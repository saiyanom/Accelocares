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

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$comp_meeting = ComplaintMeeting::find_by_id($_GET['id']);
	} else {
		$session->message("Complaint Meeting Not Found");
		redirect_to("my-complaints.php");
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
<form action="delete-complaint-meeting.php?cid=<?php echo $_GET['cid']; ?>&&id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
<div class="modal-header pr-4 pl-4 border-bottom-0 d-block">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
	<h4 class="modal-title">Visit Request</h4>
</div>
<div class="modal-body pt-3 pr-4 pl-4">
	<div class='row'>
		<div class='col-12 cldt-box'>
			<div class='form-group'><label class='control-label'><strong>Meeting Date</strong></label>
				<p><?php echo date( 'd-m-Y', strtotime($comp_meeting->meeting_date)); ?></p>
			</div>
		</div>
		<div class='col-12 cldt-box'>
			<div class='form-group'><label class='control-label'><strong>Place</strong></label>
				<p><?php echo $comp_meeting->place; ?></p>
			</div>
		</div>
		<div class='col-12 cldt-box'>
			<div class='form-group'><label class='control-label'><strong>Customer Coordinator (whom to meet)</strong></label>
				<p><?php echo $comp_meeting->customer_coordinator; ?></p>
			</div>
		</div>
		<div class='col-12 cldt-box'>
			<div class='form-group'><label class='control-label'><strong>Mobile Number</strong></label>
				<p><?php echo $comp_meeting->mobile; ?></p>
			</div>
		</div>
		<div class='col-12 cldt-box'>
			<div class='form-group'><label class='control-label'><strong>Email ID</strong></label>
				<p><?php echo $comp_meeting->email; ?></p>
			</div>
		</div>
	</div>
</div>
<div class="text-right pb-4 pr-4 evet-btn-min">
	<input type="submit" name="delete_meeting" class="btn save-event  evet-btn evet-btn-col2" value="Delete" />
	<button type="button" class="btn evet-btn evet-btn-col1" data-dismiss="modal">Close</button>
</div>
</form>