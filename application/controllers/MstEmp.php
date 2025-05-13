<?php

/**
 * @property CI_MstEmp_model $MstEmp_model
 */
class MstEmp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MstEmp_model');
        $this->load->library('session');
        $this->load->helper('form');
    }

    public function index()
    {
        $data['title'] = 'Master Emp';
        $data['mstemp'] = $this->MstEmp_model->getAllLine();
        if ($this->input->post('keyword')) {
            $data['mstemp'] = $this->MstEmp_model->cariMstEmp();
        }
        $this->load->view('templates/header', $data);
        $this->load->view('mstemp/mstempl', $data);
        $this->load->view('templates/footer');
    }
}
