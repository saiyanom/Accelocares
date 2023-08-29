<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	require '../PHPMailer/PHPMailerAutoload.php';
	//date_default_timezone_set('Asia/Calcutta');

	// error_reporting(E_ALL);
	// ini_set('display_errors', 1);

  // dd($_POST);
	/*foreach ($_POST as $key => $value) {
		if (preg_match('/[\"\^*}!{><;`=]/', $value)){
			$session->message("Remove Special Character"); redirect_to("approval.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\"\^*}!{><;`=]/', $value)){
			$session->message("Remove Special Character"); redirect_to("approval.php");
		}
	}*/

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


	if ($session->is_employee_logged_in()){ 
		/*$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != 'Employee' Limit 1";

    $employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);

    if(!$employee_location){
      redirect_to("logout.php?"); 
    }*/

    if(!isset($_GET['id']) || empty($_GET['id'])){
        $session->message('Complaint id is missing');
        redirect_to("approval.php"); 
    }
    
    $complaint = Complaint::find_by_id($_GET['id']);
    if(! $complaint){
        $session->message('Complaint Not Found');
        redirect_to("approval.php"); 
    }

    //get product id of complaint i.e CR/auto/kanhe
    $product_id = Product::find_product_id($complaint->business_vertical,$complaint->plant_location,$complaint->product);
    if(! $product_id){
        $session->message('Product Not Found');
        redirect_to("approval.php"); 
    }

    //get employee location for that product id
    $employee_reg = EmployeeReg::find_by_id($session->employee_id);

    $emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != 'Employee' AND product_id = {$product_id->id}";

    $employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);

    if(!$employee_location){
      $session->message('Location data Not Found');
      redirect_to("approval.php"); 

      // redirect_to("logout.php?"); 
    }
    $emp_sub_role_appr = '';
    $approver_name = '';

    $valid_roles = ["CRM - Head", "Commercial Head", "Plant Chief - AN", "Sales Head", "CFO", "MD"];
    foreach ($employee_location as $key => $value) {
        if( in_array($value->emp_sub_role, $valid_roles) ){
            $emp_sub_role_appr = $value->emp_sub_role;
            $approver_name = $value->emp_name;
            break;
        }
    }

    if( empty($emp_sub_role_appr)){
      $session->message('Invalid Role');
      redirect_to("approval.php"); 
    }

    // note approval validation according to position
    // #role base validation
    if($emp_sub_role_appr == 'Commercial Head'){

        if(empty($complaint->cna_crm_head)){
            $session->message("The CRM Head have not approved this complaint yet, Please get approval from CRM Head first");
            redirect_to("approval.php");
        }
    
    } elseif($emp_sub_role_appr == 'Plant Chief - AN'){
        if(empty($complaint->cna_commercial_head)){
            $session->message("The Commercial Head have not approved this complaint yet, Please get approval from Commercial Head first");
            redirect_to("approval.php");
        }
    } elseif($emp_sub_role_appr == 'Sales Head'){
    
      if(empty($complaint->cna_plant_chief)){
            $session->message("The Plant Chief have not approved this complaint yet, Please get approval from Plant Chief first");
            redirect_to("approval.php");
        }
    
    }elseif($emp_sub_role_appr == 'CFO'){
        //todo - recheck - cfo or cna_md - there are either one of them
        if(empty($complaint->cna_sales_head)){
            $session->message("The Sales Head have not approved this complaint yet, Please get approval from Sales Head first");
            redirect_to("approval.php");
        }
    }
	}/* else { 
    // redirect_to("logout.php"); 
  }*/


	// $found_appr_note = ApprovalNote::find_by_comp_id($_GET['id']);
		
	$appr_note = ApprovalNote::find_by_id($complaint->approval_note);


	$product_id = Product::find_product_id($complaint->business_vertical,$complaint->plant_location,$complaint->product);

	//print_r($product_id);
  $is_approved_by_all = 0;
	$emp_num = 1;
	$employee_location_emp_id = "";
	$employee_location_emp_name = "";
	$employee_location_emp_email = "";
	
	while($emp_num != 0){
		$sql = "Select * from employee_location where product_id = {$product_id->id} AND role_priority = 'Responsible' order by id ASC Limit 1";
		$employee_location_emp = EmployeeLocation::find_by_sql($sql);

		if($employee_location_emp){
			foreach($employee_location_emp as $employee_location_emp){
				// $employee_location_emp->lead if conditoin is disabled becuase we don't know why it was open & what is lead stands for.
				//if($employee_location_emp->lead == 1){
					$employee_location_emp_id 	= $employee_location_emp->emp_id;
					$employee_location_emp_name 	= $employee_location_emp->emp_name;
					$employee_location_emp_email = $employee_location_emp->emp_email;
					$emp_num = 0;
				//}
			}
		} else {
			if($emp_num >= 5){
				$employee_location_emp_id = "";
				$employee_location_emp_name = "";
				$employee_location_emp_email = "";
			}
			$emp_num++;
		}
	}

  $admin_subject = getComplaintSubjectAdmin($complaint);

	if($product_id){
		$employee_loc = EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"CRM - Head");

		if($employee_loc){
			$cna_crm_head_name = $employee_loc->emp_name;

			if(empty($_POST['customer_name']) || empty($_POST['nature_of_complaint']) || empty($_POST['complait_reference']) || empty($_POST['name_of_sm_sc_t'])
			 	|| empty($_POST['complait_reg_date']) || empty($_POST['responsibility']) || empty($_POST['material_details']) || empty($_POST['billing_doc_no'])
			    || empty($_POST['total_qty_rejc']) || empty($_POST['billing_doc_date']) || empty($_POST['basic_sale_price'])
			 ) {
				// Success
				$session->message("Enter Mandatory Fields");
				redirect_to("approval.php");
			}
			
			if(empty($_POST['qty_acpt_steel_mill']) && empty($_POST['qty_scrp_auc_serv_cent']) && empty($_POST['qty_dlv_customer'])) {
				// Success
				$session->message("Enter any One Quantity (t)");
				redirect_to("approval.php");
			}

			if(empty($_POST['debit_note_sal_rate_sale_value']) || $_POST['debit_note_sal_rate_sale_value'] == 0 ) {
				// Success
				$session->message("Debit note (purchase price/t) / Salvage rate / Sale value is empty");
				redirect_to("approval.php");
			}
			
			$complait_reg_date = $_POST['complait_reg_date']; 
			$complait_reg_date = strtotime($complait_reg_date); 
			$complait_reg_date = date("Y-m-d", $complait_reg_date);

			$billing_doc_date = $_POST['billing_doc_date']; 
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
			

    $toArr = [];
    $ccArr = [];
		
    $bodyContent = '';

			if($appr_note){

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
				$appr_note->total_qty_rejc			= $_POST['total_qty_rejc'];
				$appr_note->billing_doc_date		= $billing_doc_date;
				$appr_note->basic_sale_price_txt	= $_POST['basic_sale_price_txt'];
				$appr_note->basic_sale_price		= $_POST['basic_sale_price'];
				$appr_note->sales_value				= $sales_value; 

				$appr_note->cgst_percent			= $_POST['cgst_percent']; 
				$appr_note->cgst					= $cgst; 
				$appr_note->sgst_percent			= $_POST['sgst_percent'];
				$appr_note->sgst					= $sgst; 

				$appr_note->cost_inc_customer_txt	= $_POST['cost_inc_customer_txt'];
				$appr_note->cost_inc_customer		= $_POST['cost_inc_customer'];
				$appr_note->salvage_value_txt		= $_POST['salvage_value_txt'];
				$appr_note->salvage_value			= $_POST['salvage_value'];
				$appr_note->credit_note_iss_cust	= $credit_note_iss_cust; //$_POST['credit_note_iss_cust'];
				//$appr_note->debit_note_supplier		= $_POST['debit_note_supplier'];
				$appr_note->qty_acpt_steel_mill		= $_POST['qty_acpt_steel_mill'];
				$appr_note->qty_scrp_auc_serv_cent	= $_POST['qty_scrp_auc_serv_cent'];
				$appr_note->qty_dlv_customer		= $_POST['qty_dlv_customer'];
				$appr_note->debit_salvage_sale_txt		= !empty($_POST['debit_salvage_sale_txt']) ? $_POST['debit_salvage_sale_txt'] : "" ;
				$appr_note->debit_note_sal_rate_sale_value		= $_POST['debit_note_sal_rate_sale_value'];
				$appr_note->value					= $value;
				$appr_note->lcgst_percent			= $_POST['lcgst_percent'];
				$appr_note->loss_cgst				= $loss_cgst;
				$appr_note->lsgst_percent			= $_POST['lsgst_percent'];
				$appr_note->loss_sgst				= $loss_sgst; 
				$appr_note->oth_exp_inc_mill		= $oth_exp_inc_mill;
				$appr_note->oth_exp_debited			= $oth_exp_debited; 
				$appr_note->compensation_exp		= $compensation_exp;
				$appr_note->debit_note_iss_supplier	= $debit_note_iss_supplier;
				$appr_note->loss_from_rejection		= $loss_from_rejection;
				$appr_note->recoverable_transporter	= $recoverable_transporter; 
        $appr_note->other_realisation = $other_realisation; 
				$appr_note->net_loss				= $net_loss;
				//$appr_note->remark					= nl2br($_POST['verify_remark']);
				
				$appr_note->other_exp_inc_mill_txt  = $_POST['other_exp_inc_mill_txt'];


        $appr_note->d_purchase_price    = getValue($_POST,'d_purchase_price');
        $appr_note->d_salvage_rate      = getValue($_POST,'d_salvage_rate');
        $appr_note->d_sale_value        = getValue($_POST,'d_sale_value');


				$appr_note->date_					= date("Y-m-d");
				$appr_note->time_					= date("H:i:s");
				
				$appr_note->save();	

				$complaint->cna_crm_head				= "Yes";
				$complaint->cna_crm_head_name			= $cna_crm_head_name;
				$complaint->cna_crm_head_date			= date("Y-m-d");	

			}

			 $employee_loc = EmployeeLocation::find_by_productId_emp_role($product_id->id,"Commercial Head");
			
			 
       $toArr[] = ['email' => $employee_loc->emp_email, 'name' => $employee_loc->emp_name ];
       $ccArr[] = ['email' => $employee_location_emp_email, 'name' => $employee_location_emp_name ];

			 $bodyContent = "
					<p>Dear {$employee_loc->emp_name}, </p>

					<p>Requesting you to approve the Approval Note for complaint ID {$complaint->ticket_no} by clicking on link below</p>		

					<p><strong>Complaint details are</strong><br />
					<strong>Customer Name :</strong> {$complaint->company_name}<br />
					<strong>Nature of Complaint :</strong> {$complaint->business_vertical}, {$complaint->complaint_type}<br />
					<strong>Source :</strong> {$complaint->identify_source}<br />

					{$complaint->emp_name} and team has analysed & resolved the complaint.<br />

					The Approval Note for the same has been created & below is the link <br />

					<a style=' text-decoration:none; color:#1774b5' href='".BASE_URL."administrator/approver/approval.php'>".BASE_URL."administrator/approver/approval.php</a>
					
					</p>";

		} else {
			$employee_location = EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"Commercial Head");

			if($employee_location){
				$cna_commercial_head = $employee_location->emp_name;

				$employee_loc = EmployeeLocation::find_by_productId_emp_role($product_id->id,"Plant Chief - AN");
				

				$toArr[] = ['email' => $employee_loc->emp_email, 'name' => $employee_loc->emp_name ];
				$ccArr[] = ['email' => $employee_location_emp_email, 'name' => $employee_location_emp_name ];

				$bodyContent = "<p>Dear {$employee_loc->emp_name}, </p>

					<p>Requesting you to approve the Approval Note for complaint ID {$complaint->ticket_no} by clicking on link below</p>		

					<p><strong>Complaint details are</strong><br />
					<strong>Customer Name :</strong> {$complaint->company_name}<br />
					<strong>Nature of Complaint :</strong> {$complaint->business_vertical}, {$complaint->complaint_type}<br />
					<strong>Source :</strong> {$complaint->identify_source}<br />

					{$complaint->emp_name} and team has analysed & resolved the complaint.<br />

					The Approval Note for the same has been created & below is the link <br />

					<a style=' text-decoration:none; color:#1774b5' href='".BASE_URL."administrator/approver/approval.php'>".BASE_URL."administrator/approver/approval.php</a>
					
					</p> ";

				$complaint->cna_commercial_head				= "Yes";
				$complaint->cna_commercial_head_name		= $cna_commercial_head;
				$complaint->cna_commercial_head_date		= date("Y-m-d");
				
			} else {
				$employee_location 	= EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"Plant Chief - AN");

				if($employee_location){
					$cna_plant_chief 	= $employee_location->emp_name;

					$employee_loc = EmployeeLocation::find_by_productId_emp_role($product_id->id,"Sales Head");
					

					$toArr[] = ['email' => $employee_loc->emp_email, 'name' => $employee_loc->emp_name ];   
					$ccArr[] = ['email' => $employee_location_emp_email, 'name' => $employee_location_emp_name ];   


					$bodyContent = "
              <p>Dear {$employee_loc->emp_name}, </p>

							<p>Requesting you to approve the Approval Note for complaint ID {$complaint->ticket_no} by clicking on link below</p>		

							<p><strong>Complaint details are</strong><br />
							<strong>Customer Name :</strong> {$complaint->company_name}<br />
							<strong>Nature of Complaint :</strong> {$complaint->business_vertical}, {$complaint->complaint_type}<br />
							<strong>Source :</strong> {$complaint->identify_source}<br />

							{$complaint->emp_name} and team has analysed & resolved the complaint.<br />

							The Approval Note for the same has been created & below is the link <br />

							<a style=' text-decoration:none; color:#1774b5' href='".BASE_URL."administrator/approver/approval.php'>".BASE_URL."administrator/approver/approval.php</a>
							
							</p> ";

					$complaint->cna_plant_chief					= "Yes";
					$complaint->cna_plant_chief_name			= $cna_plant_chief;
					$complaint->cna_plant_chief_date			= date("Y-m-d");

				} else {
					$employee_location 	= EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"Sales Head");

					if($employee_location){
						$cna_sales_head 	= $employee_location->emp_name;

						$employee_loc = EmployeeLocation::find_by_productId_emp_role($product_id->id,"CFO");
						

						$toArr[] = ['email' => $employee_loc->emp_email, 'name' => $employee_loc->emp_name ];   
						$ccArr[] = ['email' => $employee_location_emp_email, 'name' => $employee_location_emp_name ];   

						$bodyContent = "
								<p>Dear {$employee_loc->emp_name}, </p>

								<p>Requesting you to approve the Approval Note for complaint ID {$complaint->ticket_no} by clicking on link below</p>		

								<p><strong>Complaint details are</strong><br />
								<strong>Customer Name :</strong> {$complaint->company_name}<br />
								<strong>Nature of Complaint :</strong> {$complaint->business_vertical}, {$complaint->complaint_type}<br />
								<strong>Source :</strong> {$complaint->identify_source}<br />

								{$complaint->emp_name} and team has analysed & resolved the complaint.<br />

								The Approval Note for the same has been created & below is the link <br />

								<a style=' text-decoration:none; color:#1774b5' href='".BASE_URL."administrator/approver/approval.php'>".BASE_URL."administrator/approver/approval.php</a>
								
								</p> ";

						$complaint->cna_sales_head					= "Yes";
						$complaint->cna_sales_head_name				= $cna_sales_head;
						$complaint->cna_sales_head_date				= date("Y-m-d");

					} else {
						$employee_location 	= EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"CFO");

						if($employee_location){
							$cna_cfo 			= $employee_location->emp_name;

							$employee_loc = EmployeeLocation::find_by_productId_emp_role($product_id->id,"MD");
							

							$toArr[] = ['email' => $employee_loc->emp_email, 'name' => $employee_loc->emp_name ];   
							$ccArr[] = ['email' => $employee_location_emp_email, 'name' => $employee_location_emp_name ];   

							$bodyContent = "
									<p>Dear {$employee_loc->emp_name}, </p>

									<p>The team has analysed & processed the complaint registered under Complaint ID- {$complaint->ticket_no}</p>		

									<p><strong>Complaint Detail</strong><br />
									<strong>Customer Name :</strong> {$complaint->company_name}<br />
									<strong>Nature of Complaint :</strong> {$complaint->business_vertical}, {$complaint->complaint_type}<br />
									<strong>Source :</strong> {$complaint->identify_source}<br />
									<strong>Action to be taken :</strong> {$complaint->other_advice}<br />

									{$complaint->emp_name} and team has prepared the Approval Note for the above Complaint <br />

									Requesting you to approve the same. <br />
									Below is the link : <br />
									<a style=' text-decoration:none; color:#1774b5' href='".BASE_URL."administrator/approver/approval.php'>".BASE_URL."administrator/approver/approval.php</a>
									
									</p>";

							if(isset($_POST['cna_md_status'])){
								$complaint->cna_md_status			= "Yes";
							} else {
								$complaint->cna_md_status			= "No";
								$complaint->emp_status				= "All Approved";

								$is_approved_by_all = 1;
							}
							
							$complaint->cna_cfo						= "Yes";
							$complaint->cna_cfo_name				= $cna_cfo;
							$complaint->cna_cfo_date				= date("Y-m-d");
							//$complaint->status					= "Closed";

						} else {
							$employee_location 	= EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,$session->employee_id,"MD");
							$cna_md 		= $employee_location->emp_name;

							if(!$employee_location){								
								$session->message('Approver Not Found');
								redirect_to("approval.php"); 
							}

							$complaint->cna_md						= "Yes";
							$complaint->cna_md_name					= $cna_md;
							$complaint->cna_md_date					= date("Y-m-d");
							$complaint->emp_status					= "All Approved";
							
							$is_approved_by_all = 1;

							//$complaint->status					= "Closed";
						} 
						
					} 
					
				} 

				
			} 
			
		} 
	} else {
		$session->message('Product Not Found');
		redirect_to("approval.php"); 
	}

	
	//$employee_loc = EmployeeLocation::find_by_productId_emp_id_emp_role($product_id->id,"Commercial Head");

	//print_r($employee_loc);
	//return false;

	//$complaint->identify_source				= $_POST['id_source'];
	
	//$employee_loc = EmployeeLocation::find_by_emp_id($session->employee_id);
	
    /*	if($employee_loc->emp_sub_role == "CRM - Head"){		 
					
	} else if($employee_loc->emp_sub_role == "Commercial Head"){
		
	} else if($employee_loc->emp_sub_role == "Plant Chief - AN"){
		
	} else if($employee_loc->emp_sub_role == "Sales Head"){
		

	} else if($employee_loc->emp_sub_role == "CFO"){
		
		
	} else if($employee_loc->emp_sub_role == "MD"){
		
	} else {
		$session->message("Approver Not Found   2");
		redirect_to("approval.php");
	}*/


	if($complaint->save()) {
		// Success
    //it is now stored in new table
		/*if(isset($_POST['approver_remark'])){
			$approval_note = ApprovalNote::find_by_comp_id($_GET['id']);
			$approval_note->approver_remark = nl2br($_POST['approver_remark']);
			$approval_note->save();
		}*/

    //store approver remark
    if( getValue($_POST,'approver_remark') ){
        $remark = new ApprovalRemark();
        $remark->complaint_id = $complaint->id;
        $remark->approval_note_id = $complaint->approval_note;
        $remark->emp_id = $session->employee_id;
        $remark->emp_name = $approver_name;
        $remark->sub_role = $emp_sub_role_appr;
        $remark->remark = getValue($_POST,'approver_remark');
        $remark->created_at = date("Y-m-d H:i:s");
        if(! $remark->save()) {
            $session->message('Approver remark could not be saved.');
        }
    }

		if($employee_location->emp_sub_role == "CFO"){
			if( isset($_POST['cna_md_status']) ){
				 sendComplaintMail($complaint, $admin_subject, $bodyContent, $toArr , $ccArr);
			} 		
		} else if($employee_location->emp_sub_role != "CFO"){
			if($employee_location->emp_sub_role != "MD"){
				sendComplaintMail($complaint, $admin_subject, $bodyContent, $toArr , $ccArr);
			}
		}

		if($is_approved_by_all == 1){

  			$subject = "{$complaint->business_vertical} | {$complaint->plant_location} | Complaint ID # {$complaint->ticket_no} | {$complaint->company_name} | {$complaint->complaint_type} has been approved by all concerned authorities.";
			  $body = "<p>Complaint ID #'.$complaint->ticket_no.' has been approved by all concerned authorities. </p>
			  <p><strong>Complaint detail are</strong><br />
			  <strong>Customer Name :</strong> {$complaint->company_name}<br />
			  <strong>Nature of Complaint :</strong> {$complaint->business_vertical}, {$complaint->complaint_type}<br />
			  <strong>Location :</strong> {$complaint->plant_location}<br />
			  <strong>Source :</strong> {$complaint->identify_source}<br />

			  Thank You!<br /><br />

			  Warm Regards, <br />
			  CRM Team <br />
			  </p>";

        $toArr = getLocationChampsDetails($product_id->id);
        // $ccArr = getLocationEmployeeByRole($product_id->id, "Commercial Head");
  				
  			sendComplaintMail($complaint, $subject, $body, $toArr );
		}
		   
		// $session->message("Approval Note Approved");
		// redirect_to("approval.php");

		?>

		<!-- Success Alert Modal -->
		<div id="success-alert-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content modal-filled bg-success">
					<div class="modal-body p-4">
						<div class="text-center">
							<i class="dripicons-checkmark h1"></i>
							<h2 class="mt-2">Success</h2>
							<p class="mt-3" style="font-size:18px;">
								You have successfully approved Approval Note.
							</p>
							<a href="approval.php" class="btn btn-light my-2">Continue</a>
						</div>
					</div>
				</div><!-- /.modal-content -->
			</div> <!-- /.modal-dialog -->
		</div><!-- /.modal -->
	
	<?php
	} else {
		// Failure
		$session->message("Fail to Approve Approval Note");
		redirect_to("approval.php");
	}





?>


