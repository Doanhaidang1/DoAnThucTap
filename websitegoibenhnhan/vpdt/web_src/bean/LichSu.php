<?PHP
class LichSu {	
	var $lsId; 
	var $dtId; 
	var $ngayGhi; 
	var $nguoiThaoTac; 
	var $stateIn; 
	var $stateOut; 
	var $ghiChu;
	
	function LichSu(){				
		$this->lsId = 0; 
		$this->dtId = 0; 
		$this->ngayGhi = ""; 
		$this->nguoiThaoTac = 0; 
		$this->stateIn = 0; 
		$this->stateOut = 0; 
		$this->ghiChu = "";		
	}
		
	function set($key,$value){
		$this->$key = $value;		
	}
	
	function get($key){
		return $this->$key ;
	}		
}
?>