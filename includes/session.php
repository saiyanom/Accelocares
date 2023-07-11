<?php
// A class to help work with Sessions
// In our case, primarily to manage logging users in and out

// Keep in mind when working with sessions that it is generally 
// inadvisable to store DB-related objects in sessions

class Session {
	
	private $customer_logged_in=false;
	public $customer_id;
	
	private $employee_logged_in=false;
	public $employee_id;
	
	private $super_admin_logged_in=false;
	public $super_admin_id;
	
	public $message;
	
	function __construct() {
		session_start();
		$this->check_message();
		$this->check_customer_login();
		$this->check_employee_login();
		$this->check_super_admin_login();

		if($this->customer_logged_in) {
		  // actions to take right away if user is logged in
		} else {
		  // actions to take right away if user is not logged in
		}
	}
	
	public function is_customer_logged_in() {
		return $this->customer_logged_in;
	}
	public function is_employee_logged_in() {
		return $this->employee_logged_in;
	}
	public function is_super_admin_logged_in() {
		return $this->super_admin_logged_in;
	}

	public function customer_login($user) {
		// database should find user based on username/password
		if($user){
			$this->customer_id = $_SESSION['customer_id'] = $user->id;
			$this->customer_logged_in = true;
		}
	}
  
 	public function employee_login($user) {
		// database should find user based on username/password
		if($user){
			$this->employee_id 			= $_SESSION['employee_id'] = $user->id;
			$this->employee_logged_in 	= true;
		}
	}
	
	public function super_admin_login($user) {
		// database should find user based on username/password
		if($user){
			$this->super_admin_id = $_SESSION['super_admin_id'] = $user->id;
			$this->super_admin_logged_in = true;
		}
	}
  
	
	public function customer_logout() {
		unset($_SESSION['customer_id']);
		unset($this->customer_id);
		$this->customer_logged_in = false;
	}
	
	public function employee_logout() {
		unset($_SESSION['employee_id']);
		unset($this->employee_id);
		$this->employee_logged_in = false;
	}
	
	public function super_admin_logout() {
		unset($_SESSION['super_admin_id']);
		unset($this->super_admin_id);
		$this->super_admin_logged_in = false;
	}

	public function message($msg="") {
	  if(!empty($msg)) {
	    // then this is "set message"
	    // make sure you understand why $this->message=$msg wouldn't work
	    $_SESSION['message'] = $msg;
	  } else {
	    // then this is "get message"
			return $this->message;
	  }
	}

  
	private function check_customer_login() {
		if(isset($_SESSION['customer_id'])) {
			$this->customer_id = $_SESSION['customer_id'];
			$this->customer_logged_in = true;
		} else {
			unset($this->customer_id);
			$this->customer_logged_in = false;
		}
	}
	
	private function check_employee_login() {
		if(isset($_SESSION['employee_id'])) {
			$this->employee_id = $_SESSION['employee_id'];
			$this->employee_logged_in = true;
		} else {
			unset($this->employee_id);
			$this->employee_logged_in = false;
		}
	}
	
	private function check_super_admin_login() {
		if(isset($_SESSION['super_admin_id'])) {
			$this->super_admin_id = $_SESSION['super_admin_id'];
			$this->super_admin_logged_in = true;
		} else {
			unset($this->super_admin_id);
			$this->super_admin_logged_in = false;
		}
	}
	
  
	private function check_message() {
		// Is there a message stored in the session?
		if(isset($_SESSION['message'])) {
			// Add it as an attribute and erase the stored version
			$this->message = $_SESSION['message'];
			unset($_SESSION['message']);
		} else {
			$this->message = "";
		}
	}
	
}

$session = new Session();
$message = $session->message();

?>