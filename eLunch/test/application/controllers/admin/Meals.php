<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meals extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('common');
        $this->load->model('meals_model');

    }

    public function index()
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            if (isset($_POST['submit']))
            {
                $this->validation('index');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->load_meals_view();
                }
                else $this->load_meals_view($this->input->post('from'), $this->input->post('to'));
            }
            $this->load_meals_view();
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
                $this->validation('add');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->load_new_meal_view();
                }
                else
                {
                    if ($this->store_meal())
                    {
                        $message = $this->common->get_message('new_meal', array('add_success'));
                        $this->session->set_flashdata('message', $message['add_success']);
                    }
                    else
                    {
                        $message = $this->common->get_message('new_meal', array('add_failure'));
                        $this->session->set_flashdata('message', $message['add_failure']);
                    }
                    redirect('admin/meals','refresh');
                }
            }
            else
            {
                $this->load_new_meal_view();
            }
        }
       else redirect('admin/login', 'refresh');
    }

    public function edit($meal_id)
    {
        if ( $this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            if (isset($_POST['submit']))
            {
                $this->validation('edit');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->load_edit_meal_view($meal_id);
                }
                else
                {
                    if ($this->edit_meal($meal_id))
                    {
                        $message = $this->common->get_message('edit_meal', array('edit_success'));
                        $this->session->set_flashdata('message', $message['edit_success']);
                    }
                    else
                    {
                        $message = $this->common->get_message('edit_meal', array('edit_failure'));
                        $this->session->set_flashdata('message', $message['edit_failure']);
                    }
                    redirect('admin/meals','refresh');
                }
            }
            else
            {
                $this->load_edit_meal_view($meal_id);
            }
        }
       else redirect('admin/login', 'refresh');
    }

    public function load_new_meal_view()
    {
        $message = array('title', 'name_dish', 'category',
            'lunch_date', 'dishes_of_menu', 'preordered_meal', 'menu', 'image', 'lunch_date', 'save');
        $data = $this->common->set_language_and_data('new_meal', $message);
        $this->load->model('menus_model');
        $menus = $this->menus_model->get_all_menus();
        $data['menus'] = $menus;
        $this->common->load_view('admin/meals/new_meal', $data);
    }

    public function load_edit_meal_view($meal_id)
    {
        $message = array('title', 'name_dish', 'category',
            'lunch_date', 'dishes_of_menu', 'preordered_meal', 'menu', 'image', 'lunch_date', 'edit');
        $data = $this->common->set_language_and_data('edit_meal', $message);
        $this->load->model('menus_model');
        $menus = $this->menus_model->get_all_menus();
        $data['menus'] = $menus;
        $data['meal'] = $this->meals_model->get_meal_by_id($meal_id);
        $this->common->load_view('admin/meals/edit_meal', $data);
    }

    public function load_meals_view($from = NULL, $to = NULL)
    {
        $message = array('title', 'create_meal', 'meals', 'name_dish', 'category',
         'lunch_date', 'dishes_of_menu', 'preordered_meal', 'menu', 'image', 'lunch_date', 'search',
          'from', 'to', 'edit', 'delete', 'are_you_sure', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('meals', $message);
        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/meals');
        $config['total_rows'] = $this->meals_model->get_num_of_meals($from, $to);
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
        $meals = $this->meals_model->get_meals($config['per_page'], $data['page'], $from, $to);
        $data['meals'] = $meals;
        $this->common->load_view('admin/meals/meals', $data);
    }

    public function dishes($menu_id)
    {
        $this->load->model('menus_model');
        echo json_encode($this->menus_model->get_dishes_by_menu($menu_id));
    }

    public function validation($view)
    {
        $this->load->helper('security');
        $this->load->library('form_validation');
        // Validation rules
        if ($view == 'index')
        {
            $this->form_validation->set_rules('from', 'lang:from', 'trim|required|callback_check_date_format|xss_clean');
            $this->form_validation->set_rules('to', 'lang:to', 'trim|required|callback_check_date_format|xss_clean');
        }
        else
        {
            $this->form_validation->set_rules('lunch_date', 'lang:lunch_date', 'trim|required|callback_check_date_format|xss_clean');
            $this->form_validation->set_rules('preordered_meal', 'lang:preordered_meal', 'trim|required|numeric|greater_than[1]|xss_clean');
            $this->form_validation->set_rules('menu', 'lang:menu', 'trim|required|numeric|xss_clean');
        }
    }

    public function store_meal()
    {
        $lunch_date = $this->input->post('lunch_date');
        $menu_id = $this->input->post('menu');
        $preordered_meal = $this->input->post('preordered_meal');
        return $this->meals_model->insert_meal($lunch_date, $menu_id, $preordered_meal);
    }

    public function edit_meal($meal_id)
    {
        $lunch_date = $this->input->post('lunch_date');
        $menu_id = $this->input->post('menu');
        $preordered_meal = $this->input->post('preordered_meal');
        return $this->meals_model->update_meal($meal_id, $lunch_date, $menu_id, $preordered_meal);
    }

    public function check_date_format($date) {
        if (!$this->common->date_format($date))
        {
            $this->lang->load('validation', $this->session->userdata('site_lang'));
            $this->form_validation->set_message('check_date_format', $this->lang->line('date_format'));
            return FALSE;
        }
        return TRUE;
    }

    public function delete($meal_id)
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            $message = $this->common->get_message('delete_menu', array('delete_success', 'delete_failure'));
            if ($this->meals_model->delete_meal($meal_id))
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
}