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
        $this->load_users_view();
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
                if ($this->add_users()) $this->common->return_notification('new_user', 'add_success', 1);
                else $this->common->return_notification('new_user', 'add_failure', 0);
                //redirect('admin/users','refresh');
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

    public function add_users()
    {
        $users = array(
            array('email' =>'Theresa@enclave.vn', 'first_name' => 'Theresa', 'last_name' => 'Thao', 'floor' => 1, 'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Theresa.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Theresa.JPG')),

            array('email' =>'Sarah@enclave.vn', 'first_name' => 'Sarah', 'last_name' => 'Suong', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Sarah.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Sarah.JPG')),

            array('email' =>'Charles@enclave.vn', 'first_name' => 'Charles', 'last_name' => 'Hung', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Charles.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Charles.JPG')),

            array('email' =>'Tracy@enclave.vn', 'first_name' => 'Tracy', 'last_name' => 'Thu', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Tracy.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Tracy.JPG')),

            array('email' =>'Harris@enclave.vn', 'first_name' => 'Harris', 'last_name' => 'Hiep', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Harris.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Harris.JPG')),

            array('email' =>'Peter@enclave.vn', 'first_name' => 'Peter', 'last_name' => 'Phong', 'floor' => 1, 'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Peter.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Peter.JPG')),

            array('email' =>'Perla@enclave.vn', 'first_name' => 'Perla', 'last_name' => 'Phuong', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Perla.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Perla.JPG')),

            array('email' =>'Prescott@enclave.vn', 'first_name' => 'Prescott', 'last_name' => 'Phuong', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Prescott.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Prescott.JPG')),

            array('email' =>'Quinn@enclave.vn', 'first_name' => 'Quinn', 'last_name' => 'Quoc', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Quinn.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Quinn.JPG')),

            array('email' =>'Smith@enclave.vn', 'first_name' => 'Smith', 'last_name' => 'Sinh', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Smith.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Smith.JPG')),

            array('email' =>'Tywin@enclave.vn', 'first_name' => 'Tywin', 'last_name' => 'Tam', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Tywin.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Tywin.JPG')),

            array('email' =>'Vania@enclave.vn', 'first_name' => 'Vania', 'last_name' => 'Van', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Vania.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Vania.JPG')),

            array('email' =>'Nadie@enclave.vn', 'first_name' => 'Nadie', 'last_name' => 'Nga', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Nadie.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Nadie.JPG')),

            array('email' =>'Thurstan@enclave.vn', 'first_name' => 'Thurstan', 'last_name' => 'Thanh', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Thurstan.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Thurstan.JPG')),
            array('email' =>'Quinn@enclave.vn', 'first_name' => 'Quinn', 'last_name' => 'Quoc', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Quinn.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Quinn.JPG')),

            array('email' =>'Tobin@enclave.vn', 'first_name' => 'Tobin', 'last_name' => 'Thanh', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Tobin.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Tobin.JPG')),

            array('email' =>'Tammy@enclave.vn', 'first_name' => 'Tammy', 'last_name' => 'Tam', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Tammy.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Tammy.JPG')),

            array('email' =>'Harva@enclave.vn', 'first_name' => 'Harva', 'last_name' => 'Hanh', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Harva.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Harva.JPG')),

            array('email' =>'Timon@enclave.vn', 'first_name' => 'Timon', 'last_name' => 'Thuan', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Timon.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Timon.JPG')),
            array('email' =>'Tansy@enclave.vn', 'first_name' => 'Tansy', 'last_name' => 'Tien', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Tansy.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Tansy.JPG')),

            array('email' =>'Tory@enclave.vn', 'first_name' => 'Tory', 'last_name' => 'Tien', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Tory.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Tory.JPG')),

            array('email' =>'Timothy@enclave.vn', 'first_name' => 'Timothy', 'last_name' => 'Toan', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Timothy.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Timothy.JPG')),

            array('email' =>'Kathy@enclave.vn', 'first_name' => 'Kathy', 'last_name' => 'Quy', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Kathy.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Kathy.JPG')),

            array('email' =>'Tunner@enclave.vn', 'first_name' => 'Tunner', 'last_name' => 'Tung', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Tunner.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Tunner.JPG')),
            array('email' =>'Terry@enclave.vn', 'first_name' => 'Terry', 'last_name' => 'Thanh', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Terry.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Terry.JPG')),

            array('email' =>'Hank@enclave.vn', 'first_name' => 'Hank', 'last_name' => 'Huy', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Hank.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Hank.JPG')),

            array('email' =>'Talon@enclave.vn', 'first_name' => 'Talon', 'last_name' => 'Thanh', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Talon.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Talon.JPG')),

            array('email' =>'Duke@enclave.vn', 'first_name' => 'Duke', 'last_name' => 'Duc', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Duke.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Duke.JPG')),

            array('email' =>'Chloe@enclave.vn', 'first_name' => 'Chloe', 'last_name' => 'Nga', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Chloe.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Chloe.JPG')),

            array('email' =>'Lyn@enclave.vn', 'first_name' => 'Lyn', 'last_name' => 'Lieu', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Lyn.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Lyn.JPG')),

            array('email' =>'Hawk@enclave.vn', 'first_name' => 'Hawk', 'last_name' => 'Hieu', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Hawk.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Hawk.JPG')),

            array('email' =>'Audrey@enclave.vn', 'first_name' => 'Audrey', 'last_name' => 'An', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Audrey.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Audrey.JPG')),

            array('email' =>'Perry@enclave.vn', 'first_name' => 'Perry', 'last_name' => 'Phong', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Perry.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Perry.JPG')),
            array('email' =>'Nolan@enclave.vn', 'first_name' => 'Nolan', 'last_name' => 'Nhut', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Nolan.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Nolan.JPG')),

            array('email' =>'Jane@enclave.vn', 'first_name' => 'Jane', 'last_name' => 'Trinh', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Jane.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Jane.JPG')),

            array('email' =>'Tiana@enclave.vn', 'first_name' => 'Tiana', 'last_name' => 'Trinh', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Tiana.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Tiana.JPG')),

            array('email' =>'Karl@enclave.vn', 'first_name' => 'Karl', 'last_name' => 'Kien', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Karl.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Karl.JPG')),

            array('email' =>'Justin@enclave.vn', 'first_name' => 'Justin', 'last_name' => 'Huy', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Justin.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Justin.JPG')),

            array('email' =>'Teddy@enclave.vn', 'first_name' => 'Teddy', 'last_name' => 'Tuyen', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Teddy.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Teddy.JPG')),

            array('email' =>'Hendrix@enclave.vn', 'first_name' => 'Hendrix', 'last_name' => 'Hung', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Hendrix.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Hendrix.JPG')),

            array('email' =>'Thierry@enclave.vn', 'first_name' => 'Thierry', 'last_name' => 'Tung', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Thierry.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Thierry.JPG')),

            array('email' =>'Darian@enclave.vn', 'first_name' => 'Darian', 'last_name' => 'Dai', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Darian.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Darian.JPG')),

            array('email' =>'Hilary@enclave.vn', 'first_name' => 'Hilary', 'last_name' => 'Hieu', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Hilary.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Hilary.JPG')),
            array('email' =>'Vinson@enclave.vn', 'first_name' => 'Vinson', 'last_name' => 'Viet', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Vinson.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Vinson.JPG')),

            array('email' =>'Chuck@enclave.vn', 'first_name' => 'Chuck', 'last_name' => 'Chuc', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Chuck.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Chuck.JPG')),

            array('email' =>'Luke@enclave.vn', 'first_name' => 'Luke', 'last_name' => 'Luu', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Luke.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Luke.JPG')),

            array('email' =>'Natalie@enclave.vn', 'first_name' => 'Natalie', 'last_name' => 'Huong', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Natalie.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Natalie.JPG')),

            array('email' =>'Jolie@enclave.vn', 'first_name' => 'Jolie', 'last_name' => 'Hieu', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Jolie.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Jolie.JPG')),

            array('email' =>'Tristan@enclave.vn', 'first_name' => 'Tristan', 'last_name' => 'Trieu', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Tristan.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Tristan.JPG')),

            array('email' =>'Timmy@enclave.vn', 'first_name' => 'Timmy', 'last_name' => 'Tien', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Timmy.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Timmy.JPG')),

            array('email' =>'Nancy@enclave.vn', 'first_name' => 'Nancy', 'last_name' => 'Nhung', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Nancy.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Nancy.JPG')),

            array('email' =>'Vin@enclave.vn', 'first_name' => 'Vin', 'last_name' => 'Vu', 'floor' => 1,'shift' => 1,
                'password' => 'enclaveit@123', 'what_taste' => '', 'want_vegan_meal' => 0,
                'role' => 0, 'avatar_file_name' => 'Vin.JPG', 'avatar_content_file' => base_url('assets/images/users/'.'Vin.JPG')),
            );
        foreach ($users as $key => $value) {
            list($check_register, $result) = $this->users_model->insert_user($value);
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
            'avatar_content_file' => base_url('assets/images/users/'.$image_data['file_name']),
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
            'avatar_content_file' => base_url('assets/images/users/'.$image_data['file_name']),
            'want_vegan_meal' => $want_vegan_meal,
            'floor' => $this->input->post('floor')
            ));
        return $can_update;
    }

    public function delete($user_id)
    {
        $this->common->authenticate();
        $message = $this->common->get_message('delete_user', array('delete_success', 'delete_failure'));
        if ($this->users_model->delete_user($user_id))
        {
            $avatar_file_name = $this->input->post('avatar_file_name');
            $this->common->image_delete('../assets/images/users/'. $avatar_file_name);
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
        $data['floors'] = $this->floors_model->get_all_floors();
        $this->load->model('shifts_model');
        $data['shifts'] = $this->shifts_model->get_all_shifts();
        $this->common->load_view('admin/users/new_user', $data);
    }

    public function load_edit_user_view($user_id)
    {
        $user = $this->users_model->get_user_by('id', $user_id);
        $image_data['file_name'] = $user->avatar_file_name;
        $this->session->set_userdata('upload', $image_data);
        $message = array('title', 'manage_users', 'email', 'password', 'confirm_password',
         'what_taste', 'edit', 'want_vegan_meal', 'first_name', 'last_name', 'floor', 'shift',
         'admin', 'user', 'role', 'image_upload', 'avatar', 'change_password', 'change_shift', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('edit_user', $message);
        $this->load->model('floors_model');
        $floors = $this->floors_model->get_all_floors();
        $data['floors'] = $floors;
        $this->load->model('shifts_model');
        $data['shifts'] = $this->shifts_model->get_all_shifts();
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
        $users = $this->users_model->get_all_users($config['per_page'],  ($data['page'] == 0 ? $data['page'] : ($data['page'] - 1)) * $config['per_page']);
        $data['users'] = $users;
        $this->common->load_view('admin/users/users', $data);
    }

    public function check_image_upload()
    {
        if (empty($this->session->userdata('upload')))
        {
            if ($_FILES['img']['size'] != 0)
            {
                if (!$this->common->image_upload('../assets/images/users'))
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
            if (!$this->common->image_upload('../assets/images/users'))
            {
                $this->lang->load('web_portal/validation', $this->session->userdata('site_lang'));
                $this->form_validation->set_message('check_image_upload', $this->lang->line('error_upload'));
                return FALSE;
            }
            else
            {
                $this->common->image_delete('../assets/images/users/'.$old_image);
                return TRUE;
            }
        }
        else return TRUE;
    }

    public function exist_email($email)
    {
        if ($this->users_model->is_user_exists($email))
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

    public function upload_image()
    {
        $this->load->helper('form');
        $data = array();
        $data['title'] = 'Multiple file upload';

        if($this->input->post())
        {
            if (!$this->common->image_upload('../assets/images/users'))
                {
                    $this->lang->load('web_portal/validation', $this->session->userdata('site_lang'));
                    $this->form_validation->set_message('check_image_upload', $this->lang->line('error_upload'));
                    return FALSE;
                }
        }
        $this->load->view('upload_form', $data);

    }

}