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
            echo '{"result" : "Username not valid!" }';
            return;
        }
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        if ( !filter_var($email, FILTER_VALIDATE_EMAIL) )
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
                        echo '{"result" : "E-mail send failed!" }';
                        return;
                    }
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

    //function guestbook()
    //{
    //    $this->load->view('guestbook');
    //    return;
    //}

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
                if ($user->pass == $password)
                {
                    $arr = array('s_uid' => $user->uid,
                        's_username' => $user->user_name,
                        's_email' => $user->email
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

            $user_info = $this->user_model->u_info($data['user_name']);
            $data['transfers'] = $user_info->u + $user_info->d;
            $data['all_transfer'] = $user_info->transfer_enable;
            $data['unused_transfer'] = human_file_size( $data['all_transfer'] - $data['transfers'] );
            $data['used_100'] = round( ($data['transfers'] / $data['all_transfer'] * 100), 2 );
            $data['transfers'] = human_file_size( $data['transfers'] );
            $data['all_transfer'] = human_file_size( $data['all_transfer'] );
            $data['passwd'] = $user_info->passwd;
            $data['plan'] = $user_info->plan;
            $data['port'] = $user_info->port;
            $data['last_check_in_time'] = $user_info->last_check_in_time;
            $data['unix_time'] = $user_info->t;
            $data['is_able_to_check_in'] = is_able_to_check_in( $user_info->last_check_in_time );

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
                echo '{"result" : "Nothing to change!" }';
                return;
            }
            if ( $password == "" && $email == "")
            {
                echo '{"result" : "Nothing to change!" }';
                return;
            }

            if ( $password && $password != "" && $repassword && $password != $repassword )
            {
                echo '{"result" : "Please type same password twice!" }';
                return;
            }
            if ( $email && $email != "" && ! filter_var($email, FILTER_VALIDATE_EMAIL) )
            {
                echo '{"result" : "E-mail not valid!" }';
                return;
            }
            if ( $this->user_model->profile_update($uid, $username, $nowpassword, $password, $email) )
            {
                echo '{"result" : "success" }';
                return;
            }
            else
            {
                echo '{"result" : "Wrong password!" }';
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
                echo '{"result" : "Nothing to change!" }';
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
                    echo '{"result" : "Something Wrong!" }';
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
                    echo "You now have " . $result . "MB more trafic!";
                    //redirect(site_url('user'));
                }
            }
            else 
            {
                echo 'Cannot Check In Now!';
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
                echo "<script>alert(\"Success!\"); window.location.href = \"" . site_url('user/login') . "\";</script>";
            }
            else
            {
                echo "<script>alert(\"Failed! Please check again!\"); window.location.href = \"" . site_url('user/login') . "\";</script>";
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
            if ( $this->do_send_mail($this->session->userdata('s_username')) )
            {
                echo "Success!";
            }
            else
            {
                echo "Send mail error!";
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
        if ($this->is_login())
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
                    return true;
                } else
                {
                    return false;
                }
            } else
            {
                return false;
            }
        }
        else
        {
            redirect(site_url('user/login'));
        }
    }

    function client_config($id = null)
    {
        if ($id == null)
        {
            echo "<script>alert('No server select!');</script>";
        }
        if ($this->is_login())
        {
            $user = $this->user_model->u_info($this->session->userdata('s_username'));
            $node = $this->user_model->get_nodes( false, $id )[0];
            $data['server'] = $node->node_server;
            $data['port'] = $user->port;
            $data['password'] = $user->passwd;
            $data['method'] = 'rc4-md5';
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
                echo '{"result" : "Not match!" }';
            }
        }
        else
        {
            echo '{"result" : "Something missing!" }';
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
                    return true;
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
        else
        {
            return false;
        }

    }

    function resend_password($code = null)
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
                    echo "<script>alert(\"Success!\nPlease check your email!\"); window.location.href = \"" . site_url('user/login') . "\";</script>";
                }
                else
                {
                    echo "<script>alert(\"Send mail error!\"); window.location.href = \"" . site_url('user/forget') . "\";</script>";
                }
            }
            else
            {
                echo "<script>alert(\"Failed! Please check again!\"); window.location.href = \"" . site_url('user/forget') . "\";</script>";
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
            return true;
        }
        else
        {
            return false;
        }
    }
}