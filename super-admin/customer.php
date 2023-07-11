<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindraaccelo Customer</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content=" " name="description" />
<meta content="Coderthemes" name="author" />
<!-- third party css -->
<link href="assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
<link href="assets/css/vendor/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
<link href="assets/css/vendor/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
<link href="assets/css/vendor/select.bootstrap4.css" rel="stylesheet" type="text/css" />
        <!-- third party css end -->

<style>
   	
   #my-complaints_filter{position: absolute; right: 340px; top: 23px; display: none;}

	.dt-buttons {float:right !important; margin: -44px 0 0 0; height: 35px;}
	.dt-buttons button{background: #71bf44 !important; border-color: #71bf44; border-radius: 4px;}
	.dt-buttons button:hover{background:#26990A !important; border-color: #26990A;}
	
	.basic-datatable tr td, .basic-datatable tr th {
		padding: 5px 30px 5px 5px !important;
		text-align: left;
	}
	table.dataTable thead .sorting:before, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc_disabled:before {
		top: 8px !important;
	}
	table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_desc_disabled:after {
		top: 2px !important;
	}
	span.err_msg {
	    color: #f00;
	    font-size: 12px;
	    display: none;
	}
	
	#customer_company {
		width:300px !important;
	}
	
	#customer_company .select2-container {
		width: 100% !important;
	}
	
	.srcbtnd {
		float: right;
		width: 21.5% !important;
	}

	input.btn-primary, input.btn-light {
		margin-right: 4px;
	}
	.fc-right{ display:none}
	.fc-center{ float:right}
	.fc-today-button{ display:none}
	.back-btn { padding: 0 !important;}
	.mdi-keyboard-backspace {
		font-size: 24px;
		color: #0acf97;
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

<!-- start page title -->
     
<!-- end page title --> 
<div>&nbsp;</div>		
<?php  $message = output_message($message); ?>
<div class="alert fade show text-white <?php 
	if($message == "Customer Added Successfully."){echo "bg-success";} 
	else if($message == "Status Updated Successfully."){echo "bg-success";} 		
	else if($message == "Customer Updated Successfully."){echo "bg-success";} 		
	else {echo "bg-danger";}?>" 
	<?php if(empty($message)){echo "style='display:none;'";}?>>
	<a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
	<?php echo $message; ?>
</div>

<div class=" ">
<div class="col-12">

<div class="bord-box">
<div class="card-body">
<div class="al-com">
<div class="compl-lef"><h4>Search</h4></div>
<div class="clerfix"></div>
</div>


<div class="form-block">
<form>

<ul class="form-block-con">
<li id="customer_company">
	
	<?php
		if(isset($_GET['company'])){
	?>
		<a class="btn btn-default back-btn" href="customer.php"><i class="mdi mdi-keyboard-backspace"></i></a>
	<?php
		}
	?>

<select id="company" name="company" class="form-control select2" data-toggle="select2">
	<option value="">- Select Company -</option>
	<option value="New">New</option>
	<?php
		$company_reg = CompanyReg::find_all();
		foreach($company_reg as $company_reg){
			echo "<option value='{$company_reg->id}'>{$company_reg->customer_id} - {$company_reg->company_name}</option>";
		}
	?>
</select>
</li>


<li class="" style="float:right;">
<div class="form-group mb-0 text-center log-btn">
<button class="btn btn-primary btn-block" type="submit">Search <i class="mdi mdi-magnify"></i></button>
</div></li>

<div class="clerfix"></div>

</ul>


</form>
</div>

</div>
</div>
	
	
<div class="bord-box">
<div class="card-body">
<div class="al-com">
<div class="compl-lef"><h4>All Type of Customer</h4></div>
<div class="compl-rig02">
<ul class="adblock">
<li class="colgr-1 "><a href="#" data-toggle="modal" data-target="#add-new"><i class="mdi mdi-plus-circle-outline"></i> Add New</a></li>
<div class="clerfix"></div>
</ul>
</div>
<div class="clerfix"></div>
</div>

<table id="my-complaints" class="table dt-responsive nowrap basic-datatable" width="100%">
	<thead>
		<tr>
			<th>Sr. No</th>
			<th>Customer Id </th>
			<th>Company Name</th>
			<th>Password</th>
			<th style="display: none;">Employee Name</th>
			<th style="display: none;">Employee Email</th>
			<th style="display: none;">Employee Mobile</th>
			<th style="display: none;">Employee Name</th>
			<th style="display: none;">Employee Email</th>
			<th style="display: none;">Employee Mobile</th>
			<th style="display: none;">Employee Name</th>
			<th style="display: none;">Employee Email</th>
			<th style="display: none;">Employee Mobile</th>
			<th style="display: none;">Employee Name</th>
			<th style="display: none;">Employee Email</th>
			<th style="display: none;">Employee Mobile</th>
			<th style="display: none;">Employee Name</th>
			<th style="display: none;">Employee Email</th>
			<th style="display: none;">Employee Mobile</th>			
			<th>Status</th>
			<th>Action</th>
			<th>View</th>
		</tr>
	</thead>

<tbody>
	
<?php
if(isset($_GET['company']) && !empty($_GET['company'])){

	if($_GET['company'] == "New"){
		$sql = "Select * from company_reg where customer_id LIKE '%{$_GET['company']}%' order by customer_id ASC";
	} else {
		$sql = "Select * from company_reg where id = '{$_GET['company']}' order by customer_id ASC";
	}

	$company_reg = CompanyReg::find_by_sql($sql);
	
	$num = 0;
	foreach ($company_reg as $company_reg) {
		$num++;
		echo "<tr>";
		echo "<td>".$num."</td>";
		echo "<td>".$company_reg->customer_id."</td>";
		echo "<td>".$company_reg->company_name."</td>";
		echo "<td class='password'><span style='display:none;' class='pass'>".$company_reg->password."</span><span class='hash'>******</span></td>";
		echo "<td style='display: none;'>".$company_reg->emp_name_1."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_email_1."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_mobile_1."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_name_2."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_email_2."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_mobile_2."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_name_3."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_email_3."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_mobile_3."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_name_4."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_email_4."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_mobile_4."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_name_5."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_email_5."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_mobile_5."</td>";
		echo "<td><a class='strri update_status ";
		if($company_reg->status == 1){echo "col1";} else { echo "col2"; }
		echo "' href='update-customer-status.php?id={$company_reg->id}'><i class='mdi mdi-check-circle-outline'></i></a><a class='strri update_status ";
		if($company_reg->status == 0){echo "col3";} else { echo "col2"; }
		echo "' href='update-customer-status.php?id={$company_reg->id}'><i class='mdi mdi-close-circle-outline'></i></a></td>";
		echo "<td><a href='#' class='edit_customer' data-id='{$company_reg->id}' data-toggle='modal' data-target='#edit-new'>Edit</a></td>";
		echo "<td><a href='#' class='view_customer' data-id='{$company_reg->id}' data-toggle='modal' data-target='#edit-new'>View</a></td>";
		echo "</tr>";
	}
	
} else {
	$company_reg = CompanyReg::find_all();
	
	$num = 0;
	foreach($company_reg as $company_reg){
		$num++;
		echo "<tr>";
		echo "<td>".$num."</td>";
		echo "<td>".$company_reg->customer_id."</td>";
		echo "<td>".$company_reg->company_name."</td>";
		echo "<td class='password'><span style='display:none;' class='pass'>".$company_reg->password."</span><span class='hash'>******</span></td>";
		echo "<td style='display: none;'>".$company_reg->emp_name_1."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_email_1."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_mobile_1."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_name_2."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_email_2."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_mobile_2."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_name_3."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_email_3."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_mobile_3."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_name_4."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_email_4."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_mobile_4."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_name_5."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_email_5."</td>";
		echo "<td style='display: none;'>".$company_reg->emp_mobile_5."</td>";
		echo "<td><a class='strri update_status ";
		if($company_reg->status == 1){echo "col1";} else { echo "col2"; }
		echo "' href='update-customer-status.php?id={$company_reg->id}'><i class='mdi mdi-check-circle-outline'></i></a><a class='strri update_status ";
		if($company_reg->status == 0){echo "col3";} else { echo "col2"; }
		echo "' href='update-customer-status.php?id={$company_reg->id}'><i class='mdi mdi-close-circle-outline'></i></a></td>";
		echo "<td><a href='#' class='edit_customer' data-id='{$company_reg->id}' data-toggle='modal' data-target='#edit-new'>Edit</a></td>";
		echo "<td><a href='#' class='view_customer' data-id='{$company_reg->id}' data-toggle='modal' data-target='#edit-new'>View</a></td>";
		echo "</tr>";
	}
}


?>

<!--<tr>
<td>01</td>
<td>Tata Steel</td>
<td>Abhishek Agarwal</td>
<td>abhishek.agrawal@tatasteel.com</td>
<td>+91 73505 26434</td>
<td>-</td>
<td>-</td>

<td>
<a class="strri col1" href="#"><i class="mdi mdi-check-circle-outline"></i></a> 
<a class="strri col2" href="#"><i class="mdi mdi-close-circle-outline"></i></a></td>
<td><a href="#">Edit</a></td>
</tr>-->


</tbody>

</table>
</div>
</div>
 <!-- end card body-->
</div> <!-- end card -->
</div><!-- end col-->
</div>
<!-- end row-->


</div>
<!-- container -->


</div>
<!-- content -->

<!-- Footer Start -->
<?php include 'footer.php'?>
<!-- end Footer -->
</div>




<!-- Form pop up -->
<div class="modal fade fomall" id="add-new" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header border-bottom-st d-block">
				<!--<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>-->
				<div class="form-p-hd">
					<h2>Add New Customer</h2>
				</div>

				<div class="form-p-block">
					<form action="customer-add-db.php" method="post" enctype="multipart/form-data" autocomplete="off">
					<div class="form-group">
						<label class="control-label">Company Name</label>
						<input class="form-control form-p-box-bg1" placeholder="" type="text" id="company_name" name="company_name">
						<span class="err_msg company_name_msg"></span>
					</div>
					<ul class="ad-lr">
						<div class="form-group"><label class="control-label">Customer Id</label><input class="form-control form-p-box-bg1" placeholder="" type="text" id="customer_id" name="customer_id"><span class="err_msg customer_id_msg"></span></div>
						<li class="adl1"><div class="form-group"><label class="control-label">Password</label><input class="form-control form-p-box-bg1" placeholder="" type="password" id="password"><input class="form-control form-p-box-bg1" placeholder="" type="hidden" id="user_password" name="password"><span class="err_msg password_msg"></span></div></li>						
						<li class="adr1"><div class="form-group"><label class="control-label">Retype Password</label><input class="form-control form-p-box-bg1" placeholder="" type="password" id="re_password"><input class="form-control form-p-box-bg1" placeholder="" type="hidden" id="user_re_password" name="re_password"><span class="err_msg re_password_msg"></span></div></li>
					</ul>
					<div class="clerfix"></div>
					
					<div class="cust_details">
						<div class="cust_details_row cust_details_row_1">
							<hr />
							<div class="form-group"><label class="control-label">Full Name</label><input class="form-control form-p-box-bg1" type="text" id="emp_name_1" name="emp_name_1"><span class="err_msg emp_name_1_msg"></span></div>
							<div class="form-group"><label class="control-label">Email</label><input class="form-control form-p-box-bg1" type="text" id="emp_email_1" name="emp_email_1"><span class="err_msg emp_email_1_msg"></span></div>
							<div class="form-group"><label class="control-label">Mobile Number</label><input class="form-control form-p-box-bg1" type="number" id="emp_mobile_1" name="emp_mobile_1"><span class="err_msg emp_mobile_1_msg"></span></div>
							<div class="clerfix"></div>
						</div>
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
						<input type="submit" id="create_customer" class="fpdone" value="Add">
					</div>

					<div class="clerfix"></div>
					</form>
				</div>
			</div>

		<!-- end modal-body-->
		</div> <!-- end modal-content-->
	</div> <!-- end modal dialog-->
</div>
<!-- Form pop up -->
	
	
<!-- Form pop up -->
<div class="modal fade fomall" id="edit-new" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			

		<!-- end modal-body-->
		</div> <!-- end modal-content-->
	</div> <!-- end modal dialog-->
</div>
<!-- Form pop up -->



<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->
<!-- END wrapper -->
<!-- third party js -->
<script src="assets/js/vendor/jquery.dataTables.js"></script>
<script src="assets/js/vendor/dataTables.bootstrap4.js"></script>
<script src="assets/js/vendor/dataTables.responsive.min.js"></script>
<script src="assets/js/vendor/responsive.bootstrap4.min.js"></script>
<script src="assets/js/vendor/dataTables.buttons.min.js"></script>
<script src="assets/js/vendor/buttons.bootstrap4.min.js"></script>
<script src="assets/js/vendor/buttons.html5.min.js"></script>
<script src="assets/js/vendor/buttons.flash.min.js"></script>
<script src="assets/js/vendor/buttons.print.min.js"></script>
<script src="assets/js/vendor/dataTables.keyTable.min.js"></script>
<script src="assets/js/vendor/dataTables.select.min.js"></script>
<!-- third party js ends -->
<!-- demo app -->
<script src="assets/js/pages/demo.datatable-init.js"></script>
<!-- end demo js-->
<script src="assets/js/sha256.js"></script>
<script type="text/javascript">

	$(document).ready(function() {
		
		$('#my-complaints').DataTable( {
			"searching": true,
			scrollCollapse: false,
			autoWidth: false,
			responsive: false,
			"scrollX": true,

			columnDefs: [{
				targets: "0",
				orderable: false,
			}],
			"bSort" : true,
			dom: 'Bfrtip',
			buttons: [{
	           extend: 'csv',
	            exportOptions: {
	                columns: [0,1,2,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18]
	            }	          
	       }],
			"lengthMenu": [[50, 25, 50, -1], [50, 25, 50, "All"]],
			"language": {
				"info": "_START_-_END_ of _TOTAL_ entries",
				searchPlaceholder: "Search"
			},
		} );
		
		$('.buttons-csv span').html('Download Excel');
	

		$(".pass").hide();
		$(".hash").show();
	});
	
	$('.password').click(function() {
		//$(this).children().toggle();
		$(".pass",this).toggle();
		$(".hash",this).toggle();
	});
	
	$('.edit_customer').click(function() {
		var data_id = $(this).attr('data-id');
		//alert(data_id);
		$("#edit-new .modal-content").load("edit-customer.php?id="+data_id);
	});
	
	$('.view_customer').click(function() {
		var data_id = $(this).attr('data-id');
		//alert(data_id);
		$("#edit-new .modal-content").load("view-customer.php?id="+data_id);
	});
	
	$(".update_status").click(function(e) {
		if (confirm('Status Update Confirmation')) {
			return true;
		} else {
			return false;
		}
		e.prevedefault();
	});

/* Create Mill Form Submition *************************************************************/

	$("#password").keyup(function () {
	    var value = $(this).val();
	    $("#user_password").val(sha256_digest(value));
	}).keyup();
	
	$("#re_password").keyup(function () {
	    var value = $(this).val();
	    $("#user_re_password").val(sha256_digest(value));
	}).keyup();

	

	function validateEmail(email) {
		var email = request.email.replace(/\'/g,'&apos;');
		
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		return emailReg.test(email);
	}

$("#create_customer").click(function() {
	
	if ($("#company_name").val() == "") {
		$("#company_name").css("border","1px solid #f00");
		$(".company_name_msg").show(); $(".company_name_msg").html("Enter Company Name");
		return false;
	} else {
		$("#company_name").css("border","1px solid #dee2e6"); $(".company_name_msg").hide(); $(".company_name_msg").html("");
	}

	if ($("#customer_id").val() == "") {
		$("#customer_id").css("border","1px solid #f00");
		$(".customer_id_msg").show(); $(".customer_id_msg").html("Enter Customer ID");
		return false;
	} else {
		$("#customer_id").css("border","1px solid #dee2e6"); $(".customer_id_msg").hide(); $(".customer_id_msg").html("");
	}


	if ($("#password").val() == "") {
		$("#password").css("border","1px solid #f00");
		$(".password_msg").show(); $(".password_msg").html("Enter Password");
	  	return false;
	} else {
		$("#password").css("border","1px solid #dee2e6"); $(".password_msg").hide(); $(".password_msg").html("");
	} 

	if ($("#password").val().length < 6) {
		$("#password").css("border","1px solid #f00");
		$(".password_msg").show(); $(".password_msg").html("Enter Minimum 6 digit Password");
	  	return false;
	} else {
		$("#password").css("border","1px solid #dee2e6"); $(".password_msg").hide(); $(".password_msg").html("");
	} 

	if ($("#re_password").val() == "") {
		$("#re_password").css("border","1px solid #f00");
		$(".re_password_msg").show(); $(".re_password_msg").html("Enter Retype Password");
	  	return false;
	} else {
		$("#re_password").css("border","1px solid #dee2e6"); $(".re_password_msg").hide(); $(".re_password_msg").html("");
	} 

	if ($("#re_password").val().length < 6) {
		$("#re_password").css("border","1px solid #f00");
		$(".re_password_msg").show(); $(".re_password_msg").html("Enter Minimum 6 digit Retype Password");
	  	return false;
	} else {
		$("#re_password").css("border","1px solid #dee2e6"); $(".re_password_msg").hide(); $(".re_password_msg").html("");
	} 

	if ($("#password").val() !=  $("#re_password").val()) {
		$("#re_password").css("border","1px solid #f00");
		$(".re_password_msg").show(); $(".re_password_msg").html("Password & Retype Password not matched");
	  	return false;
	} else {
		$("#re_password").css("border","1px solid #dee2e6"); $(".re_password_msg").hide(); $(".re_password_msg").html("");
	} 

	
	

	if ($("#emp_name_1").val() == "") {
		$("#emp_name_1").css("border","1px solid #f00");
		$(".emp_name_1_msg").show(); $(".emp_name_1_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#emp_name_1").val())) {
			$("#emp_name_1").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".emp_name_1_msg").show(); $(".emp_name_1_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#emp_name_1").css("border","1px solid #dee2e6"); $(".emp_name_1_msg").hide(); $(".emp_name_1_msg").html("");
		}
	
		
		if ($("#emp_email_1").val() == "") {
			$("#emp_email_1").css("border","1px solid #f00");
			$(".emp_email_1_msg").show(); $(".emp_email_1_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#emp_email_1").val())){
				$("#emp_email_1").css("border","1px solid #f00");
				$(".emp_email_1_msg").show(); $(".emp_email_1_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#emp_email_1").css("border","1px solid #dee2e6"); $(".emp_email_1_msg").hide(); $(".emp_email_1_msg").html("");
			} 
		} 
		
		if ($("#emp_mobile_1").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#emp_mobile_1').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#emp_mobile_1").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".emp_mobile_1_msg").show(); $(".emp_mobile_1_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#emp_mobile_1").css("border","1px solid #dee2e6"); $(".emp_mobile_1_msg").hide(); $(".emp_mobile_1_msg").html("");} 
			} else {
				$("#emp_mobile_1").css("border","1px solid #f00");
				$(".emp_mobile_1_msg").show(); $(".emp_mobile_1_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#emp_mobile_1").css("border","1px solid #f00");
			//$(".emp_mobile_1_msg").show(); $(".emp_mobile_1_msg").html("Enter Mobile Number");
			//return false;
		}
	} 


