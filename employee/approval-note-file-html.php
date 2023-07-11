<?php 

//  ******this file is included in apporver and superadmin folder.****

$complaint = Complaint::find_by_id($approval_note->complaint_id);

if($complaint){


  if($complaint->emp_id == $session->employee_id && $complaint->approval_on_hold != 1 && $complaint->status != 'Closed'){
?>
<hr>
<form action="<?php echo "approval-note-file-db.php?id=".$_GET['id']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">


<div class="form-p-block">
<!-- box 1 -->
<div class="form-p-box form-p-box-bg2">

<div class="approval_note_doc">
  <h3>Approval note related documents</h3>
  <p class="colost2"><strong class="colost2">Upload file </strong><span class="sdcon">(.JPG, .XLSX, .PDF file format upto 25MB)</span></p>
    
  <?php 
   for ($i=1; $i < 6 ; $i++) {  
      $key_name = 'file_'.$i;
      $file_name = $approval_note->{$key_name} ;
   ?>
    <div class="row ">
      <div class="col-md-6 div_note_doc_<?php echo $i?>">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text clear_file" title="Clear File" data-target="note_doc_<?php echo $i?>">X</span>
          </div>
          <div class="custom-file">
            <input type="file" value="<?php echo $file_name;?>" name="note_doc_<?php echo $i?>" class="custom-file-input note_doc_<?php echo $i?>" id="note_doc_<?php echo $i?>"  accept="image/jpg, image/jpeg, application/pdf, application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
            <label class="custom-file-label" for="note_doc_<?php echo $i?>"><?php 
              echo ($file_name) ? $file_name : 'Upload File';        ?></label>

          </div>
        </div>
      </div>
      <div class="col-md-2 ">
          <input type="hidden" class="note_doc_<?php echo $i?>" value="<?php echo $file_name;?>" name="note_doc_<?php echo $i?>" >

          <?php 
            if(! empty($file_name)){
                echo '<a href="../document/'.$approval_note->ticket_no.'/note/'.$file_name.'" target="_blank"> View File</a>';
            }
          ?>
      </div>
      <div class="col-md-4 err_div">
      </div>
  </div>
  <?php  } ?>

</div>   


    <div class="row ">
      <div class="col-md-6">

           <ul class="rais-block-comsub">
            <li class="subtn03" style="margin: 15px auto;">
              <div class="form-group mb-0 text-center log-btn">
                <input type="submit" id="approval_note_file_btn" name="approval_note_file_btn" class="btn btn-danger btn-block" value="Submit" />
              </div>
            </li>
            <div class="clerfix"></div>
          </ul> 
      </div>
    </div>

  </div>
</div>



</form>

  <script type="text/javascript">

    $(document).ready(function(){

        $('input[type=file]').change(function(e){   
            var fileName = e.target.files[0].name;
            //console.log(e.target.files[0]);
            $(this).closest('div').find('label').html(fileName);
          }); 

        $(".clear_file").click(function (e) {
          $(this).closest('.row').find('.custom-file label').html('Upload File');
          $('.'+ $(this).data('target')).val('');
        });

    });
  </script>

<?php 
  } else{
      $note_doc_html = '';

      for ($i=1; $i <= 5 ; $i++) {  
        $key_name = 'file_'.$i;
        $file_name = $approval_note->{$key_name} ;
        if(! empty($file_name)){
            $note_doc_html .= '<p> <a href="../document/'.$approval_note->ticket_no.'/note/'.$file_name.'" target="_blank"> '.$file_name.'</a> </p>';
        }
      }

      if( $note_doc_html){ ?>
            <div class="form-p-box form-p-box-bg1">
                <div class="rst-full">
                    <ul class="fpall">
                        <p class="colrred_black"><strong>Attachments : </strong><?php echo $note_doc_html; ?></p>
                    </ul>
                </div>
             </div>
      <?php 
      }

  }

} //end if complaint found
?>

