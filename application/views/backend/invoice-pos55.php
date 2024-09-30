<?php
$this->load->view('backend/header');
$this->load->view('backend/sidebar');
$CI =& get_instance();

$doctors = $CI->getdoctors();
//print_r($doctors);
$doc_array = array();
foreach($doctors as $doctor){

  array_push($doc_array,ucfirst($doctor->name));
  
  
          }
         // echo $final_doc_array =  json_encode($doc_array);

?>
<div class="page-wrapper">
  <div class="flashmessage">
  </div>
  <div class="container-fluid" style="padding-top: 9px;">

    <style>
      .b-r-0 {
        border-right: 0px !important;
      }

      .p-l-r-5 {
        padding-left: 5px !important;
        padding-right: 5px !important;
      }

      .p-l-5 {
        padding-left: 5px !important;
      }

      .p-r-5 {
        padding-right: 5px !important;
      }

      .custom-text-button {
        font-size: 13px;
        font-weight: 600;
        padding: 5px 0px;
      }

      .m-b-5 {
        margin-bottom: 10px !important;
      }

      .custom-text-button {
        font-size: 13px;
        font-weight: 600;
        padding: 5px 2px;
      }

      #SalesForm :focus {
        outline: 1px solid rgba(0, 0, 0, 0.3)
      }

      .select2-container--open .select2-dropdown {
        left: -37px;
        width: 250px !important;
      }

      .select2-container .select2-selection--single {
        height: 37px;
      }

      .select2-container {
        ;
        width: 100% !important;
      }

      .select2-container--default .select2-selection--single .select2-selection__rendered {
        display: none;
      }

      .select2-container--default .select2-selection--single .select2-selection__arrow {
        width: 100%;
      }

      .table th,
      .table thead th {
        padding-left: 10px;
      }

      span.previous-dues {
        font-size: 12px;
        font-weight: 500;
        color: #eb0a8d;
      }

      h4.previous-due-header {
        font-size: 14px;
        font-weight: 600;
        color: #eb0a8d;
        margin-top: 10px;
      }

      /*Controll Customer section line number 380*/
      .discount-info {
        color: #000;
        font-size: 14px;
        margin: 0px;
      }

      .ui-menu .ui-menu-item-wrapper {
        font-size: 13px;
        font-weight: 600;
      }

      .ui-menu .ui-menu-item-wrapper:hover {
        font-size: 13px;
        font-weight: 700;
      }

      .form-group.genric-left-sug {
        width: 85%;
        float: left;
      }

      .input-group.genric-right-sug {
        width: 15%;
        float: right;
      }

      .custom-text-button {
        font-size: 16px;
        font-weight: 600;
        padding: 5px 2px;
      }

      li.super-sale-list {
        padding: 0px !important;
        padding-left: 5px !important;
        border-bottom: .5px solid #e3e3e3 !important;
        padding-top: 0 !important;
        margin-top: 1px;
        font-size: 13px;
        font-weight: 600;
      }
      /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

      @media (max-width: 1400px) {
        span.input-group-addon.suggestion-icon.b-r-0 {
          display: none;
        }

        .select2-container {
          width: 100% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
          width: 100% !important;
        }

        .select2-container--open .select2-dropdown {
          left: 0px;
          width: 250px !important;
        }

        label.col-form-label.pos-label {
          font-size: 13px;
        }

        .custom-text-button {
          font-size: 13px;
          font-weight: 600;
          padding: 5px 2px;
        }

      }

      @media (max-width: 780px) {}
      .suggestions {
        position: absolute;
    width: 100%;
    margin: 35px 0px;
    z-index: 999;
}

[role="listbox"] {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
}

