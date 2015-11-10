<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Votes_model extends CI_Model {

    function get_all_dishes_with_votes_number_in_a_week($day = NULL)
    {
        $first_day_of_week = $this->find_first_date_of_week($day);
        $query = $this->db->get_where('vote_logs', array('first_day_of_week' => $first_day_of_week));
        $voted_dish_ids_in_week = "";
        $dishes = array();
        $num_votes = 0;
        foreach ($query->result() as $value)
        {
            $voted_dish_ids_in_week.=$value->votes;
        }
        $last_day_of_week = $this->find_last_date_of_week($day);
        $this->load->model('dishes_model');
        $result = $this->dishes_model->get_all_dishes();
        foreach ($result as $dish)
        {
            // Count dish_id have in voted dish ids in week or not
            $num_votes = substr_count($voted_dish_ids_in_week, $dish->id);
            $dish->num_votes = $num_votes;
            // Push object dish in array $vote
            array_push($dishes, $dish);
        }
        usort($dishes, array($this,"compared_by_num_votes"));
        return $dishes;
    }

    function get_all_favorite_dishes_with_votes_number_of_user($user_id)
    {
        $first_day_of_week = $this->find_first_date_of_week();
        $query = $this->db->get_where('vote_logs', array('first_day_of_week' => $first_day_of_week));
        $voted_dish_ids_in_week = $this->get_votes_of_user_in_week($user_id, $first_day_of_week)->votes;
        $dishes = array();
        $num_votes = 0;
        $last_day_of_week = $this->find_last_date_of_week();
        $this->load->model('dishes_model');
        $result = $this->dishes_model->get_all_dishes();
        foreach ($result as $dish)
        {
            // Count dish_id have in voted dish ids in week or not
            $num_votes = substr_count($voted_dish_ids_in_week, $dish->id);
            $dish->num_votes = $num_votes;
            // Push object dish in array $vote
            array_push($dishes, $dish);
        }
        usort($dishes, array($this,"compared_by_num_votes"));
        return $dishes;
    }

    function vote_for_dish_of_week($user_id, $dishes_id)
    {
        $first_day_of_week = $this->find_first_date_of_week();
        $have_log_record = $this->is_exist_vote_of_user_in_week($user_id, $first_day_of_week);
        if ($have_log_record)
        {
            return $this->update_vote_log_of_user_this_week($user_id, $first_day_of_week, $dishes_id);
        }
        else
        {
            return $this->create_vote_log_of_user_this_week($user_id, $first_day_of_week, $dishes_id);
        }
    }

    function remove_vote_for_dish_of_week($user_id, $dish_id)
    {
        $result = "";
        $first_day_of_week = $this->find_first_date_of_week();
        $have_log_record = $this->is_exist_vote_of_user_in_week($user_id, $first_day_of_week);
        if ($have_log_record)
        {
            $votes_in_week = $this->get_votes_of_user_in_week($user_id, $first_day_of_week)->votes;
            if (substr_count($votes_in_week, $dish_id.';') > 0)
            {
                $new_votes_in_week = preg_replace('/'.$dish_id.';/', '', $votes_in_week, 1);
                $query = $this->update_votes_of_user($user_id, $new_votes_in_week , $first_day_of_week);
                $result = ($query) ? REMOVE_VOTE_SUCCESSFULLY : REMOVE_VOTE_FAIL;
            }
            else $result = NO_VOTE_THIS_DISH;
        }
        else $result = REMOVE_VOTE_FAIL;
        return $result;
    }

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

    function is_exist_vote_of_user_in_week($user_id, $first_day_of_week)
    {
        $query = $this->db->get_where('vote_logs', array(
            'first_day_of_week' => $first_day_of_week,
            'user_id' => $user_id));
        return $query->num_rows() > 0;
    }

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

    function create_vote_log_of_user_this_week($user_id, $first_day_of_week, $dishes_id)
    {
        if (substr_count($dishes_id, ';') < 5)
        {
            $data = array('user_id' => $user_id,
                'first_day_of_week' => $first_day_of_week,
                'votes' => $dishes_id.';');
            $query = $this->db->insert('vote_logs', $data);
            return ($query) ? ADD_VOTE_SUCCESSFULLY : ADD_VOTE_FAIL;
        }
        return MAX_VOTES;
    }

    function update_vote_log_of_user_this_week($user_id, $first_day_of_week, $dishes_id)
    {
        if (substr_count($dishes_id, ';') < 5)
        {
            $new_votes_in_week = $dishes_id.';';
            $query = $this->update_votes_of_user($user_id, $new_votes_in_week, $first_day_of_week);
            $result = ($query) ? ADD_VOTE_SUCCESSFULLY : ADD_VOTE_FAIL;
            return $result;
        }
        else return MAX_VOTES;
    }

    function update_votes_of_user($user_id, $new_votes, $first_day_of_week)
    {
        $data = array('votes' => $new_votes);
        $this->db->where('user_id', $user_id);
        $this->db->where('first_day_of_week', $first_day_of_week);
        $query = $this->db->update('vote_logs', $data);
        return $query;
    }

    function find_first_date_of_week($date = NULL)
    {
        $date = (is_null($date)) ? new DateTime(date('Y-m-d')) : new DateTime(date($date));
        $monday = clone $date->modify(('Sunday' == $date->format('l')) ? 'Monday last week' : 'Monday this week');
        return $monday->format('y-m-d');
    }

    function find_last_date_of_week($date = NULL)
    {
        $date = (is_null($date)) ? new DateTime(date('Y-m-d')) : new DateTime(date($date));
        $friday = clone $date->modify('Friday this week');
        return $friday->format('y-m-d');
    }

    function is_end_of_voting_time()
    {
        $current_day = new DateTime(date('Y-m-d'));
        $data['current_day'] = $current_day->format('Y-m-d');
        $first_day_of_week = clone $current_day->modify(('Sunday' == $current_day->format('l')) ? 'Monday last week' : 'Monday this week');
        $data['first_day_of_week'] = $first_day_of_week->format('Y-m-d');
        $end_day = $first_day_of_week->add(new DateInterval('P3D'));
        $data['end_day'] = $end_day->format('Y-m-d');
        $a = ($data['end_day'] < $data['current_day']) ? true: false;
        $data['sub'] = $a;
        return $data;
    }

    function compared_by_num_votes($dish1, $dish2)
    {
        return $dish2->num_votes - $dish1->num_votes;
    }

}

