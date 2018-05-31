<?php 
$edit_data = $this->db->get_where('employee' , array('emp_id' => $param2 ))->result_array();

foreach ($edit_data as $row):
?>            

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_employee');?>
            	</div>
            </div>

			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/employee/do_update/'.$row['emp_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
                               	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>
                        
						<div class="col-sm-5">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
									<img src="<?php echo $this->crud_model->get_image_url('employee' , $row['emp_id']);?>" alt="...">
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
								<div>
									<span class="btn btn-white btn-file">
										<span class="fileinput-new">Select image</span>
										<span class="fileinput-exists">Change</span>
										<input type="file" name="userfile" accept="image/*">
									</span>
									<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
							</div>
						</div>
					</div>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('full_name');?>
							<br>
							<span><small>(firstname first)</small></span>
						</label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" 
								value="<?php echo $this->db->get_where('employee' , array('emp_id' => $row['emp_id']))->row()->name; ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('other_name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="other_name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" 
								value="<?php echo $this->db->get_where('employee' , array('emp_id' => $row['emp_id']))->row()->other_name; ?>">
						</div>
					</div>			
							
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('birthday');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="birthday" 
								value="<?php echo $this->db->get_where('employee' , array('emp_id' => $row['emp_id']))->row()->birthday; ?>" 
									data-start-view="2">
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('gender');?></label>
                        
						<div class="col-sm-5">
							<select name="sex" class="form-control selectboxit">
							<?php
								$gender = $this->db->get_where('employee' , array('emp_id' => $row['emp_id']))->row()->sex;
							?>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="male" <?php if($gender == 'male')echo 'selected';?>><?php echo get_phrase('male');?></option>
                              <option value="female"<?php if($gender == 'female')echo 'selected';?>><?php echo get_phrase('female');?></option>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('religion');?></label>
                        
						<div class="col-sm-5">
							<select name="religion" class="form-control selectboxit">
							<?php
								$religion = $this->db->get_where('employee' , array('emp_id' => $row['emp_id']))->row()->religion;
							?>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="christian" <?php if($religion == 'christian')echo 'selected';?>><?php echo get_phrase('christian');?></option>
                              <option value="muslim"<?php if($religion == 'muslim')echo 'selected';?>><?php echo get_phrase('muslim');?></option>
                              <option value="others"<?php if($religion == 'others')echo 'selected';?>><?php echo get_phrase('others');?></option>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('designation');?></label>
                        
						<div class="col-sm-5">
							<select name="designation" class="form-control selectboxit">
							<?php
								$designation = $this->db->get_where('employee' , array('emp_id' => $row['emp_id']))->row()->designation;
							?>
                              <option value=""><?php echo get_phrase('select');?></option>

                              <option value="security" <?php if($designation == 'security')echo 'selected';?>><?php echo get_phrase('security');?></option>

                              <option value="cleaner"<?php if($designation == 'cleaner')echo 'selected';?>><?php echo get_phrase('cleaner');?></option>

                              <option value="vendor"<?php if($designation == 'vendor')echo 'selected';?>><?php echo get_phrase('vendor');?></option>

                              <option value="office_assistant"<?php if($designation == 'office_assistant')echo 'selected';?>><?php echo get_phrase('office_assistant');?></option>

                              <option value="corpers"<?php if($designation == 'corpers')echo 'selected';?>><?php echo get_phrase('corpers');?></option>

                              <option value="marketers"<?php if($designation == 'marketers')echo 'selected';?>><?php echo get_phrase('marketers');?></option>
                              
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('working_hour');?></label>
                        
						<div class="col-sm-5">
							<select name="working_hour" class="form-control selectboxit">
							<?php
								$working_hour = $this->db->get_where('employee' , array('emp_id' => $row['working_hour']))->row()->working_hour;
							?>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="part_time" <?php if($working_hour == 'part_time')echo 'selected';?>><?php echo get_phrase('part_time');?></option>
                              
                              <option value="full_time"<?php if($working_hour == 'full_time')echo 'selected';?>><?php echo get_phrase('full_time');?></option>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('nationality');?></label>
                        
						<div class="col-sm-5">
							<select name="nationality" class="form-control selectboxit">
							<?php
								$nationality = $this->db->get_where('employee' , array('emp_id' => $row['emp_id']))->row()->nationality;
							?>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="nigerian" <?php if($nationality == 'nigerian')echo 'selected';?>><?php echo get_phrase('nigerian');?></option>
                              
                              <option value="others"<?php if($nationality == 'others')echo 'selected';?>><?php echo get_phrase('others');?></option>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('state_of_origin');?></label>

						<div class="col-sm-5">
							<select name="state_id" class="form-control" data-validate="required" id="state_id"
									onchange="return get_lga(this.value)">

								<?php
								$state = $this->db->get_where('employee' , array('emp_id' => $row['emp_id']))->row()->state_id;
								?>

                              <option value=""><?php echo get_phrase('select');?></option>
                              
                              <?php
								$states = $this->db->get_where('states')->result_array();
								foreach($states as $rows):
							  ?>
                            		<option value="<?php echo $rows['state_id'];?>" <?php if($state == $rows['state_id'])echo 'selected';?>>

											<?php echo $rows['name'];?>

                                    </option>
                                <?php
								endforeach;
							  ?>
                          </select>
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('lga');?></label>
		                    <div class="col-sm-5">
		                        <select name="local_id" class="form-control" id="lga_selector_holder">

			                        <?php
									$local = $this->db->get_where('employee' , array('emp_id' => $row['emp_id']))->row()->local_id;
									?>

		                            <option value=""><?php echo get_phrase('select_lga');?></option>

		                            <?php
										$locals = $this->db->get_where('locals')->result_array();
										foreach($locals as $rowx):
									  ?>
		                            		<option value="<?php echo $rowx['local_id'];?>" <?php if($local == $rowx['local_id'])echo 'selected';?>>

													<?php echo $rowx['local_name'];?>

		                                    </option>
		                                <?php
										endforeach;
									  ?>
			                    </select>
			                </div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="address" 
								value="<?php echo $this->db->get_where('employee' , array('emp_id' => $row['emp_id']))->row()->address; ?>" >
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="phone" 
								value="<?php echo $this->db->get_where('employee' , array('emp_id' => $row['emp_id']))->row()->phone; ?>" >
						</div> 
					</div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="email" 
								value="<?php echo $this->db->get_where('employee' , array('emp_id' => $row['emp_id']))->row()->email; ?>">
						</div>
					</div>
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('edit_employee');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

<?php
endforeach;
?>

<script type="text/javascript">
	
    function get_lga(state_id) {

    	$.ajax({
            url: '<?php echo base_url();?>index.php?admin/get_lga/' + state_id ,
            success: function(response)
            {
                jQuery('#lga_selector_holder').html(response);
            }
        });
    }

</script>