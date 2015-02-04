<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/11/15
 * Time: 16:46
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

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        return;
    }

    function u_select($username)
    {
        $this->db->where('user_name', $username);
        $this->db->select('uid, user_name, pass, email');
        $query = $this->db->get('user');
        if ($query->num_rows() > 0)
        {
            return $query->result()[0];
        }
        else
        {
            return FALSE;
        }
    }

    function email_select($email)
    {
        $this->db->where('email', $email);
        $this->db->select('uid, email');
        $query = $this->db->get('user');
        if ($query->num_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    function need_invite()
    {
        $this->db->where('option_name', 'invite_only');
        $query = $this->db->get('options');
        if ( $query->result()[0]->option_value == 'true' )
        {
            return (bool) TRUE;
        }
        else
        {
            return (bool) FALSE;
        }
    }

    function get_default_transfer()
    {
        $this->db->where('option_name', 'default_transfer');
        $query = $this->db->get('options');
        return $query->result()[0]->option_value;
    }

    function get_default_invite_number()
    {
        $this->db->where('option_name', 'default_invite_number');
        $query = $this->db->get('options');
        return (int) $query->result()[0]->option_value;
    }

    function get_last_port()
    {
        $this->db->select('port');
        $this->db->order_by('uid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('user');
        return $query->result()[0]->port;
    }

    function deactive_code($invitecode, $username)
    {
        $data = array(
            'used' => (bool) TRUE,
            'user_name' => $username
            );
        $this->db->where('code', $invitecode);
        return $this->db->update('invite_code', $data );
    }

    function new_user($username, $password, $email, $invitecode = null)
    {
        if ($invitecode)
        {
            $this->deactive_code($invitecode, $username);
        }
        $this->load->helper('comm');
        $data = array(
            'user_name' => $username,
            'email' => $email,
            'pass' => $password,
            'passwd' => get_temp_pass(),
            't' => '0',
            'u' => '0',
            'd' => '0',
            'plan' => 'A',
            'transfer_enable' => $this->get_default_transfer(),
            'port' => $this->get_last_port() + rand( 2, 7 ),
            //'switch' => '0',
            //'enable' => '0',
            'type' => '7',
            'reg_date' => time(),
            'invite_num' => $this->get_default_invite_number(),
            'money' => '0'
        );
        if ($this->need_activate() == 'true')
        {
            $this->db->set('switch', '0', FALSE);
            $this->db->set('enable', '0', FALSE);
        }
        else
        {
            $this->db->set('switch', '1', FALSE);
            $this->db->set('enable', '1', FALSE);
        }
        //$this->db->set('reg_date', 'NOW()', FALSE);
        return $this->db->insert('user', $data);
    }

    function valid_code($invitecode)
    {
        $this->db->where('code', $invitecode);
        $query = $this->db->get('invite_code');
        if ($query->num_rows() > 0)
        {
            return (bool) !$query->result()[0]->used;
        }
        else
        {
            return (bool) FALSE;
        }
    }

    function u_info( $username )
    {
        $this->db->where('user_name', $username);
        $this->db->select('t, u, d, plan, transfer_enable, passwd, port, enable, last_check_in_time, money');
        $query = $this->db->get('user');
        if ($query->num_rows() > 0)
        {
            return $query->result()[0];
        }
        else
        {
            return (bool) FALSE;
        }
    }

    function u_basic_info( $username )
    {
        $this->db->where('user_name', $username);
        $this->db->select('email, plan, money');
        $query = $this->db->get('user');
        if ($query->num_rows() > 0)
        {
            return $query->result()[0];
        }
        else
        {
            return (bool) FALSE;
        }
    }

    function get_nodes( $test = FALSE, $id = null )
    {
        if ($id)
        {
            $this->db->where('id', $id);
        }
        elseif ($test)
        {
            $this->db->where('node_type', '1');
        }
        else
        {
            $this->db->where('node_type', '0');
        }

        $this->db->order_by('node_order', 'ASC');
        $query = $this->db->get('ss_node');
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return (bool) FALSE;
        }
    }

    function get_invite_codes($uid = NULL)
    {
        $this->db->where('user', '2');
        $this->db->where('used', '0');
        if ($uid && $uid != "")
        {
            $where = "( owner = 0 or owner = {$uid} or owner is NULL)";
            $this->db->where($where);
        }
        $query = $this->db->get('invite_code');
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return (bool) FALSE;
        }
    }

    function get_code_number($uid)
    {
        $this->db->select('invite_num');
        $this->db->where('uid', $uid);
        $query = $this->db->get('user');
        if ($query->num_rows() > 0)
        {
            return $query->result()[0]->invite_num;
        }
        else
        {
            return FALSE;
        }
    }
    function generate_user_code($uid)
    {
        $invite_num = $this->get_code_number($uid);
        if ($invite_num > 0)
        {
            $invite_num--;
            $x = rand(10, 1000);
            $z = rand(10, 1000);
            $x = md5($x).md5($z);
            $x = base64_encode($x);
            $code = substr($x, rand(1, 13), 24);
            $data = array(
                'code' => $code,
                'user' => '2',
                'owner' => $uid
            );
            if ($this->db->insert('invite_code', $data))
            {
                $data = array('invite_num' => $invite_num);
                $this->db->where('uid', $uid);
                $this->db->limit(1);
                if ($this->db->update('user',$data))
                {
                    $data = array(
                        'result' => TRUE,
                        'code' => $code
                    );
                    return $data;
                }
                else
                {
                    return FALSE;
                }
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }

    function profile_update($uid, $username, $nowpassword, $password, $email)
    {
        $this->db->where('uid', $uid);
        $this->db->where('user_name', $username);
        $this->db->where('pass', $nowpassword);
        $query = $this->db->get('user');
        if ($query->num_rows() > 0)
        {
            $data = array(
                'pass' => $password,
                'email' => $email,
                'switch' => 0,
                'enable' => 0
            );
            if ( !$password )
            {
                unset($data['pass']);
            }
            if ( !$email || $email == "" )
            {
                unset($data['email']);
                unset($data['switch']);
                unset($data['enable']);
            }
            $this->db->where('uid', $uid);
            return $this->db->update('user', $data );
        }
        else
        {
            return (bool) FALSE;
        }
    }

    function change_ss_pass($uid, $username, $pass)
    {
        $data = array( 'passwd' => $pass );
        $this->db->where('uid', $uid);
        $this->db->where('user_name', $username);
        return $this->db->update('user', $data );
    }

    function check_in($username)
    {
        $this->db->where('option_name', 'check_min');
        $this->db->select('option_value');
        $query = $this->db->get('options');
        if ($query->num_rows() > 0)
        {
            $check_min = $query->result()[0]->option_value;
        }
        else
        {
            $check_min = 50;
        }

        $this->db->where('option_name', 'check_max');
        $this->db->select('option_value');
        $query = $this->db->get('options');
        if ($query->num_rows() > 0)
        {
            $check_max = $query->result()[0]->option_value;
        }
        else
        {
            $check_max = 100;
        }

        $transfer_to_add = rand($check_min,$check_max);
        $this->add_transfer($username, $transfer_to_add  * 1024 * 1024 );
        $data = array( 'last_check_in_time' => time() );
        $this->db->where('user_name', $username);
        $this->db->update('user', $data);
        return $transfer_to_add;
    }

    function get_transfer_enable($username)
    {
        if ($username)
        {
            $this->db->where('user_name', $username);
            $this->db->select('transfer_enable');
            return $this->db->get('user')->result()[0]->transfer_enable;
        }
        return (bool) FALSE;
    }

    function add_transfer($username = null, $amount)
    {
        $transfer = $this->get_transfer_enable($username) + $amount;
        $data = array( 'transfer_enable' => $transfer );
        if ( $username )
        {
            $this->db->where('user_name', $username);
        }
        return $this->db->update( 'user', $data );
    }

    function send_active_email($username)
    {
        $user = $this->u_select($username);
        if ($user)
        {
            $x = $user->user_name;
            $y = $user->pass;
            $z = rand(10, 10000);
            $x = md5($x).md5($y).md5($z);
            $x = base64_encode($x);
            $x = base64_encode(md5(md5($x).md5($user->uid)));
            $code = substr($x, rand(1, 13), 24);
            $data = array(
                'activate_code' => $code,
                'uid' => $user->uid,
                'user_name' => $user->user_name,
                'email' => $user->email,
                'used' => 0
            );
            $this->db->insert('activate', $data);
            $data = array(
                'email' => $user->email,
                'activate_code' => $code
            );
            return $data;
        }
        else
        {
            return FALSE;
        }
    }

    function activate($code)
    {
        $this->db->where('activate_code', $code);
        $query = $this->db->get('activate');
        if ($query->num_rows() > 0 && !$query->result()[0]->used)
        {
            $data = array('used' => 1 );
            $this->db->where('activate_code', $code);
            $this->db->limit(1);
            $this->db->update('activate',$data);

            $result = $query->result()[0];
            $data = array(
                'switch' => 1,
                'enable' => 1
            );
            $this->db->where('uid', $result->uid);
            $this->db->where('user_name', $result->user_name);
            $this->db->where('email', $result->email);
            $this->db->limit(1);
            return $this->db->update('user',$data);
        }
        else
        {
            return FALSE;
        }
    }

    function check_reset_code($code)
    {
        $this->db->where('reset_code', $code);
        $query = $this->db->get('reset');
        if ($query->num_rows() > 0 && !$query->result()[0]->used)
        {
            $data = array('used' => 1 );
            $this->db->where('reset_code', $code);
            $this->db->limit(1);
            $this->db->update('reset',$data);

            $result = $query->result()[0];
            $new_password = $this->generate_passwd($result->user_name);
            $new_password_md5 = md5($new_password);
            $data = array(
                'pass' => $new_password_md5
            );
            $this->db->where('uid', $result->uid);
            $this->db->where('user_name', $result->user_name);
            $this->db->where('email', $result->email);
            $this->db->limit(1);
            if ($this->db->update('user',$data))
            {
                $data = array(
                    'user_name' => $result->user_name,
                    'new_password' => $new_password,
                    'email' => $result->email
                );
                return $data;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }

    function get_email_subject()
    {
        $this->db->where('option_name', 'email_subject');
        $this->db->select('option_value');
        $query = $this->db->get('options');
        if ($query->num_rows() > 0)
        {
            return $query->result()[0]->option_value;
        }
        else
        {
            return FALSE;
        }
    }

    function get_email_templates()
    {
        $this->db->where('option_name', 'email_body');
        $this->db->select('option_value');
        $query = $this->db->get('options');
        if ($query->num_rows() > 0)
        {
            return $query->result()[0]->option_value;
        }
        else
        {
            return FALSE;
        }
    }

    function generate_reset_code($username = null)
    {
        if (!empty($username))
        {
            $user = $this->u_select($username);
            $this->db->where('user_name', $username);
            $x = $username;
            $x = md5($x);
            $x = substr($x,rand(1,9),13);
            $y = rand(10,1000);
            $y = md5($y);
            $y = substr($y,rand(1,9),13);
            $code = md5($x.$y);
            $data = array(
                'reset_code' => $code,
                'uid' => $user->uid,
                'user_name' => $user->user_name,
                'email' => $user->email,
                'used' => 0
            );
            $this->db->insert('reset', $data);
            $data = array(
                'email' => $user->email,
                'reset_code' => $code
            );
            return $data;
        }
    }

    function generate_passwd($username = null)
    {
        if (!empty($username))
        {
            $this->db->where('user_name', $username);
            $x = rand(10,1000);
            $x = md5($x);
            $x = substr($x,rand(1,9),13);
            $y = rand(10,1000);
            $y = md5($y);
            $y = substr($y,rand(1,9),13);
            $password = substr($x.$y, rand(2,15), 10);
            return $password;
        }
    }

    function get_reset_subject()
    {
        $this->db->where('option_name', 'reset_mail_subject');
        $this->db->select('option_value');
        $query = $this->db->get('options');
        if ($query->num_rows() > 0)
        {
            return $query->result()[0]->option_value;
        }
        else
        {
            return FALSE;
        }
    }

    function get_reset_templates()
    {
        $this->db->where('option_name', 'reset_mail_body');
        $this->db->select('option_value');
        $query = $this->db->get('options');
        if ($query->num_rows() > 0)
        {
            return $query->result()[0]->option_value;
        }
        else
        {
            return FALSE;
        }
    }

    function get_resend_subject()
    {
        $this->db->where('option_name', 'resend_mail_subject');
        $this->db->select('option_value');
        $query = $this->db->get('options');
        if ($query->num_rows() > 0)
        {
            return $query->result()[0]->option_value;
        }
        else
        {
            return FALSE;
        }
    }

    function get_resend_templates()
    {
        $this->db->where('option_name', 'resend_mail_body');
        $this->db->select('option_value');
        $query = $this->db->get('options');
        if ($query->num_rows() > 0)
        {
            return $query->result()[0]->option_value;
        }
        else
        {
            return FALSE;
        }
    }

    function get_default_method()
    {
        $this->db->where('option_name', 'default_method');
        $this->db->select('option_value');
        $query = $this->db->get('options');
        if ($query->num_rows() > 0)
        {
            return $query->result()[0]->option_value;
        }
        else
        {
            return FALSE;
        }
    }

    function log_login($username, $password, $ip, $ua, $result)
    {
        $data = array(
            'user_name' => $username,
            'pass' => $password,
            'ip' => $ip,
            'ua' => $ua,
            'result' => $result,
            'time' => time()
        );
        return $this->db->insert('user_login', $data);
    }

    function log_send_mail($username, $email, $ip, $ua, $result)
    {
        $data = array(
            'user_name' => $username,
            'email' => $email,
            'ip' => $ip,
            'ua' => $ua,
            'result' => $result,
            'time' => time()
        );
        return $this->db->insert('mail_log', $data);
    }

    function need_activate()
    {
        $this->db->select('option_value');
        $this->db->where('option_name', 'need_activate');
        $query = $this->db->get('options');
        if ($query->num_rows() > 0)
        {
            return $query->result()[0]->option_value;
        }
    }

    function create_transaction($trade_no, $user_name, $amount, $ip)
    {
        $data = array(
            'trade_no' => $trade_no,
            'user_name' => $user_name,
            'amount' => $amount,
            'ip' => $ip,
            'result' => FALSE,
            'ctime' => time(),
            'ftime' => 0
        );

        return $this->db->insert('transactions', $data);
    }

    function insert_trade_form($trade_no, $user_name, $body)
    {
        $data = array(
            'trade_no' => $trade_no,
            'user_name' => $user_name,
            'body' => $body,
            'time' => time()
        );

        return $this->db->insert('transaction_form', $data);
    }

    function t_select($trade_no)
    {
        $this->db->where('trade_no', $trade_no);
        $query = $this->db->get('transactions');
        if ($query->num_rows() > 0)
        {
            return $query->result()[0];
        }
        else
        {
            return FALSE;
        }
    }

    function t_f_select($trade_no)
    {
        $this->db->where('trade_no', $trade_no);
        $query = $this->db->get('transaction_form');
        if ($query->num_rows() > 0)
        {
            return $query->result()[0];
        }
        else
        {
            return FALSE;
        }
    }

    function get_log($mode = NULL, $user_name)
    {
        if ($mode)
        {
            $this->db->limit(100);
            switch($mode)
            {
                case "login":
                    $this->db->order_by('time', 'DESC');
                    $this->db->where('user_name', $user_name);
                    return $this->db->get('user_login')->result();
                case "pay":
                    $this->db->where('user_name', $user_name);
                    return $this->db->get('transactions')->result();
                case "order":
                    $this->db->where('user_name', $user_name);
                    return $this->db->get('orders')->result();
            }
        }
    }
}
