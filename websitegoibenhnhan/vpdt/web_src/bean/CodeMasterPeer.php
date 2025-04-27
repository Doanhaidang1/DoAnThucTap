<?
require_once("web_src/bean/CodeMaster.php");

class CodeMasterPeer{
	var $dbsql;
	
	function CodeMasterPeer() {
		$this->dbsql = new db_mysql;
		$this->dbsql->connect();
		$this->dbsql->selectdb();
	}	
	
	function setCodeMaster($result){
		$CodeMaster = new CodeMaster;					
		
		$CodeMaster->set("id",$result["id"]);
		$CodeMaster->set("year",$result["year"]);
		$CodeMaster->set("curvalue",$result["curvalue"]);
		$CodeMaster->set("active",$result["active"]);
		$CodeMaster->set("description",$result["description"]);	
						
		return $CodeMaster;
	}

	function getCodeMaster($code){
		$year = substr(date("Y"),2);
		// kiem tra nam da co chua
		$curvalue = $this->getCurvalue($code, $year);
		if(!$curvalue) {
			$this->updateActive($code, $year);	
			$this->insert($code, $year);
			$curvalue = $this->getCurvalue($code, $year);
		}
		$this->update($code, $year);	
		
		return $code.$year."/".$curvalue;
	}
	
	function getCurvalue($code, $year){
		$sSQL = " SELECT LPAD(`curvalue`,6,'0') `curvalue` FROM codemaster WHERE id='".$code."' AND year = '".$year."'";
		
		$result=$this->dbsql->query($sSQL);		
		
		if($row = $this->dbsql->fetch_Array($result)){			
			return $row["curvalue"];		
		}
		return false;		
	}
	
	function updateActive($code, $year){
		$sql = "UPDATE `codemaster` SET `active` = '0' WHERE id='".$code."' AND year = '".$year."'";			
		$this->dbsql->query($sql);
	}
	
	function update($code, $year){
		$sql = "UPDATE `codemaster` SET `curvalue` = (`curvalue` + 1) WHERE id='".$code."' AND year = '".$year."'";			
		$this->dbsql->query($sql);
	}
	
	function insert($code, $year){
		$sql = "INSERT INTO `codemaster` (`id`, `year`, `curvalue`, `active`, `description`) 
		VALUES ('".$code."','".$year."','1','1','')";
		$this->dbsql->query($sql);
	}
}
?>

