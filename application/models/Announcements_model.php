<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcements_model extends CI_Model {

    private static $db;

    function __construct() {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    /**
     * Get announcements for user
     *
     * @param       int  $user_id
     * @param       date(Y-m-d)  $start_time
     * @param       date(Y-m-d)  $end_time
     * @return      array
     */
    function get_announcements_for_user($user_id, $start_time, $end_time)
    {

        $messages = array();
        $this->load->model('users_model');
        $user = Users_model::get_user_by('id', $user_id);
        // Get all messages from admin
        $result = $this->get_announcements(NULL, NULL, $start_time, $end_time);
        if ($result != NULL)
        {
            foreach ($result as $message)
            {
                if ($message->user == 'all')
                {
                    $messages = $this->add_a_annoucement_in_announcements($user, $messages, $message);
                }
                elseif($message->user == $user_id)
                {
                    $messages = $this->add_a_annoucement_in_announcements($user, $messages, $message);
                }
                else
                {
                    $this->load->model('tables_model');
                    // Get shift and table of user
                    $shift_and_tables = Tables_model::get_shift_and_tables_of_user($user_id);
                    if ($shift_and_tables != NULL)
                    {
                        $shift_id = $shift_and_tables[0]->shift_id;
                        if (!is_null($message->shift))
                        {
                            if ($message->shift == $shift_id)
                            {
                                $messages = $this->add_a_annoucement_in_announcements($user, $messages, $message);
                            }
                        }
                        elseif (!is_null($message->table))
                        {
                            foreach ($shift_and_tables as $table)
                            {
                                if ($message->table == $table->table_id)
                                {
                                    $messages = $this->add_a_annoucement_in_announcements($user, $messages, $message);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $messages;
    }

    /**
     * Get detail announcement for user( with status of announcement, number replies of announcement have read or not.)
     *
     * @param       int  $user_id
     * @param       int  $announcement_id
     * @param       date(Y-m-d)  $start_time
     * @param       date(Y-m-d)  $end_time
     * @return      object
     */
    function get_detail_announcement_for_user($user_id, $announcement_id, $start_time = NULL, $end_time = NULL)
    {
        $announcement = new stdClass();
        $this->load->model('users_model');
        $user = Users_model::get_user_by('id', $user_id);
        $announcements_with_read_replies = array();
        $announcements_with_read_replies = (array)json_decode($user->read_replies_announcements);
        $have_read_replies_announcement= "";
        foreach ($announcements_with_read_replies as $announcement_with_read_replies)
        {
            if ($announcement_id == $announcement_with_read_replies->announcement)
            {
                $have_read_replies_announcement .= $announcement_with_read_replies->replies.";";
            }
        }
        $replies = $this->get_replies_announcement_by_id($announcement_id);
        $announcement->have_read_replies_announcement = $have_read_replies_announcement;
        $announcement->replies = $replies;
        return $announcement;
    }

    /**
     * Get replies announcement by id
     *
     * @param       int  $announcement_id
     * @return      array
     */
    static function get_replies_announcement_by_id($announcement_id)
    {
        self::$db->select('admin_messages.id,
            reply_messages.id AS reply_id, reply_messages.type_messages, reply_messages.content AS reply_content, reply_messages.created_at AS reply_created_at, reply_messages.updated_at AS reply_updated_at,
            users.email, users.avatar_content_file ');
        self::$db->from('admin_messages');
        self::$db->join('reply_messages', 'reply_messages.message_id = admin_messages.id');
        self::$db->join('users', 'users.id = reply_messages.user_id');
        self::$db->where('admin_messages.id', $announcement_id);
        self::$db->where('reply_messages.type_messages', ANNOUNCEMENT);
        self::$db->order_by('reply_messages.created_at', 'DESC');
        $query = self::$db->get();
        return $query->result();
    }

    /**
     * Get announcements based on pagination or date
     *
     * @param       int  $per_page
     * @param       int  $offset
     * @param       date(Y-m-d)  $start_time
     * @param       date(Y-m-d)  $end_time
     * @return      array
     */
    static function get_announcements($per_page = NULL, $offset = NULL, $start_time = NULL, $end_time = NULL)
    {
        if (!is_null($offset) && !is_null($per_page)){
            $query = self::$db->query('
                SELECT admin_messages.*,
                SUM(reply_messages.id AND reply_messages.type_messages = ? ) AS number_of_replies,
                users.id AS user_id, users.avatar_content_file, users.email
                FROM admin_messages
                LEFT JOIN reply_messages ON reply_messages.message_id = admin_messages.id
                INNER JOIN users ON admin_messages.user_id = users.id
                GROUP BY admin_messages.id
                ORDER BY created_at DESC
                LIMIT ?, ?', array(ANNOUNCEMENT, (int)$offset, (int)$per_page));
        }
        elseif ((!is_null($start_time) && !is_null($end_time)))
        {
            $query = self::$db->query('
                SELECT admin_messages.*,
                SUM(reply_messages.id AND reply_messages.type_messages = ? ) AS number_of_replies,
                users.id AS user_id, users.avatar_content_file, users.email
                FROM admin_messages
                LEFT JOIN reply_messages ON reply_messages.message_id = admin_messages.id
                INNER JOIN users ON admin_messages.user_id = users.id
                WHERE DATE_FORMAT(admin_messages.created_at,"%Y-%m-%d") >= ?
                AND DATE_FORMAT(admin_messages.created_at,"%Y-%m-%d") <= ?
                GROUP BY admin_messages.id
                ORDER BY created_at DESC
                ', array(ANNOUNCEMENT, $start_time, $end_time));
        }
        elseif (!is_null($start_time))
        {
            $query = self::$db->query('
                SELECT admin_messages.*,
                SUM(reply_messages.id AND reply_messages.type_messages = ? ) AS number_of_replies,
                users.id AS user_id, users.avatar_content_file, users.email
                FROM admin_messages
                LEFT JOIN reply_messages ON reply_messages.message_id = admin_messages.id
                INNER JOIN users ON admin_messages.user_id = users.id
                WHERE DATE_FORMAT(admin_messages.created_at,"%Y-%m-%d") > ?
                GROUP BY admin_messages.id
                ORDER BY created_at DESC
                ', array(ANNOUNCEMENT, $start_time));
        }
        elseif (!is_null($end_time))
        {
            $query = self::$db->query('
                SELECT admin_messages.*,
                SUM(reply_messages.id AND reply_messages.type_messages = ? ) AS number_of_replies,
                users.id AS user_id, users.avatar_content_file, users.email
                FROM admin_messages
                LEFT JOIN reply_messages ON reply_messages.message_id = admin_messages.id
                INNER JOIN users ON admin_messages.user_id = users.id
                WHERE DATE_FORMAT(admin_messages.created_at,"%Y-%m-%d") < ?
                GROUP BY admin_messages.id
                ORDER BY created_at DESC
                ', array(ANNOUNCEMENT, $end_time));
        }
        $result = $query->result();
        return $result;
    }

    /**
     * Get announcement by id
     *
     * @param       int  $user_id
     * @param       int  $announcement_id
     * @return      object
     */
    function get_announcement_by_id($user_id, $announcement_id)
    {
        $query = $this->db->query('
            SELECT admin_messages.*,
            SUM(reply_messages.id AND reply_messages.type_messages = ? ) AS number_of_replies,
            users.id AS user_id, users.avatar_content_file, users.email
            FROM admin_messages
            LEFT JOIN reply_messages ON reply_messages.message_id = admin_messages.id
            INNER JOIN users ON admin_messages.user_id = users.id
            WHERE admin_messages.id = ?
            ', array(ANNOUNCEMENT, $announcement_id));
        $result = $query->first_row();
        $this->load->model('users_model');
        $user = Users_model::get_user_by('id', $user_id);
        $announcements_with_read_replies = array();
        $announcements_with_read_replies = (array)json_decode($user->read_replies_announcements);
        $count_replies_have_read = 0;
        $read_announcements = (substr_count($user->read_announcements, ';') > 0) ? explode(";", $user->read_announcements) : array($user->read_announcements);
        foreach ($announcements_with_read_replies as $announcement_with_read_replies)
        {
            if ($result->id == $announcement_with_read_replies->announcement)
            {
                $count_replies_have_read += (substr_count($announcement_with_read_replies->replies, ";") + 1);
            }
        }
        $result->count_replies_have_read = $count_replies_have_read;
        $result->have_read = in_array($result->id, $read_announcements);
        return $result;
    }

    /**
     * Get user in the announcement by announcement id
     *
     * @param       int  $announcement_id
     * @return      object
     */
    static function get_user_in_announcement($announcement_id)
    {
        $announcement = self::$db->get_where('admin_messages', array('id' => $announcement_id))->first_row();
        $user = array();
        if (!is_null($announcement->user) && $announcement->user != 'all')
        {
            $user = self::$db->get_where('users', array('id' => $announcement->user))->first_row();
        }
        return $user;
    }

    /**
     * Get number of announcements
     *
     * @return      int
     */
    static function number_of_announcements()
    {
        $query = self::$db->get('admin_messages');
        return $query->num_rows();
    }

    /**
     * Add a announcement in array
     *
     * @param       object  $user
     * @param       array  $messages
     * @param       object  $message
     * @return      array
     */
    function add_a_annoucement_in_announcements($user, $messages, $message)
    {
        $announcements_with_read_replies = array();
        $announcements_with_read_replies = (array)json_decode($user->read_replies_announcements);
        $have_read_replies_announcements = "";
        $count_replies_have_read = 0;
        if (substr_count($user->read_announcements, ';') > 0) $read_announcements = explode(";", $user->read_announcements);
        else
        {
            $read_announcements = array($user->read_announcements);
        }
        foreach ($announcements_with_read_replies as $announcement_with_read_replies)
        {
            if ($message->id == $announcement_with_read_replies->announcement)
            {
                $count_replies_have_read += (substr_count($announcement_with_read_replies->replies, ";") + 1);
            }
        }
        $message->count_replies_have_read = $count_replies_have_read;
        $message->have_read = in_array($message->id, $read_announcements);
        array_push($messages, $message);
        return $messages;
    }

    /**
     * Insert new announcement
     *
     * @param       array  $data
     * @return      [bool, int]
     */
    static function insert_announcement($data)
    {
        return [self::$db->insert('admin_messages', $data), self::$db->insert_id()];
    }

    /**
     * Reply a announcement
     *
     * @param       int  $user_id
     * @param       int  $announcement_id
     * @param       string  $content
     * @return      [bool, int]
     */
    function reply_announcement($user_id, $announcement_id, $content)
    {
        $data = array(
            'user_id' => $user_id,
            'message_id' => $announcement_id,
            'content' => $content,
            'type_messages' => ANNOUNCEMENT);
        $this->db->trans_begin();
        $this->db->insert('reply_messages', $data);
        $reply_id = $this->db->insert_id();
        $this->have_read_replies_announcement($user_id, $announcement_id, $reply_id);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return [FALSE, NULL];
        }
        else
        {
            $this->db->trans_commit();
            return [TRUE, $reply_id];
        }
    }

    /**
     * Delete a announcement
     *
     * @param       int  $announcement_id
     * @return      bool
     */
    static function delete_announcement($announcement_id)
    {
        $have_comment_in_admin_message = self::$db->get_where('reply_messages', array('type_messages' => ANNOUNCEMENT, 'message_id' => $announcement_id))->num_rows();
        if ($have_comment_in_admin_message > 0)
        {
            return self::$db->query('
                DELETE admin_messages, reply_messages
                FROM admin_messages
                INNER JOIN reply_messages ON admin_messages.id = reply_messages.message_id
                WHERE reply_messages.type_messages = ?
                AND reply_messages.message_id = ?
                AND admin_messages.id = ?', array(ANNOUNCEMENT, $announcement_id, $announcement_id));
        }
        else
        {
            self::$db->where('id', $announcement_id);
            return self::$db->delete('admin_messages');
        }
    }

    /**
     * User have read announcement
     *
     * @param       int  $user_id
     * @param       int  $announcement_id
     * @return      bool
     */
    function have_read_announcement($user_id, $announcement_id)
    {
        $this->load->model('users_model');
        $user = Users_model::get_user_by('id', $user_id);
        $have_read_announcements = $user->read_announcements;
        if ($have_read_announcements == NULL) $have_read_announcements = $announcement_id;
        else
        {
            $have_read_announcements_arr = array();
            $have_read_announcements_arr = explode(';', $have_read_announcements);
            if (in_array($announcement_id, $have_read_announcements_arr)) return TRUE;
            $have_read_announcements .= ';'.$announcement_id;
        }
        $this->db->where('id', $user_id);
        return $this->db->update('users', array('read_announcements'=> $have_read_announcements));
    }

    /**
     * User have read replies of announcement
     *
     * @param       int  $user_id
     * @param       int  $announcement_id
     * @param       array  $reply_ids
     * @return      bool
     */
    function have_read_replies_announcement($user_id, $announcement_id, $reply_ids)
    {
        $read_replies_for_announcement = array();
        $reply_ids_for_announcements = array();
        $read_replies_for_announcement['announcement'] = $announcement_id;
        $read_replies_for_announcement['replies'] = $reply_ids;
        $this->load->model('users_model');
        $user = Users_model::get_user_by('id', $user_id);
        $reply_ids_for_announcements = (array)json_decode($user->read_replies_announcements);
        $reply_ids_for_announcements[] = $read_replies_for_announcement;
        $this->db->where('id', $user_id);
        return $this->db->update('users', array('read_replies_announcements'=> json_encode($reply_ids_for_announcements)));
    }

}