[role="option"] {
  /* padding: 0.25em;
  color: #999;
  border: 2px solid;
  border-top: 0; */
  padding: 0.25em;
    color: #363636;
    border: 1px solid #ccc;
    border-top: 0;
    cursor: pointer;
    background-color: #e7e7e7;
}
    </style>
    <?php
    $emtype = $this->session->userdata('em_type');
    if ($emtype == "admin") { ?>



      <div class="row">
        <div class="col-12">
          <div class="card card-outline-info" style="border-radius: none;">
            <div class="card-body" style="padding-top: 15px;">
              <div class="row">
                <div class="col-md-10">
                  <div class="pos_inputs">
                    <form action="" method="post" class="SalesForm" id="SalesForm" enctype="multipart/form-data">
                      <div class="row m-b-5">
                        <div class="col-md-3">
                          <input name="customer_type" value="WalkIn" type="radio" id="WalkIn_customer" name="click_cus" tabindex="-1" checked="checked">
                          <label for="WalkIn_customer">Walk In Customer</label>
                        </div>
                        <div class="col-md-3">
                          <input name="customer_type"  value="Regular" type="radio" id="regular_customer" tabindex="-1" >
                          <label for="regular_customer">Regular Customer</label>
                        </div>
                        <div class="col-md-3">
                          <input name="customer_type" value="Wholesale" type="radio" id="wholesale_customer" tabindex="-1">
                          <label for="wholesale_customer">Wholesale Customer</label>
                        </div>

                        <div class="col-md-2" style="margin-left: -42px;">
                          <a href="<?php echo base_url(); ?>Customer/Create" target="_blank" class="btn btn-sm btn-info waves-effect waves-light" tabindex="-1"><b>Create New Customer</b></a>
                        </div>

                        <div class="col-md-1">
                          <a href="<?php echo base_url(); ?>Invoice/manage_Invoice" target="_blank" class="btn btn-sm btn-info waves-effect waves-light" tabindex="-1"><b>Manage Invoice</b></a>
                        </div>
                      </div>
                      <div class="row m-b-5">
                        <div class="col-md-2 p-r-5">
                          <div class="input-group" id="regular_phone">
                            <span class="input-group-addon b-r-0"><i class="fa fa-mobile mx-1" aria-hidden="true"></i>
                            </span>
                            <input type="text" class="form-control" name="cusid" id="cusid" placeholder="Phone No" tabindex="1" autocomplete="off">
                          </div>
                          <div>
                            <div class="input-group" id="walk_phone" style="display:none;">
                              <span class="input-group-addon b-r-0"><i class="fa fa-mobile"></i></span>
                              <input type="number" class="form-control" name="walkin_phone" id="walkin_phone" placeholder="Phone No" tabindex="1" autocomplete="off">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2 p-l-r-5">
                          <div class="input-group" id="cus_drop">
                            <span class="input-group-addon b-r-0">
                              <i class="fa fa-user-circle"></i></span>
                            <input type="hidden" class="form-control" name="customer_name1" id="customer_name1" placeholder="Customer name">
                            <select name="customer_name" id="customer_name" class="form-control">
                              <option>Select the Customer</option>
                            </select>
                          </div>
                          <div id="app_cus_name">
                            <div class="input-group" id="walk_cus_name_div" style="display:none;">
                              <span class="input-group-addon b-r-0">
                                <i class="fa fa-user-o"></i></span>
                              <input type="text" class="form-control" name="walk_cus_name" id="walk_cus_name" placeholder="Customer Name" value="Cash">
                            </div>
                            

                          </div>
                        </div>
                        <div class="col-md-2 p-l-r-5">
                        <div class="input-group suggestions-container" id="doctor_name">
                        
                              <span class="input-group-addon b-r-0">
                                <i class="fa fa-stethoscope"></i></span>
                              <input type="text" class="form-control" name="doctor_name" id="pets" data-suggest autocomplete="off" placeholder="Doctor Name">
                              <div class="suggestions"></div>
                            </div>
                        </div>
                        <div class="col-md-3 p-l-5">
                        
                          <div class="input-group" id="cus_id">
                            <span class="input-group-addon b-r-0">
                              <i class="fa fa-user-o"></i></span>
                            <input type="text" class="form-control customer_id" name="customer_id" id="customer_id" placeholder="Customer ID">
                            <input type="hidden" class="form-control regulardisc" name="regulardisc" id="regulardisc" value="0">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="row">
                            <div class="col-md-6">
                              <span style="font-size:12px!important" class="custom-text-button">
                                Date:
                                <?php date_default_timezone_set("Asia/kolkata");
                                echo date("j  M Y") ?>
                              </span>
                            </div>
                            <div class="col-md-6">
                              <span style="font-size:12px!important" class="custom-text-button">
                                Time:
                                <?php date_default_timezone_set("Asia/kolkata");
                                echo date("h:i A") ?>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row m-b-4">
                        <div class="col-md-9">
                          <div class="row pos-remove-spacing">
                            <div class="col-md-4" style="">
                              <div class="input-group">
                                <span class="input-group-addon b-r-0"><i class="fa fa-search" aria-hidden="true"></i>
                                </span>
                                <input type="hidden" id="proid" name="proid" value="">
                                <input type="text" class="form-control proval" name="proval" placeholder="Medicine Name" id="product_name" tabindex="2" autocomplete="off">
                              </div>
                            </div>


                            <div class="col-md-3">
                              <div class="form-group">
                                <input type="text" class="form-control proname" name="proname" id="proname" placeholder="Product Name" autocomplete="off"><sup>
                                  <h6 id="expiry" style="color:red;margin-top: 5px;position:absolute;"></h6>
                                </sup>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group genric-left-sug">
                                <input type="text" class="form-control genname" name="genname" id="genname" placeholder="Generic Name"  autocomplete="off">
                              </div>
                              <div class="input-group genric-right-sug">

                              </div>
                            </div>
                            <div class="col-md-2" style="">
                              <div class="form-group">

                              </div>

                            </div>
                          </div>
                        </div>


                        <div class="col-md-3">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="input-group">
                                <!-- <span class="input-group-addon"><i class="fa fa-money"></i>
                                </span>
                                <input type="text" class="form-control mrp" name="mrp" id="mrp" placeholder="MRP" readonly tabindex="-1" value=""> -->
                                
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cart-arrow-down"></i>
                                </span>
                                <input type="text" class="form-control stock" name="stock123" id="stock" placeholder="Stock " readonly tabindex="-1" value="">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="append_med_history">

                      </div>
                      <div class="text-right col-md-9 mb-3"> <button id="add" class="btn btn btn-info">ADD</button></div>
                    </form>
                    <form action="" method="post" name="SalesFormConfirm" class="SalesFormConfirm" id="SalesFormConfirm" enctype="multipart/form-data">
                      <div class="row">
                        <div class="col-md-9">
                          <div class="table-responsive mb-15" style="height: 300px; overflow-y: auto; ">
                            <table class="table table-bordered pos_table scroll">
                              <thead>
                                <tr>
                                  <th>Product Name
                                  </th>
                                  <th>Quantity
                                  </th>
                                  <th>Total
                                  </th>
                                  <th>Action
                                  </th>

                                </tr>
                              </thead>
                              <tbody id="posinfo">

                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="row form-group">
                            <div class="col-md-5">
                              <label for="example-text-input" class=" col-form-label pos-label">Total Rs.
                              </label>
                            </div>
                            <div class="col-md-7">
                              <input class="form-control grandtotal" name="grandtotal" id="grandtotal" type="text" value="" style="" tabindex="-1" readonly>
                            </div>
                          </div>
                          <div class="row form-group" style="display:none">
                            <div class="col-md-5">
                              <label for="example-text-input" class="col-form-label pos-label">Total Tax.
                              </label>
                            </div>
                            <div class="col-md-7">
                              <input class="form-control totalTax" id="totalTax" name="totalTax" id="totalTax" type="tax" value="" style="" tabindex="-1" readonly>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-5">
                              <label for="example-text-input" class=" col-form-label pos-label">Discount %
                              </label>
                            </div>
                            <div class="col-md-7">
                              <input class="form-control gdiscount" name="gdiscount" id="gdiscount" type="text" style="" tabindex="-1">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-5">
                              <label for="example-text-input" class=" col-form-label pos-label">Payable ₹.
                              </label>
                            </div>
                            <div class="col-md-7">
                              <input class="form-control payable" name="payable" id="payable" type="text" value="" style="" tabindex="-1" readonly>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-5">
                              <label for="example-text-input" class=" col-form-label pos-label">Paid ₹.
                              </label>
                            </div>
                            <div class="col-md-7">
                              <input class="form-control pay" type="text" name="pay" value="" style="" tabindex="-1" required="1">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-5">
                              <label for="example-text-input" class=" col-form-label pos-label">Return ₹.
                              </label>
                            </div>
                            <div class="col-md-7">
                              <input class="form-control return" name="return" type="text" value="" style="" tabindex="-1">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-5">
                              <label for="example-text-input" class=" col-form-label pos-label">Due ₹.
                              </label>
                            </div>
                            <div class="col-md-7">
                              <input class="form-control due" name="due" type="text" value="" style="" tabindex="-1">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-5">
                              <label for="example-text-input" class=" col-form-label pos-label">Mode.
                              </label>
                            </div>
                            <div class="col-md-7">
                              <select name="mtype" id="mtype" class="form-control" required>
                                <option value="Cash">Cash</option>
                                <option value="UPI">UPI</option>
                                <option value="Card">Card</option>
                                <option value="Credit">Credit</option>
                              </select>
                            </div>
                          </div>
                          <!--Regular customer sales target view-->
                          <div class="row form-group">
                            <div class="col-md-12">
                              <!--                              <label for="example-text-input" id="sales" class="col-form-label" style="color:#007bff">
                              </label>-->
                              <!--Dues-->
                              <div id="sales">

                              </div>
                            </div>
                          </div>
                        </div>
                      </div><input type="hidden" id="cid" name="cid" value='' tabindex="-1">
                      <div class="row">
                        <div class="col-md-3">

                          <button type="button" id="saleSubmit" class="btn waves-effect waves-light btn-secondary" style="width: 70%;">Sale & Invoice
                          </button>
                        </div>
                        <div class="col-md-3">
                          <button type="button" id="FinalSubmit" class="btn waves-effect waves-light btn-secondary" style="width: 50%;">Save
                          </button>
                        </div>
                        <!--<div class="col-md-3">
                          <button type="submit" id="Billhold" class="btn waves-effect waves-light btn-secondary" style="width: 50%;">Hold Bill
                          </button>
                        </div>-->
                        <div class="col-md-3">
                          <a id="salesposSubmit" class="btn waves-effect waves-light btn-secondary" style="width: 70%;">Invoice & Print
                          </a>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-md-2">
                  <!--Super sale-->
                  <div class="card">
                    <div class="card-heading">
                      <span style="display: block; padding: 7px 10px; background-color: #a5a5a5; color: #fff;font-weight:600">
                        Super Sale
                      </span>
                    </div>
                    <div class="card-body" style="padding: 0; ">
                      <ul class="list-group custom_list" style="height: 420px; overflow-y: auto;">
                        <?php foreach ($medicineList as $value) : ?>
                          <li class="super-sale-list" style="padding:1px;padding-left:5px;border-bottom:.5px solid #e3e3e3">
                            <a href="" id="superpro" data-id="<?php echo $value->mid; ?>"><?php echo $value->product_name ?><?php if (!empty($value->strength)) {
                                                                                                                              echo "(" . $value->strength . ")";
                                                                                                                            } else {
                                                                                                                            } ?> [ <?php echo $value->totinstock; ?> ] </a>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } else { ?>
      <div class="row">
        <div class="col-12">
          <div class="card card-outline-info" style="border-radius: none;">
            <div class="card-body" style="padding-top: 15px;">
              <div class="row">
                <div class="col-md-10">
                  <div class="pos_inputs">
                    <form action="" method="post" class="SalesForm" id="SalesForm" enctype="multipart/form-data">
                      <div class="row m-b-5">
                        <div class="col-md-3">
                          <input name="customer_type" value="WalkIn" type="radio" id="WalkIn_customer" name="click_cus" tabindex="-1" checked="checked">
                          <label for="WalkIn_customer">In Patient </label>
                        </div>
                        <div class="col-md-3" style="display:none">
                          <input name="customer_type" value="Regular" type="radio" id="regular_customer" tabindex="-1">
                          <label for="regular_customer">Regular Customer</label>
                        </div>
                        <div class="col-md-3" style="display:none">
                          <input name="customer_type" value="Wholesale" type="radio" id="wholesale_customer" tabindex="-1">
                          <label for="wholesale_customer">Wholesale Customer</label>
                        </div>

                        <!-- <div class="col-md-2" style="margin-left: -42px;"  >
                        <a href="<?php echo base_url(); ?>Customer/Create" target="_blank" class="btn btn-sm btn-info waves-effect waves-light" tabindex="-1"><b>Create New Customer</b></a>
                      </div> -->

                        <div class="col-md-1">
                          <a href="<?php echo base_url(); ?>Invoice/manage_Invoice" target="_blank" class="btn btn-sm btn-info waves-effect waves-light" tabindex="-1"><b>Manage Invoice</b></a>
                        </div>
                      </div>
                      <div class="row m-b-5">
                        <div class="col-md-2 p-r-5">
                          <div class="input-group" id="regular_phone">
                            <span class="input-group-addon b-r-0"><i class="fa fa-mobile mx-1" aria-hidden="true"></i>
                            </span>
                            <input type="text" class="form-control" name="cusid" id="cusid" placeholder="Phone No" tabindex="1" autocomplete="off">
                          </div>
                          <div>
                            <div class="input-group" id="walk_phone" style="display:none;">
                              <span class="input-group-addon b-r-0"><i class="fa fa-mobile"></i></span>
                              <input type="number" class="form-control" name="walkin_phone" id="walkin_phone" placeholder="Phone No" tabindex="1" autocomplete="off">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2 p-l-r-5">
                          <div class="input-group" id="cus_drop">
                            <span class="input-group-addon b-r-0">
                              <i class="fa fa-user-circle"></i></span>
                            <input type="hidden" class="form-control" name="customer_name1" id="customer_name1" placeholder="Customer name">
                            <select name="customer_name" id="customer_name" class="form-control">
                              <option>Select the Customer</option>
                            </select>
                          </div>
                          <div id="app_cus_name">
                            <div class="input-group" id="walk_cus_name_div" style="display:none;">
                              <span class="input-group-addon b-r-0">
                                <i class="fa fa-user-o"></i></span>
                              <input type="text" class="form-control" name="walk_cus_name" id="walk_cus_name" placeholder="Patient Name">
                              <input type="hidden" class="form-control regulardisc" name="regulardisc" id="regulardisc" value="0">
                            </div>

                            



                          </div>
                        </div>
                        <div class="col-md-2 p-l-5">
                        <div class="input-group suggestions-container" id="doctor_name">
                          <span class="input-group-addon b-r-0">
                            <i class="fa fa-stethoscope"></i></span>
                          <input type="text" class="form-control" name="doctor_name" id="doctor_name" data-suggest autocomplete="off" placeholder="Doctor Name">
                          <div class="suggestions"></div>
                          
                        </div>
                          <!-- <div class="input-group" id="cus_id">
                            <span class="input-group-addon b-r-0">
                              <i class="fa fa-user-o"></i></span>
                            <input type="text" class="form-control customer_id" name="customer_id" id="customer_id" placeholder="Customer ID">
                          </div> -->
                        </div>
                        <div class="col-md-3 p-1-5">
                        <div class="input-group" id="cus_id">
                            <span class="input-group-addon b-r-0">
                              <i class="fa fa-user-o"></i></span>
                            <input type="text" class="form-control customer_id" name="customer_id" id="customer_id" placeholder="Customer ID">
                          </div>
    </div>
                        <div class="col-md-3">
                          <div class="row">
                            <div class="col-md-6">
                              <span style="font-size:12px!important" class="custom-text-button">
                                Date:
                                <?php date_default_timezone_set("Asia/kolkata");
                                echo date("j  M Y") ?>
                              </span>
                            </div>
                            <div class="col-md-6">
                              <span style="font-size:12px!important" class="custom-text-button">
                                Time:
                                <?php date_default_timezone_set("Asia/kolkata");
                                echo date("h:i A") ?>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row m-b-4">
                        <div class="col-md-9">
                          <div class="row pos-remove-spacing">
                            <div class="col-md-4" style="">
                              <div class="input-group">
                                <span class="input-group-addon b-r-0"><i class="fa fa-search" aria-hidden="true"></i>
                                </span>
                                <input type="hidden" id="proid" name="proid" value="">
                                <!--<select class="js-product-data-ajax form-control product" name="proval" style="width:100%" required id="product_name" tabindex="2" autocomplete="off">
                                </select>-->
                                <input type="text" class="form-control proval" name="proval" placeholder="Search Product" id="product_name" tabindex="2" autocomplete="off">
                              </div>
                            </div>


                            <div class="col-md-3">
                              <div class="form-group">
                                <input type="text" class="form-control proname" name="proname" id="proname" placeholder="Product Name" autocomplete="off"><sup>
                                  <h6 id="expiry" style="color:red;margin-top: 5px;position:absolute;"></h6>
                                </sup>
                              </div>
                            </div>
                            
                            <div class="col-md-3">
                              <div class="form-group genric-left-sug">
                                <input type="text" class="form-control genname" name="genname" id="genname" placeholder="Generic Name"  autocomplete="off">
                              </div>
                              <div class="input-group genric-right-sug">
                                <!--span class="input-group-addon suggestion-icon b-r-0"><i class="fa fa-gg"></i>
                                </span-->
                                <!-- <select id="lunch" class="form-control select2 generic gensuggestion" name="generic" title="" style="" placeholder="" autocomplete="off">
                              </select> -->
                              </div>
                            </div>
                            <div class="col-md-2" style="">
                              <div class="form-group">
                                <!-- <input type="text" class="form-control qty123" name="qty" id="qty123" placeholder="Qty " autocomplete="off"> -->
                              </div>
                              <!-- <button id="add_btn">Add</button> -->
                            </div>
                          </div>
                        </div>


                        <div class="col-md-3">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i>
                                </span>
                                <input type="text" class="form-control mrp" name="mrp" id="mrp" placeholder="MRP" readonly tabindex="-1" value="">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cart-arrow-down"></i>
                                </span>
                                <input type="text" class="form-control stock" name="stock" id="stock" placeholder="Stock " readonly tabindex="-1" value="">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="append_med_history">

                      </div>
                      <div class="text-right col-md-9 mb-3"> <button id="add" class="btn btn btn-info">ADD</button></div>
                    </form>
                    <form action="" method="post" name="SalesFormConfirm" class="SalesFormConfirm" id="SalesFormConfirm" enctype="multipart/form-data">
                      <div class="row">
                        <div class="col-md-9">
                          <div class="table-responsive mb-15" style="height: 300px; overflow-y: auto; ">
                            <table class="table table-bordered pos_table scroll">
                              <thead>
                                <tr>
                                  <th>Product Name
                                  </th>
                                  <th>Quantity
                                  </th>
                                  
                                  <th>Total
                                  </th>
                                  <th>Action
                                  </th>

                                </tr>
                              </thead>
                              <tbody id="posinfo">

                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="row form-group">
                            <div class="col-md-5">
                              <label for="example-text-input" class=" col-form-label pos-label">Total Rs.
                              </label>
                            </div>
                            <div class="col-md-7">
                              <input class="form-control grandtotal" name="grandtotal" id="grandtotal" type="text" value="" style="" tabindex="-1" readonly>
                            </div>
                          </div>
                          <div class="row form-group" style="display:none">
                            <div class="col-md-5">
                              <label for="example-text-input" class="col-form-label pos-label">Total Tax.
                              </label>
                            </div>
                            <div class="col-md-7">
                              <input class="form-control totalTax" id="totalTax" name="totalTax" id="totalTax"  type="tax" value="" style="" tabindex="-1" readonly>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-5">
                              <label for="example-text-input" class=" col-form-label pos-label">Discount
                              </label>
                            </div>
                            <div class="col-md-7">
                              <input class="form-control gdiscount" name="gdiscount" id="gdiscount"  type="text" style="" tabindex="-1">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-5">
                              <label for="example-text-input" class=" col-form-label pos-label">Payable ₹.
                              </label>
                            </div>
                            <div class="col-md-7">
                              <input class="form-control payable" name="payable" id="payable" type="text" value="" style="" tabindex="-1" readonly>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-5">
                              <label for="example-text-input" class=" col-form-label pos-label">Paid ₹.
                              </label>
                            </div>
                            <div class="col-md-7">
                              <input class="form-control pay" type="text" name="pay" value="" style="" tabindex="-1" required="1">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-5">
                              <label for="example-text-input" class=" col-form-label pos-label">Return ₹.
                              </label>
                            </div>
                            <div class="col-md-7">
                              <input class="form-control return" name="return" type="text" value="" style="" tabindex="-1">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-5">
                              <label for="example-text-input" class=" col-form-label pos-label">Due ₹.
                              </label>
                            </div>
                            <div class="col-md-7">
                              <input class="form-control due" name="due" type="text" value="" style="" tabindex="-1">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-5">
                              <label for="example-text-input" class=" col-form-label pos-label">Mode.
                              </label>
                            </div>
                            <div class="col-md-7">
                              <select name="mtype" id="mtype" class="form-control" required>
                                <option value="Cash">Cash</option>
                                <option value="UPI">UPI</option>
                                <option value="Card">Card</option>
                                <option value="Credit">Credit</option>
                              </select>
                            </div>
                          </div>
                          <!--Regular customer sales target view-->
                          <div class="row form-group">
                            <div class="col-md-12">
                              <!--                              <label for="example-text-input" id="sales" class="col-form-label" style="color:#007bff">
                              </label>-->
                              <!--Dues-->
                              <div id="sales">

                              </div>
                            </div>
                          </div>
                        </div>
                      </div><input type="hidden" id="cid" name="cid" value='' tabindex="-1">
                      <div class="row">
                        <div class="col-md-3">

                          <button type="button" id="saleSubmit" class="btn waves-effect waves-light btn-secondary" style="width: 70%;">Sale & Invoice
                          </button>
                        </div>
                        <div class="col-md-3">
                          <button type="button" id="FinalSubmit" class="btn waves-effect waves-light btn-secondary" style="width: 50%;">Save
                          </button>
                        </div>
                        <!--<div class="col-md-3">
                          <button type="submit" id="Billhold" class="btn waves-effect waves-light btn-secondary" style="width: 50%;">Hold Bill
                          </button>
                        </div>-->
                        <div class="col-md-3">
                          <a id="salesposSubmit" class="btn waves-effect waves-light btn-secondary" style="width: 70%;">Invoice & Print
                          </a>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-md-2">
                  <!--Super sale-->
                  <div class="card">
                    <div class="card-heading">
                      <span style="display: block; padding: 7px 10px; background-color: #a5a5a5; color: #fff;font-weight:600">
                        Super Sale
                      </span>
                    </div>
                    <div class="card-body" style="padding: 0; ">
                      <ul class="list-group custom_list" style="height: 420px; overflow-y: auto;">
                        <?php foreach ($medicineList as $value) : ?>
                          <li class="super-sale-list" style="padding:1px;padding-left:5px;border-bottom:.5px solid #e3e3e3">
                            <a href="" id="superpro" data-id="<?php echo $value->mid; ?>"><?php echo $value->product_name ?><?php if (!empty($value->strength)) {
                                                                                                                              echo "(" . $value->strength . ")";
                                                                                                                            } else {
                                                                                                                            } ?> [ <?php echo $value->instock; ?> ] </a>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    <?php }
    ?>
    <div id="invoicemodal" class="modal fade" role="dialog">
      <div class="modal-dialog" style="width: 350px;">
        <!-- Modal content-->
        <div class="modal-content" id="invoicedom">

        </div><!-- ./model-content  -->
        <button style="margin-top: 5px" type='submit' class='btn btn-info' id='print'>print</button>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>

    <footer class="footer"> © <?php echo date("Y"); ?> Med Jacket</footer>
  </div>
