<?php
require(APPPATH.'controllers/Base_api.php');

class Tracking_users_api extends Base_api {

    function __construct()
    {
        parent::__construct();
        $this->load->library('common');
        $this->load->model('tracking_users_model');
    }

    /**
     * Update status of user
     * url: http://localhost/user/<user_id>/tracking
     * Method: POST
     * @param       int  $user_id
     * @param       string  $is_available
     * @return      json
     */
    function tracking_user_put($user_id)
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('tracking_users_api',
            array('tracking_user_success', 'tracking_user_failure'));
        $response = array();
        $this->verify_required_params(array('is_available'));
        $status = $this->put('is_available');
        $result = $this->tracking_users_model->check_time_update_user($user_id, ATTEND);
        if ($result)
        {
            $response['status'] = $messages_lang['success'];
            $response['message'] = $messages_lang['tracking_user_success'];
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response['message'] = $messages_lang['tracking_user_failure'];
        }
        $this->response($response, 200);
    }
}