<?php

class ControllerExtensionDSEOModuleDAjaxFilterSEO extends Controller
{
    private $codename = 'd_ajax_filter_seo';
    private $route = 'extension/d_seo_module/d_ajax_filter_seo';
    private $config_file = 'd_ajax_filter_seo';
    private $error = array();

    /*
    *   Functions for SEO Module.
    */
    public function menu()
    {
        $this->load->language($this->route);
        $this->load->model('extension/d_opencart_patch/url');

        $menu = array();

        if ($this->user->hasPermission('access', 'extension/module/' . $this->codename)) {
            $menu[] = array(
                'name' => $this->language->get('heading_title_main'),
                'href' => $this->model_extension_d_opencart_patch_url->link('extension/module/' . $this->codename),
                'sort_order' => 5,
                'children' => array()
            );
        }

        return $menu;
    }

    public function language_add($data)
    {
        $this->load->model($this->route);

        $this->{'model_d_seo_module_' . $this->codename}->addLanguage($data);
    }

    public function language_delete($data)
    {
        $this->load->model($this->route);

        $this->{'model_d_seo_module_' . $this->codename}->deleteLanguage($data);
    }

    public function field_config($data)
    {
        $_language = new Language();
        $_language->load($this->route);

        $_config = new Config();
        $_config->load($this->config_file);
        $config_field_setting = ($_config->get($this->codename . '_field_setting')) ? $_config->get($this->codename . '_field_setting') : array();

        foreach ($config_field_setting['sheet'] as &$sheet) {
            if (substr($sheet['name'], 0, strlen('text_')) == 'text_') {
                $sheet['name'] = $_language->get($sheet['name']);
            }

            foreach ($sheet['field'] as &$field) {
                if (substr($field['name'], 0, strlen('text_')) == 'text_') {
                    $field['name'] = $_language->get($field['name']);
                }

                if (substr($field['description'], 0, strlen('help_')) == 'help_') {
                    $field['description'] = $_language->get($field['description']);
                }
            }
        }

        if (!empty($config_field_setting['sheet'])) {
            $data['sheet'] = array_replace_recursive($data['sheet'], $config_field_setting['sheet']);
        }

        return $data;
    }

    public function field_elements($filter_data)
    {
        $this->load->model($this->route);

        return $this->{'model_extension_d_seo_module_' . $this->codename}->getFieldElements($filter_data);
    }
}
