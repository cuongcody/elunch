<?php
require(APPPATH.'controllers/Base_api.php');

class Dishes_api extends BaseApi {

    function dishes_get()
    {
        $this->authenticate();
        $this->load->model('dishes_model');
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
            $response['status'] = 'success';
            $response['message'] = 'Get all dishes successfully';
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
    * Listing all dishes of a meal in a day
    * method GET
    * url: http://localhost/meals?from=yyyy-mm-dd&days=
    */
    function meals_get()
    {
        $this->authenticate();
        $from_date = $this->input->get('from');
        $days = $this->input->get('days');
        if ($days == NULL) $days = 0;
        if ($days > 30 OR $days < 0 OR !is_numeric($days) OR !strtotime($from_date))
        {
            $response = array();
            $response['status'] = 'failure';
            $response['message'] = "Sorry. Your variable 'from' or 'days' is not vaild";
        }
        else
        {
            $response['status'] = 'success';
            $response['message'] = "Load dish from date successfully";
            $this->load->model('dishes_model');
            $result = $this->dishes_model->get_dishes_of_meals_from($from_date, $days);
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
            $response['data'] = $dates;
        }
        $this->response($response, 200);
    }
}
