<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/10/15
 * Time: 15:34
 */

defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('form');
?><!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="utf-8">
    <meta name="google" value="notranslate" />
    <title><?php echo SITE_NAME; ?> - 管理登陆</title>
    <link rel="icon" href="<?php echo site_url('favicon.ico'); ?>">
    <!-- bootstrap 3.0.2 -->
    <link href="<?php echo base_url("static/bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="<?php echo base_url("static/css/font-awesome.min.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url("static/css/AdminLTE.css"); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url("static/bootstrap-dialog/css/bootstrap-dialog.min.css"); ?>" rel="stylesheet" type="text/css" />

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
    <script src="<?php echo base_url("static/prettify/run_prettify.js"); ?>"></script>
    <script src="<?php echo base_url("static/bootstrap-dialog/js/bootstrap-dialog.min.js"); ?>"></script>
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
                    document.getElementById('pass').value = '';
                    $(this).ajaxSubmit(options);
                    var dialog = new BootstrapDialog({
                        size: BootstrapDialog.SIZE_LARGE,
                        title: 'Login',
                        message: 'Still login ... Please wait ...',
                        closable: false
                    });
                    dialog.realize();
                    dialog.getModalBody().css('color', '#000');
                    dialog.open();
                    return false;
                }
            });

            jQuery.validator.addMethod("onlyAlphaNumber", function(value, element) {
                return /^[a-zA-Z0-9]+$/.test(value);
            }, "Alpha and Number Only!");

            $('#loginForm').validate( {
                    rules:{
                        username: {
                            required: true,
                            onlyAlphaNumber: true
                        },
                        password: "required"
                    }
                }
            )
        });

        // post-submit callback
        function showResponse(data) {
            if (data.result == "success") {
                window.location.href = "<?php echo site_url('admin'); ?>";
            } else {
                var dialog = new BootstrapDialog({
                    size: BootstrapDialog.SIZE_LARGE,
                    type: BootstrapDialog.TYPE_WARNING,
                    title: '错误',
                    message: data.result,
                    closable: false,
                    buttons: [{
                        label: '关闭',
                        action: function(dialogRef){
                            dialogRef.close();
                            window.location.href = "<?php echo site_url('admin/login'); ?>";
                        }
                    ]
                });
                dialog.realize();
                dialog.getModalBody().css('color', '#000');
                dialog.open();
            }
        }
    </script>
</head>
<body class="bg-black">
<div class="form-box" id="login-box">
    <div class="header"><?php echo SITE_NAME; ?> - 管理登录</div>
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
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                    <input type="username"  id="username" name="username" class="form-control" placeholder="Username" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                    <input type="password"  id="pass" name="pass" class="form-control" placeholder="Password" required>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group" style="display: none">
                    <input type="hidden"  id="password" name="password" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="checkbox" name="remember_me" value="week"/> 保存Cookie7天
                </div>
            </div>
            <div class="input-group" id="loginResult"></div>
        </div>
        <div class="footer">
            <button type="submit" class="btn bg-olive btn-block"  name="login" >登录</button>
        </div>
    <?php echo form_close(); ?>
</div>
</body>
</html>
