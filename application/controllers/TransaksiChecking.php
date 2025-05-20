
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
        $data['TransaksiChecking'] = $this->TransaksiChecking_model->getAllTransaksiChecking();
        if ($this->input->post('keyword')) {
            $data['TransaksiChecking'] = $this->TransaksiChecking_model->cariTransaksiChecking();
        }
        // digunakan untuk menampilkan data style dan line
        $data['line_list'] = $this->TransaksiChecking_model->getAlllines();
        // $data['style_list'] = $this->transaksi_checking_model->getAllStyles();

        if($this->input->get('Workgroup'))  { 
            $data['selected_line'] = $this->input->get('Workgroup');
            $data['style_list'] = $this->TransaksiChecking_model->getStyleByLine($data['selected_line']);
        } 
        // $data['line_name'] = $this->TransaksiChecking_model->getLineById()

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

        // Validasi form
        $this->form_validation->set_rules('id_workgroup', 'Line', 'required');
        $this->form_validation->set_rules('id_style', 'Style', 'required');
        $this->form_validation->set_rules('empID', 'Employee ID', 'required');
        $this->form_validation->set_rules('employee_name', 'Employee Name', 'required');
        $this->form_validation->set_rules('op_name', 'Operation Name', 'required');
        $this->form_validation->set_rules('op_code', 'Operation code', 'required');
        $this->form_validation->set_rules('kode_defect', 'Kode Defect', 'required');
        $this->form_validation->set_rules('deskripsi_defect', 'Deskripsi Defect', 'required');
        $this->form_validation->set_rules('kategori_defect', 'Kategori', 'required');
    
        // Data untuk dropdown
        $data['operators'] = $this->TransaksiChecking_model->getAllMasterEmployee();
        // echo '<pre>'; print_r($data['operators']); die;
        $data['operation_name'] = $this->TransaksiChecking_model->getAllOperationCode();
        $data['defect_list'] = $this->TransaksiChecking_model->getAllDefect();
        
        // load data line dari url
        $id = $this->input->get('Workgroup'); 
        $data['line'] = $id;

        // $this->load->model('TransaksiChecking_model');
        $line = $this->TransaksiChecking_model->getById($id);

        $data['line_name'] = $line ? $line->Workgroup : '';
        $data['Workgroup'] = $line;
            
        
        // load data style dari url
        $id_style = $this->input->get('style');
        // var_dump($id_style); exit;
        $data['style'] = $id_style;    
        // $this->load->model('TransaksiChecking_model');
        $style = $this->TransaksiChecking_model->getStyleById($id_style);
        
        $data['style_name'] = $style ? $style->style : 'Style tidak ditemukan';
        $data['id_style'] = $id_style;
        
            
        
        if($this->form_validation->run()==FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('TransaksiChecking/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $data =[
                'id_workgroup'=>$this->input->post('id_workgroup'),
                'id_style'=>$this->input->post('id_style'),
                'empID'=>$this->input->post('empID'),
                'employee_name'=>$this->input->post('employee_name'),
                'operation_code'=>$this->input->post('operation_code'),
                'operation_name'=>$this->input->post('operation_name'),
                'kode_defect'=>$this->input->post('kode_defect'),
                'deskripsi_defect'=>$this->input->post('deskripsi_defect'),
                'kategori'=>$this->input->post('kategori'),
            ] ;
            $this->TransaksiChecking_model->tambahDataInputDefect($data);
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('TransaksiChecking');
        }
    }

    public function simpan()
    {
        $emp_data = $this->TransaksiChecking_model->getUserById($this->input->post('empID'));  
        $emp_name = isset($emp_data->name) ? $emp_data->name : '';
        $data = [
                'id_workgroup'      => $this->input->post('id_workgroup'),
                'id_style'          => $this->input->post('id_style'),
                'id_employee'       => $this->input->post('empID'), 
                'employee_name'     => $emp_name,
                'op_name'           => $this->input->post('op_name'),
                'op_code'           => $this->input->post('op_code'),
                'kode_defect'       => $this->input->post('kode_defect'), 
                'deskripsi_defect'  => $this->input->post('deskripsi_defect'),
                'kategori_defect'   => $this->input->post('kategori_defect'),
            ];
        
            // Optional: cek apakah semua data wajib sudah ada
            if (!$data['id_employee'] || !$data['kode_defect']) {
                $this->session->set_flashdata('error', 'Gagal menyimpan. Data wajib belum lengkap.');
                redirect('TransaksiChecking/tambah');
            }
        
            $this->TransaksiChecking_model->insert($data);
        
        
            $this->session->set_flashdata('success', 'Data berhasil disimpan!');
            redirect('TransaksiChecking');
     }

    public function hapus ($id)
    {
        $this->TransaksiChecking_model->hapusDataInputDefect($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('TransaksiChecking');
    }

    public function detail ($id)
    {
        $data ['judul']= 'Detail Data Input Defect';

        $data['transaksi_checking'] = $this->TransaksiChecking_model->getTransaksiById($id);
        $this->load->view('templates/header', $data);
        $this->load->view('TransaksiChecking/detail', $data);
        $this->load->view('templates/footer');
    }

    public function ubah($id)
    {
        $data['judul'] = 'Form Ubah Data Input Defect';
        $data['transaksi_checking'] = $this->TransaksiChecking_model->getTransaksiById($id); 
    
        if (empty($data['transaksi_checking'])) {
            show_404();
        }
    
        $data['operators'] = $this->TransaksiChecking_model->getAllMasterEmployee();
        $data['operation_name'] = $this->TransaksiChecking_model->getAllOperationCode();
        $data['defect_list'] = $this->TransaksiChecking_model->getAllDefect();
    
        $this->load->view('templates/header', $data);
        $this->load->view('TransaksiChecking/ubah', $data);
        $this->load->view('templates/footer');
    }
    
    public function update($id)
    {

        $this->form_validation->set_rules('id_workgroup', 'Workgroup', 'required');
        $this->form_validation->set_rules('id_style', 'Style', 'required');
        $this->form_validation->set_rules('empID', 'Employee', 'required');
        $this->form_validation->set_rules('employee_name', 'Employee Name', 'required');
        $this->form_validation->set_rules('op_name','Operation Name', 'required');
        $this->form_validation->set_rules('op_code', 'Operation Code', 'required');
        $this->form_validation->set_rules('deskripsi_defect', 'Deskripsi Defect', 'required');
        $this->form_validation->set_rules('kode_defect', 'Kode Defect', 'required');
        $this->form_validation->set_rules('kategori_defect', 'Kategori', 'required');
    
        // if ($this->form_validation->run() == FALSE) {
        //     // Kalau validasi gagal, balik ke form ubah
        //     $this->ubah($id); 
        // } else {
            $emp_data = $this->TransaksiChecking_model->getUserById($this->input->post('empID'));  
            $emp_name = isset($emp_data->name) ? $emp_data->name : '';
            $data = [
                'id_workgroup' => $this->input->post('id_workgroup'),
                'id_style' => $this->input->post('id_style'),
                'id_employee' => $this->input->post('empID'),
                'employee_name'     => $emp_name,
                'op_name' => $this->input->post('op_name'),
                'op_code' => $this->input->post('op_code'),
                'kode_defect' => $this->input->post('kode_defect'),
                'deskripsi_defect' => $this->input->post('deskripsi_defect'),
                'kategori_defect' => $this->input->post('kategori_defect'),
            ];
    
            $this->TransaksiChecking_model->update($id, $data);
            $this->session->set_flashdata('success', 'Data berhasil diubah.');
            redirect('TransaksiChecking');
        }
    } 
    
    // public function search()
    // {
    //     $data['judul'] = 'Hasil Pencarian';
    //     $keyword = $this->input->get('keyword'); // Mengambil parameter dari GET
    //     $data['results'] = $this->TransaksiChecking_model->searchData($keyword);
        
       
    //     $this->load->view('templates/header', $data);
    //     $this->load->view('TransaksiChecking/index', $data);
    //     $this->load->view('templates/footer');
    // }

