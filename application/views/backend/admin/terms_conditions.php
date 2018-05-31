
<hr>
<div class="row">

    <?php include 'left_sidebar.php'; ?>

    <div class="col-md-10">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h3><?php echo get_phrase('terms_conditions'); ?></h3>
                <hr />

                <?php echo form_open(base_url() . 'index.php?admin/frontend_settings/update_terms_conditions' ,
                    array('class' => 'form-horizontal form-groups', 'id' => 'jq-submit'));?>


                <div class="form-group">
                    <textarea class="form-control wysihtml5" data-stylesheet-url="assets/css/wysihtml5-color.css" id="sample_wysiwyg">
                        <?php echo $this->db->get_where('settings_frontend' , array('type' =>'terms_conditions'))->row()->description;?>
                    </textarea>
                    <input type="hidden" name="terms_conditions" id="terms_conditions">
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-success"
                            id="submit_button">
                        <i class="entypo-check"></i> &nbsp; <?php echo get_phrase('save'); ?>
                    </button>
                </div>

                <?php echo form_close();?>
            </div>
        </div>

        <script type="text/javascript">
            $('#submit_button').on('click', function() {
                var value = $('#sample_wysiwyg').val();
                $('#terms_conditions').val(value);
                $('#jq-submit').submit();
            });
        </script>

    </div>
</div>
