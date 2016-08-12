<?php
class ControllerModuleListnews extends Controller {
	private $error = array();
 
	public function install() {
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "listnews` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `parent_id` int(11) NOT NULL,
		  `image` varchar(200) NOT NULL,
		  `special` tinyint(1) DEFAULT NULL,
		  `active` tinyint(1) DEFAULT NULL,
		  `ord` smallint(6) DEFAULT NULL,
		  PRIMARY KEY (`id`),
		  KEY `active` (`active`)
		)");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "listnews_description` (
		  `listnews_description_id` int(11) NOT NULL AUTO_INCREMENT,
		  `listnews_id` int(11) NOT NULL,
		  `language_id` int(11) NOT NULL,
		  `title` varchar(255) COLLATE utf8_bin NOT NULL,
		  `description` text COLLATE utf8_bin NOT NULL,
		  PRIMARY KEY (`listnews_description_id`)
		)");
	}
 
 	/**
 	 * List News mangager
 	 */
	public function index() {
		$this->load->language('module/listnews');
		$this->load->model('module/listnews');
		
		$this->document->setTitle($this->language->get('heading_title'));

		/**
		 * Phân trang trước
		 */
		$url = '';
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
			$url .= '&page=' . $this->request->get['page'];
		} else {
			$page = 1;
		}
 		$data = array(
			'page' => $page,
			'limit' => $this->config->get('config_limit_admin'),
			'start' => $this->config->get('config_limit_admin') * ($page - 1),
		);

 
		$total = $this->model_module_listnews->countListNews();
 
		$pagination = new Pagination();
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/listnews', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
 		$data['results'] = sprintf($this->language->get('text_pagination'), ($total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($total - $this->config->get('config_limit_admin'))) ? $total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $total, ceil($total / $this->config->get('config_limit_admin')));
 		
		$data['pagination'] = $pagination->render();

 		/**
 		 * Breadcrumb
 		 */
		$data['breadcrumbs'] = array();
 
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
 
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/listnews', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
 
 		/**
 		 * Thông báo
 		 */
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
 
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
 
		if (isset($this->session->data['warning'])) {
			$data['error'] = $this->session->data['warning'];
 
			unset($this->session->data['warning']);
		} else {
			$data['error'] = '';
		}
 
		
 		/**
 		 * Texts
 		 */
		$data['heading_title'] = $this->language->get('heading_title');
 		$text = array('text_list','text_parent','text_image','text_no_results','text_title','text_order','text_active','text_action','text_edit', 
 			'text_confirm','button_layout','button_add','button_delete');
 		foreach($text as $t)
 			$data[$t] =  $this->language->get($t);
 
		
 		/**
 		 * Buttons
 		 */
 		$this->load->model('extension/module');
 		$lastest_listnews = $this->model_extension_module->getModulesByCode('listnews');
 		$data['layout'] = $this->url->link('module/listnews/layout', '&token=' . $this->session->data['token'] . ($lastest_listnews? '&id=' . $lastest_listnews[0]['module_id']:''), 'SSL');
 		$data['insert'] = $this->url->link('module/listnews/insert', '&token=' . $this->session->data['token'], 'SSL');
		$data['delete'] = $this->url->link('module/listnews/delete', 'token=' . $this->session->data['token'], 'SSL');
 
 		/**
 		 * Generate list news
 		 */
		$data['listnews'] = array();
		$this->load->model('tool/image');           
		$listnews = $this->model_module_listnews->getAllListNews($data);
		foreach ($listnews as $n) {
			 if (is_file(DIR_IMAGE . $n['image'])) {
              $thumb = $this->model_tool_image->resize($n['image'], 100, 100);
            } else {
              $thumb = $this->model_tool_image->resize('no_image.png', 100, 100);
            }

            $parent = $this->language->get('text_none');
            foreach ($listnews as $n2) {
            	if($n2['id']==$n['parent_id']) $parent = $n2['title'];
            }
			$data['listnews'][] = array (
				'id' => $n['id'],
				'title' => $n['title'],
				'thumb' => $thumb,
				'parent_id' => $n['parent_id'],
				'parent' => $parent,
				'ord' => $n['ord'],
				'active' => ($n['active']?$this->language->get('text_yes'):$this->language->get('text_no')),
				'edit' => $this->url->link('module/listnews/edit', '&id=' . $n['id'] . '&token=' . $this->session->data['token'], 'SSL')
			);
		}

		/**
		 * render
		 */
 		$data['header'] = $this->load->controller('common/header');
        $data['footer'] = $this->load->controller('common/footer');
        $data['column_left'] = $this->load->controller('common/column_left');
        $this->response->setOutput($this->load->view('module/listnews.tpl', $data));
	}
 
	/**
	 * Form
	 * @return [type] [description]
	 */
	private function form($data) {
		$this->load->language('module/listnews');
		$this->load->model('module/listnews');
		
		$data['heading_title'] = $this->language->get('heading_title');
   		

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		foreach ($data['languages'] as $language){
			if (isset($this->error['title'][$language['language_id']])) {
				$data['error_title'][$language['language_id']] = $this->error['title'][$language['language_id']];
			} else {
				$data['error_title'][$language['language_id']] = '';
			}
		}

   		/**
 		 * Texts
 		 */
		$data['heading_title'] = $this->language->get('heading_title');
 		$text = array('text_form','text_parent','text_title','text_description', 'text_image','text_keyword', 'text_active','text_enabled','text_disabled',
 			'button_save','button_cancel','text_yes','text_no','text_description','text_order','text_none','entry_keyword','help_keyword');
 		foreach($text as $t)
 			$data[$t] =  $this->language->get($t);
 
		
		if (isset($this->request->get['id'])) {
			$listnews = $this->model_module_listnews->getListNews($this->request->get['id']);
		} else {
			$listnews = '';
		}
 
		if (isset($this->request->post['listnews'])) {
			$data['listnews'] = $this->request->post['listnews'];
		} elseif (!empty($listnews)) {
			$data['listnews'] = $this->model_module_listnews->getListNewsDescription($this->request->get['id']);
		} else {
			$data['listnews'] = '';
		}
 
		$keys = array('image','special','active','ord','parent_id','keyword');
		foreach($keys as $k):
			if (isset($this->request->post[$k])) {
				$data[$k] = $this->request->post[$k];
			} elseif (!empty($listnews) && isset($listnews[$k])) {
				$data[$k] = $listnews[$k];
			} else {
				$data[$k] = '';
				if($k=='special') $data[$k] = 0;
				if($k=='active') $data[$k] = 1;
				if($k=='ord') $data[$k] = 0;
			}
		endforeach;

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($listnews) && is_file(DIR_IMAGE . $listnews['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($listnews['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
 
		if (isset($this->request->post['listnews_description'])) {
			$data['listnews_description'] = $this->request->post['listnews_description'];
		} elseif (isset($this->request->get['id'])) {
			$data['listnews_description'] = $this->model_module_listnews->getListNewsDescription($this->request->get['id']);
		} else {
			$data['listnews_description'] = array();
		}

		if (isset($this->request->get['id'])) {
			$data['listnews_parent'] = $this->model_module_listnews->getParents($this->request->get['id']);
		} else {
			$data['listnews_parent'] = $this->model_module_listnews->getParents(null);
		}
 
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
 
		$this->response->setOutput($this->load->view('module/listnews_form.tpl',$data));
	}
 


	/**
	 * List News Edit
	 */
	public function edit() {
		$this->load->language('module/listnews');
		$this->load->model('module/listnews');
 		$this->load->model('localisation/language');
 
		$this->document->setTitle($this->language->get('heading_title'));
 
		if (isset($this->session->data['warning'])) {
			$data['error'] = $this->session->data['warning'];
 
			unset($this->session->data['warning']);
		} else {
			$data['error'] = '';
		}
 
		if (!isset($this->request->get['id'])) {
			$this->response->redirect($this->url->link('module/listnews', '&token=' . $this->session->data['token'], 'SSL'));
		}
 
		$data['languages'] = $this->model_localisation_language->getLanguages();
 		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
 			$post = $this->request->post; $flag = true;
			foreach ($data['languages'] as $language)
			if(!$this->db->escape($post['listnews_description'][$language['language_id']]['title'])) {
				$flag = false;
				$this->error['title'][$language['language_id']] = 'Title cannot be empty';
			} 
			if($flag){
				$this->model_module_listnews->editListNews($this->request->get['id'], $this->request->post);
	 
				$this->session->data['success'] = $this->language->get('text_success');
	 
				$this->response->redirect($this->url->link('module/listnews', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}
 
		$data['breadcrumbs'] = array();
 
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
 
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/listnews', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
 
		$data['action'] = $this->url->link('module/listnews/edit', '&id=' . $this->request->get['id'] . '&token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('module/listnews', '&token=' . $this->session->data['token'], 'SSL');
		$data['token'] = $this->session->data['token'];
 
		$this->form($data);
	}
 
 	/**
 	 * News insert
 	 */
	public function insert($data) {
		$this->load->language('module/listnews');
		$this->load->model('module/listnews');
 		$this->load->model('localisation/language');
 
		$this->document->setTitle($this->language->get('heading_title'));
 
		if (isset($this->session->data['warning'])) {
			$data['error'] = $this->session->data['warning'];
 
			unset($this->session->data['warning']);
		} else {
			$data['error'] = '';
		}
 
		$data['languages'] = $this->model_localisation_language->getLanguages();
 		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$post = $this->request->post; $flag = true;
			foreach ($data['languages'] as $language)
			if(!$this->db->escape($post['listnews_description'][$language['language_id']]['title'])) {
				$flag = false;
				$this->error['title'][$language['language_id']] = 'Title cannot be empty';
			} 
			if($flag){
				$this->model_module_listnews->addListNews($this->request->post);
	 
				$this->session->data['success'] = $this->language->get('text_insert_success');
	 
				$this->response->redirect($this->url->link('module/listnews', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}
 
		$data['breadcrumbs'] = array();
 
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
 
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/listnews', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
 
		$data['action'] = $this->url->link('module/listnews/insert', '&token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('module/listnews', '&token=' . $this->session->data['token'], 'SSL');
		$data['token'] = $this->session->data['token'];
 
		$this->form($data);
	}
 

	/**
	 * News Delete
	 */
	public function delete() {
		$this->load->language('module/listnews');
		$this->load->model('module/listnews');
 
		$this->document->setTitle($this->language->get('heading_title'));
 
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_module_listnews->deleteListNews($id);
			}
 
			$this->session->data['success'] = $this->language->get('text_success');
		}
 
		$this->response->redirect($this->url->link('module/listnews', 'token=' . $this->session->data['token'], 'SSL'));
	}
 
	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'module/listnews')) {
			$this->error['warning'] = $this->language->get('error_permission');
 
			$this->session->data['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
 
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/listnews')) {
			$this->error['warning'] = $this->language->get('error_permission');
			$this->session->data['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}


	public function layout() {
		$this->load->language('module/listnews');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['id'])) {
				$this->model_extension_module->addModule('listnews', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}

		if (isset($this->error['limit'])) {
			$data['error_limit'] = $this->error['limit'];
		} else {
			$data['error_limit'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		if (!isset($this->request->get['id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/listnews', 'token=' . $this->session->data['token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/listnews', 'token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'], 'SSL')
			);
		}

		if (!isset($this->request->get['id'])) {
			$data['action'] = $this->url->link('module/listnews/layout', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('module/listnews/layout', 'token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'], 'SSL');
		}

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info)) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = '';
		}

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($module_info)) {
			$data['width'] = $module_info['width'];
		} else {
			$data['width'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/listnews_layout.tpl', $data));
	}
}
?>