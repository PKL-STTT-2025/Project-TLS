<?php

class transaksi_checking extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi_checking_model');
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = 'Transaksi Checking';
        $data['transaksi_checking'] = $this->transaksi_checking_model->getAllTransaksiChecking();
        if ($this->input->post('keyword')) {
            $data['transaksi_checking'] = $this->transaksi_checking_model->cariTransaksiChecking();
        }
        $this->load->view('templates/header', $data);
        $this->load->view('transaksi_checking/index', $data);
        $this->load->view('templates/footer');
    }
}