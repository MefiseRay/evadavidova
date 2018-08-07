<?php  
class ControllerExtensionModuleSmenu extends Controller {
	public function index($setting) {
		static $module = 0;	
		
		$this->language->load('extension/module/smenu'); 

		if(isset($setting['heading_title'][$this->config->get('config_language_id')])){
            $data['heading_title'] = $setting['heading_title'][$this->config->get('config_language_id')];
        }else{
            $data['heading_title'] = '';
        }
        
        $data['position'] = $setting['position'];
        
        if (isset($this->session->data['payment_address']['city'])) {
            $data['city'] = $this->session->data['shipping_address']['city'];
        } else {
            $data['city'] = 'Москва';
        }

		$data['telephone'] = $this->config->get('config_telephone');
		
		$this->load->model('catalog/smenu');

		$data['smenus'] = array();
		$root_items = $this->model_catalog_smenu->getSmenu($setting['smenu_id']);
		$routs=array(0 =>"/",1=>"information/contact", 2=>"account/return/add", 3=>"information/sitemap", 4=>"product/manufacturer", 5=>"account/voucher", 6=>"affiliate/account", 7=>"product/special", 8=>"account/account", 9=>"account/order", 10=>"account/wishlist", 11=>"account/newsletter", 12=>"account/newsletter");
		$path=array(1=>'information/information', 2=>'product/category', 3 =>'catalog/product', 4=>'information/sigallery',0=>'');
		$path_url=array(1=>'information_id', 2=>'path', 3=>'product_id', 4=>'path_gallery',0=>'');
		foreach ($root_items as $items) {
			$children_data=false;
			$childs = $this->model_catalog_smenu->getSmenu($items['smenu_id'], $items['smenu_item_id']);
			$active = 0;


			if ($items['type']==5) {
				$url=$items['type_name'];
			}
			elseif (($items['type']==6) AND ($items['type_id']!=0)) {
				$url=$this->url->link($routs[(int)$items['type_id']],"", 'SSL');
				if (isset($this->request->get['route']))
				{
					$active = ($this->request->get['route'] == $routs[(int)$items['type_id']])?'active':'';
				}
			}
			elseif (($items['type']==6) AND ($items['type_id']==0)) {
				$url="/";
				$active = (!$this->request->get)?1:0;
			}
			else {
				$url=$this->url->link($path[(int)$items['type']], $path_url[(int)$items['type']]."=".$items['type_id'], 'SSL');
				if ((isset($this->request->get['route']))AND($this->request->get['route']==$path[(int)$items['type']]) AND (isset($this->request->get[$path_url[(int)$items['type']]])) AND ($this->request->get[$path_url[(int)$items['type']]]==(int)$items['type_id']))
					$active = 1;
			}

				foreach ($childs as $child) {
                    $children_data2=false;
                    $childs2 = $this->model_catalog_smenu->getSmenu($child['smenu_id'], $child['smenu_item_id']);
                    
                    
					if ($child['type']==5) {
						$url=$items['type_name'];
					}
					if ($child['type']==6) {
						$url=$this->url->link($routs[(int)$child['type']],"", 'SSL');
					}
					else {
						$url=$this->url->link($path[(int)$child['type']], $path_url[(int)$child['type']]."=".$child['type_id'], 'SSL');
					}
                    
                    foreach ($childs2 as $child2) {
                        
                        if ($child2['type']==5) {
                            $url=$items['type_name'];
                        }
                        if ($child2['type']==6) {
                            $url=$this->url->link($routs[(int)$child2['type']],"", 'SSL');
                        }
                        else {
                            $url=$this->url->link($path[(int)$child2['type']], $path_url[(int)$child2['type']]."=".$child2['type_id'], 'SSL');
                        }
                        
                        $children_data2[] = array(
                            'item_id'  => $child2['smenu_item_id'],
                            'href'     => $url,
                            'name'     => html_entity_decode($child2['smenu_text'], ENT_QUOTES, 'UTF-8'),
                            'title'    => $child2['smenu_title']
                        );
                        
                    }
                    
                    
					$children_data[] = array(
						'item_id'  => $child['smenu_item_id'],
						'href'     => $url,
						'name'     => html_entity_decode($child['smenu_text'], ENT_QUOTES, 'UTF-8'),
						'title'    => $child['smenu_title'],
                        'children' => $children_data2
					);
				}
	

			$data['items'][] = array(
				'item_id'        => $items['smenu_item_id'],
				'name'           => html_entity_decode($items['smenu_text'], ENT_QUOTES, 'UTF-8'),
				'title'          => $items['smenu_title'],
				'href'           => $url,
				'active'         => $active,
				'children'       => $children_data
			);
		}
        
        return $this->load->view('extension/module/smenu', $data);
				
	}
	
	
}
?>
