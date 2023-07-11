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
?><!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindraaccelo</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content=" " name="description" />
<meta content="Coderthemes" name="author" />
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
<div class="row">

<div class="complaints-blocks">
<div class="cb-block">
<div class="cmp-lf"><h2>Create new complaint</h2></div>
<div class="clerfix"></div>


<ul class="rais-block">
<li class="resit-act1">
<select id="inputState" class="form-control">
<option>- Company Name -</option>
<option>Option 1</option>
<option>Option 2</option>
<option>Option 3</option>
</select>
</li>
<li class="resit-act1">
<select id="inputState" class="form-control">
<option>- Select Product -</option>
<option>Option 1</option>
<option>Option 2</option>
<option>Option 3</option>
</select>
</li>
<li class="resit-act1">
<select id="inputState" class="form-control">
<option>- Select Location -</option>
<option>Option 1</option>
<option>Option 2</option>
<option>Option 3</option>
</select>

</li>

<li class="resit-act1">
<input type="text" id=" " placeholder="Add Rejected Quantity" class="form-control">
</li>

</ul>

<ul class="rais-block">
<li class="resit-act1">
<input type="text" id=" " placeholder="Invoice Number" class="form-control">
</li>

<li class="resit-act1">
<input type="text" id=" " placeholder="Invoice Date" class="form-control">
</li>


<li class="resit-act1">
<input type="text" id=" " placeholder="Defected Batch Number" class="form-control">
</li>

<li class="resit-act1">
<select id="inputState" class="form-control">
<option>- Complaint Type -</option>
<option>Option 1</option>
<option>Option 2</option>
<option>Option 3</option>
</select>
</li>


</ul>

<ul class="rais-block">
<li class="resit-act1">
<select id="inputState" class="form-control">
<option>- Sub Complaint Type -</option>
<option>Option 1</option>
<option>Option 2</option>
<option>Option 3</option>
</select>
</li>

<li class="resit-act1">
<input type="text" id=" " placeholder="Contact Person Name" class="form-control">
</li>

<li class="resit-act1">
<input type="text" id=" " placeholder="Email ID" class="form-control">
</li>

<li class="resit-act1">
<input type="text" id=" " placeholder="Mobile Number" class="form-control">
</li>



</ul>
<div class="clerfix"></div>
<ul class="rais-block-comsub">
<li class=" ">
<div class="input-group">
<div class="custom-file">
<input type="file" class="custom-file-input" id="inputGroupFile04">
<label class="custom-file-label" for="inputGroupFile04">Upload Image</label>
</div>
</div>
</li>

<li>
<textarea class="form-control" id="example-textarea" placeholder="Write your feedback here..." rows="3"></textarea>
</li>

<li class="subtn03">
<div class="form-group mb-0 text-center log-btn">
<button class="btn btn-primary btn-block" type="submit">Create complaint </button>
</div>
</li>

<div class="clerfix"></div>
</ul>

</div>
</div>




</div><!-- end row-->
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


