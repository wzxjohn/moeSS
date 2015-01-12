<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/12/15
 * Time: 21:41
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?><!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            邀请
            <small>Invite</small>
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
                        <h3 class="box-title">邀请码</h3>
                    </div><!-- /.box-header -->

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>###</th>
                                <th>邀请码</th>
                                <th>状态</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php if ($codes) { foreach ($codes as $code): ?>
                                <tr>
                                    <td><?php echo $a;$a++; ?></td>
                                    <td><?php echo $code->code;?></td>
                                    <td>可用</td>
                                </tr>
                            <?php endforeach; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.box -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</aside><!-- /.right-side -->
