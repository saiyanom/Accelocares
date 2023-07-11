<?php ob_start();
  require_once("../includes/initialize.php"); 
  if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

  if(isset($_GET['id']) && !empty($_GET['id'])){
    $capa 		= Capa::find_by_id($_GET['id']);
    $complaint 	= Complaint::find_by_id($capa->complaint_id);
  } else {
    $session->message("Complaint Not Found");
    redirect_to("my-complaints.php");
  }
?>
<style>
.bor-bottom{border-bottom:none}
.bor-top{border-top:none}
.bor-tb{border-bottom:none;border-top:none}

.bor-left{border-left:none}
.bor-right{border-right:none}
.bor-lf{border-left:none;border-right:none}


</style>

<table border="1" cellpadding="5" align="center" cellspacing="0" width="96%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000; margin: 2%; box-sizing: border-box;">
<tbody>
<tr>
<td colspan="2" rowspan="4">
<div style="position: relative;"><img style="" src="<?php echo BASE_URL; ?>administrator/images/accelo.png" border="0"></div></td>
<td colspan="10" rowspan="3" align="center" style=" font-size:20px"><strong>MAHINDRA ACCELO PVT. LTD.<br>
Corrective And Preventive Action Report</strong> </td>
<td colspan="3" align="center"><strong>System Coordinator</strong></td>
</tr>
<tr>
<td width="92"><strong>Document No.</strong></td>
<td colspan="2"><?php echo $capa->document_no; ?></td>
</tr>
<tr>
<td><strong>Rev. No.</strong></td>
<td colspan="2"><?php echo $capa->rev_no; ?></td>
</tr>
<tr>
<td colspan="10" align="center"><strong>Corrective And Preventive Action Report</strong></td>
<td><strong>Page No.</strong></td>
<td colspan="2"><?php echo $capa->page_no; ?></td>
</tr>
<tr>
<td width="145" class="bor-right bor-bottom"><strong>Customer Name:</strong></td>
<td colspan="6" class="bor-left bor-bottom"><?php echo $capa->customer_name; ?></td>
<td width="76" class="bor-right bor-bottom"><strong>CAPA No:</strong></td>
<td colspan="4" class="bor-left bor-bottom"><?php echo $capa->capa_no; ?></td>
<td colspan="3" class="bor-bottom"></td>
</tr>
<tr>
<td class="bor-right bor-bottom"><strong>Model:</strong> </td>
<td class="bor-left bor-bottom" colspan="6"><?php echo $capa->model; ?></td>
<td class="bor-right bor-tb"><strong>Reported by : </strong></td>
<td class="bor-left bor-tb" colspan="4"><?php echo $capa->reported_by; ?></td>
<td class="bor-right bor-tb"><strong>Date of issue:</strong>   </td>
<td class="bor-left bor-tb" colspan="2"><?php echo date( 'd-m-Y', strtotime($capa->date_issue)); ?></td>
</tr>
<tr>
<td class="bor-right bor-tb"><strong>Problem Description:  </strong></td>
<td class="bor-left bor-tb" colspan="6"><?php echo $capa->problem_desc; ?></td>
<td class="bor-right bor-tb"><strong>Team Members:</strong></td>
<td class="bor-left bor-tb" colspan="4" ><?php echo $capa->team_member; ?></td>
<td colspan="3" class="bor-tb"></td>
</tr>
<tr>
<td class="bor-right bor-tb"><strong>Feedback Date:</strong></td>
<td class="bor-left bor-tb" colspan="6"><?php echo date( 'd-m-Y', strtotime($capa->feedback_date)); ?></td>
<td class="bor-right bor-top"><strong>Reviewed by:</strong> </td>
<td class="bor-left bor-top" colspan="4"><?php echo $capa->reviewed_by; ?></td>
<td class="bor-right bor-top"><strong>Reviewed date :</strong> </td>
<td class="bor-left bor-top" colspan="2"><?php echo date( 'd-m-Y', strtotime($capa->reviewed_date)); ?></td>
</tr>
<tr>
<td class="bor-right bor-top"><strong>contact person Name:</strong></td>
<td class="bor-left bor-top"  colspan="6"><?php echo $capa->contact_person_name; ?></td>
<td class=" bor-top"  colspan="8"></td>
</tr>
<tr>
<td colspan="7" bgcolor="#66FF99"><strong>1) Problem Description:</strong> </td>
<td colspan="6" bgcolor="#66FF99">5) Correction:</td>
<td width="107" bgcolor="#66FF99"><strong>Who</strong> </td>
<td width="65" bgcolor="#66FF99"><strong>When</strong></td>
</tr>
<tr>
  <td colspan="7" class="bor-bottom"><strong>Where : <?php echo $capa->problem_where; ?></strong></td>
  <td colspan="6" rowspan="6" align="center" valign="middle"><?php echo $capa->correction_remark; ?></td>
  <td rowspan="6" align="center"><?php echo $capa->correction_who; ?></td>
  <td rowspan="6" align="center"><?php echo $capa->correction_when; ?></td>
