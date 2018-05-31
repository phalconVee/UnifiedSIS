
<div class="col-md-3">
	<div class="form_group">
	<label><?php echo get_phrase('students');?></label>

		<select name="student_id" id="student_id" class="form-control" style="width: 250px;">

	        <option value=""><?php echo get_phrase('select');?></option>
	        
	        <?php 

		        $students = $this->db->get_where('enroll' , array(
	            'class_id' => $class_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description))->result_array();

	        	foreach($students as $row):

	        	$name = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;

	        ?>
	            <option value="<?php echo $row['student_id'];?>">
	                    <?php echo $name;?>
	            </option>
	        <?php
	        endforeach;
	        ?>
	    </select>

		
	</div>
</div>



<script type="text/javascript">
	$(document).ready(function() {
        if($.isFunction($.fn.selectBoxIt))
		{
			$("select.selectboxit").each(function(i, el)
			{
				var $this = $(el),
					opts = {
						showFirstOption: attrDefault($this, 'first-option', true),
						'native': attrDefault($this, 'native', false),
						defaultText: attrDefault($this, 'text', ''),
					};
					
				$this.addClass('visible');
				$this.selectBoxIt(opts);
			});
		}
    });
	
</script>

<script>

$(document).ready(function(){
    show_photo();
    show_student_rollno();
    show_student_name();
    show_student_code();
    show_student_dob();
    show_gender();
    show_address();
})

var times = 1;
$('#student_id').on('click', function(){
    show_photo();
    show_student_rollno();
    show_student_name();    
    show_student_code();
    show_student_dob();
    show_gender();
    show_address();
    
});

function show_photo() {
    //if (times) {
        var select = $('#student_id');
        var value = select[0].value;
        var photo = document.getElementById("photo");
        photo.src = "uploads/student_image/"+value+".jpg";
        times = -1;
    //}
    //times++;
}

function show_student_rollno() {
  
    var select = $('#student_id');
    var value = select[0].value;

    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>index.php?loadidcardajax/show_student_rollno',
        data: "student_id="+value,
        success: function(response) {
            jQuery("#student_rollno").html(response);
        }
    });        
}

function show_student_name() {
  
    var select = $('#student_id');
    var value = select[0].value;

    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>index.php?loadidcardajax/show_student_name',
        data: "student_id="+value,
        success: function(response) {
            jQuery("#student_name").html(response);
        }
    });        
}

function show_student_code() {
  
    var select = $('#student_id');
    var value = select[0].value;

    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>index.php?loadidcardajax/show_student_code',
        data: "student_id="+value,
        success: function(response) {
            jQuery("#student_code").html(response);
        }
    });        
}

function show_student_dob() {
  
    var select = $('#student_id');
    var value = select[0].value;

    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>index.php?loadidcardajax/show_student_dob',
        data: "student_id="+value,
        success: function(response) {
            jQuery("#student_dob").html(response);
        }
    });        
}

function show_gender() {
  
    var select = $('#student_id');
    var value = select[0].value;

    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>index.php?loadidcardajax/show_student_gender',
        data: "student_id="+value,
        success: function(response) {
            jQuery("#student_gender").html(response);
        }
    });        
}

function show_address() {
  
    var select = $('#student_id');
    var value = select[0].value;

    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>index.php?loadidcardajax/show_student_address',
        data: "student_id="+value,
        success: function(response) {
            jQuery("#student_address").html(response);
        }
    });        
}

</script>