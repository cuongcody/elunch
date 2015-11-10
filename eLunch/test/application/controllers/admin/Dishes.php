<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dishes extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('common');
        $this->load->model('dishes_model');
    }

    public function index()
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            $this->load_dishes_view();
        }
        else
        {
            redirect('admin/login', 'refresh');
        }
    }

    public function favourite_dishes()
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            $this->load_favourite_dishes_view();
        }
        else
        {
            redirect('admin/login', 'refresh');
        }
    }

    public function add()
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            if (isset($_POST['submit']))
            {
                $this->validation('add');
                if($this->form_validation->run() == FALSE)
                {
                   $this->load_new_dish_view();
                }
                else
                {
                    if ($this->store_dish())
                    {
                        $this->session->unset_userdata('upload');
                        $message = $this->common->get_message('new_dish', array('add_success'));
                        $this->session->set_flashdata('message', $message['add_success']);
                    }
                    else
                    {
                        $message = $this->common->get_message('new_dish', array('add_failure'));
                        $this->session->set_flashdata('message', $message['add_failure']);
                    }
                    redirect('admin/dishes','refresh');
                }
            }
            else
            {
                $this->session->unset_userdata('upload');
                $this->load_new_dish_view();
            }
        }
        else redirect('admin/login', 'refresh');
    }

    public function edit($dish_id)
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            if (isset($_POST['submit']))
            {
                $this->validation('edit');
                if($this->form_validation->run() == FALSE)
                {
                   $this->load_edit_dish_view($dish_id);
                }
                else
                {
                    if ($this->edit_dish($dish_id))
                    {
                        $this->session->unset_userdata('upload');
                        $message = $this->common->get_message('edit_dish', array('edit_success'));
                        $this->session->set_flashdata('message', $message['edit_success']);
                    }
                    else
                    {
                        $message = $this->common->get_message('edit_dish', array('edit_failure'));
                        $this->session->set_flashdata('message', $message['edit_failure']);
                    }
                    redirect('admin/dishes','refresh');
                }
            }
            else
            {
                $this->session->unset_userdata('upload');
                $this->load_edit_dish_view($dish_id);
            }
        }
        else redirect('admin/login', 'refresh');
    }

    public function load_new_dish_view()
    {
        $message = array('title', 'description', 'name', 'category', 'image', 'save', 'image_upload');
        $data = $this->common->set_language_and_data('new_dish', $message);
        $this->load->model('categories_model');
        $categories = $this->categories_model->get_all_categories();
        $data['categories'] = $categories;
        $this->common->load_view('admin/dishes/new_dish', $data);
    }

    public function load_favourite_dishes_view()
    {
        $message = array('title', 'description', 'name', 'lunch_date', 'image', 'votes');
        $data = $this->common->set_language_and_data('favourite_dishes', $message);
        $this->load->model('votes_model');
        $data['dishes'] = $this->votes_model->get_all_dishes_with_votes_number_in_a_week();
        // Delete dish have no vote
        $data['dishes'] = $this->get_list_dishes_have_votes($data['dishes']);
        $this->common->load_view('admin/dishes/favourite_dishes', $data);
    }

    public function get_list_dishes_have_votes($dishes)
    {
        foreach ($dishes as $key => $dish)
        {
            if ($dish->num_votes == 0) {
                unset($dishes[$key]);
            }
        }
        return array_values($dishes);
    }

    public function load_edit_dish_view($dish_id)
    {
        $dish = $this->dishes_model->get_dish_by_id($dish_id);
        $image_data['file_name'] =$dish->image_file_name;
        $this->session->set_userdata('upload', $image_data);
        $message = array('title', 'description', 'name', 'category', 'image', 'edit', 'image_upload');
        $data = $this->common->set_language_and_data('edit_dish', $message);
        $this->load->model('categories_model');
        $categories = $this->categories_model->get_all_categories();
        $data['categories'] = $categories;
        $data['dish'] = (array)$dish;
        $this->common->load_view('admin/dishes/edit_dish', $data);
    }

    public function load_dishes_view()
    {
        $message = array('title', 'description', 'name', 'category', 'image', 'create_dish', 'edit', 'delete', 'are_you_sure', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('dishes', $message);
        $this->load->library('pagination');
        $config['base_url'] = base_url().'/admin/dishes';
        $config['total_rows'] = $this->dishes_model->get_num_of_dishes();
        $config['per_page'] = 3;
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
        $dishes = $this->dishes_model->get_dishes($config['per_page'], $data['page']);
        $data['dishes'] = $dishes;
        $this->common->load_view('admin/dishes/dishes', $data);
    }

    public function delete($dish_id)
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            $message = $this->common->get_message('delete_dish', array('delete_success', 'delete_failure'));
             if ($this->dishes_model->delete_dish($dish_id))
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

    public function validation($view)
    {
        $this->load->helper('security');
        $this->load->library('form_validation');
        //validation rules
        $this->form_validation->set_rules('name', 'lang:name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'lang:description', 'trim|required|xss_clean');
        $this->form_validation->set_rules('category', 'lang:category', 'trim|required|xss_clean');
        if ($view == 'add') $this->form_validation->set_rules('image', 'lang:image', 'callback_check_image_upload');
        else $this->form_validation->set_rules('image', 'lang:image', 'callback_edit_image_upload');
    }

    public function store_dish()
    {
        $image_data = $this->session->userdata('upload');
        $name = $this->input->post('name');
        $description = $this->input->post('description');
        $category = $this->input->post('category');
        $image = base_url('assets/images/dishes/'.$image_data['file_name']);
        $dish = array(
            'name' => $name,
            'description' => $description,
            'category' => $category,
            'image' => $image,
            'image_file_name' => $image_data['file_name']);
        $result = $this->dishes_model->insert_dish($dish);
        return $result;
    }

    public function edit_dish($dish_id)
    {
        $image_data= $this->session->userdata('upload');
        $name = $this->input->post('name');
        $description = $this->input->post('description');
        $category = $this->input->post('category');
        $dish = array(
            'name' => $name,
            'description' => $description,
            'category' => $category,
            'image' => base_url('assets/images/dishes/'.$image_data['file_name']),
            'image_file_name' => $image_data['file_name']);
        $result = $this->dishes_model->update_dish($dish_id, $dish);
        return $result;
    }

    public function check_image_upload()
    {
        if (empty($this->session->userdata('upload')))
        {
            if ($_FILES['img']['size'] != 0)
            {
                $this->common->image_upload('../assets/images/dishes');
            }
            else
            {
                $this->lang->load('validation', $this->session->userdata('site_lang'));
                $this->form_validation->set_message('check_image_upload', $this->lang->line('image_upload'));
                return FALSE;
            }
        }
        return TRUE;
    }

    public function edit_image_upload()
    {
        if ($_FILES['img']['size'] != 0)
        {
            $this->common->image_upload('../assets/images/dishes');
        }
        else return TRUE;
    }

}