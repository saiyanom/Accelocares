<?php
ob_start();
require_once("../includes/initialize.php");
if (!$session->is_employee_logged_in()) {
    redirect_to("logout.php");
}

foreach ($_POST as $key => $value) {
    //if (preg_match('/[\'"\^*()}!{><;`=]/', $value)){
    if (preg_match('/[\"\^*}!{><;`=]/', $value)) {
        $session->message("Remove Special Character from Employee CVC");
        redirect_to("approval.php");
    }
}
foreach ($_GET as $key => $value) {
    if (preg_match('/[\"\^*}!{><;`=]/', $value)) {
        $session->message("Remove Special Character from Employee CVC");
        redirect_to("approval.php");
    }
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    if (!is_numeric($_GET['id'])) {
        $session->message("Invalid Document.");
        redirect_to("approval.php");
    }
    if (strlen($_GET['id']) < 1) {
        $session->message("Invalid Document.");
        redirect_to("approval.php");
    }
} else {
    $session->message("Complaint Not Found");
    redirect_to("all-complaints.php");
}

$employee_reg = EmployeeReg::find_by_id($session->employee_id);
if (!$session->is_employee_logged_in()) {
    redirect_to("logout.php");
}
if ($session->is_employee_logged_in()) {

    $emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != 'Employee' Limit 1";

    $employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);

    if (!$employee_location) {
        redirect_to("logout.php");
    }
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $approval_note = ApprovalNote::find_by_id($_GET['id']);
    $complaint_reg = Complaint::find_by_id($approval_note->complaint_id);
} else {
    $session->message("Complaint Not Found");
    redirect_to("all-complaints.php");
}

//get product id of complaint i.e CR/auto/kanhe
$product_id = Product::find_product_id($complaint_reg->business_vertical, $complaint_reg->plant_location, $complaint_reg->product);
if(! $product_id){
    $session->message('Product Not Found');
    redirect_to("approval.php"); 
}

//get employee location for that product id
$emp_loc_sql = "Select * from employee_location where emp_id = {$employee_reg->id} AND emp_sub_role != 'Employee' AND product_id = {$product_id->id} ";

$employee_location = EmployeeLocation::find_by_sql($emp_loc_sql);

if(!$employee_location){
  $session->message('Location data Not Found');
  redirect_to("approval.php"); 
}

$emp_sub_role_appr = '';
// $emp_sub_role_appr = $employee_location[0]->emp_sub_role;

$valid_roles = ["CRM - Head", "Commercial Head", "Plant Chief - AN", "Sales Head", "CFO", "MD"];
foreach ($employee_location as $key => $value) {
    if( in_array($value->emp_sub_role, $valid_roles) ){
        $emp_sub_role_appr = $value->emp_sub_role;
        break;
    }
}
// echo $emp_sub_role_appr;
/*$sql = "Select * from employee_location where emp_id = {$session->employee_id} AND emp_sub_role != 'Employee' ";
$employee_loc = EmployeeLocation::find_by_sql($sql);
foreach ($employee_loc as $employee_loc) {
    if ($employee_loc->emp_sub_role == "CRM - Head" || $employee_loc->emp_sub_role == "Commercial Head" || $employee_loc->emp_sub_role == "Plant Chief - AN" || $employee_loc->emp_sub_role == "Sales Head"  || $employee_loc->emp_sub_role == "CFO" || $employee_loc->emp_sub_role == "MD") {
        $emp_sub_role_appr = $employee_loc->emp_sub_role;
    }
}*/

// $employee_loc = EmployeeLocation::find_by_emp_id($session->employee_id);
if ($emp_sub_role_appr == "CRM - Head") {
    $readonly = "";
    $disabled = "";
} else {
    $readonly = "readonly";
    $disabled = "disabled";
}


?>



<style>
    .form-p-box-bg3:disabled,
    .form-control[readonly] {
        background-color: #7c7c7c;
        opacity: 1;
        color: #fff;
    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #e9ecef;
        opacity: 1;
        color: #666;
    }

    .form-p-box-bg3 {
        background-color: #7c7c7c !important;
        opacity: 1;
        color: #fff;
    }

    .app_note_number {
        text-align: right;
    }

    .fp-con01 {
        width: 70%;
    }

    .fp-con01 p {
        margin-top: 0;
        margin-bottom: 0;
        padding: 6px 0 0 0;
    }

    .fp-con02 {
        width: 28.54%;
    }

    .sphf {
        width: 73%;
    }

    .app_note_number {
        text-align: right;
    }

    .form-p-box-bg3 {
        background-color: #7c7c7c !important;
        color: #fff !important;
    }

    .optional_field {
        width: 300px;
        display: inline-block;
    }

    .err_msg {
        color: #f00;
    }
    .debit_inputs div{
      width: 200px;
      display: inline-block;
    }
