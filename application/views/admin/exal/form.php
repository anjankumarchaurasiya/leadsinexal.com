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
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
	                <div class="daterange-container">
	                    <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create" href="<?php echo base_url('admin/exal'); ?>"><i class="icon-eye"></i> View</a>
	                </div>
	            </div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<form id="Exal" action="<?php echo base_url('admin/exal/store'); ?>" method="post" enctype="multipart/form-data">
			<?php $this->view('admin/validation'); ?>
			<div class="card">
                <div class="card-body">
					<div class="row gutters">
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<label>Title</label>
								<input type="text" class="form-control"  required="" id="title" name="title" placeholder="Excel title *" value="<?php echo set_value('title',isset($exal['record']['title'])?$exal['record']['title']:''); ?>" />
							</div>
						</div>
                    	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<label>Select category</label>
								<select class="form-control" required="" name="category_id">
									<option value="">Select Category</option>
									<?php
									foreach ($category['records'] as $skey => $svalue) {
									?>
									<option <?= (set_value($val['category_id'])==$svalue['id'] || ($user['record']['category_id'])==$svalue['id'])?'selected':'' ?> value="<?= $svalue['id']; ?>"><?= ucfirst($svalue['name']) ?></option>
									<?php
									}
									 ?>
								</select>
							</div>
						</div>	
						<div class="col-md-6">
							<div class="form-group">	
	                            <label for="name" >Import File</label>
	                            <div class="custom-file">
	                                <input required class="form-control custom-file-input" id="image" name="file_path" type="file" accept=".xls,.xlsx">
	                                <label for="image" class="custom-file-label custom-file-label-primary">Choose file</label>
	                            </div>
                        	</div>
                    	</div>
					</div>
					<p class="text-danger">Note - Required field of excel</p>
					<ul>
						<li class="text-info">Name, Email, Mobile, District, Location, State, Pincode, Father name ( <a class="text-success" href="<?= base_url('assets/images/ExalFormat.xlsx') ?>" download>Download Sample</a> )</li>

					</ul>
					</br>
					<div class="actions clearfix">
						<button type="submit" class="btn btn-primary" ><span class="icon-printer"></span> <?php echo 'Import file'; ?></button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- END: .main-content -->
<?php $this->view('admin/layouts/footer'); ?>
