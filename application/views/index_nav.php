<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/11/15
 * Time: 17:45
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="header">
    <ul class="nav nav-pills pull-right" role="tablist">
        <li role="presentation"><a href="<?php echo site_url()?>">主页</a></li>
        <li role="presentation"><a href="<?php echo site_url('user/register') ;?>">注册</a></li>
        <li role="presentation"><a href="<?php echo site_url('siteIndex/view_code') ;?>">邀请码</a></li>
        <li role="presentation"><a href="<?php echo site_url('user/login'); ?>">登录</a></li>
        <li role="presentation"><a href="<?php echo site_url('user'); ?>">用户中心</a></li>
    </ul>
    <h3 class="text-muted"><?php echo SITE_NAME; ?></h3>
</div>
