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

	if(isset($_GET['id']) && !empty($_GET['id'])){
		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Query."); redirect_to("add-site-location.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Query."); redirect_to("add-site-location.php");
		}
	} else {
		$session->message("Company not found"); redirect_to("add-site-location.php");
	}


	if(isset($_GET['id']) && !empty($_GET['id'])){
		$employee_location = EmployeeLocation::find_by_id($_GET['id']);
	} 
?>


<div class="modal-header border-bottom-st d-block">
<!--<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<div class="form-p-hd">
<h2>Edit Employee Role</h2>
</div>


<div class="form-p-block">
<form action="edit-employee-location-db.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
<!-- box 1 -->
<div class="form-group">
	<label class="control-label">Employee</label>
	<select class="form-control select2" id="employee_2" name="employee" data-toggle="select2">
		<option value="">- Select Employee -</option>
		<?php
			$employee_reg = EmployeeReg::find_all();
			foreach($employee_reg as $employee_reg){
				echo "<option ";
				if($employee_location->emp_id == $employee_reg->id){echo "Selected";}
				echo " value='{$employee_reg->id}'>{$employee_reg->emp_name}, {$employee_reg->emp_email}</option>";
			}
		?>
	</select><br />
	<span class="err_msg employee_2_msg"></span>
</div>

<div class="form-group">
	<label class="control-label">Select Role</label>
	<select id="emp_sub_role_2" name="emp_sub_role" class="form-control select2"  data-toggle="select2">
		<option value="">- Select Approver -</option>
		<option <?php if($employee_location->emp_sub_role == "Employee"){echo "Selected";} ?>>Employee</option>
		<option <?php if($employee_location->emp_sub_role == "Viewer"){echo "Selected";} ?>>Viewer</option>		
		<option <?php if($employee_location->emp_sub_role == "CRM - Head"){echo "Selected";} ?>>CRM - Head</option>
		<option <?php if($employee_location->emp_sub_role == "Commercial Head"){echo "Selected";} ?>>Commercial Head</option>
		<option <?php if($employee_location->emp_sub_role == "Plant Chief - AN"){echo "Selected";} ?>>Plant Chief - AN</option>
		<option <?php if($employee_location->emp_sub_role == "Sales Head"){echo "Selected";} ?>>Sales Head</option>
		<option <?php if($employee_location->emp_sub_role == "CFO"){echo "Selected";} ?>>CFO</option>
		<option <?php if($employee_location->emp_sub_role == "MD"){echo "Selected";} ?>>MD</option>
		<option <?php if($employee_location->emp_sub_role == "Quality Assurance"){echo "Selected";} ?>>Quality Assurance</option>
		<option <?php if($employee_location->emp_sub_role == "Plant Head"){echo "Selected";} ?>>Plant Head</option>
		<option <?php if($employee_location->emp_sub_role == "Plant Chief - CN"){echo "Selected";} ?>>Plant Chief - CN</option>
		<option <?php if($employee_location->emp_sub_role == "Management Representative"){echo "Selected";} ?>>Management Representative</option>
	</select><br />
	<span class="err_msg emp_sub_role_2_msg"></span>
</div>
	
<div class="form-group">
	<label class="control-label">Role Priority</label>
	<select id="role_priority_2" name="role_priority" class="form-control select2"  data-toggle="select2">
		<option <?php if($employee_location->role_priority == "Responsible"){echo "Selected";} ?>>Responsible</option>
		<option <?php if($employee_location->role_priority == "Escalation 1"){echo "Selected";} ?>>Escalation 1</option>
		<option <?php if($employee_location->role_priority == "Escalation 2"){echo "Selected";} ?>>Escalation 2</option>
		<option <?php if($employee_location->role_priority == "None"){echo "Selected";} ?>>None</option>
	</select>
</div>	
<!-- box 1 -->



<div class="form-p-box form-p-boxbtn">
	<a class="fpcl" data-dismiss="modal" aria-hidden="true" href="#">Close</a>
	<input type="submit" class="fpdone" id="update_emp_location" value="Update">
</div>

<div class="clerfix"></div>
</form>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){		
        $(".select2").select2({
		  dropdownParent: $("#edit-new")
		});
		
    });

    $("#update_emp_location").click(function() {

		if ($("#employee_2").val() == "") {
			$("#employee_2").css("border","1px solid #f00");
			$(".employee_2_msg").show(); $(".employee_2_msg").html("Select Employee");
			return false;
		} else {
			$("#employee_2").css("border","1px solid #dee2e6"); $(".employee_2_msg").hide(); $(".employee_2_msg").html("");
		}

		if ($("#emp_sub_role_2").val() == "") {
			$("#emp_sub_role_2").css("border","1px solid #f00");
			$(".emp_sub_role_2_msg").show(); $(".emp_sub_role_2_msg").html("Select Employee Role");
			return false;
		} else {
			$("#emp_sub_role_2").css("border","1px solid #dee2e6"); $(".emp_sub_role_2_msg").hide(); $(".emp_sub_role_2_msg").html("");
		}
		
	});	
</script>

