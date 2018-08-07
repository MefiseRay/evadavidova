<?php

class ControllerExtensionDAjaxFilterOption extends Controller
{
    private $codename = 'd_ajax_filter';
    private $route = 'extension/d_ajax_filter/option';
    private $filter_data = array();
    
    private $option_setting = array();

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->model('extension/module/'.$this->codename);
        $this->load->model($this->route);

        $this->load->language('extension/module/'.$this->codename);

        $this->filter_data = $this->{'model_extension_module_'.$this->codename}->getFitlerData();
        

        $option_setting = $this->config->get($this->codename.'_options');

        if(empty($option_setting)){
            $this->config->load('d_ajax_filter');
            $setting = $this->config->get('d_ajax_filter_setting');

            $option_setting = $setting['options'];
        }

        $this->option_setting = $option_setting;
    }

    public function index($setting) {
        $filters = array();
        $results = $this->{'model_extension_'.$this->codename.'_option'}->getOptions($this->filter_data);

        foreach ($results as $option_id => $option_info) {
            $option_values = $this->{'model_extension_'.$this->codename.'_option'}->getOptionValues($option_id);

            $option_setting = $this->{'model_extension_'.$this->codename.'_option'}->getSetting($option_id, $this->option_setting, $setting['module_setting']);

            $option_value_data = array();
            if($option_setting['status']){

                foreach ($option_values as $option_value_id => $option_value_info) {

                    if(!empty($option_value_info['image'])&&file_exists(DIR_IMAGE.$option_value_info['image'])) {
                        $thumb = $this->model_tool_image->resize($option_value_info['image'],45,45);
                    }
                    else {
                        $thumb = $this->model_tool_image->resize('no_image.png',45,45);
                    }

                    $option_value_data['_'.$option_value_id] = array(
                        'name' => html_entity_decode($option_value_info['name'], ENT_QUOTES, 'UTF-8'),
                        'value' => $option_value_id,
                        'thumb' => $thumb
                        );
                }

                if(!empty($option_value_data)){

                    $option_value_data = $this->{'model_extension_module_'.$this->codename}->sort_values($option_value_data, $option_setting['sort_order_values']);

                    $filters['_'.$option_id] = array(
                        'caption' => html_entity_decode($option_info['name'], ENT_QUOTES, 'UTF-8'),
                        'name' => 'option',
                        'group_id' => $option_id,
                        'type' =>  $option_setting['type'],
                        'collapse' =>  $option_setting['collapse'],
                        'values' => $option_value_data,
                        'sort_order'=> $setting['sort_order']
                        );
                }
            }
        }

        return $filters;
    }

    public function quantity(){

        $quantity = $this->{'model_extension_'.$this->codename.'_option'}->getOptionCount($this->filter_data);


        if(isset($quantity['option'])){
            $option_quantity = $quantity['option'];
        }
        else{
            $option_quantity = array();
        }

        return $option_quantity;
    }

    public function url($query){
        $groups = array();

        preg_match_all('/o([0-9]+)-([^<>,]*),([^&>\\/<]*)(\/|\\z)/', $query, $matches, PREG_SET_ORDER);

        if(!empty($matches)){
            foreach ($matches as $match) {
                if(!empty($match[1]) && !empty($match[3])){
                    $group_id = (int)$match[1];
                    $names = explode(',', $match[3]);
                    $names =array_map(function($val){ return "'".$val."'"; }, $names);

                    $results = $this->{'model_extension_module_'.$this->codename}->getTranslit($names, 'option', $group_id);
                    if(!empty($results)){
                        $groups[$group_id] = $results;
                    }
                }
            }
        }
        
        return $groups;
    }

    public function rewrite($data){
        $result = array();
        if(!empty($data)){
            foreach ($data as $option_id => $option_values) {
                $option_info = $this->{'model_extension_'.$this->codename.'_option'}->getOption($option_id);
                $option_info['name'] = html_entity_decode($option_info['name'], ENT_QUOTES, 'UTF-8');
                $query = array('o'.$option_id.'-'.$this->{'model_extension_module_'.$this->codename}->translit($option_info['name']));
                foreach ($option_values as $option_value_id) {
                    $option_value_info = $this->{'model_extension_'.$this->codename.'_option'}->getOptionValue($option_value_id);

                    $name = html_entity_decode($option_value_info['name'], ENT_QUOTES, 'UTF-8');

                    $query[] = $this->{'model_extension_module_'.$this->codename}->setTranslit($name, 'option', $option_id, $option_value_id);
                }
                if(count($query) > 1){
                    $result[] = implode(',', $query);
                }
            }
            
        }

        return $result;
    }

}