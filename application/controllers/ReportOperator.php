<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_ReportOperator_model $ReportOperator_model
 */
class ReportOperator extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ReportOperator_model');
        $this->load->library('session');
    }


    public function index()
    {
        // $data['title'] = 'Operator per Line';
        // $data['operators'] = [];
        // $data['Report_Operator'] = $this->ReportOperator_model->getAllReportOperator();
        // // digunakan untuk menampilkan data style dan line
        // $data['line_list'] = $this->ReportOperator_model->getAlllines();
        // $data['style_list'] = $this->ReportOperator_model->getAllStyles();

        // // Jika user sudah pilih Line dan klik Search
        // if ($this->input->post('Workgroup')) {
        //     $line = $this->input->post('Workgroup');
        //     $style = $this->input->post('style');

        //     // filter di model berdasarkan Line dan Style
        //     $data['operators'] = $this->ReportOperator_model->getFilteredReport($line, $style);
        //     // $data['operators'] = $this->ReportOperator_model->get_data_operator_by_line_and_style($line, $style);
        // } elseif ($this->input->post('keyword')) {
        //     $data['Report_Operator'] = $this->ReportOperator_model->cariReportOperator();
        // } else {
        //     // Awalnya kosong
        //     $data['Report_Operator'] = [];
        // }

        // // $id_employee = $this->input->post('id_employee');
        // // $id_opb = $this->input->post('id_opb');
        // $data['jumlah_kunjungan'] = $this->ReportOperator_model->getJumlahKunjunganQC();
        // $this->load->view('templates/header', $data);
        // $this->load->view('Report/Operator', $data);
        // $this->load->view('templates/footer');
        $data['title'] = 'Operator per Line';
        $data['operators'] = [];
        $data['Report_Operator'] = [];
        $data['line_name'] = '';

        // Dropdown data
        $data['line_list'] = $this->ReportOperator_model->getAlllines();
        $data['style_list'] = $this->ReportOperator_model->getAllStyles();

        // Kalau tombol search diklik

        if ($this->input->post('Workgroup')) {
            $line = $this->input->post('Workgroup');
            $style = $this->input->post('style');

            // Cari id_opb dulu
            $id_opb = $this->ReportOperator_model->getOpbByLineAndStyle($line, $style);

            if ($id_opb) {
                // Kalau ketemu, ambil operatornya
                $operators = $this->ReportOperator_model->get_data_operator($id_opb);
                $data['operators'] = $operators;
            }

            // Ambil nama line
            $line_name = $this->ReportOperator_model->getLineName($line);
            $data['line_name'] = $line_name;
        }

        // Data statistik kunjungan QC
        $data['jumlah_kunjungan'] = $this->ReportOperator_model->getJumlahKunjunganQC();

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('Report/Operator', $data);
        $this->load->view('templates/footer');
    }

    public function getStyleByLine()
    {
        // masih bingung yang ini  (workgroup)sama style
        $Workgroup = (int)$this->input->post('Workgroup');

        // var_dump((int)$Workgroup);
        // die;

        $response = $this->ReportOperator_model->getStyleByLine($Workgroup);
        echo json_encode($response);
    }
    public function report_operator($id_employee, $id_opb)
    {
        $data['title'] = 'Histori Defect Operator';
        $data['op'] = $this->ReportOperator_model->get_operator($id_employee, $id_opb);
        $data['defects'] = $this->ReportOperator_model->get_defect_operator($id_employee, $id_opb);
        $data['total_kunjungan'] = 5;
        $this->load->view('templates/header', $data);
        $this->load->view('Report/report_operator', $data);
        $this->load->view('templates/footer');
    }
}
