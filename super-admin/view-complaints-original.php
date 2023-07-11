<?php
	require_once("../includes/initialize.php"); 
	if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$complaint_reg = Complaint::find_by_id($_GET['id']);
	} else {
		$session->message("Complaint Not Found");
		redirect_to("my-complaints.php");
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
<style>
	input.btn-primary, input.btn-light {
		margin-right: 4px;
	}
	.fc-right{ display:none}
	.fc-center{ float:right}
	.fc-today-button{ display:none}
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



<?php  $message = output_message($message); ?>
<div class="alert fade show text-white <?php 
	if($message == "Meeting Added Successfully"){echo "bg-success";} 
	else if($message == "Complaint Updated Successfully"){echo "bg-success";} 		
	else if($message == "Approval Note Created Successfully"){echo "bg-success";} 		
	else if($message == "CAPA Created Successfully"){echo "bg-success";} 		
	else if($message == "Status Updated Successfully."){echo "bg-success";} 		
	else {echo "bg-danger";}?>" 
<?php if(empty($message)){echo " style='display:none';";} else {echo " style='margin-top:20px';";} ?> >
<a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
<?php echo $message; ?>
</div>
<!-- Start Content-->
<div class="container-fluid">

<div class="">

<div class="container-fluid">
<div class="">


<!-- top box -->
<div class="complaints-blocks">
<div class="cb-block">

<div class="cmp-lf"><h2>Complaint details - <?php echo $complaint_reg->company_name; ?>   |   Complaint No. <?php echo $complaint_reg->ticket_no; ?></h2></div>
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
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
<td class="fsd-2"><span><?php echo date('m-d-Y', strtotime($complaint_reg->invoice_date)); ?></span></td>
</tr>


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
<td class="fsd-1">Mobile No..	</td>
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
</div></div>
</div>
<!-- top box -->



<div class="complaints-blocks2" <?php if(empty($complaint_reg->identify_source)){echo "style='display:none'";}?>>

	
<div class="cb-block">
<!-- 1 -->
<div class="onlock" <?php if(empty($complaint_reg->identify_source)){echo "style='display:none'";}?>>
	<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
	<!------------------------------ Data Below ---------------------------->
	
	<div id="id_source_2" <?php if(empty($complaint_reg->identify_source)){echo "style='display:none;'";}?>>
		<div class="onlock-1"><p class="colost1">Identify the Source</p></div>
		<div class="onlock-2"><p class="colost2"><?php echo $complaint_reg->identify_source; ?></p></div>
		<div class="clerfix"></div>
		<div class="onlock-1"><p class="colost1">Select Mill</p></div>
		<div class="onlock-2"><p class="colost2"><?php echo $complaint_reg->mill; ?></p></div>
		<div class="clerfix"></div>
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
<div class="onlock" <?php if(empty($complaint_reg->request_visit)){echo "style='display:none'";} ?>>
	<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
	<!------------------------------ Data Below ---------------------------->
	<div id="request_visit_2" <?php if(empty($complaint_reg->request_visit) || $complaint_reg->request_visit == "No"){echo "style='display:none;'";}?>>
		
		<?php $complaint_meeting = ComplaintMeeting::find_by_comp_id($_GET['id']); ?>
		<div class="onlock-cov">
		<div class="onlock-3"><p class="colost1">Request a Visit</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_meeting->request_visit; ?></p></div>
		<div class="clerfix"></div>
		<div class="onlock-3"><p class="colost1">Date</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo date('m-d-Y', strtotime($complaint_meeting->meeting_date)); ?></p></div>
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
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_meeting->mobile; ?></p></div>
		</div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- 2 -->

<!-- 3 -->
<div class="onlock" <?php if(empty($complaint_reg->visit_done)){echo "style='display:none;'";} ?>>
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
	<!------------------------------ Data Below ---------------------------->
	<div id="visit_done_2" <?php if(empty($complaint_reg->visit_done) || $complaint_reg->visit_done == "Yes"){echo "style='display:none;'";}?>>
		
		<div class="onlock-1"><p class="colost1">Visit Done</p></div>
		<div class="onlock-2">
				<p class="colost2"><?php echo $complaint_reg->visit_done; ?></p>
				<p class="colost2"><?php echo $complaint_reg->visit_remark; ?></p>
		</div>
		<div class="clerfix"></div>		
	</div>
	<div id="visit_done_2" <?php if(empty($complaint_reg->visit_done) || $complaint_reg->visit_done == "No"){echo "style='display:none;'";}?>>
		<div class="onlock-cov">
		<div class="onlock-3"><p class="colost1">Visit Done</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->mill; ?></p>


		<div class="lrbox">
		<div class="lrbox1"><p class="colost2">MOM Document</p></div>
		<div class="lrbox2"><a class="fancybox-thumbs" data-fancybox-group="thumb" href="<?php echo "../document/{$complaint_reg->ticket_no}/mom/{$complaint_reg->mom_document}";?>">Open link</a></div>
		<div class="clerfix"></div>
		</div>

		<div class="lrbox">
		<div class="lrbox1"><p class="colost2">Plant Images</p></div>
		<div class="lrbox2"><a class="fancybox-thumbs" data-fancybox-group="thumb2" href="<?php echo "../document/{$complaint_reg->ticket_no}/plant/{$complaint_reg->plant_img_1}";?>">Open link</a>
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

		<div class="onlock-cov">
		<div class="onlock-3"><p class="colost1">Product Status</p></div>
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
<div class="onlock" <?php if(empty($complaint_reg->complaint_accepted)){echo "style='display:none'";} ?>>
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>

	<!------------------------------ Data Below ---------------------------->
	<div id="complaint_accepted_2" <?php if(empty($complaint_reg->complaint_accepted)){echo "style='display:none'";}?>>
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
			<?php } if(!empty($complaint_reg->action_by_date)){ ?>	
			<div class="onlock-3"><p class="colost1">Date</p></div>
			<div class="onlock-3"><p class="colost2"><?php echo date('m-d-Y', strtotime($complaint_reg->action_by_date)); ?></p></div>
			<?php } ?>	
		</div>
	</div>

	<div class="clerfix"></div>
