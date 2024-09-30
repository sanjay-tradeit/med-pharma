<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Purchase extends CI_Controller {
	    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('purchase_model');
        $this->load->model('supplier_model');
        $this->load->model('medicine_model');
        $this->load->model('configuration_model');
        $this->load->model('user_model');
        $this->load->model('invoice_model');
        $this->load->model('Hsn_model');
        $this->load->model('Store_model');
        
       
        $this->load->model('customer_model');

    }

	public function index()

	{
		#Redirect to Admin dashboard after authentication
		if ($this->session->userdata('user_login_access') != 1)
            redirect(base_url() . 'login', 'refresh');
        if ($this->session->userdata('user_login_access') == 1)
          $data= array();
        redirect('dashboard/Dashboard');
	}
    public function purchaseedit_draft()
    {
        if($this->session->userdata('user_login_access') != False) {
        $returnid = $this->uri->segment(3);
        $data = array();
        $data['supplierList'] = $this->medicine_model->get_supplierlist();
        $data['purchasehistory'] = $this->purchase_model->GetPurchaseHistorybyId($returnid);
        $purchaseDraftmeta = $this->purchase_model->GetPurchaseHistorymetabyId($returnid);
        
        if(!empty($purchaseDraftmeta)){
            $data['medicine']    = $purchaseDraftmeta;
        }
        else{
            $data['medicine'] = '';
        }

        
        //$data['transfer'] = $this->user_model->get_transfer_history($store_id); 
        $this->load->view('backend/purchaseedit_draft',$data);
    }
    else{
        redirect(base_url() , 'refresh');
    } 
        }


    public function purchase_draftview(){ 
        if($this->session->userdata('user_login_access') != False) {
       $data['draftlist'] = $this->purchase_model->Getalldrafts();     
       $this->load->view('backend/pur_draft', $data);
   
       }
   else{
       redirect(base_url() , 'refresh');
   }             

   }
    public function Create(){ 
         if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                if (in_array(34, $permissions)) { 
        $data = array();
        $data['supplierList'] = $this->supplier_model->getAllSupplier();
        $data['storeList'] = $this->supplier_model->getAllStore();
        $data['bankinfo'] = $this->user_model->Getbankinfowithsupplier();     
        $this->load->view('backend/Add_purchase',$data);
    }
    else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
        }
    else{
		redirect(base_url() , 'refresh');
	}             

    }
    public function GetSupplierByid(){
            $midbatch = $_POST['search'];
               if(empty($midbatch)){
                   die();
               }
               $this->purchase_model->GetSuppIDbatch($midbatch);
    }

    public function store_name()
    {
       $get_store_name =  $this->purchase_model->store_name($storeid);
        echo json_encode($get_store_name);
    }

    public function supplier_name()
    {
       $get_supplier_name =  $this->purchase_model->supplier_name();
        echo json_encode($get_supplier_name);
    }

    public function GetPurchaseparam(){
      if ($this->session->userdata('user_login_access') != False) {
        $param = $_GET['param'];
        $purval = $this->purchase_model->GetPurchaseparam($param);
        echo json_encode($purval);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function medicinebysupplierId(){
        if ($this->session->userdata('user_login_access') != False) {
            $id          = $this->input->get('id');
            $medicine    = $this->medicine_model->getSupplierMedicine($id);

            $medsubform = $this->medicine_model->getMedicinesubForm($id);
            
            if(!empty($medsubform)){
            $medsubFormArray= explode(',',$medsubform[0]->subform);
            }
            else{
                
            }        
            foreach ($medicine as $value) {
                $result = $this->medicine_model->getformbyid($value->form);
                $title = $result[0]->title;
                $GST    = $this->Hsn_model->GetHsnDetailsById($value->hsn);
                $unitList = $this->medicine_model->Getunitsbyform($value->form);
                $proid = $value->product_id;
                $string = preg_replace('/\s+/','',$proid);
                echo "<tr>    
                            <td>
                            <input type='hidden' class='form-control medicine' id='medicine' name='medicine[]' placeholder='' readonly value='$value->product_id'>
                            <input type='text' class='form-control'  name='mname[]' readonly value='$value->product_name.($value->strength)'>
                            <input type='hidden' class='form-control'  name='ids[]' readonly value='2024'>
                            </td>
                            <td><input type='text' class='form-control' name='gname[]' placeholder='' readonly value='$value->generic_name'></td>
                            <td><input id='form' type='text' class='form-control' name='model[]' placeholder='' readonly value='$title'></td>
                            <td style='width: 110px;'>
                                <select id='units$string' class='form-control' name='units[]'>";
                                foreach($medsubFormArray as $unitid) {

                                    $subformUnit = $this->medicine_model->subformUnit($unitid);
                                    
                                    echo "<option value='".$subformUnit[0]->id."'>".$subformUnit[0]->unit."</option>";
                    
                                }
                                    
                echo           "</select>
                                <a id='refresh' data-pid='$value->product_id' style='font-size:20px;color: #1976d2;float: right;cursor: pointer;' onclick='refreshunits($string)'><i class='fa fa-refresh'></i></a>
                            </td>
                            <td><input type='text' class='form-control batch_no' name='batch_no[]'  value=''></td>
                            <td><input type='date' class='form-control datepicker valid' name='expiredate[]' value='' id='datepicker' required></td>
                                                      
                            <td><input type='text' class='form-control qty' name='qty[]' placeholder='0.00' value='' required></td>    
                            <td><input type='text' class='form-control freeqty' name='freeqty[]' placeholder='0.00' value=''></td>                                                      
                            <td><input type='text' class='form-control tradeprice' name='tradeprice[]' placeholder='0.00' value=''></td>
                            <td><input type='text' class='form-control mrp' name='mrp[]' placeholder='0.00' value=''></td>
                            
                            <td><input type='text' class='form-control wholesaler' name='wholesaler[]' placeholder='0.00' value ='0'><input type='hidden' class='form-control discount' name='discount[]' placeholder='0.00' value ='0'></td>
                            <td><input readonly type='text' class='form-control tax' name='tax[]' placeholder='0.00'>
                            <input type='hidden' class='form-control hsn' name='hsn[]'  value='$GST->igst'></td>
                            <td><input readonly type='text' class='form-control total' name='total[]' placeholder='0.00' value='0'>
                            <input type='hidden' class='form-control tdiscount' name='tdiscount[]' placeholder='0.00'  value='0'>
                            <input type='hidden' class='form-control idd' name='idd[]' placeholder='0.00'  value='0'>
                            </td>
                            <td id='btn'><i class='fa fa-times-circle-o' aria-hidden='true'></i></td>
                            
                            
                    </tr>";                    
            }
        } 
        else {
            redirect(base_url(), 'refresh');
        }
    }  
    public function medicinebysupplierId5(){
        if ($this->session->userdata('user_login_access') != False) {
            $id          = $this->input->get('id');
            $medicine    = $this->medicine_model->getSupplierMedicine($id);

            $medsubform = $this->medicine_model->getMedicinesubForm($id);
            
            if(!empty($medsubform)){
            $medsubFormArray= explode(',',$medsubform[0]->subform);
            }
            else{
                
            }

            
            
          
         
            foreach ($medicine as $value) {
                $result = $this->medicine_model->getformbyid($value->form);
                $title = $result[0]->title;
                $GST    = $this->Hsn_model->GetHsnDetailsById($value->hsn);
                $unitList = $this->medicine_model->Getunitsbyform($value->form);
                $proid = $value->product_id;
                $string = preg_replace('/\s+/','',$proid);
                echo "<tr>    
                            <td>
                            <input type='hidden' class='form-control medicine' id='medicine' name='medicine[]' placeholder='' readonly value='$value->product_id'>
                            <input type='text' class='form-control'  name='mname[]' readonly value='$value->product_name.($value->strength)'>
                            </td>
                            <td><input type='text' class='form-control' name='gname[]' placeholder='' readonly value='$value->generic_name'></td>
                            <td><input id='form' type='text' class='form-control' name='model[]' placeholder='' readonly value='$title'></td>
                            <td style='width: 110px;'>
                                <select id='units$string' class='form-control' name='units[]'>";
                                foreach($medsubFormArray as $unitid) {

                                    $subformUnit = $this->medicine_model->subformUnit($unitid);
                                    
                                    echo "<option value='".$subformUnit[0]->id."'>".$subformUnit[0]->unit."</option>";
                    
                                }
                                    
                echo           "</select>
                                <a id='refresh' data-pid='$value->product_id' style='font-size:20px;color: #1976d2;float: right;cursor: pointer;' onclick='refreshunits($string)'><i class='fa fa-refresh'></i></a>
                            </td>
                            <td><input type='text' class='form-control batch_no' name='batch_no[]'  value=''></td>
                            <td><input type='date' class='form-control datepicker valid' name='expiredate[]' value='' id='datepicker' required></td>
                                                      
                            <td><input type='text' class='form-control qty' name='qty[]' placeholder='0.00' value='' required></td>    
                            <td><input type='text' class='form-control freeqty' name='freeqty[]' placeholder='0.00' value=''></td>                                                      
                            <td><input type='text' class='form-control tradeprice' name='tradeprice[]' placeholder='0.00' value=''></td>
                            <td><input type='text' class='form-control mrp' name='mrp[]' placeholder='0.00' value=''></td>
                            
                            <td><input type='text' class='form-control wholesaler' name='wholesaler[]' placeholder='0.00' value ='0'><input type='hidden' class='form-control discount' name='discount[]' placeholder='0.00' value ='0'></td>
                            <td><input readonly type='text' class='form-control tax' name='tax[]' placeholder='0.00'>
                            <input type='hidden' class='form-control hsn' name='hsn[]'  value='$GST->igst'></td>
                            <td><input readonly type='text' class='form-control total' name='total[]' placeholder='0.00' value='0'>
                            <input type='hidden' class='form-control tdiscount' name='tdiscount[]' placeholder='0.00'  value='0'>
                            <input type='hidden' class='form-control idd' name='idd[]' placeholder='0.00'  value='0'>
                            </td>
                            <td id='btn'><i class='fa fa-times-circle-o' aria-hidden='true'></i></td>
                            
                            
                    </tr>";                    
            }
        } 

    }  
    public function medicinebysupplierId6() {
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->get('id');
            $medicine = $this->medicine_model->getMedicinesfromHis($id);

            foreach ($medicine as $value) {
                $mid = $value->mid; 
                $medicinedetails = $this->medicine_model->getSupplierMedicine($mid);
                
                $medsubform = $this->medicine_model->getMedicinesubForm($value->mid);
                $medsubFormArray = explode(',', $medsubform[0]->subform);
                
                $result = $this->medicine_model->getformtitle($medicinedetails[0]->form);
                $subformUnit = $this->medicine_model->subformUnit($medicinedetails[0]->subform);
                $UNIT = $subformUnit[0]->qnty;
                $title = $result[0]->title;
                
                
                $GST = $this->Hsn_model->GetHsnDetailsById($medicinedetails[0]->hsn);
                $unitList = $this->medicine_model->Getunitsbyform($medicinedetails[0]->form);
                $proname = $medicinedetails[0]->product_name;
                $gen = $medicinedetails[0]->strength;
                $batch = $value->Batch_Number;
                $idd = $value->ph_id;
                $exp = $value->expire_date;
                $qty = $value->qty;
                $freeqty = $value->free_qty;
                $tradeprice = $value->supplier_price;
                $mrp = $value->mrp;
                $dis = $value->discount;
                $tax = $value->tax;
                $tot = $value->total_amount;
                
                echo "<tr>
                    <td>
                        <input type='hidden' class='form-control medicine1' id='medicine1' name='medicine[]' readonly value='$mid'>
                        <input type='text' class='form-control' placeholder='Ounce' name='mname[]' readonly value='$proname ($gen)'>
                    </td>
                    <td><input type='text' class='form-control' name='gname[]' readonly value='$gen'></td>
                    <td><input type='text' class='form-control' name='model[]' readonly value='$title'></td>
                    <td style='width: 110px;'>
                        <select class='form-control' name='units[]'>";
                            foreach ($medsubFormArray as $unitid) {
                                $subformUnit = $this->medicine_model->subformUnit($unitid);
                                $selected = ($value->unit == $subformUnit[0]->id) ? "selected" : "";
                                echo "<option value='".$subformUnit[0]->id."' $selected>".$subformUnit[0]->unit."</option>";
                            }
                echo    "</select>
                    </td>
                    <td><input type='text' class='form-control batch_no' name='batch_no[]' value='$batch'></td>
                    <td><input type='text' class='form-control datepicker valid' name='expiredate[]' readonly value='$exp' id='datepicker' required></td>
                    <td><input type='text' class='form-control qty' name='qty[]' value='$qty' required></td>
                    <td><input type='text' class='form-control freeqty' name='freeqty[]' value='$freeqty'></td>
                    <td><input type='text' class='form-control tradeprice' name='tradeprice[]' value='$tradeprice'></td>
                    <td><input type='text' class='form-control mrp' name='mrp[]' value='$mrp'></td>
                    <td><input type='text' class='form-control wholesaler' name='wholesaler[]' value='$dis'>
                        <input type='hidden' class='form-control discount' name='discount[]' value='0'>
                    </td>
                    <td><input readonly type='text' class='form-control tax' name='tax[]' value='$tax'>
                        <input type='hidden' class='form-control hsn' name='hsn[]' value='$GST->igst'>
                    </td>
                    <td><input readonly type='text' class='form-control total' name='total[]' value='$tot'>
                        <input type='hidden' class='form-control tdiscount' name='idd[]' value='$idd'>
                        <input type='hidden' class='form-control tdiscount' name='tdiscount[]' value='0'>
                    </td>
                </tr>";
            }
            
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    

    public function append_checkbox_data()
    {
        $id  = $this->input->post('id');
        $value    = $this->medicine_model->get_medicine_by_id($id);
            $product_id =   $value[0]->product_id;
            $product_name =   $value[0]->product_name;
            $strength =   $value[0]->strength;
            $generic_name =   $value[0]->generic_name;
            $form =   $value[0]->form;
            $expire_date =   $value[0]->expire_date;
            $instock =   $value[0]->instock;
            $purchase_rate =   $value[0]->purchase_rate;
            $mrp =   $value[0]->mrp;
            $discount =   $value[0]->discount;
            $Batch_Number =   $value[0]->Batch_Number;
            $id =   $value[0]->id;
          

        echo   "<tr>
                <td>
                <input type='hidden' class='form-control medicine' id='medicine' name='medicine[]' placeholder='Ounce' readonly value='$product_id'>
                <input type='text' class='form-control' placeholder='Ounce' name='mname[]' readonly value='$product_name.($strength)'>
                </td>
                
                <td><input type='text' class='form-control' name='gname[]' placeholder='Ounce' readonly value='$generic_name'></td>
                <td><input type='text' class='form-control' name='model[]' placeholder='Ounce' readonly value='$form'></td>
                <td><input type='text' class='form-control datepicker' name='expiredate[]' value='$expire_date' id='datepicker' required></td>
                <td><input type='text' class='form-control' name='stock[]' placeholder='0.00' readonly value='0'></td>                            
                <td><input type='text' class='form-control qty' name='qty[]' placeholder='0.00' value='' required></td>                                                          
                <td><input type='text' class='form-control tradeprice' name='tradeprice[]' placeholder='0.00' value='$purchase_rate'></td>
                <td><input type='text' class='form-control mrp' name='mrp[]' placeholder='0.00' value='$mrp'></td>
                <td><input type='text' class='form-control wholesaler' name='wholesaler[]' placeholder='0.00' value='$discount'></td>
                <td><input type='text' class='form-control total' name='total[]' placeholder='0.00' value='0'></td>
                <td><input type='text' class='form-control batch_no' name='batch_no[]' placeholder='0.00' value='$Batch_Number' ></td>
                <td><input type='hidden' class='form-control tdiscount' name='tdiscount[]' placeholder='0.00'  value='0'></td>
                <td><input class='append-checkbox' type='checkbox' data-id ='$id' value='$id' id='appended_check'></td>;
               </tr>";
    }

    public function medicineInfoByMedicineID(){
        $id= $this->input->get('id');
        $data = array();
        $data['medicinevalue'] = $this->medicine_model->getMedicineBymedicineId($id);
        echo json_encode($data);
    }
    
    public function purchase(){
        if ($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
        if (in_array(33, $permissions)) { 
        $data = array();
        $data['Purchase'] = $this->purchase_model->getPurchaseInfo(); 
        $data['permissions1'] = $this->permissionsbyemrole(); 
        $this->load->view('backend/purchase',$data);
    }
    else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
        } else {
            redirect(base_url(), 'refresh');
        }        
    }

    public function Purchase_Review(){
       
        $supplier   =   $this->input->post('supplier1');
        $deliverytime = $this->input->post('delivery_time');
        $paymenttime = $this->input->post('payment_time');
        $invoice    =   $this->input->post('invoice');
        $entrydate  =   $this->input->post('entrydate');
        $details    =   $this->input->post('details');
        $mtype    =   $this->input->post('mtype');
        $bankid    =   $this->input->post('bankid');
        $units    =   $this->input->post('units');
        $billadjustment = $this->input->post('billadjustment');
        $bankid    =   $this->input->post('delivery_time');
        $bankid    =   $this->input->post('bankid');
        $freeqty = $this->input->post('freeqty');
        if(!empty($bankid)){
            $bankname = $this->purchase_model->GetBankName($bankid);
        }
        $bankinfo = $this->user_model->Getbankinfowithsupplier();
        $cheque    =   $this->input->post('cheque');
        $issuedate    =   $this->input->post('issuedate');
        $rname    =   $this->input->post('rname');
        $rcontact    =   $this->input->post('rcontact');
        $paydate    =   $this->input->post('paydate');
        /*$tdiscount  =   round($this->input->post('tdiscount'));*/
        $sumTax =  $this->input->post('sumTax');
        $grandamount =  $this->input->post('grandamount');
        $sumAmount =  $this->input->post('sumAmount');
        
        $paid =  $this->input->post('paid');
        $due =  $this->input->post('due');
        $invoiceid    = $this->purchase_model->GePurchaseInvoice($invoice);
        if(!empty($invoiceid)){
            echo "This Invoice is Already exist";
            die();
        }
        $date       =   strtotime(date('m/d/Y'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        // $this->form_validation->set_rules('supplier1', 'Supplier1', 'trim|required|xss_clean');
        $this->form_validation->set_rules('qty[]', 'Quantity', 'trim|xss_clean');
       $supplierval = $this->supplier_model->GetSupplierValueById($supplier);
       
      
      
        if($this->form_validation->run() == FALSE){
		    $response['status'] = 'error';
            $response['message'] = validation_errors();
            $this->output->set_output($response);
        } else {

           
            
                                     echo " 
                                        <div class='row'>
                                        
                                            <div class='col-md-3'>
                                                <div class='form-group' style='margin-bottom: 15px'>
                                                <label class='control-label'>Supplier Name</label>
                                                <input type='hidden' class='form-control supplier' id='supplier' name='supplier' placeholder='Supplier' readonly value='$supplier'>
                                                <input type='text' class='form-control' style='border: 1px solid rgba(222, 218, 218, 0.15);' placeholder='Ounce' name='' readonly value='$supplierval->s_name'>                                                
                                                </div>
                                            </div>
                                            <div class='col-md-3'>
                                                <div class='form-group' style='margin-bottom: 15px'>
                                                    <label class='control-label'>Invoice No</label>
                                                    <input type='text' style='border: 1px solid rgba(222, 218, 218, 0.15);' id='firstName' name='invoice' class='form-control' placeholder='Invoice No' value='$invoice' required='1'>
                                                </div>
                                            </div>                                            
                                            <div class='col-md-3'>
                                                <div class='form-group' style='margin-bottom: 15px'>
                                                    <label class='control-label'>Date</label>
                                                    <input type='text' style='border: 1px solid rgba(222, 218, 218, 0.15);' id='datepicker' class='form-control datepicker' placeholder='' name='entrydate' required value='$entrydate'>
                                                </div>
                                            </div>
                                            <div class='col-md-3'>
                                                <div class='form-group' style='margin-bottom: 15px'>
                                                    <label class='control-label'>Note</label>
                                                    <input type='text' style='border: 1px solid rgba(222, 218, 218, 0.15);' name='details' class='form-control' placeholder='Details' value='$details'>
                                                </div>
                                            </div>
                                            </div>
                                            <div class='row'>
                                            <div class='col-md-4'>
                                                <div class='form-group' style='margin-bottom: 15px'>
                                                    <label class='control-label'>Delivery Time(Days)</label>
                                                    <input type='text' style='border: 1px solid rgba(222, 218, 218, 0.15);' name='delivery_time' class='form-control' placeholder='Delivery Time(Days)' value='$deliverytime'>
                                                </div>
                                            </div>
                                            <div class='col-md-4'>
                                                <div class='form-group' style='margin-bottom: 15px'>
                                                    <label class='control-label'>Payment Time(Days)</label>
                                                    <input type='text' style='border: 1px solid rgba(222, 218, 218, 0.15);' name='payment_time' class='form-control' placeholder='Payment Time(Days)' value='$paymenttime'>
                                                </div>
                                            </div>
                                        </div>
                <table class='table table-bordered m-t-10 pos_table purchase'>
                    <thead>
                        <tr>
                            <th style='width: 144px;'>Medicine</th>
                            <th>G.Name</th>
                            <th>Form</th> 
                            <th>Unit</th>                      
                            <th style='width: 92px;'>Exp. Date</th>
                            <th>Qty</th>
                            <th>Free Qty</th>
                            <th>Purchase Rate</th>
                            <th>MRP</th>
                            <th>Disc.(W)</th>
                            <th>Tax</th>
                            <th>Total</th>
                           
                            <th>Batch no.</th>
                        </tr>
                    </thead>
                    <tbody id='addPurchaseItem'>";            
            
                foreach($_POST['qty'] as $row=>$name){
                if(!empty($_POST['qty'][$row])){
                $medicine   =   $_POST['medicine'][$row];
                $mname   =   $_POST['mname'][$row];
                $qty        =   $_POST['qty'][$row];
                $freeqty = $_POST['freeqty'][$row];
                $modal   =   $_POST['model'][$row];
                $unit =  $this->medicine_model->GetunitBynum($_POST['units'][$row]);
                $units        =   $_POST['units'][$row];               
                //$instock       =   $_POST['stock'][$row];
                $tradeprice =   $_POST['tradeprice'][$row];
                $mrp        =   $_POST['mrp'][$row];
                $wholesaller=   $_POST['wholesaler'][$row];
                $batch_no   =   $_POST['batch_no'][$row];
                //$deliverytime = $_POST['delivery_time'][$row];
                //$paymenttime = $_POST['payment_time'][$row];
                $total      =   $_POST['total'][$row];
                $tax        =   $_POST['tax'][$row];
                $expire     =   $_POST['expiredate'][$row];
                $gname     =   $_POST['gname'][$row];
                $medicineval    = $this->medicine_model->getMedicineBymedicineId($medicine);
                $unitMrp =   $mrp/$unit->qnty;
                $tax1 = round($tax, 2);
                echo "<tr>
                            <td><input type='hidden' class='form-control medicine' id='medicine' name='medicine[]' placeholder='Ounce' readonly value='$medicine'>
                            <input type='text' class='form-control' placeholder='Ounce' readonly value='$mname'>
                            </td>
                            <td><input type='text' class='form-control' name='gname[]'  readonly value='$gname'></td>
                            <td><input type='text' class='form-control' name='modal[]' placeholder='Ounce' readonly value='$modal'></td>
                            <td><input type='text' class='form-control' name='unitsid2[]' placeholder='Ounce' readonly value='$unit->qnty'></td>
                            <input type='hidden' class='form-control' name='units123' placeholder='Ounce' readonly value='$unit->unit'>
                            <input type='hidden' class='form-control' name='unitsid[]' placeholder='Ounce' readonly value='$units'>
                            <input type='hidden' class='form-control' name='units[]' placeholder='Ounce' readonly value='$unit->qnty'>
                            <input type='hidden' class='form-control' name='billadjustment' placeholder='Ounce' readonly value='$billadjustment'>
                            <td style='width: 111px;'><input type='text' class='form-control datepicker' readonly name='expiredate[]' value='$expire' id='datepicker' required>
                            <input type='hidden' class='form-control' name='stock[]' placeholder='0.00' readonly value='' >
                            </td>                            
                            <td><input type='text' class='form-control qtyval' name='qty[]' placeholder='0.00' readonly value='$qty' autocomplete='off' required></td>   
                            <td><input type='text' class='form-control freeqty' name='freeqty[]' placeholder='0.00' readonly value='$freeqty' autocomplete='off'></td>                                                         
                            <td><input type='text' class='form-control tardepriceval' name='tradeprice[]' readonly placeholder='0.00' value='$tradeprice'></td>
                            <td><input type='text' class='form-control mrpval' name='mrp[]' placeholder='0.00' readonly value='$mrp'>
                            <input type='hidden' class='form-control' name='unitmrp[]' placeholder='Ounce'  value='$unitMrp'></td>
                            <td><input type='text' class='form-control wholesaler' name='wholesaler[]' readonly placeholder='0.00' value='$wholesaller' required></td>
                            <td><input type='text' class='form-control tax' name='tax[]' readonly placeholder='0.00' value='$tax1'></td>
                            <td><input type='text' class='form-control totalval' name='totalval[]' readonly placeholder='0.00' value='$total'></td>
                            <td><input type='text' class='form-control batch_no' name='batch_no[]' readonly value='$batch_no'></td>
                            <input type='hidden' class='form-control' name='barqty[]' placeholder='0.00' value='' autocomplete='off'>
                    </tr>";
                    }
                } 
            echo "</tbody>
                        <tfood>
                        <tr>
                                    
                                    <td class='text-right font-weight-bold' colspan=9>Grand Total:</td>
                                    <td colspan='4'><input type='text' class='form-control sumAmount' name='sumAmount' placeholder='0.00' readonly value='$sumAmount'></td>
                                    
                                    
                            </tr>
                        <tr>
                                    
                        <td class='text-right font-weight-bold' colspan=9>Tax:</td>
                        <td colspan='4'><input type='text' class='form-control sumTax' name='sumTax' placeholder='0.00' readonly value='$sumTax'></td>
                        
                        
                        
                </tr>
                            <tr>
                                    
                                    <td class='text-right font-weight-bold' colspan=9>Grand Total:</td>
                                    <td colspan='4'><input type='text' class='form-control gtotalval' name='grandamount' placeholder='0.00' readonly value='$grandamount'></td>
                                    
                                    
                            </tr>
                            
                            <tr>
                                                <td class='text-right font-weight-bold' colspan=9>Total Paid:</td>

                                                <td colspan='4'><input type='text' class='form-control rpaid' name='paid' placeholder='0.00' value='$paid'></td>
                                                
                                            </tr>
                                            <tr>
                                                <td class='text-right font-weight-bold' colspan=9>Total Due:</td>

                                                <td colspan='4'><input type='text' class='form-control rdue' name='due' placeholder='0.00' readonly='' value='$due'></td>
                                                
                                            </tr>
                                            <tr id='payform'>
                                                <td colspan='4'><select name='mtype' id='mtype' class='form-control'>
                                                            <option value='$mtype'>$mtype</option>
                                                            
                                                        </select>
                                            <input type='hidden' class='form-control mtype' id='mtype' name='mtype' placeholder='Supplier' readonly value='$mtype'>
                                                        </td>";
                                                if(!empty($bankid)){
                                                echo"<td id='bankid' colspan=2><select class='select2 form-control' name='bankid' style='width:100%' >
                                                           <option value='$bankname->bank_id'>$bankname->bank_name</option>";
                                                            foreach($bankinfo as $value){
                                                                echo"<option value='$value->bank_id'>$value->bank_name</option>";
                                                            }
                                                        echo"</select></td>
                                                
                                                <td colspan='4' id='cheque'><input type='text' name='cheque'  class='form-control' placeholder='Cheque No...' value='$cheque'></td>
                                                <td colspan='4' id='issuedate'><input type='text' name='issuedate'  class='form-control datepicker' placeholder='Issue Date' value='$issuedate'></td>";
                                                }
                                                echo"<td colspan=2><input type='text' name='rname' id='rname' class='form-control' placeholder='Receiver Name' value='$rname'></td> 
                                                <td colspan=2><input type='text' name='rcontact' id='rcontact' class='form-control' placeholder='Receiver Contact' value='$rcontact'></td>
                                                <td colspan=2><input type='text' name='paydate' class='form-control datepicker' placeholder='Pay Date' value='$paydate'></td> 
                                                        
                                                
                                            </tr>                            
                        </tfood>            
            </table>";
        }
    }
    public function Purchase_Review_update(){
        $supplier   =   $this->input->post('supplier_name');
        $purid    =       $this->input->post('pur_id');
        $deliverytime = $this->input->post('delivery_time');
        $paymenttime = $this->input->post('payment_time');
        $invoice    =   $this->input->post('invoice');
        $entrydate  =   $this->input->post('entrydate');
        $details    =   $this->input->post('details');
        $mtype    =   $this->input->post('mtype');
        $bankid    =   $this->input->post('bankid');
        $units    =   $this->input->post('units');
        $idarray       = $this->input->post('idd');
        
        
        $billadjustment = $this->input->post('billadjustment');
        $bankid    =   $this->input->post('delivery_time');
        $bankid    =   $this->input->post('bankid');
        $freeqty = $this->input->post('freeqty');
        if(!empty($bankid)){
            $bankname = $this->purchase_model->GetBankName($bankid);
        }
        $bankinfo = $this->user_model->Getbankinfowithsupplier();
        $cheque    =   $this->input->post('cheque');
        $issuedate    =   $this->input->post('issuedate');
        $rname    =   $this->input->post('rname');
        $rcontact    =   $this->input->post('rcontact');
        $paydate    =   $this->input->post('paydate');
        /*$tdiscount  =   round($this->input->post('tdiscount'));*/
        $sumTax =  $this->input->post('sumTax');
        $grandamount =  $this->input->post('grandamount');
        $sumAmount =  $this->input->post('sumAmount');
        
        $paid =  $this->input->post('paid');
        $due =  $this->input->post('due');
        $invoiceid    = $this->purchase_model->GePurchaseInvoice($invoice);

        $date       =   strtotime(date('m/d/Y'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        // $this->form_validation->set_rules('supplier', 'Supplier', 'trim|required|xss_clean');
        $this->form_validation->set_rules('qty[]', 'Quantity', 'trim|xss_clean');
       $supplierval = $this->supplier_model->GetSupplierValueById($supplier);
       
       //print_r($storeval);
       
        if($this->form_validation->run() == FALSE){
		    $response['status'] = 'error';
            $response['message'] = validation_errors();
            $this->output->set_output($response);
        } else {
            
                                     echo " 
                                        <div class='row'>
                                        
                                            <div class='col-md-3'>
                                                <div class='form-group' style='margin-bottom: 15px'>
                                                <label class='control-label'>Supplier Name</label>
                                                <input type='hidden' class='form-control' name='pur_id'  readonly value='$purid'>
                                                <input type='hidden' class='form-control supplier' id='supplier' name='supplier' placeholder='Supplier' readonly value='$supplier'>
                                                <input type='text' class='form-control' style='border: 1px solid rgba(222, 218, 218, 0.15);' placeholder='Ounce' name='' readonly value='$supplierval->s_name'>                                                
                                                </div>
                                            </div>
                                           
                                            <div class='col-md-3'>
                                                <div class='form-group' style='margin-bottom: 15px'>
                                                    <label class='control-label'>Invoice No</label>
                                                    <input type='text' style='border: 1px solid rgba(222, 218, 218, 0.15);' id='firstName' name='invoice' class='form-control' placeholder='Invoice No' value='$invoice' required='1'>
                                                </div>
                                            </div>                                            
                                            <div class='col-md-3'>
                                                <div class='form-group' style='margin-bottom: 15px'>
                                                    <label class='control-label'>Date</label>
                                                    <input type='text' style='border: 1px solid rgba(222, 218, 218, 0.15);' id='datepicker' class='form-control datepicker' placeholder='' name='entrydate' required value='$entrydate'>
                                                </div>
                                            </div>
                                            <div class='col-md-3'>
                                                <div class='form-group' style='margin-bottom: 15px'>
                                                    <label class='control-label'>Note</label>
                                                    <input type='text' style='border: 1px solid rgba(222, 218, 218, 0.15);' name='details' class='form-control' placeholder='Details' value='$details'>
                                                </div>
                                            </div>
                                            </div>
                                            <div class='row'>
                                            <div class='col-md-4'>
                                                <div class='form-group' style='margin-bottom: 15px'>
                                                    <label class='control-label'>Delivery Time(Days)</label>
                                                    <input type='text' style='border: 1px solid rgba(222, 218, 218, 0.15);' name='delivery_time' class='form-control' placeholder='Delivery Time(Days)' value='$deliverytime'>
                                                </div>
                                            </div>
                                            <div class='col-md-4'>
                                                <div class='form-group' style='margin-bottom: 15px'>
                                                    <label class='control-label'>Payment Time(Days)</label>
                                                    <input type='text' style='border: 1px solid rgba(222, 218, 218, 0.15);' name='payment_time' class='form-control' placeholder='Payment Time(Days)' value='$paymenttime'>
                                                </div>
                                            </div>
                                        </div>
                <table class='table table-bordered m-t-10 pos_table purchase'>
                    <thead>
                        <tr>
                            <th style='width: 144px;'>Medicine</th>
                            <th>G.Name</th>
                            <th>Form</th> 
                            <th>Unit</th>                      
                            <th style='width: 92px;'>Exp. Date</th>
                            <th>Qty</th>
                            <th>Free Qty</th>
                            <th>Purchase Rate</th>
                            <th>MRP</th>
                            <th>Disc.(W)</th>
                            <th>Tax</th>
                            <th>Total</th>        
                            <th>Batch no.</th>
                        </tr>
                    </thead>
                    <tbody id='addPurchaseItem'>";            
            
                foreach($_POST['qty'] as $row=>$name){
                if(!empty($_POST['qty'][$row])){
                $medicine   =   $_POST['medicine'][$row];
                $mname   =   $_POST['mname'][$row];
                
                $qty        =   $_POST['qty'][$row];
                $freeqty = $_POST['freeqty'][$row];
                $modal   =   $_POST['model'][$row];
                $ids    =   $_POST['idd'][$row];
                
                $unit =  $this->medicine_model->GetunitBynum($_POST['units'][$row]);
                $units        =   $_POST['units'][$row];               
                //$instock       =   $_POST['stock'][$row];
                $tradeprice =   $_POST['tradeprice'][$row];
                $mrp        =   $_POST['mrp'][$row];
                $wholesaller=   $_POST['wholesaler'][$row];
                $batch_no   =   $_POST['batch_no'][$row];
                //$deliverytime = $_POST['delivery_time'][$row];
                //$paymenttime = $_POST['payment_time'][$row];
                $total      =   $_POST['total'][$row];
                $tax        =   $_POST['tax'][$row];
                $expire     =   $_POST['expiredate'][$row];
                $gname     =   $_POST['gname'][$row];
                $medicineval    = $this->medicine_model->getMedicineBymedicineId($medicine);
                $unitMrp =   $mrp/$unit->qnty;
                $tax1 = round($tax, 2);
                echo "<tr>
                            <td><input type='hidden' class='form-control medicine' id='medicine' name='medicine[]' placeholder='Ounce' readonly value='$medicine'>
                            <input type='text' class='form-control' placeholder='Ounce' readonly value='$mname'>
                            </td>
                            <td><input type='text' class='form-control' name='gname[]' placeholder='Ounce' readonly value='$gname'></td>
                            <td><input type='text' class='form-control' name='modal[]' placeholder='Ounce' readonly value='$modal'></td>
                            <td><input type='text' class='form-control' name='unitsid2[]' placeholder='Ounce' readonly value='$unit->qnty'></td>
                            <input type='hidden' class='form-control' name='units123' placeholder='Ounce' readonly value='$unit->unit'>
                            <input type='hidden' class='form-control' name='unitsid[]' placeholder='Ounce' readonly value='$units'>
                            <input type='hidden' class='form-control' name='units[]' placeholder='Ounce' readonly value='$unit->qnty'>
                            <input type='hidden' class='form-control' name='idd[]'  readonly value='$ids'>
                            
                            <input type='hidden' class='form-control' name='billadjustment' placeholder='Ounce' readonly value='$billadjustment'>
                            <td style='width: 111px;'><input type='text' class='form-control datepicker' readonly name='expiredate[]' value='$expire' id='datepicker' required>
                            <input type='hidden' class='form-control' name='stock[]' placeholder='0.00' readonly value='' >
                            </td>                            
                            <td><input type='text' class='form-control qtyval' name='qty[]' placeholder='0.00' readonly value='$qty' autocomplete='off' required></td>   
                            <td><input type='text' class='form-control freeqty' name='freeqty[]' placeholder='0.00' readonly value='$freeqty' autocomplete='off'></td>                                                         
                            <td><input type='text' class='form-control tardepriceval' name='tradeprice[]' readonly placeholder='0.00' value='$tradeprice'></td>
                            <td><input type='text' class='form-control mrpval' name='mrp[]' placeholder='0.00' readonly value='$mrp'>
                            <input type='hidden' class='form-control' name='unitmrp[]' placeholder='Ounce'  value='$unitMrp'></td>
                            <td><input type='text' class='form-control wholesaler' name='wholesaler[]' readonly placeholder='0.00' value='$wholesaller' required></td>
                            <td><input type='text' class='form-control tax' name='tax[]' readonly placeholder='0.00' value='$tax1'></td>
                            <td><input type='text' class='form-control totalval' name='totalval[]' readonly placeholder='0.00' value='$total'></td>
                            <td><input type='text' class='form-control batch_no' name='batch_no[]' readonly value='$batch_no'></td>
                            <input type='hidden' class='form-control' name='barqty[]' placeholder='0.00' value='' autocomplete='off'>
                    </tr>";
                    }
                } 
            echo "</tbody>
                        <tfood>
                        <tr>
                                    
                                    <td class='text-right font-weight-bold' colspan=9>Grand Total:</td>
                                    <td colspan='4'><input type='text' class='form-control sumAmount' name='sumAmount' placeholder='0.00' readonly value='$sumAmount'></td>
                                    
                                    
                            </tr>
                        <tr>
                                    
                        <td class='text-right font-weight-bold' colspan=9>Tax:</td>
                        <td colspan='4'><input type='text' class='form-control sumTax' name='sumTax' placeholder='0.00' readonly value='$sumTax'></td>
                        
                        
                        
                </tr>
                            <tr>
                                    
                                    <td class='text-right font-weight-bold' colspan=9>Grand Total:</td>
                                    <td colspan='4'><input type='text' class='form-control gtotalval' name='grandamount' placeholder='0.00' readonly value='$grandamount'></td>
                                    
                                    
                            </tr>
                            
                            <tr>
                                                <td class='text-right font-weight-bold' colspan=9>Total Paid:</td>

                                                <td colspan='4'><input type='text' class='form-control rpaid' name='paid' placeholder='0.00'readonly  value='$paid'></td>
                                                
                                            </tr>
                                            <tr>
                                                <td class='text-right font-weight-bold' colspan=9>Total Due:</td>

                                                <td colspan='4'><input type='text' class='form-control rdue' name='due' placeholder='0.00' readonly='' value='$due'></td>
                                                
                                            </tr>
                                            <tr id='payform'>
                                                <td colspan='4'><select name='mtype' id='mtype' class='form-control'>
                                                            <option value='$mtype'>$mtype</option>
                                                            
                                                        </select>
                                            <input type='hidden' class='form-control mtype' id='mtype' name='mtype' placeholder='Supplier' readonly value='$mtype'>
                                                        </td>";
                                                if(!empty($bankid)){
                                                echo"<td id='bankid' colspan=2><select class='select2 form-control' name='bankid' style='width:100%' >
                                                           <option value='$bankname->bank_id'>$bankname->bank_name</option>";
                                                            foreach($bankinfo as $value){
                                                                echo"<option value='$value->bank_id'>$value->bank_name</option>";
                                                            }
                                                        echo"</select></td>
                                                
                                                <td colspan='4' id='cheque'><input type='text' name='cheque'  class='form-control' placeholder='Cheque No...' value='$cheque'></td>
                                                <td colspan='4' id='issuedate'><input type='text' name='issuedate'  class='form-control datepicker' placeholder='Issue Date' value='$issuedate'></td>";
                                                }
                                                echo"<td colspan=2><input type='text' name='rname' id='rname' class='form-control' placeholder='Receiver Name' value='$rname'></td> 
                                                <td colspan=2><input type='text' name='rcontact' id='rcontact' class='form-control' placeholder='Receiver Contact' value='$rcontact'></td>
                                                <td colspan=2><input type='text' name='paydate' class='form-control datepicker' placeholder='Pay Date' value='$paydate'></td> 
                                                        
                                                
                                            </tr>                            
                        </tfood>            
            </table>";
        }
    }
    public function Save_Purchase(){
        $purid      =   'P'.rand(2000,10000000);
        $supplier   =   $this->input->post('supplier');
        $invoice    =   $this->input->post('invoice');
        $entrydate  =   $this->input->post('entrydate');
        $details    =   $this->input->post('details');
        $deliverytime = $this->input->post('delivery_time');
        $paymenttime = $this->input->post('payment_time');
        $date       =   date('d/m/Y');
        $date2       =   date('m/d/Y');
        $mtype    =   $this->input->post('mtype');
        $bankid    =   $this->input->post('bankid');
        $entryid = $this->session->userdata('user_login_id');
        // $formattedDate = DateTime::createFromFormat('d-m-Y', $entrydate)->format('d/m/Y');
        //print_r($formattedDate);
        $storeid = $this->session->userdata('store_id');
        if(!empty($bankid)){
         $bankname = $this->purchase_model->GetBankName($bankid);
        }
        $bankinfo = $this->user_model->Getbankinfowithsupplier();
        $cheque    =   $this->input->post('cheque');
        $issuedate    =   $this->input->post('issuedate');
        $rname    =   $this->input->post('rname');
        $rcontact    =   $this->input->post('rcontact');
        $paydate    =   $this->input->post('paydate');
        $billadjustment = $this->input->post('billadjustment');
        /*$tdiscount  =   round($this->input->post('tdiscount'));*/
        $sumTax =  $this->input->post('sumtax');
        $grandamount =  $this->input->post('grandamount');
        $paid =  $this->input->post('paid');
        $duev =  abs($this->input->post('due'));       
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('supplier', 'Supplier', 'trim|required|xss_clean');
        $this->form_validation->set_rules('expiredate[]', 'ExpiryDate', 'trim|required|xss_clean');
        $this->form_validation->set_rules('qty[]', 'Quantity', 'trim|xss_clean');
        $this->form_validation->set_rules('invoice', 'Invoice', 'trim|required|xss_clean');
        $checksameinvoice = $this->purchase_model->GePurchaseInvoice($invoice);
        if(!empty($checksameinvoice)){
            echo "This Invoice is Already exist";
            die();
        }
        if($this->form_validation->run() == FALSE){
		    $response['status'] = 'error';
            $response['message'] = validation_errors();
            $this->output->set_output(json_encode($response));
        } else {
                $data = array();
                $data = array(
                    'p_id' => $purid,
                    'sid' => $supplier,
                    'invoice_no' => $invoice,
                    'pur_date' => $date2,
                    'pur_details' => $details,
                    'tax' => $sumTax,
                              
                    /*'total_discount' => $tdiscount,*/
                    'delivery_time' =>  $deliverytime,
                    'payment_time'  =>  $paymenttime,
                    'gtotal_amount' => $grandamount,
                    'entry_date' => $date,
                    'entry_id' => $entryid,
                    'adjustment'  => $billadjustment
                ); 
            $success = $this->purchase_model->Save_Purchase($data);
            if($this->db->affected_rows()){
                /*Root Accounts Start*/
                $account = $this->user_model->GetAccountBalance();
                if(!empty($account))
                {
                    $id = $account->id;
                    $amount = $account->amount - $paid;
                        $data = array(
                            'amount'   =>  $amount
                        );
                    $success = $this->user_model->UPDATE_ACCOUNT($id,$data); 
                }
                
                /*Root Accounts end*/
                
                $supplierbalance = $this->supplier_model->Getsupplierbalance($supplier);
                if(!empty($supplierbalance)){
                    $total = $supplierbalance->total_amount + $grandamount; 
                    $due = $supplierbalance->total_due + $duev;
                    $paids = $supplierbalance->total_paid + $paid;
                    $data = array();
                    $data = array(
                        'total_amount' => $total,
                        'total_paid' => $paids,
                        'total_due' => $due
                    );
                    $success = $this->supplier_model->update_Supplier_balance($supplier,$data); 
                }
            
                $data = array();
                $resource = 'purchase';
                $data = array(
                    'supp_id' => $supplier,
                    'pur_id' => $purid,
                    'type' => $mtype,
                    'bank_id' => $bankid,
                    'cheque_no' => $cheque,
                    'issue_date' => $issuedate,
                    'receiver_name' => $rname,
                    'receiver_contact' => $rcontact,
                    'date' => $paydate,
                    'paid_amount' => $paid,
                    'from' => $resource
                );
                

                $success = $this->purchase_model->Insert_Supplier_amount($data);
                        
               

                $data = array();
                $resource = 'purchase';
                $data = array(
                    'supplier_id' => $supplier,
                    'pur_id' => $purid,
                    'date' => $paydate,
                    'total_amount' => $grandamount,
                    'paid_amount' => $paid,
                    'due_amount' => $duev,
                    'from' => $resource
                );

                $success = $this->purchase_model->Insert_Supplier_PayHistory($data);                 
                foreach($_POST['qty'] as $row=>$name){
                if(!empty($_POST['qty'][$row])){
                $medicine   =   $_POST['medicine'][$row];
                $qty        =   $_POST['qty'][$row];
                $freeqty        =   $_POST['freeqty'][$row];
                $tradeprice =   $_POST['tradeprice'][$row];
                $mrp        =   $_POST['mrp'][$row];
                $batch_no   =   $_POST['batch_no'][$row];
                $tax        =   $_POST['tax'][$row];
                $discount   =   $_POST['wholesaler'][$row];
                $unit       =   $_POST['units'][$row];
                $unitid = $_POST['unitsid'][$row];
                $unitmrp    =   $_POST['unitmrp'][$row];
                $totalQnty  =   ($unit*$qty);
                $totfreeqty = ($unit*$freeqty);
                $perunitprice = $tradeprice / $unit;
                $total      =   $_POST['totalval'][$row];
                $expire     =   strtotime($_POST['expiredate'][$row]); 
                $expire =  date('Y-m-d', $expire);  
                
                $totquantity = $totalQnty + $totfreeqty;
                $grandtotal = $total + $tax;
                $dis = ($grandtotal * $discount)/100;
                
                $grandtotal1 = $total + $tax;
                $actualpur = $grandtotal1/$totquantity;
                $actualpur1 = round($actualpur, 3);
                    $data = array(
                        'pur_id'   =>  $purid,
                        'mid'      =>  $medicine,
                        'supp_id'  => $supplier,
                        'qty'      =>  $totalQnty ,
                        'supplier_price'=>$tradeprice,
                        'discount'   =>  $discount,
                        'delivery_time' =>  $deliverytime,
                        'payment_time'  =>  $paymenttime,
                        'expire_date'   =>  $expire,
                        'total_amount'  =>  $total,
                        'Batch_Number'  =>  $batch_no,
                        'mrp'  =>  $mrp,
                        'tax'  => $tax,
                        'unit_mrp' => $unitmrp,
                        'unit_price' => $perunitprice,
                        'free_qty' => $totfreeqty,
                        'actual_purrate'  => $actualpur1,
                        'unit' => $unitid 

                    );
                   
                $success = $this->purchase_model->Save_Purchase_History($data);

                $met_data = array(
                  "product_id" => $medicine,
                  "supplier_id" => $supplier,
                  "Batch_Number" => $batch_no,
                  "expire_date" => $expire,
                  "purchase_rate" => $tradeprice,
                  "mrp" => $mrp,
                  "instock" => $qty,
                );
                //print_r($met_data);
              
             //   $insert_med_meta = $this->purchase_model->insert_med_meta($met_data);
                    }
                }                
                foreach($_POST['qty'] as $row=>$name){
                if(!empty($_POST['qty'][$row])){
             
                $medicine   =   $_POST['medicine'][$row];
                $qty        =   $_POST['qty'][$row];
                $freeqty        =   $_POST['freeqty'][$row];
                $mrp        =   $_POST['mrp'][$row];
                $tradeprice      =   $_POST['tradeprice'][$row];
                $batch_no   =   $_POST['batch_no'][$row];
                $unit       =   $_POST['units'][$row];
                $unitmrp    =   $_POST['unitmrp'][$row];
                $totalQnty  =   ($unit*$qty) + ($unit*$freeqty);
                
                $wholesaller=   $_POST['wholesaler'][$row];
                if(empty($wholesaller))
                {
                  $wholesaller = '';
                }
                $expire     =   $_POST['expiredate'][$row];
           
                $medicinestock = $this->purchase_model->getmedicineByMId($medicine);
                $instock = $medicinestock->instock + $totalQnty;
                    if(empty($wholesaller)){
                        $wholesaller = $medicinestock->discount; 
                    }
                    else{

                    }
                   
                    $data = array(
                        'product_id'   =>  $medicine,
                        'instock'      =>  $instock,
                        'purchase_rate'    =>  $unitmrp,
                        'discount'    =>  $wholesaller,
                        'expire_date123'   =>  $expire
                    );

                    $check_batch_no = $this->purchase_model->check_batch_no($medicine, $batch_no, $supplier);
                   
                    if(!empty($check_batch_no))
                    {
                        
                        $getstock = $this->purchase_model->get_med_stock_medicine_meta($medicine, $batch_no, $supplier);
                       $pre_stock = $getstock[0]->instock;
                       $new_stock = $totalQnty;
                       $total_stock = $pre_stock + $new_stock;
                       $stock = array(
                               "instock" => $total_stock
                            );
                        $Update_Medicine_meta_stock = $this->purchase_model->Update_Medicine_meta_stock($medicine, $batch_no, $supplier, $stock);
                       // $success = $this->purchase_model->Update_Medicine($medicine,$data);

                       $check_med_stock = $this->purchase_model->check_med_stock($medicine);
                       $pre_stock = $check_med_stock[0]->instock;
                       $new_stock = $totalQnty;
                       $total_stock = $pre_stock + $new_stock;
                       $stock1 = array(
                               "instock" => $total_stock
                            );
                            
                       $update_med_stock = $this->purchase_model->update_med_stock($medicine, $stock1);

                        $response['status'] = 'success';
                        $response['message'] = "Successfully Added";
                        $response['curl'] = base_url()."Purchase/purchase";
                        $this->output->set_output(json_encode($response)); 
                    }else{
                     
                       $expire = date("Y-m-d", strtotime($expire));
                      
                        $value = array(                           
                             "product_id" => $medicine,
                             "supplier_id" => $supplier,
                             "Batch_Number" => $batch_no,
                             "expire_date" => $expire,
                             "purchase_rate" => $tradeprice,
                             "mrp" => $unitmrp,
                             "instock" => $totalQnty

                        );
                       
                       
                           $insert_med_meta = $this->purchase_model->insert_med_meta($value);

                            $check_med_stock = $this->purchase_model->check_med_stock($medicine);
                            $pre_stock = $check_med_stock[0]->instock;
                            $new_stock = $totalQnty;
                            $total_stock = $pre_stock + $new_stock;
                            $stock = array(
                                    "instock" => $total_stock
                                 );
                                 
                            $update_med_stock = $this->purchase_model->update_med_stock($medicine, $stock);
                             $response['status'] = 'success';
                            $response['message'] = "Successfully Added";
                            $response['curl'] = base_url()."Purchase/purchase";
                            $this->output->set_output(json_encode($response));  


                    }
                     
                    $saleqty = $medicinestock->sale_qty;
                    $manfdate = $medicinestock->manf_date;
                                //insert in store_mata
                                $data = array();
                                $data = array(
                                    'product_id' => $medicine,
                                    'supplier_id' => $supplier,
                                    'Batch_Number' => $batch_no,
                                    'manf_date' => $manfdate,
                                    'expire_date' => $expire,
                                    'purchase_rate' => $tradeprice,
                                    'mrp' => $unitmrp,
                                    'store_id' => $storeid,
                                    'instock' => $totalQnty,
                                    'sale_qty' => $saleqty,
                                    'discount' => $wholesaller,
                                    'tax' => $sumTax,
                                    
                                );

                                
                                $check_batch_no = $this->purchase_model->check_batch($medicine,$supplier,$batch_no);
                                if(!empty($check_batch_no))
                                {

                                    $pre_stock = $check_batch_no[0]->instock;
                                    $new_stock = $totalQnty;
                                    $total_stock = $pre_stock + $new_stock;
                                    $stock = array(
                                            "instock" => $total_stock
                                            // "status" => 1
                                        );
                                    $success = $this->purchase_model->Update_Store_Mata1($medicine,$supplier,$batch_no,$stock); 
                                }
                               else{
                                $success = $this->purchase_model->Insert_Store_Mata($data);
                                }

                }
                   
                }
 
            }
        }
    }
    public function save_draft(){
        $purid      =   'P'.rand(2000,10000000);
        $supplier   =   $this->input->post('supplier_name');
        $draftid   =   $this->input->post('supplier2');
        $invoice    =   $this->input->post('invoice');
        $entrydate  =   $this->input->post('entrydate');
        $details    =   $this->input->post('details');
        $deliverytime = $this->input->post('delivery_time');
        $paymenttime = $this->input->post('payment_time');
        $date       =   date('d/m/Y');
        $newDate = date("Y-m-d", strtotime($entrydate));
        $productid   =   $this->input->post('supplier');
        $billadjustment = $this->input->post('billadjustment');
        /*$tdiscount  =   round($this->input->post('tdiscount'));*/
        $sumTax =  $this->input->post('sumTax');
        $grandamount =  $this->input->post('grandamount');
        $paid =  $this->input->post('paid');
        $duev =  abs($this->input->post('due'));       
        $total = $this->input->post('sumAmount');
        $discount = $this->input->post('Discount');
        $totdis = ($total * $discount)/100;
                $data = array();
                $data = array(
                    'supplier_id' => $supplier,
                    'invoice_no' => $invoice,
                    'invoice_date' => $newDate,
                    'note' => $details,  
                    'delivery_time' =>  $deliverytime,
                    'payment_time'  =>  $paymenttime,
                    'total'   => $total,
                    'tax' => $sumTax,
                    'grandTotal' => $grandamount,
                    'adjustment' =>  $billadjustment,
                    'paid' =>  $paid,
                    'due' => $duev,
                    'totaldiscount' => $totdis



                ); 

               

                $returnid = $this->purchase_model->Save_Purchase_draft($data);
                
                foreach($_POST['medicine'] as $row=>$name){
                if(!empty($_POST['medicine'][$row])){
                $medicine   =   $_POST['medicine'][$row];
                $qty        =   $_POST['qty'][$row];
                $unit       =   $_POST['units'][$row];
                $freeqty        =   $_POST['freeqty'][$row];
                $tradeprice =   $_POST['tradeprice'][$row];
                $mrp        =   $_POST['mrp'][$row];
                $batch_no   =   $_POST['batch_no'][$row];
                $tax        =   $_POST['tax'][$row];
                $discount   =   $_POST['wholesaler'][$row];
                $expire     =   strtotime($_POST['expiredate'][$row]); 
                $expire =  date('Y-m-d', $expire);
                
                    $data = array(
                        'draft_id' => $returnid,
                        'medicine_id' =>  $medicine,
                        'qnty'      =>  $qty ,
                        'purchase_rate'=>$tradeprice,
                        'discount'   =>  $discount,
                        'exp_date'   =>  $expire,
                        'batch'  =>  $batch_no,
                        'mrp'  =>  $mrp,
                        'free_qnty' => $freeqty,
                        'unit'  => $unit
                    );
               
                $success = $this->purchase_model->Save_Purchase_Draftmeta($data);
                
                }
  
    }
    $response['status'] = 'success';
    $response['message'] = "Successfully Added";
    $response['curl'] = base_url()."Purchase/purchaseedit_draft/$returnid";
    $this->output->set_output(json_encode($response));
}

public function update_draft(){
    $purid      =   'P'.rand(2000,10000000);
    $draftid   =   $this->input->post('supplier2');
    $supplier   =   $this->input->post('supplier1');
    $invoice    =   $this->input->post('invoice');
    $entrydate  =   $this->input->post('entrydate');
    $details    =   $this->input->post('details');
    $deliverytime = $this->input->post('delivery_time');
    $paymenttime = $this->input->post('payment_time');
    $date       =   date('d/m/Y');
    $newDate = date("Y-m-d", strtotime($entrydate));
    $productid   =   $this->input->post('supplier');
    $billadjustment = $this->input->post('billadjustment');
    /*$tdiscount  =   round($this->input->post('tdiscount'));*/
    $sumTax =  $this->input->post('sumTax');
    $grandamount =  $this->input->post('grandamount');
    $paid =  $this->input->post('paid');
    $duev =  abs($this->input->post('due'));  
    $total = $this->input->post('sumAmount');  
    $discount = $this->input->post('Discount');
    $totdis = ($total * $discount)/100;   
    
            $data = array();
            $data = array(
                'supplier_id' => $supplier,
                'invoice_no' => $invoice,
                'invoice_date' => $newDate,
                'note' => $details,  
                'delivery_time' =>  $deliverytime,
                'payment_time'  =>  $paymenttime,
                'total'   => $total,
                    'tax' => $sumTax,
                    'grandTotal' => $grandamount,
                    'adjustment' =>  $billadjustment,
                    'paid' =>  $paid,
                    'due' => $duev,
                    'totaldiscount' => $discount
            ); 
 
          

            $returnid = $this->purchase_model->Update_Purchase_draft($data,$draftid);
            if(!empty($_POST['medicine'])){
            foreach($_POST['medicine'] as $row=>$name){
            $medicine   =   $_POST['medicine'][$row];
            $qty        =   $_POST['qty'][$row];
            $unit       =   $_POST['units'][$row];
            $freeqty        =   $_POST['freeqty'][$row];
            $tradeprice =   $_POST['tradeprice'][$row];
            $mrp        =   $_POST['mrp'][$row];
            $batch_no   =   $_POST['batch_no'][$row];
            $tax        =   $_POST['tax'][$row];
            $discount   =   $_POST['wholesaler'][$row];
            $expire     =   strtotime($_POST['expiredate'][$row]); 
            $id = $_POST['ids'];
            $expire =  date('Y-m-d', $expire);  
            $totalQnty  =   ($unit*$qty);
            $totfreeqty = ($unit*$freeqty);
                $data = array(
                    'draft_id' => $draftid,
                    'medicine_id' =>  $medicine,
                    'qnty'      =>  $qty,
                    'purchase_rate'=>$tradeprice,
                    'discount'   =>  $discount,
                    'exp_date'   =>  $expire,
                    'batch'  =>  $batch_no,
                    'mrp'  =>  $mrp,
                    'free_qnty' => $freeqty,
                    'unit' => $unit
                );

       $check = $this->purchase_model->check_Purchase_Draftmeta($draftid);
        $db_ids = array_map(function($obj) {
            return $obj->id; 
        }, $check);
        foreach ($id as $current_id) {
            if (!in_array($current_id, $db_ids)) {
            
                if ($current_id == 2024) {
                    $success = $this->purchase_model->Save_Purchase_Draftmeta($data);
                }
            }
            else{
                $success = $this->purchase_model->Update_Purchase_Draftmeta($data,$medicine,$draftid);
            }
        }
       foreach ($db_ids as $db_id) {
            if (!in_array($db_id, $id)) {
                $success = $this->purchase_model->Delete_Purchase_Draftmeta($db_id, $draftid);
            }
        
        }
                    }
                    
        }

        $response['status'] = 'success';
            $response['message'] = "Successfully Added";
            $response['curl'] = base_url()."Purchase/purchaseedit_draft/$draftid";
            $this->output->set_output(json_encode($response));

        }
        
    public function Update_Purchase(){
        $purid      =   $this->input->post('pur_id');
        $supplier   =   $this->input->post('supplier');
        $invoice    =   $this->input->post('invoice');
        $entrydate  =   $this->input->post('entrydate');
        
        // $formattedDate = DateTime::createFromFormat('d-m-Y', $entryid)->format('d/m/Y');
        $details    =   $this->input->post('details');
        $deliverytime = $this->input->post('delivery_time');
        $deliverytime = $this->input->post('delivery_time');
        $idd          = $this->input->post('idd'); 
        $paymenttime = $this->input->post('payment_time');
        $date       =   date('d/m/Y');
        $date2       =   date('m/d/Y');
        $mtype    =   $this->input->post('mtype');
        $bankid    =   $this->input->post('bankid');
        $entryid = $this->session->userdata('user_login_id');
        $storeid = $this->session->userdata('store_id');
        if(!empty($bankid)){
         $bankname = $this->purchase_model->GetBankName($bankid);
        }
        $bankinfo = $this->user_model->Getbankinfowithsupplier();
        $cheque    =   $this->input->post('cheque');
        $issuedate    =   $this->input->post('issuedate');
        $rname    =   $this->input->post('rname');
        $rcontact    =   $this->input->post('rcontact');
        $paydate    =   $this->input->post('paydate');
        $billadjustment = $this->input->post('billadjustment');
        /*$tdiscount  =   round($this->input->post('tdiscount'));*/
        $sumTax =  $this->input->post('sumtax');
        $grandamount =  $this->input->post('grandamount');
        $paid =  $this->input->post('paid');
        $duev =  abs($this->input->post('due'));       
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('supplier', 'Supplier', 'trim|required|xss_clean');
        $this->form_validation->set_rules('expiredate[]', 'ExpiryDate', 'trim|required|xss_clean');
        $this->form_validation->set_rules('qty[]', 'Quantity', 'trim|xss_clean');
        $this->form_validation->set_rules('invoice', 'Invoice', 'trim|required|xss_clean');
        $checksameinvoice = $this->purchase_model->GePurchaseInvoice($invoice);
        
        if($this->form_validation->run() == FALSE){
		    $response['status'] = 'error';
            $response['message'] = validation_errors();
            $this->output->set_output(json_encode($response));
        } else {
                $data = array();
                $data = array(
                    'p_id' => $purid,
                    'sid' => $supplier,
                    'invoice_no' => $invoice,
                    'pur_date' => $date2,
                    'pur_details' => $details,
                    'tax' => $sumTax,
                    'delivery_time' =>  $deliverytime,
                    'payment_time'  =>  $paymenttime,
                    'gtotal_amount' => $grandamount,
                    'entry_date' => $date,
                    'entry_id' => $entryid,
                    'adjustment'  => $billadjustment
                ); 
                
            $success = $this->purchase_model->Update_Purchase($purid,$data);
            if($this->db->affected_rows()){
                /*Root Accounts Start*/
                $account = $this->user_model->GetAccountBalance();
                if(!empty($account))
                {
                    $id = $account->id;
                    $amount = $account->amount - $paid;
                        $data = array(
                            'amount'   =>  $amount
                        );
                    $success = $this->user_model->UPDATE_ACCOUNT($id,$data); 
                }
                
                /*Root Accounts end*/
                
                
                $supplierbalance1 = $this->supplier_model->Getsupplierbalance($supplier);
                
                if(!empty($supplierbalance1)){
                    
                    $supplierAccbalance1 = $this->supplier_model->GetsupplierAccbalance1($purid);
                    
                    $exitotamt  = $supplierbalance1->total_amount;
                    $existotpaid = $supplierbalance1->total_paid;
                    $existotdues = $supplierbalance1->total_due;
                    
                    
                    if(!empty($supplierAccbalance1)){
                        $oldtotamt = $supplierAccbalance1[0]->total_amount;
                        $oldtotpaid = $supplierAccbalance1[0]->paid_amount;
                        $oldtotdues = $supplierAccbalance1[0]->due_amount;
                        }
                        else{
                            $oldtotamt = 0;
                            $oldtotpaid = 0;
                            $oldtotdues = 0;
                        }
                   

                    $total1 = $exitotamt - $oldtotamt + $grandamount;
                    $paid1 = $existotpaid - $oldtotpaid + $paid;
                    $dues1 = $existotdues - $oldtotdues + $duev;
                    $data = array();
                    $data = array(
                        'total_amount' => $grandamount,
                        'total_paid' => $paid1,
                        'total_due' => $dues1
                    );
                    
                    $success = $this->supplier_model->update_Supplier_balance($supplier,$data); 
                }
                
               


                

                $supplierAccbalance1 = $this->supplier_model->GetsupplierAccbalance1($purid);

                if(!empty($supplierAccbalance1)){
                // $oldpaid = $supplierAccbalance1[0]->total_amount;
                
                $data = array();
                
                $data = array(
                    'supp_id' => $supplier,
                    'pur_id' => $purid,
                    'type' => $mtype,
                    'bank_id' => $bankid,
                    'cheque_no' => $cheque,
                    'issue_date' => $issuedate,
                    'receiver_name' => $rname,
                    'receiver_contact' => $rcontact,
                    'date' => $paydate,
                    'paid_amount' => $paid
                );
                
                $success = $this->purchase_model->Update_Supplier_amount($purid,$data);
                
            }
            
                
                $supplierAccbalance = $this->supplier_model->GetsupplierAccbalance($purid);
                
                $resource = 'purchase';
                $data = array(
                    'supplier_id' => $supplier,
                    'pur_id' => $purid,
                    'date' => $paydate,
                    'total_amount' => $grandamount,
                    'paid_amount' => $paid,
                    'due_amount' => $duev,
                    'from' => $resource
                );
                
                $success = $this->purchase_model->Update_Supplier_PayHistory($purid,$data);
          
            

                foreach($_POST['qty'] as $row=>$name){
                if(!empty($_POST['qty'][$row])){
                $idd   =   $_POST['idd'][$row];    
                $medicine   =   $_POST['medicine'][$row];
                $qty        =   $_POST['qty'][$row];
                $freeqty        =   $_POST['freeqty'][$row];
                $tradeprice =   $_POST['tradeprice'][$row];
                $mrp        =   $_POST['mrp'][$row];
                $batch_no   =   $_POST['batch_no'][$row];
                $tax        =   $_POST['tax'][$row];
                $discount   =   $_POST['wholesaler'][$row];
                $unit       =   $_POST['units'][$row];
                $unitid = $_POST['unitsid'][$row];
                $unitmrp    =   $_POST['unitmrp'][$row];
                $totalQnty  =   ($unit*$qty);
                $totfreeqty = ($unit*$freeqty);
                $perunitprice = $tradeprice / $unit;
                $total      =   $_POST['totalval'][$row];
                $expire     =   strtotime($_POST['expiredate'][$row]); 
                $expire =  date('Y-m-d', $expire);
                $totquantity = $totalQnty + $totfreeqty;
                $grandtotal = $total + $tax;
                $dis = ($grandtotal * $discount)/100;
                
                $grandtotal1 = $total + $tax;
                $actualpur = $grandtotal1/$totquantity;
                $actualpur1 = round($actualpur, 3);                   
                    $data = array(
                        'pur_id'   =>  $purid,
                        'mid'      =>  $medicine,
                        'supp_id'  => $supplier,
                        'qty'      =>  $totalQnty ,
                        'supplier_price'=>$tradeprice,
                        'discount'   =>  $discount,
                        'delivery_time' =>  $deliverytime,
                        'payment_time'  =>  $paymenttime,
                        'expire_date'   =>  $expire,
                        'total_amount'  =>  $total,
                        'Batch_Number'  =>  $batch_no,
                        'mrp'  =>  $mrp,
                        'tax'  => $tax,
                        'unit_mrp' => $unitmrp,
                        'unit_price' => $perunitprice,
                        'free_qty' => $totfreeqty,
                        'actual_purrate'  => $actualpur1,
                        'unit'  => $unitid

                    );
                   if($idd == 0){

                    $success = $this->purchase_model->Save_Purchase_History($data);
                   }else{

                    
                   }
                

                $met_data = array(
                  "product_id" => $medicine,
                  "supplier_id" => $supplier,
                  "Batch_Number" => $batch_no,
                  "expire_date" => $expire,
                  "purchase_rate" => $tradeprice,
                  "mrp" => $mrp,
                  "instock" => $qty,
                );
                //print_r($met_data);
              
             //   $insert_med_meta = $this->purchase_model->insert_med_meta($met_data);
                    }
                }                
                foreach($_POST['qty'] as $row=>$name){
                if(!empty($_POST['qty'][$row])){
               
                $medicine   =   $_POST['medicine'][$row];
                $idd   =   $_POST['idd'][$row];  
                $qty        =   $_POST['qty'][$row];
                $freeqty        =   $_POST['freeqty'][$row];
                $mrp        =   $_POST['mrp'][$row];
                $tradeprice      =   $_POST['tradeprice'][$row];
                $batch_no   =   $_POST['batch_no'][$row];
                $unit       =   $_POST['units'][$row];
                $unitmrp    =   $_POST['unitmrp'][$row];
                $totalQnty  =   ($unit*$qty) + ($unit*$freeqty);
                
                $wholesaller=   $_POST['wholesaler'][$row];
                if(empty($wholesaller))
                {
                  $wholesaller = '';
                }
                $expire     =   $_POST['expiredate'][$row];
           
                $medicinestock = $this->purchase_model->getmedicineByMId($medicine);
                $instock = $medicinestock->instock + $totalQnty;
                    if(empty($wholesaller)){
                        $wholesaller = $medicinestock->discount; 
                    }
                    else{

                    }
                   
                    $data = array(
                        'product_id'   =>  $medicine,
                        'instock'      =>  $instock,
                        'purchase_rate'    =>  $unitmrp,
                        'discount'    =>  $wholesaller,
                        'expire_date123'   =>  $expire
                    );

                    $check_batch_no = $this->purchase_model->check_batch_no($medicine, $batch_no, $supplier);
                   
                    if(!empty($check_batch_no))
                    {
                        
                        $getstock = $this->purchase_model->get_med_stock_medicine_meta($medicine, $batch_no, $supplier);
                       $pre_stock = $getstock[0]->instock;
                       $new_stock = $totalQnty;
                       $total_stock = $pre_stock + $new_stock;
                       $stock = array(
                               "instock" => $total_stock
                            );
                            if($idd == 0){    
                        $Update_Medicine_meta_stock = $this->purchase_model->Update_Medicine_meta_stock($medicine, $batch_no, $supplier, $stock);
                       // $success = $this->purchase_model->Update_Medicine($medicine,$data);
                            }else {

                            }

                       $check_med_stock = $this->purchase_model->check_med_stock($medicine);
                       $pre_stock = $check_med_stock[0]->instock;
                       $new_stock = $totalQnty;
                       $total_stock = $pre_stock + $new_stock;
                       $stock1 = array(
                               "instock" => $total_stock
                            );
                           if($idd == 0){ 
                       $update_med_stock = $this->purchase_model->update_med_stock($medicine, $stock1);
                           }else{

                           }
                        $response['status'] = 'success';
                        $response['message'] = "Successfully Added";
                        $response['curl'] = base_url()."Purchase/purchase";
                        $this->output->set_output(json_encode($response)); 
                    }else{
                     
                       $expire = date("Y-m-d", strtotime($expire));
                      
                        $value = array(                           
                             "product_id" => $medicine,
                             "supplier_id" => $supplier,
                             "Batch_Number" => $batch_no,
                             "expire_date" => $expire,
                             "purchase_rate" => $tradeprice,
                             "mrp" => $unitmrp,
                             "instock" => $totalQnty

                        );
                       
                       
                           $insert_med_meta = $this->purchase_model->insert_med_meta($value);

                            $check_med_stock = $this->purchase_model->check_med_stock($medicine);
                            $pre_stock = $check_med_stock[0]->instock;
                            $new_stock = $totalQnty;
                            $total_stock = $pre_stock + $new_stock;
                            $stock = array(
                                    "instock" => $total_stock
                                 );
                              if($idd == 0){   
                            $update_med_stock = $this->purchase_model->update_med_stock($medicine, $stock);
                              }else {

                              }
                             $response['status'] = 'success';
                            $response['message'] = "Successfully Added";
                            $response['curl'] = base_url()."Purchase/purchase";
                            $this->output->set_output(json_encode($response));  
                       

                    }
                     
                    $saleqty = $medicinestock->sale_qty;
                    $manfdate = $medicinestock->manf_date;
                                //insert in store_mata
                                $data = array();
                                $data = array(
                                    'product_id' => $medicine,
                                    'supplier_id' => $supplier,
                                    'Batch_Number' => $batch_no,
                                    'manf_date' => $manfdate,
                                    'expire_date' => $expire,
                                    'purchase_rate' => $tradeprice,
                                    'mrp' => $unitmrp,
                                    'store_id' => $storeid,
                                    'instock' => $totalQnty,
                                    'sale_qty' => $saleqty,
                                    'discount' => $wholesaller,
                                    'tax' => $sumTax,
                                    
                                );

                                
                                $check_batch_no = $this->purchase_model->check_batch($medicine,$supplier,$batch_no);
                                if(!empty($check_batch_no))
                                {

                                    $pre_stock = $check_batch_no[0]->instock;
                                    $new_stock = $totalQnty;
                                    $total_stock = $pre_stock + $new_stock;
                                    $stock = array(
                                            "instock" => $total_stock
                                            // "status" => 1
                                        );
                                        if($idd == 0){
                                    $success = $this->purchase_model->Update_Store_Mata1($medicine,$supplier,$batch_no,$stock); 
                                        }else{}
                                }
                               else{
                                if($idd == 0){
                                $success = $this->purchase_model->Insert_Store_Mata($data);
                                }else {}
                                }

                }
                   
                }
 
            }
        }
    }
    public function Save_Purchase_Invoice(){
        $purid      =   'P'.rand(2000,10000000);
        $supplier   =   $this->input->post('supplier');
        $invoice    =   $this->input->post('invoice');
        $createdate  =   $this->input->post('entrydate');
        $entrydate  =   strtotime($this->input->post('entrydate'));
        
        // $formattedDate = DateTime::createFromFormat('d-m-Y', $entrydate)->format('d/m/Y');
        $details    =   $this->input->post('details');
        
         date_default_timezone_set("Asia/Kolkata");
        $date       =   date('d/m/Y');
        $date2       =   date('m/d/Y');
        $mtype    =   $this->input->post('mtype');
        $bankid    =   $this->input->post('bankid');
        $deliverytime = $this->input->post('delivery_time');
        $paymenttime = $this->input->post('payment_time');
        $entryid = $this->session->userdata('user_login_id');
        
        $billadjustment = $this->input->post('billadjustment'); 
        if(!empty($bankid)){
            $bankname = $this->purchase_model->GetBankName($bankid);
        }
        $bankinfo = $this->user_model->Getbankinfowithsupplier();
        $cheque    =   $this->input->post('cheque');
        $issuedate    =   $this->input->post('issuedate');
        $rname    =   $this->input->post('rname');
        $rcontact    =   $this->input->post('rcontact');
        $paydate    =   $this->input->post('paydate');
        /*$tdiscount  =   round($this->input->post('tdiscount'));*/
        $sumTax =  $this->input->post('sumTax');
        $grandamount =  $this->input->post('grandamount');
        $paid =  $this->input->post('paid');
        $duev =  abs($this->input->post('due'));         
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('supplier', 'Supplier', 'trim|required|xss_clean');
        $this->form_validation->set_rules('expiredate[]', 'ExpiryDate', 'trim|required|xss_clean');
        $this->form_validation->set_rules('qty[]', 'Quantity', 'trim|xss_clean');
        $this->form_validation->set_rules('invoice', 'Invoice', 'trim|required|xss_clean');
        $checksameinvoice = $this->purchase_model->GePurchaseInvoice($invoice);
        $storeid = $this->session->userdata('store_id');
        if(!empty($checksameinvoice)){
            echo "This Invoice is Already exist";
            die();
        }
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        } else {
                $supplierbalance = $this->supplier_model->Getsupplierbalance($supplier);
                $total = $supplierbalance->total_amount + $grandamount; 
                $due = $supplierbalance->total_due + $duev;
                $paids = $supplierbalance->total_paid + $paid;
                $data = array();
                $data = array(
                    'total_amount' => $total,
                    'total_paid' => $paids,
                    'total_due' => $due
                );
                $success = $this->supplier_model->update_Supplier_balance($supplier,$data);             
                $data = array();
                $data = array(
                    'p_id' => $purid,
                    'sid' => $supplier,
                    'invoice_no' => $invoice,
                    'pur_date' => $date2,
                    'pur_details' => $details,
                    'delivery_time' =>  $deliverytime,
                    'payment_time'  =>  $paymenttime,
                    /*'total_discount' => $tdiscount,*/
                    'tax' => $sumTax,
                    'gtotal_amount' => $grandamount,
                    'entry_date' => $date,
                    'entry_id' => $entryid,
                    'adjustment' => $billadjustment
                ); 
            $success = $this->purchase_model->Save_Purchase($data);
                $data = array();
                $resource = 'purchase';
                $data = array(
                    'supp_id' => $supplier,
                    'pur_id' => $purid,
                    'type' => $mtype,
                    'bank_id' => $bankid,
                    'cheque_no' => $cheque,
                    'issue_date' => $issuedate,
                    'receiver_name' => $rname,
                    'receiver_contact' => $rcontact,
                    'date' => $paydate,
                    'paid_amount' => $paid,
                    'from' => $resource
                );
                $success = $this->purchase_model->Insert_Supplier_amount($data);
                $data = array();
                $resource = 'purchase';
                $data = array(
                    'supplier_id' => $supplier,
                    'pur_id' => $purid,
                    'date' => $paydate,
                    'total_amount' => $grandamount,
                    'paid_amount' => $paid,
                    'due_amount' => $duev,
                    'from' => $resource
                );
                $success = $this->purchase_model->Insert_Supplier_PayHistory($data);             
            if($success){
                /*Root Accounts Start*/
                $account = $this->user_model->GetAccountBalance();
                if(!empty($account))
                {
                    $id = $account->id;
                    $amount = $account->amount - $paid;
                        $data = array(
                            'amount'   =>  $amount
                        );
                    $success = $this->user_model->UPDATE_ACCOUNT($id,$data); 
                }
               
                /*Root Accounts end*/                
                foreach($_POST['qty'] as $row=>$name){
                    if(!empty($_POST['qty'][$row])){
                $medicine   =   $_POST['medicine'][$row];
                $qty        =   $_POST['qty'][$row];
                $freeqty        =   $_POST['freeqty'][$row];
                $tradeprice =   $_POST['tradeprice'][$row];
                $mrp        =   $_POST['mrp'][$row];
                /*$discount   =   $_POST['discount'][$row];*/
                $total      =   $_POST['totalval'][$row];
                $expire     =   strtotime($_POST['expiredate'][$row]); 
                $expire     =    date("d-m-Y", $expire);
                $batch_no   =   $_POST['batch_no'][$row];
                $tax        =   $_POST['tax'][$row];
                $discount         =   $_POST['wholesaler'][$row];
                $unit       =   $_POST['units'][$row];
                $unitmrp    =   $_POST['unitmrp'][$row];
                $totalQnty  =   ($unit*$qty);
                $totfreeqty = ($unit*$freeqty);
                $perunitprice = $tradeprice / $unit;
                $totquantity = $totalQnty + $totfreeqty;
                $grandtotal = $total + $tax;
                $dis = ($grandtotal * $discount)/100;
                $unitid = $_POST['unitsid'][$row];
                $grandtotal1 = $total + $tax - $dis;
                $actualpur = $grandtotal1/$totquantity;
                $actualpur1 = round($actualpur, 3);
                    $data = array(
                        'pur_id'   =>  $purid,
                        'mid'      =>  $medicine,
                        'supp_id'      =>$supplier,
                        'qty'      =>  $totalQnty,
                        'supplier_price'=>$tradeprice,
                        'discount'   =>  $discount,
                        'expire_date'   =>  $expire,
                        'total_amount'  =>  $total,
                        'Batch_Number'  =>  $batch_no,
                        'mrp'  =>  $mrp,
                        'tax'  => $tax,
                        'unit_mrp' => $unitmrp,
                        'unit_price' => $perunitprice,
                        'free_qty' => $totfreeqty,
                        'actual_purrate'  => $actualpur1,
                        'unit' => $unitid 
                    );
                $success = $this->purchase_model->Save_Purchase_History($data);
                    }
                }                
                foreach($_POST['qty'] as $row=>$name){
                if(!empty($_POST['qty'][$row])){
                $medicine   =   $_POST['medicine'][$row];
                $qty        =   $_POST['qty'][$row];
                $freeqty        =   $_POST['freeqty'][$row];
                $mrp        =   $_POST['mrp'][$row];
                $tradeprice =   $_POST['tradeprice'][$row];
                $batch_no   =   $_POST['batch_no'][$row];
                $wholesaller=   $_POST['wholesaler'][$row];
                $unit       =   $_POST['units'][$row];
                $unitmrp    =   $_POST['unitmrp'][$row];
                $totalQnty  =   ($unit*$qty) + ($unit*$freeqty);
                if(empty($wholesaller))
                {
                  $wholesaller = '';
                }
                $expire     =   $_POST['expiredate'][$row];     
                //$medicinestock = $this->purchase_model->getMedicineStock($medicine);
                //$instock = $medicinestock->instock + $qty;
                $medicinestock = $this->purchase_model->getmedicineByMId($medicine);
                $instock = $medicinestock->instock + $qty;
               
                 if(!empty($wholesaller)){
                        $wholesaller = $medicinestock->discount; 
                    }
                    $data = array(
                        'product_id'   =>  $medicine,
                        'instock'      =>  $instock,
                        'purchase_rate'   =>  $mrp,
                        'discount'    =>  $wholesaller,
                        'expire_date123'   =>  $expire
                    );
                    $check_batch_no = $this->purchase_model->check_batch_no12($medicine, $batch_no, $supplier);
                    if(!empty($check_batch_no))
                    {
                        
                        $getstock = $this->purchase_model->get_med_stock_medicine_meta($medicine, $batch_no, $supplier);
                        $pre_stock = $getstock[0]->instock;
                        $new_stock = $qty + $freeqty;
                        $total_stock = $pre_stock + $new_stock;
                        $stock = array(
                                "instock" => $total_stock
                             );
                         $Update_Medicine_meta_stock = $this->purchase_model->Update_Medicine_meta_stock($medicine, $batch_no, $supplier, $stock);
                        // $success = $this->purchase_model->Update_Medicine($medicine,$data);
 
                        $check_med_stock = $this->purchase_model->check_med_stock($medicine);
                        $pre_stock = $check_med_stock[0]->instock;
                        $new_stock = $qty + $freeqty;
                        $total_stock = $pre_stock + $new_stock;
                        $stock1 = array(
                                "instock" => $total_stock
                             );
                             
                        $update_med_stock = $this->purchase_model->update_med_stock($medicine, $stock1);
 
         
                       // $success = $this->purchase_model->Update_Medicine($medicine,$data);
                  
                    }
                    else{
                        $value = array(                           
                            "product_id" => $medicine,
                            "supplier_id" => $supplier,
                            "Batch_Number" => $batch_no,
                            "expire_date" => $expire,
                            "purchase_rate" => $tradeprice,
                            "mrp" => $unitmrp,
                            "instock" => $totalQnty,

                       );
                      
                      
                          $insert_med_meta = $this->purchase_model->insert_med_meta($value);

                           $check_med_stock = $this->purchase_model->check_med_stock($medicine);
                           $pre_stock = $check_med_stock[0]->instock;
                           $new_stock = $qty + $freeqty;
                           $total_stock = $pre_stock + $new_stock;
                           $stock = array(
                                   "instock" => $total_stock
                                );
                                
                           $update_med_stock = $this->purchase_model->update_med_stock($medicine, $stock);
                    }

                    $check_batch_no = $this->purchase_model->check_batch($medicine,$supplier,$batch_no);
                  //  print_r($check_batch_no);
                    if(!empty($check_batch_no))
                    {

                        $pre_stock = $check_batch_no[0]->instock;
                        $new_stock = $qty + $freeqty;
                        $total_stock = $pre_stock + $new_stock;
                        $stock = array(
                                "instock" => $total_stock
                            );
                        $success = $this->purchase_model->Update_Store_Mata1($medicine,$supplier,$batch_no,$stock); 
                    }
                  else{
                    $saleqty = $medicinestock->sale_qty;
                    $manfdate = $medicinestock->manf_date;
                    $data = array();
                    $data = array(
                        'product_id' => $medicine,
                        'supplier_id' => $supplier,
                        'Batch_Number' => $batch_no,
                        'manf_date' => $manfdate,
                        'expire_date' => $expire,
                        'purchase_rate' => $tradeprice,
                        'mrp' => $unitmrp,
                        'store_id' => $storeid,
                        'instock' => $totalQnty,
                        'sale_qty' => $saleqty,
                        'discount' => $wholesaller,
                        'tax' => $sumTax,
                        
                    );
                    $success = $this->purchase_model->Insert_Store_Mata($data);
                    }
                
                }
                   
                }
                $settings   = $this->configuration_model->getAllSettings();
                $supplierval = $this->supplier_model->GetSupplierValueById($supplier);
                
                $createdate = date("d-m-Y", strtotime($createdate));
                echo "<div class='row'>
                    <div class='col-md-12'>
                        <div class='card card-body printableArea' id='printableArea'>
                            <h5>INVOICE: <span class='pull-right text-muted'>#$invoice</span></h5>
                            <hr>
                            <div class='row'>
                                <div class='col-md-12' style='margin-top: -32px;'>
                                    <div class='pull-left'>
                                        <address>
                                            <h3> &nbsp;<b class='text-muted'>$supplierval->s_name</b></h3>
                                            <p class='text-muted m-l-5'>$supplierval->s_address</p>
                                            <p class='text-muted m-l-5'>GST:$supplierval->s_gst</p>
                                        </address>
                                    </div>
                                    <div class='pull-right text-right'>
                                        <address>
                                            <h3 class='text-muted'>To,</h3>
                                            <h5 class='text-muted'>$settings->name</h5>
                                            <p class='text-muted m-l-10'>$settings->address,
                                                <br> $settings->email,
                                                <br> $settings->contact 
                                                <br>(GST No) $settings->gst
                                                </p>
                                                
                                            <p class='text-muted m-t-5'><b>Invoice Date :</b> <i class='fa fa-calendar'></i> $createdate</p>
                                        </address>
                                    </div>
                                </div>
                                <div class='col-md-12'>
                                    <div class='table-responsive m-t-10' style='clear: both;'>
                                        <table class='table table-hover'>
                                            <thead>              
                                                <tr>
                                                    <th class=''>Medicine</th>
                                                    <th>Quantity</th>
                                                    <th>Free Qty</th>
                                                    <th class=''>Trade Price</th>
                                                    <th class=''>Tax</th>
                                                    <th class=''>Discount</th>
                                                    <th class=''>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>";
                                            $totalAmnt = $grandamount - $sumTax;
                                            $total1=0;
                                            $total2=0;
                                            $sumtax1 =0;
                                        foreach($_POST['qty'] as $row=>$name){
                                        if(!empty($_POST['qty'][$row])){
                                        $medicine   =   $_POST['medicine'][$row];
                                        $qty        =   $_POST['qty'][$row];
                                        $freeqty        =   $_POST['freeqty'][$row];
                                        $mrp        =   $_POST['mrp'][$row];
                                        $tradeprice =   $_POST['tradeprice'][$row];    
                                        $wholesaller=   $_POST['wholesaler'][$row];
                                        $expire     =   $_POST['expiredate'][$row];
                                        /*$discount   =   $_POST['discount'][$row];*/
                                        $total      =   $_POST['totalval'][$row];
                                        $tax      =   $_POST['tax'][$row];
                                        $tax1 = round($tax, 2);
                                        $total1 += $wholesaller;
                                        $total2 += $total;
                                        $sumtax1 += $tax;
                                        $totalwithoutdis = $total2 + $sumtax1;
                                        $medicinestock = $this->purchase_model->getmedicineByMId($medicine);
                                         
                                                echo "<tr>
                                                    <td class=''> $medicinestock->product_name </td>
                                                    <td>$qty</td>
                                                    <td>$freeqty</td>
                                                    <td class=''> $tradeprice </td>
                                                    <td class=''> $tax1 </td>
                                                    <td class=''> $wholesaller </td>                                                   
                                                    <td class=''> $total </td>
                                                </tr>";
                                        }
                                        }
                                            echo "</tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class='col-md-12'>
                                    <div class='pull-right m-t-5 text-right'>
                                    <p style='margin-bottom: auto'>Sub - Total: $total2</p>
                                        <p style='margin-bottom: auto'>Sub - Tax amount: $sumTax</p>
                                        <p style='margin-bottom: auto'>Sub - Total amount: $totalwithoutdis</p>
                                        <p style='margin-bottom: auto'>Sub - Discount: $total1</p>
                                        <p style='margin-bottom: auto'>Sub - Total Paid: $paid</p>
                                        <p style='margin-bottom: auto'>Adjusted Amount: $billadjustment</p>
                                        <p style='margin-bottom: auto'>Sub - Total Due: $duev </p>
                                        <hr>
                                    </div>
                                    <div class='clearfix'></div>
                                    <hr>
                                </div>
                                <div class='col-md-12 m-t-10'>
                                    <div class='clearfix'>
                                    <div class='col-md-4'>
                                    <div id='signaturename'>
                                        Signature:
                                    </div>

                                    <div id='signature'>
                                    </div>
                                    </div>
                                    <div class='col-md-8'>
                                    </div>
                                    </div>
                                    <hr>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>";
            }
            



        } 
             
    }

    public function Update_Purchase_Invoice(){
        $purid    =   $this->input->post('pur_id');
        $supplier   =   $this->input->post('supplier');
        $invoice    =   $this->input->post('invoice');
        $createdate  =   $this->input->post('entrydate');
        $entrydate  =   strtotime($this->input->post('entrydate'));
        $idd          = $this->input->post('idd'); 
        $entrydate = date("d-m-Y", $entrydate);
        $details    =   $this->input->post('details');
        
         date_default_timezone_set("Asia/Kolkata");
        $date       =   date('d/m/Y');
        $mtype    =   $this->input->post('mtype');
        $bankid    =   $this->input->post('bankid');
        $deliverytime = $this->input->post('delivery_time');
        $paymenttime = $this->input->post('payment_time');
        $entryid = $this->session->userdata('user_login_id');
        $billadjustment = $this->input->post('billadjustment'); 
        if(!empty($bankid)){
            $bankname = $this->purchase_model->GetBankName($bankid);
        }
        $bankinfo = $this->user_model->Getbankinfowithsupplier();
        $cheque    =   $this->input->post('cheque');
        $issuedate    =   $this->input->post('issuedate');
        $rname    =   $this->input->post('rname');
        $rcontact    =   $this->input->post('rcontact');
        $paydate    =   $this->input->post('paydate');
        /*$tdiscount  =   round($this->input->post('tdiscount'));*/
        $sumTax =  $this->input->post('sumTax');
        $grandamount = $this->input->post('grandamount');
        $paid =  $this->input->post('paid');
        $duev =  abs($this->input->post('due'));         
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('supplier', 'Supplier', 'trim|required|xss_clean');
        $this->form_validation->set_rules('expiredate[]', 'ExpiryDate', 'trim|required|xss_clean');
        $this->form_validation->set_rules('qty[]', 'Quantity', 'trim|xss_clean');
        $this->form_validation->set_rules('invoice', 'Invoice', 'trim|required|xss_clean');
        $checksameinvoice = $this->purchase_model->GePurchaseInvoice($invoice);
        $storeid = $this->session->userdata('store_id');
        
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        } else {
            
                /*Root Accounts Start*/
                $account = $this->user_model->GetAccountBalance();
                if(!empty($account))
                {
                    $id = $account->id;
                    $amount = $account->amount - $paid;
                        $data = array(
                            'amount'   =>  $amount
                        );
                    $success = $this->user_model->UPDATE_ACCOUNT($id,$data); 
                }
                
                /*Root Accounts end*/
                
                
                $supplierbalance1 = $this->supplier_model->Getsupplierbalance($supplier);
                
                if(!empty($supplierbalance1)){
                    
                    $supplierAccbalance1 = $this->supplier_model->GetsupplierAccbalance1($purid);
                    
                    $exitotamt  = $supplierbalance1->total_amount;
                    $existotpaid = $supplierbalance1->total_paid;
                    $existotdues = $supplierbalance1->total_due;
                    
                    if(!empty($supplierAccbalance1)){
                        $oldtotamt = $supplierAccbalance1[0]->total_amount;
                        $oldtotpaid = $supplierAccbalance1[0]->paid_amount;
                        $oldtotdues = $supplierAccbalance1[0]->due_amount;
                        }
                        else{
                            $oldtotamt = 0;
                            $oldtotpaid = 0;
                            $oldtotdues = 0;  
                        }
                       
                    $total1 = $exitotamt - $oldtotamt + $grandamount;
                    $paid1 = $existotpaid - $oldtotpaid + $paid;
                    $dues1 = $existotdues - $oldtotdues + $duev;
                    $data = array();
                    $data = array(
                        'total_amount' => $grandamount,
                        'total_paid' => $paid1,
                        'total_due' => $dues1
                    );
                    
                    $success = $this->supplier_model->update_Supplier_balance($supplier,$data); 
                }
                
               


                

                $supplierAccbalance1 = $this->supplier_model->GetsupplierAccbalance1($purid);

                if(!empty($supplierAccbalance1)){
                // $oldpaid = $supplierAccbalance1[0]->total_amount;
                // $totalpaid = $oldpaid + $paid;
                $data = array();
                
                $data = array(
                    'supp_id' => $supplier,
                    'pur_id' => $purid,
                    'type' => $mtype,
                    'bank_id' => $bankid,
                    'cheque_no' => $cheque,
                    'issue_date' => $issuedate,
                    'receiver_name' => $rname,
                    'receiver_contact' => $rcontact,
                    'date' => $paydate,
                    'paid_amount' => $paid
                );
                
                $success = $this->purchase_model->Update_Supplier_amount($purid,$data);
                
            }
            
                
                $supplierAccbalance = $this->supplier_model->GetsupplierAccbalance($purid);
                
        
                $resource = 'purchase';
                $data = array(
                    'supplier_id' => $supplier,
                    'pur_id' => $purid,
                    'date' => $paydate,
                    'total_amount' => $grandamount,
                    'paid_amount' => $paid,
                    'due_amount' => $duev,
                    'from' => $resource
                );
               
                $success = $this->purchase_model->Update_Supplier_PayHistory($purid,$data);   
            
                /*Root Accounts end*/                
                foreach($_POST['qty'] as $row=>$name){
                    if(!empty($_POST['qty'][$row])){
                $idd   =   $_POST['idd'][$row];
                $medicine   =   $_POST['medicine'][$row];
                $qty        =   $_POST['qty'][$row];
                $freeqty        =   $_POST['freeqty'][$row];
                $tradeprice =   $_POST['tradeprice'][$row];
                $mrp        =   $_POST['mrp'][$row];
                /*$discount   =   $_POST['discount'][$row];*/
                $total      =   $_POST['totalval'][$row];
                $expire     =   strtotime($_POST['expiredate'][$row]); 
                $expire     =    date("d-m-Y", $expire);
                $batch_no   =   $_POST['batch_no'][$row];
                $tax        =   $_POST['tax'][$row];
                $discount         =   $_POST['wholesaler'][$row];
                $unit       =   $_POST['units'][$row];
                $unitmrp    =   $_POST['unitmrp'][$row];
                $totalQnty  =   ($unit*$qty);
                $totfreeqty = ($unit*$freeqty);
                $perunitprice = $tradeprice / $unit;
                $totquantity = $totalQnty + $totfreeqty;
                $grandtotal = $total + $tax;
                $dis = ($grandtotal * $discount)/100;
                $unitid = $_POST['unitsid'][$row];
                $grandtotal1 = $total + $tax - $dis;
                $actualpur = $grandtotal1/$totquantity;
                $actualpur1 = round($actualpur, 3);
                    $data = array(
                        'pur_id'   =>  $purid,
                        'mid'      =>  $medicine,
                        'supp_id'      =>$supplier,
                        'qty'      =>  $totalQnty,
                        'supplier_price'=>$tradeprice,
                        'discount'   =>  $discount,
                        'expire_date'   =>  $expire,
                        'total_amount'  =>  $total,
                        'Batch_Number'  =>  $batch_no,
                        'mrp'  =>  $mrp,
                        'tax'  => $tax,
                        'unit_mrp' => $unitmrp,
                        'unit_price' => $perunitprice,
                        'free_qty' => $totfreeqty,
                        'actual_purrate'  => $actualpur1,
                        'unit'  => $unitid
                    );
                    if($idd == 0){

                        $success = $this->purchase_model->Save_Purchase_History($data);
                       }else{
    
                        
                       }
                    
                    }
                }                
                foreach($_POST['qty'] as $row=>$name){
                if(!empty($_POST['qty'][$row])){
                $medicine   =   $_POST['medicine'][$row];
                $qty        =   $_POST['qty'][$row];
                $freeqty        =   $_POST['freeqty'][$row];
                $mrp        =   $_POST['mrp'][$row];
                $idd   =   $_POST['idd'][$row]; 
                $tradeprice =   $_POST['tradeprice'][$row];
                $batch_no   =   $_POST['batch_no'][$row];
                $wholesaller=   $_POST['wholesaler'][$row];
                $unit       =   $_POST['units'][$row];
                $unitmrp    =   $_POST['unitmrp'][$row];
                $totalQnty  =   ($unit*$qty) + ($unit*$freeqty);
                if(empty($wholesaller))
                {
                  $wholesaller = '';
                }
                $expire     =   $_POST['expiredate'][$row];     
                //$medicinestock = $this->purchase_model->getMedicineStock($medicine);
                //$instock = $medicinestock->instock + $qty;
                $medicinestock = $this->purchase_model->getmedicineByMId($medicine);
                $instock = $medicinestock->instock + $qty;
               
                 if(!empty($wholesaller)){
                        $wholesaller = $medicinestock->discount; 
                    }
                    $data = array(
                        'product_id'   =>  $medicine,
                        'instock'      =>  $instock,
                        'purchase_rate'   =>  $mrp,
                        'discount'    =>  $wholesaller,
                        'expire_date123'   =>  $expire
                    );
                    $check_batch_no = $this->purchase_model->check_batch_no12($medicine, $batch_no, $supplier);
                    if(!empty($check_batch_no))
                    {
                        
                        $getstock = $this->purchase_model->get_med_stock_medicine_meta($medicine, $batch_no, $supplier);
                        $pre_stock = $getstock[0]->instock;
                        $new_stock = $qty + $freeqty;
                        $total_stock = $pre_stock + $new_stock;
                        $stock = array(
                                "instock" => $total_stock
                             );
                             if($idd == 0){
                         $Update_Medicine_meta_stock = $this->purchase_model->Update_Medicine_meta_stock($medicine, $batch_no, $supplier, $stock);
                             }
                             else{

                             }
                        // $success = $this->purchase_model->Update_Medicine($medicine,$data);
 
                        $check_med_stock = $this->purchase_model->check_med_stock($medicine);
                        $pre_stock = $check_med_stock[0]->instock;
                        $new_stock = $qty + $freeqty;
                        $total_stock = $pre_stock + $new_stock;
                        $stock1 = array(
                                "instock" => $total_stock
                             );
                          if($idd == 0){   
                        $update_med_stock = $this->purchase_model->update_med_stock($medicine, $stock1);
                          }
                          else{

                          }
         
                       // $success = $this->purchase_model->Update_Medicine($medicine,$data);
                  
                    }
                    else{
                        $value = array(                           
                            "product_id" => $medicine,
                            "supplier_id" => $supplier,
                            "Batch_Number" => $batch_no,
                            "expire_date" => $expire,
                            "purchase_rate" => $tradeprice,
                            "mrp" => $unitmrp,
                            "instock" => $totalQnty,

                       );
                      
                           if($idd == 0){
                           $insert_med_meta = $this->purchase_model->insert_med_meta($value);
                           }
                           else{

                           }
                           $check_med_stock = $this->purchase_model->check_med_stock($medicine);
                           $pre_stock = $check_med_stock[0]->instock;
                           $new_stock = $qty + $freeqty;
                           $total_stock = $pre_stock + $new_stock;
                           $stock = array(
                                   "instock" => $total_stock
                                );
                           if($idd == 0){
                           $update_med_stock = $this->purchase_model->update_med_stock($medicine, $stock);
                           }
                           else{

                           }
                    }

                    $check_batch_no = $this->purchase_model->check_batch($medicine,$supplier,$batch_no);
                  //  print_r($check_batch_no);
                    if(!empty($check_batch_no))
                    {

                        $pre_stock = $check_batch_no[0]->instock;
                        $new_stock = $qty + $freeqty;
                        $total_stock = $pre_stock + $new_stock;
                        $stock = array(
                                "instock" => $total_stock
                            );
                            if($idd == 0){
                        $success = $this->purchase_model->Update_Store_Mata1($medicine,$supplier,$batch_no,$stock); 
                            }
                            else{

                            }
                    }
                  else{
                    $saleqty = $medicinestock->sale_qty;
                    $manfdate = $medicinestock->manf_date;
                    $data = array();
                    $data = array(
                        'product_id' => $medicine,
                        'supplier_id' => $supplier,
                        'Batch_Number' => $batch_no,
                        'manf_date' => $manfdate,
                        'expire_date' => $expire,
                        'purchase_rate' => $tradeprice,
                        'mrp' => $unitmrp,
                        'store_id' => $storeid,
                        'instock' => $totalQnty,
                        'sale_qty' => $saleqty,
                        'discount' => $wholesaller,
                        'tax' => $sumTax,
                        
                    );
                    if($idd == 0){
                    $success = $this->purchase_model->Insert_Store_Mata($data);
                    }
                    else{
                        
                    }
                    }
                
                }
                   
                }
                $settings   = $this->configuration_model->getAllSettings();
                $supplierval = $this->supplier_model->GetSupplierValueById($supplier);
                
                $createdate = date("d-m-Y", strtotime($createdate));
                echo "<div class='row'>
                    <div class='col-md-12'>
                        <div class='card card-body printableArea' id='printableArea'>
                            <h5>INVOICE: <span class='pull-right text-muted'>#$invoice</span></h5>
                            <hr>
                            <div class='row'>
                                <div class='col-md-12' style='margin-top: -32px;'>
                                    <div class='pull-left'>
                                        <address>
                                            <h3> &nbsp;<b class='text-muted'>$supplierval->s_name</b></h3>
                                            <p class='text-muted m-l-5'>$supplierval->s_address</p>
                                        </address>
                                    </div>
                                    <div class='pull-right text-right'>
                                        <address>
                                            <h3 class='text-muted'>To,</h3>
                                            <h5 class='text-muted'>$settings->name</h5>
                                            <p class='text-muted m-l-10'>$settings->address,
                                                <br> $settings->email,
                                                <br> $settings->contact </p>
                                            <p class='text-muted m-t-5'><b>Invoice Date :</b> <i class='fa fa-calendar'></i> $createdate</p>
                                        </address>
                                    </div>
                                </div>
                                <div class='col-md-12'>
                                    <div class='table-responsive m-t-10' style='clear: both;'>
                                        <table class='table table-hover'>
                                            <thead>              
                                                <tr>
                                                    <th class=''>Medicine</th>
                                                    <th>Quantity</th>
                                                    <th>Free Qty</th>
                                                    <th class=''>Trade Price</th>
                                                    <th class=''>Tax</th>
                                                    <th class=''>Discount</th>
                                                    <th class=''>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>";
                                            $totalAmnt = $grandamount - $sumTax;
                                            $total1=0;
                                            $total2=0;
                                            $sumtax1 =0;
                                        foreach($_POST['qty'] as $row=>$name){
                                        if(!empty($_POST['qty'][$row])){
                                        $medicine   =   $_POST['medicine'][$row];
                                        $qty        =   $_POST['qty'][$row];
                                        $freeqty        =   $_POST['freeqty'][$row];
                                        $mrp        =   $_POST['mrp'][$row];
                                        $tradeprice =   $_POST['tradeprice'][$row];    
                                        $wholesaller=   $_POST['wholesaler'][$row];
                                        $expire     =   $_POST['expiredate'][$row];
                                        /*$discount   =   $_POST['discount'][$row];*/
                                        $total      =   $_POST['totalval'][$row];
                                        $tax      =   $_POST['tax'][$row];
                                        $tax1 = round($tax, 2);
                                        $total1 += $wholesaller;
                                        $total2 += $total;
                                        $sumtax1 += $tax;
                                        $totalwithoutdis = $total2 + $sumtax1;
                                        $medicinestock = $this->purchase_model->getmedicineByMId($medicine);
                                         
                                                echo "<tr>
                                                    <td class=''> $medicinestock->product_name </td>
                                                    <td>$qty</td>
                                                    <td>$freeqty</td>
                                                    <td class=''> $tradeprice </td>
                                                    <td class=''> $tax1 </td>
                                                    <td class=''> $wholesaller </td>                                                   
                                                    <td class=''> $total </td>
                                                </tr>";
                                        }
                                        }
                                            echo "</tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class='col-md-12'>
                                    <div class='pull-right m-t-5 text-right'>
                                    <p style='margin-bottom: auto'>Sub - Total: $total2</p>
                                        <p style='margin-bottom: auto'>Sub - Tax amount: $sumTax</p>
                                        <p style='margin-bottom: auto'>Sub - Total amount: $totalwithoutdis</p>
                                        <p style='margin-bottom: auto'>Sub - Discount: $total1</p>
                                        <p style='margin-bottom: auto'>Sub - Total Paid: $paid</p>
                                        <p style='margin-bottom: auto'>Adjusted Amount: $billadjustment</p>
                                        <p style='margin-bottom: auto'>Sub - Total Due: $duev </p>
                                        <hr>
                                    </div>
                                    <div class='clearfix'></div>
                                    <hr>
                                </div>
                                <div class='col-md-12 m-t-10'>
                                    <div class='clearfix'>
                                    <div class='col-md-4'>
                                    <div id='signaturename'>
                                        Signature:
                                    </div>

                                    <div id='signature'>
                                    </div>
                                    </div>
                                    <div class='col-md-8'>
                                    </div>
                                    </div>
                                    <hr>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>";
            }
        

        

        }
             
    
    public function Save_Purchase_Bar(){
        $purid      =   'P'.rand(2000,10000000);
        $supplier   =   $this->input->post('supplier');
        $invoice    =   $this->input->post('invoice');
        $createdate  =   $this->input->post('entrydate');
        $entrydate  =   strtotime($this->input->post('entrydate'));
        $deliverytime = $this->input->post('delivery_time');
        $paymenttime = $this->input->post('payment_time');
        $details    =   $this->input->post('details');
        $mtype    =   $this->input->post('mtype');
        $bankid    =   $this->input->post('bankid');
        if(!empty($bankid)){
            $bankname = $this->purchase_model->GetBankName($bankid);
        }
        $bankinfo = $this->user_model->Getbankinfowithsupplier();
        
        $cheque    =   $this->input->post('cheque');
        $issuedate    =   $this->input->post('issuedate');
        $rname    =   $this->input->post('rname');
        $rcontact    =   $this->input->post('rcontact');
        $paydate    =   $this->input->post('paydate');
        /*$tdiscount  =   round($this->input->post('tdiscount'));*/
        $grandamount =  $this->input->post('grandamount');
        $paid =  $this->input->post('paid');
        $duev =  abs($this->input->post('due'));
         date_default_timezone_set("Asia/Dhaka");
        $date       =   strtotime(date('m/d/Y'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('supplier', 'Supplier', 'trim|required|xss_clean');
        $this->form_validation->set_rules('qty[]', 'Quantity', 'trim|xss_clean');
        $this->form_validation->set_rules('invoice', 'Invoice', 'trim|required|xss_clean');
        $checksameinvoice = $this->purchase_model->GePurchaseInvoice($invoice);
        if(!empty($checksameinvoice)){
            echo "This Invoice is Already exist";
            die();
        }
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        } else {               
                
                        foreach($_POST['barqty'] as $row=>$name):
                            if(!empty($_POST['barqty'][$row])){
                                $medicine   =   $_POST['medicine'][$row];     
                                $qty     =   $_POST['barqty'][$row]; 
                                $medicinestock = $this->purchase_model->getmedicineByMId($medicine);
                        
                                $base = base_url();
                                for($i=1;$i<=$qty;$i++){
                                echo "<div id='printArr' style='margin-bottom: 1mm;'>
            
                                        <p class='' style=''>$medicinestock->product_name</p>
                                        <p class='' style=''>$medicinestock->strength &nbsp; &nbsp; $medicinestock->form</p>
                                        <img class='' src='$base/assets/images/barcode/$medicinestock->batch_no.png' alt='Card image' style='max-width: 100%;height: auto;'>
                                        <p style=''>$medicinestock->expire_date</p></div>";
                                };
                            };
                        endforeach;
            }
              
    }    

    /*Purchase History by purchase ID*/
    public function Purchase_History(){
        if($this->session->userdata('user_login_access') != False) {
        $id = base64_decode($this->input->get('H'));
        $data = array();
        $data['purchasehistory'] = $this->purchase_model->GetPurchaseHistory($id);
        //print_r($data['purchasehistory']);
        $this->load->view('backend/purchase_history',$data);
    }
    else{
        redirect(base_url() , 'refresh');
    } 
        }

    /*Purchase Invoice edit page by purchase ID*/

    public function Purchase_Invoice_edit() {
        if($this->session->userdata('user_login_access') != False) {
        $id = base64_decode($this->input->get('H'));
        $data = array();
        $data['supplierList'] = $this->medicine_model->get_supplierlist();
        $data['purchasehistory'] = $this->purchase_model->GetPurchaseHistory($id);
           
        $this->load->view('backend/purchase_edit', $data);
                  
    }
    else{
        redirect(base_url() , 'refresh');
    } 
        }
    

        public function GetPurchaseSpecificdata() {
            $pid = $this->input->get('id');
            $purchaseval = $this->purchase_model->getPurchaseInvoiceDatafromhis($pid);
        
            // Loop through each purchase detail
            foreach ($purchaseval as $purchase) {
                $indate = $purchase->pur_date;
                $sname = $purchase->s_name;
                $sid = $purchase->s_id;
                $puridd = $purchase->pur_id;
                $invoiceno = $purchase->invoice_no;
                $purdetails = $purchase->pur_details;
            }
                echo "<div class='card-body'>
                        <div class=''>
                            <form action='Return_Confirm' method='post' class='form-horizontal' enctype='multipart/form-data' id='purchaserForm'> 
                                <div class='row'>
                                    <div class='col-md-3'>
                                        <div class='form-group'>
                                            <label class='control-label'>Supplier Name</label>
                                            <input type='text' name='company' class='form-control' placeholder='' value='$sname' autocomplete='off' readonly>
                                            <input type='hidden' name='sid' class='form-control' placeholder='' value='$sid' autocomplete='off'>
                                            <input type='hidden' name='purid' class='form-control' placeholder='' value='$puridd' autocomplete='off'>
                                        </div>
                                    </div>
                                    <div class='col-md-2'>
                                        <div class='form-group'>
                                            <label class='control-label'>Invoice No</label>
                                            <input type='text' id='firstName' name='invoice' class='form-control' placeholder='Invoice No' value='$invoiceno' autocomplete='off' readonly>
                                        </div>
                                    </div>                                            
                                    <div class='col-md-2'>
                                        <div class='form-group'>
                                            <label class='control-label'>Invoice Date</label>
                                            <input type='text' id='datepicker' class='form-control datepicker' placeholder='' name='entrydate' autocomplete='off' value='$indate' readonly>
                                        </div>
                                    </div>
                                    <div class='col-md-5'>
                                        <div class='form-group'>
                                            <label class='control-label'>Note</label>
                                            <textarea type='text' name='details' class='form-control' placeholder='Details' rows='1' cols='8' readonly>$purdetails</textarea>
                                        </div>
                                    </div>
                                </div>
                                <table class='table table-bordered m-t-5 purchase'>
                                    <thead>
                                        <tr>
                                            <th>Medicine</th>
                                            <th>Strength</th>
                                            <th>Batch No.</th>
                                            <th>Purchase Qty</th>
                                            <th>Received Qty</th>
                                            <th>Return Qty</th>
                                            <th>Purchase Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id='addPurchaseItem'>";
        
                $counter = 1;
                $purchasedetails = $this->purchase_model->getPurchaseDetailsInvoiceData($pid);
        
                foreach ($purchasedetails as $value) {
                    $purchase = $value->qty + $value->free_qty;
                    $product = $value->mid;
                    $batch = $value->Batch_Number;
                    $grnno = $this->purchase_model->getGrnno($invoiceno, $puridd);
                    if(!empty($grnno)){
                    foreach ($grnno as $grnno1) {
                    $grn = $grnno1->grn_no;
                    $metagrn = $this->purchase_model->getMetagrn($grn, $product, $batch);
                    $recqty = $metagrn[0]->rec_qty;
                    }
                }
                else{
                    $recqty = 0;
                }
                    echo "<tr>
                            <td><input type='text' name='medicisne' class='form-control' placeholder='Medicine' value='$value->product_name' autocomplete='off' readonly>
                                <input type='hidden' name='mid[]' class='form-control' placeholder='Medicine' value='$value->mid' autocomplete='off'>
                                <input type='hidden' name='ph[]' class='form-control' placeholder='Medicine' value='$value->ph_id' autocomplete='off'>
                                <input type='hidden' name='batchno[]' class='form-control' placeholder='Medicine' value='$value->Batch_Number' autocomplete='off'>
                                <input type='hidden' name='supid[]' class='form-control' placeholder='Medicine' value='$value->supp_id' autocomplete='off'>
                            </td>
                            <td><input type='text' class='form-control' name='strenth[]' placeholder='Ounce' readonly value='$value->strength'></td>
                            <td><input type='text' class='form-control' name='batchNu' placeholder='Ounce' readonly value='$value->Batch_Number'></td>
                            <td><input type='number' class='form-control pqty' name='pqty[]' placeholder='' readonly value='$purchase'></td>
                            <td><input type='text' id='received' class='form-control td' name='' placeholder='' value='$recqty' readonly></td>
                            <td><input type='number' data-return='unitmrp-$counter' id='return' class='form-control rqty' name='rqty[]' placeholder='0.00' min='0' max='$recqty' value=''></td>
                            <td><input type='text' class='form-control td12' name='td[]' placeholder='' value='$value->supplier_price' readonly></td>
                            <input type='hidden' id='unitmrp-$counter' class='form-control td' name='unitmrp' placeholder='' value='$value->unit_price' readonly>
                            <td><input type='text' class='form-control total' name='total[]' placeholder='' value='0'></td>
                        </tr>";
                    $counter++;
                }
        
                echo "</tbody>
                    <tbody>
                        <tr>
                            <td class='text-right'> <input type='submit' id='purchasesubmit' class='btn btn-primary btn-block' value='Return'> </td>
                            <td class='text-right font-weight-bold' colspan=4>Grand Total:</td>
                            <td><input type='text' class='form-control gtotal' name='grandamount' placeholder='' readonly value=''></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
        </div>";
            
        }
        

    public function GetSupplierByid22()
    {
      
          $data =  $this->purchase_model->GetSupplierByid22();
          echo json_encode($data);
    }
    public function add_grn()
    {
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
        if (in_array(37, $permissions)) {
        $data['storeList'] = $this->supplier_model->getAllStore();
        $this->load->view('backend/add_grn'); 
    }
    else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
    }
    else{
        redirect(base_url() , 'refresh');
    } 
        }

    public function get_grn_data()
    {
        $p_id = $this->input->post('po_no');
       
        $get_grn_data = $this->purchase_model->get_grn_data($p_id);
    
        if (!empty($get_grn_data)) {
            echo json_encode($get_grn_data, JSON_UNESCAPED_UNICODE);
        } else {
           
            $error_message = "No GRN data found for PO number: $p_id";
            log_message('error', $error_message);
            echo json_encode(['error' => $error_message]);
        }
    }
    

    public function get_supplier_name()
    {
        $sid =  $this->input->post('sid');
        $get_supplier_name =  $this->purchase_model->get_supplier_name($sid);
        echo json_encode($get_supplier_name);
    }

    public function get_medicine_detail()
    {
        $puid = $this->input->post('po_no');
       
      
        $get_medicine_detail = $this->purchase_model->get_medicine_detail_his($puid);
        
       
        if ($get_medicine_detail) {
          
          foreach($get_medicine_detail as $value):
            // print_r($value);
            $get_pending = $this->purchase_model->get_pending($value->mid, $value->supp_id, $value->Batch_Number);
            

            if(!empty($get_pending))
            {
                $pending = ($get_pending[0]->instock);
            }else{
                $pending = '0';
            } 
           $totqty = $value->qty + $value->free_qty;
           $currentDate = date('Y-m-d');
           $recievedqty = $totqty - $pending;
            $total_amount  = $value->tax + $value->total_amount;
            $output = '<tr>';
            $output .= "<td><input type='hidden' name='supplier[]' value='$value->supp_id'><input type='text' name='pro_id[]' value='$value->mid' readonly></td>";
            $output .= "<td><input type='text' name='product_name[]' value='$value->product_name' readonly></td>";
            $output .= "<td><input type='text' name='generic_name[]' value='$value->generic_name' readonly></td>";
            $output .= "<td><input type='text' name='Batch_Number[]' value='$value->Batch_Number' readonly></td>";     
            $output .= "<td><input type='text' name='expire_date[]' value='$value->expire_date' readonly></td>";
            $output .= "<td><input type='text' id='pur' name='mrp[]' value='$value->supplier_price' readonly></td>";
            $output .= "<td><input type='text' id='tax' name='tax[]' value='$value->tax' readonly></td>"; 
            $output .= "<td><input type='text' name='Sch_no[]' value=''></td>";
            $output .= "<td><input type='date' name='Sch_date[]' value='$currentDate'></td>";
            $output .= "<td><input type='text' id='qty' name='sale_qty[]' value='$totqty' readonly></td>";
            $output .= "<td><input type='text' name='pending[]' value='$pending' readonly></td>";   
            $output .= "<td><input type='text' name='rec_qty[]' id='recieved' value='$pending'></td>";   
            $output .= "<td><input type='text' id='tot' name='purchase[]' value='$total_amount' readonly></td>";
            $output .= "<td><input type='hidden' name='instock[]' value='$value->instock' readonly></td>";
            $output .= "<input type='hidden' name='unitmrp[]' value='$value->unit_mrp' readonly>";
            $output .= '</tr>';
            echo ($output);
        endforeach;
        } 
    }

    //public function medi_for_grn()
    // {
    //     $grn_no = $this->input->post('grn_no');
        
    //     // Assuming $this->purchase_model->get_medicine_detail returns an array or object
    //     $get_medicine_detail = $this->purchase_model->medi_for_grn($grn_no);
      
    //     // Check if data is available before constructing HTML
    //     if ($get_medicine_detail) {
          
    //       foreach($get_medicine_detail as $value):
           
    //        $medicine = $this->purchase_model->get_medicine_detail_his($value->po_no);
    //       print_r($medicine);

    //     //     $get_pending = $this->purchase_model->get_pending($value->mid, $value->supp_id, $value->Batch_Number);
    //     //     if(!empty($get_pending))
    //     //     {
    //     //         $pending = ($get_pending[0]->instock);
    //     //     }else{
    //     //         $pending = '0';
    //     //     }
           
            

    //     if(isset($medicine[0])) {
    //         $total_amount  = isset($medicine[0]->tax) ? $medicine[0]->tax : 0 + isset($medicine[0]->total_amount) ? $medicine[0]->total_amount : 0;
    //         $tax = isset($medicine[0]->tax) ? $medicine[0]->tax : 0;
    //         $supplier_price = isset($medicine[0]->supplier_price) ? $medicine[0]->supplier_price : 0;
    //     }
        
    //        $receivedamt = $value->receivedamt;
    //        $dues = $value->dues;
      
    //         $output = '<tr>';
    //         $output .= "<td><input type='text' name='pro_id[]' value='$value->product_id' readonly></td>";
    //         $output .= "<td><input type='text' name='product_name[]' value='' readonly></td>";
    //         $output .= "<td><input type='text' name='generic_name[]' value='' readonly></td>";
    //         $output .= "<td><input type='text' name='Batch_Number[]' value='$value->Batch_Number' readonly></td>";     
    //         $output .= "<td><input type='text' name='expire_date[]' value='$value->expire_date' readonly></td>";
    //         if(isset($medicine[0])) {
    //             $total_amount  = isset($medicine[0]->tax) ? $medicine[0]->tax : 0 + isset($medicine[0]->total_amount) ? $medicine[0]->total_amount : 0;
    //             $supplier_price = isset($medicine[0]->supplier_price) ? $medicine[0]->supplier_price : 0;
    //             $tax = isset($medicine[0]->tax) ? $medicine[0]->tax : 0;
    //             $output .= "<td><input type='text' name='purchase[]' value='$total_amount' readonly></td>"; 
    //             $output .= "<td><input type='text' name='mrp[]' value='$supplier_price' readonly></td>";
    //             $output .= "<td><input type='text' name='tax[]' value='$tax' readonly></td>";
    //         } else {
    //             // Handle case where $medicine[0] is not set
    //             $output .= "<td><input type='text' name='purchase[]' value='0' readonly></td>"; 
    //             $output .= "<td><input type='text' name='mrp[]' value='0' readonly></td>";
    //             $output .= "<td><input type='text' name='tax[]' value='0' readonly></td>";
    //         }; 
    //         $output .= "<td><input type='text' name='Sch_no[]' value='$value->Sch_no' readonly></td>";
    //         $output .= "<td><input type='text' name='Sch_date[]' value='$value->Sch_date' readonly></td>";
            
    //         $output .= "<td><input type='text' name='sale_qty[]' value='$value->instock' readonly></td>";
             
    //         $output .= "<td><input type='text' name='rec_qty[]' value='$value->rec_qty' readonly></td>";   
                                
            
    //         //$output .= "<td><input type='text'  id='reci' name='receivedamt[]' value='$receivedamt' readonly></td>";                   
              
    //         //$output .= "<td><input type='text' id='dues' name='dues[]' value='$dues' readonly></td>";
    //         $output .= "<td><input type='hidden' style='display: none;' name='instock[]' value='$value->instock' readonly></td>";
    //         // $output .= "<td><input class='append-checkbox' type='checkbox' value='$sid' id='appended_check'></td>";
    //         $output .= '</tr>';
    //         echo ($output);
    //     endforeach;
    //     } 
    // }

    public function medi_for_grn()
    {
        $grn_no = $this->input->post('grn_no');
        
        // Assuming $this->purchase_model->get_medicine_detail returns an array or object
        $get_medicine_detail = $this->purchase_model->medi_for_grn($grn_no);
        //   echo "<pre>";
           
        // Check if data is available before constructing HTML
           
        
        if ($get_medicine_detail) {
          
          foreach($get_medicine_detail as $value):
          $purchasedetail =  $this->purchase_model->get_medicine_detail_his($value->po_no);
          
          $med_detail = $this->purchase_model->med_detail($value->product_id);
          $product_name = $med_detail[0]->product_name;
          $generic_name = $med_detail[0]->generic_name;
          $hsn = $med_detail[0]->hsn;
          $gst = $this->purchase_model->get_gst($hsn);
          $igst = $gst[0]->igst;
          



          $Batch_Number = $value->Batch_Number;
          $expire_date =  $value->expire_date;
           $Sch_no =  $value->Sch_no;
           $Sch_date =  $value->Sch_date;
           $instock = $value->instock;
           $rec_qty =  $value ->rec_qty;
           $price =  $value ->price;
           $total = $value ->total_amount;
           $tax = $value ->tax;
           

           $tax = ($total * $igst) / 100;
          
           $total_amount = $total + $tax;
           
        
             $output = '<tr>';
             $output .= "<td><input type='text' name='pro_id[]' value='$value->product_id' readonly></td>";
             $output .= "<td><input type='text' name='product_name[]' value='$product_name' readonly></td>";
             $output .= "<td><input type='text' name='generic_name[]' value='$generic_name' readonly></td>";
             $output .= "<td><input type='text' name='Batch_Number[]' value='$value->Batch_Number' readonly></td>";     
             $output .= "<td><input type='text' name='expire_date[]' value='$value->expire_date' readonly></td>";
             $output .= "<td><input type='text' name='mrp[]' value='$price' readonly></td>";
             $output .= "<td><input type='text' name='tax[]' value='$tax' readonly></td>"; 
             $output .= "<td><input type='text' name='Sch_no[]' value='$Sch_no' readonly></td>";
             $output .= "<td><input type='text' name='Sch_date[]' value='$Sch_date' readonly></td>";
            
             $output .= "<td><input type='text' name='sale_qty[]' value='$instock' readonly></td>";
             
             $output .= "<td><input type='text' name='rec_qty[]' value='$rec_qty' readonly></td>";   
                               
             $output .= "<td><input type='text' name='purchase[]' value='$total_amount' readonly></td>";  
            
            //$output .= "<td><input type='text'  id='reci' name='receivedamt[]' value='$receivedamt' readonly></td>";                   
              
            //$output .= "<td><input type='text' id='dues' name='dues[]' value='$dues' readonly></td>";
            // $output .= "<td><input type='hidden' style='display: none;' name='instock[]' value='$value->instock' readonly></td>";
            // // $output .= "<td><input class='append-checkbox' type='checkbox' value='$sid' id='appended_check'></td>";
             $output .= '</tr>';
             echo ($output);
        endforeach;
        } 
    }


    


    public function append_medicine()
    {
        $sid = $this->input->post('sid');
        $get_medicine_detail = $this->purchase_model->get_medicine_detail($sid);

        if ($get_medicine_detail) {
          $batch =   $get_medicine_detail[0]->Batch_Number;
          $instock =   $get_medicine_detail[0]->instock;
          $expire_date =   $get_medicine_detail[0]->expire_date;

            $output  = '<tr>';
            $output .= '<td>' . $get_medicine_detail[0]->product_name . '</td>';
            $output .= '<td>' . $get_medicine_detail[0]->product_id . '</td>';
            $output .= '<td>' . $get_medicine_detail[0]->generic_name . '</td>';
            $output .= "<td><input type='text' name='batch_array[]' value='$batch'></td>";
            $output .= '<td>' . $get_medicine_detail[0]->manf_date . '</td>';
            $output .= '<td>' . $get_medicine_detail[0]->sale_qty . '</td>';
            $output .= "<td><input type='text' name='instock_array[]' value='$instock'></td>";
            $output .= '<td>' . $get_medicine_detail[0]->unit_price . '</td>';
            $output .= '<td>' . $get_medicine_detail[0]->Batch_Number . '</td>';
            $output .= "<td><input type='text' name='expire_date_array[]' value='$expire_date'></td>";
            $output .= '<td>' . $get_medicine_detail[0]->box_price . '</td>';
            $output .= '<td>' . $get_medicine_detail[0]->purchase . '</td>';
            $output .= "<td><input class='append-checkbox' type='checkbox' value='$sid' id='appended_check'></td>";
            $output .= '</tr>';
            echo ($output);
        } 
    }

    public function save_grn()
    {
        
    //    $store_name = $this->input->post('store_name');
       $po_no = $this->input->post('po_no');
       $supplier_name = $this->input->post('supplier_name');
       $order_type = $this->input->post('order_type');
       $supplier_code = $this->input->post('supplier_code');
       $grn_no = $this->input->post('grn_no');
       $dc_no = $this->input->post('dc_no');
       $dc_date = $this->input->post('dc_date');
       $bill_no = $this->input->post('bill_no');
       $bill_date = $this->input->post('bill_date');
       $bill_amt = $this->input->post('bill_amt');
       $batch_array = $this->input->post('batch_array');
       $instock_array = $this->input->post('instock_array');
       $expire_date_array = $this->input->post('expire_date_array');
       $schno = $this->input->post('Sch_no');
       $schdate = $this->input->post('Sch_date');
       $recqty = $this->input->post('rec_qty');
       $unitmrp = $this->input->post('unitmrp');
    //    $receivedamt = $this->input->post('receivedamt');
    //    $dues = $this->input->post('dues');

       $get_medicine_detail = $this->purchase_model->get_medicine_detail($supplier_code);
       $product_name =  $get_medicine_detail[0]->product_name;
       $product_id =  $get_medicine_detail[0]->product_id;
       $generic_name =  $get_medicine_detail[0]->generic_name;
       $Batch_Number =  $get_medicine_detail[0]->Batch_Number;
       $manf_date =  $get_medicine_detail[0]->manf_date;
       $sale_qty =  $get_medicine_detail[0]->sale_qty;
       $instock =   $get_medicine_detail[0]->instock;
       $unit_price =  $get_medicine_detail[0]->unit_price;
       $expire_date =  $get_medicine_detail[0]->expire_date;
    //    $box_price =   $get_medicine_detail[0]->box_price;
       $purchase =   $get_medicine_detail[0]->purchase;
       $checkin = date("Y-m-d"); 
       
       $id_array = $this->input->post('id_array');
  
       $data = array(
        // "store_name" => $store_name,
        "po_no" => $po_no,
        "supplier_name" => $supplier_name,
        "order_type" => $order_type,
        "supplier_code" => $supplier_code,
        "grn_no" => $grn_no,
        "dc_no" => $dc_no,
        "dc_date" => $dc_date,
        "bill_no" => $bill_no,
        "bill_date" => $bill_date,
        "product_name" => $product_name,
        "generic_name" => $generic_name,
        "manf_date" => $manf_date,
        "unit_price" => $unit_price,
        // "box_price" => $box_price,
        "purchase" => $purchase,
        "grn_date" => $checkin,
        "Sch_no"  => '',
        "Sch_date" => '',
        "rec_qty" => ''
        // "receivedamt" => $receivedamt,
        //  "dues" => $dues
     );
      $save_grn = $this->purchase_model->save_grn($data);
       
       foreach($_POST['pro_id'] as $row=>$name){
        $pro_id   =   $_POST['pro_id'][$row];
        $Sch_no   =   $_POST['Sch_no'][$row];
        $Sch_date   =   $_POST['Sch_date'][$row];
        $rec_qty   =   $_POST['rec_qty'][$row];
        $pro_name = $_POST['product_name'][$row]; 
        $gen_name = $_POST['generic_name'][$row];
        $Batch_Number = $_POST['Batch_Number'][$row]; 
        $expire_date = $_POST['expire_date'][$row]; 
        $instock = $_POST['pending'][$row]; 
        $supplier_id = $_POST['supplier'][$row]; 
        $unitmrp = $_POST['unitmrp'][$row]; 
        $price = $_POST['mrp'][$row];
        //$dues = $_POST['dues'][$row];
        
  
    

      $data2 = array(
        
        "grn_no" => $grn_no,
        "product_id" => $pro_id,
        "Batch_Number" => $Batch_Number,
        "instock" => $instock,
        "expire_date" => $expire_date,
        "Sch_no"  => $Sch_no,
        "Sch_date" => $Sch_date,
        "rec_qty" => $rec_qty,
        "price" => $price,
         "unit_mrp" => $unitmrp,
         "createdAt" => date("Y-m-d")
     );


 $save_grn = $this->purchase_model->save_grn_meta($data2);  
   // }
      $i=0;
    //   if(!empty($batch_array))
    //   {
    //     foreach($batch_array as $val)
    //     {
    //      $data2 = array(
         
    //          "grn_no" => $grn_no,
    //          "product_id" => $pro_id,
    //          "Batch_Number" => $Batch_Number,
    //          "instock" => $instock[$i],
    //          "expire_date" => $expire_date[$i],
    //          "Sch_no"  => $Sch_no[$i],
    //         "Sch_date" => $Sch_date[$i],
    //         "rec_qty" => $rec_qty[$i]
    //       );
    //       $i++;
          
    //   $save_grn = $this->purchase_model->save_grn_meta($data2);  
    //   }

    //    }
       //Update grn
       $originalDate = $expire_date;

// edited 
   $unixTime = strtotime($originalDate);

// edited
   $newDate = date("Y-m-d", $unixTime);
    

       $check_purchase = $this->purchase_model->check_purchase($pro_id, $supplier_id, $Batch_Number, $newDate);
       // edited changed expire_date with newDate
        
       if(!empty($check_purchase))
       {
       
        $check_pre_update = $this->purchase_model->check_pre_update($pro_id, $supplier_id, $Batch_Number, $newDate, $data);  //edited changed expire_date with newDate
        if(!empty($check_pre_update))
        { 
            echo "not empty";
            $data = array(
                "instock" => $rec_qty + $check_pre_update[0]->instock,
                "status" => 1
                );
              $update_status = $this->purchase_model->update_status_at_one($pro_id, $supplier_id, $Batch_Number, $newDate, $data); //edited changed expire_date with newDate

              $check_pre_update_zero = $this->purchase_model->check_pre_update_zero($pro_id, $supplier_id, $Batch_Number, $newDate); //edited changed expire_date with newDate
            
              $data55 = array(
                "instock" => $check_pre_update_zero[0]->instock - $rec_qty,
                
                );
                
                
                $update_pre_update_zero = $this->purchase_model->update_pre_update_zero($pro_id, $supplier_id, $Batch_Number, $newDate, $data55);  //edited changed expire_date with newDate
                
        }
        else{
           
            $purchase_stock = $check_purchase[0]->instock;
     
            $data = array(
            "instock" => $rec_qty,
            "status" => 1
        );
    
       $update_status = $this->purchase_model->update_status($pro_id, $supplier_id, $Batch_Number, $newDate, $data); //edited changed expire_date with newDate
       $pending = $purchase_stock - $rec_qty;
if($pending > 0){
       $pending_stock = array(
        "product_id" => $check_purchase[0]->product_id,
        "supplier_id" => $check_purchase[0]->supplier_id,
        "Batch_Number" => $check_purchase[0]->Batch_Number,
        "manf_date" => $check_purchase[0]->manf_date,
        "expire_date" => $check_purchase[0]->expire_date,
        "purchase_rate" => $check_purchase[0]->purchase_rate,
        "mrp" => $check_purchase[0]->mrp,
        "instock" => $pending,
        "sale_qty" => $check_purchase[0]->sale_qty,
        "discount" => $check_purchase[0]->discount,
        "tax" => $check_purchase[0]->tax,
        "store_id" => $check_purchase[0]->store_id,
        "status" => 0
       );
    
      $insert_pending_stock = $this->purchase_model->insert_pending_stock($pending_stock);
      
    }

        }
            
    }

       // change status in medicine meta
       $medicine_meta = $this->purchase_model->check_status_in_med_meta($pro_id, $supplier_id, $Batch_Number);
       if(!empty($medicine_meta))
       {
        $data = array(
            "status" => 1
        );
       $update_status = $this->purchase_model->update_status_med_meta($pro_id, $supplier_id, $Batch_Number, $data); 
       } 

       else
       {
        $pending = $purchase_stock - $rec_qty;

        $data = array(
            "instock" => $rec_qty,
            "status" => 1
        );
        $update_status = $this->purchase_model->update_status_med_meta($pro_id, $supplier_id, $Batch_Number, $data); 
        if($pending > 0){
        $pending_stock = array(
            "product_id" => $medicine_meta[0]->product_id,
            "supplier_id" => $medicine_meta[0]->supplier_id,
            "Batch_Number" => $medicine_meta[0]->Batch_Number,
            "manf_date" => $medicine_meta[0]->manf_date,
            "expire_date" => $medicine_meta[0]->expire_date,
            "purchase_rate" => $medicine_meta[0]->purchase_rate,
            "mrp" => $medicine_meta[0]->mrp,
            "instock" => $pending,
            "sale_qty" => $medicine_meta[0]->sale_qty,
            "discount" => $medicine_meta[0]->discount,
            "tax" => $medicine_meta[0]->tax,
            //"store_id" => $medicine_meta[0]->store_id,
            "status" => 0
           );
          $insert_pending_stock = $this->purchase_model->insert_pending_stock_in_medicine_meta($pending_stock);
       }
    }

       
       
      
    }
        $response['status'] = 'success';
        $response['message'] = "Successfully Added";
        $response['curl'] = base_url()."purchase/manage_grn";
        $this->output->set_output(json_encode($response)); 
       
    }
    public function manage_grn()
    {
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
        if (in_array(36, $permissions)) {
        $data['grn'] = $this->purchase_model->get_grn();
        $this->load->view('backend/manage_grn', $data);
    }
    else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
    }
    else{
        redirect(base_url() , 'refresh');
    } 
        }

    public function delete_grn()
   {
       $grn_id = $this->uri->segment(3);
       $delete_grn= $this->purchase_model->delete_grn($grn_id);
       redirect('Purchase/manage_grn');
        
   }

   public function edit_grn()
   {
    if($this->session->userdata('user_login_access') != False) {
    $grn_id = $this->uri->segment(3);
    $data['grn']= $this->purchase_model->edit_grn($grn_id);
    $this->load->view('backend/edit_grn', $data);
   }
   else{
    redirect(base_url() , 'refresh');
      } 
    }

   public function get_edit_grn()
   {
     $grn_id = $this->input->post('id');
     $data = $this->purchase_model->edit_grn($grn_id);
     echo json_encode($data);
   }

   public function get_edit_medicine_detail()
   {
        $grn_no = $this->input->post('grn_no');
        $get_medicine_detail = $this->purchase_model->get_edit_medicine_detail($grn_no);
     
        foreach($get_medicine_detail as $row)
       {
      
      
         $supplier_name = $this->purchase_model->get_sup_id($row->supplier_name);
        $sid = $supplier_name[0]->s_id;
    
         $get_med_det = $this->purchase_model->get_med_det($row->product_id, $row->Batch_Number, $sid);
        echo  "<pre>";
        print_r($get_med_det[0]->tax);


          $batch =   $row->Batch_Number;
          $instock =   $row->instock;
          $expire_date =   $row->expire_date;

            $output  = '<tr>';
            $output .= '<td>' . $row->product_name . '</td>';
            $output .= '<td>' . $row->product_id . '</td>';
            $output .= '<td>' . $row->generic_name . '</td>';
            $output .= "<td><input type='text' name='batch_array[]' value='$batch'></td>";
            $output .= "<td><input type='text' name='expire_date_array[]' value='$expire_date'></td>";
            $output .= "<td><input type='text' name='mrp[]' value=''></td>";
            $output .= '<td>' . $row->Sch_no . '</td>';
            $output .= '<td>' . $row->Sch_date . '</td>';
            $output .= "<td><input type='text' name='instock_array[]' value='$instock'></td>";
            $output .= '<td>' . $row->unit_price . '</td>';
           
           
            $output .= "<input type='hidden' name='id_array[]' value='$row->idd'>";
            $output .= '<td>' . $row->box_price . '</td>';
            $output .= '<td>' . $row->purchase . '</td>';
            // $output .= "<td id='$row->idd'><input class='append-checkbox' type='checkbox' data-id='$row->idd' value='$row->idd' id='appended_check'></td>";
            // $output .= "<td id='$row->idd'><input type='button' data-id='$row->idd' value='Delete' id='delete_btn'> ";
            $output .= '</tr>';
            echo ($output);
       }
  
    
   }

   public function edit_grn_data()
   {
    $store_name = $this->input->post('store_name');
    $po_no = $this->input->post('po_no');
    $supplier_name = $this->input->post('supplier_name');
    $order_type = $this->input->post('order_type');
    $supplier_code = $this->input->post('supplier_code');
    $grn_no = $this->input->post('grn_no');
    $dc_no = $this->input->post('dc_no');
    $dc_date = $this->input->post('dc_date');
    $bill_no = $this->input->post('bill_no');
    $bill_date = $this->input->post('bill_date');
    $bill_amt = $this->input->post('bill_amt');
    $batch_array = $this->input->post('batch_array');
    $instock_array = $this->input->post('instock_array');
    $expire_date_array = $this->input->post('expire_date_array');
    $get_medicine_detail = $this->purchase_model->get_medicine_detail($supplier_code);
    $product_id = $get_medicine_detail[0]->product_id;
    $product_name =  $get_medicine_detail[0]->product_name;
    $generic_name =  $get_medicine_detail[0]->generic_name;
    $manf_date =  $get_medicine_detail[0]->manf_date;
    $sale_qty =  $get_medicine_detail[0]->sale_qty;
    $unit_price =  $get_medicine_detail[0]->unit_price;
    $box_price =   $get_medicine_detail[0]->box_price;
    $purchase =   $get_medicine_detail[0]->purchase;
    $id_array = $this->input->post('id_array');
    $delete_grn_meta = $this->purchase_model->delete_grn_meta($grn_no);
  
   $i=0;
    foreach($id_array as $val)
    {
    
        $data = array(
            "store_name" => $store_name,
            "po_no" => $po_no,
            "supplier_name" => $supplier_name,
            "order_type" => $order_type,
            "supplier_code" => $supplier_code,
            "grn_no" => $grn_no,
            "dc_no" => $dc_no,
            "dc_date" => $dc_date,
            "bill_no" => $bill_no,
            "bill_date" => $bill_date,
            "product_name" => $product_name,
            "generic_name" => $generic_name,
            "manf_date" => $manf_date,          
            "unit_price" => $unit_price,
            "box_price" => $box_price,
            "purchase" => $purchase,
           
            
         );
         $save_grn = $this->purchase_model->update_grn($grn_no,$data); 
          

      $data2 = array(
        "grn_no" => $grn_no,
        "product_id" => $product_id,
        "Batch_Number" => $batch_array[$i],
        "instock" => $instock_array[$i],
        "expire_date" => $expire_date_array[$i]
     );
   
      $i++;

       
       $save_grn = $this->purchase_model->save_grn_meta($data2);
    }
   }

   public function delete_sub_grn()
   {
    $id = $this->input->post('id');
    $delete_sub_grn = $this->purchase_model->delete_sub_grn($id);  
   }

   public function edit_append_medicine()
   {
    $id = $this->input->post('grn_id');
    $get_medicine_detail = $this->purchase_model->append_edit_medicine_detail($id);
    // echo "<pre>";
    // print_r($get_medicine_detail);

      $batch =   $get_medicine_detail[0]->Batch_Number;
      $instock =   $get_medicine_detail[0]->instock;
      $expire_date =   $get_medicine_detail[0]->expire_date;
      $id = $get_medicine_detail[0]->idd;

        $output  = '<tr>';
        $output .= '<td>' . $get_medicine_detail[0]->product_name . '</td>';
        $output .= '<td>' . $get_medicine_detail[0]->product_id . '</td>';
        $output .= '<td>' . $get_medicine_detail[0]->generic_name . '</td>';
        $output .= "<td><input type='text' name='batch_array[]' value='$batch'></td>";
        $output .= '<td>' . $get_medicine_detail[0]->manf_date . '</td>';
        $output .= '<td>' . $get_medicine_detail[0]->sale_qty . '</td>';
        $output .= "<td><input type='text' name='instock_array[]' value='$instock'></td>";
        $output .= '<td>' . $get_medicine_detail[0]->unit_price . '</td>';
        $output .= '<td>' . $get_medicine_detail[0]->Batch_Number . '</td>';
        $output .= "<td><input type='text' name='expire_date_array[]' value='$expire_date'></td>";
        $output .= "<input type='hidden' name='id_array[]' value='$id'>";
        $output .= '<td>' . $get_medicine_detail[0]->box_price . '</td>';
        $output .= '<td>' . $get_medicine_detail[0]->purchase . '</td>';
        $output .= "<td id='$id'><input class='append-checkbox' type='checkbox'   value='$id' id='appended_check'></td>";
        $output .= "<td id='$id'><input type='button' data-id='$id' value='$id' id='delete_btn'>";
        $output .= '</tr>';
        echo ($output);

   }

   public function manufacturer()
   {
    $manufacturer =  $this->purchase_model->manufacturer();
    echo json_encode($manufacturer);
   }

   public function get_medicine()
   {
    $get_medicine =  $this->purchase_model->get_medicine();
    echo json_encode($get_medicine);
   }

   public function abc()
   {
       $pro_id = $this->input->post('pro_id');
       $get_med_his =  $this->purchase_model->get_med_his($pro_id);
       $html = '';
       foreach($get_med_his as $val)
       {
           
           $html .= '<div class="row pos-remove-spacing">
               <div class="col-md-3" style="">
                   <div class="input-group">
                       <input type="text" class="form-control" name="batch[]" id="batch" tabindex="2" value ="'.$val->Batch_Number.'" autocomplete="off">
                   </div>
               </div>
               <div class="col-md-2">
                   <div class="form-group">
                       <input type="text" class="form-control" name="exp_date" id="exp_date" value="'.$val->expire_date.'" autocomplete="off">
                   </div>
               </div>
               <div class="col-md-2">
                   <div class="form-group genric-left-sug">
                       <input type="text" class="form-control" name="stock" id="stock" value="'.$val->instock.'"  autocomplete="off">
                   </div>
               </div>
           </div>';
       }
       
       echo $html;
   }
    public function permissionsbyemrole(){
        $id = $_SESSION['user_type'];
        $permission = $this->user_model->getAllpermissionsbyemid($id);  
        return $permissions1 = $permission[0]->permissions;
    }
    public function get_lastid(){
    
        return $lastid = $this->purchase_model->getlastinsertedID();
    }
    public function getformbyid($id)
    {
    return  $data = $this->medicine_model->getformbyid($id);
    }
    public function gettitlebyform($id)
    {
    return  $data = $this->medicine_model->getAllunitsFormID2($id);
    }
    public function GetHsnDetailsById1($id)
    {
    return  $data = $this->Hsn_model->GetHsnDetailsById($id);
    }
   public function get_med_his()
   {
    $pro_id = $this->input->post('pro_id');
    $get_med_his =  $this->purchase_model->get_med_his($pro_id);
    $medForm = $this->purchase_model->check_med_form($pro_id);
    $select_unit =  $this->purchase_model->select_unitformbyId($medForm[0]->form);
    $options = ''; // Initialize an empty string for options
    
    foreach($select_unit as $val) {
   
        $options .= '<option value="'.$val->qnty.'">' . $val->unit . '</option>'; // Append each option
    }
   
    foreach($get_med_his as $val)
    {
        if(strtotime($val->expire_date) >= strtotime(date('Y-m-d')) ){

            echo  '<div class="row pos-remove-spacing">
            <div class="col-md-2" style="">
            <div class="input-group">
            <input type="text" class="form-control" name="pro_id"  id="pro_id" tabindex="2" value ="'.$pro_id.'">
            <input type="hidden" class="form-control" name="supplier_id[]"  id="supplier_id" tabindex="2" value ="'.$val->supplier_id.'" autocomplete="off">
            <input type="text" class="form-control" name="mrp"  id="mrp" tabindex="2" value ="'.$val->mrp.'" autocomplete="off">
            <input type="text" class="form-control" name="batch[]"  id="batch" tabindex="2" value ="'.$val->Batch_Number.'" autocomplete="off">
            </div>
            </div>
            <div class="col-md-2">
            <div class="form-group">
                <input type="text" class="form-control" name="exp_date" id="exp_date" value="'.$val->expire_date.'" autocomplete="off">
            </div>
            </div>
            <div class="col-md-2">
            <div class="form-group genric-left-sug">
                <input type="text" class="form-control" name="stock" id="stock" value="'.$val->instock.'"  autocomplete="off">
            </div>
            </div>
            <div class="col-md-2">
        <div class="form-group">
        <select class="form-group form-control" id = "unit" name= "units">
        <option value="">Select the option</option>' . $options . '
      
        </select>
        
        </div>
        <span id="select_error"></span>
        </div>
            <div class="col-md-2">
            <div class="form-group">
            <input type="text" class="form-control req_qty" date-id="" name="qty" id="req_qty" placeholder="Qty" autocomplete="off">
            </div>
            </div>
            <div class="col-md-2">
            <div class="form-group">
            <button class="btn btn-info" data-id="'.$val->Batch_Number.'" id="add_pos55">Add</button>
            </div>
            </div>
            
            
             </div>';


        }else{
   
   }
}
}

public function get_med_his55()
{
 $pro_id = $this->input->post('pro_id');
 $get_med_his =  $this->purchase_model->get_med_his($pro_id);
 $medForm = $this->purchase_model->check_med_form($pro_id);
 $select_unit =  $this->purchase_model->select_unitformbyId($medForm[0]->form);
 $options = ''; // Initialize an empty string for options
 
 foreach($select_unit as $val) {

    $options .= '<option ' . ($val->qnty == 1 ? 'selected' : '') . ' value="' . $val->qnty . '">' . $val->unit . '</option>';     // Append each option
     

 }

 foreach($get_med_his as $val) {
    if(strtotime($val->expire_date) >= strtotime(date('Y-m-d')) ) {
        // If the medicine is not expired
        echo  '<div class="row pos-remove-spacing">
        <div class="col-md-2" style="">
        <div class="input-group">
        <input type="text" class="form-control" name="pro_id"  id="pro_id" tabindex="2" value ="'.$pro_id.'">
        <input type="hidden" class="form-control" name="supplier_id[]"  id="supplier_id" tabindex="2" value ="'.$val->supplier_id.'" autocomplete="off">
        <input type="text" class="form-control" name="mrp"  id="mrp" tabindex="2" value ="'.$val->mrp.'" autocomplete="off">
        <input type="text" class="form-control" name="batch[]"  id="batch" tabindex="2" value ="'.$val->Batch_Number.'" autocomplete="off">
        </div>
        </div>
        <div class="col-md-2">
        <div class="form-group">
            <input type="text" class="form-control" name="exp_date" id="exp_date" value="'.$val->expire_date.'" autocomplete="off">
        </div>
        </div>
        <div class="col-md-2">
        <div class="form-group genric-left-sug">
            <input type="text" class="form-control" name="stock" id="stock" value="'.$val->instock.'"  autocomplete="off">
        </div>
        </div>
        <div class="col-md-2">
        <div class="form-group">
        <select class="form-group form-control" id = "unit" name= "units">
        <option value="">Select the option</option>' . $options . '
      
        </select>
        
        </div>
        <span id="select_error"></span>
        </div>
       
        <div class="col-md-2">
        <div class="form-group">
        <input max="'.$val->instock.'" type="number" class="form-control req_qty" date-id="" name="qty" id="req_qty" placeholder="Qty" autocomplete="off">
        </div>
        </div>
        <div class="col-md-2">
        <div class="form-group">
        <button class="btn btn-info" data-id="'.$val->Batch_Number.'" id="add_pos55">Add</button>
        </div>
        </div>
        
        
         </div>';
    } else {
        // If the medicine is expired (empty block)
    }
}

}

    public function view_grn()
    {
        if($this->session->userdata('user_login_access') != False) {
        $grn_no = $this->uri->segment(3);
        $data['grn'] = $this->supplier_model->get_grn_data($grn_no);
        $this->load->view('backend/view_grn', $data);  
    }
    else{
        redirect(base_url() , 'refresh');
    }
    }
    
   
}


