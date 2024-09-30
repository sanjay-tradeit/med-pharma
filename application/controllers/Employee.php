<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

	    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->model('medicine_model');
        $this->load->model('Invoice_model');
        $this->load->model('Supplier_model');
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
    public function checkempname(){
        $supname = $this->input->post('emname');

        $supplier = $this->Supplier_model->checkempname($supname);
        if(!empty($supplier)){ echo "error";}else{echo "success";}

    }
    public function permissionsbyemrole(){
        $id = $_SESSION['user_type'];
        $permission = $this->user_model->getAllpermissionsbyemid($id);  
        return $permissions = $permission[0]->permissions;
    }

    public function Create(){
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                    if (in_array(27, $permissions) || in_array(97, $permissions))
                    {
        $data['rolelist'] = $this->user_model->getAllRoles();
        $data['store'] = $this->user_model->get_stores();
        $data['permissions'] = $this->user_model->getAllpermissionsModules();
        $this->load->view('backend/Add_Employee', $data);
    }
    else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }
    
    public function GetEmployeeById(){
        if($this->session->userdata('user_login_access') != False) {
        $id= $this->input->get('id');
        $data= array();
        $data['employee'] = $this->user_model->GetEmployeeValueById($id);


        $data['allStores'] = $this->user_model->get_all_stores();

      

      

        echo json_encode($data);
        }
        else{
            redirect(base_url() , 'refresh');
        }        
    }
    public function View(){
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
            
            if (in_array(26, $permissions) || in_array(100, $permissions)){
        $data['userList'] = $this->user_model->getAllUser();
        $data['userListspecific'] = $this->user_model->getAllUserforstore($_SESSION['store_id']);
        $data['rolelist'] = $this->user_model->getAllRoles();  
        $data['permissions1'] = $this->permissionsbyemrole();
        $this->load->view('backend/List_employee',$data);
    }
    else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
    }
    else{
        redirect(base_url() , 'refresh');
    } 
        }

    public function permissions(){
        if($this->session->userdata('user_login_access') != False) {
        $data['permissions_modules'] = $this->user_model->getAllpermissionsModules();
        
        $data['rolelist'] = $this->user_model->getAllRoles();
        $this->load->view('backend/permissions',$data);
    }
    else{
        redirect(base_url() , 'refresh');
    } 
        }

        public function edit_role(){

            if($this->session->userdata('user_login_access') != False) {
    
                $id = $_GET['pid'];
                $data['permissions_modules'] = $this->user_model->getAllpermissionsModules();
        
                $data['rolelist'] = $this->user_model->getAllRoles();
                $data['roledata'] = $this->user_model->getRoledatabyid($id);
               
                
                $this->load->view('backend/editpermissions',$data);
            }
            else{
                redirect(base_url() , 'refresh');
            }            
        }

    public function permissionsbymodulename($module){
        
        return $this->user_model->getAllpermissionsbyModule($module);   
    }
    
    
    public function save_permissions(){

        $rolename = $this->input->post('emname');
        $selectedPermissions = implode(',', $_POST['permissionid']);
        $data = array();
                $data = array(
                    'title' => $rolename,
                    'permissions' => $selectedPermissions
                );
        $success = $this->user_model->Add_permissionsinroles($data);
        $response['status'] = 'success';    
        $response['message'] = "Successfully Created";
        $response['curl'] = base_url(). "Employee/permissions"; 
        $this->output->set_output(json_encode($response)); 
        

    }
    public function update_permissions(){

        $roleid = $this->input->post('emid');
        $rolename = $this->input->post('emname');
        $selectedPermissions = implode(',', $_POST['permissionid']);
        $data = array();
                $data = array(
                    'title' => $rolename,
                    'permissions' => $selectedPermissions
                );
        $success = $this->user_model->Update_permissionsinroles($roleid,$data);
        $response['status'] = 'success';    
        $response['message'] = "Successfully Updated";
        $response['curl'] = base_url(). "Employee/permissions"; 
        $this->output->set_output(json_encode($response)); 
        

    }
    
    public function delete_role()
    {
       $id =  $this->uri->segment(3);
       $delete_manu = $this->user_model->delete_role($id);
       redirect('Employee/View');
    }



    public function Save(){
        $id = $this->input->post('emid');
        $name = $this->input->post('emname');
        $emid = 'E'.rand(100,500);        
        $phone = $this->input->post('emphone');
        $email = $this->input->post('ememail');
        $address = $this->input->post('emaddress');
        $password = $this->input->post('passone');
        $confirm = $this->input->post('passtwo');
        $role = $this->input->post('emroll');
        $status = $this->input->post('emstatus');
        $note = $this->input->post('emnote');
        $store = $this->input->post('store');
        $emptype = $this->input->post('emtype');
        $entrydate = date("d/m/Y");
        $this->load->library('image_lib');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('emname', 'name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('emphone', 'phone', 'trim|required|min_length[10]|max_length[13]|xss_clean');
        $this->form_validation->set_rules('ememail', 'email', 'trim|required|min_length[7]|max_length[150]|xss_clean');
        $this->form_validation->set_rules('emaddress', 'address', 'trim|required|min_length[5]|max_length[256]|xss_clean');
        if($this->form_validation->run() == FALSE){
		    $response['status'] = 'error';
            $response['message'] = validation_errors();
            $this->output->set_output(json_encode($response));
        } else {
           if($this->login_model->Does_email_exists($email) && $password == $confirm){
            $response['status'] = 'error';
            $response['message'] = "Email is already exist";
            $this->output->set_output(json_encode($response));
            } else {
                if($password != $confirm){
                 $response['status'] = 'error';
                 $response['message'] = "Passwords do not match.";
                 $this->output->set_output(json_encode($response));
                 }else {
            
         if($_FILES['img_url']['name']){
            $file_name = $_FILES['img_url']['name'];
			$fileSize = $_FILES["img_url"]["size"]/1024;
			$fileType = $_FILES["img_url"]["type"];
			$new_file_name='';
            $new_file_name .= $emid;

            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./assets/images/users",
                'allowed_types' => "gif|jpg|png|jpeg",
                'overwrite' => False,
                'max_size' => "20240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "4000",
                'max_width' => "4000"
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('img_url')) {
            $response['status'] = 'error';
            $response['message'] = $this->upload->display_errors();
            $this->output->set_output(json_encode($response));                
			}
			else {
            $image_data =   $this->upload->data();
            $configer =  array(
              'image_library'   => 'gd2',
              'source_image'    =>  $image_data['full_path'],
              //'create_thumb'    => TRUE,    
              'maintain_ratio'  =>  TRUE,
              'width'           =>  160,
              'height'          =>  100,
            );
            $this->image_lib->clear();
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();                 
                $path = $this->upload->data();
                $img_url = $path['file_name'];
                $data = array();
                $data = array(
                    'em_id' => $emid,
                    'em_name' => $name,
                    'email' => $email,
                    'password' => sha1($password),
                    'em_role' => $role,
                    'em_type' => $emptype,
                    'em_contact' => $phone,
                    'em_address' => $address,
					'em_image'=>$img_url,
					'em_details'=>$note,
					'em_entrydate'=>strtotime($entrydate),
					'em_ip'=>$this->input->ip_address(),
                    'store' =>$store,
					'status'=>$status
                );
        $success = $this->user_model->Add_user_info($data);
        $response['status'] = 'success';    
        $response['message'] = "Successfully Added";
        $response['curl'] = base_url()."Employee/View"; 
        $this->output->set_output(json_encode($response)); 
            }
        } else {
                $data = array();
                $data = array(
                    'em_id' => $emid,
                    'em_name' => $name,
                    'email' => $email,
                    'password' => sha1($password),
                    'em_role' => $role,
                    'em_type' => $emptype,
                    'em_contact' => $phone,
                    'em_address' => $address,
					'em_details'=>$note,
					'em_entrydate'=>strtotime($entrydate),
					'em_ip'=>$this->input->ip_address(),
                    'store' =>$store,
					'status'=>$status
                );
        $success = $this->user_model->Add_user_info($data);
        $response['status'] = 'success';    
        $response['message'] = "Successfully Created";
        $response['curl'] = base_url(). "Employee/View"; 
        $this->output->set_output(json_encode($response));     
            }
                    
        }
        }
    }
}
    public function Update(){
        $id = $this->input->post('eid');
        $name = $this->input->post('emname');       
        $phone = $this->input->post('emphone');
        $email = $this->input->post('ememail');
        $password = $this->input->post('passone');
        $address = $this->input->post('emaddress');
        $role = $this->input->post('emroll');
        $status = $this->input->post('emstatus');
        $emptype = $this->input->post('emtype');
        $note = $this->input->post('emnote');
        $store = $this->input->post('store');
        $this->load->library('image_lib');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('emname', 'name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('emphone', 'phone', 'trim|required|min_length[10]|max_length[13]|xss_clean');
        $this->form_validation->set_rules('ememail', 'email', 'trim|required|min_length[7]|max_length[150]|xss_clean');
        $this->form_validation->set_rules('emaddress', 'address', 'trim|required|min_length[5]|max_length[256]|xss_clean');
        if($this->form_validation->run() == FALSE){
		    $response['status'] = 'error';
            $response['message'] = validation_errors();
            $this->output->set_output(json_encode($response));
        } else {
         if($_FILES['img_url']['name']){
            $file_name = $_FILES['img_url']['name'];
			$fileSize = $_FILES["img_url"]["size"]/1024;
			$fileType = $_FILES["img_url"]["type"];
			$new_file_name='';
            $new_file_name .= $id;

            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./assets/images/users",
                'allowed_types' => "gif|jpg|png|jpeg",
                'overwrite' => False,
                'max_size' => "20240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "4000",
                'max_width' => "4000"
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('img_url')) {
            $response['status'] = 'error';
            $response['message'] = $this->upload->display_errors();
            $this->output->set_output(json_encode($response));                
			}
			else {
                $image = $this->user_model->GetEmployeeValueById($id);
            $checkimage = "./assets/images/users/$image->em_image";                 
                if(!empty($image->em_image)){
            	unlink($checkimage);
				} 
            $image_data =   $this->upload->data();
            $configer =  array(
              'image_library'   => 'gd2',
              'source_image'    =>  $image_data['full_path'],
              //'create_thumb'    => TRUE,    
              'maintain_ratio'  =>  TRUE,
              'width'           =>  160,
              'height'          =>  100,
            );
            $this->image_lib->clear();
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();                 
                $path = $this->upload->data();
                $img_url = $path['file_name'];
                $data = array();
                $data = array(
                    'em_name' => $name,
                    'email' => $email,
                    'em_role' => $role,
                    'em_type' => $emptype,
                    'em_contact' => $phone,
                    'em_address' => $address,
					'em_image'=>$img_url,
					'em_details'=>$note,
                    'store' => $store,
					'em_ip'=>$this->input->ip_address(),
					'status'=>$status
                );
                if (!empty($password)) {
                    $data['password'] = sha1($password);
                }
        $success = $this->user_model->Update_user_info($id,$data);
        $response['status'] = 'success';    
        $response['message'] = "Successfully Updated";
        $response['curl'] = base_url()."Employee/View"; 
        $this->output->set_output(json_encode($response)); 
            }
        } else {
                $data = array();
                $data = array(
                    'em_name' => $name,
                    'email' => $email,
                    'em_role' => $role,
                    'em_type' => $emptype,
                    'em_contact' => $phone,
                    'em_address' => $address,
					'em_details'=>$note,
                    'store' => $store,
					'em_ip'=>$this->input->ip_address(),
					'status'=>$status
                );
                if (!empty($password)) {
                    $data['password'] = sha1($password);
                }    
        $success = $this->user_model->Update_user_info($id,$data);
        $response['status'] = 'success';    
        $response['message'] = "Successfully Updated";
        $response['curl'] = base_url(). "Employee/View"; 
        $this->output->set_output(json_encode($response));     
            }
        }
    }
    public function Reset_Password(){
        if($this->session->userdata('user_login_access') != False) {

        $userid =$this->session->userdata('user_login_id');
       // print_r($userid);
        $pass = $this->input->post('pass');
        $c_pass = $this->input->post('c_pass');
       
            if($pass == $c_pass){
                $data = array();
                $data = array(
                    'password'=> sha1($pass)
                );
        $success = $this->user_model->Reset_Password($userid,$data);
       
        $this->session->set_flashdata('feedback','Successfully Updated');
        #redirect("employee/view?I=" .base64_encode($id));
        $response['status'] = 'success';   
        $response['message'] = "Successfully Updated";
        $response['curl'] = base_url(). "dashboard/Dashboard";         
        $this->output->set_output(json_encode($response));  
            } 
            else
             {
               
             // $response['status'] = 'error';   
             // $response['message'] = "Please enter valid password";  
             $this->session->set_flashdata('error','Please enter correct password'); 
             $response['status'] = 'success';   
             $response['message'] = "Successfully Updated";
             $response['curl'] = base_url(). "dashboard/Dashboard";         
             $this->output->set_output(json_encode($response));  
            }

        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }   

        
        
    

    public function delete_emp()
    {
       $id =  $this->uri->segment(3);
       $delete_manu = $this->user_model->delete_emp($id);
       redirect('Employee/View');
    }

    public function getstore()
    {
       return  $data = $this->user_model->get_stores();  
    }
    public function get_all_stores()
    {
       return  $data = $this->user_model->get_all_stores(); 
    }
    public function getrolename($id)
    {
       return  $data = $this->user_model->GetEmployeerolenameByid($id); 
    }
 
    public function get_store_name($store_id){


       return $data = $this->Invoice_model->get_store_name($store_id);
       
    }
    public function RoleAndPermissiondata(){
        if ($this->session->userdata('user_login_access') != False) {
            $id          = $this->input->get('id');
           
            $medicine    = $this->medicine_model->getSupplierMedicine($id);

            $medsubform = $this->medicine_model->getMedicinesubForm($id);
            

            $medsubFormArray= explode(',',$medsubform[0]->subform);
            

            
            
          
         
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
        else {
            redirect(base_url(), 'refresh');
        }
    }
}