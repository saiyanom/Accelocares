<?php ob_start();
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
		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != '' Limit 1";
		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
		if(!$employee_location){
			redirect_to("my-cvc.php"); 
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
<div id="mill_data_graph" style="width: 100%;height: 320px;"></div>


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
        height: 335,
        type: "bar",
        toolbar: {
            show: !1
        }
    },
    plotOptions: {
        bar: {
            horizontal: !1
        }
    },
    dataLabels: {
        enabled: !0
    },
    series: [{
		<?php 
			$mill_reg = MillReg::find_all();
			
			echo "data: [";
				foreach($mill_reg as $mill_reg){	
					if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
						$mill_count = Complaint::count_by_mill_date($_GET['from_date'], $_GET['to_date'], $mill_reg->mill_name);
					} else { $mill_count = Complaint::count_by_mill($mill_reg->mill_name); }
					echo "{$mill_count},";
				}
			echo "]";
		?>
    }],
    colors: ["#727cf5"],
    xaxis: {
		<?php 
			$mill_reg = MillReg::find_all();
			echo "categories: [";
				foreach($mill_reg as $mill_reg){	
					echo "'{$mill_reg->mill_name}',";
				}
			echo "]";
		?>
    },
    states: {
        hover: {
            filter: "none"
        }
    },
    grid: {
        borderColor: "#f1f3fa"
    }
};
(chart = new ApexCharts(document.querySelector("#mill_data_graph"), options)).render();
</script>