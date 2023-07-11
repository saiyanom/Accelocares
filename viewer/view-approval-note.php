<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Employee CVC"); redirect_to("approval.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Employee CVC"); redirect_to("approval.php");
		}
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Document.");
			redirect_to("approval.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Document.");
			redirect_to("approval.php");
		}
	} else {
		$session->message("Complaint Not Found");
		redirect_to("all-complaints.php");
	}

	$employee_reg = EmployeeReg::find_by_id($session->employee_id);
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	if ($session->is_employee_logged_in()){ 
		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role = 'Viewer' Limit 1";
		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
		if(!$employee_location){
			redirect_to("logout.php"); 
		}
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$complaint_reg = Complaint::find_by_id($_GET['id']);
		$approval_note = ApprovalNote::find_by_id($_GET['id']);
	} else {
		$session->message("Complaint Not Found");
		redirect_to("all-complaints.php");
	}
	
	$employee_loc = EmployeeLocation::find_by_emp_id($session->employee_id);
	if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "CRM - Head"){
		$readonly = "";
		$disabled = "";
	} else { $readonly = "readonly"; $disabled = "disabled";}
?>



<style>
	.form-p-box-bg3:disabled, .form-control[readonly] {
		background-color: #7c7c7c;
		opacity: 1;
		color: #fff;
	}
	.form-control:disabled, .form-control[readonly] {
	    background-color: #e9ecef;
	    opacity: 1;
	    color: #666;
	}
	.debit_inputs div{
      width: 200px;
      display: inline-block;
    }
</style>
<div class="modal-header border-bottom-st d-block">
<!--<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<div class="form-p-hd">
<h2>MAHINDRA ACCELO LTD. / MASL / MSSCL<br>
Credit Note / Debit Note Approval</h2>
</div>


<div class="form-p-block" id="create-note">
<!-- box 1 -->
<div class="form-p-box form-p-box-bg2">

<div class="rst-left">
	<ul class="fpall">
		<li class="fp-con1"><p>Name of the customer</p></li>             
		<li class="fp-con2"><input readonly type="text" value="<?php echo $approval_note->customer_name; ?>" id="customer_name" name="customer_name" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Complaint reference no</p></li>             
		<li class="fp-con2"><input readonly type="text" value="<?php echo $approval_note->complait_reference; ?>" id="complait_reference" name="complait_reference" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Complant Registration date</p></li>             
		<li class="fp-con2">
			<input readonly value="<?php echo date('d/m/Y', strtotime($approval_note->complait_reg_date)); ?>"  class="form-control" id="complait_reg_date" type="text"  name="complait_reg_date">
		</li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Material Details  (grade, size etc)</p></li>             
		<li class="fp-con2"><input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->material_details; ?>" id="material_details" name="material_details" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>
</div>

<div class="rst-right">
	<ul class="fpall">
		<li class="fp-con1"><p>Nature of the complaint</p></li>             
		<li class="fp-con2"><input readonly type="text" value="<?php echo $approval_note->nature_of_complaint; ?>" id="nature_of_complaint" name="nature_of_complaint" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Name of the Steel Mill / Service centre/ Transporter</p></li>             
		<li class="fp-con2"><input readonly type="text" value="<?php echo $approval_note->name_of_sm_sc_t; ?>" id="name_of_sm_sc_t" name="name_of_sm_sc_t" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Responsibility</p></li>             
		<li class="fp-con2"><input readonly type="text" value="<?php echo $approval_note->responsibility; ?>" id="responsibility" name="responsibility" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>
</div>

<div class="clerfix"></div>
</div>
<!-- box 1 -->

<!-- box 2 -->
<div class="form-p-box form-p-box-bg1 border-bottom-st">
	<h2 class="sectphd">Credit note to be issued to customer</h2>
	<div class="rst-left">
	<ul class="fpall">
		<li class="fp-con1"><p>Billing Document No.</p></li>   
		<li class="fp-con2"><input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->billing_doc_no; ?>" id="billing_doc_no" name="billing_doc_no" class="form-control form-p-box-bg2"></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Billing Document Date</p></li>             
		<li class="fp-con2">
			<input readonly id="billing_doc_date" value="<?php echo date('d/m/Y', strtotime($approval_note->billing_doc_date)); ?>" type="text" name="billing_doc_date" readonly class="form-control fodhf date-picker">
		</li>
		<div class="clerfix"></div>
	</ul>
