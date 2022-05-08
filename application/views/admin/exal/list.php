<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->view('admin/layouts/header'); ?>
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
					<div class="page-icon">
						<i class="icon-database3"></i>
					</div>
					<div class="page-title">
						<h3>Excel</h3>
					</div>
				</div>
				<?php
				if($userrole['record']['permissions']['exal']['create'] == "1"){
				?>
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
	                <div class="daterange-container">
	                    <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create" href="<?php echo base_url('admin/exal/create'); ?>"><i class="icon-plus"></i> Add Excel</a>
	                </div>
	            </div>
	            <?php
	        }
	            ?>
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
						<table id="datatable" class="table table-bordered table-striped dataTable no-footer">
							<thead>
								<tr>
									<th>Sr No</th>
									<th>Category</th>
									<th>Title</th>
									<th>File</th>
									<?php if($admin['role'] !=='2' && $admin['role'] !=='3'){ ?>
									<th>Download</th>
									<?php } ?>
									<th>Size</th>
									<th>Data</th>
									<th>Date</th>
									<?php
											
										if($userrole['record']['permissions']['exal']['edit'] == "1" || $userrole['record']['permissions']['exal']['delete'] == "1"  ){
											?>
							        <th>Action</th>
							        <?php
							    }
							    ?>
									
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($exal['records'] as $key=>$val){
										?>
										<tr>
											<td><?php echo ($key+1); ?></td>
											<td><?= getcategoryname($val['category_id']) ?></td>
											<td>
												<?php
													echo ucfirst($val['title']);
												?>
											</td>
											<td>
												<a href="<?= base_url('admin/exal/viewdata/'.base64_encode($val['id'])) ?>" title="view all data"><i class="icon-folder4 "></i></a>
												
											</td>
											<?php if($admin['role'] !=='2' && $admin['role'] !=='3'){ ?>
											<td>
												<a download href="<?= base_url($val['file_path']) ?>"><i class="icon-folder-download "></i></a>
											</td>
											<?php } ?>
											<td><?= $val['file_size']; ?></td>
											<td><?= $val['no_row']; ?></td>

											<td><?= $val['created_at']; ?></td>
											<?php

										if($userrole['record']['permissions']['exal']['edit'] === true || $userrole['record']['permissions']['exal']['delete'] === true ){
											?>
											<td>
												<?php
												 
												 
												if($userrole['record']['permissions']['exal']['delete'] === true){
													
												?>
												<a data-toggle="tooltip" class="btn btn-danger btn-sm btn-edit" onclick="return confirm('Are you sure?');" href="<?php echo base_url('admin/exal/destroy/'.$val['id']); ?>" ><i class="icon-trash2"></i> Delete</a>
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
<script src="<?php echo asset_url(); ?>admin/js/pages/rolepermission-list.js"></script>