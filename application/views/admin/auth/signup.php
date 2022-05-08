<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" href="<?php echo isset($settings['records'][0]['favicon'])!=''?base_url().'uploads/images/'.$settings['records'][0]['favicon']:asset_url().'images/favicon.ico'; ?>" />
		<title>Sign Up</title>
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/bootstrap.min.css" />
		<!-- Icomoon Icons CSS -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/fonts/icomoon/icomoon.css" />
		<!-- Master CSS -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/main.css" />
		<!-- custom style -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/style.css" />
		<!-- Datepickers css -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/plugins/datetimepicker/datetimepicker.css" />
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/summernote-bs4.css" />
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/common.css" />
	</head>
	<body>
		<!-- Container start -->
		<div class="container">
			<form id="SignUp" action="<?php echo base_url('admin/auth/store'); ?>" method="post">
				<div class="row justify-content-md-center">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="login-screen">
							<div class="login-box">
								<a href="#" class="login-logo">
									<img src="<?php echo isset($settings['records'][0]['logo'])!=''?base_url().'uploads/images/'.$settings['records'][0]['logo']:asset_url().'images/logo-light.png'; ?>" />
								</a>
								<div class="validation">
								</div>
								<?php $this->view('admin/validation'); ?>
								<div class="row gutters">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
										<div class="form-group">
											<input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name *" value="<?php echo set_value('firstname'); ?>" required="required"/>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
										<div class="form-group">
											<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name *" value="<?php echo set_value('lastname'); ?>" />
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
										<div class="form-group">
											<input type="email" class="form-control" id="email" name="email" placeholder="Email Address *" value="<?php echo set_value('email'); ?>" />
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
										<div class="form-group">
											<input type="text" class="form-control datepicker" id="birthdate" name="birthdate" placeholder="Birth Date *" value="<?php echo set_value('birthdate'); ?>" readonly="true" />
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
										<div class="form-group">
											<input type="password" class="form-control" id="password" name="password" placeholder="Password *" />
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
										<div class="form-group">
											<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password *" />
										</div>
									</div>
								</div>
								<div id="formmodel">
            					</div>
								<div class="actions clearfix">
									<button type="submit" class="btn btn-primary btn-block"><span class="icon-log-out"></span> Sign Up</button>
								</div>
								<a href="<?php echo base_url('admin/signin'); ?>" class="additional-link">Have an Account? <span>Sign In Now</span></a>
							</div>
						</div>

					</div>
				</div>
			</form>
		</div>
		<!-- Container end -->
		<!-- jQuery JS. -->
		<script src="<?php echo asset_url(); ?>admin/js/jquery.js"></script>
		<script src="<?php echo asset_url(); ?>admin/js/bootstrap.min.js"></script>
		<!-- Daterange JS -->
		<script src="<?php echo asset_url(); ?>admin/plugins/datetimepicker/datetimepicker.full.js"></script>
		<script src="<?php echo asset_url(); ?>js/common.js"></script>
		<script src="<?php echo asset_url(); ?>admin/js/summernote-bs4.js"></script>
		<input type="hidden" id="dashboardurl" value="<?php echo base_url('admin/dashboard');?>"/>
		<input type="hidden" id="getattribute" value="<?php echo base_url('admin/auth/getattribute');?>"/>
		<script src="<?php echo asset_url(); ?>admin/js/pages/signup.js"></script>
	</body>
</html>
