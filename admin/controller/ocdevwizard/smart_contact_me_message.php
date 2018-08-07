<?php

// @category  : OpenCart
// @module    : Smart Contact Me
// @author    : OCdevWizard <ocdevwizard@gmail.com> 
// @copyright : Copyright (c) 2015, OCdevWizard
// @license   : http://license.ocdevwizard.com/Licensing_Policy.pdf

class ControllerOcdevwizardSmartContactMeMessage extends Controller {
	
	private $error           = array(); 
	static  $_module_version = '2.0.0';
	static  $_module_name    = 'smart_contact_me';

	public function index() {
		$this->getList();
	}

	public function view() {
		$data = array();

    // connect models array
		$models = array(
			'ocdevwizard/'.self::$_module_name
		);

		foreach ($models as $model) {
			$this->load->model($model);
		} 

		$data = array_merge($data, $this->language->load('ocdevwizard/'.self::$_module_name.'_message'));
		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->{'model_ocdevwizard_'.self::$_module_name}->editForm($this->request->get['record_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort='.$this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order='.$this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page='.$this->request->get['page'];
			}

			$this->response->redirect($this->url->link('ocdevwizard/'.self::$_module_name.'_message', 'token='.$this->session->data['token'].$url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$data = array();

    // connect models array
		$models = array(
			'ocdevwizard/'.self::$_module_name
		);

		foreach ($models as $model) {
			$this->load->model($model);
		} 

		$data = array_merge($data, $this->language->load('ocdevwizard/'.self::$_module_name.'_message'));
		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['selected_record_id'])) {
			$this->{'model_ocdevwizard_'.self::$_module_name}->deleteRecord($this->request->get['selected_record_id']);
		}

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $record_id) {
				$this->{'model_ocdevwizard_'.self::$_module_name}->deleteRecord($record_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort='.$this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order='.$this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page='.$this->request->get['page'];
			}

			$this->response->redirect($this->url->link('ocdevwizard/'.self::$_module_name.'_message', 'token='.$this->session->data['token'].$url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		$data = array();

    // connect models array
		$models = array(
			'ocdevwizard/'.self::$_module_name
		);

		foreach ($models as $model) {
			$this->load->model($model);
		} 

		$data = array_merge($data, $this->language->load('ocdevwizard/'.self::$_module_name.'_message'));
		$this->document->setTitle($this->language->get('heading_name'));

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'fm.date_added';
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
			$url .= '&sort='.$this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order='.$this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page='.$this->request->get['page'];
		}

		$data['breadcrumbs'] = array(
			0 => array(
				'text'      => $this->language->get('text_home'),
				'href' 		=> $this->url->link('common/dashboard', 'token='.$this->session->data['token'], 'SSL')
			),
			1 => array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('ocdevwizard/'.self::$_module_name.'_message', 'token='.$this->session->data['token'].$url, 'SSL')
			)
		);

		$data['delete'] = $this->url->link('ocdevwizard/'.self::$_module_name.'_message/delete', 'token='.$this->session->data['token'].$url, 'SSL');

		$data['messages'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$messages_total = $this->{'model_ocdevwizard_'.self::$_module_name}->getTotalRecords();

		$results = $this->{'model_ocdevwizard_'.self::$_module_name}->getRecords($filter_data);

		foreach ($results as $result) {
			$data['messages'][] = array(
				'record_id'  => $result['record_id'],
				'title' 	  	=> $result['heading_module'],
				'date_added'  => $result['date_added'],
				'viewed' 	  	=> ($result['viewed'] == 0) ? $this->language->get('text_status_not_viewed') : $this->language->get('text_status_viewed'),
				'view'        => $this->url->link('ocdevwizard/'.self::$_module_name.'_message/view', 'token='.$this->session->data['token'].'&record_id='.$result['record_id'].$url, 'SSL'),
				'delete'      => $this->url->link('ocdevwizard/'.self::$_module_name.'_message/delete', 'token='.$this->session->data['token'].'&selected_record_id='.$result['record_id'].$url, 'SSL')
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
			$url .= '&page='.$this->request->get['page'];
		}

		$data['sort_title'] = $this->url->link('ocdevwizard/'.self::$_module_name.'_message', 'token='.$this->session->data['token'].'&sort=fd.heading_module'.$url, 'SSL');
		$data['sort_date_added'] = $this->url->link('ocdevwizard/'.self::$_module_name.'_message', 'token='.$this->session->data['token'].'&sort=fm.date_added'.$url, 'SSL');
		$data['sort_viewed'] = $this->url->link('ocdevwizard/'.self::$_module_name.'_message', 'token='.$this->session->data['token'].'&sort=fm.viewed'.$url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort='.$this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order='.$this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $messages_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('ocdevwizard/'.self::$_module_name.'_message', 'token='.$this->session->data['token'].$url.'&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($messages_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($messages_total - $this->config->get('config_limit_admin'))) ? $messages_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $messages_total, ceil($messages_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('ocdevwizard/'.self::$_module_name.'_message_list.tpl', $data));
	}

	protected function getForm() {
		$data = array();

    // connect models array
		$models = array(
			'ocdevwizard/'.self::$_module_name
		);

		foreach ($models as $model) {
			$this->load->model($model);
		} 

		$data = array_merge($data, $this->language->load('ocdevwizard/'.self::$_module_name.'_message'));
		$this->document->setTitle($this->language->get('heading_name'));

		$data['error_warning'] = (isset($this->error['warning'])) ? $this->error['warning'] : '';

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort='.$this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order='.$this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page='.$this->request->get['page'];
		}

		$data['breadcrumbs'] = array(
			0 => array(
				'text'  => $this->language->get('text_home'),
				'href'  => $this->url->link('common/dashboard', 'token='.$this->session->data['token'], 'SSL')
			),
			1 => array(
				'text'  => $this->language->get('heading_title'),
				'href'  => $this->url->link('ocdevwizard/'.self::$_module_name.'_message', 'token='.$this->session->data['token'].$url, 'SSL')
			)
		);

		$data['cancel'] = $this->url->link('ocdevwizard/'.self::$_module_name.'_message', 'token='.$this->session->data['token'].$url, 'SSL');

		if (isset($this->request->get['record_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$record_info = $this->{'model_ocdevwizard_'.self::$_module_name}->getRecord($this->request->get['record_id']);
			$this->{'model_ocdevwizard_'.self::$_module_name}->updateViewed($this->request->get['record_id']);
		}

		$data['token'] = $this->session->data['token'];

		$data['messages'] = array();

		$fields = unserialize($record_info['field_data']);

		$field_data = array();

		foreach ($fields as $field) {
			$field_data[] = $field;
		}

		$data['messages'][] = array(
			'record_id'       => $record_info['record_id'],
			'field_data'      => $field_data,
			'ip'              => $record_info['ip'],
			'referer'         => $record_info['referer'],
			'user_agent'      => $record_info['user_agent'],
			'accept_language' => $record_info['accept_language'],
			'date_added'      => $record_info['date_added']
		);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('ocdevwizard/'.self::$_module_name.'_message_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'ocdevwizard/'.self::$_module_name.'_message')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}
}