<?PHP
require_once ("web_src/bean/LichSu.php");

class LichSuPeer
{
	var $dbsql;

	function LichSuPeer()
	{
		$this->dbsql = new db_mysql;
		$this->dbsql->connect();
		$this->dbsql->selectdb();
	}

	function setLichSu($result)
	{
		$lichSu = new LichSu;

		$lichSu->set("lsId", $result["lsId"]);
		$lichSu->set("dtId", $result["dtId"]);
		$lichSu->set("ngayGhi", $result["ngayGhi"]);
		$lichSu->set("nguoiThaoTac", $result["nguoiThaoTac"]);
		$lichSu->set("stateIn", $result["stateIn"]);
		$lichSu->set("stateOut", $result["stateOut"]);
		$lichSu->set("ghiChu", $result["ghiChu"]);

		return $lichSu;
	}

	function getLichSu()
	{
		$sSQL = " SELECT * FROM lichsu ";
		$sSQL .= " ORDER BY `order` ASC";

		$result = $this->dbsql->query($sSQL);
		$arrList = [];
		$i = 0;
		while ($row = $this->dbsql->fetch_Array($result)) {
			$arrList[$i] = $this->setLichSu($row);
			$i++;
		}
		return $arrList;
	}

	function save($dtId, $stateIn = -1, $stateOut = 0, $ghiChu = "")
	{
		$d = strtotime("now");

		$sql = "INSERT INTO `lichsu`(`lsId`, `dtId`, `ngayGhi`, `nguoiThaoTac`, `stateIn`, `stateOut`, `ghiChu`) VALUES (NULL,'" . $dtId . "','" . date("Y-m-d h:i:s", $d) . "','" . $_SESSION["sUserName"] . "','" . $stateIn . "','" . $stateOut . "','" . $ghiChu . "')";

		$this->dbsql->query($sql);

		return $this->dbsql->insert_id();
	}

}
?>