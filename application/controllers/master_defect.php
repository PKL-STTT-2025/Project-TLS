<?php
defined('BASEPATH') or exit('No direct script access allowed');

class master_defect extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('master_defect_model');
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = 'Add Data Reject/Defect';
        $data['nama_user'] = $this->session->userdata('nama');

        $data['style_list'] = $this->master_defect_model->getAllStyles();
        $data['orc_list'] = $this->master_defect_model->getAllORC();

        $data['line_list'] = $this->master_defect_model->getAlllines();
        $data['list_transaksi'] = $this->master_defect_model->getAlldefects();

        // var_dump($data);
        // print_r($data['list_transaksi']);
        // die;

        // $Workgroup = $this->input->post('Workgroup');
        // if (!$Workgroup) {
        //     $data['Workgroup'] = $this->master_defect_model->search_layout_by_line($Workgroup);
        // } else {
        //     $data['Workgroup'] = $this->master_defect_model->getAlltransaksi();
        // }

        // $this->session->set_flashdata('Workgroup', $Workgroup);

        $this->load->view('templates/header', $data);
        $this->load->view('master_defect/index');
        $this->load->view('templates/footer');
    }

    // public function form_input()
    // {
    //     $data['Workgroup'] = $this->master_defect_model->getAlllines();
    //     $this->load->view('master_defect/layout', $data);
    // }

    

    public function search()
    {
        $data['title'] = 'Search Layout';
        $data['Workgroup'] = $this->master_defect_model->getAlllines();
        $this->load->view('templates/header', $data);
        $this->load->view('master_defect/search', $data);
        $this->load->view('templates/footer');
    }

    public function getStyleAndOrc()
    {
        $id_Workgroup = $this->input->post('id_Workgroup');
        $style = $this->master_defect_model->get_style_by_line($id_Workgroup);
        $orc = $this->master_defect_model->get_orc_by_line($id_Workgroup);

        $response = [
            'styles' => [$style],
            'orc' => [$orc]
        ];
        echo json_encode($response);
    }

    public function tambah()
    {
        $data['judul'] = 'Form Tambah Data Input Defect';
        $this->load->library('form_validation');

        $this->form_validation->set_rules('kode_defect', 'Kode_Defect', 'required');
        $this->form_validation->set_rules('deskripsi_defect', 'Deskripsi_Defect', 'required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('master_defect/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'kode_defect' => $this->input->post('kode_defect'),
                'deskripsi_defect' => $this->input->post('deskripsi_defect'),
                'kategori' => $this->input->post('kategori'),
            ];
            $this->transaksi_checking_model->tambahDatamaster_defect($data);
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('master_defect');
        }
    }


    public function simpan()
    {
        $id_transaksi = $this->master_defect_model->insert_master_defect($this->input->post());
        $defect_list = $this->input->post('defect_list');

        foreach ($defect_list as $item) {
            $this->master_defect_model->insert_master_defect_detail([
                'id_master_defect' => $id_transaksi,
                'id_defect' => $item['id_defect'],
                'jumlah' => $item['jumlah']
            ]);
        }
        redirect('master_defect');
    }

    public function ubah($id)
    {
        $data['title'] = 'Ubah Defect';
        $data['transaksi'] = $this->master_defect_model->get_transaksi_by_id($id);
        $data['defect_detail'] = $this->master_defect_model->get_detail_by_transaksi($id);
        $data['defects'] = $this->master_defect_model->getAlldefects();

        $this->load->view('templates/header', $data);
        $this->load->view('master_defect/ubah', $data);
        $this->load->view('templates/footer');
    }

    public function update($id)
    {
        $this->master_defect_model->update_transaksi($id, $this->input->post());
        $this->master_defect_model->delete_detail_by_transaksi($id);

        $defect_list = $this->input->post('defect_list');
        foreach ($defect_list as $item) {
            $this->master_defect_model->insert_master_defect_detail([
                'id_master_defect' => $id,
                'id_defect' => $item['id_defect'],
                'jumlah' => $item['jumlah']
            ]);
        }
        redirect('master_defect');
    }

    public function detail($id)
    {
        $data['title'] = 'Detail Defect';
        $data['transaksi'] = $this->master_defect_model->get_transaksi_by_id($id);
        $data['defect_detail'] = $this->master_defect_model->get_detail_by_transaksi($id);

        $this->load->view('templates/header', $data);
        $this->load->view('master_defect/detail', $data);
        $this->load->view('templates/footer');
    }

    public function hapus($id)
    {
        $this->master_defect_model->delete_detail_by_transaksi($id);
        $this->master_defect_model->delete_transaksi($id);
        redirect('master_defect');
    }

    public function get_layout_info()
    {
        $id_employee = $this->input->post('id_layout');
        $master_opt_layout = $this->master_defect_model->get_layout_by_id($id_employee);
        echo json_encode($master_opt_layout);
    }

    public function get_layout_detail()
    {
        $id_employee = $this->input->post('id_employee');
        $data = $this->master_defect_model->get_layout_by_id($id_employee);
        echo json_encode($data);
    }

    public function get_layout_by_Workgroup()
    {
        $Workgroup = $this->input->post('Workgroup');
        $layout = $this->master_defect_model->get_layout_by_Workgroup($Workgroup);
        if ($layout) {
            $response = [
                'status' => 'success',
                'data' => $layout
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ];
        }
        echo json_encode($response);
        exit;
    }
}
