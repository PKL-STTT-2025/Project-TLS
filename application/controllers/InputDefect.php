<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InputDefect extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('InputDefect_model');
        $this->load->library('session');
    }

    public function index()
    {   $data['title'] = 'Add Data Reject/Defect';
        $data['nama_user']= $this->session->userdata('nama');

        $data['style_list'] = $this->InputDefect_model->getAllStyles();
        $data['orc_list'] = $this->InputDefect_model->getAllORC();

        $data['line_list'] = $this->InputDefect_model->getAlllines();
        $data['list_transaksi'] = $this->InputDefect_model->getAlltransaksi();

        $Workgroup = $this->input->post('Workgroup'); 
        if (!$Workgroup) {
            $data['Workgroup'] = $this->InputDefect_model->search_layout_by_line($Workgroup);
        } else {
            $data['Workgroup'] = $this->InputDefect_model->getAlltransaksi();
        }

        $this->session->set_flashdata('Workgroup', $Workgroup);

        $this->load->view('templates/header', $data);
        $this->load->view('InputDefect/index', $data);
        $this->load->view('templates/footer');
    }

    public function form_input() {
        $data['Workgroup'] = $this->InputDefect_model->getAlllines();
        $this->load->view('InputDefect_Form/layout', $data);
    }
    
    public function search() 
    {
        $data['title'] = 'Search Layout';
        $data['Workgroup'] = $this->InputDefect_model->getAlllines();
        $this->load->view('templates/header', $data);
        $this->load->view('InputDefect_Form/search', $data);
        $this->load->view('templates/footer');
    }

    public function getStyleAndOrc() {
        $id_Workgroup = $this->input->post('id_Workgroup');
        $style = $this->InputDefect_model->get_style_by_line($id_Workgroup);
        $orc = $this->InputDefect_model->get_orc_by_line($id_Workgroup);

        $response = [
            'styles' => [$style],
            'orc' => [$orc]
        ];
        echo json_encode($response);
    }
    
    public function tambah ()
    {
        $data['judul'] = 'Form Tambah Data Input Defect';
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('kode_defect','Kode_Defect', 'required');
        $this->form_validation->set_rules('deskripsi_defect', 'Deskripsi_Defect', 'required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');

        if($this->form_validation->run()==FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('InputDefect_Form/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $data =[
                'kode_defect'=>$this->input->post('kode_defect'),
                'deskripsi_defect'=>$this->input->post('deskripsi_defect'),
                'kategori'=>$this->input->post('kategori'),
            ] ;
            $this->InputDefect_model->tambahDataInputDefect($data);
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('InputDefect');
        }
    }


       public function simpan() {
        $id_transaksi = $this->InputDefect_model->insert_transaksi_checking($this->input->post());
        $defect_list = $this->input->post('defect_list');

        foreach ($defect_list as $item) {
            $this->InputDefect_model->insert_transaksi_checking_detail([
                'id_transaksi_checking' => $id_transaksi,
                'id_defect' => $item['id_defect'],
                'jumlah' => $item['jumlah']
            ]);
        }
        redirect('InputDefect');
    }

    public function ubah($id) 
    {   $data['title'] = 'Ubah Defect';
        $data['transaksi'] = $this->InputDefect_model->get_transaksi_by_id($id);
        $data['defect_detail'] = $this->InputDefect_model->get_detail_by_transaksi($id);
        $data['defects'] = $this->InputDefect_model->getAlldefects();

        $this->load->view('templates/header', $data);
        $this->load->view('InputDefect/ubah', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
        $this->InputDefect_model->update_transaksi($id, $this->input->post());
        $this->InputDefect_model->delete_detail_by_transaksi($id);

        $defect_list = $this->input->post('defect_list');
        foreach ($defect_list as $item) {
            $this->InputDefect_model->insert_transaksi_checking_detail([
                'id_transaksi_checking' => $id,
                'id_defect' => $item['id_defect'],
                'jumlah' => $item['jumlah']
            ]);
        }
        redirect('InputDefect');
    }

    public function detail($id) 
    {   $data['title'] = 'Detail Defect';
        $data['transaksi'] = $this->InputDefect_model->get_transaksi_by_id($id);
        $data['defect_detail'] = $this->InputDefect_model->get_detail_by_transaksi($id);

        $this->load->view('templates/header', $data);
        $this->load->view('InputDefect/detail', $data);
        $this->load->view('templates/footer');
    }

    public function hapus($id) {
        $this->InputDefect_model->delete_detail_by_transaksi($id);
        $this->InputDefect_model->delete_transaksi($id);
        redirect('InputDefect');
    }

    public function get_layout_info()
    {
    $id_employee = $this->input->post('id_layout');
    $master_opt_layout = $this->InputDefect_model->get_layout_by_id($id_employee);
    echo json_encode($master_opt_layout);
    }

    public function get_layout_detail()
{
    $id_employee = $this->input->post('id_employee');
    $data = $this->InputDefect_model->get_layout_by_id($id_employee);
    echo json_encode($data);
}

    public function get_layout_by_Workgroup() {
        $Workgroup = $this->input->post('Workgroup');
        $layout = $this->InputDefect_model->get_layout_by_Workgroup($Workgroup);
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
