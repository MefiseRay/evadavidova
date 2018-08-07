<?php
class ControllerCatalogContact extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('catalog/contact');
		$this->load->language('setting/setting');
		
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/contact');
        $this->load->model('setting/setting');
		
		$this->getForm();

	}

	public function edit() {
		$this->language->load('catalog/contact');
		$this->load->language('setting/setting');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/contact');
        $this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            
            $this->model_catalog_contact->editContact($this->request->post);
            
            $this->model_setting_setting->editSetting('contact_page', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('catalog/contact', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = $this->language->get('text_edit');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_map_geocode'] = $this->language->get('entry_map_geocode');
		$data['help_map_geocode'] = $this->language->get('help_map_geocode');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_description_above'] = $this->language->get('entry_description_above');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_h1'] = $this->language->get('entry_meta_h1');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
        $data['entry_status'] = $this->language->get('entry_status');
		$data['entry_type'] = $this->language->get('entry_type');
        $data['text_type_one'] = $this->language->get('text_type_one');
        $data['text_type_all'] = $this->language->get('text_type_all');
        $data['entry_scroll'] = $this->language->get('entry_scroll');
        $data['entry_zoom'] = $this->language->get('entry_zoom');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
        $data['tab_map'] = $this->language->get('tab_map');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = array();
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/contact', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('catalog/contact/edit', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('catalog/contact', 'token=' . $this->session->data['token'], 'SSL');

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$contact_info = $this->model_catalog_contact->getContact($this->request->post);
		}

		$data['token'] = $this->session->data['token'];
        
        //CKEditor
        if ($this->config->get('config_editor_default')) {
            $this->document->addScript('view/javascript/ckeditor/ckeditor.js');
            $this->document->addScript('view/javascript/ckeditor/ckeditor_init.js');
        } else {
            $this->document->addScript('view/javascript/summernote/summernote.js');
            $this->document->addScript('view/javascript/summernote/lang/summernote-' . $this->language->get('lang') . '.js');
            $this->document->addScript('view/javascript/summernote/opencart.js');
            $this->document->addStyle('view/javascript/summernote/summernote.css');
        }

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['lang'] = $this->language->get('lang');

		if (isset($this->request->post['contact_description'])) {
			$data['contact_description'] = $this->request->post['contact_description'];
		} elseif ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$data['contact_description'] = $this->model_catalog_contact->getContact($this->request->post);
		} else {
			$data['contact_description'] = array();
		}
        
        if (isset($this->request->post['contact_page_map_status'])) {
			$data['contact_page_map_status'] = $this->request->post['contact_page_map_status'];
		} else {
			$data['contact_page_map_status'] = $this->config->get('contact_page_map_status');
		}
        
        if (isset($this->request->post['contact_page_map_type'])) {
			$data['contact_page_map_type'] = $this->request->post['contact_page_map_type'];
		} else {
			$data['contact_page_map_type'] = $this->config->get('contact_page_map_type');
		}
		
		if (isset($this->request->post['contact_page_map_scroll'])) {
			$data['contact_page_map_scroll'] = $this->request->post['contact_page_map_scroll'];
		} else {
			$data['contact_page_map_scroll'] = $this->config->get('contact_page_map_scroll');
		}
        
        if (isset($this->request->post['contact_page_map_zoom'])) {
			$data['contact_page_map_zoom'] = $this->request->post['contact_page_map_zoom'];
		} else {
			$data['contact_page_map_zoom'] = $this->config->get('contact_page_map_zoom');
		}
        
        if (isset($this->request->post['contact_page_map_geocode'])) {
			$data['contact_page_map_geocode'] = $this->request->post['contact_page_map_geocode'];
		} else {
			$data['contact_page_map_geocode'] = $this->config->get('contact_page_map_geocode');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/contact_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/contact')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['contact_description'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 64)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

}
