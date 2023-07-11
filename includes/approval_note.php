<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('config.php');
require_once('database.php');
require_once('session.php');


class ApprovalNote extends DatabaseObject {
	
	protected static $table_name="approval_note";
	protected static $db_fields = array('id', 'complaint_id', 'customer_id', 'company_name', 'ticket_no', 'customer_name', 'nature_of_complaint', 'complait_reference', 'name_of_sm_sc_t', 'complait_reg_date', 
	'responsibility', 'material_details', 'billing_doc_no', 'total_qty_rejc', 'billing_doc_date','basic_sale_price_txt', 'basic_sale_price', 'sales_value', 'cgst_percent',  'cgst', 'sgst_percent',  'sgst', 'cost_inc_customer_txt',
	'cost_inc_customer', 'salvage_value_txt', 'salvage_value', 'credit_note_iss_cust', 'debit_note_supplier', 'qty_acpt_steel_mill', 'qty_scrp_auc_serv_cent', 'qty_dlv_customer', 'debit_salvage_sale_txt', 'debit_note_sal_rate_sale_value', 'value', 
	'lcgst_percent', 'loss_cgst', 'lsgst_percent', 'loss_sgst', 'other_exp_inc_mill_txt', 'oth_exp_inc_mill', 'oth_exp_debited', 'compensation_exp', 'debit_note_iss_supplier', 'loss_from_rejection', 'recoverable_transporter', 'other_realisation', 'net_loss', 'remark','approver_remark','on_hold','on_hold_date','on_hold_by','on_hold_remark', 'creator_id', 'creator_name', 'd_purchase_price','d_salvage_rate','d_sale_value', 'file_1','file_2','file_3','file_4','file_5', 'date_', 'time_');
	
	public $id;
	public $complaint_id;
	public $customer_id;
	public $company_name;
	public $ticket_no;
	public $customer_name;
	public $nature_of_complaint;
	public $complait_reference;
	public $name_of_sm_sc_t;
	public $complait_reg_date;
	public $responsibility;
	public $material_details;
	public $billing_doc_no;
	public $total_qty_rejc;
	public $billing_doc_date;
	public $basic_sale_price_txt;
	public $basic_sale_price;
	public $sales_value;
	public $cgst_percent;
	public $cgst;
	public $sgst_percent;
	public $sgst;
	public $cost_inc_customer_txt;
	public $cost_inc_customer;
	public $salvage_value_txt;
	public $salvage_value;
	public $credit_note_iss_cust;
	public $debit_note_supplier;
	public $qty_acpt_steel_mill;
	public $qty_scrp_auc_serv_cent;
	public $qty_dlv_customer;
	public $debit_salvage_sale_txt;
	public $debit_note_sal_rate_sale_value;
	public $value;
	public $lcgst_percent;
	public $loss_cgst;
	public $lsgst_percent;
	public $loss_sgst;
	public $other_exp_inc_mill_txt;
	public $oth_exp_inc_mill;
	public $oth_exp_debited;
	public $compensation_exp;
	public $debit_note_iss_supplier;
	public $loss_from_rejection;
	public $recoverable_transporter;
	public $net_loss;
	public $remark;
	public $approver_remark;
	
  public $on_hold;
  public $on_hold_date;
  public $on_hold_by;
  public $on_hold_remark;

  public $creator_id;
  public $creator_name; 

  public $d_purchase_price;
  public $d_salvage_rate;
  public $d_sale_value;

  public $file_1;
  public $file_2;
  public $file_3;
  public $file_4;
  public $file_5;

  public $other_realisation;

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

  public static function get_active_approval_note_by_comp_id($complaint_id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE complaint_id='{$complaint_id}' AND on_hold = 0 ORDER BY id desc LIMIT 1");
    return !empty($result_array) ? array_shift($result_array) : false;
  }
	
  public static function note_exist($complaint_id=0) {
    global $database;
    $sql = "SELECT COUNT(id) FROM ".self::$table_name." Where complaint_id = '{$complaint_id}' ";
    $result_set = $database->query($sql);
    $row = $database->fetch_array($result_set);
    return array_shift($row);
  }
  
	public static function find_by_last_id() {
		$result_array = self::find_by_sql("SELECT id  FROM ".self::$table_name." Order by id DESC LIMIT 1");
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