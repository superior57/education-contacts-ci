<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usersmanage extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->helper('cias_helper');
		$this->load->model('Usersmanage_model','Usersmanage');
	}

	public function index()
	{
		$this->load->helper('url');	    
		$this->load->view('Usersmanage_view');
	}

	public function ajax_list()
	{
		$list = $this->Usersmanage->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $Usersmanage) {
			$no++;
			$row = array();
			$row[] = $Usersmanage->name;
			$row[] = $Usersmanage->email;
			$row[] = $Usersmanage->mobile;
			$row[] = $Usersmanage->role;
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_staff('."'".$Usersmanage->userId."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_staff('."'".$Usersmanage->userId."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Usersmanage->count_all(),
						"recordsFiltered" => $this->Usersmanage->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->Usersmanage->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_member($Usersmanage)
	{
		$data = $this->Usersmanage->get_by_member($Usersmanage);
		echo json_encode($data);
	}

	public function ajax_add()
	{

		$data = array(
				'name' => $this->input->post('user_name'),
				'email' => $this->input->post('email'),
				'password' => getHashedPassword($this->input->post('password')),
				'mobile' => $this->input->post('mobile'),
				'roleId' => $this->input->post('authority'),
			);
		if ($this->Usersmanage->is_by($this->input->post('email'))) {
			$this->Usersmanage->update(array('email' => $this->input->post('email')), $data);
		}else
				$insert = $this->Usersmanage->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{		
		if ( $this->input->post('password') == "" ) {
			$data = array(
			'name' => $this->input->post('user_name'),
			'email' => $this->input->post('email'),
			'mobile' => $this->input->post('mobile'),
			'roleId' => $this->input->post('authority'),
			);
		}
		else{
			$data = array(
			'name' => $this->input->post('user_name'),
			'email' => $this->input->post('email'),
			'password' => getHashedPassword($this->input->post('password')),
			'mobile' => $this->input->post('mobile'),
			'roleId' => $this->input->post('authority'),
			); }
			$this->Usersmanage->update(array('userId' => $this->input->post('id')), $data);
			echo json_encode(array("status" => TRUE)); 
	}

	public function ajax_delete($id)
	{
		$this->Usersmanage->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_staff_add()
	{

		$data = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('userName'),
				'password' => getHashedPassword($this->input->post('password')),
				'roleId' => $this->input->post('Admin'),
				'status' => $this->input->post('status'),
			);
		if ($this->Usersmanage->is_by($this->input->post('userName'))) {
			$this->Usersmanage->update(array('email' => $this->input->post('userName')), $data);
		}else
				$insert = $this->Usersmanage->save($data);
		echo json_encode(array("status" => TRUE));
	}


}
