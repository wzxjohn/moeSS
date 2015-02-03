<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/12/15
 * Time: 21:28
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
                        <i class="fa fa-user"></i>
                        <h3 class="box-title">我的信息</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p>用户名: <?php echo $user_name; ?></p>
                        <p>邮箱: <?php echo $user_email;  ?></p>
                        <p> 套餐: <span class="label label-info"> <?php echo $plan; ?> </span> </p>
                        <p> 账户余额: <?php echo $money; ?>元 <a class="btn btn-info btn-sm" href="<?php echo site_url('user/pay'); ?>" target="_blank">充值</a></p>
                    </div><!-- /.box -->
                </div>
            </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->