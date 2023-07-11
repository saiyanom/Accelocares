<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	
	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("raised-complaint.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("raised-complaint.php");
		}
	}

	$employee_reg = EmployeeReg::find_by_id($session->employee_id);
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	if ($session->is_employee_logged_in()){ 
		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != '' Limit 1";
		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
		if(!$employee_location){
			redirect_to("my-cvc.php"); 
		}
	}

	if(isset($_GET['product']) && !empty($_GET['product'])){
		
		$business_vertical = Product::find_business_vertical($_GET['plant_location'], $_GET['product']);
		
		$sql = "Select * from complaint_type where department_id={$business_vertical->department_id} AND status=1 order by complaint_type ASC";
		$complaint = ComplaintType::find_by_sql($sql);
		//$sub_complaint = SubComplaintType::find_all();
		echo "<option value=''>- Complaint Type - </option>";
		foreach($complaint as $complaint){
			
			if(empty($complaint->complaint_type)){
				echo "<option value=''>None</option>";
			} else {
				echo "<option value='$complaint->id'>{$complaint->complaint_type}</option>";				
			}
		} echo "<option>Other</option>";
	} 	
?>