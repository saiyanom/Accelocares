<?php ob_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  require_once("../includes/initialize.php"); 
  if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

  if(isset($_GET['id']) && !empty($_GET['id'])){
    $approval_note  = ApprovalNote::find_by_id($_GET['id']);
    $complaint      = Complaint::find_by_id($approval_note->complaint_id);
  } else {
    $session->message("Complaint Not Found");
    redirect_to("my-complaints.php");
  }

  if($complaint->cna_md_status == 'No'){
      $cna_md_name = 'N/A';
  } else {
      $cna_md_name = $complaint->cna_md_name; 
  }

  require_once '../pdfcreator/vendor/dompdf/dompdf/lib/html5lib/Parser.php';
  require_once '../pdfcreator/vendor/phenx/php-font-lib/src/FontLib/Autoloader.php';
  require_once '../pdfcreator/vendor/phenx/php-svg-lib/src/autoload.php';
  require_once '../pdfcreator/vendor/dompdf/dompdf/src/Autoloader.php';
  Dompdf\Autoloader::register();

  // reference the Dompdf namespace
  use Dompdf\Dompdf;


  $dompdf = new Dompdf();
  
$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Approval Note</title>
<style>
@page{margin: 30px 10px 10px 10px;}
.bor-bottom{border-bottom:none}
.bor-top{border-top:none}
.bor-tb{border-bottom:none;border-top:none}

