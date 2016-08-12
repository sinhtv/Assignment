<?php
class ControllerModuleNews extends Controller {
	public function index() {
		$this->load->language('module/news');

		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['id'])) {
			$parts = explode('_', (string)$this->request->get['id']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['news_id'] = $parts[0];
		} else {
			$data['news_id'] = 0;
		}

		$this->load->model('module/news');


		$this->load->model('tool/image');
		$this->load->model('extension/module');
		$this->load->model('tool/helper');

 		$lastest_news = $this->model_extension_module->getModulesByCode('news');
 		$setting_news = json_decode($lastest_news[0]['setting']);
 		$data['module_title'] = $lastest_news[0]['name'];
		$news = $this->model_module_news->getAllNews(array('start'=>0,'limit'=>$setting_news->limit));
		$data['news'] = array();
		foreach ($news as $n) {
			if ($n['image']) {
				$thumb = $this->model_tool_image->resizeAdaptive($n['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'), 'w');
			} else {
				$thumb = '';
			}
			$data['news'][] = array(
				'news_id' 		=> $n['id'],
				'name'       	=> $this->model_tool_helper->limitWord($n['title'], 6),
				'posted_date'   => $n['posted_date'],
				'thumb'       	=> $thumb,
				'href'        	=> $this->url->link('news/news', 'id=' . $n['id'])
			);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/news.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/news.tpl', $data);
		} else {
			return $this->load->view('default/template/module/news.tpl', $data);
		}
	}



}