<?php

class Operation_Layout_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllOperationLayout()
    {
        $query = $this->db->get('master_opt_layout');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array(); 
        }
    }
    public function cariOperationLayout()
    {
    $keyword = $this->input->post('keyword', true);
    $this->db->like('op_name', $keyword);
    return $this->db->get('master_opt_layout')->result_array();
    }
}