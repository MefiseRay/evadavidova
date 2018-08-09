<?php

class ControllerExtensionPaymentTinkoff extends Controller
{
    private $error = array();

    public function install()
    {
        $this->load->model('extension/payment/tinkoff');

        $this->model_extension_payment_tinkoff->install();
    }

    public function uninstall()
    {
        $this->load->model('extension/payment/tinkoff');

        $this->model_extension_payment_tinkoff->uninstall();
    }

    public function index()
    {
        $data = array();
        $this->load->language('extension/payment/tinkoff');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');
        $this->load->model('setting/store');
        $this->load->model('extension/payment/tinkoff');

        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $this->error = array();

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->request->post['tinkoff_enabled_taxation'] = (isset($this->request->post['tinkoff_enabled_taxation']) && $this->request->post['tinkoff_enabled_taxation'] = 'on') ? 1 : 0;
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            //unset($this->request->post['tinkoff_module']);
            $this->model_setting_setting->editSetting('tinkoff', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
        } else {
            if (!empty($this->error)) {
                $data['error_warning'] = array_shift($this->error);
            }
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['terminal_key_label'] = $this->language->get('terminal_key');
        $data['secret_key_label'] = $this->language->get('secret_key');
        $data['currency_label'] = $this->language->get('currency');
        $data['payment_url_label'] = $this->language->get('payment_url');
        $data['description_label'] = $this->language->get('description');
        $data['status_label'] = $this->language->get('status');
        $data['status_success_label'] = $this->language->get('status_success');
        $data['status_failed_label'] = $this->language->get('status_failed');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['status_authorized'] = $this->language->get('status_authorized');
        $data['status_completed'] = $this->language->get('status_completed');
        $data['status_canceled'] = $this->language->get('status_canceled');
        $data['status_rejected'] = $this->language->get('status_rejected');
        $data['status_refunded'] = $this->language->get('status_refunded');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/tinkoff', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        //button actions
        $data['action'] = $this->url->link('extension/payment/tinkoff', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');

        $data['tinkoff_terminal_key'] = isset($this->request->post['tinkoff_terminal_key']) ? $this->request->post['tinkoff_terminal_key'] : $this->config->get('tinkoff_terminal_key');
        $data['tinkoff_secret_key'] = isset($this->request->post['tinkoff_secret_key']) ? $this->request->post['tinkoff_secret_key'] : $this->config->get('tinkoff_secret_key');
        $data['currency'] = isset($this->request->post['currency']) ? $this->request->post['currency'] : $this->config->get('currency');
        $data['tinkoff_payment_url'] = isset($this->request->post['tinkoff_payment_url']) ? $this->request->post['tinkoff_payment_url'] : $this->config->get('tinkoff_payment_url');
        $data['description'] = isset($this->request->post['description']) ? $this->request->post['description'] : $this->config->get('description');
        $data['tinkoff_status'] = isset($this->request->post['tinkoff_status']) ? $this->request->post['tinkoff_status'] : $this->config->get('tinkoff_status');
        $data['order_status_success_id'] = isset($this->request->post['order_status_success_id']) ? $this->request->post['order_status_success_id'] : $this->config->get('order_status_success_id');
        $data['order_status_failed_id'] = isset($this->request->post['order_status_failed_id']) ? $this->request->post['order_status_failed_id'] : $this->config->get('order_status_failed_id');
        $data['tinkoff_taxation'] = isset($this->request->post['tinkoff_taxation']) ? $this->request->post['tinkoff_taxation'] : $this->config->get('tinkoff_taxation');
        $data['tinkoff_order_status_authorized'] = isset($this->request->post['tinkoff_order_status_authorized']) ? $this->request->post['tinkoff_order_status_authorized'] : $this->config->get('tinkoff_order_status_authorized');
        $data['tinkoff_order_status_completed'] = isset($this->request->post['tinkoff_order_status_completed']) ? $this->request->post['tinkoff_order_status_completed'] : $this->config->get('tinkoff_order_status_completed');
        $data['tinkoff_order_status_canceled'] = isset($this->request->post['tinkoff_order_status_canceled']) ? $this->request->post['tinkoff_order_status_canceled'] : $this->config->get('tinkoff_order_status_canceled');
        $data['tinkoff_order_status_rejected'] = isset($this->request->post['tinkoff_order_status_rejected']) ? $this->request->post['tinkoff_order_status_rejected'] : $this->config->get('tinkoff_order_status_rejected');
        $data['tinkoff_order_status_refunded'] = isset($this->request->post['tinkoff_order_status_refunded']) ? $this->request->post['tinkoff_order_status_refunded'] : $this->config->get('tinkoff_order_status_refunded');


        $data['taxation_label'] = $this->language->get('tinkoff_taxation');
        $data['tinkoff_taxations'] = array(
            'osn' => $this->language->get('tinkoff_osn'),
            'usn_income' => $this->language->get('tinkoff_usn_income'),
            'usn_income_outcome' => $this->language->get('tinkoff_usn_income_outcome'),
            'envd' => $this->language->get('tinkoff_envd'),
            'esn' => $this->language->get('tinkoff_esn'),
            'patent' => $this->language->get('tinkoff_patent'),
        );

        $data['tinkoff_enabled_taxation_label'] = $this->language->get('tinkoff_enabled_taxation');
        $data['tinkoff_enabled_taxation'] = isset($this->request->post['tinkoff_enabled_taxation']) ? $this->request->post['tinkoff_enabled_taxation'] : $this->config->get('tinkoff_enabled_taxation');

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $data['token'] = $this->session->data['token'];

        $this->template = 'extension/payment/tinkoff.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('extension/payment/tinkoff.tpl', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/payment/tinkoff')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (empty($this->request->post['tinkoff_terminal_key'])) {
            $this->error['tinkoff_terminal_key'] = $this->language->get('error_terminal_key');
        }

        if (empty($this->request->post['tinkoff_secret_key'])) {
            $this->error['tinkoff_secret_key'] = $this->language->get('error_secret_key');
        }

        if (empty($this->request->post['tinkoff_payment_url'])) {
            $this->error['tinkoff_payment_url'] = $this->language->get('error_payment_url');
        }
//
//        if (empty($this->request->post['currency'])) {
//            $this->error['currency'] = $this->language->get('error_currency');
//        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }


}