</div>
<!-- 4 -->

<!-- 5 -->
<div class="onlock" <?php if(empty($complaint_reg->approval_action_taken)){echo "style='display:none'";} ?>>
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
	<!------------------------------ Data Below ---------------------------->
	<div id="approval_action_taken_2" <?php if(empty($complaint_reg->approval_action_taken)){echo "style='display:none;'";}?>>
		<div class="onlock-1"><p class="colost1">Approval Note</p></div>
		<div class="onlock-2">
		<div class="lrbox001">
		<div class="lrbox1"><p class="colost2">Document</p></div>
		<div class="lrbox2"><a data-toggle="modal" class="view_approval_note" data-id="<?php echo $complaint_reg->approval_note; ?>" data-target="#view-approval-note" href="#">Open link</a></div>
		<div class="clerfix"></div>
		</div></div>
		<div class="clerfix"></div>
		<div class="onlock-1"><p class="colost1">Action Taken</p></div>
		<div class="onlock-2"><p class="colost2">
			<?php echo $complaint_reg->approval_action_taken; 
					if(!empty($complaint_reg->approval_action_taken_specify)){
						echo " : ".$complaint_reg->approval_action_taken_specify;
					}
			?>
		</p></div>
		<div class="clerfix"></div>
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
			<input disabled <?php if($complaint_reg->cna_production_head == "Yes"){echo "checked";} ?> type="checkbox" class="custom-control-input" id="cna_production_head">
			<label class="custom-control-label" for="cna_production_head">Production Head</label>
			</div>
			
			<div class="custom-control custom-checkbox arsalin">
			<input disabled <?php if($complaint_reg->cna_plant_head == "Yes"){echo "checked";} ?> type="checkbox" class="custom-control-input" id="cna_plant_head">
			<label class="custom-control-label" for="cna_plant_head">Plant Head</label>
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
		</div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- 5 -->	

<!-- 6 -->
<div class="onlock" <?php if(empty($complaint_reg->settlement)){echo "style='display:none'";} ?>>
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
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
		<div class="onlock-3"><p class="colost2"><?php echo date('m-d-Y', strtotime($complaint_reg->settlement_date)); ?></p></div>
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

