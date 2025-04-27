<?php
require_once ("web_src/bean/BacSi.php");
require_once ("web_src/bean/KhoaPhong.php");
class BacSiPeer
{
    private $conn;

    var $dbsql;
    var $bs;
    var $kp;
    function __construct()
    {
        $this->dbsql = new db_mysql;
        $this->bs = new BacSi;
        $this->dbsql->connect();
        $this->kp = new KhoaPhong;
    }

    function setBacSi($result)
    {
        $bacsi = new BacSi;

        $bacsi->set("MaBacSi", $result["MaBacSi"]);
        $bacsi->set("TenBacSi", $result["TenBacSi"]);
        $bacsi->set("GioiTinh", $result["GioiTinh"]);
        $bacsi->set("soDienThoai", $result["soDienThoai"]);
        $bacsi->set("MaKhoaPhong", $result["MaKhoaPhong"]);
        // $bacsi->set("Avatar", $result["Avatar"]);
        return $bacsi;
    }
    function setLog($_BacSi, $chucnang = "")
    {
        $log = new Log;

        if ($chucnang == "") {
            if ($_BacSi->get("MaBacSi") == "" || $_BacSi->get("MaBacSi") == 0)
                $chucnang = "Thêm bác sĩ";
            else
                $chucnang = "Sửa bác sĩ";
        }
        $noidung = "";
        $noidungcu = "";
        if ($_BacSi->get("MaBacSi") == "" || $_BacSi->get("MaBacSi") == 0) {
            $noidung = "Tên bác sĩ: " . $_BacSi->get("TenBacSi")
                . "; Giới tính: " . $_BacSi->get("GioiTinh")
                . "; sdt: " . $_BacSi->get('soDienThoai');
        } else {
            $noidung = "Tên bác sĩ: " . $_BacSi->get("TenBacSi")
                . "; Giới tính: " . $_BacSi->get("GioiTinh")
                . "; sdt: " . $_BacSi->get('soDienThoai');
            $BacSiCu = $this->getBacSiID($_BacSi->get("MaBacSi"));
            $noidungcu = "Tên bác sĩ: " . $BacSiCu->get("TenBacSi")
                . "; Giới tính: " . $BacSiCu->get("GioiTinh")
                . "; sdt: " . $BacSiCu->get('soDienThoai');
        }

        $log->set("chucnang", $chucnang);
        $log->set("noidung", $noidung);
        $log->set("noidungcu", $noidungcu);

        $logPeer = new LogPeer;
        $logPeer->ghiLog($log);
    }


    function getBacSiID($bacSiID)
    {
        $sql_select = "SELECT * FROM bacsi WHERE MaBacSi='" . $bacSiID . "'";

        $this->dbsql->query($sql_select);

        if ($this->dbsql->num_rows() > 0) {
            $result = $this->dbsql->fetch_array();
            return $this->setBacSi($result);
        }
        return false;
    }
    function getListTenBacSi($data)
    {
        $keyWord = strtoupper($data);
        $sSQL = "SELECT bacsi.MaBacSi, bacsi.TenBacSi FROM bacsi WHERE UPPER(bacsi.TenBacSi) LIKE '%" . $keyWord . "%'";

        $result = $this->dbsql->query($sSQL);
        $arrList = [];
        while ($row = $result->fetch_assoc()) {
            $arrList[] = [
                'MaBacSi' => $row['MaBacSi'],
                'TenBacSi' => $row['TenBacSi']
            ];

        }
        return $arrList;
    }
    function getListBacSi()
    {
        $sSQL = "SELECT * FROM bacsi ORDER BY MaBacSi DESC";

        $result = $this->dbsql->query($sSQL);
        $arrList = [];
        $i = 0;
        while ($row = $this->dbsql->fetch_Array($result)) {
            $arrList[$i] = $this->setBacSi($row);
            $i++;
        }
        return $arrList;
    }

    function save($_bacSi, $pass = 0)
    {
        if ($_bacSi->get("MaBacSi") == "" || $_bacSi->get("MaBacSi") == 0) {
            $sql = "INSERT INTO `bacsi`(`TenBacSi`, `GioiTinh`, `soDienThoai`, `MaKhoaPhong`) 
                    VALUES ('" . $_bacSi->get("TenBacSi") . "','"
                . $_bacSi->get("GioiTinh") . "','"
                . $_bacSi->get("soDienThoai") . "','"
                . $_bacSi->get("MaKhoaPhong") . "')";
        } else {
            if ($pass == 0) {
                $sql = "UPDATE `bacsi` SET 
                              `TenBacSi` = '" . $_bacSi->get("TenBacSi") . "',
                              `GioiTinh` = '" . $_bacSi->get("GioiTinh") . "',
                              `soDienThoai` = '" . $_bacSi->get("soDienThoai") . "',
                              `MaKhoaPhong` = '" . $_bacSi->get("MaKhoaPhong") . "'
                        WHERE `MaBacSi` =  '" . $_bacSi->get("MaBacSi") . "' ";
            }
        }
        $this->setLog($_bacSi);
        $this->dbsql->query($sql);
        return ($this->dbsql->insert_id() == 0) ? $_bacSi->get("MaBacSi") : $this->dbsql->insert_id();
    }

    function deleteBacSi($maBacSi)
    {
        $this->bs->set("MaBacSi", $maBacSi);
        $this->setLog($this->bs, "Xóa bác sĩ");
        $sSQL = "DELETE FROM bacsi WHERE MaBacSi ='" . $maBacSi . "'";
        $this->dbsql->query($sSQL);
        return true;
    }
}
?>