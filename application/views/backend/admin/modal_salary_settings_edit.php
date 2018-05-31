<?php 
	$edit_data = $this->db->get_where('salary_settings' , array('id' => $param2))->result_array();
	foreach ($edit_data as $row):
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title">
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_salary_setting');?>
            	</div>
            </div>

			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/salarySettings/edit/' . $row['id'] , array('class' => 'form-horizontal form-groups-bordered validate'));?>
                    
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('pay_head_master');?></label>
                        
						<div class="col-sm-5">
							<select name="pay_head_id" class="form-control" data-validate="required">
                              <option value=""><?php echo get_phrase('select_pay_head');?></option>

                              <?php
                              	$pay_head = $this->db->get_where('pay_head')->result_array();

                              	foreach($pay_head as $row2):
                              ?>

                              <option value="<?php echo $row2['pay_head_id'];?>"
                              	<?php if($row['pay_head_id'] == $row2['pay_head_id']) echo 'selected';?>><?php echo $row2['pay_head_name'];?></option>
                          <?php endforeach;?>
                          </select>
						</div> 
					</div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('unit');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="unit" value="<?php echo $row['unit'];?>" >
						</div>
					</div>                 
									
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('type');?></label>
                        
						<div class="col-sm-5">
							<select name="type" class="form-control" data-validate="required">
							<?php
								$type = $this->db->get_where('salary_settings' , array('type' => $row['type']))->row()->type;
							?>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="percentage" <?php if($type == 'percentage')echo 'selected';?>><?php echo get_phrase('percentage');?></option>
                              <option value="amount"<?php if($type == 'amount')echo 'selected';?>><?php echo get_phrase('amount');?></option>
                          </select>
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
