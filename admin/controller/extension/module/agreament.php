<?php

class ControllerExtensionModuleAgreament extends Controller
{
    private $error = array();

    public function index()
    {
        $this->language->load('extension/module/agreament');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('agreament', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_title'] = $this->language->get('text_title');

        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');

        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_feedback'] = $this->language->get('entry_feedback');
        $data['entry_checkout'] = $this->language->get('entry_checkout');
        $data['entry_caption'] = $this->language->get('entry_caption');
        $data['entry_review'] = $this->language->get('entry_review');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
        } else {
            $data['success'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/agreament', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link('extension/module/agreament', 'token=' . $this->session->data['token'], 'SSL');

        $data['upgrade'] = $this->url->link('extension/module/agreament/upgrade', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');

        $data['token'] = $this->session->data['token'];

        // Multilanguage
        $this->load->model('localisation/language');
        $data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->post['agreament_status'])) {
            $data['agreament_status'] = $this->request->post['agreament_status'];
        } else {
            $data['agreament_status'] = $this->config->get('agreament_status');
        }

        if (isset($this->request->post['agreament_feedback'])) {
            $data['agreament_feedback'] = $this->request->post['agreament_feedback'];
        } else {
            $data['agreament_feedback'] = $this->config->get('agreament_feedback');
        }

        if (isset($this->request->post['agreament_checkout'])) {
            $data['agreament_checkout'] = $this->request->post['agreament_checkout'];
        } else {
            $data['agreament_checkout'] = $this->config->get('agreament_checkout');
        }

        if (isset($this->request->post['agreament_caption'])) {
            $data['agreament_caption'] = $this->request->post['agreament_caption'];
        } else {
            $data['agreament_caption'] = $this->config->get('agreament_caption');
        }

        if (isset($this->request->post['agreament_review'])) {
            $data['agreament_review'] = $this->request->post['agreament_review'];
        } else {
            $data['agreament_review'] = $this->config->get('agreament_review');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/agreament.tpl', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/agreament')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}

?>
