<?php
	require_once("../includes/initialize.php"); 
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindraaccelo</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content=" " name="description" />
<meta content="Coderthemes" name="author" />

<style>
.fc-right{ display:none}
.fc-center{ float:right}
.fc-today-button{ display:none}
</style>

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

<div class="cmp-lf"><h2>Complaint details - Alf Engineering Ltd.   |   Complaint No. 00001</h2></div>
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
<div class="clerfix"></div>
<div class="tabobox">
<div class="tabobox1">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="fsd-1">Product</td>
<td class="fsd-2"><span>Marvel</span></td>
</tr>
<tr>
<td class="fsd-1">Rejected Quantity</td>
<td class="fsd-2"><span>50000</span></td>
</tr>
<tr>
<td class="fsd-1">Invoice Number</td>
<td class="fsd-2"><span>00001</span></td>
</tr>
<tr>
<td class="fsd-1">Invoice Date</td>
<td class="fsd-2"><span>12-12-2018</span></td>
</tr>


<tr>
<td class="fsd-1">Defect Batch No.</td>
<td class="fsd-2"><span>993030200445</span></td>
</tr>
<tr>
<td class="fsd-1">Customer Id</td>
<td class="fsd-2"><span>80555</span></td>
</tr>
<tr>
<td class="fsd-1">Business Vertical</td>
<td class="fsd-2"><span>CRGO</span></td>
</tr>
</table>
</div>
<div class="tabobox2">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="fsd-1">Location</td>
<td class="fsd-2"><span>Nashik</span></td>
</tr>
<tr>
<td class="fsd-1">Complaint Type</td>
<td class="fsd-2"><span>Cracking</span></td>
</tr>
<tr>
<td class="fsd-1">Sub Complaint Type</td>
<td class="fsd-2"><span>Bend</span></td>
</tr>
<tr>
<td class="fsd-1">Contact Person Name</td>
<td class="fsd-2"><span>Nilesh Singh</span></td>
</tr>
<tr>
<td class="fsd-1">Email ID</td>
<td class="fsd-2"><span>nilesh.singh@alfengineering.com</span></td>
</tr>
<tr>
<td class="fsd-1">Mobile No..	</td>
<td class="fsd-2"><span>9870380716</span></td>
</tr>
</table>
</div>
<div class="clerfix"></div>
<div class="tabobox1">
<div class="bottab">
<p class="colost1"><span>Images</span></p>
<ul class="lip-popbox">
<li><a class="fancybox-thumbs" data-fancybox-group="thumb-top" href="assets/images/images/box1.jpg"><img src="assets/images/images/box1.jpg"></a></li>
<li><a class="fancybox-thumbs" data-fancybox-group="thumb-top" href="assets/images/images/box1.jpg"><img src="assets/images/images/box1.jpg"></a></li>
<li><a class="fancybox-thumbs" data-fancybox-group="thumb-top" href="assets/images/images/box1.jpg"><img src="assets/images/images/box1.jpg"></a></li>
<li><a class="fancybox-thumbs" data-fancybox-group="thumb-top" href="assets/images/images/box1.jpg"><img src="assets/images/images/box1.jpg"></a></li>
<div class="clerfix"></div>
</ul>
</div>
</div>

<div class="tabobox2">
<div class="bottab">
<p class="colost1"><span>Feedback</span></p>
<p class="colost2">Lorem Ipsum is simply dummy text of the printing and typesetting industry.<br>
Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
</div></div>
<div class="clerfix"></div>
</div></div>
</div>
<!-- top box -->


<div class="complaints-blocks2" >
<div class="cb-block">

<div class="onlock">
<div class="onlock-1"><p>Identify the Source</p></div>
<div class="onlock-2"><p class="colost2">Plant</p></div>
<div class="clerfix"></div>
<div class="onlock-1"><p>Customer Contacted</p></div>
<div class="onlock-2"><p class="colost2">Yes</p></div>
<div class="clerfix"></div>
<div class="onlock-1"><p>Remark</p></div>
<div class="onlock-2"><p class="colost2">Of type and scrambled it to make a type pecimen book.</p></div>
<div class="clerfix"></div>
</div>
<div class="paddi10"></div>

<div class="onlock" style="border-bottom:0">
<div class="onlock-1"><p>Request a Visit</p></div>
<div class="onlock-2"><a class="onlock-link " href="#">Yes</a>   <a href="#" class="onlock-link ">No</a><br>
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
    <div class="modal-body pt-3 pr-4 pl-4">                                            </div>
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


<div class="onlock"  style="border-bottom:0">
<div class="onlock-1"><p>&nbsp;</p></div>
<div class="onlock-2  log-btn"><a class="btn btn-primary2" href="my-complaints-05.php">Submit</a></div>
<div class="clerfix"></div>
</div>


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


