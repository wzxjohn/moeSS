<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/12/15
 * Time: 20:31
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
        <!-- START PROGRESS BARS -->
        <div class="row">
            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header">
                        <i class="fa fa-th-list"></i>
                        <h3 class="box-title">节点</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="callout callout-info">
                            <h4>加密方式</h4>
                            <p>无特殊说明加密方式均为<code><?php echo $default_method; ?></code></p>
                        </div><?php if ($nodes) { foreach ($nodes as $node): ?>
                            <p><?php echo $node->node_name; ?>:  <code><?php echo $node->node_server; ?></code> <?php echo $node->node_info; ?><?php if ($node->node_method != $default_method) {echo " <code>$node->node_method</code>";} ?> </p>
                            <button class="btn btn-info btn-sm" onclick="viewConfig(<?php echo $node->id; ?>)">查看配置</button>
                            <p></p>
                        <?php endforeach; } ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col (left) -->

            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header">
                        <i class="fa fa-code"></i>
                        <h3 class="box-title">测试节点</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="callout callout-warning">
                            <h4>注意!</h4>
                            <p>测试节点可能随时撤销，有问题请反馈.</p>
                        </div><?php if ($test_nodes) { foreach ($test_nodes as $node): ?>
                            <p><?php echo $node->node_name; ?>:  <code><?php echo $node->node_server; ?></code> <?php echo $node->node_info; ?><?php if ($node->node_method != $default_method) {echo " <code>$node->node_method</code>";} ?> </p>
                            <button class="btn btn-info btn-sm" onclick="viewConfig(<?php echo $node->id; ?>)">查看配置</button>
                            <p></p>
                        <?php endforeach; } ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col (right) -->
        </div><!-- /.row -->
        <!-- END PROGRESS BARS -->
    </section><!-- /.content -->
</aside><!-- /.right-side -->
<script>
function viewConfig($id) {
    var $url="<?php echo base_url('user/client_config'); ?>/".concat($id);
    $url=$url.concat(".html");
    BootstrapDialog.show({
        title: '查看配置',
        size: BootstrapDialog.SIZE_SMALL,
        type: BootstrapDialog.TYPE_INFO,
        message: $('<div></div>').load($url)
    });
    //window.open($url, "_blank", "location=no, menubar=no, status=no, toolbar=no, scrollbars=no, resizable=no, top=0, left=0, width=280, height=400");
}
</script>