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
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Analytics | Mahindraaccelo</title>
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
<?php  $message = output_message($message); ?>
<div class="alert fade show text-white <?php 
		if($message == "My Complaint Successfully"){echo "bg-success";} 		
		else {echo "bg-danger";}?>" 
<?php if(empty($message)){echo "style='display:none;'";}?>>
<a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
<?php echo $message; ?>
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

</div>
<!-- end row-->
	
<div class="">
<div class="comp-box" style="padding-top: 0;">
<ul>

<li style="width: 24%; margin: 1% 1% 1% 0;">
<div class="comp-left"><h2><?php
	$total_plant_complaint_tat=0;
	$total_plant_complaint_closed=0;
	$average_plant_complaint_tat=0;
	$plant_complaint_tat=0;
	
	$sql_mill 	= "Select * from complaint where identify_source = 'Plant' AND emp_id = '{$session->employee_id}' AND status = 'Closed'";
	$complaint 		= Complaint::find_by_sql($sql_mill);

	foreach($complaint as $complaint){
		// Plant Data
		$total_plant_complaint_closed++;
		
		$db_date 	= $complaint->date_;
		$today 		= $complaint->comp_closed_date;

		$start = new DateTime($db_date);
		$end = new DateTime($today);

		$interval = $end->diff($start);

		$plant_complaint_tat += $interval->days;
		$hours = $interval->h;

		$period = new DatePeriod($start, new DateInterval('P1D'), $end);

		foreach($period as $dt) {
			$curr = $dt->format('D');

			if ($curr == 'Sat' || $curr == 'Sun') {
				$plant_complaint_tat--;
			}	
		}
		$total_plant_complaint_tat += $plant_complaint_tat;
	}			
	$average_plant_complaint_tat = $total_plant_complaint_tat / $total_plant_complaint_closed;
	if(is_nan($average_plant_complaint_tat)){ $average_plant_complaint_tat = 0; }
	echo "7 / ".round($average_plant_complaint_tat);
?></h2><p>Plant Turn Around Time</p></div>
<div class="comp-right"><img src="assets/images/complaints/1.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="#" class="color-gr1">Average Closing Days</a></div>
</li>

<li style="width: 23%; margin: 1% 1%;">
<div class="comp-left"><h2><?php
	$total_mill_complaint_closed=0;
	$average_mill_complaint_tat=0;
	$total_mill_complaint_tat = 0;
	$mill_complaint_tat = 0;
	
	$sql_mill 	= "Select * from complaint where identify_source = 'Mill' AND emp_id = '{$session->employee_id}' AND status = 'Closed'";
	$complaint 		= Complaint::find_by_sql($sql_mill);

	foreach($complaint as $complaint){
			
		$total_mill_complaint_closed++;

		$db_date 	= $complaint->date_;
		$today 		= $complaint->comp_closed_date;

		$start = new DateTime($db_date);
		$end = new DateTime($today);

		$interval = $end->diff($start);

		$mill_complaint_tat = $interval->days;
		$hours = $interval->h;

		$period = new DatePeriod($start, new DateInterval('P1D'), $end);

		foreach($period as $dt) {
			$curr = $dt->format('D');

			if ($curr == 'Sat' || $curr == 'Sun') {
				$mill_complaint_tat--;
			}	
		}
		
		$total_mill_complaint_tat += $mill_complaint_tat;
	}
	
	$average_mill_complaint_tat = $total_mill_complaint_tat / $total_mill_complaint_closed;
	if(is_nan($average_mill_complaint_tat)){ $average_mill_complaint_tat = 0; }

	echo "15 / ".round($average_mill_complaint_tat);
?></h2><p>Mill Turn Around Time</p></div>
<div class="comp-right"><img src="assets/images/complaints/2.png"></div>
<div class="clerfix"></div>
<div class="val"><a href="#" class="color-gr2">Average Closing Days</a></div>
</li>
	
<li style="width: 23%; margin: 1% 1%;">
<div class="comp-left"><h2><?php
	$complaint_all = Complaint::count_all_emp($session->employee_id);
	echo "<span class='app_note_plant'>{$complaint_all}</span>";
 
