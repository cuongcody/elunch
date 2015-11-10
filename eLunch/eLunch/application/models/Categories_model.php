<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_model extends CI_Model {

    /**
     * Get all categories
     *
     * @return      array
     */
    function get_all_categories()
    {
        $query = $this->db->get('categories');
        return (array)$query->result();
    }

    /**
     * Get number of categories
     *
     * @return      int
     */
    function get_num_of_categories()
    {
        $query = $this->db->get('categories');
        return $query->num_rows();
    }

    /**
     * Get category by id
     *
     * @param       int  $category_id
     * @return      object
     */
    function get_category_by_id($category_id)
    {
        $query = $this->db->get_where('categories', array('id' => $category_id));
        return $query->first_row();
    }

    /**
     * Inser new category
     *
     * @param       string  $name
     * @param       string  $decription
     * @return      bool
     */
    function insert_category($name, $decription)
    {
        $data = array(
            'name' => $name,
            'description' => $decription);
        return $this->db->insert('categories', $data);
    }

    /**
     * Update category
     *
     * @param       int  $category_id
     * @param       string  $name
     * @param       string  $decription
     * @return      bool
     */
    function update_category($category_id, $name, $description)
    {
        $data = array(
            'name' => $name,
            'description'=> $description,
            'updated_at' => date('Y-m-d H:i:s'));
        $this->db->where('id', $category_id);
        return $this->db->update('categories', $data);
    }

    /**
     * Delete category
     *
     * @param       int  $category_id
     * @return      bool
     */
    function delete_category($category_id)
    {
        $this->db->trans_begin();
        $data = array('id' => $category_id);
        $this->db->delete('categories', $data);
        $query = $this->db->get_where('dishes', array('category_id' => $category_id));
        $have_dish_belong_to_this_category = $query->num_rows();
        if ($have_dish_belong_to_this_category > 0)
        {
            $dishes_id_belong_to_category = array();
            // Get all dishes id belongs to category
            foreach ($query->result() as $dish)
            {
                $dishes_id_belong_to_category[] = $dish->id;
            }
            // Delete list of dishes belongs to category
            $this->load->model('dishes_model');
            if ($this->dishes_model->delete_dishes($dishes_id_belong_to_category))
            {
                $this->load->model('menus_model');
                // Delete list of dishes in menus have this category
                $this->menus_model->delete_dishes_in_menu_by_field('dish_id', $dishes_id_belong_to_category);
            }
        }

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
