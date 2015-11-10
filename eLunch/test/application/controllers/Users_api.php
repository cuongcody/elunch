<?php
require(APPPATH.'controllers/Base_api.php');

class Users_api extends BaseApi {

    /**
    * Listing all user
    * method GET
    * url: http://localhost/users
    */
    function users_get()
    {
        $this->authenticate();
        $response = array();
        $this->load->model('users_model');
        $result = $this->users_model->get_all_users();
        $users = array();
        if ($result != NULL)
        {
            foreach ($result as $key => $temp) {
                $user = array();
                $user['id'] = (int)$temp->id;
                $user['email'] = $temp->email;
                $user['first_name'] = $temp->first_name;
                $user['last_name'] = $temp->last_name;
                $user['want_vegan_meal'] = (boolean)$temp->want_vegan_meal;
                $user['floor'] = $temp->floor;
                $user['what_taste'] = $temp->what_taste;
                array_push($users, $user);
            }
            $response['status'] = 'success';
            $response['message'] = 'Get all users successfully';
            $response['data'] = $users;
        }
        else
        {
            $response['status'] = 'failure';
            $response['message'] = 'Cannot get all users';
        }
        // Respond with information about a user
        $this->response($response, 200);
    }

    /**
    * Get infomation user by id
    * method GET
    * url: http://localhost/user/<number_of_user_id>
    */
    function user_get($id)
    {
        $this->authenticate();
        $response = array();
        $this->load->model('users_model');
        $result = $this->users_model->get_user_by('id', $id);
        if ($result != NULL)
        {
            $response['status'] = 'success';
            $response['message'] = 'Get user successfully';
            $user['id'] = (int)$result->id;
            $user['email'] = $result->email;
            $user['first_name'] = $result->first_name;
            $user['last_name'] = $result->last_name;
            $user['avatar_content_file'] = $result->avatar_content_file;
            $user['want_vegan_meal'] = (boolean)$result->want_vegan_meal;
            $user['floor'] = $result->floor;
            $user['shift_id'] = (int)$result->shift_id;
            $user['shift'] = $result->shift;
            $user['start_time'] = $result->start_time;
            $user['end_time'] = $result->end_time;
            $user['max_votes'] = MAX_VOTES_FOR_USER;
            $user['what_taste'] = $result->what_taste;
            $response['data'] = $user;
        }
        else
        {
            $response['status'] = 'failure';
            $response['message'] = 'Cannot get user';
        }
        // Respond with information about a user
        $this->response($response, 200);
    }

    function user_put($user_id)
    {
        $this->authenticate();
        $data = array();
        $data['want_vegan_meal'] = (!is_null($this->put('want_vegan_meal'))) ? $this->put('want_vegan_meal') : NULL;
        $data['what_taste'] = (!is_null($this->put('what_taste'))) ? $this->put('what_taste') : NULL;
        $this->load->model('users_model');
        $result = $this->users_model->edit_profile($data, $user_id);
        if ($result == TRUE)
        {
            $response['status'] = 'success';
            $response['message'] = 'Edit profile successfully';
        }
        else
        {
            $response['status'] = 'failure';
            $response['message'] = 'Cannot edit profile ';
        }
        $this->response($response, 200);
    }

    /**
    * User Login
    * url: http://localhost/login
    * method - POST
    * params - email, password
    */
    function login_post()
    {
        // Check for required params
        $this->verify_required_params(array('email', 'password'));
        // Reading post params
        $email = $this->post('email');
        $password = $this->post('password');
        // Check for validate Email
        $this->validate_email($email);
        $response = array();
        $this->load->model('users_model');
        $issue_at = time();
        list($check_login, $result) = $this->users_model->login(array(
            'email' => $this->post('email'),
            'password' => $this->post('password')));
        if($check_login)
        {
            $user['id'] = (int)$result->id;
            $user['authentication_token'] = $this->jwt->encode(array(
                                'iat' => $issue_at,
                                'nbf' => $issue_at + 10,
                                'exp' => $issue_at + 172800,
                                'tok' => $result->authentication_token,
                                'email' => $email,
                                'password' => $password
                                ), $this->config->item("secret_key"));
            $user['email'] = $result->email;
            $user['first_name'] = $result->first_name;
            $user['last_name'] = $result->last_name;
            $user['want_vegan_meal'] = (boolean)$result->want_vegan_meal;
            $user['avatar_content_file'] = $result->avatar_content_file;
            $user['shift_id'] = (int)$result->shift_id;
            $user['shift'] = $result->shift;
            $user['start_time'] = $result->start_time;
            $user['end_time'] = $result->end_time;
            $user['max_votes'] = MAX_VOTES_FOR_USER;
            // Response
            $response['status'] = 'success';
            $response['message'] = 'Login successfully';
            $response['data'] = $user;
        }
        else
        {
            $response['status'] = 'failure';
            $response['message'] = "Incorrect email or password";
        }
        $this->response($response, 200);
    }

