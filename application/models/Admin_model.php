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

    function c_user_time()
    {

    }
}