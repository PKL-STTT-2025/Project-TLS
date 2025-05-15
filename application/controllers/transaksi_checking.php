<!-- 
<?php

class TransaksiChecking extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('TransaksiChecking_model');
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = 'Transaksi Checking';
        $data['transaksi_checking'] = $this->TransaksiChecking_model->getAllTransaksiChecking();
        // if ($this->input->post('keyword')) {
        //     $data['TransaksiChecking'] = $this->transaksi_checking_model->cariTransaksiChecking();
    
        // digunakan untuk menampilkan data style dan line
        $data['line_list'] = $this->TransaksiChecking_model->getAlllines();
        // $data['style_list'] = $this->transaksi_checking_model->getAllStyles();

         // Jika user sudah pilih Line dan klik Search
        if ($this->input->post('Workgroup')) {
            $line = $this->input->post('Workgroup');
            $style = $this->input->post('style');

            // filter di model berdasarkan Line dan Style
            $data['transaksi_checking'] = $this->TransaksiChecking_model->getFilteredTransaksi($line, $style);
        } elseif ($this->input->post('keyword')) {
            $data['transaksi_checking'] = $this->TransaksiChecking_model->cariTransaksiChecking();
        } else {
            // Awalnya kosong
            // $data['transaksi_checking'] = [];
        }

        $this->load->view('templates/header', $data);
        $this->load->view('TransaksiChecking/index', $data);
        $this->load->view('templates/footer');
    }

    public function getStyleByLine()
    {   
        // masih bingung yang ini  (workgroup)sama style
        $Workgroup = (int)$this->input->post('Workgroup');

        // var_dump((int)$Workgroup);
        // die;

        $response = $this->TransaksiChecking_model->getStyleByLine($Workgroup);
        echo json_encode($response); 
    }


    // public function getlayoutbyline()
    // {
    //     $line = $this->input->post('Workgroup');
    //     $data['mstworkgroups'] = $this->transaksi_checking_model->getLayoutByLine($line);
    //     echo json_encode($data);
    // }

    // public function getOperatorCodeByLine()
    // {   
    //     // masih bingung yang ini  (workgroup)sama style
    //     $operation_code = (int)$this->input->post('operation_code');

    //     // var_dump((int)$Workgroup);
    //     // die;

    //     $response = $this->transaksi_checking_model->getOperatorCodeByNine($operation_code);
    //     echo json_encode($response); 
    // }

    public function tambah ()
    {
        $data['judul'] = 'Form Tambah Data Input Defect';
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('operation_code', 'Operation code', 'required');
        $this->form_validation->set_rules('kode_defect', 'Kode Defect', 'required');
        $this->form_validation->set_rules('deskripsi_defect', 'Deskripsi Defect', 'required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');
        $this->form_validation->set_rules('empID', 'Operator', 'required'); 
    
        // Data untuk dropdown
        $data['operators'] = $this->TransaksiChecking_model->getAllMasterEmployee();
        // echo '<pre>'; print_r($data['operators']); die;
        $data['operation_code'] = $this->TransaksiChecking_model->getAllOperationCode();
        $data['defect_list'] = $this->TransaksiChecking_model->getAllDefect();
        
        
        
        if($this->form_validation->run()==FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('TransaksiChecking/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $data =[
                'empID'=>$this->input->post('empID'),
                'employee_name'=>$this->input->post('employee_name'),
                'operation_code'=>$this->input->post('operation_code'),
                'operation_name'=>$this->input->post('operation_name'),
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

        $data['TransaksiChecking'] = $this->transaksi_checking_model->getTransaksiById($id);
        $this->load->view('templates/header', $data);
        $this->load->view('TransaksiChecking/detail', $data);
        $this->load->view('templates/footer');
    }

    // public function ubah($id)
    // {
    //     $data['judul'] = 'Form Ubah Data Input Defect';
    //     $data['jurusan'] = ['Teknik Informatika', 'Teknik Mesin', 'Teknik Industri'];
    //     $data['transaksi_checking'] = $this->transaksi_checking_model->getTransaksiById($id); 

    //     if (empty($data['transaksi_checking'])) {
    //         show_404();
    //     }

    //     $this->form_validation->set_rules('operation_name','Operation Name', 'required');
    //     $this->form_validation->set_rules('operation_code', 'Operation Code', 'required');
    //     $this->form_validation->set_rules('employee_name', 'Employee Name', 'required');

    //     if ($this->form_validation->run() == FALSE) {
    //         $this->load->view('templates/header', $data);
    //         $this->load->view('transaksi_checking/ubah', $data);
    //         $this->load->view('templates/footer');
    //     } else {
    //         $this->transaksi_checking_model->ubahDataInputDefect();
    //         $this->session->set_flashdata('flash', 'Diubah');
    //         redirect('TransaksiChecking');
    //     }
    // }
} -->
