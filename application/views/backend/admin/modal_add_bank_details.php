<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_staff_bank_details');?>
            	</div>
            </div>
			<div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?admin/bank_details/add/' , array('class' => 'form-horizontal form-groups-bordered validate'));?>
	
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('staff_designation');?></label>
                        
						<div class="col-sm-5">
							
							<select name="staff_type" class="form-control" data-validate="required" id="type_id" data-message-required="<?php echo get_phrase('value_required');?>" onchange="return get_staff_names(this.value)">

                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="teacher"><?php echo get_phrase('teacher');?></option>
                              <option value="accountant"><?php echo get_phrase('accountant');?></option>
                              <option value="librarian"><?php echo get_phrase('librarian');?></option>
                              <option value="employee"><?php echo get_phrase('employee');?></option>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('staff_name');?></label>
                        
						<div class="col-sm-5">
		                        <select name="staff_id" class="form-control" id="section_selector_holder" data-validate="required">
		                            <option value=""><?php echo get_phrase('select_designation_first');?></option>

			                    </select>
			                </div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('bank');?></label>

						<div class="col-sm-5">
							<select name="bank_id" class="form-control" data-validate="required">
                              <option value=""><?php echo get_phrase('select');?></option>
	                              <?php
	                              	$banks = $this->db->get('banks')->result_array();
	                              	foreach($banks as $row):
	                              ?>
                              		<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                          		<?php endforeach;?>
                          </select>
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('branch');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="branch" value="" data-validate="required">
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('account_number');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="acct_no" value="" data-validate="required">
						</div>
					</div>
		
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('add_bank_details');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
	var type_id;

	function get_staff_names(type_id) {

		if(type_id != ''){
			$.ajax({
	            url: '<?php echo base_url();?>index.php?admin/get_staff_names/' + type_id,
	            success: function(response)
	            {
	                jQuery('#section_selector_holder').html(response);
	            }
        	});
		}  	
    }

</script>
