<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('common');
        $this->load->model('users_model');
    }
    public function index()
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            $this->load_users_view();
        }
        else
        {
            redirect('admin/login', 'refresh');
        }
    }

    public function add()
    {
        if ( $this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            if (isset($_POST['submit']))
            {
                $this->validation('add');
                if ($this->form_validation->run() == FALSE)
                {
                   $this->load_new_user_view();
                }
                else
                {
                    if ($this->store_user())
                    {
                        $this->session->unset_userdata('upload');
                        $message = $this->common->get_message('add_user', array('add_success'));
                        $this->session->set_flashdata('message', $message['add_success']);
                    }
                    else
                    {
                        $message = $this->common->get_message('add_user', array('add_failure'));
                        $this->session->set_flashdata('message', $message['add_failure']);
                    }
                    redirect('admin/users','refresh');
                }
            }
            else
            {
                $this->load_new_user_view();
            }
        }
       else redirect('admin/login', 'refresh');
    }

    public function edit($user_id)
    {
        if ( $this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            if (isset($_POST['submit']))
            {
                $this->validation('edit');
                if ($this->form_validation->run() == FALSE)
                {
                   $this->load_edit_user_view($user_id);
                }
                else
                {
                    if ($this->edit_user($user_id))
                    {
                        $this->session->unset_userdata('upload');
                        $message = $this->common->get_message('edit_user', array('edit_success'));
                        $this->session->set_flashdata('message', $message['edit_success']);
                    }
                    else
                    {
                        $message = $this->common->get_message('edit_user', array('edit_failure'));
                        $this->session->set_flashdata('message', $message['edit_failure']);
                    }
                    redirect('admin/users','refresh');
                }
            }
            else
            {
                $this->session->unset_userdata('upload');
                $this->load_edit_user_view($user_id);
            }
        }
       else redirect('admin/login', 'refresh');
    }

    public function store_user()
    {
        $want_vegan_meal = (!empty($this->input->post('want_vegan_meal'))) ? 1 : 0;
        $image_data = $this->session->userdata('upload');
        list($check_register, $result) = $this->users_model->insert_user(array(
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'what_taste' => $this->input->post('what_taste'),
            'role' => $this->input->post('role'),
            'avatar_file_name' => $image_data['file_name'],
            'avatar_content_file' => base_url('assets/images/users/'.$image_data['file_name']),
            'want_vegan_meal' => $want_vegan_meal,
            'floor' => $this->input->post('floor')
            ));
        if ($check_store == USER_CREATED_SUCCESSFULLY)
        {
                return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function edit_user($user_id)
    {
        $want_vegan_meal = (!empty($this->input->post('want_vegan_meal'))) ? 1 : 0;
        $image_data = $this->session->userdata('upload');
        $can_update = $this->users_model->update_user($user_id,
            array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'what_taste' => $this->input->post('what_taste'),
            'role' => $this->input->post('role'),
            'avatar_file_name' => $image_data['file_name'],
            'avatar_content_file' => base_url('assets/images/users/'.$image_data['file_name']),
            'want_vegan_meal' => $want_vegan_meal,
            'floor' => $this->input->post('floor')
            ));
        return $can_update;
    }

    public function delete($user_id)
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            $message = $this->common->get_message('delete_user', array('delete_success', 'delete_failure'));
             if ($this->users_model->delete_user($user_id))
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
        else redirect('admin/login', 'refresh');
    }

    public function validation($view)
    {
        $this->load->helper('security');
        $this->load->library('form_validation');
        //validation rules
        if ($view == 'add')
        {
            $this->form_validation->set_rules('password', 'lang:password', 'trim|required|min_length[5]|xss_clean|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'lang:confirm_password', 'trim|required|min_length[5]|xss_clean');
            $this->form_validation->set_rules('avatar', 'lang:avatar', 'callback_check_image_upload');
            $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|callback_exist_email|xss_clean');
        }
        else
        {
            $this->form_validation->set_rules('avatar', 'lang:avatar', 'callback_edit_image_upload');
        }
        $this->form_validation->set_rules('first_name', 'lang:first_name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('last_name', 'lang:last_name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('what_taste', 'lang:what_taste', 'trim|xss_clean');
        $this->form_validation->set_rules('role', 'lang:role', 'required|xss_clean');
        $this->form_validation->set_rules('floor', 'lang:floor', 'required|xss_clean');
    }

    public function load_new_user_view()
    {
        $message = array('title', 'email', 'password', 'confirm_password',
         'what_taste', 'save', 'want_vegan_meal', 'first_name', 'last_name', 'floor',
         'admin', 'user', 'role', 'image_upload', 'avatar', 'exist_email');
        $data = $this->common->set_language_and_data('new_user', $message);
        $this->load->model('floors_model');
        $data['floors'] = $this->floors_model->get_all_floors();
        $this->common->load_view('admin/users/new_user', $data);
    }

    public function load_edit_user_view($user_id)
    {
        $user = $this->users_model->get_user_by('id', $user_id);
        $image_data['file_name'] = $user->avatar_file_name;
        $this->session->set_userdata('upload', $image_data);
        $message = array('title', 'email', 'password', 'confirm_password',
         'what_taste', 'edit', 'want_vegan_meal', 'first_name', 'last_name', 'floor',
         'admin', 'user', 'role', 'image_upload', 'avatar', 'change_password', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('edit_user', $message);
        $this->load->model('floors_model');
        $floors = $this->floors_model->get_all_floors();
        $data['floors'] = $floors;
        $data['user'] = $user;
        $this->common->load_view('admin/users/edit_user', $data);
    }

    public function load_users_view()
    {
        $message = array('title', 'email', 'first_name', 'last_name', 'what_taste', 'want_vegan_meal', 'floor', 'role', 'user', 'admin', 'create_user', 'edit', 'delete', 'are_you_sure', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('users', $message);
        $this->load->library('pagination');
        $config['base_url'] = base_url().'/admin/users';
        $config['total_rows'] = $this->users_model->get_num_of_users();
        $config['per_page'] = 10;
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
        $users = $this->users_model->get_users($config['per_page'], $data['page']);
        $data['users'] = $users;
        $this->common->load_view('admin/users/users', $data);
    }

    public function check_image_upload()
    {
        if (empty($this->session->userdata('upload')))
        {
            if ($_FILES['img']['size'] != 0)
            {
                $this->common->image_upload('../assets/images/users');
            }
            else
            {
                $this->lang->load('validation', $this->session->userdata('site_lang'));
                $this->form_validation->set_message('check_image_upload', $this->lang->line('image_upload'));
                return FALSE;
            }
        }
        return TRUE;
    }

    public function edit_image_upload()
    {
        if ($_FILES['img']['size'] != 0)
        {
            $this->common->image_upload('../assets/images/users');
        }
        else return TRUE;
    }

    public function exist_email($email)
    {
        if ($this->users_model->is_user_exists($email))
        {
            $this->lang->load('new_user', $this->session->userdata('site_lang'));
            $this->form_validation->set_message('exist_email', $this->lang->line('exist_email'));
            return FALSE;
        }
        return TRUE;
    }

    public function change_password($user_id)
    {
        $password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'lang:password', 'trim|required|min_length[5]|xss_clean|matches[confirm_password]');
        $this->form_validation->set_rules('confirm_password', 'lang:confirm_password', 'trim|required|min_length[5]|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $data['status'] = 'failure';
            $data['message'] = $errors;
        }
        else
        {
            $message = $this->common->get_message('change_password', array('change_success', 'change_failure'));
            if ($this->users_model->change_password_of_admin($user_id, $password))
            {
                $data['status'] = 'success';
                $data['message'] = $message['change_success'];
            }
            else
            {
                $data['status'] = 'failure';
                $data['message'] = $message['change_failure'];
            }
        }
        echo json_encode($data);
    }

}