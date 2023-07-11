<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	require '../PHPMailer/PHPMailerAutoload.php';
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	//date_default_timezone_set('Asia/Calcutta');

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("my-account.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("my-cvaccountc.php");
		}
	}
	
	$employee_reg = EmployeeReg::find_by_id($session->employee_id);
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	if ($session->is_employee_logged_in()){ 
		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role = 'Viewer' Limit 1";
		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
		if(!$employee_location){
			redirect_to("logout.php"); 
		}
	}

	//date_default_timezone_set('Asia/Calcutta');
	
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

	if(isset($_POST['old_password']) && !empty($_POST['old_password']) && isset($_POST['new_password']) && !empty($_POST['new_password']) && isset($_POST['retype_password']) && !empty($_POST['retype_password'])) {
				
		$employee = EmployeeReg::find_by_id($session->employee_id);
		
		if($_POST['old_password'] != $employee->password){
			$session->message("Old Password is Wrong");
			redirect_to("my-account.php");
		}
		if(strlen($_POST['new_password']) < 6){
			$session->message("Enter minimum 6 Character Password");
			redirect_to("my-account.php");
		}
		if($_POST['retype_password'] != $_POST['new_password']){
			$session->message("New & Confirm Password Not Matched");
			redirect_to("my-account.php");
		}
		
		$employee->password = $_POST['new_password'];
		
		if($employee->save()) {
			// Success
			$session->message("Password Updated Successfully.");
			redirect_to("my-account.php");
		} else {
			// Failure
			$session->message("Fail to Change Password");
			redirect_to("my-account.php");
		}
		
	}	else {
			$session->message("Enter All Password Fields");
			redirect_to("my-account.php");
	}
?>


