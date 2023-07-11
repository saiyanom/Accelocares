<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }
	////date_default_timezone_set('Asia/Calcutta');

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("delivery-compliance.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("delivery-compliance.php");
		}
	}

	if(isset($_GET['dateYear'])){
		if(!is_numeric($_GET['dateYear'])) {
			$session->message("Invalid Date."); redirect_to("delivery-compliance.php");
		}
		if(strlen($_GET['dateYear']) != 4) {
			$session->message("Invalid Date."); redirect_to("delivery-compliance.php");
		}
	}
	
	if(isset($_GET['company'])){
		if(!is_numeric($_GET['company'])) {
			$session->message("Invalid Company."); redirect_to("delivery-compliance.php");
		}
	}

	if(isset($_GET['location'])){
		if(is_numeric($_GET['location'])) {
			$session->message("Invalid Location."); redirect_to("delivery-compliance.php");
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindraaccelo Delivery Compliance</title>
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
   	#delivery-compliance_info{ display:none;}
   	#delivery-compliance_paginate {display: none;}
   	#delivery-compliance_filter{ display:none;}
	.dt-buttons {float:right !important; margin: -50px 0 0 0;}
	.dt-buttons button{background: #71bf44 !important; border-color: #71bf44;}
	.dt-buttons button:hover{background:#26990A !important; border-color: #26990A;}
	
	.basic-datatable tr td {
		padding: 5px 0px 5px 5px !important;
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
	

<div class=" ">

<div class="bord-box">
	<div class="card-body">
		<div class="al-com">
			<div class="compl-lef"><h4>Search</h4></div>
			<?php 
				//echo date("Y");
				if(isset($_GET['dateYear']) && !empty($_GET['dateYear'])){
					$year = $_GET['dateYear'];
				} else {
					if (date('m') > 3) {$year = date('Y');} 
					else { $year = (date('Y') - 1); }
				} 
			?>
			<div class="clerfix"></div>
		</div>
		<div class="form-block">
		<form method="get" enctype="multipart/form-data" autocomplete="off">
		<ul class="form-block-con">
			<li>
				<select id="dateYear" name="dateYear" class="form-control">
					<option value="">Search by Year</option>
					<option <?php if(isset($_GET['dateYear']) && $_GET['dateYear'] == '2018'){echo "Selected"; } else if($year == '2018'){echo "Selected"; }?> value="2018">2018-2019</option>
					<option <?php if(isset($_GET['dateYear']) && $_GET['dateYear'] == '2019'){echo "Selected"; } else if($year == '2019'){echo "Selected"; }?> value="2019">2019-2020</option>
					<option <?php if(isset($_GET['dateYear']) && $_GET['dateYear'] == '2020'){echo "Selected"; } else if($year == '2020'){echo "Selected"; }?> value="2020">2020-2021</option>
					<option <?php if(isset($_GET['dateYear']) && $_GET['dateYear'] == '2021'){echo "Selected"; } else if($year == '2021'){echo "Selected"; }?> value="2021">2021-2022</option>
					<option <?php if(isset($_GET['dateYear']) && $_GET['dateYear'] == '2022'){echo "Selected"; } else if($year == '2022'){echo "Selected"; }?> value="2022">2022-2023</option>
					<option <?php if(isset($_GET['dateYear']) && $_GET['dateYear'] == '2023'){echo "Selected"; } else if($year == '2023'){echo "Selected"; }?> value="2023">2023-2024</option>
					<option <?php if(isset($_GET['dateYear']) && $_GET['dateYear'] == '2024'){echo "Selected"; } else if($year == '2024'){echo "Selected"; }?> value="2024">2024-2025</option>
					<option <?php if(isset($_GET['dateYear']) && $_GET['dateYear'] == '2025'){echo "Selected"; } else if($year == '2025'){echo "Selected"; }?> value="2025">2025-2026</option>
					<option <?php if(isset($_GET['dateYear']) && $_GET['dateYear'] == '2026'){echo "Selected"; } else if($year == '2026'){echo "Selected"; }?> value="2026">2026-2027</option>
					<option <?php if(isset($_GET['dateYear']) && $_GET['dateYear'] == '2027'){echo "Selected"; } else if($year == '2027'){echo "Selected"; }?> value="2027">2027-2028</option>
				</select>
			</li>
			<li><select id="company" name="company" class="form-control select2" data-toggle="select2">
				<option value="">- Select Company -</option>
				<?php
					$company_reg = CompanyReg::find_all();
					foreach($company_reg as $company_reg){
						echo "<option ";
						if(isset($_GET['company']) && !empty($_GET['company'])){
							if($_GET['company'] == $company_reg->id){ echo "Selected";}
						}
						echo " value='{$company_reg->id}'>{$company_reg->customer_id} {$company_reg->company_name}</option>";
					}
				?>
			</select></li>
			<li><select id="location" name="location" class="form-control select2" data-toggle="select2">
					<option value="">- Location -</option>
					<?php 
						$sql = "Select site_location from site_location order by site_location ASC";
						$site_location = SiteLocation::find_by_sql($sql);
						$repeat_location = '';
						foreach($site_location as $site_location){
							if($repeat_location != $site_location->site_location){
								echo "<option ";
								if(isset($_GET['location']) && !empty($_GET['location'])){
									if($_GET['location'] == $site_location->site_location){ echo "Selected";}
								}
								echo " value='{$site_location->site_location}'>{$site_location->site_location}</option>";
								$repeat_location = $site_location->site_location;
							}
						}
					?>
			</select></li>
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
	<?php  $message = output_message($message); ?>
	<div class="alert fade show text-white <?php 
				if($message == "Data Added Successfully."){echo "bg-success";} 
				else if($message == "Data Updated Successfully."){echo "bg-success";} 		
				else {echo "bg-danger";}?>" 
		<?php if(empty($message)){echo "style='display:none;'";}?>>
		<a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
		<?php echo $message; ?>
	</div>
</div><!-- end col-->	
	
<div class="row">

	<div class="col-xl-6">

		<div class="card">
			<div class="card-body">
				<div class="al-com">
				<div class="compl-lef"><h4>Delivery Compliance</h4></div>
				<div class="clerfix"></div>
				</div>

				<table id="delivery-compliance" class="table dt-responsive table-condensed nowrap basic-datatable" width="100%">
				<thead>
				<tr>
					<td>#</td>
					<td>Reliable</td>
					<td>Target</td>
					<td>Actual</td>
					<td>Action</td>
				</tr>
				</thead>

				<tbody>
					<?php
						if(isset($_GET['dateYear']) && !empty($_GET['dateYear'])){
							$fromYear 	= $_GET['dateYear'];
							$toYear		= ($_GET['dateYear'] + 1);
							
							$year = $_GET['dateYear'];
						} else {
							if (date('m') > 3) { 
								$fromYear 	=  date('Y')."-4-1";
								$toYear		= (date('Y') + 1)."-3-31";
								
								$onlyFromYear 	= date('Y');
								$onlyToYear 	= (date('Y') + 1);
							} else { 
								$fromYear 	= (date('Y') - 1)."-4-1";
								$toYear		=  date('Y')."-3-31";
								
								$onlyFromYear 	= (date('Y') - 1);
								$onlyToYear 	= date('Y');
							}
						}
					
						if(isset($_GET['company']) && !empty($_GET['company'])){
							$company_reg 	= CompanyReg::find_by_id($_GET['company']);
							$company 		= $company_reg->company_name;
							$company_id 	= $company_reg->id;
						} else { 
							$customer_delivery_compliance = CustomerDeliveryCompliance::find_first();
							$company 		= $customer_delivery_compliance->company;
							$company_id 	= $customer_delivery_compliance->company_id;
						}
					
						if(isset($_GET['location']) && !empty($_GET['location'])){
							$location = $_GET['location'];
						} else {
							$customer_delivery_compliance = CustomerDeliveryCompliance::find_first();
							$location = $customer_delivery_compliance->location;
						}
					
						
						if(!empty($company) && !empty($location)) {
						$apr_delivery_compliance = CustomerDeliveryCompliance::find_by_month($year."-04-01", $company, $location);
						echo "<tr>";
						echo "<td>1</td>";
						echo "<td> Apr {$year}</td>";
						echo "<td>";if($apr_delivery_compliance){echo $apr_delivery_compliance_target = $apr_delivery_compliance->target; }else {$apr_delivery_compliance_target=0;}echo "</td>";
						echo "<td>";if($apr_delivery_compliance){echo $apr_delivery_compliance_actual = $apr_delivery_compliance->actual;}else {$apr_delivery_compliance_actual=0;} echo "</td>";
						echo "<td>";
							if($apr_delivery_compliance){
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#edit-delivery-compliance' href='#' style='color:#f00;' data-date='".$year.'-04-01'."' data-id='{$apr_delivery_compliance->id}'><i class='mdi mdi-pencil'></i> Edit</a>";
							} else {
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#add-delivery-compliance' href='#' style='color:#0acf97;' data-date='".$year.'-04-01'."' data-loc='{$location}' data-comp='{$company_id}' data-id='0'><i class='mdi mdi-plus'></i> Add</a>";
							}
						echo "</td>";
						echo "</tr>";
						
						$may_delivery_compliance = CustomerDeliveryCompliance::find_by_month($year."-05-01", $company, $location);
						echo "<tr>";
						echo "<td>2</td>";
						echo "<td> May {$year}</td>";
						echo "<td>";if($may_delivery_compliance){echo $may_delivery_compliance_target = $may_delivery_compliance->target; }else {$may_delivery_compliance_target=0;}echo "</td>";
						echo "<td>";if($may_delivery_compliance){echo $may_delivery_compliance_actual = $may_delivery_compliance->actual;}else {$may_delivery_compliance_actual=0;} echo "</td>";
						echo "<td>";
							if($may_delivery_compliance){
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#edit-delivery-compliance' href='#' style='color:#f00;' data-date='".$year.'-05-01'."' data-id='{$may_delivery_compliance->id}'><i class='mdi mdi-pencil'></i> Edit</a>";
							} else {
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#add-delivery-compliance' href='#' style='color:#0acf97;' data-date='".$year.'-05-01'."' data-loc='{$location}' data-comp='{$company_id}' data-id='0'><i class='mdi mdi-plus'></i> Add</a>";
							}
						echo "</td>";
						echo "</tr>";
					
						$jun_delivery_compliance = CustomerDeliveryCompliance::find_by_month($year."-06-01", $company, $location);
						echo "<tr>";
						echo "<td>3</td>";
						echo "<td> Jun {$year}</td>";
						echo "<td>";if($jun_delivery_compliance){echo $jun_delivery_compliance_target = $jun_delivery_compliance->target; }else {$jun_delivery_compliance_target=0;} echo "</td>";
						echo "<td>";if($jun_delivery_compliance){echo $jun_delivery_compliance_actual = $jun_delivery_compliance->actual;}else {$jun_delivery_compliance_actual=0;} echo "</td>";
						echo "<td>";
							if($jun_delivery_compliance){
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#edit-delivery-compliance' href='#' style='color:#f00;' data-date='".$year.'-06-01'."' data-id='{$jun_delivery_compliance->id}'><i class='mdi mdi-pencil'></i> Edit</a>";
							} else {
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#add-delivery-compliance' href='#' style='color:#0acf97;' data-date='".$year.'-06-01'."' data-loc='{$location}' data-comp='{$company_id}' data-id='0'><i class='mdi mdi-plus'></i> Add</a>";
							}
						echo "</td>";
						echo "</tr>";
					
						$jul_delivery_compliance = CustomerDeliveryCompliance::find_by_month($year."-07-01", $company, $location);
						echo "<tr>";
						echo "<td>4</td>";
						echo "<td> Jul {$year}</td>";
						echo "<td>";if($jul_delivery_compliance){echo $jul_delivery_compliance_target = $jul_delivery_compliance->target; }else {$jul_delivery_compliance_target=0;} echo "</td>";
						echo "<td>";if($jul_delivery_compliance){echo $jul_delivery_compliance_actual = $jul_delivery_compliance->actual;}else {$jul_delivery_compliance_actual=0;}  echo "</td>";
						echo "<td>";
							if($jul_delivery_compliance){
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#edit-delivery-compliance' href='#' style='color:#f00;' data-date='".$year.'-07-01'."' data-id='{$jul_delivery_compliance->id}'><i class='mdi mdi-pencil'></i> Edit</a>";
							} else {
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#add-delivery-compliance' href='#' style='color:#0acf97;' data-date='".$year.'-07-01'."' data-loc='{$location}' data-comp='{$company_id}' data-id='0'><i class='mdi mdi-plus'></i> Add</a>";
							}
						echo "</td>";
						echo "</tr>";
					
						$aug_delivery_compliance = CustomerDeliveryCompliance::find_by_month($year."-08-01", $company, $location);
						echo "<tr>";
						echo "<td>5</td>";
						echo "<td> Aug {$year}</td>";
						echo "<td>";if($aug_delivery_compliance){echo $aug_delivery_compliance_target = $aug_delivery_compliance->target;}else {$aug_delivery_compliance_target=0;} echo "</td>";
						echo "<td>";if($aug_delivery_compliance){echo $aug_delivery_compliance_actual = $aug_delivery_compliance->actual;}else {$aug_delivery_compliance_actual=0;}  echo "</td>";
						echo "<td>";
							if($aug_delivery_compliance){
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#edit-delivery-compliance' href='#' style='color:#f00;' data-date='".$year.'-08-01'."' data-id='{$aug_delivery_compliance->id}'><i class='mdi mdi-pencil'></i> Edit</a>";
							} else {
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#add-delivery-compliance' href='#' style='color:#0acf97;' data-date='".$year.'-08-01'."' data-loc='{$location}' data-comp='{$company_id}' data-id='0'><i class='mdi mdi-plus'></i> Add</a>";
							}
						echo "</td>";
						echo "</tr>";
					
						$sep_delivery_compliance = CustomerDeliveryCompliance::find_by_month($year."-09-01", $company, $location);
						echo "<tr>";
						echo "<td>6</td>";
						echo "<td> Sep {$year}</td>";
						echo "<td>";if($sep_delivery_compliance){echo $sep_delivery_compliance_target = $sep_delivery_compliance->target;}else {$sep_delivery_compliance_target=0;} echo "</td>";
						echo "<td>";if($sep_delivery_compliance){echo $sep_delivery_compliance_actual = $sep_delivery_compliance->actual;}else {$sep_delivery_compliance_actual=0;} echo "</td>";
						echo "<td>";
							if($sep_delivery_compliance){
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#edit-delivery-compliance' href='#' style='color:#f00;' data-date='".$year.'-09-01'."' data-id='{$sep_delivery_compliance->id}'><i class='mdi mdi-pencil'></i> Edit</a>";
							} else {
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#add-delivery-compliance' href='#' style='color:#0acf97;' data-date='".$year.'-09-01'."' data-loc='{$location}' data-comp='{$company_id}' data-id='0'><i class='mdi mdi-plus'></i> Add</a>";
							}
						echo "</td>";
						echo "</tr>";
					
						$oct_delivery_compliance = CustomerDeliveryCompliance::find_by_month($year."-10-01", $company, $location);
						echo "<tr>";
						echo "<td>7</td>";
						echo "<td> Oct {$year}</td>";
						echo "<td>";if($oct_delivery_compliance){echo $oct_delivery_compliance_target = $oct_delivery_compliance->target; }else {$oct_delivery_compliance_target=0;} echo "</td>";
						echo "<td>";if($oct_delivery_compliance){echo $oct_delivery_compliance_actual = $oct_delivery_compliance->actual;}else {$oct_delivery_compliance_actual=0;} echo "</td>";
						echo "<td>";
							if($oct_delivery_compliance){
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#edit-delivery-compliance' href='#' style='color:#f00;' data-date='".$year.'-10-01'."' data-id='{$oct_delivery_compliance->id}'><i class='mdi mdi-pencil'></i> Edit</a>";
							} else {
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#add-delivery-compliance' href='#' style='color:#0acf97;' data-date='".$year.'-10-01'."' data-loc='{$location}' data-comp='{$company_id}' data-id='0'><i class='mdi mdi-plus'></i> Add</a>";
							}
						echo "</td>";
						echo "</tr>";
					
						$nov_delivery_compliance = CustomerDeliveryCompliance::find_by_month($year."-11-01", $company, $location);
						echo "<tr>";
						echo "<td>8</td>";
						echo "<td> Nov {$year}</td>";
						echo "<td>";if($nov_delivery_compliance){echo $nov_delivery_compliance_target = $nov_delivery_compliance->target; }else {$nov_delivery_compliance_target=0;} echo "</td>";
						echo "<td>";if($nov_delivery_compliance){echo $nov_delivery_compliance_actual = $nov_delivery_compliance->actual;}else {$nov_delivery_compliance_actual=0;} echo "</td>";
						echo "<td>";
							if($nov_delivery_compliance){
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#edit-delivery-compliance' href='#' style='color:#f00;' data-date='".$year.'-11-01'."' data-id='{$nov_delivery_compliance->id}'><i class='mdi mdi-pencil'></i> Edit</a>";
							} else {
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#add-delivery-compliance' href='#' style='color:#0acf97;' data-date='".$year.'-11-01'."' data-loc='{$location}' data-comp='{$company_id}' data-id='0'><i class='mdi mdi-plus'></i> Add</a>";
							}
						echo "</td>";
						echo "</tr>";
					
						$dec_delivery_compliance = CustomerDeliveryCompliance::find_by_month($year."-12-01", $company, $location);
						echo "<tr>";
						echo "<td>9</td>";
						echo "<td> Dec {$year}</td>";
						echo "<td>";if($dec_delivery_compliance){echo $dec_delivery_compliance_target = $dec_delivery_compliance->target; }else {$dec_delivery_compliance_target=0;} echo "</td>";
						echo "<td>";if($dec_delivery_compliance){echo $dec_delivery_compliance_actual = $dec_delivery_compliance->actual;}else {$dec_delivery_compliance_actual=0;} echo "</td>";
						echo "<td>";
							if($dec_delivery_compliance){
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#edit-delivery-compliance' href='#' style='color:#f00;' data-date='".$year.'-12-01'."' data-id='{$dec_delivery_compliance->id}'><i class='mdi mdi-pencil'></i> Edit</a>";
							} else {
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#add-delivery-compliance' href='#' style='color:#0acf97;' data-date='".$year.'-12-01'."' data-loc='{$location}' data-comp='{$company_id}' data-id='0'><i class='mdi mdi-plus'></i> Add</a>";
							}
						echo "</td>";
						echo "</tr>";
					
						$jan_delivery_compliance = CustomerDeliveryCompliance::find_by_month(($year+1)."-01-01", $company, $location);
						echo "<tr>";
						echo "<td>10</td>";
						echo "<td> Jan ".($year+1)."</td>";
						echo "<td>";if($jan_delivery_compliance){echo $jan_delivery_compliance_target = $jan_delivery_compliance->target; }else {$jan_delivery_compliance_target=0;} echo "</td>";
						echo "<td>";if($jan_delivery_compliance){echo $jan_delivery_compliance_actual = $jan_delivery_compliance->actual;}else {$jan_delivery_compliance_actual=0;} echo "</td>";
						echo "<td>";
							if($jan_delivery_compliance){
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#edit-delivery-compliance' href='#' style='color:#f00;' data-date='".($year+1).'-01-01'."' data-id='{$jan_delivery_compliance->id}'><i class='mdi mdi-pencil'></i> Edit</a>";
							} else {
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#add-delivery-compliance' href='#' style='color:#0acf97;' data-date='".($year+1).'-01-01'."' data-loc='{$location}' data-comp='{$company_id}' data-id='0'><i class='mdi mdi-plus'></i> Add</a>";
							}
						echo "</td>";
						echo "</tr>";
					
						$feb_delivery_compliance = CustomerDeliveryCompliance::find_by_month(($year+1)."-02-01", $company, $location);
						echo "<tr>";
						echo "<td>11</td>";
						echo "<td> Feb ".($year+1)."</td>";
						echo "<td>";if($feb_delivery_compliance){echo $feb_delivery_compliance_target = $feb_delivery_compliance->target; }else {$feb_delivery_compliance_target=0;} echo "</td>";
						echo "<td>";if($feb_delivery_compliance){echo $feb_delivery_compliance_actual = $feb_delivery_compliance->actual;}else {$feb_delivery_compliance_actual=0;} echo "</td>";
						echo "<td>";
							if($feb_delivery_compliance){
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#edit-delivery-compliance' href='#' style='color:#f00;' data-date='".($year+1).'-02-01'."' data-id='{$feb_delivery_compliance->id}'><i class='mdi mdi-pencil'></i> Edit</a>";
							} else {
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#add-delivery-compliance' href='#' style='color:#0acf97;' data-date='".($year+1).'-02-01'."' data-loc='{$location}' data-comp='{$company_id}' data-id='0'><i class='mdi mdi-plus'></i> Add</a>";
							}
						echo "</td>";
						echo "</tr>";
					
						$mar_delivery_compliance = CustomerDeliveryCompliance::find_by_month(($year+1)."-03-01", $company, $location);
						echo "<tr>";
						echo "<td>12</td>";
						echo "<td> Mar ".($year+1)."</td>";
						echo "<td>";if($mar_delivery_compliance){echo $mar_delivery_compliance_target = $mar_delivery_compliance->target; }else {$mar_delivery_compliance_target=0;} echo "</td>";
						echo "<td>";if($mar_delivery_compliance){echo $mar_delivery_compliance_actual = $mar_delivery_compliance->actual;}else {$mar_delivery_compliance_actual=0;} echo "</td>";
						echo "<td>";
							if($mar_delivery_compliance){
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#edit-delivery-compliance' href='#' style='color:#f00;' data-date='".($year+1).'-03-01'."' data-id='{$mar_delivery_compliance->id}'><i class='mdi mdi-pencil'></i> Edit</a>";
							} else {
								echo "<a class='delivery_compliance' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#add-delivery-compliance' href='#' style='color:#0acf97;' data-date='".($year+1).'-03-01'."' data-loc='{$location}' data-comp='{$company_id}' data-id='0'><i class='mdi mdi-plus'></i> Add</a>";
							}
						echo "</td>";
						echo "</tr>";
						}
					?>	
				</tbody>	

				</table>
			</div>
			<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	
	<div class="col-xl-6">
		<div class="card">
		<div class="card-body">
			<div align="center"><h4 class="header-title">Delivery Compliance</h4></div>
			<div id="delivery-compliance-charts" class="delivery-compliance-charts"></div>
		</div>
		<!-- end card body-->
		</div>
		<!-- end card -->
	</div>
	<!-- end col-->

</div>	


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


	
<div class="modal fade fomall" id="add-delivery-compliance" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
		<!-- end modal-body-->
		</div> <!-- end modal-content-->
	</div> <!-- end modal dialog-->
</div>
<!-- Form pop up -->	
	
<!-- Form pop up -->
<div class="modal fade fomall" id="edit-delivery-compliance" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
		<!-- end modal-body-->
		</div> <!-- end modal-content-->
	</div> <!-- end modal dialog-->
</div>
<!-- Form pop up -->

	
	
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


<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.3/themes/hot-sneaks/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>	
	
<!-- App js -->

<!-- third party:js -->
<script src="assets/js/vendor/apexcharts.min.js"></script>	
<script type="application/javascript">	
	
	$(document).ready(function() {
		
		$('#delivery-compliance').DataTable( {
			dom: 'Bfrtip',
			buttons: [{
	           extend: 'csv',
	            exportOptions: {
	                columns: [0,1,2,3]
	            }	          
	       }],
			lengthMenu: [[12, 25, 50, -1], [12, 25, 50, "All"]]
		} );
		
		$('.buttons-csv span').html('Download Excel');

	});

	$('.delivery_compliance').click(function() {
		var data_id = $(this).attr('data-id');
		var data_date = $(this).attr('data-date');
		var year = "<?php echo $year; ?>";
		//alert(data_id+', '+data_date);

		if(data_id == 0){
			var data_comp = $(this).attr('data-comp');
			var data_loc = $(this).attr('data-loc');
			$("#add-delivery-compliance .modal-content").load("add-delivery-compliance.php?dateYear="+year+"&&date="+data_date+"&&comp="+data_comp+"&&loc="+data_loc);			
		} else {
			$("#edit-delivery-compliance .modal-content").load("edit-delivery-compliance.php?dateYear="+year+"&&date="+data_date+"&&id="+data_id);
		}
		//var data_id = $(this).attr('data-id');
		
		
	});
	

var options = {
    chart: {
        height: 435,
        type: "line",
        toolbar: {
            show: !1
        }
    },
	
    series: [{
        name: "Target",
        type: "column",
        <?php 
			echo "data: [{$apr_delivery_compliance_target}, {$may_delivery_compliance_target}, {$jun_delivery_compliance_target}, {$jul_delivery_compliance_target}, {$aug_delivery_compliance_target}, {$sep_delivery_compliance_target}, {$oct_delivery_compliance_target}, {$nov_delivery_compliance_target}, {$dec_delivery_compliance_target}, {$jan_delivery_compliance_target}, {$feb_delivery_compliance_target}, {$mar_delivery_compliance_target}]";
		?>
    }, {
        name: "Actual",
        type: "line",
		<?php 
			echo "data: [{$apr_delivery_compliance_actual}, {$may_delivery_compliance_actual}, {$jun_delivery_compliance_actual}, {$jul_delivery_compliance_actual}, {$aug_delivery_compliance_actual}, {$sep_delivery_compliance_actual}, {$oct_delivery_compliance_actual}, {$nov_delivery_compliance_actual}, {$dec_delivery_compliance_actual}, {$jan_delivery_compliance_actual}, {$feb_delivery_compliance_actual}, {$mar_delivery_compliance_actual}]";
		?>
    }],
    stroke: {
        width: [0, 4]
    },
    labels: ["01 April <?php echo $year; ?>", "01 May <?php echo $year; ?>", "01 June <?php echo $year; ?>", "01 July <?php echo $year; ?>", "01 Aug <?php echo $year; ?>", "01 Sept <?php echo $year; ?>", "01 Oct <?php echo $year; ?>", "01 Nov <?php echo $year; ?>", "01 Dec <?php echo $year; ?>", "01 Jan <?php echo ($year+1); ?>", "01 Feb <?php echo ($year+1); ?>", "01 Mar <?php echo ($year+1); ?>"],
    xaxis: {
        type: "datetime"
    },
    colors: ["#fa5c7c", "#0fb3f0"],
    yaxis: [{
        title: {
            text: "Target"
        }
    }, {
        opposite: !0,
        title: {
            text: "Actual"
        }
    }],
    grid: {
        row: {
            colors: ["#f1f3fa", "transparent"]
        },
        borderColor: "#f1f3fa"
    }
};
(chart = new ApexCharts(document.querySelector("#delivery-compliance-charts"), options)).render();
	
	
	
//----------------------------------------------------------------------
	
	
	
</script>
<style>
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


