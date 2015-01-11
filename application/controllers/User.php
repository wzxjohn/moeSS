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
    }

    function login_check()
    {
        $this->load->model('user_model');
        $user = $this->admin_model->u_select(trim($_POST['username']));
        if ($user)
        {
            if ($user[0]->pass == $_POST['password'])
            {
                $arr = array( 's_uid' => $user[0]->uid,
                    's_username' => $user[0]->username
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
