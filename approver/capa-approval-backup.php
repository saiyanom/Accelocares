<?php
	ob_start();
	require_once("../includes/initialize.php"); 

	$employee_reg = EmployeeReg::find_by_id($session->employee_id);
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	if ($session->is_employee_logged_in()){ 

		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_role = 'Approver'";

		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);

		if(!$employee_location){
			redirect_to("logout.php"); 
		}
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
<select id="inputState" class="form-control">
<option>Source</option>
<option>Option 1</option>
<option>Option 2</option>
<option>Option 3</option>
</select>
</li>


<li>
<select id="inputState" class="form-control">
<option>Aging</option>
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
<!-- <div class="compl-rig"><a href="#">Download to XL</a></div>-->
<div class="clerfix"></div>
</div>

<table id="basic-datatable" class="table dt-responsive nowrap basic-datatable" width="100%">
<thead>
<tr>
<td>Complaint No</td>
<td>Company Name</td>
<td>Complaint Type</td>
<td>Date</td>
<td>Busi. Ver.</td>
<td>Source</td>
<td>Status</td>
<td>Action</td>
<td>Aging</td>
</tr>
</thead>

<tbody>

<tr>
<td>00001</td>
<td>Alf Engineering LTD.</td>
<td>Width Variat...</td>
<td>2018/12/10</td>
<td>CRGO</td>
<td>Plant</td>
<td><span class="closed-td">Pending</span></td>
<td><a  data-toggle="modal" data-target="#create-note" href="#">View</a></td>
<td>05</td>
</tr>

<tr>
<td>00002</td>
<td>Alf Engineering LTD.</td>
<td>Thickness Var...</td>
<td>2018/12/10</td>
<td>CRGO</td>
<td>Mill</td>
<td><span class="open-td">Approve</span></td>
<td><a  data-toggle="modal" data-target="#create-note" href="#">View</a></td>
<td>11</td>
</tr>

<tr>
<td>00003</td>
<td>Alf Engineering LTD.</td>
<td>Dent and scr...</td>
<td>2018/12/10</td>
<td>Auto</td>
<td>Plant</td>
<td><span class="open-td">Approve</span></td>
<td><a  data-toggle="modal" data-target="#create-note" href="#">View</a></td>
<td>10</td>
</tr>

<tr>
<td>00004</td>
<td>Alf Engineering LTD.</td>
<td>Rotor flaring...</td>
<td>2018/12/10</td>
<td>CRGO</td>
<td>Plant</td>
<td><span class="open-td">Approve</span></td>
<td><a  data-toggle="modal" data-target="#create-note" href="#">View</a></td>
<td>01</td>
</tr>

<tr>
<td>00005</td>
<td>Alf Engineering LTD.</td>
<td>Miss feed lami...</td>
<td>2018/12/10</td>
<td>Auto</td>
<td>Plant</td>
<td><span class="open-td">Approve</span></td>
<td><a  data-toggle="modal" data-target="#create-note" href="#">View</a></td>
<td>06</td>
</tr>

<tr>
<td>00006</td>
<td>Alf Engineering LTD.</td>
<td>Core slot misp...</td>
<td>2018/12/10</td>
<td>CRGO</td>
<td>Mill</td>
<td><span class="open-td">Approve</span></td>
<td><a  data-toggle="modal" data-target="#create-note" href="#">View</a></td>
<td>03</td>
</tr>

<tr>
<td>00007</td>
<td>Alf Engineering LTD.</td>
<td>Commercial is...</td>
<td>2018/12/10</td>
<td>CRGO</td>
<td>Mill</td>
<td><span class="open-td">Approve</span></td>
<td><a  data-toggle="modal" data-target="#create-note" href="#">View</a></td>
<td>08</td>
</tr>

<tr>
<td>00008</td>
<td>Alf Engineering LTD.</td>
<td>Cracking</td>
<td>2018/12/10</td>
<td>Auto</td>
<td>Plant</td>
<td><span class="open-td">Approve</span></td>
<td><a  data-toggle="modal" data-target="#create-note" href="#">View</a></td>
<td>02</td>
</tr>

