<?php

$Model_common = new \App\Models\Admin\Model_common();
$setting_data = $Model_common->get_setting_data();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Set New Password | Peak PotentialCMS</title>
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
		<b><?php echo esc($setting_data['website_name'] ?? 'Peak Potential'); ?></b>
		<span>Choose a new password for your account</span>
	</div>
  	<div class="login-box-body">
    	<p class="login-box-msg">Set your new password</p>
    
	    <?php
        if(session()->getFlashdata('error')) {
            echo '<div class="error">'.session()->getFlashdata('error').'</div>';
        }
        if(session()->getFlashdata('success')) {
            echo '<div class="success">'.session()->getFlashdata('success').'</div>';
        }
        ?>

		<?php echo form_open(base_url().'admin/reset-password/index/'.$var1.'/'.$var2);?>
			<div class="form-group has-feedback">
				<input class="form-control" placeholder="New password" name="new_password" type="password" autocomplete="off" autofocus>
			</div>
			<div class="form-group has-feedback">
				<input class="form-control" placeholder="Confirm new password" name="re_password" type="password" autocomplete="off">
			</div>
			<div class="row">
				<div class="col-xs-12">
					<input type="submit" class="btn btn-primary btn-block btn-flat login-button" name="form1" value="Update Password">
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
	<p class="login-footer-note">&copy; <?php echo date('Y'); ?> Peak Potential</p>
</div>

<script src="<?php echo base_url(); ?>public/admin/js/jquery-2.2.3.min.js"></script>
<script src="<?php echo base_url(); ?>public/admin/js/bootstrap.min.js"></script>
</body>
</html>
