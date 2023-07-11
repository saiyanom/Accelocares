<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	////date_default_timezone_set('Asia/Calcutta');
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		echo $key." -> ". $value."<br />";
	}


	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("mill.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+-]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("mill.php");
		}
	}

	function isValidEmail($email){ 
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}


	
	if ($_POST['mill_name'] == "") {
		$session->message("Enter Mill Name"); redirect_to("mill.php");
	} else {
		if (is_numeric($_POST['mill_name'])) {
			$session->message("Enter Valid Mill Name"); redirect_to("mill.php");
		}
	}
	
	if (isset($_POST['name_1']) && $_POST['name_1'] == "") {
		$session->message("Enter Name"); redirect_to("mill.php");
	} else {
		if (is_numeric($_POST['name_1'])) {
			$session->message("Enter Valid Name"); redirect_to("mill.php");
		}
	}
	
	if (isset($_POST['email_1']) && $_POST['email_1'] == "") {
		$session->message("Enter Email"); redirect_to("mill.php");
	} else {
		if(!isValidEmail($_POST['email_1'])){
			$session->message("Invalid 1{$_POST['name_1']} Email"); redirect_to("mill.php");
		}
	} 
	
	if (isset($_POST['mobile_1']) && $_POST['mobile_1'] != "") {		
		$phone_num = $_POST['mobile_1'];
		if (is_numeric($phone_num)) {
			if (strlen($phone_num) != 10) {
				$session->message("Enter 10 digit {$_POST['mobile_1']} Mobile Number"); redirect_to("mill.php");
			}
		} else {
			$session->message("Enter valid {$_POST['name_1']} Mobile Number"); redirect_to("mill.php");
		}
	}  else{
		//$session->message("Enter {$_POST['name_1']} Mobile Number"); redirect_to("mill.php");
	}


	if (isset($_POST['name_2']) && $_POST['name_2'] != "") {
		
		if (isset($_POST['name_2']) && $_POST['name_2'] == "") {
			$session->message("Enter Name"); redirect_to("mill.php");
		} else if (isset($_POST['name_2']) && $_POST['name_2'] != "") {
			if (is_numeric($_POST['name_2'])) {
				$session->message("Enter Valid Name"); redirect_to("mill.php");
			}
		}

		if (isset($_POST['email_2']) && $_POST['email_2'] == "") {
			$session->message("Enter Email"); redirect_to("mill.php");
		} else if (isset($_POST['email_2']) && $_POST['email_2'] != "") {
			if(!isValidEmail($_POST['email_2'])){
				$session->message("Invalid 2{$_POST['name_2']} Email"); redirect_to("mill.php");
			}
		} 

		if (isset($_POST['mobile_2']) && $_POST['mobile_2'] != "") {		
			$phone_num = $_POST['mobile_2'];
			if (is_numeric($phone_num)) {
				if (strlen($phone_num) != 10) {
					$session->message("Enter 10 digit {$_POST['mobile_2']} Mobile Number"); redirect_to("mill.php");
				}
			} else {
				$session->message("Enter valid {$_POST['name_2']} Mobile Number"); redirect_to("mill.php");
			}
		}  else{
			//$session->message("Enter {$_POST['name_2']} Mobile Number"); redirect_to("mill.php");
		}
	}


	if (isset($_POST['name_3']) && $_POST['name_3'] != "") {
		if (isset($_POST['name_3']) && $_POST['name_3'] == "") {
			$session->message("Enter Name"); redirect_to("mill.php");
		} else if (isset($_POST['name_3']) && $_POST['name_3'] != "") {
			if (is_numeric($_POST['name_3'])) {
				$session->message("Enter Valid Name"); redirect_to("mill.php");
			}
		}

		if (isset($_POST['email_3']) && $_POST['email_3'] == "") {
			$session->message("Enter Email"); redirect_to("mill.php");
		} else if (isset($_POST['email_3']) && $_POST['email_3'] != "") {
			if(!isValidEmail($_POST['email_3'])){
				$session->message("Invalid 3{$_POST['name_3']} Email"); redirect_to("mill.php");
			}
		} 

		if (isset($_POST['mobile_3']) && $_POST['mobile_3'] != "") {		
			$phone_num = $_POST['mobile_3'];
			if (is_numeric($phone_num)) {
				if (strlen($phone_num) != 10) {
					$session->message("Enter 10 digit {$_POST['mobile_3']} Mobile Number"); redirect_to("mill.php");
				}
			} else {
				$session->message("Enter valid {$_POST['name_3']} Mobile Number"); redirect_to("mill.php");
			}
		}  else{
			//$session->message("Enter {$_POST['name_3']} Mobile Number"); redirect_to("mill.php");
		}
	}


	if (isset($_POST['name_4']) && $_POST['name_4'] == "") {
		if (isset($_POST['name_4']) && $_POST['name_4'] == "") {
			$session->message("Enter Name"); redirect_to("mill.php");
		} else if (isset($_POST['name_4']) && $_POST['name_4'] != "") {
			if (is_numeric($_POST['name_4'])) {
				$session->message("Enter Valid Name"); redirect_to("mill.php");
			}
		}

		if (isset($_POST['email_4']) && $_POST['email_4'] == "") {
			$session->message("Enter Email"); redirect_to("mill.php");
		} else if (isset($_POST['email_4']) && $_POST['email_4'] != "") {
			if(!isValidEmail($_POST['email_4'])){
				$session->message("Invalid {$_POST['name_4']} Email"); redirect_to("mill.php");
			}
		} 

		if (isset($_POST['mobile_4']) && $_POST['mobile_4'] != "") {		
			$phone_num = $_POST['mobile_4'];
			if (is_numeric($phone_num)) {
				if (strlen($phone_num) != 10) {
					$session->message("Enter 10 digit {$_POST['mobile_4']} Mobile Number"); redirect_to("mill.php");
				}
			} else {
				$session->message("Enter valid {$_POST['name_4']} Mobile Number"); redirect_to("mill.php");
			}
		}  else{
			//$session->message("Enter 4{$_POST['name_4']} Mobile Number"); redirect_to("mill.php");
		}
	}


	if (isset($_POST['name_5']) && $_POST['name_5'] == "") {
		if (isset($_POST['name_5']) && $_POST['name_5'] == "") {
			$session->message("Enter Name"); redirect_to("mill.php");
		} else if (isset($_POST['name_5']) && $_POST['name_5'] != "") {
			if (is_numeric($_POST['name_5'])) {
				$session->message("Enter Valid Name"); redirect_to("mill.php");
			}
		}

		if (isset($_POST['email_5']) && $_POST['email_5'] == "") {
			$session->message("Enter Email"); redirect_to("mill.php");
		} else if (isset($_POST['email_5']) && $_POST['email_5'] != "") {
			if(!isValidEmail($_POST['email_5'])){
				$session->message("Invalid {$_POST['name_5']} Email"); redirect_to("mill.php");
			}
		} 

		if (isset($_POST['mobile_5']) && $_POST['mobile_5'] != "") {		
			$phone_num = $_POST['mobile_5'];
			if (is_numeric($phone_num)) {
				if (strlen($phone_num) != 10) {
					$session->message("Enter 10 digit {$_POST['mobile_5']} Mobile Number"); redirect_to("mill.php");
				}
			} else {
				$session->message("Enter valid {$_POST['name_5']} Mobile Number"); redirect_to("mill.php");
			}
		}  else{
			//$session->message("Enter 5{$_POST['name_5']} Mobile Number"); redirect_to("mill.php");
		}
	}



	//$auth_emp 	= MillReg::authenticate_mill_email($_POST['mill_email']);

	//if($auth_emp){
		//$session->message($_POST['mill_email']. " Already Registered");
		//redirect_to("mill.php");
	//}

	if(empty($_POST['mill_name']) || empty($_POST['name_5']) || empty($_POST['name_5']) || empty($_POST['name_5'])){
		//$session->message("Enter Mill Name, Name, Email & Mobile Number");
		//redirect_to("mill.php");
	}

	$mill_reg = new MillReg();

	$mill_reg->mill_name		= $_POST['mill_name'];
	
	if(isset($_POST['name_1']) && !empty($_POST['name_1'])){
		$mill_reg->name_1		= $_POST['name_1'];
		$mill_reg->email_1		= $_POST['email_1'];
		$mill_reg->mobile_1		= $_POST['mobile_1'];	
	}

	if(isset($_POST['name_2']) && !empty($_POST['name_2'])){
		$mill_reg->name_2		= $_POST['name_2'];
		$mill_reg->email_2		= $_POST['email_2'];
		$mill_reg->mobile_2		= $_POST['mobile_2'];	
	}

	if(isset($_POST['name_3']) && !empty($_POST['name_3'])){
		$mill_reg->name_3		= $_POST['name_3'];
		$mill_reg->email_3		= $_POST['email_3'];
		$mill_reg->mobile_3		= $_POST['mobile_3'];	
	}

	if(isset($_POST['name_4']) && !empty($_POST['name_4'])){
		$mill_reg->name_4		= $_POST['name_4'];
		$mill_reg->email_4		= $_POST['email_4'];
		$mill_reg->mobile_4		= $_POST['mobile_4'];	
	}

	if(isset($_POST['name_5)']) && !empty($_POST['name_5'])){
		$mill_reg->name_5		= $_POST['name_5'];
		$mill_reg->email_5		= $_POST['email_5'];
		$mill_reg->mobile_5		= $_POST['mobile_5'];	
	}
	
	
	$mill_reg->status			= 1;
	$mill_reg->date_			= date("Y-m-d");
	$mill_reg->time_			= date("H:i:s");

	if($mill_reg->save()) {
		// Success
		$session->message("Mill Added Successfully.");
		redirect_to("mill.php");
	} else {
		// Failure
		$session->message("Fail to Add Mill.");
		redirect_to("mill.php");
	}
	
?>