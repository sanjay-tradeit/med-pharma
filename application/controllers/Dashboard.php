<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('customer_model');
        $this->load->model('invoice_model');
        $this->load->model('medicine_model');
        $this->load->model('supplier_model');
        $this->load->model('user_model');
  
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
    public function Dashboard(){
        if($this->session->userdata('user_login_access') != False) {
        $today = date("Y-m-d");
        $todaystr = date("Y-m-d");
        $onemonth = strtotime('+1 month', strtotime($todaystr));
       
        $month = date("Y-m-d",$onemonth);    
       
        $data['expiresoonmedicine'] = $this->medicine_model->GetStockExpiresoonproduct($today,$month);  
        //print_r($data['expiresoonmedicine']);          
        $data['topselling'] = $this->invoice_model->TopSellingProduct();
        $data['sortstock'] = $this->medicine_model->Getshortproduct();    
        $this->load->view('backend/dashboard',$data);
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }
}