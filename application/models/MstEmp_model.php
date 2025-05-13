<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MstEmp_model extends CI_Model
{

    public function getActiveOperation()
    {
        return $this->db->get('mstemp')->result();
    }
}
