<?php ob_start();
	require_once("../includes/initialize.php"); 
	if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$complaint_reg = Complaint::find_by_id($_GET['id']);
		
		$get_comp_id = CompanyReg::authenticate_customer_id($complaint_reg->customer_id);

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
<td class="fsd-2"><span><?php echo $complaint_reg->invoice_date; ?></span></td>
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
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
	<!------------------------------ Data Form Below ---------------------------->
	<div id="id_source_1" <?php if($complaint_reg->client_contacted == "Yes"){echo "style='display:none;'";}?>>
		<form action="<?php echo "raised-complaint-db.php?id=".$_GET['id']; ?>" method="post" enctype="multipart/form-data">
		<div class="paddi15"></div>

		<div class="idf-sort">
		<div class="idf-sort-lft"><p>Identify the Source</p></div>
			<div class="idf-sort-rig onlock-2-acbtn id_source">
				<input type="button" class="btn btn-light id_source_plant" value="Plant" />   
				<input type="button" class="btn btn-light id_source_mil" value="Mill" />
				<input type="hidden" class="id_source_val" id="id_source" name="id_source" value="<?php if(!empty($complaint_reg->identify_source)){echo $complaint_reg->identify_source; } else {echo "";}?>" />
				<span class="err_msg id_source_msg"></span>
			</div>
		<div class="clerfix"></div>
		</div>

		<div class="idf-sort select_mill" style="display: none;">
			<div class="idf-sort-lft"><p>Select Mill</p></div>
			<div class="idf-sort-rig">
				<select id="select_mill" name="select_mill" class="form-control form-controlws">
				<option value="">- Select Mill -</option>
				<?php
					$mill_reg = MillReg::find_all();
					foreach($mill_reg as $mill_reg){
						echo "<option ";
							if($complaint_reg->mill == $mill_reg->mill_name){echo "Selected";}
						echo " >{$mill_reg->mill_name}</option>";
					}
				?>
				</select><span class="err_msg select_mill_msg"></span>
			</div>
			<div class="clerfix"></div>
		</div>

		<div class="idf-sort">
		<div class="idf-sort-lft"><p>Customer Contacted</p></div>
			<div class="idf-sort-rig onlock-2-acbtn client_contacted">
				<input type="button" class="btn btn-light client_contacted_yes" value="Yes" />   
				<input type="button" class="btn btn-light client_contacted_no" value="No" />
				<input type="hidden" class="client_contacted_val" id="client_contacted" name="client_contacted" value="<?php if(!empty($complaint_reg->client_contacted)){echo $complaint_reg->client_contacted; } else {echo "";}?>" />
				<span class="err_msg client_contacted_msg"></span>
			</div>
		<div class="clerfix"></div>
		</div>

		<div class="idf-sort" id="identify_source_remark" <?php if(empty($complaint_reg->identify_source_remark)){echo "style='display:none';";} ?>>
		<div class="idf-sort-lft"><p>&nbsp;</p></div>
		<div class="idf-sort-rig">
			<textarea class="form-control identify_source_remark" placeholder="Add Remark" rows="5" name="identify_source_remark"><?php echo $complaint_reg->identify_source_remark; ?></textarea>
			<span class="err_msg identify_source_remark_msg"></span>
		</div>
		<div class="clerfix"></div>
		</div>

		<div class="idf-sort">
		<div class="idf-sort-lft"><p>&nbsp;</p></div>
		<div class="idf-sort-rig log-btn"><input type="submit" id="identify_the_source" name="identify_the_source" class="btn btn-primary2" /></div>
		<div class="clerfix"></div>
		</div>
		</form>
	</div>

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
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
	<!------------------------------ Data FORM Below ---------------------------->
	<div id="request_visit_1" <?php if($complaint_reg->request_visit == "Yes"){echo "style='display:none;'";}?>>
		<form action="<?php echo "raised-complaint-db.php?id=".$_GET['id']; ?>" method="post" enctype="multipart/form-data">	

		<div class="paddi10"></div>

		<div class="onlock-1"><p>Request a Visit</p></div>
		<div class="onlock-2">
			<div class="request_visit">
				<?php $auth_meeting	= ComplaintMeeting::find_by_comp_id($complaint_reg->id); ?>
				<input type="button" class="btn <?php if($complaint_reg->request_visit == "Yes"){echo "btn-primary";} else if($complaint_reg->request_visit == "No"){echo "btn-light";} else {echo "btn-light";}?> request_visit_yes" value="Yes" />    
				<input type="button" class="btn <?php if($complaint_reg->request_visit == "No"){echo "btn-primary";} else if($complaint_reg->request_visit == "Yes"){echo "btn-light";} else {echo "btn-light";}?> request_visit_no" value="No" />
				<input type="hidden" class="request_visit_val" name="request_visit" value="<?php if(!empty($complaint_reg->request_visit)){echo $complaint_reg->request_visit;} else {echo "";}?>" />
				<span class="err_msg request_visit_msg"></span>
			</div>
			<div class="cldblock request_remark" <?php if($complaint_reg->request_visit != "No"){echo "style='display:none'";} ?>>
				<textarea class="form-control" name="request_remark" id="request_remark" placeholder="Request Remark" rows="3"><?php echo $complaint_reg->request_remark; ?></textarea>
				<span class="err_msg request_remark_msg"></span>
			</div>
		<div class="cldblock">
			<div id="calendar" <?php 
				 $auth_meeting	= ComplaintMeeting::find_by_comp_id($complaint_reg->id);
				 if(!$auth_meeting){
					 if($complaint_reg->request_visit == "No"){echo "style='display:none;'";}
				 } else {
					 if($complaint_reg->request_visit == "No"){echo "style='display:none;'";}
				 } 			 
			?>></div>
		</div>

		<div class="clerfix"></div>
		</div>

		<div class="clerfix">&nbsp;</div>

		<div class="idf-sort">
		<div class="idf-sort-lft"><p>&nbsp;</p></div>
		<div class="idf-sort-rig log-btn"><input type="submit" id="request_a_visit" name="request_a_visit" class="btn btn-primary2"/></div>
		<div class="clerfix"></div>
		</div>
		</form>
	</div>
		
	<!------------------------------ Data Below ---------------------------->
	<div id="request_visit_2" <?php if(empty($complaint_reg->request_visit) || $complaint_reg->request_visit == "No"){echo "style='display:none;'";}?>>
		
		<?php $complaint_meeting = ComplaintMeeting::find_by_comp_id($_GET['id']); ?>
		<div class="onlock-cov">
		<div class="onlock-3"><p class="colost1">Request a Visit</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_meeting->request_visit; ?></p></div>
		<div class="clerfix"></div>
		<div class="onlock-3"><p class="colost1">Date</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_meeting->meeting_date; ?></p></div>
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
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
	<!------------------------------ Data FORM Below ---------------------------->
	<div id="visit_done_1" <?php if(!empty($complaint_reg->visit_done) && $complaint_reg->visit_done == "Yes"){echo "style='display:none;'";}?>>
	<form action="<?php echo "raised-complaint-db.php?id=".$_GET['id']; ?>" method="post" enctype="multipart/form-data">

		<div class="paddi10"></div>
		<div class="onlock" style="border:none">
		<div class="onlock-1"><p>Visit Done</p></div>
		<div class="onlock-2">
			<div class="visit_done">
				<input type="button" class="btn <?php if($complaint_reg->visit_done == "Yes"){echo "btn-primary";} else if($complaint_reg->visit_done == "No"){echo "btn-light";} else {echo "btn-light";}?>  visit_done_yes" value="Yes" />   
				<input type="button" class="btn <?php if($complaint_reg->visit_done == "No"){echo "btn-primary";} else if($complaint_reg->visit_done == "Yes"){echo "btn-light";} else {echo "btn-light";}?> visit_done_no" value="No" />
				<input type="hidden" class="visit_done_val" name="visit_done" value="<?php if(!empty($complaint_reg->visit_done)){echo $complaint_reg->visit_done;} else {echo "";}?>" />
				<span class="err_msg visit_done_msg"></span>
			</div>
		</div>
		
		<div class="onlock-1 visit_no" <?php if($complaint_reg->visit_done != "No"){echo "style='display:none;'";}?>><div class="clerfix">&nbsp;</div>	<p>Remark</p></div>	
		<div class="onlock-2 visit_no" <?php if($complaint_reg->visit_done != "No"){echo "style='display:none;'";}?>><div class="clerfix">&nbsp;</div>	
			<textarea class="form-control" name="visit_remark" id="visit_remark" placeholder="Visit Remark" rows="3"><?php echo $complaint_reg->visit_remark; ?></textarea>
			<span class="err_msg visit_remark_msg"></span>
		</div>
		<div class="onlock-1 visit_yes" <?php if($complaint_reg->visit_done != "Yes"){echo "style='display:none;'";}?>><p>&nbsp;</p></div>	
		<div class="onlock-2 visit_yes" <?php if($complaint_reg->visit_done != "Yes"){echo "style='display:none;'";}?>>
			<div class="onfod">
				<div class="input-group">
					<div class="input-group-prepend">
					<span class="input-group-text clear_img mom_document" title="Clear Image">X</span>
				</div>
				<div class="custom-file">
					<input type="file" name="mom_document" class="custom-file-input" id="mom_document">
					<label class="custom-file-label" for="mom_document">upload MOM document</label>
				</div>
			</div>
			<span class="sdcon">(Please use .JPG or .PDF file format)</span>

			<p class="colost2 paddi5">OR</p>
			<textarea class="form-control" name="mom_written" id="mom_written" placeholder="Add Remark " rows="3"></textarea>
			<span class="err_msg mom_written_msg"></span>
			</div>

			<div class="onfod">

			<p class="colost2"><strong class="colost2">Upload plant images </strong><span class="sdcon">(Use minimum 2 images in .JPG or .PDF file format)</span></p>

				<div class="plant_img">
					<div class="input-group plant-img-row plant_img_row_1">
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text clear_img clear_img_1" title="Clear Image">X</span>
							</div>
							<div class="custom-file">
								<input type="file" name='plant_img_1' class="custom-file-input" id="plant_img_1">
								<label class="custom-file-label" for="plant_img_1">Upload plant image</label>
							</div>
						</div>
					</div>
				</div>
				<div class="input-group">
					<div class="custom-file">
						<button type="button" name="plant_btn" class="btn btn-success add_plant_img"><i class="mdi mdi-plus"></i> Add Image</button>
						&nbsp; &nbsp; 
						<button type="button" name="plant_btn" class="btn btn-danger rem_plant_img"><i class="mdi mdi-minus"></i> Remove Image</button>
					</div>
				</div>	

		</div>
		<div class="clerfix visit_yes" <?php if($complaint_reg->visit_done != "Yes"){echo "style='display:none;'";}?>></div>
			
		<div class="onlock-1 visit_yes" <?php if($complaint_reg->visit_done != "Yes"){echo "style='display:none;'";}?>><p>Product Status</p></div>
		<div class="onlock-2 visit_yes" <?php if($complaint_reg->visit_done != "Yes"){echo "style='display:none;'";}?>>
			<div class="oldsercj">
				<select id="product_status" name="product_status" class="form-control">
					<option value="">- Select Product -</option>
					<option>Sample Collected</option>
					<option>Trail Conducted</option>
					<option>Sample Test Analysis</option>
					<option>Others</option>
				</select>
				<span class="err_msg product_status_msg"></span>
			</div>

			<textarea class="form-control" id="product_status_specify" name="product_status_specify" placeholder="Please specify" rows="3"></textarea>
		</div>
		<div class="clerfix visit_yes"></div>
			
		<div class="clerfix"></div>
		</div>
		</div>
		<div class="clerfix">&nbsp;</div>

		<div class="idf-sort">
		<div class="idf-sort-lft"><p>&nbsp;</p></div>
		<div class="idf-sort-rig log-btn"> &nbsp; &nbsp; <input type="submit" id="visit_a_done" name="visit_a_done" class="btn btn-primary2"/></div>
		<div class="clerfix"></div>
		</div>
	</form>
	</div>

	<!------------------------------ Data Below ---------------------------->
	<div id="visit_done_2" <?php if(empty($complaint_reg->visit_done) || $complaint_reg->visit_done == "No"){echo "style='display:none;'";}?>>
		<div class="onlock-cov">
		<div class="onlock-3"><p class="colost1">Visit Done</p></div>
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->mill; ?></p>


		<div class="lrbox">
		<div class="lrbox1"><p class="colost2">MOM Document</p></div>
		<div class="lrbox2">
			<a <?php if(empty($complaint_reg->mom_written)){echo "style='display:none;'";} ?> id="mom_write_doc" href="#mom_doc">Open Document</a>
			<a <?php if(empty($complaint_reg->mom_document)){echo "style='display:none;'";} ?> class="fancybox-thumbs" data-fancybox-group="thumb" href="<?php echo "../document/{$complaint_reg->ticket_no}/mom/{$complaint_reg->mom_document}";?>">Open link</a>
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
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
	<!------------------------------ Data Form Below ---------------------------->
	<div id="complaint_accepted_1" <?php if(!empty($complaint_reg->complaint_accepted) && $complaint_reg->complaint_accepted != "Decision Pending"){echo "style='display:none;'";}?>>
		<form action="<?php echo "raised-complaint-db.php?id=".$_GET['id']; ?>" method="post" enctype="multipart/form-data">	

			<div class="onlock" style="border:none">
				<div class="onlock-1"><p class="colost1">Complaint Accepted</p></div>
				<div class="onlock-2">
					<div class="complaint_accepted">
						<input type="button" class="btn <?php if($complaint_reg->complaint_accepted == "Yes"){echo "btn-primary";} else {echo "btn-light";}?> complaint_accepted_yes" value="Yes" />   
						<input type="button" class="btn <?php if($complaint_reg->complaint_accepted == "No"){echo "btn-primary";} else {echo "btn-light";}?> complaint_accepted_no" value="No" />
						<input type="button" class="btn <?php if($complaint_reg->complaint_accepted == "Decision Pending"){echo "btn-primary";} else {echo "btn-light";}?> complaint_accepted_no" value="Decision Pending" />
						<input type="hidden" class="complaint_accepted_val" name="complaint_accepted" value="<?php echo $complaint_reg->complaint_accepted; ?>" />
						<span class="err_msg complaint_accepted_msg"></span>
					</div>
				<div class="clerfix"></div>
				</div>
				<div class="clerfix"></div>
				<div class="onfod" id="complaint_remark" >
					<div class="onlock-1"><p class="colost1 ">Remark</p></div>
					<div class="onlock-2">
						<textarea class="form-control mrig10 complaint_remark" name="complaint_remark" placeholder="Remark" rows="3"><?php echo $complaint_reg->complaint_remark; ?></textarea>
						<span class="err_msg complaint_remark_msg"></span>
					</div>
					<div class="clerfix"></div>
				</div>

				<div class="clerfix"></div>
				<div class="onfod" id="recommended_advice">

					<div class="onlock-1"><p class="colost1 ">Recommended / Adviced</p></div>

					<div class="onlock-2">

					<div class="custom-control custom-radio mrig5"><input type="radio" id="recommended_advice1" value="Replace" name="recommended_advice" class="custom-control-input">
					<label class="custom-control-label colost2" for="recommended_advice1">Replace</label></div>

					<div class="custom-control custom-radio mrig5"><input type="radio" id="recommended_advice2" value="Divert to other Customer" name="recommended_advice" class="custom-control-input">
					<label class="custom-control-label colost2" for="recommended_advice2">Divert to other Customer</label></div>

					<div class="custom-control custom-radio mrig5"><input type="radio" id="recommended_advice3" value="Lift back" name="recommended_advice" class="custom-control-input">
					<label class="custom-control-label colost2" for="recommended_advice3">Lift back</label></div>

					<div class="custom-control custom-radio mrig5"><input type="radio" id="recommended_advice4" value="Rework and Send back" name="recommended_advice" class="custom-control-input">
					<label class="custom-control-label colost2" for="recommended_advice4">Rework and Send back</label></div>

					<div class="custom-control custom-radio mrig5"><input type="radio" id="recommended_advice5" value="Commercial Settle" name="recommended_advice" class="custom-control-input">
					<label class="custom-control-label colost2" for="recommended_advice5">Commercial Settle</label></div>

					<div class="custom-control custom-radio mrig5"><input type="radio" id="recommended_advice6" value="Initiate Insurance Survey" name="recommended_advice" class="custom-control-input">
					<label class="custom-control-label colost2" for="recommended_advice6">Initiate Insurance Survey</label></div>

					<div class="custom-control custom-radio mrig5"><input type="radio" id="recommended_advice7" value="Others" name="recommended_advice" class="custom-control-input">
					<label class="custom-control-label colost2" for="recommended_advice7">Others</label></div>
					<span class="err_msg recommended_advice_msg"></span>
						
					<textarea class="form-control mrig10" id="other_advice" name="other_advice" placeholder="Please specify" rows="3"></textarea>
					<span class="err_msg other_advice_msg"></span>	
					</div>

					<div class="clerfix"></div>
				</div>

				<div class="clerfix"></div>
				<div class="onfod" id="action_by_name">
					<div class="onlock-1">
						<p class="colost1 ">Action By</p>
					</div>
					<div class="onlock-cov2">
						<div class="onlock-3">
							<!--<select name="action_by_name" class="form-control fodhf action_by_name"> -->
							<select name="action_by_name" class="form-control fodhf select2 action_by_name" data-toggle="select2">
								<?php
								
									$employee = EmployeeReg::find_all();
								
									foreach($employee as $employee){
										echo "<option ";
										if($complaint_reg->action_by_name == $employee->emp_name){
											echo "Selected";
										}
										echo ">{$employee->emp_name}</option>";
									}
								?>
								
							</select>
							<span class="err_msg action_by_name_msg"></span>
						</div>
						<div class="onlock-3"><p class="colost2"><span class="padd10">Date</span> 
							<?php
								if($complaint_reg->action_by_date != "0000-00-00"){
									$action_by_date = strtotime($complaint_reg->action_by_date); 
									$action_by_date = date("m/d/Y", $action_by_date);
								} else { $action_by_date = ""; }
								
							?>
							<input readonly class="form-control fodhf date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="true" id="action_by_date" type="text" value="<?php echo $action_by_date; ?>" name="action_by_date"></p>
							<span class="err_msg action_by_date_msg"></span>
						</div>
					</div>
					<div class="clerfix"></div>
				</div>

				<div class="">
					<div class="onlock-1">
						&nbsp;
					</div>
					<div class="onlock-cov2">
						<div class="btspa">
							<div class="form-group mb-0 text-center log-btn">
								<input type="submit" id="complaint_a_accepted" name="complaint_a_accepted" class="btn btn-primary2"/>
							</div>
						</div>
					</div>
					<div class="clerfix"></div>
				</div>
			</div>

		</form>
	</div>
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
			<div class="onlock-3"><p class="colost1">Date</p></div>
			<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->action_by_date; ?></p></div>
			<?php } ?>	
		</div>
	</div>

	<div class="clerfix"></div>
