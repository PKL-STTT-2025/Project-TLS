<?php

class master_defect extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master_defect_model');
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = 'Master Defect';
        $data['ms_defects'] = $this->master_defect_model->getAllDefects();
        if ($this->input->post('keyword')) {
            $data['ms_defects'] = $this->master_defect_model->findDefects();
        }
        $this->load->view('templates/header', $data);
        $this->load->view('master_defect/index', $data);
        $this->load->view('templates/footer');
    }
}