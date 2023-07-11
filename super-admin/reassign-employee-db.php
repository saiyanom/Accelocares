<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }
	////date_default_timezone_set('Asia/Calcutta');

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("all-complaints.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("all-complaints.php");
		}
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){

		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Document.");
			redirect_to("all-complaints.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Document.");
			redirect_to("all-complaints.php");
		}
	} else {
		$session->message("Complaint Not Found");
		redirect_to("all-complaints.php");
	}
	
?>
<!-- App css -->
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
<!-- App js -->
<script src="assets/js/app.min.js"></script>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#success-alert-modal').modal('show');
    });
</script>
<?php
	
	foreach ($_POST as $key => $value) {
		//echo htmlspecialchars($key)." = ".htmlspecialchars($value)."<br>";
	}
	//return false;

	$complaint 	= Complaint::find_by_id($_GET['id']);
	$employee	= EmployeeReg::find_by_id($_POST['employee']);


	$complaint->emp_id					= $employee->id;
	$complaint->emp_name				= $employee->emp_name;


	if($complaint->save()) {
?>
		<!-- Success Alert Modal -->
		<div id="success-alert-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content modal-filled bg-success">
					<div class="modal-body p-4">
						<div class="text-center">
							<i class="dripicons-checkmark h1"></i>
							<h2 class="mt-2">Successfull</h2>
							<p class="mt-3" style="font-size:18px;"><?php echo $employee->emp_name?> is assigned to this Complaint</p>
							<a href="all-complaints.php" class="btn btn-light my-2">Continue</a>
						</div>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
<?php
		// Success
		//$session->message("Complaint Raised Successfully");
		//redirect_to("my-complaints.php");
	} else {
		// Failure
		$session->message("Failed to Raise Complaint");
		redirect_to("all-complaints.php");
	}
	
?>


