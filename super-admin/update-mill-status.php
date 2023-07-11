<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	////date_default_timezone_set('Asia/Calcutta');
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }


	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("mill.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+-]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("mill.php");
		}
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Query."); redirect_to("mill.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Query."); redirect_to("mill.php");
		}
	} else {
		$session->message("Employee not found"); redirect_to("mill.php");
	}
		

	if(isset($_GET['id']) && !empty($_GET['id'])) {
		
		if(!isset($session->super_admin_id) || empty($session->super_admin_id)){
			//$session->message("Admin not found");
			//redirect_to("logout.php");
		}
				
		$mill_reg = MillReg::find_by_id($_GET['id']);
		
		if($mill_reg->status == 1){
			$mill_reg->status = 0;
		} else {
			$mill_reg->status = 1;
		}
			
		if($mill_reg->save()) {
			// Success
			$session->message("Status Updated Successfully.");
			redirect_to("mill.php");
		} else {
			// Failure
			$session->message("Fail to Updated Status");
			redirect_to("mill.php");
		}
		
	}	else {
			$session->message("Mill Not Found");
			redirect_to("mill.php");
	}
?>


