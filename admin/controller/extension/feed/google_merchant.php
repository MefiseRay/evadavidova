<?php

class ControllerExtensionFeedGoogleMerchant extends Controller
{

    public $fields_market = array(
        'google_merchant_available',
        'google_merchant_additional_images',
        'google_merchant_combination',
        'google_merchant_features',
        'google_merchant_dimensions',
        'google_merchant_allcurrencies',
        'google_merchant_store',
        'google_merchant_delivery',
        'google_merchant_pickup',
    );
    private $error = array();

    public function index()
    {
        $this->load->language('extension/feed/google_merchant');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            if (isset($this->request->post['google_merchant_categories'])) {
                $this->request->post['google_merchant_categories'] = implode(',', $this->request->post['google_merchant_categories']);
            }

            $this->model_setting_setting->editSetting('google_merchant', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/feed/google_merchant', 'token=' . $this->session->data['token'], 'SSL'));
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
        $data['tab_delivery'] = $this->language->get('tab_delivery');
        $data['tab_delivery_product'] = $this->language->get('tab_delivery_product');

        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_yml'] = $this->language->get('entry_yml');
        $data['entry_data_feed'] = $this->language->get('entry_data_feed');
        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_description'] = $this->language->get('entry_description');
        $data['entry_brand'] = $this->language->get('entry_brand');
        $data['entry_google_product_category'] = $this->language->get('entry_google_product_category');
        $data['entry_category'] = $this->language->get('entry_category');
        $data['entry_color_option'] = $this->language->get('entry_color_option');
        $data['entry_size_option'] = $this->language->get('entry_size_option');
        $data['entry_material_option'] = $this->language->get('entry_material_option');
        $data['entry_color'] = $this->language->get('entry_color');
        $data['entry_material'] = $this->language->get('entry_material');
        $data['entry_currency'] = $this->language->get('entry_currency');
        $data['entry_in_stock'] = $this->language->get('entry_in_stock');
        $data['entry_out_of_stock'] = $this->language->get('entry_out_of_stock');
        $data['entry_condition'] = $this->language->get('entry_condition');
        $data['entry_condition_new'] = $this->language->get('entry_condition_new');
        $data['entry_condition_used'] = $this->language->get('entry_condition_used');
        $data['entry_condition_refurbished'] = $this->language->get('entry_condition_refurbished');
        $data['entry_settings'] = $this->language->get('entry_settings');
        $data['entry_available'] = $this->language->get('entry_available');
        $data['entry_additional_images'] = $this->language->get('entry_additional_images');
        $data['entry_combination'] = $this->language->get('entry_combination');
        $data['entry_features'] = $this->language->get('entry_features');
        $data['entry_dimensions'] = $this->language->get('entry_dimensions');
        $data['entry_allcurrencies'] = $this->language->get('entry_allcurrencies');
        $data['entry_store'] = $this->language->get('entry_store');
        $data['entry_delivery'] = $this->language->get('entry_delivery');
        $data['entry_pickup'] = $this->language->get('entry_pickup');
        $data['entry_price'] = $this->language->get('entry_price');
        $data['entry_price_from'] = $this->language->get('entry_price_from');
        $data['entry_cost'] = $this->language->get('entry_cost');
        $data['entry_service'] = $this->language->get('entry_service');
        $data['entry_priority'] = $this->language->get('entry_priority');

        $data['help_brand'] = $this->language->get('help_brand');
        $data['help_google_product_category'] = $this->language->get('help_google_product_category');
        $data['help_category'] = $this->language->get('help_category');
        $data['help_in_stock'] = $this->language->get('help_in_stock');
        $data['help_out_of_stock'] = $this->language->get('help_out_of_stock');
        $data['help_condition'] = $this->language->get('help_condition');
        $data['help_size_unit'] = $this->language->get('help_size_unit');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_delivery_add'] = $this->language->get('button_delivery_add');
        $data['button_remove'] = $this->language->get('button_remove');

        $data['token'] = $this->session->data['token'];

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

        $data['action'] = $this->url->link('extension/feed/google_merchant', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['google_merchant_status'])) {
            $data['google_merchant_status'] = $this->request->post['google_merchant_status'];
        } else {
            $data['google_merchant_status'] = $this->config->get('google_merchant_status');
        }

        $data['data_feed'] = HTTP_CATALOG . 'index.php?route=extension/feed/google_merchant';

        if (isset($this->request->post['google_merchant_title'])) {
            $data['google_merchant_title'] = $this->request->post['google_merchant_title'];
        } else {
            $data['google_merchant_title'] = $this->config->get('google_merchant_title');
        }

        if (isset($this->request->post['google_merchant_description'])) {
            $data['google_merchant_description'] = $this->request->post['google_merchant_description'];
        } else {
            $data['google_merchant_description'] = $this->config->get('google_merchant_description');
        }

        if (isset($this->request->post['google_merchant_brand'])) {
            $data['google_merchant_brand'] = $this->request->post['google_merchant_brand'];
        } else {
            $data['google_merchant_brand'] = $this->config->get('google_merchant_brand');
        }

        if (isset($this->request->post['google_merchant_product_category_name'])) {
            $data['google_merchant_product_category_name'] = $this->request->post['google_merchant_product_category_name'];
        } else {
            $data['google_merchant_product_category_name'] = $this->config->get('google_merchant_product_category_name');
        }

        if (isset($this->request->post['google_merchant_product_category_id'])) {
            $data['google_merchant_product_category_id'] = $this->request->post['google_merchant_product_category_id'];
        } else {
            $data['google_merchant_product_category_id'] = $this->config->get('google_merchant_product_category_id');
        }

        if (isset($this->request->post['google_merchant_color'])) {
            $data['google_merchant_color'] = $this->request->post['google_merchant_color'];
        } elseif ($this->config->get('google_merchant_color')) {
            $data['google_merchant_color'] = $this->config->get('google_merchant_color');
        } else {
            $data['google_merchant_color'] = 0;
        }

        if (isset($this->request->post['google_merchant_material'])) {
            $data['google_merchant_material'] = $this->request->post['google_merchant_material'];
        } elseif ($this->config->get('google_merchant_material')) {
            $data['google_merchant_material'] = $this->config->get('google_merchant_material');
        } else {
            $data['google_merchant_material'] = 0;
        }

        if (isset($this->request->post['google_merchant_currency'])) {
            $data['google_merchant_currency'] = $this->request->post['google_merchant_currency'];
        } else {
            $data['google_merchant_currency'] = $this->config->get('google_merchant_currency');
        }

        if (isset($this->request->post['google_merchant_condition'])) {
            $data['google_merchant_condition'] = $this->request->post['google_merchant_condition'];
        } else {
            $data['google_merchant_condition'] = $this->config->get('google_merchant_condition');
        }

        if (isset($this->request->post['google_merchant_in_stock'])) {
            $data['google_merchant_in_stock'] = $this->request->post['google_merchant_in_stock'];
        } elseif ($this->config->get('google_merchant_in_stock')) {
            $data['google_merchant_in_stock'] = $this->config->get('google_merchant_in_stock');
        } else {
            $data['google_merchant_in_stock'] = 7;
        }

        if (isset($this->request->post['google_merchant_out_of_stock'])) {
            $data['google_merchant_out_of_stock'] = $this->request->post['google_merchant_out_of_stock'];
        } elseif ($this->config->get('google_merchant_in_stock')) {
            $data['google_merchant_out_of_stock'] = $this->config->get('google_merchant_out_of_stock');
        } else {
            $data['google_merchant_out_of_stock'] = 5;
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

        $data['google_merchant_size_options'] = array();

        if ($this->config->get('google_merchant_size_options')) {
            $data['google_merchant_size_options'] = $this->config->get('google_merchant_size_options');
        }

        $data['google_merchant_color_options'] = array();

        if ($this->config->get('google_merchant_color_options')) {
            $data['google_merchant_color_options'] = $this->config->get('google_merchant_color_options');
        }

        $this->load->model('catalog/attribute');
        $results = $this->model_catalog_attribute->getAttributes(array('sort' => 'name'));
        $data['attributes'] = $results;

        $data['google_merchant_material_options'] = array();

        if ($this->config->get('google_merchant_material_options')) {
            $data['google_merchant_material_options'] = $this->config->get('google_merchant_material_options');
        }

        $this->load->model('catalog/category');

        $data['market_cat_tree'] = $this->treeCat(0);

        if (isset($this->request->post['google_merchant_categories'])) {
            $data['google_merchant_categories'] = $this->request->post['google_merchant_categories'];
        } elseif ($this->config->get('google_merchant_categories') != '') {
            $data['google_merchant_categories'] = explode(',', $this->config->get('google_merchant_categories'));
        } else {
            $data['google_merchant_categories'] = array();
        }

        if (isset($this->request->post['google_merchant_delivery_product'])) {
            $delivery_products = $this->request->post['google_merchant_delivery_product'];
        } elseif ($this->config->get('google_merchant_delivery_product')) {
            $delivery_products = $this->config->get('google_merchant_delivery_product');
        } else {
            $delivery_products = array();
        }

        $data['google_merchant_delivery_products'] = array();

        if (count($delivery_products)) {

            foreach ($delivery_products as $delivery_product) {
                $data['google_merchant_delivery_products'][] = array(
                    'category' => $delivery_product['category'],
                    'price_from' => $delivery_product['price_from'],
                    'price' => $delivery_product['price'],
                    'service' => $delivery_product['service'],
                    'priority' => $delivery_product['priority'],
                );
                $sort_priority[] = $delivery_product['priority'];
                $sort_price[] = $delivery_product['price_from'];
            }

            array_multisort($sort_priority, SORT_ASC, $sort_price, SORT_ASC, $data['google_merchant_delivery_products']);
        }

        $this->load->model('localisation/currency');
        $currencies = $this->model_localisation_currency->getCurrencies();
        $allowed_currencies = array_flip(array('RUR', 'RUB', 'BYR', 'KZT', 'UAH'));
        $data['currencies'] = array_intersect_key($currencies, $allowed_currencies);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/feed/google_merchant', $data));
    }

    private function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/feed/google_merchant')) {
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
						<input type="checkbox" name="google_merchant_categories[]" value="' . $id . '">
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
							<input type="checkbox" name="google_merchant_categories[]" value="' . $id . '">
							<i class="tree-dot"></i>
							<label class="">' . $name . '</label>
						</span>
					</li>';
        return $html;
    }

    public function autocomplete()
    {
        $json = array();

        $results = file('https://www.google.com/basepages/producttype/taxonomy-with-ids.ru-RU.txt');

        $i = 1;

        if (isset($this->request->get['google_product_category'])) {
            foreach ($results as $result) {
                if ($i != 1) {
                    $result = preg_replace("/\s{2,}/", ' ', $result);
                    $category = explode(" - ", $result);
                    $pos = strripos($category[1], $this->request->get['google_product_category']);
                    if ($pos === false) {
                    } else {
                        $json[] = array(
                            'category_id' => $category[0],
                            'name' => strip_tags(html_entity_decode($category[1], ENT_QUOTES, 'UTF-8'))
                        );
                    }
                }
                $i++;
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}

?>
