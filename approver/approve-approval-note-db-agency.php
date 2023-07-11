<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	require '../PHPMailer/PHPMailerAutoload.php';

	$employee_reg = EmployeeReg::find_by_id($session->employee_id);
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	if ($session->is_employee_logged_in()){ 

		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_role = 'Approver'";

		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);

		if(!$employee_location){
			redirect_to("logout.php"); 
		}
	}

	////date_default_timezone_set('Asia/Calcutta');

	//echo $session->employee_id;



	foreach ($_POST as $key => $value) {
		//echo htmlspecialchars($key)." = ".htmlspecialchars($value)."<br>";
	}

	//return false;

	if(!isset($_GET['id']) || empty($_GET['id'])){
		$session->message('Complaint Not Found');
		redirect_to("my-complaints.php"); 
	}
	
	$complaint = Complaint::find_by_id($_GET['id']);

	$found_appr_note = ApprovalNote::find_by_comp_id($_GET['id']);
		
	$appr_note = ApprovalNote::find_by_id($found_appr_note->id);


	$product_id = Product::find_product_id($complaint->business_vertical,$complaint->plant_location,$complaint->product);

	//print_r($product_id);


	if($product_id){
		$employee_loc = EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"CRM - Head");
		if(!$employee_loc){
			$employee_loc = EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"Commercial Head");

			$mail = new PHPMailer;

			$mail->IsMail();                            // Set mailer to use SMTP
			$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
			$mail->SMTPAuth = false;                     // Enable SMTP authentication
			$mail->Username = '';          // SMTP username
			$mail->Password = ''; // SMTP password
			//$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 25;                          // TCP port to connect to

			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);

			//$mail->SMTPDebug = 2;
			$mail->Mailer = "smtp";
			$mail->Priority = 1;
			$mail->setFrom('crm.accelo@emailmahindra.com', 'Mahindra Accelo');
			$mail->addAddress('salvi.suvarna@mahindra.com','Salvi Suvarna');   // Add a recipient
			//$mail->addAddress('{$employee_loc->emp_email}','{$employee_loc->emp_name}');   // Add a recipient
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');

			$mail->isHTML(true);  // Set email format to HTML

			$bodyContent = "

			<p>Dear {$employee_loc->emp_name} </p> <br />

			<p>The team has analysed & processed the complaint registered under Ticket Id- {$complaint->ticket_no}</p>		

			<p>Complaint detail<br />
			Customer Name: {$complaint->company_name}<br />
			Nature of Complaint: {$complaint->business_vertical}, {$complaint->complaint_type}<br />
			Source : {$complaint->identify_source}<br />
			Action to be taken: {$complaint->other_advice}<br />

			{$complaint->emp_name} and team has prepared the Approval Note for the above Complaint <br />

			Requesting you to approve the same. <br />
			Below is the link : <br />
			</p>  

			<br /><br /><br />
			<p>Thank You for your time! </p>		
			<p>Best Regards, <br />
			Customer Service Team<br />
			<strong>Mahindra Accelo</strong></p>  
			";

			$mail->Subject = "{$complaint->business_vertical} | {$complaint->plant_location} | Ticket ID #{$complaint->ticket_no} | {$complaint->company_name} | {$complaint->complaint_type}";
			$mail->Body    = $bodyContent;

			
		} 
		if(!$employee_loc){
			$employee_loc = EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"Plant Chief - AN");

			$mail = new PHPMailer;

			$mail->IsMail();                            // Set mailer to use SMTP
			$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
$mail->SMTPAuth = false;                     // Enable SMTP authentication
$mail->Username = '';          // SMTP username
$mail->Password = ''; // SMTP password
// $mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;                        // TCP port to connect to

			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);

			//$mail->SMTPDebug = 2;
			$mail->Mailer = "smtp";
			$mail->Priority = 1;
			$mail->setFrom('crm.accelo@emailmahindra.com', 'Mahindra Accelo');
			$mail->addAddress('salvi.suvarna@mahindra.com','Salvi Suvarna');   // Add a recipient
			//$mail->addAddress('{$employee_loc->emp_email}','{$employee_loc->emp_name}');   // Add a recipient
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');

			$mail->isHTML(true);  // Set email format to HTML

			$bodyContent = "

			<p>Dear {$employee_loc->emp_name} </p> <br />

			<p>The team has analysed & processed the complaint registered under Ticket Id- {$complaint->ticket_no}</p>		

			<p>Complaint detail<br />
			Customer Name: {$complaint->company_name}<br />
			Nature of Complaint: {$complaint->business_vertical}, {$complaint->complaint_type}<br />
			Source : {$complaint->identify_source}<br />
			Action to be taken: {$complaint->other_advice}<br />

			{$complaint->emp_name} and team has prepared the Approval Note for the above Complaint <br />

			Requesting you to approve the same. <br />
			Below is the link : <br />
			</p>  

			<br /><br /><br />
			<p>Thank You for your time! </p>		
			<p>Best Regards, <br />
			Customer Service Team<br />
			<strong>Mahindra Accelo</strong></p>  
			";

			$mail->Subject = "{$complaint->business_vertical} | {$complaint->plant_location} | Ticket ID #{$complaint->ticket_no} | {$complaint->company_name} | {$complaint->complaint_type}";
			$mail->Body    = $bodyContent;
		} 
		if(!$employee_loc){
			$employee_loc = EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"Sales Head");

			$mail = new PHPMailer;

			$mail->IsMail();                            // Set mailer to use SMTP
			$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
