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


	if(isset($_GET['department']) && !empty($_GET['department'])){
		
		$sql = "Select * from complaint_type where department_id = '{$_GET['department']}'";
		$complaint = ComplaintType::find_by_sql($sql);

		echo "<option value=''>- Complaint Type - </option>";
		foreach($complaint as $complaint){
			if(empty($complaint->complaint_type)){
				echo "<option value=''>None</option>";
			} else {
				echo "<option value='$complaint->id'>{$complaint->complaint_type}</option>";				
			}
		}
	} 	
?>