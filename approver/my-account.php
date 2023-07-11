<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("my-account.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+-]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("my-account.php");
		}
	}

	if ($session->is_employee_logged_in()){ 
		$employee_reg = EmployeeReg::find_by_id($session->employee_id);

		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != 'Employee' Limit 1";

		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);

		if(!$employee_location){
			redirect_to("logout.php?"); 
		}
	} else { redirect_to("logout.php"); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Mahindra Accelo CRM</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content=" " name="description" />
<meta content="Coderthemes" name="author" />

<style>
	.container-group{transform: translate(130px, 10px) !important;}
	.bar-chart .y-axis-group .tick text {font-size: 12px !important;}
	.apexcharts-tooltip.light.active{ display:none!important; opacity:0.0!important}
	span.err_msg{
		color: #f00;
		font-size: 12px;
		/*display: none;*/
	}
</style>

</head>
<!-- sidebar-enable -->
<body class="larged" data-keep-enlarged="true">

<!-- Begin page -->
<div class="wrapper">

<!-- ========== LEFT HEADER Sidebar Start ========== -->
<?php include 'left-header.php'?>
<!-- ========== LEFT HEADER Sidebar Start ========== -->

<!-- ============================================================== --><!-- Start Page Content here --><!-- ============================================================== -->

<div class="content-page">
<div class="content">

<!-- ========== TOP Sidebar Start ========== -->
<?php include 'top-header.php'?>
<!-- ========== TOP Sidebar Start ========== -->



<!-- Start Content-->
<div class="container-fluid">
	<div class="clear-fix">&nbsp;</div>
	<div class="row">
		<div class="col-sm-12">
			
			<?php  $message = output_message($message); ?>
			<div class="alert fade show text-white <?php 
				if($message == "Password Updated Successfully."){echo "bg-success";} 
				else if($message == "Mobile Number Updated Successfully."){echo "bg-success";} 
				else {echo "bg-danger";}?>" 
			<?php if(empty($message)){echo " style='display:none';";} else {echo " style='margin-top:20px';";} ?> >
			<a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
			<?php echo $message; ?>
			</div>

			<!-- Profile -->
			<div class="card">
				<div class="card-body profile-user-box">

					<div class="row">
						<div class="col-sm-8">
							<div class="media">
								<div class="media-body">
									<h4 class="mt-1 mb-1"><?php echo $employee_reg->emp_name;?></h4>
								</div> <!-- end media-body-->
							</div>
						</div> <!-- end col-->

						<div class="col-sm-4">
							<div class="text-center mt-sm-0 mt-3 text-sm-right">
								<button type="button" class="btn btn-success" data-toggle="modal" data-target="#update_password">
									<i class="mdi mdi-textbox-password mr-1"></i> Update Password
								</button>
							</div>
						</div> <!-- end col-->
					</div> <!-- end row -->
					
					<div class="clearfix">&nbsp;</div>
					<div class="text-left">

						<p class="text-muted">
							<strong>MOBILE :</strong><span class="ml-2"><?php echo $employee_reg->emp_mobile;?></span>
							&nbsp; &nbsp; <i data-toggle="modal" data-target="#edit_mobile" title="Edit Mobile Number" class="mdi mdi-square-edit-outline text-success"></i>
						</p>

						<p class="text-muted"><strong>EMAIL :</strong> <span class="ml-2"><?php echo $employee_reg->emp_email;?></span></p>

						<p class="text-muted"><strong>LOCATION :</strong> <span class="ml-2"><?php echo $employee_reg->location;?></span></p>

						<p class="text-muted"><strong>ROLE :</strong> <span class="ml-2"><?php echo $employee_reg->emp_role;?></span></p>						

					</div>

				</div> <!-- end card-body/ profile-user-box-->
			</div><!--end profile/ card -->
			
			
			
		</div> <!-- end col-->
	</div>
	<!-- end row -->






</div>
<!-- container -->


</div>
<!-- content -->

<!-- Footer Start -->
<?php include 'footer.php'?>
<!-- end Footer -->
</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->
</div>
<!-- END wrapper -->


</body>
</html>
<!-- Add New Event MODAL -->
<div class="modal fade" id="update_password" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="update-password-db.php" method="post" enctype="multipart/form-data" autocomplete="off">
			<div class="modal-header pr-4 pl-4 border-bottom-0 d-block">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
				<h4 class="modal-title">Update Password</h4>
			</div>
			<div class="modal-body pt-3 pr-4 pl-4">
        		<div class='row'>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label class='control-label'>Old Password</label>
							<input type='password' id="old_password" placeholder='******' class="form-control"/>
							<input type='hidden' class="old_password" name='old_password' class="form-control"/>
							<span class="err_msg old_password_msg"></span>
						</div>
					</div>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label class='control-label'>New Password</label>
							<input class='form-control' placeholder='******' type='password' id='new_password'/>
							<input type='hidden' class="new_password" name='new_password' class="form-control"/>
							<span class="err_msg new_password_msg"></span>
						</div>
					</div>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label class='control-label'>Retype Password</label>
							<input class='form-control' type='password' placeholder='******' id='retype_password'/>
							<input type='hidden' class="retype_password" name='retype_password' class="form-control"/>
							<span class="err_msg retype_password_msg"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="text-right pb-4 pr-4 evet-btn-min">
				<button type="button" class="btn evet-btn evet-btn-col1" data-dismiss="modal">Close</button>
				<input type="submit" name="complaint_meeting" class="btn btn-danger save-event update_password evet-btn evet-btn-col2" value="Update" />
			</div>
			</form>
		</div> <!-- end modal-content-->
	</div> <!-- end modal dialog-->
</div>
<!-- end modal-->	


<!-- Add New Event MODAL -->
<div class="modal fade" id="edit_mobile" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="update-mobile-db.php" method="post" enctype="multipart/form-data" autocomplete="off">
			<div class="modal-header pr-4 pl-4 border-bottom-0 d-block">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
				<h4 class="modal-title">Update Mobile Number</h4>
			</div>
			<div class="modal-body pt-3 pr-4 pl-4">
        		<div class='row'>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label class='control-label'>Mobile Number</label>
							<input type='number' min="0" id="mobile" placeholder='' name='mobile' value='<?php echo $employee->emp_mobile;?>' class="form-control"/>
							<span class="err_msg mobile_msg"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="text-right pb-4 pr-4 evet-btn-min">
				<button type="button" class="btn evet-btn evet-btn-col1" data-dismiss="modal">Close</button>
				<input type="submit" name="complaint_meeting" class="btn btn-danger save-event update_mobile  evet-btn evet-btn-col2" value="Update" />
			</div>
			</form>
		</div> <!-- end modal-content-->
	</div> <!-- end modal dialog-->
</div>
<!-- end modal-->	

<script src="assets/js/sha256.js"></script>
<script>
	$("#old_password").keyup(function () {
	    var value = $(this).val(); $(".old_password").val(sha256_digest(value));
	}).keyup();

	$("#new_password").keyup(function () {
	    var value = $(this).val(); $(".new_password").val(sha256_digest(value));
	}).keyup();

	$("#retype_password").keyup(function () {
	    var value = $(this).val(); $(".retype_password").val(sha256_digest(value));
	}).keyup();

	$(".update_password").click(function (e) {
		
		if ($("#old_password").val() == "") {
			$("#old_password").css("border","1px solid #f00");
			$(".old_password_msg").show(); $(".old_password_msg").html("Enter Old Password");
		  	return false;
		} else {
			$("#old_password").css("border","1px solid #dee2e6"); $(".old_password_msg").hide(); $(".old_password_msg").html("");
		} 

		if ($("#old_password").val().length < 6) {
			$("#old_password").css("border","1px solid #f00");
			$(".old_password_msg").show(); $(".old_password_msg").html("Enter Minimum 6 digit Password");
		  	return false;
		} else {
			$("#old_password").css("border","1px solid #dee2e6"); $(".old_password_msg").hide(); $(".old_password_msg").html("");
		} 

		
		if ($("#new_password").val() == "") {
			$("#new_password").css("border","1px solid #f00");
			$(".new_password_msg").show(); $(".new_password_msg").html("Enter New Password");
		  	return false;
		} else {
			$("#new_password").css("border","1px solid #dee2e6"); $(".new_password_msg").hide(); $(".new_password_msg").html("");
		} 

		if ($("#new_password").val().length < 6) {
			$("#new_password").css("border","1px solid #f00");
			$(".new_password_msg").show(); $(".new_password_msg").html("Enter Minimum 6 digit New Password");
		  	return false;
		} else {
			$("#new_password").css("border","1px solid #dee2e6"); $(".new_password_msg").hide(); $(".new_password_msg").html("");
		} 

		if ($("#retype_password").val() == "") {
			$("#retype_password").css("border","1px solid #f00");
			$(".retype_password_msg").show(); $(".retype_password_msg").html("Enter Retype Password");
		  	return false;
		} else {
			$("#retype_password").css("border","1px solid #dee2e6"); $(".retype_password_msg").hide(); $(".retype_password_msg").html("");
		} 

		if ($("#retype_password").val().length < 6) {
			$("#retype_password").css("border","1px solid #f00");
			$(".retype_password_msg").show(); $(".retype_password_msg").html("Enter Minimum 6 digit Retype Password");
		  	return false;
		} else {
			$("#retype_password").css("border","1px solid #dee2e6"); $(".retype_password_msg").hide(); $(".retype_password_msg").html("");
		} 

		if ($("#new_password").val() !=  $("#retype_password").val()) {
			$("#retype_password").css("border","1px solid #f00");
			$(".retype_password_msg").show(); $(".retype_password_msg").html("New Password & Retype Password not matched");
		  	return false;
		} else {
			$("#retype_password").css("border","1px solid #dee2e6"); $(".retype_password_msg").hide(); $(".retype_password_msg").html("");
		} 
		
	});	

	$(".update_mobile").click(function (e) {
		
		if ($("#mobile").val() == "") {
			$("#mobile").css("border","1px solid #f00");
		  	//alert("Enter Employee Mobile");
			$(".mobile_msg").show(); $(".mobile_msg").html("Enter Mobile Number");
		  	return false;
		}
		if ($("#mobile").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#mobile').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#mobile").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
				    $(".mobile_msg").show(); $(".mobile_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#mobile").css("border","1px solid #dee2e6"); $(".mobile_msg").hide(); $(".mobile_msg").html("");} 
			} else {
				$("#mobile").css("border","1px solid #f00");
				//alert("Enter valid Mobile Number");
				$(".mobile_msg").show(); $(".mobile_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			$("#mobile").css("border","1px solid #f00");
			//alert("Enter Mobile Number");
			$(".mobile_msg").show(); $(".mobile_msg").html("Enter Mobile Number");
			return false;
		}
		
	});	


	$("#emp_leave").change(function() {
		
		if(this.checked) {
			var emp_leave = "Active";
		} else {
			var emp_leave = "Deactive"
		}
		
		$.post( "emp-leave-db.php", { status: emp_leave })
			.done(function( data ) {
			//alert( data );
			$('#success-alert-modal .modal-body p').text(data);
			$('#success-alert-modal').modal('show');
		});
		
	});
</script>	