</style>

<div class="modal-header border-bottom-st d-block">
    <button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>
    <div class="form-p-hd">
        <h2>MAHINDRA ACCELO LTD. / MASL / MSSCL<br>
            Credit Note / Debit Note Approval</h2>
    </div>


    <div class="form-p-block" id="create-note">
        <form action="<?php echo "approve-approval-note-db.php?id=" . $approval_note->complaint_id; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <!-- box 1 -->
            <div class="form-p-box form-p-box-bg2">

                <div class="rst-left">
                    <ul class="fpall">
                        <li class="fp-con1">
                            <p>Name of the customer</p>
                        </li>
                        <li class="fp-con2"><input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->customer_name; ?>" name="customer_name" class="form-control form-p-box-bg1"></li>
                        <div class="clerfix"></div>
                    </ul>

                    <ul class="fpall">
                        <li class="fp-con1">
                            <p>Complaint reference no</p>
                        </li>
                        <li class="fp-con2"><input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->complait_reference; ?>" name="complait_reference" class="form-control form-p-box-bg1"></li>
                        <div class="clerfix"></div>
                    </ul>

                    <ul class="fpall">
                        <li class="fp-con1"><p>Plant</p></li>             
                        <li class="fp-con2"><input readonly type="text" value="<?php echo $complaint_reg->product." | ".$complaint_reg->business_vertical." | ".$complaint_reg->plant_location; ?>" class="form-control form-p-box-bg1"></li>
                        <div class="clerfix"></div>
                      </ul>

                    <ul class="fpall">
                        <li class="fp-con1">
                            <p>Complant Registration date</p>
                        </li>
                        <li class="fp-con2">
                            <input <?php echo $readonly; ?> value="<?php echo date('d-m-Y', strtotime($approval_note->complait_reg_date)); ?>" class="form-control" id="complait_reg_date" type="text" name="complait_reg_date">
                        </li>
                        <div class="clerfix"></div>
                    </ul>

                    <ul class="fpall">
                        <li class="fp-con1">
                            <p>Material Details (grade, size etc)</p>
                        </li>
                        <li class="fp-con2"><input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->material_details; ?>" name="material_details" class="form-control form-p-box-bg1"></li>
                        <div class="clerfix"></div>
                    </ul>
                </div>

                <div class="rst-right">
                    <ul class="fpall">
                        <li class="fp-con1">
                            <p>Nature of the complaint</p>
                        </li>
                        <li class="fp-con2">
                            <textarea <?php echo $readonly; ?> id="nature_of_complaint" name="nature_of_complaint" class="form-control mrig10 form-p-box-bg1"><?php echo $approval_note->nature_of_complaint; ?></textarea>
                        </li>
                        <div class="clerfix"></div>
                    </ul>

                    <ul class="fpall">
                        <li class="fp-con1">
                            <p>Name of the Steel Mill / Service centre/ Transporter</p>
                        </li>
                        <li class="fp-con2"><input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->name_of_sm_sc_t; ?>" name="name_of_sm_sc_t" class="form-control form-p-box-bg1"></li>
                        <div class="clerfix"></div>
                    </ul>

                    <ul class="fpall">
                        <li class="fp-con1">
                            <p>Responsibility</p>
                        </li>
                        <li class="fp-con2"><input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->responsibility; ?>" name="responsibility" class="form-control form-p-box-bg1"></li>
                        <div class="clerfix"></div>
                    </ul>
                </div>

                <div class="clerfix"></div>
            </div>
            <!-- box 1 -->

            <!-- box 2 -->
            <div class="form-p-box form-p-box-bg1 border-bottom-st">
                <h2 class="sectphd">Credit note to be issued to customer</h2>
                <div class="rst-left">
                    <ul class="fpall">
                        <li class="fp-con1">
                            <p>Billing Document No.</p>
                        </li>
                        <li class="fp-con2"><input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->billing_doc_no; ?>" name="billing_doc_no" class="form-control form-p-box-bg2"></li>
                        <div class="clerfix"></div>
                    </ul>

                    <ul class="fpall">
                        <li class="fp-con1">
                            <p>Billing Document Date</p>
                        </li>
                        <li class="fp-con2">
                            <input <?php echo $readonly; ?> style="width: 100%;" id="billing_doc_date" value="<?php echo $approval_note->billing_doc_date;  ?>" type="date" name="billing_doc_date" class="form-control fodhf date" data-provide1="datepicker" data-toggle1="date-picker" data-single-date-picker1="true">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                </div>

                <div class="rst-right">
                    <ul class="fpall">
                        <li class="fp-con1">
                            <p>Total Qty Rejected by the Customer</p>
                        </li>
                        <li class="fp-con2"><input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->total_qty_rejc; ?>" id="total_qty_rejc" name="total_qty_rejc" class="form-control form-p-box-bg2 app_note_number"></li>
                        <div class="clerfix"></div>
                    </ul>
                </div>

                <div class="clerfix"></div>
            </div>
            <!-- box 2 -->

            <!-- box 3 -->
            <div class="form-p-box form-p-box-bg1">

                <div class="rst-full">
                    <ul class="fpall">
                        <li class="fp-con01">
                            <p>Basic sale price <input name="basic_sale_price_txt" <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->basic_sale_price_txt; ?>" class="form-control optional_field"></p>
                        </li>
                        <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->basic_sale_price; ?>" id="basic_sale_price" name="basic_sale_price" class="form-control form-p-box-bg2 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <p>Sales Value (Basic sale price/t X Qty) <span style="float: right;">(a)</span></p>
                        </li>
                        <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->sales_value; ?>" id="sales_value" name="sales_value" class="form-control form-p-box-bg2 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <div class="input-group" style="width: 250px">
                                <div class="input-group-append">
                                    <span class="input-group-text">CGST @</span>
                                </div>
                                <input type="number" min="0"  step="any" name="cgst_percent" class="form-control cgst" value="<?php 
                                    if(!empty($approval_note->cgst_percent)){
                                        echo $approval_note->cgst_percent;
                                    }else {
                                        $cgst_percent =  100 / ($approval_note->sales_value/$approval_note->cgst);
                                        echo round($cgst_percent,2);
                                    }
                                ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </li>
                        <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->cgst; ?>" id="cgst" name="cgst" class="form-control form-p-box-bg2 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <div class="input-group" style="width: 250px">
                                <div class="input-group-append">
                                    <span class="input-group-text">SGST @</span>
                                </div>
                                <input type="number"  step="any"  min="0" name="sgst_percent"  class="form-control sgst" value="<?php 
                                    if(!empty($approval_note->sgst_percent)){
                                        echo $approval_note->sgst_percent;
                                    }else {
                                        $sgst_percent = 100 / ($approval_note->sales_value/$approval_note->sgst);
                                        echo round($sgst_percent,1);
                                    }
                                ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </li>
                        <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->sgst; ?>" id="sgst" name="sgst" class="form-control form-p-box-bg2 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <p>Cost incurred by the customer, <input <?php echo $readonly; ?> type="text" name="cost_inc_customer_txt" value="<?php echo $approval_note->cost_inc_customer_txt; ?>" class="form-control optional_field"></p>
                        </li>
                        <li class="fp-con02"><span class="padd10">(+) &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->cost_inc_customer; ?>" id="cost_inc_customer" name="cost_inc_customer" class="form-control form-p-box-bg2 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <p>Salvage value <input <?php echo $readonly; ?> name="salvage_value_txt" type="text" value="<?php echo $approval_note->salvage_value_txt; ?>" class="form-control optional_field"></p>
                        </li>
                        <li class="fp-con02"><span class="padd10">(-) &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->salvage_value; ?>" id="salvage_value" name="salvage_value" class="form-control form-p-box-bg2 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <p class="colrred">Credit note to be issued to the customer (total of abv net of scrap value)</p>
                        </li>
                        <li class="fp-con02"><span class="padd10 colrred">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->credit_note_iss_cust; ?>" id="credit_note_iss_cust" name="credit_note_iss_cust" class="form-control form-p-box-bg3 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                </div>

                <div class="clerfix"></div>
            </div>
            <!-- box 3 -->

            <!-- box 4 -->
            <div class="form-p-box form-p-box-bg2">

                <div class="rst-full">
                    <h2 class="sectphd">Debit Note Issued to Supplier / Realisation from Scrap / To be Recovered from Insurance Co.</h2>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <p>Quantity (t) as Accepted by Steel Mill</p>
                        </li>
                        <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp;</span>
                            <input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->qty_acpt_steel_mill; ?>" id="qty_acpt_steel_mill" name="qty_acpt_steel_mill" class="form-control form-p-box-bg1 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <p>Quantity (t) to be scrapped / auction at service centres </p>
                        </li>
                        <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp;</span>
                            <input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->qty_scrp_auc_serv_cent; ?>" id="qty_scrp_auc_serv_cent" name="qty_scrp_auc_serv_cent" class="form-control form-p-box-bg1 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <p>Quantity (t) to be diverted to any other customer</p>
                        </li>
                        <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp;</span>
                            <input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->qty_dlv_customer; ?>" id="qty_dlv_customer" name="qty_dlv_customer" class="form-control form-p-box-bg1 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <p>Debit note (purchase price/t) / Salvage rate / Sale value <input <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->debit_salvage_sale_txt; ?>" name="debit_salvage_sale_txt" class="form-control optional_field"></p>
                        </li>
                        <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->debit_note_sal_rate_sale_value; ?>" id="debit_note_sal_rate_sale_value" name="debit_note_sal_rate_sale_value" class="form-control form-p-box-bg2 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>

                    <ul class="fpall debit_inputs">
                        <li class="fp-con01">
                          <div>
                          Purchase price/t <br>
                          <input type="text" name="d_purchase_price" placeholder="Purchase price/t" style="width: 200px; float: left;" class="form-control optional_field mr-2" value="<?php echo $approval_note->d_purchase_price; ?>" <?php echo $readonly; ?>>
                          </div>

                          <div>
                           Salvage rate <br>

                          <input type="text" class="form-control optional_field  mr-2" name="d_salvage_rate" placeholder="Salvage rate" style="width: 200px; float: left;" value="<?php echo $approval_note->d_salvage_rate; ?>" <?php echo $readonly; ?>>
                          </div>

                          <div>
                          Sale value <br>
                          <input type="text" class="form-control optional_field mr-2" name="d_sale_value" placeholder="Sale value" style="width: 200px; float: left;" value="<?php echo $approval_note->d_sale_value; ?>" <?php echo $readonly; ?>>
                          </div>
                        </li>
                        
                        <div class="clerfix"></div>
                      </ul>

                    <ul class="fpall">
                        <li class="fp-con01">
                            <p>Value (purchase price/t X qty) <span style="float: right;">(b)</span></p>
                        </li>
                        <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->value; ?>" id="value" name="value" class="form-control form-p-box-bg1 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <div class="input-group" style="width: 250px">
                                <div class="input-group-append">
                                    <span class="input-group-text">CGST @</span>
                                </div>
                                <input type="number" min="0"  step="any"  name="lcgst_percent"  class="form-control loss_cgst" value="<?php 
                                    if(!empty($approval_note->lcgst_percent)){
                                        echo $approval_note->lcgst_percent;
                                    }else {
                                        $lcgst_percent =  100 / ($approval_note->value/$approval_note->loss_cgst);
                                        echo round($lcgst_percent,2);
                                    }
                                ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </li>
                        <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->loss_cgst; ?>" id="loss_cgst" name="loss_cgst" class="form-control form-p-box-bg1 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <div class="input-group" style="width: 250px">
                                <div class="input-group-append">
                                    <span class="input-group-text">SGST @</span>
                                </div>
                                <input type="number" min="0"  step="any"  name="lsgst_percent" class="form-control loss_sgst" value="<?php 
                                    if(!empty($approval_note->lsgst_percent)){
                                        echo $approval_note->lsgst_percent;
                                    }else {
                                        $lsgst_percent =  100 / ($approval_note->value/$approval_note->loss_sgst);
                                        echo round($lsgst_percent,2);
                                    }
                                ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </li>
                        <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->loss_sgst; ?>" id="loss_sgst" name="loss_sgst" class="form-control form-p-box-bg1 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <p>Total Debit Value <span style="float: right;">(x)</span></p>
                        </li>
                        <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->total_debit_value; ?>" id="total_debit_value" name="total_debit_value" class="form-control form-p-box-bg1 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <p>Other expenses incurred by MIL <input style="width: 300px;" <?php echo $readonly; ?> type="text" value="<?php echo $approval_note->other_exp_inc_mill_txt; ?>" name="other_exp_inc_mill_txt" class="form-control optional_field"> <span style="float: right;">(c)</span></p>
                        </li>
                        <li class="fp-con02"><span class="padd10">(+) &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->oth_exp_inc_mill; ?>" id="oth_exp_inc_mill" name="oth_exp_inc_mill" class="form-control form-p-box-bg1 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <p>Other expenses to be debited (eg freight) / credited (eg scrap @ 20000 recovery) to steel mill <span style="float: right;">(y)</span></p>
                        </li>
                        <li class="fp-con02"><span class="padd10">(-) &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->oth_exp_debited; ?>" id="oth_exp_debited" name="oth_exp_debited" class="form-control form-p-box-bg1 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <p>Compensation expected from Insurance Co. <span style="float: right;">(d)</span></p>
                        </li>
                        <li class="fp-con02"><span class="padd10">(-) &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->compensation_exp; ?>" id="compensation_exp" name="compensation_exp" class="form-control form-p-box-bg1 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <p class="colrred">Debit note issued to supplier / Billing back to customer / Realisation from scrap <span style="float: right;">(x+y)</span></p>
                        </li>
                        <li class="fp-con02"><span class="padd10 colrred">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->debit_note_iss_supplier; ?>" id="debit_note_iss_supplier" name="debit_note_iss_supplier" class="form-control form-p-box-bg3 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <p class="colrred">Loss from the Rejection <span style="float: right;">(e) = (a-b+c-d-y)</span></p>
                        </li>
                        <li class="fp-con02"><span class="padd10 colrred">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->loss_from_rejection; ?>" id="loss_from_rejection" name="loss_from_rejection" class="form-control form-p-box-bg3 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>
                    <ul class="fpall">
                        <li class="fp-con01">
                            <p>Recoverable from Transporter (if applicable) <span style="float: right;">(f)</span></p>
                        </li>
                        <li class="fp-con02"><span class="padd10">(-) &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->recoverable_transporter; ?>" id="recoverable_transporter" name="recoverable_transporter" class="form-control form-p-box-bg1 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>

                    <ul class="fpall">
                        <li class="fp-con01">
                            <p>Other Realisation (if applicable) <span style="float: right;">(g)</span></p>
                        </li>
                        <li class="fp-con02"><span class="padd10">(-) &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->other_realisation; ?>" id="other_realisation" name="other_realisation" class="form-control form-p-box-bg1 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>


                    <ul class="fpall">
                        <li class="fp-con01">
                            <p class="colrred">Net Loss / (-) Net Profit <span style="float: right;">(e-f-g)</span></p>
                        </li>
                        <li class="fp-con02"><span class="padd10 colrred">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>
                            <input <?php echo $readonly; ?> type="number" step="any" value="<?php echo $approval_note->net_loss; ?>" id="net_loss" name="net_loss" class="form-control form-p-box-bg3 sphf app_note_number">
                        </li>
                        <div class="clerfix"></div>
                    </ul>

                </div>
                <?php
                $employee_loc = EmployeeLocation::find_by_emp_id($session->employee_id);
                if ($emp_sub_role_appr == "CFO") {
                    $comp_sql = "Select * from complaint where approval_note != ''";
                ?>
                    <div class="rst-full">
                        <ul class="fpall">
                            <div class="custom-control custom-checkbox arsalin">
                                <input name="cna_md_status" <?php if ($approval_note->net_loss >= 100000) {
                                                                echo " checked ";
                                                            } ?> type="checkbox" class="custom-control-input" id="cna_crm_head">
                                <label class="custom-control-label" for="cna_crm_head">Send Document to MD for Approval</label>
                            </div>
                        </ul>
                    </div>
                <?php } ?>

            <div class="rst-full">
                <ul class="fpall">
                    <p class="colrred_black"><strong>Employee Remark</strong></p>
                    <?php echo $approval_note->remark; ?>
                </ul>

              <?php 
                  
                  show_approver_info_common($complaint_reg,$approval_note);


                    if( can_approve_complaint($complaint_reg,$emp_sub_role_appr) &&  $approval_note->on_hold == 0){
                        echo '<ul class="fpall" >
                                 <hr />
                                <textarea class="form-control mrig10 form-p-box-bg1"  name="approver_remark" placeholder="Approver Remarks" rows="3"></textarea>
                            </ul>';
                      }
                  ?>
                
                    
                </div>


                <div class="pfot-cont">
                    <hr>
                    <p>
                        Note<br />
                        a) Credit Note will be issued by the respective plants in case of material return from the customer.<br />
                        b) For processing related rejections, complaint will be closed after issue of CAPA / CN<br />
                    </p>
                </div>

                <div class="clerfix"></div>
            </div>
            <!-- box 4 -->

  

  <?php
  // $employee_loc = EmployeeLocation::find_by_emp_id($session->employee_id);
  $approve_div = "
    <div class='form-p-box form-p-boxbtn'>
        <input type='checkbox' id='is_hold'  value='1'>
        <label for='is_hold'> Reject / Hold </label><br>
    </div>

    <div align='center'><span class='err_msg approval_note_msg'></span></div>
      <div class='form-p-box form-p-boxbtn approve_btn_div'>
        <button type='button' class='fpcl' data-dismiss='modal'>Close</button>
        <input type='submit' id='approve_approval_note' name='approve_approval_note' class='fpdone' value='Approve' />
      </div>";


    if( can_approve_complaint($complaint_reg,$emp_sub_role_appr) &&  $approval_note->on_hold == 0){
      echo $approve_div;
    }
  /*if($emp_sub_role_appr == "CRM - Head" && empty($complaint_reg->cna_crm_head) ){
      echo $approve_div;
  } 
  else if($emp_sub_role_appr == "Commercial Head" && empty($complaint_reg->cna_commercial_head) ){
    echo $approve_div;
  }
  else if($emp_sub_role_appr == "Plant Chief - AN" && empty($complaint_reg->cna_plant_chief) ){
      echo $approve_div;
  } 
  else if($emp_sub_role_appr == "Sales Head" && empty($complaint_reg->cna_sales_head) ){
      echo $approve_div;
  } 
  else if($emp_sub_role_appr == "CFO" && empty($complaint_reg->cna_cfo) ){
      echo $approve_div;
  } 
  else if($emp_sub_role_appr == "MD" && empty($complaint_reg->cna_md) && $complaint_reg->cna_md_status = 'Yes'){
      echo $approve_div;
  }*/


