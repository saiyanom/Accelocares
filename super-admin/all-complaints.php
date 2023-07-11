<?php 

	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("all-complaints.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("all-complaints.php");
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindraaccelo All Complaints</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content=" " name="description" />
<meta content="Coderthemes" name="author" />
<!-- third party css -->
<link href="assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
<link href="assets/css/vendor/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
<link href="assets/css/vendor/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
<link href="assets/css/vendor/select.bootstrap4.css" rel="stylesheet" type="text/css" />
        <!-- third party css end -->

<style>
   	#my-complaints_info{ display:none;}
   	
   	#my-complaints_filter{ display:none;}
	.dt-buttons {float:right !important; margin: -43px 0 0 0;}
	.dt-buttons button{background: #71bf44 !important; border-color: #71bf44;}
	.dt-buttons button:hover{background:#26990A !important; border-color: #26990A;}
	
	.basic-datatable tr td, .basic-datatable tr th {
		padding: 5px 30px 5px 5px !important;
		text-align: left;
	}
	table.dataTable thead .sorting:before, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc_disabled:before {
		top: 8px !important;
	}
	table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_desc_disabled:after {
		top: 2px !important;
	}
</style>

</head>
<!-- sidebar-enable -->
<body class="larged" data-keep-enlarged="true">

<!-- Begin page -->
<div class="wrapper">

<!-- ========== LEFT HEADER Sidebar Start ========== -->
<?php include 'left-header.php'?>
<!-- ========== LEFT HEADER Sidebar Start ========== -->

<!-- ============================================================== --><!-- Start Page Content here --><!-- ============================================================== -->

<div class="content-page">
<div class="content">

<!-- ========== TOP Sidebar Start ========== -->
<?php include 'top-header.php'?>
<!-- ========== TOP Sidebar Start ========== -->



<!-- Start Content-->
<div class="container-fluid">

	<?php  $message = output_message($message); ?>
	<div class="alert fade show text-white <?php 
		if($message == "Meeting Added Successfully"){echo "bg-success";} 
		else if($message == "Complaint Updated Successfully"){echo "bg-success";} 		
		else if($message == "Approval Note Created Successfully"){echo "bg-success";} 		
		else if($message == "CAPA Created Successfully"){echo "bg-success";} 	
		else if($message == "Meeting Deleted Successfully."){echo "bg-success";} 					
		else {echo "bg-danger";}?>" 
	<?php if(empty($message)){echo " style='display:none';";} else {echo " style='margin-top:20px';";} ?> >
	<a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
	<?php echo $message; ?>
	</div>

<!-- start page title -->
     
<!-- end page title --> 


<div class=" ">
<div class="col-12">
	<div class="bord-box">
		<div class="card-body">
			<div class="al-com">
				<div class="compl-lef"><h4>Search</h4></div>
				<div class="clerfix"></div>
			</div>
			<div class="form-block">
			<form method="get" enctype="multipart/form-data" autocomplete="off">
				<input type="hidden" name="status" value="<?php if(isset($_GET['status'])){echo $_GET['status'];} ?>" />
			<ul class="form-block-con">
				<li><select id="company" name="company" class="form-control select2" data-toggle="select2">
					<option value="">- Select Company -</option>
					<?php
						$company_reg = CompanyReg::find_all();
						foreach($company_reg as $company_reg){
							echo "<option ";
							if(isset($_GET['company']) && !empty($_GET['company'])){
								if($_GET['company'] == $company_reg->id){ echo "Selected";}
							}
							echo " value='{$company_reg->id}'>{$company_reg->company_name}</option>";
						}
					?>
				</select></li>
				<li>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text clear_img clear_date" title="Clear Image">X</span>
						</div>
						<div class="custom-file">
							<input readonly type="text" value="<?php if(isset($_GET['date_range'])){ echo $_GET['date_range'];} ?>" id="date_range" name="date_range" placeholder="Select Date Range" class="form-control date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="false">
						</div>
					</div>
				</li>
				<li><select id="department" name="department" class="form-control select2" data-toggle="select2">
						<option value="">- Business Vertical -</option>
						<?php 
							$department = Department::find_all();
							foreach($department as $department){
								echo "<option ";
								if(isset($_GET['department']) && !empty($_GET['department'])){
									if($_GET['department'] == $department->id){ echo "Selected";}
								}
								echo " value='{$department->id}'>{$department->department}</option>";
							}
						?>
				</select></li>
				<li>
					<select id="complaintType" name="complaint_type" class="form-control">
						<option value="">- Complaint Type -</option>
					</select>
					<span class="err_msg complaint_type_msg"></span>
				</li>
				<li class="resit-act1" id="complaintOtherSubType">
					<select id="complaintSubType" name="sub_complaint_type" class="form-control">
						<option value="">- Sub Complaint Type -</option>
					</select>
					<span class="err_msg sub_complaint_type_msg"></span>
				</li>

				<li>
					<select id="identify_source" name="identify_source" class="form-control">
						<option value="">Source</option>
						<option <?php if(isset($_GET['identify_source']) && !empty($_GET['identify_source'])){if($_GET['identify_source'] == "Plant"){ echo "Selected";}}?>>Plant</option>
						<option <?php if(isset($_GET['identify_source']) && !empty($_GET['identify_source'])){if($_GET['identify_source'] == "Mill"){ echo "Selected";}}?>>Mill</option>
					</select>
				</li>
				<li>
					<div class="inputs">
						<label class="lowerlimit">Lower Limit: </label><input name="lower_aging" type="hidden" class="lowerlimit" />
						<label class="upperlimit" style="float: right;"></label><input name="upper_aging" type="hidden" class="upperlimit" />
					</div> 
					<div id="mySlider"></div>
				</li>
				<li>
					<div class="form-group mb-0 text-center log-btn">
						<button class="btn btn-primary btn-block" type="submit">Search </button>
					</div>
				</li>
			</ul>
			</form>
			</div>
		</div>
	</div>	

<div class="bord-box">
<div class="card-body">
<div class="al-com">
<div class="compl-lef"><h4>All Complaints</h4></div>
<div class="clerfix"></div>
</div>

<table id="my-complaints" class="table dt-responsive nowrap basic-datatable" width="100%">
<thead>
<tr>
<th>Complaint No</th>
<th>Company Name</th>
<th>Complaint Type</th>
<th>Sub Complaint Type</th>
<th>Date</th>
<th>Product</th>
<th>Location</th>
<th>Quantity</th>
<th>Busi. Ver.</th>
<th>Source</th>
<th>Status</th>
<th>Action</th>
<th>Ageing</th>
<th>Employee</th>
</tr>
</thead>

<tbody>
	<?php
	
		$num = 0;
		if(!empty($_GET['status'])){
			$status = " status = '{$_GET['status']}' AND ";
			$num++;
		} else { $status = ""; }
	
	
		if(isset($_GET['company'])){
			if(!empty($_GET['company'])){
				$company = CompanyReg::find_by_id($_GET['company']);
				$company = " customer_id = '{$company->customer_id}' AND ";
				$num++;
			} else { $company = ""; }
			
			if(!empty($_GET['date_range'])){
				$from_date = strtok($_GET['date_range'], '-');
				$from_date = strtotime($from_date); 
				$from_date = date("Y-m-d", $from_date); 
				list(, $to_date) = explode('-', $_GET['date_range']);
				$to_date = strtotime($to_date); 
				$to_date = date("Y-m-d", $to_date); 
				
				$date_range = " date_ BETWEEN '{$from_date}' AND '{$to_date}' AND ";
				$num++;
			} else { $date_range = "";}
			
			if(!empty($_GET['department'])){
				$department = Department::find_by_id($_GET['department']);
				$department = " business_vertical = '{$department->department}' AND ";
				$num++;
			} else { $department = ""; }
			
			if(!empty($_GET['complaint_type'])){
				$complaint_type = $complaint_type_og = ComplaintType::find_by_id($_GET['complaint_type']);
				$complaint_type = " complaint_type = '{$complaint_type->complaint_type}' AND ";
				$num++;
			} else { $complaint_type = ""; $complaint_type_og = "";}
			
			if(!empty($_GET['sub_complaint_type'])){
				$sub_complaint_type = " sub_complaint_type = '{$_GET['sub_complaint_type']}' AND ";
				$num++;
			} else { $sub_complaint_type = ""; }
			
			if(!empty($_GET['identify_source'])){
				$identify_source = " identify_source = '{$_GET['identify_source']}' AND ";
				$num++;
			} else { $identify_source = ""; }
			
			if(!empty($_GET['upper_aging'])){
				$lower_aging = $_GET['lower_aging'];
				$upper_aging = $_GET['upper_aging'];
				$num++;
			} else { 
				$lower_aging = 0;
				$upper_aging = 20;
			}
			
			
			//echo $num."<hr />";
			if($num > 0){
				$sql = "Select * from complaint where {$company} {$status} {$date_range} {$department} {$complaint_type} {$sub_complaint_type} {$identify_source} date_ != '0000-00-00' order by id DESC";
				$complaint = Complaint::find_by_sql($sql);
			} else {
				$complaint = Complaint::find_all();
			}			
		} else {
			$lower_aging = 0;
			$upper_aging = 20;
			
			$sql = "Select * from complaint where {$status} date_ != '0000-00-00' order by id DESC";
			$complaint = Complaint::find_by_sql($sql);
		}
		
		
		$num =1;
		//$complaint = Complaint::find_by_cust_id($employee->$employee_id);
		foreach($complaint as $complaint){
			/* Days count without skipping Weekends
			$now 		= time(); // or your date as well
			$your_date 	= strtotime($complaint->date_);
			$datediff 	= $now - $your_date;
			$aging 		= round($datediff / (60 * 60 * 24));*/

			// Days count with skipping Weekends
			$db_date 	= $complaint->date_;
			
			if( validateDate( $complaint->comp_closed_date ) ){
				$today = $complaint->comp_closed_date;
			}else{
				$today = date("Y-m-d");
			}
			

			$start = new DateTime($db_date);
			$end = new DateTime($today);

			$end->modify('+1 day');

			$interval = $end->diff($start);

			$aging = $interval->days;

			$period = new DatePeriod($start, new DateInterval('P1D'), $end);

			$holidays = array('2012-09-07');

			foreach($period as $dt) {
				$curr = $dt->format('D');

				if ($curr == 'Sat' || $curr == 'Sun') {
					$aging--;
				}

				elseif (in_array($dt->format('Y-m-d'), $holidays)) {
					$aging--;
				}
			}
			

			if(isset($_GET['upper_aging'])){
				if($aging <= $upper_aging && $aging >= $lower_aging){
					echo "<tr>";
					echo "<td>".$complaint->ticket_no."</td>";
					echo "<td>".$complaint->company_name."</td>";
					echo "<td>".$complaint->complaint_type."</td>";
					echo "<td>".$complaint->sub_complaint_type."</td>";
					echo "<td>".date( 'd-m-Y', strtotime($complaint->invoice_date))."</td>";
					echo "<td>".$complaint->product."</td>";
          echo "<td>".$complaint->plant_location."</td>";
					echo "<td>".$complaint->rejected_quantity."</td>";
					echo "<td>".$complaint->business_vertical."</td>";
          // echo "<td>".$complaint->identify_source."</td>";
					
					echo "<td>".getSourceText($complaint)."</td>";
					
					
					//echo "<td><span class='open-td'>".$complaint->emp_status."</span></td>";
					echo "<td><span class='open-td'>". customComplaintStatus($complaint) ."</span></td>";
					echo "<td><a href='view-complaints.php?id={$complaint->id}'>View</a></td>";
					echo "<td>".$aging."</td>";															
					echo "<td><form method='post' action='reassign-employee-db.php?id={$complaint->id}' autocomplete='off'><select style='width: 70%; float-left; display:inline' class='form-control assign_emp select_{$num} select2' data-toggle='select2' id='employee_{$num}' name='employee'>";
							
							$sql_product = "Select * from product where department = '{$complaint->business_vertical}' AND site_location = '{$complaint->plant_location}' AND product = '{$complaint->product}'";
							$product = Product::find_by_sql($sql_product);

							foreach ($product as $product) {
								$sql_emp_loc = "Select * from employee_location where product_id = {$product->id}";
								$emp_location = EmployeeLocation::find_by_sql($sql_emp_loc);

								foreach ($emp_location as $emp_location) {
									echo "<option ";
									if($emp_location->emp_id == $complaint->emp_id){ echo "Selected";}
									echo " value='{$emp_location->emp_id}'>{$emp_location->emp_name}, {$emp_location->emp_email}</option>";
								}
							}
					echo "</select><button style='width: 20%; margin-left: 10px; float-left;' class='btn btn-success' type='submit'>Submit</button></form></td>";
					echo "</tr>";
					$num++;
				}
			} else {
				echo "<tr>";
				echo "<td>".$complaint->ticket_no."</td>";
				echo "<td>".$complaint->company_name."</td>";
				echo "<td>".$complaint->complaint_type."</td>";
				echo "<td>".$complaint->sub_complaint_type."</td>";
				echo "<td>".date( 'd-m-Y', strtotime($complaint->invoice_date))."</td>";
				echo "<td>".$complaint->product."</td>";
        echo "<td>".$complaint->plant_location."</td>";
				echo "<td>".$complaint->rejected_quantity."</td>";
				echo "<td>".$complaint->business_vertical."</td>";
        // echo "<td>".$complaint->identify_source."</td>";
				
			  echo "<td>".getSourceText($complaint)."</td>";

				//echo "<td><span class='open-td'>".$complaint->emp_status."</span></td>";
				echo "<td><span class='open-td'>". customComplaintStatus($complaint) ."</span></td>";
				echo "<td><a href='view-complaints.php?id={$complaint->id}'>View</a></td>";
				echo "<td>".$aging."</td>";
				echo "<td><form method='post' action='reassign-employee-db.php?id={$complaint->id}' autocomplete='off'><select style='width: 70%; float-left; display:inline' class='form-control assign_emp select_{$num} select2' data-toggle='select2' id='employee_{$num}' name='employee'>";
						
						$sql_product = "Select * from product where department = '{$complaint->business_vertical}' AND site_location = '{$complaint->plant_location}' AND product = '{$complaint->product}'";
						$product = Product::find_by_sql($sql_product);

						foreach ($product as $product) {
							$sql_emp_loc = "Select * from employee_location where product_id = {$product->id}";
							$emp_location = EmployeeLocation::find_by_sql($sql_emp_loc);

							foreach ($emp_location as $emp_location) {
								echo "<option ";
								if($emp_location->emp_id == $complaint->emp_id){ echo "Selected";}
								echo " value='{$emp_location->emp_id}'>{$emp_location->emp_name}, {$emp_location->emp_email}</option>";
							}
						}
				echo "</select><button style='width: 20%; margin-left: 10px; float-left;' class='btn btn-success' type='submit'>Submit</button></form></td>";
				echo "</tr>";
				$num++;
			}
		}

	?>	
</tbody>	

</table>
</div>
</div>
 <!-- end card body-->
</div> <!-- end card -->
</div><!-- end col-->
</div>
<!-- end row-->


</div>
<!-- container -->


</div>
<!-- content -->

<!-- Footer Start -->
<?php include 'footer.php'?>
<!-- end Footer -->
</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->
</div>
<!-- END wrapper -->
<!-- third party js -->
<script src="assets/js/vendor/jquery.dataTables.js"></script>
<script src="assets/js/vendor/dataTables.bootstrap4.js"></script>
<script src="assets/js/vendor/dataTables.responsive.min.js"></script>
<script src="assets/js/vendor/responsive.bootstrap4.min.js"></script>
<script src="assets/js/vendor/dataTables.buttons.min.js"></script>
<script src="assets/js/vendor/buttons.bootstrap4.min.js"></script>
<script src="assets/js/vendor/buttons.html5.min.js"></script>
<script src="assets/js/vendor/buttons.flash.min.js"></script>
<script src="assets/js/vendor/buttons.print.min.js"></script>
<script src="assets/js/vendor/dataTables.keyTable.min.js"></script>
<script src="assets/js/vendor/dataTables.select.min.js"></script>
<!-- third party js ends -->
<!-- demo app -->
<script src="assets/js/pages/demo.datatable-init.js"></script>
<!-- end demo js-->

<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/hot-sneaks/jquery-ui.css" />
<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>	
<script type="application/javascript">	
	
	$(document).ready(function() {
		
		$('#my-complaints').DataTable( {
			scrollCollapse: false,
			autoWidth: false,
			responsive: false,
			"scrollX": true,
			"bStateSave": true,
			columnDefs: [{
				targets: "0",
				orderable: false,
			}],
			"bSort" : true,
			"order": [[ 0, "desc" ]],
			dom: 'Bfrtip',
			buttons: [{
	           extend: 'csv',
	            exportOptions: {
	                columns: [0,1,2,3,4,5,6,7,8,9,10,12]
	            }	          
	       }],
			"lengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
			"language": {
				"info": "_START_-_END_ of _TOTAL_ entries",
				searchPlaceholder: "Search"
			},
		} );
		
		$('.buttons-csv span').html('Download Excel');
        
		$('#mySlider').slider({
			<?php echo "values: [{$lower_aging}, {$upper_aging}]"; ?>,
			//values: [10, 30],
			range: true,
			min: 0,
			max: 120,
			create: attachSlider,
			slide: attachSlider,
			stop: attachSlider
		})

		function attachSlider() {
			$('.lowerlimit').val($('#mySlider').slider("values", 0));
			$('label.lowerlimit').html($('#mySlider').slider("values", 0));
			$('.upperlimit').val($('#mySlider').slider("values", 1));
			$('label.upperlimit').html($('#mySlider').slider("values", 1));
		}

		$('input').change(function(e) {
			var setIndex = (this.id == "upperlimit") ? 1 : 0;
			$('#mySlider').slider("values", setIndex, $(this).val())
		})


	});

	
	$(".clear_date").click(function(){
		$("#date_range").val("");
	});
	
	<?php 
		if(empty($_GET['date_range'])){
			echo "$('#date_range').val('');";
		}
	
		if(isset($_GET['complaint_type'])){?>

		if($("#department").val() == ""){
			//alert("Yes");
		} else {
			var department = $("#department").val();

			$("#complaintType").load("search-complaint-type.php?department="+department, function() {
				$("#complaintType").val("<?php echo $_GET['complaint_type']; ?>").attr("selected","selected");

				var complaint 	= $("#complaintType").val().replace(" ","%20");
				var department 	= $("#department").val().replace(" ","%20");	
				$("#complaintSubType").load("search-complaint-sub-type.php?department="+department+"&&complaint="+complaint, function() {
					$("#complaintSubType").val("<?php echo $_GET['sub_complaint_type']; ?>").attr("selected","selected");
				});	

			});	
		}
	<?php } ?>
	
	
//----------------------------------------------------------------------
	
	$("#department").change(function(){
		var department = this.value;
		$("#complaintType").load("search-complaint-type.php?department="+department);
	});	
		
	
	$("#complaintType").change(function(){
		var complaint 	= this.value.replace(" ","%20");
		var department 	= $("#department").val().replace(" ","%20");	
		$("#complaintSubType").load("search-complaint-sub-type.php?department="+department+"&&complaint="+complaint);
	});
	
</script>
<style>




@media only screen and (max-width: 800px) {
  .btn-group>.btn:first-child {
	    margin-top: 10px !important;
	    float: right !important;
	    font-size: 12px !important;
	    padding: 5px !important;
	}
}

	.select2-container {
		width: 100% !important;
	}
	
/* Interaction states----------------------------------*/
.ui-state-default,
.ui-widget-content .ui-state-default,
.ui-widget-header .ui-state-default {
	border: 1px solid #ebce35 !important;
	background: #ebce35 !important;
	font-weight: bold;
	color: #333333;
	border-radius: 20px;
}
.ui-state-default a,
.ui-state-default a:link,
.ui-state-default a:visited {
	color: #333333;
	text-decoration: none;
}
.ui-state-hover,
.ui-widget-content .ui-state-hover,
.ui-widget-header .ui-state-hover,
.ui-state-focus,
.ui-widget-content .ui-state-focus,
.ui-widget-header .ui-state-focus {
	border: 1px solid #999999;
	background: #ccd232 url("images/ui-bg_diagonals-small_75_ccd232_40x40.png") 50% 50% repeat;
	font-weight: bold;
	color: #212121;
}
.ui-state-hover a,
.ui-state-hover a:hover,
.ui-state-hover a:link,
.ui-state-hover a:visited,
.ui-state-focus a,
.ui-state-focus a:hover,
.ui-state-focus a:link,
.ui-state-focus a:visited {
	color: #212121;
	text-decoration: none;
}
.ui-state-active,
.ui-widget-content .ui-state-active,
.ui-widget-header .ui-state-active {
	border: 1px solid #ff6b7f;
	background: #db4865 url("images/ui-bg_diagonals-small_40_db4865_40x40.png") 50% 50% repeat;
	font-weight: bold;
	color: #ffffff;
}
.ui-state-active a,
.ui-state-active a:link,
.ui-state-active a:visited {
	color: #ffffff;
	text-decoration: none;
}
	
.ui-widget-header {
    border: 1px solid #bbb !important;
    background: #bbb !important;
    color: #e1e463;
    font-weight: bold;
}	
.ui-corner-all, .ui-corner-bottom, .ui-corner-right, .ui-corner-br {
    border-radius: 20px !important;
}
	
span.clear_img{
	cursor: pointer;
	color: #fff;
	background-color: #a00;
	border: 1px solid #900;
}
</style>	
</body>
</html>


