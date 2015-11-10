<?php
require(APPPATH.'controllers/Base_api.php');

class Tables_api extends BaseApi {

    /**
    * Listing all table
    * method GET
    * url: http://localhost/tables?for_vegans=
    */
    function tables_get()
    {
        $this->authenticate();
        $for_vegans = NULL;
        if (NULL != $this->input->get('for_vegans'))
        {
            $for_vegans = strtolower($this->input->get('for_vegans'));
        }
        $response = array();
        if (in_array($for_vegans, array("true", "false", "1", "0", NULL), true))
        {
            $this->load->model('tables_model');
            $result = $this->tables_model->get_all_tables($for_vegans);
            $tables = array();
            if ($result != NULL)
            {
                foreach ($result as $key => $temp)
                {
                    $table = array();
                    $table['id'] = (int)$temp->id;
                    $table['name'] = $temp->name;
                    $table['description'] = $temp->description;
                    $table['for_vegans'] = (bool)$temp->for_vegans;
                    $table['seats'] = (int)$temp->seats;
                    $table['available_seats'] = (int)$temp->available_seats;
                    $table['shift'] = $temp->shift;
                    $table['start_time'] = $temp->start_time;
                    $table['end_time'] = $temp->end_time;
                    $users = array();
                    $result = $this->tables_model->get_users_in_table($temp->id);
                    if ($result != NULL)
                    {
                        foreach ($result as $key => $temp)
                        {
                            $user = array();
                            $user['id'] = (int)$temp->id;
                            $user['email'] = $temp->email;
                            $user['first_name'] = $temp->first_name;
                            $user['last_name'] = $temp->last_name;
                            $user['want_vegan_meal'] = (boolean)$temp->want_vegan_meal;
                            $user['avatar_content_file'] = $temp->avatar_content_file;
                            array_push($users, $user);
                        }
                        $table['users'] = $users;
                    }
                    array_push($tables, $table);
                }
                $response['status'] = 'success';
                $response['message'] = str_replace("false", "normal ", str_replace("true", "vegan ", "Get all {$for_vegans}tables."));
                $response['data'] = $tables;
            }
            else
            {
                $response['status'] = 'failure';
                $response['message'] = 'Cannot get all tables';
            }
        }
        else
        {
            $response['status'] = 'failure';
            $response['message'] = "Your variable 'for_vegans' is not vaild";
        }
        $this->response($response, 200);
    }

    /**
    * Listing all user of table
    * method GET
    * url: http://localhost/tables/<number_of_table_id>/users
    */
    function users_of_table_get($table_id)
    {
        $this->authenticate();
        $this->load->model('tables_model');
        $result = $this->tables_model->get_users_in_table($table_id);
        $users = array();
        if ($result != NULL)
        {
            foreach ($result as $key => $temp)
            {
                $user = array();
                $user['id'] = (int)$temp->id;
                $user['email'] = $temp->email;
                $user['first_name'] = $temp->first_name;
                $user['last_name'] = $temp->last_name;
                $user['want_vegan_meal'] = (boolean)$temp->want_vegan_meal;
                $user['avatar_content_file'] = $temp->avatar_content_file;
                array_push($users, $user);
            }
            $response['status'] = 'success';
            $response['message'] = 'Get all users in table successfully';
            $response['data'] = $users;
        }
        else
        {
            $response['status'] = 'failure';
            $response['message'] = 'No have users in table';
        }
        // Respond with information about a user
        $this->response($response, 200);
    }

    /**
    * Listing all table of shift
    * method GET
    * url: http://localhost/shift/<number_of_shift>/tables
    */
    function tables_of_shift_get($shift_id)
    {
        $this->authenticate();
        $for_vegans = NULL;
        if (NULL != $this->input->get('for_vegans'))
        {
            $for_vegans = strtolower($this->input->get('for_vegans'));
        }
        $this->load->model('tables_model');
        $result = $this->tables_model->get_tables_by_shift($shift_id, $for_vegans);
        $tables = array();
        $response = array();
        if ($result != NULL)
        {
            foreach ($result as $key => $temp)
            {
                $table = array();
                $table['id'] = (int)$temp->id;
                $table['name'] = $temp->name;
                $table['for_vegans'] = (boolean)$temp->for_vegans;
                $table['description'] = $temp->description;
                $table['seats'] = (int)$temp->seats;
                $table['available_seats'] = (int)$temp->available_seats;
                $table['shift_id'] = (int)$temp->shift_id;
                $table['shift'] = $temp->shift;
                $table['start_time'] = $temp->start_time;
                $table['end_time'] = $temp->end_time;
                $users = array();
                $result = $this->tables_model->get_users_in_table($temp->id);
                if ($result != NULL)
                {
                    foreach ($result as $key => $temp)
                    {
                        $user = array();
                        $user['id'] = (int)$temp->id;
                        $user['email'] = $temp->email;
                        $user['first_name'] = $temp->first_name;
                        $user['last_name'] = $temp->last_name;
                        $user['want_vegan_meal'] = (boolean)$temp->want_vegan_meal;
                        $user['avatar_content_file'] = $temp->avatar_content_file;
                        array_push($users, $user);
                    }
                    $table['users'] = $users;
                    }
                array_push($tables, $table);
            }
            $response['status'] = 'success';
            $response['message'] = 'Get all tables of shift successfully';
            $response['data'] = $tables;
        }
        else
        {
            $response['status'] = 'failure';
            $response['message'] = 'Cannot get all tables of shift';
        }
        $this->response($response, 200);
    }

