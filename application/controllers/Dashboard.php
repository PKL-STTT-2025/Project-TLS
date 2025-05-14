<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_session $session
 * @property CI_Dashboard_model $Dashboard_model
 * @property CI_Dashboard_Realtime $Dashboard_Realtime
 */
class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }


    public function index()
    {

        // Menentukan role pengguna
        $role = $this->session->userdata('role_id');
        $data['title'] = 'Dashboard TLS';

        if ($role == 'admin') {
            $this->admin();
        } elseif ($role == 'qc') {
            $this->qcinline();
        } elseif ($role == 'supervisor') {
            $this->supervisor();
        } else {
            // Handle invalid role if needed
            show_404();
        }
    }

    public function admin()
    {
        $data['title'] = 'Dashboard TLS';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('Dashboard_Realtime/admin/index');
        $this->load->view('templates/footer');
    }

    public function supervisor()
    {
        $data['title'] = 'Dashboard TLS';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('Dashboard_Realtime/supervisor/index');
        $this->load->view('templates/footer');
    }

    public function qcinline()
    {
        $data['title'] = 'Dashboard TLS';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('Dashboard_Realtime/qcinline/index');
        $this->load->view('templates/footer');
    }

    public function reportHari()
    {
        // Mengambil data untuk laporan hari
        $data['report_hari'] = $this->Dashboard_model->get_daily_report();
        $this->load->view('Dashboard_Realtime/report_hari', $data);
    }

    public function reportMinggu()
    {
        // Mengambil data untuk laporan minggu
        $data['report_minggu'] = $this->Dashboard_model->get_mingguan();
        $this->load->view('Dashboard_Realtime/report_minggu', $data);
    }

    public function reportBulan()
    {
        // Mengambil data untuk laporan bulan
        $data['report_bulan'] = $this->Dashboard_model->get_bulanan();
        $this->load->view('Dashboard_Realtime/report_bulan', $data);
    }

    public function traffic_light()
    {
        $data['title'] = 'Data Operator per Line';
        $data['operators'] = $this->Dashboard_model->get_data_operator();
        $data['latest_defect'] = $this->Dashboard_model->get_defect_operator();
        $data['jumlah_kunjungan'] = $this->Dashboard_model->getJumlahKunjunganQC();

        // Menampilkan view traffic light
        $this->load->view('templates/header', $data);
        $this->load->view('Dashboard_Realtime/traffic_light', $data);
        $this->load->view('templates/footer');
    }
}
