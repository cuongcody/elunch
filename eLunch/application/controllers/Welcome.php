<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function index($lang = '')
    {
        if ($this->session->userdata('logged_in'))
        {
            redirect('admin/home', 'refresh');
        }
        else
        {
            redirect('admin/login', 'refresh');
        }
    }

}
