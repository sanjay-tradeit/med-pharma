<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Customer extends CI_Controller {
	    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->model('medicine_model');
        $this->load->model('customer_model');
        $this->load->model('supplier_model');
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
    public function permissionsbyemrole(){
        $id = $_SESSION['user_type'];
        $permission = $this->user_model->getAllpermissionsbyemid($id);  
        return $permissions1 = $permission[0]->permissions;
    }
    public function Create(){
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                if (in_array(4, $permissions)) { 
        $this->load->view('backend/Add_customer');
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
        $data['customerList'] = $this->customer_model->getAllCustomer();
        $this->load->view('backend/List_customer',$data);
        }
    else{
		redirect(base_url() , 'refresh');
	}       
    }

   public function Regular(){
       if($this->session->userdata('user_login_access') != False) {
        $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                if (in_array(3, $permissions)) {
        $data['RegulatList'] = $this->customer_model->getAllRCustomer();
        $data['permissions1'] = $this->permissionsbyemrole();
        $this->load->view('backend/Regular_customer',$data);
    }
    else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }

   public function Wholesale(){
       if($this->session->userdata('user_login_access') != False) {
        $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                if (in_array(3, $permissions)) {
        $data['wholesaleList'] = $this->customer_model->getAllWCustomer();
        $data['permissions1'] = $this->permissionsbyemrole();
        $this->load->view('backend/Wholesale_customer',$data);
    }
    else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
        }
    else{
		redirect(base_url() , 'refresh');
	}        

    }


    //Walkin list
    public function Walkin(){
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                if (in_array(3, $permissions)) {
        $data['Walkin'] = $this->customer_model->getAllWalkCustomer();
        $data['permissions1'] = $this->permissionsbyemrole();
        $this->load->view('backend/Walkin_customer',$data);
    }
    else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
         }
     else{
         redirect(base_url() , 'refresh');
     }        
 
     }

    public function Save_regular_with_img()
    {
        $this->load->library('image_lib');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
         $this->form_validation->set_rules('cname', 'name', 'required');
         $this->form_validation->set_rules('cphone', 'phone', 'required');
         $this->form_validation->set_rules('cemail', 'cemail', 'required');
        //  $this->form_validation->set_rules('caddress', 'caddress', 'required');
        //  $this->form_validation->set_rules('tamount', 'tamount', 'required');
        //  $this->form_validation->set_rules('rdiscount', 'rdiscount', 'required');
        //  $this->form_validation->set_rules('tdiscount', 'tdiscount', 'required');
        //  $this->form_validation->set_rules('cnote', 'cnote', 'required');
        if($this->form_validation->run() === FALSE){
		    $response['status']   = 'error';
            $response['message']  = validation_errors();
            $this->output->set_output(json_encode($response));

        } else {
            $name   =     $this->input->post('cname') ? $this->input->post('cname') : '';
            $phone  =    $this->input->post('cphone')? $this->input->post('cphone') : '';
            $pname  =    $this->input->post('pname')? $this->input->post('pname') : '';
            $email  =    $this->input->post('cemail') ? $this->input->post('cemail') : '';
            $address =  $this->input->post('caddress') ? $this->input->post('caddress') : '';
            $tamount =  $this->input->post('tamount') ? $this->input->post('tamount') : '';
            $rdiscount= $this->input->post('rdiscount') ? $this->input->post('rdiscount') : '';
            $tdiscount = $this->input->post('tdiscount') ? $this->input->post('tdiscount') : '';
            $note =     $this->input->post('cnote') ? $this->input->post('cnote') : '';
            $cid    =      'C'.rand(100,1000000);
            $batchno    =   rand(5000000,10000000);        
            $group  =    $this->input->post('ctype');
            $entrydate = strtotime(date("m/d/Y"));
             $Does_email_exists = $this->customer_model->Does_email_exists($email,$phone);
            if($Does_email_exists=="1"){
                $response['status'] = 'error';   
                $response['message'] = 'Email already Exist12345';
                echo json_encode($response);
            }
            else {

                $img_name = [];
                //---------------------------------------------------------
                if(!empty($_FILES['files']['name'])){ 
                    $filesCount = count($_FILES['files']['name']); 
                    for($i = 0; $i < $filesCount; $i++){ 
                        $_FILES['file']['name']     = $_FILES['files']['name'][$i]; 
                        $_FILES['file']['type']     = $_FILES['files']['type'][$i]; 
                        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
                        $_FILES['file']['error']     = $_FILES['files']['error'][$i]; 
                        $_FILES['file']['size']     = $_FILES['files']['size'][$i]; 
                         
                        // File upload configuration 
                        $uploadPath = "./assets/images/customer"; 
                        $config['upload_path'] = $uploadPath; 
                        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                        $this->load->library('upload', $config); 
                        $this->upload->initialize($config); 
                        if($this->upload->do_upload('file')){ 
                            $fileData = $this->upload->data(); 
                            $img_name = $fileData['file_name'];                             
                    } 
                }
            }
            $data = array();
            $data = array(
                'c_id'      => $cid,
                'c_name'    => $name,
                'pharmacy_name'=> $pname,
                'c_email'   => $email,
                'c_type'    => $group,
                'cus_contact' => $phone,
                'c_address' => $address,
                'regular_discount' => $rdiscount,
                'target_amount'=> $tamount,
                'target_discount'=> $tdiscount,
                'c_note'   => $note,
                'c_img'    => $img_name,
                'barcode'    => $batchno,
                'entrydate'=> $entrydate
            );
           
            $success = $this->customer_model->Add_customer_info($data);

            $data1 = array();
            $data1 = array(
             'customer_id' => $cid,
             'total_balance' => 0,
             'total_paid' => 0,
             'total_due' => 0,

            );
            $success = $this->customer_model->Create_Customer_balance($data1);
            $response['status'] = 'success';    
            $response['message'] = "Successfully Created";
            $response['curl'] = base_url("Customer/".$group); 
            $this->output->set_output(json_encode($response)); 
          
        //------------------------------------------------------------
            }

    }
   }

   public function Save_wholesale_with_img()
   {
    $this->load->library('image_lib');
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters();
     $this->form_validation->set_rules('cname', 'name', 'required');
    //  $this->form_validation->set_rules('pname', 'pharmacy', 'required');
     $this->form_validation->set_rules('cphone', 'phone', 'required');
     $this->form_validation->set_rules('cemail', 'cemail', 'required');
    //  $this->form_validation->set_rules('caddress', 'caddress', 'required');
    //  $this->form_validation->set_rules('cnote', 'cnote', 'required');

    //  $this->form_validation->set_rules('tamount', 'tamount', 'required');
    //  $this->form_validation->set_rules('rdiscount', 'rdiscount', 'required');
    //  $this->form_validation->set_rules('tdiscount', 'tdiscount', 'required');
   
    if($this->form_validation->run() === FALSE){
        $response['status']   = 'error';
        $response['message']  = validation_errors();
        $this->output->set_output(json_encode($response));

    } else {
        $name   =     $this->input->post('cname') ? $this->input->post('cname') : '';
        $pname  =    $this->input->post('pname')? $this->input->post('pname') : '';
        $phone  =    $this->input->post('cphone')? $this->input->post('cphone') : '';
        $email  =    $this->input->post('cemail') ? $this->input->post('cemail') : '';
        $address =  $this->input->post('caddress') ? $this->input->post('caddress') : '';
        $note =     $this->input->post('cnote') ? $this->input->post('cnote') : '';

        $tamount =  $this->input->post('tamount') ? $this->input->post('tamount') : '';
        $rdiscount= $this->input->post('rdiscount') ? $this->input->post('rdiscount') : '';
        $tdiscount = $this->input->post('tdiscount') ? $this->input->post('tdiscount') : '';
        
        $cid    =      'C'.rand(100,1000000);
        $batchno    =   rand(5000000,10000000);        
        $group  =    $this->input->post('ctype');
        $entrydate = strtotime(date("m/d/Y"));
         $Does_email_exists = $this->customer_model->Does_email_exists($email,$phone);
        if($Does_email_exists=="1"){
            $response['status'] = 'error';   
            $response['message'] = 'Email already Exist';
            echo json_encode($response);
        }
        else {

            $img_name = [];
            //---------------------------------------------------------
            if(!empty($_FILES['files']['name'])){ 
                $filesCount = count($_FILES['files']['name']); 
                for($i = 0; $i < $filesCount; $i++){ 
                    $_FILES['file']['name']     = $_FILES['files']['name'][$i]; 
                    $_FILES['file']['type']     = $_FILES['files']['type'][$i]; 
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
                    $_FILES['file']['error']     = $_FILES['files']['error'][$i]; 
                    $_FILES['file']['size']     = $_FILES['files']['size'][$i]; 
                     
                    // File upload configuration 
                    $uploadPath = "./assets/images/customer"; 
                    $config['upload_path'] = $uploadPath; 
                    $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                    $this->load->library('upload', $config); 
                    $this->upload->initialize($config); 
                    if($this->upload->do_upload('file')){ 
                        $fileData = $this->upload->data(); 
                        $img_name = $fileData['file_name'];                             
                } 
            }
        }
        $data = array();
        $data = array(
            'c_id'      => $cid,
            'c_name'    => $name,
            'pharmacy_name'=> $pname,
            'c_email'   => $email,
            'c_type'    => $group,
            'cus_contact' => $phone,
            'c_address' => $address,
            'regular_discount' => $rdiscount,
            'target_amount'=> $tamount,
            'target_discount'=> $tdiscount,
            'c_note'   => $note,
            'c_img'    => $img_name,
            'barcode'    => $batchno,
            'entrydate'=> $entrydate
        );
        // echo "<pre>";
        // print_r($data);
        $success = $this->customer_model->Add_customer_info($data);

        $data1 = array();
            $data1 = array(
             'customer_id' => $cid,
             'total_balance' => 0,
             'total_paid' => 0,
             'total_due' => 0,

            );
            $success = $this->customer_model->Create_Customer_balance($data1);
        $response['status'] = 'success';    
        $response['message'] = "Successfully Created";
        $response['curl'] = base_url("Customer/".$group); 
        $this->output->set_output(json_encode($response)); 
      
    //------------------------------------------------------------
        }

}
   }

    public function Save(){
         $this->load->library('image_lib');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
         $this->form_validation->set_rules('cname', 'name', 'trim|required|min_length[1]|max_length[150]|xss_clean');
        //  $this->form_validation->set_rules('pname', 'pname', 'required');
        $this->form_validation->set_rules('cphone', 'phone', 'required');
        $this->form_validation->set_rules('cemail', 'cemail', 'required');
        // $this->form_validation->set_rules('caddress', 'caddress', 'required');
        // $this->form_validation->set_rules('cnote', 'cnote', 'required');
        if($this->form_validation->run() === FALSE){
		    $response['status']   = 'error';
            $response['message']  = validation_errors();
            $this->output->set_output(json_encode($response));

        } else {
            $name   =     $this->input->post('cname') ? $this->input->post('cname') : '';
            $pname   =     $this->input->post('pname') ? $this->input->post('pname') : '';
            $phone  =    $this->input->post('cphone')? $this->input->post('cphone') : '';
            $cid    =      'C'.rand(100,1000000);
            $batchno    =   rand(5000000,10000000);        
            $email  =    $this->input->post('cemail') ? $this->input->post('cemail') : '';
            $address =  $this->input->post('caddress') ? $this->input->post('caddress') : '';
            $group  =    $this->input->post('ctype') ? $this->input->post('ctype') : '';
            $tamount =  $this->input->post('tamount') ? $this->input->post('tamount') : '';
            $rdiscount= $this->input->post('rdiscount') ? $this->input->post('rdiscount') : '';
            $tdiscount = $this->input->post('tdiscount') ? $this->input->post('tdiscount') : '';
            $note =     $this->input->post('cnote') ? $this->input->post('cnote') : '';
            $entrydate = strtotime(date("m/d/Y"));
           // $oldmail =  $this->customer_model->getEmailId($email) ;
             $Does_email_exists = $this->customer_model->Does_email_exists($email,$phone);
             print_r($Does_email_exists);
            if($Does_email_exists=="1"){
                $response['status'] = 'error';   
                $response['message'] = 'Email already Exist';  
               // $this->output->set_output(json_encode($response)); 

                echo json_encode($response);
            } 
            else {

                $img_name = [];
                //---------------------------------------------------------
                if(!empty($_FILES['files']['name'])){ 
                    $filesCount = count($_FILES['files']['name']); 
                    for($i = 0; $i < $filesCount; $i++){ 
                        $_FILES['file']['name']     = $_FILES['files']['name'][$i]; 
                        $_FILES['file']['type']     = $_FILES['files']['type'][$i]; 
                        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
                        $_FILES['file']['error']     = $_FILES['files']['error'][$i]; 
                        $_FILES['file']['size']     = $_FILES['files']['size'][$i]; 
                         
                        // File upload configuration 
                        $uploadPath = "./assets/images/customer"; 
                        $config['upload_path'] = $uploadPath; 
                        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                        $this->load->library('upload', $config); 
                        $this->upload->initialize($config); 
                        if($this->upload->do_upload('file')){ 
                            // Uploaded file data 
                            $fileData = $this->upload->data(); 
                            $img_name = $fileData['file_name']; 
                            print_r($img_name);
                           
                    } 
                     
               
                }
            }
            $data = array();
            $data = array(
                'c_id'      => $cid,
                'c_name'    => $name,
                'pharmacy_name'=> $pname,
                'c_email'   => $email,
                'c_type'    => $group,
                'cus_contact' => $phone,
                'c_address' => $address,
                'regular_discount' => $rdiscount,
                'target_amount'=> $tamount,
                'target_discount'=> $tdiscount,
                'c_note'   => $note,
                'c_img'    => $img_name,
                'barcode'    => $batchno,
                'entrydate'=> $entrydate
            );
           
            $success = $this->customer_model->Add_customer_info($data);

            $data1 = array();
            $data1 = array(
             'customer_id' => $cid,
             'total_balance' => 0,
             'total_paid' => 0,
             'total_due' => 0,

            );
            $success = $this->customer_model->Create_Customer_balance($data1);

            $response['status'] = 'success';    
            $response['message'] = "Successfully Created";
            $response['curl'] = base_url('Customer/'.$group); 
            $this->output->set_output(json_encode($response)); 

                //------------------------------------------------------------
            }
         }
        }
    
    public function Save_Canvas(){
        $this->form_validation->set_rules('cname', 'name', 'trim|required|min_length[1]|max_length[150]|xss_clean');
        $name   =     $this->input->post('cname') ;
        $pname   =     $this->input->post('pname') ? $this->input->post('pname'):'';
        $phone  =    $this->input->post('cphone') ? $this->input->post('cphone'):'';
        $cid    =      'C'.rand(10000000,20000000);        
        $batchno    =   rand(3000000,4900000);        
        $email  =    $this->input->post('cemail') ? $this->input->post('cemail'):'';
        $address =  $this->input->post('caddress') ? $this->input->post('caddress'):'';
        $group  =    $this->input->post('ctype');
       // print_r($group);
        $tamount =  $this->input->post('tamount') ? $this->input->post('tamount'):'';
        $rdiscount= $this->input->post('rdiscount') ? $this->input->post('rdiscount'):'';
        $tdiscount = $this->input->post('tdiscount') ? $this->input->post('tdiscount'):'';
        $note =     $this->input->post('cnote') ? $this->input->post('cnote'):'';
        $entrydate = strtotime(date("m/d/Y"));
       // $oldmail =  $this->customer_model->getEmailId($email);
        $this->load->library('image_lib');
        $this->load->library('form_validation');
       // $this->form_validation->set_error_delimiters();
      
        if($this->form_validation->run() == FALSE){
		    $response['status'] = 'error';
           //$response['message'] = validation_errors();
           $response['message'] = "Your Email Or Phone number already exist";
            $this->output->set_output(json_encode($response));
        } else {
            if($this->customer_model->Does_email_exists($email,$phone)){
            $this->session->set_flashdata('error', 'E-mail or Phone number already Exist');
            $response['status'] = 'error';
            $response['message'] = "Your Email Or Phone number already exist";
            $this->output->set_output(json_encode($response));
            } else {            
        $img = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACWCAMAAAAL34HQAAAAAXNSR0IB2cksfwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAdRQTFRFAAAA1tbW0dHRzs7OzMzMy8vL0NDQ1NTU1dXVz8/Pzc3Nzc3NzMzMysrK09PTy8vLysrKxcXFv7+/vb29wMDAycnJx8fHr6+vj4+PcXFxYGBgVVVVUlJSU1NTWFhYZ2dnfn5+np6evLy8eXl5VlZWTExMTk5OTU1NS0tLT09PYmJimJiYsrKybW1tXFxcjo6OyMjIn5+faWlpxMTErKysa2trWVlZhoaGcHBwUFBQjY2NgICAUVFRpKSkl5eXaGhodXV1tLS0SkpKs7Oze3t7ra2tdHR0lpaWioqKqKiou7u7xsbGqampubm5f39/uLi4d3d3o6OjiYmJhYWFzs7OsbGxcnJyz8/PpaWlX19flZWVh4eHR0dHRUVFtra2RkZGfX19wcHBk5OTpqamhISE0tLSoaGhZWVlq6urampqb29vqqqqSUlJjIyMbGxstbW1ZGRkm5ubt7e3VFRUXl5eenp6kpKSc3NzXV1doKCgmpqaSEhIoqKiurq6rq6uV1dXeHh4Y2NjW1tbwsLCYWFhvr6+nJyclJSUfHx8ubm5wsLCgYGBvb29iIiIxMTEx8fHdnZ2nZ2dsLCwtLS0kJCQZmZmt7e3bm5uWlpawMDAp6eng4ODWxBjEwAAAJx0Uk5TAAcnOkdNLRQNM0D//1Ma//////////////////////////////////////////////////////////////////////////////////////////////////////////////////8g///////////////////////////////////////////////Ahv+m/3pm///54P//zf//k///59OtLgAAB0ZJREFUeJztnOlb1FYUxgcmgzA3kkEEpbIKuZm0iiCLjlKxI2oFRRShYq0LrdgiLpSx1rqgtla7b6Jd/tlmMiyDJPe89yYDX+b9xPPw5PDLOScn9557QiRSVFFFFVVUUQKVlEa1ZcViWtmmjSYqr9DicaaviDnSdS2ubY5uEFKp4xtdIOfX645WKkZaQYuXrBtTdDPEtIQWL18PKMxPeWIsXlloqLhmSFK5j4FWVkgox1PSVIuKVRQKKiobvtXSClLPojFVRy2JaaFDbZLPKQ+ueMiVLGoYYWCxcB2mhQGVkxZa6lfGw2JyFQuHqowx+m/phisEywiFS2MIllSUQwhknEFYiaot1dXVW2tAsKBFH0qr2m3b697ZUd/Q0NjU3FKN+I0F85cGOGpna5vJuWW6spL2u+8lSDLGglQwjYwf27W7fhHIlfMDt9r3dBBgjl11rjiZVkYnN818rJzTrL1d7rMpvFa1smruXYnU3WOZXlim1buPkfVCLb/IbO/en+JOyLzF2w/sJK5npSq+IuKXOMi5H1POb33vU6kvv9AvFccvcaifE1iOxw5/IMaSrvfl4mzvOJzmNJbF+46EyyV+5XQM2BaC5YAdDZNLvDxOHEsuP3mU+o4LE8yQSS/xQ8g+NHEsi58QGpOoXpXiJ2iQZ8sTimX1DgmtxWGsmNhZ+4CcWpGZPCm+S3RvS+y7TjUguZ7HNRzOS0jsLL1VhskRrz8ttMewMMbF5b26TxaLj4jvE8Iq0cVYZyxprEbiPYaEkcgsdlYqsVwsq0psE6mpBNZQvTxW6rjYJuAuajmzU+4xdLH46DmxUTq7qF7DmArW+Edio+TKnuyAnFfAsiYILNJdZAvrgqWAZVNWiY1jlLz+YwUsfrGLMitOerrfRy2VPbE+GaTMiqNIYw0oYV0i7Yq4ysir2YgK1mViTa+Lo0g7i12xVbDEL2tXgvUNgDWqhHWVxvKPYiV9MZtUwbI6aMv+UUS6Rp+aClgTgGF/LOQ4YEylbu1H2py+FRXBUnpVfwYY9k2ua8jFXSq5NYl0CP2iCDUkE20KWFOJAFjYSdN1eSzzc6gP7XMcimF9oYC1DcLyaXdBWFt65aDcIF6oQbi814LlwJVGc70slYNl2+27AC7vR5F+TzvlIdc/gnpIq/xVB5xzeOc88iAe5ypYjtqq6BMhbyxij+9q2lbE4t2q3gKwErYy1iRtXTmIg5dVsexh2rp34xnAumEpY40DWJ4rQaBsnVcOoj1dQKyxtDIW0UwKhFU1o5zyNwuIxW6p1i2L6M8HwtKnwFOCNc7qBVbzuue0C1JOt6SVqCx+DDDuXSAQLH23ItZtwLZ3Od2MYHUmlbDuIHsMbyxoubVVDatVHasCmhToV8JqQW7ZG4s46VnUrPQ+0VF7rToWFsXEgO/xtL9OIZYDYen6lwcapJimzwwhmeW3lkexdH1cCus0I9rfS7rmjQUVrqy2y1DN1UKzQ/7b1woU6zx+xmlZGR2bafJv2aBRvJSGoTjfy86tE1aHBJZ1l62Xt8414ljmdgPE8u1v0YcFi1jTOJZ9w6nSgZyFu+srPOexAh8O1m0bpTKvgCZFY2bwgOk9FCstHs5Ykei4oAS0weDKlTGwF4/4LAouEV+DMezEKjwx+hZHrdzH3JVB7YkP7spRM7V9CBU/CJqjDtGJ2Yxl1cwhWPY+FMtn9bCka6CdBNRC5TdBc+QkBJj0RgbBsiZBLHKmEumgZnUHoUp+g2EBUzbgYrAfWdHPTAVaLucLXAxCb+uZkxAWNJKEZdcIhDUGYUHT89h+sRXBerALMQUOeULZ1QN56yEDvodAv5aiwmgMPXoI7RX5vcdXaygseCJWVOrZo7O3MvPwyU9qvr3pcKfoOFFiTtffXVefWLbEzOmi5h7636jM1LwPV/VB2+aWNJWjp2d8FvT4NGzEu3gZR0af2QpNpJzsupZvPZYnkl8+rHkaa6a+U0bKKd0w8HwNFrFyILg6LjxVanvnKXv13Ei2h5r3aMp/jpGXXkZL79KpSjAsbiWHB/M+aZFKrJyW0stIfN9uckvtkOBtrKyBu8tNOKVPasrcTfrzF9dlx3IppQaOJpiar1x/Mf30S9kJZkhmZrZL+fOjyP0eePcsDTbfrIz1g/x0Aa79qlSRyI+FiGBOT9SpnPTaURiw5E9BqJyqKj27Amk0GJWjnqTKq1mo5InAVJFIM94pxTT/cwhUkciJIMV9rZ6GAuWorCk0Jp56ERaVo19CojIzv4ZIFYn8NhEG1IM9oUJlNRs4w9K7C/IfNEZm1MGce5rrLgSUo02/X0ybSisvzlNh1Co/xV4qTY0kn/1RQChXww3SWBN/Fhoqq7/qkhzcmXE+0/ZK5fNpJZXOLjyA2m6p5tfrxbSox2/4jMBnduri3zfXzU+rdfTVeCNPpq1VqWbO2PXXh1v+2RikZb3+99B/T8ZvNS0sLPS/uTewZ2rbRv1LsKKKKqqoot7S/1R8NVMJuUGfAAAAAElFTkSuQmCC";//$_POST['dataURL'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $fileData = base64_decode($img);
        $fileName = $cid.'.png';
        $fdata = file_put_contents("./assets/images/customer/$fileName", $fileData);                            
            $image_data =   $this->upload->data();
            $configer =  array(
              'image_library'   => 'gd2',
              'source_image'    =>  './assets/images/customer/$fileName',    
              'maintain_ratio'  =>  TRUE,
              'width'           =>  160,
              'height'          =>  100,
            );
            $this->image_lib->clear();
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();
                
                $data = array();
                $data = array(
                    'c_id' => $cid,
                    'c_name' => $name,
                    'pharmacy_name'=> $pname,
                    'c_email' => $email,
                    'c_type' => $group,
                    'cus_contact' => $phone,
                    'c_address' => $address,
                    'regular_discount' => $rdiscount,
					'target_amount'=>$tamount,
					'target_discount'=>$tdiscount,
                    'c_img'    => $fileName,
                    'c_note'=> $note,
                    'barcode'    => $batchno,
					'entrydate'=> $entrydate
                );
               // print_r($data);
               
                $success = $this->customer_model->Add_customer_info($data);
                if($this->db->affected_rows()){
                $data = array();
                $data = array(
                    'customer_id' => $cid,
                    'total_balance' => 0,
                    'total_paid' => 0,
                    'total_due' => 0,
                );
                    $success = $this->customer_model->Create_Customer_balance($data);
                    if($this->db->affected_rows()){
		              //load library
        		      $this->load->library('zend');
        		      //load in folder Zend
        		      $this->zend->load('Zend/Barcode');
        		      //generate barcode
                      $barcode = $batchno;
        		      $file = Zend_Barcode::draw('code128', 'image', array('text' => $barcode,'barHeight'=> 30), array());
                      $store_image = imagepng($file,"./assets/images/cbarcode/{$barcode}.png");                        
                $response['status'] = 'success';    
                $response['message'] = "Successfully Created";
               $response['curl'] = base_url("Customer/".$group); 
                $this->output->set_output(json_encode($response));                       
                    }                      
                }
        }
        }

    }    
    public function Update(){
        $id     =       $this->input->post('cid') ;
        $name   =     $this->input->post('cname') ? $this->input->post('cname'): '';
        $phone  =    $this->input->post('cphone') ? $this->input->post('cphone'): '';
        $email  =    $this->input->post('cemail') ? $this->input->post('cemail'): '';
        $address =  $this->input->post('caddress') ? $this->input->post('caddress'): '';
        $tamount =  $this->input->post('tamount') ? $this->input->post('tamount'): '';
        $rdiscount= $this->input->post('rdiscount') ? $this->input->post('rdiscount'): '';
        $tdiscount = $this->input->post('tdiscount') ? $this->input->post('tdiscount'): '';
        $note =     $this->input->post('cnote') ? $this->input->post('cnote'): '';
        $group  =    $this->input->post('ctype');

        $pname   =     $this->input->post('pcname') ? $this->input->post('pcname'):'';  
        $ctype =     $this->input->post('ctype');

        $entrydate = strtotime(date("m/d/Y"));
        $oldmail =  $this->customer_model->getEmailId($email);
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('cname', 'name', 'trim|required|min_length[1]|max_length[150]|xss_clean');
        $this->form_validation->set_rules('cphone', 'phone', 'trim|xss_clean');

       // if($this->form_validation->run() === FALSE){
		    // $response['status']   = 'error';
            // $response['message']  = validation_errors();
            // $this->output->set_output(json_encode($response));

      //  } 
		//	else 
            if($ctype == 'Regular'){
                $img_name = [];
                //------------------------------------------------------------------------------------------------------
                if(!empty($_FILES['files']['name'])){ 
                    print_r("image");
                    $filesCount = count($_FILES['files']['name']); 
                    for($i = 0; $i < $filesCount; $i++){ 
                        $_FILES['file']['name']     = $_FILES['files']['name'][$i]; 
                        $_FILES['file']['type']     = $_FILES['files']['type'][$i]; 
                        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
                        $_FILES['file']['error']     = $_FILES['files']['error'][$i]; 
                        $_FILES['file']['size']     = $_FILES['files']['size'][$i]; 
                         
                        // File upload configuration 
                        $uploadPath = "./assets/images/customer"; 
                        $config['upload_path'] = $uploadPath; 
                        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                        $this->load->library('upload', $config); 
                        $this->upload->initialize($config); 
                        if($this->upload->do_upload('file')){ 
                            $fileData = $this->upload->data(); 
                            $img_name = $fileData['file_name'];   
                            print_r($img_name);                          
                    } 
                }
            }
            if(empty($img_name))
            {
                $get_image_name =  $this->customer_model->get_image_name($id);
                 $img_name = $get_image_name[0]->c_img;

            }
                $udata = array();
                $udata = array(
                    'c_name'    => $name,
                    'pharmacy_name' => $pname,
                    'c_email'   => $email,
                    'c_type'    => $group,
                    'cus_contact' => $phone,
                    'c_address' => $address,
                    'regular_discount' => $rdiscount,
                    'target_amount'=>$tamount,
                    'target_discount'=>$tdiscount,
                    'c_note'   => $note,
                    'c_img'    => $img_name
                );
             
               $success = $this->customer_model->Update_customer_info($id,$udata); 
                $response['status'] = 'success';    
                $response['message'] = "Successfully Updated";
                $response['curl'] = base_url('Customer/'.$ctype); 
                redirect('regular_cus');
               // $this->output->set_output(json_encode($response));
             }
            else
            if($ctype == 'Wholesale'){
                $img_name = [];
                //---------------------------------------------------------
                if(!empty($_FILES['files']['name'])){ 
                    print_r("image");
                    $filesCount = count($_FILES['files']['name']); 
                    for($i = 0; $i < $filesCount; $i++){ 
                        $_FILES['file']['name']     = $_FILES['files']['name'][$i]; 
                        $_FILES['file']['type']     = $_FILES['files']['type'][$i]; 
                        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
                        $_FILES['file']['error']     = $_FILES['files']['error'][$i]; 
                        $_FILES['file']['size']     = $_FILES['files']['size'][$i]; 
                         
                        // File upload configuration 
                        $uploadPath = "./assets/images/customer"; 
                        $config['upload_path'] = $uploadPath; 
                        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                        $this->load->library('upload', $config); 
                        $this->upload->initialize($config); 
                        if($this->upload->do_upload('file')){ 
                            $fileData = $this->upload->data(); 
                            $img_name = $fileData['file_name'];   
                            print_r($img_name);                          
                    } 
                }
            }
            if(empty($img_name))
            {
                $get_image_name =  $this->customer_model->get_image_name($id);
                 $img_name = $get_image_name[0]->c_img;

            }
            $udata = array();
            $udata = array(
                'c_name'    => $name,
                'pharmacy_name' => $pname,
                'c_email'   => $email,
                'cus_contact' => $phone,
                'c_address' => $address,
                'c_note'   => $note,
                'c_img'    => $img_name
            );
     
           $success = $this->customer_model->Update_customer_info($id,$udata); 
            $response['status'] = 'success';    
            $response['message'] = "Successfully Updated";
            $response['curl'] = base_url('Customer/'.$ctype); 
            $this->output->set_output(json_encode($response));

            }
             else {
                $udata = array();
                if($ctype == 'walkin'){
                    $udata = array(
                        'c_name'    => $name,
                        'cus_contact' => $phone
                        
                    );
                    $success = $this->customer_model->Update_customer_info($id,$udata); 
                    $response['status'] = 'success';    
                    $response['message'] = "Successfully Updated";
                    $response['curl'] = base_url("Customer/".$ctype);
                    $this->output->set_output(json_encode($response)); 
            
            }
        }
    }
    
    /*Get monthly income for regular customer*/
    public function GetCustomerMonthlyIncome(){
        $id =$this->input->get('id');
      //  print_r($id);
        if(!empty($id)){
        $date = date('Y-m');
        $balance = $this->customer_model->GetCustomerMonthlyIncome($id,$date);
        $dues = $this->customer_model->GetCustomerBalance($id);
        $targetbalance = $this->customer_model->GetCustomerIdValue($id);
        $total= 0 ;
        foreach($balance as $value){
           $total += $value->total_amount; 
        }
/*        echo date('F Y',strtotime('-1 month')).' : '.$total.' '."Target:".$targetbalance->target_amount.'   '."Discount:".$targetbalance->target_discount.'%';*/
                              echo"<div class='dues'>";
                              if(!empty($dues)){
                                if($dues->total_due > 0){ 
                                    echo"<h4 class='previous-due-header'><span class='previous-dues'>Previous Dues= </span>₹ $dues->total_due </h4>";
                                    }
                              }
       
                              echo"</div>
                               <div class='borderc'>
                                   <h5 class='discount-info'><span>";echo date('F Y').' : '. "</span>₹  $total </h5>
                                   <h5 class='discount-info'><span>Target Amount:</span> ₹ $targetbalance->target_amount </h5>
                                   <h5 class='discount-info' id='discountval' name='discount'><span>Discount Applied: </span>";if($targetbalance->target_amount < $total){ echo $targetbalance->target_discount; } else {
                                      echo $targetbalance->regular_discount;
                                   } echo" %</h5>
                               </div>";            
        }
    }

    // Get Gagular Customer Data
    public function GetRegularById(){ 
        if($this->session->userdata('user_login_access') != False) {
        $id= $this->input->get('id');
        $data= array();
        $data['mvalue'] = $this->customer_model->GetRegularValueById($id);
        echo json_encode($data);
        }
        else{
            redirect(base_url() , 'refresh');
        }        
    }

    // Get Customer Data
    public function GetCustomerId(){ 
        if($this->session->userdata('user_login_access') != False) {
        $id= $this->input->get('id');
        $data['mvalue'] = $this->customer_model->GetCustomerValueForPOS($id);
        echo json_encode($data);
        }
        else{
            redirect(base_url() , 'refresh');
        }        
    }

    // Get Customer Data
    public function GetCustomerValueforPOS(){ 
        if($this->session->userdata('user_login_access') != False) {
        $id= $this->input->get('id');
        $data= array();
        $data['mvalue'] = $this->customer_model->GetCustomerValueForPOS($id);
        echo json_encode($data);
        }
        else{
            redirect(base_url() , 'refresh');
        }        
    }

    // Get Customer balance Data
    public function GetCustomerBalanceBYId(){ 
        if($this->session->userdata('user_login_access') != False) {
        $id= $this->input->get('id');
        $data= array();
        $data['mvalue'] = $this->customer_model->GetCustomerBALANCEValue($id);
        $dueData = $this->customer_model->GetcustomerwithdueBYid($id);
        $content = '';
            foreach($dueData as $dues){

                $content .= "<div class='row p-b-5'><div class='col-md-3'><input type='hidden' name='ids[]' value='$dues->id'></input><input  readonly class='form-control pay' type='text' name='' value='$dues->create_date'></input></div><div class='col-md-3'><input readonly class='form-control pay' type='text' name='' value='$dues->invoice_no'></input></div><div class='col-md-3'><input class='form-control pay' readonly type='text' name='dueamnt[]' value='$dues->due_amount'></input></div><div class='col-md-3'><input class='form-control pay'  type='text' name='paidamt[]'></input></div></div></div>";


            }

        $data['duevalue'] = $content;

        echo json_encode($data);
        }
        else{
            redirect(base_url() , 'refresh');
        }        
    }
    public function Balance(){
       if($this->session->userdata('user_login_access') != False) {
        $per = $this->permissionsbyemrole();
        $permissions = explode(',', $per);
                   if (in_array(69, $permissions)) {
        $data['balancesheet'] = $this->customer_model->getAllCustomerBalance();

        $this->load->view('backend/customer_balance',$data);
    } else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
        }

    else{

		redirect(base_url() , 'refresh');

	}  
    }
    public function GetBarcodeDom(){
        if($this->session->userdata('user_login_access') != False) {
		$cid= $this->input->get('id');
		$mvalue = $this->customer_model->GetCustomerValueForPOS($cid);
                $base = base_url();
                
		echo "<div class='modal-body'>
                <div class='card-body'>
                    <table style='width:100%'>
                    <tr><td style='text-align:center;padding-bottom: 10px;' colspan='2'><img height='150px' width='150px' class='' src='$base/assets/images/customer/$mvalue->c_img' alt='Customer image'></td></tr>
                    <tr>
                        <td>Name:</td>
                        <td>$mvalue->c_name</td>
                        
                    </tr>
                    <tr>
                    <td>Id:</td>
                    <td>$mvalue->c_id</td>
                    </tr>
                    <tr>
                    <td>Email:</td>
                    <td>$mvalue->c_email</td>
                     </tr>
                     <tr>
                    <td>Contact:</td>
                    <td>$mvalue->cus_contact</td>
                     </tr>
                     <tr>
                    <td>Type:</td>
                    <td>Regular</td>
                     </tr>
                     <tr>
                    <td>Target:</td>
                    <td>$mvalue->target_amount</td>
                     </tr>
                     <tr>
                    <td>Target Discount(%) :</td>
                    <td>$mvalue->target_discount</td>
                     </tr>
                     <td>Regular Discount(%) :</td>
                    <td>$mvalue->regular_discount</td>
                     </tr>
                    </table>
                
                
                </div>
               
            </div>";
        }
        else{
    		redirect(base_url() , 'refresh');
    	}
}
public function GetBarcodeDomWhole(){
    if($this->session->userdata('user_login_access') != False) {
    $cid= $this->input->get('id');
    $mvalue = $this->customer_model->GetCustomerValueForPOS($cid);
            $base = base_url();
            
    echo "<div class='modal-body'>
            <div class='card-body'>
                <table style='width:100%'>
                <tr><td style='text-align:center;padding-bottom: 10px;' colspan='2'><img height='150px' width='150px' class='' src='$base/assets/images/customer/$mvalue->c_img' alt='Customer image'></td></tr>
                <tr>
                    <td>Name:</td>
                    <td>$mvalue->c_name</td>
                    
                </tr>
                <tr>
                <td>Id:</td>
                <td>$mvalue->c_id</td>
                </tr>
                <tr>
                <td>Email:</td>
                <td>$mvalue->c_email</td>
                 </tr>
                 <tr>
                <td>Contact:</td>
                <td>$mvalue->cus_contact</td>
                 </tr>
                 <tr>
                <td>Type:</td>
                <td>Wholesale</td>
                 </tr>
                 <tr>
                <td>Pharmacy:</td>
                <td>$mvalue->pharmacy_name</td>
                 </tr>
                 
                </table>
            
            
            </div>
           
        </div>";
    }
    else{
        redirect(base_url() , 'refresh');
    }
}
    public function Update_Balance(){
        if($this->session->userdata('user_login_access') != False) {
            $cid = $this->input->post('id');
            $total = $this->input->post('total');
            $paid = $this->input->post('paid');
            $due = $this->input->post('due');
            $pay = $this->input->post('pay');
            if($pay < 0){
                $response['status'] = 'error';
                $response['message'] = "Please Enter Valid Input";
                $this->output->set_output(json_encode($response));
            } else {
             $this->form_validation->set_rules('pay','Pay','trim|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $response['status'] = 'error';
                $response['message'] = validation_errors();
                $this->output->set_output(json_encode($response)); 
            } else {
                //update due in sales by id 
                $i = 0;
                $totpaid = 0;
                
                $ids =      $_POST['ids'];   
                $dueamnt      =   $_POST['dueamnt'];
                $paidamt     =   $_POST['paidamt'];
                $total_paid = 0;
                foreach($_POST['ids'] as $ids){
                    // if(!empty($_POST['ids'][$row])){
                
                $total_paid += $paidamt[$i];
                $balance =  $dueamnt[$i] - $paidamt[$i]; 
                $todaysdate = date('Y-m-d');
                $note = $total_paid . " Paid On ". $todaysdate;
                $totpaid = $total_paid + $paid;
        
                $data1 = array(
                   'due_amount' => $balance,
                   'note' => $note,
                   'paid_amount' => $totpaid
                );
                 
 
                $this->customer_model->update_dueinsales($ids, $data1);
                    $i++;
                }
               
                $tpaid = $total_paid + $paid;
                $tdue = abs($due - $total_paid);
                $data=array(
                    'customer_id'=> $cid,
                    'total_paid'=> $tpaid,
                    'total_due'=> $tdue
                );
                //print_r($data);
                $success = $this->customer_model->Update_Balance($cid,$data);
                



                $response['status'] = 'success';    
                $response['message'] = "Successfully Balance Updated";
                $response['curl'] = base_url()."Customer/Balance"; 
                $this->output->set_output(json_encode($response));                 
            }
        }
        }
        else{
            redirect(base_url() , 'refresh');
        } 
    }

    public function get_regular_cus()
    {
        $get_regular_cus = $this->customer_model->get_regular_cus();
        echo json_encode($get_regular_cus);
    }

    public function get_cus_data()
    {
        $cus_id = $this->input->post('id');
        $get_cus_data = $this->customer_model->get_cus_data($cus_id);
        echo json_encode($get_cus_data);
    }

    public function get_wholesale_cus()
    {
        $get_wholesale_cus = $this->customer_model->get_wholesale_cus();
        echo json_encode($get_wholesale_cus);
    }
    public function read_excel()
    {
        $picture = [];
        //---------------------------------------------------
        if(!empty($_FILES['picture']['name'])){
            $config['upload_path'] = 'excel';
            $config['allowed_types'] = 'xlsx';
            $config['file_name'] = $_FILES['picture']['name'];
            
            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            
            if($this->upload->do_upload('picture')){
                $uploadData = $this->upload->data();
                $picture[] = $uploadData['file_name'];
            
               
            }
        }
    
       if(!empty($picture))
       {
        $name = $picture[0];
       }
        
        //---------------------------------------------------
        require_once APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
        if(!empty($picture)){
            $path = "excel/$name";
           
        }else{
            $path = '';
        }
       
       if (file_exists($path)) {
        
            $objPHPExcel = PHPExcel_IOFactory::load($path);
            $sheet = $objPHPExcel->getActiveSheet();
    
            $highestRow = $sheet->getHighestDataRow();
            $highestColumn = $sheet->getHighestDataColumn();
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

            for ($row = 2; $row <= $highestRow; $row++) {

                for ($col = 0; $col < $highestColumnIndex; $col++) {

                    if($col == 0){
                        $medicine_name =  $sheet->getCellByColumnAndRow($col, $row)->getValue();
                        $get_medicine_id = $this->customer_model->get_medicine_id($medicine_name);
                      if(!empty($get_medicine_id)){
                        $get_igst = $this->customer_model->get_igst($get_medicine_id[0]->hsn);
                        $igst = $get_igst[0]->igst;
                      }
                       

                    }
                    if($col == 1){
                        $batch_num =  $sheet->getCellByColumnAndRow($col, $row)->getValue();
                    }
                    if($col == 2){
                        $expiry_date =  $sheet->getCellByColumnAndRow($col, $row)->getValue();
                        
                                            
                                            $date = DateTime::createFromFormat('d/m/Y', $expiry_date);
                                            $expirydate = $date->format('Y-m-d');
                                            print_r($expirydate);
                                            $expireyforgrn = $date->format('d-m-Y');
                       
                        
                    }

                    if($col == 3){
                    $supplier_name =  $sheet->getCellByColumnAndRow($col, $row)->getValue() ;
            
                    $getsupplier_id = $this->customer_model->getsupplier_id($supplier_name);
                  
                 
                    if(!empty($getsupplier_id))
                    {
                        $supplier_id = $getsupplier_id[0]->s_id;
                    }
                }
                if($col == 4){
                    $manu_name =  $sheet->getCellByColumnAndRow($col, $row)->getValue();
                    $get_manu_id = $this->customer_model->get_manu_id($manu_name);
            
                   
                
                }
                if($col == 5){
                    $purchase_rate =  $sheet->getCellByColumnAndRow($col, $row)->getValue();
                
                }
                if($col == 6){
                    $sale_rate =  $sheet->getCellByColumnAndRow($col, $row)->getValue() ;
                 
                }
                if($col == 7){
                    $qty =  $sheet->getCellByColumnAndRow($col, $row)->getValue();
                    
                }
           
                if($col == 8){
                    $invoice_id =  $sheet->getCellByColumnAndRow($col, $row)->getValue() ;
                
                }
                if($col == 9){
                    $invoice_date =  $sheet->getCellByColumnAndRow($col, $row)->getFormattedValue() ;
                   
                
                }
                if($col == 10){
                    $invoice_amount =  $sheet->getCellByColumnAndRow($col, $row)->getValue() ;
                     
                }
                if($col == 11){
                    $purchase_date =  $sheet->getCellByColumnAndRow($col, $row)->getFormattedValue() ;
                }
                if($col == 12){
                    $mrp =  $sheet->getCellByColumnAndRow($col, $row)->getFormattedValue() ;
                  
                }


                if($col == 13){
                    $html = '';
                    $grn =  $sheet->getCellByColumnAndRow($col, $row)->getFormattedValue() ;
                    $check_grn = $this->customer_model->check_grn($grn); 

                    if(empty($grn) || (!empty($check_grn)))
                    {
                        $html .= '<p class="para">'."Row ".$row . " - Not inserted".'</p>';
                        echo ($html); 
                    } 
                    else {

                    //--------------------------------------------------------------------
                    //Check Supplier
                    if(!empty($getsupplier_id))
                    {
                            $supplier_id = $getsupplier_id[0]->s_id;
                           
                            //check Manufacturer
                            if(!empty($get_manu_id))
                            {
                                
                                //print_r($get_manu_id);
                                    $manufac_id = $get_manu_id[0]->manufac_id;
                                    
                                    if(!empty($get_medicine_id)){
                                        
                                        $product_id = $get_medicine_id[0]->product_id;
                                                //  Add Purchase
                                                
                                                    $tax = ($invoice_amount * $igst) / 100;
                                                    $pur_date = date("m/d/Y");
                                                    $p_id =  'P'.rand(2000,10000000);
                                                    $data = array(
                                                      "p_id" =>  $p_id,
                                                      "sid" => $supplier_id,
                                                      "invoice_no" => $invoice_id,
                                                      "pur_date" => $purchase_date,
                                                      "tax" => $tax,
                                                      "gtotal_amount" => $invoice_amount,
                                                      "entry_id" => "U392",
                                                      "entry_date" => date("m/d/Y")
                                                    );
                                                    $add_purchase = $this->customer_model->add_purchase($data);
                                                    //print_r($add_purchase); 
                                                    $check_invoice = $this->customer_model->re_check_invoice($invoice_id);
                                                   
                                                    if(!empty($check_invoice))
                                                    {
                                                        
                                                      $p_id =  $check_invoice[0]->p_id;
                                                      
                                                      
                                                      $check_invoice = $this->customer_model->check_invoice($p_id, $supplier_id, $batch_num, $expiry_date);
                                                      
                                                      if(empty($check_invoice)){
                                                        //Add Purchase
                                                        
                                                        $total_amount = $qty * $purchase_rate;
                                                        $tax = ($total_amount * $igst)/100;

                                                        $history = array(
                                                            "pur_id" =>  $p_id,
                                                            "mid" => $product_id,
                                                            "supp_id" => $supplier_id,
                                                            "qty" => $qty,
                                                            "supplier_price" => $purchase_rate,
                                                            "expire_date" => $expirydate,
                                                            "Batch_Number" =>  $batch_num,
                                                            "mrp"  => $mrp,
                                                            "total_amount" => $total_amount, 
                                                            "tax"  => $tax
                                                        );
                                                   
                                                          $add_purchase_history = $this->customer_model->add_purchase_history($history);
                                                          //print_r($add_purchase_history);
                                                          // Add Purchase

                                                          $data = array(
                                                            "p_id" => $p_id,
                                                            "sid" => $supplier_id,
                                                            "invoice_no" => $invoice_id,
                                                            "pur_date" => $purchase_date,
                                                            "tax" => $tax,
                                                            "gtotal_amount" => $invoice_amount,
                                                            "entry_date" => date("m/d/Y"),
                                                            "entry_id" => "U392",
                                                         );
                                                         //$add_purchase = $this->customer_model->add_purchase($data); 
                                                         //print_r($add_purchase);     
                                                         
                                                         // Add supplier account 

                                                         $data2 = array(
                                                            "supplier_id" => $supplier_id,
                                                            "pur_id" => $p_id,
                                                            "total_amount" => $invoice_amount,
                                                            "paid_amount" => $invoice_amount,
                                                            "due_amount" => 0,
                                                            "date" => date("m/d/Y")                                                         
                                                         );
                                                         $add_suppaccount = $this->supplier_model->add_supp_account($data2);
                                                         //print_r($add_suppaccount);
                                                         //Add Supplier Payment
                                                         $supp_data = array(
                                                            "supp_id" => $supplier_id,
                                                            "pur_id" => $p_id,
                                                            "type" => "cash",
                                                            "bank_id" => '',
                                                            "cheque_no" => '',
                                                            "issue_date" => '',
                                                            "receiver_name" => '',
                                                            "receiver_contact" => '',
                                                            "paid_amount" => $invoice_amount,
                                                            "date" => date("m/d/Y")                                                         
                                                         );
                                                         $add_supp_payment = $this->supplier_model->add_supp_payment($supp_data);
                                                         //print_r($add_supp_payment);
                                                             //Add Medicine Meta
                                                             $check_existing_medicine = $this->customer_model->check_existing_medicine($product_id, $supplier_id, $batch_num);
                                                            // print_r($check_existing_medicine);
                                                             
                                                             if(!empty($check_existing_medicine)){
                                                                $previous_qty = $check_existing_medicine[0]->instock;
                                                                $new_stock =  $previous_qty + $qty;
                                                                $medicine_meta_stock = array(
                                                                    "instock" => $new_stock
                                                                );
                                                                $update_stock = $this->customer_model->update_stock($product_id, $supplier_id, $batch_num, $medicine_meta_stock);
                                                             
                                                                $get_stock = $this->customer_model->get_medicine_stock($product_id);
                                                               $stock = $get_stock[0]->instock;
                                                               $new_med_stock = $stock + $qty;
                                                               $med_stock = array(
                                                                "instock" => $new_med_stock
                                                                  );

                                                              $update_medicine_stock = $this->customer_model->update_medicine_stock($product_id, $med_stock);


                                                             }
                                                         else{
                                                             $medicine_meta = array(
                                                                "product_id" =>  $product_id,
                                                                "supplier_id" => $supplier_id,
                                                                "Batch_Number" => $batch_num,
                                                                "expire_date" => $expiry_date,
                                                                "purchase_rate" => $purchase_rate,
                                                                "mrp" =>  $mrp,
                                                                "instock"  => $qty,
                                                                //"tax" => $total_amount,
                                                                "status" => 1
                                                            );
                                                        
                                                            $add_medicine_meta = $this->customer_model->add_medicine_meta($medicine_meta);
                                                            //print_r($add_medicine_meta);
                                                             }

                                                     }
                                                    
                                                    } else {
                                                        
                                                       // Add purchase
                                                        // $data = array(
                                                        //    "p_id" => $p_id,
                                                        //    "sid" => $supplier_id,
                                                        //    "invoice_no" => $invoice_id,
                                                        //    "pur_date" => $purchase_date,
                                                        //    "tax" => $tax,
                                                        //    "gtotal_amount" => $invoice_amount,
                                                        //    "entry_date" => date("m/d/Y"),
                                                        //    "entry_id" => "U392",
                                                        // );
                                                        // $add_purchase = $this->customer_model->add_purchase($data);
                                                    }

                                                //     $check_med = $this->customer_model->check_med($product_id);
                                                //     if(empty($check_med)){
                                                //    // $add_purchase = $this->customer_model->add_purchase($data);
                                                //     }
                                                  
                                                //              // Add Medicine Meta
                                                //              $check_existing_medicine = $this->customer_model->check_existing_medicine($product_id, $supplier_id, $batch_num);
                                                //              print_r($check_existing_medicine);
                                                          
                                                //              if(!empty($check_existing_medicine)){
                                                //                 $previous_qty = $check_existing_medicine[0]->instock;
                                                //                 $new_stock =  $previous_qty + $qty;
                                                //                 $medicine_meta_stock = array(
                                                //                     "instock" => $new_stock
                                                //                 );
                                                //                 $update_stock = $this->customer_model->update_stock($product_id, $supplier_id, $batch_num, $medicine_meta_stock);
                                                             
                                                //                 $get_stock = $this->customer_model->get_medicine_stock($product_id);
                                                //                $stock = $get_stock[0]->instock;
                                                //                $new_med_stock = $stock + $qty;
                                                //                $med_stock = array(
                                                //                 "instock" => $new_med_stock
                                                //                   );

                                                //               $update_medicine_stock = $this->customer_model->update_medicine_stock($product_id, $med_stock);


                                                //              }
                                                //          else{
                                                //              $medicine_meta = array(
                                                //                 "product_id" =>  $product_id,
                                                //                 "supplier_id" => $supplier_id,
                                                //                 "Batch_Number" => $batch_num,
                                                //                 "expire_date" => $expiry_date,
                                                //                 "purchase_rate" => $purchase_rate,
                                                //                 "mrp" =>  $mrp,
                                                //                 "instock"  => $qty,
                                                //                 //"tax" => $total_amount,
                                                //                 "status" => 1
                                                //             );
                                                        
                                                //             $add_medicine_meta = $this->customer_model->add_medicine_meta($medicine_meta);
                                                //              }
                                                             
                                         // Store medicine meta
                                         $store_id = 78;
                                         $check_med_store_meta = $this->customer_model->check_med_store_meta($product_id, $supplier_id, $batch_num, $store_id);
                                         if(empty($check_med_store_meta)){
                                            $stck = array(
                                                "product_id" => $product_id, 
                                                "supplier_id" => $supplier_id,
                                                "Batch_Number" => $batch_num,
                                                "expire_date" => $expiry_date,
                                                "purchase_rate" => $purchase_rate,
                                                "mrp" => $mrp,
                                                "instock" => $qty,
                                                "tax" => $tax,
                                                "store_id" => $store_id,
                                                "status" => 1
                                             );
                                             $insert = $this->customer_model->insert_medicine_meta_store($stck);
                                            // print_r($insert);
                                         }else{
                                            $check_pre_record = $this->customer_model->check_pre_record($product_id, $batch_num, $expiry_date, $supplier_id, $store_id);
                                            $pre = $check_pre_record[0]->instock;
                                            $new = $pre + $qty;
                                            $data = array(
                                                "instock"  => $new
                                            );
                                            $update_store_medi_meta = $this->customer_model->update_store_medi_meta($product_id, $batch_num, $expiry_date, $supplier_id, $store_id, $data);

                                         }

                                        // Add GRN
                                    

                                        $grn_data = array(
                                            "store_name" => '' ,
                                            "po_no" => $p_id,
                                            "supplier_name" => $supplier_name,
                                            "order_type" => "Tablet",
                                            "supplier_code" => $supplier_id ,
                                            "grn_no" => $grn ,
                                            "dc_no" => '',
                                            "dc_date" => '',
                                            "bill_no" =>  $invoice_id ,
                                            "bill_date" => '',
                                            "bill_amt" => '',
                                            "product_name" => $medicine_name,
                                            "generic_name" => '' ,
                                            "manf_date" => '',
                                            "sale_qty" => '',
                                            "unit_price" => '',
                                            "box_price" => '' ,
                                            "purchase" => '',
                                            "Sch_no" => '',
                                            "Sch_date" => '',
                                            "rec_qty" => $qty,
                                            "receivedamt" => '',
                                            "dues" => '',
                                        );
                                        $insertingrn = $this->customer_model->insert_in_grn($grn_data);
                                       // print_r($insertingrn);
                                        $grn_meta = array(
                                            "grn_no" => $grn,
                                            "product_id" => $get_medicine_id[0]->product_id,
                                            "Batch_Number" => $batch_num,
                                            "instock" =>  $qty,
                                            "expire_date" => $expireyforgrn,
                                            "Sch_no" => "",
                                            "Sch_date" => "",
                                            "rec_qty" => $qty,
                                            "price" => $mrp
                                           
                                        );
                                        $insert_grn_meta = $this->customer_model->insert_grn_meta($grn_meta);
                                        //print_r($insert_grn_meta);
                                     
                                      
                                         $response['status'] = 'success';
                                         $response['message'] = "Successfully Added";
                                         $response['curl'] = base_url()."Invantory/import_inventory";
                                         $this->output->set_output(json_encode($response)); 

                                        
                                


 
                                    }
                                    else{
                                        //print_r("No medicine Found");
                                                    $html .= '<p class="para">'."Row ".$row . " - Not inserted".'</p>';
                                                    echo ($html);
                                    }
                                  
                            
                            }
                            else{
                                // print_r("No Manufacturer Found");
                       
                               
                                $html .= '<p class="para">'."Row ".$row . " - Not inserted".'</p>';
                                echo ($html);


                            }
                            $response['status'] = 'success';
                            $response['message'] = "Successfully Added";
                            $response['curl'] = base_url()."Invantory/import_inventory";
                            $this->output->set_output(json_encode($response)); 
                    }
                    else{
                     // print_r("No supplier found");
                       
                        $html .= '<p class="para">'."Row ".$row . " - Not inserted".'</p>';
                        echo ($html);  
                    }
                }
                //---------------------------------------------------------------------------------- 
                }
            }
         
               
            }
            unlink($path);
        }
        else {
            
        }
    }
    public function read_manufacturer()
    {
        $picture = [];
        $response = ['status' => 'error', 'message' => 'An error occurred'];
    
        if (!empty($_FILES['picture']['name'])) {
            $config['upload_path'] = './assets/images/customer';
            $config['allowed_types'] = 'xlsx';
            $config['file_name'] = $_FILES['picture']['name'];
    
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('picture')) {
                $uploadData = $this->upload->data();
                $picture[] = $uploadData['file_name'];
            } else {
                $response['message'] = $this->upload->display_errors();
                $this->output->set_output(json_encode($response));
                return;
            }
        }
    
        if (!empty($picture)) {
            $name = $picture[0];
        } else {
            $response['message'] = 'No file uploaded.';
            $this->output->set_output(json_encode($response));
            return;
        }
    
        require_once APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
    
        $path = "./assets/images/customer/$name";
    
        if (file_exists($path)) {
            try {
                $objPHPExcel = PHPExcel_IOFactory::load($path);
                $sheet = $objPHPExcel->getActiveSheet();
                $highestRow = $sheet->getHighestDataRow();
                $highestColumn = $sheet->getHighestDataColumn();
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    
                
                
    
                $this->load->model('manufacturer_model'); 
    
                for ($row = 2; $row <= $highestRow; $row++) {
                    $manufacturerName = $sheet->getCellByColumnAndRow(0, $row)->getValue();

                    $existingManufacturers = $this->supplier_model->getallmanufacturer();               
                    $existingManufacturerNames = array_column($existingManufacturers, 'm_name');
                    
                    if (!empty($manufacturerName)) {
                        
                        if (!in_array($manufacturerName, $existingManufacturerNames)) {
                            $manufacidid = 'M' . rand(100, 50000);
    
                            $data = array(
                                'm_name' => $manufacturerName,
                                'manufac_id' => $manufacidid
                            );
    
                           $success = $this->db->insert('manufacturer', $data);
                        }
                    }
                }
    
                
                    $response['status'] = 'success';
                    $response['message'] = 'Manufacturers imported successfully';
                    $response['curl'] = base_url() . "Manufacturer/manufacturer";
                    $this->output->set_output(json_encode($response));
                    
                
               
            } catch (Exception $e) {
                $response['message'] = 'Error reading Excel file: ' . $e->getMessage();
            }
    
            unlink($path);
        } else {
            $response['message'] = 'File does not exist.';
        }
    
        
    }
    

            public function import_manufac()
            {
                if ($this->session->userdata('user_login_access') != false) {  
                $this->load->view('backend/import_manufacturer');
            }
            else {
                redirect(base_url(), 'refresh');
            }
        }



        
        public function read_supplier()
        {
            $picture = [];
            $response = ['status' => 'error', 'message' => 'An error occurred'];
        
            
            if (!empty($_FILES['picture']['name'])) {
                // Configure upload settings
                $config['upload_path'] = './assets/images/customer';
                $config['allowed_types'] = 'xlsx';
                $config['file_name'] = $_FILES['picture']['name']; 
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
        
                
                if ($this->upload->do_upload('picture')) {
                    $uploadData = $this->upload->data();
                    $picture[] = $uploadData['file_name'];
                } else {
                    $response['message'] = $this->upload->display_errors();
                    $this->output->set_output(json_encode($response));
                    return;
                }
            }
        
            if (!empty($picture)) {
                $fileName = $picture[0];
            } else {
                $response['message'] = 'No file uploaded.';
                $this->output->set_output(json_encode($response));
                return;
            }
        
            require_once APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
        
            $path = "./assets/images/customer/$fileName";
        
            
            if (file_exists($path)) {
                try {
                    $objPHPExcel = PHPExcel_IOFactory::load($path);
                    $sheet = $objPHPExcel->getActiveSheet();
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();
        
                    $this->load->model('supplier_model'); 
        
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $existinggstnumbers = $this->supplier_model->getallgstnumbers();
                        $existinghsn_num = array_column($existinggstnumbers, 's_gst');

                        $supplierName = $sheet->getCellByColumnAndRow(0, $row)->getValue();
                        $gstNumber = $sheet->getCellByColumnAndRow(1, $row)->getValue();
                        $phoneNumber = $sheet->getCellByColumnAndRow(2, $row)->getValue();
                        $emailAddress = $sheet->getCellByColumnAndRow(3, $row)->getValue();
                        $status = 'Active';
                        $address = $sheet->getCellByColumnAndRow(4, $row)->getValue();
                        $sid = 'S'.rand(100,25000);
                        $date      =   date('m-d-Y');
                        if (!empty($supplierName)) {
                            if (!in_array($gstNumber, $existinghsn_num)) {
                                

                            $data = [
                                's_name' => $supplierName,
                                's_gst' => $gstNumber,
                                's_phone' => $phoneNumber,
                                's_email' => $emailAddress,
                                'status' => $status,
                                's_id'  => $sid,
                                's_address' => $address,
                                'entrydate' => $date
                            ];
                            $this->db->insert('supplier', $data);
                        }
                        }
                    }
        
                    $response = [
                        'status' => 'success',
                        'message' => 'Suppliers imported successfully',
                        'curl' => base_url() . "Supplier/View" 
                    ];
                } catch (Exception $e) {
                    $response['message'] = 'Error reading Excel file: ' . $e->getMessage();
                }
        
                
                unlink($path);
            } else {
                $response['message'] = 'File does not exist.';
            }
        
            $this->output->set_output(json_encode($response));
        }
        

