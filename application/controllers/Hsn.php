<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Hsn extends CI_Controller {




	    function __construct() {
        parent::__construct();
        $this->load->helper(array('form','url'));
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->model('Hsn_model');
        $this->load->model('medicine_model');
        
        global $pic;
}
public function permissionsbyemrole(){
    $id = $_SESSION['user_type'];
    $permission = $this->user_model->getAllpermissionsbyemid($id);  
    return $permissions1 = $permission[0]->permissions;
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

    
    public function Createhsn(){

        

        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
        if (in_array(11, $permissions)) { 
            $this->load->view('backend/Add_hsn');
        }
        else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
        }
        else{
    		redirect(base_url() , 'refresh');
    	}            
    }
    public function Savehsn(){
        $hsn_num =  $this->input->post('hsn_num');
        $cgst =  $this->input->post('cgst');
        $sgst =  $this->input->post('sgst');
        $igst =  $this->input->post('igst');
        $data = array(
            'hsn_num' => $hsn_num,
            'cgst' => $cgst,
            'sgst' => $sgst,
            'igst' => $igst
        );

       $success = $this->Hsn_model->Savehsn($data);
       
       if($success != ''){

        $response['status'] = 'success';    
        $response['message'] = "Successfully Added";
        $response['curl'] = base_url('Hsn/Viewhsn'); 
        $this->output->set_output(json_encode($response));

       }else{
        echo "error";

       }


        

                   
    }


    
    public function Viewhsn(){

        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
        if (in_array(10, $permissions)) { 
            $data['hsnList'] = $this->Hsn_model->getAllHsn();
            $data['permissions1'] = $this->permissionsbyemrole();
            $this->load->view('backend/List_hsn',$data);
        }
        else {
            redirect(base_url().'Sales/auth_error', 'refresh');
        }
        }
        else{
    		redirect(base_url() , 'refresh');
    	}            
    }


    //delete function
    public function delete_hsn()
    {
        $hsnnum = $this->uri->segment(3);
        $delete_hsn= $this->Hsn_model->delete_hsn($hsnnum);
        redirect('Hsn/Viewhsn');
         
    }
   
    //edit function for hsn
    // public function edit_hsn()
    // {
    //  $hsnnum = $this->uri->segment(3);
    //  $data['gst']= $this->Hsn_model->edit_hsn($hsnnum);
    //  $this->load->view('backend/edit_hsn', $data);
    // }


    public function GetHsnBynum(){
        if($this->session->userdata('user_login_access') != False) {
        $id= $this->input->get('id');
        $data= array();
        $data = $this->Hsn_model->GetHsnById($id);
        echo json_encode($data);
        }
        else{
            redirect(base_url() , 'refresh');
        }        
    }

    
    public function update_hsn()
    {
        $id= $this->input->get('id');
     
        $hsn_num= $this->input->post('hsn_num');
        $igst= $this->input->post('igst');
        $sgst= $this->input->post('sgst');
        $cgst= $this->input->post('cgst');
       $data = array(
        'hsn_num' => $hsn_num,
        'igst' => $igst,
        'sgst' => $sgst,
        'cgst' => $cgst
       );
 
   
        $update_hsn= $this->Hsn_model->update_hsn($id, $data);
        $response['status'] = 'success';    
        $response['message'] = "Successfully Updated";
        $response['curl'] = base_url("Hsn/Viewhsn"); 
        $this->output->set_output(json_encode($response)); 
         
    }

    public function get_hsnnumber()
    {
     $get_hsnnumber =  $this->Hsn_model->getAllHsn();
     echo json_encode($get_hsnnumber);
    }



}
