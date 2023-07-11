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
		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != 'Employee' AND emp_sub_role != 'Viewer' AND emp_sub_role != '' Limit 1";
		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
		if(!$employee_location){
			redirect_to("logout.php"); 
		}
	}
?>
<h4 class="header-title">
	<a href="analytics-business-verticle-table.php"><i class="mdi mdi-table"></i> Business verticle</a>
	<select id="comp_status" name="comp_status" class="form-control select2" data-toggle="select2"  style="float: right; width: 170px;">
		<option value="">- Complaint Status -</option>
		<option <?php if(isset($_GET['comp_status']) && !empty($_GET['comp_status'])){ if($_GET['comp_status'] == ''){ echo "Selected"; }}?> value="">All</option>
		<option <?php if(isset($_GET['comp_status']) && !empty($_GET['comp_status'])){ if($_GET['comp_status'] == 'Open'){ echo "Selected"; }}?>>Open</option>
		<option <?php if(isset($_GET['comp_status']) && !empty($_GET['comp_status'])){ if($_GET['comp_status'] == 'Closed'){ echo "Selected"; }}?>>Closed</option>
		<option <?php if(isset($_GET['comp_status']) && !empty($_GET['comp_status'])){ if($_GET['comp_status'] == 'Invalid'){ echo "Selected"; }}?>>Invalid</option>
	</select>
	<div class="input-group" style="float: right; width: 200px; margin-right: 10px;">
		<div class="custom-file">
			<input readonly type="text" value="<?php if(isset($_GET['date_range'])){echo $_GET['date_range'];} ?>" id="date_range" name="date_range" placeholder="Select Date Range" class="form-control date-picker verticle_date_picker" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="false">
		</div>
	</div>
</h4>

<div id="business_verticle_graph" class="apex-charts"></div>

