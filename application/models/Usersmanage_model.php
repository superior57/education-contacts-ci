<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usersmanage_model extends CI_Model {

	var $table = 'tbl_users';
	var $column = array('userId', 'email','password','name','mobile','roleId', 'isDeleted', 'status', 'createdBy', 'createdDtm', 'updatedBy', 'updatedDtm', 'role', 'state');
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		    $this->search = '';

	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);

		$i = 0;
	
		foreach ($this->column as $item) 
		{
			if($_POST['search']['value'])
				($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
			$column[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		// $this->_get_datatables_query();
		// if($_POST['length'] != -1)
		// $this->db->limit($_POST['length'], $_POST['start']);
		// $query = $this->db->get();
		// return $query->result();
		return $this->db->query("SELECT * FROM $this->table LEFT JOIN tbl_roles ON $this->table.roleId = tbl_roles.roleId ORDER BY userId")->result();


	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		return $this->db->query("SELECT * FROM $this->table LEFT JOIN tbl_roles ON $this->table.roleId = tbl_roles.roleId WHERE userId = $id")->row();
	}

	public function get_by_member($staff)
	{
		$this->db->from($this->table);
		$this->db->where('name',$staff);
		$query = $this->db->get();

		return $query->row();
	}

	public function save_staff($data)
	{
		if ( is_by($data->email) ) {
			$this->db->update($this->table, $data, array('email' => $data->email));
			// return $this->db->affected_rows();
		}
		$this->db->insert($this->table, $data);
	}
		public function save($data)
	{

		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function verify_password( $where, $oldpass )
	{
		$this->db->from($this->table);
		$this->db->where($where);
		$query = $this->db->get();
		$result = $query->row();

		if (verifyHashedPassword($oldpass, $result->password) ){
			return true;			
		}
		return false;
	}

	public function delete_by_id($id)
	{
		$this->db->where('userId', $id);
		$this->db->delete($this->table);
	}

		public function get_by_id_view($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$results = $query->result();
		}
		return $results;
	}

	public function get_role($role_id)
	{
		return $this->db->query("SELECT * FROM tbl_roles WHERE roleId = $role_id")->row();
	}

	function is_by($email)
	{
		$this->db->from($this->table);
		$this->db->where('email', $email);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;
		}
		return false;
	}


}
