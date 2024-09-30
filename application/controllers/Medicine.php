<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Medicine extends CI_Controller {



	    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->model('supplier_model');
        $this->load->model('medicine_model');
        $this->load->model('Hsn_model');
        global $pic;
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

    public function Create(){
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                if (in_array(19, $permissions)) {
        $data = array();
        $data['supplierList'] = $this->supplier_model->getAllSupplier();   
        $data['companylist'] = $this->medicine_model->getAllCompany();
        $data['medforms'] = $this->medicine_model->getAllunitsForm();      
        $this->load->view('backend/Add_medicine',$data);
    }
    else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
        }

    else{

		redirect(base_url() , 'refresh');

	}        

    }

    public function View(){

        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                if (in_array(18, $permissions)) {
            $data['medicineList'] = $this->medicine_model->getAllMedicine();
            $data['companylist'] = $this->medicine_model->getAllCompany();
            $data['supplierList'] = $this->medicine_model->get_manufacturer();
            $data['hsnList'] = $this->Hsn_model->getAllHsn();
            $data['unitList'] = $this->medicine_model->getAllUnits();
            $data['medforms'] = $this->medicine_model->getAllunitsForm();
            $data['permissions1'] = $this->permissionsbyemrole();
            $this->load->view('backend/List_medicine',$data);
        }
        else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
        }
        else{
    		redirect(base_url() , 'refresh');
    	}            
    }

    public function getAllunitsFormID($id){
        

    return $this->medicine_model->getAllunitsFormID($id);


       // print_r($data);


    }



    public function edit_med(){

        if($this->session->userdata('user_login_access') != False) {

            $product_id = $_GET['pid'];

            $data['mvalue'] = $this->medicine_model->GetMedicineValueById($product_id );

            $data['medicineList'] = $this->medicine_model->getAllMedicine();
            $data['companylist'] = $this->medicine_model->getAllCompany();
            $data['supplierList'] = $this->medicine_model->get_manufacturer();
            $data['hsnList'] = $this->Hsn_model->getAllHsn();
            $data['unitList'] = $this->medicine_model->getAllUnits();
            $data['medforms'] = $this->medicine_model->getAllunitsForm();
            
            $this->load->view('backend/edit_med',$data);
        }
        else{
    		redirect(base_url() , 'refresh');
    	}            
    }
    public function checkmedicinename(){
        $medname = $this->input->post('product_name');

        $supplier = $this->supplier_model->checkmedname($medname);
        if(!empty($supplier)){ echo "error";}else{echo "success";}

    }
    public function Save(){
        
        $supplier_id        = $this->input->post('supplier');
        $product_name       = $this->input->post('product_name');
        $generic_name       = $this->input->post('generic_name');
        $fa                 = $this->input->post('favourite');
        $productid          = 'P'.rand(100,50000);   
        $storeshort_stock       = $this->input->post('storeshort_stock');
        $min_orderqty       = $this->input->post('min_orderqty');
        $max_orderqty       = $this->input->post('max_orderqty');
        $reorder_qty       = $this->input->post('reorder_qty');
        $batchno            = $this->input->post('barcode');        
        $strength           = $this->input->post('strength');
        $form               = $this->input->post('formSelect');
        $box_size           = $this->input->post('box_size');
        $trade_price        = $this->input->post('trade_price');
        $mrp                = $this->input->post('mrp');
        $discount           = $this->input->post('discount');
        $box_price          = $this->input->post('box_price');
        $side_effect        = $this->input->post('side_effect');
        $expire_date        = $this->input->post('expire_date');
        $shortstock         = $this->input->post('shortstock');
        $caruntdate         = date("m-d-Y");
        if($fa==''){
        $favourite = '0';
        } else {
            $favourite = $fa;
        }
        $this->load->library('image_lib');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('product_name', 'name', 'trim|required|min_length[1]|max_length[150]|xss_clean');
        $this->form_validation->set_rules('generic_name', 'Generic', 'trim|xss_clean');
        $this->form_validation->set_rules('supplier', 'Company', 'trim|required|min_length[1]|max_length[250]|xss_clean');
        if($this->form_validation->run() == FALSE){
		    $response['status'] = 'error';
            $response['message'] = validation_errors();
            $this->output->set_output(json_encode($response));
        }
         else {
         if($_FILES['webcam']['name']){
            $file_name = $_FILES['webcam']['name'];
			$fileSize = $_FILES["webcam"]["size"]/1024;
			$fileType = $_FILES["webcam"]["type"];
			$new_file_name='';
            $new_file_name .= $productid;


            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./assets/images/medicine",
                'allowed_types' => "gif|jpg|png|jpeg|webp",
                'overwrite' => False,
                'max_size' => "40480000", // Can be set to particular file size , here it is 4 MB(2048 Kb)
                'max_height' => "4300",
                'max_width' => "4000"
            );
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('webcam')) {
                $response['status'] = 'error';
                $response['message'] = $this->upload->display_errors();
               // $response['url'] = "https://browncrystal.com/mad-pharma/Medicine/View";
                $this->output->set_output(json_encode($response)); 
			}

			else {
            $image_data =   $this->upload->data();
            $configer =  array(
              'image_library'   => 'gd2',
              'source_image'    =>  $image_data['full_path'],    
              'maintain_ratio'  =>  TRUE,
              'width'           =>  160,
              'height'          =>  100,
            );
            $this->image_lib->clear();
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();
                
                $path = $this->upload->data();
                $product_image = $path['file_name'];
                $data = array();
                $data = array(
                    'product_id' => $productid,
                    'batch_no' => $batchno,
                    'manufacturer_id' => $supplier_id,
                    'product_name' => $product_name,
                    'generic_name' => $generic_name,
                    'strength' => $strength,
                    'form' => $form,
                    'storeshort_stock' => $storeshort_stock,
                    'min_orderqty' => $min_orderqty,
                    'max_orderqty' => $max_orderqty,
                    'reorder_qty' => $reorder_qty,
                    'box_size' => $box_size,
                    'trade_price' => $trade_price,
                    'mrp' => $mrp,
                    'box_price'=>$box_price,
                    'side_effect'=>$side_effect,
                    'product_image'=> $product_image,
                    'expire_date'=> $expire_date,
                    'short_stock'=> $shortstock,
                    'instock'=> 0,
                    'favourite'=> $favourite,
                    'discount'=> $discount,
                    'date'=> strtotime($caruntdate)
                );
                    $success = $this->medicine_model->Add_medicine_info($data);
                    if($this->db->affected_rows()){
		              //load library
        		      $this->load->library('zend');
        		      //load in folder Zend
        		      $this->zend->load('Zend/Barcode');
        		      //generate barcode
                      $barcode = $batchno;
        		      $file = Zend_Barcode::draw('code128', 'image', array('text' => $barcode,'barHeight'=> 30), array());
                      $store_image = imagepng($file,"./assets/images/barcode/{$barcode}.png");                        
                    $response['status'] = 'success';
                    $response['message'] = "Successfully Added";
                    $response['curl'] = base_url()."Medicine/View";
                    $this->output->set_output(json_encode($response));                        
                    }    
            }

        } else {
                $data = array();
                $data = array(
                    'product_id' => $productid,
                    'batch_no' => $batchno,
                    'manufacturer_id' => $supplier_id,
                    'product_name' => $product_name,
                    'generic_name' => $generic_name,
                    'strength' => $strength,
                    'form' => $form,
                    'storeshort_stock' => $storeshort_stock,
                    'min_orderqty' => $min_orderqty,
                    'max_orderqty' => $max_orderqty,
                    'reorder_qty' => $reorder_qty,
                    'box_size' => $box_size,
                    'trade_price' => $trade_price,
                    'mrp' => $mrp,
                    'box_price'=>$box_price,
                    'side_effect'=>$side_effect,
                    'favourite'=> $favourite,
                    'discount'=> $discount,
                    'expire_date'=> $expire_date,
                    'short_stock'=> $shortstock,
                    'instock'=> 0
                );
                    $success = $this->medicine_model->Add_medicine_info($data);
                    if($this->db->affected_rows()){
		              //load library
        		      $this->load->library('zend');
        		      //load in folder Zend
        		      $this->zend->load('Zend/Barcode');
        		      //generate barcode
                      $barcode = $batchno;
        		      $file = Zend_Barcode::draw('code128', 'image', array('text' => $barcode,'barHeight'=> 30), array());
                      $store_image = imagepng($file,"./assets/images/barcode/{$barcode}.png");                        
                        $response['status'] = 'success';
                        $response['message'] = "Successfully Added";
                        $response['curl'] = base_url()."Medicine/View";
                        $this->output->set_output(json_encode($response));                        
                    }    

            }

        }

    }

    
    public function Save_Canvas(){
        
         $supplier_id        = $this->input->post('supplier');
         $product_name       = $this->input->post('product_name');
         $generic_name       = $this->input->post('generic_name');
         $strength           = $this->input->post('strength');
         $formSelect         = $this->input->post('formSelect');
         $subformSelect      = substr($this->input->post('subformSelect'), 1);
         $shortstock         = $this->input->post('shortstock');
         $storeshortstock    = $this->input->post('storeshort_stock');
         $minimum            = $this->input->post('min_orderqty');
         $maximum            = $this->input->post('max_orderqty');
         $reorder            = $this->input->post('reorder_qty');
         $hsn                = $this->input->post('hsn');
         $side_effect        = $this->input->post('side_effect');;
         $product_image      = $this->input->post('product_image');
        // $exp_date           = $this->input->post('exp_date');
         $productid          = 'P'.rand(100,50000);   
         $caruntdate         = date("m-d-Y");
         $unit        = $this->input->post('unit');
        $this->load->library('image_lib');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
       
        $this->form_validation->set_rules('product_name', 'name', 'trim|required');
        if($this->form_validation->run() == FALSE){
		    $response['status'] = 'error';
            $response['message'] = validation_errors();
            $this->output->set_output(json_encode($response));
        } 
        else {
        $img = $_POST['dataURL'];
                $data = array();
                $data = array(
                    'product_id' => $productid,
                     'manufacturer_id' => $supplier_id,
                     'product_name' => $product_name,
                     'generic_name' => $generic_name, 
                     'strength'=>$strength,
                     'form'=> $formSelect,
                     'subform' =>$subformSelect,
                     'short_stock'=> $shortstock,
                    'min_orderqty' => $minimum,
                    'max_orderqty' => $maximum,
                    'reorder_qty' => $reorder,
                    //'unit'       => $unit,


                     'storeshort_stock' => $storeshortstock,
                     'hsn'=> $hsn,
                     'side_effect'=> $side_effect,
                     'product_image'=> $product_image,
                    'date'=> strtotime($caruntdate),
                    //'expire_date' => $exp_date,
                );
                
                    $success = $this->medicine_model->Add_medicine_info($data);
                    if($success){
                        $response['status'] = 'success';
                        $response['message'] = "Successfully Updated";
                        $response['curl'] = base_url()."Medicine/View";
                        $this->output->set_output(json_encode($response));
                    }
             
              
        }

    }
    public function image_upload()
    {
            if($_FILES['webcam']['name']){
            $file_name = $_FILES['webcam']['name'];
			$fileSize = $_FILES["webcam"]["size"]/1024;
			$fileType = $_FILES["webcam"]["type"];
			$new_file_name='';
           // $new_file_name .= $productid;


            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./assets/images/medicine",
                'allowed_types' => "gif|jpg|png|jpeg|webp",
                'overwrite' => False,
                'max_size' => "40480000", // Can be set to particular file size , here it is 4 MB(2048 Kb)
                'max_height' => "4300",
                'max_width' => "4000"
            );
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('webcam')) {
                $this->output->set_output(json_encode($response)); 
			}
        } 
    }

    public function Update(){
        
       if(count($this->input->post('medSUBforms')) > 1){



        $subForms           = implode(',',$this->input->post('medSUBforms'));
       }else {

            $subFormsArray  = $this->input->post('medSUBforms');
            $subForms = $subFormsArray[0];
       }
        
        //$id      =  $this->input->get('id');
        
        $id               = $_POST['id'];
        $supplier_id        = $this->input->post('supplier_name');
        $product_name       = $this->input->post('product_name');
        $generic_name       = $this->input->post('generic_name');
        $storeshortstock    = $this->input->post('storeshort_stock');
         $minimum            = $this->input->post('min_orderqty');
         $maximum            = $this->input->post('max_orderqty');
         $reorder            = $this->input->post('reorder_qty');  
         $form               = $this->input->post('formSelect');
         
         $subformSelect      = $subForms;//substr($this->input->post('subformSelect'), 1);
        // $Batch_Number       = $this->input->post('Batch_Number'); 
        // $manf_date          = $this->input->post('manf_date');        
        // $exp_date           = $this->input->post('exp_date');
        //$quan_approve       = $this->input->post('quan_approve'); 
        // $purchase_rate      = $this->input->post('purchase_rate'); 
        // $purchase      = $this->input->post('purchase'); 
        // $sale_rate          = $this->input->post('sale_rate');           
        $strength           = $this->input->post('strength');
         $formSelect         = $this->input->post('formSelect');

       // $box_size           = $this->input->post('box_size');
      //  $box_price           = $this->input->post('box_price');
       // $unit_price         = $this->input->post('unit_price');
        $shortstock         = $this->input->post('shortstock');
        $hsn                = $this->input->post('hsn');
       // $cgst               = $this->input->post('cgst');
       // $sgst               = $this->input->post('sgst');
       // $Igst               = $this->input->post('Igst');
        $side_effect        = $this->input->post('side_effect');
       // $side_effect          = $this->input->post('side_effect');
       // $discount           = $this->input->post('discount');
       //$unit        = $this->input->post('unit');
        // if($favourite==''){
        // $favourite = '0';
        // } else {
        //     $favourite = $fa;
        // }
        
        $pic = array(); 
        $caruntdate         = date("m-d-Y");
        $this->load->library('form_validation');
        $this->load->library('image_lib');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('product_name', 'name', 'trim|required|min_length[1]|max_length[150]|xss_clean');
        $this->form_validation->set_rules('generic_name', 'Generic', 'trim|xss_clean');
        //$this->form_validation->set_rules('supplier', 'Company', 'trim|required|min_length[1]|max_length[250]|xss_clean');
        if($this->form_validation->run() == FALSE){
		    $response['status'] = 'error';
            $response['message'] = validation_errors();
            $this->output->set_output(json_encode($response));
        } else {  
            $photoName = $_FILES["product_image"]["name"];
            
            if(!empty($photoName))
            {
                $file_name = $_FILES['product_image']['name'];
                $fileSize = $_FILES["product_image"]["size"]/1024;
                $fileType = $_FILES["product_image"]["type"];
                $new_file_name='';
                $new_file_name .= $id;
               
                $pic[] = $new_file_name;
              
                $config = array(
                    'file_name' => $photoName,
                    'upload_path' => "./assets/images/medicine",
                    'allowed_types' => "gif|jpg|png|jpeg|webp",
                    'overwrite' => False,
                    'max_size' => "40480000", // Can be set to particular file size , here it is 4 MB(2048 Kb)
                    'max_height' => "4000",
                    'max_width' => "4000"
                );
                $this->load->library('Upload', $config);
                $this->upload->initialize($config);                
                if (!$this->upload->do_upload('product_image')) {
                    $response['status'] = 'error';
                    $response['message'] = $this->upload->display_errors(); 
                }
               $product_image =  $pic[0].'.jpg';
               
                $udata = array(
                     'manufacturer_id' => $supplier_id,
                    'product_name' => $product_name,
                    'generic_name' => $generic_name,
                //     'Batch_Number' => $Batch_Number,
                //     'manf_date' => $manf_date,
                //     'exp_date' => $exp_date,
                //     //'quan_approve' => $quan_approve,
                //     'purchase_rate' => $purchase_rate,
                //     'purchase'=> $purchase,
                //     'sale_rate'=>$sale_rate,
                'min_orderqty' => $minimum,
                    'max_orderqty' => $maximum,
                    'reorder_qty' => $reorder,
                     'storeshort_stock' => $storeshortstock,
                     'strength'=>$strength,
                       'form'=> $formSelect,
                       'subform'=>$subformSelect,
                //     'box_size'=> $box_size,
                //      'box_price' => $box_price,
                //     'unit_price'=> $unit_price,
                //     //'instock'=> 0,
                     'short_stock'=> $shortstock,
                     'hsn'=> $hsn,
                //     'unit' => $unit,
                //     'cgst'=> $cgst,
                //     'sgst'=> $sgst,
                //     'Igst'=> $Igst,
                     'side_effect'=> $side_effect,
                //     'favourite'=> $favourite,
                //     'discount'=> $discount,
                     'form' => $form,
                    'product_image'=> $photoName,
                    'date'=> strtotime($caruntdate)
                );
                
                    $success = $this->medicine_model->Update_medicine_info($id,$udata);
                    $response['status'] = 'success';
                    $response['message'] = "Successfully Updated";
                    $response['curl'] = base_url()."Medicine/View";
                    $this->output->set_output(json_encode($response));
            }
            else{
             
             
                $udata = array(
                    'manufacturer_id' => $supplier_id,
                    'product_name' => $product_name,
                    'generic_name' => $generic_name,
                    'min_orderqty' => $minimum,
                    'max_orderqty' => $maximum,
                    'reorder_qty' => $reorder,
                   'storeshort_stock' => $storeshortstock,
                    // 'Batch_Number' => $Batch_Number,
                    // 'manf_date' => $manf_date,
                    // 'exp_date' => $exp_date,
                    //'quan_approve' => $quan_approve,
                    // 'purchase_rate' => $purchase_rate,
                    // 'purchase'=> $purchase,
                    // 'sale_rate'=>$sale_rate,
                     'strength'=>$strength,
                     'form'=> $formSelect,
                     'subform'=>$subformSelect,
                    // 'box_size'=> $box_size,
                    //  'box_price' => $box_price,
                    // 'unit_price'=> $unit_price,
                    // //'instock'=> 0,
                     'short_stock'=> $shortstock,
                     'hsn'=> $hsn,
                    // 'cgst'=> $cgst,
                    // 'sgst'=> $sgst,
                    // 'Igst'=> $Igst,
                     'side_effect'=> $side_effect,
                     'form' => $form,
                    // 'unit'  => $unit,
                    // 'favourite'=> $favourite,
                    // 'discount'=> $discount,
                    
                    'date'=> strtotime($caruntdate)
                );
                    
                    $success = $this->medicine_model->Update_medicine_info($id,$udata);
                    $response['status'] = 'success';
                    $response['message'] = "Successfully Updated";
                    $response['curl'] = base_url()."Medicine/View";
                    $this->output->set_output(json_encode($response));
            }
            

      
        
        }
    }

    /*//delete 
    public function Delete(){
       $id      =  $this->input->get('id');
       $data['medicine']   = $this->medicine_model->DeleteMedicineID($id);
       echo "Successfully Deleted";
       redirect(base_url().'medicine/view','refresh');
      
    }*/

    public function GetMedicineById(){ 
        if($this->session->userdata('user_login_access') != False) {
		$id= $this->input->get('id');
        $data= array();
		$data['mvalue'] = $this->medicine_model->GetMedicineValueById($id);
		echo json_encode($data);
        }
        else{
    		redirect(base_url() , 'refresh');
    	}        
    }

    public function GetBarcodeDom(){ 
        if($this->session->userdata('user_login_access') != False) {
		$mid= $this->input->get('id');
		$mvalue = $this->medicine_model->GetMedicineValueById($mid);
        $manufacturer = $this->medicine_model->GetManufacturerValueById($mvalue->manufacturer_id);

                $base = base_url();
		if($mvalue->product_image != ''){$medImg = $mvalue->product_image;}else{$medImg = 'capsules.png';}
                echo "<div class='modal-body'>
            <div class='card-body'>
                <table style='width:100%'>
                <tr><td style='text-align:center;padding-bottom: 10px;' colspan='2'><img height='150px' width='150px' class='' src='$base/assets/images/medicine/$medImg' alt='Medicine image'></td></tr>
                <tr>
                <td>Manufacturer:</td>
                <td>$manufacturer->m_name</td>
                </tr>
                <tr>
                    <td>Product Name:</td>
                    <td>$mvalue->product_name($mvalue->strength)</td>
                    
                </tr>
                <tr>
                <td>Generic Name:</td>
                <td>$mvalue->generic_name</td>
                </tr>
                
                
                 <tr>
                <td>Form:</td>
                <td>$mvalue->form</td>
                 </tr>
                 
                 
                </table>
            
            
            </div>
           
        </div>";
        }
        else{
    		redirect(base_url() , 'refresh');
    	}        
    }
    /*


                    <div class='card'>
                        <div id='printArr'>
                            <p class='card-title' style='text-align:center;margin:2px 0 -10px 0;font-size:11px'><strong>$mvalue->product_name</strong></p>
                            <div class='card-body text-center'>
                                <p class='card-title chead' style='text-align:center'>$mvalue->strength &nbsp; &nbsp; &nbsp; $mvalue->form</p>
                                <img class='' src='$base/assets/images/barcode/$mvalue->batch_no.png' alt='Card image'>
                                <div class='container'>
                                    <p style='text-align:center;margin:3px 0 -5px 0;font-size:10px'>EXP:$mvalue->expire_date</p>
                                </div>
                            </div>
                        </div>
                    </div>


    public function GetbarcodeInfo(){ 
        if($this->session->userdata('user_login_access') != False) {
		$mid= $this->input->get('id');
		$qid= $this->input->get('qty');
		$mvalue = $this->medicine_model->GetMedicineValueById($mid);
            for($x = 1; $x <= $qid; $x++){
                $base = base_url();
		echo "
                    <div class='col-lg-3 col-md-3'>
                        <div class='card'>
                        <h4 class='card-title' style='text-align:center'>$mvalue->product_name</h4>
                        <div class='card-body'>
                        <h4 class='card-title' style='text-align:center'>$mvalue->strength  $mvalue->form</h4>
                        <img class='' src='$base/assets/images/barcode/	
$mvalue->batch_no.png' alt='Card image height='180px' width='240px'>
                        <p class='card-text' style='text-align:center'>$mvalue->expire_date</p>
                        </div>
                        </div>
                    </div>";
            }
        }
        else{
    		redirect(base_url() , 'refresh');
    	}        
    }*/

    public function Barcode(){ 
        if($this->session->userdata('user_login_access') != False) {
            $data['medicineList'] = $this->medicine_model->getAllMedicine();
            $this->load->view('backend/barcode',$data);
        }
        else{
    		redirect(base_url() , 'refresh');
    	}        
    }



    public function post_hsn()
    {
       $hsn = $this->input->post('hsn');
       $get_hsn_data = $this->medicine_model->get_hsn_data($hsn);
        echo json_encode($get_hsn_data);
    }

    public function delete_medicine()
    {
       $product_id =  $this->uri->segment(3);
       $delete_medicine = $this->medicine_model->delete_medicine($product_id);
       redirect('manage_View');
        
    }

    
    public function Viewhsn(){

        if($this->session->userdata('user_login_access') != False) {
            $data['hsnList'] = $this->medicine_model->getAllHsn();
            $this->load->view('backend/List_hsn',$data);
        }
        else{
    		redirect(base_url() , 'refresh');
    	}            
    }

    public function Createhsn(){

        if($this->session->userdata('user_login_access') != False) {
            
            $this->load->view('backend/Add_hsn');
        }
        else{
    		redirect(base_url() , 'refresh');
    	}            
    }

    // public function Checkmedicinename($medicinename){ 
    //     if($this->session->userdata('user_login_access') != False) {
    //         $data['medicineList'] = $this->medicine_model->checkmedicinename($medicinename);
           
    //     }
    //     else{
    // 		redirect(base_url() , 'refresh');
    // 	}        
    // }
   

   
     public function GetMedicinebyname()
     {
         $name = "Allercet";
          //  $name= $this->input->get('product_name');
         //   $data= array();
         $medicineid  = $this->medicine_model->GetMedicinebyname($name);
         echo json_encode($medicineid);
     }


     public function getformbyid($id)
     {
        return  $data = $this->medicine_model->getformbyid($id);
     }

     public function GetsubunitBynum(){
        $id = $this->input->post('form');
        $data = $this->medicine_model->GetsubunitBynum($id);
        echo json_encode($data);
     }
     
     public function permissionsbyemrole(){
        $id = $_SESSION['user_type'];
        $permission = $this->user_model->getAllpermissionsbyemid($id);  
        return $permissions1 = $permission[0]->permissions;
    }

     public function Measurementcreate()
    {
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
        if (in_array(14, $permissions)) { 
            $data['UnitList'] = $this->medicine_model->getAllunits();

            $data['UnitFormList'] = $this->medicine_model->getAllunitsForm();
            $data['medforms'] = $this->medicine_model->getAllunitsForm();
            $data['permissions1'] = $this->permissionsbyemrole();

            $this->load->view('backend/List_unit',$data);
        }
        else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
        }
        else{
    		redirect(base_url() , 'refresh');
    	}            
    


    }

    public function Saveunit(){
        $munit = $this->input->post('unit');
        $mnote = $this->input->post('note');
        $qnty = $this->input->post('qnty');
        $form = $this->input->post('form');
    
        $data = array(
            'unit' => $munit,
            'note' => $mnote,
            'qnty' => $qnty,
            'form' => $form
        );
    
        $this->db->insert('units', $data);
    
        $response = array(
            'status' => 'success',
            'message' => 'Unit added successfully',
            'curl' => base_url('Medicine/Measurementcreate'),
        );
    
        echo json_encode($response);
    }

    public function GetunitBynum(){
        if($this->session->userdata('user_login_access') != False) {
        $id= $this->input->get('id');
        $data= array();
        $data = $this->medicine_model->GetunitBynum($id);
        echo json_encode($data);
        }
        else{
            redirect(base_url() , 'refresh');
        }        
    }


    public function update_unit()
    {
        $id= $this->input->get('id');
     
        $munit= $this->input->post('unit');
        $mnote= $this->input->post('note');
        $mform= $this->input->post('form');
        $qnty= $this->input->post('qnty');
       $data = array(
        'unit' => $munit,
        'note' => $mnote,
        'form' => $mform,
        'qnty' => $qnty
       );
 
   
        $update_manu= $this->medicine_model->update_unit($id, $data);
        $response['status'] = 'success';    
        $response['message'] = "Successfully Updated";
        $response['curl'] = base_url("Medicine/Measurementcreate"); 
        $this->output->set_output(json_encode($response)); 
         
    }

    public function delete_unit()
    {
       $id =  $this->uri->segment(3);
       $delete_manu = $this->medicine_model->delete_unit($id);
       redirect('Medicine/Measurementcreate');
        
    }

    public function get_units()
    {
     $get_units =  $this->medicine_model->getAllUnits();
     echo json_encode($get_units);
    }

    public function closing_report()
    {
        $date = date("Y-m-d");
        $get_med_data =  $this->medicine_model->get_med_data($date); 
        $stock = 0;
        $processed_combinations = [];
        foreach($get_med_data as $val)
        {
       
        $date = $val->sale_date; 
        $pro_id = $val->mid; 
        $supplier_id = $val->supplier_id; 
        $batch = $val->Batch_Number;
    // Check if the combination has already been processed
    $combination_key = "$pro_id-$supplier_id-$batch-$date";

    if (!in_array($combination_key, $processed_combinations)) {
   
        $get_stock = $this->medicine_model->get_stock($pro_id, $supplier_id, $batch, $date);

        $get_purchase_rate = $this->medicine_model->get_purchase_rate($pro_id, $supplier_id, $batch);

        $get_hsn_num = $this->medicine_model->get_hsn_num($pro_id);
        $hsn = ($get_hsn_num[0]->hsn);
      

        $get_gst = $this->medicine_model->get_gst($hsn);
        $igst = $get_gst[0] -> igst;
        

      
       $purchase_rate = $get_purchase_rate[0] -> purchase_rate;
       $purchase_tax = ($purchase_rate * $igst)/100; 
       $purchase_wid_tax = $purchase_rate + $purchase_tax;
       

       $exp_date = $get_purchase_rate[0] -> expire_date;

        $processed_combinations[] = $combination_key;

        $in_house_purchase = $get_stock[0]-> total_qty * $purchase_wid_tax ;
        $in_house_sale = ($get_stock[0]-> total_qty * $get_stock[0] -> rate) ;

         $tax = ($in_house_sale * $igst)/100 ;
         $sale_with_tax = $in_house_sale + $tax;

         
      
        
            $data = array(
                "product_id" =>  $pro_id,
                "supplier_id" =>  $supplier_id,
                "batch_no" =>  $batch,
                "exp_date" =>  $exp_date,
                "unit_mrp" =>  '',
                "sale_price" =>  $get_stock[0] -> rate,
                "purchase_rate" => $purchase_rate,
                "purchase_wid_tax" => $purchase_wid_tax,
                "instock" => $get_stock[0]-> total_qty,
                "sale_price_wid_tax" =>  $sale_with_tax,
                "in_house_purchase_val" => $in_house_purchase,
                "in_house_sale_val" => $in_house_sale ,
                "created_at" => $date 
            );
       
          
          $insert =  $this->medicine_model->insert_closing_stock($data);
       
    } 
       
        }
        
    }

    public function closing()
    {
        $date = date("Y-m-d");
        $get_med_data =  $this->medicine_model->get_med_data($date); 
        $stock = 0;
        $processed_combinations = [];
        foreach($get_med_data as $val)
        {
       
        $date = $val->sale_date; 
        $pro_id = $val->mid; 
        $supplier_id = $val->supplier_id; 
        $batch = $val->Batch_Number;
    // Check if the combination has already been processed
    $combination_key = "$pro_id-$supplier_id-$batch-$date";

    if (!in_array($combination_key, $processed_combinations)) {
   
        $get_stock = $this->medicine_model->get_stock($pro_id, $supplier_id, $batch, $date);

        $get_purchase_rate = $this->medicine_model->get_purchase_rate($pro_id, $supplier_id, $batch);

        $get_hsn_num = $this->medicine_model->get_hsn_num($pro_id);
        $hsn = ($get_hsn_num[0]->hsn);
        $product_name = $get_hsn_num[0]->product_name;
        $form = $get_hsn_num[0]->form;
      

        $get_gst = $this->medicine_model->get_gst($hsn);
        $igst = $get_gst[0] -> igst;
        

      
       $purchase_rate = $get_purchase_rate[0] -> purchase_rate;
       $purchase_tax = ($purchase_rate * $igst)/100; 
       $purchase_wid_tax = $purchase_rate + $purchase_tax;
       

       $exp_date = $get_purchase_rate[0] -> expire_date;

        $processed_combinations[] = $combination_key;

        $in_house_purchase = $get_stock[0]-> total_qty * $purchase_wid_tax ;
        $in_house_sale = ($get_stock[0]-> total_qty * $get_stock[0] -> rate) ;

         $tax = ($in_house_sale * $igst)/100 ;
         $sale_with_tax = $in_house_sale + $tax;

         
      
        
            $data = array(
                "product_id" =>  $pro_id,
                "supplier_id" =>  $supplier_id,
                "batch_no" =>  $batch,
                "exp_date" =>  $exp_date,
                "unit_mrp" =>  '',
                "sale_price" =>  $get_stock[0] -> rate,
                "purchase_rate" => $purchase_rate,
                "purchase_wid_tax" => $purchase_wid_tax,
                "instock" => $get_stock[0]-> total_qty,
                "sale_price_wid_tax" =>  $sale_with_tax,
                "in_house_purchase_val" => $in_house_purchase,
                "in_house_sale_val" => $in_house_sale ,
                "created_at" => $date 
            );

           
       
           $qty =  $get_stock[0]-> total_qty;

            echo"<tr>
            <td>$product_name</td>
            <td>$form</td>
            <td>$supplier_id</td>
            <td>$batch</td>
            <td>$pro_id</td>
            <td>$exp_date</td>
            <td>$purchase_rate</td>
            <td>$purchase_wid_tax</td>
            <td>$qty</td>
            <td>$in_house_purchase</td>
            <td>$in_house_sale</td>     
            </tr>";
       
    } 
       
        }
        
    }

   public function Getallmeds()
   {
            $data =  $this->medicine_model->getAllMedicineid();       
            $key = array();  
           $value = array(); 
                array_push($key,'');
                array_push($value,'Select Medicine');    
          foreach($data as $unitid) {               
           //echo ".$unitid->product_id.":".$unitid->product_name";

                array_push($key,$unitid->product_id);
                array_push($value,$unitid->product_name);

            }
            echo json_encode(array_combine($value,$key));

            }


                public function Getallunitbyform()
            {
                $mid = $this->input->post('medid');
                $data = $this->medicine_model->getsubformbyId($mid);
                $combined_data = [];
            
                foreach ($data as $item) {
                    $exploded_data = explode(',', $item['subform']);
            
                    foreach ($exploded_data as $subform_id) {
                        $units = $this->medicine_model->getAllsubformunit($subform_id);
            
                        foreach ($units as $unit) {
                            $combined_data[$unit['unit']] = $unit['id'];
                        }
                    }
                }
            
                echo json_encode($combined_data);
            }

            





        }