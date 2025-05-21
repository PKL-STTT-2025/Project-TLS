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
    public function detail()
    {
        $data['operators'] = $this->Supervisor_model->getLimitedEmployee(10);
        $data['operation_name'] = $this->Supervisor_model->getLimitedOperation(10);
        $data['layouts'] = $this->Supervisor_model->getLayoutWithMesin(10);
        $this->load->view('templates/header', $data);
        $this->load->view('Supervisor/detail', $data);
        $this->load->view('templates/footer');
    }
}
