<?php

class ControllerExtensionFeedYandexSitemap extends Controller
{
    public $fields_xml = array(
        'yandex_sitemap_category_priority',
        'yandex_sitemap_product_priority',
        'yandex_sitemap_manufacturer_priority',
        'yandex_sitemap_information_priority'
    );
    private $error = array();

    public function index()
    {
        $this->load->language('extension/feed/yandex_sitemap');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('yandex_sitemap', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_data_feed'] = $this->language->get('entry_data_feed');
        $data['entry_category_priority'] = $this->language->get('entry_category_priority');
        $data['entry_product_priority'] = $this->language->get('entry_product_priority');
        $data['entry_manufacturer_priority'] = $this->language->get('entry_manufacturer_priority');
        $data['entry_information_priority'] = $this->language->get('entry_information_priority');
        $data['entry_settings'] = $this->language->get('entry_settings');
        $data['entry_homepage'] = $this->language->get('entry_homepage');
        $data['entry_contacts'] = $this->language->get('entry_contacts');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['tab_general'] = $this->language->get('tab_general');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_feed'),
            'href' => $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/feed/yandex_sitemap', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['action'] = $this->url->link('extension/feed/yandex_sitemap', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['yandex_sitemap_status'])) {
            $data['yandex_sitemap_status'] = $this->request->post['yandex_sitemap_status'];
        } else {
            $data['yandex_sitemap_status'] = $this->config->get('yandex_sitemap_status');
        }

        $array_init = array_merge($this->fields_xml);

        foreach ($array_init as $xml_field) {
            if (isset($this->request->post[$xml_field])) {
                $data[$xml_field] = $this->request->post[$xml_field];
            } else {
                $data[$xml_field] = $this->config->get($xml_field);
            }
        }

        if (isset($this->request->post['yandex_sitemap_homepage'])) {
            $data['yandex_sitemap_homepage'] = $this->request->post['yandex_sitemap_homepage'];
        } elseif ($this->config->get('yandex_sitemap_homepage')) {
            $data['yandex_sitemap_homepage'] = $this->config->get('yandex_sitemap_homepage');
        } else {
            $data['yandex_sitemap_homepage'] = 0;
        }

        if (isset($this->request->post['yandex_sitemap_contacts'])) {
            $data['yandex_sitemap_contacts'] = $this->request->post['yandex_sitemap_contacts'];
        } elseif ($this->config->get('yandex_sitemap_contacts')) {
            $data['yandex_sitemap_contacts'] = $this->config->get('yandex_sitemap_contacts');
        } else {
            $data['yandex_sitemap_contacts'] = 0;
        }

        $data['data_feed'] = HTTP_CATALOG . 'index.php?route=feed/yandex_sitemap';

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/feed/yandex_sitemap', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/feed/yandex_sitemap')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}
