<?php 	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	ob_start();
	require '../PHPMailer/PHPMailerAutoload.php';
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

	
	if ($_POST['employee'] == "") {
		$session->message("Select Employee"); redirect_to("add-site-location.php");
	}

	if ($_POST['emp_sub_role'] == "") {
		$session->message("Select Employee Role"); redirect_to("add-site-location.php");
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Query."); redirect_to("add-site-location.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Query."); redirect_to("add-site-location.php"); 
		}
	} else {
		$session->message("Company not found"); redirect_to("add-site-location.php"); 
	}


	if(!isset($_GET['id']) || empty($_GET['id'])){
		$session->message('Product Not Found');
		redirect_to("add-site-location.php"); 
	}	
	
	$employee_reg 	= EmployeeReg::find_by_id($_POST['employee']);
	$product 		= Product::find_by_id($_GET['id']);

	if($employee_reg){
		$emp_location 	= new EmployeeLocation();

		$auth_emp 		= EmployeeLocation::authenticate_emp_role($_GET['id'],$_POST['employee'],$_POST['emp_sub_role']);

		if($auth_emp){
			$session->message($auth_emp->emp_name. " Already Registered as ".$_POST['emp_sub_role']);
			redirect_to("employee-location.php?id=".$_GET['id']);
		}

		$emp_location->product_id		= $_GET['id'];
		$emp_location->emp_id			= $employee_reg->id;
		$emp_location->emp_name			= $employee_reg->emp_name;
		$emp_location->emp_email		= $employee_reg->emp_email;
		$emp_location->emp_mobile		= $employee_reg->emp_mobile;
		$emp_location->emp_role			= $employee_reg->emp_role;
		$emp_location->emp_sub_role		= $_POST['emp_sub_role'];
		$emp_location->role_priority	= $_POST['role_priority'];

		
		$emp_location->status			= 1;
		$emp_location->date_			= date("Y-m-d");
		$emp_location->time_			= date("H:i:s");

		if($emp_location->save()) {
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
			//$mail->addAddress('salvi.suvarna@mahindra.com','Salvi Suvarna');   // Add a recipient
			$mail->addAddress($employee_reg->emp_email,$employee_reg->emp_name);   // Add a recipient
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

					<p>Dear {$employee_reg->emp_name}, </p> 

					<p>You have been added in {$product->department} / {$product->site_location} / {$product->product} team of CS portal.</p>



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


			$mail->Subject = "Welcome to {$product->department} / {$product->site_location} / {$product->product} team of CS portal";
			$mail->Body    = $bodyContent;
			$mail->send();


			$session->message("Employee Added Successfully.");
			redirect_to("employee-location.php?id=".$_GET['id']);
		} else {
			// Failure
			$session->message("Fail to Add Employee.");
			redirect_to("employee-location.php?id=".$_GET['id']);
		}
	} else {
		// Failure
		$session->message("Invalid Employee Selection.");
		redirect_to("employee-location.php?id=".$_GET['id']);
	}
	
	
?>