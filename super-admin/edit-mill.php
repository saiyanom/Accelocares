<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	////date_default_timezone_set('Asia/Calcutta');
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }


	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("mill.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+-]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("mill.php");
		}
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Query."); redirect_to("mill.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Query."); redirect_to("mill.php");
		}
	} else {
		$session->message("Employee not found"); redirect_to("mill.php");
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$mill_reg = MillReg::find_by_id($_GET['id']);
	} 
?>
<div class="modal-header border-bottom-st d-block">
	<div class="form-p-hd">
		<h2>Edit Mill Details</h2>
	</div>

<div class="form-p-block">
	<form action="edit-mill-db.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
		<!-- box 1 -->
		<div class="form-group">
			<label class="control-label">Mill Name</label>
			<input class="form-control form-p-box-bg1" type="text" value="<?php echo $mill_reg->mill_name; ?>" id="mill2_name" name="mill_name">
			<span class="err_msg mill_name_msg"></span>
		</div>
		
		<div class="edit_mill_details">
			
			<?php if(!empty($mill_reg->name_1)){?>
			<div class="mill2_details_row mill2_details_row_1">
				<hr />
				<div class="form-group"><label class="control-label">Full Name</label><input value="<?php echo $mill_reg->name_1; ?>" class="form-control form-p-box-bg1" type="text" id="name2_1" name="name_1"><span class="err_msg name2_1_msg"></span></div>
				<div class="form-group"><label class="control-label">Email</label><input value="<?php echo $mill_reg->email_1; ?>" class="form-control form-p-box-bg1" type="text" id="email2_1" name="email_1"><span class="err_msg email2_1_msg"></span></div>
				<div class="form-group"><label class="control-label">Mobile Number</label><input value="<?php echo $mill_reg->mobile_1; ?>" class="form-control form-p-box-bg1" type="number" id="mobile2_1" name="mobile_1"><span class="err_msg mobile2_1_msg"></span></div>
				<div class="clerfix"></div>
			</div>
			<?php } if(!empty($mill_reg->name_2)){?>
			<div class="mill2_details_row mill2_details_row_2">
				<hr />
				<div class="form-group"><label class="control-label">Full Name</label><input value="<?php echo $mill_reg->name_2; ?>" class="form-control form-p-box-bg1" type="text" id="name2_2" name="name_2"><span class="err_msg name2_2_msg"></span></div>
				<div class="form-group"><label class="control-label">Email</label><input value="<?php echo $mill_reg->email_2; ?>" class="form-control form-p-box-bg1" type="text" id="email2_2" name="email_2"><span class="err_msg email2_2_msg"></span></div>
				<div class="form-group"><label class="control-label">Mobile Number</label><input value="<?php echo $mill_reg->mobile_2; ?>" class="form-control form-p-box-bg1" type="number" id="mobile2_2" name="mobile_2"><span class="err_msg mobile2_2_msg"></span></div>
				<div class="clerfix"></div>
			</div>
			<?php } if(!empty($mill_reg->name_3)){?>
			<div class="mill2_details_row mill2_details_row_3">
				<hr />
				<div class="form-group"><label class="control-label">Full Name</label><input value="<?php echo $mill_reg->name_3; ?>" class="form-control form-p-box-bg1" type="text" id="name2_3" name="name_3"><span class="err_msg name2_3_msg"></span></div>
				<div class="form-group"><label class="control-label">Email</label><input value="<?php echo $mill_reg->email_3; ?>" class="form-control form-p-box-bg1" type="text" id="email2_3" name="email_3"><span class="err_msg email2_3_msg"></span></div>
				<div class="form-group"><label class="control-label">Mobile Number</label><input value="<?php echo $mill_reg->mobile_3; ?>" class="form-control form-p-box-bg1" type="number" id="mobile2_3" name="mobile_3"><span class="err_msg mobile2_3_msg"></span></div>
				<div class="clerfix"></div>
			</div>
			<?php } if(!empty($mill_reg->name_4)){?>
			<div class="mill2_details_row mill2_details_row_4">
				<hr />
				<div class="form-group"><label class="control-label">Full Name</label><input value="<?php echo $mill_reg->name_4; ?>" class="form-control form-p-box-bg1" type="text" id="name2_4" name="name_4"><span class="err_msg name2_4_msg"></span></div>
				<div class="form-group"><label class="control-label">Email</label><input value="<?php echo $mill_reg->email_4; ?>" class="form-control form-p-box-bg1" type="text" id="email2_4" name="email_4"><span class="err_msg email2_4_msg"></span></div>
				<div class="form-group"><label class="control-label">Mobile Number</label><input value="<?php echo $mill_reg->mobile_4; ?>" class="form-control form-p-box-bg1" type="number" id="mobile2_4" name="mobile_4"><span class="err_msg mobile2_4_msg"></span></div>
				<div class="clerfix"></div>
			</div>
			<?php } if(!empty($mill_reg->name_5)){?>
			<div class="mill2_details_row mill2_details_row_5">
				<hr />
				<div class="form-group"><label class="control-label">Full Name</label><input value="<?php echo $mill_reg->name_5; ?>" class="form-control form-p-box-bg1" type="text" id="name2_5" name="name_5"><span class="err_msg name2_5_msg"></span></div>
				<div class="form-group"><label class="control-label">Email</label><input value="<?php echo $mill_reg->email_5; ?>" class="form-control form-p-box-bg1" type="text" id="email2_5" name="email_5"><span class="err_msg email2_5_msg"></span></div>
				<div class="form-group"><label class="control-label">Mobile Number</label><input value="<?php echo $mill_reg->mobile_5; ?>" class="form-control form-p-box-bg1" type="number" id="mobile2_5" name="mobile_5"><span class="err_msg mobile2_5_msg"></span></div>
				<div class="clerfix"></div>
			</div>
			<?php } ?>
		</div>
		
		<div class="input-group">
			<div class="custom-file">
				<button type="button" name="product_btn" class="fpcl btn add2_mill"><i class="mdi mdi-plus"></i> Add</button>
				&nbsp; &nbsp; 
				<button type="button" name="product_btn" class="btn fpdone rem2_mill"><i class="mdi mdi-minus"></i> Remove</button>
			</div>
		</div>
		<div class="clerfix">&nbsp;</div>

		<div class="form-p-box form-p-boxbtn">
		<a class="fpcl" data-dismiss="modal" aria-hidden="true" href="#">Close</a>
		<input type="submit" class="fpdone" id="update_mill" value="Add">
		</div>
		<div class="clerfix"></div>
	</form>
