<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" href="<?php echo isset($settings['records'][0]['favicon'])!=''?base_url().'uploads/images/'.$settings['records'][0]['favicon']:asset_url().'images/favicon.ico'; ?>" />
		<title><?php echo ucfirst($this->uri->segment(2)); ?></title>
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/bootstrap.min.css" />
		<!-- Icomoon Icons CSS -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/fonts/icomoon/icomoon.css" />
		<!-- Master CSS -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/main.css" />
		<!-- custom style -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/style.css" />
		<!-- Gallery CSS -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/plugins/gallery/gallery.css" />
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/summernote-bs4.css" />
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/common.css" />
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/fonts/font-awesome/font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/bs-select.css" />
      <link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/bs-select.css" />
		<link rel="stylesheet" href="<?php echo asset_url(); ?>/select2/select2.min.css"/>
		
		<!-- jQuery JS. -->
		<script src="<?php echo asset_url(); ?>admin/js/jquery.js"></script>
		<!-- Tether js, then other JS. -->
		<script src="<?php echo asset_url(); ?>admin/js/popper.min.js"></script>
		<script src="<?php echo asset_url(); ?>admin/js/bootstrap.min.js"></script>
		<script src="<?php echo asset_url(); ?>admin/js/summernote-bs4.js"></script>
		<script src="<?php echo asset_url(); ?>admin/js/c3.min.js"></script>
		<script src="<?php echo asset_url(); ?>admin/js/bs-select.min.js"></script>
		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/modules/export-data.js"></script>

		<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
		<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
		<script src="<?php echo asset_url(); ?>admin/js/bootstrap-editable.min.js"></script>
      <link rel="stylesheet" type="text/css" href="<?= asset_url(); ?>toaster/notific.css">
	</head>
	<body oncontextmenu="return false" onselectstart="return false" ondragstart="return false" >
		<!-- Loading start -->
		<!-- <div id="loading-wrapper">
			<div id="loader"></div>
		</div> -->
		<!-- Loading end -->
		<!-- BEGIN .app-wrap -->
		<div class="app-wrap">
			<!-- BEGIN .app-heading -->
			<header class="app-header">
				<!-- Container fluid starts -->
				<div class="container-fluid">
					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-7 col-lg-7 col-md-6 col-sm-7 col-7">
							<!-- BEGIN .logo -->
							<div class="logo-block">
								<a href="<?php echo base_url('admin/dashboard'); ?>" class="logo">

								 <img src="<?php echo isset($settings['records'][0]['logo'])!=''?base_url().'uploads/images/'.$settings['records'][0]['logo']:asset_url().'images/logo-light.png'; ?>" />
								
								</a>

								<a class="mini-nav-btn" href="javascript:void(0);" id="onoffcanvas-nav">
									<i class="open"></i>
									<i class="open"></i>
									<i class="open"></i>
								</a>
								<a href="#app-side" data-toggle="onoffcanvas" class="onoffcanvas-toggler" aria-expanded="true">
									<i class="open"></i>
									<i class="open"></i>
									<i class="open"></i>
								</a>
							</div>
							<!-- END .logo -->
						</div>
						<div class="col-xl-5 col-lg-5 col-md-6 col-sm-5 col-5">
							<!-- Header actions start -->
							<ul class="header-actions">
								<li class="dropdown">
									<a href="<?php echo asset_url(); ?>images/user.png" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">

									<div class="avatar avatar-img">
										<?php
											if($admin['image_flag']=='0'){
												?>
												<img src="<?php echo $admin['image']!=''?base_url().'uploads/admins/'.$admin['image']:asset_url().'images/user.png'; ?>" />
												<?php
											}
											else{
												?>
												<img src="<?php echo $admin['image']!=''?$admin['image']:asset_url().'images/user.png'; ?>" />
												<?php
											}
										?>
									</div>
									<span class="user-name"><?php echo $admin['firstname'].' '.$admin['lastname']; ?></span>
									<i class="icon-chevron-small-down downarrow"></i>
									</a>
									<div class="dropdown-menu lg dropdown-menu-right" aria-labelledby="userSettings">
										<div class="admin-settings">
													<?php
													if($admin['login_type']=='1'){
														?>	
													<ul class="admin-settings-list">
												<li>
													<a href="<?php echo base_url('admin/profile'); ?>">
														<span class="icon icon-user"></span>
														<span class="text-name">Profile</span>
													</a>
												</li>
												<li>
													<a href="<?php echo base_url('admin/change_password'); ?>">
														<span class="icon icon-cog"></span>
														<span class="text-name">Change Password</span>
													</a>
												</li>
													
												 </ul>
									 			<?php
									 		}
													if($admin['login_type'] =='1'){
														?>
											<div class="actions">
												<a href="<?php echo base_url('admin/admin/signout'); ?>" class="btn btn-primary btn-block"><span class="icon-log-out"></span> Sign Out</a>
											</div>
											<?php
											}else{
												?>
											
											<div class="actions">
												<a href="<?php echo base_url('admin/admin/logout'); ?>" class="btn btn-primary btn-block"><span class="icon-log-out"></span> Sign Out</a>
											</div>
											<?php
										}
										?>
										</div>
									</div>
								</li>
							</ul>
							<!-- Header actions end -->
						</div>
					</div>
					<!-- Row start -->
				</div>
				<!-- Container fluid ends -->
			</header>
			<!-- END: .app-heading -->
			<!-- BEGIN .app-container -->
			<div class="app-container">
				<?php $this->view('admin/layouts/sidebar'); ?>
