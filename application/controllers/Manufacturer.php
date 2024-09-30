<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Manufacturer extends CI_Controller {




	    function __construct() {
        parent::__construct();
        $this->load->helper(array('form','url'));
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->model('Hsn_model');
        $this->load->model('medicine_model');
        $this->load->model('Manufacturer_model');
        $this->load->model('Supplier_model');
        global $pic;
}

	public function index()

	{
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
    public function manufacturer()
    {
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                if (in_array(6, $permissions)) { 
            $data['manufacturerList'] = $this->Manufacturer_model->getAllmanufacturer();
            $data['manufacturerid'] =  $this->Manufacturer_model->getAllmanufacturerid();
            $data['permissions1'] = $this->permissionsbyemrole();
            $this->load->view('backend/List_manufacturer',$data);
        }
        else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
        }
        else{
    		redirect(base_url() , 'refresh');
    	}            
    


    }
    public function checkmanuname(){
        $manuname = $this->input->post('m_name');
        $supplier1 = $this->Manufacturer_model->checkmanufacname($manuname);
        if(!empty($supplier1)){ echo "error";}else{echo "success";}

    }
    public function Savemanufacturer(){
        $mname = $this->input->post('m_name');
        $productid = 'M' . rand(100, 50000);
        $mnote = $this->input->post('note');
    
        $data = array(
            'm_name' => $mname,
            'manufac_id' => $productid,
            'note' => $mnote,
        );
    
        $this->db->insert('manufacturer', $data);
    
        $response = array(
            'status' => 'success',
            'message' => 'Manufacturer added successfully',
            'curl' => base_url('Manufacturer/manufacturer'),
        );
    
        echo json_encode($response);
    }
    
    public function GetmanufacturerBynum(){
        if($this->session->userdata('user_login_access') != False) {
        $id= $this->input->get('id');
        $data= array();
        $data = $this->Manufacturer_model->GetmanufacturerById($id);
        echo json_encode($data);
        }
        else{
            redirect(base_url() , 'refresh');
        }        
    }

    public function update_manu()
    {
        $id= $this->input->get('id');
     
        $mname= $this->input->post('m_name');
        $note= $this->input->post('note');

       $data = array(
        'm_name' => $mname,
        'note' => $note
       );
 
   
        $update_manu= $this->Manufacturer_model->update_manu($id, $data);
        $response['status'] = 'success';    
        $response['message'] = 'Successfully Updated';
        $response['curl'] = base_url("Manufacturer/manufacturer"); 
        
        echo json_encode($response);
         
    }

    public function delete_manu()
    {
       $id =  $this->uri->segment(3);
       $delete_manu = $this->Manufacturer_model->delete_manu($id);
       redirect('Manufacturer/manufacturer');
        
    }

}
