<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property Report_Defect_model $Report_Defect_model
 * @property input $input
 */
class Report_Defect extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Report_Defect_model');
    }
    public function reportHari()
    {
        $data['title'] = 'Report Harian Defect';
        $data['report_hari'] = $this->Report_Defect_model->getAllReportDefect();

        // digunakan untuk menampilkan data style dan line
        $data['line_list'] = $this->Report_Defect_model->getAlllines();
        $data['style_list'] = $this->Report_Defect_model->getAllStyles();

        // Jika user sudah pilih Line dan klik Search
        if ($this->input->post('Workgroup')) {
            $line = $this->input->post('Workgroup');
            $style = $this->input->post('style');

            // filter di model berdasarkan Line dan Style
            $data['report_hari'] = $this->Report_Defect_model->getFilteredReportDefect($line, $style);
        } elseif ($this->input->post('keyword')) {
            $data['report_hari'] = $this->Report_Defect_model->cariReportDefect();
        } else {
        }

        $this->load->view('templates/header', $data);
        $this->load->view('Report_Defect/report_hari', $data);
        $this->load->view('templates/footer');
    }
    public function getDefectChart()
    {
        $line_id = $this->input->get('line');
        $style_id = $this->input->get('style');
        $defects = $this->Report_Defect_model->getDefectByLineStyle($line_id, $style_id);
        echo json_encode($defects);
    }

    public function reportMinggu()
    {
        $data['title'] = 'Report Mingguan Defect';
        $data['report_minggu'] = $this->Report_Defect_model->getAllReportDefect();

        // digunakan untuk menampilkan data style dan line
        $data['line_list'] = $this->Report_Defect_model->getAlllines();
        $data['style_list'] = $this->Report_Defect_model->getAllStyles();

        // Jika user sudah pilih Line dan klik Search
        if ($this->input->post('Workgroup')) {
            $line = $this->input->post('Workgroup');
            $style = $this->input->post('style');

            // filter di model berdasarkan Line dan Style
            $data['report_minggu'] = $this->Report_Defect_model->getFilteredReportDefect($line, $style);
        } elseif ($this->input->post('keyword')) {
            $data['report_minggu'] = $this->Report_Defect_model->cariReportDefect();
        } else {
        }

        $this->load->view('templates/header', $data);
        $this->load->view('Report_Defect/report_hari', $data);
        $this->load->view('templates/footer');
    }

    public function reportBulan()
    {
        $data['title'] = 'Report Bulanan Defect';
        $data['report_bulan'] = $this->Report_Defect_model->getAllReportDefect();

        // digunakan untuk menampilkan data style dan line
        $data['line_list'] = $this->Report_Defect_model->getAlllines();
        $data['style_list'] = $this->Report_Defect_model->getAllStyles();

        // Jika user sudah pilih Line dan klik Search
        if ($this->input->post('Workgroup')) {
            $line = $this->input->post('Workgroup');
            $style = $this->input->post('style');

            // filter di model berdasarkan Line dan Style
            $data['report_bulan'] = $this->Report_Defect_model->getFilteredReportDefect($line, $style);
        } elseif ($this->input->post('keyword')) {
            $data['report_bulan'] = $this->Report_Defect_model->cariReportDefect();
        } else {
        }

        $this->load->view('templates/header', $data);
        $this->load->view('Report_Defect/report_hari', $data);
        $this->load->view('templates/footer');
    }

    public function getStyleByLine()
    {
        // masih bingung yang ini  (workgroup)sama style
        $Workgroup = (int)$this->input->post('Workgroup');

        // var_dump((int)$Workgroup);
        // die;

        $response = $this->Report_Defect_model->getStyleByLine($Workgroup);
        echo json_encode($response);
    }
}
