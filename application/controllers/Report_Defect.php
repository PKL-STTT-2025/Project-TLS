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

        // Dropdown line dan style
        $data['line_list'] = $this->Report_Defect_model->getAlllines();
        $data['style_list'] = $this->Report_Defect_model->getAllStyles();

        // Ambil default data (kosong)
        $data['report_hari'] = [];
        $data['total_defect'] = '-';


        $id_wg = $this->input->get('id_wg');
        $id_opb = $this->input->get('id_opb');
        $style = $this->input->get('style');

        if ($id_wg && $id_opb) {
            $data['report_hari'] = $this->Report_Defect_model->getDefectByLineStyle($style, $id_wg);
            $data['selected_wg'] = $id_wg;
            $data['selected_opb'] = $id_opb;
        } else {
            $data['reportoperator'] = [];
            $data['selected_wg'] = '';
            $data['selected_opb'] = '';
        }
        $data['selected_wg'] = $id_wg ?: '';
        $data['selected_opb'] = $id_opb ?: '';


        $this->load->view('templates/header', $data);
        $this->load->view('Report_Defect/report_hari', $data);
        $this->load->view('templates/footer');
    }
    public function getTotalDefect()
    {
        $line = $this->input->get('line');
        $style = $this->input->get('style');

        $total = $this->Report_Defect_model->getTotalDefectPerDay($line, $style);
        echo json_encode(['total_defect' => $total]);
    }
    public function getDefectChart()
    {
        $id_wg = $this->input->get('line');
        $style = $this->input->get('style');
        $tanggal = date('Y-m-d');
        $defects = $this->Report_Defect_model->getDefectByLineStyle($style, $id_wg);
        echo json_encode($defects);
    }

    public function reportMinggu()
    {
        $data['title'] = 'Report Mingguan Defect';

        // Dropdown untuk memilih line dan style
        $data['line_list'] = $this->Report_Defect_model->getAlllines();
        $data['style_list'] = $this->Report_Defect_model->getAllStyles();

        // Jika user memilih Workgroup (Line) dan Style lalu klik Search
        if ($this->input->post('Workgroup') && $this->input->post('style')) {
            $line = $this->input->post('Workgroup');  // ID Workgroup (ex: SHIFT 1 LINE WAKATOBI)
            $style = $this->input->post('style');     // ID Style dari operation_breakdown

            // Ambil data defect mingguan (7 hari terakhir berdasarkan tanggal di transaksi_checking)
            $data['report_minggu'] = $this->Report_Defect_model->getDefectMingguanByLineStyle($style, $line);
        } else {
            $data['report_minggu'] = []; // kosong jika belum pilih line/style
        }

        $this->load->view('templates/header', $data);
        $this->load->view('Report_Defect/report_minggu', $data);
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
        $this->load->view('Report_Defect/report_bulan', $data);
        $this->load->view('templates/footer');
    }

    public function getStyleByLine()
    {
        // masih bingung yang ini  (workgroup)sama style
        $Workgroup = (int)$this->input->post('Workgroup');
        $tanggal = date('Y-m-d');
        $response = $this->Report_Defect_model->getStyleByLine($Workgroup);
        echo json_encode($response);
    }
}