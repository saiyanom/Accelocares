<?php 
	ob_start();
	require_once("../includes/initialize.php"); 
	require '../PHPMailer/PHPMailerAutoload.php';
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	////date_default_timezone_set('Asia/Calcutta');

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("my-cvc.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("my-cvc.php");
		}
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){

		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Document.");
			redirect_to("my-cvc.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Document.");
			redirect_to("my-cvc.php");
		}
	} else {
		$session->message("Complaint Not Found");
		redirect_to("my-cvc.php");
	}
	
	if ($session->is_employee_logged_in()){ 
		$employee_reg = EmployeeReg::find_by_id($session->employee_id);

		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != 'Employee' Limit 1";

		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);

		if(!$employee_location){
			redirect_to("logout.php?"); 
		}
	} else { redirect_to("logout.php"); }

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$cvc_meeting = CvcMeeting::find_by_id($_GET['id']);
	} else {
		$session->message("Meeting Not Found");
		redirect_to("my-cvc.php");
	}
?>

<form action="<?php echo "cvc-meeting-db.php?id={$_GET['id']}"; ?>" method="post" enctype="multipart/form-data" autocomplete="off">

<div class="form-group">
	<label><strong>Name</strong></label>
	<p><?php echo $cvc_meeting->emp_name; ?></p>
</div>
	
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

<?php 
if(strtolower($employee_reg->emp_email) == "mehernosh.percy@mahindra.com" || strtolower($employee_reg->emp_email) == "salvi.suvarna@mahindra.com" || strtolower($employee_reg->emp_email) == "issar.sumit@mahindra.com" || strtolower($employee_reg->emp_email) == "arora.vijay@mahindra.com"){
	
} else {
	if($session->employee_id == $cvc_meeting->emp_id) {
?>	
<div class="form-group" id="meeting_status" <?php if($cvc_meeting->status != 0){ echo "style='display:none;'";}?>>
	<label class="control-label"><strong>Meeting Done</strong></label> <br />
	<input type="button" class="btn meeting_yes btn-light" value="Yes" />   
	<input type="button" class="btn meeting_no btn-light" value="No" />
	<input type="button" class="btn meeting_reschedule btn-light" value="Reschedule" />
	<input type="hidden" class="meeting_val" name="meeting_status" value="<?php echo $cvc_meeting->meeting_status; ?>" />
	<span class="err_msg meeting_status_msg"></span>
	<div class="clerfix"></div>
</div>
<?php }} ?>	


<div class="form-group" <?php if($cvc_meeting->status == 0){ echo "style='display:none;'";}?>>
	<label class="control-label"><strong>Meeting Done</strong></label> <br />
	<p><?php echo $cvc_meeting->meeting_status; ?></p>
	<div class="clerfix"></div>
</div>
	
<div class="form-group" id="discussions">
	<label class="control-label"><strong>Discussions</strong></label>
	<div class="input-group" <?php if($cvc_meeting->status != 0){ echo "style='display:none;'";}?>>
		<div class="input-group-prepend">
			<span class="input-group-text clear_img mom_document" title="Clear Image">X</span>
		</div>
		<div class="custom-file">
			<input type="file" name="discussion_document" class="custom-file-input" id="discussion_document">
			<label class="custom-file-label" for="discussion_document">Upload Discussions document</label>
		</div>
	</div>
	<span <?php if($cvc_meeting->status != 0){ echo "style='display:none;'";}?> class="sdcon">(Please use .JPG or .PDF file format)</span>
	<p <?php if($cvc_meeting->status != 0){ echo "style='display:none;'";}?> class="colost2 paddi5">Action To Be Taken</p>

	<textarea <?php if($cvc_meeting->status != 0){ echo "style='display:none;'";}?> class="form-control form-white" name="discussion"/></textarea>
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
	
