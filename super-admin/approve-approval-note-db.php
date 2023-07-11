<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	require '../PHPMailer/PHPMailerAutoload.php';
	//date_default_timezone_set('Asia/Calcutta');

  // dd($_POST);
	/*
	foreach ($_POST as $key => $value) {
		if (preg_match('/[\"\^*}!{><;`=]/', $value)){
			$session->message("Remove Special Character"); redirect_to("approval.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\"\^*}!{><;`=]/', $value)){
			$session->message("Remove Special Character"); redirect_to("approval.php");
		}
	}
	*/

  	foreach ($_POST as $key => $value) {
  		//echo htmlspecialchars($key)." = ".htmlspecialchars($value)."<br>";
  	}


	 if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }



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
  		$session->message("Debit note (purchase price/t) / Salvage rate / Sale value");
  		redirect_to("approval.php");
  	}
			
			$complait_reg_date = $_POST['complait_reg_date']; 
			$complait_reg_date = strtotime($complait_reg_date); 
			$complait_reg_date = date("Y-m-d", $complait_reg_date);

			$billing_doc_date = $_POST['billing_doc_date']; 
			$billing_doc_date = strtotime($billing_doc_date); 
			$billing_doc_date = date("Y-m-d", $billing_doc_date);
			
      
      $complaint = Complaint::find_by_id($_GET['id']);
      if(! $complaint){
          $session->message('Complaint Not Found');
          redirect_to("approval.php"); 
      }
			
      $found_appr_note = ApprovalNote::find_by_comp_id($_GET['id']);

			if($found_appr_note){
				$appr_note = ApprovalNote::find_by_id($found_appr_note->id);

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
				$appr_note->sales_value				= $_POST['sales_value'];
				$appr_note->cgst					= $_POST['cgst'];
				$appr_note->sgst					= $_POST['sgst'];
        $appr_note->cgst_percent      = $_POST['cgst_percent']; 
        $appr_note->sgst_percent      = $_POST['sgst_percent'];

				$appr_note->cost_inc_customer_txt	= $_POST['cost_inc_customer_txt'];
				$appr_note->cost_inc_customer		= $_POST['cost_inc_customer'];
				$appr_note->salvage_value_txt		= $_POST['salvage_value_txt'];
				$appr_note->salvage_value			= $_POST['salvage_value'];
				$appr_note->credit_note_iss_cust	= $_POST['credit_note_iss_cust'];
				//$appr_note->debit_note_supplier		= $_POST['debit_note_supplier'];
				$appr_note->qty_acpt_steel_mill		= $_POST['qty_acpt_steel_mill'];
				$appr_note->qty_scrp_auc_serv_cent	= $_POST['qty_scrp_auc_serv_cent'];
				$appr_note->qty_dlv_customer		= $_POST['qty_dlv_customer'];
				$appr_note->debit_salvage_sale_txt		= !empty($_POST['debit_salvage_sale_txt']) ? $_POST['debit_salvage_sale_txt'] : "" ;
				$appr_note->debit_note_sal_rate_sale_value		= $_POST['debit_note_sal_rate_sale_value'];
				$appr_note->value					= $_POST['value'];
				$appr_note->loss_cgst				= $_POST['loss_cgst'];
				$appr_note->loss_sgst				= $_POST['loss_sgst'];
        $appr_note->lcgst_percent   = $_POST['lcgst_percent'];
        $appr_note->lsgst_percent   = $_POST['lsgst_percent'];

				$appr_note->oth_exp_inc_mill		= $_POST['oth_exp_inc_mill'];
				$appr_note->oth_exp_debited			= $_POST['oth_exp_debited'];
				$appr_note->compensation_exp		= $_POST['compensation_exp'];
				$appr_note->debit_note_iss_supplier	= $_POST['debit_note_iss_supplier'];
				// $appr_note->loss_from_rejection		= $_POST['loss_from_rejection'];
				// $appr_note->recoverable_transporter	= $_POST['recoverable_transporter'];
				// $appr_note->net_loss				= $_POST['net_loss'];
				//$appr_note->remark					= nl2br($_POST['verify_remark']);
				  
        $loss_from_rejection  = $_POST["loss_from_rejection"];
        $recoverable_transporter  = $_POST["recoverable_transporter"];
        $other_realisation  = $_POST["other_realisation"];
        $net_loss         = $loss_from_rejection - $recoverable_transporter - $other_realisation;
        $net_loss         = round($net_loss, 2);

        $appr_note->loss_from_rejection   = $loss_from_rejection;
        $appr_note->recoverable_transporter = $recoverable_transporter; 
        $appr_note->other_realisation = $other_realisation; 
        $appr_note->net_loss        = $net_loss;


        $appr_note->other_exp_inc_mill_txt  = $_POST['other_exp_inc_mill_txt'];

        $appr_note->d_purchase_price    = getValue($_POST,'d_purchase_price');
        $appr_note->d_salvage_rate      = getValue($_POST,'d_salvage_rate');
        $appr_note->d_sale_value        = getValue($_POST,'d_sale_value');

				$appr_note->date_					= date("Y-m-d");
				$appr_note->time_					= date("H:i:s");
				
        if($appr_note->save()) {
            $session->message("Approval note updated successfully.");
            redirect_to("approval.php");
        }else{
            $session->message("Fail to save data");
            redirect_to("approval.php");
        }
	
	} else {
		$session->message('Product Not Found');
		redirect_to("approval.php"); 
	}

	
?>


