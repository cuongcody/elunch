<?php

class Tables_model extends CI_Model{

    private static $db;

    function __construct() {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    /**
     * Get all tables. all normal tables, all vegan tables
     *
     * @param       int  $for_vegans
     * @return      array
     */
    static function get_all_tables($for_vegans = NULL)
    {
        self::$db->select('tables.id, tables.name, tables.description, tables.for_vegans, tables.seats,
            shifts.name AS shift , shifts.start_time, shifts.end_time');
        self::$db->from('tables');
        self::$db->join('shifts', 'tables.shift_id = shifts.id');
        if (!is_null($for_vegans))
        {
            $for_vegans = ($for_vegans == 'true') ? 1 : 0;
            self::$db->where('for_vegans', $for_vegans);
        }
        return self::$db->get()->result();
    }

    /**
     * Get all tables based on pagination
     *
     * @param       int  $perpage
     * @param       int  $offset
     * @return      array
     */
    static function get_tables($perpage, $offset, $search = NULL)
    {
        self::$db->cache_on();
        self::$db->select('tables.id, tables.name, tables.description, tables.for_vegans, tables.seats,
            shifts.name AS shift , shifts.start_time, shifts.end_time');
        self::$db->from('tables');
        self::$db->join('shifts', 'tables.shift_id = shifts.id', 'left');
        self::$db->like('tables.name', $search);
        self::$db->limit($perpage, $offset)->order_by('tables.shift_id', 'ASC')->order_by('tables.name', 'ASC');
        return self::$db->get()->result();
    }

    /**
     * Get table by id
     *
     * @param       int  $table_id
     * @return      object
     */
    static function get_table_by($table_id)
    {
        self::$db->select('tables.id, tables.name, tables.description, tables.for_vegans, tables.seats,
            shifts.name AS shift , shifts.id AS shift_id, shifts.start_time, shifts.end_time');
        self::$db->from('tables');
        self::$db->join('shifts', 'tables.shift_id = shifts.id');
        self::$db->where('tables.id', $table_id);
        return self::$db->get()->first_row();
    }

    /**
     * Get number of tables
     *
     * @return      int
     */
    static function get_num_of_tables($search)
    {
        return self::$db->like('tables.name', $search)->get('tables')->num_rows();
    }

    /**
     * Delete table
     *
     * @param       int  $table_id
     * @return      bool
     */
    function delete_table($table_id)
    {
        $this->db->cache_delete('admin', 'tables');
        $this->db->cache_delete('admin', 'home');
        $table = $this->get_table_by($table_id);
        $num_of_users_in_table = ($table->for_vegans == 1) ? $this->count_users_in_table($table_id, VEGAN_DAY) : $this->count_users_in_table($table_id, NORMAL_DAY);
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

    /**
     * Insert new table
     *
     * @param       array  $data
     * @return      bool
     */
    static function insert_table($data)
    {
        self::$db->cache_delete('admin', 'tables');
        self::$db->cache_delete('admin', 'home');
        return self::$db->insert('tables', $data);
    }

    /**
     * Update table
     *
     * @param       int  $table_id
     * @param       array  $data
     * @return      bool
     */
    function update_table($table_id, $data)
    {
        $table = $this->get_table_by($table_id);
        $num_of_users_in_table = ($table->for_vegans == 1) ? $this->count_users_in_table($table_id, VEGAN_DAY) : $this->count_users_in_table($table_id, NORMAL_DAY);
        if ($data['seats'] >= $num_of_users_in_table)
        {
            $this->db->cache_delete('admin', 'tables');
            $this->db->cache_delete('admin', 'home');
            $this->db->where('id', $table_id);
            return $this->db->update('tables', $data);
        }
        return FALSE;
    }

    /**
     * Get tables by shift
     *
     * @param       int  $shift_id
     * @param       int  $for_vegans
     * @param       int  $day( NORMAL DAY OR VEGAN DAY)
     * @return      array
     */
    static function get_tables_by_shift($shift_id, $for_vegans = NULL, $day = NULL)
    {
        $query = '
            SELECT tables.id, tables.name, tables.description, tables.for_vegans, tables.seats,
            SUM(users.id AND tables_users.vegan_day = ?) AS occupied_seats,
            shifts.name AS shift , shifts.id AS shift_id, shifts.start_time, shifts.end_time
            FROM tables
            INNER JOIN shifts ON tables.shift_id = shifts.id
            LEFT JOIN tables_users ON tables_users.table_id = tables.id
            LEFT JOIN users ON tables_users.user_id = users.id
            WHERE shifts.id = ? ';
        if (!is_null($for_vegans))
        {
            $query.='AND tables.for_vegans = ? GROUP BY tables.id';
            $result = self::$db->query($query, array($day, $shift_id, $for_vegans));
        }
        else
        {
            $query.='GROUP BY tables.id';
            $result = self::$db->query($query, array($day, $shift_id));
        }
        return $result->result();
    }

    /**
     * Check status of user in table
     *
     * @param       int  $user_id
     * @param       int  $day( NORMAL DAY OR VEGAN DAY)
     * @return      int
     */
    static function check_status_of_user_in_table($user_id, $day = NULL)
    {

        $data = array('user_id' => $user_id, 'vegan_day' => $day);
        $query = self::$db->get_where('tables_users', $data);
        $num_rows = $query->num_rows();
        if ($num_rows == 0)
        {
            return NO_SEAT_IN_TABLE;
        }
        else
        {
            return HAVE_SEAT_IN_TABLE;
        }
    }

    /**
     * User join in table
     *
     * @param       int  $user_id
     * @param       int  $table_id
     * @return      int
     */
    function set_table_for_user($user_id, $table_id)
    {
        $result = JOIN_TABLE_FAILED;
        if ($this->can_set_seat_in_table_for_user($user_id, $table_id))
        {
            $this->load->model('users_model');
            $is_vegan_table = $this->is_vegan_table($table_id);
            $is_user_want_vegan_meal = Users_model::is_user_want_vegan_meal($user_id);
            $res = ($is_vegan_table) ? $this->check_status_of_user_in_table($user_id, VEGAN_DAY) : $this->check_status_of_user_in_table($user_id, NORMAL_DAY);
            if ($res == NO_SEAT_IN_TABLE)
            {
                if ($is_user_want_vegan_meal && $is_vegan_table)
                {
                    $result = ($this->insert_user_in_table($user_id, $table_id, VEGAN_DAY)) ? JOIN_TABLE_SUCCESSFULLY : JOIN_TABLE_FAILED;
                }
                else if ($is_user_want_vegan_meal && !$is_vegan_table)
                {
                    $result = ($this->insert_user_in_table($user_id, $table_id, NORMAL_DAY)) ? JOIN_TABLE_SUCCESSFULLY : JOIN_TABLE_FAILED;
                }
                else if (!$is_user_want_vegan_meal && !$is_vegan_table)
                {
                    $result = ($this->insert_user_in_table($user_id, $table_id, NULL)) ? JOIN_TABLE_SUCCESSFULLY : JOIN_TABLE_FAILED;
                }
                else $result = JOIN_TABLE_FAILED;
            }
            else $result = HAVE_SEAT_IN_TABLE;
        }
        return $result;
    }

    /**
     * Admin arrange to add user in table
     *
     * @param       int  $user_id
     * @param       int  $table_id
     * @param       int  $day
     * @return      int
     */
    function arrange_to_add_user_in_table($user_id, $table_id, $day)
    {
        $result = JOIN_TABLE_FAILED;
        if ($this->can_set_seat_in_table_for_user($user_id, $table_id))
        {
            $this->load->model('users_model');
            $is_vegan_table = $this->is_vegan_table($table_id);
            $is_user_want_vegan_meal = Users_model::is_user_want_vegan_meal($user_id);
            $res = $this->check_status_of_user_in_table($user_id, $day);
            if ($res == NO_SEAT_IN_TABLE)
            {
                if ($is_user_want_vegan_meal && $is_vegan_table && $day == VEGAN_DAY)
                {
                    $result = ($this->insert_user_in_table($user_id, $table_id, VEGAN_DAY)) ? JOIN_TABLE_SUCCESSFULLY : JOIN_TABLE_FAILED;
                }
                elseif ($is_user_want_vegan_meal && !$is_vegan_table && $day == NORMAL_DAY)
                {
                    $result = ($this->insert_user_in_table($user_id, $table_id, NORMAL_DAY)) ? JOIN_TABLE_SUCCESSFULLY : JOIN_TABLE_FAILED;
                }
                elseif (!$is_user_want_vegan_meal && !$is_vegan_table)
                {
                    $result = ($this->insert_user_in_table($user_id, $table_id, NULL)) ? JOIN_TABLE_SUCCESSFULLY : JOIN_TABLE_FAILED;
                }
                else $result = JOIN_TABLE_FAILED;
            }
            else $result = HAVE_SEAT_IN_TABLE;
        }
        return $result;
    }

    /**
     * Insert user in table
     *
     * @param       int  $user_id
     * @param       int  $table_id
     * @param       int  $day( NORMAL DAY OR VEGAN DAY)
     * @return      int
     */
    function insert_user_in_table($user_id, $table_id, $day)
    {
        $this->db->cache_delete('admin', 'tables');
        $this->db->cache_delete('admin', 'home');
        $data1 = array(
                    'table_id' => $table_id,
                    'user_id' => $user_id,
                    'vegan_day' => NORMAL_DAY);
        $data2 = array(
                    'table_id' => $table_id,
                    'user_id' => $user_id,
                    'vegan_day' => VEGAN_DAY);
        if (is_null($day))
        {
            $data = array( $data1, $data2);
            $query = ($this->is_exist_seat_in_table($table_id, NORMAL_DAY) && $this->is_exist_seat_in_table($table_id, VEGAN_DAY)) ? $this->db->insert_batch('tables_users', $data) : FALSE;
        }
        elseif ($day == NORMAL_DAY)
        {
            $query = ($this->is_exist_seat_in_table($table_id, $day)) ? $this->db->insert('tables_users', $data1) : FALSE;
        }
        elseif ($day == VEGAN_DAY)
        {
            $query = ($this->is_exist_seat_in_table($table_id, $day)) ? $this->db->insert('tables_users', $data2) : FALSE;
        }
        return $query;
    }

    /**
     * Check user and table have the same shift or not
     *
     * @param       int  $user_id
     * @param       int  $table_id
     * @param       int  $day( NORMAL DAY OR VEGAN DAY)
     * @return      bool
     */
    function can_set_seat_in_table_for_user($user_id, $table_id, $day = NULL)
    {
        $this->db->select('users.shift_id, tables.shift_id');
        $this->db->from('users');
        $this->db->join('tables', 'users.shift_id = tables.shift_id');
        $this->db->where('users.id', $user_id);
        $this->db->where('tables.id', $table_id);
        $query = $this->db->get();
        return ($query->num_rows() > 0);
    }

    /**
     * User leave table
     *
     * @param       int  $user_id
     * @param       int  $table_id
     * @param       int  $day( NORMAL DAY OR VEGAN DAY)
     * @return      int
     */
    function user_leave_table($user_id, $table_id, $day = NULL)
    {
        $result = LEAVE_TABLE_FAILED;
        if ($this->is_user_belongs_to_table($user_id, $table_id, $day))
        {
            $this->load->model('users_model');
            $is_vegan_table = $this->is_vegan_table($table_id);
            $is_user_want_vegan_meal = Users_model::is_user_want_vegan_meal($user_id);
            $res = ($is_vegan_table) ? $this->check_status_of_user_in_table($user_id, VEGAN_DAY) : $this->check_status_of_user_in_table($user_id, NORMAL_DAY);
            if ($is_user_want_vegan_meal && $is_vegan_table)
            {
                $result = ($this->delete_user_in_table($user_id, $table_id, VEGAN_DAY)) ? LEAVE_TABLE_SUCCESSFULLY : LEAVE_TABLE_FAILED;
            }
            else if ($is_user_want_vegan_meal && !$is_vegan_table)
            {
                $result = ($this->delete_user_in_table($user_id, $table_id, NORMAL_DAY)) ? LEAVE_TABLE_SUCCESSFULLY : LEAVE_TABLE_FAILED;
            }
            else if (!$is_user_want_vegan_meal && !$is_vegan_table)
            {
                $result = ($this->delete_user_in_table($user_id, $table_id, NULL)) ? LEAVE_TABLE_SUCCESSFULLY : LEAVE_TABLE_FAILED;
            }
            else $result = LEAVE_TABLE_FAILED;
        }
        else $result = NO_SEAT_IN_TABLE;
        return $result;
    }

    /**
     * Check user belongs to table
     *
     * @param       int  $user_id
     * @param       int  $table_id
     * @param       int  $day( NORMAL DAY OR VEGAN DAY)
     * @return      bool
     */
    function is_user_belongs_to_table($user_id, $table_id, $day)
    {
        if (is_null($day))
        {
            $data = array(
            'user_id' => $user_id,
            'table_id' => $table_id);
        }
        elseif (!is_null($day) && $day == VEGAN_DAY)
        {
            $data = array(
            'user_id' => $user_id,
            'table_id' => $table_id,
            'vegan_day' => VEGAN_DAY);
        }
        elseif (!is_null($day) && $day == NORMAL_DAY)
        {
            $data = array(
            'user_id' => $user_id,
            'table_id' => $table_id,
            'vegan_day' => NORMAL_DAY);
        }
        $query = $this->db->get_where('tables_users', $data);
        return $query->num_rows();
    }

    /**
     * Delete user in table
     *
     * @param       int  $user_id
     * @param       int  $table_id
     * @param       int  $day( NORMAL DAY OR VEGAN DAY)
     * @return      bool
     */
    function delete_user_in_table($user_id, $table_id, $day = NULL)
    {
        $this->db->cache_delete('admin', 'tables');
        $this->db->cache_delete('admin', 'home');
        if (is_null($day))
        {
            $data = array(
            'user_id' => $user_id);
        }
        elseif (!is_null($day) && $day == VEGAN_DAY)
        {
            $data = array(
            'table_id' => $table_id,
            'user_id' => $user_id,
            'vegan_day' => VEGAN_DAY);
        }
        elseif (!is_null($day) && $day == NORMAL_DAY)
        {
            $data = array(
            'table_id' => $table_id,
            'user_id' => $user_id,
            'vegan_day' => NORMAL_DAY);
        }
        $query = $this->db->delete('tables_users', $data);
        return $query;
    }

    /**
     * Get users in table
     *
     * @param       int  $table_id
     * @param       int  $day( NORMAL DAY OR VEGAN DAY)
     * @return      array
     */
    static function get_users_in_table($table_id, $day = NULL)
    {
        self::$db->select('users.*, floors.id AS floor_id, floors.name AS floor');
        self::$db->from('tables_users');
        self::$db->join('users', 'tables_users.user_id = users.id');
        self::$db->join('floors', 'users.floor_id = floors.id', 'left');
        self::$db->where('table_id', $table_id);
        if (!is_null($day) && $day == VEGAN_DAY)
        {
            self::$db->where('vegan_day', VEGAN_DAY);
        }
        elseif(!is_null($day) && $day == NORMAL_DAY) self::$db->where('vegan_day', NORMAL_DAY);
        self::$db->order_by('users.first_name', 'ASC');
        $query = self::$db->get();
        return $query->result();
    }

    /**
     * Count users in tables
     *
     * @param       int  $table_id
     * @param       int  $day( NORMAL DAY OR VEGAN DAY)
     * @return      int
     */
    function count_users_in_table($table_id, $day = NULL)
    {
        $this->db->select('users.*');
        $this->db->from('tables_users');
        $this->db->join('users', 'tables_users.user_id = users.id');
        $this->db->where('table_id', $table_id);
        if (!is_null($day) && $day == VEGAN_DAY)
        {
            $this->db->where('vegan_day', VEGAN_DAY);
        }
        else $this->db->where('vegan_day', NORMAL_DAY);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Update table for user when user edit profile
     *
     * @param       int  $user_id
     * @param       int  $request
     * @return      bool
     */
    function update_table_for_user($user_id, $request)
    {
        // User want to change from eat vegan meal to eat normal meal
        if ($request)
        {
            $table_in_normal_day = $this->db->get_where('tables_users', array('user_id' => $user_id, 'vegan_day' => NORMAL_DAY))->first_row();
            // Have set table
            if ($table_in_normal_day != NULL)
            {
                $have_vegan_table = $this->db->get_where('tables_users', array('user_id' => $user_id, 'vegan_day' => VEGAN_DAY))->num_rows();
                if ($have_vegan_table > 0)
                {
                    // Replace table normal meal for table vegan meal
                    $this->db->where('user_id', $user_id);
                    $this->db->where('vegan_day', VEGAN_DAY);
                    return ($this->is_exist_seat_in_table($table_in_normal_day->table_id, VEGAN_DAY)) ? $this->db->update('tables_users', array('table_id' => $table_in_normal_day->table_id)) : FALSE;
                }
                else
                {
                    return ($this->is_exist_seat_in_table($table_in_normal_day->table_id, VEGAN_DAY)) ? $this->db->insert('tables_users', array('user_id'=> $user_id, 'table_id' => $table_in_normal_day->table_id, 'vegan_day' => VEGAN_DAY)) : FALSE;
                }
            }
            else return TRUE;
        }
        // User want to change from eat normal meal to eat vegan meal
        else
        {
            //Delete table normal of user in vegan day
            return $this->db->delete('tables_users', array('user_id' => $user_id, 'vegan_day' => VEGAN_DAY));
        }
    }

    /**
     * Check have available seats in table
     *
     * @param       int  $table_id
     * @param       int  $day( NORMAL DAY OR VEGAN DAY)
     * @return      bool
     */
    function is_exist_seat_in_table($table_id, $day)
    {
        $query = $this->db->query('
            SELECT tables.id, tables.name, tables.description, tables.for_vegans, tables.seats,
            SUM(users.id AND tables_users.vegan_day = ?) AS occupied_seats,
            shifts.name AS shift , shifts.id AS shift_id, shifts.start_time, shifts.end_time
            FROM tables
            INNER JOIN shifts ON tables.shift_id = shifts.id
            LEFT JOIN tables_users ON tables_users.table_id = tables.id
            LEFT JOIN users ON tables_users.user_id = users.id
            WHERE tables.id = ?', array($day, $table_id));
        $result = $query->first_row();
        return ($result->seats > $result->occupied_seats);
    }

    /**
     * Check table for vegan meal or normal meal
     *
     * @param       int  $table_id
     * @return      bool
     */
    function is_vegan_table($table_id)
    {
        $query = $this->db->get_where('tables', array('id' => $table_id));
        $for_vegans = $query->first_row()->for_vegans;
        if ($for_vegans == 0) return FALSE;
        else return TRUE;
    }

    /**
     * Get shift and tables of user
     *
     * @param       int  $user_id
     * @return      array
     */
    static function get_shift_and_tables_of_user($user_id)
    {
        self::$db->select('tables.id AS table_id, tables.name AS table_name, tables.for_vegans,
            shifts.id AS shift_id, shifts.name AS shift_name, shifts.start_time, shifts.end_time');
        self::$db->from('tables_users');
        self::$db->join('tables', 'tables_users.table_id = tables.id');
        self::$db->join('shifts', 'tables.shift_id = shifts.id');
        self::$db->join('users', 'users.id = tables_users.user_id');
        self::$db->where('users.id', $user_id);
        self::$db->group_by('tables.id');
        $query = self::$db->get();
        return $query->result();
    }

    /**
     * Delete tables when user want to change shift
     *
     * @param       int  $user_id
     * @return      int  bool
     */
    function leave_tables_in_shift_for_user($user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->delete('tables_users');
    }
}