<?php
	require_once("../includes/initialize.php");

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