</div>
<!-- 4 -->

<!-- 5 -->
<div class="onlock" <?php if($complaint_reg->complaint_accepted != "Yes"){echo "style='display:none'";} ?>>
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
	<!------------------------------ Data Form Below ---------------------------->
	<div id="approval_action_taken_1" <?php if(!empty($complaint_reg->approval_action_taken)){echo "style='display:none;'";}?>>
		<form action="<?php echo "raised-complaint-db.php?id=".$_GET['id']; ?>" method="post" enctype="multipart/form-data">	

		<div class="onlock" style="border:none">
			<div class="onfod">
				<div class="onlock-1"><p class="colost1">Approval Note</p></div>
				<div class="onlock-2">
					<a class="onlock-link " href="#" data-toggle="modal" data-target="#create-note" >Create Note</a>
					<div class="clerfix"></div>
				</div>
				<div class="clerfix"></div>
			</div>

			<div class="onlock-1"><p class="colost1 ">Action Taken</p></div>

			<div class="onlock-2" id="approval_action_taken">

			<div class="custom-control custom-radio mrig5"><input type="radio" value="Replaced" id="approval_action_taken1" name="approval_action_taken" class="custom-control-input approval_action_taken">
			<label class="custom-control-label colost2" for="approval_action_taken1">Replaced</label></div>

			<div class="custom-control custom-radio mrig5"><input type="radio" value="Diverted to Other Customer" id="approval_action_taken2" name="approval_action_taken" class="custom-control-input approval_action_taken">
			<label class="custom-control-label colost2" for="approval_action_taken2">Diverted to Other Customer</label></div>

			<div class="custom-control custom-radio mrig5"><input type="radio" value="Lifted back" id="approval_action_taken3" name="approval_action_taken" class="custom-control-input approval_action_taken">
			<label class="custom-control-label colost2" for="approval_action_taken3">Lifted back</label></div>

			<div class="custom-control custom-radio mrig5"><input type="radio" value="Reworked and Send back" id="approval_action_taken4" name="approval_action_taken" class="custom-control-input approval_action_taken">
			<label class="custom-control-label colost2" for="approval_action_taken4">Reworked and Send back</label></div>

			<div class="custom-control custom-radio mrig5"><input type="radio" value="Commercial Settled" id="approval_action_taken5" name="approval_action_taken" class="custom-control-input approval_action_taken">
			<label class="custom-control-label colost2" for="approval_action_taken5">Commercial Settled</label></div>

			<div class="custom-control custom-radio mrig5"><input type="radio" value="Initiated Insurance Survey" id="approval_action_taken6" name="approval_action_taken" class="custom-control-input approval_action_taken">
			<label class="custom-control-label colost2" for="approval_action_taken6">Initiated Insurance Survey</label></div>

			<div class="custom-control custom-radio mrig5"><input type="radio" value="Others" id="approval_action_taken7" name="approval_action_taken" class="custom-control-input approval_action_taken">
			<label class="custom-control-label colost2" for="approval_action_taken7">Others</label></div>
			<span class="err_msg approval_action_taken_msg"></span>
				
			<textarea class="form-control mrig10" id="approval_action_taken_specify" name="approval_action_taken_specify" placeholder="Please specify" rows="3"></textarea>
			<span class="err_msg approval_action_taken_specify_msg"></span>
			</div>

			<div class="clerfix"></div>

			<div class="clerfix"></div>

			<div class="onlock-1"><p class="colost1"></p></div>

			<div class="onlock-cov2">
				<div class="btspa">
					<div class="form-group mb-0 text-center log-btn">
						<input type="submit" id="approval_action_a_taken" name="approval_action_a_taken" class="btn btn-primary2"/>
					</div>
				</div>
			</div>

			<div class="clerfix"></div>
		</div>

		</form>
	</div>
	
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
<div class="onlock" <?php 
	 if($complaint_reg->cna_cfo != "Yes"){echo "style='display:none'";}
	 else if(empty($complaint_reg->cna_md_status)){echo "style='display:none'";}
	// else if($complaint_reg->cna_md_status == "No" && $complaint_reg->cna_md != "Yes"){echo "style='display:none'";}
	 else if($complaint_reg->cna_md_status == "Yes" && $complaint_reg->cna_md != "Yes"){echo "style='display:none'";}
