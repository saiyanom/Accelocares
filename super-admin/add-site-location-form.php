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
<style type="text/css">
	.select2-container {
		width: 100% !important;
	}
</style>
<div class="modal-header border-bottom-st d-block">
<!--<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<div class="form-p-hd">
<h2>Add New Site Location, Department  & Product</h2>
</div>


<div class="form-p-block">
<form action="add-site-location-db.php" method="post" enctype="multipart/form-data">
<!-- box 1 -->
<div class="form-group">
	<label class="control-label">Department</label>
	<select class="form-control select2" id="department" name="department" data-toggle="select2">
		<option value="">- Select Department -</option>
		<option value="new_department">- Add New Department -</option>
		<optgroup label="Select">
			<?php
				$department = Department::find_all();
				foreach($department as $department){
					echo "<option>{$department->department}</option>";
				}
			?>
		</optgroup>
	</select><br />
	<span class="err_msg department_msg"></span>
</div>
<div class="form-group" id="department_new" style="display: none;"><input class="form-control form-p-box-bg1" placeholder="New Department" type="text" name="department_new"><span class="err_msg department_new_msg"></span></div>
<!-- box 1 -->

<div class="form-group">
	<label class="control-label"> Site Location</label>
	<select class="form-control select2" id="site_location" name="site_location" data-toggle="select2">
		<option value="">- Select Site Location -</option>
		<option value="new_site_location">- Add New Site Location -</option>
		<optgroup label="Select">
			<?php
				$sql_loc = "Select * from site_location order by site_location ASC";
				$site_location = SiteLocation::find_by_sql($sql_loc);
				$s_location = '';
				foreach($site_location as $site_location){
					if($s_location != $site_location->site_location){
						echo "<option>{$site_location->site_location}</option>";
					}
					$s_location = $site_location->site_location;
				}
			?>
		</optgroup>
	</select><br />
	<span class="err_msg site_location_msg"></span>
</div>
<div class="form-group" id="site_location_new" style="display: none;"><input class="form-control form-p-box-bg1" placeholder="New Site Location" type="text" name="site_location_new"><span class="err_msg site_location_new_msg"></span></div>

<!-- box 1 -->
<div class="form-group">
	<label class="control-label">Product </label>
	<select class="form-control select2" id="product" name="product" data-toggle="select2">
		<option value="">- Select Product -</option>
		<option value="new_product">- Add New Product -</option>
		<optgroup label="Select">
			<?php
				$sql = "Select * from product order by product ASC";
				$product = Product::find_by_sql($sql);
				$stored_pro = "";
				foreach($product as $product){
					if($stored_pro != $product->product) {
						echo "<option>{$product->product}</option>";
					}					
					$stored_pro = $product->product;
				}
			?>
		</optgroup>
	</select>
</div>
<div class="form-group" id="product_new" style="display: none;"><input class="form-control form-p-box-bg1" placeholder="New Product" type="text" name="product_new"></div>

<!-- box 1 -->

<div class="form-p-box form-p-boxbtn">
	<a class="fpcl" data-dismiss="modal" aria-hidden="true" href="#">Close</a>
	<input type="submit" class="fpdone" id="create_site_location" value="Add">
</div>

<div class="clerfix"></div>
</form>
</div>
</div>

<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>		
<script src="assets/js/app.min.js"></script>
<script type="application/javascript">
	
	$("#department").change(function (e) {
		var department = $(this).val();
		
		if(department == 'new_department'){
			$("#department_new").show();
		} else {
			$("#department_new input").val('');
			$("#department_new").hide();
		}
	});
	
	$("#site_location").change(function (e) {
		var site_location = $(this).val();
		
		if(site_location == 'new_site_location'){
			$("#site_location_new").show();
		} else {
			$("#site_location_new input").val('');
			$("#site_location_new").hide();
		}
	});
	
	$("#product").change(function (e) {
		var product = $(this).val();
		
		if(product == 'new_product'){
			$("#product_new").show();
		} else {
			$("#product_new input").val('');
			$("#product_new").hide();
		}
	});

	
	
</script>