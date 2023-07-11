<?php ob_start();
 //ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once("../includes/initialize.php"); 


if (!$session->is_super_admin_logged_in()) { redirect_to("logout.php"); }

  
  include_once("../common/approval-note-download.php"); 
?>