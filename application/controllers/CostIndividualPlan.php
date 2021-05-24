<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CostIndividualPlan extends CI_Controller {

	var $id_pup;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('costindividualplan_model','CostIndividualPlan');
	}

	public function index($pupil_id)
	{ 
		$id_pup = $pupil_id;
		$data['pupil_id'] = $pupil_id;		
		$data['staff_member'] = $this->CostIndividualPlan->getAllGroups();
//		$temp[] = $this->CostIndividualPlan->getAllGroups();

		$this->load->helper('url');
		$this->load->view('costindividualplan_view', $data);
	}

	public function ajax_list($id)
	{

		$pupil_id = $id;
		

		$list = $this->CostIndividualPlan->get_datatables($pupil_id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $CostIndividualPlan) {
			$no++;
			$row = array(); 
			$row[] = $CostIndividualPlan->sen;
			$row[] = $CostIndividualPlan->objectives;
			$row[] = $CostIndividualPlan->strategies;
			$row[] = $CostIndividualPlan->cost_str;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title= '."'".$pupil_id."'".' onclick="edit_CostIndividualPlan('."'".$CostIndividualPlan->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				<a class="btn btn-sm btn-success" href="javascript:void()" title="add Cost" onclick="addCost_CostIndividualPlan('."'".$CostIndividualPlan->id."'".')"><i class="glyphicon glyphicon-plus"></i> Cost</a>
				<a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_CostIndividualPlan('."'".$CostIndividualPlan->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->CostIndividualPlan->count_all(),
						"recordsFiltered" => $this->CostIndividualPlan->count_filtered($pupil_id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->CostIndividualPlan->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_cost_update($id)
	{
		$value = $this->input->post('value');
		$data = array(
				'cost_str' => $value,
			);
		$this->CostIndividualPlan->update(array('id' => $id), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_edit_cost($plan_id, $tblname)
	{
		$data = $this->CostIndividualPlan->get_cost($plan_id, $tblname);
		echo json_encode($data);
	}

	public function ajax_add($pupil_id)
	{
		$data = array(
				'id_pupil' => $pupil_id,
				'sen' => $this->input->post('sen'),
				'date' => $this->input->post('date'),
				'objectives' => $this->input->post('objectives'),
				'strategies' => $this->input->post('strategies'),
			);
		$insert = $this->CostIndividualPlan->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update() 
	{
		$data = array(
				'date' => $this->input->post('date'),
				'objectives' => $this->input->post('objectives'),
				'strategies' => $this->input->post('strategies'),
			);
		$this->CostIndividualPlan->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	

	public function ajax_delete($id)
	{
		$this->CostIndividualPlan->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

		public function ajax_cost_delete($plan_id, $tblname)
	{
		$this->CostIndividualPlan->delete_cost_id($plan_id, $tblname);
		echo json_encode(array("status" => TRUE));
	}


	public function ajax_cost_add($id, $tblname, $plan_id, $cost)
	{
		// $tblname = "tbl_coststaff";

		$data = array(
				'plan_id' => $plan_id,
				'hour' => $this->input->post(''.$cost.'_hour_'.$id.''),
				'minute' => $this->input->post(''.$cost.'_min_'.$id.''),
				'hourly' => $this->input->post(''.$cost.'_hourly_'.$id.''),
				'staffMember' => $this->input->post(''.$cost.'_member_'.$id.''),
				'description' => $this->input->post(''.$cost.'_desc_'.$id.''),
			);
		// print_r($tblname);
		$insert = $this->CostIndividualPlan->save_staff($data, $tblname, $plan_id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_get_total($plan_id)
	{
		$data = $this->CostIndividualPlan->get_total_cost($plan_id);
		echo json_encode($data);
	}

	public function ajax_get_other($plan_id)
	{
		$data = $this->CostIndividualPlan->get_total_other($plan_id);
		echo json_encode($data);
	}

}


