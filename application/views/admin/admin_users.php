<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/13/15
 * Time: 22:38
 */
$this->load->helper('comm');
defined('BASEPATH') OR exit('No direct script access allowed');
?><!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            用户列表
            <small>User List</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <p> <a class="btn btn-success btn-sm" href="<?php echo site_url('admin/user_add'); ?>">添加</a> </p>
                    <div class="box">
                        <div class="box-body table-responsive no-padding">
                            <table id="userTable" class="table table-bordered table-hover">
                                <tr role="row">
                                    <th role="columnheader">UID</th>
                                    <th role="columnheader">用户名</th>
                                    <th role="columnheader">电子邮件</th>
                                    <th role="columnheader">SS 密码</th>
                                    <th role="columnheader">上次连接时间</th>
                                    <th role="columnheader">上传量</th>
                                    <th role="columnheader">下载量</th>
                                    <th role="columnheader">套餐</th>
                                    <th role="columnheader">总量</th>
                                    <th role="columnheader">端口</th>
                                    <th role="columnheader">上次签到</th>
                                    <th role="columnheader">注册时间</th>
                                    <th role="columnheader">操作</th>
                                </tr>
                                <?php if ($users) { foreach ($users as $user) : ?>
                                    <tr>
                                        <td>#<?php echo $user->uid; ?></td>
                                        <td> <?php echo $user->user_name; ?></td>
                                        <td><?php echo $user->email; ?></td>
                                        <td><?php echo $user->passwd; ?></td>
                                        <td><?php echo date("m-j G:i", $user->t); ?></td>
                                        <td><?php echo human_file_size($user->u); ?></td>
                                        <td><?php echo human_file_size($user->d); ?></td>
                                        <td><?php echo $user->plan; ?></td>
                                        <td><?php echo human_file_size($user->transfer_enable); ?></td>
                                        <td><?php echo $user->port; ?></td>
                                        <td><?php echo date("m-j G:i", $user->last_check_in_time); ?></td>
                                        <td><?php echo $user->reg_date; ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?php echo site_url( "admin/user_edit/$user->uid"); ?>">编辑</a>
                                            <a class="btn btn-danger btn-sm" href="<?php echo site_url( "admin/user_del/$user->uid"); ?>">删除</a>
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
<script src="<?php echo base_url('static/js/jquery-2.1.1.js'); ?>"></script>
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

<script type="text/javascript">
    $(window).on('load', function () {

        $('.selectpicker').selectpicker({
            'selectedText': 'cat'
        });

        // $('.selectpicker').selectpicker('hide');
    });
    $('#userTable').dataTable();
</script>
<?php $this->load->view('ana') ;?>
</body>
</html>