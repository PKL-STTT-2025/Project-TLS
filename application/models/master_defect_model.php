<?php

class master_defect_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllDefects()
    {   
        return $this->db->get('master_defect')->result_array();
        // $query = $this->db->get('master_defect');
        // if ($query->num_rows() > 0) {
        //     return $query->result_array();
        // } else {
        //     return array(); 
        // }
    }
    public function findDefects()
    {
    $keyword = $this->input->post('keyword', true);
    $this->db->like('kategori', $keyword);
    return $this->db->get('master_defect')->result_array();
    }
}