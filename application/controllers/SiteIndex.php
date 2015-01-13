<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/11/15
 * Time: 17:36
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class SiteIndex extends CI_Controller {

    public function index()
    {
        $this->load->view('site_index');
    }

    function view_code()
    {
        $this->load->model('index_model');
        $data['codes'] = $this->index_model->get_codes();
        $this->load->view('site_code', $data);
    }
}
