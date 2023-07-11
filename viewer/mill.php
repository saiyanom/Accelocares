<?php
	ob_start();
	require_once("../includes/initialize.php"); 

	$employee_reg = EmployeeReg::find_by_id($session->employee_id);
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	if ($session->is_employee_logged_in()){ 
		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role = 'Viewer' Limit 1";
		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
		if(!$employee_location){
			redirect_to("logout.php"); 
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindraaccelo</title>
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
#basic-datatable_length{ display:none}
#basic-datatable_filter{ display:none}

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
<form>

<ul class="form-block-con">

<li>
<input type="text" id=" " placeholder="Mill Name" class="form-control">
</li>

<li>
<input type="text" id=" " placeholder="Mobile Number" class="form-control">
</li>
<li>
 <input type="text"  id=" " placeholder="Email ID" class="form-control"></li>


<li class="srcbtnd" style="">
<div class="form-group mb-0 text-center log-btn">
<button class="btn btn-primary btn-block" type="submit"><i class="mdi mdi-magnify"></i> </button>
</div></li>

<div class="clerfix"></div>

</ul>


</form>
</div>

</div>
</div>
	
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
<li class="colgr-2"><a href="#">Download</a>   |  <a href="#">Upload</a></li>
<div class="clerfix"></div>
</ul>
</div>
<div class="clerfix"></div>
</div>

<table id="basic-datatable" class="table dt-responsive nowrap basic-datatable" width="100%">
<thead>
<tr>
<td>Sr. No</td>
<td>Mill Name</td>
<td>Person Name</td>
<td>Email ID</td>
<td>Mobile Number</td>
<td>Status</td>
<td>Action</td>
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
		echo "<td>".$mill_reg->person_name."</td>";
		echo "<td>".$mill_reg->mill_email."</td>";
		echo "<td>".$mill_reg->mill_mobile."</td>";
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
	<form action="add-mill-db.php" method="post" enctype="multipart/form-data">
		<!-- box 1 -->
		<div class="form-group"><label class="control-label">Mill Name</label><input class="form-control form-p-box-bg1" type="text" name="mill_name"></div>
		<div class="form-group"><label class="control-label">Person Name</label><input class="form-control form-p-box-bg1" type="text" name="person_name"></div>
		<!-- box 1 -->
		<ul class="ad-lr">
		<!-- box 1 -->
			<li class="adl1"><div class="form-group"><label class="control-label">Email ID</label><input class="form-control form-p-box-bg1" type="text" name="mill_email"></div></li>
			<li class="adr1"><div class="form-group"><label class="control-label">Mobile Number</label><input class="form-control form-p-box-bg1" type="text" name="mill_mobile"></div></li>
		<!-- box 1 -->
		<div class="clerfix"></div>
		</ul>

		<div class="form-p-box form-p-boxbtn">
			<a class="fpcl" data-dismiss="modal" aria-hidden="true" href="#">Close</a>
			<input type="submit" class="fpdone" value="Add">
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
</html>


