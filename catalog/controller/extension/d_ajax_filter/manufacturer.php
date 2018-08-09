<?php

class ControllerExtensionDAjaxFilterManufacturer extends Controller
{
    private $codename = 'd_ajax_filter';
    private $route = 'extension/d_ajax_filter/manufacturer';
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
        $results = $this->{'model_extension_' . $this->codename . '_manufacturer'}->getManufacturers($this->filter_data);

        $manufacturer_data = array();

        foreach ($results as $manufacturer_id => $value) {

            if (!empty($value['image']) && file_exists(DIR_IMAGE . $value['image'])) {
                $thumb = $this->model_tool_image->resize($value['image'], 45, 45);
            } else {
                $thumb = $this->model_tool_image->resize('no_image.png', 45, 45);
            }

            $manufacturer_data['_' . $manufacturer_id] = array(
                'name' => $value['name'],
                'value' => $manufacturer_id,
                'thumb' => $thumb
            );

        }
        if (!empty($manufacturer_data)) {

            $manufacturer_data = $this->{'model_extension_module_' . $this->codename}->sort_values($manufacturer_data, $setting['sort_order_values']);

            $filters['_0'] = array(
                'caption' => $this->language->get('text_manufacturer'),
                'name' => 'manufacturer',
                'type' => $setting['type'],
                'group_id' => '0',
                'collapse' => $setting['collapse'],
                'values' => $manufacturer_data,
            );
        }

        return $filters;
    }

    public function quantity()
    {

        $quantity = $this->{'model_extension_' . $this->codename . '_manufacturer'}->getTotalManufacturer($this->filter_data);

        if (isset($quantity['manufacturer'])) {
            $manufacturer_quantity = $quantity['manufacturer'];
        } else {
            $manufacturer_quantity = array();
        }

        return $manufacturer_quantity;
    }

    public function url($query)
    {
        $groups = array();

        preg_match('/manufacturer,([a-zA-Z\\s,-]+)\\/?/', $query, $matches);
        if (!empty($matches[1])) {
            $names = explode(',', $matches[1]);
            $names = array_map(function ($val) {
                return "'" . $val . "'";
            }, $names);
            $results = $this->{'model_extension_module_' . $this->codename}->getTranslit($names, 'manufacturer', 0);
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
            $query = array('manufacturer');
            foreach ($data[0] as $manufacturer_id) {
                $manufacturer_info = $this->{'model_extension_' . $this->codename . '_manufacturer'}->getManufacturer($manufacturer_id);
                $name = html_entity_decode($manufacturer_info['name'], ENT_QUOTES, 'UTF-8');

                $query[] = $this->{'model_extension_module_' . $this->codename}->setTranslit($name, 'manufacturer', 0, $manufacturer_id);
            }

            if (count($query) > 1) {
                $result[] = implode(',', $query);
            }
        }

        return $result;
    }
}