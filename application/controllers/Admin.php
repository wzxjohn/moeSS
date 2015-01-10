<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/10/15
 * Time: 15:21
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
    }

    function index()
    {
        if (is_loggin())
        {
            $this->load->view('welcome_message');
        }
        else
        {
            redirect(site_url('admin/login/'));
        }
    }

    function is_login()
    {
        if ($this->session->userdata('s_uid'))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function login()
    {
        if ($this->is_login())
        {
            redirect(site_url('admin'));
        }
        else
        {
            $this->load->view('admin_login');
        }
        return;
    }

    function login_check()
    {
        $this->load->model('admin_model');
        $user = $this->admin_model->u_select($_POST['username']);
        if ($user)
        {
            if ($user[0]->pass == $_POST['password'])
            {
                $arr = array('s_uid' => $user[0]->uid);
                $this->session->set_userdata($arr);
                echo "Login Success!";
                redirect(site_url('admin'));
            }
            else
            {
                echo "Wrong Password";
                redirect(site_url('admin/login/'));
            }
        }
        else
        {
            echo "Wrong Username";
            redirect(site_url('admin/login/'));
        }
    }
}