<?php ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }
	////date_default_timezone_set('Asia/Calcutta');


	$super_admin = SuperAdmin::find_by_id($session->super_admin_id);
	

	$super_admin->admin_mobile		= $_POST['mobile'];

	$super_admin->date_			= date("Y-m-d");
	$super_admin->time_			= date("H:i:s");

	if($super_admin->save()) {
		// Success
		$session->message("Mobile Number Updated Successfully.");
		redirect_to("my-account.php");
	} else {
		// Failure
		$session->message("Fail to Update Mobile Number.");
		redirect_to("my-account.php");
	}
	
?>