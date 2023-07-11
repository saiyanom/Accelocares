<?php ob_start();
	require_once("../includes/initialize.php"); 
	require '../PHPMailer/PHPMailerAutoload.php';

	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	////date_default_timezone_set('Asia/Calcutta');
?>
<!-- App css -->
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
<!-- App js -->
<script src="assets/js/app.min.js"></script>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#success-alert-modal').modal('show');
    });
</script>


<?php
	
	foreach ($_POST as $key => $value) {
		//echo htmlspecialchars($key)." = ".htmlspecialchars($value)."<br>";
	}

	//return false;

	$last_tn = Complaint::find_by_last_id();
	if($last_tn){
		//$get_tn = str_replace("TN","",);
		$new_tn = $last_tn->ticket_no+1;
		
		$ticket_no = sprintf( '%06d', $new_tn );
	} else {
		echo $ticket_no = "000001";
	}
	

	$business_vertical = Product::find_business_vertical($_POST['plant_location'], $_POST['product']);

    // Driver code 
    $date = $_POST['invoice_date']; 
	$date = str_replace('/', '-', $date);
	// convert date and time to seconds 
	$sec = strtotime($date); 

	// convert seconds into a specific format 
	$invoice_date = date("Y-m-d", $sec); 

	$company_reg 	= CompanyReg::find_by_id($_POST['company']);
	$employee		= EmployeeReg::find_by_id($session->employee_id);


	$complaint = new Complaint();
	$complaint->emp_id					= $employee->id;
	$complaint->emp_name				= $employee->emp_name;

	$complaint->customer_id				= $company_reg->customer_id;
	$complaint->company_name			= $company_reg->company_name;
	$complaint->ticket_no				= $ticket_no;
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
	

	$complaint->rejected_quantity		= $_POST['rejected_quantity']." ".$_POST['quantity_type'];
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


	$path = "../document/".$ticket_no."/complaint";

	if(isset($_FILES['product_img_1'])){
		$complaint->product_img_1 		= $_FILES['product_img_1']['name'];	
		$product_img_1					= basename($_FILES['product_img_1']['name']);
		
		if (!file_exists($path)) {
			mkdir("../document/".$ticket_no."/complaint", 0777, true);
		}
		
		if(!empty($product_img_1)) {
			$product_img_1 					= str_replace(" ","_",$product_img_1);
			$product_img_1 					= time()."-".$product_img_1;
			$complaint->product_img_1		= $product_img_1;
			$tp_photo 	=  	$path."/".$product_img_1;
			$move_photo 	= move_uploaded_file($_FILES['product_img_1']['tmp_name'], $tp_photo);
		} else {$complaint->product_img_1 = "";}
		
	}
	if(isset($_FILES['product_img_2'])){
		$complaint->product_img_2 		= $_FILES['product_img_2']['name'];	
		$product_img_2					= basename($_FILES['product_img_2']['name']);
		
		if (!file_exists($path)) {
			mkdir("../document/".$ticket_no."/complaint", 0777, true);
		}

		if(!empty($product_img_2)) {
			$product_img_2 = str_replace(" ","_",$product_img_2);
			$product_img_2 					= time()."-".$product_img_2;
			$complaint->product_img_2		= $product_img_2;
			$tp_photo 	=  	$path."/".$product_img_2;
			$move_photo 	= move_uploaded_file($_FILES['product_img_2']['tmp_name'], $tp_photo);
		} else {$complaint->product_img_2 = "";}
	}
	if(isset($_FILES['product_img_3'])){
		$complaint->product_img_3 		= $_FILES['product_img_3']['name'];	
		$product_img_3					= basename($_FILES['product_img_3']['name']);
		
		if (!file_exists($path)) {
			mkdir("../document/".$ticket_no."/complaint", 0777, true);
		}

		if(!empty($product_img_3)) {
			$product_img_3 					= str_replace(" ","_",$product_img_3);
			$product_img_3 					= time()."-".$product_img_3;
			$complaint->product_img_3		= $product_img_3;
			$tp_photo 	=  	$path."/".$product_img_3;
			$move_photo 	= move_uploaded_file($_FILES['product_img_3']['tmp_name'], $tp_photo);
		} else {$complaint->product_img_3 = "";}
	}
	if(isset($_FILES['product_img_4'])){
		$complaint->product_img_4 		= $_FILES['product_img_4']['name'];	
		$product_img_4					= basename($_FILES['product_img_4']['name']);
		
		if (!file_exists($path)) {
			mkdir("../document/".$ticket_no."/complaint", 0777, true);
		}

		if(!empty($product_img_4)) {
			$product_img_4 					= str_replace(" ","_",$product_img_4);
			$product_img_4 					= time()."-".$product_img_4;
			$complaint->product_img_4		= $product_img_4;
			$tp_photo 						=  	$path."/".$product_img_4;
			$move_photo 	= move_uploaded_file($_FILES['product_img_4']['tmp_name'], $tp_photo);
		} else {$complaint->product_img_4 = "";}
	}


	$complaint->cust_status				= "Complaint Registered";
	$complaint->emp_status				= "Complaint Received";

	$complaint->status					= "Open";
	$complaint->date_					= date("Y-m-d");
	$complaint->time_					= date("H:i:s");



	if($complaint->save()) {

		$mail = new PHPMailer;

		$mail->IsMail();                            // Set mailer to use SMTP
		$mail->Host = '172.32.0.173';             // Specify main and backup SMTP servers
		$mail->SMTPAuth = false;                     // Enable SMTP authentication
		$mail->Username = '';          // SMTP username
		$mail->Password = ''; // SMTP password
		//$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 25;                          // TCP port to connect to

		//$mail->SMTPDebug = 2;
		$mail->Mailer = "smtp";
		$mail->Priority = 1;
		$mail->setFrom('crm.accelo@emailmahindra.com', 'Mahindra Accelo');
		$mail->addAddress($location_emp_email, $location_emp_name);   // Add a recipient
		$mail->addCC('salvi.suvarna@mahindra.com','Salvi Suvarna');
		$mail->addCC('gajelli.lalita@mahindra.com','Lalita Gajelli');
		$mail->isHTML(true);  // Set email format to HTML

		$bodyContent = "

		<p>Dear, {$location_emp_name}</p> <br />


		<p>You’ve received a new complaint!</p>

		<p>Would appreciate if you could work on the feedback received & get back to the client at the earliest.</p> 


		<p>Thank You!</p>
		
		<p>Best Regards, <br />
		Customer Service Team <br />
		<strong>Mahindra Accelo</strong></p>  
		
		<p>Note:<br />
		<i>This is an auto generated e-mail, hence please do not reply</i>.</p>
		";

		$mail->Subject = "{$complaint->business_vertical} | {$complaint->plant_location} | Ticket ID #{$ticket_no} | {$complaint->company_name} | {$complaint->complaint_type}";
		$mail->Body    = $bodyContent;

		if(!$mail->send()) {
		    //echo 'Message could not be sent. <br />';
		    //echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    //echo 'Message has been sent';
?>
		<!-- Success Alert Modal -->
		<div id="success-alert-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content modal-filled bg-success">
					<div class="modal-body p-4">
						<div class="text-center">
							<i class="dripicons-checkmark h1"></i>
							<h2 class="mt-2">Thank You!!!</h2>
							<p class="mt-3" style="font-size:18px;">
								Your Complaint ID is <?php echo $ticket_no; ?>. <br />
								Team Accelo will get back to you with the next steps, shortly.
							</p>
							<a href="my-complaints.php" class="btn btn-light my-2">Continue</a>
						</div>
					</div>
				</div><!-- /.modal-content -->
			</div> <!-- /.modal-dialog -->
		</div><!-- /.modal -->
<?php
		// Success
		//$session->message("Complaint Raised Successfully");
		//redirect_to("my-complaints.php");
	} else {
		// Failure
		$session->message("Failed to Raise Complaint");
		redirect_to("my-complaints.php");
	}
	
?>


