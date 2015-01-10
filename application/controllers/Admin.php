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
        $this->load->view('welcome_message');
    }

    function login()
    {
        $this->load->view('admin_login');
    }

    function login_check()
    {
        $this->load->model('admin_model');
        $user = $this->admin_model->u_select($_POST['username']);
        if ($user)
        {
            if ($user[0]->pass == $_POST['password'])
            {
                $this->load->library('session');
                $arr = array('s_uid' => $user[0]->uid);
                $this->session->set_userdate($arr);
            }
            else
            {
                echo "Wrong Password";
            }
        }
        else
        {
            echo "Wrong Username";
        }
    }
}