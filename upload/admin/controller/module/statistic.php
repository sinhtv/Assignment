<?php
class ControllerModuleStatistic extends Controller {
	private $error = array();
 
	public function index() {
		if(!file_exists($this->online)) file_put_contents(DIR_SYSTEM.'../counter/ds_online.txt','');
		if(!file_exists($this->data)) file_put_contents(DIR_SYSTEM.'../counter/ds_data.txt','');
		$this->load->language('module/statistic');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('statistic', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
			$dt = unserialize(file_get_contents(DIR_SYSTEM.'../counter/ds_data.txt'));
			$dt['01/01/1900'] = $this->request->post['total'];
			$this->writefile(DIR_SYSTEM.'../counter/ds_data.txt','w',serialize($dt));

			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$text = array('heading_title','text_edit','text_enabled','text_disabled','entry_name', 'entry_online_view', 'entry_today_view', 'entry_lastmonth_view'
			, 'entry_yesterday_view', 'entry_total_view', 'entry_total','entry_status', 'button_cancel', 'button_save');
		foreach($text as $t)
			$data[$t] = $this->language->get($t);

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
		if (isset($this->error['total'])) {
			$data['error_total'] = $this->error['total'];
		} else {
			$data['error_total'] = '';
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

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/statistic', 'token=' . $this->session->data['token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/statistic', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/statistic', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('module/statistic', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}

		$info = array('name', 'today_view', 'online_view', 'yesterday_view', 'lastmonth_view', 'total_view', 'total', 'status');
		foreach ($info as $i) {
			if (isset($this->request->post[$i])) {
				$data[$i] = $this->request->post[$i];
			} elseif (!empty($module_info)) {
				$data[$i] = $module_info[$i];
			} else {
				$data[$i] = '';
				if(in_array($i,array('today_view', 'online_view', 'yesterday_view', 'lastmonth_view', 'total_view', 'status'))) $data[$i] = 1;
				if($i=='total') $data[$i] = 0;
			}
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/statistic.tpl', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/statistic')) {
			$this->error['warning'] = $this->language->get('error_permission');
			$this->session->data['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function writefile($name, $type, $value){
		$handle = fopen($name, $type);
		fwrite($handle, $value);
		fclose($handle);
	}
}
?>