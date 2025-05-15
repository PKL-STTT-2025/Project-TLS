<?php
class ReportOperator_model extends CI_Model
{

    public function getAllReportOperator()
    {
        $query = $this->db->get('transaksi_checking');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function cariReportOperator()
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
    public function getStylesByLine($line)
    {
        $this->db->select('style');
        $this->db->distinct();
        $this->db->where('Workgroup', $line);
        $query = $this->db->get('operation_breakdown');
        return $query->result_array();
    }


    public function getFilteredReport($line, $style)
    {
        $this->db->where('Workgroup', $line);
        $this->db->where('style', $style);
        $query = $this->db->get('mstworkgroup');
        return $query->result();
    }

    public function get_data_operator()
    {
        $id_opb = $this->input->post('id_opb');
        $query = "SELECT
            master_opt_layout.id_employee,
            mstemp.name AS operator_name,
            jns_barang.name AS nama_mesin,
            master_opt_layout.op_code AS kode_proses
        FROM master_opt_layout
        JOIN mstemp ON master_opt_layout.id_employee = mstemp.empID
        JOIN jns_barang ON master_opt_layout.id_machine = jns_barang.id_jnsbarang
        WHERE master_opt_layout.id_opb = ?;";

        return $this->db->query($query, [$id_opb])->result();
    }

    public function get_operator()
    {
        $id_opb = $this->input->post('id_opb');
        $query = "SELECT
        master_opt_layout.id_employee,
        mstemp.name AS operator_name,
        jns_barang.name AS nama_mesin,
        master_opt_layout.op_code AS kode_proses
        FROM master_opt_layout
        JOIN mstemp ON master_opt_layout.id_employee = mstemp.empID
        JOIN jns_barang ON master_opt_layout.id_machine = jns_barang.id_jnsbarang
        WHERE master_opt_layout.id_employee = ? AND master_opt_layout.id_opb = ?";
        return $this->db->query($query, [$id_opb])->result();
    }

    public function get_defect_operator()
    {
        $id_opb = $this->input->post('id_opb');
        $query = "SELECT
        transaksi_checking_detail.id_defect,
        transaksi_checking_detail.id_transaksi_checking,
        master_defect.deskripsi_defect
        FROM transaksi_checking_detail
        JOIN master_defect ON transaksi_checking_detail.id_defect = master_defect.id
        JOIN transaksi_checking ON transaksi_checking_detail.id_transaksi_checking = transaksi_checking.id_transaksi_checking
        JOIN master_opt_layout ON transaksi_checking.id_layout = master_opt_layout.id
        WHERE master_opt_layout.id_opb = ?";
        return $this->db->query($query, [$id_opb])->result();
    }

    public function getJumlahKunjunganQC()
    {
        $this->db->select('op_name, COUNT(*) as total_kunjungan');
        $this->db->from('transaksi_checking');
        $this->db->group_by('op_name');
        $query = $this->db->get();

        $result = $query->result();
        $output = [];
        foreach ($result as $row) {
            $output[$row->op_name] = $row->total_kunjungan;
        }
        return $output;
    }
}
