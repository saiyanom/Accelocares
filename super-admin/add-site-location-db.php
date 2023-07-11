<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	////date_default_timezone_set('Asia/Calcutta');
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }


	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("add-site-location.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+-]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("add-site-location.php");
		}
	}

	
	if ($_POST['department'] == "") {
		$session->message("Enter Department"); redirect_to("add-site-location.php");
	} else {
		if($_POST['department'] == "new_department"){
			if($_POST['department_new'] == ""){
				$session->message("Enter New Department"); redirect_to("add-site-location.php");
			}
		}
	}

	if ($_POST['site_location'] == "") {
		$session->message("Enter Site Location"); redirect_to("add-site-location.php");
	} else {
		if($_POST['site_location'] == "new_site_location"){
			if($_POST['site_location_new'] == ""){
				$session->message("Enter New Site Location"); redirect_to("add-site-location.php");
			}
		}
	}


	
// Department Entry ************************************************************

	if($_POST['department'] == "new_department"){
		$department = $_POST['department_new'];
		
		$auth_department 	= Department::authenticate_department($department);

		if($auth_department){
			//echo $_POST['department_new']. " Already Registered";
			$session->message($department. " Already Registered");
			redirect_to("add-site-location.php");
		}
		
		$department_reg = new Department();	

		$department_reg->department = $_POST['department_new'];

		$department_reg->status			= 1;
		$department_reg->date_			= date("Y-m-d");
		$department_reg->time_			= date("H:i:s");

		if($department_reg->save()){
			echo "Department Saved <br />";
			$department_id 		= $department_reg->id;
		} else {
			echo "Department Failed <br />";
		}

	} else {
		$department 		= $_POST['department'];
		$auth_department 	= Department::authenticate_department($department);
		$department_id 		= $auth_department->id;
	}

	


// Site Location Entry ************************************************************

	if($_POST['site_location'] == "new_site_location"){
		$site_location = $_POST['site_location_new'];
		
		$auth_site_location 	= SiteLocation::authenticate_site_location($department_id, $site_location);

		if(!$auth_site_location){
			//echo $_POST['site_location_new']. " Already Registered";
			//$session->message($site_location. " Already Registered");
			//redirect_to("add-site-location.php");
			$site_location_reg = new SiteLocation();	

			$site_location_reg->department_id 	= $department_id;
			$site_location_reg->department 		= $department;
			$site_location_reg->site_location 	= $_POST['site_location_new'];

			$site_location_reg->status			= 1;
			$site_location_reg->date_			= date("Y-m-d");
			$site_location_reg->time_			= date("H:i:s");

			if($site_location_reg->save()){
				echo "Site Location Saved <br />";
				$site_location_id 		= $site_location_reg->id;
			} else {
				echo "Site Location Failed <br />";
			}
		}
	} else {
		$site_location 			= $_POST['site_location'];
		$auth_site_location 	= SiteLocation::authenticate_site_location($department_id, $site_location);
		$site_location_id 		= $auth_site_location->id;
	}

	


// Product Entry ************************************************************

	if($_POST['product'] == "new_product"){
		$product = $_POST['product_new'];
		
		$auth_product 	= Product::authenticate_product($department, $site_location, $product);

		if($auth_product){
			//echo $_POST['product_new']. " Already Registered";
			$session->message($product. " Already Registered");
			redirect_to("add-site-location.php");
		}
	} else {
		$product = $_POST['product'];	
		
		$auth_product 	= Product::authenticate_product($department, $site_location, $product);

		if($auth_product){
			//echo $_POST['product']. " Already Registered";
			$session->message($department.", ".$site_location.", ".$product. " Already Registered");
			redirect_to("add-site-location.php");
		}
	}


	$product_reg = new Product();

	$product_reg->department_id 		= $department_id;
	$product_reg->department 			= $department;
	$product_reg->site_location_id 		= $site_location_id;
	$product_reg->site_location 		= $site_location;
	$product_reg->product 				= $product;

	$product_reg->status				= 1;
	$product_reg->date_					= date("Y-m-d");
	$product_reg->time_					= date("H:i:s");
	
	if(!$auth_product ){
		if($product_reg->save()){
			//echo "Product Saved <br />";
			$session->message("Site Location Saved Successfully");
			redirect_to("add-site-location.php");
		} else {
			//echo "Product Failed <br />";
			$session->message(" Failed to Save Site Location");
			redirect_to("add-site-location.php");
		}
	}
	
	
	




	//$session->message("Employee Added Successfully.");
	//redirect_to("add-employee.php");
	
?>