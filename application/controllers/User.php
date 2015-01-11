<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/11/15
 * Time: 16:43
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        return;
    }

    function index()
    {
        if ($this->is_login())
        {
            $this->load->view('welcome_message');
        }
        else
        {
            redirect(site_url('user/login'));
        }
        return;
    }

    function login()
    {
        if ($this->is_login())
        {
            redirect(site_url('user'));
        }
        else
        {
            $this->load->view('user_login');
        }
        return;
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url('user/login'));
        return;
    }

    function register()
    {
        $this->load->view('user_register');
        return;
    }

    function do_register()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $invitecode = $this->input->post('invitecode');
        return;
    }

    function guestbook()
    {
        return;
    }

    function login_check()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if ($username && $password)
        {
            $this->load->model('user_model');
            $user = $this->user_model->u_select($username);
            if ($user) {
                if ($user[0]->pass == $password)
                {
                    $arr = array('s_uid' => $user[0]->uid,
                        's_username' => $user[0]->user_name
                    );
                    $this->session->set_userdata($arr);
                    echo '{"result" : "success" }';
                    //redirect(site_url('admin'));
                }
                else
                {
                    echo '{"result" : "Wrong Username or Password!" }';
                    //redirect(site_url('admin/login/'));
                }
            }
            else
            {
                echo '{"result" : "Wrong Username or Password!" }';
                //redirect(site_url('admin/login/'));
            }
        }
        else
        {
            echo '{"result" : "Wrong Username or Password!" }';
        }
        return;
    }

    function is_login()
    {
        if ($this->session->userdata('s_uid') && $this->session->userdata('s_username'))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
