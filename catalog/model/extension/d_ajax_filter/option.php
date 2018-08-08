<?php

class ModelExtensionDAjaxFilterOption extends Model
{

    private $codename = "d_ajax_filter";

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->model('extension/module/' . $this->codename);
    }

    public function getOptions($filter_data)
    {
        $sql = "SELECT o.option_id, od.name FROM `" . DB_PREFIX . "product_option_value` pov INNER JOIN `" . DB_PREFIX . "af_temporary` aft ON aft.product_id = pov.product_id LEFT JOIN `" . DB_PREFIX . "option` o ON pov.option_id = o.option_id LEFT JOIN `" . DB_PREFIX . "option_description` od ON o.option_id = od.option_id WHERE od.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY pov.option_id ORDER BY o.sort_order ASC";


        $hash = md5(json_encode($filter_data));

        $result = $this->cache->get('af-option.' . $hash);

        if (!$result) {
            $query = $this->db->query($sql);
            $result = $query->rows;
            $this->cache->set('af-option.' . $hash, $result);
        }

        $option_data = array();
        if (!empty($result)) {
            foreach ($result as $row) {
                $option_data[$row['option_id']] = $row;
            }
        }

        return $option_data;
    }

    public function getOptionValues($option_id)
    {
        $sql = "SELECT ov.option_value_id, ovd.name, ov.image  FROM `" . DB_PREFIX . "product_option_value` pov  INNER JOIN `" . DB_PREFIX . "af_temporary` aft ON aft.product_id = pov.product_id  LEFT JOIN `" . DB_PREFIX . "option_value` ov ON ov.option_value_id = pov.option_value_id LEFT JOIN `" . DB_PREFIX . "option_value_description` ovd ON ov.option_value_id = ovd.option_value_id  WHERE ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pov.option_id='" . (int)$option_id . "' GROUP BY ov.option_value_id ORDER BY ov.sort_order ASC ";

        $query = $this->db->query($sql);

        $result = $query->rows;

        $option_value_data = array();
        if (!empty($result)) {
            foreach ($result as $row) {
                $option_value_data[$row['option_value_id']] = $row;
            }
        }

        return $option_value_data;
    }

    public function getOptionValue($option_value_id)
    {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "option_value` ov LEFT JOIN `" . DB_PREFIX . "option_value_description` ovd ON ov.option_value_id = ovd.option_value_id WHERE ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ov.option_value_id = '" . (int)$option_value_id . "'");
        return $query->row;
    }

    public function getOption($option_id)
    {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "option` o LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE o.option_id = '" . (int)$option_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->row;
    }

    public function getOptionCount($data)
    {
        $params = $this->{'model_extension_module_' . $this->codename}->getParamsToArray(true);

        $in = $this->getTotalOption($data, true);

        if (!empty($params['option'])) {
            foreach ($params['option'] as $option_id => $option_values) {
                $group_count = $this->getTotalOption($data, true, $option_id);
                if (isset($group_count['option'][$option_id])) {
                    $in = $this->{'model_extension_module_' . $this->codename}->mergeTotal($in, array('option' => array($option_id => $group_count['option'][$option_id])));
                }
            }
        }
        return $in;
    }

    public function getTotalOption($data, $group_id = null)
    {
        $params = $this->{'model_extension_module_' . $this->codename}->getParamsToArray();

        $total_query = $this->{'model_extension_module_' . $this->codename}->getProductsQuery();

        $sql = "SELECT 'option' as type, ov.option_id as id, ov.option_value_id as val, COUNT(pov.product_id) as c
        FROM " . DB_PREFIX . "option_value ov
        INNER JOIN " . DB_PREFIX . "product_option_value pov
        ON pov.option_value_id = ov.option_value_id
        INNER JOIN (" . $total_query . ") p
        ON pov.product_id = p.product_id";

        if (!empty($params)) {
            if (!is_null($group_id)) {
                unset($params['option'][$group_id]);
            }

            $data['params'] = $params;

            $result = $this->{'model_extension_module_' . $this->codename}->getParamsQuery($params);
            if (!empty($result)) {
                $sql .= " AND " . $result;
            }
        }

        $sql .= " GROUP BY ov.option_value_id ";

        $hash = md5(json_encode($data));

        $result = $this->cache->get('af-total-option.' . $hash);
        if (!$result) {
            $query = $this->db->query($sql);
            $result = $query->rows;
            $this->cache->set('af-total-option.' . $hash, $result);
        }
        return $this->{'model_extension_module_' . $this->codename}->convertResultTotal($result);

    }

    public function getSetting($option_id, $common_setting, $module_setting)
    {

        if (isset($module_setting['options'][$option_id]) && $module_setting['options'][$option_id]['status'] != 'default') {
            return $module_setting['options'][$option_id];
        }

        if ($module_setting['option_default']['status'] != 'default') {
            return $module_setting['option_default'];
        }
        if (isset($common_setting['options'][$option_id]) && $common_setting['options'][$option_id]['status'] != 'default') {
            return $common_setting['options'][$option_id];
        }
        return $common_setting['default'];
    }

    public function getTotalQuery($options, $table_name)
    {
        $implode = array();
        foreach ($options as $option_id => $option_values) {
            $value_array = array();
            foreach ($option_values as $option_value_id) {
                $value_array[] = "FIND_IN_SET((" . $this->{'model_extension_module_' . $this->codename}->getValue('option', $option_id, $option_value_id) . ")," . $table_name . ".af_values)";
            }
            $implode[] = "(" . implode(' OR ', $value_array) . ")";
        }
        $sql = "";
        if (!empty($implode)) {
            $sql = implode(' AND ', $implode);
        }
        return $sql;
    }
}