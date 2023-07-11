<?php ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }
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
<div id="complaint_type_graph" style="width: 100%;height: 320px;"></div>


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
			$sql = "Select * from complaint_type where department = 'Auto' order by complaint_type ASC";
			$complaint_type = ComplaintType::find_by_sql($sql);
			$ct_store = "";
			echo "data: [";
				foreach($complaint_type as $complaint_type){
					if($ct_store != $complaint_type->complaint_type){
						if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
							$complaint_type_ = Complaint::count_by_complaint_type_date($_GET['from_date'], $_GET['to_date'], $complaint_type->complaint_type);
						} else { $complaint_type_ = Complaint::count_by_complaint_type($complaint_type->complaint_type); }
						echo "{$complaint_type_},";
					}$ct_store = $complaint_type->complaint_type;
				}
				if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
					$complaint_type_ = Complaint::count_by_complaint_type_date($_GET['from_date'], $_GET['to_date'], 'Other');
				} else { $complaint_type_ = Complaint::count_by_complaint_type('Other'); }
				echo "{$complaint_type_},";
			echo "]";
		?>
    }],
    colors: ["#ffbc00"],
    xaxis: {
		<?php 
			$sql = "Select * from complaint_type where department = 'Auto' order by complaint_type ASC";
			$complaint_type = ComplaintType::find_by_sql($sql);
			$ct_store = "";
			echo "categories: [";
				foreach($complaint_type as $complaint_type){	
					if($ct_store != $complaint_type->complaint_type){
						echo "'{$complaint_type->complaint_type}',";
					} $ct_store = $complaint_type->complaint_type;
				}
				echo "'Other'";
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
(chart = new ApexCharts(document.querySelector("#complaint_type_graph"), options)).render();
</script>