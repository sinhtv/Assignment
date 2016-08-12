<?php
class ControllerModuleListnews extends Controller {
	public function index() {
		$this->load->language('module/listnews');

		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['id'])) {
			$parts = explode('_', (string)$this->request->get['id']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['listnews_id'] = $parts[0];
		} else {
			$data['listnews_id'] = 0;
		}

		$this->load->model('module/listnews');


		$this->load->model('extension/module');
 		$lastest_listnews = $this->model_extension_module->getModulesByCode('listnews');
 		$setting_listnews = json_decode($lastest_listnews[0]['setting']);
 		$data['module_title'] = $lastest_listnews[0]['name'];
		$listnews = $this->model_module_listnews->getAllListNews(array('start'=>0,'limit'=>$setting_listnews->limit));
		foreach ($listnews as $n) {
			$data['listnews'][] = array(
				'listnews_id' 		=> $n['id'],
				'name'       	=> $n['title'],
				'parent_id'     => $n['parent_id'],
				'href'        	=> $this->url->link('news/listnews', 'id=' . $n['id'])
			);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/listnews.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/listnews.tpl', $data);
		} else {
			return $this->load->view('default/template/module/listnews.tpl', $data);
		}
	}

}