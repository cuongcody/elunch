<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('common');
    }
    public function index()
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->load->helper('security');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('shift', 'lang:shift', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('day', 'lang:day', 'trim|required|numeric|xss_clean');
            $this->load_tracking_meal_view($this->input->post('shift'), $this->input->post('day'));
        }
        else $this->load_home_view();
    }

    public function load_home_view()
    {
        $message = array('title', 'total_users', 'total_categories', 'lastest_comments', 'live_attendant_status', 'total_shifts', 'total_tables', 'total_dishes', 'total_floors', 'total_menus', 'shift', 'search', 'normal_day', 'vegan_day', 'list_tables', 'create_log', 'status', 'attend', 'absent', 'late', 'choose_status', 'note', 'private_note', 'lunch_date', 'actual_meals', 'log', 'for_vegan', 'for_normal', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('home', $message);
        $this->load->model('shifts_model');
        $this->load->model('tables_model');
        $this->load->model('tracking_users_model');
        $shifts = $this->shifts_model->get_all_shifts();
        $data['shifts'] = $shifts;
        $data['status'] = $this->tracking_users_model->get_all_status();
        $this->common->load_view('admin/home', $data);
    }

    function get_tables_from_shift()
    {
        $this->common->authenticate();
        $shift_id = $this->input->post('shift_id');
        $day = $this->input->post('day');
        $for_vegans = ($day == NORMAL_DAY) ? 0 : NULL;
        $this->load->model('tables_model');
        $this->load->model('shifts_model');
        $tables = $this->tables_model->get_tables_by_shift($shift_id, $for_vegans, $day);
        $data['tables'] = $tables;
        $data['shift'] = $this->shifts_model->get_shift_by_id($shift_id);
        echo json_encode($data);
    }

    function logout()
    {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        redirect('admin/login', 'refresh');
    }

    public function validation($view)
    {
        $this->config->set_item('language', $this->session->userdata('site_lang'));
        $this->load->helper('security');
        $this->load->library('form_validation');
        // Validation rules
        if ($view == 'tracking')
        {
            $this->form_validation->set_rules('lunch_date', 'lang:lunch_date', 'trim|required|callback_check_date_format|xss_clean');
        }
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

    public function tracking_meal_log()
    {
        $this->common->authenticate();
        $tables = $this->input->post('tables');
        $meal_date = $this->input->post('lunch_date');
        $note = $this->input->post('note');
        $private_note = $this->input->post('private_note');
        $actual_meals = $this->input->post('actual_meals');
        $shift = $this->input->post('shift');
        $this->validation('tracking');
        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $data['status'] = 'failure';
            $data['message'] = $errors;
        }
        else
        {
            $this->load->model('meals_model');
            $message = $this->common->get_message('gen_log_file_meal', array('gen_log_file_success', 'gen_log_file_failure'));
            if ($this->meals_model->update_meal_log($shift, $tables, $meal_date, $note, $private_note, $actual_meals))
            {
                $data = array(
                    'status' => 'success',
                    'message' => $message['gen_log_file_success']);
            }
            else
            {
                $data = array(
                    'status' => 'failure',
                    'message' => $message['gen_log_file_failure']);
            }
        }
        echo json_encode($data);
    }

    public function list_status_of_users_from_tables()
    {
        $this->common->authenticate();
        $data = array();
        $table_ids = $this->input->post('table_ids');
        $day = $this->input->post('day');
        $this->load->model('tracking_users_model');
        $data['status'] = $this->tracking_users_model->get_all_status();
        $data['tables'] = $this->tracking_users_model->get_status_of_users_in_tables($table_ids, $day);
        echo json_encode($data);
    }

    public function update_status_of_user_from_table()
    {
        $this->common->authenticate();
        $user_id = $this->input->post('user_id');
        $status = $this->input->post('status');
        $this->load->model('tracking_users_model');
        $message = $this->common->get_message('update_status_user', array('update_status_user_success', 'update_status_user_failure'));
        if ($this->tracking_users_model->update_status_users(array($user_id), $status, 1))
        {
            $data = array(
                'status' => 'success',
                'message' => $message['update_status_user_success']);
        }
        else
        {
            $data = array(
                'status' => 'failure',
                'message' => $message['update_status_user_failure']);
        }
        echo json_encode($data);
    }

}