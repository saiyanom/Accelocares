<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("add-site-location.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("add-site-location.php");
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindraaccelo Stie Location</title>
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
   	
   	#my-complaints_filter{ display:none;}

	.dt-buttons {float:right !important; margin: -44px 0 0 0; height: 35px;}
	.dt-buttons button{background: #71bf44 !important; border-color: #71bf44; border-radius: 4px;}
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
		<ul class="form-block-con">
			<li><select id="departmentType" name="department" class="form-control">
					<option value="">- Business Vertical -</option>
					<?php 
						$department = Department::find_all();
						foreach($department as $department){
							echo "<option ";
							if(isset($_GET['department']) && !empty($_GET['department'])){
								if($_GET['department'] == $department->department){ echo "Selected";}
							}
							echo " value='{$department->department}'>{$department->department}</option>";
						}
					?>
			</select></li>
			<li>
				<select id="complaintType" name="site_location" class="form-control">
					<option value="">- Site Location -</option>
					<?php 
						$sql_site_location = "Select * from product order by site_location ASC";
						$site_location = Product::find_by_sql($sql_site_location);
						$site_location_data = "";
						foreach($site_location as $site_location){
							if($site_location_data != $site_location->site_location){
								echo "<option ";
								if(isset($_GET['site_location']) && !empty($_GET['site_location'])){
									if($_GET['site_location'] == $site_location->site_location){ echo "Selected";}
								}
								echo " value='{$site_location->site_location}'>{$site_location->site_location}</option>";
							} $site_location_data = $site_location->site_location;
							
						}
					?>
				</select>
				<span class="err_msg complaint_type_msg"></span>
			</li>
			<li>
				<select id="productType" name="product" class="form-control">
					<option value="">- Product -</option>
					<?php 
						$sql_product = "Select * from product order by product ASC";
						$product = Product::find_by_sql($sql_product);
						$product_data = "";
						foreach($product as $product){
							if($product_data != $product->product){
								echo "<option ";
								if(isset($_GET['product']) && !empty($_GET['product'])){
									if($_GET['product'] == $product->product){ echo "Selected";}
								}
								echo " value='{$product->product}'>{$product->product}</option>";
							} $product_data = $product->product;
							
						}
					?>
				</select>
				<span class="err_msg complaint_type_msg"></span>
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
	
<?php  $message = output_message($message); ?>
<div class="alert fade show text-white <?php 
			if($message == "Site Location Saved Successfully"){echo "bg-success";} 
			else if($message == "Status Updated Successfully."){echo "bg-success";} 		
			else if($message == "Site Location Updated Successfully"){echo "bg-success";} 		
			else {echo "bg-danger";}?>" 
	<?php if(empty($message)){echo "style='display:none;'";}?>>
	<a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
	<?php echo $message; ?>
</div>	

<div class="bord-box">
<div class="card-body">
<div class="al-com">
<div class="compl-lef"><h4>All Site Location , Department  & Product</h4></div>
<div class="compl-rig02">
<ul class="adblock">
<li class="colgr-1 "><a href="#" data-toggle="modal" data-target="#add-new" class="add_product"><i class="mdi mdi-plus-circle-outline"></i> Add New</a></li>
<div class="clerfix"></div>
</ul>
</div>
<div class="clerfix"></div>
</div>

<table id="my-complaints" class="table dt-responsive nowrap basic-datatable" width="100%">
<thead>
<tr>
<th>Sr. No</th>
<th>Department</th>
<th>Site Location</th>
<th>Product</th>
<th>Status</th>
<th>Action</th>
<th>Employee</th>
<th>Escalation</th>
</tr>
</thead>

<tbody>
	
	<?php
		if(isset($_GET['department'])){
			$num = 0;
			
			
			if(!empty($_GET['department'])){
				$department = " department = '{$_GET['department']}' AND ";
				$num++;
			} else { $department = ""; }
			
			
			if(!empty($_GET['site_location'])){
				$site_location = " site_location = '{$_GET['site_location']}' AND ";
				$num++;
			} else { $site_location = ""; }
			
			
			
			if(!empty($_GET['product'])){
				$product = " product = '{$_GET['product']}' AND ";
				$num++;
			} else { $product = ""; }
			
			
			
			
			//echo $num."<hr />";
			if($num > 0){
				$product_sql = "Select * from product where {$department} {$site_location} {$product} date_ != '0000-00-00' order by id ASC";
			} else {
				$product_sql = "Select * from product where  date_ != '0000-00-00' order by id ASC";
			}			
		} else {
			$product_sql = "Select * from product where  date_ != '0000-00-00' order by id ASC";
		}
		
		$product = Product::find_by_sql($product_sql);
		$num = 0;
		foreach($product as $product){
			$num++;
			echo "<tr>";
			echo "<td>".$num."</td>";
			echo "<td>".$product->department."</td>";
			echo "<td>".$product->site_location."</td>";
			echo "<td>".$product->product."</td>";
			echo "<td><a class='strri update_status ";
			if($product->status == 1){echo "col1";} else { echo "col2"; }
			echo "' href='update-product-status.php?id={$product->id}'><i class='mdi mdi-check-circle-outline'></i></a><a class='strri update_status ";
			if($product->status == 0){echo "col3";} else { echo "col2"; }
			echo "' href='update-product-status.php?id={$product->id}'><i class='mdi mdi-close-circle-outline'></i></a></td>";
			echo "<td><a href='#' class='edit_product' data-id='{$product->id}' data-toggle='modal' data-target='#edit-new'>Edit</a></td>";
			echo "<td style='width:100px;'><a href='employee-location.php?id={$product->id}' class='col1 strri'><i class='mdi mdi-plus-circle-outline'></i></a></td>";
			echo "<td style='width:100px;'><a href='complaint-escalation.php?id={$product->id}' class='col1 strri'><i class='mdi mdi-plus-circle-outline'></i></a></td>";
			echo "</tr>";
		}

	?>
<!--
<tr>
<td>01</td>
<td>AUTO</td>
<td>Kanhe</td>
<td>Purlins</td>
<td>
<a class="strri col1" href="#"><i class="mdi mdi-check-circle-outline"></i></a> 
<a class="strri col2" href="#"><i class="mdi mdi-close-circle-outline"></i></a></td>
<td><a href="#">Edit</a></td>
</tr>
-->


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




<!-- Form pop up -->
<div class="modal fade fomall select2onlod" id="add-new">
	<div class="modal-dialog">
		<div class="modal-content">

		<!-- end modal-body-->
		</div> <!-- end modal-content-->
	</div> <!-- end modal dialog-->
</div>
<!-- Form pop up -->
	
	

<!-- Form pop up -->
<div class="modal fade fomall select2onlod" id="edit-new">
	<div class="modal-dialog">
		<div class="modal-content">

		</div> <!-- end modal-content-->
	</div> <!-- end modal dialog-->
</div>
<!-- Form pop up -->


<script src="assets/js/app.min.js"></script>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->
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

<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>	
<!-- third party js ends -->
<script type="application/javascript">
	
	
	
	$(document).ready(function() {
		
		$('#department').select2();
		
		
		$('#my-complaints').DataTable( {
			scrollCollapse: false,
			autoWidth: false,
			responsive: false,
			"scrollX": true,

			columnDefs: [{
				targets: "0",
				orderable: false,
			}],
			"bSort" : true,
			dom: 'Bfrtip',
			buttons: [{
	           extend: 'csv',
	            exportOptions: {
	                columns: [0,1,2,3]
	            }	          
	       }],
			"lengthMenu": [[50, 25, 50, -1], [50, 25, 50, "All"]],
			"language": {
				"info": "_START_-_END_ of _TOTAL_ entries",
				searchPlaceholder: "Search"
			},
		} );
		
		$('.buttons-csv span').html('Download Excel');
	});

	$('.add_product').click(function() {
		//alert("Hello")
		$("#add-new .modal-content").load("add-site-location-form.php");
	});

	$('.edit_product').click(function() {
		var data_id = $(this).attr('data-id');
		//alert(data_id);
		$("#edit-new .modal-content").load("edit-site-location.php?id="+data_id);
	});
	
	$(".update_status").click(function(e) {
		if (confirm('Status Update Confirmation')) {
			return true;
		} else {
			return false;
		}
		e.prevedefault();
	});

	$("#create_site_location").click(function() {

		if ($("#department").val() == "") {
			$("#department").css("border","1px solid #f00");
			$(".department_msg").show(); $(".department_msg").html("Enter Department");
			return false;
		} else {
			$("#department").css("border","1px solid #dee2e6"); $(".department_msg").hide(); $(".department_msg").html("");

			if ($("#department").val() == "new_department") {
				if ($("#department_new input").val() == "") {
					$("#department_new input").css("border","1px solid #f00");
					$(".department_new_msg").show(); $(".department_new_msg").html("Enter New Department");
					return false;
				} else {
					$("#department_new input").css("border","1px solid #dee2e6"); $(".department_new_msg").hide(); $(".department_new_msg").html("");
				}
			}
		}

		if ($("#site_location").val() == "") {
			$("#site_location").css("border","1px solid #f00");
			$(".site_location_msg").show(); $(".site_location_msg").html("Enter Site Location");
			return false;
		} else {
			$("#site_location").css("border","1px solid #dee2e6"); $(".site_location_msg").hide(); $(".site_location_msg").html("");

			if ($("#site_location").val() == "new_site_location") {
				if ($("#site_location_new input").val() == "") {
					$("#site_location_new input").css("border","1px solid #f00");
					$(".site_location_new_msg").show(); $(".site_location_new_msg").html("Enter New Site Location");
					return false;
				} else {
					$("#site_location_new input").css("border","1px solid #dee2e6"); $(".site_location_new_msg").hide(); $(".site_location_new_msg").html("");
				}
			}
		}
		
	});	
	
</script>
<style>
.adblock {
	margin-right: 150px;
}
@media only screen and (max-width: 800px) {
  .btn-group>.btn:first-child {
	    margin-top: 10px !important;
	    float: right !important;
	    font-size: 12px !important;
	    padding: 5px !important;
	}

	.adblock {
		margin-right: 110px;
	}

	.adblock li {
	    display: inline-block;
	    margin: auto 5px;
	    padding: 5px;
	    border-radius: 4px;
	    color: #fff;
	    opacity: 0.6;
	}

	.adblock li a {
	    color: #fff;
	    padding: 0 2px;
	    font-size: 11px;
	}
}
</style>
</body>
</html>