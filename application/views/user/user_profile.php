<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/12/15
 * Time: 21:49
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
$this->load->helper('form');
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
                        <i class="fa fa-pencil-square-o"></i>
                        <h3 class="box-title">资料修改</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php
                    $attributes = array(
                        'role' => 'form',
                        'name' => 'editForm',
                        'id' => 'editForm'//,
                        //'onsubmit' => 'return check()'
                    );
                    echo form_open('user/do_profile_update', $attributes);
                    ?>
                        <div class="box-body">
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="当前密码(必填)" id="nowpassword" name="nowpassword" required>
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="新密码(不修改请留空)" id="password" name="password">
                            </div>

                            <div class="form-group">
                                <input type="password" placeholder="确认密码" class="form-control" id="repassword" name="repassword">
                            </div>

                            <div class="form-group">
                                <input type="text" placeholder="邮箱(不修改请留空)" class="form-control" id="email" name="email">
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" name="action" value="add" class="btn btn-primary">修改</button>
                        </div>
                    <?php echo form_close(); ?>
                </div><!-- /.box -->
            </div>

            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-align-left"></i>
                        <h3 class="box-title">Shadowsocks连接密码修改</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form role="form" id="ssPass" name="ssPass" method="post" action="<?php echo site_url('user/update_ss_pass'); ?>"  >
                            <div class="form-group">
                                <input type="text" placeholder="输入新密码" class="form-control" id="pass" name="pass" required>
                            </div>

                            <div class="box-footer">
                                <button type="submit" name="action" value="edit" class="btn btn-primary">修改</button>
                            </div>
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col (right) -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
<?php $this->load->view('ana') ;?>
</body>
</html>
