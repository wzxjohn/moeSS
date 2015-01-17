<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('get_temp_pass'))
{
    function get_temp_pass()
    {
        $a = rand(100000,999999);
        return $a;
    }
}

if ( ! function_exists('get_gravatar'))
{
    //Gravatar
    function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() )
    {
        $url = 'https://secure.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img )
        {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }
}

if ( ! function_exists('human_file_size'))
{
    function human_file_size( $size, $unit="" )
    {
        if( (!$unit && $size >= 1<<30) || $unit == "GB")
            return number_format($size/(1<<30),2)." GB";
        if( (!$unit && $size >= 1<<20) || $unit == "MB")
            return number_format($size/(1<<20),2)." MB";
        if( (!$unit && $size >= 1<<10) || $unit == "KB")
            return number_format($size/(1<<10),2)." KB";
        return number_format($size)." bytes";
    }
}

if (! function_exists('is_able_to_check_in'))
{
    function is_able_to_check_in( $last_check_in_time )
    {
        $now = time();
        if( $now - $last_check_in_time > 3600*24 )
        {
            return (bool) true;
        }
        else
        {
            return (bool) false;
        }
    }
}

if (! function_exists('send_mail'))
{
    function send_mail($from = null, $from_name = null, $to, $subject, $html)
    {
        $this->load->database();
        $this->db->where('option_name', 'mail_protocol');
        $query = $this->db->get('options');
        if ($query->num_rows() > 0)
        {
            if ($from)
            {
                $sender_address = $from;
            }
            else
            {
                $this->db->where('option_name', 'mail_sender_address');
                $query = $this->db->get('options');
                $sender_address = $query->result()[0]->option_value;
            }
            if ($from_name)
            {
               $sender_name = $from_name;
            }
            else
            {
                $this->db->where('option_name', 'mail_sender_name');
                $query = $this->db->get('options');
                $sender_name = $query->result()[0]->option_value;
            }
            $config['protocol'] = $query->result()[0]->option_value;
            if ($config['protocol'] == 'sendmail')
            {
                $this->db->where('option_name', 'mail_mailpath');
                $query = $this->db->get('options');
                $config['mailpath'] = $query->result()[0]->option_value;
            }
            elseif ($config['protocol'] == 'smtp')
            {
                $this->db->where('option_name', 'mail_smtp_host');
                $query = $this->db->get('options');
                $config['smtp_host'] = $query->result()[0]->option_value;
                $this->db->where('option_name', 'mail_smtp_user');
                $query = $this->db->get('options');
                $config['smtp_user'] = $query->result()[0]->option_value;
                $this->db->where('option_name', 'mail_smtp_pass');
                $query = $this->db->get('options');
                $config['smtp_pass'] = $query->result()[0]->option_value;
                $this->db->where('option_name', 'mail_smtp_port');
                $query = $this->db->get('options');
                $config['smtp_port'] = $query->result()[0]->option_value;
                $this->db->where('option_name', 'mail_smtp_crypto');
                $query = $this->db->get('options');
                $config['smtp_crypto'] = $query->result()[0]->option_value;
            }
            elseif ($config['protocol'] == 'sendgrid')
            {
                $url = 'https://api.sendgrid.com/';
                $this->db->where('option_name', 'mail_sg_user');
                $query = $this->db->get('options');
                $api_user = $query->result()[0]->option_value;
                $this->db->where('option_name', 'mail_sg_pass');
                $query = $this->db->get('options');
                $api_pass = $query->result()[0]->option_value;
                $params = array(
                    'api_user' => $api_user,
                    'api_key' => $api_pass,
                    'to' => $to,
                    'subject' => $subject,
                    'html' => $html,
                    'from' => $sender_address,
                );

                $request = $url . 'api/mail.send.json';
                $session = curl_init($request);
                curl_setopt($session, CURLOPT_POST, true);
                curl_setopt($session, CURLOPT_POSTFIELDS, $params);
                curl_setopt($session, CURLOPT_HEADER, false);
                curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($session);
                curl_close($session);
                $response = json_decode($response);
                if ($response->message == "success") {
                    return true;
                } else {
                    return false;
                }
            }

            $config['mailtype'] = 'html';
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = TRUE;
            $config['crlf'] = '\r\n';
            $config['newline'] = '\r\n';
            $this->load->library('email');
            $this->email->initialize($config);

            $this->email->from($sender_address, $sender_name);
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($html);
            return $this->email->send();
        }
    }
}