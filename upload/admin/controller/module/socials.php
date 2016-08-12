<?php
class ControllerModuleSocials extends Controller {
	private $error = array();
 
 	/**
 	 * List News mangager
 	 */
	public function index() {
		$this->load->language('module/socials');
		$this->load->model('extension/module');
		$this->document->setTitle($this->language->get('heading_title'));

		// Save information
		if ( ($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() ) 
		{
			if (! isset($this->request->get['facebook_id']) ) 
			{
				$this->model_extension_module->addModule('socials', $this->request->post['social_facebook'] );
			} 
			else 
			{
				$this->model_extension_module->editModule($this->request->get['facebook_id'], $this->request->post['social_facebook']);
			}

			if (! isset($this->request->get['google_id']) ) 
			{
				$this->model_extension_module->addModule('socials', $this->request->post['social_google'] );
			} 
			else 
			{
				$this->model_extension_module->editModule($this->request->get['google_id'], $this->request->post['social_google']);
			}

			$this->session->data['success'] = $this->language->get('text_success');
		}

		// Initial information
		if ( isset($this->request->get['facebook_id']) ) {
			$facebook_info = array(
				'module_id' => $this->request->get['facebook_id'],
				'setting' => $this->model_extension_module->getModule($this->request->get['facebook_id'])
			);
		}
		if ( isset($this->request->get['google_id']) ) {
			$google_info = array(
				'module_id' => $this->request->get['google_id'],
				'setting' => $this->model_extension_module->getModule($this->request->get['google_id'])
			);
		}

		if( empty($facebook_info) && empty($google_info) )
		{
			$socials = $this->model_extension_module->getModulesByCode('socials');
	 		foreach ($socials as $row) {
	 			if( empty($facebook_info) && $row['name'] == 'Facebook Page' )
	 			{
	 				$facebook_info = $row;
	 			}
	 			if( empty($google_info) && $row['name'] == 'Google Plus' )
	 			{
	 				$google_info = $row;
	 			}
	 		}
		}

 		if ( 
 			empty($this->request->get['facebook_id']) 
 			&& empty($this->request->get['google_id']) 
 			&& !empty($facebook_info)
 			&& !empty($google_info)
 		)
 		{
 			$this->response->redirect(
 				$this->url->link('module/socials', 'token=' . $this->session->data['token']
				. (! empty($facebook_info) ? '&facebook_id=' . $facebook_info['module_id'] : '' )
 				. (! empty($google_info) ? '&google_id=' . $google_info['module_id'] : '' ), 'SSL')
 			);
 		}

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
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/socials', 'token=' . $this->session->data['token']
				. (! empty($facebook_info) ? '&facebook_id=' . $facebook_info['module_id'] : '' )
 				. (! empty($google_info) ? '&google_id=' . $google_info['module_id'] : '' ), 'SSL'),
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
 		$text = array('text_form','text_facebook_page','text_google_page','text_action','text_edit', 'text_facebook_appId', 'text_facebook_width', 'text_facebook_height',
 			'text_confirm','button_save','button_cancle');
 		foreach($text as $t)
 		{
 			$data[$t] =  $this->language->get($t);
 		}

		
 		/**
 		 * Buttons
 		 */
 		$this->load->model('extension/module');


 		
 		$data['action'] = $this->url->link('module/socials', 
 			'&token=' . $this->session->data['token']
 			. (! empty($facebook_info) ? '&facebook_id=' . $facebook_info['module_id'] : '' )
 			. (! empty($google_info) ? '&google_id=' . $google_info['module_id'] : '' )
 			, 'SSL');
		$data['cancel'] = $this->url->link('extension/module', '&token=' . $this->session->data['token'], 'SSL');
		$data['token'] = $this->session->data['token'];


		
		// Facebook
		if (isset($this->request->post['social_facebook']['name'])) {
			$data['social_facebook']['name'] = $this->request->post['social_facebook']['name'];
		} elseif (!empty($facebook_info['name'])) {
			$data['social_facebook']['name'] = $facebook_info['name'];
		} else {
			$data['social_facebook']['name'] = 'Facebook Page';
		}
		if (isset($this->request->post['social_facebook']['page_url'])) {
			$data['social_facebook']['page_url'] = $this->request->post['social_facebook']['page_url'];
		} elseif (!empty($facebook_info['setting']['page_url'])) {
			$data['social_facebook']['page_url'] = $facebook_info['setting']['page_url'];
		} else {
			$data['social_facebook']['page_url'] = '';
		}
		if (isset($this->request->post['social_facebook']['appId'])) {
			$data['social_facebook']['appId'] = $this->request->post['social_facebook']['appId'];
		} elseif (!empty($facebook_info['setting']['appId'])) {
			$data['social_facebook']['appId'] = $facebook_info['setting']['appId'];
		} else {
			$data['social_facebook']['appId'] = '';
		}
		if (isset($this->request->post['social_facebook']['width'])) {
			$data['social_facebook']['width'] = $this->request->post['social_facebook']['width'];
		} elseif (!empty($facebook_info['setting']['width'])) {
			$data['social_facebook']['width'] = $facebook_info['setting']['width'];
		} else {
			$data['social_facebook']['width'] = '';
		}
		if (isset($this->request->post['social_facebook']['height'])) {
			$data['social_facebook']['height'] = $this->request->post['social_facebook']['height'];
		} elseif (!empty($facebook_info['setting']['height'])) {
			$data['social_facebook']['height'] = $facebook_info['setting']['height'];
		} else {
			$data['social_facebook']['height'] = '';
		}
		if (isset($this->request->post['social_facebook']['status'])) {
			$data['social_facebook']['status'] = $this->request->post['social_facebook']['status'];
		} elseif (!empty($facebook_info['setting']['status'])) {
			$data['social_facebook']['status'] = $facebook_info['setting']['status'];
		} else {
			$data['social_facebook']['status'] = '1';
		}


		// Google
		if (isset($this->request->post['social_google']['name'])) {
			$data['social_google']['name'] = $this->request->post['social_google']['name'];
		} elseif (!empty($google_info['name'])) {
			$data['social_google']['name'] = $google_info['name'];
		} else {
			$data['social_google']['name'] = 'Google Plus';
		}
		if (isset($this->request->post['social_google']['page_url'])) {
			$data['social_google']['page_url'] = $this->request->post['social_google']['page_url'];
		} elseif (!empty($google_info['setting']['page_url'])) {
			$data['social_google']['page_url'] = $google_info['setting']['page_url'];
		} else {
			$data['social_google']['page_url'] = '';
		}
		if (isset($this->request->post['social_google']['width'])) {
			$data['social_google']['width'] = $this->request->post['social_google']['width'];
		} elseif (!empty($google_info['setting']['width'])) {
			$data['social_google']['width'] = $google_info['setting']['width'];
		} else {
			$data['social_google']['width'] = '';
		}
		if (isset($this->request->post['social_google']['status'])) {
			$data['social_google']['status'] = $this->request->post['social_google']['status'];
		} elseif (!empty($google_info['setting']['status'])) {
			$data['social_google']['status'] = $google_info['setting']['status'];
		} else {
			$data['social_google']['status'] = '1';
		}

		/**
		 * render
		 */
 		$data['header'] = $this->load->controller('common/header');
        $data['footer'] = $this->load->controller('common/footer');
        $data['column_left'] = $this->load->controller('common/column_left');
        $this->response->setOutput($this->load->view('module/socials.tpl', $data));
	}
 
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/socials')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
?>