$mail->SMTPAuth = false;                     // Enable SMTP authentication
$mail->Username = '';          // SMTP username
$mail->Password = ''; // SMTP password
// $mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;                // TCP port to connect to

			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);

			//$mail->SMTPDebug = 2;
			$mail->Mailer = "smtp";
			$mail->Priority = 1;
			$mail->setFrom('crm.accelo@emailmahindra.com', 'Mahindra Accelo');
			$mail->addAddress('salvi.suvarna@mahindra.com','Salvi Suvarna');   // Add a recipient
			//$mail->addAddress('{$employee_loc->emp_email}','{$employee_loc->emp_name}');   // Add a recipient
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');

			$mail->isHTML(true);  // Set email format to HTML

			$bodyContent = "

			<p>Dear {$employee_loc->emp_name} </p> <br />

			<p>The team has analysed & processed the complaint registered under Ticket Id- {$complaint->ticket_no}</p>		

			<p>Complaint detail<br />
			Customer Name: {$complaint->company_name}<br />
			Nature of Complaint: {$complaint->business_vertical}, {$complaint->complaint_type}<br />
			Source : {$complaint->identify_source}<br />
			Action to be taken: {$complaint->other_advice}<br />

			{$complaint->emp_name} and team has prepared the Approval Note for the above Complaint <br />

			Requesting you to approve the same. <br />
			Below is the link : <br />
			</p>  

			<br /><br /><br />
			<p>Thank You for your time! </p>		
			<p>Best Regards, <br />
			Customer Service Team<br />
			<strong>Mahindra Accelo</strong></p>  
			";

			$mail->Subject = "{$complaint->business_vertical} | {$complaint->plant_location} | Ticket ID #{$complaint->ticket_no} | {$complaint->company_name} | {$complaint->complaint_type}";
			$mail->Body    = $bodyContent;
		} 
		if(!$employee_loc){
			$employee_loc = EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"CFO");

			$mail = new PHPMailer;

			$mail->IsMail();                            // Set mailer to use SMTP
			$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
$mail->SMTPAuth = false;                     // Enable SMTP authentication
$mail->Username = '';          // SMTP username
$mail->Password = ''; // SMTP password
// $mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;                        // TCP port to connect to

			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);

			//$mail->SMTPDebug = 2;
			$mail->Mailer = "smtp";
			$mail->Priority = 1;
			$mail->setFrom('crm.accelo@emailmahindra.com', 'Mahindra Accelo');
			$mail->addAddress('salvi.suvarna@mahindra.com','Salvi Suvarna');   // Add a recipient
			//$mail->addAddress('{$employee_loc->emp_email}','{$employee_loc->emp_name}');   // Add a recipient
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');

			$mail->isHTML(true);  // Set email format to HTML

			$bodyContent = "

			<p>Dear {$employee_loc->emp_name} </p> <br />

			<p>The team has analysed & processed the complaint registered under Ticket Id- {$complaint->ticket_no}</p>		

			<p>Complaint detail<br />
			Customer Name: {$complaint->company_name}<br />
			Nature of Complaint: {$complaint->business_vertical}, {$complaint->complaint_type}<br />
			Source : {$complaint->identify_source}<br />
			Action to be taken: {$complaint->other_advice}<br />

			{$complaint->emp_name} and team has prepared the Approval Note for the above Complaint <br />

			Requesting you to approve the same. <br />
			Below is the link : <br />
			</p>  

			<br /><br /><br />
			<p>Thank You for your time! </p>		
			<p>Best Regards, <br />
			Customer Service Team<br />
			<strong>Mahindra Accelo</strong></p>  
			";

			$mail->Subject = "{$complaint->business_vertical} | {$complaint->plant_location} | Ticket ID #{$complaint->ticket_no} | {$complaint->company_name} | {$complaint->complaint_type}";
			$mail->Body    = $bodyContent;
		} 
		if(!$employee_loc){
			$employee_loc = EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"MD");

			$mail = new PHPMailer;

			$mail->IsMail();                            // Set mailer to use SMTP
			$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