</div>
<script>
  $(".close").click(function() {
    location.reload();
  });
</script>
<script>
  // var cid = $('#cusid').val(ui.item.label);

  $('#salesposSubmit').hide();
  $('#saleSubmit').hide();
  $('#FinalSubmit').hide();
  $('#Billhold').hide();
  $('#cusid').attr('tabindex', 1).focus();

  $('#cus_drop').hide();
  $('#cus_id').hide();
  $('#regular_phone').hide();
  $('#walk_cus_name_div').show();
  $('#walk_phone').show();
  <?php
  $emtype = $this->session->userdata('em_type');
  if ($emtype != "admin") { ?>
    //------------------------
    $('#cus_drop').hide();
    $('#cus_id').hide();
    $('#regular_phone').hide();
    $('#walk_cus_name_div').show();
    $('#walk_phone').show();
  <?php } ?>
</script>


<script>
  $('#WalkIn_customer').on("click", function() {
    $('#cus_drop').hide();
    $('#cus_id').hide();
    $('#regular_phone').hide();
    $('#walk_cus_name_div').show();
    $('#walk_phone').show();

  });
</script>

<!--Save data-->
<script type="text/javascript">
  $(document).ready(function() {
    $("#FinalSubmit").on('click', function(event) {
      event.preventDefault();
      var formval = $('#SalesFormConfirm')[0];
      var data = new FormData(formval);
      data.append('walkin_cus_name', $('#walk_cus_name').val());
      data.append('walkin_phone', $('#walkin_phone').val());
      data.append('doctor_name', $('#pets').val());

      $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "Save_Pos",
        dataType: 'json',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 1000,
        success: function(response) {

          if (response.status == 'error') {
            $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);

          } else if (response.status == 'success') {
            $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
            window.setTimeout(function() {
              window.location = "<?php echo base_url(); ?>Invoice/manage_Invoice";
            }, 3000);
          }
        },
        error: function(response) {
          console.error();
        }
      });
    });

  });
