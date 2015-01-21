<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/15/15
 * Time: 16:26
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
                                <input type="text" class="form-control" name="node_status"  value="可用" <?php if ($node) {echo "value=\"$node->node_status\""; } ?> >
                            </div>

                            <div class="form-group">
                                <label for="cate_order">排序</label>
                                <input type="text" class="form-control" name="node_order"  value="0" <?php if ($node) {echo "value=\"$node->node_order\""; } ?> >
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
