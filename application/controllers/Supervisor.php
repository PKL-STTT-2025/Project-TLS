<?php

/**
 * @property Supervisor_model $Supervisor_model
 * @property input $input
 */
class Supervisor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Supervisor_model');
    }
    public function index()
    {
        $data['title'] = 'List Checking Time';
        $data['CheckingTime'] = $this->Supervisor_model->getCheckingTime();
        $this->load->view('templates/header', $data);
        $this->load->view('Supervisor/index', $data);
        $this->load->view('templates/footer');
    }
    public function detail($id_transaksi_checking)
    {

        $data['title'] = 'List Checking Time';
        $data['line_name'] = '';
        $data['operators'] = $this->Supervisor_model->getLimitedEmployee($id_transaksi_checking);
        $data['operation_name'] = $this->Supervisor_model->getLimitedOperation(10);
        $data['layouts'] = $this->Supervisor_model->getLayoutWithMesin($id_transaksi_checking);
        $data['operation_defects'] = $this->Supervisor_model->getDefectsPerOperation($id);

        $this->load->view('templates/header', $data);
        $this->load->view('Supervisor/detail', $data);
        $this->load->view('templates/footer');
    }
    public function action_plan()
    {
        $data['title'] = 'List Checking Time';
        $data['ActionPlan'] = $this->Supervisor_model->getAction();
        $this->load->view('templates/header', $data);
        $this->load->view('Supervisor/action_plan', $data);
        $this->load->view('templates/footer');
    }
}
