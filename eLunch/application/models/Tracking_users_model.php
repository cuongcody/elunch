<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking_users_model extends CI_Model {

    /**
     * Get all status
     *
     * @return      array
     */
    function get_all_status()
    {
        return $this->db->get('status_user')->result();
    }

    /**
     * Get tables with status of users in table
     *
     * @param       int  $table_id
     * @param       int  $day( NORMAL DAY OR VEGAN DAY)
     * @return      array
     */
    function get_status_of_users_in_tables($table_ids, $day = NULL)
    {
        $tables = array();
        $users= array();
        foreach ($table_ids as $table_id)
        {
            $table = array();
            $table['id'] = $table_id;
            $this->db->select('users.*, floors.id AS floor_id, floors.name AS floor, tracking_users.status_id, tracking_users.updated_at AS last_updated_status, tracking_users.manually_set');
            $this->db->from('tables_users');
            $this->db->join('users', 'tables_users.user_id = users.id');
            $this->db->join('floors', 'users.floor_id = floors.id', 'left');
            $this->db->join('tracking_users', 'users.id = tracking_users.user_id', 'left');
            $this->db->where('table_id', $table_id);
            if (!is_null($day) && $day == VEGAN_DAY)
            {
                $this->db->where('vegan_day', VEGAN_DAY);
            }
            elseif (!is_null($day) && $day == NORMAL_DAY) $this->db->where('vegan_day', NORMAL_DAY);
            $users = $this->db->get()->result();
            $user_ids = array();
            $current_date = date('Y-m-d');
            $before_current_day_timeout_mins = date("Y-m-d H:i:s", strtotime('-'.TIMEOUT.' minutes', time()));
            foreach ($users as $user)
            {
                if(($user->last_updated_status < $before_current_day_timeout_mins && $user->manually_set == 0 && date('Y-m-d', strtotime($user->last_updated_status)) == $current_date) OR date('Y-m-d', strtotime($user->last_updated_status)) != $current_date)
                {
                    $user_ids[] = $user->id;
                    $user->status_id = ABSENT;
                }
            }
            if ($user_ids != NULL)
            {
                $this->load->model('tracking_users_model');
                $this->tracking_users_model->update_status_users($user_ids, ABSENT, 0);
            }
            $table['users'] = $users;
            array_push($tables, $table);
        }
        return $tables;
    }

    /**
     * Check time to check-in for user
     *
     * @param       int  $user_id
     * @param       int  $status_ids
     * @return      bool
     */
     function check_time_update_user($user_id, $status)
    {
        $this->db->select('shifts.start_time, shifts.end_time, DATE_FORMAT(tracking_users.updated_at, "%Y-%m-%d") AS updated_date, tracking_users.manually_set');
        $this->db->from('users');
        $this->db->join('shifts', 'users.shift_id = shifts.id');
        $this->db->join('tracking_users', 'tracking_users.user_id = users.id');
        $this->db->where('users.id', $user_id);
        $result = $this->db->get()->first_row();
        $current_time = date('H:i:s');
        $current_date = date('Y-m-d');
        $is_on_time = ($current_time > $result->start_time && $current_time < $result->end_time);
        if ($is_on_time && ($result->manually_set == 0 OR $result->updated_date != $current_date))
        {
            return $this->update_status_users(array($user_id), $status, 0);
        }
        else return FALSE;
    }

    /**
     * Insert status for user
     *
     * @param       int  $user_id
     * @param       int  $status
     * @return      bool
     */
    function insert_status_user($user_id, $status)
    {
        return $this->db->insert('tracking_users', array('user_id' => $user_id, 'status_id' => $status, 'updated_at' => date('Y-m-d H:i:s')));
    }

    /**
     * Update status for user
     *
     * @param       int  $user_id
     * @param       int  $status
     * @param       int  $manually_set
     * @return      bool
     */
    function update_status_users($user_ids, $status, $manually_set)
    {
        $this->db->where_in('user_id', $user_ids);
        return $this->db->update('tracking_users', array('status_id' => $status, 'manually_set' => $manually_set, 'updated_at' => date('Y-m-d H:i:s')));
    }

}
