<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->view('admin/layouts/header'); ?>
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
					<div class="page-icon">
						<i class="icon-laptop_windows"></i>
					</div>
					<div class="page-title">
						<h3>Dashboard</h3>
						<h6 class="sub-heading">Welcome to dashboard.</h6>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		
				<div class="row gutters">
					<?php
					if(isset($userrole['record']['permissions']['users']) && $userrole['record']['permissions']['users']['view'] === true){
						?>
			        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
			        	<a href="<?php echo base_url(); ?>admin/user">
				            <div class="plain-widget blue" data-toggle="tooltip" title="Users">
				                <div class="growth bg-info"><i class="icon-users"></i></div>
				                <h3><?php echo $users; ?></h3>
				                <p>Users</p>
				                <div class="progress sm no-shadow">
				                    <div class="progress-bar bg-info dashboardbox" role="progressbar"  aria-valuenow="37" aria-valuemin="0" aria-valuemax="100"></div>
				                </div>
				            </div>
				        </a>
			        </div>
			    	<?php } ?>
			        <?php if($admin['role'] !=='2' && $admin['role'] !=='3'){ ?>
			        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
			        	<a href="<?php echo base_url(); ?>admin/user">
				            <div class="plain-widget blue" data-toggle="tooltip" title="Users">
				                <div class="growth bg-info"><i class="icon-users"></i></div>
				                <h3><?php echo $seller; ?></h3>
				                <p>Resellers</p>
				                <div class="progress sm no-shadow">
				                    <div class="progress-bar bg-info dashboardbox" role="progressbar"  aria-valuenow="37" aria-valuemin="0" aria-valuemax="100"></div>
				                </div>
				            </div>
				        </a>
			        </div>
			    	<?php } ?>
                
                 <?php if($admin['role'] !=='2' && $admin['role'] !=='3'){ ?>
                 <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                  <a href="<?php echo base_url(); ?>admin/category">
                        <div class="plain-widget blue" data-toggle="tooltip" title="Users">
                            <div class="growth bg-info"><i class="icon-leaf"></i></div>
                            <h3><?php echo $category; ?></h3>
                            <p>Category</p>
                            <div class="progress sm no-shadow">
                                <div class="progress-bar bg-info dashboardbox" role="progressbar"  aria-valuenow="37" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </a>
                 </div>
               <?php } ?>
			    	<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
			        	<a href="<?php echo base_url(); ?>admin/exal">
				            <div class="plain-widget blue" data-toggle="tooltip" title="Users">
				                <div class="growth bg-info"><i class="icon-database3"></i></div>
				                <h3><?php echo $exal; ?></h3>
				                <p>Excel</p>
				                <div class="progress sm no-shadow">
				                    <div class="progress-bar bg-info dashboardbox" role="progressbar"  aria-valuenow="37" aria-valuemin="0" aria-valuemax="100"></div>
				                </div>
				            </div>
				        </a>
			        </div>
			        
			   
			        <?php
				    if(isset($userrole['record']['permissions']['cms']) && $userrole['record']['permissions']['cms']['view'] === true){

				        ?>
				        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
				        	<a href="<?php echo base_url(); ?>admin/cms">
					            <div class="plain-widget blue" data-toggle="tooltip" title="CMS">
					                <div class="growth bg-info"><i class="icon-text"></i></div>
					                <h3><?php echo $cms; ?></h3>
					                <p>CMS</p>
					                <div class="progress sm no-shadow">
					                    <div class="progress-bar bg-info dashboardbox" role="progressbar"  aria-valuenow="37" aria-valuemin="0" aria-valuemax="100"></div>
					                </div>
					            </div>
					        </a>
				        </div>
			        </div>
				    <?php
				    }
			        
			        if(isset($userrole['record']['permissions']['cms']) && isset($userrole['record']['permissions']['users']) && $userrole['record']['permissions']['cms']['view'] !== true && $userrole['record']['permissions']['users']['view'] !== true){
			        	?>
			        	<div class="row gutters">
			        	<h2 align="center">Welcome</h2>
			        	</div>
			        	<?php
			        }

					if(isset($userrole['record']['permissions']['users']) && $userrole['record']['permissions']['users']['view'] === true){
					
		        	?>
		        </div>
        		<div class="row gutters">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="card">
							
							<div class="card-body">
							<div id="container">
								<div class="dashboardcontainer"></div>
							</div>

							</div>
						</div>
					</div>

				</div>
				<?php
				}
				if(isset($userrole['record']['permissions']['users']) && $userrole['record']['permissions']['users']['view'] === true){
				
					?>
			        <div class="row gutters">
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
							
						<div class="section-container">
						
							<p class="section-title">Last 5 Logged in Users</p>

							<div class="table-responsive">
								<table class="table m-0">
									<thead class="thead-light">
										<tr>
											<th>Sr No</th>
											<th>Name</th>
											<th>Email</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach($last_login as $key=>$val){
											?>
										<tr>
											<td><?php echo $key+1;?></td>
											<td><?php echo ucfirst($val['firstname']).' '.$val['lastname'];?></td>
											<td><?php echo $val['email']?></td>
											<td><?php if($val['status'] == "1"){?>
											<span class="badge badge-info">Active</span>
											<?php
											}else{?>
											<span class="badge badge-warning">Inactive</span>
											<?php
										}?>
											</td>
										</tr>
										<?php
									}
									?>
									</tbody>
								</table>
							</div>
							
					    </div>
						</div>
					   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
							
						<div class="section-container">
						
							<p class="section-title">Last 5 Registered Users</p>

							<div class="table-responsive">
								<table class="table m-0">
									<thead class="thead-light">
										<tr>
											<th>Sr No</th>
											<th>Name</th>
											<th>Email</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach($last_register as $key=>$val){
											?>
										<tr>
											<td><?php echo $key+1;?></td>
											<td><?php echo ucfirst($val['firstname']).' '.$val['lastname'];?></td>
											<td><?php echo $val['email']?></td>
											<td><?php if($val['status'] == "1"){?>
											<span class="badge badge-info">Active</span>
											<?php
											}else{?>
											<span class="badge badge-warning">Inactive</span>
											<?php
										}?>
											</td>
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
					<?php
				}?>
			</div>
	
	<!-- END: .main-content -->
<?php $this->view('admin/layouts/footer'); ?>
<input type="hidden" id="registered" value="<?php echo $registered; ?>"/>
<script src="<?php echo asset_url(); ?>admin/js/pages/dashboard.js"></script>