<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('config.php');
require_once('database.php');
require_once('session.php');


class Complaint extends DatabaseObject {
	
	protected static $table_name="complaint";
	protected static $db_fields = array('id', 'emp_id', 'emp_name', 'customer_id', 'company_name', 'ticket_no', 'product', 'product_img_1', 'product_img_2', 'product_img_3', 'product_img_4', 
										'plant_location', 'business_vertical', 'complaint_type', 'sub_complaint_type', 'rejected_quantity', 'invoice_number', 'invoice_date', 
										'defect_batch_no', 'pl_name', 'pl_email', 'pl_mobile', 'pl_feedback', 'identify_source', 'mill', 'other_source', 'client_contacted', 'identify_source_remark', 'identify_source_date','identify_source_time', 
										'request_visit', 'request_remark', 'visit_done', 'visit_remark', 'request_visit_date', 'request_visit_time', 'mom_document', 'mom_written', 'plant_img_1', 'plant_img_2', 'plant_img_3', 'plant_img_4', 'plant_img_5', 'product_status', 
										'product_status_specify', 'visit_done_date', 'visit_done_time', 'complaint_accepted', 'complaint_remark', 'other_advice', 'action_by_name', 'action_by_date', 'visit_done_date', 'visit_done_time', 'create_approval_note',
										'approval_note', 'approval_on_hold', 'approval_action_taken', 'approval_action_taken_specify', 'approval_note_date', 'approval_note_time', 'cna_crm_head', 'cna_crm_head_name', 'cna_crm_head_date', 'cna_commercial_head', 'cna_commercial_head_name', 
										'cna_commercial_head_date', 'cna_plant_chief', 'cna_plant_chief_name', 'cna_plant_chief_date', 'cna_sales_head', 'cna_sales_head_name', 'cna_sales_head_date', 'cna_cfo', 'cna_cfo_name', 'cna_cfo_date', 
										'cna_md_status', 'cna_md', 'cna_md_name', 'cna_md_date', 'settlement', 'settlement_date', 'reject_invoice_no', 'reject_final_qty', 'comm_amount', 'settlement_credit_note_no', 'credit_note_date', 'credit_note_time', 'create_capa_doc',
										'capa', 'capa_document', 'capa_qa', 'capa_qa_name', 'capa_ph', 'capa_ph_name', 'capa_pc', 'capa_pc_name', 'capa_mr', 'capa_mr_name', 'capa_sent_customer_date', 'complaint_analysis', 'comp_closed_date', 'size', 'cust_status', 'emp_status', 'status', 'date_', 'time_');
	
	public $id;
	public $emp_id;
	public $emp_name;
	public $customer_id;
	public $company_name;
	public $ticket_no;
	public $product;
	public $product_img_1;
	public $product_img_2;
	public $product_img_3;
	public $product_img_4;
	public $plant_location;
	public $business_vertical;
	public $complaint_type;
	public $sub_complaint_type;
	public $rejected_quantity;
	public $invoice_number;
	public $invoice_date;
	public $defect_batch_no;
	public $pl_name;
	public $pl_email;
	public $pl_mobile;
	public $pl_feedback;
	public $identify_source;
	public $mill;
  public $other_source;
	public $client_contacted;
	public $identify_source_remark;
	public $identify_source_date;
	public $identify_source_time;
	
	public $request_visit;	
	public $request_remark;
	public $request_visit_date;
	public $request_visit_time;

	public $visit_done;	
	public $visit_remark;	
	public $mom_document;
	public $mom_written;
	public $plant_img_1;
	public $plant_img_2;
	public $plant_img_3;
	public $plant_img_4;
	public $plant_img_5;
	public $product_status;
	public $product_status_specify;
	public $complaint_accepted;
	public $complaint_remark;
	public $other_advice;
	public $action_by_name;
	public $action_by_date;
	public $visit_done_date;
	public $visit_done_time;
	
