<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_leave_categroy');?>
            	</div>
            </div>

			<div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?admin/leaveCategory/add/' , array('class' => 'form-horizontal form-groups-bordered validate'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-4 control-label"><?php echo get_phrase('leave_category_name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="category_name" value="" data-validate="required">							
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
