<?php
	class Manufacturer_model extends CI_Model{
	function __consturct(){
	parent::__construct();
	}

  public function getAllmanufacturer(){
    $sql = "SELECT * FROM `manufacturer` ORDER BY `id` DESC";
    $query = $this->db->query($sql);
    $result = $query->result();
    return $result;
}


public function getAllmanufacturerid(){
  $sql = "SELECT manufacturer_id FROM `medicine` ORDER BY 'id' DESC";
  $query = $this->db->query($sql);
  $result = $query->result();
  return $result;
}

public function checkmanufacname($manuname){
  $this->db->select('m_name');
  $this->db->from('manufacturer');
  $this->db->where('m_name', $manuname);
  $query = $this->db->get();
  $result = $query->result();
  //echo ($this->db->last_query());
  return $result;

}



public function GetmanufacturerById($id){
  $sql = "SELECT * FROM `manufacturer` WHERE `id`='$id'";
  $query = $this->db->query($sql);
  $result = $query->row();
  return $result;
}


public function update_manu($id, $data){
  $this->db->where('id', $id);
  $this->db->update('manufacturer', $data);
  return true;
}


public function delete_manu($id)
{
  $this->db->where('id', $id);
  $this->db->delete('manufacturer');
  return TRUE;
}




}


?>