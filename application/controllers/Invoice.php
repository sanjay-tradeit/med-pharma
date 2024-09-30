<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Invoice extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->model('medicine_model');
        $this->load->model('customer_model');
        $this->load->model('supplier_model');
        $this->load->model('invoice_model');
        $this->load->model('purchase_model');
        $this->load->model('Hsn_model');
        $this->load->model('configuration_model');
        $this->load->model('sales_model');
        $this->load->model('help_model');
    }

    public function index()

    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') != 1)
            redirect(base_url() . 'login', 'refresh');
        if ($this->session->userdata('user_login_access') == 1)
            $data = array();
        redirect('dashboard/Dashboard');
    }

    public function Create()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data = array();
            $data['customer'] = $this->invoice_model->getAllCustomer();
            $data['medicineList'] = $this->medicine_model->getAllMedicine();
            $this->load->view('backend/invoice', $data);
        } else {

            redirect(base_url(), 'refresh');
        }
    }
    public function Pos_Create()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data = array();
            $data['customer'] = $this->invoice_model->getAllCustomer();
            $data['medicineList'] = $this->medicine_model->getAllSuperMedicine();
            $this->load->view('backend/invoice-pos', $data);
        } else {

            redirect(base_url(), 'refresh');
        }
    }

    public function Pos_Create55()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
            
            
            if (in_array(1, $permissions)) {    
                
                
                $data = array();
                $data['customer'] = $this->invoice_model->getAllCustomer();
                $data['medicineList'] = $this->medicine_model->getAllSuperMedicine();
                $this->load->view('backend/invoice-pos55', $data);
            } else {
                //$this->load->view('backend/auth_error');
                redirect(base_url().'Sales/auth_error', 'refresh');
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    

    public function View()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data['supplierList'] = $this->supplier_model->getAllSupplier();
            $this->load->view('backend/List_supplier', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function GetProductparam()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $midbatch = $_POST['search'];
            if (empty($midbatch)) {
                die();
            }

            $this->invoice_model->GetMIDbatch($midbatch);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function GetExpiryDtaeAselect()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $pid = $this->input->get('id');
            if (empty($pid)) {
                die();
            }
            $medicine = $this->invoice_model->SpecificMedicine($pid);
            date_default_timezone_set("Asia/Kolkata");
            $today = strtotime(date('Y/m/d'));
        }
    }
    /*Get similar generic name data*/
    public function GetSimilarGenericdata()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $pid = $this->input->get('id');
            if (!empty($pid)) {
                $product = $this->invoice_model->SpecificMedicine($pid);
                $pn = $product->generic_name;
                $generic = $this->invoice_model->GetSimilarGenericdata($pn);
                /* echo"<option>Select Here</option>";*/
                foreach ($generic as $value) {
                    echo "<option value='$value->product_id'>$value->product_name</option>";
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function GetCustomerId()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $cid = $_POST['search'];
            if (empty($cid)) {
                die();
            }
            $this->invoice_model->SpecificCustomer($cid);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function GetProductValueForPOSField()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $pid = $this->input->get('id');
            $data['mvalue'] = $this->invoice_model->SpecificMedicine($pid);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function Pos_Info()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $cid = $this->input->post('customer_id');
            $pid = $this->input->post('proid');
            $qty = $this->input->post('qty');

            $product = $this->invoice_model->SpecificMedicine($pid);

            $taxDetails = $this->Hsn_model->GetTaxDetails($product->hsn);
            if (!empty($taxDetails)) {
                $tax = $taxDetails->igst;
            }



            $mrp = $this->input->post('mrp');
            if (empty($pid)) {
                die();
            }

            if (empty($cid)) {
                $ctype = 'Walkin';
            } else {
                $customer = $this->invoice_model->GetCusTomerForCheckType($cid);
                $ctype = $customer->c_type;
            }
            if ($ctype == 'Wholesale') {
                //$product = $this->invoice_model->SpecificMedicine($pid);

                date_default_timezone_set("Asia/Kolkata");
                $today = strtotime(date('Y/m/d'));
                $expire = strtotime($product->expire_date);
                $date = str_replace('/', '-', $product->expire_date);
                $expired = strtotime($date);
                $a = date('Y/m/d', $expired);
                $b = strtotime($a);
                if ($today > $b) {
                    // echo '<script language="javascript">';
                    // echo 'alert(Expired)';  //not showing an alert box.
                    // echo '</script>';
                    // die();
                }
                if ($qty > $product->instock) {
                    // echo '<script language="javascript">';
                    // echo 'alert(Invalid Quantity)';  //not showing an alert box.
                    // echo '</script>';
                    // die();
                }
                if (empty($qty)) {
                    // echo '<script language="javascript">';
                    // echo 'alert(Invalid Quantity)';  //not showing an alert box.
                    // echo '</script>';
                    //  die();
                }
                if ($product->discount == 'YES') {
                    $wdiscount = $product->discount;
                    $bsize = $product->box_size;
                    $bprice = $product->box_price;
                    if ($bsize > $qty) {
                        $discount = ($mrp * $qty) * ($wdiscount / 100);
                        $total = ($mrp * $qty) - $discount;
                        $totall = ($mrp * $qty);
                    } elseif ($bsize < $qty) {
                        $totall = ($mrp * $qty);
                        $oneq = $qty % $bsize;
                        $mrpp = $oneq * $mrp;
                        $two = ($qty - $oneq) / $bsize;
                        $discount = $mrpp * ($wdiscount / 100);
                        $boxprice = $bprice * $two;
                        $total = ($mrpp - $discount) + $boxprice;
                    } elseif ($bsize = $qty) {
                        $totall = ($mrp * $qty);
                        $discount = 0;
                        $total = $bprice;
                    }
                } elseif ($product->discount == 'NO') {
                    $wdiscount = $product->w_discount;
                    $bsize = $product->box_size;
                    $bprice = $product->box_price;
                    if ($bsize > $qty) {
                        $totall = ($mrp * $qty);
                    } elseif ($bsize < $qty) {
                        $totall = ($mrp * $qty);
                        $oneq = $qty % $bsize;
                        $mrpp = $oneq * $mrp;
                        $two  = ($qty - $oneq) / $bsize;
                        $discount = 0;
                        $boxprice = $bprice * $two;
                        $total = $mrpp + $boxprice;
                    } elseif ($bsize = $qty) {
                        $totall = ($mrp * $qty);
                        $discount = 0;
                        $total = $bprice;
                    }
                }
                $output =  "<tr class='premove'>
                              <td><input type='hidden' class='pid' value='$pid' name='pid[]'><input type='text' value='($product->product_name)' name='' readonly></td>
                              <td><input type='text' class='qty' value='$qty' name='qty[]' readonly>
                              <input type='hidden' class='mrp' value='$mrp' name='mrp[]'></td>
                              <td><input type='text' class='tax' value='$mrp' name='tax[]'><input type='text' class='tax' value='$mrp' name='taxnorm[]'></td>
                              <td><input type='hidden' class='total' value='$total' name='total[]' readonly><input type='text' class='totall' value='$totall' name='totall[]' readonly>
                              <input type='hidden' class='discount' value='$discount' name='discount[]'></td>
                              <td class='text-nowrap'>
                                <a href='' id='tremove' data-total='$total' data-totall='$totall' data-discount='$discount' data-original-title='Close'> 
                                  <i class='fa fa-close text-danger'>
                                  </i> 
                                </a>
                              </td>
                            </tr>";
                echo $output;
            } elseif ($ctype == 'Regular') {

                //$product = $this->invoice_model->SpecificMedicine($pid);
                date_default_timezone_set("Asia/Kolkata");
                $today = strtotime(date('Y/m/d'));
                $expire = strtotime($product->expire_date);
                $date = str_replace('/', '-', $product->expire_date);
                $expired = strtotime($date);
                $a = date('Y/m/d', $expired);
                $b = strtotime($a);

                if ($today > $b) {
                    // echo '<script language="javascript">';
                    // echo 'alert(Expired)';  //not showing an alert box.
                    // echo '</script>';
                    //die();
                }
                if ($qty > $product->instock) {
                    // echo '<script language="javascript">';
                    // echo 'alert(Invalid Quantity)';  //not showing an alert box.
                    // echo '</script>';
                    // die();
                }
                if (empty($qty)) {
                    // echo '<script language="javascript">';
                    // echo 'alert(Invalid Quantity)';  //not showing an alert box.
                    // echo '</script>';
                    //die();
                }
                // $product = $this->invoice_model->SpecificMedicine($pid);  

                $date = date('Y-m', strtotime('-1 month'));
                $balance = $this->customer_model->GetCustomerMonthlyIncome($cid, $date);
                $to = 0;
                foreach ($balance as $value) {
                    $to += $value->total_amount;
                }
                $totalsales = $to;
                $target = $customer->target_amount;
                if ($product->discount == 'YES') {
                    if ($totalsales > $target) {
                        print_r("discount");

                        $totall = ($mrp * $qty);
                        $percent = ($customer->regular_discount + $customer->target_discount) / 100;
                        $discount = $totall * $percent;
                        $total = $totall - $discount;
                    } else {
                        print_r("else_dis");
                        $totall = ($mrp * $qty);
                        $percent = $customer->regular_discount / 100;
                        $discount = $totall * $percent;
                        $total = $totall - $discount;
                    }
                } else if ($product->discount == 'NO') {

                    $totall = ($mrp * $qty);
                    $discount = 0;
                    $total = ($mrp * $qty) - $discount;
                }

                $output = "<tr class='premove'>
        <td><input type='hidden' class='pid' value='$pid' name='pid[]'><input type='text' value='" . ($product->product_name) . "' readonly></td>
        <td><input type='text' class='qty' value='$qty' name='qty[]' readonly><input type='hidden' class='mrp' value='$mrp' name='mrp[]'></td>
        <td><input type='text' class='tax' value='$mrp' name='tax[]'></td>
        <td><input type='hidden' class='total' value='$total' name='total[]' readonly>
           <input type='hidden' class='discount' value='$discount' name='discount[]'>
           <input type='text' class='totall' value='$totall' name='totall[]' readonly></td>
        <td class='text-nowrap'>
           <a href='' id='tremove' data-total='$total' data-totall='$totall' data-discount='$discount' data-original-title='Close'> 
              <i class='fa fa-close text-danger'></i> 
           </a>
        </td>
     </tr>";
                echo $output;
            } elseif ($ctype == 'Walkin') {
                //$product = $this->invoice_model->SpecificMedicine($pid);
                date_default_timezone_set("Asia/Kolkata");
                $today = strtotime(date('Y/m/d'));
                // $expire = strtotime($product->expire_date);
                // $date = str_replace('/', '-',$product->expire_date);
                // $expired = strtotime($date);
                // $a = date('Y/m/d',$expired);
                // $b = strtotime($a);               
                // if($today > $b){
                // echo '<script language="javascript">';
                // echo 'alert(Expired)';  //not showing an alert box.
                // echo '</script>';
                //  die();
                //   }                
                //  if($qty > $product->instock){
                // echo '<script type="javascript/text">';
                // echo 'alert(Invalid Quantity)';  //not showing an alert box.
                // echo '</script>';
                //   die();
                //  }                
                // if(empty($qty)){
                //     echo '<script type="javascript/text">';
                //     echo 'alert(Invalid Quantity)';  //not showing an alert box.
                //     echo '</script>';
                // die();
                //  }
                //$product = $this->invoice_model->SpecificMedicine($pid);       
                $totall = ($mrp * $qty);
                $total = ($mrp * $qty);
                $Totaltax = ($tax * $totall) / 100;
                $sum = ($totall + $Totaltax);

                $output =   "<tr class='premove'>
                              <td><input type='hidden' class='pid' value='$pid' name='pid[]'><input type='text' value='($product->product_name)' readonly></td>
                            <td><input type='text' class='qty' value='$qty' name='qty[]' readonly><input type='hidden' class='mrp' value='$mrp' name='mrp[]'></td>
                              
                              <td><input type='text' class='tax' value='$Totaltax' name='tax[]'></td>
                              <input type='hidden' class='discount' value='0' name='discount[]'>
                              <td><input type='text' class='totall' value='$sum' name='totall[]' readonly>
                              <input type='hidden' class='total' value='$sum' name='total[]' readonly></td>
                              <td class='text-nowrap'>
                                <a href='' id='tremove' data-total='$sum' data-totall='$sum' data-discount='0' data-original-title='Close'> 
                                  <i class='fa fa-close text-danger'>
                                  </i> 
                                </a>
                              </td>
                            </tr>";
                echo $output;
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function Save()
    {
        die;
        $salesid      =   'S' . rand(2000, 10000000);
        $customer   =   $this->input->post('customerid');
        $invoice    =   rand(1000000000, 50000000000);
        date_default_timezone_set("Asia/Kolkata");
        $entrydate  =   date("d/m/Y");
        $sale_date = date('Y-m-d');
        //print_r($entrydate);
        $time = strtotime(date('Y-m-d H:i:s'));
        $monthyear  =   date('Y-m');
        $gdiscount  =   round($this->input->post('gdiscount'));
        $gtotal  =   round($this->input->post('payable'));
        $paid =  round($this->input->post('paid'));
        $due =  round($this->input->post('due'));
        $qty =  $this->input->post('qty[]');
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('customerid', 'Supplier', 'trim|required|xss_clean');
        $this->form_validation->set_rules('paid', 'Paid Amount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('qty[]', 'Quantity', 'trim|required|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'error';
            $response['message'] = validation_errors();
            $this->output->set_output(json_encode($response));
        } else {
            $data = array();
            $data = array(
                'sale_id' => $salesid,
                'cus_id' => $customer,
                'invoice_no' => $invoice,
                'total_discount' => $gdiscount,
                'total_amount' => $gtotal,
                'paid_amount' => $paid,
                'due_amount' => $due,
                'create_date' => $entrydate,
                'sales_time' => $time,
                'sale_date' => $sale_date
            );
            $success = $this->invoice_model->Save_Payment($data);
            $balance = $this->customer_model->GetCustomerBalance($customer);
            $totalbalance = $balance->total_balance + $gtotal;
            $totalpaid = $balance->total_paid + $paid;
            $totaldue = $balance->total_due + $due;
            $data = array();
            $data = array(
                'total_balance' => $totalbalance,
                'total_paid' => $totalpaid,
                'total_due' => $totaldue
            );
            $success = $this->invoice_model->Update_Customer_Balance($customer, $data);
            if ($this->db->affected_rows()) {
                $account = $this->user_model->GetAccountBalance();
                $id = $account->id;
                $amount = $account->amount + $gtotal;
                $paid = $account->paid + $paid;
                $due = $account->due + $due;
                $data = array(
                    'amount'   =>  $amount,
                    'paid'      =>  $paid,
                    'due'      =>  $due
                );
                $success = $this->user_model->UPDATE_ACCOUNT($id, $data);
                foreach ($_POST['productid'] as $row => $name) {
                    $medicine   =   $_POST['productid'][$row];
                    $qty        =   $_POST['qty'][$row];
                    $mrp        =   $_POST['smrp'][$row];
                    $total      =   round($_POST['total'][$row]);
                    $discount   =   round($_POST['discount'][$row]);
                    $totaldiscount      =   round($_POST['tdiscount'][$row]);
                    $data = array(
                        'mid'   =>  $medicine,
                        'sale_id'      =>  $salesid,
                        'qty'      =>  $qty,
                        'rate'  =>    $mrp,
                        'total_price'   =>  $total,
                        'discount'   =>  $discount,
                        'total_discount'  =>  $totaldiscount,
                        'total_tax' => $totalTax,
                        'grand_total' => $grandamount

                    );
                    $success = $this->invoice_model->Save_Sales_History($data);
                }
                foreach ($_POST['productid'] as $row => $name) {
                    $medicine   =   $_POST['productid'][$row];
                    $qty        =   $_POST['qty'][$row];
                    $mrp        =   $_POST['smrp'][$row];
                    $total      =   round($_POST['total'][$row]);
                    $discount   =   round($_POST['discount'][$row]);
                    $totaldiscount      =   round($_POST['tdiscount'][$row]);
                    //$medicinestock = $this->purchase_model->getMedicineStock($medicine);
                    //$instock = $medicinestock->instock + $qty;
                    $medicinestock = $this->purchase_model->getmedicineByMId($medicine);
                    $instock = $medicinestock->instock - $qty;
                    $soldqty = $medicinestock->sale_qty + $qty;
                    $data = array(
                        'instock'  =>  $instock,
                        'sale_qty'  =>  $soldqty
                    );
                    $success = $this->purchase_model->Update_Medicine($medicine, $data);
                }
                $response['status'] = 'success';
                $response['message'] = "Successfully Added";
                $response['curl'] = base_url() . "invoice/Create";
                $this->output->set_output(json_encode($response));
            }
        }
    }
    public function GetPosMedicineForDOM()
    {
        $mid = $this->input->get('id');
        $cid = $this->input->get('cusid');
        if (empty($mid)) {
            die();
        }
        $customer = $this->invoice_model->SpecificCustomer($cid);
        $medicine = $this->invoice_model->SpecificMedicine($mid);
        if ($customer->c_type == 'Wholesale') {
            echo "<tr>
                <td><input type='hidden' name='mid[]' value='$medicine->product_id' class='form-control'><button type='button' class='btn bg-purple btn-block btn-xs edit' id=''><span style='color:white;    font-size: 15px' id=''>$medicine->product_name</span></button></td>
                <td><button type='button' class='btn bg-purple btn-block btn-xs edit' id=''><span style='color:white;    font-size: 15px' id=''>$medicine->generic_name</span></button></td>
                <td><input type='text' name='instock[]' value='$medicine->instock' class='form-control instock' readonly></td>
                <td><input type='number' name='qty[]' value='' max='$medicine->instock' class='form-control qty'></td>
                <td><input type='number' name='mrp[]' value='$medicine->mrp' class='form-control mrp' readonly></td>
                <td><input type='number' name='discount[]' value='$medicine->w_discount' class='form-control discount' readonly></td>
                <td><input type='text' name='total[]' value='0' class='form-control total'><input type='hidden' name='tdiscount[]' value='0' class='form-control tdiscount' ></td>
                <td></td>
    </tr>";
        } elseif ($customer->c_type == 'Regular') {
            $date = date('Y-m', strtotime('-1 month'));
            $balance = $this->customer_model->GetCustomerMonthlyIncome($cid, $date);
            $total = 0;
            foreach ($balance as $value) {
                $total += $value->total_amount;
            }
            $totalsales = $total;
            $target = $customer->target_amount;
            if ($totalsales > $target) {
                $discount = 5 + $customer->target_discount;
            } else {
                $discount = 5;
            }
            echo "<tr>
                <td><input type='hidden' name='mid[]' value='$medicine->product_id' class='form-control'><button type='button' class='btn bg-purple btn-block btn-xs edit' id=''><span style='color:white;    font-size: 15px' id=''>$medicine->product_name</span></button></td>
                <td><button type='button' class='btn bg-purple btn-block btn-xs edit' id=''><span style='color:white;    font-size: 15px' id=''>$medicine->generic_name</span></button></td>
                <td><input type='text' name='instock[]' value='$medicine->instock' class='form-control instock' readonly></td>
                <td><input type='text' name='qty[]' value='' max='$medicine->instock' class='form-control qty'></td>
                <td><input type='text' name='mrp[]' value='$medicine->mrp' class='form-control mrp' readonly></td>
                <td><input type='text' name='discount[]' value='$discount' class='form-control discount' readonly></td>
                <td><input type='text' name='total[]' value='0' class='form-control total'><input type='hidden' name='tdiscount[]' value='0' class='form-control tdiscount'></td>
                <td></td>
    </tr>";
        }
    }
    public function Save_Pos()
    {
        $salesid    =   'S' . rand(2000, 10000000);
        $customer   =   $this->input->post('cid');
        $invoice    =   rand(10000000, 50000000);
        date_default_timezone_set("Asia/Kolkata");
        $entrydate  =   date("d/m/Y");
        $sale_date = date('Y-m-d');
        $p_mode   =   $this->input->post('mtype');
        $drname   =   $this->input->post('doctor_name');
        $checkdr = $this->purchase_model->Does_dr_exists($drname);
        if(!empty($drname)){
        if($checkdr == null)
        {
            $data = array(
                'name' => $drname
            );
            $this->purchase_model->insert_doctor($data);
        }
    }
        $monthyear  =   date('Y-m');
        $time = strtotime(date('Y-m-d H:i:s'));
        $gdiscount  =   $this->input->post('gdiscount');
        if (empty($gdiscount)) {
            $gdiscount = 0;
        }
        $grandamount =  $this->input->post('payable');
        $payi =  $this->input->post('pay');
        $duea =  $this->input->post('due');
        $totalTax =  $this->input->post('totalTax');
        $return =  $this->input->post('return');
        $walkin_cus_name = '';
        $walkin_phone = '';
        $storeID = $this->session->userdata('store_id');

        if ($duea >= 0) {
            $paya = $grandamount - $duea;
        } elseif ($duea < 0) {
            $paya = $grandamount;
        }
        $entry = $this->session->userdata('user_login_id');
        if ($this->session->userdata('cnumber')) {
            $type = $this->session->userdata('cnumber');
        } else {
            $type = $this->session->userdata('em_type');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('pay', 'Pay Amount', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'error';
            $response['message'] = validation_errors();
            $this->output->set_output(json_encode($response));
        } else {
            if (empty($customer)) {
                //$customer = 'WalkIn';
                $cid    =      'C' . rand(100, 1000000);
                $walkin_cus_name = $this->input->post('walkin_cus_name');
                $walkin_phone = $this->input->post('walkin_phone');
                $Does_customer_exists = $this->customer_model->Does_customer_exists($walkin_cus_name, $walkin_phone);
                if ($Does_customer_exists == 2) {

                    $data = array(
                        'c_id' => $cid,
                        'c_name' => $walkin_cus_name,
                        'cus_contact' => $walkin_phone,
                        'c_type' => 'Walkin'
                    );

                    $success = $this->customer_model->Add_customer_info($data);
                    $customer = $cid;
                } else {

                    $customer = $Does_customer_exists;
                }
            } else {
                $cbalance = $this->customer_model->GetCustomerBalance($customer);
                if (!empty($cbalance)) {
                    $total = $cbalance->total_balance + $grandamount;
                    $due = $cbalance->total_due + $duea;
                    $paid = $grandamount - $duea;
                    $paidval = $cbalance->total_paid + $paid;
                    $data = array();
                    $data = array(
                        'total_balance' => $total,
                        'total_paid' => $paidval,
                        'total_due' => $due
                    );

                    $success = $this->invoice_model->Update_Customer_Balance($customer, $data);
                }
            }
            $paid = $grandamount - $duea;
            $data = array();
            $data = array(
                'sale_id' => $salesid,
                'store_id' => $storeID,
                'cus_id' => $customer,
                'walkin_cus_name' => $walkin_cus_name,
                'walkin_phone' => $walkin_phone,
                'entryid' => $entry,
                'invoice_no' => $invoice,
                'total_discount' => $gdiscount,
                'total_amount' => $grandamount,
                'total_tax' => $totalTax,
                'paid_amount' => $paid,
                'due_amount' => $duea,
                'create_date' => $entrydate,
                'counter' => $type,
                'pay_status' => 'Pay',
                'payment_mode' => $p_mode,
                'monthyear' => $monthyear,
                'sales_time' => $time,
                'sale_date' => $sale_date,
                'doctor_name' => $drname
            );
             
            $success = $this->invoice_model->Save_Sales($data);
            if ($this->db->affected_rows()) {

                $account = $this->user_model->GetAccountBalance();
                if (!empty($account)) {
                    $id = $account->id;
                    $amount = $account->amount + $grandamount;
                    $paid = $account->paid + $paya;
                    $due = $account->due + $duea;
                    $data = array(
                        'amount'   =>  $amount,
                        'paid'      =>  $paid,
                        'due'      =>  $due
                    );
                    $success = $this->user_model->UPDATE_ACCOUNT($id, $data);
                }

                foreach ($_POST['qty'] as $row => $name) {
                    if (!empty($_POST['qty'][$row])) {
                        $medicine   =   $_POST['pid'][$row];
                        $qty        =   $_POST['qty'][$row];
                        $mrp        =   $_POST['mrp'][$row];
                        $unitmrp        =   $_POST['unitmrp'][$row];
                        $discount   =   $_POST['discount'][$row];
                        $supplier_id   =   $_POST['supplier_id'][$row];
                        $batch_no   =   $_POST['batch_no'][$row];
                        $total     =   $_POST['total'][$row];
                        $initialstock = $this->sales_model->getInitialstock($medicine,$batch_no);
                        $inistock = $initialstock[0]->instock;
                        $actualprice = $this->sales_model->getActualpurprice($medicine,$batch_no,$supplier_id);
                        if(!empty($actualprice)){
                        $actpurprice = $actualprice[0]->actual_purrate;
                        }
                        else {

                        }
                        $totamt = $total + $totalTax;
                        $totdis = ($totamt * $discount)/100;
                        $totgdis = ($totamt * $gdiscount)/100;
                        $totamt1 = $total + $totalTax - $totdis - $totgdis;
                        $perunitsaleprice = $totamt1/$qty;
                        $profitperunit =  $perunitsaleprice - $actpurprice;
                        $profitperunit1 = round($profitperunit, 3);
                        if (empty($discount)) {
                            $discount = 0;
                        }
                        $perunit = $grandamount/$qty;
                        $data = array(
                            'sale_id'   =>  $salesid,
                            'mid'      =>  $medicine,
                            'qty'      => $qty,
                            'rate'      =>  $unitmrp,
                            "supplier_id"    => $supplier_id,
                            "Batch_Number"   =>  $batch_no,
                            'total_price' => $total,
                            'discount'   =>  $discount,
                            'gdiscount' => $gdiscount,
                            "sale_date" => date('Y-m-d'),
                            "store_id" => $this->session->userdata('store_id'),
                            'total_tax' => $totalTax,
                            'grand_total' => $grandamount,
                            'initial_stock' => $inistock,
                            'perunit_profit' => $profitperunit1
                            

                        );
                        $success = $this->invoice_model->Save_Sales_History($data);
                    }
                }
                foreach ($_POST['qty'] as $row => $name) {
                    if (!empty($_POST['qty'][$row])) {
                        $medicine   =   $_POST['pid'][$row];
                        $qty        =   $_POST['qty'][$row];
                        $mrp        =   $_POST['mrp'][$row];
                        $discount   =   $_POST['discount'][$row];
                        $total     =   $_POST['total'][$row];
                        $supplier_id     =   $_POST['supplier_id'][$row];
                        $batch_no     =   $_POST['batch_no'][$row];
                        $exp_date     =   $_POST['exp_date'][$row];




                        $medicinestock = $this->purchase_model->getmedicineByMId($medicine);
                        $instock = $medicinestock->instock - $qty;
                        $soldqty = $medicinestock->sale_qty + $qty;

                        $data = array(
                            'instock'  =>  $instock,
                            'sale_qty'  =>  $soldqty
                        );
                        $success = $this->purchase_model->Update_Medicine($medicine, $data);

                        $get_mmedicine_meta_stock = $this->purchase_model->get_mmedicine_meta_stock($medicine, $supplier_id, $batch_no);
                        $pre_stock = $get_mmedicine_meta_stock[0]->instock;
                        $sold_stock = $get_mmedicine_meta_stock[0]->sale_qty;

                        $qty_sold =  $qty;
                        $rest_qty = $pre_stock - $qty_sold;

                        $data15 = array(
                            'instock' => $rest_qty,
                            'sale_qty' => $sold_stock + $qty_sold
                        );
                        $Update_Medicine_meta = $this->purchase_model->Update_Medicine_meta($medicine, $supplier_id, $batch_no, $data15);

                        // Update  store_medicine_meta
                        $store_id = $this->session->userdata('store_id');
                        $chk_med_store_stock = $this->purchase_model->chk_med_store_stock($medicine, $supplier_id, $batch_no, $store_id, $exp_date);
                        $pre = $chk_med_store_stock[0]->instock;
                        $new = $pre - $qty;
                        $data = array(
                            "instock" => $new
                        );
                        $update_med_store_stock = $this->purchase_model->update_med_store_stock($medicine, $supplier_id, $batch_no, $store_id, $exp_date, $data);
                    }
                }
                $response['status'] = 'success';
                $response['message'] = "Successfully Added";
                // $response['curl'] = base_url() . "invoice/Pos_Create";
                $this->output->set_output(json_encode($response));
            }
        }
    }
    public function Hold_Pos()
    {
        $salesid    =   'S' . rand(2000, 10000000);
        $storeID = $this->session->userdata('store_id');
        $customer   =   $this->input->post('cid');
        $invoice    =   rand(10000000, 50000000);
        date_default_timezone_set("Asia/Kolkata");
        $entrydate  =   date("d/m/Y");
        $sale_date =  date('Y-m-d');
        $monthyear  =   date('Y-m');
        $time = strtotime(date('Y-m-d H:i:s'));
        $gdiscount  =   round($this->input->post('gdiscount'));
        $totalTax =  round($this->input->post('totalTax'));
        $grandamount =  round($this->input->post('payable'));
        $payi =  round($this->input->post('pay'));
        $duea =  round($this->input->post('due'));
        $return =  round($this->input->post('return'));
        if ($duea >= 0) {
            $paya = $grandamount - $duea;
        } elseif ($duea < 0) {
            $paya = $grandamount;
        }
        $entry = $this->session->userdata('user_login_id');
        if ($this->session->userdata('cnumber')) {
            $type = $this->session->userdata('cnumber');
        } else {
            $type = $this->session->userdata('em_type');
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        //$this->form_validation->set_rules('cid', 'customer', 'trim|required|xss_clean');
        $this->form_validation->set_rules('pay', 'Pay Amount', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'error';
            $response['message'] = validation_errors();
            $this->output->set_output(json_encode($response));
        } else {
            if (empty($customer)) {
                $customer = 'WalkIn';
            } else {
                $cbalance = $this->customer_model->GetCustomerBalance($customer);
                $total = $cbalance->total_balance + $grandamount;
                $due = $cbalance->total_due + $duea;
                $paid = $grandamount - $duea;
                $paidval = $cbalance->total_paid + $paid;
                $data = array();
                $data = array(
                    'total_balance' => $total,
                    'total_paid' => $paidval,
                    'total_due' => $due
                );
                $success = $this->invoice_model->Update_Customer_Balance($customer, $data);
            }
            $paid = $grandamount - $duea;
            $data = array();
            $data = array(
                'sale_id' => $salesid,
                'store_id' => $storeID,
                'cus_id' => $customer,
                'entryid' => $entry,
                'invoice_no' => $invoice,
                'total_discount' => $gdiscount,
                'total_amount' => $grandamount,
                'total_tax' => $totalTax,
                'paid_amount' => $paid,
                'due_amount' => $duea,
                'create_date' => $entrydate,
                'counter' => $type,
                'pay_status' => 'Hold',
                'monthyear' => $monthyear,
                'sales_time' => $time,
                'sale_date' => $sale_date
            );
            $success = $this->invoice_model->Save_Sales($data);
            if ($this->db->affected_rows()) {
                $account = $this->user_model->GetAccountBalance();
                $id = $account->id;
                $amount = $account->amount + $grandamount;
                $paid = $account->paid + $paya;
                $due = $account->due + $duea;
                $data = array(
                    'amount'   =>  $amount,
                    'paid'      =>  $paid,
                    'due'      =>  $due
                );
                $success = $this->user_model->UPDATE_ACCOUNT($id, $data);
                foreach ($_POST['qty'] as $row => $name) {
                    if (!empty($_POST['qty'][$row])) {
                        $medicine   =   $_POST['pid'][$row];
                        $qty        =   $_POST['qty'][$row];
                        $mrp        =   $_POST['mrp'][$row];
                        $discount   =   $_POST['discount'][$row];
                        $total     =   $_POST['total'][$row];
                        $data = array(
                            'sale_id'   =>  $salesid,
                            'mid'      =>  $medicine,
                            'qty'      => $qty,
                            'rate'      =>  $mrp,
                            'total_price' => $total,
                            'discount'   =>  $discount,
                            'total_tax' => $totalTax,
                            'grand_total' => $grandamount
                        );
                        $success = $this->invoice_model->Save_Sales_History($data);
                    }
                }
                foreach ($_POST['qty'] as $row => $name) {
                    if (!empty($_POST['qty'][$row])) {
                        $medicine   =   $_POST['pid'][$row];
                        $qty        =   $_POST['qty'][$row];
                        $mrp        =   $_POST['mrp'][$row];
                        $discount   =   $_POST['discount'][$row];
                        $total     =   $_POST['total'][$row];
                        //$medicinestock = $this->purchase_model->getMedicineStock($medicine);
                        //$instock = $medicinestock->instock + $qty;
                        $medicinestock = $this->purchase_model->getmedicineByMId($medicine);
                        $instock = $medicinestock->instock - $qty;
                        $soldqty = $medicinestock->sale_qty + $qty;
                        $data = array(
                            'instock'  =>  $instock,
                            'sale_qty'  =>  $soldqty
                        );
                        $success = $this->purchase_model->Update_Medicine($medicine, $data);
                    }
                    $response['status'] = 'success';
                    $response['message'] = "Successfully Hold";
                    $response['curl'] = base_url() . "invoice/Pos_Create";
                    $this->output->set_output(json_encode($response));
                }
            }
        }
    }

    public function testtime()
    {

        date_default_timezone_set("Asia/Kolkata");
        $entrydate  =   date("d/m/Y");
        $monthyear  =   date('Y-m');
        echo $date = date('H:i:s');
        //echo $time = strtotime("now");

    }
    public function Save_Pos_invoice()
    {
        $salesid    =   'S' . rand(2000, 10000000);
        $storeID = $this->session->userdata('store_id');
        $customer   =   $this->input->post('cid');
        $invoice    =   rand(10000000, 50000000);
        $drname   =   $this->input->post('doctor_name');
        $checkdr = $this->purchase_model->Does_dr_exists($drname);
        if(!empty($drname)){
        if($checkdr == null)
        {
            $data = array(
                'name' => $drname
            );
            $this->purchase_model->insert_doctor($data);
        }
    }
        date_default_timezone_set("Asia/Kolkata");
        $entrydate  =   date("d/m/Y");
        $sale_date =  date('Y-m-d');
        $monthyear  =   date('Y-m');
        $time = date('H:i:s');

        $gdiscount  =   $this->input->post('gdiscount');
        $grandamount =  $this->input->post('payable');
        $payi =  $this->input->post('pay');
        $change =  $this->input->post('return');
        $p_mode   =   $this->input->post('mtype');
        $totalTax =  $this->input->post('totalTax');

        


        $duea =  $this->input->post('due');
        $return =  $this->input->post('return');
        if ($duea >= 0) {
            $paya = $grandamount - $duea;
        } elseif ($duea < 0) {
            $paya = $grandamount;
        }
        $entry = $this->session->userdata('user_login_id');
        if ($this->session->userdata('cnumber')) {
            $type = $this->session->userdata('cnumber');
        } else {
            $type = $this->session->userdata('em_type');
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        //$this->form_validation->set_rules('cid', 'customer', 'trim|required|xss_clean');
        $this->form_validation->set_rules('pay', 'Pay Amount', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            echo validation_errors();
        } else {
            if (empty($customer)) {
                $cid    =      'C' . rand(100, 1000000);
                $walkin_cus_name = $this->input->post('walkin_cus_name');
                $walkin_phone = $this->input->post('walkin_phone');

                $Does_customer_exists = $this->customer_model->Does_customer_exists($walkin_cus_name, $walkin_phone);



                if ($Does_customer_exists == 2) {

                    $data = array(
                        'c_id' => $cid,
                        'c_name' => $walkin_cus_name,
                        'cus_contact' => $walkin_phone,
                        'c_type' => 'Walkin'
                    );

                    $success = $this->customer_model->Add_customer_info($data);
                    $customer = $cid;
                } else {

                    $customer = $Does_customer_exists;
                }
            } else {

                $cbalance = $this->customer_model->GetCustomerBalance($customer);
                if (!empty($cbalance)) {
                    $total = $cbalance->total_balance + $grandamount;
                    $due = $cbalance->total_due + $duea;
                    $paid = $grandamount - $duea;
                    $paidval = $cbalance->total_paid + $paid;
                    $data = array();
                    $data = array(
                        'total_balance' => $total,
                        'total_paid' => $paidval,
                        'total_due' => $due
                    );
                    $success = $this->invoice_model->Update_Customer_Balance($customer, $data);
                }
            }
            $paid = $grandamount - $duea;
            $data = array();
            $data = array(
                'sale_id' => $salesid,
                'store_id' => $storeID,
                'cus_id' => $customer,
                'entryid' => $entry,
                'invoice_no' => $invoice,
                'total_discount' => $gdiscount,
                'total_amount' => $grandamount,
                'paid_amount' => $paid,
                'due_amount' => $duea,
                'total_tax' => $totalTax,
                'create_date' => $entrydate,
                'counter' => $type,
                'pay_status' => 'Pay',
                'payment_mode' => $p_mode,
                'monthyear' => $monthyear,
                'sales_time' => $time,
                'sale_date' => $sale_date,
                'doctor_name' => $drname


            );
               
            $success = $this->invoice_model->Save_Sales($data);
            if ($this->db->affected_rows()) {
                $account = $this->user_model->GetAccountBalance();
                if (!empty($account)) {
                    $id = $account->id;
                    $amount = $account->amount + $grandamount;
                    $paid = $account->paid + $paya;
                    $due = $account->due + $duea;
                    $data = array(
                        'amount'   =>  $amount,
                        'paid'      =>  $paid,
                        'due'      =>  $due
                    );
                    $success = $this->user_model->UPDATE_ACCOUNT($id, $data);
                }

                $sale_date =  date('Y-m-d');
                foreach ($_POST['qty'] as $row => $name) {
                    if (!empty($_POST['qty'][$row])) {
                        $medicine   =   $_POST['pid'][$row];
                        $qty        =   $_POST['qty'][$row];
                        $mrp        =   $_POST['mrp'][$row];
                        $unitmrp    =   $_POST['unitmrp'][$row];
                        $discount   =   $_POST['discount'][$row];
                        $total     =   $_POST['total'][$row];
                        $supplier_id   =   $_POST['supplier_id'][$row];
                        $batch_no   =   $_POST['batch_no'][$row];
                        $initialstock = $this->sales_model->getInitialstock($medicine,$batch_no);
                        $inistock = $initialstock[0]->instock;
                        $actualprice = $this->sales_model->getActualpurprice($medicine,$batch_no,$supplier_id);
                        if(!empty($actualprice)){
                        $actpurprice = $actualprice[0]->actual_purrate;
                        }
                        else {

                        }
                        $totamt = $total + $totalTax;
                        $totdis = ($totamt * $discount)/100;
                        $totgdis = ($totamt * $gdiscount)/100;
                        $totamt1 = $total + $totalTax - $totdis - $totgdis;
                        $perunitsaleprice = $totamt1/$qty;
                        $profitperunit =  $perunitsaleprice - $actpurprice;
                        $profitperunit1 = round($profitperunit, 3);
                        $data = array(
                            'sale_id'   =>  $salesid,
                            'mid'      =>  $medicine,
                            'qty'      => $qty,
                            'rate'      =>  $unitmrp,
                            'total_price' => $total,
                            'discount'   =>  $discount,
                            'total_tax' => $totalTax,
                            'grand_total' => $grandamount,
                            "supplier_id" => $supplier_id,
                            "Batch_Number" => $batch_no,
                            'sale_date' => $sale_date,
                            "store_id" => $this->session->userdata('store_id'),
                            'initial_stock' => $inistock,
                            'perunit_profit' => $profitperunit1
                        );
                        $success = $this->invoice_model->Save_Sales_History($data);
                    }
                }
                $itemDiscount = 0;
                foreach ($_POST['qty'] as $row => $name) {
                    if (!empty($_POST['qty'][$row])) {
                        $medicine   =   $_POST['pid'][$row];
                        $qty        =   $_POST['qty'][$row];
                        $mrp        =   $_POST['mrp'][$row];
                        $unitmrp    =   $_POST['unitmrp'][$row];
                        $discount   =   $_POST['discount'][$row];
                        $total     =   $_POST['total'][$row];
                        $supplier_id     =   $_POST['supplier_id'][$row];
                        $batch_no     =   $_POST['batch_no'][$row];
                        $exp_date     =   $_POST['exp_date'][$row];

                        $itemtotalAmount = $_POST['totall'][$row];
                       

                        $itemDiscount += ($discount * $itemtotalAmount)/100;

                        //$medicinestock = $this->purchase_model->getMedicineStock($medicine);
                        //$instock = $medicinestock->instock + $qty;
                        $medicinestock = $this->purchase_model->getmedicineByMId($medicine);
                        $instock = $medicinestock->instock - $qty;
                        $soldqty = $medicinestock->sale_qty + $qty;
                        $data = array(
                            'instock'  =>  $instock,
                            'sale_qty'  =>  $soldqty
                        );
                        $success = $this->purchase_model->Update_Medicine($medicine, $data);
                        $get_mmedicine_meta_stock = $this->purchase_model->get_mmedicine_meta_stock($medicine, $supplier_id, $batch_no);
                        //print_r($get_mmedicine_meta_stock);
                        $sold_stock = $get_mmedicine_meta_stock[0]->sale_qty + $qty;
                        //die;
                        $pre_stock = $get_mmedicine_meta_stock[0]->instock;
                        $sold_stock = $get_mmedicine_meta_stock[0]->sale_qty;
                        $qty_sold =  $qty;
                        $rest_qty = $pre_stock - $qty_sold;
                        $data15 = array(

                            'instock' => $rest_qty,
                            'sale_qty' => $sold_stock + $qty_sold
                        );
                        $Update_Medicine_meta = $this->purchase_model->Update_Medicine_meta($medicine, $supplier_id, $batch_no, $data15);
                    }
                    //     // Update  store_medicine_meta
                    $store_id = $this->session->userdata('store_id');
                    $chk_med_store_stock = $this->purchase_model->chk_med_store_stock($medicine, $supplier_id, $batch_no, $store_id, $exp_date);
                    $pre = $chk_med_store_stock[0]->instock;
                    $new = $pre - $qty;
                    $data = array(
                        "instock" => $new
                    );

                    $update_med_store_stock = $this->purchase_model->update_med_store_stock($medicine, $supplier_id, $batch_no, $store_id, $exp_date, $data);
                }
                $settings   = $this->configuration_model->getAllSettings();
                //$customer = $this->invoice_model->GetCusTomerForCheckType($customer);
                $createdate = date("jS  M Y ");
                $createtime = date("h:i A");
                $paid = $grandamount - $duea;

                $customerphone = $this->customer_model->getAllCustomerrecipt($customer);

                $phone = $customerphone[0]->cus_contact;
                $name = $customerphone[0]->c_name;


                $invoice_details = $this->sales_model->getSalesDetailsForInvoice($salesid);
                $invoice1 = $this->sales_model->getSalesReportForInvoice($salesid);
                $tax = 0;
                $roundtax = 0;
                if($gdiscount == ''){$discount = $itemDiscount;}else{ $discount = $invoice1->total_discount;}
                
                
                


                echo " <div id='printa'>
<div class='card-body pos_receipt'>
    <div class='receipt_header'>
      <div class='row'>
      <div class='col-md-12'>
      <p class='company-info' style='padding-bottom:5px;margin-top:-10px;'>
        <span style='text-align:center;'><img src='" . base_url('assets/images/' . $settings->sitelogo) . "' class='img-responsive text-center' style='width:120px;height:auto;'></span>
        
        <span style='text-align:center;font-size: 12px;font-weight: 600;color: #000;line-height:15px;'> $settings->address</span>
        <span style='text-align:center;font-size: 13px;font-weight: 600;color: #000;line-height:15px;margin-bottom:5px;padding-bottom:5px;border-bottom:1px dashed;'>Contact: $settings->contact</span>
        <span style='text-align:center;font-size: 13px;font-weight: 600;color: #000;line-height:15px;margin-bottom:5px;padding-bottom:5px;border-bottom:1px dashed;'>GST: $settings->gst</span>
        <span style='float:left;font-size: 13px;font-weight: 600;color: #000;line-height:15px;'>$createtime</span><span style='float:right;font-size: 13px;font-weight: 600;color: #000'>$createdate</span>
      </p>
      </div>
      <div class='col-md-12'>
      <p class='customer-details;margin-bottom:5px;'>
        <span style='font-size: 12px;font-weight: 600;color: #000'>ID: $customer</span>
        <span style='font-size: 12px;font-weight: 600;color: #000'>Name: $name </span>
        <span style='font-size: 12px;font-weight: 600;color: #000'>Invoice: $invoice</span>
        <span style='font-size: 12px;font-weight: 600;color: #000'>Phone Number: $phone</span>
        <span style='font-size: 12px;font-weight: 600;color: #000'>Dr. Name: $drname</span>
        
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

                foreach ($invoice_details as $value) :
                    $id += 1;

                    $totalAM =    $value->qty * $value->rate;

                    echo "<tr>
<td style='right;font-size: 12px;font-weight: 600;color: #000'>";
                    echo $id;
                    echo "</td>
  <td class='medicine_name' style='right;font-size: 12px;font-weight: 600;color: #000'>
    $value->product_name
  </td>
  <td  style='right;font-size: 12px;font-weight: 600;color: #000'>$value->qty * $value->rate</td>
  <td style='right;font-size: 12px;font-weight: 600;color: #000'> $totalAM

.</td>              
</tr>";

                endforeach;
                $fdiscount = round(($totalAM + $roundtax)-$invoice1->total_amount,2) ;
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
  <td style='right;font-size: 12px;font-weight: 600;color: #000'>  $fdiscount

.</td>
</tr> 
<tr>
<td></td>
<td></td>

  <td colspan='1' style='right;font-size: 12px;font-weight: 600;color: #000'>Net Due</td>
  <td style='right;font-size: 12px;font-weight: 600;color: #000'>  $invoice1->due_amount 

.</td>
</tr>
<tr>
<td></td>
<td></td>
  <td colspan='1' style='right;font-size: 12px;font-weight: 600;color: #000'>Paid</td>
  <td style='right;font-size: 12px;font-weight: 600;color: #000'> $invoice1->paid_amount 

.</td>
</tr>
<tr>
<td></td>
<td></td>
  <td colspan='1' style='right;font-size: 12px;font-weight: 600;color: #000'>Total Amount</td>
  <td style='right;font-size: 12px;font-weight: 600;color: #000'> $invoice1->total_amount 

.</td>
</tr>
</table>
</div>
<div class='receipt_footer'>
<span style='right;font-size: 12px;font-weight: 600;color: #000'>THANK YOU</span>
<div style='display:flex;justify-content: space-between;align-items: center;'>
          <p style='font-size: 12px;''>
              Powered by MedJacket India Private Limited.</p>
          <img src= '" . base_url('assets/images/Mask.png') . "' alt='homepage' class='dark-logo' style='width: 52px;'>
      </div>
</div>                          
</div>
</div>";
            }
        }
    }
    public function Invoice_Create()
    {
        $sales = $this->input->get('I');
        if (!empty($sales)) {
            $data['settings']   = $this->configuration_model->getAllSettings();
            $data['invoice'] = $this->invoice_model->Get_Invoice_Value($sales);
            $data['invoicedetails'] = $this->invoice_model->Get_Invoice_Value_Details($sales);
            $this->load->view('backend/invoice_view', $data);
        }
    }
    public function pos_print()
    {

        if ($this->session->userdata('user_login_access') != False) {
            $this->load->view('backend/pos-print');
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function barcode_print()
    {

        if ($this->session->userdata('user_login_access') != False) {
            $this->load->view('backend/barcode-print');
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function permissionsbyemrole(){
        $id = $_SESSION['user_type'];
        $permission = $this->user_model->getAllpermissionsbyemid($id);  
        return $permissions1 = $permission[0]->permissions;
    }

    public function manage_Invoice()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
            if (in_array(2, $permissions)) { 
            $data['invoice'] = $this->invoice_model->GetAllInvoiceData();
            $this->load->view('backend/manage_invoice', $data);
        } else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    
    public function Pos_Info12()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $cid = $this->input->post('customer_id');
            $pid = $this->input->post('proid');
            $qty = $this->input->post('qty');
            $batchNumber = $this->input->post('batchNumber');
            $stock = $this->input->post('stock');
            $exp_date = $this->input->post('exp_date');
            $storeID = $this->session->userdata('store_id');


            $get_discount = $this->invoice_model->get_discount($cid);
            if (!empty($get_discount)) {
                $dis = $get_discount[0]->regular_discount;
            }


            $get_supplier_id = $this->invoice_model->get_supplier_id($pid, $batchNumber, $stock, $storeID);

            $supplier_id = $get_supplier_id[0]->supplier_id;

            $product = $this->invoice_model->SpecificMedicine12($pid);
            $taxDetails = $this->Hsn_model->GetTaxDetails($product[0]->hsn);
            $igst = $taxDetails->igst;
            // print_r($igst);
            if (!empty($taxDetails)) {
                $tax = $taxDetails->igst;
            }
            $mrp = $this->input->post('mrp');
            if (empty($pid)) {
                die();
            }

            if (empty($cid)) {
                $ctype = 'Walkin';
            } else {
                $customer = $this->invoice_model->GetCusTomerForCheckType($cid);
                $ctype = $customer->c_type;
            }
            if ($ctype == 'Wholesale') {
                date_default_timezone_set("Asia/Kolkata");
                $today = strtotime(date('Y/m/d'));
                $expire = strtotime($product[0]->expire_date);
                $date = str_replace('/', '-', $product[0]->expire_date);
                $expired = strtotime($date);
                $a = date('Y/m/d', $expired);
                $b = strtotime($a);

                $balance = $this->customer_model->GetCustomerMonthlyIncome($cid, $date);
                $to = 0;
                foreach ($balance as $value) {
                    $to += $value->total_amount;
                }
                $totalsales = $to;
                $target = $customer->target_amount;
                if ($product[0]->discount == '0') {

                    if ($totalsales > $target) {

                        $totall = ($mrp * $qty);
                        $percent = ($customer->regular_discount + $customer->target_discount) / 100;
                        $discount = $totall * $percent;
                        $total = $totall - $discount;
                    } else {

                        $totall = ($mrp * $qty);
                        $percent = $customer->regular_discount / 100;
                        $discount = $totall * $percent;
                        $total = $totall - $discount;
                    }
                } else if ($product[0]->discount == 'NO') {

                    $totall = ($mrp * $qty);
                    $discount = 0;
                    $total = ($mrp * $qty) - $discount;
                }
                $output =  "<tr class='premove'>
                              <td><input type='hidden' class='pid' value='$pid' name='pid[]'> <input type='hidden' class='pid' value='$supplier_id' name='supplier_id[]'><input type='hidden' class='pid' value='$batchNumber' name='batch_no[]'><input type='text' value='" . ($product[0]->product_name) . "' readonly></td>
                           
                              <td><input type='hidden' value='$exp_date' name='exp_date[]'><input type='text' class='qty' value='$qty' name='qty[]' readonly>
                              <input type='hidden' class='mrp' value='$mrp' name='mrp[]'></td>
                              <td><input type='text' class='tax' value='$mrp' name='tax[]'></td>
                              <td><input type='hidden' class='total' value='$total' name='total[]' readonly><input type='text' class='totall' value='$totall' name='totall[]' readonly>
                              <input type='hidden' class='discount' value='$dis' name='discount[]'></td>
                              <td class='text-nowrap'>
                                <a href='' id='tremove' data-total='$total' data-totall='$totall' data-discount='$discount' data-original-title='Close'> 
                                  <i class='fa fa-close text-danger'>
                                  </i> 
                                </a>
                              </td>
                            
                            </tr>";
                echo $output;
            } elseif ($ctype == 'Regular') {
                date_default_timezone_set("Asia/Kolkata");
                $today = strtotime(date('Y/m/d'));
                $expire = strtotime($product[0]->expire_date);
                $date = str_replace('/', '-', $product[0]->expire_date);
                $expired = strtotime($date);
                $a = date('Y/m/d', $expired);
                $b = strtotime($a);
                // $product = $this->invoice_model->SpecificMedicine($pid);  

                $date = date('Y-m', strtotime('-1 month'));
                $balance = $this->customer_model->GetCustomerMonthlyIncome($cid, $date);
                $to = 0;
                foreach ($balance as $value) {
                    $to += $value->total_amount;
                }
                $totalsales = $to;
                $target = $customer->target_amount;
                if ($product[0]->discount == '0') {

                    if ($totalsales > $target) {
                        $totall = ($mrp * $qty);
                        $percent = ($customer->regular_discount + $customer->target_discount) / 100;
                        $discount = $totall * $percent;
                        $total = $totall - $discount;
                    } else {
                        $totall = ($mrp * $qty);
                        $percent = $customer->regular_discount / 100;
                        $discount = $totall * $percent;
                        $total = $totall - $discount;
                    }
                } else if ($product[0]->discount == 'NO') {

                    $totall = ($mrp * $qty);
                    $discount = 0;
                    $total = ($mrp * $qty) - $discount;
                }
                $total_gst  = ($totall * $igst) / 100;
                $output = "<tr class='premove'>
        <td><input type='hidden' class='pid' value='$pid' name='pid[]'><input type='hidden' class='pid' value='$supplier_id' name='supplier_id[]'><input type='hidden' class='pid' value='$batchNumber' name='batch_no[]'><input type='text' value='" . ($product[0]->product_name) . "' readonly></td>
        <td><input type='text' class='qty' value='$qty' name='qty[]' readonly><input type='hidden' class='mrp' value='$mrp' name='mrp[]'></td>
        <td><input type='text' class='tax' value='$total_gst' name='tax[]'></td>
        <td> <input type='hidden' value='$exp_date' name='exp_date[]'><input type='hidden' class='total' value='$total' name='total[]' readonly>
           <input type='text' class='discount' value='$dis' id = 'discount' name='discount'>
           <input type='text' class='totall' value='$totall' name='totall[]' readonly></td>
        <td class='text-nowrap'>
           <a href='' id='tremove' data-total='$total' data-totall='$totall' data-discount='$discount' data-original-title='Close'> 
              <i class='fa fa-close text-danger'></i> 
           </a>
        </td>
       
     </tr>";
                echo $output;
            } elseif ($ctype == 'Walkin') {
                //$product = $this->invoice_model->SpecificMedicine($pid);
                date_default_timezone_set("Asia/Kolkata");
                $today = strtotime(date('Y/m/d'));
                $taxDetails = $this->Hsn_model->GetTaxDetails($product[0]->hsn);
                $igst = $taxDetails->igst;


                $totall = ($mrp * $qty);
                $total = ($mrp * $qty);

                if (!empty($taxDetails)) {
                    $Totaltax = ($tax * $totall) / 100;
                    $sum = ($totall + $Totaltax);
                    $total_gst  = ($totall * $igst) / 100;
                }


                $output = "<tr class='premove'>
            <td><input type='hidden' class='pid' value='$pid' name='pid[]'><input type='hidden' class='pid' value='$supplier_id' name='supplier_id[]'><input type='hidden' class='pid' value='$batchNumber' name='batch_no[]'><input type='text' value='" . ($product[0]->product_name) . "' readonly></td>
      
            <td><input type='text' class='qty' value='$qty' name='qty[]' readonly><input type='hidden' class='mrp' value='$mrp' name='mrp[]'></td>
            <td><input type='text' class='tax' value='$total_gst' name='tax[]'></td>
            <td><input type='hidden' value='$exp_date' name='exp_date[]'><input type='hidden' class='total' value='$total' name='total[]' readonly><input type='hidden' class='total' value='' name='discount[]' readonly>
               <input type='text' class='totall' value='$totall' name='totall[]' readonly></td>
            <td class='text-nowrap'>
               <a href='' id='tremove' data-total='$total' data-totall='$totall' data-discount='' data-original-title='Close'> 
                  <i class='fa fa-close text-danger'></i> 
               </a>
            </td>
         </tr>";
                echo $output;
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Pos_Info55()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $cid = $this->input->post('customer_id');
            $pid = $this->input->post('proid');
            $regDisc = $this->input->post('regdisc');

            $batchNumber = $this->input->post('batchNumber');
            $stock = $this->input->post('stock');
            $exp_date = $this->input->post('exp_date');
            $unit = $this->input->post('unit');
            $storeID = $this->session->userdata('store_id');
            $medqty = $this->input->post('qty');
            // if ($unit == "Tablet") {
            //     $qty = $this->input->post('qty');
            // }
            // if ($unit == "strip") {
            //     $qty = $this->input->post('qty');
            //     $qty = $qty * 10;
            // }
            // if ($unit == "Box") {
            //     $qty = $this->input->post('qty');
            //     $qty = $qty * 100;
            // }


            $qty = $unit * $medqty;

            $get_unitmrp = $this->invoice_model->get_unitmrp($pid,$batchNumber);
            $unitmrp = $get_unitmrp[0]->unit_mrp;
            $get_discount = $this->invoice_model->get_discount($cid);
            if (!empty($get_discount)) {
                $dis = $get_discount[0]->regular_discount;
            }


            $get_supplier_id = $this->invoice_model->get_supplier_id($pid, $batchNumber, $stock, $storeID);

            $supplier_id = $get_supplier_id[0]->supplier_id;

            $product = $this->invoice_model->SpecificMedicine12($pid);
            //print_r($product);
            
            $taxDetails = $this->Hsn_model->GetTaxDetails($product[0]->hsn);
            $igst = 0;
            // print_r($igst);
            if (!empty($taxDetails)) {
                $tax = 0;
            }
            $mrp = $this->input->post('mrp');
            if (empty($pid)) {
                die();
            }

            if (empty($cid)) {
                $ctype = 'Walkin';
            } else {
                $customer = $this->invoice_model->GetCusTomerForCheckType($cid);
                $ctype = $customer->c_type;
            }
            if ($ctype == 'Wholesale') {
                date_default_timezone_set("Asia/Kolkata");
                $today = strtotime(date('Y/m/d'));
                $expire = strtotime($product[0]->expire_date);
                $date = str_replace('/', '-', $product[0]->expire_date);
                $expired = strtotime($date);
                $a = date('Y/m/d', $expired);
                $b = strtotime($a);

                $balance = $this->customer_model->GetCustomerMonthlyIncome($cid, $date);
                $to = 0;
                foreach ($balance as $value) {
                    $to += $value->total_amount;
                }
                $totalsales = $to;
                $target = $customer->target_amount;
                if ($product[0]->discount == '0') {

                    if ($totalsales > $target) {

                        $totall = ($unitmrp * $qty);
                        $percent = ($customer->regular_discount + $customer->target_discount) / 100;
                        $discount = $totall * $percent;
                        $total = $totall - $discount;
                    } else {

                        $totall = round(($unitmrp * $qty),2);
                        $percent = $customer->regular_discount / 100;
                        $discount = $totall * $percent;
                        $total = round($totall - $discount, 2);
                    }
                } else if ($product[0]->discount == 'NO') {

                    $totall = ($unitmrp * $qty);
                    $discount = 0;
                    $total = ($unitmrp * $qty) - $discount;

                    $total_gst  = ($totall * $igst) / 100;
                }
                $total_gst  = 0;
                
                $output =  "<tr class='premove'>
                              <td><input type='hidden' class='pid' value='$pid' name='pid[]'> <input type='hidden' class='pid' value='$supplier_id' name='supplier_id[]'><input type='hidden' class='pid' value='$batchNumber' name='batch_no[]'><input type='text' value='" . ($product[0]->product_name) . "' readonly></td>
                           
                              <td><input type='hidden' value='$exp_date' name='exp_date[]'><input type='text' class='qty' value='$qty' name='qty[]' readonly>
                              <input type='hidden' class='mrp' value='$mrp' name='mrp[]'></td>
                              <input type='hidden' class='mrp' value='$unitmrp' name='unitmrp[]'>
                              <input type='hidden' class='tax' value='$total_gst' name='tax[]'><input type='hidden' class='taxpercent' value='$igst' name='taxpercent[]'></td>
                              <td><input type='hidden' class='total' value='$total' name='total[]' readonly><input type='text' class='totall' value='$totall' name='totall[]' readonly>
                              <input type='hidden' class='discount' value='$dis' name='discount[]'></td>
                              <td class='text-nowrap'>
                                <a href='' id='tremove' data-total='$total' data-totall='$totall' data-discount='$discount' data-original-title='Close'> 
                                  <i class='fa fa-close text-danger'>
                                  </i> 
                                </a>
                              </td>
                            
                            </tr>";
                echo $output;
            } elseif ($ctype == 'Regular') {
                date_default_timezone_set("Asia/Kolkata");
                $today = strtotime(date('Y/m/d'));
                $expire = strtotime($product[0]->expire_date);
                $date = str_replace('/', '-', $product[0]->expire_date);
                $expired = strtotime($date);
                $a = date('Y/m/d', $expired);
                $b = strtotime($a);
                // $product = $this->invoice_model->SpecificMedicine($pid);  

                $date = date('Y-m', strtotime('-1 month'));
                $balance = $this->customer_model->GetCustomerMonthlyIncome($cid, $date);
                $to = 0;
                foreach ($balance as $value) {
                    $to += $value->total_amount;
                }
                $totalsales = $to;
                $target = $customer->target_amount;
                if ($product[0]->discount == '0') {

                    if ($totalsales > $target) {
                        $totall = ($unitmrp * $qty);
                        $percent = ($customer->regular_discount + $customer->target_discount) / 100;
                        $discount = $totall * $percent;
                        $total = $totall - $discount;
                    } else {
                        $totall = ($unitmrp * $qty);
                        $percent = $customer->regular_discount / 100;
                        $discount = $totall * $percent;
                        $total = $totall - $discount;
                    }
                } else if ($product[0]->discount == 'NO') {

                    $totall = ($unitmrp * $qty);
                    $discount = 0;
                    $total = ($unitmrp * $qty) - $discount;
                }
                $total_gst  = 0;
                $normaltax = 0;
    //             $output = "<tr class='premove'>
    //     <td><input type='hidden' class='pid' value='$pid' name='pid[]'><input type='hidden' class='pid' value='$supplier_id' name='supplier_id[]'><input type='hidden' class='pid' value='$batchNumber' name='batch_no[]'><input type='text' value='" . ($product[0]->product_name) . "' readonly></td>
    //     <td><input type='text' class='qty' value='$qty' name='qty[]' readonly><input type='hidden' class='mrp' value='$mrp' name='mrp[]'></td>
    //     <td><input type='text' class='tax' value='$total_gst' name='tax[]'></td>
    //     <td> <input type='hidden' value='$exp_date' name='exp_date[]'><input type='hidden' class='total' value='$total' name='total[]' readonly>
    //     <input type='hidden' class='mrp' value='$unitmrp' name='unitmrp[]'></td>
    //        <input type='text' class='discount' value='$dis' id = 'discount' name='discount'>
    //        <input type='text' class='totall' value='$totall' name='totall[]' readonly></td>
    //     <td class='text-nowrap'>
    //        <a href='' id='tremove' data-total='$total' data-totall='$totall' data-discount='$discount' data-original-title='Close'> 
    //           <i class='fa fa-close text-danger'></i> 
    //        </a>
    //     </td>
       
    //  </tr>";
    $output =  "<tr class='premove 123 123'>
                              <td><input type='hidden' class='pid' value='$pid' name='pid[]'> <input type='hidden' class='pid' value='$supplier_id' name='supplier_id[]'><input type='hidden' class='pid' value='$batchNumber' name='batch_no[]'><input type='text' value='" . ($product[0]->product_name) . "' readonly></td>
                           
                              <td><input type='hidden' value='$exp_date' name='exp_date[]'><input type='text' class='qty' value='$qty' name='qty[]' readonly>
                              <input type='hidden' class='mrp' value='$mrp' name='mrp[]'></td>
                              <input type='hidden' class='mrp' value='$unitmrp' name='unitmrp[]'>
                              <input type='hidden' class='tax' value='$total_gst' name='tax[]'><input type='hidden' class='normaltax' value='$normaltax' name='normaltax[]'><input type='hidden' class='taxpercent' value='$igst' name='taxpercent[]'></td>
                              <td><input type='hidden' class='total' value='$total' name='total[]' readonly><input type='text' class='totall' value='$totall' name='totall[]' readonly>
                              <input type='hidden' class='discount' value='$dis' name='discount[]'></td>
                              <td class='text-nowrap'>
                                <a href='' id='tremove' data-total='$total' data-totall='$totall' data-discount='$discount' data-original-title='Close'> 
                                  <i class='fa fa-close text-danger'>
                                  </i> 
                                </a>
                              </td>
                            
                            </tr>";
                echo $output;
            } elseif ($ctype == 'Walkin') {
                //$product = $this->invoice_model->SpecificMedicine($pid);
                date_default_timezone_set("Asia/Kolkata");
                $today = strtotime(date('Y/m/d'));
                $taxDetails = $this->Hsn_model->GetTaxDetails($product[0]->hsn);
                $igst = 0;
                $total_gst  = 0;

                $totall = ($unitmrp * $qty);
                $total = ($unitmrp * $qty);
                
                if (!empty($taxDetails)) {
                    $Totaltax = ($tax * $totall) / 100;
                    $sum = ($totall + $Totaltax);
                    $total_gst  = 0;  
                }


                $output = "<tr class='premove'>
            <td><input type='hidden' class='pid' value='$pid' name='pid[]'><input type='hidden' class='pid' value='$supplier_id' name='supplier_id[]'><input type='hidden' class='pid' value='$batchNumber' name='batch_no[]'><input type='text' value='" . ($product[0]->product_name) . "' readonly></td>
      
            <td><input type='hidden' class='qty' value='$unit' name='unit[]'><input type='text' class='qty' value='$qty' name='qty[]' readonly><input type='hidden' class='mrp' value='$mrp' name='mrp[]'></td>
            <input type='hidden' class='mrp' value='$unitmrp' name='unitmrp[]'>
            <input type='hidden' class='tax' value='$total_gst' name='tax[]'><input type='hidden' class='taxpercent' value='$igst' name='taxpercent[]'></td>
            <td><input type='hidden' value='$exp_date' name='exp_date[]'><input type='hidden' class='total' value='$total' name='total[]' readonly><input type='hidden' class='total' value='' name='discount[]' readonly>
               <input type='text' class='totall' value='$totall' name='totall[]' readonly></td>
            <td class='text-nowrap'>
               <a href='' id='tremove' data-total='$total' data-totall='$totall' data-discount='' data-original-title='Close'> 
                  <i class='fa fa-close text-danger'></i> 
               </a>
            </td>
         </tr>";
                echo $output;
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function GethsnNum($mid)
    {
        return  $GethsnNum = $this->sales_model->GethsnNum($mid);
    }



    public function GETStockclosingrePort()
    {
        $start = $this->input->post('start');
        $START51 = strtotime($start);
        
        // $end = $this->input->post('start');
        // $END5 = strtotime($end);
        //--------------------------------------------------
        
        // $END5 = date('Y-m-d', $END5);
        $START5 = date('Y-m-d', $START51);
        
        // //---------------------------------------------------
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

                $get_stock_storemedicine = $this->sales_model->get_stock_frommedicinemata($pro_id, $supplier_id, $batch, $START5);
                if(!empty($get_stock_storemedicine))
                {
                    $closingstock = $get_stock_storemedicine[0]->stock;   
                }
                else{
                    $closingstock = 0; 
                }

               
                $get_opningstock_storemedicine = $this->sales_model->get_stock_frommedicinemataopening($pro_id, $supplier_id, $batch, $START5);
                if(!empty($get_opningstock_storemedicine))
                { $openingstock = $get_opningstock_storemedicine[0]->stock;}
                else{
                    $openingstock = 0; 
                }
                

                $recieved_stock_fromgrn = $this->medicine_model->getstockrecievedvalue1($pro_id,$START5,$START5);
                // print_r($recieved_stock_fromgrn);
                $metastocks = $recieved_stock_fromgrn;
                
                $get_purchase_rate = $this->medicine_model->get_purchase_rate($pro_id, $supplier_id, $batch);
                $stock_fromsales = $this->medicine_model->get_stock_fromsales($pro_id, $supplier_id, $batch, $START5, $START5);
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
                $getsuppname = $this->medicine_model->get_supp_name($supplier_id);
                
                $suppname = $getsuppname[0]->s_name;
                $sale_wid_tax = $mrp + $sale_tax;
                
                $sale_wid_tax1 = round($sale_wid_tax, 2);
                
                //  $sale_with_tax = $in_house_sale + $tax;

                $sale_tax =  ($mrp * $igst) / 100;
                
                $in_house_sale = ($closingstock * $sale_wid_tax1);
                $tax = ($in_house_sale * $igst) / 100;
                
                


                $qty =  $get_stock[0]->total_qty;
                $total_sale += $in_house_sale;
                $total_purchase += $in_house_purchase;
                $total_purchase1 = round($total_purchase, 2);
                $total_sale1 = round($total_sale, 2);
                $mrp1 = round($mrp, 2);
                $purchase_wid_tax1 = round($purchase_wid_tax, 2);
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
        <td><b> $total_sale1</b></td>
        <td><b> $total_purchase1</b></td>
    </tr>";
    }

    public function adjus_medicine()
    {
        $id = $this->input->post('id');
        $adjus_medicine =  $this->purchase_model->adjus_medicine($id);
        //   echo "<pre>";
        //   print_r($adjus_medicine);
        foreach ($adjus_medicine as $val) {

            $pro_id = $val->product_id;
            $supplier_id = $val->supplier_id;
            $Batch_Number = $val->Batch_Number;
            $mrp = $val->mrp;
            $instock = $val->instock;
            $store_id = $val->store_id;

            $product_name =  $this->purchase_model->product_name($pro_id);
            $pro_name = $product_name[0]->product_name;

            $get_supplier_name =  $this->purchase_model->get_supplier_name($supplier_id);
            $sup_name = $get_supplier_name[0]->s_name;

            $store_name =  $this->purchase_model->get_store_name($store_id);
            // print_r($store_name);
            $store_name = $store_name->store_name;

            echo "<tr>
                <td><input type ='hidden' id='pro_id' name='pro_id[]' value='$pro_id'>$pro_name</td>
                <td><input type ='hidden' id='supplier_id' name='supplier_id[]' value='$supplier_id'>$sup_name</td>
                <td><input type ='hidden' id='Batch_Number' name='Batch_Number[]' value='$Batch_Number'>$Batch_Number</td>
                <td><input type ='hidden' id='mrp' name='mrp[]' value='$mrp'>$mrp</td>
                <td><input type ='hidden' id='instock' name='instock[]' value='$instock'>$instock</td>
                <td><input type ='hidden' id='store_id' name='store_id[]'' value='$store_id'>$store_name</td>
                <td><input type ='text' id='qty' name='qty[]'></td>
                <td><input type ='text' id='qty' name='add_qty[]'></td>
               </tr>";
        }
    }

    public function submit_adjust()
    {

        //---------------------------------------------------------------------------------------------------------------------------------------------------
        //  Minus Qty from Store medicine Meta , medicine Meta , Medicine Table
        //---------------------------------------------------------------------------------------------------------------------------------------------------
        foreach ($_POST['qty'] as $row => $name) {
            if (!empty($_POST['qty'][$row])) {
                $qty   =   $_POST['qty'][$row];
                $pro_id   =   $_POST['pro_id'][$row];
                $Batch_Number   =   $_POST['Batch_Number'][$row];
                $supplier_id        =   $_POST['supplier_id'][$row];
                $store_id        =   $_POST['store_id'][$row];
                $get_qty =  $this->purchase_model->get_qty($pro_id, $supplier_id, $Batch_Number, $store_id);
                $preinstock = $get_qty[0]->instock;
                $adjus_id = 'adjus' . rand(100, 50000);
                $timestamp = date('Y-m-d H:i:s');
                $data = array(
                    "adjus_id" => $adjus_id,
                    "product_id" => $pro_id,
                    "supplier_id" => $supplier_id,
                    "store_id" => $store_id,
                    "adjus_qty" => 'Subtracted' . ' ' . $qty,
                    "pre_instock" => $preinstock,
                    "created_at" => $timestamp
                );
                
                $insert_adjus =  $this->purchase_model->insert_adjus($data);
                // Update Store Medicine Meta
                $get_qty =  $this->purchase_model->get_qty($pro_id, $supplier_id, $Batch_Number, $store_id);
                if (!empty($get_qty)) {
                    $pre_stock = $get_qty[0]->instock;
                    $new_stock = $get_qty[0]->instock - $qty;
                    $data = array(
                        "instock" => $new_stock
                    );
                    //  print_r($data);
                    $update_store_med =  $this->purchase_model->update_store_med_store_qty($pro_id, $supplier_id, $Batch_Number, $store_id, $data);
                }



                // Update Medicine Meta

                $get_qty_med_meta =  $this->purchase_model->get_qty_med_meta($pro_id, $supplier_id, $Batch_Number);
                if (!empty($get_qty_med_meta)) {
                    $pre_stock1 = $get_qty_med_meta[0]->instock;
                    $new_stock1 = $pre_stock1 - $qty;

                    $data1 = array(
                        "instock" => $new_stock1
                    );

                     $update_store_med =  $this->purchase_model->Update_Medicine_meta($pro_id, $supplier_id, $Batch_Number, $data1);
                }


                // Update Medicine 
                $get_medi_stock =  $this->purchase_model->get_medicine_tbl_stock($pro_id);
                if (!empty($get_medi_stock)) {
                    $pre = $get_medi_stock[0]->instock;
                    $new = $pre - $qty;
                    $data2 = array(
                        "instock" =>  $new
                    );

                     $update_medicine_tbl =  $this->purchase_model->update_medicine_tbl($pro_id, $data2);
                }
            }
        }

        //---------------------------------------------------------------------------------------------------------------------------------------------------
        //  Add Qty from Store medicine Meta , medicine Meta , Medicine Table
        //------------------------------------------------------------------------------------------------------------------------------------------------------
        foreach ($_POST['add_qty'] as $row => $name) {
            if (!empty($_POST['add_qty'][$row])) {
                $qty   =   $_POST['add_qty'][$row];
                $pro_id   =   $_POST['pro_id'][$row];
                $Batch_Number   =   $_POST['Batch_Number'][$row];
                $supplier_id        =   $_POST['supplier_id'][$row];
                $store_id        =   $_POST['store_id'][$row];
                $get_qty =  $this->purchase_model->get_qty($pro_id, $supplier_id, $Batch_Number, $store_id);
                $preinstock = $get_qty[0]->instock;
                $adjus_id = 'adjus' . rand(100, 50000);
                $timestamp = date('Y-m-d H:i:s');
                $data = array(
                    "adjus_id" => $adjus_id,
                    "product_id" => $pro_id,
                    "supplier_id" => $supplier_id,
                    "store_id" => $store_id,
                    "adjus_qty" => 'Added' . ' ' . $qty,
                    "pre_instock" => $preinstock,
                    "created_at" => $timestamp
                );

                
                $insert_adjus =  $this->purchase_model->insert_adjus($data);
                // Update Store Medicine Meta
                $get_qty =  $this->purchase_model->get_qty($pro_id, $supplier_id, $Batch_Number, $store_id);
                if (!empty($get_qty)) {
                    $pre_stock = $get_qty[0]->instock;
                    $new_stock = $get_qty[0]->instock + $qty;
                    $data = array(
                        "instock" => $new_stock
                    );
                    //  print_r($data);
                    $update_store_med =  $this->purchase_model->update_store_med_store_qty($pro_id, $supplier_id, $Batch_Number, $store_id, $data);
                }



                // Update Medicine Meta

                $get_qty_med_meta =  $this->purchase_model->get_qty_med_meta($pro_id, $supplier_id, $Batch_Number);
                if (!empty($get_qty_med_meta)) {
                    $pre_stock1 = $get_qty_med_meta[0]->instock;
                    $new_stock1 = $pre_stock1 + $qty;

                    $data1 = array(
                        "instock" => $new_stock1
                    );

                    $update_store_med =  $this->purchase_model->Update_Medicine_meta($pro_id, $supplier_id, $Batch_Number, $data1);
                }


                // Update Medicine 
                $get_medi_stock =  $this->purchase_model->get_medicine_tbl_stock($pro_id);
                if (!empty($get_medi_stock)) {
                    $pre = $get_medi_stock[0]->instock;
                    $new = $pre + $qty;
                    $data2 = array(
                        "instock" =>  $new
                    );

                    $update_medicine_tbl =  $this->purchase_model->update_medicine_tbl($pro_id, $data2);
                }
            }
        }

        $response['status'] = 'success';
        $response['message'] = "Adjusted Successfully";
        $response['curl'] = base_url() . "Invantory/stock_adjushis";
        $this->output->set_output(json_encode($response));
    }

    // public function allmedicine()
    // {
    //     $jsonArray = json_decode(file_get_contents('php://input'), true);
    //     $branchname = $jsonArray['branch'];
    //     $branchid = $this->medicine_model->getbranchidwithname($branchname);
    //     $branchnaid = $branchid[0]->id;
    //     $data1 = $this->supplier_model->getmedicinewithstoremedicine($branchnaid);

    //     $output = '';

    //     foreach ($data1 as $product) {
    //         $product_id = $product->product_id;
    //         $productName = $this->supplier_model->getmedicinenamewithproid($product_id);
    //         $productName = $productName[0]->product_name;

    //         $jsonData = json_encode(array(
    //             "product_id" => $product_id,
    //             "product_name" => $productName
    //         ));
    //         $output .= $jsonData . ",\n";
    //     }


    //     $output = rtrim($output, ",\n");

    //     print_r($output);
    // }
    public function allmedicine()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $jsonArray = json_decode(file_get_contents('php://input'), true);
        if(!empty($jsonArray)){}else{

            $response['status'] = 'error';
            $response['message'] = "invalid request";
            print_r(json_encode($response));
            die;
        }
        
        
       
        $branchname = $jsonArray['branch'];
        $branchid = $this->medicine_model->getbranchidwithname($branchname);
        $branchnaid = $branchid[0]->id;
        $data1 = $this->supplier_model->getmedicinewithstoremedicine($branchnaid);
        // print_r($data1); 
        // die();
        $output = '';
        $i = 0;
        foreach ($data1 as $product) {
            $product_id = $product->product_id;
            $productName = $this->supplier_model->getmedicinenamewithproid($product_id);
            $productName = $productName[0]->product_name;
            $stock = 0;

            $jsonData = json_encode(array(
                "product_id" => $product_id,
                "product_name" => $productName,
                "stock" => $data1[$i]->instock
            ));
            $output .= $jsonData . ",\n";
            $i++;
        }


        $output = rtrim($output, ",\n");

        print_r($output);
    }else {
        $response['status'] = 'error';
            $response['message'] = "invalid request";
            print_r(json_encode($response));
            die;

    }
}




    // public function medication()
    // {

    //     $jsonArray = json_decode(file_get_contents('php://input'), true);
    //     print_r($jsonArray);

    //     $branchname =  $jsonArray['branch'];
    //     $duration = $jsonArray['duration'];
    //     $time = $jsonArray['time'];
    //     $patientname = $jsonArray['patient_name'];
    //     $branchid = $this->medicine_model->getbranchidwithname($branchname);
    //     $branchnaid = $branchid[0]->id;

    //     $ttime =  count(explode(",", $time));
    //     $qty = $ttime * $duration;


    //     $patientid = $jsonArray['patient_id'];

    //     $patientcheck = $this->medicine_model->Getpatientbyid($patientid);


    //     if (!empty($patientcheck)) {

    //         $existedpatient =  $this->medicine_model->getcidpatient($patientid);
    //         $cusid = $existedpatient[0]->c_id;
    //         echo  $cusid;
    //     } else {

    //         $cid    = 'C' . rand(100, 1000000);
    //         $type = "inpatient";
    //         $data = array(
    //             "patient_id" => $patientid,
    //             "c_id" => $cid,
    //             "c_name" => $patientname,
    //             "c_type" => $type,
    //             "store_id" => $branchnaid
    //         );
    //         $insertpatient =  $this->medicine_model->insertpatient($data);
    //     }
    // }

    public function medication()
    {

        $jsonArray = json_decode(file_get_contents('php://input'), true);
        

        $branchname =  $jsonArray['branch'];
        $duration = $jsonArray['duration'];
        $time = $jsonArray['time'];
        $patientname = $jsonArray['patient_name'];
        $branchid = $this->medicine_model->getbranchidwithname($branchname);
        $branchnaid = $branchid[0]->id;

        $ttime =  count(explode(",", $time));
        $qty = $ttime * $duration;


        $patientid = $jsonArray['patient_id'];

        $patientcheck = $this->medicine_model->Getpatientbyid($patientid);


        if (!empty($patientcheck)) {

            $existedpatient =  $this->medicine_model->getcidpatient($patientid);
            $cusid = $existedpatient[0]->c_id;
            echo  $cusid;
        } else {

            $cid    = 'C' . rand(100, 1000000);
            $type = "inpatient";
            $data = array(
                "patient_id" => $patientid,
                "c_id" => $cid,
                "c_name" => $patientname,
                "c_type" => $type,
                "store_id" => $branchnaid
            );
            $insertpatient =  $this->medicine_model->insertpatient($data);
        }
    }


    // public function Save_medication()
    // {
    //     date_default_timezone_set("Asia/Kolkata");
    //     $jsonArray = json_decode(file_get_contents('php://input'), true);

    //     if(!empty($jsonArray)){}else{

    //         $response['status'] = 'error';
    //         $response['message'] = "invalid request";
    //         print_r(json_encode($response));
    //         die;
    //     }






    //     $branchname =  $jsonArray['branch'];
    //     $patientname = $jsonArray['patient_name'];
    //     $product_id = $jsonArray['drug_name'];
    //     $branchid = $this->medicine_model->getbranchidwithname($branchname);
    //     $storeID = $branchid[0]->id;
    //     $cid    = 'C' . rand(100, 1000000);


    //     $duration = $jsonArray['duration'];
    //     $time = $jsonArray['time'];
    //     $ttime =  count(explode(",", $time));
    //     $qty = $ttime * $duration;
    //     $customer = 'Inpatient';
    //     // For Sales and sales_history table
    //     $salesid    =   'S' . rand(2000, 10000000);
    //     $invoice    =   rand(10000000, 50000000);
    //     $type = "inpatient";
    //     $gdiscount  =   0;
    //     $totamthis = 0;
    //     $tottaxhis = 0;







    //     // check if stock available.

    //     $medcheckstock = $this->medicine_model->GetMedStockid($product_id, $storeID);
    //     $medSTOCK = $medcheckstock[0]->instock;

    //     if ($medSTOCK >=  $qty) {






    //         // Check if customer exist in db

    //         $patientid = $jsonArray['patient_id'];
    //         $patientcheck = $this->medicine_model->Getpatientbyid($patientid);
    //         if (!empty($patientcheck)) {

    //             $existedpatient =  $this->medicine_model->getcidpatient($patientid);
    //             $cid = $existedpatient[0]->c_id;
    //         } else {


    //             $data = array(
    //                 "patient_id" => $patientid,
    //                 "c_id" => $cid,
    //                 "c_name" => $patientname,
    //                 "c_type" => $type,
    //                 "store_id" => $branchnaid
    //             );
    //             $sucess =  $this->medicine_model->insertpatient($data);
    //         }





    //         // Create sale with medicines

    //         $Allmeds = $this->medicine_model->GetMedbystore($product_id, $storeID);


    //         $dueMed = $qty;
    //         $laps = 1;
    //         foreach ($Allmeds as $med) {
    //             //echo $med->instock;




    //             if ($dueMed != 0) {


    //                 if ($med->instock >= $dueMed) {

    //                    // echo "Yes";
    //                     if ($laps == 0) {
    //                         $dueMed = $qty;
    //                     } else {
    //                     }






    //                     $entrydate  =   date("d/m/Y");
    //                     $sale_date = date('Y-m-d');
    //                     $p_mode   =  ' ';
    //                     $monthyear  =   date('Y-m');
    //                     $time = strtotime(date('Y-m-d H:i:s'));



    //                     // Get Medicine details from Store medicine mata table        
    //                     $medmrp = $this->medicine_model->Getmedmrpbyid($med->id);
                        

    //                     $mrp = isset($medmrp[0]->mrp) ? $medmrp[0]->mrp : 0;



    //                     // Get Medicine hasn details from medicine table  
    //                     $medHSN = $this->medicine_model->GetigstbyMedID($product_id);
    //                     $igst = $this->medicine_model->Getigstbyhsn($medHSN[0]->hsn);
    //                     $igsttot = isset($igst[0]->igst) ? $igst[0]->igst : 0;



    //                     $grandamount = $mrp * $dueMed;
                        
                            
    //                     $tottax = ($grandamount * $igsttot) / 100;
    //                     $totamt = $grandamount + $tottax;

    //                     $tottaxhis += ($grandamount * $igsttot) / 100;
    //                     $totamthis += $grandamount + $tottax;
                        



    //                     $payi =  ' ';
    //                     $duea = ' ';

    //                     $return =  ' ';
    //                     $walkin_cus_name = '';
    //                     $walkin_phone = '';
    //                     //$settings   = $this->configuration_model->getAllSettings();

    //                     //  $storeID = $settings->main_store_id;
    //                     //print_r($storeID);

    //                     if ($duea >= 0) {
    //                         $paya = $grandamount - $duea;
    //                     } elseif ($duea < 0) {
    //                         $paya = $grandamount;
    //                     }


    //                     $type = 'API';



    //                     if (!empty($cid)) {
    //                         //$customer = 'WalkIn';

    //                         $cbalance = $this->customer_model->GetCustomerBalance($cid);
    //                         //print_r($cbalance);
    //                         if (!empty($cbalance)) {
    //                             $total = $cbalance->total_balance + $totamt;

    //                             //  $paid = $cbalance->total_paid;
    //                             $paidval = $cbalance->total_paid;
    //                             $due = $total - $paidval;
    //                             $data = array();
    //                             $data = array(
    //                                 'total_balance' => $total,
    //                                 'total_paid' => $paidval,
    //                                 'total_due' => $due
    //                             );

    //                             $success = $this->invoice_model->Update_Customer_Balance($cid, $data);
    //                         }
    //                     }

    //                     if ($laps == 0) {

    //                         // Insert in sales_history            
    //                         $paid = $grandamount - $duea;
    //                         $data = array();
    //                         $data = array(
    //                             'sale_id' => $salesid,
    //                             'store_id' => $storeID,
    //                             'cus_id' => $cid,
    //                             'walkin_cus_name' => $patientname,
    //                             'walkin_phone' => '',
    //                             'entryid' => 'API001',
    //                             'invoice_no' => $invoice,
    //                             'total_discount' => $gdiscount,
    //                             'total_amount' => $totamt,
    //                             'total_tax' => $tottax,
    //                             'paid_amount' => 0,
    //                             'due_amount' => $totamt,
    //                             'create_date' => $entrydate,
    //                             'counter' => $type,
    //                             'pay_status' => 'Hold',
    //                             'payment_mode' => '',
    //                             'monthyear' => $monthyear,
    //                             'sales_time' => $time,
    //                             'sale_date' => $sale_date
    //                         );


    //                         $success = $this->invoice_model->Save_Sales($data);
    //                     } else {
    //                     }
    //                     if ($this->db->affected_rows()) {

    //                         $account = $this->user_model->GetAccountBalance();
    //                         if (!empty($account)) {
    //                             $id = $account->id;
    //                             $amount = $account->amount + $totamt;
    //                             $paid = $account->paid;
    //                             $due = $account->due + $totamt;
    //                             $data = array(
    //                                 'amount'   =>  $amount,
    //                                 'paid'      =>  $paid,
    //                                 'due'      =>  $due
    //                             );
    //                             $success = $this->user_model->UPDATE_ACCOUNT($id, $data);
    //                         }














    //                         $supplier_id  = isset($medmrp[0]->supplier_id) ? $medmrp[0]->supplier_id : 0;
    //                         $batch_no  = isset($medmrp[0]->Batch_Number) ? $medmrp[0]->Batch_Number : 0;
    //                         $exp   = isset($medmrp[0]->expire_date) ? $medmrp[0]->expire_date : '0000-00-00';



    //                         // Insert in sales_history
    //                         $data = array(
    //                             'sale_id'   =>  $salesid,
    //                             'mid'      =>  $product_id,
    //                             'qty'      => $dueMed,
    //                             'rate'      =>  $mrp,
    //                             "supplier_id"    => $supplier_id,
    //                             "Batch_Number"   =>  $batch_no,
    //                             'total_price' => $grandamount,
    //                             'discount'   =>  0,
    //                             'gdiscount' => 0,
    //                             "sale_date" => date('Y-m-d'),
    //                             "store_id" => $storeID,
    //                             'total_tax' => $tottax,
    //                             'grand_total' => $totamt


    //                         );
    //                         $success = $this->invoice_model->Save_Sales_History($data);




    //                         $medicine   =   $product_id;
    //                         $qty        =   $qty;
    //                         $mrp        =   $mrp;
    //                         $discount   =   0;
    //                         $total     =   $grandamount;
    //                         $supplier_id     =   $supplier_id;
    //                         $batch_no     =   $batch_no;
    //                         $exp_date     =   $exp;




    //                         $medicinestock = $this->purchase_model->getmedicineByMId($medicine);
    //                         $instock = $medicinestock->instock - $qty;
    //                         $soldqty = $medicinestock->sale_qty + $qty;

    //                         $data = array(
    //                             'instock'  =>  $instock,
    //                             'sale_qty'  =>  $soldqty
    //                         );
    //                         $success = $this->purchase_model->Update_Medicine($medicine, $data);




    //                         // Update  store_medicine_meta
    //                         $get_mmedicine_meta_stock = $this->purchase_model->get_mmedicine_meta_stock($medicine, $supplier_id, $batch_no);
    //                         $pre_stock = $get_mmedicine_meta_stock[0]->instock;
    //                         $sold_stock = $get_mmedicine_meta_stock[0]->sale_qty;

    //                         $qty_sold =  $dueMed;
    //                         $rest_qty = $pre_stock - $qty_sold;

    //                         $data15 = array(
    //                             'instock' => $rest_qty,
    //                             'sale_qty' => $sold_stock + $qty_sold
    //                         );
    //                         $Update_Medicine_meta = $this->purchase_model->Update_Medicine_meta($medicine, $supplier_id, $batch_no, $data15);




    //                         // Update  store_medicine_meta
    //                         $chk_med_store_stock = $this->purchase_model->chk_med_store_stock($medicine, $supplier_id, $batch_no, $storeID, $exp_date);
    //                         $pre = $chk_med_store_stock[0]->instock;
    //                         $sold_stock = $chk_med_store_stock[0]->sale_qty;

    //                         $new = $pre - $dueMed;
    //                         $qty_sold =  $dueMed;
    //                         $data = array(
    //                             "instock" => $new,
    //                             'sale_qty' => $sold_stock + $qty_sold

    //                         );
    //                         $update_med_store_stock = $this->purchase_model->update_med_store_stock($medicine, $supplier_id, $batch_no, $storeID, $exp_date, $data);

    //                         $response['status'] = 'success';
    //                         $response['message'] = "invoice created successfully. Id: ". $invoice ;
    //                         print_r(json_encode($response));
    //                     }
    //                     break;
    //                 } else {

    //                     //For multmedicine.
    //                     $entrydate  =   date("d/m/Y");
    //                     $sale_date = date('Y-m-d');
    //                     $p_mode   =  ' ';
    //                     $monthyear  =   date('Y-m');
    //                     $time = strtotime(date('Y-m-d H:i:s'));
    //                     $gdiscount  =   0;


    //                     // Get Medicine details from Store medicine mata table        
    //                     $medmrp = $this->medicine_model->Getmedmrpbyid($med->id);


    //                     $mrp = isset($medmrp[0]->mrp) ? $medmrp[0]->mrp : 0;



    //                     // Get Medicine hasn details from medicine table  
    //                     $medHSN = $this->medicine_model->GetigstbyMedID($product_id);
    //                     $igst = $this->medicine_model->Getigstbyhsn($medHSN[0]->hsn);
    //                     $igsttot = isset($igst[0]->igst) ? $igst[0]->igst : 0;



    //                     $grandamount = $mrp * $dueMed;
    //                     $tottax = ($grandamount * $igsttot) / 100;
    //                     $totamt = $grandamount + $tottax;

                        

    //                     $payi =  ' ';
    //                     $duea = ' ';

    //                     $return =  ' ';
    //                     $walkin_cus_name = '';
    //                     $walkin_phone = '';
    //                     //$settings   = $this->configuration_model->getAllSettings();

    //                     //  $storeID = $settings->main_store_id;
    //                     //print_r($storeID);

    //                     if ($duea >= 0) {
    //                         $paya = $grandamount - $duea;
    //                     } elseif ($duea < 0) {
    //                         $paya = $grandamount;
    //                     }


    //                     $type = 'API';



    //                     if (!empty($cid)) {
    //                         //$customer = 'WalkIn';

    //                         $cbalance = $this->customer_model->GetCustomerBalance($cid);
    //                         //print_r($cbalance);
    //                         if (!empty($cbalance)) {
    //                             $total = $cbalance->total_balance + $totamt;

    //                             //  $paid = $cbalance->total_paid;
    //                             $paidval = $cbalance->total_paid;
    //                             $due = $total - $paidval;
    //                             $data = array();
    //                             $data = array(
    //                                 'total_balance' => $total,
    //                                 'total_paid' => $paidval,
    //                                 'total_due' => $due
    //                             );

    //                             $success = $this->invoice_model->Update_Customer_Balance($cid, $data);
    //                         }
    //                     }







    //                     // Insert in sale history

    //                     $supplier_id  = isset($medmrp[0]->supplier_id) ? $medmrp[0]->supplier_id : 0;
    //                     $batch_no  = isset($medmrp[0]->Batch_Number) ? $medmrp[0]->Batch_Number : 0;
    //                     $exp   = isset($medmrp[0]->expire_date) ? $medmrp[0]->expire_date : '0000-00-00';

    //                     $chk_med_store_stock = $this->purchase_model->chk_med_store_stock($product_id, $supplier_id, $batch_no, $storeID, $exp);
    //                     $pre = $chk_med_store_stock[0]->instock;

    //                     $grandamount = $pre * $mrp;
    //                     $tottax = ($grandamount * $igsttot) / 100;
    //                     $totamt = $grandamount + $tottax;

    //                     $tottaxhis += ($grandamount * $igsttot) / 100;
    //                     $totamthis += $grandamount + $tottax;

    //                     $data = array(
    //                         'sale_id'   =>  $salesid,
    //                         'mid'      =>  $product_id,
    //                         'qty'      => $pre,
    //                         'rate'      =>  $mrp,
    //                         "supplier_id"    => $supplier_id,
    //                         "Batch_Number"   =>  $batch_no,
    //                         'total_price' => $pre * $mrp,
    //                         'discount'   =>  0,
    //                         'gdiscount' => 0,
    //                         "sale_date" => date('Y-m-d'),
    //                         "store_id" => $storeID,
    //                         'total_tax' => $tottax,
    //                         'grand_total' => $totamt


    //                     );
    //                     $success = $this->invoice_model->Save_Sales_History($data);




    //                     $medicine   =   $product_id;
    //                     $qty        =   $qty;
    //                     $mrp        =   $mrp;
    //                     $discount   =   0;
    //                     $total     =   $grandamount;
    //                     $supplier_id     =   $supplier_id;
    //                     $batch_no     =   $batch_no;
    //                     $exp_date     =   $exp;
    //                     // Update  medicine
    //                     if ($laps == 0) {

    //                         $medicinestock = $this->purchase_model->getmedicineByMId($medicine);
    //                         $instock = $medicinestock->instock - $qty;
    //                         $soldqty = $medicinestock->sale_qty + $qty;

    //                         $data = array(
    //                             'instock'  =>  $instock,
    //                             'sale_qty'  =>  $soldqty
    //                         );
    //                         $success = $this->purchase_model->Update_Medicine($medicine, $data);
    //                     } else {
    //                     }

    //                     // Update  medicine_meta
    //                     $get_mmedicine_meta_stock = $this->purchase_model->get_mmedicine_meta_stock($medicine, $supplier_id, $batch_no);
    //                     $pre_stock = $get_mmedicine_meta_stock[0]->instock;
    //                     $sold_stock = $get_mmedicine_meta_stock[0]->sale_qty;


    //                     $rest_qty = $pre_stock - $dueMed;
    //                     $qty_sold =  $dueMed;
    //                     $data15 = array(
    //                         'instock' => 0,
    //                         'sale_qty' => $sold_stock + $pre_stock
    //                     );
    //                     $Update_Medicine_meta = $this->purchase_model->Update_Medicine_meta($medicine, $supplier_id, $batch_no, $data15);

    //                     // Update  store_medicine_meta

    //                     $chk_med_store_stock = $this->purchase_model->chk_med_store_stock($medicine, $supplier_id, $batch_no, $storeID, $exp_date);
    //                     $pre = $chk_med_store_stock[0]->instock;
    //                     $sold_stock = $chk_med_store_stock[0]->sale_qty;

    //                     $new = $pre - $dueMed;
    //                     $qty_sold =  $dueMed;
    //                     $data = array(
    //                         "instock" => 0,
    //                         'sale_qty' => $sold_stock + $pre

    //                     );


    //                     echo $update_med_store_stock = $this->purchase_model->update_med_store_stock($medicine, $supplier_id, $batch_no, $storeID, $exp_date, $data);











    //                     //echo "No";
    //                     $dueMed = $dueMed - $med->instock;
    //                 }
    //             } else {

    //                 break;
    //             }
    //             // echo $dueMed."-";
    //             // echo $totamthis."-";
    //             // echo $tottaxhis."-";

    //             //End foreach  
    //             $laps++;
    //         }
    //         //Insert in sales Table         
    //         $data = array();
    //         $data = array(
    //             'sale_id' => $salesid,
    //             'store_id' => $storeID,
    //             'cus_id' => $cid,
    //             'walkin_cus_name' => $patientname,
    //             'walkin_phone' => '',
    //             'entryid' => 'API001',
    //             'invoice_no' => $invoice,
    //             'total_discount' => $gdiscount,
    //             'total_amount' => $totamthis,
    //             'total_tax' => $tottaxhis,
    //             'paid_amount' => 0,
    //             'due_amount' => $totamthis,
    //             'create_date' => $entrydate,
    //             'counter' => $type,
    //             'pay_status' => 'Hold',
    //             'payment_mode' => '',
    //             'monthyear' => $monthyear,
    //             'sales_time' => $time,
    //             'sale_date' => $sale_date
    //         );


    //         $success = $this->invoice_model->Save_Sales($data);




    //         $account = $this->user_model->GetAccountBalance();
    //         if (!empty($account)) {
    //             $id = $account->id;
    //             $amount = $account->amount + $totamt;
    //             $paid = $account->paid;
    //             $due = $account->due + $totamt;
    //             $data = array(
    //                 'amount'   =>  $amount,
    //                 'paid'      =>  $paid,
    //                 'due'      =>  $due
    //             );
    //             $success = $this->user_model->UPDATE_ACCOUNT($id, $data);
    //         }
            
    //     } else {

    //         if($medSTOCK == ''){$medSTOCK = 0;}else{}
    //         $response['status'] = 'error';
    //         $response['message'] = "Don't have enough requested medicine stock. Stock available only " . $medSTOCK;
    //         print_r(json_encode($response));
    //     }
    // }
    public function Save_medication()
    {
        date_default_timezone_set("Asia/Kolkata");
        $jsonArray = json_decode(file_get_contents('php://input'), true);

        if(!empty($jsonArray)){}else{

            $response['status'] = 'error';
            $response['message'] = "invalid request";
            print_r(json_encode($response));
            die;
        }






        $branchname =  $jsonArray['branch'];
        $patientname = $jsonArray['patient_name'];
        $product_id = $jsonArray['drug_name'];
        $branchid = $this->medicine_model->getbranchidwithname($branchname);
        $storeID = $branchid[0]->id;
        $cid    = 'C' . rand(100, 1000000);


        $duration = $jsonArray['duration'];
        $time = $jsonArray['time'];
        $ttime =  count(explode(",", $time));
        $qty = $ttime * $duration;
        $customer = 'Inpatient';
        // For Sales and sales_history table
        $salesid    =   'S' . rand(2000, 10000000);
        $invoice    =   rand(10000000, 50000000);
        $type = "inpatient";
        $gdiscount  =   0;
        $totamthis = 0;
        $tottaxhis = 0;
        






        // check if stock available.

        $medcheckstock = $this->medicine_model->GetMedStockid($product_id, $storeID);
        $medSTOCK = $medcheckstock[0]->instock;
        
       
        if ($medSTOCK >=  $qty) {






            // Check if customer exist in db

            $patientid = $jsonArray['patient_id'];
            $patientcheck = $this->medicine_model->Getpatientbyid($patientid);
            if (!empty($patientcheck)) {

                $existedpatient =  $this->medicine_model->getcidpatient($patientid);
                $cid = $existedpatient[0]->c_id;
            } else {


                $data = array(
                    "patient_id" => $patientid,
                    "c_id" => $cid,
                    "c_name" => $patientname,
                    "c_type" => $type,
                    "store_id" => $storeID
                );
                $sucess =  $this->medicine_model->insertpatient($data);
            }

            



            // Create sale with medicines

            $Allmeds = $this->medicine_model->GetMedbystore($product_id, $storeID);


            $dueMed = $qty;
            $laps = 0;
            foreach ($Allmeds as $med) {
                //echo $med->instock;




                if ($dueMed != 0) {


                    if ($med->instock >= $dueMed) {

                       
                        if ($laps == 0) {
                            $dueMed = $qty;
                        } else {
                        }






                        $entrydate  =   date("d/m/Y");
                        $sale_date = date('Y-m-d');
                        $p_mode   =  ' ';
                        $monthyear  =   date('Y-m');
                        $time = strtotime(date('Y-m-d H:i:s'));



                        // Get Medicine details from Store medicine mata table        
                        $medmrp = $this->medicine_model->Getmedmrpbyid($med->id);
                        

                        $mrp = isset($medmrp[0]->mrp) ? $medmrp[0]->mrp : 0;

                            
                        
                        // Get Medicine hasn details from medicine table  
                        $medHSN = $this->medicine_model->GetigstbyMedID($product_id);
                       
                        $igst = $this->medicine_model->Getigstbyhsn($medHSN[0]->hsn);
                        $igsttot = isset($igst[0]->igst) ? $igst[0]->igst : 0;



                        $grandamount = $mrp * $dueMed;
                        
                            
                        $tottax = ($grandamount * $igsttot) / 100;
                        $totamt = $grandamount + $tottax;

                        $tottaxhis += ($grandamount * $igsttot) / 100;
                        $totamthis += $grandamount + $tottax;
                        



                        $payi =  ' ';
                        $duea = ' ';

                        $return =  ' ';
                        $walkin_cus_name = '';
                        $walkin_phone = '';
                        //$settings   = $this->configuration_model->getAllSettings();

                        //  $storeID = $settings->main_store_id;
                        //print_r($storeID);

                        if ($duea >= 0) {
                            $paya = $grandamount - $duea;
                        } elseif ($duea < 0) {
                            $paya = $grandamount;
                        }


                        $type = 'API';



                        if (!empty($cid)) {
                            //$customer = 'WalkIn';

                            $cbalance = $this->customer_model->GetCustomerBalance($cid);
                            //print_r($cbalance);
                            if (!empty($cbalance)) {
                                $total = $cbalance->total_balance + $totamt;

                                //  $paid = $cbalance->total_paid;
                                $paidval = $cbalance->total_paid;
                                $due = $total - $paidval;
                                $data = array();
                                $data = array(
                                    'total_balance' => $total,
                                    'total_paid' => $paidval,
                                    'total_due' => $due
                                );

                                $success = $this->invoice_model->Update_Customer_Balance($cid, $data);
                            }
                        }
                        

                        if ($laps == 0) {
                            
                            // Insert in sales_history            
                            $paid = $grandamount - $duea;
                            $data = array();
                            $data = array(
                                'sale_id' => $salesid,
                                'store_id' => $storeID,
                                'cus_id' => $cid,
                                'walkin_cus_name' => $patientname,
                                'walkin_phone' => '',
                                'entryid' => 'API001',
                                'invoice_no' => $invoice,
                                'total_discount' => $gdiscount,
                                'total_amount' => $totamt,
                                'total_tax' => $tottax,
                                'paid_amount' => 0,
                                'due_amount' => $totamt,
                                'create_date' => $entrydate,
                                'counter' => $type,
                                'pay_status' => 'Hold',
                                'payment_mode' => '',
                                'monthyear' => $monthyear,
                                'sales_time' => $time,
                                'sale_date' => $sale_date
                            );


                            $success = $this->invoice_model->Save_Sales($data);
                            
                        } else {
                        }
                        if ($this->db->affected_rows()) {

                            $account = $this->user_model->GetAccountBalance();
                            if (!empty($account)) {
                                $id = $account->id;
                                $amount = $account->amount + $totamt;
                                $paid = $account->paid;
                                $due = $account->due + $totamt;
                                $data = array(
                                    'amount'   =>  $amount,
                                    'paid'      =>  $paid,
                                    'due'      =>  $due
                                );
                                $success = $this->user_model->UPDATE_ACCOUNT($id, $data);
                            }














                            $supplier_id  = isset($medmrp[0]->supplier_id) ? $medmrp[0]->supplier_id : 0;
                            $batch_no  = isset($medmrp[0]->Batch_Number) ? $medmrp[0]->Batch_Number : 0;
                            $exp   = isset($medmrp[0]->expire_date) ? $medmrp[0]->expire_date : '0000-00-00';



                            // Insert in sales_history
                            $data = array(
                                'sale_id'   =>  $salesid,
                                'mid'      =>  $product_id,
                                'qty'      => $dueMed,
                                'rate'      =>  $mrp,
                                "supplier_id"    => $supplier_id,
                                "Batch_Number"   =>  $batch_no,
                                'total_price' => $grandamount,
                                'discount'   =>  0,
                                'gdiscount' => 0,
                                "sale_date" => date('Y-m-d'),
                                "store_id" => $storeID,
                                'total_tax' => $tottax,
                                'grand_total' => $totamt


                            );
                            $success = $this->invoice_model->Save_Sales_History($data);




                            $medicine   =   $product_id;
                            $qty        =   $qty;
                            $mrp        =   $mrp;
                            $discount   =   0;
                            $total     =   $grandamount;
                            $supplier_id     =   $supplier_id;
                            $batch_no     =   $batch_no;
                            $exp_date     =   $exp;




                            $medicinestock = $this->purchase_model->getmedicineByMId($medicine);
                            $instock = $medicinestock->instock - $qty;
                            $soldqty = $medicinestock->sale_qty + $qty;

                            $data = array(
                                'instock'  =>  $instock,
                                'sale_qty'  =>  $soldqty
                            );
                            $success = $this->purchase_model->Update_Medicine($medicine, $data);




                            // Update  store_medicine_meta
                            $get_mmedicine_meta_stock = $this->purchase_model->get_mmedicine_meta_stock($medicine, $supplier_id, $batch_no);
                            $pre_stock = $get_mmedicine_meta_stock[0]->instock;
                            $sold_stock = $get_mmedicine_meta_stock[0]->sale_qty;

                            $qty_sold =  $dueMed;
                            $rest_qty = $pre_stock - $qty_sold;

                            $data15 = array(
                                'instock' => $rest_qty,
                                'sale_qty' => $sold_stock + $qty_sold
                            );
                            $Update_Medicine_meta = $this->purchase_model->Update_Medicine_meta($medicine, $supplier_id, $batch_no, $data15);




                            // Update  store_medicine_meta
                            $chk_med_store_stock = $this->purchase_model->chk_med_store_stock($medicine, $supplier_id, $batch_no, $storeID, $exp_date);
                            $pre = $chk_med_store_stock[0]->instock;
                            $sold_stock = $chk_med_store_stock[0]->sale_qty;

                            $new = $pre - $dueMed;
                            $qty_sold =  $dueMed;
                            $data = array(
                                "instock" => $new,
                                'sale_qty' => $sold_stock + $qty_sold

                            );
                            $update_med_store_stock = $this->purchase_model->update_med_store_stock($medicine, $supplier_id, $batch_no, $storeID, $exp_date, $data);

                            $response['status'] = 'success';
                            $response['message'] = "invoice created successfully. Id: ". $invoice ;
                            print_r(json_encode($response));
                            
                        }
                        break;
                    } else {

                        //For multmedicine.
                        $entrydate  =   date("d/m/Y");
                        $sale_date = date('Y-m-d');
                        $p_mode   =  ' ';
                        $monthyear  =   date('Y-m');
                        $time = strtotime(date('Y-m-d H:i:s'));
                        $gdiscount  =   0;


                        // Get Medicine details from Store medicine mata table        
                        $medmrp = $this->medicine_model->Getmedmrpbyid($med->id);


                        $mrp = isset($medmrp[0]->mrp) ? $medmrp[0]->mrp : 0;



                        // Get Medicine hasn details from medicine table  
                        $medHSN = $this->medicine_model->GetigstbyMedID($product_id);
                        $igst = $this->medicine_model->Getigstbyhsn($medHSN[0]->hsn);
                        $igsttot = isset($igst[0]->igst) ? $igst[0]->igst : 0;



                        $grandamount = $mrp * $dueMed;
                        $tottax = ($grandamount * $igsttot) / 100;
                        $totamt = $grandamount + $tottax;

                        

                        $payi =  ' ';
                        $duea = ' ';

                        $return =  ' ';
                        $walkin_cus_name = '';
                        $walkin_phone = '';
                        //$settings   = $this->configuration_model->getAllSettings();

                        //  $storeID = $settings->main_store_id;
                        //print_r($storeID);

                        if ($duea >= 0) {
                            $paya = $grandamount - $duea;
                        } elseif ($duea < 0) {
                            $paya = $grandamount;
                        }


                        $type = 'API';



                        if (!empty($cid)) {
                            //$customer = 'WalkIn';

                            $cbalance = $this->customer_model->GetCustomerBalance($cid);
                            //print_r($cbalance);
                            if (!empty($cbalance)) {
                                $total = $cbalance->total_balance + $totamt;

                                //  $paid = $cbalance->total_paid;
                                $paidval = $cbalance->total_paid;
                                $due = $total - $paidval;
                                $data = array();
                                $data = array(
                                    'total_balance' => $total,
                                    'total_paid' => $paidval,
                                    'total_due' => $due
                                );

                                $success = $this->invoice_model->Update_Customer_Balance($cid, $data);
                            }
                        }







                        // Insert in sale history

                        $supplier_id  = isset($medmrp[0]->supplier_id) ? $medmrp[0]->supplier_id : 0;
                        $batch_no  = isset($medmrp[0]->Batch_Number) ? $medmrp[0]->Batch_Number : 0;
                        $exp   = isset($medmrp[0]->expire_date) ? $medmrp[0]->expire_date : '0000-00-00';

                        $chk_med_store_stock = $this->purchase_model->chk_med_store_stock($product_id, $supplier_id, $batch_no, $storeID, $exp);
                        $pre = $chk_med_store_stock[0]->instock;

                        $grandamount = $pre * $mrp;
                        $tottax = ($grandamount * $igsttot) / 100;
                        $totamt = $grandamount + $tottax;

                        $tottaxhis += ($grandamount * $igsttot) / 100;
                        $totamthis += $grandamount + $tottax;

                        $data = array(
                            'sale_id'   =>  $salesid,
                            'mid'      =>  $product_id,
                            'qty'      => $pre,
                            'rate'      =>  $mrp,
                            "supplier_id"    => $supplier_id,
                            "Batch_Number"   =>  $batch_no,
                            'total_price' => $pre * $mrp,
                            'discount'   =>  0,
                            'gdiscount' => 0,
                            "sale_date" => date('Y-m-d'),
                            "store_id" => $storeID,
                            'total_tax' => $tottax,
                            'grand_total' => $totamt


                        );
                        $success = $this->invoice_model->Save_Sales_History($data);




                        $medicine   =   $product_id;
                        $qty        =   $qty;
                        $mrp        =   $mrp;
                        $discount   =   0;
                        $total     =   $grandamount;
                        $supplier_id     =   $supplier_id;
                        $batch_no     =   $batch_no;
                        $exp_date     =   $exp;
                        // Update  medicine
                        if ($laps == 0) {

                            $medicinestock = $this->purchase_model->getmedicineByMId($medicine);
                            $instock = $medicinestock->instock - $qty;
                            $soldqty = $medicinestock->sale_qty + $qty;

                            $data = array(
                                'instock'  =>  $instock,
                                'sale_qty'  =>  $soldqty
                            );
                            $success = $this->purchase_model->Update_Medicine($medicine, $data);
                        } else {
                        }

                        // Update  medicine_meta
                        $get_mmedicine_meta_stock = $this->purchase_model->get_mmedicine_meta_stock($medicine, $supplier_id, $batch_no);
                        $pre_stock = $get_mmedicine_meta_stock[0]->instock;
                        $sold_stock = $get_mmedicine_meta_stock[0]->sale_qty;


                        $rest_qty = $pre_stock - $dueMed;
                        $qty_sold =  $dueMed;
                        $data15 = array(
                            'instock' => 0,
                            'sale_qty' => $sold_stock + $pre_stock
                        );
                        $Update_Medicine_meta = $this->purchase_model->Update_Medicine_meta($medicine, $supplier_id, $batch_no, $data15);

                        // Update  store_medicine_meta

                        $chk_med_store_stock = $this->purchase_model->chk_med_store_stock($medicine, $supplier_id, $batch_no, $storeID, $exp_date);
                        $pre = $chk_med_store_stock[0]->instock;
                        $sold_stock = $chk_med_store_stock[0]->sale_qty;

                        $new = $pre - $dueMed;
                        $qty_sold =  $dueMed;
                        $data = array(
                            "instock" => 0,
                            'sale_qty' => $sold_stock + $pre

                        );


                        echo $update_med_store_stock = $this->purchase_model->update_med_store_stock($medicine, $supplier_id, $batch_no, $storeID, $exp_date, $data);











                        //echo "No";
                        $dueMed = $dueMed - $med->instock;
                    }
                } else {

                    break;
                }
                // echo $dueMed."-";
                // echo $totamthis."-";
                // echo $tottaxhis."-";

                //End foreach  
                $laps++;
            }
            //Insert in sales Table         
            $data = array();
            $data = array(
                'sale_id' => $salesid,
                'store_id' => $storeID,
                'cus_id' => $cid,
                'walkin_cus_name' => $patientname,
                'walkin_phone' => '',
                'entryid' => 'API001',
                'invoice_no' => $invoice,
                'total_discount' => $gdiscount,
                'total_amount' => $totamthis,
                'total_tax' => $tottaxhis,
                'paid_amount' => 0,
                'due_amount' => $totamthis,
                'create_date' => $entrydate,
                'counter' => $type,
                'pay_status' => 'Hold',
                'payment_mode' => '',
                'monthyear' => $monthyear,
                'sales_time' => $time,
                'sale_date' => $sale_date
            );


            $success = $this->invoice_model->Save_Sales($data);




            $account = $this->user_model->GetAccountBalance();
            if (!empty($account)) {
                $id = $account->id;
                $amount = $account->amount + $totamt;
                $paid = $account->paid;
                $due = $account->due + $totamt;
                $data = array(
                    'amount'   =>  $amount,
                    'paid'      =>  $paid,
                    'due'      =>  $due
                );
                $success = $this->user_model->UPDATE_ACCOUNT($id, $data);
            }
            
        } else {

            if($medSTOCK == ''){$medSTOCK = 0;}else{}

            $response['status'] = 'error';
            $response['message'] = "Don't have enough requested medicine stock. Stock available only " . $medSTOCK;
            print_r(json_encode($response));
        }
    }
    public function doctors()
    {
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
    if (in_array(77, $permissions)) {
        return $doctors = $this->help_model->GetDoctorInfo();
        
        
    } else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
    }
    else{
        redirect(base_url() , 'refresh');
    } 
    }

    public function getdoctors()
    {
        if($this->session->userdata('user_login_access') != False) {
            
   
        return $doctors = $this->help_model->GetDoctorInfo();
        
        
   
    }
    else{
        redirect(base_url() , 'refresh');
    } 
    }
    
}
