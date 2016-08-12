<?php
class ModelModuleStatistic extends Model {
	//==========================================================================================//
	//========================================== COUNTER =======================================//
	//==========================================================================================//
	private $online = 'counter/ds_online.txt';
	private $data = 'counter/ds_data.txt';
	public $ct	= '';
	public $cf	= array();

	public function visit(){ 	
		$cr = unserialize(file_get_contents($this->online));
		$dt = unserialize(file_get_contents($this->data));
		$flag = false;
		//Check if end session
		if($cr)
		while (current($cr)) {
			if($cr[key($cr)]<$this->ct) {
				if(isset($dt[date('d/m/Y',$cr[key($cr)])])) 
					$dt[date('d/m/Y',$cr[key($cr)])]++; 
				else 
					$dt[date('d/m/Y',$cr[key($cr)])]=9;
				unset($cr[key($cr)]); 
				$flag=true;	
			}
			next($cr);
		}
		//Làm mới session nếu thời gian online qua một mức nhất định (nếu sess chưa hết hạn)
		if(isset($cr[$_SERVER['REMOTE_ADDR'].' | '.$_SERVER['HTTP_USER_AGENT']]) && $cr[$_SERVER['REMOTE_ADDR'].' | '.$_SERVER['HTTP_USER_AGENT']]-$this->cf['cld']>$this->ct){ 
			$cr[$_SERVER['REMOTE_ADDR'].' | '.$_SERVER['HTTP_USER_AGENT']] = $this->ct + $this->cf['clo']; 
			$this->writefile($this->online,'w',serialize($cr)); 
		}
		else { 
			$cr[$_SERVER['REMOTE_ADDR'].' | '.$_SERVER['HTTP_USER_AGENT']] = $this->ct + $this->cf['clo']; 
			$this->writefile($this->online,'w',serialize($cr)); 
		}
		//Check change sau đó mới ghi file
		if($flag) $this->writefile($this->data,'w',serialize($dt));
	}
	public function display(){
		$cr = unserialize(file_get_contents($this->online)); $cro=count($cr); $c=0;
		$dt = unserialize(file_get_contents($this->data));
		if($cr) foreach($cr as $t) 
					if($t>$this->ct) $c++;	
		$rs = $c;				//Dang online
		
		$ytd=0; $lw=0; $lm=0; $cd=0; $all=0;
		if($dt)
		while(current($dt)){
			list($d,$m,$y) = explode("/",key($dt));
			$tmp = mktime(0,0,0,$m,$d,$y);
			if($tmp==$this->cf['cd']) $cd=current($dt);								//Ngay hom nay
			if($tmp==$this->cf['yd']) $ytd+=current($dt);							//Ngay hom truoc
			if($tmp>=$this->cf['lw'] && $tmp<$this->cf['cd']) $lw+=current($dt);	//Tuan truoc
			if($tmp>=$this->cf['lm'] && $tmp<$this->cf['cd']) $lm+=current($dt);	//Thang truoc
			$all+=current($dt);	
			next($dt);
		}
		$rs .= '-'.($cd+$cro).'-'.$ytd.'-'.$lw.'-'.$lm.'-'.($all+$cro);
		return $rs;
	}

	public function getConfig(){
		$d = new DateTime();	 $this->ct = $d->getTimestamp();		//Lấy thời gian hiện tại
		$this->cf['clo'] = 1440;										//Thời gian tính từ lần view page cuối
		$this->cf['cld'] = 180;											//Thời gian delay trước khi làm mới session		
		$aday = 24*60*60; $aweek = $aday*7; $amonth = $aday*30;
		list($d,$m,$y) = explode("/",date('d/m/Y',$this->ct));
		$this->cf['cd'] = mktime(0,0,0,$m,$d,$y);						//timestamp 0 giờ sáng hôm nay
		$this->cf['yd'] = $this->cf['cd'] - $aday;						//timestamp 0 giờ sáng ngày hôm trước
		$this->cf['lw'] = $this->cf['cd'] - $aweek;
		$this->cf['lm'] = $this->cf['cd'] - $amonth;
	}		
	
	private function writefile($name, $type, $value){
		$handle = fopen($name, $type);
		fwrite($handle, $value);
		fclose($handle);
	}
}