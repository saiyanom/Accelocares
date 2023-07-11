<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	require '../PHPMailer/PHPMailerAutoload.php';
	//////date_default_timezone_set('Asia/Calcutta');	


	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("my-cvc.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+-]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("my-cvc.php");
		}
	}

	$employee = EmployeeReg::find_by_id($session->employee_id);


//   ----------------- Meeting Appointment  --------------------------------------------


	foreach ($_POST as $key => $value) {
		echo htmlspecialchars($key)." = ".htmlspecialchars($value)."<br>";
	}

	if(isset($_POST['create_cvc_meeting'])){
		
		if(	isset($_POST['company']) && !empty($_POST['company']) && isset($_POST['meeting_date']) && !empty($_POST['meeting_date'])
		  && isset($_POST['place']) && !empty($_POST['place'])){
			
			$meeting_date = $_POST['meeting_date']; 
			//$meeting_date = str_replace('/', '-', $meeting_date);
			$meeting_date = strtotime($meeting_date); 
			$meeting_date = date("Y-m-d", $meeting_date);	

			$curr_date = strtotime(date("Y-m-d"));
			$valid_date = date("Y-m-d", strtotime("-1 month", $curr_date));

			if($meeting_date < $valid_date){				
				//$session->message("User cannot create backdated meeting request - ".$valid_date); redirect_to("my-cvc.php");
				$session->message("User can create only one month backdated meeting request"); redirect_to("my-cvc.php");
			} 


			$company = CompanyReg::find_by_id($_POST['company']);

			$cvc_meeting = new CvcMeeting();

			$cvc_meeting->emp_id				= $employee->id;
			$cvc_meeting->emp_name				= $employee->emp_name;
			$cvc_meeting->emp_email				= $employee->emp_email;
			$cvc_meeting->comp_id				= $company->id;
			$cvc_meeting->comp_code				= $company->customer_id;
			$cvc_meeting->comp_name				= $company->company_name;
			$cvc_meeting->meeting_date			= $meeting_date;

			$cvc_meeting->place					= $_POST['place'];
			$cvc_meeting->meeting_objective		= $_POST['meeting_objective'];


			$cvc_meeting->status				= 0;
			$cvc_meeting->date_					= date("Y-m-d");
			$cvc_meeting->time_					= date("H:i:s");


			if($cvc_meeting->save()) {
				// Success
				$session->message("Meeting Added Successfully");
				redirect_to("my-cvc.php");
			} else {
				$session->message("Fail to Add Meeting");
				redirect_to("my-cvc.php");
			}
			
		} else {
			
			$session->message("Enter Mandatory Fields");
			redirect_to("my-cvc.php");
		}
	} 

	
	if(isset($_POST['create_cvc_meeting_discuss'])){
		
		if(!isset($_GET['id']) || empty($_GET['id'])){
			$session->message("Meeting Not Found");
			redirect_to("my-cvc.php");
		}
		
		if(!isset($_POST['meeting_status']) || empty($_POST['meeting_status'])){
			$session->message("Select Meeting Status");
			redirect_to("my-cvc.php");
		}
		
		if(empty($_POST['discussion']) && !isset($_FILES['discussion_document'])){
			$session->message("Upload Discussion Document OR Write Discussion");
			redirect_to("my-cvc.php");
		}
		
		$cvc_meeting = CvcMeeting::find_by_id($_GET['id']);
		
		if($_POST['meeting_status'] == "Yes"){
			$action_date = $_POST['action_date']; 
			$action_date = str_replace('/', '-', $action_date);
			$action_date = strtotime($action_date); 
			$action_date = date("Y-m-d", $action_date);		

			$cvc_meeting->meeting_status		= $_POST['meeting_status'];
			$cvc_meeting->discussion			= nl2br($_POST['discussion']);
			$cvc_meeting->action_by				= $_POST['action_by_name'];
			$cvc_meeting->remark				= "";
			$cvc_meeting->action_date			= $action_date;
			
			$cvc_meeting->status				= 1;
			
			
			

			if(isset($_FILES['discussion_document'])){
				$discussion_path = "../document/cvc/".$employee->id;

				$cvc_meeting->discussion				= "";
				$cvc_meeting->discussion_document 	= $_FILES['discussion_document']['name'];	
				$discussion_document				= basename($_FILES['discussion_document']['name']);

				if (!file_exists($discussion_path)) {
					mkdir("../document/cvc/".$employee->id, 0777, true);
				}

				if(!empty($discussion_document)) {
					$discussion_document 			= str_replace(" ","_",$discussion_document);
					$discussion_document 			= time()."-".$discussion_document;
					$cvc_meeting->discussion_document	= $discussion_document;
					$tp_photo 	=  	$discussion_path."/".$discussion_document;
					$move_photo 	= move_uploaded_file($_FILES['discussion_document']['tmp_name'], $tp_photo);
				} else {$cvc_meeting->discussion_document = "";}

			} 
			if(!empty($_POST['discussion'])){
				$cvc_meeting->discussion				= nl2br($_POST['discussion']);
				/*if(!empty($cvc_meeting->discussion_document)){
					$discussion_document				= "../document/cvc/".$employee->id."/".$cvc_meeting->discussion_document;
					$cvc_meeting->discussion_document	=	"";
					unlink($discussion_document);
				}*/
				
			}
		}
		
		if($_POST['meeting_status'] == "No"){
			$cvc_meeting->meeting_status		= $_POST['meeting_status'];
			$cvc_meeting->discussion			= "";
			$cvc_meeting->action_by				= "";
			$cvc_meeting->remark				= $_POST['remark'];
			$cvc_meeting->action_date			= "0000-00-00";
			
			$cvc_meeting->status				= 2;
		}
		
		if($_POST['meeting_status'] == "Reschedule"){
			$action_date = $_POST['action_date']; 
			$action_date = str_replace('/', '-', $action_date);
			$action_date = strtotime($action_date); 
			$action_date = date("Y-m-d", $action_date);		

			$cvc_meeting->meeting_status		= $_POST['meeting_status'];
			$cvc_meeting->discussion			= "";
			$cvc_meeting->action_by				= "";
			$cvc_meeting->remark				= $_POST['remark'];
			$cvc_meeting->action_date			= $action_date;
			
			$cvc_meeting->status				= 3;
		
		}

		if($cvc_meeting->save()) {
			// Success
			
			if($_POST['meeting_status'] == "Reschedule"){
				$cvc_meeting_new = new CvcMeeting();

				$cvc_meeting_new->emp_id				= $cvc_meeting->emp_id;
				$cvc_meeting_new->emp_name				= $cvc_meeting->emp_name;
				$cvc_meeting_new->emp_email				= $cvc_meeting->emp_email;
				$cvc_meeting_new->comp_id				= $cvc_meeting->comp_id;
				$cvc_meeting_new->comp_code				= $cvc_meeting->comp_code;
				$cvc_meeting_new->comp_name				= $cvc_meeting->comp_name;
				$cvc_meeting_new->meeting_date			= $action_date;

				$cvc_meeting_new->place					= $cvc_meeting->place;
				$cvc_meeting_new->meeting_objective		= $cvc_meeting->meeting_objective;

				$cvc_meeting->status					= 0;
				$cvc_meeting_new->date_					= date("Y-m-d");
				$cvc_meeting_new->time_					= date("H:i:s");

				$cvc_meeting_new->save();
			}
			$session->message("Meeting Added Successfully");
			redirect_to("my-cvc.php");
		} else {
			$session->message("Fail to Add Meeting");
			redirect_to("my-cvc.php");
		}
		
		
	} 




?>