<?php

	class User_model extends CI_Model{


	function __consturct(){
	parent::__construct();
	
	}
    public function Add_user_info($data){
		$this->db->insert('user',$data);
	}
    public function insertSPAYMENT($data){
		$this->db->insert('supp_account',$data);
	}
    public function Save_Closing($data){
		$this->db->insert('closing',$data);
	}
    public function insertPAYMENT($data){
		$this->db->insert('accounts_report',$data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
	}
    public function getAllUser(){
        $sql = "SELECT * FROM `user` ORDER BY `em_name` ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getAllUserforstore($id){
        $sql = "SELECT * FROM `user` WHERE `user`.`store` = '$id' ORDER BY `em_name` ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getAllRoles(){
        $sql = "SELECT * FROM `roles` ORDER BY `title` ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getAllpermissionsModules(){
        $sql = "SELECT `role_permissions`.`module` FROM `role_permissions` GROUP BY `role_permissions`.`module`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getAllpermissionsbyModule($module){
        $sql = "SELECT `role_permissions`.`id`,`role_permissions`.`title` FROM `role_permissions` WHERE `role_permissions`.`module`='$module'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function GetEmployeeValueById($id){
        $sql = "SELECT * FROM `user` WHERE `em_id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function GetpermissionsByid($id){
        $sql = "SELECT * FROM `roles` WHERE `id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function GetAccountBalance(){
        $sql = "SELECT * FROM `accounts`";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function Getbankinfowithsupplier(){
        $sql = "SELECT * FROM `bank`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function Update_user_info($id,$data){
        $this->db->where('em_id',$id);
        $this->db->update('user',$data);
    } 
    public function UPDATE_ACCOUNT($id,$data){
        $this->db->where('id',$id);
        $this->db->update('accounts',$data);
    } 
    public function UPDATEsPAYMENT($supplier,$data){
        $this->db->where('supplier_id',$supplier);
        $this->db->update('supplier_ledger',$data);
    } 
    public function Reset_Password($id,$data){
        $this->db->where('em_id',$id);
        $this->db->update('user',$data);
        return TRUE;
    }  
    
    public function getRoledatabyid($id){
        $sql = "SELECT * FROM `roles` WHERE `roles`.`id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function Update_permissionsinroles($roleid,$data){
        $this->db->where('id',$roleid);
        $this->db->update('roles',$data);
        //echo $this->db->Last_query();
        return TRUE;
    }  
    

    public function delete_emp($id)
    {
    $this->db->where('id', $id);
    $this->db->delete('user');
    return TRUE;
    }
    public function delete_role($id)
    {
    $this->db->where('id', $id);
    $this->db->delete('roles');
    return TRUE;
    }

    public function get_stores()
    {
        $this->db->select('*');
        $this->db->from('store'); 
        $this->db->order_by("store_name", "asc");    
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function get_all_stores()
    {
        $this->db->select('*');
        $this->db->from('store'); 
       // $this->db->where('id !=', 78);    
        $query = $this->db->get();
        $result = $query->result();

        $key = array();
        $value = array();
        foreach($result as $data){

            $key[] = $data->id;
            $value[] = $data->store_name;

        }
        $fnalArray = array_combine($key,$value);


        return $fnalArray ;
    }
   
    public function get_tranfer_inventory()
    {
        $this->db->select('*');
        $this->db->from('stock_transfer');
       // $this->db->join('stock_transfer', 'stock_transfer.stock_transfer_id = stock_transfer_history.stock_transfer_id', 'left'); 
        $this->db->order_by("stock_transfer.id", "desc");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
     public function get_store_name($store_id)
     {
        $this->db->select('*');
        $this->db->from('store');
        $this->db->where('id', $store_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
     }

     public function get_transfer_history($stock_transfer_id)
     {
        $this->db->select('*');
        $this->db->from('stock_transfer_history');
        $this->db->where('stock_transfer_id', $stock_transfer_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
     }

     public function get_req_his($req)
     {
        $this->db->select('*');
        $this->db->from('stock_request');
        $this->db->where('request_id', $req);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
     }


     
     public function get_req_store($request_id)
     {
        $this->db->select('*');
        $this->db->from('reverse_stock');
        $this->db->where('request_id', $request_id);
        $this->db->join('supplier', 'reverse_stock.supplier_id = supplier.s_id', 'left');
        $this->db->join('medicine', 'reverse_stock.product_id = medicine.product_id', 'left'); 
        $query = $this->db->get();
        $result = $query->result();
        return $result;
     }

     public function get_prduct_name($product_id)
     {
        $this->db->select('product_name');
        $this->db->from('medicine');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
     }
     public function supplier_name($s_id)
     {
        $this->db->select('s_name');
        $this->db->from('supplier');
        $this->db->where('s_id', $s_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result; 
     }

     public function get_store_id($store_id)
     {
        $this->db->select('id');
        $this->db->from('store');
        $this->db->where('store_id', $store_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result; 
     }

     public function Add_permissionsinroles($data){
		$this->db->insert('roles',$data);
        //echo $this->db->last_query();
	}
    
    public function getAllpermissionsbyemid($id){
        $sql = "SELECT `roles`.`permissions` FROM `roles` WHERE `roles`.`id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;
    }
    public function GetEmployeerolenameByid($id){
        $sql = "SELECT * FROM `roles` WHERE `id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        //echo $this->db->last_query();
        return $result;
    }


        
}
?>