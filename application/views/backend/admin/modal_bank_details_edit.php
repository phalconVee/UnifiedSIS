<?php 
	$edit_data = $this->db->get_where('bank_details' , array('id' => $param2))->result_array();
	foreach ($edit_data as $row):
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title">
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_staff_bank_details');?>
            	</div>
            </div>

			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/bank_details/do_update/' . $row['id'] , array('class' => 'form-horizontal form-groups-bordered validate'));?>
                    
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('banks');?></label>
                        
						<div class="col-sm-5">
							<select name="bank_id" class="form-control" data-validte="required">
                              <option value=""><?php echo get_phrase('select_bank');?></option>

                              <?php
                              	$banks = $this->db->get_where('banks')->result_array();

                              	foreach($banks as $row2):
                              ?>

                              <option value="<?php echo $row2['id'];?>"
                              	<?php if($row['bank_id'] == $row2['id']) echo 'selected';?>><?php echo $row2['name'];?></option>
                          <?php endforeach;?>
                          </select>
						</div> 
					</div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('branch');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="branch" value="<?php echo $row['branch'];?>" >
						</div>
					</div>                 
									
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('account_number');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="acct_no" value="<?php echo $row['acct_no'];?>">
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
