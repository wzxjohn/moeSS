<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/10/15
 * Time: 15:22
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

class Admin_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        return $this->load->database();
    }

    function check_admin($uid, $username)
    {
        $this->db->where('admin_name', $username);
        $this->db->where('uid', $uid);
        $this->db->select('uid');
        $query = $this->db->get('ss_admin');
        if ($query->num_rows() > 0)
        {
            return (bool) TRUE;
        }
        else
        {
            return (bool) FALSE;
        }
    }

    function u_select($username)
    {
        $this->db->where('admin_name', $username);
        $this->db->select('*');
        $query = $this->db->get('ss_admin');
        return $query->result();
    }

    function c_nodes()
    {
        return $this->db->count_all('ss_node');
    }

    function c_users()
    {
        return $this->db->count_all('user');
    }

    function get_users($uid = NULL)
    {
        if ($uid)
        {
            $this->db->where('uid',$uid);
        }
        $this->db->select('uid, user_name, email, pass, passwd, t, u, d, plan, transfer_enable, port, switch, enable, last_check_in_time, reg_date');
        return $this->db->get('user')->result();
    }

    function c_active_users()
    {
        $this->db->where('t >', '0');
        return $this->db->count_all_results('user');
    }

    function get_month_traffic()
    {
        $this->db->select_sum('u');
        $query = $this->db->get('user');
        $u = $query->result()[0]->u;
        $this->db->select_sum('d');
        $query = $this->db->get('user');
        $d = $query->result()[0]->d;
        return $u + $d;
    }

    function c_user_time($time)
    {
        $now = time();
        $time = $now - $time;
        $this->db->where('t >', $time);
        return $this->db->count_all_results('user');
    }

    function get_version()
    {
        $this->db->where('option_name', 'version');
        $query = $this->db->get('options');
        if ($query->num_rows() > 0)
        {
            return $query->result()[0]->option_value;
        }
        return 0;
    }

    function add_code($sub,$type,$num)
    {
        $datas = array();
        for($a=0;$a<$num;$a++)
        {
            $x = rand(10, 1000);
            $z = rand(10, 1000);
            $x = md5($x).md5($z);
            $x = base64_encode($x);
            $code = $sub.substr($x, rand(1, 13), 24);
            $data = array(
                'code' => $code,
                'user' => $type
            );
            array_push($datas, $data);
        }
        return $this->db->insert_batch('invite_code', $datas);
    }

    function add_code_num($user_name = NULL, $uid = NULL, $num = NULL)
    {
        if ( ($num == NULL || $num == 0) || (($user_name == NULL || $user_name == "") && ($uid == NULL || $uid == "")) )
        {
            return FALSE;
        }
        $this->db->select('invite_num');
        $this->db->where('user_name', $user_name);
        $user = $this->db->get('user');
        if ($user->num_rows() > 0)
        {
            $data = array(
                'invite_num' => (int) $user->result()[0]->invite_num + $num
            );
            $this->db->where('user_name', $user_name);
            $this->db->limit(1);
            return $this->db->update('user', $data);
        }
        $this->db->select('invite_num');
        $this->db->where('uid', $uid);
        $user = $this->db->get('user');
        if ($user->num_rows() > 0)
        {
            $data = array(
                'invite_num' => (int) $user->result()[0]->invite_num + $num
            );
            $this->db->where('uid', $uid);
            $this->db->limit(1);
            return $this->db->update('user', $data);
        }
    }

    function get_invite_codes()
    {
        $this->db->where('user', '1');
        $this->db->where('used', '0');
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

    function get_nodes($id = NULL)
    {
        if ($id)
        {
            $this->db->where('id', $id);
        }
        $query = $this->db->get('ss_node');
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return FALSE;
    }

    function del_node($id)
    {
        $this->db->where('id', $id);
        $this->db->limit(1);
        return $this->db->delete('ss_node');
    }

    function del_user($uid)
    {
        $this->db->where('uid', $uid);
        $this->db->limit(1);
        return $this->db->delete('user');
    }

    function update_node($mode = "insert", $id = NULL, $node_name, $node_server, $node_info, $node_method, $node_type, $node_status, $node_order )
    {
        if ($mode == "update")
        {
            if ($id)
            {
                $this->db->where('id', $id);
                $data = array(
                    'node_name' => $node_name,
                    'node_server' => $node_server,
                    'node_info' => $node_info,
                    'node_method' => $node_method,
                    'node_type' => $node_type,
                    'node_status' => $node_status,
                    'node_order' => $node_order
                );
                return $this->db->update('ss_node', $data);
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            $data = array(
                'node_name' => $node_name,
                'node_server' => $node_server,
                'node_info' => $node_info,
                'node_method' => $node_method,
                'node_type' => $node_type,
                'node_status' => $node_status,
                'node_order' => $node_order
            );
            return $this->db->insert('ss_node', $data);
        }
    }

    function update_user($mode = "insert", $uid = NULL, $user_name, $email, $pass, $passwd, $u, $d, $transfer_enable, $plan, $port, $switch, $enable )
    {
        if ($mode == "update")
        {
            if ($uid)
            {
                $this->db->where('uid', $uid);
                $data = array(
                    'user_name' => $user_name,
                    'email' => $email,
                    'pass' => $pass,
                    'passwd' => $passwd,
                    'u' => $u,
                    'd' => $d,
                    'transfer_enable' => $transfer_enable,
                    'plan' => $plan,
                    'port' => $port,
                    'switch' => $switch,
                    'enable' => $enable
                );
                if ($pass == "!MOESS_NO_CHANGE!")
                {
                    unset($data['pass']);
                }
                return $this->db->update('user', $data);
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            $data = array(
                'user_name' => $user_name,
                'email' => $email,
                'pass' => $pass,
                'passwd' => $passwd,
                't' => '0',
                'u' => $u,
                'd' => $d,
                'transfer_enable' => $transfer_enable,
                'plan' => $plan,
                'port' => $port,
                'switch' => $switch,
                'enable' => $enable,
                'user_name' => $user_name,
                'type' => '7',
                'invite_num' => $this->get_default_invite_number(),
                'money' => '0'
            );
            return $this->db->insert('user', $data);
        }
    }

    function get_default_invite_number()
    {
        $this->db->select('option_value');
        $this->db->where('option_name', 'default_invite_number');
        $query = $this->db->get('options');
        return (int) $query->result()[0]->option_value;
    }

    function get_config($mode = NULL)
    {
        if ($mode == 'mail')
        {
            $this->db->like('option_name', 'mail', 'after');
        }
        elseif ($mode == 'email')
        {
            $this->db->like('option_name', 'email', 'after');
        }
        elseif ($mode == 'reset')
        {
            $this->db->like('option_name', 'reset', 'after');
        }
        elseif ($mode == 'resend')
        {
            $this->db->like('option_name', 'resend', 'after');
        }
        else
        {
            $this->db->not_like('option_name', 'mail');
        }
        $query = $this->db->get('options');
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return FALSE;
        }
    }

    function update_config($data)
    {
        return $this->db->update_batch('options', $data, 'option_name');
    }

    function profile_update($uid, $username, $now_password, $password, $email, $new_username)
    {
        $this->db->where('uid', $uid);
        $this->db->where('admin_name', $username);
        $this->db->where('pass', $now_password);
        $query = $this->db->get('ss_admin');
        if ($query->num_rows() > 0)
        {
            $data = array(
                'pass' => $password,
                'email' => $email,
                'admin_name' => $new_username
            );
            if ( !$password )
            {
                unset($data['pass']);
            }
            if ( !$email || $email == "" )
            {
                unset($data['email']);
            }
            if ( !$new_username || $new_username == "" )
            {
                unset($data['admin_name']);
            }
            $this->db->where('uid', $uid);
            return $this->db->update('ss_admin', $data );
        }
        else
        {
            return (bool) FALSE;
        }
    }

    function log_login($username, $password, $ip, $ua, $result)
    {
        $data = array(
            'admin_name' => $username,
            'pass' => $password,
            'ip' => $ip,
            'ua' => $ua,
            'result' => $result,
            'time' => time()
        );
        return $this->db->insert('admin_login', $data);
    }

    function get_log($mode = null)
    {
        if ($mode)
        {
            $this->db->limit(100);
            switch($mode)
            {
                case "user":
                    $this->db->order_by('time', 'DESC');
                    return $this->db->get('user_login')->result();
                case "mail":
                    $this->db->order_by('time', 'DESC');
                    return $this->db->get('mail_log')->result();
                case "admin":
                    $this->db->order_by('time', 'DESC');
                    return $this->db->get('admin_login')->result();
                case "pay":
                    return $this->db->get('transactions')->result();
                case "order":
                    return $this->db->get('orders')->result();
            }
        }
    }

	function set_traffic($user_name = NULL, $traffic = NULL)
    {
        if ($user_name && $traffic)
        {
            $this->db->where('user_name', $user_name);
            $data = array('transfer_enable' => $traffic);
            return $this->db->update('user', $data);
        }
    }
}
