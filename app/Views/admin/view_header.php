<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Peak PotentialCMS</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?= csrf_meta() ?>

	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/datepicker3.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/all.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/select2.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/jquery.fancybox.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/_all-skins.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/magnific-popup.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/admin/css/shivalik-admin.css">

</head>

<body class="hold-transition fixed skin-blue skin-Peaksidebar-mini">

	<div class="wrapper">

		<header class="main-header">

			<a href="<?php echo base_url(); ?>admin/dashboard" class="logo">
				<span class="logo-lg"><?php echo esc($setting['website_name'] ?? 'PeakRasayan'); ?></span>
			</a>

			<nav class="navbar navbar-static-top">
				
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<span class="srl-header-title">Content Manager</span>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li>
							<a href="<?php echo base_url(); ?>" target="_blank">Visit Website</a>
						</li>

						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<?php if($this->session->userdata('photo') == ''): ?>
									<img src="<?php echo base_url(); ?>public/img/no-photo.jpg" class="user-image" alt="user photo">
								<?php else: ?>
									<img src="<?php echo base_url(); ?>public/uploads/<?php echo esc($this->session->userdata('photo')); ?>" class="user-image" alt="user photo">
								<?php endif; ?>
								
								<span class="hidden-xs"><?php echo esc($this->session->userdata('full_name')); ?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-footer">
									<div>
										<a href="<?php echo base_url(); ?>admin/profile" class="btn btn-default btn-flat">Edit Profile</a>
									</div>
									<div>
										<a href="<?php echo base_url(); ?>admin/login/logout" class="btn btn-default btn-flat">Log out</a>
									</div>
								</li>
							</ul>
						</li>
						
					</ul>
				</div>

			</nav>
		</header>

  		<?php
			$class_name = '';
		    $segment_2 = 0;
		    $segment_3 = 0;
		    $class_name = strtolower(substr(strrchr(\Config\Services::router()->controllerName(), '\\'), 1));
		    $segment_2 = \Config\Services::request()->getUri()->getSegment(2, '');
		    $segment_3 = \Config\Services::request()->getUri()->getSegment(3, '');
		?>

  		<aside class="main-sidebar">
    		<section class="sidebar">

				<div class="sidebar-brand">
					<span class="sidebar-brand-name"><?php echo esc($setting['website_name'] ?? 'PeakRasayan'); ?></span>
					<span class="sidebar-brand-sub">Website CMS</span>
				</div>
     
      			<ul class="sidebar-menu">

			        <li class="treeview <?php if($class_name == 'dashboard') {echo 'active';} ?>">
			          <a href="<?php echo base_url(); ?>admin/dashboard">
			            <i class="fa fa-laptop"></i> <span>Dashboard</span>
			          </a>
			        </li>

			        <li class="treeview <?php if($class_name == 'site_inquiry') {echo 'active';} ?>">
			          <a href="<?php echo base_url(); ?>admin/site_inquiry">
			            <i class="fa fa-envelope"></i> <span>Enquiries</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($class_name == 'setting') ) {echo 'active';} ?>">
			          <a href="<?php echo base_url(); ?>admin/setting">
			            <i class="fa fa-cog"></i> <span>Settings</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($class_name == 'page_home') || ($class_name == 'page_about') || ($class_name == 'page_contact') || ($class_name == 'page_team') || ($class_name == 'page_news') || ($class_name == 'slider') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-file-text-o"></i>
							<span>Page Settings</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="<?php echo base_url(); ?>admin/page-home"><i class="fa fa-circle-o"></i> Home Page</a></li>
							<li><a href="<?php echo base_url(); ?>admin/page-about"><i class="fa fa-circle-o"></i> About Page</a></li>
							<li><a href="<?php echo base_url(); ?>admin/page-contact"><i class="fa fa-circle-o"></i> Contact Page</a></li>
						</ul>
					</li>

					

			        
			        <li class="treeview <?php if( ($class_name == 'social_media') ) {echo 'active';} ?>">
			          <a href="<?php echo base_url(); ?>admin/social_media">
			            <i class="fa fa-share-alt"></i> <span>Social Media</span>
			          </a>
			        </li>

      			</ul>
    		</section>
  		</aside>

  		<div class="content-wrapper">