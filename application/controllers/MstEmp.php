<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property MstEmp $MstEmp_model
 */
class MstEmp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MstEmp_model');
    }

    public function index()
    {
        $data['title'] = 'MstEmp';
        $data['operation'] = $this->MstEmp_model->getActiveOperation();
        $this->load->view('mstemp/mstempl', $data);
    }
}
