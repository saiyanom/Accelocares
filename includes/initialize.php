<?php

// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
/*defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : 
	define('SITE_ROOT', DS.'Users'.DS.'kevin'.DS.'Sites'.DS.'photo_gallery');

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');*/

// load config file first
require_once('config.php');
/*
ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  */

// load basic functions next so that everything after can use them
require_once('functions.php');

// load core objects
require_once('session.php');
require_once('database.php');
require_once('database_object.php');
require_once('pagination.php');

// load database-related classes
require_once('admin_panel.php');
require_once('complaint.php');
require_once('approval_note.php');
require_once('capa.php');
require_once('complaint_meeting.php');
require_once('company_reg.php');
require_once('employee_reg.php');
require_once('super_admin.php');
require_once('mill_reg.php');
require_once('department.php');
require_once('site_location.php');
require_once('employee_location.php');
require_once('product.php');
require_once('complaint_type.php');
require_once('sub_complaint_type.php');
require_once('complaint_escalation.php');
require_once('cvc_meeting.php');

require_once('customer_off_take.php');
require_once('customer_delivery_compliance.php');
require_once('approval_remark.php');


require_once('simpleimage.php');
?>

