// JavaScript Document
$(document).ready(function() {

	function isValid(str) {
	    //return !/[~`!#$%\^&*()+=\\[\]\\';,/{}|\\":<>\?]/g.test(str);
	    return !/[~`!#$%\^&*+=\\[\]\\;/{}|\\:<>\?]/g.test(str);
	}

	$("input, textarea").keypress(function(event) {
	    var character = String.fromCharCode(event.keyCode);
	    return isValid(character);  
	});
	

	if($(".id_source_val").val() == "Mill"){
		$(".select_mill").show();	
    $(".other_source_div").hide(); 

		$(".id_source .btn").removeClass('btn-light');		
		$(".id_source .btn").removeClass('btn-primary');		

    $(".id_source .id_source_plant, .id_source_other").addClass('btn-light');
    $(".id_source .id_source_mil").addClass('btn-primary');

	} else if($(".id_source_val").val() == "Plant"){
		$(".select_mill, .other_source_div").hide(); 
		$(".id_source .btn").removeClass('btn-light');		
		$(".id_source .btn").removeClass('btn-primary');		

    $(".id_source .id_source_mil, .id_source_other").addClass('btn-light');
    $(".id_source .id_source_plant").addClass('btn-primary');

	}
  else if($(".id_source_val").val() == "Other"){
    $(".select_mill").hide(); 
    $(".other_source_div").show(); 

    $(".id_source .btn").removeClass('btn-light');    
    $(".id_source .btn").removeClass('btn-primary');  

    $(".id_source .id_source_mil, .id_source_plant").addClass('btn-light');
    $(".id_source .id_source_other").addClass('btn-primary');
  }


	$(".id_source .btn").click(function (e) {
		$(".id_source .btn").removeClass('btn-primary');		
		$(".id_source .btn").addClass('btn-light');		
		$(this).removeClass('btn-light');		
		$(this).addClass('btn-primary');		
		
		$(".id_source_val").val($(this).attr('value'));	
		
		if($(this).attr('value') == "Mill"){
			$(".select_mill").show();	
      $(".other_source_div").hide(); 
		}
    else if($(this).attr('value') == "Other"){
      $(".select_mill").hide(); 
      $(".other_source_div").show(); 
    }
    else { 
      $(".select_mill, .other_source_div").hide(); 
    }
	});
	
// ***************************************************************************
	
	if($(".client_contacted_val").val() == "Yes"){
		$(".client_contacted .btn").removeClass('btn-light');		
		$(".client_contacted .btn").removeClass('btn-primary');		
		$(".client_contacted .client_contacted_yes").addClass('btn-primary');			
		$(".client_contacted .client_contacted_no").addClass('btn-light');		
	} else if($(".client_contacted_val").val() == "No"){
		$(".client_contacted .btn").removeClass('btn-light');		
		$(".client_contacted .btn").removeClass('btn-primary');		
		$(".client_contacted .client_contacted_yes").addClass('btn-light');			
		$(".client_contacted .client_contacted_no").addClass('btn-primary');		
	}

	$(".client_contacted .btn").click(function (e) {
		$(".client_contacted .btn").removeClass('btn-primary');		
		$(".client_contacted .btn").addClass('btn-light');		
		$(".client_contacted_val").val($(this).attr('value'));	
		
		$("#identify_source_remark").show();
		$(this).removeClass('btn-light');		
		$(this).addClass('btn-primary');		
	});	
	
// ***************************************************************************	
	
	

	$(".request_visit .btn").click(function (e) {
		$(".request_visit .btn").removeClass('btn-primary');		
		$(".request_visit .btn").addClass('btn-light');		
		$(".request_visit_val").val($(this).attr('value'));	
		
		$(this).removeClass('btn-light');		
		$(this).addClass('btn-primary');	
		
		if($(this).attr('value') == "Yes"){
			$("#calendar").show();
			$(".request_remark").hide();
		} else {
			$("#calendar").hide();
			$(".request_remark").show();
		}
		
		console.log("request ", $(this).attr('value'));
		
	});	
	
	
// ***************************************************************************	
	
	$(".visit_done_no").addClass('btn-primary');

	//$(".visit_yes").hide();	
	//$(".visit_no").show();

	$(".visit_done .btn").click(function (e) {
		$(".visit_done .btn").removeClass('btn-primary');		
		$(".visit_done .btn").addClass('btn-light');		
		$(".visit_done_val").val($(this).attr('value'));	
		
		$(this).removeClass('btn-light');		
		$(this).addClass('btn-primary');	

		if($(this).attr('value') == "Yes"){
			$(".visit_yes").show();	
			$(".visit_no").hide();
		} else {
			$(".visit_yes").hide();	
			$(".visit_no").show();
		}	
	});

	$("#product_status_specify").hide();
	
	$('#product_status').change(function(){
				
        if ($(this).val() == "Others") {
            $("#product_status_specify").show();
        } else {
			$("#product_status_specify").hide();
		}
    });
	
	
// ***************************************************************************	
	
	var plant_num = 0;
	for (num = 1; num <= 3; num++) { 
		if($("#plant_img_txt_"+num).val() == null){
			var div = "<div class='input-group plant-img-row plant_img_row_"+ num +"'><div class='input-group-prepend'><span class='input-group-text clear_img clear_img_"+ num +"' title='Clear Image'>X</span></div><div class='custom-file'><input type='file' name='plant_img_"+ num +"' class='custom-file-input' id='plant_img_"+ num +"'><label class='custom-file-label' for='plant_img_"+ num +"'>Upload plant image</label></div></div>";
			$(".plant_img").append(div);
			$(".plant_img_row_"+ num).hide();
		} else {
			plant_num = num;
		}
		
	}

	
	$('input[type=file]').change(function(e){		
		var fileName = e.target.files[0].name;
		$(this).closest('div').find('label').html(fileName);
		//alert('The file "' + fileName +  '" has been selected. - ');
	});	

	$(".clear_img").click(function (e) {
		$(this).closest('.product-img-row').find('.custom-file label').html('Upload Image');
		$(this).closest('.product-img-row').find('.custom-file input').val('');
	});

	$(".mom_document").click(function (e) {
		$("#mom_document").val('');
		$("#mom_document").closest('div').find('label').html('Upload MOM Document');
	});

	$(".clear_img").click(function (e) {
		$(this).closest('.plant-img-row').find('.custom-file label').html('Upload Plant Image');
		$(this).closest('.plant-img-row').find('.custom-file input').val('');
		$(this).closest('.plant-img-row').find('.custom-file input[type=text]').val('');		
	});
	
	
	var num = plant_num;
	
	$(".add_plant_img").click(function (e) {
		if(num < 3){
			num++;
			$(".plant_img_row_"+ num).show();
			//console.log(num);	
		} 
		e.preventDefault();
	});
	
	$(".rem_plant_img").click(function (e) {
		if(num >= 2){
			$(".plant_img_row_"+ num).hide();	
			$(".plant_img_row_"+ num +" input").val(''); 
			//console.log(num);
			num--;
		}
		e.preventDefault();
	});	


/*	
	$(".add_plant_img").click(function (e) {
		var num = $(".plant-img-row").length + 1;
		if(num <= 5){
			var div ="<div class='input-group plant-img-row plant_img_row_"+ num +"'><div class='custom-file'><input type='file' name='plant_img_"+ num +"' class='custom-file-input' id='plant_img_"+ num +"'><label class='custom-file-label' for='plant_img_"+ num +"'>Upload plant image</label></div></div>";
			//var div = "<li class='resit-act1 plant-img-row plant_img_row_"+ num +"' style='margin: 15px 0;'><div class='input-group'><div class='custom-file'><input type='file' name='plant_img_"+ num +"' class='custom-file-input' id='inputGroupFile"+ num +"'><label class='custom-file-label' for='inputGroupFile"+ num +"'>Upload Image</label></div></div></li>";
			$(".plant_img").append(div);
		} 		
			
		e.preventDefault();
	});
	
	$(".rem_plant_img").click(function (e) {
		var num = $(".plant-img-row").length;		
		if(num >= 2){
			$(".plant_img_row_"+ num).remove();
		}
		e.preventDefault();
	});	
*/
	
// ***************************************************************************	

	$("#complaint_remark").hide();
	$("#recommended_advice").hide();
	$("#other_advice").hide();
	$("#action_by_name").hide();

	if($('#recommended_advice input[name=recommended_advice]:checked').val() == "Others") {
		 $("#other_advice").show();
	} 
	
	$('#recommended_advice input:radio').change(
    function(){
        if ($(this).is(':checked') && $(this).val() == "Others") {
            $("#other_advice").show();
        } else {
			$("#other_advice").hide();
		}
    });
	

	if($(".complaint_accepted_val").val() == "Yes"){
		$("#complaint_remark").hide();
		$("#recommended_advice").show();
		$("#action_by_name").show();		
	}
	else if($('.complaint_accepted_val').val() == "No"){	
		$("#complaint_remark").show();
		$("#recommended_advice").hide();
		
		$("#action_by_name").hide();		
	}
	else if($('.complaint_accepted_val').val() == "Decision Pending"){
		$("#complaint_remark").show();
		$("#recommended_advice").hide();
		$("#action_by_name").show();		
	}
	else {		
		$("#complaint_remark").hide();
		$("#recommended_advice").hide();
		$("#action_by_name").hide();		
	}


	$(".complaint_accepted .btn").click(function (e) {
		$(".complaint_accepted .btn").removeClass('btn-primary');		
		$(".complaint_accepted .btn").addClass('btn-light');		
		$(".complaint_accepted_val").val($(this).attr('value'));	
		
		$(this).removeClass('btn-light');		
		$(this).addClass('btn-primary');		
		
		
		if($(this).attr('value') == "Yes"){
			
			$("#complaint_remark").hide();
			$("#recommended_advice").show();
			$("#action_by_name").show();
			
		}
		else if($(this).attr('value') == "No"){
			
			$("#complaint_remark").show();
			$("#recommended_advice").hide();
			
			$("#action_by_name").hide();
			
		}
		else if($(this).attr('value') == "Decision Pending"){
			
			$("#complaint_remark").show();
			$("#recommended_advice").hide();
			$("#action_by_name").show();
			
		}
		else {
			
			$("#complaint_remark").hide();
			$("#recommended_advice").hide();
			$("#action_by_name").hide();
			
		}
		
	});
		
	
// ***************************************************************************
	
	if($(".create_approval_note_val").val() == "Yes"){
		$(".create_approval_note .btn").removeClass('btn-light');		
		$(".create_approval_note .btn").removeClass('btn-primary');		
		$(".create_approval_note .create_approval_note_yes").addClass('btn-primary');			
		$(".create_approval_note .create_approval_note_no").addClass('btn-light');	
		$(".approval_note").show();
	} else if($(".create_approval_note_val").val() == "No"){
		$(".create_approval_note .btn").removeClass('btn-light');		
		$(".create_approval_note .btn").removeClass('btn-primary');		
		$(".create_approval_note .create_approval_note_yes").addClass('btn-light');			
		$(".create_approval_note .create_approval_note_no").addClass('btn-primary');	
		$(".approval_note").hide();
	}
	
	if($(".create_approval_note_val").val() == "Yes"){
		$(".approval_note").show();
	} else { $(".approval_note").hide(); }

	$(".create_approval_note .btn").click(function (e) {
		$(".create_approval_note .btn").removeClass('btn-primary');		
		$(".create_approval_note .btn").addClass('btn-light');		
		$(".create_approval_note_val").val($(this).attr('value'));	
		
		if($(this).attr('value') == "Yes"){
			$(".approval_note").show();
		} else { $(".approval_note").hide(); }
		$(this).removeClass('btn-light');		
		$(this).addClass('btn-primary');		
	});	
	
// ***************************************************************************		
	

	if($('#approval_action_taken input[name=approval_action_taken]:checked').val() == "Others") {
		 $("#approval_action_taken_specify").show();
	} else {
		$("#approval_action_taken_specify").hide();	
	}

	
	$('.approval_action_taken:radio').change(function(){
		
		console.log($(this).val());
		
        if ($(this).is(':checked') && $(this).val() == "Others") {
            $("#approval_action_taken_specify").show();
        } else {
			$("#approval_action_taken_specify").hide();
		}
    });
	
	
	
// ***************************************************************************	
	
	if($(".settlement_val").attr('value') == "Rejection"){
		$(".settlement_rej_box").show();
		$(".settlement_com_box").hide();		
		
		$(".settlement .btn").removeClass('btn-primary');	
		$(".settlement_rej").addClass('btn-primary');		
		$(".settlement_com").addClass('btn-light');	
		
		
	} else if($(".settlement_val").attr('value') == "Commercial"){
		$(".settlement_rej_box").hide();
		$(".settlement_com_box").show();
		
		$(".settlement .btn").removeClass('btn-primary');	
		$(".settlement_rej").addClass('btn-light');		
		$(".settlement_com").addClass('btn-primary');	
		
	} else {
		$(".settlement_rej_box").show();
		$(".settlement_com_box").hide();	
	}
	
	$(".settlement .btn").click(function (e) {
		$(".settlement .btn").removeClass('btn-primary');		
		$(".settlement .btn").addClass('btn-light');		
		$(".settlement_val").val($(this).attr('value'));	
		
		$(this).removeClass('btn-light');		
		$(this).addClass('btn-primary');	
		
		if($(this).attr('value') == "Rejection"){
			$(".settlement_rej_box").show();
			$(".settlement_com_box").hide();			
		} else if($(this).attr('value') == "Commercial"){
			$(".settlement_rej_box").hide();
			$(".settlement_com_box").show();
		}
		
	});	

// ***************************************************************************
	
	if($(".create_capa_doc_val").val() == "Yes"){
		$(".create_capa_doc .btn").removeClass('btn-light');		
		$(".create_capa_doc .btn").removeClass('btn-primary');		
		$(".create_capa_doc .create_capa_doc_yes").addClass('btn-primary');			
		$(".create_capa_doc .create_capa_doc_no").addClass('btn-light');	
		$(".capa_doc").show();
	} else if($(".create_capa_doc_val").val() == "No"){
		$(".create_capa_doc .btn").removeClass('btn-light');		
		$(".create_capa_doc .btn").removeClass('btn-primary');		
		$(".create_capa_doc .create_capa_doc_yes").addClass('btn-light');			
		$(".create_capa_doc .create_capa_doc_no").addClass('btn-primary');	
		$(".capa_doc").hide();
	}
	
	if($(".create_capa_doc_val").val() == "Yes"){
		$(".capa_doc").show();
	} else { $(".capa_doc").hide(); }

	$(".create_capa_doc .btn").click(function (e) {
		$(".create_capa_doc .btn").removeClass('btn-primary');		
		$(".create_capa_doc .btn").addClass('btn-light');		
		$(".create_capa_doc_val").val($(this).attr('value'));	
		
		if($(this).attr('value') == "Yes"){
			$(".capa_doc").show();
		} else { $(".capa_doc").hide(); }
		$(this).removeClass('btn-light');		
		$(this).addClass('btn-primary');		
	});		
	

/* Identify the Source Form Submition *************************************************************/

	$("#identify_the_source").click(function() {	

		if ($("#id_source").val() == "") {
			$(".id_source .btn").css("border","1px solid #f00");
		  	//alert("Select Product");
			$(".id_source_msg").show(); $(".id_source_msg").html("Select Identify the Source");
		  	return false;
		} else { $(".id_source .btn").css("border","1px solid #dee2e6"); $(".id_source_msg").hide(); $(".id_source_msg").html("");} 

		if ($("#id_source").val() == "Mill") {
			if ($("#select_mill").val() == "") {
				$("#select_mill").css("border","1px solid #f00");
			  	//alert("Select Product");
				$(".select_mill_msg").show(); $(".select_mill_msg").html("Select Mill");
			  	return false;
			} else { $("#select_mill").css("border","1px solid #dee2e6"); $(".select_mill_msg").hide(); $(".select_mill_msg").html("");} 
		}

		if ($("#client_contacted").val() == "") {
			$(".client_contacted .btn").css("border","1px solid #f00");
		  	//alert("Select Product");
			$(".client_contacted_msg").show(); $(".client_contacted_msg").html("Select Yes / No");
		  	return false;
		} else { $(".client_contacted .btn").css("border","1px solid #dee2e6");} 

		if ($(".identify_source_remark").val() == "") {
			$(".identify_source_remark").css("border","1px solid #f00");
		  	//alert("Select Product");
			$(".identify_source_remark_msg").show(); $(".identify_source_remark_msg").html("Enter Remark");
		  	return false;
		} else { $(".identify_source_remark").css("border","1px solid #dee2e6"); $(".identify_source_remark_msg").hide(); $(".identify_source_remark_msg").html("");} 

	});

/* Identify the Source Form Submition *************************************************************/


/* Request a Visit Form Submition *************************************************************/

	$("#request_a_visit").click(function() {	

		if ($(".request_visit_val").val() == "") {
			$(".request_visit .btn").css("border","1px solid #f00");
		  	//alert("Select Product");
			$(".request_visit_msg").show(); $(".request_visit_msg").html("Select Yes / No");
		  	return false;
		} else { $(".request_visit .btn").css("border","1px solid #dee2e6"); $(".request_visit_msg").hide(); $(".request_visit_msg").html("");} 


		if ($(".request_visit_val").val() == "No") {
			if ($("#request_remark").val() == "") {
				$("#request_remark").css("border","1px solid #f00");
			  	//alert("Select Product");
				$(".request_remark_msg").show(); $(".request_remark_msg").html("Enter Request Remark");
			  	return false;
			} else { $("#request_remark").css("border","1px solid #dee2e6"); $(".request_remark_msg").hide(); $(".request_remark_msg").html("");} 
		}  

		

	});

/* Request a Visit Form Submition *************************************************************/


/* Visit Done Form Submition *************************************************************/

	$("#visit_a_done").click(function() {	

		if ($(".visit_done_val").val() == "") {
			$(".visit_done .btn").css("border","1px solid #f00");
		  	//alert("Select Product");
			$(".visit_done_msg").show(); $(".visit_done_msg").html("Select Yes / No");
		  	return false;
		} else if ($(".visit_done_val").val() == "Yes") {
			$(".visit_done .btn").css("border","1px solid #f4f3f0"); $(".visit_done_msg").hide(); $(".visit_done_msg").html("");

			if ($("#mom_document").val() == "") {
				if ($("#mom_document_txt").val() == "") {
					if ($("#mom_written").val() == "") {
						$("#mom_written").css("border","1px solid #f00");
						//alert("Select Product");
						$(".mom_written_msg").show(); $(".mom_written_msg").html("Enter MOM Document");
						return false;
					} else { $("#mom_written").css("border","1px solid #dee2e6"); $(".mom_written_msg").hide(); $(".mom_written_msg").html("");} 
				} else { $("#mom_written").css("border","1px solid #dee2e6"); $(".mom_written_msg").hide(); $(".mom_written_msg").html("");} 
			}  else { $("#mom_written").css("border","1px solid #dee2e6"); $(".mom_written_msg").hide(); $(".mom_written_msg").html("");} 

			if ($("#mom_document").val() != "") {
				$("#mom_written").css("border","1px solid #dee2e6"); $(".mom_written_msg").hide(); $(".mom_written_msg").html("");
				/*if ($("#mom_written").val() != "") {
					$("#mom_written").css("border","1px solid #f00");
					//alert("Select Product");
					$(".mom_written_msg").show(); $(".mom_written_msg").html("Any One, Upload MOM Document OR Write MOM");
					return false;
				} else { $("#mom_written").css("border","1px solid #dee2e6"); $(".mom_written_msg").hide(); $(".mom_written_msg").html("");} */
			}  else { $("#mom_written").css("border","1px solid #dee2e6"); $(".mom_written_msg").hide(); $(".mom_written_msg").html("");} 


			if ($("#product_status").val() == "") {
				$("#product_status").css("border","1px solid #f00");
				//alert("Select Product");
				$(".product_status_msg").show(); $(".product_status_msg").html("Select Product Status");
				return false;
			} else { $("#product_status").css("border","1px solid #dee2e6"); $(".product_status_msg").hide(); $(".product_status_msg").html("");} 
		} 

		if ($(".visit_done_val").val() == "No") {
			if ($("#visit_remark").val() == "") {
				$("#visit_remark").css("border","1px solid #f00");
			  	//alert("Select Product");
				$(".visit_remark_msg").show(); $(".visit_remark_msg").html("Enter Visit Remark");
			  	return false;
			} else { $("#visit_remark").css("border","1px solid #dee2e6"); $(".visit_remark_msg").hide(); $(".visit_remark_msg").html("");} 
		}


		

	});

/* Visit Done Form Submition *************************************************************/


/* Complaint Accepted Form Submition *************************************************************/
	

	$("#complaint_a_accepted").click(function() {	

		if ($(".complaint_accepted_val").val() == "") {
			$(".complaint_accepted .btn").css("border","1px solid #f00");
		  	//alert("Select Product");
			$(".complaint_accepted_msg").show(); $(".complaint_accepted_msg").html("Select Option");
		  	return false;
		} else { $(".complaint_accepted .btn").css("border","1px solid #f4f3f0"); $(".complaint_accepted_msg").hide(); $(".complaint_accepted_msg").html("");} 


		//if ($("input").is(":not(:checked)"))
		if($('#recommended_advice input[name=recommended_advice]').is(":not(:checked)")){
			//$(".custom-radio .custom-control-label::before").css("background-color","#f00");
			//$(".custom-radio .custom-control-label::after").css("background-color","#f00");
		} 

		if (!$('#recommended_advice input[name=recommended_advice]').is(":checked")) {
	        //alert("Select Recommended / Adviced");
			$(".recommended_advice_msg").show(); $(".recommended_advice_msg").html("Select Any One Recommended / Adviced");
		  	return false;
	    } else {
			$(".recommended_advice_msg").hide(); $(".recommended_advice_msg").html("");
		}

		
		if ($(".complaint_accepted_val").val() == "Yes") {

			if($('#recommended_advice input[name=recommended_advice]:checked').val() == ""){
				$("#recommended_advice .custom-radio").css("border","1px solid #f00");
			  	//alert("Select Product");
				$(".recommended_advice_msg").show(); $(".recommended_advice_msg").html("Select Any One Recommended / Adviced");
			  	return false;
			} else { $("#recommended_advice .custom-radio").css("border","none"); $(".recommended_advice_msg").hide(); $(".recommended_advice_msg").html("");} 


			if($('#recommended_advice input[name=recommended_advice]:checked').val() == "Others") {
				if ($("#other_advice").val() == "") {
					$("#other_advice").css("border","1px solid #f00");
			  		//alert("Select Product");
					$(".other_advice_msg").show(); $(".other_advice_msg").html("Enter Recommended / Adviced");
			  		return false;
			  	} else { $("#other_advice").css("border","1px solid #dee2e6"); $(".other_advice_msg").hide(); $(".other_advice_msg").html("");} 
			} 


			if ($(".action_by_name").val() == "") {
				$(".action_by_name").css("border","1px solid #f00");
			  	//alert("Select Product");
				$(".action_by_name_msg").show(); $(".action_by_name_msg").html("Select Action by");
			  	return false;
			} else { $(".action_by_name").css("border","1px solid #dee2e6"); $(".action_by_name_msg").hide(); $(".action_by_name_msg").html("");} 

			if ($("#action_by_date").val() == "") {
				$("#action_by_date").css("border","1px solid #f00");
			  	//alert("Select Product");
				$(".action_by_date_msg").show(); $(".action_by_date_msg").html("Select Date");
			  	return false;
			} else { $("#action_by_date").css("border","1px solid #dee2e6"); $(".action_by_date_msg").hide(); $(".action_by_date_msg").html("");} 

		}

		if ($(".complaint_accepted_val").val() == "Decision Pending") {

			if ($(".complaint_remark").val() == "") {
				$(".complaint_remark").css("border","1px solid #f00");
			  	//alert("Select Product");
				$(".complaint_remark_msg").show(); $(".complaint_remark_msg").html("Enter Remark");
			  	return false;
			} else { $(".complaint_remark").css("border","1px solid #dee2e6"); $(".complaint_remark_msg").hide(); $(".complaint_remark_msg").html("");} 

			if ($(".action_by_name").val() == "") {
				$(".action_by_name").css("border","1px solid #f00");
				$(".action_by_name_msg").show(); $(".action_by_name_msg").html("Select Action by");
			  	//alert("Select Product");
			  	return false;
			} else { $(".action_by_name").css("border","1px solid #dee2e6"); $(".action_by_name_msg").hide(); $(".action_by_name_msg").html("");} 

			if ($("#action_by_date").val() == "") {
				$("#action_by_date").css("border","1px solid #f00");
			  	//alert("Select Product");
				$(".action_by_date_msg").show(); $(".action_by_date_msg").html("Select Date");
			  	return false;
			} else { $("#action_by_date").css("border","1px solid #dee2e6"); $(".action_by_date_msg").hide(); $(".action_by_date_msg").html("");} 

		}


		if ($(".complaint_accepted_val").val() == "No") {
			if ($(".complaint_remark").val() == "") {
				$(".complaint_remark").css("border","1px solid #f00");
			  	//alert("Select Product");
				$(".complaint_remark_msg").show(); $(".complaint_remark_msg").html("Enter Remark");
			  	return false;
			} else { $(".complaint_remark").css("border","1px solid #dee2e6"); $(".complaint_remark_msg").hide(); $(".complaint_remark_msg").html("");} 

		}


		

	});

/* Complaint Accepted Form Submition *************************************************************/


/* Action Taken Form Submition *************************************************************/

	$("#approval_action_a_taken").click(function() {	

		if (!$('#approval_action_taken input[name=approval_action_taken]').is(":checked")) {
	        //alert("Select Action Taken");
			$(".approval_action_taken_msg").show(); $(".approval_action_taken_msg").html("Select Action Taken");
		  	return false;
	    } else { $(".approval_action_taken_msg").hide(); $(".approval_action_taken_msg").html(""); }

	    if($('#approval_action_taken input[name=approval_action_taken]:checked').val() == "Others") {
			if ($("#approval_action_taken_specify").val() == "") {
				$("#approval_action_taken_specify").css("border","1px solid #f00");
		  		//alert("Select Product");
				$(".approval_action_taken_specify_msg").show(); $(".approval_action_taken_specify_msg").html("Specify Action Taken");
		  		return false;
		  	} else { $("#approval_action_taken_specify").css("border","1px solid #dee2e6"); $(".approval_action_taken_specify_msg").hide(); $(".approval_action_taken_specify_msg").html("");} 
		} 

	});

/* Action Taken Form Submition *************************************************************/


/* Settlement Form Submition *************************************************************/
	
	$("#settlement_done").click(function() {	

		if ($(".settlement_val").val() == "") {
			$(".settlement .btn").css("border","1px solid #f00");
			$(".settlement_msg").show(); $(".settlement_msg").html("Select Settlement");
		  	return false;
		} else { $(".settlement .btn").css("border","1px solid #f4f3f0"); $(".settlement_msg").hide(); $(".settlement_msg").html("");} 
	    
		
		if ($(".settlement_val").val() == "Rejection") {

			if ($("#reject_invoice_no").val() == "") {
				$("#reject_invoice_no").css("border","1px solid #f00");
				$(".reject_invoice_no_msg").show(); $(".reject_invoice_no_msg").html("Enter Invoice No.");
			  	return false;
			} else { $("#reject_invoice_no").css("border","1px solid #dee2e6"); $(".reject_invoice_no_msg").hide(); $(".reject_invoice_no_msg").html("");} 

			if ($("#reject_final_qty").val() == "") {
				$("#reject_final_qty").css("border","1px solid #f00");
				$(".rreject_final_qty_msg").show(); $(".reject_final_qty_msg").html("Enter Final Quantity");
			  	return false;
			} else { $("#reject_final_qty").css("border","1px solid #dee2e6"); $(".reject_final_qty_msg").hide(); $(".reject_final_qty_msg").html("");} 

			if ($("#settlement_date").val() == "") {
				$("#settlement_date").css("border","1px solid #f00");
				$(".settlement_date_msg").show(); $(".settlement_date_msg").html("Select Settlement Date");
			  	return false;
			} else { $("#settlement_date").css("border","1px solid #dee2e6"); $(".settlement_date_msg").hide(); $(".settlement_date_msg").html("");} 

			if ($("#settlement_credit_note_no").val() == "") {
				$("#settlement_credit_note_no").css("border","1px solid #f00");
				$(".settlement_credit_note_no_msg").show(); $(".settlement_credit_note_no_msg").html("Enter Credit Note No.");
			  	return false;
			} else { $("#settlement_credit_note_no").css("border","1px solid #dee2e6"); $(".settlement_credit_note_no_msg").hide(); $(".settlement_credit_note_no_msg").html("");} 

		}

		if ($(".settlement_val").val() == "Commercial") {

			if ($("#comm_amount").val() == "") {
				$("#comm_amount").css("border","1px solid #f00");
				$(".comm_amount_msg").show(); $(".comm_amount_msg").html("Enter Commercial Amount");
			  	return false;
			} else { $("#comm_amount").css("border","1px solid #dee2e6"); $(".comm_amount_msg").hide(); $(".comm_amount_msg").html("");} 

			if ($("#settlement_date").val() == "") {
				$("#settlement_date").css("border","1px solid #f00");
				$(".settlement_date_msg").show(); $(".settlement_date_msg").html("Select Settlement Date");
			  	return false;
			} else { $("#settlement_date").css("border","1px solid #dee2e6"); $(".settlement_date_msg").hide(); $(".settlement_date_msg").html("");} 

			if ($("#settlement_credit_note_no").val() == "") {
				$("#settlement_credit_note_no").css("border","1px solid #f00");
				$(".settlement_credit_note_no_msg").show(); $(".settlement_credit_note_no_msg").html("Enter Credit Note No.");
			  	return false;
			} else { $("#settlement_credit_note_no").css("border","1px solid #dee2e6"); $(".settlement_credit_note_no_msg").hide(); $(".settlement_credit_note_no_msg").html("");} 

		}


	});

/* Settlement Form Submition *************************************************************/



/* Raise Complaint Form Submition *************************************************************/
	$("#create_complaint").click(function() {	

		function validateEmail(email) {
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			return emailReg.test(email);
		}
		
		if ($("#product").val() == "") {
			$("#product").css("border","1px solid #f00");
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
		  	/*if(invoice_number.length > 20){
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


		if ($("#company").val() == "") {
			$("span.select2-selection").css("border","1px solid #f00");
		  	//alert("Select Company");
		  	$(".company_msg").show(); $(".company_msg").html("Select Company");
		  	return false;
		} else { $("span.select2-selection").css("border","1px solid #dee2e6"); $(".company_msg").hide(); $(".company_msg").html("");} 	

		
		if ($("#pl_name").val() == "") {
			$("#pl_name").css("border","1px solid #f00");
		 	//alert("Select Complaint Raised by");
			$(".pl_name_msg").show(); $(".pl_name_msg").html("Select Complaint Raised by");
		  	return false;
		} else { $("#pl_name").css("border","1px solid #dee2e6"); $(".pl_name_msg").hide(); $(".pl_name_msg").html("");} 

		
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


/* Create Complaint Meeting *************************************************************/
	$("#create_meeting").click(function() {		
		
		if ($("#meeting_date").val() == "") {
			$("#meeting_date").css("border","1px solid #f00");
		  	//alert("Select Meeting Date");
			$(".meeting_date_msg").show(); $(".meeting_date_msg").html("Select Meeting Date");
		  	return false;
		} else { $("#meeting_date").css("border","1px solid #dee2e6"); $(".meeting_date_msg").hide(); $(".meeting_date_msg").html("");} 	

		if ($("#meeting_name").val() == "") {
			$("#meeting_name").css("border","1px solid #f00");
		  	//alert("Enter Customer Coordinator");
			$(".meeting_name_msg").show(); $(".meeting_name_msg").html("Select Name");
		  	return false;
		} else { $("#meeting_name").css("border","1px solid #dee2e6"); $(".meeting_name_msg").hide(); $(".meeting_name_msg").html("");} 	

		if ($("#meeting_name").val() == "Other") {
			if ($("#meeting_name_2").val() == "") {
				$("#meeting_name_2").css("border","1px solid #f00");
			  	//alert("Enter Customer Coordinator");
				$(".meeting_name_2_msg").show(); $(".meeting_name_2_msg").html("Enter Name");
			  	return false;
			} else { $("#meeting_name_2").css("border","1px solid #dee2e6"); $(".meeting_name_2_msg").hide(); $(".meeting_name_2_msg").html("");} 
		} else { $("#meeting_name").css("border","1px solid #dee2e6");} 	

		if ($("#meeting_mobile").val() != "") {			
			var intsOnly = /^\d+$/,
			phone_num = $('#meeting_mobile').val();

			if(intsOnly.test(phone_num)) {
			   if (phone_num.length != 10) {
			   		$("#meeting_mobile").css("border","1px solid #f00");
					//alert("Enter 10 digit Mobile Number");
				   	$(".meeting_mobile_msg").show(); $(".meeting_mobile_msg").html("Enter 10 digit Mobile Number");
					return false;
				} else { $("#meeting_mobile").css("border","1px solid #dee2e6"); $(".meeting_mobile_msg").hide(); $(".meeting_mobile_msg").html("");} 	
			} else {
				$("#meeting_mobile").css("border","1px solid #f00");
				//alert("Enter valid Mobile Number");
				$(".meeting_mobile_msg").show(); $(".meeting_mobile_msg").html("Enter valid Mobile Number");
				return false;
			} 
		} else {
			//$("#meeting_mobile").css("border","1px solid #f00");
			//alert("Enter Mobile Number");
			//$(".meeting_mobile_msg").show(); $(".meeting_mobile_msg").html("Enter Mobile Number");
			//return false;
		} 



		if ($("#meeting_email").val() == "") {
			$("#meeting_email").css("border","1px solid #f00");
		  	//alert("Enter Primary Email Address");
			$(".meeting_email_msg").show(); $(".meeting_email_msg").html("Enter Email Address");
		  	return false;
		} 
		
		function isValidEmailAddress1(emailAddress1) {
			var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
			return pattern.test(emailAddress1);
		};
	
		var meeting_email = $("#meeting_email").val();

		if( !isValidEmailAddress1( meeting_email ) ) { 
			if ($("#meeting_email").val() == "") {
			 // return true;
				$(".meeting_email_msg").hide(); $(".meeting_email_msg").html("	");
			} else {
				$("#meeting_email").css("border","1px solid #f00");
				//alert("Invalid Email ID");
				$(".meeting_email_msg").show(); $(".meeting_email_msg").html("Invalid Email Address");
				return false;
			}
		}
	
		
	});
/* Create Complaint Meeting  END *************************************************************/



/* Create Credit Approval Note *************************************************************/
	$("#create_a_note").click(function() {

		var num = 0;
		
		total_qty_rejc 		      = $("#total_qty_rejc").val();
				
		qty_acpt_steel_mill 	  = $("#qty_acpt_steel_mill").val();
		qty_scrp_auc_serv_cent 	= $("#qty_scrp_auc_serv_cent").val();
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

		if($("#id_source").val() == "Plant"){
			//alert(qty_debit + " != " +total_qty_rejc);
			num++;
			$("#qty_acpt_steel_mill").css("border","1px solid #f00");
			$("#qty_scrp_auc_serv_cent").css("border","1px solid #f00");
			$("#qty_dlv_customer").css("border","1px solid #f00");
		} 	

		console.log(num);
		console.log(qty_debit + " != " +total_qty_rejc);

		if(num > 0){
			$(".approval_note_msg").show(); $(".approval_note_msg").html("The fields marked in red needs to be filled / correct information");
			return false;
		} else {
			$(".approval_note_msg").hide(); $(".approval_note_msg").html("");
		}
		

	});
/* Create Credit Approval Note  END *************************************************************/


/* Create CAPA Note *************************************************************/
	$("#save_capa").click(function() {

		var num = 0;

		$("#create-capa input[type=text]").each(function() {
			
			if ($(this).val() == "") {
				num++
				$(this).css("border","1px solid #f00");
			} else {
				//alert("Valid");
				$(this).css("border","1px solid #dee2e6");
			}	

		}); //num = num-2;

		

		if($("#team_member").val() == ""){
			num++
			$(".team_member .select2-container").css("border","1px solid #f00");
		} else {
			//alert("Valid");
			$(".team_member .select2-container").css("border","1px solid #dee2e6");
		}

		if($("#correction_who").val() == ""){
			num++
			$(".correction_who .select2-container").css("border","1px solid #f00");
		} else {
			//alert("Valid");
			$(".correction_who .select2-container").css("border","1px solid #dee2e6");
		}

		if($("#correction_action_who").val() == ""){
			num++
			$(".correction_action_who .select2-container").css("border","1px solid #f00");
		} else {
			//alert("Valid");
			$(".correction_action_who .select2-container").css("border","1px solid #dee2e6");
		}

		if($("#verify_who").val() == ""){
			num++
			$(".verify_who .select2-container").css("border","1px solid #f00");
		} else {
			//alert("Valid");
			$(".verify_who .select2-container").css("border","1px solid #dee2e6");
		}

		if($("#prevent_who").val() == ""){
			num++
			$(".prevent_who .select2-container").css("border","1px solid #f00");
		} else {
			//alert("Valid");
			$(".prevent_who .select2-container").css("border","1px solid #dee2e6");
		}

		$("#create-capa textarea").each(function() {
			
			if ($(this).val() == "") {
				//alert("Empty");
				num++
				$(this).css("border","1px solid #f00");
			} else {
				//alert("Valid");
				$(this).css("border","1px solid #dee2e6");
			}	

		});

		/*
		$(".team_member input").css("border","none");
		$(".correction_who input").css("border","none");


		if ($("#team_member").val() == "") {
			$(".team_member .select2-container").css("border","1px solid #f00");
		  	num++
		} else { $(".team_member .select2-container").css("border","1px solid #dee2e6"); }

		if ($("#correction_who").val() == "") {
			$(".correction_who span.select2-container").css("border","1px solid #f00");
		  	num++
		} else { $(".correction_who .select2-container").css("border","1px solid #dee2e6"); }

		if ($("#correction_action_who").val() == "") {
			$(".correction_action_who span.select2-container").css("border","1px solid #f00");
		  	num++
		} else { $(".correction_action_who .select2-container").css("border","1px solid #dee2e6"); }

		if ($("#verify_who").val() == "") {
			$(".verify_who span.select2-container").css("border","1px solid #f00");
		  	num++
		} else { $(".verify_who .select2-container").css("border","1px solid #dee2e6"); }

		if ($("#prevent_who").val() == "") {
			$(".prevent_who span.select2-container").css("border","1px solid #f00");
		  	num++
		} else { $(".prevent_who .select2-container").css("border","1px solid #dee2e6"); }
		*/


		console.log(num);

		if(num > 0){
			$(".capa_msg").show(); $(".capa_msg").html("The fields marked in red needs to be filled / correct information");
			return false;
		} else {
			$(".capa_msg").hide(); $(".capa_msg").html("");
		}
		
		
		
		


	});
/* Create CAPA Note  END *************************************************************/










	
	
});