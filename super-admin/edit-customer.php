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
<div class="modal-header border-bottom-st d-block">
	<button type="button" id="close_form" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>
	<div class="form-p-hd">
		<h2>Edit Company Details</h2>
	</div>

	<div class="form-p-block">
		<form action="customer-edit-db.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
		<div class="form-group">
			<label class="control-label">Company Name</label>
			<input class="form-control form-p-box-bg1" placeholder="" type="text" value="<?php echo $company_reg->company_name; ?>" id="company_name2" name="company_name">
			<span class="err_msg company_name2_msg"></span>
		</div>
		<ul class="ad-lr">
			<div class="form-group"><label class="control-label">Customer Id</label><input class="form-control form-p-box-bg1" placeholder="" type="text" value="<?php echo $company_reg->customer_id; ?>" id="customer_id2" name="customer_id"><span class="err_msg customer_id2_msg"></span></div>
			<li class="adl1"><div class="form-group"><label class="control-label">Password</label><input class="form-control form-p-box-bg1" placeholder="" type="password" id="password2"><input class="form-control form-p-box-bg1" placeholder="" type="hidden" id="user_password2" name="password"><span class="err_msg password2_msg"></span></div></li>						
			<li class="adr1"><div class="form-group"><label class="control-label">Retype Password</label><input class="form-control form-p-box-bg1" placeholder="" type="password" id="re_password2"><input class="form-control form-p-box-bg1" placeholder="" type="hidden" id="user_re_password2" name="re_password2"><span class="err_msg re_password2_msg"></span></div></li>
		</ul>
		<div class="clerfix"></div>

		<div class="edit_cust_details">
			<div class="cust_details">
				<div class="cust2_details_row cust2_details_row_1">
					<hr />
					<div class="form-group"><label class="control-label">Full Name</label><input class="form-control form-p-box-bg1" type="text" value="<?php echo $company_reg->emp_name_1; ?>" id="emp2_name_1" name="emp_name_1"><span class="err_msg emp2_name_1_msg"></span></div>
					<div class="form-group"><label class="control-label">Email</label><input class="form-control form-p-box-bg1" type="text" value="<?php echo $company_reg->emp_email_1; ?>" id="emp2_email_1" name="emp_email_1"><span class="err_msg emp2_email_1_msg"></span></div>
					<div class="form-group"><label class="control-label">Mobile Number</label><input class="form-control form-p-box-bg1" type="number" value="<?php echo $company_reg->emp_mobile_1; ?>" id="emp2_mobile_1" name="emp_mobile_1"><span class="err_msg emp2_mobile_1_msg"></span></div>
					<div class="clerfix"></div>
				</div>
			</div>
			<?php if(!empty($company_reg->emp_name_2)){ ?>
			<div class="cust_details">
				<div class="cust2_details_row cust2_details_row_2">
					<hr />
					<div class="form-group"><label class="control-label">Full Name</label><input class="form-control form-p-box-bg1" type="text" value="<?php echo $company_reg->emp_name_2; ?>" id="emp2_name_2" name="emp_name_2"><span class="err_msg emp2_name_2_msg"></span></div>
					<div class="form-group"><label class="control-label">Email</label><input class="form-control form-p-box-bg1" type="text" value="<?php echo $company_reg->emp_email_2; ?>" id="emp2_email_2" name="emp_email_2"><span class="err_msg emp2_email_2_msg"></span></div>
					<div class="form-group"><label class="control-label">Mobile Number</label><input class="form-control form-p-box-bg1" type="number" value="<?php echo $company_reg->emp_mobile_2; ?>" id="emp2_mobile_2" name="emp_mobile_2"><span class="err_msg emp2_mobile_2_msg"></span></div>
					<div class="clerfix"></div>
				</div>
			</div>
			<?php } ?>
			<?php if(!empty($company_reg->emp_name_3)){ ?>
			<div class="cust_details">
				<div class="cust2_details_row cust2_details_row_3">
					<hr />
					<div class="form-group"><label class="control-label">Full Name</label><input class="form-control form-p-box-bg1" type="text" value="<?php echo $company_reg->emp_name_3; ?>" id="emp2_name_3" name="emp_name_3"><span class="err_msg emp2_name_3_msg"></span></div>
					<div class="form-group"><label class="control-label">Email</label><input class="form-control form-p-box-bg1" type="text" value="<?php echo $company_reg->emp_email_3; ?>" id="emp2_email_3" name="emp_email_3"><span class="err_msg emp2_email_3_msg"></span></div>
					<div class="form-group"><label class="control-label">Mobile Number</label><input class="form-control form-p-box-bg1" type="number" value="<?php echo $company_reg->emp_mobile_3; ?>" id="emp2_mobile_3" name="emp_mobile_3"><span class="err_msg emp2_mobile_3_msg"></span></div>
					<div class="clerfix"></div>
				</div>
			</div>
			<?php } ?>
			<?php if(!empty($company_reg->emp_name_4)){ ?>
			<div class="cust_details">
				<div class="cust2_details_row cust2_details_row_4">
					<hr />
					<div class="form-group"><label class="control-label">Full Name</label><input class="form-control form-p-box-bg1" type="text" value="<?php echo $company_reg->emp_name_4; ?>" id="emp2_name_4" name="emp_name_4"><span class="err_msg emp2_name_4_msg"></span></div>
					<div class="form-group"><label class="control-label">Email</label><input class="form-control form-p-box-bg1" type="text" value="<?php echo $company_reg->emp_email_4; ?>" id="emp2_email_4" name="emp_email_4"><span class="err_msg emp2_email_4_msg"></span></div>
					<div class="form-group"><label class="control-label">Mobile Number</label><input class="form-control form-p-box-bg1" type="number" value="<?php echo $company_reg->emp_mobile_4; ?>" id="emp2_mobile_4" name="emp_mobile_4"><span class="err_msg emp2_mobile_4_msg"></span></div>
					<div class="clerfix"></div>
				</div>
			</div>
			<?php } ?>
			<?php if(!empty($company_reg->emp_name_5)){ ?>
			<div class="cust_details">
				<div class="cust2_details_row cust2_details_row_5">
					<hr />
					<div class="form-group"><label class="control-label">Full Name</label><input class="form-control form-p-box-bg1" type="text" value="<?php echo $company_reg->emp_name_5; ?>" id="emp2_name_5" name="emp_name_5"><span class="err_msg emp2_name_5_msg"></span></div>
					<div class="form-group"><label class="control-label">Email</label><input class="form-control form-p-box-bg1" type="text" value="<?php echo $company_reg->emp_email_5; ?>" id="emp2_email_5" name="emp_email_5"><span class="err_msg emp2_email_5_msg"></span></div>
					<div class="form-group"><label class="control-label">Mobile Number</label><input class="form-control form-p-box-bg1" type="number" value="<?php echo $company_reg->emp_mobile_5; ?>" id="emp2_mobile_5" name="emp_mobile_5"><span class="err_msg emp2_mobile_5_msg"></span></div>
					<div class="clerfix"></div>
				</div>
			</div>
			<?php } ?>
		</div>					

		<div class="input-group">
			<div class="custom-file">
				<button type="button" name="product_btn" class="fpcl btn add_cust"><i class="mdi mdi-plus"></i> Add Employee</button>
				&nbsp; &nbsp; 
				<button type="button" name="product_btn" class="btn fpdone rem_cust"><i class="mdi mdi-minus"></i> Remove Employee</button>
			</div>
		</div>
		<div class="clerfix">&nbsp;</div>

		<div class="form-p-box form-p-boxbtn">
			<input type="submit" class="fpdone" id="update_customer" value="Update">
		</div>

		<div class="clerfix"></div>
		</form>
	</div>
