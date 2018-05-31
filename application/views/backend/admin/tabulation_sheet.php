<hr />
<div class="row">
	<div class="col-md-12">
		<?php echo form_open(base_url() . 'index.php?admin/tabulation_sheet');?>
			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label"><?php echo get_phrase('class');?></label>
					<select name="class_id" class="form-control selectboxit" id = 'class_id' onchange="get_class_section(this.value)">
                        <option value=""><?php echo get_phrase('select_a_class');?></option>
                        <?php 
                        $classes = $this->db->get('class')->result_array();
                        foreach($classes as $row):
                        ?>
                            <option value="<?php echo $row['class_id'];?>"
                            	<?php if ($class_id == $row['class_id']) echo 'selected';?>>
                            		<?php echo $row['name'];?>
                            </option>
                        <?php
                        endforeach;
                        ?>
                    </select>
				</div>
			</div>

            <div id="section_holder">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('section');?></label>
                        <select name="" id="" class="form-control selectboxit" disabled="disabled">
                            <option value=""><?php echo get_phrase('select_class_first');?></option>
                        </select>
                    </div>
                </div>
            </div>

			<div class="col-md-3">
				<div class="form-group">
				<label class="control-label"><?php echo get_phrase('exam');?></label>
					<select name="exam_id" class="form-control selectboxit" id = 'exam_id'>
                        <option value=""><?php echo get_phrase('select_an_exam');?></option>
                        <?php 
                        $exams = $this->db->get_where('exam' , array('year' => $running_year))->result_array();
                        foreach($exams as $row):
                        ?>
                            <option value="<?php echo $row['exam_id'];?>"
                            	<?php if ($exam_id == $row['exam_id']) echo 'selected';?>>
                            		<?php echo $row['name'];?>
                            </option>
                        <?php
                        endforeach;
                        ?>
                    </select>
				</div>
			</div>

			<input type="hidden" name="operation" value="selection">
			<div class="col-md-3" style="margin-top: 20px;">
				<button type="submit" id = 'submit' class="btn btn-info"><?php echo get_phrase('view_tabulation_sheet');?></button>
			</div>
		<?php echo form_close();?>
	</div>
</div>

<?php if ($class_id != '' && $exam_id != '' && $section_id != ''):?>
<br>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4" style="text-align: center;">
		<div class="tile-stats tile-gray">
		<div class="icon"><i class="entypo-docs"></i></div>
			<h3 style="color: #696969;">
				<?php
					$exam_name  = $this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name; 
					$class_name = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name; 
					$section_name = $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
					echo get_phrase('tabulation_sheet');
				?>
			</h3>
			<h4 style="color: #696969;">
				<?php echo get_phrase('class') . ' ' . $class_name;?> <?php echo $section_name; ?> : <?php echo $exam_name;?>
			</h4>
		</div>
	</div>
	<div class="col-md-4"></div>
</div>


<hr />