<div class="onlock" <?php if(empty($complaint_reg->capa)){echo "style='display:none'";} else {echo "style='border:none'";} ?>>
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>

	<!------------------------------ Data Below ---------------------------->
	<div id="capa_2" <?php if(empty($complaint_reg->capa)){echo "style='display:none'";}?>>
		<div class="onlock-1"><p class="colost1">CAPA</p></div>
		<div class="onlock-2">
		<div class="lrbox001">
		<div class="lrbox1"><p class="colost2">Document</p></div>
		<div class="lrbox2">
			<a data-toggle="modal" class="view_capa" data-id="<?php echo $complaint_reg->capa; ?>" data-target="#view-capa" href="#">Open link</a>
		</div>
		<div class="clerfix"></div>
		</div><div class="clerfix"></div>

		</div>
	</div>
	<div class="clerfix"></div>
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
	
<!-- Add New Event MODAL -->
<div class="modal fade" id="complaint_meeting" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="raised-complaint-db.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
			<div class="modal-header pr-4 pl-4 border-bottom-0 d-block">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
				<h4 class="modal-title">Add new visit request</h4>
			</div>
			<div class="modal-body pt-3 pr-4 pl-4">
        		<div class='row'>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label class='control-label'>Meeting Date</label>
							<input type='text' readonly id="meeting_date" name='meeting_date' class="form-control"/>
						</div>
					</div>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label class='control-label'>Place</label>
							<input class='form-control' placeholder='Place' type='text' name='place'/>
						</div>
					</div>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label class='control-label'>Customer Coordinator (whom to meet)</label>
							<input class='form-control' type='text' name='customer_coordinator'/>
						</div>
					</div>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label class='control-label'>Mobile Number</label>
							<input class='form-control' type='text' name='mobile'/>
						</div>
					</div>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label class='control-label'>Email ID</label>
							<input class='form-control' type='text' name='email'/>
						</div>
					</div>
				</div>
			</div>
			<div class="text-right pb-4 pr-4 evet-btn-min">
				<button type="button" class="btn evet-btn evet-btn-col1" data-dismiss="modal">Close</button>
				<input type="submit" name="complaint_meeting" class="btn save-event  evet-btn evet-btn-col2" value="Submit" />
			</div>
			</form>
		</div> <!-- end modal-content-->
	</div> <!-- end modal dialog-->
</div>
<!-- end modal-->	
	

<!-- Delete  Event MODAL -->
<div class="modal fade" id="delete_meeting" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="raised-complaint-db.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
			<div class="modal-header pr-4 pl-4 border-bottom-0 d-block">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
				<h4 class="modal-title">Add new visit request</h4>
			</div>
			<div class="modal-body pt-3 pr-4 pl-4">
        		<div class='row'>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label class='control-label'>Meeting Date</label>
							<input class='form-control' placeholder='' type='text' name='title'/>
						</div>
					</div>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label class='control-label'>Place</label>
							<input class='form-control' placeholder=' ' type='text' name='title'/>
						</div>
					</div>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label class='control-label'> Customer Coordinator (whom to meet)</label>
							<input class='form-control' placeholder=' ' type='text' name='title'/>
						</div>
					</div>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label class='control-label'>Mobile Number</label>
							<input class='form-control' placeholder=' ' type='text' name='title'/>
						</div>
					</div>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label class='control-label'>Email ID</label>
							<input class='form-control' placeholder=' ' type='text' name='title'/>
						</div>
					</div>
				</div>
			</div>
			<div class="text-right pb-4 pr-4 evet-btn-min">
				<input type="submit" name="delete_meeting" class="btn save-event  evet-btn evet-btn-col2" value="Delete" />
				<button type="button" class="btn evet-btn evet-btn-col1" data-dismiss="modal">Close</button>
				<input type="submit" name="update_meeting" class="btn evet-btn btn-success" value="Update" />
			</div>
			</form>
		</div> <!-- end modal-content-->
	</div> <!-- end modal dialog-->
</div>		
<!-- end modal-->

	
	
<!-- Form pop up -->
<div class="modal fade form-pop" id="create-note" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header border-bottom-st d-block">
<!--<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<div class="form-p-hd">
<h2>MAHINDRA INTERTRADE LTD<br>
Credit Note Approval</h2>
</div>


<div class="form-p-block">
<form action="<?php echo "raised-complaint-db.php?id=".$_GET['id']; ?>" method="post" enctype="multipart/form-data">
<!-- box 1 -->
<div class="form-p-box form-p-box-bg2">

