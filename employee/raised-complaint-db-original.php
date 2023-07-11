<?php ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	////date_default_timezone_set('Asia/Calcutta');

	$employee = EmployeeReg::find_by_id($session->employee_id);

	foreach ($_POST as $key => $value) {
		//echo htmlspecialchars($key)." = ".htmlspecialchars($value)."<br>";
	}

	//return false;

	if(!isset($_GET['id']) || empty($_GET['id'])){
		$session->message('Complaint Not Found');
		redirect_to("my-complaints.php"); 
	}
	
	$complaint = Complaint::find_by_id($_GET['id']);

//   ----------------- identify_the_source --------------------------------------------

	if(isset($_POST['identify_the_source'])){
		

		$complaint->emp_id						= $employee->id;
		$complaint->emp_name					= $employee->emp_name;

		$complaint->identify_source				= $_POST['id_source'];
		if($_POST['id_source'] == "Mill"){
			$complaint->mill						= $_POST['select_mill'];
		} else {
			$complaint->mill						= "";
		}
		
		$complaint->client_contacted			= $_POST['client_contacted'];
		$complaint->identify_source_remark		= $_POST['identify_source_remark'];

		$complaint->status						= "Open";
		//$complaint->date_					= date("Y-m-d");
		//$complaint->time_					= date("H:i:s");


		if($complaint->save()) {
			// Success
			$session->message("Complaint Updated Successfully");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		} else {
			// Failure
			$session->message("Failed to Updated Complaint");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
	}



//   ----------------- Meeting Appointment  --------------------------------------------

	if(isset($_POST['complaint_meeting'])){
		
		
		$meeting_date = $_POST['meeting_date']; 
		$meeting_date = strtotime($meeting_date); 
		$meeting_date = date("Y-m-d", $meeting_date);
		
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
			$session->message("Meeting Added Successfully");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		} else {
			// Failure
			$session->message("Failed to Add Meeting");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
	}


//   ----------------- identify_the_source --------------------------------------------

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

				if($complaint->save()) {
					// Success
					$session->message("Complaint Updated Successfully");
					redirect_to("view-complaints.php?id=".$_GET['id']);
				} else {
					// Failure
					$session->message("Failed to Updated Complaint");
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
				$session->message("Failed to Updated Complaint");
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
			
			$complaint->cust_status				= "Visit Done";
			
			if($_POST['product_status'] == "Others"){
				$complaint->product_status			= $_POST['product_status'];
				$complaint->product_status_specify	= $_POST['product_status_specify'];
				
				$complaint->emp_status				= $_POST['product_status_specify'];
			} else {
				$complaint->product_status			= $_POST['product_status'];
				$complaint->product_status_specify	= "";
				
				$complaint->emp_status				= $_POST['product_status'];
			}			
			
			if(empty($_POST['mom_written'])){
				$mom_path = "../document/".$complaint->ticket_no."/mom";

				if(isset($_FILES['mom_document'])){
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
			} else {
				$complaint->mom_written				= nl2br($_POST['mom_written']);
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
					$plant_img_2 = str_replace(" ","_",$plant_img_2);
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
			
			$complaint->cust_status				= "Visit Not Done";
			$complaint->emp_status				= "Visit Not Done";
		}

		if($complaint->save()) {
			// Success
			$session->message("Complaint Updated Successfully");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		} else {
			// Failure
			$session->message("Failed to Updated Complaint");
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
		
		if($_POST['recommended_advice'] == "Others"){
			if(empty($_POST['other_advice'])){
				$session->message("Enter Mandatory Fields");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			}
		} 
		
		
		// Driver code 
		$action_by_date = $_POST['action_by_date']; 
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
		}
		else if($_POST['complaint_accepted'] == "No"){
			$complaint->complaint_accepted		= $_POST['complaint_accepted'];
			$complaint->complaint_remark		= $_POST['complaint_remark'];
			$complaint->other_advice			= "";
			$complaint->action_by_name			= "";
			$complaint->action_by_date			= "";
			
			$complaint->cust_status				= "Complaint Rejected";
			$complaint->emp_status				= "Complaint Rejected";
			$complaint->status					= "Closed";
		}
		else if($_POST['complaint_accepted'] == "Decision Pending"){
			$complaint->complaint_accepted		= $_POST['complaint_accepted'];
			$complaint->complaint_remark		= $_POST['complaint_remark'];
			$complaint->other_advice			= "";
			$complaint->action_by_name			= $_POST['action_by_name'];
			$complaint->action_by_date			= $action_by_date;
			
			$complaint->cust_status				= "Complaint Pending";
			$complaint->emp_status				= "Complaint Pending";
			$complaint->status					= "Open";
		}
		
		if($complaint->save()) {
			// Success
			$session->message("Complaint Updated Successfully");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		} else {
			// Failure
			$session->message("Fail to Updated Complaint");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
	}



//   ----------------- Approval Note Create --------------------------------------------

	if(isset($_POST['create_a_note'])){
		
		if(empty($_POST['customer_name']) || empty($_POST['nature_of_complaint']) || empty($_POST['complait_reference']) || empty($_POST['name_of_sm_sc_t'])
		 	|| empty($_POST['complait_reg_date']) || empty($_POST['responsibility']) || empty($_POST['material_details']) || empty($_POST['billing_doc_no'])
		    || empty($_POST['total_qty_rejc_type']) || empty($_POST['billing_doc_date']) || empty($_POST['basic_sale_price'])
		 ) {
			// Success
			$session->message("Enter Mandatory Fields");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
		
		if(empty($_POST['qty_acpt_steel_mill_type']) && empty($_POST['qty_scrp_auc_serv_cent_type']) && empty($_POST['qty_dlv_customer_type'])) {
			// Success
			$session->message("Enter any One Quantity (t)");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
		
		if(empty($_POST['debit_note_sal_rate_sale_value'])) {
			// Success
			$session->message("Debit note (purchase price/t) / Salvage rate / Sale value");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
		
		$complait_reg_date = $_POST['complait_reg_date']; 
		$complait_reg_date = strtotime($complait_reg_date); 
		$complait_reg_date = date("Y-m-d", $complait_reg_date);

		$billing_doc_date = $_POST['billing_doc_date']; 
		$billing_doc_date = strtotime($billing_doc_date); 
		$billing_doc_date = date("Y-m-d", $billing_doc_date);
		
		
		$found_appr_note = ApprovalNote::find_by_comp_id($_GET['id']);
		
		if($found_appr_note){
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
		$appr_note->basic_sale_price		= $_POST['basic_sale_price'];
		$appr_note->sales_value				= $_POST['sales_value'];
		$appr_note->cgst					= $_POST['cgst'];
		$appr_note->sgst					= $_POST['sgst'];
		$appr_note->cost_inc_customer		= $_POST['cost_inc_customer'];
		$appr_note->salvage_value			= $_POST['salvage_value'];
		$appr_note->credit_note_iss_cust	= $_POST['credit_note_iss_cust'];
		//$appr_note->debit_note_supplier		= $_POST['debit_note_supplier'];
		$appr_note->qty_acpt_steel_mill		= $_POST['qty_acpt_steel_mill']." ".$_POST['qty_acpt_steel_mill_type'];
		$appr_note->qty_scrp_auc_serv_cent	= $_POST['qty_scrp_auc_serv_cent']." ".$_POST['qty_scrp_auc_serv_cent_type'];
		$appr_note->qty_dlv_customer		= $_POST['qty_dlv_customer']." ".$_POST['qty_dlv_customer_type'];
		$appr_note->debit_note_sal_rate_sale_value		= $_POST['debit_note_sal_rate_sale_value'];
		$appr_note->value					= $_POST['value'];
		$appr_note->loss_cgst				= $_POST['loss_cgst'];
		$appr_note->loss_sgst				= $_POST['loss_sgst'];
		$appr_note->oth_exp_inc_mill		= $_POST['oth_exp_inc_mill'];
		$appr_note->oth_exp_debited			= $_POST['oth_exp_debited'];
		$appr_note->compensation_exp		= $_POST['compensation_exp'];
		$appr_note->debit_note_iss_supplier	= $_POST['debit_note_iss_supplier'];
		$appr_note->loss_from_rejection		= $_POST['loss_from_rejection'];
		$appr_note->recoverable_transporter	= $_POST['recoverable_transporter'];
		$appr_note->net_loss				= $_POST['net_loss'];
		$appr_note->net_loss				= $_POST['net_loss'];
		$appr_note->remark					= nl2br($_POST['verify_remark']);
		
		$appr_note->date_					= date("Y-m-d");
		$appr_note->time_					= date("H:i:s");

		if($appr_note->save()) {
			// Success
			$session->message("Approval Note Created Successfully");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		} else {
			// Failure
			$session->message("Fail to Create Approval Note");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
		
	}


//   ----------------- Approval Taken  --------------------------------------------

	if(isset($_POST['approval_action_a_taken'])){
		
		$appr_note = ApprovalNote::find_by_comp_id($_GET['id']);
		
		if($appr_note){
			
			if(isset($_POST['approval_action_taken']) && !empty($_POST['approval_action_taken'])){
				if($_POST['approval_action_taken'] == "Others"){
					
					if(!isset($_POST['approval_action_taken_specify']) || empty($_POST['approval_action_taken_specify'])){
						$session->message("Please specify Action Taken");
						redirect_to("view-complaints.php?id=".$_GET['id']);
					}
					   
					$complaint->approval_note					= $appr_note->id;	
					$complaint->approval_action_taken			= $_POST['approval_action_taken'];	
					$complaint->approval_action_taken_specify	= $_POST['approval_action_taken_specify'];	
				} else {
					$complaint->approval_note					= $appr_note->id;	
					$complaint->approval_action_taken			= $_POST['approval_action_taken'];	
					$complaint->approval_action_taken_specify	= "";	
				}
				
				$complaint->emp_status					= "Approval Note Shared";
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
				$session->message("Fail to Updated Complaint");
				redirect_to("view-complaints.php?id=".$_GET['id']);
			}
			
		} else { 
			$session->message("Create Approval Note First");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}		
	}



//   ----------------- Settlement Rejection Or Commercial  --------------------------------------------

	if(isset($_POST['settlement_done'])){
		
		if(isset($_POST['settlement']) && !empty($_POST['settlement'])){
			
			$settlement_date = $_POST['settlement_date']; 
			$settlement_date = strtotime($settlement_date); 
			$settlement_date = date("Y-m-d", $settlement_date);
			
			
			if($_POST['settlement'] == "Rejection"){
				$complaint->settlement			= $_POST['settlement'];	
				$complaint->settlement_date		= $settlement_date;	
				$complaint->reject_invoice_no	= $_POST['reject_invoice_no'];	
				$complaint->reject_final_qty	= $_POST['reject_final_qty']." ".$_POST['reject_qty_type'];
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
			
			$complaint->emp_status					= "Credit Note Shared";
			$complaint->cust_status					= "Credit Note Shared";
			//$complaint->status						= "Closed";
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
			$session->message("Fail to Updated Complaint");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
			
	}


//   ----------------- CAPA Create --------------------------------------------
	if(isset($_POST['save_capa'])){
		
		$date_issue = $_POST['date_issue']; 
		$date_issue = strtotime($date_issue); 
		$date_issue = date("Y-m-d", $date_issue);

		$feedback_date = $_POST['feedback_date']; 
		$feedback_date = strtotime($feedback_date); 
		$feedback_date = date("Y-m-d", $feedback_date);

		$reviewed_date = $_POST['reviewed_date']; 
		$reviewed_date = strtotime($reviewed_date); 
		$reviewed_date = date("Y-m-d", $reviewed_date);

		
		$found_capa = Capa::find_by_comp_id($_GET['id']);
		
		if($found_capa){
			$capa = Capa::find_by_id($found_capa->id);
		} else {
			$capa = new Capa();
		}
		
		$capa->complaint_id			= $complaint->id;
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
		$capa->team_member			= $team_member;
		
		$capa->feedback_date		= $feedback_date;
		$capa->reviewed_by			= $_POST['reviewed_by'];
		$capa->reviewed_date		= $reviewed_date;
		$capa->contact_person_name 	= $_POST['contact_person_name'];
		$capa->problem_where		= $_POST['problem_where'];
		$capa->problem_when			= $_POST['problem_when'];
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
		$capa->correction_who		= $correction_who;

		$capa->correction_when		= $_POST['correction_when'];
		$capa->verify_remark		= $_POST['verify_remark'];
		$capa->verify_who			= $_POST['verify_who'];
		$capa->verify_when			= $_POST['verify_when'];
		$capa->prevent_remark		= $_POST['prevent_remark'];
		$capa->prevent_who			= $_POST['prevent_who'];
		$capa->prevent_when			= $_POST['prevent_when'];

		$capa->date_				= date("Y-m-d");
		$capa->time_				= date("H:i:s");

		if($capa->save()) {
			// Success
			$complaint->capa = $capa->id;
			
			$complaint->emp_status					= "CAPA Shared";
			//$complaint->cust_status					= "Credit Note Shared";
			$complaint->status						= "Closed";
			
			$complaint->save();
			$session->message("CAPA Created Successfully");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		} else {
			// Failure
			$session->message("Fail to Create CAPA");
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
			} else {$complaint->capa_document = "";}

		} 
		
		if($complaint->save()) {
			// Success
			$session->message("CAPA Document Uploaded Successfully");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		} else {
			// Failure
			$session->message("Fail to Upload CAPA Document");
			redirect_to("view-complaints.php?id=".$_GET['id']);
		}
		
	}




?>


