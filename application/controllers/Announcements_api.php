<?php
require(APPPATH.'controllers/Base_api.php');

class Announcements_api extends Base_api {

    function __construct()
    {
        parent::__construct();
        $this->load->library('common');
        $this->load->model('announcements_model');
    }

    /**
     * Get all announcements
     * url: http://localhost/user/<user_id>/announcements?to=yyyy-mm-dd&days=duration
     * Method: GET
     * @param       int  $user_id
     * @param       date(Y-m-d)  $to
     * @param       int  $days
     * @return      json
     */
    function announcements_get($user_id)
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('announcements_api',
            array('get_announcements_success', 'get_announcements_failure', 'get_announcements_not_valid'));
        $to = $this->input->get('to');
        $days = $this->input->get('days');
        if (strtotime($to))
        {
            $date_to = (new DateTime($to))->format('Y-m-d');
            $date_from = (new DateTime($to))->sub(new DateInterval('P'.$days.'D'))->format('Y-m-d');
            $result = $this->announcements_model->get_announcements_for_user($user_id, $date_from, $date_to);
            $response = array();
            $messages = array();
            $data = array();
            if ($result != NULL)
            {
                foreach ($result as $item)
                {
                    $message = array();
                    $message['id'] = (int)$item->id;
                    $message['title'] = $item->title;
                    $message['content'] = $item->content;
                    $message['meal_date'] = $item->meal_date;
                    $message['number_of_replies'] = (int)$item->number_of_replies;
                    $message['number_of_have_read_replies'] = (int)$item->count_replies_have_read;
                    $message['read_flag'] = $item->have_read;
                    $message['created_at'] = $item->created_at;
                    $message['user_id'] = (int)$item->user_id;
                    $message['email'] = $item->email;
                    $message['avatar_content_file'] = $item->avatar_content_file;
                    array_push($messages, $message);
                }
                $date_to = date('Y-m-d', strtotime($messages[sizeof($messages) - 1]['created_at']));
                $is_more_announcements = ($this->announcements_model->get_announcements_for_user($user_id, NULL, $date_to) != NULL) ? TRUE : FALSE;
                $data['is_more_announcements'] = $is_more_announcements;
                $data['messages'] = $messages;
                $response['status'] = $messages_lang['success'];
                $response['message'] = $messages_lang['get_announcements_success'];
                $response['data'] = $data;
            }
            else
            {
                $is_more_announcements = ($this->announcements_model->get_announcements_for_user($user_id, NULL, $date_from) != NULL) ? TRUE : FALSE;
                $data['is_more_announcements'] = $is_more_announcements;
                $data['messages'] = NULL;
                $response['status'] = $messages_lang['success'];
                $response['message'] = $messages_lang['get_announcements_failure'];
                $response['data'] = $data;
            }
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response['message'] = $messages_lang['get_announcements_not_valid'];
        }
        $this->response($response, 200);
    }

    /**
     * Get detail message from admin
     * url: http://localhost/user/<user_id>/announcement/<announcement_id>
     * Method: GET
     * @param       int  $user_id
     * @param       int  $announcement_id
     * @return      json
     */
    function announcement_get($user_id, $announcement_id)
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('announcements_api',
            array('get_detail_announcement_for_user_success', 'get_detail_announcement_for_user_failure', 'get_announcements_not_valid'));
        $response = array();
        $data = array();
        $result = $this->announcements_model->get_detail_announcement_for_user($user_id, $announcement_id);
        if ($result != NULL)
        {
            $replies = array();
            foreach ($result->replies as $item)
            {
                $reply = array();
                $reply['id'] = (int)$item->reply_id;
                $reply['content'] = $item->reply_content;
                $reply['email'] = $item->email;
                $reply['avatar_content_file'] = $item->avatar_content_file;
                $reply['created_at'] = $item->reply_created_at;
                $reply['updated_at'] = $item->reply_updated_at;
                array_push($replies, $reply);
            }
            $data['replies'] = $replies;
            $data['have_read_replies_announcement'] = $result->have_read_replies_announcement;
            $response['status'] = $messages_lang['success'];
            $response['message'] = $messages_lang['get_detail_announcement_for_user_success'];
            $response['data'] = $data;
        }
        else
        {
            $response['status'] = $messages_lang['success'];
            $response['message'] = $messages_lang['get_detail_announcement_for_user_failure'];
            $response['data'] = $data;
        }
        $this->response($response, 200);
    }

    /**
     * Reply message from admin
     * url: http://localhost/announcement
     * Method: POST
     * @param       int  $user_id
     * @param       int  $announcement_id
     * @param       string  $content
     * @return      json
     */
    function announcement_post()
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('announcements_api',
            array('reply_success', 'reply_failure'));
        // Check for required params
        $this->verify_required_params(array('user_id', 'content', 'announcement_id'));
        $user_id = $this->post('user_id');
        $content = $this->post('content');
        $announcement_id = $this->post('announcement_id');
        $response = array();
        list($result, $reply_id) = $this->announcements_model->reply_announcement($user_id, $announcement_id, $content);
        if ($result)
        {
            $data = array();
            $data['id'] = (int)$reply_id;
            $data['content'] = $content;
            $data['created_at'] = date('Y-m-d H:m:s');
            $response['status'] = $messages_lang['success'];
            $response['message'] = $messages_lang['reply_success'];
            $response['data'] = $data;
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response['message'] = $messages_lang['reply_failure'];
        }
        $this->response($response, 200);
    }

    /**
     * Update all announcement of user have read
     * url: http://localhost/read_announcement
     * Method: PUT
     * @param       int  $user_id
     * @param       int  $announcement_id
     * @return      json
     */
    function read_announcement_put()
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('announcements_api',
            array('read_announcement_success', 'read_announcement_failure'));
        $this->verify_required_params(array('user_id', 'announcement_id'));
        $user_id = $this->put('user_id');
        $announcement_id = $this->put('announcement_id');
        $response = array();
        $result = $this->announcements_model->have_read_announcement($user_id, $announcement_id);
        if ($result == TRUE)
        {
            $response['status'] = $messages_lang['success'];
            $response['message'] = $messages_lang['read_announcement_success'];
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response['message'] = $messages_lang['read_announcement_failure'];
        }
        $this->response($response, 200);
    }

    /**
     * Update all replies of announcement of user have read
     * url: http://localhost/read_replies_announcement
     * Method: PUT
     * @param       int  $user_id
     * @param       int  $announcement_id
     * @param       array  $reply_ids
     * @return      json
     */
    function read_replies_announcement_put()
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('announcements_api',
            array('read_replies_announcement_success', 'read_replies_announcement_failure'));
        $this->verify_required_params(array('user_id', 'announcement_id', 'reply_ids'));
        $user_id = $this->put('user_id');
        $announcement_id = $this->put('announcement_id');
        $reply_ids = $this->put('reply_ids');
        $response = array();
        $result = $this->announcements_model->have_read_replies_announcement($user_id, $announcement_id, $reply_ids);
        if ($result == TRUE)
        {
            $response['status'] = $messages_lang['success'];
            $response['message'] = $messages_lang['read_replies_announcement_success'];
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response['message'] = $messages_lang['read_replies_announcement_failure'];
        }
        $this->response($response, 200);
    }
}