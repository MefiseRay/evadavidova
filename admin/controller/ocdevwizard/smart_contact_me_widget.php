<?php

// @category  : OpenCart
// @module    : Smart Contact Me
// @author    : OCdevWizard <ocdevwizard@gmail.com> 
// @copyright : Copyright (c) 2015, OCdevWizard
// @license   : http://license.ocdevwizard.com/Licensing_Policy.pdf

class ControllerOcdevwizardSmartContactMeWidget extends Controller {

	static $_module_version = '2.0.0';
	static $_module_name    = 'smart_contact_me'; 

	public function index() {
		$data = array();

    // connect models array
		$models = array(
			'ocdevwizard/'.self::$_module_name
		);

		foreach ($models as $model) {
			$this->load->model($model);
		} 

		$data = array_merge($data, $this->language->load('ocdevwizard/'.self::$_module_name.'_widget'));

		$data['total_viewed'] = $this->{'model_ocdevwizard_'.self::$_module_name}->getTotalRecordsForWidget(array('filter_viewed' => 1));
		$data['total_not_viewed'] = $this->{'model_ocdevwizard_'.self::$_module_name}->getTotalRecordsForWidget(array('filter_viewed' => 0));
		$data['total'] = $this->{'model_ocdevwizard_'.self::$_module_name}->getTotalRecordsForWidget();

		$data['link'] = $this->url->link('ocdevwizard/'.self::$_module_name.'_message', 'token='.$this->session->data['token'], 'SSL');

		return $this->load->view('ocdevwizard/'.self::$_module_name.'_widget.tpl', $data);
	}
}