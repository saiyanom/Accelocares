<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("approval.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("approval.php");
		}
	}

	if ($session->is_employee_logged_in()){ 
		$employee_reg = EmployeeReg::find_by_id($session->employee_id);

		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != 'Employee' AND emp_sub_role != 'Viewer' AND emp_sub_role != '' Limit 1";

		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);

		if(!$employee_location){
			redirect_to("logout.php?"); 
		}
	} else { redirect_to("logout.php"); }

	if(isset($_GET['complaint']) && !empty($_GET['complaint'])){
		
		
		$sql = "Select * from sub_complaint_type where department_id={$_GET['department']} AND complaint_type_id={$_GET['complaint']} AND status=1 order by sub_complaint_type ASC";
		$sub_complaint = SubComplaintType::find_by_sql($sql);
		//$sub_complaint = SubComplaintType::find_all();
		echo "<option value=''>- Sub Complaint Type -</option>";
		foreach($sub_complaint as $sub_complaint){
			if(empty($sub_complaint->sub_complaint_type)){
				echo "<option value=''>None</option>";
			} else {
				echo "<option>{$sub_complaint->sub_complaint_type}</option>";
			}
		}
	} 	
?>