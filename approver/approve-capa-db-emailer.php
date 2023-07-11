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


	foreach ($_POST as $key => $value) {
		//echo htmlspecialchars($key)." = ".htmlspecialchars($value)."<br>";
	}

	//return false;

	if(!isset($_GET['id']) || empty($_GET['id'])){
		$session->message('Complaint Not Found');
		redirect_to("my-complaints.php"); 
	}
	
	$complaint = Complaint::find_by_id($_GET['id']);

	$complaint->identify_source				= $_POST['id_source'];
	
	$employee_loc = EmployeeLocation::find_by_emp_id($session->employee_id);



	if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "Quality Assurance"){
		$complaint->capa_qa				= "Yes";

		$mail = new PHPMailer;

		$mail->IsMail();                            // Set mailer to use SMTP
		$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
$mail->SMTPAuth = false;                     // Enable SMTP authentication
$mail->Username = '';          // SMTP username
$mail->Password = ''; // SMTP password
// $mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
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

		<p>Dear {$employee_loc->emp_name} </p> 

		<p>We have attached the link to the CAPA Document created for your complaint registered under the Ticket Id- {$complaint->ticket_no}</p>		

		<p>Kindly check the below link to access the CAPA Document for future reference.</p>
		<p>(Link)</p>
		<p>We hope Team Accelo was able to assist you through your journey with Mahindra Accelo</p>



		<br /><br />
		<p>Thank You!</p>		
		<p>Best Regards, <br />
		Customer Service Team<br />
		<strong>Mahindra Accelo</strong></p>  
		";

		$mail->Subject = "{$complaint->business_vertical} | {$complaint->plant_location} | Ticket ID #{$complaint->ticket_no} | {$complaint->company_name} | {$complaint->complaint_type}";
		$mail->Body    = $bodyContent;


	} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "Plant Head"){
		$complaint->capa_ph				= "Yes";

		$mail = new PHPMailer;

		$mail->IsMail();                            // Set mailer to use SMTP
		$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
$mail->SMTPAuth = false;                     // Enable SMTP authentication
$mail->Username = '';          // SMTP username
$mail->Password = ''; // SMTP password
// $mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
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

		<p>Dear {$employee_loc->emp_name} </p> 

		<p>We have attached the link to the CAPA Document created for your complaint registered under the Ticket Id- {$complaint->ticket_no}</p>		

		<p>Kindly check the below link to access the CAPA Document for future reference.</p>
		<p>(Link)</p>
		<p>We hope Team Accelo was able to assist you through your journey with Mahindra Accelo</p>



		<br /><br />
		<p>Thank You!</p>		
		<p>Best Regards, <br />
		Customer Service Team<br />
		<strong>Mahindra Accelo</strong></p>  
		";

		$mail->Subject = "{$complaint->business_vertical} | {$complaint->plant_location} | Ticket ID #{$complaint->ticket_no} | {$complaint->company_name} | {$complaint->complaint_type}";
		$mail->Body    = $bodyContent;

	} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "Plant Chief - CN"){
		$complaint->capa_pc				= "Yes";

		$mail = new PHPMailer;

		$mail->IsMail();                            // Set mailer to use SMTP
		$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
$mail->SMTPAuth = false;                     // Enable SMTP authentication
$mail->Username = '';          // SMTP username
$mail->Password = ''; // SMTP password
// $mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;                         // TCP port to connect to

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

		<p>Dear {$employee_loc->emp_name} </p> 

		<p>We have attached the link to the CAPA Document created for your complaint registered under the Ticket Id- {$complaint->ticket_no}</p>		

		<p>Kindly check the below link to access the CAPA Document for future reference.</p>
		<p>(Link)</p>
		<p>We hope Team Accelo was able to assist you through your journey with Mahindra Accelo</p>



		<br /><br />
		<p>Thank You!</p>		
		<p>Best Regards, <br />
		Customer Service Team<br />
		<strong>Mahindra Accelo</strong></p>  
		";

		$mail->Subject = "{$complaint->business_vertical} | {$complaint->plant_location} | Ticket ID #{$complaint->ticket_no} | {$complaint->company_name} | {$complaint->complaint_type}";
		$mail->Body    = $bodyContent;

	} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "Management Representative"){
		$complaint->capa_mr				= "Yes";
		$complaint->emp_status			= "CAPA Approved";

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

		<p>Dear {$employee_loc->emp_name} </p> 

		<p>We have attached the link to the CAPA Document created for your complaint registered under the Ticket Id- {$complaint->ticket_no}</p>		

		<p>Kindly check the below link to access the CAPA Document for future reference.</p>
		<p>(Link)</p>
		<p>We hope Team Accelo was able to assist you through your journey with Mahindra Accelo</p>



		<br /><br />
		<p>Thank You!</p>		
		<p>Best Regards, <br />
		Customer Service Team<br />
		<strong>Mahindra Accelo</strong></p>  
		";

		$mail->Subject = "{$complaint->business_vertical} | {$complaint->plant_location} | Ticket ID #{$complaint->ticket_no} | {$complaint->company_name} | {$complaint->complaint_type}";
		$mail->Body    = $bodyContent;

	} else {
		$session->message("Approver Not Found");
		redirect_to("capa-approval.php?id=".$_GET['id']);
	}



	if($complaint->save()) {
		// Success
		$mail->send();
		$session->message("CAPA Approved");
		redirect_to("capa-approval.php?id=".$_GET['id']);
	} else {
		// Failure
		$session->message("Failed to Approve CAPA");
		redirect_to("capa-approval.php?id=".$_GET['id']);
	}





?>


