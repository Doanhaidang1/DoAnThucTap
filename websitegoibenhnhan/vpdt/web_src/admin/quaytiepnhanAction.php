<?
require_once ("web_src/bean/QuayTiepNhan.php");
require_once ("web_src/bean/QuayTIepNhanPeer.php");
class quaytiepnhanAction
{
    var $request;
    var $quaytiepnhanpeer;
    var $quaytiepnhan;
    public static $listRole = "quaytiepnhan,saveQuayTiepNhan,deleteQuayTiepNhan";

    public function __construct()
    {
        $this->request = new Request;
        $this->quaytiepnhanpeer = new QuayTiepNhanPeer;
        $this->quaytiepnhan = new QuayTiepNhan;
    }
    function index()
    {
        $this->request->setAttribute('script', '<script src="' . _DEFAULT_URL_ . 'js/quaytiepnhan.js?' . _DEFAULT_VERSION_JS_CSS_ . '"></script>');
        $this->request->setModel("www/admin/quaytiepnhan/quaytiepnhan.htm");
        return true;
    }

    function getData()
    {
        $arrNQ = $this->quaytiepnhanpeer->getListQuay();
        $data["data"] = $arrNQ;
        $myJSON = json_encode($data);

        return $this->request->json_response($myJSON);
    }
    function saveQuayTiepNhan()
    {
        $Id = ($this->request->getParameter("id") != "") ? $this->request->getParameter("id") : 0;
        $data = $this->request->getParameter("data", true);
        $arrayData = json_decode($data, true);
        if (empty($arrayData)) {
            $message = new Message();
            $message->set("flag", false);
            $message->set("errorMessage", "Bạn chưa sửa dữ liệu gì trên dòng này. Vui lòng sửa trước khi lưu.");
            $response["message"] = $message;

            $myJSON = json_encode($response);
            return $this->request->json_response($myJSON);
        }
        if (!empty($arrayData)) {
            if (empty($Id)) {
                $this->quaytiepnhan->set("maQuay", $Id);
                $this->quaytiepnhan->set("tenQuayTiepNhan", $arrayData[0]);
                $id = $this->quaytiepnhanpeer->save($this->quaytiepnhan);
            } else {
                $this->quaytiepnhan->set("maQuay", $Id);
                $this->quaytiepnhan->set("tenQuayTiepNhan", $arrayData[0]);
                $id = $this->quaytiepnhanpeer->save($this->quaytiepnhan);

            }
            $message = new Message();
            $message->set("flag", true);
            $message->set("succesMessage", "Cập nhật quầy tiếp nhận thành công");

            $response["id"] = $id;
            $response["message"] = $message;

            $myJSON = json_encode($response);
            return $this->request->json_response($myJSON);
        }
        return false;

    }
    function deleteQuayTiepNhan()
    {
        $Id = ($this->request->getParameter("id") != "") ? $this->request->getParameter("id") : 0;
        $message = new Message();
        try {
            $this->quaytiepnhanpeer->deleteQuayTiepNhan($Id);
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) {
                $message->set("flag", false);
                $message->set("errorMessage", "Không thể xóa quầy vì còn bệnh nhân liên quan đến quầy này tồn tại.");
                $response["message"] = $message;

                $myJSON = json_encode($response);
                return $this->request->json_response($myJSON);
            } else {
                $message->set("flag", false);
                $message->set("errorMessage", "Đã có lỗi khi xóa quầy tiếp nhận.");
                $response["message"] = $message;

                $myJSON = json_encode($response);
                return $this->request->json_response($myJSON);
            }
        }

        $myJSON = json_encode(true);
        return $this->request->json_response($myJSON);
    }
}
?>