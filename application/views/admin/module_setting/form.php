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
						<h3>Module Settings</h3>
					</div>
				</div>
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
	                <div class="daterange-container">
	                    <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create" href="<?php echo base_url('admin/ModuleSetting'); ?>"><i class="icon-eye"></i> View</a>
	                </div>
	            </div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<form id="SignUp" action="<?php echo $this->uri->segment(3)=='create'||$this->uri->segment(3)=='store'?base_url('admin/ModuleSetting/store'):base_url('admin/ModuleSetting/update/'.$id); ?>" method="post">
			<?php $this->view('admin/validation'); ?>
			
			<div class="card">
                <div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								
								<input type="text" class="form-control" id="name" name="name" placeholder="Name *" value="<?php echo set_value('name',isset($user['record']['name'])?$user['record']['name']:''); ?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" name="type" id="attributetype">
									<option value=" ">Choose Attibute Type</option>
									<?php
									foreach($attribute as $key=>$val){
										?>			
									<option  <?php echo (isset($user['record']['type']) && $val == $user['record']['type']) || set_select( 'type',$val) ?'selected':''; ?> value="<?php echo $val;?>"><?php echo ucfirst($val);?></option>
									<?php
								}?>
								</select>
								
							</div>
						</div>
					</div>
						<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control selectpicker" name="validate[]" id="validateattr" multiple="" title="Choose attribute for validation" tabindex="-98">
										<?php
										foreach($validate_attr as $key=>$val){
										?>

									<option <?php echo (isset($user['record']['validate_attr']) &&  in_array($val, $user['record']['validate_attr']['rules'])) || set_select('validate[]',$val) ?'selected':''; ?> value="<?php echo $val;?>"><?php echo $val;?></option>
									<?php
									}?>
										
								</select>
							</div>
						</div>
						

						<div class="col-md-6 values <?php if(isset($user['record']['type'])){  if($user['record']['type'] == 'radio(select one)' || $user['record']['type'] == 'checkbox(multiple select)' || $user['record']['type'] == 'select(dropdown)'){?> modulesettingsblock <?php } } ?> modulesettingsnone ">
							<div class="form-group">
								<label for="type">Enter comma separated string</label>
								<input type="text" class="form-control" id="attributevalue" name="attributevalue" placeholder="Attribute Value *" value="<?php echo set_value('attributevalue',isset($user['record']['data'])?$user['record']['data']:''); ?>" />
							</div>
						</div>
						</div>
						<div class="row">
							<div class="col-md-6 maximum <?php if(isset($user['maximum'])){  echo 'modulesettingsblock'; }else{  echo 'modulesettingsnone'; } ?>">
								<div class="form-group ">
								<input type="number" class="form-control" id="maximum" name="maximum" placeholder="Maximum Value *" value="<?php echo set_value('maximum',isset($user['maximum'])?$user['maximum']:''); ?>" />
							</div>
							</div>
							<div class="col-md-6 minimum <?php if(isset($user['minimum'])){  echo 'modulesettingsblock'; }else{  echo 'modulesettingsnone'; } ?>">
								<div class="form-group ">
									<input type="number" class="form-control" id="minimum" name="minimum" placeholder="Minimum Value *" value="<?php echo set_value('minimum',isset($user['minimum'])?$user['minimum']:''); ?>" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group ">
									<select class="form-control" required="" name="role_id">
										<option>Select role</option>
										<?php foreach ($roles as $key => $value) {
										?>
										<option  <?php echo ($value['id'] == $user['record']['role_id'])?'selected':''; ?> value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
										<?php
										} ?>
									</select>
								</div>
							</div>
						</div>
						
					<div class="actions clearfix">
						<button type="submit" id="cms_submit" class="btn btn-primary"><span class="icon-save2"></span> <?php echo $this->uri->segment(3)=='create'?'Save':'Update'; ?></button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- END: .main-content -->
<?php $this->view('admin/layouts/footer'); ?>
<script src="<?php echo asset_url(); ?>admin/js/pages/modulesettings-form.js"></script>