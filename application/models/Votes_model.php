<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Votes_model extends CI_Model {

    /**
     * Get all dishes with votes in a week
     *
     * @param       date(Y-m-d)  $day
     * @return      array
     */
    function get_all_dishes_with_votes_number_in_a_week($day = NULL)
    {
        $this->load->model('dishes_model');
        $result_dishes = $this->dishes_model->get_all_dishes();
        $dishes = array();
        $first_day_of_week = $this->find_first_date_of_week($day);
        $query = $this->db->get_where('vote_logs', array('first_day_of_week' => $first_day_of_week));
        $result = $query->result();
        if ($result != NULL)
        {
            $voted_dish_ids_in_week = "";
            $voted_dish_ids_in_week_arr = array();
            $num_votes = 0;
            foreach ($result as $value)
            {
                $voted_dish_ids_in_week.=$value->votes;
            }
            $voted_dish_ids_in_week_arr = (substr_count($voted_dish_ids_in_week, ';') > 0) ? explode(";", $voted_dish_ids_in_week) : array($voted_dish_ids_in_week);
            $last_day_of_week = $this->find_last_date_of_week($day);
            $counts_value_in_voted_dish_ids = array_count_values($voted_dish_ids_in_week_arr);
            foreach ($result_dishes as $dish)
            {
                $num_votes = 0;
                // Count dish_id have in voted dish ids in week or not
                if (in_array($dish->id, $voted_dish_ids_in_week_arr))
                {
                    $num_votes = $counts_value_in_voted_dish_ids[$dish->id];
                }
                $dish->num_votes = $num_votes;
                // Push dish in array $dishes
                array_push($dishes, $dish);
            }
            usort($dishes, array($this,"compared_by_num_votes"));
        }
        else $dishes = (array)$result_dishes;
        return $dishes;
    }

    /**
     * Get all favorite dishes with votes in a week
     *
     * @param       int  $user_id
     * @return      array
     */
    function get_all_favorite_dishes_with_votes_number_of_user($user_id)
    {
        $dishes = array();
        $first_day_of_week = $this->find_first_date_of_week();
        $voted_dish_ids_in_week_arr = array();
        $voted_dish_ids_in_week = $this->get_votes_of_user_in_week($user_id, $first_day_of_week)->votes;
        if ($voted_dish_ids_in_week != NULL)
        {
            $voted_dish_ids_in_week_arr = (substr_count($voted_dish_ids_in_week, ';') > 0) ? explode(";", $voted_dish_ids_in_week) : array($voted_dish_ids_in_week);
            $this->load->model('dishes_model');
            $result = $this->dishes_model->get_all_dishes();
            foreach ($result as $dish)
            {
                // Count dish_id have in voted dish ids in week or not
                $num_votes = (in_array($dish->id, $voted_dish_ids_in_week_arr)) ? 1 : 0;
                $dish->num_votes = $num_votes;
                // Push object dish in array $vote
                array_push($dishes, $dish);
            }
            usort($dishes, array($this,"compared_by_num_votes"));
        }
        return $dishes;
    }

    /**
     * Vote for dish
     *
     * @param       int  $user_id
     * @param       int  $dishes_id
     * @return      int
     */
    function vote_for_dish_of_week($user_id, $dishes_id)
    {
        if (!$this->is_end_of_voting_time())
        {
            $first_day_of_week = $this->find_first_date_of_week();
            $have_log_record = $this->is_exist_vote_of_user_in_week($user_id, $first_day_of_week);
            if ($have_log_record)
            {
                return $this->update_votes_of_user_in_week($user_id, $first_day_of_week, $dishes_id);
            }
            else
            {
                return $this->create_vote_log_of_user_in_week($user_id, $first_day_of_week, $dishes_id);
            }
        }
        else return END_VOTING_TIME;
    }

    /**
     * Count votes remaining of user in a week
     *
     * @param       int  $user_id
     * @return      int
     */
    function count_votes_remaining_of_user_in_a_week($user_id)
    {
        $vote_remaining = MAX_VOTES_FOR_USER;
        $first_day_of_week = $this->find_first_date_of_week();
        $have_log_record = $this->is_exist_vote_of_user_in_week($user_id, $first_day_of_week);
        if ($have_log_record)
        {
            $votes_in_week = $this->get_votes_of_user_in_week($user_id, $first_day_of_week)->votes;
            $vote_remaining = MAX_VOTES_FOR_USER - substr_count($votes_in_week, ';');
        }
        return $vote_remaining;
    }

    /**
     * Check exist vote_log record of user in week
     *
     * @param       int  $user_id
     * @param       date(Y-m-d)  $first_day_of_week
     * @return      bool
     */
    function is_exist_vote_of_user_in_week($user_id, $first_day_of_week)
    {
        $query = $this->db->get_where('vote_logs', array(
            'first_day_of_week' => $first_day_of_week,
            'user_id' => $user_id));
        return $query->num_rows() > 0;
    }

    /**
     * Get votes of user in week
     *
     * @param       int  $user_id
     * @param       date(Y-m-d)  $first_day_of_week
     * @return      object
     */
    function get_votes_of_user_in_week($user_id, $first_day_of_week)
    {
        $result = new stdClass();
        $query = $this->db->get_where('vote_logs', array(
            'user_id' => $user_id,
            'first_day_of_week' => $first_day_of_week));
        if ($query->num_rows() > 0) $result = $query->first_row();
        else
        {
            $result->votes = '';
        }
        return $result;
    }

    /**
     * Create vote log of user for dishes in week
     *
     * @param       int  $user_id
     * @param       date(Y-m-d)  $first_day_of_week
     * @param       int  $dishes_id
     * @return      int
     */
    function create_vote_log_of_user_in_week($user_id, $first_day_of_week, $dishes_id)
    {
        if (substr_count($dishes_id, ';') < MAX_VOTES_FOR_USER)
        {
            $data = array('user_id' => $user_id,
                'first_day_of_week' => $first_day_of_week,
                'votes' => $dishes_id.';');
            $query = $this->db->insert('vote_logs', $data);
            return ($query) ? ADD_VOTE_SUCCESSFULLY : ADD_VOTE_FAIL;
        }
        return MAX_VOTES;
    }

    /**
     * Update votes of user for dishes in week
     *
     * @param       int  $user_id
     * @param       date(Y-m-d)  $first_day_of_week
     * @param       int  $dishes_id
     * @return      int
     */
    function update_votes_of_user_in_week($user_id, $first_day_of_week, $dishes_id)
    {
        if (substr_count($dishes_id, ';') < MAX_VOTES_FOR_USER)
        {
            $new_votes_in_week = $dishes_id.';';
            $query = $this->update_vote_log_of_user($user_id, $new_votes_in_week, $first_day_of_week);
            $result = ($query) ? ADD_VOTE_SUCCESSFULLY : ADD_VOTE_FAIL;
            return $result;
        }
        return MAX_VOTES;
    }

    /**
     * Update vote log of user
     *
     * @param       int  $user_id
     * @param       date(Y-m-d)  $first_day_of_week
     * @param       string  $new_votes
     * @return      bool
     */
    function update_vote_log_of_user($user_id, $new_votes, $first_day_of_week)
    {
        $data = array('votes' => $new_votes);
        $this->db->where('user_id', $user_id);
        $this->db->where('first_day_of_week', $first_day_of_week);
        $query = $this->db->update('vote_logs', $data);
        return $query;
    }

    /**
     * Find first date of week
     *
     * @param       date(Y-m-d)  $date
     * @return      string
     */
    function find_first_date_of_week($date = NULL)
    {
        $date = (is_null($date)) ? new DateTime(date('Y-m-d')) : new DateTime(date($date));
        $monday = clone $date->modify(('Sunday' == $date->format('l')) ? 'Monday last week' : 'Monday this week');
        return $monday->format('y-m-d');
    }

    /**
     * Find last date of week
     *
     * @param       date(Y-m-d)  $date
     * @return      string
     */
    function find_last_date_of_week($date = NULL)
    {
        $date = (is_null($date)) ? new DateTime(date('Y-m-d')) : new DateTime(date($date));
        $friday = clone $date->modify('Friday this week');
        return $friday->format('y-m-d');
    }

    /**
     * Check voting time
     *
     * @return      bool
     */
    function is_end_of_voting_time()
    {
        $date = new DateTime(date('Y-m-d'));
        $current_date = $date->format('Y-m-d');
        $first_day_of_week = $date->modify(('Sunday' == $date->format('l')) ? 'Monday last week' : 'Monday this week')->format('Y-m-d');
        // Thursday is end of voting time
        $end_day_of_voting = $date->add(new DateInterval('P3D'))->format('Y-m-d');
        return ($end_day_of_voting < $current_date) ? TRUE : FALSE;
    }

    /**
     * Compare dishes by number of votes
     *
     * @param       object  $dish1
     * @param       object  $dish2
     * @return      bool
     */
    function compared_by_num_votes($dish1, $dish2)
    {
        return $dish2->num_votes - $dish1->num_votes;
    }

}

