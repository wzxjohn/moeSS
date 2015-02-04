<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2/3/15
 * Time: 11:40
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
<form role="form" method="post" action="<?php echo site_url("admin/do_add_traffic/$user->uid");?>">
    <div class="form-group">
        <label for="cate_title">用户名</label>
        <input type="text" class="form-control" name="user_name" value="<?php echo $user->user_name?>" readonly>
    </div>

    <div class="form-group">
        <label for="cate_title">流量(MB)<small>整数</small></label>
        <input type="text" class="form-control" name="traffic">
    </div>

    <div class="box-footer">
        <button type="submit" name="action" value="add" class="btn btn-primary">添加</button>
    </div>
</form>