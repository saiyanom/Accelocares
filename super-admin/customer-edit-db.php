<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	////date_default_timezone_set('Asia/Calcutta');
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }


	foreach ($_POST as $key => $value) {
		if (preg_match('/[\"\^%*}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("customer.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*}!{><;`=+-]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("customer.php");
		}
	}


	function isValidEmail($email){ 
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Query."); redirect_to("customer.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Query."); redirect_to("customer.php");
		}
	} else {
		$session->message("Employee not found"); redirect_to("customer.php");
	}

	
	if ($_POST['company_name'] == "") {
		$session->message("Enter Company Name"); redirect_to("customer.php");
	}

	if ($_POST['customer_id'] == "") {
		$session->message("Enter Customer ID"); redirect_to("customer.php");
	}

	
	if(!empty($_POST['password'])){
		if(strlen($_POST['password']) < 6){
			$session->message("Enter minimum 6 Character Password");
			redirect_to("customer.php");
		}
		if(empty($_POST['re_password2'])){
			$session->message("Enter Retype Password");
			redirect_to("customer.php");
		}
		if(strlen($_POST['re_password2']) < 6){
			$session->message("Enter minimum 6 Character Retype Password");
			redirect_to("customer.php");
		}
		if($_POST['re_password2'] != $_POST['password']){
			$session->message("Password & Confirm Password Not Matched");
			redirect_to("customer.php");
		}
	} 
	
	
	if ($_POST['emp_name_1'] == "") {
		$session->message("Enter Name 1"); redirect_to("customer.php");
	} else {
		if (is_numeric($_POST['emp_name_1'])) {
			$session->message("Enter Valid Name"); redirect_to("customer.php");
		}
	}
	
	if ($_POST['emp_email_1'] == "") {
		$session->message("Enter Email"); redirect_to("customer.php");
	} else {
		if(!isValidEmail($_POST['emp_email_1'])){
			$session->message("Invalid {$_POST['emp_name_1']} Email"); redirect_to("customer.php");
		}
	} 
	
	if ($_POST['emp_mobile_1'] != "") {		
		$phone_num = $_POST['emp_mobile_1'];
		if (is_numeric($phone_num)) {
			if (strlen($phone_num) != 10) {
				$session->message("Enter 10 digit {$_POST['emp_mobile_1']} Mobile Number"); redirect_to("customer.php");
			}
		} else {
			$session->message("Enter valid {$_POST['emp_name_1']} Mobile Number"); redirect_to("customer.php");
		}
	}  else{
		//$session->message("Enter {$_POST['emp_name_1']} Mobile Number"); redirect_to("customer.php");
	}


	if (isset($_POST['emp_name_2'])){
		if (isset($_POST['emp_name_2']) && $_POST['emp_name_2'] == "") {
			$session->message("Enter Name 2"); redirect_to("customer.php");
		} else {
			if (is_numeric($_POST['emp_name_2'])) {
				$session->message("Enter Valid Name"); redirect_to("customer.php");
			}
		}
		
		if (isset($_POST['emp_email_2']) && $_POST['emp_email_2'] == "") {
			$session->message("Enter Email"); redirect_to("customer.php");
		} else {
			if(!isValidEmail($_POST['emp_email_2'])){
				$session->message("Invalid {$_POST['emp_name_2']} Email"); redirect_to("customer.php");
			}
		} 
		
		if (isset($_POST['emp_mobile_2']) && $_POST['emp_mobile_2'] != "") {		
			$phone_num = $_POST['emp_mobile_2'];
			if (is_numeric($phone_num)) {
				if (strlen($phone_num) != 10) {
					$session->message("Enter 10 digit {$_POST['emp_mobile_2']} Mobile Number"); redirect_to("customer.php");
				}
			} else {
				$session->message("Enter valid {$_POST['emp_name_2']} Mobile Number"); redirect_to("customer.php");
			}
		}  else{
			//$session->message("Enter {$_POST['emp_name_2']} Mobile Number"); redirect_to("customer.php");
		}
	}
	

	if (isset($_POST['emp_name_3'])){
		if (isset($_POST['emp_name_3']) && $_POST['emp_name_3'] == "") {
			$session->message("Enter Name 3"); redirect_to("customer.php");
		} else {
			if (is_numeric($_POST['emp_name_3'])) {
				$session->message("Enter Valid Name"); redirect_to("customer.php");
			}
		}
		
		if (isset($_POST['emp_email_3']) && $_POST['emp_email_3'] == "") {
			$session->message("Enter Email"); redirect_to("customer.php");
		} else {
			if(!isValidEmail($_POST['emp_email_3'])){
				$session->message("Invalid {$_POST['emp_name_3']} Email"); redirect_to("customer.php");
			}
		} 
		
		if (isset($_POST['emp_mobile_3']) && $_POST['emp_mobile_3'] != "") {		
			$phone_num = $_POST['emp_mobile_3'];
			if (is_numeric($phone_num)) {
				if (strlen($phone_num) != 10) {
					$session->message("Enter 10 digit {$_POST['emp_mobile_3']} Mobile Number"); redirect_to("customer.php");
				}
			} else {
				$session->message("Enter valid {$_POST['emp_name_3']} Mobile Number"); redirect_to("customer.php");
			}
		}  else{
			//$session->message("Enter {$_POST['emp_name_3']} Mobile Number"); redirect_to("customer.php");
		}
	}


	if (isset($_POST['emp_name_4'])){
		if (isset($_POST['emp_name_4']) && $_POST['emp_name_4'] == "") {
			$session->message("Enter Name 4"); redirect_to("customer.php");
		} else {
			if (is_numeric($_POST['emp_name_4'])) {
				$session->message("Enter Valid Name"); redirect_to("customer.php");
			}
		}
		
		if (isset($_POST['emp_email_4']) && $_POST['emp_email_4'] == "") {
			$session->message("Enter Email"); redirect_to("customer.php");
		} else {
			if(!isValidEmail($_POST['emp_email_4'])){
				$session->message("Invalid {$_POST['emp_name_4']} Email"); redirect_to("customer.php");
			}
		} 
		
		if (isset($_POST['emp_mobile_4']) && $_POST['emp_mobile_4'] != "") {		
			$phone_num = $_POST['emp_mobile_4'];
			if (is_numeric($phone_num)) {
				if (strlen($phone_num) != 10) {
					$session->message("Enter 10 digit {$_POST['emp_mobile_4']} Mobile Number"); redirect_to("customer.php");
				}
			} else {
				$session->message("Enter valid {$_POST['emp_name_4']} Mobile Number"); redirect_to("customer.php");
			}
		}  else{
			//$session->message("Enter {$_POST['emp_name_4']} Mobile Number"); redirect_to("customer.php");
		}
	}


	if (isset($_POST['emp_name_5'])){
		if (isset($_POST['emp_name_5']) && $_POST['emp_name_5'] == "") {
			$session->message("Enter Name 5"); redirect_to("customer.php");
		} else {
			if (is_numeric($_POST['emp_name_5'])) {
				$session->message("Enter Valid Name"); redirect_to("customer.php");
			}
		}
		
		if (isset($_POST['emp_email_5']) && $_POST['emp_email_5'] == "") {
			$session->message("Enter Email"); redirect_to("customer.php");
		} else {
			if(!isValidEmail($_POST['emp_email_5'])){
				$session->message("Invalid {$_POST['emp_name_5']} Email"); redirect_to("customer.php");
			}
		} 
		
		if (isset($_POST['emp_mobile_5']) && $_POST['emp_mobile_5'] != "") {		
			$phone_num = $_POST['emp_mobile_5'];
			if (is_numeric($phone_num)) {
				if (strlen($phone_num) != 10) {
					$session->message("Enter 10 digit {$_POST['emp_mobile_5']} Mobile Number"); redirect_to("customer.php");
				}
			} else {
				$session->message("Enter valid {$_POST['emp_name_5']} Mobile Number"); redirect_to("customer.php");
			}
		}  else{
			//$session->message("Enter {$_POST['emp_name_5']} Mobile Number"); redirect_to("customer.php");
		}    
	}



      
    if(isset($_GET['id']) && !empty($_GET['id'])){
		$company_reg = CompanyReg::find_by_id($_GET['id']);
	} else {
		$session->message("Customer Not Found.");
		redirect_to("customer.php");
	}

	$company_reg = CompanyReg::find_by_id($_GET['id']);

	$company_reg->customer_id			= $_POST['customer_id'];
	$company_reg->company_name			= $_POST['company_name'];

	if(isset($_POST['password']) && !empty($_POST['password'])){
		$company_reg->password			= $_POST['password'];
	}

	$company_reg->emp_name_1			= $_POST['emp_name_1'];
	$company_reg->emp_email_1			= $_POST['emp_email_1'];
	$company_reg->emp_mobile_1			= $_POST['emp_mobile_1'];

	if(isset($_POST['emp_name_2']) && !empty($_POST['emp_name_2'])){
		$company_reg->emp_name_2			= $_POST['emp_name_2'];
		$company_reg->emp_email_2			= $_POST['emp_email_2'];
		$company_reg->emp_mobile_2			= $_POST['emp_mobile_2'];
	} else {
		$company_reg->emp_name_2			= "";
		$company_reg->emp_email_2			= "";
		$company_reg->emp_mobile_2			= "";
	}
	
	if(isset($_POST['emp_name_3']) && !empty($_POST['emp_name_3'])){
		$company_reg->emp_name_3			= $_POST['emp_name_3'];
		$company_reg->emp_email_3			= $_POST['emp_email_3'];
		$company_reg->emp_mobile_3			= $_POST['emp_mobile_3'];
	} else {
		$company_reg->emp_name_3			= "";
		$company_reg->emp_email_3			= "";
		$company_reg->emp_mobile_3			= "";
	}
	if(isset($_POST['emp_name_4']) && !empty($_POST['emp_name_4'])){
		$company_reg->emp_name_4			= $_POST['emp_name_4'];
		$company_reg->emp_email_4			= $_POST['emp_email_4'];
		$company_reg->emp_mobile_4			= $_POST['emp_mobile_4'];
	} else {
		$company_reg->emp_name_4			= "";
		$company_reg->emp_email_4			= "";
		$company_reg->emp_mobile_4			= "";
	}

	if(isset($_POST['emp_name_5']) && !empty($_POST['emp_name_5'])){
		$company_reg->emp_name_5			= $_POST['emp_name_5'];
		$company_reg->emp_email_5			= $_POST['emp_email_5'];
		$company_reg->emp_mobile_5			= $_POST['emp_mobile_5'];
	} else {
		$company_reg->emp_name_5			= "";
		$company_reg->emp_email_5			= "";
		$company_reg->emp_mobile_5			= "";
	}

	//$company_reg->status				= "Pending";
	$company_reg->date_					= date("Y-m-d");
	$company_reg->time_					= date("H:i:s");



	if($company_reg->save()) {
		// Success
		$session->message("Customer Updated Successfully.");
		redirect_to("customer.php");
	} else {
		// Failure
		//$session->message("Fail to Create New LC");
		$session->message("Fail to Update Customer.");
		redirect_to("customer.php");
	}
	
?>


