<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/10/15
 * Time: 15:22
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
            return (bool) true;
        }
        else
        {
            return (bool) false;
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

    function get_users()
    {
        $this->db->select('uid, user_name, email, passwd, t, u, d, plan, transfer_enable, port, last_check_in_time, reg_date');
        return $this->db->get('users')->result();
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
}