?>
       </form>

<?php 
  include '../employee/approval-note-file-html.php';
?>

<?php 
    if ( $approval_note->on_hold == 1){

      echo '<div class="form-p-box form-p-box-bg1">
            <div class="rst-full">
                <ul class="fpall">
                    <p class="colrred_black"><strong>Rejected By : </strong>'.$approval_note->on_hold_by.'</p>
                    <p class="colrred_black"><strong>Rejected On : </strong>'.date("Y-m-d", strtotime($approval_note->on_hold_date)).'</p>
                    <p class="colrred_black"><strong>Hold/Reject Reason : </strong></p>
                    <p> '.$approval_note->on_hold_remark.' </p>
                </ul>
              </div>
            </div>';
    }
    else {
  ?>
  <form action="<?php echo "reject-approval-note-db.php?id=" . $approval_note->complaint_id; ?>" method="post" enctype="multipart/form-data" autocomplete="off" id="reject_appr_note" style="display: none;">

      <div class="form-p-box form-p-box-bg1">

        <div class="rst-full">
            <ul class="fpall">
                <p class="colrred_black"><strong>Hold/Reject Reason</strong></p>
                <textarea class="form-control mrig10 form-p-box-bg1" id="approver_hold_remark" name="approver_hold_remark" placeholder="Enter Hold/Reject Reason" rows="3"></textarea>
            </ul>

        </div>

          <div class='form-p-box form-p-boxbtn'>
              <button type='button' class='fpcl' data-dismiss='modal'>Close</button>
              <input type='submit' id='reject_approval_note' name='reject_approval_note' class='fpdone' value='Reject' />
          </div>
          
      </div>
    </form>
<?php   
 }
