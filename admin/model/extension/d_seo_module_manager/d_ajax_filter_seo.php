<?php

class ModelExtensionDSEOModuleManagerDAjaxFilterSEO extends Model
{
    private $codename = 'd_ajax_filter_seo';

    /*
    *	Return List Elements for Manager.
    */
    public function getListElements($data)
    {
        $url_token = '';

        if (isset($this->session->data['token'])) {
            $url_token .= 'token=' . $this->session->data['token'];
        }

        if (isset($this->session->data['user_token'])) {
            $url_token .= 'user_token=' . $this->session->data['user_token'];
        }

        $field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');

        if ($data['sheet_code'] == 'ajax_filter_seo') {
            $implode = array();
            $implode[] = "q.query_id";
            $add = '';

            foreach ($data['fields'] as $field) {
                if (isset($field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store']) && isset($field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status'])) {
                    if ($field['code'] == 'title') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.title" : "qd.h1 as title";
                    }

                    if ($field['code'] == 'description') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.description" : "qd.description";
                    }

                    if ($field['code'] == 'meta_title') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.meta_title" : "qd.meta_title";
                    }

                    if ($field['code'] == 'meta_description') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.meta_description" : "qd.meta_description";
                    }

                    if ($field['code'] == 'meta_keyword') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.meta_keyword" : "qd.meta_keyword";
                    }

                    if ($field['code'] == 'meta_robots') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.meta_robots" : "md.meta_robots";
                    }

                    if ($field['code'] == 'target_keyword') {
                        $implode[] = "CONCAT('[', GROUP_CONCAT(DISTINCT tk.keyword ORDER BY tk.sort_order SEPARATOR ']['), ']') as target_keyword";

                        if ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) {
                            $target_keyword_store_id = $data['store_id'];
                        } else {
                            $target_keyword_store_id = 0;
                        }

                        $add .= " LEFT JOIN " . DB_PREFIX . "d_target_keyword tk ON (tk.route = CONCAT('af_query_id=', q.query_id) AND tk.store_id = '" . (int)$target_keyword_store_id . "' AND tk.language_id = '" . (int)$data['language_id'] . "') LEFT JOIN " . DB_PREFIX . "d_target_keyword tk2 ON (tk2.route = CONCAT('af_query_id=', q.query_id) AND tk2.store_id = '" . (int)$target_keyword_store_id . "')";
                    }

                    if ($field['code'] == 'url_keyword') {
                        $implode[] = "uk.keyword as url_keyword";

                        if ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) {
                            $url_keyword_store_id = $data['store_id'];
                        } else {
                            $url_keyword_store_id = 0;
                        }

                        if (VERSION >= '3.0.0.0') {
                            $add .= " LEFT JOIN " . DB_PREFIX . "seo_url uk ON (uk.query = CONCAT('af_query_id=', q.query_id) AND uk.store_id = '" . (int)$url_keyword_store_id . "' AND uk.language_id = '" . (int)$data['language_id'] . "') LEFT JOIN " . DB_PREFIX . "seo_url uk2 ON (uk2.query = CONCAT('af_query_id=', q.query_id) AND uk2.store_id = '" . (int)$url_keyword_store_id . "')";
                        } else {
                            $add .= " LEFT JOIN " . DB_PREFIX . "d_url_keyword uk ON (uk.route = CONCAT('af_query_id=', q.query_id) AND uk.store_id = '" . (int)$url_keyword_store_id . "' AND uk.language_id = '" . (int)$data['language_id'] . "') LEFT JOIN " . DB_PREFIX . "d_url_keyword uk2 ON (uk2.route = CONCAT('af_query_id=', q.query_id) AND uk2.store_id = '" . (int)$url_keyword_store_id . "')";
                        }
                    }
                }
            }

            $sql = "SELECT " . implode(', ', $implode) . " FROM " . DB_PREFIX . "af_query q LEFT JOIN " . DB_PREFIX . "af_query_description qd ON (qd.query_id = q.query_id AND qd.language_id = '" . (int)$data['language_id'] . "') LEFT JOIN " . DB_PREFIX . "d_meta_data md ON (md.route = CONCAT('af_query_id=', q.query_id) AND md.store_id = '0' AND md.language_id = '" . (int)$data['language_id'] . "') LEFT JOIN " . DB_PREFIX . "d_meta_data md2 ON (md2.route = CONCAT('af_query_id=', q.query_id) AND md2.store_id = '" . (int)$data['store_id'] . "' AND md2.language_id = '" . (int)$data['language_id'] . "') LEFT JOIN " . DB_PREFIX . "af_query_description qd2 ON (qd2.query_id = q.query_id) LEFT JOIN " . DB_PREFIX . "d_meta_data md3 ON (md3.route = CONCAT('af_query_id=', q.query_id) AND md3.store_id = '0') LEFT JOIN " . DB_PREFIX . "d_meta_data md4 ON (md4.route = CONCAT('af_query_id=', q.query_id) AND md4.store_id = '" . (int)$data['store_id'] . "')" . $add;

            $implode = array();

            foreach ($data['filter'] as $field_code => $filter) {
                if (!empty($filter)) {
                    if ($field_code == 'query_id') {
                        $implode[] = "q.query_id = '" . (int)($filter) . "'";
                    }

                    if ($field_code == 'target_keyword') {
                        $implode[] = "ut2.keyword LIKE '%" . $this->db->escape($filter) . "%'";
                    }

                    if ($field_code == 'url_keyword') {
                        $implode[] = "uk2.keyword LIKE '%" . $this->db->escape($filter) . "%'";
                    }
                }

                if (!empty($filter) && isset($field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store']) && isset($field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status'])) {
                    if ($field_code == 'title') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md4.title LIKE '%" . $this->db->escape($filter) . "%'" : "qd2.h1 LIKE '%" . $this->db->escape($filter) . "%'";
                    }

                    if ($field_code == 'description') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md4.description LIKE '%" . $this->db->escape($filter) . "%'" : "qd2.description LIKE '%" . $this->db->escape($filter) . "%'";
                    }

                    if ($field_code == 'meta_title') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md4.meta_title LIKE '%" . $this->db->escape($filter) . "%'" : "qd2.meta_title LIKE '%" . $this->db->escape($filter) . "%'";
                    }

                    if ($field_code == 'meta_description') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md4.meta_description LIKE '%" . $this->db->escape($filter) . "%'" : "qd2.meta_description LIKE '%" . $this->db->escape($filter) . "%'";
                    }

                    if ($field_code == 'meta_keyword') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md4.meta_keyword LIKE '%" . $this->db->escape($filter) . "%'" : "qd2.meta_keyword LIKE '%" . $this->db->escape($filter) . "%'";
                    }

                    if ($field_code == 'meta_robots') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md4.meta_robots LIKE '%" . $this->db->escape($filter) . "%'" : "md3.meta_robots LIKE '%" . $this->db->escape($filter) . "%'";
                    }
                }
            }

            if ($implode) {
                $sql .= " WHERE " . implode(' AND ', $implode);
            }

            $sql .= " GROUP BY q.query_id";

            $query = $this->db->query($sql);

            $queries = array();

            foreach ($query->rows as $result) {
                $queries[$result['query_id']] = $result;
                $queries[$result['query_id']]['link'] = $this->url->link('extension/d_ajax_filter_seo/query/edit', $url_token . '&query_id=' . $result['query_id'], true);
            }

            return $queries;
        }
        return false;
    }

    /*
    *	Save Element Field for Manager.
    */
    public function saveElementField($element)
    {
        $field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');

        if ($element['sheet_code'] == 'ajax_filter_seo') {
            if (($element['field_code'] == 'title') || ($element['field_code'] == 'description') || ($element['field_code'] == 'meta_title') || ($element['field_code'] == 'meta_description') || ($element['field_code'] == 'meta_keyword') && isset($field_info['sheet'][$element['sheet_code']]['field'][$element['field_code']]['multi_store']) && isset($field_info['sheet'][$element['sheet_code']]['field'][$element['field_code']]['multi_store_status'])) {
                if ($element['field_code'] == 'title') {
                    $element['field_code'] = 'h1';
                }
                if ($element['store_id'] && $field_info['sheet'][$element['sheet_code']]['field'][$element['field_code']]['multi_store'] && $field_info['sheet'][$element['sheet_code']]['field'][$element['field_code']]['multi_store_status']) {
                    $this->db->query("UPDATE " . DB_PREFIX . "d_meta_data SET " . $this->db->escape($element['field_code']) . " = '" . $this->db->escape($element['value']) . "' WHERE route='af_query_id=" . (int)$element['element_id'] . "' AND store_id = '" . (int)$element['store_id'] . "' AND language_id = '" . (int)$element['language_id'] . "'");

                    if (!$this->db->countAffected()) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "d_meta_data SET route='af_query_id=" . (int)$element['element_id'] . "', store_id = '" . (int)$element['store_id'] . "', language_id = '" . (int)$element['language_id'] . "', " . $this->db->escape($element['field_code']) . " = '" . $this->db->escape($element['value']) . "'");
                    }
                } else {
                    $this->db->query("UPDATE " . DB_PREFIX . "af_query_description SET " . $this->db->escape($element['field_code']) . " = '" . $this->db->escape($element['value']) . "' WHERE query_id = '" . (int)$element['element_id'] . "' AND language_id = '" . (int)$element['language_id'] . "'");
                }
            }

            if (($element['field_code'] == 'meta_robots') && isset($field_info['sheet'][$element['sheet_code']]['field'][$element['field_code']]['multi_store']) && isset($field_info['sheet'][$element['sheet_code']]['field'][$element['field_code']]['multi_store_status'])) {
                if ($element['store_id'] && $field_info['sheet'][$element['sheet_code']]['field'][$element['field_code']]['multi_store'] && $field_info['sheet'][$element['sheet_code']]['field'][$element['field_code']]['multi_store_status']) {
                    $this->db->query("UPDATE " . DB_PREFIX . "d_meta_data SET " . $this->db->escape($element['field_code']) . " = '" . $this->db->escape($element['value']) . "' WHERE route='af_query_id=" . (int)$element['element_id'] . "' AND store_id = '" . (int)$element['store_id'] . "' AND language_id = '" . (int)$element['language_id'] . "'");

                    if (!$this->db->countAffected()) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "d_meta_data SET route='af_query_id=" . (int)$element['element_id'] . "', store_id = '" . (int)$element['store_id'] . "', language_id = '" . (int)$element['language_id'] . "', " . $this->db->escape($element['field_code']) . " = '" . $this->db->escape($element['value']) . "'");
                    }
                } else {
                    $this->db->query("UPDATE " . DB_PREFIX . "d_meta_data SET " . $this->db->escape($element['field_code']) . " = '" . $this->db->escape($element['value']) . "' WHERE route='af_query_id=" . (int)$element['element_id'] . "' AND store_id = '0' AND language_id = '" . (int)$element['language_id'] . "'");

                    if (!$this->db->countAffected()) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "d_meta_data SET route='af_query_id=" . (int)$element['element_id'] . "', store_id = '0', language_id = '" . (int)$element['language_id'] . "', " . $this->db->escape($element['field_code']) . " = '" . $this->db->escape($element['value']) . "'");
                    }
                }
            }

            if (($element['field_code'] == 'target_keyword') && isset($field_info['sheet'][$element['sheet_code']]['field'][$element['field_code']]['multi_store']) && isset($field_info['sheet'][$element['sheet_code']]['field'][$element['field_code']]['multi_store_status'])) {
                if ($element['store_id'] && $field_info['sheet'][$element['sheet_code']]['field'][$element['field_code']]['multi_store'] && $field_info['sheet'][$element['sheet_code']]['field'][$element['field_code']]['multi_store_status']) {
                    $target_keyword_store_id = $element['store_id'];
                } else {
                    $target_keyword_store_id = 0;
                }

                $this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'af_query_id=" . (int)$element['element_id'] . "' AND store_id = '" . (int)$target_keyword_store_id . "' AND language_id = '" . (int)$element['language_id'] . "'");

                if ($element['value']) {
                    preg_match_all('/\[[^]]+\]/', $element['value'], $keywords);

                    $sort_order = 1;
                    $this->request->post['value'] = '';

                    foreach ($keywords[0] as $keyword) {
                        $keyword = substr($keyword, 1, strlen($keyword) - 2);
                        $this->db->query("INSERT INTO " . DB_PREFIX . "d_target_keyword SET route = 'af_query_id=" . (int)$element['element_id'] . "', store_id='" . (int)$target_keyword_store_id . "', language_id = '" . (int)$element['language_id'] . "', sort_order = '" . $sort_order . "', keyword = '" . $this->db->escape($keyword) . "'");

                        $sort_order++;
                        $this->request->post['value'] .= '[' . $keyword . ']';
                    }
                }
            }

            if (($element['field_code'] == 'url_keyword') && isset($field_info['sheet'][$element['sheet_code']]['field'][$element['field_code']]['multi_store']) && isset($field_info['sheet'][$element['sheet_code']]['field'][$element['field_code']]['multi_store_status'])) {
                if ($element['store_id'] && $field_info['sheet'][$element['sheet_code']]['field'][$element['field_code']]['multi_store'] && $field_info['sheet'][$element['sheet_code']]['field'][$element['field_code']]['multi_store_status']) {
                    $url_keyword_store_id = $element['store_id'];
                } else {
                    $url_keyword_store_id = 0;
                }

                if (VERSION >= '3.0.0.0') {
                    $this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'af_query_id=" . (int)$element['element_id'] . "' AND store_id = '" . (int)$url_keyword_store_id . "' AND language_id = '" . (int)$element['language_id'] . "'");

                    if (trim($element['value'])) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET query = 'af_query_id=" . (int)$element['element_id'] . "', store_id='" . (int)$url_keyword_store_id . "', language_id='" . (int)$element['language_id'] . "', keyword = '" . $this->db->escape($element['value']) . "'");
                    }
                } else {
                    $this->db->query("DELETE FROM " . DB_PREFIX . "d_url_keyword WHERE route = 'af_query_id=" . (int)$element['element_id'] . "' AND store_id = '" . (int)$url_keyword_store_id . "' AND language_id = '" . (int)$element['language_id'] . "'");

                    if (trim($element['value'])) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "d_url_keyword SET route = 'af_query_id=" . (int)$element['element_id'] . "', store_id='" . (int)$url_keyword_store_id . "', language_id='" . (int)$element['language_id'] . "', keyword = '" . $this->db->escape($element['value']) . "'");
                    }

                    if (($url_keyword_store_id == 0) && ($element['language_id'] == (int)$this->config->get('config_language_id'))) {
                        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'af_query_id=" . (int)$element['element_id'] . "'");

                        if (trim($element['value'])) {
                            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'af_query_id=" . (int)$element['element_id'] . "', keyword = '" . $this->db->escape($element['value']) . "'");
                        }
                    }
                }

                $this->cache->delete('url_rewrite');
            }
        }

        return true;
    }

    /*
    *	Return Export Elements for Manager.
    */
    public function getExportElements($data)
    {
        $this->load->model('extension/module/' . $this->codename);

        $languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();

        $field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');

        if ($data['sheet_code'] == 'ajax_filter_seo') {
            $queries = array();
            $implode = array();
            $add = '';

            foreach ($data['fields'] as $field) {
                if (isset($field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store']) && isset($field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status'])) {
                    if ($field['code'] == 'title') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.title" : "qd.h1 as title";
                    }

                    if ($field['code'] == 'description') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.description" : "qd.description";
                    }

                    if ($field['code'] == 'meta_title') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.meta_title" : "qd.meta_title";
                    }

                    if ($field['code'] == 'meta_description') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.meta_description" : "qd.meta_description";
                    }

                    if ($field['code'] == 'meta_keyword') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.meta_keyword" : "qd.meta_keyword";
                    }

                    if ($field['code'] == 'meta_robots') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.meta_robots" : "md.meta_robots";
                    }

                    if ($field['code'] == 'target_keyword') {
                        $implode[] = "CONCAT('[', GROUP_CONCAT(DISTINCT tk.keyword ORDER BY tk.sort_order SEPARATOR ']['), ']') as target_keyword";

                        if ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) {
                            $target_keyword_store_id = $data['store_id'];
                        } else {
                            $target_keyword_store_id = 0;
                        }

                        $add .= " LEFT JOIN " . DB_PREFIX . "d_target_keyword tk ON (tk.route = CONCAT('af_query_id=', q.query_id) AND tk.store_id = '" . (int)$target_keyword_store_id . "' AND tk.language_id = qd.language_id)";
                    }

                    if ($field['code'] == 'url_keyword') {
                        $implode[] = "uk.keyword as url_keyword";

                        if ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) {
                            $url_keyword_store_id = $data['store_id'];
                        } else {
                            $url_keyword_store_id = 0;
                        }

                        if (VERSION >= '3.0.0.0') {
                            $add .= " LEFT JOIN " . DB_PREFIX . "seo_url uk ON (uk.query = CONCAT('af_query_id=', q.query_id) AND uk.store_id = '" . (int)$url_keyword_store_id . "' AND uk.language_id = qd.language_id)";
                        } else {
                            $add .= " LEFT JOIN " . DB_PREFIX . "d_url_keyword uk ON (uk.route = CONCAT('af_query_id=', q.query_id) AND uk.store_id = '" . (int)$url_keyword_store_id . "' AND uk.language_id = qd.language_id)";
                        }
                    }
                }
            }

            if ($implode) {
                $query = $this->db->query("SELECT qd.query_id, qd.language_id, " . implode(', ', $implode) . " FROM " . DB_PREFIX . "af_query q LEFT JOIN " . DB_PREFIX . "af_query_description qd ON (qd.query_id = q.query_id) LEFT JOIN " . DB_PREFIX . "d_meta_data md ON (md.route = CONCAT('af_query_id=', q.query_id) AND md.store_id = '0' AND md.language_id = qd.language_id) LEFT JOIN " . DB_PREFIX . "d_meta_data md2 ON (md2.route = CONCAT('af_query_id=', q.query_id) AND md2.store_id = '" . (int)$data['store_id'] . "' AND md2.language_id = qd.language_id)" . $add . " GROUP BY q.query_id, qd.language_id");

                foreach ($query->rows as $result) {
                    $queries[$result['query_id']]['query_id'] = $result['query_id'];

                    foreach ($result as $field => $value) {
                        if (($field != 'query_id') && ($field != 'language_id')) {
                            $queries[$result['query_id']][$field][$result['language_id']] = $value;
                        }
                    }
                }
            }

            return $queries;
        }

        return false;
    }

    /*
    *	Save Import Elements for Manager.
    */
    public function saveImportElements($data)
    {
        $this->load->model('extension/module/' . $this->codename);

        $languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();

        $field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');

        if ($data['sheet_code'] == 'ajax_filter_seo') {
            $queries = array();
            $implode = array();
            $add = '';

            foreach ($data['fields'] as $field) {
                if (isset($field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store']) && isset($field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status'])) {
                    if ($field['code'] == 'title') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.title" : "qd.h1 as title";
                    }

                    if ($field['code'] == 'description') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.description" : "qd.description";
                    }

                    if ($field['code'] == 'meta_title') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.meta_title" : "qd.meta_title";
                    }

                    if ($field['code'] == 'meta_description') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.meta_description" : "qd.meta_description";
                    }

                    if ($field['code'] == 'meta_keyword') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.meta_keyword" : "qd.meta_keyword";
                    }

                    if ($field['code'] == 'meta_robots') {
                        $implode[] = ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) ? "md2.meta_robots" : "md.meta_robots";
                    }

                    if ($field['code'] == 'target_keyword') {
                        $implode[] = "CONCAT('[', GROUP_CONCAT(DISTINCT tk.keyword ORDER BY tk.sort_order SEPARATOR ']['), ']') as target_keyword";

                        if ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) {
                            $target_keyword_store_id = $data['store_id'];
                        } else {
                            $target_keyword_store_id = 0;
                        }

                        $add .= " LEFT JOIN " . DB_PREFIX . "d_target_keyword tk ON (tk.route = CONCAT('af_query_id=', q.query_id) AND tk.store_id = '" . (int)$target_keyword_store_id . "' AND tk.language_id = qd.language_id)";
                    }

                    if ($field['code'] == 'url_keyword') {
                        $implode[] = "uk.keyword as url_keyword";

                        if ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) {
                            $url_keyword_store_id = $data['store_id'];
                        } else {
                            $url_keyword_store_id = 0;
                        }

                        if (VERSION >= '3.0.0.0') {
                            $add .= " LEFT JOIN " . DB_PREFIX . "seo_url uk ON (uk.query = CONCAT('af_query_id=', q.query_id) AND uk.store_id = '" . (int)$url_keyword_store_id . "' AND uk.language_id = qd.language_id)";
                        } else {
                            $add .= " LEFT JOIN " . DB_PREFIX . "d_url_keyword uk ON (uk.route = CONCAT('af_query_id=', q.query_id) AND uk.store_id = '" . (int)$url_keyword_store_id . "' AND uk.language_id = qd.language_id)";
                        }
                    }
                }
            }

            if ($implode) {
                $query = $this->db->query("SELECT qd.query_id, qd.language_id, " . implode(', ', $implode) . " FROM " . DB_PREFIX . "af_query q LEFT JOIN " . DB_PREFIX . "af_query_description qd ON (qd.query_id = q.query_id) LEFT JOIN " . DB_PREFIX . "d_meta_data md ON (md.route = CONCAT('af_query_id=', q.query_id) AND md.store_id = '0' AND md.language_id = qd.language_id) LEFT JOIN " . DB_PREFIX . "d_meta_data md2 ON (md2.route = CONCAT('af_query_id=', q.query_id) AND md2.store_id = '" . (int)$data['store_id'] . "' AND md2.language_id = qd.language_id)" . $add . " GROUP BY q.query_id, qd.language_id");

                foreach ($query->rows as $result) {
                    $queries[$result['query_id']]['query_id'] = $result['query_id'];

                    foreach ($result as $field => $value) {
                        if (($field != 'query_id') && ($field != 'language_id')) {
                            $queries[$result['query_id']][$field][$result['language_id']] = $value;
                        }
                    }
                }
            }

            foreach ($data['elements'] as $element) {
                if (isset($queries[$element['query_id']])) {
                    $category = $queries[$element['query_id']];

                    foreach ($languages as $language) {
                        $implode1 = array();
                        $implode2 = array();
                        $implode3 = array();

                        foreach ($data['fields'] as $field) {
                            if (($field['code'] == 'title') || ($field['code'] == 'description') || ($field['code'] == 'meta_title') || ($field['code'] == 'meta_description') || ($field['code'] == 'meta_keyword')) {
                                if ($field['code'] == 'title') {
                                    $field['code'] = 'h1';
                                }
                                if (isset($element[$field['code']][$language['language_id']]) && isset($category[$field['code']][$language['language_id']])) {
                                    if ($element[$field['code']][$language['language_id']] != $category[$field['code']][$language['language_id']]) {
                                        if ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) {
                                            $implode3[] = $field['code'] . " = '" . $this->db->escape($element[$field['code']][$language['language_id']]) . "'";
                                        } else {
                                            $implode1[] = $field['code'] . " = '" . $this->db->escape($element[$field['code']][$language['language_id']]) . "'";
                                        }
                                    }
                                }
                            }

                            if ($field['code'] == 'meta_robots') {
                                if (isset($element[$field['code']][$language['language_id']]) && isset($category[$field['code']][$language['language_id']])) {
                                    if ($element[$field['code']][$language['language_id']] != $category[$field['code']][$language['language_id']]) {
                                        if ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field'][$field['code']]['multi_store_status']) {
                                            $implode3[] = $field['code'] . " = '" . $this->db->escape($element[$field['code']][$language['language_id']]) . "'";
                                        } else {
                                            $implode2[] = $field['code'] . " = '" . $this->db->escape($element[$field['code']][$language['language_id']]) . "'";
                                        }
                                    }
                                }
                            }
                        }

                        if ($implode1) {
                            $this->db->query("UPDATE " . DB_PREFIX . "af_query_description SET " . implode(', ', $implode1) . " WHERE query_id = '" . (int)$category['query_id'] . "' AND language_id = '" . (int)$language['language_id'] . "'");
                        }

                        if ($implode2) {
                            $this->db->query("UPDATE " . DB_PREFIX . "d_meta_data SET " . implode(', ', $implode2) . " WHERE route='af_query_id=" . (int)$category['query_id'] . "' AND store_id = '0' AND language_id = '" . (int)$language['language_id'] . "'");

                            if (!$this->db->countAffected()) {
                                $this->db->query("INSERT INTO " . DB_PREFIX . "d_meta_data SET route='af_query_id=" . (int)$category['query_id'] . "', store_id = '0', language_id = '" . (int)$language['language_id'] . "', " . implode(', ', $implode2) . "'");
                            }
                        }

                        if ($implode3) {
                            $this->db->query("UPDATE " . DB_PREFIX . "d_meta_data SET " . implode(', ', $implode3) . " WHERE route='af_query_id=" . (int)$category['query_id'] . "' AND store_id = '" . (int)$data['store_id'] . "' AND language_id = '" . (int)$language['language_id'] . "'");

                            if (!$this->db->countAffected()) {
                                $this->db->query("INSERT INTO " . DB_PREFIX . "d_meta_data SET route='af_query_id=" . (int)$category['query_id'] . "', store_id = '" . (int)$data['store_id'] . "', language_id = '" . (int)$language['language_id'] . "', " . implode(', ', $implode3) . "'");
                            }
                        }

                        if (isset($element['target_keyword'][$language['language_id']])) {
                            if ((isset($category['target_keyword'][$language['language_id']]) && ($element['target_keyword'][$language['language_id']] != $category['target_keyword'][$language['language_id']])) || !isset($category['target_keyword'][$language['language_id']])) {
                                if ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field']['target_keyword']['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field']['target_keyword']['multi_store_status']) {
                                    $target_keyword_store_id = $data['store_id'];
                                } else {
                                    $target_keyword_store_id = 0;
                                }

                                $this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'af_query_id=" . (int)$category['query_id'] . "' AND store_id = '" . (int)$target_keyword_store_id . "' AND language_id = '" . (int)$language['language_id'] . "'");

                                if ($element['target_keyword'][$language['language_id']]) {
                                    preg_match_all('/\[[^]]+\]/', $element['target_keyword'][$language['language_id']], $keywords);

                                    $sort_order = 1;

                                    foreach ($keywords[0] as $keyword) {
                                        $keyword = substr($keyword, 1, strlen($keyword) - 2);
                                        $this->db->query("INSERT INTO " . DB_PREFIX . "d_target_keyword SET route = 'af_query_id=" . (int)$category['query_id'] . "', store_id = '" . (int)$target_keyword_store_id . "', language_id = '" . (int)$language['language_id'] . "', sort_order = '" . $sort_order . "', keyword = '" . $this->db->escape($keyword) . "'");
                                        $sort_order++;
                                    }
                                }
                            }
                        }

                        if (isset($element['url_keyword'][$language['language_id']])) {
                            if ((isset($category['url_keyword'][$language['language_id']]) && ($element['url_keyword'][$language['language_id']] != $category['url_keyword'][$language['language_id']])) || !isset($category['url_keyword'][$language['language_id']])) {
                                if ($data['store_id'] && $field_info['sheet'][$data['sheet_code']]['field']['url_keyword']['multi_store'] && $field_info['sheet'][$data['sheet_code']]['field']['url_keyword']['multi_store_status']) {
                                    $url_keyword_store_id = $data['store_id'];
                                } else {
                                    $url_keyword_store_id = 0;
                                }

                                if (VERSION >= '3.0.0.0') {
                                    $this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'af_query_id=" . (int)$element['query_id'] . "' AND store_id = '" . (int)$url_keyword_store_id . "' AND language_id = '" . (int)$language['language_id'] . "'");

                                    if (trim($element['url_keyword'][$language['language_id']])) {
                                        $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET query = 'af_query_id=" . (int)$element['query_id'] . "', store_id='" . (int)$url_keyword_store_id . "', language_id='" . (int)$language['language_id'] . "', keyword = '" . $this->db->escape($element['url_keyword'][$language['language_id']]) . "'");
                                    }
                                } else {
                                    $this->db->query("DELETE FROM " . DB_PREFIX . "d_url_keyword WHERE route = 'af_query_id=" . (int)$element['query_id'] . "' AND store_id = '" . (int)$url_keyword_store_id . "' AND language_id = '" . (int)$language['language_id'] . "'");

                                    if (trim($element['url_keyword'][$language['language_id']])) {
                                        $this->db->query("INSERT INTO " . DB_PREFIX . "d_url_keyword SET route = 'af_query_id=" . (int)$element['query_id'] . "', store_id='" . (int)$url_keyword_store_id . "', language_id='" . (int)$language['language_id'] . "', keyword = '" . $this->db->escape($element['url_keyword'][$language['language_id']]) . "'");
                                    }

                                    if (($url_keyword_store_id == 0) && ($language['language_id'] == (int)$this->config->get('config_language_id'))) {
                                        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'af_query_id=" . (int)$element['query_id'] . "'");

                                        if (trim($element['url_keyword'][$language['language_id']])) {
                                            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'af_query_id=" . (int)$element['query_id'] . "', keyword = '" . $this->db->escape($element['url_keyword'][$language['language_id']]) . "'");
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $this->cache->delete('url_rewrite');
        }

        return true;
    }
}
