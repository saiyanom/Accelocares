<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	require '../PHPMailer/PHPMailerAutoload.php';
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	//////date_default_timezone_set('Asia/Calcutta');
/*
	foreach ($_POST as $key => $value) {
		//if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
		if (preg_match('/[\"\^*}!{><;`=]/', $value)){
			$session->message("Remove Special Character"); redirect_to("capa-approval.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\"\^*}!{><;`=]/', $value)){
			$session->message("Remove Special Character"); redirect_to("capa-approval.php");
		}
	}*/

	if(isset($_GET['id']) && !empty($_GET['id'])){

		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Document.");
			redirect_to("capa-approval.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Document.");
			redirect_to("capa-approval.php");
		}
	} else {
		$session->message("Complaint Not Found");
		redirect_to("all-complaints.php");
	}

	if ($_POST['identify_source'] == "") {
		//$session->message("Source No Found");
		//redirect_to("capa-approval.php");
	} 
	
	
	$employee_reg = EmployeeReg::find_by_id($session->employee_id);
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	if ($session->is_employee_logged_in()){ 

		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != 'Employee' Limit 1";

		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);

		if(!$employee_location){
			redirect_to("logout.php"); 
		}
	}



	foreach ($_POST as $key => $value) {
		//echo htmlspecialchars($key)." = ".htmlspecialchars($value)."<br>";
	}

	//return false;

	if(!isset($_GET['id']) || empty($_GET['id'])){
		$session->message('Complaint Not Found');
		redirect_to("my-complaints.php"); 
	}
	
	$complaint = Complaint::find_by_id($_GET['id']);

	//$complaint->identify_source				= $_POST['identify_source'];



	$complaint = Complaint::find_by_id($_GET['id']);


	$product_id = Product::find_product_id($complaint->business_vertical,$complaint->plant_location,$complaint->product);

	if($product_id){
		$employee_loc = EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"Quality Assurance");
		if(!$employee_loc){
			$employee_loc = EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"Plant Head");
			if(!$employee_loc){
				$employee_loc = EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"Plant Chief - CN");
				if(!$employee_loc){
					$employee_loc = EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"Management Representative");
				}
			}
		}



		//$employee_loc = EmployeeLocation::find_by_emp_id($session->employee_id);

		if($employee_loc->emp_sub_role == "Quality Assurance"){
			$complaint->capa_qa				= "Yes";
			$complaint->capa_qa_name		= $employee_loc->emp_name;

			$employee_loc = EmployeeLocation::find_by_productId_emp_role($product_id->id,"Plant Head");
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
			$mail->addAddress($employee_loc->emp_email,$employee_loc->emp_name);   // Add a recipient
			$mail->addCC('salvi.suvarna@mahindra.com','Salvi Suvarna');
			$mail->addCC('gajelli.lalita@mahindra.com','Lalita Gajelli');
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

					<p>Dear {$employee_loc->emp_name}, </p> 

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
			$mail->send();

		} else if($employee_loc->emp_sub_role == "Plant Head"){
			$complaint->capa_ph				= "Yes";
			$complaint->capa_ph_name		= $employee_loc->emp_name;

			$employee_loc = EmployeeLocation::find_by_productId_emp_role($product_id->id,"Plant Chief - CN");
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
			$mail->addAddress($employee_loc->emp_email,$employee_loc->emp_name);   // Add a recipient
			$mail->addCC('salvi.suvarna@mahindra.com','Salvi Suvarna');
			$mail->addCC('gajelli.lalita@mahindra.com','Lalita Gajelli');
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

					<p>Dear {$employee_loc->emp_name}, </p> 

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
			$mail->send();

		} else if($employee_loc->emp_sub_role == "Plant Chief - CN"){
			$complaint->capa_pc				= "Yes";
			$complaint->capa_pc_name		= $employee_loc->emp_name;

			$employee_loc = EmployeeLocation::find_by_productId_emp_role($product_id->id,"Management Representative");
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
			$mail->addAddress($employee_loc->emp_email,$employee_loc->emp_name);   // Add a recipient
			$mail->addCC('salvi.suvarna@mahindra.com','Salvi Suvarna');
			$mail->addCC('gajelli.lalita@mahindra.com','Lalita Gajelli');
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

					<p>Dear {$employee_loc->emp_name}, </p> 

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
			$mail->send();

		} else if($employee_loc->emp_sub_role == "Management Representative"){
			$complaint->capa_mr				= "Yes";
			$complaint->capa_mr_name		= $employee_loc->emp_name;
			$complaint->emp_status			= "CAPA Approved";

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
			$mail->addAddress($complaint->pl_email,$complaint->pl_name);   // Add a recipient
			$mail->addCC('salvi.suvarna@mahindra.com','Salvi Suvarna');
			$mail->addCC('gajelli.lalita@mahindra.com','Lalita Gajelli');
			//$mail->addBCC('bcc@example.com');

			$mail->isHTML(true);  // Set email format to HTML

			//  Customer Email Message 
			$bodyContent = "
				<table  cellpadding='0' cellspacing='0' border='0' align='center' style=' background:#fff;width:700px;  min-width:300px; color:#262626; font-size:17px; font-family: Verdana, Geneva, sans-serif'>

					<tr><td style='display:block'><img src='".BASE_URL."administrator/images/1.jpg' /></td></tr>
					<tr>
					<td  cellpadding='0' cellspacing='0' border='0' width='100%' style='display:block;'>
					<table border='0' style=' padding:30px '>

					<tr>
					<td style='line-height:23px'>

					<p>Dear {$complaint->pl_name}, </p> 

					<p>CAPA document is prepared for your complaint number {$complaint->ticket_no}.</p>

					<p>Requesting you to click on the below link to access the CAPA Document.</p>

					<p><a style=' text-decoration:none; color:#1774b5' href='".BASE_URL."customer/'>".BASE_URL."customer/</a></p>

					<p>We hope Team Accelo was able to resolve the complaint.</p>


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


			/*$bodyContent = "

			<p>Dear {$complaint->company_name} </p> 

			<p>We have attached the link to the CAPA Document created for your complaint registered under the Complaint ID- {$complaint->ticket_no}</p>		

			<p>Kindly check the below link to access the CAPA Document for future reference.</p>
			<p>(Link)</p>
			<p>We hope Team Accelo was able to assist you through your journey with Mahindra Accelo</p>



			<br /><br />
			<p>Thank You!</p>		
			<p>Best Regards, <br />
			Customer Service Team<br />
			<strong>Mahindra Accelo</strong></p> 


			/////////////////////////////////////////////////////////

			<p>Dear {$employee_loc->emp_name} </p> <br />

			<p>The team has analysed & processed the complaint registered under Complaint ID- {$complaint->ticket_no}</p>		

			<p>Complaint detail<br />
			Customer Name: {$complaint->company_name}<br />
			Nature of Complaint: {$complaint->business_vertical}, {$complaint->complaint_type}<br />
			Source : {$complaint->identify_source}<br />
			Action to be taken: {$complaint->other_advice}<br />

			{$complaint->emp_name} and team has prepared the CAPA for the above Complaint <br />

			Requesting you to approve the same. <br />
			Below is the link : <br />
			".BASE_URL."administrator/approver/capa-approval.php
			</p>  

			<br /><br /><br />
			<p>Thank You for your time! </p>		
			<p>Best Regards, <br />
			Customer Service Team<br />
			<strong>Mahindra Accelo</strong></p>  
			";*/

			$mail->Subject = getComplaintSubjectAdmin($complaint);
			$mail->Body    = $bodyContent;
			$mail->send();

		} else {
			$session->message("Approver Not Found");
			redirect_to("capa-approval.php?id=".$_GET['id']);
		}
	}




	if($complaint->save()) {
		// Success
		
		$session->message("CAPA Approved");
		redirect_to("capa-approval.php?id=".$_GET['id']);
	} else {
		// Failure
		$session->message("Failt to Approve CAPA");
		redirect_to("capa-approval.php?id=".$_GET['id']);
	}





?>


