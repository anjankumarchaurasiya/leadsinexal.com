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
						<h3>user</h3>
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
		<form id="SignUp" action="<?php echo $this->uri->segment(3)=='create'||$this->uri->segment(3)=='store'?base_url('admin/user/store'):base_url('admin/user/update/'.$id); ?>" method="post" autocomplete="off">
			<div class="validation"> 
			
        	</div>
			<?php $this->view('admin/validation'); 
			?>
			<div class="card">
    		<div class="card-body">
    			<div class="row gutters pt-5">	 
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
							<input type="text" class="form-control" id="username" name="username" placeholder="Username *" value="<?php echo set_value('username',isset($user['record']['username'])?$user['record']['username']:''); ?>" autocomplete="off" />
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<input type="email" class="form-control" id="email" name="email" placeholder="Email Address *" value="<?php echo set_value('email',isset($user['record']['email'])?$user['record']['email']:''); ?>" />
						</div>
					</div>
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                     <input type="number" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number  " value="<?php echo set_value('mobile',isset($user['record']['mobile'])?$user['record']['mobile']:''); ?>" />
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                     <input type="text" class="form-control" id="company" name="company" placeholder="Company Name" value="<?php echo set_value('company',isset($user['record']['company'])?$user['record']['company']:''); ?>" />
                  </div>
               </div>

					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<input type="text" class="form-control datepicker" id="birthdate" name="birthdate" placeholder="Birth Date *" value="<?php echo set_value('birthdate',isset($user['record']['birthdate'])?$user['record']['birthdate']:''); ?>" readonly="true" />
						</div>
					</div>
					 
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<input type="text" class="form-control" id="password" name="password" placeholder="Password" />
                     <span class="password-absoulate">
                        <button type="button">Generate <input class="password-generate" type="checkbox" name=""></button>
                     </span>
						</div>
					</div>
					<?=  isset($user['record']['role'])?'<input type="hidden" name="role" value="'.$user['record']['role'].'">':''; ?>
					<?php  $getrole=getrole_id(); if($getrole !=='2'){ ?>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<select class="form-control" name="role" id="onchangerole" <?= isset($user['record']['role'])?'disabled':''; ?>>
								 <option value="">Select role</option>
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
					<?php }else{
						?>
						<input type="hidden" name="role" value="3">
						<input type="hidden" name="seller_id" value="<?= $this->session->userdata('admin_id'); ?>">
						<?php 
					} ?>
				</div> 
			<div id="formmodel">
            </div>
			<div class="row">
				<div class="actions clearfix">
					<button type="submit" class="btn btn-primary" id="submitbutton"><span class="icon-save2"></span> <?php echo $this->uri->segment(3)=='create'?'Save':'Update'; ?></button>
				</div>
			</div>
		</div>
	</div>
		</form>
	</div>
	<!-- END: .main-content -->
<?php $this->view('admin/layouts/footer'); ?>
<input type="hidden" id="userurl" value="<?php echo base_url('admin/user');?>"/>
<input type="hidden" id="urlsegment" value="<?php echo $this->uri->segment(4)?>"/>
<input type="hidden" id="editattribute" value="<?php echo base_url('admin/ModuleSetting/editattribute/')?>"/>
<input type="hidden" id="getattribute" value="<?php echo base_url('admin/ModuleSetting/getattribute/');?>"/>
<input type="hidden" id="pageurl" value="<?php echo $this->uri->segment(2)?>"/>
<script src="<?php echo asset_url(); ?>admin/js/pages/userform.js"></script>