?>>
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
	<!------------------------------ Data Form Below ---------------------------->
	<div id="settlement_1" <?php if(!empty($complaint_reg->settlement)){echo "style='display:none'";}?>>
	<form action="<?php echo "raised-complaint-db.php?id=".$_GET['id']; ?>" method="post" enctype="multipart/form-data">	
	
	<div class="onlock" style="border:none">
		<div class="onlock-1"><p class="colost1">Settlement</p></div>
		<div class="onlock-2">
			<div class="settlement">
				<input type="button" class="btn btn-primary settlement_rej" value="Rejection" />   
				<input type="button" class="btn btn-light settlement_com" value="Commercial" />
				<input type="hidden" class="settlement_val" name="settlement" value="Rejection" />
				<span class="err_msg settlement_msg"></span>
			</div>
			<div class="clerfix"></div>
		</div>

		<div class="clerfix"></div>
		<div class="mrig20"></div>

		<div class="onlock-1 mrig8 settlement_rej_box"><p class="colost1 ">Rejection Invoice No.</p></div>
		<div class="onlock-cov2 mrig8 settlement_rej_box">
			<div class="onlock-3">
				<input class="form-control fodhf" id="reject_invoice_no" type="text" name="reject_invoice_no">
				<span class="err_msg reject_invoice_no_msg"></span>
			</div>
			<div class="clerfix"></div>
		</div>

		<div class="onlock-1 mrig8 settlement_rej_box"><p class="colost1 ">Final Quantity</p></div>
		<div class="onlock-cov2 mrig8 settlement_rej_box">
			<div class="onlock-3">
				<div class="row">	
					<div class="col col-sm-3">
						<select id="reject_qty_type" name="reject_qty_type" class="form-control">
							<option>MT</option>
							<option>KG</option>
							<option>Each</option>
						</select>
					</div>
					<div class="col col-sm-9">
						<input class="form-control fodhf" placeholder="" type="text" id="reject_final_qty" name="reject_final_qty"> 
					</div>
					&nbsp; &nbsp; &nbsp; <span class="err_msg reject_final_qty_msg"></span>
				</div>
			</div>
			<div class="clerfix"></div>
		</div>	

		<div class="onlock-1 mrig8 settlement_com_box"><p class="colost1 ">Commercial Amount</p></div>
		<div class="onlock-cov2 mrig8 settlement_com_box">
			<div class="onlock-3">
				<input class="form-control fodhf" id="comm_amount" type="text" name="comm_amount">
				<span class="err_msg comm_amount_msg"></span>
			</div>
			<div class="clerfix"></div>
		</div>	

		<div class="onlock-1 mrig8"><p class="colost1 ">Date</p></div>
		<div class="onlock-cov2 mrig8">
			<div class="onlock-3">
				<input readonly class="form-control fodhf date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="true" id="settlement_date" type="text" name="settlement_date"></p>
				<span class="err_msg settlement_date_msg"></span>
			</div>
			<div class="clerfix"></div>
		</div>

		<div class="onlock-1 mrig8"><p class="colost1 ">Credit Note No.</p></div>
		<div class="onlock-cov2 mrig8">
			<div class="onlock-3">
				<input class="form-control fodhf" id="settlement_credit_note_no" type="text" name="settlement_credit_note_no">
				<span class="err_msg settlement_credit_note_no_msg"></span>
			</div>
			<div class="clerfix"></div>
		</div>

		<div class="onlock-1"><p class="colost1"></p></div>

		<div class="onlock-cov2">
			<div class="btspa">
				<div class="form-group mb-0 text-center log-btn">
					<input type="submit" id="settlement_done" name="settlement_done" class="btn btn-primary2"/>
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
		<div class="onlock-3"><p class="colost2"><?php echo $complaint_reg->settlement_date; ?></p></div>
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

