<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	require '../PHPMailer/PHPMailerAutoload.php';
	//date_default_timezone_set('Asia/Calcutta');

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  // ini_set('max_execution_time', 15);
  error_reporting(E_ALL);


	foreach ($_POST as $key => $value) {
		//if (preg_match('/[\"\^%*}!{><;`=+-]/', $value)){
		if (preg_match('/[\"\^*}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Complaint Form"); redirect_to("raised-complaint.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\"\^*}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Complaint Form"); redirect_to("raised-complaint.php");
		}
	}

	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	$employee_reg = EmployeeReg::find_by_id($session->employee_id);
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	if ($session->is_employee_logged_in()){ 
		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != '' Limit 1";
		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
		if(!$employee_location){
			redirect_to("my-cvc.php"); 
		}
	}

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

	if ($_POST['product'] == "") {
		$session->message("Select Product");
		redirect_to("raised-complaint.php");
	} 

	if ($_POST['plant_location'] == "") {
		$session->message("Select Location");
		redirect_to("raised-complaint.php");
	} 

	if ($_POST['rejected_quantity'] == "") {
		$session->message("Add Rejected Quantity");
		redirect_to("raised-complaint.php");
	} else {
		if (!is_numeric($_POST['rejected_quantity'])) {
			$session->message("Enter Rejected Quantity in Number only");
			redirect_to("raised-complaint.php");
		}
	} 

	if ($_POST['invoice_number'] == "") {
		$session->message("Enter Invoice Number");
		redirect_to("raised-complaint.php");
	} else {
		$invoice_number = $_POST['invoice_number'];
		/*if(strlen($invoice_number) != 12){
			$session->message("Enter 12 digit Invoice Number");
			redirect_to("raised-complaint.php");
		}*/
	} 

	if ($_POST['invoice_date'] == "") {
		$session->message("Select Invoice Date");
		redirect_to("raised-complaint.php");
	} 

	if ($_POST['defect_batch_no'] == "") {
		$session->message("Enter Defected Batch Number");
		redirect_to("raised-complaint.php");
	} else {
		$defect_batch_no = $_POST['defect_batch_no'];
		if(strlen($defect_batch_no) > 40){
			$session->message("Maximum character limit for Defected Batch Number is 40");
			redirect_to("raised-complaint.php");
		} 
	} 

	if ($_POST['complaint_type'] == "") {
		$session->message("Select Complaint Type");
		redirect_to("raised-complaint.php");
	}  

	if ($_POST['complaint_type'] == "Other") {
		if ($_POST['complaint_typeOther'] == "") {
			$session->message("Enter Complaint Type");
			redirect_to("raised-complaint.php");
		} 
	} 

	if ($_POST['sub_complaint_type'] == "Other") {
		if ($_POST['complaintSubTypeOther'] == "") {
			$session->message("Enter Sub Complaint Type");
			redirect_to("raised-complaint.php");
		}  
	} 

	if ($_POST['company'] == "") {
		$session->message("Select Company");
		redirect_to("raised-complaint.php");
	} 

	if ($_POST['pl_name'] == "") {
		$session->message("Select Complaint Raised by");
		redirect_to("raised-complaint.php");
	} 

	function isValidEmail($email){ 
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}


	if ($_POST['pl_name'] == "Other") {

		if ($_POST['pl_name_2'] == "") {
			$session->message("Enter Person Name");
			redirect_to("raised-complaint.php");
		} else {
			
			if (preg_match('/[0-9]/', $_POST['pl_name_2'])){
				$session->message("Remove Number from Person Name");
				redirect_to("raised-complaint.php");
			}

			if ($_POST['pl_email'] == "") {
				$session->message("Enter Employee Email");
				redirect_to("raised-complaint.php");
			}

			if(!isValidEmail($_POST['pl_email'])){
			 	$session->message("Invalid Employee Email");
			 	redirect_to("raised-complaint.php");
			}

			if ($_POST['pl_mobile'] == "") {
				$session->message("Enter Employee Mobile");
				redirect_to("raised-complaint.php");
			}
			if ($_POST['pl_mobile'] != "") {		
				
				$phone_num = $_POST['pl_mobile'];
				if (is_numeric($phone_num)) {
					if (strlen($phone_num) != 10) {
						$session->message("Enter 10 digit Mobile Number");
						redirect_to("raised-complaint.php");
					}
				} else {
					$session->message("Enter valid Mobile Number");
					redirect_to("raised-complaint.php");
				}
				
			}  else{
				$session->message("Enter Mobile Number");
				redirect_to("raised-complaint.php");
			}
		}

	}

  if ($_POST['size'] == "") {
    $session->message("Enter size details");
    redirect_to("raised-complaint.php");
  } 

	$last_tn = Complaint::find_by_last_id();
	if($last_tn){
		//$get_tn = str_replace("TN","",);
		$new_tn = $last_tn->ticket_no+1;
		
		$ticket_no = sprintf( '%06d', $new_tn );
	} else {
		echo $ticket_no = "000001";
	}
	

	$business_vertical = Product::find_business_vertical($_POST['plant_location'], $_POST['product']);


	$count_emp_lead 	= EmployeeLocation::count_emp_lead($business_vertical->id,'Responsible');
	if($count_emp_lead >= 1){
		$sql = "Select * from employee_location where product_id = {$business_vertical->id} AND role_priority = 'Responsible' order by id ASC";
		$emp_location = EmployeeLocation::find_by_sql($sql);
		$num = 0;
		foreach($emp_location as $emp_location){
			if($emp_location->lead == 0){
				if($num == 0){
					$emp_location->lead = 1;
					$emp_location->save();
					$num++;
				}
			} 
			else if($emp_location->lead == 1){
				$emp_location->lead = 0;
				$emp_location->save();
			}
		}
		
		if($num == 0){
			$employee_location_off 	= EmployeeLocation::authenticate_emp_lead($business_vertical->id,'Responsible',0);
			if($employee_location_off){
				$employee_location_off->lead = 1;
				$employee_location_off->save();
			}
		}
	} else {
		$employee_location_off 	= EmployeeLocation::authenticate_emp_lead($business_vertical->id,'Responsible',0);
		if($employee_location_off){
			$employee_location_off->lead = 1;
			$employee_location_off->save();
		}
	}



	$location_emp_id 	= ""; $location_emp_name 	= ""; $location_emp_email = "";
	/*$emp_num = 1;
	while($emp_num != 0){
		$sql = "Select * from employee_location where product_id = {$business_vertical->id} AND role_priority = 'Responsible' order by id ASC Limit 1";
		$employee_location = EmployeeLocation::find_by_sql($sql);

		if($employee_location){
			foreach($employee_location as $employee_location){
				if($employee_location->lead == 1){
					$location_emp_id 	= $employee_location->emp_id;
					$location_emp_name 	= $employee_location->emp_name;
					$location_emp_email = $employee_location->emp_email;
					$emp_num = 0;
				}
			}
		} else {
			if($emp_num >= 5){
				$session->message("Employee Not Found");
				redirect_to("raised-complaint.php");
			}
			$emp_num++;
			//echo $emp_num;
		}
	}*/
  $empsql = "Select * from employee_location where product_id = {$business_vertical->id} AND role_priority = 'Responsible' AND lead = 1 order by id ASC Limit 1";
  $employee_location = EmployeeLocation::find_by_sql($empsql);

  if($employee_location){
    foreach($employee_location as $employee_location){
        $location_emp_id  = $employee_location->emp_id;
        $location_emp_name  = $employee_location->emp_name;
        $location_emp_email = $employee_location->emp_email;
    }
  }

  if( empty($location_emp_email) ){
    $session->message("Employee Not Found");
    redirect_to("raised-complaint.php");
  }


	$location_1_emp_id 	= ""; $location_1_emp_name 	= ""; $location_1_emp_email = "";
	$sql = "Select * from employee_location where product_id = {$business_vertical->id} AND role_priority = 'Escalation 1' order by id ASC Limit 1";
	$employee_location_1 = EmployeeLocation::find_by_sql($sql);

	if($employee_location_1){
		foreach($employee_location_1 as $employee_location_1){
			$location_1_emp_id 	= $employee_location_1->emp_id;
			$location_1_emp_name 	= $employee_location_1->emp_name;
			$location_1_emp_email = $employee_location_1->emp_email;
		}
	}

	$location_2_emp_id 	= ""; $location_2_emp_name 	= ""; $location_2_emp_email = "";
	$sql = "Select * from employee_location where product_id = {$business_vertical->id} AND role_priority = 'Escalation 2' order by id ASC Limit 1";
	$employee_location_2 = EmployeeLocation::find_by_sql($sql);

	if($employee_location_2){
		foreach($employee_location_2 as $employee_location_2){
			$location_2_emp_id 	= $employee_location_2->emp_id;
			$location_2_emp_name 	= $employee_location_2->emp_name;
			$location_2_emp_email = $employee_location_2->emp_email;
		}
	}



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
	$complaint->emp_id					= $location_emp_id;
	$complaint->emp_name				= $location_emp_name;

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
	
	$allowed_image_extension = array( "png", "PNG", "jpg", "jpeg", "JPG", "JPEG" );

	if(isset($_FILES['product_img_1']) && !empty($_FILES['product_img_1']['name'])){
		
		if(function_exists('mime_content_type')) {
			$filename = $_FILES['product_img_1']['tmp_name'];
			$mime_type =  mime_content_type($filename);

			if($mime_type != "image/png" && $mime_type != "image/jpeg"){
				$session->message("Invalid Image Format uploaded");
				redirect_to("raised-complaint.php");
			}
		} else {
			$session->message("Failed to Detect File Format.");
			redirect_to("raised-complaint.php");
		}
		
		$img_ext = (explode(".",$_FILES['product_img_1']["name"]));  
		$extensions_count = count($img_ext);
		if($extensions_count > 2){  
			//$session->message("Image has Multiple Extensions");
			//redirect_to("raised-complaint.php");
		} 
				
		$file_extension = pathinfo($_FILES["product_img_1"]["name"], PATHINFO_EXTENSION);
		
		if (!in_array($file_extension, $allowed_image_extension)) {
			$session->message("Upload Valid images. Only PNG and JPEG are allowed.");
			redirect_to("raised-complaint.php");
		}    // Validate image file size
		else if (($_FILES["product_img_1"]["size"] > 25485760)) {
			$session->message("Image size exceeds 25MB");
			redirect_to("raised-complaint.php");
		} else {
			$complaint->product_img_1 		= $_FILES['product_img_1']['name'];	
			$product_img_1					= basename($_FILES['product_img_1']['name']);

			if (!file_exists($path)) {
				mkdir("../document/".$ticket_no."/complaint", 0777, true);
			}

			if(!empty($product_img_1)) {
				//$product_img_1 					= str_replace(" ","_",$product_img_1);
				$product_img_1 					= $ticket_no."-".time()."1.".$file_extension;
				$complaint->product_img_1		= $product_img_1;
				$tp_photo 	=  	$path."/".$product_img_1;
				$move_photo 	= move_uploaded_file($_FILES['product_img_1']['tmp_name'], $tp_photo);
			} else {$complaint->product_img_1 = "";}
		}
		
	}

	if(isset($_FILES['product_img_2']) && !empty($_FILES['product_img_2']['name'])){
		
		if(function_exists('mime_content_type')) {
			$filename = $_FILES['product_img_2']['tmp_name'];
			$mime_type =  mime_content_type($filename);

			if($mime_type != "image/png" && $mime_type != "image/jpeg"){
				$session->message("Invalid Image Format uploaded");
				redirect_to("raised-complaint.php");
			}
		} else {
			$session->message("Failed to Detect File Format.");
			redirect_to("raised-complaint.php");
		}
		
		$img_ext = (explode(".",$_FILES['product_img_2']["name"]));  
		$extensions_count = count($img_ext);
		if($extensions_count > 2){  
			//$session->message("Image has Multiple Extensions");
			//redirect_to("raised-complaint.php");
		} 
				
		$file_extension = pathinfo($_FILES["product_img_2"]["name"], PATHINFO_EXTENSION);
		
		if (!in_array($file_extension, $allowed_image_extension)) {
			$session->message("Upload Valid images. Only PNG and JPEG are allowed.");
			redirect_to("raised-complaint.php");
		}    // Validate image file size
		else if (($_FILES["product_img_2"]["size"] > 25485760)) {
			$session->message("Image size exceeds 25MB");
			redirect_to("raised-complaint.php");
		} else {
			$complaint->product_img_2 		= $_FILES['product_img_2']['name'];	
			$product_img_2					= basename($_FILES['product_img_2']['name']);

			if (!file_exists($path)) {
				mkdir("../document/".$ticket_no."/complaint", 0777, true);
			}

			if(!empty($product_img_2)) {
				//$product_img_2 = str_replace(" ","_",$product_img_2);
				$product_img_2 					= $ticket_no."-".time()."2.".$file_extension;
				$complaint->product_img_2		= $product_img_2;
				$tp_photo 	=  	$path."/".$product_img_2;
				$move_photo 	= move_uploaded_file($_FILES['product_img_2']['tmp_name'], $tp_photo);
			} else {$complaint->product_img_2 = "";}
		}		
	}

	if(isset($_FILES['product_img_3']) && !empty($_FILES['product_img_3']['name'])){
		
		if(function_exists('mime_content_type')) {
			$filename = $_FILES['product_img_3']['tmp_name'];
			$mime_type =  mime_content_type($filename);

			if($mime_type != "image/png" && $mime_type != "image/jpeg"){
				$session->message("Invalid Image Format uploaded");
				redirect_to("raised-complaint.php");
			}
		} else {
			$session->message("Failed to Detect File Format.");
			redirect_to("raised-complaint.php");
		}
		
		$img_ext = (explode(".",$_FILES['product_img_3']["name"]));  
		$extensions_count = count($img_ext);
		if($extensions_count > 2){  
			//$session->message("Image has Multiple Extensions");
			//redirect_to("raised-complaint.php");
		} 
				
		$file_extension = pathinfo($_FILES["product_img_3"]["name"], PATHINFO_EXTENSION);
		
		if (!in_array($file_extension, $allowed_image_extension)) {
			$session->message("Upload Valid images. Only PNG and JPEG are allowed.");
			redirect_to("raised-complaint.php");
		}    // Validate image file size
		else if (($_FILES["product_img_3"]["size"] > 25485760)) {
			$session->message("Image size exceeds 25MB");
			redirect_to("raised-complaint.php");
		} else {
			$complaint->product_img_3 		= $_FILES['product_img_3']['name'];	
			$product_img_3					= basename($_FILES['product_img_3']['name']);

			if (!file_exists($path)) {
				mkdir("../document/".$ticket_no."/complaint", 0777, true);
			}

			if(!empty($product_img_3)) {
				//$product_img_3 					= str_replace(" ","_",$product_img_3);
				$product_img_3 					= $ticket_no."-".time()."3.".$file_extension;
				$complaint->product_img_3		= $product_img_3;
				$tp_photo 	=  	$path."/".$product_img_3;
				$move_photo 	= move_uploaded_file($_FILES['product_img_3']['tmp_name'], $tp_photo);
			} else {$complaint->product_img_3 = "";}
		}
		
	}


	$complaint->cust_status				= "Complaint Registered";
	$complaint->emp_status				= "Complaint Received";

	$complaint->status					= "Open";
	$complaint->date_					= date("Y-m-d");
	$complaint->time_					= date("H:i:s");

  $complaint->size          = getValue($_POST, 'size');


	if($complaint->save()) {
		
    //Send email to company customer
		$toArr = [];
    $ccArr = [];

		if($complaint->pl_email != $company_reg->emp_email_1 && $complaint->pl_email != $company_reg->emp_email_2 && $complaint->pl_email != $company_reg->emp_email_3 && $complaint->pl_email != $company_reg->emp_email_4 && $complaint->pl_email != $company_reg->emp_email_5){

        $toArr[] = ['email' => $complaint->pl_email, 'name' => $complaint->pl_name ];
		} 


		if(!empty($company_reg->emp_email_1)){
			if($complaint->pl_email == $company_reg->emp_email_1){

        $toArr[] = ['email' => $company_reg->emp_email_1, 'name' => $company_reg->emp_name_1];
			} else {
        $ccArr[] = ['email' => $company_reg->emp_email_1, 'name' => $company_reg->emp_name_1 ];
			}
		}
		if(!empty($company_reg->emp_email_2)){
			if($complaint->pl_email == $company_reg->emp_email_2){
        $toArr[] = ['email' => $company_reg->emp_email_2, 'name' =>$company_reg->emp_name_2];
			} else {
        $ccArr[] = ['email' => $company_reg->emp_email_2, 'name' => $company_reg->emp_name_2 ];
			}
		}
		if(!empty($company_reg->emp_email_3)){
			if($complaint->pl_email == $company_reg->emp_email_3){
        $toArr[] = ['email' => $company_reg->emp_email_3, 'name' => $company_reg->emp_name_3 ];
			} else {
        $ccArr[] = ['email' => $company_reg->emp_email_3, 'name' => $company_reg->emp_name_3 ];
			}
		}
		if(!empty($company_reg->emp_email_4)){
			if($complaint->pl_email == $company_reg->emp_email_4){
        $toArr[] = ['email' => $company_reg->emp_email_4, 'name' => $company_reg->emp_name_4 ];
			} else {
        $ccArr[] = ['email' => $company_reg->emp_email_4, 'name' => $company_reg->emp_name_4 ];
			}
		}
		if(!empty($company_reg->emp_email_5)){
			if($complaint->pl_email == $company_reg->emp_email_5){

        $toArr[] = ['email' => $company_reg->emp_email_5, 'name' => $company_reg->emp_name_5 ];
			} else {
        $ccArr[] = ['email' => $company_reg->emp_email_5, 'name' => $company_reg->emp_name_5 ];
			}
		}

		$user_body = "
		<p>Greetings {$complaint->pl_name},</p>

		<p>Thank-you for contacting Accelo CRM team.</p>

		<p>We have raised complaint on behalf of you. {$employee_location->emp_name} will contact you shortly with the next steps.</p>

		<h3>Below are your complaint details.</h3> 

		<p><strong>Complaint No. :</strong> {$ticket_no} <br />
		<strong>Nature of Complaint:</strong> {$complaint->business_vertical}, {$complaint->complaint_type}<br />
		<strong>Remarks:</strong> {$complaint->pl_feedback} </p>

		<p>Requesting you to track the complaint status by clicking on the link below.</p>
		
		<p><a style=' text-decoration:none; color:#1774b5' href='".BASE_URL."customer/'>".BASE_URL."customer/</a></p> 
		";

		$user_subject = getComplaintSubjectCustomer($complaint);

		sendMail($user_subject, $user_body, $toArr , $ccArr);
		
    //send email to admin
		$admin_body = "
  		<p>Dear {$location_emp_name},</p>

  		<p>You've received a new complaint!</p>

  		<p>Requesting you to work on the complaint & respond to the customer at the earliest.</p> ";

		$admin_subject = getComplaintSubjectAdmin($complaint);
		
    $toArr = array(  ['email' => $location_emp_email, 'name' => $location_emp_name ]  );
    $ccArr = array(
      ['email' => $location_1_emp_email, 'name' => $location_1_emp_name ],
      ['email' => $location_2_emp_email, 'name' => $location_2_emp_name ]
    );
      
    sendComplaintMail($complaint, $admin_subject, $admin_body, $toArr , $ccArr);

		
		if(!empty($complaint->pl_mobile)){
			$mobile = $complaint->pl_mobile;
			$message = "The complaint has been raised on behalf of you. \nYour Complaint ID is {$ticket_no}. \nTeam Accelo will get back to you with the next steps, shortly.";
			//$message = "Thank You!! \nYour Complaint ID is {$ticket_no}. \nTeam Accelo will get back to you with the next steps, shortly.";

      echo sendSms($mobile, $message);
		}
		
		
		
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
		//}
	} else {
		// Failure
		$session->message("Failed to Raise Complaint");
		redirect_to("my-complaints.php");
	}
	
?>


