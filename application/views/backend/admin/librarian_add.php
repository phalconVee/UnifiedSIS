<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title">
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_librarian');?>
            	</div>
            </div>

			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/librarian/create' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"  autofocus
                            	value="">
						</div>
					</div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="email" value="" >
						</div>
					</div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('username');?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="username" name="username" value="" onBlur="checkAvailability()" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"><span id="user-availability-status"></span>
                            <p><img src="assets/images/loader-2.gif" id="loaderIcon" style="display:none" /></p>
                        </div>
                    </div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('password');?></label>
                        
						<div class="col-sm-5">
							<input type="password" class="form-control" name="password" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
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
</div>

<script>
    function checkAvailability() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "<?=base_url();?>index.php?admin/librarianUsernameCheck",
            data:'username='+$("#username").val(),
            type: "POST",
            success:function(data){
                $("#user-availability-status").html(data);
                $("#loaderIcon").hide();
            },
            error:function (){}
        });
    }
</script>
