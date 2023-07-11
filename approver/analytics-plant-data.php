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
	<a href="analytics-plant-data-table.php"><i class="mdi mdi-table"></i> Plant Over View</a>
	<div class="input-group" style="float: right; width: 200px;">
		<div class="custom-file">
			<input readonly type="text" id="date_range" name="date_range" placeholder="Select Date Range" class="form-control date-picker plant_data_date_picker" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="false">
		</div>
	</div>
</h4>	
<div id="plant_data_graph" class="apex-charts" style="width: 100%;height: 380px;"></div>

<?php

	
	$sql = "Select * from site_location order by site_location ASC";
	$site_location = SiteLocation::find_by_sql($sql);
	$sl_store = "";
	$plant_location = 0;
	$plant_name_count = array();

	foreach($site_location as $site_location){	
		if($sl_store != $site_location->site_location){
			if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
				$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee'";
				$employee_location = EmployeeLocation::find_by_sql($sql_el);

				foreach($employee_location as $employee_location){
					$product = Product::find_by_id($employee_location->product_id);
					
					if($site_location->site_location == $product->site_location){
						$auto_sql = "SELECT * FROM complaint WHERE plant_location = '{$product->site_location}' AND date_ BETWEEN '" . $_GET['from_date'] . "' AND  '" . $_GET['to_date']. "'";
						$complaints_plant 	= Complaint::find_by_sql($auto_sql);
						foreach($complaints_plant as $complaints_plant){ $plant_location++;}
					} else {
						$plant_location=0;
					}
				}
				//$plant_location = Complaint::count_by_plant_location_date($_GET['from_date'], $_GET['to_date'], $site_location->site_location);
			} else { 
				$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee'";
				$employee_location = EmployeeLocation::find_by_sql($sql_el);

				foreach($employee_location as $employee_location){
					$product = Product::find_by_id($employee_location->product_id);
					
					if($site_location->site_location == $product->site_location){
						$auto_sql = "SELECT * FROM complaint WHERE plant_location = '{$product->site_location}'";
						$complaints_plant 	= Complaint::find_by_sql($auto_sql);
						foreach($complaints_plant as $complaints_plant){ $plant_location++;}
					} else {
						$plant_location=0;
					}
					
				}
				//$plant_location = Complaint::count_by_plant_location($site_location->site_location); 
			}

			$plant_name_count += ["{$site_location->site_location}" => $plant_location];
			//echo "{$plant_location},";
			$sl_store = $site_location->site_location;
		}
	}

	arsort($plant_name_count);

	

?>
<script>
	$('.date-picker').daterangepicker({
		singleDatePicker: false,
		locale: {
		  format: 'DD/MM/YYYY',
		}
	});
	
	$('.plant_data_date_picker').click(function(){
		$(this).on('apply.daterangepicker', function(ev, picker) {
			var startDate 	= picker.startDate;
			var endDate 	= picker.endDate;

			var startDate 	= startDate.format('YYYY-MM-DD');
			var endDate 	= endDate.format('YYYY-MM-DD')

			$("#plant_data").load("analytics-plant-data.php?from_date="+startDate+"&to_date="+endDate);
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
				foreach($plant_name_count as $key => $value){
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
				foreach($plant_name_count as $key => $value){
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
(chart = new ApexCharts(document.querySelector("#plant_data_graph"), options)).render();
	
</script>


