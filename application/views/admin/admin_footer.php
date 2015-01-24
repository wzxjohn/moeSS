<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/12/15
 * Time: 19:03
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
?><script src="<?php echo base_url('static/js/jquery-2.1.1.js'); ?>"></script>
<script src="<?php echo base_url('static/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('static/js/jquery-ui.min.js'); ?>" type="text/javascript"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url('static/js/raphael-min.js'); ?>"></script>
<script src="<?php echo base_url('static/js/plugins/morris/morris.min.js'); ?>" type="text/javascript"></script>
<!-- Sparkline -->
<script src="<?php echo base_url('static/js/plugins/sparkline/jquery.sparkline.min.js'); ?>" type="text/javascript"></script>
<!-- jvectormap -->
<script src="<?php echo base_url('static/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('static/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>" type="text/javascript"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url('static/js/plugins/jqueryKnob/jquery.knob.js'); ?>" type="text/javascript"></script>
<!-- Moment JS -->
<script src="<?php echo base_url('static/js/plugins/moment/moment.min.js'); ?>"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url('static/js/plugins/daterangepicker/daterangepicker.js'); ?>" type="text/javascript"></script>
<!-- datepicker -->
<script src="<?php echo base_url('static/js/plugins/datepicker/bootstrap-datepicker.js'); ?>" type="text/javascript"></script>
<!-- dateTable -->
<script src="<?php echo base_url('static/js/plugins/datatables/dataTables.bootstrap.js'); ?>" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('static/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>" type="text/javascript"></script>
<!-- iCheck -->
<script src="<?php echo base_url('static/js/plugins/iCheck/icheck.min.js'); ?>" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('static/js/AdminLTE/app.js'); ?>" type="text/javascript"></script>

<!-- Select js -->
<script src="<?php echo base_url('static/js/bootstrap-select.js'); ?>"></script>
<script src="<?php echo base_url('static/js/bootstrap-switch.js'); ?>"></script>
<script src="<?php echo base_url("static/bootstrap-dialog/js/bootstrap-dialog.min.js"); ?>"></script>

<script type="text/javascript">
    $(window).on('load', function () {

        $('.selectpicker').selectpicker({
            'selectedText': 'cat'
        });

        // $('.selectpicker').selectpicker('hide');
    });
    $(function() {
        $("#userTable").dataTable();
    });
</script>
<?php $this->load->view('ana') ;?>
</body>
</html>
