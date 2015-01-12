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