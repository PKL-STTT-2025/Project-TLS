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

    public function index() {}


    public function Operator()
    {
        $data['title'] = 'Operator per Line';
        $data['Report_Operator'] = $this->ReportOperator_model->getAllReportOperator();
        // digunakan untuk menampilkan data style dan line
        $data['line_list'] = $this->ReportOperator_model->getAlllines();
        $data['style_list'] = $this->ReportOperator_model->getAllStyles();

        // Jika user sudah pilih Line dan klik Search
        if ($this->input->post('Workgroup')) {
            $line = $this->input->post('Workgroup');
            $style = $this->input->post('style');

            // filter di model berdasarkan Line dan Style
            $data['Report_Operator'] = $this->ReportOperator_model->getFilteredReport($line, $style);
        } elseif ($this->input->post('keyword')) {
            $data['Report_Operator'] = $this->ReportOperator_model->cariReportOperator();
        } else {
            // Awalnya kosong
            $data['Report_Operator'] = [];
        }
        $data['jumlah_kunjungan'] = $this->ReportOperator_model->getJumlahKunjunganQC();
        $data['operators'] = $this->ReportOperator_model->get_data_operator();
        $this->load->view('templates/header', $data);
        $this->load->view('Report/Operator', $data);
        $this->load->view('templates/footer');
    }

    public function report_operator()
    {
        $data['title'] = 'Histori Defect Operator';
        $data['op'] = $this->ReportOperator_model->get_operator();
        $data['defects'] = $this->ReportOperator_model->get_defect_operator();
        $data['total_kunjungan'] = 5;
        $this->load->view('templates/header', $data);
        $this->load->view('Report/report_operator', $data);
        $this->load->view('templates/footer');
    }
}
