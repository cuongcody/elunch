<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function index($lang = '')
    {
        if ($this->session->userdata('logged_in'))
        {
            redirect('admin/home', 'refresh');
        }
        else
        {
            $this->session->unset_userdata('upload');
            $lang = ($lang == '')? 'english' : $lang;
            // load language file
            $this->lang->load('register_form', $lang);
            $msg_lang = $this->set_message();
            // Set values in session
            $this->session->set_userdata('register_lang', $msg_lang);
            $this->session->set_userdata('site_lang', $lang);
            // Retrieve session values
            $data = $this->session->all_userdata('register_lang');
            $this->load->model('floors_model');
            $floors = $this->floors_model->get_all_floors();
            $data['floors'] = $floors;
            $this->load->helper('form');
            $this->load->view('admin/register', $data);
        }
    }

    public function validation()
    {
        $this->load->helper('security');
        $this->load->library('form_validation');
        //validation rules
        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|callback_exist_email|xss_clean');
        $this->form_validation->set_rules('avatar', 'lang:avatar', 'callback_image_upload');
        $this->form_validation->set_rules('password', 'lang:password', 'trim|required|min_length[5]|xss_clean|matches[confirm_password]');
        $this->form_validation->set_rules('confirm_password', 'lang:confirm_password', 'trim|required|min_length[5]|xss_clean');
        $this->form_validation->set_rules('first_name', 'lang:first_name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('last_name', 'lang:last_name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('what_taste', 'lang:what_taste', 'trim|xss_clean');
        $this->form_validation->set_rules('role', 'lang:role', 'required|xss_clean');
        $this->form_validation->set_rules('floor', 'lang:floor', 'required|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->model('floors_model');
            $floors = $this->floors_model->get_all_floors();
            $data = $this->session->all_userdata();
            $data['floors'] = $floors;
            $this->load->view('admin/register', $data);
        }
        else
        {
            if ($this->store_user())
            {
                $this->session->unset_userdata('upload');
                redirect('admin/home','refresh');
            }
        }
    }

    public function store_user()
    {
        $image_data = $this->session->userdata('upload');
        $this->load->model('users_model');
        list($check_register, $result) = $this->users_model->insert_user(array(
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'what_taste' => $this->input->post('what_taste'),
            'role' => $this->input->post('role'),
            'avatar_file_name' => base_url('assets/images/users/'.$image_data['file_name']),
            'want_vegan_meal' => $this->input->post('want_vegan_meal'),
            'floor' => $this->input->post('floor')
            ));
        if ($check_register == USER_CREATED_SUCCESSFULLY)
        {
            $issue_at = time();
            $user['authentication_token'] = $this->jwt->encode(array(
                                    'iat' => $issue_at,
                                    'nbf' => $issue_at + 10,
                                    'exp' => $issue_at + 172800,
                                    'tok' => $result['authentication_token'],
                                    'email' => $this->input->post('email'),
                                    'password' => $this->input->post('password')
                                    ), $this->config->item("secret_key"));
                $session_array = array(
                    'authen_key' => $user['authentication_token'],
                    'email' => $result['email'],
                    'first_name' => $result['first_name'],
                    'last_name' => $result['last_name'],
                    'want_vegan_meal' => (boolean)$result['want_vegan_meal'],
                    'avatar_file_name' => $result['avatar_file_name']);
                $this->session->set_userdata('logged_in', $session_array);
                return TRUE;
        }
        else
        {
            redirect('admin/login','refresh');
        }
    }

    public function set_message()
    {
        $msg_lang = array();
        $msg_lang['title'] = $this->lang->line('title');
        $msg_lang['email'] = $this->lang->line('email');
        $msg_lang['password'] = $this->lang->line('password');
        $msg_lang['confirm_password'] = $this->lang->line('confirm_password');
        $msg_lang['what_taste'] = $this->lang->line('what_taste');
        $msg_lang['first_name'] = $this->lang->line('first_name');
        $msg_lang['last_name'] = $this->lang->line('last_name');
        $msg_lang['register'] = $this->lang->line('register');
        $msg_lang['floor'] = $this->lang->line('floor');
        $msg_lang['want_vegan_meal'] = $this->lang->line('want_vegan_meal');
        $msg_lang['admin'] = $this->lang->line('admin');
        $msg_lang['user'] = $this->lang->line('user');
        $msg_lang['avatar'] = $this->lang->line('avatar');
        $msg_lang['role'] = $this->lang->line('role');
        $msg_lang['select_lang'] = $this->lang->line('select_lang');
        $msg_lang['english'] = $this->lang->line('english');
        $msg_lang['vietnamese'] = $this->lang->line('vietnamese');
        $msg_lang['login_page'] = $this->lang->line('login_page');
        return $msg_lang;
    }

    public function image_upload()
    {
        if(empty($this->session->userdata('upload')))
        {
            if ($_FILES['img']['size'] != 0)
            {
                $upload_dir = APPPATH. '../assets/images/users';
                $config = array(
                    'upload_path' => $upload_dir,
                    'allowed_types' => 'gif|jpg|png',
                    'max_size' => '500000');
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('img')){
                    $this->form_validation->set_message('image_upload', $this->upload->display_errors());
                    return FALSE;
                }
                $image_data =  $this->upload->data();
                if (!empty($image_data)){
                    $config = array(
                        "source_image" => chmod($image_data['full_path'], 0777),
                        "new_image" => $upload_dir,
                        "maintain_ratio" => true,
                        "width" => '128',
                        "height" => '128');
                    $this->load->library("image_lib", $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('upload', $image_data);
                return TRUE;
                }
            }
            else
            {
                $this->lang->load('register_form', $this->session->userdata('site_lang'));
                $this->form_validation->set_message('image_upload', $this->lang->line('image_upload'));
                return FALSE;
            }
        }
    }

    public function exist_email($email)
    {
        $this->load->model('users_model');
        if ($this->users_model->is_user_exists($email))
        {
            $this->lang->load('register_form', $this->session->userdata('site_lang'));
            $this->form_validation->set_message('exist_email', $this->lang->line('exist_email'));
            return FALSE;
        }
        return TRUE;
    }

}