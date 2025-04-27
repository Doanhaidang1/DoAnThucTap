<?
require_once ("web_src/bean/TrangThai.php");
class TrangThaiPeer
{
    var $dbsql;
    var $trangthai;

    function __construct()
    {
        $this->dbsql = new db_mysql;
        $this->dbsql->connect();
        $this->trangthai = new TrangThai;

    }
    function setTrangThai($result)
    {
        $trangthai = new TrangThai;
        $trangthai->set("maTrangThai", $result["maTrangThai"]);
        $trangthai->set("tenTrangThai", $result["tenTrangThai"]);
        return $trangthai;
    }
    function setLog($_trangthai, $chucnang = "")
    {
        $log = new Log;

        if ($chucnang == "") {
            if ($_trangthai->get("maTrangThai") == "" || $_trangthai->get("maTrangThai") == 0)
                $chucnang = "Thêm trạng thái";
            else
                $chucnang = "Sửa trạng thái";
        }
        $noidung = "";
        $noidungcu = "";
        if ($_trangthai->get("maTrangThai") == "" || $_trangthai->get("maTrangThai") == 0) {
            $noidung = "Tên trạng thái: " . $_trangthai->get("tenTrangThai");
        } else {
            $noidung = "Tên trạng thái: " . $_trangthai->get("tenTrangThai");
            $trangthai = $this->getTrangThaiID($_trangthai->get("maTrangThai"));
            $noidungcu = "Tên trạng thái: " . $trangthai->get("tenTrangThai");
        }

        $log->set("chucnang", $chucnang);
        $log->set("noidung", $noidung);
        $log->set("noidungcu", $noidungcu);

        $logPeer = new LogPeer;
        $logPeer->ghiLog($log);
    }

    function getListTT()
    {
        $sSQL = "SELECT * FROM trangthai";
        $sSQL .= " ORDER BY `maTrangThai` DESC";
        $result = $this->dbsql->query($sSQL);
        $arrList = [];
        $i = 0;
        while ($row = $this->dbsql->fetch_Array($result)) {
            $arrList[$i] = $this->setTrangThai($row);
            $i++;
        }
        return $arrList;

    }

    function getTrangThaiID($trangThaiID)
    {
        // tao cau truy van		

        $sql_select = "SELECT * FROM trangthai WHERE maTrangThai='" . $trangThaiID . "'";

        $this->dbsql->query($sql_select);

        if ($this->dbsql->num_rows() > 0) {
            $result = $this->dbsql->fetch_array();
            return $this->setTrangThai($result);
        }
        return false;
    }

    function save($_trangthai)
    {
        if (empty($_trangthai->get("maTrangThai"))) {
            $sql = "INSERT INTO `trangthai` (`tenTrangThai`) 
					VALUES (
                        '" . $_trangthai->get("tenTrangThai") . "')";
        } else {
            $sql = "UPDATE `trangthai` 
            SET 
            `tenTrangThai` = '" . $_trangthai->get("tenTrangThai") . "'
			WHERE `maTrangThai` = '" . $_trangthai->get("maTrangThai") . "'";
        }
        $this->setLog($_trangthai);
        $this->dbsql->query($sql);

        return ($this->dbsql->insert_id() == 0) ? $_trangthai->get("maTrangThai") : $this->dbsql->insert_id();
    }
    function deleteTrangThai($maTrangThai)
    {
        if (!empty($maTrangThai)) {
            if ($maTrangThai == 1 || $maTrangThai == 2 || $maTrangThai == 3) {
                return false;
            } else {
                $this->trangthai->set("maTrangThai", $maTrangThai);
                $this->setLog($this->trangthai, "Xóa trạng thái");
                $sSQL = "DELETE FROM trangthai WHERE maTrangThai ='" . $maTrangThai . "'";
                $this->dbsql->query($sSQL);
            }
        }

    }
}