if ($("#emp_name_2").val()) {
	if ($("#emp_name_2").val() == "") {
		$("#emp_name_2").css("border","1px solid #f00");
		$(".emp_name_2_msg").show(); $(".emp_name_2_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#emp_name_2").val())) {
			$("#emp_name_2").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".emp_name_2_msg").show(); $(".emp_name_2_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#emp_name_2").css("border","1px solid #dee2e6"); $(".emp_name_2_msg").hide(); $(".emp_name_2_msg").html("");
		}
	
		
		if ($("#emp_email_2").val() == "") {
			$("#emp_email_2").css("border","1px solid #f00");
			$(".emp_email_2_msg").show(); $(".emp_email_2_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#emp_email_2").val())){
				$("#emp_email_2").css("border","1px solid #f00");
				$(".emp_email_2_msg").show(); $(".emp_email_2_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#emp_email_2").css("border","1px solid #dee2e6"); $(".emp_email_2_msg").hide(); $(".emp_email_2_msg").html("");
			} 
		} 
		
		if ($("#emp_mobile_2").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#emp_mobile_2').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#emp_mobile_2").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".emp_mobile_2_msg").show(); $(".emp_mobile_2_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#emp_mobile_2").css("border","1px solid #dee2e6"); $(".emp_mobile_2_msg").hide(); $(".emp_mobile_2_msg").html("");} 
			} else {
				$("#emp_mobile_2").css("border","1px solid #f00");
				$(".emp_mobile_2_msg").show(); $(".emp_mobile_2_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#emp_mobile_2").css("border","1px solid #f00");
			//$(".emp_mobile_2_msg").show(); $(".emp_mobile_2_msg").html("Enter Mobile Number");
			//return false;
		}
	} 
}


