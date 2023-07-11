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
<h4 class="header-title"><i class="mdi mdi-table"></i> Complaint Type
	<a href="analytics-complaint-type-mill-table.php">Mill</a> / 
	<a href="analytics-complaint-type-location-table.php">Location</a>
	<div class="input-group" style="float: right; width: 200px;">
		<div class="custom-file">
			<input readonly type="text" id="date_range" name="date_range" placeholder="Select Date Range" class="form-control date-picker complaint_type_date_picker" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="false">
		</div>
	</div>
</h4>	
<div id="complaint_type_graph" class="apex-charts" style="width: 100%;height: 380px;"></div>


<script>
	$('.date-picker').daterangepicker({
		singleDatePicker: false,
		locale: {
		  format: 'DD/MM/YYYY',
		}
	});
	
	$('.complaint_type_date_picker').click(function(){
		$(this).on('apply.daterangepicker', function(ev, picker) {
			var startDate 	= picker.startDate;
			var endDate 	= picker.endDate;

			var startDate 	= startDate.format('YYYY-MM-DD');
			var endDate 	= endDate.format('YYYY-MM-DD')

			//alert("analytics-complaint-type.php?from_date="+startDate+"&to_date="+endDate);
			$("#complaint_type").load("analytics-complaint-type.php?from_date="+startDate+"&to_date="+endDate);
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
        	$sql = "Select * from complaint_type order by complaint_type ASC";
			$complaint_type = ComplaintType::find_by_sql($sql);
			//$sql = "Select * from complaint_type where department = 'Auto' order by complaint_type ASC";
			//$complaint_type = ComplaintType::find_by_sql($sql);
			$complaint_type_=0;
			$max=0;
			$ct_store = "";
			$complaint_type_all = "";
			echo "data: [";
				foreach($complaint_type as $complaint_type){
					if($ct_store != $complaint_type->complaint_type){
						if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
							$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee'";
							$employee_location = EmployeeLocation::find_by_sql($sql_el);

							foreach($employee_location as $employee_location){
								$product = Product::find_by_id($employee_location->product_id);
								
								$complaint_sql = "SELECT * FROM complaint WHERE plant_location = '{$product->site_location}' AND complaint_type = '".$complaint_type->complaint_type."' AND date_ BETWEEN '" . $_GET['from_date'] . "' AND  '" . $_GET['to_date']. "'";
								$complaints 	= Complaint::find_by_sql($complaint_sql);
								foreach($complaints as $complaints){ $complaint_type_++;}
								
							}
							//$complaint_type_ = Complaint::count_by_complaint_type_date($_GET['from_date'], $_GET['to_date'], $complaint_type->complaint_type);
						} else { 
							$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee'";
							$employee_location = EmployeeLocation::find_by_sql($sql_el);

							foreach($employee_location as $employee_location){
								$product = Product::find_by_id($employee_location->product_id);
								
								$complaint_sql = "SELECT * FROM complaint WHERE plant_location = '{$product->site_location}' AND complaint_type = '".$complaint_type->complaint_type."' AND plant_location = '{$product->site_location}'";
								$complaints 	= Complaint::find_by_sql($complaint_sql);
								foreach($complaints as $complaints){ $complaint_type_++;}
								
							}
							//$complaint_type_ = Complaint::count_by_complaint_type($complaint_type->complaint_type); 
						}
						echo "{$complaint_type_},";
						$complaint_type_all .= "'{$complaint_type->complaint_type}',";
						if($max < $complaint_type_){ $max = $complaint_type_;}
						$complaint_type_=0;
					}$ct_store = $complaint_type->complaint_type;
				}

				$complaint_type_all = substr($complaint_type_all, 0, -1);

				if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
					$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee'";
					$employee_location = EmployeeLocation::find_by_sql($sql_el);

					foreach($employee_location as $employee_location){
						$product = Product::find_by_id($employee_location->product_id);

						$complaint_sql = "SELECT * FROM complaint WHERE plant_location = '{$product->site_location}' AND complaint_type NOT IN (".$complaint_type_all.") AND date_ BETWEEN '" . $_GET['from_date'] . "' AND  '" . $_GET['to_date']. "'";
						$complaints 	= Complaint::find_by_sql($complaint_sql);
						foreach($complaints as $complaints){ $complaint_type_++;}
					}
					//$complaint_type_ = Complaint::count_by_complaint_type_date($_GET['from_date'], $_GET['to_date'], 'Other');
				} else { 
					$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee'";
					$employee_location = EmployeeLocation::find_by_sql($sql_el);

					foreach($employee_location as $employee_location){
						$product = Product::find_by_id($employee_location->product_id);

						$complaint_sql = "SELECT * FROM complaint WHERE plant_location = '{$product->site_location}' AND complaint_type NOT IN (".$complaint_type_all.") AND plant_location = '{$product->site_location}'";
						$complaints 	= Complaint::find_by_sql($complaint_sql);
						foreach($complaints as $complaints){ $complaint_type_++;}

					}
					//$complaint_type_ = Complaint::count_by_complaint_type('Other'); 
				}
				echo "{$complaint_type_},";
				//$complaint_type_all .= "'{$complaint_type->complaint_type}',";
				//if($max < $complaint_type_){ $max = $complaint_type_;}
				//$complaint_type_=0;
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
        max: <?php if($max < 6){ echo 6; } else {echo $max;} ?>
    },
    labels: series.monthDataSeries1.dates,
    xaxis: {
    	tooltip: {
		  enabled: false
		},
        categories: [<?php
        	$sql_cat = "Select * from complaint_type order by complaint_type ASC";
			$complaint_type = ComplaintType::find_by_sql($sql_cat);
			$old_complaint_type = "";
			foreach ($complaint_type as $complaint_type) {
				if($complaint_type->complaint_type != $old_complaint_type){
					echo "'{$complaint_type->complaint_type}',";
				}
				$old_complaint_type = $complaint_type->complaint_type;
			} echo "'Other'";
        ?>]
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
(chart = new ApexCharts(document.querySelector("#complaint_type_graph"), options)).render();
	
</script>