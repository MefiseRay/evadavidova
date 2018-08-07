<?php

// @category  : OpenCart
// @module    : Smart Contact Me
// @author    : OCdevWizard <ocdevwizard@gmail.com> 
// @copyright : Copyright (c) 2015, OCdevWizard
// @license   : http://license.ocdevwizard.com/Licensing_Policy.pdf

class ModelOcdevwizardSmartContactMe extends Model {

	static $_module_version = '2.0.0';
	static $_module_name    = 'smart_contact_me'; 

	public function updateViewed($record_id) {
		$this->db->query("UPDATE ".DB_PREFIX."smcm_record SET viewed = '1' WHERE record_id = '".(int)$record_id."'");
	}

	public function addForm($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."smcm_form SET add_id_selector = '".$data['add_id_selector']."', location = '".(int)$data['location']."', status = '".(int)$data['status']."', allow_admin_notify = '".(int)$data['allow_admin_notify']."', admin_email_for_notifications = '".$data['admin_email_for_notifications']."', display_type = '".(int)$data['display_type']."', background = '".$data['background']."', background_opacity = '".(int)$data['background_opacity']."', date_added = NOW()");

		$form_id = $this->db->getLastId();

		foreach ($data['form_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO ".DB_PREFIX."smcm_form_description SET form_id = '".(int)$form_id."', language_id = '".(int)$language_id."', heading_module = '".$this->db->escape($value['heading_module'])."', call_button = '".$this->db->escape($value['call_button'])."', send_button = '".$this->db->escape($value['send_button'])."', close_button = '".$this->db->escape($value['close_button'])."', success_message = '".$this->db->escape($value['success_message'])."', field_data = '".serialize($data['field_data'])."'");
		}

		if (isset($data['feedback_store'])) {
			foreach ($data['feedback_store'] as $store_id) {
				$this->db->query("INSERT INTO ".DB_PREFIX."smcm_form_to_store SET form_id = '".(int)$form_id."', store_id = '".(int)$store_id."'");
			}
		}

		if (isset($data['feedback_customer_groups'])) {
			foreach ($data['feedback_customer_groups'] as $customer_group_id) {
				$this->db->query("INSERT INTO ".DB_PREFIX."smcm_form_to_customer_group SET form_id = '".(int)$form_id."', customer_group_id = '".(int)$customer_group_id."'");
			}
		}

		return $form_id;
	}

	public function editForm($form_id, $data) {
		$this->db->query("UPDATE ".DB_PREFIX."smcm_form SET add_id_selector = '".$data['add_id_selector']."', location = '".(int)$data['location']."', status = '".(int)$data['status']."', allow_admin_notify = '".(int)$data['allow_admin_notify']."', admin_email_for_notifications = '".$data['admin_email_for_notifications']."', display_type = '".(int)$data['display_type']."', background = '".$data['background']."', background_opacity = '".(int)$data['background_opacity']."', date_modified = NOW() WHERE form_id = '".(int)$form_id."'");

		$this->db->query("DELETE FROM ".DB_PREFIX."smcm_form_description WHERE form_id = '".(int)$form_id."'");

		foreach ($data['form_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO ".DB_PREFIX."smcm_form_description SET form_id = '".(int)$form_id."', language_id = '".(int)$language_id."', heading_module = '".$this->db->escape($value['heading_module'])."', call_button = '".$this->db->escape($value['call_button'])."', send_button = '".$this->db->escape($value['send_button'])."', close_button = '".$this->db->escape($value['close_button'])."', success_message = '".$this->db->escape($value['success_message'])."', field_data = '".serialize($data['field_data'])."'");
		}

		$this->db->query("DELETE FROM ".DB_PREFIX."smcm_form_to_store WHERE form_id = '".(int)$form_id."'");

		if (isset($data['feedback_store'])) {
			foreach ($data['feedback_store'] as $store_id) {
				$this->db->query("INSERT INTO ".DB_PREFIX."smcm_form_to_store SET form_id = '".(int)$form_id."', store_id = '".(int)$store_id."'");
			}
		}

		$this->db->query("DELETE FROM ".DB_PREFIX."smcm_form_to_customer_group WHERE form_id = '".(int)$form_id."'");

		if (isset($data['feedback_customer_groups'])) {
			foreach ($data['feedback_customer_groups'] as $customer_group_id) {
				$this->db->query("INSERT INTO ".DB_PREFIX."smcm_form_to_customer_group SET form_id = '".(int)$form_id."', customer_group_id = '".(int)$customer_group_id."'");
			}
		}
	}

	public function getForm($form_id) {
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."smcm_form WHERE form_id = '".(int)$form_id."'");

		return $query->row;
	}

	public function getForms($data = array()) {
		$sql = "SELECT * FROM ".DB_PREFIX."smcm_form f LEFT JOIN ".DB_PREFIX."smcm_form_description fd ON (f.form_id = fd.form_id) WHERE fd.language_id = '".(int)$this->config->get('config_language_id')."'";

		$sort_data = array(
			'fd.heading_module',
			'f.date_added',
			'f.date_modified'
			);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY ".$data['sort'];
		} else {
			$sql .= " ORDER BY f.date_added";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalForms() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."smcm_form");

