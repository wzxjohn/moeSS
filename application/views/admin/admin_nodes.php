<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/10/15
 * Time: 15:27
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
            节点列表
            <small>Node List</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <p> <a class="btn btn-success btn-sm" href="<?php echo site_url( 'admin/node_add' ); ?>">添加</a> </p>
                    <div class="box">
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>ID</th>
                                    <th>节点</th>
                                    <th>描述</th>
                                    <th>排序</th>
                                    <th>操作</th>
                                </tr>
                                <?php if ($nodes) { foreach( $nodes as $node ) : ?>
                                    <tr>
                                        <td>#<?php echo $node->id; ?></td>
                                        <td><?php echo $node->node_name; ?></td>
                                        <td><?php echo $node->node_info; ?></td>
                                        <td><?php echo $node->node_order; ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?php echo site_url( "admin/node_edit/$node->id" ); ?>">编辑</a>
                                            <button class="btn btn-danger btn-sm" onclick="del_node(<?php echo $node->id; ?>)">删除</button>
                                        </td>
                                    </tr>
                                <?php endforeach; } ?>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
<script type="text/javascript">
    function del_node($id)
    {
        var dialog = new BootstrapDialog({
            size: BootstrapDialog.SIZE_LARGE,
            type: BootstrapDialog.TYPE_DANGER,
            title: '删除节点',
            message: '确认删除 ID 为：'.concat($id,' 的节点？该操作无法恢复！'),
            closable: false,
            buttons: [{
                label: '确认',
                cssClass: 'btn-danger',
                action: function (dialogRef) {
                    dialogRef.close();
                    do_del_node($id);
                }},
                {
                    label: '取消',
                    action: function (dialogRef) {
                        dialogRef.close();
                    }
                }
            ]
        });
        dialog.realize();
        dialog.getModalBody().css('color', '#000');
        dialog.open();
    }

    function do_del_node($id)
    {
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
                alert(xmlhttp.responseText);
                window.location.href = "<?php echo site_url('admin/nodes'); ?>";
            }
        }
        xmlhttp.open("GET","<?php echo base_url( "admin/node_del"); ?>".concat("/",$id),true);
        xmlhttp.send();
    }
</script>
