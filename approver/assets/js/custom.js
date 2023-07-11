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
	


	/* Create Credit Approval Note *************************************************************/
	$("#approve_approval_note").click(function() {

		var num = 0;
		
		
		total_qty_rejc 		= $("#total_qty_rejc").val();
		
		
		qty_acpt_steel_mill 			= $("#qty_acpt_steel_mill").val();
		qty_scrp_auc_serv_cent 			= $("#qty_scrp_auc_serv_cent").val();
		qty_dlv_customer 				= $("#qty_dlv_customer").val();

		qty_debit						= parseFloat(qty_acpt_steel_mill) + parseFloat(qty_scrp_auc_serv_cent) + parseFloat(qty_dlv_customer)
				

		$("#create-note input").each(function() {
			
			if ($(this).val() == "") {
				if($(this).attr("class") != "form-control optional_field"){
					num++
					$(this).css("border","1px solid #f00");
				}
			} else {
				//alert("Valid");
				$(this).css("border","1px solid #dee2e6");
			}	

		});	


		$(".app_note_number").each(function() {			

		    var intsOnly = /(^-?\d\d*\.\d*$)|(^-?\d\d*$)|(^-?\.\d\d*$)/,
			app_note_number = $(this).val();

			if(intsOnly.test(app_note_number)) {
			   	$(this).css("border","1px solid #dee2e6");
			} else {
				$(this).css("border","1px solid #f00");
				num++
			} 

		});	

		 if(total_qty_rejc != qty_debit){
			alert(qty_debit + " != " +total_qty_rejc);
			 num++;
			 $("#qty_acpt_steel_mill").css("border","1px solid #f00");
			 $("#qty_scrp_auc_serv_cent").css("border","1px solid #f00");
			 $("#qty_dlv_customer").css("border","1px solid #f00");
		 } 	

	 new_total_qty_rejc = total_qty_rejc.replace(/\d+/g, '')


		console.log(num);
		console.log(qty_debit + " != " +total_qty_rejc + " = " +new_total_qty_rejc);

		if(num > 0){
			$(".approval_note_msg").show(); $(".approval_note_msg").html("The fields marked in red needs to be filled / correct information");
			return false;
		} else {
			$(".approval_note_msg").hide(); $(".approval_note_msg").html("");
		}
		

	});
/* Create Credit Approval Note  END *************************************************************/
	
	
});