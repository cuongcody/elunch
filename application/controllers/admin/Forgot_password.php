<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('users_model');
        $this->load->library('common');
    }
    public function index($lang = '')
    {
        if ($this->session->userdata('logged_in'))
        {
            redirect('admin/home', 'refresh');
        }
        else
        {
            $lang = ($lang == '') ? 'english' : $lang;
            // load language file
            $this->lang->load('web_portal/forgot_password', $lang);
            $msg_lang = $this->set_message();
            // Set values in session
            $this->session->set_userdata('forgot_password_lang', $msg_lang);
            $this->session->set_userdata('site_lang', $lang);
            // Retrieve session values
            $forgot_password_lang = $this->session->all_userdata('forgot_password_lang');
            if (isset($_POST['submit']))
            {
                $this->validation();
                if ($this->form_validation->run() == FALSE)
                {
                    $forgot_password_lang = $this->session->all_userdata('forgot_password_lang');
                    $this->load->view('admin/forgot_password', $forgot_password_lang);
                }
                else
                {
                    if ($this->forgot_password()) $this->common->return_notification('forgot_password', 'reset_password_success', 1);
                    else $this->common->return_notification('forgot_password', 'reset_password_failure', 0);
                    redirect('admin/login','refresh');
                }
            }
            else $this->load->view('admin/forgot_password', $forgot_password_lang);
        }
    }

    public function forgot_password()
    {
        $email = $this->input->post('email');
        list($result, $new_password) = $this->users_model->reset_password($email);
        if ($result)
        {
             $this->send_mail($email, $new_password);
             return TRUE;
        }
        else return FALSE;
    }

    public function send_mail($email, $password)
    {
        $message = $this->common->get_message('forgot_password', array('reset_password', 'send_mail_success'));
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
        $this->email->to($email);
        $this->email->subject($message['reset_password']);
        $this->email->message($message['send_mail_success']. $password);
        return $this->email->send();
    }
    public function set_message()
    {
        $msg_lang = array();
        $msg_lang['title'] = $this->lang->line('title');
        $msg_lang['email'] = $this->lang->line('email');
        $msg_lang['reset_password'] = $this->lang->line('reset_password');
        $msg_lang['reset_password_success'] = $this->lang->line('select_lang');
        $msg_lang['reset_password_failure'] = $this->lang->line('login');
        return $msg_lang;
    }

    public function validation()
    {
        $this->config->set_item('language', $this->session->userdata('site_lang'));
        $this->load->helper('security');
        $this->load->library('form_validation');
        //validation rules
        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|xss_clean|callback_not_exist_email');
    }

    public function not_exist_email($email)
    {
        if (!$this->users_model->is_user_exists($email))
        {
            $this->lang->load('web_portal/forgot_password', $this->session->userdata('site_lang'));
            $this->form_validation->set_message('not_exist_email', $this->lang->line('not_exist_email'));
            return FALSE;
        }
        return TRUE;
    }

}