if ($("#emp_name_3").val()) {
	if ($("#emp_name_3").val() == "") {
		$("#emp_name_3").css("border","1px solid #f00");
		$(".emp_name_3_msg").show(); $(".emp_name_3_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#emp_name_3").val())) {
			$("#emp_name_3").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".emp_name_3_msg").show(); $(".emp_name_3_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#emp_name_3").css("border","1px solid #dee2e6"); $(".emp_name_3_msg").hide(); $(".emp_name_3_msg").html("");
		}
	
		
		if ($("#emp_email_3").val() == "") {
			$("#emp_email_3").css("border","1px solid #f00");
			$(".emp_email_3_msg").show(); $(".emp_email_3_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#emp_email_3").val())){
				$("#emp_email_3").css("border","1px solid #f00");
				$(".emp_email_3_msg").show(); $(".emp_email_3_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#emp_email_3").css("border","1px solid #dee2e6"); $(".emp_email_3_msg").hide(); $(".emp_email_3_msg").html("");
			} 
		} 
		
		if ($("#emp_mobile_3").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#emp_mobile_3').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#emp_mobile_3").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".emp_mobile_3_msg").show(); $(".emp_mobile_3_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#emp_mobile_3").css("border","1px solid #dee2e6"); $(".emp_mobile_3_msg").hide(); $(".emp_mobile_3_msg").html("");} 
			} else {
				$("#emp_mobile_3").css("border","1px solid #f00");
				$(".emp_mobile_3_msg").show(); $(".emp_mobile_3_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#emp_mobile_3").css("border","1px solid #f00");
			//$(".emp_mobile_3_msg").show(); $(".emp_mobile_3_msg").html("Enter Mobile Number");
			//return false;
		}
	} 
}


