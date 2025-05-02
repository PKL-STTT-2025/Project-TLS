<?php
class InputDefect_model extends CI_Model {

    public function get_layout_by_id($id_employee)
{
    $this->db->select('master_opt_layout.*, admin.nama_admin AS user');
    $this->db->from('master_opt_layout');
    $this->db->join('admin', 'admin.id_admin = master_opt_layout.id_employee', 'left');
    $this->db->where('master_opt_layout.id_employee', $id_employee);
    return $this->db->get()->row_array();
}

    
    public function getAllStyles() 
    {
        $this->db->select('DISTINCT(style)');
        $this->db->from('operation_breakdown');
        $this->db->join('mstworkgroup', 'mstworkgroup.Workgroup = operation_breakdown.style', 'left');
        $this->db->where('operation_breakdown.style IS NOT NULL');
        return $this->db->get()->result_array();
    }

    
    public function getAllORC() 
    {
        $this->db->select('DISTINCT(id_buyer) as orc');
        $this->db->from('operation_breakdown');
        return $this->db->get()->result_array();
    }

    
    public function getAlltransaksi() {
        return $this->db->get('transaksi_checking')->result_array();
    }

    public function getAlldefects() {
        return $this->db->get('master_defect')->result_array();
    }

    public function getAlllines() {
        return $this->db->distinct()->select('Workgroup')->get('mstworkgroup')->result_array();
    }

    public function get_layout_by_line($Workgroup) {
        return $this->db->get_where('mstworkgroup', ['Workgroup' => $Workgroup])->row_array();
    }

    public function insert_transaksi_checking($data) {
        $insert_data = [
            'id_layout' => $data['id_layout'],
            'id_user' => $data['id_user'],
            'op_code' => $data['op_code'],
            'op_name' => $data['op_name'],
            'employee_name' => $data['employee_name'],
            'machine_name' => $data['machine_name'],
            'ada_defect' => $data['ada_defect'] ?? 0,
            'masalah_selesai' => $data['masalah_selesai']
        ];
        $this->db->insert('transaksi_checking', $insert_data);
        return $this->db->insert_id();
    }

    public function insert_transaksi_checking_detail($data) {
        $this->db->insert('transaksi_checking_detail', $data);
    }

    public function get_transaksi_by_id($id) {
        return $this->db->get_where('transaksi_checking', ['id_transaksi_checking' => $id])->row_array();
    }

    public function get_detail_by_transaksi($id) {
        $this->db->select('td.*, md.nama_defect');
        $this->db->from('transaksi_checking_detail td');
        $this->db->join('master_defect md', 'md.id = td.id_defect');
        $this->db->where('td.id_transaksi_checking', $id);
        return $this->db->get()->result_array();
    }

    public function update_transaksi($id, $data) {
        $update_data = [
            'id_layout' => $data['id_layout'],
            'id_user' => $data['id_user'],
            'op_code' => $data['op_code'],
            'op_name' => $data['op_name'],
            'employee_name' => $data['employee_name'],
            'machine_name' => $data['machine_name'],
            'ada_defect' => $data['ada_defect'] ?? 0,
            'masalah_selesai' => $data['masalah_selesai']
        ];
        $this->db->where('id_transaksi_checking', $id);
        $this->db->update('transaksi_checking', $update_data);
    }

    public function delete_detail_by_transaksi($id) {
        $this->db->delete('transaksi_checking_detail', ['id_transaksi_checking' => $id]);
    }

    public function delete_transaksi($id) { 
        $this->db->delete('transaksi_checking', ['id_transaksi_checking' => $id]);
    }

    public function search_layout_by_line($keyword) {
        $this->db->like('Workgroup', $keyword);
        return $this->db->get('mstworkgroup')->result();
    }
    
    public function get_layout_by_Workgroup($Workgroup) {
        return $this->db->get_where('mstworkgroup', ['Workgroup' => $Workgroup])->row_array();
    }
    

    public function get_style_by_line($Workgroup) {
        $this->db->select('DISTINCT(style)');
        $this->db->from('operation_breakdown');
        $this->db->where('style IS NOT NULL');
        $this->db->where('style', $Workgroup);
        return $this->db->get()->row_array();
    }
    
    public function get_orc_by_line($Workgroup) {
        $this->db->select('DISTINCT(id_buyer) as orc');
        $this->db->from('operation_breakdown');
        $this->db->where('style', $Workgroup);
        return $this->db->get()->row_array();
    }
    
}

        