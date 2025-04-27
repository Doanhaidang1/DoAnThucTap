<?PHP
class hang {	
	
	var $Id_hang; 
	var $Ten_hang; 
	var $DVT; 
	var $Kho; 
	var $Lo; 
	var $Date; 
	var $SL; 
	var $Gia; 
    var $Nguon;
		
	function hang(){
		$this->Id_hang = 0; 
		$this->Ten_hang = ""; 
		$this->DVT = ""; 
		$this->Kho = ""; 
		$this->Lo = ""; 
		$this->Date = ""; 
		$this->SL = ""; 
		$this->Gia = "";
        $this->Nguon = "";		
	}
	function sethang($key,$value){
		$this->$key = $value;		
	}
	
	function gethang($key){
		return $this->$key ;
	}	
	function set($key,$value){
		$this->$key = $value;		
	}
	
	function get($key){
		return $this->$key ;
	}		
}
?>