<?php
require_once ("web_src/bean/KhoaPhongPeer.php");
require_once ("web_src/bean/KhoaPhong.php");

class KhoaPhongAction
{
    var $request;
    var $khoaphongpeer;
    public static $listRole = "khoaphong,saveKhoaPhong,deleteKhoaPhong";

    public function __construct()
    {
        $this->request = new Request;
        $this->khoaphongpeer = new KhoaPhongPeer;
    }

    function index()
    {
        $this->request->setAttribute('script', '<script src="' . _DEFAULT_URL_ . 'js/khoaphong.js?' . _DEFAULT_VERSION_JS_CSS_ . '"></script>');


        $this->request->setModel("www/admin/khoaphong.htm");
        return true;
    }

    function getData()
    {
        $arrKP = $this->khoaphongpeer->getListKhoaPhong();
        $data["data"] = $arrKP;
        $myJSON = json_encode($data);
        return $this->request->json_response($myJSON);
    }

    function saveKhoaPhong()
    {
        $kpId = ($this->request->getParameter("id") != "") ? $this->request->getParameter("id") : 0;
        $data = $this->request->getParameter("data", false);
        $arrayData = json_decode($data, true);
        if (empty($arrayData)) {
            $message = new Message();
            $message->set("flag", false);
            $message->set("errorMessage", "Bạn chưa sửa gì trên dòng này");

            $response["id"] = $kpId;
            $response["message"] = $message;

            $myJSON = json_encode($response);
            return $this->request->json_response($myJSON);
        }
        // if (!preg_match('/^[a-zA-ZÀ-ỹĂăÂâĐđÊêÔôƠơƯư0-9\s]+$/u', $arrayData[0])) {
        //     $message = new Message();
        //     $message->set("flag", false);
        //     $message->set("errorMessage", "Tên khoa phòng chỉ được nhập chữ và số. Vui lòng nhập lại.");
        //     $response["message"] = $message;

        //     $myJSON = json_encode($response);
        //     return $this->request->json_response($myJSON);
        // }
        if ($arrayData[0] != "") {
            $khoaphong = new KhoaPhong;
            $khoaphong->set("MaKhoaPhong", $kpId);
            $khoaphong->set("TenKhoaPhong", $arrayData[0]);

            $id = $this->khoaphongpeer->save($khoaphong);

            $message = new Message();
            $message->set("flag", true);
            $message->set("succesMessage", "Cập nhật thông tin khoa/phòng thành công");

            $response["id"] = $id;
            $response["message"] = $message;

            $myJSON = json_encode($response);
            return $this->request->json_response($myJSON);
        }

        $message = new Message();
        $message->set("flag", false);
        $message->set("errorMessage", "");

        $response["message"] = $message;

        $myJSON = json_encode($response);
        return $this->request->json_response($myJSON);
    }

    function deleteKhoaPhong()
    {
        $kpId = ($this->request->getParameter("id") != "") ? $this->request->getParameter("id") : 0;
        $message = new Message();
        try {
            $this->khoaphongpeer->deleteKhoaPhong($kpId);
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) {
                $message->set("flag", false);
                $message->set("errorMessage", "Không thể xóa khoa phòng vì còn bác sĩ liên quan đến khoa phòng này tồn tại.");
                $response["message"] = $message;

                $myJSON = json_encode($response);
                return $this->request->json_response($myJSON);
            } else {
                $message->set("flag", false);
                $message->set("errorMessage", "Đã có lỗi khi xóa khoa phòng.");
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