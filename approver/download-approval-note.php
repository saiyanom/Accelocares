<?php ob_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  require_once("../includes/initialize.php"); 
  if (!$session->is_employee_logged_in()) { redirect_to("logout.php"); }

  include_once("../common/approval-note-download.php"); 
?>