<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OperationBreakdown_model extends CI_Model
{

    public function getActiveOperation()
    {
        return $this->db->get('operation_breakdown')->result();
    }
}
