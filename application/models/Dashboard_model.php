<?php
class Dashboard_model extends CI_Model
{

    private function get_count_by_status($start_date, $end_date)
    {
        $this->db->select('status, COUNT(*) as jumlah');
        $this->db->where("DATE(waktu_update) >=", $start_date);
        $this->db->where("DATE(waktu_update) <=", $end_date);
        $this->db->group_by('status');
        return $this->db->get('dashboard')->result();
    }

    public function get_harian()
    {
        $today = date('Y-m-d');
        $this->db->select('status, COUNT(*) as jumlah');
        $this->db->where("DATE(waktu_update) >=", $today);
        return $this->get_count_by_status($today, $today);
    }

    public function get_mingguan()
    {
        $start = date('Y-m-d', strtotime('monday this week'));

        $end = date('Y-m-d', strtotime('sunday this week'));
        return $this->get_count_by_status($start, $end);
    }

    public function get_bulanan()
    {
        $start = date('Y-m-01');
        $end = date('Y-m-t');
        return $this->get_count_by_status($start, $end);
    }

    public function get_data_operator()
    {
        // $this->db->select('NIK, name');
        // $this->db->from('mstemp');
        // return $this->db->get()->result();

        $query = "SELECT
            master_opt_layout.id_employee,
            mstemp.name AS operator_name,
            jns_barang.name AS nama_mesin,
            master_opt_layout.op_code AS kode_proses
        FROM master_opt_layout
        JOIN mstemp ON master_opt_layout.id_employee = mstemp.empID
        JOIN jns_barang ON master_opt_layout.id_machine = jns_barang.id_jnsbarang
        WHERE master_opt_layout.id_opb = 192;";

        return $this->db->query($query)->result();
    }

    public function get_operator()
    {
        $id_employee = 4373;
        $id_opb = 192;
        $query = "SELECT
        master_opt_layout.id_employee,
        mstemp.name AS operator_name,
        jns_barang.name AS nama_mesin,
        master_opt_layout.op_code AS kode_proses
        FROM master_opt_layout
        JOIN mstemp ON master_opt_layout.id_employee = mstemp.empID
        JOIN jns_barang ON master_opt_layout.id_machine = jns_barang.id_jnsbarang
        WHERE master_opt_layout.id_employee = ? AND master_opt_layout.id_opb = ?
        LIMIT 1";
        return $this->db->query($query, [$id_employee, $id_opb = 192])->row();
    }

    public function get_defect_operator()
    {
        $id_employee = 4373;
        $id_opb = 192;
        $query = "SELECT
        transaksi_checking_detail.id_defect,
        transaksi_checking_detail.id_transaksi_checking,
        master_defect.deskripsi_defect
        FROM transaksi_checking_detail
        JOIN master_defect ON transaksi_checking_detail.id_defect = master_defect.id
        JOIN transaksi_checking ON transaksi_checking_detail.id_transaksi_checking = transaksi_checking.id_transaksi_checking
        JOIN master_opt_layout ON transaksi_checking.id_layout = master_opt_layout.id
        WHERE master_opt_layout.id_employee = ? AND master_opt_layout.id_opb = ?
        LIMIT 1";
        return $this->db->query($query, [$id_employee, $id_opb = 192])->row();
    }
}
