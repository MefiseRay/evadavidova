<?php
class ModelExtensionDAjaxFilterStockStatus extends Model {

    private $codename="d_ajax_filter";

    public function __construct($registry) {
        parent::__construct($registry);
        $this->load->model('extension/module/'.$this->codename);
    }

    public function getStockStatuses($filter_data){
        $sql = "SELECT * FROM `".DB_PREFIX."stock_status` s WHERE s.language_id='".(int)$this->config->get('config_language_id')."' ORDER BY s.name ASC ";

        $hash = md5(json_encode($filter_data));

        $result = $this->cache->get('af-stock-status.' . $hash);

        if(!$result){
            $query = $this->db->query($sql);
            $result = $query->rows;
            $this->cache->set('af-stock-status.' .$hash , $result);
        }

        $stock_status_data = array();
        if(!empty($result)){
            foreach ($result as $row) {
                $stock_status_data[$row['stock_status_id']] = $row;
            }
        }

        return $stock_status_data;
    }

    public function getStockStatus($stock_status_id){
        $query = $this->db->query("SELECT * FROM `".DB_PREFIX."stock_status` WHERE `language_id` = '".(int)$this->config->get('config_language_id')."' AND `stock_status_id` = '".(int)$stock_status_id."'");

        return $query->row;
    }

    public function getTotalStockStatus($data){
        $data['params'] = $params = $this->{'model_extension_module_'.$this->codename}->getParamsToArray();

        $total_query = $this->{'model_extension_module_'.$this->codename}->getProductsQuery();
        $sql = "SELECT 'stock_status' as type, 0 as id, s.stock_status_id as val, COUNT(p.product_id) as c
        FROM ".DB_PREFIX."stock_status s
        INNER JOIN (".$total_query.") p
        ON s.stock_status_id = p.stock_status_id 
        WHERE s.language_id = '".(int)$this->config->get('config_language_id')."'";
        if (!empty($params)) {
            unset($params['stock_status']);
            $result = $this->{'model_extension_module_'.$this->codename}->getParamsQuery($params);
            if(!empty($result)){
                $sql.=" AND ".$result;
            }
        }
        $sql .=" GROUP BY s.stock_status_id";

        $hash = md5(json_encode($data));
        $result = $this->cache->get('af-total-stock-status.' . $hash);
        if(!$result){
            $query = $this->db->query($sql);
            $result = $query->rows;
            $this->cache->set('af-total-stock-status.' .$hash , $result);
        }

        return $this->{'model_extension_module_'.$this->codename}->convertResultTotal($result);
    }
    public function getTotalQuery($stock_statuses, $table_name){
        $sql = $table_name.".stock_status_id IN (".implode(',', $stock_statuses[0]).") ";
        return $sql;
    }
}