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
}
