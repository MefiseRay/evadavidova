<?php

// @category  : OpenCart
// @module    : Smart Contact Me
// @author    : OCdevWizard <ocdevwizard@gmail.com> 
// @copyright : Copyright (c) 2015, OCdevWizard
// @license   : http://license.ocdevwizard.com/Licensing_Policy.pdf

class ControllerExtensionModuleOCdevSmcmStatic extends Controller
{

    static $_module_version = '2.0.0';
    static $_module_name = 'ocdev_smcm_static';

    public function index($setting)
    {
        $data = array();

        // connect models array
        $models = array(
            'ocdevwizard/smart_contact_me',
            'ocdevwizard/ocdevwizard_setting'
        );

        foreach ($models as $model) {
            $this->load->model($model);
        }

        $form_id = (int)$setting['form_id'];

        $data = array_merge($data, $this->language->load('ocdevwizard/smart_contact_me'));

        $form_data = $this->model_ocdevwizard_smart_contact_me->getForm($form_id);
        $form_data_setting = (array)$this->model_ocdevwizard_ocdevwizard_setting->getSettingData('smart_contact_me_form_data');

        $language_id = $this->model_ocdevwizard_smart_contact_me->getLanguageByCode($this->session->data['language']);

        if (isset($setting['heading'][$language_id])) {
            $data['heading_title'] = $setting['heading'][$language_id];
        }

        $data['button_send_order'] = $form_data['send_button'];

        $data['form_id'] = $form_id;

        $data['fields_data'] = array();

        if ($form_data && $form_data['display_type'] == 2) {
            foreach ($this->getActiveField($form_id) as $field) {
                switch ($field['position']) {
                    case '1':
                        $position = "left";
                        break;
                    case '2':
                        $position = "right";
                        break;
                    case '3':
                        $position = "center";
                        break;
                }

                $view_fields = array();

                if (!empty($field['view_fields'])) {
                    $view_fields = explode(";", $field['view_fields'][$language_id]);
                }

                $data['fields_data'][] = array(
                    'activate' => $field['activate'],
                    'title' => $field['title'][$language_id],
                    'name' => $field['name'],
                    'type' => $field['view'],
                    'view_fields' => $view_fields,
                    'check' => $field['check'],
                    'mask' => $field['mask'],
                    'error_text' => $field['error_text'],
                    'css_id' => $field['css_id'],
                    'css_class' => $field['css_class'],
                    'position' => $position
                );
            }
        }

        if (isset($form_data_setting['activate']) && $form_data_setting['activate']) {
            return $this->load->view('extension/module/' . self::$_module_name . '.tpl', $data);
        }
    }

    public function save()
    {
        $data = array();

        // connect models array
        $json = array();

        $models = array(
            'ocdevwizard/smart_contact_me',
            'ocdevwizard/ocdevwizard_setting'
        );

        foreach ($models as $model) {
            $this->load->model($model);
        }

        // get @form_id
        if (isset($this->request->request['form_id'])) {
            $form_id = (int)$this->request->request['form_id'];
        } else {
            die();
        }

        $data = array_merge($data, $this->language->load('ocdevwizard/smart_contact_me'));

        $form_data = $this->model_ocdevwizard_smart_contact_me->getForm($form_id);

        $language_id = $this->model_ocdevwizard_smart_contact_me->getLanguageByCode($this->session->data['language']);

        $success_message = html_entity_decode($form_data['success_message'], ENT_QUOTES, 'UTF-8');

        // validate fields
        foreach ($this->getActiveField($form_id) as $field) {
            if ($field['check'] == 1 && empty($this->request->request[$field['name']])) {
                $json['error']['field'][$field['name']] = $field['error_text'][$language_id];
            } elseif ($field['check'] == 2 && (!empty($field['check_rule']) && !preg_match($field['check_rule'], $this->request->request[$field['name']]))) {
                $json['error']['field'][$field['name']] = $field['error_text'][$language_id];
            } elseif ($field['check'] == 3 && (utf8_strlen(str_replace(array('_', '-', '(', ')', '+'), "", $this->request->request[$field['name']])) < $field['check_min'] || utf8_strlen(str_replace(array('_', '-', '(', ')', '+'), "", $this->request->request[$field['name']])) > $field['check_max'])) {
                $json['error']['field'][$field['name']] = $field['error_text'][$language_id];
            } else {
                unset($json['error']['field'][$field['name']]);
            }
        }

        // send data
        $filter_data = array();

        if (!isset($json['error'])) {
            $post_fields = array();

            foreach ($this->getActiveField($form_id) as $key => $field) {
                if (isset($this->request->request[$field['name']])) {
                    $post_fields[] = array(
                        'title' => $field['title'][$language_id],
                        'value' => $this->request->request[$field['name']]
                    );
                }
            }

            if (!empty($this->request->server['REMOTE_ADDR'])) {
                $ip = $this->request->server['REMOTE_ADDR'];
            } else {
                $ip = '';
            }

            if (!empty($this->request->server['HTTP_REFERER'])) {
                $referer = $this->request->server['HTTP_REFERER'];
            } else {
                $referer = '';
            }

            if (isset($this->request->server['HTTP_USER_AGENT'])) {
                $user_agent = $this->request->server['HTTP_USER_AGENT'];
            } else {
                $user_agent = '';
            }

            if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
                $accept_language = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
            } else {
                $accept_language = '';
            }

            $filter_data = array(
                'form_id' => $form_id,
                'ip' => $ip,
                'referer' => $referer,
                'user_agent' => $user_agent,
                'accept_language' => $accept_language,
                'field_data' => $post_fields
            );

            $this->model_ocdevwizard_smart_contact_me->addMessage($filter_data);

            $json['output'] = strip_tags($success_message);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function getActiveField($form_id)
    {
        $models = array(
            'ocdevwizard/smart_contact_me'
        );

        foreach ($models as $model) {
            $this->load->model($model);
        }

        $form_data = $this->model_ocdevwizard_smart_contact_me->getForm($form_id);

        $fields = unserialize($form_data['field_data']);

        foreach ($fields as $key => $field) {
            if ($field['activate'] == 0) {
                unset($fields[$key]);
            }
        }

        return $fields;
    }
}

?>