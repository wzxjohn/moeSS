<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/12/15
 * Time: 23:06
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
    <title><?php echo SITE_NAME;?></title>
    <meta charset="utf-8">
    <meta name="google" value="notranslate" />
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url('static/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('static/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="<?php echo base_url('static/css/ionicons.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="<?php echo base_url('static/css/morris/morris.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- Theme style -->
    <link href="<?php echo base_url('static/css/AdminLTE.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url("static/bootstrap-dialog/css/bootstrap-dialog.min.css"); ?>" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo base_url('static/js/jquery-2.1.1.js'); ?>"></script>
    <script src="<?php echo base_url("static/js/jquery.validate.min.js"); ?>"></script>
    <script src="<?php echo base_url("static/js/jquery.form.min.js"); ?>"></script>
    <script src="<?php echo base_url('static/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('static/js/jquery-ui.min.js'); ?>" type="text/javascript"></script>
    <!-- Morris.js charts -->
    <script src="<?php echo base_url('static/js/raphael-min.js'); ?>"></script>
    <script src="<?php echo base_url('static/js/plugins/morris/morris.min.js'); ?>" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="<?php echo base_url('static/js/plugins/sparkline/jquery.sparkline.min.js'); ?>" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="<?php echo base_url('static/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('static/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo base_url('static/js/plugins/jqueryKnob/jquery.knob.js'); ?>" type="text/javascript"></script>
    <!-- Moment JS -->
    <script src="<?php echo base_url('static/js/plugins/moment/moment.min.js'); ?>"></script>
    <!-- daterangepicker -->
    <script src="<?php echo base_url('static/js/plugins/daterangepicker/daterangepicker.js'); ?>" type="text/javascript"></script>
    <!-- datepicker -->
    <script src="<?php echo base_url('static/js/plugins/datepicker/bootstrap-datepicker.js'); ?>" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo base_url('static/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url('static/js/plugins/iCheck/icheck.min.js'); ?>" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url('static/js/AdminLTE/app.js'); ?>" type="text/javascript"></script>

    <!-- Select js -->
    <script src="<?php echo base_url('static/js/bootstrap-select.js'); ?>"></script>
    <script src="<?php echo base_url('static/js/bootstrap-switch.js'); ?>"></script>
    <script src="<?php echo base_url("static/prettify/run_prettify.js"); ?>"></script>
    <script src="<?php echo base_url("static/bootstrap-dialog/js/bootstrap-dialog.min.js"); ?>"></script>

    <script type="text/javascript">
        $(window).on('load', function () {

            $('.selectpicker').selectpicker({
                'selectedText': 'cat'
            });

            // $('.selectpicker').selectpicker('hide');
        });
    </script>
    <script language="javascript">
        $(document).ready(function() {
            var options = {
                target:        '#updateResult',   // target element(s) to be updated with server response
                success:       showResponse,  // post-submit callback
                dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type)
            };

            $('#editForm').submit(function() {
                if ($(this).valid()) {
                    $(this).ajaxSubmit(options);
                    var dialog = new BootstrapDialog({
                        size: BootstrapDialog.SIZE_LARGE,
                        title: '资料修改',
                        message: '正在提交，请稍候。。。',
                        closable: false,
                        buttons: [{
                            label: '关闭',
                            action: function (dialogRef) {
                                dialogRef.close();
                            }
                        }]
                    });
                    dialog.realize();
                    dialog.getModalBody().css('color', '#000');
                    dialog.open();
                    return false;
                }
            });

            $('#editForm').validate( {
                    rules:{
                        nowpassword: {
                            required: true,
                            minlength: 6
                        },
                        password: {
                            required: false,
                            minlength: 8
                        },
                        repassword: {
                            required: false,
                            minlength: 8,
                            equalTo: '#password'
                        },
                        email: {
                            required: false,
                            email: true
                        }
                    }
                }
            );

            $('#ssPass').submit(function() {
                $(this).ajaxSubmit(options);
                var dialog = new BootstrapDialog({
                    size: BootstrapDialog.SIZE_LARGE,
                    title: '密码修改',
                    message: '正在提交，请稍候。。。',
                    closable: false
                });
                dialog.realize();
                dialog.getModalBody().css('color', '#000');
                dialog.open();
                return false;
            });
        });

        // post-submit callback
        function showResponse(data) {
            if (data.result == "success")
            {
                var dialog = new BootstrapDialog({
                    size: BootstrapDialog.SIZE_LARGE,
                    type: BootstrapDialog.TYPE_SUCCESS,
                    title: '成功',
                    message: '修改成功！',
                    closable: false,
                    buttons: [{
                        label: '关闭',
                        action: function (dialogRef) {
                            dialogRef.close();
                            window.location.href = "<?php echo site_url('user/profile_update'); ?>";
                        }
                    }]
                });
                dialog.realize();
                dialog.getModalBody().css('color', '#000');
                dialog.open();
            } else {
                var dialog = new BootstrapDialog({
                    size: BootstrapDialog.SIZE_LARGE,
                    type: BootstrapDialog.TYPE_WARNING,
                    title: '失败',
                    message: data.result,
                    closable: false,
                    buttons: [{
                        label: '关闭',
                        action: function (dialogRef) {
                            dialogRef.close();
                        }
                    }]
                });
                dialog.realize();
                dialog.getModalBody().css('color', '#000');
                dialog.open();
            }
        }
    </script>
</head>
<body class="skin-blue">