<?php
class Report_model extends CI_Model
{
    public function getAllReportDefect()
    {
        $query = $this->db->get('transaksi_checking');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function getAlllines()
    {
        $query = "SELECT DISTINCT
                mw.idWG,
                mw.Workgroup
            FROM 
                transaksi_checking tc
            JOIN operation_breakdown ob ON ob.id = tc.id_opb
            JOIN master_line ml ON ml.id = ob.id_line
            JOIN mstWorkgroup mw ON mw.idWG = ml.line_name
            ORDER BY mw.Workgroup ASC";

        $result = $this->db->query($query);
        return $result->result_array();
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
            JOIN
            master_line ON master_line.id = t1.id_line
            JOIN 
            mstWorkgroup ON mstWorkgroup.idWG = master_line.line_name
            JOIN 
            transaksi_checking ON transaksi_checking.id_opb = t1.id
            WHERE 
            mstWorkgroup.idWG = $Workgroup
            GROUP BY t1.id
            ORDER BY t1.date_created DESC;";

        $result = $this->db->query($query);
        return $result->result_array();
    }


    public function getReportOperator($id_opb, $id_wg)
    {
        $query = "SELECT 
                mol.op_name AS nama_proses,
                tcd.id_transaksi_checking_detail
            FROM master_opt_layout mol
            LEFT JOIN transaksi_checking_detail tcd ON mol.id = tcd.id_master_opt_layout
            LEFT JOIN transaksi_checking tc ON tc.id_transaksi_checking = tcd.id_transaksi_checking
            WHERE mol.date_deleted IS NULL
              AND mol.id_opb = ?
              AND (tc.id_wg = ? OR tc.id_wg IS NULL)
            ORDER BY mol.op_name ASC";
        return $this->db->query($query, array($id_opb, $id_wg))->result_array();
    }

    public function getOperatorByCheckingDetail($id_transaksi_checking_detail)
    {
        $query = "SELECT 
        e.name AS operator_name,  
        tcd.op_code AS kode_proses, 
        jb.name AS nama_mesin,
        tc.id_wg,
        tc.id_opb
        FROM transaksi_checking_detail tcd
        JOIN mstemp e ON e.empID = tcd.empID
        JOIN jns_barang jb ON jb.id_jnsbarang = tcd.id_jnsbarang
        JOIN transaksi_checking tc ON tc.id_transaksi_checking = tcd.id_transaksi_checking
        WHERE tcd.id_transaksi_checking_detail = ?";
        return $this->db->query($query, [$id_transaksi_checking_detail])->row();
    }
    public function getDefectHistory($id_transaksi_checking_detail)
    {
        $query = "SELECT md.deskripsi_defect, td.jumlah, td.note
              FROM transaksi_defect td
              JOIN master_defect md ON md.id = td.id_defect
              WHERE td.id_transaksi_checking_detail = ?";
        return $this->db->query($query, [$id_transaksi_checking_detail])->result();
    }
    public function getLatestDefect($id_transaksi_checking_detail)
    {
        $query = "SELECT 
                md.deskripsi_defect, 
                td.jumlah, 
                td.note,
                tcd.id_transaksi_checking
            FROM transaksi_defect td
            JOIN master_defect md ON md.id = td.id_defect
            JOIN transaksi_checking_detail tcd ON tcd.id_transaksi_checking_detail = td.id_transaksi_checking_detail
            WHERE td.id_transaksi_checking_detail = ?
            ORDER BY td.id_transaksi_defect DESC
            LIMIT 3";

        $defects = $this->db->query($query, [$id_transaksi_checking_detail])->result();

        // Urutkan lagi berdasarkan jumlah terbesar
        usort($defects, function ($a, $b) {
            return $b->jumlah - $a->jumlah;
        });

        return $defects;
    }
}