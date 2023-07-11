<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("analytics.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("analytics.php");
		}
	}

	$employee_reg = EmployeeReg::find_by_id($session->employee_id);
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	if ($session->is_employee_logged_in()){ 

		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != 'Employee' Limit 1";

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
<title>Mahindra Accelo CRM</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="" name="description" />
<meta content=" " name="author" />
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

<div class="">
&nbsp;
</div>	

<?php
	$complaints_open = Complaint::count_status_emp('Open',$session->employee_id);
	$complaints_closed = Complaint::count_status_emp('Closed',$session->employee_id); 	
	$complaints_all = Complaint::count_all_emp($session->employee_id); 
?>	


<div class="row">

	<div class="col-xl-6">
		<div class="card">
			<div class="card-body" id="plant_vs_mill">
				
			</div>
			<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	
	<div class="col-xl-6">
		<div class="card">
		<div class="card-body" id="mill_data">

		</div>
		<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	<!-- end col-->
	
	<div class="col-xl-6">
		<div class="card">
		<div class="card-body" id="business_verticle">

		</div>
		<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	<!-- end col-->
	
	<div class="col-xl-6">
		<div class="card">
		<div class="card-body" id="plant_data">

		</div>
		<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	<!-- end col-->
	
	<div class="col-xl-6">
		<div class="card">
		<div class="card-body" id="complaint_type">

		</div>
		<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	<!-- end col-->
	
	<div class="col-xl-6">
		<div class="card">
		<div class="card-body" id="company_wise">

		</div>
		<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	<!-- end col-->
	
	
	<div class="col-xl-6">
		<div class="card">
		<div class="card-body" id="complaint_analysis">

		</div>
		<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	<!-- end col-->
	
	<div class="col-xl-6">
		<div class="card">
		<div class="card-body" id="employee_performance">

		</div>
		<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	<!-- end col-->

</div>
<!-- end row-->

<div class="">
<div class="comp-box" style="padding-top: 0;">
<ul>

<li style="width: 24%; margin: 1% 1% 1% 0;">
<div class="comp-left"><h2><?php
	$total_plant_complaint_received=0;
	$total_plant_complaint_closed=0;
	$average_plant_complaint_tat=0;
	
	$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee'";
	$employee_location = EmployeeLocation::find_by_sql($sql_el);

	foreach($employee_location as $employee_location){
		$product = Product::find_by_id($employee_location->product_id);

		$sql_mill 	= "Select * from complaint where identify_source != '' AND plant_location = '{$product->site_location}' AND business_vertical = '{$product->department}' AND product = '{$product->product}'";
		$complaint 		= Complaint::find_by_sql($sql_mill);

		foreach($complaint as $complaint){
			// Plant Data
			if($complaint->identify_source == 'Plant'){
				$total_plant_complaint_received++;
			}

			if($complaint->identify_source == 'Plant' && $complaint->status == "Closed"){
				$total_plant_complaint_closed++;
			}

			if($complaint->identify_source == 'Plant' && $complaint->status == "Closed"){
				$db_date 	= $complaint->date_;
				$today 		= $complaint->comp_closed_date;

				$start = new DateTime($db_date);
				$end = new DateTime($today);

				$interval = $end->diff($start);

				$total_plant_complaint_tat = $interval->days;
				$hours = $interval->h;

				$period = new DatePeriod($start, new DateInterval('P1D'), $end);

				foreach($period as $dt) {
					$curr = $dt->format('D');

					if ($curr == 'Sat' || $curr == 'Sun') {
						$total_plant_complaint_tat--;
					}	
				}
				$average_plant_complaint_tat = $total_plant_complaint_tat / $total_plant_complaint_closed;
			}			
		}
	}
	if(is_nan($average_plant_complaint_tat)){ $average_plant_complaint_tat = 0; }
	echo "7 / ".round($average_plant_complaint_tat);
?></h2><p>Plant Turn Around Time</p></div>
<div class="comp-right"><img src="assets/images/complaints/1.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="analytics-plant-data-table.php" class="color-gr1">Average Closing Days</a></div>
</li>

<li style="width: 23%; margin: 1% 1%;">
<div class="comp-left"><h2><?php
	$total_mill_complaint_received=0;
	$total_mill_complaint_closed=0;
	$average_mill_complaint_tat=0;
	
	$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee'";
	$employee_location = EmployeeLocation::find_by_sql($sql_el);

	foreach($employee_location as $employee_location){
		$product = Product::find_by_id($employee_location->product_id);

		$sql_mill 	= "Select * from complaint where identify_source != '' AND plant_location = '{$product->site_location}' AND business_vertical = '{$product->department}' AND product = '{$product->product}'";
		$complaint 		= Complaint::find_by_sql($sql_mill);

		foreach($complaint as $complaint){
			// Mill Data
			if($complaint->identify_source == 'Mill'){
				$total_mill_complaint_received++;
			}

			if($complaint->identify_source == 'Mill' && $complaint->status == "Closed"){
				$total_mill_complaint_closed++;
				
				$db_date 	= $complaint->date_;
				$today 		= $complaint->comp_closed_date;

				$start = new DateTime($db_date);
				$end = new DateTime($today);

				$interval = $end->diff($start);

				$total_mill_complaint_tat = $interval->days;
				$hours = $interval->h;

				$period = new DatePeriod($start, new DateInterval('P1D'), $end);

				foreach($period as $dt) {
					$curr = $dt->format('D');

					if ($curr == 'Sat' || $curr == 'Sun') {
						$total_mill_complaint_tat--;
					}	
				}
				$average_mill_complaint_tat = $total_mill_complaint_tat / $total_mill_complaint_closed;
			}

			
		}
	}
	if(is_nan($average_mill_complaint_tat)){ $average_mill_complaint_tat = 0; }
	echo "15 / ".round($average_mill_complaint_tat);
?></h2><p>Mill Turn Around Time</p></div>
<div class="comp-right"><img src="assets/images/complaints/2.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="analytics-mill-data-table.php" class="color-gr2">Average Closing Days</a></div>
</li>
	
<li style="width: 23%; margin: 1% 1%;">
<div class="comp-left"><h2><?php
	$sql = "Select * from site_location order by site_location ASC";
	$site_location = SiteLocation::find_by_sql($sql);
	$repeat = "";
	
	
	$total_credit_note_iss_cust = 0;
	$total_debit_note_iss_supplier = 0;
	$total_loss_per_approval_note = 0;

	foreach($site_location as $site_location){
		if($repeat != $site_location->site_location){
		
			$total_qty_rejc = 0;
			$credit_note_iss_cust = 0;
			$debit_note_iss_supplier = 0;
			$loss_per_approval_note = 0;

			$approval_note = ApprovalNote::find_all();
			foreach($approval_note as $approval_note){   
				
				$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee'";
				$employee_location = EmployeeLocation::find_by_sql($sql_el);

				foreach($employee_location as $employee_location){
					$product = Product::find_by_id($employee_location->product_id);

					$sql_mill 	= "Select * from complaint where id = '{$approval_note->complaint_id}' AND plant_location = '{$product->site_location}' AND business_vertical = '{$product->department}' AND product = '{$product->product}' AND identify_source = 'Plant' Limit 1";
					$complaint 		= Complaint::find_by_sql($sql_mill);

					foreach($complaint as $complaint){
						if($complaint){
							if($complaint->plant_location == $site_location->site_location){
								$credit_note_iss_cust 		+= $approval_note->credit_note_iss_cust;
								$debit_note_iss_supplier 	+= $approval_note->debit_note_iss_supplier;
								//$loss_per_approval_note 	= $credit_note_iss_cust - $debit_note_iss_supplier;
								$loss_per_approval_note 	= $approval_note->net_loss;
							}
						}
					}
				}
			}
			$total_credit_note_iss_cust 	+= $credit_note_iss_cust;
			$total_debit_note_iss_supplier 	+= $debit_note_iss_supplier;
			$total_loss_per_approval_note 	+= $loss_per_approval_note;

	} $repeat = $site_location->site_location; }
	
	echo "<span class='app_note_plant'>{$total_loss_per_approval_note}</span>";
 
?></h2><p>Approval Note - Plant</p></div>
<div class="comp-right"><i class="fa fa-inr" style="color: #e31837;"></i></div>
<div class="clerfix"></div>
<div class="val"><a href="analytics-approval-note-location-table.php" class="color-gr3">View all</a></div>
</li>

<li style="width: 23%; margin: 1% 0 1% 1%;">
<div class="comp-left"><h2><?php
	$mill_reg = MillReg::find_all();

	$total_credit_note_iss_cust = 0;
	$total_debit_note_iss_supplier = 0;
	$total_loss_per_approval_note = 0;

	foreach($mill_reg as $mill_reg){
		
	$total_qty_rejc = 0;
	$credit_note_iss_cust = 0;
	$debit_note_iss_supplier = 0;
	$loss_per_approval_note = 0;

	$approval_note = ApprovalNote::find_all();
	foreach($approval_note as $approval_note){   
		
		$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee'";
		$employee_location = EmployeeLocation::find_by_sql($sql_el);

		foreach($employee_location as $employee_location){
			$product = Product::find_by_id($employee_location->product_id);

			$sql_mill 	= "Select * from complaint where id = '{$approval_note->complaint_id}' AND plant_location = '{$product->site_location}' AND business_vertical = '{$product->department}' AND product = '{$product->product}' AND identify_source = 'Mill' Limit 1";
			$complaint 		= Complaint::find_by_sql($sql_mill);

			foreach($complaint as $complaint){
				if($complaint){
					if($complaint->identify_source == 'Mill'){
						if($complaint->mill == $mill_reg->mill_name){
							$credit_note_iss_cust 		+= $approval_note->credit_note_iss_cust;
							$debit_note_iss_supplier 	+= $approval_note->debit_note_iss_supplier;
							//$loss_per_approval_note 	= $credit_note_iss_cust - $debit_note_iss_supplier;
							$loss_per_approval_note 	= $approval_note->net_loss;
						}
					}
				}
			}
		}
	}
	$total_loss_per_approval_note 	+= $loss_per_approval_note;
}	echo "<span class='app_note_mill'>{$total_loss_per_approval_note}</span>";
?></h2><p>Approval Note - Mill</p></div>
	<div class="comp-right"><i class="fa fa-inr" style="color: #ffbc00;"></i></div>
<div class="clerfix"></div>
<div class="val"><a href="analytics-approval-note-mill-table.php" class="color-gr4">View all</a></div>
</li>	

<div class="clerfix"></div>
</ul>
</div>
</div>



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


<!-- third party:js -->
<script src="assets/js/vendor/d3.min.js"></script>
<script src="assets/js/vendor/britecharts.min.js"></script>
<!-- third party end -->
<!-- demo:js 
<script src="assets/js/pages/demo.britechart.js"></script>
<!-- demo end -->

<!-- third party js -->
<script src="assets/js/vendor/Chart.bundle.min.js"></script>
<!-- third party js ends -->
<!-- demo app 
<script src="assets/js/pages/demo.chartjs.js"></script>
<!-- end demo js-->
<!-- third party:js -->
<script src="assets/js/vendor/apexcharts.min.js"></script>
<!-- third party end -->
<!-- demo:js 
<script src="assets/js/pages/demo.apex-radialbar.js"></script>
<!-- demo end -->
<!-- third party:js -->
<script src="assets/js/vendor/apexcharts.min.js"></script>
<!-- third party end -->
<!-- demo:js -->
<script src="https://apexcharts.com/samples/assets/stock-prices.js"></script>
<script src="https://apexcharts.com/samples/assets/irregular-data-series.js"></script>

<?php
	
	
?>
<script>

	$(document).ready(function() {
		$("#plant_vs_mill").load("analytics-plant-vs-mill.php");
		$("#mill_data").load("analytics-mill-data.php");
		$("#business_verticle").load("analytics-business-verticle.php");
		$("#plant_data").load("analytics-plant-data.php");
		$("#complaint_type").load("analytics-complaint-type.php");
		$("#company_wise").load("analytics-company-wise.php");
		$("#complaint_analysis").load("analytics-complaint-analysis.php");
		$("#employee_performance").load("analytics-employee-performance.php");
	});
		
</script>
<style>
	.apexcharts-toolbar {display: none;}

	.comp-left p {
		font-size: 13px !important;
	}
</style>
