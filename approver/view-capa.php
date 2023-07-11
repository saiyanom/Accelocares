<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Employee CVC"); redirect_to("capa-approval.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Employee CVC"); redirect_to("capa-approval.php");
		}
	}

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


	$employee_reg = EmployeeReg::find_by_id($session->employee_id);
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	if ($session->is_employee_logged_in()){ 

		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != 'Employee' Limit 1";

		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);

		if(!$employee_location){
			redirect_to("logout.php"); 
		}
	}

	if(isset($_GET['doc']) && !empty($_GET['doc']) && isset($_GET['id']) && !empty($_GET['id'])){

		if(is_numeric($_GET['doc'])) {
			$session->message("Invalid Document Type.");
			redirect_to("capa-approval.php");
		}
		if(strlen($_GET['doc']) > 1) {
			$session->message("Invalid Document Type.");
			redirect_to("capa-approval.php");
		}

		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Document.");
			redirect_to("capa-approval.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Document.");
			redirect_to("capa-approval.php");
		}
		
		$capa = Capa::find_by_id($_GET['id']);
		
		if($_GET['doc'] == "w"){
			$capa = Capa::find_by_id($_GET['id']);
		} else if($_GET['doc'] == "d"){
			$complaint_reg = Complaint::find_by_id($_GET['id']);
		} else {
			$session->message("CAPA Not Found");
			redirect_to("all-complaints.php");
		}
	} else {
		$session->message("CAPA Not Found");
		redirect_to("all-complaints.php");
	}
?>

<script>
	var h = window.innerHeight;
	var doc_h = h - 150;
	document.getElementById("doc_h").style.height = doc_h+"px";
</script>

<?php if($_GET['doc'] == "d"){ ?>
<object id="doc_h" data="<?php echo "../document/{$complaint_reg->ticket_no}/capa/{$complaint_reg->capa_document}";?>" type="application/pdf">
	<iframe src="<?php echo "../document/{$complaint_reg->ticket_no}/capa/{$complaint_reg->capa_document}";?>&embedded=true"></iframe>
</object>
<div class="modal-header border-bottom-st d-block">

<div class="form-p-block">
	
<form action="<?php echo "approve-capa-db.php?id=".$complaint_reg->id; ?>" method="post" enctype="multipart/form-data" autocomplete="off">

<div class="form-p-box form-p-boxbtn">
	<input type="button" class="fpcl" data-dismiss="modal" aria-hidden="true" value="Cancel" />
	<input type="submit" name="save_capa" value="Approve" class="fpdone" />
</div>

<div class="clerfix"></div>
</form>	
</div>

</div>

<?php } ?>





