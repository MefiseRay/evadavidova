<?php
/* 
Version: 1.0
Author: Artur SuÅkowski
Website: http://artursulkowski.pl
*/

class ControllerModuleSmenu extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('module/smenu');

        $this->document->setTitle('Vertical Menu');

        $this->load->model('setting/setting');

        // Dodawanie plikÃ³w css i js do <head>
        $this->document->addStyle('view/stylesheet/blog_latest.css');

        // Zapisywanie moduÅu
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('smenu', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('module/smenu', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['button_control'] = $this->language->get('button_control');

        $data['button_control_href'] = $this->url->link('catalog/smenu', 'token=' . $this->session->data['token'], 'SSL');

        // WyÅwietlanie powiadomieÅ
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

        $data['action'] = $this->url->link('module/smenu', 'token=' . $this->session->data['token'], 'SSL');

        $data['token'] = $this->session->data['token'];

        // Åadowanie listy moduÅÃ³w
        $data['modules'] = array();

        if (isset($this->request->post['smenu_module'])) {
            $data['modules'] = $this->request->post['smenu_module'];
        } elseif ($this->config->get('smenu_module')) {
            $data['modules'] = $this->config->get('smenu_module');
        }

        // Layouts
        $this->load->model('design/layout');
        $data['layouts'] = $this->model_design_layout->getLayouts();


        // Menu
        $this->load->model('catalog/smenu');

        $data['menus'] = $this->model_catalog_smenu->getSmenus();

        // Languages
        $this->load->model('localisation/language');
        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => 'Modules',
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => 'Vertical Menu',
            'href' => $this->url->link('module/smenu', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/smenu.tpl', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'module/smenu')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function install()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "smenu` (
			`smenu_id` int(11) NOT NULL AUTO_INCREMENT,
			`smenu_status` tinyint(1) NOT NULL,
			`name` tinytext NOT NULL,
			PRIMARY KEY (`smenu_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "smenu_items` (
			`smenu_item_id` int(11) NOT NULL AUTO_INCREMENT,
			`smenu_order` int(11) NOT NULL,
			`smenu_parent` int(11) NOT NULL,
			`smenu_id` int(11) NOT NULL,
			`type` int(11) NOT NULL,
			`type_id` int(11) NOT NULL,
			`type_name` text NOT NULL,
		PRIMARY KEY (`smenu_item_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "smenu_links` (
			`smenu_items_id` int(11) NOT NULL,
			`smenu_text` varchar(64) NOT NULL,
			`smenu_title` varchar(64) NOT NULL,
			`smenu_language_id` int(11) NOT NULL,
			`smenu_id` int(11) NOT NULL,
		UNIQUE KEY `smenu_items_id_3` (`smenu_items_id`,`smenu_language_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
    }

    public function uninstall()
    {
        $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "smenu");
        $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "smenu_items");
        $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "smenu_links");
    }
}

?>