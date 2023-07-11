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

	if(isset($_GET['id']) && !empty($_GET['id'])){
		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Query."); redirect_to("add-site-location.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Query."); redirect_to("add-site-location.php");
		}
	} else {
		$session->message("Site Location not found"); redirect_to("add-site-location.php");
	}

	if(isset($_GET['id']) && !empty($_GET['id'])) {
		
		if(!isset($session->super_admin_id) || empty($session->super_admin_id)){
			//$session->message("Admin not found");
			//redirect_to("logout.php");
		}
				
		$emp_location = EmployeeLocation::find_by_id($_GET['id']);
		
		if($emp_location->status == 1){
			$emp_location->status = 0;
		} else {
			$emp_location->status = 1;
		}
			
		if($emp_location->save()) {
			// Success
			$session->message("Status Updated Successfully.");
			redirect_to("employee-location.php?id=".$emp_location->product_id);
		} else {
			// Failure
			$session->message("Fail to Updated Status");
			redirect_to("employee-location.php?id=".$emp_location->product_id);
		}
		
	}	else {
			$session->message("Record Not Found");
			redirect_to("employee-location.php?id=".$emp_location->product_id);
	}
?>


