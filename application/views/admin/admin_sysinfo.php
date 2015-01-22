<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/13/15
 * Time: 20:59
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
                            <p>Time: <?php  echo  date("Y-m-d H:i",time()); ?> 当前版本<code><?php echo $version; ?></code></p>
                            <p><?php echo SITE_NAME;?> 已经产生流量 <code><?php echo $mt; ?></code>。</p>
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
