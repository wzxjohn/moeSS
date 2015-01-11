<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/11/15
 * Time: 16:48
 */

defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('form');
?><!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="UTF-8">
    <title><?php echo SITE_NAME; ?> - 注册</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="<?php echo base_url("static/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="<?php echo base_url("static/css/font-awesome.min.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url("static/css/AdminLTE.css"); ?>" rel="stylesheet" type="text/css" />

	<!-- jQuery 2.0.2 -->
    <script src="<?php echo base_url("static/js/jquery-2.0.3.min.js"); ?>"></script>
    <script src="<?php echo base_url("static/js/jquery.validate.min.js"); ?>"></script>
    <script src="<?php echo base_url("static/js/jquery.form.min.js"); ?>"></script>
	<!-- Bootstrap -->
	<script src="<?php echo base_url("static/js/bootstrap.min.js"); ?>" type="text/javascript"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script language="javascript">
        $(document).ready(function() {
            var options = {
                target:        '#registerResult',   // target element(s) to be updated with server response
                success:       showResponse,  // post-submit callback
                dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type)
            };

            $('#registerForm').submit(function() {
                if ($(this).valid()) {
                    $(this).ajaxSubmit(options);
                    return false;
                }
            });

            $('#registerForm').validate( {
                    rules:{
                        username: {
                        	required: true,
                        	minlength: 8
                        },
                        password: {
                        	required: true,
                        	minlength: 8
                        },
                        repassword: {
                        	required: true,
                        	minlength: 8,
                        	equalTo: '#password'
                        },
                        email: {
                        	required: true,
                        	email: true
                        }<?php if( $invite_only ) { ?>,
                        code: {
                        	required: true
                        }
                        <?php } ?>
                    }
                }
            )
        });

        // post-submit callback
        function showResponse(data) {
            if (data.result == "success") {
                window.location.href = "<?php echo site_url('user/login'); ?>";
            } else {
                alert(data.result);
            }
        }
    </script>
</head>
<body class="bg-black">

<div class="form-box" id="login-box">
    <div class="header"><?php echo SITE_NAME;?> - 注册</div>
    <?php
    $attributes = array(
        'role' => 'form',
        'name' => 'reg',
        'id' => 'registerForm'//,
        //'onsubmit' => 'return logincheck()'
    );
    echo form_open('user/do_register', $attributes);
    ?>
        <div class="body bg-gray">
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="用户名" >
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="密码" >
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="repassword" placeholder="重复密码" >
            </div>

            <div class="form-group">
                <input type="text" name="email" class="form-control" id="inputUsernameEmail" placeholder="邮箱" >
            </div>

            <?php if( $invite_only ) { ?>
                <div class="form-group">
                    <input type="text" class="form-control" name="code" placeholder="邀请码" >
                </div>
            <?php } ?>
        </div>
        <div class="footer">

            <button type="submit" class="btn bg-olive btn-block">注册</button>

            <a href="<?php echo site_url('user/login')?>" class="text-center">已经注册？请登录</a>
        </div>
    <?php echo form_close(); ?>

    <div class="margin text-center">
        <span>下面的按钮暂时是不可用的</span>
        <br/>
        <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
        <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
        <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>

    </div>
</div>
</body>
</html>