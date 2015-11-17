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
        $this->common->authenticate();
        $search = $this->input->post('search');
        $this->load_dishes_view($search);
    }

    public function favourite_dishes()
    {
        $this->common->authenticate();
        $this->load_favourite_dishes_view();
    }

    public function add()
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->validation('add');
            if($this->form_validation->run() == FALSE)
            {
               $this->load_new_dish_view();
            }
            else
            {
                if ($this->store_dish()) $this->common->return_notification('new_dish', 'add_success', 1);
                else $this->common->return_notification('new_dish', 'add_failure', 0);
                redirect('admin/dishes','refresh');
            }
        }
        else
        {
            $this->session->unset_userdata('upload');
            $this->load_new_dish_view();
        }
    }

    public function edit($dish_id)
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->validation('edit');
            if($this->form_validation->run() == FALSE)
            {
               $this->load_edit_dish_view($dish_id);
            }
            else
            {
                if ($this->edit_dish($dish_id)) $this->common->return_notification('edit_dish', 'edit_success', 1);
                else $this->common->return_notification('edit_dish', 'edit_failure', 0);
                redirect('admin/dishes','refresh');
            }
        }
        else
        {
            $this->session->unset_userdata('upload');
            $this->load_edit_dish_view($dish_id);
        }
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
        $message = array('title', 'description', 'name', 'manage_dishes','category', 'image', 'edit', 'image_upload');
        $data = $this->common->set_language_and_data('edit_dish', $message);
        $this->load->model('categories_model');
        $categories = $this->categories_model->get_all_categories();
        $data['categories'] = $categories;
        $data['dish'] = (array)$dish;
        $this->common->load_view('admin/dishes/edit_dish', $data);
    }

    public function load_dishes_view($search)
    {
        $message = array('title', 'search_name', 'search', 'description', 'name', 'category', 'image', 'create_dish', 'edit', 'delete', 'are_you_sure', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('dishes', $message);
        $this->load->library('pagination');
        $config['base_url'] = base_url().'/admin/dishes';
        $config['total_rows'] = $this->dishes_model->get_num_of_dishes($search);
        $config['per_page'] = (($search != '') ? $config['total_rows'] : 10);
        $config['use_page_numbers'] = TRUE;
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
        $dishes = $this->dishes_model->get_all_dishes($config['per_page'], ($data['page'] == 0 ? $data['page'] : ($data['page'] - 1)) * $config['per_page'], $search);
        $data['dishes'] = $dishes;
        $this->common->load_view('admin/dishes/dishes', $data);
    }

    public function delete($dish_id)
    {
        $this->common->authenticate();
        $message = $this->common->get_message('delete_dish', array('delete_success', 'delete_failure'));
        if ($this->dishes_model->delete_dish($dish_id))
        {
        $image_file_name = $this->input->post('image_file_name');
        $this->common->image_delete(SAVE_IMAGE_OF_DISHES.'/'.$image_file_name);
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

    public function validation($view)
    {
        $this->config->set_item('language', $this->session->userdata('site_lang'));
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
        $image = base_url(LINK_TO_IMAGE_OF_DISHES.$image_data['file_name']);
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
        $image_data = $this->session->userdata('upload');
        $name = $this->input->post('name');
        $description = $this->input->post('description');
        $category = $this->input->post('category');
        $dish = array(
            'name' => $name,
            'description' => $description,
            'category' => $category,
            'image' => base_url(LINK_TO_IMAGE_OF_DISHES.$image_data['file_name']),
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
                if (!$this->common->image_upload(SAVE_IMAGE_OF_DISHES))
                {
                    $this->lang->load('web_portal/validation', $this->session->userdata('site_lang'));
                    $this->form_validation->set_message('check_image_upload', $this->lang->line('error_upload'));
                    return FALSE;
                }
                else return TRUE;
            }
            else
            {
                $this->lang->load('web_portal/validation', $this->session->userdata('site_lang'));
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
            $old_image = $this->session->userdata('upload')['file_name'];
            if (!$this->common->image_upload(SAVE_IMAGE_OF_DISHES))
            {
                $this->lang->load('web_portal/validation', $this->session->userdata('site_lang'));
                $this->form_validation->set_message('check_image_upload', $this->lang->line('error_upload'));
                return FALSE;
            }
            else
            {
                $this->common->image_delete(SAVE_IMAGE_OF_DISHES.'/'.$old_image);
                return TRUE;
            }
        }
        else return TRUE;
    }

}