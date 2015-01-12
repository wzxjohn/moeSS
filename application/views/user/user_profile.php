<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/12/15
 * Time: 21:49
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
                    echo form_open('user/do_update', $attributes);
                    ?>
                        <div class="box-body">
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="当前密码(必填)" name="nowpassword">
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="新密码(不修改请留空)" name="password">
                            </div>

                            <div class="form-group">
                                <input type="password" placeholder="确认密码" class="form-control" name="repassword">
                            </div>

                            <div class="form-group">
                                <input type="text" placeholder="邮箱(不修改请留空)" class="form-control" name="email">
                            </div>

                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" name="action" value="add" class="btn btn-primary">修改</button>
                        </div>
                    </form>

                </div><!-- /.box -->
            </div>

            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header">
                        <i class="fa fa-align-left"></i>
                        <h3 class="box-title">Shadowsocks连接密码修改</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form role="form" name="edit" method="post" action="profile_update_pass_do.php"  >
                            <div class="form-group">
                                <input type="text" placeholder="输入新密码" class="form-control" name="pass">
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
<script LANGUAGE="javascript">
    function check()
    {

        if(document.edit.nowpassword.value.length==0){
            alert("请输入当前密码!");
            document.edit.nowpassword.focus();
            return false;
        }
        if(document.edit.password.value.length != 0){
            if(document.edit.password.value.length < 8){
                alert("密码至少8位");
                document.edit.password.focus();
                return false;
            }
            if(document.edit.repassword.value != document.edit.password.value ){
                alert("两次密码输入不符!");
                document.edit.repassword.focus();
                return false;
            }
        }
        if(document.edit.email.length != 0){
            //对电子邮件的验证
            //定义email正则表达式
            var email_reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;

            if(!email_reg.test(document.reg.email.value)) {
                alert('提示\n\n请输入有效的E-mail！');
                document.reg.email.focus();
                return false;
            }
        }

    }
</script>