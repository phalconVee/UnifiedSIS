<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('staff_salary');?>
            	</div>
            </div>
			<div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?admin/staffSalary/add/' , array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'main'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('staff_designation');?></label>
                        
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
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('staff_name');?></label>
                        
						<div class="col-sm-5">
		                        <select name="staff_id" class="form-control" id="section_selector_holder" data-validate="required">
		                            <option value=""><?php echo get_phrase('select_designation_first');?></option>
			                    </select>
			                </div>
					</div>
					
					<div class="form-group">
						<label for="field-3" class="col-sm-3 control-label"><?php echo get_phrase('year');?></label>

						<div class="col-sm-5">
							<select name="year" class="form-control" data-validate="required">

                              <option value=""><?php echo get_phrase('select_salary_year');?></option>
                              <?php for($i = 0; $i < 20; $i++):?>
							      	<option value="<?php echo (2012+$i);?>">
							          	<?php echo (2012+$i);?>
							      	</option>
							  <?php endfor;?>
                          </select>
						</div>
					</div>

					<div class="form-group">
						<label for="field-4" class="col-sm-3 control-label"><?php echo get_phrase('month');?></label>
						<div class="col-sm-5">
							<select name="month" class="form-control" data-validate="required">

                              <option value=""><?php echo get_phrase('select_salary_month');?></option>
                              <option value="january"><?php echo get_phrase('january');?></option>
                              <option value="february"><?php echo get_phrase('february');?></option>
                              <option value="march"><?php echo get_phrase('march');?></option>
                              <option value="april"><?php echo get_phrase('april');?></option>
                              <option value="may"><?php echo get_phrase('may');?></option>
                              <option value="june"><?php echo get_phrase('june');?></option>
                              <option value="july"><?php echo get_phrase('july');?></option>
                              <option value="august"><?php echo get_phrase('august');?></option>
                              <option value="september"><?php echo get_phrase('september');?></option>
                              <option value="october"><?php echo get_phrase('october');?></option>
                              <option value="november"><?php echo get_phrase('november');?></option>
                              <option value="december"><?php echo get_phrase('december');?></option>
                          </select>
                             
						</div>
					</div>

					<div class="form-group">
						<label for="field-5" class="col-sm-3 control-label"><?php echo get_phrase('start_date');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" id="dp3" name="start_date" placeholder= "mm/dd/yyyy" value="" data-start-view="2">
						</div>
					</div>

					<div class="form-group">
						<label for="field-6" class="col-sm-3 control-label"><?php echo get_phrase('end_date');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="end_date" placeholder= "mm/dd/yyyy" value="" data-start-view="2">
						</div>
					</div>

					
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('save');?></button>
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
