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
		$complaint_escalation = ComplaintEscalation::find_by_id($_GET['id']);
	} 
?>

<div class="modal-header border-bottom-st d-block">
<!--<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<div class="form-p-hd">
<h2>Edit Employee to Product</h2>
</div>


<div class="form-p-block">
<form action="edit-complaint-escalation-db.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
<!-- box 1 -->
<div class="form-group">
	<label class="control-label">Employee</label>
	<select class="form-control select2" id="employee_2" name="employee" data-toggle="select2">
		<option value="">- Select Employee -</option>
		<?php
			$employee_reg = EmployeeReg::find_all();
			foreach($employee_reg as $employee_reg){
				echo "<option ";
				if($complaint_escalation->emp_id == $employee_reg->id){echo "Selected";}
				echo " value='{$employee_reg->id}'>{$employee_reg->emp_name}, {$employee_reg->emp_email}</option>";
			}
		?>
	</select><br />
	<span class="err_msg employee_2_msg"></span>
</div>
	
<div class="form-group">
	<label class="control-label">Role Priority</label>
	<select id="role_priority_2" name="role_priority" class="form-control select2"  data-toggle="select2">
		<option <?php if($complaint_escalation->role_priority == "Escalation 1"){echo "Selected";} ?>>Escalation 1</option>
		<option <?php if($complaint_escalation->role_priority == "Escalation 2"){echo "Selected";} ?>>Escalation 2</option>
		<option <?php if($complaint_escalation->role_priority == "Escalation 3"){echo "Selected";} ?>>Escalation 3</option>
		<option <?php if($complaint_escalation->role_priority == "Escalation 4"){echo "Selected";} ?>>Escalation 4</option>
	</select><br />
	<span class="err_msg role_priority_2_msg"></span>
</div>	
<!-- box 1 -->



<div class="form-p-box form-p-boxbtn">
	<a class="fpcl" data-dismiss="modal" aria-hidden="true" href="#">Close</a>
	<input type="submit" class="fpdone" id="update_comp_escalations" value="Update">
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

    $("#update_comp_escalation").click(function() {
	
		if ($("#employee_2").val() == "") {
			$("#employee_2").css("border","1px solid #f00");
			$(".employee_2_msg").show(); $(".employee_2_msg").html("Select Employee");
			return false;
		} else {
			$("#employee_2").css("border","1px solid #dee2e6"); $(".employee_2_msg").hide(); $(".employee_2_msg").html("");
		}

		if ($("#role_priority_2").val() == "") {
			$("#role_priority_2").css("border","1px solid #f00");
			$(".role_priority_2_msg").show(); $(".role_priority_2_msg").html("Select Role Priority");
			return false;
		} else {
			$("#role_priority_2").css("border","1px solid #dee2e6"); $(".role_priority_2_msg").hide(); $(".role_priority_2_msg").html("");
		}
		
	});	
</script>
