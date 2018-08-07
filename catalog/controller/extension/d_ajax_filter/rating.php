<?php

class ControllerExtensionDAjaxFilterRating extends Controller
{
    private $codename = 'd_ajax_filter';
    private $route = 'extension/d_ajax_filter/rating';
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
        $results = array(1,2,3,4,5);

        $rating_data = array();

        foreach ($results as $value) {
            $rating_data[$value] = array(
                'name' => sprintf($this->language->get('text_star'), $value),
                'value' => $value
                );
        }
        if(!empty($rating_data)){
            $filters['_0'] = array(
                'caption' => $this->language->get('text_rating'),
                'name' => 'rating',
                'group_id' => 0,
                'type' =>  $setting['type'],
                'collapse' =>  $setting['collapse'],
                'values' => $rating_data
                );
        }
        
        return $filters;
    }


    public function quantity(){

        $quantity = $this->{'model_extension_'.$this->codename.'_rating'}->getTotalRating($this->filter_data, true);

        if(isset($quantity['rating'])){
            $rating_quantity = $quantity['rating'];
        }
        else{
            $rating_quantity = array();
        }

        return $rating_quantity;
    }

    public function url($query){
        $groups = array();

        preg_match('/rating,([^&><]*)\\/?/', $query, $matches);
        if(!empty($matches[1])){

            $results = explode(',', $matches[1]);
            if(!empty($results)){
                $groups[] = $results;
            }
        }

        return $groups;
    }

    public function rewrite($data){
        $result = array();
        if(!empty($data[0])){
            $query = array('rating');
            foreach ($data[0] as $rating) {
                $query[] = $rating;
            }

            if(count($query) > 1){
                $result[] = implode(',', $query);
            }
        }

        return $result;
    }
}