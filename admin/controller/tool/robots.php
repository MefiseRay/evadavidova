<?php
class ControllerToolRobots extends Controller {
	private $error = array();
    
	public function index() {		
		$this->load->language('tool/robots');
		
		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_confirm'] = $this->language->get('text_confirm');
        $data['text_loading'] = $this->language->get('text_loading');

        $data['button_upload'] = $this->language->get('button_upload');
		$data['button_download'] = $this->language->get('button_download');
        $data['button_save'] = $this->language->get('button_save');
		$data['button_clear'] = $this->language->get('button_clear');

        $data['token'] = $this->session->data['token'];
        
		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('tool/robots', 'token=' . $this->session->data['token'], 'SSL')
		);

        $data['action'] = $this->url->link('tool/robots/save', 'token=' . $this->session->data['token'], 'SSL');
		$data['download'] = $this->url->link('tool/robots/download', 'token=' . $this->session->data['token'], 'SSL');
		$data['clear'] = $this->url->link('tool/robots/clear', 'token=' . $this->session->data['token'], 'SSL');

		$data['robots'] = '';
        
		$file = str_replace('image/', '', DIR_IMAGE) . 'robots.txt';
        
		if (file_exists($file)) {
			$size = filesize($file);

			if ($size >= 5242880) {
				$suffix = array(
					'B',
					'KB',
					'MB',
					'GB',
					'TB',
					'PB',
					'EB',
					'ZB',
					'YB'
				);

				$i = 0;

				while (($size / 1024) > 1) {
					$size = $size / 1024;
					$i++;
				}
				$data['error_warning'] = sprintf($this->language->get('error_warning'), basename($file), round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]);
			} else {
				$data['robots'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
			}
		}
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('tool/robots.tpl', $data));
	}

    public function save() {
        $this->load->language('tool/robots');
        
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $file = str_replace('image/', '', DIR_IMAGE) . 'robots.txt';
            $current = $this->request->post;
            $content = htmlspecialchars_decode($current['robots']);
            file_put_contents($file, $content);

            $this->session->data['success'] = $this->language->get('text_success_save');
            $this->response->redirect($this->url->link('tool/robots', 'token=' . $this->session->data['token'], 'SSL'));
        }
	}
    
	public function download() {
		$this->response->addheader('Pragma: public');
		$this->response->addheader('Expires: 0');
		$this->response->addheader('Content-Description: File Transfer');
		$this->response->addheader('Content-Type: application/octet-stream');
		$this->response->addheader('Content-Disposition: attachment; filename=robots.txt');
		$this->response->addheader('Content-Transfer-Encoding: binary');

		$this->response->setOutput(file_get_contents(str_replace('image/', '', DIR_IMAGE) . 'robots.txt', FILE_USE_INCLUDE_PATH, null));
	}
	
	public function clear() {
		$this->load->language('tool/robots');

		if (!$this->user->hasPermission('modify', 'tool/robots')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} else {
			$file = str_replace('image/', '', DIR_IMAGE) . 'robots.txt';

			$handle = fopen($file, 'w+');

			fclose($handle);

			$this->session->data['success'] = $this->language->get('text_success_clear');
		}

		$this->response->redirect($this->url->link('tool/robots', 'token=' . $this->session->data['token'], 'SSL'));
	}
 
    public function upload() {
		$this->load->language('extension/installer');
		$this->load->language('tool/robots');

		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'tool/robots')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			if (!empty($this->request->files['file']['name'])) {
				if (substr($this->request->files['file']['name'], -4) != '.txt') {
					$json['error'] = $this->language->get('error_filetype');
				} 

				if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
					//$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
                    $json['error'] = $this->language->get('error_upload');
				}
			} else {
				$json['error'] = $this->language->get('error_upload');
			}
		}
        
        if (!$json) {
           $filename = html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8');
           $file = $filename;
                
			move_uploaded_file($this->request->files['file']['tmp_name'], DIR_UPLOAD . $file);
            
            $upload_info =  file_get_contents(DIR_UPLOAD . $file, FILE_USE_INCLUDE_PATH, null);
            
            if ($upload_info && is_file(DIR_UPLOAD . $file)) {
				unlink(DIR_UPLOAD . $file);
            }
            
            $json['robots'] = iconv('UTF-8', 'ISO-8859-1//IGNORE', $upload_info);
            $json['success'] = $this->language->get('success_upload');
            
        }

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

}
