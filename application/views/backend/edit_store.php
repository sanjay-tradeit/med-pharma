<?php
$this->load->view('backend/header');
$this->load->view('backend/sidebar');
?>

<div class="page-wrapper" style="min-height: 561px;">
    <div class="container-fluid p-t-10">
        <div class="row">

            <div class="col-lg-12">
                  <?php
                     $string = date("Y-m-d");
                     $date = DateTime::createFromFormat("Y-m-d", $string);
                        $dateObj   = DateTime::createFromFormat('!m', $date->format("m"));
                        $monthName = $dateObj->format('F'); 
                    ?>
                <div class="card card-outline-info">
                    <div class="card-header">
                    <h4 class="m-b-0 text-white">Store<span class="pull-right"> <?php echo  date("l");?> <?php echo $date->format("d");  ?>th of <?php echo $monthName;  echo $date->format("Y"); ?> <?php echo  date("h:i:sa") ?></span></h4>
                    </div>
                    <div id="success_msg">
                     </div>
                    <div class="card-body add-store-card">

                        <form action="<?php echo base_url(); ?>Store/update_store" method="POST">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>Store Name</b></label>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <input type="text" class="form-control" placeholder="Store-id" id="store_id" name="store_id" value="<?php if(!empty($stores_info[0]->store_id)){  echo $stores_info[0]->store_id; }?>">
                                                <input type = "hidden" name="id" value="<?php if(!empty($stores_info[0]->id)){  echo $stores_info[0]->id; }?>">
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <input type="text" class="form-control" placeholder="Store-name" id="store_name" name="store_name" value="<?php if(!empty($stores_info[0]->store_name)){ echo $stores_info[0]->store_name; }?>">
                                            </div>
                                            <div class="col-md-4 col-sm-12 ">

                                                <input type="text" class="form-control" placeholder="Alias" id="store_alias" name="store_alias" value="<?php if(!empty($stores_info[0]->store_alias)){ echo $stores_info[0]->store_alias;} ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>Store Type</b></label>

                                        <div class="row pl-2">
                                          <div class="col-md-3 col-sm-12 ">
                                            <input type="radio" name="store_type" class="custom-control-input discount" id="main-yes" value="0" <?php if($stores_info[0]->store_point_type=="0") {echo "checked";}?>>
                                            <label for="main-yes">Main</label>
                                            </div>
                                            <div class="col-md-3 col-sm-12 ">
                                            <input type="radio" name="store_type" class="custom-control-input discount" id="sub-yes" value="1" <?php if($stores_info[0]->store_point_type=="1") {echo "checked";}?>>
                                            <label for="sub-yes">Sub</label>
                                            </div>
                                        </div>


                                    </div>
                                    <hr>
                                    <?php 
                                          $transaction_type = explode(",", $stores_info[0]->transaction_type); 
                                        
                                    ?>
                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>Transaction Type</b></label>
                                     <div class="row pl-2">
                                        <div class="col-md-3 col-sm-12 ">
                                            <input name="Transaction_Type[]" class="custom-control-input favourite" value="0" type="checkbox" id="icu_customer" <?php if(in_array("0", $transaction_type)){ echo 'checked="checked"'; }?>>
                                            <label for="icu_customer">ICU</label>
                                        </div>
                                            <div class="col-md-3 col-sm-12 ">
                                                <input name="Transaction_Type[]" class="custom-control-input favourite" value="1" type="checkbox" id="Ward_customer" <?php if(in_array("1", $transaction_type)){ echo 'checked="checked"'; }?>>
                                                <label for="Ward_customer">Ward</label>
                                            </div>
                                            <div class="col-md-3 col-sm-12 ">
                                                <input name="Transaction_Type[]" class="custom-control-input favourite" value="2" type="checkbox" id="OT_customer" <?php if(in_array("2", $transaction_type)){ echo 'checked="checked"'; }?>>
                                                <label for="OT_customer">OT</label>
                                            </div>
                                        </div>
                                        <div class="row  pl-2">
                                        <div class="col-md-3 col-sm-12 ">
                                            <input type="radio" name="medical_type" class="custom-control-input discount" id="Medical-yes" value="0" <?php if($stores_info[0]->medical_type=="0") {echo "checked";}?>>
                                            <label for="Medical-yes">Medical</label>
                                            </div>
                                            <div class="col-md-3 col-sm-12 ">
                                            <input type="radio" name="medical_type" class="custom-control-input discount" id="Non-Medical-yes" value="1" <?php if($stores_info[0]->medical_type=="1") {echo "checked";}?>>
                                            <label for="Non-Medical-yes">Non-Medical</label>
                                            </div>
                                        </div>


                                    </div>
                                    <hr>
                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>Payment Type</b></label>
                                        <div class="row pl-2">
                                        <div class="col-md-3 col-sm-12 ">
                                            <input type="radio" name="payment_type" class="custom-control-input discount" id="Cash-yes" value="0" <?php if($stores_info[0]->payment_type=="0") {echo "checked";}?>>
                                            <label for="Cash-yes">Cash</label>
                                            </div>
                                            <div class="col-md-3 col-sm-12 ">
                                            <input type="radio" name="payment_type" class="custom-control-input discount" id="Credit-yes" value="1" <?php if($stores_info[0]->payment_type=="1") {echo "checked";}?>>
                                            <label for="Credit-yes">Credit</label>
                                            </div>
                                            <div class="col-md-3 col-sm-12 ">
                                            <input type="radio" name="payment_type" class="custom-control-input discount" id="Both-yes" value="2" <?php if($stores_info[0]->payment_type=="2") {echo "checked";}?>>
                                            <label for="Both-yes">Both</label>
                                            </div>
                                        </div>

                                    </div>

                                    <hr>
                                    <?php
                                       // echo $stores_info[0]->discount_facility_discount;
                                    ?>
                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>Discount Facility</b></label>
                                        <div class="row pl-2">
                                            <div class="col-md-4 col-sm-12 ">
                                                <input name="Discount_Facility" class="custom-control-input favourite" value="1" type="checkbox" id="Discount_Facility" <?php if($stores_info[0]->discount_facility_discount=="1"){ echo 'checked="checked"'; }?>>
                                                <label for="Discount_Facility">Discount (%)</label>
                                            </div>
                                            <div class="col-md-2 col-sm-12 ">
                                                <input type="text" class="form-control" name="discount_facility_value" value="<?php echo  $stores_info[0]->discount_facility_dis_val; ?>">

                                            </div>
                                       
                                            <div class="col-md-4 col-sm-12">
                                                <input name="doc_dis" class="custom-control-input favourite" value="1" type="checkbox" id="Doctor_Discount" <?php if($stores_info[0]->discount_facility_doc_dis=="1"){ echo 'checked="checked"'; }?>>
                                                <label for="Doctor_Discount">Doctor Discount (%)</label>
                                            </div>
                                            <div class="col-md-2 col-sm-12 ">
                                                <input type="text" class="form-control" name="Doctor_Discount_val" value="<?php echo  $stores_info[0]->discount_facility_doc_dis_val; ?>">

                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>IP Tax Applicable</b></label>
                                        <div class="row pl-2">
                                            <div class="col-md-2 col-sm-12 ">
                                                <input type="radio" name="ip_tax" class="custom-control-input discount" id="Cash-no" value="0" <?php if($stores_info[0]->ip_tax_applicable=="0") {echo "checked";}?>>
                                                <label for="Cash-no">No</label>
                                            </div>
                                            <div class="col-md-4 col-sm-12 ">
                                                <input type="radio" name="ip_tax" class="custom-control-input discount" id="Tax-yes" value="1" <?php if($stores_info[0]->ip_tax_applicable=="1") {echo "checked";}?>>
                                                <label for="Tax-yes">Ward Group Wise Tax</label>
                                            </div>
                                       
                                            <div class="col-md-4 col-sm-12 ">
                                                <input type="radio" name="ip_tax" class="custom-control-input discount" id="Flat-no" value="2" <?php if($stores_info[0]->ip_tax_applicable=="2") {echo "checked";}?>>
                                                <label for="Flat-no">All Wards Flat (%)</label>
                                            </div>
                                            <div class="col-md-2 col-sm-12 ">
                                                <input type="text" class="form-control" name="All_Wards_Flat" value="<?php echo $stores_info[0]->ip_tax_all_ward_flat;?>">

                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group ">

                                        <div class="row">
                                        <div class="col-md-6 col-sm-12 ">
                                            <label class="control-label"><b>OT Tax Applicable </b></label>
                                            </div>
                                            <div class="col-md-6 col-sm-12 ">
                                            <label class="control-label "><b>OP Tax Applicable </b></label>
                                            </div>
                                        </div>
                                        <div class="row pl-2">
                                        <div class="col-md-6 col-sm-12 ">
                                        <input type="text" class=" " name="ot_tax_applicable" value="<?php echo $stores_info[0]->ot_tax_applicable;?>">
                                            </div>
                                            <div class="col-md-6 col-sm-12 ">
                                            <input type="text" class="" name="op_tax_applicable" value="<?php echo $stores_info[0]->op_tax_applicable;?>">
                                            </div>
                                        </div>

                                      
                                    </div>


                                    <hr>
                                    <div class="form-group ">
                                        <div>
                                            <label class="control-label"><b>Returns Applicable </b></label>
                                            <div class="row pl-2">
                                                <div class="col-md-4 col-sm-12 ">
                                                    <input type="radio" name="return_applicable" class="custom-control-input discount" id="Returns-yes" value="0" <?php if($stores_info[0]->returns_applicable=="0") {echo "checked";}?>>
                                                    <label for="Returns-yes">Yes</label>
                                                </div>
                                                <div class="col-md-3 col-sm-12 ">
                                                    <input type="radio" name="return_applicable" class="custom-control-input discount" id="Returns-no" value="1" <?php if($stores_info[0]->returns_applicable=="1") {echo "checked";}?>>
                                                    <label for="Returns-no">No</label>
                                                </div>

                                                <div class="col-md-4 col-sm-12 ">
                                                    <label>Days</label>
                                                    <input type="number" class="" name="return_applicable_days" value="<?php echo $stores_info[0]->returns_applicable_days ;?>">

                                                </div>

                                            </div>
                                            <div class="row pl-2">
                                                <div class="col-md-6 col-sm-12 ">
                                                    <label>Contract Days</label>
                                                    <input type="number" class="" name="contract_days" value="<?php echo $stores_info[0]->returns_applicable_contract_days ;?>">

                                                </div>
                                                <div class="col-md-6 col-sm-12 ">
                                                    <label>View Ledgers From</label>
                                                    <input type="number" class="" name="View_Ledgers" value="<?php echo $stores_info[0]->returns_applicable_view_ledger ;?>">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="form-group row align-items-center">

                                        <div class="col-md-6 col-sm-12 ">
                                            <div class=" col-sm-12 ">
                                                <input name="GST_Not_Applicable" class="custom-control-input favourite" value="1" type="checkbox" id="GST_customer" <?php if($stores_info[0]->gst_not_applicable=="1"){ echo 'checked="checked"'; }?>>
                                                <label for="GST_customer">GST Not Applicable</label>
                                            </div>
                                            <div class=" col-sm-12 ">
                                                <input name="Req_for_Discharge" class="custom-control-input favourite" value="1" type="checkbox" id="Discharge" <?php if($stores_info[0]->req_for_discharge=="1"){ echo 'checked="checked"'; }?>>
                                                <label for="Discharge">Req for Discharge Medication</label>
                                            </div>
                                            <div class=" col-sm-12 ">
                                                <input name="Item_Code_Editable" class="custom-control-input favourite" value="1" type="checkbox" id="Editable" <?php if($stores_info[0]->item_code_editable=="1"){ echo 'checked="checked"'; }?>>
                                                <label for="Editable">Item Code Editable</label>
                                            </div>
                                            <div class=" col-sm-12 ">
                                                <input name="Remarks" class="custom-control-input favourite" value="1" type="checkbox" id="Remarks" <?php if($stores_info[0]->is_remark=="1"){ echo 'checked="checked"'; }?>>
                                                <label for="Remarks">Is Remarks Req For Returns</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 ">
                                            <label>DM Discount (%)</label>
                                            <input type="number" class="" name="dm_discount" value="<?php echo $stores_info[0]->dm_discount; ?>">
                                        </div>

                                    </div>

                                    <hr>
                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>Rounding Value</b></label>
                                        <div class="row  pl-2">
                                        <div class="col-md-3 col-sm-12 ">
                                            <input type="radio" name="Rounding_Value" class="custom-control-input discount" value="0" id="Round-yes" <?php if($stores_info[0]->rounding_value=="0") {echo "checked";}?>>
                                            <label for="Round-yes">Round</label>
                                            </div>
                                            <div class="col-md-3 col-sm-12 ">
                                            <input type="radio" name="Rounding_Value" class="custom-control-input discount" value="1" id="Ceil-yes" <?php if($stores_info[0]->rounding_value=="1") {echo "checked";}?>>
                                            <label for="Ceil-yes">Ceil</label>
                                            </div>
                                            <div class="col-md-3 col-sm-12 ">
                                            <input type="radio" name="Rounding_Value" class="custom-control-input discount" value="2" id="Floor-yes" <?php if($stores_info[0]->rounding_value=="2") {echo "checked";}?>>
                                            <label for="Floor-yes">Floor</label>
                                            </div>
                                        </div>
                                        <div class="row  pl-2">
                                        <div class="col-md-3 col-sm-12 ">
                                            <input type="radio" name="round" class="custom-control-input discount" id="Round-25" value="0.25" <?php if($stores_info[0]->round=="0.25") {echo "checked";}?>>
                                            <label for="Round-25">.25</label>
                                            </div>
                                            <div class="col-md-3 col-sm-12 ">
                                            <input type="radio" name="round" class="custom-control-input discount" id="Ceil-50" value="0.50" <?php if($stores_info[0]->round=="0.50") {echo "checked";}?>>
                                            <label for="Ceil-50">.50</label>
                                            </div>
                                            <div class="col-md-3 col-sm-12 ">
                                            <input type="radio" name="round" class="custom-control-input discount" id="Floor-1" value="1.00" <?php if($stores_info[0]->round=="1.00") {echo "checked";}?>>
                                            <label for="Floor-1">1.00</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group ">
                                        <label class="control-label "><b>Less On Returns</b></label>
                                        <div class="row pl-2">
                                            <div class="col-md-4 col-sm-12 ">
                                                <input name="less_on_returns" class="custom-control-input favourite" value="1" type="radio" id="Returns_yes" <?php if($stores_info[0]->less_returns=="1") {echo "checked";}?>>
                                                <label for="Returns_yes">Yes</label>
                                            </div>
                                            <div class="col-md-4 col-sm-12 ">
                                                <input name="less_on_returns" class="custom-control-input favourite" value="1" type="radio" id="Returns_no" <?php if($stores_info[0]->round=="1") {echo "checked";}?>>
                                                <label for="Returns_no">No</label>
                                            </div>
                                        </div>
                                        <div class="row pl-2">
                                            <div class="col-md-4 col-sm-12 ">
                                                <input name="less_on_returns_option" class="custom-control-input favourite" value="1" type="radio" id="Returns_yes_per" <?php if($stores_info[0]->round=="1") {echo "checked";}?>>
                                                <label for="Returns_yes_per">%</label>
                                            </div>
                                            <div class="col-md-4 col-sm-12 ">
                                                <input name="less_on_returns_option" class="custom-control-input favourite" value="1" type="radio" id="Returns_yes_cash" <?php if($stores_info[0]->round=="1") {echo "checked";}?>>
                                                <label for="Returns_yes_cash">Cash</label>
                                            </div>
                                            <div class="col-md-4 col-sm-12 ">
                                                <input type="number" class="form-control" name="less_on_returns_val" value="<?php echo $stores_info[0]->less_returns_val;  ?>"> (%)
                                             
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <?php
                                        $direct_approve =  explode(",",$stores_info[0]->direct_approve); 
                     
                                    ?>

                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>Direct Approve</b></label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 ">

                                                <div class=" col-sm-12 ">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="0" type="checkbox" id="Goods_Receipts" <?php if(in_array("0", $direct_approve)){ echo 'checked="checked"'; }?>>
                                                    <label for="Goods_Receipts">Goods Receipts Note (GRN)</label>
                                                </div>
                                                <div class=" col-sm-12 ">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="1" type="checkbox" id="GIN" <?php if(in_array("1", $direct_approve)){ echo 'checked="checked"'; }?>>
                                                    <label for="GIN">Goods Issue Note (GIN)</label>
                                                </div>
                                                <div class=" col-sm-12 ">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="2" type="checkbox" id="NRDC" <?php if(in_array("2", $direct_approve)){ echo 'checked="checked"'; }?>>
                                                    <label for="NRDC">Non Returnable Delivery Challan (NRDC)</label>
                                                </div>
                                                <div class=" col-sm-12 ">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="3" type="checkbox" id="Department_Adjustment" <?php if(in_array("3", $direct_approve)){ echo 'checked="checked"'; }?>> 
                                                    <label for="Department_Adjustment">Department Adjustment Note</label>
                                                </div>
                                                <div class=" col-sm-12 ">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="4" type="checkbox" id="RDC" <?php if(in_array("4", $direct_approve)){ echo 'checked="checked"'; }?>>
                                                    <label for="RDC">Returnable Delivery Challan (RDC)</label>
                                                </div>
                                                <div class=" col-sm-12 ">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="5" type="checkbox" id="RDR" <?php if(in_array("5", $direct_approve)){ echo 'checked="checked"'; }?>>
                                                    <label for="RDR">Returnable Delivery Challan Returns (RDR)</label>
                                                </div>
                                                <div class=" col-sm-12 ">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="6" type="checkbox" id="Courier_Entry" <?php if(in_array("6", $direct_approve)){ echo 'checked="checked"'; }?>>
                                                    <label for="Courier_Entry">Courier Entry Details</label>
                                                </div>
                                                <div class=" col-sm-12 ">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="7" type="checkbox" id="Purchase_Indent" <?php if(in_array("7", $direct_approve)){ echo 'checked="checked"'; }?>>
                                                    <label for="Purchase_Indent">Purchase Indent Cancel</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 ">
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="8" type="checkbox" id="PO" <?php if(in_array("8", $direct_approve)){ echo 'checked="checked"'; }?>>
                                                    <label for="PO">Purchase Order (PO)</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="9" type="checkbox" id="MRN" <?php if(in_array("9", $direct_approve)){ echo 'checked="checked"'; }?>>
                                                    <label for="MRN">Material Return Note (MRN)</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="10" type="checkbox" id="NRQ" <?php if(in_array("10", $direct_approve)){ echo 'checked="checked"'; }?>>
                                                    <label for="NRQ">Nurse Requisition (NRQ)</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="11" type="checkbox" id="MRQ" <?php if(in_array("11", $direct_approve)){ echo 'checked="checked"'; }?>>
                                                    <label for="MRQ">Material Requisition (MRQ)</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="12" type="checkbox" id="SCN" <?php if(in_array("12", $direct_approve)){ echo 'checked="checked"'; }?>>
                                                    <label for="SCN">Scrap Note (SCN)</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="13" type="checkbox" id="Patient_Returns" <?php if(in_array("13", $direct_approve)){ echo 'checked="checked"'; }?>>
                                                    <label for="Patient_Returns">Patient Returns</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="14" type="checkbox" id="Material_Requisition" <?php if(in_array("14", $direct_approve)){ echo 'checked="checked"'; }?>>
                                                    <label for="Material_Requisition">Material Requisition Cancel</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="15" type="checkbox" id="Purchase_Order" <?php if(in_array("15", $direct_approve)){ echo 'checked="checked"'; }?>>
                                                    <label for="Purchase_Order">Purchase Order Cancel</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php
                                        $lock_indents =  explode(",",$stores_info[0]->lock_indents); 
                                      
                                       
                                    ?>
                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>Lock Indents</b></label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 ">
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="Lock_Indents[]" class="custom-control-input favourite" value="0" type="checkbox" id="Goods_Receipts_Note" <?php if(in_array("0", $lock_indents)){ echo 'checked="checked"'; }?>>
                                                    <label for="Goods_Receipts_Note">Goods Receipts Note</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="Lock_Indents[]" class="custom-control-input favourite" value="1" type="checkbox" id="Stock_Point_Billing" <?php if(in_array("1", $lock_indents)){ echo 'checked="checked"'; }?>>
                                                    <label for="Stock_Point_Billing">Stock Point Billing to Patient</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12 ">
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="Lock_Indents[]" class="custom-control-input favourite" value="2" type="checkbox" id="Goods_Issue_Note" <?php if(in_array("2", $lock_indents)){ echo 'checked="checked"'; }?>>
                                                    <label for="Goods_Issue_Note">Goods Issue Note</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="Lock_Indents[]" class="custom-control-input favourite" value="3" type="checkbox" id="Department_Billing" <?php if(in_array("3", $lock_indents)){ echo 'checked="checked"'; }?>>
                                                    <label for="Department_Billing">Department Billing to Patient</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group ">

                                        <div class="row">
                                            <div class="col-md-8 col-sm-12 ">
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="Lock_Indents[]" class="custom-control-input favourite" value="4" type="checkbox" id="Material_Return" <?php if(in_array("4", $lock_indents)){ echo 'checked="checked"'; }?>>
                                                    <label for="Material_Return">Material Return Note Days in Goods Issue Note</label>
                                                </div>

                                            </div>

                                            <div class="col-md-4 col-sm-12 ">

                                                <input type="number" name="look_indent_val" value="<?php echo $stores_info[0]->look_indents_val;?>">
                                            </div>

                                        </div>
                                    </div>

                                   <?php
                                        $by_default_active = explode(",", $stores_info[0]->by_default_active);
                                   ?>

