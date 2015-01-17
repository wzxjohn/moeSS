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

    function sidebar()
    {
        $sidebar_data['index_active'] = (bool) false;
        $sidebar_data['user_active'] = (bool) false;
        $sidebar_data['node_active'] = (bool) false;
        $sidebar_data['code_active'] = (bool) false;
        $sidebar_data['system_active'] = (bool) false;
        $sidebar_data['config_active'] = (bool) false;
        $sidebar_data['config_g_activate'] = (bool) false;
        $sidebar_data['config_m_activate'] = (bool) false;
        $sidebar_data['config_e_activate'] = (bool) false;
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
            $data['index_active'] = (bool) true;
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
    }

    function is_login()
    {
        if ($this->session->userdata('s_admin_uid') && $this->session->userdata('admin') == 'true')
        {
            return $this->admin_model->check_admin($this->session->userdata('s_admin_uid'), $this->session->userdata('s_admin_username') );
        }
        else
        {
            return false;
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
            $data['user_active'] = (bool) true;
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
            $data['node_active'] = (bool) true;
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
            $data['code_active'] = (bool) true;
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
            $data['system_active'] = (bool) true;
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
            $data['code_active'] = (bool) true;
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
            $data['user_active'] = (bool) true;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['user'] = null;
            $this->load->view( 'admin/admin_user_edit', $data );
            $this->load->view( 'admin/admin_footer' );
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function user_del($uid = null)
    {
        if ($this->is_login())
        {
            $uid = (int) $uid;
            if ($this->admin_model->del_user($uid))
            {
                //echo '{"result" : "success" }';
                echo "<script>alert(\"Success!\"); window.location.href = \"" . site_url('admin/users') . "\";</script>";
                //redirect('admin/users');
            }
            else
            {
                echo '{"result" : "Something Error!" }';
            }
            return;
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function user_edit($uid = null)
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
            $data['user_active'] = (bool) true;
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

    function user_update($uid = null)
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
            if ($user_name != "" && $email != "" && $pass != "" && $passwd != "" && $u != null && $d != null && $transfer_enable != null && $plan != "" && $port != "" && $switch != null && $enable != null )
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
            $data['node_active'] = (bool) true;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['node'] = null;
            $this->load->view( 'admin/admin_node_edit', $data );
            $this->load->view( 'admin/admin_footer' );
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function node_del($id = null)
    {
        if ($this->is_login())
        {
            $id = (int) $id;
            if ($this->admin_model->del_node($id))
            {
                //echo '{"result" : "success" }';
                echo "<script>alert(\"Success!\"); window.location.href = \"" . site_url('admin/nodes') . "\";</script>";
                //redirect('admin/nodes');
            }
            else
            {
                echo '{"result" : "Something Error!" }';
            }
            return;
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }

    function node_edit($id = null)
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
            $data['node_active'] = (bool) true;
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

    function node_update($id = null)
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
            $node_type = $this->input->post('node_type');
            $node_status = $this->input->post('node_status');
            $node_order = $this->input->post('node_order');
            if ($node_name != "" && $node_server != "" && $node_info != "" && $node_type != null && $node_status != "" && $node_order != null)
            {
                if ($this->admin_model->update_node($mode, $id, $node_name, $node_server, $node_info, $node_type, $node_status, $node_order ))
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
            $data['config_active'] = (bool) true;
            $data['config_g_active'] = (bool) true;
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
                    'option_value' => $this->input->post('invite_only'),
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
            $data['config_active'] = (bool) true;
            $data['config_m_active'] = (bool) true;
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
            $data['config_active'] = (bool) true;
            $data['config_e_active'] = (bool) true;
            $this->load->view( 'admin/admin_sidebar', $data );

            $data['configs'] = $this->admin_model->get_config('email');
            $this->load->view( 'admin/admin_config_email_tpl', $data );
            $this->load->view( 'admin/admin_footer' );
        }
        else
        {
            redirect(site_url('admin/login'));
        }
        return;
    }
}