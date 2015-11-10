<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Floors_model extends CI_Model {

    /**
     * Get all floors
     *
     * @return      array
     */
    function get_all_floors()
    {
        $query = $this->db->get('floors');
        return (array)$query->result();
    }

    /**
     * Get number of floors
     *
     * @return      int
     */
    function get_num_of_floors()
    {
        $query = $this->db->get('floors');
        return $query->num_rows();
    }

    /**
     * Get floor by id
     *
     * @param       int  $floor_id
     * @return      object
     */
    function get_floor_by_id($floor_id)
    {
        $query = $this->db->get_where('floors', array('id' => $floor_id));
        return $query->first_row();
    }

    /**
     * Inser new floor
     *
     * @param       string  $name
     * @param       string  $decription
     * @return      bool
     */
    function insert_floor($name, $decription)
    {
        $data = array(
            'name' => $name,
            'description' => $decription);
        return $this->db->insert('floors', $data);
    }

    /**
     * Update floor
     *
     * @param       int  $floor_id
     * @param       string  $name
     * @param       string  $decription
     * @return      bool
     */
    function update_floor($floor_id, $name, $description)
    {
        $data = array(
            'name' => $name,
            'description'=> $description,
            'updated_at' => date('Y-m-d H:i:s'));
        $this->db->where('id', $floor_id);
        return $this->db->update('floors', $data);
    }

    /**
     * Delete floor
     *
     * @param       int  $floor_id
     * @return      bool
     */
    function delete_floor($floor_id)
    {
        $have_users_in_floor = $this->db->get_where('users', array('floor_id' => $floor_id))->num_rows();
        if ($have_users_in_floor > 0) return FALSE;
        else return $this->db->delete('floors', array('id' => $floor_id));
    }
}
