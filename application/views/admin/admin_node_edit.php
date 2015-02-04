<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/15/15
 * Time: 16:26
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
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php if ($node) { echo "编辑"; } else { echo "添加"; } ?>节点</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="<?php if ($node) { echo site_url( "admin/node_update/$node->id"); } else { echo site_url( 'admin/node_update'); } ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="cate_title">节点名字</label>
                                <input type="text" class="form-control" name="node_name" <?php if ($node) {echo "value=\"$node->node_name\""; } ?> >
                            </div>

                            <div class="form-group">
                                <label for="cate_title">节点地址</label>
                                <input type="text" class="form-control" name="node_server" <?php if ($node) {echo "value=\"$node->node_server\""; } ?> >
                            </div>

                            <div class="form-group">
                                <label for="cate_title">节点描述</label>
                                <input type="text" class="form-control" name="node_info" <?php if ($node) {echo "value=\"$node->node_info\""; } ?> >
                            </div>

                            <div class="form-group">
                                <label for="cate_title">加密类型</label>
                                <input type="text" class="form-control" name="node_method" <?php if ($node) {echo "value=\"$node->node_method\""; } ?> >
                            </div>

                            <div class="form-group">
                                <label for="cate_order">分类(0或者1)</label>
                                <input type="text" class="form-control" name="node_type" <?php if ($node) {echo "value=\"$node->node_type\""; } ?> >
                            </div>

                            <div class="form-group">
                                <label for="cate_order">状态</label>
                                <input type="text" class="form-control" name="node_status" <?php if ($node) {echo "value=\"$node->node_status\""; } else {echo 'value="可用"';} ?> >
                            </div>

                            <div class="form-group">
                                <label for="cate_order">排序</label>
                                <input type="text" class="form-control" name="node_order" <?php if ($node) {echo "value=\"$node->node_order\""; } else {echo 'value="0"';} ?> >
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" name="action" value="add" class="btn btn-primary">提交</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.box -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</aside><!-- /.right-side -->
