<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->view('admin/layouts/header'); ?>
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
					<div class="page-icon">
						<i class="icon-check_circle"></i>
					</div>
					<div class="page-title">
						<h3>Category</h3>
					</div>
				</div>
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
	             
	            </div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->

	<div class="main-content">
		<form id="Category" action="<?php echo $this->uri->segment(3)==''||$this->uri->segment(3)=='create'||$this->uri->segment(3)=='store'?base_url('admin/category/store'):base_url('admin/category/update/'.$id); ?>" method="post" enctype="multipart/form-data">
			<?php $this->view('admin/validation'); ?>
			<div class="card">
                <div class="card-body">
					<div class="row gutters">
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<input type="text" class="form-control"  id="category" name="name" placeholder="Category name *" value="<?php echo set_value('name',isset($category['record']['name'])?$category['record']['name']:''); ?>" />
							</div>
						</div>
					</div>
					<div class="actions clearfix">
						<button type="submit" class="btn btn-primary" <?php if($userrole['record']['permissions']['setting']['view'] === "1" && $userrole['record']['permissions']['setting']['create'] !== true && $userrole['record']['permissions']['setting']['edit'] !== true && $userrole['record']['permissions']['setting']['delete'] !== true ){ ?>disabled <?php } ?>><span class="icon-save2"></span><?php echo $this->uri->segment(3)=='create'?'Save':'Update'; ?></button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- END: .main-content -->
<?php $this->view('admin/layouts/footer'); ?>

