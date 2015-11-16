<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shifts_model extends CI_Model {

    /**
     * Get all shifts
     *
     * @return      array
     */
    function get_all_shifts()
    {
        $query = $this->db->get('shifts');
        return (array)$query->result();
    }

    /**
     * Get number of shifts
     *
     * @return      int
     */
    function get_num_of_shifts()
    {
        $query = $this->db->get('shifts');
        return $query->num_rows();
    }

    /**
     * Get shift by id
     *
     * @param       int  $shift_id
     * @return      object
     */
    function get_shift_by_id($shift_id)
    {
        $query = $this->db->get_where('shifts', array('id' => $shift_id));
        return $query->first_row();
    }

    /**
     * Get users by shift
     *
     * @param       int  $shift_id
     * @return      array
     */
    function get_users_by_shift($shift_id)
    {

        $this->db->select('users.*, floors.name AS floor, shifts.name AS shift, shifts.id AS shift_id, shifts.start_time, shifts.end_time');
        $this->db->from('users');
        $this->db->join('floors', 'users.floor_id = floors.id');
        $this->db->join('shifts', 'users.shift_id = shifts.id');
        $this->db->where('shift_id', $shift_id);
        $this->db->order_by('users.first_name');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Insert new shift
     *
     * @param       int  $data
     * @return      bool
     */
    function insert_shift($data)
    {
        return $this->db->insert('shifts', $data);
    }

    /**
     * Update shift
     *
     * @param       int  $shift_id
     * @param       array  $data
     * @return      bool
     */
    function update_shift($shift_id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $shift_id);
        return $this->db->update('shifts', $data);
    }

    /**
     * Delete shift
     *
     * @param       int  $shift_id
     * @return      bool
     */
    function delete_shift($shift_id)
    {
        $have_users_in_shift = $this->db->get_where('tables', array('shift_id' => $shift_id))->num_rows();
        if ($have_users_in_shift > 0) return FALSE;
        else return $this->db->delete('shifts', array('id' => $shift_id));
    }

}
