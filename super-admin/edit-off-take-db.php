<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }
	////date_default_timezone_set('Asia/Calcutta');
	

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=+]/', $value)){
			$session->message("Malicious Code Found."); redirect_to("customers-page.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=+]/', $value)){
			$session->message("Malicious Code Found."); redirect_to("customers-page.php");
		}
	}


	if(!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['dateYear']) || empty($_GET['dateYear']) || !isset($_GET['date']) || empty($_GET['date']) || !isset($_GET['comp']) || empty($_GET['comp']) || !isset($_GET['loc']) || empty($_GET['loc'])){
		$session->message("Company Not Found");
		redirect_to("customers-page.php");
	} else {

		if(isset($_GET['id'])){
			if(!is_numeric($_GET['id'])) {
				$session->message("Invalid Query."); redirect_to("customers-page.php");
			}
			if(strlen($_GET['id']) < 1) {
				$session->message("Invalid Query."); redirect_to("customers-page.php");
			}
		}

		if(isset($_GET['dateYear'])){
			if(!is_numeric($_GET['dateYear'])) {
				$session->message("Invalid Date."); redirect_to("customers-page.php");
			}
			if(strlen($_GET['dateYear']) != 4) {
				$session->message("Invalid Date."); redirect_to("customers-page.php");
			}
		}

		if(isset($_GET['date'])){
			if (!preg_match('/^[0-9- ]+$/D', $_GET['date'])){
				$session->message("Invalid Date."); redirect_to("customers-page.php");
			}
			if(strlen($_GET['date']) != 10) {
				$session->message("Invalid Date."); redirect_to("customers-page.php");
			}
		}

		if(isset($_GET['comp'])){
			if(!is_numeric($_GET['comp'])) {
				$session->message("Invalid Company."); redirect_to("customers-page.php");
			}
		}

		if(isset($_GET['loc'])){
			if(is_numeric($_GET['loc'])) {
				$session->message("Invalid Location."); redirect_to("customers-page.php");
			}
		}


		$url = "customers-page.php?dateYear={$_GET['dateYear']}&&company={$_GET['comp']}&&location={$_GET['loc']}";
	}


	if(isset($_POST['order_qty']) && !empty($_POST['order_qty'])){
		if(!is_numeric($_POST['order_qty'])) {
			$session->message("Invalid Order Quantity."); redirect_to("customers-page.php");
		}
	} else { 
		if($_POST['order_qty'] != "0") {
			$session->message("Enter Order Quantity."); redirect_to("customers-page.php");
		}
	}

	if(isset($_POST['dispatch_qty']) && !empty($_POST['dispatch_qty'])){
		if(!is_numeric($_POST['dispatch_qty'])) {
			$session->message("Invalid Dispatch Quantity."); redirect_to("customers-page.php");
		}
	} else { 
		if($_POST['dispatch_qty'] != "0") {
			$session->message("Enter Dispatch Quantity."); redirect_to("customers-page.php");
		}
	}

	if(isset($_POST['triger_qty']) && !empty($_POST['triger_qty'])){
		if(!is_numeric($_POST['triger_qty'])) {
			$session->message("Invalid Triger Quantity."); redirect_to("customers-page.php");
		}
	} else { 
		if($_POST['triger_qty'] != "0") {
			$session->message("Enter Triger Quantity."); redirect_to("customers-page.php");
		}
	}



	$customer_off_take =CustomerOffTake::find_by_id($_GET['id']);


	//$company_reg 	= CompanyReg::find_by_id($_GET['comp']);

	

	//$customer_off_take->month			= $_GET['date'];
	//$customer_off_take->company_id		= $company_reg->id;
	//$customer_off_take->company			= $company_reg->company_name;
	//$customer_off_take->location		= $_GET['loc'];
	$customer_off_take->order_qty		= $_POST['order_qty'];
	$customer_off_take->dispatch_qty	= $_POST['dispatch_qty'];
	$customer_off_take->triger_qty		= $_POST['triger_qty'];
	
	$customer_off_take->status			= 1;
	$customer_off_take->date_			= date("Y-m-d");
	$customer_off_take->time_			= date("H:i:s");

	if($customer_off_take->save()) {
		// Success
		$session->message("Data Updated Successfully.");
		redirect_to($url);
	} else {
		// Failure
		$session->message("Fail to Update Data.");
		redirect_to($url);
	}
	
?>