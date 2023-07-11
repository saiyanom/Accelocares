<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	require '../PHPMailer/PHPMailerAutoload.php';


	foreach ($_POST as $key => $value) {
		if (preg_match('/[\"\^*}!{><;`=]/', $value)){
			$session->message("Remove Special Character"); redirect_to("my-complaints.php"); 
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\"\^*}!{><;`=]/', $value)){
			$session->message("Remove Special Character"); redirect_to("my-complaints.php"); 
		}
	}


	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	//date_default_timezone_set('Asia/Calcutta');

	$employee = EmployeeReg::find_by_id($session->employee_id);

	foreach ($_POST as $key => $value) {
		echo htmlspecialchars($key)." = ".htmlspecialchars($value)."<br>";
	}

	//return false;

	if(!isset($_GET['id']) || empty($_GET['id'])){
		$session->message('Complaint Not Found');
		redirect_to("my-complaints.php"); 
	}
	
	$complaint = Complaint::find_by_id($_GET['id']);


//   ----------------- Raised Complaint --------------------------------------------

	if(isset($_POST['edit_complaint'])){
		
		$business_vertical 	= Product::find_business_vertical($_POST['plant_location'], $_POST['product']);

		$sql = "Select * from employee_location where product_id = {$business_vertical->id} AND emp_sub_role = 'Employee' AND role_priority = 'Responsible' order by id ASC Limit 1";
		$employee_location = EmployeeLocation::find_by_sql($sql);

		if(!$employee_location){
			$session->message($_POST['plant_location']." Location Not Found");
			redirect_to("raised-complaint.php");
		}
		
		// Driver code 
		$date = $_POST['invoice_date']; 
		$date = str_replace('/', '-', $date);
		// convert date and time to seconds 
		$sec = strtotime($date); 

		// convert seconds into a specific format 
		$invoice_date = date("Y-m-d", $sec); 

		$complaint->product					= $_POST['product'];

		$complaint->plant_location			= $_POST['plant_location'];
		$complaint->business_vertical		= $business_vertical->department;

		if($_POST['complaint_type'] == "Other"){
			$complaint->complaint_type		= $_POST['complaintTypeOther'];
		} else {
			$complaint_type 	= ComplaintType::find_by_id($_POST['complaint_type']);
			$complaint->complaint_type			= $complaint_type->complaint_type;

			if($_POST['sub_complaint_type'] == "Other"){
				$complaint->sub_complaint_type		= $_POST['complaintSubTypeOther'];		
			} else {
				$complaint->sub_complaint_type		= $_POST['sub_complaint_type'];
			}
		}

		
		if (strpos($_POST['rejected_quantity'], 'MT') !== false) {
			$rejected_quantity = str_replace("MT","",$_POST['rejected_quantity']);
		} else if (strpos($_POST['rejected_quantity'], 'KG') !== false) {
			$rejected_quantity = str_replace("KG","",$_POST['rejected_quantity']);
		} else if (strpos($_POST['rejected_quantity'], 'Each') !== false) {
			$rejected_quantity = str_replace("Each","",$_POST['rejected_quantity']);
		} else {
			$rejected_quantity = $_POST['rejected_quantity'];
		}

		$complaint->rejected_quantity		= $rejected_quantity." ".$_POST['quantity_type'];
		
		$complaint->invoice_number			= $_POST['invoice_number'];
		$complaint->invoice_date			= $invoice_date;
		$complaint->defect_batch_no			= $_POST['defect_batch_no'];

		if($_POST['pl_name'] == "Other"){
			$complaint->pl_name				= $_POST['pl_name_2'];
		} else {
			$complaint->pl_name				= $_POST['pl_name'];
		}
		$complaint->pl_email				= $_POST['pl_email'];
		$complaint->pl_mobile				= $_POST['pl_mobile'];
		$complaint->pl_feedback				= $_POST['pl_feedback'];


		$path = "../document/".$complaint->ticket_no."/complaint";

		if(isset($_FILES['product_img_1'])){
			if($_FILES['product_img_1']['name']){
				$complaint->product_img_1 		= $_FILES['product_img_1']['name'];	
				$product_img_1					= basename($_FILES['product_img_1']['name']);

				if (!file_exists($path)) {
					mkdir("../document/".$complaint->ticket_no."/complaint", 0777, true);
				}

				if(!empty($product_img_1)) {
					$product_img_1 					= str_replace(" ","_",$product_img_1);
					$product_img_1 					= time()."-".$product_img_1;
					$complaint->product_img_1		= $product_img_1;
					$tp_photo 	=  	$path."/".$product_img_1;
					$move_photo 	= move_uploaded_file($_FILES['product_img_1']['tmp_name'], $tp_photo);
				} else {$complaint->product_img_1 = "";}
			} else {
				if($_POST['product_img_1_txt'] != "Yes"){
					$complaint->product_img_1 = "";
				}
			}
		}
		if(isset($_FILES['product_img_2'])){
			if($_FILES['product_img_2']['name']){
				$complaint->product_img_2 		= $_FILES['product_img_2']['name'];	
				$product_img_2					= basename($_FILES['product_img_2']['name']);

				if (!file_exists($path)) {
					mkdir("../document/".$complaint->ticket_no."/complaint", 0777, true);
				}

				if(!empty($product_img_2)) {
					$product_img_2 = str_replace(" ","_",$product_img_2);
					$product_img_2 					= time()."-".$product_img_2;
					$complaint->product_img_2		= $product_img_2;
					$tp_photo 	=  	$path."/".$product_img_2;
					$move_photo 	= move_uploaded_file($_FILES['product_img_2']['tmp_name'], $tp_photo);
				} else {$complaint->product_img_2 = "";}
			} else {
				if($_POST['product_img_2_txt'] != "Yes"){
					$complaint->product_img_2 = "";
				}
			}
		}
		if(isset($_FILES['product_img_3'])){
			if($_FILES['product_img_3']['name']){
				$complaint->product_img_3 		= $_FILES['product_img_3']['name'];	
				$product_img_3					= basename($_FILES['product_img_3']['name']);

				if (!file_exists($path)) {
					mkdir("../document/".$complaint->ticket_no."/complaint", 0777, true);
				}

				if(!empty($product_img_3)) {
					$product_img_3 					= str_replace(" ","_",$product_img_3);
					$product_img_3 					= time()."-".$product_img_3;
					$complaint->product_img_3		= $product_img_3;
					$tp_photo 	=  	$path."/".$product_img_3;
					$move_photo 	= move_uploaded_file($_FILES['product_img_3']['tmp_name'], $tp_photo);
				} else {$complaint->product_img_3 = "";}
			} else {
				if($_POST['product_img_3_txt'] != "Yes"){
					$complaint->product_img_3 = "";
				}
			}
		}
		
    $complaint->size          = getValue($_POST, 'size');

		
		if($complaint->save()) {
			// Success
			$session->message("Complaint Updated Successfully");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		} else {
			// Failure
			$session->message("Failed to Update Complaint");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
			
	}




//   ----------------- identify_the_source --------------------------------------------

	if(isset($_POST['identify_the_source'])){
		

		$complaint->emp_id						= $employee->id;
		$complaint->emp_name					= $employee->emp_name;

		$complaint->identify_source				= $_POST['id_source'];
		if($_POST['id_source'] == "Mill"){
			$complaint->mill					= $_POST['select_mill'];
		} else {
			$complaint->mill					= "";
		}

    $complaint->other_source   = ($_POST['id_source'] == "Other") ? $_POST['other_source'] : "";
    
		$complaint->client_contacted			= $_POST['client_contacted'];
		$complaint->identify_source_remark		= $_POST['identify_source_remark'];

		$complaint->cust_status					= "In Process";
		$complaint->emp_status					= "Complaint Attented";
		$complaint->status						= "Open";
		
		$complaint->identify_source_date		= date("Y-m-d");
		$complaint->identify_source_time		= date("H:i:s");


		if($complaint->save()) {
			// Success
			if($_POST['id_source'] == "Mill"){

        $toArr = [];
        
        $millReg = MillReg::find_by_mill_name($complaint->mill);

        $toArr[] = ['email' => $millReg->email_1, 'name' => $millReg->name_1 ];

        if(!empty($millReg->email_2)){
          $toArr[] = ['email' => $millReg->email_2, 'name' => $millReg->name_2 ];
        }
        if(!empty($millReg->email_3)){
          $toArr[] = ['email' => $millReg->email_3, 'name' => $millReg->name_3 ];
        }  

        $ccArr =[ ['email' => $employee->emp_email, 'name' => $employee->emp_name ] ];

        $bodyContent = "
          <p>Dear {$millReg->name_1},</p>

          <p>Season's greetings from Team Accelo...!</p>

          <p>We have received following complaint from our customer.</p>

          <h3>Complaint details are,</h3>
          <p><strong>Complaint ID. :</strong> {$complaint->ticket_no} <br />
          <p><strong>Customer Name. :</strong> {$complaint->company_name} <br />
          <strong>Nature of Complaint:</strong> {$complaint->business_vertical}, {$complaint->complaint_type}<br />
          <strong>Invoice No:</strong> {$complaint->invoice_number}<br />
          <strong>Invoice Date:</strong> {$complaint->invoice_date}<br />
          <strong>Batch No:</strong> {$complaint->defect_batch_no}</p>


          <p>Requesting you to co-ordinate with {$employee->emp_name}</p>

          <p>Kindly arrange resources for resolving the complaint.</p>
        ";
        $mailSubject = "Complaint from Mahindra Accelo Customer | Complaint ID #{$complaint->ticket_no}";

        sendComplaintMail($complaint, $mailSubject, $bodyContent, $toArr , $ccArr);

				/*$mail = new PHPMailer;
        $mail->IsMail();                            // Set mailer to use SMTP
				$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
				$mail->SMTPAuth = false;                     // Enable SMTP authentication
				$mail->Username = '';          // SMTP username
				$mail->Password = ''; // SMTP password
				$mail->Port = 25;                          // TCP port to connect to
				$mail->Mailer = "smtp";
				$mail->Priority = 1;
				$mail->setFrom('crm.accelo@emailmahindra.com', 'Mahindra Accelo');
				$mail->addAddress($millReg->email_1, $millReg->name_1);   // Add a recipient
				if(!empty($millReg->email_2)){
					$mail->addAddress($millReg->email_2, $millReg->name_2);   // Add a recipient
				}
				if(!empty($millReg->email_3)){
					$mail->addAddress($millReg->email_3, $millReg->name_3);   // Add a recipient
				}				
				$mail->addCC('salvi.suvarna@mahindra.com','Salvi Suvarna');
				$mail->addCC('gajelli.lalita@mahindra.com','Lalita Gajelli');
				$mail->addCC($employee->emp_email,$employee->emp_name);
				
				$mail->isHTML(true);  // Set email format to HTML

				$bodyContent = "

				<table  cellpadding='0' cellspacing='0' border='0' align='left' style=' background:#fff;width:700px;  min-width:300px; color:#262626; font-size:17px; font-family: Verdana, Geneva, sans-serif'>
					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
					<tr>
					<td  cellpadding='0' cellspacing='0' border='0' width='100%' style='display:block;'>
					<table border='0' style=' padding:30px '>

					<tr>
					<td style='line-height:23px'>

					<p>Dear {$millReg->name_1},</p>

					<p>Season's greetings from Team Accelo...!</p>

					<p>We have received following complaint from our customer.</p>

					<h3>Complaint details are,</h3>
					<p><strong>Complaint ID. :</strong> {$complaint->ticket_no} <br />
					<p><strong>Customer Name. :</strong> {$complaint->company_name} <br />
					<strong>Nature of Complaint:</strong> {$complaint->business_vertical}, {$complaint->complaint_type}<br />
					<strong>Invoice No:</strong> {$complaint->invoice_number}<br />
					<strong>Invoice Date:</strong> {$complaint->invoice_date}<br />
					<strong>Batch No:</strong> {$complaint->defect_batch_no}</p>


					<p>Requesting you to co-ordinate with {$employee->emp_name}</p>

					<p>Kindly arrange resources for resolving the complaint.</p>
					
					
					<p>Warm Regards, <br />
					CRM Team <br />
					<img src='".BASE_URL."administrator/images/logo.png' /></p>  
					<p><i>Note: This is an auto generated e-mail, hence please do not reply.</i></p>

					</td>
					</tr>
					</table>
					</td>
					</tr>

					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
				</table>
				";

				$mail->Subject = "Complaint from Mahindra Accelo Customer | Complaint ID #{$complaint->ticket_no}";
				$mail->Body    = $bodyContent;
				$mail->send();*/
			}

			$session->message("Complaint Updated Successfully");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		} else {
			// Failure
			$session->message("Failed to Update Complaint");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
	}



//   ----------------- Meeting Appointment  --------------------------------------------

	if(isset($_POST['complaint_meeting'])){
		
		
		$meeting_date = $_POST['meeting_date']; 
		
		//$meeting_date = str_replace('/', '-', $meeting_date);
		//$meeting_date = strtotime($meeting_date); 
		//$meeting_date = date("Y-m-d", $meeting_date);

		$meeting_date_2 = $_POST['meeting_date']; 
		$meeting_date_2 = str_replace('/', '-', $meeting_date_2);
		$meeting_date_2 = strtotime($meeting_date_2); 
		$meeting_date_2 = date("d F Y", $meeting_date_2);
		
		$auth_meeting	= ComplaintMeeting::auth_meeting($complaint->id,$complaint->emp_id,$meeting_date);
		
		if($auth_meeting){
			$session->message("You have Already Meeting on ".$meeting_date);
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
		
		$complaint_meeting = new ComplaintMeeting();

		$complaint_meeting->emp_id					= $complaint->emp_id;
		$complaint_meeting->emp_name				= $complaint->emp_name;
		$complaint_meeting->complaint_id			= $complaint->id;
		$complaint_meeting->customer_id				= $complaint->customer_id;
		$complaint_meeting->company_name			= $complaint->company_name;
		$complaint_meeting->ticket_no				= $complaint->ticket_no;
		$complaint_meeting->request_visit			= "Yes";
		//$complaint_meeting->r_visit_remark			= $_POST['r_visit_remark'];
		$complaint_meeting->meeting_date			= $meeting_date;
		$complaint_meeting->place					= $_POST['place'];
		if($_POST['customer_coordinator'] == "Other"){
			$complaint_meeting->customer_coordinator	= $_POST['customer_coordinator_2'];
		} else {
			$complaint_meeting->customer_coordinator	= $_POST['customer_coordinator'];
		}
		$complaint_meeting->mobile					= $_POST['mobile'];
		$complaint_meeting->email					= $_POST['email'];
		//$complaint_meeting->cancel_remark			= $_POST['cancel_remark'];
		//$complaint_meeting->visit_done				= $_POST['visit_done'];

		$complaint_meeting->date_					= date("Y-m-d");
		$complaint_meeting->time_					= date("H:i:s");


		if($complaint_meeting->save()) {
			// Success

			$complaint->request_visit		= $_POST['request_visit'];		
			$complaint->request_remark		= "";
			$complaint->emp_status			= "Visit Confirmed";
			$complaint->cust_status			= "Visit Confirmed";
			$complaint->request_visit_date	= date("Y-m-d");	
			$complaint->request_visit_time	= date("H:i:s");


			$complaint->request_visit			= "Yes";
			$complaint->save();

			$mail = new PHPMailer;

			$mail->IsMail();                            // Set mailer to use SMTP
			$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
			$mail->SMTPAuth = false;                     // Enable SMTP authentication
			$mail->Username = '';          // SMTP username
			$mail->Password = ''; // SMTP password
			////$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 25;                          // TCP port to connect to

			//$mail->SMTPDebug = 2;
			$mail->Mailer = "smtp";
			$mail->Priority = 1;
			$mail->setFrom('crm.accelo@emailmahindra.com', 'Mahindra Accelo');
			//$mail->addAddress('richa@agency09.in', 'Richa');   // Add a recipient
			$mail->addAddress($complaint_meeting->email,$complaint_meeting->customer_coordinator);
			$mail->addCC('salvi.suvarna@mahindra.com','Salvi Suvarna');
			$mail->addCC('gajelli.lalita@mahindra.com','Lalita Gajelli');
			$mail->addCC($complaint->pl_email, $complaint->pl_name);   // Add a recipient
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');

			$mail->isHTML(true);  // Set email format to HTML

			$bodyContent = "
				<table  cellpadding='0' cellspacing='0' border='0' align='left' style=' background:#fff;width:700px;  min-width:300px; color:#262626; font-size:17px; font-family: Verdana, Geneva, sans-serif'>
					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
					<tr>
					<td  cellpadding='0' cellspacing='0' border='0' width='100%' style='display:block;'>
					<table border='0' style=' padding:30px '>

					<tr>
					<td style='line-height:23px'>

					<p>Dear Ma'am / Sir,</p>

					<p>Greetings from Team Accelo!</p>
			
					<p>As per our last conversation, one of our officials will be visiting your site on {$meeting_date_2}, to understand the situation and identify solution for the feedback given by you.</p>

					<p>We thank you for your time!</p>


					<p>Warm Regards, <br />
					CRM Team <br />
					<img src='".BASE_URL."administrator/images/logo.png' /></p>  
					<p><i>Note: This is an auto generated e-mail, hence please do not reply.</i></p>

					</td>
					</tr>
					</table>
					</td>
					</tr>

					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
				</table>
			";

			$mail->Subject = getComplaintSubjectAdmin($complaint);
			$mail->Body    = $bodyContent;

			if(!$mail->send()) {
			    $session->message("Meeting Added Successfully, Mail could not be sent.");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			} else {
			    $session->message("Meeting Added Successfully");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			}
		} else {
			$session->message("Failed to Add Meeting");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
	}


//   ----------------- Request A Visit --------------------------------------------

	if(isset($_POST['request_a_visit'])){
		
		if(empty($_POST['request_visit'])){
			$session->message("Select Request Visit Yes / No");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
		
		if($_POST['request_visit'] == "Yes"){
			
			$auth_meeting	= ComplaintMeeting::find_by_comp_id($complaint->id);
		
			if($auth_meeting){

				$complaint->request_visit		= $_POST['request_visit'];		
				$complaint->request_remark		= "";
				$complaint->emp_status			= "Visit Confirmed";
				$complaint->cust_status			= "Visit Confirmed";
				$complaint->request_visit_date	= date("Y-m-d");	
				$complaint->request_visit_time	= date("H:i:s");

				if($complaint->save()) {
					// Success
					$session->message("Complaint Updated Successfully");
					redirect_to("view-complaints.php?id=".$_GET['id']);
				} else {
					// Failure
					$session->message("Failed to Update Complaint");
					redirect_to("view-complaints.php?id=".$_GET['id']);
				}

			} else {
				$session->message("Create Meeting First.");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			}
		} else {
			if(empty($_POST['request_remark'])){
				$session->message("Enter Request Visit Remark");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			}
			
			$complaint->request_visit		= $_POST['request_visit'];
			$complaint->request_remark		= $_POST['request_remark'];
						
			if($complaint->save()) {
				// Success
				$session->message("Complaint Updated Successfully");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			} else {
				// Failure
				$session->message("Failed to Update Complaint");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			}
		}		
		
	}



//   ----------------- visit_a_done --------------------------------------------

	if(isset($_POST['visit_a_done'])){
		
		if($_POST['visit_done'] == "Yes"){
			if(empty($_POST['product_status']) || empty($_POST['visit_done'])){
				$session->message("Select Visit Status & Product Status");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			}	

			if($_POST['product_status'] == "Others"){
				if(empty($_POST['product_status_specify'])){
					$session->message("Please Specify Product Status");
					redirect_to("view-complaints.php?id=".$_GET['id']);
				}
			}	
		} else if($_POST['visit_done'] == "No"){
			if(empty($_POST['visit_remark'])){
				$session->message("Enter Visit Remark");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			}
		}
			
		
		
		if(empty($_POST['mom_written']) && !isset($_FILES['mom_document'])){
			$session->message("Upload MOM Document OR Write MOM");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
				
		if($_POST['visit_done'] == "Yes"){
			$complaint->visit_done				= $_POST['visit_done'];
			$complaint->visit_remark			= "";
			
			$complaint->cust_status				= "MOM Uploaded";
			
			if($_POST['product_status'] == "Others"){
				$complaint->product_status			= $_POST['product_status'];
				$complaint->product_status_specify	= $_POST['product_status_specify'];
				
				$complaint->emp_status				= "MOM Created";
			} else {
				$complaint->product_status			= $_POST['product_status'];
				$complaint->product_status_specify	= "";
				
				$complaint->emp_status				= "MOM Created";
			}			
			
			if(isset($_FILES['mom_document'])){
				$mom_path = "../document/".$complaint->ticket_no."/mom";

				$complaint->mom_written				= "";
				$complaint->mom_document 			= $_FILES['mom_document']['name'];	
				$mom_document						= basename($_FILES['mom_document']['name']);

				if (!file_exists($mom_path)) {
					mkdir("../document/".$complaint->ticket_no."/mom", 0777, true);
				}

				if(!empty($mom_document)) {
					$mom_document 					= str_replace(" ","_",$mom_document);
					$mom_document 					= time()."-".$mom_document;
					$complaint->mom_document		= $mom_document;
					$tp_photo 	=  	$mom_path."/".$mom_document;
					$move_photo 	= move_uploaded_file($_FILES['mom_document']['tmp_name'], $tp_photo);
				} else {$complaint->mom_document = "";}
			} 
			if(!empty($_POST['mom_written'])){
				$complaint->mom_written				= nl2br($_POST['mom_written']);
				/*if(!empty($complaint->mom_document)){
					$mom_document						= "../document/".$complaint->ticket_no."/mom/".$complaint->mom_document;
					$complaint->mom_document	=	"";
					unlink($mom_document);
				}*/
			}

			$path = "../document/".$complaint->ticket_no."/plant";

			if(isset($_FILES['plant_img_1'])){
				$complaint->plant_img_1 		= $_FILES['plant_img_1']['name'];	
				$plant_img_1					= basename($_FILES['plant_img_1']['name']);

				if (!file_exists($path)) {
					mkdir("../document/".$complaint->ticket_no."/plant", 0777, true);
				}

				if(!empty($plant_img_1)) {
					$plant_img_1 					= str_replace(" ","_",$plant_img_1);
					$plant_img_1 					= time()."-".$plant_img_1;
					$complaint->plant_img_1		= $plant_img_1;
					$tp_photo 	=  	$path."/".$plant_img_1;
					$move_photo 	= move_uploaded_file($_FILES['plant_img_1']['tmp_name'], $tp_photo);
				} else {$complaint->plant_img_1 = "";}

			}
			if(isset($_FILES['plant_img_2'])){
				$complaint->plant_img_2 		= $_FILES['plant_img_2']['name'];	
				$plant_img_2					= basename($_FILES['plant_img_2']['name']);

				if (!file_exists($path)) {
					mkdir("../document/".$complaint->ticket_no."/plant", 0777, true);
				}

				if(!empty($plant_img_2)) {
					$plant_img_2 = str_replace	(" ","_",$plant_img_2);
					$plant_img_2 					= time()."-".$plant_img_2;
					$complaint->plant_img_2		= $plant_img_2;
					$tp_photo 	=  	$path."/".$plant_img_2;
					$move_photo 	= move_uploaded_file($_FILES['plant_img_2']['tmp_name'], $tp_photo);
				} else {$complaint->plant_img_2 = "";}
			}
			if(isset($_FILES['plant_img_3'])){
				$complaint->plant_img_3 		= $_FILES['plant_img_3']['name'];	
				$plant_img_3					= basename($_FILES['plant_img_3']['name']);

				if (!file_exists($path)) {
					mkdir("../document/".$complaint->ticket_no."/plant", 0777, true);
				}

				if(!empty($plant_img_3)) {
					$plant_img_3 					= str_replace(" ","_",$plant_img_3);
					$plant_img_3 					= time()."-".$plant_img_3;
					$complaint->plant_img_3		= $plant_img_3;
					$tp_photo 	=  	$path."/".$plant_img_3;
					$move_photo 	= move_uploaded_file($_FILES['plant_img_3']['tmp_name'], $tp_photo);
				} else {$complaint->plant_img_3 = "";}
			}
			if(isset($_FILES['plant_img_4'])){
				$complaint->plant_img_4 		= $_FILES['plant_img_4']['name'];	
				$plant_img_4					= basename($_FILES['plant_img_4']['name']);

				if (!file_exists($path)) {
					mkdir("../document/".$complaint->ticket_no."/plant", 0777, true);
				}

				if(!empty($plant_img_4)) {
					$plant_img_4 					= str_replace(" ","_",$plant_img_4);
					$plant_img_4 					= time()."-".$plant_img_4;
					$complaint->plant_img_4		= $plant_img_4;
					$tp_photo 						=  	$path."/".$plant_img_4;
					$move_photo 	= move_uploaded_file($_FILES['plant_img_4']['tmp_name'], $tp_photo);
				} else {$complaint->plant_img_4 = "";}
			}
			if(isset($_FILES['plant_img_5'])){
				$complaint->plant_img_5 		= $_FILES['plant_img_5']['name'];	
				$plant_img_5					= basename($_FILES['plant_img_5']['name']);

				if (!file_exists($path)) {
					mkdir("../document/".$complaint->ticket_no."/plant", 0777, true);
				}

				if(!empty($plant_img_5)) {
					$plant_img_5 					= str_replace(" ","_",$plant_img_5);
					$plant_img_5 					= time()."-".$plant_img_5;
					$complaint->plant_img_5		= $plant_img_5;
					$tp_photo 						=  	$path."/".$plant_img_5;
					$move_photo 	= move_uploaded_file($_FILES['plant_img_5']['tmp_name'], $tp_photo);
				} else {$complaint->plant_img_5 = "";}
			}						
		} else {
			$complaint->visit_done				= $_POST['visit_done'];
			$complaint->visit_remark			= $_POST['visit_remark'];
			
			$complaint->mom_written				= "";
			$complaint->product_status			= "";
			$complaint->product_status_specify	= "";
			
			$complaint->cust_status				= "MOM Uploaded";
			$complaint->emp_status				= "MOM Created";
		}
		
		$complaint->visit_done_date				= date("Y-m-d");
		$complaint->visit_done_time				= date("H:i:s");

		$meeting	= ComplaintMeeting::find_by_comp_id($complaint->id);

		if($complaint->save()) {
			// Success

			$mail = new PHPMailer;

			$mail->IsMail();                            // Set mailer to use SMTP
			$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
			$mail->SMTPAuth = false;                     // Enable SMTP authentication
			$mail->Username = '';          // SMTP username
			$mail->Password = ''; // SMTP password
			////$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 25;                          // TCP port to connect to

			//$mail->SMTPDebug = 2;
			$mail->Mailer = "smtp";
			$mail->Priority = 1;
			$mail->setFrom('crm.accelo@emailmahindra.com', 'Mahindra Accelo');
			if(empty($meeting->email)){
				$mail->addAddress($complaint->pl_email, $complaint->pl_name);   // Add a recipient
			} else {
				$mail->addAddress($meeting->email, $meeting->customer_coordinator);   // Add a recipient
				$mail->addCC($complaint->pl_email, $complaint->pl_name);   // Add a recipient
			}
			
			$mail->addCC('salvi.suvarna@mahindra.com','Salvi Suvarna');
			$mail->addCC('gajelli.lalita@mahindra.com','Lalita Gajelli');
			
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');

			$mail->isHTML(true);  // Set email format to HTML

			if($complaint->product_status == "Others"){
				$product_status = $complaint->product_status_specify;
			} else { $product_status = $complaint->product_status; }

			$bodyContent = "
				<table  cellpadding='0' cellspacing='0' border='0' align='left' style=' background:#fff;width:700px;  min-width:300px; color:#262626; font-size:17px; font-family: Verdana, Geneva, sans-serif'>
					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
					<tr>
					<td  cellpadding='0' cellspacing='0' border='0' width='100%' style='display:block;'>
					<table border='0' style=' padding:30px '>

					<tr>
					<td style='line-height:23px'>

					<p>Dear Ma'am / Sir,</p> 

					<p>Greetings from Mahindra Accelo,</p>

					<p>We have compiled the Minutes of the Meeting (MOM) for your reference. The complaint status is as follows - {$product_status}</p>

					<p>Please click on below link for viewing the MOM.</p>
					<a style='text-decoration:none; color:#1774b5' href='".BASE_URL."customer/'>".BASE_URL."customer/</a>


					<br /><br />

					<p>Warm Regards, <br />
					CRM Team <br />
					<img src='".BASE_URL."administrator/images/logo.png' /></p>  
					<p><i>Note: This is an auto generated e-mail, hence please do not reply.</i></p>

					</td>
					</tr>
					</table>
					</td>
					</tr>

					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
				</table>
			";

			$mail->Subject = getComplaintSubjectAdmin($complaint);
			$mail->Body    = $bodyContent;

			if(!$mail->send()) {
			    //echo 'Mail could not be sent. <br />';
			    //echo 'Mailer Error: ' . $mail->ErrorInfo;
			    $session->message("Meeting Added Successfully, Mail could not be sent.");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			} else {
			    //echo 'Message has been sent';
			    $session->message("Complaint Updated Successfully");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			}			
		} else {
			// Failure
			$session->message("Failed to Update Complaint");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
	}

//   ----------------- Complaint Accepted or Not --------------------------------------------

	if(isset($_POST['complaint_a_accepted'])){
				
		if($_POST['complaint_accepted'] == "Yes"){
			if(empty($_POST['complaint_accepted']) || empty($_POST['recommended_advice']) || empty($_POST['action_by_name']) || empty($_POST['action_by_date'])) {
				$session->message("Enter Mandatory Fields");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			}			
		} 
		
		if($_POST['complaint_accepted'] == "No"){
			if(empty($_POST['complaint_remark'])) {
				$session->message("Enter Compliant Remark");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			}
		} 
		
		if($_POST['complaint_accepted'] == "Decision Pending"){
			if(empty($_POST['complaint_accepted']) || empty($_POST['complaint_remark']) || empty($_POST['action_by_name'])) {
				$session->message("Enter Mandatory Fields");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			}
		} 
		
		if($_POST['complaint_accepted'] == "Yes"){
			if($_POST['recommended_advice'] == "Others"){
				if(empty($_POST['other_advice'])){
					$session->message("Enter Mandatory Fields");
					redirect_to("view-complaints.php?id=".$_GET['id']);
				}
			} 
		}
		
		
		// Driver code 
		$action_by_date = $_POST['action_by_date']; 
		$action_by_date = str_replace('/', '-', $action_by_date);
		// convert date and time to seconds 
		$action_by_date = strtotime($action_by_date); 
		// convert seconds into a specific format 
		$action_by_date = date("Y-m-d", $action_by_date);
		
		if($_POST['complaint_accepted'] == "Yes"){
			$complaint->complaint_accepted		= $_POST['complaint_accepted'];
			$complaint->complaint_remark		= "";
			if($_POST['recommended_advice'] == "Others"){
				$complaint->other_advice		= $_POST['other_advice'];
			} else {
				$complaint->other_advice		= $_POST['recommended_advice'];
			}
			$complaint->action_by_name			= $_POST['action_by_name'];
			$complaint->action_by_date			= $action_by_date;
			
			$complaint->cust_status				= "Complaint Accepted";
			$complaint->emp_status				= "Complaint Accepted";
			$complaint->status					= "Open";


			$empReg = EmployeeReg::find_by_emp_name($_POST['action_by_name']);


			$bodyContent = "
				<table  cellpadding='0' cellspacing='0' border='0' align='left' style=' background:#fff;width:700px;  min-width:300px; color:#262626; font-size:17px; font-family: Verdana, Geneva, sans-serif'>
					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
					<tr>
					<td  cellpadding='0' cellspacing='0' border='0' width='100%' style='display:block;'>
					<table border='0' style=' padding:30px '>

					<tr>
					<td style='line-height:23px'>

					<p>Dear {$empReg->emp_name},</p>

					<p>We are in process of resolving the following complaint and we are adding you in the loop.</p>

					<p><strong>Complaint detail are,</strong><br />
					<strong>Complaint ID :</strong> {$complaint->ticket_no}<br />
					<strong>Customer Name :</strong> {$complaint->company_name}<br />
					<strong>Nature of Complaint :</strong> {$complaint->business_vertical}, {$complaint->complaint_type}<br />
					<strong>Source :</strong> {$complaint->identify_source}<br />
	
					<p>The action to be taken by you is: {$complaint->other_advice}</p>							

					<p>Requesting you to execute the action as soon as possible</p>							


					<p>Thank You!</p>
					<p>Warm Regards, <br />
					CRM Team <br />
					<img src='".BASE_URL."administrator/images/logo.png' /></p>  
					<p><i>Note: This is an auto generated e-mail, hence please do not reply.</i></p>

					</td>
					</tr>
					</table>
					</td>
					</tr>

					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
				</table>
			";

			$mail = new PHPMailer;

			$mail->IsMail();                            // Set mailer to use SMTP
			$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
			$mail->SMTPAuth = false;                     // Enable SMTP authentication
			$mail->Username = '';          // SMTP username
			$mail->Password = ''; // SMTP password
			////$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 25;                          // TCP port to connect to

			//$mail->SMTPDebug = 2;
			$mail->Mailer = "smtp";
			$mail->Priority = 1;
			$mail->setFrom('crm.accelo@emailmahindra.com', 'Mahindra Accelo');
			$mail->addAddress($empReg->emp_email, $complaint->emp_name);   // Add a recipient
			$mail->addCC('salvi.suvarna@mahindra.com','Salvi Suvarna');
			$mail->addCC('gajelli.lalita@mahindra.com','Lalita Gajelli');
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');

			$mail->isHTML(true);  // Set email format to HTML

			$mail->Subject = getComplaintSubjectAdmin($complaint);
			$mail->Body    = $bodyContent;

			if(!$mail->send()) {
			    //echo 'Mail could not be sent. <br />';
			    //echo 'Mailer Error: ' . $mail->ErrorInfo;
			    $session->message("Complaint Updated Successfully, Mail could not be sent.");
				//redirect_to("view-complaints.php?id=".$_GET['id']);
			} else {
			    $session->message("Complaint Updated Successfully");
				//redirect_to("view-complaints.php?id=".$_GET['id']);
			}

			$bodyContent = "
				<table  cellpadding='0' cellspacing='0' border='0' align='left' style=' background:#fff;width:700px;  min-width:300px; color:#262626; font-size:17px; font-family: Verdana, Geneva, sans-serif'>
					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
					<tr>
					<td  cellpadding='0' cellspacing='0' border='0' width='100%' style='display:block;'>
					<table border='0' style=' padding:30px '>

					<tr>
					<td style='line-height:23px'>

					<p>Dear Ma'am / Sir,</p>
					<p>Greetings from Mahindra Accelo,</p>

					<p>We have analysed your complaint.</p> 

					<p>We are pleased to notify you, that your registered feedback with the Complaint ID - {$complaint->ticket_no} has been accepted!</p> 

					<p>We've identified the reason for the inconvenience caused & the recommended solution is: {$complaint->other_advice}</p> 
		 
					<p>Team Accelo is currently working on initiating / implementing the solution mentioned above & will get in touch with you shortly!</p>
		 

					<p>Thank You!</p>
					<p>Warm Regards, <br />
					CRM Team <br />
					<img src='".BASE_URL."administrator/images/logo.png' /></p>  
					<p><i>Note: This is an auto generated e-mail, hence please do not reply.</i></p>

					</td>
					</tr>
					</table>
					</td>
					</tr>

					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
				</table>
			";
		}
		else if($_POST['complaint_accepted'] == "No"){
			$complaint->complaint_accepted		= $_POST['complaint_accepted'];
			$complaint->complaint_remark		= $_POST['complaint_remark'];
			$complaint->other_advice			= "";
			$complaint->action_by_name			= "";
			$complaint->action_by_date			= "";
			
			$complaint->cust_status				= "Complaint Rejected";
			$complaint->emp_status				= "Complaint Rejected";
			$complaint->status					= "Invalid";


			$bodyContent = "
				<table  cellpadding='0' cellspacing='0' border='0' align='left' style=' background:#fff;width:700px;  min-width:300px; color:#262626; font-size:17px; font-family: Verdana, Geneva, sans-serif'>
					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
					<tr>
					<td  cellpadding='0' cellspacing='0' border='0' width='100%' style='display:block;'>
					<table border='0' style=' padding:30px '>

					<tr>
					<td style='line-height:23px'>

					<p>Dear Ma'am / Sir,</p>
					<p>Greetings from Mahindra Accelo,</p>

					<p>We have analysed your complaint and based on our co-ordination wit you and your team, the Complaint ID - {$complaint->ticket_no} has been rejected...!</p> 
					 
					<p>We appreciate your patience & hope your experience with Team Accelo was smooth.</p>
		 
					<p>Warm Regards, <br />
					CRM Team <br />
					<img src='".BASE_URL."administrator/images/logo.png' /></p>  
					<p><i>Note: This is an auto generated e-mail, hence please do not reply.</i></p>

					</td>
					</tr>
					</table>
					</td>
					</tr>

					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
				</table>
			
			";
		}
		else if($_POST['complaint_accepted'] == "Decision Pending"){
			$complaint->complaint_accepted		= $_POST['complaint_accepted'];
			$complaint->complaint_remark		= $_POST['complaint_remark'];
			$complaint->other_advice			= "";
			$complaint->action_by_name			= $_POST['action_by_name'];
			$complaint->action_by_date			= $action_by_date;
			
			$complaint->cust_status				= "Decision Pending";
			$complaint->emp_status				= "Decision Pending";
			$complaint->status					= "Open";
		}
		
		if($complaint->save()) {
			// Success
			
			if($_POST['complaint_accepted'] != "Decision Pending"){

				$empReg = EmployeeReg::find_by_emp_name($_POST['action_by_name']);

				$mail = new PHPMailer;

				$mail->IsMail();                            // Set mailer to use SMTP
				$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
				$mail->SMTPAuth = false;                     // Enable SMTP authentication
				$mail->Username = '';          // SMTP username
				$mail->Password = ''; // SMTP password
				////$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 25;                          // TCP port to connect to

				//$mail->SMTPDebug = 2;
				$mail->Mailer = "smtp";
				$mail->Priority = 1;
				$mail->setFrom('crm.accelo@emailmahindra.com', 'Mahindra Accelo');
				$mail->addAddress($complaint->pl_email, $complaint->pl_name);   // Add a recipient
				$mail->addCC('salvi.suvarna@mahindra.com','Salvi Suvarna');
				$mail->addCC('gajelli.lalita@mahindra.com','Lalita Gajelli');
				//$mail->addCC('cc@example.com');
				//$mail->addBCC('bcc@example.com');

				$mail->isHTML(true);  // Set email format to HTML

				$mail->Subject = getComplaintSubjectAdmin($complaint);
				$mail->Body    = $bodyContent;

				if(!$mail->send()) {
				    //echo 'Mail could not be sent. <br />';
				    //echo 'Mailer Error: ' . $mail->ErrorInfo;
				    $session->message("Complaint Updated Successfully, Mail could not be sent.");
					redirect_to("view-complaints.php?id=".$_GET['id']);
				} else {
				    $session->message("Complaint Updated Successfully");
					redirect_to("view-complaints.php?id=".$_GET['id']);
				}
			} else {
				$session->message("Complaint Updated Successfully");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			}
		} else {
			// Failure
			$session->message("Failed to Update Complaint");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
	}



//   ----------------- Approval Note Create --------------------------------------------

	if(isset($_POST['create_a_note'])){
    // dd($_POST);
		if(empty($_POST['customer_name']) || empty($_POST['nature_of_complaint']) || empty($_POST['complait_reference']) || empty($_POST['name_of_sm_sc_t'])
		 	|| empty($_POST['complait_reg_date']) || empty($_POST['responsibility']) || empty($_POST['material_details']) || empty($_POST['billing_doc_no'])
		    || empty($_POST['total_qty_rejc_type']) || empty($_POST['billing_doc_date']) || empty($_POST['basic_sale_price'])
		 ) {
			// Success
			$session->message("Enter Mandatory Fields");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
		
    // $complaint->identify_source
		if(empty($_POST['qty_acpt_steel_mill_type']) && empty($_POST['qty_scrp_auc_serv_cent_type']) && empty($_POST['qty_dlv_customer_type'])) {
			// Success
			$session->message("Enter any One Quantity (t)");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
		
		if($_POST['debit_note_sal_rate_sale_value'] < 0) {
			// Success
			$session->message("Enter Debit note Amount");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
		
		$complait_reg_date = $_POST['complait_reg_date']; 
		$complait_reg_date = str_replace('/', '-', $complait_reg_date);
		$complait_reg_date = strtotime($complait_reg_date); 
		$complait_reg_date = date("Y-m-d", $complait_reg_date);

		$billing_doc_date = $_POST['billing_doc_date']; 
		$billing_doc_date = str_replace('/', '-', $billing_doc_date);
		$billing_doc_date = strtotime($billing_doc_date); 
		$billing_doc_date = date("Y-m-d", $billing_doc_date);


		// ******************* Approval Note Calculation Start *******************	
		
		$total_qty_rejc 	= $_POST["total_qty_rejc"];
		$basic_sale_price 	= $_POST["basic_sale_price"];
		$sales_value 		= $total_qty_rejc * $basic_sale_price;
		
		$cgst 	= ($sales_value / 100) * round($_POST["cgst_percent"], 2);
		$sgst 	= ($sales_value / 100) * round($_POST["sgst_percent"], 2);
		$cgst 	= round($cgst, 2);
		$sgst 	= round($sgst, 2);
		
		$cost_inc_customer 	= $_POST["cost_inc_customer"];
		$salvage_value 		= $_POST["salvage_value"];
		
		$credit_note_iss_cust = round($sales_value, 2) + round($cgst, 2) + round($sgst, 2) + round($cost_inc_customer, 2) - round($salvage_value, 2);
				
		$qty_acpt_steel_mill 			= $_POST["qty_acpt_steel_mill"];
		$qty_scrp_auc_serv_cent 		= $_POST["qty_scrp_auc_serv_cent"];
		$qty_dlv_customer 				= $_POST["qty_dlv_customer"];
		
		$qty_debit						= $qty_acpt_steel_mill + $qty_scrp_auc_serv_cent + $qty_dlv_customer;
		
		$debit_note_sal_rate_sale_value = $_POST["debit_note_sal_rate_sale_value"];
		$value 							= $qty_debit * $debit_note_sal_rate_sale_value;
		$value 							= round($value, 2);
		
		$loss_cgst 	= ($value / 100) * round($_POST["lcgst_percent"], 2);
		$loss_sgst 	= ($value / 100) * round($_POST["lsgst_percent"], 2);
		$loss_cgst 	= round($loss_cgst, 2);
		$loss_sgst 	= round($loss_sgst, 2);
				
		
		$total_debit_value = $value + $loss_cgst + $loss_sgst;
		$total_debit_value = round($total_debit_value, 2);
		
		$oth_exp_inc_mill 			= $_POST["oth_exp_inc_mill"];
		$oth_exp_debited 			= $_POST["oth_exp_debited"];
		$compensation_exp 			= $_POST["compensation_exp"];
		
		
		$debit_note_iss_supplier 	= $value + $loss_cgst + $loss_sgst + $oth_exp_debited;
		$debit_note_iss_supplier 	= round($debit_note_iss_supplier, 2);
		
		$loss_from_rejection 		= ($sales_value - $value) + ($oth_exp_inc_mill - $oth_exp_debited - $compensation_exp);

		$loss_from_rejection 		= round($loss_from_rejection, 2);
		
		
		$recoverable_transporter 	= $_POST["recoverable_transporter"];
    $other_realisation  = $_POST["other_realisation"];
		$net_loss					= $loss_from_rejection - $recoverable_transporter - $other_realisation;
		$net_loss					= round($net_loss, 2);

		// ******************* Approval Note Calculation End *******************

		$found_appr_note = ApprovalNote::find_by_comp_id($_GET['id']);
		
		if($found_appr_note && $complaint->approval_on_hold == 0){
			$appr_note = ApprovalNote::find_by_id($found_appr_note->id);
		} else {
			$appr_note = new ApprovalNote();
		}
				

		$appr_note->complaint_id			= $complaint->id;
		$appr_note->customer_id				= $complaint->customer_id;
		$appr_note->company_name			= $complaint->company_name;
		$appr_note->ticket_no				= $complaint->ticket_no;

		$appr_note->customer_name			= $_POST['customer_name'];
		$appr_note->nature_of_complaint		= $_POST['nature_of_complaint'];
		$appr_note->complait_reference		= $_POST['complait_reference'];
		$appr_note->name_of_sm_sc_t			= $_POST['name_of_sm_sc_t'];
		$appr_note->complait_reg_date		= $complait_reg_date;
		$appr_note->responsibility			= $_POST['responsibility'];
		$appr_note->material_details		= $_POST['material_details'];
		$appr_note->billing_doc_no			= $_POST['billing_doc_no'];
		$appr_note->total_qty_rejc			= $_POST['total_qty_rejc']." ".$_POST['total_qty_rejc_type'];
		$appr_note->billing_doc_date		= $billing_doc_date;
		$appr_note->basic_sale_price_txt	= $_POST['basic_sale_price_txt'];
		$appr_note->basic_sale_price		= $_POST['basic_sale_price'];
		$appr_note->sales_value				= $sales_value; //$_POST['sales_value'];
		$appr_note->cgst_percent			= $_POST['cgst_percent']; //$_POST['cgst'];
		$appr_note->cgst					= $cgst; //$_POST['cgst'];
		$appr_note->sgst_percent			= $_POST['sgst_percent']; //$_POST['sgst'];
		$appr_note->sgst					= $sgst; //$_POST['sgst'];
		$appr_note->cost_inc_customer_txt	= $_POST['cost_inc_customer_txt'];
		$appr_note->cost_inc_customer		= $_POST['cost_inc_customer'];
		$appr_note->salvage_value_txt		= $_POST['salvage_value_txt'];
		$appr_note->salvage_value			= $_POST['salvage_value'];
		$appr_note->credit_note_iss_cust	= $credit_note_iss_cust; //$_POST['credit_note_iss_cust'];
		//$appr_note->debit_note_supplier		= $_POST['debit_note_supplier'];
		$appr_note->qty_acpt_steel_mill		= $_POST['qty_acpt_steel_mill']." ".$_POST['qty_acpt_steel_mill_type'];
		$appr_note->qty_scrp_auc_serv_cent	= $_POST['qty_scrp_auc_serv_cent']." ".$_POST['qty_scrp_auc_serv_cent_type'];
		$appr_note->qty_dlv_customer		= $_POST['qty_dlv_customer']." ".$_POST['qty_dlv_customer_type'];		
		$appr_note->debit_salvage_sale_txt	= $_POST['debit_salvage_sale_txt'];
		$appr_note->debit_note_sal_rate_sale_value		= $debit_note_sal_rate_sale_value; //$_POST['debit_note_sal_rate_sale_value'];
		$appr_note->value					= $value; //$_POST['value'];
		$appr_note->lcgst_percent			= $_POST['lcgst_percent']; //$_POST['loss_cgst'];
		$appr_note->loss_cgst				= $loss_cgst; //$_POST['loss_sgst'];
		$appr_note->lsgst_percent			= $_POST['lsgst_percent']; //$_POST['loss_cgst'];
		$appr_note->loss_sgst				= $loss_sgst; //$_POST['loss_sgst'];
		$appr_note->other_exp_inc_mill_txt	= $_POST['other_exp_inc_mill_txt'];
		$appr_note->oth_exp_inc_mill		= $oth_exp_inc_mill; //$_POST['oth_exp_inc_mill'];
		$appr_note->oth_exp_debited			= $oth_exp_debited; //$_POST['oth_exp_debited'];
		$appr_note->compensation_exp		= $compensation_exp; //$_POST['compensation_exp'];
		$appr_note->debit_note_iss_supplier	= $debit_note_iss_supplier; //$_POST['debit_note_iss_supplier'];
		$appr_note->loss_from_rejection		= $loss_from_rejection; //$_POST['loss_from_rejection'];
		$appr_note->recoverable_transporter	= $recoverable_transporter; //$_POST['recoverable_transporter'];

    $appr_note->other_realisation = $other_realisation; //$_POST['other_realisation'];
		$appr_note->net_loss				= $net_loss; //$_POST['net_loss'];
		$appr_note->remark					= nl2br($_POST['verify_remark']);
		
    $appr_note->d_purchase_price    = getValue($_POST,'d_purchase_price');
    $appr_note->d_salvage_rate      = getValue($_POST,'d_salvage_rate');
    $appr_note->d_sale_value        = getValue($_POST,'d_sale_value');


		$appr_note->date_					= date("Y-m-d");
		$appr_note->time_					= date("H:i:s");

    if(! $found_appr_note){
        $appr_note->creator_id            = $employee->id;
        $appr_note->creator_name          = $employee->emp_name;
    }
    

		if($appr_note->save()) {
			// Success
      //if complaint was on hold, then change status back to normal. reset all approvals
			if($complaint->approval_on_hold == 1){
        $complaint->approval_on_hold = 0;

        $complaint->cna_crm_head        = "";
        $complaint->cna_crm_head_name     = "";
        $complaint->cna_crm_head_date     = "0000-00-00";

        $complaint->cna_commercial_head        = "";
        $complaint->cna_commercial_head_name     = "";
        $complaint->cna_commercial_head_date     = "0000-00-00";

        $complaint->cna_plant_chief        = "";
        $complaint->cna_plant_chief_name     = "";
        $complaint->cna_plant_chief_date     = "0000-00-00";

        $complaint->cna_sales_head        = "";
        $complaint->cna_sales_head_name     = "";
        $complaint->cna_sales_head_date     = "0000-00-00";

        $complaint->cna_cfo        = "";
        $complaint->cna_cfo_name     = "";
        $complaint->cna_cfo_date     = "0000-00-00";

        $complaint->cna_md_status        = "";
        $complaint->cna_md     = "";
        $complaint->cna_md_name     = "";
        $complaint->cna_md_date     = "0000-00-00";
      }

			$complaint->approval_note			    = $appr_note->id;
			$complaint->create_approval_note	= "Yes";
			$complaint->approval_note_date		= date("Y-m-d");
			$complaint->approval_note_time		= date("H:i:s");
			$complaint->save();


			$product_id = Product::find_product_id($complaint->business_vertical,$complaint->plant_location,$complaint->product);
			if($product_id){
				//$emp_location = EmployeeLocation::find_by_productId_emp_role($product_id->id,"CRM - Head");
				$emp_location = EmployeeLocation::find_by_productId_emp_role($product_id->id,"CRM - Head");
			}

			$mail = new PHPMailer;

			$mail->IsMail();                            // Set mailer to use SMTP
			$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
			$mail->SMTPAuth = false;                     // Enable SMTP authentication
			$mail->Username = '';          // SMTP username
			$mail->Password = ''; // SMTP password
			////$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 25;                          // TCP port to connect to

			//$mail->SMTPDebug = 2;
			$mail->Mailer = "smtp";
			$mail->Priority = 1;
			$mail->setFrom('crm.accelo@emailmahindra.com', 'Mahindra Accelo');
			$mail->addAddress($emp_location->emp_email,$emp_location->emp_name);   // Add a recipient
			$mail->addCC('salvi.suvarna@mahindra.com','Salvi Suvarna');   // Add a recipient
			$mail->addCC('gajelli.lalita@mahindra.com','Lalita Gajelli');


			$mail->isHTML(true);  // Set email format to HTML

			$bodyContent = "
				<table  cellpadding='0' cellspacing='0' border='0' align='left' style=' background:#fff;width:700px;  min-width:300px; color:#262626; font-size:17px; font-family: Verdana, Geneva, sans-serif'>
					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
					<tr>
					<td  cellpadding='0' cellspacing='0' border='0' width='100%' style='display:block;'>
					<table border='0' style=' padding:30px '>

					<tr>
					<td style='line-height:23px'>

					<p>Dear {$emp_location->emp_name}, </p>

					<p>Requesting you to approve the Approval Note for complaint ID {$complaint->ticket_no} by clicking on link below</p>		

					<p><strong>Complaint details are</strong><br />
					<strong>Customer Name :</strong> {$complaint->company_name}<br />
					<strong>Nature of Complaint :</strong> {$complaint->business_vertical}, {$complaint->complaint_type}<br />
					<strong>Source :</strong> {$complaint->identify_source}<br />

					{$complaint->emp_name} and team has analysed & resolved the complaint.<br />

					The Approval Note for the same has been created & below is the link <br />

					<a style=' text-decoration:none; color:#1774b5' href='".BASE_URL."administrator/approver/approval.php'>".BASE_URL."administrator/approver/approval.php</a>
					
					</p>  

					<p>Thanking You! </p>		
					<p>Warm Regards, <br />
					CRM Team <br />
					<img src='".BASE_URL."administrator/images/logo.png' /></p>  
					<p><i>Note: This is an auto generated e-mail, hence please do not reply.</i></p>

					</td>
					</tr>
					</table>
					</td>
					</tr>

					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
				</table>
			";

			$mail->Subject = getComplaintSubjectAdmin($complaint);
			$mail->Body    = $bodyContent;

			if(!$mail->send()) {
			    //echo 'Mail could not be sent. <br />';
			    //echo 'Mailer Error: ' . $mail->ErrorInfo;
			    $session->message("Approval Note Created Successfully, Mail could not be sent.");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			} else {
			    //echo 'Message has been sent';
			    $session->message("Approval Note Created Successfully");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			}
		} else {
			// Failure
			$session->message("Failed to Create Approval Note");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
		
	}


//  ----------------- Approval Taken  --------------------------------------------

	if(isset($_POST['approval_action_a_taken'])){
		
		if(empty($_POST['create_approval_note'])){
			$session->message("Select Create Approval Note Yes OR No");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
		
		if($_POST['create_approval_note'] == "Yes"){
			$appr_note = ApprovalNote::find_by_comp_id($_GET['id']);
			
			if(!$appr_note){
				$session->message("Create Approval Note First");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			} else {
				$appr_note_id = $appr_note->id;
			}
			$complaint->emp_status		= "Approval Note Submitted";
		} else { 
			$appr_note_id = ""; 
			$complaint->cust_status				= "Complaint Accepted";
			$complaint->emp_status				= "Complaint Accepted";
			$complaint->status					= "Closed";
			$complaint->comp_closed_date		= date("Y-m-d");
		}
		
		if(isset($_POST['approval_action_taken']) && !empty($_POST['approval_action_taken'])){
			if($_POST['approval_action_taken'] == "Others"){

				if(!isset($_POST['approval_action_taken_specify']) || empty($_POST['approval_action_taken_specify'])){
					$session->message("Please specify Action Taken");
					redirect_to("view-complaints.php?id=".$_GET['id']);
				}
				$complaint->create_approval_note			= $_POST['create_approval_note'];
				$complaint->approval_note					= $appr_note_id;	
				$complaint->approval_action_taken			= $_POST['approval_action_taken'];	
				$complaint->approval_action_taken_specify	= $_POST['approval_action_taken_specify'];	
			} else {
				$complaint->create_approval_note			= $_POST['create_approval_note'];
				$complaint->approval_note					= $appr_note_id;	
				$complaint->approval_action_taken			= $_POST['approval_action_taken'];	
				$complaint->approval_action_taken_specify	= "";	
			}

			
			//$complaint->cust_status				= "Complaint Pending";
			//$complaint->status					= "Open";

		} else { 
			$session->message("Please specify Action Taken");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}	

		if($complaint->save()) {
			// Success
			$session->message("Complaint Updated Successfully");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		} else {
			// Failure
			$session->message("Failed to Update Complaint");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
	}



//   ----------------- Settlement Rejection Or Commercial  --------------------------------------------

	if(isset($_POST['settlement_done'])){
		
		if(isset($_POST['settlement']) && !empty($_POST['settlement'])){
			
			$settlement_date = $_POST['settlement_date']; 
			$settlement_date = str_replace('/', '-', $settlement_date);
			$settlement_date = strtotime($settlement_date); 
			$settlement_date = date("Y-m-d", $settlement_date);
			
			
			if (strpos($_POST['reject_final_qty'], 'MT') !== false) {
				$reject_final_qty = str_replace("MT","",$_POST['reject_final_qty']);
			} else if (strpos($_POST['reject_final_qty'], 'KG') !== false) {
				$reject_final_qty = str_replace("KG","",$_POST['reject_final_qty']);
			} else if (strpos($_POST['reject_final_qty'], 'Each') !== false) {
				$reject_final_qty = str_replace("Each","",$_POST['reject_final_qty']);
			} else {
				$reject_final_qty = $_POST['reject_final_qty'];
			}
			
			if($_POST['settlement'] == "Rejection"){
				$complaint->settlement			= $_POST['settlement'];	
				$complaint->settlement_date		= $settlement_date;	
				$complaint->reject_invoice_no	= $_POST['reject_invoice_no'];	
				$complaint->reject_final_qty	= $reject_final_qty." ".$_POST['reject_qty_type'];
				$complaint->settlement_credit_note_no	= $_POST['settlement_credit_note_no'];				
				$complaint->comm_amount			= "";	
			} else if($_POST['settlement'] == "Commercial"){
				$complaint->settlement			= $_POST['settlement'];	
				$complaint->settlement_date		= $settlement_date;	
				$complaint->reject_invoice_no	= "";	
				$complaint->reject_final_qty	= "";	
				$complaint->settlement_credit_note_no	= $_POST['settlement_credit_note_no'];				
				$complaint->comm_amount			= $_POST['comm_amount'];
			}
			
			//$complaint->emp_status				= "Credit Note Shared";
			//$complaint->cust_status				= "Credit Note Shared";
			$complaint->credit_note_date		= date("Y-m-d");
			$complaint->credit_note_time		= date("H:i:s");
			$complaint->status					= "Closed";
			$complaint->comp_closed_date		= date("Y-m-d");
		} else { 
			$session->message("Please specify Action Taken");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}

		if($complaint->save()) {
			// Success

      //start Admin mail
			$bodyContent = "
					<p>Dear Ma'am / Sir,</p>
					<p>Greetings from Mahindra Accelo,</p>

					<p>We have analysed complaint No - {$complaint->ticket_no} and taken actions accordingly.</p>	

					<p>We are closing the complaint. We appreciate your patience.</p>	";

      $subject = "Complaint Closure | Complaint ID #{$complaint->ticket_no} | {$complaint->product} | {$complaint->business_vertical} | {$complaint->plant_location} | {$complaint->company_name}";

      $toArr = array(
        ['email' => $complaint->pl_email, 'name' =>$complaint->pl_name ]
      );
      $ccArr = array(
        ['email' => $emp_location->emp_email, 'name' => $emp_location->emp_name ]
      );
        
      $mailRes = sendComplaintMail($complaint, $subject, $bodyContent, $toArr , $ccArr);
      //End Admin mail

      if($mailRes['status'] == 1){
          $session->message("Complaint Updated Successfully");
          redirect_to("view-complaints.php?id=".$_GET['id']);
      }else {
			    $session->message("Complaint Updated Successfully, Mail could not be sent.");
				  redirect_to("view-complaints.php?id=".$_GET['id']);
			} 

		} else {
			// Failure
			$session->message("Failed to Update Complaint");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
			
	}


//   ----------------- CAPA Create --------------------------------------------
	if(isset($_POST['save_capa'])){
		
		$date_issue = str_replace('/', '-', $_POST['date_issue']);
		$date_issue = date("Y-m-d", strtotime($date_issue));

		$feedback_date = str_replace('/', '-', $_POST['feedback_date']);
		$feedback_date = date("Y-m-d", strtotime($feedback_date));

		$reviewed_date = str_replace('/', '-', $_POST['reviewed_date']);
		$reviewed_date = date("Y-m-d", strtotime($reviewed_date));

		$problem_when = str_replace('/', '-', $_POST['problem_when']);
		$problem_when = date("Y-m-d", strtotime($problem_when));

		
		$found_capa = Capa::find_by_comp_id($_GET['id']);
		
		if($found_capa){
			$capa = Capa::find_by_id($found_capa->id);
			$capa->complaint_id			= $complaint->id;
		} else {
			$capa = new Capa();
			$capa->complaint_id			= $complaint->id;
		}
		
		$capa->customer_id			= $complaint->customer_id;
		$capa->company_name			= $complaint->company_name;
		$capa->ticket_no			= $complaint->ticket_no;

		$capa->document_no			= $_POST['document_no'];
		$capa->rev_no				= $_POST['rev_no'];
		$capa->page_no				= $_POST['page_no'];
		$capa->customer_name		= $_POST['customer_name'];
		$capa->capa_no				= $_POST['capa_no'];
		$capa->model				= $_POST['model'];
		$capa->reported_by			= $_POST['reported_by'];
		$capa->date_issue			= $date_issue;
		$capa->problem_desc			= $_POST['problem_desc'];
		
		$num = 1;
		$team_member ;
		foreach ($_POST["team_member"] as $selectedOption)
		{   
			if($num != 1){
				$team_member .= ", ".$selectedOption;
			} else {
				$team_member .= $selectedOption;
			}  
		  $num++;  
		}
		echo $capa->team_member			= $team_member;
		
		echo $capa->feedback_date		= $feedback_date;
		$capa->reviewed_by			= $_POST['reviewed_by'];
		echo $capa->reviewed_date		= $reviewed_date;
		$capa->contact_person_name 	= $_POST['contact_person_name'];
		$capa->problem_where		= $_POST['problem_where'];
		echo $capa->problem_when	= $problem_when;
		$capa->problem_what_qty		= $_POST['problem_what_qty'];
		$capa->problem_which_model	= $_POST['problem_which_model'];
		$capa->problem_who_produced	= $_POST['problem_who_produced'];
		$capa->finding_invest_remark	= $_POST['finding_invest_remark'];
		$capa->structured_remark	= $_POST['structured_remark'];
		$capa->root_cause_remark	= $_POST['root_cause_remark'];

		$capa->correction_remark	= $_POST['correction_remark'];
		$num = 1;
		$correction_who ;
		foreach ($_POST["correction_who"] as $selectedOption)
		{   
			if($num != 1){
				$correction_who .= ", ".$selectedOption;
			} else {
				$correction_who .= $selectedOption;
			}  
		  $num++;  
		}
		echo $capa->correction_who		= $correction_who;

		$correction_when = str_replace('/', '-', $_POST['correction_when']);
		$correction_when = date("Y-m-d", strtotime($correction_when));
		echo $capa->correction_when		= $correction_when;

		$capa->corrective_remark	= $_POST['correction_action_remark'];
		$num = 1;
		$correction_action_who ;
		foreach ($_POST["correction_action_who"] as $selectedOption)
		{   
			if($num != 1){
				$correction_action_who .= ", ".$selectedOption;
			} else {
				$correction_action_who .= $selectedOption;
			}  
		  $num++;  
		}
		echo $capa->corrective_who		= $correction_action_who;

		$correction_action_when = str_replace('/', '-', $_POST['correction_action_when']);
		$correction_action_when = date("Y-m-d", strtotime($correction_action_when));
		echo $capa->corrective_when		= $correction_action_when;


		$capa->verify_remark		= $_POST['verify_remark'];
		//$capa->verify_who			= $_POST['verify_who'];
		$num = 1;
		$verify_who ;
		foreach ($_POST["verify_who"] as $selectedOption)
		{   
			if($num != 1){
				$verify_who .= ", ".$selectedOption;
			} else {
				$verify_who .= $selectedOption;
			}  
		  $num++;  
		}
		echo $capa->verify_who			= $verify_who;

		$verify_when = str_replace('/', '-', $_POST['verify_when']);
		$verify_when = date("Y-m-d", strtotime($verify_when));
		echo $capa->verify_when			= $verify_when;

		$capa->prevent_remark		= $_POST['prevent_remark'];
		//$capa->prevent_who			= $_POST['prevent_who'];
		$num = 1;
		$prevent_who ;
		foreach ($_POST["prevent_who"] as $selectedOption)
		{   
			if($num != 1){
				$prevent_who .= ", ".$selectedOption;
			} else {
				$prevent_who .= $selectedOption;
			}  
		  $num++;  
		}
		echo $capa->prevent_who			= $prevent_who;

		$prevent_when = str_replace('/', '-', $_POST['prevent_when']);
		$prevent_when = date("Y-m-d", strtotime($prevent_when));
		echo $capa->prevent_when			= $prevent_when;

		$capa->date_				= date("Y-m-d");
		$capa->time_				= date("H:i:s");

		if($capa->save()) {
			// Success
			$complaint->create_capa_doc		= "Yes";
			$complaint->capa 				= $capa->id;
			
			$complaint->emp_status			= "CAPA Submittedf";
			//$complaint->cust_status		= "Credit Note Shared";
			$complaint->status				= "Closed";
			$complaint->comp_closed_date	= date("Y-m-d");
			$complaint->save();

			$product_id = Product::find_product_id($complaint->business_vertical,$complaint->plant_location,$complaint->product);
			if($product_id){
				//$emp_location = EmployeeLocation::find_by_productId_emp_role($product_id->id,"Quality Assurance");
				$emp_location = EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"Quality Assurance");
			}

			$mail = new PHPMailer;

			$mail->IsMail();                            // Set mailer to use SMTP
			$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
			$mail->SMTPAuth = false;                     // Enable SMTP authentication
			$mail->Username = '';          // SMTP username
			$mail->Password = ''; // SMTP password
			////$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 25;                          // TCP port to connect to

			//$mail->SMTPDebug = 2;
			$mail->Mailer = "smtp";
			$mail->Priority = 1;
			$mail->setFrom('crm.accelo@emailmahindra.com', 'Mahindra Accelo');
			//$mail->addAddress('salvi.suvarna@mahindra.com','Salvi Suvarna');   // Add a recipient
			$mail->addAddress($emp_location->emp_email,$emp_location->emp_name);   // Add a recipient
			$mail->addCC('salvi.suvarna@mahindra.com','Salvi Suvarna');   // Add a recipient
			$mail->addCC('gajelli.lalita@mahindra.com','Lalita Gajelli');
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');

			$mail->isHTML(true);  // Set email format to HTML

			$bodyContent = "
				<table  cellpadding='0' cellspacing='0' border='0' align='left' style=' background:#fff;width:700px;  min-width:300px; color:#262626; font-size:17px; font-family: Verdana, Geneva, sans-serif'>
					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
					<tr>
					<td  cellpadding='0' cellspacing='0' border='0' width='100%' style='display:block;'>
					<table border='0' style=' padding:30px '>

					<tr>
					<td style='line-height:23px'>

					<p>Dear {$emp_location->emp_name}, </p> 

					<p>Requesting you to approve CAPA for Complaint ID- {$complaint->ticket_no} by clicking on link below,</p>


					<p><strong>Complaint detail are,</strong><br />
					<strong>Customer Name :</strong> {$complaint->company_name}<br />
					<strong>Nature of Complaint :</strong> {$complaint->business_vertical}, {$complaint->complaint_type}<br />
					<strong>Source :</strong> {$complaint->identify_source}</p>

					<p>{$complaint->emp_name} and team has analysed & resolved the complaint.</p>

					<p>The CAPA document for the same has been created & below is the link <br />
					<a style=' text-decoration:none; color:#1774b5' href='".BASE_URL."administrator/approver/capa-approval.php'>".BASE_URL."administrator/approver/capa-approval.php</a>
					</p>  

					<p>Thanking You!</p>		
					<p>Warm Regards, <br />
					CRM Team <br />
					<img src='".BASE_URL."administrator/images/logo.png' /></p>  
					<p><i>Note: This is an auto generated e-mail, hence please do not reply.</i></p>

					</td>
					</tr>
					</table>
					</td>
					</tr>

					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
				</table>
			";

			$mail->Subject = getComplaintSubjectAdmin($complaint);
			$mail->Body    = $bodyContent;

			if(!$mail->send()) {
			    //echo 'Mail could not be sent. <br />';
			    //echo 'Mailer Error: ' . $mail->ErrorInfo;
			    $session->message("CAPA Created Successfully, Mail could not be sent.");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			} else {
			    //echo 'Message has been sent';
			    $session->message("CAPA Created Successfully");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			}
			//$session->message("CAPA Created Successfully");
			//redirect_to("view-complaints.php?id=".$_GET['id']);
		} else {
			// Failure
			$session->message("Failed to Create CAPA");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
		
	}


//   ----------------- CAPA Upload --------------------------------------------

	if(isset($_POST['upload_capa_document'])){
		
		
		if(empty($complaint->capa) && empty($_FILES['capa_document']['name'])){
			$session->message("Upload CAPA Document OR Create CAPA Dodument");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
		
		$capa_path = "../document/".$complaint->ticket_no."/capa";


		$allowed_image_extension = array( "png", "PNG", "jpg", "jpeg", "JPG", "JPEG", "pdf", "PDF" );

		$file_extension = pathinfo($_FILES["capa_document"]["name"], PATHINFO_EXTENSION);
		
		if (!in_array($file_extension, $allowed_image_extension)) {
			$session->message("Upload Valid CAPA. Only PDF, PNG and JPEG are allowed.");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}    // Validate image file size
		else if (($_FILES["capa_document"]["size"] > 25485760)) {
			$session->message("CAPA document size exceeds 25MB");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}



		if(isset($_FILES['capa_document'])){
			$complaint->capa_document 			= $_FILES['capa_document']['name'];	
			$capa_document						= basename($_FILES['capa_document']['name']);

			if (!file_exists($capa_path)) {
				mkdir("../document/".$complaint->ticket_no."/capa", 0777, true);
			}

			if(!empty($capa_document)) {
				$capa_document 					= str_replace(" ","_",$capa_document);
				$capa_document 					= time()."-".$capa_document;
				$complaint->capa_document		= $capa_document;
				$tp_photo 	=  	$capa_path."/".$capa_document;
				$move_photo 	= move_uploaded_file($_FILES['capa_document']['tmp_name'], $tp_photo);
				
				if($move_photo){
					$complaint->create_capa_doc		= "Yes";
				}
			} else {$complaint->capa_document = "";}

		} 
		
		
		if($complaint->save()) {
			// Success

			$product_id = Product::find_product_id($complaint->business_vertical,$complaint->plant_location,$complaint->product);
			if($product_id){
				//$emp_location = EmployeeLocation::find_by_productId_emp_role($product_id->id,"Quality Assurance");
				$emp_location = EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"Quality Assurance");
			}

			$mail = new PHPMailer;

			$mail->IsMail();                            // Set mailer to use SMTP
			$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
			$mail->SMTPAuth = false;                     // Enable SMTP authentication
			$mail->Username = '';          // SMTP username
			$mail->Password = ''; // SMTP password
			////$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 25;                          // TCP port to connect to

			//$mail->SMTPDebug = 2;
			$mail->Mailer = "smtp";
			$mail->Priority = 1;
			$mail->setFrom('crm.accelo@emailmahindra.com', 'Mahindra Accelo');
			$mail->addAddress($emp_location->emp_email,$emp_location->emp_name);   // Add a recipient
			$mail->addCC('salvi.suvarna@mahindra.com','Salvi Suvarna');   // Add a recipient
			$mail->addCC('gajelli.lalita@mahindra.com','Lalita Gajelli');
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');

			$mail->isHTML(true);  // Set email format to HTML

			$bodyContent = "
				<table  cellpadding='0' cellspacing='0' border='0' align='left' style=' background:#fff;width:700px;  min-width:300px; color:#262626; font-size:17px; font-family: Verdana, Geneva, sans-serif'>
					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
					<tr>
					<td  cellpadding='0' cellspacing='0' border='0' width='100%' style='display:block;'>
					<table border='0' style=' padding:30px '>

					<tr>
					<td style='line-height:23px'>

					<p>Dear {$emp_location->emp_name}, </p> 

					<p>Requesting you to approve CAPA for Complaint ID- {$complaint->ticket_no} by clicking on link below,</p>


					<p><strong>Complaint detail are,</strong><br />
					<strong>Customer Name :</strong> {$complaint->company_name}<br />
					<strong>Nature of Complaint :</strong> {$complaint->business_vertical}, {$complaint->complaint_type}<br />
					<strong>Source :</strong> {$complaint->identify_source}</p>

					<p>{$complaint->emp_name} and team has analysed & resolved the complaint.</p>

					<p>The CAPA document for the same has been created & below is the link <br />
					<a style=' text-decoration:none; color:#1774b5' href='".BASE_URL."administrator/approver/capa-approval.php'>".BASE_URL."administrator/approver/capa-approval.php</a>
					</p>  

					<p>Thanking You!</p>		
					<p>Warm Regards, <br />
					CRM Team <br />
					<img src='".BASE_URL."administrator/images/logo.png' /></p>  
					<p><i>Note: This is an auto generated e-mail, hence please do not reply.</i></p>

					</td>
					</tr>
					</table>
					</td>
					</tr>

					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
				</table>
			
			";

			$mail->Subject = getComplaintSubjectAdmin($complaint);
			$mail->Body    = $bodyContent;

			if(!$mail->send()) {
			    //echo 'Mail could not be sent. <br />';
			    //echo 'Mailer Error: ' . $mail->ErrorInfo;
			    $session->message("CAPA Document Uploaded Successfully, Mail could not be sent.");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			} else {
			    //echo 'Message has been sent';
			    $session->message("CAPA Document Uploaded Successfully");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			}
			//$session->message("CAPA Document Uploaded Successfully");
			//redirect_to("view-complaints.php?id=".$_GET['id']);
		} else {
			// Failure
			$session->message("Failed to Upload CAPA Document");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
		
	}




?>


