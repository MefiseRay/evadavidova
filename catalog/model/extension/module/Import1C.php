<?php

class ModelExtensionModuleImport1C extends Model
{

    public function clearDatabase()
    {

        // Attributes
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "attribute`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "attribute_description`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "attribute_group`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "attribute_group_description`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "attribute_presets`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "attribute_presets_description`");

        // Category
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "category`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "category_description`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "category_filter`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "category_path`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "category_to_layout`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "category_to_store`");
        $query = $this->db->query("DELETE FROM `" . DB_PREFIX . "url_alias` WHERE query LIKE 'category_id=%'");

        // Option
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "option`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "option_description`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "option_value`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "option_value_description`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product`");

        // Products
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "poip_main_option_settings`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "poip_option_image`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "poip_option_settings`");

        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product_attribute`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product_description`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product_discount`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product_filter`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product_image`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product_option`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product_option_value`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product_recurring`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product_related`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product_reward`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product_special`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product_to_category`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product_to_download`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product_to_layout`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "product_to_store`");

        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "relatedoptions`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "relatedoptions_discount`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "relatedoptions_option`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "relatedoptions_search`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "relatedoptions_special`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "relatedoptions_to_char`");
        //$query = $this->db->query("TRUNCATE `" . DB_PREFIX . "relatedoptions_variant`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "relatedoptions_variant_option`");
        $query = $this->db->query("TRUNCATE `" . DB_PREFIX . "relatedoptions_variant_product`");

        $query = $this->db->query("DELETE FROM `" . DB_PREFIX . "url_alias` WHERE query LIKE 'product_id=%'");

    }

    public function addCategoriesToProduct()
    {
        $sql = "SELECT p.product_id, p.1C_product_id FROM `" . DB_PREFIX . "product` p WHERE 1C_product_id != ''";

        $query = $this->db->query($sql);

        if ($query->num_rows) {
            foreach ($query->rows as $result) {
                $product_info_old = $this->db->query("SELECT po.product_id FROM `" . DB_PREFIX . "product_old` po WHERE 1C_product_id = '" . $result['1C_product_id'] . "'");

                if ($product_info_old->num_rows) {
                    $product_categories = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_to_category_old` p2co WHERE product_id = '" . $product_info_old->row['product_id'] . "'");

                    if ($product_categories->num_rows) {
                        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$result['product_id'] . "'");

                        foreach ($product_categories->rows as $product_category) {
                            //var_dump($product_category);
                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$result['product_id'] . "', category_id = '" . (int)$product_category['category_id'] . "', main_category = '" . (int)$product_category['main_category'] . "'");
                        }
                    }
                }
            }
        }

    }

    // Получение всех category_id таблицы oc_category
    public function getAllCategories()
    {
        $category_data = array();

        $sql = "SELECT category_id, 1C_category_id FROM `" . DB_PREFIX . "category` WHERE 1C_category_id != ''";

        $query = $this->db->query($sql);

        if ($query->num_rows) {
            foreach ($query->rows as $result) {
                $category_data[$result['1C_category_id']] = $result['category_id'];
            }
        }

        return $category_data;
    }

    // Добавление новой категории
    public function addCategory($data = array())
    {
        $parent_id = 0;

        if ($data['parent_id']) {
            $query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE 1C_category_id = '" . $data['parent_id'] . "'");
            if ($query->num_rows) {
                $parent_id = (int)$query->row['category_id'];
            }
        }

        $this->db->query("INSERT INTO `" . DB_PREFIX . "category` SET 1C_category_id = '" . $this->db->escape($data['id']) . "', sort_order = '0', parent_id='" . $parent_id . "', image='', status = '1', date_added = NOW(), date_modified = NOW()");

        $category_id = $this->db->getLastId();

        $this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "',  name = '" . $this->db->escape($data['name']) . "', language_id='1'");

        $this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '0'");

        $level = 0;

        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$parent_id . "' ORDER BY `level` ASC");

        foreach ($query->rows as $result) {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

            $level++;
        }

        $this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', `level` = '" . (int)$level . "'");

        if (isset($data['keyword'])) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
        }

        return $category_id;
    }

    // Обновление категории
    public function updateCategory($data = array(), $category_id = 0)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "category_description SET name = '" . $this->db->escape($data['name']) . "' WHERE category_id = '" . (int)$category_id . "' AND language_id = '1'");
    }

    // Получение всех записей таблицы oc_attribute
    public function getAllAttributes()
    {

        $attribute_data = array();

        $sql = "SELECT DISTINCT attribute_id, 1C_attribute_id FROM `" . DB_PREFIX . "attribute` WHERE 1C_attribute_id != ''";

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $attribute_data[$result['1C_attribute_id']] = $result['attribute_id'];
        }

        return $attribute_data;
    }

    // Добавление атрибута
    public function addAttribute($data = array(), $attribute_group_id = 1)
    {

        $this->db->query("INSERT IGNORE INTO `" . DB_PREFIX . "attribute_group` SET attribute_group_id = '" . $attribute_group_id . "', sort_order = '0'");
        $this->db->query("INSERT IGNORE INTO `" . DB_PREFIX . "attribute_group_description` SET attribute_group_id = '" . $attribute_group_id . "', language_id = '1', name = 'Характеристики'");

        $this->db->query("INSERT INTO `" . DB_PREFIX . "attribute` SET 1C_attribute_id = '" . $this->db->escape($data['id']) . "', attribute_group_id = '" . (int)$attribute_group_id . "', sort_order = '0'");

        $attribute_id = $this->db->getLastId();

        $this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "',  name = '" . $this->db->escape($data['name']) . "', language_id = '1'");

        return $attribute_id;

    }

    // Обновление атрибута
    public function updateAttribute($data = array(), $attribute_id = 0)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "attribute_description SET name = '" . $this->db->escape($data['name']) . "' WHERE attribute_id = '" . (int)$attribute_id . "' AND language_id = '1'");
    }

    // Получение всех preset_id таблицы oc_attribute_presets
    public function getAllAttributePresets()
    {

        $attribute_preset_data = array();

        $sql = "SELECT DISTINCT preset_id, 1C_preset_id FROM `" . DB_PREFIX . "attribute_presets` WHERE 1C_preset_id != ''";

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $attribute_preset_data[$result['1C_preset_id']] = $result['preset_id'];
        }

        return $attribute_preset_data;
    }

    // Добавление значения атрибута
    public function addAttributePreset($data = array(), $attribute_id = 0)
    {

        $this->db->query("INSERT INTO `" . DB_PREFIX . "attribute_presets` SET 1C_preset_id = '" . $this->db->escape($data['id']) . "', attribute_id = '" . $attribute_id . "'");

        $preset_id = $this->db->getLastId();

        $this->db->query("INSERT INTO " . DB_PREFIX . "attribute_presets_description SET preset_id = '" . (int)$preset_id . "',  text = '" . $this->db->escape($data['text']) . "', language_id = '1'");

        return $preset_id;
    }

    // Обновление значения атрибута
    public function updateAttributePreset($data = array(), $preset_id = 0)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "attribute_presets_description SET text = '" . $this->db->escape($data['text']) . "' WHERE preset_id = '" . (int)$preset_id . "' AND language_id = '1'");
    }

    // Получение option_id опции Цвет
    public function getColorOptionId()
    {

        $query = $this->db->query("SELECT option_id FROM `" . DB_PREFIX . "option_description` WHERE name = 'Цвет' AND language_id='1'");

        if ($query->num_rows) {

            $option_id = (int)$query->row['option_id'];

        } else {

            $option_id = 1;

            $this->db->query("INSERT INTO `" . DB_PREFIX . "option` SET option_id = '" . (int)$option_id . "', type = 'radio', sort_order = '1'");

            $this->db->query("INSERT INTO " . DB_PREFIX . "option_description SET option_id = '" . (int)$option_id . "', language_id = '1', name = 'Цвет'");

        }

        return $option_id;
    }

    public function getSizeOptionId()
    {

        $query = $this->db->query("SELECT option_id FROM `" . DB_PREFIX . "option_description` WHERE name = 'Размер' AND language_id='1'");

        if ($query->num_rows) {

            $option_id = (int)$query->row['option_id'];

        } else {

            $option_id = 2;

            $this->db->query("INSERT INTO `" . DB_PREFIX . "option` SET option_id = '" . (int)$option_id . "', type = 'radio', sort_order = '1'");

            $this->db->query("INSERT INTO " . DB_PREFIX . "option_description SET option_id = '" . (int)$option_id . "', language_id = '1', name = 'Размер'");

        }

        return $option_id;
    }

    // Получение всех option_value_id таблицы oc_option_value, относящихся к опции Цвет
    public function getOptionValues($option_id = 0)
    {

        $option_value_data = array();

        $sql = "SELECT option_value_id, 1C_option_value_id FROM `" . DB_PREFIX . "option_value` WHERE option_id = '" . (int)$option_id . "'";

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $option_value_data[$result['1C_option_value_id']] = $result['option_value_id'];
        }

        return $option_value_data;
    }

    // Добавление значения опции Цвет/Размер
    public function addOptionValue($data = array(), $option_id, $sort_order = 0)
    {

        $this->db->query("INSERT INTO `" . DB_PREFIX . "option_value` SET 1C_option_value_id = '" . $this->db->escape($data['id']) . "', option_id = '" . $option_id . "', sort_order = '" . $sort_order . "'");

        $option_value_id = $this->db->getLastId();

        $this->db->query("INSERT INTO " . DB_PREFIX . "option_value_description SET option_value_id = '" . (int)$option_value_id . "', option_id = '" . $option_id . "',  name = '" . $this->db->escape($data['name']) . "', language_id = '1'");

        return $option_value_id;
    }

    // Обновление значения опции
    public function updateOptionValue($data = array(), $option_value_id = 0, $sort_order = 0)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "option_value SET sort_order = '" . $sort_order . "' WHERE option_value_id = '" . (int)$option_value_id . "'");
        $this->db->query("UPDATE " . DB_PREFIX . "option_value_description SET name = '" . $this->db->escape($data['name']) . "' WHERE option_value_id = '" . (int)$option_value_id . "' AND language_id = '1'");
    }

    // Получение всех manufacturer_id таблицы oc_manufacturer
    public function getAllManufacturers()
    {
        $manufacturer_data = array();

        $sql = "SELECT manufacturer_id, 1C_manufacturer_id FROM `" . DB_PREFIX . "manufacturer` WHERE 1C_manufacturer_id != ''";

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $manufacturer_data[$result['1C_manufacturer_id']] = $result['manufacturer_id'];
        }

        return $manufacturer_data;
    }

    // Добавление производителя
    public function addManufacturer($data = array())
    {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "manufacturer` SET 1C_manufacturer_id = '" . $this->db->escape($data['id']) . "', name = '" . $data['name'] . "', sort_order = '0'");

        $manufacturer_id = $this->db->getLastId();

        $this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_description SET manufacturer_id = '" . (int)$manufacturer_id . "',  meta_h1 = '" . $this->db->escape($data['name']) . "', language_id = '1'");

        $this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_smp SET manufacturer_id = '" . (int)$manufacturer_id . "',  name = '" . $this->db->escape($data['name']) . "', language_id = '1'");

        $this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . (int)$manufacturer_id . "', store_id = '0'");

        if (isset($data['keyword'])) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$manufacturer_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
        }

        return $manufacturer_id;
    }

    // Обновление производителя
    public function updateManufacturer($data = array(), $manufacturer_id = 0)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "manufacturer_description SET meta_h1 = '" . $this->db->escape($data['name']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "' AND language_id = '1'");

        $this->db->query("UPDATE " . DB_PREFIX . "manufacturer_smp SET name = '" . $this->db->escape($data['name']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "' AND language_id = '1'");
    }

    // Получение всех записей таблицы oc_product
    /*public function getAllProducts(){
        $product_data = array();
        
        $sql = "SELECT DISTINCT product_id, 1C_product_id FROM `".DB_PREFIX ."product` WHERE 1C_product_id !=''";
        
        $query = $this->db->query($sql);
		
		foreach ($query->rows as $result) {
			$product_data[$result['1C_product_id']] = $result['product_id'];
		}
		
		return $product_data;
    }
    */

    // Получение всех моделей таблицы oc_product
    public function getAllProducts()
    {
        $product_data = array();

        $sql = "SELECT DISTINCT model, 1C_product_id FROM `" . DB_PREFIX . "product` WHERE 1C_product_id !=''";

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $product_data[$result['1C_product_id']] = $result['model'];
        }

        return $product_data;
    }

    public function getProduct($model = '', $id = 0)
    {
        $product_data = $this->db->query("SELECT product_id FROM `" . DB_PREFIX . "product` WHERE model ='" . $model . "' AND 1C_product_id = '" . $id . "'");

        if ($product_data->num_rows) {
            return $product_data->row['product_id'];
        }
    }

    public function getProductsByModel($model = '', $main_product_id = 0, $id = 0)
    {
        $offer_data = array();

        $query_rovp = $this->db->query("SELECT ROVP.* FROM 	`" . DB_PREFIX . "relatedoptions_variant_product` ROVP WHERE ROVP.product_id = '" . (int)$main_product_id . "'");

        $relatedoptions_variant_product_id = $query_rovp->row['relatedoptions_variant_product_id'];

        $query = $this->db->query("SELECT product_id FROM `" . DB_PREFIX . "product` WHERE model ='" . $model . "' AND 1C_product_id != '" . $id . "'");

        //echo "SELECT product_id FROM `".DB_PREFIX ."product` WHERE model ='" . $model . "' AND 1C_product_id != '" . $id . "'";

        if ($query->num_rows) {

            $product_option_data = array();

            $product_related_option_data = array();

            $product_images = array();

            $product_option_image_settings = array();

            $product_option_images = array();

            foreach ($query->rows as $product) {

                $product_id = $product['product_id'];

                $product_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

                foreach ($product_option_query->rows as $product_option) {
                    $product_option_value_data = array();

                    $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON(pov.option_value_id = ov.option_value_id) WHERE pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' ORDER BY ov.sort_order ASC");

                    foreach ($product_option_value_query->rows as $product_option_value) {

                        $product_option_image_query = $this->db->query("SELECT DISTINCT * FROM `" . DB_PREFIX . "poip_option_image` WHERE product_id = '" . (int)$product_id . "' AND product_option_id = '" . $product_option['product_option_id'] . "' AND product_option_value_id='" . $product_option_value['product_option_value_id'] . "'");

                        if ($product_option_image_query->num_rows) {
                            $poip = $product_option_image_query->rows;
                        } else {
                            $poip = array();
                        }

                        $product_option_value_data[] = array(
                            'product_option_value_id' => $product_option_value['product_option_value_id'],
                            'option_value_id' => $product_option_value['option_value_id'],
                            'quantity' => $product_option_value['quantity'],
                            'subtract' => $product_option_value['subtract'],
                            'price' => $product_option_value['price'],
                            'price_prefix' => $product_option_value['price_prefix'],
                            'points' => $product_option_value['points'],
                            'points_prefix' => $product_option_value['points_prefix'],
                            'weight' => $product_option_value['weight'],
                            'weight_prefix' => $product_option_value['weight_prefix'],
                            'thumb' => $product_option_value['thumb'],
                            'poip' => $poip

                        );
                    }

                    $product_option_data[] = array(
                        'product_option_id' => $product_option['product_option_id'],
                        'option_id' => $product_option['option_id'],
                        'name' => $product_option['name'],
                        'type' => $product_option['type'],
                        'value' => $product_option['value'],
                        'required' => $product_option['required'],
                        'product_option_value' => $product_option_value_data,
                    );


                }


                $product_related_option_query = $this->db->query("SELECT DISTINCT * FROM `" . DB_PREFIX . "relatedoptions` WHERE product_id = '" . (int)$product_id . "'");

                //echo "SELECT DISTINCT * FROM `" . DB_PREFIX . "relatedoptions` WHERE product_id = '" . (int)$product_id . "'";

                foreach ($product_related_option_query->rows as $product_related_option) {

                    $product_related_option_value_data = array();

                    $product_related_option_value_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "relatedoptions_option` WHERE product_id = '" . (int)$product_id . "' AND relatedoptions_id = '" . (int)$product_related_option['relatedoptions_id'] . "'");

                    foreach ($product_related_option_value_query->rows as $product_related_option_value) {
                        $product_related_option_value_data[] = array(
                            'option_id' => $product_related_option_value['option_id'],
                            'option_value_id' => $product_related_option_value['option_value_id']
                        );
                    }

                    $product_related_option_data[] = array(
                        '1C_product_id' => $product_related_option['1C_product_id'],
                        'model' => $product_related_option['model'],
                        'sku' => $product_related_option['sku'],
                        'quantity' => $product_related_option['quantity'],
                        'price' => $product_related_option['price'],
                        'product_related_option_value' => $product_related_option_value_data,
                        'relatedoptions_variant_product_id' => $relatedoptions_variant_product_id
                    );

                }

                // POIP
                //$product_option_image_settings_query = $this->db->query("SELECT DISTINCT * FROM `" . DB_PREFIX . "poip_option_settings` WHERE product_id = '" . (int)$product_id . "'");                


            }

            return array(
                'product_option' => $product_option_data,
                'product_related_option' => $product_related_option_data,
                //'product_option_image_settings' => $product_option_image_settings_query->rows,
                // 'product_option_image' => $product_option_image_query->rows
            );
        }

    }


    public function addProductOptions($product_id = 0, $data = array())
    {

        if (isset($data)) {

            foreach ($data as $product_option) {
                if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                    if (isset($product_option['product_option_value'])) {

                        $product_option_query = $this->db->query("SELECT product_option_id FROM `" . DB_PREFIX . "product_option` WHERE product_id = '" . (int)$product_id . "' AND option_id = '" . (int)$product_option['option_id'] . "'");

                        if ($product_option_query->num_rows) {

                            $product_option_id = $product_option_query->row['product_option_id'];

                        } else {
                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");

                            $product_option_id = $this->db->getLastId();

                        }

                        foreach ($product_option['product_option_value'] as $product_option_value) {

                            $product_option_value_query = $this->db->query("SELECT product_option_value_id FROM " . DB_PREFIX . "product_option_value WHERE product_option_id = '" . (int)$product_option_id . "' AND product_id = '" . (int)$product_id . "' AND option_id = '" . (int)$product_option['option_id'] . "' AND option_value_id = '" . (int)$product_option_value['option_value_id'] . "'");

                            if (!$product_option_value_query->num_rows) {
                                //var_dump($product_option_value);

                                $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', thumb = '" . $product_option_value['thumb'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");

                                if (count($product_option_value['poip'])) {
                                    $product_option_value_id = $this->db->getLastId();

                                    foreach ($product_option_value['poip'] as $poip) {
                                        $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "poip_option_image SET product_id = '" . (int)$product_id . "', product_option_id = '" . (int)$product_option_id . "', product_option_value_id = '" . (int)$product_option_value_id . "', image = '" . $poip['image'] . "', sort_order = '" . $poip['sort_order'] . "'");
                                    }

                                }


                            } else {
                                $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET thumb = '" . $product_option_value['thumb'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', price = '" . (float)$product_option_value['price'] . "' WHERE product_option_value_id = '" . (int)$product_option_value_query->row['product_option_value_id'] . "'");

                                if (count($product_option_value['poip'])) {

                                    //$this->db->query("DELETE FROM " . DB_PREFIX . "poip_option_image WHERE product_id = '" . (int)$product_id . "' AND product_option_id = '" . (int)$product_option_id . "' AND product_option_value_id = '" . (int)$product_option_value_query->row['product_option_value_id'] . "'");

                                    foreach ($product_option_value['poip'] as $poip) {
                                        if ($poip['image']) {
                                            $product_option_image_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "poip_option_image` WHERE product_id = '" . (int)$product_id . "' AND product_option_id = '" . (int)$product_option_id . "' AND product_option_value_id = '" . (int)$product_option_value_query->row['product_option_value_id'] . "' AND image = '" . $poip['image'] . "'");

                                            if (!$product_option_image_query->num_rows) {
                                                $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "poip_option_image SET product_id = '" . (int)$product_id . "', product_option_id = '" . (int)$product_option_id . "', product_option_value_id = '" . (int)$product_option_value_query->row['product_option_value_id'] . "', image = '" . $poip['image'] . "', sort_order = '" . $poip['sort_order'] . "'");
                                            }
                                        }
                                    }

                                }

                            }
                        }
                    }
                }
            }

        }
    }

    public function addProductRelatedOptions($product_id = 0, $data = array())
    {

        if (isset($data)) {
            foreach ($data as $product_option) {

                $product_relatedoptions_option_query = $this->db->query("SELECT relatedoptions_id FROM `" . DB_PREFIX . "relatedoptions` WHERE product_id = '" . (int)$product_id . "' AND sku = '" . $product_option['sku'] . "'");

                if (!$product_relatedoptions_option_query->num_rows) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "relatedoptions SET relatedoptions_variant_product_id = '" . (int)$product_option['relatedoptions_variant_product_id'] . "', product_id = '" . (int)$product_id . "', 1C_product_id = '" . $product_option['1C_product_id'] . "', model = '" . $product_option['model'] . "', sku = '" . $product_option['sku'] . "', quantity = '" . $product_option['quantity'] . "', price = '" . $product_option['price'] . "', price_prefix = '='");

                    $relatedoptions_id = $this->db->getLastId();

                    foreach ($product_option['product_related_option_value'] as $product_option_value) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "relatedoptions_option SET relatedoptions_id = '" . $relatedoptions_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option_value['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "'");
                    }
                } else {
                    $relatedoptions_id = $product_relatedoptions_option_query->row['relatedoptions_id'];

                    $this->db->query("UPDATE " . DB_PREFIX . "relatedoptions SET quantity = '" . $product_option['quantity'] . "', price = '" . $product_option['price'] . "' WHERE relatedoptions_id = '" . $relatedoptions_id . "'");

                }
            }
        }

    }

    // Добавление товара
    public function addProduct($data = array())
    {
        //var_dump($this->db->escape($data['name']) . ' - ' . (float)$data['price']);
        $this->db->query("INSERT INTO `" . DB_PREFIX . "product` SET 1C_product_id = '" . $this->db->escape($data['id']) . "', price = '" . (float)$data['price'] . "', model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', quantity = '" . (int)$data['quantity'] . "', stock_status_id = '5', sort_order = '1',  date_added = NOW(), date_modified = NOW(), status = '" . (int)$data['status'] . "'");

        $product_id = $this->db->getLastId();

        $product_images = array();

        if (isset($data['product_image'])) {

            $product_images = $data['product_image'];

            $main_image = array_shift($data['product_image']);

            $this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($main_image) . "' WHERE product_id = '" . (int)$product_id . "'");

            $sort_order = 0;
            foreach ($data['product_image'] as $product_image) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape($product_image) . "', sort_order = '" . $sort_order++ . "'");
            }
        }

        if ($data['quantity'] <= 0) {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET status = '0' WHERE product_id = '" . (int)$product_id . "'");
        }

        if (isset($data['manufacturer_id'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET manufacturer_id = '" . (int)$data['manufacturer_id'] . "' WHERE product_id = '" . (int)$product_id . "'");
        }

        if (isset($data['minimum'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET minimum = '" . ($data['minimum'] ? (int)$data['minimum'] : 1) . "' WHERE product_id = '" . (int)$product_id . "'");
        }

        $this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '1', name = '" . $this->db->escape($data['name']) . "', description = '" . $this->db->escape($data['description']) . "', meta_title = '" . $this->db->escape($data['name']) . "', meta_h1 = '" . $this->db->escape($data['name']) . "'");

        $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id='" . (int)$product_id . "', store_id = '0'");

        if (isset($data['product_category'])) {
            foreach ($data['product_category'] as $category_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
            }
        }

        if (isset($data['product_category'][0])) {
            $this->db->query("UPDATE " . DB_PREFIX . "product_to_category SET main_category = 1 WHERE product_id = '" . (int)$product_id . "' AND category_id = '" . (int)$data['product_category'][0] . "'");
        }

        if (isset($data['keyword'])) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
        }

        if (isset($data['product_attribute'])) {

            foreach ($data['product_attribute'] as $product_attribute) {
                if ($product_attribute['attribute_id']) {

                    if (isset($product_attribute['preset_id']) && $product_attribute['preset_id']) {
                        $query = $this->db->query("SELECT text FROM " . DB_PREFIX . "attribute_presets_description WHERE preset_id = '" . (int)$product_attribute['preset_id'] . "' AND language_id = '1'");

                        if ($query->num_rows) {
                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', preset_id = '" . (int)$product_attribute['preset_id'] . "', language_id = '1', text = '" . $this->db->escape($query->row['text']) . "'");
                        }
                    } else if (isset($product_attribute['text']) && $product_attribute['text']) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '1', text = '" . $this->db->escape($product_attribute['text']) . "'");
                    }
                }
            }
        }

        if (isset($data['product_option'])) {

            $this->db->query("INSERT INTO " . DB_PREFIX . "relatedoptions_variant_product SET relatedoptions_variant_id = '1', product_id = '" . (int)$product_id . "', relatedoptions_use = '1'");

            $relatedoptions_variant_product_id = $this->db->getLastId();

            foreach ($data['product_option'] as $product_option) {

                $this->db->query("INSERT INTO " . DB_PREFIX . "relatedoptions SET relatedoptions_variant_product_id = '" . (int)$relatedoptions_variant_product_id . "', product_id = '" . (int)$product_id . "', 1C_product_id = '" . $product_option['1C_product_id'] . "', model = '" . $product_option['model'] . "', sku = '" . $product_option['sku'] . "', quantity = '" . $product_option['quantity'] . "', price = '" . $product_option['price'] . "', price_prefix = '='");

                $relatedoptions_id = $this->db->getLastId();

                if (isset($product_option['product_option_value'])) {
                    foreach ($product_option['product_option_value'] as $option_id => $product_option_value) {
                        // Options
                        $query = $this->db->query("SELECT product_option_id FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "' AND option_id = '" . (int)$option_id . "' LIMIT 1");

                        if (!$query->num_rows) {
                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$option_id . "', required = '1'");
                            $product_option_id = $this->db->getLastId();

                            if (isset($data['product_image'])) {
                                $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "poip_option_settings 
                                SET product_id = '" . (int)$product_id . "', 
                                    product_option_id = '" . (int)$product_option_id . "',
                                    img_change = '0',
                                    img_use = '0',
                                    img_limit = '0',
                                    img_gal = '0',
                                    img_option = '0',
                                    img_category = '0',
                                    img_first = '0',
                                    img_from_option = '0',
                                    img_sort = '0',
                                    img_select = '0',
                                    img_cart = '0',
                                    img_radio_checkbox = '0',
                                    dependent_thumbnails = '0',
                                    img_hover = '0'");
                            }

                        } else {
                            $product_option_id = $query->row['product_option_id'];
                        }

                        $query = $this->db->query("SELECT product_option_value_id FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "' AND option_id = '" . (int)$option_id . "' AND option_value_id = '" . (int)$product_option_value . "' LIMIT 1");

                        if (!$query->num_rows) {
                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$option_id . "', option_value_id = '" . (int)$product_option_value . "', quantity = '" . (int)$product_option['quantity'] . "'");
                        } else {
                            $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = quantity + " . (int)$product_option['quantity'] . " WHERE product_option_id = '" . (int)$product_option_id . "' AND product_id = '" . (int)$product_id . "' AND option_id = '" . (int)$option_id . "' AND option_value_id = '" . (int)$product_option_value . "'");
                        }

                        $product_option_value_id = $this->db->getLastId();

                        if ($product_option_value == $data['product_color_option_value']) {
                            $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET default_value = 1 WHERE product_option_id = '" . (int)$product_option_id . "' AND product_id = '" . (int)$product_id . "' AND option_id = '" . (int)$option_id . "' AND option_value_id = '" . (int)$product_option_value . "'");

                            if ($data['product_color_image']) {
                                $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET thumb = '" . $data['product_color_image'] . "' WHERE product_option_id = '" . (int)$product_option_id . "' AND product_id = '" . (int)$product_id . "' AND option_id = '" . (int)$option_id . "' AND option_value_id = '" . (int)$product_option_value . "'");
                            }

                            // Image Pro
                            if (count($product_images) && $product_option_value_id != 0) {
                                $this->addImageForOptionValue($product_id, $product_option_id, $product_option_value_id, $product_images);
                            }

                        }

                        // Related
                        $this->db->query("INSERT INTO " . DB_PREFIX . "relatedoptions_option SET relatedoptions_id = '" . $relatedoptions_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$option_id . "', option_value_id = '" . (int)$product_option_value . "'");
                    }
                }
            }
        }

        return $product_id;
    }

    // 
    public function addImageForOptionValue($product_id, $product_option_id, $product_option_value_id, $product_image = array())
    {
        $sort_order = 0;
        foreach ($product_image as $product_image) {
            $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "poip_option_image SET product_id = '" . (int)$product_id . "', product_option_id = '" . (int)$product_option_id . "', product_option_value_id = '" . (int)$product_option_value_id . "', image = '" . $product_image . "', sort_order = '" . $sort_order++ . "'");
        }
    }

    // Отключение товаров
    public function deactivateAllProducts()
    {

        $this->db->query("UPDATE " . DB_PREFIX . "product SET status = '0'");

        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = '0'");
    }

    // Обновление товара
    public function updateProduct($data = array(), $id = '', $option_id = 0)
    {
        $product_query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE 1C_product_id = '" . $id . "'");

        if ($product_query->num_rows) {
            $product_id = $product_query->row['product_id'];
        } else {
            $product_id = 0;
        }

        //var_dump($data);

        if ($product_id) {

            $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . $data['price'] . "', quantity = '" . $data['quantity'] . "', status = '" . ($data['quantity'] > 0 ? 1 : 0) . "', date_modified = NOW() WHERE product_id = '" . $product_id . "'");

            if (isset($data['product_image']) && count($data['product_image'])) {

                $product_images = $data['product_image'];

                $main_image = array_shift($data['product_image']);

                $this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($main_image) . "' WHERE product_id = '" . (int)$product_id . "'");

                $this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");

                $sort_order = 0;
                foreach ($data['product_image'] as $product_image) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape($product_image) . "', sort_order = '" . $sort_order++ . "'");
                }
            }

            $this->db->query("UPDATE " . DB_PREFIX . "product_description SET name = '" . $this->db->escape($data['name']) . "', description = '" . $this->db->escape($data['description']) . "', meta_title = '" . $this->db->escape($data['name']) . "', meta_h1 = '" . $this->db->escape($data['name']) . "' WHERE product_id = '" . (int)$product_id . "' AND language_id = '1'");


            if (isset($data['product_attribute'])) {

                $this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");

                foreach ($data['product_attribute'] as $product_attribute) {
                    if ($product_attribute['attribute_id']) {

                        if (isset($product_attribute['preset_id']) && $product_attribute['preset_id']) {
                            $query = $this->db->query("SELECT text FROM " . DB_PREFIX . "attribute_presets_description WHERE preset_id = '" . (int)$product_attribute['preset_id'] . "' AND language_id = '1'");

                            if ($query->num_rows) {
                                $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', preset_id = '" . (int)$product_attribute['preset_id'] . "', language_id = '1', text = '" . $this->db->escape($query->row['text']) . "'");
                            }
                        } else if (isset($product_attribute['text']) && $product_attribute['text']) {
                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '1', text = '" . $this->db->escape($product_attribute['text']) . "'");
                        }
                    }
                }
            }

            if (isset($data['product_option']) && count($data['product_option'])) {

                //$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
                //$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");

                $relatedoptions_variant_product = $this->db->query("SELECT relatedoptions_variant_product_id FROM " . DB_PREFIX . "relatedoptions_variant_product WHERE relatedoptions_variant_id = '1' AND product_id = '" . (int)$product_id . "' LIMIT 1");

                $relatedoptions_variant_product_id = $relatedoptions_variant_product->row['relatedoptions_variant_product_id'];

                foreach ($data['product_option'] as $product_option) {

                    $relatedoptions = $this->db->query("SELECT relatedoptions_id FROM " . DB_PREFIX . "relatedoptions WHERE sku = '" . $product_option['sku'] . "'");

                    if ($relatedoptions->num_rows) {

                        foreach ($relatedoptions->rows as $relatedoptions) {

                            $relatedoptions_id = $relatedoptions['relatedoptions_id'];

                            $this->db->query("UPDATE " . DB_PREFIX . "relatedoptions SET quantity = '" . $product_option['quantity'] . "', price = '" . $product_option['price'] . "' WHERE sku = '" . $product_option['sku'] . "' AND relatedoptions_id = '" . $relatedoptions_id . "'");

                        }

                    } else {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "relatedoptions SET relatedoptions_variant_product_id = '" . (int)$relatedoptions_variant_product_id . "', product_id = '" . (int)$product_id . "', 1C_product_id = '" . $product_option['1C_product_id'] . "', model = '" . $product_option['model'] . "', sku = '" . $product_option['sku'] . "', quantity = '" . $product_option['quantity'] . "', price = '" . $product_option['price'] . "', price_prefix = '='");

                        $relatedoptions_id = $this->db->getLastId();

                    }


                    if (isset($product_option['product_option_value'])) {
                        foreach ($product_option['product_option_value'] as $option_id => $product_option_value) {
                            // Options
                            $query = $this->db->query("SELECT product_option_id FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "' AND option_id = '" . (int)$option_id . "' LIMIT 1");

                            if (!$query->num_rows) {

                                $this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$option_id . "', required = '1'");
                                $product_option_id = $this->db->getLastId();

                                if (isset($data['product_image'])) {
                                    $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "poip_option_settings 
									SET product_id = '" . (int)$product_id . "', 
										product_option_id = '" . (int)$product_option_id . "',
										img_change = '0',
										img_use = '0',
										img_limit = '0',
										img_gal = '0',
										img_option = '0',
										img_category = '0',
										img_first = '0',
										img_from_option = '0',
										img_sort = '0',
										img_select = '0',
										img_cart = '0',
										img_radio_checkbox = '0',
										dependent_thumbnails = '0',
										img_hover = '0'");
                                }

                            } else {
                                $product_option_id = $query->row['product_option_id'];
                            }

                            $query_roduct_option_value = $this->db->query("SELECT product_option_value_id FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "' AND option_id = '" . (int)$option_id . "' AND option_value_id = '" . (int)$product_option_value . "' LIMIT 1");

                            if (!$query_roduct_option_value->num_rows) {

                                $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$option_id . "', option_value_id = '" . (int)$product_option_value . "', quantity = '" . (int)$product_option['quantity'] . "'");

                                $product_option_value_id = $this->db->getLastId();

                            } else {
                                $product_option_value_id = $query_roduct_option_value->row['product_option_value_id'];

                                $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = quantity + " . (int)$product_option['quantity'] . " WHERE product_option_value_id = '" . $product_option_value_id . "'");
                            }

                            if ($product_option_value == $data['product_color_option_value']) {
                                $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET default_value = 1 WHERE product_option_id = '" . (int)$product_option_id . "' AND product_id = '" . (int)$product_id . "' AND option_id = '" . (int)$option_id . "' AND option_value_id = '" . (int)$product_option_value . "'");

                                if ($data['product_color_image']) {
                                    $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET thumb = '" . $data['product_color_image'] . "' WHERE product_option_id = '" . (int)$product_option_id . "' AND product_id = '" . (int)$product_id . "' AND option_id = '" . (int)$option_id . "' AND option_value_id = '" . (int)$product_option_value . "'");
                                }

                                // Image Pro
                                if (count($product_images) && $product_option_value_id != 0) {
                                    $this->db->query("DELETE FROM " . DB_PREFIX . "poip_option_image WHERE product_id = '" . (int)$product_id . "' AND product_option_id = '" . (int)$product_option_id . "' AND product_option_value_id = '" . (int)$product_option_value_id . "'");

                                    $this->addImageForOptionValue($product_id, $product_option_id, $product_option_value_id, $product_images);
                                }

                            }

                            // Related
                            //$this->db->query("INSERT INTO " . DB_PREFIX . "relatedoptions_option SET relatedoptions_id = '" . $relatedoptions_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$option_id . "', option_value_id = '" . (int)$product_option_value . "'");
                        }
                    }
                }
            }


            if (isset($data['product_option_value_id'])) {
                $query = $this->db->query("SELECT product_id FROM `" . DB_PREFIX . "product` WHERE 1C_product_id = '" . $id . "'");

                if ($query->num_rows) {

                    $product_id = (int)$query->row['product_id'];

                    $query = $this->db->query("SELECT product_option_value_id FROM `" . DB_PREFIX . "product_option_value` WHERE product_id = '" . (int)$product_id . "' AND option_id = '" . $option_id . "' AND option_value_id = '" . $data['product_option_value_id'] . "'");

                    if ($query->num_rows) {

                        $product_option_value_id = (int)$query->row['product_option_value_id'];

                        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = '" . (int)$data['quantity'] . "', price = '" . (float)$data['price'] . "' WHERE product_option_value_id = '" . $product_option_value_id . "'");
                    } else {
                        $query = $this->db->query("SELECT product_option_id FROM `" . DB_PREFIX . "product_option` WHERE product_id = '" . $product_id . "' AND option_id = '" . $option_id . "'");

                        if ($query->num_rows) {
                            $product_option_id = (int)$query->row['product_option_id'];

                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$option_id . "', option_value_id = '" . (int)$data['product_option_value_id'] . "', quantity = '" . (int)$data['quantity'] . "', subtract = '1', price = '" . (float)$data['price'] . "', price_prefix = '=', points = '0', points_prefix = '=', weight = '0', weight_prefix = '='");

                            $product_option_value_id = $this->db->getLastId();

                            if (isset($data['image'])) {

                                $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape($data['image']) . "', sort_order = '1'");

                                $this->db->query("INSERT INTO " . DB_PREFIX . "poip_option_image SET product_id = '" . (int)$product_id . "', product_option_id = '" . (int)$product_option_id . "', product_option_value_id = '" . (int)$product_option_value_id . "', image = '" . $this->db->escape($data['image']) . "', sort_order = '1'");
                            }

                        }
                    }
                }
            } else {
                $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$data['quantity'] . "', price = '" . (float)$data['price'] . "', minimum = '" . (isset($data['minimum']) && $data['minimum'] ? (int)$data['minimum'] : 1) . "', date_modified = NOW() WHERE 1C_product_id = '" . $id . "'");
            }
        }
    }

    public function get1CProductId($order_id = 0, $order_product_id = 0, $product_id = 0, $price = 0)
    {
        $product_data = $options = $input = array();

        $this->load->model('account/order');

        $query_order = $this->db->query("SELECT pov.option_value_id FROM " . DB_PREFIX . "order_option oo LEFT JOIN  " . DB_PREFIX . "product_option_value pov ON (oo.product_option_value_id = pov.product_option_value_id) WHERE oo.order_id = '" . (int)$order_id . "' AND oo.order_product_id = '" . (int)$order_product_id . "'");
        if ($query_order->num_rows) {

            foreach ($query_order->rows as $option) {
                $options[] = $option["option_value_id"];
            }

            if (count($options)) {
                $query_id = $this->db->query("SELECT relatedoptions_id FROM " . DB_PREFIX . "relatedoptions_option WHERE product_id = '" . $product_id . "' AND option_value_id IN (" . implode(",", $options) . ")");

                foreach ($query_id->rows as $id) {
                    $input[] = $id["relatedoptions_id"];
                }

                $array_counts = array_count_values($input);

                $flip = array_flip($array_counts);

                foreach ($flip as $key => $value) {
                    if ($key > 1) {
                        $relatedoptions_id = $value;
                    }
                }

                $query_sku = $this->db->query("SELECT price, sku FROM " . DB_PREFIX . "relatedoptions WHERE relatedoptions_id = '" . (int)$relatedoptions_id . "'");

                $product_1C_id = explode('#', $query_sku->row['sku']);

                $query_product = $this->db->query("SELECT pd.name FROM " . DB_PREFIX . "product p LEFT JOIN  " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND 1C_product_id = '" . $product_1C_id[0] . "'");

                $query_special = $this->db->query("SELECT * FROM " . DB_PREFIX . "relatedoptions_special WHERE relatedoptions_id = '" . (int)$relatedoptions_id . "' AND price = '" . $price . "'");


                if ($query_special->num_rows) {
                    $special = $query_special->row['name'];
                } else {
                    $special = false;
                }

                if ($query_product->num_rows) {
                    $product_data = array(
                        'id' => $query_sku->row['sku'],
                        'name' => $query_product->row['name'],
                        'special' => $special,
                        'price' => round($query_sku->row['price'], 0)
                    );
                }
            }
        }

        return $product_data;
    }

    public function setSpecialPrice($data = 0, $sku = '')
    {

        $query_options = $this->db->query("SELECT relatedoptions_id, product_id, price FROM " . DB_PREFIX . "relatedoptions WHERE sku = '" . $sku . "'");

        if ($query_options->num_rows) {
            foreach ($query_options->rows as $option) {
                $this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions_special WHERE relatedoptions_id = '" . (int)$option['relatedoptions_id'] . "'");

                $price = round($option['price'] - $option['price'] / 100 * (int)$data['value'], 0);

                $this->db->query("INSERT INTO " . DB_PREFIX . "relatedoptions_special SET relatedoptions_id = '" . (int)$option['relatedoptions_id'] . "', customer_group_id = '1', priority = '" . $data['priority'] . "', price = '" . (float)$price . "', name = '" . $data['name'] . "', 1С_special_id = '" . $data['1C_special_id'] . "'");

                $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$option['product_id'] . "'");

                $this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$option['product_id'] . "', customer_group_id = '1', priority = '1', price = '" . (float)$price . "', date_start = '" . $this->db->escape($data['date_start']) . "', date_end = '" . $this->db->escape($data['date_end']) . "'");

            }
        }
    }

    public function deleteSpecial($special_id = '')
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions_special WHERE 1С_special_id = '" . $special_id . "'");
    }

    public function deleteProduct($id = '')
    {
        $product_query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE 1C_product_id = '" . $id . "'");

        if ($product_query->num_rows) {
            $product_id = $product_query->row['product_id'];
        } else {
            $product_id = 0;
        }

        if ($product_id) {
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "product_recurring WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "'");

            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "poip_option_image WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "poip_option_settings WHERE product_id = '" . (int)$product_id . "'");
        }

        $relatedoptions_query = $this->db->query("SELECT relatedoptions_id FROM " . DB_PREFIX . "relatedoptions WHERE sku = '" . $id . "'");

        if ($relatedoptions_query->num_rows) {
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions WHERE sku = '" . $id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions_search WHERE product_id = '" . (int)$product_id . "'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions_variant_product WHERE product_id = '" . (int)$product_id . "'");
            foreach ($relatedoptions_query->rows as $relatedoption) {
                $query = $this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions WHERE relatedoption_id = '" . (int)$relatedoption['relatedoption_id'] . "'");
                $query = $this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions_discount WHERE relatedoption_id = '" . (int)$relatedoption['relatedoption_id'] . "'");
                $query = $this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions_option WHERE relatedoption_id = '" . (int)$relatedoption['relatedoption_id'] . "'");
                $query = $this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions_special WHERE relatedoption_id = '" . (int)$relatedoption['relatedoption_id'] . "'");
                $query = $this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions_to_char WHERE relatedoption_id = '" . (int)$relatedoption['relatedoption_id'] . "'");
            }
        }
    }

    public function deleteOffer($id = '')
    {
        $relatedoptions_query = $this->db->query("SELECT relatedoptions_id FROM " . DB_PREFIX . "relatedoptions WHERE sku = '" . $id . "'");

        if ($relatedoptions_query->num_rows) {
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions WHERE sku = '" . $id . "'");
            foreach ($relatedoptions_query->rows as $relatedoption) {
                $query = $this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions WHERE relatedoption_id = '" . (int)$relatedoption['relatedoption_id'] . "'");
                $query = $this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions_discount WHERE relatedoption_id = '" . (int)$relatedoption['relatedoption_id'] . "'");
                $query = $this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions_option WHERE relatedoption_id = '" . (int)$relatedoption['relatedoption_id'] . "'");
                $query = $this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions_special WHERE relatedoption_id = '" . (int)$relatedoption['relatedoption_id'] . "'");
                $query = $this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions_to_char WHERE relatedoption_id = '" . (int)$relatedoption['relatedoption_id'] . "'");
            }
        }
    }

    public function getDeliveryInfo($order_id = 0)
    {
        $query = $this->db->query("SELECT value FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' AND code='shipping'");

        return $query->row;
    }

    public function insert_sale_products($sale_id, $related_id, $special, $start_date, $end_date, $variant_id, $priority)
    {
        //$sql = "SELECT related_id FROM " . DB_PREFIX . "sale_related_products WHERE sale_id = '" . (int)$sale_id . "' AND related_id = '" . (int)$related_id . "'";
        $sql = "SELECT related_id FROM " . DB_PREFIX . "sale_related_products WHERE related_id = '" . (int)$related_id . "'";
        $query = $this->db->query($sql);

        if (!$query->num_rows) {
            $sql_s_r_p = "INSERT INTO " . DB_PREFIX . "sale_related_products SET `sale_id` = '" . (int)$sale_id . "', `related_id` = '" . (int)$related_id . "'";
            $this->db->query($sql_s_r_p);

            $sql1 = "INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$related_id . "', customer_group_id = '1', sale_id = '" . (int)$sale_id . "', price = '" . $special . "', date_start = '" . $start_date . "', date_end = '" . $end_date . "', priority = '" . (int)$priority . "'";
            $this->db->query($sql1);

            $sql2 = "INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$related_id . "', customer_group_id = '2', sale_id = '" . (int)$sale_id . "', price = '" . $special . "', date_start = '" . $start_date . "', date_end = '" . $end_date . "', priority = '" . (int)$priority . "'";
            $this->db->query($sql2);
        } else {
            $sql_priority_product = "SELECT priority FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$related_id . "'";

            $query_priority_product = $this->db->query($sql_priority_product);

            if (!$query_priority_product->num_rows) {
                $this->db->query("UPDATE " . DB_PREFIX . "product_special SET sale_id = '" . (int)$sale_id . "', price = '" . $special . "', priority = '" . (int)$priority . "' WHERE product_id = '" . (int)$related_id . "'");
            } else if ($query_priority_product->num_rows && ((int)$query_priority_product->row['priority'] > (int)$priority)) {
                $this->db->query("UPDATE " . DB_PREFIX . "product_special SET sale_id = '" . (int)$sale_id . "', price = '" . $special . "', priority = '" . (int)$priority . "' WHERE product_id = '" . (int)$related_id . "'");
            }
        }

        if ($variant_id) {
            $sql_priority = "SELECT priority FROM " . DB_PREFIX . "tdo_data WHERE product_id = '" . (int)$related_id . "' AND tdo_id = '" . (int)$variant_id . "'";

            $query_priority = $this->db->query($sql_priority);

            if (!$query_priority->num_rows) {
                $this->db->query("UPDATE " . DB_PREFIX . "tdo_data SET sale_id = '" . (int)$sale_id . "', special = '" . $special . "', priority = '" . (int)$priority . "' WHERE tdo_id = '" . (int)$variant_id . "'");
            } else if ($query_priority->num_rows && ((int)$query_priority->row['priority'] > (int)$priority)) {
                $this->db->query("UPDATE " . DB_PREFIX . "tdo_data SET sale_id = '" . (int)$sale_id . "', special = '" . $special . "', priority = '" . (int)$priority . "' WHERE tdo_id = '" . (int)$variant_id . "'");
            }
        }
    }

}


