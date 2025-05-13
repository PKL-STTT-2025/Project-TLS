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
    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Searches for master line entries in the database where the 'name' field
     * matches the given keyword. The keyword is retrieved from a POST request.
     * 
     * @return array An array of matched records from the 'master_user' table.
     */

    /*******  826ea303-4eec-4e53-a0f1-5c8f1bfd75d9  *******/
    public function cariMasterLine()
    {
        $keyword = $this->input->post('keyword');
        $this->db->like('name', $keyword);

        return $this->db->get('master_user')->result_array();
    }
}
