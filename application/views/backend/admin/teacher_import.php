<hr />

<?php echo form_open(base_url() . 'index.php?admin/teacher_import/import_excel/' , array('class' => 'form-horizontal form-groups-bordered validate', 'style' => 'text-align:center;', 'enctype' => 'multipart/form-data', 'autcomplete' => 'off'));?>


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
			Please Follow The Instructions For Adding Bulk Teachers:	
		</p>
			<ol>
				<li style="padding: 5px;">At First Click "Generate CSV File".</li>
				<li style="padding: 5px;">Open The Downloaded "bulk_teacher.csv" File. Enter Teacher Details As Written In There And Remember to Start entrying the data from the first rows. Just delete the sample data</li>
				<li style="padding: 5px;">Save The Edited "bulk_teacher.csv" File.</li>
				<li style="padding: 5px;">Click The "Select CSV File" And Choose The File You Just Edited.</li>
				<li style="padding: 5px;">Import That File.</li>
				<li style="padding: 5px;">Hit "Import CSV File".</li>
			</ol>

			<p style="color: #FF5722; font-weight: 500;">
				***This System Keeps Track Of Duplication In Email ID. So Please Enter Unique Email ID For Every Student.	
			</p>

	</div>

    
</div>

<a href="" download="bulk_teacher.csv" style="display: none;" id = "bulk">Download</a>

<?php echo form_close();?>

<script type="text/javascript">

	$("#generate_csv").click(function() {		
			$.ajax({
			  	url: '<?=base_url();?>index.php?admin/download/bulk_teacher.csv',
			  	success: function(response) {
			    	toastr.success("File Generated");
						$("#bulk").attr('href', response);
						jQuery('#bulk')[0].click();
			    	//document.location = response;
			  	}
			});		
	});

</script>
