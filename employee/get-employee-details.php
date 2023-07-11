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
		
		$company = CompanyReg::find_by_id($_GET['cid']);


		if (strpos($company->emp_name_1, $_GET['id']) !== false) {
		    if($_GET['type'] == 'mobile'){
				echo $company->emp_mobile_1;	
			}
			if($_GET['type'] == 'email'){
				echo $company->emp_email_1;		
			}	
		}
		else if (strpos($company->emp_name_2, $_GET['id']) !== false) {
		    if($_GET['type'] == 'mobile'){
				echo $company->emp_mobile_2;	
			}
			if($_GET['type'] == 'email'){
				echo $company->emp_email_2;		
			}	
		}
		else if (strpos($company->emp_name_3, $_GET['id']) !== false) {
		    if($_GET['type'] == 'mobile'){
				echo $company->emp_mobile_3;	
			}
			if($_GET['type'] == 'email'){
				echo $company->emp_email_3;		
			}	
		}
		else if (strpos($company->emp_name_4, $_GET['id']) !== false) {
		    if($_GET['type'] == 'mobile'){
				echo $company->emp_mobile_4;	
			}
			if($_GET['type'] == 'email'){
				echo $company->emp_email_4;		
			}	
		}
		else if (strpos($company->emp_name_5, $_GET['id']) !== false) {
		    if($_GET['type'] == 'mobile'){
				echo $company->emp_mobile_5;	
			}
			if($_GET['type'] == 'email'){
				echo $company->emp_email_5;		
			}	
		}



		/*if($company->emp_name_1 == $_GET['id']){
			if($_GET['type'] == 'mobile'){
				echo $company->emp_mobile_1;	
			}
			if($_GET['type'] == 'email'){
				echo $company->emp_email_1;		
			}				
		}
		else if($company->emp_name_2 == $_GET['id']){
			if($_GET['type'] == 'mobile'){
				echo $company->emp_mobile_2;	
			}
			if($_GET['type'] == 'email'){
				echo $company->emp_email_2;		
			}				
		}
		else if($company->emp_name_3 == $_GET['id']){
			if($_GET['type'] == 'mobile'){
				echo $company->emp_mobile_3;	
			}
			if($_GET['type'] == 'email'){
				echo $company->emp_email_3;		
			}				
		}
		else if($company->emp_name_4 == $_GET['id']){
			if($_GET['type'] == 'mobile'){
				echo $company->emp_mobile_4;	
			}
			if($_GET['type'] == 'email'){
				echo $company->emp_email_4;		
			}				
		}
		else if($company->emp_name_5 == $_GET['id']){
			if($_GET['type'] == 'mobile'){
				echo $company->emp_mobile_5;	
			}
			if($_GET['type'] == 'email'){
				echo $company->emp_email_5;		
			}				
		}*/
			
			
	} 
	

	
?>