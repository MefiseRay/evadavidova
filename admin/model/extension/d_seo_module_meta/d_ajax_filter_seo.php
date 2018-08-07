<?php
class ModelExtensionDSEOModuleMetaDAjaxFilterSEO extends Model
{
    private $codename = 'd_ajax_filter_seo';
    
    /*
    *	Generate Fields.
    */
    public function generateFields($data)
    {
        $this->load->model('extension/module/' . $this->codename);
        
        $store = $this->{'model_extension_module_' . $this->codename}->getStore($data['store_id']);
        $languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();
                                
        $field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');
        
        $field_data = array(
            'field_code' => 'meta_data',
            'filter' => array(
                'route' => 'common/home',
                'store_id' => $data['store_id']
            )
        );
        
        $meta_data = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);
        
        if (file_exists(DIR_APPLICATION . 'model/extension/module/d_translit.php')) {
            $this->load->model('extension/module/d_translit');
            
            $translit_data = true;
        } else {
            $translit_data = false;
        }
        
        if (isset($data['sheet']['ajax_filter_seo']['field'])) {
            $field = array();
            $implode = array();
                        
            if (isset($data['sheet']['ajax_filter_seo']['field']['meta_title']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store_status'])) {
                $field = $data['sheet']['ajax_filter_seo']['field']['meta_title'];
                $implode[] = ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store_status']) ? "md2.meta_title" : "qd.meta_title";
            }
            
            if (isset($data['sheet']['ajax_filter_seo']['field']['meta_description']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store_status'])) {
                $field = $data['sheet']['ajax_filter_seo']['field']['meta_description'];
                $implode[] = ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store_status']) ? "md2.meta_description" : "qd.meta_description";
            }
            
            if (isset($data['sheet']['ajax_filter_seo']['field']['meta_keyword']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store_status'])) {
                $field = $data['sheet']['ajax_filter_seo']['field']['meta_keyword'];
                $implode[] = ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store_status']) ? "md2.meta_keyword" : "qd.meta_keyword";
            }
            
            if (isset($field_info['sheet']['ajax_filter_seo']['field']['title']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['title']['multi_store_status'])) {
                $implode[] = ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['title']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['title']['multi_store_status']) ? "md2.title" : "qd.h1 as title";
            }
                        
            if (isset($field_info['sheet']['ajax_filter_seo']['field']['description']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['description']['multi_store_status'])) {
                $implode[] = ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['description']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['description']['multi_store_status']) ? "md2.description" : "qd.description";
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
                
                $query = $this->db->query("SELECT qd.query_id, qd.language_id, " . implode(', ', $implode) . " FROM " . DB_PREFIX . "af_query q LEFT JOIN " . DB_PREFIX . "af_query_description qd ON (qd.query_id = q.query_id) LEFT JOIN " . DB_PREFIX . "d_meta_data md ON (md.route = CONCAT('af_query_id=', q.query_id) AND md.store_id = '0' AND md.language_id = qd.language_id) LEFT JOIN " . DB_PREFIX . "d_meta_data md2 ON (md2.route = CONCAT('af_query_id=', q.query_id) AND md2.store_id = '" . (int)$data['store_id'] . "' AND md2.language_id = qd.language_id)  GROUP BY q.query_id, qd.language_id");
                    
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
                    
                    if (isset($meta_data['common/home'][$data['store_id']][$language['language_id']]['meta_title'])) {
                        $store_title = $meta_data['common/home'][$data['store_id']][$language['language_id']]['meta_title'];
                    } else {
                        $store_title = '';
                    }
                    
                    if (is_array($field_template)) {
                        $field_new = $field_template[$language['language_id']];
                    } else {
                        $field_new = $field_template;
                    }
                    
                    $field_new = strtr($field_new, array(
                        '[title]' => $query['title'][$language['language_id']],
                        '[store_name]' => $store['name'],
                        '[store_title]' => $store_title
                    ));
                    $field_new = $this->replaceDescription($field_new, $query['description'][$language['language_id']]);
                    $field_new = $this->replaceTargetKeyword($field_new, $target_keyword);
                    
                    if ($translit_data) {
                        $field_new = $this->model_extension_module_d_translit->translit($field_new, $translit_data);
                    }
                    
                    $implode = array();
                    
                    if (isset($data['sheet']['ajax_filter_seo']['field']['meta_title']) && isset($query['meta_title'][$language['language_id']]) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store_status'])) {
                        if (($field_new != $query['meta_title'][$language['language_id']]) && ($field_overwrite || !$query['meta_title'][$language['language_id']])) {
                            if ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store_status']) {
                                $this->db->query("UPDATE " . DB_PREFIX . "d_meta_data SET meta_title = '" . $this->db->escape($field_new) . "' WHERE route='af_query_id=" . (int)$query['query_id'] . "' AND store_id = '" . (int)$data['store_id'] . "' AND language_id = '" . (int)$language['language_id'] . "'");
                                
                                if (!$this->db->countAffected()) {
                                    $this->db->query("INSERT INTO " . DB_PREFIX . "d_meta_data SET route='af_query_id=" . (int)$query['query_id'] . "', store_id = '" . (int)$data['store_id'] . "', language_id = '" . (int)$language['language_id'] . "', meta_title = '" . $this->db->escape($field_new) . "'");
                                }
                            } else {
                                $this->db->query("UPDATE " . DB_PREFIX . "af_query_description SET meta_title = '" . $this->db->escape($field_new) . "' WHERE query_id = '" . (int)$query['query_id'] . "' AND language_id = '" . (int)$language['language_id'] . "'");
                            }
                        }
                    }
                    
                    if (isset($data['sheet']['ajax_filter_seo']['field']['meta_description']) && isset($query['meta_description'][$language['language_id']]) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store_status'])) {
                        if (($field_new != $query['meta_description'][$language['language_id']]) && ($field_overwrite || !$query['meta_description'][$language['language_id']])) {
                            if ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store_status']) {
                                $this->db->query("UPDATE " . DB_PREFIX . "d_meta_data SET meta_description = '" . $this->db->escape($field_new) . "' WHERE route='af_query_id=" . (int)$query['query_id'] . "' AND store_id = '" . (int)$data['store_id'] . "' AND language_id = '" . (int)$language['language_id'] . "'");
                                
                                if (!$this->db->countAffected()) {
                                    $this->db->query("INSERT INTO " . DB_PREFIX . "d_meta_data SET route='af_query_id=" . (int)$query['query_id'] . "', store_id = '" . (int)$data['store_id'] . "', language_id = '" . (int)$language['language_id'] . "', meta_description = '" . $this->db->escape($field_new) . "'");
                                }
                            } else {
                                $this->db->query("UPDATE " . DB_PREFIX . "af_query_description SET meta_description = '" . $this->db->escape($field_new) . "' WHERE query_id = '" . (int)$query['query_id'] . "' AND language_id = '" . (int)$language['language_id'] . "'");
                            }
                        }
                    }
                    
                    if (isset($data['sheet']['ajax_filter_seo']['field']['meta_keyword']) && isset($query['meta_keyword'][$language['language_id']]) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store_status'])) {
                        if (($field_new != $query['meta_keyword'][$language['language_id']]) && ($field_overwrite || !$query['meta_keyword'][$language['language_id']])) {
                            if ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store_status']) {
                                $this->db->query("UPDATE " . DB_PREFIX . "d_meta_data SET meta_keyword = '" . $this->db->escape($field_new) . "' WHERE route='af_query_id=" . (int)$query['query_id'] . "' AND store_id = '" . (int)$data['store_id'] . "' AND language_id = '" . (int)$language['language_id'] . "'");
                                
                                if (!$this->db->countAffected()) {
                                    $this->db->query("INSERT INTO " . DB_PREFIX . "d_meta_data SET route='af_query_id=" . (int)$query['query_id'] . "', store_id = '" . (int)$data['store_id'] . "', language_id = '" . (int)$language['language_id'] . "', meta_keyword = '" . $this->db->escape($field_new) . "'");
                                }
                            } else {
                                $this->db->query("UPDATE " . DB_PREFIX . "af_query_description SET meta_keyword = '" . $this->db->escape($field_new) . "' WHERE query_id = '" . (int)$query['query_id'] . "' AND language_id = '" . (int)$language['language_id'] . "'");
                            }
                        }
                    }
                }
            }
        }
    }
    
    /*
    *	Clear Fields.
    */
    public function clearFields($data)
    {
        $this->load->model('extension/module/' . $this->codename);
        
        $store = $this->{'model_extension_module_' . $this->codename}->getStore($data['store_id']);
        $languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();
                                
        $field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');
        
        if (isset($data['sheet']['ajax_filter_seo']['field'])) {
            if (isset($data['sheet']['ajax_filter_seo']['field']['meta_title']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store_status'])) {
                $field = $data['sheet']['ajax_filter_seo']['field']['meta_title'];
                $implode[] = ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store_status']) ? "md2.meta_title" : "cd.meta_title";
            }
            
            if (isset($data['sheet']['ajax_filter_seo']['field']['meta_description']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store_status'])) {
                $field = $data['sheet']['ajax_filter_seo']['field']['meta_description'];
                $implode[] = ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store_status']) ? "md2.meta_description" : "cd.meta_description";
            }
            
            if (isset($data['sheet']['ajax_filter_seo']['field']['meta_keyword']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store_status'])) {
                $field = $data['sheet']['ajax_filter_seo']['field']['meta_keyword'];
                $implode[] = ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store_status']) ? "md2.meta_keyword" : "cd.meta_keyword";
            }
            
            $queries = array();
            
            $query = $this->db->query("SELECT qd.query_id, qd.language_id, " . implode(', ', $implode) . " FROM " . DB_PREFIX . "af_query q LEFT JOIN " . DB_PREFIX . "af_query_description qd ON (qd.query_id = q.query_id) LEFT JOIN " . DB_PREFIX . "d_meta_data md ON (md.route = CONCAT('af_query_id=', q.query_id) AND md.store_id = '0' AND md.language_id = qd.language_id) LEFT JOIN " . DB_PREFIX . "d_meta_data md2 ON (md2.route = CONCAT('af_query_id=', q.query_id) AND md2.store_id = '" . (int)$data['store_id'] . "' AND md2.language_id = qd.language_id) GROUP BY q.query_id, qd.language_id");
                        
            foreach ($query->rows as $result) {
                $queries[$result['query_id']]['query_id'] = $result['query_id'];
                
                foreach ($result as $field => $value) {
                    if (($field != 'query_id') && ($field != 'language_id')) {
                        $queries[$result['query_id']][$field][$result['language_id']] = $value;
                    }
                }
            }
                                
            foreach ($queries as $query) {
                foreach ($languages as $language) {
                  
                    if (isset($data['sheet']['ajax_filter_seo']['field']['meta_title']) && isset($query['meta_title'][$language['language_id']]) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store_status'])) {
                        if ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_title']['multi_store_status']) {
                            $this->db->query("UPDATE " . DB_PREFIX . "d_meta_data SET meta_title = '' WHERE route='af_query_id=" . (int)$query['query_id'] . "' AND store_id = '" . (int)$data['store_id'] . "' AND language_id = '" . (int)$language['language_id'] . "'");
                        } else {
                            $this->db->query("UPDATE " . DB_PREFIX . "af_query_description SET meta_title = '' WHERE query_id = '" . (int)$query['query_id'] . "' AND language_id = '" . (int)$language['language_id'] . "'");
                        }
                    }
                    
                    if (isset($data['sheet']['ajax_filter_seo']['field']['meta_description']) && isset($query['meta_description'][$language['language_id']]) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store_status'])) {
                        if ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_description']['multi_store_status']) {
                            $this->db->query("UPDATE " . DB_PREFIX . "d_meta_data SET meta_description = '' WHERE route='af_query_id=" . (int)$query['query_id'] . "' AND store_id = '" . (int)$data['store_id'] . "' AND language_id = '" . (int)$language['language_id'] . "'");
                        } else {
                            $this->db->query("UPDATE " . DB_PREFIX . "af_query_description SET meta_description = '' WHERE query_id = '" . (int)$query['query_id'] . "' AND language_id = '" . (int)$language['language_id'] . "'");
                        }
                    }
                    
                    if (isset($data['sheet']['ajax_filter_seo']['field']['meta_keyword']) && isset($query['meta_keyword'][$language['language_id']]) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store']) && isset($field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store_status'])) {
                        if ($data['store_id'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store'] && $field_info['sheet']['ajax_filter_seo']['field']['meta_keyword']['multi_store_status']) {
                            $this->db->query("UPDATE " . DB_PREFIX . "d_meta_data SET meta_keyword = '' WHERE route='af_query_id=" . (int)$query['query_id'] . "' AND store_id = '" . (int)$data['store_id'] . "' AND language_id = '" . (int)$language['language_id'] . "'");
                        } else {
                            $this->db->query("UPDATE " . DB_PREFIX . "af_query_description SET meta_keyword = '' WHERE query_id = '" . (int)$query['query_id'] . "' AND language_id = '" . (int)$language['language_id'] . "'");
                        }
                    }
                }
            }
        }
    }
    
    /*
    *	Replace Description.
    */
    private function replaceDescription($field_template, $description)
    {
        $field_template = preg_replace_callback('/\[description[^]]+\]/', function ($matches) use ($description) {
            $replacement_description = '';
            
            if (preg_match('/#sentences=[0-9]+/', $matches[0], $matches_sentences)) {
                $explode = explode('=', $matches_sentences[0]);
                $sentence_total = $explode[1];
                $sentences = preg_split('/[.!?]/', htmlentities(strip_tags(html_entity_decode($description))));
                $i = 0;
                
                foreach ($sentences as $sentence) {
                    $replacement_description .= $sentence . '.';
                    $i++;
                    if ($i>=$sentence_total) {
                        break;
                    }
                }
            }
            
            return $replacement_description;
        }, $field_template);
        
        return $field_template;
    }
    
    /*
    *	Replace Target Keyword.
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
}
