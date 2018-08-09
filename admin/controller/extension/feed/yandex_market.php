<?php

class ControllerExtensionFeedYandexMarket extends Controller
{

    public $fields_market = array(
        'yandex_market_available',
        'yandex_market_additional_images',
        'yandex_market_delivery_common',
        'yandex_market_delivery_individual',
        'yandex_market_combination',
        'yandex_market_features',
        'yandex_market_dimensions',
        'yandex_market_allcurrencies',
        'yandex_market_store',
        'yandex_market_delivery',
        'yandex_market_pickup',
        'yandex_market_manufacturer_warranty'
    );
    private $error = array();

    public function index()
    {
        $this->load->language('extension/feed/yandex_market');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            if (isset($this->request->post['yandex_market_categories'])) {
                $this->request->post['yandex_market_categories'] = implode(',', $this->request->post['yandex_market_categories']);
            }

            $this->model_setting_setting->editSetting('yandex_market', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_select_all'] = $this->language->get('text_select_all');
        $data['text_unselect_all'] = $this->language->get('text_unselect_all');
        $data['text_show_all'] = $this->language->get('text_show_all');
        $data['text_hide_all'] = $this->language->get('text_hide_all');
        $data['text_none'] = $this->language->get('text_none');

        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_category'] = $this->language->get('tab_category');
        $data['tab_delivery'] = $this->language->get('tab_delivery');
        $data['tab_delivery_product'] = $this->language->get('tab_delivery_product');

        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_yml'] = $this->language->get('entry_yml');
        $data['entry_data_feed'] = $this->language->get('entry_data_feed');
        $data['entry_shopname'] = $this->language->get('entry_shopname');
        $data['entry_company'] = $this->language->get('entry_company');
        $data['entry_vendor'] = $this->language->get('entry_vendor');
        $data['entry_model'] = $this->language->get('entry_model');
        $data['entry_sales_notes'] = $this->language->get('entry_sales_notes');
        $data['entry_category'] = $this->language->get('entry_category');
        $data['entry_country_of_origin'] = $this->language->get('entry_country_of_origin');
        $data['entry_color_option'] = $this->language->get('entry_color_option');
        $data['entry_size_option'] = $this->language->get('entry_size_option');
        $data['entry_currency'] = $this->language->get('entry_currency');
        $data['entry_in_stock'] = $this->language->get('entry_in_stock');
        $data['entry_out_of_stock'] = $this->language->get('entry_out_of_stock');
        $data['entry_settings'] = $this->language->get('entry_settings');
        $data['entry_available'] = $this->language->get('entry_available');
        $data['entry_additional_images'] = $this->language->get('entry_additional_images');
        $data['entry_delivery_common'] = $this->language->get('entry_delivery_common');
        $data['entry_delivery_individual'] = $this->language->get('entry_delivery_individual');
        $data['entry_combination'] = $this->language->get('entry_combination');
        $data['entry_features'] = $this->language->get('entry_features');
        $data['entry_dimensions'] = $this->language->get('entry_dimensions');
        $data['entry_allcurrencies'] = $this->language->get('entry_allcurrencies');
        $data['entry_store'] = $this->language->get('entry_store');
        $data['entry_yandex_market_category'] = $this->language->get('entry_yandex_market_category');
        $data['entry_delivery'] = $this->language->get('entry_delivery');
        $data['entry_pickup'] = $this->language->get('entry_pickup');
        $data['entry_manufacturer_warranty'] = $this->language->get('entry_manufacturer_warranty');
        $data['entry_price'] = $this->language->get('entry_price');
        $data['entry_price_from'] = $this->language->get('entry_price_from');
        $data['entry_cost'] = $this->language->get('entry_cost');
        $data['entry_days'] = $this->language->get('entry_days');
        $data['entry_order_before'] = $this->language->get('entry_order_before');
        $data['entry_priority'] = $this->language->get('entry_priority');

        $data['help_shopname'] = $this->language->get('help_shopname');
        $data['help_company'] = $this->language->get('help_company');
        $data['help_vendor'] = $this->language->get('help_vendor');
        $data['help_model'] = $this->language->get('help_model');
        $data['help_category'] = $this->language->get('help_category');
        $data['help_currency'] = $this->language->get('help_currency');
        $data['help_in_stock'] = $this->language->get('help_in_stock');
        $data['help_out_of_stock'] = $this->language->get('help_out_of_stock');
        $data['help_yandex_market'] = $this->language->get('help_yandex_market');
        $data['help_size_unit'] = $this->language->get('help_size_unit');
        $data['help_sales_notes'] = $this->language->get('help_sales_notes');
        $data['help_yandex_market_category'] = $this->language->get('help_yandex_market_category');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_delivery_add'] = $this->language->get('button_delivery_add');
        $data['button_remove'] = $this->language->get('button_remove');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'text' => $this->language->get('text_home'),
            'separator' => FALSE
        );

        $data['breadcrumbs'][] = array(
            'href' => $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'),
            'text' => $this->language->get('text_feed'),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'href' => $this->url->link('extension/feed/yml', 'token=' . $this->session->data['token'], 'SSL'),
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link('extension/feed/yandex_market', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['yandex_market_status'])) {
            $data['yandex_market_status'] = $this->request->post['yandex_market_status'];
        } else {
            $data['yandex_market_status'] = $this->config->get('yandex_market_status');
        }

        if (isset($this->request->post['yandex_market_simple'])) {
            $data['yandex_market_simple'] = $this->request->post['yandex_market_simple'];
        } else {
            $data['yandex_market_simple'] = $this->config->get('yandex_market_simple');
        }

        $data['data_feed'] = HTTP_CATALOG . 'index.php?route=feed/yandex_market';

        if (isset($this->request->post['yandex_market_shopname'])) {
            $data['yandex_market_shopname'] = $this->request->post['yandex_market_shopname'];
        } else {
            $data['yandex_market_shopname'] = $this->config->get('yandex_market_shopname');
        }

        if (isset($this->request->post['yandex_market_company'])) {
            $data['yandex_market_company'] = $this->request->post['yandex_market_company'];
        } else {
            $data['yandex_market_company'] = $this->config->get('yandex_market_company');
        }

        if (isset($this->request->post['yandex_market_vendor'])) {
            $data['yandex_market_vendor'] = $this->request->post['yandex_market_vendor'];
        } else {
            $data['yandex_market_vendor'] = $this->config->get('yandex_market_vendor');
        }

        if (isset($this->request->post['yandex_market_sales_notes'])) {
            $data['yandex_market_sales_notes'] = $this->request->post['yandex_market_sales_notes'];
        } else {
            $data['yandex_market_sales_notes'] = $this->config->get('yandex_market_sales_notes');
        }

        if (isset($this->request->post['yandex_market_model'])) {
            $data['yandex_market_model'] = $this->request->post['yandex_market_model'];
        } else {
            $data['yandex_market_model'] = $this->config->get('yandex_market_model');
        }

        if (isset($this->request->post['yandex_market_country_of_origin'])) {
            $data['yandex_market_country_of_origin'] = $this->request->post['yandex_market_country_of_origin'];
        } elseif ($this->config->get('yandex_market_country_of_origin')) {
            $data['yandex_market_country_of_origin'] = $this->config->get('yandex_market_country_of_origin');
        } else {
            $data['yandex_market_country_of_origin'] = 0;
        }

        if (isset($this->request->post['yandex_market_currency'])) {
            $data['yandex_market_currency'] = $this->request->post['yandex_market_currency'];
        } else {
            $data['yandex_market_currency'] = $this->config->get('yandex_market_currency');
        }

        if (isset($this->request->post['yandex_market_in_stock'])) {
            $data['yandex_market_in_stock'] = $this->request->post['yandex_market_in_stock'];
        } elseif ($this->config->get('yandex_market_in_stock')) {
            $data['yandex_market_in_stock'] = $this->config->get('yandex_market_in_stock');
        } else {
            $data['yandex_market_in_stock'] = 7;
        }

        if (isset($this->request->post['yandex_market_out_of_stock'])) {
            $data['yandex_market_out_of_stock'] = $this->request->post['yandex_market_out_of_stock'];
        } elseif ($this->config->get('yandex_market_in_stock')) {
            $data['yandex_market_out_of_stock'] = $this->config->get('yandex_market_out_of_stock');
        } else {
            $data['yandex_market_out_of_stock'] = 5;
        }

        $array_init = array_merge($this->fields_market);

        foreach ($array_init as $ya_field) {
            if (isset($this->request->post[$ya_field])) {
                $data[$ya_field] = $this->request->post[$ya_field];
            } elseif ($this->config->get($ya_field)) {
                $data[$ya_field] = $this->config->get($ya_field);
            } else {
                $data[$ya_field] = 0;
            }
        }

        $this->load->model('localisation/stock_status');

        $data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

        $this->load->model('catalog/option');

        $results = $this->model_catalog_option->getOptions(array('sort' => 'name'));
        $data['options'] = $results;

        $data['yandex_market_size_options'] = array();

        if ($this->config->get('yandex_market_size_options')) {
            $data['yandex_market_size_options'] = $this->config->get('yandex_market_size_options');
        }

        $data['yandex_market_color_options'] = array();

        if ($this->config->get('yandex_market_color_options')) {
            $data['yandex_market_color_options'] = $this->config->get('yandex_market_color_options');
        }

        // Attributes
        $this->load->model('catalog/attribute');

        $data['attributes'] = array();

        $results = $this->model_catalog_attribute->getAttributes();
        if ($results) {
            foreach ($results as $result) {
                $data['attributes'][] = array(
                    'attribute_id' => $result['attribute_id'],
                    'name' => $result['name']
                );
            }
        }

        $this->load->model('catalog/category');

        if (isset($this->request->post['yandex_market_category_default'])) {
            $data['yandex_market_category_default'] = $this->request->post['yandex_market_category_default'];
        } else {
            $data['yandex_market_category_default'] = $this->config->get('yandex_market_category_default');
        }

        $filter_data = array(
            'sort' => 'name',
            'order' => 'ASC'
        );

        $data['categories'] = $this->model_catalog_category->getCategories($filter_data);

        if (isset($this->request->post['yandex_market_category'])) {
            $yandex_market_category_options = $this->request->post['yandex_market_category'];
        } elseif ($this->config->get('yandex_market_category')) {
            $yandex_market_category_options = $this->config->get('yandex_market_category');
        } else {
            $yandex_market_category_options = array();
        }

        $data['yandex_market_category_options'] = array();

        foreach ($yandex_market_category_options as $yandex_market_category) {
            $data['yandex_market_category_options'][] = array(
                'category_id' => $yandex_market_category['category_id'],
                'category_name' => $yandex_market_category['category_name'],
            );
        }

        $data['market_cat_tree'] = $this->treeCat(0);

        if (isset($this->request->post['yandex_market_categories'])) {
            $data['yandex_market_categories'] = $this->request->post['yandex_market_categories'];
        } elseif ($this->config->get('yandex_market_categories') != '') {
            $data['yandex_market_categories'] = explode(',', $this->config->get('yandex_market_categories'));
        } else {
            $data['yandex_market_categories'] = array();
        }

        if (isset($this->request->post['yandex_market_delivery_option'])) {
            $delivery_options = $this->request->post['yandex_market_delivery_option'];
        } elseif ($this->config->get('yandex_market_delivery_option')) {
            $delivery_options = $this->config->get('yandex_market_delivery_option');
        } else {
            $delivery_options = array();
        }

        foreach ($delivery_options as $delivery_option) {
            $data['yandex_market_delivery_options'][] = array(
                'cost' => $delivery_option['cost'],
                'days' => $delivery_option['days'],
                'order_before' => $delivery_option['order_before']
            );
        }

        if (isset($this->request->post['yandex_market_delivery_product'])) {
            $delivery_products = $this->request->post['yandex_market_delivery_product'];
        } elseif ($this->config->get('yandex_market_delivery_product')) {
            $delivery_products = $this->config->get('yandex_market_delivery_product');
        } else {
            $delivery_products = array();
        }

        $data['yandex_market_delivery_products'] = array();

        if (count($delivery_products)) {
            foreach ($delivery_products as $delivery_product) {
                $data['yandex_market_delivery_products'][] = array(
                    'category' => $delivery_product['category'],
                    'price_from' => $delivery_product['price_from'],
                    'cost' => $delivery_product['cost'],
                    'days' => $delivery_product['days'],
                    'order_before' => $delivery_product['order_before'],
                    'priority' => $delivery_product['priority'],
                );
                $sort_priority[] = $delivery_product['priority'];
                $sort_price[] = $delivery_product['price_from'];
            }

            array_multisort($sort_priority, SORT_ASC, $sort_price, SORT_ASC, $data['yandex_market_delivery_products']);
        }

        $this->load->model('localisation/currency');
        $currencies = $this->model_localisation_currency->getCurrencies();
        $allowed_currencies = array_flip(array('RUR', 'RUB', 'BYR', 'KZT', 'UAH'));
        $data['currencies'] = array_intersect_key($currencies, $allowed_currencies);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/feed/yandex_market', $data));
    }

