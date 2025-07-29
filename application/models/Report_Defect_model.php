<?php
class Report_Defect_model extends CI_Model
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

    public function cariReportDefect()
    {
        $keyword = $this->input->post('keyword', true);
        $this->db->like('op_name', $keyword);
        return $this->db->get('transaksi_checking')->result_array();
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
            JOIN master_line ON master_line.id = t1.id_line
            JOIN mstWorkgroup ON mstWorkgroup.idWG = master_line.line_name
            JOIN transaksi_checking ON transaksi_checking.id_opb = t1.id
            WHERE mstWorkgroup.idWG = $Workgroup
            GROUP BY t1.id
            ORDER BY t1.date_created DESC;";

        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function getFilteredReportDefect($line, $style)
    {
        $this->db->where('Workgroup', $line);
        $this->db->where('style', $style);
        $query = $this->db->get('mstworkgroup');
        return $query->result_array();
    }

    public function getTotalDefectPerDay($line, $style)
    {
        $this->db->select_sum('transaksi_defect.jumlah');
        $this->db->from('transaksi_defect');
        $this->db->join('transaksi_checking_detail', 'transaksi_checking_detail.id_transaksi_checking_detail = transaksi_defect.id_transaksi_checking_detail');
        $this->db->join('transaksi_checking', 'transaksi_checking.id_transaksi_checking = transaksi_checking_detail.id_transaksi_checking');
        $this->db->join('mstworkgroup', 'mstworkgroup.idWG = transaksi_checking.id_wg');
        $this->db->join('operation_breakdown', 'operation_breakdown.id = transaksi_checking.id_opb');

        $this->db->where('mstworkgroup.idWG', $line); // nama line
        $this->db->where('operation_breakdown.id', $style); // nama style
        $this->db->where('DATE(transaksi_checking.date_created)', date('Y-m-d'));

        $query = $this->db->get();
        return $query->row()->jumlah ?? 0;
    }

    public function get_count_by_status($start_date, $end_date, $line = null)
    {
        $this->db->select('DAYNAME(tanggal) as hari, COUNT(*) as jumlah');
        $this->db->where("DATE(tanggal) >=", $start_date);
        $this->db->where("DATE(tanggal) <=", $end_date);

        if ($line) {
            $this->db->where('line', $line);
        }

        $this->db->group_by('DAYNAME(tanggal)');
        return $this->db->get('transaksi_checking')->result();
    }

    public function getDefectByLineStyle($style, $id_wg)
    {

        $query = "SELECT 
            md.deskripsi_defect, 
            SUM(td.jumlah) AS total, 
            mwg.Workgroup, 
            ob.style 
        FROM 
            transaksi_defect td  
        JOIN 
            transaksi_checking_detail tcd ON td.id_transaksi_checking_detail = tcd.id_transaksi_checking_detail
        JOIN 
            transaksi_checking tc ON tcd.id_transaksi_checking = tc.id_transaksi_checking 
        JOIN 
            operation_breakdown ob ON ob.id = tc.id_opb 
        JOIN 
            master_line ml ON ob.id_line = ml.id 
        JOIN 
            mstworkgroup mwg ON ml.line_name = mwg.idWG 
        JOIN 
            master_defect md ON md.id = td.id_defect 
        WHERE 
            ob.id = ? 
            AND mwg.idWG = ? 
            AND DATE(tc.date_created) = ?
        GROUP BY 
           td.id_defect, md.deskripsi_defect
        ORDER BY 
            total DESC
    ";

        $result = $this->db->query($query, array($style, $id_wg));
        return $result->result_array();
    }

    public function getDefectMingguanByLineStyle($style, $id_wg)
    {
        $startDate = date('Y-m-d', strtotime('monday this week'));
        $endDate = date('Y-m-d', strtotime('sunday this week'));

        $query = "SELECT 
        md.deskripsi_defect, 
        SUM(td.jumlah) AS total, 
        mwg.Workgroup, 
        ob.style 
    FROM 
        transaksi_defect td 
    JOIN 
        transaksi_checking_detail tcd ON td.id_transaksi_checking_detail = tcd.id_transaksi_checking_detail 
    JOIN 
        transaksi_checking tc ON tcd.id_transaksi_checking = tc.id_transaksi_checking 
    JOIN 
        operation_breakdown ob ON ob.id = tc.id_opb 
    JOIN 
        master_line ml ON ob.id_line = ml.id 
    JOIN 
        mstworkgroup mwg ON ml.line_name = mwg.idWG 
    JOIN 
        master_defect md ON md.id = td.id_defect 
    WHERE 
        ob.id = ? 
        AND mwg.idWG = ? 
        AND DATE(tc.tanggal) BETWEEN ? AND ?
    GROUP BY 
        td.id_defect, md.deskripsi_defect, mwg.workgroup, ob.style 
    ORDER BY 
        total DESC";

        $result = $this->db->query($query, array($style, $id_wg, $startDate, $endDate));
        return $result->result_array();
    }

    // public function getStyleByLine($Workgroup)
    // {

    //     $query = "SELECT
    //             t1.id AS id_operation_breakdown,
    //             t1.style,
    //             t1.date_created,
    //             mstWorkgroup.Workgroup,
    //             mstWorkgroup.idWG AS id_master_workgroup
    //         FROM 
    //             operation_breakdown AS t1
    //         JOIN master_line ON master_line.id = t1.id_line
    //         JOIN mstWorkgroup ON mstWorkgroup.idWG = master_line.line_name
    //         WHERE  mstWorkgroup.idWG = $Workgroup
    //         ORDER BY t1.date_created DESC;";

    //     $result = $this->db->query($query);
    //     return $result->result_array();
    // }
}