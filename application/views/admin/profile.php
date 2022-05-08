<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->view('admin/layouts/header'); ?>
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
					<div class="page-icon">
						<i class="icon-user"></i>
					</div>
					<div class="page-title">
						<h3>Profile</h3>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<form id="SignUp" action="<?php echo base_url('admin/admin/update'); ?>" method="post" enctype="multipart/form-data">
			<div class="validation"> 
			
        	</div>
			<?php $this->view('admin/validation'); ?>
			<div class="card">
                <div class="card-body">
					<div class="row gutters">
						<?php
							if($admin['image']!=''){
								?>
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<!-- Gallery start -->
										<div class="baguetteBoxThree gallery">
											<!-- Row start -->
											<div class="row gutters">
												<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
													<?php
														if($admin['image_flag']=='0'){
															?>
															<a href="<?php echo base_url(); ?>uploads/admins/<?php echo $admin['image']; ?>" class="effects">
																<img src="<?php echo base_url(); ?>uploads/admins/<?php echo $admin['image']; ?>" class="img-responsive">
																<div class="overlay">
																	<span class="expand">+</span>
																</div>
															</a>
															<?php
															}
															else{
																?>
																<a href="<?php echo $admin['image']; ?>" class="effects">
																<img src="<?php echo $admin['image']; ?>" class="img-responsive">
																<div class="overlay">
																	<span class="expand">+</span>
																</div>
															</a>
																<?php
															}
														?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php
							}
						?>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name *" value="<?php echo set_value('firstname',isset($admin['firstname'])?$admin['firstname']:''); ?>" />
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name *" value="<?php echo set_value('lastname',isset($admin['lastname'])?$admin['lastname']:''); ?>" />
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<input type="text" class="form-control" id="username" name="username" placeholder="Username *" value="<?php echo set_value('username',isset($admin['username'])?$admin['username']:''); ?>" />
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<input type="email" class="form-control" id="email" name="email" placeholder="Email Address *" value="<?php echo set_value('email',isset($admin['email'])?$admin['email']:''); ?>" readonly="true" />
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<input type="text" class="form-control datepicker" id="birthdate" name="birthdate" placeholder="Birth Date" value="<?php echo set_value('birthdate',isset($admin['birthdate'])?$admin['birthdate']:''); ?>" readonly="true" />
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="image" name="image" />
								<label class="custom-file-label custom-file-label-primary" for="image">Choose file</label>
							</div>
						</div>
					</div>
					<div id="formmodel">
					</div>
					<div class="actions clearfix">
						<button type="submit" class="btn btn-primary"><span class="icon-save2"></span> <?php echo $this->uri->segment(3)=='create'?'Save':'Update'; ?></button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- END: .main-content -->
<?php $this->view('admin/layouts/footer'); ?>
<script>
$(document).ready(function() {
	$(".validation").hide();
	$("#SignUp").on('submit',function(e) {
        //prevent Default functionality
        e.preventDefault();

        //get the action-url of the form
        var actionurl = e.currentTarget.action;
        //do your own request an handle the results
        $.ajax({
                url: actionurl,
                type: 'post',
                data: $("#SignUp").serialize(),
                success: function(data) {
                var d = JSON.parse(data);
                if(d.status === false){
					$(".validation").show();
					var html = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" id="cross">×</span></button><i class="icon-warning2"></i><strong>Oh snap!</strong><ul></ul></div>';
					$(".validation").html(html);
					$(".validation").find("ul").html(d.validation);
				}else{
					 window.location = "<?php echo base_url('admin/user');?>";
				}
                }
        });
	
    });

	$("#cross").on('click',function(){
		$(".validation").hide();
	})
		var id = <?php echo $this->session->userdata('admin_id');?>;
		var url = "<?php echo base_url('admin/ModuleSetting/editattribute/')?>"+id;

	$.ajax({

        "url": url,
        success: function(data){
        		if(data != "false"){
                $("#formmodel").html(data);
            	}
            },
      
 	});  
  

});
</script>