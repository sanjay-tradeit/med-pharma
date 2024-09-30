<?php

	class Sales_model extends CI_Model{


	function __consturct(){
	parent::__construct();
	
	}
/*    public function Add_user_info($data){
		$this->db->insert('user',$data);
	}*/
    public function getTodaysSale($date){
        $sql = "SELECT `sales`.*,
        `customer`.`c_name`
        FROM `sales`
        LEFT JOIN `customer` ON `sales`.`cus_id`=`customer`.`c_id`
        WHERE `sales`.`create_date`='$date' ORDER BY `sales`.`id` DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getTodaysSaleByCounter($today,$counter){
        $sql = "SELECT `sales`.*,
        `customer`.`c_name`
        FROM `sales`
        LEFT JOIN `customer` ON `sales`.`cus_id`=`customer`.`c_id`
        WHERE `sales`.`sale_date`='$today' AND `sales`.`store_id`='$counter'";
        $query = $this->db->query($sql);
    
        $result = $query->result();
        return $result;
    }
    public function GetTotalTodaySales($today){
        $sql = "SELECT `paid_amount` FROM `sales` WHERE `sales`.`create_date`='$today'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getActualpurprice($medicine,$batch_no,$supplier_id){
        $sql = "SELECT `actual_purrate` FROM `purchase_history` WHERE `purchase_history`.`mid`='$medicine' AND `purchase_history`.`Batch_Number`='$batch_no' AND `purchase_history`.`supp_id`='$supplier_id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;
    }
    /*public function GetSpecificSales($sid){
        $sql = "SELECT `total_amount` FROM `sales` WHERE `sales`.`sale_id`='$sid'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }*/
    public function GetAllClosingReport(){
        $sql = "SELECT * FROM `closing`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function GetTotalTodayPurchase($todays){
        $sql = "SELECT `paid_amount` FROM `supp_payment` WHERE `supp_payment`.`date`='$todays'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getByInvoiceFromToEnd($start,$end){
        $formattedDatestart = DateTime::createFromFormat('d/m/Y', $start)->format('Y-m-d');
        $formattedDateend = DateTime::createFromFormat('d/m/Y', $end)->format('Y-m-d');
        $storeid = $this->session->userdata('store_id');
        $emtype = $this->session->userdata('em_type');
        if($emtype == "admin")
        {
            
            $this->db->select('*');
            $this->db->from('sales');
            $this->db->where('sales.sale_date >=', $formattedDatestart);
            $this->db->where('sales.sale_date <=', $formattedDateend);
            // $this->db->where('sales.store_id', $storeid);
            $this->db->join('sales_details', 'sales.sale_id = sales_details.sale_id', 'left');
            $this->db->join('customer', 'customer.c_id = sales.cus_id', 'left');
            $this->db->order_by('sales.id', "desc");
            $this->db->group_by('invoice_no');
            $query = $this->db->get();
            echo $this->db->last_query();
            $result = $query->result();
            return $result;
        }
        else
        {
            $this->db->select('*');
            $this->db->from('sales');
            $this->db->where('sales.sale_date >=', $formattedDatestart);
            $this->db->where('sales.sale_date <=', $formattedDateend);
            $this->db->where('sales.store_id', $storeid);
            $this->db->join('sales_details', 'sales.sale_id = sales_details.sale_id', 'left');
            $this->db->join('customer', 'customer.c_id = sales.cus_id', 'right outer');
             $this->db->group_by('invoice_no');
            $this->db->order_by('sales.id', "desc");
            $query = $this->db->get();
            $result = $query->result();

           // echo $this->db->last_query();
            return $result;
        }
      

  
    }

    public function get_item_con($start,$end,$mainid){
        $storeid = $this->session->userdata('store_id');

        if($storeid == $mainid)
        {
            $this->db->select('sales_details.*, sales.*, SUM(sales_details.qty) AS totl_qty');
           // $this->db->select('*');
            $this->db->from('sales');
            $this->db->where('create_date >=', $start);
            $this->db->where('create_date <=', $end);
            $this->db->join('sales_details', 'sales.sale_id = sales_details.sale_id', 'left');
            $this->db->join('customer', 'customer.c_id = sales.cus_id', 'right outer');
            $this->db->group_by('sales_details.mid'); 
            $query = $this->db->get();
             //echo $this->db->last_query();
            $result = $query->result();
            return $result;
        }
        else
        {
            $this->db->select('*');
            $this->db->from('sales');
            $this->db->where('create_date >=', $start);
            $this->db->where('create_date <=', $end);
            $this->db->where('sales.store_id', $storeid);
            $this->db->join('sales_details', 'sales.sale_id = sales_details.sale_id', 'left');
            $this->db->join('customer', 'customer.c_id = sales.cus_id', 'right outer');
            // $this->db->group_by('mid');
            $query = $this->db->get();
            $result = $query->result();

           // echo $this->db->last_query();
            return $result;
        }
      

  
    }
    public function getByInvoiceFromToEndByCounter($start,$end){
        $sql = "SELECT `sales`.*,
        `customer`.`c_name`,
        `user`.`em_id`,`em_name`
        FROM `sales`
        LEFT JOIN `customer` ON `sales`.`cus_id`=`customer`.`c_id`
        LEFT JOIN `user` ON `sales`.`entryid`=`user`.`em_id`
        WHERE  `sales`.`create_date` BETWEEN '$start' AND '$end'";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }
    public function getSalesReport(){
        if($this->session->userdata('em_type') =='admin'){       
        $sql = "SELECT `sales`.*,
        `customer`.`c_name`
        FROM `sales`
        LEFT JOIN `customer` ON `sales`.`cus_id`=`customer`.`c_id`";
        $query = $this->db->query($sql);
        
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;
    }
    else{
        $store_id = $this->session->userdata('store_id');
        $sql = "SELECT `sales`.*,
        `customer`.`c_name`
        FROM `sales`
        LEFT JOIN `customer` ON `sales`.`cus_id`=`customer`.`c_id`
        WHERE `sales`.`store_id`='$store_id'";
        $query = $this->db->query($sql);       
        $result = $query->result();
        //echo $this->db->last_query();
        return $result; 
    }
}
    public function getsalesSpecificData($sid){
        $sql = "SELECT `sales`.*,
        `customer`.`c_name`,`c_id`,`c_type`
        FROM `sales`
        LEFT JOIN `customer` ON `sales`.`cus_id`=`customer`.`c_id`
        WHERE `sales`.`sale_id`='$sid'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    } 
    public function getSalesReportForInvoice($id){
        $sql = "SELECT `sales`.*,
        `customer`.`c_name`
        FROM `sales`
        LEFT JOIN `customer` ON `sales`.`cus_id`=`customer`.`c_id`
        WHERE `sales`.`sale_id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }  
        /*Sales return report*/
    public function GetSalesReturnReport($start5,$END5){
        if($this->session->userdata('em_type') =='admin'){
        $sql = "SELECT `sales_return`.*,
        `customer`.`c_name`,
        `user`.`em_name`,`em_id`
        FROM `sales_return`
        LEFT JOIN `customer` ON `sales_return`.`cus_id`=`customer`.`c_id`
        LEFT JOIN `user` ON `sales_return`.`entry_id`=`user`.`em_id`
        WHERE `sales_return`.`return_date` BETWEEN '$start5' AND '$END5'";
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;
        }
        else{
        $store_id = $this->session->userdata('store_id');
        $sql = "SELECT `sales_return`.*,
        `customer`.`c_name`,
        `user`.`em_name`,`em_id`
        FROM `sales_return`
        LEFT JOIN `customer` ON `sales_return`.`cus_id`=`customer`.`c_id`
        LEFT JOIN `user` ON `sales_return`.`entry_id`=`user`.`em_id`
        WHERE `sales_return`.`store_id`='$store_id' AND `sales_return`.`return_date` BETWEEN '$start5' AND '$END5'";
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;
        }
    }   
        /*Sales return report details*/
    public function SalesReturnDetails($ID){
        $sql = "SELECT `sales_return_details`.*,
        `medicine`.`product_name`,`product_id`
        FROM `sales_return_details`
        LEFT JOIN `medicine` ON `sales_return_details`.`mid`=`medicine`.`product_id`
        WHERE `sales_return_details`.`sr_id`='$ID'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }  
    public function getSalesDetailsForInvoice($id){
        $sql = "SELECT `sales_details`.*,
        `medicine`.`product_id`,`product_name`,`purchase_rate`,`strength`,`generic_name`
        FROM `sales_details`
        LEFT JOIN `medicine` ON `sales_details`.`mid`=`medicine`.`product_id`
        WHERE `sales_details`.`sale_id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    } 
    public function getTodaysPurchase($date){
        $sql = "SELECT `purchase`.*,
        `supplier`.`s_name`
        FROM `purchase`
        LEFT JOIN `supplier` ON `purchase`.`sid`=`supplier`.`s_id`
        WHERE `purchase`.`entry_date`='$date'";
        $query = $this->db->query($sql);
        $result = $query->result();
    
        return $result;
    } 
    public function getPurchaseReport(){
        $sql = "SELECT `purchase`.*,
        `supplier`.`s_name`
        FROM `purchase`
        LEFT JOIN `supplier` ON `purchase`.`sid`=`supplier`.`s_id`";
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;
    }
    public function getPurchaseReturnReport($start5,$END5){
        $newDate = date("m-d-Y", strtotime($start5));
        $newDate1 = date("m-d-Y", strtotime($END5));
        $sql = "SELECT `purchase_return`.*,
        `supplier`.`s_name`,`s_id`
        FROM `purchase_return`
        LEFT JOIN `supplier` ON `purchase_return`.`sid`=`supplier`.`s_id`
        WHERE `purchase_return`.`return_date` BETWEEN '$newDate' AND '$newDate1'";
        $query = $this->db->query($sql);
        $result = $query->result();
        echo $this->db->last_query();
        return $result;
    }
    public function PurchaseReturnDetails($ID){
        $sql = "SELECT `purchase_return_details`.*,
        `supplier`.`s_name`,`s_id`,
        `medicine`.`product_id`,`product_name`
        FROM `purchase_return_details`
        LEFT JOIN `supplier` ON `purchase_return_details`.`supp_id`=`supplier`.`s_id`
        LEFT JOIN `medicine` ON `purchase_return_details`.`mid`=`medicine`.`product_id`
        WHERE `purchase_return_details`.`r_id`='$ID'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


    // Get details by invoice number
    public function getByInvoice($invoiceID) {

    $sql = "SELECT `mid` AS `medicine_id`, `qty`, `rate`, `total_price`, `discount`, `total_discount`, (SELECT `medicine`.`product_name` FROM `medicine` WHERE `medicine_id` = `medicine`.`product_id`) AS 'medicine_name'
            FROM `sales_details`
            WHERE `sale_id` IN (SELECT `sale_id` FROM `sales` WHERE `invoice_no` = '$invoiceID')";

    /*$sql = "SELECT `mid`, `qty`, `rate`, `total_price`, `discount`, `total_discount`,
            `medicine`.`product_name`
            FROM `sales_details`
            LEFT JOIN `medicine` ON `medicine`.`product_id` = `sales_details`.`mid`
            WHERE `sale_id` IN (SELECT `sale_id` FROM `sales` WHERE `invoice_no` = '65168533')";*/

        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;        
    } 

    public function Sales_Return_Form($data){
        $this->db->insert('sales_return',$data);
    } 

    public function Save_Sales_Retun_History($data){
        $this->db->insert('sales_return_details',$data);
    }    

    public function getpurchasedetail($start55,$end55,$storeID)
    {
        
        
        // $storeID = $this->session->userdata('store_id');
        $sql = "SELECT *, SUM(total_amount) as sum
        FROM `stock_transfer`
        WHERE `stock_transfer`.`store_id`='$storeID' AND `stock_transfer`.`date` BETWEEN '$start55' AND '$end55'";
        $query = $this->db->query($sql);
        
        $result = $query->result();
        return $result;
    }

    public function getsalesdetail($start55,$end55,$storeID)
     {
    //     $sql = "SELECT SUM(total_price)        
    //     FROM `sales_details`
    //     WHERE `sales_details`.`store_id`='78' AND `sales_details`.`date`  BETWEEN '$start' AND '$end'";
    //     $query = $this->db->query($sql);
    //     $result = $query->result();
    //     return $result;
    // }
    // $storeID = $this->session->userdata('store_id');
    $sql = "SELECT *, SUM(total_amount) as sum
    FROM `sales`
    WHERE `sales`.`store_id`='$storeID' AND `sales`.`sale_date` BETWEEN '$start55' AND '$end55'";
    $query = $this->db->query($sql);
    
    $result = $query->result();
    return $result;
}

public function getsalesreturndetail($start55,$end55,$storeID)
{
//     $sql = "SELECT SUM(total_price)        
//     FROM `sales_details`
//     WHERE `sales_details`.`store_id`='78' AND `sales_details`.`date`  BETWEEN '$start' AND '$end'";
//     $query = $this->db->query($sql);
//     $result = $query->result();
//     return $result;
// }
// $storeID = $this->session->userdata('store_id');
$sql = "SELECT SUM(total_amount) as sum, SUM(tax) as sumtax
FROM `sales_return`
WHERE `sales_return`.`store_id`='$storeID' AND `sales_return`.`return_date` BETWEEN '$start55' AND '$end55'";
$query = $this->db->query($sql);
//echo $this->db->last_query(); die;
$result = $query->result();
return $result;
}



public function Getsalesbysid($sid)
    {
        
        $sql = "SELECT *
        FROM `sales`
        WHERE `sales`.`sale_id`='$sid'";
        $query = $this->db->query($sql);
    
        $result = $query->result();
        return $result;
    }

    public function Update_Sales_Details($sid,$data)
    {

    $this->db->where('sale_id', $sid);
    $this->db->update('sales', $data);
    return true;
    }
    
    public function GethsnNum($mid)
    {
        
        $sql = "SELECT *
        FROM `medicine`
        WHERE `medicine`.`product_id`='$mid'";
        $query = $this->db->query($sql);
    
        $result = $query->result();
        return $result;
    }
    
    public function GetgrnNum($pid)
    {
        
        $sql = "SELECT *
        FROM `grn`
        WHERE `grn`.`po_no`='$pid'";
        $query = $this->db->query($sql);
    
        $result = $query->result();
        return $result;
    }

    public function Getperunitpur($mid,$batchno)
    {
        
        $sql = "SELECT *
        FROM `purchase_history`
        WHERE `purchase_history`.`mid`='$mid' AND `purchase_history`.`Batch_Number` ='$batchno'";
        $query = $this->db->query($sql);
    
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;
    }

    public function getigst($hsn)
    {
        $sql = "SELECT *
        FROM `gst`
        WHERE `gst`.`hsn_num`='$hsn'";
        $query = $this->db->query($sql);
        
        $result = $query->result();
        return $result;
    }
    
    public function getClosingstockReport(){
        $store_id = $this->session->userdata('store_id');
        $sql = "SELECT `sales`.*,
        `customer`.`c_name`
        FROM `sales`
        LEFT JOIN `customer` ON `sales`.`cus_id`=`customer`.`c_id`
        WHERE `sales`.`store_id`='$store_id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    // public function getBydatemedicineFromToEnd($start5,$END5){
    //     $sql = "SELECT `sales_details`.*,
    //     `medicine`.`product_name`,`product_id`,`form`,`expire_date123`,`instock`,`supplier`.`s_name`
    //     FROM `sales_details`
    //     LEFT JOIN `medicine` ON `sales_details`.`mid`=`medicine`.`product_id`
    //     LEFT JOIN `supplier` ON `sales_details`.`supplier_id`=`supplier`.`s_id`
    //     WHERE `sales_details`.`sale_date` BETWEEN '$start5' AND '$END5'";
    //     $query = $this->db->query($sql);
    //     $result = $query->result();
    //     return $result;
    // } 
  

        public function getBydatemedicineFromToEnd($start5,$END5) 
        {
            $this->db->select('*');
            $this->db->from('store_medicine_mata');
            $this->db->where('DATE(createdat)>=', $start5);
            $this->db->where('DATE(createdat)<=', $END5);
            $this->db->where('status', "1");
            $query = $this->db->get();
            $result = $query->result();
           // echo $this->db->last_query();
            return $result;

        
        } 
        
        public function getBydatemedicineFromToEnd1($start5) 
        {
            $this->db->select('*');
            $this->db->from('store_medicine_mata');
            $this->db->where('DATE(createdat)=', $start5);
            $this->db->where('status', "1");
            $query = $this->db->get();
            $result = $query->result();
            echo $this->db->last_query();
            return $result;

        
        } 

        public function get_stock($pro_id, $supplier_id, $batch,$start5, $END5)
        {
            $this->db->select('SUM(instock) AS total_qty, product_id, 	supplier_id, Batch_Number, expire_date, purchase_rate, mrp, instock, sale_qty, tax');
            // $this->db->select('*');
            $this->db->from('store_medicine_mata');
            $this->db->where('product_id', $pro_id);
            $this->db->where('supplier_id', $supplier_id);
            $this->db->where('Batch_Number', $batch);
            $this->db->where('DATE(createdat)>=', $start5);
            $this->db->where('DATE(createdat)<=', $END5);
            $this->db->where('status', "1");
            $query = $this->db->get();
            $result = $query->result();
            // echo $this->db->last_query(); 
            return $result;   
        }



    public function getPurchaseReportstatrt($start5,$END5){
        $formattedDatestart = DateTime::createFromFormat('d/m/Y', $start5)->format('m/d/Y');
        $formattedDateend = DateTime::createFromFormat('d/m/Y', $END5)->format('m/d/Y');
        $sql = "SELECT `purchase`.*,
        `supplier`.`s_name`
        FROM `purchase`
        LEFT JOIN `supplier` ON `purchase`.`sid`=`supplier`.`s_id`
        WHERE `purchase`.`pur_date` BETWEEN '$formattedDatestart' AND '$formattedDateend'";
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;
    }

    public function getPurchasesaleledger($medid,$start5,$END5,$start1,$newDate){
        
        $sql = "SELECT `purchase_history`.*,
        `supplier`.`s_name`,`purchase`.`pur_date`,`sales_details`.`sale_date`,`sales_details`.`qty` AS `sold`
        FROM `purchase_history`
        LEFT JOIN `supplier` ON `purchase_history`.`supp_id`=`supplier`.`s_id`
        LEFT JOIN `purchase` ON `purchase_history`.`pur_id`=`purchase`.`p_id`
        LEFT JOIN `purchase_return` ON `purchase_history`.`pur_id`=`purchase_return`.`pur_id`
        LEFT JOIN `sales_details` ON `purchase_history`.`mid`=`sales_details`.`mid`
        WHERE `purchase_history`.`mid`='$medid' AND`purchase`.`pur_date` BETWEEN '$start5' AND '$END5' AND `sales_details`.`sale_date` BETWEEN '$start1' AND '$newDate'";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();
        $result = $query->result();
        return $result;
    }
    public function getPurchaseledger($medid,$start5,$END5){
        //echo "purchasedetails";
        $sql = "SELECT `purchase_history`.*,
        `supplier`.`s_name`,`purchase`.`pur_date`,`purchase`.`invoice_no`,`medicine`.`product_name`,`medicine`.`generic_name`
        FROM `purchase_history`
        LEFT JOIN `supplier` ON `purchase_history`.`supp_id`=`supplier`.`s_id`
        LEFT JOIN `purchase` ON `purchase_history`.`pur_id`=`purchase`.`p_id`
        LEFT JOIN `medicine` ON `purchase_history`.`mid`=`medicine`.`product_id`
        WHERE `purchase_history`.`mid`='$medid' AND`purchase`.`pur_date` BETWEEN '$start5' AND '$END5'";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();
        $result = $query->result();
        return $result;
    }

    public function getGRNledger($medid,$start5,$END5){
        //echo "purchasedetails";
        $sql = "SELECT `meta_grn`.*
                
                FROM `meta_grn`
                LEFT JOIN `grn` ON `meta_grn`.`grn_no`=`grn`.`grn_no`
                
                WHERE `meta_grn`.`product_id`='$medid' AND `meta_grn`.`createdAt` BETWEEN '$start5' AND '$END5'";
        $query = $this->db->query($sql);
       //echo $this->db->last_query();
        $result = $query->result();
       return $result;
    }
   
    public function getSalesledger($medid, $start1, $newDate){
        //print_r($start1);
        //echo "salesdetails";
        $sql = "SELECT `sales_details`.*,
                `supplier`.`s_name`, `sales`.`cus_id`
                FROM `sales_details`
                LEFT JOIN `supplier` ON `sales_details`.`supplier_id`=`supplier`.`s_id`
                LEFT JOIN `sales` ON `sales_details`.`sale_id`=`sales`.`sale_id`
                WHERE `sales_details`.`mid`='$medid' AND `sales_details`.`sale_date` BETWEEN '$start1' AND '$newDate'";
        $query = $this->db->query($sql);
       // echo $this->db->last_query();
        $result = $query->result();
        return $result;
    }

    public function getGrnstock($purchase,$pname,$gname){

                $sql = "SELECT * FROM `grn`
                WHERE `grn`.`po_no`='$purchase' AND `grn`.`product_name`='$pname' AND `grn`.`generic_name`='$gname'";
                $query = $this->db->query($sql);
                //echo $this->db->last_query();
                $result = $query->result();
                return $result;
                 }

                 public function getTodaysSalewithdue($date){
                    $sql = "SELECT `sales`.*,
                    `customer`.`c_name`
                    FROM `sales`
                    LEFT JOIN `customer` ON `sales`.`cus_id`=`customer`.`c_id`
                    WHERE `sales`.`due_amount` > 0 AND `sales`.`create_date` = '$date' ORDER BY `sales`.`create_date` DESC";
                    $query = $this->db->query($sql);
                    $result = $query->result();
                    return $result;
                }


                public function getHighQuantitySales($start_date, $end_date)
                {
                    $this->db->select('sales_details.supplier_id, sales_details.Batch_Number, sales_details.mid, sales_details.sale_id, sales_details.grand_total, sales.invoice_no, SUM(CAST(sales_details.qty AS UNSIGNED)) AS total_quantity_sold');
                    $this->db->from('sales_details');
                    $this->db->join('sales', 'sales.sale_id = sales_details.sale_id', 'left');
                    $this->db->where('DATE(sales_details.sale_date) >=', $start_date);
                    $this->db->where('DATE(sales_details.sale_date) <=', $end_date);
                    $this->db->group_by('sales_details.mid');
                    $this->db->order_by('total_quantity_sold', 'DESC');
                    $query = $this->db->get();
                    //echo $this->db->last_query(); 
                    return $query->result();
                }
                


                
                public function getlowQuantitySales($start_date, $end_date)
                {
                    $this->db->select('sales_details.supplier_id, sales_details.Batch_Number, sales_details.mid, sales_details.sale_id, sales_details.grand_total, sales.invoice_no, SUM(CAST(sales_details.qty AS UNSIGNED)) AS total_quantity_sold');
                    $this->db->from('sales_details');
                    $this->db->join('sales', 'sales.sale_id = sales_details.sale_id', 'left');
                    $this->db->where('DATE(sales_details.sale_date) >=', $start_date);
                    $this->db->where('DATE(sales_details.sale_date) <=', $end_date);
                     $this->db->group_by('sales_details.mid');
                    $this->db->order_by('total_quantity_sold', 'ASC');
                    $query = $this->db->get();
                    //echo $this->db->last_query(); 
                    return $query->result();
                }
                
                public function getInitialstock($medicine,$batch_no) 
                {
                    $this->db->select('*');
                    $this->db->from('medicine_mata');
                    $this->db->where('product_id', $medicine);
                    $this->db->where('Batch_Number', $batch_no);
                    $this->db->where('status', "1");
                    $query = $this->db->get();
                    $result = $query->result();
                    //echo $this->db->last_query();
                    return $result;
        
                
                } 
                public function getInitialstockvalue($medicine) 
                {
                    $this->db->select('stock');
                    $this->db->from('current_stock');
                    $this->db->where('product_id', $medicine);
                    $this->db->limit(1); 
                    $query = $this->db->get();
                    $result = $query->row(); 
                    //echo $this->db->last_query();
                    return $result;
                }
                
                public function getstockrecievedvalue($medicine, $start_date, $end_date) 
                {
                    $this->db->select_sum('rec_qty');
                    $this->db->from('meta_grn');
                    $this->db->where('product_id', $medicine);
                    $this->db->where('DATE(meta_grn.createdAt) >=', $start_date);
                    $this->db->where('DATE(meta_grn.createdAt) <=', $end_date);
                    $query = $this->db->get();
                    
                    $result = $query->row(); 
                    //echo $this->db->last_query();
                    return $result->rec_qty;
                }
                
                public function GetAllmedicinedata() 
                {
                    $this->db->select('*');
                    $this->db->from('store_medicine_mata');
                    $query = $this->db->get();
                    $result = $query->result();
                    //echo $this->db->last_query();
                    return $result;
                }
                public function Save_current_stock($data){
                    $this->db->insert('current_stock',$data);
                } 

                
                public function get_stock_frommedicinemata($pro_id, $supplier_id, $batch, $START5) 
                {
                    $newDate = date("d-m-Y", strtotime($START5));
                    $this->db->select('*');
                    $this->db->from('current_stock');
                    $this->db->where('product_id', $pro_id);
                    $this->db->where('Batch_Number', $batch);
                    $this->db->where('Supplier_id', $supplier_id);
                    $this->db->where('current_stock.date =', $newDate);
                    $query = $this->db->get();
                    $result = $query->result();
                    //echo $this->db->last_query();
                    return $result;
                }
                
                public function get_stock_frommedicinemataopening($pro_id, $supplier_id, $batch, $START5) 
                {
                   
                    $prev_date = date('d-m-Y', strtotime($START5 .' -1 day'));
                    $this->db->select('*');
                    $this->db->from('current_stock');
                    $this->db->where('product_id', $pro_id);
                    $this->db->where('Batch_Number', $batch);
                    $this->db->where('Supplier_id', $supplier_id);
                    $this->db->where('current_stock.date =', $prev_date);
                    $query = $this->db->get();
                    $result = $query->result();
                    // echo $this->db->last_query();
                    return $result;
                }
                public function getByInvoiceFromsales($date){
                    $sql = "SELECT `sales`.*,
                    `sales_details`.`perunit_profit`,`sales_details`.`Batch_Number`,`sales_details`.`supplier_id`,`sales_details`.`qty`,`sales_details`.`mid`,`sales_details`.`grand_total`,`sales_details`.`total_price`
                    FROM `sales`
                    LEFT JOIN `sales_details` ON `sales`.`sale_id`=`sales_details`.`sale_id`
                    WHERE `sales`.`create_date`='$date'";
                    $query = $this->db->query($sql);
                    $result = $query->result();
                    //echo $this->db->Last_query();
                    return $result;
                } 
    
                public function getByInvoiceFromsalesforprofit($invoiceID){
                    $sql = "SELECT `sales`.*,
                    `sales_details`.`perunit_profit`,`sales_details`.`Batch_Number`,`sales_details`.`supplier_id`,`sales_details`.`qty`,`sales_details`.`mid`,`sales_details`.`grand_total`,`sales_details`.`total_price`
                    FROM `sales`
                    LEFT JOIN `sales_details` ON `sales`.`sale_id`=`sales_details`.`sale_id`
                    WHERE `sales`.`invoice_no` = '$invoiceID'";
                    $query = $this->db->query($sql);
                    $result = $query->result();
                    //echo $this->db->Last_query();
                    return $result;
                }
    }
    
?>