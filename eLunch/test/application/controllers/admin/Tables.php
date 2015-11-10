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
        if ($this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            $this->load_tables_view();
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
                $this->validation();
                if ($this->form_validation->run() == FALSE)
                {
                    $this->load_new_table_view();
                }
                else
                {
                    if ($this->store_or_edit_table('store'))
                    {
                        $message = $this->common->get_message('new_table', array('add_success'));
                        $this->session->set_flashdata('message', $message['add_success']);
                    }
                    else
                    {
                        $message = $this->common->get_message('new_table', array('add_failure'));
                        $this->session->set_flashdata('message', $message['add_failure']);
                    }
                    redirect('admin/tables','refresh');
                }
            }
            else
            {
                $this->load_new_table_view();
            }
        }
       else redirect('admin/login', 'refresh');
    }

    public function edit($table_id)
    {
        if ( $this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
            if (isset($_POST['submit']))
            {
                $this->validation();
                if ($this->form_validation->run() == FALSE)
                {
                    $this->load_edit_table_view($table_id);
                }
                else
                {
                    if ($this->store_or_edit_table('edit', $table_id))
                    {
                        $message = $this->common->get_message('edit_table', array('edit_success'));
                        $data['status'] = 'success';
                        $data['message'] = $message['edit_success'];
                        $this->session->set_flashdata('message', json_encode($data));
                    }
                    else
                    {
                        $message = $this->common->get_message('edit_table', array('edit_failure'));
                        $data['status'] = 'failure';
                        $data['message'] = $message['edit_failure'];
                        $this->session->set_flashdata('message', json_encode($data));
                    }
                    redirect('admin/tables','refresh');
                }
            }
            else
            {
                $this->load_edit_table_view($table_id);
            }
        }
       else redirect('admin/login', 'refresh');
    }

    public function delete($table_id)
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {
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
        else redirect('admin/login', 'refresh');
    }

    public function load_new_table_view()
    {
        $message = array('title', 'description', 'table', 'for_vegans', 'shift', 'seats','save');
        $data = $this->common->set_language_and_data('new_table', $message);
        $this->load->model('shifts_model');
        $shifts = $this->shifts_model->get_all_shifts();
        $data['shifts'] = $shifts;
        $this->common->load_view('admin/tables/new_table', $data);
    }

    public function load_edit_table_view($table_id)
    {
        $message = array('title', 'description', 'table', 'for_vegans', 'list_of_users', 'shift', 'seats', 'image', 'name', 'delete', 'are_you_sure', 'yes', 'cancel', 'floor', 'edit');
        $data = $this->common->set_language_and_data('edit_table', $message);
        $this->load->model('shifts_model');
        $shifts = $this->shifts_model->get_all_shifts();
        $data['shifts'] = $shifts;
        $data['table'] = $this->tables_model->get_table_by($table_id);
        $data['users'] = $this->tables_model->get_users_in_table($table_id);
        $this->common->load_view('admin/tables/edit_table', $data);
    }

    public function load_tables_view()
    {
        $message = array('title', 'table_name', 'seats', 'available_seats', 'for_vegans', 'shift', 'description', 'image', 'list_of_users', 'name', 'floor', 'create_table', 'edit', 'delete', 'are_you_sure', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('tables', $message);
        $this->load->library('pagination');
        $config['base_url'] = base_url().'/admin/tables';
        $config['total_rows'] = $this->tables_model->get_num_of_tables();
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
        $tables = $this->tables_model->get_tables($config['per_page'], $data['page']);
        $data['tables'] = $tables;
        $this->common->load_view('admin/tables/tables', $data);
    }

    public function list_users_from_table($table_id)
    {
        echo json_encode($this->tables_model->get_users_in_table($table_id));
    }

    public function validation()
    {
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
        if ($request == 'store') return $this->tables_model->insert_table($table);
        else return $this->tables_model->update_table($table_id, $table);
    }

    public function delete_user_in_table($table_id, $user_id)
    {
        $res = $this->tables_model->cancel_seat_in_table_for_user($user_id, $table_id);
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