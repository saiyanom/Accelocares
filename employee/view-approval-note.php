<?php ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$approval_note = ApprovalNote::find_by_id($_GET['id']);
	} else {
		$session->message("Complaint Not Found");
		redirect_to("my-complaints.php");
	}

  $complaint_reg = Complaint::find_by_id($approval_note->complaint_id);
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

	.form-p-box-bg3{
		background-color: #7c7c7c !important;
		opacity: 1;
		color: #fff;
	}

	.app_note_number {
		text-align: right;
	}
	
	.fp-con01 {
		width: 70%;
	}
	.fp-con01 p{
		margin-top: 0;
		margin-bottom: 0;
		padding: 6px 0 0 0;
	}
	.fp-con02 {
	    width: 28.54%;
	}
	.sphf {
	    width: 73%;
	}
	.app_note_number {
		text-align: right;
	}

	.form-p-box-bg3 {
		background-color: #7c7c7c !important ;
		color: #fff !important;
	}	
  .debit_inputs div{
      width: 200px;
      display: inline-block;
    }
</style>
<div class="modal-header border-bottom-st d-block">
<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>
<div class="form-p-hd">
<h2>MAHINDRA ACCELO LTD. / MASL / MSSCL<br>
Credit Note / Debit Note Approval</h2>
</div>



<div class="form-p-block">
<!-- box 1 -->
<div class="form-p-box form-p-box-bg2">

<div class="rst-left">
	<ul class="fpall">
		<li class="fp-con1"><p>Name of the customer</p></li>             
		<li class="fp-con2"><input readonly type="text" value="<?php echo $approval_note->customer_name; ?>" name="customer_name" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Complaint reference no</p></li>             
		<li class="fp-con2"><input readonly type="text" value="<?php echo $approval_note->complait_reference; ?>" name="complait_reference" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>

  <ul class="fpall">
    <li class="fp-con1"><p>Plant</p></li>             
    <li class="fp-con2"><input readonly type="text" value="<?php echo $complaint_reg->product." | ".$complaint_reg->business_vertical." | ".$complaint_reg->plant_location; ?>" class="form-control form-p-box-bg1"></li>
    <div class="clerfix"></div>
  </ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Complant Registration date</p></li>             
		<li class="fp-con2">
			<input readonly value="<?php echo date( 'd-m-Y', strtotime($approval_note->complait_reg_date)); ?>"  class="form-control" id="complait_reg_date" type="text"  name="complait_reg_date">
		</li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Material Details  (grade, size etc)</p></li>             
		<li class="fp-con2"><input readonly type="text" value="<?php echo $approval_note->material_details; ?>" name="material_details" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>
</div>

<div class="rst-right">
	<ul class="fpall">
		<li class="fp-con1"><p>Nature of the complaint</p></li>             
		<li class="fp-con2">
			<textarea readonly id="nature_of_complaint" name="nature_of_complaint" readonly class="form-control mrig10 form-p-box-bg1"><?php echo $approval_note->nature_of_complaint; ?></textarea>
		</li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Name of the Steel Mill / Service centre/ Transporter</p></li>             
		<li class="fp-con2"><input readonly type="text" value="<?php echo $approval_note->name_of_sm_sc_t; ?>" name="name_of_sm_sc_t" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Responsibility</p></li>             
		<li class="fp-con2"><input readonly type="text" value="<?php echo $approval_note->responsibility; ?>" name="responsibility" class="form-control form-p-box-bg1"></li>
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
		<li class="fp-con2"><input readonly type="text" value="<?php echo $approval_note->billing_doc_no; ?>" name="billing_doc_no" class="form-control form-p-box-bg2"></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Billing Document Date</p></li>             
		<li class="fp-con2">
			<input readonly style="width: 100%;" id="billing_doc_date" value="<?php echo date( 'd-m-Y', strtotime($approval_note->billing_doc_date));  ?>" type="text" name="billing_doc_date" readonly class="form-control fodhf date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="true">
		</li>
		<div class="clerfix"></div>
	</ul>
</div>

