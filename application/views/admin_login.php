<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/10/15
 * Time: 15:34
 */

defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('form');
?>
<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="utf-8">
    <title><?php echo SITE_NAME; ?> - 管理登陆</title>
    <!-- bootstrap 3.0.2 -->
    <link href=<?php echo base_url("static/bootstrap/css/bootstrap.min.css"); ?> rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href=<?php echo base_url("static/css/font-awesome.min.css"); ?> rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href=<?php echo base_url("static/css/AdminLTE.css"); ?> rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 2.0.2 -->
    <script src=<?php echo base_url("static/js/jquery-2.0.3.min.js"); ?>></script>
    <script src=<?php echo base_url("static/js/jquery.validate.min.js"); ?>></script>
    <script src=<?php echo base_url("static/js/jquery.form.min.js"); ?>></script>
    <!-- Bootstrap -->
    <script src=<?php echo base_url("static/js/bootstrap.min.js"); ?> type="text/javascript"></script>
    <script src=<?php echo base_url("static/js/md5.js"); ?> type="text/javascript"></script>
    <script language="javascript">
        $(document).ready(function() {
            var options = {
                target:        '#loginResult',   // target element(s) to be updated with server response
                success:       showResponse,  // post-submit callback
                dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type)
            };

            $('#loginForm').submit(function() {
                if ($(this).valid()) {
                    document.getElementById('password').value = md5(document.getElementById('pass').value);
                    $(this).ajaxSubmit(options);
                    return false;
                }
            });

            $('#loginForm').validate( {
                    rules:{
                        username: "required",
                        password: "required"
                    }
                }
            )
        });

        // post-submit callback
        function showResponse(data, statusText, xhr, $form) {
            if (data.result == "success") {
                location.reload();
            } else {
                alert(data.result);
            }
        }
    </script>
</head>
<body class="bg-black">

<?php echo validation_errors(); ?>

<div class="form-box" id="login-box">
    <div class="header">登录</div>
    <?php
        $attributes = array(
            'role' => 'form',
            'id' => 'loginForm'//,
            //'onsubmit' => 'return logincheck()'
        );
        echo form_open('admin/login_check', $attributes);
    ?>
        <div class="body bg-gray">
            <div class="form-group">
                <input type="username"  id="username" name="username" class="form-control" placeholder="Username" required autofocus>
            </div>
            <div class="form-group">
                <input type="password"  id="pass" name="pass" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group" style="display: none">
                <input type="hidden"  id="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <input type="checkbox" name="remember_me" value="week"/> 保存Cookie7天
            </div>
            <div class="form-group" id="loginResult"></div>
        </div>
        <div class="footer">
            <button type="submit" class="btn bg-olive btn-block"  name="login" >登录</button>
        </div>
    <?php echo form_close(); ?>
</div>
</body>
</html>
