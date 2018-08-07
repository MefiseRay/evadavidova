<?php

// @category  : OpenCart
// @module    : Smart Contact Me
// @author    : OCdevWizard <ocdevwizard@gmail.com>
// @copyright : Copyright (c) 2015, OCdevWizard
// @license   : http://license.ocdevwizard.com/Licensing_Policy.pdf

class ControllerOcdevwizardSmartContactMe extends Controller {

	private $error           = array();
	static  $_module_version = '2.0.0';
	static  $_module_name    = 'smart_contact_me';
	static  $_compatible_version = '2.2.0.0'; 

	public function index() {
		$data = array();

    // connect models array
    $models = array(
      'setting/store', 
      'user/user_group', 
      'ocdevwizard/'.self::$_module_name, 
      'ocdevwizard/ocdevwizard_setting'
    );

    foreach ($models as $model) {
      $this->load->model($model);
    } 

		$data = array_merge($data, $this->language->load('ocdevwizard/'.self::$_module_name));
		$this->document->setTitle($this->language->get('heading_name'));

		$styles = array('stylesheet.css');
		foreach ($styles as $style) {
			$this->document->addStyle('view/stylesheet/ocdevwizard/'.self::$_module_name.'/'.$style);
		}

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
      if (is_uploaded_file($this->request->files['import']['tmp_name'])) {
        $content = file_get_contents($this->request->files['import']['tmp_name']);
      }

      if (isset($content)) {
        $this->session->data['success'] = $this->language->get('text_success');
        $this->model_ocdevwizard_ocdevwizard_setting->editSetting(self::$_module_name, unserialize($content));
        $this->response->redirect($this->url->link('extension/module', 'token='.$this->session->data['token'], 'SSL'));
      } else {
        $this->session->data['success'] = $this->language->get('text_success');
        $this->model_ocdevwizard_ocdevwizard_setting->editSetting(self::$_module_name, $this->request->post);
        $this->response->redirect($this->url->link('extension/module', 'token='.$this->session->data['token'], 'SSL'));
      }
    }

		$data['error_warning'] = (isset($this->error['warning'])) ? $this->error['warning'] : '';
    $data['error_warning'] = (isset($this->error['compatible_version'])) ? $this->error['compatible_version'] : '';

		if (isset($this->session->data['success'])) {
      $data['success'] = $this->session->data['success'];

      unset($this->session->data['success']);
    } else {
      $data['success'] = '';
    }

    if (isset($this->session->data['warning'])) {
      $data['warning'] = $this->session->data['warning'];

      unset($this->session->data['warning']);
    } else {
      $data['warning'] = '';
    }

    $data['breadcrumbs'] = array(
      0 => array(
        'text'      => $this->language->get('text_home'),
        'href'      => $this->url->link('common/home', 'token='.$this->session->data['token'], 'SSL'),
        'separator' => false
      ),
      1 => array(
        'text'      => $this->language->get('text_module'),
        'href'      => $this->url->link('extension/module', 'token='.$this->session->data['token'], 'SSL'),
        'separator' => ' :: '
      ),
      2 => array(
        'text'      => $this->language->get('heading_title'),
        'href'      => $this->url->link('ocdevwizard/'.self::$_module_name, 'token='.$this->session->data['token'], 'SSL'),
        'separator' => ' :: '
      )
    );

    $this->{'model_ocdevwizard_'.self::$_module_name}->createDBTables();

    $module_settings = $this->model_ocdevwizard_ocdevwizard_setting->getSetting(self::$_module_name);

    if (!$module_settings) {
      // add permission
      $modules = array(
      	'ocdevwizard/'.self::$_module_name, 
      	'ocdevwizard/'.self::$_module_name.'_form',
      	'ocdevwizard/'.self::$_module_name.'_message'
      );

      foreach ($modules as $module) {
        $this->model_user_user_group->addPermission($this->user->getId(), 'access', $module);
        $this->model_user_user_group->addPermission($this->user->getId(), 'modify', $module);
      }

      // set default data
      $this->model_ocdevwizard_ocdevwizard_setting->editSetting(self::$_module_name, array(
        self::$_module_name.'_form_data' => array(
          'activate'             => '1',
					'show_on_dashboard'    => '1',
					'front_module_name'    => str_replace(array('<b>','</b>'), "", $this->language->get('heading_title')),
          'front_module_version' => (string)self::$_module_version
        )
      ));

      $this->session->data['success'] = $this->language->get('text_success_install');
    }

		$data['action']           = $this->url->link('ocdevwizard/'.self::$_module_name, 'token='.$this->session->data['token'], 'SSL');
    $data['uninstall']        = $this->url->link('ocdevwizard/'.self::$_module_name.'/uninstall', 'token='.$this->session->data['token'], 'SSL');
    $data['action_plus']      = $this->url->link('ocdevwizard/'.self::$_module_name.'/edit_and_stay', 'token='.$this->session->data['token'], 'SSL');
    $data['export_settings_button'] = $this->url->link('ocdevwizard/'.self::$_module_name.'/export_settings', 'token='.$this->session->data['token'], 'SSL');
    $data['import_settings_button'] = $this->url->link('ocdevwizard/'.self::$_module_name.'/import_settings', 'token='.$this->session->data['token'], 'SSL');
    $data['contact_me_form_list'] = $this->url->link('ocdevwizard/'.self::$_module_name.'_form', 'token='.$this->session->data['token'], 'SSL');
		$data['contact_me_message_list'] = $this->url->link('ocdevwizard/'.self::$_module_name.'_message', 'token='.$this->session->data['token'], 'SSL');
    $data['cancel']           = $this->url->link('extension/module', 'token='.$this->session->data['token'], 'SSL');
    $data['admin_language']   = $this->config->get('config_admin_language');
    $data['_module_name']     = (string)self::$_module_name;
    $data['_module_version']  = (string)self::$_module_version;
    $data['opencart_version'] = VERSION;
    $data['token']            = $this->session->data['token'];
    $data['form_data']        = $form_data = isset($this->request->post[self::$_module_name.'_form_data']) ? $this->request->post[self::$_module_name.'_form_data'] : $this->model_ocdevwizard_ocdevwizard_setting->getSettingData(self::$_module_name.'_form_data');
		
