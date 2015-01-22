<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/11/15
 * Time: 16:43
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
            if ($data['all_transfer'] == 0)
            {
                $data['used_100'] = 0;
            }
            else
            {
                $data['used_100'] = round(($data['transfers'] / $data['all_transfer'] * 100), 2);
            }
            $data['transfers'] = human_file_size( $data['transfers'] );
            $data['all_transfer'] = human_file_size( $data['all_transfer'] );
            $data['passwd'] = $user_info->passwd;
            $data['plan'] = $user_info->plan;
            $data['port'] = $user_info->port;
            $data['last_check_in_time'] = $user_info->last_check_in_time;
            $data['unix_time'] = $user_info->t;
            $data['is_able_to_check_in'] = is_able_to_check_in( $user_info->last_check_in_time );
            $data['enable'] = $user_info->enable;

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

    function register($code = null)
    {
        if ( $this->user_model->need_invite() )
        {
            $data['invite_only'] = true;
            $data['code'] = $code;
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
            echo '{"result" : "用户名不合法！" }';
            return;
        }
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        if ( !filter_var($email, FILTER_VALIDATE_EMAIL) )
        {
            echo '{"result" : "邮箱不合法！" }';
            return;
        }
        $invitecode = $this->input->post('code');

        if ( $username && $password && $email )
        {
            $user = $this->user_model->u_select($username);
            if ($user)
            {
                echo '{"result" : "用户名已存在！" }';
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
                            echo '{"result" : "邀请码无效！" }';
                            return;
                        }
                    }
                    else
                    {
                        echo '{"result" : "请输入邀请码！" }';
                        return;
                    }
                }
                $this->load->helper('string');
                $username = strip_slashes(strip_quotes($username));
                $this->load->helper('security');
                $password = hash('md5', $password );
                if ( $this->user_model->new_user($username, $password, $email, $invitecode) )
                {
                    if ( $this->do_send_mail($username) )
                    {
                        echo '{"result" : "success" }';
                        return;
                    }
                    else
                    {
                        echo '{"result" : "邮件发送失败！" }';
                        return;
                    }
                }
                else
                {
                    echo '{"result" : "数据库错误！" }';
                    return;
                }
            }
        }
        else
        {
            echo '{"result" : "缺少参数！" }';
            return;
        }
    }

    //function guestbook()
    //{
    //    $this->load->view('guestbook');
    //    return;
    //}

    function login_check()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $remember_me = $this->input->post('remember_me');
        if ($username && $password)
        {
            $this->load->model('user_model');
            $user = $this->user_model->u_select($username);
            if ($user)
            {
                if ($user->pass == $password)
                {
                    $arr = array('s_uid' => $user->uid,
                        's_username' => $user->user_name,
                        's_email' => $user->email
                    );
                    if ($remember_me == "week")
                    {
                        $this->session->sess_expiration = 60 * 60 * 24 * 7;
                    }
                    else
                    {
                        $this->session->sess_expiration = NULL;
                    }
                    $this->session->set_userdata($arr);
                    echo '{"result" : "success" }';
                    $this->user_model->log_login($username, $password, $this->input->ip_address(), $this->input->user_agent(), TRUE);
                    //redirect(site_url('admin'));
                }
                else
                {
                    echo '{"result" : "用户名或密码错误！" }';
                    $this->user_model->log_login($username, $password, $this->input->ip_address(), $this->input->user_agent(), FALSE);
                    //redirect(site_url('admin/login/'));
                }
            }
            else
            {
                echo '{"result" : "用户名或密码错误！" }';
                $this->user_model->log_login($username, $password, $this->input->ip_address(), $this->input->user_agent(), FALSE);
                //redirect(site_url('admin/login/'));
            }
        }
        else
        {
            echo '{"result" : "用户名或密码错误！" }';
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

    function node_list()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_email'));
            $this->load->view( 'user/user_header' );
            $this->load->view( 'user/user_nav', $data );

            $data['index_active'] = (bool) false;
            $data['node_active'] = (bool) true;
            $data['info_active'] = (bool) false;
            $data['update_active'] = (bool) false;
            $data['code_active'] = (bool) false;
            $this->load->view( 'user/user_sidebar', $data );

            $nodes = $this->user_model->get_nodes( (bool) false );
            $test_nodes = $this->user_model->get_nodes( (bool) true );
            $data['nodes'] = $nodes;
            $data['test_nodes'] = $test_nodes;
            $data['default_method'] = $this->user_model->get_default_method();

            $this->load->view( 'user/user_nodes', $data );
            $this->load->view( 'user/user_footer' );
        }
        else
        {
            redirect(site_url('user/login'));
        }
        return;
    }

    function my_info()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_email'));
            $this->load->view( 'user/user_header' );
            $this->load->view( 'user/user_nav', $data );

            $data['index_active'] = (bool) false;
            $data['node_active'] = (bool) false;
            $data['info_active'] = (bool) true;
            $data['update_active'] = (bool) false;
            $data['code_active'] = (bool) false;
            $this->load->view( 'user/user_sidebar', $data );

            $user_info = $this->user_model->u_basic_info($data['user_name']);
            $data['user_email'] = $user_info->email;
            $data['plan'] = $user_info->plan;
            $data['money'] = $user_info->money;

            $this->load->view( 'user/user_info', $data );
            $this->load->view( 'user/user_footer' );
        }
        else
        {
            redirect(site_url('user/login'));
        }
        return;
    }

    function profile_update()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_email'));
            $this->load->view( 'user/user_profile_header' );
            $this->load->view( 'user/user_nav', $data );

            $data['index_active'] = (bool) false;
            $data['node_active'] = (bool) false;
            $data['info_active'] = (bool) false;
            $data['update_active'] = (bool) true;
            $data['code_active'] = (bool) false;
            $this->load->view( 'user/user_sidebar', $data );

