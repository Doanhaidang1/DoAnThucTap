<?
require_once ('web_src/common/IOFactory.php');
require_once ("web_src/bean/hangPeer.php");
require_once ("web_src/bean/khoPeer.php");

class DSchitiet
{
    var $request;
    var $hangPeer;
    public static $listRole = "DSchitiet";
    public function __construct()
    {
        $this->request = new Request;
        $this->hangPeer = new hangPeer();
        $this->request->setTitle("DS chi tiết");
    }
    function index()
    {
        $this->request->setAttribute('script', '<script src="' . _DEFAULT_URL_ . 'js/chitiet.js?' . _DEFAULT_VERSION_JS_CSS_ . '"></script>');

        $khoPeer = new khoPeer;
        $listkho = $khoPeer->getkhoID();


        $this->request->setAttribute("listkho", $listkho);

        $this->request->setModel("www/admin/qlvaccine/datiem.htm");
        return true;
    }
}
?>