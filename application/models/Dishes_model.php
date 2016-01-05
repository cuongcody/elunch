<?php

class Dishes_model extends CI_Model {

    private static $db;

    function __construct() {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    /**
     * Get all dishes
     *
     * @param       int  $perpage
     * @param       int  $offset
     * @return      array
     */
    static function get_all_dishes($perpage = NULL, $offset = NULL, $search = NULL, $category_id = NULL)
    {
        self::$db->select('dishes.id, dishes.name, dishes.description, categories.name AS category, pictures.image, pictures.image_file_name');
        self::$db->from('dishes');
        self::$db->join('categories', 'dishes.category_id = categories.id');
        self::$db->join('pictures', 'dishes.id = pictures.dish_id');
        if ($category_id != NULL && $category_id != 'all')
        {
            self::$db->where('categories.id', $category_id);
        }
        if (!is_null($perpage) && !is_null($offset))
        {
            self::$db->limit($perpage, $offset)->order_by('categories.name', 'ASC')->order_by('dishes.name', 'ASC');
        }
        self::$db->like('dishes.name', $search);
        $query = self::$db->get();
        return $query->result();
    }

    /**
     * Get dishes by category
     *
     * @param       int  $category
     * @return      object
     */
    static function get_dishes_by_category($category_id)
    {
        self::$db->cache_on();
        return self::$db->get_where('dishes', array('category_id' => $category_id))->result();
    }

    static function get_num_of_dishes_by_category($category_id, $dish_name = NULL)
    {
        $data = array();
        if ($category_id != 'all')
        {
            $data = array('category_id' => $category_id);
        }
        if ($dish_name == NULL) return self::$db->get_where('dishes', $data)->num_rows();
        else return self::$db->like('dishes.name', $dish_name)->get_where('dishes', $data)->num_rows();
    }

    /**
     * Get dishes by id
     *
     * @param       int  $dish_id
     * @return      object
     */
    static function get_dish_by_id($dish_id)
    {
        self::$db->select('dishes.id, dishes.name, dishes.description, categories.id AS category_id,
         categories.name AS category, pictures.image, pictures.image_file_name');
        self::$db->from('dishes');
        self::$db->join('categories', 'dishes.category_id = categories.id');
        self::$db->join('pictures', 'dishes.id = pictures.dish_id');
        self::$db->where('dishes.id', $dish_id);
        $query = self::$db->get();
        return $query->first_row();
    }

    /**
     * Get dishes from menu
     *
     * @param       int  $menu_id
     * @return      array
     */
    static function get_dishes_from_menu($menu_id)
    {
        self::$db->cache_on();
        self::$db->select('dishes.id, dishes.name, dishes.description, categories.id AS category_id,
         categories.name AS category, pictures.image, pictures.image_file_name');
        self::$db->from('dishes');
        self::$db->join('categories', 'dishes.category_id = categories.id');
        self::$db->join('pictures', 'dishes.id = pictures.dish_id', 'left');
        self::$db->join('dishes_menus', 'dishes.id = dishes_menus.dish_id');
        self::$db->where('dishes_menus.menu_id', $menu_id);
        $query = self::$db->get();
        return $query->result();
    }

    /**
     * Get dishes from menu
     *
     * @param       date(Y-m-d)  $date
     * @param       int  $number_of_days
     * @return      array
     */
    static function get_dishes_of_meals_from($date, $number_of_days)
    {
        $date_from = new DateTime($date);
        $date_to = new DateTime($date);
        $date_to->add(new DateInterval('P'.$number_of_days.'D'));
        self::$db->select('dishes.*, categories.order, pictures.image, pictures.dish_id, meals.meal_date, meals.for_vegans');
        self::$db->from('meals');
        self::$db->join('menus', 'meals.menu_id = menus.id');
        self::$db->join('dishes_menus', 'dishes_menus.menu_id = menus.id');
        self::$db->join('dishes', 'dishes_menus.dish_id = dishes.id');
        self::$db->join('pictures', 'dishes.id = pictures.dish_id');
        self::$db->join('categories', 'categories.id = dishes.category_id');
        self::$db->where('meal_date >=', $date_from->format('Y-m-d'));
        self::$db->where('meal_date <=', $date_to->format('Y-m-d'));
        self::$db->order_by('meal_date', 'asc');
        self::$db->order_by('menus.id', 'asc');
        self::$db->order_by('categories.order', 'asc');
        $dishes_grouped_by_date = array();
        $dishes = self::$db->get()->result();
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
    static function insert_dish($dish)
    {
        $data_dish = array(
            'name' => $dish['name'],
            'description' => $dish['description'],
            'category_id' => $dish['category']);
        if (self::$db->insert('dishes', $data_dish))
        {
            self::$db->cache_delete('admin', 'dishes');
            self::$db->cache_delete('admin', 'menus');
            $dish_id = self::$db->insert_id();
            $data_picture_of_dish = array(
                'dish_id' => $dish_id,
                'image'=> $dish['image'],
                'image_file_name' => $dish['image_file_name'],
                'description' => $dish['image_file_name']);
            return self::$db->insert('pictures', $data_picture_of_dish);
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
    static function update_dish($dish_id, $dish)
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
        self::$db->trans_begin();
        self::$db->where('id', $dish_id);
        self::$db->update('dishes', $data_dish);
        self::$db->where('dish_id', $dish_id);
        self::$db->update('pictures', $data_picture_of_dish);
        if (self::$db->trans_status() === FALSE)
        {
            self::$db->trans_rollback();
            return FALSE;
        }
        else
        {
            self::$db->cache_delete('admin', 'dishes');
            self::$db->cache_delete('admin', 'menus');
            self::$db->trans_commit();
            return TRUE;
        }
    }

    /**
     * Number of dishes
     *
     * @return      int
     */
    static function get_num_of_dishes($search = NULL)
    {
        return self::$db->like('dishes.name', $search)->get('dishes')->num_rows();
    }

    /**
     * Delete dish
     *
     * @param       array  $dishes_id
     * @return      bool
     */
    static function delete_dishes($dishes_id)
    {
        self::$db->trans_begin();
        self::$db->where_in('id', $dishes_id);
        self::$db->delete('dishes');
        self::$db->where_in('dish_id', $dishes_id);
        self::$db->delete('pictures');
        if (self::$db->trans_status() === FALSE)
        {
            self::$db->trans_rollback();
            return FALSE;
        }
        else
        {
            self::$db->cache_delete('admin', 'dishes');
            self::$db->cache_delete('admin', 'menus');
            self::$db->trans_commit();
            return TRUE;
        }
    }
}

