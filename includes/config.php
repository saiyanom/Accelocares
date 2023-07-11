<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
// error_reporting(E_ALL);
// Database Constants

if($_SERVER['SERVER_NAME'] == 'localhost'){
	defined('DB_SERVER') ? null : define("DB_SERVER", "localhost");
	defined('DB_USER')   ? null : define("DB_USER", "root");
	defined('DB_PASS')   ? null : define("DB_PASS", "");
	defined('DB_NAME')   ? null : define("DB_NAME", "accelokonnect");

  defined('BASE_URL')   ? null : define("BASE_URL", "https://localhost/accelokonnect/crm/");

  define("SERVER_ENV", "staging");
}
else if( strpos($_SERVER['SERVER_NAME'], 'agency09.co') !== false){
	defined('DB_SERVER') ? null : define("DB_SERVER", "localhost");
	defined('DB_USER')   ? null : define("DB_USER", "agencyco_agency");
	defined('DB_PASS')   ? null : define("DB_PASS", "-SF1;E^8X?A[");
	defined('DB_NAME')   ? null : define("DB_NAME", "agencyco_accelokonnect");

  defined('BASE_URL')   ? null : define("BASE_URL", "https://www.agency09.co/staging/accelokonnect/crm/");
  define("SERVER_ENV", "staging");
}
else{
	defined('DB_SERVER') ? null : define("DB_SERVER", "localhost");
	defined('DB_USER')   ? null : define("DB_USER", "root");
	defined('DB_PASS')   ? null : define("DB_PASS", "pass,123");
	defined('DB_NAME')   ? null : define("DB_NAME", "mahindra_accelo");

  defined('BASE_URL')   ? null : define("BASE_URL", "https://www.accelocares.com/");
  define("SERVER_ENV", "live");
}


?>