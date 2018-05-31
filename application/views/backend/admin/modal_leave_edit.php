<?php 
	$edit_data = $this->db->get_where('leave_application' , array('id' => $param2))->result_array();
	foreach ($edit_data as $row):
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title">
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_leave_application');?>
            	</div>
            </div>

			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/leaveApplication/do_update/' . $row['id'] , array('class' => 'form-horizontal form-groups-bordered validate'));?>
                    

                    <div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('leave_category_name');?>
						</label>

						<div class="col-sm-5">
							<select name="leave_category_id" class="form-control" data-validte="required">
                              <option value=""><?php echo get_phrase('select_leave_category');?></option>

                              <?php
                              	$cate = $this->db->get_where('leave_category')->result_array();

                              	foreach($cate as $row2):
                              ?>

                              <option value="<?php echo $row2['id'];?>"
                              	<?php if($row['leave_category_id'] == $row2['id']) echo 'selected';?>><?php echo $row2['category_name'];?></option>
                          <?php endforeach;?>
                          </select>
						</div> 

					</div>   

					<div class="form-group">
						<label for="field-5" class="col-sm-3 control-label"><?php echo get_phrase('from');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" id="datepicker" name="from" placeholder= "mm/dd/yyyy" value="<?=$row['from']?>" data-start-view="2" data-validate="required">
						</div>
					</div>	

					<div class="form-group">
						<label for="field-5" class="col-sm-3 control-label"><?php echo get_phrase('to');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" id="datepicker" name="to" placeholder= "mm/dd/yyyy" value="<?=$row['to']?>" data-start-view="2" data-validate="required">
						</div>
					</div>	

					<div class="form-group">
						<label for="field-5" class="col-sm-3 control-label"><?php echo get_phrase('reason');?></label>

						<div class="col-sm-5">
							<textarea class="form-control" data-validate="required" name="reason">
								<?=$row['reason'];?>
							</textarea>
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