//            $user_info = $this->user_model->u_info($data['user_name']);
//            $data['transfers'] = $user_info->u + $user_info->d;
//            $data['all_transfer'] = $user_info->transfer_enable;
//            $data['unused_transfer'] = human_file_size( $data['all_transfer'] - $data['transfers'] );
//            $data['used_100'] = round( ($data['transfers'] / $data['all_transfer'] * 100), 2 );
//            $data['transfers'] = human_file_size( $data['transfers'] );
//            $data['all_transfer'] = human_file_size( $data['all_transfer'] );
//            $data['passwd'] = $user_info->passwd;
//            $data['plan'] = $user_info->plan;
//            $data['port'] = $user_info->port;
//            $data['last_check_in_time'] = $user_info->last_check_in_time;
//            $data['unix_time'] = $user_info->t;
//            $data['is_able_to_check_in'] = is_able_to_check_in( $user_info->last_check_in_time );

            $this->load->view( 'user/user_profile', $data );
            //$this->load->view( 'user/user_footer' );
        }
        else
        {
            redirect(site_url('user/login'));
        }
        return;
    }

    function invite_code()
    {
        if ($this->is_login())
        {
            //$this->load->view('welcome_message');
            $this->load->helper('comm');
            $data['user_name'] = $this->session->userdata('s_username');
            $data['gravatar'] = get_gravatar($this->session->userdata('s_email'));
            $this->load->view( 'user/user_header' );
            $this->load->view( 'user/user_nav', $data );

            $data['index_active'] = (bool) false;
            $data['node_active'] = (bool) false;
            $data['info_active'] = (bool) false;
            $data['update_active'] = (bool) false;
            $data['code_active'] = (bool) true;
            $this->load->view( 'user/user_sidebar', $data );

            $codes = $this->user_model->get_invite_codes();
            $data['codes'] = $codes;

            $this->load->view( 'user/user_code', $data );
            $this->load->view( 'user/user_footer' );
        }
        else
        {
            redirect(site_url('user/login'));
        }
        return;
    }

    function pay()
    {
        redirect(site_url('user'));
        return;
    }

    function do_profile_update()
    {
        if ($this->is_login())
        {
            $username = $this->session->userdata('s_username');
            $uid = $this->session->userdata('s_uid');
            $nowpassword = $this->input->post('nowpassword');
            if ($nowpassword == "")
            {
                $nowpassword = null;
            }
            else
            {
                $nowpassword = hash( 'md5', $nowpassword );
            }
            $password = $this->input->post('password');
            if ($password == "")
            {
                $password = null;
            }
            else
            {
                $password = hash( 'md5', $password );
            }
            $repassword = $this->input->post('repassword');
            if ($repassword == "")
            {
                $repassword = null;
            }
            else
            {
                $repassword = hash( 'md5', $repassword );
            }
            $email = $this->input->post('email');
            if ($email == "")
            {
                $email = null;
            }
            if ( ! $password && ! $email )
            {
                echo '{"result" : "没有需要修改的项目！" }';
                return;
            }
            if ( $password == "" && $email == "")
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
            if ( $this->user_model->profile_update($uid, $username, $nowpassword, $password, $email) )
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
            redirect(site_url('user/login'));
        }
    }

    function update_ss_pass()
    {
        if ($this->is_login())
        {
            $username = $this->session->userdata('s_username');
            $uid = $this->session->userdata('s_uid');
            $pass = $this->input->post('pass');
            if ( ! $pass )
            {
                echo '{"result" : "没有需要修改的项目！" }';
                return;
            }
            else
            {
                if ( $this->user_model->change_ss_pass($uid, $username, $pass) )
                {
                    echo '{"result" : "success" }';
                    return;
                }
                else
                {
                    echo '{"result" : "Opps，出错了。。。" }';
                    return;
                }
            }
        }
        else
        {
            redirect(site_url('user/login'));
        }
    }

    function check_in()
    {
        if ($this->is_login())
        {
            $this->load->helper('comm');
            $username = $this->session->userdata('s_username');
            $user_info = $this->user_model->u_info($username);
            $last_check_in_time = $user_info->last_check_in_time;
            if ( is_able_to_check_in( $last_check_in_time ) )
            {
                $result = $this->user_model->check_in($username);
                if ( $result )
                {
                    echo "你获得了 " . $result . "MB 流量！";
                    //redirect(site_url('user'));
                }
            }
            else 
            {
                echo '现在无法签到！';
                //redirect(site_url('user'));
            }
        }
        else
        {
            redirect(site_url('user/login'));
        }
        return;
    }

    function activate($code = null)
    {
        if ($code)
        {
            if ( $this->user_model->activate($code) )
            {
                echo "<script>alert(\"激活成功！\"); window.location.href = \"" . site_url('user/login') . "\";</script>";
            }
            else
            {
                echo "<script>alert(\"激活失败！请检查链接！\"); window.location.href = \"" . site_url('user/login') . "\";</script>";
            }
        }
        else
        {
            redirect(site_url('user/login'));
        }
        return;
    }

    function resend_mail()
    {
        if ($this->is_login())
        {
            if ($this->user_model->u_info($this->session->userdata('s_username'))->enable)
            {
                echo "该用户已经激活，无需重发！";
                return;
            }
            if ( $this->do_send_mail($this->session->userdata('s_username')) )
            {
                echo "重发成功！";
            }
            else
            {
                echo "邮件发送失败！";
            }
        }
        else
        {
            redirect(site_url('user/login'));
        }
        return;
    }

    private function do_send_mail($username)
    {
        $data = $this->user_model->send_active_email($username);
        if ($data)
        {
            $email = $data['email'];
            $code = $data['activate_code'];
            $subject = $this->user_model->get_email_subject();
            $html = $this->user_model->get_email_templates();
            $html = str_replace('%{activate_link}%', site_url("user/activate/$code"), $html);
            $this->load->helper('comm');
            if (send_mail(null, null, $email, $subject, $html))
            {
                $this->user_model->log_send_mail($username, $email, $this->input->ip_address(), $this->input->user_agent(), TRUE);
                return true;
            }
            else
            {
                $this->user_model->log_send_mail($username, $email, $this->input->ip_address(), $this->input->user_agent(), FALSE);
                return false;
            }
        } else
        {
            return false;
        }
    }

    function client_config($id = null)
    {
        if ($id == null)
        {
            echo "<script>alert('请选择服务器！');</script>";
        }
        if ($this->is_login())
        {
            $user = $this->user_model->u_info($this->session->userdata('s_username'));
            $node = $this->user_model->get_nodes( false, $id )[0];
            $data['server'] = $node->node_server;
            $data['port'] = $user->port;
            $data['password'] = $user->passwd;
            $data['method'] = $node->node_method;
            $data['ssurl'] = 'ss://' . base64_encode($data['method'] . ":" . $data['password'] . "@" . $data['server'] . ":" . $data['port']);
            $this->load->view('user/user_config', $data);
        }
        else
        {
            redirect(site_url('user/login'));
        }
        return;
    }

    function forget()
    {
        if ($this->is_login())
        {
            redirect(site_url('user/login'));
        }
        else
        {
            $this->load->view('user/user_forget');
        }
        return;
    }

    function reset_passwd()
    {
        $user_name = $this->input->post('username');
        $email = $this->input->post('email');
        if (!empty($user_name) && !empty($email))
        {
            $user = $this->user_model->u_select($user_name);
            if ($user->email == $email)
            {
                $this->do_send_reset($user_name, $email);
                echo '{"result" : "success" }';
            }
            else
            {
                echo '{"result" : "用户名和邮箱不匹配！" }';
            }
        }
        else
        {
            echo '{"result" : "请填写用户名和邮箱！" }';
        }
    }

    private function do_send_reset($user_name, $email)
    {
        $data = $this->user_model->generate_reset_code($user_name);
        if ($data)
        {
            if ($email == $data['email'])
            {
                $code = $data['reset_code'];
                $subject = $this->user_model->get_reset_subject();
                $html = $this->user_model->get_reset_templates();
                $html = str_replace('%{reset_link}%', site_url("user/resend_pass/$code"), $html);
                $this->load->helper('comm');
                if (send_mail(null, null, $email, $subject, $html))
                {
                    $this->user_model->log_send_mail($user_name, $email, $this->input->ip_address(), $this->input->user_agent(), TRUE);
                    return true;
                }
                else
                {
                    $this->user_model->log_send_mail($user_name, $email, $this->input->ip_address(), $this->input->user_agent(), FALSE);
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }

    }

    function resend_pass($code = null)
    {
        if ($code)
        {
            $data = $this->user_model->check_reset_code($code);
            if ($data)
            {
                $new_password = $data['new_password'];
                $username = $data['user_name'];
                $email = $data['email'];
                if ($this->do_resend_passwd($username, $new_password, $email))
                {
                    echo "<script>alert(\"密码重置成功！\\n请查收邮件！\"); window.location.href = \"" . site_url('user/login') . "\";</script>";
                }
                else
                {
                    echo "<script>alert(\"邮件发送失败！\"); window.location.href = \"" . site_url('user/forget') . "\";</script>";
                }
            }
            else
            {
                echo "<script>alert(\"密码重置失败！请检查链接！\"); window.location.href = \"" . site_url('user/forget') . "\";</script>";
            }
        }
        else
        {
            redirect('user/forget');
        }
        return;
    }

    private function do_resend_passwd($username, $new_password, $email)
    {
        $subject = $this->user_model->get_resend_subject();
        $html = $this->user_model->get_resend_templates();
        $html = str_replace('%{username}%', $username, $html);
        $html = str_replace('%{password}%', $new_password, $html);
        $this->load->helper('comm');
        if (send_mail(null,null,$email,$subject,$html))
        {
            $this->user_model->log_send_mail($username, $email, $this->input->ip_address(), $this->input->user_agent(), TRUE);
            return true;
        }
        else
        {
            $this->user_model->log_send_mail($username, $email, $this->input->ip_address(), $this->input->user_agent(), FALSE);
            return false;
        }
    }
}