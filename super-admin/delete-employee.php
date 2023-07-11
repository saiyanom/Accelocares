<?php ob_start();
	require_once("../includes/initialize.php"); 
	////date_default_timezone_set('Asia/Calcutta');

	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }
	


	if(isset($_GET['id']) || !empty($_GET['id'])) {
		$delete = EmployeeLocation::find_by_id($_GET['id']);
	
		if($delete && $delete->delete($_GET['id'])) {
			$session->message("{$delete->emp_name} Deleted Successfully.");
			redirect_to("employee-location.php?id=".$delete->product_id);
		} else {
			$session->message("Fail to Delete {$delete->emp_name}.");
			redirect_to("employee-location.php?id=".$delete->product_id);
		}
	} else {
		$session->message("Fail to Delete {$delete->emp_name}.");
		redirect_to("employee-location.php?id=".$delete->product_id);
	}
	
	
?>