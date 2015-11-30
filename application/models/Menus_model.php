<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus_model extends CI_Model {

    /**
     * Get menus based on pagination
     *
     * @param       int  $perpage
     * @param       int  $offset
     * @return      object
     */
    function get_all_menus($perpage = NULL, $offset = NULL, $search = NULL)
    {
        $this->db->select('menus.id, menus.name, menus.description');
        $this->db->from('menus');
        $this->db->join('dishes_menus','menus.id = dishes_menus.menu_id');
        if (!is_null($perpage) && !is_null($offset))
        {
            $this->db->limit($perpage, $offset)->group_by('menus.id');
        }
        $this->db->like('menus.name', $search);
        $query = $this->db->order_by('menus.name', 'ASC');
        return (array)$query->get()->result();
    }

    /**
     * Get dishes by menus
     *
     * @param       int  $menu_id
     * @return      array
     */
    function get_dishes_by_menu($menu_id)
    {
        $this->db->select('pictures.image, $dishes.name, categories.name AS category_name');
        $this->db->from('dishes');
        $this->db->join('pictures', 'pictures.dish_id = dishes.id');
        $this->db->join('dishes_menus', 'dishes_menus.dish_id = dishes.id');
        $this->db->join('categories', 'dishes.category_id = categories.id');
        $this->db->where('menus.id', $menu_id);
        return $this->db->get()->result();
    }

    /**
     * Get menu by id
     *
     * @param       int  $menu_id
     * @return      object
     */
    public function get_menu_by_id($menu_id)
    {
        $query = $this->db->get_where('menus', array('id' => $menu_id));
        return $query->first_row();
    }

    /**
     * Get number of menus
     *
     * @return      int
     */
    function get_num_of_menus($search = NULL)
    {
        $this->db->select('menus.id, menus.name, menus.description');
        $this->db->from('menus');
        $this->db->join('dishes_menus','menus.id = dishes_menus.menu_id')->group_by('menus.id')->order_by('menus.id', 'DESC');
        $this->db->like('menus.name', $search);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Insert new menu
     *
     * @param       array  $menu
     * @param       array  $dishes_of_menu
     * @return      bool
     */
    function insert_menu($menu, $dishes_of_menu)
    {
        $this->db->trans_begin();
        $this->db->insert('menus', $menu);
        $menu_id = $this->db->insert_id();
        $this->insert_dishes_in_menu($menu_id, $dishes_of_menu);
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
     * Insert dishes in menu
     *
     * @param       int  $menu_id
     * @param       array  $dishes_of_menu
     * @return      bool
     */
    function insert_dishes_in_menu($menu_id, $dishes_of_menu)
    {
        $datas = array();
        foreach ($dishes_of_menu as $dish) {
            $data = array(
                'menu_id' => $menu_id,
                'dish_id' => $dish);
            array_push($datas, $data);
        }
        return $this->db->insert_batch('dishes_menus', $datas);
    }

    /**
     * Update menu
     *
     * @param       int  $menu_id
     * @param       array  $menu
     * @param       array  $dishes_of_menu
     * @return      bool
     */
    function update_menu($menu_id, $menu, $dishes_of_menu)
    {
        $this->db->trans_begin();
        $this->db->where('id', $menu_id);
        $this->db->update('menus', $menu);
        $this->delete_dishes_in_menu_by_field('menu_id', $menu_id);
        $this->insert_dishes_in_menu($menu_id, $dishes_of_menu);

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
     * Delete menu
     *
     * @param       int  $menu_id
     * @return      bool
     */
    function delete_menu($menu_id)
    {
        return $this->db->query('DELETE menus, dishes_menus FROM menus
            INNER JOIN dishes_menus ON dishes_menus.menu_id = menus.id
            WHERE dishes_menus.menu_id = ? AND menus.id = ?', array($menu_id, $menu_id));
    }

    /**
     * Delete dishes in menu by field
     *
     * @param       string  $field
     * @param       string  $field_value
     * @return      bool
     */
    function delete_dishes_in_menu_by_field($field, $field_value)
    {
        $this->db->where_in($field, $field_value);
        return $this->db->delete('dishes_menus');
    }
}
