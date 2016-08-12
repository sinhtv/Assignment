<?php
class ControllerNewsNews extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('news/news');
		$this->load->model('module/news');
		$this->load->model('module/listnews');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['id'])) {
			$news_id = (int)$this->request->get['id'];
		} else {
			$news_id = 0;
		}

		

		$news_info = $this->model_module_news->getNews($news_id);
		if ($news_id) {
			//Breadcrumb
			$listnews_info = $this->model_module_listnews->getListNews($news_info['cat_id']);
			if($listnews_info)
			$data['breadcrumbs'][] = array(
				'text' => $listnews_info['title'],
				'href' => $this->url->link('news/listnews', '&id=' . $listnews_info['id'])
			);

			$data['breadcrumbs'][] = array(
				'text' => $news_info['title'],
				'href' => $this->url->link('news/news', '&id=' . $this->request->get['id'])
			);

			$this->document->setTitle($news_info['title']);
			$data['metaDescription'] = addslashes(substr(strip_tags(html_entity_decode($news_info['description'])), 0, 160));
			$this->document->setDescription($data['metaDescription']);
			$this->document->setKeywords($news_info['keyword']);
			$this->document->addLink($this->url->link('news/news', 'id=' . $this->request->get['id']), 'canonical');
			$data['heading_title'] = $news_info['title'];
			$data['url'] = $this->url->link('news/news', 'id=' . $this->request->get['id']);

			$this->load->model('tool/image');

			if ($news_info['image']) {
				if ($this->request->server['HTTPS']) {
					$data['image'] =  $this->config->get('config_ssl') . 'image/' . $news_info['image'];
				} else {
					$data['image'] =  $this->config->get('config_url') . 'image/' . $news_info['image'];
				}
				$data['thumb'] = $this->model_tool_image->resize($news_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
			} else {
				$data['image'] = '';
				$data['thumb'] = '';
			}
			$data['cat_id'] = $news_info['cat_id'];
			$data['hits'] = $news_info['hits'];
			$data['posted_date'] = $news_info['posted_date'];
			$data['brief'] = $news_info['brief'];
			$data['description'] = html_entity_decode($news_info['description']);
			
			$text = array('text_published_at','text_on','text_views');
			foreach($text as $t)
 				$data[$t] =  $this->language->get($t);

			$this->model_module_news->updateViewed($this->request->get['id']);

			$controller = array('column_left','column_right','content_top','content_bottom','footer','header');
			foreach($controller as $c) 
				$data[$c] = $this->load->controller("common/$c");

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/news.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/news/news.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/news/news.tpl', $data));
			}
		} else {

			$this->document->setTitle($this->language->get('text_error'));
			$data['heading_title'] = $this->language->get('text_error');
			$data['text_error'] = $this->language->get('text_error');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$controller = array('column_left','column_right','content_top','content_bottom','footer','header');
			foreach($controller as $c) 
				$data[$c] = $this->load->controller("common/$c");

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}

}
