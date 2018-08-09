<?php

class ControllerCocDiscount extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('coc/discount');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('coc/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_coc_setting->editDiscountSetting('coc_discount', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('coc/discount', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = $this->language->get('text_edit');
        $data['text_select'] = $this->language->get('text_select');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');


        $data['entry_heading_title'] = $this->language->get('entry_heading_title');
        $data['entry_meta_title'] = $this->language->get('entry_meta_title');
        $data['entry_meta_description'] = $this->language->get('entry_meta_description');
        $data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
        $data['entry_seo_keyword'] = $this->language->get('entry_seo_keyword');
        $data['entry_quantity'] = $this->language->get('entry_quantity');
        $data['entry_status'] = $this->language->get('entry_status');

        $data['help_seo_keyword'] = $this->language->get('help_seo_keyword');
        $data['help_quantity'] = $this->language->get('help_quantity');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_data'] = $this->language->get('tab_data');


        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (stristr(HTTP_SERVER, 'localhost')) {

        } else {


        }

        if (isset($this->error['seo_keyword'])) {
            $data['error_seo_keyword'] = $this->error['seo_keyword'];
        } else {
            $data['error_seo_keyword'] = '';
        }

        if (isset($this->error['meta_title'])) {
            $data['error_meta_title'] = $this->error['meta_title'];
        } else {
            $data['error_meta_title'] = array();
        }


        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_stores'),
            'href' => $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('coc/setting', 'token=' . $this->session->data['token'], 'SSL')
        );

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['action'] = $this->url->link('coc/discount', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('common/dashborad', 'token=' . $this->session->data['token'], 'SSL');

        $data['token'] = $this->session->data['token'];

        if (isset($this->request->post['coc_discount_seo_keyword'])) {
            $data['coc_discount_seo_keyword'] = $this->request->post['coc_discount_seo_keyword'];
        } else {
            $data['coc_discount_seo_keyword'] = $this->config->get('coc_discount_seo_keyword');
        }


        if (isset($this->request->post['coc_discount_status'])) {
            $data['status'] = $this->request->post['coc_discount_status'];
        } else {
            $data['status'] = $this->config->get('coc_discount_status');
        }


        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->post['coc_discount_description'])) {
            $data['coc_discount_description'] = $this->request->post['coc_discount_description'];
        } elseif ($this->config->get('coc_discount_description')) {
            $data['coc_discount_description'] = $this->config->get('coc_discount_description');
        } else {
            $data['coc_discount_description'] = array();
        }


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('coc/discount.tpl', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'coc/discount')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        foreach ($this->request->post['coc_discount_description'] as $language_id => $value) {

            if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
                $this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
            }
        }

        if (utf8_strlen($this->request->post['coc_discount_seo_keyword']) > 0) {
            $this->load->model('catalog/url_alias');

            $url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['coc_discount_seo_keyword']);

            if ($url_alias_info && $url_alias_info['query'] != 'product/discount') {
                $this->error['seo_keyword'] = sprintf($this->language->get('error_seo_keyword'));
            }

        }


        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

}