</script>
<!--Hold data-->
<script type="text/javascript">
  $(document).ready(function() {
    $("#Billhold").on('click', function(event) {
      event.preventDefault();
      var formval = $('#SalesFormConfirm')[0];
      var data = new FormData(formval);
      $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "Hold_Pos",
        dataType: 'json',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function(response) {
          if (response.status == 'error') {
            $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);

          } else if (response.status == 'success') {
            $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);

            window.setTimeout(function() {
              window.location = response.curl;
            }, 3000);
          }
        },
        error: function(response) {
          console.error();
        }
      });
    });

  });
</script>
<!--sale & invoice data-->
<script type="text/javascript">
  $(document).ready(function() {
    $("#saleSubmit").on('click', function(event) {
      event.preventDefault();
      var x = document.forms['SalesFormConfirm']["pay"].value;
      if (x == "") {


      } else {
        var formval = $('#SalesFormConfirm')[0];
        var data = new FormData(formval);
        data.append('walkin_cus_name', $('#walk_cus_name').val());
        data.append('walkin_phone', $('#walkin_phone').val());
        data.append('doctor_name', $('#pets').val());
        $.ajax({
          type: "POST",
          enctype: 'multipart/form-data',
          url: "Save_Pos_invoice",
          dataType: 'html',
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 3000,
          success: function(response) {
            $("#invoicedom").html(response);
            $('#invoicemodal').modal({
              backdrop: 'static',
              keyboard: false
            })
            //$("#invoicemodal").modal("show");
          },
          error: function(response) {
            console.error();
          }
        });
      }
    });

    $("#print").click(function(e) {

      var mode = 'iframe'; //popup
      var close = mode == "popup";
      var options = {
        mode: mode,
        popClose: true
      };
      $("div#printa").printArea(options);
    });


  });
