<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/12/15
 * Time: 18:54
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
?><!DOCTYPE html>
<html>
<head>
    <title><?php echo SITE_NAME;?> - 管理中心</title>
    <meta charset="utf-8">
    <meta name="google" value="notranslate" />
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" type="image/ico" href="<?php echo base_url('favicon.ico'); ?>" />
    <link href="<?php echo base_url('static/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('static/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="<?php echo base_url('static/css/ionicons.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('static/css/AdminLTE.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo base_url('static/js/jquery-2.1.1.js'); ?>"></script>
    <script src="<?php echo base_url('static/js/jquery.validate.min.js'); ?>"></script>
    <script src="<?php echo base_url('static/js/jquery.form.min.js'); ?>"></script>
    <script src="<?php echo base_url('static/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('static/js/jquery-ui.min.js'); ?>" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url('static/js/AdminLTE/app.js'); ?>" type="text/javascript"></script>

    <script language="javascript">
    $(document).ready(function() {
        var options = {
            target:        '#addResult',   // target element(s) to be updated with server response
            success:       showResponse,  // post-submit callback
            dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type)
        };

        $('#addCodeForm').submit(function() {
            if ($(this).valid()) {
                $(this).ajaxSubmit(options);
                return false;
            }
        });

        $('#addCodeNumForm').submit(function() {
            if ($(this).valid()) {
                $(this).ajaxSubmit(options);
                return false;
            }
        });

        $('#addCodeForm').validate( {
            rules:{
                code_cub: {
                    required: false
                },
                code_type: {
                    required: true,
                    maxlength: 1
                },
                code_num: {
                    required: true
                }
            }
        });

        $('#addCodeNumForm').validate( {
            rules:{
                user_name: {
                    required: false
                },
                uid: {
                    required: false
                },
                code_num: {
                    required: true
                }
            }
        })
    });

    // post-submit callback
    function showResponse(data) {
        if (data.result == "success")
        {
            alert('添加成功!');
            window.location.href = "<?php echo site_url('admin/codes'); ?>";
        } else {
            alert(data.result);
        }
    }
</script>
</head>
<body class="skin-blue">