<?php
class Supervisor_model extends CI_Model
{
    public function getCheckingTime()
    {
        $query = "SELECT 
            tc.id_transaksi_checking,
            wg.Workgroup AS line_name,
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
            IFNULL(SUM(td.jumlah), 0) AS total_defect
        FROM transaksi_checking_detail d
        LEFT JOIN jns_barang jb ON jb.id_jnsbarang = d.id_jnsbarang
        LEFT JOIN transaksi_defect td ON td.id_transaksi_checking_detail = d.id_transaksi_checking_detail
        WHERE d.id_transaksi_checking = ?
        GROUP BY d.op_code
        ORDER BY total_defect DESC
    ";

        return $this->db->query($query, [$id_transaksi_checking])->result();
    }

    public function getDefectsPerOperation($id_transaksi_checking)
    {
        $query = "SELECT 
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
    ";
        return $this->db->query($query)->result_array();
    }

    // public function getDetail()
    // {
    // $query = "SELECT 
    //         tcd.*, 
    //         tc.id_wg, 
    //         wg.Workgroup AS line_name, 
    //         tc.id_opb, 
    //         ob.style AS style, 
    //         emp.name AS employee_name, 
    //         ml.op_name, 
    //         ml.op_code, 
    //         jb.name AS nama_mesin, 
    //         def.deskripsi_defect, 
    //         SUM(td.jumlah) AS defect_jumlah
    //     FROM transaksi_checking_detail tcd
    //     JOIN transaksi_checking tc 
    //         ON tc.id_transaksi_checking = tcd.id_transaksi_checking
    //     LEFT JOIN mstworkgroup wg 
    //         ON wg.idWG = tc.id_wg
    //     LEFT JOIN operation_breakdown ob 
    //         ON ob.id = tc.id_opb
    //     LEFT JOIN mstemp emp 
    //         ON emp.empID = tcd.empID
    //     LEFT JOIN master_opt_layout ml 
    //         ON ml.id = tcd.id_master_opt_layout
    //     LEFT JOIN jns_barang jb 
    //         ON jb.id_jnsbarang = tcd.id_jnsbarang
    //     LEFT JOIN transaksi_defect td 
    //         ON td.id_transaksi_checking_detail = tcd.id_transaksi_checking_detail
    //     LEFT JOIN master_defect def 
    //         ON def.id = td.id_defect
    //     ORDER BY tcd.id_transaksi_checking_detail DESC
    //     LIMIT 10
    // ";
    // return $this->db->query($query)->result_array();
    // }

    public function getAction()
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
                master_defect md ON td.id_defect = md.id";

        return $this->db->query($query)->result();
    }
}
