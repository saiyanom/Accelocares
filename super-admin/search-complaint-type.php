<?php
	require_once("../includes/initialize.php");

	if(isset($_GET['department']) && !empty($_GET['department'])){
		
		$sql = "Select * from complaint_type where department_id = '{$_GET['department']}'";
		$complaint = ComplaintType::find_by_sql($sql);

		echo "<option value=''>- Complaint Type - </option>";
		foreach($complaint as $complaint){
			if(empty($complaint->complaint_type)){
				echo "<option value=''>None</option>";
			} else {
				echo "<option value='$complaint->id'>{$complaint->complaint_type}</option>";				
			}
		}
	} 	
?>