<?php
require(APPPATH.'controllers/Base_api.php');

class Votes_api extends Base_api {

    function __construct()
    {
        parent::__construct();
        $this->load->library('common');
        $this->load->model('votes_model');
    }

    /**
     * Listing all vote of dishes in a week
     * url: http://localhost/votes[?date=yyyy-mm-dd]
     * Method: GET
     * @param       date(y-m-d)  $date
     * @return      json
     */
    function votes_get()
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('votes_api',
            array('get_votes_success', 'get_votes_failure'));
        $date = $this->input->get('date');
        $result = $this->votes_model->get_all_dishes_with_votes_number_in_a_week((strtotime($date)) ? $date: NULL);
        $response = array();
        $dishes = array();
        if ($result != NULL)
        {
            foreach ($result as $temp)
            {
                $dish = array();
                $dish['id'] = (int)$temp->id;
                $dish['name'] = $temp->name;
                $dish['description'] = $temp->description;
                $dish['image'] = $temp->image;
                $dish['num_votes'] = isset($temp->num_votes) ? $temp->num_votes : 0;
                array_push($dishes, $dish);
            }
            $response['status'] = $messages_lang['success'];
            $response['message'] = $messages_lang['get_votes_success'];
            $response['data'] = $dishes;
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response['message'] = $messages_lang['get_votes_failure'];
        }
        $this->response($response, 200);
    }

    /**
     * Add vote for a dish in a week
     * url: http://localhost/vote
     * Method: POST
     * @param       int  $user_id
     * @param       array  $dishes_id
     * @return      json
     */
    function vote_post()
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('votes_api',
            array('vote_success', 'vote_failure', 'vote_over', 'vote_time'));
        $user_id = $this->post('user_id');
        $dishes_id = $this->post('dishes_id');
        $this->verify_required_params(array('user_id','dishes_id'));
        $response = array();
        $res = $this->votes_model->vote_for_dish_of_week($user_id, $dishes_id);
        switch ($res)
        {
            case ADD_VOTE_SUCCESSFULLY:
                $result = $this->votes_model->get_all_dishes_with_votes_number_in_a_week();
                $dishes = array();
                foreach ($result as $temp)
                {
                    if (0 != $temp->num_votes)
                    {
                        $dish = array();
                        $dish['id'] = (int)$temp->id;
                        $dish['name'] = $temp->name;
                        $dish['description'] = $temp->description;
                        $dish['image'] = $temp->image;
                        $dish['num_votes'] = $temp->num_votes;
                        array_push($dishes, $dish);
                    }
                }
                $response['status'] = $messages_lang['success'];
                $response['message'] = $messages_lang['vote_success'];
                $response['data'] = $dishes;
                break;
            case ADD_VOTE_FAIL:
                $response['status'] = $messages_lang['failure'];
                $response['message'] = $messages_lang['vote_failure'];
                break;
            case MAX_VOTES:
                $response['status'] = $messages_lang['failure'];
                $response['message'] = $messages_lang['vote_over'];
                break;
            case END_VOTING_TIME:
                $response['status'] = $messages_lang['failure'];
                $response['message'] = $messages_lang['vote_time'];
                break;
        }
        $this->response($response, 200);
    }

    /**
     * Count number of votes remainning of user for all dishes in a week
     * url: http://localhost/user/<user_id>/votes
     * Method: GET
     * @param       int  $user_id
     * @return      json
     */
    function count_vote_get($user_id)
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('votes_api',
            array('count_vote_success', 'count_vote_failure'));
        $result = $this->votes_model->count_votes_remaining_of_user_in_a_week($user_id);
        $response = array();
        if ($result >= 0)
        {
            $response['status'] = $messages_lang['success'];
            $response['message'] = $messages_lang['count_vote_success'];
            $user['num_votes_remaining'] = $result;
            $response['data'] = $user;
        }
        else
        {
            $response['status']= $messages_lang['failure'];
            $response['message'] = $messages_lang['count_vote_failure'];
        }
        $this->response($response, 200);
    }

    /**
     * Count number of vote from user for a dish in a week
     * url: http://localhost/user/<user_id>/vote_dishes
     * Method: GET
     * @param       int  $user_id
     * @return      json
     */
    function vote_dish_of_user_get($user_id)
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('votes_api',
            array('get_votes_of_user_success', 'get_votes_of_user_failure'));
        $result = $this->votes_model->get_all_favorite_dishes_with_votes_number_of_user($user_id);
        $response = array();
        $dishes = array();
        if ($result != NULL)
        {
            foreach ($result as $temp)
            {
                if (0 != $temp->num_votes)
                {
                    $dish = array();
                    $dish['id'] = (int)$temp->id;
                    $dish['name'] = $temp->name;
                    $dish['description'] = $temp->description;
                    $dish['image'] = $temp->image;
                    $dish['num_votes'] = $temp->num_votes;
                    array_push($dishes, $dish);
                }
            }
            $response['status'] = $messages_lang['success'];
            $response['message'] = $messages_lang['get_votes_of_user_success'];
            $response['data'] = $dishes;
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response['message'] = $messages_lang['get_votes_of_user_failure'];
        }
        $this->response($response, 200);
    }

}
