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
     * Get users by shift
     *
     * @param       int  $shift_id
     * @return      array
     */
    static function get_users_by_shift($shift_id)
    {

        self::$db->select('users.*, floors.name AS floor, shifts.name AS shift, shifts.id AS shift_id, shifts.start_time, shifts.end_time');
        self::$db->from('users');
        self::$db->join('floors', 'users.floor_id = floors.id');
        self::$db->join('shifts', 'users.shift_id = shifts.id');
        self::$db->where('shift_id', $shift_id);
        self::$db->order_by('users.first_name');
        $query = self::$db->get();
        return $query->result();
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
