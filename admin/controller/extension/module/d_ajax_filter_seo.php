<?php
/*
*   location: admin/controller
*/

class ControllerExtensionModuleDAjaxFilterSeo extends Controller
{
    private $codename = 'd_ajax_filter_seo';
    private $route = 'extension/module/d_ajax_filter_seo';

    private $extension = array();
    private $config_file = '';
    private $store_id = 0;
    private $error = array();

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->model($this->route);
        $this->load->language($this->route);

        $this->extension = json_decode(file_get_contents(DIR_SYSTEM . 'library/d_shopunity/extension/' . $this->codename . '.json'), true);
        $this->d_shopunity = (file_exists(DIR_SYSTEM . 'library/d_shopunity/extension/d_shopunity.json'));
        $this->d_opencart_patch = (file_exists(DIR_SYSTEM . 'library/d_shopunity/extension/d_opencart_patch.json'));
        $this->d_twig_manager = (file_exists(DIR_SYSTEM . 'library/d_shopunity/extension/d_twig_manager.json'));
    }

    public function index()
    {
        $this->load->model('extension/d_opencart_patch/url');
        $this->load->model('extension/d_opencart_patch/load');
        $this->load->model('extension/d_opencart_patch/user');

        if ($this->d_twig_manager) {
            $this->load->model('extension/module/d_twig_manager');
            if (!$this->model_extension_module_d_twig_manager->isCompatible()) {
                $this->model_extension_module_d_twig_manager->installCompatibility();
                $this->load->language('extension/module/d_visual_designer');
                $this->session->data['success'] = $this->language->get('success_twig_compatible');
                $this->response->redirect($this->model_extension_d_opencart_patch_url->link('marketplace/extension', 'type=module'));
            }
        }
        if ($this->d_shopunity) {
            $this->load->model('extension/d_shopunity/mbooth');
            $this->model_extension_d_shopunity_mbooth->validateDependencies($this->codename);
        }

        $seo_extensions = $this->{'model_extension_module_' . $this->codename}->getSEOExtensions();

        if (in_array($this->codename, $seo_extensions)) {
            $this->load->controller('extension/' . $this->codename . '/setting');
        } else {
            $this->document->setTitle($this->language->get('heading_title_main'));
            $data['heading_title'] = $this->language->get('heading_title_main');

            // Variable
            $data['codename'] = $this->codename;
            $data['route'] = $this->route;
            $data['version'] = $this->extension['version'];
            $data['config'] = $this->config_file;
            $data['d_shopunity'] = $this->d_shopunity;
            $data['token'] = $this->model_extension_d_opencart_patch_user->getToken();

            $data['module_link'] = $this->model_extension_d_opencart_patch_url->link($this->route);

            $data['cancel'] = $this->model_extension_d_opencart_patch_url->link('marketplace/extension', 'type=module');

            $data['install'] = $this->model_extension_d_opencart_patch_url->link($this->route . '/installModule');

            $data['store_setting'] = $this->model_extension_d_opencart_patch_url->link('setting/store');

            $data['text_install'] = $this->language->get('text_install');

            // Button
            $data['button_cancel'] = $this->language->get('button_cancel');
            $data['button_install'] = $this->language->get('button_install');
            $data['button_uninstall'] = $this->language->get('button_uninstall');

            $data['help_install'] = $this->language->get('help_install');

            // Breadcrumbs
            $data['breadcrumbs'] = array();

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->model_extension_d_opencart_patch_url->link('common/dashboard')
            );

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_modules'),
                'href' => $this->model_extension_d_opencart_patch_url->link('marketplace/extension', 'type=module')
            );


            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title_main'),
                'href' => $this->model_extension_d_opencart_patch_url->link($this->route)
            );


            $data['header'] = $this->load->controller('common/header');
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['footer'] = $this->load->controller('common/footer');

            $this->response->setOutput($this->model_extension_d_opencart_patch_load->view('extension/' . $this->codename . '/install', $data));

        }
    }

    public function installModule()
    {

        if ($this->validateInstall()) {
            $this->{'model_extension_module_' . $this->codename}->CreateDatabase();

            $this->session->data['success'] = $this->language->get('text_success_install');
        }

        $data['error'] = $this->error;

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $this->response->setOutput(json_encode($data));
    }

    private function validateInstall($permission = 'modify')
    {

        $this->load->model('extension/d_opencart_patch/url');
        $this->load->model($this->route);

        if (!$this->user->hasPermission($permission, $this->route)) {
            $this->error['warning'] = $this->language->get('error_permission');

            return false;
        }
        $seo_extensions = $this->{'model_extension_module_' . $this->codename}->getSEOExtensions();

        if (in_array('d_seo_module', $seo_extensions)) {
            $seo_extensions[] = $this->codename;
            $this->{'model_extension_module_' . $this->codename}->saveSEOExtensions($seo_extensions);
        } else {

            $this->load->model('user/user_group');

            if (VERSION >= '2.3.0.0') {
                $this->model_user_user_group->addPermission($this->{'model_extension_module_' . $this->codename}->getGroupId(), 'access', 'extension/module/d_seo_module');
                $this->model_user_user_group->addPermission($this->{'model_extension_module_' . $this->codename}->getGroupId(), 'modify', 'extension/module/d_seo_module');
                $install_d_seo_module = $this->model_extension_d_opencart_patch_url->link('extension/module/d_seo_module/installModule');
            } else {
                $this->model_user_user_group->addPermission($this->{'model_extension_module_' . $this->codename}->getGroupId(), 'access', 'module/d_seo_module');
                $this->model_user_user_group->addPermission($this->{'model_extension_module_' . $this->codename}->getGroupId(), 'modify', 'module/d_seo_module');
                $install_d_seo_module = $this->model_extension_d_opencart_patch_url->link('module/d_seo_module/installModule');
            }

            $this->error['warning'] = sprintf($this->language->get('error_dependence_d_seo_module'), $install_d_seo_module);

            return false;
        }

        return true;
    }

    public function uninstallModule()
    {

        if ($this->validateUninstall()) {

            $this->{'model_extension_module_' . $this->codename}->DropDatabase();

            $this->session->data['success'] = $this->language->get('text_success_uninstall');
        }

        $data['error'] = $this->error;

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $this->response->setOutput(json_encode($data));
    }

    private function validateUninstall($permission = 'modify')
    {
        $this->load->model($this->route);

        if (isset($this->request->post['config'])) {
            return false;
        }

        if (!$this->user->hasPermission($permission, $this->route)) {
            $this->error['warning'] = $this->language->get('error_permission');

            return false;
        }

        $seo_extensions = $this->{'model_extension_module_' . $this->codename}->getSEOExtensions();
        $key = array_search($this->codename, $seo_extensions);
        if ($key !== false) unset($seo_extensions[$key]);
        $this->{'model_extension_module_' . $this->codename}->saveSEOExtensions($seo_extensions);

        return true;
    }

    public function install()
    {
        if ($this->d_shopunity) {
            $this->load->model('extension/d_shopunity/mbooth');
            $this->model_extension_d_shopunity_mbooth->installDependencies($this->codename);
        }

        $this->load->model('user/user_group');

        $this->model_user_user_group->addPermission($this->{'model_extension_module_' . $this->codename}->getGroupId(), 'access', 'extension/module/' . $this->codename);
        $this->model_user_user_group->addPermission($this->{'model_extension_module_' . $this->codename}->getGroupId(), 'access', 'extension/' . $this->codename);
        $this->model_user_user_group->addPermission($this->{'model_extension_module_' . $this->codename}->getGroupId(), 'access', 'extension/' . $this->codename . '/query');
        $this->model_user_user_group->addPermission($this->{'model_extension_module_' . $this->codename}->getGroupId(), 'access', 'extension/' . $this->codename . '/setting');
        $this->model_user_user_group->addPermission($this->{'model_extension_module_' . $this->codename}->getGroupId(), 'modify', 'extension/module/' . $this->codename);
        $this->model_user_user_group->addPermission($this->{'model_extension_module_' . $this->codename}->getGroupId(), 'modify', 'extension/' . $this->codename);
        $this->model_user_user_group->addPermission($this->{'model_extension_module_' . $this->codename}->getGroupId(), 'modify', 'extension/' . $this->codename . '/query');
        $this->model_user_user_group->addPermission($this->{'model_extension_module_' . $this->codename}->getGroupId(), 'modify', 'extension/' . $this->codename . '/setting');
    }
}

?>