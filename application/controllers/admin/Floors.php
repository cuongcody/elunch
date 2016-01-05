<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Floors extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('common');
        $this->load->model('floors_model');
    }
    public function index()
    {
        $this->common->authenticate();
        $this->load_floors_view();
    }

    public function add()
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->validation();
            if ($this->form_validation->run() == FALSE)
            {
               $this->load_new_floor_view();
            }
            else
            {
                if ($this->store_floor()) $this->common->return_notification('new_floor', 'add_success', 1);
                else $this->common->return_notification('new_floor', 'add_failure', 0);
                redirect('admin/floors','refresh');
            }
        }
        else
        {
            $this->load_new_floor_view();
        }
    }

    public function edit($floor_id)
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->validation();
            if ($this->form_validation->run() == FALSE)
            {
               $this->load_edit_floor_view($floor_id);
            }
            else
            {
                if ($this->edit_floor($floor_id)) $this->common->return_notification('edit_floor', 'edit_success', 1);
                else $this->common->return_notification('edit_floor', 'edit_failure', 0);
                redirect('admin/floors','refresh');
            }
        }
        else
        {
            $this->load_edit_floor_view($floor_id);
        }
    }

    public function delete($floor_id)
    {
        $this->common->authenticate();
        $message = $this->common->get_message('delete_floor', array('delete_success', 'delete_failure'));
        if (Floors_model::delete_floor($floor_id))
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

    public function load_floors_view()
    {
        $message = array('title', 'description', 'floor', 'create_floor', 'edit', 'delete', 'are_you_sure', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('floors', $message);
        $data['floors'] = Floors_model::get_all_floors();
        $this->common->load_view('admin/floors/floors', $data);
    }

    public function validation()
    {
        $this->config->set_item('language', $this->session->userdata('site_lang'));
        $this->load->helper('security');
        $this->load->library('form_validation');
        //validation rules
        $this->form_validation->set_rules('floor', 'lang:floor', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'lang:description', 'trim|required|xss_clean');
    }

    public function load_new_floor_view()
    {
        $message = array('title', 'description', 'floor', 'save');
        $data = $this->common->set_language_and_data('new_floor', $message);
        $this->common->load_view('admin/floors/new_floor', $data);
    }

    public function load_edit_floor_view($floor_id)
    {
        $message = array('title', 'description', 'manage_floors', 'floor', 'edit');
        $data = $this->common->set_language_and_data('edit_floor', $message);
        $data['floor'] = Floors_model::get_floor_by_id($floor_id);
        $this->common->load_view('admin/floors/edit_floor', $data);
    }

    public function store_floor()
    {
        $floor = $this->input->post('floor');
        $description = $this->input->post('description');
        return Floors_model::insert_floor($floor, $description);
    }

    public function edit_floor($floor_id)
    {
        $description = $this->input->post('description');
        $floor = $this->input->post('floor');
        return Floors_model::update_floor($floor_id, $floor, $description);
    }

}
