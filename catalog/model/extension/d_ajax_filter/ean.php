<?php

class ModelExtensionDAjaxFilterEan extends Model
{

    private $codename = "d_ajax_filter";

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->model('extension/module/' . $this->codename);
    }

    public function getEans($filter_data)
    {

        $sql = "SELECT e.ean_id, e.value
        FROM `" . DB_PREFIX . "af_temporary` aft
        INNER JOIN `" . DB_PREFIX . "af_product_ean` pe ON pe.product_id = aft.product_id
        INNER JOIN `" . DB_PREFIX . "af_ean` e ON e.ean_id = pe.ean_id
        GROUP BY pe.ean_id
        ORDER BY LCASE(e.value) ASC";
        $hash = md5(json_encode($filter_data));

        $result = $this->cache->get('af-ean.' . $hash);

        if (!$result) {
            $query = $this->db->query($sql);
            $result = $query->rows;
            $this->cache->set('af-ean.' . $hash, $result);
        }

        $ean_data = array();
        if (!empty($result)) {
            foreach ($result as $row) {
                $ean_data[$row['ean_id']] = $row;
            }
        }


        return $ean_data;
    }

    public function getTotalEan($data)
    {
        $data['params'] = $params = $this->{'model_extension_module_' . $this->codename}->getParamsToArray();

        $total_query = $this->{'model_extension_module_' . $this->codename}->getProductsQuery();
        $sql = "SELECT 'ean' as type, 0 as id, e.ean_id as val, COUNT(p.product_id) as c
        FROM " . DB_PREFIX . "af_ean e
        INNER JOIN " . DB_PREFIX . "af_product_ean pe
        ON e.ean_id = pe.ean_id
        INNER JOIN (" . $total_query . ") p
        ON pe.product_id = p.product_id ";
        if (!empty($params)) {
            unset($params['ean']);
            $result = $this->{'model_extension_module_' . $this->codename}->getParamsQuery($params);
            if (!empty($result)) {
                $sql .= " WHERE " . $result;
            }
        }
        $sql .= " GROUP BY e.ean_id";
        $sql .= " ORDER BY e.value";

        $hash = md5(json_encode($data));
        $result = $this->cache->get('af-total-ean.' . $hash);
        if (!$result) {
            $query = $this->db->query($sql);
            $result = $query->rows;
            $this->cache->set('af-total-ean.' . $hash, $result);
        }
        return $this->{'model_extension_module_' . $this->codename}->convertResultTotal($result);
    }

    public function getEan($ean_id)
    {
        $query = $this->db->query("SELECT e.ean_id, e.value as name FROM `" . DB_PREFIX . "af_ean` e WHERE e.ean_id = '" . (int)$ean_id . "'");
        return $query->row;
    }

    public function getTotalQuery($eans, $table_name)
    {
        $implode = array();
        $value_array = array();
        foreach ($eans[0] as $ean_id) {
            $implode[] = "FIND_IN_SET((" . $this->{'model_extension_module_' . $this->codename}->getValue('ean', '0', $ean_id) . ")," . $table_name . ".af_values)";
        }
        $sql = "";
        if (!empty($implode)) {
            $sql = implode(' OR ', $implode);
        }
        return $sql;
    }
}