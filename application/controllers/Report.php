<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property Report_model $Report_model
 * @property input $input
 */
class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Report_model');
    }

    public function index()
    {
        $data['title'] = 'Report Operator';
        $data['reportoperator'] = $this->Report_model->getAllReportDefect();

        $id_wg = $this->input->get('id_wg');
        $id_opb = $this->input->get('id_opb');

        if ($id_wg && $id_opb) {
            $data['reportoperator'] = $this->Report_model->getReportOperator($id_opb, $id_wg);
            $data['selected_wg'] = $id_wg;
            $data['selected_opb'] = $id_opb;
        } else {
            $data['reportoperator'] = [];
            $data['selected_wg'] = '';
            $data['selected_opb'] = '';
        }
        $data['selected_wg'] = $id_wg ?: '';
        $data['selected_opb'] = $id_opb ?: '';

        $data['line_list'] = $this->Report_model->getAlllines();
        $data['style_list'] = $this->Report_model->getAllStyles();

        $this->load->view('templates/header', $data);
        $this->load->view('Report/index', $data);
        $this->load->view('templates/footer');
    }
    public function getStyleByLine()
    {
        $Workgroup = (int)$this->input->post('Workgroup');
        $response = $this->Report_model->getStyleByLine($Workgroup);
        echo json_encode($response);
    }
    public function getReportIndex()
    {
        $id_opb = $this->input->post('id_opb');
        $id_wg  = $this->input->post('id_wg');

        $data = $this->Report_model->getReportOperator($id_opb, $id_wg);

        echo json_encode($data);
    }


    public function report_operator($id_transaksi_checking_detail)
    {

        $this->load->model('Report_model');
        $data['op'] = $this->Report_model->getOperatorByCheckingDetail($id_transaksi_checking_detail);
        $data['histori_defect'] = $this->Report_model->getDefectHistory($id_transaksi_checking_detail);
        $data['latest_defect'] = $this->Report_model->getLatestDefect($id_transaksi_checking_detail);
        $data['title'] = "Report Operator";
        $this->load->view('templates/header', $data);
        $this->load->view('Report/report_operator', $data);
        $this->load->view('templates/footer');
    }
}