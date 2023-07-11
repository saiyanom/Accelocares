<?php
	require_once("../includes/initialize.php");

	if(isset($_GET['product']) && !empty($_GET['product'])){
		
		$sql = "Select * from product where product='{$_GET['product']}' AND status = 1 order by site_location ASC";
		$product = Product::find_by_sql($sql);
			echo "<option value=''>- Select Location - </option>";
		foreach($product as $product){
			echo "<option>{$product->site_location}</option>";
		}
	} 
	

	
?>