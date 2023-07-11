<?php

function sendMail($subject, $body, $toArr , $ccArr=[]){
   // d($toArr);   d($ccArr);  echo '------------------------------';
    // return true;
    $is_live = 0;
    if(SERVER_ENV == 'live'){
         $is_live = 1;
    }

    $email_arr = [];

    $temp_cc = [
      ['email' => 'salvi.suvarna@mahindra.com', 'name' => 'Salvi Suvarna' ], 
      ['email' => 'gajelli.lalita@mahindra.com', 'name' => 'Lalita Gajelli' ]
    ];

    $ccArr = array_merge($ccArr,$temp_cc);

    foreach ($toArr as $key => $value) {
       if(empty($value['email'])){
          unset($toArr[$key]);
       }else{
          if( in_array($value['email'], $email_arr) ){
             unset($toArr[$key]);
          }else{
              $email_arr[] = $value['email'];
          }
       }
    }

    foreach ($ccArr as $key => $value) {
       if(empty($value['email'])){
          unset($ccArr[$key]);
       }else{
          if( in_array($value['email'], $email_arr) ){
             unset($ccArr[$key]);
          }else{
              $email_arr[] = $value['email'];
          }
       }
    }


    // d($toArr);  d($ccArr); echo '------------------------------';  
    // dd($email_arr);

    // return ['status' => 1];
    
    if (!class_exists('PHPMailer')) {
      require '../PHPMailer/PHPMailerAutoload.php';
    }

    if(!$toArr){
      return ['status' => 0,'message'=> 'Receiver array is empty'];
    }

    $body_extra = '';

    if($is_live != 1) {
        $body_extra = "<p>To Array : ". json_encode($toArr)."</p>
              <p><br><br> Cc Array : ". json_encode($ccArr)."</p>";
    } 
    

    $bodyContent = "
      ".$body_extra."
      <table cellpadding='0' cellspacing='0' border='0' align='left' style=' background:#fff;width:700px;  min-width:300px; color:#262626; font-size:17px; font-family: Verdana, Geneva, sans-serif'>
        <tr>
          <td style='display:block'>
            <img src='".BASE_URL."administrator/images/1.jpg?v=1' />
          </td>
        </tr>
        <tr>
          <td cellpadding='0' cellspacing='0' border='0' width='100%' style='display:block;'>
            <table border='0' style=' padding:30px '>
              <tr>
                <td style='line-height:23px'>
                  ".$body."

                  <p>Thank You! </p>   
                  <p>Warm Regards, <br />
                      CRM Team <br />
                      <img src='".BASE_URL."administrator/images/logo.png?v=1' />
                  </p> 

                  <p><i>Note: This is an auto generated e-mail, hence please do not reply.</i></p>

                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td style='display:block'>
            <img src='".BASE_URL."administrator/images/1.jpg?v=1' />
          </td>
        </tr>
      </table>";


      $mail = new PHPMailer;

      if($is_live == 1){
          // $mail->IsMail();                           
            //Accelo mail 
          $mail->IsSMTP();   
          // $mail->SMTPDebug = 2;                        
          $mail->Host = '172.32.0.173'; 
          $mail->SMTPAuth = false;    
          $mail->Username = ''; 
          $mail->Password = ''; 
          $mail->Port = 25; 
          //$mail->SMTPSecure = 'ssl'; 

          // $mail->Mailer = "smtp";
          $mail->Priority = 1;
          $mail->setFrom('crm.accelo@emailmahindra.com', 'Mahindra Accelo');

          foreach ($toArr as $key => $value) {
              $mail->addAddress(getValue($value,'email'),getValue($value,'name'));
          }

          // $mail->addCC('salvi.suvarna@mahindra.com','Salvi Suvarna');
          // $mail->addCC('gajelli.lalita@mahindra.com','Lalita Gajelli');

          if($ccArr){
              foreach ($ccArr as $key => $value) {
                $mail->addCC(getValue($value,'email'),getValue($value,'name'));
              }
          }
      }else{
          $mail->IsSMTP();   
          $mail->Priority = 1;
          // $mail->SMTPDebug = 3;
          // $mail->Debugoutput = 'html'; 

          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'tech.agency09@gmail.com';
          $mail->Password = 'zojeopveyeiggcit';
          $mail->Port = 587;
          $mail->setFrom('tech.agency09@gmail.com', 'Mahindra Accelo');

          $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
          );
          
          $mail->addAddress('nilesh@agency09.in', 'Nilesh');
          $mail->addCC('rasika@agency09.in', 'Rasika');
         /* if($_SERVER['SERVER_NAME'] != 'localhost'){
            $mail->addCC('rasika@agency09.in', 'Rasika');
            $mail->addCC('shivani@agency09.in', 'Shivani');
            $mail->addCC('gajela-cont@mahindra.com', 'Lalita');
          }*/
      }


      $mail->Subject = $subject;
      $mail->Body = $bodyContent;
      $mail->isHTML(true);

      if( !$mail->send() ) {
          return ['status' => 0,'message'=> $mail->ErrorInfo];
      }
      else {
          return ['status' => 1];
      }
}

