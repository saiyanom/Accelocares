<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("add-site-location.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+-]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("add-site-location.php");
		}
	}
?>




<div class="modal-header border-bottom-st d-block">
<!--<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<div class="form-p-hd">
<h2>Add New Complaint Type</h2>
</div>


<div class="form-p-block">
<form action="add-complaint-type-db.php" method="post" enctype="multipart/form-data" autocomplete="off">
	
<div class="form-group"><label class="control-label">Department</label>
	<select class="form-control select2" id="department" name="department" data-toggle="select2">
		<option value="">- Select Department -</option>
		<?php
			$department = Department::find_all();
			foreach($department as $department){
				echo "<option value='{$department->id}'>{$department->department}</option>";
			}
		?>
	</select><br />
	<span class="err_msg department_msg"></span>
</div>
	
<!-- box 1 -->
<div class="form-group"><label class="control-label">Type of Complaint</label>
	<select class="form-control select2" id="complaint_type" name="complaint_type" data-toggle="select2">
		<option value="">- Select Complaint Type -</option>
		<option value="new_complaint_type">- Add New Complaint Type -</option>
		<optgroup label="Select">
			<?php
				$sql_comp_type = "Select * from complaint_type order by complaint_type ASC";
				$complaint_type = ComplaintType::find_by_sql($sql_comp_type);
				$complaint_type_data = "";
				foreach($complaint_type as $complaint_type){
					if($complaint_type_data != $complaint_type->complaint_type){
						echo "<option>{$complaint_type->complaint_type}</option>";
					} $complaint_type_data = $complaint_type->complaint_type;
				}
			?>
		</optgroup>
	</select><br />
	<span class="err_msg complaint_type_msg"></span>
</div>
<div class="form-group" id="complaint_type_new" style="display: none;"><input class="form-control form-p-box-bg1" placeholder="New Complaint Type" type="text" name="complaint_type_new"></div>	
<!-- box 1 -->


<!-- box 1 -->
<div class="form-group"><label class="control-label">Sub Complaint Type</label>
	<select class="form-control select2" id="sub_complaint_type" name="sub_complaint_type" data-toggle="select2">
		<option value="">- Select Sub Complaint Type -</option>
		<option value="new_sub_complaint_type">- Add Sub Complaint Type -</option>
		<option value="">None</option>
		<optgroup label="Select">
			<?php
				$sql_sub_comp_type = "Select * from sub_complaint_type order by sub_complaint_type ASC";
				$sub_complaint_type = SubComplaintType::find_by_sql($sql_sub_comp_type);
				$stored_pro = "";
				foreach($sub_complaint_type as $sub_complaint_type){
					if($stored_pro != $sub_complaint_type->sub_complaint_type) {
						if(!empty($sub_complaint_type->sub_complaint_type)){
							echo "<option>{$sub_complaint_type->sub_complaint_type}</option>";
						}
					} $stored_pro = $sub_complaint_type->sub_complaint_type;					
				}
			?>
		</optgroup>
	</select><br />
	<span class="err_msg sub_complaint_type_msg"></span>
</div>
<div class="form-group" id="sub_complaint_type_new" style="display: none;"><input class="form-control form-p-box-bg1" placeholder="New Sub Complaint Type" type="text" name="sub_complaint_type_new"></div>	
<!-- box 1 -->

<div class="form-p-box form-p-boxbtn">
	<a class="fpcl" data-dismiss="modal" aria-hidden="true" href="#">Close</a>
	<input type="submit" id="create_complaint_type" class="fpdone" value="Add">
</div>

<div class="clerfix"></div>
</form>
</div>
</div>

<!-- end modal-body-->



<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>		
<script src="assets/js/app.min.js"></script>

<script type="text/javascript">
	$("#complaint_type").change(function (e) {
		var complaint_type = $(this).val();
				
		if(complaint_type == 'new_complaint_type'){
			$("#complaint_type_new").show();
		} else {
			$("#complaint_type_new input").val('');
			$("#complaint_type_new").hide();
		}
	});
	
	$("#sub_complaint_type").change(function (e) {
		var sub_complaint_type = $(this).val();
				
		if(sub_complaint_type == 'new_sub_complaint_type'){
			$("#sub_complaint_type_new").show();
		} else {
			$("#sub_complaint_type_new input").val('');
			$("#sub_complaint_type_new").hide();
		}
	});
</script>
