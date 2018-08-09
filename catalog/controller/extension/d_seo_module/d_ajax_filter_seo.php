<?php

class ControllerExtensionDSeoModuleDAjaxFilterSeo extends Controller
{
    private $codename = 'd_ajax_filter_seo';
    private $route = 'extension/d_seo_module/d_ajax_filter_seo';
    private $config_file = 'd_ajax_filter_seo';

    private $common_setting = array();

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->model($this->route);
    }

    /*
    *	Functions for SEO Module.
    */
    public function seo_url()
    {
        $this->load->model($this->route);
        $this->load->model('extension/module/' . $this->codename);
        $this->load->model('setting/setting');

        $store_id = (int)$this->config->get('config_store_id');

        // Setting
        $_config = new Config();
        $_config->load($this->config_file);
        $config_setting = ($_config->get($this->codename . '_setting')) ? $_config->get($this->codename . '_setting') : array();

        $status = ($this->config->get($this->codename . '_status')) ? $this->config->get($this->codename . '_status') : false;
        $setting = ($this->config->get($this->codename . '_setting')) ? $this->config->get($this->codename . '_setting') : array();

        if (!empty($setting)) {
            $config_setting = array_replace_recursive($config_setting, $setting);
        }

        $setting = $config_setting;

        if ($status) {
            if (!isset($this->request->get['route']) && isset($this->request->get['_route_'])) {
                $parts = explode('/', $this->request->get['_route_']);

                // remove any empty arrays from trailing
                if (utf8_strlen(end($parts)) == 0) {
                    array_pop($parts);
                }

                foreach ($parts as $part) {
                    unset($route);
                    unset($language_id);

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
                                $language_id = $url_language_id;
                            }

                            foreach ($store_url_keywords[$store_id] as $url_language_id => $keyword) {
                                if ($url_language_id == (int)$this->config->get('config_language_id')) {
                                    $route = $url_route;
                                    $language_id = $url_language_id;
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
                                $this->request->get['path'] = $query_info['path'];
                                $this->request->get['ajaxfilter'] = $query_info['params'];
                                $this->request->get['route'] = 'product/category';
                            }
                        }
                        if ($route[0] == 'category_id' && !empty($this->request->get['ajaxfilter'])) {
                            $category_id = $route[1];
                            $this->request->get['path'] = $this->{'model_extension_d_seo_module_' . $this->codename}->getCategoryPath($category_id);
                            $this->request->get['ajaxfilter'] = $this->request->get['ajaxfilter'];
                            $this->request->get['route'] = 'product/category';
                        }
                    }
                }

                if (isset($language_id)) {
                    $this->load->model($this->route);
                    $this->load->model('localisation/language');

                    $language_info = $this->model_localisation_language->getLanguage($language_id);

                    if ($this->session->data['language'] != $language_info['code']) {
                        $this->session->data['language'] = $language_info['code'];
                        $this->response->redirect($this->{'model_extension_d_seo_module_' . $this->codename}->getCurrentURL(), '302');
                    }
                }
            }

            if (isset($this->request->get['route'])) {
                if ($this->request->get['route'] == 'product/category') {
                    if (isset($this->request->get['ajaxfilter'])) {
                        $ajaxFilterParams = $this->request->get['ajaxfilter'];
                    }

                    if (isset($this->request->get['path'])) {
                        $path = $this->request->get['path'];
                    }

                    if (!empty($ajaxFilterParams) && !empty($path)) {
                        if ($setting['sheet']['ajax_filter_seo']['unique_url']) {
                            $url_data = array();

                            $url_data['path'] = $path;
                            $url_data['ajaxfilter'] = $ajaxFilterParams;

                            $exception_data = explode(',', $setting['sheet']['ajax_filter_seo']['exception_data']);

                            foreach ($exception_data as $exception) {
                                $exception = trim($exception);

                                if (isset($this->request->get[$exception])) {
                                    $url_data[$exception] = $this->request->get[$exception];
                                }
                            }

                            if ($this->url->link($this->request->get['route'], http_build_query($url_data), true) != $this->{'model_extension_d_seo_module_' . $this->codename}->getCurrentURL()) {
                                $this->response->redirect($this->url->link($this->request->get['route'], http_build_query($url_data), true), '301');
                            }
                        }
                    }
                }
            }
        }
    }

    public function seo_url_rewrite($data)
    {
        $this->load->model($this->route);
        $this->load->model('extension/module/' . $this->codename);
        // Setting
        $status = ($this->config->get($this->codename . '_status')) ? $this->config->get($this->codename . '_status') : false;

        if ($status) {
            $store_id = (int)$this->config->get('config_store_id');
            $language_id = (int)$this->config->get('config_language_id');

            $url_info = parse_url(str_replace('&amp;', '&', $data['url']));

            $url = '';

            $url_data = array();

            if (isset($url_info['query'])) {
                parse_str($url_info['query'], $url_data);

                if (isset($url_data['route'])) {
                    if ($url_data['route'] == 'product/category') {
                        if (isset($url_data['ajaxfilter']) && isset($url_data['path'])) {
                            $query_info = $this->{'model_extension_module_' . $this->codename}->findQuery($url_data['path'], $url_data['ajaxfilter']);

                            if (!empty($query_info)) {
                                $route = 'af_query_id=' . $query_info['query_id'];

                                $field_data = array(
                                    'field_code' => 'url_keyword',
                                    'filter' => array(
                                        'route' => $route,
                                        'store_id' => $store_id,
                                        'language_id' => $language_id
                                    )
                                );

                                $url_keywords = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);

                                if ($url_keywords) {
                                    $url_keyword = $url_keywords[$route][$store_id][$language_id];

                                    if ($url_keyword) {
                                        $url .= '/' . $url_keyword;

                                        unset($url_data['ajaxfilter']);
                                        unset($url_data['path']);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if ($url) {
                unset($url_data['route']);

                $query = '';

                if ($url_data) {
                    foreach ($url_data as $key => $value) {
                        $query .= '&' . rawurlencode((string)$key) . '=' . rawurlencode((is_array($value) ? http_build_query($value) : (string)$value));
                    }

                    if ($query) {
                        $query = '?' . str_replace('&', '&amp;', trim($query, '&'));
                    }
                }

                $data['url'] = $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
                $data['status'] = true;
            }
        }

        return $data;
    }

    public function language_language()
    {
        $this->load->model($this->route);

        $status = ($this->config->get($this->codename . '_status')) ? $this->config->get($this->codename . '_status') : false;

        if ($status && isset($this->request->post['redirect'])) {
            $this->request->post['redirect'] = $this->{'model_extension_d_seo_module_' . $this->codename}->getURLForLanguage($this->request->post['redirect'], $this->session->data['language']);
        }
    }

    public function category_before($data)
    {
        $store_id = (int)$this->config->get('config_store_id');
        $language_id = (int)$this->config->get('config_language_id');

        // Setting
        $status = ($this->config->get($this->codename . '_status')) ? $this->config->get($this->codename . '_status') : false;
        $setting = ($this->config->get($this->codename . '_setting')) ? $this->config->get($this->codename . '_setting') : array();

        if ($status && $data) {
            $query_info = $this->{'model_extension_module_' . $this->codename}->getCurrentQuery();
            if (!empty($query_info)) {
                $route = 'af_query_id=' . (int)$query_info['query_id'];

                $field_data = array(
                    'field_code' => 'meta_data',
                    'filter' => array(
                        'route' => $route,
                        'store_id' => $store_id,
                        'language_id' => $language_id
                    )
                );

                $meta_data = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);

                if ($meta_data) {
                    $meta_info = $meta_data[$route][$store_id][$language_id];

                    if ($meta_info['title']) {
                        $data['heading_title'] = html_entity_decode($meta_info['title'], ENT_QUOTES, 'UTF-8');
                    }

                    if ($meta_info['description']) {
                        $data['description'] = html_entity_decode($meta_info['description'], ENT_QUOTES, 'UTF-8');
                    }

                    if ($meta_info['meta_title']) {
                        $this->document->setTitle($meta_info['meta_title']);
                    }

                    if ($meta_info['meta_description']) {
                        $this->document->setDescription($meta_info['meta_description']);
                    }

                    if ($meta_info['meta_keyword']) {
                        $this->document->setKeywords($meta_info['meta_keyword']);
                    }

                    $data['header'] = $this->load->controller('common/header');
                }
            } else {
                if (!empty($setting['generate_status'])) {
                    $this->{'model_extension_module_' . $this->codename}->addQuery();
                }
            }

            $this->{'model_extension_module_' . $this->codename}->updatePopularity();
        }

        return $data;
    }

    public function category_after($html)
    {
        $store_id = (int)$this->config->get('config_store_id');
        $language_id = (int)$this->config->get('config_language_id');

        // Setting
        $status = ($this->config->get($this->codename . '_status')) ? $this->config->get($this->codename . '_status') : false;
        $setting = ($this->config->get($this->codename . '_setting')) ? $this->config->get($this->codename . '_setting') : array();

        if ($status && file_exists(DIR_SYSTEM . 'library/d_simple_html_dom.php')) {
            $query_info = $this->{'model_extension_module_' . $this->codename}->getCurrentQuery();
            if (!empty($query_info)) {
                if (isset($this->request->get['path'])) {
                    $parts = explode('_', (string)$this->request->get['path']);
                    $category_id = (int)array_pop($parts);
                } else {
                    $category_id = 0;
                }

                $route = 'category_id=' . (int)$category_id;

                $field_data = array(
                    'field_code' => 'meta_data',
                    'filter' => array(
                        'route' => $route,
                        'store_id' => $store_id,
                        'language_id' => $language_id
                    )
                );

                $meta_data_category = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);

                $route = 'af_query_id=' . (int)$query_info['query_id'];

                $field_data = array(
                    'field_code' => 'meta_data',
                    'filter' => array(
                        'route' => $route,
                        'store_id' => $store_id,
                        'language_id' => $language_id
                    )
                );

                $meta_data = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);

                if ($meta_data && !$meta_data_category) {
                    $meta_info = $meta_data[$route][$store_id][$language_id];

                    $html_dom = new d_simple_html_dom();
                    $html_dom->load((string)$html, $lowercase = true, $stripRN = false, $defaultBRText = DEFAULT_BR_TEXT);

                    if ($meta_info['meta_robots']) {
                        foreach ($html_dom->find('head') as $element) {
                            $element->innertext .= '<meta name="robots" content="' . $meta_info['meta_robots'] . '" />' . "\n";
                        }
                    }

                    return (string)$html_dom;
                }
            }
        }

        return $html;
    }

    public function field_config($data)
    {
        $_language = new Language();
        $_language->load($this->route);

        $_config = new Config();
        $_config->load($this->config_file);
        $config_field_setting = ($_config->get($this->codename . '_field_setting')) ? $_config->get($this->codename . '_field_setting') : array();

        foreach ($config_field_setting['sheet'] as &$sheet) {
            foreach ($sheet['field'] as &$field) {
                if (substr($field['name'], 0, strlen('text_')) == 'text_') {
                    $field['name'] = $_language->get($field['name']);
                }

                if (substr($field['description'], 0, strlen('help_')) == 'help_') {
                    $field['description'] = $_language->get($field['description']);
                }
            }
        }

        if (!empty($config_field_setting['sheet'])) {
            $data['sheet'] = array_replace_recursive($data['sheet'], $config_field_setting['sheet']);
        }

        return $data;
    }

    public function field_elements($filter_data)
    {
        $this->load->model($this->route);

        return $this->{'model_extension_d_seo_module_' . $this->codename}->getFieldElements($filter_data);
    }
}
