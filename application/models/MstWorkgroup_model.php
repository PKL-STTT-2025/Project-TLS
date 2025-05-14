<?php

class MstWorkgroup_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllLine()
    {
        $query = $this->db->get('mstworkgroup');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    public function cariWG()
    {
        $keyword = $this->input->post('keyword');
        $this->db->like('Workgroup', $keyword);

        return $this->db->get('mstworkgroup')->result_array();
    }
}