?>



  <div class="clerfix"></div>
</div>


</div>
<script src="assets/js/app.min.js"></script>

<script>
    $(document).ready(function() {
        $("#create-note input").each(function() {
            if ($(this).attr('type') == "number") {
                if (!$(this).val()) {
                    $(this).val(0);
                }
            }
        });
    });


    var readonly = '<?php echo $readonly; ?>';

    if (readonly == '') {
        $('.date-picker').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD/MM/YYYY',
            }
        });
    }

    function updateInputValue(){
        total_qty_rejc = $.trim( $("#total_qty_rejc").val() );
        // total_qty_rejc = total_qty_rejc.replace("MT", "");
        temp_arr = total_qty_rejc.split(" ");
        total_qty_rejc = $.trim(temp_arr[0]);

        basic_sale_price = $("#basic_sale_price").val();
        sales_value = (total_qty_rejc * basic_sale_price).toFixed(2);
        $("#sales_value").val(sales_value);

        cgst = (sales_value / 100) * $(".cgst").val();
        sgst = (sales_value / 100) * $(".sgst").val();
        cgst = cgst.toFixed(2);
        sgst = sgst.toFixed(2);

        $("#cgst").val(cgst);
        $("#sgst").val(sgst);

        cost_inc_customer = $("#cost_inc_customer").val();
        salvage_value = $("#salvage_value").val();

        credit_note_iss_cust = parseFloat(sales_value) + parseFloat(cgst) + parseFloat(sgst) + parseFloat(cost_inc_customer) - parseFloat(salvage_value);
        $("#credit_note_iss_cust").val(credit_note_iss_cust.toFixed(2));

        //console.log(parseFloat(cgst));
        //console.log("Text Out"); 

        qty_acpt_steel_mill = $.trim( $("#qty_acpt_steel_mill").val() );
        // qty_acpt_steel_mill = qty_acpt_steel_mill.replace("MT", "");
        temp_arr = qty_acpt_steel_mill.split(" ");
        qty_acpt_steel_mill = $.trim(temp_arr[0]);


        qty_scrp_auc_serv_cent = $.trim( $("#qty_scrp_auc_serv_cent").val() );
        // qty_scrp_auc_serv_cent = qty_scrp_auc_serv_cent.replace("MT", "");
        temp_arr = qty_scrp_auc_serv_cent.split(" ");
        qty_scrp_auc_serv_cent = $.trim(temp_arr[0]);


        qty_dlv_customer = $.trim( $("#qty_dlv_customer").val() );
        // qty_dlv_customer = qty_dlv_customer.replace("MT", "");
        temp_arr = qty_dlv_customer.split(" ");
        qty_dlv_customer = $.trim(temp_arr[0]);


        qty_debit = parseFloat(qty_acpt_steel_mill) + parseFloat(qty_scrp_auc_serv_cent) + parseFloat(qty_dlv_customer)

        debit_note_sal_rate_sale_value = $("#debit_note_sal_rate_sale_value").val();
        value = qty_debit * debit_note_sal_rate_sale_value;
        value = value.toFixed(2);
        $("#value").val(value);

        loss_cgst = (value / 100) * $(".loss_cgst").val();
        loss_sgst = (value / 100) * $(".loss_sgst").val();
        loss_cgst = loss_cgst.toFixed(2);
        loss_sgst = loss_sgst.toFixed(2);

        $("#loss_cgst").val(loss_cgst);
        $("#loss_sgst").val(loss_sgst);


        var total_debit_value = parseFloat(value) + parseFloat(loss_cgst) + parseFloat(loss_sgst);
        $("#total_debit_value").val(total_debit_value.toFixed(2));


        oth_exp_inc_mill = $("#oth_exp_inc_mill").val();
        oth_exp_debited = $("#oth_exp_debited").val();
        compensation_exp = $("#compensation_exp").val();


        //debit_note_iss_supplier   = parseFloat(value) + parseFloat(loss_cgst) + parseFloat(loss_sgst) + parseFloat(oth_exp_debited) + parseFloat(compensation_exp) - parseFloat(oth_exp_inc_mill);
        debit_note_iss_supplier = parseFloat(value) + parseFloat(loss_cgst) + parseFloat(loss_sgst) + parseFloat(oth_exp_debited);
        debit_note_iss_supplier = debit_note_iss_supplier.toFixed(2);
        $("#debit_note_iss_supplier").val(debit_note_iss_supplier);


        //loss_from_rejection       = (parseFloat(sales_value) - parseFloat(value)) + (parseFloat(oth_exp_inc_mill) - parseFloat(compensation_exp));
        loss_from_rejection = (parseFloat(sales_value) - parseFloat(value)) + (parseFloat(oth_exp_inc_mill) - parseFloat(oth_exp_debited) - parseFloat(compensation_exp));
        //loss_from_rejection       = (parseFloat(sales_value) - parseFloat(value)) + (parseFloat(oth_exp_inc_mill) - parseFloat(compensation_exp) - parseFloat(debit_note_iss_supplier));
        //loss_from_rejection       = parseFloat(credit_note_iss_cust) - parseFloat(debit_note_iss_supplier);
        loss_from_rejection = loss_from_rejection.toFixed(2);
        $("#loss_from_rejection").val(loss_from_rejection);


        recoverable_transporter = $("#recoverable_transporter").val();
        other_realisation   = $("#other_realisation").val();

        net_loss = parseFloat(loss_from_rejection) - parseFloat(recoverable_transporter) - parseFloat(other_realisation);
        net_loss = net_loss.toFixed(2);
        $("#net_loss").val(net_loss);
    }
    $('#create-note input').change(function() {
        updateInputValue();
    });

    $('#create-note input').blur(function() {
        if ($(this).attr('type') == "number") {
            if (!$(this).val()) {
                $(this).val(0);
            }
        }
        updateInputValue();
    });


    $('#is_hold').change(function() {
        if(this.checked) {
            $('#reject_appr_note').show();
            $('.approve_btn_div').hide();
        }else{
          $('#reject_appr_note').hide();
          $('.approve_btn_div').show();
        }
    });

    $(document).ready(function() {
        updateInputValue();

        /* Create Credit Approval Note *************************************************************/
  $("#approve_approval_note").click(function() {

    var num = 0;
    
    total_qty_rejc    = $("#total_qty_rejc").val();
    temp_arr = total_qty_rejc.split(" ");
    total_qty_rejc = $.trim(temp_arr[0]);

    qty_acpt_steel_mill       = $("#qty_acpt_steel_mill").val();
    temp_arr = qty_acpt_steel_mill.split(" ");
    qty_acpt_steel_mill = $.trim(temp_arr[0]);


    qty_scrp_auc_serv_cent      = $("#qty_scrp_auc_serv_cent").val();
    temp_arr = qty_scrp_auc_serv_cent.split(" ");
    qty_scrp_auc_serv_cent = $.trim(temp_arr[0]);


    qty_dlv_customer        = $("#qty_dlv_customer").val();
    temp_arr = qty_dlv_customer.split(" ");
    qty_dlv_customer = $.trim(temp_arr[0]);



    qty_debit           = parseFloat(qty_acpt_steel_mill) + parseFloat(qty_scrp_auc_serv_cent) + parseFloat(qty_dlv_customer)
        

    $("#create-note input").each(function() {
        if ($(this).val() == "") {
          if(! $(this).hasClass("optional_field")){
            num++
            $(this).css("border","1px solid #f00");
          }
        } else {
          $(this).css("border","1px solid #dee2e6");
        } 
    }); 


    $(".app_note_number").each(function() {     

        var intsOnly = /(^-?\d\d*\.\d*$)|(^-?\d\d*$)|(^-?\.\d\d*$)/,
        app_note_number = $.trim($(this).val());

        temp_arr = app_note_number.split(" ");
        app_note_number = $.trim(temp_arr[0]);

        if(intsOnly.test(app_note_number)) {
            $(this).css("border","1px solid #dee2e6");
        } else {
          $(this).css("border","1px solid #f00");
          num++
        } 
    }); 

    $id_source = '<?php echo $complaint_reg->identify_source; ?>';

    //if($id_source != "Plant" && total_qty_rejc != qty_debit){
      //alert(qty_debit + " != " +total_qty_rejc);
      //num++;
      //$("#qty_acpt_steel_mill").css("border","1px solid #f00");
      //$("#qty_scrp_auc_serv_cent").css("border","1px solid #f00");
      //$("#qty_dlv_customer").css("border","1px solid #f00");
    //}   

    new_total_qty_rejc = total_qty_rejc.replace(/\d+/g, '')


    console.log(num);
    console.log(qty_debit + " != " +total_qty_rejc + " = " +new_total_qty_rejc);

    if(num > 0){
      $(".approval_note_msg").show(); $(".approval_note_msg").html("The fields marked in red needs to be filled / correct information");
      return false;
    } else {
      $(".approval_note_msg").hide(); $(".approval_note_msg").html("");
    }
    
    // alert('no error'); return false;

  });
/* Create Credit Approval Note  END *************************************************************/
    });
</script>