<div class="onlock" id="create_capa" <?php if(empty($complaint_reg->capa) && empty($complaint_reg->capa_document)){echo "style='display:none;'";}?>>
<div class="bg-rig"><a href="#" class="editme" title="edit"><i class="mdi mdi-border-color"></i></a></div>
	<!------------------------------ Data Form Below ---------------------------->	
	<div id="capa_1" <?php if(!empty($complaint_reg->capa) || !empty($complaint_reg->capa_document)){echo "style='display:none;'";}?>>
		
		<div class="onlock-1"><p class="colost1">CAPA</p></div>
		<div class="onlock-2">
			<a class="onlock-link " href="#" data-toggle="modal" data-target="#create-capa">Create Document</a><div class="clerfix"></div>
		</div>
		<div class="clerfix"></div>
		
		<div class="onlock-1"><p class="colost1">&nbsp;</p></div>
		<div class="onlock-2"><br />OR</div>
		<div class="clerfix">&nbsp;</div>
		
		<div class="onlock-1"><p class="colost1"></p></div>
		<div class="onlock-2">
		<form action="<?php echo "raised-complaint-db.php?id=".$_GET['id']; ?>" method="post" enctype="multipart/form-data">
			
			<div class="input-group capa-document-row">
				<div class="input-group-prepend">
					<span class="input-group-text clear_img capa_document" title="Clear Image">X</span>
				</div>
				<div class="custom-file">
					<input type="file" name="capa_document" class="custom-file-input" id="capa_document">
					<label class="custom-file-label" for="product_img_1">Upload CAPA Document</label>
				</div>
			</div>
			
			<div class="clerfix"></div>
			<div class="btspa">
				<div class="form-group mb-0 text-center log-btn">
					<input type="submit" id="upload_capa_document" name="upload_capa_document" class="btn btn-primary2"/>
				</div>
			<div class="clerfix"></div>
			</div>
			
			<div class="onlock-1"><p class="colost1"></p></div>
			
		</form>
		</div>
		
		<div class="clerfix"></div>
	</div>
	<!------------------------------ Data Below ---------------------------->
	<div id="capa_2" <?php if(empty($complaint_reg->capa) && empty($complaint_reg->capa_document)){echo "style='display:none;'";}?>>
		<div class="onlock-1"><p class="colost1">CAPA</p></div>
		<div class="onlock-2">
		<div class="lrbox001">
		<div class="lrbox1"><p class="colost2">Document</p></div>
		<div class="lrbox2">
			<a <?php if(empty($complaint_reg->capa)){echo "style='display:none;'";} ?> data-toggle="modal" class="view_capa" data-id="<?php echo $complaint_reg->capa; ?>" data-target="#view-capa" href="#">Open Document</a>
			<a <?php if(empty($complaint_reg->capa_document)){echo "style='display:none;'";} ?> class="fancybox open_capa_doc" data-fancybox-group="thumb" href="<?php echo "../document/{$complaint_reg->ticket_no}/capa/{$complaint_reg->capa_document}";?>">Open link</a>
		</div>
		<div class="clerfix"></div>
		</div><div class="clerfix"></div>

		</div>
		<div class="clerfix"></div>
		<div class="onlock-1 mrig8"><p class="colost1 ">Credit note Approval</p></div>
		<div class="onlock-2">
			<div class="custom-control custom-checkbox arsalin">
			<input disabled <?php if($complaint_reg->capa_qa == "Yes"){echo "checked";} ?> type="checkbox" class="custom-control-input" id="capa_qa">
			<label class="custom-control-label" for="capa_qa">Qualilty Assistance</label>
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
	
	
	
	
	
	
	
	
	
	
	
	
	
