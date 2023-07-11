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
		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != '' Limit 1";
		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
		if(!$employee_location){
			redirect_to("my-cvc.php"); 
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Complaint Type | Mahindraaccelo</title>
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
			<form method="get" enctype="multipart/form-data" autocomplete="off">
			<ul class="form-block-con">
				<li>
					<select id="business_vertical" name="business_vertical" class="form-control">
						<option value="">Source</option>
						<option <?php if(isset($_GET['business_vertical']) && !empty($_GET['business_vertical'])){if($_GET['business_vertical'] == "Auto"){ echo "Selected";}}?>>Auto</option>
						<option <?php if(isset($_GET['business_vertical']) && !empty($_GET['business_vertical'])){if($_GET['business_vertical'] == "CRNO"){ echo "Selected";}}?>>CRNO</option>
						<option <?php if(isset($_GET['business_vertical']) && !empty($_GET['business_vertical'])){if($_GET['business_vertical'] == "CRGO"){ echo "Selected";}}?>>CRGO</option>
					</select>
				</li>
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
						<input style="background: #e51937; border-radius: 5px;" type="submit" class="btn btn-danger btn-block" value="Search"/>
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
<div class="compl-lef"><h4>Complaint Type</h4></div>
	<div class="compl-rig"><a href="analytics.php"><i class="mdi mdi-arrow-left"></i> back</a></div>
<div class="clerfix"></div>
</div>

<table id="basic-datatable" class="table dt-responsive nowrap basic-datatable" width="100%">
<thead>
	<tr>
		<th>Steel Mill</th>
		<?php 				
			$sql = "Select * from complaint_type where department = 'Auto' order by complaint_type ASC";
			$complaint_type = ComplaintType::find_by_sql($sql);
			$ct_store = "";
			foreach($complaint_type as $complaint_type){	
				if($ct_store != $complaint_type->complaint_type){
					echo "<th>{$complaint_type->complaint_type}</th>";
				} $ct_store = $complaint_type->complaint_type;
			}
			echo "<th>Other</th>";
			echo "<th>Total</th>";
		?>
	</tr>
</thead>
<tbody>
<?php
	
	$mill_reg = MillReg::find_all();
	
	$num = 1;
	$total_total_complaint_received = 0;
	$total_complaint_other = 0;

	foreach($mill_reg as $mill_reg){
		
?>
	<tr>
		<td><?php echo $mill_reg->mill_name; ?></td>
<?php
	$sql = "Select * from complaint_type where department = 'Auto' order by complaint_type ASC";
	$complaint_type = ComplaintType::find_by_sql($sql);
	$ct_store = "";
	$total_total_complaint_received = 0;
	$total_complaint_other = 0;	
	$total_complaint_mill = 0;
	foreach($complaint_type as $complaint_type){	
		if($ct_store != $complaint_type->complaint_type){
			$total_complaint_received = 0;
			$total_complaint_closed = 0;

			if(isset($_GET['business_vertical']) || isset($_GET['date_range'])){
		
				$num = 0;
				if(!empty($_GET['business_vertical'])){
					$business_vertical = " business_vertical = '{$_GET['business_vertical']}' AND ";
					$num++;
				} else { $business_vertical = ""; }

				if(!empty($_GET['date_range'])){
					$from_date = strtok($_GET['date_range'], '-');
					$from_date = strtotime($from_date); 
					$from_date = date("Y-m-d", $from_date); 
					list(, $to_date) = explode('-', $_GET['date_range']);
					$to_date = strtotime($to_date); 
					$to_date = date("Y-m-d", $to_date); 

					$date_range = " date_ BETWEEN '{$from_date}' AND '{$to_date}' AND ";
					$num++;
				} else { $date_range = "";}

				if($num > 0){
					$sql = "Select * from complaint where emp_id = {$session->employee_id} AND {$business_vertical} {$date_range} date_ != '0000-00-00' order by id DESC";
					$complaint = Complaint::find_by_sql($sql);
				} else {
					$sql = "Select * from complaint where emp_id = {$session->employee_id} order by id DESC";
					$complaint = Complaint::find_by_sql($sql);
				}
			} else {
				$sql = "Select * from complaint where emp_id = {$session->employee_id} order by id DESC";
				$complaint = Complaint::find_by_sql($sql);
			}
			
			foreach($complaint as $complaint){   

				if($complaint->mill == $mill_reg->mill_name && $complaint->complaint_type == $complaint_type->complaint_type){
					$total_complaint_received++;
					$total_complaint_mill += $total_complaint_other;
				}
				if($complaint->mill == $mill_reg->mill_name && $complaint->complaint_type == 'Other'){
					$total_complaint_other++;
				}

			}
			
			echo "<td>{$total_complaint_received}</td>";
			$total_complaint_mill += $total_complaint_received;
			
		} $ct_store = $complaint_type->complaint_type;
	}
	echo "<td>{$total_complaint_other}</td>";
	echo "<td><strong>{$total_complaint_mill}</strong></td>";
?>
	</tr>
<?php } ?>
	<tr>
		<td>Plant</td>
<?php
	$sql = "Select * from complaint_type where department = 'Auto' order by complaint_type ASC";
	$complaint_type = ComplaintType::find_by_sql($sql);
	$ct_store = "";
	$total_total_complaint_received = 0;
	$total_complaint_other = 0;	
	$total_complaint_mill = 0;	
	foreach($complaint_type as $complaint_type){	
		if($ct_store != $complaint_type->complaint_type){
			$total_complaint_received = 0;
			$total_complaint_closed = 0;

			if(isset($_GET['business_vertical']) || isset($_GET['date_range'])){
		
				$num = 0;
				if(!empty($_GET['business_vertical'])){
					$business_vertical = " business_vertical = '{$_GET['business_vertical']}' AND ";
					$num++;
				} else { $business_vertical = ""; }

				if(!empty($_GET['date_range'])){
					$from_date = strtok($_GET['date_range'], '-');
					$from_date = strtotime($from_date); 
					$from_date = date("Y-m-d", $from_date); 
					list(, $to_date) = explode('-', $_GET['date_range']);
					$to_date = strtotime($to_date); 
					$to_date = date("Y-m-d", $to_date); 

					$date_range = " date_ BETWEEN '{$from_date}' AND '{$to_date}' AND ";
					$num++;
				} else { $date_range = "";}

				if($num > 0){
					$sql = "Select * from complaint where emp_id = {$session->employee_id} AND {$business_vertical} {$date_range} date_ != '0000-00-00' order by id DESC";
					$complaint = Complaint::find_by_sql($sql);
				} else {
					$sql = "Select * from complaint where emp_id = {$session->employee_id} order by id DESC";
					$complaint = Complaint::find_by_sql($sql);
				}
			} else {
				$sql = "Select * from complaint where emp_id = {$session->employee_id} order by id DESC";
				$complaint = Complaint::find_by_sql($sql);
			}
			
			foreach($complaint as $complaint){   

				if($complaint->identify_source == 'Plant' && $complaint->complaint_type == $complaint_type->complaint_type){
					$total_complaint_received++;
				}
				if($complaint->identify_source == 'Plant' && $complaint->complaint_type == 'Other'){
					$total_complaint_other++;
					$total_complaint_mill += $total_complaint_other;
				}

			}
			
			echo "<td>{$total_complaint_received}</td>";
			$total_complaint_mill += $total_complaint_received;
			
		} $ct_store = $complaint_type->complaint_type;
	}
	echo "<td>{$total_complaint_other}</td>";
	echo "<td><strong>{$total_complaint_mill}</strong></td>";
	
?>
	</tr>
</tbody>	
<tfoot>
	<tr style="background: #eee;">
		<td><strong>TOTAL</strong></th>
		<?php 
			$total_complaint_mill = 0;
			$sql = "Select * from complaint_type where department = 'Auto' order by complaint_type ASC";
			$complaint_type = ComplaintType::find_by_sql($sql);
			$ct_store = "";
			$total_total_complaint_received = 0;
			$total_complaint_other = 0;	
			foreach($complaint_type as $complaint_type){	
				if($ct_store != $complaint_type->complaint_type){
					$total_complaint_received = 0;
					$total_complaint_closed = 0;

					if(isset($_GET['business_vertical']) || isset($_GET['date_range'])){
		
						$num = 0;
						if(!empty($_GET['business_vertical'])){
							$business_vertical = " business_vertical = '{$_GET['business_vertical']}' AND ";
							$num++;
						} else { $business_vertical = ""; }

						if(!empty($_GET['date_range'])){
							$from_date = strtok($_GET['date_range'], '-');
							$from_date = strtotime($from_date); 
							$from_date = date("Y-m-d", $from_date); 
							list(, $to_date) = explode('-', $_GET['date_range']);
							$to_date = strtotime($to_date); 
							$to_date = date("Y-m-d", $to_date); 

							$date_range = " date_ BETWEEN '{$from_date}' AND '{$to_date}' AND ";
							$num++;
						} else { $date_range = "";}

						if($num > 0){
							$sql = "Select * from complaint where emp_id = {$session->employee_id} AND {$business_vertical} {$date_range} date_ != '0000-00-00' order by id DESC";
							$complaint = Complaint::find_by_sql($sql);
						} else {
							$sql = "Select * from complaint where emp_id = {$session->employee_id} order by id DESC";
							$complaint = Complaint::find_by_sql($sql);
						}
					} else {
						$sql = "Select * from complaint where emp_id = {$session->employee_id} order by id DESC";
						$complaint = Complaint::find_by_sql($sql);
					}
					foreach($complaint as $complaint){   

						if(!empty($complaint->identify_source) && $complaint->complaint_type == $complaint_type->complaint_type){
							$total_complaint_received++;
						}
						if(!empty($complaint->identify_source) && $complaint->complaint_type == 'Other'){
							$total_complaint_other++;
							$total_complaint_mill += $total_complaint_other;
						}

					}
					$total_complaint_mill += $total_complaint_received;

					echo "<td><strong>{$total_complaint_received}</strong></td>";

				} $ct_store = $complaint_type->complaint_type;
			}
			echo "<td><strong>{$total_complaint_other}</strong></td>";
			echo "<td><strong>{$total_complaint_mill}</strong></td>";
		?>
	</tr>
</tfoot>
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
<!-- END wrapper -->
<!-- third party js -->
<!-- <script src="assets/js/vendor/jquery.dataTables.js"></script> -->
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

<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.3/themes/hot-sneaks/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>	
<script type="application/javascript">	
	
	$(document).ready(function() {
		$('#basic-datatable').DataTable( {
			"scrollX": true
		} );
		
		$(".edit_meeting").click(function (e) {
			var meet_id = $(this).attr('data-id');				
			$("#meeting-form2 .modal-body").load("meeting-discussion.php?id="+meet_id);
		});
        
		

		function attachSlider() {
			$('.lowerlimit').val($('#mySlider').slider("values", 0));
			$('label.lowerlimit').html($('#mySlider').slider("values", 0));
			$('.upperlimit').val($('#mySlider').slider("values", 1));
			$('label.upperlimit').html($('#mySlider').slider("values", 1));
		}

		$('input').change(function(e) {
			var setIndex = (this.id == "upperlimit") ? 1 : 0;
			$('#mySlider').slider("values", setIndex, $(this).val())
		})


	});

	
	$(".clear_date").click(function(){
		$("#date_range").val("");
	});
	
	
	
	
//----------------------------------------------------------------------
	
	$("#department").change(function(){
		var department = this.value;
		$("#complaintType").load("search-complaint-type.php?department="+department);
	});	
		
	
	$("#complaintType").change(function(){
		var complaint 	= this.value.replace(" ","%20");
		var department 	= $("#department").val().replace(" ","%20");	
		$("#complaintSubType").load("search-complaint-sub-type.php?department="+department+"&&complaint="+complaint);
	});
	
</script>
<style>
	.select2-container {
		width: 100% !important;
	}
	
/* Interaction states----------------------------------*/
.ui-state-default,
.ui-widget-content .ui-state-default,
.ui-widget-header .ui-state-default {
	border: 1px solid #ebce35 !important;
	background: #ebce35 !important;
	font-weight: bold;
	color: #333333;
	border-radius: 20px;
}
.ui-state-default a,
.ui-state-default a:link,
.ui-state-default a:visited {
	color: #333333;
	text-decoration: none;
}
.ui-state-hover,
.ui-widget-content .ui-state-hover,
.ui-widget-header .ui-state-hover,
.ui-state-focus,
.ui-widget-content .ui-state-focus,
.ui-widget-header .ui-state-focus {
	border: 1px solid #999999;
	background: #ccd232 url("images/ui-bg_diagonals-small_75_ccd232_40x40.png") 50% 50% repeat;
	font-weight: bold;
	color: #212121;
}
.ui-state-hover a,
.ui-state-hover a:hover,
.ui-state-hover a:link,
.ui-state-hover a:visited,
.ui-state-focus a,
.ui-state-focus a:hover,
.ui-state-focus a:link,
.ui-state-focus a:visited {
	color: #212121;
	text-decoration: none;
}
.ui-state-active,
.ui-widget-content .ui-state-active,
.ui-widget-header .ui-state-active {
	border: 1px solid #ff6b7f;
	background: #db4865 url("images/ui-bg_diagonals-small_40_db4865_40x40.png") 50% 50% repeat;
	font-weight: bold;
	color: #ffffff;
}
.ui-state-active a,
.ui-state-active a:link,
.ui-state-active a:visited {
	color: #ffffff;
	text-decoration: none;
}
	
.ui-widget-header {
    border: 1px solid #bbb !important;
    background: #bbb !important;
    color: #e1e463;
    font-weight: bold;
}	
.ui-corner-all, .ui-corner-bottom, .ui-corner-right, .ui-corner-br {
    border-radius: 20px !important;
}
	
span.clear_img{
	cursor: pointer;
	color: #fff;
	background-color: #a00;
	border: 1px solid #900;
}
</style>	

</body>
</html>


