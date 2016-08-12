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

	public function addListNews($data) {
		/**
		 * Khởi tạo giá trị
		 */
		$key = array(
			'image' => 1,
			'thumb' => 1,
			'special' => 0,
			'active' => 0,
			'ord' => 0,
			'parent_id' => 0,
		);
		$values = '';
		foreach($key as $k=>$v):
			if(isset($data[$k])){
				if($v) $values .= ", $k = '".$this->db->escape($data[$k])."'";
				else $values .= ", $k = '".(int)$data[$k]."'";
			}
		endforeach;

		$this->db->query("INSERT INTO " . DB_PREFIX . "listnews SET special = 0 $values");
 
		$id = $this->db->getLastId();
 
 		/**
 		 * Them tieu de va mo ta
 		 */
		foreach ($data['listnews_description'] as $key => $value) {
			$this->db->query("
				INSERT INTO " . DB_PREFIX ."listnews_description 
				SET 
					listnews_id = '" . (int)$id . "', 
					language_id = '" . (int)$key . "', 
					title = '" . $this->db->escape($value['title']) . "', 
					description = '" . $this->db->escape($value['description']) . "'
			");
		}
 
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'listnews_id=" . (int)$id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
	}
 
	public function editListNews($id, $data) {
		$key = array(
			'image' => 1,
			'thumb' => 1,
			'special' => 0,
			'active' => 0,
			'ord' => 0,
			'parent_id' => 0,
		);
		$values = '';
		foreach($key as $k=>$v):
			if(isset($data[$k])){
				if($v) $values .= ", $k = '".$this->db->escape($data[$k])."'";
				else $values .= ", $k = '".(int)$data[$k]."'";
			}
		endforeach;
		$this->db->query("UPDATE " . DB_PREFIX . "listnews SET $values WHERE id = '" . (int)$id . "'");
 
		$this->db->query("DELETE FROM " . DB_PREFIX . "listnews_description WHERE listnews_id = '" . (int)$id. "'");
 
		foreach ($data['listnews_description'] as $key => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX ."listnews_description 
				SET listnews_id = '" . (int)$id . "', 
				language_id = '" . (int)$key . "', 
				title = '" . $this->db->escape($value['title']) . "', 
				description = '" . $this->db->escape($value['description']) . "'");
		}
 
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'listnews_id=" . (int)$id. "'");
 
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'listnews_id=" . (int)$id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
	}
 
	public function getListNews($id) {
		$query = $this->db->query("SELECT DISTINCT *, 
			( SELECT keyword 
			FROM " . DB_PREFIX . "url_alias 
			WHERE query = 'listnews_id=" . (int)$id . "') AS keyword 
			FROM " . DB_PREFIX . "listnews 
			WHERE id = '" . (int)$id . "'
		");
 
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
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
 
	
 
	public function deleteListNews($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "listnews WHERE id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "listnews_description WHERE listnews_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'listnews_id=" . (int)$id. "'");
	}
 
	public function countListNews() {
		$count = $this->db->query("SELECT * FROM " . DB_PREFIX . "listnews");
 
		return $count->num_rows;
	}

	public function getParents($id){
		if($id) $con = 'AND id != '.$id; else $con = '';

		$sql = "SELECT n.*, nd.* 
		FROM " . DB_PREFIX . "listnews n 
		LEFT JOIN " . DB_PREFIX . "listnews_description nd 
		ON n.id = nd.listnews_id 
		WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' $con
		ORDER BY ord ASC, n.id DESC";
 
		$query = $this->db->query($sql);
 
		return $query->rows;
	}

	
}
?>