		// codev products
    $data['products'] = $this->{'model_ocdevwizard_'.self::$_module_name}->getOCdevCatalog();

    // codev support
    $data['support_info'] = $this->{'model_ocdevwizard_'.self::$_module_name}->getOCdevSupportInfo();

    $data['header']      = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer']      = $this->load->controller('common/footer');

    $this->response->setOutput($this->load->view('ocdevwizard/'.self::$_module_name.'.tpl', $data));
	}

	public function edit_and_stay() {
    if (!$this->user->hasPermission('modify', 'ocdevwizard/'.self::$_module_name)) {
      $this->language->load('ocdevwizard/'.self::$_module_name);
      $this->session->data['warning'] = $this->language->get('error_permission');

      $this->response->redirect($this->url->link('ocdevwizard/'.self::$_module_name, 'token='.$this->session->data['token'], 'SSL'));
    } else {
      $data = array();

      // connect models array
      $models = array('ocdevwizard/ocdevwizard_setting');
      foreach ($models as $model) {
        $this->load->model($model);
      }

      $data = array_merge($data, $this->language->load('ocdevwizard/'.self::$_module_name));
      $this->document->setTitle($this->language->get('heading_title'));

      if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {

        if (is_uploaded_file($this->request->files['import']['tmp_name'])) {
          $content = file_get_contents($this->request->files['import']['tmp_name']);
        }

        if (isset($content)) {
          $this->session->data['success'] = $this->language->get('text_success');
          $this->model_ocdevwizard_ocdevwizard_setting->editSetting(self::$_module_name, unserialize($content));
          $this->response->redirect($this->url->link('ocdevwizard/'.self::$_module_name, 'token='.$this->session->data['token'], 'SSL'));
        } else {
          $this->session->data['success'] = $this->language->get('text_success');
          $this->model_ocdevwizard_ocdevwizard_setting->editSetting(self::$_module_name, $this->request->post);
          $this->response->redirect($this->url->link('ocdevwizard/'.self::$_module_name, 'token='.$this->session->data['token'], 'SSL'));
        }
      } else {
        $this->index();
      }
    }  
  }

	public function uninstall() {
    $this->language->load('ocdevwizard/'.self::$_module_name);

    if (!$this->user->hasPermission('modify', 'ocdevwizard/'.self::$_module_name)) {
      $this->session->data['warning'] = $this->language->get('error_permission');

      $this->response->redirect($this->url->link('ocdevwizard/'.self::$_module_name, 'token='.$this->session->data['token'], 'SSL'));
    } else {
      // connect model data
      $models = array(
        'ocdevwizard/ocdevwizard_setting', 
        'ocdevwizard/'.self::$_module_name, 
        'user/user_group'
      );

      foreach ($models as $model) {
        $this->load->model($model);
      }

      // add permission
      $modules = array(
      	'ocdevwizard/'.self::$_module_name, 
      	'ocdevwizard/'.self::$_module_name.'_form',
      	'ocdevwizard/'.self::$_module_name.'_message'
      );

      foreach ($modules as $module) {
        $this->model_user_user_group->removePermission($this->user->getId(), 'access', $module);
        $this->model_user_user_group->removePermission($this->user->getId(), 'modify', $module);
      }

      $this->{'model_ocdevwizard_'.self::$_module_name}->deleteDBTables();
      $this->model_ocdevwizard_ocdevwizard_setting->deleteSetting(self::$_module_name);

      $this->session->data['success'] = $this->language->get('text_success_uninstall');
       
      $this->response->redirect($this->url->link('extension/module', 'token='.$this->session->data['token'], 'SSL'));
    }
  }

	private function validate() {
    if (!$this->user->hasPermission('modify', 'ocdevwizard/'.self::$_module_name)) {
      $this->error['warning'] = $this->language->get('error_permission');
      $this->session->data['warning'] = $this->language->get('error_permission');
    }

    $opencart_version = explode("|", self::$_compatible_version);
    if (!in_array(VERSION, $opencart_version)) {
      $this->error['compatible_version'] = $this->language->get('error_compatible_version');
    }

		return (!$this->error) ? TRUE : FALSE;
	}

	public function export_settings() {
    // connect models array
    $models = array('ocdevwizard/ocdevwizard_setting');
    foreach ($models as $model) {
      $this->load->model($model);
    }

    $module_settings = $this->model_ocdevwizard_ocdevwizard_setting->getSetting(self::$_module_name);

    $this->response->addheader('Pragma: public');
    $this->response->addheader('Expires: 0');
    $this->response->addheader('Content-Description: File Transfer');
    $this->response->addheader('Content-Type: application/octet-stream');
    $this->response->addheader('Content-Disposition: attachment; filename='.self::$_module_name.'_'.date("Y-m-d H:i:s", time()).'.txt');
    $this->response->addheader('Content-Transfer-Encoding: binary');

    $this->response->setOutput(serialize($module_settings));
  }
}
?>
