<?php

class Jenis_Barang_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllJenisBarang()
    {
        $query = $this->db->get('jns_barang');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array(); 
        }
    }
    public function cariDataJenisBarang()
    {
    $keyword = $this->input->post('keyword', true);
    $this->db->like('name', $keyword);
    return $this->db->get('jns_barang')->result_array();
    }
}