<?php

class ControllerExtensionDAjaxFilterStockStatus extends Controller
{
    private $codename = 'd_ajax_filter';
    private $route = 'extension/d_ajax_filter/stock_status';
    private $filter_data = array();


    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->model('extension/module/' . $this->codename);
        $this->load->model($this->route);

        $this->load->language('extension/module/' . $this->codename);

        $this->filter_data = $this->{'model_extension_module_' . $this->codename}->getFitlerData();


    }

    public function index($setting)
    {
        $filters = array();
        $results = $this->{'model_extension_' . $this->codename . '_stock_status'}->getStockStatuses($this->filter_data);

        $stock_status_data = array();

        foreach ($results as $stock_status_id => $value) {

            $stock_status_data['_' . $stock_status_id] = array(
                'name' => $value['name'],
                'value' => $stock_status_id
            );

        }
        if (!empty($stock_status_data)) {

            $stock_status_data = $this->{'model_extension_module_' . $this->codename}->sort_values($stock_status_data, $setting['sort_order_values']);

            $filters['_0'] = array(
                'caption' => $this->language->get('text_stock_status'),
                'name' => 'stock_status',
                'group_id' => 0,
                'type' => $setting['type'],
                'collapse' => $setting['collapse'],
                'values' => $stock_status_data,
                'sort_order' => $setting['sort_order']
            );
        }
        return $filters;
    }

    public function selected($setting)
    {
        $selected = array();
        if (isset($this->selected_params['stock_status'][0])) {
            foreach ($this->selected_params['stock_status'][0] as $stock_status_id) {
                $stock_status_info = $this->{'model_extension_' . $this->codename . '_stock_status'}->getStockStatus($stock_status_id);
                $selected[] = array(
                    'name' => $stock_status_info['name'],
                    'type' => 'stock_status',
                    'mode' => $setting['type'],
                    'caption' => $this->language->get('text_stock_status'),
                    'value' => $stock_status_id
                );
            }
        }
        return $selected;
    }

    public function quantity()
    {

        $quantity = $this->{'model_extension_' . $this->codename . '_stock_status'}->getTotalStockStatus($this->filter_data, true);

        if (isset($quantity['stock_status'])) {
            $stock_status_quantity = $quantity['stock_status'];
        } else {
            $stock_status_quantity = array();
        }

        return $stock_status_quantity;
    }

    public function url($query)
    {
        $groups = array();

        preg_match('/stock_status,([a-zA-Z\\s\\S,]+)\\/?/', $query, $matches);
        if (!empty($matches[1])) {
            $names = explode(',', $matches[1]);
            $names = array_map(function ($val) {
                return "'" . $val . "'";
            }, $names);

            $results = $this->{'model_extension_module_' . $this->codename}->getTranslit($names, 'stock_status', 0);
            if (!empty($results)) {
                $groups[] = $results;
            }
        }

        return $groups;
    }

    public function rewrite($data)
    {
        $result = array();
        if (!empty($data[0])) {
            $query = array('stock_status');
            foreach ($data[0] as $stock_status_id) {
                $stock_status_info = $this->{'model_extension_' . $this->codename . '_stock_status'}->getStockStatus($stock_status_id);
                $query[] = $this->{'model_extension_module_' . $this->codename}->setTranslit($stock_status_info['name'], 'stock_status', 0, $stock_status_id);
            }

            if (count($query) > 1) {
                $result[] = implode(',', $query);
            }
        }

        return $result;
    }
}