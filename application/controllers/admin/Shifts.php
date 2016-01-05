<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shifts extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('common');
        $this->load->model('shifts_model');
    }

    public function index()
    {
        $this->common->authenticate();
        $this->load_shifts_view();
    }

    public function add()
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->validation();
            if ($this->form_validation->run() == FALSE)
            {
               $this->load_new_shift_view();
            }
            else
            {
                if ($this->store_or_edit_shift('add')) $this->common->return_notification('new_shift', 'add_success', 1);
                else $this->common->return_notification('new_shift', 'add_failure', 0);
                redirect('admin/shifts','refresh');
            }
        }
        else
        {
            $this->load_new_shift_view();
        }
    }

    public function edit($shift_id)
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->validation();
            if ($this->form_validation->run() == FALSE)
            {
               $this->load_edit_shift_view($shift_id);
            }
            else
            {
                if ($this->store_or_edit_shift('edit', $shift_id)) $this->common->return_notification('edit_shift', 'edit_success', 1);
                else $this->common->return_notification('edit_shift', 'edit_failure', 0);
                redirect('admin/shifts','refresh');
            }
        }
        else
        {
            $this->load_edit_shift_view($shift_id);
        }
    }

    public function delete($shift_id)
    {
        $this->common->authenticate();
        $message = $this->common->get_message('delete_shift', array('delete_success', 'delete_failure'));
        if (Shifts_model::delete_shift($shift_id))
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

    public function load_shifts_view()
    {
        $message = array('title', 'description', 'shift', 'create_shift', 'start_time', 'end_time', 'edit', 'delete', 'are_you_sure', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('shifts', $message);
        $shifts = Shifts_model::get_all_shifts();
        $data['shifts'] = $shifts;
        $this->common->load_view('admin/shifts/shifts', $data);
    }


    public function validation()
    {
        $this->config->set_item('language', $this->session->userdata('site_lang'));
        $this->load->helper('security');
        $this->load->library('form_validation');
        //validation rules
        $this->form_validation->set_rules('shift', 'lang:shift', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'lang:description', 'trim|required|xss_clean');
        $this->form_validation->set_rules('start_time', 'lang:start_time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('end_time', 'lang:end_time', 'trim|required|callback_check_time|xss_clean');
    }

    function check_time()
    {
        $from = date("H:i", strtotime($this->input->post('start_time')));
        $to = date("H:i", strtotime($this->input->post('end_time')));
        if ($to > $from) return TRUE;
        else
        {
            $this->lang->load('web_portal/validation', $this->session->userdata('site_lang'));
            $this->form_validation->set_message('check_time', $this->lang->line('time_format'));
            return FALSE;
        }
    }

    public function load_new_shift_view()
    {
        $message = array('title', 'description', 'shift', 'start_time', 'end_time', 'save');
        $data = $this->common->set_language_and_data('new_shift', $message);
        $this->common->load_view('admin/shifts/new_shift', $data);
    }

    public function load_edit_shift_view($shift_id)
    {
        $message = array('title', 'description', 'manage_shifts', 'start_time', 'end_time', 'shift', 'edit');
        $data = $this->common->set_language_and_data('edit_shift', $message);
        $data['shift'] = Shifts_model::get_shift_by_id($shift_id);
        $this->common->load_view('admin/shifts/edit_shift', $data);
    }

    public function store_or_edit_shift($request, $shift_id = NULL)
    {
        $shift = $this->input->post('shift');
        $description = $this->input->post('description');
        $start_time = date("H:i", strtotime($this->input->post('start_time')));
        $end_time = date("H:i", strtotime($this->input->post('end_time')));
        $data = array(
            'name' => $shift,
            'description' => $description,
            'start_time' => $start_time,
            'end_time' => $end_time);
        if ($request == 'add') return Shifts_model::insert_shift($data);
        else return Shifts_model::update_shift($shift_id, $data);
    }

}
