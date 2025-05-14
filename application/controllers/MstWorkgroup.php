<?php

/**
 * @property CI_MstWorkgroup_model $MstWorkgroup_model
 */
class MstWorkgroup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MstWorkgroup_model');
        $this->load->library('session');
        $this->load->helper('form');
    }

    public function index()
    {
        $data['title'] = 'Master Workgroup';
        $data['mstworkgroup'] = $this->MstWorkgroup_model->getAllLine();
        if ($this->input->post('keyword')) {
            $data['mstworkgroup'] = $this->MstWorkgroup_model->cariWG();
        }
        $this->load->view('templates/header', $data);
        $this->load->view('mstworkgroup/mstwg', $data);
        $this->load->view('templates/footer');
    }
}
