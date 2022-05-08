<div class="row gutters attribute">
			<?php 
			if(isset($page['record']))
			{

			foreach($page['record'] as $key=>$val){
				
				?>
				<?php if(strtolower($val['type']) == 'radio(select one)'){
					$val['type'] = explode("(", $val['type']);
					$valueofattribute = json_decode($val['data'],true);
					?>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
					<?php
					foreach($valueofattribute['attributevalue'] as $key=>$value){?>
						<div class="custom-control custom-radio custom-control-inline">
						<input type="<?php echo $val['type']['0']?>" id="<?php echo $val['slug'].'['.$key.']';?>" class="custom-control-input"  name="<?php echo $val['slug'];?>"  value="<?php echo $value ?>" <?php echo (isset($user['record']['module'][$val['slug']]) && $value == $user['record']['module'][$val['slug']]) || set_select( $val['slug'],$val) ?'checked':''; ?> />
						<label class="custom-control-label" for="<?php echo $val['slug'].'['.$key.']';?>" ><?php echo ucfirst($value)?></label>
						</div>
						<?php
					}?>
					</div>
					<?}elseif(strtolower($val['type']) == 'checkbox(multiple select)'){
						$val['type'] = explode("(", $val['type']);
					$valueofattribute = json_decode($val['data'],true);?>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<?php
					foreach($valueofattribute['attributevalue'] as $key=>$value){?>
						<?php
						if(isset($user['record']['module'][$val['slug']]))
						if(!is_array($user['record']['module'][$val['slug']])){
							$ar[0] = $user['record']['module'][$val['slug']];
						}
						else{
							$ar = $user['record']['module'][$val['slug']];
						}
						?>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input class="custom-control-input" type="<?php echo $val['type']['0']?>" id="<?php echo $val['slug'].'['.$key.']'?>" name="<?php echo $val['slug'];?>[]" value="<?php echo $value ?>" <?php echo (isset($user['record']['module'][$val['slug']]) && in_array($value, $ar))|| set_select( $val['slug'],$val) ?'checked':''; ?>/>
							<label class="custom-control-label" for="<?php echo $val['slug'].'['.$key.']'?>"><?php echo $value?></label>
				
						</div>
						<?php
					}?>
					</div>
					<?}elseif(strtolower($val['type']) == 'select(dropdown)'){
					?>
					<?php 
						$valueofattribute = json_decode($val['data'],true);
						?>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
					<div class="form-group">
							<select class="form-control" name="<?php echo $val['slug'];?>" id="<?php echo $val['name'	];?>" >
								<option value=" ">Choose Type:</option>
								<?php
								foreach($valueofattribute['attributevalue'] as $key=>$value){
									?>
								<option <?php echo (isset($user['record']['module'][$val['slug']]) && $value == $user['record']['module'][$val['slug']]) || set_select( $val['slug'],$val) ?'selected':''; ?> value="<?php echo $value;?>"><?php echo $value;?></option>
								<?php
							}?>
							</select>
					</div>
				</div>
					<?php
				
				}elseif(strtolower($val['type']) == 'textarea(long field)'){
					?>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
					<div class="form-group">
					<textarea class="form-control" placeholder="<?php echo ucfirst($val['name'])?>" name="<?php echo $val['slug']?>" role="textbox" aria-multiline="true"><?php echo set_value($val['slug'],isset($user['record']['module'][$val['slug']])?$user['record']['module'][$val['slug']]:''); ?></textarea>
					</div>
					</div>
					<?php
				}elseif(strtolower($val['type']) == 'file'){
					
				}else{
					$val['type'] = explode("(", $val['type']);
					if(isset($user['record']['module'][$val['slug']])){
					if(is_array($user['record']['module'][$val['slug']])){
							$ar = $user['record']['module'][$val['slug']][0];
						}
						else{
							$ar = $user['record']['module'][$val['slug']];
						}
					}
					?>
				
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
					<div class="form-group">
					<input type="<?php echo $val['type']['0']?>" class="form-control" id="<?php echo $val['slug'];?>" name="<?php echo $val['slug'];?>" placeholder="<?php echo ucfirst($val['name']);?> *" value="<?php echo set_value($val['slug'],isset($user['record']['module'][$val['slug']])?$ar:''); ?>" />	
					</div>
				</div>
					<?php
					
				}
			}
			}
			?>
			<?php if($role_id==3){
			?>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<select class="form-control" required="" name="seller_id">
						<option>Select Seller</option>
						<?php
						foreach ($seller as $skey => $svalue) {
						?>
						<option <?= (set_value($val['seller_id'])==$svalue['id'] || ($user['record']['seller_id'])==$svalue['id'])?'selected':'' ?> value="<?= $svalue['id']; ?>"><?= ucfirst($svalue['username']) ?></option>
						<?php
						}
						 ?>
					</select>
				</div>
			</div>
			<?php	
			} ?>			
		
		</div>