<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function index()
    {
        $data['title'] = 'Dashboard TLS';
        $this->load->view('templates/header', $data);
        // $this->load->view('templates/sidebar');
        $this->load->view('Dashboard_Realtime/index.php');
        $this->load->view('templates/footer');
    }

    public function reportHari()
    {
        $data['judul'] = 'Report Per Hari';
        $data['hari'] = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $data['jumlah'] = [5, 8, 3, 10, 6, 2, 4];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('Dashboard_Realtime/report_hari',);
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
<<<<<<< Updated upstream
=======

    public function traffic_light()
    {
        $data['title'] = 'Data Operator per Line';
        $data['operators'] = $this->Dashboard_model->get_data_operator();
        $data['latest_defect'] = $this->Dashboard_model->get_defect_operator();
        $this->load->view('templates/header', $data);
        $this->load->view('Dashboard_Realtime/traffic_light', $data);
        $this->load->view('templates/footer');
    }

    public function report_operator()
    {
        $data['title'] = 'Histori Defect Operator';
        $data['op'] = $this->Dashboard_model->get_operator();
        $data['defects'] = $this->Dashboard_model->get_defect_operator();
        $data['total_kunjungan'] = 5;
        $this->load->view('templates/header', $data);
        $this->load->view('Dashboard_Realtime/report_operator', $data);
        $this->load->view('templates/footer');
    }
>>>>>>> Stashed changes
}