<tr>
<td>00009</td>
<td>Alf Engineering LTD.</td>
<td>Core slot misp...</td>
<td>2018/12/10</td>
<td>CRGO</td>
<td>Plant</td>
<td><span class="open-td">Approve</span></td>
<td><a  data-toggle="modal" data-target="#create-note" href="#">View</a></td>
<td>03</td>
</tr>

<tr>
<td>00010</td>
<td>Alf Engineering LTD.</td>
<td>Rotor flaring...</td>
<td>2018/12/10</td>
<td>CRGO</td>
<td>Plant</td>
<td><span class="open-td">Approve</span></td>
<td><a  data-toggle="modal" data-target="#create-note" href="#">View</a></td>
<td>01</td>
</tr>




<tr>
<td>00011</td>
<td>Alf Engineering LTD.</td>
<td>Width Variat...</td>
<td>2018/12/10</td>
<td>CRGO</td>
<td>Plant</td>
<td><span class="closed-td">Pending</span></td>
<td><a  data-toggle="modal" data-target="#create-note" href="#">View</a></td>
<td>05</td>
</tr>

<tr>
<td>00012</td>
<td>Alf Engineering LTD.</td>
<td>Thickness Var...</td>
<td>2018/12/10</td>
<td>CRGO</td>
<td>Mill</td>
<td><span class="open-td">Approve</span></td>
<td><a  data-toggle="modal" data-target="#create-note" href="#">View</a></td>
<td>11</td>
</tr>

<tr>
<td>00013</td>
<td>Alf Engineering LTD.</td>
<td>Dent and scr...</td>
<td>2018/12/10</td>
<td>Auto</td>
<td>Plant</td>
<td><span class="open-td">Approve</span></td>
<td><a  data-toggle="modal" data-target="#create-note" href="#">View</a></td>
<td>10</td>
</tr>

<tr>
<td>00014</td>
<td>Alf Engineering LTD.</td>
<td>Rotor flaring...</td>
<td>2018/12/10</td>
<td>CRGO</td>
<td>Plant</td>
<td><span class="open-td">Approve</span></td>
<td><a  data-toggle="modal" data-target="#create-note" href="#">View</a></td>
<td>01</td>
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

<!-- Form pop up -->
<div class="modal fade form-pop" id="create-note" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header border-bottom-st d-block">
<!--<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<div class="form-p-hd">
<h2>MAHINDRA STEEL SERVICE CENTRE LTD. (PLANT I)<br>
Corrective And Preventive Action Report</h2>
</div>


<div class="form-p-block">

<!-- box 1 -->
<div class="form-p-box form-p-box-bg2">

<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
<div class="clerfix"></div>

<div class="sectp-fom sectp-fom02">
<h2 class="sectphd">Management Representative</h2>

<ul class="fpall-z">
<li class="fp-con1-z"><p class="padd10">Document No.</p></li> <li class="fp-con2-z"><p class="form-p-box-bg1 com-done">QF/SC/09 B	</p></li>
</ul>

<ul class="fpall-z">
<li class="fp-con1-z"><p class="padd10">Rev. No.</p></li> <li class="fp-con2-z"><p class="form-p-box-bg1 com-done">2</p></li>
</ul>

<ul class="fpall-z">
<li class="fp-con1-z"><p class="padd10">Page No.</p></li> <li class="fp-con2-z"><p class="form-p-box-bg1 com-done">01 of 01	</p></li>
</ul>
<div class="clerfix"></div>
</div>


<div class="clerfix"></div>
</div>
<!-- box 1 -->

<!-- box 2 -->
<div class="form-p-box form-p-box-bg1 border-bottom-st">
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
<div class="clerfix"></div>


