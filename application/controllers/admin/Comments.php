<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('common');
        $this->load->model('comments_model');
    }

    public function index()
    {
        $this->common->authenticate();
        $this->load_comment_view();
    }

    public function load_comment_view()
    {
        $message = array('title', 'comments', 'lunch_date', 'subject', 'content', 'inbox', 'from', 'reply', 'send', 'edit', 'delete', 'are_you_sure', 'yes', 'cancel');
        $data = $this->common->set_language_and_data('comments', $message);
        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/comments');
        $config['total_rows'] = $this->comments_model->number_of_comments();
        $config['per_page'] = 5;
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
        $comments = $this->comments_model->get_comments($config['per_page'],  ($data['page'] == 0 ? $data['page'] : ($data['page'] - 1)) * $config['per_page']);
        $data['comments'] = $comments;
        $this->common->load_view('admin/comments/comments', $data);
    }

    public function get_detail_comment($comment_id)
    {
        $this->common->authenticate();
        $result = $this->comments_model->get_replies_comment_by_id($comment_id);
        $data = array();
        $replies = array();
        foreach ($result as $item)
        {
            $reply = array();
            $reply['id'] = (int)$item->reply_id;
            $reply['content'] = $item->reply_content;
            $reply['email'] = $item->email;
            $reply['avatar_content_file'] = $item->avatar_content_file;
            $reply['created_at'] = $item->reply_created_at;
            $reply['updated_at'] = $item->reply_updated_at;
            array_push($replies, $reply);
        }
        $data['replies'] = $replies;
        echo json_encode($data);
    }

    public function get_lastest_comments()
    {
        $this->common->authenticate();
        $result = $this->comments_model->get_comments(10, 0);
        $data['comments'] = $result;
        echo json_encode($data);
    }

    public function add_reply($comment_id = NULL)
    {
        $this->common->authenticate();
        $message = $this->common->get_message('new_reply_comment', array('add_success', 'add_failure'));
        if (!is_null($comment_id))
        {
            $content = $this->input->post('content');
            $this->load->helper('security');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('content', 'lang:content', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE)
            {
                $errors = validation_errors();
                $data['status'] = 'errors';
                $data['message'] = $errors;
            }
            else
            {
                $user_id = $this->session->userdata('logged_in')['user_id'];
                list($result, $reply_id) = $this->comments_model->reply_comment($user_id, $comment_id, $content);
                if ($result)
                {
                    $data['status'] = 'success';
                    $data['message'] = $message['add_success'];
                    $data['email'] = $this->session->userdata('logged_in')['email'];
                    $data['content'] = $content;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['avatar_content_file'] = $this->session->userdata('logged_in')['avatar_content_file'];
                    $user = $this->comments_model->get_user_in_comment($comment_id);
                    if ($user != NULL)
                    {
                        $comment = $this->comments_model->get_comment_by_id($user->id, $comment_id);
                        $send_notification = array();
                        $send_notification['data'] = array(
                            'type' => 'reply_comment',
                            'comment' => array(
                                'user_id' => $comment->user_id,
                                'email' => $comment->email,
                                'avatar_content_file' => $comment->avatar_content_file,
                                'id' => (int)$comment->id,
                                'meal_date' => $comment->meal_date,
                                'dish_id' => $comment->dish_id,
                                'title' => $comment->title,
                                'content' => $comment->content,
                                'read_flag' => $comment->have_read,
                                'number_of_replies' => (int)$comment->number_of_replies,
                                'number_of_have_read_replies' => (int)$comment->count_replies_have_read,
                                'created_at' => $comment->created_at),
                            'reply' => array(
                                'id' => (int)$reply_id,
                                'content' => $data['content'],
                                'created_at' => $data['created_at'],
                                'user_id' => (int)$user_id,
                                'email' => $data['email'],
                                'avatar_content_file' => $data['avatar_content_file']));
                        if ($user->gcm_regid != NULL) $this->common->send_notification(array($user->gcm_regid), $send_notification);
                    }
                }
                else
                {
                    $data['status'] = 'failure';
                    $data['message'] = $message['add_failure'];
                }
            }
        }
        else
        {
            $data['status'] = 'failure';
            $data['message'] = $message['add_failure'];
        }
        echo json_encode($data);
    }

    public function delete($comment_id)
    {
        $this->common->authenticate();
        $message = $this->common->get_message('delete_comment', array('delete_success', 'delete_failure'));
         if ($this->comments_model->delete_comment($comment_id))
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

    public function check_date_format($date)
    {
        if (!$this->common->date_format($date))
        {
            $this->lang->load('web_portal/validation', $this->session->userdata('site_lang'));
            $this->form_validation->set_message('check_date_format', $this->lang->line('date_format'));
            return FALSE;
        }
        return TRUE;
    }

}
?>