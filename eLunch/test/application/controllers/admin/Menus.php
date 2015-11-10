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
        if ($this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            $this->load_menus_view();
        }
        else
        {
            redirect('admin/login', 'refresh');
        }
    }

    public function add()
    {
        if ( $this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            if (isset($_POST['submit']))
            {
                $this->validation();
                if ($this->form_validation->run() == FALSE)
                {
                    $this->load_new_menu_view();
                }
                else
                {
                    if ($this->store_menu())
                    {
                        $message = $this->common->get_message('new_menu', array('add_success'));
                        $this->session->set_flashdata('message', $message['add_success']);
                    }
                    else
                    {
                        $message = $this->common->get_message('new_menu', array('add_failure'));
                        $this->session->set_flashdata('message', $message['add_failure']);
                    }
                    redirect('admin/menus','refresh');
                }
            }
            else
            {
                $this->load_new_menu_view();
            }
        }
       else redirect('admin/login', 'refresh');
    }

    public function edit($menu_id)
    {
        if ( $this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            if (isset($_POST['submit']))
            {
                $this->validation();
                if ($this->form_validation->run() == FALSE)
                {
                    $this->load_edit_menu_view($menu_id);
                }
                else
                {
                    if ($this->edit_menu($menu_id))
                    {
                        $message = $this->common->get_message('edit_menu', array('edit_success'));
                        $this->session->set_flashdata('message', $message['edit_success']);
                    }
                    else
                    {
                        $message = $this->common->get_message('edit_menu', array('edit_failure'));
                        $this->session->set_flashdata('message', $message['edit_failure']);
                    }
                    redirect('admin/menus','refresh');
                }
            }
            else
            {
                $this->load_edit_menu_view($menu_id);
            }
        }
       else redirect('admin/login', 'refresh');
    }

    public function delete($menu_id)
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
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
        else redirect('admin/login', 'refresh');
    }

    public function list_dishes_from_menu($menu_id)
    {
        $this->load->model('dishes_model');
        echo json_encode($this->dishes_model->get_dishes_from_menu($menu_id));
    }

    public function load_new_menu_view()
    {
        $message = array('title', 'description', 'name', 'dishes', 'dishes_of_menu', 'filtered_by','save');
        $data = $this->common->set_language_and_data('new_menu', $message);
        $this->load->model('categories_model');
        $categories = $this->categories_model->get_all_categories();
        $data['categories'] = $categories;
        $this->common->load_view('admin/menus/new_menu', $data);
    }

    public function load_edit_menu_view($menu_id)
    {
        $message = array('title', 'description', 'name', 'dishes', 'dishes_of_menu', 'filtered_by','edit');
        $data = $this->common->set_language_and_data('edit_menu', $message);
        $this->load->model('categories_model');
        $menu = $this->menus_model->get_menu_by_id($menu_id);
        $data['menu'] = $menu;
        $categories = $this->categories_model->get_all_categories();
        $data['categories'] = $categories;
        $this->load->model('dishes_model');
        $dishes_of_menu = $this->dishes_model->get_dishes_from_menu($menu_id);
        $data['dishes_of_menu'] = $dishes_of_menu;
        $this->common->load_view('admin/menus/edit_menu', $data);
    }

    public function load_menus_view()
    {
        $message = array('title', 'menu', 'description', 'image', 'category', 'dishes_of_menu', 'name_dish', 'create_menu', 'edit', 'delete', 'search', 'are_you_sure', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('menus', $message);
        $this->load->library('pagination');
        $config['base_url'] = base_url().'/admin/menus';
        $config['total_rows'] = $this->menus_model->get_num_of_menus();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['num_links'] = 3;
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] ="</ul>";
        $config['first_link'] = false;
        $config['last_link'] = false;
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
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $menus = $this->menus_model->get_menus($config['per_page'], $data['page']);
        $data['menus'] = $menus;
        // var_dump($menus); exit();
        $this->common->load_view('admin/menus/menus', $data);
    }

    public function validation()
    {
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
        $dishes_of_menu = $this->input ->post('dishes_of_menu[]');
        return $this->menus_model->update_menu($menu_id, $menu, $dishes_of_menu);
    }

    public function dishes($category_id)
    {
        $this->load->model('dishes_model');
         echo json_encode($this->dishes_model->get_dishes_by_category($category_id));
    }

}