<div class="rst-left">
	<ul class="fpall">
		<li class="fp-con1"><p>Name of the customer</p></li>             
		<li class="fp-con2"><input type="text" id=" " name="customer_name" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Complaint reference no</p></li>             
		<li class="fp-con2"><input type="text" id=" " name="complait_reference" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Complant Registration date</p></li>             
		<li class="fp-con2">
			<input readonly class="form-control fodhf date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="true" id="complait_reg_date" type="text"  name="complait_reg_date">
		</li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Material Details  (grade, size etc)</p></li>             
		<li class="fp-con2"><input type="text" id=" " name="material_details" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>
</div>

<div class="rst-right">
	<ul class="fpall">
		<li class="fp-con1"><p>Nature of the complaint</p></li>             
		<li class="fp-con2"><input type="text" id=" " name="nature_of_complaint" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Name of the Steel Mill / Service centre/ Transporter</p></li>             
		<li class="fp-con2"><input type="text" id=" " name="name_of_sm_sc_t" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Responsibility</p></li>             
		<li class="fp-con2"><input type="text" id=" " name="responsibility" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>
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
		<li class="fp-con2"><input type="text" id=" " name="billing_doc_no" class="form-control form-p-box-bg2"></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Billing Document Date</p></li>             
		<li class="fp-con2">
			<input id="billing_doc_date" type="text" name="billing_doc_date" readonly class="form-control fodhf date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="true">
		</li>
		<div class="clerfix"></div>
	</ul>
</div>

<div class="rst-right">
	<ul class="fpall">
		<li class="fp-con1"><p>Total qty (t) rejected by the customer</p></li>             
		<li class="fp-con2"><input type="text" id=" " name="total_qty_rejc" class="form-control form-p-box-bg2"></li>
		<div class="clerfix"></div>
	</ul>
</div>

<div class="clerfix"></div>
</div>
<!-- box 2 -->

<!-- box 3 -->
<div class="form-p-box form-p-box-bg1">

<div class="rst-full">
	<ul class="fpall">
		<li class="fp-con01"><p>Basic sale price</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id=" " name="basic_sale_price" class="form-control form-p-box-bg2 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Sales Value (Basic sale price/t X Qty)</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id=" " name="sales_value" class="form-control form-p-box-bg2 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>CGST @ 9%</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id=" " name="cgst" class="form-control form-p-box-bg2 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>SGST @ 9%</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>
		<input type="text" id=" " name="sgst" class="form-control form-p-box-bg2 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Cost incurred by the customer, (customer has debited us for poor packaging of the material)</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id=" " name="cost_inc_customer" class="form-control form-p-box-bg2 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Salvage value (in case matl scrapped by the customer)</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id=" " name="salvage_value" class="form-control form-p-box-bg2 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p class="colrred">Credit note to be issued to the customer (total of abv net of scrap value)</p></li> 
		<li class="fp-con02"><span class="padd10 colrred">Rs.</span>  
		<input type="text" id=" " name="credit_note_iss_cust" class="form-control form-p-box-bg3 sphf"></li>
		<div class="clerfix"></div>
	</ul>
</div>

<div class="clerfix"></div>
</div>
<!-- box 3 -->

<!-- box 4 -->
<div class="form-p-box form-p-box-bg2">

<div class="rst-full">
	<ul class="fpall">
		<li class="fp-con01"><p>Debit note issued to supplier / Realisation from scrap / To be recovered from Insurance co.</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id=" " name="debit_note_supplier" class="form-control form-p-box-bg1 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Quantity (t) as accepted by steel mill    </p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id=" " name="qty_acpt_steel_mill" class="form-control form-p-box-bg1 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Quantity (t) to be scrapped / auction at service centres </p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id=" " name="qty_scrp_auc_serv_cent" class="form-control form-p-box-bg1 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Quantity (t) to be diverted to any other customer</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id=" " name="qty_dlv_customer" class="form-control form-p-box-bg1 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Debit note (purchase price/t) / Salvage rate / Sale value</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id=" " name="debit_note_sal_rate_sale_value" class="form-control form-p-box-bg2 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Value (purchase price/t  X qty)</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id=" " name="value" class="form-control form-p-box-bg1 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>CGST @ 9%</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id=" " name="loss_cgst" class="form-control form-p-box-bg1 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>SGST @ 9%</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id=" " name="loss_sgst" class="form-control form-p-box-bg1 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Other expenses incurred by MIL (processing cost, freight, octroi et al) *</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id=" " name="oth_exp_inc_mill" class="form-control form-p-box-bg1 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Other expenses to be debited (eg freight) / credited (eg scrap @ 20000 recovery) to steel mill</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id=" " name="oth_exp_debited" class="form-control form-p-box-bg1 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Compensation expected from Insurance Co.</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id=" " name="compensation_exp" class="form-control form-p-box-bg1 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p class="colrred">Debit note issued to supplier / Billing back to customer / Realisation from scrap</p></li> 
		<li class="fp-con02"><span class="padd10 colrred">Rs.</span>  
		<input type="text" id=" " name="debit_note_iss_supplier" class="form-control form-p-box-bg3 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p class="colrred">Loss from the Rejection </p></li> 
		<li class="fp-con02"><span class="padd10 colrred">Rs.</span>  
		<input type="text" id=" " name="loss_from_rejection" class="form-control form-p-box-bg3 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Recoverable from Transporter (if applicable)</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id=" " name="recoverable_transporter" class="form-control form-p-box-bg1 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p class="colrred">Net loss </p></li> 
		<li class="fp-con02"><span class="padd10 colrred">Rs.</span>  
		<input type="text" id=" " name="net_loss" class="form-control form-p-box-bg3 sphf"></li>
		<div class="clerfix"></div>
	</ul>
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
	<button type="button" class="fpcl" data-dismiss="modal">Close</button>
	<input type="submit" name="create_a_note" class="fpdone" value="Save" />