<?php
	
	if(isset($_GET['comp_status'])){
		$comp_status = $_GET['comp_status'];
	} else {
		$comp_status = '';
	}

	$complaints_auto = 0;
	$complaints_crgo = 0;
	$complaints_crno = 0;

	if(isset($_GET['from_date']) && !empty($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['to_date'])){
		
		$from_date = str_replace('/', '-', $_GET['from_date']);
		$from_date = strtotime($from_date); 
		$from_date = date("Y-m-d", $from_date);
		
		$to_date = str_replace('/', '-', $_GET['to_date']);
		$to_date = strtotime($to_date); 
		$to_date = date("Y-m-d", $to_date);
		
		$date_range = date("d/m/Y", strtotime(str_replace('/', '-', $_GET['from_date'])))." - ".date("d/m/Y", strtotime(str_replace('/', '-', $_GET['to_date'])));
		
		$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee'";
		$employee_location = EmployeeLocation::find_by_sql($sql_el);

		$source_mill_count = 0;
		$source_plant_count = 0;
		$prod_id = '';
		
		foreach($employee_location as $employee_location){
			$product = Product::find_by_id($employee_location->product_id);
			
		
				$from_date = $_GET['from_date'];
				$to_date = $_GET['to_date'];
				
				if(empty($comp_status)){
					$auto_sql = "SELECT * FROM complaint WHERE business_vertical = 'Auto' AND plant_location = '{$product->site_location}' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date. "'";
					$complaints_autos 	= Complaint::find_by_sql($auto_sql);
					foreach($complaints_autos as $complaints_autos){ if($prod_id != $product->id){ $complaints_auto++;}	 }
					
					$crgo_sql = "SELECT * FROM complaint WHERE business_vertical = 'CRGO' AND plant_location = '{$product->site_location}' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date. "'";
					$complaints_crgos 	= Complaint::find_by_sql($crgo_sql);
					foreach($complaints_crgos as $complaints_crgos){ if($prod_id != $product->id){ $complaints_crgo++;} }
					
					$crno_sql = "SELECT * FROM complaint WHERE business_vertical = 'CRNO' AND plant_location = '{$product->site_location}' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date. "'";
					$complaints_crnos 	= Complaint::find_by_sql($crno_sql);
					foreach($complaints_crnos as $complaints_crnos){ if($prod_id != $product->id){ $complaints_crno++;}}
					
					$prod_id = $product->id;
				} else {
					$auto_sql = "SELECT * FROM complaint WHERE business_vertical = 'Auto' AND plant_location = '{$product->site_location}' AND status = '" . $comp_status. "' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date. "'";
					$complaints_autos 	= Complaint::find_by_sql($auto_sql);
					foreach($complaints_autos as $complaints_autos){ if($prod_id != $product->id){ $complaints_auto++;}	 }
					
					$crgo_sql = "SELECT * FROM complaint WHERE business_vertical = 'CRGO' AND plant_location = '{$product->site_location}' AND status = '" . $comp_status. "' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date. "'";
					$complaints_crgos 	= Complaint::find_by_sql($crgo_sql);
					foreach($complaints_crgos as $complaints_crgos){ if($prod_id != $product->id){ $complaints_crgo++;}}
					
					$crno_sql = "SELECT * FROM complaint WHERE business_vertical = 'CRNO' AND plant_location = '{$product->site_location}' AND status = '" . $comp_status. "' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date. "'";
					$complaints_crnos 	= Complaint::find_by_sql($crno_sql);
					foreach($complaints_crnos as $complaints_crnos){ if($prod_id != $product->id){ $complaints_crno++;} }
					
					$prod_id = $product->id;
				}

			
		
		}
		
		//$complaints_auto 	= Complaint::count_by_complaint_verticle_date($from_date, $to_date,'Auto',$comp_status);
		//$complaints_crgo 	= Complaint::count_by_complaint_verticle_date($from_date, $to_date,'CRGO',$comp_status); 
		//$complaints_crno 	= Complaint::count_by_complaint_verticle_date($from_date, $to_date,'CRNO',$comp_status); 
	} else {
		
		$sql_el = "Select * from employee_location where emp_id = '{$session->employee_id}' AND emp_sub_role != 'Employee'";
		$employee_location = EmployeeLocation::find_by_sql($sql_el);

		$source_mill_count = 0;
		$source_plant_count = 0;

		foreach($employee_location as $employee_location){
			$product = Product::find_by_id($employee_location->product_id);
			
			if(empty($comp_status)){
				$auto_sql = "SELECT * FROM complaint WHERE business_vertical = 'Auto' AND plant_location = '{$product->site_location}'";
				$complaints_autos 	= Complaint::find_by_sql($auto_sql);
				foreach($complaints_autos as $complaints_autos){ $complaints_auto++;}

				$crgo_sql = "SELECT * FROM complaint WHERE business_vertical = 'CRGO' AND plant_location = '{$product->site_location}'";
				$complaints_crgos 	= Complaint::find_by_sql($crgo_sql);
				foreach($complaints_crgos as $complaints_crgos){ $complaints_crgo++;}

				$crno_sql = "SELECT * FROM complaint WHERE business_vertical = 'CRNO' AND plant_location = '{$product->site_location}'";
				$complaints_crnos 	= Complaint::find_by_sql($crno_sql);
				foreach($complaints_crnos as $complaints_crnos){ $complaints_crno++;}
			} else {
				$auto_sql = "SELECT * FROM complaint WHERE business_vertical = 'Auto' AND plant_location = '{$product->site_location}' AND status = '" . $comp_status. "'";
				$complaints_autos 	= Complaint::find_by_sql($auto_sql);
				foreach($complaints_autos as $complaints_autos){ $complaints_auto++;}

				$crgo_sql = "SELECT * FROM complaint WHERE business_vertical = 'CRGO' AND plant_location = '{$product->site_location}' AND status = '" . $comp_status. "'";
				$complaints_crgos 	= Complaint::find_by_sql($crgo_sql);
				foreach($complaints_crgos as $complaints_crgos){ $complaints_crgo++;}

				$crno_sql = "SELECT * FROM complaint WHERE business_vertical = 'CRNO' AND plant_location = '{$product->site_location}' AND status = '" . $comp_status. "'";
				$complaints_crnos 	= Complaint::find_by_sql($crno_sql);
				foreach($complaints_crnos as $complaints_crnos){ $complaints_crno++;}
			}
		}
		//$complaints_auto 	= Complaint::count_by_complaint_verticle('Auto');
		//$complaints_crgo 	= Complaint::count_by_complaint_verticle('CRGO'); 
		//$complaints_crno	= Complaint::count_by_complaint_verticle('CRNO'); 
		
		$date_range = "";
	}

?>
<script>
	$('.verticle_date_picker').val('<?php if(!empty($date_range)){echo $date_range; }?>');

	$('.date-picker').daterangepicker({
		singleDatePicker: false,
		locale: {
		  format: 'DD/MM/YYYY',
		}
	});
	
	//$('.verticle_date_picker').val('<?php //if(!empty($date_range)){echo $date_range; }?>');
	
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