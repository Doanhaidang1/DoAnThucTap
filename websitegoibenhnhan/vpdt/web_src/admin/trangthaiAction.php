<?
require_once ("web_src/bean/TrangThaiPeer.php");
require_once ("web_src/bean/TrangThai.php");
class trangthaiAction
{
    var $request;
    var $trangthaipeer;
    var $trangthai;
    public static $listRole = "trangthai,saveTrangThai,deleteTrangThai";

    public function __construct()
    {
        $this->request = new Request;
        $this->trangthaipeer = new TrangThaiPeer;
        $this->trangthai = new TrangThai;
    }
    function index()
    {
        //<script src="http://localhost/vpdt/js/trangthai.js?1"></script>
        $this->request->setAttribute('script', '<script src="' . _DEFAULT_URL_ . 'js/trangthai.js?' . _DEFAULT_VERSION_JS_CSS_ . '"></script>');
        $this->request->setModel("www/admin/trangthai/trangthai.htm");
        return true;
    }

    function getData()
    {
        $arrNQ = $this->trangthaipeer->getListTT();
        $data["data"] = $arrNQ;
        $myJSON = json_encode($data);

        return $this->request->json_response($myJSON);
    }
    function saveTrangThai()
    {
        $ttId = ($this->request->getParameter("id") != "") ? $this->request->getParameter("id") : 0;
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
        // if (!preg_match('/^[a-zA-ZÀ-ỹĂăÂâĐđÊêÔôƠơƯư0-9\s]+$/u', $arrayData[0])) {
        //     $message = new Message();
        //     $message->set("flag", false);
        //     $message->set("errorMessage", "Tên trạng thái chỉ được nhập chữ và số. Vui lòng nhập lại.");
        //     $response["message"] = $message;

        //     $myJSON = json_encode($response);
        //     return $this->request->json_response($myJSON);
        // }
        if (!empty($arrayData)) {
            if (empty($ttId)) {
                $this->trangthai->set("maTrangThai", $ttId);
                $this->trangthai->set("tenTrangThai", $arrayData[0]);
                $id = $this->trangthaipeer->save($this->trangthai);
            } else {
                $this->trangthai->set("maTrangThai", $ttId);
                $this->trangthai->set("tenTrangThai", $arrayData[0]);
                $id = $this->trangthaipeer->save($this->trangthai);

            }
            $message = new Message();
            $message->set("flag", true);
            $message->set("succesMessage", "Cập nhật trạng thái thành công");

            $response["id"] = $id;
            $response["message"] = $message;

            $myJSON = json_encode($response);
            //echo $myJSON;
            return $this->request->json_response($myJSON);
        }
        return false;

    }
    function deleteTrangThai()
    {
        $trangthaiId = ($this->request->getParameter("id") != "") ? $this->request->getParameter("id") : 0;
        $message = new Message();
        try {
            $this->trangthaipeer->deleteTrangThai($trangthaiId);
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) {
                $message->set("flag", false);
                $message->set("errorMessage", "Không thể xóa trạng thái vì còn bệnh nhân liên quan đến trạng thái này tồn tại.");
                $response["message"] = $message;

                $myJSON = json_encode($response);
                return $this->request->json_response($myJSON);
            } else {
                $message->set("flag", false);
                $message->set("errorMessage", "Đã có lỗi khi xóa trạng thái.");
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