if ($("#emp_name_4").val()) {
	if ($("#emp_name_4").val() == "") {
		$("#emp_name_4").css("border","1px solid #f00");
		$(".emp_name_4_msg").show(); $(".emp_name_4_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#emp_name_4").val())) {
			$("#emp_name_4").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".emp_name_4_msg").show(); $(".emp_name_4_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#emp_name_4").css("border","1px solid #dee2e6"); $(".emp_name_4_msg").hide(); $(".emp_name_4_msg").html("");
		}
	
		
		if ($("#emp_email_4").val() == "") {
			$("#emp_email_4").css("border","1px solid #f00");
			$(".emp_email_4_msg").show(); $(".emp_email_4_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#emp_email_4").val())){
				$("#emp_email_4").css("border","1px solid #f00");
				$(".emp_email_4_msg").show(); $(".emp_email_4_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#emp_email_4").css("border","1px solid #dee2e6"); $(".emp_email_4_msg").hide(); $(".emp_email_4_msg").html("");
			} 
		} 
		
		if ($("#emp_mobile_4").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#emp_mobile_4').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#emp_mobile_4").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".emp_mobile_4_msg").show(); $(".emp_mobile_4_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#emp_mobile_4").css("border","1px solid #dee2e6"); $(".emp_mobile_4_msg").hide(); $(".emp_mobile_4_msg").html("");} 
			} else {
				$("#emp_mobile_4").css("border","1px solid #f00");
				$(".emp_mobile_4_msg").show(); $(".emp_mobile_4_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#emp_mobile_4").css("border","1px solid #f00");
			//$(".emp_mobile_4_msg").show(); $(".emp_mobile_4_msg").html("Enter Mobile Number");
			//return false;
		}
	} 
}


