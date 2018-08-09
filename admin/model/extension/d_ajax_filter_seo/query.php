<?php
/*
 *  location: admin/model
 */

class ModelExtensionDAjaxFilterSeoQuery extends Model
{

    private $codename = 'd_ajax_filter_seo';

    public function addQuery($data)
    {
        $this->db->query("INSERT INTO " . DB_PREFIX . "af_query SET 
            path = '" . $this->db->escape($data['path']) . "', 
            params = '" . $this->db->escape($data['params']) . "', 
            popularity='0'");

        $query_id = $this->db->getLastId();

        foreach ($data['query_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "af_query_description SET 
                query_id ='" . $query_id . "',
                language_id='" . $language_id . "',
                h1='" . $this->db->escape($value['h1']) . "',
                description='" . $this->db->escape($value['description']) . "',
                meta_title='" . $this->db->escape($value['meta_title']) . "', 
                meta_description='" . $this->db->escape($value['meta_description']) . "', 
                meta_keyword='" . $this->db->escape($value['meta_keyword']) . "'");
        }

        $data['query_id'] = $query_id;

        $this->load->model('extension/module/' . $this->codename);

        $seo_extensions = $this->{'model_extension_module_' . $this->codename}->getSEOFilterExtensions();

        foreach ($seo_extensions as $seo_extension) {
            $this->load->controller('extension/d_seo_module_ajax_filter/' . $seo_extension . '/query_add', $data);
        }
    }

    public function editQuery($query_id, $data)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "af_query SET 
            path = '" . $this->db->escape($data['path']) . "', 
            params = '" . $this->db->escape($data['params']) . "'
            WHERE query_id = '" . $query_id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "af_query_description WHERE query_id = '" . (int)$query_id . "'");

        foreach ($data['query_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "af_query_description SET 
                query_id ='" . $query_id . "',
                language_id='" . $language_id . "',
                h1='" . $this->db->escape($value['h1']) . "',
                description='" . $this->db->escape($value['description']) . "',
                meta_title='" . $this->db->escape($value['meta_title']) . "', 
                meta_description='" . $this->db->escape($value['meta_description']) . "', 
                meta_keyword='" . $this->db->escape($value['meta_keyword']) . "'");
        }

        $data['query_id'] = $query_id;

        $this->load->model('extension/module/' . $this->codename);

        $seo_extensions = $this->{'model_extension_module_' . $this->codename}->getSEOFilterExtensions();

        foreach ($seo_extensions as $seo_extension) {
            $this->load->controller('extension/d_seo_module_ajax_filter/' . $seo_extension . '/query_edit', $data);
        }
    }

    public function deleteQuery($query_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "af_query WHERE query_id = '" . (int)$query_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "af_query_description WHERE query_id = '" . (int)$query_id . "'");

        $this->load->model('extension/module/' . $this->codename);

        $seo_extensions = $this->{'model_extension_module_' . $this->codename}->getSEOFilterExtensions();

        foreach ($seo_extensions as $seo_extension) {
            $this->load->controller('extension/d_seo_module_ajax_filter/' . $seo_extension . '/query_delete', array('query_id' => $query_id));
        }
    }

    public function getQuery($query_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "af_query
            WHERE query_id = '" . $query_id . "'");
        $query_data = array();

        if ($query->num_rows) {
            $query_data = $query->row;
        }

        return $query_data;
    }

    public function getCategoryPath($category_id)
    {
        $query = $this->db->query("SELECT DISTINCT (SELECT GROUP_CONCAT(cp.path_id ORDER BY LEVEL SEPARATOR '_') FROM " . DB_PREFIX . "category_path cp WHERE cp.category_id = c.category_id
            GROUP BY cp.category_id) AS path FROM " . DB_PREFIX . "category c WHERE c.category_id = '" . (int)$category_id . "'");
        if ($query->num_rows) {
            return $query->row['path'];
        } else {
            return '';
        }
    }

    public function getQueries($data)
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "af_query afq";

        $implode = array();

        if (!empty($data['filter_path'])) {
            $implode[] = " afq.path LIKE '%" . $this->db->escape($data['filter_path']) . "%'";
        }

        if (!empty($data['filter_params'])) {
            $implode[] = " afq.params LIKE '%" . $this->db->escape($data['filter_params']) . "%'";
        }
        if (!empty($data['filter_popularity'])) {
            $implode[] = " afq.popularity > '" . $this->db->escape($data['filter_popularity']) . "'";
        }

        if (count($implode) > 0) {
            $sql .= " WHERE " . implode(' AND ', $implode);
        }

        $sort_data = array(
            'afq.path',
            'afq.params',
            'afq.popularity'
        );
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY afq.popularity";
        }

        if (isset($data['order']) && ($data['order'] == 'ASC')) {
            $sql .= " ASC";
        } else {
            $sql .= " DESC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        $query_data = array();

        if ($query->num_rows) {
            $query_data = $query->rows;
        }

        return $query_data;
    }

    public function getQueryDescription($query_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "af_query_description 
            WHERE query_id = '" . $query_id . "'");

        $query_data = array();
        foreach ($query->rows as $result) {
            $query_data[$result['language_id']] = array(
                'description' => $result['description'],
                'h1' => $result['h1'],
                'meta_title' => $result['meta_title'],
                'meta_description' => $result['meta_description'],
                'meta_keyword' => $result['meta_keyword'],
            );
        }
        return $query_data;
    }

    public function getKeywordForQuery($path, $params)
    {
        $sql = "SELECT query, keyword FROM `" . DB_PREFIX . "url_alias` WHERE query LIKE 'path=" . $this->db->escape($path) . "&ajaxfilter=" . $this->db->escape($params) . "&language_id=%'";

        $query = $this->db->query($sql);

        $keyword_data = array();
        if ($query->num_rows) {
            foreach ($query->rows as $row) {
                $explode = explode('&language_id=', $row['query']);
                $language_id = $explode[1];
                $keyword_data[$language_id] = $row['keyword'];
            }
        }

        return $keyword_data;
    }

    public function getUrlAlias($keyword)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "'");

        return $query->row;
    }

    public function getQueriesTotal($data)
    {
        $sql = "SELECT count(*) as total FROM " . DB_PREFIX . "af_query afq";

        $implode = array();

        if (!empty($data['filter_url'])) {
            $implode[] = " afq.url LIKE '%" . $this->db->escape($data['filter_url']) . "%'";
        }
        if (!empty($data['filter_popularity'])) {
            $implode[] = " afq.popularity > '" . $this->db->escape($data['filter_popularity']) . "'";
        }

        if (count($implode) > 0) {
            $sql .= " WHERE " . implode(' AND ', $implode);
        }

        $query = $this->db->query($sql);

        $total = $query->row['total'];

        return $total;
    }

    public function getParams($data)
    {
        $sql = "SELECT `params` FROM `" . DB_PREFIX . "af_query`";

        $implode = array();

        if (!empty($data['filter_params'])) {
            $implode[] = " `params` LIKE '%" . $this->db->escape($data['filter_params']) . "%'";
        }

        if (count($implode) > 0) {
            $sql .= " WHERE " . implode(' AND ', $implode);
        }
        $sql .= " GROUP BY `params` ORDER BY `params` ASC ";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }
}
