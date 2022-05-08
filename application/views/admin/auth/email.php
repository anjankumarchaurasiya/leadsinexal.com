<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" href="<?php echo isset($settings['records'][0]['favicon'])!=''?base_url().'uploads/images/'.$settings['records'][0]['favicon']:asset_url().'images/favicon.ico'; ?>"  />
		<title>Forgot Password</title>
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/bootstrap.min.css" />
		<!-- Icomoon Icons CSS -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/fonts/icomoon/icomoon.css" />
		<!-- Master CSS -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/main.css" />
		<!-- custom style -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/style.css" />
	</head>
	<body>
		<!-- Container start -->
		<div class="container">
			<form id="SignIn" action="<?php echo base_url('admin/auth/forgot'); ?>" method="post">
				<div class="row justify-content-md-center">
					<div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
						<div class="login-screen">
							<div class="login-box">
								<a href="#" class="login-logo">
									<img src="<?php echo isset($settings['records'][0]['logo'])!=''?base_url().'uploads/images/'.$settings['records'][0]['logo']:asset_url().'images/logo-light.png'; ?>" />
								</a>
								<?php $this->view('admin/validation'); ?>
								<div class="form-group">
									<input type="email" class="form-control" id="email" name="email" placeholder="Email Address *" value="<?php echo set_value('email'); ?>" />
								</div>
								<div class="actions">
									<button type="submit" class="btn btn-primary btn-block"><span class="icon-log-out"></span> Reset Password</button>

								</div>
								<div class="mt-4">
								<a href="<?php echo base_url('admin/signin'); ?>" class="additional-link">Have Password? <span>Sign In</span></a>
								</div>
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
		<script src="<?php echo asset_url(); ?>admin/js/nifty.min.js"></script>
	</body>
</html>