</div>

<script type="application/javascript">
	$(document).ready(function() {
		
		
	$(".add_cust").click(function (e) {
		var num = $(".cust2_details_row").length + 1;
		if(num <= 5){
			var div = "<div class='cust2_details_row cust2_details_row_"+num+"'><hr /><div class='form-group'><label class='control-label'>Full Name</label><input class='form-control form-p-box-bg1' type='text' id='emp_name_"+num+"' name='emp_name_"+num+"'><span class='err_msg emp_name_"+num+"_msg'></span></div><div class='form-group'><label class='control-label'>Email</label><input class='form-control form-p-box-bg1' type='text' id='emp_email_"+num+"' name='emp_email_"+num+"'><span class='err_msg emp_email_"+num+"_msg'></span></div><div class='form-group'><label class='control-label'>Mobile Number</label><input class='form-control form-p-box-bg1' type='number' id='emp_mobile_"+num+"' name='emp_mobile_"+num+"'><span class='err_msg emp_mobile_"+num+"_msg'></span></div><div class='clerfix'></div></div>";
			$(".cust_details").append(div);
		} 		
		e.preventDefault();
	});
	
	$(".rem_cust").click(function (e) {
		var num = $(".cust2_details_row").length;		
		if(num >= 2){
			$(".cust2_details_row_"+ num).remove();
		}
		e.preventDefault();
	});

	});

	$("#password2").keyup(function () {
	    var value = $(this).val();
	    $("#user_password2").val(sha256_digest(value));
	}).keyup();
	
	$("#re_password2").keyup(function () {
	    var value = $(this).val();
	    $("#user_re_password2").val(sha256_digest(value));
	}).keyup();

	function validateEmail(email) {
		var email = request.email.replace(/\'/g,'&apos;');
		
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		return emailReg.test(email);
	}

$("#update_customer").click(function() {
	
	if ($("#company_name2").val() == "") {
		$("#company_name2").css("border","1px solid #f00");
		$(".company_name2_msg").show(); $(".company_name2_msg").html("Enter Company Name");
		return false;
	} else {
		$("#company_name2").css("border","1px solid #dee2e6"); $(".company_name2_msg").hide(); $(".company_name2_msg").html("");
	}

	if ($("#customer_id2").val() == "") {
		$("#customer_id2").css("border","1px solid #f00");
		$(".customer_id2_msg").show(); $(".customer_id2_msg").html("Enter Customer ID");
		return false;
	} else {
		$("#customer_id2").css("border","1px solid #dee2e6"); $(".customer_id2_msg").hide(); $(".customer_id2_msg").html("");
	}


	if ($("#password2").val() != "") {
		if ($("#password2").val().length < 6) {
			$("#password2").css("border","1px solid #f00");
			$(".password2_msg").show(); $(".password2_msg").html("Enter Minimum 6 digit Password");
		  	return false;
		} else {
			$("#password2").css("border","1px solid #dee2e6"); $(".password2_msg").hide(); $(".password2_msg").html("");
		} 

		if ($("#re_password2").val() == "") {
			$("#re_password2").css("border","1px solid #f00");
			$(".re_password2_msg").show(); $(".re_password2_msg").html("Enter Retype Password");
		  	return false;
		} else {
			$("#re_password2").css("border","1px solid #dee2e6"); $(".re_password2_msg").hide(); $(".re_password2_msg").html("");
		} 

		if ($("#re_password2").val().length < 6) {
			$("#re_password2").css("border","1px solid #f00");
			$(".re_password2_msg").show(); $(".re_password2_msg").html("Enter Minimum 6 digit Retype Password");
		  	return false;
		} else {
			$("#re_password2").css("border","1px solid #dee2e6"); $(".re_password2_msg").hide(); $(".re_password2_msg").html("");
		} 

		if ($("#password2").val() !=  $("#re_password2").val()) {
			$("#re_password2").css("border","1px solid #f00");
			$(".re_password2_msg").show(); $(".re_password2_msg").html("Password & Retype Password not matched");
		  	return false;
		} else {
			$("#re_password2").css("border","1px solid #dee2e6"); $(".re_password2_msg").hide(); $(".re_password2_msg").html("");
		} 
	} 
	
	

	if ($("#emp2_name_1").val() == "") {
		$("#emp2_name_1").css("border","1px solid #f00");
		$(".emp2_name_1_msg").show(); $(".emp2_name_1_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#emp2_name_1").val())) {
			$("#emp2_name_1").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".emp2_name_1_msg").show(); $(".emp2_name_1_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#emp2_name_1").css("border","1px solid #dee2e6"); $(".emp2_name_1_msg").hide(); $(".emp2_name_1_msg").html("");
		}
	
		
		if ($("#emp2_email_1").val() == "") {
			$("#emp2_email_1").css("border","1px solid #f00");
			$(".emp2_email_1_msg").show(); $(".emp2_email_1_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#emp2_email_1").val())){
				$("#emp2_email_1").css("border","1px solid #f00");
				$(".emp2_email_1_msg").show(); $(".emp2_email_1_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#emp2_email_1").css("border","1px solid #dee2e6"); $(".emp2_email_1_msg").hide(); $(".emp2_email_1_msg").html("");
			} 
		} 
		
		if ($("#emp2_mobile_1").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#emp2_mobile_1').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#emp2_mobile_1").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".emp2_mobile_1_msg").show(); $(".emp2_mobile_1_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#emp2_mobile_1").css("border","1px solid #dee2e6"); $(".emp2_mobile_1_msg").hide(); $(".emp2_mobile_1_msg").html("");} 
			} else {
				$("#emp2_mobile_1").css("border","1px solid #f00");
				$(".emp2_mobile_1_msg").show(); $(".emp2_mobile_1_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#emp2_mobile_1").css("border","1px solid #f00");
			//$(".emp2_mobile_1_msg").show(); $(".emp2_mobile_1_msg").html("Enter Mobile Number");
			//return false;
		}
	} 


