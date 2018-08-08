<?php

class ModelCatalogContact extends Model
{
    public function getContact()
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "contact_description WHERE language_id ='" . $this->config->get('config_language_id') . "'");

        return $query->row;
    }
}

?>