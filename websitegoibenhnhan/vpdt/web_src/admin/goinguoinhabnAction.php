<?
require_once ("web_src/bean/BenhNhanPeer.php");
require_once ("web_src/bean/BenhNhan.php");
require_once ("web_src/bean/TrangThaiPeer.php");

class goinguoinhabnAction
{
    var $request;
    var $benhnhanpeer;
    var $trangthaipeer;

    public function __construct()
    {
        $this->request = new Request;
        $this->benhnhanpeer = new BenhNhanPeer;
        $this->trangthaipeer = new TrangThaiPeer;

    }
    function index()
    {
        $script = '<script src="' . _DEFAULT_URL_ . 'js/danhsachgoi.js?' . _DEFAULT_VERSION_JS_CSS_ . '"></script>';
        $script .= '<script src="' . _DEFAULT_URL_ . 'js/danhsachcho.js?' . _DEFAULT_VERSION_JS_CSS_ . '"></script>';

        $listTT = $this->trangthaipeer->getListTT();
        $this->request->setAttribute("listTT", $listTT);
        $this->request->setAttribute('script', $script);
        $this->request->setModel("www/admin/goi/goinguoinhabn.htm");
        return true;
    }
    function getDataGoi()
    {
        $arrNQ = $this->benhnhanpeer->getListBNGoi();

        $data["data"] = $arrNQ;
        $myJSON = json_encode($data);

        return $this->request->json_response($myJSON);
    }
    function getDataCho()
    {
        $arrBN = $this->benhnhanpeer->getListBNCho();

        $data["data"] = $arrBN;
        $myJSON = json_encode($data);

        return $this->request->json_response($myJSON);
    }
    function doiTrangThaiChuaKham()
    {
        $benhNhanID = ($this->request->getParameter("id") != "") ? $this->request->getParameter("id") : 0;
        if (!empty($benhNhanID)) {
            $this->benhnhanpeer->doiTrangThaiChuaKham($benhNhanID);
            $message = new Message();
            $message->set("flag", true);
            $message->set("succesMessage", "Cập nhật bệnh nhân thành công");

            $response["id"] = $benhNhanID;
            $response["message"] = $message;

            $myJSON = json_encode($response);
            return $this->request->json_response($myJSON);
        }
        return false;
    }
    function doiTrangThaiChoKham()
    {
        $bnId = ($this->request->getParameter("id") != "") ? $this->request->getParameter("id") : 0;
        $quay = ($this->request->getParameter("msg") != "") ? $this->request->getParameter("msg") : null;
        $benhNhan = $this->benhnhanpeer->getBNId($bnId);
        $ngayHienTai = new DateTime();
        if (!empty($bnId)) {
            if ($benhNhan && isset($benhNhan['ngayGoi'])) {
                $ngayGoi = new DateTime($benhNhan['ngayGoi']);
                $interval = $ngayHienTai->diff($ngayGoi);
                $hours = $interval->h + ($interval->days * 24);

                if ($hours >= 2) {
                    $this->benhnhanpeer->doiTrangThaiDaKham($bnId);
                    $benhNhanMoi = $this->benhnhanpeer->getBenhNhan($bnId);
                    if (!empty($benhNhanMoi)) {
                        $benhNhanMoi->set('id', '');
                        $benhNhanMoi->set('maTrangThai', '1');
                        $benhNhanMoi->set('ngayTao', date('Y-m-d H:i:s'));
                        $this->benhnhanpeer->save($benhNhanMoi);
                    }
                    $message = new Message();
                    $message->set("flag", false);
                    $message->set("errorMessage", "Hiện đã hết thời gian hiệu lực, hệ thống đã thêm mới lại bệnh nhân!");

                    $response["id"] = $bnId;
                    $response["message"] = $message;

                    $myJSON = json_encode($response);
                    return $this->request->json_response($myJSON);
                }
            }
            $this->benhnhanpeer->doiTrangThaiChoKham($bnId, $quay);
            $message = new Message();
            $message->set("flag", true);
            $message->set("succesMessage", "Cập nhật bệnh nhân thành công");

            $response["id"] = $bnId;
            $response["message"] = $message;

            $myJSON = json_encode($response);
            //echo $myJSON;
            return $this->request->json_response($myJSON);
        }
        return false;


    }
    function doiTrangThaiDaKham()
    {

        $bnId = ($this->request->getParameter("id") != "") ? $this->request->getParameter("id") : 0;
        $benhNhan = $this->benhnhanpeer->getBNId($bnId);

        if (!empty($bnId)) {
            if ($benhNhan['ngayGoi'] !== null) {
                $id = $this->benhnhanpeer->doiTrangThaiDaKham($bnId);
                $message = new Message();
                $message->set("flag", true);
                $message->set("succesMessage", "Cập nhật bệnh nhân thành công");

                $response["id"] = $id;
                $response["message"] = $message;

                $myJSON = json_encode($response);
                //echo $myJSON;
                return $this->request->json_response($myJSON);
            } else {
                $message = new Message();
                $message->set("flag", false);
                $message->set("errorMessage", "Bạn hãy nhấn gọi trước khi kết thúc");
                $response["message"] = $message;

                $myJSON = json_encode($response);
                return $this->request->json_response($myJSON);
            }
        }
        return false;


    }

}
?>