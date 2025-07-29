<?php

/**
 * @property Supervisor_model $Supervisor_model
 * @property input $input
 * @property session $session
 * @property db $db
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
        $keyword = $this->input->get('keyword');
        if ($keyword) {
            $data['CheckingTime'] = $this->Supervisor_model->getsearchCheckingTime($keyword);
        } else {
            $data['CheckingTime'] = $this->Supervisor_model->getCheckingTime();
        }
        $this->load->view('templates/header', $data);
        $this->load->view('Supervisor/index', $data);
        $this->load->view('templates/footer');
    }
    public function selesai($id_transaksi_checking)
    {
        if ($id_transaksi_checking === null) {
            show_404(); // biar ketauan kalau null
        }

        $this->db->where('id_transaksi_checking', $id_transaksi_checking);
        $this->db->update('transaksi_checking', ['masalah_selesai' => 1]);

        $this->session->set_flashdata('success', 'Masalah ditandai selesai.');
        redirect('Supervisor/index');
    }
    public function detail($id_transaksi_checking)
    {

        $data['title'] = 'Detail Checking Time';
        $data['line_name'] = '';
        $data['operators'] = $this->Supervisor_model->getLimitedEmployee($id_transaksi_checking);
        $data['operation_name'] = $this->Supervisor_model->getLimitedOperation($id_transaksi_checking);
        $data['layouts'] = $this->Supervisor_model->getLayoutWithMesin($id_transaksi_checking);
        $data['operation_defects'] = $this->Supervisor_model->getDefectsPerOperation($id_transaksi_checking);

        // Ambil layout
        $layouts = $this->Supervisor_model->getLayoutWithMesin($id_transaksi_checking);

        // Ambil defects per operator
        $operation_defects = $this->Supervisor_model->getDefectsPerOperation($id_transaksi_checking);

        // Mapping defect count per op_name
        $defectCountsPerOpName = [];
        foreach ($operation_defects as $defect) {
            $op_name = trim($defect['op_name']);
            if (!isset($defectCountsPerOpName[$op_name])) {
                $defectCountsPerOpName[$op_name] = 0;
            }
            $defectCountsPerOpName[$op_name] += $defect['jumlah'];
        }

        // Tambahkan defect_count ke masing-masing layout item berdasarkan op_name
        foreach ($layouts as $layout) {
            $op_name = trim($layout->op_name);
            $layout->defect_count = isset($defectCountsPerOpName[$op_name])
                ? $defectCountsPerOpName[$op_name]
                : 0;

            // tambahan operator name krn punya relasi ke operator
            $layout->operator_name = '-';
            foreach ($data['operators'] as $op) {
                if (trim($layout->op_code) === trim($op->op_code)) {
                    $layout->operator_name = $op->operator_name;
                    break;
                }
            }
        }


        $data['layouts'] = $layouts;
        $data['operation_defects'] = $operation_defects;

        $this->load->view('templates/header', $data);
        $this->load->view('Supervisor/detail', $data);
        $this->load->view('templates/footer');
    }

    public function action_plan($id_transaksi_checking)
    {
        $data['title'] = 'List Checking Time';
        $keyword = $this->input->get('keyword');
        $id_wg   = $this->input->get('id_wg');

        if ($keyword) {
            // Kalau ada keyword, cari yang sesuai
            $data['ActionPlan'] = $this->Supervisor_model->searchActionPlan($id_wg, $keyword);
        } else {
            // Kalau ga ada keyword, ambil semua
            $data['ActionPlan'] = $this->Supervisor_model->getAction($id_transaksi_checking);
        }

        $data['id_transaksi_checking'] = $id_transaksi_checking;

        $this->load->view('templates/header', $data);
        $this->load->view('Supervisor/action_plan', $data);
        $this->load->view('templates/footer');
    }
}