<?
require_once ("web_src/bean/QuayTiepNhan.php");
class QuayTiepNhanPeer
{
    var $dbsql;
    var $quaytiepnhan;

    function __construct()
    {
        $this->dbsql = new db_mysql;
        $this->dbsql->connect();
        $this->quaytiepnhan = new QuayTiepNhan();

    }
    function setQuayTiepNhan($result)
    {
        $quayTiepNhan = new QuayTiepNhan;
        $quayTiepNhan->set("maQuay", $result["maQuay"]);
        $quayTiepNhan->set("tenQuayTiepNhan", $result["tenQuayTiepNhan"]);
        return $quayTiepNhan;
    }
    function setLog($_quayTiepNhan, $chucnang = "")
    {
        $log = new Log;

        if ($chucnang == "") {
            if ($_quayTiepNhan->get("maQuay") == "" || $_quayTiepNhan->get("maQuay") == 0)
                $chucnang = "Thêm quầy tiếp nhận";
            else
                $chucnang = "Sửa quầy tiếp nhận";
        }
        $noidung = "";
        $noidungcu = "";
        if ($_quayTiepNhan->get("maQuay") == "" || $_quayTiepNhan->get("maQuay") == 0) {
            $noidung = "Tên quầy tiếp nhận: " . $_quayTiepNhan->get("tenQuayTiepNhan");
        } else {
            $noidung = "Tên quầy tiếp nhận: " . $_quayTiepNhan->get("tenQuayTiepNhan");
            $quaytiepnhan = $this->getQuayTiepNhanID($_quayTiepNhan->get("maQuay"));
            $noidungcu = "Tên quầy tiếp nhận: " . $quaytiepnhan->get("tenQuayTiepNhan");
        }

        $log->set("chucnang", $chucnang);
        $log->set("noidung", $noidung);
        $log->set("noidungcu", $noidungcu);

        $logPeer = new LogPeer;
        $logPeer->ghiLog($log);
    }

    function getListQuay()
    {
        $sSQL = "SELECT * FROM quaytiepnhan";
        $sSQL .= " ORDER BY `maQuay` DESC";
        $result = $this->dbsql->query($sSQL);
        $arrList = [];
        $i = 0;
        while ($row = $this->dbsql->fetch_Array($result)) {
            $arrList[$i] = $this->setQuayTiepNhan($row);
            $i++;
        }
        return $arrList;

    }

    function getQuayTiepNhanID($quayTiepNhanID)
    {
        // tao cau truy van		

        $sql_select = "SELECT * FROM quaytiepnhan WHERE maQuay='" . $quayTiepNhanID . "'";

        $this->dbsql->query($sql_select);

        if ($this->dbsql->num_rows() > 0) {
            $result = $this->dbsql->fetch_array();
            return $this->setQuayTiepNhan($result);
        }
        return false;
    }

    function save($_quayTiepNhan)
    {
        if (empty($_quayTiepNhan->get("maQuay"))) {
            $sql = "INSERT INTO `quaytiepnhan` (`tenQuayTiepNhan`) 
					VALUES (
                        '" . $_quayTiepNhan->get("tenQuayTiepNhan") . "')";
        } else {
            $sql = "UPDATE `quaytiepnhan` 
            SET 
            `tenQuayTiepNhan` = '" . $_quayTiepNhan->get("tenQuayTiepNhan") . "'
			WHERE `maQuay` = '" . $_quayTiepNhan->get("maQuay") . "'";
        }
        $this->setLog($_quayTiepNhan);
        $this->dbsql->query($sql);

        return ($this->dbsql->insert_id() == 0) ? $_quayTiepNhan->get("maQuay") : $this->dbsql->insert_id();
    }
    function deleteQuayTiepNhan($maQuayTiepNhan)
    {
        if (!empty($maQuayTiepNhan)) {

            $this->quaytiepnhan->set("maQuay", $maQuayTiepNhan);
            $this->setLog($this->quaytiepnhan, "Xóa quầy tiếp nhận");
            $sSQL = "DELETE FROM quaytiepnhan WHERE maQuay ='" . $maQuayTiepNhan . "'";
            $this->dbsql->query($sSQL);

        }

    }
}