<?PHP 

class khambenhAction {

    function index(){
		$request = new Request;		
		$request->setModel("www\View\User\index.htm");
		return true;
	}
}

?>