    /**
    * User Logout
    * url: http://localhost/logout
    * method - POST
    */
    function logout_post()
    {
        $this->destroy();
    }

    /**
    * User Registration
    * url: http://localhost/register
    * method - POST
    * params - name, email, password
    */
    function register_post()
    {
        // Check for required params
        $this->verify_required_params(array('email', 'password', 'confirm_password', 'first_name', 'last_name'));
        // Reading post params
        $email = $this->post('email');
        $password = $this->post('password');
        $first_name = $this->post('first_name');
        $last_name = $this->post('last_name');
        // Check for validate Email
        $this->validate_email($email);
        $response= array();
        $this->load->model('users_model');
        list($check_register, $result) = $this->users_model->insert_user(array(
            'email' => $email,
            'password' => $password,
            'first_name' => $first_name,
            'last_name' => $last_name
            ));
        if($check_register == USER_CREATED_SUCCESSFULLY)
        {
            $issue_at = time();
            $user['authentication_token'] = $this->jwt->encode(array(
                                    'iat' => $issue_at,
                                    'nbf' => $issue_at + 10,
                                    'exp' => $issue_at + 172800,
                                    'email' => $email,
                                    'tok' => $result['authentication_token'],
                                    'password' => $password
                                    ), $this->config->item("secret_key"));
            $user['email'] = $result['email'];
            $user['first_name'] = $result['first_name'];
            $user['last_name'] = $result['last_name'];
            $response['status'] = 'success';
            $response['message'] = 'Register successfully';
            $response['data'] = $user;
        }
        elseif($check_register == USER_ALREADY_EXISTED)
        {
            $response['status'] = 'failure';
            $response['message'] = 'Sorry, this email already existed';
        }
        elseif($check_register == USER_CREATE_FAILED)
        {
            $response['status'] = 'failure';
            $response['message'] = 'An error occurred while registereing';
        }
        $this->response($response, 200);
    }
    /**
    * Change password of user
    * url: http://localhost/change_password
    * method - POST
    * params - name, email, password
    */
    function change_password_put()
    {
        $this->authenticate();
        $user_id = $this->put('user_id');
        $current_password = $this->put('current_password');
        $new_password = $this->put('new_password');
        $confirm_new_password = $this->put('confirm_new_password');
        $this->verify_required_params(array('user_id', 'current_password','new_password','confirm_new_password'));
        $response= array();
        if ($new_password != $confirm_new_password)
        {
            $response['status'] = 'failure';
            $response['message'] = 'Not match password';
        }
        else
        {
            $this->load->model('users_model');
            $res = $this->users_model->change_password($user_id, $current_password, $new_password);
            if ($res == TRUE)
            {
                $result = $this->users_model->get_user_by('id', $user_id);
                $issue_at = time();
                $user['authentication_token'] = $this->jwt->encode(array(
                                    'iat' => $issue_at,
                                    'nbf' => $issue_at + 10,
                                    'exp' => $issue_at + 172800,
                                    'email' => $result->email,
                                    'tok' => $result->authentication_token,
                                    'password' => $new_password
                                    ), $this->config->item("secret_key"));
                $response['status'] = 'success';
                $response['message'] = 'Change password successfully';
                $response['data'] = $user;
            }
            else
            {
                $response['status'] = 'failure';
                $response['message'] = 'You cannot change password. Maybe incorrect password. Please check again';
            }
        }
        $this->response($response, 200);
    }

    /**
    * Validating email address
    */
    function validate_email($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $response["status"] = 'failure';
            $response["message"] = 'Email address is not valid';
            $this->response($response, 200);
            return false;
        }
    }
}
