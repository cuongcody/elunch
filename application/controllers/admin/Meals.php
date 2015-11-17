<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meals extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('common');
        $this->load->model('meals_model');

    }

    public function index()
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->validation('index');
            if ($this->form_validation->run() == FALSE)
            {
                $this->load_meals_view();
            }
            else $this->load_meals_view($this->input->post('from'), $this->input->post('to'));
        }
        $this->load_meals_view();
    }

    public function add()
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->validation('add');
            if ($this->form_validation->run() == FALSE)
            {
                $this->load_new_meal_view();
            }
            else
            {
                if ($this->store_meal()) $this->common->return_notification('new_meal', 'add_success', 1);
                else $this->common->return_notification('new_meal', 'add_failure', 0);
                redirect('admin/meals','refresh');
            }
        }
        else
        {
            $this->load_new_meal_view();
        }
    }

    public function report($meal_date)
    {
        $this->common->authenticate();
        $data = array();
        $meal_log = array();
        $meal_log = $this->meals_model->get_meal_log($meal_date);
        if ($meal_log != NULL)
        {
            if ($meal_log->tracking_log != NULL)
            {
                $tracking_log = json_decode($meal_log->tracking_log);
                usort($tracking_log, array($this, "compared_by_shift_name"));
                $data['meal_log'] = $tracking_log;
                $data['preordered_meals'] = $meal_log->preordered_meals;
                $data['actual_meals'] = $meal_log->actual_meals;
                $data['note'] = $meal_log->note;
                foreach ($data['meal_log'] as $key => $value)
                {
                    if (isset($value->shift))
                    {
                        if (isset($value->tables))
                        {
                            foreach ($value->tables as $key2 => $value2)
                            {
                                $number_users_have_attend = 0;
                                if (isset($value2->users))
                                {
                                    foreach ($value2->users as $key3 => $value3)
                                    {
                                        if ($value3->status_user == 1) $number_users_have_attend++;
                                    }
                                }
                                $value2->number_users_have_attend = $number_users_have_attend;
                            }
                        }
                    }
                }
                $data['meal_date'] = $meal_date;
                $data['title'] = 'Daily Lunch Service Report';
                $this->load->model('tracking_users_model');
                $view = $this->load->view('admin/meals/meal_report', $data, TRUE);
                $this->pdf_report($view, $meal_date);
            }
            else
            {
                $this->common->return_notification('gen_log_file_meal', 'no_data_in_log_file', 0);
            }
        }
        else
        {
            $this->common->return_notification('gen_log_file_meal', 'cannot_find_log_file', 0);
        }
        redirect('admin/meals','refresh');
    }

    public function edit($meal_id)
    {
        $this->common->authenticate();
        if (isset($_POST['submit']))
        {
            $this->validation('edit');
            if ($this->form_validation->run() == FALSE)
            {
                $this->load_edit_meal_view($meal_id);
            }
            else
            {
                if ($this->edit_meal($meal_id)) $this->common->return_notification('edit_meal', 'edit_success', 1);
                else $this->common->return_notification('edit_meal', 'edit_failure', 0);
                redirect('admin/meals','refresh');
            }
        }
        else
        {
            $this->load_edit_meal_view($meal_id);
        }
    }

    public function load_new_meal_view()
    {
        $message = array('title', 'name_dish', 'category',
            'lunch_date', 'dishes_of_menu', 'preordered_meal', 'menu', 'image', 'lunch_date', 'save');
        $data = $this->common->set_language_and_data('new_meal', $message);
        $this->load->model('menus_model');
        $menus = $this->menus_model->get_all_menus();
        $data['menus'] = $menus;
        $this->common->load_view('admin/meals/new_meal', $data);
    }

    public function load_edit_meal_view($meal_id)
    {
        $message = array('title', 'name_dish', 'category',
            'lunch_date', 'dishes_of_menu', 'preordered_meal', 'manage_meals', 'menu', 'image', 'edit');
        $data = $this->common->set_language_and_data('edit_meal', $message);
        $this->load->model('menus_model');
        $menus = $this->menus_model->get_all_menus();
        $data['menus'] = $menus;
        $data['meal'] = $this->meals_model->get_meal_by_id($meal_id);
        $this->common->load_view('admin/meals/edit_meal', $data);
    }

    public function load_meals_view($from = NULL, $to = NULL)
    {
        $message = array('title', 'create_meal', 'meals', 'name_dish', 'category',
         'lunch_date', 'dishes_of_menu', 'preordered_meal', 'menu', 'image', 'lunch_date', 'search',
          'from', 'to', 'edit', 'delete', 'generate_log_file', 'want_to_gen_log_file', 'are_you_sure', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('meals', $message);
        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/meals');
        $config['total_rows'] = $this->meals_model->get_num_of_meals($from, $to);
        $config['per_page'] = (($from != '' || $to != '') ? $config['total_rows'] : 10);
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 3;
        $config['num_links'] = 3;
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] ="</ul>";
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $meals = $this->meals_model->get_meals($config['per_page'],  ($data['page'] == 0 ? $data['page'] : ($data['page'] - 1)) * $config['per_page'], $from, $to);
        $data['meals'] = $meals;
        $this->common->load_view('admin/meals/meals', $data);
    }

    public function dishes($menu_id)
    {
        $this->common->authenticate();
        $this->load->model('menus_model');
        echo json_encode($this->menus_model->get_dishes_by_menu($menu_id));
    }

    public function validation($view)
    {
        $this->config->set_item('language', $this->session->userdata('site_lang'));
        $this->load->helper('security');
        $this->load->library('form_validation');
        // Validation rules
        if ($view == 'index')
        {
            $this->form_validation->set_rules('from', 'lang:from', 'trim|required|callback_check_date_format|xss_clean');
            $this->form_validation->set_rules('to', 'lang:to', 'trim|required|callback_check_date_format|xss_clean');
        }
        elseif ($view == 'add')
        {
            $this->form_validation->set_rules('lunch_date', 'lang:lunch_date', 'trim|required|callback_check_date_format|xss_clean');
            $this->form_validation->set_rules('preordered_meal', 'lang:preordered_meal', 'trim|required|numeric|greater_than[1]|xss_clean');
            $this->form_validation->set_rules('menu', 'lang:menu', 'trim|required|numeric|xss_clean');
        }
        else
        {
            $this->form_validation->set_rules('preordered_meal', 'lang:preordered_meal', 'trim|required|numeric|greater_than[1]|xss_clean');
            $this->form_validation->set_rules('menu', 'lang:menu', 'trim|required|numeric|xss_clean');
        }
    }

    public function store_meal()
    {
        $lunch_date = $this->input->post('lunch_date');
        $menu_id = $this->input->post('menu');
        $preordered_meal = $this->input->post('preordered_meal');
        return $this->meals_model->insert_meal($lunch_date, $menu_id, $preordered_meal);
    }

    public function edit_meal($meal_id)
    {
        $menu_id = $this->input->post('menu');
        $preordered_meal = $this->input->post('preordered_meal');
        return $this->meals_model->update_meal($meal_id, $menu_id, $preordered_meal);
    }

    public function check_date_format($date) {
        if (!$this->common->date_format($date))
        {
            $this->lang->load('validation', $this->session->userdata('site_lang'));
            $this->form_validation->set_message('check_date_format', $this->lang->line('date_format'));
            return FALSE;
        }
        return TRUE;
    }

    public function delete($meal_id)
    {
        $this->common->authenticate();
        $message = $this->common->get_message('delete_menu', array('delete_success', 'delete_failure'));
        if ($this->meals_model->delete_meal($meal_id))
        {
            $data = array(
                'status' => 'success',
                'message' => $message['delete_success']);
        }
        else
        {
            $data = array(
                'status' => 'failure',
                'message' => $message['delete_failure']);
        }
        echo json_encode($data);
    }

    public function generate_log_file_meal($meal_date)
    {
        $this->common->authenticate();
        $message = $this->common->get_message('gen_log_file_meal', array('gen_log_file_success', 'gen_log_file_failure'));
        if ($this->meals_model->gen_log_file_meal($meal_date))
        {
            $data = array(
                'status' => 'success',
                'message' => $message['gen_log_file_success']);
        }
        else
        {
            $data = array(
                'status' => 'failure',
                'message' => $message['gen_log_file_failure']);
        }
        echo json_encode($data);
    }

    /**
     * Print daily lunch report
     *
     * @param       html  $html
     * @param       date(Y-m-d)  $meal_date
     * @return      pdf file
     */
    public function pdf_report($html, $meal_date)
    {
        ini_set('memory_limit','-1');
        $pdfFilePath = "meal_report_".$meal_date.".pdf";
        $this->load->library('m_pdf');
        $pdf = $this->m_pdf->load();
        $pdf->SetFooter('Elunch'.'|{PAGENO}|'.date('D, d M Y', strtotime($meal_date)));
        $pdf->WriteHTML($html);
        $pdf->Output($pdfFilePath, "D");
    }

    /**
     * Compare shifts by shift id
     *
     * @param       object  $log1
     * @param       object  $log2
     * @return      bool
     */
    function compared_by_shift_name($log1, $log2)
    {
        return $log1->shift->name - $log2->shift->name;
    }
}