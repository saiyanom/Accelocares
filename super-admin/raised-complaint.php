<?php 
	ob_start();
	require_once("../includes/initialize.php"); 

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("raised-complaint.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("raised-complaint.php");
		} 
	}

	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindra Accelo CRM</title>
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

	
<div class="row">

<div class="complaints-blocks">
<div class="cb-block">
<div class="cmp-lf"><h2>Create New Complaint</h2></div>
<div class="clerfix"></div>
	
	
	

<form action="raised-new-complaint-db.php" method="post" enctype="multipart/form-data" autocomplete="off">
		
<ul class="rais-block">
	<li class="resit-act1">
	<select id="product" name="product" class="form-control">
		<option value="">- Select Product -</option>
		<?php
			$sql = "Select * from product order by product ASC";
			$product = Product::find_by_sql($sql);
			$product_stored = '';
			foreach($product as $product){
				if($product_stored != $product->product){
					echo "<option>{$product->product}</option>";
					$product_stored = $product->product;
				}
			}
		?>
	</select>
	<span class="err_msg product_msg"></span>
	</li>
	<li class="resit-act1">
	<select id="plant_location" name="plant_location" class="form-control">
		<option value="">- Select Location -</option>
	</select>
	<span class="err_msg plant_location_msg"></span>
	</li>
	<li class="resit-act1">
	<div class="row">	
		<div class="col col-sm-5">
			<select name="quantity_type" class="form-control">
				<option>MT</option>
				<option>KG</option>
				<option>Each</option>
			</select>
		</div>
		<div class="col col-sm-7">
			<input type="text" id="rejected_quantity" name="rejected_quantity" placeholder="Add Rejected Quantity" class="form-control">
		</div>
		<span class="err_msg rejected_quantity_msg"></span>
	</div>	
	</li>

	<li class="resit-act1">
		<input type="text" id="invoice_number" name="invoice_number" placeholder="Invoice Number" class="form-control">
		<span class="err_msg invoice_number_msg"></span>
	</li>

  <li class="resit-act1">
    <input type="text" id="size" name="size" placeholder="Size" class="form-control">
    <span class="err_msg size_msg"></span>
  </li>
  
</ul>

<ul class="rais-block">
	<li class="resit-act1">
		<input type="text" id="invoice_date" name="invoice_date" placeholder="Invoice Date" class="form-control date-picker">
		<span class="err_msg invoice_date_msg"></span>
	</li>

	<li class="resit-act1">
		<input type="text" id="defect_batch_no" name="defect_batch_no" placeholder="Defective Batch No." class="form-control">
		<span class="err_msg defect_batch_no_msg"></span>
	</li>

	<li class="resit-act1">
		<select id="complaintType" name="complaint_type" class="form-control">
			<option value="">- Complaint Type -</option>
		</select>
		<span class="err_msg complaint_type_msg"></span>
	</li>
	<li class="resit-act1" id="complaintTypeOther" style="display: none;">
		<input type="text" name="complaintTypeOther" placeholder="Complaint Type" class="form-control">
		<span class="err_msg complaintTypeOther_msg"></span>
	</li>
	<li class="resit-act1" id="complaintOtherSubType">
		<select id="complaintSubType" name="sub_complaint_type" class="form-control">
			<option value=''>- Sub Complaint Type -</option>
		</select>
		<span class="err_msg sub_complaint_type_msg"></span>
	</li>
	<li class="resit-act1" id="complaintSubTypeOther" style="display: none;">
		<input type="text" name="complaintSubTypeOther" placeholder="Sub Complaint Type" class="form-control">
		<span class="err_msg complaintSubTypeOther_msg"></span>
	</li>
</ul>

