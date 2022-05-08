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
						<h3><?= $exal_data['record']['title']; ?></h3>
					</div>
				</div>
				<?php
				if($userrole['record']['permissions']['role']['create'] == "1"){
				?>
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
	                <div class="daterange-container ml-2">
	                    <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create" href="<?php echo base_url('admin/exal/create'); ?>"><i class="icon-plus"></i> Add Exal</a>
	                </div>

	                 <div class="daterange-container">
	                    <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create" href="<?php echo base_url('admin/exal'); ?>"><i class="icon-eye"></i> View</a>
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
		<header class="main-heading mb-3">
			<div class="row">
				<?php
				if($admin['role'] !== "3"){
				?>
				
				<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10">
					<form action="<?= base_url('admin/exal/assigntoseller/'.base64_encode($exal_data['record']['id'])) ?>" method="post">
					<div class="daterange-container w-50">
						<select class="form-control select2" required="" name="user_id">
	                		<option value="">Select user</option>
                			<?php
							foreach($seller as $key=>$val){
								if(empty($val['assigned_user_id'])){
								?>			
							<option  value="<?php echo $val['adminuserid'];?>"><?php echo ucfirst($val['username']);?></option>
							<?php
							}
							}?>
	                	</select>
	                </div>
	                <div class="daterange-container w-50">
	                	<select required class=" form-control selectpicker" name="mask_field_name[]" maxlength="7" multiple="" title="Choose attribute for validation" tabindex="-98">
							<option value="name">Name</option>
							<option value="email">Email</option>
							<option value="mobile">Mobile</option>
							<option value="district">District</option>
							<option value="location">Location</option>
							<option value="state">State</option>
							<option value="pincode">Pincode</option>
							<!-- <option value="father_name">FatherName</option> -->
						</select>
	                </div>
				</div>
				<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
					<input type="hidden" name="exal_id" value="<?= $exal_data['record']['id']; ?>">
	                <div class="daterange-container float-left">
	                    <button type="submit" data-toggle="tooltip" class="btn btn-primary btn-sm btn-create"><i class="icon-plus"></i> Assign to seller</button>
	                </div>
	            </div>
	            </form>
	            <?php
	        	}
	            ?>
			</div>
		</header>
		<!-- Row start -->
		<div class="row gutters">
			<?php
				if($admin['role'] !== "3"){
				?>
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<?php $this->view('admin/validation'); ?>
				<div class="card custom-bdr">
					<div class="card-header">
						Assigned user
					</div>
					<div class="card-body table-responsive">
						<table class="table table-bordered table-striped dataTable no-footer">
							<thead>
								<tr>
									<th>Sr No</th>
									<th>Seller name</th>
									<th>Mask fileds</th>
                                    <!-- if($admin['role'] == "1"){ -->
                                    <th>Is assigned</th>
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
                           if($assignedseller){
   									foreach($assignedseller as $key=>$val){
   										?>
   										<tr>
   											<td><?php echo ($key+1); ?></td>
   											<td><?= ucfirst($val['username']) ?></td>
   											<td><?= $val['mask_field_name']; ?> </td>
                                    
                                    <td>
                                       <?php if($val['is_assigned'] == "yes"){
                                          ?>
                                            <button class="btn btn-success btn-xs fa fa-check text-white assigned-action" data-assignid="<?= $val['exal_assign_id']; ?>" > Yes </button>
                                          <?php
                                       }else{
                                          ?>
                                            <button class="btn btn-danger btn-xs fa fa-ban text-white assigned-action" data-assignid="<?= $val['exal_assign_id']; ?>"> No </button>
                                          <?php
                                       } ?>
                                    </td>
                                     
										<?php

										if($userrole['record']['permissions']['exal']['edit'] === true || $userrole['record']['permissions']['exal']['delete'] === true ){
										?>
										<td>
											<?php
											 
											 
											if($userrole['record']['permissions']['exal']['delete'] === true){
												
											?>
											<a data-toggle="tooltip" class="btn btn-danger btn-sm btn-edit" href="<?php echo base_url('admin/exal/exallistassigndestroy/'.base64_encode($val['exal_id']).'/'.base64_encode($val['exal_assign_id'])); ?>" onclick="return confirm('Are you sure?');"><i class="icon-trash2"></i> Delete</a>
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
                           }else{
                              ?>
                              <tr class="text-center">
                                  <td <?php if($userrole['record']['permissions']['exal']['delete'] === true){ echo 'colspan="5"'; }else{  echo 'colspan="4"'; } ?> >Data not available</td>  
                              </tr>
                              <?php
                           }
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
		<div class="row gutters">

			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
			   
				<div class="card custom-bdr">
					<div class="card-header">
						All data list
					</div>
					<div class="card-body table-responsive">
                  <form method="get">
                  <div class="select_location filter-form row  pb-3 pt-3">
                     
                     <div class="col-md-2  ">
                        <select class="select2 form-control state" name="state">
                           <option value="">Select state</option>
                           <?php 
                           $exal_state_list = get_exal_location_by_exal_id($exal_id);
                           foreach ($exal_state_list as $ex_stat_key => $ex_stat_value) {
                              ?>
                              <option value="<?= $ex_stat_value['state']; ?>" <?php if($filter['state'] == $ex_stat_value['state']){ echo 'selected'; }  ?>><?php echo $ex_stat_value['state'];  ?></option>
                              <?php
                           }
                           ?>
                        </select>
                     </div>
                     <div class="col-md-3"  >
                        <select class="select2 form-control city" name="district" <?php if($filter['district'] =="" || $filter['state']  == ""){ echo 'disabled'; }else{ echo 'enabled'; }  ?>>
                           <option value="">Select District</option>
                        </select>
                     </div>
                     <div class="col-md-3">
                        <select class="select2 form-control location" name="location" <?php if($filter['location']   == "" || $filter['state']  == ""){ echo 'disabled'; }else{ echo 'enabled'; }  ?>>
                           <option value="">Select Location</option>
                        </select>
                     </div>
                     <div class="col-md-2">
                        <select class="select2 form-control" name="is_interested">
                           <option value="" >Select option</option>
                           <option value="1" <?php if($filter['is_interested'] == '1'){ echo 'selected'; }  ?>> Intrested </option>
                           <option value="0" <?php if($filter['is_interested'] == '0'){ echo 'selected'; }  ?>> Not Intrested </option>
                        </select>
                     </div>
                     <div class="col-md-2 no-padding">
                         <button type="submit" class="btn btn-success">Filter</button>
                         <a href="<?= base_url('admin/exal/viewdata/'.base64_encode($exal_id)) ?>"><button type="button" class="btn btn-danger">Reset</button></a>
                     </div>
                     
                  </div>
                  </form>
                  <input type="hidden" class="exal_id" name="exal_id" value="<?= $exal_id; ?>">
						<table  class="table table-bordered table-striped dataTable no-footer">
							<thead>
								<tr>
									<th>Sr No</th>
									<th>Name</th>
									<th>Mobile</th>
									<th>Email</th>
									<th>District</th>
									<th>Location</th>
									<th>State</th>
									<th>Pincode</th>
									<th>FatherName</th>
                           <th>Is Intrested</th>
                           <th>Remark</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$mainmaskfield=['name','email','mobile','district','location','state','pincode','father_name'];
                                    if($exal)
                                    {
    									foreach($exal as $key=>$val){

    										if($admin['role'] == "3" || $admin['role'] == "2"){
    										?>
    										<tr>
    											 
    											<td><?php echo ($key+1); ?></td>
    											<?php $namefind = array_search('name', $mask_field_name); if($namefind !==false){ ?>
    											<td><a href="javascript:void(0)"  onclick="removemaskeddata('<?= $admin['role'] ?>','<?= $admin['id'] ?>','<?= $val['exal_id'] ?>','name,is_interested','<?= $val['id']; ?>')"><?= ucfirst($val['name']) ?></a></td>
    											<?php }else{ ?>
    												<td><?= ucfirst($val['name']) ?></td>
    											<?php } ?>

    											<?php $mobilefind = array_search('mobile', $mask_field_name); if($mobilefind !==false){ ?>
    											<td><a href="javascript:void(0)"  onclick="removemaskeddata('<?= $admin['role'] ?>','<?= $admin['id'] ?>','<?= $val['exal_id'] ?>','mobile,is_interested','<?= $val['id']; ?>')"><?= $val['mobile']; ?></a></td>
    											<?php }else{ ?>
    												<td><?= ucfirst($val['mobile']) ?></td>
    											<?php } ?>
    											
    											<?php $emailfind = array_search('email', $mask_field_name); if($emailfind !==false){ ?>
    											<td><a href="javascript:void(0)"  onclick="removemaskeddata('<?= $admin['role'] ?>','<?= $admin['id'] ?>','<?= $val['exal_id'] ?>','email,is_interested','<?= $val['id']; ?>')"><?= $val['email']; ?></a></td>
    											<?php }else{ ?>
    												<td><?= ucfirst($val['email']) ?></td>
    											<?php } ?>

    											<?php $districtfind = array_search('district', $mask_field_name); if($districtfind !==false){ ?>
    											<td><a href="javascript:void(0)"  onclick="removemaskeddata('<?= $admin['role'] ?>','<?= $admin['id'] ?>','<?= $val['exal_id'] ?>','district,is_interested','<?= $val['id']; ?>')"><?= $val['district']; ?></a></td>
    											<?php }else{ ?>
    												<td><?= ucfirst($val['district']) ?></td>
    											<?php } ?>

    											<?php $locationfind = array_search('location', $mask_field_name); if($locationfind !==false){ ?>
    											<td><a href="javascript:void(0)"  onclick="removemaskeddata('<?= $admin['role'] ?>','<?= $admin['id'] ?>','<?= $val['exal_id'] ?>','location,is_interested','<?= $val['id']; ?>')"><?= $val['location']; ?></a></td>
    											<?php }else{ ?>
    												<td><?= ucfirst($val['location']) ?></td>
    											<?php } ?>

    											<?php $statefind = array_search('state', $mask_field_name); if($statefind !==false){ ?>
    											<td><a href="javascript:void(0)"  onclick="removemaskeddata('<?= $admin['role'] ?>','<?= $admin['id'] ?>','<?= $val['exal_id'] ?>','state,is_interested','<?= $val['id']; ?>')"><?= $val['state']; ?></a></td>
    											<?php }else{ ?>
    												<td><?= ucfirst($val['state']) ?></td>
    											<?php } ?>

    											<?php $pincodefind = array_search('pincode', $mask_field_name); if($pincodefind !==false){ ?>
    											<td><a href="javascript:void(0)"  onclick="removemaskeddata('<?= $admin['role'] ?>','<?= $admin['id'] ?>','<?= $val['exal_id'] ?>','pincode,is_interested','<?= $val['id']; ?>')"><?= $val['pincode']; ?></a></td>
    											<?php }else{ ?>
    												<td><?= ucfirst($val['pincode']) ?></td>
    											<?php } ?>

    											<?php $father_namefind = array_search('father_name', $mask_field_name); if($father_namefind !==false){ ?>
    											<td><a href="javascript:void(0)"  onclick="removemaskeddata('<?= $admin['role'] ?>','<?= $admin['id'] ?>','<?= $val['exal_id'] ?>','father_name,is_interested','<?= $val['id']; ?>')"><?= $val['father_name']; ?></a></td>
    											<?php }else{ ?>
    												<td><?= ucfirst($val['father_name']) ?></td>
    											<?php } ?>
                                       <td><?= ($val['is_interested'] == '1')?'<span class="text-success font-weight-bold td-interested" id="exid-'.$val['id'].'">Intrested</span>':'<span class="text-danger font-weight-bold td-interested" id="exid-'.$val['id'].'">Not intrested</span>'; ?></td>
                                       <td><?= $val['remark']; ?></td>
    										</tr>
    										<?php }else{
    										?>
    										<tr>
    											<td><?php echo ($key+1); ?></td>
    											<td><?= ucfirst($val['name']) ?></td>
    											<td><?= $val['mobile']; ?></td>
    											<td><?= $val['email']; ?></td>

    											<td><?= $val['district']; ?></td>
    											<td><?= $val['location']; ?></td>
    											<td><?= $val['state']; ?></td>
    											<td><?= $val['pincode']; ?></td>
    											<td><?= $val['father_name']; ?></td>
    											<td><?= ($val['is_interested'] == '1')?'<span class="text-success font-weight-bold td-interested" id="exid-'.$val['id'].'">Intrested</span>':'<span class="text-danger font-weight-bold td-interested" id="exid-'.$val['id'].'">Not intrested</span>'; ?></td>
                                                <td><?= $val['remark']; ?></td>
    										</tr>
    										<?php
    										} ?>
    										<?php
    									}
                           }else{
                               ?>
                               <tr class="text-center"><td colspan="11">Data not available</td></tr>
                               <?php
                           }
								?>
							</tbody>
						</table>
						<div class="col-md-12 col-xs-12">
   	                <?php echo $datatble['result_count']; ?>
   	                <?php if(!empty($datatble['pagination'])) echo $datatble['pagination']; ?>
   	              </div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- END: .main-content -->
	<!-- modal for mask -->
	<div id="myModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title exaldata"></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                </div>
                <div class="modal-body">
                    <p class="printedname"></p>
                    <b><h4 class="maskdata text-center mt-4 mb-4"></h4></b>
                    <div class="switch-button text-center">
                        <label class="switch">
                           <input type="checkbox" class="intrested-checkbox">
                           <div class="slider round">
                            <!--ADDED HTML -->
                            <span class="on">Intrested</span>
                            <span class="off">Not Intrested</span>
                            <!--END-->
                           </div>
                        </label>
                    </div>
                </div>
               
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
	<!-- -------------- -->
<script type="text/javascript">
  var filter_state = "<?= $filter['state']; ?>";
  var filter_district = "<?= $filter['district']; ?>"; 
  var filter_location = "<?= $filter['location']; ?>"; 

</script>
<?php $this->view('admin/layouts/footer'); ?>
<?php if($admin['role'] == "3" || $admin['role'] == "2"){?>
<script type="text/javascript">
	    var exid_id = null;
		function removemaskeddata(roleid,userid,exal_id,namefield,exid) {
			 exid_id = exid
			$.ajax({
		        "url":"<?= base_url('admin/exal/fetchmaskdata') ?>",
		        "type":'post',
		        "data":{roleid:roleid,userid:userid,exal_id:exal_id,namefield:namefield,exid:exid},
		        'dataType':'json',
		        beforesend:function()
		        {
					$('.printedname').html('');
		        	$('.maskdata').html('');
		        },
		        success: function(data){
		            const re_namefield = namefield.split(",");
		        	var printedname=data.data[re_namefield[0]];
		        	if(data.status != false){
		        		$('.printedname').html(re_namefield[0].toUpperCase());
                        $('.exaldata').html(re_namefield[0].toUpperCase());
		        		$('.maskdata').html(printedname.toUpperCase());
		                $('#myModal').modal('show');
                        $('.intrested-checkbox').attr('id', exid);
                        $('.intrested-checkbox').attr('data-id', exid);

                       const is_intrested = data.data[re_namefield[1]];
		               if(is_intrested == 1)
                       {
                        $('.intrested-checkbox').prop('checked',true);
                       }else{
                        $('.intrested-checkbox').prop('checked',false); 
                       }
                    }else{
		            	alert(data.message);
		        		$('.maskdata').html('');	            	
		            }
		        },
		 	});
			
		}	
	    $('.intrested-checkbox').on('click',function(e){
            if(exid_id !== null)
            {
                $.ajax({
                    "url":baseurl+"/admin/exal/isIntrestedStatusUpdate",
                    "type":'post',
                    "data":{exid:exid_id},
                    'dataType':'json',
                    'async' : true,
                    beforesend:function()
                    {
                       $(this).prop('disabled', true);
                    },
                    success: function(data){
                        $(this).prop('disabled', false);
                        
                        if(data.status == true)
                        {
                            
                            if(data.data == 1)
                            {
                                // console.log('exid',exid);
                                $('#exid-'+exid_id).text('Intrested');
                                $('#exid-'+exid_id).removeClass('text-danger').addClass('text-success');  
                                Message.add(data.message, {vertical:'top',horizontal:'center',type: 'success'});
                            }else{
                                Message.add(data.message, {vertical:'top',horizontal:'center',type: 'error'});
                                $('#exid-'+exid_id).text('Not intrested');
                                $('#exid-'+exid_id).removeClass('text-success').addClass('text-danger');  
                            }
                             
                        } 
                    },
                });

            } 
        });     
</script>
<?php } ?>
<script src="<?php echo asset_url(); ?>admin/js/pages/rolepermission-list.js"></script>