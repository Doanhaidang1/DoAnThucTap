<?PHP
require_once("web_src/bean/hangPeer.php");
require_once("web_src/bean/ChucNangPeer.php");
require_once("web_src/bean/khoPeer.php");
// require_once("web_src/bean/hangPeer.php");


class hangAction {	
	var $request;
	var $hangPeer;
	public static $listRole = "hang,savehang,deletehang";
	public function __construct(){
		$this->request = new Request;
		$this->hangPeer = new hangPeer();
		$this->request->setTitle("Danh sách người dùng");
	}
	
	function index(){		
		$this->request->setAttribute('script','<script src="'._DEFAULT_URL_ .'js/hang.js?'._DEFAULT_VERSION_JS_CSS_.'"></script>');
		
		$khoPeer = new khoPeer();
		$arrkho = $khoPeer->getListkho();		
		
		$this->request->setAttribute("listkho",$arrkho);		
		
		$this->request->setModel("www/admin/hang.htm");
		return true;		
	}
	
	function getData(){		
		$Id_hang = $this->request->getParameter("Id_hang");
		$Ten_hang = $this->request->getParameter("Ten_hang");
		$arrhang = $this->hangPeer->gethangs($Id_hang,$Ten_hang);	
		$data["data"] = $arrhang;
		$myJSON = json_encode($data);
		
		return $this->request->json_response($myJSON);
		//return true;
	}
	
	function savehang(){		
		$hangId = ($this->request->getParameter("id")!="") ? $this->request->getParameter("id") : 0;
		$data = $this->request->getParameter("data",false);		
		$arrayData = json_decode($data,true);
		
		if($arrayData[0] == "" || $arrayData[1] == "" || $arrayData[2] == "" || $arrayData[3] == "" || $arrayData[4] == "" || $arrayData[5] == "" || $arrayData[6] == "" || $arrayData[7] == ""){
			$message = new Message();
			$message->set("flag",false);
			$message->set("errorMessage","");
			
			$response["message"] = $message;
			
			$myJSON = json_encode($response);
			//echo $myJSON;
			return $this->request->json_response($myJSON);
		}
		
		$hang = new hang;
		// $khoPeer = new khoPeer;
		// $kho = new kho;
		$id = 0;
		if($hangId == 0){ // them moi				
			$hang->set("Id_hang",$hangId);	
			$hang->set("Ten_hang",$arrayData[0]);	
			$hang->set("DVT",$arrayData[1]);
			$hang->set("Kho",$arrayData[2]);
			$hang->set("Lo",$arrayData[3]);
			$hang->set("Date",$arrayData[4]);	
			$hang->set("SL",$arrayData[5]);
			$hang->set("Gia",$arrayData[6]);
			$hang->set("Nguon",$arrayData[7]);			
			
			// $kho = $khoPeer->getkhoID($arrayData[7]);
			// if($kho != false)	$hang->set("Id_kho",$kho->get("quyen"));
				
			$id = $this->hangPeer->save($hang);
		}
		else{ // sửa user				
			$hang->set("Id_hang",$hangId);	
			$hang->set("Ten_hang",$arrayData[0]);	
			$hang->set("DVT",$arrayData[1]);
			$hang->set("Kho",$arrayData[2]);
			$hang->set("Lo",$arrayData[3]);
			$hang->set("Date",$arrayData[4]);	
			$hang->set("SL",$arrayData[5]);
			$hang->set("Gia",$arrayData[6]);
			$hang->set("Nguon",$arrayData[7]);	
			$id = $this->hangPeer->save($hang);	
		}			
		
		$message = new Message();
		$message->set("flag",true);
		$message->set("succesMessage","Cập nhật người dùng thành công");
		
		$response["Id_hang"] = $id;
		$response["message"] = $message;			
		
		$myJSON = json_encode($response);
		//echo $myJSON;
		return $this->request->json_response($myJSON);	
	}
	
	function deletehang(){		

		// $test = $this->request->getParameter("id");
		// echo "<h1>tesst bien - </h1> ";
		// // print_r($test);
		$Id_hang = ($this->request->getParameter("id")!="") ? $this->request->getParameter("id") : 0;
		$this->hangPeer->deletehang($Id_hang);
		
		$myJSON = json_encode(true);		
		return $this->request->json_response($myJSON);
	}
	
