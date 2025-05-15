<?php

class TransaksiChecking_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllTransaksiChecking()
    {
        $query = $this->db->get('transaksi_checking');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array(); 
        }
    }
    public function cariTransaksiChecking()
    {
    $keyword = $this->input->post('keyword', true);
    $this->db->like('op_name', $keyword);
    return $this->db->get('transaksi_checking')->result_array();
    }

    public function getAlllines()
    {
        $query = $this->db->get('mstworkgroup');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array(); 
        }
    }
   
    public function getAllStyles()
    {
        $query = $this->db->get('operation_breakdown');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array(); 
        }
    }

    public function getStyleByLine($Workgroup) {
        // $this->db->select('DISTINCT(style)');
        // $this->db->from('operation_breakdown');
        // $this->db->where('style IS NOT NULL');
        // $this->db->where('style', $style);
        // return $this->db->get()->row_array();

        $query = "SELECT
                t1.id AS id_operation_breakdown,
                t1.style,
                t1.date_created,
                `mstWorkgroup`.`Workgroup`,
                `mstWorkgroup`.`idWG` AS id_master_workgroup
            FROM 
                `operation_breakdown` AS t1
            JOIN `master_line` ON `master_line`.`id` = t1.id_line
            JOIN `mstWorkgroup` ON `mstWorkgroup`.`idWG` = `master_line`.`line_name`
            WHERE  `mstWorkgroup`.`idWG` = $Workgroup
            ORDER BY `t1`.`date_created` DESC;";

        $result = $this->db->query($query);
        return $result->result_array();
    }

    // public function getlayoutbyline($line)
    // {
    //     $this->db->where('line_name', $line);
    //     $query = $this->db->get('mstworkgroup');
    //     if ($query->num_rows() > 0) {
    //         return $query->result_array();
    //     } else {
    //         return array(); 
    //     }
    // }

    public function getFilteredTransaksi($line, $style)
    {
        $this->db->where('Workgroup', $line);
        $this->db->where('style', $style);
        $query = $this->db->get('mstworkgroup');
        return $query->result_array();

        
//     $layout = $this->db
//     ->where('Workgroup', $line)
//     ->get('mstworkgroup')
//     ->result_array();

// $style_data = $this->db
//     ->where('style', $style)
//     ->get('operation_breakdown')
//     ->result_array();

// // Gabung manual kalau perlu
// return [
//     'layout' => $layout,
//     'style_data' => $style_data
// ];
    }

    public function tambahDataInputDefect()
    {
        $empID = $this->input->post('empID', true);
        $operationcode = $this->input->post('op_code', true);
        $kodeDefect = $this->input->post('kode_defect', true);
        
        $this->db->select('name')->from('mstemp')->where('empID', $empID)->limit(1);
        $operator = $this->db->get()->row_array();
        
        $this->db->select('op_name')->from('master_opt_layout')->where('id', $operationcode)->limit(1);
        $proses = $this->db->get()->row_array();
        
        $data = [
            'empID' => $empID,
            'employee_name' => $operator['name'] ?? 'Unknown',
            'operation_code' => $operationcode,
            'operation_name' => $proses['op_name'] ?? 'Unknown',
            'kode_defect' => $kodeDefect,
            'deskripsi_defect' => $this->input->post('deskripsi_defect', true),
            'kategori' => $this->input->post('kategori', true),
            // 'tanggal_input' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('transaksi_checking', $data);
        return $this->db->insert_id();
    }
        

    public function hapusDataInputDefect($id)
    {
        //$this->db->where('id', $id);
        $this->db->delete('transaksi_checking', ['id'=>$id]);
    }

    public function getTransaksiById($id)
    {
    return $this->db->get_where('transaksi_checking', ['id' => $id])->row_array();
    }


    public function ubahDataInputDefect()
    {
    $data = [
        "operation_name" => $this->input->post('operation_name', true),
        "operation_code" => $this->input->post('operation_code', true),
        "employee_name" => $this->input->post('employee_name', true),
    ];

    $this->db->where('id', $this->input->post('id'));
    $this->db->update('transaksi_checking', $data);
    }

    public function cariDataInputDefect()
    {
        $keyword= $this->input->post('keyword',true);
        $this->db->like('operation_name',$keyword);
        $this->db->or_like('operation_code', $keyword);
        $this->db->or_like('employee_name', $keyword);
        return $this->db->get('transaksi_checking')->result_array();
    }

    public function getAllMasterEmployee()
    {
        $this->db->select('empID, name');
        $this->db->from('mstemp');
        $query = $this->db->get();
    
    // echo $this->db->last_query(); 
    // die();
    
    return $query->result_array();
    }

    public function getAllOperationCode()
    {
        $this->db->select('op_code, op_name');
        $this->db->from('master_opt_layout');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAllOperationName()
    {
        $query = $this->db->get('master_opt_layout');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array(); 
        }
    }

    public function getAllDefect()
    {
        $this->db->select('kode_defect, deskripsi_defect, kategori');
        $this->db->from('master_defect');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getById ($id)
    {
        return $this->db->get_where('mstworkgroup', ['idWG' => $id])->row();
    }
    public function getStyleById ($id)
    {
        return $this->db->get_where('operation_breakdown', ['id' => $id])->row();
    }
}
