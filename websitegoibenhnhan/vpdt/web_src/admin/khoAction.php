<?PHP
require_once("web_src/bean/khoPeer.php");
require_once("web_src/bean/ChucNangPeer.php");

class khoAction {	
	var $request;
	var $khoPeer;
	public static $listRole = "kho,save,delete ";
	
	public function __construct(){
		$this->request = new Request;
		$this->khoPeer = new khoPeer();
		$this->request->setTitle("Danh sách kho");
	}
	// duong dan trang html
	function index(){		
		$this->request->setAttribute('script','<script src="'._DEFAULT_URL_ .'js/kho.js?'._DEFAULT_VERSION_JS_CSS_.'"></script>');

		$this->request->setModel("www/admin/kho.htm");
		return true;		
	}
	// get date form tim kiem
	function getData(){				
		$Ten_kho = $this->request->getParameter("Ten_kho");
		
		$arrkho = $this->khoPeer->getListkho($Ten_kho);
		
		$data["data"] = $arrkho;
		$myJSON = json_encode($data);
		
		return $this->request->json_response($myJSON);		
	}
	
	function save(){		
		$khoId = ($this->request->getParameter("id")!="") ? $this->request->getParameter("id") : 0;
		$data = $this->request->getParameter("data",false);
		
		$arrayData = json_decode($data,true);
		
		if($arrayData[0] !="") {			
			$kho = new kho;
			$kho->set("Id_kho",$khoId);	
			$kho->set("Ten_kho",$arrayData[1]);	
			$id = $this->khoPeer->save($kho);			
			
			$message = new Message();
			$message->set("flag",true);
			$message->set("succesMessage","Cập nhật kho thành công");
			
			$response["id"] = $id;
			$response["message"] = $message;			
			
			$myJSON = json_encode($response);
			//echo $myJSON;
			return $this->request->json_response($myJSON);
		}	
		
		$message = new Message();
		$message->set("flag",false);
		$message->set("errorMessage","");
		
		$response["message"] = $message;
		
		$myJSON = json_encode($response);
		//echo $myJSON;
		return $this->request->json_response($myJSON);	
	}
	
	function delete(){		
		$khoId = ($this->request->getParameter("id")!="") ? $this->request->getParameter("id") : 0;
		$this->khoPeer->delete($khoId);
		
		$myJSON = json_encode(true);
		
		return $this->request->json_response($myJSON);
	}
	
	// function phakhouyen(){
	// 	$Id_kho = $this->request->getParameter("Id_kho");
		
	// 	$chucNangPeer = new ChucNangPeer;
		
	// 	$kho = new kho;
	// 	$kho = $this->khoPeer->getkhoID($Id_kho);

	// 	$quyen = explode(",", $kho->get("quyen"));
	// 	$listChucNang = $chucNangPeer->getChucNang();
	// 	//print_r($_SESSION["quyen"]);		
	// 	include("www/admin/phakhouyen/viewListPhakhouyen.htm");
		
	// 	return "";
	// }
	
	// function savePhakhouyen(){
	// 	$Id_kho = $this->request->getParameter("username");
	// 	$numCheck = $this->request->getParameter("numCheck");
	// 	$quyen = "";
		
	// 	$phay = "";
		
	// 	for($i=0;$i<$numCheck;$i++){
	// 		//$checkbox = $_POST['checkbox'.$i];
			
	// 		if(isset($_POST['checkbox'.$i])){
	// 			$quyen = $quyen . $phay . implode(",", $_POST['checkbox'.$i]);
	// 			$phay = ",";
	// 		}
	// 	}
		
	// 	$kho = $this->khoPeer->getkhoID($Id_kho);
	// 	$kho->set("quyen",$quyen);		

	// 	$this->khoPeer->update($kho);
		
	// 	$myJSON = json_encode("Đã lưu");		
		
	// 	return $this->request->json_response($myJSON);
	// }
}
?>