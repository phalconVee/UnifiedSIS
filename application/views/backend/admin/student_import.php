<hr />

<?php echo form_open(base_url() . 'index.php?admin/student_import/import_excel/' , array('class' => 'form-horizontal form-groups-bordered validate', 'style' => 'text-align:center;', 'enctype' => 'multipart/form-data', 'autcomplete' => 'off'));?>


<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-3">
		<div class="form_group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
			<select name="class_id" id="class_id" class="form-control selectboxit" required
				onchange="get_sections(this.value)"  data-validate="required"  data-message-required="<?php echo get_phrase('value_required');?>">
				<option value=""><?php echo get_phrase('select_class');?></option>
				<?php
					$classes = $this->db->get('class')->result_array();
					foreach($classes as $row):
				?>
				<option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>
	<div id="section_holder"></div>
	<div class="col-md-3"></div>
</div>
<br><br>

<div class="row">

	<div class="col-md-offset-4 col-md-4" style="padding: 15px;">
		<button type="button" class="btn btn-primary" name="generate_csv" id="generate_csv">Generate CSV File</button>
	</div>

	<div class="col-md-offset-4 col-md-4" style="padding-bottom:15px;">
	<input type="file" name="file" id="file" class="form-control file2 inline btn btn-info" data-label="<i class='entypo-tag'></i> Select CSV File" data-validate="required" data-message-required="Required"
	               		accept="text/csv, .csv" />
	</div>

	<div class="col-md-offset-4 col-md-4">
		<button type="submit" class="btn btn-success" name="import_csv" id="import_csv">Import CSV</button>
	</div>

</div>

<br><br>

<?php echo form_close();?>

	

<div class="row">

	<div class="col-md-12" style="padding: 10px; background-color: #B3E5FC; color: #424242;">
		<p style="font-weight: 700; font-size: 15px;">
			Please Follow The Instructions For Adding Bulk Student:		</p>
			<ol>
				<li style="padding: 5px;">At First Select The Class And Section.</li>
				<li style="padding: 5px;">After Selecting Class And Section Click "Generate CSV File".</li>
				<li style="padding: 5px;">Open The Downloaded "bulk_student.csv" File. Enter Student Details As Written In There And Remember to Start entrying the data from the first rows. Just delete the sample data</li>
				<li style="padding: 5px;">Save The Edited "bulk_student.csv" File.</li>
				<li style="padding: 5px;">Click The "Select CSV File" And Choose The File You Just Edited.</li>
				<li style="padding: 5px;">Import That File.</li>
				<li style="padding: 5px;">Hit "Import CSV File".</li>
			</ol>
			<p style="color: #FF5722; font-weight: 500;">
				***This System Keeps Track Of Duplication In Email ID. So Please Enter Unique Email ID For Every Student.	
		</p>
	</div>

    
</div>

<a href="" download="bulk_student.csv" style="display: none;" id = "bulk">Download</a>

<?php echo form_close();?>

<script type="text/javascript">

	var class_selection = '';
	jQuery(document).ready(function($) {
	$('#submit_button').attr('disabled', 'disabled');
	});

	function get_sections(class_id) {
		if(class_id !== ''){
		$.ajax({
            url: '<?php echo base_url();?>index.php?admin/get_sections/' + class_id ,
            success: function(response)
            {
                jQuery('#section_holder').html(response);
                jQuery('#bulk_add_form').show();
            }
        });
	  }
	}

	function check_validation(){
		if(class_selection !== ''){
			$('#submit_button').removeAttr('disabled')
		}
		else{
			$('#submit_button').attr('disabled', 'disabled');
		}
	}

	$('#class_id').change(function() {
		class_selection = $('#class_id').val();
		check_validation();
	});

	$("#generate_csv").click(function() {
		var class_id 	= $('#class_id').val();
		var section_id 	= $('#section_id').val();

		if(class_id == '' || section_id == '')
			toastr.error("Please Make Sure Class And Section Is Selected");
		else {
			$.ajax({
			  	url: '<?=base_url();?>index.php?admin/download/bulk_student.csv',
			  	success: function(response) {
			    	toastr.success("File Generated");
						$("#bulk").attr('href', response);
						jQuery('#bulk')[0].click();
			    	//document.location = response;
			  	}
			});
		}
	});

</script>
