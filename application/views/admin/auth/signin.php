<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" href="<?php echo isset($settings['records'][0]['favicon'])!=''?base_url().'uploads/images/'.$settings['records'][0]['favicon']:asset_url().'images/favicon.ico'; ?>" />
		<title>Sign In</title>
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
			<form id="SignIn"  method="post" onsubmit="return false;">
				<div class="row justify-content-md-center">
					<div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
						<div class="login-screen">
							<div class="login-box">
								<a href="#" class="login-logo">
									<img src="<?php echo isset($settings['records'][0]['logo'])!=''?base_url().'uploads/images/'.$settings['records'][0]['logo']:asset_url().'images/logo.png'; ?>" />
								</a>
								<?php $this->view('admin/validation'); ?>
								<div>
									<div class="alert alert-success successmessageotp" style="display: none">
									  
									</div>
								</div>
								<div class="login_step_1">
									<div class="form-group">
										<input type="email" class="form-control" id="username" required="" name="username" placeholder="Email *" value="<?php echo set_value('username'); ?>" />
									</div>
									<div class="form-group">
										<input type="password" required="" class="form-control" id="password" name="password" placeholder="Password *" />
									</div>
									<div class="actions">
										<button onclick="checkandsendemailforlogin()" type="button" class="btn btn-primary btn-block"><span class="icon-log-out"></span> <i style="display: none" class="fa fa-spinner fa-spin"></i> Next</button>
										<a href="<?php echo base_url('admin/auth/email'); ?>">Forgot password?</a>
									</div>
								</div> 
								<div class="login_step_2"  style="display: none">
									<div class="form-group">
										<input type="number" class="form-control" id="otp" name="otp" required="" minlength="6" maxlength="6" placeholder="Otp *" value="" />
									</div>
									<div class="actions">
										<button type="submit" class="btn btn-primary btn-block"><span class="icon-log-out"></span> Submit</button>
										<!-- <a href="<?php echo base_url('admin/auth/email'); ?>">Forgot password?</a> -->
									</div>
								</div>
								<!-- <div class="or">
									<span>or signin using</span>
								</div> -->
								<!-- <div class="row gutters">
									<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group">
											<a  href="<?php echo $loginURL; ?>" class="btn btn-danger btn-block">Google</a>
										</div>
									</div>
								</div> -->
								<!-- <div class="mt-4">
									<a href="<?php echo base_url('admin/signup'); ?>" class="additional-link">Not Registered? <span>Create an Account</span></a>
								</div> -->
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
		<script type="text/javascript">
			function checkandsendemailforlogin()
			{
				var username=$('#username').val();
				var password=$('#password').val();
				if(username =="" || password == "")
				{
					return false;
				}else{
 					$.ajax({
                        type: "POST",
                        url: '<?= base_url('admin/auth/loginwithotp') ?>',
                        data: {username: username,password:password},
                     	dataType:'json',
                        success: function(data){
                            console.log(data);
                            if(data.status===true)
                            {
                            	$('.successmessageotp').html(data.message);
                            	$('.login_step_1').hide();
                            	$('.login_step_2').show();

                            }else{
                            	$('.successmessageotp').html(data.message);

                            	$('.login_step_1').show();
                            	$('.login_step_2').hide();
                            }
                            $('.successmessageotp').show();
                        }
                    });
				}
			}
			$(function () {
		        $('#SignIn').on('submit', function (e) {
		          e.preventDefault();
		          $.ajax({
		            type: 'post',
		            url: '<?php echo base_url('admin/auth/dosigninwithotp'); ?>',
		            data: $('#SignIn').serialize(),
		            dataType:'json',
		            success: function (data) {
		            	$('.successmessageotp').show();
		            	$('.successmessageotp').html(data.message);
		            	if(data.status===true)
		            	{
		            		window.location.href="<?= base_url('admin/dashboard') ?>";
		            		
		            	}
		            }
		          });
		        });
		    });
		</script>
	</body>
</html>
