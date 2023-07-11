<?php ob_start();

  require_once("../includes/initialize.php"); 

  if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }



  if(isset($_GET['id']) && !empty($_GET['id'])){



    if(isset($_GET['doc']) && $_GET['doc'] == "d"){

      $complaint_reg = Complaint::find_by_id($_GET['id']);



      $file_location = "../document/{$complaint_reg->ticket_no}/capa/{$complaint_reg->capa_document}";

      //$file_location = "../document/000003/capa/1564070344-capa-132423_(1).pdf";

      //file_put_contents($file_location, $output);



      //$dompdf->stream();


      //return false;

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

        exit;

      } 



      die();

    } else {

      $capa         = Capa::find_by_id($_GET['id']);

      $complaint    = Complaint::find_by_id($capa->complaint_id);

    }

  } else {

    $session->message("Complaint Not Found");

    redirect_to("my-complaints.php");

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

<title>CAPA</title>

<style>



.bor-bottom{border-bottom:none}

.bor-top{border-top:none}

.bor-tb{border-bottom:none;border-top:none}



.bor-left{border-left:none}

.bor-right{border-right:none}

.bor-lf{border-left:none;border-right:none}
.signature {width="100%; margin : 10px 0 0 0; font-size: 12px;}




</style>



<table border="1" cellpadding="5" align="center" cellspacing="0" width="96%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000; margin: 2%; box-sizing: border-box;">

<tbody>

<tr>

<td colspan="2" rowspan="4" style="margin:0;padding:0; background-image: url(../images/accelo.png); background-repeat: no-repeat; background-position: center; "></td>

<td colspan="10" rowspan="3" align="center" style=" font-size:20px"><strong>MAHINDRA STEEL SERVICE CENTRE LTD. (PLANT I)<br>

Corrective And Preventive Action Report</strong> </td>

<td colspan="3" align="center"><strong>System Coordinator</strong></td>

</tr>

<tr>

<td width="92"><strong>Document No.</strong></td>

<td colspan="2">'. $capa->document_no.'</td>

</tr>

<tr>

<td><strong>Rev. No.</strong></td>

<td colspan="2">'. $capa->rev_no.'</td>

</tr>

<tr>

<td colspan="10" align="center"><strong>Corrective And Preventive Action Report</strong></td>

<td><strong>Page No.</strong></td>

<td colspan="2">'. $capa->page_no.'</td>

</tr>

<tr>

<td width="145" class="bor-right bor-bottom"><strong>Customer Name:</strong></td>

<td colspan="6" class="bor-left bor-bottom">'. $capa->customer_name.'</td>

<td width="76" class="bor-right bor-bottom"><strong>CAPA No:</strong></td>

<td colspan="4" class="bor-left bor-bottom">'. $capa->capa_no.'</td>

<td colspan="3" class="bor-bottom"></td>

</tr>

<tr>

<td class="bor-right bor-bottom"><strong>Model:</strong> </td>

<td class="bor-left bor-bottom" colspan="6">'. $capa->model.'</td>

<td class="bor-right bor-tb"><strong>Reported by : </strong></td>

<td class="bor-left bor-tb" colspan="4">'. $capa->reported_by.'</td>

<td class="bor-right bor-tb"><strong>Date of issue:</strong>   </td>

<td class="bor-left bor-tb" colspan="2">'. date( 'd-m-Y', strtotime($capa->date_issue)).'</td>

</tr>

<tr>

<td class="bor-right bor-tb"><strong>Problem Description:  </strong></td>

<td class="bor-left bor-tb" colspan="6">'. $capa->problem_desc.'</td>

<td class="bor-right bor-tb"><strong>Team Members:</strong></td>

<td class="bor-left bor-tb" colspan="4" >'. $capa->team_member.'</td>

<td colspan="3" class="bor-tb"></td>

</tr>

<tr>

<td class="bor-right bor-tb"><strong>Feedback Date:</strong></td>

<td class="bor-left bor-tb" colspan="6">'. date( 'd-m-Y', strtotime($capa->feedback_date)).'</td>

<td class="bor-right bor-top"><strong>Reviewed by:</strong> </td>

<td class="bor-left bor-top" colspan="4">'. $capa->reviewed_by.'</td>

<td class="bor-right bor-top"><strong>Reviewed date :</strong> </td>

<td class="bor-left bor-top" colspan="2">'. date( 'd-m-Y', strtotime($capa->reviewed_date)).'</td>

</tr>

<tr>

<td class="bor-right bor-top"><strong>contact person Name:</strong></td>

<td class="bor-left bor-top"  colspan="6">'. $capa->contact_person_name.'</td>

<td class=" bor-top"  colspan="8"></td>

</tr>

<tr>

<td colspan="7" bgcolor="#66FF99"><strong>1) Problem Description:</strong> </td>

<td colspan="6" bgcolor="#66FF99">5) Correction:</td>

<td width="107" bgcolor="#66FF99"><strong>Who</strong> </td>

<td width="65" bgcolor="#66FF99"><strong>When</strong></td>

</tr>

