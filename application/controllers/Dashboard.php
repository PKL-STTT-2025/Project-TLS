<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function index()
    {
        $data['title'] = 'Dashboard TLS';
        $this->load->view('Dashboard_Realtime/index.php', $data);
    }

    public function reportHari()
    {
        $data['judul'] = 'Report Per Hari';
        $data['hari'] = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $data['jumlah'] = [5, 8, 3, 10, 6, 2, 4];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('Dashboard_Realtime/report_hari', $data);
        $this->load->view('templates/footer');
    }

    public function reportMinggu()
    {
        $this->load->view('Dashboard_Realtime/report_minggu');
    }

    public function reportBulan()
    {
        $this->load->view('Dashboard_Realtime/report_bulan');
    }
}
