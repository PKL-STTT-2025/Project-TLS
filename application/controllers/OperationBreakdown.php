<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property OperationBreakdown_model $OperationBreakdown_model
 */
class OperationBreakdown extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('OperationBreakdown_model');
    }

    public function index()
    {
        $data['title'] = 'Operation Breakdown';
        $data['operation'] = $this->OperationBreakdown_model->getActiveOperation();
        $this->load->view('templates/header', $data);
        $this->load->view('OperationBreakdown/opb', $data);
        $this->load->view('templates/footer');
    }
}
