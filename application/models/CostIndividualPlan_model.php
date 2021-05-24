<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CostIndividualPlan_model extends CI_Model {

	var $table = 'intervention_plan';
	var $column = array('id_pupil','sen','objectives','strategies','cost_str', 'cost_val', 'date');
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		    $this->search = '';

	}
	public function getAllGroups()
	{
	    return $this->db->query('SELECT name FROM staffs ORDER BY id')->result_array();   
	}

	private function _get_datatables_query($id)
	{
		
		$this->db->from($this->table);
		$this->db->where('id_pupil', $id);
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

	function get_datatables($id)
	{
		$this->_get_datatables_query($id);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($id)
	{
		$this->_get_datatables_query($id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	public function count_all_staff($tblname)
	{
		$this->db->from($tblname);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	// public function update_by_cost($id, $value)
	// {
	// 	// $this->db->from($this->table);
	// }

		public function get_cost($plan_id, $tblname)
	{
		$this->db->from($tblname);
		$this->db->where('plan_id', $plan_id);
		$this->db->order_by("id");
		$query = $this->db->get();
		return $query->result_array();

	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

		public function save_staff($data, $tblname, $plan_id)
	{

		$this->db->insert($tblname, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	

	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}

	public function delete_cost_id($plan_id, $tblname)
	{
		$this->db->where('plan_id', $plan_id);
		$this->db->delete($tblname);
		// print_r($tblname+"===="+$plan_id);
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

	public function get_total_cost($pupil_id)
	{
		return $this->db->query("SELECT tbl_coststaff.hour, tbl_coststaff.minute, tbl_coststaff.hourly 
			FROM intervention_plan LEFT JOIN tbl_coststaff ON 
			intervention_plan.id = tbl_coststaff.plan_id WHERE 
			intervention_plan.id_pupil = $pupil_id")->result_array();

	}
	public function get_total_other($pupil_id)
	{
		return $this->db->query("SELECT tbl_costother.hour, tbl_costother.minute, tbl_costother.hourly 
			FROM intervention_plan LEFT JOIN tbl_costother ON 
			intervention_plan.id = tbl_costother.plan_id WHERE 
			intervention_plan.id_pupil = $pupil_id")->result_array();

	}


}
