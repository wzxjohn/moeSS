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
    }

    function u_select($username)
    {
        $this->db->where('user_name', $username);
        $this->db->select('uid', 'user_name', 'pass');
        $query = $this->db->get('user');
        return $query->result();
    }
}
