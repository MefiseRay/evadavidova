<?php
class ModelExtensionDSEOModuleAjaxFilterDAjaxFilterSEO extends Model
{
    /*
    *	Save Query Meta Data.
    */
    public function saveQueryMetaData($data)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "d_meta_data WHERE route = 'af_query_id=" . (int)$data['query_id'] . "'");
        
        if (isset($data['meta_data'])) {
            foreach ($data['meta_data'] as $store_id => $language_meta_data) {
                foreach ($language_meta_data as $language_id => $meta_data) {
                    $implode = array();
                    
                    if ($store_id) {
                        if (isset($meta_data['title'])) {
                            $implode[] = "title = '" . $this->db->escape($meta_data['title']) . "'";
                        }
                        
                        if (isset($meta_data['description'])) {
                            $implode[] = "description = '" . $this->db->escape($meta_data['description']) . "'";
                        }
                        
                        if (isset($meta_data['meta_title'])) {
                            $implode[] = "meta_title = '" . $this->db->escape($meta_data['meta_title']) . "'";
                        }
                        
                        if (isset($meta_data['meta_description'])) {
                            $implode[] = "meta_description = '" . $this->db->escape($meta_data['meta_description']) . "'";
                        }
                        
                        if (isset($meta_data['meta_keyword'])) {
                            $implode[] = "meta_keyword = '" . $this->db->escape($meta_data['meta_keyword']) . "'";
                        }
                    }
                    
                    if (isset($meta_data['meta_robots'])) {
                        $implode[] = "meta_robots = '" . $this->db->escape($meta_data['meta_robots']) . "'";
                    }
                    
                    $this->db->query("INSERT INTO " . DB_PREFIX . "d_meta_data SET route = 'af_query_id=" . (int)$data['query_id'] . "', store_id='" . (int)$store_id . "', language_id='" . (int)$language_id . "', " . implode(', ', $implode));
                }
            }
        }
    }
    
    /*
    *	Save Query Target Keyword.
    */
    public function saveQueryTargetKeyword($data)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'af_query_id=" . (int)$data['query_id'] . "'");
                        
        if (isset($data['target_keyword'])) {
            foreach ($data['target_keyword'] as $store_id => $language_target_keyword) {
                foreach ($language_target_keyword as $language_id => $keywords) {
                    $sort_order = 1;
                
                    foreach ($keywords as $keyword) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "d_target_keyword SET route = 'af_query_id=" . (int)$data['query_id'] . "', store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', sort_order = '" . $sort_order . "', keyword = '" .  $this->db->escape($keyword) . "'");
                    
                        $sort_order++;
                    }
                }
            }
        }
    }
    
    /*
    *	Save Query URL Keyword.
    */
    public function saveQueryURLKeyword($data)
    {
        if (VERSION >= '3.0.0.0') {
            $this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'af_query_id=" . (int)$data['query_id'] . "'");
        } else {
            $this->db->query("DELETE FROM " . DB_PREFIX . "d_url_keyword WHERE route = 'af_query_id=" . (int)$data['query_id'] . "'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'af_query_id=" . (int)$data['query_id'] . "'");
        }
        
        if (isset($data['url_keyword'])) {
            foreach ($data['url_keyword'] as $store_id => $language_url_keyword) {
                foreach ($language_url_keyword as $language_id => $url_keyword) {
                    if ($url_keyword) {
                        if (VERSION >= '3.0.0.0') {
                            $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET query = 'af_query_id=" . (int)$data['query_id'] . "', store_id='" . (int)$store_id . "', language_id='" . (int)$language_id . "', keyword = '" . $this->db->escape($url_keyword) . "'");
                        } else {
                            $this->db->query("INSERT INTO " . DB_PREFIX . "d_url_keyword SET route = 'af_query_id=" . (int)$data['query_id'] . "', store_id='" . (int)$store_id . "', language_id='" . (int)$language_id . "', keyword = '" . $this->db->escape($url_keyword) . "'");
                            
                            if (($store_id == 0) && ($language_id == (int)$this->config->get('config_language_id'))) {
                                $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'af_query_id=" . (int)$data['query_id'] . "', keyword = '" . $this->db->escape($url_keyword) . "'");
                            }
                        }
                    }
                }
            }
        }
        
        $this->cache->delete('url_rewrite');
    }
    
        
    /*
    *	Delete Query Meta Data.
    */
    public function deleteQueryMetaData($data)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "d_meta_data WHERE route = 'af_query_id=" . (int)$data['query_id'] . "'");
    }

    /*
    *	Delete Query Target Keyword.
    */
    public function deleteQueryTargetKeyword($data)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'af_query_id=" . (int)$data['query_id'] . "'");
    }
    
    /*
    *	Delete Query URL Keyword.
    */
    public function deleteQueryURLKeyword($data)
    {
        if (VERSION >= '3.0.0.0') {
            $this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'af_query_id=" . (int)$data['query_id'] . "'");
        } else {
            $this->db->query("DELETE FROM " . DB_PREFIX . "d_url_keyword WHERE route = 'af_query_id=" . (int)$data['query_id'] . "'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'af_query_id=" . (int)$data['query_id'] . "'");
        }
    }
    
    /*
    *	Return Query Meta Data.
    */
    public function getQueryMetaData($query_id)
    {
        $meta_data = array();
        
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "d_meta_data WHERE route='af_query_id=" . (int)$query_id . "'");
        
        foreach ($query->rows as $result) {
            $meta_data[$result['store_id']][$result['language_id']] = array(
                'title'            => $result['title'],
                'description'      => $result['description'],
                'meta_title'       => $result['meta_title'],
                'meta_description' => $result['meta_description'],
                'meta_keyword'     => $result['meta_keyword'],
                'meta_robots'      => $result['meta_robots']
            );
        }
        
        return $meta_data;
    }
    
    /*
    *	Return Query Target Keyword.
    */
    public function getQueryTargetKeyword($query_id)
    {
        $target_keyword = array();
        
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'af_query_id=" . (int)$query_id . "' ORDER BY sort_order");
        
        foreach ($query->rows as $result) {
            $target_keyword[$result['store_id']][$result['language_id']][$result['sort_order']] = $result['keyword'];
        }
        
        return $target_keyword;
    }
    
    /*
    *	Return Query URL Keyword.
    */
    public function getQueryURLKeyword($query_id)
    {
        $url_keyword = array();
        
        if (VERSION >= '3.0.0.0') {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'af_query_id=" . (int)$query_id . "'");
        } else {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "d_url_keyword WHERE route = 'af_query_id=" . (int)$query_id . "'");
        }
        
        foreach ($query->rows as $result) {
            $url_keyword[$result['store_id']][$result['language_id']] = $result['keyword'];
        }
        
        return $url_keyword;
    }
}
