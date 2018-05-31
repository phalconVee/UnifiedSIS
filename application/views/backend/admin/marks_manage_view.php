<hr />
<?php echo form_open(base_url() . 'index.php?admin/marks_selector');?>
<div class="row">

	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam');?></label>
			<select name="exam_id" class="form-control selectboxit" required>
				<?php
					$exams = $this->db->get_where('exam' , array('year' => $running_year))->result_array();
					foreach($exams as $row):
				?>
				<option value="<?php echo $row['exam_id'];?>"
					<?php if($exam_id == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
			<select name="class_id" class="form-control selectboxit" onchange="get_class_subject(this.value)">
				<option value=""><?php echo get_phrase('select_class');?></option>
				<?php
					$classes = $this->db->get('class')->result_array();
					foreach($classes as $row):
				?>
				<option value="<?php echo $row['class_id'];?>"
					<?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>

	<div id="subject_holder">
		<div class="col-md-2">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('section');?></label>
				<select name="section_id" id="section_id" class="form-control selectboxit">
					<?php 
						$sections = $this->db->get_where('section' , array(
							'class_id' => $class_id 
						))->result_array();
						foreach($sections as $row):
					?>
					<option value="<?php echo $row['section_id'];?>" 
						<?php if($section_id == $row['section_id']) echo 'selected';?>>
							<?php echo $row['name'];?>
					</option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject');?></label>
				<select name="subject_id" id="subject_id" class="form-control selectboxit">
					<?php 
						$subjects = $this->db->get_where('subject' , array(
							'class_id' => $class_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
						))->result_array();
						foreach($subjects as $row):
					?>
					<option value="<?php echo $row['subject_id'];?>"
						<?php if($subject_id == $row['subject_id']) echo 'selected';?>>
							<?php echo $row['name'];?>
					</option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="col-md-2" style="margin-top: 20px;">
			<center>
				<button type="submit" class="btn btn-info"><?php echo get_phrase('manage_marks');?></button>
			</center>
		</div>
	</div>

</div>
<?php echo form_close();?>

<hr />
<div class="row" style="text-align: center;">
	<div class="col-sm-4"></div>
	<div class="col-sm-4">
		<div class="tile-stats tile-gray">
			<div class="icon"><i class="entypo-chart-bar"></i></div>
			
			<h3 style="color: #696969;"><?php echo get_phrase('marks_for');?> <?php echo $this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name;?></h3>
			<h4 style="color: #696969;">
				<?php echo get_phrase('class');?> <?php echo $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;?> : 
				<?php echo get_phrase('section');?> <?php echo $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;?> 
			</h4>
			<h4 style="color: #696969;">
				<?php echo get_phrase('subject');?> : <?php echo $this->db->get_where('subject' , array('subject_id' => $subject_id))->row()->name;?>
			</h4>
		</div>
	</div>
	<div class="col-sm-4"></div>
</div>
<div class="row">

	<div class="col-md-12">

		<?php echo form_open(base_url() . 'index.php?admin/marks_update/'.$exam_id.'/'.$class_id.'/'.$section_id.'/'.$subject_id);?>
			<table class="table table-bordered">
				<thead>
                <?php $sub_array = array('1', '2', '3', '4', '5', '6', '7', '8', '9');?>
                <?php if(in_array($class_id, $sub_array)) { ?>
					<tr>
						<th>#</th>
						<th><?php echo get_phrase('admission_no');?></th>
						<th><?php echo get_phrase('name');?></th>
                        <th><?php echo get_phrase('1st CA');?>[Max: 20]</th>
                        <th><?php echo get_phrase('2nd CA');?>[Max: 20]</th>
                        <th><?php echo get_phrase('3rd CA');?>[Max: 10]</th>
						<th><?php echo get_phrase('exam');?>[Max: 50]</th>
                        <th><?php echo get_phrase('total');?></th>
						<th><?php echo get_phrase('comment');?></th>
					</tr>
                <?php }else { ?>
                    <tr>
                        <th>#</th>
                        <th><?php echo get_phrase('admission_no');?></th>
                        <th><?php echo get_phrase('name');?></th>
                        <th><?php echo get_phrase('1st CA');?>[Max: 15]</th>
                        <th><?php echo get_phrase('2nd CA');?>[Max: 15]</th>
                        <th><?php echo get_phrase('3rd CA');?>[Max: 10]</th>
                        <th><?php echo get_phrase('exam');?>[Max: 60]</th>
                        <th><?php echo get_phrase('total');?></th>
                        <th><?php echo get_phrase('comment');?></th>
                    </tr>
                <?php } ?>

				</thead>
				<tbody>
				<?php
					$count = 1;
					/*$marks_of_students = $this->db->get_where('mark' , array(
						'class_id' => $class_id, 
							'section_id' => $section_id ,
								'year' => $running_year,
									'subject_id' => $subject_id,
										'exam_id' => $exam_id
					))->result_array();*/
                    $this->db->select('mark.*, student.name, student.student_id');
                        $this->db->from('mark');
                            $this->db->where('mark.class_id', $class_id);
                                $this->db->where('mark.section_id', $section_id);
                                    $this->db->where('mark.year', $running_year);
                                        $this->db->where('mark.subject_id', $subject_id);
                                            $this->db->where('mark.exam_id', $exam_id);
                                                $this->db->join('student', 'mark.student_id = student.student_id');
                                                    $this->db->order_by('student.name', 'ASC');
                                                        $marks_of_students = $this->db->get()->result_array();

					foreach($marks_of_students as $row):

				?>
					<tr>
						<td><?php echo $count++;?></td>
						<td>
							<?php echo $this->db->get_where('enroll', array('student_id'=>$row['student_id']))->row()->enroll_code;?>
						</td>
						<td>
							<?php //echo $this->db->order_by('name', 'DESC')->get_where('student' , array('student_id' => $row['student_id']))->row()->name;?>
							<?php echo $row['name'];?>
						</td>

                        <td>
                            <input type="text" class="form-control" id="other_mark_<?php echo $row['mark_id'];?>" name="other_mark_<?php echo $row['mark_id'];?>"
                                   value="<?php echo $row['other_mark'];?>" onchange="check_input('<?=$row['mark_id'];?>')">
                        </td>

                        <td>
                            <input type="text" class="form-control" id="mark_test_1_<?php echo $row['mark_id'];?>" name="mark_test_1_<?php echo $row['mark_id'];?>"
                                   value="<?php echo $row['mark_test_1'];?>" onchange="check_input('<?=$row['mark_id'];?>')">
                        </td>
                        <td>
                            <input type="text" class="form-control" id="mark_test_2_<?php echo $row['mark_id'];?>" name="mark_test_2_<?php echo $row['mark_id'];?>"
                                   value="<?php echo $row['mark_test_2'];?>" onchange="check_input('<?=$row['mark_id'];?>')">
                        </td>

						<td>
							<input type="text" class="form-control" id="marks_obtained_<?php echo $row['mark_id'];?>" name="marks_obtained_<?php echo $row['mark_id'];?>"
								value="<?php echo $row['mark_obtained'];?>" onchange="check_input('<?=$row['mark_id'];?>')">
						</td>

                        <td>
                            <input type="text" class="form-control" id="total_score_<?php echo $row['mark_id'];?>" name="total_score_<?php echo $row['mark_id'];?>"
                                   value="<?php echo $row['total_score'];?>" readonly>
                        </td>

						<td>
							<input type="text" class="form-control" id="comment_<?php echo $row['mark_id'];?>" name="comment_<?php echo $row['mark_id'];?>"
								value="<?php echo $row['comment'];?>">
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>

			</table>

		<center>
            <a href="<?php echo base_url();?>index.php?admin/mark_sheet_print_view/<?php echo $class_id;?>/<?php echo $exam_id;?>/<?php echo $section_id;?>/<?php echo $subject_id;?>"
               class="btn btn-primary" target="_blank">
                <?php echo get_phrase('print_mark_sheet');?>
            </a>

			<button type="submit" class="btn btn-success" id="submit_button">
				<i class="entypo-check"></i> <?php echo get_phrase('save_changes');?>
			</button>
		</center>

		<?php echo form_close();?>
		
	</div>
	<!--<div class="col-md-2"></div>-->
</div>





<script type="text/javascript">

    $(document).ready(function () {

        $("#target").keyup(function() {
            alert( "Handler for .keyup() called." );
        });

    });

    function get_class_subject(class_id) {
        if (class_id !== '') {
        $.ajax({
                url: '<?php echo base_url();?>index.php?admin/marks_get_subject/' + class_id ,
                success: function(response)
                {
                    jQuery('#subject_holder').html(response);
                }
            });
          }
	}

    function check_input(id) {

        var target1 =  $("#other_mark_" + id).val();
        var target2 =  $("#mark_test_1_" + id).val();
        var target3 =  $("#mark_test_2_" + id).val();
        var target4 =  $("#marks_obtained_" + id).val();

        <?php if(in_array($class_id, $sub_array)) { ?>

        if(target1.length !== 0 && (target1 > 20 || !($.isNumeric(target1)))) {
            toastr.error('Value in 1st CA must not be greater than 20', 'Invalid Input', {timeOut: 5000});
            $("#other_mark_" + id).css("border-color","red");
            $("#submit_button").attr('disabled', true);
            return;
        }else if (target1.length === 0) {
            //toastr.error('You did not input a value in 1st CA cell', 'Please Input a Value', {timeOut: 5000});
            $("#other_mark_" + id).css("border-color","red");
            $("#submit_button").attr('disabled', true);
            return;
        } else {
            $("#other_mark_" + id).css("border-color","#bbb");
            $("#submit_button").attr('disabled', false);
        }

        if(target2.length !== 0 && (target2 > 20 || !($.isNumeric(target2)))) {
            toastr.error('Value in 2nd CA must not be greater than 20', 'Invalid Input', {timeOut: 5000});
            $("#mark_test_1_" + id).css("border-color","red");
            $("#submit_button").attr('disabled', true);
            return;
        }else if (target2.length === 0) {
            //toastr.error('You did not input a value in 2nd CA cell', 'Please Input a Value', {timeOut: 5000});
            $("#mark_test_1_" + id).css("border-color","red");
            $("#submit_button").attr('disabled', true);
            return;
        } else {
            $("#mark_test_1_" + id).css("border-color","#bbb");
            $("#submit_button").attr('disabled', false);
        }

        if(target3.length !== 0 && (target3 > 10 || !($.isNumeric(target3)))) {
            toastr.error('Value in 3rd CA must not be greater than 10', 'Invalid Input', {timeOut: 5000});
            $("#mark_test_2_" + id).css("border-color","red");
            $("#submit_button").attr('disabled', true);
            return;
        }else if (target3.length === 0) {
            //toastr.error('You did not input a value in 3rd CA cell', 'Please Input a Value', {timeOut: 5000});
            $("#mark_test_2_" + id).css("border-color","red");
            $("#submit_button").attr('disabled', true);
            return;
        } else {
            $("#mark_test_2_" + id).css("border-color","#bbb");
            $("#submit_button").attr('disabled', false);
        }

        if(target4.length !== 0 &&  (target4 > 50 || !($.isNumeric(target4)))) {
            toastr.error('Value in Exam must not be greater than 50', 'Invalid Input', {timeOut: 5000});
            $("#marks_obtained_" + id).css("border-color","red");
            $("#submit_button").attr('disabled', true);
            //return;
        }else if (target4.length === 0) {
            //toastr.error('You did not input a value in 4th CA cell', 'Please Input a Value', {timeOut: 5000});
            $("#marks_obtained_" + id).css("border-color","red");
            $("#submit_button").attr('disabled', true);
            //return;
        }else {
            $("#marks_obtained_" + id).css("border-color","#bbb");
            $("#submit_button").attr('disabled', false);
        }

    <?php } else { ?>
        if(target1.length !== 0 && (target1 > 15 || !($.isNumeric(target1)))) {
            toastr.error('Value in 1st CA must not be greater than 15', 'Invalid Input', {timeOut: 5000});
            $("#other_mark_" + id).css("border-color","red");
            $("#submit_button").attr('disabled', true);
            return;
        }else if (target1.length === 0) {
            //toastr.error('You did not input a value in 1st CA cell', 'Please Input a Value', {timeOut: 5000});
            $("#other_mark_" + id).css("border-color","red");
            $("#submit_button").attr('disabled', true);
            return;
        } else {
            $("#other_mark_" + id).css("border-color","#bbb");
            $("#submit_button").attr('disabled', false);
        }

        if(target2.length !== 0 && (target2 > 15 || !($.isNumeric(target2)))) {
            toastr.error('Value in 2nd CA must not be greater than 15', 'Invalid Input', {timeOut: 5000});
            $("#mark_test_1_" + id).css("border-color","red");
            $("#submit_button").attr('disabled', true);
            return;
        }else if (target2.length === 0) {
            //toastr.error('You did not input a value in 2nd CA cell', 'Please Input a Value', {timeOut: 5000});
            $("#mark_test_1_" + id).css("border-color","red");
            $("#submit_button").attr('disabled', true);
            return;
        } else {
            $("#mark_test_1_" + id).css("border-color","#bbb");
            $("#submit_button").attr('disabled', false);
        }

        if(target3.length !== 0 && (target3 > 10 || !($.isNumeric(target3)))) {
            toastr.error('Value in 3rd CA must not be greater than 10', 'Invalid Input', {timeOut: 5000});
            $("#mark_test_2_" + id).css("border-color","red");
            $("#submit_button").attr('disabled', true);
            return;
        }else if (target3.length === 0) {
            //toastr.error('You did not input a value in 3rd CA cell', 'Please Input a Value', {timeOut: 5000});
            $("#mark_test_2_" + id).css("border-color","red");
            $("#submit_button").attr('disabled', true);
            return;
        } else {
            $("#mark_test_2_" + id).css("border-color","#bbb");
            $("#submit_button").attr('disabled', false);
        }

        if(target4.length !== 0 &&  (target4 > 60 || !($.isNumeric(target4)))) {
            toastr.error('Value in Exam must not be greater than 60', 'Invalid Input', {timeOut: 5000});
            $("#marks_obtained_" + id).css("border-color","red");
            $("#submit_button").attr('disabled', true);
            //return;
        }else if (target4.length === 0) {
            //toastr.error('You did not input a value in 4th CA cell', 'Please Input a Value', {timeOut: 5000});
            $("#marks_obtained_" + id).css("border-color","red");
            $("#submit_button").attr('disabled', true);
            //return;
        }else {
            $("#marks_obtained_" + id).css("border-color","#bbb");
            $("#submit_button").attr('disabled', false);
        }

    <?php } ?>

    }

</script>