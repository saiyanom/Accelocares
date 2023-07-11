<?php
	require_once("../includes/initialize.php");

	if(isset($_GET['complaint']) && !empty($_GET['complaint'])){
		
		
		$sql = "Select * from sub_complaint_type where department_id={$_GET['department']} AND complaint_type_id={$_GET['complaint']} AND status=1 order by sub_complaint_type ASC";
		$sub_complaint = SubComplaintType::find_by_sql($sql);
		//$sub_complaint = SubComplaintType::find_all();
		echo "<option value=''>- Sub Complaint Type -</option>";
		foreach($sub_complaint as $sub_complaint){
			if(empty($sub_complaint->sub_complaint_type)){
				echo "<option value=''>None</option>";
			} else {
				echo "<option>{$sub_complaint->sub_complaint_type}</option>";
			}
		}
	} 	
?>