	// function lockhang(){		
	// 	$hangId = $this->request->getParameter("mahang");
	// 	$lock = $this->request->getParameter("lock");
		
	// 	if($lock == '0') $lock = '1';
	// 	else $lock = '0';
		
	// 	$this->hangPeer->updateLock($hangId,$lock);
		
	// 	$myJSON = json_encode($lock);		
	// 	return $this->request->json_response($myJSON);
	// }
	
	function gethangs()	{
		$searchString = $this->request->getParameter("searchString");
		$listhangs = $this->request->getParameter("listhangs",false);
				
		$arrhang = $this->hangPeer->gethangs($searchString, $listhangs);
		
		$myJSON = json_encode($arrhang);		
		
		return $this->request->json_response($myJSON);
	}
	
	// function phakhouyen(){
	// 	$maUser = $this->request->getParameter("maUser");
		
	// 	$chucNangPeer = new ChucNangPeer;
				
	// 	$user = $this->userPeer->getUserID($maUser);

	// 	$quyen = explode(",", $user->get("quyen"));
	// 	$listChucNang = $chucNangPeer->getChucNang();
	// 	//print_r($_SESSION["quyen"]);		
	// 	include("www/admin/phakhouyen/viewListPhakhouyen.htm");
		
	// 	return "";
	// }
	
	// function savePhakhouyen(){
	// 	$username = $this->request->getParameter("username");
	// 	$numCheck = $this->request->getParameter("numCheck");
	// 	$quyen = "";
		
	// 	$phay = "";
		
	// 	for($i=0;$i<$numCheck;$i++){
			
	// 		if(isset($_POST['checkbox'.$i])){
	// 			$quyen = $quyen . $phay . implode(",", $_POST['checkbox'.$i]);
	// 			$phay = ",";
	// 		}
	// 	}
		
	// 	$user = $this->userPeer->getUser($username);
	// 	$change = 0;
	// 	// kiem tra quyen vùa cập nhật
	// 	$quyencu = $user->get("quyen");
	// 	if(strlen($quyencu)!=strlen($quyen)) $change = 1;
	// 	else {
	// 		$listquyen = explode(",", $quyen);
	// 		$listquyencu = explode(",",$quyencu);
	// 		for($i=0;$i<$numCheck;$i++){
	// 			if(!in_array($listquyen[$i], $listquyencu)){
	// 				$change = 1;
	// 				break;
	// 			}
	// 		}
	// 	}
	function getThe(){
		$Id_hang = $this->request->getParameter("Id_hang");
		
		$hang = $this->hangPeer->gethangID($Id_hang);
		
		// kiểm tra nếu đủ thông tin thì mời in giấy	
		if($hang->get("Ten_hang")!="" && $hang->get("DVT")!="" && $hang->get("Kho")!="" && $hang->get("Lo")!="" && $hang->get("Date")!="" && $hang->get("SL")!="" && $hang->get("Gia")!="" && $hang->get("Nguon")!=""){
			
			$hangPeer = new hangPeer;
			$arrChiTiet = $hangPeer->gethangID($Id_hang);	
			
			// $qr  = base64_encode(file_get_contents("https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=http%3A%2F%2Ftracuu%2Ebvtn%2Eorg%2Evn%2F%3Fcv9=".$hang->get("Id_hang")."%26token=".$hang->get("token")."&choe=UTF-8"));
			
			// $src = 'data: png;base64,'.$qr;

			// Echo out a sample image
			// $data["img"] = '<img src="' . $src . '">';		
			$data["hang"] = $hang;
			$data["chiTiet"] = $arrChiTiet;
			$data['status'] = 'success';
			
			$myJSON = json_encode($data);
			
			return $this->request->json_response($myJSON);
		}
		else {
			$data['status'] = 'error';
			$myJSON = json_encode($data);
			
			return $this->request->json_response($myJSON);
		}
	}	
	// 	$user->set("quyen",$quyen);
	// 	$user->set("password","");
	// 	$user->set("changeQuyen",$change);

	// 	$this->userPeer->updateQuyen($user);
		
	// 	$myJSON = json_encode("Đã lưu");		
		
	// 	return $this->request->json_response($myJSON);
	// }
}
?>