<?php
class Supervisor_model extends CI_Model
{
    public function getsearchCheckingTime($keyword)
    {
        $query = "SELECT 
            tc.id_transaksi_checking,
            wg.Workgroup AS line_name,
            tc.masalah_selesai,
            ob.style AS style
            FROM transaksi_checking tc
            LEFT JOIN mstworkgroup wg ON wg.idWG = tc.id_wg
            LEFT JOIN operation_breakdown ob ON ob.id = tc.id_opb
            WHERE wg.Workgroup LIKE ?
            GROUP BY tc.id_transaksi_checking
            ORDER BY tc.id_transaksi_checking DESC";

        return $this->db->query($query, ["%$keyword%"])->result_array();
    }
    public function getCheckingTime()
    {
        $query = "SELECT 
            tc.id_transaksi_checking,
            tc.id_wg,
            wg.Workgroup AS line_name,
            tc.masalah_selesai,
            ob.style AS style
            FROM transaksi_checking tc
            LEFT JOIN mstworkgroup wg ON wg.idWG = tc.id_wg
            LEFT JOIN operation_breakdown ob ON ob.id = tc.id_opb
            GROUP BY tc.id_transaksi_checking
            ORDER BY tc.id_transaksi_checking DESC";

        return $this->db->query($query)->result_array();
    }
    public function getLimitedEmployee($id_transaksi_checking)
    {
        $this->db->select('transaksi_checking_detail.*, mstemp.name AS operator_name');
        $this->db->from('transaksi_checking_detail');
        $this->db->join('mstemp', 'transaksi_checking_detail.empID = mstemp.empID');
        $this->db->where('transaksi_checking_detail.id_transaksi_checking', $id_transaksi_checking);
        $this->db->group_by('transaksi_checking_detail.op_code');
        $this->db->order_by('transaksi_checking_detail.id_transaksi_checking_detail', 'ASC');
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }
    public function getLimitedOperation($limit = 10)
    {
        $this->db->select('*');
        $this->db->from('master_opt_layout');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }
    public function getLayoutWithMesin($id_transaksi_checking)
    {

        $query = "SELECT 
            d.op_code,
            d.op_name,
            jb.name AS nama_mesin,
            IFNULL(SUM(td.jumlah), 0) AS defect_count
        FROM transaksi_checking_detail d
        LEFT JOIN jns_barang jb ON jb.id_jnsbarang = d.id_jnsbarang
        LEFT JOIN transaksi_defect td ON td.id_transaksi_checking_detail = d.id_transaksi_checking_detail
        WHERE d.id_transaksi_checking = ?
        GROUP BY d.op_code
        ORDER BY defect_count DESC
    ";

        return $this->db->query($query, [$id_transaksi_checking])->result();
    }

    public function getDefectsPerOperation($id_transaksi_checking)
    {
        $query = "SELECT 
        tcd.op_name,
        td.id_transaksi_defect,
        td.id_transaksi_checking_detail,
        td.id_defect,
        md.deskripsi_defect,
        td.jumlah,
        td.note
    FROM 
        transaksi_defect td
    JOIN 
        master_defect md ON td.id_defect = md.id
    JOIN
        transaksi_checking_detail tcd ON td.id_transaksi_checking_detail = tcd.id_transaksi_checking_detail
    WHERE 
        tcd.id_transaksi_checking = $id_transaksi_checking
    ORDER BY tcd.op_name ASC
    ";
        return $this->db->query($query)->result_array();
    }

    public function searchActionPlan($keyword)
    {
        $query = "SELECT 
                td.id_transaksi_defect,
                td.id_transaksi_checking_detail,
                td.id_defect,
                md.deskripsi_defect,
                td.jumlah
            FROM 
                transaksi_defect td
            JOIN 
                master_defect md ON td.id_defect = md.id
            WHERE 
                md.deskripsi_defect LIKE ?
            ORDER BY 
                td.jumlah DESC, md.deskripsi_defect ASC";

        return $this->db->query($query, ["%$keyword%"])->result();
    }


    public function getAction($id_transaksi_checking)
    {
        $query = "SELECT 
                 md.deskripsi_defect,
                SUM(td.jumlah) AS jumlah
            FROM 
                transaksi_defect td
            JOIN 
                master_defect md ON td.id_defect = md.id
            JOIN 
                transaksi_checking_detail tcd ON td.id_transaksi_checking_detail = tcd.id_transaksi_checking_detail
            JOIN 
                transaksi_checking tc ON tcd.id_transaksi_checking = tc.id_transaksi_checking
            WHERE 
                tc.id_transaksi_checking = ?
            GROUP BY 
                md.deskripsi_defect
            ORDER BY 
                jumlah DESC, md.deskripsi_defect ASC";

        return $this->db->query($query, [$id_transaksi_checking])->result();
    }
}