<?php
require(APPPATH.'controllers/Base_api.php');

class Admin_messages_api extends BaseApi {

    /**
     * Get all message from admin
     * url: http://localhost/messages/<user_id>
     */
    function messages_get($user_id)
    {
        $this->authenticate();
        $this->load->model('messages_model');
        $result = $this->messages_model->get_messages_of_user($user_id);
        $response = array();
        $messages = array();
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
                $message['created_at'] = $item->created_at;
                array_push($messages, $message);
            }
            $response['status'] = 'success';
            $response['message'] = 'Get all messages from admin successfully';
            $response['data'] = $messages;
        }
        else
        {
            $response['status'] = 'success';
            $response['message'] = "User doen't have announce from admin";
        }
        $this->response($response, 200);
    }

     /**
     * Get detail message from admin
     * url: http://localhost/message/<number_of_message_id>
     */
    function message_get($message_id)
    {
        $this->authenticate();
        $this->load->model('messages_model');
        list($result, $number_of_replies) = $this->messages_model->get_detail_message($message_id);
        $response = array();
        if ($result != NULL)
        {
            $data = array();
            $replies = array();
            $message = array();
            $message['id'] = (int)$result[0]->id;
            $message['title'] = $result[0]->title;
            $message['content'] = $result[0]->content;
            $message['meal_date'] = $result[0]->meal_date;
            $message['created_at'] = $result[0]->created_at;
            $message['updated_at'] = $result[0]->updated_at;
            $message['number_of_replies'] = $number_of_replies;
            foreach ($result as $item)
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
            $data['message'] = $message;
            $data['replies'] = $replies;
            $response['status'] = 'success';
            $response['message'] = 'Get detail messages from admin successfully';
            $response['data'] = $data;
        }
        else
        {
            $response['status'] = 'success';
            $response['message'] = "This message doesn't have reply";
        }
        $this->response($response, 200);
    }

    /**
     * Reply message from admin
     * url: http://localhost/message
     */
    function message_post()
    {
        $this->authenticate();
        // Check for required params
        $this->verify_required_params(array('user_id', 'content', 'message_id'));
        $user_id = $this->post('user_id');
        $content = $this->post('content');
        $message_id = $this->post('message_id');
        $response = array();
        $this->load->model('messages_model');
        $result = $this->messages_model->reply_admin_message($user_id, $message_id, $content);
        if ($result == TRUE)
        {
            $response['status'] = 'success';
            $response['message'] = 'Reply message from admin successfully';
        }
        else
        {
            $response['status'] = 'failure';
            $response['message'] = 'Reply message from admin fail';
        }
        $this->response($response, 200);
    }
}