if ($("#emp2_name_2").val()) {
	if ($("#emp2_name_2").val() == "") {
		$("#emp2_name_2").css("border","1px solid #f00");
		$(".emp2_name_2_msg").show(); $(".emp2_name_2_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#emp2_name_2").val())) {
			$("#emp2_name_2").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".emp2_name_2_msg").show(); $(".emp2_name_2_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#emp2_name_2").css("border","1px solid #dee2e6"); $(".emp2_name_2_msg").hide(); $(".emp2_name_2_msg").html("");
		}
	
		
		if ($("#emp2_email_2").val() == "") {
			$("#emp2_email_2").css("border","1px solid #f00");
			$(".emp2_email_2_msg").show(); $(".emp2_email_2_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#emp2_email_2").val())){
				$("#emp2_email_2").css("border","1px solid #f00");
				$(".emp2_email_2_msg").show(); $(".emp2_email_2_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#emp2_email_2").css("border","1px solid #dee2e6"); $(".emp2_email_2_msg").hide(); $(".emp2_email_2_msg").html("");
			} 
		} 
		
		if ($("#emp2_mobile_2").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#emp2_mobile_2').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#emp2_mobile_2").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".emp2_mobile_2_msg").show(); $(".emp2_mobile_2_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#emp2_mobile_2").css("border","1px solid #dee2e6"); $(".emp2_mobile_2_msg").hide(); $(".emp2_mobile_2_msg").html("");} 
			} else {
				$("#emp2_mobile_2").css("border","1px solid #f00");
				$(".emp2_mobile_2_msg").show(); $(".emp2_mobile_2_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#emp2_mobile_2").css("border","1px solid #f00");
			//$(".emp2_mobile_2_msg").show(); $(".emp2_mobile_2_msg").html("Enter Mobile Number");
			//return false;
		}
	} 
}


