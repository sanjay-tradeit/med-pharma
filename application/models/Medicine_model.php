<?php
	class Medicine_model extends CI_Model{
	function __consturct(){
	parent::__construct();
	}

    public function Add_medicine_info($data){

		$this->db->insert('medicine',$data);
       // echo $this->db->last_query();
        $insert_id = $this->db->insert_id();
        return $insert_id;

	}

    public function getAllCompany(){
        $sql = "SELECT * FROM `company` ORDER BY 'id' DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getAllunits(){
        $sql = "SELECT * FROM `units` ORDER BY 'id' DESC";//"SELECT * FROM `units` GROUP BY form ORDER BY form asc;";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    
    public function getAllunitsForm(){
        $sql = "SELECT * FROM `unit_form` GROUP BY title ORDER BY title asc;";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getAllunitsFormID($ID){
        $sql = "SELECT * FROM `units` WHERE `form` = '$ID';";           //  ORDER BY unit asc
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;
    }
    public function getAllunitsFormID2($ID){
        $sql = "SELECT * FROM `units` WHERE `id` = '$ID';";           //  ORDER BY unit asc
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;
    }
    
    public function getformbyid($id){
        $sql = "SELECT * FROM `unit_form` WHERE `unit_form`.`id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;
    }

     public function getformtitle($id){
        $sql = "SELECT * FROM `unit_form` WHERE `unit_form`.`id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;
    }

    // public function getformbyid1($id){
    //     $sql = "SELECT * FROM `units` WHERE `units`.`id`='$id'";
    //     $query = $this->db->query($sql);
    //     $result = $query->result();
    //     //echo $this->db->last_query();
    //     return $result;
    // }

    public function GetunitBynum($id){
        $sql = "SELECT * FROM `units` WHERE `units`.`id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function GetsubunitBynum($id){
        $sql = "SELECT * FROM `units` WHERE `units`.`form`='$id'";
        $query = $this->db->query($sql);
        //$result = $query->row();
        $result = $query->result();
        return $result;
    }

    public function update_unit($id, $data){
        $this->db->where('id', $id);
        $this->db->update('units', $data);
        return true;
      }

      public function delete_unit($id)
        {
        $this->db->where('id', $id);
        $this->db->delete('units');
        return TRUE;
        }
    public function getAllSuperMedicine(){
        $today = date("Y-m-d");
        $store_id = $this->session->userdata('store_id');
        $sql = "SELECT `medicine`.product_name,`medicine`.strength,`medicine`.instock, `sales_details`.mid,COUNT(mid),`sales_details`.mid,SUM(qty) AS totinstock FROM `sales_details` LEFT JOIN `medicine` ON `sales_details`.`mid`=`medicine`.`product_id`  WHERE `sales_details`.sale_date = '$today' &&  `sales_details`.store_id = $store_id  GROUP BY mid HAVING COUNT(mid) > 0 ORDER by COUNT(mid) DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;
    }
    
    public function GetexpiredMedicine($today){
        
        if($this->session->userdata('em_type') =='substore'){ 
            $today = date("Y-m-d");
            $storeID = $this->session->userdata('store_id');
            $this->db->select('*');
            $this->db->from('store_medicine_mata');
            $this->db->where('expire_date<=', $today);
            $this->db->where('store_id=', $storeID);
            $this->db->where('store_medicine_mata.status', 1);
            $this->db->join('supplier', 'store_medicine_mata.supplier_id = supplier.s_id', 'left');
            $this->db->join('medicine', 'store_medicine_mata.product_id = medicine.product_id', 'left'); 
            $query = $this->db->get();
            $result = $query->result();
            //echo $this->db->last_query();
           
            return $result;
        }
        else{
        $sql = "SELECT `medicine_mata`.*,
        `supplier`.`s_id`,`s_name`,`medicine`.`product_name`,`medicine`.`generic_name`,`medicine`.`strength`
        FROM `medicine_mata`
        LEFT JOIN `supplier` ON `medicine_mata`.`supplier_id`=`supplier`.`s_id`
        LEFT JOIN `medicine` ON `medicine_mata`.`product_id`=`medicine`.`product_id`  
        WHERE DATE_FORMAT(STR_TO_DATE(`expire_date`, '%Y-%m-%d'), '%Y-%m-%d') <= '$today' and `medicine_mata`.`status` = 1";
       
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
       return $result;
    } 
}
    public function Getshortproduct(){

        if($this->session->userdata('em_type') =='substore'){ 
            $status = '1';
            $storeID = $this->session->userdata('store_id');            
            $this->db->select('*');
            $this->db->from('store_medicine_mata');
            $this->db->where('store_id', $storeID);
            $this->db->join('supplier', 'store_medicine_mata.supplier_id = supplier.s_id', 'left');
            $this->db->join('medicine', 'store_medicine_mata.product_id = medicine.product_id', 'left');
            $this->db->where('store_medicine_mata.instock < medicine.storeshort_stock');
            $this->db->where('store_medicine_mata.status' , $status);

            $query = $this->db->get();
            $result = $query->result();
            //echo $this->db->last_query();
           
            return $result;
        }
        else{


        $sql = "SELECT `medicine_mata`.*,
        `supplier`.`s_id`,`s_name`,`medicine`.`product_name`,`medicine`.`generic_name`,`medicine`.`strength`, `medicine`.`product_image`
        FROM `medicine_mata`
        LEFT JOIN `supplier` ON `medicine_mata`.`supplier_id`=`supplier`.`s_id`
        LEFT JOIN `medicine` ON `medicine_mata`.`product_id`=`medicine`.`product_id`
        WHERE `medicine_mata`.`instock` <= 50 and  `medicine_mata`.`status` =1";
        $query = $this->db->query($sql);
        $result = $query->result();
        // echo $this->db->last_query();
        // die;
        return $result;
    }
}
    


    public function GetStockExpiresoonproduct($today,$month){

        // $today = date("Y-m-d", strtotime($today));
       // $month = date("Y-m-d", strtotime($month));
        $month = date("Y-m-d", strtotime("+1 month", strtotime($today)));
        if($this->session->userdata('em_type') =='substore'){ 

            $storeID = $this->session->userdata('store_id');
            $this->db->select('medicine.product_name, medicine.generic_name, medicine.strength, supplier.s_name, medicine_mata.instock, medicine_mata.Batch_Number, medicine_mata.expire_date');
            $this->db->from('store_medicine_mata');
            $this->db->where('store_medicine_mata.expire_date>=', $today);
            $this->db->where('store_medicine_mata.expire_date!=', $today);
            $this->db->where('store_medicine_mata.expire_date<=', $month);
            $this->db->where('store_id=', $storeID);
            $this->db->where('store_medicine_mata.status', 1);
            $this->db->join('supplier', 'store_medicine_mata.supplier_id = supplier.s_id', 'left');
            $this->db->join('medicine', 'store_medicine_mata.product_id = medicine.product_id', 'left'); 
            $this->db->join('medicine_mata', 'store_medicine_mata.supplier_id = medicine_mata.supplier_id', 'left');
            $query = $this->db->get();
            $result = $query->result();
            //echo $this->db->last_query();
            return $result;
        }
        else{

          $this->db->select('medicine.product_name, medicine.generic_name, medicine.strength, supplier.s_name, medicine_mata.instock, medicine_mata.Batch_Number, medicine_mata.expire_date');
          $this->db->from('medicine_mata');
          $this->db->where('expire_date>=', $today);
          $this->db->where('expire_date!=', $today);
          $this->db->where('expire_date<=', $month);
          $this->db->where('medicine_mata.status', 1);
          $this->db->join('supplier', 'medicine_mata.supplier_id = supplier.s_id', 'left');
          $this->db->join('medicine', 'medicine_mata.product_id = medicine.product_id', 'left'); 
          $query = $this->db->get();
          $result = $query->result();
         // echo $this->db->last_query();
          return $result;
    }
}







    public function GetStockVal(){
        if($this->session->userdata('em_type') =='substore'){ 
            $storeID = $this->session->userdata('store_id');
            $sql = "SELECT `store_medicine_mata`.*,
        `supplier`.`s_id`,`s_name`,`medicine`.`product_name`,`medicine`.`generic_name`,`medicine`.`strength`
        FROM `store_medicine_mata`
        LEFT JOIN `supplier` ON `store_medicine_mata`.`supplier_id`=`supplier`.`s_id`
        LEFT JOIN `medicine` ON `store_medicine_mata`.`product_id`=`medicine`.`product_id`
        WHERE `store_medicine_mata`.`store_id`='$storeID'   order by `medicine`.`product_name` asc";

        }else{

            $sql = "SELECT `medicine_mata`.*,
            `supplier`.`s_id`,`s_name`,`medicine`.`product_name`,`medicine`.`generic_name`,`medicine`.`strength`
            FROM `medicine_mata`
            LEFT JOIN `supplier` ON `medicine_mata`.`supplier_id`=`supplier`.`s_id`
            LEFT JOIN `medicine` ON `medicine_mata`.`product_id`=`medicine`.`product_id` where `medicine_mata`.`status`='1' order by `medicine`.`product_name` asc";

        }
        $query = $this->db->query($sql);
        $result = $query->result();
      // echo $this->db->last_query();
        return $result;
    }

    public function GetStockOutproduct(){
        $sql = "SELECT `medicine_mata`.*,
        `supplier`.`s_id`,`s_name`,`medicine`.`product_name`,`medicine`.`generic_name`,`medicine`.`strength`
        FROM `medicine_mata`
        LEFT JOIN `supplier` ON `medicine_mata`.`supplier_id`=`supplier`.`s_id`
        LEFT JOIN `medicine` ON `medicine_mata`.`product_id`=`medicine`.`product_id`
         
        WHERE `medicine_mata`.`instock`<='0' and `medicine_mata`.`instock`= 1 order by `medicine`.`product_name` asc";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    } 

  

    

    public function getAllMedicine(){
        $this->db->select('*');
        $this->db->from('medicine');
        $this->db->join('manufacturer', 'medicine.manufacturer_id = manufacturer.manufac_id	', 'left');
         $this->db->order_by('medicine.product_name', 'ASC'); 
        $query = $this->db->get();
        $result= $query->result();
        return $result;
    // $sql = "SELECT `medicine`.*,
    //   `supplier`.`s_id`,`s_name`
    //   FROM `medicine`
    //   LEFT JOIN `supplier` ON `medicine`.`supplier_id`=`supplier`.`s_id`
    //   ORDER BY `medicine`.`product_name` ASC";
    //     $query = $this->db->query($sql);
    //     $result = $query->result();
    //     return $result;
    } 

    public function GetMedicineValueById($id){
        $sql = "SELECT * FROM `medicine` WHERE `medicine`.`product_id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function GetMedicineValueById1($mid){
        $this->db->select('*');
        $this->db->from('medicine');
        $this->db->where('product_id=', $mid); 
        $query = $this->db->get();
        $result= $query->result();
        return $result;
 
    } 
    public function GetSupplierValueById($id){
        $sql = "SELECT * FROM `supplier` WHERE `supplier`.`s_id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function GetMedicineValueId($purid){
        $sql = "SELECT * FROM `medicine` WHERE `medicine`.`product_id`='$purid'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    
    public function GetManufacturerValueById($manufacturerID){
        $sql = "SELECT `m_name` FROM `manufacturer` WHERE `manufacturer`.`manufac_id`='$manufacturerID'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    } 

    public function getSupplierMedicine($id){

        $this->db->select('*');
        $this->db->from('medicine');
       // $this->db->join('medicine_mata', 'medicine.product_id = medicine_mata.product_id', 'left');
        $this->db->where('medicine.product_id', $id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getMedicinesubForm($id){

        $this->db->select('subform');
        $this->db->from('medicine');
       // $this->db->join('medicine_mata', 'medicine.product_id = medicine_mata.product_id', 'left');
        $this->db->where('medicine.product_id', $id);
        $query = $this->db->get();
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;
    }
    public function subformUnit($id){

        $this->db->select('*');
        $this->db->from('units');
       // $this->db->join('medicine_mata', 'medicine.product_id = medicine_mata.product_id', 'left');
        $this->db->where('units.id', $id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    
    public function getMedicineBymedicineId($id){
        $sql = "SELECT * FROM `medicine` WHERE `medicine`.`product_id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }    
    public function Update_medicine_info($id,$udata){
            $this->db->where('product_id',$id);
            $this->db->update('medicine',$udata);
           // echo $this->db->last_query();
            return true;
    }
   
    public function get_hsn_data($hsn_num)
    {
        $this->db->select('*');
        $this->db->from('gst');
        $this->db->where('hsn_num', $hsn_num);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function delete_medicine($product_id)
    {
        $this->db->where('product_id', $product_id);
        $this->db->delete('medicine');
        return true;
    }

    public function get_medicine_by_id($id)
    {
        $sql = "SELECT * FROM `medicine` WHERE `medicine`.`id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result; 
    }

    public function get_manufacturer()
    {
        $this->db->select('*');
        $this->db->from('manufacturer');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_supplierlist()
    {
        $this->db->select('*');
        $this->db->from('supplier');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    // public function checkmedicinename($medicinename)
    // {
    //     $sql = "SELECT * FROM `medicine` WHERE `medicine`.`generic_name`='$medicinename'";
    //     $query = $this->db->query($sql);
    //     $result = $query->result();
    //     return true; 
   
    // }

    public function GetMedicinebyname($name)
    {
        $sql = "SELECT `id` FROM `medicine` WHERE `medicine`.`product_name`='$name'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function get_medicine()
    {
        $this->db->select('*');
        $this->db->from('medicine');
        $this->db->order_by('product_name', 'asc');
        $this->db->join('store_medicine_mata', 'store_medicine_mata.product_id = medicine.product_id', 'left');
        //$this->db->join('store_medicine_mata', 'store_medicine_mata.product_id = medicine.product_id');
        $this->db->group_by('store_medicine_mata.product_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_store()
    {
         $this->db->select('*');
        $this->db->from('store');
        $this->db->where('id !=',  78);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
   
    public function getStockstoreVal($storeID){

        $storeID = $this->session->userdata('store_id');
        
        $sql = "SELECT `store_medicine_mata`.*, `supplier`.`s_id`, `s_name`, `medicine`.`product_name`, `medicine`.`generic_name`, `medicine`.`strength`
        FROM `store_medicine_mata`
        LEFT JOIN `supplier` ON `store_medicine_mata`.`supplier_id` = `supplier`.`s_id`
        LEFT JOIN `medicine` ON `store_medicine_mata`.`product_id` = `medicine`.`product_id`
        WHERE `store_medicine_mata`.`store_id` = '$storeID' AND `store_medicine_mata`.`status` = '1'
        GROUP BY `store_medicine_mata`.`product_id`
        ORDER BY `medicine`.`product_name` ASC";
      
        $query = $this->db->query($sql);
        
        $result = $query->result();
       
        return $result;

          }

          public function getstoreShortProduct($storeID){
            if($this->session->userdata('em_type') =='admin'){
            $storeID = $this->session->userdata('store_id');
            $sql = "SELECT `store_medicine_mata`.*,
            `supplier`.`s_id`,`s_name`,`medicine`.`product_name`,`medicine`.`generic_name`,`medicine`.`strength`,`medicine`.`storeshort_stock`
            FROM `store_medicine_mata`
            LEFT JOIN `supplier` ON `store_medicine_mata`.`supplier_id`=`supplier`.`s_id`
            LEFT JOIN `medicine` ON `store_medicine_mata`.`product_id`=`medicine`.`product_id`            
            WHERE `medicine`.`storeshort_stock` >= `store_medicine_mata`.`instock` AND  `store_medicine_mata`.`store_id`='$storeID' AND `store_medicine_mata`.`status` = '1' order by `medicine`.`product_name` asc";
            $query = $this->db->query($sql);
            $result = $query->result();
            //echo $this->db->last_query();
            return $result;
        }
        else{

            $storeID = $this->session->userdata('store_id');
            $sql = "SELECT `store_medicine_mata`.*,
            `supplier`.`s_id`,`s_name`,`medicine`.`product_name`,`medicine`.`generic_name`,`medicine`.`strength`
            FROM `store_medicine_mata`
            LEFT JOIN `supplier` ON `store_medicine_mata`.`supplier_id`=`supplier`.`s_id`
            LEFT JOIN `medicine` ON `store_medicine_mata`.`product_id`=`medicine`.`product_id`            
            WHERE `medicine`.`storeshort_stock` >= `store_medicine_mata`.`instock` AND  `store_medicine_mata`.`store_id`='$storeID' AND `store_medicine_mata`.`status` = '1' order by `medicine`.`product_name` asc";
            $query = $this->db->query($sql);
            $result = $query->result();
            return $result;

        }
    }

        public function GetStockOutstoreproduct(){
            $storeID = $this->session->userdata('store_id');
            $sql = "SELECT `store_medicine_mata`.*,
            `supplier`.`s_id`,`s_name`,`medicine`.`product_name`,`medicine`.`generic_name`,`medicine`.`strength`
            FROM `store_medicine_mata`
            LEFT JOIN `supplier` ON `store_medicine_mata`.`supplier_id`=`supplier`.`s_id`
            LEFT JOIN `medicine` ON `store_medicine_mata`.`product_id`=`medicine`.`product_id`            
            WHERE `store_medicine_mata`.`instock`<='0' AND  `store_medicine_mata`.`store_id`='$storeID' AND `store_medicine_mata`.`status` = '1' order by `medicine`.`product_name` asc";
            $query = $this->db->query($sql);
            $result = $query->result();
            return $result;
        } 
        

        public function getStockExpiresoonstoreProduct($today,$month){

            // $today = date("Y-m-d", strtotime($today));
           // $month = date("Y-m-d", strtotime($month));
            $month = date("Y-m-d", strtotime("+1 month", strtotime($today)));
            
    
                $storeID = $this->session->userdata('store_id');
                $this->db->select('medicine.product_name, medicine.generic_name, medicine.strength, supplier.s_name, store_medicine_mata.instock, store_medicine_mata.Batch_Number, store_medicine_mata.expire_date');
                $this->db->from('store_medicine_mata');
                $this->db->where('expire_date>=', $today);
                $this->db->where('expire_date<=', $month);
                $this->db->where('store_id=', $storeID);
                $this->db->where('store_medicine_mata.status', '1');
                $this->db->join('supplier', 'store_medicine_mata.supplier_id = supplier.s_id', 'left');
                $this->db->join('medicine', 'store_medicine_mata.product_id = medicine.product_id', 'left'); 
                $query = $this->db->get();
                $result = $query->result();
                //echo $this->db->last_query();
               
                return $result;
            }

            public function GetpermissionsByid1($id){
                $sql = "SELECT * FROM `roles` WHERE `id`='$id'";
                $query = $this->db->query($sql);
                $result = $query->result();
                return $result;
            }
        
 
        public function GetexpiredstoreMedicine($today){
                $today = date("Y-m-d");
                $storeID = $this->session->userdata('store_id');
                $this->db->select('medicine.product_name, medicine.generic_name, medicine.strength, supplier.s_name, store_medicine_mata.instock, store_medicine_mata.Batch_Number, store_medicine_mata.expire_date');
                $this->db->from('store_medicine_mata');
                $this->db->where('expire_date<=', $today);
                $this->db->where('store_id=', $storeID);
                $this->db->where('store_medicine_mata.status', '1');
                $this->db->join('supplier', 'store_medicine_mata.supplier_id = supplier.s_id', 'left');
                $this->db->join('medicine', 'store_medicine_mata.product_id = medicine.product_id', 'left'); 
                $query = $this->db->get();
                $result = $query->result();
                // echo $this->db->last_query();
                return $result;
            }



            public function GetrequestStock()
            {
            $this->db->select('*');
            $this->db->from('stock_request');
            $this->db->group_by('request_id');
            $this->db->order_by("id", "desc");
            $query = $this->db->get();
            $result = $query->result();
            return $result;
            }

            public function get_generic($product_id)
            {
                $this->db->select('generic_name');
                $this->db->from('medicine');
                $this->db->where('product_id', $product_id);
                $query = $this->db->get();
                $result = $query->result();
                return $result;
            }

            public function get_med_data()
            {                
                $sql = "SELECT `store_medicine_mata`.*
                FROM `store_medicine_mata`";
                $query = $this->db->query($sql);
                $result = $query->result();
                //echo $this->db->last_query(); 
                return $result; 
            }
            

      

            public function get_stock($pro_id, $supplier_id, $batch, $date)
            {
                $this->db->select('SUM(qty) AS total_qty, mid, 	supplier_id, Batch_Number, qty, rate, supp_rate, total_price, total_tax, grand_total');
                // $this->db->select('*');
                $this->db->from('sales_details');
                $this->db->where('mid', $pro_id);
                $this->db->where('supplier_id', $supplier_id);    
                $this->db->where('Batch_Number', $batch);
                $this->db->where('sale_date', $date);
                $query = $this->db->get();
                $result = $query->result();
               // echo $this->db->last_query(); 
                return $result;   
            }

            public function insert_closing_stock($data)
            {
                $this->db->insert('closing_tble', $data);
                $insert_id = $this->db->insert_id();
                return $insert_id;
            }

            public function get_purchase_rate($pro_id, $supplier_id, $batch)
            {
                $this->db->select('*');
                // $this->db->select('*');
                $this->db->from('medicine_mata');
                $this->db->where('product_id', $pro_id);
                $this->db->where('supplier_id', $supplier_id);
                $this->db->where('Batch_Number', $batch);
                $query = $this->db->get();
                $result = $query->result();
               // echo $this->db->last_query(); 
                return $result;   
            }

            public function get_hsn_num($pro_id)
            {
                $this->db->select('hsn, product_name, form');
                // $this->db->select('*');
                $this->db->from('medicine');
                $this->db->where('product_id', $pro_id);
                $query = $this->db->get();
                $result = $query->result();
               // echo $this->db->last_query(); 
                return $result;   
            }

            public function get_gst($hsn_num)
            {
                $this->db->select('igst');
                // $this->db->select('*');
                $this->db->from('gst');
                $this->db->where('hsn_num', $hsn_num);
                $query = $this->db->get();
                $result = $query->result();
               // echo $this->db->last_query(); 
                return $result;  
            }

            public function get_supp_name($s_id)
            {
                $this->db->select('s_name');
                $this->db->from('supplier');
                $this->db->where('s_id', $s_id);
                $query = $this->db->get();
                $result = $query->result();
                return $result;  
            }
             
            public function getallmedicinewithstock()
            {
                $this->db->select('product_id,product_name,instock');
                $this->db->from('medicine');
                $this->db->where('instock>', 0);
                $query = $this->db->get();
                $result = $query->result();
                return $result;

            }

            public function getbranchidwithname($branchname)
            {
                $this->db->select('id');
                $this->db->from('store');
                $this->db->where('store_name', $branchname);
                $query = $this->db->get();
                $result = $query->result();
                return $result;

            }
            
            public function Getpatientbyid($patientid)
            {
                $this->db->select('*');
                $this->db->from('customer');
                $this->db->where('patient_id', $patientid);
                $query = $this->db->get();
                $result = $query->result();
                return $result;
            }
            
            public function insertpatient($data){
                $this->db->insert('customer',$data);              
                $query = $this->db->insert_id();  
                    
            }

            
            public function getcidpatient($patientid){
                $this->db->select('c_id');
                $this->db->from('customer');
                $this->db->where('patient_id', $patientid);
                //echo $this->db->last_query();
                $query = $this->db->get();
                $result = $query->result();
                return $result;        
            }

            public function Getmedidbyname($medicinename)
            {
                $this->db->select('*');
                $this->db->from('medicine');
                $this->db->where('product_name', $medicinename);
                $query = $this->db->get();
                $result = $query->result();
                return $result;
            }

            public function Getmedmrpbyid($id)
            {
                $this->db->select('*');
                $this->db->from('store_medicine_mata');
                $this->db->where('id', $id);
               // $this->db->where('store_id',$storeID);
               // $this->db->where('status',1);
                $query = $this->db->get();
                $result = $query->result();
                return $result;
            }

            public function GetigstbyMedID($product_id)
            {
                $this->db->select('hsn');
                $this->db->from('medicine');
                $this->db->where('product_id',$product_id);
                $query = $this->db->get();
                $result = $query->result();
                //echo $this->db->last_query(); die;
                return $result;
            }

            public function Getigstbyhsn($hsnnum)
            {
                $this->db->select('*');
                $this->db->from('gst');
                $this->db->where('hsn_num', $hsnnum);
                $query = $this->db->get();
                $result = $query->result();
                return $result;
            }
            public function GetMedStockid($product_id,$storeID)
            {
                $this->db->select_sum('instock');
                $this->db->from('store_medicine_mata');
                $this->db->where('product_id', $product_id);
                $this->db->where('store_id', $storeID);
                $this->db->where('status', 1);
                $query = $this->db->get();
                $result = $query->result();
                //echo $this->db->last_query(); die;
                return $result;
            }
            
            public function getMedicinesfromHis($id)
            {
                $this->db->select('*');
                $this->db->from('purchase');
                $this->db->where('invoice_no', $id);
                $this->db->join('purchase_history', 'purchase.p_id = purchase_history.pur_id', 'left');
                $query = $this->db->get();
                $result = $query->result();
                return $result;
            }

            public function GetMedbystore($product_id,$storeID)
            {
                $this->db->select('*');
                $this->db->from('store_medicine_mata');
                $this->db->where('product_id', $product_id);
                $this->db->where('store_id', $storeID);
                $this->db->where('status', 1);
                $this->db->order_by("instock", "desc");
                $query = $this->db->get();
                $result = $query->result();
                return $result;
            }

            public function getStockstoreValupdated($storeID){

                $storeID = $this->session->userdata('store_id');
                
                $sql = "SELECT `store_medicine_mata`.*, `supplier`.`s_id`, `s_name`, `medicine`.`product_name`, `medicine`.`generic_name`, `medicine`.`strength`
                FROM `store_medicine_mata`
                LEFT JOIN `supplier` ON `store_medicine_mata`.`supplier_id` = `supplier`.`s_id`
                LEFT JOIN `medicine` ON `store_medicine_mata`.`product_id` = `medicine`.`product_id`
                WHERE `store_medicine_mata`.`store_id` = '$storeID' AND `store_medicine_mata`.`status` = '1'
                ORDER BY `medicine`.`product_name` ASC";         
                $query = $this->db->query($sql);              
                $result = $query->result(); 
                //echo $this->db->last_query();    
                return $result;
        
                  }

                  public function Getunitsbyform($form){
                    $sql = "SELECT * FROM `units`
                    WHERE `units`.`form` = '$form'";
                    
                    $query = $this->db->query($sql);
                    $result = $query->result();
                    return $result;
                }
                public function get_purchase_rateperunit($pro_id, $supplier_id, $batch)
                {
                    $this->db->select('*');
                    $this->db->from('purchase_history');
                    $this->db->where('mid', $pro_id);
                    $this->db->where('supp_id', $supplier_id);
                    $this->db->where('Batch_Number', $batch);
                    $query = $this->db->get();
                    $result = $query->result();
                    return $result;
                }

                public function get_stock_fromsales($pro_id, $supplier_id, $batch, $START5, $END5){
                
                    $sql = "SELECT *              
                            FROM `sales_details`
                            WHERE `sales_details`.`mid`='$pro_id' AND `sales_details`.`supplier_id` ='$supplier_id' AND `sales_details`.`Batch_Number` ='$batch'   AND `sales_details`.`sale_date` BETWEEN '$START5' AND '$END5'";
                    $query = $this->db->query($sql);
                   // echo $this->db->last_query();
                    $result = $query->result();
                    return $result;
                }

                public function getstockrecievedvalue1($pro_id,$START5,$END5) 
                {
                    $newDate1 = date("Y-m-d", strtotime($START5));
                    $newDate2 = date("Y-m-d", strtotime($END5));
                    $this->db->select_sum('rec_qty');
                    $this->db->from('meta_grn');
                    $this->db->where('product_id', $pro_id);
                    $this->db->where('DATE(meta_grn.createdAt) >=', $newDate1);
                    $this->db->where('DATE(meta_grn.createdAt) <=', $newDate2);
                    $query = $this->db->get();
                    
                    $result = $query->row(); 
                    //echo $this->db->last_query();
                    return $result->rec_qty;
                }

                public function getAllMedicineid(){
                    $this->db->select(`medicine`.`product_id`,`product_name`);
                    $this->db->from('medicine');                    
                     $this->db->order_by('medicine.product_name', 'ASC'); 
                    $query = $this->db->get();
                    $result= $query->result();
                    return $result;
                
                }

                public function getformbyname($title){
                    $sql = "SELECT * FROM `unit_form` WHERE `unit_form`.`title`='$title'";
                    $query = $this->db->query($sql);
                    $result = $query->result();
                    //echo $this->db->last_query();
                    return $result;
                }
          
                 public function getunitbyid($id){
                    $sql = "SELECT * FROM `units` WHERE `units`.`form`='$id'";
                    $query = $this->db->query($sql);
                    $result = $query->result();
                    //echo $this->db->last_query();
                    return $result;
                }

                public function getsubformbyId($mid) {
                    
                    $this->db->select('subform');
                    $this->db->where('product_id', $mid);
                    $query = $this->db->get('medicine');
                    $result = $query->result_array();
                    //echo $this->db->last_query();
                    return $result;
                   
                }
                public function getAllsubformunit($id) {
                    
                    $this->db->select('*');
                    $this->db->where('id', $id);
                    $query = $this->db->get('units');
                    $result = $query->result_array();
                    //echo $this->db->last_query();
                    return $result;
                   
                }
                
                
            
    }

?>