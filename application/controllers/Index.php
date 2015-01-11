<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/11/15
 * Time: 17:36
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

    public function index()
    {
        $this->load->view('site_index');
    }
}
