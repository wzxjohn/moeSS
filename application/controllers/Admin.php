<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/10/15
 * Time: 15:21
 */

/**
 * moeSS
 *
 * moeSS is an open source Shadowsocks frontend for PHP 5.4 or newer
 * Copyright (C) 2015  wzxjohn
 *
 * This file is part of moeSS.
 *
 * moeSS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * moeSS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with moeSS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package	moeSS
 * @author	wzxjohn
 * @copyright	Copyright (c) 2015, wzxjohn (https://maoxian.de/)
 * @license	http://www.gnu.org/licenses/ GPLv3 License
 * @link	http://github.com/wzxjohn/moeSS
 * @since	Version 1.0.0
 * @filesource
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
    }

    function sidebar()
    {
        $sidebar_data['index_active'] = (bool) FALSE;
        $sidebar_data['user_active'] = (bool) FALSE;
        $sidebar_data['node_active'] = (bool) FALSE;
        $sidebar_data['code_active'] = (bool) FALSE;
        $sidebar_data['system_active'] = (bool) FALSE;
        $sidebar_data['config_active'] = (bool) FALSE;
        $sidebar_data['config_g_active'] = (bool) FALSE;
        $sidebar_data['config_m_active'] = (bool) FALSE;
        $sidebar_data['config_e_active'] = (bool) FALSE;
        $sidebar_data['log_active'] = (bool) FALSE;
        $sidebar_data['log_u_active'] = (bool) FALSE;
        $sidebar_data['log_m_active'] = (bool) FALSE;
        $sidebar_data['log_a_active'] = (bool) FALSE;
        return $sidebar_data;
    }

    function index()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_admin_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_admin_email'));
            $this->load->view( 'admin/admin_header' );
            $this->load->view( 'admin/admin_nav', $data );

            $data = $this->sidebar();
            $data['index_active'] = (bool) TRUE;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['node_count'] = $this->admin_model->c_nodes();
            $data['all_user'] = $this->admin_model->c_users();
            $this->load->view( 'admin/admin_index', $data);
            $this->load->view( 'admin/admin_footer' );

        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function login()
    {
        if ($this->is_login())
        {
            redirect(site_url('admin'));
        }
        else
        {
            $this->load->view('admin/admin_login');
        }
        return;
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url('admin/login'));
        return;
    }

    function login_check()
    {
        //$this->output->enable_profiler(TRUE);
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if ($username && $password)
        {
            $this->load->model('admin_model');
            $user = $this->admin_model->u_select($username);
            if ($user)
            {
                if ($user[0]->pass == $password)
                {
                    $arr = array(
                        's_admin_uid' => $user[0]->uid,
                        's_admin_username' => $user[0]->admin_name,
                        's_admin_email' => $user[0]->email,
                        'admin' => 'true'
                    );
                    $this->session->set_userdata($arr);
                    echo '{"result" : "success" }';
                    $this->admin_model->log_login($username, $password, $this->input->ip_address(), $this->input->user_agent(), TRUE);
                    //redirect(site_url('admin'));
                }
                else
                {
                    echo '{"result" : "Wrong Username or Password!" }';
                    $this->admin_model->log_login($username, $password, $this->input->ip_address(), $this->input->user_agent(), FALSE);
                    //redirect(site_url('admin/login/'));
                }
            }
            else
            {
                echo '{"result" : "Wrong Username or Password!" }';
                $this->admin_model->log_login($username, $password, $this->input->ip_address(), $this->input->user_agent(), FALSE);
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
        if ($this->session->userdata('s_admin_uid') && $this->session->userdata('admin') == 'true')
        {
            return $this->admin_model->check_admin($this->session->userdata('s_admin_uid'), $this->session->userdata('s_admin_username') );
        }
        else
        {
            return FALSE;
        }
    }

    function users()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_admin_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_admin_email'));
            $this->load->view( 'admin/admin_header' );
            $this->load->view( 'admin/admin_nav', $data );

            $data = $this->sidebar();
            $data['user_active'] = (bool) TRUE;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['users'] = $this->admin_model->get_users();
            $this->load->view( 'admin/admin_users', $data );
            $this->load->view( 'admin/admin_footer' );
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function nodes()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_admin_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_admin_email'));
            $this->load->view( 'admin/admin_header' );
            $this->load->view( 'admin/admin_nav', $data );

            $data = $this->sidebar();
            $data['node_active'] = (bool) TRUE;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['nodes'] = $this->admin_model->get_nodes();
            $this->load->view( 'admin/admin_nodes', $data );    
            $this->load->view( 'admin/admin_footer' );
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function codes()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_admin_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_admin_email'));
            $this->load->view( 'admin/admin_codes_header' );
            $this->load->view( 'admin/admin_nav', $data );

            $data = $this->sidebar();
            $data['code_active'] = (bool) TRUE;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['node_count'] = $this->admin_model->c_nodes();
            $data['all_user'] = $this->admin_model->c_users();
            $this->load->view( 'admin/admin_codes', $data );    
            //$this->load->view( 'admin/admin_footer' );
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function system_info()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_admin_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_admin_email'));
            $this->load->view( 'admin/admin_header' );
            $this->load->view( 'admin/admin_nav', $data );

            $data = $this->sidebar();
            $data['system_active'] = (bool) TRUE;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['all_user'] = $this->admin_model->c_users();
            $data['active_user'] = $this->admin_model->c_active_users();
            $data['user_time_count_3600'] = $this->admin_model->c_user_time(3600);
            $data['user_time_count_300'] = $this->admin_model->c_user_time(300);
            $data['user_time_count_60'] = $this->admin_model->c_user_time(60);
            $data['user_time_count_10'] = $this->admin_model->c_user_time(10);
            $data['user_time_count_24'] = $this->admin_model->c_user_time(3600 * 24);
            $data['mt'] = human_file_size( $this->admin_model->get_month_traffic() );
            $data['version'] = $this->admin_model->get_version();
            $this->load->view( 'admin/admin_sysinfo', $data );    
            $this->load->view( 'admin/admin_footer' );
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function invite_code()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_admin_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_admin_email'));
            $this->load->view( 'admin/admin_header' );
            $this->load->view( 'admin/admin_nav', $data );

            $data = $this->sidebar();
            $data['code_active'] = (bool) TRUE;
            $this->load->view( 'admin/admin_sidebar', $data );

            $codes = $this->admin_model->get_invite_codes();
            $data['codes'] = $codes;
            $this->load->view( 'admin/admin_code', $data );
            $this->load->view( 'admin/admin_footer' );
        }
        else
        {
            redirect(site_url('user/login'));
        }
        return;
    }

    function add_invite()
    {
        if ($this->is_login())
        {
            $sub = $this->input->post('code_sub');
            $type = $this->input->post('code_type');
            $num = $this->input->post('code_num');
            if ($type == "" || $num == "") {
                echo '{"result" : "Not enougth args!" }';
                return;
            }
            if ($this->admin_model->add_code($sub, $type, $num))
            {
                echo '{"result" : "success" }';
            }
            else
            {
                echo '{"result" : "Database Error!" }';
            }
            return;
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function add_invite_num()
    {
        if ($this->is_login())
        {
            $user_name = $this->input->post('user_name');
            $uid = $this->input->post('uid');
            $num = $this->input->post('code_num');
            if ($num == "" || $num == 0 || ($user_name == "" && $uid == "" ))
            {
                echo '{"result" : "Not enougth args!" }';
                return;
            }
            if ($this->admin_model->add_code_num($user_name, $uid, $num))
            {
                echo '{"result" : "success" }';
            }
            else
            {
                echo '{"result" : "Database Error!" }';
            }
            return;
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function user_add()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_admin_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_admin_email'));
            $this->load->view( 'admin/admin_header' );
            $this->load->view( 'admin/admin_nav', $data );

            $data = $this->sidebar();
            $data['user_active'] = (bool) TRUE;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['user'] = NULL;
            $this->load->view( 'admin/admin_user_edit', $data );
            $this->load->view( 'admin/admin_footer' );
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function user_del($uid = NULL)
    {
        if ($this->is_login())
        {
            $uid = (int) $uid;
            if ($this->admin_model->del_user($uid))
            {
                //echo '{"result" : "success" }';
                echo "Success!";
                //redirect('admin/users');
            }
            else
            {
                echo 'Something Error!';
            }
            return;
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function user_edit($uid = NULL)
    {
        if ($this->is_login())
        {
            $uid = (int) $uid;
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_admin_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_admin_email'));
            $this->load->view( 'admin/admin_header' );
            $this->load->view( 'admin/admin_nav', $data );

            $data = $this->sidebar();
            $data['user_active'] = (bool) TRUE;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['user'] = $this->admin_model->get_users($uid)[0];
            $this->load->view( 'admin/admin_user_edit', $data );
            $this->load->view( 'admin/admin_footer' );
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function user_update($uid = NULL)
    {
        if ($this->is_login())
        {
            $mode = "insert";
            if ($uid)
            {
                $uid = (int) $uid;
                $mode = "update";
            }
            $user_name = $this->input->post('user_name');
            $email = $this->input->post('email');
            $pass = $this->input->post('pass');
            $passwd = $this->input->post('passwd');
            $u = $this->input->post('u');
            $d = $this->input->post('d');
            $transfer_enable = $this->input->post('transfer_enable');
            $plan = $this->input->post('plan');
            $port = $this->input->post('port');
            $switch = $this->input->post('switch');
            $enable = $this->input->post('enable');
            if ($user_name != "" && $email != "" && $pass != "" && $passwd != "" && $u != NULL && $d != NULL && $transfer_enable != NULL && $plan != "" && $port != "" && $switch != NULL && $enable != NULL )
            {
                if ($this->admin_model->update_user($mode, $uid, $user_name, $email, $pass, $passwd, $u, $d, $transfer_enable, $plan, $port, $switch, $enable ))
                {
                    //echo '{"result" : "success" }';
                    //echo '<script>alert("Success!");</script>';
                    echo "<script>alert(\"Success!\"); window.location.href = \"" . site_url('admin/users') . "\";</script>";
                    //redirect('admin/nodes');
                }
                else
                {
                    echo '{"result" : "Something Error!" }';
                }
            }
            else
            {
                echo '{"result" : "You miss something!" }';
            }
            return;
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function node_add()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_admin_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_admin_email'));
            $this->load->view( 'admin/admin_header' );
            $this->load->view( 'admin/admin_nav', $data );

            $data = $this->sidebar();
            $data['node_active'] = (bool) TRUE;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['node'] = NULL;
            $this->load->view( 'admin/admin_node_edit', $data );
            $this->load->view( 'admin/admin_footer' );
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function node_del($id = NULL)
    {
        if ($this->is_login())
        {
            $id = (int) $id;
            if ($this->admin_model->del_node($id))
            {
                //echo '{"result" : "success" }';
                echo "Success!";
                //redirect('admin/nodes');
            }
            else
            {
                echo 'Something Error!';
            }
            return;
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function node_edit($id = NULL)
    {
        if ($this->is_login())
        {
            $id = (int) $id;
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_admin_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_admin_email'));
            $this->load->view( 'admin/admin_header' );
            $this->load->view( 'admin/admin_nav', $data );

            $data = $this->sidebar();
            $data['node_active'] = (bool) TRUE;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['node'] = $this->admin_model->get_nodes($id)[0];
            $this->load->view( 'admin/admin_node_edit', $data );
            $this->load->view( 'admin/admin_footer' );
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function node_update($id = NULL)
    {
        if ($this->is_login())
        {
            $mode = "insert";
            if ($id)
            {
                $id = (int) $id;
                $mode = "update";
            }
            $node_name = $this->input->post('node_name');
            $node_server = $this->input->post('node_server');
            $node_info = $this->input->post('node_info');
            $node_method = $this->input->post('node_method');
            $node_type = $this->input->post('node_type');
            $node_status = $this->input->post('node_status');
            $node_order = $this->input->post('node_order');
            if ($node_name != "" && $node_server != "" && $node_info != "" && $node_type != NULL && $node_status != "" && $node_order != NULL)
            {
                if ($this->admin_model->update_node($mode, $id, $node_name, $node_server, $node_info, $node_method, $node_type, $node_status, $node_order ))
                {
                    //echo '{"result" : "success" }';
                    //echo '<script>alert("Success!");</script>';
                    echo "<script>alert(\"Success!\"); window.location.href = \"" . site_url('admin/nodes') . "\";</script>";
                    //redirect('admin/nodes');
                }
                else
                {
                    echo '{"result" : "Something Error!" }';
                }
            }
            else
            {
                echo '{"result" : "You miss something!" }';
            }
            return;
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function system_config()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_admin_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_admin_email'));
            $this->load->view( 'admin/admin_header' );
            $this->load->view( 'admin/admin_nav', $data );

            $data = $this->sidebar();
            $data['config_active'] = (bool) TRUE;
            $data['config_g_active'] = (bool) TRUE;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['configs'] = $this->admin_model->get_config();
            $this->load->view( 'admin/admin_config', $data );
            $this->load->view( 'admin/admin_footer' );
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function config_update()
    {
        if ($this->is_login())
        {
            $data = array(
                array(
                    'option_name' => 'invite_only',
                    'option_value' => strtolower($this->input->post('invite_only')),
                ),
                array(
                    'option_name' => 'default_transfer',
                    'option_value' => $this->input->post('default_transfer'),
                ),
                array(
                    'option_name' => 'default_invite_number',
                    'option_value' => $this->input->post('default_invite_number'),
                ),
                array(
                    'option_name' => 'check_min',
                    'option_value' => $this->input->post('check_min'),
                ),
                array(
                    'option_name' => 'check_max',
                    'option_value' => $this->input->post('check_max'),
                ),
                array(
                    'option_name' => 'version',
                    'option_value' => $this->input->post('version'),
                ),
                array(
                    'option_name' => 'default_method',
                    'option_value' => $this->input->post('default_method'),
                ),
                array(
                    'option_name' => 'need_activate',
                    'option_value' => strtolower($this->input->post('need_activate')),
                ),
                //array(
                //    'option_name' => '',
                //    'option_value' => $this->input->post(''),
                //),
            );
            if ( $this->admin_model->update_config($data) )
            {
                echo "<script>alert(\"Success!\"); window.location.href = \"" . site_url('admin/system_config') . "\";</script>";
            }
            else
            {
                echo "<script>alert(\"Something error!\"); window.location.href = \"" . site_url('admin/system_config') . "\";</script>";
            }
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function mail_config()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_admin_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_admin_email'));
            $this->load->view( 'admin/admin_header' );
            $this->load->view( 'admin/admin_nav', $data );

            $data = $this->sidebar();
            $data['config_active'] = (bool) TRUE;
            $data['config_m_active'] = (bool) TRUE;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['configs'] = $this->admin_model->get_config('mail');
            $this->load->view( 'admin/admin_config_email', $data );
            $this->load->view( 'admin/admin_footer' );
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function mail_config_update()
    {
        if ($this->is_login())
        {
            $data = array(
                array(
                    'option_name' => 'mail_protocol',
                    'option_value' => $this->input->post('mail_protocol'),
                ),
                array(
                    'option_name' => 'mail_mailpath',
                    'option_value' => $this->input->post('mail_mailpath'),
                ),
                array(
                    'option_name' => 'mail_smtp_host',
                    'option_value' => $this->input->post('mail_smtp_host'),
                ),
                array(
                    'option_name' => 'mail_smtp_user',
                    'option_value' => $this->input->post('mail_smtp_user'),
                ),
                array(
                    'option_name' => 'mail_smtp_pass',
                    'option_value' => $this->input->post('mail_smtp_pass'),
                ),
                array(
                    'option_name' => 'mail_smtp_port',
                    'option_value' => $this->input->post('mail_smtp_port'),
                ),
                array(
                    'option_name' => 'mail_smtp_crypto',
                    'option_value' => $this->input->post('mail_smtp_crypto'),
                ),
                array(
                    'option_name' => 'mail_sender_address',
                    'option_value' => $this->input->post('mail_sender_address'),
                ),
                array(
                    'option_name' => 'mail_sender_name',
                    'option_value' => $this->input->post('mail_sender_name'),
                ),
                array(
                    'option_name' => 'mail_sg_user',
                    'option_value' => $this->input->post('mail_sg_user'),
                ),
                array(
                    'option_name' => 'mail_sg_pass',
                    'option_value' => $this->input->post('mail_sg_pass'),
                )
            );
            if ( $this->admin_model->update_config($data) )
            {
                echo "<script>alert(\"Success!\"); window.location.href = \"" . site_url('admin/mail_config') . "\";</script>";
            }
            else
            {
                echo "<script>alert(\"Something error!\"); window.location.href = \"" . site_url('admin/mail_config') . "\";</script>";
            }
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function email_tpl()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_admin_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_admin_email'));
            $this->load->view( 'admin/admin_header' );
            $this->load->view( 'admin/admin_nav', $data );

            $data = $this->sidebar();
            $data['config_active'] = (bool) TRUE;
            $data['config_e_active'] = (bool) TRUE;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['email'] = $this->admin_model->get_config('email');
            $data['reset'] = $this->admin_model->get_config('reset');
            $data['resend'] = $this->admin_model->get_config('resend');
            $this->load->view( 'admin/admin_config_email_tpl', $data );
            $this->load->view( 'admin/admin_footer' );
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function email_tpl_update($part = NULL)
    {
        if ($this->is_login())
        {
            if ($part)
            {
                if ($part == 'email')
                {
                    $data = array(
                        array (
                            'option_name' => 'email_subject',
                            'option_value' => htmlspecialchars_decode($this->input->post('email_subject'))
                        ),
                        array (
                            'option_name' => 'email_body',
                            'option_value' => htmlspecialchars_decode($this->input->post('email_body'))
                        )
                    );
                }
                elseif ($part == 'reset')
                {
                    $data = array(
                        array (
                            'option_name' => 'reset_subject',
                            'option_value' => htmlspecialchars_decode($this->input->post('reset_subject'))
                        ),
                        array (
                            'option_name' => 'reset_body',
                            'option_value' => htmlspecialchars_decode($this->input->post('reset_body'))
                        )
                    );
                }
                elseif ($part == 'resend')
                {
                    $data = array(
                        array (
                            'option_name' => 'resend_subject',
                            'option_value' => htmlspecialchars_decode($this->input->post('resend_subject'))
                        ),
                        array (
                            'option_name' => 'resend_body',
                            'option_value' => htmlspecialchars_decode($this->input->post('resend_body'))
                        )
                    );
                }
                else
                {
                    echo "<script>alert(\"Something error!\"); window.location.href = \"" . site_url('admin/email_tpl') . "\";</script>";
                }
                if ($this->admin_model->update_config($data))
                {
                    echo "<script>alert(\"Success!\"); window.location.href = \"" . site_url('admin/email_tpl') . "\";</script>";
                }
                else
                {
                    echo "<script>alert(\"Database Error!\"); window.location.href = \"" . site_url('admin/email_tpl') . "\";</script>";
                }
            }
            else
            {
                echo "<script>alert(\"Something error!\"); window.location.href = \"" . site_url('admin/email_tpl') . "\";</script>";
            }
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function captcha_test()
    {
        if ($this->is_login())
        {
            $this->load->helper('captcha');
            $vals = array(
                'word_length' => 4,
                'img_width' => 100,
                'img_path' => 'captcha/',
                'img_url' => base_url() . 'captcha/',
                'pool' => '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ'
            );
            $cap = create_captcha($vals);
            echo $cap['image'];
        }
        else
        {
            redirect('admin/login');
        }
        return;
    }

    function my_info()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_admin_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_admin_email'));
            $this->load->view( 'admin/admin_profile_header' );
            $this->load->view( 'admin/admin_nav', $data );

            $data = $this->sidebar();
            $this->load->view( 'admin/admin_sidebar', $data );
            $this->load->view( 'admin/admin_profile', $data );
            //$this->load->view( 'user/user_footer' );
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function do_profile_update()
    {
        if ($this->is_login())
        {
            $username = $this->session->userdata('s_admin_username');
            $uid = $this->session->userdata('s_admin_uid');
            $nowpassword = $this->input->post('nowpassword');
            if ($nowpassword == "")
            {
                $nowpassword = NULL;
            }
            else
            {
                $nowpassword = hash( 'md5', $nowpassword );
            }
            $password = $this->input->post('password');
            if ($password == "")
            {
                $password = NULL;
            }
            else
            {
                $password = hash( 'md5', $password );
            }
            $repassword = $this->input->post('repassword');
            if ($repassword == "")
            {
                $repassword = NULL;
            }
            else
            {
                $repassword = hash( 'md5', $repassword );
            }
            $email = $this->input->post('email');
            if ($email == "")
            {
                $email = NULL;
            }
            $new_username = $this->input->post('username');
            if ($new_username == "")
            {
                $new_username = NULL;
            }
            elseif ($this->admin_model->u_select($new_username))
            {
                echo '{"result" : "用户名已存在！" }';
                return;
            }
            if ( ! $password && ! $email && ! $new_username )
            {
                echo '{"result" : "没有需要修改的项目！" }';
                return;
            }
            if ( $password == "" && $email == "" && $new_username == "")
            {
                echo '{"result" : "没有需要修改的项目！" }';
                return;
            }

            if ( $password && $password != "" && $repassword && $password != $repassword )
            {
                echo '{"result" : "请输入相同的新密码！" }';
                return;
            }
            if ( $email && $email != "" && ! filter_var($email, FILTER_VALIDATE_EMAIL) )
            {
                echo '{"result" : "邮箱不合法！" }';
                return;
            }
            if ( $this->admin_model->profile_update($uid, $username, $nowpassword, $password, $email, $new_username) )
            {
                echo '{"result" : "success" }';
                return;
            }
            else
            {
                echo '{"result" : "密码错误！" }';
                return;
            }

        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function user_log()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_admin_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_admin_email'));
            $this->load->view( 'admin/admin_header' );
            $this->load->view( 'admin/admin_nav', $data );

            $data = $this->sidebar();
            $data['log_active'] = (bool) TRUE;
            $data['log_u_active'] = (bool) TRUE;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['mode'] = "user";
            $data['logs'] = $this->admin_model->get_log('user');
            $this->load->view( 'admin/admin_log', $data );
            $this->load->view( 'admin/admin_footer' );

        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function mail_log()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_admin_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_admin_email'));
            $this->load->view( 'admin/admin_header' );
            $this->load->view( 'admin/admin_nav', $data );

            $data = $this->sidebar();
            $data['log_active'] = (bool) TRUE;
            $data['log_m_active'] = (bool) TRUE;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['mode'] = "mail";
            $data['logs'] = $this->admin_model->get_log('mail');
            $this->load->view( 'admin/admin_log_mail', $data );
            $this->load->view( 'admin/admin_footer' );

        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function admin_log()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_admin_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_admin_email'));
            $this->load->view( 'admin/admin_header' );
            $this->load->view( 'admin/admin_nav', $data );

            $data = $this->sidebar();
            $data['log_active'] = (bool) TRUE;
            $data['log_a_active'] = (bool) TRUE;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['mode'] = "admin";
            $data['logs'] = $this->admin_model->get_log('admin');
            $this->load->view( 'admin/admin_log', $data );
            $this->load->view( 'admin/admin_footer' );

        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }
}