<!------------------------------------------------ MODAL CONTENT START ------------------------------------------------->	
<!------------------------------------------------ MODAL CONTENT START ------------------------------------------------->	
	
<!-- Add New Event MODAL -->
<div class="modal fade" id="complaint_meeting" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="raised-complaint-db.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
			<div class="modal-header pr-4 pl-4 border-bottom-0 d-block">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
				<h4 class="modal-title">Add New Visit Request</h4>
			</div>
			<div class="modal-body pt-3 pr-4 pl-4">
        		<div class='row'>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label class='control-label'>Meeting Date</label>
							<input type='text' readonly id="meeting_date" name='meeting_date' class="form-control"/>
							<span class="err_msg meeting_date_msg"></span>
						</div>
					</div>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label class='control-label'>Place</label>
							<input class='form-control' placeholder='Place' type='text' name='place'/>
						</div>
					</div>
					<div class='col-12 cldt-box'>
						<div class='form-group'>
							<select id="meeting_name" name="customer_coordinator" class="form-control">
								<option value="">- Customer Coordinator (whom to meet) -</option>
							</select>
							<span class="err_msg meeting_name_msg"></span>
						</div>
					</div>
					<div class='col-12 cldt-box meeting_name_2' style="display: none;">
						<div class='form-group'><label class='control-label'>Customer Coordinator (whom to meet)</label>
							<input type="text" id="meeting_name_2" name="customer_coordinator_2" class="form-control">
							<span class="err_msg meeting_name_2_msg"></span>
						</div>
					</div>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label class='control-label'>Mobile Number</label>
							<input class='form-control' id="meeting_mobile" type='text' name='mobile'/>
							<span class="err_msg meeting_mobile_msg"></span>
						</div>
					</div>
					<div class='col-12 cldt-box'>
						<div class='form-group'><label id="meeting_date" class='control-label'>Email ID</label>
							<input class='form-control' id="meeting_email" type='text' name='email'/>
							<span class="err_msg meeting_email_msg"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="text-right pb-4 pr-4 evet-btn-min">
				<button type="button" class="btn evet-btn evet-btn-col1" data-dismiss="modal">Close</button>
				<input type="submit" id="create_meeting" name="complaint_meeting" class="btn save-event  evet-btn evet-btn-col2" value="Submit" />
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


