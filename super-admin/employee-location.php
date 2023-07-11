<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("add-site-location.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+-]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("add-site-location.php");
		}
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Query."); redirect_to("add-site-location.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Query."); redirect_to("add-site-location.php"); 
		}
	} else {
		$session->message("Company not found"); redirect_to("add-site-location.php"); 
	}

	if(!isset($_GET['id']) || empty($_GET['id'])){
		$session->message('Product Not Found');
		redirect_to("add-site-location.php"); 
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindra Accelo CRM</title>
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
   	
   	#my-complaints_filter{ display:none;}

	.dt-buttons {float:right !important; margin: -44px 0 0 0; height: 35px;}
	.dt-buttons button{background: #71bf44 !important; border-color: #71bf44; border-radius: 4px;}
	.dt-buttons button:hover{background:#26990A !important; border-color: #26990A;}
	
	.basic-datatable tr td, .basic-datatable tr th {
		padding: 5px 0px 5px 5px !important;
		text-align: left;
	}
	table.dataTable thead .sorting:before, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc_disabled:before {
		top: 8px !important;
	}
	table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_desc_disabled:after {
		top: 2px !important;
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


<div class=" ">
<div class="col-12">
	
<?php  $message = output_message($message); ?>
<div class="alert fade show text-white <?php 
		if($message == "Employee Added Successfully."){echo "bg-success";} 
		else {echo "bg-danger";}?>" 
	<?php if(empty($message)){echo "style='display:none;'";}?>>
	<a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
	<?php echo $message; ?>
</div>	
<div class="bord-box">
<div class="card-body">
<div class="al-com">
<div class="compl-lef"><h4>
	<?php
		$product = Product::find_by_id($_GET['id']);
	
		echo $product->department." / ".$product->site_location." / ".$product->product;
	?>
</h4></div>
<div class="compl-rig02">
<ul class="adblock" style="margin-right: 150px;">
	<li class="colgr-3"><a href="add-site-location.php"><i class="mdi mdi-keyboard-backspace"></i> Back</a></li>
	<li class="colgr-1"><a href="#" data-toggle="modal" data-target="#add-new"  ><i class="mdi mdi-plus-circle-outline"></i> Add New</a></li>
	<div class="clerfix"></div>
</ul>
</div>
<div class="clerfix"></div>
</div>

<table id="my-complaints" class="table dt-responsive nowrap basic-datatable" width="100%">
<thead>
<tr>
<td>Sr. No</td>
<td>Product</td>
<td>Name</td>
<td>Email</td>
<td>Mobile</td>
<!--<td>Role</td>-->
<td>Role</td>
<td>Role Priority</td>
<td>Status</td>
<td>Action</td>
<td>Delete</td>
</tr>
</thead>

<tbody>
	
	<?php
	$sql			= "Select * from employee_location where product_id = '{$product->id}'";
	$emp_location 	= EmployeeLocation::find_by_sql($sql);
	$num = 0;
	foreach($emp_location as $emp_location){
		$num++;
		echo "<tr>";
		echo "<td>".$num."</td>";
		echo "<td>".$product->product."</td>";
		echo "<td>".$emp_location->emp_name."</td>";
		echo "<td>".$emp_location->emp_email."</td>";
		echo "<td>".$emp_location->emp_mobile."</td>";
		//echo "<td>".$emp_location->emp_role."</td>";
		echo "<td>".$emp_location->emp_sub_role."</td>";
		echo "<td>".$emp_location->role_priority."</td>";
		echo "<td><a class='strri update_status ";
		if($emp_location->status == 1){echo "col1";} else { echo "col2"; }
		echo "' href='update-emp-location-status.php?id={$emp_location->id}'><i class='mdi mdi-check-circle-outline'></i></a><a class='strri update_status ";
		if($emp_location->status == 0){echo "col3";} else { echo "col2"; }
		echo "' href='update-emp-location-status.php?id={$emp_location->id}'><i class='mdi mdi-close-circle-outline'></i></a></td>";
		echo "<td><a href='#' class='edit_product' data-id='{$emp_location->id}' data-toggle='modal' data-target='#edit-new'>Edit</a></td>";
		echo "<td style='width:70px;'><a href='delete-employee-location.php?id={$emp_location->id}' class='col3 strri delete_status'><i class='mdi mdi-minus-circle-outline'></i></a></td>";
		echo "</tr>";
	}

	?>

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
<div class="modal fade fomall select2onlod" id="add-new">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header border-bottom-st d-block">
<!--<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<div class="form-p-hd">
<h2>Add New Employee Role</h2>
</div>


<div class="form-p-block">
<form action="add-employee-location-db.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
<!-- box 1 -->
<div class="form-group">
	<label class="control-label">Employee</label>
	<select class="form-control select2" id="employee" name="employee" data-toggle="select2">
		<option value="">- Select Employee -</option>
		<?php
			$employee_reg = EmployeeReg::find_all();
			foreach($employee_reg as $employee_reg){
				echo "<option value='{$employee_reg->id}'>{$employee_reg->emp_name}, {$employee_reg->emp_email}</option>";
			}
		?>
	</select><br />
	<span class="err_msg employee_msg"></span>
</div>
<!-- box 1 -->

<!-- box 1 -->
<div class="form-group">
	<label class="control-label">Select Role</label>
	<select id="emp_sub_role" name="emp_sub_role" class="form-control select2"  data-toggle="select2">
		<option value="">- Select Approver -</option>
		<option>Employee</option>
		<option>Viewer</option>
		<option>CRM - Head</option>
		<option>Commercial Head</option>
		<option>Plant Chief - AN</option>
		<option>Sales Head</option>
		<option>CFO</option>
		<option>MD</option>
		<option>Quality Assurance</option>
		<option>Plant Head</option>
		<option>Plant Chief - CN</option>
		<option>Management Representative</option>
	</select><br />
	<span class="err_msg emp_sub_role_msg"></span>
</div>
	
<div class="form-group">
	<label class="control-label">Role Priority</label>
	<select id="role_priority" name="role_priority" class="form-control select2"  data-toggle="select2">
		<option>Responsible</option>
		<option>Escalation 1</option>
		<option>Escalation 2</option>
		<option>None</option>
	</select><br />
	<span class="err_msg role_priority_msg"></span>
</div>	
<!-- box 1 -->


<div class="form-p-box form-p-boxbtn">
	<a class="fpcl" data-dismiss="modal" aria-hidden="true" href="#">Close</a>
	<input type="submit" class="fpdone" id="create_emp_location" value="Add">
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
<div class="modal fade fomall select2onlod" id="edit-new">
	<div class="modal-dialog">
		<div class="modal-content">

		</div> <!-- end modal-content-->
	</div> <!-- end modal dialog-->
</div>
<!-- Form pop up -->

</body>
<script src="assets/js/app.min.js"></script>

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
<script src="assets/js/custom.js"></script>

<script type="application/javascript">

	$(document).ready(function() {

		$('#my-complaints').DataTable( {
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
	                columns: [0,1,3,4,5,6]
	            }	          
	       }],
			"lengthMenu": [[50, 25, 50, -1], [50, 25, 50, "All"]],
			"language": {
				"info": "_START_-_END_ of _TOTAL_ entries",
				searchPlaceholder: "Search"
			},
		} );
		
		$('.buttons-csv span').html('Download Excel');
	});
	
	$('.edit_product').click(function() {
		var data_id = $(this).attr('data-id');
		//alert(data_id);
		$("#edit-new .modal-content").load("edit-employee-location.php?id="+data_id);
	});
	
	$(".delete_status").click(function(e) {
		if (confirm('You want to Delete Employee from this Product')) {
			return true;
		} else {
			return false;
		}
		e.prevedefault();
	});
	
	$(".update_status").click(function(e) {
		if (confirm('Status Update Confirmation')) {
			return true;
		} else {
			return false;
		}
		e.prevedefault();
	});

	$("#create_emp_location").click(function() {

		if ($("#employee").val() == "") {
			$("#employee").css("border","1px solid #f00");
			$(".employee_msg").show(); $(".employee_msg").html("Select Employee");
			return false;
		} else {
			$("#employee").css("border","1px solid #dee2e6"); $(".employee_msg").hide(); $(".employee_msg").html("");
		}

		if ($("#emp_sub_role").val() == "") {
			$("#emp_sub_role").css("border","1px solid #f00");
			$(".emp_sub_role_msg").show(); $(".emp_sub_role_msg").html("Select Employee Role");
			return false;
		} else {
			$("#emp_sub_role").css("border","1px solid #dee2e6"); $(".emp_sub_role_msg").hide(); $(".emp_sub_role_msg").html("");
		}
		
	});	
	
</script>
</html>


