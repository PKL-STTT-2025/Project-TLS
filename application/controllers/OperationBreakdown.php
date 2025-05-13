<?php

/**
 * @property CI_OperationBreakdown_model $OperationBreakdown_model
 */
class OperationBreakdown extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('OperationBreakdown_model');
        $this->load->library('session');
        $this->load->helper('form');
    }

    public function index()
    {
        $data['title'] = 'Operation Breakdown';
        $data['operation_breakdown'] = $this->OperationBreakdown_model->getAllLine();
        if ($this->input->post('keyword')) {
            $data['operation_breakdown'] = $this->OperationBreakdown_model->cariOPB();
        }
        $this->load->view('templates/header', $data);
        $this->load->view('OperationBreakdown/opb', $data);
        $this->load->view('templates/footer');
    }
}
