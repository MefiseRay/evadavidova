<?php

class ModelExtensionDSEOModuleDAjaxFilterSEO extends Model
{
    private $codename = 'd_ajax_filter_seo';

    /*
    *   Add Language.
    */
    public function addLanguage($data)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "af_query_description WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");

        foreach ($query->rows as $query_description) {
            $this->db->query("UPDATE " . DB_PREFIX . "af_query_description SET description = '" . $this->db->escape($query_description['description']) . "', h1 = '" . $this->db->escape($query_description['h1']) . "', meta_title = '" . $this->db->escape($query_description['meta_title']) . "', meta_description = '" . $this->db->escape($query_description['meta_description']) . "', meta_keyword = '" . $this->db->escape($query_description['meta_keyword']) . "' WHERE query_id = '" . (int)$query_description['query_id'] . "' AND language_id = '" . (int)$data['language_id'] . "'");
        }
    }

    /*
    *   Delete Language.
    */
    public function deleteLanguage($data)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query LIKE '%language_id=" . (int)$data['language_id'] . "%' AND (query LIKE '%bm_category_id=%' OR query LIKE '%bm_post_id=%' OR query LIKE '%bm_author_id=%' OR query RLIKE 'd_blog_module/search(&|$)')");

        $this->cache->delete('url_rewrite');
    }

    /*
    *	Return Field Elements.
    */
    public function getFieldElements($data)
    {
        if ($data['field_code'] == 'target_keyword') {
            $this->load->model('extension/module/' . $this->codename);

            $stores = $this->{'model_extension_module_' . $this->codename}->getStores();

            $field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');

            $field_elements = array();

            $sql = "SELECT * FROM " . DB_PREFIX . "d_target_keyword";

            $implode = array();

            foreach ($data['filter'] as $filter_code => $filter) {
                if (!empty($filter)) {
                    if ($filter_code == 'route') {
                        if (strpos($filter, '%') !== false) {
                            $implode[] = "route LIKE '" . $this->db->escape($filter) . "'";
                        } else {
                            $implode[] = "route = '" . $this->db->escape($filter) . "'";
                        }
                    }

                    if ($filter_code == 'language_id') {
                        $implode[] = "language_id = '" . (int)$filter . "'";
                    }

                    if ($filter_code == 'sort_order') {
                        $implode[] = "sort_order = '" . (int)$filter . "'";
                    }

                    if ($filter_code == 'keyword') {
                        $implode[] = "keyword = '" . $this->db->escape($filter) . "'";
                    }
                }
            }

            if ($implode) {
                $sql .= " WHERE " . implode(' AND ', $implode);
            }

            $sql .= " ORDER BY sort_order";

            $query = $this->db->query($sql);

            foreach ($query->rows as $result) {
                if (strpos($result['route'], 'af_query_id') === 0) {
                    if (isset($field_info['sheet']['ajax_filter_seo']['field']['target_keyword']['multi_store']) && $field_info['sheet']['ajax_filter_seo']['field']['target_keyword']['multi_store'] && isset($field_info['sheet']['ajax_filter_seo']['field']['target_keyword']['multi_store_status']) && $field_info['sheet']['ajax_filter_seo']['field']['target_keyword']['multi_store_status']) {
                        if ((isset($data['filter']['store_id']) && ($result['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
                            $field_elements[$result['route']][$result['store_id']][$result['language_id']][$result['sort_order']] = $result['keyword'];
                        }
                    } elseif ($result['store_id'] == 0) {
                        foreach ($stores as $store) {
                            if ((isset($data['filter']['store_id']) && ($store['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
                                $field_elements[$result['route']][$store['store_id']][$result['language_id']][$result['sort_order']] = $result['keyword'];
                            }
                        }
                    }
                }
            }
            return $field_elements;
        }

        if ($data['field_code'] == 'url_keyword') {
            $this->load->model('extension/module/' . $this->codename);

            $stores = $this->{'model_extension_module_' . $this->codename}->getStores();

            $field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');

            $field_elements = array();

            if (VERSION >= '3.0.0.0') {
                $sql = "SELECT * FROM " . DB_PREFIX . "seo_url";
            } else {
                $sql = "SELECT * FROM " . DB_PREFIX . "d_url_keyword";
            }

            $implode = array();

            foreach ($data['filter'] as $filter_code => $filter) {
                if (!empty($filter)) {
                    if ($filter_code == 'route') {
                        if (strpos($filter, '%') !== false) {
                            if (VERSION >= '3.0.0.0') {
                                $implode[] = "query LIKE '" . $this->db->escape($filter) . "'";
                            } else {
                                $implode[] = "route LIKE '" . $this->db->escape($filter) . "'";
                            }
                        } else {
                            if (VERSION >= '3.0.0.0') {
                                $implode[] = "query = '" . $this->db->escape($filter) . "'";
                            } else {
                                $implode[] = "route = '" . $this->db->escape($filter) . "'";
                            }
                        }
                    }

                    if ($filter_code == 'language_id') {
                        $implode[] = "language_id = '" . (int)$filter . "'";
                    }

                    if ($filter_code == 'keyword') {
                        $implode[] = "keyword = '" . $this->db->escape($filter) . "'";
                    }
                }
            }

            if ($implode) {
                $sql .= " WHERE " . implode(' AND ', $implode);
            }

            $query = $this->db->query($sql);

            foreach ($query->rows as $result) {
                if (VERSION >= '3.0.0.0') {
                    $result['route'] = $result['query'];
                }

                if (strpos($result['route'], 'af_query_id') === 0) {
                    if (isset($field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store']) && $field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store'] && isset($field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store_status']) && $field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store_status']) {
                        if ((isset($data['filter']['store_id']) && ($result['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
                            $field_elements[$result['route']][$result['store_id']][$result['language_id']] = $result['keyword'];
                        }
                    } elseif ($result['store_id'] == 0) {
                        foreach ($stores as $store) {
                            if ((isset($data['filter']['store_id']) && ($store['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
                                $field_elements[$result['route']][$store['store_id']][$result['language_id']] = $result['keyword'];
                            }
                        }
                    }
                }
            }

            return $field_elements;
        }

        if ($data['field_code'] == 'meta_data') {
            $this->load->model('extension/module/' . $this->codename);

            $stores = $this->{'model_extension_module_' . $this->codename}->getStores();

            $field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');

            $field_elements = array();

            if ((isset($data['filter']['route']) && (strpos($data['filter']['route'], 'af_query_id') === 0)) || !isset($data['filter']['route'])) {
                $sql = "SELECT * FROM " . DB_PREFIX . "af_query_description";

                $implode = array();

                foreach ($data['filter'] as $filter_code => $filter) {
                    if (!empty($filter)) {
                        if ($filter_code == 'route') {
                            $route_arr = explode('af_query_id=', $filter);

                            if (isset($route_arr[1]) && ($route_arr[1] != '%')) {
                                $query_id = $route_arr[1];
                                $implode[] = "query_id = '" . (int)$query_id . "'";
                            }
                        }

                        if ($filter_code == 'language_id') {
                            $implode[] = "language_id = '" . (int)$filter . "'";
                        }

                        if ($filter_code == 'title') {
                            $implode[] = "title = '" . $this->db->escape($filter) . "'";
                        }

                        if ($filter_code == 'description') {
                            $implode[] = "description = '" . $this->db->escape($filter) . "'";
                        }

                        if ($filter_code == 'meta_title') {
                            $implode[] = "meta_title = '" . $this->db->escape($filter) . "'";
                        }

                        if ($filter_code == 'meta_description') {
                            $implode[] = "meta_description = '" . $this->db->escape($filter) . "'";
                        }

                        if ($filter_code == 'meta_keyword') {
                            $implode[] = "meta_keyword = '" . $this->db->escape($filter) . "'";
                        }
                    }
                }

                if ($implode) {
                    $sql .= " WHERE " . implode(' AND ', $implode);
                }

                $query = $this->db->query($sql);

                foreach ($query->rows as $result) {
                    $route = 'af_query_id=' . $result['query_id'];

                    if ((isset($field_info['sheet']['ajax_filter_seo']['field']['title']['multi_store']) && $field_info['sheet']['ajax_filter_seo']['field']['title']['multi_store'] && isset($field_info['sheet']['ajax_filter_seo']['field']['title']['multi_store_status']) && $field_info['sheet']['ajax_filter_seo']['field']['title']['multi_store_status'])) {
                        if ((isset($data['filter']['store_id']) && ($data['filter']['store_id'] == 0)) || !isset($data['filter']['store_id'])) {
                            $field_elements[$route][0][$result['language_id']]['title'] = $result['h1'];
                        }
                    } else {
                        foreach ($stores as $store) {
                            if ((isset($data['filter']['store_id']) && ($store['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
                                $field_elements[$route][$store['store_id']][$result['language_id']]['title'] = $result['title'];
                            }
                        }
                    }

                    if ((isset($field_info['sheet']['ajax_filter_seo']['field']['description']['multi_store']) && $field_info['sheet']['ajax_filter_seo']['field']['description']['multi_store'] && isset($field_info['sheet']['ajax_filter_seo']['field']['description']['multi_store_status']) && $field_info['sheet']['ajax_filter_seo']['field']['description']['multi_store_status'])) {
                        if ((isset($data['filter']['store_id']) && ($data['filter']['store_id'] == 0)) || !isset($data['filter']['store_id'])) {
                            $field_elements[$route][0][$result['language_id']]['description'] = $result['description'];
                        }
                    } else {
                        foreach ($stores as $store) {
                            if ((isset($data['filter']['store_id']) && ($store['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
                                $field_elements[$route][$store['store_id']][$result['language_id']]['description'] = $result['description'];
                            }
                        }
                    }

                    if ((isset($field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store']) && $field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store'] && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store_status']) && $field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store_status'])) {
                        if ((isset($data['filter']['store_id']) && ($data['filter']['store_id'] == 0)) || !isset($data['filter']['store_id'])) {
                            $field_elements[$route][0][$result['language_id']]['meta_title'] = $result['meta_title'];
                        }
                    } else {
                        foreach ($stores as $store) {
                            if ((isset($data['filter']['store_id']) && ($store['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
                                $field_elements[$route][$store['store_id']][$result['language_id']]['meta_title'] = $result['meta_title'];
                            }
                        }
                    }

                    if ((isset($field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store']) && $field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store'] && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store_status']) && $field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store_status'])) {
                        if ((isset($data['filter']['store_id']) && ($data['filter']['store_id'] == 0)) || !isset($data['filter']['store_id'])) {
                            $field_elements[$route][0][$result['language_id']]['meta_description'] = $result['meta_description'];
                        }
                    } else {
                        foreach ($stores as $store) {
                            if ((isset($data['filter']['store_id']) && ($store['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
                                $field_elements[$route][$store['store_id']][$result['language_id']]['meta_description'] = $result['meta_description'];
                            }
                        }
                    }

                    if ((isset($field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store']) && $field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store'] && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store_status']) && $field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store_status'])) {
                        if ((isset($data['filter']['store_id']) && ($data['filter']['store_id'] == 0)) || !isset($data['filter']['store_id'])) {
                            $field_elements[$route][0][$result['language_id']]['meta_keyword'] = $result['meta_keyword'];
                        }
                    } else {
                        foreach ($stores as $store) {
                            if ((isset($data['filter']['store_id']) && ($store['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
                                $field_elements[$route][$store['store_id']][$result['language_id']]['meta_keyword'] = $result['meta_keyword'];
                            }
                        }
                    }
                }
            }

            if ((isset($data['filter']['route']) && (strpos($data['filter']['route'], 'af_query_id') === 0)) || !isset($data['filter']['route'])) {
                $sql = "SELECT * FROM " . DB_PREFIX . "d_meta_data";

                $implode = array();

                foreach ($data['filter'] as $filter_code => $filter) {
                    if (!empty($filter)) {
                        if ($filter_code == 'route') {
                            if (strpos($filter, '%') !== false) {
                                $implode[] = "route LIKE '" . $this->db->escape($filter) . "'";
                            } else {
                                $implode[] = "route = '" . $this->db->escape($filter) . "'";
                            }
                        }

                        if ($filter_code == 'language_id') {
                            $implode[] = "language_id = '" . (int)$filter . "'";
                        }

                        if ($filter_code == 'name') {
                            $implode[] = "name = '" . $this->db->escape($filter) . "'";
                        }

                        if ($filter_code == 'title') {
                            $implode[] = "title = '" . $this->db->escape($filter) . "'";
                        }

                        if ($filter_code == 'description') {
                            $implode[] = "description = '" . $this->db->escape($filter) . "'";
                        }

                        if ($filter_code == 'meta_title') {
                            $implode[] = "meta_title = '" . $this->db->escape($filter) . "'";
                        }

                        if ($filter_code == 'meta_description') {
                            $implode[] = "meta_description = '" . $this->db->escape($filter) . "'";
                        }

                        if ($filter_code == 'meta_keyword') {
                            $implode[] = "meta_keyword = '" . $this->db->escape($filter) . "'";
                        }

                        if ($filter_code == 'meta_robots') {
                            $implode[] = "meta_robots = '" . $this->db->escape($filter) . "'";
                        }
                    }
                }

                if ($implode) {
                    $sql .= " WHERE " . implode(' AND ', $implode);
                }

                $query = $this->db->query($sql);

                foreach ($query->rows as $result) {
                    if (strpos($result['route'], 'af_query_id') === 0) {
                        if ($result['store_id'] && isset($field_info['sheet']['ajax_filter_seo']['field']['title']['multi_store']) && $field_info['sheet']['ajax_filter_seo']['field']['title']['multi_store'] && isset($field_info['sheet']['ajax_filter_seo']['field']['title']['multi_store_status']) && $field_info['sheet']['ajax_filter_seo']['field']['title']['multi_store_status']) {
                            if ((isset($data['filter']['store_id']) && ($result['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
                                $field_elements[$result['route']][$result['store_id']][$result['language_id']]['title'] = $result['title'];
                            }
                        }

                        if ($result['store_id'] && isset($field_info['sheet']['ajax_filter_seo']['field']['description']['multi_store']) && $field_info['sheet']['ajax_filter_seo']['field']['description']['multi_store'] && isset($field_info['sheet']['ajax_filter_seo']['field']['description']['multi_store_status']) && $field_info['sheet']['ajax_filter_seo']['field']['description']['multi_store_status']) {
                            if ((isset($data['filter']['store_id']) && ($result['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
                                $field_elements[$result['route']][$result['store_id']][$result['language_id']]['description'] = $result['description'];
                            }
                        }

                        if ($result['store_id'] && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store']) && $field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store'] && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store_status']) && $field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store_status']) {
                            if ((isset($data['filter']['store_id']) && ($result['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
                                $field_elements[$result['route']][$result['store_id']][$result['language_id']]['meta_title'] = $result['meta_title'];
                            }
                        }

                        if ($result['store_id'] && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store']) && $field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store'] && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store_status']) && $field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store_status']) {
                            if ((isset($data['filter']['store_id']) && ($result['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
                                $field_elements[$result['route']][$result['store_id']][$result['language_id']]['meta_description'] = $result['meta_description'];
                            }
                        }

                        if ($result['store_id'] && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store']) && $field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store'] && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store_status']) && $field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store_status']) {
                            if ((isset($data['filter']['store_id']) && ($result['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
                                $field_elements[$result['route']][$result['store_id']][$result['language_id']]['meta_keyword'] = $result['meta_keyword'];
                            }
                        }

                        if ($result['store_id'] && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_robots']['multi_store']) && $field_info['sheet']['ajax_filter_seo']['field']['meta_robots']['multi_store'] && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_robots']['multi_store_status']) && $field_info['sheet']['ajax_filter_seo']['field']['meta_robots']['multi_store_status']) {
                            if ((isset($data['filter']['store_id']) && ($result['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
                                $field_elements[$result['route']][$result['store_id']][$result['language_id']]['meta_robots'] = $result['meta_robots'];
                            }
                        } elseif ($result['store_id'] == 0) {
                            foreach ($stores as $store) {
                                if ((isset($data['filter']['store_id']) && ($store['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
                                    $field_elements[$result['route']][$result['store_id']][$result['language_id']]['meta_robots'] = $result['meta_robots'];
                                }
                            }
                        }
                    }
                }
            }

            return $field_elements;
        }

        return false;
    }
}
