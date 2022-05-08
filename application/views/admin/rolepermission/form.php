<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->view('admin/layouts/header'); ?>
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
					<div class="page-icon">
						<i class="icon-user-check"></i>
					</div>
					<div class="page-title">
						<h3>Role Permission</h3>
					</div>
				</div>
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
	                <div class="daterange-container">
	                    <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create" href="<?php echo base_url('admin/RolePermission'); ?>"><i class="icon-eye"></i> View</a>
	                </div>
	            </div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<form id="SignUp" action="<?php echo $this->uri->segment(3)=='create'||$this->uri->segment(3)=='store'?base_url('admin/RolePermission/store'):base_url('admin/RolePermission/update/'.$id); ?>" method="post" enctype="multipart/form-data">
			<?php $this->view('admin/validation'); ?>
			<div class="card">
                <div class="card-body">
					<div class="row gutters">
						<div class="col-xl-6">
							<div class="form-group">
								<input type="text" class="form-control" id="name" name="name" placeholder="Name *" value="<?php echo set_value('name',isset($rolepermission['record']['name'])?$rolepermission['record']['name']:''); ?>" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xl-12">
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th>Module</th>
										<th>View</th>
										<th>Create</th>
										<th>Edit</th>
										<th>Delete</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><label><input type="checkbox" class="chkrow" id="exal" value="true" /> Exal</label></td>
										<td><input type="checkbox" class="chkcol view" name="permissions[exal][view]" value="true" <?php echo (isset($rolepermission['record']['permissions']['exal']['view']) && $rolepermission['record']['permissions']['exal']['view']===true) || set_value('permissions[exal][view]') ?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[exal][create]" value="true" <?php echo (isset($rolepermission['record']['permissions']['exal']['create']) && $rolepermission['record']['permissions']['exal']['create']===true)  || set_value('permissions[exal][create]')?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[exal][edit]" value="true" <?php echo (isset($rolepermission['record']['permissions']['exal']['edit']) && $rolepermission['record']['permissions']['exal']['edit']===true)  || set_value('permissions[exal][edit]')?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[exal][delete]" value="true" <?php echo (isset($rolepermission['record']['permissions']['exal']['delete']) && $rolepermission['record']['permissions']['exal']['delete']===true)  || set_value('permissions[exal][delete]')?'checked="checked"':''; ?> /></td>
									</tr>
                           <tr>
                              <td><label><input type="checkbox" class="chkrow" id="database_demo" value="true" /> Database Demo</label></td>
                              <td><input type="checkbox" class="chkcol view" name="permissions[database_demo][view]" value="true" <?php echo (isset($rolepermission['record']['permissions']['database_demo']['view']) && $rolepermission['record']['permissions']['database_demo']['view']===true) || set_value('permissions[database_demo][view]') ?'checked="checked"':''; ?> /></td>
                              <td><input type="checkbox" class="chkcol" name="permissions[database_demo][create]" value="true" <?php echo (isset($rolepermission['record']['permissions']['database_demo']['create']) && $rolepermission['record']['permissions']['database_demo']['create']===true)  || set_value('permissions[database_demo][create]')?'checked="checked"':''; ?> /></td>
                              <td><input type="checkbox" class="chkcol" name="permissions[database_demo][edit]" value="true" <?php echo (isset($rolepermission['record']['permissions']['database_demo']['edit']) && $rolepermission['record']['permissions']['database_demo']['edit']===true)  || set_value('permissions[database_demo][edit]')?'checked="checked"':''; ?> /></td>
                              <td><input type="checkbox" class="chkcol" name="permissions[database_demo][delete]" value="true" <?php echo (isset($rolepermission['record']['permissions']['database_demo']['delete']) && $rolepermission['record']['permissions']['database_demo']['delete']===true)  || set_value('permissions[database_demo][delete]')?'checked="checked"':''; ?> /></td>
                           </tr>
									<tr>
										<td><label><input type="checkbox" class="chkrow" id="category" value="true" /> category</label></td>
										<td><input type="checkbox" class="chkcol view" name="permissions[category][view]" value="true" <?php echo (isset($rolepermission['record']['permissions']['category']['view']) && $rolepermission['record']['permissions']['category']['view']===true) || set_value('permissions[category][view]') ?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[category][create]" value="true" <?php echo (isset($rolepermission['record']['permissions']['category']['create']) && $rolepermission['record']['permissions']['category']['create']===true)  || set_value('permissions[category][create]')?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[category][edit]" value="true" <?php echo (isset($rolepermission['record']['permissions']['category']['edit']) && $rolepermission['record']['permissions']['category']['edit']===true)  || set_value('permissions[category][edit]')?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[category][delete]" value="true" <?php echo (isset($rolepermission['record']['permissions']['category']['delete']) && $rolepermission['record']['permissions']['category']['delete']===true)  || set_value('permissions[category][delete]')?'checked="checked"':''; ?> /></td>
									</tr>
									<!--  -->
									<tr>
										
										<td><label><input type="checkbox" class="chkrow" id="users" value="true" /> Users</label></td>
										<td><input type="checkbox" class="chkcol view" name="permissions[users][view]" value="true" <?php echo (isset($rolepermission['record']['permissions']['users']['view']) && $rolepermission['record']['permissions']['users']['view']===true) || set_value('permissions[users][view]') ?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[users][create]" value="true" <?php echo (isset($rolepermission['record']['permissions']['users']['create']) && $rolepermission['record']['permissions']['users']['create']===true)  || set_value('permissions[users][create]')?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[users][edit]" value="true" <?php echo (isset($rolepermission['record']['permissions']['users']['edit']) && $rolepermission['record']['permissions']['users']['edit']===true)  || set_value('permissions[users][edit]')?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[users][delete]" value="true" <?php echo (isset($rolepermission['record']['permissions']['users']['delete']) && $rolepermission['record']['permissions']['users']['delete']===true)  || set_value('permissions[users][delete]')?'checked="checked"':''; ?> /></td>
									</tr>
									<!-- <tr>
										<td><label><input type="checkbox" class="chkrow" id="cms" value="true" /> CMS</label></td>
										<td><input type="checkbox" class="chkcol view" name="permissions[cms][view]" value="true" <?php echo (isset($rolepermission['record']['permissions']['cms']['view']) && $rolepermission['record']['permissions']['cms']['view']===true) || set_value('permissions[cms][view]') ?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[cms][create]" value="true" <?php echo (isset($rolepermission['record']['permissions']['cms']['create']) && $rolepermission['record']['permissions']['cms']['create']===true)  || set_value('permissions[cms][create]')?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[cms][edit]" value="true" <?php echo (isset($rolepermission['record']['permissions']['cms']['edit']) && $rolepermission['record']['permissions']['cms']['edit']===true)  || set_value('permissions[cms][edit]')?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[cms][delete]" value="true" <?php echo (isset($rolepermission['record']['permissions']['cms']['delete']) && $rolepermission['record']['permissions']['cms']['delete']===true)  || set_value('permissions[cms][delete]')?'checked="checked"':''; ?> /></td>
									</tr> -->
									<tr>
										<td><label><input type="checkbox" class="chkrow" id="setting" value="true" /> General Settings</label></td>
										<td><input type="checkbox" class="chkcol view" name="permissions[setting][view]" value="true" <?php echo (isset($rolepermission['record']['permissions']['setting']['view']) && $rolepermission['record']['permissions']['setting']['view']===true) || set_value('permissions[setting][view]') ?'checked="checked"':''; ?> /></td>
										<td></td>
										<td><input type="checkbox" class="chkcol" name="permissions[setting][edit]" value="true" <?php echo (isset($rolepermission['record']['permissions']['setting']['edit']) && $rolepermission['record']['permissions']['setting']['edit']===true)  || set_value('permissions[setting][edit]')?'checked="checked"':''; ?> /></td>
										<td></td>
									</tr>
									<tr>
										<td><label><input type="checkbox" class="chkrow" id="role" value="true" /> Role Permission</label></td>
										<td><input type="checkbox" class="chkcol view" name="permissions[role][view]" value="true" <?php echo (isset($rolepermission['record']['permissions']['role']['view']) && $rolepermission['record']['permissions']['role']['view']===true) || set_value('permissions[role][view]') ?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[role][create]" value="true" <?php echo (isset($rolepermission['record']['permissions']['role']['create']) && $rolepermission['record']['permissions']['role']['create']===true)  || set_value('permissions[role][create]')?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[role][edit]" value="true" <?php echo (isset($rolepermission['record']['permissions']['role']['edit']) && $rolepermission['record']['permissions']['role']['edit']===true)  || set_value('permissions[role][edit]')?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[role][delete]" value="true" <?php echo (isset($rolepermission['record']['permissions']['role']['delete']) && $rolepermission['record']['permissions']['role']['delete']===true)  || set_value('permissions[role][delete]')?'checked="checked"':''; ?> /></td>
									</tr>
									<tr>
										<td><label><input type="checkbox" class="chkrow" id="banip" value="true" /> Ban ID</label></td>
										<td><input type="checkbox" class="chkcol view" name="permissions[banip][view]" value="true" <?php echo (isset($rolepermission['record']['permissions']['banip']['view']) && $rolepermission['record']['permissions']['banip']['view']===true) || set_value('permissions[banip][view]') ?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[banip][create]" value="true" <?php echo (isset($rolepermission['record']['permissions']['banip']['create']) && $rolepermission['record']['permissions']['banip']['create']===true)  || set_value('permissions[banip][create]')?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[banip][edit]" value="true" <?php echo (isset($rolepermission['record']['permissions']['banip']['edit']) && $rolepermission['record']['permissions']['banip']['edit']===true)  || set_value('permissions[banip][edit]')?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[banip][delete]" value="true" <?php echo (isset($rolepermission['record']['permissions']['banip']['delete']) && $rolepermission['record']['permissions']['banip']['delete']===true)  || set_value('permissions[banip][delete]')?'checked="checked"':''; ?> /></td>
									</tr>
									<tr>
										<td><label><input type="checkbox" class="chkrow" id="module" value="true" />Module Settings</label></td>
										<td><input type="checkbox" class="chkcol view" name="permissions[module][view]" value="true" <?php echo (isset($rolepermission['record']['permissions']['module']['view']) && $rolepermission['record']['permissions']['module']['view']===true) || set_value('permissions[module][view]') ?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[module][create]" value="true" <?php echo (isset($rolepermission['record']['permissions']['module']['create']) && $rolepermission['record']['permissions']['module']['create']===true)  || set_value('permissions[module][create]')?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[module][edit]" value="true" <?php echo (isset($rolepermission['record']['permissions']['module']['edit']) && $rolepermission['record']['permissions']['module']['edit']===true)  || set_value('permissions[module][edit]')?'checked="checked"':''; ?> /></td>
										<td><input type="checkbox" class="chkcol" name="permissions[module][delete]" value="true" <?php echo (isset($rolepermission['record']['permissions']['module']['delete']) && $rolepermission['record']['permissions']['module']['delete']===true)  || set_value('permissions[module][delete]')?'checked="checked"':''; ?> /></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="actions clearfix">
						<button type="submit" id="rolepermission_submit" class="btn btn-primary"><span class="icon-save2"></span> <?php echo $this->uri->segment(3)=='create'?'Save':'Update'; ?></button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- END: .main-content -->
<?php $this->view('admin/layouts/footer'); ?>
