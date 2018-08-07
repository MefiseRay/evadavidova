<?php
class ControllerExtensionDSEOModuleAjaxFilterDAjaxFilterSEO extends Controller
{
    private $codename = 'd_ajax_filter_seo';
    private $route = 'extension/d_seo_module_ajax_filter/d_ajax_filter_seo';
    private $config_file = 'd_ajax_filter_seo';
    private $error = array();

    /*
    *	Functions for SEO Module Blog.
    */
    public function query_form_tab_general_language()
    {
        $this->load->model($this->route);
        $this->load->model('extension/module/' . $this->codename);
        
        $languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();
        
        $field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');
        
        if (isset($field_info['sheet']['ajax_filter_seo']['field'])) {
            $data['fields'] = $field_info['sheet']['ajax_filter_seo']['field'];
        } else {
            $data['fields'] = array();
        }
        
        $data['error'] = ($this->config->get($this->codename . '_error')) ? $this->config->get($this->codename . '_error') : array();
                                        
        if (isset($this->request->post['meta_data'])) {
            $data['meta_data'] = $this->request->post['meta_data'];
        } elseif (isset($this->request->get['query_id'])) {
            $data['meta_data'] = $this->{'model_extension_d_seo_module_ajax_filter_' . $this->codename}->getQueryMetaData($this->request->get['query_id']);
        } else {
            $data['meta_data'] = array();
        }
        
        if (isset($this->request->post['target_keyword'])) {
            $data['target_keyword'] = $this->request->post['target_keyword'];
        } elseif (isset($this->request->get['query_id'])) {
            $data['target_keyword'] = $this->{'model_extension_d_seo_module_ajax_filter_' . $this->codename}->getQueryTargetKeyword($this->request->get['query_id']);
        } else {
            $data['target_keyword'] = array();
        }
        
        if (isset($this->request->post['url_keyword'])) {
            $data['url_keyword'] = $this->request->post['url_keyword'];
        } elseif (isset($this->request->get['query_id'])) {
            $data['url_keyword'] = $this->{'model_extension_d_seo_module_ajax_filter_' . $this->codename}->getQueryURLKeyword($this->request->get['query_id']);
        } else {
            $data['url_keyword'] = array();
        }
        
        $data['adviser_elements'] = array();
        $data['rating'] = array();
        
        if (isset($this->request->get['query_id'])) {
            $route = 'af_query_id=' . $this->request->get['query_id'];
            
            $adviser_info = $this->load->controller('extension/module/d_seo_module_adviser/getAdviserInfo', $route);
        
            if (isset($adviser_info['adviser_elements']) && isset($adviser_info['rating'])) {
                $data['adviser_elements'] = $adviser_info['adviser_elements'];
                $data['rating'] = $adviser_info['rating'];
            }
        }
        
        $data['store_id'] = 0;
            
        $html_tab_general_language = array();
                
        foreach ($languages as $language) {
            $data['language_id'] = $language['language_id'];
            
            if (isset($data['target_keyword'][$data['store_id']][$data['language_id']])) {
                foreach ($data['target_keyword'][$data['store_id']][$data['language_id']] as $sort_order => $keyword) {
                    $field_data = array(
                        'field_code' => 'target_keyword',
                        'filter' => array(
                            'store_id' => $data['store_id'],
                            'keyword' => $keyword
                        )
                    );
            
                    $target_keywords = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);
                    
                    if ($target_keywords) {
                        $store_target_keywords = reset($target_keywords);
                            
                        if ((count($target_keywords) > 1) || (count(reset($store_target_keywords)) > 1)) {
                            $data['target_keyword_duplicate'][$data['store_id']][$data['language_id']][$sort_order] = 1;
                        }
                    }
                }
            }
            
            $html_tab_general_language[$data['language_id']] = $this->load->view($this->route . '/query_form_tab_general_language', $data);
        }
                
