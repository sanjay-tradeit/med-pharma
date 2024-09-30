<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends CI_Controller {

	    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->model('supplier_model');
        $this->load->model('medicine_model');
        $this->load->model('Store_model');

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
    public function add_store()
    {
      if($this->session->userdata('user_login_access') != False) {
        $per = $this->permissionsbyemrole();
                    $permissions = explode(',', $per);
                if (in_array(23, $permissions)) { 
        $this->load->view('backend/add_store');
      }
      else {
        redirect(base_url().'Sales/auth_error', 'refresh');
      }
      }
      else{
        redirect(base_url() , 'refresh');
      } 
    }

    public function add_new_store()
    {
       $store_id =  $this->input->post('store_id');
       $store_name =  $this->input->post('store_name');
       $store_alias =  $this->input->post('store_alias');
       $store_type =  $this->input->post('store_type');
        $transactionTypes = $this->input->post('Transaction_Type');
        $transactionTypeString = $transactionTypes ? implode(",", $transactionTypes) : '';
       $medical_type =  $this->input->post('medical_type');
       $payment_type =  $this->input->post('payment_type');
       $Discount_Facility =  $this->input->post('Discount_Facility') ? $this->input->post('Discount_Facility'):'';
       $discount_facility_value =  $this->input->post('discount_facility_value');
       $Doctor_Discount =  $this->input->post('doc_dis') ? $this->input->post('doc_dis'):'';
       $Doctor_Discount_val =  $this->input->post('Doctor_Discount_val');
       $ip_tax =  $this->input->post('ip_tax');
       $All_Wards_Flat =  $this->input->post('All_Wards_Flat');
       $ot_tax_applicable =  $this->input->post('ot_tax_applicable');
       $op_tax_applicable =  $this->input->post('op_tax_applicable');
       $return_applicable =  $this->input->post('return_applicable');
       $return_applicable_days =  $this->input->post('return_applicable_days');
       $contract_days =  $this->input->post('contract_days');
       $View_Ledgers =  $this->input->post('View_Ledgers');
       $GST_Not_Applicable =  $this->input->post('GST_Not_Applicable') ? $this->input->post('GST_Not_Applicable'):'';
       $Req_for_Discharge =  $this->input->post('Req_for_Discharge')? $this->input->post('Req_for_Discharge'):'';
       $Item_Code_Editable =  $this->input->post('Item_Code_Editable')? $this->input->post('Item_Code_Editable'):'';
       $Remarks =  $this->input->post('Remarks') ? $this->input->post('Remarks'):'';
       $dm_discount =  $this->input->post('dm_discount') ? $this->input->post('dm_discount'):'';
       $Rounding_Value =  $this->input->post('Rounding_Value') ? $this->input->post('Rounding_Value'):'';
       $round =  $this->input->post('round') ? $this->input->post('round'):'';
       $less_on_returns =  $this->input->post('less_on_returns') ? $this->input->post('less_on_returns'):'';
       $less_on_returns_option =  $this->input->post('less_on_returns_option') ? $this->input->post('less_on_returns_option'):'';
       $less_on_returns_val =  $this->input->post('less_on_returns_val') ? $this->input->post('less_on_returns_val'):'';

        $direct_approveTypes = $this->input->post('direct_approve');
        $direct_approveTypeString = $direct_approveTypes ? implode(",", $direct_approveTypes) : '';
  
       $Lock_IndentsTypes = $this->input->post('Lock_Indents');
       $Lock_IndentsTypesString = $Lock_IndentsTypes ? implode(",", $Lock_IndentsTypes) : '';
      //  print_r($Lock_IndentsTypesString);
        $look_indent_val =  $this->input->post('look_indent_val');
     
       $By_DefaultTypes = $this->input->post('By_Default');
       $By_DefaultTypesTypeString = $By_DefaultTypes ? implode(",", $By_DefaultTypes) : '';
       $Nurse_Indents =  $this->input->post('Nurse_Indents') ? $this->input->post('Nurse_Indents'):'';
       $Nurse_Indents_val =  $this->input->post('Nurse_Indents_val');
       $Purchase_Order =  $this->input->post('Purchase_Order') ? $this->input->post('Purchase_Order'):'';
       $Purchase_Order_val =  $this->input->post('Purchase_Order_val');
       $Dept_Indents =  $this->input->post('Dept_Indents') ? $this->input->post('Dept_Indents'):'';
       $Dept_Indents_val =  $this->input->post('Dept_Indents_val');
       $Casuality = $this->input->post('Casuality') ? $this->input->post('Casuality'):'';
       $Item_Search =  $this->input->post('Item_Search');
       $MRQ_Indents =   $this->input->post('MRQ_Indents');
     
       $Mandatory_FieldsTypes = $this->input->post('Mandatory_Fields');
       $Mandatory_FieldsTypesString = $Mandatory_FieldsTypes ? implode(",", $Mandatory_FieldsTypes) : '';
       $Bar_Code =   $this->input->post('Bar_Code') ? $this->input->post('Bar_Code'):'';
       $Bar_Code_val =   $this->input->post('Bar_Code_val');
       $Barcode_Labels =   $this->input->post('Barcode_Labels') ? $this->input->post('Barcode_Labels'):'';
       $Barcode_Labels_val =   $this->input->post('Barcode_Labels_val');
       $Wireless_Device =   $this->input->post('Wireless_Device') ? $this->input->post('Wireless_Device'):'';
       $Wireless_Device_val =   $this->input->post('Wireless_Device_val');
       


           $data = array(
             "store_id" => $store_id,
             "store_name" => $store_name,
             "store_alias" => $store_alias,
             "store_point_type" => $store_type,
             "transaction_type" => $transactionTypeString,
             "medical_type" => $medical_type,
            "payment_type" => $payment_type,
            "discount_facility_discount" => $Discount_Facility,
            "discount_facility_dis_val" => $discount_facility_value,
            "discount_facility_doc_dis" => $Doctor_Discount,
            "discount_facility_doc_dis_val" => $Doctor_Discount_val,
            "ip_tax_applicable" => $ip_tax,
            "ip_tax_all_ward_flat" => $All_Wards_Flat,
            "ot_tax_applicable" => $ot_tax_applicable,
            "op_tax_applicable" => $op_tax_applicable,
            "returns_applicable" => $return_applicable,
            "returns_applicable_days" => $return_applicable_days,
            "returns_applicable_contract_days" => $contract_days,
            "returns_applicable_view_ledger" => $View_Ledgers,
            "gst_not_applicable" => $GST_Not_Applicable,
            "req_for_discharge" => $Req_for_Discharge,
            "item_code_editable" => $Item_Code_Editable,
            "is_remark"   => $Remarks,
            "	dm_discount" => $dm_discount,
            "rounding_value" => $Rounding_Value,
            "round" => $round,
            "less_returns" => $less_on_returns,
            "less_returns_if_yes" => $less_on_returns_option,
            "less_returns_val" => $less_on_returns_val,
             "direct_approve" => $direct_approveTypeString,
            "lock_indents" => $Lock_IndentsTypesString,
            "look_indents_val" => $look_indent_val,
            "by_default_active" => $By_DefaultTypesTypeString,
            "nurse_indent" => $Nurse_Indents,
            "indent_setting_nurse_val" => $Nurse_Indents_val,
            "purchase_order" => $Purchase_Order,
            "indent_setting_purchase_val" => $Purchase_Order_val,
            "dept_order" => $Dept_Indents,
            "indent_setting_dept_val" => $Dept_Indents_val,
            "casulality" => $Casuality,
            "item_search" => $Item_Search,
            "mrq_indent" => $MRQ_Indents,
            "mandatory_field" => $Mandatory_FieldsTypesString,
            "bar_code" => $Bar_Code,
            "bar_code_val" => $Bar_Code_val,
            "barcode_label" => $Barcode_Labels,
            "barcode_label_val" => $Barcode_Labels_val,
            "wireless_device" => $Wireless_Device,
            "wireless_device_val" => $Wireless_Device_val,
       );
       
       $insert_store = $this->Store_model->insert_store($data); 
      if($insert_store)
      {
        $success = $this->session->set_flashdata('success', 'Store Submitted Succesfully');
      
      }
  
    }

    public function manage_stores()
    {
      if($this->session->userdata('user_login_access') != False) {
        $per = $this->permissionsbyemrole();
        $permissions = explode(',', $per);
    if (in_array(22, $permissions)) { 
      $data['get_stores'] = $this->Store_model->get_storess(); 
      $data['permissions1'] = $this->permissionsbyemrole();
      $this->load->view('backend/manage_store', $data);
    }
    else {
      redirect(base_url().'Sales/auth_error', 'refresh');
    }
    }
    else{
      redirect(base_url() , 'refresh');
    } 
  }


    public function edit_store()
    {
      if($this->session->userdata('user_login_access') != False) {
      $id = $this->uri->segment(3);
      $data['stores_info'] = $this->Store_model->get_stores_info($id); 
      $this->load->view('backend/edit_store', $data);
    }
    else{
      redirect(base_url() , 'refresh');
    } 
  }

    public function update_store()
    {
      $id =  $this->input->post('id');
      $store_id =  $this->input->post('store_id');
      $store_name =  $this->input->post('store_name');
      $store_alias =  $this->input->post('store_alias');
      $store_type =  $this->input->post('store_type');
       $transactionTypes = $this->input->post('Transaction_Type');
       $transactionTypeString = $transactionTypes ? implode(",", $transactionTypes) : '';
      $medical_type =  $this->input->post('medical_type');
      $payment_type =  $this->input->post('payment_type');
      $Discount_Facility =  $this->input->post('Discount_Facility') ? $this->input->post('Discount_Facility'):'';
      $discount_facility_value =  $this->input->post('discount_facility_value');
      $Doctor_Discount =  $this->input->post('doc_dis') ? $this->input->post('doc_dis'):'';
      $Doctor_Discount_val =  $this->input->post('Doctor_Discount_val');
      $ip_tax =  $this->input->post('ip_tax');
      $All_Wards_Flat =  $this->input->post('All_Wards_Flat');
      $ot_tax_applicable =  $this->input->post('ot_tax_applicable');
      $op_tax_applicable =  $this->input->post('op_tax_applicable');
      $return_applicable =  $this->input->post('return_applicable');
      $return_applicable_days =  $this->input->post('return_applicable_days');
      $contract_days =  $this->input->post('contract_days');
      $View_Ledgers =  $this->input->post('View_Ledgers');
      $GST_Not_Applicable =  $this->input->post('GST_Not_Applicable') ? $this->input->post('GST_Not_Applicable'):'';
      $Req_for_Discharge =  $this->input->post('Req_for_Discharge')? $this->input->post('Req_for_Discharge'):'';
      $Item_Code_Editable =  $this->input->post('Item_Code_Editable')? $this->input->post('Item_Code_Editable'):'';
      $Remarks =  $this->input->post('Remarks') ? $this->input->post('Remarks'):'';
      $dm_discount =  $this->input->post('dm_discount') ? $this->input->post('dm_discount'):'';
      $Rounding_Value =  $this->input->post('Rounding_Value') ? $this->input->post('Rounding_Value'):'';
      $round =  $this->input->post('round') ? $this->input->post('round'):'';
      $less_on_returns =  $this->input->post('less_on_returns') ? $this->input->post('less_on_returns'):'';
      $less_on_returns_option =  $this->input->post('less_on_returns_option') ? $this->input->post('less_on_returns_option'):'';
      $less_on_returns_val =  $this->input->post('less_on_returns_val') ? $this->input->post('less_on_returns_val'):'';

       $direct_approveTypes = $this->input->post('direct_approve');
       $direct_approveTypeString = $direct_approveTypes ? implode(",", $direct_approveTypes) : '';
 
      $Lock_IndentsTypes = $this->input->post('Lock_Indents');
      $Lock_IndentsTypesString = $Lock_IndentsTypes ? implode(",", $Lock_IndentsTypes) : '';
     // print_r($Lock_IndentsTypesString);
       $look_indent_val =  $this->input->post('look_indent_val');
    
      $By_DefaultTypes = $this->input->post('By_Default');
      $By_DefaultTypesTypeString = $By_DefaultTypes ? implode(",", $By_DefaultTypes) : '';
      $Nurse_Indents =  $this->input->post('Nurse_Indents') ? $this->input->post('Nurse_Indents'):'';
      $Nurse_Indents_val =  $this->input->post('Nurse_Indents_val');
      $Purchase_Order =  $this->input->post('Purchase_Order') ? $this->input->post('Purchase_Order'):'';
      $Purchase_Order_val =  $this->input->post('Purchase_Order_val');
      $Dept_Indents =  $this->input->post('Dept_Indents') ? $this->input->post('Dept_Indents'):'';
      $Dept_Indents_val =  $this->input->post('Dept_Indents_val');
      $Casuality = $this->input->post('Casuality') ? $this->input->post('Casuality'):'';
      $Item_Search =  $this->input->post('Item_Search');
      $MRQ_Indents =   $this->input->post('MRQ_Indents');
    
      $Mandatory_FieldsTypes = $this->input->post('Mandatory_Fields');
      $Mandatory_FieldsTypesString = $Mandatory_FieldsTypes ? implode(",", $Mandatory_FieldsTypes) : '';
      $Bar_Code =   $this->input->post('Bar_Code') ? $this->input->post('Bar_Code'):'';
      $Bar_Code_val =   $this->input->post('Bar_Code_val');
      $Barcode_Labels =   $this->input->post('Barcode_Labels') ? $this->input->post('Barcode_Labels'):'';
      $Barcode_Labels_val =   $this->input->post('Barcode_Labels_val');
      $Wireless_Device =   $this->input->post('Wireless_Device') ? $this->input->post('Wireless_Device'):'';
      $Wireless_Device_val =   $this->input->post('Wireless_Device_val');

      $data = array(
        "store_id" => $store_id,
        "store_name" => $store_name,
        "store_alias" => $store_alias,
        "store_point_type" => $store_type,
        "transaction_type" => $transactionTypeString,
        "medical_type" => $medical_type,
       "payment_type" => $payment_type,
       "discount_facility_discount" => $Discount_Facility,
       "discount_facility_dis_val" => $discount_facility_value,
       "discount_facility_doc_dis" => $Doctor_Discount,
       "discount_facility_doc_dis_val" => $Doctor_Discount_val,
       "ip_tax_applicable" => $ip_tax,
       "ip_tax_all_ward_flat" => $All_Wards_Flat,
       "ot_tax_applicable" => $ot_tax_applicable,
       "op_tax_applicable" => $op_tax_applicable,
       "returns_applicable" => $return_applicable,
       "returns_applicable_days" => $return_applicable_days,
       "returns_applicable_contract_days" => $contract_days,
       "returns_applicable_view_ledger" => $View_Ledgers,
       "gst_not_applicable" => $GST_Not_Applicable,
       "req_for_discharge" => $Req_for_Discharge,
       "item_code_editable" => $Item_Code_Editable,
       "is_remark"   => $Remarks,
       "	dm_discount" => $dm_discount,
       "rounding_value" => $Rounding_Value,
       "round" => $round,
       "less_returns" => $less_on_returns,
       "less_returns_if_yes" => $less_on_returns_option,
       "less_returns_val" => $less_on_returns_val,
        "direct_approve" => $direct_approveTypeString,
       "lock_indents" => $Lock_IndentsTypesString,
       "look_indents_val" => $look_indent_val,
       "by_default_active" => $By_DefaultTypesTypeString,
       "nurse_indent" => $Nurse_Indents,
       "indent_setting_nurse_val" => $Nurse_Indents_val,
       "purchase_order" => $Purchase_Order,
       "indent_setting_purchase_val" => $Purchase_Order_val,
       "dept_order" => $Dept_Indents,
       "indent_setting_dept_val" => $Dept_Indents_val,
       "casulality" => $Casuality,
       "item_search" => $Item_Search,
       "mrq_indent" => $MRQ_Indents,
       "mandatory_field" => $Mandatory_FieldsTypesString,
       "bar_code" => $Bar_Code,
       "bar_code_val" => $Bar_Code_val,
       "barcode_label" => $Barcode_Labels,
       "barcode_label_val" => $Barcode_Labels_val,
       "wireless_device" => $Wireless_Device,
       "wireless_device_val" => $Wireless_Device_val,
  );
      $update_store = $this->Store_model->update_store($id, $data); 
    }

    public function delete_store()
    {
      $id = $this->uri->segment(3);
      $delete_store = $this->Store_model->delete_store($id); 
       redirect('manage_store');
      
    }

   


}
