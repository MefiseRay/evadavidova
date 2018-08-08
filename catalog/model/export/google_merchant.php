<?php

class ModelExportGoogleMerchant extends Model
{
    public function getCategory($category_id)
    {

        $query = $this->db->query("
			SELECT GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' / ') AS name, MAX(cp.level) AS lvl
			FROM " . DB_PREFIX . "category_path cp
			LEFT JOIN " . DB_PREFIX . "category c ON (cp.path_id = c.category_id)
			LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (c.category_id = cd1.category_id)
			LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id)
			WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "'
			AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'
			AND cd2.category_id = '" . (int)$category_id . "'
			GROUP BY cp.category_id ORDER BY cp.level DESC LIMIT 1"
        );

        return ($query->num_rows) ? $query->row : false;

    }

    public function getCategories($product_id)
    {

        $query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

        return ($query->num_rows) ? $query->rows : false;

    }

    public function getProduct($allowed_categories = 0, $out_of_stock_id, $vendor_required = true)
    {

        $sql = "SELECT p.*, pd.name, pd.description, m.name AS manufacturer, p2c.category_id, p.price AS price, ps.price as sale_price FROM " . DB_PREFIX . "product p JOIN " . DB_PREFIX . "product_to_category AS p2c ON (p.product_id = p2c.product_id) " . ($vendor_required ? '' : 'LEFT ') . "JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "product_special ps ON (p.product_id = ps.product_id) AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ps.date_start < NOW() AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()) WHERE";

        if ($allowed_categories) {
            $sql .= " p2c.category_id IN (" . $this->db->escape($allowed_categories) . ") AND";
        }

        $sql .= " p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1' AND (p.quantity > '0' OR p.stock_status_id != '" . (int)$out_of_stock_id . "') GROUP BY p.product_id";

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getProductImages($product_id)
    {
        $query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product_image WHERE product_id='" . $product_id . "' LIMIT 10");

        return $query->rows;
    }

}

?>
