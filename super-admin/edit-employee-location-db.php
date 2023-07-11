<?php 	
	ob_start();
	require_once("../includes/initialize.php"); 
	////date_default_timezone_set('Asia/Calcutta');
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }


	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("add-site-location.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+-]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("add-site-location.php");
		}
	}

	
	if ($_POST['employee'] == "") {
		$session->message("Select Employee"); redirect_to("add-site-location.php");
	}

	if ($_POST['emp_sub_role'] == "") {
		$session->message("Select Employee Role"); redirect_to("add-site-location.php");
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Query."); redirect_to("add-site-location.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Query."); redirect_to("add-site-location.php");
		}
	} else {
		$session->message("Company not found"); redirect_to("add-site-location.php");
	}

	if(!isset($_GET['id']) || empty($_GET['id'])){
		$session->message('Product Not Found');
		redirect_to("add-site-location.php"); 
	}	
	
	$employee_reg 	= EmployeeReg::find_by_id($_POST['employee']);

	$emp_location 	= EmployeeLocation::find_by_id($_GET['id']);

	//$auth_emp 		= EmployeeLocation::authenticate_product($emp_location->product_id,$_POST['employee']);

	//if($auth_emp){
		//$session->message($auth_emp->emp_name. " Already Registered");
		//redirect_to("employee-location.php?id=".$emp_location->product_id);
	//}

	if($emp_location){
		//$emp_location->product_id		= $_GET['id'];
		$emp_location->emp_id			= $employee_reg->id;
		$emp_location->emp_name			= $employee_reg->emp_name;
		$emp_location->emp_email		= $employee_reg->emp_email;
		$emp_location->emp_mobile		= $employee_reg->emp_mobile;
		$emp_location->emp_role			= $employee_reg->emp_role;
		$emp_location->emp_sub_role		= $_POST['emp_sub_role'];
		$emp_location->role_priority	= $_POST['role_priority'];
		
		$emp_location->status			= 1;
		$emp_location->date_			= date("Y-m-d");
		$emp_location->time_			= date("H:i:s");

		if($emp_location->save()) {
			// Success
			$session->message("Employee Added Successfully.");
			redirect_to("employee-location.php?id=".$emp_location->product_id);
		} else {
			// Failure
			$session->message("Fail to Add Employee.");
			redirect_to("employee-location.php?id=".$emp_location->product_id);
		}
	} else {
		// Failure
		$session->message("Invalid Employee Selection.");
		redirect_to("employee-location.php?id=".$_GET['id']);
	}
	
	
?>