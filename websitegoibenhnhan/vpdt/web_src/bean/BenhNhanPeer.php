<?
require_once ("web_src/bean/BenhNhan.php");
require_once ("web_src/bean/BacSiPeer.php");
require_once ("web_src/bean/TrangThaiPeer.php");
class BenhNhanPeer
{
    var $dbsql;
    var $benhnhan;
    var $log;
    var $bacsipeer;
    var $trangthaipeer;

    function __construct()
    {
        $this->dbsql = new db_mysql;
        $this->benhnhan = new BenhNhan;
        $this->bacsipeer = new BacSiPeer;
        $this->trangthaipeer = new TrangThaiPeer;
        $this->dbsql->connect();

    }
    function setBenhNhan($result)
    {
        $benhnhan = new BenhNhan;
        $benhnhan->set("id", $result["id"]);
        $benhnhan->set("maBN", $result["maBN"]);
        $benhnhan->set("tenBN", $result["tenBN"]);
        $benhnhan->set("namSinh", $result["namSinh"]);
        $benhnhan->set("gioiTinh", $result["gioiTinh"]);
        $benhnhan->set("chuanDoan", $result["chuanDoan"]);
        $benhnhan->set("ngayTao", $result["ngayTao"]);
        $benhnhan->set("maTrangThai", $result["maTrangThai"]);
        $benhnhan->set("quayTiepNhan", $result["quayTiepNhan"]);
        $benhnhan->set("bacSi", $result["bacSi"]);
        $benhnhan->set("ngayGoi", $result["ngayGoi"]);
        $benhnhan->set("ngayGoiMoiNhat", $result["ngayGoiMoiNhat"]);
        return $benhnhan;
    }

