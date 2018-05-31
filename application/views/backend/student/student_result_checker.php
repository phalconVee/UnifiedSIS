
<div class="row">
<div class="col-md-8">
    <div class="panel panel-primary" data-collapsed="0">
        <div class="panel-heading">
            <div class="panel-title" >
                <i class="entypo-plus-circled"></i>
                <?php echo get_phrase('result_checker');?>
            </div>
        </div>
        <div class="panel-body">

            <?php echo form_open(base_url() . 'index.php?student/result_checker/'.$student_id.'/check_result/' , array('class' => 'form-horizontal form-groups-bordered validate'));?>

            <div class="form-group">
                
               <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('pin');?></label>

               <div class="col-sm-5">
                    <input type="text" class="form-control" name="pin" id="pin" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <button type="submit" class="btn btn-info"><?php echo get_phrase('submit');?></button>
                </div>
            </div>

            <?php echo form_close();?>

        </div>
    </div>
</div>

<div class="col-md-4">
    <blockquote class="blockquote-blue">
        <p>
            <strong>Check Results</strong>
        </p>
        <p>
            Input your unique pin to view results for the current academic session. The pin is a unique seven (7) alphanumeric character given to you by the school.
        </p>
    </blockquote>

    <?php
    $credential = array('student_id' => $student_id);
    $query = $this->db->get_where('cards', $credential);
    if($query->num_rows() == 1){

        $row = $query->row();
    ?>
        <blockquote class="blockquote-green">
            <p>
               Your Result Checker Pin is: <strong><?=$row->pin;?></strong>
            </p>
        </blockquote>
    <?php } ?>
</div>

</div>

