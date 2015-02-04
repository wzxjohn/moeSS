<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2/3/15
 * Time: 16:24
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
            充值记录
            <small>Pay Log</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <table id="userTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>用户名</th>
                                <th>交易号</th>
                                <th>金额</th>
                                <th>结果</th>
                                <th>创建时间</th>
                                <th>结束时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($logs) { foreach ($logs as $log) : ?>
                                <tr>
                                    <td><?php echo $log->user_name; ?></td>
                                    <td><?php echo $log->trade_no; ?></td>
                                    <td><?php echo $log->amount; ?></td>
                                    <td><span class="label label-<?php if ($log->result) { echo 'success'; } else { echo 'danger'; } ?>"><?php if ($log->result) {echo "已完成";} else {echo "未完成";} ?></span></td>
                                    <td><?php echo date("m-j G:i", $log->ctime); ?></td>
                                    <td><?php if ($log->ftime == 0) {echo "未完成";} else {echo date("m-j G:i", $log->ftime);} ?></td>
                                    <td><a href="<?php echo site_url("user/view_order/$log->trade_no");?>" target="_blank">查看详情</a></td>
                                </tr>
                            <?php endforeach; } ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