        return $html_tab_general_language;
    }
    
    public function query_form_tab_general_store_language()
    {
        $this->load->model($this->route);
        $this->load->model('extension/module/' . $this->codename);

        $stores = $this->{'model_extension_module_' . $this->codename}->getStores();
        $languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();
        
        $field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');
        
        if (isset($field_info['sheet']['ajax_filter_seo']['field'])) {
            $data['fields'] = $field_info['sheet']['ajax_filter_seo']['field'];
        } else {
            $data['fields'] = array();
        }
        
        $data['error'] = ($this->config->get($this->codename . '_error')) ? $this->config->get($this->codename . '_error') : array();
                                        
        if (isset($this->request->post['meta_data'])) {
            $data['meta_data'] = $this->request->post['meta_data'];
        } elseif (isset($this->request->get['query_id'])) {
            $data['meta_data'] = $this->{'model_extension_d_seo_module_ajax_filter_' . $this->codename}->getQueryMetaData($this->request->get['query_id']);
        } else {
            $data['meta_data'] = array();
        }
        
        if (isset($this->request->post['target_keyword'])) {
            $data['target_keyword'] = $this->request->post['target_keyword'];
        } elseif (isset($this->request->get['query_id'])) {
            $data['target_keyword'] = $this->{'model_extension_d_seo_module_ajax_filter_' . $this->codename}->getQueryTargetKeyword($this->request->get['query_id']);
        } else {
            $data['target_keyword'] = array();
        }
        
        if (isset($this->request->post['url_keyword'])) {
            $data['url_keyword'] = $this->request->post['url_keyword'];
        } elseif (isset($this->request->get['query_id'])) {
            $data['url_keyword'] = $this->{'model_extension_d_seo_module_ajax_filter_' . $this->codename}->getQueryURLKeyword($this->request->get['query_id']);
        } else {
            $data['url_keyword'] = array();
        }
        
        $data['adviser_elements'] = array();
        $data['rating'] = array();
        
        if (isset($this->request->get['query_id'])) {
            $route = 'af_query_id=' . $this->request->get['query_id'];
            
            $adviser_info = $this->load->controller('extension/module/d_seo_module_adviser/getAdviserInfo', $route);
        
            if (isset($adviser_info['adviser_elements']) && isset($adviser_info['rating'])) {
                $data['adviser_elements'] = $adviser_info['adviser_elements'];
                $data['rating'] = $adviser_info['rating'];
            }
        }
                
        $html_tab_general_store_language = array();
        
        foreach ($stores as $store) {
            $data['store_id'] = $store['store_id'];
        
            foreach ($languages as $language) {
                $data['language_id'] = $language['language_id'];
                
                if (isset($data['target_keyword'][$data['store_id']][$data['language_id']])) {
                    foreach ($data['target_keyword'][$data['store_id']][$data['language_id']] as $sort_order => $keyword) {
                        $field_data = array(
                            'field_code' => 'target_keyword',
                            'filter' => array(
                                'store_id' => $data['store_id'],
                                'keyword' => $keyword
                            )
                        );
            
                        $target_keywords = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);
                        
                        if ($target_keywords) {
                            $store_target_keywords = reset($target_keywords);
                            
                            if ((count($target_keywords) > 1) || (count(reset($store_target_keywords)) > 1)) {
                                $data['target_keyword_duplicate'][$data['store_id']][$data['language_id']][$sort_order] = 1;
                            }
                        }
                    }
                }
                
                $html_tab_general_store_language[$data['store_id']][$data['language_id']] = $this->load->view($this->route . '/query_form_tab_general_store_language', $data);
            }
        }
        
        return $html_tab_general_store_language;
    }
    
    public function query_form_style()
    {
        return $this->load->view($this->route . '/query_form_style');
    }
    
    public function query_form_script()
    {
        $url_token = '';
        
        if (isset($this->session->data['token'])) {
            $url_token .= 'token=' . $this->session->data['token'];
        }
        
        if (isset($this->session->data['user_token'])) {
            $url_token .= 'user_token=' . $this->session->data['user_token'];
        }
        
        $data['route'] = $this->route;
        $data['url_token'] = $url_token;
        
        return $this->load->view($this->route . '/query_form_script', $data);
    }
    
    public function query_validate_form($error)
    {
        $_language = new Language();
        $_language->load($this->route);
        return $error;
        if (isset($this->request->post['meta_data'])) {
            foreach ($this->request->post['meta_data'] as $store_id => $language_meta_data) {
                foreach ($language_meta_data as $language_id => $meta_data) {
                    if ($store_id) {
                        if (isset($meta_data['title']) && ((utf8_strlen($meta_data['title']) < 2) || (utf8_strlen($meta_data['title']) > 255))) {
                            $error['meta_data'][$store_id][$language_id]['title'] = $_language->get('error_category_title');
                        }

                        if (isset($meta_data['meta_title']) && ((utf8_strlen($meta_data['meta_title']) < 3) || (utf8_strlen($meta_data['meta_title']) > 255))) {
                            $error['meta_data'][$store_id][$language_id]['meta_title'] = $_language->get('error_meta_title');
                        }
                    }
                }
            }
        }
        
        if (isset($this->request->post['url_keyword'])) {
            foreach ($this->request->post['url_keyword'] as $store_id => $language_url_keyword) {
                foreach ($language_url_keyword as $language_id => $url_keyword) {
                    if (trim($url_keyword)) {
                        $field_data = array(
                            'field_code' => 'url_keyword',
                            'filter' => array(
                            'store_id' => $store_id,
                            'keyword' => $url_keyword
                            )
                        );
            
                        $url_keywords = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);
                                    
                        if ($url_keywords) {
                            if (isset($this->request->get['query_id'])) {
                                foreach ($url_keywords as $route => $store_url_keywords) {
                                    if ($route != 'af_query_id=' . $this->request->get['query_id']) {
                                        $error['url_keyword'][$store_id][$language_id] = sprintf($_language->get('error_url_keyword_exists'), $url_keyword);
                                    }
                                }
                            } else {
                                $error['url_keyword'][$store_id][$language_id] = sprintf($_language->get('error_url_keyword_exists'), $url_keyword);
                            }
                        }
                    }
                }
            }
        }
        
        $this->config->set($this->codename . '_error', $error);
        
        return $error;
    }
    
    public function query_add($data)
    {
        $this->load->model($this->route);
        
        $this->{'model_extension_d_seo_module_ajax_filter_' . $this->codename}->saveQueryMetaData($data);
        $this->{'model_extension_d_seo_module_ajax_filter_' . $this->codename}->saveQueryTargetKeyword($data);
        $this->{'model_extension_d_seo_module_ajax_filter_' . $this->codename}->saveQueryURLKeyword($data);
    }
    
    public function query_edit($data)
    {
        $this->load->model($this->route);
        
        $this->{'model_extension_d_seo_module_ajax_filter_' . $this->codename}->saveQueryMetaData($data);
        $this->{'model_extension_d_seo_module_ajax_filter_' . $this->codename}->saveQueryTargetKeyword($data);
        $this->{'model_extension_d_seo_module_ajax_filter_' . $this->codename}->saveQueryURLKeyword($data);
    }
    
    public function query_delete($data)
    {
        $this->load->model($this->route);
        
        $this->{'model_extension_d_seo_module_ajax_filter_' . $this->codename}->deleteQueryMetaData($data);
        $this->{'model_extension_d_seo_module_ajax_filter_' . $this->codename}->deleteQueryTargetKeyword($data);
        $this->{'model_extension_d_seo_module_ajax_filter_' . $this->codename}->deleteQueryURLKeyword($data);
    }
}
