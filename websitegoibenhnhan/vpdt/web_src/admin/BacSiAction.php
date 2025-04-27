<?php
require_once ("web_src/bean/BacSiPeer.php");
require_once ("web_src/bean/BacSi.php");
require_once ("web_src/bean/KhoaPhong.php");
require_once ("web_src/bean/KhoaPhongPeer.php");

class BacSiAction
{
    var $request;
    var $BacSiPeer;
    var $KhoaPhongPeer;
    public static $listRole = "bacsi,saveBacSi,deleteBacSi";

    public function __construct()
    {
        $this->request = new Request;
        $this->BacSiPeer = new BacSiPeer;
        $this->KhoaPhongPeer = new KhoaPhongPeer;
    }

    function index()
    {
        $this->request->setAttribute('script', '<script src="' . _DEFAULT_URL_ . 'js/bacsi.js?' . _DEFAULT_VERSION_JS_CSS_ . '"></script>');
        $this->request->setAttribute('css', '<link href="' . _DEFAULT_URL_ . 'css/style.css?' . _DEFAULT_VERSION_JS_CSS_ . '" rel="stylesheet">');

        $listKP = $this->KhoaPhongPeer->getListKhoaPhong();
        $this->request->setAttribute("listKP", $listKP);

        $this->request->setModel("www/admin/bacsi.htm");
        return true;
    }

    function getData()
    {
        $arrBS = $this->BacSiPeer->getListBacSi();
        $data["data"] = $arrBS;
        $myJSON = json_encode($data);
        return $this->request->json_response($myJSON);
    }

    function saveBacSi()
    {
        $bsId = ($this->request->getParameter("id") != "") ? $this->request->getParameter("id") : 0;
        $data = $this->request->getParameter("data", true);
        $arrayData = json_decode($data, true);
        // if (!preg_match('/^[a-zA-ZÀ-ỹĂăÂâĐđÊêÔôƠơƯư0-9\s\']+$/u', $arrayData[0])) {
        //     $message = new Message();
        //     $message->set("flag", false);
        //     $message->set("errorMessage", "Tên bác sĩ chỉ được nhập chữ và số. Vui lòng nhập lại.");
        //     $response["message"] = $message;

        //     $myJSON = json_encode($response);
        //     return $this->request->json_response($myJSON);
        // }
        // if (!in_array($arrayData[1], ["Nam", "Nữ"])) {
        //     $message = new Message();
        //     $message->set("flag", false);
        //     $message->set("errorMessage", "Giới tính bạn chọn không có trong dữ liệu. Vui lòng nhập lại.");
        //     $response["message"] = $message;

        //     $myJSON = json_encode($response);
        //     return $this->request->json_response($myJSON);
        // }
        if (empty($arrayData)) {
            $message = new Message();
            $message->set("flag", false);
            $message->set("errorMessage", "Bạn chưa sửa gì trên dòng này");

            $response["id"] = $bsId;
            $response["message"] = $message;

            $myJSON = json_encode($response);
            return $this->request->json_response($myJSON);
        }
        if ($arrayData[2] !== '' && !preg_match('/^\d{10}$/', $arrayData[2])) {
            $message = new Message();
            $message->set("flag", false);
            $message->set("errorMessage", "Số điện thoại chỉ nhập 10 số. Vui lòng nhập lại.");
            $response["message"] = $message;

            $myJSON = json_encode($response);
            return $this->request->json_response($myJSON);
        }
        if (!preg_match('/^[0-9]*$/', $arrayData[3])) {
            $message = new Message();
            $message->set("flag", false);
            $message->set("errorMessage", "Mã khoa phòng chỉ được nhập số. Vui lòng nhập lại.");
            $response["message"] = $message;

            $myJSON = json_encode($response);
            return $this->request->json_response($myJSON);
        }
        if ($arrayData[0] != "") {
            $bacsi = new BacSi;
            $bacsi->set("MaBacSi", $bsId);
            $bacsi->set("TenBacSi", $arrayData[0]);
            $bacsi->set("GioiTinh", $arrayData[1]);
            $bacsi->set("soDienThoai", $arrayData[2]);
            $bacsi->set("MaKhoaPhong", $arrayData[3]);
            // $bacsi->set("Avatar", $arrayData[4]);

            $id = $this->BacSiPeer->save($bacsi);

            $message = new Message();
            $message->set("flag", true);
            $message->set("succesMessage", "Cập nhật thông tin bác sĩ thành công");

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

    function deleteBacSi()
    {
        $bacSiId = ($this->request->getParameter("id") != "") ? $this->request->getParameter("id") : 0;
        $message = new Message();
        try {
            $this->BacSiPeer->deleteBacSi($bacSiId);
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) {
                $message->set("flag", false);
                $message->set("errorMessage", "Không thể xóa bác sĩ vì còn bệnh nhân liên quan đến bác sĩ này tồn tại.");
                $response["message"] = $message;

                $myJSON = json_encode($response);
                return $this->request->json_response($myJSON);
            } else {
                $message->set("flag", false);
                $message->set("errorMessage", "Đã có lỗi khi xóa bác sĩ.");
                $response["message"] = $message;

                $myJSON = json_encode($response);
                return $this->request->json_response($myJSON);
            }
        }
        $myJSON = json_encode(true);
        return $this->request->json_response($myJSON);
    }
    function getListTenPhongKhoa()
    {
        $tenPhongKhoaList = $this->KhoaPhongPeer->getListTenPhongKhoa();
        $response = array("data" => $tenPhongKhoaList);
        return $this->request->json_response(json_encode($response));
    }




}
?>