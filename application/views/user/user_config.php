<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/12/15
 * Time: 21:28
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?><html>
<head>
	<title><?php echo SITE_NAME; ?> - 配置文件</title>
	<script src="<?php echo base_url('static/js/jquery-2.1.1.js'); ?>"></script>
	<script src="<?php echo base_url('static/js/qrcode.min.js'); ?>"></script>
</head>
<body>
	<div><textarea rows="7" cols="30">{
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