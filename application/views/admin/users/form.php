<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->view('admin/layouts/header'); ?>
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
					<div class="page-icon">
						<i class="icon-users"></i>
					</div>
					<div class="page-title">
						<h3>Users</h3>
					</div>
				</div>
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
	                <div class="daterange-container">
	                    <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create" href="<?php echo base_url('admin/user'); ?>"><i class="icon-eye"></i> View</a>
	                </div>
	            </div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<form id="SignUp" action="<?php echo $this->uri->segment(3)=='create'||$this->uri->segment(3)=='store'?base_url('admin/user/store'):base_url('admin/user/update/'.$id); ?>" method="post">
			<?php $this->view('admin/validation'); ?>
			<div class="card">
                <div class="card-body">
					<div class="row gutters">
							<?php
								if(isset($user['record'])){
									?>
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<!-- Gallery start -->
										<div class="baguetteBoxThree gallery">
											<!-- Row start -->
											<div class="row gutters">
												<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
														<?php
														if($user['record']['image']!=''){
															?>
													<a href="<?php echo base_url(); ?>uploads/admins/<?php echo $user['record']['image']; ?>">
														<img src="<?php echo base_url(); ?>uploads/admins/<?php echo $user['record']['image']; ?>" class="img-responsive">
														<div class="overlay">
															<span class="expand">+</span>
														</div>
													</a>
														<?php
															}else{
														?>
														<a href="<?php echo asset_url(); ?>images/user.png">
														<img src="<?php echo asset_url().'images/user.png'; ?>" />
														<div class="overlay">
															<span class="expand">+</span>
														</div>
													</a>
														<?php
													}
													?>
											</div>
											</div>
										</div>
									</div>
								</div>
								<?php
							}
						?>
					
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name *" value="<?php echo set_value('firstname',isset($user['record']['firstname'])?$user['record']['firstname']:''); ?>" />
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name *" value="<?php echo set_value('lastname',isset($user['record']['lastname'])?$user['record']['lastname']:''); ?>" />
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<input type="text" class="form-control" id="username" name="username" placeholder="Username *" value="<?php echo set_value('username',isset($user['record']['username'])?$user['record']['username']:''); ?>" />
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<input type="email" class="form-control" id="email" name="email" placeholder="Email Address *" value="<?php echo set_value('email',isset($user['record']['email'])?$user['record']['email']:''); ?>" />
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<input type="text" class="form-control datepicker" id="birthdate" name="birthdate" placeholder="Birth Date *" value="<?php echo set_value('birthdate',isset($user['record']['birthdate'])?$user['record']['birthdate']:''); ?>" readonly="true" />
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<input type="password" class="form-control" id="password" name="password" placeholder="Password" />
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<input type="password" class="form-control" id="confirm_assword" name="confirm_password" placeholder="Confirm Password" />
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<select class="form-control" name="role" >
									<option value="">Select role</option>
                           <?php
                           foreach($role['records'] as $values){  
                              echo '<pre>';
                              print_r($values);
                              die();
                           ?>
                              <option  <?php echo (isset($user['record']['role']) && $values['id'] == $user['record']['role']) || set_select('role',$values['id']) ?'selected':''; ?> value="<?php echo $values['id']; ?>"><?php echo $values['name'];?></option>
                           <?php
                           }
                           ?>
                           <?php
                           foreach($role['records'] as $values){	
                           ?>
                              <option  <?php echo (isset($user['record']['role']) && $values['id'] == $user['record']['role']) || set_select('role',$values['id']) ?'selected':''; ?> value="<?php echo $values['id']; ?>"><?php echo $values['name'];?></option>
                           <?php
                           }
                           ?>
								</select>
							</div>
						</div>
					</div>
					<div class="actions clearfix">
						<button type="submit" class="btn btn-primary"><span class="icon-save2"></span> <?php echo $this->uri->segment(3)=='create'?'Save':'Update'; ?></button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- END: .main-content -->
<?php $this->view('admin/layouts/footer'); ?>

