<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access_point_model extends CI_Model {

    private static $db;

    function __construct() {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    /**
     * Get all access point
     *
     * @param       int  $selected
     * @return      array
     */
    static function get_all_access_point($selected = NULL)
    {
        $data = (!is_null($selected)) ? array('selected' => $selected) : array();
        $query = self::$db->get_where('access_point', $data);
        return (array)$query->result();
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

    /**
     * Insert new access point
     *
     * @param       string  $ssid
     * @param       string  $bssid
     * @param       int     $selected
     * @return      bool
     */
    function insert_access_point($ssid, $bssid, $selected)
    {
        $data = array(
            'ssid' => $ssid,
            'bssid' => $bssid,
            'selected' => $selected);
        if ($this->db->insert('access_point', $data))
        {
            if ($selected == SELECTED)
            {
                $this->push_notification_change_access_point();
            }
            return TRUE;
        }
        else return FALSE;
    }

    /**
     * Update access point
     *
     * @param       int  $access_point_id
     * @param       string  $ssid
     * @param       string  $bssid
     * @param       int     $selected
     * @return      bool
     */
    function update_access_point($access_point_id, $ssid, $bssid, $selected)
    {
        $data = array(
            'ssid' => $ssid,
            'bssid'=> $bssid,
            'selected' => $selected,
            'updated_at' => date('Y-m-d H:i:s'));
        $this->db->where('id', $access_point_id);
        if ($this->db->update('access_point', $data))
        {
            if ($selected == SELECTED)
            {
                $this->push_notification_change_access_point();
            }
            return TRUE;
        }
        else return FALSE;
    }

    /**
     * Delete access point by id
     *
     * @param       int  $access_point_id
     * @return      bool
     */
    function delete_access_point($access_point_id)
    {
        $data = array('id' => $access_point_id);
        if ($this->db->delete('access_point', $data))
        {
            $this->push_notification_change_access_point();
            return TRUE;
        }
        else return FALSE;
    }

    /**
     * Push notification for mobile when Admin change access point
     *
     * @return      bool
     */
    function push_notification_change_access_point()
    {
        // Get all access point have selected
        $access_point = $this->get_all_access_point(SELECTED);
        if ($access_point != NULL)
        {
            $this->load->model('users_model');
            $users = Users_model::get_all_users();
            $registation_ids = array();
            if ($users != NULL)
            {
                foreach ($users as $user)
                {
                    if ($user->gcm_regid != NULL) $registation_ids[] = $user->gcm_regid;
                }
            }
            if ($registation_ids != NULL)
            {
                $send_notification['data'] = array(
                'type' => 'config_access_point',
                'access_point' => $access_point);
                $this->common->send_notification($registation_ids, $send_notification);
                return TRUE;
            }
            else return FALSE;
        }
        else return FALSE;
    }

}
