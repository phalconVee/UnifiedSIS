<hr>
<div class="row">

    <?php include 'left_sidebar.php'; ?>


    <div class="col-md-10">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3><?php echo get_phrase('about_us')?></h3>
            <hr />

            <?php echo form_open(base_url() . 'index.php?admin/frontend_settings/update_about_us' ,
                array('class' => 'form-horizontal form-groups', 'id' => 'jq-submit', 'enctype' => 'multipart/form-data'));?>

                <div class="form-group">
                    <textarea class="form-control wysihtml5" data-stylesheet-url="assets/css/wysihtml5-color.css" id="sample_wysiwyg">
                        <?php echo $this->db->get_where('settings_frontend' , array('type' =>'about_us'))->row()->description;?>
                    </textarea>
                    <input type="hidden" name="about_us" id="about_us">
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-2 control-label"><?php echo get_phrase('banner_image')?></label>
                    <div class="col-sm-7">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 300px; height: 200px;" data-trigger="fileinput">
                                <img src="<?php echo base_url();?>uploads/frontend/about/default.jpg" alt="...">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 300px; max-height: 200px"></div>
                            <div>
                              <span class="btn btn-white btn-file">
                                <span class="fileinput-new">Select Image</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" name="about_us_image" accept="image/*">
                              </span>
                                <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-success" id="submit_button">
                        <i class="entypo-check"></i> &nbsp; <?php echo get_phrase('save');?> </button>
                </div>

            <?php echo form_close();?>
        </div>
    </div>

    <script type="text/javascript">

        $('#submit_button').on('click', function() {
            var value = $('#sample_wysiwyg').val();
            $('#about_us').val(value);
            $('#jq-submit').submit();
        });

    </script>
</div>
</div>
