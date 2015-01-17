<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/12/15
 * Time: 18:55
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo $gravatar; ?>" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>欢迎, <?php echo $user_name; ?></p>

<a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
</div>
</div>

<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
    <li <?php if ($index_active) { echo 'class="active"';};?>>
        <a href="<?php echo site_url('admin');?>">
            <i class="fa fa-dashboard"></i> <span>管理中心</span>
        </a>
    </li>

    <li <?php if ($user_active) { echo 'class="active"';};?>>
        <a href="<?php echo site_url('admin/users');?>">
            <i class="fa fa-users"></i> <span>用户管理</span>
        </a>
    </li>

    <li <?php if ($node_active) { echo 'class="active"';};?>>
        <a href="<?php echo site_url('admin/nodes');?>">
            <i class="fa fa-sitemap"></i> <span>节点编辑</span>
        </a>
    </li>

    <li <?php if ($code_active) { echo 'class="active"';};?>>
        <a href="<?php echo site_url('admin/codes');?>">
            <i class="fa fa-user"></i> <span>邀请管理</span>
        </a>
    </li>

    <li <?php if ($system_active) { echo 'class="active"';};?>>
        <a href="<?php echo site_url('admin/system_info');?>">
            <i class="fa fa-pencil"></i> <span>系统信息</span>
        </a>
    </li>

    <li class="treeview<?php if ($config_active) { echo ' active';};?>">
        <a href="#">
            <i class="fa fa-cog"></i> <span>系统设置</span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo site_url('admin/system_config'); ?>"><i class="fa fa-angle-double-right"></i> 一般设置</a></li>
            <li><a href="<?php echo site_url('admin/system_email'); ?>"><i class="fa fa-angle-double-right"></i> 发件设置</a></li>
            <li><a href="<?php echo site_url('admin/system_email_tpl'); ?>"><i class="fa fa-angle-double-right"></i> 邮件模版</a></li>
        </ul>
    </li>
</ul>
</section>
<!-- /.sidebar -->
</aside>
