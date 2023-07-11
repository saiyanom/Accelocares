<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	
	if (!$session->is_employee_logged_in()) { 
		redirect_to("logout.php"); 
	} else {
		$employee_reg = EmployeeReg::find_by_id($session->employee_id);
		if($employee_reg->emp_role != "Approver"){
			redirect_to("logout.php"); 
		}
	}

	$employee_loc = EmployeeLocation::find_by_emp_id($session->employee_id);


	if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "CRM - Head"){
		$comp_sql = "Select * from complaint where approval_note != ''";
	} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "Commercial Head"){
		$comp_sql = "Select * from complaint where approval_note != ''";
	} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "Production Head"){
		$comp_sql = "Select * from complaint where approval_note != ''";
	} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "Plant Head"){
		$comp_sql = "Select * from complaint where approval_note != ''";
	} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "Sales Head"){
		$comp_sql = "Select * from complaint where approval_note != ''";
	} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "CFO"){
		$comp_sql = "Select * from complaint where approval_note != ''";
	} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "MD"){
		$comp_sql = "Select * from complaint where approval_note != ''";
	} else {
		redirect_to("index.php"); 
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
/*#basic-datatable_length{ display:none}
#basic-datatable_filter{ display:none}*/

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
	if($message == "Approval Note Approved"){echo "bg-success";} 
	else if($message == "Complaint Updated Successfully"){echo "bg-success";} 		
	else if($message == "Approval Note Created Successfully"){echo "bg-success";} 		
	else if($message == "CAPA Created Successfully"){echo "bg-success";} 		
	else {echo "bg-danger";}?>" 
<?php if(empty($message)){echo " style='display:none';";} else {echo " style='margin-top:20px';";} ?> >
<a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
<?php echo $message; ?>
</div>
	
<div class="bord-box">
<div class="card-body">
<div class="al-com">
<div class="compl-lef"><h4>Search</h4></div>
<div class="clerfix"></div>
</div>


<div class="form-block">
<form>
<ul class="form-block-con form-block-con-szz">

<li>
<input type="text" id=" " placeholder="Company Name" class="form-control">
</li>

<li>
<input type="text" id=" " placeholder="Select Date Range" class="form-control">
</li>
<li>
 <input type="text" class="form-control date" id="birthdatepicker" data-toggle="date-picker" placeholder="Date" data-single-date-picker="true"></li>

<li>
<select id="inputState" class="form-control">
<option>- Business Vertical -</option>
<option>Option 1</option>
<option>Option 2</option>
<option>Option 3</option>
</select>
</li>

<li>
<select id="inputState" class="form-control">
<option>- Complaint Type -</option>
<option>Option 1</option>
<option>Option 2</option>
<option>Option 3</option>
</select>
</li>

<li>
<select id="inputState" class="form-control">
<option>Source</option>
<option>Option 1</option>
<option>Option 2</option>
<option>Option 3</option>
</select>
</li>


<li>
<select id="inputState" class="form-control">
<option>Aging</option>
<option>Option 1</option>
<option>Option 2</option>
<option>Option 3</option>
</select>
</li>

<li>
<div class="form-group mb-0 text-center log-btn">
<button class="btn btn-primary btn-block" type="submit">Search </button>
</div></li>

</ul>
</form>
</div>
</div>
</div>
<div class="bord-box">
<div class="card-body">
<div class="al-com">
<div class="compl-lef"><h4>All Complaints</h4></div>
<!-- <div class="compl-rig"><a href="#">Download to XL</a></div>-->
<div class="clerfix"></div>
</div>

<table id="basic-datatable" class="table dt-responsive basic-datatable" width="100%">
	<thead>
		<tr>
			<td>Complaint No</td>
			<td>Company Name</td>
			<td>Complaint Type</td>
			<td>Date</td>
			<td>Busi. Ver.</td>
			<td>Source</td>
			<td>Status</td>
			<td>Action</td>
			<td>Aging</td>
		</tr>
	</thead>

	<tbody>
		<?php
			$complaint = Complaint::find_by_sql($comp_sql);
			foreach($complaint as $complaint){
				
				// Days count with skipping Weekends
				$db_date 	= $complaint->date_;
				$today 		= date("Y-m-d");

				$start = new DateTime($db_date);
				$end = new DateTime($today);

				$end->modify('+1 day');

				$interval = $end->diff($start);

				$aging = $interval->days;

				$period = new DatePeriod($start, new DateInterval('P1D'), $end);

				$holidays = array('2012-09-07');

				foreach($period as $dt) {
					$curr = $dt->format('D');

					if ($curr == 'Sat' || $curr == 'Sun') {
						$aging--;
					}

					elseif (in_array($dt->format('Y-m-d'), $holidays)) {
						$aging--;
					}
				}
		?>
		<tr>
			<td><?php echo $complaint->id.", ".$complaint->ticket_no; ?></td>
			<td><?php echo $complaint->company_name; ?></td>
			<td><?php echo $complaint->complaint_type; ?></td>
			<td><?php echo $complaint->invoice_date; ?></td>
			<td><?php echo $complaint->business_vertical; ?></td>
			<td><?php echo $complaint->identify_source; ?></td>
			<?php 
				
				if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "CRM - Head"){
					if(empty($complaint->cna_crm_head)){
						echo "<td><span class='closed-td'>Pending</span></td>";
						echo "<td><a data-toggle='modal' class='view_approval_note' data-id='$complaint->approval_note' data-target='#approval-note' href='#'>View</a></td>";
					} else {
						echo "<td><span class='open-td'>Approved</span></td>";
						echo "<td><a>View</a></td>";
					}
				} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "Commercial Head"){
					if(empty($complaint->cna_commercial_head)){
						echo "<td><span class='closed-td'>Pending</span></td>";
						if(!empty($complaint->cna_crm_head)){
							echo "<td><a data-toggle='modal' class='view_approval_note' data-id='$complaint->approval_note' data-target='#approval-note' href='#'>View</a></td>";
						} else {echo "<td><a>View</a></td>";}
					} else {
						echo "<td><span class='open-td'>Approved</span></td>";
						echo "<td><a>View</a></td>";
					}
				} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "Production Head"){
					if(empty($complaint->cna_production_head)){
						echo "<td><span class='closed-td'>Pending</span></td>";
						if(!empty($complaint->cna_commercial_head)){
							echo "<td><a data-toggle='modal' class='view_approval_note' data-id='$complaint->approval_note' data-target='#approval-note' href='#'>View</a></td>";
						} else {echo "<td><a>View</a></td>";}
					} else {
						echo "<td><span class='open-td'>Approved</span></td>";
						echo "<td><a>View</a></td>";
					}
				} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "Plant Head"){
					if(empty($complaint->cna_plant_head)){
						echo "<td><span class='closed-td'>Pending</span></td>";
						if(!empty($complaint->cna_production_head)){
							echo "<td><a data-toggle='modal' class='view_approval_note' data-id='$complaint->approval_note' data-target='#approval-note' href='#'>View</a></td>";
						} else {echo "<td><a>View</a></td>";}
					} else {
						echo "<td><span class='open-td'>Approved</span></td>";
						echo "<td><a>View</a></td>";
					}
				} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "Sales Head"){
					if(empty($complaint->cna_sales_head)){
						echo "<td><span class='closed-td'>Pending</span></td>";
						if(!empty($complaint->cna_plant_head)){
							echo "<td><a data-toggle='modal' class='view_approval_note' data-id='$complaint->approval_note' data-target='#approval-note' href='#'>View</a></td>";
						} else {echo "<td><a>View</a></td>";}
					} else {
						echo "<td><span class='open-td'>Approved</span></td>";
						echo "<td><a>View</a></td>";
					}
				} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "CFO"){
					if(empty($complaint->cna_cfo)){
						echo "<td><span class='closed-td'>Pending</span></td>";
						if(!empty($complaint->cna_sales_head)){
							echo "<td><a data-toggle='modal' class='view_approval_note' data-id='$complaint->approval_note' data-target='#approval-note' href='#'>View</a></td>";
						} else {echo "<td><a>View</a></td>";}
					} else {
						echo "<td><span class='open-td'>Approved</span></td>";
						echo "<td><a>View</a></td>";
					}
				} else if($employee_loc->emp_role == "Approver" && $employee_loc->emp_sub_role == "MD"){
					if(empty($complaint->cna_md)){
						echo "<td><span class='closed-td'>Pending</span></td>";
						if(!empty($complaint->cna_cfo)){
							echo "<td><a data-toggle='modal' class='view_approval_note' data-id='$complaint->approval_note' data-target='#approval-note' href='#'>View</a></td>";
						} else {echo "<td><a>View</a></td>";}
					} else {
						echo "<td><span class='open-td'>Approved</span></td>";
						echo "<td><a>View</a></td>";
					}
				} 

			?>
			
			<td><?php echo $aging; ?></td>
		</tr>
		<?php } ?>
		
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



<!-- Form pop up -->
<div class="modal fade form-pop" id="approval-note" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">




<!-- end modal-body-->
</div> <!-- end modal-content-->
</div> <!-- end modal dialog-->
</div>
<!-- Form pop up -->




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


<script>
	$('.view_approval_note').click(function() {
		var data_id 	= $(this).attr('data-id');
		$("#approval-note .modal-content").load("view-approval-note.php?id="+data_id);
	});
</script>	
</body>
</html>


