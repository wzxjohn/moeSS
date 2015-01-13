<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/13/15
 * Time: 21:14
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?><!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            邀请管理
            <small>Invite Manage</small>
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
                        <h3 class="box-title">添加邀请码</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="addCodeForm" name="addCodeForm" role="form" method="post" action="<?php echo site_url('admin/add_invite') ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="cate_title">邀请码前缀</label>
                                <input  class="form-control" id="code_cub" name="code_sub" placeholder="小于8个字符"  >
                            </div>

                            <div class="form-group">
                                <label for="cate_title">邀请码类别</label>
                                <input  class="form-control" id="code_type" name="code_type"  placeholder="0为公开，1为管理员可见，2为已注册用户可见" >
                            </div>

                            <div class="form-group">
                                <label for="cate_title">邀请码数量</label>
                                <input  class="form-control" id="code_num" name="code_num" placeholder="要生成的邀请码数量"  >
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" name="action" value="add" class="btn btn-primary">添加</button>
                        </div>
                        <div class="box-footer">
                            <p>邀请码类别0的<a href="<?php echo site_url('siteIndex/view_code'); ?>">在这里查看</a> </p>
                            <p>邀请码类别1的<a href="<?php echo site_url('admin/invite_code'); ?>">在这里查看</a> </p>
                            <p>邀请码类别2的<a href="<?php echo site_url('user/invite_code'); ?>">在这里查看</a> </p>
                        </div>
                    </form>
                </div>
            </div><!-- /.box -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</aside><!-- /.right-side -->
<?php $this->load->view('ana') ;?>
</body>
</html>