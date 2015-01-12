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
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_email'));
            $this->load->view( 'user/user_header' );
            $this->load->view( 'user/user_nav', $data );

            $data['index_active'] = (bool) true;
            $data['node_active'] = (bool) false;
            $data['info_active'] = (bool) false;
            $data['update_active'] = (bool) false;
            $data['code_active'] = (bool) false;
            $this->load->view( 'user/user_sidebar', $data );

            $user_info = $this->user_model->u_info($data['user_name']);
            $data['transfers'] = $user_info->u + $user_info->d;
            $data['all_transfer'] = $user_info->transfer_enable;
            $data['unused_transfer'] = human_file_size( $data['all_transfer'] - $data['transfers'] );
            $data['used_100'] = round( ($data['transfers'] / $data['all_transfer']), 2 );
            $data['transfers'] = human_file_size( $data['transfers'] );
            $data['all_transfer'] = human_file_size( $data['all_transfer'] );
            $data['passwd'] = $user_info->passwd;
            $data['plan'] = $user_info->plan;
            $data['port'] = $user_info->port;
            $data['last_check_in_time'] = $user_info->last_check_in_time;
            $data['unix_time'] = $user_info->t;
            $data['is_able_to_check_in'] = is_able_to_check_in( $user_info->last_check_in_time );

            $this->load->view( 'user/user_index', $data );
            $this->load->view( 'user/user_footer' );
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
            $this->load->view('user/user_login');
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
        if ( $this->user_model->need_invite() )
        {
            $data['invite_only'] = true;
        }
        else
        {
            $data['invite_only'] = false;
        }
        $this->load->view('user/user_register', $data);
        return;
    }

    function do_register()
    {
        $username = $this->input->post('username');
        if ( strlen($username)<7||strlen($username)>32 )
        {
            echo '{"result" : "Username not valid!" }';
            return;
        }
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $this->load->helper('email');
        if ( !valid_email($email) )
        {
            echo '{"result" : "E-mail not valid!" }';
            return;
        }
        $invitecode = $this->input->post('code');

        if ( $username && $password && $email )
        {
            $user = $this->user_model->u_select($username);
            if ($user)
            {
                echo '{"result" : "Username already exist!" }';
                return;
            }
            else
            {
                if ( $this->user_model->need_invite() )
                {
                    if ( $invitecode )
                    {
                        if ( !$this->user_model->valid_code($invitecode) )
                        {
                            echo '{"result" : "Invite Code Invalid!" }';
                            return;
                        }
                    }
                    else
                    {
                        echo '{"result" : "Please input Invite Code!" }';
                        return;
                    }
                }
                $this->load->helper('string');
                $username = strip_slashes(strip_quotes($username));
                $this->load->helper('security');
                $password = do_hash($password, 'md5');
                if ( $this->user_model->new_user($username, $password, $email, $invitecode) )
                {
                    echo '{"result" : "success" }';
                    return;
                }
                else
                {
                    echo '{"result" : "DB Failed!" }';
                    return;
                }
            }
        }
        else
        {
            echo '{"result" : "Something Missing!" }';
            return;
        }
        return;
    }

    function guestbook()
    {
        $this->view->load('guestbook');
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
            if ($user)
            {
                if ($user[0]->pass == $password)
                {
                    $arr = array('s_uid' => $user[0]->uid,
                        's_username' => $user[0]->user_name,
                        's_email' => $user[0]->email
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

    function my_info()
    {
        return;
    }

}
