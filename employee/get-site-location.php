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
		
		$sql = "Select * from product where product='{$_GET['product']}' AND status = 1 order by site_location ASC";
		$product = Product::find_by_sql($sql);
			echo "<option value=''>- Select Location - </option>";
		foreach($product as $product){
			echo "<option>{$product->site_location}</option>";
		}
	} 
	

	
?>