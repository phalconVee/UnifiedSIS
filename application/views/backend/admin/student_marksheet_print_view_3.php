<?php
$system_name        =	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
$system_title       =	$this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;
$system_logo        =   '<img src="'.base_url().'"uploads/logo.png"  style="max-height:60px;"/>';
$text_align         =	$this->db->get_where('settings' , array('type'=>'text_align'))->row()->description;
$account_type       =	$this->session->userdata('login_type');
$skin_colour        =   $this->db->get_where('settings' , array('type'=>'skin_colour'))->row()->description;
$active_sms_service =   $this->db->get_where('settings' , array('type'=>'active_sms_service'))->row()->description;
$running_year 		=   $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
$school_title       =   $this->db->get_where('settings_frontend' , array('type'=>'school_title'))->row()->description;
$address            =   $this->db->get_where('settings' , array('type'=>'address'))->row()->description;
$class_name		 	= 	$this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
$exam_name  		= 	$this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name;
$section_name  		= 	$this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
?>

<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left') echo 'rtl';?>">
<head>
    <title>
        <?=$page_title?>
    </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="BIG School ERP" />
    <meta name="description" content="Intellisense Technology Africa" />
    <meta name="author" content="Henry Ugochukwu" />

    <link rel="shortcut icon" href="<?=base_url();?>assets/images/favicon-4.png">

    <link rel="stylesheet" href="<?=base_url();?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/font-icons/entypo/css/entypo.css">
    <link href="<?=base_url();?>assets/theme/css/font-awesome.min.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CRoboto:300,400,500,600,700">

    <link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/neon-core.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/neon-theme.css">

    <script src="<?=base_url();?>assets/js/jquery-1.11.0.min.js"></script>

    <style>
        table #header-tb {
            border: 1px solid #CCC;
            border-collapse: collapse;
        }

        #header-tb td, th {
            border: none;
        }

        table #main-tb tr {
            border: 1px solid #000;
        }

        #main-tb td, th {
            font-weight: 600;
        }

        #main-tb th {
            width: 20px;
            margin-top: -100px;
        }

        #main-tb td {
            height: 35px;
        }

        #rotate {
            -moz-transform: rotate(-90.0deg);  /* FF3.5+ */
            -o-transform: rotate(-90.0deg);  /* Opera 10.5 */
            -webkit-transform: rotate(-90.0deg);  /* Saf3.1+, Chrome */
            filter:  progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083);  /* IE6,IE7 */
            -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)"; /* IE8 */
            height: 150px;
            border: 1px solid #000;
        }

        table #table-3 {
            height: 1px;
        }
    </style>

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-1"></div>

        <div class="col-md-10">

            <table id="header-tb" border="1" style="width: 100%; height: 50px;">
                <tr >
                    <th>
                        <img src="<?php echo base_url();?>image.php/<?=base_url();?>uploads/logo.png?width=100&height=100&cropratio=1:1&image=<?=base_url();?>uploads/logo.png" />
                    </th>
                    <th style="text-align: center;">
                        <h3><?=$system_name?></h3>
                        <span><?=$address?></span>
                        <h4>REPORT SHEET FOR <?=$running_year?> ACADEMIC SESSION</h4>
                    </th>
                    <th>
                        <img src="<?php echo base_url();?>image.php/<?php echo $this->crud_model->get_image_url('student', $student_id);?>?width=100&height=100&cropratio=1:1&image=<?php echo $this->crud_model->get_image_url('student', $student_id);?>" class="img-circle"/>
                    </th>
                </tr>
            </table>

            <table id="header-tb" border="1" style="width: 100%; height: 25px;margin-top: 2px;color: #000;">
                <tr>
                    <td>NAME:</td>
                    <td><strong><?php echo $this->db->get_where('student' , array('student_id' => $student_id))->row()->name;?></strong></td>
                    <td>TERM:</td>
                    <td><strong><?php echo $exam_name;?></strong></td>
                    <td>REG NO:</td>
                    <td><strong><?php echo $this->db->get_where('enroll' , array('student_id' => $student_id))->row()->enroll_code;?></strong></td>
                    <td>SESSION:</td>
                    <td><strong><?=$running_year?></strong></td>
                </tr>
                <tr>
                    <td>CLASS:</td>
                    <td><strong><?php echo get_phrase('class') . ' ' . $class_name;?>&nbsp;<?=$section_name;?></strong></td>
                    <td>NO. IN CLASS:</td>
                    <td><strong><?=$no_in_class?></strong></td>
                    <td>AVERAGE:</td>
                    <td><strong><?=$average;?>%</strong></td>
                    <td>POSITION:</td>
                    <td><strong><?=$position?><sup><?=$super_script;?></sup></strong></td>
                </tr>
            </table>

            <table id="main-tb" border="1" style="width: 100%; margin-top: 28px;color: #000;text-align: center;">

                <thead>
                <tr style="border: 1px solid #000;">
                    <th class="text-center" width="40%">
                        Subject
                    </th>
                    <th class="text-center">1<sup>st</sup> C.A</th>
                    <th class="text-center">2<sup>nd</sup> C.A</th>
                    <th class="text-center">3<sup>rd</sup> C.A</th>
                    <th class="text-center">Total C.A (40%)</th>
                    <th class="text-center">Exam (60%)</th>
                    <th class="text-center">Total (100%)</th>
                    <th class="text-center">Grade </th>
                    <th class="text-center">Remark</th>
                    <th class="text-center">No. of students in subject class </th>
                    <!--<th class="text-center">Highest In Class</th>
                    <th class="text-center">Lowest In Class</th>-->
                </tr>
                </thead>

                <tbody>
                <?php
                $total_marks = 0;
                $total_score = 0;
                $total_marked = 0;
                $CA_1 = 0;
                $CA_2 = 0;
                $CA_3 = 0;
                $total_grade_point = 0;
                $subjects = $this->db->get_where('subject' , array(
                    'class_id' => $class_id , 'year' => $running_year
                ))->result_array();
                foreach ($subjects as $row3):
                ?>
                <tr>
                    <td style="text-align: left"><?php echo $row3['name'];?></td>
                    <td>
                        <?php
                        $other_mark_query = $this->db->get_where('mark' , array(
                            'subject_id' => $row3['subject_id'],
                            'exam_id' => $exam_id,
                            'class_id' => $class_id,
                            'student_id' => $student_id ,
                            'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
                        ));
                        if($other_mark_query->num_rows() > 0){
                            $marks = $other_mark_query->result_array();
                            foreach ($marks as $row4) {
                                $CA_1 =  $row4['other_mark'];
                                if(intval($CA_1) > 0) {
                                    echo $CA_1;
                                }else {
                                    echo '-';
                                }
                                $total_marks += $row4['other_mark'];
                            }
                        } else {
                            $CA_1 = '-';
                            echo $CA_1;
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $first_test_query = $this->db->get_where('mark' , array(
                            'subject_id' => $row3['subject_id'],
                            'exam_id' => $exam_id,
                            'class_id' => $class_id,
                            'student_id' => $student_id ,
                            'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
                        ));
                        if($first_test_query->num_rows() > 0){
                            $marks = $first_test_query->result_array();
                            foreach ($marks as $row4) {
                                $CA_2 = $row4['mark_test_1'];
                                if(intval($CA_2) > 0) {
                                    echo $CA_2;
                                }else{
                                    echo '-';
                                }
                                $total_marks += $row4['mark_test_1'];
                            }
                        } else {
                            $CA_2 = '-';
                            echo $CA_2;
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $second_test_query = $this->db->get_where('mark' , array(
                            'subject_id' => $row3['subject_id'],
                            'exam_id' => $exam_id,
                            'class_id' => $class_id,
                            'student_id' => $student_id ,
                            'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
                        ));
                        if($second_test_query->num_rows() > 0){
                            $marks = $second_test_query->result_array();
                            foreach ($marks as $row4) {
                                $CA_3 = $row4['mark_test_2'];
                                if(intval($CA_3 > 0)) {
                                    echo $CA_3;
                                }else {
                                    echo '-';
                                }
                                $total_marks += $row4['mark_test_2'];
                            }
                        } else {
                            $CA_3 = '-';
                            echo $CA_3;
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        $total_CA = $CA_1 + $CA_2 + $CA_3;
                        if($total_CA > 0){
                            echo $total_CA;
                        }else{
                            echo '-';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        $obtained_mark_query = $this->db->get_where('mark' , array(
                            'subject_id' => $row3['subject_id'],
                            'exam_id' => $exam_id,
                            'class_id' => $class_id,
                            'student_id' => $student_id ,
                            'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
                        ));
                        if($obtained_mark_query->num_rows() > 0){
                            $marks = $obtained_mark_query->result_array();
                            foreach ($marks as $row4) {
                                //echo $row4['mark_obtained'];
                                if(intval($row4['mark_obtained']) > 0){
                                    echo $row4['mark_obtained'];
                                }else{
                                    echo '-';
                                }
                                $total_marks += $row4['mark_obtained'];
                            }
                        }else {
                            echo '-';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        $obtained_total_query = $this->db->get_where('mark' , array(
                            'subject_id' => $row3['subject_id'],
                            'exam_id' => $exam_id,
                            'class_id' => $class_id,
                            'student_id' => $student_id ,
                            'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
                        ));
                        if($obtained_total_query->num_rows() > 0){
                            $marks = $obtained_total_query->result_array();
                            foreach ($marks as $row4) {
                                //echo $row4['total_score'];
                                //$total_marks += $row4['total_score'];
                                $t_score = $row4['total_score'];
                                $total_marked += $row4['total_score'];
                                if($t_score == 0) {
                                    echo '-';
                                }else {
                                    if($t_score >=40)
                                        echo '<span style="color: #4CAF50;">'.$t_score.'</span>';
                                    else
                                        echo '<span style="color: #F44336;">'.$t_score.'</span>';
                                }
                            }
                        }else {
                            echo '-';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        if($obtained_mark_query->num_rows() > 0) {
                            if ($row4['mark_obtained'] >= 0 || $row4['mark_obtained'] != '') {
                                if($row4['total_score'] == 0) {
                                    echo '-';
                                } else {
                                    $grade = $this->crud_model->get_grade($row4['total_score']);
                                    echo $grade['name'];
                                    $total_grade_point += $grade['grade_point'];
                                }
                            }
                        }else {
                            echo '-';
                        }
                        ?>
                    </td>

                    <!--<td></td>-->

                    <td>
                        <?php
                        if($obtained_mark_query->num_rows() > 0) :
                            if($t_score > 0){
                                echo $row4['comment'];
                            }else{
                                echo '-';
                            }
                        else:
                            echo '-';
                        endif;
                        ?>
                    </td>

                    <td>
                        <?php
                        $this->db->where('class_id' , $class_id);
                        $this->db->where('exam_id' , $exam_id);
                        $this->db->where('section_id' , $section_id);
                        $this->db->where('subject_id' , $row3['subject_id']);
                        $this->db->where('year' , $running_year);
                        $this->db->from('mark');
                        $no_in_sub_class = $this->db->count_all_results();
                        echo $no_in_sub_class;
                        ?>
                    </td>

                    <!--<td>
                        <?php echo $this->crud_model->get_highest_marks( $exam_id , $class_id , $row3['subject_id'] ); ?>
                    </td>

                    <td>
                        <?php echo $this->crud_model->get_lowest_marks( $exam_id , $class_id , $row3['subject_id'] ); ?>
                    </td>-->
                </tr>
                <?php endforeach;?>
                </tbody>

            </table>

            <div style="text-align: center;color: #000;font-weight: 500;">

                <?php
                    $fair = array(3, 4);
                    $good = array(4, 5);
                ?>

                <table border="1" id="table-3" style="width: 100%; padding: 8px; height: 12px; margin-top: 5px;">
                    <tr>
                        <th style="width: 50px;"></th>
                        <th>GRADING</th>
                        <th></th>
                        <th>BEHAVIOUR</th>
                        <th><small>Average Rating</small></th>
                        <th>ACTIVITIES</th>
                        <th><small>Average Rating</small></th>
                    </tr>

                    <tbody>
                        <tr>
                            <!--Grading-->
                            <td>95 - 100</td>
                            <td>A+</td>
                            <td>Excellent in Knowledge</td>
                            <!-- Behaviour-->
                            <td>Punctuality</td>
                            <td>
                                <?=
                                ($average > 45) ? $good[array_rand($good)] : $fair[array_rand($fair)];
                                ?>
                            </td>
                            <!--Activities-->
                            <td>Manual Dexterity in Handling Tools</td>
                            <td>
                                <?=
                                ($average > 45) ? $good[array_rand($good)] : $fair[array_rand($fair)];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <!-- Grading -->
                            <td>80 - 94</td>
                            <td>A</td>
                            <td>Excellent</td>
                            <!-- Behaviour-->
                            <td>Attendance in Class</td>
                            <td>
                                <?=
                                ($average > 45) ? $good[array_rand($good)] : $fair[array_rand($fair)];
                                ?>
                            </td>
                            <!--Activities-->
                            <td>Handwriting</td>
                            <td>
                                <?=
                                ($average > 45) ? $good[array_rand($good)] : $fair[array_rand($fair)];
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <!--Grading-->
                            <td>70 -79</td>
                            <td>B</td>
                            <td>Very Good</td>
                            <!-- Behaviour-->
                            <td>Carrying out Assignment</td>
                            <td>
                                <?=
                                ($average > 45) ? $good[array_rand($good)] : $fair[array_rand($fair)];
                                ?>
                            </td>
                            <!--Activities-->
                            <td>Communication</td>
                            <td>
                                <?=
                                ($average > 45) ? $good[array_rand($good)] : $fair[array_rand($fair)];
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <!-- Grading -->
                            <td>60 -69</td>
                            <td>C</td>
                            <td>Good</td>
                            <!-- Behaviour-->
                            <td>Participation in Class Activity</td>
                            <td>
                                <?=
                                ($average > 45) ? $good[array_rand($good)] : $fair[array_rand($fair)];
                                ?>
                            </td>
                            <!--Activities-->
                            <td>Sports & Games</td>
                            <td>
                                <?=
                                ($average > 45) ? $good[array_rand($good)] : $fair[array_rand($fair)];
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <!--Grading-->
                            <td>45 - 59</td>
                            <td>D</td>
                            <td>Fairly Good</td>
                            <!-- Behaviour-->
                            <td>Neatness</td>
                            <td>
                                <?=
                                ($average > 45) ? $good[array_rand($good)] : $fair[array_rand($fair)];
                                ?>
                            </td>
                            <!--Activities-->
                            <td>Drawing & Painting</td>
                            <td>
                                <?=
                                ($average > 45) ? $good[array_rand($good)] : $fair[array_rand($fair)];
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <!-- Grading -->
                            <td>30 - 44</td>
                            <td>E</td>
                            <td>Poor</td>
                            <!-- Behaviour-->
                            <td>Honesty</td>
                            <td>
                                <?=
                                ($average > 45) ? $good[array_rand($good)] : $fair[array_rand($fair)];
                                ?>
                            </td>
                            <!--Activities-->
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <!--Grading-->
                            <td>0 - 29</td>
                            <td>F</td>
                            <td>Very Poor</td>
                            <!-- Behaviour-->
                            <td></td>
                            <td></td>
                            <!--Activities-->
                            <td></td>
                            <td></td>
                        </tr>


                    </tbody>
                </table>

            </div>

            <div class="clearfix">&nbsp;</div>

            <table id="header-tb" border="1" style="width: 100%; height: 25px;margin-top: 5px;color: #000;">
                <tr>
                    <td>Reg No:</td>
                    <td><strong><strong><?php echo $this->db->get_where('enroll' , array('student_id' => $student_id))->row()->enroll_code;?></strong></td>
                    <td>Total Marks Obtained:</td>
                    <td><strong><?=$total_marked;?></strong></td>
                    <td>No. of Subjects Taken:</td>
                    <td><strong><?=$no_of_subjects;?></strong></td>
                    <td>Vacation Date:</td>
                    <td><strong><?php echo $this->db->get_where('exam' , array('name' => $exam_name, 'year' => $running_year))->row()->date;?></strong></td>
                    <td>Resumption Date:</td>
                    <td><strong>N/A</strong></td>
                </tr>
                <!--<tr>
                    <td>Total Marks Obtained:</td>
                    <td><strong><?=$total_marked;?></strong></td>
                    <td>No. of Subjects Taken:</td>
                    <td><strong><?=$no_of_subjects;?></strong></td>
                    <td>Vacation Date:</td>
                    <td><strong><?php echo $this->db->get_where('exam' , array('name' => $exam_name, 'year' => $running_year))->row()->date;?></strong></td>
                    <td>Resumption Date:</td>
                    <td><strong>N/A</strong></td>
                </tr>-->
            </table>


            <table class="table table-bordered" border="1" style="width: 100%; height: 25px;margin-top: 5px;color: #000;">
                <thead>
                <tr>
                    <td class="text-center" style="text-align: center;background-color: #ccc; color: #000;" width="5"><strong>Position:</strong></td>
                    <td class="text-center" width="80" style="color: #000;">&nbsp;
                        <strong><?=$position?><sup><?=$super_script;?></sup>
                    </td>
                </tr>
                <tr>
                    <td class="text-center" style="text-align: center;background-color: #ccc; color: #000;" width="20"><strong>Result Status:</strong></td>
                    <td class="text-center" width="80" style="color: #000;">&nbsp;
                        <?php
                        /*
                        if($pass_status == 'FAILED')
                            echo 'FAILED (NOT PROMOTED)';
                        else
                            echo 'PASSED';*/
                        if(intval($average) < 40) {
                            echo 'FAILED';
                        }else {
                            echo 'PASSED';
                        }
                        ?>
                    </td>
                </tr>
                </thead>
            </table>

            <div class="margin"></div><br>

            <div class="row">
                <div class="col-md-12">

                    <table width="100%" class="table responsive" style="color: #000;">
                        <tr>
                            <td>TEACHER: ______________________________________</td>
                            <td>PRINCIPAL: ______________________________________</td>
                            <td>PARENT: ______________________________________</td>
                        </tr>
                    </table>

                </div>
            </div>

        </div>

        <div class="col-md-1"></div>
    </div>
</div>

</body>

<script src="<?=base_url();?>assets/js/gsap/main-gsap.js"></script>
<script src="<?=base_url();?>assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="<?=base_url();?>assets/js/bootstrap.js"></script>

</html>