</div>
</div>
<!-- end modal-body-->

<script type="application/javascript">
$(document).ready(function() {

	function isValid(str) {
	    return !/[~`!#$%\^&*()+=\\[\]\\';,/{}|\\":<>\?]/g.test(str);
	}

	$("input, textarea").keypress(function(event) {
	    var character = String.fromCharCode(event.keyCode);
	    return isValid(character);  
	});

	function validateEmail(email) {
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		return emailReg.test(email);
	}


	$(".add2_mill").click(function (e) {
		var num = $(".mill2_details_row").length + 1;
		if(num <= 5){
			var div = "<div class='mill2_details_row mill2_details_row_"+num+"'><hr /><div class='form-group'><label class='control-label'>Full Name</label><input class='form-control form-p-box-bg1' type='text' id='name2_"+num+"' name='name_"+num+"'><span class='err_msg name2_"+num+"_msg'></span></div><div class='form-group'><label class='control-label'>Email</label><input class='form-control form-p-box-bg1' type='text' id='email2_"+num+"' name='email_"+num+"'><span class='err_msg email2_"+num+"_msg'></div><div class='form-group'><label class='control-label'>Mobile Number</label><input class='form-control form-p-box-bg1' type='number' id='mobile2_"+num+"' name='mobile_"+num+"'><span class='err_msg mobile2_"+num+"_msg'></span></div><div class='clerfix'></div></div>";
			$(".edit_mill_details").append(div);
		} 		
		e.preventDefault();
	});
	
	$(".rem2_mill").click(function (e) {
		var num = $(".mill2_details_row").length;		
		if(num >= 2){
			$(".mill2_details_row_"+ num).remove();
		}
		e.preventDefault();
	});
	


/* Edit Mill Form Submition *************************************************************/
$("#update_mill").click(function() {
	
	if ($("#mill2_name").val() == "") {
		$("#mill2_name").css("border","1px solid #f00");
		$(".mill2_name_msg").show(); $(".mill_name_msg").html("Enter Mill Name");
		return false;
	} else {
		$("#mill_name").css("border","1px solid #dee2e6"); $(".mill_name_msg").hide(); $(".mill_name_msg").html("");
	}

	if ($("#name2_1").val() == "") {
		$("#name2_1").css("border","1px solid #f00");
		$(".name2_1_msg").show(); $(".name2_1_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#name2_1").val())) {
			$("#name2_1").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".name2_1_msg").show(); $(".name2_1_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#name2_1").css("border","1px solid #dee2e6"); $(".name2_1_msg").hide(); $(".name2_1_msg").html("");
		}
	
		
		if ($("#email2_1").val() == "") {
			$("#email2_1").css("border","1px solid #f00");
			$(".email2_1_msg").show(); $(".email2_1_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#email2_1").val())){
				$("#email2_1").css("border","1px solid #f00");
				$(".email2_1_msg").show(); $(".email2_1_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#email2_1").css("border","1px solid #dee2e6"); $(".email2_1_msg").hide(); $(".email2_1_msg").html("");
			} 
		} 
		
		if ($("#mobile2_1").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#mobile2_1').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#mobile2_1").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".mobile2_1_msg").show(); $(".mobile2_1_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#mobile2_1").css("border","1px solid #dee2e6"); $(".mobile2_1_msg").hide(); $(".mobile2_1_msg").html("");} 
			} else {
				$("#mobile2_1").css("border","1px solid #f00");
				$(".mobile2_1_msg").show(); $(".mobile2_1_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#mobile2_1").css("border","1px solid #f00");
			//$(".mobile2_1_msg").show(); $(".mobile2_1_msg").html("Enter Mobile Number");
			//return false;
		}
	} 


if ($("#name2_2").val()) {
	if ($("#name2_2").val() == "") {
		$("#name2_2").css("border","1px solid #f00");
		$(".name2_2_msg").show(); $(".name2_2_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#name2_2").val())) {
			$("#name2_2").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".name2_2_msg").show(); $(".name2_2_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#name2_2").css("border","1px solid #dee2e6"); $(".name2_2_msg").hide(); $(".name2_2_msg").html("");
		}
	
		
		if ($("#email2_2").val() == "") {
			$("#email2_2").css("border","1px solid #f00");
			$(".email2_2_msg").show(); $(".email2_2_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#email2_2").val())){
				$("#email2_2").css("border","1px solid #f00");
				$(".email2_2_msg").show(); $(".email2_2_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#email2_2").css("border","1px solid #dee2e6"); $(".email2_2_msg").hide(); $(".email2_2_msg").html("");
			} 
		} 
		
		if ($("#mobile2_2").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#mobile2_2').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#mobile2_2").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".mobile2_2_msg").show(); $(".mobile2_2_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#mobile2_2").css("border","1px solid #dee2e6"); $(".mobile2_2_msg").hide(); $(".mobile2_2_msg").html("");} 
			} else {
				$("#mobile2_2").css("border","1px solid #f00");
				$(".mobile2_2_msg").show(); $(".mobile2_2_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#mobile2_2").css("border","1px solid #f00");
			//$(".mobile2_2_msg").show(); $(".mobile2_2_msg").html("Enter Mobile Number");
			//return false;
		}
	} 
}


if ($("#name2_3").val()) {
	if ($("#name2_3").val() == "") {
		$("#name2_3").css("border","1px solid #f00");
		$(".name2_3_msg").show(); $(".name2_3_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#name2_3").val())) {
			$("#name2_3").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".name2_3_msg").show(); $(".name2_3_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#name2_3").css("border","1px solid #dee2e6"); $(".name2_3_msg").hide(); $(".name2_3_msg").html("");
		}
	
		
		if ($("#email2_3").val() == "") {
			$("#email2_3").css("border","1px solid #f00");
			$(".email2_3_msg").show(); $(".email2_3_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#email2_3").val())){
				$("#email2_3").css("border","1px solid #f00");
				$(".email2_3_msg").show(); $(".email2_3_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#email2_3").css("border","1px solid #dee2e6"); $(".email2_3_msg").hide(); $(".email2_3_msg").html("");
			} 
		} 
		
		if ($("#mobile2_3").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#mobile2_3').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#mobile2_3").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".mobile2_3_msg").show(); $(".mobile2_3_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#mobile2_3").css("border","1px solid #dee2e6"); $(".mobile2_3_msg").hide(); $(".mobile2_3_msg").html("");} 
			} else {
				$("#mobile2_3").css("border","1px solid #f00");
				$(".mobile2_3_msg").show(); $(".mobile2_3_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#mobile2_3").css("border","1px solid #f00");
			//$(".mobile2_3_msg").show(); $(".mobile2_3_msg").html("Enter Mobile Number");
			//return false;
		}
	} 
}


if ($("#name2_4").val()) {
	if ($("#name2_4").val() == "") {
		$("#name2_4").css("border","1px solid #f00");
		$(".name2_4_msg").show(); $(".name2_4_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#name2_4").val())) {
			$("#name2_4").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".name2_4_msg").show(); $(".name2_4_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#name2_4").css("border","1px solid #dee2e6"); $(".name2_4_msg").hide(); $(".name2_4_msg").html("");
		}
	
		
		if ($("#email2_4").val() == "") {
			$("#email2_4").css("border","1px solid #f00");
			$(".email2_4_msg").show(); $(".email2_4_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#email2_4").val())){
				$("#email2_4").css("border","1px solid #f00");
				$(".email2_4_msg").show(); $(".email2_4_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#email2_4").css("border","1px solid #dee2e6"); $(".email2_4_msg").hide(); $(".email2_4_msg").html("");
			} 
		} 
		
		if ($("#mobile2_4").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#mobile2_4').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#mobile2_4").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".mobile2_4_msg").show(); $(".mobile2_4_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#mobile2_4").css("border","1px solid #dee2e6"); $(".mobile2_4_msg").hide(); $(".mobile2_4_msg").html("");} 
			} else {
				$("#mobile2_4").css("border","1px solid #f00");
				$(".mobile2_4_msg").show(); $(".mobile2_4_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#mobile2_4").css("border","1px solid #f00");
			//$(".mobile2_4_msg").show(); $(".mobile2_4_msg").html("Enter Mobile Number");
			//return false;
		}
	} 
}


if ($("#name2_5").val()) {
	if ($("#name2_5").val() == "") {
		$("#name2_5").css("border","1px solid #f00");
		$(".name2_5_msg").show(); $(".name2_5_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#name2_5").val())) {
			$("#name2_5").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".name2_5_msg").show(); $(".name2_5_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#name2_5").css("border","1px solid #dee2e6"); $(".name2_5_msg").hide(); $(".name2_5_msg").html("");
		}
	
		
		if ($("#email2_5").val() == "") {
			$("#email2_5").css("border","1px solid #f00");
			$(".email2_5_msg").show(); $(".email2_5_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#email2_5").val())){
				$("#email2_5").css("border","1px solid #f00");
				$(".email2_5_msg").show(); $(".email2_5_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#email2_5").css("border","1px solid #dee2e6"); $(".email2_5_msg").hide(); $(".email2_5_msg").html("");
			} 
		} 
		
		if ($("#mobile2_5").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#mobile2_5').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#mobile2_5").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".mobile2_5_msg").show(); $(".mobile2_5_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#mobile2_5").css("border","1px solid #dee2e6"); $(".mobile2_5_msg").hide(); $(".mobile2_5_msg").html("");} 
			} else {
				$("#mobile2_5").css("border","1px solid #f00");
				$(".mobile2_5_msg").show(); $(".mobile2_5_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#mobile2_5").css("border","1px solid #f00");
			//$(".mobile2_5_msg").show(); $(".mobile2_5_msg").html("Enter Mobile Number");
			//return false;
		}
	} 
}
});	
/* Edit Mill Form Submition End *************************************************************/

});
</script>	


