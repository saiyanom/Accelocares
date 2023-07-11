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
	<a href="#"><i class="mdi mdi-table"></i> Complaint Analysis</a>
	<div class="input-group" style="float: right; width: 200px;">
		<div class="custom-file">
			<input readonly type="text" id="date_range" name="date_range" placeholder="Select Date Range" class="form-control date-picker complaint_analysis_date_picker" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="false">
		</div>
	</div>
</h4>	
<div id="complaint_analysis_graph" class="apex-charts" style="width: 100%;height: 380px;"></div>

<?php
	
	$complaint_analysis_sporadic 	= 0;
	$complaint_analysis_chronic 	= 0;
	$complaint_analysis_major	 	= 0;
	$complaint_analysis_minor	 	= 0;
	$complaint_analysis_invalid 	= 0;

	if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
		
		$from_date = $_GET['from_date'];
		$to_date = $_GET['to_date'];
		
		$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee'";
		$employee_location = EmployeeLocation::find_by_sql($sql_el);
		$prod_id = '';
		
		foreach($employee_location as $employee_location){
			$product = Product::find_by_id($employee_location->product_id);
			$complaint_sql = "SELECT * FROM complaint WHERE 
			product = '{$product->product}' AND 
			plant_location = '{$product->site_location}' AND 
			business_vertical = '{$product->department}' AND 
			
			date_ BETWEEN '". $_GET['from_date'] ."' AND '". $_GET['to_date']."'";
			$complaints 	= Complaint::find_by_sql($complaint_sql);
			foreach($complaints as $complaints){ 
				if($prod_id != $product->id){
					if($complaints->complaint_analysis == "Sporadic"){$complaint_analysis_sporadic++;}
					if($complaints->complaint_analysis == "Chronic"){$complaint_analysis_chronic++;}
					if($complaints->complaint_analysis == "Major"){$complaint_analysis_major++;}
					if($complaints->complaint_analysis == "Minor"){$complaint_analysis_minor++;}
					if($complaints->status 			   == "Invalid"){$complaint_analysis_invalid++; }
					$prod_id = $product->id;
				}
			}
		}
		
		/*$complaint_analysis_sporadic 		= Complaint::count_complaint_analysis_date($from_date, $to_date,"Sporadic");
		$complaint_analysis_chronic 		= Complaint::count_complaint_analysis_date($from_date, $to_date,"Chronic");
		$complaint_analysis_major	 		= Complaint::count_complaint_analysis_date($from_date, $to_date,"Major");
		$complaint_analysis_minor	 		= Complaint::count_complaint_analysis_date($from_date, $to_date,"Minor");
		$complaint_analysis_invalid 		= Complaint::count_status_date($from_date, $to_date,"Invalid");*/
	} else {
		$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee' order by product_id ASC";
		$employee_location = EmployeeLocation::find_by_sql($sql_el);
		$prod_id = '';
		foreach($employee_location as $employee_location){
			$product = Product::find_by_id($employee_location->product_id);
			$complaint_sql = "SELECT * FROM complaint WHERE product = '{$product->product}' AND 
			plant_location = '{$product->site_location}' AND 
			business_vertical = '{$product->department}' order by id ASC";
			$complaints 	= Complaint::find_by_sql($complaint_sql);
			
			foreach($complaints as $complaints){ 
				if($prod_id != $product->id){
					if($complaints->complaint_analysis == "Sporadic"){$complaint_analysis_sporadic++;}
					if($complaints->complaint_analysis == "Chronic"){$complaint_analysis_chronic++;}
					if($complaints->complaint_analysis == "Major"){$complaint_analysis_major++;}
					if($complaints->complaint_analysis == "Minor"){$complaint_analysis_minor++;}
					if($complaints->status 			   == "Invalid"){$complaint_analysis_invalid++; }
					$prod_id = $product->id;
				}
			}
		}
		/*$complaint_analysis_sporadic 		= Complaint::count_complaint_analysis("Sporadic");
		$complaint_analysis_chronic 		= Complaint::count_complaint_analysis("Chronic");
		$complaint_analysis_major	 		= Complaint::count_complaint_analysis("Major");
		$complaint_analysis_minor	 		= Complaint::count_complaint_analysis("Minor");
		$complaint_analysis_invalid 		= Complaint::count_status("Invalid");*/
	}


	$arr = array($complaint_analysis_sporadic, $complaint_analysis_chronic, $complaint_analysis_major, $complaint_analysis_minor, $complaint_analysis_invalid);
	arsort($arr);
	$max = $arr[0];

	

?>

<script>
	$('.date-picker').daterangepicker({
		singleDatePicker: false,
		locale: {
		  format: 'DD/MM/YYYY',
		}
	});
	
	$('.complaint_analysis_date_picker').click(function(){
		$(this).on('apply.daterangepicker', function(ev, picker) {
			var startDate 	= picker.startDate;
			var endDate 	= picker.endDate;

			var startDate 	= startDate.format('YYYY-MM-DD');
			var endDate 	= endDate.format('YYYY-MM-DD')

			//alert("analytics-complaint-analysis.php?from_date="+startDate+"&to_date="+endDate);
			$("#complaint_analysis").load("analytics-complaint-analysis.php?from_date="+startDate+"&to_date="+endDate);
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
			echo "data: [{$complaint_analysis_sporadic},{$complaint_analysis_chronic},{$complaint_analysis_major},{$complaint_analysis_minor},{$complaint_analysis_invalid}]";
		?>
    }],
    title: {
        text: '',
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
        categories: ['Sporadic','Chronic','Major','Minor','invalid']
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
(chart = new ApexCharts(document.querySelector("#complaint_analysis_graph"), options)).render();	
	
</script>