if ($("#emp_name_5").val()) {
	if ($("#emp_name_5").val() == "") {
		$("#emp_name_5").css("border","1px solid #f00");
		$(".emp_name_5_msg").show(); $(".emp_name_5_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#emp_name_5").val())) {
			$("#emp_name_5").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".emp_name_5_msg").show(); $(".emp_name_5_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#emp_name_5").css("border","1px solid #dee2e6"); $(".emp_name_5_msg").hide(); $(".emp_name_5_msg").html("");
		}
	
		
		if ($("#emp_email_5").val() == "") {
			$("#emp_email_5").css("border","1px solid #f00");
			$(".emp_email_5_msg").show(); $(".emp_email_5_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#emp_email_5").val())){
				$("#emp_email_5").css("border","1px solid #f00");
				$(".emp_email_5_msg").show(); $(".emp_email_5_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#emp_email_5").css("border","1px solid #dee2e6"); $(".emp_email_5_msg").hide(); $(".emp_email_5_msg").html("");
			} 
		} 
		
		if ($("#emp_mobile_5").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#emp_mobile_5').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#emp_mobile_5").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".emp_mobile_5_msg").show(); $(".emp_mobile_5_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#emp_mobile_5").css("border","1px solid #dee2e6"); $(".emp_mobile_5_msg").hide(); $(".emp_mobile_5_msg").html("");} 
			} else {
				$("#emp_mobile_5").css("border","1px solid #f00");
				$(".emp_mobile_5_msg").show(); $(".emp_mobile_5_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#emp_mobile_5").css("border","1px solid #f00");
			//$(".emp_mobile_5_msg").show(); $(".emp_mobile_5_msg").html("Enter Mobile Number");
			//return false;
		}
	} 
}
});	
/* Create Mill Form Submition End *************************************************************/
</script>
<style>
.adblock {
	margin-right: 150px;
}
@media only screen and (max-width: 800px) {
  .btn-group>.btn:first-child {
	    margin-top: 10px !important;
	    float: right !important;
	    font-size: 12px !important;
	    padding: 5px !important;
	}

	.adblock {
		margin-right: 110px;
	}

	.adblock li {
	    display: inline-block;
	    margin: auto 5px;
	    padding: 5px;
	    border-radius: 4px;
	    color: #fff;
	    opacity: 0.6;
	}

	.adblock li a {
	    color: #fff;
	    padding: 0 2px;
	    font-size: 11px;
	}
}
</style>
</body>
</html>








