<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/10/15
 * Time: 15:34
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="utf-8">
    <title><?php echo $SITE_NAME; ?> - 管理登陆</title>
    <!-- bootstrap 3.0.2 -->
    <link href=<?php echo site_url("static/bootstrap/css/bootstrap.min.css"); ?> rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href=<?php echo site_url("static/css/font-awesome.min.css"); ?> rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href=<?php echo site_url("static/css/AdminLTE.css"); ?> rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="bg-black">
<div class="form-box" id="login-box">
    <div class="header">登录</div>
    <form role="form" id="loginForm" action="login_check" method="post" onsubmit="return logincheck()">
        <div class="body bg-gray">
            <div class="form-group">
                <input type="username"  id="username" name="username" class="form-control" placeholder="Username" required autofocus>
            </div>
            <div class="form-group">
                <input type="password"  id="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="checkbox" name="remember_me" value="week"/> 保存Cookie7天
            </div>
        </div>
        <div class="footer">
            <button type="submit" class="btn bg-olive btn-block"  name="login" >登录</button>
        </div>
    </form>
</div>
<script LANGUAGE="javascript">
    function logincheck()
    {
        if(document.getElementById('username').value.length==0){
            alert("请输入用户名");
            document.getElementById('username').focus();
            return false;
        }

        if(document.getElementById('password').value.length==0){
            alert("请输入密码!");
            document.getElementById('password').focus();
            return false;
        }

        document.getElementById('password').value = md5(document.getElementById('password').value);
        document.getElementById('loginForm').submit();
    }
</script>
<!-- jQuery 2.0.2 -->
<script src=<?php echo site_url("static/js/jquery-2.0.3.min.js"); ?>></script>
<!-- Bootstrap -->
<script src=<?php echo site_url("static/js/bootstrap.min.js"); ?> type="text/javascript"></script>
<script src=<?php echo site_url("static/js/md5.js"); ?> type="text/javascript"></script>
</body>
</html>
