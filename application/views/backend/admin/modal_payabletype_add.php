<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_payable_type');?>
            	</div>
            </div>

			<div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?admin/payableTypes/create/' , array('class' => 'form-horizontal form-groups-bordered validate'));?>

	                <div class="form-group">
						<label for="field-1" class="col-sm-4 control-label"><?php echo get_phrase('payable_type_name');?></label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="payable_name" value="" data-validate="required">
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

