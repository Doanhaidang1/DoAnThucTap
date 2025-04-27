<?
class TrangThai
{
    var $maTrangThai;
    var $tenTrangThai;
    function __construct()
    {
        $this->maTrangThai = 0;
        $this->tenTrangThai = "";
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