<div class="rst-left">
<ul class="fpall">
<li class="fp-con1"><p>Customer Name</p></li>             <li class="fp-con2"><p class="form-p-box-bg2 com-done">LTL Transformers Pvt Ltd</p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con1"><p>Model</p></li>             <li class="fp-con2"><p class="form-p-box-bg2 com-done">110mm 23ZDKH85 - 0.23 x C & 150 MM - 23ZDKH85 - 0.23 x C</p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con1"><p>Date of issue</p></li>             <li class="fp-con2"><p class="form-p-box-bg2 com-done">High Burr issue</p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con1"><p>Team Members</p></li>             <li class="fp-con2"><p class="form-p-box-bg2 com-done"> Vaibhav Chavan, Adhivesh H., Rahul N,Pankaj Mishra</p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con1"><p>Reviewed By</p></li>             <li class="fp-con2"><p class="form-p-box-bg2 com-done">Laxman Mahale (Plant Chief)</p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con1"><p>Contact Person Name</p></li>             <li class="fp-con2"><p class="form-p-box-bg2 com-done">Jayalathdi Muthu </p></li>
<div class="clerfix"></div></ul>

</div>

<div class="rst-right">
<ul class="fpall">
<li class="fp-con1"><p>CAPA No.</p></li>             <li class="fp-con2"><p class="form-p-box-bg2 com-done">1</p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con1"><p>Reported By</p></li>             <li class="fp-con2"><p class="form-p-box-bg2 com-done">Jayalathdi Muthu</p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con1"><p>Problem Description</p></li>             <li class="fp-con2"><p class="form-p-box-bg2 com-done">High Burr issue </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con1"><p>Feedback Date</p></li>             <li class="fp-con2"><p class="form-p-box-bg2 com-done">Thursday, September 20, 2018 </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con1"><p>Reviewed Date</p></li>             <li class="fp-con2"><p class="form-p-box-bg2 com-done">22.09.2018</p></li>
<div class="clerfix"></div></ul>

</div>

<div class="clerfix"></div>
</div>
<!-- box 2 -->

<!-- box 3 -->
<div class="form-p-box form-p-box-bg2 border-bottom-st">

<div class="sectp-fom">
<h2 class="sectphd">1. Problem Description</h2>
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
<div class="clerfix"></div>

<ul class="ulsp1">
<li class="ulsp1-l"><p>Where</p></li>
<li class="ulsp1-r"><p class="form-p-box-bg1 com-done">During core building and testing.</p></li>
<div class="clerfix"></div>
</ul>

<ul class="ulsp1">
<li class="ulsp1-l"><p>When</p></li>
<li class="ulsp1-r"><p class="form-p-box-bg1 com-done">20/09/2018</p></li>
<div class="clerfix"></div>
</ul>

<ul class="ulsp1">
<li class="ulsp1-l"><p>What Qty </p></li>
<li class="ulsp1-r"><p class="form-p-box-bg1 com-done">19.3 MT</p></li>
<div class="clerfix"></div>
</ul>

<ul class="ulsp1">
<li class="ulsp1-l"><p>Which Model</p></li>
<li class="ulsp1-r"><p class="form-p-box-bg1 com-done">110mm 23ZDKH85 - 0.23 x C & 150 MM - 23ZDKH85 - 0.23 x C</p></li>
<div class="clerfix"></div>
</ul>

<ul class="ulsp1">
<li class="ulsp1-l"><p>Who Produced</p></li>
<li class="ulsp1-r"><p class="form-p-box-bg1 com-done">CKK Line</p></li>
<div class="clerfix"></div>
</ul>

<div class="clerfix"></div>
</div>


<div class="clerfix"></div>
</div>
<!-- box 3 -->

<!-- box 4-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
<div class="clerfix"></div>
<div class="sectp-fom">
<h2 class="sectphd">2. Findings / Investigation</h2>
<p class="form-p-box-bg1 com-done">Burr was found more than specification on the slit edge of the Coil against PO. No.:1000906 having width 110mm & 150mm, grade-23ZDKH85.	</p>
<div class="clerfix"></div>
</div>
<div class="clerfix"></div>
</div>
<!-- box 4 -->

