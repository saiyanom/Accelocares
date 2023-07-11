<?php 
    ob_start();
	require_once("../includes/initialize.php");

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("login.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("login.php");
		} 
	}

	if($session->employee_id){
		$found_user = EmployeeReg::find_by_id($session->employee_id);

		$found_user->log 			= 0;
		$found_user->log_session 	= time();
		$found_user->log_time 		= 0;
		if($found_user->save()){
			$session->employee_logout();
			setcookie("PHPSESSID","",time()-3600,"/");
			setcookie("PHPSESSID","",time()-3600,"/crm/administrator");
			redirect_to("../index.php");
		} else {
			$message = "Failed to Logout, try again.";
			redirect_to("index.php");
		}
	} else {
		$session->employee_logout();
		redirect_to("../index.php");
	} 



?>