    function setLog($_BenhNhan, $chucnang = "")
    {
        $log = new Log;
        $listTrangThai = $this->trangthaipeer->getListTT();
        if (!empty($listTrangThai)) {
            foreach ($listTrangThai as $item) {
                if ($item->maTrangThai == $_BenhNhan->get("maTrangThai")) {
                    $_BenhNhan->set("tenTrangThai", $item->tenTrangThai);
                }
            }
        }
        if ($chucnang == "") {
            if ($_BenhNhan->get("id") == "" || $_BenhNhan->get("id") == 0)
                $chucnang = "Thêm bệnh nhân";
            else
                $chucnang = "Sửa bệnh nhân";
        }
        $noidung = "";
        $noidungcu = "";
        if ($_BenhNhan->get("id") == "" || $_BenhNhan->get("id") == 0) {
            $noidung = "Mã bệnh nhân: " . $_BenhNhan->get("maBN")
                . "; Tên bệnh nhân: " . $_BenhNhan->get("tenBN")
                . "; Năm sinh: " . $_BenhNhan->get("namSinh")
                . "; Giới tính: " . $_BenhNhan->get("gioiTinh")
                . "; Chuẩn đoán: " . $_BenhNhan->get("chuanDoan")
                . "; Ngày tạo: " . $_BenhNhan->get("ngayTao")
                . "; Trạng thái: " . $_BenhNhan->get("tenTrangThai")
                . "; Bác sĩ: " . $_BenhNhan->get("bacSi");

        } else {
            if ($chucnang === "Xóa bệnh nhân") {
                $noidung = "Mã bệnh nhân: " . $_BenhNhan->get("maBN")
                    . "; Tên bệnh nhân: " . $_BenhNhan->get("tenBN")
                    . "; Ngày tạo: " . $_BenhNhan->get("ngayTao") . "<br><br>"
                    . "<em>Trạng thái xóa: </em>" . ($_BenhNhan->get("trangThaiXoa") == 1 ? '<em>Đã xóa' : '<em>Chưa xóa</em>');
                $benhnhan = $this->getBenhNhan($_BenhNhan->get("id"));
                $noidungcu = "Mã bệnh nhân: " . $benhnhan->get("maBN")
                    . "; Tên bệnh nhân: " . $benhnhan->get("tenBN")
                    . "; Ngày tạo: " . $benhnhan->get("ngayTao") . "<br><br>"
                    . "<em> Trạng thái xóa: </em>" . ($benhnhan->get("trangThaiXoa") == 1 ? '<em>Đã xóa' : '<em>Chưa xóa</em>');
            }
            if ($chucnang === "Đổi trạng thái") {
                $noidung = "Mã bệnh nhân: " . $_BenhNhan->get("maBN")
                    . "; Tên bệnh nhân: " . $_BenhNhan->get("tenBN")
                    . "; Ngày tạo: " . $_BenhNhan->get("ngayTao") . '<br><br><em>'
                    . "Trạng thái: " . $_BenhNhan->get("tenTrangThai")
                    . "; Quầy tiếp nhận: " . $_BenhNhan->get("quayTiepNhan")
                    . "; Ngày gọi: " . $_BenhNhan->get("ngayGoi")
                    . "; Ngày gọi mới nhất: " . $_BenhNhan->get("ngayGoiMoiNhat") . '</em>';
                $benhnhan = $this->getBenhNhan($_BenhNhan->get("id"));
                foreach ($listTrangThai as $item) {
                    if ($item->maTrangThai == $benhnhan->get('maTrangThai')) {
                        $benhnhan->set("tenTrangThai", $item->tenTrangThai);
                    }
                }
                $noidungcu = "Mã bệnh nhân: " . $benhnhan->get("maBN")
                    . "; Tên bệnh nhân: " . $benhnhan->get("tenBN")
                    . "; Ngày tạo: " . $benhnhan->get("ngayTao") . '<br><br><em>'
                    . "Trạng thái: " . $benhnhan->get("tenTrangThai")
                    . "; Quầy tiếp nhận: " . $benhnhan->get("quayTiepNhan")
                    . "; Ngày gọi: " . $benhnhan->get("ngayGoi")
                    . "; Ngày gọi mới nhất: " . $benhnhan->get("ngayGoiMoiNhat") . '</em>';
            }
            if ($chucnang === "Sửa bệnh nhân") {
                $noidung = "Mã bệnh nhân: " . $_BenhNhan->get("maBN")
                    . "; Tên bệnh nhân: " . $_BenhNhan->get("tenBN")
                    . "; Năm sinh: " . $_BenhNhan->get("namSinh")
                    . "; Giới tính: " . $_BenhNhan->get("gioiTinh")
                    . "; Chuẩn đoán: " . $_BenhNhan->get("chuanDoan")
                    . "; Ngày tạo: " . $_BenhNhan->get("ngayTao")
                    . "; Trạng thái: " . $_BenhNhan->get("tenTrangThai")
                    . "; Trạng thái Xóa: " . ($_BenhNhan->get("trangThaiXoa") == 1 ? 'Đã xóa' : 'Chưa xóa')
                    . "; Bác sĩ: " . $_BenhNhan->get("bacSi");
                $benhnhan = $this->getBenhNhan($_BenhNhan->get("id"));
                foreach ($listTrangThai as $item) {
                    if ($item->maTrangThai == $benhnhan->get('maTrangThai')) {
                        $benhnhan->set("tenTrangThai", $item->tenTrangThai);
                    }
                }
                $noidungcu = "Mã bệnh nhân: " . $benhnhan->get("maBN")
                    . "; Tên bệnh nhân: " . $benhnhan->get("tenBN")
                    . "; Năm sinh: " . $benhnhan->get("namSinh")
                    . "; Giới tính: " . $benhnhan->get("gioiTinh")
                    . "; Chuẩn đoán: " . $benhnhan->get("chuanDoan")
                    . "; Ngày tạo: " . $benhnhan->get("ngayTao")
                    . "; Trạng thái: " . $benhnhan->get("tenTrangThai")
                    . "; Trạng thái Xóa: " . ($_BenhNhan->get("trangThaiXoa") == 1 ? 'Đã xóa' : 'Chưa xóa')
                    . "; Bác sĩ: " . $benhnhan->get("bacSi");
            }
        }
        $log->set("chucnang", $chucnang);
        $log->set("noidung", $noidung);
        $log->set("noidungcu", $noidungcu);

        $logPeer = new LogPeer;
        $logPeer->ghiLog($log);
    }
    function getListBN()
    {
        $sSQL = "SELECT bn.id, bn.maBN, bn.tenBN, bn.namSinh,bn.quayTiepNhan, bn.gioiTinh,bn.chuanDoan,bn.maTrangThai,bn.bacSi, bn.ngayTao,bn.ngayGoi, bn.ngayGoiMoiNhat
        FROM benhnhan as bn LEFT JOIN trangthai as tt ON bn.maTrangThai = tt.maTrangThai LEFT JOIN bacsi as bs ON bn.bacSi = bs.MaBacSi";
        $sSQL .= " WHERE bn.maTrangThai != 3 AND bn.trangThaiXoa = 0 ORDER BY bn.ngayTao DESC";
        $result = $this->dbsql->query($sSQL);
        $arrList = [];
        $i = 0;
        while ($row = $this->dbsql->fetch_Array($result)) {
            $arrList[$i] = $this->setBenhNhan($row);
            $i++;
        }
        return $arrList;
    }
    function getListBNGoi()
    {

        $sSQL = "SELECT * FROM benhnhan as bn LEFT JOIN trangthai as tt ON bn.maTrangThai = tt.maTrangThai WHERE bn.maTrangThai != 3 AND bn.maTrangThai != 2 AND trangThaiXoa = 0";

        $sSQL .= " ORDER BY bn.ngayTao ASC";

        $result = $this->dbsql->query($sSQL);
        $arrList = [];
        $i = 0;
        while ($row = $this->dbsql->fetch_Array($result)) {
            $arrList[$i] = $this->setBenhNhan($row);
            $i++;
        }
        return $arrList;
    }
    function getListBNCho()
    {

        $sSQL = "SELECT * FROM benhnhan as bn LEFT JOIN trangthai as tt ON bn.maTrangThai = tt.maTrangThai WHERE bn.maTrangThai = 2 AND trangThaiXoa = 0";

        $sSQL .= " ORDER BY bn.ngayGoiMoiNhat ASC";

        $result = $this->dbsql->query($sSQL);
        $arrList = [];
        $i = 0;
        while ($row = $this->dbsql->fetch_Array($result)) {
            $arrList[$i] = $this->setBenhNhan($row);
            $i++;
        }
        return $arrList;

    }
    public function getBenhNhan($_id)
    {
        $sql = "SELECT * FROM benhnhan WHERE id = $_id";
        $this->dbsql->query($sql);

        if ($this->dbsql->num_rows() > 0) {
            $result = $this->dbsql->fetch_array();
            return $this->setBenhNhan($result);
        }
        return false;
    }
    public function getBNId($_id)
    {
        $sql = "SELECT * FROM benhnhan WHERE id = $_id";
        $result = $this->dbsql->query($sql);

        return $this->dbsql->fetch_array($result);

    }
    function save($_benhnhan)
    {
        if (empty($_benhnhan->get("id"))) {
            $sql = "INSERT INTO `benhnhan` (`maBN`,`tenBN`,`namSinh`,`gioiTinh`,`chuanDoan`,`ngayTao`,`maTrangThai`,`bacSi`) 
					VALUES (
                        '" . $_benhnhan->get("maBN") . "',
                        '" . $_benhnhan->get("tenBN") . "',
                        '" . $_benhnhan->get("namSinh") . "',
                        '" . $_benhnhan->get("gioiTinh") . "',
                        '" . $_benhnhan->get("chuanDoan") . "',
                        '" . $_benhnhan->get("ngayTao") . "',
                        '" . $_benhnhan->get("maTrangThai") . "',
                        '" . $_benhnhan->get("bacSi") . "')";
        } else {
            $sql = "UPDATE `benhnhan` 
            SET 
            `maBN` = '" . $_benhnhan->get("maBN") . "',
            `tenBN` = '" . $_benhnhan->get("tenBN") . "',
            `namSinh` = '" . $_benhnhan->get("namSinh") . "',
            `gioiTinh` = '" . $_benhnhan->get("gioiTinh") . "',
            `chuanDoan` = '" . $_benhnhan->get("chuanDoan") . "',
             `ngayTao` = '" . $_benhnhan->get("ngayTao") . "',
             `maTrangThai` = '" . $_benhnhan->get("maTrangThai") . "',
             `bacSi` = '" . $_benhnhan->get("bacSi") . "'
			WHERE `id` = '" . $_benhnhan->get("id") . "'";
        }
        $this->setLog($_benhnhan);
        $this->dbsql->query($sql);

        return ($this->dbsql->insert_id() == 0) ? $_benhnhan->get("id") : $this->dbsql->insert_id();
    }
    function doiTrangThaiChuaKham($_benhNhanID)
    {
        $benhNhan = $this->getBNId($_benhNhanID);

        if (!empty($_benhNhanID)) {
            $sql = "UPDATE `benhNhan` SET  `maTrangThai` = '1' WHERE `id` = '" . $_benhNhanID . "'";
            $this->benhnhan->set("id", $_benhNhanID);
            $this->benhnhan->set("maTrangThai", 1);
            $this->benhnhan->set("tenBN", $benhNhan['tenBN']);
            $this->benhnhan->set("namSinh", $benhNhan['namSinh']);
            $this->benhnhan->set("gioiTinh", $benhNhan['gioiTinh']);
            $this->benhnhan->set("bacSi", $benhNhan['bacSi']);
            $this->benhnhan->set("ngayTao", $benhNhan['ngayTao']);
            $this->setLog($this->benhnhan, "Đổi trạng thái");
            $this->dbsql->query($sql);

            return ($this->dbsql->insert_id() == 0) ? $_benhNhanID : $this->dbsql->insert_id();

        }
        return false;

    }
    function doiTrangThaiDaKham($_benhNhanID)
    {
        $benhNhan = $this->getBNId($_benhNhanID);
        if (!empty($_benhNhanID)) {
            $sql = "UPDATE `benhnhan` 
            SET 
             `maTrangThai` = '" . "3" . "'
			WHERE `id` = '" . $_benhNhanID . "'";
        }
        $this->benhnhan->set("id", $_benhNhanID);
        $this->benhnhan->set("maTrangThai", 3);
        $this->benhnhan->set("maBN", $benhNhan['maBN']);
        $this->benhnhan->set("tenBN", $benhNhan['tenBN']);
        $this->benhnhan->set("namSinh", $benhNhan['namSinh']);
        $this->benhnhan->set("gioiTinh", $benhNhan['gioiTinh']);
        $this->benhnhan->set("bacSi", $benhNhan['bacSi']);
        $this->benhnhan->set("ngayTao", $benhNhan['ngayTao']);
        $this->benhnhan->set("trangThaiXoa", $benhNhan['trangThaiXoa']);
        $this->benhnhan->set("ngayGoi", $benhNhan['ngayGoi']);
        $this->setLog($this->benhnhan, "Đổi trạng thái");
        $this->dbsql->query($sql);

        return ($this->dbsql->insert_id() == 0) ? $_benhNhanID : $this->dbsql->insert_id();
    }
    function doiTrangThaiChoKham($_benhNhanID, $quay)
    {
        $ngayHienTai = date('Y-m-d H:i:s');
        $benhNhan = $this->getBNId($_benhNhanID);
        if (!empty($_benhNhanID)) {
            if ($benhNhan['ngayGoi'] != null) {
                $sql = "UPDATE `benhnhan` 
                SET 
                 `maTrangThai` = '" . "2" . "',  `ngayGoiMoiNhat` = '$ngayHienTai',  `quayTiepNhan` = '$quay'
                WHERE `id` = '" . $_benhNhanID . "'";

                $this->benhnhan->set("id", $_benhNhanID);
                $this->benhnhan->set("maBN", $benhNhan['maBN']);
                $this->benhnhan->set("maTrangThai", $benhNhan['maTrangThai']);
                $this->benhnhan->set("tenBN", $benhNhan['tenBN']);
                $this->benhnhan->set("ngayGoi", $benhNhan["ngayGoi"]);
                $this->benhnhan->set("ngayGoiMoiNhat", $ngayHienTai);
                $this->benhnhan->set("namSinh", $benhNhan['namSinh']);
                $this->benhnhan->set("gioiTinh", $benhNhan['gioiTinh']);
                $this->benhnhan->set("trangThaiXoa", $benhNhan['trangThaiXoa']);
                $this->benhnhan->set("bacSi", $benhNhan['bacSi']);
                $this->benhnhan->set("quayTiepNhan", $quay);
                $this->benhnhan->set("ngayTao", $benhNhan['ngayTao']);
                $this->setLog($this->benhnhan, "Đổi trạng thái");
            } else {
                $sql = "UPDATE `benhnhan` 
                SET 
                 `maTrangThai` = '" . "2" . "', `ngayGoi` = '$ngayHienTai', `ngayGoiMoiNhat` = '$ngayHienTai',`quayTiepNhan` = '$quay'
                WHERE `id` = '" . $_benhNhanID . "' AND `ngayGoi` IS NULL";

                $this->benhnhan->set("id", $_benhNhanID);
                $this->benhnhan->set("maBN", $benhNhan['maBN']);
                $this->benhnhan->set("maTrangThai", 2);
                $this->benhnhan->set("tenBN", $benhNhan['tenBN']);
                $this->benhnhan->set("ngayGoi", $ngayHienTai);
                $this->benhnhan->set("ngayGoiMoiNhat", $ngayHienTai);
                $this->benhnhan->set("namSinh", $benhNhan['namSinh']);
                $this->benhnhan->set("gioiTinh", $benhNhan['gioiTinh']);
                $this->benhnhan->set("trangThaiXoa", $benhNhan['trangThaiXoa']);
                $this->benhnhan->set("quayTiepNhan", $quay);
                $this->benhnhan->set("bacSi", $benhNhan['bacSi']);
                $this->benhnhan->set("ngayTao", $benhNhan['ngayTao']);
                $this->setLog($this->benhnhan, "Đổi trạng thái");
            }
        }
        $this->dbsql->query($sql);
        return ($this->dbsql->insert_id() == 0) ? $_benhNhanID : $this->dbsql->insert_id();
    }
    function deleteBenhNhan($id)
    {
        // $this->getListBN()
        $this->benhnhan->set("id", $id);
        $listBN = $this->getBNId($id);
        $this->benhnhan->set("trangThaiXoa", 1);
        $this->benhnhan->set("maBN", $listBN["maBN"]);
        $this->benhnhan->set("tenBN", $listBN["tenBN"]);
        $this->benhnhan->set("ngayTao", $listBN["ngayTao"]);
        $this->setLog($this->benhnhan, "Xóa bệnh nhân");
        $sSQL = "UPDATE `benhnhan` 
                SET 
                 `trangThaiXoa` = '" . "1" . "'
                WHERE `id` = '" . $id . "'";
        $this->dbsql->query($sSQL);
    }
}