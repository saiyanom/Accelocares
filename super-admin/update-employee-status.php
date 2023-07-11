<?php ob_start();
	require_once("../includes/initialize.php"); 
	////date_default_timezone_set('Asia/Calcutta');
	if (!$session->is_super_admin_logged_in()) { 
		redirect_to("logout.php"); 
	}

	if(isset($_GET['id']) && !empty($_GET['id'])) {
		
		if(!isset($session->super_admin_id) || empty($session->super_admin_id)){
			//$session->message("Admin not found");
			//redirect_to("logout.php");
		}
				
		$employee_reg = EmployeeReg::find_by_id($_GET['id']);
		
		if($employee_reg->status == 1){
			$employee_reg->status = 0;
		} else {
			$employee_reg->status = 1;
		}
			
		if($employee_reg->save()) {
			// Success
			$session->message("Status Updated Successfully.");
			redirect_to("add-employee.php");
		} else {
			// Failure
			$session->message("Fail to Updated Status");
			redirect_to("add-employee.php");
		}
		
	}	else {
			$session->message("Employee Not Found");
			redirect_to("add-employee.php");
	}
?>


