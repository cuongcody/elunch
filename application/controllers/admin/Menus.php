<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('common');
        $this->load->model('menus_model');

    }

    public function index()
    {
        $this->common->authenticate();
        $search = $this->common->delete_session_searchitem('name');
        $search = '';
        $this->load_menus_view($search);
    }

    public function search()
    {
        $this->common->authenticate();
        $search = $this->common->searchitem_handler('name', $this->input->post('search'));
        $this->load_menus_view($search);
    }

    public function add()
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->validation();
            if ($this->form_validation->run() == FALSE)
            {
                $this->load_new_menu_view();
            }
            else
            {
                if ($this->store_menu()) $this->common->return_notification('new_menu', 'add_success', 1);
                else $this->common->return_notification('new_menu', 'add_failure', 0);
                redirect('admin/menus','refresh');
            }
        }
        else
        {
            $this->load_new_menu_view();
        }
    }

    public function edit($menu_id)
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->validation();
            if ($this->form_validation->run() == FALSE)
            {
                $this->load_edit_menu_view($menu_id);
            }
            else
            {
                if ($this->edit_menu($menu_id)) $this->common->return_notification('edit_menu', 'edit_success', 1);
                else $this->common->return_notification('edit_menu', 'edit_failure', 0);
                redirect('admin/menus','refresh');
            }
        }
        else
        {
            $this->load_edit_menu_view($menu_id);
        }
    }

    public function delete($menu_id)
    {
        $this->common->authenticate();
        $message = $this->common->get_message('delete_menu', array('delete_success', 'delete_failure'));
        if ($this->menus_model->delete_menu($menu_id))
        {
            $data = array(
                'status' => 'success',
                'message' => $message['delete_success']);
        }
        else
        {
            $data = array(
                'status' => 'failure',
                'message' => $message['delete_failure']);
        }
        echo json_encode($data);
    }

    public function list_dishes_from_menu($menu_id = NULL)
    {
        $this->common->authenticate();
        $this->load->model('dishes_model');
        echo json_encode(Dishes_model::get_dishes_from_menu($menu_id));
    }

    public function load_new_menu_view()
    {
        $message = array('title', 'description', 'name', 'dishes', 'dishes_of_menu', 'filtered_by','save');
        $data = $this->common->set_language_and_data('new_menu', $message);
        $this->load->model('categories_model');
        $data['categories'] = Categories_model::get_all_categories();
        $this->common->load_view('admin/menus/new_menu', $data);
    }

    public function load_edit_menu_view($menu_id)
    {
        $message = array('title', 'description', 'name', 'manage_menus','dishes', 'dishes_of_menu', 'filtered_by','edit');
        $data = $this->common->set_language_and_data('edit_menu', $message);
        $menu = Menus_model::get_menu_by_id($menu_id);
        $data['menu'] = $menu;
        $this->load->model('categories_model');
        $data['categories'] = Categories_model::get_all_categories();
        $this->load->model('dishes_model');
        $data['dishes_of_menu'] = Dishes_model::get_dishes_from_menu($menu_id);
        $this->common->load_view('admin/menus/edit_menu', $data);
    }

    public function load_menus_view($search)
    {
        $message = array('title', 'search', 'search_name', 'menu', 'description', 'image', 'category', 'dishes_of_menu', 'name_dish', 'create_menu', 'edit', 'delete', 'search', 'are_you_sure', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('menus', $message);
        $this->load->library('pagination');
        $config['base_url'] = ($search == NULL) ? base_url().'/admin/menus' : base_url().'/admin/menus/search';
        $config['total_rows'] = Menus_model::get_num_of_menus($search);
        $config['per_page'] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = $config['uri_segment'] = ($search == NULL) ? 3 : 4;
        $config['num_links'] = 3;
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] ="</ul>";
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = ($search == NULL) ? (($this->uri->segment(3)) ? $this->uri->segment(3) : 0) : (($this->uri->segment(4)) ? $this->uri->segment(4) : 0);
        $menus = Menus_model::get_all_menus($config['per_page'],  ($data['page'] == 0 ? $data['page'] : ($data['page'] - 1)) * $config['per_page'], $search);
        $data['menus'] = $menus;
        $this->common->load_view('admin/menus/menus', $data);
    }

    public function validation()
    {
        $this->config->set_item('language', $this->session->userdata('site_lang'));
        $this->load->helper('security');
        $this->load->library('form_validation');
        // Validation rules
        $this->form_validation->set_rules('menu', 'lang:menu', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'lang:description', 'trim|required|xss_clean');
        $this->form_validation->set_rules('dishes_of_menu[]', 'lang:dishes_of_menu', 'trim|required|xss_clean');
    }

    public function store_menu()
    {
        $menu = array(
            'name' => $this->input->post('menu'),
            'description' => $this->input->post('description'));
        $dishes_of_menu = array();
        $dishes_of_menu = $this->input ->post('dishes_of_menu[]');
        return $this->menus_model->insert_menu($menu, $dishes_of_menu);
    }

    public function edit_menu($menu_id)
    {
        $menu = array(
            'name' => $this->input->post('menu'),
            'description' => $this->input->post('description'));
        $dishes_of_menu = array();
        $dishes_of_menu = $this->input->post('dishes_of_menu[]');
        return $this->menus_model->update_menu($menu_id, $menu, $dishes_of_menu);
    }

    public function dishes($category_id)
    {
        $this->common->authenticate();
        $this->load->model('dishes_model');
        echo json_encode(Dishes_model::get_dishes_by_category($category_id));
    }

}