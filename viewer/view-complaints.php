<?php
	ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	foreach ($_POST as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("all-complaints.php");
		} 
	}
	foreach ($_GET as $key => $value) {
		if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
			$session->message("Remove Special Character from Search Form"); redirect_to("all-complaints.php");
		}
	}
	
	$employee_reg = EmployeeReg::find_by_id($session->employee_id);
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }
	if ($session->is_employee_logged_in()){ 
		$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role = 'Viewer' Limit 1";
		$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);
		if(!$employee_location){
			redirect_to("logout.php"); 
		}
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$complaint_reg = Complaint::find_by_id($_GET['id']);
	} else {
		$session->message("Complaint Not Found");
		redirect_to("my-complaints.php");
	}

 $sql = "Select * from approval_note where complaint_id = {$complaint_reg->id} ORDER By id desc ";
$approval_notes = ApprovalNote::find_by_sql($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Mahindraaccelo</title>
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



<?php  $message = output_message($message); ?>
<div class="alert fade show text-white <?php 
	if($message == "Meeting Added Successfully"){echo "bg-success";} 
	else if($message == "Complaint Updated Successfully"){echo "bg-success";} 		
	else if($message == "Approval Note Created Successfully"){echo "bg-success";} 		
	else if($message == "CAPA Created Successfully"){echo "bg-success";} 		
	else {echo "bg-danger";}?>" 
<?php if(empty($message)){echo " style='display:none';";} else {echo " style='margin-top:20px';";} ?> >
<a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
<?php echo $message; ?>
</div>
<!-- Start Content-->
<div class="container-fluid">

<div class="">

<!-- top box -->
<?php if(isset($_GET['id'])){?>
<div class="complaints-blocks">
	

<div class="cb-block">

<div class="cmp-lf"><h2>Complaint details - <?php echo $complaint_reg->company_name; ?>   |   Complaint No. <?php echo $complaint_reg->ticket_no; ?></h2></div>
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
<td class="fsd-2"><span><?php echo $complaint_reg->ticket_no; ?></span></td>
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
</div></div>
</div>
<!-- top box -->
<?php } ?>



<div class="complaints-blocks2" >
<div class="cb-block">
<!-- 1 -->
<div class="onlock">
	

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
<div class="onlock" <?php if($complaint_reg->identify_source == ""){echo "style='display:none'";} ?>>
	
		
	<!------------------------------ Data Below ---------------------------->
	<div id="request_visit_2" <?php if(empty($complaint_reg->request_visit) || $complaint_reg->request_visit == "No"){echo "style='display:none;'";}?>>
		
		<?php $complaint_meeting = ComplaintMeeting::find_by_comp_id($_GET['id']); ?>
		<div class="onlock-cov">
		<div class="onlock-3"><p class="colost1">Request a Visit</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_meeting->request_visit; ?></p></div>
		<div class="clerfix"></div>
		<div class="onlock-3"><p class="colost1">Date</p></div>
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
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_meeting->mobile; ?></p></div>
		</div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- 2 -->

<!-- 3 -->
<div class="onlock" <?php if($complaint_reg->request_visit != "Yes"){echo "style='display:none'";} ?>>
	

	<!------------------------------ Data Below ---------------------------->
	<div id="visit_done_2" <?php if(empty($complaint_reg->visit_done)){echo "style='display:none;'";}?>>
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
		<div class="lrbox2">
			<?php if(empty($complaint_reg->plant_img_1)){ echo "N/A"; } ?>
			<a <?php if(empty($complaint_reg->plant_img_1)){ echo "style='display:none;'"; } ?> class="fancybox-thumbs" data-fancybox-group="thumb2" href="<?php echo "../document/{$complaint_reg->ticket_no}/plant/{$complaint_reg->plant_img_1}";?>">Open link</a>
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
<div class="onlock" <?php if($complaint_reg->visit_done != "Yes"){echo "style='display:none'";} ?>>
	
	<!------------------------------ Data Below ---------------------------->
	<div id="complaint_accepted_2" <?php if(empty($complaint_reg->complaint_accepted)){echo "style='display:none;'";}?>>
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
			<div class="onlock-3"><p class="colost2"><?php echo date('d-m-Y', strtotime($complaint_reg->action_by_date)); ?></p></div>
			<?php } ?>	
		</div>
	</div>

	<div class="clerfix"></div>
</div>
<!-- 4 -->

