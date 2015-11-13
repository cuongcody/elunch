<?php
require(APPPATH.'controllers/Base_api.php');

class Dishes_api extends Base_api {

    function __construct()
    {
        parent::__construct();
        $this->load->library('common');
        $this->load->model('dishes_model');
    }

    /**
     * Get all dishes
     * url: http://localhost/dishes
     * Method: GET
     * @return      json
     */
    function dishes_get()
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('dishes_api',
            array('get_dishes_success', 'get_dishes_failure'));
        $result = $this->dishes_model->get_all_dishes();
        $response = array();
        if (!is_null($result))
        {
            $dishes = array();
            foreach ($result as $temp)
            {
                $dish = array();
                $dish['id'] = (int)$temp->id;
                $dish['name'] = $temp->name;
                $dish['description'] = $temp->description;
                $dish['category'] = $temp->category;
                $dish['image'] = $temp->image;
                array_push($dishes, $dish);
            }
            $response['status'] = $messages_lang['success'];
            $response['message'] = $messages_lang['get_dishes_success'];
            $response['data'] = $dishes;
        }
        else
        {
            $response['status'] = $messages_lang['failure'];
            $response['message'] = $messages_lang['get_dishes_failure'];
        }
        $this->response($response, 200);
    }

    /**
     * Listing all dishes of a meal in a day
     * url: http://localhost/meals?from=yyyy-mm-dd&days=<number>
     * Method: GET
     * @param       date(y-m-d)  $from
     * @param       int  $days
     * @return      json
     */
    function meals_get()
    {
        $this->authenticate();
        $messages_lang = $this->common->set_language_for_server_api('dishes_api',
            array('get_meals_success', 'get_meals_failure', 'get_meals_not_valid'));
        $from_date = $this->input->get('from');
        $days = $this->input->get('days');
        $days = ($days == NULL) ? 0 : $days;
        if ($days > 30 OR $days < 0 OR !is_numeric($days) OR !strtotime($from_date))
        {
            $response = array();
            $response['status'] = $messages_lang['failure'];
            $response['message'] = $messages_lang['get_meals_not_valid'];
        }
        else
        {
            $result = $this->dishes_model->get_dishes_of_meals_from($from_date, $days);
            if ($result != NULL)
            {
                $dates = array();
                foreach ($result as $key1 => $temp1)
                {
                    $dishes = array();
                    foreach ($temp1 as $key2 => $temp2)
                    {
                        $dish = array();
                        $dish['id'] = (int)$temp2->dish_id;
                        $dish['name'] = $temp2->name;
                        $dish['description'] = $temp2->description;
                        $dish['image'] = $temp2->image;
                        array_push($dishes, $dish);
                    }
                    $dates[$key1] = $dishes;
                }
                $response['status'] = $messages_lang['success'];
                $response['message'] = $messages_lang['get_meals_success'];
                $response['data'] = $dates;
            }
            else
            {
                $response['status'] = $messages_lang['failure'];
                $response['message'] = $messages_lang['get_meals_failure'];
            }
        }
        $this->response($response, 200);
    }
}
