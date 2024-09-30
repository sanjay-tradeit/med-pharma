<?php
	class Invoice_model extends CI_Model{
	function __consturct(){
	parent::__construct();
	}

	public function pos(){
		$this->db->get();
	}
    public function Add_Supplier_info($data){

		$this->db->insert('supplier',$data);

	}
    public function Save_Payment($data){

		$this->db->insert('sales',$data);

	}
     public function insert_stock_request($data){
      $this->db->insert('stock_request', $data);
      $insert_id = $this->db->insert_id();
      return $insert_id;
     }
    public function Save_Sales_History($data){
		$this->db->insert('sales_details',$data);
    $insert_id = $this->db->insert_id();
    return $insert_id;
	}
    public function Save_Sales($data){
		$this->db->insert('sales',$data);
    //echo $this->db->last_query();die;
    $insert_id = $this->db->insert_id();
    return $insert_id;
	}
	// Get All Customer 
	public function getAllCustomer(){
        $sql = "SELECT * FROM `customer` ORDER BY 'id' DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
	}
	// Get specific Customer 
	public function GetCusTomerForCheckType($cid){
        $sql = "SELECT * FROM `customer` WHERE `customer`.`c_id`='$cid'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
	} 
	public function getAllMedicineByKey($param){
        $sql    = "SELECT * FROM `medicine` WHERE `product_name` LIKE '$param%'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
	} 
	public function GetCInfo($cid){
        $sql    = "SELECT `c_name`,`c_id` FROM `customer` WHERE `c_name` LIKE '$cid%' OR `cus_contact` LIKE '$cid%'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
	}  
  
/*	public function SpecificCustomer($cid){
        $sql    = "SELECT `c_name`,`c_id` FROM `customer` WHERE `barcode` LIKE '$cid%' OR `cus_contact` LIKE '$cid%'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
	}*/ 
  function SpecificCustomer($q){
    $this->db->select('*');
    $this->db->limit(10);
    $this->db->like('barcode', $q);
    $this->db->or_like('cus_contact', $q);
    $this->db->or_like('c_name', $q);
    $query = $this->db->get('customer');
    if($query->num_rows() > 0){
      foreach ($query->result_array() as $row){
        $new_row['label']=htmlentities(stripslashes($row['c_name']));
        $new_row['value']=htmlentities(stripslashes($row['c_id']));
        $new_row['ctype']=htmlentities(stripslashes($row['c_type']));
        $row_set[] = $new_row; //build an array
      }
      echo json_encode($row_set); //format the array into json data
    }
  }       
	public function GetSimilarGenericdata($pn){
        $sql    = "SELECT `product_name`,`product_id`,`generic_name` FROM `medicine` WHERE `generic_name` LIKE '$pn%'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
	}

  function GetMIDbatch($midbatch){
   $store_id = $this->session->userdata('store_id');
   if($this->session->userdata('em_type') =='admin'){
    $sql = "SELECT * FROM `medicine` LEFT JOIN `store_medicine_mata` ON `medicine`.`product_id` = `store_medicine_mata`.`product_id` WHERE `medicine`.`instock` > 0 AND `product_name` LIKE '$midbatch%'   OR  `Batch_Number` LIKE '$midbatch%' GROUP BY `medicine`.`product_name`";
   }
   else {
    $sql = "SELECT * FROM `medicine` LEFT JOIN `store_medicine_mata` ON `medicine`.`product_id` = `store_medicine_mata`.`product_id` WHERE (`medicine`.`product_name` LIKE '$midbatch%' OR `Batch_Number` LIKE '$midbatch%') AND `store_medicine_mata`.`store_id` = '$store_id' AND `medicine`.`instock` > 0  GROUP BY `store_medicine_mata`.`product_id`";


   }


   $query  = $this->db->query($sql);
    if($query->num_rows() > 0){
    date_default_timezone_set("Asia/Kolkata");
    $today = strtotime(date('Y/m/d'));
      foreach ($query->result_array() as $row){
        $new_row['label']=htmlentities(stripslashes($row['product_name'].'('.$row['strength'].')'));
        $new_row['value']=htmlentities(stripslashes($row['product_id']));
        $new_row['genval']=htmlentities(stripslashes($row['generic_name']));
        $new_row['mrp']=htmlentities(stripslashes($row['mrp']));
        $new_row['stock']=htmlentities(stripslashes($row['instock']));
          $date = str_replace('/', '-', $row['expire_date']);
          $expire = strtotime($date);
          $a = date('Y/m/d',$expire);
          $b = strtotime($a);
          if($today >= $b){
        $new_row['expiry']=htmlentities(stripslashes($row['expire_date']));
          } else {
         $new_row['expiry']=htmlentities(stripslashes(0));     
          }
        $row_set[] = $new_row; 
      }
      echo json_encode($row_set);
    }
  }        
        /*Specific medicine for pos*/
	public function SpecificMedicine($mid){
        $sql    = "SELECT * FROM `medicine` WHERE `product_id`='$mid'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
	}
  public function SpecificMedicine12($mid){
    $this->db->select('*');
    $this->db->from('medicine');
    $this->db->join('medicine_mata', 'medicine_mata.product_id = medicine.product_id', 'left'); 
    $this->db->where('medicine.product_id', $mid);
    $query = $this->db->get();
    $result = $query->result();
   // echo $this->db->last_query();
    return $result;
}

public function SpecificMedicinemrp($pid,$batch,$supplier_id) {
  $this->db->select('purchase_history.mrp'); 
  $this->db->from('purchase_history');  
  $this->db->where('purchase_history.mid', $pid);
  $this->db->where('purchase_history.Batch_Number', $batch);
  $this->db->where('purchase_history.supp_id', $supplier_id);  
  $query = $this->db->get();  
  $result = $query->result();
  //echo $this->db->last_query();
  return $result;
}

public function SpecificMedicine122($mid){
  $this->db->select('*');
  $this->db->from('medicine');
  $this->db->join('medicine_mata', 'medicine_mata.product_id = medicine.product_id', 'left'); 
  $this->db->where('medicine.product_id', $mid);
  $query = $this->db->get();
  $result = $query->result();
 // echo $this->db->last_query();
  return $result;
}
        /*Sales medicine for pos*/
	public function Get_Invoice_Value($sales){
      $sql = "SELECT `sales`.*,
      `customer`.*
      FROM `sales`
      LEFT JOIN `customer` ON `sales`.`cus_id`=`customer`.`c_id`
      WHERE `sales`.`sale_id`='$sales'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
	}
        /*Sales Invoice Data*/
	public function GetAllInvoiceData(){
    $storeid = $this->session->userdata('store_id');
    $this->db->select('*');
    $this->db->from('sales');
    $this->db->where('sales.store_id', $storeid);
    $this->db->join('customer', 'sales.cus_id = customer.c_id', 'right'); 
    $this->db->order_by('sales.time_stamp', 'desc');
    $query = $this->db->get();
    $result = $query->result();
   //echo $this->db->last_query();die;
    return $result;
}

        /*Sales medicine details for pos*/
	public function Get_Invoice_Value_Details($sales){
    $sql = "SELECT `sales_details`.*,
      `medicine`.*
      FROM `sales_details`
      LEFT JOIN `medicine` ON `sales_details`.`mid`=`medicine`.`product_id`
      WHERE `sales_details`.`sale_id`='$sales'";        
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
	}
	// Get All Product 
	public function getAllProduct(){
        $sql = "SELECT * FROM `medicine` ORDER BY 'id' DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
	}
    public function getAllSupplier(){
        $sql = "SELECT * FROM `supplier` ORDER BY 'id' DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function Update_Customer_Balance($customer,$data){
        $this->db->where('customer_id',$customer);
        $this->db->update('customer_ledger',$data);
        
    }
    /*Top selling Product*/    
    public function TopSellingProduct(){
        // $sql = "select *
        //     from `medicine`
        //     group by `product_id`
        //     order by sum(sale_qty) desc
        //     LIMIT 5";
        // $query = $this->db->query($sql);
        // $result = $query->result();
        // return $result;   
        $today = date("Y-m-d");
        $sql = "SELECT `medicine`.product_name,`medicine`.product_image,`medicine`.strength,`medicine`.instock, `medicine`.generic_name,`medicine_mata`.expire_date ,`sales_details`.mid,COUNT(mid) FROM `sales_details` LEFT JOIN `medicine` ON `sales_details`.`mid`=`medicine`.`product_id` LEFT JOIN `medicine_mata` ON `sales_details`.`mid`=`medicine_mata`.`product_id`  WHERE `sales_details`.sale_date = '$today' GROUP BY mid HAVING COUNT(mid) > 0 ORDER by COUNT(mid) DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;     
    }    

    public function get_supplier_id($m_id, $batch, $stock, $storeID)
    {
      $this->db->select('*');
      $this->db->from('store_medicine_mata');
      $this->db->where('product_id', $m_id);
      $this->db->where('Batch_Number', $batch);
      $this->db->where('store_id', $storeID);
      $query = $this->db->get();
      $result = $query->result();
      //echo $this->db->last_query();
      return $result;
    }

    public function get_supplier($pid, $batchNumber, $exp_date)
    {
      
      $storeid = $this->session->userdata('store_id');
      $this->db->select('*');
      $this->db->from('store_medicine_mata');
      $this->db->where('product_id', $pid);
      $this->db->where('Batch_Number', $batchNumber);
      $this->db->where('expire_date', $exp_date);
      $this->db->where('store_id', $storeid);

      $query = $this->db->get();
      $result = $query->result();
    // echo $this->db->last_query();
      return $result;
    }

    public function insert_stock_history($data)
    {
      $this->db->insert('stock_transfer_history', $data);
      $insert_id = $this->db->insert_id();
      return $insert_id;
    }

    public function get_igst($hsn_num)
    {
      $this->db->select('igst');
      $this->db->from('gst');
      $this->db->where('hsn_num', $hsn_num);
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }

    public function insert_stock_transfer($data)
    {
      $this->db->insert('stock_transfer', $data);
      $insert_id = $this->db->insert_id();
      //$this->db->last_query();
      return $insert_id;
    }

    public function insert_med_meta($data)
    {
      $this->db->insert('store_medicine_mata', $data);
      $insert_id = $this->db->insert_id();
      //echo $this->db->last_query();
      return $insert_id;
    }

    public function check_get_med_stock($pid, $batch_no, $exp_date, $supplier_id)
    {
      $this->db->select('*');
      $this->db->from('medicine_mata');
      $this->db->where('product_id', $pid);
      $this->db->where('Batch_Number', $batch_no);
      $this->db->where('expire_date', $exp_date);
      $this->db->where('supplier_id', $supplier_id);
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }

    public function update_get_med_stock($pid, $batch_no, $exp_date, $supplier_id, $data)
    {
      $this->db->where('product_id', $pid);
      $this->db->where('Batch_Number', $batch_no);
      $this->db->where('expire_date', $exp_date);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->update('medicine_mata', $data);
      return true;
    }

    public function check_main_med_stock($pid)
    {
      $this->db->select('instock');
      $this->db->from('medicine');
      $this->db->where('product_id', $pid);
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }

    public function update_stock_in_medicine($pid, $data)
    {
      $this->db->where('product_id', $pid);
      $this->db->update('medicine', $data);
      return true;
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
      $this->db->where('status ', "1");
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
      $this->db->where('status ', "1");
      $this->db->update('store_medicine_mata', $data);
     // echo $this->db->last_query();
      return true;
    }

    public function check_sess_store_stock($pid, $batch_no, $exp_date, $supplier_id, $store_id)
    {
      $this->db->select('*');
      $this->db->from('store_medicine_mata');
      $this->db->where('product_id', $pid);
      $this->db->where('Batch_Number', $batch_no);
      $this->db->where('expire_date', $exp_date);
      $this->db->where('supplier_id ', $supplier_id);
      $this->db->where('store_id ', $store_id);
      $this->db->where('status ', "1");
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }

    public function update_sess_store_stock($pid, $batch_no, $exp_date, $supplier_id, $store_id, $data)
    {
     

    //  echo  $sql = "UPDATE `store_medicine_mata` SET `instock` = $data WHERE `product_id` = '$pid' AND `Batch_Number` = '$batch_no' AND `expire_date` = '$exp_date' AND `supplier_id` = '$supplier_id' AND `store_id` = '$store_id'";
     
    //   $query = $this->db->query($sql);
    //   $result = $query->result();
    //   return true; 
      
      $this->db->where('product_id', $pid);
      $this->db->where('Batch_Number', $batch_no);
      $this->db->where('expire_date', $exp_date);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('store_id', $store_id);
      $this->db->where('status', "1");
      $this->db->update('store_medicine_mata', $data);
      //echo $this->db->last_query();
      if ($this->db->affected_rows() > 0) {
        return true;
        } else {
            return false;
        }
    }

    public function insert_rev_stock($data)
    {
      $this->db->insert('reverse_stock', $data);
      $insert_id = $this->db->insert_id();
      return  $insert_id;
    }

    public function get_requested_stock($store_id)
    {
      $this->db->select('*');
      $this->db->from('reverse_stock');
      $this->db->where('from_store_id ', $store_id);
      $this->db->order_by('id', 'desc');
      $this->db->group_by('request_id');
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }

    public function get_store_name($store_id)
    {
      $this->db->select('store_name');
      $this->db->from('store');
      $this->db->where('id', $store_id);
      $query = $this->db->get();
      $result = $query->result();
     //echo $this->db->last_query();die;
      return $result;
    }

    public function Request_stock_his()
    {

      $store_id = $this->session->userdata('store_id');
      $this->db->select('*');
      $this->db->from('stock_request');
      $this->db->where('store_id', $store_id);
      $this->db->order_by('createdat', 'DESC');
      $this->db->group_by('stock_request.request_id');
      $query = $this->db->get();
      $result = $query->result();
    // echo $this->db->last_query();
      return $result;
    }

    public function stock_his_by_sub($request_id)
    {
      $this->db->select('*');
      $this->db->from('stock_request');
      $this->db->where('request_id', $request_id);
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }
    public function stock_his_by_reqid($request_id)
    {
      $this->db->select('*');
      $this->db->from('adjustment_tble');
      $this->db->where('adjus_id', $request_id);
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }
    public function get_pro_name($id)
    {
      $this->db->select('product_name');
      $this->db->from('medicine');
      $this->db->where('product_id', $id);
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }

    public function view_all_stock($pro_id, $sup_id, $batch)
    {
      $this->db->select('*');
      $this->db->from('store_medicine_mata');
      $this->db->where('product_id', $pro_id);
      $this->db->where('supplier_id', $sup_id);
      $this->db->where('Batch_Number', $batch);
      $this->db->where('status', "1");
      $query = $this->db->get();
      $result = $query->result();
      // echo $this->db->last_query();
      return $result;
    }

    public function req_stock_history()
    {
      $this->db->select('*');
      $this->db->from('reverse_stock');
      $this->db->order_by("id", "desc");
      $this->db->group_by('reverse_stock.request_id'); 
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }

    public function admin_req_his($req_id)
    {
      $this->db->select('*');
      $this->db->from('reverse_stock');
      $this->db->where('request_id', $req_id);
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }

    public function append_medicine($store_id)
    {
      $this->db->select('*');
      $this->db->from('store_medicine_mata');
      $this->db->where('store_id', $store_id);
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }
    public function get_store_id($store_id)
    {
      $this->db->select('*');
      $this->db->from('store');
      $this->db->where('store_id', $store_id);
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }

    public function get_medicine_name($product_id)
    {
      $this->db->select('product_id, product_name, form');
      $this->db->from('medicine');
      $this->db->where('product_id', $product_id);
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }

    public function getBydatemedicineFromToEnd($end)
    {
      $this->db->select('*');
      $this->db->from('closing_tble');
      //$this->db->where('created_at >=', $start);
      $this->db->where('created_at <=', $end);
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }

    public function get_supplier_name($s_id)
    {
      $this->db->select('*');
      $this->db->from('supplier');
      $this->db->where('s_id', $s_id);
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }

    public function get_discount($c_id)
    {
      $this->db->select('*');
      $this->db->from('customer');
      $this->db->where('c_id', $c_id);
      $query = $this->db->get();
      $result = $query->result();
      //echo $this->db->last_query();
      return $result;
    }

    public function get_unitmrp($pid,$batchNumber)
    {
      $this->db->select('*');
      $this->db->from('purchase_history');
      $this->db->where('mid', $pid);
      $this->db->where('Batch_Number', $batchNumber);
      $query = $this->db->get();
      $result = $query->result();
      //echo $this->db->last_query();
      return $result;
    }


    public function getAllInvoiceNotes($id)
    {
      $this->db->select('*');
      $this->db->from('invoice_notes');
      $this->db->where('invoice_no', $id);
      $this->db->order_by('created_at', 'desc');
      $query = $this->db->get();
      $result = $query->result();
      //echo $this->db->last_query();
      return $result;
    }

    

}

?>