<ul class="rais-block">
	<li class="resit-act1">
	<select id="company" name="company" class="form-control select2" data-toggle="select2">
		<option value="">- Select Company -</option>
		<?php
			$company_reg = CompanyReg::find_all();
			foreach($company_reg as $company_reg){
				echo "<option value='{$company_reg->id}'>{$company_reg->company_name}</option>";
			}
		?>
	</select>
	<span class="err_msg company_msg"></span>
	</li>
	<li class="resit-act1">
		<select id="pl_name" name="pl_name" class="form-control">
			<option value="">- Complaint Raised by -</option>
		</select>
		<span class="err_msg pl_name_msg"></span>
	</li>
	
	<li class="resit-act1 pl_name_2" style="display: none;">
		<input type="text" id="pl_name_2" name="pl_name_2" placeholder="Person Name" class="form-control">
		<span class="err_msg pl_name_2_msg"></span>
	</li>
	
	<li class="resit-act1">
		<input type="text" readonly id="pl_email" name="pl_email" placeholder="Email ID" class="form-control">
		<span class="err_msg pl_email_msg"></span>
	</li>

	<li class="resit-act1">
		<input type="text" readonly id="pl_mobile" name="pl_mobile" placeholder="Mobile Number" class="form-control">
		<span class="err_msg pl_mobile_msg"></span>
	</li>
</ul>

<ul class="rais-block-comsub product_img">
	<li class="resit-act1 product-img-row prod_img_row_1" style="margin: 15px 0;">
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text clear_img clear_img_1" title="Clear Image">X</span>
			</div>
			<div class="custom-file">
				<input type="file" name="product_img_1" class="custom-file-input" id="product_img_1">
				<label class="custom-file-label" for="product_img_1">Upload Image</label>
			</div>
		</div>
		<span>(Maximun upload file size is 25MB)</span>
		<span class="err_msg product_img_1_msg"></span>
	</li>
</ul>
	
<ul class="rais-block-comsub">
	<li class="resit-act1" style="margin: 15px 0;">
		<div class="input-group">
			<div class="custom-file">
				<button type="button" name="product_btn" class="btn btn-success add_prod_img"><i class="mdi mdi-plus"></i> Add Image</button>
				&nbsp; &nbsp; 
				<button type="button" name="product_btn" class="btn btn-danger rem_prod_img"><i class="mdi mdi-minus"></i> Remove Image</button>
			</div>
		</div>
	</li>
</ul>

<ul class="rais-block-comsub">
	<li class="resit-act1" style="margin: 15px 0;">
		<textarea class="form-control" id="example-textarea" name="pl_feedback" placeholder="Write your feedback here..." rows="3"></textarea>
	</li>
</ul>
	
<ul class="rais-block-comsub">
	<li class="subtn03" style="margin: 15px auto;">
		<div class="form-group mb-0 text-center log-btn">
			<input type="submit" id="create_complaint" name="create_complaint" class="btn btn-danger btn-block" value="Create Complaint" />
		</div>
	</li>
	<div class="clerfix"></div>
</ul>	

</form>	

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
</body>
<style>
	span.clear_img{
		cursor: pointer;
		color: #fff;
		background-color: #a00;
		border: 1px solid #900;
	}
	span.err_msg{
	    color: #f00;
	    font-size: 12px;
	    display: none;
	}
	.select2-container {
		width: 100% !important;
	}
</style>
<script type="application/javascript">
	
