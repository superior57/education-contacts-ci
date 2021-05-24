<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CostStaff extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CostStaff_model');
    }
    public function index()
    {
        $data['title']= 'Warehouse - Delivery';
        $data['groups'] = $this->CostStaff_model->getAllGroups();
        
        //I take here a sample view, you can put more view pages here
        $this->load->view('costIndividualPlan',$data);
    }
}