<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->view('admin/layouts/header'); ?>
	<!-- BEGIN .main-heading -->

	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
					<div class="page-icon">
						<i class="icon-text"></i>
					</div>
					<div class="page-title">
						<h3>Ban Ip</h3>
					</div>
				</div>
				<?php
				if($userrole['record']['permissions']['banip']['create'] == "1"){
					
	            ?>
	            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
	                <div class="daterange-container">
	                    <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create" href="<?php echo base_url('admin/banip/create'); ?>"><i class="icon-plus"></i> Add Ban IP</a>
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
						<?php
					if($userrole['record']['permissions']['banip']['delete'] === true){
		
									?>
										<a data-toggle="tooltip"  class="btn btn-danger btn-sm btn-edit pull-right" id="deletevalue" ><i class="icon-trash2"></i> Delete</a>
										<?php
									}
									?>
						<table id="datatable" class="table table-bordered">
							<thead>
								<tr>
									<?php if($userrole['record']['permissions']['banip']['delete'] === true){ ?>
									<th><div class="custom-control custom-checkbox">
											<input class="custom-control-input"  type="checkbox" id="checkalluser">
											<label class="custom-control-label banipcheckbox" for="checkalluser"></label>
										</div></th>
										<?php } ?>
									<th>IP</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($users['records'] as $key=>$val){
										?>
										<tr>
											<?php if($userrole['record']['permissions']['banip']['delete'] === true){ ?>
											<td><div class="custom-control custom-checkbox">
											<input class="custom-control-input values banipvalues"  name="cmsselect[]" value="<?php echo $val['id'];?>" type="checkbox" id="<?php echo 'checkbox'.$val['id'];?>">
											<label class="custom-control-label baniplable " for="<?php echo 'checkbox'.$val['id'];?>"></label>
										</div>
												</td>
											<?php } ?>

											<td class="banip" id="<?php echo 'ipaddress';?>"><a href="#" id="ipaddress" data-type="text" data-pk="<?php echo $val['id'];?>" data-url="<?php echo base_url('admin/banip/edit/'.$val['id']); ?>" data-title="IP"></a><?php echo $val['IP'];?></a></td>
									
											<td>
												<?php
												if($userrole['record']['permissions']['cms']['edit'] == "1"){
												?>
												<a data-toggle="tooltip" class="btn btn-primary btn-sm btn-edit" href="<?php echo base_url('admin/banip/edit/'.$val['id']); ?>"><i class="icon-pencil"></i> Edit</a>
												<?php
												}
												?>
												
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
<input type="hidden" id="updateurl" value="<?php echo base_url('admin/banip/update/'); ?>"/>
<input type="hidden" id="destroy" value="<?php echo base_url('admin/banip/destroy')?>"/>
<script src="<?php echo asset_url(); ?>admin/js/pages/banip-list.js"></script>
