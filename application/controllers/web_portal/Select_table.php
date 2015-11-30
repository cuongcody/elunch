<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Select_table extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('common');
        $this->load->model('tables_model');
    }

    public function index()
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('logged_in')['role'] == 0)
        {
            if (isset($_POST['submit']))
            {
                $this->load->helper('security');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('shift', 'lang:shift', 'trim|required|numeric|xss_clean');
                $this->form_validation->set_rules('day', 'lang:day', 'trim|required|numeric|xss_clean');
                $this->load_tracking_meal_view($this->input->post('shift'), $this->input->post('day'));
            }
            else $this->load_tables_view();
        }
        else redirect('admin/login','refresh');
    }

    public function load_tables_view()
    {
        $message = array('title', 'join_table', 'shift', 'day', 'normal_day', 'vegan_day', 'list_tables', 'create_log', 'status');
        $data = $this->common->set_language_and_data('join_table', $message);
        $this->load->model('shifts_model');
        $user = array();
        $user['user_id'] = $this->session->userdata('logged_in')['user_id'];
        $user['first_name'] = $this->session->userdata('logged_in')['first_name'];
        $user['want_vegan_meal'] = $this->session->userdata('logged_in')['want_vegan_meal'];
        $data['user'] = $user;
        $shift = $this->shifts_model->get_shift_by_id($this->session->userdata('logged_in')['shift_id']);
        $data['shift'] = $shift;
        $this->common->load_view('web_portal/join_table', $data);
    }

    function get_tables_from_shift()
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('logged_in')['role'] == 0)
        {
            $shift_id = $this->input->post('shift_id');
            $day = $this->input->post('day');
            $for_vegans = $day;
            $this->load->model('tables_model');
            $this->load->model('shifts_model');
            $tables = $this->tables_model->get_tables_by_shift($shift_id, $for_vegans, $day);
            $data['tables'] = $tables;
            $data['shift'] = $this->shifts_model->get_shift_by_id($shift_id);
            echo json_encode($data);
        }
        else redirect('admin/login','refresh');
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

    public function list_status_of_users_from_tables()
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('logged_in')['role'] == 0)
        {
            $data = array();
            $table_ids = $this->input->post('table_ids');
            $day = $this->input->post('day');
            $this->load->model('tracking_users_model');
            $data['status'] = $this->tracking_users_model->get_all_status();
            $data['tables'] = $this->tracking_users_model->get_status_of_users_in_tables($table_ids, $day);
            echo json_encode($data);
        }
        else redirect('admin/login','refresh');
    }

    public function join_table()
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('logged_in')['role'] == 0)
        {
            $user_id = $this->input->post('user_id');
            $table_id = $this->input->post('table_id');
            $message = $this->common->get_message('add_user', array('add_success', 'add_failure', 'have_table'));
            if (is_numeric($user_id) && is_numeric($table_id))
            {
                $result = $this->tables_model->set_table_for_user($user_id, $table_id);
                switch ($result)
                {
                    case JOIN_TABLE_SUCCESSFULLY:
                        $this->load->model('users_model');
                        $user = $this->users_model->get_user_by('id', $user_id);
                        $data = array(
                            'status' => 'success',
                            'message' => $message['add_success'],
                            'user' => $user);
                        break;
                    case JOIN_TABLE_FAILED:
                        $data = array(
                            'status' => 'failure',
                            'message' => $message['add_failure']);
                        break;
                    case HAVE_SEAT_IN_TABLE:
                        $data = array(
                            'status' => 'failure',
                            'message' => $message['have_table']);
                        break;
                }
            }
            else
            {
                $data = array(
                    'status' => 'failure',
                    'message' => $message['add_failure']);
            }
            echo json_encode($data);
        }
        else redirect('admin/login','refresh');
    }

    public function leave_table()
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('logged_in')['role'] == 0)
        {
            $user_id = $this->input->post('user_id');
            $table_id = $this->input->post('table_id');
            $message = $this->common->get_message('leave_table', array('leave_success', 'leave_failure'));
            if (is_numeric($user_id) && is_numeric($table_id))
            {
                $result = $this->tables_model->user_leave_table($user_id, $table_id);
                switch ($result)
                {
                    case LEAVE_TABLE_SUCCESSFULLY:
                        $data = array(
                        'status' => 'success',
                        'message' => $message['leave_success']);
                        break;
                    default:
                        $data = array(
                        'status' => 'failure',
                        'message' => $message['leave_failure']);
                        break;
                }
            }
            else
            {
                $data = array(
                    'status' => 'failure',
                    'message' => $message['leave_failure']);
            }
            echo json_encode($data);
        }
        else redirect('admin/login','refresh');
    }

    public function change_users_taste($want_vegan_meal)
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('logged_in')['role'] == 0)
        {
            $this->load->model('users_model');
            $data['want_vegan_meal'] = (bool)$want_vegan_meal;
            $data['what_taste'] = NULL;
            $user_id = $this->session->userdata('logged_in')['user_id'];
            if ($this->users_model->edit_profile($data, $user_id))
            {
                $new_session = $this->session->userdata('logged_in');
                $new_session['want_vegan_meal'] = $want_vegan_meal;
                $this->session->set_userdata('logged_in', $new_session);
                $this->common->return_notification('edit_user', 'edit_success', 1);
            }
            else $this->common->return_notification('edit_user', 'edit_failure', 0);
            redirect('web_portal/select_table','refresh');
        }
    }

}