<?php

class Dishes_model extends CI_Model {

    function get_all_dishes()
    {
        $this->db->select('dishes.id, dishes.name, dishes.description, categories.name AS category, pictures.image');
        $this->db->from('dishes');
        $this->db->join('categories', 'dishes.category_id = categories.id');
        $this->db->join('pictures', 'dishes.id = pictures.dish_id');
        $query = $this->db->get();
        return $query->result();
    }

    function get_dishes_by_category($category_id)
    {
        return $this->db->get_where('dishes', array('category_id' => $category_id))->result();
    }


    function get_dishes($perpage, $offset)
    {
        $this->db->select('dishes.id, dishes.name, dishes.description, categories.name AS category, pictures.image, pictures.image_file_name');
        $this->db->from('dishes');
        $this->db->join('categories', 'dishes.category_id = categories.id');
        $this->db->join('pictures', 'dishes.id = pictures.dish_id');
        $this->db->limit($perpage, $offset)->order_by('categories.name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

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

    function get_dishes_of_meals_from($date, $number_of_days)
    {
        $meals_grouped_by_date = array();
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
        $dishes = $this->db->get()->result();
        foreach ($dishes as $key1 => $dish1)
        {
            $date = $dish1->meal_date;
            $meals_grouped_by_date[$date] = array();
            foreach ($dishes as $key2 => $dish2)
            {
                if ($dish2->meal_date == $date)
                {
                    array_push($meals_grouped_by_date[$date], $dish2);
                }
            }
        }
        return $meals_grouped_by_date;
    }

    function get_all_dishes_in_week($first_day_of_week, $last_date_of_week)
    {
        $this->db->distinct();
        $this->db->select('dishes.*, pictures.image, pictures.dish_id, meals.meal_date');
        $this->db->from('meals');
        $this->db->join('menus', 'meals.menu_id = menus.id');
        $this->db->join('dishes_menus', 'dishes_menus.menu_id = menus.id');
        $this->db->join('dishes', 'dishes_menus.dish_id = dishes.id');
        $this->db->join('pictures', 'dishes.id = pictures.dish_id');
        $this->db->where('meal_date >=', $first_day_of_week);
        $this->db->where('meal_date <=', $last_date_of_week);
        $this->db->group_by('dishes.id');
        $dishes = $this->db->get()->result();
        return $dishes;
    }

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
            $this->db->where('id', $dish_id);
            if ($this->db->update('dishes', $data_dish))
                {
                    $this->db->where('dish_id', $dish_id);
                    return $this->db->update('pictures', $data_picture_of_dish);
                }
    }

    function get_num_of_dishes()
    {
        return $this->db->get('dishes')->num_rows();
    }

    function delete_dish($dish_id)
    {
        if ($this->db->delete('dishes', array('id' => $dish_id))) return $this->db->delete('pictures', array('dish_id' => $dish_id));
    }

    function delete_dishes($dishes_id)
    {
        $this->db->where_in('id', $dishes_id);
        if ($this->db->delete('dishes'))
        {
            $this->db->where_in('dish_id', $dishes_id);
            return $this->db->delete('pictures');
        }
        return FALSE;
    }
}
?>
