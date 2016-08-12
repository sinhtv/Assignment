<?php
	class ModelToolHelper extends Model {
		public function limitWord( $str, $limit = 20 ){
			$str = strip_tags(html_entity_decode($str, ENT_QUOTES, 'UTF-8'));
			$temp = explode(' ', $str);
			$string = '';
			for($j=0; $j<$limit && $j < count($temp); $j++){
				$string = $string.$temp[$j].' ';
			}
			if ($limit<count($temp))
				$string = $string.'...';
			return $string;
		}
	}

?>