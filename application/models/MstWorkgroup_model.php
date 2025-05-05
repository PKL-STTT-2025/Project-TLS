<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MstWorkgroup_model extends CI_Model
{

    public function getActiveOperation()
    {
        return $this->db->get('mstworkgroup')->result();
    }
}