</script>
<!--sale & invoice & print data-->
<script type="text/javascript">
  $(document).ready(function() {
    $("#salesposSubmit").on('click', function(event) {
      event.preventDefault();
      var x = document.forms['SalesFormConfirm']["pay"].value;

      var formval = $('#SalesFormConfirm')[0];
      var data = new FormData(formval);
      data.append('walkin_cus_name', $('#walk_cus_name').val());
      data.append('walkin_phone', $('#walkin_phone').val());
      data.append('payment_mode', $('#mtype').val());
      data.append('doctor_name', $('#pets').val());
      $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "Save_Pos_invoice",
        dataType: 'html',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function(response) {
          $("#invoicedom").html(response);
          var mode = 'iframe'; //popup
          var close = mode == "popup";
          var options = {
            mode: mode,
            popClose: true
          };
          $("div#invoicedom").printArea(options);
        },
        error: function(response) {
          console.error();
        }
      });
      //}
    });
  });
</script>
<script>
  $(document).ready(function() {
    $(document).on('click', '#tremove', function(e) {
      e.preventDefault();
      var rows = this.closest('#SalesFormConfirm tr');
      var discount = parseFloat($(".gdiscount").val());
      var total = parseFloat($(".grandtotal").val());
      var payt = parseFloat($(".payable").val());
      var t = parseFloat($(this).attr('data-total'));
      var tl = parseFloat($(this).attr('data-totall'));
      var d = parseFloat($(this).attr('data-discount'));
      var atotal = parseFloat(total - tl);
      var ptotal = parseFloat(payt - t);
      var adiscount = parseFloat(discount - d);
      $('.grandtotal').val(atotal);
      $('.payable').val(ptotal.toFixed(2));
      $('.gdiscount').val(adiscount.toFixed(2));
      $(this).closest('tr').remove();
    });
  });
</script>
<!--Super sale information-->
<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('click', "#superpro", function(e) {
      e.preventDefault(e);
      var iid = $(this).attr('data-id');

      $.ajax({
        url: '<?php echo base_url(); ?>Invoice/GetProductValueForPOSField?id=' + iid,
        method: 'GET',
        data: '',
        dataType: 'json',
      }).done(function(response) {
        //console.log(response);
        // Populate the form fields with the data returned from server                   
       // $('#SalesForm').find('[name="mrp"]').val(response.mvalue.mrp).end();
        $('#SalesForm').find('[name="stock123"]').val(response.mvalue.instock).end();
        $('#SalesForm').find('[name="proid"]').val(response.mvalue.product_id).end();
        $('#SalesForm').find('[name="proval"]').val(response.mvalue.product_name).end();
        // $('#SalesForm').find('[name="exp"]').val(response.mvalue.expire_date).end();
        $('#SalesForm').find('[name="proname"]').val(response.mvalue.product_name + '(' + response.mvalue.strength + ')').end();
        $('#SalesForm').find('[name="genname"]').val(response.mvalue.generic_name).end();
        $('#SalesForm').find('[name="qty"]').attr("max", response.mvalue.instock).end();

        $(this).addClass("disabled");
        $('#expiry').show();

        var vdata = {
          pro_id: response.mvalue.product_id
        };
        $.ajax({
          url: "<?php echo base_url() ?>Purchase/get_med_his55",
          type: 'post',
          dataType: "html",
          data: vdata,
          success: function(data) {

            $('#append_med_history').append(data);
          }
        });
        
      });
    });
  });
</script>
<!--Input value calculation-->
<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('keyup', '.gdiscount,.grandtotal,.pay,.return,.payable', function() {

    
      
      var discountamount = 0;
      //var total;  
      var gtotal = 0;
      var rows = this.closest('#SalesFormConfirm div');
      var discount = $(rows).find(".gdiscount");
      var total = $(rows).find(".grandtotal");
      var payable = $(rows).find(".payable");
      var pay = $(rows).find(".pay");
      var payableval = $('.payable').val();
      var payval = $('.pay').val();

      

     

      var returnval;
      returnval = payval - payableval;
      if (returnval <= 0) {
        $(".due").val(Math.abs(returnval).toFixed(2));
      } else if (returnval > 0) {
        $(".due").val('');
      }
      $(".return").val(returnval.toFixed(2));

    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('change', '.product', function(e) {
      e.preventDefault(e);
      //select to data return an array 
      var data = $(this).select2('data');
      //so i access it by index
      var iid = data[0].id;

      $.ajax({
        url: '<?php echo base_url(); ?>Invoice/GetProductValueForPOSField?id=' + iid,
        method: 'GET',
        data: '',
        dataType: 'json',
      }).done(function(response) {

        // Populate the form fields with the data returned from server                   
        $('#SalesForm').find('[name="mrp"]').val(response.mvalue.mrp).end();
        $('#SalesForm').find('[name="stock"]').val(response.mvalue.instock).end();
        $('#SalesForm').find('[name="exp"]').val(response.mvalue.expire_date).end();
        $('#SalesForm').find('[name="proname"]').val(response.mvalue.product_name + '(' + response.mvalue.strength + ')').end();
        $('#SalesForm').find('[name="genname"]').val(response.mvalue.generic_name).end();
        $('#SalesForm').find('[name="qty"]').attr("max", response.mvalue.instock).end();

        $('#expiry').show();
      });
    });
  });
