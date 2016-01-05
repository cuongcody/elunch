<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access_point extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('common');
        $this->load->model('access_point_model');
    }

    public function index()
    {
        $this->common->authenticate();
        $this->load_access_point_view();
    }

    public function add()
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->validation();
            if ($this->form_validation->run() == FALSE)
            {
               $this->load_new_access_point_view();
            }
            else
            {
                if ($this->store_access_point()) $this->common->return_notification('new_access_point', 'add_success', 1);
                else $this->common->return_notification('new_access_point', 'add_failure', 0);
                redirect('admin/access_point','refresh');
            }
        }
        else
        {
            $this->load_new_access_point_view();
        }
    }

    public function edit($access_point_id)
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->validation();
            if ($this->form_validation->run() == FALSE)
            {
               $this->load_edit_access_point_view($access_point_id);
            }
            else
            {
                if ($this->edit_access_point($access_point_id)) $this->common->return_notification('edit_access_point', 'edit_success', 1);
                else $this->common->return_notification('edit_access_point', 'edit_failure', 0);
                redirect('admin/access_point','refresh');
            }
        }
        else
        {
            $this->load_edit_access_point_view($access_point_id);
        }
    }

    public function delete($access_point_id)
    {
        $this->common->authenticate();
        $message = $this->common->get_message('delete_access_point', array('delete_success', 'delete_failure'));
        if ($this->access_point_model->delete_access_point($access_point_id))
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

    public function push_notification()
    {
        $this->common->authenticate();
        $message = $this->common->get_message('push_access_point', array('push_success', 'push_failure'));
        if ($this->access_point_model->push_notification_change_access_point())
        {
            $data = array(
                'status' => 'success',
                'message' => $message['push_success']);
        }
        else
        {
            $data = array(
                'status' => 'failure',
                'message' => $message['push_failure']);
        }
        echo json_encode($data);
    }

    public function load_access_point_view()
    {
        $message = array('title', 'bssid', 'ssid', 'create_access_point', 'push_notification', 'edit', 'delete', 'selected', 'are_you_sure', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('access_point', $message);
        $access_point = Access_point_model::get_all_access_point();
        $data['access_point'] = $access_point;
        $this->common->load_view('admin/access_point/access_point', $data);
    }

    public function validation()
    {
        $this->config->set_item('language', $this->session->userdata('site_lang'));
        $this->load->helper('security');
        $this->load->library('form_validation');
        //validation rules
        $this->form_validation->set_rules('ssid', 'lang:ssid', 'trim|required|xss_clean');
        $this->form_validation->set_rules('bssid', 'lang:bssid', 'trim|required|xss_clean');
    }

    public function load_new_access_point_view()
    {
        $message = array('title', 'bssid', 'selected', 'ssid', 'save');
        $data = $this->common->set_language_and_data('new_access_point', $message);
        $this->common->load_view('admin/access_point/new_access_point', $data);
    }

    public function load_edit_access_point_view($access_point_id)
    {
        $message = array('title', 'bssid', 'ssid', 'selected', 'manage_access_point', 'edit');
        $data = $this->common->set_language_and_data('edit_access_point', $message);
        $data['access_point_item'] = Access_point_model::get_access_point_by_id($access_point_id);
        $this->common->load_view('admin/access_point/edit_access_point', $data);
    }

    public function store_access_point()
    {
        $selected = (!empty($this->input->post('selected'))) ? SELECTED : NO_SELECT;
        $ssid = $this->input->post('ssid');
        $bssid = $this->input->post('bssid');
        return $this->access_point_model->insert_access_point($ssid, $bssid, $selected);
    }

    public function edit_access_point($access_point_id)
    {
        $selected = (!empty($this->input->post('selected'))) ? SELECTED : NO_SELECT;
        $bssid = $this->input->post('bssid');
        $ssid = $this->input->post('ssid');
        return $this->access_point_model->update_access_point($access_point_id, $ssid, $bssid, $selected);
    }

}
