<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	////date_default_timezone_set('Asia/Calcutta');
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }


	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("add-employee.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+-]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("add-employee.php");
		}
	}

	function isValidEmail($email){ 
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Query."); redirect_to("add-employee.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Query."); redirect_to("add-employee.php");
		}
	} else {
		$session->message("Employee not found"); redirect_to("add-employee.php");
	}
	
	if ($_POST['emp_name'] == "") {
		$session->message("Enter Name Of Employee"); redirect_to("add-employee.php");
	} else {
		if (is_numeric($_POST['emp_name'])) {
			$session->message("Enter Valid Name Of Employee"); redirect_to("add-employee.php");
		}
	}
	
	if ($_POST['emp_email'] == "") {
		$session->message("Enter Email Of Employee"); redirect_to("add-employee.php");
	} else {
		if(!isValidEmail($_POST['emp_email'])){
			$session->message("Invalid {$_POST['emp_name']} Employee Email"); redirect_to("add-employee.php");
		}
	} 
	
	if ($_POST['emp_mobile'] != "") {		
		$phone_num = $_POST['emp_mobile'];
		if (is_numeric($phone_num)) {
			if (strlen($phone_num) != 10) {
				$session->message("Enter 10 digit {$_POST['emp_name']} Employee Mobile Number"); redirect_to("add-employee.php");
			}
		} else {
			$session->message("Enter valid {$_POST['emp_name']} Employee Mobile Number"); redirect_to("add-employee.php");
		}
	}  else{
		//$session->message("Enter {$_POST['emp_name']} Employee Mobile Number"); redirect_to("add-employee.php");
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$employee_reg = EmployeeReg::find_by_id($_GET['id']);
	} else {
		$session->message("Employee Not Found.");
		redirect_to("add-employee.php");
	}


	$employee_reg->emp_name			= $_POST['emp_name'];
	$employee_reg->emp_email		= $_POST['emp_email'];
	$employee_reg->emp_mobile		= $_POST['emp_mobile'];
	
	$employee_reg->status			= 1;
	$employee_reg->date_			= date("Y-m-d");
	$employee_reg->time_			= date("H:i:s");

	if($employee_reg->save()) {
		// Success
		$session->message("Employee Updated Successfully.");
		redirect_to("add-employee.php");
	} else {
		// Failure
		$session->message("Fail to Add Employee.");
		redirect_to("add-employee.php");
	}
	
?>