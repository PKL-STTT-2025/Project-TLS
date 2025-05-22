<?php
class Supervisor_model extends CI_Model
{
    public function getCheckingTime()
    {
        $query = "SELECT
            id_transaksi_checking_detail AS id_detail,
            id_transaksi_checking,
            line_name,
            style,
            kode_orc,
            nama_proses,
            kode_proses,
            id_defect,
            jumlah
        FROM transaksi_checking_detail
        ORDER BY id_transaksi_checking_detail DESC;

        ";

        return $this->db->query($query)->result_array();
    }
    public function getLimitedEmployee($limit = 1)
    {
        $this->db->select('*');
        $this->db->from('mstemp');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }
    public function getLimitedOperation($limit = 10)
    {
        $this->db->select('*');
        $this->db->from('master_opt_layout');
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

    public function getDefectsPerOperation($limit = 1)
    {
        $this->db->select('*');
        $this->db->from('master_defect');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function getAction($limit = 10)
    {
        $this->db->select('
        d.deskripsi_defect,
        m.jumlah as jumlah_defect
    ');
        $this->db->from('master_defect d');
        $this->db->join('transaksi_checking_detail m', 'm.id_transaksi_checking_detail = m.jumlah', 'left');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
}
