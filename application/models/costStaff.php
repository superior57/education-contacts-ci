<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CostStaff_model extends CI_Model {

	public function __construct()
{
    parent::__construct();
}

function getAllGroups()
{
    $query = $this->db->query('SELECT description FROM location');
    return $this->db->query($query)->result();
}


}
