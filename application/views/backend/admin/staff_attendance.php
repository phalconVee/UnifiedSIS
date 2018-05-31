<hr />

<?php echo form_open(base_url() . 'index.php?admin/staff_attendance_selector/');?>

<div class="row">

	<div class="col-md-3">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('designation');?></label>
			
			<select name="staff_type" class="form-control" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" onchange="return get_staff_names(this.value)" id = "type_selection">

		      <option value=""><?php echo get_phrase('select');?></option>
		      <option value="teacher"><?php echo get_phrase('teacher');?></option>
		      <option value="accountant"><?php echo get_phrase('accountant');?></option>
		      <option value="librarian"><?php echo get_phrase('librarian');?></option>
		      <option value="employee"><?php echo get_phrase('employee');?></option>
		    </select>

		</div>
	</div>

	
    <!--<div id="section_holder">
	<div class="col-md-3">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('name');?></label>
			<select class="form-control selectboxit" name="staff_id">
                <option value=""><?php echo get_phrase('select_designation_first') ?></option>
			</select>
		</div>
	</div>
    </div>-->
	
        <div class="col-md-3">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('date');?></label>
			<input type="text" class="form-control datepicker" name="timestamp" data-format="dd-mm-yyyy"
				value="<?php echo date("d-m-Y");?>"/>
		</div>
	</div>
	<input type="hidden" name="year" value="<?php echo $running_year;?>">

	<div class="col-md-3" style="margin-top: 20px;">
		<button type="submit" id = "submit" class="btn btn-info"><?php echo get_phrase('manage_attendance');?></button>
	</div>

</div>
<?php echo form_close();?>

<script type="text/javascript">
var type_selection = "";
jQuery(document).ready(function($) {
	$('#submit').attr('disabled', 'disabled');
});

function get_staff_names(type_id) {
	if(type_id !== ''){
		$.ajax({
			url: '<?php echo base_url(); ?>index.php?admin/get_staff_holder/' + type_id,
			success:function (response)
			{
				jQuery('#section_holder').html(response);
			}
		});
	}
}

function check_validation(){
	if(type_selection !== ''){
		$('#submit').removeAttr('disabled')
	}
	else{
		$('#submit').attr('disabled', 'disabled');
	}
}

$('#type_selection').change(function(){
	type_selection = $('#type_selection').val();
	check_validation();
});
</script>