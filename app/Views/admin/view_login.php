<?php

$Model_common = new \App\Models\Admin\Model_common();
$setting_data = $Model_common->get_setting_data();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login | Shivalik Rasayan CMS</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/shivalik-admin.css">
	<?= csrf_meta() ?>
</head>

<body class="hold-transition srl-login-page sidebar-mini">

<div class="login-box">
	<div class="login-logo">
		<div class="srl-login-badge">SRL CMS</div>
		<b><?php echo esc($setting_data['website_name'] ?? 'Shivalik Rasayan Limited'); ?></b>
		<span>Sign in to manage website content</span>
	</div>
  	<div class="login-box-body">
    	<p class="login-box-msg">Log in to your account</p>
    
	    <?php
        if(session()->getFlashdata('error')) {
            echo '<div class="error">'.esc(session()->getFlashdata('error')).'</div>';
        }
        if(session()->getFlashdata('success')) {
            echo '<div class="success">'.esc(session()->getFlashdata('success')).'</div>';
        }
        ?>

		<?php echo form_open(base_url().'admin'); ?>
			<div class="form-group has-feedback">
				<input class="form-control" placeholder="Email address" name="email" type="email" autocomplete="off" value="<?php echo (PROJECT_MODE == 0) ? 'admin@gmail.com' : ''; ?>" autofocus>
			</div>
			<div class="form-group has-feedback">
				<input class="form-control" placeholder="Password" name="password" type="password" autocomplete="off" value="<?php echo (PROJECT_MODE == 0) ? '1234' : ''; ?>">
			</div>
			<div class="row">
				<div class="col-xs-7" style="padding-top:10px;"><a href="<?php echo base_url(); ?>admin/forget-password" style="color:var(--srl-teal);font-weight:500;">Forgot password?</a></div>
				<div class="col-xs-5">
					<input type="submit" class="btn btn-primary btn-block btn-flat login-button" name="form1" value="Sign In">
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
	<p class="login-footer-note">&copy; <?php echo date('Y'); ?> Shivalik Rasayan Limited</p>
</div>

<script src="<?php echo base_url(); ?>public/admin/js/jquery-2.2.3.min.js"></script>
<script src="<?php echo base_url(); ?>public/admin/js/bootstrap.min.js"></script>
</body>
</html>
