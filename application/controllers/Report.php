<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_Report_model $Report_model
 */
class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Report_model');
    }

    public function index() {}

    public function report_operator()
    {
        $data['title'] = 'Histori Defect Operator';
        $data['op'] = $this->Report_model->get_operator();
        $data['defects'] = $this->Report_model->get_defect_operator();
        $data['total_kunjungan'] = 5;
        $this->load->view('templates/header', $data);
        $this->load->view('Report/report_operator', $data);
        $this->load->view('templates/footer');
    }
}
