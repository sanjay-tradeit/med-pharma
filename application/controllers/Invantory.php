<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invantory extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->model('medicine_model');
        $this->load->model('purchase_model');
        $this->load->model('invoice_model');
        $this->load->helper('form');
        $this->load->library('encryption');
        
     
    }

    public function index() {
        // Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') != 1) {
            redirect(base_url() . 'login', 'refresh');
        } else {
            redirect('dashboard/Dashboard');
        }
    }

    public function Stock() {
        if ($this->session->userdata('user_login_access') != false) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
        if (in_array(38, $permissions)) { 
            $data['stock'] = $this->medicine_model->getStockVal(); 
            $this->load->view('backend/stock', $data);
        }
        else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Stock_short() {
        if ($this->session->userdata('user_login_access') != false) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
        if (in_array(39, $permissions)) { 
            $data['sortstock'] = $this->medicine_model->getShortProduct(); // Corrected method name
            $this->load->view('backend/Stock_short', $data);
        }
        else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Stock_out() {
        if ($this->session->userdata('user_login_access') != false) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
        if (in_array(40, $permissions)) { 
            $data['stockout'] = $this->medicine_model->getStockOutProduct(); // Corrected method name
            $this->load->view('backend/Stock_out', $data);
        }
        else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Stock_expire_soon() {
        if ($this->session->userdata('user_login_access') != false) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
        if (in_array(41, $permissions)) { 
            $today = date("Y-m-d");
            $todaystr = strtotime(date("d/m/Y"));
            $onemonth = strtotime('1 month', $todaystr);
            $month = date("Y-m-d", $onemonth); 
            //die($month);
            $data['expiresoonmedicine'] = $this->medicine_model->getStockExpiresoonProduct($today, $month); // Corrected method name
            
            $this->load->view('backend/stock_expire_soon', $data);
        }
        else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Stock_expired() {
        if ($this->session->userdata('user_login_access') != false) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
        if (in_array(42, $permissions)) { 
            $today = date("Y-m-d");
            $data['expired'] = $this->medicine_model->getExpiredMedicine($today); 
            $this->load->view('backend/Stock_expired', $data);
        }
        else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function import_inventory()
    {
        if ($this->session->userdata('user_login_access') != false) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
        if (in_array(43, $permissions)) {
        $this->load->view('backend/import_inventory');
    }
    else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
    }
    else {
        redirect(base_url(), 'refresh');
    }
}

     public function transfer_inventory()
     {
        if ($this->session->userdata('user_login_access') != false) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
        if (in_array(45, $permissions)) {
        $data['medicine'] = $this->medicine_model->get_medicine(); 
        $data['store'] = $this->user_model->get_stores(); 
        $this->load->view('backend/transfer_inventory', $data);
    }
    else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
     }
     else {
        redirect(base_url(), 'refresh');
    }
}

    //    public function getmain_store_stock()
    //     {
    //         $pro_id = $this->input->post('id');
    //         $store_id = $this->input->post('store_id');
    //         $get_med_his =  $this->purchase_model->get_med_his($pro_id);
    //         //print_r($get_med_his);
           
    //         foreach($get_med_his as $val)
    //         {
          
    //             if(strtotime($val->expire_date) >= strtotime(date('Y-m-d')) ){
                 
    //                 echo  '<div class="row pos-remove-spacing">
    //                 <div class="col-md-2" style="">
    //                 <div class="input-group">
    //                 <input type="hidden" class="form-control" name="product_id[]"  id="product_id" tabindex="2" value ="'.$val->product_id.'" autocomplete="off">
    //                 <input type="hidden" class="form-control" name="supplier_id[]"  id="supplier_id" tabindex="2" value ="'.$val->supplier_id.'" autocomplete="off">
    //                 <input type="hidden" class="form-control" name="mrp"  id="mrp" tabindex="2" value ="'.$val->mrp.'" autocomplete="off">
    //                 <input type="text" class="form-control" name="batch[]"  id="batch" tabindex="2" value ="'.$val->Batch_Number.'" autocomplete="off" disabled>
    //                 </div>
    //                 </div>
    //                 <div class="col-md-2">
    //                 <div class="form-group">
    //                     <input type="text" class="form-control" name="exp_date" id="exp_date" value="'.$val->expire_date.'" autocomplete="off" disabled>
    //                 </div>
    //                 </div>
    //                 <div class="col-md-2">
    //                 <div class="form-group genric-left-sug">
    //                     <input type="text" class="form-control" name="stock" id="stock" value="'.$val->instock.'"  autocomplete="off" disabled>
    //                 </div>
    //                 </div>
    //                 <div class="col-md-2">
    //                 <div class="form-group">
    //                 <input type="text" class="form-control req_qty" date-id="" name="qty" id="req_qty" placeholder="Qty" autocomplete="off">
    //                 <input type="hidden" class="form-control"  name="store_id" id="store_id" value="'.$store_id.'">
    //                 </div>
    //                 </div>
    //                 <div class="col-md-2">
    //                 <div class="form-group">
    //                 <button class="btn btn-info" data-id="'.$val->Batch_Number.'" id="add_pos">Add</button>
    //                 </div>
    //                 </div>
                    
                    
    //                  </div>';
        
        
    //             }else{
           
    //        } 
    //     }
    // }

     public function get_med15()
     {
      $pro_id = $this->input->post('id');
      $store_id = $this->session->userdata('store_id');
      $get_med_his =  $this->purchase_model->get_med_his55($pro_id);
   
        foreach($get_med_his as $val)
        {
            $CI     = & get_instance();
            $get_received = $CI->get_received($val->product_id, $val->supplier_id, $val->Batch_Number);
            // print_r($get_received[0]->instock);
            $taxonmedicine = $this->purchase_model->get_taxonmedicine($val->product_id, $val->supplier_id, $val->Batch_Number);
           
            $qty = $taxonmedicine[0]->qty + $taxonmedicine[0]->free_qty;
            $tax = $taxonmedicine[0]->tax;
            $medmrp = $taxonmedicine[0]->mrp;
            $total = $taxonmedicine[0]->total_amount;
            $tot2 = $tax + $total;
            $purchase = $tot2/$qty;
            $totalwithtax = round($purchase, 2);
            if(strtotime($val->expire_date) >= strtotime(date('Y-m-d')) ){
                echo  '<div class="row pos-remove-spacing">
                <div class="col-md-2" style="">
                <div class="input-group">
                <input type="hidden" class="form-control" name="product_id[]"  id="product_id" tabindex="2" value ="'.$val->product_id.'" autocomplete="off">
                <input type="hidden" class="form-control" name="supplier_id[]"  id="supplier_id" tabindex="2" value ="'.$val->supplier_id.'" autocomplete="off">
                <input type="hidden" class="form-control" name="mrp"  id="mrp" tabindex="2" value ="'.$totalwithtax.'" autocomplete="off">
                <input type="hidden" class="form-control" name="medmrp"  id="mrp" tabindex="2" value ="'.$medmrp.'" autocomplete="off">
                <input type="text" class="form-control" name="batch[]"  id="batch" tabindex="2" value ="'.$val->Batch_Number.'" autocomplete="off" disabled>
                </div>
                </div>
                <div class="col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control" name="exp_date" id="exp_date" value="'.$val->expire_date.'" autocomplete="off" disabled>
                </div>
                </div>
                <div class="col-md-2">
                <div class="form-group genric-left-sug">
                    <input type="text" class="form-control" name="stock" id="stock" value="'.$val->instock.'"  autocomplete="off" disabled>
                </div>
                </div>
                <div class="col-md-2">
                <div class="form-group">
                <input type="text" class="form-control req_qty" date-id="" name="qty" id="req_qty" placeholder="Qty" autocomplete="off">
                <input type="hidden" class="form-control"  name="store_id" id="store_id" value="'.$store_id.'">
                </div>
                </div>
                <div class="col-md-2">
                <div class="form-group">
                <button class="btn btn-info" data-id="'.$val->Batch_Number.'" id="add_pos">Add</button>
                </div>
                </div>
                
                
                 </div>';
    
    
            }else{
             
       
       }
    }
      
   
    }

     public function get_med()
     {
      $pro_id = $this->input->post('id');
      $store_id = $this->input->post('store_id');
      $get_med_his =  $this->purchase_model->get_med_his($pro_id);
       
      foreach($get_med_his as $val)
      {
          if(strtotime($val->expire_date) >= strtotime(date('Y-m-d')) ){
  
              echo  '<div class="row pos-remove-spacing">
              <div class="col-md-2" style="">
              <div class="input-group">
              <input type="hidden" class="form-control" name="product_id[]"  id="product_id" tabindex="2" value ="'.$val->product_id.'" autocomplete="off">
              <input type="hidden" class="form-control" name="supplier_id[]"  id="supplier_id" tabindex="2" value ="'.$val->supplier_id.'" autocomplete="off">
              <input type="hidden" class="form-control" name="mrp"  id="mrp" tabindex="2" value ="'.$val->mrp.'" autocomplete="off">
              <input type="text" class="form-control" name="batch[]"  id="batch" tabindex="2" value ="'.$val->Batch_Number.'" autocomplete="off" disabled>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
                  <input type="text" class="form-control" name="exp_date" id="exp_date" value="'.$val->expire_date.'" autocomplete="off" disabled>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group genric-left-sug">
                  <input type="text" class="form-control" name="stock" id="stock" value="'.$val->instock.'"  autocomplete="off" disabled>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <input type="text" class="form-control req_qty" date-id="" name="qty" id="req_qty" placeholder="Qty" autocomplete="off">
              <input type="hidden" class="form-control"  name="store_id" id="store_id" value="'.$store_id.'">
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <button class="btn btn-info" data-id="'.$val->Batch_Number.'" id="add_pos">Add</button>
              </div>
              </div>
              
              
               </div>';
  
  
          }else{
     
     }
  }
    }

    public function add_transfer_stock(){
        $pid = $this->input->post('proid');
        $store_id = $this->input->post('store_id');
        $qty = $this->input->post('qty');
        $batchNumber = $this->input->post('batchNumber');
        $exp_date = $this->input->post('exp_date');
        $mrp = $this->input->post('mrp');
        
        $get_supplier = $this->invoice_model->get_supplier($pid, $batchNumber, $exp_date);
      
        $supplier_id = $get_supplier[0]->supplier_id;
        $purchase_rate = $get_supplier[0]->purchase_rate;
        $product = $this->invoice_model->SpecificMedicine12($pid);
        $hsn = $product[0]->hsn;
        $mrp1 = $get_supplier[0]->mrp;
        
        //$batch = $product[0]->mata_Batch;
        //$getsupprice = $this->invoice_model->SpecificMedicinemrp($pid,$batch,$supplier_id);
        //$medmrp = $product[0]->mata_mrp;
        $get_igst = $this->invoice_model->get_igst($hsn);
        $igst = $get_igst[0]->igst;
        $total = ($mrp * $qty);
        $tax = ($total*$igst)/100;
       
      
        
            
                $output =  "<tr class='premove'>
                                  <td><input type='hidden' class='pid' value='$pid' name='pid55[]'> <input type='hidden' class='pid' value='$batchNumber' name='batch_no55[]'> <input type='text' value='" . ($product[0]->product_name) . "' readonly></td>
                               
                                  <td> <input type='hidden' class='qty' value='$supplier_id' name='supplier_id55[]' readonly><input type='hidden' class='qty' value='$exp_date' name='exp_date55[]' readonly><input type='text' class='qty' value='$qty' name='qty55[]' readonly></td>
                                
                                  <td><input type='hidden' class='qty' value='$purchase_rate' name='purchase_rate55[]' readonly><input type='text' class='tax' value='$mrp' name='mrp55[]'><input type='hidden' class='tax' value='$mrp1' name='mrp551[]'></td>
                                  <td><input type='hidden' class='totall'  value='$store_id' name='store_id55[]'><input type='hidden' class='totall' value='$tax' name='tax55[]' readonly><input type='text' class='totall' value='$total' name='totall55[]' readonly></td>
                                 
                                  <td class='text-nowrap' id='btn'>
                                
                                      <i class='fa fa-close text-danger'>
                                      </i> 
                                    </a>
                                  </td>
                                
                                </tr>";
                 echo $output;
            }

            public function submit_stock_transfer15()
            {
              
                $to_transfer_stock = $this->input->post('store');
                $stock_transfer_id   =   'T'.rand(2000,10000000);
                $sum_total_amount = array();
                $sum_total_tax = array();
                $sum_total = array();
                $sum_total = 0;
                $sum_total_amount = 0;
                $sum_total_tax = 0;
                $createdat = time();
                $todayDate = date('Y-m-d');
            

                foreach($_POST['qty55'] as $row=>$name){
                    $qty   =   $_POST['qty55'][$row];
                    $store   =   $_POST['store'][$row];
                    $pid        =   $_POST['pid55'][$row];
                    $mrp        =   $_POST['mrp551'][$row];
                    $totall        =   $_POST['totall55'][$row];
                    $batch_no        =   $_POST['batch_no55'][$row];

                    $exp_date        =   $_POST['exp_date55'][$row];
                    $supplier_id        =   $_POST['supplier_id55'][$row];
                    $purchase_rate        =   $_POST['purchase_rate55'][$row];
                    $tax        =   $_POST['tax55'][$row];
                    $store_id        =   $_POST['store_id55'][$row];
                    $total_amount = $totall + $tax;
                    $sum_total = $sum_total + $totall;
                    $sum_total_amount = $sum_total_amount + $total_amount;
                    $sum_total_tax = $sum_total_tax + $tax;
                    $createdat = time();
                    $chech = array(
                        "pid"=> $pid,
                        "batch_no"=> $batch_no,
                        "supplier_id"=> $supplier_id,
                        "exp_date"=> $exp_date,
                    );
               
                   
                // Insert stock history
                  $data_stock_history = array(
                    "stock_transfer_id" => $stock_transfer_id,
                    "product_id" => $pid,
                   "supplier_id" => $supplier_id,
                    "Batch_Number" => $batch_no,
                    "expire_date" => $exp_date,
                    "purchase_rate" => $purchase_rate,
                    "mrp" => $mrp,
                    "instock" => $qty,
                    "tax" => $tax,
                    "createdAT" => $createdat,
                    "store_id" => $to_transfer_stock

                  );
                  
                 $insert_stock_history = $this->invoice_model->insert_stock_history($data_stock_history); 


 /* ******************************* */                

                // Insert medicine meta

               
                   
               // update main store inventory after transfer.
                 $sess_store = $this->session->userdata('store_id');

             // get existing stock quantity of main store                 
                 $check_sess_store_stock = $this->invoice_model->check_sess_store_stock($pid, $batch_no, $exp_date, $supplier_id, $sess_store);

             
                 
               
               if(!empty($check_sess_store_stock))
                 {
                     $pre_stk = $check_sess_store_stock[0]->instock;
                     $new_stk =  $pre_stk - $qty;

                     $data = array(
                        "instock" => $new_stk 
                     );
                     

                     $update_sess_store_stock = $this->invoice_model->update_sess_store_stock($pid, $batch_no, $exp_date, $supplier_id, $sess_store,$data); 
                    // print_r($update_sess_store_stock);
                   
                 }


                // update substore  inventory after transfer.
                // get existing stock quantity of main store  
                $check_pre_record = $this->invoice_model->check_pre_record($pid, $batch_no, $exp_date, $supplier_id, $to_transfer_stock);
                 
                if(!empty($check_pre_record)){
                    $pre = $check_pre_record[0]->instock;
                    $new_stock = $pre + $qty;
                    $stock = array(
                        "instock" => $new_stock
                    );
                   $update_store_medi_meta = $this->invoice_model->update_store_medi_meta($pid, $batch_no, $exp_date, $supplier_id, $to_transfer_stock, $stock); 
                }
                else{
               
                    $med_data = array(
                        "product_id" =>  $pid,
                        "supplier_id" =>  $supplier_id ,
                        "Batch_Number" =>  $batch_no ,
                        "expire_date" =>  $exp_date ,
                        "purchase_rate" =>  $purchase_rate ,
                        "mrp" =>  $mrp ,
                        "instock" =>  $qty ,
                        "tax" =>  $tax ,
                        "store_id" => $to_transfer_stock,
                        "status" => "1"
                        
                        
                 );
                  
                      $insert_med_meta = $this->invoice_model->insert_med_meta($med_data); 
                }
                        
             
                 
                }
                // Insert stock tranfer
            $stock = array(
                "stock_transfer_id" => $stock_transfer_id,
                "store_id" => $to_transfer_stock,
                "net_amount" => $sum_total,
                "total_tax" => $sum_total_tax,
                "total_amount" => $sum_total_amount,
                "createdat" => $createdat,
                "date" => $todayDate
            );
              


            $insert_stock_transfer = $this->invoice_model->insert_stock_transfer($stock);
      

               $response['status'] = 'success';
               $response['message'] = "Successfully Added";
               $response['curl'] = base_url('Invantory/manage_inventory');
              $this->output->set_output(json_encode($response));   
    }

            public function submit_stock_transfer()
            {
                    $stock_transfer_id   =   'T'.rand(2000,10000000);
                    $sum_total_amount = array();
                    $sum_total_tax = array();
                    $sum_total = array();
                    $sum_total = 0;
                    $sum_total_amount = 0;
                    $sum_total_tax = 0;
                    foreach($_POST['qty'] as $row=>$name){
                        $qty   =   $_POST['qty'][$row];
                        $store   =   $_POST['store'][$row];
                        $pid        =   $_POST['pid'][$row];
                        $mrp        =   $_POST['mrp'][$row];
                        $totall        =   $_POST['totall'][$row];
                        $batch_no        =   $_POST['batch_no'][$row];

                        $exp_date        =   $_POST['exp_date'][$row];
                        $supplier_id        =   $_POST['supplier_id'][$row];
                        $purchase_rate        =   $_POST['purchase_rate'][$row];
                        $tax        =   $_POST['tax'][$row];
                        $store_id        =   $_POST['store_id'][$row];
                        $total_amount = $totall + $tax;

                        $sum_total = $sum_total + $totall;
                        $sum_total_amount = $sum_total_amount + $total_amount;
                        $sum_total_tax = $sum_total_tax + $tax;
                        $createdat = time();
                       
                    // Insert stock history
                      $data = array(
                        "stock_transfer_id" => $stock_transfer_id,
                        "product_id" => $pid,
                       "supplier_id" => $supplier_id,
                        "Batch_Number" => $batch_no,
                        "expire_date" => $exp_date,
                        "purchase_rate" => $purchase_rate,
                        "mrp" => $mrp,
                        "instock" => $qty,
                        "tax" => $tax,
                        "createdAT" => $createdat

                      );
                    // $insert_stock_history = $this->invoice_model->insert_stock_history($data); 

                    // Insert medicine meta

                    $med_data = array(
                              "product_id" =>  $pid,
                              "supplier_id" =>  $supplier_id ,
                              "Batch_Number" =>  $batch_no ,
                              "expire_date" =>  $exp_date ,
                              "purchase_rate" =>  $purchase_rate ,
                              "mrp" =>  $mrp ,
                              "instock" =>  $qty ,
                              "tax" =>  $tax ,
                              "store_id" => $store_id,
                              
                              
                       );
                       // check medicine meta data
                    $check_pre_record = $this->invoice_model->check_pre_record($pid, $batch_no, $exp_date, $supplier_id, $store_id); 
                    if(!empty($check_pre_record)){
                        $pre = $check_pre_record[0]->instock;
                        $new_stock = $pre + $qty;
                        $stock = array(
                            "instock" => $new_stock
                        );
                        $update_store_medi_meta = $this->invoice_model->update_store_medi_meta($pid, $batch_no, $exp_date, $supplier_id, $store_id, $stock); 
                    }
                    else{
                          $insert_med_meta = $this->invoice_model->insert_med_meta($med_data); 
                    }
                   
                     
                    }
                    // Insert stock tranfer
                    $stock = array(
                        "stock_transfer_id" => $stock_transfer_id,
                        "store_id" => $store_id,
                        "net_amount" => $sum_total,
                        "total_tax" => $sum_total_tax,
                        "total_amount" => $sum_total_amount,
                        "createdat" => $createdat
                    );
                   
                    $insert_stock_transfer = $this->invoice_model->insert_stock_transfer($stock);
                    // Meta_medicine_stock

                    // Get medicine stock
                   $get_med_stock = $this->invoice_model->check_get_med_stock($pid, $batch_no, $exp_date, $supplier_id);
                   if(!empty($get_med_stock )){
                  
                   $pre_stock = $get_med_stock[0]->instock;
                   $new_stock = $pre_stock- $qty;
                   $data = array(
                    "instock" =>  $new_stock
                   );
                   $update_get_med_stock = $this->invoice_model->update_get_med_stock($pid, $batch_no, $exp_date, $supplier_id, $data);
                }else {}
                   //Update stock in medicine table
                   $get_medi_stock = $this->invoice_model->check_main_med_stock($pid);
                   $previous = $get_medi_stock[0]->instock;
                   $new_stock5 = $previous- $qty;
                   $data12 = array(
                    "instock" =>  $new_stock5
                   );
                   $update_stock_in_medicine = $this->invoice_model->update_stock_in_medicine($pid, $data12);
                   redirect(base_url() . 'Invantory/manage_inventory', 'refresh');         
            
        }
        public function request_transfer_stock(){
            $pid            = $this->input->post('proid');             
            $stock          = $this->input->post('stock');
            $qty            = $this->input->post('qty');
            $batchNumber    = $this->input->post('batchNumber');
            $mrp            = $this->input->post('mrp');
            $product        = $this->invoice_model->SpecificMedicine12($pid);
           $store_id = $this->session->userdata('store_id');
          
                    $output =  "<tr class='premove'>
                                      <td><input type='hidden' class='pid' value='$pid' name='pid[]'> <input type='text' value='" . ($product[0]->product_name) . "' readonly></td>
                                      <td><input type='text' class='pid' value='$batchNumber' name='batch_no[]'></td>
                                      <td> <input type='text' class='pid' value='$stock' name='stock[]'></td>
                                    
                                      <td><input type='text' class='qty' value='$qty' name='rqty[]' readonly></td>
                                      <td><input type='hidden' name='storeid' value='".$store_id."'><input type='text' class='totall' value='$mrp' name='mrp[]' readonly></td>
                                    
                                      <td class='text-nowrap'>
                                    
                                          <i class='fa fa-close text-danger'>
                                          </i> 
                                        </a>
                                      </td>
                                    
                                    </tr>";
                     echo $output;
                }
        public function submit_stock_request()
            {
                    $stock_rquest_id   =   'Req'.rand(2000,10000000);
                    $timezone = new DateTimeZone("Asia/Kolkata");
                    $datetime = new DateTime("now", $timezone);
                    
                    foreach($_POST['rqty'] as $row=>$name){
                        $rqty   =   $_POST['rqty'][$row];
                        $pid        =   $_POST['pid'][$row];
                       // $storeid        =   $_POST['storeid'][$row];
    
                    // Insert stock history
                      $data = array(
                        "request_id" => $stock_rquest_id,
                        "request_qty" => $rqty,
                        "product_id" => $pid,
                        "store_id" => $this->session->userdata('store_id'),
                        "createdat" => $datetime->format('Y-m-d H:i:s')

                      );
                    $insert_stock_request = $this->invoice_model->insert_stock_request($data);
                    if(!empty($insert_stock_request))
                    {
                        $response['status'] = 'success';
                        $response['message'] = "Successfully Added";
                        // $response['curl'] = "https://browncrystal.com/mad-pharma/Invantory/Request_stock_his";
                        $response['curl'] =  base_url('Invantory/Request_stock_his');
                       $this->output->set_output(json_encode($response));
                    }
                   

                    }
 
        }
        

            public function manage_inventory()
            {
                if($this->session->userdata('user_login_access') != False) {
                    $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                if (in_array(44, $permissions)) { 
                $data['transfer'] = $this->user_model->get_tranfer_inventory(); 
          
                $this->load->view('backend/manage_inventory', $data);
            }
            else {
                redirect(base_url().'Sales/auth_error', 'refresh');
            }
            }
            else{
                redirect(base_url() , 'refresh');
            } 
                }

            public function get_store_name($store_id)
            {
               return  $data = $this->user_model->get_store_name($store_id);
            }

            public function tran_all_med()
            {
                if($this->session->userdata('user_login_access') != False) {
                $store_id = $this->uri->segment(3);
                $data['transfer'] = $this->user_model->get_transfer_history($store_id); 
                $this->load->view('backend/tran_all_med', $data);
            }
            else{
                redirect(base_url() , 'refresh');
            } 
                }

            public function get_prduct_name($pro_id)
            {
              return  $data = $this->user_model->get_prduct_name($pro_id); 
            }

            public function supplier_name($supplier_id)
            {
                return  $supplier_name = $this->user_model->supplier_name($supplier_id);   
            }

            public function Request_stock()
            {
                if($this->session->userdata('user_login_access') != False) {
                    $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                   if (in_array(88, $permissions)) { 
                    $data['medicine'] = $this->medicine_model->get_medicine(); 
                    $this->load->view('backend/Request_stock', $data); 
                } else {
                    redirect(base_url().'Sales/auth_error', 'refresh');
                }
            }else{
                redirect(base_url() , 'refresh');
            } 
            
           
        }

//store inventory
          
                public function StoreStock() 
                {
                        if ($this->session->userdata('user_login_access') != false) {
                            $per = $this->permissionsbyemrole();
                 $permissions = explode(',', $per);
                            if (in_array(50, $permissions)) {
                            $storeID = $this->session->userdata('store_id');
                            $data['stock'] = $this->medicine_model->getStockstoreValupdated($storeID); 
                           // print_r($data['stock']);
                            $this->load->view('backend/Store_stock', $data);
                        } else {
                            redirect(base_url().'Sales/auth_error', 'refresh');
                        }
                        } else {
                            redirect(base_url(), 'refresh');
                        }
                }

                
                public function Stock_shortstock()
                {
                    if ($this->session->userdata('user_login_access') != false) {
                        $per = $this->permissionsbyemrole();
                 $permissions = explode(',', $per);
                        if (in_array(51, $permissions)) {
                        $storeID = $this->session->userdata('store_id');
                        $data['sortstock'] = $this->medicine_model->getstoreShortProduct($storeID); 
                        $this->load->view('backend/Store_shortstock', $data);
                    } else {
                        redirect(base_url().'Sales/auth_error', 'refresh');
                    }
                    } else {
                        redirect(base_url(), 'refresh');
                    }

                }

                public function Store_Stockout() 
                {
                        if ($this->session->userdata('user_login_access') != false) {
                            $per = $this->permissionsbyemrole();
                 $permissions = explode(',', $per);
                            if (in_array(52, $permissions)) {
                            $storeID = $this->session->userdata('store_id');
                            $data['stockout'] = $this->medicine_model->GetStockOutstoreproduct($storeID); 
                            $this->load->view('backend/Stock_storeout', $data);
                        } else {
                            redirect(base_url().'Sales/auth_error', 'refresh');
                        }
                        } else {
                            redirect(base_url(), 'refresh');
                        }
                }

               public function Stock_expire_storesoon() {

                    if ($this->session->userdata('user_login_access') != false) {
                        $per = $this->permissionsbyemrole();
                 $permissions = explode(',', $per);
                            if (in_array(53, $permissions)) {
                        $today = date("Y-m-d");
                        $todaystr = strtotime(date("d/m/Y"));
                        $onemonth = strtotime('1 month', $todaystr);
                        $month = date("Y-m-d", $onemonth); 
                        $data['expiresoonmedicine'] = $this->medicine_model->getStockExpiresoonstoreProduct($today, $month); // Corrected method name
                        $this->load->view('backend/Storestock_soon', $data);
                    } else {
                        redirect(base_url().'Sales/auth_error', 'refresh');
                    }
                    } else {
                        redirect(base_url(), 'refresh');
                    }
                }

                public function Stock_storeexpired() {
                    if ($this->session->userdata('user_login_access') != false) {
                        $per = $this->permissionsbyemrole();
                 $permissions = explode(',', $per);
                            if (in_array(54, $permissions)) {
                        $today = date("Y-m-d");
                        $data['expired'] = $this->medicine_model->GetexpiredstoreMedicine($today); 
                        $this->load->view('backend/Stock_storeexpired', $data);
                    } else {
                        redirect(base_url().'Sales/auth_error', 'refresh');
                    }
                    } else {
                        redirect(base_url(), 'refresh');
                    }
                }

                public function submit_sub_store_req()
                {
                   // $req =
                   $storeid =  $this->input->post('storeid');
                   $product_id =  $this->input->post('medicine');
                   $Batch_Number =  $this->input->post('batch_no');
                   $request_qty =  $this->input->post('rqty');
                   $mrp =  $this->input->post('mrp');

                   foreach($request_qty as $val)
                   {
                        $data = array(
                            "request_id" => $request_id,
                            "product_id" => $request_id,
                            "Batch_Number" => $request_id,
                            "request_qty" => $request_id,
                            "store_id" => $request_id,
                            "mrp" => $request_id
                        );
                   }
                }
public function stock_trans_reg()
{
    $pid            = $this->input->post('proid');             
   // $stock          = $this->input->post('stock');
    $qty            = $this->input->post('qty');
  //  $batchNumber    = $this->input->post('batchNumber');
  //  $mrp            = $this->input->post('mrp');
    $product        = $this->invoice_model->SpecificMedicine122($pid);
   $store_id = $this->session->userdata('store_id');
  
            $output =  "<tr class='premove'>
                              <td><input type='hidden' class='pid' value='$pid' name='pid[]'> <input type='text' value='" . ($product[0]->product_name) . "' readonly></td>
                              <td><input type='hidden' name='storeid' value='".$store_id."'><input type='text' class='qty' value='$qty' name='rqty[]' ></td>
                              <td class='text-nowrap'>
                                  <i class='fa fa-close text-danger' id='btn'>
                                  </i> 
                                </a>
                              </td>
                            
                            </tr>";
             echo $output; 
}

public function stock_rev_reg()
{
      $pid            = $this->input->post('proid');  
      $supplier_id            = $this->input->post('supplier_id');
      $batchNumber            = $this->input->post('batchNumber');
      $expire_date            = $this->input->post('expire_date');
      $qty            = $this->input->post('qty');

      $product        = $this->invoice_model->SpecificMedicine122($pid);
   
             $output =  "<tr class='premove'>
                               <td><input type='hidden' class='pid' value='$pid' name='pid[]'> <input type='text' class='border-0 bg-transparent' value='" . ($product[0]->product_name) . "' readonly></td>
                               <td> <input type='text' class='border-0 bg-transparent' name='supplier_id[]' value='" . ($supplier_id) . "' readonly></td>
                               <td> <input type='text' class='border-0 bg-transparent' name='batchNumber[]' value='" . ($batchNumber) . "' readonly></td>
                               <td> <input type='text' class='border-0 bg-transparent' name='expire_date[]' value='" . ($expire_date) . "' readonly></td>
                               <td><input type='text' class='qty' value='$qty' name='rqty[]' ></td>
                               <td id='btn' class='text-nowrap'>
                                   <i class='fa fa-close text-danger'>
                                   </i> 
                                 </a>
                               </td>
                             
                             </tr>";
              echo $output;   
}
public function add_medicin_for_request(){

    $medID = $this->input->post('id');
    $info = $this->medicine_model->GetMedicineValueById($medID);

   // print_r($info);


    echo  '<div class="row pos-remove-spacing">
    <div class="col" style="">
    <div class="input-group">
    <input type="text" class="form-control" name="product_id[]"  id="product_id" tabindex="2" value ="'.$info->product_id.'" readonly autocomplete="off">
    
    </div>
    </div>
   
    <div class="col">
    <div class="form-group">
    <input type="text" class="form-control" name="product_name[]"  id="product_id" tabindex="2" value ="'.$info->product_name.'" readonly autocomplete="off">
       
    </div>
    </div>
    <div class="col">
    <div class="form-group">
    <input type="text" class="form-control" name="product_Gen_name[]"  id="product_id" tabindex="2" value ="'.$info->generic_name.'" readonly autocomplete="off">
      
    </div>
    </div>
    

    
    <div class="col">
    <div class="form-group">
       <input type="text" class="form-control req_qty" date-id="" name="qty" id="req_qty" autocomplete="off" placeholder="Qty">
    </div>
    </div>
    <div class="col">
    <div class="form-group">
    <button class="btn btn-info" data-id="'.$info->product_id.'" id="add_pos">Add</button>
    </div>
    </div>
     </div>';
    

}
public function fill_qty()
{
    $pro_id = $this->input->post('id');
    $store_id = $this->input->post('store_id');
    
    $get_store_d =  $this->purchase_model->get_store_d($store_id);
    
    $get_med_his =  $this->purchase_model->check_med_for_rev($pro_id, $get_store_d[0]->id);
    $info = $this->medicine_model->GetMedicineValueById($get_med_his[0]->product_id);
    $supplier = $this->medicine_model->GetSupplierValueById($get_med_his[0]->supplier_id);

     foreach($get_med_his as $val)
     {
        $pro_id = $val->product_id;
        $supplier_id = $val->supplier_id;
        $Batch_Number = $val->Batch_Number;
        $expire_date = $val->expire_date;
        $instock = $val->instock;
        
        
              echo  '<div class="row pos-remove-spacing">
              <div class="col" style="">
              <div class="input-group">
              <input type="hidden" class="form-control" name="product_id[]"  id="product_id" tabindex="2" value ="'.$pro_id.'" autocomplete="off">
              <input type="text" class="form-control" name="product_id1[]"  id="product_id1" tabindex="2" value ="'.$info->product_name.'">
              </div>
              </div>
              <div class="col">
              <div class="form-group">
              <input type="hidden" class="form-control req_qty" date-id="" name="supplier_id" id="supplier_id" value ="'.$supplier_id.'">
                 <input type="text" class="form-control req_qty" date-id="" name="supplier_id1" id="supplier_id1" value ="'.$supplier->s_name.'">
              </div>
              </div>
              <div class="col">
              <div class="form-group">
                 <input type="text" class="form-control req_qty" date-id="" name="Batch_Number" id="Batch_Number" value ="'.$Batch_Number.'">
              </div>
              </div>
              <div class="col">
              <div class="form-group">
                 <input type="text" class="form-control req_qty" date-id="" name="expire_date" id="expire_date" value ="'.$expire_date.'">
              </div>
              </div>
        
              <div class="col">
              <div class="form-group">
                 <input type="text" class="form-control req_qty" date-id="" name="instock[]" id="instock" value ="'.$instock.'">
              </div>
              </div>
              <div class="col">
              <div class="form-group">
                 <input type="text" class="form-control req_qty" date-id="" name="qty" id="req_qty" autocomplete="off">
              </div>
              </div>
              <div class="col">
              <div class="form-group">
              <button class="btn btn-info" data-id="'.$Batch_Number.'" id="add_pos">Add</button>
              </div>
              </div>
               </div>';
           }
}

public function requested_stock()
 {
    if ($this->session->userdata('user_login_access') != false) {
        $per = $this->permissionsbyemrole();
        $permissions = explode(',', $per);
    if (in_array(46, $permissions)) { 
        $data['requestedstock'] = $this->medicine_model->GetrequestStock(); 
        $this->load->view('backend/requested_stock', $data);
    }
    else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
    } else {
    
        redirect(base_url(), 'refresh');
    }
 }

           public function history_requested()
            {
                if ($this->session->userdata('user_login_access') != false) {
                $request_id = $this->uri->segment(3);
                $data['transfer'] = $this->user_model->get_req_his($request_id); 
               
               $this->load->view('backend/history_requested', $data);
            }
            else {
    
                redirect(base_url(), 'refresh');
            }
         }

            public function get_generic($med_id)
            {
              return   $get_generic = $this->medicine_model->get_generic($med_id);  
            }


            public function reverse_request()
            {
               if ($this->session->userdata('user_login_access') != false) {
                $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                if (in_array(48, $permissions)) { 
                   $data['medicine'] = $this->medicine_model->get_medicine(); 
                  $data['store'] = $this->medicine_model->get_store(); 
                 //  print_r($data['store']);

                  $this->load->view('backend/reverse_request', $data);
                }
                else {
                    redirect(base_url().'Sales/auth_error', 'refresh');
                }
               } 
               else {
    
                redirect(base_url(), 'refresh');
            }
               
            }

            public function submit_rev_request()
            {
                $pro_id = $this->input->post('pid');
                $store_id = $this->input->post('store');
                $get_store_id= $this->user_model->get_store_id($store_id); 
                $store_id = $get_store_id[0]->id;
                $rqty = $this->input->post('rqty');
                $stock_reverserquest_id   =   'Req'.rand(2000,10000000);
                foreach($_POST['rqty'] as $row=>$name)
                {
                 
                    $pid        =   $_POST['pid'][$row];
                    $supplier_id        =   $_POST['supplier_id'][$row];
                    $Batch_Number        =   $_POST['batchNumber'][$row];
                    $expire_date        =   $_POST['expire_date'][$row];
                    $rqty   =   $_POST['rqty'][$row];
                    $store   =   $_POST['store'][$row];

                    $data = array(
                        "product_id" => $pid, 
                        "supplier_id" => $supplier_id,
                        "Batch_Number" => $Batch_Number,
                        "expire_date" => $expire_date,
                        "request_id" => $stock_reverserquest_id,
                        "qty" => $rqty, 
                        "from_store_id" => $store_id, 
                    );
                    $result = $this->invoice_model->insert_rev_stock($data);
                    $response['status'] = 'success';
                    $response['message'] = "Successfully Added";
                    $response['curl'] =  base_url('Invantory/Request_stock_history');
                    $this->output->set_output(json_encode($response));   
                
                }
          
            }
            public function permissionsbyemrole(){
                $id = $_SESSION['user_type'];
                $permission = $this->user_model->getAllpermissionsbyemid($id);  
                return $permissions1 = $permission[0]->permissions;
            }

            public function reverse_request_store()
            {
               if ($this->session->userdata('user_login_access') != false) {
                $per = $this->permissionsbyemrole();
                 $permissions = explode(',', $per);
                if (in_array(90, $permissions)) { 
                $store_id = $this->session->userdata('store_id');
                $data['requestedstock'] = $this->invoice_model->get_requested_stock($store_id);
               
                $this->load->view('backend/reverse_request_store', $data);
            }
            else {
                redirect(base_url().'Sales/auth_error', 'refresh');
            }
               } 
               else{
                redirect(base_url() , 'refresh');
            } 
            }

            public function Request_stock_his()
            {
                if ($this->session->userdata('user_login_access') != false) {
                    $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
               if (in_array(89, $permissions)) { 
                $data['stock_his'] = $this->invoice_model->Request_stock_his(); 
                $this->load->view('backend/Request_stock_his', $data);
            }
            else {
                redirect(base_url().'Sales/auth_error', 'refresh');
            }
            }
            else{
                redirect(base_url() , 'refresh');
            } 
                }

            public function history_requestedstore()
            {
                $request_id = base64_decode($this->input->get('q'));
                $data['reversehistory'] = $this->user_model->get_req_store($request_id); 
               $this->load->view('backend/reverse_history_store', $data);
            }

            public function stock_his_by_sub()
            {

                $req_id = $this->uri->segment(3);
               // print_r($req_id);
                $data['history'] = $this->invoice_model->stock_his_by_sub($req_id); 
                $this->load->view('backend/stock_his_by_sub', $data);
            }
            // public function stock_his_by_reqid()
            // {

            //     $req_id = $this->uri->segment(3);
            //    // print_r($req_id);
            //     $data['history'] = $this->invoice_model->stock_his_by_reqid($req_id); 
            //     $this->load->view('backend/stockhis_adjview',$data);
            // }
             public function get_pro_name($id)
             {
                return $data = $this->invoice_model->get_pro_name($id); 
             }

             public function view_all_stock()
             {
                if ($this->session->userdata('user_login_access') != false) {
                $pro_id =   $this->uri->segment(3);
                $sup_id =   $this->uri->segment(4);
                $batch =   str_replace('_',' ',$this->uri->segment(5));
               $data['stock'] = $this->invoice_model->view_all_stock($pro_id, $sup_id, $batch);
               $this->load->view('backend/view_all_stock', $data); 

              
             }
             else{
                redirect(base_url() , 'refresh');
            } 
                }
             

             public function Request_stock_history()
             {
                if ($this->session->userdata('user_login_access') != false) {
                    $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                if (in_array(47, $permissions)) { 
                 $store_id = $this->session->userdata('store_id');
                  $data['history'] = $this->invoice_model->req_stock_history();
                 $this->load->view('backend/Request_stock_history', $data);
                }
                else {
                    redirect(base_url().'Sales/auth_error', 'refresh');
                }
                } 
                else{
                    redirect(base_url() , 'refresh');
                } 
                    }
             

             public function admin_req_his()
             {
                if ($this->session->userdata('user_login_access') != false) {
                 
                    $req_id = $this->uri->segment(3);
                    $data['history'] = $this->invoice_model->admin_req_his($req_id);
                     $this->load->view('backend/admin_req_his', $data);
                } 
                else{
                    redirect(base_url() , 'refresh');
                } 
                    
             }

             public function append_medicine()
             {
                $store_id = $this->input->post('store_id');
                $store = $this->invoice_model->get_store_id($store_id);
                $store_id = $store[0]->id;
                 $data = $this->invoice_model->append_medicine($store_id);
                 $med_info = array();
                 

                  foreach($data as $val)
                  {
                   // print_r($val);
                    $pro_id =  $val->product_id ;
                    $medicine = $this->invoice_model->get_medicine_name($pro_id);

                    $pro_id = $medicine[0]->product_id;
                    $pro_name = $medicine[0]->product_name;
                    $data1 = array();
                   
                    array_push($data1, $pro_id );
                    array_push($data1, $pro_name );
                    // $data[] = $pro_id;
                    // $data[] = $pro_name;
                    array_push($med_info, $data1 );
                  

                  }
                  $response['result'] = $med_info;
                  echo json_encode($med_info);
             }

// Approve return stock request by substore.
    public function stock_return_update()
    {
        
        $storeID = $this->session->userdata('store_id');
        $requestID = $this->input->post('reqID');
        $reqID = base64_encode($this->input->post('reqID'));
        $supID = $this->input->post('supID');
        $medID = $this->input->post('medID');
        $medQty = $this->input->post('medQty');
        $medBth = $this->input->post('medBth');

        $instock = $this->purchase_model->getinstock_store_med($supID,$medID,$medBth,$storeID);

        $updatedSTK = $instock - $medQty;

        $stockdata = array(
                            "instock" => $updatedSTK
                        );
        $updatestock= $this->purchase_model->update_instock_store_med($supID,$medID,$medBth,$storeID,$stockdata);


        $mainstoreID = 78;
        $maininstock = $this->purchase_model->getinstock_store_med($supID,$medID,$medBth,$mainstoreID);


        $updatedSTKmain = $maininstock + $medQty;

        $mainstockdata = array(
            "instock" => $updatedSTKmain
        );

        $updatestock= $this->purchase_model->update_instock_store_med($supID,$medID,$medBth,$mainstoreID,$mainstockdata);

        $statusdata = array(
            "rev_status" => 1
        );
        $statusUpdate = $this->purchase_model->update_rev_status_store_med($requestID,$supID,$medID,$medBth,$storeID,$statusdata);



        $response['status'] = 'success';
        $response['message'] = "Successfully Stock updated";
        $response['curl'] =  base_url('Invantory/history_requestedstore?q='.$reqID);
        $this->output->set_output(json_encode($response)); 
    }  


    public function check_stock($req)
    {
      return  $check_stock = $this->purchase_model->check_stock($req);
    }

    public function check_status($req, $pro)
    {
        return  $check_stock = $this->purchase_model->check_status($req, $pro); 
    }

    
public function return_stock()
{
    
    $req_id = $this->input->post('req_id');
    $pro_id = $this->input->post('pro_id');
    $demand = $this->input->post('demand');
    $to_store = $this->input->post('to_store');
   

     $stock = $this->purchase_model->check_store_medi_stock($pro_id);
     $this->load->view('backend/return_back_stock', $data);
    // $pending = $demand; 
    // $get_req_his = $this->user_model->get_req_his($req_id);
    // foreach ($stock as $val) {
    //  //print_r($val);
    //     $get_sub_store = $this->purchase_model->get_sub_store($pro_id,$val->supplier_id, $val->Batch_Number, $val->expire_date, $to_store); 
    //     $instock = $val->instock;
     

    //     if ($instock > 0) {
    //         if ($instock >= $pending) {
    //             $instock = $instock - $pending;

    //             $req_stock = array(
    //                 "full_fill_qty" => $demand
    //             );
    //             $update_req_id_stock = $this->purchase_model->update_req_id_stock($req_id, $req_stock, $pro_id);
    //            // print_r($update_req_id_stock);
    //            // Main store Stock Update
    //             $data = array(
    //                 "instock" => $instock
    //             );
              
    //             $store_id = $this->session->userdata('store_id');
    //             $update = $this->purchase_model->update_store_med_meta_stock($data, $pro_id, $val->id);

    //             // Sub store Stock Update/Insert
     
    //                         if(!empty($get_sub_store))
    //                         {
    //                             $data = array(
    //                                 "instock" => $get_sub_store[0]->instock + $pending
    //                             );
    //                             $update_sub_store_stock = $this->purchase_model->update_sub_store_stock($pro_id,$val->supplier_id, $val->Batch_Number, $val->expire_date, $to_store, $data);
    //                         }
    //                         else{

    //                             $return = array(
    //                                 "product_id"=> $val->product_id,
    //                                 "supplier_id"=> $val->supplier_id,
    //                                 "Batch_Number"=> $val->Batch_Number,
    //                                 "manf_date"=> $val->manf_date,
    //                                 "expire_date"=> $val->expire_date,
    //                                 "purchase_rate"=> $val->purchase_rate,
    //                                 "mrp"=> $val->mrp,
    //                                 "instock"=> $demand,
    //                                 "sale_qty"=> $val->sale_qty,
    //                                 "discount"=> $val->discount,
    //                                 "tax"=> $val->tax,
    //                                 "store_id"=> $to_store,
    //                             );
    //                             $return_back = $this->purchase_model->return_back($return);
    //                         }
               
             
    //            break;
    //         } else {
              

    //             $pending =  $pending - $instock; 
                 

    //             $req_stock = array(
    //                 "full_fill_qty" => $instock
    //             );


    //             $update_req_id_stock = $this->purchase_model->update_req_id_stock($req_id, $req_stock, $pro_id);

    //             if(!empty($get_sub_store))
    //             {
    //              $data1 = array(
    //                  "instock" => $get_sub_store[0]->instock + $instock
    //              );
    //              $update_sub_store_stock = $this->purchase_model->update_sub_store_stock($pro_id,$val->supplier_id, $val->Batch_Number, $val->expire_date, $to_store, $data1);
    //             }
    //             else{
    //                 $return = array(
    //                     "product_id"=> $val->product_id,
    //                     "supplier_id"=> $val->supplier_id,
    //                     "Batch_Number"=> $val->Batch_Number,
    //                     "manf_date"=> $val->manf_date,
    //                     "expire_date"=> $val->expire_date,
    //                     "purchase_rate"=> $val->purchase_rate,
    //                     "mrp"=> $val->mrp,
    //                     "instock"=> $instock,
    //                     "sale_qty"=> $val->sale_qty,
    //                     "discount"=> $val->discount,
    //                     "tax"=> $val->tax,
    //                     "store_id"=> $to_store,
    //                   );
                     
    //                   $return_back = $this->purchase_model->return_back($return);
    //                }

    //                //Main store stock update
    //             $instock = 0;
    //             $data = array(
    //                 "instock" => $instock
    //             );
            
    //             $store_id = $this->session->userdata('store_id');
    //             $update = $this->purchase_model->update_store_med_meta_stock($data, $pro_id, $val->id);
    //         }
            
    //     }
     
    // }
    // $data = array(
    //     "status" => "returned"
    // );
    // $update = $this->purchase_model->update_req_stock_status($req_id, $data);
    // $response['status'] = 'success';
    // $response['message'] = "Successfully Stock updated";
    // $response['curl'] =  base_url('Invantory/history_requested/'.$req_id);
    // $this->output->set_output(json_encode($response));
}

public function return_back_stock()
{
       $pro_id = $this->uri->segment(3);
       $to_store = $this->uri->segment(4);

      $data['stock'] = $this->purchase_model->check_store_medi_stock($pro_id);
       $this->load->view('backend/return_back_stock', $data);
}

public function submit_return_stock()
{
   
   
   $stock = $this->input->post('stock');
   $to_store = $this->input->post('to_store');
   $req_id = $this->input->post('req_id');
 
   $main_store = $this->session->userdata('store_id');
   $total_return = 0; 
   foreach($_POST['stock'] as $row=>$name)
   {
  
    
       $pid                 =   $_POST['pro_id'][$row];
       $supplier_id         =   $_POST['supplier_id'][$row];
       $batch               =   $_POST['batch'][$row];
       $exp_date            =   $_POST['exp_date'][$row];
       $stock               =   $_POST['stock'][$row];
       $return              =   $_POST['return'][$row];

 

    if($return>0)
    {
        $get_sub_store = $this->purchase_model->get_sub_store($pid, $supplier_id, $batch, $exp_date, $main_store);   
        
        //update main store 
        $pre = $get_sub_store[0]->instock;
        $new_stock = $pre - $return;
         $data = array(
            "instock" => $new_stock,
            //"status" => 1
         );
         $update = $this->purchase_model->update_sub_store_stock($pid, $supplier_id, $batch, $exp_date, $main_store, $data);

         //update sub store
         $check_sub = $this->purchase_model->get_sub_store($pid, $supplier_id, $batch, $exp_date, $to_store); 
        if(!empty($check_sub))
         {
            $pre = $check_sub[0]->instock;
            $new = $pre + $return;
            $data1 = array(
                "instock" => $new,
                "status" => 1
            );
            $update_sub_store_stock = $this->purchase_model->update_sub_store_stock($pid,$supplier_id, $batch, $exp_date, $to_store, $data1);

            // Update Stock Request
           
            $total_return  = $total_return + $return;
          
            $stock = array(
                "full_fill_qty" => $total_return,
                "status" => "returned"
            );

            $update_stock_request = $this->purchase_model->update_stock_request($req_id, $pid, $stock);
           // print_r($update_stock_request);
          
          

         }      
         else{
            $data = array(
                "product_id"=> $get_sub_store[0]->product_id,
                "supplier_id"=> $get_sub_store[0]->supplier_id,
                "Batch_Number"=> $get_sub_store[0]->Batch_Number,
                "manf_date"=> $get_sub_store[0]->manf_date,
                "expire_date"=> $get_sub_store[0]->expire_date,
                "purchase_rate"=> $get_sub_store[0]->purchase_rate,
                "mrp"=> $get_sub_store[0]->mrp,
                "instock"=> $return,
                "sale_qty"=> $get_sub_store[0]->sale_qty,
                "discount"=> $get_sub_store[0]->discount,
                "tax"=> $get_sub_store[0]->tax,
                "store_id"=> $to_store,
                "status" => 1
              );
             
              $return_back = $this->purchase_model->return_back($data);
              // Update Stock Request
           
            $total_return  = $total_return + $return;
          
            $stock = array(
                "full_fill_qty" => $total_return,
                "status" => "returned"
            );

            $update_stock_request = $this->purchase_model->update_stock_request($req_id, $pid, $stock);
           // print_r($update_stock_request);
          }

    }  
}
    $response['status'] = 'success';
    $response['message'] = "Stock Transfered Successfully";
    $response['curl'] =  base_url('Invantory/requested_stock/'.$req_id);
    $this->output->set_output(json_encode($response));

}

public function get_received($product_id, $supplier_id, $Batch_Number)
{
    return $return_back = $this->purchase_model->get_received($product_id, $supplier_id, $Batch_Number);
}

public function get_receivedAllInv($product_id, $supplier_id, $Batch_Number)
{
    return $return_back = $this->purchase_model->get_receivedAllInv($product_id, $supplier_id, $Batch_Number);
}

public function stock_adjus()
{
    if($this->session->userdata('user_login_access') != False) {
        $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                if (in_array(49, $permissions)) { 
   $data['medicine'] =  $this->purchase_model->get_adjus_medicine();
   $this->load->view('backend/stock_adjus', $data); 
}
else {
    redirect(base_url().'Sales/auth_error', 'refresh');
}
}
else{
    redirect(base_url() , 'refresh');
} 
    }

    public function stock_adjushis()
{
    if($this->session->userdata('user_login_access') != False) {
        $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                if (in_array(102, $permissions)) { 
   $data['stockadjhis'] =  $this->purchase_model->get_alladjus_meddata();
   $this->load->view('backend/stock_adjushis',$data); 
}
else {
    redirect(base_url().'Sales/auth_error', 'refresh');
}
}
else{
    redirect(base_url() , 'refresh');
} 
    }

public function get_supplier_name($id)
             {
                return $data = $this->invoice_model->get_supplier_name($id); 
             }

}
      
    



