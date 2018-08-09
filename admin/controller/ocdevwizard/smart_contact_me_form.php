<?php

// @category  : OpenCart
// @module    : Smart Contact Me
// @author    : OCdevWizard <ocdevwizard@gmail.com> 
// @copyright : Copyright (c) 2015, OCdevWizard
// @license   : http://license.ocdevwizard.com/Licensing_Policy.pdf

class ControllerOcdevwizardSmartContactMeForm extends Controller
{

    static $_module_version = '2.0.0';
    static $_module_name = 'smart_contact_me';
    private $error = array();

    public function index()
    {
        $this->getList();
    }

    protected function getList()
    {
        $data = array();

        // connect models array
        $models = array(
            'ocdevwizard/' . self::$_module_name
        );

        foreach ($models as $model) {
            $this->load->model($model);
        }

        $data = array_merge($data, $this->language->load('ocdevwizard/' . self::$_module_name . '_form'));
        $this->document->setTitle($this->language->get('heading_name'));

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'f.date_added';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array(
            0 => array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
            ),
            1 => array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('ocdevwizard/' . self::$_module_name . '_form', 'token=' . $this->session->data['token'] . $url, 'SSL')
            )
        );

        $data['add'] = $this->url->link('ocdevwizard/' . self::$_module_name . '_form' . '/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('ocdevwizard/' . self::$_module_name . '_form' . '/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $data['forms'] = array();

        $filter_data = array(
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $form_total = $this->{'model_ocdevwizard_' . self::$_module_name}->getTotalForms();

        $results = $this->{'model_ocdevwizard_' . self::$_module_name}->getForms($filter_data);

        foreach ($results as $result) {
            $data['forms'][] = array(
                'form_id' => $result['form_id'],
                'title' => $result['heading_module'],
                'date_added' => $result['date_added'],
                'date_modified' => $result['date_modified'],
                'edit' => $this->url->link('ocdevwizard/' . self::$_module_name . '_form' . '/edit', 'token=' . $this->session->data['token'] . '&form_id=' . $result['form_id'] . $url, 'SSL'),
                'delete' => $this->url->link('ocdevwizard/' . self::$_module_name . '_form' . '/delete', 'token=' . $this->session->data['token'] . '&selected_form_id=' . $result['form_id'] . $url, 'SSL')
            );
        }

        $data['error_warning'] = (isset($this->error['warning'])) ? $this->error['warning'] : '';

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['selected'] = (isset($this->request->post['selected'])) ? (array)$this->request->post['selected'] : array();

        $url = '';

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_title'] = $this->url->link('ocdevwizard/' . self::$_module_name . '_form', 'token=' . $this->session->data['token'] . '&sort=fd.heading_module' . $url, 'SSL');
        $data['sort_date_added'] = $this->url->link('ocdevwizard/' . self::$_module_name . '_form', 'token=' . $this->session->data['token'] . '&sort=f.date_added' . $url, 'SSL');
        $data['sort_date_modified'] = $this->url->link('ocdevwizard/' . self::$_module_name . '_form', 'token=' . $this->session->data['token'] . '&sort=f.date_modified' . $url, 'SSL');

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $form_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('ocdevwizard/' . self::$_module_name . '_form', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($form_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($form_total - $this->config->get('config_limit_admin'))) ? $form_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $form_total, ceil($form_total / $this->config->get('config_limit_admin')));

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('ocdevwizard/' . self::$_module_name . '_form_list.tpl', $data));
    }

    public function add()
    {
        $data = array();

        // connect models array
        $models = array(
            'ocdevwizard/' . self::$_module_name
        );

        foreach ($models as $model) {
            $this->load->model($model);
        }

        $data = array_merge($data, $this->language->load('ocdevwizard/' . self::$_module_name . '_form'));
        $this->document->setTitle($this->language->get('heading_title'));

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->{'model_ocdevwizard_' . self::$_module_name}->addForm($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('ocdevwizard/' . self::$_module_name . '_form', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    protected function validateForm()
    {
        // connect models array
        $models = array(
            'localisation/language'
        );

        foreach ($models as $model) {
            $this->load->model($model);
        }

        if (!$this->user->hasPermission('modify', 'ocdevwizard/' . self::$_module_name . '_form')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        foreach ($this->request->post['form_description'] as $language_id => $value) {
            if ((utf8_strlen($value['heading_module']) < 3) || (utf8_strlen($value['heading_module']) > 64)) {
                $this->error['heading_module'][$language_id] = $this->language->get('error_heading_module');
            }

            if ((utf8_strlen($value['call_button']) < 3) || (utf8_strlen($value['call_button']) > 64)) {
                $this->error['call_button'][$language_id] = $this->language->get('error_call_button');
            }

            if ((utf8_strlen($value['send_button']) < 3) || (utf8_strlen($value['send_button']) > 64)) {
                $this->error['send_button'][$language_id] = $this->language->get('error_send_button');
            }

            if ((utf8_strlen($value['close_button']) < 3) || (utf8_strlen($value['close_button']) > 64)) {
                $this->error['close_button'][$language_id] = $this->language->get('error_close_button');
            }

            if (html_entity_decode($value['success_message']) == "<p><br></p>") {
                $this->error['success_message'][$language_id] = $this->language->get('error_success_message');
            }
        }

        if (isset($this->request->post['field_data'])) {
            foreach ($this->request->post['field_data'] as $main_key => $field) {
                foreach ($field as $key => $value) {
                    if (empty($value) && $key == "view") {
                        $this->error['data_fields'][$main_key][$key] = $this->language->get('error_view');
                    }

                    foreach ($this->model_localisation_language->getLanguages() as $language) {
                        if (empty($value[$language['language_id']]) && $key == "title") {
                            $this->error['data_fields'][$main_key][$key][$language['language_id']] = $this->language->get('error_field_title');
                        }

                        if (empty($value[$language['language_id']]) && $key == "error_text") {
                            $this->error['data_fields'][$main_key][$key][$language['language_id']] = $this->language->get('error_error_text');
                        }
                    }
                }
            }
        }

        if (empty($this->request->post['add_id_selector']) && $this->request->post['display_type'] == 1) {
            $this->error['add_id_selector'] = $this->language->get('error_add_id_selector');
        }

        if (empty($this->request->post['location']) && $this->request->post['display_type'] == 1) {
            $this->error['location'] = $this->language->get('error_location');
        }

        if (empty($this->request->post['display_type'])) {
            $this->error['display_type'] = $this->language->get('error_display_type');
        }

        if (empty($this->request->post['admin_email_for_notifications'])) {
            $this->error['admin_email_for_notifications'] = $this->language->get('error_admin_email_for_notifications');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

    protected function getForm()
    {
        $data = array();

        // connect models array
        $models = array(
            'localisation/language',
            'customer/customer_group',
            'setting/store',
            'ocdevwizard/' . self::$_module_name
        );

        foreach ($models as $model) {
            $this->load->model($model);
        }

        $data = array_merge($data, $this->language->load('ocdevwizard/' . self::$_module_name . '_form'));
        $this->document->setTitle($this->language->get('heading_name'));

        $scripts = array('jquery-ui.min.js');
        foreach ($scripts as $script) {
            $this->document->addScript('view/javascript/ocdevwizard/' . self::$_module_name . '/' . $script);
        }

        $styles = array('stylesheet.css');
        foreach ($styles as $style) {
            $this->document->addStyle('view/stylesheet/ocdevwizard/' . self::$_module_name . '/' . $style);
        }

        $data['text_form'] = !isset($this->request->get['form_id']) ? $this->language->get('button_add') : $this->language->get('text_edit');
        $data['_module_version'] = self::$_module_version;
        $data['admin_language'] = $this->config->get('config_language_id');
        $data['token'] = $this->session->data['token'];
        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['error_warning'] = (isset($this->error['warning'])) ? $this->error['warning'] : '';
        $data['error_data_fields'] = (isset($this->error['data_fields'])) ? $this->error['data_fields'] : array();
        $data['error_heading_module'] = (isset($this->error['heading_module'])) ? $this->error['heading_module'] : '';
        $data['error_call_button'] = (isset($this->error['call_button'])) ? $this->error['call_button'] : '';
        $data['error_send_button'] = (isset($this->error['send_button'])) ? $this->error['send_button'] : '';
        $data['error_close_button'] = (isset($this->error['close_button'])) ? $this->error['close_button'] : '';
        $data['error_success_message'] = (isset($this->error['success_message'])) ? $this->error['success_message'] : '';
        $data['error_add_id_selector'] = (isset($this->error['add_id_selector'])) ? $this->error['add_id_selector'] : '';
        $data['error_location'] = (isset($this->error['location'])) ? $this->error['location'] : '';
        $data['error_display_type'] = (isset($this->error['display_type'])) ? $this->error['display_type'] : '';
        $data['error_admin_email_for_notifications'] = (isset($this->error['admin_email_for_notifications'])) ? $this->error['admin_email_for_notifications'] : '';

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array(
            0 => array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
            ),
            1 => array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('ocdevwizard/' . self::$_module_name . '_form', 'token=' . $this->session->data['token'] . $url, 'SSL')
            )
        );

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (!isset($this->request->get['form_id'])) {
            $data['action'] = $this->url->link('ocdevwizard/' . self::$_module_name . '_form' . '/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
            $data['action_plus_status'] = false;
        } else {
            $data['action'] = $this->url->link('ocdevwizard/' . self::$_module_name . '_form' . '/edit', 'token=' . $this->session->data['token'] . '&form_id=' . $this->request->get['form_id'] . $url, 'SSL');
            $data['action_plus'] = $this->url->link('ocdevwizard/' . self::$_module_name . '_form' . '/edit_and_stay', 'token=' . $this->session->data['token'] . '&form_id=' . $this->request->get['form_id'] . $url, 'SSL');
            $data['action_plus_status'] = true;
        }

        $data['cancel'] = $this->url->link('ocdevwizard/' . self::$_module_name . '_form', 'token=' . $this->session->data['token'] . $url, 'SSL');

        if (isset($this->request->get['form_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $feedback_info = $this->{'model_ocdevwizard_' . self::$_module_name}->getForm($this->request->get['form_id']);
        }

        if (isset($this->request->post['form_description'])) {
            $data['form_description'] = $this->request->post['form_description'];
        } elseif (isset($this->request->get['form_id'])) {
            $data['form_description'] = $this->{'model_ocdevwizard_' . self::$_module_name}->getDescription($this->request->get['form_id']);
        } else {
            $data['form_description'] = array();
        }

        if (isset($this->request->post['field_data'])) {
            $field_datas = $this->request->post['field_data'];
        } elseif (isset($this->request->get['form_id'])) {
            $field_datas = $this->{'model_ocdevwizard_' . self::$_module_name}->getFields($this->request->get['form_id']);
        } else {
            $field_datas = array();
        }

        $data['field_view_data'] = array(
            'text' => $this->language->get('text_field_simple_text'),
            'textarea' => $this->language->get('text_field_simple_textarea'),
            'radio' => $this->language->get('text_field_simple_radio'),
            'checkbox' => $this->language->get('text_field_simple_checkbox'),
            'select' => $this->language->get('text_field_simple_select')
        );

        $data['field_data'] = array();

        foreach ($field_datas as $field) {
            $data['field_data'][] = array(
                'sort_order' => $field['sort_order'],
                'name' => $field['name'],
                'activate' => $field['activate'],
                'title' => $field['title'],
                'view' => $field['view'],
                'view_fields' => $field['view_fields'],
                'check' => $field['check'],
                'check_rule' => $field['check_rule'],
                'check_min' => $field['check_min'],
                'check_max' => $field['check_max'],
                'mask' => $field['mask'],
                'error_text' => $field['error_text'],
                'css_id' => $field['css_id'],
                'css_class' => $field['css_class'],
                'position' => $field['position']
            );
        }

        $default_store = array(0 => array('store_id' => 0, 'name' => $this->config->get('config_name') . ' (Default)'));

        $data['stores'] = array_merge($this->model_setting_store->getStores(), $default_store);

        if (isset($this->request->post['feedback_store'])) {
            $data['feedback_store'] = $this->request->post['feedback_store'];
        } elseif (isset($this->request->get['form_id'])) {
            $data['feedback_store'] = $this->{'model_ocdevwizard_' . self::$_module_name}->getStores($this->request->get['form_id']);
        } else {
            $data['feedback_store'] = array(0);
        }

        if (isset($this->request->post['add_id_selector'])) {
            $data['add_id_selector'] = $this->request->post['add_id_selector'];
        } elseif (!empty($feedback_info)) {
            $data['add_id_selector'] = $feedback_info['add_id_selector'];
        } else {
            $data['add_id_selector'] = '';
        }

        if (isset($this->request->post['location'])) {
            $data['location'] = $this->request->post['location'];
        } elseif (!empty($feedback_info)) {
            $data['location'] = $feedback_info['location'];
        } else {
            $data['location'] = '1';
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($feedback_info)) {
            $data['status'] = $feedback_info['status'];
        } else {
            $data['status'] = true;
        }

        if (isset($this->request->post['allow_admin_notify'])) {
            $data['allow_admin_notify'] = $this->request->post['allow_admin_notify'];
        } elseif (!empty($feedback_info)) {
            $data['allow_admin_notify'] = $feedback_info['allow_admin_notify'];
        } else {
            $data['allow_admin_notify'] = true;
        }

        if (isset($this->request->post['admin_email_for_notifications'])) {
            $data['admin_email_for_notifications'] = $this->request->post['admin_email_for_notifications'];
        } elseif (!empty($feedback_info)) {
            $data['admin_email_for_notifications'] = $feedback_info['admin_email_for_notifications'];
        } else {
            $data['admin_email_for_notifications'] = $this->config->get('config_email');
        }

        if (isset($this->request->post['display_type'])) {
            $data['display_type'] = $this->request->post['display_type'];
        } elseif (!empty($feedback_info)) {
            $data['display_type'] = $feedback_info['display_type'];
        } else {
            $data['display_type'] = true;
        }

        $data['backgrounds'] = array();

        if ($this->get_background()) {
            foreach ($this->get_background() as $background) {
                $name_string = explode("/", $background);
                $name = array_pop($name_string);
                $data['backgrounds'][] = array(
                    'src' => $background,
                    'name' => $name
                );
            }
        }

        if (isset($this->request->post['background'])) {
            $data['background'] = $this->request->post['background'];
        } elseif (!empty($feedback_info)) {
            $data['background'] = $feedback_info['background'];
        } else {
            $data['background'] = 'bg_7.png';
        }

        if (isset($this->request->post['background_opacity'])) {
            $data['background_opacity'] = $this->request->post['background_opacity'];
        } elseif (!empty($feedback_info)) {
            $data['background_opacity'] = $feedback_info['background_opacity'];
        } else {
            $data['background_opacity'] = '8';
        }

        $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

        if (isset($this->request->post['feedback_customer_groups'])) {
            $data['feedback_customer_groups'] = $this->request->post['feedback_customer_groups'];
        } elseif (isset($this->request->get['form_id'])) {
            $data['feedback_customer_groups'] = $this->{'model_ocdevwizard_' . self::$_module_name}->getCustomerGroups($this->request->get['form_id']);
        } else {
            $data['feedback_customer_groups'] = array(0);
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('ocdevwizard/' . self::$_module_name . '_form_form.tpl', $data));
    }

    public function get_background()
    {
        $backgrounds = array();

        $dir = opendir(DIR_IMAGE . 'ocdevwizard/' . self::$_module_name . '/background');

        while (($file = readdir($dir)) !== FALSE) {
            if (in_array(substr(strrchr($file, '.'), 1), array('png', 'jpg'))) {
                $backgrounds[] = (HTTP_CATALOG . 'image/ocdevwizard/' . self::$_module_name . '/background/' . $file);
            }
        }

        closedir($dir);

        return $backgrounds;
    }

    public function edit()
    {
        $data = array();

        // connect models array
        $models = array(
            'ocdevwizard/' . self::$_module_name
        );

        foreach ($models as $model) {
            $this->load->model($model);
        }

        $data = array_merge($data, $this->language->load('ocdevwizard/' . self::$_module_name . '_form'));
        $this->document->setTitle($this->language->get('heading_title'));

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->{'model_ocdevwizard_' . self::$_module_name}->editForm($this->request->get['form_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('ocdevwizard/' . self::$_module_name . '_form', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function edit_and_stay()
    {
        $data = array();

        // connect models array
        $models = array(
            'ocdevwizard/' . self::$_module_name
        );

        foreach ($models as $model) {
            $this->load->model($model);
        }

        $data = array_merge($data, $this->language->load('ocdevwizard/' . self::$_module_name . '_form'));
        $this->document->setTitle($this->language->get('heading_title'));

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->{'model_ocdevwizard_' . self::$_module_name}->editForm($this->request->get['form_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('ocdevwizard/' . self::$_module_name . '_form/edit', 'token=' . $this->session->data['token'] . '&form_id=' . $this->request->get['form_id'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete()
    {
        $data = array();

        // connect models array
        $models = array(
            'ocdevwizard/' . self::$_module_name
        );

        foreach ($models as $model) {
            $this->load->model($model);
        }

        $data = array_merge($data, $this->language->load('ocdevwizard/' . self::$_module_name . '_form'));
        $this->document->setTitle($this->language->get('heading_title'));

        if (isset($this->request->get['selected_form_id'])) {
            $this->{'model_ocdevwizard_' . self::$_module_name}->deleteForm($this->request->get['selected_form_id']);
        }

        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $form_id) {
                $this->{'model_ocdevwizard_' . self::$_module_name}->deleteForm($form_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('ocdevwizard/' . self::$_module_name . '_form', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getList();
    }
}