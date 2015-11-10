<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('common');
        $this->load->model('categories_model');
    }
    public function index()
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            $this->load_categories_view();
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
                   $this->load_new_category_view();
                }
                else
                {
                    if ($this->store_category())
                    {
                        $message = $this->common->get_message('new_category', array('add_success'));
                        $this->session->set_flashdata('message', $message['add_success']);
                    }
                    else
                    {
                        $message = $this->common->get_message('new_category', array('add_failure'));
                        $this->session->set_flashdata('message', $message['add_failure']);
                    }
                    redirect('admin/categories','refresh');
                }
            }
            else
            {
                $this->load_new_category_view();
            }
        }
       else redirect('admin/login', 'refresh');
    }

    public function edit($category_id)
    {
        if ( $this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            if (isset($_POST['submit']))
            {
                $this->validation();
                if ($this->form_validation->run() == FALSE)
                {
                   $this->load_edit_category_view($category_id);
                }
                else
                {
                    if ($this->edit_category($category_id))
                    {
                        $message = $this->common->get_message('edit_category', array('edit_success'));
                        $this->session->set_flashdata('message', $message['edit_success']);
                    }
                    else
                    {
                        $message = $this->common->get_message('edit_category', array('edit_failure'));
                        $this->session->set_flashdata('message', $message['edit_success']);
                    }
                    redirect('admin/categories','refresh');
                }
            }
            else
            {
                $this->load_edit_category_view($category_id);
            }
        }
       else redirect('admin/login', 'refresh');
    }

    public function delete($category_id)
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            $message = $this->common->get_message('delete_category', array('delete_success', 'delete_failure'));
             if ($this->categories_model->delete_category($category_id))
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

    public function load_categories_view()
    {
        $message = array('title', 'description', 'category', 'create_category', 'edit', 'delete', 'are_you_sure', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('categories', $message);
        $categories = $this->categories_model->get_all_categories();
        $data['categories'] = $categories;
        $this->common->load_view('admin/categories/categories', $data);
    }

    public function validation()
    {
        $this->load->helper('security');
        $this->load->library('form_validation');
        //validation rules
        $this->form_validation->set_rules('category', 'lang:category', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'lang:description', 'trim|required|xss_clean');
    }

    public function load_new_category_view()
    {
        $message = array('title', 'description', 'category', 'save');
        $data = $this->common->set_language_and_data('new_category', $message);
        $this->common->load_view('admin/categories/new_category', $data);
    }

    public function load_edit_category_view($category_id)
    {
        $message = array('title', 'description', 'category', 'edit');
        $data = $this->common->set_language_and_data('edit_category', $message);
        $data['category_item'] = $this->categories_model->get_category_by_id($category_id);
        $this->common->load_view('admin/categories/edit_category', $data);
    }

    public function store_category()
    {
        $category = $this->input->post('category');
        $description = $this->input->post('description');
        return $this->categories_model->insert_category($category, $description);
    }

    public function edit_category($category_id)
    {
        $description = $this->input->post('description');
        $category = $this->input->post('category');
        return $this->categories_model->update_category($category_id, $category, $description);
    }

}
