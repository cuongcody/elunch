<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('common');
    }
    public function index()
    {
        if ( $this->session->userdata('logged_in') && $this->session->userdata('site_lang'))
        {

            $this->load_home_view();
        }
       else
       {
         //If no session, redirect to login page
         redirect('admin/login', 'refresh');
       }
    }

    public function load_home_view()
    {
        $message = array('title');
        $data = $this->common->set_language_and_data('home', $message);
        $this->common->load_view('admin/home', $data);
    }

    function logout()
    {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        redirect('admin/login', 'refresh');
    }

}

/* End of file Login.php */
/* Location: ./application/controllers/admin/Login.php */