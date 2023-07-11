<?php ob_start();
	require_once("../includes/initialize.php"); 
	////date_default_timezone_set('Asia/Calcutta');
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	


	if(isset($_GET['id']) || !empty($_GET['id'])) {
		$delete = CvcMeeting::find_by_id($_GET['id']);
	
		if($delete && $delete->delete($_GET['id'])) {
			$session->message("Meeting Deleted Successfully.");
			redirect_to("my-cvc.php");
		} else {
			$session->message("Fail to Delete Meeting.");
			redirect_to("my-cvc.php");
		}
	} else {
		$session->message("Fail to Delete Meeting.");
			redirect_to("my-cvc.php");
	}
	
	
?>