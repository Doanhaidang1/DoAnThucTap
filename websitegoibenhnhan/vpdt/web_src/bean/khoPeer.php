<?PHP
require_once ("web_src/bean/kho.php");

class khoPeer
{
	var $dbsql;

	function khoPeer()
	{
		$this->dbsql = new db_mysql;
		$this->dbsql->connect();
		$this->dbsql->selectdb();
	}

	function setkho($result)
	{
		$kho = new kho;

		$kho->set("Id_kho", $result["Id_kho"]);
		$kho->set("Ten_kho", $result["Ten_kho"]);

		return $kho;
	}

	function setLog($_kho, $chucnang = "")
	{
		$log = new Log;

		if ($chucnang == "") {
			if ($_kho->get("Id_kho") == "" || $_kho->get("Id_kho") == 0)
				$chucnang = "Thêm kho";
			else
				$chucnang = "Sửa kho";
		}
		$noidung = "";
		$noidungcu = "";
		if ($_kho->get("Id_kho") == "" || $_kho->get("Id_kho") == 0) {
			$noidung = "Ten_kho =" . $_kho->get("Ten_kho");
		} else {
			$noidung = "Ten_kho =" . $_kho->get("Ten_kho");
			$kho = $this->getkhoID($_kho->get("Id_kho"));
			$noidungcu = "Ten_kho =" . $kho->get("Ten_kho");
		}

		$log->set("chucnang", $chucnang);
		$log->set("noidung", $noidung);
		$log->set("noidungcu", $noidungcu);

		$logPeer = new LogPeer;
		$logPeer->ghiLog($log);
	}

	function getkhoID($khoID)
	{
		// tao cau truy van		

		$sql_select = "SELECT * FROM kho WHERE Id_kho='" . $khoID . "'";

		$this->dbsql->query($sql_select);

		if ($this->dbsql->num_rows() > 0) {
			$result = $this->dbsql->fetch_array();
			return $this->setkho($result);
		}
		return false;
	}


	function save($_kho)
	{
		if ($_kho->get("Id_kho") == 0 || $_kho->get("Id_kho") == "") {
			$sql = "INSERT INTO `kho` (`Id_kho` , `Ten_kho`) 
					VALUES ('" . $_kho->get("Id_kho") . "' ,'" . $_kho->get("Ten_kho") . "')";
		} else {
			$sql = "UPDATE `kho` SET `Id_kho` = '" . $_kho->get("Id_kho") . "',`Ten_kho` = '" . $_kho->get("Ten_kho") . "'
						WHERE `Id_kho` = '" . $_kho->get("Id_kho") . "'";
		}

		$this->setLog($_kho);

		$this->dbsql->query($sql);

		return ($this->dbsql->insert_id() == 0) ? $_kho->get("Id_kho") : $this->dbsql->insert_id();
	}

	function update($_kho)
	{
		$sql = "UPDATE `kho` SET `Ten_kho` = '" . $_kho->get("Ten_kho") . "'
				WHERE `Id_kho` = '" . $_kho->get("Id_kho") . "'";

		$this->dbsql->query($sql);

		return ($this->dbsql->insert_id() == 0) ? $_kho->get("Id_kho") : $this->dbsql->insert_id();
	}

	// hiển thị danh sách từ form tìm kiếm
	function getListkho($Ten_kho = "")
	{
		$sSQL = " SELECT * FROM kho ";

		if ($Ten_kho != "") {
			$sSQL = $sSQL . " WHERE ";
			$sSQL .= " UPPER(`Ten_kho`) LIKE UPPER('%" . $Ten_kho . "%') ";
		}

		$sSQL .= " ORDER BY `Ten_kho` ASC";

		$result = $this->dbsql->query($sSQL);
		$arrList = [];
		$i = 0;
		while ($row = $this->dbsql->fetch_Array($result)) {
			$arrList[$i] = $this->setkho($row);
			$i++;
		}
		return $arrList;
	}

	function delete($Id_kho)
	{
		$kho = new kho;
		$kho->set("Id_kho", $Id_kho);
		$this->setLog($kho, "Xóa kho");

		$sSQL = "DELETE FROM kho WHERE Id_kho='" . $Id_kho . "'";
		$this->dbsql->query($sSQL);
	}
}
?>