	public $create_approval_note;
	public $approval_note;
	public $approval_action_taken;
	public $approval_action_taken_specify;
	public $approval_note_date;
	public $approval_note_time;
	
	public $cna_crm_head;
	public $cna_crm_head_name;
	public $cna_crm_head_date;
	public $cna_commercial_head;
	public $cna_commercial_head_name;
	public $cna_commercial_head_date;
	public $cna_plant_chief;
	public $cna_plant_chief_name;
	public $cna_plant_chief_date;
	public $cna_sales_head;
	public $cna_sales_head_name;
	public $cna_sales_head_date;
	public $cna_cfo;
	public $cna_cfo_name;
	public $cna_cfo_date;
	public $cna_md_status;
	public $cna_md;
	public $cna_md_name;
	public $cna_md_date;
	public $settlement;
	public $settlement_date;
	public $reject_invoice_no;
	public $reject_final_qty;
	public $comm_amount;
	public $settlement_credit_note_no;
	public $credit_note_date;
	public $credit_note_time;
	
	public $create_capa_doc;
	public $capa;
	public $capa_document;
	public $capa_qa;
	public $capa_qa_name;
	public $capa_ph;
	public $capa_ph_name;
	public $capa_pc;
	public $capa_pc_name;
	public $capa_mr;
	public $capa_mr_name;
	public $capa_sent_customer_date;
	public $complaint_analysis;
	public $comp_closed_date;

  public $size;

  public $approval_on_hold;

	public $cust_status;
	public $emp_status;
	public $status;
	public $date_;
	public $time_;
	
	
	
