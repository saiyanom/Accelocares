// JavaScript Document
$(document).ready(function() {

	function isValid(str) {
	    return !/[~`!#$%\^*+=\\[\]\\;/{}|\\:<>\?]/g.test(str);
	}

	$("input, textarea").keypress(function(event) {
	    var character = String.fromCharCode(event.keyCode);
	    return isValid(character);  
	});

	function validateEmail(email) {
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		return emailReg.test(email);
	}
	
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
			var div = "<div class='cust_details_row cust_details_row_"+num+"'><hr /><div class='form-group'><label class='control-label'>Full Name</label><input class='form-control form-p-box-bg1' type='text' id='emp_name_"+num+"' name='emp_name_"+num+"'><span class='err_msg emp_name_"+num+"_msg'></span></div><div class='form-group'><label class='control-label'>Email</label><input class='form-control form-p-box-bg1' type='text' id='emp_email_"+num+"' name='emp_email_"+num+"'><span class='err_msg emp_email_"+num+"_msg'></span></div><div class='form-group'><label class='control-label'>Mobile Number</label><input class='form-control form-p-box-bg1' type='number' id='emp_mobile_"+num+"' name='emp_mobile_"+num+"'><span class='err_msg emp_mobile_"+num+"_msg'></span></div><div class='clerfix'></div></div>";
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
	
	$(".add_mill").click(function (e) {
		var num = $(".mill_details_row").length + 1;
		if(num <= 5){
			var div = "<div class='mill_details_row mill_details_row_"+num+"'><hr /><div class='form-group'><label class='control-label'>Full Name</label><input class='form-control form-p-box-bg1' type='text' id='name_"+num+"' name='name_"+num+"'><span class='err_msg name_"+num+"_msg'></span></div><div class='form-group'><label class='control-label'>Email</label><input class='form-control form-p-box-bg1' type='text' id='email_"+num+"' name='email_"+num+"'><span class='err_msg email_"+num+"_msg'></div><div class='form-group'><label class='control-label'>Mobile Number</label><input class='form-control form-p-box-bg1' type='number' id='mobile_"+num+"' name='mobile_"+num+"'><span class='err_msg mobile_"+num+"_msg'></span></div><div class='clerfix'></div></div>";
			$(".mill_details").append(div);
		} 		
		e.preventDefault();
	});
	
	$(".rem_mill").click(function (e) {
		var num = $(".mill_details_row").length;		
		if(num >= 2){
			$(".mill_details_row_"+ num).remove();
		}
		e.preventDefault();
	});

	
	
/* Raise Complaint Form Submition *************************************************************/
	$("#create_complaint").click(function() {	

		function validateEmail(email) {
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			return emailReg.test(email);
		}	

		if ($("#employee").val() == "") {
			$("#employee").css("border","1px solid #f00");
		  	//alert("Select Product");
		  	$(".employee_msg").show(); $(".employee_msg").html("Select Employee");
		  	return false;
		} else {$("#employee").css("border","1px solid #dee2e6"); $(".employee_msg").hide(); $(".employee_msg").html("");} 

		
		if ($("#product").val() == "") {
			$("#product").css("border","1px solid #f00");
		  	//alert("Select Product");
		  	$(".product_msg").show(); $(".product_msg").html("Select Product");
		  	return false;
		} else { $("#product").css("border","1px solid #dee2e6"); $(".product_msg").hide(); $(".product_msg").html("");} 

		if ($("#plant_location").val() == "") {
			$("#plant_location").css("border","1px solid #f00");
		  	//alert("Select Location");
		  	$(".plant_location_msg").show(); $(".plant_location_msg").html("Select Location");
		  	return false;
		} else { $("#plant_location").css("border","1px solid #dee2e6"); $(".plant_location_msg").hide(); $(".plant_location_msg").html("");} 

		if ($("#rejected_quantity").val() == "") {
			$("#rejected_quantity").css("border","1px solid #f00");
		  	//alert("Add Rejected Quantity");
		  	$(".rejected_quantity_msg").show(); $(".rejected_quantity_msg").html("Add Rejected Quantity");
		  	return false;
		} else { $("#rejected_quantity").css("border","1px solid #dee2e6"); $(".rejected_quantity_msg").hide(); $(".rejected_quantity_msg").html("");} 

		if ($("#invoice_number").val() == "") {
			$("#invoice_number").css("border","1px solid #f00");
		  	//alert("Enter Invoice Number");
		  	$(".invoice_number_msg").show(); $(".invoice_number_msg").html("Enter Invoice Number");
		  	return false;
		} else { $("#invoice_number").css("border","1px solid #dee2e6"); $(".invoice_number_msg").hide(); $(".invoice_number_msg").html("");} 

		if ($("#invoice_date").val() == "") {
			$("#invoice_date").css("border","1px solid #f00");
		  	//alert("Select Invoice Date");
		  	$(".invoice_date_msg").show(); $(".invoice_date_msg").html("Select Invoice Date");
		  	return false;
		} else { $("#invoice_date").css("border","1px solid #dee2e6"); $(".invoice_date_msg").hide(); $(".invoice_date_msg").html("");} 

		if ($("#invoice_number").val() != "") {
        var invoice_number = $("#invoice_number").val();
       /* if(invoice_number.length > 20){
        $("#invoice_number").css("border","1px solid #f00");
        $(".invoice_number_msg").show(); $(".invoice_number_msg").html("Max 20 digit Invoice Number is allowed");
          return false;
        } else { $("#invoice_number").css("border","1px solid #dee2e6"); $(".invoice_number_msg").hide(); $(".invoice_number_msg").html("");
        } */
    } 

		if ($("#defect_batch_no").val() == "") {
			$("#defect_batch_no").css("border","1px solid #f00");
		  	//alert("Enter Defected Batch Number");
		  	$(".defect_batch_no_msg").show(); $(".defect_batch_no_msg").html("Enter Defected Batch Number");
		  	return false;
		} else { $("#defect_batch_no").css("border","1px solid #dee2e6"); $(".defect_batch_no_msg").hide(); $(".defect_batch_no_msg").html("");} 

		/*if ($("#defect_batch_no").val() != "") {
		  	var defect_batch_no = $("#defect_batch_no").val();
		  	if(defect_batch_no.length != 10){
				$("#defect_batch_no").css("border","1px solid #f00");
		  		//alert("Enter 10 digit Defected Batch Number");
		  		$(".defect_batch_no_msg").show(); $(".defect_batch_no_msg").html("Enter 10 digit Defected Batch Number");
		  		return false;
		  	} else { $("#defect_batch_no").css("border","1px solid #dee2e6"); $(".defect_batch_no_msg").hide(); $(".defect_batch_no_msg").html("");} 
		} */


		if ($("#complaintType").val() == "") {
			$("#complaintType").css("border","1px solid #f00");
		  	//alert("Select Complaint Type");
		  	$(".complaint_type_msg").show(); $(".complaint_type_msg").html("Select Complaint Type");
		  	return false;
		} else { $("#complaintType").css("border","1px solid #dee2e6"); $(".complaint_type_msg").hide(); $(".complaint_type_msg").html("");} 

		if ($("#complaintType").val() == "Other") {
		  	if ($("#complaintTypeOther input").val() == "") {
				$("#complaintTypeOther input").css("border","1px solid #f00");
			  	//alert("Enter Complaint Type");
				$(".complaintTypeOther_msg").show(); $(".complaintTypeOther_msg").html("Enter Complaint Type");
			  	return false;
			} else { $("#complaintTypeOther input").css("border","1px solid #dee2e6"); $(".complaintTypeOther_msg").hide(); $(".complaintTypeOther_msg").html("");} 
		} 

		/*if ($("#complaintSubType").val() == "") {
			$("#complaintSubType").css("border","1px solid #f00");
		  	//alert("Select Sub Complaint Type");
		  	return false;
		} else { $("#complaintSubType").css("border","1px solid #dee2e6");} 
		*/
		if ($("#complaintSubType").val() == "Other") {
		  	if ($("#complaintSubTypeOther input").val() == "") {
				$("#complaintSubTypeOther input").css("border","1px solid #f00");
			  	//alert("Enter Sub Complaint Type");
			  	$(".complaintSubTypeOther_msg").show(); $(".complaintSubTypeOther_msg").html("Enter Sub Complaint Type");
			  	return false;
			} else { $("#complaintSubTypeOther input").css("border","1px solid #dee2e6"); $(".complaintSubTypeOther_msg").hide(); $(".complaintSubTypeOther_msg").html("");} 
		} 

		if ($("#pl_name").val() == "") {
			$("#pl_name").css("border","1px solid #f00");
		 	//alert("Select Complaint Raised by");
			$(".pl_name_msg").show(); $(".pl_name_msg").html("Select Complaint Raised by");
		  	return false;
		} else { $("#pl_name").css("border","1px solid #dee2e6"); $(".pl_name_msg").hide(); $(".pl_name_msg").html("");} 

		if ($("#pl_email").val() == "") {
			$("#pl_email").css("border","1px solid #f00");
			//alert("Enter Employee Email");
			$(".pl_email_msg").show(); $(".pl_email_msg").html("Enter Employee Email");
			return false;
		} else { 
			if(!validateEmail($("#pl_email").val())){
				$("#pl_email").css("border","1px solid #f00");
				$(".pl_email_msg").show(); $(".pl_email_msg").html("Enter Valid Employee Email");
				return false;
			} else {
				$("#pl_email").css("border","1px solid #dee2e6"); $(".pl_email_msg").hide(); $(".pl_email_msg").html("");
			} 
		}

		if ($("#pl_mobile").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#pl_mobile').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#pl_mobile").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
				    $(".pl_mobile_msg").show(); $(".pl_mobile_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#pl_mobile").css("border","1px solid #dee2e6"); $(".pl_mobile_msg").hide(); $(".pl_mobile_msg").html("");} 
			} else {
				$("#pl_mobile").css("border","1px solid #f00");
				//alert("Enter valid Mobile Number");
				$(".pl_mobile_msg").show(); $(".pl_mobile_msg").html("Enter valid Mobile Number");
				return false;
			}
		}
		
		if ($("#pl_name").val() == "Other") {
			
			if ($("#pl_name_2").val() == "") {
				$("#pl_name_2").css("border","1px solid #f00");
				//alert("Enter Person Name");
				$(".pl_name_2_msg").show(); $(".pl_name_2_msg").html("Enter Person Name");
		  		return false;
			} else {

				if ($.isNumeric($("#pl_name_2").val())) {
					$("#pl_name_2").css("border","1px solid #f00");
					//alert("Enter Person Name");
					$(".pl_name_2_msg").show(); $(".pl_name_2_msg").html("Remove Number from Person Name");
			  		return false;
				} else {
					$("#pl_name_2").css("border","1px solid #dee2e6"); $(".pl_name_2_msg").hide(); $(".pl_name_2_msg").html("");
				}
								

				if ($("#pl_email").val() == "") {
					$("#pl_email").css("border","1px solid #f00");
					//alert("Enter Employee Email");
					$(".pl_email_msg").show(); $(".pl_email_msg").html("Enter Employee Email");
					return false;
				} else { 
					if(!validateEmail($("#pl_email").val())){
						$("#pl_email").css("border","1px solid #f00");
						$(".pl_email_msg").show(); $(".pl_email_msg").html("Enter Valid Employee Email");
						return false;
					} else {
						$("#pl_email").css("border","1px solid #dee2e6"); $(".pl_email_msg").hide(); $(".pl_email_msg").html("");
					} 
				}

				if ($("#pl_mobile").val() == "") {
					$("#pl_mobile").css("border","1px solid #f00");
				  	//alert("Enter Employee Mobile");
					$(".pl_mobile_msg").show(); $(".pl_mobile_msg").html("Enter Employee Mobile");
				  	return false;
				}
				if ($("#pl_mobile").val() != "") {			
					var intsOnly = /^\d+$/,
					phone_num = $('#pl_mobile').val();

					if(intsOnly.test(phone_num)) {
					   if (phone_num.length != 10) {
							$("#pl_mobile").css("border","1px solid #f00");
							//alert("Enter 10 digit Mobile Number");
						    $(".pl_mobile_msg").show(); $(".pl_mobile_msg").html("Enter 10 digit Mobile Number");
							return false;
						} else { $("#pl_mobile").css("border","1px solid #dee2e6"); $(".pl_mobile_msg").hide(); $(".pl_mobile_msg").html("");} 
					} else {
						$("#pl_mobile").css("border","1px solid #f00");
						//alert("Enter valid Mobile Number");
						$(".pl_mobile_msg").show(); $(".pl_mobile_msg").html("Enter valid Mobile Number");
						return false;
					}
				}  else{
					//$("#pl_mobile").css("border","1px solid #f00");
					//alert("Enter Mobile Number");
					//$(".pl_mobile_msg").show(); $(".pl_mobile_msg").html("Enter Mobile Number");
					//return false;
				}
			}
			
		} 

    if ($("#size").val() == "") {
      $("#size").css("border","1px solid #f00");
      $(".size_msg").show(); $(".size_msg").html("Enter size");
        return false;
    } else { $("#size").css("border","1px solid #dee2e6"); $(".size_msg").hide(); $(".size_msg").html("");} 
		
		var img_error = 0;
		if($('#product_img_1').val() != ''){
			var ext = $('#product_img_1').val().split('.').pop().toLowerCase();
			var file_size = $('#product_img_1')[0].files[0].size;
			if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
				//alert('Upload Image JPG, JPEG OR PNG Format Only');
				$(".product_img_1_msg").show(); $(".product_img_1_msg").html("Upload Image JPG, JPEG OR PNG Format Only");
				img_error += 1;
			} else if(file_size>25485760) {
				$(".product_img_1_msg").show(); $(".product_img_1_msg").html("File size is greater than 25MB");
				img_error += 1;
			} else {
				$(".product_img_1_msg").hide(); $(".product_img_1_msg").html("");
			}
		} 
		
		if($('#product_img_2').val() != ''){
			var ext = $('#product_img_2').val().split('.').pop().toLowerCase();
			var file_size = $('#product_img_2')[0].files[0].size;
			if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
				$(".product_img_2_msg").show(); $(".product_img_2_msg").html("Upload Image JPG, JPEG OR PNG Format Only");
				img_error += 1;
			} else if(file_size>25485760) {
				$(".product_img_2_msg").show(); $(".product_img_2_msg").html("File size is greater than 25MB");
				img_error += 1;
			} else {
				$(".product_img_2_msg").hide(); $(".product_img_2_msg").html("");
			} 
		} 
		
		if($('#product_img_3').val() != ''){
			var ext = $('#product_img_3').val().split('.').pop().toLowerCase();
			var file_size = $('#product_img_3')[0].files[0].size;
			if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
				$(".product_img_3_msg").show(); $(".product_img_3_msg").html("Upload Image JPG, JPEG OR PNG Format Only");
				img_error += 1;
			} else if(file_size>25485760) {
				$(".product_img_3_msg").show(); $(".product_img_3_msg").html("File size is greater than 25MB");
				img_error += 1;
			} else {
				$(".product_img_3_msg").hide(); $(".product_img_3_msg").html("");
			} 
		} 
		
		if(img_error > 0){ return false; }
	
		
	});
/* Raise Complaint Form Submition  END *************************************************************/
	
	
/* Create Employee Form Submition *************************************************************/
$("#create_employee").click(function() {


	if ($("#emp_name").val() == "") {
		$("#emp_name").css("border","1px solid #f00");
		$(".emp_name_msg").show(); $(".emp_name_msg").html("Enter Employee Name");
		return false;
	} else { 
		if ($.isNumeric($("#emp_name").val())) {
			$("#emp_name").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".emp_name_msg").show(); $(".emp_name_msg").html("Remove Number from Employee Name");
	  		return false;
		} else {
			$("#emp_name").css("border","1px solid #dee2e6"); $(".emp_name_msg").hide(); $(".emp_name_msg").html("");
		}
	
		
		if ($("#emp_email").val() == "") {
			$("#emp_email").css("border","1px solid #f00");
			$(".emp_email_msg").show(); $(".emp_email_msg").html("Enter Employee Email");
			return false;
		} else { 
			if(!validateEmail($("#emp_email").val())){
				$("#emp_email").css("border","1px solid #f00");
				$(".emp_email_msg").show(); $(".emp_email_msg").html("Enter Valid Employee Email");
				return false;
			} else {
				$("#emp_email").css("border","1px solid #dee2e6"); $(".emp_email_msg").hide(); $(".emp_email_msg").html("");
			} 
		} 
		
		if ($("#emp_mobile").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#emp_mobile').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#emp_mobile").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".emp_mobile_msg").show(); $(".emp_mobile_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#emp_mobile").css("border","1px solid #dee2e6"); $(".emp_mobile_msg").hide(); $(".emp_mobile_msg").html("");} 
			} else {
				$("#emp_mobile").css("border","1px solid #f00");
				$(".emp_mobile_msg").show(); $(".emp_mobile_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#emp_mobile").css("border","1px solid #f00");
			//$(".emp_mobile_msg").show(); $(".emp_mobile_msg").html("Enter Mobile Number");
			//return false;
		}

	} 
});	
/* Create Employee Form Submition End *************************************************************/



/* Create Mill Form Submition *************************************************************/
$("#create_mill").click(function() {
	
	if ($("#mill_name").val() == "") {
		$("#mill_name").css("border","1px solid #f00");
		$(".mill_name_msg").show(); $(".mill_name_msg").html("Enter Mill Name");
		return false;
	} else {
		$("#mill_name").css("border","1px solid #dee2e6"); $(".mill_name_msg").hide(); $(".mill_name_msg").html("");
	}

	if ($("#name_1").val() == "") {
		$("#name_1").css("border","1px solid #f00");
		$(".name_1_msg").show(); $(".name_1_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#name_1").val())) {
			$("#name_1").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".name_1_msg").show(); $(".name_1_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#name_1").css("border","1px solid #dee2e6"); $(".name_1_msg").hide(); $(".name_1_msg").html("");
		}
	
		
		if ($("#email_1").val() == "") {
			$("#email_1").css("border","1px solid #f00");
			$(".email_1_msg").show(); $(".email_1_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#email_1").val())){
				$("#email_1").css("border","1px solid #f00");
				$(".email_1_msg").show(); $(".email_1_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#email_1").css("border","1px solid #dee2e6"); $(".email_1_msg").hide(); $(".email_1_msg").html("");
			} 
		} 
		
		if ($("#mobile_1").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#mobile_1').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#mobile_1").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".mobile_1_msg").show(); $(".mobile_1_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#mobile_1").css("border","1px solid #dee2e6"); $(".mobile_1_msg").hide(); $(".mobile_1_msg").html("");} 
			} else {
				$("#mobile_1").css("border","1px solid #f00");
				$(".mobile_1_msg").show(); $(".mobile_1_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#mobile_1").css("border","1px solid #f00");
			//$(".mobile_1_msg").show(); $(".mobile_1_msg").html("Enter Mobile Number");
			//return false;
		}
	} 


if ($("#name_2").val()) {
	if ($("#name_2").val() == "") {
		$("#name_2").css("border","1px solid #f00");
		$(".name_2_msg").show(); $(".name_2_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#name_2").val())) {
			$("#name_2").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".name_2_msg").show(); $(".name_2_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#name_2").css("border","1px solid #dee2e6"); $(".name_2_msg").hide(); $(".name_2_msg").html("");
		}
	
		
		if ($("#email_2").val() == "") {
			$("#email_2").css("border","1px solid #f00");
			$(".email_2_msg").show(); $(".email_2_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#email_2").val())){
				$("#email_2").css("border","1px solid #f00");
				$(".email_2_msg").show(); $(".email_2_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#email_2").css("border","1px solid #dee2e6"); $(".email_2_msg").hide(); $(".email_2_msg").html("");
			} 
		} 
		
		if ($("#mobile_2").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#mobile_2').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#mobile_2").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".mobile_2_msg").show(); $(".mobile_2_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#mobile_2").css("border","1px solid #dee2e6"); $(".mobile_2_msg").hide(); $(".mobile_2_msg").html("");} 
			} else {
				$("#mobile_2").css("border","1px solid #f00");
				$(".mobile_2_msg").show(); $(".mobile_2_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#mobile_2").css("border","1px solid #f00");
			//$(".mobile_2_msg").show(); $(".mobile_2_msg").html("Enter Mobile Number");
			//return false;
		}
	} 
}


if ($("#name_3").val()) {
	if ($("#name_3").val() == "") {
		$("#name_3").css("border","1px solid #f00");
		$(".name_3_msg").show(); $(".name_3_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#name_3").val())) {
			$("#name_3").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".name_3_msg").show(); $(".name_3_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#name_3").css("border","1px solid #dee2e6"); $(".name_3_msg").hide(); $(".name_3_msg").html("");
		}
	
		
		if ($("#email_3").val() == "") {
			$("#email_3").css("border","1px solid #f00");
			$(".email_3_msg").show(); $(".email_3_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#email_3").val())){
				$("#email_3").css("border","1px solid #f00");
				$(".email_3_msg").show(); $(".email_3_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#email_3").css("border","1px solid #dee2e6"); $(".email_3_msg").hide(); $(".email_3_msg").html("");
			} 
		} 
		
		if ($("#mobile_3").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#mobile_3').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#mobile_3").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".mobile_3_msg").show(); $(".mobile_3_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#mobile_3").css("border","1px solid #dee2e6"); $(".mobile_3_msg").hide(); $(".mobile_3_msg").html("");} 
			} else {
				$("#mobile_3").css("border","1px solid #f00");
				$(".mobile_3_msg").show(); $(".mobile_3_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#mobile_3").css("border","1px solid #f00");
			//$(".mobile_3_msg").show(); $(".mobile_3_msg").html("Enter Mobile Number");
			//return false;
		}
	} 
}


if ($("#name_4").val()) {
	if ($("#name_4").val() == "") {
		$("#name_4").css("border","1px solid #f00");
		$(".name_4_msg").show(); $(".name_4_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#name_4").val())) {
			$("#name_4").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".name_4_msg").show(); $(".name_4_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#name_4").css("border","1px solid #dee2e6"); $(".name_4_msg").hide(); $(".name_4_msg").html("");
		}
	
		
		if ($("#email_4").val() == "") {
			$("#email_4").css("border","1px solid #f00");
			$(".email_4_msg").show(); $(".email_4_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#email_4").val())){
				$("#email_4").css("border","1px solid #f00");
				$(".email_4_msg").show(); $(".email_4_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#email_4").css("border","1px solid #dee2e6"); $(".email_4_msg").hide(); $(".email_4_msg").html("");
			} 
		} 
		
		if ($("#mobile_4").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#mobile_4').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#mobile_4").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".mobile_4_msg").show(); $(".mobile_4_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#mobile_4").css("border","1px solid #dee2e6"); $(".mobile_4_msg").hide(); $(".mobile_4_msg").html("");} 
			} else {
				$("#mobile_4").css("border","1px solid #f00");
				$(".mobile_4_msg").show(); $(".mobile_4_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#mobile_4").css("border","1px solid #f00");
			//$(".mobile_4_msg").show(); $(".mobile_4_msg").html("Enter Mobile Number");
			//return false;
		}
	} 
}


if ($("#name_5").val()) {
	if ($("#name_5").val() == "") {
		$("#name_5").css("border","1px solid #f00");
		$(".name_5_msg").show(); $(".name_5_msg").html("Enter Name");
		return false;
	} else { 
		if ($.isNumeric($("#name_5").val())) {
			$("#name_5").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".name_5_msg").show(); $(".name_5_msg").html("Remove Number from Name");
	  		return false;
		} else {
			$("#name_5").css("border","1px solid #dee2e6"); $(".name_5_msg").hide(); $(".name_5_msg").html("");
		}
	
		
		if ($("#email_5").val() == "") {
			$("#email_5").css("border","1px solid #f00");
			$(".email_5_msg").show(); $(".email_5_msg").html("Enter Email");
			return false;
		} else { 
			if(!validateEmail($("#email_5").val())){
				$("#email_5").css("border","1px solid #f00");
				$(".email_5_msg").show(); $(".email_5_msg").html("Enter Valid Email");
				return false;
			} else {
				$("#email_5").css("border","1px solid #dee2e6"); $(".email_5_msg").hide(); $(".email_5_msg").html("");
			} 
		} 
		
		if ($("#mobile_5").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#mobile_5').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#mobile_5").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".mobile_5_msg").show(); $(".mobile_5_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#mobile_5").css("border","1px solid #dee2e6"); $(".mobile_5_msg").hide(); $(".mobile_5_msg").html("");} 
			} else {
				$("#mobile_5").css("border","1px solid #f00");
				$(".mobile_5_msg").show(); $(".mobile_5_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			//$("#mobile_5").css("border","1px solid #f00");
			//$(".mobile_5_msg").show(); $(".mobile_5_msg").html("Enter Mobile Number");
			//return false;
		}
	} 
}
});	
/* Create Mill Form Submition End *************************************************************/


/* Create Employee Form Submition *************************************************************
$("#create_employee").click(function() {


	if ($("#emp_name").val() == "") {
		$("#emp_name").css("border","1px solid #f00");
		$(".emp_name_msg").show(); $(".emp_name_msg").html("Enter Employee Name");
		return false;
	} else { 
		if ($.isNumeric($("#emp_name").val())) {
			$("#emp_name").css("border","1px solid #f00");
			//alert("Enter Person Name");
			$(".emp_name_msg").show(); $(".emp_name_msg").html("Remove Number from Employee Name");
	  		return false;
		} else {
			$("#emp_name").css("border","1px solid #dee2e6"); $(".emp_name_msg").hide(); $(".emp_name_msg").html("");
		}
	
		
		if ($("#emp_email").val() == "") {
			$("#emp_email").css("border","1px solid #f00");
			$(".emp_email_msg").show(); $(".emp_email_msg").html("Enter Employee Email");
			return false;
		} else { 
			if(!validateEmail($("#emp_email").val())){
				$("#emp_email").css("border","1px solid #f00");
				$(".emp_email_msg").show(); $(".emp_email_msg").html("Enter Valid Employee Email");
				return false;
			} else {
				$("#emp_email").css("border","1px solid #dee2e6"); $(".emp_email_msg").hide(); $(".emp_email_msg").html("");
			} 
		} 
		
		if ($("#emp_mobile").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#emp_mobile').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
					$("#emp_mobile").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
					$(".emp_mobile_msg").show(); $(".emp_mobile_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#emp_mobile").css("border","1px solid #dee2e6"); $(".emp_mobile_msg").hide(); $(".emp_mobile_msg").html("");} 
			} else {
				$("#emp_mobile").css("border","1px solid #f00");
				$(".emp_mobile_msg").show(); $(".emp_mobile_msg").html("Enter valid Mobile Number");
				return false;
			}
		}  else{
			$("#emp_mobile").css("border","1px solid #f00");
			$(".emp_mobile_msg").show(); $(".emp_mobile_msg").html("Enter Mobile Number");
			return false;
		}

	} 
});	
/* Create Employee Form Submition End *************************************************************/





});