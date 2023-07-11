<?php ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }
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

	if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
		
		$from_date = $_GET['from_date'];
		$to_date = $_GET['to_date'];
		
		$source_mill 		= Complaint::count_identify_source_date($from_date, $to_date,"Mill");
		$source_plant 		= Complaint::count_identify_source_date($from_date, $to_date,"Plant");
	} else {
		$source_mill 		= Complaint::count_identify_source("Mill");
		$source_plant 		= Complaint::count_identify_source("Plant");
	}

	

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
        height: 350,
        type: "pie"
    },
	<?php echo "series: [{$source_mill},{$source_plant}]"; ?>,
	<?php echo "labels: ['Plant - {$source_mill}','Mill - {$source_plant}']"; ?>,
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