</script>
<!--Customer information for c_type & c_name-->
<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('change', '.generic', function(e) {
      e.preventDefault(e);
      //select to data return an array 
      var iid = $(this).val();

      $.ajax({
        url: '<?php echo base_url(); ?>Invoice/GetProductValueForPOSField?id=' + iid,
        method: 'GET',
        data: '',
        dataType: 'json',
      }).done(function(response) {
        // Populate the form fields with the data returned from server                   
        $('#SalesForm').find('[name="mrp"]').val(response.mvalue.mrp).end();
        $('#SalesForm').find('[name="stock"]').val(response.mvalue.instock).end();
        $('#SalesForm').find('[name="exp"]').val(response.mvalue.expire_date).end();
        $('#SalesForm').find('[name="proname"]').val(response.mvalue.product_name + '(' + response.mvalue.strength + ')').end();
        $('#SalesForm').find('[name="genname"]').val(response.mvalue.generic_name).end();
        $('#SalesForm').find('[name="qty"]').attr("max", response.mvalue.instock).end();

      });
    });
  });
</script>

<script>
  $(function() {
    $("#cusid").keyup(function() {
      if ($('#cusid').val().length == 9) {
        $("#cusid").autocomplete({
          source: function(request, response) {
            $.ajax({
              url: "<?php echo base_url() ?>Invoice/GetCustomerId",
              type: 'post',
              dataType: "json",
              cache: false,
              data: {
                search: request.term
              },
              success: function(data) {
                response(data);
              }
            });
          },
          select: function(event, ui) {
            // Set selection
            $('#cusid').val('');
            $('#customer_name1').val(ui.item.label);
            $('#cid').val(ui.item.value);
            $('#customer_name1').val(ui.item.value);
            // alert(ui.item.value);

            $("#customer_name > option").each(function() {
              if (this.value == ui.item.value)
                $(this).attr("selected", "selected");
            });

            $('#customer_id').val(ui.item.value);
            if (ui.item.ctype == 'Regular') {
              $('#SalesForm').find(':radio[id=regular_customer][value="Regular"]').prop('checked', true).end();
            } else if (ui.item.ctype == 'Wholesale') {
              $('#SalesForm').find(':radio[id=wholesale_customer][value="Wholesale"]').prop('checked', true).end();
            }
            if (ui.item.ctype == 'Regular') {

              var id = ui.item.value;
              $.ajax({
                url: '<?php echo base_url() ?>Customer/GetCustomerMonthlyIncome?id=' + id,
                method: 'GET',
                data: 'data', 
              }).done(function(response) {

                $('#sales').show();
                $('#sales').html(response);
              });
            } else if (ui.item.ctype == 'Wholesale') {

              $('#sales').hide();
            }
            $("#cusid").autocomplete('close');
            //$("#cusid").autocomplete('destroy');
            $('#product_name').attr('tabindex', 2).focus();
            return false;
          },

          open: function(e, ui) {
            var len = $('.ui-autocomplete > li').length;
            if (len == 1) {
              $(".ui-menu-item:eq(0)").trigger("click");
              $("#cusid").autocomplete('close');
              //$("#cusid").autocomplete('destroy');
              // $( "#cusid" ).autocomplete({});
              return false;
            } else if (len == 2) {
              $(".ui-menu-item:eq(1)").trigger("click");
              $("#cusid").autocomplete('close');
              //$("#cusid").autocomplete('destroy');
              // $( "#cusid" ).autocomplete({});
              return false;
            }
          }
        });
      } else {}
    });

  });
</script>

<script>
  $('#add_btn').on("click", function() {
    var pro_id = $('#proid').val();
    var vdata = {
      pro_id: pro_id
    };
    $.ajax({
      url: "<?php echo base_url() ?>Purchase/get_med_his",
      type: 'post',
      dataType: "html",
      data: vdata,
      success: function(data) {
        $('#append_med_history').append(data);
      }
    });
  });
</script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<!-- <script src="YourJquery source path"></script> -->
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>

<script>
  $(function() {
    $(this.target).find('input').autocomplete();
    $("#product_name").autocomplete({
      source: function(request, response) {
        console.log(request.term);
        $.ajax({
          url: "<?php echo base_url() ?>Invoice/GetProductparam",
          type: 'post',
          dataType: "json",
          cache: false,
          data: {
            search: request.term
          },
          success: function(data) {
            console.log(data);
            response(data);
          }
        });
      },
      select: function(event, ui) {
        $('#proid').val(ui.item.value);
        $('#proname').val(ui.item.label);
        // $('#product_name').val('');
        $('#genname').val(ui.item.genval);
        $('#mrp').val(ui.item.mrp);
        $('#stock').val(ui.item.stock);
        $("#expiry").html(ui.item.expiry);
        var pro_id = $('#proid').val();

        var vdata = {
          pro_id: pro_id
        };
        $.ajax({
          url: "<?php echo base_url() ?>Purchase/get_med_his55",
          type: 'post',
          dataType: "html",
          data: vdata,
          success: function(data) {

            $('#append_med_history').append(data);
          }
        });
        if (ui.item.expiry == '0') {
          $("#expiry").hide();
        } else {
          $("#expiry").show();

        }

        var pid = ui.item.value;

        $.ajax({
          url: '<?php echo base_url() ?>Invoice/GetSimilarGenericdata?id=' + pid,
          method: 'GET',
          data: 'data',
        }).done(function(response) {
          $('.generic').html(response);
        });
        $("#product_name").autocomplete('close');
        // $('#qty').attr('tabindex', 4).focus();


        return false;
      },
      open: function(e, ui) {
        var val = $('.ui-autocomplete > li').length;


      }
    });
  });
</script>
<!--Product add to card-->
<script>
  $('#add').click(function() {
    // if(e.which == 13 || e.keycode == '13') {
    var iid = $('#customer_id').val();
    var qty = $('#qty').val();


    var formval = $('#SalesForm')[0];
    var data = new FormData(formval);
    $.ajax({
      type: "POST",
      enctype: 'multipart/form-data',
      url: "Pos_Info12",
      dataType: 'html',
      data: data,
      processData: false,
      contentType: false,
      cache: false,
      timeout: 600000,
      success: function(response) {
        $("#posinfo").append(response);
        calc_total(response);
        calc_discount();

        function calc_total() {
          var sum = 0;
          $(".totall").each(function() {
            sum += parseFloat($(this).val());
          });
          $('.grandtotal').val(sum.toFixed(2));
          var pay = 0;
          $(".total").each(function() {
            pay += parseFloat($(this).val());

          });

          $('.payable').val(pay.toFixed(2));

        }

        function calc_discount() {

          var discount = 0;
          $(".discount").each(function() {
            discount += parseFloat($(this).val());


          });
          $('.gdiscount').val(discount);
        }
        $('#salesposSubmit').show();
        $('#saleSubmit').show();
        $('#FinalSubmit').show();
        $('#Billhold').show();
      },
      error: function(response) {
        console.error();
      }
    });
    //}
  });
