<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcements extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('common');
        $this->load->model('announcements_model');
    }

    public function index()
    {
        $this->common->authenticate();
        $this->load_announcement_view();
    }

    public function add()
    {
        $this->common->authenticate();
        $this->session->unset_userdata('upload');
        if (isset($_POST['submit']))
        {
            $this->validation();
            if ($this->form_validation->run() == FALSE)
            {
               $this->load_new_announcement_view();
            }
            else
            {
                if ($this->store_announcement()) $this->common->return_notification('new_announcement', 'add_success', 1);
                else $this->common->return_notification('new_announcement', 'add_failure', 0);
                redirect('admin/announcements','refresh');
            }
        }
        else
        {
            $this->load_new_announcement_view();
        }
    }

    public function validation()
    {
        $this->config->set_item('language', $this->session->userdata('site_lang'));
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('subject', 'lang:subject', 'trim|required|xss_clean');
        $this->form_validation->set_rules('content', 'lang:content', 'trim|required|xss_clean');
        $this->form_validation->set_rules('announcement_for', 'lang:announcement_for', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lunch_date', 'lang:lunch_date', 'trim|required|callback_check_date_format|xss_clean');

    }

    public function load_new_announcement_view()
    {
        $message = array('title', 'lunch_date', 'subject', 'content', 'announcement_for', 'user', 'name', 'table', 'table_name', 'shift', 'shift_name', 'send');
        $data = $this->common->set_language_and_data('new_announcement', $message);
        $this->load->model('tables_model');
        $this->load->model('users_model');
        $this->load->model('shifts_model');
        $data['tables'] = Tables_model::get_all_tables();
        $data['users'] = Users_model::get_all_users();
        $data['shifts'] = Shifts_model::get_all_shifts();
        $data['choose'] = array(ANNOUNCEMENT_ALL_USER, ANNOUNCEMENT_USER, ANNOUNCEMENT_TABLE, ANNOUNCEMENT_SHIFT);
        $this->common->load_view('admin/announcements/new_announcement', $data);
    }

    public function load_announcement_view()
    {
        $message = array('title', 'announcement', 'create_announce', 'to', 'all_users', 'user', 'shift', 'table', 'lunch_date', 'subject', 'content', 'inbox', 'reply', 'send', 'edit', 'delete', 'are_you_sure', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('announcements', $message);
        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/announcements');
        $config['total_rows'] = Announcements_model::number_of_announcements();
        $config['per_page'] = 5;
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
        $announcements = Announcements_model::get_announcements($config['per_page'],  ($data['page'] == 0 ? $data['page'] : ($data['page'] - 1)) * $config['per_page']);
        $data['announcements'] = $announcements;
        $this->common->load_view('admin/announcements/announcements', $data);
    }

    public function get_detail_announcement($announcement_id)
    {
        $this->common->authenticate();
        $result = Announcements_model::get_replies_announcement_by_id($announcement_id);
        $data = array();
        $replies = array();
        foreach ($result as $item)
        {
            $reply = array();
            $reply['id'] = (int)$item->reply_id;
            $reply['content'] = $item->reply_content;
            $reply['email'] = $item->email;
            $reply['avatar_content_file'] = $item->avatar_content_file;
            $reply['created_at'] = $item->reply_created_at;
            $reply['updated_at'] = $item->reply_updated_at;
            array_push($replies, $reply);
        }
        $data['replies'] = $replies;
        echo json_encode($data);
    }

    public function add_reply($announcement_id = NULL)
    {
        $this->common->authenticate();
        $message = $this->common->get_message('new_reply_announce', array('add_success', 'add_failure'));
        if (!is_null($announcement_id))
        {
            $content = $this->input->post('content');
            $this->load->helper('security');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('content', 'lang:content', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE)
            {
                $errors = validation_errors();
                $data['status'] = 'errors';
                $data['message'] = $errors;
            }
            else
            {
                $user_id = $this->session->userdata('logged_in')['user_id'];
                list($result, $reply_id) = $this->announcements_model->reply_announcement($user_id, $announcement_id, $content);
                if ($result)
                {
                    $data['status'] = 'success';
                    $data['message'] = $message['add_success'];
                    $data['email'] = $this->session->userdata('logged_in')['email'];
                    $data['content'] = $content;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['avatar_content_file'] = $this->session->userdata('logged_in')['avatar_content_file'];
                    $user = Announcements_model::get_user_in_announcement($announcement_id);
                    if ($user != NULL)
                    {
                        $announcement = $this->announcements_model->get_announcement_by_id($user->id, $announcement_id);
                        $send_notification = array();
                        $send_notification['data'] = array(
                            'type' => 'reply_announcement',
                            'announcement' => array(
                                'user_id' => $announcement->user_id,
                                'email' => $announcement->email,
                                'avatar_content_file' => $announcement->avatar_content_file,
                                'id' => (int)$announcement->id,
                                'meal_date' => $announcement->meal_date,
                                'title' => $announcement->title,
                                'content' => $announcement->content,
                                'read_flag' => $announcement->have_read,
                                'number_of_replies' => (int)$announcement->number_of_replies,
                                'number_of_have_read_replies' => (int)$announcement->count_replies_have_read,
                                'created_at' => $announcement->created_at),
                            'reply' => array(
                                'id' => (int)$reply_id,
                                'content' => $data['content'],
                                'created_at' => $data['created_at'],
                                'user_id' => (int)$user_id,
                                'email' => $data['email'],
                                'avatar_content_file' => $data['avatar_content_file']));
                        if ($user->gcm_regid != NULL) $this->common->send_notification(array($user->gcm_regid), $send_notification);
                    }
                }
                else
                {
                    $data['status'] = 'failure';
                    $data['message'] = $message['add_failure'];
                }
            }
        }
        else
        {
            $data['status'] = 'failure';
            $data['message'] = $message['add_failure'];
        }
        echo json_encode($data);
    }

    public function delete($announcement_id)
    {
        $this->common->authenticate();
        $message = $this->common->get_message('delete_announcement', array('delete_success', 'delete_failure'));
        if (Announcements_model::delete_announcement($announcement_id))
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

    public function check_date_format($date)
    {
        if (!$this->common->date_format($date))
        {
            $this->lang->load('web_portal/validation', $this->session->userdata('site_lang'));
            $this->form_validation->set_message('check_date_format', $this->lang->line('date_format'));
            return FALSE;
        }
        return TRUE;
    }

    public function store_announcement()
    {
        $this->load->model('users_model');
        $data['user_id'] = (int)$this->session->userdata('logged_in')['user_id'];
        $data['title'] = $this->input->post('subject');
        $data['content'] = $this->input->post('content');
        $data['meal_date'] = $this->input->post('lunch_date');
        $announcement_for = $this->input->post('announcement_for');
        $users = array();
        switch ($announcement_for)
        {
            case ANNOUNCEMENT_USER:
                $data['user'] = $this->input->post('user');
                $users[] = Users_model::get_user_by('id', $data['user']);
                break;
            case ANNOUNCEMENT_TABLE:
                $data['table'] = $this->input->post('table');
                $this->load->model('tables_model');
                $users =  Tables_model::get_users_in_table($data['table']);
                break;
            case ANNOUNCEMENT_SHIFT:
                $data['shift'] = $this->input->post('shift');
                $this->load->model('shifts_model');
                $users = Shifts_model::get_users_by_shift($data['shift']);
                break;
            default:
                $data['user'] = 'all';
                $users = Users_model::get_all_users();
                break;
        }
        list($result, $announcement_id) = Announcements_model::insert_announcement($data);
        if ($result)
        {
            $registation_ids = array();
            if ($users != NULL)
            {
                foreach ($users as $user)
                {
                    if ($user->gcm_regid != NULL) $registation_ids[] = $user->gcm_regid;
                }
            }
            $user = array();
            $user['avatar_content_file'] = $this->session->userdata('logged_in')['avatar_content_file'];
            $user['email'] = $this->session->userdata('logged_in')['email'];
            $user['id'] = (int)$this->session->userdata('logged_in')['user_id'];
            if ($registation_ids != NULL)
            {
                $send_notification['data'] = array(
                'type' => 'announcement',
                'announcement' => array(
                    'id' => (int)$announcement_id,
                    'title' => $data['title'],
                    'content' => $data['content'],
                    'meal_date' => $data['meal_date'],
                    'read_flag' => FALSE,
                    'number_of_replies' => 0,
                    'number_of_have_read_replies' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'email' => $user['email'],
                    'avatar_content_file' => $user['avatar_content_file'],
                    'user_id' => $user['id']));
                $this->common->send_notification($registation_ids, $send_notification);
            }
            return TRUE;
        }
        else return FALSE;
    }

}
?>