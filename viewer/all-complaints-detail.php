<?php
	ob_start();
	require_once("../includes/initialize.php"); 

	$employee_reg = EmployeeReg::find_by_id($session->employee_id);
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	if ($session->is_employee_logged_in()){ 
		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role = 'Viewer' Limit 1";
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
<!-- 1 -->
<div class="onlock">
<div class="onlock-1"><p class="colost1">Identify the Source</p></div>
<div class="onlock-2"><p class="colost2">Mill</p></div>
<div class="clerfix"></div>
<div class="onlock-1"><p class="colost1">Select Mill</p></div>
<div class="onlock-2"><p class="colost2">Tata Steel</p></div>
<div class="clerfix"></div>
<div class="onlock-1"><p class="colost1">Customer Contacted</p></div>
<div class="onlock-2"><p class="colost2">Yes</p></div>
<div class="clerfix"></div>
<div class="onlock-1"><p class="colost1">Remark</p></div>
<div class="onlock-2"><p class="colost2">Of type and scrambled it to make a type pecimen book.</p></div>
<div class="clerfix"></div>
</div>
<!-- 1 -->

<!-- 2 -->
<div class="onlock">
<div class="onlock-cov">
<div class="onlock-3"><p class="colost1">Request a Visit</p></div>
<div class="onlock-3"><p class="colost2">Yes</p></div>
<div class="clerfix"></div>
<div class="onlock-3"><p class="colost1">Date</p></div>
<div class="onlock-3"><p class="colost2">12-12-2018</p></div>
<div class="clerfix"></div>
<div class="onlock-3"><p class="colost1">Place</p></div>
<div class="onlock-3"><p class="colost2">Pune</p></div>
</div>

<div class="onlock-cov">
<div class="onlock-3"><p class="colost1">Customer Coordinator</p></div>
<div class="onlock-3"><p class="colost2">Rathish Narayanan</p></div>
<div class="clerfix"></div>
<div class="onlock-3"><p class="colost1">Email ID</p></div>
<div class="onlock-3"><p class="colost2">rathish@gmail.com</p></div>
<div class="clerfix"></div>
<div class="onlock-3"><p class="colost1">Mobile Number</p></div>
<div class="onlock-3"><p class="colost2">9870380716</p></div>
</div>

<div class="clerfix"></div>
</div>
<!-- 2 -->

<!-- 3 -->
<div class="onlock">
<div class="onlock-cov">
<div class="onlock-3"><p class="colost1">Visit Done</p></div>
<div class="onlock-3"><p class="colost2">Yes</p>


<div class="lrbox">
<div class="lrbox1"><p class="colost2">MOM Document</p></div>
<div class="lrbox2"><a class="fancybox-thumbs" data-fancybox-group="thumb" href="assets/images/bg-auth.jpg">Open link</a></div>
<div class="clerfix"></div>
</div>

<div class="lrbox">
<div class="lrbox1"><p class="colost2">Plant Images</p></div>
<div class="lrbox2"><a class="fancybox-thumbs" data-fancybox-group="thumb2" href="assets/images/bg-auth.jpg">Open link</a>
<a class="fancybox-thumbs" data-fancybox-group="thumb2" href="assets/images/bg-auth.jpg"></a>
<a class="fancybox-thumbs" data-fancybox-group="thumb2" href="assets/images/bg-auth.jpg"></a>
<a class="fancybox-thumbs" data-fancybox-group="thumb2" href="assets/images/bg-auth.jpg"></a>
</div>
<div class="clerfix"></div>
</div>


</div>
<div class="clerfix"></div>
<div class="clerfix"></div>
</div>

<div class="onlock-cov">
<div class="onlock-3"><p class="colost1">Product Status</p></div>
<div class="onlock-3">
<p class="colost2">Other</p>
<p class="colost2">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>

</div>
<div class="clerfix"></div>
</div>

<div class="clerfix"></div>
</div>
<!-- 3 -->

<!-- 4 -->
<div class="onlock">
<div class="onlock-cov">
<div class="onlock-3"><p class="colost1">Complaint Accepted</p></div>
<div class="onlock-3"><p class="colost2">Yes</p></div>
<div class="clerfix"></div>
<div class="onlock-3"><p class="colost1">Recommended / Adviced</p></div>
<div class="onlock-3"><p class="colost2">Lift back</p></div>
<div class="clerfix"></div>
<div class="onlock-3"><p class="colost1">Action By</p></div>
<div class="onlock-3"><p class="colost2">Nikhil Singh</p></div>
<div class="clerfix"></div>
<div class="onlock-3"><p class="colost1">Date</p></div>
<div class="onlock-3"><p class="colost2">12-12-2018</p></div>
</div>



<div class="clerfix"></div>
</div>
<!-- 4 -->

<!-- 5 -->
<div class="onlock">
<div class="onlock-1"><p class="colost1">Approval Note</p></div>
<div class="onlock-2">
<div class="lrbox001">
<div class="lrbox1"><p class="colost2">Document</p></div>
<div class="lrbox2"><a data-toggle="modal" data-target="#approval-note" href="#">Open link</a></div>
<div class="clerfix"></div>
</div></div>
<div class="clerfix"></div>
<div class="onlock-1"><p class="colost1">Action Taken</p></div>
<div class="onlock-2"><p class="colost2">Lift back</p></div>
<div class="clerfix"></div>
<div class="onlock-1"><p class="colost1">Credit note Approval</p></div>
<div class="onlock-2">

<div class="custom-control custom-checkbox arsalin">
<input type="checkbox" class="custom-control-input" id="customCheck1">
<label class="custom-control-label" for="customCheck1">CRM Head</label>
</div>

<div class="custom-control custom-checkbox arsalin">
<input type="checkbox" class="custom-control-input" id="customCheck2">
<label class="custom-control-label" for="customCheck2">Commercial Head</label>
</div>

<div class="custom-control custom-checkbox arsalin">
<input type="checkbox" class="custom-control-input" id="customCheck3">
<label class="custom-control-label" for="customCheck3">Plant Head</label>
</div>

<div class="custom-control custom-checkbox arsalin">
<input type="checkbox" class="custom-control-input" id="customCheck4">
<label class="custom-control-label" for="customCheck4">Sales Head</label>
</div>

<div class="custom-control custom-checkbox arsalin">
<input type="checkbox" class="custom-control-input" id="customCheck5">
<label class="custom-control-label" for="customCheck5">CFO</label>
</div>


</div>


<div class="clerfix"></div>
</div>
<!-- 5 -->

<!-- 6 -->
<div class="onlock">
<div class="onlock-cov">
<div class="onlock-3"><p class="colost1">Settelment</p></div>
<div class="onlock-3"><p class="colost2">Rejection</p></div>
<div class="clerfix"></div>
<div class="onlock-3"><p class="colost1">Rejection Invoice No.</p></div>
<div class="onlock-3"><p class="colost2">212547542158</p></div>
<div class="clerfix"></div>
<div class="onlock-3"><p class="colost1">Date</p></div>
<div class="onlock-3"><p class="colost2">12-12-2018</p></div>
<div class="clerfix"></div>
<div class="onlock-3"><p class="colost1">Final Quantity</p></div>
<div class="onlock-3"><p class="colost2">50000</p></div>
<div class="clerfix"></div>
<div class="onlock-3"><p class="colost1">Credit Note No.</p></div>
<div class="onlock-3"><p class="colost2">21548</p></div>
</div>
<div class="clerfix"></div>
</div>
<!-- 6 -->

<div class="onlock" style="border:none">
<div class="onlock-1"><p class="colost1">CAPA</p></div>
<div class="onlock-2">
<div class="lrbox001">
<div class="lrbox1"><p class="colost2">Document</p></div>
<div class="lrbox2"><a href="#">Open link</a></div>
<div class="clerfix"></div>
</div><div class="clerfix"></div>

</div>
<div class="clerfix"></div>
<div class="onlock-1 mrig8"><p class="colost1 ">Credit note Approval</p></div>
<div class="onlock-2">

<div class="custom-control custom-checkbox arsalin">
<input type="checkbox" class="custom-control-input" id="customCheck1">
<label class="custom-control-label" for="customCheck1">CRM Head</label>
</div>

<div class="custom-control custom-checkbox arsalin">
<input type="checkbox" class="custom-control-input" id="customCheck2">
<label class="custom-control-label" for="customCheck2">Commercial Head</label>
</div>

<div class="custom-control custom-checkbox arsalin">
<input type="checkbox" class="custom-control-input" id="customCheck3">
<label class="custom-control-label" for="customCheck3">Plant Head</label>
</div>

<div class="custom-control custom-checkbox arsalin">
<input type="checkbox" class="custom-control-input" id="customCheck4">
<label class="custom-control-label" for="customCheck4">Sales Head</label>
</div>

<div class="custom-control custom-checkbox arsalin">
<input type="checkbox" class="custom-control-input" id="customCheck5">
<label class="custom-control-label" for="customCheck5">CFO</label>
</div>


</div>
<div class="clerfix"></div>

</div>



<div class="clerfix"></div>
</div>
<div class="clerfix"></div>
</div>



</div>


</div><!-- end row-->
</div>
<!-- container -->


<!-- content -->

<!-- Form pop up -->
<div class="modal fade form-pop" id="approval-note" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header border-bottom-st d-block">
<!--<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<div class="form-p-hd">
<h2>MAHINDRA ACCELO LTD. / MASL / MSSCL<br>
Credit Note / Debit Note Approval</h2>
</div>


<div class="form-p-block">

<!-- box 1 -->
<div class="form-p-box form-p-box-bg2">

<div class="rst-left">
<ul class="fpall">
<li class="fp-con1"><p>Name of the customer</p></li>             <li class="fp-con2"><p class="form-p-box-bg1 com-done">Delux Engineering</p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con1"><p>Complaint reference no</p></li>             <li class="fp-con2"><p class="form-p-box-bg1 com-done">Direct Sheets/CC/350/F19</p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con1"><p>Complant Registration date</p></li>             <li class="fp-con2"><p class="form-p-box-bg1 com-done">8-Oct-18</p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con1"><p>Material Details  (grade, size etc)</p></li>             <li class="fp-con2"><p class="form-p-box-bg1 com-done">D HRPO 4.90 X 1250 X 2500</p></li>
<div class="clerfix"></div></ul>

</div>

<div class="rst-right">
<ul class="fpall">
<li class="fp-con1"><p>Nature of the complaint</p></li>             <li class="fp-con2"><p class="form-p-box-bg1 com-done">Dent marks on the surface</p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con1"><p>Name of the Steel Mill / Service centre/ Transporter</p></li>             <li class="fp-con2"><p class="form-p-box-bg1 com-done">Essar</p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con1"><p>Responsibility</p></li>             <li class="fp-con2"><p class="form-p-box-bg1 com-done">Mill</p></li>
<div class="clerfix"></div></ul>

</div>

<div class="clerfix"></div>
</div>
<!-- box 1 -->

<!-- box 2 -->
<div class="form-p-box form-p-box-bg1 border-bottom-st">
<h2 class="sectphd">Credit note to be issued to customer</h2>
<div class="rst-left">
<ul class="fpall">
<li class="fp-con1"><p>Billing Document No.</p></li>   
<li class="fp-con2"><p class="form-p-box-bg2 com-done">7350643968</p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con1"><p>Billing Document Date</p></li>             <li class="fp-con2"><p class="form-p-box-bg2 com-done">2-Dec-18</p></li>
<div class="clerfix"></div></ul>

</div>

<div class="rst-right">


<ul class="fpall">
<li class="fp-con1"><p>Total qty (t) rejected by the customer</p></li>             <li class="fp-con2"><p class="form-p-box-bg2 com-done">  2.91 </p></li>
<div class="clerfix"></div></ul>

</div>

<div class="clerfix"></div>
</div>
<!-- box 2 -->

<!-- box 3 -->
<div class="form-p-box form-p-box-bg1">

<div class="rst-full">
<ul class="fpall">
<li class="fp-con01"><p>Basic sale price</p></li> <li class="fp-con02"> <span class="padd10">Rs.</span> <p class="form-p-box-bg2 com-done sphf">   52,280.00 </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p>Sales Value (Basic sale price/t X Qty)</p></li> <li class="fp-con02"><span class="padd10">Rs.</span>  <p class="form-p-box-bg2 com-done sphf">   152,134.80 </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p>CGST @ 9%</p></li> <li class="fp-con02"><span class="padd10">Rs.</span>  <p class="form-p-box-bg2 com-done sphf">   13,692.13 </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p>SGST @ 9%</p></li> <li class="fp-con02"><span class="padd10">Rs.</span>  <p class="form-p-box-bg2 com-done sphf">   13,692.13 </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p>Cost incurred by the customer, (customer has debited us for poor packaging of the material)</p></li> <li class="fp-con02"><span class="padd10">Rs.</span>  <p class="form-p-box-bg2 com-done sphf"> - </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p>Salvage Rate (in case matl scrapped by the customer)</p></li> <li class="fp-con02"><span class="padd10">Rs.</span> 
<p class="form-p-box-bg2 com-done sphf"> - </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p class="colrred">Credit note to be issued to the customer (total of abv net of scrap value)</p></li> 
<li class="fp-con02"><span class="padd10 colrred">Rs.</span>  <p class="form-p-box-bg3 com-done sphf">   179,519.06 </p></li>
<div class="clerfix"></div></ul>

</div>

<div class="clerfix"></div>
</div>
<!-- box 3 -->

<!-- box 4 -->
<div class="form-p-box form-p-box-bg2">

<div class="rst-full">
<ul class="fpall">
<li class="fp-con01"><p>Debit note issued to supplier / Realisation from scrap / To be recovered from Insurance co.</p></li> <li class="fp-con02"><span class="padd10">Rs.</span>  <p class="form-p-box-bg1 com-done sphf">  - </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p>Quantity (t) as accepted by steel mill    </p></li> <li class="fp-con02"><span class="padd10">Rs.</span>  <p class="form-p-box-bg1 com-done sphf">   2.91 </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p>Quantity (t) to be scrapped / auction at service centres </p></li> <li class="fp-con02"><span class="padd10">Rs.</span>  <p class="form-p-box-bg1 com-done sphf"> -  </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p>Quantity (t) to be diverted to any other customer</p></li> <li class="fp-con02"><span class="padd10">Rs.</span>  
<p class="form-p-box-bg1 com-done sphf"> -  </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p>Debit note (purchase price/t) / Salvage rate / Sale value</p></li> <li class="fp-con02"><span class="padd10">Rs.</span>  <p class="form-p-box-bg1 com-done sphf">   46,300.00 </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p>Value (purchase price/t  X qty)</p></li> <li class="fp-con02"><span class="padd10">Rs.</span>  <p class="form-p-box-bg1 com-done sphf">   134,733.00 </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p>CGST @ 9%</p></li> <li class="fp-con02"><span class="padd10">Rs.</span>  <p class="form-p-box-bg1 com-done sphf">   12,125.97 </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p>SGST @ 9%</p></li> <li class="fp-con02"><span class="padd10">Rs.</span>  <p class="form-p-box-bg1 com-done sphf">   12,125.97 </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p>Other expenses incurred by MIL (processing cost, freight, octroi et al) *</p></li> <li class="fp-con02"><span class="padd10">Rs.</span>  <p class="form-p-box-bg1 com-done sphf"> - </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p>Other expenses to be debited (eg freight) / credited (eg scrap @ 20000 recovery) to steel mill</p></li> <li class="fp-con02"><span class="padd10">Rs.</span>  <p class="form-p-box-bg1 com-done sphf"> -  </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p>Compensation expected from Insurance Co.</p></li> <li class="fp-con02"><span class="padd10">Rs.</span>  <p class="form-p-box-bg1 com-done sphf"> - </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p class="colrred">Debit note issued to supplier / Billing back to customer / Realisation from scrap</p></li> 
<li class="fp-con02"><span class="padd10 colrred">Rs.</span>  <p class="form-p-box-bg3 com-done sphf">   158,984.94 </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p class="colrred">Loss from the Rejection </p></li> 
<li class="fp-con02"><span class="padd10 colrred">Rs.</span>  <p class="form-p-box-bg3 com-done sphf">   20,534.12 </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p>Recoverable from Transporter (if applicable)</p></li> <li class="fp-con02"><span class="padd10">Rs.</span>  <p class="form-p-box-bg1 com-done sphf"> -  </p></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
<li class="fp-con01"><p class="colrred">Net loss </p></li> 
<li class="fp-con02"><span class="padd10 colrred">Rs.</span>  <p class="form-p-box-bg3 com-done sphf">   20,534.12 </p></li>
<div class="clerfix"></div></ul>

</div>

<div class="pfot-cont">

<p>
Note<br/>
a) Credit Note will be issued by the respective plants in case of material return from the customer.<br/>
b)  For processing related rejections, complaint will be closed after issue of CAPA / CN<br/>
</p>
</div>

<div class="clerfix"></div>
</div>
<!-- box 4 -->

<div class="form-p-box form-p-boxbtn">
<a class="fpcl" data-dismiss="modal" aria-hidden="true" href="#">Close</a>
<a class="fpdone" href="#">Save</a>
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


<!-- fancyBox Js includ -->
<?php include 'fancyboxjs.php'?>
<!-- fancyBox Js includ -->


</body>
</html>


