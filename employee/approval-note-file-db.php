<?php 
  ob_start();
  require_once("../includes/initialize.php"); 
  showPhpErrors();

  foreach ($_POST as $key => $value) {
    if (preg_match('/[\"\^*}!{><;`=]/', $value)){
      $session->message("Remove Special Character"); redirect_to("my-complaints.php"); 
    } 
  }
  foreach ($_GET as $key => $value) {
    if (preg_match('/[\"\^*}!{><;`=]/', $value)){
      $session->message("Remove Special Character"); redirect_to("my-complaints.php"); 
    }
  }

  if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

  foreach ($_POST as $key => $value) {
    echo htmlspecialchars($key)." = ".htmlspecialchars($value)."<br>";
  }



  if(!isset($_GET['id']) || empty($_GET['id'])){
    $session->message('Approval Note id is missing');
    redirect_to("my-complaints.php"); 
  }
  $approvalNote = ApprovalNote::find_by_id($_GET['id']);
  if( ! $approvalNote ){
    $session->message('Approval Note Not Found');
    redirect_to("my-complaints.php"); 
  }

  $complaint = Complaint::find_by_id($approvalNote->complaint_id);

  if( ! $complaint ){
    $session->message('Complaint Not Found');
    redirect_to("my-complaints.php"); 
  }

  if($complaint->emp_id != $session->employee_id){
      $session->message('You can not upload documents.');
      redirect_to("my-complaints.php");
  }

  $path = "../document/".$complaint->ticket_no."/note";


  $docs_arr = [];

  for ($i=1; $i <=5 ; $i++) { 
     $file_key = 'note_doc_'.$i;

     if( isset($_FILES[$file_key]) ){

        $file_name          = basename($_FILES[$file_key]['name']);

        if (!file_exists($path)) {
          mkdir($path, 0777, true);
        }

        if(!empty($file_name)) {
          $file_name          = str_replace(" ","_",$file_name);
          $file_name          = time()."-".$file_name;
          $tp_photo           = $path."/".$file_name;
          $move_photo         = move_uploaded_file($_FILES[$file_key]['tmp_name'], $tp_photo);
        }else{
          $file_name = getValue($_POST,$file_key);
        }

        $docs_arr[] = $file_name;
     }else{
        $docs_arr[] = '';
     }
  }
// d($_FILES);
// d($_POST);
//   dd($docs_arr);
  
  $approvalNote->file_1 = isset($docs_arr[0]) ? $docs_arr[0] : '';
  $approvalNote->file_2 = isset($docs_arr[1]) ? $docs_arr[1] : '';
  $approvalNote->file_3 = isset($docs_arr[2]) ? $docs_arr[2] : '';
  $approvalNote->file_4 = isset($docs_arr[3]) ? $docs_arr[3] : '';
  $approvalNote->file_5 = isset($docs_arr[4]) ? $docs_arr[4] : '';
  
  if($approvalNote->save()) {
    // Success
    $session->message("Files updated Successfully");
  } else {
    // Failure
    $session->message("Failed to update data");
  }

  redirect_to("view-complaints.php?id=".$approvalNote->complaint_id); 




?>


