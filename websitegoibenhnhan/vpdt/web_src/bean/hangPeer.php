<?PHP
require_once ("web_src/bean/hang.php");

class hangPeer
{
	var $dbsql;

	function hangPeer()
	{
		$this->dbsql = new db_mysql;
		$this->dbsql->connect();
		//$this->dbsql->selectdb();
	}

	function sethang($result, $pass = 0)
	{
		$hang = new hang;

		$hang->sethang("Id_hang", $result["Id_hang"]);
		$hang->sethang("Ten_hang", $result["Ten_hang"]);
		$hang->sethang("DVT", $result["DVT"]);
		$hang->sethang("Kho", $result["Kho"]);
		$hang->sethang("Lo", $result["Lo"]);
		$hang->sethang("Date", $result["Date"]);
		$hang->sethang("SL", $result["SL"]);
		$hang->sethang("Gia", $result["Gia"]);
		$hang->sethang("Nguon", $result["Nguon"]);

		return $hang;
	}

	// function setLog($_hang,$chucnang=""){
	// 	$log = new Log;

	// 	if($chucnang==""){
	// 		if($_hang->gethang("Id_hang") == "" || $_hang->gethang("Id_hang") == 0) $chucnang = "Thêm hang";
	// 		else $chucnang = "Sửa hang";
	// 	}
	// 	$noidung = "";
	// 	$noidungcu = "";
	// 	if($_hang->gethang("Id_hang") == "" || $_hang->gethang("Id_hang") == 0){
	// 		$noidung = "Ten_hang =" . $_hang->gethang("Ten_hang") . ";Lô =" . $_hang->gethang("Lo");
	// 	}
	// 	else{
	// 		$noidung = "Ten_hang =" . $_hang->gethang("Ten_hang") . ";Lô =" . $_hang->gethang("Lo");
	// 		$hang = $this->gethangID($_hang->gethang("Id_hang"));
	// 		$noidungcu = "Ten_hang =" . $hang->gethang("Ten_hang") . ";Lô =" . $hang->gethang("Lo");
	// 	}

	// 	$log->set("chucnang",$chucnang);
	// 	$log->set("noidung",$noidung);
	// 	$log->set("noidungcu",$noidungcu);

	// 	$logPeer = new LogPeer;		
	// 	$logPeer->ghiLog($log);
	// }

	// function gethang(){		
	// 	// tao cau truy van
	// 	//$hang = new hang;

	// 	// $sql_select = "SELECT * FROM hang WHERE Id_hang='" . $hangID . "'" ;		
	// 	$sql_select = "SELECT * FROM hang";
	// 	$this->dbsql->query($sql_select);		

	// 	if ($this->dbsql->num_rows() > 0)
	// 	{		
	// 		$result = $this->dbsql->fetch_array();		
	// 		return $this->sethang($result,1);								
	// 	}		
	// 	return false;
	// }
	// ham tim kiem
	function gethangs($searchString, $arrhang)
	{
		$sSQL = " SELECT * FROM hang ";
		$sSQL .= " WHERE (UPPER(`Id_hang`) LIKE UPPER('%" . $searchString . "%') OR UPPER(`Ten_hang`) LIKE UPPER('%" . $searchString . "%'))";
		if ($arrhang != "")
			$sSQL .= " AND `Id_hang` not in (" . $arrhang . ")";

		$sSQL .= " AND `Id_hang` != '11'";
		$sSQL .= " ORDER BY `Ten_hang` ASC";

		$result = $this->dbsql->query($sSQL);
		$arrList = [];
		$i = 0;
		while ($row = $this->dbsql->fetch_Array($result)) {
			$arrList[$i] = $this->sethang($row);
			$i++;
		}
		return $arrList;
	}

	function gethangID($Id_hang)
	{
		// tao cau truy van
		//$hang = new hang;

		$sql_select = "SELECT * FROM hang WHERE Id_hang='" . $Id_hang . "'";

		$this->dbsql->query($sql_select);

		if ($this->dbsql->num_rows() > 0) {
			$result = $this->dbsql->fetch_array();
			return $this->sethang($result);
		}
		return false;
	}

	// function gethangLogin($Ten_hang,$pass){		
	// 	$sql_select = "SELECT * FROM hang WHERE Ten_hang='" . $Ten_hang . "' AND nd_block = '0'" ;

	// 	$this->dbsql->query($sql_select);		
	// 	if ($this->dbsql->num_rows() > 0)
	// 	{		
	// 			$result = $this->dbsql->fetch_array();				
	// 			if(md5($pass) == $result["password"]){
	// 				return $this->sethang($result);						
	// 			}
	// 	}

	// 	return false;
	// }

	// function checkTen_hang($id,$Ten_hang){
	// 	$hang = $this->gethang($Ten_hang);
	// 	if($hang && $hang->get("id") != $id){			
	// 		return false;
	// 	}
	// 	return true;
	// }

