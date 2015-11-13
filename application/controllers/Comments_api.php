<?php
require(APPPATH.'controllers/Base_api.php');

class Comments_api extends Base_api {

    function __construct()
    {
        parent::__construct();
        $this->load->library('common');
        $this->load->model('comments_model');
    }

    /**
     * Get comments from user for dish
     * url: http://localhost/user/<number_of_user>/comments?to=yyyy-mm-dd&days=duration
     * Method: GET
     * @param       int  $user_id
     * @param       date('y-m-d')  $to
     * @param       int  $days
     * @return      json
     */
    function comments_of_user_get($user_id)
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('comments_api',
            array('get_comments_success', 'get_comments_failure', 'get_comments_not_valid'));
        $to = $this->input->get('to');
        $days = $this->input->get('days');
        $response = array();
        if (strtotime($to))
        {
            $date_to = (new DateTime($to))->format('Y-m-d');
            $date_from = (new DateTime($to))->sub(new DateInterval('P'.$days.'D'))->format('Y-m-d');
            $result = $this->comments_model->get_comments_of_user($user_id, $date_from, $date_to);
            $data = array();
            if ($result != NULL)
            {
                $comments = array();
                foreach ($result as $temp)
                {
                    $comment = array();
                    $comment['id'] = (int)$temp->id;
                    $comment['dish_id'] = (is_null($temp->dish_id)) ? NULL : (int)$temp->dish_id;
                    $comment['content'] = $temp->content;
                    $comment['title'] = $temp->title;
                    $comment['meal_date'] = $temp->meal_date;
                    $comment['number_of_replies'] = (int)$temp->number_of_replies;
                    $comment['number_of_have_read_replies'] = (int)$temp->count_replies_have_read;
                    $comment['read_flag'] = $temp->have_read;
                    $comment['created_at'] = $temp->created_at;
                    $comment['updated_at'] = $temp->updated_at;
                    $comment['user_id'] = (int)$temp->user_id;
                    $comment['email'] = $temp->email;
                    $comment['avatar_content_file'] = $temp->avatar_content_file;
                    array_push($comments, $comment);
                }
                $date_to = date('Y-m-d', strtotime($comments[sizeof($comments) - 1]['created_at']));
                $is_more_comments = ($this->comments_model->get_comments_of_user($user_id, NULL, $date_to) != NULL) ? TRUE : FALSE;
                $data['is_more_comments'] = $is_more_comments;
                $data['comments'] = $comments;
                $response['status'] = $messages_lang['success'];
                $response['message'] = $messages_lang['get_comments_success'];
                $response['data'] = $data;
            }
            else
            {
                $data['comments'] = NULL;
                $is_more_comments = ($this->comments_model->get_comments_of_user($user_id, NULL, $date_from) != NULL) ? TRUE : FALSE;
                $data['is_more_comments'] = $is_more_comments;
                $response['status'] = $messages_lang['success'];
                $response['message'] = $messages_lang['get_comments_failure'];
                $response['data'] = $data;
            }
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response['message'] = $messages_lang['get_comments_not_valid'];
        }
        $this->response($response, 200);
    }

    /**
     * Get detail comment from user
     * url: http://localhost/user/<user_id>/comment/<number_of_comment_id>
     * Method: GET
     * @param       int  $user_id
     * @param       int  $comment_id
     * @return      json
     */
    function comment_get($user_id, $comment_id)
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('comments_api',
            array('get_detail_comments_success', 'get_detail_comments_failure', 'get_comments_not_valid'));
        $response = array();
        $result = $this->comments_model->get_detail_comment_for_user($user_id, $comment_id);
        $data = array();
        if ($result != NULL)
        {
            $replies = array();
            if ($result->replies != NULL)
            {
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
                $date_to = date('Y-m-d', strtotime($replies[sizeof($replies) - 1]['created_at']));
            }
            $data['replies'] = $replies;
            $data['have_read_replies_comment'] = $result->have_read_replies_comment;
            $response['status'] = $messages_lang['success'];
            $response['message'] = $messages_lang['get_detail_comments_success'];
            $response['data'] = $data;
        }
        else
        {
            $response['status'] = $messages_lang['success'];
            $response['message'] = $messages_lang['get_detail_comments_failure'];
            $response['data'] = $data;
        }
        $this->response($response, 200);
    }

    /**
     * Add comment from user for meal date
     * url: http://localhost/comment
     * Method: POST
     * @param       int  $user_id
     * @param       string  $title
     * @param       string  $content
     * @param       date(y-m-d)  $meal_date
     * @return      json
     */
    function comment_post()
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('comments_api',
            array('add_comment_success', 'add_comment_failure', 'add_comment_not_valid'));
        $this->verify_required_params(array('user_id', 'title', 'content', 'meal_date'));
        $response = array();
        if (strtotime($this->post('meal_date')))
        {
            $comment = array();
            $comment['user_id'] = (int)$this->post('user_id');
            $comment['dish_id'] = ($this->post('dish_id') == NULL) ? $this->post('dish_id') : (int)$this->post('dish_id');
            $comment['title'] = $this->post('title');
            $comment['content'] = $this->post('content');
            $comment['meal_date'] = $this->post('meal_date');
            list($result, $comment) = $this->comments_model->insert_comment($comment);
            if ($result == TRUE)
            {
                $comment['replies'] = "";
                $comment['have_read_replies_comment'] = 0;
                $comment['created_at'] = date('Y-m-d H:m:s');
                $response['status'] = $messages_lang['success'];
                $response['message'] = $messages_lang['add_comment_success'];
                $response['data'] = $comment;
            }
            else
            {
                $response['status'] = $messages_lang['failure'];
                $response['message'] = $messages_lang['add_comment_failure'];
            }
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response['message'] = $messages_lang['add_comment_valid'];
        }
        $this->response($response, 200);
    }

    /**
     * Reply comment from user
     * url: http://localhost/reply
     * Method: POST
     * @param       int  $user_id
     * @param       int  $comment_id
     * @param       string  $content
     * @return      json
     */
    function reply_post()
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('comments_api',
            array('reply_comment_success', 'reply_comment_failure'));
        // Check for required params
        $this->verify_required_params(array('user_id', 'content', 'comment_id'));
        $user_id = $this->post('user_id');
        $content = $this->post('content');
        $comment_id = $this->post('comment_id');
        $response = array();
        list($result, $reply_id) = $this->comments_model->reply_comment($user_id, $comment_id, $content);
        if ($result == TRUE)
        {
            $data = array();
            $data['id'] = (int)$reply_id;
            $data['content'] = $content;
            $data['created_at'] = date('Y-m-d H:m:s');
            $response['status'] = $messages_lang['success'];
            $response['message'] = $messages_lang['reply_comment_success'];
            $response['data'] = $data;
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response['message'] = $messages_lang['reply_comment_success'];
        }
        $this->response($response, 200);
    }

    /**
     * Update all comments of user have read
     * url: http://localhost/read_comments
     * Method: PUT
     * @param       int  $user_id
     * @param       int  $comment_id
     * @return      json
     */
    function read_comment_put()
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('comments_api',
            array('read_comment_success', 'read_comment_failure'));
        $this->verify_required_params(array('user_id', 'comment_id'));
        $user_id = $this->put('user_id');
        $comment_id = $this->put('comment_id');
        $response = array();
        $result = $this->comments_model->have_read_comment($user_id, $comment_id);
        if ($result == TRUE)
        {
            $response['status'] = $messages_lang['success'];
            $response['message'] = $messages_lang['read_comment_success'];
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response['message'] = $messages_lang['read_comment_failure'];
        }
        $this->response($response, 200);
    }

    /**
     * Update all replies of comment from user have read
     * url: http://localhost/read_replies_comments
     * Method: PUT
     * @param       int  $user_id
     * @param       int  $comment_id
     * @param       int  $reply_ids
     * @return      json
     */
    function read_replies_comment_put()
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('comments_api',
            array('read_replies_comment_success', 'read_replies_comment_failure'));
        $this->verify_required_params(array('user_id', 'comment_id', 'reply_ids'));
        $user_id = $this->put('user_id');
        $comment_id = $this->put('comment_id');
        $reply_ids = $this->put('reply_ids');
        $response = array();
        $result = $this->comments_model->have_read_replies_comment($user_id, $comment_id, $reply_ids);
        if ($result == TRUE)
        {
            $response['status'] = $messages_lang['success'];
            $response['message'] = $messages_lang['read_replies_comment_success'];
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response['message'] = $messages_lang['read_replies_comment_failure'];
        }
        $this->response($response, 200);
    }

}
