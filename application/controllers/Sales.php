<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Sales extends CI_Controller {



	    function __construct() {

        parent::__construct();

        $this->load->database();

        $this->load->model('login_model');

        $this->load->model('user_model');

        $this->load->model('medicine_model');
        $this->load->model('customer_model');
        $this->load->model('supplier_model');
        $this->load->model('sales_model');
        $this->load->model('purchase_model');
        $this->load->model('configuration_model');
        $this->load->model('Store_model');
        $this->load->model('invoice_model');

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



   public function Today_report(){
       if($this->session->userdata('user_login_access') != False) {
        $per = $this->permissionsbyemrole();
        $permissions = explode(',', $per);
       if (in_array(57, $permissions)) {
        date_default_timezone_set("Asia/Kolkata");   
       $today = date('d/m/Y');
       $date = strtotime($today);
        $data['todaysreport'] = $this->sales_model->getTodaysSale($today);
        $data['todaysreportwithdue'] = $this->sales_model->getTodaysSalewithdue($today);
        $data['purchasereport'] = $this->sales_model->getTodaysPurchase($today);
        $this->load->view('backend/today_sale',$data);
    }
    else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
        }
    else{
		redirect(base_url() , 'refresh');
	}          

    } 
    public function permissionsbyemrole(){
        $id = $_SESSION['user_type'];
        $permission = $this->user_model->getAllpermissionsbyemid($id);  
        return $permissions1 = $permission[0]->permissions;
    }

   public function Today_counter_report(){
       if($this->session->userdata('user_login_access') != False) {
       $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                if (in_array(57, $permissions)) { 
        date_default_timezone_set("Asia/Kolkata");   
      // $today = date('Y-m-d');
       $today = date('Y-m-d');
      // 2024-03-14
       $date = strtotime($today);
        $counter = $this->session->userdata('store_id');
        $data['todaysreport'] = $this->sales_model->getTodaysSaleByCounter($today,$counter);
        $this->load->view('backend/today_sale_counter',$data);
         }
            else {
                redirect(base_url().'Sales/auth_error', 'refresh');
            }
        }
    else{
		redirect(base_url() , 'refresh');
	}          

    } 

   public function Sales_report(){
       if($this->session->userdata('user_login_access') != False) {
        $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
        if (in_array(58, $permissions)) { 
        $start = $this->input->get('from', TRUE);
        $end = $this->input->get('to', TRUE);
        if($start != '' && $end !=''){

            $checkin = strtotime($start);
            $start5 = date('d/m/Y', $checkin);
           $END5 = strtotime($end);
           $END5 = date('d/m/Y', $END5);
           $invoice_details = $this->sales_model->getByInvoiceFromToEnd($start5,$END5);

   
        $data['start5'] = $start5;
        $data['END5'] = $END5; 
        $data['invoice_details'] = $invoice_details; 

        $this->load->view('backend/sales_report',$data);
        }
        else {

        $data['salesreport'] = $this->sales_model->getSalesReport();      
        $this->load->view('backend/sales_report',$data);

        }
    }
    else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }

        }
    else{
		redirect(base_url() , 'refresh');
	}           
    } 

    public function item_comsumtion(){
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
            if (in_array(59, $permissions)) {
         $start = $this->input->get('from', TRUE);
         $end = $this->input->get('to', TRUE);
 
         
            
 
         //die;
 
         if($start != '' && $end !=''){
 
             $checkin = strtotime($start);
             $start5 = date('d/m/Y', $checkin);
             
 
            
            $END5 = strtotime($end);
            $END5 = date('d/m/Y', $END5);
            $invoice_details = $this->sales_model->getByInvoiceFromToEnd($start5,$END5);
 
            //print_r($invoice_details);
 
 
 
         $data['start5'] = $start5;
         $data['END5'] = $END5; 
         $data['invoice_details'] = $invoice_details; 
 
         $this->load->view('backend/sales_report',$data);
         }
         else {
 
         $data['salesreport'] = $this->sales_model->getSalesReport();      
         $this->load->view('backend/item_consumption',$data);
 
         }
 
        }
        else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
    
         }
     else{
         redirect(base_url() , 'refresh');
     }           
     } 
   public function Purchase_report(){
       if($this->session->userdata('user_login_access') != False) {
        $per = $this->permissionsbyemrole();
        $permissions = explode(',', $per);
                   if (in_array(61, $permissions)) {
        $data['purchasereport'] = $this->sales_model->getPurchaseReport();
    
        $this->load->view('backend/purchase_report',$data);
    } else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
        }

    else{
		redirect(base_url() , 'refresh');
	}       
    }  

    public function Closing_Stock_report(){
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
                       if (in_array(63, $permissions)) {
         $data['closereport'] = $this->sales_model->getClosingstockReport();
         $this->load->view('backend/closing_stockreport', $data);
        } else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
         }
     else{
         redirect(base_url() , 'refresh');
     }           
     } 

     public function Current_Stock_report(){
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
                       if (in_array(64, $permissions)) {
         $data['closereport'] = $this->sales_model->getClosingstockReport();
         $this->load->view('backend/current_stock_report', $data);
        } else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
         }
     else{
         redirect(base_url() , 'refresh');
     }           
     } 

   public function Purchase_Return(){
       if($this->session->userdata('user_login_access') != False) {
        $per = $this->permissionsbyemrole();
        $permissions = explode(',', $per);
                   if (in_array(67, $permissions)) {
        $this->load->view('backend/purchase_return');
    } else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
        }

    else{
		redirect(base_url() , 'refresh');
	}       
    } 

   public function Sales_Return(){
       if($this->session->userdata('user_login_access') != False) {
        $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
        if (in_array(91, $permissions)) {
        
        $data['salesreport'] = $this->sales_model->getSalesReport();
        $this->load->view('backend/sales_return',$data);
    } else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
} 
       
    else{
		redirect(base_url() , 'refresh');
	}           
}

   public function Sales_Return_Report(){
       if($this->session->userdata('user_login_access') != False) {
        $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
            if (in_array(60, $permissions)) {
        $this->load->view('backend/sale_returnreport');
    } else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
       }
    else{
		redirect(base_url() , 'refresh');
	}           
    } 
 
    public function Sales_R_History() {
        if($this->session->userdata('user_login_access') != False) {
            $ID = base64_decode($this->input->get('H'));
            $data['returndetails'] = $this->sales_model->SalesReturnDetails($ID);
            $this->load->view('backend/sales_return_details', $data);
        }
        else{
            redirect(base_url() , 'refresh');
        } 
    }
 
    public function Purchase_R_History() {
        if($this->session->userdata('user_login_access') != False) {
            $ID = base64_decode($this->input->get('H'));
            $data['returndetails'] = $this->sales_model->PurchaseReturnDetails($ID);
            $this->load->view('backend/purchase_return_details', $data);
        }
        else{
            redirect(base_url() , 'refresh');
        } 
    }
   public function SalesReturn(){
    if($this->session->userdata('user_login_access') != False) {   
    $sid = base64_decode($this->input->get('S'));
    $data['salesreport'] = $this->sales_model->getsalesSpecificData($sid);
    $data['allSales'] = $this->sales_model->getSalesDetailsForInvoice($sid);
    $this->load->view('backend/invoice_return',$data);
       }
    else{
		redirect(base_url() , 'refresh');
	}         
    } 

   public function Purchase_Return_Invoice(){
       if($this->session->userdata('user_login_access') != False) {  
       $invoice = $this->input->post('pinvoice');
      $purchasereport = $this->sales_model->getPurchaseReportForReturn($invoice);
        if(!empty($purchasereport)){
            echo $invoice;
       }else{
           
       }
       }
    else{
		redirect(base_url() , 'refresh');
	}           
    } 
    public function sales_report_details() {
        if($this->session->userdata('user_login_access') != False) {
            $invoiceID = $this->input->get('id');
            $data['invoice_details'] = $this->sales_model->getByInvoice($invoiceID);
            $this->load->view('backend/invoice_report', $data);
        }
        else{
            redirect(base_url() , 'refresh');
        } 
    }
    public function auth_error() {
        if($this->session->userdata('user_login_access') != False) {
           
            $this->load->view('backend/auth_error');
        }
        else{
            redirect(base_url() , 'refresh');
        } 
    }
    
    public function sales_report_invoicedetails() {
        if($this->session->userdata('user_login_access') != False) {
            $invoiceID = $this->input->get('id');
            $data['invoice_details'] = $this->sales_model->getByInvoiceFromsalesforprofit($invoiceID);
            $this->load->view('backend/invoice_profit', $data);
        }
        else{
            redirect(base_url() , 'refresh');
        } 
    }

   public function Purchase_Return_report(){
       if($this->session->userdata('user_login_access') != False) {
        $per = $this->permissionsbyemrole();
                 $permissions = explode(',', $per);
                            if (in_array(62, $permissions)) {
       //$data['purchasereturnreport'] = $this->sales_model->getPurchaseReturnReport();
        $this->load->view('backend/purchase_returnreport');
    } else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
        }
        else{
            redirect(base_url() , 'refresh');
        }           
    }
   public function Counter_report(){
       if($this->session->userdata('user_login_access') != False) {
       //$data['counter'] = $this->sales_model->Getcounter();
        $this->load->view('backend/counter_report');
        }
        else{
            redirect(base_url() , 'refresh');
        }           
    } 
    /*Purchase Return*/
   public function Return_Confirm(){
        $purid      =   $this->input->post('purid');
        $rid      =   'R'.rand(100000,500000);
        $supplier   =   $this->input->post('sid');
        $invoice    =   $this->input->post('invoice');
        $entrydate  =   date('m-d-Y');
        $batchNo =  $this->input->post('batchno');
        /*$tdiscount  =   round($this->input->post('tdiscount'));*/
        $grandamount =  round($this->input->post('grandamount'));
        $this->load->library('form_validation');
                $data = array();
                $data = array(
                    'r_id' => $rid,
                    'pur_id' => $purid,
                    'sid' => $supplier,
                    'invoice_no' => $invoice,
                    'return_date' => $entrydate,
                    'total_deduction' => $grandamount
                ); 
            $success = $this->purchase_model->Save_Purchase_return($data);
            if($this->db->affected_rows()){
                $purinfo = $this->purchase_model->GePurchaseDetAILSSs($purid);
                $total = $purinfo->gtotal_amount - $grandamount; 
                $data = array();
                $data = array(
                    'gtotal_amount' => $total,
                );
                $success = $this->purchase_model->update_P_balance($purid,$data);                
                foreach($_POST['rqty'] as $row=>$name){
                    if(!empty($_POST['rqty'][$row])){
                $medicine   =   $_POST['mid'][$row];
                $rqty        =   $_POST['rqty'][$row];
                $total      =   $_POST['total'][$row];                   
                    $data = array(
                        'r_id'   =>  $rid,
                        'pur_id'   =>  $purid,
                        'mid'      =>  $medicine,
                        'supp_id'      =>$supplier,
                        'return_qty'      => $rqty,
                        'deduction_amount'   =>  $total
                    );
                $success = $this->purchase_model->Save_Purchase_Retun_History($data);
                    }
                }                 
                foreach($_POST['rqty'] as $row=>$name){
                    if(!empty($_POST['rqty'][$row])){
                $medicine   =   $_POST['mid'][$row];
                $batchNo    =   $_POST['batchno'][$row];
                $rqty        =   $_POST['rqty'][$row];
                $total      =   $_POST['total'][$row];
                $ph      =   $_POST['ph'][$row];
                $purinfo = $this->purchase_model->GePurchaseHISDetAILSSs($ph);
                $qty = $purinfo->qty - $rqty;        
                $b = $purinfo->total_amount - $total;  

               $get_pre_stock = $this->purchase_model->get_pre_stock($medicine,$batchNo, $supplier);
               $return_qty = $get_pre_stock[0]->return_qnty + $rqty;
               


                    $data = array(
                        'return_qnty'      => $return_qty,
                        'total_amount'   => $b
                    );
                $success = $this->purchase_model->Update_Purchase_History_Details($ph,$data);
                    }
                }                
                foreach($_POST['rqty'] as $row=>$name){

                if(!empty($_POST['rqty'][$row])){

                $medicine   =   $_POST['mid'][$row];
                $batchNo    =   $_POST['batchno'][$row];
                $rqty        =   $_POST['rqty'][$row];
                $qty        =   $_POST['pqty'][$row];
                $total      =   $_POST['total'][$row];
                

                
                //$medicinestock = $this->purchase_model->getMedicineStock($medicine);
                //$instock = $medicinestock->instock + $qty;
                $medicinestock = $this->purchase_model->getmedicineByMId($medicine);
                $instock = $medicinestock->instock - $rqty;
                    $data = array(
                        'instock'      =>  $instock,
                    );
                $success = $this->purchase_model->Update_Medicine($medicine,$data);

                
                

                $medicinestock = $this->purchase_model->getmedicineByMIdSidBtch($medicine,$supplier,$batchNo);
                    
                $instock = $medicinestock->instock;   
                $instock = ($instock - $rqty);
               
               $data = array(
                'instock'      =>  $instock,
            );

                $success1 = $this->purchase_model->Update_Medicine_Mata($medicine,$data,$supplier,$batchNo);

                
                $settings   = $this->configuration_model->getAllSettings();
                $storemedicine = $this->purchase_model->getmedicineByMIdSidBtchstore($medicine,$supplier,$batchNo,$settings->main_store_id);
                $instock = $storemedicine->instock;
                $instock = ($instock - $rqty);
                
                $data = array(
                    'instock'      =>  $instock,
                );

                
                $success2 = $this->purchase_model->Update_Store_Mata2($medicine,$supplier,$batchNo,$data,$settings->main_store_id);


                }
                   
                }

           redirect("sales/Purchase_Return");
            }        
    }

    public function test(){

        $data =  $this->medicine_model->getAllMedicineid();
        $key = array();  
        $value = array();     
        foreach($data as $unitid) {               
           //echo ".$unitid->product_id.":".$unitid->product_name";

           array_push($key,$unitid->product_id);
           array_push($value,$unitid->product_name);

    }
    echo json_encode(array_combine($value,$key));

    //     $unit =  $this->medicine_model->GetunitBynum(1);
    //     print_r($unit);
    //     echo $unit->unit;
    //     phpinfo();
    //     $medicine = 'P35188';
        
        
    //     $storeID = '79';                                                                                                                                    
    //     $qty = '101';


    //     $Allmeds = $this->medicine_model->GetMedbystore($medicine,$storeID);
        
    //     $dueMed = $qty;
    //     foreach($Allmeds as $med){
            

    //     if($dueMed != 0){
            

    //         if($med->instock >= $dueMed ){

    //             echo "Yes";
    //             $dueMed = 0;
    //         }else{
    //            echo "No";
    //            $medmrp = $this->medicine_model->Getmedmrpbyid($med->id);
               
    //            $mrp = isset($medmrp[0]->mrp) ? $medmrp[0]->mrp : 0;
    //            $supplier_id  = isset($medmrp[0]->supplier_id) ? $medmrp[0]->supplier_id : 0;
    //                 $batch_no  = isset($medmrp[0]->Batch_Number) ? $medmrp[0]->Batch_Number : 0;
    //                 $exp_date   = isset($medmrp[0]->expire_date) ? $medmrp[0]->expire_date : '0000-00-00';
               

    //            // Update  store_medicine_meta

    //            $chk_med_store_stock = $this->purchase_model->chk_med_store_stock($medicine, $supplier_id, $batch_no, $storeID, $exp_date);
    //            $pre = $chk_med_store_stock[0]->instock;
    //            $sold_stock = $chk_med_store_stock[0]->sale_qty;

    //            $new = $pre - $dueMed;
    //            $qty_sold =  $dueMed;
    //            $data = array(
    //                "instock" => 0,
    //                'sale_qty' => $sold_stock + $pre

    //            ); 
    //            echo $dueMed = $dueMed - $med->instock;
    //            print_r($data);
    //         }

    //     }else{

    //         break;
    //     }
    //    echo $dueMed;

    //     }
    //     die;
       // $medicinestock = $this->configuration_model->getAllSettings();
        //print_r($medicinestock);

        //echo $medicinestock->main_store_id;

        // $medicinestock = $this->purchase_model->getmedicineByMIdSidBtch($medicine,$supplier,$batchNo);
       
        //         echo $instock = $medicinestock->instock;// - $rqty;
        //         echo "-".$rqty;
        //        //$instock = $medicinestock - $rqty;
               
        //        echo $instock = ($instock - $rqty);

        //        $data = array(
        //         'instock'      =>  $instock,
        //     );

               //$success1 = $this->purchase_model->Update_Medicine_Mata($medicine,$data,$supplier,$batchNo);

    }
    /*Sales Return*/
   public function Sales_Return_Form(){
        $sid      =   $this->input->post('s_id');
        $cid      =   $this->input->post('customer_id');
        $rid      =   'SR'.rand(100000,5000000);
        $invoice  = rand(100000,5000000);
       date_default_timezone_set("Asia/Kolkata");
        $entrydate  =   date('m-d-Y');
        /*$tdiscount  =   round($this->input->post('tdiscount'));*/
        $grandamount =  $this->input->post('grandamount');//round($this->input->post('grandamount'));
        $returntotal =  $this->input->post('returntotal');//round($this->input->post('returntotal'));
        $tax = $returntotal - $grandamount;
        $totalamt = $grandamount + $tax;
        $granddeduction =  round($this->input->post('granddeduction'));
        $userid = $this->session->userdata('user_login_id');
        $storeid = $this->session->userdata('store_id');
        if($this->session->userdata('cnumber')){
            $type = $this->session->userdata('cnumber');
        } else {
             $type = $this->session->userdata('em_type');
        }
        $this->load->library('form_validation');
                $data = array();
                $data = array(
                    'sr_id' => $rid,
                    'cus_id' => $cid,
                    'sale_id' => $sid,
                    'invoice_no' => $invoice,
                    'return_date' => $entrydate,
                    'total_deduction' => $granddeduction,
                    'total_amount' => $grandamount,
                    'entry_id' => $userid,
                    'counter' => $type,
                    'tax' => $tax,
                    'store_id' => $storeid

                ); 
            $success = $this->sales_model->Sales_Return_Form($data);
            if($this->db->affected_rows()){               
                foreach($_POST['rqty'] as $row=>$name){
                    if(!empty($_POST['rqty'][$row])){
                $medicine   =   $_POST['mid'][$row];
                $rqty        =   $_POST['rqty'][$row];
                $total      =   $_POST['total'][$row];                   
                $deduction      =   $_POST['deduction'][$row];                   
                    $data = array(
                        'sr_id'   =>  $rid,
                        'mid'   =>  $medicine,
                        'r_qty'   =>  $rqty,
                        'r_total'   =>$total,
                        'r_deduction'  => $deduction,
                        'date'   =>  $entrydate
                    );
                $success = $this->sales_model->Save_Sales_Retun_History($data);
                    }
                }                                
                foreach($_POST['rqty'] as $row=>$name){
                if(!empty($_POST['rqty'][$row])){
                $medicine   =   $_POST['mid'][$row];
                $rqty        =   $_POST['rqty'][$row];
                $supplier_id        =   $_POST['supplier_id'][$row];
                $batch        =   $_POST['batch'][$row];
                


                $medicinestock = $this->purchase_model->getmedicineByMId($medicine);
                $instock = $medicinestock->instock + $rqty;
                    $data = array(
                        'instock'      =>  $instock,
                    );
                $success = $this->purchase_model->Update_Medicine($medicine,$data);

                $settings   = $this->configuration_model->getAllSettings();
                $storeID =  $this->session->userdata('store_id');
                $medicinestockAdmin = $this->purchase_model->getmedicineByMIdAdmin($medicine,$storeID, $supplier_id, $batch);

                $instockAdmin = $medicinestockAdmin->instock + $rqty;
                $saleStockAdmin = $medicinestockAdmin->sale_qty - $rqty;
                
                    $data = array(
                        'instock'      =>  $instockAdmin,
                        'sale_qty'      =>  $saleStockAdmin
                    );

                $successAdmin = $this->purchase_model->Update_MedicineAdminStore($medicine,$data,$storeID, $supplier_id, $batch);
               







                //update store med meta
                $check_meta_stock = $this->purchase_model->check_meta_stock($medicine, $supplier_id, $batch);
                // print_r($check_meta_stock[0]->instock);
                $data = array(
                    "instock" =>$check_meta_stock[0]->instock + $rqty,
                    'sale_qty'      =>  $check_meta_stock[0]->sale_qty - $rqty
                );

                $Update_Medicine_meta = $this->purchase_model->Update_Medicine_meta($medicine, $supplier_id, $batch, $data);
              

                }
                   
                }
                    $response['status'] = 'success';
                    $response['message'] = "Successfully Created";
                    $response['curl'] = base_url(). "Sales/SalesReturn?S=".base64_encode($sid);
                    $this->output->set_output(json_encode($response));
            }        
    }
    public function GETSALESrePort(){
       if($this->session->userdata('user_login_access') != False) { 
           $start = $this->input->post('start');
          // print_r($start);
           $checkin = strtotime($start);
           $start5 = date('d/m/Y', $checkin);
            

           $end = $this->input->post('end');
           $END5 = strtotime($end);
           $END5 = date('d/m/Y', $END5);
           $settings   = $this->configuration_model->getAllSettings();
           $mainid = $settings->main_store_id;
           $invoice_details = $this->sales_model->getByInvoiceFromToEnd($start5,$END5);
        //    print_r($invoice_details);
                                   $total_sale = 0;
                                   $tot_paid = 0;
                                   $tot_due = 0;
                                      $medicine_quantities = array();
                                      
                                            foreach($invoice_details as $value):
                                                //print_r($value);
                                                // echo "<pre>";
                                                $dis = ($value->gdiscount);
                                               
                                                $get_cus_name = $this->purchase_model->get_cus_name($value->c_id);
                                                $cus = $get_cus_name[0]->c_name;


                                                $get_medicine_name = $this->purchase_model->get_medicine_name($value->mid);
                                                $med_name = ($get_medicine_name[0]->product_name);
                                                $generic_name = $get_medicine_name[0]->generic_name;
                                                $form = $get_medicine_name[0]->form;
                                                // $get_mrp = $this->purchase_model->get_mrp($value->mid);
                                                $get_mrp = $this->purchase_model->get_mrpSaleReport($value->mid,$value->Batch_Number);
                                                   
                                               

                                               $hsn = ($get_medicine_name[0]->hsn);
                                               $get_gst = $this->purchase_model->get_gst($hsn);
                                               $igst = $get_gst[0]->igst;

                                              $val =  $get_mrp[0]->mrp * $value->qty;
                                              $tax = ($val * $igst)/100; 
                                              $amt = ($val + $tax) - $dis;
                                              
                                              
                                              $CI     = & get_instance();
                                              $result = $CI->getformbyid($form);
                                              if($result){
                                              $title = $result[0]->title;
                                              }
                                              else{
                                                  $title = ' ';
                                              }

                                                $create =  $value->create_date;
                                                $dateObj = date_create_from_format('d/m/Y',$create);
                                                $datae = date_format($dateObj,'d/m/Y');
                                                
                                                $IncludeTax = $value->total_price + $tax;
                                                $total_sale += $value->total_amount;  //include tax is removed 
                                                $tot_paid += $value->paid_amount;
                                                $tot_due += $value->due_amount;
                                                $totamt = round($value->total_amount, 2);
                                                $totpaid = round($value->paid_amount, 2);
                                                $totdue = round($value->due_amount, 2);
                                            
                                          
                                            echo"<tr>
                                               <td>$value->create_date</td>
                                               <td><a href='Invoice_Historysales?H=$value->sale_id' target='_blank'>$value->invoice_no</a></td>
                                               <td>$cus</td>                                              
                                               <td>$totamt</td>    
                                               <td>$totpaid</td>
                                               <td>$totdue</td>
                                               <td>$value->note</td>
                                              
                                           </tr>";
                                        
                                       
                                             endforeach;
                                             echo "<tr>
                                               <td></td>
                                               <td></td>
                                               <td><b> Grand Total </b></td>
                                               <td><b>  $total_sale </b></td>
                                               <td><b>  $tot_paid </b></td>
                                               <td><b>  $tot_due </b></td>
                                               <td></td>
                                           </tr>";

                                              
                                           
    }        
    else{
        redirect(base_url() , 'refresh');
    }
    }

    public function get_item_con(){
        if($this->session->userdata('user_login_access') != False) { 
            $start = $this->input->post('start');
           // print_r($start);
            $checkin = strtotime($start);
            $start5 = date('d/m/Y', $checkin);
             
 
            $end = $this->input->post('end');
            $END5 = strtotime($end);
            $END5 = date('d/m/Y', $END5);
            $settings   = $this->configuration_model->getAllSettings();
            $mainid = $settings->main_store_id;
            $invoice_details = $this->sales_model->get_item_con($start5,$END5,$mainid);
         //    print_r($invoice_details);
         $medicine_quantities = array();
                                             foreach($invoice_details as $value):
 
                                                //  print_r($value);
                                                
                                                //  $get_cus_name = $this->purchase_model->get_cus_name($value->c_id);
                                                //  $cus = $get_cus_name[0]->c_name;
 
 
                                                 $get_medicine_name = $this->purchase_model->get_medicine_name($value->mid);
                                                 $med_name = ($get_medicine_name[0]->product_name);
                                                 $generic_name = $get_medicine_name[0]->generic_name;
                                                 $form = $get_medicine_name[0]->form;
                                                 // $cus_id = $get_medicine_name[0]->cus_id;
 
                                                 $create =  $value->create_date;
                                                 $dateObj = date_create_from_format('d/m/Y',$create);
                                                 $datae = date_format($dateObj,'d/m/Y');
                                                 
                                                 $CI     = & get_instance();
                                              $result = $CI->getformbyid($form);
                                              if($result){
                                              $title = $result[0]->title;
                                              }
                                              else{
                                                  $title = ' ';
                                              }
                                                
                                                 
                                             
                                           
                                             echo"<tr>
                                              
                                                <td>$value->mid</td>
                                                <td>$med_name</td>
                                                <td>$generic_name</td>
                                                <td>$title</td>
                                              
                                                <td>$value->qty </td>
                                            </tr>";
                                        
                                              endforeach;
     }        
     else{
         redirect(base_url() , 'refresh');
     }
     }
    public function GETSALESrePortBycounter(){
       if($this->session->userdata('user_login_access') != False) { 
           $start = strtotime($this->input->post('start'));
            $start55 = date('d/m/Y', $start);           
           $end = strtotime($this->input->post('end'));
           $end55 = date('d/m/Y', $end); 
         
           $invoice_details = $this->sales_model->getByInvoiceFromToEndByCounter($start55,$end55);
                                            foreach($invoice_details as $value):
                                           $create=  $value->create_date;
                                            echo"<tr>
                                                <td> $create </td>
                                                <td><a href='sales_report_details?id=$value->invoice_no'> $value->invoice_no</a></td>
                                                <td>$value->c_name</td>
                                                <td>
                                                      $value->total_amount 
                                                </td>
                                                <td>
                                                      $value->counter
                                                </td>
                                                <td>
                                                      $value->em_name
                                                </td>
                                            </tr>";
                                            endforeach;
    }        
    else{
        redirect(base_url() , 'refresh');
    }
    }
    public function GetSalesInvoiceReport(){
        $id = $this->input->get('id');
        $settings   = $this->configuration_model->getAllSettings();
        $invoice = $this->sales_model->getSalesReportForInvoice($id);
        $invoice_details = $this->sales_model->getSalesDetailsForInvoice($id);
        $createdate = $invoice->create_date;
        $createtime = $invoice->sales_time;
        $customer = $invoice->c_name;
        $invoiceno = $invoice->invoice_no;
        $drName = $invoice->doctor_name;
        $customerphone = $this->customer_model->getAllCustomerinvoice($customer);
        $phone = $customerphone[0]->cus_contact;
        
        $cusid = $customerphone[0]->c_id;
        $tax = 0;
        $discount = $invoice->total_discount;
        $cTime = $createtime;//date("d-m-Y h:i:sa",$createtime);
echo " <div id='printa'><div class='card-body pos_receipt'>
        <div class='receipt_header'>
          <div class='row'>
          <div class='col-md-12'>
          <p class='company-info' style='padding-bottom:5px;margin-top:-10px;'>
            <span style='text-align:center;'><img src='".base_url('assets/images/'.$settings->sitelogo)."' class='img-responsive text-center' style='width:120px;height:auto;'></span>
            
            <span style='text-align:center;font-size: 12px;font-weight: 600;color: #000;line-height:15px;'> $settings->address</span>
            <span style='text-align:center;font-size: 13px;font-weight: 600;color: #000;line-height:15px;margin-bottom:5px;padding-bottom:5px;'>Contact: $settings->contact</span>
             <span style='text-align:center;font-size: 13px;font-weight: 600;color: #000;line-height:15px;margin-bottom:5px;padding-bottom:5px;border-bottom:1px dashed;'>GST: $settings->gst</span>
            <span style='float:left;font-size: 13px;font-weight: 600;color: #000;line-height:15px;'>$cTime</span><span style='float:right;font-size: 13px;font-weight: 600;color: #000'>$createdate</span>
          </p>
          </div>
          <div class='col-md-12'>
          <p class='customer-details;margin-bottom:5px;'>
            <span style='font-size: 12px;font-weight: 600;color: #000'>Name: $customer</span>
            <span style='font-size: 12px;font-weight: 600;color: #000'>ID: $cusid</span>
            <span style='font-size: 12px;font-weight: 600;color: #000'>Invoice: $invoiceno</span>
            <span style='font-size: 12px;font-weight: 600;color: #000'>Phone Number: $phone</span>
            <span style='font-size: 12px;font-weight: 600;color: #000'>Dr. Name: $drName</span>
          </p>
          </div>
          </div>
        </div>
        <div class='receipt_body'>
          <table style='font-size:8px'>
          <thead>
            <th style='right;font-size: 13px;font-weight: 600;color: #000'>SL</th>
            <th style='right;font-size: 13px;font-weight: 600;color: #000'>Item/Desc</th>
            <th style='right;font-size: 13px;font-weight: 600;color: #000'>Qty.</th>
            <th style='text-align:right;right;font-size: 13px;font-weight: 600;color: #000'>Amount</th>
          </thead> 
          <tbody>";
                $id = 0;
                $tot_totalAM = 0;
                $tax1 = 0;
                $string = 0;
        foreach($invoice_details as $value):
                $id +=1;

             $totalAM =    $value->qty * $value->rate;
             $tot_totalAM += $totalAM;
             $tax1 = 0;
             $withtax = $tot_totalAM + $tax1;
             $dis = $withtax - $invoice->total_amount;
             $dis1 = round($dis, 2);
             $perunitrate = round($value->rate, 2);
             $totalam1 = round($totalAM, 2);
             $string = str_replace('-', ' ', $dis1);
            echo"<tr>
            <td style='right;font-size: 12px;font-weight: 600;color: #000'>";echo $id; echo"</td>
              <td class='medicine_name' style='right;font-size: 12px;font-weight: 600;color: #000'>
                $value->product_name
              </td>
              <td  style='right;font-size: 12px;font-weight: 600;color: #000'>$value->qty *  $perunitrate</td>
              <td style='right;font-size: 12px;font-weight: 600;color: #000'> $totalam1

</td>              
            </tr>";
                
                endforeach;
          echo "</tbody>
          
          
          <tr>
            <td></td>
            <td></td>
            <td></td>
            </tr>
            <tr>
            <td></td>
            <td></td>
            
              <td colspan='1' style='right;font-size: 12px;font-weight: 600;color: #000'>Discount</td>
              <td style='right;font-size: 12px;font-weight: 600;color: #000'>  $string

</td>
            </tr> 
          <tr>
            <td></td>
            <td></td>
            
              <td colspan='1' style='right;font-size: 12px;font-weight: 600;color: #000'>Net Due</td>
              <td style='right;font-size: 12px;font-weight: 600;color: #000'>  $invoice->due_amount 

</td>
            </tr>
            <tr>
            <td></td>
            <td></td>
              <td colspan='1' style='right;font-size: 12px;font-weight: 600;color: #000'>Paid</td>
              <td style='right;font-size: 12px;font-weight: 600;color: #000'> $invoice->paid_amount 

</td>
            </tr>
            <tr>
            <td></td>
            <td></td>
              <td colspan='1' style='right;font-size: 12px;font-weight: 600;color: #000'>Total Amount</td>
              <td style='right;font-size: 12px;font-weight: 600;color: #000'> $invoice->total_amount 

</td>
            </tr>
          </table>
        </div>
        <div class='receipt_footer'>
          <span style='right;font-size: 12px;font-weight: 600;color: #000'>THANK YOU</span>
          <div style='display:flex;justify-content: space-between;align-items: center'>
              <p style='font-size: 12px;'>
                  Powered by MedJacket India Private Limited.</p>
              <img src='" . base_url('assets/images/Mask.png') . "' alt='homepage' class='dark-logo' style='width: 52px;'>
          </div>
        </div>                          
      </div></div>";        
    }


    public function Department_summary(){
        if($this->session->userdata('user_login_access') != False) {
        //   $data['salesreport'] = $this->sales_model->getpurchasedetail($start55,$end55);
        $per = $this->permissionsbyemrole();
        $permissions = explode(',', $per);
    if (in_array(55, $permissions)) { 
         $this->load->view('backend/department_report');
        }
        else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
         }
     else{
         redirect(base_url() , 'refresh');
     }           
     }

    public function Department(){
        if($this->session->userdata('user_login_access') != False) {

        $start = strtotime($this->input->post('start'));
        $start55 = date('Y/m/d', $start);
        $end = strtotime($this->input->post('end'));
        $end55 = date('Y/m/d', $end);  
        
       
 
        
       $start = strtotime($this->input->post('start'));
       $start55 = date('Y/m/d', $start);           
       $end = strtotime($this->input->post('end'));
       $end55 = date('Y/m/d', $end);


       $newend = date('m-d-Y', $end);

       $newstart = date('m-d-Y', $start);

       $settings   = $this->configuration_model->getAllSettings();
       //echo $settings->main_store_id

       $allstores = $this->Store_model->get_stores($settings->main_store_id);
       $counter = 1;
       $grandsumsale = 0;
       $grandsumpurchase = 0;

       foreach($allstores as $value):

            $purchasemain = $this->sales_model->getpurchasedetail($start55,$end55,$value->id);
            $salesmain = $this->sales_model->getsalesdetail($start55,$end55,$value->id);
            $totalSalesreturn = $this->sales_model->getsalesreturndetail($newstart,$newend,$value->id);
            
            $totalpurchasesum = $purchasemain[0]->sum;
            $grandsumpurchase = $grandsumpurchase + $totalpurchasesum;
            $totalSalesReturn = $totalSalesreturn[0]->sum + $totalSalesreturn[0]->sumtax;
            
            $totalsalesprice = round($salesmain[0]->sum - $totalSalesReturn);



            
            $grandsumsale = $grandsumsale + $totalsalesprice;

            

            echo"<tr>
                 <td> $counter </td>
                 <td> $value->store_name </td>
                 <td>                  
                  $totalpurchasesum
                 </td>
                 <td>
                         $totalsalesprice
                 </td>
             </tr>";
             $counter++;
           
             
             
             endforeach;
             echo"<tr>
             <td></td>
             <td><strong style='font-weight:700;'>Total Sum</strong></td>
             <td>                  
                     <strong style='font-weight:700;'>$grandsumpurchase</strong>
             </td>
             <td>
                     <strong style='font-weight:700;'>$grandsumsale</strong>
             </td>
         </tr>";
         }
     else{
         redirect(base_url() , 'refresh');
     }           
     }    

     public function GethsnNum($mid)
     {
       return  $GethsnNum = $this->sales_model->GethsnNum($mid);
     }

     public function getigst($hsn)
     {
        return  $getigst = $this->sales_model->getigst($hsn);
     }
     

     public function GETStockclosingrePort(){
        if($this->session->userdata('user_login_access') != False) { 
            $start = $this->input->post('start');
           // print_r($start);
            $checkin = strtotime($start);
             $start5 = date('Y/m/d', $checkin);
             $end = $this->input->post('end');
             $END5 = strtotime($end);
            //--------------------------------------------------
            
             $END5 = date('Y-m-d', $END5);
 
             $date = date("Y-m-d");
             $get_med_data =  $this->medicine_model->get_med_data();
             $stock = 0;
             $total_sale = 0;
             $total_purchase = 0;
             $processed_combinations = [];
             foreach ($get_med_data as $val) {
                 //print_r($val);
                 // $date = $val->sale_date;
                 $pro_id = $val->product_id;
                 $supplier_id = $val->supplier_id;
                 $batch = $val->Batch_Number;
                 // Check if the combination has already been processed
                 $combination_key = "$pro_id-$supplier_id-$batch-$date";
                 
                 if (!in_array($combination_key, $processed_combinations)) {
 
                     $get_stock = $this->medicine_model->get_stock($pro_id, $supplier_id, $batch, $date);
 
                     $get_stock_storemedicine = $this->sales_model->get_stock_frommedicinemata($pro_id, $supplier_id, $batch, $END5);
                     if(!empty($get_stock_storemedicine))
                     {
                         $closingstock = $get_stock_storemedicine[0]->stock;   
                     }
                     else{
                         $closingstock = 0; 
                     }
                    $getsuppname = $this->medicine_model->get_supp_name($supplier_id);
                    
                    $suppname = $getsuppname[0]->s_name;
                     $get_opningstock_storemedicine = $this->sales_model->get_stock_frommedicinemataopening($pro_id, $supplier_id, $batch, $END5);
                     if(!empty($get_opningstock_storemedicine))
                     { $openingstock = $get_opningstock_storemedicine[0]->stock;}
                     else{
                         $openingstock = 0; 
                     }
                     
 
                     $recieved_stock_fromgrn = $this->medicine_model->getstockrecievedvalue1($pro_id,$start5,$END5);
                     // print_r($recieved_stock_fromgrn);
                     $metastocks = $recieved_stock_fromgrn;
                     
                     $get_purchase_rate = $this->medicine_model->get_purchase_rate($pro_id, $supplier_id, $batch);
                     $stock_fromsales = $this->medicine_model->get_stock_fromsales($pro_id, $supplier_id, $batch, $END5, $END5);
                     if(!empty($stock_fromsales)){
                         $stock2 = $stock_fromsales[0]->qty;
                     }
                     else{
                         $stock2 = 0;   
                     }
                     
 
                     $get_hsn_num = $this->medicine_model->get_hsn_num($pro_id);
                     $hsn = ($get_hsn_num[0]->hsn);
                     $product_name = $get_hsn_num[0]->product_name;
                     $form = $get_hsn_num[0]->form;
                     $title = $this->medicine_model->getformbyid($form);
                     $title1 = $title[0]->title;
                     $get_gst = $this->medicine_model->get_gst($hsn);
                     $igst = $get_gst[0]->igst;
                     $get_purperunit = $this->medicine_model->get_purchase_rateperunit($pro_id, $supplier_id, $batch);
                     $perunitprice = $get_purperunit[0]->unit_price;
                     $purchase_rate = $get_purchase_rate[0]->purchase_rate;
 
                     $mrp = $get_purchase_rate[0]->mrp;
                     
                     
                     $purchase_tax = ($perunitprice * $igst) / 100;
                     $purchase_wid_tax = $perunitprice + $purchase_tax;
                     $purchase_wid_tax1 = round($purchase_wid_tax, 2);
                     
 
 
 
                     $exp_date = $get_purchase_rate[0]->expire_date;
 
                     $processed_combinations[] = $combination_key;
                     
                     $in_house_purchase = $closingstock * $purchase_wid_tax1;
                     //  echo $in_house_purchase;
 
                      
 
                    
                     //  $sale_with_tax = $in_house_sale + $tax;
 
                     $sale_tax =  ($mrp * $igst) / 100;
                     $sale_wid_tax = $mrp + $sale_tax;
                     $sale_wid_tax1 = round($sale_wid_tax, 2);
                     $in_house_sale = ($closingstock * $sale_wid_tax1);
                     $tax = ($in_house_sale * $igst) / 100;
                     
                     
 
 
                     $qty =  $get_stock[0]->total_qty;
                     $total_sale += $in_house_sale;
                     $total_purchase += $in_house_purchase;
                     $total_purchase1 = round($total_purchase, 3);
                     $total_sale1 = round($total_sale, 3);
                     $mrp1 = round($mrp, 2);
                     
                     
                     $in_house_sale1 = round($in_house_sale, 2);
                     $in_house_purchase1 = round($in_house_purchase, 2);
                     echo "<tr>
                         <td>$product_name</td>
                         <td>$title1</td>
                         <td>$supplier_id</td>
                         <td>$suppname</td>
                         <td>$batch</td>
                         <td>$pro_id</td>
                         <td>$exp_date</td>
                         <td>$sale_wid_tax1</td>
                         <td>$purchase_wid_tax1</td>
                         <td>$closingstock</td>
                         <td>$openingstock</td>
                         <td>$in_house_sale1</td>
                         <td>$in_house_purchase1</td>                        
                     </tr>";
                }
             }  
             echo "<tr>           
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><b>Grand Total</b></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><b> $total_sale1</b></td>
            <td><b> $total_purchase1</b></td>
        </tr>";            
     }        
     else{
         redirect(base_url() , 'refresh');
     }
     }    
         
     public function GetgrnNum($pid)
     {
       return  $GetgrnNum = $this->sales_model->GetgrnNum($pid);
     }
     public function GETPurchaserePort(){
        if($this->session->userdata('user_login_access') != False) { 
            $start = $this->input->post('start');
           // print_r($start);
            $checkin = strtotime($start);
             $start5 = date('d/m/Y', $checkin);
             
 
            $end = $this->input->post('end');
            $END5 = strtotime($end);
            $END5 = date('d/m/Y', $END5);
            $invoice_details = $this->sales_model->getPurchaseReportstatrt($start5,$END5);
            //  print_r($invoice_details);
            //  die;
                                             $grandtotal = 0;
                                             foreach($invoice_details as $value):
                                                $CI     = & get_instance();
                                           $GetgrnNum = $CI->GetgrnNum($value->p_id);
                                           $grn = !empty($GetgrnNum) ? $GetgrnNum[0]->grn_no : '';
                                           $grn_numbers = '';
                                           $total = $value->gtotal_amount;
                                           $grandtotal += $total;
                                           if (!empty($GetgrnNum)) {
                                               foreach ($GetgrnNum as $grn_info) {
                                                   $grn_numbers .= $grn_info->grn_no . ', ';
                                               }
                                               $grn_numbers = rtrim($grn_numbers, ', ');
                                           }      
                                           
                                              echo"<tr>
                                                 <td>$value->entry_date</td>
                                                 <td>$value->invoice_no</td>
                                                 <td>$value->s_name</td>
                                                 <td>$grn_numbers</td>
                                                 <td>$total</td>
                                                 
                                              </tr>";
                                             endforeach;
                                             echo"<tr>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td><b>Grand Total</b></td>
                                                 <td><b>$grandtotal</b></td>
                                                 
                                              </tr>";
     }        
     else{
         redirect(base_url() , 'refresh');
     }
     }
     
     public function Product_Ledger(){
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                if (in_array(56, $permissions)) { 
         $data['purchasereport'] = $this->sales_model->getPurchaseReport();
         $this->load->view('backend/Product_Ledger',$data);
        }
        else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
         }
 
     else{
         redirect(base_url() , 'refresh');
     }       
     } 
     public function Profit_report(){
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
        if (in_array(101, $permissions)) {
         $this->load->view('backend/Profit_report');
        }
        else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
         }
 
     else{
         redirect(base_url() , 'refresh');
     }       
     } 


     public function GETProductLedgerPort(){
        if($this->session->userdata('user_login_access') != False) { 
            $start = $this->input->post('start');

            $checkin = strtotime($start);
             $start5 = date('Y-m-d', $checkin);
             $start1 = date('Y/m/d', $checkin);
             
            $end = $this->input->post('end');
            $END5 = strtotime($end);
            $END5 = date('Y-m-d', $END5);
            $newDate = date("Y/m/d", strtotime($end));
            
            $medid = $this->input->post('medicine_name');
            //$invoice_details = $this->sales_model->getPurchasesaleledger($medid,$start5,$END5,$start1,$newDate);
            $purchase_details = $this->sales_model->getPurchaseledger($medid, $start5, $END5);
            $sale_details = $this->sales_model->getSalesledger($medid, $start1, $newDate);
            $GRN_details = $this->sales_model->getGRNledger($medid, $start5, $END5);
              
           
            
            
            
                 $purchase = !empty($purchase_details[0]->pur_id)  ? $purchase_details[0]->pur_id : 0;
                 $pname = !empty($purchase_details[0]->product_name) ? $purchase_details[0]->product_name : 0;
                 $gname = !empty($purchase_details[0]->generic_name) ? $purchase_details[0]->generic_name : 0;
                 $grnstock = $this->sales_model->getGrnstock($purchase, $pname, $gname);
                 $stockwithgrn = !empty($grnstock) ? $grnstock[0]->rec_qty : 0;
            
                $counter = 1;
                $overall_balance = 0;
            
                if (!empty($GRN_details)) {
                    foreach ($GRN_details as $value) { 

                        $overall_balance = $overall_balance + $value->rec_qty;
                        //print_r($value);
                        echo "<tr>
                                <td>$counter</td>
                                <td>$value->rec_qty</td>
                                <td>0</td>
                                <td>$overall_balance</td>
                                <td></td>
                                <td>$value->Batch_Number</td>
                              </tr>";

                        
                              
                        $counter++;
                    }
                }
            
                if (!empty($sale_details)) {
                    foreach ($sale_details as $value) {
                        $get_cus_name = $this->purchase_model->get_cus_name($value->cus_id);
                        $cus = !empty($get_cus_name) ? $get_cus_name[0]->c_name : '';
            
                        $balance = $overall_balance - $value->qty;
                        echo "<tr>
                                <td>$counter</td>
                                <td>$stockwithgrn</td>    
                                <td>$value->qty</td>
                                <td>$balance</td>
                                <td>$cus</td>
                                <td>$value->Batch_Number</td>
                              </tr>";
                        
                        $overall_balance = $balance;
                        $counter++;
                    }
                }
             else {
                redirect(base_url(), 'refresh');
            }
}
}
    public function getformbyid($id)
     {
        return  $data = $this->medicine_model->getformbyid($id);
     }


     public function Invoice_History(){
        if($this->session->userdata('user_login_access') != False) {
        $id = base64_decode($this->input->get('H'));
        $data['settings']   = $this->configuration_model->getAllSettings();
        $data['invoice'] = $this->sales_model->getSalesReportForInvoice($id);
        $invoiceno = $data['invoice']->invoice_no;
        $data['invoice_details'] = $this->sales_model->getSalesDetailsForInvoice($id);
        // $createdate = $invoice->create_date;
        // $createtime = $invoice->sales_time;
        $customer = $data['invoice']->c_name;
        // $invoiceno = $invoice->invoice_no;
        $data['customerphone'] = $this->customer_model->getAllCustomerinvoice($customer);
        $data['nots'] = $this->invoice_model->getAllInvoiceNotes($invoiceno);
        // $phone = $customerphone[0]->cus_contact;
        // $cusid = $customerphone[0]->c_id;
        // $tax = $invoice->total_tax;
        // $discount = $invoice->total_discount;
       // $cTime = $createtime;//date("d-m-Y h:i:sa",$createtime);
        $this->load->view('backend/invoice_details',$data);

    
        
    }
    else {
        redirect(base_url(), 'refresh');
    }
}
    public function Savenote(){
       
        $mnote = $this->input->post('note');
        $minvoiceno = $this->input->post('invoiceno'); 
    
        $data = array(
            'note' => $mnote,
            'invoice_no' => $minvoiceno
        );
    
        $this->db->insert('invoice_notes', $data);
    
        $response = array(
            'status' => 'success',
            'message' => 'Note added successfully',
            'curl' => base_url('Sales/Invoice_History'),
        );
    
        echo json_encode($response);
    }

    public function Invoice_Historysales(){
        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->get('H');
        $data['settings']   = $this->configuration_model->getAllSettings();
        $data['invoice'] = $this->sales_model->getSalesReportForInvoice($id);
        $invoiceno = $data['invoice']->invoice_no;
        $data['invoice_details'] = $this->sales_model->getSalesDetailsForInvoice($id);
        // $createdate = $invoice->create_date;
        // $createtime = $invoice->sales_time;
        $customer = $data['invoice']->c_name;
        // $invoiceno = $invoice->invoice_no;
        $data['customerphone'] = $this->customer_model->getAllCustomerinvoice($customer);
        $data['nots'] = $this->invoice_model->getAllInvoiceNotes($invoiceno);
        // $phone = $customerphone[0]->cus_contact;
        // $cusid = $customerphone[0]->c_id;
        // $tax = $invoice->total_tax;
        // $discount = $invoice->total_discount;
       // $cTime = $createtime;//date("d-m-Y h:i:sa",$createtime);
        $this->load->view('backend/invoice_details',$data);

    
        
    }
    else{
        redirect(base_url() , 'refresh');
    }           
    }
    public function Fast_Moving_report(){
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
                       if (in_array(65, $permissions)) {
         $start = $this->input->get('from', TRUE);
         $end = $this->input->get('to', TRUE);
         if($start != '' && $end !=''){
 
             $checkin = strtotime($start);
             $start5 = date('d/m/Y', $checkin);
            $END5 = strtotime($end);
            $END5 = date('d/m/Y', $END5);
            $invoice_details = $this->sales_model->getByInvoiceFromToEnd($start5,$END5);
 
    
         $data['start5'] = $start5;
         $data['END5'] = $END5; 
         $data['invoice_details'] = $invoice_details; 
 
         $this->load->view('backend/fast_movingreport',$data);
         }
         else {
 
         $data['salesreport'] = $this->sales_model->getSalesReport();      
         $this->load->view('backend/fast_movingreport',$data);
 
         }
        } else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
 
         }
     else{
         redirect(base_url() , 'refresh');
     }           
     } 

     public function Slow_Moving_report(){
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
                       if (in_array(66, $permissions)) {
         $start = $this->input->get('from', TRUE);
         $end = $this->input->get('to', TRUE);
         if($start != '' && $end !=''){
 
             $checkin = strtotime($start);
             $start5 = date('d/m/Y', $checkin);
            $END5 = strtotime($end);
            $END5 = date('d/m/Y', $END5);
            $invoice_details = $this->sales_model->getByInvoiceFromToEnd($start5,$END5);
 
    
         $data['start5'] = $start5;
         $data['END5'] = $END5; 
         $data['invoice_details'] = $invoice_details; 
 
         $this->load->view('backend/slow_movingreport',$data);
         }
         else {
 
         $data['salesreport'] = $this->sales_model->getSalesReport();      
         $this->load->view('backend/slow_movingreport',$data);
 
         }
        } else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
 
         }
     else{
         redirect(base_url() , 'refresh');
     }           
     } 

     public function GETfastmovingrePort(){
        if($this->session->userdata('user_login_access') != False) { 
            $start = $this->input->post('start');
           // print_r($start);
            $checkin = strtotime($start);
            $start5 = date('Y/m/d', $checkin);
            
 
            $end = $this->input->post('end');
            $END51 = strtotime($end);
            $END5 = date('Y/m/d', $END51);
            
            $sales_details = $this->sales_model->getHighQuantitySales($start5,$END5);
            
             
                                    $total_sale = 0;
                                    $tot_paid = 0;
                                    $tot_due = 0;
                                       $medicine_quantities = array();
                                       $total = 0;
                                             foreach($sales_details as $value):                                              
                                                 
                                                 
 
 
                                                 $get_medicine_name = $this->purchase_model->get_medicine_name($value->mid);
                                                 $med_name = ($get_medicine_name[0]->product_name);
                                                 $tot1 = $value->grand_total;
                                                 $total += $tot1;
                                                 $medicine = $value->mid;
                                                 $batch_no = $value->Batch_Number;
                                                 $initial_stock = $this->sales_model->getInitialstockvalue($medicine);
                                                 
                                                 $totinit = $initial_stock->stock;
                                                 $recieved_stock = $this->sales_model->getstockrecievedvalue($medicine,$start5,$END5);
                                                 $remaining =$totinit + $recieved_stock - $value->total_quantity_sold;
                                                 $startDateTime = new DateTime($start);
                                                 $endDateTime = new DateTime($end);
                                                 $diff = date_diff($startDateTime, $endDateTime);
                                                   
                                                if ($startDateTime == $endDateTime) {
                                                $total_days = 1;
                                                } else {
                                                $total_days = $diff->days + 1; 
                                                }

                                                                    
                                                 $turnover =  $value->total_quantity_sold/$total_days;                        
                                                 $turnover1 = round($turnover, 2);
                                           
                                             echo"<tr>
                                                <td>$med_name</td>
                                                <td>$value->mid</td>
                                                <td>$totinit</td> 
                                                <td>$recieved_stock </td>                                           
                                                <td>$value->total_quantity_sold </td> 
                                                <td>$remaining</td>
                                                <td>$turnover1</td>  
                                                <td>$value->grand_total</td>                                                                                              
                                            </tr>";
                                         
                                        
                                              endforeach;
                                              echo "<tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><b> Grand Total </b></td>
                                                <td></td>
                                                <td><b> ₹$total </b></td>
                                                
                                            </tr>";
 
                                               
                                            
     }        
     else{
         redirect(base_url() , 'refresh');
     }
     }

     public function GETslowmovingrePort(){
        if($this->session->userdata('user_login_access') != False) { 
            $start = $this->input->post('start');
           // print_r($start);
            $checkin = strtotime($start);
            $start5 = date('Y/m/d', $checkin);
             
 
            $end = $this->input->post('end');
            $END5 = strtotime($end);
            $END5 = date('Y/m/d', $END5);
            $sales_details = $this->sales_model->getlowQuantitySales($start5,$END5);
            
             
                                    $total_sale = 0;
                                    $tot_paid = 0;
                                    $tot_due = 0;
                                       $medicine_quantities = array();
                                       $total = 0;
                                             foreach($sales_details as $value):                                              
                                                 
                                                 
 
 
                                                 $get_medicine_name = $this->purchase_model->get_medicine_name($value->mid);
                                                 $med_name = ($get_medicine_name[0]->product_name);
                                                 $tot1 = $value->grand_total;
                                                 $total += $tot1;
                                               
                                               
                                               
                                                                              
                                             
                                           
                                             echo"<tr>
                                                <td>$med_name</td>
                                                <td>$value->mid</td>
                                                <td><a href='Invoice_Historysales?H=$value->sale_id' target='_blank'>$value->invoice_no</a></td>                                              
                                                <td>$value->total_quantity_sold </td>    
                                                <td>$value->grand_total</td>
                                                
                                               
                                            </tr>";
                                         
                                        
                                              endforeach;
                                              echo "<tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><b> Grand Total </b></td>
                                                <td><b> ₹$total </b></td>
                                                
                                            </tr>";
 
                                               
                                            
     }        
     else{
         redirect(base_url() , 'refresh');
     }
     }
     public function GETSaleReturnrePort(){
        if($this->session->userdata('user_login_access') != False) { 
            $start = $this->input->post('start');
           // print_r($start);
            $checkin = strtotime($start);
            $start5 = date('m-d-Y', $checkin);
             
 
            $end = $this->input->post('end');
            $END5 = strtotime($end);
            $END5 = date('m-d-Y', $END5);
            $return_details = $this->sales_model->GetSalesReturnReport($start5,$END5);
            //  print_r($return_details);
            $total = 0;
                                             foreach($return_details as $value):
                                                $gtotal = $value->total_amount +  $value->tax; 
                                                
                                                $total += $gtotal;                                         
                                              echo"<tr>
                                                 <td>$value->invoice_no</td>
                                                 <td>$value->sale_id</td>
                                                 <td>$value->c_name</td>
                                                 <td>$value->return_date</td>
                                                 <td>$gtotal</td>
                                                 <td>$value->em_name</td>
                                                 
                                              </tr>";
                                             endforeach;
                                             echo "<tr>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td><b> Grand Total </b></td>
                                             <td><b> ₹$total </b></td>
                                             <td></td>
                                             
                                         </tr>";
     }        
     else{
         redirect(base_url() , 'refresh');
     }
     }

     public function EnterdataOfmedicinefrommeta() {
        
            $entrydate = date('d-m-Y');
            $product_data = $this->sales_model->GetAllmedicinedata();
          
            foreach ($product_data as $product) {
                $proid = $product->product_id;
                $instock = $product->instock;
                $batchno = $product->Batch_Number;
                $supid = $product->supplier_id;
                $data = array(
                    'product_id' => $proid,
                    'Batch_Number' => $batchno,
                    'Supplier_id' => $supid,
                    'stock' => $instock,
                    'date' => $entrydate               
                ); 
                
                $success = $this->sales_model->Save_current_stock($data);
               
            }
        
    }
    public function GETPurchaseReturnrePort1(){
        if($this->session->userdata('user_login_access') != False) { 
            $start = $this->input->post('start');
           // print_r($start);
            $checkin = strtotime($start);
            $start5 = date('d-m-Y', $checkin);
             
 
            $end = $this->input->post('end');
            $END5 = strtotime($end);
            $END5 = date('d-m-Y', $END5);
            $return_details = $this->sales_model->getPurchaseReturnReport($start5,$END5);
            //  print_r($return_details);
            $totaldeduction1 = 0;
            
                                             foreach($return_details as $value):
                                             
                                            $totaldeduction = $value->total_deduction;
                                            $totaldeduction1 += $totaldeduction;
                                                                                    
                                              echo"<tr>
                                               <td>$value->invoice_no</td>
                                                <td>$value->s_name</td>
                                                <td>$value->return_date</td>                                                  
                                                 <td>
                                                     $totaldeduction
                                                </td>                                                
                                              </tr>";
                                             endforeach;
                                             echo "<tr>
                                            <td></td>
                                            <td></td>
                                            <td><b>Grand Total</b></td>
                                            <td><b>$totaldeduction1</b></td>                                           
                                         </tr>";
     }        
     else{
         redirect(base_url() , 'refresh');
     }
     }

     
     public function GETProfitreport(){
        if($this->session->userdata('user_login_access') != False) { 
            $start = strtotime($this->input->post('start'));
             $start55 = date('d/m/Y', $start);           
            $invoice_details = $this->sales_model->getByInvoiceFromsales($start55);
            $totalprofit = 0;
                                             foreach($invoice_details as $value):
                                             $profit = $value->perunit_profit * $value->qty;
                                             $totalprofit += $profit;
                                             echo"<tr>
                                                 <td> $value->create_date </td>
                                                 <td><a href='sales_report_invoicedetails?id=$value->invoice_no'> $value->invoice_no</a></td>
                                                 <td>$profit</td>
                                                 
                                             </tr>";
                                             endforeach;
                                             echo "<tr>
                                             <td></td>
                                             
                                             <td><b>Grand Total</b></td>
                                             <td><b>$totalprofit</b></td>                                           
                                          </tr>";
     }        
     else{
         redirect(base_url() , 'refresh');
     }
     }
     public function Getperunitpur($mid,$batchno)
     {
       return  $GetgrnNum = $this->sales_model->Getperunitpur($mid,$batchno);
     }

     public function Getmedname($mid)
     {
       return  $GetgrnNum = $this->medicine_model->GetMedicineValueById1($mid);
     }

}




