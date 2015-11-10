<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common {

    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->helper('form');
    }
    public function load_view($content_view, $data)
    {
        $this->CI->load->view('templates/header',$data);
        $this->CI->load->view('templates/sidebar-menu', $data);
        $this->CI->load->view('templates/top-nav', $data);
        $this->CI->load->view($content_view, $data);
        $this->CI->load->view('templates/footer');
    }

    public function set_language_and_data($language, $message)
    {
        // Load session language
        $session_site_lang = $this->CI->session->userdata('site_lang');

        // Sidebar language
        $this->CI->lang->load('sidebar', $session_site_lang);
        // Load message sidebar
        $message_sidebar = $this->set_message_for_sidebar();
        $this->CI->session->set_userdata('sidebar_lang', $message_sidebar);
        // Load language file
        $this->CI->lang->load($language, $session_site_lang);
        //Load message
        $msg_lang = $this->set_message($message);
        // Set values in session
        $this->CI->session->set_userdata($language.'_lang', $msg_lang);

        //Load session loggin
        $session_logged_in = $this->CI->session->userdata('logged_in');
        // Retrieve all session values
        $data = $this->CI->session->all_userdata();
        $data['first_name'] = $session_logged_in['first_name'];
        $data['last_name'] = $session_logged_in['last_name'];
        $data['avatar_content_file'] = $session_logged_in['avatar_content_file'];
        $data['title'] = $msg_lang['title'];
        return $data;
    }

    public function set_message_for_sidebar()
    {
        return $this->set_message(array(
            'title', 'welcome', 'manage', 'logout',
             'dishes', 'manage_dishes', 'add_dish',
              'categories', 'manage_categories', 'add_category',
               'tables', 'manage_tables', 'add_table',
                'favourite_dishes', 'manage_favourite_dishes',
                 'users', 'manage_users', 'add_user',
                  'menus', 'manage_menus', 'add_menu',
                  'meals', 'manage_meals', 'add_meal'));
    }

    public function set_message($message)
    {
        $msg_lang = array();
        foreach ($message as $value)
        {
            $msg_lang[$value] = $this->CI->lang->line($value);
        }
        return $msg_lang;
    }

    public function image_upload($dir)
    {
        $upload_dir = APPPATH. $dir;
        $config = array(
            'upload_path' => $upload_dir,
            'allowed_types' => 'gif|jpg|png',
            'max_size' => '100000');
        $this->CI->load->library('upload', $config);
        $this->CI->upload->initialize($config);
        if (!$this->CI->upload->do_upload('img')){
            $this->CI->form_validation->set_message('image_upload', $this->CI->upload->display_errors());
            return FALSE;
        }
        $image_data =  $this->CI->upload->data();
        if (!empty($image_data)){
            $config = array(
                "source_image" => chmod($image_data['full_path'], 0777),
                "new_image" => $upload_dir,
                "maintain_ratio" => true,
                "width" => '500',
                "height" => '500');
            $this->CI->load->library("image_lib", $config);
            $this->CI->image_lib->resize();
            $this->CI->session->set_userdata('upload', $image_data);
        return TRUE;
        }
    }

    public function date_format($date)
    {
        return strtotime($date);
    }

    public function get_message($language, $message)
    {
        // Load session language
        $session_site_lang = $this->CI->session->userdata('site_lang');
        // Load language file
        $this->CI->lang->load($language, $session_site_lang);
        //Load message
        return $this->set_message($message);
    }

}
