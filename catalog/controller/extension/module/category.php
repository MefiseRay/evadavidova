<?php
class ControllerExtensionModuleCategory extends Controller {
	public function index() {
		$this->load->language('extension/module/category');

		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[1])) {
			$data['category_id'] = $parts[1];
		} else {
			$data['category_id'] = 0;
		}
        
		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}
        
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();
		
		$data['pages_top'][] = array(
			'name'        => 'Новинки',
			'active'	  => ($this->request->get['route'] == 'product/latest' ? true : false),
			'href'        => $this->url->link('product/latest', '', 'SSL')
		);

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			$children_data = array();

            $children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach($children as $child) {
					$filter_data = array('filter_category_id' => $child['category_id'], 'filter_sub_category' => true);

					$data['categories'][] = array(
						'category_id' => $child['category_id'],
						'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}

		}
		
		
		$data['pages_bottom'][] = array(
			'name'        => 'Sale',
			'active'	  => ($this->request->get['route'] == 'product/special' ? true : false),
			'href'        => $this->url->link('product/special', '', 'SSL')
		);

		return $this->load->view('extension/module/category', $data);
	}
}
