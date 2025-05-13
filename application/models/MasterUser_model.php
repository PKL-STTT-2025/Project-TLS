<?php


class MasterUser_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllMaster()
    {
        $query = $this->db->get('master_user');
        return $query->result_array();
    }
    public function cariMasterUser()
    {
        $keyword = $this->input->post('keyword');
        $this->db->like('nama', $keyword);
        return $this->db->get('master_user')->result_array();
    }
}
