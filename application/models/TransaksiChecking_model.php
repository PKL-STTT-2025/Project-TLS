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

//     public function getLayoutByLine($id_line)
// {
//     $this->db->select('id_master_opt_layout, op_name, op_code, id_machine'); 
//     $this->db->from('master_opt_layout');
//     $this->db->where('id_wg', $id_line);
//     return $this->db->get()->result();
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
        $id_jnsbarang = $this->input->post('id_jnsbarang', true);

        $this->db->select('name');
        $this->db->from('mstemp');
        $this->db->where('empID', $empID);
        $operator = $this->db->get()->row_array();

        $this->db->select('op_name');
        $this->db->from('master_opt_layout');
        $this->db->where('op_code', $operationcode);
        $proses = $this->db->get()->row_array();

        $this->db->select('id_jnsbarang');  // atau select('*') kalau mau lengkap
        $this->db->from('jns_barang');
        $this->db->where('id_jnsbarang', $id_jnsbarang);
        $machine = $this->db->get()->row_array();

        $data = [
            'empID' => $empID,
            'employee_name' => $operator['name'] ?? 'Unknown',
            'operation_code' => $operationcode,
            'operation_name' => $proses['op_name'] ?? 'Unknown',
            'kode_defect' => $kodeDefect,
            'deskripsi_defect' => $this->input->post('deskripsi_defect', true),
            'kategori_defect' => $this->input->post('kategori_defect', true), 
            'id_jnsbarang' => $machine['id_jnsbarang'] ?? null,
        ];

        $this->db->insert('transaksi_checking', $data);
        return $this->db->insert_id();
    }


    public function insert($data)
    {
        $id_workgroup = $this->input->post('id_wg');
        $id_style = $this->input->post('id_opb');
        $color = $this->input->post('color');
        $orc = $this->input->post('orc');

        $this->db->insert('transaksi_checking', $data);
    }
    

    public function getTransaksiById($transaksi_id)
    {
        $this->db->select('t.*, w.Workgroup, o.style, e.name AS employee_name');
        $this->db->from('transaksi_checking t');
        $this->db->join('mstworkgroup w', 'w.idWG = t.id_wg');
        $this->db->join('operation_breakdown o', 'o.id = t.id_opb');
        $this->db->join('transaksi_checking_detail d', 'd.id_transaksi_checking = t.id_transaksi_checking', 'left');
        $this->db->join('mstemp e', 'e.empID = d.empID', 'left');
        $this->db->where('t.id_transaksi_checking', $transaksi_id);
        $query = $this->db->get();
    
        $transaksi = $query->row_array(); 
    
        if (!$transaksi) {
            return false;
        }
    
        $this->db->select('d.id_transaksi_checking_detail, d.op_name, d.op_code, d.id_master_opt_layout, m.name as machine_name, e.name as employee_name');
        $this->db->from('transaksi_checking_detail d');
        $this->db->join('master_opt_layout l', 'l.id = d.id_master_opt_layout', 'left');
        $this->db->join('jns_barang m', 'm.id_jnsbarang = l.id_machine', 'left');
        $this->db->join('mstemp e', 'e.empID = d.empID', 'left'); 
        $this->db->where('d.id_transaksi_checking', $transaksi_id);        
        $operations = $this->db->get()->result_array();
    
        foreach ($operations as &$op) {
            $this->db->select('td.id_transaksi_checking_detail, td.id_defect, def.deskripsi_defect');
            $this->db->from('transaksi_defect td');
            $this->db->join('master_defect def', 'def.id = td.id_defect', 'left');
            $this->db->where('td.id_transaksi_checking_detail', $transaksi_id);
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
        "id_wg" => $this->input->post('id_wg', true),
        "id_opb" => $this->input->post('id_opb', true),
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
        $this->db->select('id,kode_defect, deskripsi_defect, kategori_defect');
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

public function getLimitedOperator($id_transaksi_checking)
{
    $this->db->select('transaksi_checking_detail.*, mstemp.name AS operator_name');
    $this->db->from('transaksi_checking_detail');
    $this->db->join('mstemp', 'transaksi_checking_detail.empID = mstemp.empID');
    $this->db->where('transaksi_checking_detail.id_transaksi_checking', $id_transaksi_checking);
    $this->db->group_by('transaksi_checking_detail.op_code');
    $this->db->order_by('transaksi_checking_detail.id_transaksi_checking_detail', 'ASC');
    $query = $this->db->get();

    $result = $query->result();
    return $result;
}

public function getLayout($id_transaksi_checking)
{

    $query = "SELECT 
        d.op_code,
        d.op_name,
        jb.name AS nama_mesin,
        IFNULL(SUM(td.jumlah), 0) AS defect_count
        FROM transaksi_checking_detail d
        LEFT JOIN jns_barang jb ON jb.id_jnsbarang = d.id_jnsbarang
        LEFT JOIN transaksi_defect td ON td.id_transaksi_checking_detail = d.id_transaksi_checking_detail
        WHERE d.id_transaksi_checking = ?
        GROUP BY d.op_code
        ORDER BY defect_count DESC
    ";
     return $this->db->query($query, [$id_transaksi_checking])->result();
}

public function getDefectsPerOperation($id_transaksi_checking)
{
    $query = "SELECT 
    tcd.op_name,
    td.id_transaksi_defect,
    td.id_transaksi_checking_detail,
    td.id_defect,
    md.deskripsi_defect,
    td.jumlah,
    td.note
FROM 
    transaksi_defect td
JOIN 
    master_defect md ON td.id_defect = md.id
JOIN
    transaksi_checking_detail tcd ON td.id_transaksi_checking_detail = tcd.id_transaksi_checking_detail
WHERE 
    tcd.id_transaksi_checking = $id_transaksi_checking
ORDER BY tcd.op_name ASC
";
    return $this->db->query($query)->result_array();
}

public function getDefectsByDetail($id_transaksi_checking_detail)
    {
        $query = "SELECT 
        td.id_transaksi_defect,
        td.id_transaksi_checking_detail,
        td.id_defect,
        md.deskripsi_defect,
        td.jumlah,
        td.note
    FROM 
        transaksi_defect td
    JOIN 
        master_defect md ON td.id_defect = md.id
    JOIN 
        transaksi_checking_detail tcd ON td.id_transaksi_checking_detail = tcd.id_transaksi_checking_detail
    WHERE 
        tcd.id_transaksi_checking_detail = ?
    ";
        return $this->db->query($query, [$id_transaksi_checking_detail])->result_array();
    }

// public function getLayoutWithMesin($limit=2)
// {
//     $this->db->select('l.id as id_master_opt_layout, l.op_name, l.op_code, l.id_machine, m.name as machine_name');
//     $this->db->from('master_opt_layout l');
//     $this->db->join('jns_barang m', 'm.id_jnsbarang = l.id_machine', 'left');
//     $this->db->limit($limit);
//     return $this->db->get()->result();
// }
public function getLayoutWithMesin($limit = 2)
{
    $this->db->select('
        l.id as id_master_opt_layout,
        l.op_name,
        l.op_code,
        l.id_machine,
        m.id_jnsbarang,
        m.name as machine_name
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

 function getDefectsByTransaksi($id_transaksi)
{
    $this->db->select('td.id_defect, md.deskripsi_defect, td.jumlah, md.kategori_defect');
    $this->db->from('transaksi_defect td');
    $this->db->join('master_defect md', 'td.id_defect = md.id');
    $this->db->where('td.id_transaksi_checking_detail', $id_transaksi);
    $query = $this->db->get();
    return $query->result_array();
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
    $this->db->where([
        'id_transaksi_checking_detail' => $data['id_transaksi_checking_detail'],
        'id_defect' => $data['id_defect']
    ]);
    $cek = $this->db->get('transaksi_defect')->row();

    if (!$cek) {
        if (!$this->db->insert('transaksi_defect', $data)) {
            echo "Gagal insert defect: ";
            print_r($this->db->error());
            exit;
        }
    } else {
        $this->db->set('jumlah', 'jumlah + ' . (int)$data['jumlah'], false);
        $this->db->where('id_transaksi_defect', $cek->id_transaksi_defect);
        if (!$this->db->update('transaksi_defect')) {
            echo "Gagal update defect: ";
            print_r($this->db->error());
            exit;
        }
    }
}

public function getDefectByDescription($description)
{
    $trimmed = trim($description);
    $this->db->where('TRIM(deskripsi_defect)', $trimmed);
    $result = $this->db->get('master_defect')->row();

    if (!$result) {
        log_message('error', "DEFECT NOT FOUND: " . $trimmed);
    }

    return $result;
}


public function hapusDataInputDefect($id)
{
    $this->hapusDefectByTransaksiId($id);
    $this->hapusDetailByTransaksiId($id);
    $this->db->where('id_transaksi_checking', $id);
    return $this->db->delete('transaksi_checking');
}

public function hapusDetailByTransaksiId($transaksi_id)
{
    $this->db->where('id_transaksi_checking', $transaksi_id);
    return $this->db->delete('transaksi_checking_detail');
}

public function hapusDefectByTransaksiId($transaksi_id)
{
    $this->db->where('id_transaksi_checking_detail', $transaksi_id);
    $this->db->delete('transaksi_defect');
}
public function getDetailWithJoins($id_transaksi_checking)
{
    $this->db->select('
        d.*, 
        e.name AS employee_name, 
        o.op_code, o.op_name, 
        def.id AS id_defect,
    ');
    $this->db->from('transaksi_checking_detail d');
    $this->db->join('mstemp e', 'd.empID = e.empID');
    $this->db->join('master_opt_layout o', 'd.id_master_opt_layout = o.id');
    $this->db->join('transaksi_defect td', 'td.id_transaksi_checking_detail = d.id_transaksi_checking_detail', 'left');
    $this->db->join('master_defect def', 'td.id_defect = def.id', 'left');
    $this->db->where('d.id_transaksi_checking', $id_transaksi_checking);
    return $this->db->get()->result();
}

public function getDefectsByOpDetailId($id_detail)
{
    $this->db->select('td.id_defect, md.deskripsi_defect');
    $this->db->from('transaksi_defect td');
    $this->db->join('master_defect md', 'td.id_defect = md.id', 'left');
    $this->db->where('td.id_transaksi_checking_detail', $id_detail);
    return $this->db->get()->result_array();
}

public function getLayoutsByWorkgroupAndStyle($id_wg, $id_opb)
{
    $this->db->where('id_wg', $id_wg);
    $this->db->where('id_opb', $id_opb);
    return $this->db->get('transaksi_checking')->result_array(); 
}
// TransaksiChecking_model

public function update_detail($id, $data)
{
    $this->db->where('id_transaksi_checking_detail', $id);
    return $this->db->update('transaksi_checking_detail', $data);
}

public function insert_detail($data)
{
    $this->db->insert('transaksi_checking_detail', $data);
    return $this->db->insert_id();
}

public function update_defect($id, $data)
{
    $this->db->where('id_transaksi_defect', $id);
    return $this->db->update('transaksi_defect', $data);
}

public function insert_defect($data)
{
    $this->db->insert('transaksi_defect', $data);
}
public function getLineNameByTransaksi($id)
{
    $this->db->select('wg.Workgroup AS line_name');
    $this->db->from('transaksi_checking tc');
    $this->db->join('mstworkgroup wg', 'tc.id_wg = wg.idWG');
    $this->db->where('tc.id_transaksi_checking', $id);
    $query = $this->db->get();
    return $query->row()->line_name?? ''; 
}

// application/models/TransaksiChecking_model.php

public function getDetailByTransaksi($id_transaksi)
{
    $this->db->select('d.id_transaksi_checking_detail, d.op_name, d.op_code, d.id_master_opt_layout, d.id_jnsbarang, d.empID, d.id_jnsbarang AS machine_name');
    $this->db->from('transaksi_checking_detail d');
    $this->db->where('d.id_transaksi_checking', $id_transaksi);
    $query = $this->db->get();
    return $query->result_array();
}


}