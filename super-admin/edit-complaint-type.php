<?php
ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("complaint-type.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+-]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("complaint-type.php");
		}
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Query."); redirect_to("complaint-type.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Query."); redirect_to("complaint-type.php");
		}
	} else {
		$session->message("Company not found"); redirect_to("complaint-type.php");
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$sub_complaint_type_reg = SubComplaintType::find_by_id($_GET['id']);
	} else {
		echo "Complaint not found";
	}
	
?>
<div class="modal-header border-bottom-st d-block">
<!--<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<div class="form-p-hd">
<h2>Edit Complaint Type</h2>
</div>


<div class="form-p-block">
<form action="edit-complaint-type-db.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
	
<div class="form-group"><label class="control-label">Department</label>
	<select class="form-control select2" id="department_2" name="department" data-toggle="select2">
		<option value="">- Select Department -</option>
		<?php
			
			$department = Department::find_all();
			
			foreach($department as $department){
				echo "<option ";
				if($sub_complaint_type_reg->department == $department->department){
					echo " Selected ";
				}
				echo " value='{$department->id}'>{$department->department}</option>";
			}
		?>
	</select><br />
	<span class="err_msg department_2_msg"></span>
</div>
	
<!-- box 1 -->
<div class="form-group"><label class="control-label">Type of Complaint</label>
	<select class="form-control select2" id="complaint_type_2" name="complaint_type" data-toggle="select3">
		<option value="">- Select Complaint Type -</option>
		<option value="new_complaint_type">- Add New Complaint Type -</option>
		<optgroup label="Select">
			<?php
				$sql_comp_type = "Select * from complaint_type order by complaint_type ASC";
				$complaint_type = ComplaintType::find_by_sql($sql_comp_type);
				$complaint_type_data = "";
				foreach($complaint_type as $complaint_type){
					if($complaint_type_data != $complaint_type->complaint_type){
						echo "<option ";
						if($sub_complaint_type_reg->complaint_type == $complaint_type->complaint_type){
							echo " selected ";
							//echo "<option selected>{$complaint_type->complaint_type}</option>";
						} else {
							//echo "<option>{$complaint_type->complaint_type}</option>";
						}
						echo ">{$complaint_type->complaint_type}</option>";
					} $complaint_type_data = $complaint_type->complaint_type;
				}
			?>
		</optgroup>
	</select><br />
	<span class="err_msg complaint_type_2_msg"></span>
</div>
<div class="form-group" id="complaint_type_new_2" style="display: none;"><input class="form-control form-p-box-bg1" placeholder="New Complaint Type" type="text" name="complaint_type_new"></div>	
<!-- box 1 -->


<!-- box 1 -->
<div class="form-group"><label class="control-label">Sub Complaint Type</label>
	<select class="form-control select2" id="sub_complaint_type_2" name="sub_complaint_type" data-toggle="select3">
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
						echo "<option ";
						if($sub_complaint_type_reg->sub_complaint_type == $sub_complaint_type->sub_complaint_type){
							echo "Selected";
						}
						echo ">{$sub_complaint_type->sub_complaint_type}</option>";
					}					
					$stored_pro = $sub_complaint_type->sub_complaint_type;
				}
			?>
		</optgroup>
	</select><br />
	<span class="err_msg sub_complaint_type_2_msg"></span>
</div>
<div class="form-group" id="sub_complaint_type_new_2" style="display: none;"><input class="form-control form-p-box-bg1" placeholder="New Sub Complaint Type" type="text" name="sub_complaint_type_new"></div>	
<!-- box 1 -->

<div class="form-p-box form-p-boxbtn">
	<a class="fpcl" data-dismiss="modal" aria-hidden="true" href="#">Close</a>
	<input type="submit" id="update_complaint_type" class="fpdone" value="Update">
</div>

<div class="clerfix"></div>
</form>
</div>
</div>


<script src="assets/js/app.min.js"></script>

<script type="application/javascript">
	
	$("#complaint_type_2").change(function (e) {
		var complaint_type = $(this).val();
				
		if(complaint_type == 'new_complaint_type'){
			$("#complaint_type_new_2").show();
		} else {
			$("#complaint_type_new_2 input").val('');
			$("#complaint_type_new_2").hide();
		}
	});
	
	$("#sub_complaint_type_2").change(function (e) {
		var sub_complaint_type = $(this).val();
				
		if(sub_complaint_type == 'new_sub_complaint_type'){
			$("#sub_complaint_type_new_2").show();
		} else {
			$("#sub_complaint_type_new_2 input").val('');
			$("#sub_complaint_type_new_2").hide();
		}
	});
	
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".select2").select2({
		  dropdownParent: $("#edit-new")
		});
    });

 $("#update_complaint_type").click(function() {
	


	if ($("#department_2").val() == "") {
		$("#department_2").css("border","1px solid #f00");
		$(".department_2_msg").show(); $(".department_2_msg").html("Enter Department");
		return false;
	} else {
		$("#department_2").css("border","1px solid #dee2e6"); $(".department_2_msg").hide(); $(".department_2_msg").html("");
	}

	if ($("#complaint_type_2").val() == "") {
		$("#complaint_type_2").css("border","1px solid #f00");
		$(".complaint_type_2_msg").show(); $(".complaint_type_2_msg").html("Enter Complaint Type");
		return false;
	} else {
		$("#complaint_type_2").css("border","1px solid #dee2e6"); $(".complaint_type_2_msg").hide(); $(".complaint_type_2_msg").html("");
	}


	
});	

</script>


	

