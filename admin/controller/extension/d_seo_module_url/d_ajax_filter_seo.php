<?php

class ControllerExtensionDSEOModuleURLDAjaxFilterSEO extends Controller
{
    private $codename = 'd_ajax_filter_seo';
    private $route = 'extension/d_seo_module_url/d_ajax_filter_seo';
    private $config_file = 'd_ajax_filter_seo';
    private $error = array();

    /*
    *	Functions for SEO Module URL.
    */
    public function url_generator_config($data)
    {
        $_language = new Language();
        $_language->load($this->route);

        $_config = new Config();
        $_config->load($this->config_file);
        $config_setting = ($_config->get($this->codename . '_url_generator')) ? $_config->get($this->codename . '_url_generator') : array();

        foreach ($config_setting['sheet'] as &$sheet) {
            if (substr($sheet['name'], 0, strlen('text_')) == 'text_') {
                $sheet['name'] = $_language->get($sheet['name']);
            }

            foreach ($sheet['field'] as &$field) {
                if (substr($field['name'], 0, strlen('text_')) == 'text_') {
                    $field['name'] = $_language->get($field['name']);
                }
            }

            foreach ($sheet['button_popup'] as &$button_popup) {
                if (substr($button_popup['name'], 0, strlen('text_')) == 'text_') {
                    $button_popup['name'] = $_language->get($button_popup['name']);
                }

                foreach ($button_popup['field'] as &$field) {
                    if (substr($field['name'], 0, strlen('text_')) == 'text_') {
                        $field['name'] = $_language->get($field['name']);
                    }
                }
            }
        }

        if (!empty($config_setting['sheet'])) {
            $data['sheet'] = array_replace_recursive($data['sheet'], $config_setting['sheet']);
        }

        return $data;
    }

    public function url_generator_generate_fields($generator_data)
    {
        $this->load->model($this->route);

        return $this->{'model_extension_d_seo_module_url_' . $this->codename}->generateFields($generator_data);
    }

    public function url_generator_clear_fields($generator_data)
    {
        $this->load->model($this->route);

        return $this->{'model_extension_d_seo_module_url_' . $this->codename}->clearFields($generator_data);
    }
}