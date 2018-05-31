<div class="row">
<div class="col-md-8">
    <div class="panel panel-primary" data-collapsed="0">
        <div class="panel-heading">
            <div class="panel-title" >
                <i class="entypo-plus-circled"></i>
                <?php echo get_phrase('bulk_sms_form');?>
            </div>
        </div>
        <div class="panel-body">

            <?php echo form_open(base_url() . 'index.php?admin/bulk_sms/send_bulk_sms/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

            <div class="form-group">
                <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('recipients');?></label>

                <div class="col-sm-5">
                    <textarea name="telephone" id="telephone" class="form-control" cols="45" rows="6" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" autofocus required></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('message');?></label>

                <div class="col-sm-5">
                    <textarea name="message" id="message" class="form-control" cols="45" rows="3" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" autofocus required></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <button type="submit" class="btn btn-info"><?php echo get_phrase('send');?></button>
                </div>
            </div>

            <?php echo form_close();?>

        </div>
    </div>
</div>

<div class="col-md-4">
    <blockquote class="blockquote-blue">
        <p>
            <strong>Bulk SMS Notes</strong>
        </p>
        <p>
            Put notes here
        </p>
    </blockquote>
</div>

</div>

