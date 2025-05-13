<?php


class OperationBreakdown_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllLine()
    {
        $query = $this->db->get('operation_breakdown');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    public function cariOPB()
    {
        $keyword = $this->input->post('keyword');
        $this->db->like('name', $keyword);

        return $this->db->get('operation_breakdown')->result_array();
    }
}