<div class="form-p-block" id="approval_note_div">
<form action="<?php echo "raised-complaint-db.php?id=".$_GET['id']; ?>" method="post" enctype="multipart/form-data">
<!-- box 1 -->
<div class="form-p-box form-p-box-bg2">

<div class="rst-left">
	<ul class="fpall">
		<li class="fp-con1"><p>Name of the customer</p></li>             
		<li class="fp-con2"><input readonly type="text" id="customer_name" value="<?php echo $complaint_reg->company_name; ?>" name="customer_name" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Complaint reference no</p></li>             
		<li class="fp-con2"><input readonly type="text" id="complait_reference" value="<?php echo $complaint_reg->ticket_no; ?>" name="complait_reference" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Complant Registration date</p></li>             
		<li class="fp-con2"> <?php $complait_reg_date = $complaint_reg->invoice_date; $complait_reg_date = strtotime($complait_reg_date); $complait_reg_date = date("m/d/Y", $complait_reg_date); ?>
			<input readonly class="form-control" value="<?php echo $complait_reg_date; ?>" id="complait_reg_date" name="complait_reg_date" type="text">
		</li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Material Details  (grade, size etc)</p></li>             
		<li class="fp-con2"><input type="text" id="material_details" name="material_details" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>
</div>

<div class="rst-right">
	<ul class="fpall">
		<li class="fp-con1"><p>Nature of the complaint</p></li>             
		<li class="fp-con2"><textarea id="nature_of_complaint" name="nature_of_complaint" readonly class="form-control mrig10 form-p-box-bg1"><?php echo $complaint_reg->complaint_type.", ".$complaint_reg->sub_complaint_type ?></textarea></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Name of the Steel Mill / Service centre/ Transporter</p></li>             
		<li class="fp-con2"><input readonly type="text" id="name_of_sm_sc_t" name="name_of_sm_sc_t" value="<?php if(empty($complaint_reg->mill)){echo $complaint_reg->plant_location;}else { echo $complaint_reg->mill;} ?>" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Responsibility</p></li>             
		<li class="fp-con2"><input readonly type="text" id="identify_source" name="responsibility" value="<?php echo $complaint_reg->identify_source; ?>" class="form-control form-p-box-bg1"></li>
		<div class="clerfix"></div>
	</ul>
</div>

<div class="clerfix"></div>
</div>
<!-- box 1 -->

<!-- box 2 -->
<div class="form-p-box form-p-box-bg1 border-bottom-st">
	<h2 class="sectphd">Credit Note to be Issued to Customer</h2>
	<div class="rst-left">
	<ul class="fpall">
		<li class="fp-con1"><p>Billing Document No.</p></li>   
		<li class="fp-con2"><input type="text" id="billing_doc_no" name="billing_doc_no" class="form-control form-p-box-bg2"></li>
		<div class="clerfix"></div>
	</ul>

	<ul class="fpall">
		<li class="fp-con1"><p>Billing Document Date</p></li>             
		<li class="fp-con2">
			<input id="billing_doc_date" type="text" name="billing_doc_date" readonly class="form-control date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="true">
		</li>
		<div class="clerfix"></div>
	</ul>
</div>

<div class="rst-right">
	<ul class="fpall">
		<li class="fp-con1"><p>Total Qty Rejected by the Customer</p></li>             
		<li class="fp-con2">
			<div class="row">	
				<div class="col col-sm-4">
					<select id="total_qty_rejc_type" name="total_qty_rejc_type" class="form-control">
						<option>MT</option>
						<option>KG</option>
						<option>Each</option>
					</select>
				</div>
				<div class="col col-sm-8">
					<input type="text" id="total_qty_rejc" name="total_qty_rejc" value="0" class="form-control form-p-box-bg2">
				</div>
			</div>
			
		</li>
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
		<input type="text" id="basic_sale_price" name="basic_sale_price" value="0" class="form-control form-p-box-bg2 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Sales Value (Basic sale price/t X Qty)</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input readonly type="text" id="sales_value" name="sales_value" value="0" class="form-control form-p-box-bg2 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01">
			<div class="input-group" style="width: 200px">
				<div class="input-group-append">
					<span class="input-group-text">CGST @</span>
				</div>
				<input type="text" class="form-control cgst" value="9">
				<div class="input-group-append">
					<span class="input-group-text">%</span>
				</div>
			</div>
		</li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" readonly id="cgst" name="cgst" value="0" class="form-control form-p-box-bg2 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01">
			<div class="input-group" style="width: 200px">
				<div class="input-group-append">
					<span class="input-group-text">SGST @</span>
				</div>
				<input type="text" class="form-control sgst app_note_number" value="9">
				<div class="input-group-append">
					<span class="input-group-text">%</span>
				</div>
			</div>
		</li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>
		<input type="text" readonly id="sgst" name="sgst" value="0" class="form-control form-p-box-bg2 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Cost incurred by the customer, (customer has debited us for poor packaging of the material)</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id="cost_inc_customer" name="cost_inc_customer" value="0" class="form-control form-p-box-bg2 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Salvage value (in case matl scrapped by the customer)</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id="salvage_value" name="salvage_value" value="0" class="form-control form-p-box-bg2 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p class="colrred_black">Credit note to be issued to the customer (total of abv net of scrap value)</p></li> 
		<li class="fp-con02"><span class="padd10 colrred_black">Rs.</span>  
		<input type="text" readonly id="credit_note_iss_cust" name="credit_note_iss_cust" value="0" class="form-control form-p-box-bg3 sphf"></li>
		<div class="clerfix"></div>
	</ul>
