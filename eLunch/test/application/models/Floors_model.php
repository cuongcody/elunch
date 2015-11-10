<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Floors_model extends CI_Model {

    function get_all_floors()
    {
        $query = $this->db->get('floors');
        return (array)$query->result();
    }
}

/* End of file Floors_model.php */
/* Location: ./application/models/Floors_model.php */