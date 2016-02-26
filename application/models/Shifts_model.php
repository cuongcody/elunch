<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shifts_model extends CI_Model {

    private static $db;

    function __construct() {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    /**
     * Get all shifts
     *
     * @return      array
     */
    static function get_all_shifts()
    {
        $query = self::$db->get('shifts');
        return (array)$query->result();
    }

    /**
     * Get number of shifts
     *
     * @return      int
     */
    static function get_num_of_shifts()
    {
        $query = self::$db->get('shifts');
        return $query->num_rows();
    }

    /**
     * Get shift by id
     *
     * @param       int  $shift_id
     * @return      object
     */
    static function get_shift_by_id($shift_id)
    {
        $query = self::$db->get_where('shifts', array('id' => $shift_id));
        return $query->first_row();
    }

    /**
     * Get shift by table id
     *
     * @param       int  $table_id
     * @return      object
     */
    static function get_shift_by_table_id($table_id)
    {
        self::$db->select('shifts.*, tables.id');
        self::$db->from('shifts');
        self::$db->join('tables', 'shifts.id = tables.shift_id');
        self::$db->where('tables.id', $table_id);
        $query = self::$db->get();
        return $query->first_row();
    }

    /**
     * Check kind of shift
     *
     * @param       int  $shift_id
     * @return      bool (TRUE : All users can see this shift, FALSE: Just users in this shift can see )
     */
    static function check_kind_of_shift($shift)
    {
        return ($shift->all_users == TRUE);
    }

    /**
     * Find shifts with all users can see
     *
     * @return      array
     */
    static function find_shifts_all_users_can_see()
    {
        $shifts = self::get_all_shifts();
        $shifts_all_users_can_see = array();
        foreach ($shifts as $shift)
        {
            if (self::check_kind_of_shift($shift))
            {
                $shifts_all_users_can_see[] = $shift;
            }
        }
        return $shifts_all_users_can_see;
    }

    /**
     * Get users by shift
     *
     * @param       int  $shift_id
     * @return      array
     */
    function get_users_by_shift($shift_id)
    {
        if ($this->check_kind_of_shift($this->get_shift_by_id($shift_id)))
        {
            $this->load->model('users_model');
            return $this->users_model->get_all_users();
        }
        else
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

    }

    /**
     * Insert new shift
     *
     * @param       int  $data
     * @return      bool
     */
    static function insert_shift($data)
    {
        self::$db->cache_delete('admin', 'users');
        return self::$db->insert('shifts', $data);
    }

    /**
     * Update shift
     *
     * @param       int  $shift_id
     * @param       array  $data
     * @return      bool
     */
    static function update_shift($shift_id, $data)
    {
        self::$db->cache_delete('admin', 'users');
        $data['updated_at'] = date('Y-m-d H:i:s');
        self::$db->where('id', $shift_id);
        return self::$db->update('shifts', $data);
    }

    /**
     * Delete shift
     *
     * @param       int  $shift_id
     * @return      bool
     */
    static function delete_shift($shift_id)
    {
        self::$db->cache_delete('admin', 'users');
        $have_users_in_shift = self::$db->get_where('tables', array('shift_id' => $shift_id))->num_rows();
        if ($have_users_in_shift > 0) return FALSE;
        else return self::$db->delete('shifts', array('id' => $shift_id));
    }

}