<hr>
                                        <div class="col-md-12 col-sm-12 ">

                                            <div class="form-group ">
                                                <label class="control-label text-left  col-sm-12 pl-0"><b>By Default Active Yes/No </b></label>
                                                <div class="row  pl-2">
                                                <div class="col-md-4 col-sm-12">
                                                    <input name="By_Default[]" class="custom-control-input favourite" value="0" type="checkbox" id="Item_Master" <?php if(in_array("0", $by_default_active)){ echo 'checked="checked"'; }?>>
                                                    <label for="Item_Master">Item Master</label>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <input name="By_Default[]" class="custom-control-input favourite" value="1" type="checkbox" id="Manufacturer_Master" <?php if(in_array("1", $by_default_active)){ echo 'checked="checked"'; }?>>
                                                    <label for="Manufacturer_Master">Manufacturer Master </label>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <input name="By_Default[]" class="custom-control-input favourite" value="2" type="checkbox" id="Item_Expiry" <?php if(in_array("2", $by_default_active)){ echo 'checked="checked"'; }?>>
                                                    <label for="Item_Expiry">Item Expiry Profile Master</label>
                                                </div>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>
                                        <div class="col-md-12 col-sm-12 ">

                                            <div class="form-group ">

                                                <label class="control-label text-left  col-sm-12 pl-0"><b>Indents Settings </b></label>
                                                <div class="col-md-12 col-sm-12 row">
                                                    <div class=" col-sm-6 ">
                                                        <input name="Nurse_Indents" class="custom-control-input favourite" value="1" type="checkbox" id="Nurse_Indents" <?php if($stores_info[0]->nurse_indent=="1"){ echo 'checked="checked"'; }?>>
                                                        <label for="Nurse_Indents">Nurse Indents</label>
                                                    </div>
                                                    <div class=" col-sm-2 ">

                                                        <input type="number" name = "Nurse_Indents_val" value="<?php echo $stores_info[0]->indent_setting_nurse_val; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 row">
                                                    <div class=" col-sm-6 ">
                                                        <input name="Purchase_Order" class="custom-control-input favourite" value="1" type="checkbox" id="Purchase_Order1" <?php if($stores_info[0]->purchase_order=="1"){ echo 'checked="checked"'; }?>>
                                                        <label for="Purchase_Order1">Purchase Order </label>
                                                    </div>
                                                    <div class=" col-sm-2 ">

                                                        <input type="number" name="Purchase_Order_val" value="<?php echo $stores_info[0]->	indent_setting_purchase_val; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 row">
                                                    <div class=" col-sm-6 ">
                                                        <input name="Dept_Indents" class="custom-control-input favourite" value="1" type="checkbox" id="Dept_Indents" <?php if($stores_info[0]->dept_order=="1"){ echo 'checked="checked"'; }?>>
                                                        <label for="Dept_Indents">Dept Indents</label>
                                                    </div>
                                                    <div class=" col-sm-2 ">

                                                        <input type="number" name="Dept_Indents_val" value="<?php echo $stores_info[0]->indent_setting_dept_val;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="Casuality" class="custom-control-input favourite" value="1" type="checkbox" id="Casuality" <?php if($stores_info[0]->casulality=="1"){ echo 'checked="checked"'; }?>>
                                                    <label for="Casuality">Is Casuality</label>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>

                                      
                                        <div class="form-group col-sm-12 pl-4">
                                            <label class="control-label text-left  col-sm-12 pl-0"><b>Item Search With</b></label>
                                            <div class="row pl-2">
                                                <div class="col-md-4 col-sm-12 ">
                                                    <input name="Item_Search" class="custom-control-input favourite" value="0" type="radio" id="Item_Cd" <?php if($stores_info[0]->item_search=="0") {echo "checked";}?>>
                                                    <label for="Item_Cd">Item Cd</label>
                                                </div>
                                                <div class="col-md-4 col-sm-12 ">
                                                    <input name="Item_Search" class="custom-control-input favourite" value="1" type="radio" id="Item_Name" <?php if($stores_info[0]->item_search=="1") {echo "checked";}?>>
                                                    <label for="Item_Name">Item Name</label>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>
                                        <div class="form-group col-sm-12 pl-4">
                                            <label class="control-label text-left  col-sm-12 pl-0"><b>MRQ Indents</b></label>
                                            <div class="row pl-2">
                                                <div class="col-md-4 col-sm-12 ">
                                                    <input name="MRQ_Indents" class="custom-control-input favourite" value="0" type="radio" id="Auto" <?php if($stores_info[0]->mrq_indent=="0") {echo "checked";}?>>
                                                    <label for="Auto">Auto </label>
                                                </div>
                                                <div class="col-md-4 col-sm-12 ">
                                                    <input name="MRQ_Indents" class="custom-control-input favourite" value="1" type="radio" id="Manual" <?php if($stores_info[0]->mrq_indent=="1") {echo "checked";}?>>
                                                    <label for="Manual">Manual</label>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>

                                        <?php 
                                            $mandatory_field =  explode(",", $stores_info[0]->mandatory_field);
                                        ?>
                                        <div class="form-group col-sm-12 pl-4">
                                            <label class="control-label text-left  col-sm-12 pl-0"><b>Mandatory Fields</b></label>
                                            <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                            <div class="col-md-12 col-sm-12">
                                                <input name="Mandatory_Fields[]" class="custom-control-input favourite" value="0" type="checkbox" id="Dispenser_Cd" <?php if(in_array("0", $mandatory_field)){ echo 'checked="checked"'; }?>>
                                                <label for="Dispenser_Cd">Dispenser Cd In OP Billing </label>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <input name="Mandatory_Fields[]" class="custom-control-input favourite" value="1" type="checkbox" id="Doctor_Cd" <?php if(in_array("1", $mandatory_field)){ echo 'checked="checked"'; }?>>
                                                <label for="Doctor_Cd">Doctor Cd In OP Billing </label>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <input name="Mandatory_Fields[]" class="custom-control-input favourite" value="2" type="checkbox" id="Remarks_In" <?php if(in_array("2", $mandatory_field)){ echo 'checked="checked"'; }?>>
                                                <label for="Remarks_In">Remarks In OP Billing </label>
                                            </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                            <div class="col-md-12 col-sm-12">
                                                <input name="Mandatory_Fields[]" class="custom-control-input favourite" value="3" type="checkbox" id="Indent_in" <?php if(in_array("3", $mandatory_field)){ echo 'checked="checked"'; }?>>
                                                <label for="Indent_in">Indent in PO </label>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <input name="Mandatory_Fields[]" class="custom-control-input favourite" value="4" type="checkbox" id="Req_Dt" <?php if(in_array("4", $mandatory_field)){ echo 'checked="checked"'; }?>>
                                                <label for="Req_Dt">Req Dt In Manual Indent </label>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <input name="Mandatory_Fields[]" class="custom-control-input favourite" value="5" type="checkbox" id="PO_In_Goods" <?php if(in_array("5", $mandatory_field)){ echo 'checked="checked"'; }?>>
                                                <label for="PO_In_Goods">PO In Goods Receipts Note </label>
                                            </div>
                                            </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group col-sm-12 pl-4">
                                            <label class="control-label text-left  col-sm-12 pl-0"><b>Bar Code Settings</b></label>
                                            <div class="col-md-12 col-sm-12 row">
                                                <div class=" col-sm-6 ">
                                                    <input name="Bar_Code" class="custom-control-input favourite" value="1" type="checkbox" id="Bar_Code" <?php if($stores_info[0]->bar_code=="1"){ echo 'checked="checked"'; }?>>
                                                    <label for="Bar_Code">Bar Code</label>
                                                </div>
                                                <div class=" col-sm-2 ">

                                                    <input type="number" name="Bar_Code_val" value="<?php echo  $stores_info[0]->bar_code_val; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 row">
                                                <div class=" col-sm-6 ">
                                                    <input name="Barcode_Labels" class="custom-control-input favourite" value="1" type="checkbox" id="Barcode_Labels" <?php if($stores_info[0]->barcode_label=="1"){ echo 'checked="checked"'; }?>>
                                                    <label for="Barcode_Labels">Barcode Labels</label>
                                                </div>
                                                <div class=" col-sm-2 ">

                                                    <input type="number" name="Barcode_Labels_val" value="<?php echo  $stores_info[0]->barcode_label_val; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 row">
                                                <div class=" col-sm-6 ">
                                                    <input name="Wireless_Device" class="custom-control-input favourite" value="1" type="checkbox" id="Wireless_Device" <?php if($stores_info[0]->wireless_device=="1"){ echo 'checked="checked"'; }?>>
                                                    <label for="Wireless_Device">Wireless Device</label>
                                                </div>
                                                <div class=" col-sm-2 ">

                                                    <input type="number" name="Wireless_Device_val" value="<?php echo  $stores_info[0]->wireless_device_val; ?>">
                                                </div>
                                            </div>


                                        </div>
                                 
                                </div>
                            </div>
                            <div class="form-actions text-center">
                    <div class="row">
                        <div class=" col-md-12 ">
                            <div class="form-group">
                                <button type="submit" class="btn btn-info" id="submit_btn">Submit</button>
                                <button type="button" class="btn btn-inverse">Cancel</button>
                            </div>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
                </form>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('backend/footer');
?>


    <script>
    $('#submit_btn').click(function(){
              
                window.setTimeout(function() {
                    window.location = "<?php echo base_url();?>Store/manage_stores";
                }, 3000);         
    });

    </script>
<script>
        function disableSubmitButton() {
        document.getElementById("submit_btn").disabled = true;
        }
</script>


