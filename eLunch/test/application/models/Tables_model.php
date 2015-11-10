<?php

class Tables_model extends CI_Model{

    function get_all_tables($for_vegans)
    {
        $this->db->select('tables.id, tables.name, tables.description, tables.for_vegans, tables.seats,
             tables.available_seats, shifts.name AS shift , shifts.start_time, shifts.end_time');
        $this->db->from('tables');
        $this->db->join('shifts', 'tables.shift_id = shifts.id');
        if (!is_null($for_vegans))
        {
            $for_vegans = ($for_vegans == 'true') ? 1 : 0;
            $this->db->where('for_vegans', $for_vegans);
        }
        return $this->db->get()->result();
    }

    function get_tables($perpage, $offset)
    {
        $this->db->select('tables.id, tables.name, tables.description, tables.for_vegans, tables.seats,
             tables.available_seats, shifts.name AS shift , shifts.start_time, shifts.end_time');
        $this->db->from('tables');
        $this->db->join('shifts', 'tables.shift_id = shifts.id', 'left');
        $this->db->limit($perpage, $offset)->order_by('tables.shift_id', 'ASC');
        return $this->db->get()->result();
    }

    function get_table_by($table_id)
    {
        $this->db->select('tables.id, tables.name, tables.description, tables.for_vegans, tables.seats,
             tables.available_seats, shifts.name AS shift , shifts.id AS shift_id, shifts.start_time, shifts.end_time');
        $this->db->from('tables');
        $this->db->join('shifts', 'tables.shift_id = shifts.id');
        $this->db->where('tables.id', $table_id);
        return $this->db->get()->first_row();
    }

    function get_num_of_tables()
    {
        return $this->db->get('tables')->num_rows();
    }

    function delete_table($table_id)
    {
        $num_of_users_in_table = $this->count_users_in_table($table_id);
        if ($num_of_users_in_table > 0)
        {
            return $this->db->query('DELETE tables, tables_users FROM tables_users
                INNER JOIN tables_users ON tables.id = tables_users.table_id
                WHERE tables_users.table_id = ? AND tables.id = ?', array($table_id, $table_id));
        }
        else
        {
            return $this->db->delete('tables', array('id' => $table_id));
        }
    }

    function insert_table($data)
    {
        $data['available_seats'] = $data['seats'];
        return $this->db->insert('tables', $data);
    }

    function update_table($table_id, $data)
    {
        $num_of_users_in_table = $this->count_users_in_table($table_id);
        if ($data['seats'] > $num_of_users_in_table)
        {
            $data['available_seats'] = $data['seats'] - $num_of_users_in_table;
            $this->db->where('id', $table_id);
            return $this->db->update('tables', $data);
        }
        return FALSE;
    }

    function get_tables_by_shift($shift_id, $for_vegans = NULL)
    {
        $this->db->select('tables.id, tables.name, tables.description, tables.for_vegans, tables.seats,
             tables.available_seats,  shifts.id AS shift_id, shifts.name AS shift , shifts.start_time, shifts.end_time');
        $this->db->from('tables');
        $this->db->join('shifts', 'tables.shift_id = shifts.id');
        $this->db->where('shift_id', $shift_id);
        if (!is_null($for_vegans))
        {
            $for_vegans = ($for_vegans == 'true') ? 1 : 0;
            $this->db->where('for_vegans', $for_vegans);
        }
        return $this->db->get()->result();
    }

    function set_table_for_user($user_id, $table_id)
    {
        if ($this->is_exist_seat_in_table($table_id))
        {
            $result = "";
            $res = $this->check_status_of_user_in_table($user_id);
            switch ($res) {
                case NO_SEAT_IN_TABLE:
                    if (!$this->is_user_want_vegan_meal($user_id) && $this->is_table_for_vegan_meal($table_id))
                    {
                        $result = CANNOT_SET_SEAT_FOR_USER;
                    }
                    else $result = $this->insert_user_in_table($user_id, $table_id);
                    break;
                case HAVE_SEAT_VEGAN_TABLE_BUT_NO_SEAT_IN_NO_VEGAN_TABLE:
                    if (!$this->is_table_for_vegan_meal($table_id))
                    {
                        $result = $this->insert_user_in_table($user_id, $table_id);
                    }
                    else $result = CANNOT_SET_SEAT_FOR_USER;
                    break;
                case HAVE_SEAT_NO_VEGAN_TABLE_BUT_NO_SEAT_IN_VEGAN_TABLE:
                    if ($this->is_table_for_vegan_meal($table_id))
                    {
                        $result = $this->insert_user_in_table($user_id, $table_id);
                    }
                    else $result = CANNOT_SET_SEAT_FOR_USER;
                    break;
                case USER_HAVE_ENOUGH_SEAT_IN_TABLE:
                    $result = USER_HAVE_ENOUGH_SEAT_IN_TABLE;
                    break;
                default:
                    $result = CANNOT_SET_SEAT_FOR_USER;
                    break;
            }
        }
        else
        {
            $result = HAVE_NO_AVAILABLE_SEAT;
        }
        return $result;
    }
    function change_table_for_user($user_id, $table_id, $new_table_id)
    {
        $result = "";
        $status_table_id = $this->is_table_for_vegan_meal($table_id);
        $status_new_table_id = $this->is_table_for_vegan_meal($new_table_id);
        if ($table_id == $new_table_id)
            $result = HAVE_SEAT_IN_THIS_TABLE;
        elseif ($status_table_id == $status_new_table_id)
        {
            if ($this->is_exist_seat_in_table($new_table_id))
            {
                $result = $this->update_table_for_user_in_db($user_id, $table_id, $new_table_id);
            }
            else $result = HAVE_NO_AVAILABLE_SEAT;
        }
        else $result = CANNOT_SET_SEAT_FOR_USER;
        return $result;
    }

    function cancel_seat_in_table_for_user($user_id, $table_id)
    {
        if ($this->is_user_belongs_to_table($user_id, $table_id))
        {
            $is_delete = $this->delete_table_for_user_in_db($user_id, $table_id);
            if ($is_delete) return DELETE_SEAT_FOR_USER_SUCCESSFULLY;
            else return DELETE_SEAT_FOR_USER_FAIL;
        }
        else return NO_BELONGS_TO_THIS_TABLE;
    }

    function get_users_in_table($table_id)
    {
        $this->db->select('users.*, floors.id AS floor_id, floors.name AS floor');
        $this->db->from('tables_users');
        $this->db->join('users', 'tables_users.user_id = users.id');
        $this->db->join('floors', 'users.floor_id = floors.id', 'left');
        $this->db->where('table_id', $table_id);
        $query = $this->db->get();
        return $query->result();
    }

    function count_users_in_table($table_id)
    {
        $this->db->select('users.*');
        $this->db->from('tables_users');
        $this->db->join('users', 'tables_users.user_id = users.id');
        $this->db->where('table_id', $table_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function update_table_for_user_in_db($user_id, $table_id, $new_table_id)
    {
        if ($this->is_user_belongs_to_table($user_id, $table_id))
        {
            $is_delete = $this->delete_table_for_user_in_db($user_id, $table_id);
            if ($is_delete) return $this->insert_user_in_table($user_id, $new_table_id);
            else return CANNOT_SET_SEAT_FOR_USER;
        }
        else return NO_BELONGS_TO_THIS_TABLE;
    }
    function delete_table_for_user_in_db($user_id, $table_id)
    {
        $query = $this->db->delete('tables_users', array(
            'table_id' => $table_id,
            'user_id' => $user_id));
        $update_available_seat = $this->update_available_seat($table_id, '1');
        if ($query && $update_available_seat)
        {
            return TRUE;
        }
        else return FALSE;
    }

    function delete_table_vegan_for_user($user_id)
    {
        $query_get_table = $this->db->query(
            'SELECT tables.id
             FROM tables_users INNER JOIN tables ON tables_users.table_id = tables.id
             WHERE tables_users.user_id = ? AND tables.for_vegans = ?', array($user_id, FOR_VEGANS));
        if ($query_get_table->num_rows() > 0)
        {
            $this->db->trans_begin();
            $table_id = $query_get_table->first_row()->id;
            $this->update_available_seat($table_id, '1');
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
            else
            {
                $this->db->trans_commit();
                return TRUE;
            }
        }
        else return TRUE;
    }

    function is_exist_seat_in_table($table_id)
    {
        //count seats in table
        $query = $this->db->get_where('tables', array('id' => $table_id));
        $result = $query->first_row();
        $available_seats = $result->available_seats;
        if ($available_seats > 0)
        {
            return TRUE;
        }
        else return FALSE;
    }

    function get_available_seat_in_table($table_id)
    {
        //count seats in table
        $query = $this->db->get_where('tables', array('id' => $table_id));
        $result = $query->first_row();
        return $result->available_seats;
    }

    function check_status_of_user_in_table($user_id)
    {
        $query = $this->db->get_where('tables_users', array('user_id' => $user_id));
            $num_rows = $query->num_rows();
            if ($num_rows == 0)
            {
                return NO_SEAT_IN_TABLE;
            }
            elseif ($num_rows == 1)
            {
                if ($this->is_user_want_vegan_meal($user_id))
                {
                    if ($this->is_user_have_seat_in_vegan_table($user_id))
                    {
                        return HAVE_SEAT_VEGAN_TABLE_BUT_NO_SEAT_IN_NO_VEGAN_TABLE;
                    }
                    else return HAVE_SEAT_NO_VEGAN_TABLE_BUT_NO_SEAT_IN_VEGAN_TABLE;
                }
                else return USER_HAVE_ENOUGH_SEAT_IN_TABLE;
            }
            else
            {
                return USER_HAVE_ENOUGH_SEAT_IN_TABLE;
            }
    }

    function is_user_have_seat_in_vegan_table($user_id)
    {
        $this->db->select('*');
        $this->db->from('tables_users');
        $this->db->join('tables', 'tables_users.table_id = tables.id');
        $this->db->where('tables_users.user_id', $user_id);
        $this->db->where('tables.for_vegans', FOR_VEGANS);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        return $num_rows > 0;
    }

    function is_user_belongs_to_table($user_id, $table_id)
    {
        $query = $this->db->get_where('tables_users', array(
            'user_id' => $user_id,
            'table_id' => $table_id));
        return $query->num_rows();
    }

    function is_user_want_vegan_meal($user_id)
    {
        $query = $this->db->get_where('users',array('id' => $user_id));
        $want_vegan_meal = $query->first_row()->want_vegan_meal;
        if ($want_vegan_meal == 0) return FALSE;
        else return TRUE;
    }

    function is_table_for_vegan_meal($table_id)
    {
        $query = $this->db->get_where('tables', array('id' => $table_id));
        $for_vegans = $query->first_row()->for_vegans;
        if ($for_vegans == 0) return FALSE;
        else return TRUE;
    }

    function insert_user_in_table($user_id, $table_id)
    {
            $data = array(
                        'table_id' => $table_id,
                        'user_id' => $user_id);
            $query = $this->db->insert('tables_users', $data);
            $update_available_seat = $this->update_available_seat($table_id, '-1');
            if ($query && $update_available_seat)
            {
                return SET_NEW_SEAT_FOR_USER;
            }
            else return CANNOT_SET_SEAT_FOR_USER;
    }

    function update_available_seat($table_id, $number)
    {
        return $this->db->query('UPDATE tables SET available_seats = available_seats + ? WHERE tables.id = ?', array($number, $table_id));
    }

    function get_shifts_and_tables_of_user($user_id)
    {
        $this->db->select('tables.id AS table_id, tables.name AS table_name, tables.for_vegans,
            shifts.id AS shift_id, shifts.name AS shift_name, shifts.start_time, shifts.end_time');
        $this->db->from('tables_users');
        $this->db->join('tables', 'tables_users.table_id = tables.id');
        $this->db->join('shifts', 'tables.shift_id = shifts.id');
        $this->db->where('tables_users.user_id', $user_id);
        $this->db->group_by('tables.shift_id');
        $query = $this->db->get();
        return $query->result();
    }
}