<div class="rst-right">
	<ul class="fpall">
		<li class="fp-con1"><p>Total Qty Rejected by the Customer</p></li>             
		<li class="fp-con2"><input readonly type="text" value="<?php echo $approval_note->total_qty_rejc; ?>" name="total_qty_rejc" class="form-control form-p-box-bg2 app_note_number"></li>
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
		<li class="fp-con01"><p>Basic sale price <input readonly type="text" value="<?php echo $approval_note->basic_sale_price_txt; ?>" class="form-control form-p-box-bg2 sphf"></p></li> 
		<li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->basic_sale_price; ?>" name="basic_sale_price" class="form-control form-p-box-bg2 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Sales Value (Basic sale price/t X Qty) <span style="float: right;">(a)</span></p></li> 
		<li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->sales_value; ?>" name="sales_value" class="form-control form-p-box-bg2 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>CGST @ <?php 
			if(!empty($approval_note->cgst_percent)){
				echo $approval_note->cgst_percent;
			}else {
				$cgst_percent =  100 / ($approval_note->sales_value/$approval_note->cgst);
				echo round($cgst_percent,2);
			}
		?>%</p></li> 
		<li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->cgst; ?>" name="cgst" class="form-control form-p-box-bg2 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>SGST @ <?php 
			if(!empty($approval_note->sgst_percent)){
				echo $approval_note->sgst_percent;
			}else {
				$sgst_percent = 100 / ($approval_note->sales_value/$approval_note->sgst);
				echo round($sgst_percent,1);
			}
		?>%</p></li> 
		<li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>
		<input readonly type="text" value="<?php echo $approval_note->sgst; ?>" name="sgst" class="form-control form-p-box-bg2 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		
    <li class="fp-con01"><p>Cost incurred by the customer <input readonly type="text" value="<?php echo $approval_note->cost_inc_customer_txt; ?>" class="form-control form-p-box-bg2 sphf">
      </p>
    </li> 
		
    <li class="fp-con02"><span class="padd10">(+) &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->cost_inc_customer; ?>" name="cost_inc_customer" class="form-control form-p-box-bg2 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Salvage Rate <input readonly type="text" value="<?php echo $approval_note->salvage_value_txt; ?>" class="form-control form-p-box-bg2 sphf"></p></li> 
		<li class="fp-con02"><span class="padd10">(-) &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->salvage_value; ?>" name="salvage_value" class="form-control form-p-box-bg2 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p class="colrred">Credit note to be issued to the customer (total of abv net of scrap value)</p></li> 
		<li class="fp-con02"><span class="padd10 colrred">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->credit_note_iss_cust; ?>" name="credit_note_iss_cust" class="form-control form-p-box-bg3 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
</div>

<div class="clerfix"></div>
</div>
<!-- box 3 -->

<!-- box 4 -->
<div class="form-p-box form-p-box-bg2">

