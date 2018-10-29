<center>
	<button class="btn btn-primary">
		<i class="entypo-user"></i> <?php echo $this->crud_model->get_type_name_by_id('student' , $param2);?>
	</button>
</center>
<hr />
<?php
	$running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; 
    $student_info = $this->crud_model->get_student_info($param2);
    $exams         = $this->crud_model->get_exams();
    foreach ($student_info as $row1):
    foreach ($exams as $row2):
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-shadow" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title"><?php echo $row2['name'];?></div>
            </div>
            <div class="panel-body">
               
                <table class="table table-bordered">
                   <thead>
                   <tr>
                       <td style="text-align: center;">Subject</td>
                       <td style="text-align: center;">1st CA</td>
                       <td style="text-align: center;">2nd CA</td>
                       <td style="text-align: center;">3rd CA</td>
                       <td style="text-align: center;">Exam</td>
                       <td style="text-align: center;">Total</td>
                       <td style="text-align: center;">Grade</td>

                   </tr>
                </thead>
                <tbody>
                    <?php
                        $total_score = 0;
                        $total_marks = 0;
                        $total_grade_point = 0;
                        $subjects = $this->db->get_where('subject' , array(
                            'class_id' => $param3 , 'year' => $running_year
                        ))->result_array();
                        foreach ($subjects as $row3):
                    ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $row3['name'];?></td>

                            <td style="text-align: center;">
                                <?php
                                $other_mark_query = $this->db->get_where('mark' , array(
                                    'subject_id' => $row3['subject_id'],
                                    'exam_id' => $row2['exam_id'],
                                    'class_id' => $param3,
                                    'student_id' => $param2,
                                    'year' => $running_year));
                                if ( $other_mark_query->num_rows() > 0) {
                                    $marks = $other_mark_query->result_array();
                                    foreach ($marks as $row4) {
                                        echo $row4['other_mark'];
                                        //$other_mark += $row4['other_mark'];
                                    }
                                }
                                ?>
                            </td>

                            <td style="text-align: center;">
                                <?php
                                $first_test_query = $this->db->get_where('mark' , array(
                                    'subject_id' => $row3['subject_id'],
                                    'exam_id' => $row2['exam_id'],
                                    'class_id' => $param3,
                                    'student_id' => $param2 ,
                                    'year' => $running_year));
                                if ( $first_test_query->num_rows() > 0) {
                                    $marks = $first_test_query->result_array();
                                    foreach ($marks as $row4) {
                                        echo $row4['mark_test_1'];
                                        //$mark_test_1 += $row4['mark_test_1'];
                                    }
                                }
                                ?>
                            </td>

                            <td style="text-align: center;">
                                <?php
                                $second_test_query = $this->db->get_where('mark' , array(
                                    'subject_id' => $row3['subject_id'],
                                    'exam_id' => $row2['exam_id'],
                                    'class_id' => $param3,
                                    'student_id' => $param2 ,
                                    'year' => $running_year));
                                if ( $second_test_query->num_rows() > 0) {
                                    $marks = $second_test_query->result_array();
                                    foreach ($marks as $row4) {
                                        echo $row4['mark_test_2'];
                                        //$mark_test_2 += $row4['mark_test_2'];
                                    }
                                }
                                ?>
                            </td>

                            <td style="text-align: center;">
                                <?php
                                $obtained_mark_query = $this->db->get_where('mark' , array(
                                    'subject_id' => $row3['subject_id'],
                                    'exam_id' => $row2['exam_id'],
                                    'class_id' => $param3,
                                    'student_id' => $param2 ,
                                    'year' => $running_year));
                                if ( $obtained_mark_query->num_rows() > 0) {
                                    $marks = $obtained_mark_query->result_array();
                                    foreach ($marks as $row4) {
                                        echo $row4['mark_obtained'];
                                        $total_marks += $row4['mark_obtained'];
                                    }
                                }
                                ?>
                            </td>

                            <td style="text-align: center;">
                                <?php
                                $obtained_total_query = $this->db->get_where('mark' , array(
                                    'subject_id' => $row3['subject_id'],
                                    'exam_id' => $row2['exam_id'],
                                    'class_id' => $param3,
                                    'student_id' => $param2,
                                    'year' => $running_year));
                                if ( $obtained_total_query->num_rows() > 0) {
                                    $marks = $obtained_total_query->result_array();
                                    foreach ($marks as $row4) {
                                        $t_score = $row4['total_score'];
                                        $total_score += $row4['total_score'];
                                        if($t_score == 0) {
                                            echo 'N/A';
                                        }else {
                                            echo $t_score;
                                        }
                                    }
                                }
                                ?>
                            </td>

                            <td style="text-align: center;">
                                <?php
                                if($obtained_mark_query->num_rows() > 0) {
                                    if ($row4['mark_obtained'] >= 0 || $row4['mark_obtained'] != '') {
                                        if($row4['total_score'] == 0) {
                                            echo 'N/A';
                                        }else {
                                            $grade = $this->crud_model->get_grade($row4['total_score']);
                                            echo $grade['name'];
                                            $total_grade_point += $grade['grade_point'];
                                        }
                                    }
                                }
                                ?>
                            </td>

                        </tr>
                    <?php endforeach;?>
                </tbody>
                </table>

                <hr />

                <?php echo get_phrase('total_marks');?> : <?php echo $total_score;?>
                <br>
                <?php echo get_phrase('class_average');?> :
                <?php

                $class_array = array('13', '14', '15');   //class_id for SS1, SS2 and SS3

                if(in_array($param3, $class_array)) {

                    $this->db->where('class_id' , $param3);
                    $this->db->where('exam_id' , $row2['exam_id']);
                    //$this->db->where('section_id' , $section_id);
                    $this->db->where('student_id' , $row1['student_id']);
                    $this->db->where('year' , $running_year);
                    $this->db->where('total_score != ', 0, FALSE);
                    $this->db->from('mark');
                    $number_of_subjects = $this->db->count_all_results();

                } else {

                    $this->db->where('class_id' , $param3);
                    $this->db->where('year' , $running_year);
                    $this->db->from('subject');
                    $number_of_subjects = $this->db->count_all_results();
                }

                if($total_score == 0 || $total_score == '') {
                    echo '0';
                } else {
                    //echo ($total_grade_point / $number_of_subjects);
                    echo number_format($total_score / $number_of_subjects, 2) .'%';
                }
                ?>
            </div>
        </div>  
    </div>
</div>
<?php
    endforeach;
        endforeach;
?>