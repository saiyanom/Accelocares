<?php ob_start();
	require_once("../includes/initialize.php"); 
	////date_default_timezone_set('Asia/Calcutta');
	if (!$session->is_super_admin_logged_in()) { 
		//redirect_to("logout.php"); 
	}

	if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['ca']) && !empty($_GET['ca'])) {
		
		if(!isset($session->super_admin_id) || empty($session->super_admin_id)){
			//$session->message("Admin not found");
			//redirect_to("logout.php");
		}
				
		$complaint = Complaint::find_by_id($_GET['id']);
		
		$complaint->complaint_analysis = $_GET['ca'];
			
		if($complaint->save()) {
			// Success
			$session->message("Status Updated Successfully.");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		} else {
			// Failure
			$session->message("Fail to Updated Status");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
		
	}	else {
			$session->message("Mill Not Found");
			redirect_to("all-complaint.php");
	}
?>