</div>

</form>
<div class="clerfix"></div>
</div>


</div>



<!-- end modal-body-->
</div> <!-- end modal-content-->
</div> <!-- end modal dialog-->
</div>
<!-- Form pop up -->

	

<!------------------------------------------ CAPA Form pop up ---------------------------------------------------------------->
<div class="modal fade form-pop" id="create-capa" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header border-bottom-st d-block">
<!--<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<div class="form-p-hd">
<h2>MAHINDRA STEEL SERVICE CENTRE LTD. (PLANT I)<br>
Corrective And Preventive Action Report</h2>
</div>


<div class="form-p-block">
<form action="<?php echo "raised-complaint-db.php?id=".$_GET['id']; ?>" method="post" enctype="multipart/form-data">	
<!-- box 1 -->
<div class="form-p-box form-p-box-bg2">

<div class="sectp-fom">
<h2 class="sectphd">Management Representative</h2>

<ul class="fpall-z">
	<li class="fp-con1-z"><p class="padd10">Document No.</p></li> 
	<li class="fp-con2-z"><input type="text" id="document_no" name="document_no" class="form-control form-p-box-bg1"></li>
</ul>

<ul class="fpall-z">
	<li class="fp-con1-z"><p class="padd10">Rev. No.</p></li> 
	<li class="fp-con2-z"><input type="text" id="rev_no" name="rev_no" class="form-control form-p-box-bg1"></li>
</ul>

<ul class="fpall-z">
	<li class="fp-con1-z"><p class="padd10">Page No.</p></li> 
	<li class="fp-con2-z"><input type="text" id="page_no" name="page_no" class="form-control form-p-box-bg1"></li>
</ul>
<div class="clerfix"></div>
</div>


<div class="clerfix"></div>
</div>
<!-- box 1 -->

<!-- box 2 -->
<div class="form-p-box form-p-box-bg1 border-bottom-st">

<div class="rst-left">
<ul class="fpall">
	<li class="fp-con1"><p>Customer Name</p></li>             
	<li class="fp-con2"><input type="text" id="customer_name" name="customer_name" class="form-control form-p-box-bg2"></li>
	<div class="clerfix"></div>
</ul>

<ul class="fpall">
	<li class="fp-con1"><p>Model</p></li>             
	<li class="fp-con2"><input type="text" id="model" name="model" class="form-control form-p-box-bg2"></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
	<li class="fp-con1"><p>Date of issue</p></li>             
	<li class="fp-con2">
		<input id="date_issue" type="text" name="date_issue" readonly class="form-control date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="true">
	</li>
<div class="clerfix"></div></ul>

<ul class="fpall">
	<li class="fp-con1"><p>Team Members</p></li>             
	<li class="fp-con2"><input type="text" id="team_member" name="team_member" class="form-control form-p-box-bg2"></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
	<li class="fp-con1"><p>Reviewed By</p></li>             
	<li class="fp-con2"><input type="text" id="reviewed_by" name="reviewed_by" class="form-control form-p-box-bg2"></li>
	<div class="clerfix"></div>
</ul>

