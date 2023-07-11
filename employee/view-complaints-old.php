<?php
	require_once("../includes/initialize.php"); 
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$complaint_reg = Complaint::find_by_id($_GET['id']);
	} else {
		$session->message("Complaint Not Found");
		redirect_to("my-complaints.php");
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindraaccelo</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content=" " name="description" />
<meta content="Coderthemes" name="author" />
</head>
<!-- sidebar-enable -->
<body class="enlarged" data-keep-enlarged="true">

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
<div class="">

<!-- top box -->
<div class="complaints-blocks">
<div class="cb-block">

<div class="cmp-lf"><h2>Complaint details - <?php echo $complaint_reg->company_name; ?>   |   Complaint No. <?php echo $complaint_reg->ticket_no; ?></h2></div>
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
<div class="clerfix"></div>
<div class="tabobox">
<div class="tabobox1">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="fsd-1">Product</td>
<td class="fsd-2"><span><?php echo $complaint_reg->product; ?></span></td>
</tr>
<tr>
<td class="fsd-1">Rejected Quantity</td>
<td class="fsd-2"><span><?php echo $complaint_reg->rejected_quantity; ?></span></td>
</tr>
<tr>
<td class="fsd-1">Invoice Number</td>
<td class="fsd-2"><span><?php echo $complaint_reg->ticket_no; ?></span></td>
</tr>
<tr>
<td class="fsd-1">Invoice Date</td>
<td class="fsd-2"><span><?php echo $complaint_reg->invoice_date; ?></span></td>
</tr>


<tr>
<td class="fsd-1">Defect Batch No.</td>
<td class="fsd-2"><span><?php echo $complaint_reg->defect_batch_no; ?></span></td>
</tr>
<tr>
<td class="fsd-1">Customer Id</td>
<td class="fsd-2"><span><?php echo $complaint_reg->customer_id; ?></span></td>
</tr>
<tr>
<td class="fsd-1">Business Vertical</td>
<td class="fsd-2"><span><?php echo $complaint_reg->business_vertical; ?></span></td>
</tr>
</table>
</div>
<div class="tabobox2">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="fsd-1">Location</td>
<td class="fsd-2"><span><?php echo $complaint_reg->plant_location; ?></span></td>
</tr>
<tr>
<td class="fsd-1">Complaint Type</td>
<td class="fsd-2"><span><?php echo $complaint_reg->complaint_type; ?></span></td>
</tr>
<tr>
<td class="fsd-1">Sub Complaint Type</td>
<td class="fsd-2"><span><?php echo $complaint_reg->sub_complaint_type; ?></span></td>
</tr>
<tr>
<td class="fsd-1">Complaint Raised by</td>
<td class="fsd-2"><span><?php echo $complaint_reg->pl_name; ?></span></td>
</tr>
<tr>
<td class="fsd-1">Email ID</td>
<td class="fsd-2"><span><?php echo $complaint_reg->pl_email; ?></span></td>
</tr>
<tr>
<td class="fsd-1">Mobile No. </td>
<td class="fsd-2"><span><?php echo $complaint_reg->pl_mobile; ?></span></td>
</tr>
</table>
</div>
<div class="clerfix"></div>
<div class="tabobox1">
<div class="bottab">
<p class="colost1"><span>Images</span></p>
<ul class="lip-popbox">
<?php 
	if(!empty($complaint_reg->product_img_1)){
		echo "<li><a class='fancybox-thumbs' data-fancybox-group='thumb-top' href='../document/{$complaint_reg->ticket_no}/complaint/{$complaint_reg->product_img_1}'><img src='../document/{$complaint_reg->ticket_no}/complaint/{$complaint_reg->product_img_1}'></a></li>";
	}
	if(!empty($complaint_reg->product_img_2)){
		echo "<li><a class='fancybox-thumbs' data-fancybox-group='thumb-top' href='../document/{$complaint_reg->ticket_no}/complaint/{$complaint_reg->product_img_2}'><img src='../document/{$complaint_reg->ticket_no}/complaint/{$complaint_reg->product_img_2}'></a></li>";
	}
	if(!empty($complaint_reg->product_img_3)){
		echo "<li><a class='fancybox-thumbs' data-fancybox-group='thumb-top' href='../document/{$complaint_reg->ticket_no}/complaint/{$complaint_reg->product_img_3}'><img src='../document/{$complaint_reg->ticket_no}/complaint/{$complaint_reg->product_img_3}'></a></li>";
	}
?>
<div class="clerfix"></div>
</ul>
</div>
</div>

<div class="tabobox2">
<div class="bottab">
<p class="colost1"><span>Feedback</span></p>
<p class="colost2"><?php echo $complaint_reg->pl_feedback; ?></p>
</div></div>
<div class="clerfix"></div>
</div></div>
</div>
<!-- top box -->



<div class="complaints-blocks">
<form action="<?php echo "raised-complaint-db.php?id=".$_GET['id']; ?>" method="post" enctype="multipart/form-data">
<div class="paddi15"></div>

<div class="idf-sort">
<div class="idf-sort-lft"><p>Identify the Source</p></div>
	<div class="idf-sort-rig onlock-2-acbtn id_source">
		<input type="button" class="btn btn-primary id_source_plant" value="Plant" />   
		<input type="button" class="btn btn-light id_source_mil" value="Mill" />
		<input type="hidden" class="id_source_val" name="id_source" value="Plant" />
	</div>
<div class="clerfix"></div>
</div>

<div class="idf-sort select_mill" style="display: none;">
	<div class="idf-sort-lft"><p>Select Mill</p></div>
	<div class="idf-sort-rig">
		<select id="select_mill" name="select_mill" class="form-control form-controlws">
		<option value="">- Select Mill -</option>
		<?php
			$mill_reg = MillReg::find_all();
			foreach($mill_reg as $mill_reg){
				echo "<option>{$mill_reg->mill_name}</option>";
			}
		?>
		</select>
	</div>
	<div class="clerfix"></div>
</div>
	
<div class="idf-sort">
<div class="idf-sort-lft"><p>Customer Contacted</p></div>
	<div class="idf-sort-rig onlock-2-acbtn client_contacted">
		<input type="button" class="btn btn-primary client_contacted_yes" value="Yes" />   
		<input type="button" class="btn btn-light client_contacted_no" value="No" />
		<input type="hidden" class="client_contacted_val" name="client_contacted" value="Yes" />
	</div>
<div class="clerfix"></div>
</div>


<div class="idf-sort">
<div class="idf-sort-lft"><p>&nbsp;</p></div>
<div class="idf-sort-rig"><textarea class="form-control" id="example-textarea" placeholder="Add Remark" rows="5" name="add_remark"></textarea></div>
<div class="clerfix"></div>
</div>

<div class="idf-sort">
<div class="idf-sort-lft"><p>&nbsp;</p></div>
<div class="idf-sort-rig log-btn"><input type="submit" name="identify_the_source" class="btn btn-primary2" /></div>
<div class="clerfix"></div>
</div>
</form>

</div>

<div class="complaints-blocks2" >
<div class="cb-block">

<div class="paddi10"></div>

<div class="onlock" style="border-bottom:0">
<div class="onlock-1"><p>Request a Visit</p></div>
<div class="onlock-2">
	<div class="request_visit">
		<input type="button" class="btn btn-primary request_visit_yes" value="Yes" />   
		<input type="button" class="btn btn-light request_visit_no" value="No" />
		<input type="hidden" class="request_visit_val" name="request_visit" value="Yes" />
	</div>
<div class="cldblock">
	<div id="calendar"></div>
</div>
<!-- Add New Event MODAL -->
<div class="modal fade" id="event-modal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header pr-4 pl-4 border-bottom-0 d-block">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
				<h4 class="modal-title">Add new visit request</h4>
			</div>
			<div class="modal-body pt-3 pr-4 pl-4">
				
			</div>
			<div class="text-right pb-4 pr-4 evet-btn-min">
				<button type="button" class="btn evet-btn evet-btn-col1" data-dismiss="modal">Close</button>
				<button type="button" class="btn save-event  evet-btn evet-btn-col2">Submit</button>
				<button type="button" class="btn btn-danger delete-event  " data-dismiss="modal">Delete</button>
			</div>
		</div> <!-- end modal-content-->
	</div> <!-- end modal dialog-->
</div>
<!-- end modal-->
<div class="clerfix"></div>
</div>



<div class="clerfix"></div>
</div>


<div class="idf-sort">
<div class="idf-sort-lft"><p>&nbsp;</p></div>
<div class="idf-sort-rig log-btn"><input type="submit" name="request_a_visit" class="btn btn-primary2"/></div>
<div class="clerfix"></div>
</div>


</div>


</div><!-- end row-->
</div>
	
	
</div><!-- end row-->
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
	<link href="assets/css/vendor/fullcalendar.min.css" rel="stylesheet" type="text/css" />      <!-- third party js -->
	<script src="assets/js/vendor/jquery-ui.min.js"></script>
	<script src="assets/js/vendor/fullcalendar.min.js"></script>
	<!-- third party js ends -->

	<!-- demo app -->
	<script src="assets/js/pages/demo.calendar.js"></script>
	<!-- end demo js-->
<!-- fancyBox Js includ -->
<?php include 'fancyboxjs.php'?>
<!-- fancyBox Js includ -->

	

</body>
</html>


