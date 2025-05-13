<?php


class MstEmp_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllLine()
    {
        $query = $this->db->get('mstemp');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    public function cariMstemp()
    {
        $keyword = $this->input->post('keyword');
        $this->db->like('name', $keyword);

        return $this->db->get('mstemp')->result_array();
    }
}
