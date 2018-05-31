<style>
    .onoffswitch {
    position: relative; width: 90px;
    -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
}
.onoffswitch-checkbox {
    display: none;
}
.onoffswitch-label {
    display: block; overflow: hidden; cursor: pointer;
    border: 2px solid #999999; border-radius: 20px;
}
.onoffswitch-inner {
    display: block; width: 200%; margin-left: -100%;
    transition: margin 0.3s ease-in 0s;
}
.onoffswitch-inner:before, .onoffswitch-inner:after {
    display: block; float: left; width: 50%; height: 30px; padding: 0; line-height: 30px;
    font-size: 14px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
    box-sizing: border-box;
}
.onoffswitch-inner:before {
    content: "ON";
    padding-left: 10px;
    background-color: #34A7C1; color: #FFFFFF;
}
.onoffswitch-inner:after {
    content: "OFF";
    padding-right: 10px;
    background-color: #EEEEEE; color: #999999;
    text-align: right;
}
.onoffswitch-switch {
    display: block; width: 18px; margin: 6px;
    background: #FFFFFF;
    position: absolute; top: 0; bottom: 0;
    right: 56px;
    border: 2px solid #999999; border-radius: 20px;
    transition: all 0.3s ease-in 0s; 
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
    margin-left: 0;
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
    right: 0px; 
}
</style>

<div class="row">
<div class="col-md-8">
    <div class="panel panel-primary" data-collapsed="0">
        <div class="panel-heading">
            <div class="panel-title" >
                <i class="entypo-plus-circled"></i>
                <?php echo get_phrase('result_checker_settings');?>
            </div>
        </div>
        <div class="panel-body">

            <?php echo form_open(base_url() . 'index.php?admin/result_checker_settings/update_settings/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

            <div class="form-group">

                <?php $set = $this->db->get_where('settings' , array('type' =>'scratch_card_active'))->row()->description; ?>
                
                <div class="col-sm-5">

                    <div class="onoffswitch" style="margin-left: 50px;">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" <?php if($set == '1') echo 'checked';   ?> >
                        <label class="onoffswitch-label" for="myonoffswitch">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                    
                </div>
            </div>


            <?php echo form_close();?>

        </div>
    </div>
</div>

<div class="col-md-4">
    <blockquote class="blockquote-blue">
        <p>
            <strong>Result Checker Settings</strong>
        </p>
        <p>
            Activate/De-activate result checking by scratch cards for your school. When activated students and parents will be required to use unique pins to check results. 
        </p>
    </blockquote>
</div>

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