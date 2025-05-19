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
    public function getFilteredReportDefect($line, $style)
    {
        $this->db->where('Workgroup', $line);
        $this->db->where('style', $style);
        $query = $this->db->get('mstworkgroup');
        return $query->result_array();
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

    public function get_harian($line = null)
    {
        $today = date('Y-m-d');
        return $this->get_count_by_status($today, $today, $line);
    }

    public function get_mingguan($line = null)
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

    public function getStyleByLine($Workgroup)
    {
        // $this->db->select('DISTINCT(style)');
        // $this->db->from('operation_breakdown');
        // $this->db->where('style IS NOT NULL');
        // $this->db->where('style', $style);
        // return $this->db->get()->row_array();

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
}
