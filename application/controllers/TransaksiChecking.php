
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
        // digunakan untuk menampilkan data style dan line
        $data['line_list'] = $this->TransaksiChecking_model->getAlllines();

        if($this->input->get('Workgroup'))  { 
            $data['selected_line'] = $this->input->get('Workgroup');
            $data['style_list'] = $this->TransaksiChecking_model->getStyleByLine($data['selected_line']);
        } 
        
        $id_line = $this->input->post('id_line'); 
        $this->TransaksiChecking_model->getLineById($id_line); 

         // Jika user sudah pilih Line dan klik Search
         if ($this->input->post('Workgroup')) {
            $line = $this->input->post('Workgroup');
            $style = $this->input->post('style');
            $data['transaksi_checking'] = $this->TransaksiChecking_model->getFilteredTransaksi($line, $style);
        } elseif ($this->input->post('keyword')) {
            $data['transaksi_checking'] = $this->TransaksiChecking_model->cariTransaksiChecking($keyword);
        } else {
            // Awalnya tampilkan semua data
            $data['transaksi_checking'] = $this->TransaksiChecking_model->getAllTransaksiChecking();
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

    public function tambah ()
    {
        $data['judul'] = 'Form Tambah Data Input Defect';
        $this->load->library('form_validation');

        // Validasi form
        $this->form_validation->set_rules('id_wg', 'Line', 'required');
        $this->form_validation->set_rules('id_opb', 'Style', 'required');
        $this->form_validation->set_rules('empID', 'Employee ID', 'required');
        $this->form_validation->set_rules('op_name', 'Operation Name', 'required');
        $this->form_validation->set_rules('op_code', 'Operation code', 'required');
        $this->form_validation->set_rules('id_master_opt_layout', 'ID Master Opt Layout', 'required');
        $this->form_validation->set_rules('deskripsi_defect', 'Deskripsi Defect', 'required');
    
        // Data untuk dropdown
        $data['operators'] = $this->TransaksiChecking_model->getAllMasterEmployee();
        // echo '<pre>'; print_r($data['operators']); die;
        $data['operation_name'] = $this->TransaksiChecking_model->getAllOperationCode();
        $data['defect_list'] = $this->TransaksiChecking_model->getAllDefect();
        // $data['layouts'] = $this->TransaksiChecking_model->getLayoutByLine($id_line);
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
        
        $data['operators'] = $this->TransaksiChecking_model->getLimitedEmployee(2);
        $data['operation_name'] = $this->TransaksiChecking_model->getLimitedOperation(2);
        $data['layouts'] = $this->TransaksiChecking_model->getLayoutWithMesin(2);
        
        if($this->form_validation->run()==FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('TransaksiChecking/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $data =[
                'id_wg'=>$this->input->post('id_wg'),
                'id_opb'=>$this->input->post('id_opb'),
                'empID'=>$this->input->post('id_employee'),
                'operation_code'=>$this->input->post('operation_code'),
                'operation_name'=>$this->input->post('operation_name'),
                'id_master_opt_layout'=>$this->input->post('id_master_opt_layout'),
                'deskripsi_defect'=>$this->input->post('deskripsi_defect'),
            ] ;
            $this->TransaksiChecking_model->tambahDataInputDefect($data);
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('TransaksiChecking');
        }
    }

    public function simpan()
    {
        $this->db->trans_start(); // MULAI TRANSAKSI
    
        $id_wg = $this->input->post('id_wg');
        $id_opb = $this->input->post('id_opb');
    
        $data_transaksi = [
            'id_wg' => $id_wg,
            'id_opb' => $id_opb
        ];
        $this->db->insert('transaksi_checking', $data_transaksi); 
        $transaksi_id = $this->db->insert_id();
    
        $empIDs = $this->input->post('empID');
        $op_names = $this->input->post('op_name');
        $op_codes = $this->input->post('op_code');
        $defects = $this->input->post('deskripsi_defect');
        $jumlahs = $this->input->post('jumlah');
        $id_master_layouts = $this->input->post('id_master_opt_layout');
        $id_jnsbarang = $this->input->post('id_jnsbarang');
    
        foreach ($empIDs as $i => $empID) {
            $detail_data = [
                'id_transaksi_checking' => $transaksi_id,
                'id_master_opt_layout' => $id_master_layouts[$i],
                'id_jnsbarang' => $id_jnsbarang[$i],
                'op_code' => $op_codes[$i],
                'op_name' => $op_names[$i],
                'empID' => $empID
            ];
            $detail_id = $this->TransaksiChecking_model->simpanDetail($detail_data);
    
            if (isset($defects[$i])) {
                foreach ($defects[$i] as $j => $defect_description) {
                    $defect_data = $this->TransaksiChecking_model->getDefectByDescription($defect_description);
                    if (!$defect_data) continue;
    
                    $defect = [
                        'id_transaksi_checking_detail' => $detail_id,
                        'id_defect' => $defect_data->id,
                        'jumlah' => $jumlahs[$i][$j] ?? 1
                    ];
    
                    $this->TransaksiChecking_model->simpanDefect($defect);
                }
            }
        }
    
        $this->db->trans_complete(); // AKHIRI TRANSAKSI
    
        if ($this->db->trans_status() === FALSE) {
            echo "Gagal menyimpan data. Semua rollback.";
            // Bisa tambahkan logging di sini
            exit;
        }
    
        $this->session->set_flashdata('flash', 'Ditambahkan');
        redirect('TransaksiChecking');
    }
      
    

    public function hapus($id)
    {
        $this->TransaksiChecking_model->hapusDefectByTransaksiId($id);
        $this->TransaksiChecking_model->hapusDetailByTransaksiId($id);
        $this->TransaksiChecking_model->hapusDataInputDefect($id);
        
        $this->session->set_flashdata('flash', 'Data berhasil dihapus');
        redirect('TransaksiChecking');
    }
    public function detail($id)
    {
       
        $data['detail_checking'] = $this->TransaksiChecking_model->getDetailWithJoins($id);
        $result = $this->TransaksiChecking_model->getTransaksiById($id);
        
        if (!$result) {
            show_404(); 
        }

        $data = [
            'title' => 'Detail Transaksi',
            'transaksi' => $result['transaksi'], 
            'operations' => $result['operations'],
        ];
        
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