		return $query->row['total'];
	}

	public function deleteForm($form_id) {
		$this->db->query("DELETE FROM ".DB_PREFIX."smcm_form WHERE form_id = '".(int)$form_id."'");
		$this->db->query("DELETE FROM ".DB_PREFIX."smcm_form_description WHERE form_id = '".(int)$form_id."'");
		$this->db->query("DELETE FROM ".DB_PREFIX."smcm_form_to_store WHERE form_id = '".(int)$form_id."'");
		$this->db->query("DELETE FROM ".DB_PREFIX."smcm_form_to_customer_group WHERE form_id = '".(int)$form_id."'");
	}

	public function getRecord($record_id) {
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."smcm_record WHERE record_id = '".(int)$record_id."'");

		return $query->row;
	}

	public function getRecords($data = array()) {
		$sql = "SELECT * FROM ".DB_PREFIX."smcm_record r LEFT JOIN ".DB_PREFIX."smcm_form_description fd ON (r.form_id = fd.form_id) WHERE fd.language_id = '".(int)$this->config->get('config_language_id')."'";

		$sort_data = array(
			'fd.heading_module',
			'r.date_added',
			'r.viewed'
			);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY ".$data['sort'];
		} else {
			$sql .= " ORDER BY r.date_added";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalRecords($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `".DB_PREFIX."smcm_record`";
		
		if (!empty($data['filter_date_added'])) {
			$sql .= " WHERE DATE(date_added) = DATE('".$this->db->escape($data['filter_date_added'])."')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalRecordsForWidget($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `".DB_PREFIX."smcm_record`";

		if (isset($data['filter_viewed'])) {
			$sql .= " WHERE viewed = '".$this->db->escape($data['filter_viewed'])."'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function deleteRecord($record_id) {
		$this->db->query("DELETE FROM ".DB_PREFIX."smcm_record WHERE record_id = '".(int)$record_id."'");
	}

	public function getDescription($form_id) {
		$smcm_form_description_data = array();

		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."smcm_form_description WHERE form_id = '".(int)$form_id."'");

		foreach ($query->rows as $result) {
			$smcm_form_description_data[$result['language_id']] = array(
				'heading_module'   => $result['heading_module'],
				'call_button'      => $result['call_button'],
				'send_button'      => $result['send_button'],
				'close_button'     => $result['close_button'],
				'success_message'  => $result['success_message']
			);
		}

		return $smcm_form_description_data;
	}

	public function getFields($form_id) {
		$smcm_form_description_data = array();

		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."smcm_form_description WHERE form_id = '".(int)$form_id."'");

		foreach ($query->rows as $key => $result) {
			$smcm_form_description_data = unserialize($result['field_data']);
		}

		return $smcm_form_description_data;
	}

	public function getStores($form_id) {
		$smcm_form_store_data = array();

		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."smcm_form_to_store WHERE form_id = '".(int)$form_id."'");

		foreach ($query->rows as $result) {
			$smcm_form_store_data[] = $result['store_id'];
		}

		return $smcm_form_store_data;
	}

	public function getCustomerGroups($form_id) {
		$ocdev_smart_customer_group_data = array();

		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."smcm_form_to_customer_group WHERE form_id = '".(int)$form_id."'");

		foreach ($query->rows as $result) {
			$ocdev_smart_customer_group_data[] = $result['customer_group_id'];
		}

		return $ocdev_smart_customer_group_data;
	}

		public function createDBTables() {
		$sql1  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ocdevwizard_setting` ( ";
		$sql1 .= "`setting_id` int(11) NOT NULL AUTO_INCREMENT,";
		$sql1 .= "`store_id` int(11) NOT NULL DEFAULT '0',";
		$sql1 .= "`code` varchar(32) NOT NULL,";
		$sql1 .= "`key` varchar(64) NOT NULL,";
		$sql1 .= "`value` text NOT NULL,";
		$sql1 .= "`serialized` tinyint(1) NOT NULL,";
		$sql1 .= "PRIMARY KEY (`setting_id`)";
		$sql1 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

		$this->db->query($sql1);

		$sql2  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."smcm_form` (";
		$sql2 .= "`form_id` int(11) NOT NULL AUTO_INCREMENT, ";
		$sql2 .= "`add_id_selector` varchar(128) COLLATE utf8_general_ci NOT NULL, ";
		$sql2 .= "`location` int(1) NOT NULL, ";
		$sql2 .= "`status` tinyint(1) NOT NULL DEFAULT '1', ";
		$sql2 .= "`allow_admin_notify` tinyint(1) NOT NULL DEFAULT '1', ";
		$sql2 .= "`admin_email_for_notifications` text COLLATE utf8_general_ci NOT NULL, ";
		$sql2 .= "`display_type` tinyint(1) NOT NULL DEFAULT '1', ";
		$sql2 .= "`background` varchar(255) COLLATE utf8_general_ci NOT NULL DEFAULT 'bg_7.png', ";
		$sql2 .= "`background_opacity` int(11) NOT NULL DEFAULT '8', ";
		$sql2 .= "`date_added` datetime NOT NULL, ";
		$sql2 .= "`date_modified` datetime NOT NULL, ";
		$sql2 .= "PRIMARY KEY (`form_id`) ";
		$sql2 .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ;";

		$this->db->query($sql2);
		
		$sql3 = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."smcm_form_description` (";
		$sql3 .= "`form_id` int(11) NOT NULL, ";
		$sql3 .= "`field_data` text COLLATE utf8_general_ci NOT NULL, ";
		$sql3 .= "`language_id` int(11) NOT NULL, ";
		$sql3 .= "`heading_module` varchar(64) COLLATE utf8_general_ci NOT NULL, ";
		$sql3 .= "`call_button` varchar(64) COLLATE utf8_general_ci NOT NULL, ";
		$sql3 .= "`send_button` varchar(64) COLLATE utf8_general_ci NOT NULL, ";
		$sql3 .= "`close_button` varchar(64) COLLATE utf8_general_ci NOT NULL, ";
		$sql3 .= "`success_message` text COLLATE utf8_general_ci NOT NULL ";
		$sql3 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci; ";

		$this->db->query($sql3);
		
		$sql4 = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."smcm_record` (";
		$sql4 .= "`record_id` int(11) NOT NULL AUTO_INCREMENT, ";
		$sql4 .= "`form_id` int(11) NOT NULL, ";
		$sql4 .= "`ip` varchar(40) COLLATE utf8_general_ci NOT NULL, ";
		$sql4 .= "`referer` text NOT NULL, ";
		$sql4 .= "`user_agent` varchar(255) COLLATE utf8_general_ci NOT NULL, ";
		$sql4 .= "`accept_language` varchar(255) COLLATE utf8_general_ci NOT NULL, ";
		$sql4 .= "`field_data` text COLLATE utf8_general_ci NOT NULL, ";
		$sql4 .= "`viewed` int(1) COLLATE utf8_general_ci NOT NULL DEFAULT '0', ";
		$sql4 .= "`date_added` datetime NOT NULL, ";
		$sql4 .= "PRIMARY KEY (`record_id`) ";
		$sql4 .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ; ";

		$this->db->query($sql4);
		
		$sql_5 = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."smcm_form_to_customer_group` (";
		$sql_5 .= "`form_id` int(11) NOT NULL, ";
		$sql_5 .= "`customer_group_id` int(11) NOT NULL ";
		$sql_5 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci; ";

		$this->db->query($sql_5);
		
		$sql6 = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."smcm_form_to_store` (";
		$sql6 .= "`form_id` int(11) NOT NULL, ";
		$sql6 .= "`store_id` int(11) NOT NULL ";
		$sql6 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci; ";

		$this->db->query($sql6);
	}

	public function deleteDBTables() {
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."smcm_form`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."smcm_form_description`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."smcm_form_to_customer_group`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."smcm_form_to_store`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."smcm_record`;");
	}

	public function getOCdevCatalog() {
		$catalog = array();
		$source  = 'http://ocdevwizard.com/products/share/share.xml';

		if ($source) {
			if (ini_get('allow_url_fopen')) {
				$results = simplexml_load_file($source);
			} else {    
				$ch = curl_init($source);    
				curl_setopt ($ch, CURLOPT_HEADER, false); 
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);    
				$xml_raw = curl_exec($ch);    
				$results = simplexml_load_string($xml_raw);
			}
			
			if ($results !== false) {
				foreach ($results->product as $product) {
					$catalog[] = array(
						'extension_id'     => (int)$product->extension_id,
						'title'            => (string)$product->title,
						'img'              => (string)$product->img,
						'price'            => (string)$product->price,
						'url'              => (string)str_replace("&amp;", "&", $product->url),
						'date_added'       => (string)$product->date_added,
						'opencart_version' => (string)$product->opencart_version,
						'latest_version'   => (string)$product->latest_version,
						'features'         => (string)$product->features
					);
				}
			}
		}
		return $catalog;
	}

	public function getOCdevSupportInfo() {
		$catalog = array();
		$source  = 'http://ocdevwizard.com/support/support.xml';

		if ($source) {
			if (ini_get('allow_url_fopen')) {
				$results = simplexml_load_file($source);
			} else {    
				$ch = curl_init($source);    
				curl_setopt ($ch, CURLOPT_HEADER, false); 
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);    
				$xml_raw = curl_exec($ch);    
				$results = simplexml_load_string($xml_raw);
			}
			
			if ($results !== false) {
				$catalog = array(
					'general' => (string)$results->general,
					'terms'   => (string)$results->terms,
					'service' => (string)$results->service,
					'faq'     => (string)$results->faq
				);
			}
		}
		return $catalog;
	}
}