    /**
    * Add user in a table
    * method POST
    * url: http://localhost/seat
    */
    function seat_post()
    {
        $this->authenticate();
        $response = array();
        $user_id = $this->post('user_id');
        $table_id = $this->post('table_id');
        $this->verify_required_params(array('user_id', 'table_id'));
        if (is_numeric($user_id) AND is_numeric($table_id))
        {
            $this->load->model('tables_model');
            $res = $this->tables_model->set_table_for_user($user_id, $table_id);
            switch ($res) {
                case SET_NEW_SEAT_FOR_USER:
                    $response['status'] = 'success';
                    $response['message'] = 'Have set new seat in this table successfully';
                    break;
                case CANNOT_SET_SEAT_FOR_USER:
                    $response['status'] = 'failure';
                    $response['message'] = 'You cannot set a seat in this table';
                    break;
                case USER_HAVE_ENOUGH_SEAT_IN_TABLE:
                    $response['status'] = 'failure';
                    $response['message'] = 'You have enough seat in table';
                    break;
                case HAVE_NO_AVAILABLE_SEAT:
                    $response['status'] = 'failure';
                    $response['message'] = 'Have no seat available in this table';
                    break;
                default:
                    $response['status'] = 'failure';
                    $response['message'] = 'An error occurred. Please try again';
                    break;
            }
        }
        else
        {
            $response['status'] = 'failure';
            $response['message'] = "Your variable 'user_id' or 'table_id' is not vaild";
        }
        $this->response($response, 200);
    }

    /**
    * Change user in a table to another one
    * method PUT
    * url: http://localhost/seat
    */
    function seat_put()
    {
        $this->authenticate();
        $response = array();
        $user_id = $this->put('user_id');
        $table_id = $this->put('table_id');
        $new_table_id = $this->put('new_table_id');
        $this->verify_required_params(array('user_id', 'table_id', 'new_table_id'));
        if (is_numeric($user_id) AND is_numeric($table_id) AND is_numeric($new_table_id))
        {
            $this->load->model('tables_model');
            $res = $this->tables_model->change_table_for_user($user_id, $table_id, $new_table_id);
            switch ($res) {
                case SET_NEW_SEAT_FOR_USER:
                    $response['status'] = 'success';
                    $response['message'] = 'You have changed new seat in this table successfully';
                    break;
                case CANNOT_SET_SEAT_FOR_USER:
                    $response['status'] = 'failure';
                    $response['message'] = 'You cannot change a seat in this table';
                    break;
                case HAVE_SEAT_IN_THIS_TABLE:
                    $response['status'] = 'failure';
                    $response['message'] = 'You have a seat in this table already';
                    break;
                case NO_BELONGS_TO_THIS_TABLE:
                    $response['status'] = 'failure';
                    $response['message'] = 'You don\'t belong to this table';
                    break;
                case HAVE_NO_AVAILABLE_SEAT:
                    $response['status'] = 'failure';
                    $response['message'] = 'Have no seat available in this table you want to change';
                    break;
                default:
                    $response['status'] = 'failure';
                    $response['message'] = 'An error occurred. Please try again';
                break;
            }
        }
        else
        {
            $response['status'] = 'failure';
            $response['message'] = "Your variable 'user_id' or 'table_id' or 'new_table_id' is not vaild";
        }
        $this->response($response, 200);
    }

    /**
    * Delete seat in table for user
    * method DELETE
    * url: http://localhost/seat?user_id=<number_of_user_id>&table_id=<number_of_table_id>
    */
    function seat_delete()
    {
        $this->authenticate();
        $response = array();
        $user_id = $this->input->get('user_id');
        $table_id = $this->input->get('table_id');
        if (is_numeric($user_id) AND is_numeric($table_id))
        {
            $this->load->model('tables_model');
            $res = $this->tables_model->cancel_seat_in_table_for_user($user_id, $table_id);
            switch ($res) {
                case DELETE_SEAT_FOR_USER_SUCCESSFULLY:
                    $response['status'] = 'success';
                    $response['message'] = 'You have deleted your seat in table successfully';
                    break;
                case DELETE_SEAT_FOR_USER_FAIL:
                    $response['status'] = 'failure';
                    $response['message'] = 'You cannot delete a seat of you in this table';
                    break;
                case NO_BELONGS_TO_THIS_TABLE:
                    $response['status'] = 'failure';
                    $response['message'] = 'You cannot delete this seat because you don\'t belong to this table';
                    break;
            }
        }
        else
        {
            $response['status'] = 'failure';
            $response['message'] = "Your variable 'user_id' or 'table_id' is not vaild";
        }
        $this->response($response, 200);
    }
}