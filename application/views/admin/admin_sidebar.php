<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/12/15
 * Time: 18:55
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

    <li class="treeview<?php if ($log_active) { echo ' active';};?>">
        <a href="#">
            <i class="fa fa-file-text"></i> <span>查看日志</span>
        </a>
        <ul class="treeview-menu">
            <li <?php if ($log_u_active) { echo 'class="active"';};?>><a href="<?php echo site_url('admin/user_log'); ?>"><i class="fa fa-angle-double-right"></i> 用户登陆</a></li>
            <li <?php if ($log_m_active) { echo 'class="active"';};?>><a href="<?php echo site_url('admin/mail_log'); ?>"><i class="fa fa-angle-double-right"></i> 邮件发送</a></li>
            <li <?php if ($log_a_active) { echo 'class="active"';};?>><a href="<?php echo site_url('admin/admin_log'); ?>"><i class="fa fa-angle-double-right"></i> 管理登陆</a></li>
        </ul>
    </li>

    <li class="treeview<?php if ($config_active) { echo ' active';};?>">
        <a href="#">
            <i class="fa fa-cog"></i> <span>系统设置</span>
        </a>
        <ul class="treeview-menu">
            <li <?php if ($config_g_active) { echo 'class="active"';};?>><a href="<?php echo site_url('admin/system_config'); ?>"><i class="fa fa-angle-double-right"></i> 一般设置</a></li>
            <li <?php if ($config_m_active) { echo 'class="active"';};?>><a href="<?php echo site_url('admin/mail_config'); ?>"><i class="fa fa-angle-double-right"></i> 发件设置</a></li>
            <li <?php if ($config_e_active) { echo 'class="active"';};?>><a href="<?php echo site_url('admin/email_tpl'); ?>"><i class="fa fa-angle-double-right"></i> 邮件模版</a></li>
        </ul>
    </li>
</ul>
</section>
<!-- /.sidebar -->
</aside>
