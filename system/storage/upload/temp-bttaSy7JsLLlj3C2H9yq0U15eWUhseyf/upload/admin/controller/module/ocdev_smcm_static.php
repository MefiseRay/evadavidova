<?php

// @category  : OpenCart
// @module    : Smart Contact Me
// @author    : OCdevWizard <ocdevwizard@gmail.com> 
// @copyright : Copyright (c) 2015, OCdevWizard
// @license   : http://license.ocdevwizard.com/Licensing_Policy.pdf

class ControllerModuleOCdevSmcmStatic extends Controller {

	private $error           = array(); 
	static  $_module_version = '2.0.0';
	static  $_module_name    = 'ocdev_smcm_static';

	public function index() {
		$data = array();
		
		// connect models array
		$models = array(
    	'extension/module',
    	'localisation/language',
    	'ocdevwizard/smart_contact_me'
    );

    foreach ($models as $model) {
      $this->load->model($model);
    }

		$data = array_merge($data, $this->language->load('module/'.self::$_module_name));
		$this->document->setTitle($this->language->get('heading_name'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule(self::$_module_name, $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['error_warning'] = (isset($this->error['warning'])) ? $this->error['warning'] : '';
		$data['error_name'] = (isset($this->error['name'])) ? $this->error['name'] : '';
		$data['error_heading'] = (isset($this->error['heading'])) ? $this->error['heading'] : '';

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_name'),
				'href' => $this->url->link('module/'.self::$_module_name, 'token=' . $this->session->data['token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_name'),
				'href' => $this->url->link('module/'.self::$_module_name, 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);			
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/'.self::$_module_name, 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('module/'.self::$_module_name, 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
		
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['form_id'])) {
			$data['form_id'] = $this->request->post['form_id'];
		} elseif (!empty($module_info)) {
			$data['form_id'] = $module_info['form_id'];
		} else {
			$data['form_id'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		$data['languages'] = $this->model_localisation_language->getLanguages();
		$data['forms'] = $this->model_ocdevwizard_smart_contact_me->getForms();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/'.self::$_module_name.'.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/'.self::$_module_name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (is_array($this->request->post['heading'])) {
			foreach ($this->request->post['heading'] as $language_id => $heading) {
				if ((utf8_strlen($heading) < 1) || (utf8_strlen($heading) > 255)) {
	        $this->error['heading'][$language_id] = $this->language->get('error_heading');
	      }
			}
		}

		return !$this->error;
	}
}