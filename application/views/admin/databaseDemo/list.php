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
                  <h3>Database Demo</h3>
               </div>
            </div>
            <?php
            if($userrole['record']['permissions']['database_demo']['create'] == "1"){
            ?>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                   <div class="daterange-container">
                       <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create" href="<?php echo base_url('admin/database_demo/create'); ?>"><i class="icon-plus"></i> Create</a>
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
                  <table id="datatable" class="table table-bordered">
                     <thead>
                        <tr>
                           <th>Sr No</th>
                           <th width="100px">Username</th>
                           <th>Exal</th>
                           <th>Allow</th>
                           <th>Expiry</th>
                           <th>Otp</th>        
                           <th>Checked</th>
                           <th>Created at</th>
                           <?php
                                 
                           if($userrole['record']['permissions']['database_demo']['delete'] == "1"  ){
                           ?>
                             <th>Action</th>
                             <?php
                           }
                           ?>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach ($demodb['records'] as $key => $value) {
                           ?>
                           <tr>
                              <td><?= $key+1 ?></td>
                              <td><?= checksellername($value['user_id']); ?></td>
                              <td><?= exalname($value['exal_id']); ?>
                                 </br><?php   echo '<a class="text-info" target="_blank" href="'.$value['demourl'].'">demo link</a>'; ?>
                              </td>
                              <td><?= $value['show_no_of_data'] ?></td>
                              <td><?= date('d.m.Y H:i A',$value['link_expire_duration']); ?>
                                 </br>
                                 <?php
                                 
                                 if(strtotime("now") < $value['link_expire_duration']){
                                    echo "<button class=' btn-sucess btn-xs bg-success text-white'>Active</button>";
                                 }else{
                                    echo "<button class=' btn-danger btn-xs bg-danger text-white'>Expired</button>";
                                 }

                                 ?>        
                              </td>
                              <td><?= $value['otp_type'] ?></td>
                              <td><?= $value['checked_data'] ?></td>
                              <td><?= $value['created_at'] ?></td>
                              <?php
                                 
                              if($userrole['record']['permissions']['database_demo']['delete'] == "1"  ){
                              ?>
                                <td><a href="<?= base_url('admin/database_demo/destroy/'.base64_encode($value['id'])) ?>"><button class="btn btn-danger fa fa-trash"></button></a></td>
                                <?php
                              }
                              ?>
                              
                           </tr>
                           <?php
                        } ?>
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