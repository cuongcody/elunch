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
            $this->session->set_userdata('site_lang', $lang);
            // load language file
            $msg_lang = $this->common->get_message('forgot_password', array('title', 'email', 'reset_password'));
            // Set values in session
            $this->session->set_userdata('forgot_password_lang', $msg_lang);
            // Retrieve session values
            $forgot_password_lang = $this->session->all_userdata('forgot_password_lang');
            if (isset($_POST['submit']))
            {
                $this->validation('forgot_password');
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

    public function reset()
    {
        $message = $this->common->get_message('reset_password', array('title', 'password', 'confirm_password', 'reset_password'));
        $message['token'] = $this->input->get('token');
        $this->session->set_userdata('reset_password_lang', $message);
        $reset_password_lang = $this->session->all_userdata();
        if (isset($_POST['submit']))
        {
            $this->validation('reset_password');
            if ($this->form_validation->run() == FALSE)
            {
                $reset_password_lang = $this->session->all_userdata('reset_password_lang');
                $this->load->view('admin/reset_password', $reset_password_lang);
            }
            else
            {
                if ($this->reset_password()) $this->common->return_notification('reset_password', 'reset_password_success', 1);
                else $this->common->return_notification('reset_password', 'reset_password_failure', 0);
                redirect('admin/login','refresh');
            }
        }
        else $this->load->view('admin/reset_password', $reset_password_lang);
    }

    public function forgot_password()
    {
        $email = $this->input->post('email');
        list($result, $token) = $this->users_model->forgot_password($email);
        if ($result)
        {
            $this->users_model->send_mail($email, $token);
            return TRUE;
        }
        else return FALSE;
    }

    public function reset_password()
    {
        $token = $this->input->post('token');
        $password = $this->input->post('password');
        return $this->users_model->reset_password($token, $password);
    }

    public function validation($view)
    {
        $this->config->set_item('language', $this->session->userdata('site_lang'));
        $this->load->helper('security');
        $this->load->library('form_validation');
        //validation rules
        if ($view == 'forgot_password')
        {
            $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|xss_clean|callback_not_exist_email');
        }
        elseif ($view == 'reset_password')
        {
            $this->form_validation->set_rules('password', 'lang:password', 'trim|required|min_length[5]|xss_clean|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'lang:confirm_password', 'trim|required|min_length[5]|xss_clean');
            $this->form_validation->set_rules('token', 'lang:token', 'trim|required|xss_clean');
        }
    }

    public function not_exist_email($email)
    {
        if (!Users_model::is_user_exists($email))
        {
            $this->lang->load('web_portal/forgot_password', $this->session->userdata('site_lang'));
            $this->form_validation->set_message('not_exist_email', $this->lang->line('not_exist_email'));
            return FALSE;
        }
        return TRUE;
    }

}
