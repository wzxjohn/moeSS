<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/13/15
 * Time: 15:02
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Index_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        return;
    }

    function get_codes()
    {
        $this->db->where('user', '0');
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
}