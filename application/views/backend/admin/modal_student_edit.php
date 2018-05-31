<?php 
$edit_data		=	$this->db->get_where('enroll' , array(
	'student_id' => $param2 , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
))->result_array();
foreach ($edit_data as $row):
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_student');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/student/do_update/'.$row['student_id'].'/'.$row['class_id'] , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
                               	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>
                        
						<div class="col-sm-5">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
									<img src="<?php echo $this->crud_model->get_image_url('student' , $row['student_id']);?>" alt="...">
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
								value="<?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name; ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('other_name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="other_name" value="<?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->other_name; ?>" >
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="class" disabled
								value="<?php echo $this->db->get_where('class' , array('class_id' => $row['class_id']))->row()->name; ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('section');?></label>
                        
						<div class="col-sm-5">
							<select name="section_id" class="form-control selectboxit">
                              <option value=""><?php echo get_phrase('select_section');?></option>
                              <?php
                              	$sections = $this->db->get_where('section' , array('class_id' => $row['class_id']))->result_array();
                              	foreach($sections as $row2):
                              ?>
                              <option value="<?php echo $row2['section_id'];?>"
                              	<?php if($row['section_id'] == $row2['section_id']) echo 'selected';?>><?php echo $row2['name'];?></option>
                          <?php endforeach;?>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('admission_no');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="roll"
								value="<?php echo $row['roll'];?>">
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('parent');?></label>
                        
						<div class="col-sm-5">
							<select name="parent_id" class="form-control select2">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
									$parents = $this->db->get('parent')->result_array();
									$parent_id = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->parent_id;
									foreach($parents as $row3):
										?>
                                		<option value="<?php echo $row3['parent_id'];?>"
                                        	<?php if($row3['parent_id'] == $parent_id)echo 'selected';?>>
													<?php echo $row3['name'];?>
                                                </option>
	                                <?php
									endforeach;
								  ?>
                          </select>
						</div> 
					</div>			
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('birthday');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="birthday" 
								value="<?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->birthday; ?>" 
									data-start-view="2">
						</div> 
					</div>


					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('place_of_birth');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="place_of_birth" value="<?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->place_of_birth; ?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('gender');?></label>
                        
						<div class="col-sm-5">
							<select name="sex" class="form-control selectboxit">
							<?php
								$gender = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->sex;
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
								$religion = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->religion;
							?>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="Christian" <?php if($religion == 'Christian')echo 'selected';?>><?php echo get_phrase('christian');?></option>
                              <option value="Muslim"<?php if($religion == 'Muslim')echo 'selected';?>><?php echo get_phrase('muslim');?></option>
                              <option value="Others"<?php if($religion == 'Others')echo 'selected';?>><?php echo get_phrase('others');?></option>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('blood_group');?></label>
                        
						<div class="col-sm-5">
							<select name="blood_group" class="form-control selectboxit">
							<?php
								$blood_group = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->blood_group;
							?>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="A+" <?php if($blood_group == 'A+')echo 'selected';?>><?php echo get_phrase('a+');?></option>
                              <option value="O+"<?php if($blood_group == 'O+')echo 'selected';?>><?php echo get_phrase('o+');?></option>
                              <option value="B+"<?php if($blood_group == 'B+')echo 'selected';?>><?php echo get_phrase('b+');?></option>
                              <option value="AB+"<?php if($blood_group == 'AB+')echo 'selected';?>><?php echo get_phrase('ab+');?></option>
                              <option value="A-"<?php if($blood_group == 'A-')echo 'selected';?>><?php echo get_phrase('a-');?></option>
                              <option value="O-"<?php if($blood_group == 'O-')echo 'selected';?>><?php echo get_phrase('o-');?></option>
                              <option value="B-"<?php if($blood_group == 'B-')echo 'selected';?>><?php echo get_phrase('b-');?></option>
                              <option value="AB-"<?php if($blood_group == 'AB-')echo 'selected';?>><?php echo get_phrase('ab-');?></option>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('nationality');?></label>
                        
						<div class="col-sm-5">
							<select name="nationality" class="form-control selectboxit">
							<?php
								$nationality = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->nationality;
							?>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="nigerian" <?php if($nationality == 'nigerian')echo 'selected';?>><?php echo get_phrase('nigerian');?></option>
                              
                              <option value="others"<?php if($religion == 'others')echo 'selected';?>><?php echo get_phrase('others');?></option>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('state_of_origin');?></label>

						<div class="col-sm-5">
							<select name="state_id" class="form-control" id="state_id"
									onchange="return get_lga(this.value)">

								<?php
								$state = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->state_id;
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
									$local = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->local_id;
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
								value="<?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->address; ?>" >
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="phone" 
								value="<?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->phone; ?>" >
						</div> 
					</div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="email" 
								value="<?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->email; ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('dormitory');?></label>
                        
						<div class="col-sm-5">
							<select name="dormitory_id" class="form-control selectboxit">
                              <option value=""><?php echo get_phrase('select');?></option>
	                              <?php
	                              	$dorm_id = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->dormitory_id;
	                              	$dormitories = $this->db->get('dormitory')->result_array();
	                              	foreach($dormitories as $row2):
	                              ?>
                              		<option value="<?php echo $row2['dormitory_id'];?>"
                              			<?php if($dorm_id == $row2['dormitory_id']) echo 'selected';?>><?php echo $row2['name'];?></option>
                          		<?php endforeach;?>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('transport_route');?></label>
                        
						<div class="col-sm-5">
							<select name="transport_id" class="form-control selectboxit">
                              <option value=""><?php echo get_phrase('select');?></option>
	                              <?php
	                              	$trans_id = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->transport_id; 
	                              	$transports = $this->db->get('transport')->result_array();
	                              	foreach($transports as $row2):
	                              ?>
                              		<option value="<?php echo $row2['transport_id'];?>"
                              			<?php if($trans_id == $row2['transport_id']) echo 'selected';?>><?php echo $row2['route_name'];?></option>
                          		<?php endforeach;?>
                          </select>
						</div> 
					</div>
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('edit_student');?></button>
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