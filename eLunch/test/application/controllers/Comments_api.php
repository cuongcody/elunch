<?php
require(APPPATH.'controllers/Base_api.php');

class Comments_api extends BaseApi {

    /**
     * Get comments from user for dish
     * url: http://localhost/user/<number_of_user>/comments
     */
    function comments_of_user_get($user_id)
    {
        $this->authenticate();
        $comments = array();
        $response = array();
        $this->load->model('comments_model');
        $result = $this->comments_model->get_comments_of_user($user_id);
        if ($result != NULL)
        {
            $response['status'] = 'success';
            $response['message'] = 'Get comments of user successfully';
            foreach ($result as $temp)
            {
                $comment = array();
                $comment['id'] = (int)$temp->id;
                $comment['dish_id'] = (is_null($temp->dish_id)) ? NULL : (int)$temp->dish_id;
                $comment['content'] = $temp->content;
                $comment['title'] = $temp->title;
                $comment['meal_date'] = $temp->meal_date;
                $comment['number_of_replies'] = (int)$temp->number_of_replies;
                $comment['created_at'] = $temp->created_at;
                $comment['updated_at'] = $temp->updated_at;
                array_push($comments, $comment);
            }
            $response['data'] = $comments;
        }
        else
        {
            $response['status'] = 'success';
            $response['message'] = "User doesn't have comment";
        }
        $this->response($response, 200);
    }

    /**
     * Get detail comment from user
     * url: http://localhost/comment/<number_of_comment_id>
     */
    function comment_get($comment_id)
    {
        $this->authenticate();
        $response = array();
        $this->load->model('comments_model');
        list($result, $number_of_replies) = $this->comments_model->get_detail_comment($comment_id);
        if ($result != NULL)
        {
            $data = array();
            $replies = array();
            $comment = array();
            $comment['id'] = (int)$result[0]->id;
            $comment['title'] = $result[0]->title;
            $comment['content'] = $result[0]->content;
            $comment['meal_date'] = $result[0]->meal_date;
            $comment['created_at'] = $result[0]->created_at;
            $comment['updated_at'] = $result[0]->updated_at;
            $comment['number_of_replies'] = $number_of_replies;
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
            $data['comment'] = $comment;
            $data['replies'] = $replies;
            $response['status'] = 'success';
            $response['message'] = 'Get comments of user successfully';
            $response['data'] = $data;
        }
        else
        {
            $response['status'] = 'success';
            $response['message'] = "This comment doesn't have reply";
        }
        $this->response($response, 200);
    }

    /**
     * Add comment from user for meal date
     * url: http://localhost/comment
     */
    function comment_post()
    {
        $this->authenticate();
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
            $this->load->model('comments_model');
            list($res, $comment) = $this->comments_model->add_comment_of_user_for_dish($comment);
            switch ($res)
            {
                case ADD_COMMENT_SUCCESSFULLY:
                    $response['status'] = 'success';
                    $response['message'] = 'You add comment successfully';
                    $response['data'] = $comment;
                    break;
                case ADD_COMMENT_FAIL:
                    $response['status'] = 'failure';
                    $response['message'] = 'An error occurred while comment. You cannot comment for this dish';
                    break;
                case NO_EXIST_DISH_IN_DB:
                    $response['status'] = 'failure';
                    $response['message'] = 'This dish have not existed in system';
                    break;
            }
        }
        else
        {
            $response['status'] = 'failure';
            $response['message'] = 'Your variable meal_date not valid';
        }
        $this->response($response, 200);
    }

    /**
     * Reply comment from user
     * url: http://localhost/reply_comment
     */
    function reply_post()
    {
        $this->authenticate();
        // Check for required params
        $this->verify_required_params(array('user_id', 'content', 'comment_id'));
        $user_id = $this->post('user_id');
        $content = $this->post('content');
        $comment_id = $this->post('comment_id');
        $response = array();
        $this->load->model('comments_model');
        $result = $this->comments_model->reply_comment($user_id, $comment_id, $content);
        if ($result == TRUE)
        {
            $response['status'] = 'success';
            $response['message'] = 'Reply comment successfully';
        }
        else
        {
            $response['status'] = 'failure';
            $response['message'] = 'Reply comment fail';
        }
        $this->response($response, 200);
    }

    /**
     * Edit comment from user
     * url: http://localhost/comment
     */
    function comment_put()
    {
        $this->authenticate();
        $comment = array();
        $user_id = $this->put('user_id');
        $comment_id = $this->put('comment_id');
        $comment['title'] = $this->put('title');
        $comment['content'] = $this->put('content');
        $this->verify_required_params(array('user_id', 'title', 'content', 'comment_id'));
        $this->load->model('comments_model');
        $res = $this->comments_model->edit_comment_of_user_for_dish($user_id, $comment_id, $comment);
        $response = array();
        switch ($res)
        {
            case EDIT_COMMENT_SUCCESSFULLY:
                $response['status'] = 'success';
                $response['message'] = 'You edit comment successfully';
                break;
            case EDIT_COMMENT_FAIL:
                $response['status'] = 'failure';
                $response['message'] = 'An error occurred while comment. You cannot edit comment for this dish';
                break;
            case COMMENT_NOT_BELONGS_TO_USER:
                $response['status'] = 'failure';
                $response['message'] = 'Edit comment fail. You cannot edit comment of others';
                break;
        }
        $this->response($response, 200);
    }

    /**
     * Delete comment from user
     * url: http://localhost/comment?user_id=<number_user_id>&comment_id=<number_of_comment_id>
     */
    function comment_delete()
    {
        $this->authenticate();
        $user_id = $this->input->get('user_id');
        $comment_id = $this->input->get('comment_id');
        if (!is_numeric($user_id) OR !is_numeric($comment_id))
        {
            $response['status'] = 'failure';
            $response['message'] = "Your variable 'user_id' or 'comment_id' not vaild";
        }
        else
        {
            $this->load->model('comments_model');
            $res = $this->comments_model->delete_comment_of_user_for_dish($user_id, $comment_id);
            $response = array();
            switch ($res)
            {
                case DELETE_COMMENT_SUCCESSFULLY:
                    $response['status'] = 'success';
                    $response['message'] = 'You delete comment successfully';
                    break;
                case DELETE_COMMENT_FAIL:
                    $response['status'] = 'failure';
                    $response['message'] = 'An error occurred while comment. You cannot delete comment for this dish';
                    break;
                case COMMENT_NOT_BELONGS_TO_USER:
                    $response['status'] = 'failure';
                    $response['message'] = 'Delete comment fail. Comment do not exists in system or you cannot delete comment of others';
                    break;
            }
        }
        $this->response($response, 200);
    }
}
