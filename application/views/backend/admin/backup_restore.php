
<div class="row">

    <div class="col-md-12">
        <blockquote class="blockquote-blue">
            <p>
                <strong>BackUp Settings</strong>
            </p>
            <p>
                Create Backup for your existing records by clicking on the backup button below. This should be done on schedule to avoid loosing any
                important records in-case of server mishaps. Please store in a safe place in-case of future need.
            </p>

        </blockquote>
    </div>

    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('perform_backup');?>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?admin/backup_restore/create/all' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

                <div class="form-group">


                    <div class="col-sm-5">

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-success"><i class="fa fa-download"></i> <?php echo get_phrase('backup');?></button>
                            </div>
                        </div>

                    </div>
                </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>

    <!--<div class="col-md-6">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('restore_backup');?>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?admin/backup_restore/restore/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

                <div class="form-group">

                    <div class="col-sm-5">

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5" style="padding-bottom:15px;">
                                <input type="file" name="userfile" id="file" class="form-control file2 inline btn btn-primary" data-label="<i class='entypo-tag'></i> Select SQL File" data-validate="required" data-message-required="Required"
                                       accept="text/sql, .sql" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-info"><?php echo get_phrase('restore');?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>-->



</div>


<script type="text/javascript">

    var $toggleInput = $('input[type="checkbox"]');

    $toggleInput.on('click', function(){

        var data = {};
        data.id = $(this).attr('id');
        data.value = $(this).is(':checked') ? 1 : 0;

        console.log(data);

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>index.php?admin/result_checker_settings/update_settings/",
            data: data,
        }).done(function(data) {
            window.location = '<?php echo base_url();?>index.php?admin/result_checker_settings/'
        });

    });


</script>