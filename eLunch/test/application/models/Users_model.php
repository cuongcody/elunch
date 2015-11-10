<?php

class Users_model extends CI_Model{

    function get_all_users()
    {
        $this->db->select('users.id, users.email, users.first_name, users.last_name, users.avatar_content_file,
         users.what_taste, users.want_vegan_meal, floors.name AS floor, shifts.name AS shift, shifts.id AS shift_id, shifts.start_time, shifts.end_time');
        $this->db->from('users');
        $this->db->join('floors', 'users.floor_id = floors.id');
        $this->db->join('shifts', 'users.shift_id = shifts.id');
        $query = $this->db->get();
        return $query->result();
    }

    function get_users($perpage, $offset)
    {
        $this->db->select('users.id, users.email, users.first_name, users.last_name,
         users.what_taste, users.want_vegan_meal, users.admin, users.avatar_file_name, floors.name AS floor, floors.id AS floor_id, shifts.name AS shift, shifts.id AS shift_id, shifts.start_time, shifts.end_time');
        $this->db->from('users');
        $this->db->join('floors', 'users.floor_id = floors.id', 'left');
        $this->db->limit($perpage, $offset)->order_by('users.admin', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function get_num_of_users()
    {
        return $this->db->get('users')->num_rows();
    }

    function delete_user($user_id)
    {
         return $this->db->delete('users', array('id' => $user_id));
    }

    function get_user_by($field, $field_name)
    {
        $this->db->select('users.id, users.email, users.first_name, users.last_name,
         users.what_taste, users.want_vegan_meal, users.admin, users.avatar_content_file, users.avatar_file_name, users.authentication_token, users.encrypted_password, floors.name AS floor, floors.id AS floor_id, , shifts.name AS shift, shifts.id AS shift_id, shifts.start_time, shifts.end_time');
        $this->db->from('users');
        $this->db->join('floors', 'users.floor_id = floors.id', 'left');
        $this->db->join('shifts', 'users.shift_id = shifts.id', 'left');
        $this->db->where('users.'.$field, $field_name);
        $query = $this->db->get();
        return $query->first_row();
    }

    function get_user_with_no_floor_by($field, $field_name)
    {
        $this->db->select('users.*');
        $this->db->from('users');
        $this->db->where('users.'.$field, $field_name);
        $query = $this->db->get();
        return $query->first_row();
    }

    function edit_profile($data, $user_id)
    {
        if (!is_null($data['want_vegan_meal']))
        {
            $data['want_vegan_meal'] = ($data['want_vegan_meal'] == 'true') ? 1 : 0;
            $this->load->model('tables_model');
            if ($this->tables_model->delete_table_vegan_for_user($user_id)) $this->db->set('want_vegan_meal', $data['want_vegan_meal']);
        }
        if(!is_null($data['what_taste'])) $this->db->set('what_taste', $data['what_taste']);
        $this->db->where('id', $user_id);
        return $this->db->update('users');
    }

    function login($user, $login_admin = NULL)
    {
        $this->db->select('users.*, shifts.name AS shift, shifts.id AS shift_id, shifts.start_time, shifts.end_time');
        $this->db->from('users');
        $this->db->join('shifts', 'users.shift_id = shifts.id', 'left');
        $this->db->where('users.email', $user['email']);
        $query = $this->db->get();
        $result = $query->first_row();
        if (isset($result) && $this->bcrypt->check_password($user['password'], $result->encrypted_password))
        {
            if(!is_null($login_admin) && $result->admin == 1 || is_null($login_admin))
            {
                $this->load->library('encryption');
                $data['authentication_token'] = $this->encryption->encrypt(date('Ymd Hms') + $user['password']);
                $result->authentication_token = $data['authentication_token'];
                $this->db->where('id', $result->id);
                $this->db->update('users', $data);
                return [true, $result];
            }
            else return [false, null];
        }
        else
        {
            return [false, null];
        }
    }

    function change_password($user_id, $current_password, $new_password)
    {
        $this->load->library('encryption');
        $result = $this->db->get_where('users', array('id' => $user_id))->first_row();
        if (isset($result) && $this->bcrypt->check_password($current_password, $result->encrypted_password))
        {
            $new_password_hash = $this->bcrypt->hash_password($new_password);
            $authentication_token = $this->encryption->encrypt(date('Ymd Hms') + $new_password);
            $data = array(
                'encrypted_password'=> $new_password_hash,
                'authentication_token' => $authentication_token);
            $this->db->where('id', $user_id);
            return $this->db->update('users', $data);
        }
        else return FALSE;
    }

    function change_password_of_admin($user_id, $new_password)
    {
        $this->load->library('encryption');
        $new_password_hash = $this->bcrypt->hash_password($new_password);
        $authentication_token = $this->encryption->encrypt(date('Ymd Hms') + $new_password);
        $data = array(
            'encrypted_password'=> $new_password_hash,
            'authentication_token' => $authentication_token);
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    function authenticate($user)
    {
        if (!isset($user['tok']) || !isset($user['tok']))
        {
            return [false, null];
        }

        $result = $this->db->get_where('users', array('authentication_token' => $user['tok']))->first_row();
        if (isset($result) && $this->bcrypt->check_password($user['password'], $result->encrypted_password))
        {
            return [true, $result];
        }
        else
        {
            return [false, null];
        }
    }

    function destroy_token($user)
    {
        $user = $this->get_user_with_no_floor_by('email', $user['email']);
        if ($user != null)
        {
            $user->authentication_token = '';
            $this->db->replace('users',$user);
            return true;
        }
        else return false;
    }

    function insert_user($user)
    {
        $this->load->library('encryption');
        // Check user existed or not in db
        if (!$this->is_user_exists($user['email']))
        {
            $data = array(
                'email' => $user['email'],
                'encrypted_password' => $this->bcrypt->hash_password($user['password']),
                'authentication_token' => $this->encryption->encrypt(date('Ymd Hms') + $user['password']),
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'what_taste' => $user['what_taste'],
                'admin' => $user['role'],
                'avatar_file_name' => $user['avatar_file_name'],
                'avatar_content_file' => $user['avatar_content_file'],
                'want_vegan_meal' => $user['want_vegan_meal'],
                'floor_id' => $user['floor'],
                'reset_password_sent_at' => date('Y-m-d H:i:s'),
                'remember_created_at' => date('Y-m-d H:i:s'),
                'current_sign_in_at' => date('Y-m-d H:i:s'),
                'last_sign_in_at' => date('Y-m-d H:i:s'),
                'confirmation_sent_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'));

            $query = $this->db->insert('users', $data);
            if($query)
            {
                return [USER_CREATED_SUCCESSFULLY, $data];
            }
            else
            {
                return [USER_CREATE_FAILED, null];
            }
        }
        else
        {
            return [USER_ALREADY_EXISTED, null];
        }
    }

    function update_user($user_id, $user_data)
    {
        $data = array(
                'first_name' => $user_data['first_name'],
                'last_name' => $user_data['last_name'],
                'what_taste' => $user_data['what_taste'],
                'admin' => $user_data['role'],
                'avatar_file_name' => $user_data['avatar_file_name'],
                'avatar_content_file' => $user_data['avatar_content_file'],
                'want_vegan_meal' => $user_data['want_vegan_meal'],
                'floor_id' => $user_data['floor'],
                'updated_at' => date('Y-m-d H:i:s'));
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    function is_user_exists($email)
    {
        $query = $this->db->get_where('users', array('email' => $email));
        return $query->num_rows();
    }
}
