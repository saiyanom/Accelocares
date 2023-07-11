<?php
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$employee_reg = EmployeeReg::find_by_id($_GET['id']);
	} 
?>
<div class="modal-header border-bottom-st d-block">
<!--<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<div class="form-p-hd">
	<h2>Edit Employee Details</h2>
</div>

<div class="form-p-block">
	<form action="edit-employee-db.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
	<!-- box 1 -->
	<div class="form-group"><label class="control-label">Employee Name</label><input class="form-control form-p-box-bg1" value="<?php echo $employee_reg->emp_name; ?>" type="text" name="emp_name"></div>
	<!-- box 1 -->

	<ul class="ad-lr">
		<!-- box 1 -->
		<li class="adl1"><div class="form-group"><label class="control-label">Email ID</label><input class="form-control form-p-box-bg1" value="<?php echo $employee_reg->emp_email; ?>" type="text" name="emp_email"></div></li>
		<!-- box 1 -->

		<!-- box 1 -->
		<li class="adr1"><div class="form-group"><label class="control-label">Mobile Number</label><input class="form-control form-p-box-bg1" value="<?php echo $employee_reg->emp_mobile; ?>" type="text" name="emp_mobile"></div></li>
		<!-- box 1 -->

		<!-- box 1 -->
		<li class="adl1">
			<div class="form-group"><label class="control-label">Location</label>
				<select id="inputState" name="location" class="form-control form-p-box-bg1">
					<option value="" <?php if($employee_reg->location == ''){echo "Selected";} ?>>- Select Location -</option>
					<?php
						$site_location = SiteLocation::find_all();
						foreach($site_location as $site_location){
							echo "<option ";
							if($employee_reg->location == $site_location->site_location){echo " Selected ";}
							echo "> {$site_location->department}, {$site_location->site_location}</option>";
						}
					?>
					
				</select>
			</div>
		</li>
		<!-- box 1 -->

		<!-- box 1 -->
		<li class="adr1">
			<div class="form-group"><label class="control-label">Assign Roles </label>
				<select id="inputState" name="emp_role" class="form-control form-p-box-bg1">
					<option value="" <?php if($employee_reg->emp_role == ''){echo "Selected";}?>>- Assign Roles -</option>
					<option <?php if($employee_reg->emp_role == 'Employee'){echo "Selected";}?>>Employee</option>
					<option <?php if($employee_reg->emp_role == 'Approver'){echo "Selected";}?>>Approver</option>
					<option <?php if($employee_reg->emp_role == 'Viewer'){echo "Selected";}?>>Viewer</option>
					<option <?php if($employee_reg->emp_role == 'Super Admin'){echo "Selected";}?>>Super Admin</option>
				</select>
			</div>
		</li>
		<!-- box 1 -->
		<div class="clerfix"></div>
	</ul>

	<div class="form-p-box form-p-boxbtn">
		<a class="fpcl" data-dismiss="modal" aria-hidden="true" href="#">Close</a>
		<input type="submit" class="fpdone" value="Add">
	</div>

	<div class="clerfix"></div>
	</form>
</div>
</div>