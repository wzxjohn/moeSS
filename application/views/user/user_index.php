<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/12/15
 * Time: 14:51
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
?>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            用户中心
            <small>User Panel</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- START PROGRESS BARS -->
        <div class="row">
            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header">
                        <i class="fa fa-bullhorn"></i>
                        <h3 class="box-title">公告&FAQ</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="callout callout-warning">
                            <h4>注意!</h4>
                            <p>测试中，测试期间随时删号，不保证可用。<br>所有节点均不支持外发邮件。</p>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <div class="box box-solid">
                    <div class="box-header">
                        <i class="fa fa-info-circle"></i>
                        <h3 class="box-title">连接信息</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p> 端口: <code><?php echo $port; ?></code> </p>
                        <p> 密码: <?php echo $passwd; ?> </p>
                        <p> 套餐: <span class="label label-info"> <?php echo $plan; ?> </span> </p>
                        <p> 最后使用时间: <code><?php echo date('Y-m-d H:i:s',$unix_time); ?></code> </p>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col (right) -->
            <?php if (!$enable)
            {
                echo <<< EOD
            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header">
                        <i class="fa fa-exclamation-triangle"></i>
                        <h3 class="box-title">注意</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="callout callout-danger">
                            <h4>未激活</h4>
                            <p>您的账号还没有激活，暂时不能使用！请查收邮件。</p>
                            <p><a class="btn btn-success" id="check_in_button" onclick="do_resend_mail()">重发激活邮件</a> </p>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
EOD;
            }?>

            <?php if ($enable) echo '<div class="col-md-6">'."\n"; ?>
                <div class="box box-solid">
                    <div class="box-header">
                        <i class="fa fa-bar-chart"></i>
                        <h3 class="box-title">流量使用情况</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p> 已用流量: <?php echo $transfers; ?> </p>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $used_100; ?>%">
                                <span class="sr-only">Transfer</span>
                            </div>
                        </div>
                        <p> 可用流量: <?php echo $all_transfer; ?> </p>
                        <p> 剩余流量: <?php echo  $unused_transfer; ?> </p>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <div class="box box-solid">
                    <div class="box-header">
                        <i class="fa fa-check-square-o"></i>
                        <h3 class="box-title">签到获取流量</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p> 24小时内可以签到一次。</p>
                        <?php  if( $is_able_to_check_in ) { ?>
                            <p><a class="btn btn-success" id="check_in_button" href="#" onclick="do_check_in()">签到</a> </p>
                        <?php  }else{ ?>
                            <p><a class="btn btn-success disabled" id="check_in_button" href="#">不能签到</a> </p>
                        <?php  } ?>
                        <p>上次签到时间<code><?php echo date('Y-m-d H:i:s', $last_check_in_time );?></code></p>
                        <p id="check_in_result"></p>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col (right) -->
        </div><!-- /.row -->
        <!-- END PROGRESS BARS -->
    </section><!-- /.content -->
</aside><!-- /.right-side -->
<script type="text/javascript">
    function do_check_in()
    {
        var dialog = new BootstrapDialog({
            size: BootstrapDialog.SIZE_LARGE,
            title: '每日签到',
            message: '正在签到，请稍候。。。',
            closable: false
        });
        dialog.realize();
        dialog.getModalBody().css('color', '#000');
        dialog.open();
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                var str1 = "<code>";
                var str2 = "</code>";
                document.getElementById("check_in_result").innerHTML = str1.concat( xmlhttp.responseText, str2 );
                var dialog = new BootstrapDialog({
                    size: BootstrapDialog.SIZE_LARGE,
                    type: BootstrapDialog.TYPE_SUCCESS,
                    title: '每日签到',
                    message: xmlhttp.responseText,
                    closable: false,
                    buttons: [{
                        label: '关闭',
                        action: function (dialogRef) {
                            dialogRef.close();
                            window.location.reload();
                        }
                    }]
                });
                dialog.realize();
                dialog.getModalBody().css('color', '#000');
                dialog.open();
                document.getElementById("check_in_button").href = "";
                document.getElementById("check_in_button").innerHTML = "不能签到";
            }
        }
        xmlhttp.open("GET","<?php echo site_url('user/check_in'); ?>",true);
        xmlhttp.send();
    }
    function do_resend_mail()
    {
        var dialog = new BootstrapDialog({
            size: BootstrapDialog.SIZE_LARGE,
            title: '重发邮件',
            message: '正在重发激活邮件，请稍候。。。',
            closable: false
        });
        dialog.realize();
        dialog.getModalBody().css('color', '#000');
        dialog.open();
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                var dialog = new BootstrapDialog({
                    size: BootstrapDialog.SIZE_LARGE,
                    title: '重发邮件',
                    message: xmlhttp.responseText,
                    closable: false,
                    buttons: [{
                        label: '关闭',
                        action: function (dialogRef) {
                            dialogRef.close();
                            window.location.reload();
                        }
                    }]
                });
                dialog.realize();
                dialog.getModalBody().css('color', '#000');
                dialog.open();
            }
        }
        xmlhttp.open("GET","<?php echo site_url('user/resend_mail'); ?>",true);
        xmlhttp.send();
    }
</script>