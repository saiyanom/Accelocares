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

	if($session->super_admin_id){
		$found_user = SuperAdmin::find_by_id($session->super_admin_id);

		$found_user->log 			= 0;
		$found_user->log_session 	= time();
		$found_user->log_time 		= 0;
		if($found_user->save()){
			$session->super_admin_logout();
			setcookie("PHPSESSID","",time()-3600,"/");
			setcookie("PHPSESSID","",time()-3600,"/administrator");
			//redirect_to("login.php");
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
			//redirect_to("login.php");
		}
	} 

	/*else {
		$session->super_admin_logout();
		$session->employee_logout();
		redirect_to("https://www.mahindrarise.com/get_auth_asp_new.php");
	} */
	
	//redirect_to("https://www.mahindrarise.com/get_auth_asp_new.php");
	redirect_to(BASE_URL."administrator");

?>