.bor-left{border-left:none}
.bor-right{border-right:none}
.bor-lf{border-left:none;border-right:none}
.signature {width="90%; margin : 10px 5% 0 5%; font-size: 12px;}

</style>

</head>

<body>

<table border="0" cellpadding="2" align="center"   cellspacing="0" width="90%" style="border:1px solid;font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#000">
  <tbody>
    <tr style="" class="row0">
      <td  style="text-align:center;border:1px solid; border-bottom:2px solid; font-size:12px"  class="column0 style2 s style4" colspan="4">
        <strong>Credit Note Approval MIL/MSSCL/MASL</strong>
      </td>
    </tr>
   
    <tr class="row2">
      <td width="35%" class="column0 style9 null" style="border-left:1px solid;"></td>
      <td width="36%"  class="column1 style10 null"></td>
      <td width="15%" class="column2 style11 s" align="right"></td>
      <td width="14%"  class="column3 style12 n" style="border-right:1px solid;"></td>
    </tr>
    <tr class="row3">
      <td style="border-left:1px solid;" class="column0 style13 s">Name of the Customer</td>
      <td class="column1 style14 s">'. $approval_note->customer_name.'</td>
      <td class="column2 style15 null" align="right"></td>
      <td style="border-right:1px solid;"  class="column3 style16 null" align="right"></td>
    </tr>
    <tr class="row4">
      <td style="border-left:1px solid;" class="column0 style13 s">Complaint Reference No.</td>
      <td class="column1 style15 s">'. $approval_note->complait_reference.'</td>
      <td class="column2 style15 null" align="right"></td>
      <td style="border-right:1px solid;" class="column3 style16 null" align="right"></td>
    </tr>
    <tr class="row5">
      <td style="border-left:1px solid;" class="column0 style13 s">Complant Registration Date</td>
      <td class="column1 style17 n">'. date( 'd/M/Y', strtotime($approval_note->complait_reg_date)).'</td>
      <td class="column2 style17 null" align="right"></td>
      <td style="border-right:1px solid;" class="column3 style16 null" align="right"></td>
     
    </tr>
    <tr class="row6">
      <td style="border-left:1px solid;" class="column0 style13 s">Material Details  (grade, size etc)</td>
      <td class="column1 style17 s">'. $approval_note->material_details.'</td>
      <td class="column2 style18 null" align="right"></td>
      <td style="border-right:1px solid;" class="column3 style19 null" align="right"></td>
     
    </tr>
    <tr class="row7">
      <td style="border-left:1px solid;" class="column0 style13 s">Nature of the Complaint</td>
      <td class="column1 style15 s">'. $approval_note->nature_of_complaint.'</td>
      <td class="column2 style15 null" align="right"></td>
      <td style="border-right:1px solid;" class="column3 style20 null" align="right"></td>
     
    </tr>
    <tr class="row8">
      <td style="border-left:1px solid;" class="column0 style13 s">Name of the Steel Mill / Service centre / Transporter</td>
      <td class="column1 style21 s">'. $approval_note->name_of_sm_sc_t.'</td>
      <td class="column2 style21 null" align="right"></td>
      <td style="border-right:1px solid;"  class="column3 style19 null" align="right"></td>
     
    </tr>
    <tr class="row9">
      <td style="border-left:1px solid;" class="column0 style13 s">Responsibility</td>
      <td class="column1 style21 s">'. $approval_note->responsibility.'</td>
      <td class="column2 style21 null" align="right"></td>
      <td style="border-right:1px solid;" class="column3 style19 null" align="right"></td>
     
    </tr>
   
   
   

    <tr class="row15">
      <td style="border-left:1px solid;border-top:2px solid" class="column0 style26 null">&nbsp;</td>
      <td style="border-top:2px solid" >&nbsp;</td>
      <td style="border-top:2px solid" align="right">&nbsp;</td>
      <td style="border-right:1px solid;border-top:2px solid" class="column3 style29 null" align="right">&nbsp;</td>
    </tr>

    <tr class="row12">
      <td style="border-left:1px solid;" class="column0 style24 s">Credit Note to be issued to Customer</td>
      <td></td>
      <td></td>
      <td style="border-right:1px solid" class="column3 style25 null"></td>
     
    </tr>
   
   
    <tr class="row13">
      <td style="border-left:1px solid;"   class="column0 style26 s">Billing Document No.</td>
      <td class="column1 style27 n">'. $approval_note->billing_doc_no.'</td>
      <td class="column2 style27 null">Total Qty Rejected by the Customer</td>
      <td style="border-right:1px solid;" class="column3 style19 null" align="right">'. $approval_note->total_qty_rejc.'</td>
   
    </tr>
    <tr class="row14">
      <td style="border-left:1px solid;"   class="column0 style26 s">Billing Document Date</td>
      <td class="column1 style21 null">'. date( 'd/M/Y', strtotime($approval_note->billing_doc_date)) .'</td>
      <td class="column2 style27 s" align="right"></td>
      <td style="border-right:1px solid;" class="column3 style28 n" align="right"></td>
     
    </tr>
    <tr class="row15">
      <td style="border-left:1px solid;" class="column0 style26 null">&nbsp;</td>
      <td class="column1 style21 null">&nbsp;</td>
      <td class="column2 style27 null" align="right">&nbsp;</td>
      <td style="border-right:1px solid;" class="column3 style29 null" align="right">&nbsp;</td>
    </tr>
             
    <tr class="row16">
      <td style="border:1px solid;border-top:2px solid" class="column0 style1 s" colspan="2">Basic Sale Price '. $approval_note->basic_sale_price_txt.'</td>
      <td style="border:1px solid;border-top:2px solid" class="column2 style31 s" align="right">Rs.</td>
      <td style="border:1px solid;border-top:2px solid" class="column3 style28 n" align="right">'. $approval_note->basic_sale_price.'</td>
    </tr>
    <tr class="row17">
      <td style="border:1px solid" colspan="2">&nbsp;</td>
      <td style="border:1px solid">&nbsp;</td>
      <td style="border:1px solid">&nbsp;</td>
    </tr>
    <tr class="row18">
      <td style="border:1px solid"  class="column0 style1 s" colspan="2">Sales Value (Basic Sale Price/t X Qty) </td>
      <td style="border:1px solid"  class="column2 style31 s" align="right"><strong style="float: left;">(a)</strong> Rs</td>
      <td style="border:1px solid"  class="column3 style28 f" align="right">'. $approval_note->sales_value.'</td>
   
    </tr>
    <tr class="row19">
      <td style="border:1px solid" class="column0 style1 s" colspan="2">CGST @ '. 100 / ($approval_note->sales_value/$approval_note->cgst).'%</td>
      <td style="border:1px solid" class="column2 style31 s" align="right">Rs</td>
      <td style="border:1px solid" class="column3 style28 f" align="right">'. $approval_note->cgst.'</td>
     
    </tr>
    <tr class="row20">
      <td style="border:1px solid" class="column0 style1 s" colspan="2">SGST @ '. 100 / ($approval_note->sales_value/$approval_note->sgst).'%</td>
      <td style="border:1px solid" class="column2 style31 s" align="right">Rs</td>
      <td style="border:1px solid" class="column3 style28 f" align="right">'. $approval_note->sgst.'</td>
   
    </tr>
    <tr class="row21">
      <td style="border:1px solid" colspan="2">&nbsp;</td>
      <td style="border:1px solid">&nbsp;</td>
      <td style="border:1px solid">&nbsp;</td>
    </tr>
    <tr class="row22">
      <td style="border:1px solid" class="column0 style35 s" colspan="2">Cost incurred by the Customer '. $approval_note->cost_inc_customer_txt.'</td>
      <td style="border:1px solid" class="column2 style31 s" align="right">Rs.</td>
      <td style="border:1px solid" class="column3 style32 null" align="right">'. $approval_note->cost_inc_customer.'</td>
     
    </tr>
    <tr class="row23">
      <td style="border:1px solid" colspan="2">&nbsp;</td>
      <td style="border:1px solid">&nbsp;</td>
      <td style="border:1px solid">&nbsp;</td>
    </tr>
    <tr class="row24">
      <td style="border:1px solid" class="column0 style1 s" colspan="2">Salvage Rate '. $approval_note->salvage_value_txt.'</td>
      <td style="border:1px solid" class="column2 style31 s" align="right">Rs.</td>
      <td style="border:1px solid" class="column3 style32 null" align="right">'. $approval_note->salvage_value.'</td>
   
    </tr>
    <tr class="row25">
      <td style="border:1px solid" colspan="2">&nbsp;</td>
      <td style="border:1px solid">&nbsp;</td>
      <td style="border:1px solid">&nbsp;</td>
    </tr>
    <tr class="row26">
      <td style="border:1px solid" class="column0 style40 null" colspan="2"><strong>Credit note to be issued to the Customer (total of abv net of scrap value)</strong></td>
      <td style="border:1px solid" class="column2 style42 s" align="right">Rs.</td>
      <td style="border:1px solid" class="column3 style43 f" align="right">'. $approval_note->credit_note_iss_cust.'</td>
    </tr>
    <tr class="row29">
      <td style="border-top:1px solid;border-bottom:1px solid;border-left:1px solid; font-weight:bold; font-size: 15px; color: #171717; padding: 3px 0;" colspan="4" align="center">
        Debit Note issued to Supplier / Realisation from Scrap / To be recovered from Insurance Co.
      </td>          
    </tr>
    <tr class="row32">
      <td style="border:1px solid" class="column0 style53 s" colspan="2">Quantity (t) as Accepted by Steel Mill</td>
      <td style="border:1px solid" class="column2 style31 s" align="right"></td>
      <td style="border:1px solid" class="column3 style28 n" align="right">'. $approval_note->qty_acpt_steel_mill.'</td>
   
    </tr>
    <tr class="row33">
      <td style="border:1px solid" class="column0 style1 s" colspan="2">Quantity (t) to be Scrapped / Auction at Service Centres</td>
      <td style="border:1px solid" class="column2 style31 s" align="right"></td>
      <td style="border:1px solid" class="column3 style28 null" align="right">'. $approval_note->qty_scrp_auc_serv_cent.'</td>
   
    </tr>
    <tr class="row34">
      <td style="border:1px solid" class="column0 style1 s" colspan="2">Quantity (t) to be Diverted to any Other Customer</td>
      <td style="border:1px solid" class="column2 style31 s" align="right"></td>
      <td style="border:1px solid" class="column3 style28 null" align="right">'. $approval_note->qty_dlv_customer.'</td>
   
    </tr>
    <tr class="row35">
      <td style="border:1px solid" colspan="2">&nbsp;</td>
      <td style="border:1px solid">&nbsp;</td>
      <td style="border:1px solid">&nbsp;</td>
    </tr>
    <tr class="row36">
      <td style="border:1px solid" class="column0 style1 s" colspan="2">Debit Note (purchase price/t) / Salvage rate / Sale Value '. $approval_note->debit_salvage_sale_txt.'</td>
      <td style="border:1px solid" class="column2 style56 s" align="right">Rs.</td>
      <td style="border:1px solid" class="column3 style28 n" align="right">'. $approval_note->debit_note_sal_rate_sale_value.'</td>
   
    </tr>
    <tr class="row38">
      <td style="border:1px solid" class="column0 style1 s" colspan="2">Value (Purchase Price/t  X Qty)</td>
      <td style="border:1px solid" class="column2 style56 s" align="right"><strong style="float: left;">(b)</strong> Rs.</td>
      <td style="border:1px solid" class="column3 style28 f" align="right">'. $approval_note->value.'</td>
   
    </tr>
    <tr class="row39">
      <td style="border:1px solid" class="column0 style1 s" colspan="2">CGST @ '. 100 / ($approval_note->value/$approval_note->loss_cgst).'%</td>
      <td style="border:1px solid" class="column2 style56 s" align="right">Rs.</td>
      <td style="border:1px solid" class="column3 style28 f" align="right">'. $approval_note->loss_cgst.'</td>
   
    </tr>
    <tr class="row40">
      <td style="border:1px solid" class="column0 style1 s" colspan="2">SGST @ '. 100 / ($approval_note->value/$approval_note->loss_sgst).'%</td>
      <td style="border:1px solid" class="column2 style56 s" align="right">Rs.</td>
      <td style="border:1px solid" class="column3 style28 f" align="right">'. $approval_note->loss_sgst.'</td>
     
    </tr>
    <tr class="row41">
      <td style="border:1px solid" class="column0 style1 null" colspan="2">Total Debit Value</td>
      <td style="border:1px solid" class="column2 style56 null" align="right"><strong style="float: left;">(x)</strong> Rs.</td>
      <td style="border:1px solid" class="column3 style58 null" align="right">'. $approval_note->total_debit_value.'</td>
     
    </tr>
    <tr class="row42">
      <td style="border:1px solid" colspan="2">&nbsp;</td>
      <td style="border:1px solid">&nbsp;</td>
      <td style="border:1px solid">&nbsp;</td>
    </tr>
    <tr class="row43">
      <td style="border:1px solid" class="column0 style1 s" colspan="2">Other Expenses Incurred by MILL '. $approval_note->other_exp_inc_mill_txt.'</td>
      <td style="border:1px solid" class="column2 style56 null" align="right"><strong style="float: left;">(c)</strong> Rs.</td>
      <td style="border:1px solid" class="column3 style32 null" align="right">'. $approval_note->oth_exp_inc_mill.'</td>
    </tr>
    <tr class="row44">
      <td style="border:1px solid" colspan="2">&nbsp;</td>
      <td style="border:1px solid">&nbsp;</td>
      <td style="border:1px solid">&nbsp;</td>
    </tr>
    <tr class="row45">
      <td style="border:1px solid" class="column0 style1 s" colspan="2">Other Expenses to be Debited (eg Freight) / Credited (eg scrap @ 20000 recovery) to Steel Mill</td>
      <td style="border:1px solid" class="column2 style56 null" align="right"><strong style="float: left;">(y)</strong> Rs.</td>
      <td style="border:1px solid" class="column3 style58 null" align="right">'. $approval_note->oth_exp_debited.'</td>
    </tr>
    <tr class="row48">
      <td style="border:1px solid" class="column0 style53 s" colspan="2">Compensation Expected from Insurance Co.</td>
      <td style="border:1px solid" class="column2 style56 s" align="right"><strong style="float: left;">(d)</strong> Rs.</td>
      <td style="border:1px solid" class="column3 style61 n" align="right">'. $approval_note->compensation_exp.'</td>
    </tr>
    <tr class="row51">
      <td style="border:1px solid" class="column0 style40 s" colspan="2"><strong>Debit Note Issued to Supplier / Billing back to Customer / Realisation from Scrap</strong></td>
      <td style="border:1px solid" class="column2 style68 s" align="right"><strong style="float: left;">(x+y)</strong> Rs.</td>
      <td style="border:1px solid" class="column3 style69 f" align="right">'. $approval_note->debit_note_iss_supplier.'</td>
    </tr>
    <tr class="row54">
      <td style="border:1px solid" class="column0 style72 s" colspan="2"><strong>Loss from the Rejection </strong></td>
      <td style="border:1px solid" class="column2 style46 s" align="right"><strong style="float: left;">(e) = (a-b+c-d-y)</strong> Rs.</td>
      <td style="border:1px solid" class="column3 style74 f" align="right">'. $approval_note->loss_from_rejection.'</td>
    </tr>
    <tr class="row57">
      <td style="border:1px solid" class="column0 style53 s" colspan="2">Recoverable from Transporter (if applicable)</td>
      <td style="border:1px solid" class="column2 style56 s" align="right"><strong style="float: left;">(f)</strong> Rs.</td>
      <td style="border:1px solid" class="column3 style77 n" align="right">'. $approval_note->recoverable_transporter.'</td>
    </tr>
    <tr class="row59">
      <td style="border:1px solid" class="column0 style70 s" colspan="2"><strong>Net Loss / (-) Net Profit</strong> </td>
      <td style="border:1px solid" class="column2 style65 s" align="right"><strong style="float: left;">(e-f)</strong> Rs.</td>
      <td style="border:1px solid" class="column3 style80 f" align="right">'. $approval_note->net_loss.'</td>
    </tr>        
 
    <tr class="row62">
      <td style="border-left:1px solid;border-right:1px solid" class="column0 style82 s style84" colspan="4">
        <p class="colrred_black"><strong>Remarks:</strong></p>
        '. $approval_note->remark.'<br />
        <hr />
        <p class="colrred_black"><strong>Approver Remark</strong></p>
        '. $approval_note->approver_remark.'<br />
        <hr />
        <p>
          <strong>Note</strong><br/>
          a) Credit Note will be issued by the respective plants in case of material return from the customer.<br/>
          b)  For processing related rejections, complaint will be closed after issue of CAPA / CN<br/>
        </p>
      </td>
    </tr>  
   
    <tr class="row73">
      <td style="padding: 0" colspan="4">
   
     
      <table width="100%" border="1" style="border: 1px solid #000;" cellspacing="0" cellpadding="5">
  <tr>
  <td width="15%"><strong>CRM Head</strong></td>
  <td width="15%"><strong>Commercial Head</strong></td>
  <td width="15%"><strong>Plant Chief</strong></td>
  <td width="15%"><strong>Sales Head</strong></td>
  <td width="15%"><strong>CFO</strong></td>
  <td width="15%"><strong>MD</strong></td>
  </tr>
  <tr>
  <td>'.$complaint->cna_crm_head_name.'</td>
  <td>'.$complaint->cna_commercial_head_name.'</td>
  <td>'.$complaint->cna_plant_chief_name.'</td>
  <td>'.$complaint->cna_sales_head_name.'</td>
  <td>'.$complaint->cna_cfo_name.'</td>
  <td>'.$cna_md_name.'</td>
  </tr>
</table>
      </td>
    </tr>
  </tbody>
</table> <i class="signature"> This is a computer-generated document. No signature is required. </i>

</body></html>
';


$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

$output = $dompdf->output();

$pdfname = "approval-note-".$approval_note->billing_doc_no.".pdf";

$file_location = "../document/pdf/".$pdfname;
file_put_contents($file_location, $output);

//$dompdf->stream();
//$url = "https://www.accelokonnect.com/crm/administrator/document/pdf/".$pdfname;

    if(file_exists($file_location)) {
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header("Content-Type: application/force-download");
      header('Content-Disposition: attachment; filename=' . urlencode(basename($file_location)));
      // header('Content-Transfer-Encoding: binary');
      header('Expires: 0');
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Pragma: public');
      header('Content-Length: ' . filesize($file_location));
      ob_clean();
      flush();
      readfile($file_location);
      
      unlink($file_location);
      exit;
    }
?>