</div>

<div class="clerfix"></div>
</div>
<!-- box 3 -->

<!-- box 4 -->
<div class="form-p-box form-p-box-bg2">

<div class="rst-full">
	<h2 class="sectphd">Debit Note Issued to Supplier / Realisation from Scrap / To be Recovered from Insurance Co.</h2>
	<ul class="fpall">
		<li class="fp-con01"><p>Quantity (t) as accepted by steel mill    </p></li> 
		<li class="fp-con02">
			<input style="width: 50%; margin: 0 3% 0 0; float: right;" type="text" id="qty_acpt_steel_mill" name="qty_acpt_steel_mill" value="0" class="form-control form-p-box-bg1 sphf app_note_number">
			<select style="width: 30%; margin: 0 3% 0 0; float: right;" name="qty_acpt_steel_mill_type" class="form-control">
				<option>MT</option>
				<option>KG</option>
				<option>Each</option>
			</select>
		</li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Quantity (t) to be scrapped / auction at service centres </p></li> 
		<li class="fp-con02">
			<input style="width: 50%; margin: 0 3% 0 0; float: right;" type="text" id="qty_scrp_auc_serv_cent" name="qty_scrp_auc_serv_cent" value="0" class="form-control form-p-box-bg1 sphf app_note_number">
			<select style="width: 30%; margin: 0 3% 0 0; float: right;" name="qty_scrp_auc_serv_cent_type" class="form-control">
				<option>MT</option>
				<option>KG</option>
				<option>Each</option>
			</select>
		</li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Quantity (t) to be diverted to any other customer</p></li> 
		<li class="fp-con02">
			<input style="width: 50%;  margin: 0 3% 0 0;float: right;" type="text" id="qty_dlv_customer" name="qty_dlv_customer" value="0" class="form-control form-p-box-bg1 sphf app_note_number">
			<select style="width: 30%; margin: 0 3% 0 0; float: right;" name="qty_dlv_customer_type" class="form-control">
				<option>MT</option>
				<option>KG</option>
				<option>Each</option>
			</select>
		</li>			
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Debit note (purchase price/t) / Salvage rate / Sale value</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id="debit_note_sal_rate_sale_value" name="debit_note_sal_rate_sale_value" value="0" class="form-control form-p-box-bg2 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Value (purchase price/t  X qty)</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" readonly id="value" name="value" value="0" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01">
			<div class="input-group" style="width: 200px">
				<div class="input-group-append">
					<span class="input-group-text">CGST @</span>
				</div>
				<input type="text" class="form-control loss_cgst" value="9">
				<div class="input-group-append">
					<span class="input-group-text">%</span>
				</div>
			</div>
		</li>
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" readonly id="loss_cgst" name="loss_cgst" value="0" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01">
			<div class="input-group" style="width: 200px">
				<div class="input-group-append">
					<span class="input-group-text">SGST @</span>
				</div>
				<input type="text" class="form-control loss_sgst" value="9">
				<div class="input-group-append">
					<span class="input-group-text">%</span>
				</div>
			</div>
		</li>
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" readonly id="loss_sgst" name="loss_sgst" value="0" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Other expenses incurred by MIL (processing cost, freight, octroi et al) *</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id="oth_exp_inc_mill" name="oth_exp_inc_mill" value="0" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Other expenses to be debited (eg freight) / credited (eg scrap @ 20000 recovery) to steel mill</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id="oth_exp_debited" name="oth_exp_debited" value="0" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Compensation expected from Insurance Co.</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id="compensation_exp" name="compensation_exp" value="0" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p class="colrred_black">Debit note issued to supplier / Billing back to customer / Realisation from scrap</p></li> 
		<li class="fp-con02"><span class="padd10 colrred_black">Rs.</span>  
		<input type="text" readonly id="debit_note_iss_supplier" name="debit_note_iss_supplier" value="0" class="form-control form-p-box-bg3 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p class="colrred_black">Loss from the Rejection </p></li> 
		<li class="fp-con02"><span class="padd10 colrred_black">Rs.</span>  
		<input type="text" readonly id="loss_from_rejection" name="loss_from_rejection" value="0" class="form-control form-p-box-bg3 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p>Recoverable from Transporter (if applicable)</p></li> 
		<li class="fp-con02"><span class="padd10">Rs.</span>  
		<input type="text" id="recoverable_transporter" name="recoverable_transporter" value="0" class="form-control form-p-box-bg1 sphf app_note_number"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<li class="fp-con01"><p class="colrred_black">Net Loss / (-) Net Profit </p></li> 
		<li class="fp-con02"><span class="padd10 colrred_black">Rs.</span>  
		<input type="text" readonly id="net_loss" name="net_loss" value="0" class="form-control form-p-box-bg3 sphf"></li>
		<div class="clerfix"></div>
	</ul>
	<ul class="fpall">
		<textarea class="form-control mrig10 form-p-box-bg1" id="verify_remark" name="verify_remark" placeholder="Remarks" rows="3"></textarea>
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
<div align="center"><span class="err_msg approval_note_msg"></span></div>
<div class="form-p-box form-p-boxbtn">
	<input type="submit" id="create_a_note" name="create_a_note" class="fpdone" value="Submit" />
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
	<li class="fp-con2"><input type="text" readonly id="customer_name" name="customer_name" value="<?php echo $complaint_reg->company_name; ?>" class="form-control form-p-box-bg2"></li>
	<div class="clerfix"></div>
</ul>

<ul class="fpall">
	<li class="fp-con1"><p>Model</p></li>             
	<li class="fp-con2"><input type="text" id="model" name="model" class="form-control form-p-box-bg2"></li>
<div class="clerfix"></div></ul>

<ul class="fpall">
	<li class="fp-con1"><p>Date of issue</p></li>             
	<li class="fp-con2">
		<input id="date_issue" type="text" name="date_issue" value="<?php echo $complaint_reg->invoice_date; ?>" readonly class="form-control">
	</li>
<div class="clerfix"></div></ul>

