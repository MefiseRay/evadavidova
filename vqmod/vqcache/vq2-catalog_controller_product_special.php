<?php
class ControllerProductSpecial extends Controller {
	public function index() {

      // << Related Options / Связанные опции  
			$this->load->language('module/related_options');
			$data['text_ro_clear_options'] 			= $this->language->get('text_ro_clear_options');
			// >> Related Options / Связанные опции 
      
		$this->load->language('product/category');
		

      // << Related Options / Связанные опции  
			$this->load->language('module/related_options');
			$data['text_ro_clear_options'] 			= $this->language->get('text_ro_clear_options');
			// >> Related Options / Связанные опции 
      
		$this->load->language('product/special');


      // Product Option Image PRO module <<
      if ( !$this->model_module_product_option_image_pro ) {
				$this->load->model('module/product_option_image_pro');
			}
      $data['poip_installed'] = $this->model_module_product_option_image_pro->installed();
      $data['current_class'] = str_replace("Controller", "", get_class($this));
			$data['poip_theme_name'] = $this->model_module_product_option_image_pro->getThemeName();
			$data['poip_cosyone_rollover_effect'] = $this->config->get('cosyone_rollover_effect');
			
      // >> Product Option Image PRO module
      
		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			//$sort = 'p.sort_order';
            $sort = 'p.viewed';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			//$order = 'ASC';
            $order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$url = '';

				if( $this->rgetMFP($this->config->get('mfilter_url_param')?$this->config->get('mfilter_url_param'):'mfp') ) {
					$url .= '&'.($this->config->get('mfilter_url_param')?$this->config->get('mfilter_url_param'):'mfp').'=' . urlencode( $this->rgetMFP($this->config->get('mfilter_url_param')?$this->config->get('mfilter_url_param'):'mfp') );
				}
			

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('product/special', $url)
		);
        
