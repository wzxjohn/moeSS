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
        if ($this->is_login())
        {
            $this->load->view('welcome_message');
        }
        else
        {
            redirect(site_url('admin/login'));
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

    function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url('admin/login'));
    }

    function login_check()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if ($username && $password) {
            $this->load->model('admin_model');
            $user = $this->admin_model->u_select($username);
            if ($user) {
                if ($user[0]->pass == $password) {
                    $arr = array(
                        's_uid' => $user[0]->uid,
                        'admin' => 'true'
                    );
                    $this->session->set_userdata($arr);
                    echo '{"result" : "success" }';
                    //redirect(site_url('admin'));
                } else {
                    echo '{"result" : "Wrong Username or Password!" }';
                    //redirect(site_url('admin/login/'));
                }
            } else {
                echo '{"result" : "Wrong Username or Password!" }';
                //redirect(site_url('admin/login/'));
            }
        }
        else
        {
            echo '{"result" : "Wrong Username or Password!" }';
        }
    }

    function is_login()
    {
        if ($this->session->userdata('s_uid') && $this->session->userdata('admin') == 'true')
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}