<?php

class Jenis_Barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jenis_Barang_model');
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = 'Jenis Barang';
        $data['jns_barang'] = $this->Jenis_Barang_model->getAllJenisBarang();
        if ($this->input->post('keyword')) {
            $data['jns_barang'] = $this->Jenis_Barang_model->cariDataJenisBarang();
        }
        $this->load->view('templates/header', $data);
        $this->load->view('Jenis_Barang/index', $data);
        $this->load->view('templates/footer');
    }
}