<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("analytics.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("analytics.php");
		}
	}

	$employee_reg = EmployeeReg::find_by_id($session->employee_id);
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	if ($session->is_employee_logged_in()){ 
		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role = 'Viewer' Limit 1";
		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
		if(!$employee_location){
			redirect_to("logout.php"); 
		}
	}

	$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee'";
	$employee_location = EmployeeLocation::find_by_sql($sql_el);

	$source_mill_count = 0;
	$source_plant_count = 0;
	
	foreach($employee_location as $employee_location){
		$product = Product::find_by_id($employee_location->product_id);
		//echo "{$product->department}, {$product->site_location}, {$product->product} - ".$employee_location->emp_sub_role."<br />";
		
		if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
		
			$from_date = $_GET['from_date'];
			$to_date = $_GET['to_date'];

			$sql_mill 	= "Select * from complaint where identify_source = 'Mill' AND plant_location = '{$product->site_location}' AND business_vertical = '{$product->department}' AND product = '{$product->product}' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date . "'";
			$sql_plant = "Select * from complaint where identify_source = 'Plant' AND plant_location = '{$product->site_location}' AND business_vertical = '{$product->department}' AND product = '{$product->product}' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date . "'";
		} else {
			$sql_mill 	= "Select * from complaint where identify_source = 'Mill' AND plant_location = '{$product->site_location}' AND business_vertical = '{$product->department}' AND product = '{$product->product}'";
			$sql_plant = "Select * from complaint where identify_source = 'Plant' AND plant_location = '{$product->site_location}' AND business_vertical = '{$product->department}' AND product = '{$product->product}'";
		}

		
		$source_mill 		= Complaint::find_by_sql($sql_mill);
		foreach($source_mill as $source_mill){
			$source_mill_count++;
		}
		
		$source_plant 		= Complaint::find_by_sql($sql_plant);
		foreach($source_plant as $source_plant){
			$source_plant_count++;
		}
		
	}



?>
<h4 class="header-title">
	<a href="#"><i class="mdi mdi-table"></i> Plant VS Mill</a>

	<div class="input-group" style="float: right; width: 300px;">
		<!--<div class="input-group-prepend">
			<span class="input-group-text clear_img clear_date" title="Clear Image">Select Date</span>
		</div>-->
		<div class="custom-file">
			<input readonly type="text" value="<?php echo $_GET['date_range']; ?>" id="date_range" name="date_range" placeholder="Select Date Range" class="form-control date-picker plant_vs_mill_date_picker" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="false">
		</div>
	</div>
</h4>

<div id="plant_vs_mill_graph" class="apex-charts"></div>

<?php

	

	

?>
<script>
	$('.date-picker').daterangepicker({
		singleDatePicker: false,
		locale: {
		  format: 'DD/MM/YYYY',
		}
	});
	
	$('.plant_vs_mill_date_picker').click(function(){
		$(this).on('apply.daterangepicker', function(ev, picker) {
			var startDate 	= picker.startDate;
			var endDate 	= picker.endDate;

			var startDate 	= startDate.format('YYYY-MM-DD');
			var endDate 	= endDate.format('YYYY-MM-DD')

			//alert("analytics-plant-vs-mill.php?from_date="+startDate+"&to_date="+endDate);
			$("#plant_vs_mill").load("analytics-plant-vs-mill.php?from_date="+startDate+"&to_date="+endDate);
		});
	});
	
var options = {
    chart: {
        height: 380,
        type: "pie"
    },
	<?php echo "series: [{$source_mill_count},{$source_plant_count}]"; ?>,
	<?php echo "labels: ['Mill - {$source_mill_count}','Plant - {$source_plant_count}']"; ?>,
    colors: ["#0acf97", "#727cf5"],
    legend: {
        show: !0,
        position: "bottom",
        horizontalAlign: "center",
        verticalAlign: "middle",
        floating: !1,
        fontSize: "14px",
        offsetX: 0,
        offsetY: 0
    },
    responsive: [{
        breakpoint: 600,
        options: {
            chart: {
                height: 240
            },
            legend: {
                show: !1
            }
        }
    }]
};
(chart = new ApexCharts(document.querySelector("#plant_vs_mill_graph"), options)).render();
</script>