    private function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/feed/yandex_market')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function treeCat($id_cat = 0)
    {
        $html = '';
        $categories = $this->getCategories($id_cat);
        foreach ($categories as $category) {
            $children = $this->getCategories($category['category_id']);
            if (count($children)) {
                $html .= $this->treeFolder($category['category_id'], $category['name']);
            } else {
                $html .= $this->treeItem($category['category_id'], $category['name']);
            }
        }
        return $html;
    }

    public function getCategories($parent_id = 0)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");

        return $query->rows;
    }

    public function treeFolder($id, $name)
    {
        $html = '<li class="tree-folder">
					<span class="tree-folder-name">
						<input type="checkbox" name="yandex_market_categories[]" value="' . $id . '">
						<i class="icon-folder-open"></i>
						<label class="tree-toggler">' . $name . '</label>
					</span>
					<ul class="tree" style="display: none;">' . $this->treeCat($id) . '</ul>
				</li>';
        return $html;
    }

    public function treeItem($id, $name)
    {
        $html = '<li class="tree-item">
						<span class="tree-item-name">
							<input type="checkbox" name="yandex_market_categories[]" value="' . $id . '">
							<i class="tree-dot"></i>
							<label class="">' . $name . '</label>
						</span>
					</li>';
        return $html;
    }
}

?>
