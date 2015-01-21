<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 1/12/15
 * Time: 19:03
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
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('static/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>" type="text/javascript"></script>
<!-- iCheck -->
<script src="<?php echo base_url('static/js/plugins/iCheck/icheck.min.js'); ?>" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('static/js/AdminLTE/app.js'); ?>" type="text/javascript"></script>

<!-- Select js -->
<script src="<?php echo base_url('static/js/bootstrap-select.js'); ?>"></script>
<script src="<?php echo base_url('static/js/bootstrap-switch.js'); ?>"></script>
<script src="<?php echo base_url("static/prettify/run_prettify.js"); ?>"></script>
<script src="<?php echo base_url("static/bootstrap-dialog/js/bootstrap-dialog.min.js"); ?>"></script>

<script type="text/javascript">
    $(window).on('load', function () {

        $('.selectpicker').selectpicker({
            'selectedText': 'cat'
        });

        // $('.selectpicker').selectpicker('hide');
    });
</script>
<?php $this->load->view('ana') ;?>
</body>
</html>
