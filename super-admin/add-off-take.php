<?php ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("customers-page.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("customers-page.php");
		}
	}

if(!isset($_GET['dateYear']) || empty($_GET['dateYear']) || !isset($_GET['date']) || empty($_GET['date']) || !isset($_GET['comp']) || empty($_GET['comp']) || !isset($_GET['loc']) || empty($_GET['loc'])){
	$session->message("Company Not Found");
	redirect_to("customers-page.php");
} else {
	if(isset($_GET['id'])){
		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Query."); redirect_to("customers-page.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Query."); redirect_to("customers-page.php");
		}
	}

	if(isset($_GET['dateYear'])){
		if(!is_numeric($_GET['dateYear'])) {
			$session->message("Invalid Date."); redirect_to("customers-page.php");
		}
		if(strlen($_GET['dateYear']) != 4) {
			$session->message("Invalid Date."); redirect_to("customers-page.php");
		}
	}

	if(isset($_GET['date'])){
		if (!preg_match('/^[0-9- ]+$/D', $_GET['date'])){
			$session->message("Invalid Date."); redirect_to("customers-page.php");
		}
		if(strlen($_GET['date']) != 10) {
			$session->message("Invalid Date."); redirect_to("customers-page.php");
		}
	}

	if(isset($_GET['comp'])){
		if(!is_numeric($_GET['comp'])) {
			$session->message("Invalid Company."); redirect_to("customers-page.php");
		}
	}

	if(isset($_GET['loc'])){
		if(is_numeric($_GET['loc'])) {
			$session->message("Invalid Location."); redirect_to("customers-page.php");
		}
	}
}
	//echo "add-off-take-db.php?dateYear={$_GET['dateYear']}&&date={$_GET['date']}&&comp={$_GET['comp']}&&loc={$_GET['loc']}";

	//return false;
?>
<div class="modal-header border-bottom-st d-block">
	<button type="button" id="close_form" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>
	<div class="form-p-hd">
		<h2>Add Company Details</h2>
	</div>

	<div class="form-p-block">
		<form action="<?php echo "add-off-take-db.php?dateYear={$_GET['dateYear']}&&date={$_GET['date']}&&comp={$_GET['comp']}&&loc={$_GET['loc']}"; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
		<div class="edit_cust_details">
			<div class="cust_details_row cust_details_row_1">
				<hr />
				<div class="form-group"><label class="control-label">Order Quantity</label><input class="form-control form-p-box-bg1" type="text" name="order_qty"></div>
				<div class="form-group"><label class="control-label">Dispatch Quantity</label><input class="form-control form-p-box-bg1" type="text" name="dispatch_qty"></div>
				<div class="form-group"><label class="control-label">Triger Quantity</label><input class="form-control form-p-box-bg1" type="number" name="triger_qty"></div>
				<div class="clerfix"></div>
			</div>
		</div>					

		
		<div class="clerfix">&nbsp;</div>

		<div class="form-p-box form-p-boxbtn">
			<input type="submit" class="fpdone" value="Submit">
		</div>

		<div class="clerfix"></div>
		</form>
	</div>
</div>
<script>
	function isValid(str) {
	    return !/[~`!#$%\^&*()+=\\[\]\\';,/{}|\\":<>\?]/g.test(str);
	}

	$("input, textarea").keypress(function(event) {
	    var character = String.fromCharCode(event.keyCode);
	    return isValid(character);  
	});
</script>
	
	
	
	