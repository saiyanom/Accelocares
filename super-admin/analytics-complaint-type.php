<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }


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

	if(isset($_GET['from_date'])){
		if (!preg_match('/^[0-9-\ ]+$/D', $_GET['from_date'])){
			$session->message("Invalid Date."); redirect_to("analytics.php");
		}
		if(strlen($_GET['from_date']) != 10) {
			$session->message("Invalid Date."); redirect_to("analytics.php");
		}
	}

	if(isset($_GET['to_date'])){
		if (!preg_match('/^[0-9-\ ]+$/D', $_GET['to_date'])){
			$session->message("Invalid Date."); redirect_to("analytics.php");
		}
		if(strlen($_GET['to_date']) != 10) {
			$session->message("Invalid Date."); redirect_to("analytics.php");
		}
	}

	if(isset($_GET['from_date'])){ 
		$from_date = strtotime($_GET['from_date']); 
		$from_date = date("d/m/Y", $from_date); 

		$to_date = strtotime($_GET['to_date']); 
		$to_date = date("d/m/Y", $to_date); 
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

	var selected_date = "<?php  if(isset($_GET['from_date'])){ echo $from_date.' - '.$to_date; } ?>";
    $('.complaint_type_date_picker').val(selected_date);
	
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
			$ct_store = "";
			$complaint_type_all = "";
			$max=0;

			echo "data: [";
				foreach($complaint_type as $complaint_type){
					if($ct_store != $complaint_type->complaint_type){
						if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
							$complaint_type_ = Complaint::count_by_complaint_type_date($_GET['from_date'], $_GET['to_date'], $complaint_type->complaint_type);
						} else { $complaint_type_ = Complaint::count_by_complaint_type($complaint_type->complaint_type); }
						echo "{$complaint_type_},";
						$complaint_type_all .= "'{$complaint_type->complaint_type}',";
					}$ct_store = $complaint_type->complaint_type;
				}
				$complaint_type_all = substr($complaint_type_all, 0, -1);
				if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
					$complaint_type_ = Complaint::count_by_not_complaint_type_date($_GET['from_date'], $_GET['to_date'], $complaint_type_all);
				} else { $complaint_type_ = Complaint::count_by_not_complaint_type($complaint_type_all); }
				echo "{$complaint_type_},";
				if($max < $complaint_type_){ $max = $complaint_type_;}
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