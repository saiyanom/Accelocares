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

		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != 'Employee' Limit 1";

		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);

		if(!$employee_location){
			redirect_to("logout.php?"); 
		}
	} else { redirect_to("logout.php"); }
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindraaccelo Team CVC</title>
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
		padding: 5px 0px 5px 5px !important;
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

<?php  $message = output_message($message); ?>
<div class="alert fade show text-white <?php 
	if($message == "CAPA Approved"){echo "bg-success";} 
	else {echo "bg-danger";}?>" 
<?php if(empty($message)){echo " style='display:none';";} else {echo " style='margin-top:20px';";} ?> >
<a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
<?php echo $message; ?>
</div>
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
				<li><select id="emp_name" name="emp_name" class="form-control select2" data-toggle="select2">
					<option value="">- Select Employee -</option>
					<?php
						$employee_reg = EmployeeReg::find_by_id($session->employee_id);
						if ($employee_reg){ 
							$product_id = '';
							$emp_email = '';
							$num = 1;
							$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} order by product_id ASC";
							$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
							if($employee_location){
								foreach($employee_location as $employee_location){
									if($product_id != $employee_location->product_id){
										
										$emp_location = EmployeeLocation::find_by_products_id($employee_location->product_id);
										foreach($emp_location as $emp_location){
											
											if(strpos($emp_email, $emp_location->emp_email) === false){
												echo "<option ";
												if(isset($_GET['emp_name']) && !empty($_GET['emp_name'])){
													if($_GET['emp_name'] == $emp_location->emp_id){ echo "Selected";}
												}
												echo " value='{$emp_location->emp_id}'>{$emp_location->emp_name}</option>";
													$emp_email .= " ".$emp_location->emp_email;
											}
										}
									}$product_id = $employee_location->product_id; 	
								}
							}
						}
					?>
				</select></li>
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
							<input readonly type="text" value="<?php if(isset($_GET['date_range'])){ echo $_GET['date_range'];} ?>" id="date_range" name="date_range" placeholder="Select Date Range" class="form-control date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="false">
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
<div class="compl-lef"><h4>Team CVC</h4></div>
<div class="clerfix"></div>
</div>

<table id="my-complaints" class="table dt-responsive nowrap basic-datatable" width="100%">
<thead>
	<tr>
		<th>Sr. No</th>
		<th>Employee</th>
		<th>Date</th>
		<th>Customer Name</th>
		<th>Place</th>
		<th>Meeting Status</th>
		<th>Meeting Discussion</th>
		<th>Action</th>
	</tr>
</thead>
<tbody>
<?php
	
	if(isset($_GET['emp_name']) || isset($_GET['meet_status']) || isset($_GET['date_range'])){
		
		$num = 0;
		if(!empty($_GET['emp_name'])){
			$emp_name = EmployeeReg::find_by_id($_GET['emp_name']);
			$emp_name = " emp_id = '{$emp_name->id}' AND ";
			$num++;
		} else { $emp_name = ""; }
		
		if(!empty($_GET['meet_status'])){
			$meet_status = " status = '{$_GET['meet_status']}' AND ";
			$num++;
		} else { 
			if($_GET['meet_status'] == '0'){
				$meet_status = " status = '{$_GET['meet_status']}' AND ";
				$num++;
			}else {
				$meet_status = " status >=0 AND ";
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

			if($num > 0){
				$sql = "Select * from cvc_meeting where {$emp_name} {$meet_status} {$date_range} date_ != '0000-00-00' order by id DESC";
				$comp_meet = CvcMeeting::find_by_sql($sql);
				if($comp_meet){
					foreach($comp_meet as $comp_meet){

						if(strpos($emp_email, $comp_meet->emp_email) !== false){
							?>
								<tr>
								<td><?php echo $num; ?></td>
								<td><?php echo $comp_meet->emp_name; ?></td>
								<td><?php echo date( 'd-m-Y', strtotime($comp_meet->meeting_date)); ?></td>
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
							<?php $num++; 
						}
						
					} 
				}
					$emp_email .= " ".$emp_location->emp_email;
			} else {
				$employee_reg = EmployeeReg::find_by_id($session->employee_id);
				if ($employee_reg){ 
					$product_id = '';
					$emp_email = '';
					$num = 1;
					$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} order by product_id ASC";
					$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
					if($employee_location){
						foreach($employee_location as $employee_location){
							if($product_id != $employee_location->product_id){
								
								$emp_location = EmployeeLocation::find_by_products_id($employee_location->product_id);
								foreach($emp_location as $emp_location){
									
									if(strpos($emp_email, $emp_location->emp_email) === false){

										$comp_meet = CvcMeeting::find_by_emp_email($emp_location->emp_email);
										if($comp_meet){
											foreach($comp_meet as $comp_meet){
												//echo $employee_location->product_id." - ".$comp_meet->emp_email."<br />";
												?>
													<tr>
													<td><?php echo $num; ?></td>
													<td><?php echo $comp_meet->emp_name; ?></td>
													<td><?php echo date( 'd-m-Y', strtotime($comp_meet->meeting_date)); ?></td>
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
												<?php $num++; 
											} 
										}
											$emp_email .= " ".$emp_location->emp_email;
										}
										
									}
								}$product_id = $employee_location->product_id; 	
							}
						}
					}
				}

			
	} else {
		if(isset($session->employee_id)){		
			$employee_reg = EmployeeReg::find_by_id($session->employee_id);
			if ($employee_reg){ 
				$product_id = '';
				$emp_email = '';
				$num = 1;
				$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} order by product_id ASC";
				$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
				if($employee_location){
					foreach($employee_location as $employee_location){
						if($product_id != $employee_location->product_id){
							
							$emp_location = EmployeeLocation::find_by_products_id($employee_location->product_id);
							foreach($emp_location as $emp_location){
								
								if(strpos($emp_email, $emp_location->emp_email) === false){
									$comp_meet = CvcMeeting::find_by_emp_email($emp_location->emp_email);
									if($comp_meet){
										foreach($comp_meet as $comp_meet){
											//echo $employee_location->product_id." - ".$comp_meet->emp_email."<br />";
											?>
												<tr>
												<td><?php echo $num; ?></td>
												<td><?php echo $comp_meet->emp_name; ?></td>
												<td><?php echo date( 'd-m-Y', strtotime($comp_meet->meeting_date)); ?></td>
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
											<?php $num++; 
										} 
									}
										$emp_email .= " ".$emp_location->emp_email;
									}
								}
							}$product_id = $employee_location->product_id; 	
						}
					}
				}
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
	                columns: [0,1,2,3,4,5,6]
	            }	          
	       }],
			"lengthMenu": [[50, 25, 50, -1], [50, 25, 50, "All"]],
			"language": {
				"info": "_START_-_END_ of _TOTAL_ entries",
				searchPlaceholder: "Search"
			},
		} );
		
		$('.buttons-csv span').html('Download Excel');
		
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


