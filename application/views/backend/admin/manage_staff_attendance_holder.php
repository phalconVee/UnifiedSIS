<div class="col-md-3">
	<div class="form-group">
	<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('name');?></label>
		<select name="staff_id" id="section_id" class="form-control selectboxit">

            <?php 
                if($type_id == 'teacher'){ 

                    $names = $this->db->get('teacher')->result_array();

                    foreach ($names as $row) {
                        echo '<option value="' . $row['teacher_id'] . '">' . $row['name'] . '</option>';
                    }
                }
            ?>

            <?php 
                if($type_id == 'accountant') {
                    $names = $this->db->get('accountant')->result_array();
                    foreach ($names as $row) {
                        echo '<option value="' . $row['accountant_id'] . '">' . $row['name'] . '</option>';
                    }
                }
            ?>

            <?php                
                 if($type_id == 'librarian') {
                    $names = $this->db->get('librarian')->result_array();
                    foreach ($names as $row) {
                        echo '<option value="' . $row['librarian_id'] . '">' . $row['name'] . '</option>';
                    }
                }
            ?>

            <?php
                if($type_id == 'employee') {
                    $names = $this->db->get('employee')->result_array();
                    foreach ($names as $row) {
                        echo '<option value="' . $row['emp_id'] . '">' . $row['name'] . '</option>';
                    }
                }
            ?>
			
		</select>
	</div>
</div>

<script type="text/javascript">
   
    $(document).ready(function () {

        // SelectBoxIt Dropdown replacement
        if ($.isFunction($.fn.selectBoxIt))
        {
            $("select.selectboxit").each(function (i, el)
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