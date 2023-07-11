<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }
	////date_default_timezone_set('Asia/Calcutta');


	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=+]/', $value)){
			$session->message("Malicious Code Found."); redirect_to("delivery-compliance.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=+]/', $value)){
			$session->message("Malicious Code Found."); redirect_to("delivery-compliance.php");
		}
	}

	if(!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['dateYear']) || empty($_GET['dateYear']) || !isset($_GET['date']) || empty($_GET['date']) || !isset($_GET['comp']) || empty($_GET['comp']) || !isset($_GET['loc']) || empty($_GET['loc'])){
		$session->message("Company Not Found");
		redirect_to("delivery-compliance.php");
	} else {

		if(isset($_GET['dateYear'])){
			if(!is_numeric($_GET['dateYear'])) {
				$session->message("Invalid Date."); redirect_to("delivery-compliance.php");
			}
			if(strlen($_GET['dateYear']) != 4) {
				$session->message("Invalid Date."); redirect_to("delivery-compliance.php");
			}
		}

		if(isset($_GET['date'])){
			if (!preg_match('/^[0-9- ]+$/D', $_GET['date'])){
				$session->message("Invalid Date."); redirect_to("delivery-compliance.php");
			}
			if(strlen($_GET['date']) != 10) {
				$session->message("Invalid Date."); redirect_to("delivery-compliance.php");
			}
		}

		if(isset($_GET['comp'])){
			if(!is_numeric($_GET['comp'])) {
				$session->message("Invalid Company."); redirect_to("delivery-compliance.php");
			}
		}

		if(isset($_GET['loc'])){
			if(is_numeric($_GET['loc'])) {
				$session->message("Invalid Location."); redirect_to("delivery-compliance.php");
			}
		}

		$url = "delivery-compliance.php?dateYear={$_GET['dateYear']}&&company={$_GET['comp']}&&location={$_GET['loc']}";
	}


	if(isset($_POST['target']) && !empty($_POST['target'])){
		if(!is_numeric($_POST['target'])) {
			$session->message("Invalid Target Value."); redirect_to("delivery-compliance.php");
		}
	} else { 
		if($_POST['target'] != "0") {
			$session->message("Enter Target Value."); redirect_to("delivery-compliance.php");
		}
	}

	if(isset($_POST['actual']) && !empty($_POST['actual'])){
		if(!is_numeric($_POST['actual'])) {
			$session->message("Invalid Actual Value."); redirect_to("delivery-compliance.php");
		}
	} else { 
		if($_POST['actual'] != "0") {
			$session->message("Enter Actual Value."); redirect_to("delivery-compliance.php");
		}
	}


	if(!isset($_GET['id']) || empty($_GET['id'])){
		$session->message("Company Not Found");
		redirect_to("delivery-compliance.php");
	} else {
		$url = "delivery-compliance.php?dateYear={$_GET['dateYear']}&&company={$_GET['comp']}&&location={$_GET['loc']}";
	}

	$customer_delivery_compliance = CustomerDeliveryCompliance::find_by_id($_GET['id']);

	//$company_reg 	= CompanyReg::find_by_id($_GET['comp']);	

	//customer_delivery_compliance->month			= $_GET['date'];
	//customer_delivery_compliance->company_id		= $company_reg->id;
	//customer_delivery_compliance->company			= $company_reg->company_name;
	//$customer_delivery_compliance->location			= $_GET['loc'];
	$customer_delivery_compliance->target			= $_POST['target'];
	$customer_delivery_compliance->actual			= $_POST['actual'];
	
	$customer_delivery_compliance->status			= 1;
	$customer_delivery_compliance->date_			= date("Y-m-d");
	$customer_delivery_compliance->time_			= date("H:i:s");

	if($customer_delivery_compliance->save()) {
		// Success
		$session->message("Data Updated Successfully.");
		redirect_to($url);
	} else {
		// Failure
		$session->message("Fail to Update Data.");
		redirect_to($url);
	}
	
?>