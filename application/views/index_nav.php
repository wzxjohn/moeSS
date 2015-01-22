<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/11/15
 * Time: 17:45
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
?>
<div class="header">
    <ul class="nav nav-pills pull-right" role="tablist">
        <li role="presentation"><a href="<?php echo site_url()?>">主页</a></li>
        <li role="presentation"><a href="<?php echo site_url('user/register') ;?>">注册</a></li>
        <li role="presentation"><a href="<?php echo site_url('siteIndex/view_code') ;?>">邀请码</a></li>
        <li role="presentation"><a href="<?php echo site_url('user'); ?>">用户中心</a></li>
    </ul>
    <h3 class="text-muted"><?php echo SITE_NAME; ?></h3>
</div>
