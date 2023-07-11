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
<title>Mahindra Accelo CRM</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content=" " name="description" />
<meta content="Coderthemes" name="author" />

<style>
	.fc-right{ display:none}
	.fc-center{ float:right}
	.fc-today-button{ display:none}
</style>

<!-- new style -->
<style>
.block-btn{ margin:30px 0}
.log-btn-n{ margin:10px 0; padding:0 40px 0 0}
.log-btn-n a{ width:100%; color:#fff}
.log-btn-n a:hover{ color:#000; opacity:0.8}
.btn-primary001{ background:#71bf44!important}
.btn-primary002{ background:#04b0c4!important}


	.fc-right{ display:none}
	.fc-center{ float:right}
	.fc-today-button{ display:none}


	.block-btn{ margin:30px 0}
	.log-btn-n{ margin:10px 0; padding:0 40px 0 0}
	.log-btn-n a{ width:100%; color:#fff}
	.log-btn-n a:hover{ color:#000; opacity:0.8}
	.btn-primary001{ background:#71bf44!important}
	.btn-primary002{ background:#04b0c4!important}

	.mg-colorbox{padding:5px 10px; background:#f0f3f4}
	.mgcolor{ margin:10px auto;}
	.mgcolor span{display: inline-block; border-radius:10px; margin:0 4px -3px 0;width:15px;height:15px}
	.mgcolor1 span{background:#3a87ad;}
	.mgcolor2 span{background:#71bf44;}
	.mgcolor3 span{background:#e31837;}
	.mgcolor4 span{background:#26b3f0;}
</style>
<!-- new style -->
<!-- new style -->



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

<!-- start page title -->
<div class="col-12 pt-4">
 <h4>Customer Visit Calendar - All History</h4>
</div>   
<!-- end page title --> 
<?php  $message = output_message($message); ?>
	<div class="alert fade show text-white <?php 
		if($message == "Meeting Added Successfully"){echo "bg-success";} 
		else if($message == "Complaint Updated Successfully"){echo "bg-success";} 		
		else if($message == "Approval Note Created Successfully"){echo "bg-success";} 		
		else if($message == "CAPA Created Successfully"){echo "bg-success";} 	
		else if($message == "Meeting Deleted Successfully."){echo "bg-success";} 	
		else if($message == "CAPA Document Uploaded Successfully"){echo "bg-success";} 	
		else if($message == "Status Updated Successfully."){echo "bg-success";} 	
		else {echo "bg-danger";}?>" 
	<?php if(empty($message)){echo " style='display:none';";} else {echo " style='margin-top:20px';";} ?> >
	<a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
	<?php echo $message; ?>
	</div>


<div class="complaints-blocks2" >
<div class="cb-block">



<div class="onlock" style="border-bottom:0">
<div class="onlock-1" style="width: 25%;">

<!-- new -->
<div class="block-btn">
	<div class="log-btn-n">
		<a href="#" data-toggle="modal" data-target="#meeting-form1" class="btn btn-primary001">
			<i class="mdi mdi-plus-circle-outline"></i> Create New Meeting
		</a>
	</div>
	<div class="log-btn-n"><a class="btn btn-primary002" href="cvc-list.php">List View</a></div>

	<div class="log-btn-n">
	<div class="mg-colorbox ">
	<div class="mgcolor mgcolor1"><p><span></span> - New</p></div>
	<div class="mgcolor mgcolor2"><p><span></span> - Completed</p></div>
	<div class="mgcolor mgcolor3"><p><span></span> - Cancelled</p></div>
	<div class="mgcolor mgcolor4"><p><span></span> - Rescheduled</p></div>
	</div></div>

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



<!-- new -->



</div>
<div class="onlock-2">   
<div class="cldblock">
 <div id="calendar"></div>
</div>

<div class="clerfix"></div>
</div>



<div class="clerfix"></div>
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

    <link href="assets/css/vendor/fullcalendar.min.css" rel="stylesheet" type="text/css" />      <!-- third party js -->
	<script src="assets/js/vendor/jquery-ui.min.js"></script>
	<script src="assets/js/vendor/fullcalendar.min.js"></script>
	<script src="assets/js/cvc-script.js"></script>
	
	
	<!-- third party js ends -->

	<!-- demo app 
		<script src="assets/js/pages/demo.calendar.js"></script>
	<!-- end demo js-->

<!-- fancyBox Js includ -->
<?php include 'fancyboxjs.php'?>
<!-- fancyBox Js includ -->
<script>
	$('#calendar').fullCalendar({
		  events: [
			<?php
				$sql = "Select * from cvc_meeting where emp_id = '{$session->employee_id}'";
				$comp_meet = CvcMeeting::find_by_sql($sql);
	
				foreach($comp_meet as $comp_meet){
			?>
			  	{
				  id  	 : <?php echo $comp_meet->id; ?>,
				  cid  	 : <?php echo $comp_meet->comp_id; ?>,
				  title  : '<?php echo $comp_meet->comp_name; ?>',
				  start  : '<?php echo $comp_meet->meeting_date; ?>',
				  color  : <?php if($comp_meet->meeting_status == "Yes"){echo "'#71bf44'";} else if($comp_meet->meeting_status == "No"){echo "'#e31837'";} else if($comp_meet->meeting_status == "Reschedule"){echo "'#0fb3f0'";} else {echo "'#3a87ad'";} ?>
				},
			<?php		
				}
			?>  
		  ],
		  eventColor: '#efefef',
		  eventClickClick: function(event) {
			  console.log(event.start, " - ", event.id);
			  console.log(event.start['_i'], " - ", event.title);
			  $('#meeting-form2').modal('toggle');
			  
			  var data_id = $(this).attr('data-id');
			  $("#meeting-form2 .modal-body").load("meeting-discussion.php?id="+event.id);
		  },
		  header:{
                left: "prev,next today",
                center: "title",
                right: "month,agendaWeek,agendaDay"
          }
	});
	
	var calendar = $('#calendar').fullCalendar('getCalendar');

	calendar.on('dayClick', function(date, jsEvent, view) {
		$(".select2").select2({
		  dropdownParent: $("#meeting-form1")
		});
		
		console.log('clicked on ' + date.format());	
		$('#meeting-form1').modal('toggle');
		
		$('#meeting_date').val($.fullCalendar.formatDate( date, "MM/DD/YYYY"));
		
		//$("#meeting_date").val();
	});
	
	$(document).ready(function() {

		$(".btn-primary001").click(function(){
			$(".select2").select2({
			  dropdownParent: $("#meeting-form1")
			});
		});
		
		
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
</style>
</body>
</html>