<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>

				<td style="text-align: center;">
					<?php echo get_phrase('students');?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('subjects');?> <i class="entypo-right-thin"></i>
				</td>

				<?php 
					$subjects = $this->db->get_where('subject' , array('class_id' => $class_id , 'year' => $running_year))->result_array();
					foreach($subjects as $row):
				?>
					<td style="text-align: center;"><?php echo $row['name'];?></td>
				<?php endforeach;?>

				<td style="text-align: center;"><?php echo get_phrase('average');?></td>
				<td style="text-align: center;"><?php echo get_phrase('position');?></td>
				<td style="text-align: center;">&nbsp;</td>

				</tr>
			</thead>

			<tbody>

			<?php
				
				$students = $this->db->get_where('enroll' , array('class_id' => $class_id , 'section_id' => $section_id, 'year' => $running_year))->result_array();
				foreach($students as $row):
			?>

				<tr>

					<td style="text-align: center;">
						<?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;?>
					</td>

				<?php
					$total_marks = 0;
					$total_grade_point = 0;  
					foreach($subjects as $row2):
				?>

					<td style="text-align: center;">
						<?php 
							$obtained_mark_query = 	$this->db->get_where('mark' , array(
													'class_id' => $class_id , 
														'exam_id' => $exam_id , 
															'subject_id' => $row2['subject_id'] , 
																'student_id' => $row['student_id'],
																	'year' => $running_year
												));
							
							if ( $obtained_mark_query->num_rows() > 0) {
								$total_score = $obtained_mark_query->row()->total_score;
                                if($total_score == '0'){
                                    echo 'N/A';
                                }else
                                    if ($total_score >= 0 && $total_score != '') {
                                        $grade = $this->crud_model->get_grade($total_score);
                                        echo $grade['name'];
                                        $total_grade_point += $grade['grade_point'];
                                        $stu_grade = $grade['grade_point'];
                                    }

                                $total_marks += $total_score;
							}

						?>
					</td>
				<?php endforeach;?>

				<td style="text-align: center;">
					<?php

                    $class_array = array('14', '15');   //class_id for SS2 and SS3

                    if(in_array($class_id, $class_array)) {

                        $this->db->where('class_id' , $class_id);
                        $this->db->where('exam_id' , $exam_id);
                        $this->db->where('section_id' , $section_id);
                        $this->db->where('student_id' , $row['student_id']);
                        $this->db->where('year' , $running_year);
                        $this->db->where('total_score != ',0, FALSE);
                        $this->db->from('mark');
                        $number_of_subjects = $this->db->count_all_results();

                    } else {
                        $this->db->where('class_id' , $class_id);
                        $this->db->where('year' , $running_year);
                        $this->db->from('subject');
                        $number_of_subjects = $this->db->count_all_results();
                    }

                   if($number_of_subjects > 0) {
                     $average = ($total_marks / $number_of_subjects);
                        echo number_format($average, 2);
                    } else {
                        $average = '0.00';
                       echo $average;
                    }
					?> %
				</td>

                <td style="text-align: center;">
                    <?php
                    $position = $this->crud_model->get_position($class_id, $exam_id, $section_id, $row['student_id'], $running_year);
                    echo $position;
                    ?>
                </td>

                <td style="text-align: center;">
                    <a href="<?php echo base_url();?>index.php?admin/student_marksheet_print_view/<?php echo $row['student_id'];?>/<?php echo $exam_id;?>" target="_blank" class="btn btn-sm btn-primary">Print Result</a>
                </td>

				</tr>

			<?php endforeach;?>

			</tbody>
		</table>

		<center>
			<a href="<?php echo base_url();?>index.php?admin/tabulation_sheet_print_view/<?php echo $class_id;?>/<?php echo $exam_id;?>/<?php echo $section_id;?>"
				class="btn btn-info" target="_blank">
				<?php echo get_phrase('print_tabulation_sheet');?>
			</a>
		</center>

	</div>
</div>
<?php endif;?>

<script type="text/javascript">
	var class_id = '';
	var exam_id  = '';
	jQuery(document).ready(function($) {
		$('#submit').attr('disabled', 'disabled');
	});
	function check_validation(){
		if(class_id !== '' && exam_id !== ''){
			$('#submit').removeAttr('disabled');
		}
		else{
			$('#submit').attr('disabled', 'disabled');	
		}
	}
	$('#class_id').change(function() {
		class_id = $('#class_id').val();
		check_validation();
	});
	$('#exam_id').change(function() {
		exam_id = $('#exam_id').val();
		check_validation();
	});

    function get_class_section(class_id) {
        if (class_id !== '') {
            $.ajax({
                url: '<?php echo base_url();?>index.php?admin/submit_get_section/' + class_id ,
                success: function(response)
                {
                    jQuery('#section_holder').html(response);
                }
            });
            $('#submit').removeAttr('disabled');
        }
        else{
            $('#submit').attr('disabled', 'disabled');
        }
    }
</script>