<?php

require(APPPATH.'libraries/REST_Controller.php');

class Base_api extends REST_Controller{
    public $current_user = null;
    public $messages_lang;

    function __construct()
    {
        parent::__construct();
        $this->load->library('common');
        global $messages_lang;
        $messages_lang = $this->common->set_language_for_server_api('base_api',
            array('missing_fields', 'invalid_credential', 'authorized', 'not_authorized',
                'logout_success', 'logout_failure', 'unexpected_errors'));
    }

    function authenticate()
    {
        global $messages_lang;
        $headers = apache_request_headers();
        $response = array();
        if(isset($headers['Authorization']))
        {
            $token = explode(" ", $headers['Authorization']);
            $this->load->model('users_model');
            $result = $this->jwt->decode($token[1], $this->config->item("secret_key"));
            list($check_login, $loggin_user) = $this->users_model->authenticate((array)$result);
            if(!$check_login)
            {
                $response['status'] = $messages_lang['failure'];
                $response["message"] = $messages_lang['invalid_credential'];
                $this->response($response, 401);
            }
            else
            {
                $response['status'] = $messages_lang['success'];
                $response["message"] = $messages_lang['authorized'];
                global $current_user;
                $current_user = $loggin_user;
            }
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response["message"] = $messages_lang['not_authorized'];
            $this->response($response, 401);
        }
    }

    function destroy()
    {
        global $messages_lang;
        $headers = apache_request_headers();
        $response = array();
        if (isset($headers['Authorization']))
        {
            $token = explode(" ", $headers['Authorization']);
            $this->load->model('users_model');
            $result = $this->jwt->decode($token[1], $this->config->item("secret_key"));
            if ($this->users_model->destroy_token((array)$result))
            {
                $response['status'] = $messages_lang['success'];
                $response['message'] = $messages_lang['logout_success'];
            }
            else
            {
                $response['status'] = $messages_lang['failure'];
                $response["message"] = $messages_lang['unexpected_errors'];
            }
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response["message"] = $messages_lang['logout_failure'];
        }
        $this->response($response, 200);
    }

    /**
     * Verifying required params posted or not
     */
    function verify_required_params($required_fields)
    {
        global $messages_lang;
        $error = FALSE;
        $error_fields = "";
        $request_params = array();
        $request_params = $_REQUEST;
        // Handling PUT request params
        foreach ($required_fields as $field)
        {
            if ($_SERVER['REQUEST_METHOD'] == 'PUT')
            {
                if (NULL == $this->put($field) OR strlen(trim($this->put($field))) <= 0)
                {
                    $error = TRUE;
                    $error_fields .= $field.', ';
                }
            }
            elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE')
            {
                if (NULL == $this->delete($field) OR strlen(trim($this->delete($field))) <= 0)
                {
                    $error = TRUE;
                    $error_fields .= $field.', ';
                }
            }
            elseif (!isset($request_params[$field]) OR strlen(trim($request_params[$field])) <= 0)
            {
                $error = TRUE;
                $error_fields .= $field.', ';
            }
        }
        if ($error)
        {
            // Required field(s) are missing or empty
            $response = array();
            $response['status']= $messages_lang['failure'];
            $response['message'] = $messages_lang['missing_fields'].substr($error_fields, 0, -2);
            $this->response($response, 200);
        }
    }
}
