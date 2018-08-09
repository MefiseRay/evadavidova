<?php

// @category  : OpenCart
// @module    : Smart Contact Me
// @author    : OCdevWizard <ocdevwizard@gmail.com> 
// @copyright : Copyright (c) 2015, OCdevWizard
// @license   : http://license.ocdevwizard.com/Licensing_Policy.pdf

class ControllerOcdevwizardSmartContactMe extends Controller
{

    static $_module_version = '2.0.0';
    static $_module_name = 'smart_contact_me';

    public function index()
    {
        $data = array();

        // connect models array
        $models = array(
            'ocdevwizard/' . self::$_module_name,
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

        $data = array_merge($data, $this->language->load('ocdevwizard/' . self::$_module_name));

        $form_data = (array)$this->model_ocdevwizard_ocdevwizard_setting->getSettingData(self::$_module_name . '_form_data');

        $form_info = $this->{'model_ocdevwizard_' . self::$_module_name}->getForm($form_id);

        $language_id = $this->{'model_ocdevwizard_' . self::$_module_name}->getLanguageByCode($this->session->data['language']);

        $data['heading_title'] = $form_info['heading_module'];
        $data['button_send_order'] = $form_info['send_button'];
        $data['button_close'] = $form_info['close_button'];
        $data['style_background'] = $form_info['background'];
        $data['background_opacity'] = $form_info['background_opacity'];
        $data['form_id'] = $form_id;

        $data['fields_data'] = array();

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

        $this->response->setOutput($this->load->view('ocdevwizard/' . self::$_module_name . '/' . self::$_module_name . '.tpl', $data));
    }

    public function save()
    {
        $data = array();
        $json = array();

        // connect models array
        $models = array(
            'ocdevwizard/' . self::$_module_name
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

        $data = array_merge($data, $this->language->load('ocdevwizard/' . self::$_module_name));

        $form_info = $this->{'model_ocdevwizard_' . self::$_module_name}->getForm($form_id);

        $language_id = $this->{'model_ocdevwizard_' . self::$_module_name}->getLanguageByCode($this->session->data['language']);

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
                if ($this->request->request[$field['name']]) {
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

            //$this->{'model_ocdevwizard_'.self::$_module_name}->addMessage($filter_data);

            if (isset($form_info['success_message'])) {
                $json['output'] = html_entity_decode($form_info['success_message'], ENT_QUOTES, 'UTF-8');
            }

            $json['button_close_text'] = $this->language->get('button_close_modal');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function getActiveField($form_id)
    {
        $models = array('ocdevwizard/' . self::$_module_name);
        foreach ($models as $model) {
            $this->load->model($model);
        }

        $form_info = $this->{'model_ocdevwizard_' . self::$_module_name}->getForm($form_id);

        $fields = unserialize($form_info['field_data']);

        foreach ($fields as $key => $field) {
            if ($field['activate'] == 0) {
                unset($fields[$key]);
            }
        }

        return $fields;
    }

    public function getForms()
    {
        $json = array();

        // connect models array
        $models = array(
            'ocdevwizard/' . self::$_module_name
        );

        foreach ($models as $model) {
            $this->load->model($model);
        }

        $json['forms'] = array();

        $results = $this->{'model_ocdevwizard_' . self::$_module_name}->getForms();

        foreach ($results as $result) {
            $add_id_selector = explode(',', $result['add_id_selector']);

            $json['forms'][] = array(
                'form_id' => $result['form_id'],
                'heading_module' => $result['heading_module'],
                'add_id_selector' => $add_id_selector,
                'location' => $result['location'],
                'call_button' => $result['call_button']
            );
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}

?>