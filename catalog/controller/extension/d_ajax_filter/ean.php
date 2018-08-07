<?php

class ControllerExtensionDAjaxFilterEAN extends Controller
{
    private $codename = 'd_ajax_filter';
    private $route = 'extension/d_ajax_filter/ean';
    private $filter_data = array();
    

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->model('extension/module/'.$this->codename);
        $this->load->model($this->route);

        $this->load->language('extension/module/'.$this->codename);

        $this->filter_data = $this->{'model_extension_module_'.$this->codename}->getFitlerData();
        

    }

    public function index($setting) {
        $filters = array();
        $results = $this->{'model_extension_'.$this->codename.'_ean'}->getEans($this->filter_data);

        $ean_data = array();

        foreach ($results as $ean_id => $value) {

            $ean_data['_'.$ean_id] = array(
                'name' => $value['value'],
                'value' => $ean_id
                );

        }
        if(!empty($ean_data)){

            $ean_data = $this->{'model_extension_module_'.$this->codename}->sort_values($ean_data, $setting['sort_order_values']);

            $filters['_0'] = array(
                'caption' => $this->language->get('text_ean'),
                'name' => 'ean',
                'group_id' => 0,
                'type' =>  $setting['type'],
                'collapse' =>  $setting['collapse'],
                'values' => $ean_data,
                'sort_order'=> $setting['sort_order']
                );
        }
        return $filters;
    }

    public function quantity(){

        $quantity = $this->{'model_extension_'.$this->codename.'_ean'}->getTotalEan($this->filter_data, true);

        if(isset($quantity['ean'])){
            $ean_quantity = $quantity['ean'];
        }
        else{
            $ean_quantity = array();
        }

        return $ean_quantity;
    }

    public function url($query){
        $groups = array();
        
        preg_match('/ean,([a-zA-Z\\s\\S,]+)\\/?/', $query, $matches);
        if(!empty($matches[1])){
            $names = explode(',', $matches[1]);
            $names =array_map(function($val){ return "'".$val."'"; }, $names);

            $results = $this->{'model_extension_module_'.$this->codename}->getTranslit($names, 'ean', 0);
            if(!empty($results)){
                $groups[] = $results;
            }
        }

        return $groups;
    }

    public function rewrite($data){
        $result = array();
        if(!empty($data[0])){
            $query = array('ean');
            foreach ($data[0] as $ean_id) {
                $ean_info = $this->{'model_extension_'.$this->codename.'_ean'}->getEan($ean_id);

                $query[] = $this->{'model_extension_module_'.$this->codename}->setTranslit($ean_info['name'], 'ean', 0, $ean_id);
            }

            if(count($query) > 1){
                $result[] = implode(',', $query);
            }
        }

        return $result;
    }
}