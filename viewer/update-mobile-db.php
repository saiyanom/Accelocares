<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	require '../PHPMailer/PHPMailerAutoload.php';
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	//date_default_timezone_set('Asia/Calcutta');

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("my-account.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("my-cvaccountc.php");
		}
	}

	$employee_reg = EmployeeReg::find_by_id($session->employee_id);
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	if ($session->is_employee_logged_in()){ 
		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role = 'Viewer' Limit 1";
		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
		if(!$employee_location){
			redirect_to("logout.php"); 
		}
	}

	if(!isset($_POST['mobile']) || empty($_POST['mobile'])){
		$session->message("Enter Mobile Number");
		redirect_to("my-cvaccountc.php");
	}

	$employee_reg =  EmployeeReg::find_by_id($session->employee_id);;
	

	$employee_reg->emp_mobile		= $_POST['mobile'];

	$employee_reg->date_			= date("Y-m-d");
	$employee_reg->time_			= date("H:i:s");

	if($employee_reg->save()) {
		// Success
		$session->message("Mobile Number Updated Successfully.");
		redirect_to("my-account.php");
	} else {
		// Failure
		$session->message("Fail to Update Mobile Number.");
		redirect_to("my-account.php");
	}
	
?>