<tr>

  <td colspan="7" class="bor-bottom"><strong>Where : '. $capa->problem_where.'</strong></td>

  <td colspan="6" rowspan="5" align="center" valign="middle">'. $capa->correction_remark.'</td>

  <td rowspan="5" align="center">'. $capa->correction_who.'</td>

  <td rowspan="5" align="center">'. $capa->correction_when.'</td>

</tr>

<tr>

  <td colspan="7"  class="bor-tb"><strong>When : '. $capa->problem_when.'</strong></td>

</tr>

<tr>

<td colspan="7"  class="bor-tb"><strong>What Qty : '. $capa->problem_what_qty.'</strong></td>

</tr>

<tr>

<td colspan="7" class="bor-tb"><strong>Which model: '. $capa->problem_which_model.'</strong></td>

</tr>

<tr>

<td colspan="7" class="bor-top"><strong>Who produced : '. $capa->problem_who_produced.'</strong></td>

</tr>

<tr>

<td colspan="7" bgcolor="#66FF99"><strong>2) Findings / Investigation :</strong></td>

<td colspan="6" bgcolor="#66FF99"><strong>6) Corrective Action:</strong></td>

<td bgcolor="#66FF99"><strong>Who</strong></td>

<td bgcolor="#66FF99"><strong>When</strong></td>

</tr>

<tr>

  <td colspan="7" align="center">'. $capa->finding_invest_remark.'</td>

  <td colspan="6">'. $capa->corrective_remark.'

  <td align="center">'. $capa->corrective_who.'</td>

  <td align="center">'. $capa->corrective_when.'</td>

</tr>

<tr>

  <td colspan="7" bgcolor="#66FF99"><strong>3 ) Structured &amp; systematic analysis of probable causes</strong></td>

  <td colspan="6" bgcolor="#66FF99"><strong>7) Verification of Effectiveness:</strong></td>

  <td bgcolor="#66FF99"><strong>Who</strong></td>

  <td bgcolor="#66FF99"><strong>When</strong></td>

</tr>

<tr>

<td colspan="7">'. $capa->structured_remark.'</td>

<td colspan="6">'. $capa->verify_remark.'</td>

<td align="center">'. $capa->verify_who.'</td>

<td align="center">'. $capa->verify_when.'</td>

</tr>

<tr>

  <td colspan="7" bgcolor="#66FF99"><strong>4) Root cause identified</strong></td>

  <td colspan="6" bgcolor="#66FF99"><strong>8) Preventive action (Horizontal deployment)if applicable</strong></td>

  <td bgcolor="#66FF99"><strong><strong>Who</strong></strong></td>

  <td bgcolor="#66FF99"><strong>When</strong></td>

</tr>

<tr>

<td colspan="7">'. $capa->root_cause_remark.'</td>

<td colspan="6">'. $capa->prevent_remark.'</td>

<td align="center">'.$capa->prevent_who.'</td>

<td align="center">'. $capa->prevent_when.'</td>

</tr>

<tr>
  <td style="padding: 0; border: none;" colspan="15">

    <table width="100%" border="1" style="border:none;" cellspacing="0" cellpadding="5">
      <tr class="row37">  

        <td><strong>'.$complaint->emp_name.'</strong></td>

        <td><strong>'.$complaint->capa_qa_name.'</strong></td>

        <td><strong>'.$complaint->capa_ph_name.'</strong></td>

        <td>'.$complaint->capa_pc_name.'</td>

        <td>'.$complaint->capa_mr_name.'</td>

      </tr>

      <tr>

      <td><strong>Prepared  by    Checked by</strong></td>

      <td><strong>Quality Assurance</strong></td>

      <td><strong>Verified By</strong></td>

      <td><strong>Plant chief (Approved by)</strong></td>

      <td><strong>Management Representative</strong></td>

      </tr>
    </table>

  </td>
</tr>

</tbody>

</table> <i class="signature"> This is a computer-generated document. No signature is required. </i>';





$dompdf->loadHtml($html);



// (Optional) Setup the paper size and orientation

$dompdf->setPaper('A4', 'landscape');



// Render the HTML as PDF

$dompdf->render();



$output = $dompdf->output();



$uniquid = time();

//$pdfname = $uniquid.".pdf";

$pdfname = "capa-".$capa->document_no.".pdf";



$file_location = "../document/pdf/".$pdfname;

file_put_contents($file_location, $output);



//$dompdf->stream();


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

    



        /*header("Content-Type: application/octet-stream");

        //$file = $_GET["file"] .".pdf";

        header("Content-Disposition: attachment; filename=" . urlencode($file_location));   

        header("Content-Type: application/download");

        header("Content-Description: File Transfer");            

        header("Content-Length: " . filesize($file_location));

        flush(); // this doesn't really matter.

        $fp = fopen($file_location, "r");

        while (!feof($fp))

        {

            echo fread($fp, 65536);

            flush(); // this is essential for large downloads

        } 

        fclose($fp); 

    */



        /*header('Content-Description: File Transfer');

        header('Content-Type: application/octet-stream');

        header('Content-Disposition: attachment; filename="'.basename($file_location).'"');

        header('Expires: 0');

        header('Cache-Control: must-revalidate');

        header('Pragma: public');

        header('Content-Length: ' . filesize($file_location));

        flush(); // Flush system output buffer

        readfile($file_location);

        exit;*/

    }



?>