<?php

class ControllerExtensionDSEOModuleAdviserDAjaxFilterSEO extends Controller
{
    private $codename = 'd_ajax_filter_seo';
    private $route = 'extension/d_seo_module_adviser/d_ajax_filter_seo';
    private $config_file = 'd_ajax_filter_seo';
    private $error = array();

    /*
    *	Functions for SEO Module Adviser.
    */
    public function adviser_elements($route)
    {
        $this->load->model($this->route);

        return $this->{'model_extension_d_seo_module_adviser_' . $this->codename}->getAdviserElements($route);
    }
}