<ul class="fpall">
	<li class="fp-con1"><p>Contact Person Name</p></li>             
	<li class="fp-con2"><input type="text" id="contact_person_name" name="contact_person_name" class="form-control form-p-box-bg2"></li>
	<div class="clerfix"></div>
</ul>

</div>

<div class="rst-right">
<ul class="fpall">
	<li class="fp-con1"><p>CAPA No.</p></li>             
	<li class="fp-con2"><input type="text" id="capa_no" name="capa_no" class="form-control form-p-box-bg2"></li>
	<div class="clerfix"></div>
</ul>

<ul class="fpall">
	<li class="fp-con1"><p>Reported By</p></li>             
	<li class="fp-con2"><input type="text" id="reported_by" name="reported_by" class="form-control form-p-box-bg2"></li>
	<div class="clerfix"></div>
</ul>

<ul class="fpall">
	<li class="fp-con1"><p>Problem Description</p></li>             
	<li class="fp-con2"><input type="text" id="problem_desc" name="problem_desc" class="form-control form-p-box-bg2"></li>
	<div class="clerfix"></div>
</ul>

<ul class="fpall">
	<li class="fp-con1"><p>Feedback Date</p></li>             
	<li class="fp-con2">
		<input id="feedback_date" type="text" name="feedback_date" readonly class="form-control date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="true">
	</li>
	<div class="clerfix"></div>
</ul>

<ul class="fpall">
	<li class="fp-con1"><p>Reviewed Date</p></li>             
	<li class="fp-con2">
		<input id="reviewed_date" type="text" name="reviewed_date" readonly class="form-control date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="true">
	</li>
	<div class="clerfix"></div>
</ul>

</div>

<div class="clerfix"></div>
</div>
<!-- box 2 -->

<!-- box 3 -->
<div class="form-p-box form-p-box-bg2 border-bottom-st">

<div class="sectp-fom">
<h2 class="sectphd">1. Problem Description</h2>

<ul class="ulsp1">
	<li class="ulsp1-l"><p>Where</p></li>
	<li class="ulsp1-r"><input type="text" id="problem_where" name="problem_where" class="form-control form-p-box-bg1"></li>
	<div class="clerfix"></div>
</ul>

<ul class="ulsp1">
	<li class="ulsp1-l"><p>When</p></li>
	<li class="ulsp1-r"><input type="text" id="problem_when" name="problem_when" class="form-control form-p-box-bg1"></li>
	<div class="clerfix"></div>
</ul>

<ul class="ulsp1">
	<li class="ulsp1-l"><p>What Qty </p></li>
	<li class="ulsp1-r"><input type="text" id="problem_what_qty" name="problem_what_qty" class="form-control form-p-box-bg1"></li>
	<div class="clerfix"></div>
</ul>

<ul class="ulsp1">
	<li class="ulsp1-l"><p>Which Model</p></li>
	<li class="ulsp1-r"><input type="text" id="problem_which_model" name="problem_which_model" class="form-control form-p-box-bg1"></li>
	<div class="clerfix"></div>
</ul>

<ul class="ulsp1">
	<li class="ulsp1-l"><p>Who Produced</p></li>
	<li class="ulsp1-r"><input type="text" id="problem_who_produced" name="problem_who_produced" class="form-control form-p-box-bg1"></li>
	<div class="clerfix"></div>
</ul>

<div class="clerfix"></div>
</div>


<div class="clerfix"></div>
</div>
<!-- box 3 -->

<!-- box 4-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
	<div class="sectp-fom">
		<h2 class="sectphd">2. Findings / Investigation</h2>
		<textarea class="form-control mrig10 form-p-box-bg1" id="finding_invest_remark" name="finding_invest_remark" placeholder="Remarks" rows="3"></textarea>
		<div class="clerfix"></div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- box 4 -->

<!-- box 5-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
	<div class="sectp-fom">
		<h2 class="sectphd">3. Structured & systematic analysis of probable causes</h2>
		<textarea class="form-control mrig10 form-p-box-bg1" id="structured_remark" name="structured_remark" placeholder="Remarks" rows="3"></textarea>
		<div class="clerfix"></div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- box 5 -->

<!-- box 6-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
	<div class="sectp-fom">
		<h2 class="sectphd">4. Root cause identified</h2>
		<textarea class="form-control mrig10 form-p-box-bg1" id="root_cause_remark" name="root_cause_remark" placeholder="Remarks" rows="3"></textarea>
		<div class="clerfix"></div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- box 6 -->