?></h2><p>Total Complaint Received</p></div>
<div class="comp-right"><i class="fa fa-inr" style="color: #e31837;"></i></div>
<div class="clerfix"></div>
<div class="val"><a href="my-complaints.php" class="color-gr3">View all</a></div>
</li>

<li style="width: 23%; margin: 1% 0 1% 1%;">
<div class="comp-left"><h2><?php
	$complaint_all = Complaint::count_status_emp('Closed',$session->employee_id);
	echo "<span class='app_note_mill'>{$complaint_all}</span>";
?></h2><p>Total Complaint Closed</p></div>
	<div class="comp-right"><i class="fa fa-inr" style="color: #ffbc00;"></i></div>
<div class="clerfix"></div>
<div class="val"><a href="my-complaints.php?status=Closed" class="color-gr4">View all</a></div>
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
	$bv_auto 		= Complaint::count_business_vertical_emp("Auto",$session->employee_id);
	$bv_crno 		= Complaint::count_business_vertical_emp("CRNO",$session->employee_id);
	$bv_crgo 		= Complaint::count_business_vertical_emp("CRGO",$session->employee_id);
	
	
	$emp_status_comp_reg 	= Complaint::count_emp_status_emp("Complaint Received",$session->employee_id);
	$emp_status_comp_att 	= Complaint::count_emp_status_emp("Complaint Attented",$session->employee_id);
	$emp_status_visit_con 	= Complaint::count_emp_status_emp("Visit Confirmed",$session->employee_id);
	$emp_status_mom_upld 	= Complaint::count_emp_status_emp("MOM Created",$session->employee_id);
	$emp_status_comp_acc 	= Complaint::count_emp_status_emp("Complaint Accepted",$session->employee_id);
	$emp_status_comp_rej 	= Complaint::count_emp_status_emp("Complaint Rejected",$session->employee_id);
	$emp_status_dec_pend 	= Complaint::count_emp_status_emp("Decision Pending",$session->employee_id);
	
	$emp_status_closed 		= Complaint::count_status_cust("Closed",$session->employee_id);
	$emp_status_invalid 	= Complaint::count_status_cust("Invalid",$session->employee_id);

	$source_mill 			= Complaint::count_identify_source_emp("Mill",$session->employee_id);
	$source_plant 			= Complaint::count_identify_source_emp("Plant",$session->employee_id);
	
	$complaint_type_cracking 	= Complaint::count_emp_complaint_type("Cracking",$session->employee_id);
	$complaint_type_surface 	= Complaint::count_emp_complaint_type("Surface Defect",$session->employee_id);
	$complaint_type_transit 	= Complaint::count_emp_complaint_type("Transit Damage",$session->employee_id);
	$complaint_type_processing 	= Complaint::count_emp_complaint_type("Processing",$session->employee_id);
	$complaint_type_packing 	= Complaint::count_emp_complaint_type("Packing",$session->employee_id);
?>
<script>
	
	$(document).ready(function() {
		$("#plant_vs_mill").load("analytics-plant-vs-mill.php");
		$("#mill_data").load("analytics-mill-data.php");
		$("#complaint_type").load("analytics-complaint-type.php");
		$("#company_wise").load("analytics-company-wise.php");
		
		
		var total = $('.app_note_mill').html();
		total = Math.round(total);
		var x=total;
		x=x.toString();
		var lastThree = x.substring(x.length-3);
		var otherNumbers = x.substring(0,x.length-3);
		if(otherNumbers != '')
			lastThree = ',' + lastThree;
		var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
		$('.app_note_mill').html(res);
		
		var total = $('.app_note_plant').html();
		total = Math.round(total);
		var x=total;
		x=x.toString();
		var lastThree = x.substring(x.length-3);
		var otherNumbers = x.substring(0,x.length-3);
		if(otherNumbers != '')
			lastThree = ',' + lastThree;
		var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
		$('.app_note_plant').html(res);
		
	});
</script>
<style>
	.apexcharts-toolbar {display: none;}
	.comp-left p {
		font-size: 13px !important;
	}
</style>
