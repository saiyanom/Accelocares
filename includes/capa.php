<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('config.php');
require_once('database.php');
require_once('session.php');


class Capa extends DatabaseObject {
	
	protected static $table_name="capa";
	protected static $db_fields = array('id', 'complaint_id', 'customer_id', 'company_name', 'ticket_no', 'document_no', 'rev_no', 'page_no', 'customer_name', 'capa_no', 
	'model', 'reported_by', 'date_issue', 'problem_desc', 'team_member', 'feedback_date', 'reviewed_by', 'reviewed_date',  'contact_person_name', 
	'problem_where', 'problem_when', 'problem_what_qty', 'problem_which_model', 'problem_who_produced', 'finding_invest_remark', 'structured_remark', 'root_cause_remark', 'correction_remark', 
	'correction_who', 'correction_when', 'corrective_remark', 'corrective_who', 'corrective_when', 'verify_remark', 'verify_who', 'verify_when', 'prevent_remark', 'prevent_who', 'prevent_when', 'date_', 'time_');
	
	public $id;
	public $complaint_id;
	public $customer_id;
	public $company_name;
	public $ticket_no;
	public $document_no;
	public $rev_no;
	public $page_no;
	public $customer_name;
	public $capa_no;
	public $model;
	public $reported_by;	
	public $date_issue;
	public $problem_desc;
	public $team_member;
	public $feedback_date;
	public $reviewed_by;
	public $reviewed_date;
	public $contact_person_name;
	public $problem_where;
	public $problem_when;
	public $problem_what_qty;
	public $problem_which_model;
	public $problem_who_produced;
	public $finding_invest_remark;
	public $structured_remark;
	public $root_cause_remark;
	public $correction_remark;
	public $correction_who;
	public $correction_when;
	public $corrective_remark;
	public $corrective_who;
	public $corrective_when;
	public $verify_remark;
	public $verify_who;
	public $verify_when;
	public $prevent_remark;
	public $prevent_who;
	public $prevent_when;	
	public $date_;
	public $time_;
	
	
	public static function authenticate($username="", $password="") {
		global $database;
		$username = $database->escape_value($username);
		$password = $database->escape_value($password);
	
		$sql  = "SELECT * FROM ".self::$table_name;
		$sql .= " WHERE username = '{$username}' ";
		$sql .= "AND password = '{$password}' ";
		$sql .= "LIMIT 1";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function email_authenticate($email) {
		global $database;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name." where email = '{$email}'";
	  	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
      	return array_shift($row);
	}
	
	public static function authenticate_mobile($mobile) {
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE mobile='{$mobile}' LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	// Common Database Methods
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name."  order by id DESC");
  	}
	  
	public static function find_by_id($id=0) {
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function find_by_comp_id($complaint_id=0) {
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE complaint_id='{$complaint_id}' LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
  
  	public static function find_by_last_id() {
		$result_array = self::find_by_sql("SELECT id, capa_no  FROM ".self::$table_name." Order by id DESC LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  	}
    
  	public static function find_by_sql($sql="") {
		global $database;
		$result_set = $database->query($sql);
		$object_array = array();
		while ($row = $database->fetch_array($result_set)) {
		  $object_array[] = self::instantiate($row);
		}
		return $object_array;
  	}
	
	public static function count_by_bpid($id) {
	  	global $database;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name." Where bp_code = '{$id}' ";
    	$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
    	return array_shift($row);
	}
	
	public static function count_all() {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." ";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	
	public static function count_status($status) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE status = '".$status."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	

	private static function instantiate($record) {
		// Could check that $record exists and is an array
    $object = new self;
		// Simple, long-form approach:
		// $object->id 				= $record['id'];
		// $object->username 	= $record['username'];
		// $object->password 	= $record['password'];
		// $object->first_name = $record['first_name'];
		// $object->last_name 	= $record['last_name'];
		
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 
		// return an array of attribute names and their values
	  $attributes = array();
	  foreach(self::$db_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
	
	protected function sanitized_attributes() {
	  global $database;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $database->escape_value($value);
	  }
	  return $clean_attributes;
	}
	
	public function save() {
	  // A new record won't have an id yet.
	  return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function create() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  if($database->query($sql)) {
	    $this->id = $database->insert_id();
	    return true;
	  } else {
	    return false;
	  }
	}

	public function update() {
	  global $database;
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

	public function delete() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
	  $sql = "DELETE FROM ".self::$table_name." ";
	  $sql .= " WHERE id=". $database->escape_value($this->id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	
		// NB: After deleting, the instance of User still 
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update() 
		// after calling $user->delete().
	}

}

?>