</div>

<div class="rst-right">
	<ul class="fpall">
		<li class="fp-con1"><p>Total Qty Rejected by the Customer</p></li>             
		<li class="fp-con2">
			<div class="row">	
				<div class="col col-sm-4">
					<select <?php echo $disabled; ?> id="total_qty_rejc_type" name="total_qty_rejc_type" class="form-control">
						<option <?php if (strpos($approval_note->total_qty_rejc, 'MT') !== false) {echo "Selected";}?>>MT</option>
						<option <?php if (strpos($approval_note->total_qty_rejc, 'KG') !== false) {echo "Selected";}?>>KG</option>
						<option <?php if (strpos($approval_note->total_qty_rejc, 'Each') !== false) {echo "Selected";}?>>Each</option>
					</select>
				</div>
				<div class="col col-sm-8">
					<?php
						if (strpos($approval_note->total_qty_rejc, 'MT') !== false) {
							$total_qty_rejc = str_replace("MT","",$approval_note->total_qty_rejc);
						} else if (strpos($approval_note->total_qty_rejc, 'KG') !== false) {
							$total_qty_rejc = str_replace("KG","",$approval_note->total_qty_rejc);
						} else if (strpos($approval_note->total_qty_rejc, 'Each') !== false) {
							$total_qty_rejc = str_replace("Each","",$approval_note->total_qty_rejc);
						} else {
							$total_qty_rejc = $approval_note->total_qty_rejc;
						}
					?>
					<input type="text" <?php echo $readonly; ?> id="total_qty_rejc" name="total_qty_rejc" value="<?php echo $total_qty_rejc; ?>"  class="form-control form-p-box-bg2">
				</div>
			</div>
		</li>

		<div class="clerfix"></div>
	</ul>
</div>

<div class="clerfix"></div>
</div>
<!-- box 2 -->

<!-- box 3 -->
<div class="form-p-box form-p-box-bg1">

<div class="rst-full">
	<ul class="fpall">
		<li class="fp-con01">
			<p style="float: left; margin-right: 10px;" >Basic sale price</p>
			<?php if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "CRM - Head"){ ?>
			<input style="width: 300px; float: left;" type="text" <?php echo $readonly; ?> class="form-control" name="basic_sale_price_txt" value="<?php echo $approval_note->basic_sale_price_txt; ?>">
			<?php } else { echo $approval_note->basic_sale_price_txt; } ?>
		</li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->basic_sale_price; ?>" id="basic_sale_price" name="basic_sale_price" class="form-control form-p-box-bg2 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Sales Value (Basic sale price/t X Qty)</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->sales_value; ?>" id="sales_value" name="sales_value" class="form-control form-p-box-bg2 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01">
			<div class="input-group" style="width: 250px">
				<div class="input-group-append">
					<span class="input-group-text">IGST / CGST @</span>
				</div>
				<input type="text" <?php echo $readonly; ?> class="form-control cgst" value="<?php echo 100 * $approval_note->cgst / $approval_note->sales_value ; ?>">
				<div class="input-group-append">
					<span class="input-group-text">%</span>
				</div>
			</div>
		</li>
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" readonly id="cgst" name="cgst" value="<?php echo $approval_note->cgst; ?>" class="form-control form-p-box-bg2 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01">
			<div class="input-group" style="width: 250px">
				<div class="input-group-append">
					<span class="input-group-text">SGST @</span>
				</div>
				<input type="text" <?php echo $readonly; ?> class="form-control sgst app_note_number" value="<?php echo 100 * $approval_note->cgst / $approval_note->sales_value ; ?>">
				<div class="input-group-append">
					<span class="input-group-text">%</span>
				</div>
			</div>
		</li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>
		<input type="text" readonly id="sgst" value="<?php echo $approval_note->sgst; ?>" name="sgst" class="form-control form-p-box-bg2 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01">
			<p style="float: left; margin-right: 10px;" >Cost incurred by the customer</p>
			<?php if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "CRM - Head"){ ?>
			<input style="width: 300px; float: left;" type="text" <?php echo $readonly; ?> class="form-control" name="cost_inc_customer_txt" value="<?php echo $approval_note->cost_inc_customer_txt; ?>">
			<?php } else { echo $approval_note->cost_inc_customer_txt; } ?>
		</li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->cost_inc_customer; ?>" id="cost_inc_customer" name="cost_inc_customer" class="form-control form-p-box-bg2 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01">
			<p style="float: left; margin-right: 10px;" >Salvage Rate</p>
			<?php if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "CRM - Head"){ ?>
			<input style="width: 300px; float: left;" type="text" <?php echo $readonly; ?> class="form-control" name="salvage_value_txt" value="<?php echo $approval_note->salvage_value_txt; ?>">
			<?php } else { echo $approval_note->salvage_value_txt; } ?>
		</li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->salvage_value; ?>" id="salvage_value" name="salvage_value" class="form-control form-p-box-bg2 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p class="colrred_black">Credit note to be issued to the customer (total of abv net of scrap value)</p></li> 
		<li class="fp-con02"><span class="padd10 colrred_black">Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->credit_note_iss_cust; ?>" id="credit_note_iss_cust" name="credit_note_iss_cust" class="form-control form-p-box-bg3 sphf"></li>
		<div class="clerfix"></div>
	</ul>
