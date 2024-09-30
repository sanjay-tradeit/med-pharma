<?php



	class Customer_model extends CI_Model{
        function __consturct(){
	    parent::__construct();
}

    public function Add_customer_info($data){

		$this->db->insert('customer',$data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;

	}
    public function Create_Customer_balance($data){

		$this->db->insert('customer_ledger',$data);

	}

    public function getAllCustomer(){
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->order_by("c_name", "asc");
        $query = $this->db->get();
        //$result = $query->row();
        $result = $query->result();
       // echo $this->db->last_query();
        return  $result;

        // $sql = "SELECT * FROM `customer` ORDER BY 'id' DESC";
        // $query = $this->db->query($sql);
        // $result = $query->result();
        // echo $this->db->last_query();
        // return $result;

    } 

      //save and print receipt
      public function getAllCustomerrecipt($customer){

        $sql = "SELECT * FROM `customer` WHERE `c_id`='$customer'";

        $query = $this->db->query($sql);

        $result = $query->result();

        return $result;

    } 

    public function getAllRCustomer() {
        $sql = "SELECT * FROM `customer` WHERE `c_type`='Regular' ORDER BY `c_name` ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


    public function getAllCustomerinvoice($customer){

        $sql = "SELECT * FROM `customer` WHERE `c_name`='$customer'";

        $query = $this->db->query($sql);

        $result = $query->result();

        return $result;

    } 
    
    //walk in data
    public function getAllWalkCustomer(){

        $sql = "SELECT * FROM `customer` WHERE `c_type`='Walkin' ORDER BY `c_name` ASC";

        $query = $this->db->query($sql);

        $result = $query->result();

        return $result;

    } 





    public function GetCustomerBalance($customer){
        $sql = "SELECT * FROM `customer_ledger` WHERE `customer_id`='$customer'";
        $query = $this->db->query($sql);
        $result = $query->row();
       // echo $this->db->last_query();
        return $result;
    } 

    public function getCustomerById($id){

        $sql = "SELECT * FROM `customer` WHERE `customer`.`id`='$id'";

        $query = $this->db->query($sql);

        $result = $query->row();

        return $result;
    }
    public function getAllWCustomer(){

        $sql = "SELECT * FROM `customer` WHERE `c_type`='Wholesale' ORDER BY `c_name` ASC";

        $query = $this->db->query($sql);

        $result = $query->result();

        return $result;

    }  

    public function UpdateCustomerById($id){
        $this->db->where('id' , $id);
        $this->db->update('customer');
    }  

    public function GetCustomerIdValue($id){
        $this->db->where('c_id' , $id);
        $result = $this->db->get('customer');
        return $result->row();
    }   

    //Get All Email form Cutomer table
    public function getEmailId($email){
        $this->db->where('c_email',$email);
        return $this->db->get('customer')->num_rows();;
    }
    //Get Regular Customer Value By Id
    public function GetRegularValueById($id){
        $sql = "SELECT * FROM `customer` WHERE `customer`.`id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    //Get Regular Customer Value By Id
    public function phone_book(){
        $sql = "SELECT * FROM `customer`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    //Get Customer Value By Id
    public function GetCustomerValueForPOS($id){
        $sql = "SELECT * FROM `customer` WHERE `customer`.`c_id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    //Get Customer Value By Id
    public function GetCustomerValueById($id){

        $sql = "SELECT * FROM `customer` WHERE `customer`.`c_id`='$id'";

        $query = $this->db->query($sql);

        $result = $query->row();

        return $result;

    }
    //Get Regular Customer Value By Id
    public function GetCustomerMonthlyIncome($id,$date){
        $sql = "SELECT * FROM `sales` WHERE `sales`.`cus_id`='$id' AND `sales`.`monthyear`='$date'";
        $query = $this->db->query($sql);
        $result = $query->result();
        // echo $this->db->last_query();
        return $result;
    }
    //Get Regular Customer Value By Id
    public function getAllCustomerBalance(){
    $sql = "SELECT `customer_ledger`.*,
      `customer`.`c_id`,`c_name`
      FROM `customer_ledger`
      LEFT JOIN `customer` ON `customer_ledger`.`customer_id`=`customer`.`c_id`
      ORDER BY `customer_ledger`.`id` DESC";      
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    //Get Regular Customer Value By Id
    public function GetCustomerBALANCEValue($id){
    $sql = "SELECT `customer_ledger`.*,
      `customer`.`c_id`,`c_name`
      FROM `customer_ledger`
      LEFT JOIN `customer` ON `customer_ledger`.`customer_id`=`customer`.`c_id`
      WHERE `customer_ledger`.`customer_id`='$id'";
      $query = $this->db->query($sql);
      $result = $query->row();
      return $result;
    }
    public function Update_customer_info($id,$udata){
        $this->db->where('c_id',$id);
        $this->db->update('customer',$udata);
    }
    public function Update_Balance($cid,$data){
        $this->db->where('customer_id',$cid);
        $this->db->update('customer_ledger',$data);
    }
    public function Does_email_exists($email, $phone) {
        $this->db->select('*');
        $this->db->from('customer'); 
        $this->db->where('c_email', $email);
        $this->db->or_where('cus_contact', $phone);
        $query = $this->db->get();
        $result = $query->result();
        if($result)
        {
           return "1";
        }else{
            return "0";
        }
    }
    public function Does_customer_exists($name, $phone) {

        $this->db->select('c_id');
        $this->db->from('customer'); 
        $this->db->where('c_name', $name);
        $this->db->where('cus_contact', $phone);
        $query = $this->db->get();
        $result = $query->result();
        // echo $this->db->last_query();
        // print_r($result);
        // die;
        if(!empty($result))
        {
           return $result[0]->c_id;
        }else{
            return 2;
        }
    }

    public function get_regular_cus()
    {
        $this->db->select('c_id, c_name,cus_contact');
        $this->db->from('customer');
        $this->db->where('c_type', "Regular");
       $query =  $this->db->get();
       $result = $query->result();
       return $result;
    }

    public function get_wholesale_cus()
    {
        $this->db->select('c_id, c_name,cus_contact');
        $this->db->from('customer');
        $this->db->where('c_type', "Wholesale");
       $query =  $this->db->get();
       $result = $query->result();
       return $result;  
    }

    public function get_cus_data($id)
    {
        $this->db->select('c_id, c_name,cus_contact,regular_discount');
        $this->db->from('customer');
        $this->db->where('c_id', $id);
       $query =  $this->db->get();
       $result = $query->result();
       return $result; 
    }

    public function get_image_name($id)
    {
        $this->db->select('c_img');
        $this->db->from('customer');
        $this->db->where('c_id', $id);
       $query =  $this->db->get();
       $result = $query->result();
       return $result;    
    }

    public function getsupplier_id($s_name)
    {
        $this->db->select('s_id');
        $this->db->from('supplier');
        $this->db->where('s_name', $s_name);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function add_purchase($data)
    {
        $this->db->insert('purchase', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function get_medicine_id($product_name)
    {
        $this->db->select('hsn, product_id');
        $this->db->from('medicine');
        $this->db->where('product_name', $product_name);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_igst($hsn_num)
    {
        $this->db->select('igst');
        $this->db->from('gst');
        $this->db->where('hsn_num', $hsn_num);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function add_purchase_history($data)
    {
        $this->db->insert('purchase_history', $data);
        $insert_id = $this->db->insert_id();
        $this->db->last_query();
        //echo $this->db->last_query();
        return $insert_id;

    }

    public function check_existing_medicine($product_id, $supplier_id, $batch_num)
    {
      $this->db->select('*');
      $this->db->from('medicine_mata');
      $this->db->where('product_id', $product_id);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $batch_num);
      $query = $this->db->get();
      $result = $query->result();
      //echo $this->db->last_query();
      return $result;
    }

    public function add_medicine_meta($medicine_meta)
    {
        $this->db->insert('medicine_mata', $medicine_meta);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function update_stock($product_id, $supplier_id, $batch_num, $stock)
    {
        $this->db->where('product_id', $product_id);
        $this->db->where('supplier_id', $supplier_id);
        $this->db->where('Batch_Number', $batch_num);
        $this->db->update('medicine_mata', $stock);
       // echo $this->db->last_query();
        return true;
    }

    public function get_medicine_stock($product_id)
    {
        $this->db->select('instock');
        $this->db->from('medicine');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function update_medicine_stock($product_id, $new_stock)
    {
        $this->db->where('product_id', $product_id);
        $this->db->update('medicine', $new_stock);
        return true;
    }

    public function check_invoice($product_id, $supplier_id, $batch_num, $expire_date)
    {
      $this->db->select('*');
      $this->db->from('purchase_history');
      $this->db->where('pur_id', $product_id);
      $this->db->where('supp_id', $supplier_id);
      $this->db->where('Batch_Number', $batch_num);
      $this->db->where('expire_date', $expire_date);
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }

    public function check_med($product_id)
    {
        $this->db->select('product_id');
        $this->db->from('medicine');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result; 
    }

    public function get_manu_id($m_name)
    {
        $this->db->select('manufac_id');
        $this->db->from('manufacturer');
        $this->db->where('m_name', $m_name);
        $query = $this->db->get();
        $result = $query->result();
        return $result; 
    }

    public function re_check_invoice($invoice_no)
    {
        $this->db->select('*');
        $this->db->from('purchase');
        $this->db->where('invoice_no', $invoice_no);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function chech_pid_in_his($pur_id)
    {
        $this->db->select('*');
        $this->db->from('purchase_history');
        $this->db->where('pur_id', $pur_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;  
    }
    public function get_hsn($product_id)
    {
        $this->db->select('*');
        $this->db->from('medicine');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;  
    }

    public function check_med_store_meta($product_id, $supplier_id, $batch_num, $store_id)
    {
        $this->db->select('*');
        $this->db->from('store_medicine_mata');
        $this->db->where('product_id', $product_id);
        $this->db->where('supplier_id', $supplier_id);
        $this->db->where('Batch_Number', $batch_num);
        $this->db->where('store_id', $store_id);
        $this->db->where('status', 1);
        $query = $this->db->get();
        $result = $query->result();
        return $result;   
    }

    public function insert_medicine_meta_store($data)
    {
        $this->db->insert('store_medicine_mata', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function check_pre_record($pid, $batch_no, $exp_date, $supplier_id, $store_id)
    {
      $this->db->select('*');
      $this->db->from('store_medicine_mata');
      $this->db->where('product_id', $pid);
      $this->db->where('Batch_Number', $batch_no);
      $this->db->where('expire_date', $exp_date);
      $this->db->where('supplier_id ', $supplier_id);
      $this->db->where('store_id ', $store_id);
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }

    
    public function update_store_medi_meta($pid, $batch_no, $exp_date, $supplier_id, $store_id, $data)
    {
      $this->db->where('product_id', $pid);
      $this->db->where('Batch_Number', $batch_no);
      $this->db->where('expire_date', $exp_date);
      $this->db->where('supplier_id ', $supplier_id);
      $this->db->where('store_id ', $store_id);
      $this->db->update('store_medicine_mata', $data);
      return true;
    }

    // public function add_purchase($data)
    // {
    //     $this->db->insert('purchase', $data);
    //     $insert_id = $this->db->insert_id();
    //     return $insert_id;
    // }
      
    public function insert_in_grn($grn_data)
    {
        $this->db->insert('grn', $grn_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function insert_grn_meta($data)
    {
        $this->db->insert('meta_grn', $data);
        $insert_id = $this->db->insert_id();
        echo $this->db->last_query();
        return $insert_id;
    }

    public function check_grn($grn_no)
    {
        $this->db->select('*');
        $this->db->from('grn');
        $this->db->where('grn_no', $grn_no);
        $query = $this->db->get();
        $result = $query ->result();
        return $result;
    }
    
    public function GetcustomerwithdueBYid($cid)
    {
        $this->db->select('*');
        $this->db->from('sales');
        $this->db->where('cus_id', $cid);
        $this->db->where('due_amount>', 0);
        $query = $this->db->get();
        $result = $query ->result();
        return $result;
    }
    
    public function update_dueinsales($id,$data)
    {
        $this->db->where('id' , $id);
        $this->db->update('sales',$data);
       // echo $this->db->last_query();
        
    }
    


}

?>