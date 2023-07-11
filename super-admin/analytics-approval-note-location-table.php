<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }
	////date_default_timezone_set('Asia/Calcutta');


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

	if(isset($_GET['date_range'])){
		if (!preg_match('/^[0-9-\/ ]+$/D', $_GET['date_range'])){
			$session->message("Invalid Date."); redirect_to("analytics.php");
		}
	}

	if(isset($_GET['business_vertical'])){
		if(is_numeric($_GET['business_vertical'])) {
			$session->message("Invalid Business Vertical."); redirect_to("analytics.php");
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Approval Note - Location | Mahindraaccelo</title>
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
<div class="compl-lef"><h4>Approval Note - Location</h4></div>
	<div class="compl-rig"><a href="analytics.php"><i class="mdi mdi-arrow-left"></i> back</a></div>
<div class="clerfix"></div>
</div>

<table id="basic-datatable" class="table dt-responsive nowrap basic-datatable" width="100%">
<thead>
	<tr>
		<th>Location</th>
		<th>CN issued to <br />Customer on account of Rejection</th>
		<th>Debit Note <br />Issues to Supplier </th>
		<th>Loss as per <br />Approval Note</th>		
	</tr>
</thead>
<tbody>
<?php
	
	$sql = "Select * from site_location order by site_location ASC";
	$site_location = SiteLocation::find_by_sql($sql);
	$repeat = "";
	
	
	$total_credit_note_iss_cust = 0;
	$total_debit_note_iss_supplier = 0;
	$total_loss_per_approval_note = 0;

	foreach($site_location as $site_location){
		if($repeat != $site_location->site_location){
		
?>
	
<?php
	$total_qty_rejc = 0;
	$credit_note_iss_cust = 0;
	$debit_note_iss_supplier = 0;
	$loss_per_approval_note = 0;

	$approval_note = ApprovalNote::find_all();
	foreach($approval_note as $approval_note){  
		
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
				$sql = "Select * from complaint where id = '{$approval_note->complaint_id}' AND {$business_vertical} {$date_range} date_ != '0000-00-00' order by id DESC Limit 1";
				$complaint = Complaint::find_by_sql($sql);
			} else {
				$sql = "Select * from complaint where id = '{$approval_note->complaint_id}' AND {$business_vertical} {$date_range} date_ != '0000-00-00' order by id DESC Limit 1";
				$complaint = Complaint::find_by_sql($sql);
			}
		} else {
			$sql = "Select * from complaint where id = '{$approval_note->complaint_id}' AND date_ != '0000-00-00' order by id DESC Limit 1";
			$complaint = Complaint::find_by_sql($sql);
		}

		//$complaint = Complaint::find_by_id($approval_note->complaint_id);
		if($complaint){
			foreach($complaint as $complaint){
				if($complaint->plant_location == $site_location->site_location){
					$credit_note_iss_cust 		+= $approval_note->credit_note_iss_cust;
					$debit_note_iss_supplier 	+= $approval_note->debit_note_iss_supplier;
					$loss_per_approval_note 	= $credit_note_iss_cust - $debit_note_iss_supplier;
				}
			}
			
		}
	}
	$total_credit_note_iss_cust 	+= $credit_note_iss_cust;
	$total_debit_note_iss_supplier 	+= $debit_note_iss_supplier;
	$total_loss_per_approval_note 	+= $loss_per_approval_note;

	echo "<tr>";
	echo "<td>{$site_location->site_location}</td>";
	echo "<td>{$credit_note_iss_cust}</td>";
	echo "<td>{$debit_note_iss_supplier}</td>";
	echo "<td>{$loss_per_approval_note}</td>";
	echo "</tr>";
?>
	
<?php } $repeat = $site_location->site_location; }?>
</tbody>	
<tfoot>
<?php 
	
	
	echo "<tr>";
	echo "<td><strong>TOTAL</strong></td>";
	echo "<td><strong>{$total_credit_note_iss_cust}</strong></td>";
	echo "<td><strong>{$total_debit_note_iss_supplier}</strong></td>";
	echo "<td><strong>{$total_loss_per_approval_note}</strong></td>";
	echo "</tr>";
?>
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


