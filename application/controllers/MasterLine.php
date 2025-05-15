<?php

/**
 * @property CI_MasterLine_model $MasterLine_model
 * @property CI_input $input
 */
class MasterLine extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MasterLine_model');
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = 'Master Line';

        if ($this->input->post('keyword')) {
            $data['master_line'] = $this->MasterLine_model->cariMasterLine();
        } else {
            $data['master_line'] = $this->MasterLine_model->getAllLine();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('Master_Line/index', $data);
        $this->load->view('templates/footer');
    }
}
