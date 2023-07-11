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
	


	if(isset($_GET['id']) || !empty($_GET['id'])) {
		$delete = ComplaintEscalation::find_by_id($_GET['id']);
	
		if($delete && $delete->delete($_GET['id'])) {
			$session->message("{$delete->emp_name} Deleted Successfully.");
			redirect_to("complaint-escalation.php?id=".$delete->product_id);
		} else {
			$session->message("Fail to Delete {$delete->emp_name}.");
			redirect_to("complaint-escalation.php?id=".$delete->product_id);
		}
	} else {
		$session->message("Fail to Delete {$delete->emp_name}.");
		redirect_to("complaint-escalation.php?id=".$delete->product_id);
	}
	
	
?>