function sendComplaintMail($complaint, $subject, $body, $toArr , $ccArr=[]){

    $product = Product::find_product_id($complaint->business_vertical,$complaint->plant_location,$complaint->product);

    if($product){

        $newToArr = getLocationChampsDetails($product->id);
        $newCcTArr = getLocationEmployeeByRole($product->id, "Commercial Head");

        $toArr = array_merge($toArr,$newToArr);
        $ccArr = array_merge($ccArr,$newCcTArr);
    }

    return sendMail($subject, $body, $toArr , $ccArr);
}

function sendSms($mobile, $message){
	return true;//remove this line
  if(SERVER_ENV != 'live'){
      return true;
  }
  


  $xml_data ='<?xml version="1.0"?> 
      <SmsQueue>
        <Account>
          <User>accelo</User>
          <Password>acl@321</Password>
        </Account>
        <MessageData>
          <SenderId>ACCELO</SenderId>
          <Gwid>2</Gwid>
          <DataCoding>0</DataCoding>
        </MessageData>
        <Messages>
          <Message>
            <Number>'.$mobile.'</Number>
            <Text>'.$message.'</Text>
          </Message>
        </Messages>
      </SmsQueue>
      ';

      $URL = "http://mobile1.ssexpertsystem.com/Rest/Messaging.svc/mtsms?data="; 

      $ch = curl_init($URL);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
      curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($ch);
      curl_close($ch);


      if (strpos($output, '<ErrorCode>000</ErrorCode>') !== false) {
        //echo "Yes";
      } else { 
        return $output; 
      }
}

function showPhpErrors(){
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
}

function dd($data){
  echo '<pre>';  
  print_r($data);
  echo '</pre>';
  die;
}
function d($data){
  echo '<pre>';  
  print_r($data);
  echo '</pre>';
}

