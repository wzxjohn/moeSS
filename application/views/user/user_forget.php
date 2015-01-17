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
    <meta charset="utf-8">
    <title><?php echo SITE_NAME; ?> - 忘记密码</title>
    <link rel="icon" href="<?php echo base_url('favicon.ico'); ?>">
    <!-- bootstrap 3.0.2 -->
    <link href="<?php echo base_url("static/bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="<?php echo base_url("static/css/font-awesome.min.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url("static/css/AdminLTE.css"); ?>" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 2.0.2 -->
    <script src="<?php echo base_url("static/js/jquery-2.0.3.min.js"); ?>"></script>
    <script src="<?php echo base_url("static/js/jquery.validate.min.js"); ?>"></script>
    <script src="<?php echo base_url("static/js/jquery.form.min.js"); ?>"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url("static/js/bootstrap.min.js"); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url("static/js/md5.js"); ?>" type="text/javascript"></script>
    <script language="javascript">
        $(document).ready(function() {
            var options = {
                target:        '#resultResult',   // target element(s) to be updated with server response
                success:       showResponse,  // post-submit callback
                dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type)
            };

            $('#forgetForm').submit(function() {
                if ($(this).valid()) {
                    $(this).ajaxSubmit(options);
                    return false;
                }
            });

            jQuery.validator.addMethod("onlyAlphaNumber", function(value, element) {
                return /^[a-zA-Z0-9]+$/.test(value);
            }, "Alpha and Number Only!");

            $('#forgetForm').validate( {
                    rules:{
                        username: {
                            required: true,
                            onlyAlphaNumber: true
                        },
                        email: {
                            required: true,
                            email: true
                        }
                    }
                }
            )
        });

        // post-submit callback
        function showResponse(data) {
            if (data.result == "success") {
                alert('Success!');
                window.location.href = "<?php echo site_url('user'); ?>";
            } else {
                alert(data.result);
            }
        }
    </script>
</head>
<body class="bg-black">
<div class="form-box" id="login-box">
    <div class="header"><?php echo SITE_NAME; ?> - 忘记密码</div>
    <?php
    $attributes = array(
        'role' => 'form',
        'id' => 'forgetForm'//,
        //'onsubmit' => 'return logincheck()'
    );
    echo form_open('user/resend_passwd', $attributes);
    ?>
    <div class="body bg-gray">
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                <input type="username"  id="username" name="username" class="form-control" placeholder="Username" required autofocus>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                <input type="email"  id="email" name="email" class="form-control" placeholder="E-mail" required>
            </div>
        </div>
        <div class="input-group" id="forgetResult"></div>
    </div>
    <div class="footer">
        <button type="submit" class="btn bg-olive btn-block"  name="login" >重置</button>
        <a href="<?php echo site_url('user/register')?>" class="text-center">没有注册？</a>
    </div>
    <?php echo form_close(); ?>
</div>
</body>
</html>
