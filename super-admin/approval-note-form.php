
<!-- Form pop up -->
<div class="modal fade form-pop" id="create-note" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header border-bottom-st d-block">
<button type="button" class="close btclo" data-dismiss="modal" aria-hidden="true">&times;</button>
<div class="form-p-hd">
<h2>MAHINDRA ACCELO LTD. / MASL / MSSCL<br>
Credit Note / Debit Note Approval</h2>
</div>


<div class="form-p-block" id="approval_note_div">
<form action="<?php echo "raised-complaint-db.php?id=".$_GET['id']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
<!-- box 1 -->
<div class="form-p-box form-p-box-bg2">

<div class="rst-left">
  <ul class="fpall">
    <li class="fp-con1"><p>Name of the Customer</p></li>             
    <li class="fp-con2"><input readonly type="text" id="customer_name" value="<?php echo $complaint_reg->company_name; ?>" name="customer_name" class="form-control form-p-box-bg1"></li>
    <div class="clerfix"></div>
  </ul>

  <ul class="fpall">
    <li class="fp-con1"><p>Complaint Reference no</p></li>             
    <li class="fp-con2"><input readonly type="text" id="complait_reference" value="<?php echo $complaint_reg->ticket_no; ?>" name="complait_reference" class="form-control form-p-box-bg1"></li>
    <div class="clerfix"></div>
  </ul>



  <ul class="fpall">
    <li class="fp-con1"><p>Complant Registration Date</p></li>             
    <li class="fp-con2"> <?php $complait_reg_date = $complaint_reg->invoice_date; $complait_reg_date = strtotime($complait_reg_date); $complait_reg_date = date("d/m/Y", $complait_reg_date); ?>
      <input readonly class="form-control" value="<?php echo $complait_reg_date; ?>" id="complait_reg_date" name="complait_reg_date" type="text">
    </li>
    <div class="clerfix"></div>
  </ul>

  <ul class="fpall">
    <li class="fp-con1"><p>Material Details  (grade, size etc)</p></li>             
    <li class="fp-con2"><input type="text" id="material_details" name="material_details" class="form-control form-p-box-bg1"></li>
    <div class="clerfix"></div>
  </ul>
</div>

<div class="rst-right">
  <ul class="fpall">
    <li class="fp-con1"><p>Nature of the Complaint</p></li>             
    <li class="fp-con2"><textarea id="nature_of_complaint" name="nature_of_complaint" readonly class="form-control mrig10 form-p-box-bg1"><?php echo $complaint_reg->complaint_type.", ".$complaint_reg->sub_complaint_type ?></textarea></li>
    <div class="clerfix"></div>
  </ul>

  <ul class="fpall">
    <li class="fp-con1"><p>Name of the Steel Mill / Service centre/ Transporter</p></li>             
    <li class="fp-con2"><input readonly type="text" id="name_of_sm_sc_t" name="name_of_sm_sc_t" value="<?php if(empty($complaint_reg->mill)){echo $complaint_reg->plant_location;}else { echo $complaint_reg->mill;} ?>" class="form-control form-p-box-bg1"></li>
    <div class="clerfix"></div>
  </ul>

  <ul class="fpall">
    <li class="fp-con1"><p>Responsibility</p></li>             
    <li class="fp-con2"><input readonly type="text" id="identify_source" name="responsibility" value="<?php echo $complaint_reg->identify_source; ?>" class="form-control form-p-box-bg1"></li>
    <div class="clerfix"></div>
  </ul>
</div>

<div class="clerfix"></div>
</div>
<!-- box 1 -->

<!-- box 2 -->
<div class="form-p-box form-p-box-bg1 border-bottom-st">
  <h2 class="sectphd">Credit Note to be Issued to Customer</h2>
  <div class="rst-left">
  <ul class="fpall">
    <li class="fp-con1"><p>Billing Document No.</p></li>   
    <li class="fp-con2"><input type="text" id="billing_doc_no" name="billing_doc_no" value="<?php echo $complaint_reg->invoice_number; ?>" class="form-control form-p-box-bg2"></li>
    <div class="clerfix"></div>
  </ul>

  <ul class="fpall">
    <li class="fp-con1"><p>Billing Document Date</p></li>             
    <li class="fp-con2">
      <input id="billing_doc_date" type="text" name="billing_doc_date" class="form-control date-picker">
    </li>
    <div class="clerfix"></div>
  </ul>
