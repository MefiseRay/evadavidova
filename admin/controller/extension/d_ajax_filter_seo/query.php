<?php
/*
*   location: admin/controller
*/

class ControllerExtensionDAjaxFilterSeoQuery extends Controller
{
    private $codename = 'd_ajax_filter_seo';
    private $route = 'extension/d_ajax_filter_seo/query';

    private $extension = array();
    private $error = array();

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->model($this->route);
        $this->load->model('extension/module/' . $this->codename);
        $this->load->language($this->route);

        //extension.json
        $this->extension = json_decode(file_get_contents(DIR_SYSTEM . 'library/d_shopunity/extension/d_ajax_filter.json'), true);
        $this->d_shopunity = (file_exists(DIR_SYSTEM . 'library/d_shopunity/extension/d_shopunity.json'));
    }

    public function index()
    {
        $this->getList();
    }

    public function getList()
    {
        $this->load->model('extension/d_opencart_patch/url');
        $this->load->model('extension/d_opencart_patch/load');
        $this->load->model('extension/d_opencart_patch/user');

        if (isset($this->request->get['filter_path'])) {
            $filter_path = $this->request->get['filter_path'];
        } else {
            $filter_path = null;
        }

        if (isset($this->request->get['filter_params'])) {
            $filter_params = $this->request->get['filter_params'];
        } else {
            $filter_params = null;
        }

        if (isset($this->request->get['filter_popularity'])) {
            $filter_popularity = $this->request->get['filter_popularity'];
        } else {
            $filter_popularity = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'af1.popularity';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        // Add more styles, links or scripts to the project is necessary
        $url_params = array();
        $url = '';

        if (isset($this->request->get['filter_path'])) {
            $url .= '&filter_path=' . urlencode(html_entity_decode($this->request->get['filter_path'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_params'])) {
            $url .= '&filter_params=' . urlencode(html_entity_decode($this->request->get['filter_params'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_popularity'])) {
            $url .= '&filter_popularity=' . urlencode(html_entity_decode($this->request->get['filter_popularity'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['sort'])) {
            $url_params['sort'] = $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url_params['order'] = $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url_params['page'] = $this->request->get['page'];
        }

        $url = ((!empty($url_params)) ? '&' : '') . http_build_query($url_params);

        // Breadcrumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->model_extension_d_opencart_patch_url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->model_extension_d_opencart_patch_url->link('marketplace/extension')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title_main'),
            'href' => $this->model_extension_d_opencart_patch_url->link($this->route)
        );

        // Notification
        foreach ($this->error as $key => $error) {
            $data['error'][$key] = $error;
        }

        $data['add'] = $this->model_extension_d_opencart_patch_url->link($this->route . '/add', $url);
        $data['delete'] = $this->model_extension_d_opencart_patch_url->link($this->route . '/delete', $url);

        $data['cancel'] = $this->model_extension_d_opencart_patch_url->link('marketplace/extension', 'type=module');

        $data['codename'] = $this->codename;
        $data['route'] = $this->route;
        $data['extension'] = $this->extension;
        $data['version'] = $this->extension['version'];
        $data['token'] = $this->model_extension_d_opencart_patch_user->getToken();
        $data['token_url'] = $this->model_extension_d_opencart_patch_user->getUrlToken();

        $this->document->setTitle($this->language->get('heading_title_main'));
        $data['heading_title'] = $this->language->get('heading_title_main');
        $data['text_edit'] = $this->language->get('text_edit');

        $data['button_add'] = $this->language->get('button_add');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_filter'] = $this->language->get('button_filter');

        $data['text_confirm'] = $this->language->get('text_confirm');
        $data['text_no_results'] = $this->language->get('text_no_results');

        $data['text_queries'] = $this->language->get('text_queries');
        $data['text_settings'] = $this->language->get('text_settings');

        $data['href_queries'] = $this->model_extension_d_opencart_patch_url->link($this->route);
        $data['href_settings'] = $this->model_extension_d_opencart_patch_url->link('extension/' . $this->codename . '/setting');

        $data['column_category'] = $this->language->get('column_category');
        $data['column_params'] = $this->language->get('column_params');
        $data['column_popularity'] = $this->language->get('column_popularity');
        $data['column_action'] = $this->language->get('column_action');

        $filter_data = array(
            'filter_path' => $filter_path,
            'filter_params' => $filter_params,
            'filter_popularity' => $filter_popularity,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $queries_data = $this->{'model_extension_' . $this->codename . '_query'}->getQueries($filter_data);
        $queries_total = $this->{'model_extension_' . $this->codename . '_query'}->getQueriesTotal($filter_data);

        $data['queries'] = array();

        $this->load->model('catalog/category');

        foreach ($queries_data as $query) {
            $explode = explode('_', $query['path']);

            $category_id = end($explode);

            $category_info = $this->model_catalog_category->getCategory($category_id);

            if (!empty($category_info)) {
                if (!empty($category_info['path'])) {
                    $category_path = $category_info['path'] . ' &nbsp;&nbsp;&gt;&nbsp;&nbsp; ' . $category_info['name'];
                } else {
                    $category_path = $category_info['name'];
                }
            } else {
                $category_path = '';
            }

            $data['queries'][] = array(
                'query_id' => $query['query_id'],
                'category_path' => $category_path,
                'params' => $query['params'],
                'popularity' => $query['popularity'],
                'edit' => $this->model_extension_d_opencart_patch_url->link($this->route . '/edit', 'query_id=' . $query['query_id'])
            );
        }

        $sort = (isset($this->request->get['sort'])) ? $this->request->get['sort'] : 'afq.popularity';
        $order = (isset($this->request->get['order'])) ? $this->request->get['order'] : 'DESC';
        $page = (isset($this->request->get['page'])) ? $this->request->get['page'] : 1;

        $url = '';

        if ($order == 'ASC') {
            $url .= '&order=' . 'DESC';
        } else {
            $url .= '&order=' . 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        $data['sort_path'] = $this->model_extension_d_opencart_patch_url->link($this->route, 'sort=afq.path' . $url);
        $data['sort_params'] = $this->model_extension_d_opencart_patch_url->link($this->route, 'sort=afq.params' . $url);
        $data['sort_popularity'] = $this->model_extension_d_opencart_patch_url->link($this->route, 'sort=afq.popularity' . $url);

        $url = '';

        if ($order == 'DESC') {
            $url .= '&order=' . 'DESC';
        } else {
            $url .= '&order=' . 'ASC';
        }
        $url .= '&sort=' . $sort;

        $pagination = new Pagination();
        $pagination->total = $queries_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->model_extension_d_opencart_patch_url->link($this->route, $url . '&page={page}', 'SSL');
        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($queries_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($queries_total - $this->config->get('config_limit_admin'))) ? $queries_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $queries_total, ceil($queries_total / $this->config->get('config_limit_admin')));

        $data['filter_path'] = $filter_path;
        $data['filter_params'] = $filter_params;
        $data['filter_popularity'] = $filter_popularity;

        if (!empty($data['filter_path'])) {
            $explode = explode('_', $data['filter_path']);

            $category_id = end($explode);

            $category_info = $this->model_catalog_category->getCategory($category_id);

            if (!empty($category_info)) {
                if (!empty($category_info['path'])) {
                    $data['filter_path_name'] = $category_info['path'] . ' &nbsp;&nbsp;&gt;&nbsp;&nbsp; ' . $category_info['name'];
                } else {
                    $data['filter_path_name'] = $category_info['name'];
                }
            } else {
                $data['filter_path_name'] = '';
            }
        } else {
            $data['filter_path_name'] = '';
        }

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->model_extension_d_opencart_patch_load->view('extension/' . $this->codename . '/query_list', $data));
    }

    public function add()
    {
        $this->document->setTitle($this->language->get('heading_title_main'));

        $this->load->model('extension/d_opencart_patch/url');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->{'model_extension_' . $this->codename . '_query'}->addQuery($this->request->post);

            $this->cache->delete('url_rewrite');

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->model_extension_d_opencart_patch_url->link($this->route));
        }

        $this->getForm();
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/' . $this->codename)) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (empty($this->request->post['path'])) {
            $this->error['category'] = $this->language->get('error_category');
        }

        if (empty($this->request->post['params'])) {
            $this->error['params'] = $this->language->get('error_params');
        }

        $seo_extensions = $this->{'model_extension_module_' . $this->codename}->getSEOFilterExtensions();

        foreach ($seo_extensions as $seo_extension) {
            $info = $this->load->controller('extension/d_seo_module_ajax_filter/' . $seo_extension . '/query_validate_form', $this->error);
            if ($info != '') {
                $this->error = $info;
            }
        }

        return !$this->error;
    }

    public function getForm()
    {
        $this->load->model('extension/d_opencart_patch/url');
        $this->load->model('extension/d_opencart_patch/load');
        $this->load->model('extension/d_opencart_patch/user');

        $this->document->addStyle('view/stylesheet/shopunity/bootstrap.css');

        $url_params = array();
        $url = '';

        if (isset($this->request->get['sort'])) {
            $url_params['sort'] = $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url_params['order'] = $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url_params['page'] = $this->request->get['page'];
        }

        $url = ((!empty($url_params)) ? '&' : '') . http_build_query($url_params);

        // Breadcrumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->model_extension_d_opencart_patch_url->link('common/home', 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->model_extension_d_opencart_patch_url->link('marketplace/extension', 'type=module')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title_main'),
            'href' => $this->model_extension_d_opencart_patch_url->link($this->route, $url)
        );

        // Notification
        foreach ($this->error as $key => $error) {
            $data['error'][$key] = $error;
        }

        if (isset($this->error['category'])) {
            $data['error_category'] = $this->error['category'];
        } else {
            $data['error_category'] = '';
        }

        if (isset($this->error['params'])) {
            $data['error_params'] = $this->error['params'];
        } else {
            $data['error_params'] = '';
        }

        $this->document->setTitle($this->language->get('heading_title_main'));
        $data['heading_title'] = $this->language->get('heading_title_main');
        $data['text_form'] = $this->language->get('text_form');
        $data['text_default'] = $this->language->get('text_default');

        $data['add'] = $this->model_extension_d_opencart_patch_url->link($this->route . '/add', $url);
        $data['delete'] = $this->model_extension_d_opencart_patch_url->link($this->route . '/delete', $url);
        $data['cancel'] = $this->model_extension_d_opencart_patch_url->link($this->route);

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['codename'] = $this->codename;
        $data['route'] = $this->route;

        $data['version'] = $this->extension['version'];
        $data['token'] = $this->model_extension_d_opencart_patch_user->getToken();
        $data['token_url'] = $this->model_extension_d_opencart_patch_user->getUrlToken();

        $data['entry_url'] = $this->language->get('entry_url');
        $data['entry_h1'] = $this->language->get('entry_h1');
        $data['entry_description'] = $this->language->get('entry_description');
        $data['entry_meta_title'] = $this->language->get('entry_meta_title');
        $data['entry_meta_description'] = $this->language->get('entry_meta_description');
        $data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
        $data['entry_category'] = $this->language->get('entry_category');
        $data['entry_params'] = $this->language->get('entry_params');

        $data['text_important'] = $this->language->get('text_important');
        $data['text_warning'] = $this->language->get('text_warning');
        $data['text_none'] = $this->language->get('text_none');

        if (isset($this->request->get['query_id'])) {
            $data['query_id'] = $query_id = $this->request->get['query_id'];
        }

        if (!isset($query_id)) {
            $data['action'] = $this->model_extension_d_opencart_patch_url->link($this->route . '/add', $url);
        } else {
            $data['action'] = $this->model_extension_d_opencart_patch_url->link($this->route . '/edit', 'query_id=' . $query_id . $url);
        }

        if (isset($this->request->get['query_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $query_info = $this->{'model_extension_' . $this->codename . '_query'}->getQuery($query_id);
        }

        if (isset($this->request->post['params'])) {
            $data['params'] = $this->request->post['params'];
        } elseif (!empty($query_info)) {
            $data['params'] = $query_info['params'];
        } else {
            $data['params'] = '';
        }

        if (isset($this->request->post['path'])) {
            $data['path'] = $this->request->post['path'];
        } elseif (!empty($query_info)) {
            $data['path'] = $query_info['path'];
        } else {
            $data['path'] = '';
        }

        if (!empty($data['path'])) {
            $this->load->model('catalog/category');
            $path = explode('_', $data['path']);
            $category_id = end($path);
            $category_info = $this->model_catalog_category->getCategory($category_id);
            $data['category_name'] = $category_info['name'];
        } else {
            $data['category_name'] = '';
        }


        if (isset($this->request->post['query_description'])) {
            $data['query_description'] = $this->request->post['query_description'];
        } elseif (isset($this->request->get['query_id'])) {
            $data['query_description'] = $this->{'model_extension_' . $this->codename . '_query'}->getQueryDescription($query_id);
        } else {
            $data['query_description'] = array();
        }

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();
        foreach ($data['languages'] as $key => $language) {
            if (VERSION >= '2.2.0.0') {
                $data['languages'][$key]['flag'] = 'language/' . $language['code'] . '/' . $language['code'] . '.png';
            } else {
                $data['languages'][$key]['flag'] = 'view/image/flags/' . $language['image'];
            }
        }

        $this->load->model('catalog/category');

        $data['categories'] = $this->model_catalog_category->getCategories();

        array_walk($data['categories'], function (&$value, &$index) {
            $path = $this->{'model_extension_' . $this->codename . '_query'}->getCategoryPath($value['category_id']);
            $value['path'] = $path;
        });

        $this->prepareSEO($data);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->model_extension_d_opencart_patch_load->view('extension/' . $this->codename . '/query_form', $data));
    }

    protected function prepareSEO(&$data)
    {
        $html_tab_general = '';
        $html_tab_general_language = array();
        $html_tab_general_store = array();
        $html_tab_general_store_language = array();
        $html_style = '';
        $html_script = '';

        $seo_extensions = $this->{'model_extension_module_' . $this->codename}->getSEOFilterExtensions();
        $languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();
        $stores = $this->{'model_extension_module_' . $this->codename}->getStores();
        unset($stores[0]);;
        foreach ($seo_extensions as $seo_extension) {
            $info = $this->load->controller('extension/d_seo_module_ajax_filter/' . $seo_extension . '/query_form_tab_general_language');

            foreach ($languages as $language) {
                if (!isset($html_tab_general_language[$language['language_id']])) {
                    $html_tab_general_language[$language['language_id']] = '';
                }

                if (isset($info[$language['language_id']])) {
                    $html_tab_general_language[$language['language_id']] .= $info[$language['language_id']];
                }
            }

            $info = $this->load->controller('extension/d_seo_module_ajax_filter/' . $seo_extension . '/query_form_tab_general_store');

            foreach ($stores as $store) {
                if (!isset($html_tab_general_store[$store['store_id']])) {
                    $html_tab_general_store[$store['store_id']] = '';
                }

                if (isset($info[$store['store_id']])) {
                    $html_tab_general_store[$store['store_id']] .= $info[$store['store_id']];
                }
            }

            $info = $this->load->controller('extension/d_seo_module_ajax_filter/' . $seo_extension . '/query_form_tab_general_store_language');

            foreach ($stores as $store) {
                foreach ($languages as $language) {
                    if (!isset($html_tab_general_store_language[$store['store_id']][$language['language_id']])) {
                        $html_tab_general_store_language[$store['store_id']][$language['language_id']] = '';
                    }

                    if (isset($info[$store['store_id']][$language['language_id']])) {
                        $html_tab_general_store_language[$store['store_id']][$language['language_id']] .= $info[$store['store_id']][$language['language_id']];
                    }
                }
            }

            $html_style .= $this->load->controller('extension/d_seo_module_ajax_filter/' . $seo_extension . '/query_form_style');
            $html_script .= $this->load->controller('extension/d_seo_module_ajax_filter/' . $seo_extension . '/query_form_script');
        }


        $data['html_tab_general_language'] = $html_tab_general_language;
        $data['html_style'] = $html_style;
        $data['html_script'] = $html_script;

        $html_tab_general_language = reset($html_tab_general_store_language);

        if ((count($stores)) && (reset($html_tab_general_store) || reset($html_tab_general_language))) {
            $html_stores = '<ul class="nav nav-tabs" id="store">';

            foreach ($stores as $store) {
                $html_stores .= '<li' . (($store == reset($stores)) ? ' class="active"' : '') . '><a href="#store_' . $store['store_id'] . '" data-toggle="tab">' . $store['name'] . '</a></li>';
            }

            $html_stores .= '</ul>';
            $html_stores .= '<div class="tab-store tab-content">';

            foreach ($stores as $store) {
                $html_store_languages = '';

                if (reset($html_tab_general_store_language[$store['store_id']])) {
                    $html_store_languages = '<ul class="nav nav-tabs" id="store_' . $store['store_id'] . '_language">';

                    foreach ($languages as $language) {
                        $html_store_languages .= '<li' . (($language == reset($languages)) ? ' class="active"' : '') . '><a href="#store_' . $store['store_id'] . '_language_' . $language['language_id'] . '" data-toggle="tab"><img src="' . $language['flag'] . '" title="' . $language['name'] . '" /> ' . $language['name'] . '</a></li>';
                    }

                    $html_store_languages .= '</ul>';
                    $html_store_languages .= '<div class="tab-language tab-content">';

                    foreach ($languages as $language) {
                        $html_store_languages .= '<div class="tab-pane' . (($language == reset($languages)) ? ' active' : '') . '" id="store_' . $store['store_id'] . '_language_' . $language['language_id'] . '">' . $html_tab_general_store_language[$store['store_id']][$language['language_id']] . '</div>';
                    }

                    $html_store_languages .= '</div>';
                }

                $html_stores .= '<div class="tab-pane' . (($store == reset($stores)) ? ' active' : '') . '" id="store_' . $store['store_id'] . '">' . $html_tab_general_store[$store['store_id']] . $html_store_languages . '</div>';
            }

            $html_stores .= '</div>';
            $data['html_stores'] = $html_stores;
        }
    }

    public function edit()
    {
        $this->document->setTitle($this->language->get('heading_title_main'));
        $this->load->model('extension/d_opencart_patch/url');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->{'model_extension_' . $this->codename . '_query'}->editQuery($this->request->get['query_id'], $this->request->post);

            $this->cache->delete('url_rewrite');

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->model_extension_d_opencart_patch_url->link($this->route));
        }

        $this->getForm();
    }

    public function delete()
    {
        $this->document->setTitle($this->language->get('heading_title_main'));

        $this->load->model('extension/d_opencart_patch/url');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $query_id) {
                $this->{'model_extension_' . $this->codename . '_query'}->deleteQuery($query_id);
            }

            $this->cache->delete('url_rewrite');

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->model_extension_d_opencart_patch_url->link($this->route));
        }

        $this->getForm();
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/' . $this->codename)) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function autocompleteParams()
    {
        $json = array();

        if (isset($this->request->get['filter_params']) || isset($this->request->get['filter_params'])) {
            if (isset($this->request->get['filter_params'])) {
                $filter_params = $this->request->get['filter_params'];
            } else {
                $filter_params = '';
            }

            $filter_data = array(
                'filter_params' => $filter_params,
                'start' => 0,
                'limit' => 5
            );

            $results = $this->{'model_extension_' . $this->codename . '_query'}->getParams($filter_data);

            foreach ($results as $result) {
                $json[] = array('params' => html_entity_decode($result['params'], ENT_QUOTES, 'UTF-8'));
            }
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['params'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function autocompleteCategory()
    {
        $json = array();

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('catalog/category');

            $filter_data = array(
                'filter_name' => $this->request->get['filter_name'],
                'sort' => 'name',
                'order' => 'ASC',
                'start' => 0,
                'limit' => 5
            );

            $results = $this->model_catalog_category->getCategories($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'path' => $this->{'model_extension_' . $this->codename . '_query'}->getCategoryPath($result['category_id']),
                    'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
                );
            }
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    private function validate($permission = 'modify')
    {
        if (isset($this->request->post['config'])) {
            return false;
        }

        $this->language->load($this->route);

        if (!$this->user->hasPermission($permission, $this->route)) {
            $this->error['warning'] = $this->language->get('error_permission');
            return false;
        }

        return true;
    }
}
