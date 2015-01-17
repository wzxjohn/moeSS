<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/12/15
 * Time: 21:28
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?><!-- Right side column. Contains the navbar and content of the page -->
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
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">我的信息</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p>用户名: <?php echo $user_name; ?></p>
                        <p>邮箱: <?php echo $user_email;  ?></p>
                        <p> 套餐: <span class="label label-info"> <?php echo $plan; ?> </span> </p>
                        <p> 账户余额: <?php echo $money; ?>元 <a class="btn btn-info btn-sm" href="<?php echo site_url('user/pay'); ?>">充值</a></p>
                    </div><!-- /.box -->
                </div>
            </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->