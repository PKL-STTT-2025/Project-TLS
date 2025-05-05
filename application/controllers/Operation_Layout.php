<?php

class Operation_Layout extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Operation_Layout_model');
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = 'Operation Layout';
        $data['master_opt_layout'] = $this->Operation_Layout_model->getAllOperationLayout();
        if ($this->input->post('keyword')) {
            $data['master_opt_layout'] = $this->Operation_Layout_model->cariOperationLayout();
        }
        $this->load->view('templates/header', $data);
        $this->load->view('Operation_Layout/index', $data);
        $this->load->view('templates/footer');
    }
}