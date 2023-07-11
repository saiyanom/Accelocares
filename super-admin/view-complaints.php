<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("all-complaints.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^%*()}!{><;`=+]/', $value)){
			$session->message("Found Malicious Code."); redirect_to("all-complaints.php");
		}
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){

		if(!is_numeric($_GET['id'])) {
			$session->message("Invalid Complaint.");
			redirect_to("all-complaints.php");
		}
		if(strlen($_GET['id']) < 1) {
			$session->message("Invalid Complaint.");
			redirect_to("all-complaints.php");
		}
	} else {
		$session->message("Complaint Not Found");
		redirect_to("all-complaints.php");
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$complaint_reg = Complaint::find_by_id($_GET['id']);
		
		$get_comp_id = CompanyReg::authenticate_customer_id($complaint_reg->customer_id);
		
	} else {
		$session->message("Complaint Not Found");
		redirect_to("all-complaints.php");
	}

   $sql = "Select * from approval_note where complaint_id = {$complaint_reg->id} ORDER By id desc ";
  $approval_notes = ApprovalNote::find_by_sql($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindra Accelo CRM</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content=" " name="description" />
<meta content="Coderthemes" name="author" />
<style>
	input.btn-primary, input.btn-light {
		margin-right: 4px;
	}
	.fc-right{ display:none}
	.fc-center{ float:right}
	.fc-today-button{ display:none}
	.back-btn { padding: 0 !important;}
	.mdi-keyboard-backspace {
		font-size: 24px;
		color: #0acf97;
	}
</style>	
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
	<?php  $message = output_message($message); ?>
	<div class="alert fade show text-white <?php 
		if($message == "Meeting Added Successfully"){echo "bg-success";} 
		else if($message == "Status Updated Successfully."){echo "bg-success";} 		
		else if($message == "Complaint Updated Successfully"){echo "bg-success";} 		
		else if($message == "Approval Note Created Successfully"){echo "bg-success";} 		
		else if($message == "CAPA Created Successfully"){echo "bg-success";} 	
		else if($message == "Meeting Deleted Successfully."){echo "bg-success";} 	
		else if($message == "CAPA Document Uploaded Successfully"){echo "bg-success";} 	
		else {echo "bg-danger";}?>" 
	<?php if(empty($message)){echo " style='display:none';";} else {echo " style='margin-top:20px';";} ?> >
	<a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
	<?php echo $message; ?>
	</div>
<!-- top box -->
<?php if(isset($_GET['id'])){?>
<div class="complaints-blocks">
	

<div class="cb-block">
	
	<div class="clerfix"></div>

	<!------------------------------ Data Below ---------------------------->
	
	<div id="comp_raised_2">
		
		<div class="cmp-lf"><h2><a class="btn btn-default back-btn" href="all-complaints.php"><i class="mdi mdi-keyboard-backspace"></i></a> Complaint details - <?php echo $complaint_reg->company_name; ?>   |   Complaint No. <?php echo $complaint_reg->ticket_no; ?></h2></div>
		<div class="clerfix"></div>
		<div class="tabobox">
		<div class="tabobox1">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td class="fsd-1">Product</td>
		<td class="fsd-2"><span><?php echo $complaint_reg->product; ?></span></td>
		</tr>
		<tr>
		<td class="fsd-1">Rejected Quantity</td>
		<td class="fsd-2"><span><?php echo $complaint_reg->rejected_quantity; ?></span></td>
		</tr>
		<tr>
		<td class="fsd-1">Invoice Number</td>
		<td class="fsd-2"><span><?php echo $complaint_reg->invoice_number; ?></span></td>
		</tr>
		<tr>
		<td class="fsd-1">Invoice Date</td>
		<td class="fsd-2"><span><?php echo date('d-m-Y', strtotime($complaint_reg->invoice_date)); ?></span></td>
		</tr>

     <?php if($complaint_reg->size) { ?>
      <tr>
        <td class="fsd-1">Size </td>
        <td class="fsd-2"><span><?php echo $complaint_reg->size; ?></span></td>
      </tr>
      <?php } ?>

		<tr>
		<td class="fsd-1">Defect Batch No.</td>
		<td class="fsd-2"><span><?php echo $complaint_reg->defect_batch_no; ?></span></td>
		</tr>
		<tr>
		<td class="fsd-1">Customer Id</td>
		<td class="fsd-2"><span><?php echo $complaint_reg->customer_id; ?></span></td>
		</tr>
		<tr>
		<td class="fsd-1">Business Vertical</td>
		<td class="fsd-2"><span><?php echo $complaint_reg->business_vertical; ?></span></td>
		</tr>
		</table>
		</div>
		<div class="tabobox2">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td class="fsd-1">Location</td>
		<td class="fsd-2"><span><?php echo $complaint_reg->plant_location; ?></span></td>
		</tr>
		<tr>
		<td class="fsd-1">Complaint Type</td>
		<td class="fsd-2"><span><?php echo $complaint_reg->complaint_type; ?></span></td>
		</tr>
		<tr>
		<td class="fsd-1">Sub Complaint Type</td>
		<td class="fsd-2"><span><?php echo $complaint_reg->sub_complaint_type; ?></span></td>
		</tr>
		<tr>
		<td class="fsd-1">Complaint Raised by</td>
		<td class="fsd-2"><span><?php echo $complaint_reg->pl_name; ?></span></td>
		</tr>
		<tr>
		<td class="fsd-1">Email ID</td>
		<td class="fsd-2"><span><?php echo $complaint_reg->pl_email; ?></span></td>
		</tr>
		<tr>
		<td class="fsd-1">Mobile No. </td>
		<td class="fsd-2"><span><?php echo $complaint_reg->pl_mobile; ?></span></td>
		</tr>


		</table>
		</div>
		<div class="clerfix"></div>
		<div class="tabobox1">
		<div class="bottab">
		<p class="colost1"><span>Images</span></p>
		<ul class="lip-popbox">
		<?php 
			if(!empty($complaint_reg->product_img_1)){
				echo "<li><a class='fancybox-thumbs' data-fancybox-group='thumb-top' href='../document/{$complaint_reg->ticket_no}/complaint/{$complaint_reg->product_img_1}'><img src='../document/{$complaint_reg->ticket_no}/complaint/{$complaint_reg->product_img_1}'></a></li>";
			}
			if(!empty($complaint_reg->product_img_2)){
				echo "<li><a class='fancybox-thumbs' data-fancybox-group='thumb-top' href='../document/{$complaint_reg->ticket_no}/complaint/{$complaint_reg->product_img_2}'><img src='../document/{$complaint_reg->ticket_no}/complaint/{$complaint_reg->product_img_2}'></a></li>";
			}
			if(!empty($complaint_reg->product_img_3)){
				echo "<li><a class='fancybox-thumbs' data-fancybox-group='thumb-top' href='../document/{$complaint_reg->ticket_no}/complaint/{$complaint_reg->product_img_3}'><img src='../document/{$complaint_reg->ticket_no}/complaint/{$complaint_reg->product_img_3}'></a></li>";
			}
		?>
		<div class="clerfix"></div>
		</ul>
		</div>
		</div>

		<div class="tabobox2">
		<div class="bottab">
		<p class="colost1"><span>Feedback</span></p>
		<p class="colost2"><?php echo $complaint_reg->pl_feedback; ?></p>
		</div></div>
		<div class="clerfix"></div>
		</div>
	</div>
<!-- 1 -->	

</div>
</div>
<!-- top box -->
<?php } ?>



<div class="complaints-blocks2" >
<div class="cb-block">
<!-- 1 -->
<div class="onlock">
	

	<!------------------------------ Data Below ---------------------------->
	
	<div id="id_source_2" <?php if($complaint_reg->client_contacted != "Yes"){echo "style='display:none;'";}?>>
		
		<div class="onlock-1"><p class="colost1">Identify the Source</p></div>
		<div class="onlock-2"><p class="colost2"><?php echo $complaint_reg->identify_source; ?></p></div>
		<div class="clerfix"></div>
		<?php if(!empty($complaint_reg->mill)){?>
		<div class="onlock-1"><p class="colost1">Select Mill</p></div>
		<div class="onlock-2"><p class="colost2"><?php echo $complaint_reg->mill; ?></p></div>
		<div class="clerfix"></div>
		<?php }?>

    <?php if(!empty($complaint_reg->other_source)){?>
    <div class="onlock-1"><p class="colost1">Other source</p></div>
    <div class="onlock-2"><p class="colost2"><?php echo $complaint_reg->other_source; ?></p></div>
    <div class="clerfix"></div>
    <?php }?>

		<div class="onlock-1"><p class="colost1">Customer Contacted</p></div>
		<div class="onlock-2"><p class="colost2"><?php echo $complaint_reg->client_contacted; ?></p></div>
		<div class="clerfix"></div>
		<div class="onlock-1"><p class="colost1">Remark</p></div>
		<div class="onlock-2"><p class="colost2"><?php echo $complaint_reg->identify_source_remark; ?></p></div>
		<div class="clerfix"></div>
	</div>
</div>
<!-- 1 -->

<!-- 2 -->
<div class="onlock" <?php if($complaint_reg->client_contacted == "" || $complaint_reg->client_contacted == "No"){echo "style='display:none'";} ?>>
	
		
	<!------------------------------ Data Below ---------------------------->
	<div id="request_visit_2" <?php if(empty($complaint_reg->request_visit) ){echo "style='display:none;'";}?>>
		
		<?php $complaint_meeting = ComplaintMeeting::find_by_comp_id($_GET['id']); ?>
		<div class="onlock-cov">
		<div class="onlock-3"><p class="colost1">Request a Visit</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->request_visit; ?></p></div>
		<div class="clerfix"></div>
		<?php if($complaint_reg->request_visit == "Yes"){?><div class="onlock-3"><p class="colost1">Date</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo date('d-m-Y', strtotime($complaint_meeting->meeting_date)); ?></p></div>
		<div class="clerfix"></div>
		<div class="onlock-3"><p class="colost1">Place</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_meeting->place; ?></p></div>
		</div>

		<div class="onlock-cov">
		<div class="onlock-3"><p class="colost1">Customer Coordinator</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_meeting->customer_coordinator; ?></p></div>
		<div class="clerfix"></div>
		<div class="onlock-3"><p class="colost1">Email ID</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_meeting->email; ?></p></div>
		<div class="clerfix"></div>
		<div class="onlock-3"><p class="colost1">Mobile Number</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_meeting->mobile; ?></p></div><?php } else { ?>
		<div class="clerfix"></div>
		<div class="onlock-3"><p class="colost1">Remark</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->request_remark; ?></p></div>	
		<?php } ?>	
		</div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- 2 -->

<!-- 3 -->
<div class="onlock" <?php if(!empty($complaint_reg->request_visit) != "Yes" && $complaint_reg->request_visit != "No"){echo "style='display:none'";} ?>>
	

	<!------------------------------ Data Below ---------------------------->
	<div id="visit_done_2" <?php if(empty($complaint_reg->visit_done)){echo "style='display:none;'";}?>>
		
		<div class="onlock-cov" <?php if($complaint_reg->visit_done == "Yes"){echo "style='display:none;'";}?>>
			<div class="onlock-3"><p class="colost1">Visit Done</p></div>
			<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->visit_done; ?></p></div>
			<div class="clerfix"></div>
			<div class="onlock-3"><p class="colost1">Discussion with Customer if Any</p></div>
			<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->visit_remark; ?></p></div>
			<div class="clerfix"></div>
		</div>
		
		
		
		<div class="onlock-cov" <?php if($complaint_reg->visit_done == "No"){echo "style='display:none;'";}?>>
		<div class="onlock-3"><p class="colost1">Visit Done</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->mill; ?></p>


		<div class="lrbox">
		<div class="lrbox1"><p class="colost2">MOM Document</p></div>
		<div class="lrbox2">
			<?php
			if(!empty($complaint_reg->mom_document)){
				$newstring = substr($complaint_reg->mom_document, -4);
				if($newstring == ".pdf"){
			?>
				<a target="_blank" <?php if(empty($complaint_reg->mom_document)){echo "style='display:none;'";} ?> href="<?php echo "../document/{$complaint_reg->ticket_no}/mom/{$complaint_reg->mom_document}";?>">Open Link</a><br /> 
			<?php
				} else {
			?>
				<a <?php if(empty($complaint_reg->mom_document)){echo "style='display:none;'";} ?> class="fancybox-thumbs" data-fancybox-group="thumb" href="<?php echo "../document/{$complaint_reg->ticket_no}/mom/{$complaint_reg->mom_document}";?>">Open Link</a><br /> 
			<?php
				}}
			?> 
			<a <?php if(empty($complaint_reg->mom_written)){echo "style='display:none;'";} ?> id="mom_write_doc" href="#mom_doc">View Doc</a>
		</div>
		<div style="display: none;">
			<div id="mom_doc" style="min-width: 300px; max-width: 600px; height:400px;overflow:auto;">
				<?php echo $complaint_reg->mom_written; ?>
			</div>
		</div>
		<div class="clerfix"></div>
		</div>

		<div class="lrbox">
		<div class="lrbox1"><p class="colost2">Plant Images</p></div>
		<div class="lrbox2">
			<?php if(empty($complaint_reg->plant_img_1)){ echo "N/A"; } ?>
			<a <?php if(empty($complaint_reg->plant_img_1)){ echo "style='display:none;'"; } ?> class="fancybox-thumbs" data-fancybox-group="thumb2" href="<?php echo "../document/{$complaint_reg->ticket_no}/plant/{$complaint_reg->plant_img_1}";?>">Open Link</a>
		<?php 
			
			if(!empty($complaint_reg->plant_img_2)){
				echo "<a class='fancybox-thumbs' data-fancybox-group='thumb2' href='../document/{$complaint_reg->ticket_no}/plant/{$complaint_reg->plant_img_2}'></a>";
			}
			if(!empty($complaint_reg->plant_img_3)){
				echo "<a class='fancybox-thumbs' data-fancybox-group='thumb2' href='../document/{$complaint_reg->ticket_no}/plant/{$complaint_reg->plant_img_3}'></a>";
			}
			if(!empty($complaint_reg->plant_img_4)){
				echo "<a class='fancybox-thumbs' data-fancybox-group='thumb2' href='../document/{$complaint_reg->ticket_no}/plant/{$complaint_reg->plant_img_4}'></a>";
			}
			if(!empty($complaint_reg->plant_img_5)){
				echo "<a class='fancybox-thumbs' data-fancybox-group='thumb2' href='../document/{$complaint_reg->ticket_no}/plant/{$complaint_reg->plant_img_5}'></a>";
			}
		?>

		</div>
		<div class="clerfix"></div>
		</div>

		</div>
		<div class="clerfix"></div>
		<div class="clerfix"></div>
		</div>

		<div class="onlock-cov" <?php if($complaint_reg->visit_done == "No"){echo "style='display:none;'";}?>>
		<div class="onlock-3"><p class="colost1">Complaint Status</p></div>
		<div class="onlock-3">
		<p class="colost2"><?php echo $complaint_reg->product_status; ?></p>
		<p class="colost2"><?php echo $complaint_reg->product_status_specify; ?></p>

		</div>
		<div class="clerfix"></div>
		</div>
	</div>	

	<div class="clerfix"></div>
</div>
<!-- 3 -->

<!-- 4 -->
<div class="onlock" <?php if(empty($complaint_reg->visit_done)){echo "style='display:none'";} ?>>
	
	<!------------------------------ Data Below ---------------------------->
	<div id="complaint_accepted_2" <?php if(empty($complaint_reg->complaint_accepted) || $complaint_reg->complaint_accepted == "Decision Pending"){echo "style='display:none;'";}?>>
		<div class="onlock-cov">			
			<?php if(!empty($complaint_reg->complaint_accepted)){ ?>	
			<div class="onlock-3"><p class="colost1">Complaint Accepted</p></div>
			<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->complaint_accepted; ?></p></div>
			<div class="clerfix"></div>
			<?php } if(!empty($complaint_reg->complaint_remark)){ ?>	
			<div class="onlock-3"><p class="colost1">Remark</p></div>
			<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->complaint_remark; ?></p></div>
			<div class="clerfix"></div>
			<?php } if(!empty($complaint_reg->other_advice)){ ?>	
			<div class="onlock-3"><p class="colost1">Recommended / Adviced</p></div>
			<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->other_advice; ?></p></div>
			<div class="clerfix"></div>
			<?php } if(!empty($complaint_reg->action_by_name)){ ?>	
			<div class="onlock-3"><p class="colost1">Action By</p></div>
			<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->action_by_name; ?></p></div>
			<div class="clerfix"></div>
			<?php } if($complaint_reg->action_by_date != "0000-00-00"){ ?>	
			<div class="onlock-3"><p class="colost1">Target Date</p></div>
			<div class="onlock-3"><p class="colost2"><?php echo date('d-m-Y', strtotime($complaint_reg->action_by_date)); ?></p></div>
			<?php } ?>	
		</div>
	</div>

	<div class="clerfix"></div>
</div>
<!-- 4 -->

<!-- 5 -->
<div class="onlock" <?php if($complaint_reg->complaint_accepted != "Yes"){echo "style='display:none'";} ?>>
	

	<!------------------------------ Data Form Below ---------------------------->
  <div id="approval_action_taken_1" <?php if(!empty($complaint_reg->approval_action_taken)){echo "style='display:none;'";}?>>
    <form action="<?php echo "raised-complaint-db.php?id=".$_GET['id']; ?>" method="post" enctype="multipart/form-data" autocomplete="off"> 

    <div class="onlock" style="border:none">
      <div class="onlock-1"><p class="colost1">Create Approval Note</p></div>
      <div class="onlock-2">
        <div class="create_approval_note">
          <input type="button" class="btn <?php if($complaint_reg->create_approval_note == "Yes"){echo "btn-primary";} else {echo "btn-light";}?> create_approval_note_yes" value="Yes" />   
          <input type="button" class="btn <?php if($complaint_reg->create_approval_note == "No"){echo "btn-primary";} else {echo "btn-light";}?> create_approval_note_no" value="No" />
          <input type="hidden" class="create_approval_note_val" name="create_approval_note" value="<?php echo $complaint_reg->create_approval_note; ?>" />
          <span class="err_msg create_approval_note_msg"></span>
        </div>
      <div class="clerfix"></div>
      </div>
      <div class="clerfix"></div>

      <div class="onfod">
        <div class="onlock-1 approval_note" <?php if($complaint_reg->create_approval_note != "Yes"){echo "style='display:none;'";}?>><p class="colost1">Approval Note</p></div>
        <div class="onlock-2 approval_note" <?php if($complaint_reg->create_approval_note != "Yes"){echo "style='display:none;'";}?>>
          
          <!-- //todo -->
          <?php 
            $reject_remark = '';
            /*if( count($approval_notes) ){
                foreach ($approval_notes as $key => $value) {
                   if($key == 0 && $value->on_hold == 1){
                      $reject_remark = $value->on_hold_remark;
                   }
                }
            }*/
            $create_note = 0;

              if($complaint_reg->approval_on_hold == 1){
                echo '<a class="onlock-link edit_approval_note" href="#" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-id="'.$complaint_reg->approval_note.'" data-target="#edit_approval_note" >Create New Note</a>';
              } 
               if( $complaint_reg->approval_note != 0){
                    if( count($approval_notes) ){
                          foreach ($approval_notes as $key => $value) {
                              $r_text= ($value->on_hold == 1) ? '[Rejected]' : '';
                             
                             echo ' <p class="mt-2"> <a data-toggle="modal" data-backdrop="static" data-keyboard="false" class="view_approval_note" data-id="'.$value->id.'" data-target="#view-approval-note" href="#">Open link</a>  '.$r_text .' </p>';
                          }
                      }
                  
              } else{
                   $create_note = 1;
                  echo '<a class="onlock-link " href="#" data-toggle="modal" data-backdrop="static" data-keyboard="false"data-target="#create-note" >Create Note</a>';
              }
          ?>

          <div class="clerfix"></div>
        </div>
        <div class="clerfix"></div>
      </div>
      
      <div class="onlock-1"><p class="colost1 ">Action Taken</p></div>

      <div class="onlock-2" id="approval_action_taken">

      <div class="custom-control custom-radio mrig5"><input type="radio" <?php if($complaint_reg->approval_action_taken == "Replaced"){echo "Checked";} ?> value="Replaced" id="approval_action_taken1" name="approval_action_taken" class="custom-control-input approval_action_taken">
      <label class="custom-control-label colost2" for="approval_action_taken1">Replaced</label></div>

      <div class="custom-control custom-radio mrig5"><input type="radio" <?php if($complaint_reg->approval_action_taken == "Diverted to Other Customer"){echo "Checked";} ?> value="Diverted to Other Customer" id="approval_action_taken2" name="approval_action_taken" class="custom-control-input approval_action_taken">
      <label class="custom-control-label colost2" for="approval_action_taken2">Diverted to Other Customer</label></div>

      <div class="custom-control custom-radio mrig5"><input type="radio" <?php if($complaint_reg->approval_action_taken == "Lifted back"){echo "Checked";} ?> value="Lifted back" id="approval_action_taken3" name="approval_action_taken" class="custom-control-input approval_action_taken">
      <label class="custom-control-label colost2" for="approval_action_taken3">Lifted back</label></div>

      <div class="custom-control custom-radio mrig5"><input type="radio" <?php if($complaint_reg->approval_action_taken == "Reworked and Send back"){echo "Checked";} ?> value="Reworked and Send back" id="approval_action_taken4" name="approval_action_taken" class="custom-control-input approval_action_taken">
      <label class="custom-control-label colost2" for="approval_action_taken4">Reworked and Send back</label></div>

      <div class="custom-control custom-radio mrig5"><input type="radio" <?php if($complaint_reg->approval_action_taken == "Commercial Settled"){echo "Checked";} ?> value="Commercial Settled" id="approval_action_taken5" name="approval_action_taken" class="custom-control-input approval_action_taken">
      <label class="custom-control-label colost2" for="approval_action_taken5">Commercial Settled</label></div>

      <div class="custom-control custom-radio mrig5"><input type="radio" <?php if($complaint_reg->approval_action_taken == "Initiated Insurance Survey"){echo "Checked";} ?> value="Initiated Insurance Survey" id="approval_action_taken6" name="approval_action_taken" class="custom-control-input approval_action_taken">
      <label class="custom-control-label colost2" for="approval_action_taken6">Initiated Insurance Survey</label></div>

      <div class="custom-control custom-radio mrig5"><input type="radio" <?php if($complaint_reg->approval_action_taken != "Replaced" && $complaint_reg->approval_action_taken != "Diverted to other Customer" && $complaint_reg->approval_action_taken != "Lifted back" && $complaint_reg->approval_action_taken != "Reworked and Send back" && $complaint_reg->approval_action_taken != "Commercial Settled" && $complaint_reg->approval_action_taken != "Initiated Insurance Survey"){echo "Checked";} ?> value="Others" id="approval_action_taken7" name="approval_action_taken" class="custom-control-input approval_action_taken">
      <label class="custom-control-label colost2" for="approval_action_taken7">Others</label></div>
      <span class="err_msg approval_action_taken_msg"></span>
        
      <textarea class="form-control mrig10" id="approval_action_taken_specify" name="approval_action_taken_specify" placeholder="Please specify" rows="3"><?php if($complaint_reg->approval_action_taken != "Replaced" && $complaint_reg->approval_action_taken != "Diverted to other Customer" && $complaint_reg->approval_action_taken != "Lifted back" && $complaint_reg->approval_action_taken != "Reworked and Send back" && $complaint_reg->approval_action_taken != "Commercial Settled" && $complaint_reg->approval_action_taken != "Initiated Insurance Survey"){echo $complaint_reg->approval_action_taken_specify;} ?> </textarea>
      <span class="err_msg approval_action_taken_specify_msg"></span>
      </div>

      <div class="clerfix"></div>

      <div class="clerfix"></div>

      <div class="onlock-1"><p class="colost1"></p></div>

      <div class="onlock-cov2">
        <div class="btspa">
          <div class="form-group mb-0 text-center log-btn">
            <input type="submit" id="approval_action_a_taken" name="approval_action_a_taken" class="btn btn-primary2"  value="Submit" />
          </div>
        </div>
      </div>

      <div class="clerfix"></div>
    </div>

    </form>
  </div>

	<!------------------------------ Data Below ---------------------------->
	<div id="approval_action_taken_2" <?php if(empty($complaint_reg->approval_action_taken)){echo "style='display:none;'";}?>>
		
		<div class="onlock-1"><p class="colost1">Create Approval Note</p></div>
		<div class="onlock-2"><p class="colost2">
			<?php echo $complaint_reg->create_approval_note; ?>
		</p></div>
		<div class="clerfix"></div>
		<?php if($complaint_reg->create_approval_note == "Yes"){ ?>
		<div class="onlock-1"><p class="colost1">Approval Note</p></div>
		<div class="onlock-2">
		<div class="lrbox001">
		<div class="lrbox1"><p class="colost2">Document</p></div>
		<div class="lrbox2">
      <?php 
          if( count($approval_notes) ){
                foreach ($approval_notes as $key => $value) {
                    $r_text= ($value->on_hold == 1) ? '[Rejected]' : '';
                   
                   echo '<a data-toggle="modal" data-backdrop="static" data-keyboard="false"class="view_approval_note" data-id="'.$value->id.'" data-target="#view-approval-note" href="#">View</a>
       / <a target="_blank" href="download-approval-note.php?doc=w&id='.$value->id.'">Download</a> '.$r_text .' <br>';
                }
            }
          
      ?>
     <!--  <a data-toggle="modal" data-backdrop="static" data-keyboard="false"class="view_approval_note" data-id="<?php echo $complaint_reg->approval_note; ?>" data-target="#view-approval-note" href="#">View</a>
			/ <a target="_blank" href="download-approval-note.php?doc=w&id=<?php echo $complaint_reg->approval_note; ?>">Download</a> -->


		</div>
		
		<div class="clerfix"></div>
		</div></div>
		<div class="clerfix"></div>
		<?php } ?>
		<div class="onlock-1"><p class="colost1">Action Taken</p></div>
		<div class="onlock-2"><p class="colost2">
			<?php echo $complaint_reg->approval_action_taken; 
					if(!empty($complaint_reg->approval_action_taken_specify)){
						echo " : ".$complaint_reg->approval_action_taken_specify;
					}
			?>
		</p></div>
		<div class="clerfix"></div>
		<?php if($complaint_reg->create_approval_note == "Yes"){ ?>
		<div class="onlock-1"><p class="colost1">Credit note Approval</p></div>
		<div class="onlock-2">
			<div class="custom-control custom-checkbox arsalin">
			<input disabled <?php if($complaint_reg->cna_crm_head == "Yes"){echo "checked";} ?> type="checkbox" class="custom-control-input" id="cna_crm_head">
			<label class="custom-control-label" for="cna_crm_head">CRM Head</label>
			</div>

			<div class="custom-control custom-checkbox arsalin">
			<input disabled <?php if($complaint_reg->cna_commercial_head == "Yes"){echo "checked";} ?> type="checkbox" class="custom-control-input" id="cna_commercial_head">
			<label class="custom-control-label" for="cna_commercial_head">Commercial Head</label>
			</div>

			<div class="custom-control custom-checkbox arsalin">
			<input disabled <?php if($complaint_reg->cna_plant_chief == "Yes"){echo "checked";} ?> type="checkbox" class="custom-control-input" id="cna_plant_chief">
			<label class="custom-control-label" for="cna_plant_chief">Plant Chief</label>
			</div>

			<div class="custom-control custom-checkbox arsalin">
			<input disabled <?php if($complaint_reg->cna_sales_head == "Yes"){echo "checked";} ?> type="checkbox" class="custom-control-input" id="cna_sales_head">
			<label class="custom-control-label" for="cna_sales_head">Sales Head</label>
			</div>

			<div class="custom-control custom-checkbox arsalin">
			<input disabled <?php if($complaint_reg->cna_cfo == "Yes"){echo "checked";} ?> type="checkbox" class="custom-control-input" id="cna_cfo">
			<label class="custom-control-label" for="cna_cfo">CFO</label>
			</div>
			
			<div <?php if($complaint_reg->cna_md_status != "Yes"){echo "style='display:none;'";} ?> class="custom-control custom-checkbox arsalin">
			<input disabled <?php if($complaint_reg->cna_md == "Yes"){echo "checked";} ?> type="checkbox" class="custom-control-input" id="cna_md">
			<label class="custom-control-label" for="cna_md">MD</label>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- 5 -->

<?php /* ?>
<!-- 6 -->
<div class="onlock" <?php 
	 if($complaint_reg->create_approval_note == "No"){ echo "style='display:none'"; }
	 else if($complaint_reg->cna_cfo != "Yes"){echo "style='display:none'";}
	 else if(empty($complaint_reg->cna_md_status)){echo "style='display:none'";}
	// else if($complaint_reg->cna_md_status == "No" && $complaint_reg->cna_md != "Yes"){echo "style='display:none'";}
	 else if($complaint_reg->cna_md_status == "Yes" && $complaint_reg->cna_md != "Yes"){echo "style='display:none'";}
?>>
	
	<!------------------------------ Data Below ---------------------------->	
	<div id="settlement_2" <?php if(empty($complaint_reg->settlement)){echo "style='display:none'";} ?>>
		
		<div class="onlock-cov">
		<div class="onlock-3"><p class="colost1">Settelment</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->settlement; ?></p></div>
		<div class="clerfix"></div>
		<?php if(!empty($complaint_reg->reject_invoice_no)){ ?>	
		<div class="onlock-3"><p class="colost1">Rejection Invoice No.</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->reject_invoice_no; ?></p></div>
		<div class="clerfix"></div>
		<?php } if(!empty($complaint_reg->reject_final_qty)){ ?>	
		<div class="onlock-3"><p class="colost1">Final Quantity</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->reject_final_qty; ?></p></div>
		<div class="clerfix"></div>
		<?php } if(!empty($complaint_reg->comm_amount)){ ?>	
		<div class="onlock-3"><p class="colost1">Commercial Amount</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->comm_amount; ?></p></div>
		<div class="clerfix"></div>
		<?php } if(!empty($complaint_reg->settlement_date)){ ?>	
		<div class="onlock-3"><p class="colost1">Date</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo date('d-m-Y', strtotime($complaint_reg->settlement_date)); ?></p></div>
		<div class="clerfix"></div>
		<?php }  if(!empty($complaint_reg->settlement_credit_note_no)){ ?>	
		<div class="onlock-3"><p class="colost1">Credit Note No.</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->settlement_credit_note_no; ?></p></div>
		<?php } ?>	
		<div class="onlock-3"><p class="colost1">Create CAPA</p></div>
		<div class="onlock-3">
			<div class="custom-control custom-checkbox arsalin">
				<input type="checkbox" <?php if(!empty($complaint_reg->capa) || !empty($complaint_reg->capa_document)){echo "Checked";} ?> class="custom-control-input" id="capa_check">
				<label class="custom-control-label" for="capa_check">&nbsp;</label>
			</div>
		</div>	
		</div>
		<div class="clerfix"></div>
	</div>
</div>
<!-- 6 -->
<?php */ ?>

<!-- 6 -->
<div class="onlock" <?php 
   if($complaint_reg->create_approval_note == "No"){ echo "style='display:none'"; }
   else if($complaint_reg->cna_cfo != "Yes"){echo "style='display:none'";}
   else if(empty($complaint_reg->cna_md_status)){echo "style='display:none'";}
  // else if($complaint_reg->cna_md_status == "No" && $complaint_reg->cna_md != "Yes"){echo "style='display:none'";}
   else if($complaint_reg->cna_md_status == "Yes" && $complaint_reg->cna_md != "Yes"){echo "style='display:none'";}
?>>
  <!------------------------------ Data Form Below ---------------------------->
  <div id="settlement_1" <?php if(!empty($complaint_reg->settlement)){echo "style='display:none'";}?>>
  <form action="<?php echo "raised-complaint-db.php?id=".$_GET['id']; ?>" method="post" enctype="multipart/form-data" autocomplete="off"> 
  
  <div class="onlock" style="border:none">
    <div class="onlock-1"><p class="colost1">Settlement</p></div>
    <div class="onlock-2">
      <div class="settlement">
        <input type="button" class="btn <?php if($complaint_reg->settlement == "Rejection"){echo "btn-primary";} else {echo "btn-light";}?> settlement_rej" value="Rejection" />   
        <input type="button" class="btn <?php if($complaint_reg->settlement == "Commercial"){echo "btn-primary";} else {echo "btn-light";}?> settlement_com" value="Commercial" />
        <input type="hidden" class="settlement_val" name="settlement" value="<?php echo $complaint_reg->settlement; ?>" />
        <span class="err_msg settlement_msg"></span>
      </div>
      <div class="clerfix"></div>
    </div>

    <div class="clerfix"></div>
    <div class="mrig20"></div>

    <div class="onlock-1 mrig8 settlement_rej_box"><p class="colost1 ">Rejection Invoice No.</p></div>
    <div class="onlock-cov2 mrig8 settlement_rej_box">
      <div class="onlock-3">
        <input class="form-control fodhf" id="reject_invoice_no" type="text" value="<?php echo $complaint_reg->reject_invoice_no; ?>" name="reject_invoice_no">
        <span class="err_msg reject_invoice_no_msg"></span>
      </div>
      <div class="clerfix"></div>
    </div>

    <div class="onlock-1 mrig8 settlement_rej_box"><p class="colost1 ">Final Quantity</p></div>
    <div class="onlock-cov2 mrig8 settlement_rej_box">
      <div class="onlock-3">
        <div class="row"> 
          <div class="col col-sm-5">
            <select id="reject_qty_type" name="reject_qty_type" class="form-control">
              <option <?php if (strpos($complaint_reg->reject_final_qty, 'MT') !== false) {echo "Selected";}?>>MT</option>
              <option <?php if (strpos($complaint_reg->reject_final_qty, 'KG') !== false) {echo "Selected";}?>>KG</option>
              <option <?php if (strpos($complaint_reg->reject_final_qty, 'Each') !== false) {echo "Selected";}?>>Each</option>
            </select>
          </div>
          <div class="col col-sm-7">
            <?php
              if (strpos($complaint_reg->reject_final_qty, 'MT') !== false) {
                $reject_final_qty = str_replace("MT","",$complaint_reg->reject_final_qty);
              } else if (strpos($complaint_reg->reject_final_qty, 'KG') !== false) {
                $reject_final_qty = str_replace("KG","",$complaint_reg->reject_final_qty);
              } else if (strpos($complaint_reg->reject_final_qty, 'Each') !== false) {
                $reject_final_qty = str_replace("Each","",$complaint_reg->reject_final_qty);
              } else {
                $reject_final_qty = $complaint_reg->reject_final_qty;
              }
            ?>
            <input class="form-control fodhf" placeholder="" type="text" id="reject_final_qty" value="<?php echo $reject_final_qty; ?>" name="reject_final_qty"> 
          </div>
          &nbsp; &nbsp; &nbsp; <span class="err_msg reject_final_qty_msg"></span>
        </div>
      </div>
      <div class="clerfix"></div>
    </div>  

    <div class="onlock-1 mrig8 settlement_com_box"><p class="colost1 ">Commercial Amount</p></div>
    <div class="onlock-cov2 mrig8 settlement_com_box">
      <div class="onlock-3">
        <input class="form-control fodhf" id="comm_amount" type="text" value="<?php echo $complaint_reg->comm_amount; ?>" name="comm_amount">
        <span class="err_msg comm_amount_msg"></span>
      </div>
      <div class="clerfix"></div>
    </div>  

    <div class="onlock-1 mrig8"><p class="colost1 ">Date</p></div>
    <div class="onlock-cov2 mrig8">
      <div class="onlock-3">
        <?php
          if($complaint_reg->settlement_date != "0000-00-00"){
            $settlement_date = strtotime($complaint_reg->settlement_date); 
            $settlement_date = date("d/m/Y", $settlement_date);
          } else { $settlement_date = ""; }

        ?>
        <input readonly class="form-control fodhf date-picker" value="<?php echo $settlement_date; ?>" id="settlement_date" type="text" name="settlement_date"></p>
        <span class="err_msg settlement_date_msg"></span>
      </div>
      <div class="clerfix"></div>
    </div>

    <div class="onlock-1 mrig8"><p class="colost1 ">Credit Note No.</p></div>
    <div class="onlock-cov2 mrig8">
      <div class="onlock-3">
        <input class="form-control fodhf" id="settlement_credit_note_no" type="text" value="<?php echo $complaint_reg->settlement_credit_note_no; ?>" name="settlement_credit_note_no">
        <span class="err_msg settlement_credit_note_no_msg"></span>
      </div>
      <div class="clerfix"></div>
    </div>

    <div class="onlock-1"><p class="colost1"></p></div>

    <div class="onlock-cov2">
      <div class="btspa">
        <div class="form-group mb-0 text-center log-btn">
          <input type="submit" id="settlement_done" name="settlement_done" class="btn btn-primary2"  value="Submit"/>
        </div>
      </div>
    </div>

    <div class="clerfix"></div>
  </div>
    <!-- 6 -->
  </form>
  </div>

  <!------------------------------ Data Below ----------------------------> 
  <div id="settlement_2" <?php if(empty($complaint_reg->settlement)){echo "style='display:none'";} ?>>
    <?php if($complaint_reg->status != 'Closed' && $complaint_reg->status != 'Invalid'){?>
      <div class="bg-rig"><a href="#" class="editme edit_settlement" title="edit"><i class="mdi mdi-border-color"></i></a></div>
    <?php }?>
    
    <div class="onlock-cov">
    <div class="onlock-3"><p class="colost1">Settelment</p></div>
    <div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->settlement; ?></p></div>
    <div class="clerfix"></div>
    <?php if(!empty($complaint_reg->reject_invoice_no)){ ?> 
    <div class="onlock-3"><p class="colost1">Rejection Invoice No.</p></div>
    <div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->reject_invoice_no; ?></p></div>
    <div class="clerfix"></div>
    <?php } if(!empty($complaint_reg->reject_final_qty)){ ?>  
    <div class="onlock-3"><p class="colost1">Final Quantity</p></div>
    <div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->reject_final_qty; ?></p></div>
    <div class="clerfix"></div>
    <?php } if(!empty($complaint_reg->comm_amount)){ ?> 
    <div class="onlock-3"><p class="colost1">Commercial Amount</p></div>
    <div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->comm_amount; ?></p></div>
    <div class="clerfix"></div>
    <?php } if(!empty($complaint_reg->settlement_date)){ ?> 
    <div class="onlock-3"><p class="colost1">Date</p></div>
    <div class="onlock-3"><p class="colost2"><?php echo date('d-m-Y', strtotime($complaint_reg->settlement_date)); ?></p></div>
    <div class="clerfix"></div>
    <?php }  if(!empty($complaint_reg->settlement_credit_note_no)){ ?>  
    <div class="onlock-3"><p class="colost1">Credit Note No.</p></div>
    <div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->settlement_credit_note_no; ?></p></div>
    <?php } ?>  
    
    </div>
    <div class="clerfix"></div>
  </div>
</div>
<!-- 6 -->

<div class="onlock" <?php 
	 if($complaint_reg->create_approval_note == ""){ echo "style='display:none'"; }else { echo "style='display:none'"; }
?>>
	<div class="onlock-1" <?php if($complaint_reg->create_approval_note == ""){echo "style='display:none;'";} ?>><p class="colost1">Create CAPA</p></div>
	<div class="onlock-2" <?php if($complaint_reg->create_approval_note == ""){echo "style='display:none;'";} ?>>
		<div class="custom-control custom-checkbox arsalin">
			<input type="checkbox" <?php if(!empty($complaint_reg->capa) || !empty($complaint_reg->capa_document)){echo "Checked";} ?> class="custom-control-input" id="capa_check">
			<label class="custom-control-label" for="capa_check">Yes</label>
		</div>
	</div>	
	<div class="clerfix"></div>
</div>

<div class="onlock" id="create_capa" <?php 
	 //if($complaint_reg->create_approval_note == "No"){ echo "style='display:block'"; }
 	 
	 if(empty($complaint_reg->capa) && empty($complaint_reg->capa_document)){echo "style='display:none;'";}
?>>
	
	<!------------------------------ Data Below ---------------------------->
	<div id="capa_2" <?php if(empty($complaint_reg->capa) && empty($complaint_reg->capa_document)){echo "style='display:none;'";}?>>
		<div class="onlock-1"><p class="colost1">CAPA</p></div>
		<div class="onlock-2">
		<div class="lrbox001">
		<div class="lrbox1"><p class="colost2">Document</p></div>
		<div class="lrbox2">
			<?php
				if(!empty($complaint_reg->capa)){
					echo "<a data-toggle='modal' class='view_capa' data-type='w' data-id='$complaint_reg->capa' data-target='#view-capa' href='#'>View</a>";
					echo " / <a href='download-capa.php?doc=w&id=$complaint_reg->capa'>Download</a>";
				} else if(!empty($complaint_reg->capa_document)){
					echo "<a target='_blank' href='../document/{$complaint_reg->ticket_no}/capa/{$complaint_reg->capa_document}'>View</a>";
					echo " / <a href='download-capa.php?doc=d&id=$complaint_reg->id'>Download</a>";
				}				
			?>		
		</div>
		<div class="clerfix"></div>
		</div><div class="clerfix"></div>

		</div>
		<div class="clerfix"></div>
		<div class="onlock-1 mrig8"><p class="colost1 ">CAPA Approval</p></div>
		<div class="onlock-2">
			<div class="custom-control custom-checkbox arsalin">
			<input disabled <?php if($complaint_reg->capa_qa == "Yes"){echo "checked";} ?> type="checkbox" class="custom-control-input" id="capa_qa">
			<label class="custom-control-label" for="capa_qa">Qualilty Assurance</label>
			</div>

			<div class="custom-control custom-checkbox arsalin">
			<input disabled <?php if($complaint_reg->capa_ph == "Yes"){echo "checked";} ?> type="checkbox" class="custom-control-input" id="capa_ph">
			<label class="custom-control-label" for="capa_ph">Plant Head</label>
			</div>
			
			<div class="custom-control custom-checkbox arsalin">
			<input disabled <?php if($complaint_reg->capa_pc == "Yes"){echo "checked";} ?> type="checkbox" class="custom-control-input" id="capa_pc">
			<label class="custom-control-label" for="capa_pc">Plant Chief</label>
			</div>

			<div class="custom-control custom-checkbox arsalin">
			<input disabled <?php if($complaint_reg->capa_mr == "Yes"){echo "checked";} ?> type="checkbox" class="custom-control-input" id="capa_mr">
			<label class="custom-control-label" for="capa_mr">Management Representative</label>
			</div>
		</div>
	</div>
	<div class="clerfix"></div>
</div>

<div class="onlock" <?php if(empty($complaint_reg->complaint_accepted) || $complaint_reg->complaint_accepted == "Decision Pending"){echo "style='display:none'";} ?>>
	<div class="onlock-1"><p class="colost1">&nbsp;</p></div>
	<div class="onlock-2">
		<div class="create_capa_doc <?php if($complaint_reg->status != 'Closed' && $complaint_reg->status != 'Invalid'){echo 'create_capa_doc_alert';}?> ">
			<a href="<?php if($complaint_reg->status == "Closed" || $complaint_reg->status == "Invalid"){echo "#";} else {echo "update-complaint-status.php?id={$_GET['id']}&&status=closed";}?>" class="btn <?php if($complaint_reg->status == "Closed"){echo "btn-success2";}else {echo "btn-light2";} ?> ">Close Complaint</a>   
			<a href="<?php if($complaint_reg->status == "Closed" || $complaint_reg->status == "Invalid"){echo "#";} else {echo "update-complaint-status.php?id={$_GET['id']}&&status=invalid";}?>" class="btn <?php if($complaint_reg->status == "Invalid"){echo "btn-primary2";}else {echo "btn-light2";} ?>  ">Invalid Complaint</a>
		</div>
	<div class="clerfix"></div>
	</div>
	<div class="clerfix">&nbsp;</div>
</div>
	
<div class="clerfix"></div>
</div>


<div class="clerfix"></div>

</div>

<div class="complaints-blocks2">
	<div class="cb-block">
	<!-- 1 -->
		<div class="onlock" style="border:0px">
			<div class="ontow-1">
			<p><strong>Complaint Analysis</strong></p>
			</div>
			
			<div class="ontow-2">
			<ul>
			<li <?php if($complaint_reg->complaint_analysis == "Sporadic"){echo "class='active'";}?>><a href="complaint-analysis-db.php<?php echo "?id={$complaint_reg->id}&&ca=Sporadic"; ?>" class="colost1">
			<img src="assets/images/icons/1.png">
			<p>Sporadic</p>
			</a></li>

			<li <?php if($complaint_reg->complaint_analysis == "Chronic"){echo "class='active'";}?>><a href="complaint-analysis-db.php<?php echo "?id={$complaint_reg->id}&&ca=Chronic"; ?>" class="colost1">
			<img src="assets/images/icons/2.png">
			<p>Chronic</p>
			</a></li>

			<li <?php if($complaint_reg->complaint_analysis == "Major"){echo "class='active'";}?>><a href="complaint-analysis-db.php<?php echo "?id={$complaint_reg->id}&&ca=Major"; ?>" class="colost1">
			<img src="assets/images/icons/3.png">
			<p>Major</p>
			</a></li>

			<li <?php if($complaint_reg->complaint_analysis == "Minor"){echo "class='active'";}?>><a href="complaint-analysis-db.php<?php echo "?id={$complaint_reg->id}&&ca=Minor"; ?>" class="colost1">
			<img src="assets/images/icons/4.png">
			<p>Minor</p>
			</a></li>

			<li <?php if($complaint_reg->complaint_analysis == "Invalid"){echo "class='active'";}?>><a href="complaint-analysis-db.php<?php echo "?id={$complaint_reg->id}&&ca=Invalid"; ?>" class="colost1">
			<img src="assets/images/icons/5.png">
			<p>Invalid</p>
			</a></li>
			<div class="clerfix"></div>
			</ul>
			</div>

			

			<div class="clerfix"></div>
		</div>
	</div>
</div>


</div><!-- end row-->
</div>
	
	
	
</div><!-- end row-->
</div>
<!-- container -->


</div>
<!-- content -->
	
	
	
	
	
	
	
	
	
	
	
	
	
<!------------------------------------------------ MODAL CONTENT START ------------------------------------------------->	
<!------------------------------------------------ MODAL CONTENT START ------------------------------------------------->	
	

	
<!-- View Approval Note -->
<div class="modal fade form-pop" id="view-approval-note" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content"></div> <!-- end modal-content-->
	</div> <!-- end modal dialog-->
</div>
<!-- View Approval Note -->	
	
	
<!-- View CAPA -->
<div class="modal fade form-pop" id="view-capa" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content"></div> <!-- end modal-content-->
	</div> <!-- end modal dialog-->
</div>
<!-- View CAPA-->		
	

<?php 
  $create_note = 1;

  if($create_note){
     include 'approval-note-form.php';
  }

?>

	
<!-- Footer Start -->
<?php include 'footer.php'?>
<!-- end Footer -->
</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->
</div>
<!-- END wrapper -->

	<link href="assets/css/vendor/fullcalendar.min.css" rel="stylesheet" type="text/css" />      <!-- third party js -->
	<script src="assets/js/vendor/jquery-ui.min.js"></script>
	<script src="assets/js/vendor/fullcalendar.min.js"></script>
	<!-- third party js ends -->

	<!-- demo app 
	<script src="assets/js/pages/demo.calendar.js"></script>
	<!-- end demo js-->
<!-- fancyBox Js includ -->
	<?php include 'fancyboxjs.php'?>
<!-- fancyBox Js includ -->
<?php 
	$complaint_name 	= CompanyReg::find_by_cust_id($complaint_reg->customer_id); 
	$plant_location 	= $complaint_reg->plant_location;

	$department	 		= Department::authenticate_department($complaint_reg->business_vertical);

	$complaint_type 	= ComplaintType::authenticate_complaint_type($department->id,$complaint_reg->complaint_type);
			
	$sub_complaint_type = $complaint_reg->sub_complaint_type;
		
	$pl_name			= $complaint_reg->pl_name;
?>
<script>
	$(".create_capa_doc_alert a").click(function(e) {
		if (confirm('Complaint once closed or marked invalid, cannot be edited.')) {
			return true;
		} else {
			return false;
		}
		e.prevedefault();
	});


	$('#calendar').fullCalendar({
		  events: [
			<?php
				$sql = "Select * from complaint_meeting where complaint_id = '{$_GET['id']}'";
				$comp_meet = ComplaintMeeting::find_by_sql($sql);
	
				foreach($comp_meet as $comp_meet){
			?>
			  	{
				  id  	 : <?php echo $comp_meet->id; ?>,
				  cid  	 : <?php echo $comp_meet->complaint_id; ?>,
				  title  : '<?php echo $comp_meet->customer_coordinator; ?>',
				  start  : '<?php echo $comp_meet->meeting_date; ?>'
				},
			<?php		
				}
			?>  			
		  ],
		  eventClick: function(event) {
			  console.log(event.start, " - ", event.id);
			  console.log(event.start['_i'], " - ", event.title);
			  $('#delete_meeting').modal('toggle');
			  
			  var data_id = $(this).attr('data-id');
			  $("#delete_meeting .modal-content").load("edit-complaint-meeting.php?cid="+event.cid+"&&id="+event.id);
		  },
		  header:{
                left: "prev,next today",
                center: "title",
                right: "month,agendaWeek,agendaDay"
          }
	});


	var calendar = $('#calendar').fullCalendar('getCalendar');

	calendar.on('dayClick', function(date, jsEvent, view) {
		console.log('clicked on ' + date.format());	
		$('#complaint_meeting').modal('toggle');
		
		$('#meeting_date').val($.fullCalendar.formatDate( date, "YYYY-MM-DD"));
		
		//$("#meeting_date").val();
	});
		
	$('.view_approval_note').click(function() {
		var data_id = $(this).attr('data-id');
		$("#view-approval-note .modal-content").load("view-approval-note.php?id="+data_id);
	});
	
	$('.view_capa').click(function() {
		var data_id 	= $(this).attr('data-id');
		var data_type 	= $(this).attr('data-type');
		$("#view-capa .modal-content").load("view-capa.php?doc="+data_type+"&&id="+data_id);
	});
	
	
	$(document).ready(function() {
		
		var count = 1;

		$( ".product-img-row").each(function() {
			count++;
		});
		
		for (num = count; num <= 3; num++) { 
			var div = "<li class='resit-act1 product-img-row prod_img_row_"+ num +"' style='margin: 15px 0;'><div class='input-group'><div class='input-group-prepend'><span class='input-group-text clear_img clear_img_"+ num +"' title='Clear Image'>X</span></div><div class='custom-file'><input type='file' name='product_img_"+ num +"' class='custom-file-input' id='product_img_"+ num +"'><label class='custom-file-label' for='product_img_"+ num +"'>Upload Image</label></div></div></li>";
			
			$(".product_img").append(div);
			//$(".prod_img_row_"+ num).hide();	
		}
		

		$('input[type=file]').change(function(e){		
			var fileName = e.target.files[0].name;
			//console.log(e.target.files[0]);
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

		$(".add_prod_img").click(function (e) {
			if(count < 3){
				count++;
				$(".prod_img_row_"+ count).show();
				//console.log(num);	
			} 
			e.preventDefault();
		});

		$(".rem_prod_img").click(function (e) {
			if(count >= 2){
				$(".prod_img_row_"+ count).hide();	
				$(".prod_img_row_"+ count +" input").val(''); 
				//console.log(num);
				count--;
			}
			e.preventDefault();
		});	
		
		$(".open_capa_doc").fancybox({
			width  : 600,
			height : 300,
			type   :'iframe'
		});
		
    $('.date-picker').daterangepicker({
      singleDatePicker: true,
      locale: {
        format: 'DD/MM/YYYY',
      }
    });
		
		/*var product = $("#product").val().replace(" ","%20");
		product = product.replace(" ","%20");
		product = product.replace(" ","%20");
		
		
		
		//$("#plant_location").load("get-site-location.php?product="+product);
		$("#plant_location").load("get-site-location.php?product="+product, function() {
			
			
			
			$("#plant_location").val("<?php echo $plant_location; ?>").attr("selected","selected");
			
			var plant_location = $("#plant_location").val().replace(" ","%20");
			plant_location = plant_location.replace(" ","%20");
			plant_location = plant_location.replace(" ","%20");
			
			
			var product = $("#product").val().replace(" ","%20");	
			product = product.replace(" ","%20");	
			product = product.replace(" ","%20");	
			
			var complaint_type_id = "<?php if($complaint_type){echo $complaint_type->id;}else{echo "";} ?>";
			
			if(complaint_type_id){
				$("#complaintType").load("get-complaint-type.php?plant_location="+plant_location+"&&product="+product, function() {
				
				$("#complaintType").val(complaint_type_id).attr("selected","selected");
				
				var complaint = $("#complaintType").val().replace(" ","%20");
				complaint = complaint.replace(" ","%20");
				complaint = complaint.replace(" ","%20");

				var plant_location = $("#plant_location").val().replace(" ","%20");	
				plant_location = plant_location.replace(" ","%20");	
				plant_location = plant_location.replace(" ","%20");	

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

				$("#complaintSubType").load("get-complaint-sub-type.php?plant_location="+plant_location+"&&product="+product+"&&complaint="+complaint, function() {
					$("#complaintSubType").val("<?php echo $sub_complaint_type; ?>").attr("selected","selected");
					
					var complaint = $("#complaintSubType").val();

					if(complaint == "Other"){
						$("#complaintSubTypeOther").show();
					} else {
						$("#complaintSubTypeOther").hide();
					}
				});
			});
			}
			

		});*/
		
		var company	= "<?php echo $complaint_name->id; ?>";
		
		var company = company.replace(" ","%20");
		company = company.replace(" ","%20");
		company = company.replace(" ","%20");

		$("#pl_name").load("get-employee.php?id="+company, function() {
			$("#pl_name").val("<?php echo $pl_name; ?>").attr("selected","selected");
		});
		
		
		var pl_name = "<?php echo $pl_name; ?>";
		pl_name = pl_name.replace(" ","%20");
		pl_name = pl_name.replace(" ","%20");
		pl_name = pl_name.replace(" ","%20");
		var comp_id = company;


		$( "#pl_email" ).load( "get-employee-details.php?cid="+comp_id+"&&id="+pl_name+"&&type=email", function( response, status, xhr ) {
		  $("#pl_email").val(response);
		});
		$( "#pl_email" ).load( "get-employee-details.php?cid="+comp_id+"&&id="+pl_name+"&&type=mobile", function( response, status, xhr ) {
		  $("#pl_mobile").val(response);
		});

		selected_name = $("#pl_name").val();

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
		
		
		
		
		
		
		$("#product").change(function(){
			product = this.value.replace(" ","%20");
			product = product.replace(" ","%20");
			product = product.replace(" ","%20");
			$("#plant_location").load("get-site-location.php?product="+product);
		});
		
		$("#plant_location").change(function(){
			var plant_location = this.value.replace(" ","%20");
			plant_location = plant_location.replace(" ","%20");
			plant_location = plant_location.replace(" ","%20");

			var product = $("#product").val().replace(" ","%20");	
			product = product.replace(" ","%20");	
			product = product.replace(" ","%20");	
			$("#complaintType").load("get-complaint-type.php?plant_location="+plant_location+"&&product="+product);
		});	
		
		$("#complaintType").change(function(){
			var complaint = this.value.replace(" ","%20");
			complaint = complaint.replace(" ","%20");
			complaint = complaint.replace(" ","%20");

			var plant_location = $("#plant_location").val().replace(" ","%20");	
			plant_location = plant_location.replace(" ","%20");
			plant_location = plant_location.replace(" ","%20");

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
		
		$("#pl_name").change(function(){
			var pl_name = this.value.replace(" ","%20");
			pl_name = pl_name.replace(" ","%20");
			pl_name = pl_name.replace(" ","%20");
			var comp_id = company;


			$( "#pl_email" ).load( "get-employee-details.php?cid="+comp_id+"&&id="+pl_name+"&&type=email", function( response, status, xhr ) {
			  $("#pl_email").val(response);
			});
			$( "#pl_email" ).load( "get-employee-details.php?cid="+comp_id+"&&id="+pl_name+"&&type=mobile", function( response, status, xhr ) {
			  $("#pl_mobile").val(response);
			});

			selected_name = this.value;

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
		
		
		
		
		
		
		$(".edit_comp_raised").click(function (e) {
			$("#comp_raised_1").toggle();
			$("#comp_raised_2").toggle();
			e.preventDefault();
		});
		
		$(".edit_id_source").click(function (e) {
			$("#id_source_1").toggle();
			$("#id_source_2").toggle();
			e.preventDefault();
		});
		
		$(".edit_request_visit").click(function (e) {
			$("#request_visit_1").toggle();
			$("#request_visit_2").toggle();
			e.preventDefault();
		});
		
		$(".edit_visit_done").click(function (e) {
			$("#visit_done_1").toggle();
			$("#visit_done_2").toggle();
			e.preventDefault();
		});
		
		$(".edit_complaint_accepted").click(function (e) {
			$("#complaint_accepted_1").toggle();
			$("#complaint_accepted_2").toggle();
			e.preventDefault();
		});
		
		$(".edit_approval_action_taken").click(function (e) {
			$("#approval_action_taken_1").toggle();
			$("#approval_action_taken_2").toggle();
			e.preventDefault();
		});
		
		$(".edit_settlement").click(function (e) {
			$("#settlement_1").toggle();
			$("#settlement_2").toggle();
			e.preventDefault();
		});
			
		
		
		$(".capa_document").click(function (e) {
			$(this).closest('.capa-document-row').find('.custom-file label').html('Upload CAPA Document');
			$(this).closest('.capa-document-row').find('.custom-file input').val('');
		});
		
		$("#capa_check").click(function() {	
			if ($('#capa_check').is(":checked")) {
				$('#create_capa').show();
			} else {
				$('#create_capa').hide();
			}
		});
		
		
		var cust_id = "<?php echo $get_comp_id->id; ?>";
		
		$("#meeting_name").load("get-employee-2.php?id="+cust_id);
		
		$("#meeting_name").change(function(){
			
			console.log($(this).val());
			
			var meeting_name = $(this).val().replace(" ","%20");
			meeting_name = meeting_name.replace(" ","%20");
			meeting_name = meeting_name.replace(" ","%20");
			
			$( "#meeting_email" ).load( "get-employee-details.php?cid="+cust_id+"&&id="+meeting_name+"&&type=email", function( response, status, xhr ) {
			  $("#meeting_email").val(response);
			});
			$( "#meeting_email" ).load( "get-employee-details.php?cid="+cust_id+"&&id="+meeting_name+"&&type=mobile", function( response, status, xhr ) {
			  $("#meeting_mobile").val(response);
			});

			selected_name = this.value;

			if(selected_name == "Other"){
				$(".meeting_name_2").show();
				$("#meeting_email").attr("readonly", false); $("#meeting_mobile").attr("readonly", false); 
				$("#meeting_email").val(''); $("#meeting_mobile").val('');
			} else if(selected_name == ""){
				$(".meeting_name_2").hide();
				$("#meeting_email").attr("readonly", true); $("#meeting_mobile").attr("readonly", true); 
				$("#meeting_email").val(''); $("#meeting_mobile").val('');
			} else{ 
				$(".meeting_name_2").hide(); 
				$("#meeting_email").attr("readonly", true); $("#meeting_mobile").attr("readonly", true); 
			}

		});
		
		$("#mom_write_doc").fancybox({
			'titlePosition'		: 'inside',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none'
		});
		
		$('#create-note').change(function(){
			var parent = $('#create-note');
			total_qty_rejc 		= $("#total_qty_rejc").val();
			basic_sale_price 	= $("#basic_sale_price").val();
			sales_value 		= (total_qty_rejc * basic_sale_price).toFixed(2);
			$("#sales_value").val(sales_value);
			
			cgst 	= (sales_value / 100) * $(".cgst").val();
			sgst 	= (sales_value / 100) * $(".sgst").val();
			cgst 	= cgst.toFixed(2);
			sgst 	= sgst.toFixed(2);

			$("#cgst").val(cgst);
			$("#sgst").val(sgst);
			  
			
			cost_inc_customer 	= $("#cost_inc_customer").val();
			salvage_value 		= $("#salvage_value").val();
			
			credit_note_iss_cust = parseFloat(sales_value) + parseFloat(cgst) + parseFloat(sgst) + parseFloat(cost_inc_customer) - parseFloat(salvage_value);
			$("#credit_note_iss_cust").val(credit_note_iss_cust.toFixed(2));
						 
			
			qty_acpt_steel_mill 			= $("#qty_acpt_steel_mill").val();
			qty_scrp_auc_serv_cent 			= $("#qty_scrp_auc_serv_cent").val();
			qty_dlv_customer 				= $("#qty_dlv_customer").val();
			
			qty_debit						= parseFloat(qty_acpt_steel_mill) + parseFloat(qty_scrp_auc_serv_cent) + parseFloat(qty_dlv_customer)
			
			debit_note_sal_rate_sale_value 	= $("#debit_note_sal_rate_sale_value").val();
			value 							= qty_debit * debit_note_sal_rate_sale_value;
			value 							= value.toFixed(2);
			$("#value").val(value);
			
			loss_cgst 	= (value / 100) * $(".loss_cgst").val();
			loss_sgst 	= (value / 100) * $(".loss_sgst").val();
			loss_cgst 	= loss_cgst.toFixed(2);
			loss_sgst 	= loss_sgst.toFixed(2);
			
			$("#loss_cgst").val(loss_cgst);
			$("#loss_sgst").val(loss_sgst);
			
      var total_debit_value = parseFloat(value) + parseFloat(loss_cgst) + parseFloat(loss_sgst);
      $("#total_debit_value").val(total_debit_value.toFixed(2));
			
			oth_exp_inc_mill 			= $("#oth_exp_inc_mill").val();
			oth_exp_debited 			= $("#oth_exp_debited").val();
			compensation_exp 			= $("#compensation_exp").val();
			
			
			// debit_note_iss_supplier 	= parseFloat(value) + parseFloat(loss_cgst) + parseFloat(loss_sgst) + parseFloat(oth_exp_debited) + parseFloat(compensation_exp) - parseFloat(oth_exp_inc_mill);
      debit_note_iss_supplier = parseFloat(value) + parseFloat(loss_cgst) + parseFloat(loss_sgst) + parseFloat(oth_exp_debited);

			debit_note_iss_supplier 	= debit_note_iss_supplier.toFixed(2);
			$("#debit_note_iss_supplier").val(debit_note_iss_supplier);
			
			
			// loss_from_rejection 		= (parseFloat(sales_value) - parseFloat(value)) + (parseFloat(oth_exp_inc_mill) - parseFloat(compensation_exp));
      loss_from_rejection = (parseFloat(sales_value) - parseFloat(value)) + (parseFloat(oth_exp_inc_mill) - parseFloat(oth_exp_debited) - parseFloat(compensation_exp));

			//loss_from_rejection 		= (parseFloat(sales_value) - parseFloat(value)) + (parseFloat(oth_exp_inc_mill) - parseFloat(compensation_exp) - parseFloat(debit_note_iss_supplier));
			//loss_from_rejection 		= parseFloat(credit_note_iss_cust) - parseFloat(debit_note_iss_supplier);
			loss_from_rejection 		= loss_from_rejection.toFixed(2);
			$("#loss_from_rejection").val(loss_from_rejection);
			
			
			recoverable_transporter 	= $("#recoverable_transporter").val();
      other_realisation   = $("#other_realisation").val();

			net_loss					= parseFloat(loss_from_rejection) - parseFloat(recoverable_transporter) - parseFloat(other_realisation);
			net_loss					= net_loss.toFixed(2);
			$("#net_loss").val(net_loss)
		});	

    // *********************** Settlement ****************************************************  
  
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
  //Approval note
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
});	
	
</script>
<style>

.form-p-box-bg3 {
    background-color: #7c7c7c !important ;
    color: #fff !important;
}	
</style>

</body>
</html>


