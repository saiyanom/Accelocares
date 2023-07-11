<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindra Accelo CRM</title>
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
#basic-datatable_length{ display:none}
#basic-datatable_filter{ display:none}

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
<form>
<ul class="form-block-con form-block-con-szz">

<li>
<input type="text" id=" " placeholder="Company Name" class="form-control">
</li>

<li>
<input type="text" id=" " placeholder="Select Date Range" class="form-control">
</li>
<li>
 <input type="text" class="form-control date" id="birthdatepicker" data-toggle="date-picker" placeholder="Date" data-single-date-picker="true"></li>

<li>
<select id="inputState" class="form-control">
<option>- Business Vertical -</option>
<option>Option 1</option>
<option>Option 2</option>
<option>Option 3</option>
</select>
</li>

<li>
<select id="inputState" class="form-control">
<option>- Complaint Type -</option>
<option>Option 1</option>
<option>Option 2</option>
<option>Option 3</option>
</select>
</li>


<li>
<div class="form-group mb-0 text-center log-btn">
<button class="btn btn-primary btn-block" type="submit">Search </button>
</div></li>

</ul>
</form>
</div>

</div>
</div>

<div class="bord-box">
<div class="card-body">
<div class="al-com">
<div class="compl-lef"><h4>All Complaints</h4></div>
<div class="compl-rig02">
<ul class="adblock">
<li class="colgr-2"><a href="#">Download to XL</a></li>
<div class="clerfix"></div>
</ul>
</div>
<div class="clerfix"></div>
</div>

<table id="basic-datatable" class="table dt-responsive nowrap basic-datatable" width="100%">
<thead>
<tr>
<td>Sr. No</td>
<td>Employee Name</td>
<td>Plant Name</td>
<td>Date</td>
<td>Subject</td>
<td>Mom</td>
<td>Action</td>
</tr>
</thead>

<tbody>

<tr>
<td>01</td>
<td>Pankaj Mishra</td>
<td>Kanhe</td>
<td>2018/12/10</td>
<td>Lorem Ipsum is simply...</td>
<td>-</td>
<td><a href="#" data-toggle="modal" data-target="#employee-view">View</a></td>
</tr>


<tr>
<td>02</td>
<td>Prateek Phatak</td>
<td>Nashik</td>
<td>2018/12/10</td>
<td>Lorem Ipsum is simply...</td>
<td>-</td>
<td><a href="#" data-toggle="modal" data-target="#employee-view">View</a></td>
</tr>


<tr>
<td>03</td>
<td>Niwas Gandhale</td>
<td>Chakan</td>
<td>2018/12/10</td>
<td>Lorem Ipsum is simply...</td>
<td>Lorem Ipsum is simply dummy...</td>
<td><a href="#" data-toggle="modal" data-target="#employee-view">View</a></td>
</tr>


<tr>
<td>04</td>
<td>Laxman Mahale</td>
<td>Vadodara</td>
<td>2018/12/10</td>
<td>Lorem Ipsum is simply...</td>
<td>Lorem Ipsum is simply dummy...</td>
<td><a href="#" data-toggle="modal" data-target="#employee-view">View</a></td>
</tr>


<tr>
<td>05</td>
<td>Manish Ramteke </td>
<td>Bhopal</td>
<td>2018/12/10</td>
<td>Lorem Ipsum is simply...</td>
<td>Lorem Ipsum is simply dummy...</td>
<td><a href="#" data-toggle="modal" data-target="#employee-view">View</a></td>
</tr>


<tr>
<td>06</td>
<td>Chetan vispute</td>
<td>Kanhe</td>
<td>2018/12/10</td>
<td>Lorem Ipsum is simply...</td>
<td>-</td>
<td><a href="#" data-toggle="modal" data-target="#employee-view">View</a></td>
</tr>


<tr>
<td>07</td>
<td>shrikant Khairnar</td>
<td>Nashik</td>
<td>2018/12/10</td>
<td>Lorem Ipsum is simply...</td>
<td>-</td>
<td><a href="#" data-toggle="modal" data-target="#employee-view">View</a></td>
</tr>


<tr>
<td>08</td>
<td>Sanjay Somkumar</td>
<td>Chakan</td>
<td>2018/12/10</td>
<td>Lorem Ipsum is simply...</td>
<td>Lorem Ipsum is simply dummy...</td>
<td><a href="#" data-toggle="modal" data-target="#employee-view">View</a></td>
</tr>

<tr>
<td>09</td>
<td>Pankaj Mishra</td>
<td>Vadodara</td>
<td>2018/12/10</td>
<td>Lorem Ipsum is simply...</td>
<td>Lorem Ipsum is simply dummy...</td>
<td><a href="#" data-toggle="modal" data-target="#employee-view">View</a></td>
</tr>

<tr>
<td>10</td>
<td>Vaibhav chavan</td>
<td>Bhopal</td>
<td>2018/12/10</td>
<td>Lorem Ipsum is simply...</td>
<td>Lorem Ipsum is simply dummy...</td>
<td><a href="#" data-toggle="modal" data-target="#employee-view">View</a></td>
</tr>


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
<div class="modal fade fomall" id="employee-view" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header border-bottom-st d-block">
<!--<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<div class="form-p-block">

<ul class="ad-lr02">

<!-- box 1 -->
<li class="adl1">Employee Name		<span>:</span>	</li>
<li class="adr1">Yogesh Shirsat</li>
<!-- box 1 -->

<!-- box 1 -->
<li class="adl1">Plant Name			<span>:</span></li>
<li class="adr1">Nashik</li>
<!-- box 1 -->

<!-- box 1 -->
<li class="adl1">Date					<span>:</span>	</li>
<li class="adr1">12-12-2018</li>
<!-- box 1 -->

<!-- box 1 -->
<li class="adl1">Subject				<span>:</span></li>
<li class="adr1">Lorem Ipsum is simply dummy text of the</li>
<!-- box 1 -->

<!-- box 1 -->
<li class="adl1">MOM			<span>:</span></li>
<li class="adr1">printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</li>
<!-- box 1 -->

<div class="clerfix"></div>
</ul>


<div class="form-p-box form-p-boxbtn">
<a class="fpcl" data-dismiss="modal" aria-hidden="true" href="#">Close</a>
</div>

<div class="clerfix"></div>
</div>
</div>



<!-- end modal-body-->
</div> <!-- end modal-content-->
</div> <!-- end modal dialog-->
</div>
<!-- Form pop up -->



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
<!-- third party js ends -->
        <!-- demo app -->
        <script src="assets/js/pages/demo.datatable-init.js"></script>
        <!-- end demo js-->


</body>
</html>


