<?php

class MasterUser extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MasterUser_model');
    }

    public function index()
    {
        $data['title'] = 'Master User';
        $data['users'] = $this->MasterUser_model->getAllMaster();
        if ($this->input->post('keyword')) {
            $data['master_user'] = $this->MasterUser_model->cariMasterUser();
        } else {
            $data['master_user'] = $this->MasterUser_model->getAllMaster();
        }
        $this->load->view('templates/header', $data);
        $this->load->view('Master user/index', $data);
        $this->load->view('templates/footer');
    }
}
