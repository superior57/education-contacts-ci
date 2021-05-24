<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Staff_model','staff');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('staff_view');
	}

	public function ajax_list()
	{
		$list = $this->staff->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $staff) {
			$no++;
			$row = array();
			$row[] = $staff->name;
			$row[] = $staff->position;
			$row[] = $staff->hourly_rate;


			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_staff('."'".$staff->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_staff('."'".$staff->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->staff->count_all(),
						"recordsFiltered" => $this->staff->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->staff->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_member($staff)
	{
		$data = $this->staff->get_by_member($staff);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'name' => $this->input->post('name'),
				'position' => $this->input->post('position'),
				'hourly_rate' => $this->input->post('hourly_rate'),
				'notes' => $this->input->post('notes'),
				'is_portalLogon' => $this->input->post('chbPortal'),
				'userName' => $this->input->post('userName'),
				'password' => $this->input->post('password'),
				'is_adminAccess' => $this->input->post('chbAdmin'),
			);
		$insert = $this->staff->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'name' => $this->input->post('name'),
				'position' => $this->input->post('position'),
				'hourly_rate' => $this->input->post('hourly_rate'),
				'notes' => $this->input->post('notes'),
				'is_portalLogon' => $this->input->post('chbPortal'),
				'userName' => $this->input->post('userName'),
				'password' => $this->input->post('password'),
				'is_adminAccess' => $this->input->post('chbAdmin'),
			);
		$this->staff->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->staff->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

}
