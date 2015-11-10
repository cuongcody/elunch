<?php
require(APPPATH.'controllers/Base_api.php');

class Votes_api extends BaseApi {

    /**
    * Listing all vote of dishes in a week
    * method GET
    * url: http://localhost/votes[?date=yyyy-mm-dd]
    */
    function votes_get()
    {
        $this->authenticate();
        $this->load->model('votes_model');
        $date = $this->input->get('date');
        $result = $this->votes_model->get_all_dishes_with_votes_number_in_a_week((strtotime($date)) ? $date: NULL);
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
            $response['status'] = 'success';
            $response['message'] = 'List all dishes with num_votes in next week';
            $response['data'] = $dishes;
        }
        else
        {
            $response['status'] = 'failure';
            $response['message'] = 'Cannot get all dishes';
        }
        $this->response($response, 200);
    }
    /**
    * Add vote for a dish in a week
    * method POST
    * url: http://localhost/vote
    */
    function vote_post()
    {
        $this->authenticate();
        $user_id = $this->post('user_id');
        $dishes_id = $this->post('dishes_id');
        $this->verify_required_params(array('user_id','dishes_id'));
        if (!is_numeric($user_id))
        {
            $response['status'] = 'failure';
            $response['message'] = "Your variable 'user_id' not vaild";
        }
        $this->load->model('votes_model');
        $res = $this->votes_model->vote_for_dish_of_week($user_id, $dishes_id);
        switch ($res) {
            case ADD_VOTE_SUCCESSFULLY:
                $response['status'] = 'success';
                $response['message'] = 'You voted for this dish successfully';
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
                $response['data'] = $dishes;
                break;
            case ADD_VOTE_FAIL:
                $response['status'] = 'failure';
                $response['message'] = 'You voted fail';
                break;
            case MAX_VOTES:
            $response['status'] = 'failure';
            $response['message'] = 'You cannot voted more than 5 dishes.';
            break;
        }
        $this->response($response, 200);
    }
    /**
    * Delete vote for a dish in a week
    * method DELETE
    * url: http://localhost/vote?user_id=<number_of_user_id>&dish_id=<number_of_dish_id>
    */
    function vote_delete()
    {
        $this->authenticate();
        $user_id = $this->input->get('user_id');
        $dish_id = $this->input->get('dish_id');
        if (!is_numeric($user_id) OR !is_numeric($dish_id))
        {
            $response['status'] = 'failure';
            $response['message'] = "Your variable 'user_id' or 'dish_id' not vaild";
        }
        else
        {
            $this->load->model('votes_model');
            $res = $this->votes_model->remove_vote_for_dish_of_week($user_id, $dish_id);
            switch ($res) {
                case REMOVE_VOTE_SUCCESSFULLY:
                    $response['status'] = 'success';
                    $response['message'] = 'You remove for this dish successfully';
                    break;
                case REMOVE_VOTE_FAIL:
                    $response['status'] = 'failure';
                    $response['message'] = 'You remove voted fail';
                    break;
                case NO_VOTE_THIS_DISH:
                $response['status'] = 'failure';
                $response['message'] = 'You did not vote for this dish';
                break;
            }
        }
        $this->response($response, 200);
    }
    /**
    * Count number of votes remainning of user for all dishes in a week
    * method GET
    * url: http://localhost/user/<user_id>/votes
    */
    function count_vote_get($user_id)
    {
        $this->authenticate();
        $this->load->model('votes_model');
        $result = $this->votes_model->count_votes_remaining_of_user_in_a_week($user_id);
        $response = array();
        if ($result >= 0)
        {
            $response['status'] = 'success';
            $response['message'] = 'Number of votes remaining from user';
            $user['num_votes_remaining'] = $result;
            $response['data'] = $user;
        }
        else
        {
            $response['status']= 'failure';
            $response['message'] = 'Cannot count votes remaining from user';
        }
        $this->response($response, 200);
    }
    /**
    * Count number of vote from user for a dish in a week
    * method GET
    * url: http://localhost/user/<user_id>/vote_dishes
    */
    function vote_dish_of_user_get($user_id)
    {
        $this->authenticate();
        $this->load->model('votes_model');
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
            $response['status'] = 'success';
            $response['message'] = 'List all dishes from user with num_votes in next week';
            $response['data'] = $dishes;
        }
        else
        {
            $response['status'] = 'failure';
            $response['message'] = 'Cannot get all dishes from user';
        }
        $this->response($response, 200);
    }

    public function check_get()
    {
        $this->load->model('votes_model');
        $response = $this->votes_model->is_end_of_voting_time();
        $this->response($response, 200);
    }

}
