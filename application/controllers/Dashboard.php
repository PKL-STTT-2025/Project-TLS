<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_Session $session
 */
class Dashboard extends CI_Controller
{

    public function index()
    {

        $role = $this->session->userdata('role');
        $data['title'] = 'Dashboard TLS';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');

        if ($role == 'admin') {
            $this->load->view('Dashboard_Realtime/admin/index');
        } elseif ($role == 'qc') {
            $this->load->view('Dashboard_Realtime/qcinline/index');
        } elseif ($role == 'supervisor') {
            $this->load->view('Dashboard_Realtime/supervisor/index');
        }
        $this->load->view('templates/footer');
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
}
