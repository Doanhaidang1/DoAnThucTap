<?
require_once ("web_src/bean/BenhNhanPeer.php");
require_once ("web_src/bean/TrangThaiPeer.php");
require_once ("web_src/bean/BacSiPeer.php");
require_once ("web_src/bean/BenhNhan.php");
class benhnhanAction
{
    var $request;
    var $benhnhanpeer;
    var $bacsipeer;
    var $trangthaipeer;
    var $message;
    public static $listRole = "benhnhan,saveBenhNhan,deleteBenhNhan";

    public function __construct()
    {
        $this->request = new Request;
        $this->benhnhanpeer = new BenhNhanPeer;
        $this->bacsipeer = new BacSiPeer;
        $this->trangthaipeer = new TrangThaiPeer;
    }
    function index()
    {
        $this->request->setAttribute('script', '<script src="' . _DEFAULT_URL_ . 'js/benhnhan.js?' . _DEFAULT_VERSION_JS_CSS_ . '"></script>');
        $this->request->setAttribute('css', '<link href="' . _DEFAULT_URL_ . 'css/style.css?' . _DEFAULT_VERSION_JS_CSS_ . '" rel="stylesheet">');

        $listTT = $this->trangthaipeer->getListTT();
        $listBS = $this->bacsipeer->getListBacSi();
        $this->request->setAttribute("listTT", $listTT);
        $this->request->setModel("www/admin/benhnhan/qlbenhnhan.html");
        return true;
    }
    function getData()
    {

        $arrBN = $this->benhnhanpeer->getListBN();
        $data["data"] = $arrBN;
        $myJSON = json_encode($data);

        return $this->request->json_response($myJSON);
    }

    function getTenBacSi()
    {
        $data = $this->request->getParameter("search", false);
        $arrTenBS = $this->bacsipeer->getListTenBacSi($data);
        $myJSON = json_encode($arrTenBS);
        return $this->request->json_response($myJSON);
    }

    function saveBenhNhan()
    {
        $bnId = ($this->request->getParameter("id") != "") ? $this->request->getParameter("id") : 0;
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
        $benhnhan = new BenhNhan;
        if (strlen($arrayData[0]) != 8) {
            $message = new Message();
            $message->set("flag", false);
            $message->set("errorMessage", "Mã bệnh nhân chưa nhập đủ 8 số. Vui lòng nhập lại.");
            $response["message"] = $message;

            $myJSON = json_encode($response);
            return $this->request->json_response($myJSON);
        }
        if (!preg_match('/^[0-9]+$/', $arrayData[0])) {
            $message = new Message();
            $message->set("flag", false);
            $message->set("errorMessage", "Mã bệnh nhân chỉ được nhập số. Vui lòng nhập lại.");
            $response["message"] = $message;

            $myJSON = json_encode($response);
            return $this->request->json_response($myJSON);
        }
        if (!in_array($arrayData[3], ["Nam", "Nữ"])) {
            $message = new Message();
            $message->set("flag", false);
            $message->set("errorMessage", "Giới tính bạn chọn không có trong dữ liệu. Vui lòng nhập lại.");
            $response["message"] = $message;
            $myJSON = json_encode($response);
            return $this->request->json_response($myJSON);
        }

        if (!preg_match('/^[0-9]*$/', $arrayData[2])) {
            $message = new Message();
            $message->set("flag", false);
            $message->set("errorMessage", "Năm sinh chỉ được nhập số. Vui lòng nhập lại.");
            $response["message"] = $message;

            $myJSON = json_encode($response);
            return $this->request->json_response($myJSON);
        }
        if (empty($bnId)) {
            $arrBN = $this->benhnhanpeer->getListBN();
            foreach ($arrBN as $item) {
                if ($item->get('maBN') == $arrayData[0]) {
                    if ($item->get('maTrangThai') != 3) {
                        $message = new Message();
                        $message->set("flag", false);
                        $message->set("errorMessage", "Mã bệnh nhân bạn vừa nhập đã bị trùng. Vui lòng nhập một mã khác.");
                        $response["message"] = $message;

                        $myJSON = json_encode($response);
                        return $this->request->json_response($myJSON);
                    }
                }

            }
            $ngayHienTai = date('Y-m-d H:i:s');
            $benhnhan->set("maBN", $arrayData[0]);
            $benhnhan->set("tenBN", $arrayData[1]);
            $benhnhan->set("namSinh", $arrayData[2]);
            $benhnhan->set("gioiTinh", $arrayData[3]);
            $benhnhan->set("chuanDoan", $arrayData[4]);
            $benhnhan->set("bacSi", $arrayData[5]);
            $benhnhan->set("ngayTao", $ngayHienTai);
            $benhnhan->set("maTrangThai", $arrayData[6]);
            $id = $this->benhnhanpeer->save($benhnhan);
        } else {
            $benhNhanID = $this->benhnhanpeer->getBNId($bnId);
            $arrBN = $this->benhnhanpeer->getListBN();

            foreach ($arrBN as $item) {
                if ($item->get('maBN') == $arrayData[0]) {
                    if ($benhNhanID['maBN'] != $arrayData[0]) {
                        $message = new Message();
                        $message->set("flag", false);
                        $message->set("errorMessage", "Mã bệnh nhân bạn vừa nhập đã bị trùng. Vui lòng nhập mã khác.");
                        $response["message"] = $message;
                        $myJSON = json_encode($response);
                        return $this->request->json_response($myJSON);
                    }
                }
            }
            $benhnhan->set("id", $bnId);
            $benhnhan->set("maBN", $arrayData[0]);
            $benhnhan->set("tenBN", $arrayData[1]);
            $benhnhan->set("namSinh", $arrayData[2]);
            $benhnhan->set("gioiTinh", $arrayData[3]);
            $benhnhan->set("chuanDoan", $arrayData[4]);
            $benhnhan->set("ngayTao", $benhNhanID["ngayTao"]);
            $benhnhan->set("bacSi", $arrayData[5]);
            $benhnhan->set("maTrangThai", $arrayData[6]);
            $benhnhan->set("ngayGoi", $benhNhanID['ngayGoi']);
            $id = $this->benhnhanpeer->save($benhnhan);

        }

        $message = new Message();
        $message->set("flag", true);
        $message->set("succesMessage", "Cập nhật bệnh nhân thành công");

        $response["id"] = $id;
        $response["message"] = $message;

        $myJSON = json_encode($response);
        return $this->request->json_response($myJSON);
    }

    function deleteBenhNhan()
    {
        $benhNhanId = ($this->request->getParameter("id") != "") ? $this->request->getParameter("id") : 0;

        $this->benhnhanpeer->deleteBenhNhan($benhNhanId);

        $myJSON = json_encode(true);
        return $this->request->json_response($myJSON);
    }


}