</div>

<div class="clerfix"></div>
</div>
<!-- box 3 -->

<!-- box 4 -->
<div class="form-p-box form-p-box-bg2">

<div class="rst-full border-bottom-st">
	<h2 class="sectphd">Debit Note Issued to Supplier / Realisation from Scrap / To be Recovered from Insurance Co.</h2>

	<ul class="fpall">
		<li class="fp-con01"><p>Quantity (t) as accepted by steel mill    </p></li> 
		<li class="fp-con02">
			<?php
				if (strpos($approval_note->qty_acpt_steel_mill, 'MT') !== false) {
					$qty_acpt_steel_mill = str_replace("MT","",$approval_note->qty_acpt_steel_mill);
				} else if (strpos($approval_note->qty_acpt_steel_mill, 'KG') !== false) {
					$qty_acpt_steel_mill = str_replace("KG","",$approval_note->qty_acpt_steel_mill);
				} else if (strpos($approval_note->qty_acpt_steel_mill, 'Each') !== false) {
					$qty_acpt_steel_mill = str_replace("Each","",$approval_note->qty_acpt_steel_mill);
				} else {
					$qty_acpt_steel_mill = $approval_note->qty_acpt_steel_mill;
				}
			?>
			<input <?php echo $readonly; ?> style="width: 50%; margin: 0 3% 0 0; float: right;" type="text" id="qty_acpt_steel_mill" name="qty_acpt_steel_mill" value="<?php echo $qty_acpt_steel_mill; ?>" class="form-control form-p-box-bg1 sphf app_note_number">
			<select <?php echo $disabled; ?> style="width: 30%; margin: 0 3% 0 0; float: right;" name="qty_acpt_steel_mill_type" class="form-control">
				<option <?php if (strpos($approval_note->qty_acpt_steel_mill, 'MT') !== false) {echo "Selected";}?>>MT</option>
				<option <?php if (strpos($approval_note->qty_acpt_steel_mill, 'KG') !== false) {echo "Selected";}?>>KG</option>
				<option <?php if (strpos($approval_note->qty_acpt_steel_mill, 'Each') !== false) {echo "Selected";}?>>Each</option>
			</select>
		</li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Quantity (t) to be scrapped / auction at service centres </p></li> 
		<li class="fp-con02">
			<?php
				if (strpos($approval_note->qty_scrp_auc_serv_cent, 'MT') !== false) {
					$qty_scrp_auc_serv_cent = str_replace("MT","",$approval_note->qty_scrp_auc_serv_cent);
				} else if (strpos($approval_note->qty_scrp_auc_serv_cent, 'KG') !== false) {
					$qty_scrp_auc_serv_cent = str_replace("KG","",$approval_note->qty_scrp_auc_serv_cent);
				} else if (strpos($approval_note->qty_scrp_auc_serv_cent, 'Each') !== false) {
					$qty_scrp_auc_serv_cent = str_replace("Each","",$approval_note->qty_scrp_auc_serv_cent);
				} else {
					$qty_scrp_auc_serv_cent = $approval_note->qty_scrp_auc_serv_cent;
				}
			?>
			<input <?php echo $readonly; ?> style="width: 50%; margin: 0 3% 0 0; float: right;" type="text" id="qty_scrp_auc_serv_cent" name="qty_scrp_auc_serv_cent" value="<?php echo $qty_scrp_auc_serv_cent; ?>" class="form-control form-p-box-bg1 sphf app_note_number">
			<select <?php echo $disabled; ?> style="width: 30%; margin: 0 3% 0 0; float: right;" name="qty_scrp_auc_serv_cent_type" class="form-control">
				<option <?php if (strpos($approval_note->qty_scrp_auc_serv_cent, 'MT') !== false) {echo "Selected";}?>>MT</option>
				<option <?php if (strpos($approval_note->qty_scrp_auc_serv_cent, 'KG') !== false) {echo "Selected";}?>>KG</option>
				<option <?php if (strpos($approval_note->qty_scrp_auc_serv_cent, 'Each') !== false) {echo "Selected";}?>>Each</option>
			</select>
		</li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Quantity (t) to be diverted to any other customer</p></li> 
		<li class="fp-con02">
			<?php
				if (strpos($approval_note->qty_dlv_customer, 'MT') !== false) {
					$qty_dlv_customer = str_replace("MT","",$approval_note->qty_dlv_customer);
				} else if (strpos($approval_note->qty_dlv_customer, 'KG') !== false) {
					$qty_dlv_customer = str_replace("KG","",$approval_note->qty_dlv_customer);
				} else if (strpos($approval_note->qty_dlv_customer, 'Each') !== false) {
					$qty_dlv_customer = str_replace("Each","",$approval_note->qty_dlv_customer);
				} else {
					$qty_dlv_customer = $approval_note->qty_dlv_customer;
				}
			?>
			<input <?php echo $readonly; ?> style="width: 50%;  margin: 0 3% 0 0;float: right;" type="text" id="qty_dlv_customer" name="qty_dlv_customer" value="<?php echo $qty_dlv_customer; ?>" class="form-control form-p-box-bg1 sphf app_note_number">
			<select <?php echo $disabled; ?> style="width: 30%; margin: 0 3% 0 0; float: right;" name="qty_dlv_customer_type" class="form-control">
				<option <?php if (strpos($approval_note->qty_dlv_customer, 'MT') !== false) {echo "Selected";}?>>MT</option>
				<option <?php if (strpos($approval_note->qty_dlv_customer, 'KG') !== false) {echo "Selected";}?>>KG</option>
				<option <?php if (strpos($approval_note->qty_dlv_customer, 'Each') !== false) {echo "Selected";}?>>Each</option>
			</select>
		</li>			
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Debit note (purchase price/t) / Salvage rate / Sale value <input readonly type="text" value="<?php echo $approval_note->debit_salvage_sale_txt; ?>" class="form-control form-p-box-bg2 sphf"></p></li> 

		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->debit_note_sal_rate_sale_value; ?>" id="debit_note_sal_rate_sale_value" name="debit_note_sal_rate_sale_value" class="form-control form-p-box-bg2 sphf"></li>
		<div class="clerfix"></div>
	</ul>

  <ul class="fpall debit_inputs">
    <li class="fp-con01">

      <div>
        Purchase price/t <br>
        <input type="text" name="d_purchase_price" placeholder="Purchase price/t" style="width: 200px; float: left;" class="form-control optional_field mr-2" value="<?php echo $approval_note->d_purchase_price; ?>" readonly>
      </div>
      <div>
        Salvage rate <br>
        <input type="text" class="form-control optional_field  mr-2" name="d_salvage_rate" placeholder="Salvage rate" style="width: 200px; float: left;" value="<?php echo $approval_note->d_salvage_rate; ?>" readonly>
      </div>

      <div>
         Sale value <br>
        <input type="text" class="form-control optional_field mr-2" name="d_sale_value" placeholder="Sale value" style="width: 200px; float: left;" value="<?php echo $approval_note->d_sale_value; ?>" readonly>
      </div>
    </li>
    <div class="clerfix"></div>
  </ul>

	<ul class="fpall">
		<li class="fp-con01"><p>Value (purchase price/t  X qty)</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->value; ?>" id="value" name="value" class="form-control form-p-box-bg1 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01">
			<div class="input-group" style="width: 250px">
				<div class="input-group-append">
					<span class="input-group-text">IGST / CGST @</span>
				</div>
				<input <?php echo $readonly; ?> type="text" class="form-control loss_cgst" value="<?php echo 100 * $approval_note->loss_cgst / $approval_note->value ; ?>">
				<div class="input-group-append">
					<span class="input-group-text">%</span>
				</div>
			</div>
		</li>
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" readonly id="loss_cgst" name="loss_cgst" value="<?php echo $approval_note->loss_cgst; ?>" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01">
			<div class="input-group" style="width: 250px">
				<div class="input-group-append">
					<span class="input-group-text">SGST @</span>
				</div>
				<input <?php echo $readonly; ?> type="text" class="form-control loss_sgst" value="<?php echo 100 * $approval_note->loss_sgst / $approval_note->value ; ?>">
				<div class="input-group-append">
					<span class="input-group-text">%</span>
				</div>
			</div>
		</li>
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" readonly id="loss_sgst" name="loss_sgst" value="<?php echo $approval_note->loss_cgst; ?>" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Other expenses incurred by MIL<input style="width: 300px;" readonly type="text" value="<?php echo $approval_note->other_exp_inc_mill_txt; ?>" class="form-control form-p-box-bg2 sphf">  </p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->oth_exp_inc_mill; ?>" id="oth_exp_inc_mill" name="oth_exp_inc_mill" class="form-control form-p-box-bg1 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Other expenses to be debited (eg freight) / credited (eg scrap @ 20000 recovery) to steel mill</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->oth_exp_debited; ?>" id="oth_exp_debited" name="oth_exp_debited" class="form-control form-p-box-bg1 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Compensation expected from Insurance Co.</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->compensation_exp; ?>" id="compensation_exp" name="compensation_exp" class="form-control form-p-box-bg1 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p class="colrred_black">Debit note issued to supplier / Billing back to customer / Realisation from scrap</p></li> 
		<li class="fp-con02"><span class="padd10 colrred_black">Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->debit_note_iss_supplier; ?>" id="debit_note_iss_supplier" name="debit_note_iss_supplier" class="form-control form-p-box-bg3 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p class="colrred_black">Loss from the Rejection </p></li> 
		<li class="fp-con02"><span class="padd10 colrred_black">Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->loss_from_rejection; ?>" id="loss_from_rejection" name="loss_from_rejection" class="form-control form-p-box-bg3 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Recoverable from Transporter (if applicable)</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->recoverable_transporter; ?>" id="recoverable_transporter" name="recoverable_transporter" class="form-control form-p-box-bg1 sphf"></li>
		<div class="clerfix"></div>
	</ul>

   <ul class="fpall">
    <li class="fp-con01"><p>Other Realisation (if applicable) </p></li> 
    <li class="fp-con02"><span class="padd10">Rs.</span>  
    <input readonly type="text" value="<?php echo $approval_note->other_realisation; ?>" name="other_realisation" class="form-control form-p-box-bg1 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>

	<ul class="fpall">
		<li class="fp-con01"><p class="colrred_black">Net Loss / (-) Net Profit </p></li> 
		<li class="fp-con02"><span class="padd10 colrred_black">Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->net_loss; ?>" id="net_loss" name="net_loss" class="form-control form-p-box-bg3 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	
