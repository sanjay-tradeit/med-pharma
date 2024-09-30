<?php

	class Supplier_model extends CI_Model{
	function __consturct(){

	parent::__construct();
	}


    public function checksuppliergst($gst){
        $this->db->select('s_id');
        $this->db->from('supplier');
        $this->db->where('s_gst', $gst);
        $query = $this->db->get();
        $result = $query->result();
        //echo ($this->db->last_query());
        return $result;
		
	}
    public function checksuppliername($supname){
        $this->db->select('s_name');
        $this->db->from('supplier');
        $this->db->where('s_name', $supname);
        $query = $this->db->get();
        $result = $query->result();
        //echo ($this->db->last_query());
        return $result;
		
	}
    public function checkmedname($medname){
        $this->db->select('product_name');
        $this->db->from('medicine');
        $this->db->where('product_name', $medname);
        $query = $this->db->get();
        $result = $query->result();
        //echo ($this->db->last_query());
        return $result;
		
	}
    
    public function checkempname($supname){
        $this->db->select('em_name');
        $this->db->from('user');
        $this->db->where('em_name', $supname);
        $query = $this->db->get();
        $result = $query->result();
        //echo ($this->db->last_query());
        return $result;
		
	}
    public function Add_Supplier_info($data){
		$this->db->insert('supplier',$data);
	}
    public function Save_BANK($data){
		$this->db->insert('bank',$data);
	}
    public function Create_Supplier_balance($data){
		$this->db->insert('supplier_ledger',$data);
	}
    public function getAllSupplier(){
        
        $sql = "SELECT * FROM `supplier` ORDER BY `s_name` ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }  
    public function getallmanufacturer(){
        
        $sql = "SELECT * FROM `manufacturer`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }  
    public function getallgstnumbers(){
        
        $sql = "SELECT * FROM `supplier`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    } 
    // public function getAllSupplier()
    // {
    //   $this->db->select('*');
    //   $this->db->from('supplier');
    //   $this->db->where('status', "Active");
    //   $query = $this->db->get();
    //   $result = $query->result();
    //   echo ($this->db->last_query());
    //  // return $return;
    // }

    public function DeleteSupplierID($id){
        $this->db->delete('supplier', array('id' => $id));
    }    

    public function GetSupplierValueById($id){
        $sql = "SELECT * FROM `supplier` WHERE `supplier`.`s_id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
       // echo $this->db->last_query();
        return $result;
    }    

    public function GetSupplierMBySID($id){
        $sql = "SELECT `medicine`.product_id,`medicine`.product_name,`medicine`.product_image,`medicine`.strength,`medicine`.generic_name,`medicine`.form,`medicine_mata`.expire_date,`medicine_mata`.instock,`medicine_mata`.mrp,`medicine_mata`.purchase_rate,`medicine_mata`.Batch_Number,`medicine`.instock FROM `medicine_mata`  LEFT JOIN `medicine` ON `medicine_mata`.`product_id`=`medicine`.`product_id`WHERE `medicine_mata`.`supplier_id`='$id'";
        
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }     

    public function GETSUPPLIERPURCHASEBALANCE($pid){
        $sql = "SELECT * FROM `supp_account` WHERE `supp_account`.`pur_id`='$pid'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }        

    public function Getsupplierbalance($supplier){
        $sql = "SELECT * FROM `supplier_ledger` WHERE `supplier_ledger`.`supplier_id`='$supplier'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }    
    public function Does_supplier_email_exists($email,$phone){
		$user = $this->db->dbprefix('supplier');
        $sql = "SELECT `s_email`,`s_phone` FROM $user
		WHERE `s_email`='$email' OR `s_phone`='$phone'";
		$result=$this->db->query($sql);
        if ($result->row()) {
            return $result->row();
        } else {
            return false;
        }
    }
    public function Update_Supplier_info($id,$data){
        $this->db->where('s_id',$id);
        $this->db->update('supplier',$data);
    }
    public function update_Supplier_balance($supplier,$data){
        $this->db->where('supplier_id',$supplier);
        $this->db->update('supplier_ledger',$data);
    }
    public function update_Supplier_balance1($supplier,$data){
        $this->db->where('supplier_id',$supplier);
        $this->db->update('supplier_ledger',$data);
    }
    public function getAllSupplierBalance(){
        $this->db->select('*');
        $this->db->from('supplier_ledger');
        $this->db->join('supplier', 'supplier_ledger.supplier_id = supplier.s_id', 'left'); 
        $this->db->order_by('supplier_ledger.id', 'desc'); 
        $query = $this->db->get();
        $result = $query->result();
        return $result;
        // $sql = "SELECT `supplier_ledger`.*,
        // `supplier`.`s_name`
        // FROM `supplier_ledger`
        // LEFT JOIN `supplier` ON `supplier_ledger`.`supplier_id`=`supplier`.`s_id`";
        // $query = $this->db->query($sql);
        // $result = $query->result();
        // return $result;        
    }
    public function GetSupplierDuesValueById($id){
        // $this->db->select('*');
        // $this->db->from('supp_account');
        // $this->db->join('supplier', 'supplier.s_id = supp_account.supplier_id', 'left'); 
        // $this->db->join('purchase', 'supp_account.pur_id = purchase.p_id', 'left'); 
        // $query = $this->db->get();
        // $result = $query->result();
        // echo $this->db->last_query();
        // return $result;
        // $sql = "SELECT `supp_account`.*,
        // `purchase`.`invoice_no`,`pur_date`,
        // `supplier`.`s_name`
        // FROM `supp_account`
        // LEFT JOIN `supplier` ON `supp_account`.`supplier_id`=`supplier`.`s_id`
        // LEFT JOIN `purchase` ON `supp_account`.`pur_id`=`purchase`.`p_id`
        // WHERE `supp_account`.`supplier_id`='$id' AND `supp_account`.`due_amount` > '0'";
        // $query = $this->db->query($sql);
        // $result = $query->result();
        // echo $this->db->last_query();
        // return $result; 
        $sql = "SELECT `supp_account`.*,
        `purchase`.`invoice_no`,`pur_date`,
        `supplier`.`s_name`
        FROM `supp_account`
        LEFT JOIN `supplier` ON `supp_account`.`supplier_id`=`supplier`.`s_id`
        LEFT JOIN `purchase` ON `supp_account`.`pur_id`=`purchase`.`p_id`
        WHERE `supp_account`.`supplier_id`='$id' ";
        $query = $this->db->query($sql);
        $result = $query->result();
       
       return $result;         
    } 
    public function GetSupplierInvoiceValueById($id){
        $sql = "SELECT `supp_account`.*,
        `purchase`.`invoice_no`,`pur_date`,
        `supplier`.`s_name`
        FROM `supp_account`
        LEFT JOIN `supplier` ON `supp_account`.`supplier_id`=`supplier`.`s_id`
        LEFT JOIN `purchase` ON `supp_account`.`pur_id`=`purchase`.`p_id`
        WHERE `supp_account`.`supplier_id`='$id' AND `supp_account`.`due_amount` = '0'";
        $query = $this->db->query($sql);
        $result = $query->result();
      
        return $result;        
    } 
    public function GetSupplierPaymentValueById($id){
        // $this->db->select('*');
        // $this->db->from('purchase');
        // $this->db->join('supp_account', 'supp_account.supplier_id = purchase.p_id', 'left'); 
        // $this->db->join('supplier', 'supplier.s_id = purchase.sid', 'left'); 
        //  $this->db->where('purchase.p_id', $id);
        // $query = $this->db->get();
        // $result =  $query->result();
        // echo $this->db->last_query();
        // return $result;


        $sql = "SELECT `supp_account`.*,
        `purchase`.`invoice_no`,`pur_date`,
        `supplier`.`s_name`,`supplier`.`s_address`,`supplier`.`s_email`,`supplier`.`s_phone`,`supplier`.`s_gst`
        FROM `supp_account`
        LEFT JOIN `supplier` ON `supp_account`.`supplier_id`=`supplier`.`s_id`
        LEFT JOIN `purchase` ON `supp_account`.`pur_id`=`purchase`.`p_id`
        WHERE `purchase`.`p_id`='$id'";       
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;        
    }  
    
    
    public function GetSupplierAllPayment($pid){
        $sql = "SELECT `supp_payment`.*,
        `bank`.`bank_name`
        FROM `supp_payment`
        LEFT JOIN `bank` ON `supp_payment`.`bank_id`=`bank`.`bank_id`
        WHERE `supp_payment`.`pur_id`='$pid'";
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;        
    }  
    
    public function all_payment()
    {
        $this->db->select('*');
        $this->db->from('accounts_report');
        $this->db->order_by('created_at', 'desc'); 
        $query = $this->db->get();
        $result = $query->result();
       // echo $this->db->last_query();
        return $result;
    }



    public function GetSupplierbyname($name){
        $sql = "SELECT `s_id` FROM `supplier` WHERE `supplier`.`s_name`='$name'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getAllStore(){
        
        $sql = "SELECT * FROM `store`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    } 

    public function get_grn_data($grn_no)
    {
       $this->db->select('*');
       $this->db->from('grn');
       $this->db->where('grn_no', $grn_no);
       $query = $this->db->get();
       $result = $query->result();
       //$this->db->last_query();
       return $result;

    }

    public function get_dis($pur_id)    
    {
        $this->db->select('SUM(discount) as dis');
        $this->db->from('purchase_history');
        $this->db->where('pur_id', $pur_id);
        $query = $this->db->get();
        $result = $query->result();
        // echo $this->db->last_query();
        return $result;
    }
    

    public function add_supp_account($data2){
		
     $this->db->insert('supp_account',$data2);
     $insert_id = $this->db->insert_id();
     return $insert_id;
	}

    public function add_supp_payment($data)
    {
        $this->db->insert('supp_payment', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function getmedicinewithstoremedicine($branchnaid){
        $sql = "SELECT `store_medicine_mata`.`product_id`,`instock`
        FROM `store_medicine_mata`
        WHERE `store_medicine_mata`.`store_id`='$branchnaid'";
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;        
    }

    public function getmedicinenamewithproid($product_id){
        $sql = "SELECT `product_name`
        FROM `medicine`
        WHERE `medicine`.`product_id`='$product_id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;        
    }

    public function GetsupplierAccbalance($purid)
    {
            $sql = "SELECT *
            FROM `supp_account`
            WHERE `supp_account`.`pur_id`='$purid'";
            $query = $this->db->query($sql);
            $result = $query->result();
            //echo $this->db->last_query();
            return $result;   
    }

    public function Getsupplieramount($purid,$from)
    {
            $from = 'purchase';
            $sql = "SELECT *
            FROM `supp_payment`
            WHERE `supp_payment`.`pur_id`='$purid' AND `supp_payment`.`from`='$from' ";
            $query = $this->db->query($sql);
            $result = $query->result();
            echo $this->db->last_query();
            return $result;   
    }
   
    public function GetsupplierAccbalance1($purid)
    {
            $sql = "SELECT *
            FROM `supp_account`
            WHERE `supp_account`.`pur_id`='$purid' AND `supp_account`.`from`='purchase'";
            $query = $this->db->query($sql);
            $result = $query->result();
            //echo $this->db->last_query();
            return $result;   
    }
    
 

}

?>