<!-- box 5-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
<div class="clerfix"></div>
<div class="sectp-fom">
<h2 class="sectphd">3. Structured & systematic analysis of probable causes</h2>
<p class="form-p-box-bg1 com-done">i) Burr may be generated while slitting at slit edges at CKK Line because of blunt cutter or <br>
ii) Improper gap setting of the sliting cutter  may also lead to generation of burr .<br>
iii) The defective packing material at inline unit may also lead to burr generation. </p>
<div class="clerfix"></div>
</div>
<div class="clerfix"></div>
</div>
<!-- box 5 -->

<!-- box 6-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
<div class="clerfix"></div>
<div class="sectp-fom">
<h2 class="sectphd">4. Root cause identified</h2>
<p class="form-p-box-bg1 com-done">The burr was generated because of defective packing material at inline unit.	</p>
<div class="clerfix"></div>
</div>
<div class="clerfix"></div>
</div>
<!-- box 6 -->

<!-- box 7-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
<div class="clerfix"></div>
<div class="sectp-fom">
<h2 class="sectphd">5. Correction</h2>
<p class="form-p-box-bg1 com-done">The material not avialable for correction. However other WIP coil checked and found OK.	</p>
<p class="form-p-box-bg1 com-done"><strong>Who:</strong> Vaibhav Chavan, Pankaj Mishra </p>
<p class="form-p-box-bg1 com-done"><strong>When:</strong> 21.09.2018</p>

<div class="clerfix"></div>
</div>
<div class="clerfix"></div>
</div>
<!-- box 7 -->

<!-- box 8-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
<div class="clerfix"></div>
<div class="sectp-fom">
<h2 class="sectphd">6. Corrective Action</h2>
<p class="form-p-box-bg1 com-done">i) The packing material at inline unit changed.<br>
ii) Bakellite has been introduced in place of cardboard as packing material .<br>
iii) Enough stock (15 nos.) of bakellite has been ensured at CKK line to avoid any usage of alternate material as packing material in shortage .</p>
<p class="form-p-box-bg1 com-done"><strong>Who:</strong> Production Engineer & Line Operator</p>
<p class="form-p-box-bg1 com-done"><strong>When: </strong> 21.09.2018</p>
<div class="clerfix"></div>
</div>
<div class="clerfix"></div>
</div>
<!-- box 8 -->

<!-- box 9-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
<div class="clerfix"></div>
<div class="sectp-fom">
<h2 class="sectphd">7. Verification of Effectiveness:</h2>
<p class="form-p-box-bg1 com-done">During slitting the coil the coils has been checked thrice on sample basis and  burr found within tolerance (15Micron). Also customer has been asked for their feedback in future supply.</p>
<p class="form-p-box-bg1 com-done"><strong>Who:</strong> MSSCL</p>
<p class="form-p-box-bg1 com-done"><strong>When: </strong> From all next processing & supplies.</p>

<div class="clerfix"></div>
</div>
<div class="clerfix"></div>
</div>
<!-- box 9 -->

<!-- box 9-->
<div class="form-p-box form-p-box-bg2">
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
<div class="clerfix"></div>
<div class="sectp-fom">
<h2 class="sectphd">8. Preventive action (Horizontal deployment)if applicable</h2>
<p class="form-p-box-bg1 com-done">At all Sliting line within MIL</p>
<p class="form-p-box-bg1 com-done"><strong>Who:</strong> Production Engineer & Line Operator</p>
<p class="form-p-box-bg1 com-done"><strong>When: </strong> 22.09.2018</p>

<div class="clerfix"></div>
</div>
<div class="clerfix"></div>
</div>
<!-- box 9 -->




 <div class="form-p-box form-p-boxbtn">
<a class="fpcl" data-dismiss="modal" aria-hidden="true" href="#">Cancel</a>
<a class="fpdone" href="my-complaints-10-b.php">Save</a>
</div>


<div class="clerfix"></div>
</div>


</div>



<!-- end modal-body-->
</div> <!-- end modal-content-->
</div> <!-- end modal dialog-->
</div>
<!-- Form pop up -->



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


</body>
</html>


