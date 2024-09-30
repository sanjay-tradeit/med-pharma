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
                        <h4 class="m-b-0 text-white">Store<span class="pull-right"><?php date_default_timezone_set("Asia/Kolkata");
                                                                                                    echo date("l jS \of F Y h:i:s A") ?></span></h4>
                    </div>
                    <div id="success_msg">
                      <?php $success = $this->session->flashdata('success'); 
                          if(!empty($success)){
                            echo $success;
                          }
                      ?>
                     </div>
                    <div class="card-body add-store-card">

                        <form action="<?php echo base_url('Store/add_new_store'); ?>" method="POST" onsubmit="disableSubmitButton()">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>Store Name</b></label>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                            <div class="d-flex"> <input type="text" class="form-control" placeholder="Store-id" id="store_id" name="store_id" > <span class="text-danger required-icon">*</span></div> 
                                                <span id="store_id_error" class="text-danger"></span>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                            <div class="d-flex"> <input type="text" class="form-control" placeholder="Store-name" id="store_name" name="store_name" > <span class="text-danger required-icon">*</span></div> 
                                                <span id="store_name_error" class="text-danger"></span>
                                            </div>
                                            <div class="col-md-4 col-sm-12 ">

                                                <input type="text" class="form-control" placeholder="Alias" id="store_alias" name="store_alias" >
                                                <span id="store_alias_error" class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>Store Type</b></label>

                                        <div class="row pl-2">
                                           <div class="col-sm-3">
                                                <input type="radio" name="store_type" class="custom-control-input discount" id="main-yes" value="0" checked>
                                                <label for="main-yes">Main</label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="radio" name="store_type" class="custom-control-input discount" id="sub-yes" value="1">
                                                <label for="sub-yes">Sub</label>
                                            </div>
                                        </div>


                                    </div>
                                    <hr>
                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>Transaction Type</b></label>
                                        <div class="row pl-2">
                                            <div class="col-sm-3">
                                                    <input name="Transaction_Type[]" class="custom-control-input favourite" value="0" type="checkbox" id="icu_customer">
                                                    <label for="icu_customer">ICU</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input name="Transaction_Type[]" class="custom-control-input favourite" value="1" type="checkbox" id="Ward_customer">
                                                    <label for="Ward_customer">Ward</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input name="Transaction_Type[]" class="custom-control-input favourite" value="2" type="checkbox" id="OT_customer">
                                                    <label for="OT_customer">OT</label>
                                                </div>
                                        </div>
                                        <div class="row pl-2">
                                            <div class="col-sm-3">
                                                    <input type="radio" name="medical_type" class="custom-control-input discount" id="Medical-yes" value="0" checked>
                                                    <label for="Medical-yes">Medical</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="radio" name="medical_type" class="custom-control-input discount" id="Non-Medical-yes" value="1">
                                                    <label for="Non-Medical-yes">Non-Medical</label>
                                                </div>
                                        </div>


                                    </div>
                                    <hr>
                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>Payment Type</b></label>
                                        <div class="row pl-2">
                                            <div class="col-sm-3">
                                                    <input type="radio" name="payment_type" class="custom-control-input discount" id="Cash-yes" value="0" checked>
                                                    <label for="Cash-yes">Cash</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="radio" name="payment_type" class="custom-control-input discount" id="Credit-yes" value="1">
                                                    <label for="Credit-yes">Credit</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="radio" name="payment_type" class="custom-control-input discount" id="Both-yes" value="2">
                                                    <label for="Both-yes">Both</label>
                                                </div>
                                        </div>

                                    </div>

                                    <hr>
                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>Discount Facility</b></label>
                                        <div class="row align-items-center pl-2">
                                            <div class="col-md-4 col-sm-12 ">
                                                <input name="Discount_Facility" class="custom-control-input favourite" value="1" type="checkbox" id="Discount_Facility">
                                                <label for="Discount_Facility">Discount (%)</label>
                                            </div>
                                            <div class="col-md-2 col-sm-12 ">
                                                <input type="number" class="form-control" name="discount_facility_value">

                                            </div>
                                      
                                            <div class="col-md-4 col-sm-12 ">
                                                <input name="doc_dis" class="custom-control-input favourite" value="1" type="checkbox" id="Doctor_Discount">
                                                <label for="Doctor_Discount">Doctor Discount (%)</label>
                                            </div>
                                            <div class="col-md-2 col-sm-12 ">
                                                <input type="number" class="form-control" name="Doctor_Discount_val">

                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>IP Tax Applicable</b></label>
                                        <div class="row pl-2">
                                            <div class="col-md-2 col-sm-12 ">
                                                <input type="radio" name="ip_tax" class="custom-control-input discount" id="Cash-no" value="0" checked>
                                                <label for="Cash-no">No</label>
                                            </div>
                                            <div class="col-md-4 col-sm-12 ">
                                                <input type="radio" name="ip_tax" class="custom-control-input discount" id="Tax-yes" value="1">
                                                <label for="Tax-yes">Ward Group Wise Tax</label>
                                            </div>
                                       
                                            <div class="col-md-4 col-sm-12 ">
                                                <input type="radio" name="ip_tax" class="custom-control-input discount" id="Flat-no" value="2">
                                                <label for="Flat-no">All Wards Flat (%)</label>
                                            </div>
                                            <div class="col-md-2 col-sm-12 ">
                                                <input type="number" class="form-control" name="All_Wards_Flat">

                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group ">
                                        <div class="row">
                                        <div class="col-md-6 col-sm-12 ">

                                            <label class="control-label  pl-0"><b>OT Tax Applicable </b></label>
                                            </div>
                                            <div class="col-md-6 col-sm-12 ">
                                            <label class="control-label  pl-0"><b>OP Tax Applicable </b></label>
                                            </div>
                                        </div>
                                        <div class="row pl-2">
                                        <div class="col-md-6 col-sm-12 ">
                                            <input type="text" class=" " name="ot_tax_applicable">
                                            </div>
                                            <div class="col-md-6 col-sm-12 ">
                                            <input type="text" class="" name="op_tax_applicable">
                                            </div>
                                        </div>
                                    </div>


                                    <hr>
                                    <div class="form-group ">
                                        <div class=" ">
                                            <label class="control-label "><b>Returns Applicable </b></label>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-12 ">
                                                    <input type="radio" name="return_applicable" class="custom-control-input discount" id="Returns-yes" value="0" checked>
                                                    <label for="Returns-yes">Yes</label>
                                                </div>
                                                <div class="col-md-3 col-sm-12 ">
                                                    <input type="radio" name="return_applicable" class="custom-control-input discount" id="Returns-no" value="1">
                                                    <label for="Returns-no">No</label>
                                                </div>

                                                <div class="col-md-4 col-sm-12 ">
                                                    <label>Days</label>
                                                    <input type="number" class="" name="return_applicable_days">

                                                </div>

                                            </div>
                                            <div class="row pl-2">
                                                <div class="col-md-6 col-sm-12 ">
                                                    <label>Contract Days</label>
                                                    <input type="number" class="" name="contract_days">

                                                </div>
                                                <div class="col-md-6 col-sm-12 ">
                                                    <label>View Ledgers From</label>
                                                    <input type="number" class="" name="View_Ledgers">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="form-group row align-items-center">

                                        <div class="col-md-6 col-sm-12 ">
                                            <div class=" col-sm-12 ">
                                                <input name="GST_Not_Applicable" class="custom-control-input favourite" value="1" type="checkbox" id="GST_customer">
                                                <label for="GST_customer">GST Not Applicable</label>
                                            </div>
                                            <div class=" col-sm-12 ">
                                                <input name="Req_for_Discharge" class="custom-control-input favourite" value="1" type="checkbox" id="Discharge">
                                                <label for="Discharge">Req for Discharge Medication</label>
                                            </div>
                                            <div class=" col-sm-12 ">
                                                <input name="Item_Code_Editable" class="custom-control-input favourite" value="1" type="checkbox" id="Editable">
                                                <label for="Editable">Item Code Editable</label>
                                            </div>
                                            <div class=" col-sm-12 ">
                                                <input name="Remarks" class="custom-control-input favourite" value="1" type="checkbox" id="Remarks">
                                                <label for="Remarks">Is Remarks Req For Returns</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 ">
                                            <label>DM Discount (%)</label>
                                            <input type="number" class="" name="dm_discount">
                                        </div>

                                    </div>

                                    <hr>
                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>Rounding Value</b></label>
                                        <div class="row  pl-2">
                                            <div class="col-sm-3">
                                                    <input type="radio" name="Rounding_Value" class="custom-control-input discount" value="0" id="Round-yes" checked>
                                                    <label for="Round-yes">Round</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="radio" name="Rounding_Value" class="custom-control-input discount" value="1" id="Ceil-yes">
                                                    <label for="Ceil-yes">Ceil</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="radio" name="Rounding_Value" class="custom-control-input discount" value="2" id="Floor-yes">
                                                    <label for="Floor-yes">Floor</label>
                                                </div>
                                        </div>
                                        <div class="row  pl-2">
                                        <div class="col-sm-3">
                                            <input type="radio" name="round" class="custom-control-input discount" id="Round-25" value=".025" checked>
                                            <label for="Round-25">.25</label>
                                            </div>
                                            <div class="col-sm-3">
                                            <input type="radio" name="round" class="custom-control-input discount" id="Ceil-50" value="0.50">
                                            <label for="Ceil-50">.50</label>
                                            </div>
                                            <div class="col-sm-3">
                                            <input type="radio" name="round" class="custom-control-input discount" id="Floor-1" value="1.00">
                                            <label for="Floor-1">1.00</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group ">
                                        <label class="control-label "><b>Less On Returns</b></label>
                                        <div class="row pl-2">
                                            <div class="col-md-4 col-sm-12 ">
                                                <input name="less_on_returns" class="custom-control-input favourite" value="1" type="radio" id="Returns_yes" checked>
                                                <label for="Returns_yes">Yes</label>
                                            </div>
                                            <div class="col-md-4 col-sm-12 ">
                                                <input name="less_on_returns" class="custom-control-input favourite" value="1" type="radio" id="Returns_no">
                                                <label for="Returns_no">No</label>
                                            </div>
                                        </div>
                                        <div class="row pl-2">
                                            <div class="col-md-4 col-sm-12 ">
                                                <input name="less_on_returns_option" class="custom-control-input favourite" value="1" type="radio" id="Returns_yes_per">
                                                <label for="Returns_yes_per">%</label>
                                            </div>
                                            <div class="col-md-4 col-sm-12 ">
                                                <input name="less_on_returns_option" class="custom-control-input favourite" value="1" type="radio" id="Returns_yes_cash">
                                                <label for="Returns_yes_cash">Cash</label>
                                            </div>
                                            <div class="col-md-4 col-sm-12 ">
                                                <input type="number" class="form-control" name="less_on_returns_val">
                                                <label for="Doctor_Discount_customer mr-3"> (%)</label>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-6 col-sm-12">

                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>Direct Approve</b></label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 ">

                                                <div class=" col-sm-12 ">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="0" type="checkbox" id="Goods_Receipts">
                                                    <label for="Goods_Receipts">Goods Receipts Note (GRN)</label>
                                                </div>
                                                <div class=" col-sm-12 ">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="1" type="checkbox" id="GIN">
                                                    <label for="GIN">Goods Issue Note (GIN)</label>
                                                </div>
                                                <div class=" col-sm-12 ">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="2" type="checkbox" id="NRDC">
                                                    <label for="NRDC">Non Returnable Delivery Challan (NRDC)</label>
                                                </div>
                                                <div class=" col-sm-12 ">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="3" type="checkbox" id="Department_Adjustment">
                                                    <label for="Department_Adjustment">Department Adjustment Note</label>
                                                </div>
                                                <div class=" col-sm-12 ">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="4" type="checkbox" id="RDC">
                                                    <label for="RDC">Returnable Delivery Challan (RDC)</label>
                                                </div>
                                                <div class=" col-sm-12 ">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="5" type="checkbox" id="RDR">
                                                    <label for="RDR">Returnable Delivery Challan Returns (RDR)</label>
                                                </div>
                                                <div class=" col-sm-12 ">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="6" type="checkbox" id="Courier_Entry">
                                                    <label for="Courier_Entry">Courier Entry Details</label>
                                                </div>
                                                <div class=" col-sm-12 ">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="7" type="checkbox" id="Purchase_Indent">
                                                    <label for="Purchase_Indent">Purchase Indent Cancel</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 ">
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="8" type="checkbox" id="PO">
                                                    <label for="PO">Purchase Order (PO)</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="9" type="checkbox" id="MRN">
                                                    <label for="MRN">Material Return Note (MRN)</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="10" type="checkbox" id="NRQ">
                                                    <label for="NRQ">Nurse Requisition (NRQ)</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="11" type="checkbox" id="MRQ">
                                                    <label for="MRQ">Material Requisition (MRQ)</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="12" type="checkbox" id="SCN">
                                                    <label for="SCN">Scrap Note (SCN)</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="13" type="checkbox" id="Patient_Returns">
                                                    <label for="Patient_Returns">Patient Returns</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="14" type="checkbox" id="Material_Requisition">
                                                    <label for="Material_Requisition">Material Requisition Cancel</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="direct_approve[]" class="custom-control-input favourite" value="15" type="checkbox" id="Purchase_Order">
                                                    <label for="Purchase_Order">Purchase Order Cancel</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group ">
                                        <label class="control-label text-left col-md-3 col-sm-12 pl-0"><b>Lock Indents</b></label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 ">
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="Lock_Indents[]" class="custom-control-input favourite" value="0" type="checkbox" id="Goods_Receipts_Note">
                                                    <label for="Goods_Receipts_Note">Goods Receipts Note</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="Lock_Indents[]" class="custom-control-input favourite" value="1" type="checkbox" id="Stock_Point_Billing">
                                                    <label for="Stock_Point_Billing">Stock Point Billing to Patient</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12 ">
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="Lock_Indents[]" class="custom-control-input favourite" value="2" type="checkbox" id="Goods_Issue_Note">
                                                    <label for="Goods_Issue_Note">Goods Issue Note</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="Lock_Indents[]" class="custom-control-input favourite" value="3" type="checkbox" id="Department_Billing">
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
                                                    <input name="Lock_Indents[]" class="custom-control-input favourite" value="4" type="checkbox" id="Material_Return">
                                                    <label for="Material_Return">Material Return Note Days in Goods Issue Note</label>
                                                </div>

                                            </div>

                                            <div class="col-md-4 col-sm-12 ">

                                                <input type="number" name="look_indent_val">
                                            </div>

                                        </div>
                                    </div>



                                   <hr>
                                        <div class="col-md-12 col-sm-12 ">

                                            <div class="form-group ">
                                                <label class="control-label text-left  col-sm-12 pl-0"><b>By Default Active Yes/No </b></label>
                                                <div class="row pl-2">
                                                <div class="col-md-4 col-sm-12">
                                                    <input name="By_Default[]" class="custom-control-input favourite" value="0" type="checkbox" id="Item_Master">
                                                    <label for="Item_Master">Item Master</label>
                                                </div>


                                                <div class="col-md-4 col-sm-12">
                                                    <input name="By_Default[]" class="custom-control-input favourite" value="1" type="checkbox" id="Manufacturer_Master">
                                                    <label for="Manufacturer_Master">Manufacturer Master </label>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <input name="By_Default[]" class="custom-control-input favourite" value="2" type="checkbox" id="Item_Expiry">
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
                                                        <input name="Nurse_Indents" class="custom-control-input favourite" value="1" type="checkbox" id="Nurse_Indents">
                                                        <label for="Nurse_Indents">Nurse Indents</label>
                                                    </div>
                                                    <div class=" col-sm-2 ">

                                                        <input type="number" name = "Nurse_Indents_val">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 row">
                                                    <div class=" col-sm-6 ">
                                                        <input name="Purchase_Order" class="custom-control-input favourite" value="1" type="checkbox" id="Purchase_Order1">
                                                        <label for="Purchase_Order1">Purchase Order </label>
                                                    </div>
                                                    <div class=" col-sm-2 ">

                                                        <input type="number" name="Purchase_Order_val">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 row">
                                                    <div class=" col-sm-6 ">
                                                        <input name="Dept_Indents" class="custom-control-input favourite" value="1" type="checkbox" id="Dept_Indents">
                                                        <label for="Dept_Indents">Dept Indents</label>
                                                    </div>
                                                    <div class=" col-sm-2 ">

                                                        <input type="number" name="Dept_Indents_val">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <input name="Casuality" class="custom-control-input favourite" value="1" type="checkbox" id="Casuality">
                                                    <label for="Casuality">Is Casuality</label>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>

                                    
                                        <div class="form-group col-sm-12 pl-4">
                                            <label class="control-label text-left  col-sm-12 pl-0"><b>Item Search With</b></label>
                                            <div class="row pl-2">
                                                <div class="col-md-4 col-sm-12 ">
                                                    <input name="Item_Search" class="custom-control-input favourite" value="0" type="radio" id="Item_Cd" checked>
                                                    <label for="Item_Cd">Item Cd</label>
                                                </div>
                                                <div class="col-md-4 col-sm-12 ">
                                                    <input name="Item_Search" class="custom-control-input favourite" value="1" type="radio" id="Item_Name">
                                                    <label for="Item_Name">Item Name</label>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>
                                        <div class="form-group col-sm-12 pl-4">
                                            <label class="control-label text-left  col-sm-12 pl-0"><b>MRQ Indents</b></label>
                                            <div class="row pl-2">
                                                <div class="col-md-4 col-sm-12 ">
                                                    <input name="MRQ_Indents" class="custom-control-input favourite" value="0" type="radio" id="Auto" checked>
                                                    <label for="Auto">Auto </label>
                                                </div>
                                                <div class="col-md-4 col-sm-12 ">
                                                    <input name="MRQ_Indents" class="custom-control-input favourite" value="1" type="radio" id="Manual">
                                                    <label for="Manual">Manual</label>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>
                                        <div class="form-group col-sm-12 pl-4">
                                            <label class="control-label text-left  col-sm-12 pl-0"><b>Mandatory Fields</b></label>
                                            <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                    <div class="col-md-12 col-sm-12">
                                                        <input name="Mandatory_Fields[]" class="custom-control-input favourite" value="0" type="checkbox" id="Dispenser_Cd">
                                                        <label for="Dispenser_Cd">Dispenser Cd In OP Billing </label>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <input name="Mandatory_Fields[]" class="custom-control-input favourite" value="1" type="checkbox" id="Doctor_Cd">
                                                        <label for="Doctor_Cd">Doctor Cd In OP Billing </label>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <input name="Mandatory_Fields[]" class="custom-control-input favourite" value="2" type="checkbox" id="Remarks_In">
                                                        <label for="Remarks_In">Remarks In OP Billing </label>
                                                    </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                    <div class="col-md-12 col-sm-12">
                                                        <input name="Mandatory_Fields[]" class="custom-control-input favourite" value="3" type="checkbox" id="Indent_in">
                                                        <label for="Indent_in">Indent in PO </label>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <input name="Mandatory_Fields[]" class="custom-control-input favourite" value="4" type="checkbox" id="Req_Dt">
                                                        <label for="Req_Dt">Req Dt In Manual Indent </label>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <input name="Mandatory_Fields[]" class="custom-control-input favourite" value="5" type="checkbox" id="PO_In_Goods">
                                                        <label for="PO_In_Goods">PO In Goods Receipts Note </label>
                                                    </div>

                                            </div> </div>
                                        </div>
                                        <hr>
                                        <div class="form-group col-sm-12 pl-4">
                                            <label class="control-label text-left  col-sm-12 pl-0"><b>Bar Code Settings</b></label>
                                            <div class="col-md-12 col-sm-12 row">
                                                <div class=" col-sm-6 ">
                                                    <input name="Bar_Code" class="custom-control-input favourite" value="1" type="checkbox" id="Bar_Code">
                                                    <label for="Bar_Code">Bar Code</label>
                                                </div>
                                                <div class=" col-sm-2 ">

                                                    <input type="number" name="Bar_Code_val">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 row">
                                                <div class=" col-sm-6 ">
                                                    <input name="Barcode_Labels" class="custom-control-input favourite" value="1" type="checkbox" id="Barcode_Labels">
                                                    <label for="Barcode_Labels">Barcode Labels</label>
                                                </div>
                                                <div class=" col-sm-2 ">

                                                    <input type="number" name="Barcode_Labels_val">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 row">
                                                <div class=" col-sm-6 ">
                                                    <input name="Wireless_Device" class="custom-control-input favourite" value="1" type="checkbox" id="Wireless_Device">
                                                    <label for="Wireless_Device">Wireless Device</label>
                                                </div>
                                                <div class=" col-sm-2 ">

                                                    <input type="number" name="Wireless_Device_val">
                                                </div>
                                            </div>


                                        </div>
                                  
                                </div>
                            </div>
                            <div class="form-actions text-center mt-5">
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
    <footer class="footer"> © <?php echo date("Y");?> Med Jacket</footer>
</div>
<?php
$this->load->view('backend/footer');
?>


<script>
   
       
    $('#submit_btn').click(function(event){

        
      //  event.preventDefault();
        var store_id = $('#store_id').val(); 
        var store_name = $('#store_name').val(); 
       
        if (store_id.trim() === '') {
            event.preventDefault();
            $('#store_id_error').html('Fill the Store_id');
            
        } 
        else if(store_name.trim() === ''){
            event.preventDefault();
            $('#store_id_error').html('');
            $('#store_name_error').html('Fill the Store name');
        }
 
        else {
           
            window.setTimeout(function() {
                window.location = "<?php echo base_url();?>Store/manage_stores";
            }, 3000);
        }
    });
</script>

    <script>
        setTimeout(function(){
        $('#success_msg').remove();
        }, 1000);
    </script>

<script>
        function disableSubmitButton() {
         
            document.getElementById("submit_btn").disabled = true;
        }
</script>