<div class="form-group" id="action_by_name" <?php if($cvc_meeting->status != 0){ echo "style='display:none;'";}?>>
	<label class="control-label"><strong>Action By</strong></label>
	<select name="action_by_name" class="form-control select2" data-toggle="select2">
		<option value="No Action Required">Select</option>
		<?php
			$employee = EmployeeReg::find_all();
			foreach($employee as $employee){
				echo "<option>{$employee->emp_name}</option>";
			}
		?>

	</select>
	<span class="err_msg action_by_name_msg"></span>
</div>

<div class="form-group" id="action_by_name_2" <?php if($cvc_meeting->status == 0){ echo "style='display:none;'";}?>>
	<label class="control-label"><strong>Action By</strong></label>
	<p <?php if($cvc_meeting->status == 0){ echo "style='display:none;'";}?>><?php echo $cvc_meeting->action_by; ?></p>
</div>
	
	

<div class="form-group" id="action_date">
	<label><strong>Date</strong></label>
	<input <?php if($cvc_meeting->status != 0){ echo "style='display:none;'";}?> type="text" class="form-control date-picker" name="action_date" data-toggle="date-picker" data-single-date-picker="true">
	<p <?php if($cvc_meeting->status == 0){ echo "style='display:none;'";}?>><?php echo date("d-m-Y", strtotime($cvc_meeting->action_date)); ?></p>
</div>
	
<div class="form-group" id="remark">
	<label class="control-label"><strong>Remark</strong></label>
	<textarea <?php if($cvc_meeting->status != 0){ echo "style='display:none;'";}?> class="form-control form-white" name="remark"/></textarea>
	<p <?php if($cvc_meeting->status == 0){ echo "style='display:none;'";}?>><?php echo $cvc_meeting->remark; ?></p>
</div>










<?php 
if(strtolower($employee_reg->emp_email) == "mehernosh.percy@mahindra.com" || strtolower($employee_reg->emp_email) == "salvi.suvarna@mahindra.com" || strtolower($employee_reg->emp_email) == "issar.sumit@mahindra.com" || strtolower($employee_reg->emp_email) == "arora.vijay@mahindra.com"){
	
} else {
	if($session->employee_id == $cvc_meeting->emp_id) {
?>	
<div <?php if($cvc_meeting->status != 0){ echo "style='display:none;'";}?> align="center">
	<a href="delete-cvc-meeting.php?id=<?php echo $_GET['id']; ?>" class="btn btn-warning text-white delete">Delete</a>
	<button type="button" class="btn fpcl" data-dismiss="modal">Cancel</button>
	<input type="submit" id="create_cvc_meeting_discuss" name="create_cvc_meeting_discuss" value="Submit" class="btn fpdone"/>
</div>
<?php }} ?>	
</form>
<?php
	$meeting_status = $cvc_meeting->meeting_status;
?>
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


        $(".select2").select2({
		  dropdownParent: $("#meeting-form2")
		});
		 
		 $('.date-picker').daterangepicker({
			singleDatePicker: true,
			locale: {
			  format: 'MM/DD/YYYY',
			}
		});
		 
		 
		$("#remark").hide();
		$("#action_date").hide();
		$("#discussions").hide();
		$(".discussion_document").hide();
		$("#action_by_name").hide();
		 
		var meeting_status = "<?php echo $meeting_status; ?>";
		 
		if(meeting_status == "Yes"){
			console.log("Yes ", meeting_status);
			$("#remark").hide();
			$("#action_date").show();
			$("#discussions").show();
			$(".discussion_document").show();
			$("#action_by_name").hide();
			$("#action_by_name_2").show();
		}
		else if(meeting_status == "No"){
			console.log("No ", meeting_status);
			$("#remark").show();
			$("#action_date").hide();
			$("#discussions").hide();
			$(".discussion_document").hide();
			$("#action_by_name").hide();
			$("#action_by_name_2").hide();
		}
		else if(meeting_status == "Reschedule"){
			console.log("Reschedule ", meeting_status);
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