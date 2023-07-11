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

	if ($_POST['role_priority'] == "") {
		$session->message("Select Role Priority"); redirect_to("add-site-location.php");
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

	
	
	$employee_reg 		= EmployeeReg::find_by_id($_POST['employee']);
	$comp_escalation 	= ComplaintEscalation::find_by_id($_GET['id']);

	if($comp_escalation && $employee_reg){
		//$comp_escalation->product_id		= $_GET['id'];
		$comp_escalation->emp_id			= $employee_reg->id;
		$comp_escalation->emp_name			= $employee_reg->emp_name;
		$comp_escalation->emp_email			= $employee_reg->emp_email;
		$comp_escalation->emp_mobile		= $employee_reg->emp_mobile;
		$comp_escalation->role_priority		= $_POST['role_priority'];
		
		$comp_escalation->status			= 1;
		$comp_escalation->date_				= date("Y-m-d");
		$comp_escalation->time_				= date("H:i:s");

		if($comp_escalation->save()) {
			// Success
			$session->message("Employee Updated Successfully.");
			redirect_to("complaint-escalation.php?id=".$comp_escalation->product_id);
		} else {
			// Failure
			$session->message("Fail to Add Employee.");
			redirect_to("add-site-location.php");
		}
	} else {
		// Failure
		$session->message("Fail to Add Employee.");
		redirect_to("add-site-location.php");
	}
	
	
?>