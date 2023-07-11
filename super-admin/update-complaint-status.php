<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	////date_default_timezone_set('Asia/Calcutta');
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }


	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("view-complaints.php?id={$_GET['id']}");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("view-complaints.php?id={$_GET['id']}");
		}
	}

	if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['status']) && !empty($_GET['status'])) {
						
		$complaint = Complaint::find_by_id($_GET['id']);
		
		if($_GET['status'] == "invalid"){
			$complaint->status		= "Invalid";
		} else if($_GET['status'] == "closed"){
			$complaint->status				= "Closed";
		} else {
			$session->message("Undefined Status.");
			redirect_to("view-complaints.php?id={$_GET['id']}");
		}

		$complaint->comp_closed_date	= date("Y-m-d");

			
		if($complaint->save()) {
			// Success
			$session->message("Status Updated Successfully.");
			redirect_to("view-complaints.php?id={$_GET['id']}");
		} else {
			// Failure
			$session->message("Fail to Updated Status");
			redirect_to("view-complaints.php?id={$_GET['id']}");
		}
		
	}	else {
			$session->message("Complaint Not Found");
			redirect_to("complaint-type.php");
	}
?>


