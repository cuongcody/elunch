<?php

class Comments_model extends CI_Model {

    private static $db;

    function __construct() {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    /**
     * Get comments for user
     *
     * @param       int  $user_id
     * @param       date(Y-m-d)  $start_time
     * @param       date(Y-m-d)  $end_time
     * @return      array
     */
    static function get_comments_of_user($user_id, $start_time = NULL, $end_time = NULL)
    {
        if (is_null($start_time) && is_null($end_time))
        {
            $query = self::$db->query('
                SELECT comments.*,users.id AS user_id, users.read_comments, users.read_replies_comments,
                users.email, users.avatar_content_file,
                SUM(reply_messages.id AND reply_messages.type_messages = ? ) AS number_of_replies
                FROM comments
                INNER JOIN users ON comments.user_id = users.id
                LEFT JOIN reply_messages ON reply_messages.message_id = comments.id
                WHERE comments.user_id = ?
                GROUP BY comments.id
                ORDER BY created_at DESC', array(COMMENTS, (int)$user_id));
        }
        elseif ((!is_null($start_time) && !is_null($end_time)))
        {
            $query = self::$db->query('
                SELECT comments.*, users.id AS user_id, users.read_comments, users.read_replies_comments,
                users.email, users.avatar_content_file,
                SUM(reply_messages.id AND reply_messages.type_messages = ? ) AS number_of_replies
                FROM comments
                INNER JOIN users ON comments.user_id = users.id
                LEFT JOIN reply_messages ON reply_messages.message_id = comments.id
                WHERE comments.user_id = ?
                AND DATE_FORMAT(comments.created_at,"%Y-%m-%d") >= ?
                AND DATE_FORMAT(comments.created_at,"%Y-%m-%d") <= ?
                GROUP BY comments.id
                ORDER BY created_at DESC', array(COMMENTS, (int)$user_id, $start_time, $end_time));
        }
        elseif (!is_null($end_time))
        {
            $query = self::$db->query('
                SELECT comments.*, users.id AS user_id, users.read_comments, users.read_replies_comments,
                users.email, users.avatar_content_file,
                SUM(reply_messages.id AND reply_messages.type_messages = ? ) AS number_of_replies
                FROM comments
                INNER JOIN users ON comments.user_id = users.id
                LEFT JOIN reply_messages ON reply_messages.message_id = comments.id
                WHERE comments.user_id = ?
                AND DATE_FORMAT(comments.created_at,"%Y-%m-%d") < ?
                GROUP BY comments.id
                ORDER BY created_at DESC', array(COMMENTS, (int)$user_id, $end_time));
        }
        $result = array();
        $result = $query->result();
        if ($result != NULL)
        {
            // Get comments and replies of comments have read
            $comments_with_read_replies = (array)json_decode($result[0]->read_replies_comments);
            $read_comments = (substr_count($result[0]->read_comments, ';') > 0) ? explode(";", $result[0]->read_comments) : array($result[0]->read_comments);
            foreach ($result as $temp)
            {
                $count_replies_have_read = 0;
                if ($comments_with_read_replies != NULL)
                {
                    foreach ($comments_with_read_replies as $comment_with_read_replies)
                    {
                        if ($temp->id == $comment_with_read_replies->comment)
                        {
                            $count_replies_have_read += (substr_count($comment_with_read_replies->replies, ";") + 1);
                        }
                        $temp->count_replies_have_read = $count_replies_have_read;
                    }
                }
                else $temp->count_replies_have_read = 0;
                $temp->have_read = in_array($temp->id, $read_comments);
            }
        }
        return $result;
    }

    /**
     * Get comment by id
     *
     * @param       int  $user_id
     * @param       int  $comment_id
     * @return      object
     */
    static function get_comment_by_id($user_id, $comment_id)
    {
        $query = self::$db->query('
            SELECT comments.*, users.id AS user_id, users.read_comments, users.read_replies_comments,
            users.email, users.avatar_content_file,
            SUM(reply_messages.id AND reply_messages.type_messages = ? ) AS number_of_replies
            FROM comments
            INNER JOIN users ON comments.user_id = users.id
            LEFT JOIN reply_messages ON reply_messages.message_id = comments.id
            WHERE comments.user_id = ?
            AND comments.id = ?', array(COMMENTS, (int)$user_id, (int)$comment_id));
        $result = $query->first_row();
        if ($result != NULL)
        {
            $comments_with_read_replies = (array)json_decode($result->read_replies_comments);
            if (substr_count($result->read_comments, ';') > 0) $read_comments = explode(";", $result->read_comments);
            else
            {
                $read_comments = array($result->read_comments);
            }
            $result->have_read = in_array($result->id, $read_comments);
            $count_replies_have_read = 0;
            if ($comments_with_read_replies != NULL)
            {
                foreach ($comments_with_read_replies as $comment_with_read_replies)
                {
                    if ($result->id == $comment_with_read_replies->comment)
                    {
                        $count_replies_have_read += (substr_count($comment_with_read_replies->replies, ";") + 1);
                    }
                    $result->count_replies_have_read = $count_replies_have_read;
                }
            }
            else $result->count_replies_have_read = 0;
        }
        return $result;
    }

    /**
     * Get comments based on pagination
     *
     * @param       int  $per_page
     * @param       int  $offset
     * @return      array
     */
    static function get_comments($per_page, $offset)
    {
        $query = self::$db->query('
            SELECT comments.*,
            SUM(reply_messages.id AND reply_messages.type_messages = ? ) AS number_of_replies,
            users.avatar_content_file, users.email, users.first_name, users.last_name,
            pictures.image
            FROM comments
            LEFT JOIN reply_messages ON reply_messages.message_id = comments.id
            LEFT JOIN users ON users.id = comments.user_id
            LEFT JOIN pictures ON pictures.dish_id = comments.dish_id
            GROUP BY comments.id
            ORDER BY created_at DESC
            LIMIT ?, ?', array(COMMENTS, (int)$offset, (int)$per_page));
        $result = $query->result();
        return $result;
    }

    /**
     * Get user in comment
     *
     * @param       int  $comment_id
     * @return      object
     */
    static function get_user_in_comment($comment_id)
    {
        self::$db->select('users.*');
        self::$db->from('comments');
        self::$db->join('users', 'users.id = comments.user_id');
        self::$db->where('comments.id', $comment_id);
        $query = self::$db->get();
        return $query->first_row();
    }

    /**
     * Get number of comments
     *
     * @return      int
     */
    static function number_of_comments()
    {
        $query = self::$db->get('comments');
        return $query->num_rows();
    }

    /**
     * Get detail comment for user( with status of comment, number replies of comment have read or not.)
     *
     * @param       int  $user_id
     * @param       int  $comment_id
     * @param       date(Y-m-d)  $start_time
     * @param       date(Y-m-d)  $end_time
     * @return      object
     */
    function get_detail_comment_for_user($user_id, $comment_id, $start_time = NULL, $end_time = NULL)
    {
        $comment = new stdClass();
        $this->load->model('users_model');
        $user = Users_model::get_user_by('id', $user_id);
        $comments_with_read_replies = array();
        $comments_with_read_replies = (array)json_decode($user->read_replies_comments);
        $have_read_replies_comment= "";
        foreach ($comments_with_read_replies as $comment_with_read_replies)
        {
            if ($comment_id == $comment_with_read_replies->comment)
            {
                $have_read_replies_comment .= $comment_with_read_replies->replies.";";
            }
        }
        $replies = $this->get_replies_comment_by_id($comment_id);
        $comment->have_read_replies_comment = $have_read_replies_comment;
        $comment->replies = $replies;
        return $comment;
    }

    /**
     * Get replies comment by id
     *
     * @param       int  $comment_id
     * @return      array
     */
    static function get_replies_comment_by_id($comment_id)
    {
        self::$db->select('comments.id,
            reply_messages.id AS reply_id, reply_messages.type_messages, reply_messages.content AS reply_content, reply_messages.created_at AS reply_created_at, reply_messages.updated_at AS reply_updated_at,
            users.email, users.avatar_content_file ');
        self::$db->from('comments');
        self::$db->join('reply_messages', 'reply_messages.message_id = comments.id');
        self::$db->join('users', 'users.id = reply_messages.user_id');
        self::$db->where('comments.id', $comment_id);
        self::$db->where('reply_messages.type_messages', COMMENTS);
        self::$db->order_by('reply_messages.created_at', 'DESC');
        $query = self::$db->get();
        return $query->result();
    }

    /**
     * Comment for meal date
     *
     * @param       array  $comment
     * @return      [bool, array]
     */
    function insert_comment($comment)
    {
        $result = "";
        $this->db->trans_begin();
        $this->db->insert('comments', $comment);
        $comment['id'] = $this->db->insert_id();
        $this->have_read_comment($comment['user_id'], $comment['id']);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return [FALSE,NULL];
        }
        else
        {
            $this->db->trans_commit();
            return [TRUE, $comment];
        }
    }

    /**
     * Reply a comment
     *
     * @param       int  $user_id
     * @param       int  $comment_id
     * @param       string  $content
     * @return      [bool, int]
     */
    function reply_comment($user_id, $comment_id, $content)
    {
        $data = array(
            'user_id' => $user_id,
            'message_id' => $comment_id,
            'content' => $content,
            'type_messages' => COMMENTS);
        $this->db->trans_begin();
        $query = $this->db->insert('reply_messages', $data);
        $reply_id = $this->db->insert_id();
        $this->have_read_replies_comment($user_id, $comment_id, $reply_id);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return [FALSE,NULL];
        }
        else
        {
            $this->db->trans_commit();
            return [TRUE, $reply_id];;
        }
    }

    /**
     * Edit a comment
     *
     * @param       int  $comment_id
     * @param       array  $comment
     * @return      bool
     */
    static function edit_comment($comment_id, $comment)
    {
        $comment['updated_at'] = date('Y-m-d H:i:s');
        self::$db->where('id', $comment_id);
        return $this->db->update('comments', $comment);
    }

    /**
     * Delete a comment (with replies comment if have)
     *
     * @param       int  $comment_id
     * @return      bool
     */
    static function delete_comment($comment_id)
    {
        $have_reply_in_comment = self::$db->get_where('reply_messages', array('type_messages' => COMMENTS, 'message_id' => $comment_id))->num_rows();
        if ($have_reply_in_comment > 0)
        {
            return self::$db->query('
                DELETE comments, reply_messages
                FROM comments
                INNER JOIN reply_messages ON comments.id = reply_messages.message_id
                WHERE reply_messages.type_messages = ?
                AND reply_messages.message_id = ?
                AND comments.id = ?', array(COMMENTS, $comment_id, $comment_id));
        }
        else
        {
            self::$db->where('id', $comment_id);
            return self::$db->delete('comments');
        }
    }

    /**
     * User have read comment
     *
     * @param       int  $user_id
     * @param       int  $comment_id
     * @return      bool
     */
    function have_read_comment($user_id, $comment_id)
    {
        $this->load->model('users_model');
        $user = Users_model::get_user_by('id', $user_id);
        $have_read_comments = $user->read_comments;
        if ($have_read_comments == NULL) $have_read_comments = $comment_id;
        else
        {
            $have_read_comments_arr = array();
            $have_read_comments_arr = explode(';', $have_read_comments);
            if (in_array($comment_id, $have_read_comments_arr)) return TRUE;
            $have_read_comments .= ';'.$comment_id;
        }
        $this->db->where('id', $user_id);
        return $this->db->update('users', array('read_comments'=> $have_read_comments));
    }

    /**
     * User have read replies of comment
     *
     * @param       int  $user_id
     * @param       int  $comment_id
     * @param       array  $reply_ids
     * @return      bool
     */
    function have_read_replies_comment($user_id, $comment_id, $reply_ids)
    {
        $read_replies_for_comment = array();
        $reply_ids_for_comments = array();
        $read_replies_for_comment['comment'] = $comment_id;
        $read_replies_for_comment['replies'] = $reply_ids;
        $this->load->model('users_model');
        $user = Users_model::get_user_by('id', $user_id);
        $reply_ids_for_comments = (array)json_decode($user->read_replies_comments);
        $reply_ids_for_comments[] = $read_replies_for_comment;
        $this->db->where('id', $user_id);
        return $this->db->update('users', array('read_replies_comments'=> json_encode($reply_ids_for_comments)));
    }
}
