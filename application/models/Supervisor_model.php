<?php
class Supervisor_model extends CI_Model
{
    public function getCheckingTime()
    {
        $this->db->select('
        tcd.*, 
        wg.Workgroup AS line_name, 
        ob.style AS style
    ');
        $this->db->from('transaksi_checking_detail tcd');
        $this->db->join('transaksi_checking tc', 'tc.id_transaksi_checking = tcd.id_transaksi_checking');
        $this->db->join('mstworkgroup wg', 'wg.idWG = tc.id_wg', 'left');
        $this->db->join('operation_breakdown ob', 'ob.id = tc.id_opb', 'left');
        $this->db->order_by('tcd.id_transaksi_checking_detail', 'DESC');
        return $this->db->get()->result_array();
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

    public function getDefectsPerOperation($limit = 3)
    {
        $this->db->select('*');
        $this->db->from('master_defect');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
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

    public function getAction($limit = 10)
    {
        $this->db->select('
        d.deskripsi_defect,
        SUM(m.id_defect) as jumlah_defect
    ');
        $this->db->from('master_defect d');
        $this->db->join('transaksi_checking_detail m', 'm.id_defect = d.id', 'left');
        $this->db->group_by('d.id');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
}
