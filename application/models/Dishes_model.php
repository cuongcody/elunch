<?php

class Dishes_model extends CI_Model {

    /**
     * Get all dishes
     *
     * @param       int  $perpage
     * @param       int  $offset
     * @return      array
     */
    function get_all_dishes($perpage = NULL, $offset = NULL, $search = NULL)
    {
        $this->db->select('dishes.id, dishes.name, dishes.description, categories.name AS category, pictures.image, pictures.image_file_name');
        $this->db->from('dishes');
        $this->db->join('categories', 'dishes.category_id = categories.id');
        $this->db->join('pictures', 'dishes.id = pictures.dish_id');
        if (!is_null($perpage) && !is_null($offset))
        {
            $this->db->limit($perpage, $offset)->order_by('categories.name', 'ASC')->order_by('dishes.name', 'ASC');
        }
        $this->db->like('dishes.name', $search);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get dishes by category
     *
     * @param       int  $category
     * @return      object
     */
    function get_dishes_by_category($category_id)
    {
        return $this->db->get_where('dishes', array('category_id' => $category_id))->result();
    }

    /**
     * Get dishes by id
     *
     * @param       int  $dish_id
     * @return      object
     */
    function get_dish_by_id($dish_id)
    {
        $this->db->select('dishes.id, dishes.name, dishes.description, categories.id AS category_id,
         categories.name AS category, pictures.image, pictures.image_file_name');
        $this->db->from('dishes');
        $this->db->join('categories', 'dishes.category_id = categories.id');
        $this->db->join('pictures', 'dishes.id = pictures.dish_id');
        $this->db->where('dishes.id', $dish_id);
        $query = $this->db->get();
        return $query->first_row();
    }

    /**
     * Get dishes from menu
     *
     * @param       int  $menu_id
     * @return      array
     */
    function get_dishes_from_menu($menu_id)
    {
        $this->db->select('dishes.id, dishes.name, dishes.description, categories.id AS category_id,
         categories.name AS category, pictures.image, pictures.image_file_name');
        $this->db->from('dishes');
        $this->db->join('categories', 'dishes.category_id = categories.id');
        $this->db->join('pictures', 'dishes.id = pictures.dish_id', 'left');
        $this->db->join('dishes_menus', 'dishes.id = dishes_menus.dish_id');
        $this->db->where('dishes_menus.menu_id', $menu_id);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get dishes from menu
     *
     * @param       date(Y-m-d)  $date
     * @param       int  $number_of_days
     * @return      array
     */
    function get_dishes_of_meals_from($date, $number_of_days)
    {
        $date_from = new DateTime($date);
        $date_to = new DateTime($date);
        $date_to->add(new DateInterval('P'.$number_of_days.'D'));
        $this->db->select('dishes.*, pictures.image, pictures.dish_id, meals.meal_date');
        $this->db->from('meals');
        $this->db->join('menus', 'meals.menu_id = menus.id');
        $this->db->join('dishes_menus', 'dishes_menus.menu_id = menus.id');
        $this->db->join('dishes', 'dishes_menus.dish_id = dishes.id');
        $this->db->join('pictures', 'dishes.id = pictures.dish_id');
        $this->db->where('meal_date >=', $date_from->format('Y-m-d'));
        $this->db->where('meal_date <=', $date_to->format('Y-m-d'));
        $this->db->order_by('meal_date', 'asc');
        $dishes_grouped_by_date = array();
        $dishes = $this->db->get()->result();
        if ($dishes != NULL)
        {
            foreach ($dishes as $key1 => $dish1)
            {
                $date = $dish1->meal_date;
                $dishes_grouped_by_date[$date] = array();
                foreach ($dishes as $key2 => $dish2)
                {
                    if ($dish2->meal_date == $date)
                    {
                        array_push($dishes_grouped_by_date[$date], $dish2);
                    }
                }
            }
        }
        return $dishes_grouped_by_date;
    }

    /**
     * Insert new dish
     *
     * @param       array  $dish
     * @return      bool
     */
    function insert_dish($dish)
    {
        $data_dish = array(
            'name' => $dish['name'],
            'description' => $dish['description'],
            'category_id' => $dish['category']);
        if ($this->db->insert('dishes', $data_dish))
        {
            $dish_id = $this->db->insert_id();
            $data_picture_of_dish = array(
                'dish_id' => $dish_id,
                'image'=> $dish['image'],
                'image_file_name' => $dish['image_file_name'],
                'description' => $dish['image_file_name']);
            return $this->db->insert('pictures', $data_picture_of_dish);
        }
        else return FALSE;
    }

    /**
     * Update dish
     *
     * @param       int  $dish_id
     * @param       array  $dish
     * @return      bool
     */
    function update_dish($dish_id, $dish)
    {
        $data_dish = array(
            'name' => $dish['name'],
            'description' => $dish['description'],
            'category_id' => $dish['category']);
        $data_picture_of_dish = array(
                'dish_id' => $dish_id,
                'image'=> $dish['image'],
                'image_file_name' => $dish['image_file_name'],
                'description' => $dish['image_file_name']);
        $this->db->trans_begin();
        $this->db->where('id', $dish_id);
        $this->db->update('dishes', $data_dish);
        $this->db->where('dish_id', $dish_id);
        $this->db->update('pictures', $data_picture_of_dish);
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

    /**
     * Number of dishes
     *
     * @return      int
     */
    function get_num_of_dishes($search = NULL)
    {
        return $this->db->like('dishes.name', $search)->get('dishes')->num_rows();
    }

    /**
     * Delete dish
     *
     * @param       int  $dish_id
     * @return      bool
     */
    function delete_dish($dish_id)
    {
        $this->db->trans_begin();
        $this->db->delete('dishes', array('id' => $dish_id));
        $this->db->delete('pictures', array('dish_id' => $dish_id));
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
}

