<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_model extends CI_Model {

    function get_all_categories()
    {
        $query = $this->db->get('categories');
        return (array)$query->result();
    }

    function get_category_by_id($category_id)
    {
        $query = $this->db->get_where('categories', array('id' => $category_id));
        return (array)$query->first_row();
    }

    function insert_category($name, $decription)
    {
        $data = array(
            'name' => $name,
            'description' => $decription);
        return $this->db->insert('categories', $data);
    }

    function update_category($category_id, $name, $description)
    {
        $data = array(
            'name' => $name,
            'description'=> $description,
            'updated_at' => date('Y-m-d H:i:s'));
        $this->db->where('id', $category_id);
        return $this->db->update('categories', $data);
    }

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
