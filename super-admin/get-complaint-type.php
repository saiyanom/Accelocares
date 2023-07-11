<?php
	require_once("../includes/initialize.php");

	if(isset($_GET['product']) && !empty($_GET['product'])){
		
		$business_vertical = Product::find_business_vertical($_GET['plant_location'], $_GET['product']);
		
		$sql = "Select * from complaint_type where department_id={$business_vertical->department_id} AND status=1 order by complaint_type ASC";
		$complaint = ComplaintType::find_by_sql($sql);
		//$sub_complaint = SubComplaintType::find_all();
		echo "<option value=''>- Complaint Type - </option>";
		foreach($complaint as $complaint){
			
			if(empty($complaint->complaint_type)){
				echo "<option value=''>None</option>";
			} else {
				echo "<option value='$complaint->id'>{$complaint->complaint_type}</option>";
			}
		} echo "<option>Other</option>";
	} 	
?>