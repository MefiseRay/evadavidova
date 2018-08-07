<?php
class ControllerCommonHeader extends Controller {
	public function index() {

      // Product Option Image PRO module <<
			
      if ( !$this->model_module_product_option_image_pro ) {
				$this->load->model('module/product_option_image_pro');
			}
      $data['poip_installed'] = $this->model_module_product_option_image_pro->installed();
			$data['poip_settings'] = $this->model_module_product_option_image_pro->getSettings();
			$data['poip_theme_name'] = $this->model_module_product_option_image_pro->getThemeName();
			$data['poip_inclide_file_name_default'] = $this->model_module_product_option_image_pro->getTemplateIncludeFileName('list', true);
			$data['poip_inclide_file_name_custom'] = $this->model_module_product_option_image_pro->getTemplateIncludeFileName('list');
			
      // >> Product Option Image PRO module
      

				if( ! isset( $this->request->request['mfp_seo_alias'] ) ) {
					$mfilterSeoConfig = $this->config->get('mega_filter_seo');

					if( ! empty( $mfilterSeoConfig['meta_robots'] ) && ! empty( $this->request->get[$this->config->get('mfilter_url_param')?$this->config->get('mfilter_url_param'):'mfp'] ) ) {
						$data['mfp_robots_value'] = $mfilterSeoConfig['meta_robots_value'];
					}
				}
			

        // start: OCdevWizard SMCM
        $this->load->model('ocdevwizard/ocdevwizard_setting');
        
        $smcm_form_data         = $this->model_ocdevwizard_ocdevwizard_setting->getSettingData('smart_contact_me_form_data');  
        $smcm_store_id          = (int)$this->config->get('config_store_id');
        $smcm_customer_group_id = ($this->customer->isLogged()) ? (int)$this->customer->getGroupId() : (int)$this->config->get('config_customer_group_id');
        $smcm_customer_groups   = isset($smcm_form_data['customer_groups']) ? $smcm_form_data['customer_groups'] : array();
        $smcm_stores            = isset($smcm_form_data['stores']) ? $smcm_form_data['stores'] : array();
        $data['smcm_form_data'] = $smcm_form_data;

        if (isset($smcm_form_data['activate']) && $smcm_form_data['activate'] && !in_array($smcm_customer_group_id, $smcm_customer_groups) && !in_array($smcm_store_id, $smcm_stores)) {
          $data['smcm_status'] = 1;
        } else {
          $data['smcm_status'] = 0;
        }
        // end: OCdevWizard SMCM
      
		// Analytics
		$this->load->model('extension/extension');

		$data['analytics'] = array();

		$analytics = $this->model_extension_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get($analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('extension/analytics/' . $analytic['code'], $this->config->get($analytic['code'] . '_status'));
			}
		}

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}

		$data['title'] = $this->document->getTitle();

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();

                require_once(DIR_SYSTEM . 'nitro/core/core.php');
                require_once(DIR_SYSTEM . 'nitro/core/cdn.php');

                $data['styles'] = nitroCDNResolve($data['styles']);
            

				// << Related Options
				if ( !$this->model_module_related_options ) {
					$this->load->model('module/related_options');
				}
				
				if ( $this->model_module_related_options->installed() ) {
					$this->document->addScript( $this->model_module_related_options->getScriptPathWithVersion('view/extension/related_options/js/liveopencart.select_option_toggle.js') );
					$this->document->addScript( $this->model_module_related_options->getScriptPathWithVersion('view/extension/related_options/js/liveopencart.related_options.js') );
				}
				// >> Related Options
			
		$data['scripts'] = $this->document->getScripts();

                require_once(DIR_SYSTEM . 'nitro/core/core.php');
                require_once(DIR_SYSTEM . 'nitro/core/cdn.php');

                $data['scripts'] = nitroCDNResolve($data['scripts']);
            
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

	$data['popupmaster_status'] = $this->config->get('popupmaster_status');
	$this->load->language('extension/module/popupmaster');
	$data['titulo'] = $this->language->get('titulo');
	$data['carrinho'] = $this->language->get('carrinho');
	$data['comprar'] = $this->language->get('comprar');
	$data['continuar'] = $this->language->get('continuar');
		

		$data['name'] = $this->config->get('config_name');

        
			$mydata = array();

			if (isset($this->session->data['export_order_id'])) {
				$this->load->model('account/order');
				$this->load->model('catalog/category');
				$this->load->model('catalog/product');
				
				$order_id = $this->session->data['export_order_id'];
				$order_data = $this->model_account_order->getOrder($order_id);
				$order_totals   = $this->model_account_order->getOrderTotals($order_id);
				$order_products = $this->model_account_order->getOrderProducts($order_id);		
				
				////////////////////////////// data for create_xml_for_1C() method ////////////////////////
				if ($order_data) {
					//order info
					date_default_timezone_set('Europe/Moscow');
					$mydata['order_id'] = $order_id;
					$mydata['date']     = date('Y-m-d');
					$mydata['time']     = date('H:i:s');
					
					//client info
					$mydata['firstname']    = $order_data['firstname'];
					$mydata['lastname']    	= $order_data['lastname'];
					$mydata['customer_id'] 	= $order_data['customer_id'];
					$mydata['telephone']   	= $order_data['telephone'];
					$mydata['email']   		= $order_data['email'];
					$mydata['address']     	= $order_data['payment_address_1'];	
					$mydata['country']     	= $order_data['payment_country'];
					$mydata['zone']     	= $order_data['payment_zone'];
					$mydata['city']     	= $order_data['payment_city'];
					
					// order info
					$mydata['total']     	= $order_data['total'];

					$mydata['products'] 		= $order_products;
				
					$this->load->controller('export1C/exportOrder/exportOrder', $mydata);
				}

				unset($this->session->data['export_order_id']);	
			}
		
      

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			
                
                    $config_logo   = $this->config->get('config_logo');
                    $logo_data     = renderLogoData($server, $config_logo, $data['name']);
                    $data          = array_merge($data, $logo_data);
                
            
		} else {
			$data['logo'] = '';

                
                    $data['logo_svg'] = false;
                
            
		}

		$this->load->language('common/header');

		//XML
		$data['quicksignup'] = $this->load->controller('common/quicksignup');
		$data['signin_or_register'] = $this->language->get('signin_or_register');
		
		
		$data['og_url'] = (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')) ? HTTPS_SERVER : HTTP_SERVER) . substr($this->request->server['REQUEST_URI'], 1, (strlen($this->request->server['REQUEST_URI'])-1));
		$data['og_image'] = $this->document->getOgImage();

		$data['text_home'] = $this->language->get('text_home');

		// Wishlist
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');
			if ($this->model_account_wishlist->getTotalWishlist()){
				$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
			}else {
				$data['text_wishlist'] = 0;
			}
		} else {
			if (isset($this->session->data['wishlist']) && count($this->session->data['wishlist'])) {
				$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
			} else {
                $this->load->model('account/wishlist');
                $results = $this->model_account_wishlist->getWishlist();
				$data['text_wishlist'] = count($results);
			}
		}
        
		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));

		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_page'] = $this->language->get('text_page');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');

		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
										
				'filter_sub_category' => true,
				'mfp_disabled' => true
			
					);

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}

				// Level 1
				$data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');

		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} elseif (isset($this->request->get['information_id'])) {
				$class = '-' . $this->request->get['information_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

		return $this->load->view('common/header', $data);
	}
}
