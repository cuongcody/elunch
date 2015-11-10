<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shifts_model extends CI_Model {

    function get_all_shifts()
    {
        $query = $this->db->get('shifts');
        return (array)$query->result();
    }

}
