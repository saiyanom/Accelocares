<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("add-employee.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+-]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("add-employee.php");
		}
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Query."); redirect_to("add-employee.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Query."); redirect_to("add-employee.php");
		}
	} else {
		$session->message("Employee not found"); redirect_to("add-employee.php");
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$employee_reg = EmployeeReg::find_by_id($_GET['id']);
	} 
?>
<style>
span.err_msg {
    color: #f00;
    font-size: 12px;
    /* display: none; */
}
</style>
<div class="modal-header border-bottom-st d-block">
<!--<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<div class="form-p-hd">
	<h2>Edit Employee Details</h2>
</div>

<div class="form-p-block">
	<form action="edit-employee-db.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
	<!-- box 1 -->
	<div class="form-group">
		<label class="control-label">Employee Name</label>
		<input class="form-control form-p-box-bg1" value="<?php echo $employee_reg->emp_name; ?>" type="text" id="emp2_name" name="emp_name">
		<span class="err_msg emp2_name_msg"></span>
	</div>
		
	<div class="form-group">
		<label class="control-label">Email ID</label>
		<input class="form-control form-p-box-bg1" value="<?php echo $employee_reg->emp_email; ?>" type="text" id="emp2_email" name="emp_email">
		<span class="err_msg emp2_email_msg"></span>
	</div>
	
	<div class="form-group">
		<label class="control-label">Mobile Number</label>
		<input class="form-control form-p-box-bg1" value="<?php echo $employee_reg->emp_mobile; ?>" type="text" id="emp2_mobile" name="emp_mobile">
		<span class="err_msg emp2_mobile_msg"></span>
	</div>
	<!-- box 1 -->

	
	<div class="form-p-box form-p-boxbtn">
		<a class="fpcl" data-dismiss="modal" aria-hidden="true" href="#">Close</a>
		<input type="submit" id="edit_employees" class="fpdone" value="Update" />
	</div>

	<div class="clerfix"></div>
	</form>
</div>
</div>

<script>
$(document).ready(function() {	
	function validateEmail(email) {
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		return emailReg.test(email);
	}

/* Create Employee Form Submition *************************************************************/
$("#edit_employee").click(function() {
	if ($("#emp2_name").val() == "") {
		$("#emp2_name").css("border","1px solid #f00");
		$(".emp2_name_msg").show(); $(".emp2_name_msg").html("Enter Employee Name");
		return false;
	} else { 
		if ($.isNumeric($("#emp2_name").val())) {
			$("#emp2_name").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".emp2_name_msg").show(); $(".emp2_name_msg").html("Remove Number from Employee Name");
	  		return false;
		} else {
			$("#emp2_name").css("border","1px solid #dee2e6"); $(".emp2_name_msg").hide(); $(".emp2_name_msg").html("");
		}
	
		
		if ($("#emp2_email").val() == "") {
			$("#emp2_email").css("border","1px solid #f00");
			$(".emp2_email_msg").show(); $(".emp2_email_msg").html("Enter Employee Email");
			return false;
		} else { 
			if(!validateEmail($("#emp2_email").val())){
				$("#emp2_email").css("border","1px solid #f00");
				$(".emp2_email_msg").show(); $(".emp2_email_msg").html("Enter Valid Employee Email");
				return false;
			} else {
				$("#emp2_email").css("border","1px solid #dee2e6"); $(".emp2_email_msg").hide(); $(".emp2_email_msg").html("");
			} 
		} 

		
		if ($("#emp2_mobile").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#emp2_mobile').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#emp2_mobile").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".emp2_mobile_msg").show(); $(".emp2_mobile_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#emp2_mobile").css("border","1px solid #dee2e6"); $(".emp2_mobile_msg").hide(); $(".emp2_mobile_msg").html("");} 
			} else {
				$("#emp2_mobile").css("border","1px solid #f00");
				$(".emp2_mobile_msg").show(); $(".emp2_mobile_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#emp2_mobile").css("border","1px solid #f00");
			//$(".emp2_mobile_msg").show(); $(".emp2_mobile_msg").html("Enter Mobile Number");
			//return false;
		}

	} 
});	
/* Create Employee Form Submition End *************************************************************/
});	
</script>