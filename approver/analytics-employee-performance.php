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
		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != 'Employee' AND emp_sub_role != 'Viewer' AND emp_sub_role != '' Limit 1";
		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
		if(!$employee_location){
			redirect_to("logout.php"); 
		}
	}
?>
<h4 class="header-title">
	<a href="analytics-employee-performance-table.php"><i class="mdi mdi-table"></i> Employee Performance</a>
	<div class="input-group" style="float: right; width: 200px;">
		<div class="custom-file">
			<input readonly type="text" id="date_range" name="date_range" placeholder="Select Date Range" class="form-control date-picker employee_performance_date_picker" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="false">
		</div>
	</div>
</h4>	
<div id="employee_performance_graph" class="apex-charts" style="width: 100%;height: 380px;"></div>

<?php

	if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
		
		$from_date = $_GET['from_date'];
		$to_date = $_GET['to_date'];
		
		
		$employee_reg = EmployeeReg::find_all();
		$employee_name_count = array();
		
		foreach($employee_reg as $employee_reg){
			$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee'";
			$employee_location = EmployeeLocation::find_by_sql($sql_el);
			$prod_id = '';

			foreach($employee_location as $employee_location){
				$product = Product::find_by_id($employee_location->product_id);
				
				$sql = "Select * from complaint where emp_id = '{$employee_reg->id}' AND
				product = '{$product->product}' AND 
				plant_location = '{$product->site_location}' AND 
				business_vertical = '{$product->department}'  AND date_ BETWEEN '{$from_date}' AND '{$to_date}'";

				$complaint_reg = Complaint::find_by_sql($sql);

				$comp_count = 0;
				if($prod_id != $product->id){
					foreach($complaint_reg as $complaint_reg){
						$comp_count++;
					}
					$prod_id = $product->id;
					$employee_name_count += ["{$employee_reg->emp_name}" => $comp_count];
				}
			}
		}
	} else {
		
		$employee_reg = EmployeeReg::find_all();
		$employee_name_count = array();
		
		foreach($employee_reg as $employee_reg){
			$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee'";
			$employee_location = EmployeeLocation::find_by_sql($sql_el);
			$prod_id = '';

			foreach($employee_location as $employee_location){
				$product = Product::find_by_id($employee_location->product_id);
				
				$sql = "Select * from complaint where emp_id = '{$employee_reg->id}' AND
				product = '{$product->product}' AND 
				plant_location = '{$product->site_location}' AND 
				business_vertical = '{$product->department}'";

				$complaint_reg = Complaint::find_by_sql($sql);

				$comp_count = 0;
				if($prod_id != $product->id){
					foreach($complaint_reg as $complaint_reg){
						$comp_count++;
					}
					$prod_id = $product->id;
					$employee_name_count += ["{$employee_reg->emp_name}" => $comp_count];
				}
			}
		}
		
	}
		arsort($employee_name_count);
	

?>

<script>
	$('.date-picker').daterangepicker({
		singleDatePicker: false,
		locale: {
		  format: 'DD/MM/YYYY',
		}
	});
	
	$('.employee_performance_date_picker').click(function(){
		$(this).on('apply.daterangepicker', function(ev, picker) {
			var startDate 	= picker.startDate;
			var endDate 	= picker.endDate;

			var startDate 	= startDate.format('YYYY-MM-DD');
			var endDate 	= endDate.format('YYYY-MM-DD')

			//alert("analytics-complaint-analysis.php?from_date="+startDate+"&to_date="+endDate);
			$("#employee_performance").load("analytics-employee-performance.php?from_date="+startDate+"&to_date="+endDate);
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
				foreach($employee_name_count as $key => $value){
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
				foreach($employee_name_count as $key => $value){
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
(chart = new ApexCharts(document.querySelector("#employee_performance_graph"), options)).render();	
	
</script>