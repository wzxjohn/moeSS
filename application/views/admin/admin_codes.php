<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/13/15
 * Time: 21:14
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
                </div><!-- /.box -->
            </div>

            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">增加邀请资格</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="addCodeNumForm" name="addCodeNumForm" role="form" method="post" action="<?php echo site_url('admin/add_invite_num') ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="cate_title">用户名</label>
                                <input type="text" class="form-control" id="user_name" name="user_name" placeholder="用户名和UID任选其一"  >
                            </div>

                            <div class="form-group">
                                <label for="cate_title">UID</label>
                                <input type="number" class="form-control" id="uid" name="uid"  placeholder="用户名和UID任选其一" >
                            </div>

                            <div class="form-group">
                                <label for="cate_title">邀请码数量</label>
                                <input type="number" class="form-control" id="code_num" name="code_num" placeholder="要添加的邀请码数量"  >
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" name="action" value="add" class="btn btn-primary">添加</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div><!-- /.row -->
    </section><!-- /.content -->
</aside><!-- /.right-side -->
<?php $this->load->view('ana') ;?>
</body>
</html>