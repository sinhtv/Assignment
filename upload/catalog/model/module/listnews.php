<?php
class ModelModuleListnews extends Model {
	public function getAllListNews($data) {
		$sql = "SELECT n.*, nd.* 
		FROM " . DB_PREFIX . "listnews n 
		LEFT JOIN " . DB_PREFIX . "listnews_description nd 
		ON n.id = nd.listnews_id 
		WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
		ORDER BY ord ASC, n.id DESC";
 
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
 
	public function getListNews($id) {
		$sql = "SELECT n.*, nd.*, u.keyword
		FROM " . DB_PREFIX . "listnews n 
		LEFT JOIN " . DB_PREFIX . "listnews_description nd ON n.id = nd.listnews_id 
		LEFT JOIN " . DB_PREFIX . "url_alias u ON u.query = 'listnews_id=" . (int)$id . "'
		WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.id = $id";

		$query = $this->db->query($sql);
 
		return $query->row;
	}
 
	public function getListNewsDescription($id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "listnews_description WHERE listnews_id = '" . (int)$id . "'");
 
		foreach ($query->rows as $result) {
			$listnews_description[$result['language_id']] = array(
				'title'       => $result['title'],
				'description' => $result['description']
			);
		}
 
		return $listnews_description;
	}
	public function countListNews() {
		$count = $this->db->query("SELECT * FROM " . DB_PREFIX . "listnews");
		return $count->num_rows;
	}

}
?>