</script>

<!--Expiry date After super product click-->
<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('click', "#superpro", function(e) {
      e.preventDefault(e);
      //select to data return an array 
      var pid = $(this).attr('data-id');
      //so i access it by index
      $.ajax({
        url: '<?php echo base_url() ?>Invoice/GetExpiryDtaeAselect?id=' + pid,
        method: 'GET',
        data: 'data',
      }).done(function(response) {

        $('#expiry').html(response);
      });
    });
  });
</script>
<!--Similar generic name after super product click-->
<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('click', "#superpro", function(e) {
      e.preventDefault(e);
      var pid = $(this).attr('data-id');

      $.ajax({
        url: '<?php echo base_url() ?>Invoice/GetSimilarGenericdata?id=' + pid,
        method: 'GET',
        data: 'data',
      }).done(function(response) {

        $('.generic').html(response);
      });
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('change', ".generic", function(e) {
      e.preventDefault(e);
      var pid = $(this).val();

      $.ajax({
        url: '<?php echo base_url() ?>Invoice/GetSimilarGenericdata?id=' + pid,
        method: 'GET',
        data: 'data',
      }).done(function(response) {

        $('.generic').html(response);
      });
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#add").hide();


    $('#SalesForm').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) {
        e.preventDefault();
        return false;
      }
    });

    $("#qty123").keyup(function(e) {
      //alert("hello");
      e.preventDefault(e);

      var qty = parseInt($("#qty123").val());
      var stk = parseInt($("#stock").val());
      if (stk >= qty && qty != 0) {

        $("#add").show();
        $(".error").remove();

      } else {

        $("#add").hide();
        $(".error").remove();
        $("input#qty123").after('<span class="error">In stock ' + stk + '</span>');
      }

    });
  });
</script>

<script>
  $(document).ready(function() {
    $.ajax({
      url: "<?php echo base_url(); ?>Customer/get_regular_cus",
      type: "get",
      dataType: "json",
      success: function(data) {
        $('#customer_name').empty();
        var append_option = '<option>Select the Customer</option>';
        $('#customer_name').append(append_option);
        $.each(data, function(key, value) {
          $('#customer_name').append($("<option></option>").attr("value", value.c_id).text(value.c_name));
        });
      }
    });

  });
</script>

<script>
  $('#regular_customer').click(function() {
    $('#cus_drop').show();
    $('#cus_id').show();
    $('#walk_cus_name_div').hide();
    $('#cusid').val('');
    $('#customer_id').val('');
    $.ajax({
      url: "<?php echo base_url(); ?>Customer/get_regular_cus",
      type: "get",
      dataType: "json",
      success: function(data) {
        $('#customer_name').empty();
        var append_option = '<option>Select the Customer</option>';
        $('#customer_name').append(append_option);
        $.each(data, function(key, value) {
          $('#cid').val(value.c_id);
          $('#customer_name').append($("<option ></option>").attr("value", value.c_id).text(value.c_name));

        });
      }
    });

  });
</script>
<script>
  $('#customer_name').on('change', function() {
    id = this.value;
    vdata = {
      id: id
    };
    //alert('hello');
    $.ajax({
      url: "<?php echo base_url(); ?>Customer/get_cus_data",
      type: "post",
      data: vdata,
      dataType: "json",
      success: function(data) {

        $.each(data, function(key, value) {
          $('#cid').val(value.c_id);
          $('#customer_id').val(value.c_id);
          $('#walkin_phone').val(value.cus_contact);
          $('#regulardisc').val(value.regular_discount);


        });
      }
    });
    $.ajax({
      url: '<?php echo base_url() ?>Customer/GetCustomerMonthlyIncome?id=' + id,
      method: 'GET',
      data: 'data',
    }).done(function(response) {
      $('#sales').show();
      $('#sales').html(response);
    });
  });
</script>
<script>
  $('#wholesale_customer').click(function() {
    $('#cus_drop').show();
    $('#cus_id').show();

    $('#walk_cus_name_div').hide();
    $('#cusid').val('');
    $('#customer_id').val('');
    $.ajax({
      url: "<?php echo base_url(); ?>Customer/get_wholesale_cus",
      type: "get",
      dataType: "json",
      success: function(data) {
        $('#customer_name').empty();
        var append_option = '<option>Select the Customer</option>';
        $('#customer_name').append(append_option);
        $.each(data, function(key, value) {
          $('#customer_name').append($("<option></option>").attr("value", value.c_id).text(value.c_name));
        });
      }
    });

  });
</script>

<script>
  $(document).on("click", '#add_pos55', function(e) {
 
    let stock = $(this).closest('.row').find('[name="stock"]').val();
    let qty = $(this).closest('.row').find('#req_qty').val();
    if (qty == '') {
      qty = "0";
    }

    

    if(parseInt(qty) > parseInt(stock) ){
    

     e.preventDefault()

    }else{



    $(this).closest('.row').remove();
    var batchNumber = $(this).data("id");

    var iid = $('#customer_id').val();
    var regulsrdisc = $('#regulardisc').val();
    //var stock = $(this).closest('#stock').val();
   
    var exp_date = $(this).closest('.row').find('[name="exp_date"]').val();


    
    // var proid = $('#proid').val();
    var proid = $(this).closest('.row').find('[name="pro_id"]').val();
    // alert(proid);
    var mrp = $(this).closest('.row').find('[name="mrp"]').val();
    var units = $(this).closest('.row').find('[name="units"]').val();
    

    vdata = { customer_id: iid, proid: proid, qty: qty, mrp: mrp, batchNumber: batchNumber, stock: stock, exp_date: exp_date, unit: units, regdisc:regulsrdisc  };
    
    $.ajax({
      url: "Pos_Info55",
      type: "POST",
      dataType: 'html',
      data: vdata,
      success: function(response) {
        $("#posinfo").append(response);
        calc_total(response);
        calc_discount(response);
        var discount = $('#discount').val();
        var discount = $('#gdiscount').val(discount);

        function calc_total() {
          var sum = 0;
          var tax = 0;
          $(".totall").each(function() {
            sum += parseFloat($(this).val());


          });
          //---------------------------------------
          $(".tax").each(function() {
            tax = 0;

            $('#totalTax').val(tax);
          });

          $(".discount").each(function() {
            discount += parseFloat($(this).val());
          });

          var ftax = (sum *  discount)/100;

          
          //----------------------------------------
          $('.grandtotal').val(sum.toFixed(2));
          var pay = 0;
          $(".total").each(function() {
            pay += parseFloat($(this).val());

          });
          if (iid == '') {
            var sum = sum + tax;
            $('.payable').val(sum.toFixed(2));
          } else {
            var pay = tax + pay;
            $('.payable').val(pay.toFixed(2));
          }

        }

        function calc_discount(response) {
          //console.log(response);
          var discount = 0;
          // alert("helo");
          $(".discount").each(function() {
            discount += parseFloat($(this).val());
          });
          $('.gdiscount').val(discount);
          //alert(discount);
        }
        $('#salesposSubmit').show();
        $('#saleSubmit').show();
        $('#FinalSubmit').show();
        $('#Billhold').show();


        


      },
      error: function(response) {
        console.error();
      }
    });
  }
  });
