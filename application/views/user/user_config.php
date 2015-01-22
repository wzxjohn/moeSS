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
?><html>
<head>
	<link rel="shortcut icon" type="image/ico" href="<?php echo base_url('favicon.ico'); ?>" />
	<title><?php echo SITE_NAME; ?> - 配置文件</title>
	<script src="<?php echo base_url('static/js/jquery-2.1.1.js'); ?>"></script>
	<script src="<?php echo base_url('static/js/qrcode.min.js'); ?>"></script>
</head>
<body>
	<div><textarea rows="8" cols="30" onclick="this.focus();this.select()">{
"server":"<?php echo $server; ?>",
"server_port":<?php echo $port; ?>,
"local_port":1080,
"password":"<?php echo $password; ?>",
"timeout":600,
"method":"<?php echo $method; ?>"
}</textarea></div>
	<div><input id="config" type="hidden" value="<?php echo $ssurl; ?>"></input></div>
	<div id="qrcode"></div>
	<script type="text/javascript">
		var text = document.getElementById("config");
		var qrcode = new QRCode("qrcode");
		qrcode.makeCode(text.value);
	</script>
</body>
</html>