</div>
<?php
	$employee_loc = EmployeeLocation::find_by_emp_id($session->employee_id);
	if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "CFO"){
		$comp_sql = "Select * from complaint where approval_note != ''";
?>
<div class="rst-full">
	<ul class="fpall">
		<div class="custom-control custom-checkbox arsalin">
			<input name="cna_md_status" type="checkbox" class="custom-control-input" id="cna_crm_head">
			<label class="custom-control-label" for="cna_crm_head">Send Document to MD for Approval</label>
		</div>
	</ul>
</div>	
<?php }?>	

<div class="rst-full">
	<ul class="fpall">
		<p class="colrred_black"><strong>Employee Remark</strong></p>
		<?php echo $approval_note->remark; ?>
	</ul>
	<ul class="fpall"<?php if(empty($approval_note->approver_remark)){echo "style='display:none;'";}?>>
		<hr /><p class="colrred_black"><strong>Approver Remark</strong></p>
		<?php echo $approval_note->approver_remark; ?>
	</ul>
	<ul class="fpall" <?php if($employee_loc->emp_sub_role != "CRM - Head"){echo "style='display:none;'";}?>>
		<textarea class="form-control mrig10 form-p-box-bg1" id="approver_remark" name="approver_remark" placeholder="Approver Remarks" rows="3"><?php echo $approval_note->approver_remark; ?></textarea>
	</ul>
