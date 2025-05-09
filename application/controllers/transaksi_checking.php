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
        // if ($this->input->post('keyword')) {
        //     $data['transaksi_checking'] = $this->transaksi_checking_model->cariTransaksiChecking();
    
        // digunakan untuk menampilkan data style dan line
        $data['line_list'] = $this->transaksi_checking_model->getAlllines();
        $data['style_list'] = $this->transaksi_checking_model->getAllStyles();

         // Jika user sudah pilih Line dan klik Search
        if ($this->input->post('Workgroup')) {
            $line = $this->input->post('Workgroup');
            $style = $this->input->post('style');

            // filter di model berdasarkan Line dan Style
            $data['transaksi_checking'] = $this->transaksi_checking_model->getFilteredTransaksi($line, $style);
        } elseif ($this->input->post('keyword')) {
            $data['transaksi_checking'] = $this->transaksi_checking_model->cariTransaksiChecking();
        } else {
            // Awalnya kosong
            $data['transaksi_checking'] = [];
        }

        $this->load->view('templates/header', $data);
        $this->load->view('transaksi_checking/index', $data);
        $this->load->view('templates/footer');
    }

    // public function getlayoutbyline()
    // {
    //     $line = $this->input->post('Workgroup');
    //     $data['mstworkgroups'] = $this->transaksi_checking_model->getLayoutByLine($line);
    //     echo json_encode($data);
    // }

    public function tambah ()
    {
        $data['judul'] = 'Form Tambah Data Input Defect';
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('kode_defect','Kode_Defect', 'required');
        $this->form_validation->set_rules('deskripsi_defect', 'Deskripsi_Defect', 'required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');

        if($this->form_validation->run()==FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('transaksi_checking/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $data =[
                'kode_defect'=>$this->input->post('kode_defect'),
                'deskripsi_defect'=>$this->input->post('deskripsi_defect'),
                'kategori'=>$this->input->post('kategori'),
            ] ;
            $this->transaksi_checking_model->tambahDataInputDefect($data);
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('transaksi_checking');
        }
    }
}
