<?php
	require_once("../includes/initialize.php");

	if(isset($_GET['complaint']) && !empty($_GET['complaint'])){
		
		$business_vertical = Product::find_business_vertical($_GET['plant_location'], $_GET['product']);
		
		$sql = "Select * from sub_complaint_type where department_id={$business_vertical->department_id} AND complaint_type_id={$_GET['complaint']} AND status=1";
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
		
		echo "<option>Other</option>";
	} 	
?>