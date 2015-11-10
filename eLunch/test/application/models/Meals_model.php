<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meals_model extends CI_Model {

    function get_meals($perpage, $offset, $from = NULL, $to = NULL)
    {
        $this->db->select('meals.*, menus.name AS menu_name, menus.id AS menu_id');
        $this->db->from('meals');
        $this->db->join('menus', 'meals.menu_id = menus.id','left');
        if (!is_null($from) && !is_null($to))
        {
            $this->db->where('meals.meal_date >=', $from);
            $this->db->where('meals.meal_date <=', $to);
        }
        $this->db->limit($perpage, $offset)->order_by('meals.meal_date', 'DESC');
        return $this->db->get()->result();
    }

    function get_meal_by_id($meal_id)
    {
        $this->db->select('meals.*, menus.name AS menu_name, menus.id AS menu_id');
        $this->db->from('meals');
        $this->db->join('menus', 'meals.menu_id = menus.id','left');
        $this->db->where('meals.id', $meal_id);
        return $this->db->get()->first_row();
    }

    function get_num_of_meals($from = NULL, $to = NULL)
    {
        if (!is_null($from) && !is_null($to))
        {
            $this->db->where('meals.meal_date >=', $from);
            $this->db->where('meals.meal_date <=', $to);
        }
        return $this->db->get('meals')->num_rows();
    }

    function update_meal($meal_id, $lunch_date, $menu_id, $preordered_meals)
    {
        $data = array(
            'meal_date' => $lunch_date,
            'menu_id' => $menu_id,
            'preordered_meals' => $preordered_meals);
        $this->db->where('id', $meal_id);
        return $this->db->update('meals', $data);
    }

    function insert_meal($lunch_date, $menu_id, $preordered_meals)
    {
        $data = array(
            'meal_date' => $lunch_date,
            'menu_id' => $menu_id,
            'preordered_meals' => $preordered_meals);
        return $this->db->insert('meals', $data);
    }

    function delete_meal($meal_id)
    {
        return $this->db->delete('meals', array('id' => $meal_id));
    }

}