</script>

<script>
  $(document).ready(function() {
    $("#gdiscount").keyup(function() {


      var discount = parseFloat($('#regulardisc').val());
      var gdiscount = parseFloat($('#gdiscount').val());
      if (isNaN(gdiscount)) {
        var gdiscount = 0;

        
      }else{ }

      
      var arr1 = [];  
      var tax = 0;
      var val = 0;
      var totalDiscount = 0;
      let input = document.getElementsByName('totall[]');
 
            for (let i = 0; i < input.length; i++) {
              let a = input[i];
                arr1.push(a.value);
            }

            
            let inputk = document.getElementsByName('taxpercent[]');
 
            for (let i = 0; i < inputk.length; i++) {
                
              var num = parseFloat(arr1[i]);
              var discountpercnt = (gdiscount+discount)/100;
              
              val += num - (num * discountpercnt);
              tax += (val * inputk[i].value)/100;

              totalDiscount += (num * discountpercnt);


              
              
                
                
            }
            

      
      var grandtotal = parseFloat($('#grandtotal').val());
      
      
      
     

     

      $('#totalTax').val(tax.toFixed(2));
      var totalTax = parseFloat($('#totalTax').val());
      

     
      

   
      
      var totl = parseFloat((grandtotal + totalTax) - totalDiscount);

    // var totl = parseFloat((grandtotal + totalTax) - gdiscount);
      
      var payable = totl.toFixed(2);
      var payable = parseFloat($('#payable').val(payable));


    });
  });
</script>

<script>
      $(document).on("change", '#unit',  function(e){
        var optionValue = $(this).val();
      
       // var stock = $('#stock').val(); 
        var stock =  $(this).closest('.row').find('#stock').val();
        console.log(stock);

        if (stock > 0 && stock < 10)
        {
          if(optionValue== "strip")
          {
            
            $(this).closest('.row').find('#select_error').html('Please Select Correct Option');
          }
          if(optionValue== "Box")
          {
            $(this).closest('.row').find('#select_error').html('Please Select Correct Option');
          }
          if(optionValue== "Tablet")
          {
            $(this).closest('.row').find('#select_error').html('');
          }
       
        }  
   
       else if(stock > 9 &&  stock < 100 ) 
        {
          if(optionValue== "Box")
          {
            $(this).closest('.row').find('#select_error').html('Please Select Correct Option');
          }
          if(optionValue== "Tablet")
          {
            $(this).closest('.row').find('#select_error').html('');
          }
        }
 

      });

      //Auto suggest doctor name
      var pets = <?php echo json_encode($doc_array) ?>;
//       [ 'cat',
//   'dog',
//   'fish',
//   'horse',
//   'snake',
//   'ferret',
//   'lizard',
//   'tortoise',
//   'terrapin',
//   'turtle',
//   'pig',
//   'hermit crab',
//   'hamster',
//   'gerbil',
//   'rat',
//   'tarantula',
//   'great white shark',
//   'dung beetle',
//   'stick insect',
//   'aardvark',
//   'anteater'
// ];

$('[data-suggest]').on('input', function() {
  
  var input = $(this);
  var scope = input.parents('.suggestions-container');
  
  $('.suggestions', scope).html('<div role="listbox"></div>');
  $('.suggestions-help', scope).empty();
  
  var value = input.val();
  var suggestions = _.filter(pets.sort(), function(pet) { 
    // pet & value lowercase for case-insensitive matching
    return !pet.toLowerCase().indexOf(value.toLowerCase()); });
  
  if (value) {
    $.each(suggestions, function(k, v) {
      $('[role="listbox"]', scope).append(
        '<div role="option">'+v+'</div>'
      );
    });
    $('[role="listbox"]  [role="option"]', scope).each(function() {
      $(this).attr('id', input.attr('id') + '-' + $(this).index());
    });
    if (!_.isEmpty(suggestions)) {
      $('.suggestions-help', scope).text(
      'There are '+suggestions.length+' suggestions. Use the up and down arrows to browse.');
    }
  }
  
  input.on('keydown', function(e) {
    if (e.keyCode == 40) {
      e.preventDefault();
      $('[role="listbox"]', scope)
        .attr('tabindex', '0')
        .focus();
      $('[role="listbox"]').attr('aria-activedescendant', $('[role="listbox"] [role="option"]:first-child', scope).attr('id'));
      $('[role="listbox"] [role="option"]:first-child').addClass('selected');
      $('#pets').val($('.selected').text());
    }
    if (e.keyCode == 9) {
      $('[role="listbox"]', scope).remove();
    }
  });

  $('[role="listbox"]', scope).on('keydown', function(e) {
    if (e.keyCode == 13) {
      e.preventDefault();
      e.stopPropagation();
      $('#pets').focus();
    }
    var newOption;
    if (e.keyCode == 40) {
      e.preventDefault();
      newOption = $('.selected').next();
    }
    if (e.keyCode == 38) {
      e.preventDefault();
      newOption = $('.selected').prev();
    }
    if (newOption.length) {
      $('.selected').removeClass('selected');
      newOption.addClass('selected');
      $(this).attr('aria-activedescendant', newOption.attr('id'));
      $('#pets').val($('.selected').text());
    }
  });

  $('[role="listbox"]', scope).on('blur', function() {
    $(this).children().remove();
  });
  
  $('[role="option"]', scope).on('click', function() {
    $('[data-suggest]', scope).val($(this).text())
    .focus();
    $('[role="listbox"]', scope).remove();
  });
  
});
</script>
<script type="text/javascript">
 $(document).keydown(function (e) {
            if(e.key == "F1"){
              event.preventDefault();
      var formval = $('#SalesFormConfirm')[0];
      var data = new FormData(formval);
      data.append('walkin_cus_name', $('#walk_cus_name').val());
      data.append('walkin_phone', $('#walkin_phone').val());
      data.append('doctor_name', $('#pets').val());

      $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "Save_Pos",
        dataType: 'json',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 1000,
        success: function(response) {

          if (response.status == 'error') {
            $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);

          } else if (response.status == 'success') {
            $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
            window.setTimeout(function() {
              window.location = "<?php echo base_url(); ?>Invoice/manage_Invoice";
            }, 3000);
          }
        },
        error: function(response) {
          console.error();
        }
      });
            }

        });
</script>
<script type="text/javascript">
 $(document).keydown(function (e) {
            if(e.key == "F4"){
              window.location.href = "<?php echo base_url(); ?>dashboard/Dashboard";
              return false;
            }

        });
</script>
<script type="text/javascript">
 $(document).keydown(function (e) {
            if(e.key == "F7"){
              location.reload();
              return false;
            }

        });
</script>
<script type="text/javascript">
    $(document).keydown(function (e) {
        if (e.key == "F3") {
            // $("#regular_customer").prop("checked", true);
             alert('Regular customer selected');
             return false; 
        }
    });
</script>

<?php
$this->load->view('backend/footer');
?>