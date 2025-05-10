<?php

class transaksi_checking_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllTransaksiChecking()
    {
        $query = $this->db->get('transaksi_checking');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array(); 
        }
    }
    public function cariTransaksiChecking()
    {
    $keyword = $this->input->post('keyword', true);
    $this->db->like('op_name', $keyword);
    return $this->db->get('transaksi_checking')->result_array();
    }

    public function getAlllines()
    {
        $query = $this->db->get('mstworkgroup');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array(); 
        }
    }
   
    public function getAllStyles()
    {
        $query = $this->db->get('operation_breakdown');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array(); 
        }
    }

    // public function getlayoutbyline($line)
    // {
    //     $this->db->where('line_name', $line);
    //     $query = $this->db->get('mstworkgroup');
    //     if ($query->num_rows() > 0) {
    //         return $query->result_array();
    //     } else {
    //         return array(); 
    //     }
    // }

    public function getFilteredTransaksi($line, $style)
    {
        $this->db->where('Workgroup', $line);
        $this->db->where('style', $style);
        $query = $this->db->get('mstworkgroup');
        return $query->result_array();

        
//     $layout = $this->db
//     ->where('Workgroup', $line)
//     ->get('mstworkgroup')
//     ->result_array();

// $style_data = $this->db
//     ->where('style', $style)
//     ->get('operation_breakdown')
//     ->result_array();

// // Gabung manual kalau perlu
// return [
//     'layout' => $layout,
//     'style_data' => $style_data
// ];
    }

    public function tambahinputdefect ($data)
    {
        $this->db->insert('transaksi_checking', $data);
    }
    

}