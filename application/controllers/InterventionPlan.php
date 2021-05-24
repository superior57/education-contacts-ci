<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InterventionPlan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('interventionplan_model','interventionPlan');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('interventionplan_view');
	}
	public function edit()
	{
		$this->load->view('costIndividualPlan_view');
	}

		public function ajax_cost($id, $value)
	{
		$data = $this->CostIndividualPlan->get_by_cost($id, $value);
		echo json_encode($data);
	}

	public function ajax_list()
	{
		$list = $this->interventionPlan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $interventionPlan) {
			$no++;
			$row = array();
			$row[] = $interventionPlan->name;
			$row[] = $interventionPlan->dob;
			$row[] = $interventionPlan->ncy;
			$row[] = $interventionPlan->sen_status;
			$row[] = $interventionPlan->cur_funding;

			//add html for action
			$row[] = '<a  class="ayam btn btn-sm btn-success" href="CostIndividualPlan/index/'.$interventionPlan->id.'" title="Edit" ><i class="glyphicon glyphicon-pencil"></i> Plan</a>
				<a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_interventionPlan('."'".$interventionPlan->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->interventionPlan->count_all(),
						"recordsFiltered" => $this->interventionPlan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		
		$data = $this->interventionPlan->get_by_id($id);
		echo json_encode($data);

	}

	public function ajax_add()
	{
		$data = array(
				'name' => $this->input->post('name'),
				'dob' => $this->input->post('dob'),
				'is_fsm' => $this->input->post('is_fsm'),
				'is_eal' => $this->input->post('is_eal'),
				'ncy' => $this->input->post('ncy'),
				'sen_status' => $this->input->post('sen_status'),
				'cur_funding' => $this->input->post('cur_funding'),
				'upn' => $this->input->post('upn'),
				'sen_needs' => $this->input->post('sen_needs'),
				'notes' => $this->input->post('notes'),
			);
		$insert = $this->interventionPlan->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'name' => $this->input->post('name'),
				'dob' => $this->input->post('dob'),
				'is_fsm' => $this->input->post('is_fsm'),
				'is_eal' => $this->input->post('is_eal'),
				'ncy' => $this->input->post('ncy'),
				'sen_status' => $this->input->post('sen_status'),
				'cur_funding' => $this->input->post('cur_funding'),
				'upn' => $this->input->post('upn'),
				'sen_needs' => $this->input->post('sen_needs'),
				'notes' => $this->input->post('notes'),
			);
		$this->interventionPlan->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->interventionPlan->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

}
