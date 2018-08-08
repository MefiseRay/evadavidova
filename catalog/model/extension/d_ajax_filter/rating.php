<?php

class ModelExtensionDAjaxFilterRating extends Model
{

    private $codename = "d_ajax_filter";

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->model('extension/module/' . $this->codename);
    }

    public function getTotalRating($data)
    {
        $data['params'] = $params = $this->{'model_extension_module_' . $this->codename}->getParamsToArray();

        $total_query = $this->{'model_extension_module_' . $this->codename}->getProductsQuery();
        $sql = "SELECT 'rating' as type, 0 as id, ROUND(p.rating) as val, COUNT(p.rating) as c
        FROM (" . $total_query . ") p";
        $sql .= " WHERE p.rating IS NOT NULL";
        if (!empty($params)) {
            unset($params['rating']);
            $result = $this->{'model_extension_module_' . $this->codename}->getParamsQuery($params);
            if (!empty($result)) {
                $sql .= " AND " . $result;
            }
        }
        $sql .= " GROUP BY ROUND(p.rating) ";

        $hash = md5(json_encode($data));

        $result = $this->cache->get('af-total-rating.' . $hash);
        if (!$result) {
            $query = $this->db->query($sql);
            $result = $query->rows;
            $this->cache->set('af-total-rating.' . $hash, $result);
        }
        return $this->{'model_extension_module_' . $this->codename}->convertResultTotal($result);
    }

    public function getTotalQuery($ratings, $table_name)
    {
        $sql = "ROUND(" . $table_name . ".rating) IN (" . implode(',', $ratings[0]) . ") ";
        return $sql;
    }
}