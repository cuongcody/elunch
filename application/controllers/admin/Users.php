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
        $this->common->authenticate();
        $search = $this->common->delete_session_searchitem('name');
        $search = '';
        $this->load_users_view($search);
    }

    public function search()
    {
        $this->common->authenticate();
        $search = $this->common->searchitem_handler('name', $this->input->post('search'));
        $this->load_users_view($search);
    }

    public function add()
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->validation('add');
            if ($this->form_validation->run() == FALSE)
            {
               $this->load_new_user_view();
            }
            else
            {
                if ($this->store_user()) $this->common->return_notification('new_user', 'add_success', 1);
                else $this->common->return_notification('new_user', 'add_failure', 0);
                redirect('admin/users','refresh');
            }
        }
        else
        {
            $this->session->unset_userdata('upload');
            $this->load_new_user_view();
        }
    }

    public function edit($user_id)
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->validation('edit');
            if ($this->form_validation->run() == FALSE)
            {
               $this->load_edit_user_view($user_id);
            }
            else
            {
                if ($this->edit_user($user_id)) $this->common->return_notification('edit_user', 'edit_success', 1);
                else $this->common->return_notification('edit_user', 'edit_failure', 0);
                redirect('admin/users','refresh');
            }
        }
        else
        {
            $this->session->unset_userdata('upload');
            $this->load_edit_user_view($user_id);
        }
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
            'avatar_content_file' => base_url(LINK_TO_IMAGE_OF_USERS.$image_data['file_name']),
            'want_vegan_meal' => $want_vegan_meal,
            'floor' => $this->input->post('floor'),
            'shift' => $this->input->post('shift')
            ));
        if ($check_register == USER_CREATED_SUCCESSFULLY)
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
            'avatar_content_file' => base_url(LINK_TO_IMAGE_OF_USERS.$image_data['file_name']),
            'want_vegan_meal' => $want_vegan_meal,
            'floor' => $this->input->post('floor')
            ));
        return $can_update;
    }

    public function delete($user_id)
    {
        $this->common->authenticate();
        $message = $this->common->get_message('delete_user', array('delete_success', 'delete_failure'));
        if (Users_model::delete_user($user_id))
        {
            $avatar_file_name = $this->input->post('avatar_file_name');
            $this->common->image_delete(SAVE_IMAGE_OF_USERS.'/'.$avatar_file_name);
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

    public function validation($view)
    {
        $this->config->set_item('language', $this->session->userdata('site_lang'));
        $this->load->helper('security');
        $this->load->library('form_validation');
        //validation rules
        if ($view == 'add')
        {
            $this->form_validation->set_rules('password', 'lang:password', 'trim|required|min_length[5]|xss_clean|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'lang:confirm_password', 'trim|required|min_length[5]|xss_clean');
            $this->form_validation->set_rules('avatar', 'lang:avatar', 'callback_check_image_upload');
            $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|callback_exist_email|xss_clean');
            $this->form_validation->set_rules('shift', 'lang:shift', 'required|xss_clean');
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
         'what_taste', 'save', 'want_vegan_meal', 'first_name', 'last_name', 'floor', 'shift',
         'admin', 'user', 'role', 'image_upload', 'avatar', 'exist_email');
        $data = $this->common->set_language_and_data('new_user', $message);
        $this->load->model('floors_model');
        $data['floors'] = Floors_model::get_all_floors();
        $this->load->model('shifts_model');
        $data['shifts'] = Shifts_model::get_all_shifts();
        $this->common->load_view('admin/users/new_user', $data);
    }

    public function load_edit_user_view($user_id)
    {
        $user = Users_model::get_user_by('id', $user_id);
        $image_data['file_name'] = $user->avatar_file_name;
        $this->session->set_userdata('upload', $image_data);
        $message = array('title', 'manage_users', 'email', 'password', 'confirm_password',
         'what_taste', 'edit', 'want_vegan_meal', 'first_name', 'last_name', 'floor', 'shift',
         'admin', 'user', 'role', 'image_upload', 'avatar', 'change_password', 'change_shift', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('edit_user', $message);
        $this->load->model('floors_model');
        $data['floors'] = Floors_model::get_all_floors();
        $this->load->model('shifts_model');
        $data['shifts'] = Shifts_model::get_all_shifts();
        $data['user'] = $user;
        $this->common->load_view('admin/users/edit_user', $data);
    }

    public function load_users_view($search)
    {
        $message = array('title', 'search', 'search_name', 'email', 'first_name', 'last_name', 'what_taste', 'want_vegan_meal', 'floor', 'role', 'user', 'admin', 'create_user', 'edit', 'delete', 'are_you_sure', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('users', $message);
        $this->load->library('pagination');
        $config['base_url'] = ($search == NULL) ? base_url().'/admin/users' : base_url().'/admin/users/search';
        $config['total_rows'] = Users_model::get_num_of_users($search);
        $config['per_page'] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = ($search == NULL) ? 3 : 4;
        $config['num_links'] = 3;
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] ="</ul>";
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
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
        $users = Users_model::get_all_users($config['per_page'], ($data['page'] == 0 ? $data['page'] : ($data['page'] - 1)) * $config['per_page'], $search);
        $data['users'] = $users;
        $this->common->load_view('admin/users/users', $data);
    }

    public function check_image_upload()
    {
        if (empty($this->session->userdata('upload')))
        {
            if ($_FILES['img']['size'] != 0)
            {
                if (!$this->common->image_upload(SAVE_IMAGE_OF_USERS))
                {
                    $this->lang->load('web_portal/validation', $this->session->userdata('site_lang'));
                    $this->form_validation->set_message('check_image_upload', $this->lang->line('error_upload'));
                    return FALSE;
                }
                else return TRUE;
            }
            else
            {
                $this->lang->load('web_portal/validation', $this->session->userdata('site_lang'));
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
            $old_image = $this->session->userdata('upload')['file_name'];
            if (!$this->common->image_upload(SAVE_IMAGE_OF_USERS))
            {
                $this->lang->load('web_portal/validation', $this->session->userdata('site_lang'));
                $this->form_validation->set_message('edit_image_upload', $this->lang->line('error_upload'));
                return FALSE;
            }
            else
            {
                $this->common->image_delete(SAVE_IMAGE_OF_USERS.'/'. $old_image);
                return TRUE;
            }
        }
        else return TRUE;
    }

    public function exist_email($email)
    {
        if (Users_model::is_user_exists($email))
        {
            $this->lang->load('web_portal/new_user', $this->session->userdata('site_lang'));
            $this->form_validation->set_message('exist_email', $this->lang->line('exist_email'));
            return FALSE;
        }
        return TRUE;
    }

    public function change_password($user_id)
    {
        $this->common->authenticate();
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

    public function change_shift($user_id)
    {
        $this->common->authenticate();
        $shift = $this->input->post('shift');
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('shift', 'lang:shift', 'trim|required|numeric|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $data['status'] = 'failure';
            $data['message'] = $errors;
        }
        else
        {
            $message = $this->common->get_message('change_shift', array('change_success', 'change_failure'));
            if ($this->users_model->update_shift($user_id, $shift))
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