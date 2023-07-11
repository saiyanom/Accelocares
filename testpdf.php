<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'pdfcreator/vendor/dompdf/dompdf/lib/html5lib/Parser.php';
require_once 'pdfcreator/vendor/phenx/php-font-lib/src/FontLib/Autoloader.php';
require_once 'pdfcreator/vendor/phenx/php-svg-lib/src/autoload.php';
require_once 'pdfcreator/vendor/dompdf/dompdf/src/Autoloader.php';
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


</style>

</head>

<body>
<table border="1" cellpadding="5" align="center" cellspacing="0" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000">
<tbody>
<tr>
<td colspan="2" rowspan="4" style="margin:0;padding:0; background-image: url(images/accelo.png); background-repeat: no-repeat; background-position: center; "></td>
<td colspan="10" rowspan="3" align="center" style=" font-size:20px"><strong>MAHINDRA STEEL SERVICE CENTRE LTD.</strong> </td>
<td colspan="3" align="center"><strong>Management Representative</strong></td>
</tr>
<tr>
<td width="92"><strong>Document No.</strong></td>
<td colspan="2">QF/SC/09 B	</td>
</tr>
<tr>
<td><strong>Rev. No.</strong></td>
<td colspan="2">2</td>
</tr>
<tr>
<td colspan="10" align="center"><strong>Corrective And Preventive Action Report</strong></td>
<td><strong>Page No.</strong></td>
<td colspan="2">01 of 01</td>
</tr>
<tr>
<td width="145" class="bor-right bor-bottom"><strong>Customer Name:</strong></td>
<td colspan="6" class="bor-left bor-bottom">LTL Transformers Pvt Ltd</td>
<td width="76" class="bor-right bor-bottom"><strong>CAPA No:</strong></td>
<td colspan="4" class="bor-left bor-bottom">1</td>
<td colspan="3" class="bor-bottom"></td>
</tr>
<tr>
<td class="bor-right bor-bottom"><strong>Model:</strong> </td>
<td class="bor-left bor-bottom" colspan="6">110mm 23ZDKH85 - 0.23 x C & 150 MM - 23ZDKH85 - 0.23 x C</td>
<td class="bor-right bor-tb"><strong>Reported by : </strong></td>
<td class="bor-left bor-tb" colspan="4">Jayalathdi Muthu</td>
<td class="bor-right bor-tb"><strong>Date of issue:</strong>   </td>
<td class="bor-left bor-tb" colspan="2">20.09.2018</td>
</tr>
<tr>
<td class="bor-right bor-tb"><strong>Problem Description:  </strong></td>
<td class="bor-left bor-tb" colspan="6">High Burr issue</td>
<td class="bor-right bor-tb"><strong>Team Members:</strong></td>
<td class="bor-left bor-tb" colspan="4" >Vaibhav Chavan, Adhivesh H., Rahul N,Pankaj Mishra</td>
<td colspan="3" class="bor-tb"></td>
</tr>
<tr>
<td class="bor-right bor-tb"><strong>Feedback Date:</strong></td>
<td class="bor-left bor-tb" colspan="6">9/20/2018</td>
<td class="bor-right bor-top"><strong>Reviewed by:</strong> </td>
<td class="bor-left bor-top" colspan="4">Laxman Mahale (Plant Chief)</td>
<td class="bor-right bor-top"><strong>Reviewed date :</strong> </td>
<td class="bor-left bor-top" colspan="2">22.09.2018</td>
</tr>
<tr>
<td class="bor-right bor-top"><strong>contact person Name:</strong></td>
<td class="bor-left bor-top"  colspan="6">Jayalathdi Muthu</td>
<td class=" bor-top"  colspan="8"></td>
</tr>
<tr>
<td bgcolor="#66FF99"><strong>1) Problem Description:</strong> </td>
<td colspan="6" bgcolor="#FFFF00"><strong>High Burr issue</strong> </td>
<td colspan="6" bgcolor="#66FF99">5) Correction:</td>
<td width="107" bgcolor="#66FF99"><strong>Who</strong> </td>
<td width="65" bgcolor="#66FF99"><strong>When</strong></td>
</tr>
<tr>
  <td colspan="7" class="bor-bottom"><strong>Where : During core building and testing.</strong></td>
  <td colspan="6" rowspan="6" align="center" valign="middle">The material not avialable for correction. However other WIP coil checked and found OK.</td>
  <td rowspan="6" align="center">Vaibhav Chavan, Pankaj Mishra</td>
  <td rowspan="6" align="center">21.09.2018</td>
