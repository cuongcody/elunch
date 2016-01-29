<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Preferences_model extends CI_Model {

    private static $db;

    function __construct() {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    /**
     * Get all preferences_categories
     *
     * @param       int  $selected
     * @return      object
     */
    static function get_all_preferences_categories()
    {
        $query = self::$db->get_where('preferences_categories');
        return $query->result();
    }

    /**
     * Get all preferences
     *
     * @param       int  $selected
     * @return      object
     */
    function get_all_preferences()
    {
        $this->join_preferences_and_preferenes_categories();
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get preferences of user
     *
     * @param       int  $selected
     * @return      object
     */
    function get_preferences_of_user($user_id)
    {
        $this->join_preferences_and_preferenes_categories();
        $this->db->join('user_preferences', 'preferences.id = user_preferences.preferences_id');
        $this->db->where('user_preferences.user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }

    function join_preferences_and_preferenes_categories()
    {
        $this->db->select('preferences.*, preferences_categories.name AS preferences_categories_name');
        $this->db->from('preferences_categories');
        $this->db->join('preferences', 'preferences_categories.id = preferences.preferences_categories_id');
        $this->db->order_by('preferences_categories.id', 'ASC');
        $this->db->order_by('preferences.id', 'ASC');
    }

    function insert_preferences_for_user($user_id, $preferences_ids)
    {
        $this->db->trans_begin();
        $this->delete_preferences_for_user($user_id);
        $datas = array();
        foreach ($preferences_ids as $key => $value)
        {
            $data = array();
            $data['user_id'] = $user_id;
            $data['preferences_id'] = $value;
            array_push($datas, $data);
        }
        if ($datas != NULL) $this->db->insert_batch('user_preferences', $datas);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    static function delete_preferences_for_user($user_id)
    {
        self::$db->delete('user_preferences', array('user_id' => $user_id));
    }

    /**
     * Get number of access point
     *
     * @return      int
     */
    static function get_num_of_access_point()
    {
        $query = self::$db->get('access_point');
        return $query->num_rows();
    }

    /**
     * Get access point by id
     *
     * @param       int  $access_point_id
     * @return      Object
     */
    static function get_access_point_by_id($access_point_id)
    {
        $query = self::$db->get_where('access_point', array('id' => $access_point_id));
        return $query->first_row();
    }

}