<ul class="fpall">
	<li class="fp-con1"><p>Team Members</p></li>             
	<li class="fp-con2 team_member">
		<select id="team_member" name="team_member[]" class="form-control select2 select2-multiple" data-toggle="select2" multiple="multiple">
			<?php
				$employee_reg = EmployeeReg::find_all();
				foreach($employee_reg as $employee_reg){
					echo "<option value='{$employee_reg->emp_name}'>{$employee_reg->emp_name}</option>";
				}
			?>
		</select>
	</li>
<div class="clerfix"></div></ul>

<ul class="fpall">
	<li class="fp-con1"><p>Reviewed By</p></li>             
	<li class="fp-con2">
		<select id="reviewed_by" name="reviewed_by" class="form-control">
			<?php
				$employee_reg = EmployeeReg::find_all();
				foreach($employee_reg as $employee_reg){
					echo "<option value='{$employee_reg->emp_name}'>{$employee_reg->emp_name}</option>";
				}
			?>
		</select>
	</li>
	<div class="clerfix"></div>
</ul>

<ul class="fpall">
	<li class="fp-con1"><p>Contact Person Name</p></li>             
	<li class="fp-con2"><input type="text" readonly id="contact_person_name" name="contact_person_name" value="<?php echo $complaint_reg->pl_name; ?>" class="form-control form-p-box-bg2"></li>
	<div class="clerfix"></div>
</ul>

</div>

<div class="rst-right">
	
	<?php
		$last_capa = Capa::find_by_last_id();
		if($last_capa){
			$new_capa = $last_capa->capa_no+1;
			$capa_no = sprintf( '%06d', $new_capa );
		} else { $capa_no = "0000001"; }
	?>
<ul class="fpall">
	<li class="fp-con1"><p>CAPA No.</p></li>             
	<li class="fp-con2"><input type="text" readonly id="capa_no" name="capa_no" value="<?php echo $capa_no ?>" class="form-control form-p-box-bg2"></li>
	<div class="clerfix"></div>
</ul>

<ul class="fpall">
	<li class="fp-con1"><p>Reported By</p></li>             
	<li class="fp-con2"><input type="text" required id="reported_by" name="reported_by" value="<?php echo $complaint_reg->pl_name; ?>" class="form-control form-p-box-bg2"></li>
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
	<li class="ulsp1-r"><input type="text" id="problem_when" name="problem_when" readonly class="form-control date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="true"></li>
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
		<div class="row">
			<div class="col col-sm-6 correction_who">
				<select id="correction_who" name="correction_who[]" class="form-control select2 select2-multiple form-p-box-bg1 mrig10" data-toggle="select2" multiple="multiple">
					<?php
						$employee_reg = EmployeeReg::find_all();
						foreach($employee_reg as $employee_reg){
							echo "<option value='{$employee_reg->emp_name}'>{$employee_reg->emp_name}</option>";
						}
					?>
				</select>
			</div>
			<div class="col col-sm-6"><input type="text" id="correction_when" name="correction_when" placeholder="When" readonly class="form-control form-p-box-bg1 mrig10 date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="true"></div>
		</div>
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
		<div class="row">
			<div class="col col-sm-6"><input type="text" id="verify_who" name="verify_who" placeholder="Who" class="form-control form-p-box-bg1 mrig10"></div>
			<div class="col col-sm-6"><input type="text" id="verify_when" name="verify_when" placeholder="When" readonly class="form-control form-p-box-bg1 mrig10 date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="true"></div>
		</div>
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
		<div class="row">
			<div class="col col-sm-6"><input type="text" id="prevent_who" name="prevent_who" placeholder="Who" class="form-control form-p-box-bg1 mrig10"></div>
			<div class="col col-sm-6"><input type="text" id="prevent_when" name="prevent_when" placeholder="When" class="form-control form-p-box-bg1 mrig10"></div>
		</div>
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
		<div class="row">
			<div class="col col-sm-6"><input type="text" id=" " placeholder="Who" class="form-control form-p-box-bg1 mrig10"></div>
			<div class="col col-sm-6"><input type="text" id=" " placeholder="When" readonly class="form-control form-p-box-bg1 mrig10 date" data-provide="datepicker" data-toggle="date-picker" data-single-date-picker="true"></div>
		</div>
		<div class="clerfix"></div>
	</div>
	<div class="clerfix"></div>
</div>
<!-- box 9 -->
<div align="center"><span class="err_msg capa_msg"></span></div>
 <div class="form-p-box form-p-boxbtn">
	<input type="submit" id="save_capa" name="save_capa" value="Submit" class="fpdone" />
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

	<!-- demo app 
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
		var data_id = $(this).attr('data-id');
		$("#view-capa .modal-content").load("view-capa.php?id="+data_id);
	});
	
	
	$(document).ready(function() {
		
		$(".open_capa_doc").fancybox({
			width  : 600,
			height : 300,
			type   :'iframe'
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
			
			credit_note_iss_cust = parseFloat(sales_value) + parseFloat(cgst) + parseFloat(sgst) + parseFloat(cost_inc_customer) + parseFloat(salvage_value);
			$("#credit_note_iss_cust").val(credit_note_iss_cust.toFixed(2));
			
			console.log(parseFloat(cgst));
			 
			
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
			
			
			oth_exp_inc_mill 			= $("#oth_exp_inc_mill").val();
			oth_exp_debited 			= $("#oth_exp_debited").val();
			compensation_exp 			= $("#compensation_exp").val();
			
			
			debit_note_iss_supplier 	= parseFloat(value) + parseFloat(loss_cgst) + parseFloat(loss_sgst) + parseFloat(oth_exp_debited) + parseFloat(compensation_exp) - parseFloat(oth_exp_inc_mill);
			debit_note_iss_supplier 	= debit_note_iss_supplier.toFixed(2);
			$("#debit_note_iss_supplier").val(debit_note_iss_supplier);
			
			
			//loss_from_rejection 		= (parseFloat(credit_note_iss_cust) + parseFloat(value) + parseFloat(oth_exp_inc_mill)) - (parseFloat(compensation_exp) + parseFloat(debit_note_iss_supplier));
			loss_from_rejection 		= parseFloat(credit_note_iss_cust) - parseFloat(debit_note_iss_supplier);
			loss_from_rejection 		= loss_from_rejection.toFixed(2);
			$("#loss_from_rejection").val(loss_from_rejection);
			
			
			recoverable_transporter 	= $("#recoverable_transporter").val();
			net_loss					= parseFloat(loss_from_rejection) - parseFloat(recoverable_transporter);
			net_loss					= net_loss.toFixed(2);
			$("#net_loss").val(net_loss)
		});	

		
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


