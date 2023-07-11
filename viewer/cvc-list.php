<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("employee-cvc.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search From"); redirect_to("employee-cvc.php");
		}
	}
	
	if ($session->is_employee_logged_in()){ 
		$employee_reg = EmployeeReg::find_by_id($session->employee_id);

		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role = 'Viewer' Limit 1";
		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
		if(!$employee_location){
			redirect_to("logout.php"); 
		}
	} else { redirect_to("logout.php"); }
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


<!-- new style -->
<style>
.block-btn{ margin:30px 0}
.log-btn-n{ margin:10px 0; padding:0 40px 0 0}
.log-btn-n a{ width:100%; color:#fff}
.log-btn-n a:hover{ color:#000; opacity:0.8}
.btn-primary001{ background:#71bf44!important}
.btn-primary002{ background:#04b0c4!important}
</style>
<!-- new style -->

<!-- Start Content-->
<div class="container-fluid">

<!-- start page title -->
<div class="col-12 pt-4">
 <h4>Customer Visit Calendar - All History</h4>
</div>   
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
				<li><select id="meet_status" name="meet_status" class="form-control select2" data-toggle="select2">
					<option value="">- Meeting Status -</option>
					<option <?php if(isset($_GET['meet_status'])){if($_GET['meet_status'] == '0'){ echo "Selected";}}?> value='0'>New</option>";
					<option <?php if(isset($_GET['meet_status']) && !empty($_GET['meet_status'])){if($_GET['meet_status'] == '1'){ echo "Selected";}}?> value='1'>Yes</option>";
					<option <?php if(isset($_GET['meet_status']) && !empty($_GET['meet_status'])){if($_GET['meet_status'] == '2'){ echo "Selected";}}?> value='2'>No</option>";
					<option <?php if(isset($_GET['meet_status']) && !empty($_GET['meet_status'])){if($_GET['meet_status'] == '3'){ echo "Selected";}}?> value='3'>Reschedule</option>";
				</select></li>
				<li>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text clear_img clear_date" title="Clear Image">X</span>
						</div>
						<div class="custom-file">
							<input readonly type="text" value="<?php echo $_GET['date_range']; ?>" id="date_range" name="date_range" placeholder="Select Date Range" class="form-control date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="false">
						</div>
					</div>
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

<div class="bord-box">
<div class="card-body">
<div class="al-com">
<div class="compl-lef"><h4>All CVC History</h4></div>
<div class="compl-rig">
<a href="#" data-toggle="modal" data-target="#meeting-form1" class="btn btn-primary001">
<i class="mdi mdi-plus-circle-outline"></i> Create New Meeting
</a>
&nbsp;
<a href="my-cvc.php" class="btn btn-primary002">
Calender View
</a>

</div>

<!-- Set up Meeting 1 -->
<div class="modal fade" id="meeting-form1" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="form-p-hd">
<h2>Set up Meeting</h2>
</div>
<div class="modal-body pl-4 pr-4">
<form action="cvc-meeting-db.php" method="post" enctype="multipart/form-data" autocomplete="off">
<div class="form-group">
	<label><strong>Date</strong></label>
	<input type="text" class="form-control date-picker" name="meeting_date" id="meeting_date" data-toggle="date-picker" data-single-date-picker="true">
	<span class="err_msg meeting_date_msg"></span>
</div>

<div class="form-group">
	<label class="control-label">Select Customer</label>
	<select id="company" name="company" class="form-control select2" data-toggle="select2">
		<option value="">- Select Company -</option>
		<?php
			$company_reg = CompanyReg::find_all();
			foreach($company_reg as $company_reg){
				echo "<option value='{$company_reg->id}'>{$company_reg->company_name}</option>";
			}
		?>
	</select>
	<span class="err_msg company_msg"></span>
</div>

<div class="form-group">
	<label class="control-label"><strong>Place</strong></label>
	<input class='form-control' placeholder='Place' type='text' id='place' name='place'/>
	<span class="err_msg place_msg"></span>
</div>

<div class="form-group">
	<label class="control-label"><strong>Objective</strong></label>
	<input class="form-control form-white" placeholder="Meeting Objectives" type="text" id="meeting_objective" name="meeting_objective"/>
	<span class="err_msg meeting_objective_msg"></span>
</div>

<div class="text-right">
	<button type="button" class="btn fpcl" data-dismiss="modal">Cancel</button>
	<input type="submit" id="create_cvc_meeting" name="create_cvc_meeting" value="Submit" class="btn fpdone"/>
</div>
</form>

</div> <!-- end modal-body-->
</div> <!-- end modal-content-->
</div> 
</div>
<!-- Set up Meeting 2 -->	
	
	
	

<!-- Set up Meeting 2 -->
<div class="modal fade" id="meeting-form2" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
	<div class="form-p-hd">
		<h2>Meeting Discussion</h2>
	</div>
	<div class="modal-body pl-4 pr-4">


	</div> <!-- end modal-body-->
</div> <!-- end modal-content-->
</div> 
</div>
<!-- Set up Meeting 2 -->

<div class="clerfix"></div>
</div>

<table id="basic-datatable" class="table dt-responsive nowrap " width="100%">
<thead>
	<tr>
		<th>Sr. No</th>
		<th>Date</th>
		<th>Name</th>
		<th>Customer Name</th>
		<th>Place</th>
		<th>Meeting Status</th>
		<th>Meeting Discussion</th>
		<th>Action</th>
	</tr>
</thead>
<tbody>
<?php
	
	if(isset($_GET['meet_status']) || isset($_GET['date_range'])){		
		
		$num =0;
		if(!empty($_GET['meet_status'])){
			$meet_status = " status = '{$_GET['meet_status']}' AND ";
			$num++;
		} else { 
			if($_GET['meet_status'] == '0'){
				$meet_status = " status = '{$_GET['meet_status']}' AND ";
				$num++;
			}else {
				$meet_status = " status != '' OR status >=0 AND ";
				$num++;
			}
		}

		if(!empty($_GET['date_range'])){
			$from_date = strtok($_GET['date_range'], '-');
			$from_date = strtotime($from_date); 
			$from_date = date("Y-m-d", $from_date); 
			list(, $to_date) = explode('-', $_GET['date_range']);
			$to_date = strtotime($to_date); 
			$to_date = date("Y-m-d", $to_date); 

			$date_range = " meeting_date BETWEEN '{$from_date}' AND '{$to_date}' AND ";
			$num++;
		} else { $date_range = "";}
		
	} else {
		$date_range = "";
		$meet_status = "";
	}
	
	
	
	$emp_sql = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_role = 'Approver' order by product_id ASC ";
	$emp_location = EmployeeLocation::find_by_sql($emp_sql);
	$rep_pro_id = '';
	$num = 1;
	foreach($emp_location as $emp_location){
		if($rep_pro_id != $emp_location->product_id){
			$emp_sql_pro = "Select * from employee_location where product_id = '{$emp_location->product_id}' order by emp_id ASC";
			$emp_location_pro = EmployeeLocation::find_by_sql($emp_sql_pro);

			//echo $emp_location->product_id." - ".$emp_location->emp_name."<br /> ";
			$rep_emp_id = '';
			foreach($emp_location_pro as $emp_location_pro){
				if($rep_emp_id != $emp_location_pro->emp_id){
					//echo $emp_location->product_id." - ".$emp_location_pro->emp_name."<br /> ";

					$sql = "Select * from cvc_meeting where {$meet_status} {$date_range} emp_id = '{$emp_location_pro->emp_id}'  order by id DESC";
					$comp_meet = CvcMeeting::find_by_sql($sql);
					
					foreach($comp_meet as $comp_meet){
?>
						<tr>
							<td><?php echo $num; ?></td>
							<td><?php echo date( 'd-m-Y', strtotime($comp_meet->meeting_date)); ?></td>
							<td><?php echo $comp_meet->emp_name; ?></td>
							<td><?php echo $comp_meet->comp_name; ?></td>
							<td><?php echo $comp_meet->place; ?></td>
							<td><?php echo $comp_meet->meeting_status; ?></td>
							<td><?php if($comp_meet->meeting_status == "Yes"){

									if(empty($comp_meet->discussion_document)){
										echo $str = substr($comp_meet->discussion, 0, 30) . '...';
									} else {
										echo "<a target='_blank' class='fancybox-thumbs' data-fancybox-group='thumb' href='../document/cvc/{$comp_meet->emp_id}/{$comp_meet->discussion_document}'>View Document</a>";
									}
								} else { echo $comp_meet->remark;} ?></td>
							<td><a class="edit_meeting" data-toggle="modal" data-id="<?php echo $comp_meet->id; ?>" data-target="#meeting-form2" href="#">View</a></td>
						</tr>
<?php
					$num++;}
					
					$rep_emp_id = $emp_location_pro->emp_id;
				}

			}

			$rep_pro_id = $emp_location->product_id;
		}

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

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->
</div>
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

<link href="assets/rang-css-js/jquery.range.css" rel="stylesheet" type="text/css">
<script src="assets/rang-css-js/jquery.range.js"></script>

</body>
<script>
	
	$(".clear_date").click(function(){
		$("#date_range").val("");
	});
	
	$(".edit_meeting").click(function (e) {
		var meet_id = $(this).attr('data-id');				
		$("#meeting-form2 .modal-body").load("meeting-discussion.php?id="+meet_id);
	});
	
	$(document).ready(function() {
		$('.date-picker').daterangepicker({
			singleDatePicker: true,
			locale: {
			  format: 'MM/DD/YYYY',
			}
		});
	});

</script>	
<style>
	.select2-container {
		width: 100% !important;
	}
	span.err_msg{
		color: #f00;
		font-size: 12px;
		/*display: none;*/
	}

	span.clear_img{
		cursor: pointer;
		color: #fff;
		background-color: #a00;
		border: 1px solid #900;
	}
</style>
</html>