$(document).ready(function() {
	
	$('.date-picker').daterangepicker({
		singleDatePicker: true,
		locale: {
          format: 'DD/MM/YYYY',
    	}
	});
	
	var product = "";
	
	$("#company").change(function(){
		var company = this.value.replace(" ","%20");
		company = company.replace(" ","%20");
		company = company.replace(" ","%20");
		$("#pl_name").load("get-employee.php?id="+company);
	});
	$("#product").change(function(){
		product = this.value.replace(" ","%20");
		product = product.replace(" ","%20");
		product = product.replace(" ","%20");
		$("#plant_location").load("get-site-location.php?product="+product);
	});
	$("#plant_location").change(function(){
		var plant_location = this.value.replace(" ","%20");
		var plant_location = plant_location.replace(" ","%20");
		var plant_location = plant_location.replace(" ","%20");
		var product = $("#product").val().replace(" ","%20");	
		//console.log("get-complaint-type.php?plant_location="+plant_location+"&&product="+product);
		$("#complaintType").load("get-complaint-type.php?plant_location="+plant_location+"&&product="+product);
	});
	$("#complaintType").change(function(){
		
		var complaint = this.value.replace(" ","%20");
		var complaint = complaint.replace(" ","%20");
		var complaint = complaint.replace(" ","%20");

		var plant_location = $("#plant_location").val().replace(" ","%20");	
		var plant_location = plant_location.replace(" ","%20");
		var plant_location = plant_location.replace(" ","%20");
		
		$("#complaintSubTypeOther").hide();
		
		if(complaint == "Other"){
			$("#complaintType_2").show();
			
			$("#complaintTypeOther").show();
			$("#complaintSubType").hide();
			$("#complaintSubTypeOther").hide();
		} else {
			$("#complaintType_2").hide();
			
			$("#complaintTypeOther").hide();
			$("#complaintSubType").show();
			$("#complaintSubTypeOther").hide();
		}
		
		$("#complaintSubType").load("get-complaint-sub-type.php?plant_location="+plant_location+"&&product="+product+"&&complaint="+complaint);
	});
	
	
	$("#complaintSubType").change(function(){
		var complaint = this.value;
		
		if(complaint == "Other"){
			$("#complaintSubTypeOther").show();
		} else {
			$("#complaintSubTypeOther").hide();
		}
	});
	
	
	for (num = 2; num <= 3; num++) { 
	  	var div = "<li class='resit-act1 product-img-row prod_img_row_"+ num +"' style='margin: 15px 0;'><div class='input-group'><div class='input-group-prepend'><span class='input-group-text clear_img clear_img_"+ num +"' title='Clear Image'>X</span></div><div class='custom-file'><input type='file' name='product_img_"+ num +"' class='custom-file-input' id='product_img_"+ num +"'><label class='custom-file-label' for='product_img_"+ num +"'>Upload Image</label></div></div><span>(Maximun upload file size is 25MB)</span><span class='err_msg product_img_"+ num +"_msg'></span></li>";
		$(".product_img").append(div);
		$(".prod_img_row_"+ num).hide();	
	}
	
	
	$('input[type=file]').change(function(e){		
		var fileName = e.target.files[0].name;
		$(this).closest('div').find('label').html(fileName);
		//alert('The file "' + fileName +  '" has been selected. - ');
	});	
	
	/*$(".clear_img_1").click(function (e) {
		$("#product_img_1").val('');
		$("#product_img_1").closest('div').find('label').html('');
	});*/
	
	
	$(".clear_img").click(function (e) {
		$(this).closest('.product-img-row').find('.custom-file label').html('Upload Image');
		$(this).closest('.product-img-row').find('.custom-file input').val('');
	});
	
	
	var num = 1;
	
	$(".add_prod_img").click(function (e) {
		if(num < 3){
			num++;
			$(".prod_img_row_"+ num).show();
			//console.log(num);	
		} 
		e.preventDefault();
	});
	
	$(".rem_prod_img").click(function (e) {
		if(num >= 2){
			$(".prod_img_row_"+ num).hide();	
			$(".prod_img_row_"+ num +" input").val(''); 
			//console.log(num);
			num--;
		}
		e.preventDefault();
	});	
	
	
	$("#pl_name").change(function(){
		var pl_name = this.value.replace(" ","%20");
		pl_name = pl_name.replace(" ","%20");
		pl_name = pl_name.replace(" ","%20");

		var comp_id = $("#company").val().replace(" ","%20");
		
		
		$( "#pl_email" ).load( "get-employee-details.php?cid="+comp_id+"&&id="+pl_name+"&&type=email", function( response, status, xhr ) {
		  $("#pl_email").val(response);
		});
		$( "#pl_email" ).load( "get-employee-details.php?cid="+comp_id+"&&id="+pl_name+"&&type=mobile", function( response, status, xhr ) {
		  $("#pl_mobile").val(response);
		});
		
		selected_name = this.value
				
		if(selected_name == "Other"){
			$(".pl_name_2").show();
			$("#pl_email").attr("readonly", false); $("#pl_mobile").attr("readonly", false); 
			$("#pl_email").val(''); $("#pl_mobile").val('');
		} else if(selected_name == ""){
			$(".pl_name_2").hide();
			$("#pl_email").attr("readonly", true); $("#pl_mobile").attr("readonly", true); 
			$("#pl_email").val(''); $("#pl_mobile").val('');
		} else{ 
			$(".pl_name_2").hide(); 
			$("#pl_email").attr("readonly", true); $("#pl_mobile").attr("readonly", true); 
		}

	});

});
</script>	
</html>


