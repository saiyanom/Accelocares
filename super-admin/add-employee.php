<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }
	//date_default_timezone_set('Asia/Calcutta');


	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=+]/', $value)){
			$session->message("Malicious Code Found."); redirect_to("analytics.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=+]/', $value)){
			$session->message("Malicious Code Found."); redirect_to("analytics.php");
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindraaccelo Employees</title>
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
   	
   	/*#my-complaints_filter{position: absolute; right: 340px; top: 77px;}*/
   	#my-complaints_filter input{width: 284px;}

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
	    /* display: none; */
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
<div>&nbsp;</div>		
<?php  $message = output_message($message); ?>
<div class="alert fade show text-white <?php 
	if($message == "Employee Added Successfully."){echo "bg-success";} 
	else if($message == "Status Updated Successfully."){echo "bg-success";} 		
	else if($message == "Employee Updated Successfully."){echo "bg-success";} 		
	else {echo "bg-danger";}?>" 
	<?php if(empty($message)){echo "style='display:none;'";}?>>
	<a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
	<?php echo $message; ?>
</div>
	
	
	
<div class="bord-box">
<div class="card-body">
	
<div class="al-com">
<div class="compl-lef"><h4>All Employee</h4></div>
<div class="compl-rig02">
<ul class="adblock">
<li class="colgr-1 "><a href="#" data-toggle="modal" data-target="#add-new"  ><i class="mdi mdi-plus-circle-outline"></i> Add New</a></li>
<div class="clerfix"></div>
</ul>
</div>	
<div class="clerfix"></div>
</div>

<table id="my-complaints" class="table dt-responsive nowrap basic-datatable" width="100%">
<thead>
<tr>
<th>Sr. No</th>
<th>Name</th>
<th>Email ID</th>
<th>Mobile Number</th>
<th>Location</th>
<!--<th>Assign Roles</th>-->
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
	
	<?php
	
	$employee_reg = EmployeeReg::find_all();
	$num = 0;
	foreach($employee_reg as $employee_reg){
		$num++;
		echo "<tr>";
		echo "<td>".$num."</td>";
		echo "<td>".$employee_reg->emp_name."</td>";
		echo "<td>".$employee_reg->emp_email."</td>";
		echo "<td>".$employee_reg->emp_mobile."</td>";
		echo "<td>".$employee_reg->location."</td>";
		//echo "<td>".$employee_reg->emp_role."</td>";
		echo "<td><a class='strri update_status ";
		if($employee_reg->status == 1){echo "col1";} else { echo "col2"; }
		echo "' href='update-employee-status.php?id={$employee_reg->id}'><i class='mdi mdi-check-circle-outline'></i></a><a class='strri update_status ";
		if($employee_reg->status == 0){echo "col3";} else { echo "col2"; }
		echo "' href='update-employee-status.php?id={$employee_reg->id}'><i class='mdi mdi-close-circle-outline'></i></a></td>";
		echo "<td><a href='#' class='edit_employee' data-id='{$employee_reg->id}' data-toggle='modal' data-target='#edit-new'>Edit</a></td>";
		echo "</tr>";
	}

	?>
<!--
<tr>
<td>01</td>
<td>Pankaj Mishra</td>
<td>-</td>
<td>+91 73505 26434</td>
<td>Kanhe</td>
<td>Employee</td>
<td>
<a class="strri col1" href="#"><i class="mdi mdi-check-circle-outline"></i></a> 
<a class="strri col2" href="#"><i class="mdi mdi-close-circle-outline"></i></a></td>
<td><a href="#">Edit</a></td>
</tr>
-->



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
	<h2>Add New Employee</h2>
</div>

<div class="form-p-block">
	<form action="add-employee-db.php" method="post" enctype="multipart/form-data" autocomplete="off">
	<!-- box 1 -->
	<div class="form-group">
		<label class="control-label">Employee Name</label>
		<input class="form-control form-p-box-bg1" placeholder="" type="text" id="emp_name" name="emp_name">
		<span class="err_msg emp_name_msg"></span>
	</div>
	<div class="form-group">
		<label class="control-label">Email ID</label>
		<input class="form-control form-p-box-bg1" placeholder="" type="text" id="emp_email" name="emp_email">
		<span class="err_msg emp_email_msg"></span>
	</div>
	<div class="form-group">
		<label class="control-label">Mobile Number</label>
		<input class="form-control form-p-box-bg1" placeholder="" type="text" id="emp_mobile" name="emp_mobile">
		<span class="err_msg emp_mobile_msg"></span>
	</div>
	<!-- box 1 -->

	<div class="form-p-box form-p-boxbtn">
		<a class="fpcl" data-dismiss="modal" aria-hidden="true" href="#">Close</a>
		<input type="submit" id="create_employee" class="fpdone" value="Add">
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
<script src="assets/js/custom.js"></script>
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
	                columns: [0,1,2,3]
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


	$('.edit_employee').click(function() {
		var data_id = $(this).attr('data-id');
		$("#edit-new .modal-content").load("edit-employee.php?id="+data_id);
	});
	
	$(".update_status").click(function(e) {
		if (confirm('Status Update Confirmation')) {
			return true;
		} else {
			return false;
		}
		e.prevedefault();
	});
</script>	
<style>
.adblock {
	margin-right: 150px;
}
@media only screen and (max-width: 800px) {
   #my-complaints_filter input{width: auto !important;}

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










