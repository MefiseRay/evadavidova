<?php

class ModelExtensionDSEOModuleDAjaxFilterSEO extends Model
{
    private $codename = 'd_ajax_filter_seo';

    /*
    *	Return Category Path.
    */
    public function getCategoryPath($category_id)
    {
        $path = false;

        $path = $this->cache->get('path.category.' . $category_id);

        if (!$path) {
            $query = $this->db->query("SELECT c.category_id, cd.name, c.parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");

            if ($query->num_rows) {
                if ($query->row['parent_id']) {
                    $path = $this->getCategoryPath($query->row['parent_id'], $this->config->get('config_language_id')) . '_' . $query->row['category_id'];
                } else {
                    $path = $query->row['category_id'];
                }
            }

            $this->cache->set('path.category.' . $category_id, $path);
        }

        return $path;
    }

    /*
    *	Return URL for Language.
    */

    public function getURLForLanguage($link, $language_code)
    {
        $link = str_replace($this->url->link('common/home', '', true), '', $link);

        $url_info = parse_url(str_replace('&amp;', '&', $link));

        $data = array();

        if (isset($url_info['query'])) {
            parse_str($url_info['query'], $data);
        }

        $store_id = (int)$this->config->get('config_store_id');

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language WHERE code = '" . $language_code . "'");

        $language_id = $query->row['language_id'];

        if (!isset($data['route'])) {
            if (isset($data['_route_'])) {
                $rootUrl = $data['_route_'];
            } else {
                $linkRoot = reset((explode('?', $link)));
                if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
                    $rootUrl = str_replace(HTTPS_SERVER, '', $linkRoot);
                } else {
                    $rootUrl = str_replace(HTTP_SERVER, '', $linkRoot);
                }
            }

            $parts = explode('/', $rootUrl);

            // remove any empty arrays from trailing
            if (utf8_strlen(end($parts)) == 0) {
                array_pop($parts);
            }

            foreach ($parts as $part) {
                $field_data = array(
                    'field_code' => 'url_keyword',
                    'filter' => array(
                        'store_id' => $store_id,
                        'keyword' => $part
                    )
                );

                $url_keywords = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);

                if ($url_keywords) {
                    foreach ($url_keywords as $url_route => $store_url_keywords) {
                        foreach ($store_url_keywords[$store_id] as $url_language_id => $keyword) {
                            $route = $url_route;
                        }

                        foreach ($store_url_keywords[$store_id] as $url_language_id => $keyword) {
                            if ($url_language_id == (int)$this->config->get('config_language_id')) {
                                $route = $url_route;
                            }
                        }
                    }
                }

                if (isset($route)) {
                    $route = explode('=', $route);

                    if ($route[0] == 'af_query_id') {
                        $query_id = $route[1];
                        $query_info = $this->{'model_extension_module_' . $this->codename}->getQuery($query_id);

                        if (!empty($query_info)) {
                            $data['path'] = $query_info['path'];
                            $data['ajaxfilter'] = $query_info['params'];
                            $data['route'] = 'product/category';
                        }
                    }
                }
            }
        }

        $params = array();

        if (isset($data['ajaxfilter']) && isset($data['path'])) {
            $params[] = 'path=' . $data['path'];
            $params[] = 'ajaxfilter=' . $data['ajaxfilter'];
        }
        if (isset($data['route'])) {
            foreach ($data as $param => $value) {
                if ($param != '_route_' && $param != 'route' && $param != 'path' && $param != 'ajaxfilter') {
                    $params[] = $param . '=' . $value;
                }
            }

            $config_language_id = $this->config->get('config_language_id');
            $this->config->set('config_language_id', $language_id);

            $link = $this->url->link($data['route'], implode('&', $params), true);

            $this->config->set('config_language_id', $config_language_id);
        }

        return $link;
    }

    /*
    *	Return Current URL.
    */
    public function getCurrentURL()
    {
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $url = "https://";
        } else {
            $url = 'http://';
        }

        $url .= $this->request->server['SERVER_NAME'] . $this->request->server['REQUEST_URI'];

        $url = str_replace('&', '&amp;', str_replace('&amp;', '&', $url));

        return $url;
    }

    /*
    *	Return URL Info.
    */
    public function getURLInfo($url)
    {
        $url_info = parse_url(str_replace('&amp;', '&', $url));

        $url_info['scheme'] = isset($url_info['scheme']) ? $url_info['scheme'] . '://' : '';
        $url_info['user'] = isset($url_info['user']) ? $url_info['user'] : '';
        $url_info['pass'] = isset($url_info['pass']) ? ':' . $url_info['pass'] : '';
        $url_info['pass'] = ($url_info['user'] || $url_info['pass']) ? $url_info['pass'] . '@' : '';
        $url_info['host'] = isset($url_info['host']) ? $url_info['host'] : '';
        $url_info['port'] = isset($url_info['port']) ? ':' . $url_info['port'] : '';
        $url_info['path'] = isset($url_info['path']) ? $url_info['path'] : '';

        $url_info['data'] = array();

        if (isset($url_info['query'])) {
            parse_str($url_info['query'], $url_info['data']);
        }

        $url_info['query'] = isset($url_info['query']) ? '?' . $url_info['query'] : '';
        $url_info['fragment'] = isset($url_info['fragment']) ? '#' . $url_info['fragment'] : '';

        return $url_info;
    }

    /*
    *	Return Field Elements.
    */
    public function getFieldElements($data)
    {
        $this->load->model('extension/module/' . $this->codename);

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
                            $implode[] = "h1 = '" . $this->db->escape($filter) . "'";
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
                                $field_elements[$route][$store['store_id']][$result['language_id']]['title'] = $result['h1'];
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
