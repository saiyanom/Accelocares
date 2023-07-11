<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("complaint-type.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+-]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("complaint-type.php");
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindraaccelo Complaint Type</title>
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
<div class="bord-box">
<div class="card-body">
<div class="al-com">
<div class="compl-lef"><h4>Search</h4></div>
<div class="clerfix"></div>
</div>


<div class="form-block">
	<form method="get" enctype="multipart/form-data" autocomplete="off">
		<ul class="form-block-con">
			<li>
				<select id="departmentType" name="department" class="form-control">
					<option value="">- Business Vertical -</option>
					<?php 
						$department = Department::find_all();
						foreach($department as $department){
							echo "<option ";
							if(isset($_GET['department']) && !empty($_GET['department'])){
								if($_GET['department'] == $department->department){ echo "Selected";}
							}
							echo " value='{$department->department}'>{$department->department}</option>";
						}
					?>
				</select>
			</li>
			<li>
				<select id="complaintType" name="complaint_type" class="form-control">
					<option value="">- Complaint Type -</option>
					<?php 
						$sql_complaint_type = "Select * from sub_complaint_type order by complaint_type ASC";
						$complaint_type = SubComplaintType::find_by_sql($sql_complaint_type);
						$complaint_type_data = "";
						foreach($complaint_type as $complaint_type){
							if($complaint_type_data != $complaint_type->complaint_type){
								echo "<option ";
								if(isset($_GET['complaint_type']) && !empty($_GET['complaint_type'])){
									if($_GET['complaint_type'] == $complaint_type->complaint_type){ echo "Selected";}
								}
								echo " value='{$complaint_type->complaint_type}'>{$complaint_type->complaint_type}</option>";
							} $complaint_type_data = $complaint_type->complaint_type;
							
						}
					?>
				</select>
			</li>
			<li>
				<select id="complaintType" name="sub_complaint_type" class="form-control">
					<option value="">- Sub Complaint Type -</option>
					<?php 
						$sql_sub_complaint_type = "Select * from sub_complaint_type order by sub_complaint_type ASC";
						$sub_complaint_type = SubComplaintType::find_by_sql($sql_sub_complaint_type);
						$sub_complaint_type_data = "";
						foreach($sub_complaint_type as $sub_complaint_type){
							if($sub_complaint_type_data != $sub_complaint_type->sub_complaint_type){
								echo "<option ";
								if(isset($_GET['sub_complaint_type']) && !empty($_GET['sub_complaint_type'])){
									if($_GET['sub_complaint_type'] == $sub_complaint_type->sub_complaint_type){ echo "Selected";}
								}
								echo " value='{$sub_complaint_type->sub_complaint_type}'>{$sub_complaint_type->sub_complaint_type}</option>";
							} $sub_complaint_type_data = $sub_complaint_type->sub_complaint_type;
							
						}
					?>
				</select>
			</li>		
			<li>
				<div class="form-group mb-0 text-center log-btn">
					<button class="btn btn-primary btn-block" type="submit">Search </button>
				</div>
			</li>
		</ul>
	</form>
</div>

</div>
</div>

<?php  $message = output_message($message); ?>
<div class="alert fade show text-white <?php 
	if($message == "Complaint Saved Successfully"){echo "bg-success";} 
	else if($message == "Status Updated Successfully."){echo "bg-success";} 		
	else if($message == "Complaint Updated Successfully."){echo "bg-success";} 		
	else {echo "bg-danger";}?>" 
<?php if(empty($message)){echo "style='display:none;'";}?>>
<a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
<?php echo $message; ?>
</div>

<div class="bord-box">
<div class="card-body">
<div class="al-com">
<div class="compl-lef"><h4>All Type of Complaints</h4></div>
<div class="compl-rig02">
<ul class="adblock">
<li class="colgr-1 "><a href="#" data-toggle="modal" data-target="#add-new" class="add_new"><i class="mdi mdi-plus-circle-outline"></i> Add New</a></li>
<div class="clerfix"></div>
</ul>
</div>
<div class="clerfix"></div>
</div>

<table id="my-complaints" class="table dt-responsive nowrap basic-datatable" width="100%">
<thead>
<tr>
<th>Sr. No</th>
<th>Vertical</th>
<th>Type of Complaint</th>
<th>Sub Complaint Type</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
	
	<?php
		if(isset($_GET['department'])){
			$num = 0;
			
			
			if(!empty($_GET['department'])){
				$department = " department = '{$_GET['department']}' AND ";
				$num++;
			} else { $department = ""; }
			
			
			if(!empty($_GET['complaint_type'])){
				$complaint_type = " complaint_type = '{$_GET['complaint_type']}' AND ";
				$num++;
			} else { $complaint_type = ""; }
			
			
			
			if(!empty($_GET['sub_complaint_type'])){
				$sub_complaint_type = " sub_complaint_type = '{$_GET['sub_complaint_type']}' AND ";
				$num++;
			} else { $sub_complaint_type = ""; }
			
			
			
			
			//echo $num."<hr />";
			if($num > 0){
				$sub_complaint_type_sql = "Select * from sub_complaint_type where {$department} {$complaint_type} {$sub_complaint_type} date_ != '0000-00-00' order by id ASC";
			} else {
				$sub_complaint_type_sql = "Select * from sub_complaint_type where  date_ != '0000-00-00' order by id ASC";
			}			
		} else {
			$sub_complaint_type_sql = "Select * from sub_complaint_type where  date_ != '0000-00-00' order by id ASC";
		}
	
		$subComplaintType = SubComplaintType::find_by_sql($sub_complaint_type_sql);
		$num = 0;
		foreach($subComplaintType as $subComplaintType){
			$num++;
			echo "<tr>";
			echo "<td>".$num."</td>";
			echo "<td>".$subComplaintType->department."</td>";
			echo "<td>".$subComplaintType->complaint_type."</td>";
			echo "<td>".$subComplaintType->sub_complaint_type."</td>";
			echo "<td><a class='strri update_status ";
			if($subComplaintType->status == 1){echo "col1";} else { echo "col2"; }
			echo "' href='update-complaint-status.php?id={$subComplaintType->id}'><i class='mdi mdi-check-circle-outline'></i></a><a class='strri update_status ";
			if($subComplaintType->status == 0){echo "col3";} else { echo "col2"; }
			echo "' href='update-complaint-status.php?id={$subComplaintType->id}'><i class='mdi mdi-close-circle-outline'></i></a></td>";
			echo "<td><a href='#' class='edit_complaint' data-id='{$subComplaintType->id}' data-toggle='modal' data-target='#edit-new'>Edit</a></td>";
			echo "</tr>";
		}

	?>
<!--
<tr>
<td>01</td>
<td>Cracking </td>
<td>Length variation</td>
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
<div class="modal fade fomall" id="add-new">
<div class="modal-dialog">
<div class="modal-content">

</div> <!-- end modal-content-->
</div> <!-- end modal dialog-->
</div>
<!-- Form pop up -->

	
	
<!-- Form pop up -->
<div class="modal fade fomall" id="edit-new">
	<div class="modal-dialog">
		<div class="modal-content">

		</div> <!-- end modal-content-->
	</div> <!-- end modal dialog-->
</div>
<!-- Form pop up -->
	

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

<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/hot-sneaks/jquery-ui.css" />
<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>		
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
	                columns: [0,1,3,]
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
	
	
	
	$('.add_new').click(function() {
		var data_id = $(this).attr('data-id');
		//alert(data_id);
		$("#add-new .modal-content").load("add-complaint-type.php");
	});
	
	
	$('.edit_complaint').click(function() {
		var data_id = $(this).attr('data-id');
		//alert(data_id);
		$("#edit-new .modal-content").load("edit-complaint-type.php?id="+data_id);
	});
	
	$(".update_status").click(function(e) {
		if (confirm('Status Update Confirmation')) {
			return true;
		} else {
			return false;
		}
		e.prevedefault();
	});

$("#create_complaint_type").click(function() {
	


	if ($("#department").val() == "") {
		$("#department").css("border","1px solid #f00");
		$(".department_msg").show(); $(".department_msg").html("Enter Department");
		return false;
	} else {
		$("#department").css("border","1px solid #dee2e6"); $(".department_msg").hide(); $(".department_msg").html("");
	}

	if ($("#complaint_type").val() == "") {
		$("#complaint_type").css("border","1px solid #f00");
		$(".complaint_type_msg").show(); $(".complaint_type_msg").html("Enter Complaint Type");
		return false;
	} else {
		$("#complaint_type").css("border","1px solid #dee2e6"); $(".complaint_type_msg").hide(); $(".complaint_type_msg").html("");
	}

	/*if ($("#sub_complaint_type").val() == "") {
		$("#sub_complaint_type").css("border","1px solid #f00");
		$(".sub_complaint_type_msg").show(); $(".sub_complaint_type_msg").html("Enter Sub Complaint Type");
		return false;
	} else {
		$("#sub_complaint_type").css("border","1px solid #dee2e6"); $(".sub_complaint_type_msg").hide(); $(".sub_complaint_type_msg").html("");
	}*/


	
});	

</script>

</body>
</html>
<style type="text/css">
	.select2-container {
		width: 100% !important;
	}
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
