<?php
class ControllerExtensionDSEOModuleManagerDAjaxFilterSEO extends Controller
{
    private $codename = 'd_ajax_filter_seo';
    private $route = 'extension/d_seo_module_manager/d_ajax_filter_seo';
    private $config_file = 'd_ajax_filter_seo';
    private $error = array();
    
    /*
    *	Functions for SEO Module Manager.
    */
    public function manager_config($data)
    {
        $_language = new Language();
        $_language->load($this->route);
        
        $_config = new Config();
        $_config->load($this->config_file);
        $config_setting = ($_config->get($this->codename . '_manager')) ? $_config->get($this->codename . '_manager') : array();

        foreach ($config_setting['sheet'] as &$sheet) {
            if (substr($sheet['name'], 0, strlen('text_')) == 'text_') {
                $sheet['name'] = $_language->get($sheet['name']);
            }
                
            foreach ($sheet['field'] as &$field) {
                if (substr($field['name'], 0, strlen('text_')) == 'text_') {
                    $field['name'] = $_language->get($field['name']);
                }
            }
        }
        
        if (!empty($config_setting['sheet'])) {
            $data['sheet'] = array_replace_recursive($data['sheet'], $config_setting['sheet']);
        }
                    
        return $data;
    }
    
    public function manager_list_elements($filter_data)
    {
        $this->load->model($this->route);
        
        return $this->{'model_extension_d_seo_module_manager_' . $this->codename}->getListElements($filter_data);
    }
    
    public function manager_save_element_field($element_data)
    {
        $this->load->model($this->route);
        
        return $this->{'model_extension_d_seo_module_manager_' . $this->codename}->saveElementField($element_data);
    }
    
    public function manager_export_elements($export_data)
    {
        $this->load->model($this->route);
        
        return $this->{'model_extension_d_seo_module_manager_' . $this->codename}->getExportElements($export_data);
    }
    
    public function manager_import_elements($import_data)
    {
        $this->load->model($this->route);
        
        return $this->{'model_extension_d_seo_module_manager_' . $this->codename}->saveImportElements($import_data);
    }
}