if ($("#emp2_name_3").val()) {
	if ($("#emp2_name_3").val() == "") {
		$("#emp2_name_3").css("border","1px solid #f00");
		$(".emp2_name_3_msg").show(); $(".emp2_name_3_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#emp2_name_3").val())) {
			$("#emp2_name_3").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".emp2_name_3_msg").show(); $(".emp2_name_3_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#emp2_name_3").css("border","1px solid #dee2e6"); $(".emp2_name_3_msg").hide(); $(".emp2_name_3_msg").html("");
		}
	
		
		if ($("#emp2_email_3").val() == "") {
			$("#emp2_email_3").css("border","1px solid #f00");
			$(".emp2_email_3_msg").show(); $(".emp2_email_3_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#emp2_email_3").val())){
				$("#emp2_email_3").css("border","1px solid #f00");
				$(".emp2_email_3_msg").show(); $(".emp2_email_3_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#emp2_email_3").css("border","1px solid #dee2e6"); $(".emp2_email_3_msg").hide(); $(".emp2_email_3_msg").html("");
			} 
		} 
		
		if ($("#emp2_mobile_3").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#emp2_mobile_3').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#emp2_mobile_3").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".emp2_mobile_3_msg").show(); $(".emp2_mobile_3_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#emp2_mobile_3").css("border","1px solid #dee2e6"); $(".emp2_mobile_3_msg").hide(); $(".emp2_mobile_3_msg").html("");} 
			} else {
				$("#emp2_mobile_3").css("border","1px solid #f00");
				$(".emp2_mobile_3_msg").show(); $(".emp2_mobile_3_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#emp2_mobile_3").css("border","1px solid #f00");
			//$(".emp2_mobile_3_msg").show(); $(".emp2_mobile_3_msg").html("Enter Mobile Number");
			//return false;
		}
	} 
}


