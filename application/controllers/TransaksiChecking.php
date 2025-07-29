
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
    $data['line_list'] = $this->TransaksiChecking_model->getAlllines();
    $data['selected_line'] = $this->input->get('Workgroup');
    $data['style_list'] = [];

    if ($data['selected_line']) {
        $data['style_list'] = $this->TransaksiChecking_model->getStyleByLine($data['selected_line']);
    }

    $line = $this->input->get('Workgroup');
    $style = $this->input->get('style');
    $color = $this->input->get('color');
    $orc = $this->input->get('orc');
    $keyword = $this->input->get('keyword');

    if ($keyword) {
        $data['TransaksiChecking'] = $this->TransaksiChecking_model->searchDataHariIni($keyword);
    } elseif ($line && $style) {
        $data['TransaksiChecking'] = $this->TransaksiChecking_model->getFilteredTransaksiHariIni($line, $style, $color, $orc);
    } else {
        $data['TransaksiChecking'] = $this->TransaksiChecking_model->getDataHariIni();
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
        $this->form_validation->set_rules('note', 'Note', 'required');
        $this->form_validation->set_rules('deskripsi_defect', 'Deskripsi Defect', 'required');
    
        // Data untuk dropdown
        // $data['operators'] = $this->TransaksiChecking_model->getAllMasterEmployee();
        // echo '<pre>'; print_r($data['operators']); die;
        // $data['operation_name'] = $this->TransaksiChecking_model->getAllOperationCode();
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
        $id_style = $this->input->get('style'); // id_opb
        // var_dump($id_style); exit;
        $data['style'] = $id_style;    
        // $this->load->model('TransaksiChecking_model');
        $style = $this->TransaksiChecking_model->getStyleById($id_style);
        
        $data['style_name'] = $style ? $style->style : 'Style tidak ditemukan';
        $data['id_style'] = $id_style;
        $color = $this->input->get('color');
        $orc = $this->input->get('orc');
        //view
        $data['color'] = $color;
        $data['orc'] = $orc;
        
        date_default_timezone_set('Asia/Jakarta');
        $currenttime = date('H:i');
        $session = null;

        if ($currenttime >= '07:15' && $currenttime <= '09:59') {
            $session = 1;
        } elseif ($currenttime >= '10:00' && $currenttime <= '11:29') {
            $session = 2;
        } elseif ($currenttime >= '13:00' && $currenttime <= '14:59') {
            $session = 3;
        } elseif ($currenttime >= '15:00' && $currenttime <= '16:15') {
            $session = 4;
        }

        $data['session'] = $session; 

        $idWG = $this->input->get('Workgroup'); 
        $data['operators'] = $this->TransaksiChecking_model->getLimitedEmployee(null, $idWG);
        // $data['list_proses'] = $this->TransaksiChecking_model->getProsesByLine($id_wg, $id_opb);
        
        // $data['operation_name'] = $this->TransaksiChecking_model->getLimitedOperation(0, $id_style);
        $data['layouts'] = $this->TransaksiChecking_model->getLayoutWithMesin(0, $id_style);
        foreach ($data['layouts'] as &$layout) 
        {
        $layout->default_operator = $this->TransaksiChecking_model->getDefaultOperatorFromHistori($layout->id_master_opt_layout, $idWG);
        }
        
// echo '<pre>';
// print_r($data['layouts']);
// exit;
        $data['jumlah_proses'] = count($data['layouts']);
       
        
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
                'note'=>$this->input->post('note'),
                'deskripsi_defect'=>$this->input->post('deskripsi_defect'),
            ] ;
            $this->TransaksiChecking_model->tambahDataInputDefect($data);
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('TransaksiChecking');
        }
    }

    public function simpan()
    {
        $this->db->trans_start();
    
        $id_wg = $this->input->post('id_wg');
        $id_opb = $this->input->post('id_opb');
        $color = $this->input->post('color');
        $orc = $this->input->post('orc');
        $session = $this->input->post('session');
         
        $data_transaksi = [
            'id_wg' => $id_wg,
            'id_opb' => $id_opb,
            'color' => $color,
            'orc' => $orc,
            'date_created' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('transaksi_checking', $data_transaksi); 
        $transaksi_id = $this->db->insert_id();
    
        if (!$transaksi_id) {
            echo "Gagal menyimpan transaksi utama.";
            exit;
        }
    
        $empIDs = $this->input->post('empID');
        $op_names = $this->input->post('op_name');
        $op_codes = $this->input->post('op_code');
        $id_master_layouts = $this->input->post('id_master_opt_layout');
        $id_jnsbarang = $this->input->post('id_jnsbarang');
        $deskripsi_defect = $this->input->post('deskripsi_defect'); 
        $catatan = $this->input->post('catatan'); 
        $jumlahs = $this->input->post('jumlah'); 
    
        $total_operator = count($id_master_layouts); // atau count($op_codes), terserah mana yang fix

        for ($i = 0; $i < $total_operator; $i++) {
            $empID = $empIDs[$id_master_layouts[$i]] ?? null;

            $id_jnsbarang_clean = !empty($id_jnsbarang[$i]) ? $id_jnsbarang[$i] : null;
            
            $detail_data = [
                'id_transaksi_checking' => $transaksi_id,
                'id_master_opt_layout' => $id_master_layouts[$i],
                'id_jnsbarang' => $id_jnsbarang_clean,
                'op_code' => $op_codes[$i],
                'op_name' => $op_names[$i],
                'empID' => $empID,
                'date_created' => date('Y-m-d H:i:s')
            ];
    
            $detail_id = $this->TransaksiChecking_model->simpanDetail($detail_data);
    
            if (isset($deskripsi_defect[$i])) {
                foreach ($deskripsi_defect[$i] as $j => $defect_description) {
                    // Kalau kamu sudah tahu ID defect-nya dari form, ga usah query ke DB lagi
                    $defect_data = $this->TransaksiChecking_model->getDefectByDescription($defect_description);
                    if (!$defect_data) continue;
    
                    $defect = [
                        'id_transaksi_checking_detail' => $detail_id,
                        'id_defect' => $defect_data->id,
                        'note' => $catatan[$i][$j] ?? '',
                        'jumlah' => $jumlahs[$i][$j] ?? 1, 
                        'date_created' => date('Y-m-d H:i:s')
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
    
        $this->session->set_flashdata('flash', 'Ditambahkan (Sesi: ' . ($session ?? '-') . ')');
        redirect('TransaksiChecking?Workgroup=' . $id_wg . '&style=' . $id_opb . '&color=' . urlencode($color) . '&orc=' . urlencode($orc));

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
    $result = $this->TransaksiChecking_model->getTransaksiById($id_transaksi_checking);
    $data['transaksi'] = $result['transaksi'];
    $data['operations'] = $result['operations'];

    if (!empty($data['transaksi'])) {
        $id_wg = $data['transaksi']['id_wg'];
        $id_opb = $data['transaksi']['id_opb'];
        $line = $this->TransaksiChecking_model->getLineById($id_wg);
        $data['line_name'] = $line['Workgroup'] ?? ''; 
    } else {
        $data['line_name'] = '';
        $id_opb = null;
    }

    $layout = $this->TransaksiChecking_model->getLayoutWithMesin(0, $id_opb);
    // echo '<pre>'; print_r($layout); echo '</pre>'; exit;
    $details = $this->TransaksiChecking_model->getDetailByTransaksi($id_transaksi_checking);
    // echo '<pre>'; print_r($details); echo '</pre>'; exit;

    $data['operators'] = $details;

    $detail_by_layout = [];
        foreach ($details as $detail) {
        $layout_id = $detail['id_master_opt_layout'];
        if (!isset($detail_by_layout[$layout_id])) {
            $detail_by_layout[$layout_id] = [];
        }
        $detail_by_layout[$layout_id][] = $detail;
        }
            foreach ($layout as &$l) {
            $l->operator_name = '-';
            $l->defect_count = 0;

            if (isset($detail_by_layout[$l->id_master_opt_layout])) {
                foreach ($detail_by_layout[$l->id_master_opt_layout] as $detail) {
                    $l->operator_name = $detail['op_name'] ?? '-';
                    $l->name = $detail['name'] ?? '-';
                    $l->defect_count += $this->TransaksiChecking_model->countDefectByDetailId($detail['id_transaksi_checking_detail']);
                    $l->id_transaksi_checking_detail = $detail['id_transaksi_checking_detail'];
                }
            }
        }


    $data['layout'] = $layout;
    $data['operation_defects'] = $this->TransaksiChecking_model->getDefectsPerOperation($id_transaksi_checking);

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

            $data_defect = [];
            foreach ($operations as $op) {
                if (isset($op['id_transaksi_checking_detail'])) {
                    $data_defect[$op['id_transaksi_checking_detail']] = $this->TransaksiChecking_model->getDefectsByOpDetailId($op['id_transaksi_checking_detail']);
                }
            }
            $data['data_defect'] = $data_defect;
            
        $data['transaksi'] = $transaksi;
        $data['operations'] = $operations;

        $this->load->view('templates/header', $data);
        $this->load->view('TransaksiChecking/ubah', $data);
        $this->load->view('templates/footer');
    }

    public function update($id)
    {
        $id_details = $this->input->post('id_transaksi_checking_detail');
        $id_defects_all = $this->input->post('id_defect');
        $jumlah_all = $this->input->post('jumlah');

        date_default_timezone_set('Asia/Jakarta');

        foreach ($id_details as $index => $id_detail) {
            $data_detail = [
                'empID' => $this->input->post('empID')[$index],
                'op_name' => $this->input->post('op_name')[$index],
                'op_code' => trim($this->input->post('op_code')[$index]),
                'date_updated' => date('Y-m-d H:i:s')
            ];

            $this->TransaksiChecking_model->update_detail($id_detail, $data_detail);

            // Hapus defect lama
            $this->db->where('id_transaksi_checking_detail', $id_detail);
            $this->db->delete('transaksi_defect');

            // Ambil defect baru
            $id_defects = isset($id_defects_all[$index]) ? $id_defects_all[$index] : [];
            $jumlah_defect = isset($jumlah_all[$index]) ? $jumlah_all[$index] : [];

            foreach ($id_defects as $i => $id_defect) {
                if (!is_numeric($id_defect) || $id_defect == 0) continue;

                $data_defect = [
                    'id_transaksi_checking_detail' => $id_detail,
                    'id_defect' => $id_defect,
                    'jumlah' => $jumlah_defect[$i] ?? 0,
                    'date_created' => date('Y-m-d H:i:s')
                ];

                $this->db->insert('transaksi_defect', $data_defect);
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

