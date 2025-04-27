<?PHP
class CodeMaster{	
  	
	var $id;
	var $year;
	var $curvalue;
	var $active;
	var $description;
	
	function CodeMaster(){	
		$this->id = "";
		$this->year = "";
		$this->curvalue = 1;
		$this->active = 1;
		$this->description = "";		
	}
	
	function set($key,$value){
		$this->$key = $value;		
	}
	
	function get($key){
		return $this->$key ;
	}		
}
?>