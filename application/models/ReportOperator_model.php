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
        //     $query = "
        //     SELECT DISTINCT ml.id, wg.Workgroup AS line_name
        //     FROM operation_breakdown ob
        //     JOIN master_line ml ON ob.id_line = ml.id
        //     JOIN mstworkgroup wg ON ml.line_name = wg.idWG
        //     ORDER BY wg.Workgroup ASC
        // ";
        //     return $this->db->query($query)->result();
    }

    public function getAllStyles()
    {
        $query = $this->db->get('operation_breakdown');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
        //     $query = "
        //     SELECT DISTINCT ob.id, ob.style 
        //     FROM operation_breakdown ob
        //     ORDER BY ob.style ASC
        // ";
        //     return $this->db->query($query)->result();
    }


    public function getFilteredReport($line, $style)
    {

        $styleOnly = explode(' | ', $style)[0];

        $query = "
    SELECT mol.*, ob.style, ml.line_name, wg.Workgroup,
           mol.id_employee,
           emp.name AS operator_name,
           jb.name AS nama_mesin,
           mol.op_code AS kode_proses
    FROM master_opt_layout mol
    JOIN operation_breakdown ob ON mol.id_opb = ob.id
    JOIN master_line ml ON ml.id = ob.id_line
    JOIN mstworkgroup wg ON wg.idWG = ml.line_name
    LEFT JOIN mstemp emp ON emp.empID = mol.id_employee
    LEFT JOIN jns_barang jb ON jb.id_jnsbarang = mol.id_machine
    WHERE ml.id = ? -- ambil line dari master_line.id
      AND ob.style = ?
      AND mol.date_deleted IS NULL
    ";

        $result = $this->db->query($query, [$line, $styleOnly]);
        return $result->result();
    }


    public function getStyleByLine($Workgroup)
    {
        $query = "SELECT
                t1.id AS id_operation_breakdown,
                t1.style,
                t1.date_created,
                mstWorkgroup.Workgroup,
                mstWorkgroup.idWG AS id_master_workgroup
            FROM 
                operation_breakdown AS t1
            JOIN master_line ON master_line.id = t1.id_line
            JOIN mstWorkgroup ON mstWorkgroup.idWG = master_line.line_name
            WHERE  mstWorkgroup.idWG = $Workgroup
            ORDER BY t1.date_created DESC;";

        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getLineName($idWG)
    {
        $this->db->select('Workgroup');
        $this->db->from('mstworkgroup');
        $this->db->where('idWG', $idWG);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->Workgroup;
        } else {
            return null;
        }
    }

    public function getOpbByLineAndStyle($line, $style, $Workgroup)
    {
        $sql = "SELECT 
                t1.id AS id_operation_breakdown,
                t1.style,
                t1.date_created,
                mstWorkgroup.Workgroup,
                mstWorkgroup.idWG AS id_master_workgroup
            FROM operation_breakdown AS t1
            JOIN master_line ON master_line.id = t1.id_line
            JOIN mstWorkgroup ON mstWorkgroup.idWG = master_line.line_name
            WHERE mstWorkgroup.idWG = ?
              AND t1.id_line = ?
              AND t1.style = ?
              AND t1.parent_id IS NULL
            ORDER BY t1.date_created DESC
            LIMIT 1";

        $query = $this->db->query($sql, array($Workgroup, $line, $style));

        if ($query->num_rows() > 0) {
            return $query->row(); // hasil objek row
        } else {
            return null;
        }
    }




    public function get_data_operator($id_opb)
    {
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

    public function get_operator($id_employee, $id_opb)
    {
        $query = "SELECT
        master_opt_layout.id_employee,
        mstemp.name AS operator_name,
        jns_barang.name AS nama_mesin,
        master_opt_layout.op_code AS kode_proses
        FROM master_opt_layout
        JOIN mstemp ON master_opt_layout.id_employee = mstemp.empID
        JOIN jns_barang ON master_opt_layout.id_machine = jns_barang.id_jnsbarang
        WHERE master_opt_layout.id_employee = ? AND master_opt_layout.id_opb = ?";
        return $this->db->query($query, [$id_employee, $id_opb])->result_array();
    }

    public function get_defect_operator($id_employee, $id_opb)
    {
        $query = "SELECT
        transaksi_checking_detail.id_defect,
        transaksi_checking_detail.id_transaksi_checking,
        master_defect.deskripsi_defect
        FROM transaksi_checking_detail
        JOIN master_defect ON transaksi_checking_detail.id_defect = master_defect.id
        JOIN transaksi_checking ON transaksi_checking_detail.id_transaksi_checking = transaksi_checking.id_transaksi_checking
        JOIN master_opt_layout ON transaksi_checking.id_layout = master_opt_layout.id
        WHERE master_opt_layout.id_employee = ? AND master_opt_layout.id_opb = ?";
        return $this->db->query($query, [$id_employee, $id_opb])->result_array();
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
