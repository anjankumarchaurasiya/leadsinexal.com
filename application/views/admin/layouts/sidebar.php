<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- BEGIN .app-side -->
<aside class="app-side" id="app-side">
	<!-- BEGIN .side-content -->
	<div class="side-content ">
		<!-- Current login user start -->
		<div class="login-user">
			<div class="profile-thumb">
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
			<h6 class="profile-name"><?php echo $admin['firstname'].' '.$admin['lastname']; ?></h6>
		</div>
		<!-- Current login user end -->
		<!-- Nav scroll start -->
		<div class="sidebarNoQuicklinks">
			<!-- BEGIN .side-nav -->
			<nav class="side-nav">
				<!-- BEGIN: side-nav-content -->
				<ul class="unifyMenu pt-2" id="unifyMenu">
					<li class="<?php echo $this->uri->segment(2)=='dashboard'?'selected':''; ?>">
						<a href="<?php echo base_url('admin/dashboard'); ?>">
							<span class="has-icon">
								<i class="icon-laptop_windows"></i>
							</span>
							<span class="nav-title">Dashboard</span>
						</a>
					</li>
					<?php
						if(isset($userrole['record']['permissions']['exal']['view']) && $userrole['record']['permissions']['exal']['view'] === true){
						?>
							<li class="<?php echo $this->uri->segment(2)=='exal'?'selected':''; ?>">
								<a href="<?php echo base_url('admin/exal'); ?>">
									<span class="has-icon">
										<i class="icon-database3"></i>
									</span>
									<span class="nav-title">Excel</span>
								</a>
							</li>
							<?php
						}

						if(isset($userrole['record']['permissions']['category']['view']) && $userrole['record']['permissions']['category']['view'] === true){
						?>
							<li class="<?php echo $this->uri->segment(2)=='category'?'selected':''; ?>">
								<a href="<?php echo base_url('admin/category'); ?>">
									<span class="has-icon">
										<i class="icon-check_circle"></i>
									</span>
									<span class="nav-title">Category</span>
								</a>
							</li>
							<?php
						}
						if(isset($userrole['record']['id']) && $admin['role']==$userrole['record']['id']){
							if(isset($userrole['record']['permissions']['users']['view']) && $userrole['record']['permissions']['users']['view'] === true){
							?>
							<li class="<?php echo $this->uri->segment(2)=='user'?'selected':''; ?>">
								<a href="<?php echo base_url('admin/user'); ?>">
									<span class="has-icon">
										<i class="icon-users"></i>
									</span>
									<span class="nav-title">User Management</span>
								</a>
							</li>
							<?php
						}
						if(isset($userrole['record']['permissions']['cms']['view']) && $userrole['record']['permissions']['cms']['view'] === true){
						?>
							<!-- <li class="<?php echo $this->uri->segment(2)=='cms'?'selected':''; ?>">
								<a href="<?php echo base_url('admin/cms'); ?>">
									<span class="has-icon">
										<i class="icon-text"></i>
									</span>
									<span class="nav-title">CMS</span>
								</a>
							</li> -->
						<?php
						}
                  ?>
                  <?php 
                     if(isset($userrole['record']['permissions']['database_demo']['view']) && $userrole['record']['permissions']['database_demo']['view'] === true){
                     ?>
                        <li class="<?php echo $this->uri->segment(2)=='Database_demo'?'selected':''; ?>">
                           <a href="#" class="has-arrow" aria-expanded="false">
                              <span class="has-icon">
                                 <i class="icon-emoji-happy"></i>
                              </span>
                              <span class="nav-title">Database Demo</span>
                           </a>
                           <ul aria-expanded="false" class="collapse" >
                              <?php
                              if(isset($userrole['record']['permissions']['database_demo']['create']) && $userrole['record']['permissions']['database_demo']['create'] === true){
                              ?>
                                 <li>
                                    <a href="<?php echo base_url('admin/database_demo/create'); ?>">Add Demo User</a>
                                 </li>
                              <?php
                              }if(isset($userrole['record']['permissions']['database_demo']['view']) && $userrole['record']['permissions']['database_demo']['view'] === true){
                              ?>
                                 <li>
                                    <a href="<?php echo base_url('admin/database_demo'); ?>">List Demo USer</a>
                                 </li>
                              <?php
                               }?>
                           </ul>
                        </li>
                     <?php
                     }
                  ?>
                  <?php
                  if((isset($userrole['record']['permissions']['setting']['view']) && $userrole['record']['permissions']['setting']['view'] === true) ||(isset($userrole['record']['permissions']['banid']['view']) && $userrole['record']['permissions']['banid']['view'] === true)){
							?>
							<li class="<?php echo $this->uri->segment(2)=='settings'?'selected':''; ?>">
								<a href="#" class="has-arrow" aria-expanded="false">
									<span class="has-icon">
										<i class="icon-cogs"></i>
									</span>
									<span class="nav-title">General Settings</span>
								</a>
								<ul aria-expanded="false" class="collapse" >
									<?php
									if(isset($userrole['record']['permissions']['setting']['view']) && $userrole['record']['permissions']['setting']['view'] === true){
										?>
									<li>
										<a href="<?php echo base_url('admin/Settings/create'); ?>">Settings</a>
									</li>
									<?php
								}if(isset($userrole['record']['permissions']['banip']['view']) && $userrole['record']['permissions']['banip']['view'] === true){
									?>
									<li>
										<a href="<?php echo base_url('admin/banip'); ?>">BanIP Settings</a>
									</li>
									<?php
								}?>
								</ul>
							</li>
					
							<?php
						}if(isset($userrole['record']['permissions']['role']['view']) && $userrole['record']['permissions']['role']['view'] === true){
							?>
							<li class="<?php echo $this->uri->segment(2)=='RolePermission'?'selected':''; ?>">
								<a href="<?php echo base_url('admin/RolePermission'); ?>">
									<span class="has-icon">
										<i class="icon-user-check"></i>
									</span>
									<span class="nav-title">Role Permission</span>
								</a>
							</li>
							<?php
						}
					if(isset($userrole['record']['permissions']['module']['view']) && $userrole['record']['permissions']['module']['view'] === true){
					?>
					<li class="<?php echo $this->uri->segment(2)=='ModuleSetting'?'selected':''; ?>">
							<a href="<?php echo base_url('admin/ModuleSetting'); ?>">
								<span class="has-icon">
									<i class="icon-cog"></i>
								</span>
								<span class="nav-title">Module Settings</span>
							</a>
					</li>
					<?php
					}
					}?>
					
				</ul>
				<!-- END: side-nav-content -->
			</nav>
			<!-- END: .side-nav -->
		</div>
		<!-- Nav scroll end -->
	</div>
	<!-- END: .side-content -->
</aside>
<!-- END: .app-side -->
<!-- BEGIN .app-main -->
<div class="app-main">