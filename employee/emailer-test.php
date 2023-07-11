<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	require '../PHPMailer/PHPMailerAutoload.php';






	$mail = new PHPMailer;

	$mail->IsMail();                            // Set mailer to use SMTP
	$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
	$mail->SMTPAuth = false;                     // Enable SMTP authentication
	$mail->Username = '';          // SMTP username
	$mail->Password = ''; // SMTP password
	////$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 25;                          // TCP port to connect to

	//$mail->SMTPDebug = 2;
	//$mail->Mailer = "smtp";
	$mail->Priority = 1;
	$mail->setFrom('accelo.service@emailmahindra.com', 'Mahindra Accelo');
	$mail->addAddress('mithun@agency09.in','Mithun Yadav');   // Add a recipient
	//$mail->addAddress('salvi.suvarna@mahindra.com','Salvi Suvarna');   // Add a recipient
	//$mail->addAddress('{$employee_loc->emp_email}','{$employee_loc->emp_name}');   // Add a recipient
	//$mail->addCC('cc@example.com');
	//$mail->addBCC('bcc@example.com');

	$mail->isHTML(true);  // Set email format to HTML

	$bodyContent = "


	<table  cellpadding='0' cellspacing='0' border='0' align='center' style=' background:#fff;width:700px;  min-width:300px; color:#262626; font-size:17px; font-family: Verdana, Geneva, sans-serif'>


	<tr><td style='display:block'><img src='https://www.accelokonnect.com/crm/administrator/images/1.jpg' /></td></tr>
	<tr>
	<td  cellpadding='0' cellspacing='0' border='0' width='100%' style='display:block;'>
	<table border='0' style=' padding:30px '>

	<tr>
	<td style='padding:0 0 10px'><img src='https://www.accelokonnect.com/crm/administrator/images/logo.png' /></td>
	</tr>

	<tr>
	<td style='line-height:23px'>

	<p>Dear {$employee_loc->emp_name} </p> <br />

	<p>The team has analysed & processed the complaint registered under Ticket Id- {$complaint->ticket_no}</p>		

	<p><strong>Complaint detail</strong><br />
	<strong>Customer Name: {$complaint->company_name}<br />
	<strong>Nature of Complaint:</strong> {$complaint->business_vertical}, {$complaint->complaint_type}<br />
	<strong>Source :</strong> {$complaint->identify_source}<br />
	<strong>Action to be taken:</strong> {$complaint->other_advice}<br />

	{$complaint->emp_name} and team has prepared the Approval Note for the above Complaint <br />

	Requesting you to approve the same. <br />
	Below is the link : <br />
	<a style=' text-decoration:none; color:#1774b5' href='https://www.accelokonnect.com/crm/administrator/approver/approval.php'>https://www.accelokonnect.com/crm/administrator/approver/approval.php</a>
	</p>  

	<p>If you need any further assistance in the interim, please feel free to contact the undersigned or mail us at <a href='mailto:customerservicessc@mahindra.com'  style=' text-decoration:none; color:#1774b5'>customerservicessc@mahindra.com</a></p>

	<br /><br />
	<p>Thank you for writing to us.</p>
	<p>Best Regards, <br />
	Customer Service Team <br />
	<strong>Mahindra Accelo</strong></p>
	<p><i>Note: This is an auto generated e-mail, hence please do not reply.</i></p>


	</td>
	</tr>
	</table>
	</td>
	</tr>

	<tr><td style='display:block'><img src='https://www.accelokonnect.com/crm/administrator/images/1.jpg' /></td></tr>
	</table>



	
	";

	$mail->Subject = "{$complaint->business_vertical} | {$complaint->plant_location} | Ticket ID #{$complaint->ticket_no} | {$complaint->company_name} | {$complaint->complaint_type}";
	$mail->Body    = $bodyContent;
	if($mail->send()){
		echo "yes";
	} else {echo "No"; }


?>



