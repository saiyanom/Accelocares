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


	if(isset($_GET['id']) && !empty($_GET['id'])){
		
		$company = CompanyReg::find_by_id($_GET['id']);


			echo "<option value=''>- Complaint Raised by -</option>";

			if(!empty($company->emp_name_1)){
				echo "<option>{$company->emp_name_1}</option>";
			}
			if(!empty($company->emp_name_2)){
				echo "<option>{$company->emp_name_2}</option>";
			}
			if(!empty($company->emp_name_3)){
				echo "<option>{$company->emp_name_3}</option>";
			}
			if(!empty($company->emp_name_4)){
				echo "<option>{$company->emp_name_4}</option>";
			}
			if(!empty($company->emp_name_5)){
				echo "<option>{$company->emp_name_5}</option>";
			}
			echo "<option>Other</option>";
			
	} 
	

	
?>