	// Common Database Methods
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." order by id DESC");
  	}
	  
	public static function find_by_id($id=0) {
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	public static function find_by_last_id() {
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." Order by id DESC LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	public static function find_by_last_ticket_no() {
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." Order by ticket_no DESC LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
  	
	public static function find_by_cust_id($id) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE customer_id='{$id}'");
  	}
	
	
	public static function authenticate_ticket($ticket_no) {
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE ticket_no='{$ticket_no}' LIMIT 1");
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

	public static function count_by_customer_id($id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." Where customer_id = '{$id}'  ";
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
	
	public static function count_status_date($from_date, $to_date, $status) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE status = '".$status."' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date . "'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_emp_status($status) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE emp_status = '".$status."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
		
	public static function count_cust_status($status) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE cust_status = '".$status."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	
	public static function count_complaint_analysis_date($from_date, $to_date, $analysis) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE complaint_analysis = '".$analysis."' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date . "'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_complaint_analysis($analysis) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE complaint_analysis = '".$analysis. "'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_complaint_type($complaint_type) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE complaint_type = '".$complaint_type."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	
	public static function count_business_vertical($status) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE business_vertical = '".$status."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	
	public static function count_identify_source($source) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE identify_source = '".$source."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_by_complaint_verticle($verticle) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE business_vertical = '".$verticle."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_by_complaint_verticle_date($from_date, $to_date, $verticle, $status) {
	  global $database;
		if(empty($status)){
			$sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE business_vertical = '".$verticle."' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date. "'";
		} else {
			$sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE business_vertical = '".$verticle."' AND status = '" . $status. "' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date. "'";		
		}
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_by_company_reg($company_name) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE company_name = '".$company_name."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_by_company_reg_date($from_date, $to_date, $company_name) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE company_name = '".$company_name."' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date . "'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_by_complaint_type($complaint_type) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE complaint_type = '".$complaint_type."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_by_complaint_type_date($from_date, $to_date, $complaint_type) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE complaint_type = '".$complaint_type."' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date . "'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_by_plant_location($location) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE plant_location = '".$location."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_by_plant_location_date($from_date, $to_date, $location) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE plant_location = '".$location."' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date . "'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_by_mill($mill_name) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE mill = '".$mill_name."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_by_mill_date($from_date, $to_date, $mill_name) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE mill = '".$mill_name."' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date . "'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_identify_source_date($from_date, $to_date, $source) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE identify_source = '".$source."' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date . "'
";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
//  ---- Code For Employee Start -------------------------------------------------------------------------------
	
	public static function count_emp_complaint_type($complaint_type, $emp_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE complaint_type = '".$complaint_type."' AND emp_id = '{$emp_id}' ";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	
	public static function count_by_customer_id_emp($id, $emp_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." Where emp_id = '{$emp_id}' AND customer_id = '{$id}' ";
    $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	
	public static function count_all_emp($emp_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." Where emp_id = '{$emp_id}' ";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	
	public static function count_status_emp($status,$emp_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE emp_id = '{$emp_id}' AND status = '".$status."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	
	public static function count_emp_status_emp($status,$emp_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE emp_id = '{$emp_id}' AND emp_status = '".$status."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	
	public static function count_cust_status_emp($status,$emp_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE emp_id = '{$emp_id}' AND cust_status = '".$status."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	
	public static function count_business_vertical_emp($status,$emp_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE emp_id = '{$emp_id}' AND business_vertical = '".$status."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	
	public static function count_by_company_reg_emp($company_name,$emp_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE emp_id = '{$emp_id}' AND company_name = '".$company_name."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_by_company_reg_emp_date($from_date, $to_date, $company_name,$emp_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE emp_id = '{$emp_id}' AND company_name = '".$company_name."' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date . "'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_by_complaint_type_emp($complaint_type,$emp_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE emp_id = '{$emp_id}' AND complaint_type = '".$complaint_type."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_by_complaint_type_emp_date($from_date, $to_date, $complaint_type,$emp_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE emp_id = '{$emp_id}' AND complaint_type = '".$complaint_type."' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date . "'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_by_complaint_verticle_emp($verticle,$emp_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE emp_id = '{$emp_id}' AND business_vertical = '".$verticle."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_by_complaint_verticle_emp_date($from_date, $to_date, $verticle, $status,$emp_id) {
	  global $database;
		if(empty($status)){
			$sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE emp_id = '{$emp_id}' AND business_vertical = '".$verticle."' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date. "'";
		} else {
			$sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE emp_id = '{$emp_id}' AND business_vertical = '".$verticle."' AND status = '" . $status. "' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date. "'";		
		}
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_by_mill_emp($mill_name,$emp_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE emp_id = '{$emp_id}' AND mill = '".$mill_name."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_by_mill_emp_date($from_date, $to_date, $mill_name,$emp_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE emp_id = '{$emp_id}' AND mill = '".$mill_name."' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date . "'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_identify_source_emp($source,$emp_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE emp_id = '{$emp_id}' AND identify_source = '".$source."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
	public static function count_identify_source_emp_date($from_date, $to_date, $source,$emp_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE emp_id = '{$emp_id}' AND identify_source = '".$source."' AND date_ BETWEEN '" . $from_date . "' AND  '" . $to_date . "'
";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
//  ---- Code For Employee End -------------------------------------------------------------------------------

	

//  ---- Code For Customer Start -------------------------------------------------------------------------------
	
	public static function count_all_cust($cust_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." Where customer_id = '{$cust_id}' ";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	
	public static function count_status_cust($status,$cust_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE customer_id = '{$cust_id}' AND status = '".$status."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	
	public static function count_emp_status_cust($status,$cust_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE customer_id = '{$cust_id}' AND emp_status = '".$status."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	
	public static function count_cust_status_cust($status,$cust_id) {
		global $database;
		$sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE customer_id = '{$cust_id}' AND cust_status = '".$status."' AND status = 'Open'";
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
	
	public static function count_business_vertical_cust($status,$cust_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE customer_id = '{$cust_id}' AND business_vertical = '".$status."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	
	public static function count_identify_source_cust($source,$cust_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE customer_id = '{$cust_id}' AND identify_source = '".$source."'";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}
	
//  ---- Code For Customer End -------------------------------------------------------------------------------
	
	
	
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