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

        $data['title'] = 'Detail Checking Time';
        $data['line_name'] = '';
        $data['operators'] = $this->Supervisor_model->getLimitedEmployee($id_transaksi_checking);
        $data['operation_name'] = $this->Supervisor_model->getLimitedOperation(10);
        $data['layouts'] = $this->Supervisor_model->getLayoutWithMesin($id_transaksi_checking);
        $data['operation_defects'] = $this->Supervisor_model->getDefectsPerOperation($id_transaksi_checking);

        // Ambil layout
        $layouts = $this->Supervisor_model->getLayoutWithMesin($id_transaksi_checking);

        // Ambil defects per operator
        $operation_defects = $this->Supervisor_model->getDefectsPerOperation($id_transaksi_checking);

        // Hitung defect count per op_code
        $defectCounts = [];
        foreach ($operation_defects as $defect) {
            $id_detail = $defect['id_transaksi_checking_detail'];
            if (!isset($defectCounts[$id_detail])) {
                $defectCounts[$id_detail] = 0;
            }
            $defectCounts[$id_detail] += $defect['jumlah'];
        }

        // Tambahkan defect_count & operator_name ke masing-masing layout item
        foreach ($layouts as $layout) {
            $layout->defect_count = 0;
            $layout->operator_name = '-';

            foreach ($data['operators'] as $op) {
                if (trim($layout->op_code) === trim($op->op_code)) {
                    $layout->operator_name = $op->operator_name;

                    // cari defect count dari transaksi_checking_detail yang sesuai
                    foreach ($operation_defects as $defect) {
                        if ($defect['id_transaksi_checking_detail'] == $op->id_transaksi_checking_detail) {
                            $layout->defect_count += $defect['jumlah'];
                        }
                    }
                }
            }
        }

        $data['layouts'] = $layouts;
        $data['operation_defects'] = $operation_defects;

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