<div class="rst-full">
	<h2 class="sectphd">Debit Note Issued to Supplier / Realisation from Scrap / To be Recovered from Insurance Co.</h2>
	<ul class="fpall">
		<li class="fp-con01"><p>Quantity (t) as accepted by steel mill    </p></li> 
		<li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->qty_acpt_steel_mill; ?>" name="qty_acpt_steel_mill" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Quantity (t) to be scrapped / auction at service centres </p></li> 
		<li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->qty_scrp_auc_serv_cent; ?>" name="qty_scrp_auc_serv_cent" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Quantity (t) to be diverted to any other customer</p></li> 
		<li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->qty_dlv_customer; ?>" name="qty_dlv_customer" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Debit note (purchase price/t) / Salvage rate / Sale value <input readonly type="text" value="<?php echo $approval_note->debit_salvage_sale_txt; ?>" class="form-control form-p-box-bg2 sphf"></p></li> 
		<li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->debit_note_sal_rate_sale_value; ?>" name="debit_note_sal_rate_sale_value" class="form-control form-p-box-bg2 sphf app_note_number"></li>
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
		<li class="fp-con01"><p>Value (purchase price/t  X qty) <span style="float: right;">(b)</span></p></li> 
		<li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->value; ?>" name="value" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>CGST @ <?php 
			if(!empty($approval_note->lcgst_percent)){
				echo $approval_note->lcgst_percent;
			}else {
				$lcgst_percent =  100 / ($approval_note->value/$approval_note->loss_cgst);;
				echo round($lcgst_percent,2);
			}
		?>%</p></li> 
		<li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->loss_cgst; ?>" name="loss_cgst" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>SGST @ <?php 
			if(!empty($approval_note->lsgst_percent)){
				echo $approval_note->lsgst_percent;
			}else {
				$lsgst_percent =  100 / ($approval_note->value/$approval_note->loss_sgst);
				echo round($lsgst_percent,2);
			}
		?>%</p></li> 
		<li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->loss_sgst; ?>" name="loss_sgst" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Total Debit Value  <span style="float: right;">(x)</span></p></li> 
		<li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  

		<!-- <input readonly type="text" value="<?php //echo $approval_note->total_debit_value; ?>" name="total_debit_value" class="form-control form-p-box-bg1 sphf app_note_number"> -->

		<?php $total_debit_value = $approval_note->value + $approval_note->loss_cgst + $approval_note->loss_sgst; ?>
		<input readonly type="text" value="<?php echo $total_debit_value; ?>" name="total_debit_value" class="form-control form-p-box-bg1 sphf app_note_number">

	</li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01">
			<p>Other expenses incurred by MIL  <input style="width: 300px;" readonly type="text" value="<?php echo $approval_note->other_exp_inc_mill_txt; ?>" class="form-control form-p-box-bg2 sphf"> <span style="float: right;">(c)</span></p>
		</li> 
		<li class="fp-con02"><span class="padd10">(+) &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->oth_exp_inc_mill; ?>" name="oth_exp_inc_mill" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Other expenses to be debited (eg freight) / credited (eg scrap @ 20000 recovery) to steel mill <span style="float: right;">(y)</span></p></li> 
		<li class="fp-con02"><span class="padd10">(-) &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->oth_exp_debited; ?>" name="oth_exp_debited" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Compensation expected from Insurance Co. <span style="float: right;">(d)</span></p></li> 
		<li class="fp-con02"><span class="padd10">(-) &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->compensation_exp; ?>" name="compensation_exp" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p class="colrred">Debit note issued to supplier / Billing back to customer / Realisation from scrap  <span style="float: right;">(x+y)</span></p></li> 
		<li class="fp-con02"><span class="padd10 colrred">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->debit_note_iss_supplier; ?>" name="debit_note_iss_supplier" class="form-control form-p-box-bg3 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p class="colrred">Loss from the Rejection <span style="float: right;">(e) = (a-b+c-d-y)</span></p></li> 
		<li class="fp-con02"><span class="padd10 colrred">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->loss_from_rejection; ?>" name="loss_from_rejection" class="form-control form-p-box-bg3 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Recoverable from Transporter (if applicable) <span style="float: right;">(f)</span></p></li> 
		<li class="fp-con02"><span class="padd10">(-) &nbsp; Rs.</span>  
		<input readonly type="text" value="<?php echo $approval_note->recoverable_transporter; ?>" name="recoverable_transporter" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>


  <ul class="fpall">
    <li class="fp-con01"><p>Other Realisation (if applicable) <span style="float: right;">(g)</span></p></li> 
    <li class="fp-con02"><span class="padd10">(-) &nbsp; Rs.</span>  
    <input readonly type="text" value="<?php echo $approval_note->other_realisation; ?>" name="other_realisation" class="form-control form-p-box-bg1 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>

	<ul class="fpall">
		<li class="fp-con01"><p class="colrred">Net Loss / (-) Net Profit <span style="float: right;">(e-f-g)</span></p></li> 
		<li class="fp-con02"><span class="padd10 colrred">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
		<!-- <input readonly type="text" value="<?php echo $approval_note->net_loss; ?>" name="net_loss" class="form-control form-p-box-bg3 sphf app_note_number" id="net_loss"></li> -->
    <input readonly type="text" value="<?php echo ($approval_note->loss_from_rejection - $approval_note->recoverable_transporter - $approval_note->other_realisation); ?>" name="net_loss" class="form-control form-p-box-bg3 sphf app_note_number" id="net_loss"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<p>
			<strong>Remark:</strong><br/>
			<?php echo $approval_note->remark; ?>
		</p>
	</ul>
</div>



<div class="rst-full">

<?php 
      

      show_approver_info_common($complaint_reg,$approval_note);

      
  ?>
</div>


<div class="pfot-cont">
  <hr>
	<p>
		Note<br/>
		a) Credit Note will be issued by the respective plants in case of material return from the customer.<br/>
		b)  For processing related rejections, complaint will be closed after issue of CAPA / CN<br/>
	</p>
</div>

<?php 
 if ( $approval_note->on_hold != 1){
  include 'approval-note-file-html.php';
}
?>

  <?php 
    if ( $approval_note->on_hold == 1){
       echo '<div class="form-p-box form-p-box-bg1">
            <div class="rst-full">
              <ul class="fpall">
                  <p class="colrred_black"><strong>Rejected By : </strong>'.$approval_note->on_hold_by.'</p>
                  <p class="colrred_black"><strong>Rejected On : </strong>'.date("Y-m-d", strtotime($approval_note->on_hold_date)).'</p>
                  <p class="colrred_black"><strong>Hold/Reject Reason : </strong></p>
                  <p> '.$approval_note->on_hold_remark.' </p>
              </ul>
            </div>
          </div>';
    }
  ?>


	<div class="clerfix"></div>
</div>
<!-- box 4 -->
<div class="clerfix"></div>
</div>


</div>