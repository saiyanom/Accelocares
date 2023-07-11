<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from View CAPA Page"); redirect_to("employee-cvc.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from View CAPA Page"); redirect_to("employee-cvc.php");
		}
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Document.");
			redirect_to("employee-cvc.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Document.");
			redirect_to("employee-cvc.php");
		}

		$cvc_meeting = CvcMeeting::find_by_id($_GET['id']);
	} else {
		$session->message("Meeting Not Found");
		redirect_to("employee-cvc.php");
	}
?>

<form action="<?php echo "cvc-meeting-db.php?id={$_GET['id']}"; ?>" method="post" enctype="multipart/form-data" autocomplete="off">

<div class="form-group">
	<label><strong>Date</strong></label>
	<p><?php echo date("d-m-Y", strtotime($cvc_meeting->meeting_date)); ?></p>
</div>

<div class="form-group">
	<label class="control-label"><strong>Customer</strong></label>
	<p><?php echo $cvc_meeting->comp_name; ?></p>
</div>

<div class="form-group">
	<label class="control-label"><strong>Place</strong></label>
	<p><?php echo $cvc_meeting->place; ?></p>
</div>

<div class="form-group">
	<label class="control-label"><strong>Objective</strong></label>
	<p><?php echo $cvc_meeting->meeting_objective; ?></p>
</div>

<div class="form-group" <?php if($cvc_meeting->status == 0){ echo "style='display:none;'";}?>>
	<label class="control-label"><strong>Meeting Done</strong></label> <br />
	<p><?php echo $cvc_meeting->meeting_status; ?></p>
	<div class="clerfix"></div>
</div>

<div class="form-group" <?php if($cvc_meeting->meeting_status != 'Yes'){ echo "style='display:none;'";}?>>
	<label class="control-label"><strong>Discussions</strong></label>
	<p <?php if($cvc_meeting->status == 0){ echo "style='display:none;'";}?> style="word-wrap: break-word;"><?php 
		//echo $cvc_meeting->discussion; 
		if(!empty($cvc_meeting->discussion)){
			echo $cvc_meeting->discussion;
		} 
		if(!empty($cvc_meeting->discussion_document)){
			echo "<br /><a target='_blank' class='fancybox-thumbs' data-fancybox-group='thumb' href='../document/cvc/{$cvc_meeting->emp_id}/{$cvc_meeting->discussion_document}'>View Document</a>";
		}
	?></p>
</div>	

<div class="form-group" id="action_date">
	<label><strong>Date</strong></label>
	<p <?php if($cvc_meeting->status == 0){ echo "style='display:none;'";}?>><?php echo date("d-m-Y", strtotime($cvc_meeting->action_date)); ?></p>
</div>
	
<div class="form-group" id="remark">
	<label class="control-label"><strong>Remark</strong></label>
	<p <?php if($cvc_meeting->status == 0){ echo "style='display:none;'";}?>><?php echo $cvc_meeting->remark; ?></p>
</div>



<div class="form-group" id="action_by_name_2" <?php if($cvc_meeting->status == 0){ echo "style='display:none;'";} if($cvc_meeting->meeting_status != 'Yes'){ echo "style='display:none;'";}?>>
	<label class="control-label"><strong>Action By</strong></label>
	<p <?php if($cvc_meeting->status == 0){ echo "style='display:none;'";}?>><?php echo $cvc_meeting->action_by; ?></p>
</div>


</form>

<script>
	 $(document).ready(function(){
		 
		 $('input[type=file]').change(function(e){		
			var fileName = e.target.files[0].name;
			$(this).closest('div').find('label').html(fileName);
			//alert('The file "' + fileName +  '" has been selected. - ');
		});

		 $(".clear_img").click(function (e) {
			$(this).closest('#discussions').find('.custom-file label').html('Upload Discussions document');
			$(this).closest('#discussions').find('.custom-file input').val('');
		});

		 $('.delete').click(function() {
			var x = confirm("Are you sure you want Delete this Meeting");
			if (x){
				return true;
			} else{
				return false;
			}
		});
		 
		 $('.date-picker').daterangepicker({
			singleDatePicker: true,
			locale: {
			  format: 'DD/MM/YYYY',
			}
		});
		 
		 
		$("#remark").hide();
		$("#action_date").hide();
		$("#discussions").hide();
		$(".discussion_document").hide();
		$("#action_by_name").hide();
		 
		 
		if($(".meeting_val").val() == "Yes"){
			$("#remark").hide();
			$("#action_date").show();
			$("#discussions").show();
			$(".discussion_document").show();
			$("#action_by_name").hide();
			$("#action_by_name_2").show();
		}
		else if($(".meeting_val").val() == "No"){
			$("#remark").show();
			$("#action_date").hide();
			$("#discussions").hide();
			$(".discussion_document").hide();
			$("#action_by_name").hide();
			$("#action_by_name_2").hide();
		}
		else if($(".meeting_val").val() == "Reschedule"){
			$("#remark").show();
			$("#action_date").show();
			$("#discussions").hide();
			$(".discussion_document").hide();
			$("#action_by_name").hide();
			$("#action_by_name_2").hide();
		} 

    });
	
	$("#meeting_status .btn").click(function (e) {
		$("#meeting_status .btn").removeClass('btn-primary');		
		$("#meeting_status .btn").addClass('btn-light');		
		$(".meeting_val").val($(this).attr('value'));	
		
		$(this).removeClass('btn-light');		
		$(this).addClass('btn-primary');		
		
		
		if($(this).attr('value') == "Yes"){
			$("#remark").hide();
			$("#action_date").show();
			$("#discussions").show();
			$("#action_by_name").show();
		}
		else if($(this).attr('value') == "No"){
			$("#remark").show();
			$("#action_date").hide();
			$("#discussions").hide();
			$("#action_by_name").hide();
		}
		else if($(this).attr('value') == "Reschedule"){
			$("#remark").show();
			$("#action_date").show();
			$("#discussions").hide();
			$("#action_by_name").hide();
		}
		else {
			$("#remark").hide();
			$("#action_date").hide();
			$("#discussions").hide();
			$("#action_by_name").hide();
		}
		
	});
		
		
	$("#create_cvc_meeting_discuss").click(function() {		
		
		if ($(".meeting_val").val() == "") {
			$(".meeting_val").css("border","1px solid #f00");
			//alert("Select Meeting Date");
			$(".meeting_status_msg").show(); $(".meeting_status_msg").html("Select Meeting Status");
			return false;
		} else { $(".meeting_val").css("border","1px solid #dee2e6"); $(".meeting_status_msg").hide(); $(".meeting_status_msg").html("");} 

	 });
		
</script>
<style>
	.delete {
		padding: 8px 30px;
		margin: 0 10px;
		border-radius: 8px;
		color: #fff;
	}
	.select2-container {
		width: 100% !important;
	}
	span.err_msg{
		color: #f00;
		font-size: 12px;
		/*display: none;*/
	}
</style>