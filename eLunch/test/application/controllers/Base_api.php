<?php

require(APPPATH.'libraries/REST_Controller.php');

class BaseApi extends REST_Controller{
    public $current_user = null;

    function authenticate()
    {
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
                $response['status'] = 'failure';
                $response["message"] = "Invalid Credential.";
                $this->response($response, 200);
            }
            else
            {
                $response['status'] = 'success';
                $response["message"] = "Authorized.";
                global $current_user;
                $current_user = $loggin_user;
            }
        }
        else
        {
            $response['status'] = 'failure';
            $response["message"] = "Not authorized.";
            $this->response($response, 200);
        }
    }

    function destroy()
    {
        $headers = apache_request_headers();
        $response = array();
        if (isset($headers['Authorization']))
        {
            $token = explode(" ", $headers['Authorization']);
            $this->load->model('users_model');
            $result = $this->jwt->decode($token[1], $this->config->item("secret_key"));
            if ($this->users_model->destroy_token((array)$result))
            {
                $response['status'] = 'success';
                $response['message'] = 'Logout successfully';
            }
            else
            {
                $response['status'] = 'failure';
                $response["message"] = "Unexpected error.";
            }
        }
        else
        {
            $response['status'] = 'failure';
            $response["message"] = "Not Authorized.";
        }
        $this->response($response, 200);
    }

    /**
     * Verifying required params posted or not
     */
    function verify_required_params($required_fields)
    {
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
            $response['status']='failure';
            $response['message'] = 'Required field(s) '.substr($error_fields, 0, -2).' is missing or empty';
            $this->response($response, 200);
        }
    }
}
