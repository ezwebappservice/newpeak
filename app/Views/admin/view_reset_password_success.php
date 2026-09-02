<?php

$Model_common = new \App\Models\Admin\Model_common();
$setting_data = $Model_common->get_setting_data();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Password Updated | Shivalik Rasayan CMS</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/shivalik-admin.css">
</head>

<body class="hold-transition srl-login-page sidebar-mini">

<div class="login-box">
	<div class="login-logo">
		<div class="srl-login-badge">SRL CMS</div>
		<b><?php echo esc($setting_data['website_name'] ?? 'Shivalik Rasayan Limited'); ?></b>
		<span>Your password has been updated</span>
	</div>
  	<div class="login-box-body" style="text-align:center;">
    	<p class="login-box-msg">Password reset complete</p>
	    <?php
        if(session()->getFlashdata('success')) {
            echo '<div class="success">'.session()->getFlashdata('success').'</div>';
        }
        ?>
        <a href="<?php echo base_url(); ?>admin/login" class="btn btn-primary btn-flat login-button" style="display:inline-block;padding:10px 24px;margin-top:8px;">Sign in</a>
	</div>
	<p class="login-footer-note">&copy; <?php echo date('Y'); ?> Shivalik Rasayan Limited</p>
</div>

<script src="<?php echo base_url(); ?>public/admin/js/jquery-2.2.3.min.js"></script>
<script src="<?php echo base_url(); ?>public/admin/js/bootstrap.min.js"></script>
</body>
</html>
