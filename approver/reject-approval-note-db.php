<?php
  ob_start();
  require_once("../includes/initialize.php"); 

  if (! $session->is_employee_logged_in()){ 
      redirect_to("logout.php");
  }

?>
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
<script src="assets/js/app.min.js"></script>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#success-alert-modal').modal('show');
    });
</script>

  <?php 
    $employee_reg = EmployeeReg::find_by_id($session->employee_id);

    $emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != 'Employee' ";

    $employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);

    if(!$employee_location){
      redirect_to("logout.php?"); 
    }

    $emp_sub_role_appr = '';
    $approver_name = '';

    $valid_roles = ["CRM - Head", "Commercial Head", "Plant Chief - AN", "Sales Head", "CFO", "MD"];
    foreach ($employee_location as $key => $value) {
        if( in_array($value->emp_sub_role, $valid_roles) ){
            $emp_sub_role_appr = $value->emp_sub_role;
            $approver_name = $value->emp_name;
            break;
        }
    }
    if( empty($emp_sub_role_appr)){
      $session->message('Invalid Role');
      redirect_to("approval.php"); 
    }


    if(!isset($_GET['id']) || empty($_GET['id'])){
        $session->message('Complaint Not Found');
        redirect_to("approval.php"); 
    }
        
    $complaint = Complaint::find_by_id($_GET['id']);

    if(! can_approve_complaint($complaint, $emp_sub_role_appr ) ){
        $session->message("Previous approval is pending. ");
            redirect_to("approval.php");
    }
    

    $appr_note = ApprovalNote::get_active_approval_note_by_comp_id($_GET['id']);

    if(! $appr_note){
        $session->message('Active approval note not found for this complaint.');
        redirect_to("approval.php"); 
    }

    $appr_note->on_hold         = 1;
    $appr_note->on_hold_remark  = $_POST['approver_hold_remark'];
    $appr_note->on_hold_by      = $approver_name;
    $appr_note->on_hold_date    = date("Y-m-d H:i:s");
    
    if($appr_note->save()) {

        $complaint->approval_on_hold  = 1;
        $complaint->save();

        // if( $appr_note->creator_id){
        if( $complaint->emp_id ){
            $note_creator = EmployeeReg::find_by_id( $complaint->emp_id );

            if( $note_creator ){
                $subject = getComplaintSubjectAdmin($complaint);
                $body = "
                  Approval note is rejected by ".$approver_name."
                  <br><br>

                   <b>Reject Remark : </b> <br>".$_POST['approver_hold_remark']."
                   <br><br>

                  <a style=' text-decoration:none; color:#1774b5' href='".BASE_URL."administrator/employee/view-complaints.php?id=".$_GET['id']."'>".BASE_URL."administrator/employee/view-complaints.php?id=".$_GET['id']."</a>
                ";


                $toArr = array(
                  ['email' => $note_creator->emp_email, 'name' => $note_creator->emp_name ]
                );
                  
                sendComplaintMail($complaint, $subject, $body, $toArr );
            }
            
        }
        

  ?>
    <!-- Success Alert Modal -->
    <div id="success-alert-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content modal-filled bg-success">
          <div class="modal-body p-4">
            <div class="text-center">
              <i class="dripicons-checkmark h1"></i>
              <h2 class="mt-2">Success</h2>
              <p class="mt-3" style="font-size:18px;">
                You have successfully rejected Approval Note.
              </p>
              <a href="approval.php" class="btn btn-light my-2">Continue</a>
            </div>
          </div>
        </div><!-- /.modal-content -->
      </div> <!-- /.modal-dialog -->
    </div><!-- /.modal -->

 <?php      
    }else{
      $session->message("Failed to Reject Approval Note");
      redirect_to("approval.php");
    }