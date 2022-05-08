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
				<?php
				if($userrole['record']['permissions']['users']['create'] == "1"){
					if(role_check() =='seller' && howmuch_can_user_create() > 0)
					{
					?>

	                    <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create" href="<?php echo base_url('admin/user/create'); ?>"><i class="icon-plus"></i> Add User</a>
	            	<?php
	            	}else if(role_check() !=='seller')
	            	{
	            	?>

	                    <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create" href="<?php echo base_url('admin/user/create'); ?>"><i class="icon-plus"></i> Add User</a>
	            	<?php
	            	}
	        		}
	        		if(role_check() !== "seller" && role_check() !== "user"){
	            	?>
	                    <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create" href="<?php echo base_url('admin/user/exportCSV'); ?>"><i class="icon-printer"></i> Export</a>
	                    <!-- <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create" href="<?php echo base_url('admin/user/ShowimportCsv'); ?>"><i class="icon-printer"></i> Import CSV</a> -->
	                    <!-- <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create" href="<?php echo base_url('admin/user/exportCSVformat'); ?>"><i class="icon-printer"></i> Export CSV Format</a> -->
	                </div>
	            	<?php } ?>
	            </div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<!-- Row start -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<?php $this->view('admin/validation'); ?>
				<div class="card custom-bdr">
					<div class="card-body table-responsive">
						<?php
							if($userrole['record']['permissions']['users']['delete'] === true){
				
							?>
								<a data-toggle="tooltip" class="btn btn-danger btn-sm btn-edit pull-right" id="deletevalue" ><i class="icon-trash2"></i> Delete</a>
								<?php
							}
							?>
						<table id="datatable" class="table table-bordered">
							<thead>
								<tr>
									<?php if($userrole['record']['permissions']['users']['delete'] === true){ ?>
									<th><div class="custom-control custom-checkbox">
											<input class="custom-control-input" type="checkbox" id="checkalluser">
											<label class="custom-control-label baniplable" for="checkalluser"></label>
										</div></th>
										<?php } ?>
									<th>Sr No</th>
									<th>Name</th>
									<?php if(getrole_id() == 1){ ?>
									<th>Under whom</th>
									<?php } ?>
									<th>Email/Mobile/Company</th>
									<th>Birth Date</th>
									<th>Last Login</th>
                           <th>Role</th>
									<th>Status</th>
									<?php
									if($userrole['record']['permissions']['users']['edit'] === true || $userrole['record']['permissions']['users']['delete'] === true  ){
											?>
									<th>Action</th>
									<?php
								}
									?>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($users['records'] as $key=>$val){
										?>
										<tr>
											<?php if($userrole['record']['permissions']['users']['delete'] === true){ ?>
											<td><div class="custom-control custom-checkbox">
											<input class="custom-control-input values banipvalues"  name="userselect[]" value="<?php echo $val['id'];?>" type="checkbox" id="<?php echo 'checkbox'.$val['id'];?>">
											<label class="custom-control-label baniplable" for="<?php echo 'checkbox'.$val['id'];?>"></label>
											</div>
											</td>
											
											
											<?php } ?>
											<td><?php echo ($key+1); ?></td>
											<td>
												<span class="avatar avatar-img list-img">
													<?php
														if($val['image']==''){
															?>
															<img src="<?php echo asset_url().'images/user.png'; ?>" />
															<?php
														}
														else{
																if($val['image_flag']=='0'){
															?>
																<img src="<?php echo base_url(); ?>uploads/admins/<?php echo $val['image']; ?>" />
																
															<?php
															}
															else{
																?>
																<img src="<?php echo $val['image']; ?>" >
															
															<?php
														}
														}
													?>
												</span>
												<?php
													echo ucfirst($val['firstname']).' '.ucfirst($val['lastname']);
												?>
											</td>
											<?php if(getrole_id() == 1){ ?>
											<td><?= checksellername($val['seller_id']); ?></td>
											<?php } ?>
											<td><?php echo $val['email']; ?></br><?php echo $val['mobile']; ?></br><?php echo $val['company']; ?></td>
											<td><?php echo $val['birthdate']; ?></td>
											<td><?php echo $val['last_login']; ?></td>
                                 <td><?= ($val['role']==2)?'<button class="btn btn-warning btn-sm btn-edit">Reseller</button>':'<button class="btn btn-primary btn-sm btn-edit">User</button>'; ?></td>

											<td>
												<?php
													if($val['status']=='1'){
														?>
														<a data-toggle="tooltip" class="btn btn-success btn-sm btn-edit" href="<?php echo base_url('admin/user/status/'.$val['id'].'/0'); ?>"><i class="icon-tick"></i> Active</a>
														<?php
													}
													else{
														?>
														<a data-toggle="tooltip" class="btn btn-warning btn-sm btn-edit" href="<?php echo base_url('admin/user/status/'.$val['id'].'/1'); ?>"><i class="icon-warning2"></i> Inactive</a>
														<?php
													}
												?>
											</td>

											<?php

										     if($userrole['record']['permissions']['users']['edit'] === true || $userrole['record']['permissions']['users']['delete'] === true  ){
											?>
											<td>
													<?php
												if($userrole['record']['permissions']['users']['edit'] === true){
												?> 
												<a data-toggle="tooltip" class="btn btn-primary btn-sm btn-edit" href="<?php echo base_url('admin/user/edit/'.$val['id']); ?>"><i class="icon-pencil"></i> Edit</a>
												<?php
											}
										
				
											?>
												
											</td>
											<?php
										}
											?>
										</tr>
										<?php
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END: .main-content -->
<?php $this->view('admin/layouts/footer'); ?>
<input type="hidden" id="userurl" value="<?php echo base_url('admin/user')?>/"/>
<input type="hidden" id="destroy" value="<?php echo base_url('admin/user/destroy')?>"/>
<script src="<?php echo asset_url(); ?>admin/js/pages/banip-list.js"></script>