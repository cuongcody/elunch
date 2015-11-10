<?php
require(APPPATH.'libraries/REST_Controller.php');
 
class Api extends REST_Controller {

    public $user_id = NULL;

    function authenticate()
    {
        $headers = apache_request_headers();
        $response = array();
        if(isset($headers['authen']))
        {
            $apiKey = $headers['authen'];
            $this->load->model('users_model');
            if(!$this->users_model->isValidApiKey($apiKey))
            {
                $response["message"] = "ApiKey Invaild";
                $this->response($response,403);
            }
            else
            {
                global $user_id;
                $user_id = $this->users_model->getUserId($apiKey);
            }
        }
        else
        {
            $response["message"] = "ApiKey is missing";
            $this->response($response,403);
        }
    }

    /**
    * Listing all user
    * method GET
    * url: http://localhost/api/users          
    */
    function users_get()
    {
        $this->authenticate();
        $response = array();
        $this->load->model('users_model');
        $users = $this->users_model->getAllUsers();
        // respond with information about a user
        $this->response($users,200);
    }
    
     
    /**
    * Get infomation user by id
    * method GET
    * url: http://localhost/api/user/id/$id         
    */
    function user_get()
    {
        $this->authenticate();
        $id = $this->get('id');
        $response = array();
        $this->load->model('users_model');
        $user = $this->users_model->getUserByField('id',$id);
        $this->response($user,200);
    }

    /**
    * User Login
    * url: http://localhost/api/login
    * method - POST
    * params - email, password
    */
    function login_post()
    {
        //check for required params
        $this->verifyRequiredParams(array('email','password'));
        //reading post params
        $email = $this->post('email');
        $password = $this->post('password');

        //check for validate Email
        $this->validateEmail($email);

        $response = array();
        $this->load->model('users_model');
        
        $check_login = $this->users_model->checkLogin(array(
            'email' => $this->post('email'),
            'password' => $this->post('password')));

        if($check_login)
        {
            if($this->users_model->setApiKeyforUser($email))
            {
                //get user by email
                $user = $this->users_model->getUserByField('email',$email);
                //echo json
                $response['message'] = "Login successfully";
                $response['email'] = $user->email;
                $response['apiKey'] = $user->authentication_token;
                $response['first_name'] = $user->first_name;
                $response['last_name'] = $user->last_name;
                $response['created_at'] = $user->created_at;
                $response['updated_at'] = $user->updated_at;
                $this->response($response,200);
            }
            else
            {
                $response['message'] = "Login failed. Cannot set api Key for this user";
                $this->response($response,401);
            }
            

        }
        else
        {
            $response['message'] = "Logout failed. Invaild ApiKey";
            $this->response($response,401);
        }
        
    }
    /**
    * User Logout
    * url: http://localhost/api/logout
    * method - POST
    */
    function logout_get()
    {
        $this->authenticate();
        $response = array();
        $this->load->model('users_model');
        global $user_id;
        if($this->users_model->isLogout($user_id))
        {
            $response['message'] = "Logout successfully";
            $this->response($response,200);
        }
        else
        {
            $response['message'] = "Logout fail";
            $this->response($response,401);
        }
        

    }
    /**
    * User Registration
    * url: http://localhost/api/register
    * method - POST
    * params - name, email, password
    */
    function register_post()
    {
        //check for required params
        $this->verifyRequiredParams(array('email','password','first_name','last_name'));

        //reading post params
        $email = $this->post('email');
        $password = $this->post('password');
        $first_name = $this->post('first_name');
        $last_name = $this->post('last_name');

        //check for validate Email
        $this->validateEmail($email);

        $response= array();
        $this->load->model('users_model');
        $check_register = $this->users_model->storeUser(array(
            'email' => $email,
            'password' => $password,
            'first_name' => $first_name,
            'last_name' => $last_name
            ));
        if($check_register == USER_CREATED_SUCCESSFULLY)
        {
            $response['message'] = 'You are successfully registered';
            $this->response($response,201);
        }
        elseif($check_register == USER_ALREADY_EXISTED)
        {
            $response['message'] = 'Sorry, this email already existed';
            $this->response($response,401);
        }
        elseif($check_register == USER_CREATE_FAILED)
        {
            $response['error'] = true;
            $response['message'] = 'An error occurred while registereing';
            $this->response($response,401);
        }
        

    }
    
    function verifyRequiredParams($required_fields)
    {
        $error = false;
        $error_fields = "";
        $request_params = array();
        $request_params = $_REQUEST;
        foreach ($required_fields as $field)
        {
            if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0)
            {
                $error = true;
                $error_fields .= $field . ', ';
            }
        }
        if ($error)
        {
            // Required field(s) are missing or empty
            // echo error json 
            $response = array();
            $response["error"] = true;
            $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
            $this->response($response,400);
            return false;
        }
    }

    /**
    * Validating email address
    */
    function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $response["error"] = true;
            $response["message"] = 'Email address is not valid';
            $this->response($response,400);
            return false;
        }
    }
}
