<?php
	require_once("../includes/initialize.php");

	if(isset($_GET['id']) && !empty($_GET['id'])){
		
		$company = CompanyReg::find_by_id($_GET['cid']);


		if($company->emp_name_1 == $_GET['id']){
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
		}
			
			
	} 
	

	
?>