$mail->SMTPAuth = false;                     // Enable SMTP authentication
$mail->Username = '';          // SMTP username
$mail->Password = ''; // SMTP password
// $mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;                      // TCP port to connect to

			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);

			//$mail->SMTPDebug = 2;
			$mail->Mailer = "smtp";
			$mail->Priority = 1;
			$mail->setFrom('crm.accelo@emailmahindra.com', 'Mahindra Accelo');
			$mail->addAddress('salvi.suvarna@mahindra.com','Salvi Suvarna');   // Add a recipient
			//$mail->addAddress('{$employee_loc->emp_email}','{$employee_loc->emp_name}');   // Add a recipient
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');

			$mail->isHTML(true);  // Set email format to HTML

			$bodyContent = "

			<p>Dear {$employee_loc->emp_name} </p> <br />

			<p>The team has analysed & processed the complaint registered under Ticket Id- {$complaint->ticket_no}</p>
			<p>Would like to bring to your notice that the concerned complaint needs your attention.</p>		

			<p>Complaint detail<br />
			Customer Name: {$complaint->company_name}<br />
			Nature of Complaint: {$complaint->business_vertical}, {$complaint->complaint_type}<br />
			Source : {$complaint->identify_source}<br />
			Action to be taken: {$complaint->other_advice}<br />

			The approval note shows a loss of Rs {$found_appr_note->net_loss}. <br />

			Requesting you to approve the same. <br />
			Below is the link : <br />
			</p>  

			<br /><br /><br />
			<p>Thank You for your time! </p>		
			<p>Best Regards, <br />
			Customer Service Team<br />
			<strong>Mahindra Accelo</strong></p>  
			";

			$mail->Subject = "{$complaint->business_vertical} | {$complaint->plant_location} | Ticket ID #{$complaint->ticket_no} | {$complaint->company_name} | {$complaint->complaint_type}";
			$mail->Body    = $bodyContent;
		}
	} else {
		$session->message('Product Not Found');
		redirect_to("my-complaints.php"); 
	}

	
	//$employee_loc = EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,"Commercial Head");

	

	//print_r($employee_loc);


	
	
	//return false;



	
	//$complaint->identify_source				= $_POST['id_source'];
	
	//$employee_loc = EmployeeLocation::find_by_emp_id($session->employee_id);
	
	

	if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "CRM - Head"){
		
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
		$appr_note->basic_sale_price_txt	= $_POST['basic_sale_price_txt'];
		$appr_note->basic_sale_price		= $_POST['basic_sale_price'];
		$appr_note->sales_value				= $_POST['sales_value'];
		$appr_note->cgst					= $_POST['cgst'];
		$appr_note->sgst					= $_POST['sgst'];
		$appr_note->cost_inc_customer_txt	= $_POST['cost_inc_customer_txt'];
		$appr_note->cost_inc_customer		= $_POST['cost_inc_customer'];
		$appr_note->salvage_value_txt		= $_POST['salvage_value_txt'];
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
		
		$appr_note->save();
		
		$complaint->cna_crm_head				= "Yes";
		$complaint->cna_crm_head_date			= date("Y-m-d");
		
	} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "Commercial Head"){
		$complaint->cna_commercial_head			= "Yes";
		$complaint->cna_commercial_head_date	= date("Y-m-d");
	} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "Plant Chief - AN"){
		$complaint->cna_plant_chief				= "Yes";
		$complaint->cna_plant_chief_date			= date("Y-m-d");
	} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "Sales Head"){
		$complaint->cna_sales_head				= "Yes";
		$complaint->cna_sales_head_date			= date("Y-m-d");
	} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "CFO"){
		if(isset($_POST['cna_md_status'])){
			$complaint->cna_md_status			= "Yes";
		} else {
			$complaint->cna_md_status			= "No";
			$complaint->emp_status				= "All Approved";
		}
		
		$complaint->cna_cfo						= "Yes";
		$complaint->cna_cfo_date				= date("Y-m-d");
		//$complaint->status					= "Closed";
		
	} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "MD"){
		$complaint->cna_md						= "Yes";
		$complaint->cna_md_date					= date("Y-m-d");
		$complaint->emp_status					= "All Approved";
		
		//$complaint->status					= "Closed";
	} else {
		$session->message("Approver Not Found");
		redirect_to("approval.php?id=".$_GET['id']);
	}
		


	if($complaint->save()) {
		// Success
		
		if(isset($_POST['approver_remark'])){
			$approval_note = ApprovalNote::find_by_comp_id($_GET['id']);
			$approval_note->approver_remark = nl2br($_POST['approver_remark']);
			$approval_note->save();
		}

		$mail->send();
		   
		$session->message("Approval Note Approved");
		redirect_to("approval.php?id=".$_GET['id']);
	} else {
		// Failure
		$session->message("Fail to Approve Approval Note");
		redirect_to("approval.php?id=".$_GET['id']);
	}





?>


