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


 
	public function getNews($id) {
		$sql = "SELECT n.*, nd.*, u.keyword
		FROM " . DB_PREFIX . "news n 
		LEFT JOIN " . DB_PREFIX . "news_description nd ON n.id = nd.news_id 
		LEFT JOIN " . DB_PREFIX . "url_alias u ON u.query = 'news_id=" . (int)$id . "'
		WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.id = $id";

		$query = $this->db->query($sql);
 
		return $query->row;
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

 
	public function countNews() {
		$count = $this->db->query("SELECT * FROM " . DB_PREFIX . "news");
 
		return $count->num_rows;
	}
	public function countNewsByList($cat_id) {
		$count = $this->db->query("SELECT * FROM " . DB_PREFIX . "news WHERE cat_id = $cat_id ");
 
		return $count->num_rows;
	}

	public function updateViewed($id){
		$this->db->query("UPDATE " . DB_PREFIX . "news SET hits = (hits + 1) WHERE id = '" . (int)$id . "'");
	}

	public function getAllNewsByList($data) {
		$sql = "SELECT n.*, nd.* 
		FROM " . DB_PREFIX . "news n 
		LEFT JOIN " . DB_PREFIX . "news_description nd 
		ON n.id = nd.news_id 
		WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.cat_id = ".$data['cat_id']."
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
}
?>