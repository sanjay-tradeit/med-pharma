<?php
	class Hsn_model extends CI_Model{
	function __consturct(){
	parent::__construct();
	}

  public function getAllHsn(){
    $sql = "SELECT * FROM `gst` ORDER BY `id` DESC";
    $query = $this->db->query($sql);
    $result = $query->result();
    return $result;
}


    public function Savehsn($data){
        $this->db->insert('gst',$data);
        //echo $this->db->last_query();
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function delete_hsn($hsnnum)
    {
      $this->db->where('hsn_num', $hsnnum);
      $this->db->delete('gst');
      return TRUE;
    }

    //edit hsn 
    // public function edit_hsn($hsnnum)
    // {
    //   $this->db->select('*');
    //   $this->db->from('gst');
    //   $this->db->where('hsn_num', $hsnnum);
    //   $query = $this->db->get();
    //   $result = $query->result();
    //   return $result;
    // }
    public function GetHsnById($id){
        $sql = "SELECT * FROM `gst` WHERE `id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function GetHsnDetailsById($id){
      $sql = "SELECT * FROM `gst` WHERE `hsn_num`='$id'";
      $query = $this->db->query($sql);
      $result = $query->row();
      return $result;
  }

    
    public function update_hsn($id, $data){
      $this->db->where('id', $id);
      $this->db->update('gst', $data);
      return true;
    }

// Get Tax details by HSN
    public function GetTaxDetails($hsn){
     // return $hsn;
      $sql = "SELECT * FROM `gst` WHERE `hsn_num`= $hsn";
      $query = $this->db->query($sql);
      $result = $query->row();
      //return $this->db->last_query();
      return $result;
  }

}


?>