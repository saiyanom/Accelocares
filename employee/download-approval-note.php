<?php 
  require_once("../includes/initialize.php"); 

  ob_start();
  // error_reporting(E_ALL);
  // ini_set('display_errors', 1);
  if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

  include("../common/approval-note-download.php"); 
?>