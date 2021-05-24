<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pupil extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('pupil_model','pupil');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('pupil_view');
	}

	public function ajax_list()
	{
		$list = $this->pupil->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pupil) {
			$no++;
			$row = array();
			$row[] = $pupil->name;
			$row[] = $pupil->dob;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_pupil('."'".$pupil->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_pupil('."'".$pupil->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->pupil->count_all(),
						"recordsFiltered" => $this->pupil->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->pupil->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'name' => $this->input->post('name'),
				'dob' => $this->input->post('dob'),
				'is_fsm' => $this->input->post('is_fsmY'),
				'is_eal' => $this->input->post('is_ealY'),
				'ncy' => $this->input->post('ncy'),
				'sen_status' => $this->input->post('sen_status'),
				'cur_funding' => $this->input->post('cur_funding'),
				'upn' => $this->input->post('upn'),
				'sen_needs' => $this->input->post('sen_needs'),
				'notes' => $this->input->post('notes'),
			);
		$insert = $this->pupil->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'name' => $this->input->post('name'),
				'dob' => $this->input->post('dob'),
				'is_fsm' => $this->input->post('is_fsmY'),
				'is_eal' => $this->input->post('is_ealY'),
				'ncy' => $this->input->post('ncy'),
				'sen_status' => $this->input->post('sen_status'),
				'cur_funding' => $this->input->post('cur_funding'),
				'upn' => $this->input->post('upn'),
				'sen_needs' => $this->input->post('sen_needs'),
				'notes' => $this->input->post('notes'),
			);
		$this->pupil->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->pupil->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

}