function getUserIpAddr(){
	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		//ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		//ip pass from proxy
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

function strip_zeros_from_date( $marked_string="" ) {
  // first remove the marked zeros
  $no_zeros = str_replace('*0', '', $marked_string);
  // then remove any remaining marks
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function output_message($message="") {
  if (!empty($message)) { 
    return $message;
  } else {
    return "";
  }
}

/*function __autoload($class_name) {
	$class_name = strtolower($class_name);
  $path = LIB_PATH.DS."{$class_name}.php";
  if(file_exists($path)) {
    require_once($path);
  } else {
		die("The file {$class_name}.php could not be found.");
	}
}

function include_layout_template($template="") {
	include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template);
}
*/


function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}


function getValue($arr,$key){
    $res = '';
    if(isset($arr[$key])){
        $res = $arr[$key];
    }
    return $res;
}



function customComplaintStatus($complaint)
{ 
    if($complaint->status == "Closed" || $complaint->status == "Invalid"){
      return $complaint->status;
    }
    if($complaint->approval_note != '' && $complaint->approval_on_hold == 1) {
        return 'Approval note rejected';
    }
    // $note_exist = ApprovalNote::note_exist($complaint->id);
    // else if($complaint->emp_status == 'Approval Note Submitted') {
    if($complaint->approval_note != '') {
      $msg = 'To be approved by ';
      if($complaint->cna_crm_head != "Yes"){
        return $msg.' CRM Head';
      }
      if($complaint->cna_commercial_head != "Yes"){
        return $msg.' Commercial Head';
      }
      if($complaint->cna_plant_chief != "Yes"){
        return $msg.' Plant Chief';
      }
      if($complaint->cna_sales_head != "Yes"){
        return $msg.' Sales Head';
      }
      if($complaint->cna_cfo != "Yes"){
        return $msg.' CFO';
      }
      if($complaint->cna_md_status == "Yes" && $complaint->cna_md != "Yes"){
        return $msg.' MD';
      }
      return 'Approved by all';
      // return $complaint->emp_status;
    }
    else {
      return $complaint->emp_status;
    }
}

function customComplaintApprovalStatus($complaint)
{ 
    if($complaint->status == "Closed" || $complaint->status == "Invalid"){
      return $complaint->status;
    }

    if($complaint->approval_note != '' && $complaint->approval_on_hold == 1) {
        return 'Approval note rejected';
    }

    $msg = 'To be approved by ';
    if($complaint->cna_crm_head != "Yes"){
      return $msg.' CRM Head';
    }
    if($complaint->cna_commercial_head != "Yes"){
      return $msg.' Commercial Head';
    }
    if($complaint->cna_plant_chief != "Yes"){
      return $msg.' Plant Chief';
    }
    if($complaint->cna_sales_head != "Yes"){
      return $msg.' Sales Head';
    }
    if($complaint->cna_cfo != "Yes"){
      return $msg.' CFO';
    }
    if($complaint->cna_md_status == "Yes" && $complaint->cna_md != "Yes"){
      return $msg.' MD';
    }
    return 'Approved by all';
}

function getApprovalPageCommonData($complaint,$emp_sub_role_appr){
    $modal_html = "<td><a data-toggle='modal' class='view_approval_note' data-id='$complaint->approval_note' data-target='#approval-note' href='#'>View</a></td>";

    $pending_html = "<td><span class='closed-td'>Pending</span></td>
                      <td>".customComplaintApprovalStatus($complaint)."</td>";

    $approved_html = "<td><span class='open-td'>Approved</span></td>
                      <td>".customComplaintApprovalStatus($complaint)."</td>
                      ".$modal_html;
                      // <td><a>View</a></td>";
    // $view_html = '<td><a>View</a></td>';
    $view_html = $modal_html;


      if($emp_sub_role_appr == "CRM - Head"){
        if(empty($complaint->cna_crm_head)){
          echo $pending_html;
          echo $modal_html;
        } else {
          echo $approved_html;
        }
      } 
      else if($emp_sub_role_appr == "Commercial Head"){
        if(empty($complaint->cna_commercial_head)){
          echo $pending_html;
          echo (!empty($complaint->cna_crm_head)) ? $modal_html : $view_html;

        } else {
          echo $approved_html;
        }
      } 
      else if($emp_sub_role_appr == "Plant Chief - AN"){
        if(empty($complaint->cna_plant_chief)){
          echo $pending_html;
          echo (!empty($complaint->cna_commercial_head)) ? $modal_html : $view_html;

        } else {
          echo $approved_html;
        }
      } else if($emp_sub_role_appr == "Sales Head"){
        if(empty($complaint->cna_sales_head)){
          echo $pending_html;
          echo (!empty($complaint->cna_plant_chief)) ? $modal_html : $view_html;

        } else {
          echo $approved_html;
        }
      } else if($emp_sub_role_appr == "CFO"){
        if(empty($complaint->cna_cfo)){
          echo $pending_html;
          echo (!empty($complaint->cna_sales_head)) ? $modal_html : $view_html;

        } else {
          echo $approved_html;
        }
      } else if($emp_sub_role_appr == "MD"){
        if(empty($complaint->cna_md)){
          echo $pending_html;
          echo (!empty($complaint->cna_cfo)) ? $modal_html : $view_html;

        } else {
          echo $approved_html;
        }
      } 
}

function can_approve_complaint($complaint,$subrole){

  $roles = [
    0 => [ 'id' => 'cna_crm_head',  'name' => 'CRM - Head'],
    1 => [ 'id' => 'cna_commercial_head',  'name' => 'Commercial Head'],
    2 => [ 'id' => 'cna_plant_chief',  'name' => 'Plant Chief - AN'],
    3 => [ 'id' => 'cna_sales_head',  'name' => 'Sales Head'],
    4 => [ 'id' => 'cna_cfo',  'name' => 'CFO'],
    5 => [ 'id' => 'cna_md',  'name' => 'MD'],
    /*'cna_crm_head'        => 'CRM - Head',
    'cna_commercial_head' => 'Commercial Head',
    'cna_plant_chief'     => 'Plant Chief - AN',
    'cna_sales_head'      => 'Sales Head',
    'cna_cfo'             => 'CFO',
    'cna_md'              => 'MD',*/
  ];

  // $roles = array_flip($roles);
  // $col_key = $roles[$subrole];

  // $index = 0;
  foreach ($roles as $key => $value) {
      $prev_key = ($key != 0) ? $roles[$key-1]['id'] : '';

      $column = $value['id'];

      if( $value['name'] == trim($subrole)){

          if($column == 'cna_crm_head'){
              return empty($complaint->$column) ? true : false;
          }
          else if($column == 'cna_md'){
              //previous approver has approved and current approver has not.+ md approve = yes
              return ($complaint->cna_md_status == "Yes" && empty($complaint->cna_md) && $complaint->$prev_key == "Yes" ) ? true : false;
          }
          else {
              //previous approver has approved and current approver has not.
              return (empty($complaint->$column) && $complaint->$prev_key == "Yes" ) ? true : false;
          }
      }
  }
  return false;
}


function show_approver_info_common($complaint_reg,$approval_note){
   $approver_info = '';
    if($complaint_reg->cna_crm_head == "Yes"){
       $approver_info .= 'CRM Head : '.$complaint_reg->cna_crm_head_name.'</br>';   
    }
    if($complaint_reg->cna_commercial_head == "Yes"){
      $approver_info .= 'Commercial Head : '.$complaint_reg->cna_commercial_head_name.'</br>';
    }
    if($complaint_reg->cna_plant_chief == "Yes"){
      $approver_info .= 'Plant chief : '.$complaint_reg->cna_plant_chief_name.'</br>';
    }
    if($complaint_reg->cna_sales_head == "Yes"){
       $approver_info .= 'Sales Head : '.$complaint_reg->cna_sales_head_name.'</br>';
    }
    if($complaint_reg->cna_cfo == "Yes"){
      $approver_info .= 'CFO : '.$complaint_reg->cna_cfo_name.'</br>';
    }
    if($complaint_reg->cna_md_status == "Yes" && $complaint_reg->cna_md == "Yes"){
      $approver_info .= 'MD : '.$complaint_reg->cna_md_name.'</br>';
    }

   if($approver_info){
    echo ' <ul class="fpall approver_info"> <hr>
            <p class="colrred_black"><strong>Approved By : </strong></p>
             <p>'.$approver_info.'</p>
          </ul>';
    }
    
    $remarks = ApprovalRemark::find_by_note_id($approval_note->id);

    if($remarks){
        echo ' <ul class="fpall" > <hr />
            <p class="colrred_black"><strong>Approver Remarks :</strong></p> ';

        foreach ($remarks as $key => $value) {
          echo '<div class="row"> <div class="col-md-2"><strong>'.$value->emp_name.'</strong> </div> <div class="col-md-10">'.$value->remark.'</div> </div>';
        }
        echo ' </ul>';
    }
    if($approval_note->approver_remark){
          echo ' <ul class="fpall" >
                  <hr />
                  <p class="colrred_black"><strong>Approver Remark</strong></p>
                  '.$approval_note->approver_remark.'
              </ul>';
      }
}


function getComplaintSubjectCustomer($complaint){

      $subject = "{$complaint->business_vertical} | {$complaint->plant_location} | Complaint ID #{$complaint->ticket_no} | {$complaint->company_name} | {$complaint->complaint_type}";

    return $subject;
}

function getComplaintSubjectAdmin($complaint){
      $complaint_type = $complaint->complaint_type;
      if( $complaint->sub_complaint_type != 'None' && !empty($complaint->sub_complaint_type)){
          $complaint_type = $complaint_type .' - '.$complaint->sub_complaint_type;
      }

      $other = '';
      if($complaint->identify_source != ''){
          if($complaint->identify_source == 'Mill'){
              $other = ' | Source - '.$complaint->mill;
          }
          else if( $complaint->identify_source == 'Plant' ){
              $other = ' | Source - Plant';
          }
          else if( $complaint->identify_source == 'Plant' ){
              $other = ' | Source - '.$complaint->other_source;
          }
      }

      $subject = "{$complaint->business_vertical} | {$complaint->plant_location} | Complaint ID #{$complaint->ticket_no} | {$complaint->company_name} | {$complaint_type}".$other;

    return $subject;
}

function getLocationChampsDetails($productId){
    $sql = "Select * from employee_location where product_id = {$productId} AND role_priority = 'Responsible'";
    $employee_location = EmployeeLocation::find_by_sql($sql);

    $result = [];
    if($employee_location){
       foreach ($employee_location as $key => $value) {
         $result[] = ['id' => $value->emp_id, 'email' => $value->emp_email, 'name' => $value->emp_name ];
       }
    }
    return $result;
}

function getLocationEmployeeByRole($productId,$role){
    $data = EmployeeLocation::find_by_productId_emp_role_many($productId,$role);

    $result = [];
    if($data){
        // $result[] = ['id' => $data->emp_id, 'email' => $data->emp_email, 'name' => $data->emp_name ];

       foreach ($data as $key => $value) {
         $result[] = ['id' => $value->emp_id, 'email' => $value->emp_email, 'name' => $value->emp_name ];
       }
    }
    return $result;
}


function getSourceText($complaint){
    if($complaint->identify_source == "Mill"){
      $source_text = "Mill - ".$complaint->mill;
    }
    else if($complaint->identify_source == "Plant"){
      $source_text = "Plant - ".$complaint->plant_location;
    }
    else if($complaint->identify_source == "Other"){
      $source_text = "Other - ".$complaint->other_source;
    }
    else{
      $source_text = $complaint->identify_source;
    }

    return $source_text;
}


?>