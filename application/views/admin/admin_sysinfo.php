<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/13/15
 * Time: 20:59
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?><!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            系统信息
            <small><?php echo SITE_NAME;?> Infomation</small>
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
                        <h3 class="box-title"><?php echo SITE_NAME;?>统计信息</h3>
                    </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="callout callout-warning">
                                <h4>注意!</h4>
                                <p>流量统计仅供参考，在线人数有一小会儿的延迟.</p>
                            </div>
                            <p>Time: <?php  echo  date("Y-m-d H:i",time()); ?>当前版本<code><?php echo $version; ?></code></p>
                            <p><?php echo SITE_NAME;?>已经产生流量<code><?php echo $mt; ?></code>。</p>
                            <p>注册用户: <code><?php echo $all_user;?> </code></p>
                            <p>已经有<code><?php echo $active_user;?></code>个用户使用了<?php echo SITE_NAME;?>服务。</p>
                            <p>过去1小时在线人数<code><?php echo $user_time_count_3600;?></code>。</p>
                            <p>过去5min在线人数<code><?php echo $user_time_count_300;?></code>。</p>
                            <p>过去1min在线人数<code><?php echo $user_time_count_60;?></code>。</p>
                            <p>实时在线人数<code><?php echo $user_time_count_10;?></code>。</p>
                            <p>过去24小时在线人数<code><?php echo $user_time_count_24;?></code>。</p>
                    </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
