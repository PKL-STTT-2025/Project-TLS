<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property MstWorkgroup $MstWorkgroup_model
 */
class MstWorkgroup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MstWorkgroup_model');
    }

    public function index()
    {
        $data['title'] = 'MstWorkgroup';
        $data['operation'] = $this->MstWorkgroup_model->getActiveOperation();
        $this->load->view('mstworkgroup/mstwg', $data);
    }
}
