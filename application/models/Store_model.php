<?php
	class Store_model extends CI_Model{
	function __consturct(){
	parent::__construct();
	}

    public function insert_store($data){

		$this->db->insert('store',$data);
        $insert_id = $this->db->insert_id();
		//echo $this->db->last_query();
        return $insert_id;

	}

	public function get_stores($storeID)
	{
		$this->db->select('*');
		$this->db->from('store');
		$this->db->where('id !=', $storeID);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	public function get_storess()
	{
		$this->db->select('*');
		$this->db->from('store');
		$this->db->order_by("store_name", "asc");
		// $this->db->where('id !=', $storeID);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	public function get_stores_info($id)
	{
		$this->db->select('*');
		$this->db->from('store');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	public function get_stores_infoby_sid($id)
	{
		$this->db->select('*');
		$this->db->from('store');
		$this->db->where('store_id', $id);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	public function update_store($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('store', $data);
		return true;
	}

	public function delete_store($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('store');
		return true;
	}

  
}