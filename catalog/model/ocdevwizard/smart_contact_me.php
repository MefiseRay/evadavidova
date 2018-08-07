<?php

// @category  : OpenCart
// @module    : Smart Contact Me
// @author    : OCdevWizard <ocdevwizard@gmail.com> 
// @copyright : Copyright (c) 2015, OCdevWizard
// @license   : http://license.ocdevwizard.com/Licensing_Policy.pdf

class ModelOcdevwizardSmartContactMe extends Model {

	static $_module_version = '2.0.0';
	static $_module_name    = 'smart_contact_me'; 

	public function addMessage($data = array()) {
		$this->db->query("INSERT INTO ".DB_PREFIX."smcm_record SET form_id = '".(int)$data['form_id']."', ip = '".$data['ip']."', referer = '".$data['referer']."', user_agent = '".$data['user_agent']."', accept_language = '".$data['accept_language']."', field_data = '".serialize($data['field_data'])."', date_added = NOW()");

		$record_id = $this->db->getLastId();

		$form_info = $this->getForm($data['form_id']);

		if ($form_info && $form_info['allow_admin_notify']) {
			$html_data = array();

			$html_data = array_merge($html_data, $this->language->load('ocdevwizard/'.self::$_module_name));

			$html_data['title'] = sprintf($html_data['text_email_title'], $record_id);

			$message_info = $this->getMessage($record_id);

			$html_data['fields'] = array();

			$fields = unserialize($message_info['field_data']);

			foreach ($fields as $field) {
				$html_data['fields'][] = $field;
			}

			$store_id = $this->config->get('config_store_id');
			$html_data['store_name'] 			= (string)$this->config->get('config_name');
			$html_data['logo'] 					  = $store_id ? $this->config->get('config_url') : HTTP_SERVER.'image/'.$this->config->get('config_logo');
			$html_data['store_url']				= $store_id ? $this->config->get('config_url') : HTTP_SERVER;
			$html_data['form_id']         = $message_info['form_id'];
			$html_data['ip']              = $message_info['ip'];
			$html_data['referer']         = $message_info['referer'];
			$html_data['user_agent']      = $message_info['user_agent'];
			$html_data['accept_language'] = $message_info['accept_language'];
			$html_data['date_added']      = $message_info['date_added'];

			$html = $this->load->view('ocdevwizard/'.self::$_module_name.'/'.self::$_module_name.'_mail_system.tpl', $html_data);

			// email notification
      $mail = new Mail();
      $mail->protocol = $this->config->get('config_mail_protocol');
      $mail->parameter = $this->config->get('config_mail_parameter');
      $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
      $mail->smtp_username = $this->config->get('config_mail_smtp_username');
      $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
      $mail->smtp_port = $this->config->get('config_mail_smtp_port');
      $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout'); 
							
			$mail->setTo($form_info['admin_email_for_notifications']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($this->config->get('config_name'));
			$mail->setSubject($html_data['title']);
			$mail->setHtml($html);
			$mail->send();
		}

		return $record_id;
	}

	public function getMessage($record_id) {
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."smcm_record WHERE record_id = '".(int)$record_id."'");

		return $query->row;
	}

	public function getForm($form_id) {
		$customer_group_id = $this->customer->isLogged() ? (int)$this->customer->getGroupId() : (int)$this->config->get('config_customer_group_id');

		$query = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."smcm_form f LEFT JOIN ".DB_PREFIX."smcm_form_description fd ON (f.form_id = fd.form_id) LEFT JOIN ".DB_PREFIX."smcm_form_to_store f2s ON (f.form_id = f2s.form_id) LEFT JOIN ".DB_PREFIX."smcm_form_to_customer_group f2c ON (f.form_id = f2c.form_id) WHERE f.form_id = '".(int)$form_id."' AND fd.language_id = '".(int)$this->config->get('config_language_id')."' AND f2s.store_id = '".(int)$this->config->get('config_store_id')."' AND f2c.customer_group_id = '".(int)$customer_group_id."' AND f.status = '1'");

		return $query->row;
	}

	public function getForms() {
		$customer_group_id = $this->customer->isLogged() ? (int)$this->customer->getGroupId() : (int)$this->config->get('config_customer_group_id');

		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."smcm_form f LEFT JOIN ".DB_PREFIX."smcm_form_description fd ON (f.form_id = fd.form_id) LEFT JOIN ".DB_PREFIX."smcm_form_to_store f2s ON (f.form_id = f2s.form_id) LEFT JOIN ".DB_PREFIX."smcm_form_to_customer_group f2c ON (f.form_id = f2c.form_id) WHERE fd.language_id = '".(int)$this->config->get('config_language_id')."' AND f2s.store_id = '".(int)$this->config->get('config_store_id')."' AND f2c.customer_group_id = '".(int)$customer_group_id."' AND f.status = '1' AND f.display_type = '1' ORDER BY LCASE(fd.heading_module) ASC");

		return $query->rows;
	}

	public function getLanguageByCode($code) {
    $query = $this->db->query("SELECT language_id FROM ".DB_PREFIX."language WHERE code = '".(string)$code."'");

    return $query->row['language_id'];
  }
}
?>