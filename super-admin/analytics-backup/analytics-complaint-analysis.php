<?php ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }
?>
<h4 class="header-title">
	<a href="#"><i class="mdi mdi-table"></i> Complaint Analysis</a>
	<div class="input-group" style="float: right; width: 200px;">
		<div class="custom-file">
			<input readonly type="text" id="date_range" name="date_range" placeholder="Select Date Range" class="form-control date-picker complaint_analysis_date_picker" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="false">
		</div>
	</div>
</h4>	
<div id="complaint_analysis_graph" style="width: 100%;height: 320px;"></div>

<?php

	if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
		
		$from_date = $_GET['from_date'];
		$to_date = $_GET['to_date'];
		
		$complaint_analysis_sporadic 		= Complaint::count_complaint_analysis_date($from_date, $to_date,"Sporadic");
		$complaint_analysis_chronic 		= Complaint::count_complaint_analysis_date($from_date, $to_date,"Chronic");
		$complaint_analysis_major	 		= Complaint::count_complaint_analysis_date($from_date, $to_date,"Major");
		$complaint_analysis_minor	 		= Complaint::count_complaint_analysis_date($from_date, $to_date,"Minor");
		$complaint_analysis_invalid 		= Complaint::count_status_date($from_date, $to_date,"Invalid");
	} else {
		$complaint_analysis_sporadic 		= Complaint::count_complaint_analysis("Sporadic");
		$complaint_analysis_chronic 		= Complaint::count_complaint_analysis("Chronic");
		$complaint_analysis_major	 		= Complaint::count_complaint_analysis("Major");
		$complaint_analysis_minor	 		= Complaint::count_complaint_analysis("Minor");
		$complaint_analysis_invalid 		= Complaint::count_status("Invalid");
	}

	

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
			echo "data: [{$complaint_analysis_sporadic},{$complaint_analysis_chronic},{$complaint_analysis_major},{$complaint_analysis_minor},{$complaint_analysis_invalid}]";
		?>
    }],
    colors: ["#727cf5"],
    xaxis: {
		categories: ['Sporadic','Chronic','Major','Minor','invalid']
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
(chart = new ApexCharts(document.querySelector("#complaint_analysis_graph"), options)).render();
</script>