if ($("#emp2_name_4").val()) {
	if ($("#emp2_name_4").val() == "") {
		$("#emp2_name_4").css("border","1px solid #f00");
		$(".emp2_name_4_msg").show(); $(".emp2_name_4_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#emp2_name_4").val())) {
			$("#emp2_name_4").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".emp2_name_4_msg").show(); $(".emp2_name_4_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#emp2_name_4").css("border","1px solid #dee2e6"); $(".emp2_name_4_msg").hide(); $(".emp2_name_4_msg").html("");
		}
	
		
		if ($("#emp2_email_4").val() == "") {
			$("#emp2_email_4").css("border","1px solid #f00");
			$(".emp2_email_4_msg").show(); $(".emp2_email_4_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#emp2_email_4").val())){
				$("#emp2_email_4").css("border","1px solid #f00");
				$(".emp2_email_4_msg").show(); $(".emp2_email_4_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#emp2_email_4").css("border","1px solid #dee2e6"); $(".emp2_email_4_msg").hide(); $(".emp2_email_4_msg").html("");
			} 
		} 
		
		if ($("#emp2_mobile_4").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#emp2_mobile_4').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#emp2_mobile_4").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".emp2_mobile_4_msg").show(); $(".emp2_mobile_4_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#emp2_mobile_4").css("border","1px solid #dee2e6"); $(".emp2_mobile_4_msg").hide(); $(".emp2_mobile_4_msg").html("");} 
			} else {
				$("#emp2_mobile_4").css("border","1px solid #f00");
				$(".emp2_mobile_4_msg").show(); $(".emp2_mobile_4_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#emp2_mobile_4").css("border","1px solid #f00");
			//$(".emp2_mobile_4_msg").show(); $(".emp2_mobile_4_msg").html("Enter Mobile Number");
			//return false;
		}
	} 
}


if ($("#emp2_name_5").val()) {
	if ($("#emp2_name_5").val() == "") {
		$("#emp2_name_5").css("border","1px solid #f00");
		$(".emp2_name_5_msg").show(); $(".emp2_name_5_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#emp2_name_5").val())) {
			$("#emp2_name_5").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".emp2_name_5_msg").show(); $(".emp2_name_5_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#emp2_name_5").css("border","1px solid #dee2e6"); $(".emp2_name_5_msg").hide(); $(".emp2_name_5_msg").html("");
		}
	
		
		if ($("#emp2_email_5").val() == "") {
			$("#emp2_email_5").css("border","1px solid #f00");
			$(".emp2_email_5_msg").show(); $(".emp2_email_5_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#emp2_email_5").val())){
				$("#emp2_email_5").css("border","1px solid #f00");
				$(".emp2_email_5_msg").show(); $(".emp2_email_5_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#emp2_email_5").css("border","1px solid #dee2e6"); $(".emp2_email_5_msg").hide(); $(".emp2_email_5_msg").html("");
			} 
		} 
		
		if ($("#emp2_mobile_5").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#emp2_mobile_5').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#emp2_mobile_5").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".emp2_mobile_5_msg").show(); $(".emp2_mobile_5_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#emp2_mobile_5").css("border","1px solid #dee2e6"); $(".emp2_mobile_5_msg").hide(); $(".emp2_mobile_5_msg").html("");} 
			} else {
				$("#emp2_mobile_5").css("border","1px solid #f00");
				$(".emp2_mobile_5_msg").show(); $(".emp2_mobile_5_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#emp2_mobile_5").css("border","1px solid #f00");
			//$(".emp2_mobile_5_msg").show(); $(".emp2_mobile_5_msg").html("Enter Mobile Number");
			//return false;
		}
	} 
}
});	
/* Create Mill Form Submition End *************************************************************/
		
</script>	
	
	
	
	