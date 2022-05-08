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
                  <h3>Create Demo Database</h3>
               </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
               <?php
                  if($userrole['record']['permissions']['database_demo']['view'] == "1"){
                  ?>
                   
                   <div class="daterange-container">
                       <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create" href="<?php echo base_url('admin/database_demo'); ?>"><i class="icon-view_list"></i> List</a>
                   </div>
                      
                  <?php
                 }
               ?>
            </div>
         </div>
      </div>
   </header>
   <!-- END: .main-heading -->
   <!-- BEGIN .main-content -->
   <div class="main-content">
      <form id="Category" action="<?= $this->uri->segment(3)==''|| $this->uri->segment(3)=='create'|| $this->uri->segment(3)=='store'?base_url('admin/database_demo/store'):base_url('admin/database_demo/update/'.$id); ?>" method="post" enctype="multipart/form-data">
         <?php $this->view('admin/validation'); ?>
         <div class="card">
                <div class="card-body">
               <div class="row gutters">
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                     <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Enter Name" name="name" required value="<?php echo set_value('name');?>">
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                     <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" placeholder="Enter email" name="email" required value="<?php echo set_value('email');?>">
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                     <div class="form-group">
                        <label>Mobile <span class="text-danger">*</span></label>
                        <input type="number" maxlength="12" minlength="10" min="0" class="form-control" placeholder="Enter mobile" name="mobile" required value="<?php echo set_value('mobile');?>">
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                     <div class="form-group">
                        <label>Remark</label>
                        <textarea class="form-control" name="remark" placeholder="Enter remark"><?php echo set_value('remark');?></textarea>
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                     <div class="form-group">
                        <label>Select exal <span class="text-danger">*</span></label>
                        <select class="form-control select2" name="exal_id" required >
                           <option value="">Select exal</option>
                           <?php
                           foreach($exal['records'] as $exvalues){ 
                           ?>
                              <option value="<?php echo $exvalues['id']; ?>" <?= (set_value('exal_id') == $exvalues['id'])?'selected':''; ?>><?php echo ucfirst($exvalues['title']);?></option>
                           <?php
                           }
                           ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                     <div class="form-group">
                        <label>Check no. of data <span class="text-danger">*</span></label>
                        <input type="number" min="1" name="check_no_of_data" class="form-control" required placeholder="Check no. of data" value="<?php echo set_value('check_no_of_data');?>">
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                     <div class="form-group">
                        <label>Link expire duration <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="link_expire_duration" class="form-control" required placeholder="Link expire duration" value="<?php echo set_value('link_expire_duration');?>">
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                     <div class="form-group">
                        <label>Otp Type <span class="text-danger">*</span></label>
                        <select name="otp_type" required class="form-control" placeholder="Otp type">
                           <option value="email" <?= (set_value('otp_type') == 'email')?'selected':''; ?>>Email</option>
                           <option value="mobile_sms" <?= (set_value('otp_type') == 'mobile_sms')?'selected':''; ?>>Phone message</option>
                           <option value="both" <?= (set_value('otp_type') == 'both')?'selected':''; ?>>Both</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="actions clearfix">
                  <button type="submit" class="btn btn-primary" <?php if($userrole['record']['permissions']['database_demo']['view'] === "1" && $userrole['record']['permissions']['database_demo']['create'] !== true && $userrole['record']['permissions']['database_demo']['edit'] !== true && $userrole['record']['permissions']['database_demo']['delete'] !== true ){ ?>disabled <?php } ?>><span class="icon-save2"></span><?php echo $this->uri->segment(3)=='create'?'Save':'Update'; ?></button>
               </div>
            </div>
         </div>
      </form>
   </div>
   <!-- END: .main-content -->
<?php $this->view('admin/layouts/footer'); ?>

