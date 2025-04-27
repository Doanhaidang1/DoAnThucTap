<?php
class BacSi
{
    var $MaBacSi;
    var $TenBacSi;
    var $GioiTinh;
    var $soDienThoai;
    var $MaKhoaPhong;
    // var $Avatar; 
    function BacSi()
    {
        $this->MaBacSi = 0;
        $this->TenBacSi = "";
        $this->GioiTinh = "";
        $this->soDienThoai = "";
        $this->MaKhoaPhong = 0;
        // $this->Avatar="";
    }

    function setBacSi($key, $value)
    {
        $this->$key = $value;
    }

    function getBacSi($key)
    {
        return $this->$key;
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
?>