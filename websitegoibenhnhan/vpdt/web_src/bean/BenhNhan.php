<?
class BenhNhan
{
    var $id;
    var $maBN;
    var $tenBN;
    var $namSinh;
    var $gioiTinh;
    var $chuanDoan;
    var $ngayTao;
    var $maTrangThai;
    var $bacSi;
    var $trangThaiXoa;
    var $ngayGoi;
    var $ngayGoiMoiNhat;
    var $tenTrangThai;
    var $quayTiepNhan;

    function __construct()
    {
        $this->id = 0;
        $this->maBN = "";
        $this->tenBN = "";
        $this->namSinh = 0;
        $this->gioiTinh = "";
        $this->chuanDoan = "";
        $this->ngayTao = null;
        $this->maTrangThai = 0;
        $this->bacSi = "";
        $this->trangThaiXoa = 0;
        $this->ngayGoi = null;
        $this->ngayGoiMoiNhat = null;
        // $this->tenBacSi = "";
        $this->tenTrangThai = "";
        $this->quayTiepNhan = null;

    }
    function set($key, $value)
    {
        $this->$key = $value;
    }
    function get($key)
    {
        return $this->$key;
    }
}