<!-- 5 -->
<div class="onlock" <?php if($complaint_reg->complaint_accepted != "Yes"){echo "style='display:none'";} ?>>
	
	
	<!------------------------------ Data Below ---------------------------->
	<div id="approval_action_taken_2" <?php if(empty($complaint_reg->approval_action_taken)){echo "style='display:none;'";}?>>
		<div class="onlock-1"><p class="colost1">Approval Note</p></div>
		<div class="onlock-2">
		<div class="lrbox001">
		<div class="lrbox1"><p class="colost2">Document</p></div>
		<div class="lrbox2">
			<?php 
				if($complaint_reg->create_approval_note != "Yes"){
					echo "No";
				} else {
			?>   
           <?php 
            if( count($approval_notes) ){
                foreach ($approval_notes as $key => $value) {
                          if($value->on_hold != 1){
                              echo '<a data-toggle="modal" class="view_approval_note" data-id="'.$value->id.'" data-target="#view-approval-note" href="#">Open link</a>';
                          }
                      }
                  }
                
            ?>

					<!-- <a data-toggle="modal" class="view_approval_note" data-id="<?php echo $complaint_reg->approval_note; ?>" data-target="#view-approval-note" href="#">Open link</a>			 -->
			<?php
				}
			?>
		</div>
		<div class="clerfix"></div>
		</div></div>
		<div class="clerfix"></div>
		<div class="onlock-1"><p class="colost1">Action Taken</p></div>
		<div class="onlock-2"><p class="colost2"><?php
			if($complaint_reg->approval_action_taken == "Others"){
				echo $complaint_reg->approval_action_taken ." : ".$complaint_reg->approval_action_taken_specify;
			}	
		?></p></div>
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
		</div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- 5 -->

<!-- 6 -->
<div class="onlock" <?php if($complaint_reg->cna_cfo != "Yes"){echo "style='display:none'";} ?>>
	

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
		</div>
		<div class="clerfix"></div>
	</div>
</div>
<!-- 6 -->

<div class="onlock" <?php if($complaint_reg->settlement == ""){echo "style='display:none'";} else {echo "style='border-bottom:none;padding:0;';";} ?>>
	
	<!------------------------------ Data Below ---------------------------->
	<div id="capa_2" <?php if(empty($complaint_reg->capa)){echo "style='display:none;'";}?>>
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
		<div class="clerfix"></div>
		<div class="onlock-1 mrig8"><p class="colost1 ">Credit note Approval</p></div>
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



<div class="clerfix"></div>
</div>


<div class="clerfix"></div>

</div>

<div class="complaints-blocks2" <?php if(empty($complaint_reg->complaint_analysis)){echo "style='display:none'";} ?>>
	<div class="cb-block">
	<!-- 1 -->
		<div class="onlock" style="border:0px">
			<div class="ontow-1">
			<p><strong>Complaint Analysis</strong></p>
			</div>

			<div class="ontow-2">
			<ul>
			<?php if($complaint_reg->complaint_analysis == "Sporadic"){?>
			<li <?php if($complaint_reg->complaint_analysis == "Sporadic"){echo "class='active'";}?>><a href="#" class="colost1">
			<img src="assets/images/icons/1.png">
			<p>Sporadic</p>
			</a></li>
			<?php } ?>
			<?php if($complaint_reg->complaint_analysis == "Chronic"){?>
			<li <?php if($complaint_reg->complaint_analysis == "Chronic"){echo "class='active'";}?>><a href="#" class="colost1">
			<img src="assets/images/icons/2.png">
			<p>Chronic</p>
			</a></li>
			<?php } ?>
			<?php if($complaint_reg->complaint_analysis == "Major"){?>
			<li <?php if($complaint_reg->complaint_analysis == "Major"){echo "class='active'";}?>><a href="#" class="colost1">
			<img src="assets/images/icons/3.png">
			<p>Major</p>
			</a></li>
			<?php } ?>
			<?php if($complaint_reg->complaint_analysis == "Minor"){?>
			<li <?php if($complaint_reg->complaint_analysis == "Minor"){echo "class='active'";}?>><a href="#" class="colost1">
			<img src="assets/images/icons/4.png">
			<p>Minor</p>
			</a></li>
			<?php } ?>
			<?php if($complaint_reg->complaint_analysis == "Invalid"){?>
			<li <?php if($complaint_reg->complaint_analysis == "Invalid"){echo "class='active'";}?>><a href="#" class="colost1">
			<img src="assets/images/icons/5.png">
			<p>Invalid</p>
			</a></li>
			<?php } ?>
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

	<!-- demo app 
	<script src="assets/js/pages/demo.calendar.js"></script>
	<!-- end demo js-->
<!-- fancyBox Js includ -->
	<?php include 'fancyboxjs.php'?>
<!-- fancyBox Js includ -->
<style>
	.ontow-1{ float:left; width:21%}
	.ontow-2{ float:left; width:56%}
	.ontow-3{ float:right; padding:30px 0 0}
	.ontow-2 ul{ margin:auto; padding:0; text-align:left;}
	.ontow-2 ul li{ list-style-type:none; display:inline-block; padding:10px 20px; color: #000 !important;}
	.ontow-2 ul li {filter: none;-webkit-filter: grayscale(0); opacity:0.9}
	.ontow-2 ul li p{ color: #484848!important;}
	.ontow-2 ul li img{ filter: gray;-webkit-filter: grayscale(1);-webkit-transition: all .2s ease-in-out; opacity:0.5 }
	.ontow-2 ul li.active img {filter: none;-webkit-filter: grayscale(0); opacity:0.9}
	.ontow-2 ul li p{ padding:5px 0}

</style>
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


