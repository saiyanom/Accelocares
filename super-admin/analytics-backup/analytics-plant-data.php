<?php ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }
?>
<h4 class="header-title">
	<a href="analytics-plant-data-table.php"><i class="mdi mdi-table"></i> Plant Over View</a>
	<div class="input-group" style="float: right; width: 200px;">
		<div class="custom-file">
			<input readonly type="text" id="date_range" name="date_range" placeholder="Select Date Range" class="form-control date-picker plant_data_date_picker" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="false">
		</div>
	</div>
</h4>	
<div id="plant_data_graph" style="width: 100%;height: 320px;"></div>

<?php

	

	

	

	

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
        enabled: !1
    },
    series: [{
		<?php 
			$sql = "Select * from site_location order by site_location ASC";
			$site_location = SiteLocation::find_by_sql($sql);
			$sl_store = "";
			echo "data: [";
				foreach($site_location as $site_location){	
					if($sl_store != $site_location->site_location){
						if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
							$plant_location = Complaint::count_by_plant_location_date($_GET['from_date'], $_GET['to_date'], $site_location->site_location);
						} else { $plant_location = Complaint::count_by_plant_location($site_location->site_location); }
						echo "{$plant_location},";
						$sl_store = $site_location->site_location;
					}
				}
			echo "]";
		?>
    }],
    colors: ["#39afd1"],
    xaxis: {
		<?php 
			$sql = "Select * from site_location order by site_location ASC";
			$site_location = SiteLocation::find_by_sql($sql);
			$sl_store = "";
			echo "categories: [";
				foreach($site_location as $site_location){	
					if($sl_store != $site_location->site_location){
						echo "'{$site_location->site_location}',";
						$sl_store = $site_location->site_location;
					}
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
	
(chart = new ApexCharts(document.querySelector("#plant_data_graph"), options)).render();
</script>