<?php ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }
?>
<h4 class="header-title">
	<a href="analytics-employee-performance-table.php"><i class="mdi mdi-table"></i> Employee Performance</a>
	<div class="input-group" style="float: right; width: 200px;">
		<div class="custom-file">
			<input readonly type="text" id="date_range" name="date_range" placeholder="Select Date Range" class="form-control date-picker employee_performance_date_picker" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="false">
		</div>
	</div>
</h4>	
<div id="employee_performance_graph" style="width: 100%;height: 320px;"></div>

<?php

	if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
		
		$from_date = $_GET['from_date'];
		$to_date = $_GET['to_date'];
		
		$employee_performance_sporadic 		= Complaint::count_employee_performance_date($from_date, $to_date,"Sporadic");
		$employee_performance_chronic 		= Complaint::count_employee_performance_date($from_date, $to_date,"Chronic");
		$employee_performance_major	 		= Complaint::count_employee_performance_date($from_date, $to_date,"Major");
		$employee_performance_minor	 		= Complaint::count_employee_performance_date($from_date, $to_date,"Minor");
		$employee_performance_invalid 		= Complaint::count_status_date($from_date, $to_date,"Invalid");
	} else {
		
		$employee_reg = EmployeeReg::find_all();
		$employee_name = array();
		$employee_count = array();
		
		$emp_num = 1;
		foreach($employee_reg as $employee_reg){
			if($emp_num <= 10){
				$sql = "Select * from complaint where emp_id = '{$employee_reg->id}'";
				$complaint_reg = Complaint::find_by_sql($sql);

				$comp_count = 0;
				foreach($complaint_reg as $complaint_reg){
					$comp_count++;
				}
				array_push($employee_name, $employee_reg->emp_name);
				array_push($employee_count, $comp_count);
				$emp_num++;
			}
		}
		
		
	}
	

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
			$("#employee_performance").load("analytics-complaint-analysis.php?from_date="+startDate+"&to_date="+endDate);
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
	colors: ["#727cf5"],
    series: [{
		<?php 
			echo "data: [";
				foreach($employee_count as $employee_count){
			   		echo "{$employee_count},";
			    }
			echo "]";
		?>
    }],
    
    xaxis: {
		<?php 
			echo "categories: [";
				foreach($employee_name as $employee_name){
			   		echo "'{$employee_name}',";
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
(chart = new ApexCharts(document.querySelector("#employee_performance_graph"), options)).render();
</script>