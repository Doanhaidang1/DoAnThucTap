<?
class QuayTiepNhan
{
    var $maQuay;
    var $tenQuayTiepNhan;
    function __construct()
    {
        $this->maQuay = 0;
        $this->tenQuayTiepNhan = "";
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