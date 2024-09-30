<?php

	class Purchase_model extends CI_Model{


	function __consturct(){
	parent::__construct();
	
	}
    public function Add_medicine_info($data){
		$this->db->insert('medicine',$data);
	}
    public function Insert_Supplier_amount($data){
		$this->db->insert('supp_payment',$data);
	}
  public function insert_doctor($data){
		$this->db->insert('doctor',$data);
	}
  public function Update_Supplier_amount($purid,$data) 
  {
    $this->db->where('pur_id',$purid);
    $this->db->where('from','purchase');
    $this->db->update('supp_payment',$data);
  }
    public function Save_Purchase($data){
		$this->db->insert('purchase',$data);
	}
  public function Save_Purchase_draft($data){
		$this->db->insert('purchase_draft',$data);
    $insert_id = $this->db->insert_id();
     return $insert_id;
	}
  public function Update_Purchase_draft($data,$draftid){
    $this->db->where('id',$draftid);
		$this->db->update('purchase_draft',$data);
    //echo $this->db->last_query();
    $insert_id = $this->db->insert_id();
     return $insert_id;
	}
  public function Save_Purchase_Draftmeta($data){
		$this->db->insert('purchase_draft_meta',$data);
	}
  public function Update_Purchase_Draftmeta($data,$medicine,$draftid){
    $this->db->where('draft_id',$draftid);
    $this->db->where('medicine_id',$medicine);
		$this->db->update('purchase_draft_meta',$data);
    //echo $this->db->last_query();
	}
  public function Update_Purchase($purid,$data){
    $this->db->where('p_id',$purid);
		$this->db->update('purchase',$data);
	}
    public function Save_Purchase_History($data){
		$this->db->insert('purchase_history',$data);
	}

  public function Insert_Store_Mata($data){
		$this->db->insert('store_medicine_mata',$data);
	}
    public function Insert_Supplier_PayHistory($data){
		// $insert_id = $this->db->insert_id('supp_account',$data);
     $this->db->insert('supp_account',$data);
     $insert_id = $this->db->insert_id();
     return $insert_id;
	}

    public function Save_Purchase_return($data){
		$this->db->insert('purchase_return',$data);
	}
    public function Save_Purchase_Retun_History($data){
		$this->db->insert('purchase_return_details',$data);
	}
    public function GetSupplierValue($param){
        $sql = "SELECT * FROM `supplier` WHERE `s_name` LIKE '$param%'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function GetPurchaseparam($param){
        $sql = "SELECT * FROM `purchase` WHERE `p_id` LIKE '%$param%' OR `invoice_no` LIKE '%$param%'";
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;
    }
    public function getmedicineByMId($medicine) {
        $sql = "SELECT * FROM `medicine` WHERE `product_id`='$medicine'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function Delete_Purchase_Draftmeta($db_id, $draftid) {
      $sql = "DELETE FROM `purchase_draft_meta` WHERE `id` = $db_id AND `draft_id` = $draftid";
      $query = $this->db->query($sql, array($db_id, $draftid));
      //echo $this->db->last_query();
      return $query;
  }
  
    public function check_Purchase_Draftmeta($draftid) {
      $sql = "SELECT `purchase_draft_meta`.`id` FROM `purchase_draft_meta` WHERE `draft_id`='$draftid'";
      $query = $this->db->query($sql);
      $result = $query->result();
      //echo $this->db->last_query();
      return $result;
  }
    public function Getallsuppliernames() {
      $sql = "SELECT * FROM `supplier`";
      $query = $this->db->query($sql);
      $result = $query->row();
      return $result;
  }
  public function getlastinsertedID() {
    $sql = "SELECT * FROM `purchase_draft` order by `purchase_draft`.`id` desc limit 1";
    $query = $this->db->query($sql);
    $result = $query->row();
    return $result;
}
    public function getmedicineByMIdAdmin($medicine,$mainStoreID, $supplier_id, $batch) {
      $sql = "SELECT * FROM `store_medicine_mata` WHERE `product_id`='$medicine' AND `store_id` = '$mainStoreID' AND `supplier_id` = '$supplier_id' AND `Batch_Number` = '$batch'";
      $query = $this->db->query($sql);
      $result = $query->row();
      return $result;
  }
    public function getmedicineByMIdSidBtch($medicine,$supplier,$batchNo) {

     

      //echo $sql = "SELECT `instock` FROM `medicine_mata` WHERE `product_id`='$medicine' AND `supplier_id`='$supplier' AND `Batch_Number`='$batchNo'";
      $sql = "SELECT * FROM `medicine_mata` WHERE `product_id`='$medicine' AND `supplier_id`='$supplier'AND `Batch_Number`='$batchNo'";
      
      $query = $this->db->query($sql);
      $result = $query->row();
      //print_r($result);
      return $result;
  }
  public function getmedicineByMIdSidBtchstore($medicine,$supplier,$batchNo,$mainStoreID) {

     

    //echo $sql = "SELECT `instock` FROM `medicine_mata` WHERE `product_id`='$medicine' AND `supplier_id`='$supplier' AND `Batch_Number`='$batchNo'";
    $sql = "SELECT * FROM `store_medicine_mata` WHERE `product_id`='$medicine' AND `supplier_id`='$supplier'AND `Batch_Number`='$batchNo' AND `store_id` = '$mainStoreID'";
    
    $query = $this->db->query($sql);
    $result = $query->row();
    //print_r($result);
    return $result;
}
    public function getPurchaseInfo() {

      $this->db->select('*');
      $this->db->from('purchase');
      $this->db->join('supplier','purchase. sid = supplier. s_id','left');
      $this->db->order_by('purchase.created_at', 'desc');
      
      $query = $this->db->get();
      $result = $query->result();
    //  echo $this->db->last_query();
      return $result;
   
    }
    public function getPurchaseInvoiceData($pid) {
    $sql = "SELECT `purchase`.*,
      `supplier`.`s_id`,`s_name`
      FROM `purchase`
      LEFT JOIN `supplier` ON `purchase`.`sid`=`supplier`.`s_id`
      WHERE `purchase`.`p_id`='$pid'";
       $query = $this->db->query($sql);
       $result = $query->result();
       //echo $this->db->last_query();
        return $result;
    }

    public function getPurchaseInvoiceDatafromhis($pid) {
      $sql = "SELECT `purchase_history`.*,
        `supplier`.`s_id`,`s_name`,`purchase`.`pur_date`,`invoice_no`,`pur_details`
        FROM `purchase_history`
        LEFT JOIN `supplier` ON `purchase_history`.`supp_id`=`supplier`.`s_id`
        LEFT JOIN `purchase` ON `purchase_history`.`pur_id`=`purchase`.`p_id`
        WHERE `purchase_history`.`pur_id`='$pid'";
         $query = $this->db->query($sql);
         $result = $query->result();
         //echo $this->db->last_query();
          return $result;
      }

    public function Update_Medicine($medicine,$data) {
        $this->db->where('product_id',$medicine);
        $this->db->update('medicine',$data);
       //echo $this->db->last_query();
       //die;
    }

    public function Update_MedicineAdminStore($medicine,$data,$store_id,$supplier_id, $batch) {
      $this->db->where('supplier_id',$supplier_id);
      $this->db->where('Batch_Number',$batch);
      $this->db->where('product_id',$medicine);
      $this->db->where('store_id',$store_id);
      $this->db->update('store_medicine_mata',$data);
     //echo $this->db->last_query();
      //die;
  }

    public function Update_Medicine_Mata($medicine,$data,$supplier,$batchNo) {
      $this->db->where('product_id',$medicine);
      $this->db->where('supplier_id',$supplier);
      $this->db->where('Batch_Number',$batchNo);
      $this->db->update('medicine_mata',$data);
     //echo $this->db->last_query();
     //die;
  }
  public function Update_Store_Mata1($medicine,$supplier,$batch_no,$data) {
    $this->db->where('product_id',$medicine);
    $this->db->where('supplier_id',$supplier);
    $this->db->where('Batch_Number',$batch_no);
    $this->db->update('store_medicine_mata',$data);
   //echo $this->db->last_query();
   //die;
}

    public function insert_med_meta($data)
    {
      $this->db->insert('medicine_mata',$data);
      $insert_id = $this->db->insert_id();
      //echo $this->db->last_query();
      return $insert_id;
    }
    public function update_P_balance($purid,$data) {
        $this->db->where('p_id',$purid);
        $this->db->update('purchase',$data);
    }
    public function Update_Purchase_History_Details($ph,$data){
        $this->db->where('ph_id',$ph);
        $this->db->update('purchase_history',$data);
    }
    public function Update_Supplier_PayHistory($purid,$data){
        $this->db->where('pur_id',$purid);
        $this->db->update('supp_account',$data);
    }
    public function GetPurchaseHistory($id) {
    $sql = "SELECT `purchase_history`.*,
      `medicine`.`product_name`,`strength`,
      `supplier`.`s_id`,`s_name`,`purchase`.`invoice_no`,`entry_date`,`pur_details`,`gtotal_amount`,`adjustment`,`supp_payment`.`paid_amount`
      FROM `purchase_history`
      LEFT JOIN `medicine` ON `purchase_history`.`mid`=`medicine`.`product_id`
      LEFT JOIN `supplier` ON `purchase_history`.`supp_id`=`supplier`.`s_id`
      LEFT JOIN `purchase` ON `purchase_history`.`pur_id`=`purchase`.`p_id`
      LEFT JOIN `supp_payment` ON `purchase_history`.`pur_id`=`supp_payment`.`pur_id`
      WHERE `purchase_history`.`pur_id`='$id' group by `purchase_history`.`ph_id`";
      //$this->db->group_by('purchase_history.ph_id'); 
        $query = $this->db->query($sql);
        $result = $query->result();
       //echo $this->db->last_query();
        return $result;        
    }

    public function GetPurchaseHistorybyId($id) {
      $sql = "SELECT `purchase_draft`.*,
      `purchase_draft_meta`.`medicine_id`,`batch`,`exp_date`,`qnty`,`free_qnty`,`purchase_rate`,`mrp`,`discount`,`draft_id`      
        FROM `purchase_draft`
        LEFT JOIN `purchase_draft_meta` ON `purchase_draft`.`id`=`purchase_draft_meta`.`draft_id`
        WHERE `purchase_draft`.`id`='$id'";

      // $sql = "SELECT * FROM `purchase_draft_meta` WHERE `purchase_draft_meta`.`draft_id`='$id'";
          $query = $this->db->query($sql);
          $result = $query->result();
          //echo $this->db->last_query();
          return $result;        
      }
    public function GetPurchaseHistorymetabyId($id) {
      // $sql = "SELECT `purchase_draft`.*,
      // `purchase_draft_meta`.`medicine_id`,`batch`,`exp_date`,`qnty`,`free_qnty`,`purchase_rate`,`mrp`,`discount`,`draft_id`      
      //   FROM `purchase_draft`
      //   LEFT JOIN `purchase_draft_meta` ON `purchase_draft`.`id`=`purchase_draft_meta`.`draft_id`
      //   WHERE `purchase_draft`.`id`='$id'";

      $sql = "SELECT `purchase_draft_meta`.*,`medicine`.`product_name`,`medicine`.`generic_name`,`medicine`.`strength`,`medicine`.`form`,`medicine`.`subform`,`medicine`.`hsn`,`purchase_draft`.`total`,`purchase_draft`.`totaldiscount`,`purchase_draft`.`tax`,`purchase_draft`.`grandTotal`,`purchase_draft`.`adjustment`,`purchase_draft`.`paid`,`purchase_draft`.`due` FROM `purchase_draft_meta`
      LEFT JOIN `medicine` ON `purchase_draft_meta`.`medicine_id`=`medicine`.`product_id`
      LEFT JOIN `purchase_draft` ON `purchase_draft_meta`.`draft_id`=`purchase_draft`.`id`
      WHERE `purchase_draft_meta`.`draft_id`='$id'";
          $query = $this->db->query($sql);
          $result = $query->result();
          //echo $this->db->last_query();
          return $result;        
      }
    public function getPurchaseDetailsInvoiceData($pid) {
    $sql = "SELECT `purchase_history`.*,
      `medicine`.*,`purchase_history`.`unit_price`,`purchase_history`.`Batch_Number`
      FROM `purchase_history`
      LEFT JOIN `medicine` ON `purchase_history`.`mid`=`medicine`.`product_id`
      WHERE `purchase_history`.`pur_id`='$pid'";
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;        
    }
    public function GePurchaseInvoice($invoice){
        $sql = "SELECT * FROM `purchase` WHERE `invoice_no`='$invoice'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function GetBankName($bankid){
        $sql = "SELECT `bank_id`,`bank_name` FROM `bank` WHERE `bank_id`='$bankid'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function GePurchaseDetAILSSs($pid){
        $sql = "SELECT * FROM `purchase` WHERE `p_id`='$pid'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    } 
    public function GePurchaseHISDetAILSSs($ph){
        $sql = "SELECT * FROM `purchase_history` WHERE `ph_id`='$ph'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function Getalldrafts(){
      $sql = "SELECT * FROM `purchase_draft` order by `purchase_draft`.`id` desc";
      $query = $this->db->query($sql);
      $result = $query->result();
      return $result;
  }
  function GetSuppIDbatch($midbatch){
    $this->db->select('*');
    $this->db->limit(10);
    $this->db->like('s_name', $midbatch);
    //$this->db->or_like('s_id', $midbatch);  
   // $this->db->or_like('s_phone', $midbatch);
    $this->db->where('status', "Active");
    $query = $this->db->get('supplier');
    
    if($query->num_rows() > 0){
      foreach ($query->result_array() as $row){
        $new_row['label']=htmlentities(stripslashes($row['s_name']));
        $new_row['value']=htmlentities(stripslashes($row['s_id']));
        $row_set[] = $new_row; //build an array
      }
      echo json_encode($row_set); //format the array into json data
    }
  }  

  public function supplier_name()
  {
    $this->db->select('s_name,s_id');
    $this->db->from('supplier');
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }
  
  function GetSupplierByid22()
  {
    $this->db->select('*');
    $this->db->from('supplier');
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  } 

  public function get_grn_data($p_id)
  {
    $this->db->select('*');
    $this->db->from('purchase');
    $this->db->where('p_id', $p_id);
    $this->db->order_by("id", "desc");
    $query = $this->db->get();
    $result = $query->result();
    return $result;

  }
  public function get_supplier_name($sid)
  {
    $this->db->select('*');
    $this->db->from('supplier');
    $this->db->where('s_id', $sid);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }
  public function get_medicine_detail($sid)
  {
    $this->db->select('*');
    $this->db->from('medicine_mata');
    $this->db->join('medicine','medicine_mata.product_id = medicine.product_id','left');
    
    $this->db->where('supplier_id', $sid);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }

  public function get_medicine_detail_his($puid)
  {
    $this->db->select('purchase_history.ph_id, purchase_history.pur_id, purchase_history.free_qty, purchase_history.mid, purchase_history.supp_id, purchase_history.qty, purchase_history.return_qnty, purchase_history.supplier_price, purchase_history.discount, purchase_history.expire_date, purchase_history.Batch_Number, purchase_history.delivery_time, purchase_history.payment_time, purchase_history.mrp, purchase_history.total_amount, purchase_history.tax,  medicine.product_name, medicine.generic_name, medicine.instock, store_medicine_mata.purchase_rate, purchase_history.unit_mrp');
    $this->db->from('purchase_history');
    $this->db->join('medicine','purchase_history.mid = medicine.product_id','left');
    $this->db->join('store_medicine_mata','store_medicine_mata.product_id = medicine.product_id','left');
    $this->db->where('purchase_history.pur_id', $puid);
    $this->db->group_by('purchase_history.ph_id'); 
    $this->db->group_by('purchase_history.pur_id'); 
    $query = $this->db->get();
    $result = $query->result();
   // echo $this->db->last_query();
    return $result;
  }

  public function medi_for_grn($grn)
  {
    $this->db->select('grn.po_no, grn.supplier_name, grn.order_type, grn.supplier_code, grn.grn_no, grn.dc_no, grn.dc_date, grn.bill_no, grn.bill_date, grn.receivedamt,grn.dues, meta_grn.idd, meta_grn.grn_no , meta_grn.product_id , meta_grn.Batch_Number , meta_grn.instock , meta_grn.expire_date , meta_grn.Sch_no , meta_grn.Sch_date, meta_grn.rec_qty, meta_grn.price, meta_grn.unit_mrp, purchase_history.total_amount, purchase_history.tax');
    $this->db->from('meta_grn');
    $this->db->join('grn','meta_grn.grn_no = grn.grn_no','left');
    $this->db->join('purchase_history','purchase_history.mid = meta_grn.product_id','left');
    $this->db->where('grn.grn_no', $grn);
    $this->db->group_by('meta_grn.idd'); 
    $query = $this->db->get();
    $result = $query->result();
    //echo $this->db->last_query();
    return $result;
  }


  public function save_grn($data)
  {
    $this->db->insert('grn',$data);
    $insert_id = $this->db->insert_id();
    //echo $this->db->last_query();
    return $insert_id;
  }


  public function save_grn_meta($data)
  {
    $this->db->insert('meta_grn',$data);
    $insert_id = $this->db->insert_id();
    return $insert_id;
  }

  public function get_grn()
  {
    $this->db->select('*');
    $this->db->from('grn');
    $this->db->group_by('grn_no');
    $this->db->order_by("id", "desc"); 
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }

  public function delete_grn($id)
  {
    $this->db->where('grn_no', $id);
    $this->db->delete('grn');
    return TRUE;
  }
  public function edit_grn($id)
  {
    $this->db->select('*');
    $this->db->from('grn');
    $this->db->where('grn_no', $id);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }

  public function get_edit_medicine_detail($grn_no)
  {
    $this->db->select('*');
    $this->db->from('meta_grn');
    $this->db->join('grn', 'grn.grn_no = meta_grn.grn_no', 'left'); 
    $this->db->where('meta_grn.grn_no', $grn_no);
    $query = $this->db->get();
    $result = $query->result();
    //echo $this->db->last_query();
    return $result;
  }
  public function append_edit_medicine_detail($id)
  {
    $this->db->select('*');
    $this->db->from('grn');
    $this->db->join('meta_grn', 'grn.grn_no = meta_grn.grn_no', 'left'); 
    $this->db->where('meta_grn.idd', $id);
    $query = $this->db->get();
    $result = $query->result();
    //echo $this->db->last_query();
    return $result;
  }

  public function update_grn($id, $data)
  {
    $this->db->where('grn_no', $id);
    $this->db->update('grn', $data);
  // echo $this->db->last_query();
    return true;
  }
  public function Update_Store_Mata2($medicine,$supplier,$batchNo,$data,$mainStoreID)
  {
    $this->db->where('product_id',$medicine);
    $this->db->where('supplier_id',$supplier);
    $this->db->where('Batch_Number',$batchNo);
    $this->db->where('store_id',$mainStoreID);
    $this->db->update('store_medicine_mata',$data);
   //echo $this->db->last_query();
   //die;
}
  public function update_grn_meta($id, $data)
  {
    $this->db->where('idd', $id);
    $this->db->update('meta_grn', $data);
    //echo $this->db->last_query();
    return true;
  }

  public function delete_sub_grn($id)
  {
    $this->db->where('idd', $id);
    $this->db->delete('meta_grn');
    return true;
  }

  public function existing_id($grn_no)
  {
    $this->db->select('id');
    $this->db->from('grn');
    $this->db->where('grn_no', $grn_no);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }

  public function delete_grn_meta($grn_no)
  {
    $this->db->where('grn_no', $grn_no);
    $this->db->delete('meta_grn');
    return true;
  }

  public function get_exp_date($pid, $exp_date)
  {
    $this->db->select('expire_date');
    $this->db->from('medicine');
    $this->db->where('product_id', $pid);
    $this->db->where('expire_date', $exp_date);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }

  public function get_medi_with_id($pid)
  {
    $this->db->select('*');
    $this->db->from('medicine');
    $this->db->where('product_id', $pid);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }

  public function manufacturer()
  {
    $this->db->select('*');
    $this->db->from('manufacturer');
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }

  public function get_medicine()
  {
    $this->db->select('*');
    $this->db->from('medicine');
    $this->db->order_by("product_name", "asc");
    $query = $this->db->get();
    $result = $query->result();
    
    return $result;
  }

  public function check_batch_no($medicine, $batch_no, $supplier)
  {
    $this->db->select('*');
    $this->db->from('medicine_mata');
    $this->db->where('product_id', $medicine);
    $this->db->where('Batch_Number', $batch_no);
    $this->db->where('supplier_id', $supplier);
    $query = $this->db->get();
    $result = $query->result();
    // echo $this->db->last_query();
    return $result;
  }
  public function check_batch_no12($medicine, $batch_no, $supplier)
  {
    $this->db->select('*');
    $this->db->from('medicine_mata');
    $this->db->where('product_id', $medicine);
    $this->db->where('Batch_Number', $batch_no);
    $this->db->where('supplier_id', $supplier);
    $query = $this->db->get();
    $result = $query->result();
    // echo $this->db->last_query();
    return $result;
  }

  public function check_med_stock($medicine)
  {
    $this->db->select('*');
    $this->db->from('medicine');
    $this->db->where('product_id', $medicine);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }

  public function update_med_stock($medicine, $update_stock)
  {
    $this->db->where('product_id', $medicine);
    $this->db->update('medicine', $update_stock);
    // echo $this->db->last_query();
    // die();
    return true;
  }

  public function get_med_his($medicine)
  {
    $storeid = $this->session->userdata('store_id');
    $this->db->select('*');
    $this->db->from('store_medicine_mata');
    $this->db->where('product_id', $medicine);
    $this->db->where('store_id', $storeid);
    $this->db->where('instock >', "0");
    $this->db->where('status', '1');
    $query = $this->db->get();
    $result = $query->result();
   // echo $this->db->last_query();
    return $result;
  }
  public function get_med_his55($medicine)
  {
   $storeid = $this->session->userdata('store_id');
    $this->db->select('*');
    $this->db->from('store_medicine_mata');
    $this->db->where('product_id', $medicine);
    $this->db->where('store_id', $storeid);
    $this->db->where('instock >', "0");
    $this->db->where('status', "1");
   // $this->db->group_by('product_id'); 
    $query = $this->db->get();
    $result = $query->result();
    // echo $this->db->last_query();
    return $result;
  }
  
  public function get_taxonmedicine($product_id, $supplier_id, $Batch_Number)
  {
   $storeid = $this->session->userdata('store_id');
    $this->db->select('*');
    $this->db->from('purchase_history');
    $this->db->where('mid', $product_id);
    $this->db->where('supp_id', $supplier_id);
    $this->db->where('Batch_Number', $Batch_Number);
    // $this->db->where('expire_date', $expirey);
   // $this->db->group_by('product_id'); 
    $query = $this->db->get();
    $result = $query->result();
    //echo $this->db->last_query();
    return $result;
  }
  public function getmain_store_stock($medicine)
  {
    $storeid = $this->session->userdata('store_id');
    $this->db->select('*');
    $this->db->from('store_medicine_mata');
    $this->db->where('product_id', $medicine);
    $this->db->where('store_id', $storeid);
    $this->db->where('instock >', "0");
    $query = $this->db->get();
    $result = $query->result();
   // echo $this->db->last_query();
    return $result;
  }

  public function get_med_stock_medicine_meta($medicine, $batch_no, $supplier)
  {
    $this->db->select('instock');
    $this->db->from('medicine_mata');
    $this->db->where('product_id', $medicine);
    $this->db->where('Batch_Number', $batch_no);
    $this->db->where('supplier_id', $supplier);
    $query = $this->db->get();
    $result = $query->result();
    //echo $this->db->last_query();
    return $result;
  }

  public function Update_Medicine_meta_stock($medicine, $batch_no, $supplier, $stock)
  {
  $this->db->where('product_id', $medicine);
  $this->db->where('Batch_Number', $batch_no);
  $this->db->where('supplier_id', $supplier);
  $this->db->update('medicine_mata', $stock);
  
  return true;
  }

  public function get_mmedicine_meta_stock($medicine, $supplier_id, $batch_no)
  {
    $this->db->select('instock,sale_qty');
    $this->db->from('medicine_mata');
    $this->db->where('product_id', $medicine);
    $this->db->where('Batch_Number', $batch_no);
    $this->db->where('supplier_id', $supplier_id);
    $query = $this->db->get();
    $result = $query->result();
  
    return $result;
  }

  public function Update_Medicine_meta($medicine, $supplier_id, $batch_no, $data15)
  {
    $this->db->where('product_id', $medicine);
    $this->db->where('Batch_Number', $batch_no);
    $this->db->where('supplier_id', $supplier_id);
    $this->db->update('medicine_mata', $data15);
   
    return true;
  }

  public function store_name($storeid){
    
    $sql = "SELECT `store_name` FROM `store` WHERE `store_id`='$storeid'";
    $query = $this->db->query($sql);
    $result = $query->row();
    
    return $result;
}

public function getAllPurchaseById($pid){
  $sql = "SELECT * FROM `purchase` WHERE `purchase`.`p_id`='$pid'";
  $query = $this->db->query($sql);
  $result = $query->row();
  return $result;
} 
 
public function check_batch($medicine,$supplier,$batch_no)
  {
    $this->db->select('*');
    $this->db->from('store_medicine_mata');
    $this->db->where('product_id', $medicine);
    $this->db->where('Batch_Number', $batch_no);
    $this->db->where('supplier_id', $supplier);
    $query = $this->db->get();
    $result = $query->result();
    // echo $this->db->last_query();
    return $result;
  }

  public function chk_med_store_stock($medicine, $supplier_id, $batch_no, $store_id, $exp_date)
  {
    $this->db->select('*');
    $this->db->from('store_medicine_mata');
    $this->db->where('product_id', $medicine);
    $this->db->where('Batch_Number', $batch_no);
    $this->db->where('supplier_id', $supplier_id);
    $this->db->where('store_id', $store_id);
    $this->db->where('expire_date', $exp_date);
    $query = $this->db->get();
    $result = $query->result();
   // echo $this->db->last_query();
    return $result;
  }

  public function update_med_store_stock($medicine, $supplier_id, $batch_no, $store_id, $exp_date, $data)
  {
    $this->db->where('product_id', $medicine);
    $this->db->where('Batch_Number', $batch_no);
    $this->db->where('supplier_id', $supplier_id);
    $this->db->where('store_id', $store_id);
    $this->db->where('expire_date', $exp_date);
    $this->db->where('status', "1");
    $this->db->update('store_medicine_mata', $data);
    //return $this->db->last_query();
    return true;

  }

  public function check_med_for_rev($pro_id, $store_id)
  {
    $this->db->select('*');
    $this->db->from('store_medicine_mata');
    $this->db->where('product_id', $pro_id);
    $this->db->where('store_id', $store_id);
    $query = $this->db->get();
    $result = $query->result();
    // echo $this->db->last_query();
    return $result;
  }

  public function get_store_d($store_id)
  {
    $this->db->select('id');
    $this->db->from('store');
    $this->db->where('store_id', $store_id);
    $query = $this->db->get();
    $result = $query->result();
     //echo $this->db->last_query();
    return $result;
  }




// Get instock med qnty from store_mata by storeid,productid,supplierid,batchno.
  public function getinstock_store_med($supID,$medID,$medBth,$storeID)
  {
    
    $this->db->select('instock');
    $this->db->from('store_medicine_mata');
    $this->db->where('supplier_id', $supID);
    $this->db->where('product_id', $medID);
    $this->db->where('Batch_Number', $medBth);
    $this->db->where('store_id', $storeID);
    
    $query = $this->db->get();
    $result = $query->result();
   // echo $this->db->last_query();
    return $result[0]->instock;
  }


  
  public function update_instock_store_med($supID,$medID,$medBth,$storeID,$stockdata)
    {
      
      $this->db->where('supplier_id', $supID);
      $this->db->where('product_id', $medID);
      $this->db->where('Batch_Number', $medBth);
      $this->db->where('store_id', $storeID);
      $this->db->update('store_medicine_mata', $stockdata);
      
      return true;
    }

    public function update_rev_status_store_med($reqID,$supID,$medID,$medBth,$storeID,$statusdata)
    {
      $this->db->where('request_id', $reqID);
      $this->db->where('supplier_id', $supID);
      $this->db->where('product_id', $medID);
      $this->db->where('Batch_Number', $medBth);
      $this->db->where('from_store_id', $storeID);
      $this->db->update('reverse_stock', $statusdata);
      return true;
    }  

    public function check_store_medi_stock($product_id)
    {
      $store_id = $this->session->userdata('store_id');
      $this->db->select('*');
      $this->db->from('store_medicine_mata');
      $this->db->where('product_id', $product_id);
      $this->db->where('store_id', $store_id);
      $this->db->where('status', 1);
      $this->db->order_by("instock", "desc");
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }
  
    public function check_stock($product_id)
    {
      $store_id = $this->session->userdata('store_id');
      $this->db->select('instock');
      $this->db->from('store_medicine_mata');
      $this->db->where('product_id', $product_id);
      $this->db->where('store_id', $store_id);
      $query = $this->db->get();
      $result = $query->result();
      // echo $this->db->last_query();
      return $result; 
    }

    public function check_status($req)
    {
      $this->db->select('status');
      $this->db->from(' stock_request');
      $this->db->where('request_id', $req);
      $query = $this->db->get();
      $result = $query->result();
      // echo $this->db->last_query();
      return $result; 
    }


    public function update_store_med_meta_stock($data, $pro_id, $id)
    {
      $this->db->where('id', $id);
      $this->db->where('product_id', $pro_id);
      $this->db->update('store_medicine_mata', $data);
       //echo $this->db->last_query();
      return true;
    }

    public function get_med_detail($pro_id, $store_id)
    {
      $this->db->select('*');
      $this->db->from('store_medicine_mata');
      $this->db->where('product_id', $pro_id);
      $this->db->where('store_id', $store_id);
      $query = $this->db->get();
      $result = $query->result();
      // echo $this->db->last_query();
      return $result;
    }

    public function return_back($return)
    {
      $this->db->insert('store_medicine_mata',$return);
      //echo $this->db->last_query(); die;
      $insert_id = $this->db->insert_id();
      return $insert_id;
    }

    public function get_sub_store($pro_id, $supplier_id, $Batch_Number, $expire_date, $store_id)
    {
      $this->db->select('*');
      $this->db->from('store_medicine_mata');
      $this->db->where('product_id', $pro_id);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $Batch_Number);
      $this->db->where('expire_date', $expire_date);
      $this->db->where('store_id', $store_id);
      $query = $this->db->get();
      $result = $query->result();
      //echo $this->db->last_query();
      return $result;

    }

    public function update_sub_store_stock($pro_id, $supplier_id, $Batch_Number, $expire_date, $store_id, $data)
    {
      $this->db->where('product_id', $pro_id);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $Batch_Number);
      $this->db->where('expire_date', $expire_date);
      $this->db->where('store_id', $store_id);
      $this->db->where('status', 1);
      $this->db->update('store_medicine_mata', $data);
      
       //echo $this->db->last_query();
      return true;
    }

    public function update_req_id_stock($req_id, $req_stock, $pro_id)
    {  
      $this->db->where('request_id', $req_id);
      $this->db->where('product_id', $pro_id);
      $this->db->update('stock_request', $req_stock);
      // echo $this->db->last_query();
      return true;
    }

    public function get_pre_stock($medicine,$batchNo, $supplier)
    {
      $this->db->select('*');
      $this->db->from('purchase_history');
      $this->db->where('mid', $medicine);
      $this->db->where('supp_id', $supplier);
      $this->db->where('Batch_Number', $batchNo);
      $query = $this->db->get();
      $result = $query->result();
      //echo $this->db->last_query();
      return $result;
    }

    public function update_req_stock_status($req_id, $data)
    {
      $this->db->where('request_id', $req_id);
      $this->db->update('stock_request', $data);
      // echo $this->db->last_query();
      return true;
    }

    public function check_purchase($pro_id, $supplier_id, $Batch_Number, $expire_date)
    {
      $this->db->select('*');
      $this->db->from('store_medicine_mata');
      $this->db->where('product_id', $pro_id);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $Batch_Number);
      $this->db->where('expire_date', $expire_date);
      $this->db->where('status', "0");
      $query = $this->db->get();
      $result = $query->result();
    //  echo $this->db->last_query();
      return $result;

    }

    public function update_status($pro_id, $supplier_id, $Batch_Number, $expire_date, $data)
    {
           $status = "0" ;
      $this->db->where('product_id', $pro_id);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $Batch_Number);
      $this->db->where('expire_date', $expire_date);
      $this->db->where('status', $status);
      $this->db->update('store_medicine_mata', $data);
     // echo $this->db->last_query();
      return true;
    }

    public function update_status_at_one($pro_id, $supplier_id, $Batch_Number, $expire_date, $data)
    {
      $store_id = $this->session->userdata('store_id');
      $status = "1" ;
      $this->db->where('product_id', $pro_id);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $Batch_Number);
      $this->db->where('expire_date', $expire_date);
      $this->db->where('status', $status);
      $this->db->where('store_id', $store_id);
      $this->db->update('store_medicine_mata', $data);
     // echo $this->db->last_query();
      return true;
    }

    public function update_pre_instock_status($pro_id, $supplier_id, $Batch_Number, $expire_date, $data)
    {
      $status = "1" ;
      $this->db->where('product_id', $pro_id);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $Batch_Number);
      $this->db->where('expire_date', $expire_date);
      $this->db->where('status', $status);
      $this->db->update('store_medicine_mata', $data);
     // echo $this->db->last_query();
      return true;
    }

    public function insert_pending_stock($data)
    {
      $this->db->insert('store_medicine_mata', $data);
      $insert_id = $this->db->insert_id();
      //echo $this->db->last_query();
      return $insert_id;
    }

    public function check_meta_stock($medicine, $supplier_id, $batch)
    {
      $this->db->select('*');
      $this->db->from('medicine_mata');
      $this->db->where('product_id', $medicine);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $batch);
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }

    public function check_status_in_med_meta($pro_id, $supplier_id, $Batch_Number)
    {
      $this->db->select('*');
      $this->db->from('medicine_mata');
      $this->db->where('product_id', $pro_id);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $Batch_Number);
      $query = $this->db->get();
      $result = $query->result();
      //echo $this->db->last_query();die;
      return $result;

    }

    public function update_status_med_meta($pro_id, $supplier_id, $Batch_Number, $data)
    {
      $this->db->where('product_id', $pro_id);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $Batch_Number);
      $this->db->update('medicine_mata', $data);
      return true;
    }

    public function insert_pending_stock_in_medicine_meta($data)
    {
      $this->db->insert('medicine_mata', $data);
      $insert_id = $this->db->insert_id();
      return $insert_id;
    }

    public function get_sup_id($s_name)
    {
      $this->db->select('s_id');
      $this->db->from('supplier');
      $this->db->where('s_name', $s_name);
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }

    public function get_med_det($product_id, $Batch_Number, $sid)
    {
      $this->db->select('*');
      $this->db->from('store_medicine_mata');
     // $this->db->join('store_medicine_mata', 'store_medicine_mata.product_id = purchase_history.mid', 'left'); 
      $this->db->where('product_id', $product_id);
      $this->db->where('Batch_Number', $Batch_Number);
      $this->db->where('supplier_id', $sid);
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;
    }

    public function get_pending($mid, $supp_id, $Batch_Number123)
    {
      $this->db->select('*');
      $this->db->from('store_medicine_mata');
      $this->db->where('product_id', $mid);
      $this->db->where('supplier_id', $supp_id);
      $this->db->where('Batch_Number', $Batch_Number123);
      $this->db->where('status',"0");
      $query = $this->db->get();
      $result = $query->result();
     // echo $this->db->last_query();
      return $result;

    }

    public function get_received($product_id, $supplier_id, $Batch_Number)
    {
      $storeid = $this->session->userdata('store_id');
      $this->db->select_sum('instock');
      $this->db->from('store_medicine_mata');
      $this->db->where('product_id', $product_id);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $Batch_Number);
      $this->db->where('store_id', $storeid);
      
      $this->db->where('status',"1");
      $query = $this->db->get();
      $result = $query->result();
    // echo $this->db->last_query();
     return $result;
    }

    public function get_receivedAllInv($product_id, $supplier_id, $Batch_Number)
    {
      $storeid = $this->session->userdata('store_id');
      $this->db->select_sum('instock');
      $this->db->from('store_medicine_mata');
      $this->db->where('product_id', $product_id);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $Batch_Number);
      //$this->db->where('store_id', $storeid);
      
      $this->db->where('status',"1");
      $query = $this->db->get();
      $result = $query->result();
   //echo  $this->db->last_query();
     return $result;
    }

    public function check_pre_update($product_id, $supplier_id, $Batch_Number, $expire_date)
    {
      $this->db->select('*');
      $this->db->from('store_medicine_mata');
      $this->db->where('product_id', $product_id);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $Batch_Number);
      $this->db->where('expire_date', $expire_date);
      $this->db->where('status',"1");
      $query = $this->db->get();
      $result = $query->result();
     //echo $this->db->last_query();
      return $result;
    }

    public function check_pre_update_zero($product_id, $supplier_id, $Batch_Number, $expire_date)
    {
      $this->db->select('*');
      $this->db->from('store_medicine_mata');
      $this->db->where('product_id', $product_id);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $Batch_Number);
      $this->db->where('expire_date', $expire_date);
      $this->db->where('status',"0");
      $query = $this->db->get();
      $result = $query->result();
     //echo $this->db->last_query();
      return $result;
    }

    public function update_pre_update_zero($pro_id, $supplier_id, $Batch_Number, $expire_date, $data)
    {
      $this->db->where('product_id', $pro_id);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $Batch_Number);
      $this->db->where('expire_date', $expire_date);
      $this->db->where('status', '0');
      $this->db->update('store_medicine_mata', $data);
      return true;
    }

    public function get_medicine_name($product_id)
    {
      $this->db->select('*');
      $this->db->from('medicine');
      $this->db->where('product_id', $product_id);
      $query = $this->db->get();
      $result = $query->result();
     //echo $this->db->last_query();
      return $result;
    }
    public function get_mrp($product_id)
    {
      $this->db->select('*');
      $this->db->from('medicine_mata');
      $this->db->where('product_id', $product_id);
      $query = $this->db->get();
      $result = $query->result();
     //echo $this->db->last_query();
      return $result;
    }

    public function get_mrpSaleReport($product_id,$batchID)
    {
      $this->db->select('*');
      $this->db->from('medicine_mata');
      $this->db->where('product_id', $product_id);
      $this->db->where('Batch_Number', $batchID);
      $query = $this->db->get();
      $result = $query->result();
     //echo $this->db->last_query();
      return $result;
    }

    public function get_gst($hsn)
    {
      $this->db->select('*');
      $this->db->from('gst');
      $this->db->where('hsn_num', $hsn);
      $query = $this->db->get();
      $result = $query->result();
     //echo $this->db->last_query();
      return $result;
    }

    public function add_quanty($mid, $supplier_id, $Batch_Number,$start5,$END5)
    {
      //$this->db->select('SUM(qty) as total_qty');
      $this->db->select('qty');
      $this->db->from('sales_details');
      $this->db->join('sales', 'sales.sale_id = sales_details.sale_id', 'left'); 
      $this->db->where('mid', $mid);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $Batch_Number);
      $this->db->where('create_date >=', $start5);
      $this->db->where('create_date <=', $END5);
      $query = $this->db->get();
      $result = $query->result();
     echo $this->db->last_query();
      return $result;
    }

    public function get_cus_name($c_id)
    {
      $this->db->select('*');
      $this->db->from('customer');
      $this->db->where('c_id', $c_id);
      $query = $this->db->get();
      $result = $query->result();
     //echo $this->db->last_query();
      return $result;
    }
    public function update_stock_request($req_id, $pid, $stock)
    {
      $this->db->where('request_id',$req_id);
      $this->db->where('product_id',$pid);
      $this->db->update('stock_request',$stock);
     //echo $this->db->last_query(); die;
    }


    public function getGrnno($billno,$purid)
    {
      $this->db->select('*');
      $this->db->from('grn');
      $this->db->where('bill_no', $billno);
      $this->db->where('po_no', $purid);
      $query = $this->db->get();
      $result = $query->result();
      //echo $this->db->last_query();
      return $result;
    }
    
    public function getMetagrn($grn,$product,$batch)
    {
      $this->db->select('*');
      $this->db->from('meta_grn');
      $this->db->where('grn_no', $grn);
      $this->db->where('product_id', $product);
      $this->db->where('Batch_Number', $batch);
      $query = $this->db->get();
      $result = $query->result();
      //echo $this->db->last_query();
      return $result;
    }

    public function get_adjus_medicine()
    {
      $this->db->select('*');
      $this->db->from('medicine');
      $this->db->where('instock >', 0);
      $query = $this->db->get();
      $result = $query->result();
     //echo $this->db->last_query();
      return $result;
    }

    public function adjus_medicine($pro_id)
    {
      $this->db->select('*');
      $this->db->from('store_medicine_mata');
      $this->db->where('product_id', $pro_id);
      $this->db->where('instock >', 0);
      $this->db->where('status', 1);
      $query = $this->db->get();
      $result = $query->result();
     //echo $this->db->last_query();
      return $result;
    }

    public function insert_adjus($data)
    {
      $this->db->insert('adjustment_tble', $data);
      $insert_id = $this->db->insert_id();
      return $insert_id;
    }

    public function get_qty($pro_id, $supplier_id, $Batch_Number, $store_id)
    {
      $this->db->select('*');
      $this->db->from('store_medicine_mata');
      $this->db->where('product_id', $pro_id);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $Batch_Number);
      $this->db->where('store_id', $store_id);
      $this->db->where('status', 1);
      $query = $this->db->get();
      $result = $query->result();
     //echo $this->db->last_query();
      return $result;
    }

    public function update_store_med_store_qty($pro_id, $supplier_id, $Batch_Number, $store_id, $data)
    {
      $this->db->where('product_id', $pro_id);
      $this->db->where('supplier_id', $supplier_id);
      $this->db->where('Batch_Number', $Batch_Number);
      $this->db->where('store_id', $store_id);
      $this->db->update('store_medicine_mata', $data);
      return true;

    }

    public function get_qty_med_meta($pro_id, $supplier_id, $Batch_Number)
    {
      $this->db->select('*');
      $this->db->from('medicine_mata');
      $this->db->where('product_id', $pro_id);
      $this->db->where('supplier_id	', $supplier_id);
      $this->db->where('Batch_Number	', $Batch_Number);
      $query = $this->db->get();
      $result = $query->result();
     //echo $this->db->last_query();
      return $result;
    }

    public function Does_dr_exists($drname)
    {
      $this->db->select('*');
      $this->db->from('doctor');
      $this->db->where('name', $drname);
      $query = $this->db->get();
      $result = $query->result();
     //echo $this->db->last_query();
      return $result;
    }
    public function get_alladjus_meddata()
    {
      $this->db->select('*');
      $this->db->from('adjustment_tble');
      $this->db->order_by("id", "desc");
      $query = $this->db->get();
      $result = $query->result();
     //echo $this->db->last_query();
      return $result;
    }

    public function get_medicine_tbl_stock($pro_id)
    {
      $this->db->select('*');
      $this->db->from('medicine');
      $this->db->where('product_id', $pro_id);
      $query = $this->db->get();
      $result = $query->result();
     //echo $this->db->last_query();
      return $result;
    }

    public function update_medicine_tbl($pro_id, $data)
    {
      $this->db->where('product_id', $pro_id);
      $this->db->update('medicine', $data);
      return true;
    }

    public function product_name($pro_id)
    {
      $this->db->select('*');
      $this->db->from('medicine');
      $this->db->where('product_id', $pro_id);
      $query = $this->db->get();
      $result = $query->result();
     //echo $this->db->last_query();
      return $result;
    }

    public function get_store_name($storeid){
    
      $sql = "SELECT `store_name` FROM `store` WHERE `id`='$storeid'";
      $query = $this->db->query($sql);
      $result = $query->row();
      // echo $this->db->last_query();
      return $result;
  }

  public function select_unit()
  {
    $this->db->select('*');
    $this->db->from('units');
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }

  public function med_detail($pro_id)
  {
    $this->db->select('*');
    $this->db->from('medicine');
    $this->db->where('product_id', $pro_id);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }

  public function select_unitformbyId($fid)
  {
    $this->db->select('*');
    $this->db->from('units');
    $this->db->where('form', $fid);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }
  public function check_med_form($medicine)
  {
    $this->db->select('*');
    $this->db->from('medicine');
    $this->db->where('product_id', $medicine);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }
  

}
?>