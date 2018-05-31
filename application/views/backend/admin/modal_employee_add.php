<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_employee');?>
            	</div>
            </div>
			<div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?admin/employee/create/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('full_name');?><br>
							<small>(first name first)</small>
						</label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('other_name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="other_name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('birthday');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="birthday" value="" data-start-view="2" placeholder="dd/mm/yyyy">
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('gender');?></label>
                        
						<div class="col-sm-5">
							<select name="sex" class="form-control selectboxit">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="male"><?php echo get_phrase('male');?></option>
                              <option value="female"><?php echo get_phrase('female');?></option>
                          </select>
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('nationality');?></label>
                        
						<div class="col-sm-5">
							<select name="nationality" class="form-control selectboxit">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="nigerian"><?php echo get_phrase('nigerian');?></option>
                              <option value="others"><?php echo get_phrase('Others');?></option>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('religion');?></label>
                        
						<div class="col-sm-5">
							<select name="religion" class="form-control selectboxit">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="christian"><?php echo get_phrase('christian');?></option>
                              <option value="muslim"><?php echo get_phrase('muslim');?></option>
                              <option value="others"><?php echo get_phrase('others');?></option>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('state_of_origin');?></label>

						<div class="col-sm-5">
							<select name="state_id" class="form-control" data-validate="required" id="state_id"
								data-message-required="<?php echo get_phrase('value_required');?>"
									onchange="return get_lga(this.value)">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php
								$classes = $this->db->get('states')->result_array();
								foreach($classes as $row):
									?>
                            		<option value="<?php echo $row['state_id'];?>">
											<?php echo $row['name'];?>
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
		                            <option value=""><?php echo get_phrase('select_state_first');?></option>

			                    </select>
			                </div>
					</div>					
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="address" value="" >
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('designation');?></label>
                        
						<div class="col-sm-5">
							<select name="designation" class="form-control selectboxit">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="security"><?php echo get_phrase('security');?></option>
                              <option value="cleaner"><?php echo get_phrase('cleaner');?></option>
                              <option value="vendor"><?php echo get_phrase('vendor');?></option>
                              <option value="office_assistant"><?php echo get_phrase('office_assistant');?></option>
                              <option value="corpers"><?php echo get_phrase('corpers');?></option>
                              <option value="marketers"><?php echo get_phrase('marketers');?></option>
                          </select>
						</div>  
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('working_hour');?></label>
                        
						<div class="col-sm-5">
							<select name="working_hour" class="form-control selectboxit">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="part_time"><?php echo get_phrase('part_time');?></option>
                              <option value="full_time"><?php echo get_phrase('full_time');?></option>
                          </select>
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="phone" value="" >
						</div> 
					</div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="email" value="">
						</div>
					</div>                  				
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>
                        
						<div class="col-sm-5">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
									<img src="http://placehold.it/200x200" alt="...">
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
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('add_employee');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>


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