public function import_supplier()
{
    if ($this->session->userdata('user_login_access')) {  
        $this->load->view('backend/import_supplier'); 
    } else {
        redirect(base_url(), 'refresh');
    }
}

public function download($filename = 'Supplier_List_sample.xlsx')
{
    $response = ['status' => 'error', 'message' => 'An error occurred'];

  
    if (empty($filename)) {
        $response['message'] = 'No file specified.';
        $this->output->set_output(json_encode($response));
        return;
    }

    
    $filePath = './assets/images/customer/' . $filename;

    
    if (file_exists($filePath)) {
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

       
        ob_clean();
        flush();

        
        readfile($filePath);
        exit; 
    } else {
        $response['message'] = 'File does not exist.';
        $this->output->set_output(json_encode($response));
        return;
    }
}
public function downloadmanu($filename = 'ManufacturerList_sample.xlsx')
{
    $response = ['status' => 'error', 'message' => 'An error occurred'];

  
    if (empty($filename)) {
        $response['message'] = 'No file specified.';
        $this->output->set_output(json_encode($response));
        return;
    }

    
    $filePath = './assets/images/customer/' . $filename;

    
    if (file_exists($filePath)) {
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

       
        ob_clean();
        flush();

        
        readfile($filePath);
        exit; 
    } else {
        $response['message'] = 'File does not exist.';
        $this->output->set_output(json_encode($response));
        return;
    }
}


}