</div>
<div class="pfot-cont">
	<p>
		Note<br/>
		a) Credit Note will be issued by the respective plants in case of material return from the customer.<br/>
		b)  For processing related rejections, complaint will be closed after issue of CAPA / CN<br/>
	</p>
</div>

	<div class="clerfix"></div>
</div>
<!-- box 4 -->

<div class="form-p-box form-p-boxbtn">
	<button type="button" class="fpcl" data-dismiss="modal">Close</button>
</div>

<div class="clerfix"></div>
</div>


</div>

<script>
	
	var readonly = '<?php echo $readonly; ?>';
	
	if(readonly == ''){
		$('.date-picker').daterangepicker({
			singleDatePicker: true,
			locale: {
			  format: 'DD/MM/YYYY',
			}
		});
	}
	
	$('#create-note').change(function(){
			
			total_qty_rejc 		= $("#total_qty_rejc").val();
			basic_sale_price 	= $("#basic_sale_price").val();
			sales_value 		= (total_qty_rejc * basic_sale_price).toFixed(2);
			$("#sales_value").val(sales_value);
			
			cgst 	= (sales_value / 100) * $(".cgst").val();
			sgst 	= (sales_value / 100) * $(".sgst").val();
			cgst 	= cgst.toFixed(2);
			sgst 	= sgst.toFixed(2);

			$("#cgst").val(cgst);
			$("#sgst").val(sgst);
			  
			
			cost_inc_customer 	= $("#cost_inc_customer").val();
			salvage_value 		= $("#salvage_value").val();
			
			credit_note_iss_cust = parseFloat(sales_value) + parseFloat(cgst) + parseFloat(sgst) + parseFloat(cost_inc_customer) + parseFloat(salvage_value);
			$("#credit_note_iss_cust").val(credit_note_iss_cust.toFixed(2));
			
			console.log(parseFloat(cgst));
			 
			
			qty_acpt_steel_mill 			= $("#qty_acpt_steel_mill").val();
			qty_scrp_auc_serv_cent 			= $("#qty_scrp_auc_serv_cent").val();
			qty_dlv_customer 				= $("#qty_dlv_customer").val();
			
			qty_debit						= parseFloat(qty_acpt_steel_mill) + parseFloat(qty_scrp_auc_serv_cent) + parseFloat(qty_dlv_customer)
			
			debit_note_sal_rate_sale_value 	= $("#debit_note_sal_rate_sale_value").val();
			value 							= qty_debit * debit_note_sal_rate_sale_value;
			value 							= value.toFixed(2);
			$("#value").val(value);
			
			loss_cgst 	= (value / 100) * $(".loss_cgst").val();
			loss_sgst 	= (value / 100) * $(".loss_sgst").val();
			loss_cgst 	= loss_cgst.toFixed(2);
			loss_sgst 	= loss_sgst.toFixed(2);
			
			$("#loss_cgst").val(loss_cgst);
			$("#loss_sgst").val(loss_sgst);
			
			
			oth_exp_inc_mill 			= $("#oth_exp_inc_mill").val();
			oth_exp_debited 			= $("#oth_exp_debited").val();
			compensation_exp 			= $("#compensation_exp").val();
			
			
			debit_note_iss_supplier 	= parseFloat(value) + parseFloat(loss_cgst) + parseFloat(loss_sgst) + parseFloat(oth_exp_debited) + parseFloat(compensation_exp) - parseFloat(oth_exp_inc_mill);
			debit_note_iss_supplier 	= debit_note_iss_supplier.toFixed(2);
			$("#debit_note_iss_supplier").val(debit_note_iss_supplier);
			
			
			loss_from_rejection 		= (parseFloat(sales_value) - parseFloat(value)) + (parseFloat(oth_exp_inc_mill) - parseFloat(compensation_exp));
			//loss_from_rejection 		= (parseFloat(sales_value) - parseFloat(value)) + (parseFloat(oth_exp_inc_mill) - parseFloat(compensation_exp) - parseFloat(debit_note_iss_supplier));
			//loss_from_rejection 		= parseFloat(credit_note_iss_cust) - parseFloat(debit_note_iss_supplier);
			loss_from_rejection 		= loss_from_rejection.toFixed(2);
			$("#loss_from_rejection").val(loss_from_rejection);
			
			
			recoverable_transporter 	= $("#recoverable_transporter").val();
			net_loss					= parseFloat(loss_from_rejection) - parseFloat(recoverable_transporter);
			net_loss					= net_loss.toFixed(2);
			$("#net_loss").val(net_loss)
		});	
</script>




