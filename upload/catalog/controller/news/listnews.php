<?php
class ControllerNewsListnews extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('news/news');
		$this->load->model('module/listnews');
		$this->load->model('module/news');

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['id'])) {
			$listnews_id = (int)$this->request->get['id'];
		} else {
			$listnews_id = 0;
		}
		
		$listnews_info = $this->model_module_listnews->getListNews($listnews_id);
		if ($listnews_id) {

			$data['breadcrumbs'][] = array(
				'text' => $listnews_info['title'],
				'href' => $this->url->link('news/listnews', '&id=' . $this->request->get['id'])
			);

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

			$data['page'] = $page;
			$data['limit'] = $this->config->get('config_product_limit');
			$data['start'] = $this->config->get('config_product_limit') * ($page - 1);
			$data['cat_id'] = $listnews_id;
			$news = $this->model_module_news->getAllNewsByList($data);
			$data['news'] = array();
			foreach ($news as $n) {
				$data['news'][] = array(
					'news_id' 		=> $n['id'],
					'title'       	=> $n['title'],
					'image'       	=> $n['image'],
					'brief'       	=> $n['brief'],
					'posted_date'    => $n['posted_date'],
					'hits'    => $n['hits'],
					'href'        	=> $this->url->link('news/news', 'id=' . $n['id'])
				);
			}

			$total = $this->model_module_news->countNewsByList($listnews_id);

			$pagination = new Pagination();
			$pagination->total = $total;
			$pagination->page = $page;
			$pagination->limit = $this->config->get('config_product_limit');
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('news/listnews', 'id=' . $this->request->get['id'] . $url . '&page={page}', 'SSL');
	 		
			$data['pagination'] = $pagination->render();

			// Page
			$this->document->setTitle($listnews_info['title']);
			$data['metaDescription'] = addslashes(substr(strip_tags(html_entity_decode($listnews_info['description'])), 0, 160));
			$this->document->setDescription($data['metaDescription']);
			$this->document->setKeywords($listnews_info['keyword']);
			$this->document->addLink($this->url->link('news/listnews', 'id=' . $this->request->get['id']), 'canonical');
			$data['heading_title'] = $listnews_info['title'];
			$data['url'] = $this->url->link('news/listnews', 'id=' . $this->request->get['id']);

			$this->load->model('tool/image');

			if ($listnews_info['image']) {
				if ($this->request->server['HTTPS']) {
					$data['image'] =  $this->config->get('config_ssl') . 'image/' . $listnews_info['image'];
				} else {
					$data['image'] =  $this->config->get('config_url') . 'image/' . $listnews_info['image'];
				}
				$data['thumb'] = $this->model_tool_image->resize($listnews_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
			} else {
				$data['thumb'] = '';
				$data['image'] = '';
			}
			$data['parent_id'] = $listnews_info['parent_id'];
			$data['ord'] = $listnews_info['ord'];
			$data['description'] = html_entity_decode($listnews_info['description']);


			$text = array('text_published_at','text_on','text_views');
			foreach($text as $t)
 				$data[$t] =  $this->language->get($t);

			$controller = array('column_left','column_right','content_top','content_bottom','footer','header');
			foreach($controller as $c) 
				$data[$c] = $this->load->controller("common/$c");

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/listnews.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/news/listnews.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/news/listnews.tpl', $data));
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
