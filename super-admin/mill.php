<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }

	/*foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("mill.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+-]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("mill.php");
		}
	}*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindraaccelo Mill</title>
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
	if($message == "Mill Added Successfully."){echo "bg-success";} 
	else if($message == "Status Updated Successfully."){echo "bg-success";} 		
	else if($message == "Mill Updated Successfully."){echo "bg-success";} 		
	else {echo "bg-danger";}?>" 
	<?php if(empty($message)){echo "style='display:none;'";}?>>
	<a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
	<?php echo $message; ?>
</div>
	
<div class="bord-box">
<div class="card-body">
<div class="al-com">
<div class="compl-lef"><h4>All Mill Details</h4></div>
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
<th>Mill Name</th>
<th>Person Name</th>
<th>Email ID</th>
<th>Mobile Number</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
	
	<?php
	
	$mill_reg = MillReg::find_all();
	$num = 0;
	foreach($mill_reg as $mill_reg){
		$num++;
		echo "<tr>";
		echo "<td>".$num."</td>";
		echo "<td>".$mill_reg->mill_name."</td>";
		echo "<td>".$mill_reg->name_1."</td>";
		echo "<td>".$mill_reg->email_1."</td>";
		echo "<td>".$mill_reg->mobile_1."</td>";
		echo "<td><a class='strri update_status ";
		if($mill_reg->status == 1){echo "col1";} else { echo "col2"; }
		echo "' href='update-mill-status.php?id={$mill_reg->id}'><i class='mdi mdi-check-circle-outline'></i></a><a class='strri update_status ";
		if($mill_reg->status == 0){echo "col3";} else { echo "col2"; }
		echo "' href='update-mill-status.php?id={$mill_reg->id}'><i class='mdi mdi-close-circle-outline'></i></a></td>";
		echo "<td><a href='#' class='edit_mill' data-id='{$mill_reg->id}' data-toggle='modal' data-target='#edit-new'>Edit</a></td>";
		echo "</tr>";
	}

	?>

<!--<tr>
<td>01</td>
<td>Tata Steel</td>
<td>Abhishek Agrawal</td>
<td>abhishek.agrawal@tatasteel.com</td>
<td>+91 73505 26434</td>
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
<h2>Add Mill Details</h2>
</div>

<div class="form-p-block">
	<form action="add-mill-db.php" method="post" enctype="multipart/form-data" autocomplete="off">
		<!-- box 1 -->
		<div class="form-group">
			<label class="control-label">Mill Name</label>
			<input class="form-control form-p-box-bg1" type="text" id="mill_name" name="mill_name">
			<span class="err_msg mill_name_msg"></span>
		</div>
		<div class="clerfix"></div>
		
		<div class="mill_details">
			<div class="mill_details_row mill_details_row_1">
				<hr />
				<div class="form-group"><label class="control-label">Full Name</label><input class="form-control form-p-box-bg1" type="text" id="name_1" name="name_1"><span class="err_msg name_1_msg"></span></div>
				<div class="form-group"><label class="control-label">Email</label><input class="form-control form-p-box-bg1" type="text" id="email_1" name="email_1"><span class="err_msg email_1_msg"></span></div>
				<div class="form-group"><label class="control-label">Mobile Number</label><input class="form-control form-p-box-bg1" type="number" id="mobile_1" name="mobile_1"><span class="err_msg mobile_1_msg"></span></div>
				<div class="clerfix"></div>
			</div>
		</div>
		
		<div class="input-group">
			<div class="custom-file">
				<button type="button" name="product_btn" class="fpcl btn add_mill"><i class="mdi mdi-plus"></i> Add</button>
				&nbsp; &nbsp; 
				<button type="button" name="product_btn" class="btn fpdone rem_mill"><i class="mdi mdi-minus"></i> Remove</button>
			</div>
		</div>
		<div class="clerfix">&nbsp;</div>

		<div class="form-p-box form-p-boxbtn">
			<a class="fpcl" data-dismiss="modal" aria-hidden="true" href="#">Close</a>
			<input type="submit" id="create_mill" class="fpdone" value="Add" />
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
</body>		
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
	
	$('.edit_mill').click(function() {
		var data_id = $(this).attr('data-id');
		//alert(data_id);
		$("#edit-new .modal-content").load("edit-mill.php?id="+data_id);
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
</html>


