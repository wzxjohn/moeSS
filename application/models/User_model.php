<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/11/15
 * Time: 16:46
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
        return $query->result();
    }

    function need_invite()
    {
        $this->db->where('option_name', 'invite_only');
        $query = $this->db->get('options');
        if ( $query->result()[0]->option_value == 'true' )
        {
            return (bool) true;
        }
        else
        {
            return (bool) false;
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
        $this->db->where('code', $invitecode);
        $data = array(
            'used' => (bool) true,
            'user_name' => $username
            );
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
            'switch' => '1',
            'enable' => '1',
            'type' => '7',
            'invite_num' => $this->get_default_invite_number(),
            'money' => '0'
        );
        $this->db->set('reg_date', 'NOW()', FALSE);
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
            return (bool) false;
        }
    }

    function u_info( $username )
    {
        $this->db->where('user_name', $username);
        $this->db->select('t, u, d, plan, transfer_enable, passwd, port, last_check_in_time');
        $query = $this->db->get('user');
        if ($query->num_rows() > 0)
        {
            return $query->result()[0];
        }
        else
        {
            return (bool) false;
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
            return (bool) false;
        }
    }

    function get_nodes( $test = false )
    {
        if ($test)
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
            return (bool) false;
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
            return (bool) false;
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
            $this->db->where('uid', $uid);
            $data = array(
                'pass' => $password,
                'email' => $email
            );
            if ( !$password )
            {
                unset($data['pass']);
            }
            if ( !$email || $email == "" )
            {
                unset($data['email']);
            }
            return $this->db->update('user', $data );
        }
        else
        {
            return (bool) false;
        }
    }

    function change_ss_pass($uid, $username, $pass)
    {
        $this->db->where('uid', $uid);
        $this->db->where('user_name', $username);
        $data = array( 'passwd' => $pass );
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
        $this->db->where('user_name', $username);
        $data = array( 'last_check_in_time' => time() );
        $this->db->update('user', $data);
        return $transfer_to_add;
    }

    function get_transfer_enable($username)
    {
        $this->db->where('user_name', $username);
        $this->db->select('transfer_enable');
        return $this->db->get('user')->result()[0]->transfer_enable;
    }

    function add_transfer($username = null, $amount)
    {
        if ( $username )
        {
            $this->db->where('user_name', $username);
        }
        $data = array( 'transfer_enable', $this->get_transfer_enable + $amount );
        return $this->db->update( 'user', $date );
    }
}
