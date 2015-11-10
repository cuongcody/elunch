<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages_model extends CI_Model {

    function get_messages_of_user($user_id)
    {
        $messages = array();
        // Get table id form user_id
        $this->load->model('tables_model');
        // Get shift and table of user
        $shifts_and_tables = $this->tables_model->get_shifts_and_tables_of_user($user_id);
        // Get all messages from admin
        $result = $this->get_messages();
        foreach ($result as $message)
        {
            if ($message->user == 'all')
            {
                $messages = $this->add_message_in_messages($messages, $message);
            }
            elseif($message->user == $user_id)
            {
                $messages = $this->add_message_in_messages($messages, $message);
            }
            elseif (!is_null($message->shift))
            {
                foreach ($shifts_and_tables as $shift)
                {
                    if ($message->shift == $shift->shift_id)
                    {
                        $messages = $this->add_message_in_messages($messages, $message);
                    }
                }
            }
            elseif (!is_null($message->table))
            {
                foreach ($shifts_and_tables as $table)
                {
                    if ($message->table == $table->table_id)
                    {
                        $messages = $this->add_message_in_messages($messages, $message);
                    }
                }
            }
        }
        return $messages;
    }

    function get_detail_message($message_id)
    {
        $this->db->select('admin_messages.id, admin_messages.title, admin_messages.content,admin_messages.meal_date, admin_messages.created_at, admin_messages.updated_at,
            reply_messages.id AS reply_id, reply_messages.type_messages, reply_messages.content AS reply_content, reply_messages.created_at AS reply_created_at, reply_messages.updated_at AS reply_updated_at,
            users.email, users.avatar_content_file ');
        $this->db->from('admin_messages');
        $this->db->join('reply_messages', 'reply_messages.message_id = admin_messages.id');
        $this->db->join('users', 'users.id = reply_messages.user_id');
        $this->db->where('admin_messages.id', $message_id);
        $this->db->where('reply_messages.type_messages', ADMIN_MESSAGES);
        $query = $this->db->get();
        return [$query->result(), $query->num_rows()];
    }

    function get_messages()
    {
        $this->db->select('admin_messages.*,
            COUNT(reply_messages.id) AS number_of_replies, reply_messages.type_messages');
        $this->db->from('admin_messages');
        $this->db->join('reply_messages', 'reply_messages.message_id = admin_messages.id', 'left');
        $this->db->group_by('admin_messages.id');
        $query = $this->db->get();
        $result = $this->get_admin_messages($query->result());
        return $result;
    }

    function get_admin_messages($messages)
    {
        foreach ($messages as $key => $message)
        {
            if (!is_null($message->type_messages) && $message->type_messages != ADMIN_MESSAGES)
            {
                unset($messages[$key]);
            }
        }
        return $messages;
    }

    function add_message_in_messages($messages, $message)
    {
        array_push($messages, $message);
        return $messages;
    }

    function reply_admin_message($user_id, $message_id, $content)
    {
        $data = array(
            'user_id' => $user_id,
            'message_id' => $message_id,
            'content' => $content,
            'type_messages' => ADMIN_MESSAGES);
        return $this->db->insert('reply_messages', $data);
    }

}