        $this->document->addScript('/catalog/view/javascript/jquery/formstyler/jquery.formstyler.min.js');
        $this->document->addStyle('/catalog/view/javascript/jquery/formstyler/jquery.formstyler.css');
        $this->document->addStyle('/catalog/view/javascript/jquery/formstyler/jquery.formstyler.theme.css');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_quantity'] = $this->language->get('text_quantity');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_model'] = $this->language->get('text_model');
		$data['text_price'] = $this->language->get('text_price');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_points'] = $this->language->get('text_points');
		$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		$data['text_sort'] = $this->language->get('text_sort');
		$data['text_limit'] = $this->language->get('text_limit');
		$data['text_view'] = $this->language->get('text_view');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['button_list'] = $this->language->get('button_list');
		$data['button_grid'] = $this->language->get('button_grid');
		$data['button_continue'] = $this->language->get('button_continue');

		$data['compare'] = $this->url->link('product/compare');


				// << Related Options
				if ( !$this->model_module_related_options ) {
					$this->load->model('module/related_options');
				}
				// >> Related Options
			
		$data['products'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		);


				if( isset( $this->request->get['category_id'] ) ) {
					$filter_data['filter_category_id'] = (int) $this->request->get['category_id'];
				}
			

				$filter_data['mfp_overwrite_path'] = true;
			
		$product_total = $this->model_catalog_product->getTotalProductSpecials();

		$results = $this->model_catalog_product->getProductSpecials($filter_data);

		foreach ($results as $result) {
			if ($result['image']) {

				// << Product Option Image PRO module
				if (!empty($swapImg)) {
					$poip_product_image = $result['image'];
					if ( $poip_product_image == $swapImg && count($images) > 1 && !empty($images[1]['image']) ) {
						$swapImg = $images[1]['image'];
					}
				}
				// >> Product Option Image PRO module
			
				$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
			}

			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$price = false;
			}

			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$special = false;
			}

			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
			} else {
				$tax = false;
			}

			if ($this->config->get('config_review_status')) {
				$rating = (int)$result['rating'];
			} else {
				$rating = false;
			}


				$fmSettings = $this->config->get('mega_filter_settings');
				
				if( ! empty( $fmSettings['not_remember_filter_for_products'] ) && false !== ( $mfpPos = strpos( $url, '&'.($this->config->get('mfilter_url_param')?$this->config->get('mfilter_url_param'):'mfp').'=' ) ) ) {
					$mfUrlBeforeChange = $url;
					$mfSt = mb_strpos( $url, '&', $mfpPos+1, 'utf-8');
					$url = $mfSt === false ? '' : mb_substr($url, $mfSt, mb_strlen( $url, 'utf-8' ), 'utf-8');
				}
			
			$data['products'][] = array(

      // Product Option Image PRO module <<
      'option_images'  => $this->model_module_product_option_image_pro->getCategoryImagesForController( isset($result['product_id']) ? $result['product_id'] : (isset($product_info['product_id'])?$product_info['product_id']:0),
        (isset($data['current_class']) && $data['current_class']!= 'ProductCategory' && isset($setting))?($setting):(false)  ),
      // >> Product Option Image PRO module
      
				'product_id'  => $result['product_id'],

				// << Related Options
				'ro_settings' 	=> $this->config->get('related_options'),
				// model should be already loaded by model_catalog_product->getProducts or directly in the upper code
				'ro_data' 			=> $this->model_module_related_options ? $this->model_module_related_options->getRODataForProductList($result['product_id']) : '', 
				'ro_theme_name' => $this->model_module_related_options ? $this->model_module_related_options->getThemeName() : '',
				'ros_to_select' => $this->model_module_related_options ? $this->model_module_related_options->getROCombSelectedByDefault($result['product_id']) : '',
				// >> Related Options
			
				'thumb'       => $image,
				'name'        => $result['name'],
				'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
				'price'       => $price,
				'special'     => $special,
				'tax'         => $tax,
				'minimum'     => ($result['minimum'] > 0) ? $result['minimum'] : 1,
				'rating'      => $rating,
				'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'] . $url)
			);
		}

		$url = '';

				if( $this->rgetMFP($this->config->get('mfilter_url_param')?$this->config->get('mfilter_url_param'):'mfp') ) {
					$url .= '&'.($this->config->get('mfilter_url_param')?$this->config->get('mfilter_url_param'):'mfp').'=' . urlencode( $this->rgetMFP($this->config->get('mfilter_url_param')?$this->config->get('mfilter_url_param'):'mfp') );
				}
			

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$data['sorts'] = array();
/*
		$data['sorts'][] = array(
			'text'  => $this->language->get('text_default'),
			'value' => 'p.sort_order-ASC',
			'href'  => $this->url->link('product/special', 'sort=p.sort_order&order=ASC' . $url)
		);
*/
        
        $data['sorts'][] = array(
            'text'  => $this->language->get('text_viewed_desc'),
            'value' => 'p.viewed-DESC',
            'href'  => $this->url->link('product/special', 'sort=p.viewed&order=DESC' . $url)
        );
        
		$data['sorts'][] = array(
			'text'  => $this->language->get('text_price_asc'),
			'value' => 'ps.price-ASC',
			'href'  => $this->url->link('product/special', 'sort=ps.price&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_price_desc'),
			'value' => 'ps.price-DESC',
			'href'  => $this->url->link('product/special', 'sort=ps.price&order=DESC' . $url)
		);

		if ($this->config->get('config_review_status')) {
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_desc'),
				'value' => 'rating-DESC',
				'href'  => $this->url->link('product/special', 'sort=rating&order=DESC' . $url)
			);
		}
        
        $data['views'] = array();
            
        $data['views'][] = array(
            'text'  => '2',
			'value' => 'two',
		);
            
        $data['views'][] = array(
            'text'  => '3',
            'value' => 'three',
		);
            
        $data['views'][] = array(
            'text'  => '4',
            'value' => 'four',
		);  

		$url = '';

				if( $this->rgetMFP($this->config->get('mfilter_url_param')?$this->config->get('mfilter_url_param'):'mfp') ) {
					$url .= '&'.($this->config->get('mfilter_url_param')?$this->config->get('mfilter_url_param'):'mfp').'=' . urlencode( $this->rgetMFP($this->config->get('mfilter_url_param')?$this->config->get('mfilter_url_param'):'mfp') );
				}
			

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['limits'] = array();

		$limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

		sort($limits);

		foreach($limits as $value) {
			$data['limits'][] = array(
				'text'  => $value,
				'value' => $value,
				'href'  => $this->url->link('product/special', $url . '&limit=' . $value)
			);
		}

		$url = '';

				if( $this->rgetMFP($this->config->get('mfilter_url_param')?$this->config->get('mfilter_url_param'):'mfp') ) {
					$url .= '&'.($this->config->get('mfilter_url_param')?$this->config->get('mfilter_url_param'):'mfp').'=' . urlencode( $this->rgetMFP($this->config->get('mfilter_url_param')?$this->config->get('mfilter_url_param'):'mfp') );
				}
			

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('product/special', $url . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

		// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
		if ($page == 1) {
		    $this->document->addLink($this->url->link('product/special', '', true), 'canonical');
		} elseif ($page == 2) {
		    $this->document->addLink($this->url->link('product/special', '', true), 'prev');
		} else {
		    $this->document->addLink($this->url->link('product/special', 'page='. ($page - 1), true), 'prev');
		}

		if ($limit && ceil($product_total / $limit) > $page) {
		    $this->document->addLink($this->url->link('product/special', 'page='. ($page + 1), true), 'next');
		}

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;
		
		$data['total'] = $this->theme_options->numberOf($product_total, 'товар', array('', 'а', 'ов'));

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


				$this->load->model( 'module/mega_filter' );
				
				$data = $this->model_module_mega_filter->prepareData( $data );
			
		$this->response->setOutput($this->load->view('product/special', $data));
	}
}
