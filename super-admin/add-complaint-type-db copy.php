<?php ob_start();
	require_once("../includes/initialize.php"); 
	date_default_timezone_set('Asia/Calcutta');

	
	$department			= Department::find_by_id($_POST['department']);

// Complaint Type Entry ************************************************************
	

	if($_POST['complaint_type'] == "new_complaint_type"){
		$complaint_type = $_POST['complaint_type_new'];
		
		$auth_complaint_type 	= ComplaintType::authenticate_complaint_type($department->id, $complaint_type);

		if($auth_complaint_type){
			//echo $_POST['complaint_type_new']. " Already Registered";
			$session->message($complaint_type.", Already Registered");
			redirect_to("complaint-type.php");
		}
	} else {
		$complaint_type = $_POST['complaint_type'];	
		
		$auth_complaint_type 	= ComplaintType::authenticate_complaint_type($department->id, $complaint_type);

		if($auth_complaint_type){
			//echo $_POST['complaint_type']. " Already Registered";
			$session->message($complaint_type.", Already Registered");
			redirect_to("complaint-type.php");
		}
	}


	if($_POST['complaint_type'] == "new_complaint_type"){
		$complaint_type = $_POST['complaint_type_new'];
		
		$auth_complaint_type 	= ComplaintType::authenticate_complaint_type($complaint_type);

		if($auth_complaint_type){
			//echo $_POST['complaint_type_new']. " Already Registered";
			$session->message($complaint_type. " Already Registered");
			redirect_to("complaint-type.php");
		}
		
		$complaint_type_reg = new ComplaintType();	

		$complaint_type_reg->department_id	 		= $department->id;
		$complaint_type_reg->department		 		= $department->department;

		$complaint_type_reg->complaint_type = $_POST['complaint_type_new'];

		$complaint_type_reg->status			= 1;
		$complaint_type_reg->date_			= date("Y-m-d");
		$complaint_type_reg->time_			= date("H:i:s");

		if($complaint_type_reg->save()){
			if(empty($_POST['sub_complaint_type'])){
				//$session->message("Complaint Saved Successfully");
				//redirect_to("complaint-type.php");
			}
			//echo "Complaint Saved <br />";
			$complaint_type_id 		= $complaint_type_reg->id;
		} else {
			echo "Complaint Failed <br />";
		}

	} else {
		$complaint_type 		= $_POST['complaint_type'];
		
		$auth_complaint_type 	= ComplaintType::authenticate_complaint_type($complaint_type);
		$complaint_type_id 		= $auth_complaint_type->id;
	}

	


// Sub Complaint Type Entry ************************************************************
	
	

	if($_POST['sub_complaint_type'] == "new_sub_complaint_type"){
		$sub_complaint_type = $_POST['sub_complaint_type_new'];
		
		$auth_sub_complaint_type 	= SubComplaintType::authenticate_sub_complaint_type($department->id, $complaint_type, $sub_complaint_type);

		if($auth_sub_complaint_type){
			//echo $_POST['sub_complaint_type_new']. " Already Registered";
			$session->message($complaint_type.", ".$sub_complaint_type. " Already Registered");
			redirect_to("complaint-type.php");
		}
	} else {
		$sub_complaint_type = $_POST['sub_complaint_type'];	
		
		$auth_sub_complaint_type 	= SubComplaintType::authenticate_sub_complaint_type($department->id, $complaint_type, $sub_complaint_type);

		if($auth_sub_complaint_type){
			//echo $_POST['sub_complaint_type']. " Already Registered";
			$session->message($complaint_type.", ".$sub_complaint_type. " Already Registered");
			redirect_to("complaint-type.php");
		}
	}

	


	$sub_complaint_type_reg = new SubComplaintType();

	$sub_complaint_type_reg->department_id	 		= $department->id;
	$sub_complaint_type_reg->department		 		= $department->department;
	$sub_complaint_type_reg->complaint_type_id 		= $complaint_type_id;
	$sub_complaint_type_reg->complaint_type 		= $complaint_type;
	$sub_complaint_type_reg->sub_complaint_type 	= $sub_complaint_type;

	$sub_complaint_type_reg->status					= 1;
	$sub_complaint_type_reg->date_					= date("Y-m-d");
	$sub_complaint_type_reg->time_					= date("H:i:s");
	
	if(!$auth_sub_complaint_type ){
		if($sub_complaint_type_reg->save()){
			//echo "sub_complaint_type Saved <br />";
			$session->message("Complaint Saved Successfully");
			redirect_to("complaint-type.php");
		} else {
			//echo "sub_complaint_type Failed <br />";
			$session->message(" Failed to Save Complaint");
			redirect_to("complaint-type.php");
		}
	}
	
	
	




	//$session->message("Employee Added Successfully.");
	//redirect_to("add-employee.php");
	
?>