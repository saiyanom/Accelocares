<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	////date_default_timezone_set('Asia/Calcutta');
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }


	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("customer.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+-]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("customer.php");
		}
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Query."); redirect_to("customer.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Query."); redirect_to("customer.php");
		}
	} else {
		$session->message("Company not found"); redirect_to("customer.php");
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$company_reg = CompanyReg::find_by_id($_GET['id']);
	} 

	//document.getElementById('close_form').click(); 
	
?>
<style>
	strong {text-transform: uppercase; color: #222; }
</style>
<div class="modal-header border-bottom-st d-block">
	<button type="button" id="close_form" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>
	<div class="form-p-hd">
		<h2>Company Details</h2>
	</div>

	<div class="form-p-block">
		<div class="form-group"><label class="control-label"><strong>Company Name</strong></label><p><?php echo $company_reg->company_name; ?></p></div>
		<ul class="ad-lr">
			<div class="form-group"><label class="control-label"><strong>Customer Id</strong></label><p><?php echo $company_reg->customer_id; ?></p></div>
		</ul>
		<div class="clerfix"></div>

		<div class="edit_cust_details">
			<div class="cust_details_row cust_details_row_1">
				<hr />
				<div class="form-group"><label class="control-label"><strong>Full Name</strong></label><p><?php echo $company_reg->emp_name_1; ?></p></div>
				<div class="form-group"><label class="control-label"><strong>Email</strong></label><p><?php echo $company_reg->emp_email_1; ?></p></div>
				<div class="form-group"><label class="control-label"><strong>Mobile Number</strong></label><p><?php echo $company_reg->emp_mobile_1; ?></p></div>
				<div class="clerfix"></div>
			</div>
			<?php if(!empty($company_reg->emp_name_2)){ ?>
			<div class="cust_details_row cust_details_row_2">
				<hr />
				<div class="form-group"><label class="control-label"><strong>Full Name</strong></label><p><?php echo $company_reg->emp_name_2; ?></p></div>
				<div class="form-group"><label class="control-label"><strong>Email</strong></label><p><?php echo $company_reg->emp_email_2; ?></p></div>
				<div class="form-group"><label class="control-label"><strong>Mobile Number</strong></label><p><?php echo $company_reg->emp_mobile_2; ?></p></div>
				<div class="clerfix"></div>
			</div>
			<?php } ?>
			<?php if(!empty($company_reg->emp_name_3)){ ?>
			<div class="cust_details_row cust_details_row_3">
				<hr />
				<div class="form-group"><label class="control-label"><strong>Full Name</strong></label><p><?php echo $company_reg->emp_name_3; ?></p></div>
				<div class="form-group"><label class="control-label"><strong>Email</strong></label><p><?php echo $company_reg->emp_email_3; ?></p></div>
				<div class="form-group"><label class="control-label"><strong>Mobile Number</strong></label><p><?php echo $company_reg->emp_mobile_3; ?></p></div>
				<div class="clerfix"></div>
			</div>
			<?php } ?>
			<?php if(!empty($company_reg->emp_name_4)){ ?>
			<div class="cust_details_row cust_details_row_4">
				<hr />
				<div class="form-group"><label class="control-label"><strong>Full Name</strong></label><p><?php echo $company_reg->emp_name_4; ?></p></div>
				<div class="form-group"><label class="control-label"><strong>Email</strong></label><p><?php echo $company_reg->emp_email_4; ?></p></div>
				<div class="form-group"><label class="control-label"><strong>Mobile Number</strong></label><p><?php echo $company_reg->emp_mobile_4; ?></p></div>
				<div class="clerfix"></div>
			</div>
			<?php } ?>
			<?php if(!empty($company_reg->emp_name_5)){ ?>
			<div class="cust_details_row cust_details_row_5">
				<hr />
				<div class="form-group"><label class="control-label"><strong>Full Name</strong></label><p><?php echo $company_reg->emp_name_5; ?></p></div>
				<div class="form-group"><label class="control-label"><strong>Email</strong></label><p><?php echo $company_reg->emp_email_5; ?></p></div>
				<div class="form-group"><label class="control-label"><strong>Mobile Number</strong></label><p><?php echo $company_reg->emp_mobile_5; ?></p></div>
				<div class="clerfix"></div>
			</div>
			<?php } ?>
		</div>					

		

		<div class="clerfix"></div>
	</div>
</div>
