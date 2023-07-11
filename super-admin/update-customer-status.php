<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	////date_default_timezone_set('Asia/Calcutta');
	if (!$session->is_super_admin_logged_in()) { 
		//redirect_to("logout.php"); 
	}

	if(isset($_GET['id']) && !empty($_GET['id'])) {
		
		if(!isset($session->super_admin_id) || empty($session->super_admin_id)){
			//$session->message("Admin not found");
			//redirect_to("logout.php");
		}
				
		$company_reg = CompanyReg::find_by_id($_GET['id']);
		
		if($company_reg->status == 1){
			$company_reg->status = 0;
		} else {
			$company_reg->status = 1;
		}
			
		if($company_reg->save()) {
			// Success
			$session->message("Status Updated Successfully.");
			redirect_to("customer.php");
		} else {
			// Failure
			$session->message("Fail to Updated Status");
			redirect_to("customer.php");
		}
		
	}	else {
			$session->message("Customer Not Found");
			redirect_to("customer.php");
	}
?>


