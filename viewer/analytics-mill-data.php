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
?>
<h4 class="header-title">
	<a href="analytics-mill-data-table.php"><i class="mdi mdi-table"></i> Mill Data</a>
	<div class="input-group" style="float: right; width: 200px;">
		<div class="custom-file">
			<input readonly type="text" id="date_range" name="date_range" placeholder="Select Date Range" class="form-control date-picker mill_data_date_picker" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="false">
		</div>
	</div>
</h4>	
<div id="mill_data_graph" class="apex-charts" style="width: 100%; height: 380px;"></div>

<?php

	$mill_reg = MillReg::find_all();
	$repeat_mill = '';
	$repeat_comp_id = '';
	$mill_name_count = array();

	foreach($mill_reg as $mill_reg){	
		$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee'";
		$employee_location = EmployeeLocation::find_by_sql($sql_el);

		$source_mill_count = 0;
		$max = 0;
		if($repeat_mill != $mill_reg->mill_name){
			foreach($employee_location as $employee_location){
				$product = Product::find_by_id($employee_location->product_id);

				if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
					$sql_mill 	= "Select * from complaint where mill = '{$mill_reg->mill_name}' AND plant_location = '{$product->site_location}' AND business_vertical = '{$product->department}' AND product = '{$product->product}' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date . "'";
					$source_mill 		= Complaint::find_by_sql($sql_mill);
					foreach($source_mill as $source_mill){
						if($repeat_comp_id != $source_mill->id){
							$source_mill_count++;
							//echo $source_mill->id.", ";
							//$source_mill_count = $mill_reg->mill_name;
							$repeat_comp_id = $source_mill->id;
						}
					}
				} else { 
					$sql_mill 	= "Select * from complaint where mill = '{$mill_reg->mill_name}' AND plant_location = '{$product->site_location}' AND business_vertical = '{$product->department}' AND product = '{$product->product}' ";
					$source_mill 		= Complaint::find_by_sql($sql_mill);
					foreach($source_mill as $source_mill){
						if($repeat_comp_id != $source_mill->id){
							$source_mill_count++;
							//echo $source_mill->id.", ";
							//$source_mill_count = $mill_reg->mill_name;
							$repeat_comp_id = $source_mill->id;
						}
					}
				}
			} 
			$mill_name_count += ["{$mill_reg->mill_name}" => $source_mill_count];
			//echo "{$source_mill_count},";
			//$repeat_mill = $mill_reg->mill_name;
			if($max < $source_mill_count){ $max = $source_mill_count;}
		} 
		
	}

	arsort($mill_name_count);


?>

<script>
	$('.date-picker').daterangepicker({
		singleDatePicker: false,
		locale: {
		  format: 'DD/MM/YYYY',
		}
	});
	
	$('.mill_data_date_picker').click(function(){
		$(this).on('apply.daterangepicker', function(ev, picker) {
			var startDate 	= picker.startDate;
			var endDate 	= picker.endDate;

			var startDate 	= startDate.format('YYYY-MM-DD');
			var endDate 	= endDate.format('YYYY-MM-DD')

			$("#mill_data").load("analytics-mill-data.php?from_date="+startDate+"&to_date="+endDate);
		});
	});
	
var options = {
    chart: {
        height: 380,
        type: "line",
        zoom: {
            enabled: !1
        }
    },
    dataLabels: {
        enabled: !1
    },
    colors: ["#2c8ef8"],
    stroke: {
        width: [10],
        curve: "straight"
    },
    series: [{
        name: "Complaint",
        <?php 
			$i=0;
			$max=0;
			echo "data: [";
				foreach($mill_name_count as $key => $value){
					if($i < 10){
						echo "{$value},";
					}
					if($i == 0){
						$max = $value;
					}
					$i++;					
			    }
			    if($max < 6){
					$max = 6;
				}
			echo "]";
		?>
    }],
    title: {
        text: "",
        align: "center"
    },
    grid: {
        row: {
            colors: ["transparent", "transparent"],
            opacity: .2
        },
        borderColor: "#f1f3fa"
    },
    yaxis: {
        min: 0,
        max: <?php echo $max; ?>
    },
    labels: series.monthDataSeries1.dates,
    xaxis: {
		tooltip: {
		  enabled: false
		},
        <?php $i=0;
			echo "categories: [";
				foreach($mill_name_count as $key => $value){
			   		if($i < 10){
						echo "'{$key}',";
					}$i++;
			    }
			echo "]";
		?>
    },
    responsive: [{
        breakpoint: 600,
        options: {
            chart: {
                toolbar: {
                    show: !1
                }
            },
            legend: {
                show: !1
            }
        }
    }]
};
(chart = new ApexCharts(document.querySelector("#mill_data_graph"), options)).render();
</script>


	