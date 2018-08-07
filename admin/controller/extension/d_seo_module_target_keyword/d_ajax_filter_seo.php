<?php
class ControllerExtensionDSEOModuleTargetKeywordDAjaxFilterSEO extends Controller {
	private $codename = 'd_ajax_filter_seo';
	private $route = 'extension/d_seo_module_target_keyword/d_ajax_filter_seo';
	private $config_file = 'd_ajax_filter_seo';
	private $error = array();
	
	/*
	*	Functions for SEO Module Target Keyword.
	*/	
	public function edit_target_element($target_element_data) {
		$this->load->model($this->route);
		
		return $this->{'model_extension_d_seo_module_target_keyword_' . $this->codename}->editTargetElement($target_element_data);
	}
	
	public function target_elements() {	
		$this->load->model($this->route);
		
		return $this->{'model_extension_d_seo_module_target_keyword_' . $this->codename}->getTargetElements();
	}
	
	public function store_target_elements_links($store_target_elements) {	
		$url_token = '';
		
		if (isset($this->session->data['token'])) {
			$url_token .= 'token=' . $this->session->data['token'];
		}
		
		if (isset($this->session->data['user_token'])) {
			$url_token .= 'user_token=' . $this->session->data['user_token'];
		}
		
		foreach ($store_target_elements as $store_id => $target_elements) {
			foreach ($target_elements as $target_element_key => $target_element) {
				if (strpos($target_element['route'], 'af_query_id') === 0) {
					$route_arr = explode("af_query_id=", $target_element['route']);
				
					if (isset($route_arr[1])) {
						$query_id = $route_arr[1];
						$store_target_elements[$store_id][$target_element_key]['link'] = $this->url->link('extension/d_ajax_filter_seo/query/edit', $url_token . '&query_id=' . $query_id, true);
					}
				}
			}
		}
		
		return $store_target_elements;
	}
}
