<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meals_model extends CI_Model {

    /**
     * Get all meals based on pagination or date
     *
     * @param       int  $perpage
     * @param       int  $offset
     * @param       int  $from
     * @param       int  $to
     * @return      array
     */
    function get_meals($perpage, $offset, $from = NULL, $to = NULL)
    {
        $query = "SELECT meals.*, menus.name AS  menu_name , menus.id AS menu_id , IF(ISNULL(meals_log.meal_date ) , 0, meals_log.meal_date) AS check_log
                    FROM  meals
                    LEFT JOIN  menus ON  meals.menu_id =  menus.id
                    LEFT JOIN meals_log ON meals.meal_date = meals_log.meal_date";
        if (!is_null($from) && !is_null($to))
        {
            $query .= " WHERE meals.meal_date >= ? AND meals.meal_date <= ?
                        GROUP BY meals.id ORDER BY meals.meal_date DESC LIMIT ?, ? ";
            return $this->db->query($query, array($from, $to, (int)$offset, (int)$perpage))->result();
        }
        $query .= " GROUP BY meals.id ORDER BY meals.meal_date DESC LIMIT ?, ? ";
        return $this->db->query($query, array((int)$offset, (int)$perpage))->result();
    }

    /**
     * Get meal by id
     *
     * @param       int  $meal_id
     * @return      object
     */
    function get_meal_by_id($meal_id)
    {
        $this->db->select('meals.*, menus.name AS menu_name, menus.id AS menu_id');
        $this->db->from('meals');
        $this->db->join('menus', 'meals.menu_id = menus.id','left');
        $this->db->where('meals.id', $meal_id);
        return $this->db->get()->first_row();
    }

    /**
     * Get number of meal
     *
     * @param       date(Y-m-d)  $from
     * @param       date(Y-m-d)  $to
     * @return      int
     */
    function get_num_of_meals($from = NULL, $to = NULL)
    {
        if (!is_null($from) && !is_null($to))
        {
            $this->db->where('meals.meal_date >=', $from);
            $this->db->where('meals.meal_date <=', $to);
        }
        return $this->db->get('meals')->num_rows();
    }

    /**
     * Update meal
     *
     * @param       int  $meal_id
     * @param       int  $menu_id
     * @param       int  $preordered_meals
     * @return      bool
     */
    function update_meal($meal_id, $menu_id, $preordered_meals)
    {
        $data = array(
            'menu_id' => $menu_id,
            'preordered_meals' => $preordered_meals);
        $this->db->where('id', $meal_id);
        return $this->db->update('meals', $data);
    }

    /**
     * Insert new meal
     *
     * @param       date(Y-m-d)  $meal_date
     * @param       int  $menu_id
     * @param       int  $preordered_meals
     * @return      bool
     */
    function insert_meal($meal_date, $menu_id, $preordered_meals)
    {
        $data = array(
            'meal_date' => $meal_date,
            'menu_id' => $menu_id,
            'preordered_meals' => $preordered_meals);
        return $this->db->insert('meals', $data);
    }

    /**
     * Delete meal
     *
     * @param       int  $meal_id
     * @return      bool
     */
    function delete_meal($meal_id)
    {
        return $this->db->delete('meals', array('id' => $meal_id));
    }

    /**
     * Generate a log file of meal
     *
     * @param       date(Y-m-d)  $meal_date
     * @return      bool
     */
    function gen_log_file_meal($meal_date)
    {
        return $this->db->insert('meals_log', array('meal_date' => $meal_date));
    }

    function get_meal_log($meal_date)
    {
        $this->db->select('meals.*, meals_log.actual_meals, meals_log.note, meals_log.tracking_log, meals_log.created_at AS meal_log_created_at');
        $this->db->from('meals');
        $this->db->join('meals_log', 'meals.meal_date = meals_log.meal_date');
        $this->db->where('meals_log.meal_date', $meal_date);
        $query = $this->db->get();
        return $query->first_row();
    }

    /**
     * Update a log file of meal
     *
     * @param       int  $shift_id
     * @param       array  $tables
     * @param       date(Y-m-d)  $meal_date
     * @param       string  $note
     * @return      bool
     */
    function update_meal_log($shift, $tables, $meal_date, $note, $actual_meals)
    {
        $query = $this->db->get_where('meals_log', array('meal_date' => $meal_date));
        $have_meal_log = $query->num_rows();
        if ($have_meal_log > 0)
        {
            $tracking_log = array();
            $tracking_log = json_decode($query->first_row()->tracking_log);
            if ($tracking_log != NULL)
            {
                foreach ($tracking_log as $key => $log)
                {
                    if ($shift['id'] == $log->shift->id)
                    {
                        unset($tracking_log[$key]);
                        $tracking_log = array_values($tracking_log);
                    }
                }
            }
            $tracking_log[] = array('shift' => $shift, 'tables' => $tables);
            $data = array();
            $data['tracking_log'] = json_encode($tracking_log);
            $data['updated_at'] = date('Y-m-d H:i:s');
            if (!is_null($note)) $data['note'] = $query->first_row()->note."<br>".$note;
            if (!is_null($actual_meals)) $data['actual_meals'] = $actual_meals;
            $this->db->where('meal_date', $meal_date);
            return $this->db->update('meals_log', $data);
        }
        return FALSE;
    }

}
