<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }
	////date_default_timezone_set('Asia/Calcutta');

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=+]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("customers-page.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=+]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("customers-page.php");
		}
	}

if(!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['dateYear']) || empty($_GET['dateYear']) || !isset($_GET['date']) || empty($_GET['date'])){
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
}	

	if(!isset($_GET['id']) || empty($_GET['id'])){
		$session->message("Company Not Found");
		redirect_to("customers-page.php");
	} else {
		$customer_off_take = CustomerOffTake::find_by_id($_GET['id']);
		$company 		= $customer_off_take->company;
		$company_id 	= $customer_off_take->company_id;
		
		//$url = "customers-page.php?dateYear={$_GET['dateYear']}&&company={$customer_off_take->company_id}&&location={$customer_off_take->location}";
	}

?>
<div class="modal-header border-bottom-st d-block">
	<button type="button" id="close_form" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>
	<div class="form-p-hd">
		<h2><?php echo $customer_off_take->company; ?></h2>
	</div>

	<div class="form-p-block">
		<form action="<?php echo "edit-off-take-db.php?dateYear={$_GET['dateYear']}&&id={$_GET['id']}&&date={$_GET['date']}&&comp={$customer_off_take->company_id}&&loc={$customer_off_take->location}"; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
		<div class="edit_cust_details">
			<div class="cust_details_row cust_details_row_1">
				<hr />
				<div class="form-group"><label class="control-label">Order Quantity</label><input class="form-control form-p-box-bg1" type="text" value="<?php echo $customer_off_take->order_qty; ?>" name="order_qty"></div>
				<div class="form-group"><label class="control-label">Dispatch Quantity</label><input class="form-control form-p-box-bg1" type="text" value="<?php echo $customer_off_take->dispatch_qty; ?>" name="dispatch_qty"></div>
				<div class="form-group"><label class="control-label">Triger Quantity</label><input class="form-control form-p-box-bg1" type="number" value="<?php echo $customer_off_take->triger_qty; ?>" name="triger_qty"></div>
				<div class="clerfix"></div>
			</div>
			
		</div>					

		
		<div class="clerfix">&nbsp;</div>

		<div class="form-p-box form-p-boxbtn">
			<input type="submit" class="fpdone" value="Update">
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
	
	
	
	