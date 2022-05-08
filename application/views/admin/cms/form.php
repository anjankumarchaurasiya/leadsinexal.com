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
						<h3>CMS</h3>
					</div>
				</div>
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
	                <div class="daterange-container">
	                    <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create" href="<?php echo base_url('admin/cms'); ?>"><i class="icon-eye"></i> View</a>
	                </div>
	            </div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<form id="SignUp" action="<?php echo $this->uri->segment(3)=='create'||$this->uri->segment(3)=='store'?base_url('admin/cms/store'):base_url('admin/cms/update/'.$id); ?>" method="post" enctype="multipart/form-data">
			<?php $this->view('admin/validation'); ?>
			<div class="card">
                <div class="card-body">
					<div class="row gutters">
						<div class="col-xl-12">
							<div class="form-group">
								<input type="text" class="form-control" id="title" name="title" placeholder="Title *" value="<?php echo set_value('title',isset($user['record']['title'])?$user['record']['title']:''); ?>" />
							</div>
							<textarea class="summernote" name="content" >
							<?php echo set_value('content',isset($user['record']['content'])?$user['record']['content']:''); ?>
							</textarea>
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