</tr>
<tr>
  <td colspan="7"  class="bor-tb"><strong>When : 20/09/2018</strong></td>
</tr>
<tr>
<td colspan="7"  class="bor-tb"><strong>What Qty : 19.3 MT</strong></td>
</tr>
<tr>
<td colspan="7" class="bor-tb"><strong>Which model: 110mm 23ZDKH85 - 0.23 x C & 150 MM - 23ZDKH85 - 0.23 x C</strong></td>
</tr>
<tr>
<td colspan="7" class="bor-top"><strong>Who produced : CKK Line</strong></td>
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
  <td colspan="7" align="center">Burr was found more than specification on the slit edge of the Coil against PO. No.:1000906 having width 110mm & 150mm, grade-23ZDKH85.</td>
  <td colspan="6">
    i)The packing material at inline unit changed.<br />
    ii) Bakellite has been introduced in place of cardboard as packing material .<br />
    iii)Enough stock (15 nos.) of bakellite has been ensured at CKK line to avoid any usage of alternate material as packing material in shortage .</td>
  <td align="center">Production Engineer & Line Operator</td>
  <td align="center">21.09.2018</td>
</tr>
<tr>
  <td colspan="7" bgcolor="#66FF99"><strong>3 ) Structured &amp; systematic analysis of probable causes</strong></td>
  <td colspan="6" bgcolor="#66FF99"><strong>7) Verification of Effectiveness:</strong></td>
  <td bgcolor="#66FF99"><strong>Who</strong></td>
  <td bgcolor="#66FF99"><strong>When</strong></td>
</tr>
<tr>
<td colspan="7">
i)Burr may be generated while slitting at slit edges at CKK Line because of blunt cutter or<br />
ii)Improper gap setting of the sliting cutter  may also lead to generation of burr .<br />
iii)The defective packing material at inline unit may also lead to burr generation. 
</td>
<td colspan="6">During slitting the coil the coils has been checked thrice on sample basis and  burr found within tolerance (15Micron).Also customer has been asked for their feedback in future supply.</td>
<td align="center">MSSCL </td>
<td align="center">From all next processing & supplies.</td>
</tr>
<tr>
  <td colspan="7" bgcolor="#66FF99"><strong>4) Root cause identified</strong></td>
  <td colspan="6" bgcolor="#66FF99"><strong>8) Preventive action (Horizontal deployment)if applicable</strong></td>
  <td bgcolor="#66FF99"><strong><strong>Who</strong></strong></td>
  <td bgcolor="#66FF99"><strong>When</strong></td>
</tr>
<tr>
<td colspan="7">The burr was generated because of defective packing material at inline unit.</td>
<td colspan="6">At all Sliting line within MIL					
					
					
					
</td>
<td align="center">Production Engineer & Line Operator</td>
<td align="center">22.09.2018</td>
</tr>
<tr class="row37">
  <td colspan="2"><strong>Udit Arora</strong></td>
  <td colspan="4"><strong>Pankaj Mishra</strong></td>
  <td><strong>Vaibhav Chavan</strong></td>
  <td colspan="4"> </td>
  <td colspan="4"> </td>
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


</body></html>';

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

$output = $dompdf->output();

$uniquid = time();

$file_location = "document/pdf/".$uniquid.".pdf";
file_put_contents($file_location, $output);

$dompdf->stream();

die("--");
    // Process download
    /*if(file_exists($file_location)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file_location).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_location));
        flush(); // Flush system output buffer
        readfile($file_location);
        exit;
    }*/

// Output the generated PDF to Browser
//$dompdf->stream();

?>