</div>

<div class="rst-right">
  <ul class="fpall">
    <li class="fp-con1"><p>Total Qty Rejected by the Customer</p></li>             
    <li class="fp-con2">
      <div class="row"> 
        <div class="col col-sm-5">
          <select id="total_qty_rejc_type" name="total_qty_rejc_type" class="form-control">
            <option>MT</option>
            <option>KG</option>
            <option>Each</option>
          </select>
        </div>
        <div class="col col-sm-7">
          <input type="text" id="total_qty_rejc" name="total_qty_rejc" value="0" class="form-control form-p-box-bg2 app_note_number">
        </div>
      </div>
    </li>
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
      <p style="float: left; margin-right: 10px;" >Basic sale price</p>
      <input style="width: 300px; float: left;" type="text" class="form-control optional_field" name="basic_sale_price_txt">
    </li> 
    <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
    <input type="text" id="basic_sale_price" name="basic_sale_price" value="0" class="form-control form-p-box-bg2 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01"><p>Sales Value (Basic sale price/t X Qty) <span style="float: right;">(a)</span></p></li> 
    <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
    <input readonly type="text" id="sales_value" name="sales_value" value="0" class="form-control form-p-box-bg2 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01">
      <div class="input-group" style="width: 200px">
        <div class="input-group-append">
          <span class="input-group-text">CGST @</span>
        </div>
        <input type="text" name="cgst_percent" class="form-control cgst" value="9">
        <div class="input-group-append">
          <span class="input-group-text">%</span>
        </div>
      </div>
    </li> 
    <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
    <input type="text" readonly id="cgst" name="cgst" value="0" class="form-control form-p-box-bg2 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01">
      <div class="input-group" style="width: 200px">
        <div class="input-group-append">
          <span class="input-group-text">SGST @</span>
        </div>
        <input type="text" name="sgst_percent" class="form-control sgst" value="9">
        <div class="input-group-append">
          <span class="input-group-text">%</span>
        </div>
      </div>
    </li> 
    <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>
    <input type="text" readonly id="sgst" name="sgst" value="0" class="form-control form-p-box-bg2 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01">
      <p style="float: left; margin-right: 10px;">Cost incurred by the Customer</p>
      <input style="width: 300px; float: left;" type="text" class="form-control optional_field" name="cost_inc_customer_txt">
    </li>
    <li class="fp-con02"><span class="padd10">(+) &nbsp; Rs.</span>  
    <input type="text" id="cost_inc_customer" name="cost_inc_customer" value="0" class="form-control form-p-box-bg2 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01">
      <p style="float: left; margin-right: 10px;" >Salvage Rate</p>
      <input style="width: 300px; float: left;" type="text" class="form-control optional_field" name="salvage_value_txt">
    </li> 
    <li class="fp-con02"><span class="padd10">(-) &nbsp; Rs.</span>  
    <input type="text" id="salvage_value" name="salvage_value" value="0" class="form-control form-p-box-bg2 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01"><p class="colrred_black">Credit note to be issued to the customer (total of abv net of scrap value)</p></li> 
    <li class="fp-con02"><span class="padd10 colrred_black">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
    <input type="text" readonly id="credit_note_iss_cust" name="credit_note_iss_cust" value="0" class="form-control form-p-box-bg3 sphf app_note_number"></li>
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
    <li class="fp-con01"><p>Quantity (t) as accepted by steel mill    </p></li> 
    <li class="fp-con02">
      <input style="width: 50%; margin: 0 3% 0 0; float: right;" type="text" id="qty_acpt_steel_mill" name="qty_acpt_steel_mill" value="0" class="form-control form-p-box-bg1 sphf app_note_number">
      <select style="width: 30%; margin: 0 3% 0 0; float: right;" name="qty_acpt_steel_mill_type" class="form-control">
        <option>MT</option>
        <option>KG</option>
        <option>Each</option>
      </select>
    </li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01"><p>Quantity (t) to be scrapped / auction at service centres </p></li> 
    <li class="fp-con02">
      <input style="width: 50%; margin: 0 3% 0 0; float: right;" type="text" id="qty_scrp_auc_serv_cent" name="qty_scrp_auc_serv_cent" value="0" class="form-control form-p-box-bg1 sphf app_note_number">
      <select style="width: 30%; margin: 0 3% 0 0; float: right;" name="qty_scrp_auc_serv_cent_type" class="form-control">
        <option>MT</option>
        <option>KG</option>
        <option>Each</option>
      </select>
    </li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01"><p>Quantity (t) to be diverted to any other customer</p></li> 
    <li class="fp-con02">
      <input style="width: 50%;  margin: 0 3% 0 0;float: right;" type="text" id="qty_dlv_customer" name="qty_dlv_customer" value="0" class="form-control form-p-box-bg1 sphf app_note_number">
      <select style="width: 30%; margin: 0 3% 0 0; float: right;" name="qty_dlv_customer_type" class="form-control">
        <option>MT</option>
        <option>KG</option>
        <option>Each</option>
      </select>
    </li>     
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01">
      <p style="float: left; margin-right: 10px;" >Debit note (purchase price/t) / Salvage rate / Sale value</p>
      <input style="width: 300px; float: left;" type="text" class="form-control optional_field" name="debit_salvage_sale_txt">
    </li>

    <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
    <input type="text" id="debit_note_sal_rate_sale_value" name="debit_note_sal_rate_sale_value" value="0" class="form-control form-p-box-bg2 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>

  <ul class="fpall">
    <li class="fp-con01">
      <div>
        Purchase price/t <br>
        <input type="text" name="d_purchase_price" placeholder="Purchase price/t" style="width: 200px; float: left;margin-right: .75rem;" class="form-control optional_field">
      </div>

      <div>
        Salvage rate <br>
        <input type="text" class="form-control optional_field" name="d_salvage_rate" placeholder="Salvage rate" style="width: 200px; float: left; margin-right: .75rem;">
      </div>

        <div>
          Sale value  <br>
          <input type="text" class="form-control optional_field" name="d_sale_value" placeholder="Sale value" style="width: 200px; float: left;margin-right: .75rem;">
        </div>
        
      </li>
    <div class="clerfix"></div>
  </ul>


  <ul class="fpall">
    <li class="fp-con01"><p>Value (purchase price/t  X qty)  <span style="float: right;">(b)</span></p></li> 
    <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
    <input type="text" readonly id="value" name="value" value="0" class="form-control form-p-box-bg1 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01">
      <div class="input-group" style="width: 200px">
        <div class="input-group-append">
          <span class="input-group-text">CGST @</span>
        </div>
        <input type="text" name="lcgst_percent" class="form-control loss_cgst" value="9">
        <div class="input-group-append">
          <span class="input-group-text">%</span>
        </div>
      </div>
    </li>
    <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
    <input type="text" readonly id="loss_cgst" name="loss_cgst" value="0" class="form-control form-p-box-bg1 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01">
      <div class="input-group" style="width: 200px">
        <div class="input-group-append">
          <span class="input-group-text">SGST @</span>
        </div>
        <input type="text" name="lsgst_percent" class="form-control loss_sgst" value="9">
        <div class="input-group-append">
          <span class="input-group-text">%</span>
        </div>
      </div>
    </li>
    <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
    <input type="text"  readonly id="loss_sgst" name="loss_sgst" value="0" class="form-control form-p-box-bg1 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01"><p>Total Debit Value  <span style="float: right;">(x)</span></p></li> 
    <li class="fp-con02"><span class="padd10">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
    <input type="text" readonly id="total_debit_value" name="total_debit_value" value="0" class="form-control form-p-box-bg3 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01">
      <p style="float: left; margin-right: 10px;">Other expenses incurred by MIL</p>
      <input style="width: 250px; float: left;" type="text" class="form-control optional_field" name="other_exp_inc_mill_txt">
      <span style="float: right;">(c)</span>
    </li> 
    <li class="fp-con02"><span class="padd10">(+) &nbsp; Rs.</span>  
    <input type="text"  id="oth_exp_inc_mill" name="oth_exp_inc_mill" value="0" class="form-control form-p-box-bg1 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01"><p>Other expenses to be debited (eg freight) / credited (eg scrap @ 20000 recovery) to steel mill  <span style="float: right;">(y)</span></p></li> 
    <li class="fp-con02"><span class="padd10">(-) &nbsp; Rs.</span>  
    <input type="text"  id="oth_exp_debited" name="oth_exp_debited" value="0" class="form-control form-p-box-bg1 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01"><p>Compensation expected from Insurance Co.  <span style="float: right;">(d)</span></p></li> 
    <li class="fp-con02"><span class="padd10">(-) &nbsp; Rs.</span>  
    <input type="text"  id="compensation_exp" name="compensation_exp" value="0" class="form-control form-p-box-bg1 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01"><p class="colrred_black">Debit note issued to supplier / Billing back to customer / Realisation from scrap  <span style="float: right;">(x+y)</span></p></li> 
    <li class="fp-con02"><span class="padd10 colrred_black">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
    <input type="text"  readonly id="debit_note_iss_supplier" name="debit_note_iss_supplier" value="0" class="form-control form-p-box-bg3 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01"><p class="colrred_black">Loss from the Rejection <span style="float: right;">(e) = (a-b+c-d-y)</span></p></li> 
    <li class="fp-con02"><span class="padd10 colrred_black">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
    <input type="text"  readonly id="loss_from_rejection" name="loss_from_rejection" value="0" class="form-control form-p-box-bg3 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <li class="fp-con01"><p>Recoverable from Transporter (if applicable) <span style="float: right;">(f)</span></p></li> 
    <li class="fp-con02"><span class="padd10">(-) &nbsp; Rs.</span>  
    <input type="text"  id="recoverable_transporter" name="recoverable_transporter" value="0" class="form-control form-p-box-bg1 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>

  <ul class="fpall">
    <li class="fp-con01"><p>Other Realisation (if applicable) <span style="float: right;">(g)</span></p></li> 
    <li class="fp-con02"><span class="padd10">(-) &nbsp; Rs.</span>  
    <input type="text"  id="other_realisation" name="other_realisation" value="0" class="form-control form-p-box-bg1 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>

  <ul class="fpall">
    <li class="fp-con01"><p class="colrred_black">Net Loss / (-) Net Profit <span style="float: right;">(e-f-g)</span></p></li> 
    <li class="fp-con02"><span class="padd10 colrred_black">&nbsp; &nbsp; &nbsp; &nbsp; Rs.</span>  
    <input type="text"  readonly id="net_loss" name="net_loss" value="0" class="form-control form-p-box-bg3 sphf app_note_number"></li>
    <div class="clerfix"></div>
  </ul>
  <ul class="fpall">
    <textarea class="form-control mrig10 form-p-box-bg1" id="verify_remark" name="verify_remark" placeholder="Remarks" rows="3"></textarea>
  </ul>
</div>

<div class="pfot-cont">
  <p>
    Note<br/>
    a) Credit Note will be issued by the respective plants in case of material return from the customer.<br/>
    b)  For processing related rejections, complaint will be closed after issue of CAPA / CN<br/>
  </p>
</div>

  <div class="clerfix"></div>
</div>
<!-- box 4 -->
<div align="center"><span class="err_msg approval_note_msg"></span></div>
<div class="form-p-box form-p-boxbtn">
  <input type="submit" id="create_a_note" name="create_a_note" class="fpdone" value="Submit" />
</div>

</form>
<div class="clerfix"></div>
</div>


</div>



<!-- end modal-body-->
</div> <!-- end modal-content-->
</div> <!-- end modal dialog-->
</div>
<!-- Form pop up -->
