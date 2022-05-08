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
		<form id="SignUp" action="<?php echo base_url('admin/user/importCSV'); ?>" method="post" enctype="multipart/form-data">
			<?php $this->view('admin/validation'); ?>
			<div class="card">
                <div class="card-body">
					<div class="row gutters">
						<div class="col-md-6">
							<div class="form-group">	
                                <label for="name" >Import File</label>
                            <div class="custom-file">
                                <input class="form-control custom-file-input" id="image" name="csv_file" type="file">
                                <label for="image" class="custom-file-label custom-file-label-primary">Choose file</label>
                            </div>
                        </div>
                    </div>
						
					</div>
					<div class="actions clearfix">
						<button type="submit" class="btn btn-primary" ><span class="icon-printer"></span> <?php echo 'Import file'; ?></button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- END: .main-content -->
<?php $this->view('admin/layouts/footer'); ?>
