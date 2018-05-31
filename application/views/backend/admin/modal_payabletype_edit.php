<?php 
	$edit_data = $this->db->get_where('payable_types' , array('payable_id' => $param2))->result_array();
	foreach ($edit_data as $row):
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title">
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_payable_type');?>
            	</div>
            </div>

			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/payableTypes/edit/' . $row['payable_id'] , array('class' => 'form-horizontal form-groups-bordered validate'));?>
                    

                    <div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('pay_head_name');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="payable_name" value="<?php echo $row['payable_name'];?>" data-validate="required">
						</div>
					</div>   

                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-default"><?php echo get_phrase('update');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>
