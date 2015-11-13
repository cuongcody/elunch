<?php
require(APPPATH.'controllers/Base_api.php');

class Tables_api extends Base_api {

    function __construct()
    {
        parent::__construct();
        $this->load->library('common');
        $this->load->model('tables_model');
    }

    /**
     * Listing all tables of shift
     * url: http://localhost/shift/<number_of_shift>/tables?[for_vegans=]
     * Method: GET
     * @param       int  $shift_id
     * @param       int  $for_vegans
     * @return      json
     */
    function tables_of_shift_get($shift_id)
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('tables_api',
            array('get_tables_of_shift_success', 'get_tables_of_shift_failure', 'variables_not_valid'));
        $for_vegans = NULL;
        $day = NULL;
        if (NULL != $this->input->get('for_vegans'))
        {
            $for_vegans = strtolower($this->input->get('for_vegans'));
        }
        if ($for_vegans == 'true')
        {
            $day = $for_vegans = VEGAN_DAY;
        }
        else if ($for_vegans == 'false')
        {
            $day = $for_vegans = NORMAL_DAY;
        }
        $result = $this->tables_model->get_tables_by_shift($shift_id, $for_vegans, $day);
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
                $table['available_seats'] = (int)$temp->seats - (int)$temp->occupied_seats;
                $table['shift_id'] = (int)$temp->shift_id;
                $table['shift'] = $temp->shift;
                $table['start_time'] = $temp->start_time;
                $table['end_time'] = $temp->end_time;
                $users = array();
                $result = $this->tables_model->get_users_in_table($temp->id, $day);
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
            $response['status'] = $messages_lang['success'];
            $response['message'] = $messages_lang['get_tables_of_shift_success'];
            $response['data'] = $tables;
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response['message'] = $messages_lang['get_tables_of_shift_failure'];
        }
        $this->response($response, 200);
    }

    /**
     * Join in table
     * url: http://localhost/seat
     * Method: POST
     * @param       int  $user_id
     * @param       int  $table_id
     * @return      json
     */
    function seat_post()
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('tables_api',
            array('join_table_success', 'join_table_failure', 'have_table', 'variables_not_valid'));
        $response = array();
        $user_id = $this->post('user_id');
        $table_id = $this->post('table_id');
        $this->verify_required_params(array('user_id', 'table_id'));
        if (is_numeric($user_id) AND is_numeric($table_id))
        {
            $result = $this->tables_model->set_table_for_user($user_id, $table_id);
            switch ($result)
            {
                case JOIN_TABLE_SUCCESSFULLY:
                    $response['status'] = $messages_lang['success'];
                    $response['message'] = $messages_lang['join_table_success'];
                    break;
                case JOIN_TABLE_FAILED:
                    $response['status'] = $messages_lang['failure'];
                    $response['message'] = $messages_lang['join_table_failure'];
                    break;
                case HAVE_SEAT_IN_TABLE:
                    $response['status'] = $messages_lang['failure'];
                    $response['message'] = $messages_lang['have_table'];
                    break;
            }
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response['message'] = $messages_lang['variables_not_valid'];
        }
        $this->response($response, 200);
    }

    /**
     * Leave table
     * url: http://localhost/seat?user_id=<number_of_user_id>&table_id=<number_of_table_id>
     * Method: DELETE
     * @param       int  $user_id
     * @param       int  $table_id
     * @return      json
     */
    function seat_delete()
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('tables_api',
            array('leave_table_success', 'leave_table_failure', 'no_table', 'variables_not_valid'));
        $response = array();
        $user_id = $this->input->get('user_id');
        $table_id = $this->input->get('table_id');
        if (is_numeric($user_id) AND is_numeric($table_id))
        {
            $result = $this->tables_model->user_leave_table($user_id, $table_id, NULL);
            switch ($result)
            {
                case LEAVE_TABLE_SUCCESSFULLY:
                    $response['status'] = $messages_lang['success'];
                    $response['message'] = $messages_lang['leave_table_success'];
                    break;
                case LEAVE_TABLE_FAILED:
                    $response['status'] = $messages_lang['failure'];
                    $response['message'] = $messages_lang['leave_table_failure'];
                    break;
                case NO_SEAT_IN_TABLE:
                    $response['status'] = $messages_lang['failure'];
                    $response['message'] = $messages_lang['no_table'];
                    break;
            }
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response['message'] = $messages_lang['variables_not_valid'];
        }
        $this->response($response, 200);
    }
}