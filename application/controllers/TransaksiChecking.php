
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
        $this->form_validation->set_rules('color', 'Color', 'required');
        $this->form_validation->set_rules('orc', 'ORC', 'required');
        $this->form_validation->set_rules('op_name', 'Operation Name', 'required');
        $this->form_validation->set_rules('op_code', 'Operation code', 'required');
        $this->form_validation->set_rules('id_master_opt_layout', 'ID Master Opt Layout', 'required');
        $this->form_validation->set_rules('id_jnsbarang', 'ID Jenis Barang', 'required');
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
                'color'=>$this->input->post('color'),
                'orc'=>$this->input->post('orc'),
                'empID'=>$this->input->post('id_employee'),
                'operation_code'=>$this->input->post('operation_code'),
                'operation_name'=>$this->input->post('operation_name'),
                'id_master_opt_layout'=>$this->input->post('id_master_opt_layout'),
                'id_jnsbarang'=>$this->input->post('id_jnsbarang'),
                'deskripsi_defect'=>$this->input->post('deskripsi_defect'),
            ] ;
            $this->TransaksiChecking_model->tambahDataInputDefect($data);
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('TransaksiChecking');
        }
    }

    public function simpan()
    {
        // echo "Sampai di fungsi simpan."; 
        // exit;
        
        $this->db->trans_start();
    
        $id_wg = $this->input->post('id_wg');
        $id_opb = $this->input->post('id_opb');
        $color = $this->input->post('color');
        $orc = $this->input->post('orc');
    
        $data_transaksi = [
            'id_wg' => $id_wg,
            'id_opb' => $id_opb,
            'color' => $color,
            'orc' => $orc
        ];
        $this->db->insert('transaksi_checking', $data_transaksi); 
        $transaksi_id = $this->db->insert_id();
        
        if (!$transaksi_id) {
            echo "Gagal menyimpan transaksi utama.";
            exit;
        }
        // echo "<pre>";
        // print_r($this->input->post());
        // echo "</pre>";
        // exit;

    
        $empIDs = $this->input->post('empID');
        $op_names = $this->input->post('op_name');
        $op_codes = $this->input->post('op_code');
        $defects = $this->input->post('deskripsi_defect');
        $jumlahs = $this->input->post('jumlah');
        $id_master_layouts = $this->input->post('id_master_opt_layout');
        $id_jnsbarang = $this->input->post('id_jnsbarang');
    
        foreach ($empIDs as $i => $empID) {
            $id_jnsbarang_clean = $id_jnsbarang[$i] !== '' ? $id_jnsbarang[$i] : null;
        
            $detail_data = [
                'id_transaksi_checking' => $transaksi_id,
                'id_master_opt_layout' => $id_master_layouts[$i],
                'id_jnsbarang' => $id_jnsbarang_clean,
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
                        'jumlah' => $jumlahs[$i][$j] ?? 1, 
                    ];
                    $this->TransaksiChecking_model->simpanDefect($defect);
                }
            }
        }
        
    
        $this->db->trans_complete(); 
    
        if ($this->db->trans_status() === FALSE) {
            echo "Gagal menyimpan data. Semua rollback.";
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
    public function detail($id_transaksi_checking)
    {

        $data['title'] = 'Detail Checking Time';
        $data['line_name'] = '';
        $data['operators'] = $this->TransaksiChecking_model->getLimitedOperator($id_transaksi_checking);
        $data['operation_name'] = $this->TransaksiChecking_model->getLimitedOperation(2);
        $data['layout'] = $this->TransaksiChecking_model->getLayout($id_transaksi_checking);
        $data['operation_defects'] = $this->TransaksiChecking_model->getDefectsPerOperation($id_transaksi_checking);

        // Ambil layout
        $layout = $this->TransaksiChecking_model->getLayout($id_transaksi_checking);

        // Ambil defects per operator
        $operation_defects = $this->TransaksiChecking_model->getDefectsPerOperation($id_transaksi_checking);

        // Hitung defect count per op_code
        $defectCounts = [];
        foreach ($operation_defects as $defect) {
            $id_detail = $defect['id_transaksi_checking_detail'];
            if (!isset($defectCounts[$id_detail])) {
                $defectCounts[$id_detail] = 0;
            }
            $defectCounts[$id_detail] += $defect['jumlah'];
        }

        // Tambahkan defect_count & operator_name ke masing-masing layout item
        foreach ($layout as $opt_layout) {
            $opt_layout->defect_count = 0;
            $opt_layout->operator_name = '-';

            foreach ($data['operators'] as $op) {
                if (trim($opt_layout->op_code) === trim($op->op_code)) {
                    $opt_layout->operator_name = $op->operator_name;

                    // cari defect count dari transaksi_checking_detail yang sesuai
                    foreach ($operation_defects as $defect) {
                        if ($defect['id_transaksi_checking_detail'] == $op->id_transaksi_checking_detail) {
                            $opt_layout->defect_count += $defect['jumlah'];
                        }
                    }
                }
            }
        }

        $data['layout'] = $layout;
        $data['operation_defects'] = $operation_defects;

        $this->load->view('templates/header', $data);
        $this->load->view('TransaksiChecking/detail', $data);
        $this->load->view('templates/footer');
    }


    public function ubah($id)
{
    $data['judul'] = 'Form Ubah Transaksi Checking';
    $data['transaksi_checking'] = $this->TransaksiChecking_model->getTransaksiById($id); 

    if (empty($data['transaksi_checking'])) {
        show_404();
    }

    $id_wg = $data['transaksi_checking']['transaksi']['id_wg'];
    $id_opb = $data['transaksi_checking']['transaksi']['id_opb'];

    $data['line_name'] = $this->TransaksiChecking_model->getLineNameByTransaksi($id);
    $data['layouts'] = $this->TransaksiChecking_model->getLayoutsByWorkgroupAndStyle($id_wg, $id_opb);
    $data['id_transaksi_checking_detail'] = $id;
    $data['id_transaksi'] = $id;
    $data['data_detail'] = $this->TransaksiChecking_model->getDetailByTransaksi($id);

    $data['operators'] = $this->TransaksiChecking_model->getAllMasterEmployee();
    $data['operation_name'] = $this->TransaksiChecking_model->getAllOperationCode();
    $data['defect_list'] = $this->TransaksiChecking_model->getAllDefect();

    $transaksi = $data['transaksi_checking']['transaksi'];
    $operations = isset($data['transaksi_checking']['operations']) && is_array($data['transaksi_checking']['operations']) 
        ? $data['transaksi_checking']['operations'] : [];

    foreach ($operations as &$op) {
        if (isset($op['id_transaksi_checking_detail'])) {
            $op['defects'] = $this->TransaksiChecking_model->getDefectsByOpDetailId($op['id_transaksi_checking_detail']);
        } else {
            $op['defects'] = [];
        }
    }

    $data['transaksi'] = $transaksi;
    $data['operations'] = $operations;

    $this->load->view('templates/header', $data);
    $this->load->view('TransaksiChecking/ubah', $data);
    $this->load->view('templates/footer');
}

    public function update($id)
    {
        $transaksi_detail = $this->input->post('operators'); 

        if (!$transaksi_detail || !is_array($transaksi_detail)) {
            $this->session->set_flashdata('error', 'Data tidak valid.');
            redirect('TransaksiChecking/ubah/' . $id);
        }

        foreach ($transaksi_detail as $detail) {
            $id_detail = $detail['id_transaksi_checking_detail'] ?? null;

            $data_detail = [
                'empID' => $detail['empID'],
                'employee_name' => $detail['employee_name'],
                'op_name' => $detail['op_name'],
                'op_code' => $detail['op_code'],
                'date_updated' => date('Y-m-d H:i:s'),
            ];

            if ($id_detail) {
                $this->TransaksiChecking_model->update_detail($id_detail, $data_detail);
            } else {
                $data_detail['id_transaksi_checking_detail'] = $id;
                $data_detail['date_created'] = date('Y-m-d H:i:s');
                $id_detail = $this->TransaksiChecking_model->insert_detail($data_detail);
            }
            if (!empty($detail['defects'])) {
                foreach ($detail['defects'] as $defect) {
                    $id_defect = $defect['id_defect'] ?? null;

                    $data_defect = [
                        // 'kode_defect' => $defect['kode_defect'],
                        // 'deskripsi_defect' => $defect['deskripsi_defect'],
                        // 'kategori_defect' => $defect['kategori_defect'],
                        'id_transaksi_checking_detail' => $id_detail,
                        'id_defect' => $defect['id_defect'],
                        'note' => $detail['note'] ?? null,
                        'jumlah' => $defect['jumlah'],
                        'date_updated' => date('Y-m-d H:i:s'),
                    ];

                    if ($id_defect) {
                        $this->TransaksiChecking_model->update_defect($id_defect, $data_defect);
                    } else {
                        $data_defect['id_transaksi_defect'] = $id;
                        $data_defect['id_transaksi_checkingdetail'] = $id_detail;
                        $data_defect['date_created'] = date('Y-m-d H:i:s');
                        $this->TransaksiChecking_model->insert_defect($data_defect);
                    }
                }
            }
        }

        $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
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

