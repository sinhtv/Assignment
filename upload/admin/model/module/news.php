<?php
class ModelModuleNews extends Model {
	public function getAllNews($data) {
		$sql = "SELECT n.*, nd.* 
		FROM " . DB_PREFIX . "news n 
		LEFT JOIN " . DB_PREFIX . "news_description nd 
		ON n.id = nd.news_id 
		WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
		ORDER BY posted_date DESC";
 
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
				if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
 
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
 
		$query = $this->db->query($sql);
 
		return $query->rows;
	}

	public function addNews($data) {
		/**
		 * Khởi tạo giá trị
		 */
		$key = array(
			'image' => 1,
			'thumb' => 1,
			'hot' => 0,
			'home' => 0,
			'active' => 0,
			'hits' => 0,
			'cat_id' => 0,
		);
		$values = '';
		foreach($key as $k=>$v):
			if(isset($data[$k])){
				if($v) $values .= ", $k = '".$this->db->escape($data[$k])."'";
				else $values .= ", $k = '".(int)$data[$k]."'";
			}
		endforeach;

		$this->db->query("INSERT INTO " . DB_PREFIX . "news SET posted_date = NOW() $values");
 
		$id = $this->db->getLastId();
 
 		/**
 		 * Them tieu de va mo ta
 		 */
		foreach ($data['news_description'] as $key => $value) {
			$this->db->query("
				INSERT INTO " . DB_PREFIX ."news_description 
				SET 
					news_id = '" . (int)$id . "', 
					language_id = '" . (int)$key . "', 
					title = '" . $this->db->escape($value['title']) . "', 
					brief = '" . $this->db->escape($value['brief']) . "', 
					description = '" . $this->db->escape($value['description']) . "'
			");
		}
 
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
	}
 
	public function editNews($id, $data) {
		$key = array(
			'image' => 1,
			'thumb' => 1,
			'hot' => 0,
			'home' => 0,
			'active' => 0,
			'hits' => 0,
			'cat_id' => 0,
		);
		$values = '';
		foreach($key as $k=>$v):
			if(isset($data[$k])){
				if($v) $values .= ($values?',':'')." $k = '".$this->db->escape($data[$k])."'";
				else $values .= ($values?',':'')." $k = '".(int)$data[$k]."'";
			}
		endforeach;

		if( preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}$/",$data['posted_date'])){
			$tmp = explode('/',$data['posted_date']);
			$values .=  ", posted_date = '{$tmp[2]}-{$tmp[1]}-{$tmp[0]} 00:00:00'";
		} else $model->create_at = ", posted_date = '0000-00-00 00:00:00'";

		$this->db->query("UPDATE " . DB_PREFIX . "news SET $values WHERE id = '" . (int)$id . "'");
 
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$id. "'");
 
		foreach ($data['news_description'] as $key => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX ."news_description 
				SET news_id = '" . (int)$id . "', 
				language_id = '" . (int)$key . "', 
				title = '" . $this->db->escape($value['title']) . "', 
				brief = '" . $this->db->escape($value['brief']) . "', 
				description = '" . $this->db->escape($value['description']) . "'");
		}
 
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$id. "'");
 
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
	}
 
	public function getNews($id) {
		$query = $this->db->query("SELECT DISTINCT *, 
			( SELECT keyword 
			FROM " . DB_PREFIX . "url_alias 
			WHERE query = 'news_id=" . (int)$id . "') AS keyword 
			FROM " . DB_PREFIX . "news 
			WHERE id = '" . (int)$id . "'
		");
 
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}
 
	public function getNewsDescription($id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$id . "'");
 
		foreach ($query->rows as $result) {
			$news_description[$result['language_id']] = array(
				'title'       => $result['title'],
				'brief' => $result['brief'],
				'description' => $result['description']
			);
		}
 
		return $news_description;
	}
 
	
 
	public function deleteNews($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "news WHERE id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$id. "'");
	}
 
	public function countNews() {
		$count = $this->db->query("SELECT * FROM " . DB_PREFIX . "news");
 
		return $count->num_rows;
	}
}
?>