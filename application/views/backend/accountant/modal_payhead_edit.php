<?php
$edit_data = $this->db->get_where('pay_head' , array('pay_head_id' => $param2))->result_array();
foreach ($edit_data as $row):
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-plus-circled"></i>
                        <?php echo get_phrase('edit_pay_head');?>
                    </div>
                </div>

                <div class="panel-body">

                    <?php echo form_open(base_url() . 'index.php?accountant/payHeadMaster/edit/' . $row['pay_head_id'] , array('class' => 'form-horizontal form-groups-bordered validate'));?>


                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('pay_head_name');?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="pay_head_name" value="<?php echo $row['pay_head_name'];?>" data-validate="required">
                        </div>
                    </div>

                    <div class="form-group">

                        <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>

                        <div class="col-sm-5">
                            <textarea class="form-control" name="description" data-validate="required"><?php echo $row['description'];?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-3" class="col-sm-3 control-label"><?php echo get_phrase('action');?></label>

                        <div class="col-sm-5">
                            <select name="action" class="form-control" data-validate="required">
                                <?php
                                $action = $this->db->get_where('pay_head' , array('pay_head_id' => $row['pay_head_id']))->row()->action;
                                ?>
                                <option value=""><?php echo get_phrase('select');?></option>
                                <option value="addition" <?php if($action == 'addition')echo 'selected';?>><?php echo get_phrase('addition');?></option>
                                <option value="deduction"<?php if($action == 'deduction')echo 'selected';?>><?php echo get_phrase('deduction');?></option>
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
