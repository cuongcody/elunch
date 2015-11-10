<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }
    public function index($lang = '')
    {
        if ($this->session->userdata('logged_in'))
        {
            redirect('admin/home', 'refresh');
        }
        else
        {
            $lang = ($lang == '')? 'english' : $lang;
            // load language file
            $this->lang->load('web_portal/login_form', $lang);
            $msg_lang = $this->set_message();
            // Set values in session
            $this->session->set_userdata('login_lang', $msg_lang);
            $this->session->set_userdata('site_lang', $lang);
            // Retrieve session values
            $login_lang = $this->session->all_userdata('login_lang');
            $this->load->helper('form');
            $this->load->view('admin/login', $login_lang);
        }
    }

    public function set_message()
    {
        $msg_lang = array();
        $msg_lang['title'] = $this->lang->line('title');
        $msg_lang['email'] = $this->lang->line('email');
        $msg_lang['password'] = $this->lang->line('password');
        $msg_lang['select_lang'] = $this->lang->line('select_lang');
        $msg_lang['login'] = $this->lang->line('login');
        $msg_lang['forgot_password'] = $this->lang->line('forgot_password');
        $msg_lang['english'] = $this->lang->line('english');
        $msg_lang['vietnamese'] = $this->lang->line('vietnamese');
        return $msg_lang;
    }

    public function check_login()
    {
        $this->config->set_item('language', $this->session->userdata('site_lang'));
        $this->load->helper('security');
        $this->load->library('form_validation');
        //validation rules
        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('password', 'lang:password', 'trim|required|min_length[5]|xss_clean|callback_check_database');
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('admin/login', $this->session->all_userdata());
        }
        else
        {
            redirect('admin/home','refresh');
        }
    }

    public function check_database($password)
    {
        $email = $this->input->post('email');
        $this->load->model('users_model');
            $issue_at = time();
            list($can_login, $result) = $this->users_model->login(array(
                'email' => $email,
                'password' => $password), 'admin');
            if ($can_login)
            {
                $session_array = array(
                    'user_id' => $result->id,
                    'email' => $result->email,
                    'first_name' => $result->first_name,
                    'last_name' => $result->last_name,
                    'want_vegan_meal' => (boolean)$result->want_vegan_meal,
                    'avatar_content_file' => $result->avatar_content_file);
                $this->session->set_userdata('logged_in', $session_array);
                return TRUE;
            }
            else
            {
                $this->lang->load('web_portal/login_form', $this->session->userdata('site_lang'));
                $this->form_validation->set_message('check_database', $this->lang->line('check_database'));
                return FALSE;
            }
    }

}
