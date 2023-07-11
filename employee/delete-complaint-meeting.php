<?php ob_start();
	require_once("../includes/initialize.php"); 
	////date_default_timezone_set('Asia/Calcutta');
	//if (!$session->is_admin_logged_in()) {redirect_to("logout.php");}

	$employee_reg = EmployeeReg::find_by_id($session->employee_id);
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	if ($session->is_employee_logged_in()){ 
		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != '' Limit 1";
		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
		if(!$employee_location){
			redirect_to("my-cvc.php"); 
		}
	}

	if(isset($_GET['cid']) || !empty($_GET['cid']) || isset($_GET['id']) || !empty($_GET['id'])) {
		$delete = ComplaintMeeting::find_by_id($_GET['id']);
	
		if($delete && $delete->delete($_GET['id'])) {
			$session->message("Meeting Deleted Successfully.");
			redirect_to("view-complaints.php?id=".$_GET['cid']);
		} else {
			$session->message("Fail to Delete Meeting.");
			redirect_to("view-complaints.php?id=".$_GET['cid']);
		}
	} else {
		$session->message("Fail to Delete Meeting.");
		redirect_to("my-complaint.php");
	}
	
	
?>