<?php
$edit_data	=  $this->db->get_where('events' , array('event_id' => $param2) )->result_array();
?>

<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">

        <?php foreach($edit_data as $row):?>

            <?php echo form_open(base_url(). 'index.php?admin/frontend_events/do_update_events/'.$row['event_id'] , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

            <div class="padded">
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('title');?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="title" value="<?php echo $row['title'];?>" required/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
                    <div class="col-sm-5">
                        <input type="text" class="datepicker form-control" name="timestamp" value="<?php echo date('m/d/Y',$row['date']);?>" required/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('status'); ?></label>
                    <div class="col-sm-4">

                        <select class="form-control" name="status">

                            <option value="0" <?php if($row['status'] == '0')echo 'selected';?>>
                                <?php echo get_phrase('inactive'); ?>
                            </option>

                            <option value="1" <?php if($row['status'] == '1')echo 'selected';?>>
                                <?php echo get_phrase('active')?>
                            </option>
                        </select>

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <button type="submit" class="btn btn-info">
                        <i class="fa fa-check"></i>
                        <?php echo get_phrase('update');?>
                    </button>
                </div>
            </div>

            </form>
        <?php endforeach;?>
    </div>
</div>