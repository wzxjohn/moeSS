<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/12/15
 * Time: 21:41
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
?><!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            邀请
            <small>Invite</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">邀请码</h3>
                    </div><!-- /.box-header -->

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>###</th>
                                <th>邀请码</th>
                                <th>状态</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php if ($codes) { $a=1; foreach ($codes as $code): ?>
                                <tr>
                                    <td><?php echo $a;$a++; ?></td>
                                    <td><?php echo $code->code;?></td>
                                    <td>可用</td>
                                </tr>
                            <?php endforeach; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <?php if ($code_num > 0) { echo '<button class="btn btn-info" onclick="get_code()">获取邀请码</button>'; }?>
                </div>
            </div><!-- /.box -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</aside><!-- /.right-side -->
<script>
    function get_code()
    {
        var dialog = new BootstrapDialog({
            size: BootstrapDialog.SIZE_LARGE,
            title: '获取邀请码',
            message: '正在获取，请稍候。。。',
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
                    type: BootstrapDialog.TYPE_SUCCESS,
                    title: '获取邀请码',
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
        xmlhttp.open("GET","<?php echo site_url('user/get_invite_code'); ?>",true);
        xmlhttp.send();
    }
</script>
