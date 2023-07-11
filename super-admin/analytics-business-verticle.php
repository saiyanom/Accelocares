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

	if(isset($_GET['comp_status'])){
		if(is_numeric($_GET['comp_status'])) {
			$session->message("Invalid Complaint Status."); redirect_to("analytics.php");
		}
	}
?>
<h4 class="header-title">
	<a href="analytics-business-verticle-table.php"><i class="mdi mdi-table"></i> Business verticle</a>
	<select id="comp_status" name="comp_status" class="form-control select2" data-toggle="select2"  style="float: right; width: 100px;">
		<option value="">-Status -</option>
		<option <?php if(isset($_GET['comp_status']) && !empty($_GET['comp_status'])){ if($_GET['comp_status'] == ''){ echo "Selected"; }}?> value="">All</option>
		<option <?php if(isset($_GET['comp_status']) && !empty($_GET['comp_status'])){ if($_GET['comp_status'] == 'Open'){ echo "Selected"; }}?>>Open</option>
		<option <?php if(isset($_GET['comp_status']) && !empty($_GET['comp_status'])){ if($_GET['comp_status'] == 'Closed'){ echo "Selected"; }}?>>Closed</option>
		<option <?php if(isset($_GET['comp_status']) && !empty($_GET['comp_status'])){ if($_GET['comp_status'] == 'Invalid'){ echo "Selected"; }}?>>Invalid</option>
	</select>
	<div class="input-group" style="float: right; width: 200px; margin-right: 10px;">
		<div class="custom-file">
			<input readonly type="text" value="<?php echo $_GET['date_range']; ?>" id="date_range" name="date_range" placeholder="Select Date Range" class="form-control date-picker verticle_date_picker" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="false">
		</div>
	</div>
</h4>

<div id="business_verticle_graph" class="apex-charts"></div>

<?php

	if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date']) && isset($_GET['comp_status'])){
		
		$comp_status = $_GET['comp_status'];
		
		
		$from_date = str_replace('/', '-', $_GET['from_date']);
		$from_date = strtotime($from_date); 
		$from_date = date("Y-m-d", $from_date);
		
		$to_date = str_replace('/', '-', $_GET['to_date']);
		$to_date = strtotime($to_date); 
		$to_date = date("Y-m-d", $to_date);
		
		$date_range = date("d/m/Y", strtotime(str_replace('/', '-', $_GET['from_date'])))." - ".date("d/m/Y", strtotime(str_replace('/', '-', $_GET['to_date'])));
		
		$complaints_auto 	= Complaint::count_by_complaint_verticle_date($from_date, $to_date,'Auto',$comp_status);
		$complaints_crgo 	= Complaint::count_by_complaint_verticle_date($from_date, $to_date,'CRGO',$comp_status); 
		$complaints_crno 	= Complaint::count_by_complaint_verticle_date($from_date, $to_date,'CRNO',$comp_status); 
	} else {
		$complaints_auto 	= Complaint::count_by_complaint_verticle('Auto');
		$complaints_crgo 	= Complaint::count_by_complaint_verticle('CRGO'); 
		$complaints_crno	= Complaint::count_by_complaint_verticle('CRNO'); 
		
		$date_range = "";
	}

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
    $('.verticle_date_picker').val(selected_date);
		
	$('.verticle_date_picker').click(function(){
		$(this).on('apply.daterangepicker', function(ev, picker) {
			var startDate 	= picker.startDate;
			var endDate 	= picker.endDate;

			var startDate 	= startDate.format('YYYY-MM-DD');
			var endDate 	= endDate.format('YYYY-MM-DD');

			var compStatus 	= $("#comp_status").val();

			console.log("analytics-business-verticle.php?from_date="+startDate+"&to_date="+endDate+"&comp_status="+compStatus);

			//$("#business_verticle").load("analytics-business-verticle.php?from_date="+startDate+"&to_date="+endDate+"&comp_status="+compStatus);
			$( "#business_verticle" ).load( "analytics-business-verticle.php?from_date="+startDate+"&to_date="+endDate+"&comp_status="+compStatus, function() {
				//var compStatus 	= $("#comp_status").val();
				//$("#business_verticle").load("analytics-business-verticle.php?from_date="+startDate+"&to_date="+endDate+"&comp_status="+compStatus);
			});
		});
	});
	
	$("#comp_status").change(function(){
		var date_range 	= $(".verticle_date_picker").val()
		
		var startDate	= date_range.substr(0, date_range.indexOf('-')); 
		
		var endDate 	= date_range.replace(startDate+'-', "");
		
		var sd_date = 	startDate.slice(0, 5);
		
		
		

		var startDate 	= startDate.replace('/',"-");
		var startDate 	= startDate.replace('/',"-");
		var startDate 	= startDate.replace('/',"-");
		var startDate 	= startDate.replace(' ',"");
		
		
		var endDate 	= endDate.replace('/',"-");
		var endDate 	= endDate.replace('/',"-");
		var endDate 	= endDate.replace('/',"-");
		var endDate 	= endDate.replace(' ',"");

		
		var compStatus 	= this.value;
		
		//alert("analytics-business-verticle.php?from_date="+startDate+"&to_date="+endDate+"&comp_status="+this.value);
		
		console.log("analytics-business-verticle.php?from_date="+startDate+"&to_date="+endDate+"&comp_status="+compStatus);
				
		$("#business_verticle").load("analytics-business-verticle.php?from_date="+startDate+"&to_date="+endDate+"&comp_status="+this.value);
		
		
	});
	
var options = {
    chart: {
        height: 380,
        type: "pie"
    },
	<?php echo "series: [{$complaints_auto},{$complaints_crgo},{$complaints_crno}]"; ?>,
	<?php echo "labels: ['Auto - {$complaints_auto}','CRGO - {$complaints_crgo}','CRNO - {$complaints_crno}']"; ?>,
    colors: ["#0acf97", "#727cf5","#ffbc00"],
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
(chart = new ApexCharts(document.querySelector("#business_verticle_graph"), options)).render();
</script>