</tr>
<tr>
  <td colspan="7"  class="bor-tb"><strong>When : <?php echo $capa->problem_when; ?></strong></td>
</tr>
<tr>
<td colspan="7"  class="bor-tb"><strong>What Qty : <?php echo $capa->problem_what_qty; ?></strong></td>
</tr>
<tr>
<td colspan="7" class="bor-tb"><strong>Which model: <?php echo $capa->problem_which_model; ?></strong></td>
</tr>
<tr>
<td colspan="7" class="bor-top"><strong>Who produced : <?php echo $capa->problem_who_produced; ?></strong></td>
</tr>
<tr>
<td colspan="7" rowspan="2" bgcolor="#66FF99"><strong>2) Findings / Investigation :</strong></td>
</tr>
<tr>
<td colspan="6" bgcolor="#66FF99"><strong>6) Corrective Action:</strong></td>
<td bgcolor="#66FF99"><strong>Who</strong></td>
<td bgcolor="#66FF99"><strong>When</strong></td>
</tr>
<tr>
  <td colspan="7" align="center"><?php echo $capa->finding_invest_remark; ?></td>
  <td colspan="6"><?php echo $capa->corrective_remark; ?>
  <td align="center"><?php echo $capa->corrective_who; ?></td>
  <td align="center"><?php echo $capa->corrective_when; ?></td>
</tr>
<tr>
  <td colspan="7" bgcolor="#66FF99"><strong>3 ) Structured &amp; systematic analysis of probable causes</strong></td>
  <td colspan="6" bgcolor="#66FF99"><strong>7) Verification of Effectiveness:</strong></td>
  <td bgcolor="#66FF99"><strong>Who</strong></td>
  <td bgcolor="#66FF99"><strong>When</strong></td>
</tr>
<tr>
<td colspan="7"><?php echo $capa->structured_remark; ?></td>
<td colspan="6"><?php echo $capa->verify_remark; ?></td>
<td align="center"><?php echo $capa->verify_who; ?></td>
<td align="center"><?php echo $capa->verify_when; ?></td>
</tr>
<tr>
  <td colspan="7" bgcolor="#66FF99"><strong>4) Root cause identified</strong></td>
  <td colspan="6" bgcolor="#66FF99"><strong>8) Preventive action (Horizontal deployment)if applicable</strong></td>
  <td bgcolor="#66FF99"><strong><strong>Who</strong></strong></td>
  <td bgcolor="#66FF99"><strong>When</strong></td>
</tr>
<tr>
<td colspan="7"><?php echo $capa->root_cause_remark; ?></td>
<td colspan="6"><?php echo $capa->prevent_remark; ?></td>
<td align="center"><?php echo $capa->prevent_who; ?></td>
<td align="center"><?php echo $capa->prevent_when; ?></td>
</tr>
<tr class="row37">
  	<td colspan="2"><strong><?php echo $complaint->emp_name; ?></strong></td>
	<td colspan="4"><strong><?php echo $complaint->capa_qa_name; ?></strong></td>
	<td width="123"><strong><?php echo $complaint->capa_ph_name; ?></strong></td>
	<td colspan="4"><strong><?php echo $complaint->capa_pc_name; ?></strong></td>
	<td colspan="4"><strong><?php echo $complaint->capa_mr_name; ?></strong></td>
</tr>
<tr>
<td colspan="2"><strong>Prepared  by    Checked by</strong></td>
<td colspan="4"><strong>Quality Assurance</strong></td>
<td width="123"><strong>Verified By</strong></td>
<td colspan="4"><strong>Plant chief (Approved by)</strong></td>
<td colspan="4"><strong>Management Representative</strong></td>
</tr>
<tr>
  <td colspan="15">&nbsp;</td>
</tr>
</tbody>
</table>