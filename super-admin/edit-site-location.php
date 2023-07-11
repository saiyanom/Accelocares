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
		$product_reg = Product::find_by_id($_GET['id']);
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
<h2>Edit Site Location, Department  & Product</h2>
</div>


<div class="form-p-block">
<form action="edit-site-location-db.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
<!-- box 1 -->
<div class="form-group">
	<label class="control-label">Department</label>
	<select class="form-control select2" id="department_2" name="department" data-toggle="select2">
		<option value="">- Select Department -</option>
		<option value="new_department">- Add New Department -</option>
		<optgroup label="Select">
			<?php
				$department = Department::find_all();
				foreach($department as $department){
					echo "<option ";
					
					if($product_reg->department == $department->department){
						echo " Selected ";
					}
			?>
				
			<?php echo " >{$department->department}</option>";
				}
			?>
		</optgroup>
	</select><br />
	<span class="err_msg department_2_msg"></span>
</div>
<div class="form-group" id="department_new_2" style="display: none;"><input class="form-control form-p-box-bg1" placeholder="New Department" type="text" name="department_new"><span class="err_msg department_new_2_msg"></span></div>
<!-- box 1 -->

<div class="form-group">
	<label class="control-label"> Site Location</label>
	<select class="form-control select2" id="site_location_2" name="site_location" data-toggle="select2">
		<option value="">- Select Site Location -</option>
		<option value="new_site_location">- Add New Site Location -</option>
		<optgroup label="Select">
			<?php
				$sql_loc = "Select * from site_location order by site_location ASC";
				$site_location = SiteLocation::find_by_sql($sql_loc);
				$s_location = '';
				foreach($site_location as $site_location){
					if($s_location != $site_location->site_location){
						echo "<option ";
						if($product_reg->site_location == $site_location->site_location){
							echo " Selected ";
						}
					}
					$s_location = $site_location->site_location;
					
			?>
				
			<?php echo " >{$site_location->site_location}</option>";
				}
			?>
		</optgroup>
	</select><br />
	<span class="err_msg site_location_2_msg"></span>
</div>
<div class="form-group" id="site_location_new_2" style="display: none;"><input class="form-control form-p-box-bg1" placeholder="New Site Location" type="text" name="site_location_new"><span class="err_msg site_location_new_2_msg"></span></div>

<!-- box 1 -->
<div class="form-group">
	<label class="control-label">Product </label>
	<select class="form-control select2" id="product_2" name="product" data-toggle="select2">
		<option value="">- Select Product -</option>
		<option value="new_product">- Add New Product -</option>
		<optgroup label="Select">
			<?php
				$sql = "Select * from product order by product ASC";
				$product = Product::find_by_sql($sql);
				$stored_pro = "";
				foreach($product as $product){
					if($stored_pro != $product->product) {
						echo "<option ";
						if($product_reg->product == $product->product){
							echo " Selected ";
						}
				 		echo " >{$product->product}</option>";
					}					
					$stored_pro = $product->product;
				}
			?>
		</optgroup>
	</select>
</div>
<div class="form-group" id="product_new_2" style="display: none;"><input class="form-control form-p-box-bg1" placeholder="New Product" type="text" name="product_new"></div>

<!-- box 1 -->

<div class="form-p-box form-p-boxbtn">
	<a class="fpcl" data-dismiss="modal" aria-hidden="true" href="#">Close</a>
	<input type="submit" class="fpdone" id="update_site_location" value="Add">
</div>

<div class="clerfix"></div>
</form>
</div>
</div>

<script src="assets/js/app.min.js"></script>


<script type="text/javascript">
	$("#department_2").change(function (e) {
		var department = $(this).val();
		
		if(department == 'new_department'){
			$("#department_new_2").show();
		} else {
			$("#department_new_2 input").val('');
			$("#department_new_2").hide();
		}
	});
	
	$("#site_location_2").change(function (e) {
		var site_location = $(this).val();
		
		if(site_location == 'new_site_location'){
			$("#site_location_new_2").show();
		} else {
			$("#site_location_new_2 input").val('');
			$("#site_location_new_2").hide();
		}
	});
	
	$("#product_2").change(function (e) {
		var product = $(this).val();
		
		if(product == 'new_product'){
			$("#product_new_2").show();
		} else {
			$("#product_new_2 input").val('');
			$("#product_new_2").hide();
		}
	});


	$("#update_site_location").click(function() {

		if ($("#department_2").val() == "") {
			$("#department_2").css("border","1px solid #f00");
			$(".department_2_msg").show(); $(".department_2_msg").html("Enter Department");
			return false;
		} else {
			$("#department_2").css("border","1px solid #dee2e6"); $(".department_2_msg").hide(); $(".department_2_msg").html("");

			if ($("#department_2").val() == "new_department") {
				if ($("#department_new_2 input").val() == "") {
					$("#department_new_2 input").css("border","1px solid #f00");
					$(".department_new_2_msg").show(); $(".department_new_2_msg").html("Enter New Department");
					return false;
				} else {
					$("#department_new_2 input").css("border","1px solid #dee2e6"); $(".department_new_2_msg").hide(); $(".department_new_2_msg").html("");
				}
			}
		}

		if ($("#site_location_2").val() == "") {
			$("#site_location_2").css("border","1px solid #f00");
			$(".site_location_2_msg").show(); $(".site_location_2_msg").html("Enter Site Location");
			return false;
		} else {
			$("#site_location_2").css("border","1px solid #dee2e6"); $(".site_location_2_msg").hide(); $(".site_location_2_msg").html("");

			if ($("#site_location_2").val() == "new_site_location") {
				if ($("#site_location_new_2 input").val() == "") {
					$("#site_location_new_2 input").css("border","1px solid #f00");
					$(".site_location_new_2_msg").show(); $(".site_location_new_2_msg").html("Enter New Site Location");
					return false;
				} else {
					$("#site_location_new_2 input").css("border","1px solid #dee2e6"); $(".site_location_new_2_msg").hide(); $(".site_location_new_2_msg").html("");
				}
			}
		}
	});	



</script>
	
	
	



<!-- end modal-body-->