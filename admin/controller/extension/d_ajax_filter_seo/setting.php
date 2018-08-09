<?php
/*
*   location: admin/controller
*/

class ControllerExtensionDAjaxFilterSeoSetting extends Controller
{
    private $codename = 'd_ajax_filter_seo';
    private $route = 'extension/d_ajax_filter_seo/setting';

    private $extension = array();
    private $config_file = '';
    private $store_id = 0;
    private $error = array();

    public function __construct($registry)
    {
        parent::__construct($registry);

        $this->load->language($this->route);

        //extension.json
        $this->extension = json_decode(file_get_contents(DIR_SYSTEM . 'library/d_shopunity/extension/d_ajax_filter.json'), true);
        $this->d_shopunity = (file_exists(DIR_SYSTEM . 'library/d_shopunity/extension/d_shopunity.json'));

        //Store_id (for multistore)
        if (isset($this->request->get['store_id'])) {
            $this->store_id = $this->request->get['store_id'];
        }
    }

    public function index()
    {

        $this->load->model('extension/d_opencart_patch/url');
        $this->load->model('extension/d_opencart_patch/load');
        $this->load->model('extension/d_opencart_patch/user');

        $this->load->model('setting/setting');

        //save post
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->model_setting_setting->editSetting($this->codename, $this->request->post, $this->store_id);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->model_extension_d_opencart_patch_url->link('marketplace/extension', 'type=module'));
        }

        $this->document->addStyle('view/stylesheet/shopunity/bootstrap.css');

        $this->document->addScript('view/javascript/shopunity/bootstrap-switch/bootstrap-switch.min.js');
        $this->document->addStyle('view/stylesheet/shopunity/bootstrap-switch/bootstrap-switch.css');

        $this->document->addStyle('view/stylesheet/d_ajax_filter_seo.css');

        $url_params = array();
        $url = '';

        if (isset($this->response->get['store_id'])) {
            $url_params['store_id'] = $this->store_id;
        }

        $url = ((!empty($url_params)) ? '&' : '') . http_build_query($url_params);

        // Breadcrumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->model_extension_d_opencart_patch_url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->model_extension_d_opencart_patch_url->link('extension/extension', 'type=module')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title_main'),
            'href' => $this->model_extension_d_opencart_patch_url->link($this->route, $url)
        );

        // Notification
        foreach ($this->error as $key => $error) {
            $data['error'][$key] = $error;
        }

        // Heading
        $this->document->setTitle($this->language->get('heading_title_main'));
        $data['heading_title'] = $this->language->get('heading_title_main');
        $data['text_edit'] = $this->language->get('text_edit');

        $data['text_queries'] = $this->language->get('text_queries');
        $data['text_settings'] = $this->language->get('text_settings');

        $data['href_queries'] = $this->model_extension_d_opencart_patch_url->link('extension/' . $this->codename . '/query');
        $data['href_settings'] = $this->model_extension_d_opencart_patch_url->link($this->route);

        // Variable
        $data['id'] = $this->codename;
        $data['route'] = $this->route;
        $data['store_id'] = $this->store_id;

        $data['version'] = $this->extension['version'];
        $data['token'] = $this->model_extension_d_opencart_patch_user->getToken();

        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_confirm'] = $this->language->get('text_confirm');
        $data['text_uninstall_confirm'] = $this->language->get('text_uninstall_confirm');


        $data['entry_auto_generated'] = $this->language->get('entry_auto_generated');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_generate_status'] = $this->language->get('entry_generate_status');
        $data['entry_uninstall'] = $this->language->get('entry_uninstall');

        // Button
        $data['button_save'] = $this->language->get('button_save');
        $data['button_uninstall'] = $this->language->get('button_uninstall');
        $data['button_save_and_stay'] = $this->language->get('button_save_and_stay');
        $data['button_cancel'] = $this->language->get('button_cancel');

        // Entry
        $data['entry_status'] = $this->language->get('entry_status');

        // Text
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        //action
        $data['module_link'] = $this->model_extension_d_opencart_patch_url->link('extension/module/' . $this->codename);
        $data['uninstall'] = $this->model_extension_d_opencart_patch_url->link('extension/module/' . $this->codename . '/uninstallModule');
        $data['action'] = $this->model_extension_d_opencart_patch_url->link($this->route, $url);
        $data['install_event_support'] = $this->model_extension_d_opencart_patch_url->link($this->route . '/install_event_support');

        $data['cancel'] = $this->model_extension_d_opencart_patch_url->link('marketplace/extension', 'type=module');

        //support
        $data['text_support'] = $this->language->get('text_support');
        $data['entry_support'] = $this->language->get('entry_support');
        $data['button_support_email'] = $this->language->get('button_support_email');

        if (isset($this->request->post[$this->codename . '_setting'])) {
            $data['setting'] = $this->request->post[$this->codename . '_setting'];
        } else {
            $data['setting'] = $this->config->get('d_ajax_filter_seo_setting');
        }

        if (isset($this->request->post[$this->codename . '_status'])) {
            $data['status'] = $this->request->post[$this->codename . '_status'];
        } else {
            $data['status'] = $this->config->get('d_ajax_filter_seo_status');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->model_extension_d_opencart_patch_load->view('extension/' . $this->codename . '/setting', $data));
    }

    private function validate($permission = 'modify')
    {

        if (isset($this->request->post['config'])) {
            return false;
        }

        $this->language->load($this->route);

        if (!$this->user->hasPermission($permission, $this->route)) {
            $this->error['warning'] = $this->language->get('error_permission');
            return false;
        }

        return true;
    }
}