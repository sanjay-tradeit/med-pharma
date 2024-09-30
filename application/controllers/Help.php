<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Help extends CI_Controller {

        function __construct() {

        parent::__construct();

        $this->load->database();

        $this->load->model('login_model');

        $this->load->model('user_model');

        $this->load->model('medicine_model');
        $this->load->model('help_model');
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

    public function permissionsbyemrole(){
        $id = $_SESSION['user_type'];
        $permission = $this->user_model->getAllpermissionsbyemid($id);  
        return $permissions1 = $permission[0]->permissions;
    }
    public function Phone_book()
    {
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
            if (in_array(76, $permissions)) {
        $data['phonebook'] = $this->customer_model->phone_book();
        $this->load->view('backend/phone_book',$data);
    } else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
    }
    else{
        redirect(base_url() , 'refresh');
    } 
        }
    public function add_phonebook()
    {
        if($this->session->userdata('user_login_access') != False) {

            $name = $this->input->post('name');
            $contact = $this->input->post('contact');
            $email = $this->input->post('email');
            $address = $this->input->post('address');
            
            $this->form_validation->set_rules('name','Name','trim|required|min_length[5]|max_length[100]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $feedback['error'] = validation_errors();
                echo json_encode($feedback);
            } else {
                $data=array(
                    'name'=> $name,
                    'contact'=> $contact,
                    'email'=> $email,
                    'address'=> $address
                );

                $success = $this->help_model->insertPhonebook($data);

                if($success) {
                    $feedback = array(
                        'message'=> "Done!"
                    );
                    echo json_encode($feedback);
                }
            }
        }
        else{
            redirect(base_url() , 'refresh');
        } 
    }
    public function Doctor()
    {
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
    if (in_array(77, $permissions)) {
        $data['doctor'] = $this->help_model->GetDoctorInfo();
        $data['permissions1'] = $this->permissionsbyemrole();
        $this->load->view('backend/doctor',$data);
    } else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
    }
    else{
        redirect(base_url() , 'refresh');
    } 
}
    public function add_doctor()
    {
        if($this->session->userdata('user_login_access') != False) {

            $name = $this->input->post('name');
            $contact = $this->input->post('contact');
            $email = $this->input->post('email');
            $address = $this->input->post('address');
            
            $this->form_validation->set_rules('name','Name','trim|required|min_length[5]|max_length[100]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $feedback['error'] = validation_errors();
                echo json_encode($feedback);
            } else {
                $data=array(
                    'name'=> $name,
                    'contact'=> $contact,
                    'email'=> $email,
                    'address'=> $address
                );

                $success = $this->help_model->insertDoctor($data);

                if($success) {
                    $feedback = array(
                        'message'=> "Done!"
                    );
                    echo json_encode($feedback);
                }
            }
        }
        else{
            redirect(base_url() , 'refresh');
        } 
    }
    public function Hospital()
    {
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
    if (in_array(79, $permissions)) {
        $data['hospital'] = $this->help_model->GetHospitalInfo();
        $data['permissions1'] = $this->permissionsbyemrole();
        $this->load->view('backend/hospital',$data);
    } else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
    }
    else{
        redirect(base_url() , 'refresh');
    } 
      }
    public function add_hospital()
    {
        if($this->session->userdata('user_login_access') != False) {

            $name = $this->input->post('name');
            $contact = $this->input->post('contact');
            $email = $this->input->post('email');
            $address = $this->input->post('address');
            
            $this->form_validation->set_rules('name','Name','trim|required|min_length[5]|max_length[100]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $feedback['error'] = validation_errors();
                echo json_encode($feedback);
            } else {
                $data=array(
                    'name'=> $name,
                    'contact'=> $contact,
                    'email'=> $email,
                    'address'=> $address
                );

                $success = $this->help_model->insertHospital($data);

                if($success) {
                    $feedback = array(
                        'message'=> "Done!"
                    );
                    echo json_encode($feedback);
                }
            }
        }
        else{
            redirect(base_url() , 'refresh');
        } 
    }
    public function Ambulance()
    {
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
            if (in_array(81, $permissions)) {
        $data['ambulance'] = $this->help_model->GetAmbulance();
        $data['permissions1'] = $this->permissionsbyemrole();
        $this->load->view('backend/ambulance', $data);
    } else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
    }
    else{
        redirect(base_url() , 'refresh');
    } 
   }
    public function add_ambulance()
    {
        if($this->session->userdata('user_login_access') != False) {

            $name = $this->input->post('name');
            $contact = $this->input->post('contact');
            $email = $this->input->post('email');
            $address = $this->input->post('address');
            $hospital_name = $this->input->post('hospital_name');
            $notes = $this->input->post('notes');
            
            $this->form_validation->set_rules('name','Name','trim|required|min_length[5]|max_length[100]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $feedback['error'] = validation_errors();
                echo json_encode($feedback);
            } else {
                $data=array(
                    'name'=> $name,
                    'contact'=> $contact,
                    'email'=> $email,
                    'address'=> $address,
                    'hospital_name'=> $hospital_name,
                    'notes'=> $notes
                );

                $success = $this->help_model->insertAmbulance($data);

                if($success) {
                    $feedback = array(
                        'message'=> "Done!"
                    );
                    echo json_encode($feedback);
                }
            }
        }
        else{
            redirect(base_url() , 'refresh');
        } 
    }
    public function Fire_Service()
    {
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
            if (in_array(83, $permissions)) {
        $data['fire_service'] = $this->help_model->GetFireService();
        $data['permissions1'] = $this->permissionsbyemrole();
        $this->load->view('backend/fire_service', $data);
    } else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
    }
    else{
        redirect(base_url() , 'refresh');
    } 
}
    public function add_fire_service()
    {
        if($this->session->userdata('user_login_access') != False) {

            $name = $this->input->post('name');
            $contact = $this->input->post('contact');
            $email = $this->input->post('email');
            $address = $this->input->post('address');
            
            $this->form_validation->set_rules('name','Name','trim|required|min_length[5]|max_length[100]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $feedback['error'] = validation_errors();
                echo json_encode($feedback);
            } else {
                $data=array(
                    'name'=> $name,
                    'contact'=> $contact,
                    'email'=> $email,
                    'address'=> $address
                );

                $success = $this->help_model->insertFireService($data);

                if($success) {
                    $feedback = array(
                        'message'=> "Done!"
                    );
                    echo json_encode($feedback);
                }
            }
        }
        else{
            redirect(base_url() , 'refresh');
        } 
    }
    public function Police()
    {
        if($this->session->userdata('user_login_access') != False) {
            $per = $this->permissionsbyemrole();
            $permissions = explode(',', $per);
    if (in_array(85, $permissions)) {
        $data['police'] = $this->help_model->GetPolice();
        $data['permissions1'] = $this->permissionsbyemrole();
        $this->load->view('backend/police', $data);
    } else {
        redirect(base_url().'Sales/auth_error', 'refresh');
    }
    }
    else{
        redirect(base_url() , 'refresh');
    } 
}

    public function add_police()
    {
        if($this->session->userdata('user_login_access') != False) {

            $name = $this->input->post('name');
            $contact = $this->input->post('contact');
            $email = $this->input->post('email');
            $address = $this->input->post('address');
            
            $this->form_validation->set_rules('name','Name','trim|required|min_length[5]|max_length[100]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $feedback['error'] = validation_errors();
                echo json_encode($feedback);
            } else {
                $data=array(
                    'name'=> $name,
                    'contact'=> $contact,
                    'email'=> $email,
                    'address'=> $address
                );

                $success = $this->help_model->insertPolice($data);

                if($success) {
                    $feedback = array(
                        'message'=> "Done!"
                    );
                    echo json_encode($feedback);
                }
            }
        }
        else{
            redirect(base_url() , 'refresh');
        } 
    }
}