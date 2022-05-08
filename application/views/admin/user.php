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
	                    <a data-toggle="tooltip" title="Create" class="btn btn-primary btn-sm btn-create" href="<?php echo base_url('admin/user/create'); ?>"><i class="icon-pencil"></i> Create</a>
	                </div>
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
				<div class="card custom-bdr">
					<div class="card-body">
						<table id="datatable" class="table table-bordered">
							<thead>
								<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Birth Date</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($users['records'] as $key=>$val){
										?>
										<tr>
											<td><?php echo $val['firstname'].' '.$val['lastname']; ?></td>
											<td><?php echo $val['email']; ?></td>
											<td><?php echo $val['birthdate']; ?></td>
											<td>
												<?php
													echo $val['status'];
												?>
											</td>
											<td>
												
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
	</div>
	<!-- END: .main-content -->
<?php $this->view('admin/layouts/footer'); ?>
<script src="<?php echo asset_url(); ?>admin/js/pages/user.js"></script>