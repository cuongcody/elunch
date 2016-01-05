<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Floors_model extends CI_Model {

    private static $db;

    function __construct() {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    /**
     * Get all floors
     *
     * @return      array
     */
    static function get_all_floors()
    {
        self::$db->cache_on();
        $query = self::$db->get('floors');
        return (array)$query->result();
    }

    /**
     * Get number of floors
     *
     * @return      int
     */
    static function get_num_of_floors()
    {
        $query = self::$db->get('floors');
        return $query->num_rows();
    }

    /**
     * Get floor by id
     *
     * @param       int  $floor_id
     * @return      object
     */
    static function get_floor_by_id($floor_id)
    {
        $query = self::$db->get_where('floors', array('id' => $floor_id));
        return $query->first_row();
    }

    /**
     * Insert new floor
     *
     * @param       string  $name
     * @param       string  $decription
     * @return      bool
     */
    static function insert_floor($name, $decription)
    {
        self::$db->cache_delete('admin', 'floors');
        self::$db->cache_delete('admin', 'users');
        $data = array(
            'name' => $name,
            'description' => $decription);
        return self::$db->insert('floors', $data);
    }

    /**
     * Update floor
     *
     * @param       int  $floor_id
     * @param       string  $name
     * @param       string  $decription
     * @return      bool
     */
    static function update_floor($floor_id, $name, $description)
    {
        self::$db->cache_delete('admin', 'floors');
        self::$db->cache_delete('admin', 'users');
        $data = array(
            'name' => $name,
            'description'=> $description,
            'updated_at' => date('Y-m-d H:i:s'));
        self::$db->where('id', $floor_id);
        return self::$db->update('floors', $data);
    }

    /**
     * Delete floor
     *
     * @param       int  $floor_id
     * @return      bool
     */
    static function delete_floor($floor_id)
    {
        $have_users_in_floor = self::$db->get_where('users', array('floor_id' => $floor_id))->num_rows();
        if ($have_users_in_floor > 0) return FALSE;
        else return self::$db->delete('floors', array('id' => $floor_id));
    }
}
