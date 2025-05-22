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
    public function cariTransaksiChecking($keyword)
    {
    $this->input->post('keyword', true);
    $this->db->like('employee_name', $keyword);
    $this->db->or_like('op_name', $keyword);
    $this->db->or_like('op_code', $keyword);
    $this->db->or_like('deskripsi_defect', $keyword);
    $this->db->or_like('kategori_defect', $keyword);
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
        
        $this->db->select('name')->from('mstemp')->limit(5);
        $operators = $this->db->get()->result_array();
        
        $this->db->select('op_name')->from('master_opt_layout')->limit(5);
        $proses = $this->db->get()->result_array();
        
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

    public function insert($data)
    {
        $id_workgroup = $this->input->post('id_workgroup');
        $id_style = $this->input->post('id_style');

        $this->db->insert('transaksi_checking', $data);
    }
    
    public function hapusDataInputDefect($id)
    {
        //$this->db->where('id', $id);
        $this->db->delete('transaksi_checking', ['id_transaksi_checking'=>$id]);
    }

    public function getTransaksiById($transaksi_id)
    {
        $this->db->select('t.*, w.Workgroup, o.style, e.name as employee_name');
        $this->db->from('transaksi_checking t');
        $this->db->join('mstworkgroup w', 'w.idWG = t.id_workgroup', 'left');
        $this->db->join('operation_breakdown o', 'o.id = t.id_style', 'left');
        $this->db->join('mstemp e', 'e.empID = t.id_employee', 'left');
        $this->db->where('t.id_transaksi_checking', $transaksi_id);
        $transaksi = $this->db->get()->row_array();

        if (!$transaksi) {
            return false;
        }
        $this->db->select('DISTINCT(t.op_name), t.op_code, m.name as machine_name');
        $this->db->from('transaksi_checking t');
        $this->db->join('master_opt_layout l', 'l.op_code = t.op_code', 'left');
        $this->db->join('jns_barang m', 'm.id_jnsbarang = l.id_machine', 'left');
        $this->db->where('t.id_transaksi_checking', $transaksi_id);
        $operations = $this->db->get()->result_array();


        foreach ($operations as &$op) {
            $this->db->select('t.id_transaksi_checking, t.kode_defect, d.deskripsi_defect, d.kategori_defect');
            $this->db->from('transaksi_checking t');
            $this->db->join('master_defect d', 'd.kode_defect = t.kode_defect', 'left');
            $this->db->where('t.id_transaksi_checking', $transaksi_id);
            $this->db->where('t.op_name', $op['op_name']);
            $op['defects'] = $this->db->get()->result_array();
        }

        return [
            'transaksi' => $transaksi,
            'operations' => $operations
        ];
    }


    public function ubahDataInputDefect($id)
    {
    $data = [
        "id_workgroup" => $this->input->post('id_workgroup', true),
        "id_style" => $this->input->post('id_style', true),
        "empID" => $this->input->post('empID', true),
        "employee_name" => $this->input->post('employee_name', true),
        "op_name" => $this->input->post('op_name', true),
        "op_code" => $kodeDefect,
        "kode_defect" => $this->input->post('kode_defect', true),
        "deskripsi_defect" => $this->input->post('deskripsi_defect', true),
        "kategori_defect" => $this->input->post('kategori_defect', true),
        
    ];

    $this->db->where('id_transaksi_checking', $this->input->post('id_transaksi_checking'));
    $this->db->update('transaksi_checking', $data);
    }
    public function update($id, $data)
    {
        $this->db->where('id_transaksi_checking', $id);
        $this->db->update('transaksi_checking', $data);
        return $this->db->affected_rows();
    }


    // public function cariDataInputDefect()
    // {
    //     $keyword= $this->input->post('keyword',true);
    //     $this->db->like('operation_name',$keyword);
    //     $this->db->or_like('operation_code', $keyword);
    //     $this->db->or_like('employee_name', $keyword);
    //     return $this->db->get('transaksi_checking')->result_array();
    // }

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
        $this->db->select('kode_defect, deskripsi_defect, kategori_defect');
        $this->db->from('master_defect');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getById ($id)
    {
        return $this->db->get_where('mstworkgroup', ['idWG' => $id])->row();
    }
    public function getStyleById($id)
    {
        return $this->db->get_where('operation_breakdown', ['id' => $id])->row();
    }

    public function getUserById ($id)
    {
        $this->db->select('name');
        $this->db->from('mstemp');
        $this->db->where('empID', $id);
        return $this->db->get()->row();
    }

    public function getLineById($id)
    {
        $this->db->select('Workgroup');
        $this->db->from('mstworkgroup');
        $this->db->where('idWG', $id);
        return $this->db->get()->row();
    }

    // public function searchData($keyword)
    // {
    //     $this->db->like('employee_name', $keyword);
    //     $this->db->or_like('op_name', $keyword);
    //     $this->db->or_like('op_code', $keyword);
    //     $this->db->or_like('deskripsi_defect', $keyword);
    //     $this->db->or_like('kategori_defect', $keyword);
    //     return $this->db->get('transaksi_checking')->result_array();
    // }
    // Dalam TransaksiChecking_model.php
    public function getLimitedEmployee($limit = 2)
    {
        $this->db->select('*');
        $this->db->from('mstemp'); 
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }
    public function getLimitedOperation($limit = 2)
{
    $this->db->select('*');
    $this->db->from('master_opt_layout'); 
    $this->db->limit($limit);
    return $this->db->get()->result_array();
}

public function getLayoutWithMesin($limit = 2)
{
    $this->db->select('
        l.op_code,
        l.op_name,
        m.name as nama_mesin
    ');
    $this->db->from('master_opt_layout l');
    $this->db->join('jns_barang m', 'm.id_jnsbarang = l.id_machine', 'left');
    $this->db->limit($limit);
    return $this->db->get()->result();
}

public function getCodeandDeskripsiDefectByID($id)
{
    $this->db->select('kode_defect, deskripsi_defect, kategori_defect');
    $this->db->from('master_defect');
    $this->db->where_in('id', $id);
    return $this->db->get()->row();

}
public function simpanTransaksi($data)
{
    $this->db->insert('transaksi_checking', $data);
    return $this->db->insert_id();
}

public function simpanDetail($data)
{
    $this->db->insert('transaksi_checking_detail', $data);
    return $this->db->insert_id();
}

public function simpanDefect($data)
{
    $this->db->insert('transaksi_defect', $data);
    return $this->db->insert_id();
}

public function getDefectByDescription($description)
{
    $this->db->where('deskripsi_defect', $description);
    return $this->db->get('master_defect')->row();
}
}