<?php if($_GET['doc'] == "w"){ ?>
<div class="modal-header border-bottom-st d-block">
<!--<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<div class="form-p-hd">
<h2>MAHINDRA ACCELO PVT. LTD.<br>
Corrective And Preventive Action Report</h2>
</div>


<div class="form-p-block">
<form action="<?php echo "approve-capa-db.php?id=".$capa->complaint_id; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
<!-- box 1 -->
<div class="form-p-box form-p-box-bg2">

<div class="sectp-fom">
<h2 class="sectphd">Management Representative</h2>

<ul class="fpall-z">
	<li class="fp-con1-z"><p class="padd10">Document No.</p></li> 
	<li class="fp-con2-z"><input type="text" disabled value="<?php echo $capa->document_no; ?>" id="document_no" name="document_no" class="form-control form-p-box-bg1"></li>
</ul>

<ul class="fpall-z">
	<li class="fp-con1-z"><p class="padd10">Rev. No.</p></li> 
	<li class="fp-con2-z"><input type="text" disabled value="<?php echo $capa->rev_no; ?>" id="rev_no" name="rev_no" class="form-control form-p-box-bg1"></li>
</ul>

<ul class="fpall-z">
	<li class="fp-con1-z"><p class="padd10">Page No.</p></li> 
	<li class="fp-con2-z"><input type="text" disabled value="<?php echo $capa->page_no; ?>" id="page_no" name="page_no" class="form-control form-p-box-bg1"></li>
</ul>
<div class="clerfix"></div>
</div>


<div class="clerfix"></div>
</div>
<!-- box 1 -->

<!-- box 2 -->
<div class="form-p-box form-p-box-bg1 border-bottom-st">

<div class="rst-left">
<ul class="fpall">
	<li class="fp-con1"><p>Customer Name</p></li>             
	<li class="fp-con2"><input type="text" disabled value="<?php echo $capa->customer_name; ?>" id="customer_name" name="customer_name" class="form-control form-p-box-bg2"></li>
	<div class="clerfix"></div>
</ul>

<ul class="fpall">
	<li class="fp-con1"><p>Model</p></li>             
	<li class="fp-con2"><input type="text" disabled value="<?php echo $capa->model; ?>" id="model" name="model" class="form-control form-p-box-bg2"></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
	<li class="fp-con1"><p>Date of issue</p></li>             
	<li class="fp-con2">
		<input id="date_issue" type="text" disabled value="<?php echo date('d/m/Y', strtotime($capa->date_issue)); ?>" name="date_issue" readonly class="form-control date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="true">
	</li>
<div class="clerfix"></div></ul>

<ul class="fpall">
	<li class="fp-con1"><p>Team Members</p></li>             
	<li class="fp-con2"><input type="text" disabled value="<?php echo $capa->team_member; ?>" id="team_member" name="team_member" class="form-control form-p-box-bg2"></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
	<li class="fp-con1"><p>Reviewed By</p></li>             
	<li class="fp-con2"><input type="text" disabled value="<?php echo $capa->reviewed_by; ?>" id="reviewed_by" name="reviewed_by" class="form-control form-p-box-bg2"></li>
	<div class="clerfix"></div>
</ul>

<ul class="fpall">
	<li class="fp-con1"><p>Contact Person Name</p></li>             
	<li class="fp-con2"><input type="text" disabled value="<?php echo $capa->contact_person_name; ?>" id="contact_person_name" name="contact_person_name" class="form-control form-p-box-bg2"></li>
	<div class="clerfix"></div>
</ul>

</div>

<div class="rst-right">
<ul class="fpall">
	<li class="fp-con1"><p>CAPA No.</p></li>             
	<li class="fp-con2"><input type="text" disabled value="<?php echo $capa->capa_no; ?>" id="capa_no" name="capa_no" class="form-control form-p-box-bg2"></li>
	<div class="clerfix"></div>
</ul>

<ul class="fpall">
	<li class="fp-con1"><p>Reported By</p></li>             
	<li class="fp-con2"><input type="text" disabled value="<?php echo $capa->reported_by; ?>" id="reported_by" name="reported_by" class="form-control form-p-box-bg2"></li>
	<div class="clerfix"></div>
</ul>

<ul class="fpall">
	<li class="fp-con1"><p>Problem Description</p></li>             
	<li class="fp-con2"><input type="text" disabled value="<?php echo $capa->problem_desc; ?>" id="problem_desc" name="problem_desc" class="form-control form-p-box-bg2"></li>
	<div class="clerfix"></div>
</ul>

<ul class="fpall">
	<li class="fp-con1"><p>Feedback Date</p></li>             
	<li class="fp-con2">
		<input id="feedback_date" type="text" disabled value="<?php echo date('d/m/Y', strtotime($capa->feedback_date)); ?>" name="feedback_date" readonly class="form-control date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="true">
	</li>
	<div class="clerfix"></div>
</ul>

<ul class="fpall">
	<li class="fp-con1"><p>Reviewed Date</p></li>             
	<li class="fp-con2">
		<input id="reviewed_date" type="text" disabled value="<?php echo date('d/m/Y', strtotime($capa->reviewed_date)); ?>" name="reviewed_date" readonly class="form-control date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="true">
	</li>
	<div class="clerfix"></div>
</ul>

</div>

<div class="clerfix"></div>
</div>
<!-- box 2 -->

<!-- box 3 -->
<div class="form-p-box form-p-box-bg2 border-bottom-st">

<div class="sectp-fom">
<h2 class="sectphd">1. Problem Description</h2>

<ul class="ulsp1">
	<li class="ulsp1-l"><p>Where</p></li>
	<li class="ulsp1-r"><input type="text" disabled value="<?php echo $capa->problem_where; ?>" id="problem_where" name="problem_where" class="form-control form-p-box-bg1"></li>
	<div class="clerfix"></div>
</ul>

<ul class="ulsp1">
	<li class="ulsp1-l"><p>When</p></li>
	<li class="ulsp1-r"><input type="text" disabled value="<?php echo $capa->problem_when; ?>" id="problem_when" name="problem_when" class="form-control form-p-box-bg1"></li>
	<div class="clerfix"></div>
</ul>

<ul class="ulsp1">
	<li class="ulsp1-l"><p>What Qty </p></li>
	<li class="ulsp1-r"><input type="text" disabled value="<?php echo $capa->problem_what_qty; ?>" id="problem_what_qty" name="problem_what_qty" class="form-control form-p-box-bg1"></li>
	<div class="clerfix"></div>
</ul>

<ul class="ulsp1">
	<li class="ulsp1-l"><p>Which Model</p></li>
	<li class="ulsp1-r"><input type="text" disabled value="<?php echo $capa->problem_which_model; ?>" id="problem_which_model" name="problem_which_model" class="form-control form-p-box-bg1"></li>
	<div class="clerfix"></div>
</ul>

<ul class="ulsp1">
	<li class="ulsp1-l"><p>Who Produced</p></li>
	<li class="ulsp1-r"><input type="text" disabled value="<?php echo $capa->problem_who_produced; ?>" id="problem_who_produced" name="problem_who_produced" class="form-control form-p-box-bg1"></li>
	<div class="clerfix"></div>
</ul>

<div class="clerfix"></div>
</div>


<div class="clerfix"></div>
</div>
<!-- box 3 -->

<!-- box 4-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
	<div class="sectp-fom">
		<h2 class="sectphd">2. Findings / Investigation</h2>
		<textarea disabled class="form-control mrig10 form-p-box-bg1" id="finding_invest_remark" name="finding_invest_remark" placeholder="Remarks" rows="3"><?php echo $capa->finding_invest_remark; ?></textarea>
		<div class="clerfix"></div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- box 4 -->

<!-- box 5-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
	<div class="sectp-fom">
		<h2 class="sectphd">3. Structured & systematic analysis of probable causes</h2>
		<textarea disabled class="form-control mrig10 form-p-box-bg1" id="structured_remark" name="structured_remark" placeholder="Remarks" rows="3"><?php echo $capa->structured_remark; ?></textarea>
		<div class="clerfix"></div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- box 5 -->

<!-- box 6-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
	<div class="sectp-fom">
		<h2 class="sectphd">4. Root cause identified</h2>
		<textarea disabled class="form-control mrig10 form-p-box-bg1" id="root_cause_remark" name="root_cause_remark" placeholder="Remarks" rows="3"><?php echo $capa->root_cause_remark; ?></textarea>
		<div class="clerfix"></div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- box 6 -->

<!-- box 7-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
	<div class="sectp-fom">
		<h2 class="sectphd">5. Correction</h2>
		<textarea disabled class="form-control mrig10 form-p-box-bg1" id="correction_remark" name="correction_remark" placeholder="Remarks" rows="3"><?php echo $capa->correction_remark; ?></textarea>
		<input type="text" disabled value="<?php echo $capa->correction_who; ?>" id="correction_who" name="correction_who" placeholder="Who" class="form-control form-p-box-bg1 mrig10">
		<input type="text" disabled value="<?php echo $capa->correction_when; ?>" id="correction_when" name="correction_when" placeholder="When" class="form-control form-p-box-bg1 mrig10">

		<div class="clerfix"></div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- box 7 -->

<!-- box 8-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
	<div class="sectp-fom">
		<h2 class="sectphd">6. Corrective Action</h2>
		<textarea disabled class="form-control mrig10 form-p-box-bg1" id="corrective_remark" name="corrective_remark" placeholder="Remarks" rows="3"><?php echo $capa->corrective_remark; ?></textarea>
		<input type="text" disabled value="<?php echo $capa->corrective_who; ?>" id="corrective_who" name="corrective_who" placeholder="Who" class="form-control form-p-box-bg1 mrig10">
		<input type="text" disabled value="<?php echo $capa->corrective_when; ?>" id="corrective_when" name="corrective_when" placeholder="When" class="form-control form-p-box-bg1 mrig10">

		<div class="clerfix"></div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- box 8 -->

<!-- box 9-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
	<div class="sectp-fom">
		<h2 class="sectphd">7. Verification of Effectiveness:</h2>
		<textarea disabled class="form-control mrig10 form-p-box-bg1" id="verify_remark" name="verify_remark" placeholder="Remarks" rows="3"><?php echo $capa->verify_remark; ?></textarea>
		<input type="text" disabled value="<?php echo $capa->verify_who; ?>" id="verify_who" name="verify_who" placeholder="Who" class="form-control form-p-box-bg1 mrig10">
		<input type="text" disabled value="<?php echo $capa->verify_when; ?>" id="verify_when" name="verify_when" placeholder="When" class="form-control form-p-box-bg1 mrig10">

		<div class="clerfix"></div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- box 9 -->

<!-- box 9-->
<div class="form-p-box form-p-box-bg2">
	<div class="sectp-fom">
		<h2 class="sectphd">8. Preventive action (Horizontal deployment)if applicable</h2>
		<textarea disabled class="form-control mrig10 form-p-box-bg1" id="prevent_remark" name="prevent_remark" placeholder="Remarks" rows="3"><?php echo $capa->prevent_remark; ?></textarea>
		<input type="text" disabled name="prevent_who" value="<?php echo $capa->prevent_who; ?>" id=" " placeholder="Who" class="form-control form-p-box-bg1 mrig10">
		<input type="text" disabled name="prevent_when" value="<?php echo $capa->prevent_when; ?>" id=" " placeholder="When" class="form-control form-p-box-bg1 mrig10">

		<div class="clerfix"></div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- box 9 -->

 <div class="form-p-box form-p-boxbtn">
	<input type="button" class="fpcl" data-dismiss="modal" aria-hidden="true" value="Cancel" />
	<input type="submit" name="save_capa" value="Approve" class="fpdone" />
</div>

<div class="clerfix"></div>
</form>	
</div>

</div>
<?php } ?>



