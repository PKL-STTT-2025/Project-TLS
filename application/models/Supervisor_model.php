<?php
class Supervisor_model extends CI_Model
{
    public function getCheckingTime()
    {
        $query = "
        SELECT
            id_transaksi_checking_detail AS id_detail,
            id_transaksi_checking,
            id_master_opt_layout,
            line_name,
            style,
            nama_proses,
            kode_proses,
            id_defect,
            jumlah
        FROM transaksi_checking_detail
        ORDER BY id_transaksi_checking_detail DESC;

        ";

        return $this->db->query($query)->result_array();
    }
    public function getLimitedEmployee($limit = 10)
    {
        $this->db->select('*');
        $this->db->from('mstemp'); // sesuaikan nama tabel
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }
    public function getLimitedOperation($limit = 10)
    {
        $this->db->select('*');
        $this->db->from('master_opt_layout'); // sesuaikan tabel
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }
    public function getLayoutWithMesin($limit = 10)
    {
        $this->db->select('
        l.op_code,
        l.op_name,
        m.name as nama_mesin
    ');
        $this->db->from('master_opt_layout l');
        $this->db->join('jns_barang m', 'm.id_jnsbarang = l.id_machine', 'left');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
}
