<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tables extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('common');
        $this->load->model('tables_model');
    }

    public function index()
    {
        $this->common->authenticate();
        $search = $this->common->delete_session_searchitem('name');
        $search = '';
        $this->load_tables_view($search);
    }

    public function search()
    {
        $this->common->authenticate();
        $search = $this->common->searchitem_handler('name', $this->input->post('search'));
        $this->load_tables_view($search);
    }

    public function add()
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->validation();
            if ($this->form_validation->run() == FALSE)
            {
                $this->load_new_table_view();
            }
            else
            {
                if ($this->store_or_edit_table('add')) $this->common->return_notification('new_table', 'add_success', 1);
                else $this->common->return_notification('new_table', 'add_failure', 0);
                redirect('admin/tables','refresh');
            }
        }
        else
        {
            $this->load_new_table_view();
        }
    }

    public function edit($table_id)
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->validation();
            if ($this->form_validation->run() == FALSE)
            {
                $this->load_edit_table_view($table_id);
            }
            else
            {
                if ($this->store_or_edit_table('edit', $table_id)) $this->common->return_notification('edit_table', 'edit_success', 1);
                else $this->common->return_notification('edit_table', 'edit_failure', 0);
                redirect('admin/tables','refresh');
            }
        }
        else
        {
            $this->load_edit_table_view($table_id);
        }
    }

    public function delete($table_id)
    {
        $this->common->authenticate();
        $message = $this->common->get_message('delete_table', array('delete_success', 'delete_failure'));
        if ($this->tables_model->delete_table($table_id))
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

    public function send_mail($table_id)
    {
        $data = array();
        $data['table'] = Tables_model::get_table_by($table_id);
        $data['users']['normal_day'] = Tables_model::get_users_in_table($table_id, NORMAL_DAY);
        $data['users']['vegan_day'] = Tables_model::get_users_in_table($table_id, NORMAL_DAY);
        $all_users_in_table = array();
        $all_users_in_table = $data['users']['normal_day'];
        foreach ($data['users']['normal_day'] as $user_normal) {
            if (!in_array($user_normal, $data['users']['vegan_day'])) $all_users_in_table[] = $data['users']['vegan_day'];
        }
        $emails = array();
        foreach ($all_users_in_table as $key => $user) {
            $emails[] = $user->email;
        }
        $view = $this->load->view('admin/tables/tables_mail', $data, true);
        $message = $this->common->get_message('tables_mail', array('title'));
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'elunch.enclaveit@gmail.com',
            'smtp_pass' => 'enclaveit@123',
            'mailtype'  => 'html',
            'auth' => true,
            'charset'   => 'iso-8859-1'
        );
        date_default_timezone_set('GMT');
        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from('elunch.enclaveit@gmail.com', 'Elunch');
        $this->email->to($emails);
        $this->email->subject($message['title']);
        $this->email->message($view);
        if ($this->email->send()) $this->common->return_notification('tables', 'send_success', 1);
        else $this->common->return_notification('tables', 'send_failure', 0);
        redirect('admin/tables','refresh');
    }

    public function add_user()
    {
        $this->common->authenticate();
        $user_id = $this->input->post('user_id');
        $table_id = $this->input->post('table_id');
        $day = $this->input->post('day');
        $message = $this->common->get_message('add_user', array('add_success', 'add_failure', 'have_table'));
        if (is_numeric($user_id) && is_numeric($table_id))
        {
            $result = $this->tables_model->arrange_to_add_user_in_table($user_id, $table_id, $day);
            switch ($result)
            {
                case JOIN_TABLE_SUCCESSFULLY:
                    $this->load->model('users_model');
                    $user = Users_model::get_user_by('id', $user_id);
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

    public function leave_table()
    {
        $this->common->authenticate();
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

    public function arrange()
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->load->helper('security');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('shift', 'lang:shift', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('day', 'lang:day', 'trim|required|numeric|xss_clean');
            $this->load_arrange_table_view($this->input->post('shift'), $this->input->post('day'));
        }
        else $this->load_arrange_table_view(NULL, NORMAL_DAY);
    }

    public function load_arrange_table_view($shift_id = NULL, $day)
    {
        $message = array('title', 'shift', 'search', 'normal_day', 'vegan_day', 'list_tables', 'table', 'arrange', 'for_vegan', 'for_normal','add_user', 'list_of_users', 'avatar', 'name', 'floor', 'vegan', 'move_to', 'leave', 'are_you_sure', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('arrange_tables', $message);
        $this->load->model('shifts_model');
        $data['shifts'] = Shifts_model::get_all_shifts();
        $for_vegans = ($day == NORMAL_DAY) ? 0 : NULL;
        $tables = array();
        if (!is_null($shift_id))
        {
            $tables = Tables_model::get_tables_by_shift($shift_id, $for_vegans, $day);
        }
        else
        {
            if (!empty($data['shifts']))
            {
                $shift_id = $data['shifts'][0]->id;
                $tables = Tables_model::get_tables_by_shift($shift_id, $for_vegans, $day);
            }
        }
        $data['tables'] = $tables;
        $data['users'] = Shifts_model::get_users_by_shift($shift_id);
        $data['day'] = $day;
        $this->common->load_view('admin/tables/arrange_tables', $data);
    }

    public function load_new_table_view()
    {
        $message = array('title', 'description', 'table', 'for_vegans', 'shift', 'seats','save');
        $data = $this->common->set_language_and_data('new_table', $message);
        $this->load->model('shifts_model');
        $data['shifts'] = Shifts_model::get_all_shifts();
        $this->common->load_view('admin/tables/new_table', $data);
    }

    public function load_edit_table_view($table_id)
    {
        $message = array('title', 'description', 'manage_tables', 'table', 'for_vegans', 'list_of_users', 'shift', 'seats', 'image', 'name', 'delete', 'are_you_sure', 'yes', 'cancel', 'floor', 'edit');
        $data = $this->common->set_language_and_data('edit_table', $message);
        $this->load->model('shifts_model');
        $data['shifts'] = Shifts_model::get_all_shifts();
        $data['table'] = Tables_model::get_table_by($table_id);
        $data['users'] = Tables_model::get_users_in_table($table_id);
        $this->common->load_view('admin/tables/edit_table', $data);
    }

    public function load_tables_view($search)
    {
        $message = array('title', 'search_name', 'search', 'table_name', 'seats', 'available_seats', 'for_vegans', 'shift', 'description', 'image', 'list_of_users', 'name', 'floor', 'create_table', 'edit', 'delete', 'are_you_sure', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('tables', $message);
        $this->load->library('pagination');
        $config['base_url'] = ($search == NULL) ? base_url().'/admin/tables' : base_url().'/admin/tables/search';
        $config['total_rows'] = Tables_model::get_num_of_tables($search);
        $config['per_page'] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = $config['uri_segment'] = ($search == NULL) ? 3 : 4;
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
        $data['page'] = ($search == NULL) ? (($this->uri->segment(3)) ? $this->uri->segment(3) : 0) : (($this->uri->segment(4)) ? $this->uri->segment(4) : 0);
        $tables = Tables_model::get_tables($config['per_page'],  ($data['page'] == 0 ? $data['page'] : ($data['page'] - 1)) * $config['per_page'], $search);
        $data['tables'] = $tables;
        $this->common->load_view('admin/tables/tables', $data);
    }

    public function list_users_from_table($table_id)
    {
        $this->common->authenticate();
        $day = $this->input->get('day');
        echo json_encode(Tables_model::get_users_in_table($table_id, $day));
    }

    public function validation()
    {
        $this->config->set_item('language', $this->session->userdata('site_lang'));
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('table', 'lang:table', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'lang:description', 'trim|required|xss_clean');
        $this->form_validation->set_rules('shift', 'lang:shift', 'trim|xss_clean');
        $this->form_validation->set_rules('seats', 'lang:seats', 'required|numeric|greater_than[1]|xss_clean');
    }

    public function store_or_edit_table($request, $table_id = NULL)
    {
        $table = array(
            'name' => $this->input->post('table'),
            'description' => $this->input->post('description'),
            'seats' => $this->input->post('seats'),
            'shift_id' => $this->input->post('shift'),
            'for_vegans' => (!empty($this->input->post('for_vegans'))) ? 1 : 0
            );
        if ($request == 'add') return Tables_model::insert_table($table);
        else return $this->tables_model->update_table($table_id, $table);
    }

    public function delete_user_in_table($table_id, $user_id)
    {
        $this->common->authenticate();
        $day = $this->input->get('day');
        $res = $this->tables_model->user_leave_table($user_id, $table_id, $day);
        $message = $this->common->get_message('delete_user', array('delete_success', 'delete_failure'));
        if ($res === DELETE_SEAT_FOR_USER_SUCCESSFULLY)
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

}