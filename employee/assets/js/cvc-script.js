/* Create Complaint Meeting *************************************************************/
	$("#create_cvc_meeting").click(function() {		
		
		if ($("#meeting_date").val() == "") {
			$("#meeting_date").css("border","1px solid #f00");
		  	//alert("Select Meeting Date");
			$(".meeting_date_msg").show(); $(".meeting_date_msg").html("Select Meeting Date");
		  	return false;
		} else { $("#meeting_date").css("border","1px solid #dee2e6"); $(".meeting_date_msg").hide(); $(".meeting_date_msg").html("");} 	

		if ($("#company").val() == "") {
			$("#company").css("border","1px solid #f00");
		  	//alert("Enter Customer Coordinator");
			$(".company_msg").show(); $(".company_msg").html("Select Company");
		  	return false;
		} else { $("#company").css("border","1px solid #dee2e6"); $(".company_msg").hide(); $(".company_msg").html("");} 	
		
		
		if ($("#place").val() == "") {
			$("#place").css("border","1px solid #f00");
		  	//alert("Enter Customer Coordinator");
			$(".place_msg").show(); $(".place_msg").html("Enter Place");
		  	return false;
		} else { $("#place").css("border","1px solid #dee2e6"); $(".place_msg").hide(); $(".place_msg").html("");} 
		
		
		if ($("#meeting_objective").val() == "") {
			$("#meeting_objective").css("border","1px solid #f00");
		  	//alert("Enter Customer Coordinator");
			$(".meeting_objective_msg").show(); $(".meeting_objective_msg").html("Enter Meeting Objective");
		  	return false;
		} else { $("#meeting_objective").css("border","1px solid #dee2e6"); $(".meeting_objective_msg").hide(); $(".meeting_objective_msg").html("");} 
		
		
		

		
	
		
	});
/* Create Complaint Meeting  END *************************************************************/