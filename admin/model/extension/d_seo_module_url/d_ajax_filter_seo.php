<?php

class ModelExtensionDSEOModuleURLDAjaxFilterSEO extends Model
{
    private $codename = 'd_ajax_filter_seo';

    /*
    *	Generate Fields.
    */
    public function generateFields($data)
    {
        $this->load->model('extension/module/' . $this->codename);

        $languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();

        $field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');

        if (file_exists(DIR_APPLICATION . 'model/extension/module/d_translit.php')) {
            $this->load->model('extension/module/d_translit');

            $translit_data = true;
        } else {
            $translit_data = false;
        }

        if (isset($data['sheet']['ajax_filter_seo']['field'])) {
            $field = array();
            $implode = array();

            if (isset($data['sheet']['ajax_filter_seo']['field']['url_keyword']) && isset($field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store_status'])) {
                $field = $data['sheet']['ajax_filter_seo']['field']['url_keyword'];
                $implode[] = ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store_status']) ? "uk2.keyword as url_keyword" : "uk.keyword as url_keyword";
            }

            if ($data['store_id'] && isset($field_info['sheet']['ajax_filter_seo']['field']['title']['multi_store']) && $field_info['sheet']['ajax_filter_seo']['field']['title']['multi_store'] && isset($field_info['sheet']['ajax_filter_seo']['field']['title']['multi_store_status']) && $field_info['sheet']['ajax_filter_seo']['field']['title']['multi_store_status']) {
                $implode[] = "md.title";
                $add = "LEFT JOIN " . DB_PREFIX . "d_meta_data md ON (md.route = CONCAT('af_query_id=', q.query_id) AND md.store_id = '" . (int)$data['store_id'] . "' AND md.language_id = qd.language_id)";
            } else {
                $implode[] = "qd.h1 as title";
                $add = "";
            }

            $queries = array();

            if ($field) {
                $field_template = isset($field['template']) ? $field['template'] : '';
                $field_overwrite = isset($field['overwrite']) ? $field['overwrite'] : 1;

                if ($translit_data) {
                    $translit_data = array(
                        'translit_symbol_status' => isset($field['translit_symbol_status']) ? $field['translit_symbol_status'] : 1,
                        'translit_language_symbol_status' => isset($field['translit_language_symbol_status']) ? $field['translit_language_symbol_status'] : 1,
                        'transform_language_symbol_id' => isset($field['transform_language_symbol_id']) ? $field['transform_language_symbol_id'] : 0
                    );
                }

                $field_data = array(
                    'field_code' => 'target_keyword',
                    'filter' => array('store_id' => $data['store_id'])
                );

                $target_keywords = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);

                if (VERSION >= '3.0.0.0') {
                    $query = $this->db->query("SELECT qd.query_id, qd.language_id, " . implode(', ', $implode) . " FROM " . DB_PREFIX . "af_query q LEFT JOIN " . DB_PREFIX . "af_query_description qd ON (qd.query_id = q.query_id) " . $add . " LEFT JOIN " . DB_PREFIX . "seo_url uk ON (uk.query = CONCAT('af_query_id=', q.query_id) AND uk.store_id = '0' AND uk.language_id = qd.language_id) LEFT JOIN " . DB_PREFIX . "seo_url uk2 ON (uk2.query = CONCAT('af_query_id=', q.query_id) AND uk2.store_id = '" . (int)$data['store_id'] . "' AND uk2.language_id = qd.language_id) GROUP BY q.query_id, qd.language_id");
                } else {
                    $query = $this->db->query("SELECT qd.query_id, qd.language_id, " . implode(', ', $implode) . " FROM " . DB_PREFIX . "af_query q LEFT JOIN " . DB_PREFIX . "af_query_description qd ON (qd.query_id = q.query_id) " . $add . " LEFT JOIN " . DB_PREFIX . "d_url_keyword uk ON (uk.route = CONCAT('af_query_id=', q.query_id) AND uk.store_id = '0' AND uk.language_id = qd.language_id) LEFT JOIN " . DB_PREFIX . "d_url_keyword uk2 ON (uk2.route = CONCAT('af_query_id=', q.query_id) AND uk2.store_id = '" . (int)$data['store_id'] . "' AND uk2.language_id = qd.language_id) GROUP BY q.query_id, qd.language_id");
                }

                foreach ($query->rows as $result) {
                    $queries[$result['query_id']]['query_id'] = $result['query_id'];

                    foreach ($result as $field => $value) {
                        if (($field != 'query_id') && ($field != 'language_id')) {
                            $queries[$result['query_id']][$field][$result['language_id']] = $value;
                        }
                    }
                }
            }

            foreach ($queries as $query) {
                foreach ($languages as $language) {
                    if (isset($target_keywords['af_query_id=' . $query['query_id']][$data['store_id']][$language['language_id']])) {
                        $target_keyword = $target_keywords['af_query_id=' . $query['query_id']][$data['store_id']][$language['language_id']];
                    } else {
                        $target_keyword = array();
                    }

                    if (is_array($field_template)) {
                        $field_new = $field_template[$language['language_id']];
                    } else {
                        $field_new = $field_template;
                    }

                    $field_new = strtr($field_new, array('[title]' => $query['title'][$language['language_id']]));
                    $field_new = $this->replaceTargetKeyword($field_new, $target_keyword);

                    if ($translit_data) {
                        $field_new = $this->model_extension_module_d_translit->translit($field_new, $translit_data);
                    }

                    if (isset($data['sheet']['ajax_filter_seo']['field']['url_keyword']) && isset($field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store_status'])) {
                        if ((isset($query['url_keyword'][$language['language_id']]) && ($field_new != $query['url_keyword'][$language['language_id']]) && $field_overwrite) || !isset($query['url_keyword'][$language['language_id']])) {
                            if ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store_status']) {
                                $url_keyword_store_id = $data['store_id'];
                            } else {
                                $url_keyword_store_id = 0;
                            }

                            if (VERSION >= '3.0.0.0') {
                                $this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'af_query_id=" . (int)$query['query_id'] . "' AND store_id = '" . (int)$url_keyword_store_id . "' AND language_id = '" . (int)$language['language_id'] . "'");

                                if (trim($field_new)) {
                                    $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET query = 'af_query_id=" . (int)$query['query_id'] . "', store_id='" . (int)$url_keyword_store_id . "', language_id='" . (int)$language['language_id'] . "', keyword = '" . $this->db->escape($field_new) . "'");
                                }
                            } else {
                                $this->db->query("DELETE FROM " . DB_PREFIX . "d_url_keyword WHERE route = 'af_query_id=" . (int)$query['query_id'] . "' AND store_id = '" . (int)$url_keyword_store_id . "' AND language_id = '" . (int)$language['language_id'] . "'");

                                if (trim($field_new)) {
                                    $this->db->query("INSERT INTO " . DB_PREFIX . "d_url_keyword SET route = 'af_query_id=" . (int)$query['query_id'] . "', store_id='" . (int)$url_keyword_store_id . "', language_id='" . (int)$language['language_id'] . "', keyword = '" . $this->db->escape($field_new) . "'");
                                }

                                if (($url_keyword_store_id == 0) && ($language['language_id'] == (int)$this->config->get('config_language_id'))) {
                                    $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'af_query_id=" . (int)$query['query_id'] . "'");

                                    if (trim($field_new)) {
                                        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'af_query_id=" . (int)$query['query_id'] . "', keyword = '" . $this->db->escape($field_new) . "'");
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $this->cache->delete('url_rewrite');
        }
    }

    /*
    *	Clear Fields.
    */

    private function replaceTargetKeyword($field_template, $target_keyword)
    {
        $field_template = preg_replace_callback('/\[target_keyword[^]]+\]/', function ($matches) use ($target_keyword) {
            $replacement_target_keyword = '';

            if (preg_match('/#number=[0-9]+/', $matches[0], $matches_number)) {
                $explode = explode('=', $matches_number[0]);
                $number = $explode[1];

                if (isset($target_keyword[$number])) {
                    $replacement_target_keyword = $target_keyword[$number];
                }
            }

            return $replacement_target_keyword;
        }, $field_template);

        return $field_template;
    }

    /*
    *	Replace Target Keyword.
    */

    public function clearFields($data)
    {
        $this->load->model('extension/module/' . $this->codename);

        $languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();

        $field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');

        if (isset($data['sheet']['ajax_filter_seo'])) {
            $field = array();
            $implode = array();

            if (isset($data['sheet']['ajax_filter_seo']['field']['url_keyword']) && isset($field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store_status'])) {
                $field = $data['sheet']['ajax_filter_seo']['field']['url_keyword'];
                $implode[] = ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store_status']) ? "uk2.keyword as url_keyword" : "uk.keyword as url_keyword";
            }

            $categories = array();

            if ($field) {
                if (VERSION >= '3.0.0.0') {
                    $query = $this->db->query("SELECT cd.query_id, cd.language_id, " . implode(', ', $implode) . " FROM " . DB_PREFIX . "af_query c LEFT JOIN " . DB_PREFIX . "af_query_description cd ON (cd.query_id = c.query_id) LEFT JOIN " . DB_PREFIX . "seo_url uk ON (uk.query = CONCAT('af_query_id=', c.query_id) AND uk.store_id = '0' AND uk.language_id = cd.language_id) LEFT JOIN " . DB_PREFIX . "seo_url uk2 ON (uk2.query = CONCAT('af_query_id=', c.query_id) AND uk2.store_id = '" . (int)$data['store_id'] . "' AND uk2.language_id = cd.language_id) GROUP BY c.query_id, cd.language_id");
                } else {
                    $query = $this->db->query("SELECT cd.query_id, cd.language_id, " . implode(', ', $implode) . " FROM " . DB_PREFIX . "af_query c LEFT JOIN " . DB_PREFIX . "af_query_description cd ON (cd.query_id = c.query_id) LEFT JOIN " . DB_PREFIX . "d_url_keyword uk ON (uk.route = CONCAT('af_query_id=', c.query_id) AND uk.store_id = '0' AND uk.language_id = cd.language_id) LEFT JOIN " . DB_PREFIX . "d_url_keyword uk2 ON (uk2.route = CONCAT('af_query_id=', c.query_id) AND uk2.store_id = '" . (int)$data['store_id'] . "' AND uk2.language_id = cd.language_id) GROUP BY c.query_id, cd.language_id");
                }

                foreach ($query->rows as $result) {
                    $categories[$result['query_id']]['query_id'] = $result['query_id'];

                    foreach ($result as $field => $value) {
                        if (($field != 'query_id') && ($field != 'language_id')) {
                            $categories[$result['query_id']][$field][$result['language_id']] = $value;
                        }
                    }
                }
            }

            foreach ($categories as $query) {
                foreach ($languages as $language) {
                    if (isset($data['sheet']['ajax_filter_seo']['field']['url_keyword']) && isset($query['url_keyword'][$language['language_id']]) && isset($field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store_status'])) {
                        if ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['url_keyword']['multi_store_status']) {
                            $url_keyword_store_id = $data['store_id'];
                        } else {
                            $url_keyword_store_id = 0;
                        }

                        if (VERSION >= '3.0.0.0') {
                            $this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'af_query_id=" . (int)$query['query_id'] . "' AND store_id = '" . (int)$url_keyword_store_id . "' AND language_id = '" . (int)$language['language_id'] . "'");
                        } else {
                            $this->db->query("DELETE FROM " . DB_PREFIX . "d_url_keyword WHERE route = 'af_query_id=" . (int)$query['query_id'] . "' AND store_id = '" . (int)$url_keyword_store_id . "' AND language_id = '" . (int)$language['language_id'] . "'");

                            if (($url_keyword_store_id == 0) && ($language['language_id'] == (int)$this->config->get('config_language_id'))) {
                                $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'af_query_id=" . (int)$query['query_id'] . "'");
                            }
                        }
                    }
                }
            }

            $this->cache->delete('path.blog_category');
            $this->cache->delete('path.blog_post');
            $this->cache->delete('url_rewrite');
        }

        if (isset($data['sheet']['blog_post'])) {
            $field = array();
            $implode = array();

            if (isset($data['sheet']['blog_post']['field']['url_keyword']) && isset($field_info['sheet']['blog_post']['field']['url_keyword']['multi_store']) && isset($field_info['sheet']['blog_post']['field']['url_keyword']['multi_store_status'])) {
                $field = $data['sheet']['blog_post']['field']['url_keyword'];
                $implode[] = ($data['store_id'] && $field_info['sheet']['blog_post']['field']['url_keyword']['multi_store'] && $field_info['sheet']['blog_post']['field']['url_keyword']['multi_store_status']) ? "uk2.keyword as url_keyword" : "uk.keyword as url_keyword";
            }

            $posts = array();

            if ($field) {
                if (VERSION >= '3.0.0.0') {
                    $query = $this->db->query("SELECT pd.post_id, pd.language_id, " . implode(', ', $implode) . " FROM " . DB_PREFIX . "bm_post p LEFT JOIN " . DB_PREFIX . "bm_post_description pd ON (pd.post_id = p.post_id) LEFT JOIN " . DB_PREFIX . "seo_url uk ON (uk.query = CONCAT('bm_post_id=', p.post_id) AND uk.store_id = '0' AND uk.language_id = pd.language_id) LEFT JOIN " . DB_PREFIX . "seo_url uk2 ON (uk2.query = CONCAT('bm_post_id=', p.post_id) AND uk2.store_id = '" . (int)$data['store_id'] . "' AND uk2.language_id = pd.language_id) GROUP BY p.post_id, pd.language_id");
                } else {
                    $query = $this->db->query("SELECT pd.post_id, pd.language_id, " . implode(', ', $implode) . " FROM " . DB_PREFIX . "bm_post p LEFT JOIN " . DB_PREFIX . "bm_post_description pd ON (pd.post_id = p.post_id) LEFT JOIN " . DB_PREFIX . "d_url_keyword uk ON (uk.route = CONCAT('bm_post_id=', p.post_id) AND uk.store_id = '0' AND uk.language_id = pd.language_id) LEFT JOIN " . DB_PREFIX . "d_url_keyword uk2 ON (uk2.route = CONCAT('bm_post_id=', p.post_id) AND uk2.store_id = '" . (int)$data['store_id'] . "' AND uk2.language_id = pd.language_id) GROUP BY p.post_id, pd.language_id");
                }

                foreach ($query->rows as $result) {
                    $posts[$result['post_id']]['post_id'] = $result['post_id'];

                    foreach ($result as $field => $value) {
                        if (($field != 'post_id') && ($field != 'language_id')) {
                            $posts[$result['post_id']][$field][$result['language_id']] = $value;
                        }
                    }
                }
            }

            foreach ($posts as $post) {
                foreach ($languages as $language) {
                    if (isset($data['sheet']['blog_post']['field']['url_keyword']) && isset($post['url_keyword'][$language['language_id']]) && isset($field_info['sheet']['blog_post']['field']['url_keyword']['multi_store']) && isset($field_info['sheet']['post']['field']['url_keyword']['multi_store_status'])) {
                        if ($data['store_id'] && $field_info['sheet']['blog_post']['field']['url_keyword']['multi_store'] && $field_info['sheet']['blog_post']['field']['url_keyword']['multi_store_status']) {
                            $url_keyword_store_id = $data['store_id'];
                        } else {
                            $url_keyword_store_id = 0;
                        }

                        if (VERSION >= '3.0.0.0') {
                            $this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'bm_post_id=" . (int)$post['post_id'] . "' AND store_id = '" . (int)$url_keyword_store_id . "' AND language_id = '" . (int)$language['language_id'] . "'");
                        } else {
                            $this->db->query("DELETE FROM " . DB_PREFIX . "d_url_keyword WHERE route = 'bm_post_id=" . (int)$post['post_id'] . "' AND store_id = '" . (int)$url_keyword_store_id . "' AND language_id = '" . (int)$language['language_id'] . "'");

                            if (($url_keyword_store_id == 0) && ($language['language_id'] == (int)$this->config->get('config_language_id'))) {
                                $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'bm_post_id=" . (int)$post['post_id'] . "'");
                            }
                        }
                    }
                }
            }

            $this->cache->delete('path.blog_post');
            $this->cache->delete('url_rewrite');
        }

        if (isset($data['sheet']['blog_author'])) {
            $field = array();
            $implode = array();

            if (isset($data['sheet']['blog_author']['field']['url_keyword']) && isset($field_info['sheet']['blog_author']['field']['url_keyword']['multi_store']) && isset($field_info['sheet']['blog_author']['field']['url_keyword']['multi_store_status'])) {
                $field = $data['sheet']['blog_author']['field']['url_keyword'];
                $implode[] = ($data['store_id'] && $field_info['sheet']['blog_author']['field']['url_keyword']['multi_store'] && $field_info['sheet']['blog_author']['field']['url_keyword']['multi_store_status']) ? "uk2.keyword as url_keyword" : "uk.keyword as url_keyword";;
            }

            $authors = array();

            if ($field) {
                if (VERSION >= '3.0.0.0') {
                    $query = $this->db->query("SELECT ad.author_id, ad.language_id, " . implode(', ', $implode) . " FROM " . DB_PREFIX . "bm_author a LEFT JOIN " . DB_PREFIX . "bm_author_description ad ON (ad.author_id = a.author_id) " . $add . " LEFT JOIN " . DB_PREFIX . "seo_url uk ON (uk.query = CONCAT('bm_author_id=', a.author_id) AND uk.store_id = '0' AND uk.language_id = ad.language_id) LEFT JOIN " . DB_PREFIX . "seo_url uk2 ON (uk2.query = CONCAT('bm_author_id=', a.author_id) AND uk2.store_id = '" . (int)$data['store_id'] . "' AND uk2.language_id = ad.language_id) GROUP BY a.author_id, ad.language_id");
                } else {
                    $query = $this->db->query("SELECT ad.author_id, ad.language_id, " . implode(', ', $implode) . " FROM " . DB_PREFIX . "bm_author a LEFT JOIN " . DB_PREFIX . "bm_author_description ad ON (ad.author_id = a.author_id) LEFT JOIN " . DB_PREFIX . "d_url_keyword uk ON (uk.route = CONCAT('bm_author_id=', a.author_id) AND uk.store_id = '0' AND uk.language_id = ad.language_id) LEFT JOIN " . DB_PREFIX . "d_url_keyword uk2 ON (uk2.route = CONCAT('bm_author_id=', a.author_id) AND uk2.store_id = '" . (int)$data['store_id'] . "' AND uk2.language_id = ad.language_id) GROUP BY a.author_id, ad.language_id");
                }

                foreach ($query->rows as $result) {
                    $authors[$result['author_id']]['author_id'] = $result['author_id'];

                    foreach ($result as $field => $value) {
                        if (($field != 'author_id') && ($field != 'language_id')) {
                            $authors[$result['author_id']][$field][$result['language_id']] = $value;
                        }
                    }
                }
            }

            foreach ($authors as $author) {
                foreach ($languages as $language) {
                    if (isset($data['sheet']['blog_author']['field']['url_keyword']) && isset($author['url_keyword'][$language['language_id']]) && isset($field_info['sheet']['blog_author']['field']['url_keyword']['multi_store']) && isset($field_info['sheet']['blog_author']['field']['url_keyword']['multi_store_status'])) {
                        if ($data['store_id'] && $field_info['sheet']['blog_author']['field']['url_keyword']['multi_store'] && $field_info['sheet']['blog_author']['field']['url_keyword']['multi_store_status']) {
                            $url_keyword_store_id = $data['store_id'];
                        } else {
                            $url_keyword_store_id = 0;
                        }

                        if (VERSION >= '3.0.0.0') {
                            $this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'bm_author_id=" . (int)$author['author_id'] . "' AND store_id = '" . (int)$url_keyword_store_id . "' AND language_id = '" . (int)$language['language_id'] . "'");
                        } else {
                            $this->db->query("DELETE FROM " . DB_PREFIX . "d_url_keyword WHERE route = 'bm_author_id=" . (int)$author['author_id'] . "' AND store_id = '" . (int)$url_keyword_store_id . "' AND language_id = '" . (int)$language['language_id'] . "'");

                            if (($url_keyword_store_id == 0) && ($language['language_id'] == (int)$this->config->get('config_language_id'))) {
                                $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'bm_author_id=" . (int)$author['author_id'] . "'");
                            }
                        }
                    }
                }
            }

            $this->cache->delete('url_rewrite');
        }
    }
}
