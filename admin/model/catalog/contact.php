<?php

class ModelCatalogContact extends Model
{
    public function editContact($data)
    {

        foreach ($data['contact_description'] as $language_id => $value) {
            $this->db->query("UPDATE " . DB_PREFIX . "contact_description SET title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', description_above = '" . $this->db->escape($value['description_above']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "' WHERE language_id = '" . (int)$language_id . "'");
        }

    }

    public function getContact()
    {
        $contact_description_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contact_description");

        foreach ($query->rows as $result) {
            $contact_description_data[$result['language_id']] = array(
                'title' => $result['title'],
                'description' => $result['description'],
                'description_above' => $result['description_above'],
                'meta_title' => $result['meta_title'],
                'meta_h1' => $result['meta_h1'],
                'meta_description' => $result['meta_description'],
                'meta_keyword' => $result['meta_keyword']
            );
        }

        return $contact_description_data;
    }

}
