<?php

class Comments_model extends CI_Model {

    function get_comments_of_user($user_id)
    {
        $this->db->select('comments.*,
            COUNT(reply_messages.id) AS number_of_replies, reply_messages.type_messages');
        $this->db->from('comments');
        $this->db->join('reply_messages', 'reply_messages.message_id = comments.id', 'left');
        $this->db->where('comments.user_id', $user_id);
        $this->db->group_by('comments.id');
        $query = $this->db->get();
        return $this->get_comments_messages($query->result());
    }

    function get_comments_messages($messages)
    {
        foreach ($messages as $key => $message)
        {
            if (!is_null($message->type_messages) && $message->type_messages != COMMENTS)
            {
                unset($messages[$key]);
            }
        }
        return $messages;
    }

    function get_detail_comment($comment_id)
    {
        $this->db->select('comments.*,
            reply_messages.id AS reply_id, reply_messages.type_messages, reply_messages.content AS reply_content, reply_messages.created_at AS reply_created_at, reply_messages.updated_at AS reply_updated_at,
            users.email, users.avatar_content_file ');
        $this->db->from('comments');
        $this->db->join('reply_messages', 'reply_messages.message_id = comments.id');
        $this->db->join('users', 'users.id = reply_messages.user_id');
        $this->db->where('comments.id', $comment_id);
        $this->db->where('reply_messages.type_messages', COMMENTS);
        $query = $this->db->get();
        return [$query->result(), $query->num_rows()];
    }

    function add_comment_of_user_for_dish($comment)
    {
        $result = "";
        if (is_null($comment['dish_id']) OR $this->is_exist_dish_in_db($comment['dish_id']))
        {
            $query = $this->db->insert('comments', $comment);
            $comment['id'] = $this->db->insert_id();
            $result = ($query)? [ADD_COMMENT_SUCCESSFULLY, $comment] : [ADD_COMMENT_FAIL, NULL];
        }
        else $result = [NO_EXIST_DISH_IN_DB, NULL];
        return $result;
    }

    function reply_comment($user_id, $comment_id, $content)
    {
        $data = array(
            'user_id' => $user_id,
            'message_id' => $comment_id,
            'content' => $content,
            'type_messages' => COMMENTS);
        return $this->db->insert('reply_messages', $data);
    }

    function edit_comment_of_user_for_dish($user_id, $comment_id, $comment)
    {
        $result = "";
        if ($this->is_comment_belongs_to_user($user_id, $comment_id))
        {
            $comment['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where('id', $comment_id);
            $query = $this->db->update('comments', $comment);
            $result = ($query) ? EDIT_COMMENT_SUCCESSFULLY : EDIT_COMMENT_FAIL;
        }
        else $result = COMMENT_NOT_BELONGS_TO_USER;
        return $result;
    }

    function delete_comment_of_user_for_dish($user_id, $comment_id)
    {
        $result ="";
        if ($this->is_exist_comment_in_db($comment_id) &&
         $this->is_comment_belongs_to_user($user_id, $comment_id))
        {
            $query = $this->db->delete('comments',array('id' => $comment_id));
            $result = ($query) ? DELETE_COMMENT_SUCCESSFULLY : DELETE_COMMENT_FAIL;
        }
        else $result = COMMENT_NOT_BELONGS_TO_USER;
        return $result;
    }

    function is_exist_dish_in_db($dish_id)
    {
        if (is_null($dish_id)) return FALSE;
        $query = $this->db->get_where('dishes', array('id' => $dish_id));
        $num_rows = $query->num_rows();
        return $num_rows > 0;
    }

    function is_exist_comment_in_db($comment_id)
    {
        $query = $this->db->get_where('comments', array('id' => $comment_id));
        $num_rows = $query->num_rows();
        return $num_rows > 0;
    }

    function is_comment_belongs_to_user($user_id, $comment_id)
    {
        $query = $this->db->get_where('comments', array(
            'id' => $comment_id,
            'user_id' => $user_id));
        $num_rows = $query->num_rows();
        return $num_rows > 0;
    }
}
