<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/17/15
 * Time: 15:41
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?><!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            系统设置
            <small>System Config</small>
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
                        <h3 class="box-title">账户激活邮件模版</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="<?php echo site_url( "admin/email_tpl_update"); ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="cate_title"><?php echo $email[0]->display_name; ?>    <small><?php echo $email[0]->option_name; ?></small></label>
                                <input type="text" class="form-control" name="<?php echo $email[0]->option_name; ?>" value="<?php echo $email[0]->option_value; ?>" >
                            </div>
                            <div class="form-group">
                                <label for="cate_title"><?php echo $email[1]->display_name; ?>    <small><?php echo $email[1]->option_name; ?></small></label>
                                <textarea rows="15" class="form-control" name="<?php echo $email[1]->option_name; ?>"><?php echo $email[1]->option_value; ?></textarea>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" name="action" value="add" class="btn btn-primary">提交</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.box -->

            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">密码重置邮件模版</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="<?php echo site_url( "admin/email_tpl_update"); ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="cate_title"><?php echo $reset[0]->display_name; ?>    <small><?php echo $reset[0]->option_name; ?></small></label>
                                <input type="text" class="form-control" name="<?php echo $reset[0]->option_name; ?>" value="<?php echo $reset[0]->option_value; ?>" >
                            </div>
                            <div class="form-group">
                                <label for="cate_title"><?php echo $reset[1]->display_name; ?>    <small><?php echo $reset[1]->option_name; ?></small></label>
                                <textarea rows="15" class="form-control" name="<?php echo $reset[1]->option_name; ?>"><?php echo $reset[1]->option_value; ?></textarea>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" name="action" value="add" class="btn btn-primary">提交</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.box -->

            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">账户信息邮件模版</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="<?php echo site_url( "admin/email_tpl_update"); ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="cate_title"><?php echo $resend[0]->display_name; ?>    <small><?php echo $resend[0]->option_name; ?></small></label>
                                <input type="text" class="form-control" name="<?php echo $resend[0]->option_name; ?>" value="<?php echo $resend[0]->option_value; ?>" >
                            </div>
                            <div class="form-group">
                                <label for="cate_title"><?php echo $resend[1]->display_name; ?>    <small><?php echo $resend[1]->option_name; ?></small></label>
                                <textarea rows="15" class="form-control" name="<?php echo $resend[1]->option_name; ?>"><?php echo $resend[1]->option_value; ?></textarea>
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
