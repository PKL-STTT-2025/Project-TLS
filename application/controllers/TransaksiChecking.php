<?php

class TransaksiChecking extends CI_Controller
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
        //     $data['TransaksiChecking'] = $this->transaksi_checking_model->cariTransaksiChecking();
    
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
            $data['TransaksiChecking'] = [];
        }

        $this->load->view('templates/header', $data);
        $this->load->view('transaksi_checking/index', $data);
        $this->load->view('templates/footer');
    }

        public function get_style_by_line()
    {
        $line = $this->input->post('Workgroup');
        $this->load->model('transaksi_checking_model');
        $data = $this->transaksi_checking_model->getStyleByLine($line);
        echo json_encode($data);
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

        $data['op_code'] = $this->transaksi_checking_model->getAllOperationCode();
        
        $this->form_validation->set_rules('operation_code','Operation code', 'required');
        $this->form_validation->set_rules('kode_defect', 'Kode Defect', 'required');
        $this->form_validation->set_rules('deskripsi_defect', 'Deskripsi Defect ', 'required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');

        if($this->form_validation->run()==FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('transaksi_checking/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $data =[
                'operation_code'=>$this->input->post('operation_code'),
                'kode_defect'=>$this->input->post('kode_defect'),
                'deskripsi_defect'=>$this->input->post('deskripsi_defect'),
                'kategori'=>$this->input->post('kategori'),
            ] ;
            $this->transaksi_checking_model->tambahDataInputDefect($data);
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('TransaksiChecking');
        }
    }

    public function hapus ($id)
    {
        $this->transaksi_checking_model->hapusDataInputDefect($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('TransaksiChecking');
    }

    public function detail ($id)
    {
        $data ['judul']= 'Detail Data Input Defect';

        $data['transaksi_checking'] = $this->transaksi_checking_model->getTransaksiById($id);
        $this->load->view('templates/header', $data);
        $this->load->view('transaksi_checking/detail', $data);
        $this->load->view('templates/footer');
    }

    public function ubah($id)
    {
        $data['judul'] = 'Form Ubah Data Input Defect';
        $data['jurusan'] = ['Teknik Informatika', 'Teknik Mesin', 'Teknik Industri'];
        $data['transaksi_checking'] = $this->transaksi_checking_model->getTransaksiById($id); 

        if (empty($data['transaksi_checking'])) {
            show_404();
        }

        $this->form_validation->set_rules('operation_name','Operation Name', 'required');
        $this->form_validation->set_rules('operation_code', 'Operation Code', 'required');
        $this->form_validation->set_rules('employee_name', 'Employee Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('transaksi_checking/ubah', $data);
            $this->load->view('templates/footer');
        } else {
            $this->transaksi_checking_model->ubahDataInputDefect();
            $this->session->set_flashdata('flash', 'Diubah');
            redirect('TransaksiChecking');
        }
    }
}
