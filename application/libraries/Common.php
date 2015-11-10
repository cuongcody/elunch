<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common {

    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->helper('form');
    }

    public function authenticate()
    {
        if ($this->CI->session->userdata('logged_in') && $this->CI->session->userdata('site_lang')) return TRUE;
        else redirect('admin/login', 'refresh');
    }
    public function load_view($content_view, $data)
    {
        $this->CI->load->view('templates/header',$data);
        $this->CI->load->view('templates/sidebar-menu', $data);
        $this->CI->load->view('templates/top-nav', $data);
        $this->CI->load->view($content_view, $data);
        $this->CI->load->view('templates/footer');
    }

    public function set_language_for_server_api($language, $message_indexes)
    {
        $file_language = 'server_api/'.$language;
        $this->CI->lang->load($file_language, 'english');
        $msg_lang = $this->get_messages($message_indexes);
        $this->CI->lang->load('server_api/status_api', 'english');
        $status_lang = $this->get_messages(array('success', 'failure'));
        $msg_lang = array_merge($msg_lang, $status_lang);
        return $msg_lang;
    }

    public function set_language_and_data($language, $message_indexes)
    {
        $file_language = 'web_portal/'.$language;
        // Load session language
        $session_site_lang = $this->CI->session->userdata('site_lang');

        // Sidebar language
        $this->CI->lang->load('web_portal/sidebar', $session_site_lang);
        // Load message sidebar
        $messages_sidebar = $this->set_messages_for_sidebar();
        $this->CI->session->set_userdata('sidebar_lang', $messages_sidebar);
        // Load language file
        $this->CI->lang->load($file_language, $session_site_lang);
        //Load message
        $msg_lang = $this->get_messages($message_indexes);
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

    public function set_messages_for_sidebar()
    {
        return $this->get_messages(array(
            'title', 'welcome', 'manage', 'logout',
            'dishes', 'manage_dishes', 'add_dish',
            'categories', 'manage_categories', 'add_category',
            'tables', 'manage_tables', 'add_table', 'arrange_tables',
            'floors', 'manage_floors', 'add_floor',
            'shifts', 'manage_shifts', 'add_shift',
            'favourite_dishes', 'manage_favourite_dishes',
            'users', 'manage_users', 'add_user',
            'menus', 'manage_menus', 'add_menu',
            'meals', 'manage_meals', 'add_meal', 'tracking_meal',
            'announcement', 'manage_announcement', 'add_announcement',
            'comments', 'manage_comments', 'add_comment',
            'access_point', 'manage_access_point', 'add_access_point'));
    }

    public function return_notification($language, $message_lang, $status)
    {
        $message = $this->get_message($language, array($message_lang));
        if ($status == 1) $data['status'] = 'success';
        else $data['status'] = 'failure';
        $data['message'] = $message[$message_lang];
        $this->CI->session->set_flashdata('message', json_encode($data));
    }

    public function get_messages($message_indexs)
    {
        $msg_lang = array();
        foreach ($message_indexs as $message_index)
        {
            $msg_lang[$message_index] = $this->CI->lang->line($message_index);
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
        if (!$this->CI->upload->do_upload('img')){
            var_dump($this->CI->upload->display_errors());
            return FALSE;
        }
        $image_data =  $this->CI->upload->data();
        if (!empty($image_data))
        {
            $image_config = array(
                "source_image" => $image_data['full_path'],
                "new_image" => $image_data['file_path'],
                "maintain_ratio" => TRUE,
                "width" => 500,
                "height" => 500);
            $dim = (intval($image_data["image_width"]) / intval($image_data["image_height"])) - ($image_config['width'] / $image_config['height']);
            $image_config['master_dim'] = ($dim > 0)? "height" : "width";
            $this->CI->load->library("image_lib", $image_config);
            if (!$this->CI->image_lib->resize()) {var_dump($this->CI->resize->display_errors());return FALSE;}
            else chmod($image_data['full_path'], 0777);
            $this->CI->session->set_userdata('upload', $image_data);
            return TRUE;
        }
    }

    public function image_delete($dir)
    {
        if (file_exists(APPPATH. $dir)) return unlink(APPPATH. $dir);
        return FALSE;
    }

    public function date_format($date)
    {
        return strtotime($date);
    }

    public function get_message($language, $message)
    {
        $file_language = 'web_portal/'.$language;
        // Load session language
        $session_site_lang = $this->CI->session->userdata('site_lang');
        // Load language file
        $this->CI->lang->load($file_language, $session_site_lang);
        //Load message
        return $this->get_messages($message);
    }

    function is_url_exist($url)
    {
        $headers = get_headers($url);
        return stripos($headers[0],"200 OK") ? TRUE : FALSE;
    }

    /**
     * Sending Push Notification
     */
    public function send_notification($registatoin_ids, $message) {
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'content_available ' => TRUE,
            'priority' => 'high',
            'notification' => array('body' => 'You have notification.!', 'title' => 'eLunch', 'sound' => 'default', 'badge' => '1'),
            'data' => $message,
        );
        $headers = array(
            'Authorization: key=' . $this->CI->config->item('google_api_key'),
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) die('Curl failed: ' . curl_error($ch));
        // Close connection
        curl_close($ch);
        //echo $result;
    }

}
