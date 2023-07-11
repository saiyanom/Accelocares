// JavaScript Document
$(document).ready(function() {
	
	$("#department").change(function (e) {
		var department = $(this).val();
		
		if(department == 'new_department'){
			$("#department_new").show();
		} else {
			$("#department_new input").val('');
			$("#department_new").hide();
		}
	});
	
	$("#site_location").change(function (e) {
		var site_location = $(this).val();
		
		if(site_location == 'new_site_location'){
			$("#site_location_new").show();
		} else {
			$("#site_location_new input").val('');
			$("#site_location_new").hide();
		}
	});
	
	$("#product").change(function (e) {
		var product = $(this).val();
		
		if(product == 'new_product'){
			$("#product_new").show();
		} else {
			$("#product_new input").val('');
			$("#product_new").hide();
		}
	});
	
	
	
	
	
	
	
	$(".add_cust").click(function (e) {
		var num = $(".cust_details_row").length + 1;
		if(num <= 5){
			var div = "<div class='cust_details_row cust_details_row_"+num+"'><hr /><div class='form-group'><label class='control-label'>Full Name</label><input class='form-control form-p-box-bg1' type='text' name='emp_name_"+num+"'></div><div class='form-group'><label class='control-label'>Email</label><input class='form-control form-p-box-bg1' type='text' name='emp_email_"+num+"'></div><div class='form-group'><label class='control-label'>Mobile Number</label><input class='form-control form-p-box-bg1' type='number' name='emp_mobile_"+num+"'></div><div class='clerfix'></div></div>";
			$(".cust_details").append(div);
		} 		
		e.preventDefault();
	});
	
	$(".rem_cust").click(function (e) {
		var num = $(".cust_details_row").length;		
		if(num >= 2){
			$(".cust_details_row_"+ num).remove();
		}
		e.preventDefault();
	});	
	
	
	
});