<!-- box 7-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
	<div class="sectp-fom">
		<h2 class="sectphd">5. Correction</h2>
		<textarea class="form-control mrig10 form-p-box-bg1" id="correction_remark" name="correction_remark" placeholder="Remarks" rows="3"></textarea>
		<input type="text" id="correction_who" name="correction_who" placeholder="Who" class="form-control form-p-box-bg1 mrig10">
		<input type="text" id="correction_when" name="correction_when" placeholder="When" class="form-control form-p-box-bg1 mrig10">

		<div class="clerfix"></div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- box 7 -->

<!-- box 8-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
	<div class="sectp-fom">
		<h2 class="sectphd">6. Corrective Action</h2>
		<textarea class="form-control mrig10 form-p-box-bg1" id="verify_remark" name="verify_remark" placeholder="Remarks" rows="3"></textarea>
		<input type="text" id="verify_who" name="verify_who" placeholder="Who" class="form-control form-p-box-bg1 mrig10">
		<input type="text" id="verify_when" name="verify_when" placeholder="When" class="form-control form-p-box-bg1 mrig10">

		<div class="clerfix"></div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- box 8 -->

<!-- box 9-->
<div class="form-p-box form-p-box-bg2 border-bottom-st">
	<div class="sectp-fom">
		<h2 class="sectphd">7. Verification of Effectiveness:</h2>
		<textarea class="form-control mrig10 form-p-box-bg1" id="prevent_remark" name="prevent_remark" placeholder="Remarks" rows="3"></textarea>
		<input type="text" id="prevent_who" name="prevent_who" placeholder="Who" class="form-control form-p-box-bg1 mrig10">
		<input type="text" id="prevent_when" name="prevent_when" placeholder="When" class="form-control form-p-box-bg1 mrig10">

		<div class="clerfix"></div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- box 9 -->

<!-- box 9-->
<div class="form-p-box form-p-box-bg2">
	<div class="sectp-fom">
		<h2 class="sectphd">8. Preventive action (Horizontal deployment)if applicable</h2>
		<textarea class="form-control mrig10 form-p-box-bg1" id="example-textarea" placeholder="Remarks" rows="3"></textarea>
		<input type="text" id=" " placeholder="Who" class="form-control form-p-box-bg1 mrig10">
		<input type="text" id=" " placeholder="When" class="form-control form-p-box-bg1 mrig10">

		<div class="clerfix"></div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- box 9 -->

 <div class="form-p-box form-p-boxbtn">
	<input type="button" class="fpcl" data-dismiss="modal" aria-hidden="true" value="Cancel" />
	<input type="submit" name="save_capa" value="Save" class="fpdone" />
</div>

<div class="clerfix"></div>
</form>	
</div>

</div>

<!-- end modal-body-->
</div> <!-- end modal-content-->
</div> <!-- end modal dialog-->
</div>
<!-- Form pop up -->	
	
	

	
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

	<!-- demo app -->
	<script src="assets/js/pages/demo.calendar.js"></script>
	<!-- end demo js-->
<!-- fancyBox Js includ -->
	<?php include 'fancyboxjs.php'?>
<!-- fancyBox Js includ -->

<script>
	
	$('#calendar').fullCalendar({
		  events: [
			<?php
				$sql = "Select * from complaint_meeting where complaint_id = '{$_GET['id']}'";
				$comp_meet = ComplaintMeeting::find_by_sql($sql);
	
				foreach($comp_meet as $comp_meet){
			?>
			  	{
				  id  	 : <?php echo $comp_meet->id; ?>,
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
		  }
	});


	var calendar = $('#calendar').fullCalendar('getCalendar');

	calendar.on('dayClick', function(date, jsEvent, view) {
		console.log('clicked on ' + date.format());	
		$('#complaint_meeting').modal('toggle');
		
		$('#meeting_date').val($.fullCalendar.formatDate( date, "YYYY-MM-DD"));
		
		//$("#meeting_date").val();
	});
	

	$(document).ready(function() {


	});
	
	
	$('.view_approval_note').click(function() {
		var data_id = $(this).attr('data-id');
		$("#view-approval-note .modal-content").load("view-approval-note.php?id="+data_id);
	});
	
	$('.view_capa').click(function() {
		var data_id = $(this).attr('data-id');
		$("#view-capa .modal-content").load("view-capa.php?id="+data_id);
	});
		
	
</script>

</body>
</html>