	// function getIP(){		
	// 	$ip = $_SERVER["REMOTE_ADDR"];
	// 	$sql_select = "SELECT COUNT(*) FROM `Id_hang` WHERE `address` LIKE '$ip' AND `timestamp` > (now() - interval 10 minute)" ;

	// 	$this->dbsql->query($sql_select);		
	// 	if ($this->dbsql->num_rows() > 0)
	// 	{		
	// 			$result = $this->dbsql->fetch_array();				
	// 			return $result[0];				
	// 	}

	// 	return 0;
	// }

	// function saveIP(){		
	// 	$ip = $_SERVER["REMOTE_ADDR"];
	// 	$sql = "INSERT INTO `Id_hang` (`address` ,`timestamp`)VALUES ('$ip',CURRENT_TIMESTAMP)";		
	// 	$this->dbsql->query($sql);

	// 	return $this->dbsql->insert_id();		
	// }

	function save($hang)
	{
		// $test = $hang->get("Id_hang");
		// echo "test-";
		// print_r($test);
		if ($hang->get("Id_hang") == "" || $hang->get("Id_hang") == 0) {
			$sql = "INSERT INTO `hang`(`Ten_hang`,`DVT`,`Kho`,`Lo`,`Date`,`SL`,`Gia`,`Nguon`) VALUES ('" . $hang->gethang("Ten_hang") . "','" . $hang->gethang("DVT") . "','" . $hang->gethang("Kho") . "','" . $hang->gethang("Lo") . "','" . $hang->gethang("Date") . "','" . $hang->gethang("SL") . "','" . $hang->gethang("Gia") . "','" . $hang->gethang("Nguon") . "')";
		} else {
			$sql = "UPDATE `hang` SET 
							`Ten_hang` = '" . $hang->gethang("Ten_hang") . "',
							`DVT` = '" . $hang->gethang("DVT") . "',
							`Kho` = '" . $hang->gethang("Kho") . "',
							`Lo` = '" . $hang->gethang("Lo") . "',
							`Date` = '" . $hang->gethang("Date") . "',
							`SL` = '" . $hang->gethang("SL") . "',
							`Gia` = '" . $hang->gethang("Gia") . "',
							`Nguon` = '" . $hang->gethang("Nguon") . "'
					WHERE `Id_hang` =  '" . $hang->gethang("Id_hang") . "' ";
		}
		//echo ($sql);
		// $this->setLog($hang);

		// if($this->checkTen_hang($hang->gethang("id"),$hang->gethang("Ten_hang"))) {			
		$this->dbsql->query($sql);
		return ($this->dbsql->insert_id() == 0) ? $hang->gethang("Id_hang") : $this->dbsql->insert_id();
		// }

		// return false;
	}

	// function updateLock($hangId,$nd_block=0){
	// 	$sql = "UPDATE `hang` SET `nd_block` = '" . $nd_block ."' WHERE `Id_hang` =  '" . $hangId . "' ";
	// 	$this->dbsql->query($sql);
	// }

	function getListhang($Id_hang = "", $Ten_hang = "")
	{
		$sSQL = " SELECT * FROM hang ";
		$sSQL = $sSQL . " WHERE `Id_hang` != '11'";

		if ($Id_hang != "" || $Ten_hang != "") {
			$or = " AND";
			if ($Id_hang != "") {
				$sSQL = $sSQL . $or . " (UPPER(`Lo`) LIKE UPPER('%" . $Id_hang . "%') ";
				$or = " OR ";
			}
			if ($Ten_hang != "")
				$sSQL = $sSQL . $or . " UPPER(`Ten_hang`) LIKE UPPER('%" . $Ten_hang . "%') ";

			$sSQL .= ")";
		}

		// if($_SESSION["AdminType"]!=1){
		// 	$sSQL.=" AND `adminType` = '0' ";
		// }			

		$result = $this->dbsql->query($sSQL);
		$arrList = [];
		$i = 0;
		while ($row = $this->dbsql->fetch_Array($result)) {
			$arrList[$i] = $this->sethang($row);
			$i++;
		}
		return $arrList;
	}

	function getListhangActive()
	{
		$sSQL = " SELECT * FROM hang ";
		$sSQL .= " WHERE `id` != '11' AND `nd_block` = '0'";

		$result = $this->dbsql->query($sSQL);
		$arrList = [];
		$i = 0;
		while ($row = $this->dbsql->fetch_Array($result)) {
			$arrList[$i] = $this->sethang($row);
			$i++;
		}
		return $arrList;
	}

	function deletehang($Id)
	{

		$hang = new hang;
		$hang->set("Id_hang", $Id);
		// $test = $hang->get($Id_hang);
		// echo "test-";
		// print_r($test);
		// $this->setLog($hang,"Xóa hang");

		$sSQL = "DELETE FROM `hang` WHERE Id_hang='" . $Id . "'";
		$this->dbsql->query($sSQL);
	}
}
?>