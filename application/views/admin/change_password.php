<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->view('admin/layouts/header'); ?>
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
					<div class="page-icon">
						<i class="icon-cog"></i>
					</div>
					<div class="page-title">
						<h3>Change Password</h3>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<form id="SignUp" action="<?php echo base_url('admin/admin/update_password'); ?>" method="post">
			<?php $this->view('admin/validation'); ?>
			<div class="card">
                <div class="card-body">
					<div class="row gutters">
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<input type="password" class="form-control" id="current_password" name="current_password" placeholder="Current Password *" />
							</div>
						</div>
					</div>
					<div class="row gutters">
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<input type="password" class="form-control" id="password" name="password" placeholder="New Password *" />
							</div>
						</div>
					</div>
					<div class="row gutters">
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<input type="password" class="form-control" id="confirm_assword" name="confirm_password" placeholder="Confirm Password *" />
							</div>
						</div>
					</div>
					<div class="actions clearfix">
						<button type="submit" class="btn btn-primary"><span class="icon-save2"></span> Update Password</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- END: .main-content -->
<?php $this->view('admin/layouts/footer'); ?>