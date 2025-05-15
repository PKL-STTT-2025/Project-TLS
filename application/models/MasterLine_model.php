<?php


class MasterLine_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllLine()
    {

        $query = "SELECT
            mstworkgroup.Workgroup AS line_name,
            master_line.spv
            FROM master_line 
            JOIN mstworkgroup ON CAST(master_line.line_name AS UNSIGNED) = mstworkgroup.idWG";
        return $this->db->query($query)->result();
    }
    public function cariMasterLine()
    {
        $keyword = $this->input->post('keyword');
        $this->db->like('spv', $keyword);

        return $this->db->get('master_line')->result();
    }
}
