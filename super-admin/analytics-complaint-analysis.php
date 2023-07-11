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

	$arr = array($complaint_analysis_sporadic, $complaint_analysis_chronic, $complaint_analysis_major, $complaint_analysis_minor, $complaint_analysis_invalid);
	arsort($arr);
	$max = $arr[0];

    if(isset($_GET['from_date'])){ 
        $from_date = strtotime($_GET['from_date']); 
        $from_date = date("d/m/Y", $from_date); 

        $to_date = strtotime($_GET['to_date']); 
        $to_date = date("d/m/Y", $to_date); 
    }

?>

<script>
	$('.date-picker').daterangepicker({
		singleDatePicker: false,
		locale: {
		  format: 'DD/MM/YYYY',
		}
	});

    var selected_date = "<?php  if(isset($_GET['from_date'])){ echo $from_date.' - '.$to_date; } ?>";
    $('.complaint_analysis_date_picker').val(selected_date);
	
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