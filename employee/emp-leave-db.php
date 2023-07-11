<?php ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	////date_default_timezone_set('Asia/Calcutta');

	foreach ($_POST as $key => $value) {
		//echo htmlspecialchars($key)." = ".htmlspecialchars($value)."<br>";
	}

	if(isset($_POST['status']) && !empty($_POST['status'])) {
				
		$employee = EmployeeReg::find_by_id($session->employee_id);
		
		$employee->emp_leave = $_POST['status'];
		
		if($employee->save()) {
			// Success
			echo "Status Updated Successfully.";
		} else {
			// Failure
			echo "Fail to Update Status";
		}
	}	else {
			echo "Data not Found";
	}
?>