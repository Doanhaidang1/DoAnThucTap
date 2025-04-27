<?PHP
class kho {	
  
	var $Id_kho;
	var $Ten_kho;

	function kho(){		
		$this->Id_kho = 0;
		$this->Ten_kho = "";
	}
	
	function set($key,$value){
		$this->$key = $value;		
	}
	
	function get($key){
		return $this->$key ;
	}		
}
?>