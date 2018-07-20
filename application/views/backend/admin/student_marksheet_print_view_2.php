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

    <link rel="stylesheet" href="<?=base_url();?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/font-icons/entypo/css/entypo.css">
    <link href="<?=base_url();?>assets/theme/css/font-awesome.min.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CRoboto:300,400,500,600,700">

    <link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/neon-core.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/neon-theme.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/neon-forms.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/custom.css">

    <?php
    $skin_colour = $this->db->get_where('settings' , array(
        'type' => 'skin_colour'
    ))->row()->description;
    if ($skin_colour != ''):?>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/skins/<?php echo $skin_colour;?>.css">
    <?php endif;?>

    <script src="<?=base_url();?>assets/js/jquery-1.11.0.min.js"></script>


    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="<?=base_url();?>assets/images/favicon-4.png">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/font-icons/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?=base_url();?>assets/js/vertical-timeline/css/component.css">

</head>

    <body class="page-body ">

    <div class="page-container ">
        <div class="main-content">

            <div class="row">
                <div class="col-md-12">
                        <div class="panel panel-primary" data-collapsed="0">

                        <div class="panel-heading" >
                            <div class="panel-title">
                            <div style="text-align: center;">
                                <table width="100" class="table responsive" border="0">
                                    <tr>
                                        <th class="text-center">
                                           <img src="<?php echo base_url();?>image.php/<?=base_url();?>uploads/logo.png?width=100&height=100&cropratio=1:1&image=<?=base_url();?>uploads/logo.png" />
                                        </th>

                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>

                                        <th class="text-center">
                                            <h2><?php echo $system_name;?></h2>
                                            <span><?php echo $address ?></span>
                                            <h4>REPORT SHEET FOR <?=$running_year;?> ACADEMIC SESSION</h4>
                                        </th>

                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>

                                        <th class="text-center">
                                            <img src="<?php echo base_url();?>image.php/<?php echo $this->crud_model->get_image_url('student', $student_id);?>?width=100&height=100&cropratio=1:1&image=<?php echo $this->crud_model->get_image_url('student', $student_id);?>" class="img-circle"/>
                                        </th>
                                    </tr>
                                </table>
                            </div>

                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table width="100%" class="table responsive" border="0" cellspacing="0">
                                        <tr>
                                            <td><h4>NAME: <strong><?php echo $this->db->get_where('student' , array('student_id' => $student_id))->row()->name;?></strong></h4></td>
                                            <td><h4>TERM: <strong><?php echo $exam_name;?></strong></h4></td>
                                            <td><h4>REG NO.: <strong><?php echo $this->db->get_where('enroll' , array('student_id' => $student_id))->row()->enroll_code;?></strong></h4></td>
                                            <td><h4>SESSION: <strong><?=$running_year?></strong></h4></td>
                                        </tr>

                                        <tr>
                                            <td><h4>CLASS: <strong><?php echo get_phrase('class') . ' ' . $class_name;?>&nbsp;<?=$section_name;?></strong></h4></td>
                                            <td><h4>NO. IN CLASS: <strong><?=$no_in_class?></strong></h4></td>
                                            <td><h4>STUDENT AVERAGE: <strong><?=$average;?>%</strong></h4></td>
                                            <td><h4>POSITION: <strong><?=$position?><sup><?=$super_script;?></sup></strong></h4></td>
                                        </tr>
                                    </table>
                                </div>

                            </div>

                            <div class="margin"></div><br>

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered" border="1">
                                        <thead>
                                        <tr>
                                            <th class="text-center" width="10%">Subject</th>
                                            <th>1<sup>st</sup> C.A</th>
                                            <th>2<sup>nd</sup> C.A</th>
                                            <th>3<sup>rd</sup> C.A</th>
                                            <th>Total C.A (40%)</th>
                                            <th>Exam (60%)</th>
                                            <th>Total (100%)</th>
                                            <th>Grade </th>
                                            <!--<th>Rank </th>-->
                                            <th width="8%">Remark</th>
                                            <th>No. of students in<br> subject class </th>
                                            <th>Highest In Class</th>
                                            <th>Lowest In Class</th>
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
                                            <td><?php echo $row3['name'];?></td>
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
                                                        echo $CA_1;
                                                        $total_marks += $row4['other_mark'];
                                                    }
                                                } else {
                                                    $CA_1 = 0;
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
                                                        echo $CA_2;
                                                        $total_marks += $row4['mark_test_1'];
                                                    }
                                                } else {
                                                    $CA_2 = 0;
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
                                                        echo $CA_3;
                                                        $total_marks += $row4['mark_test_2'];
                                                    }
                                                } else {
                                                    $CA_3 = 0;
                                                    echo $CA_3;
                                                }
                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo $CA_1 + $CA_2 + $CA_3;
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
                                                        echo $row4['mark_obtained'];
                                                        $total_marks += $row4['mark_obtained'];
                                                    }
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
                                                            echo 'N/A';
                                                        }else {
                                                            if($t_score >=40)
                                                                echo '<span style="color: #4CAF50;">'.$t_score.'</span>';
                                                            else
                                                                echo '<span style="color: #F44336;">'.$t_score.'</span>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                if($obtained_mark_query->num_rows() > 0) {
                                                    if ($row4['mark_obtained'] >= 0 || $row4['mark_obtained'] != '') {
                                                        if($row4['total_score'] == 0) {
                                                            echo 'N/A';
                                                        } else {
                                                            $grade = $this->crud_model->get_grade($row4['total_score']);
                                                            echo $grade['name'];
                                                            $total_grade_point += $grade['grade_point'];
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>

                                            <!--<td></td>-->

                                            <td><?php if($obtained_mark_query->num_rows() > 0) echo $row4['comment'];?></td>

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

                                            <td>
                                                <?php echo $this->crud_model->get_highest_marks( $exam_id , $class_id , $row3['subject_id'] ); ?>
                                            </td>

                                            <td>
                                                <?php echo $this->crud_model->get_lowest_marks( $exam_id , $class_id , $row3['subject_id'] ); ?>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="margin"></div><br>

                            <div class="row">
                                <div class="col-md-12">

                                    <table width="100%" class="table responsive">
                                        <tr>
                                            <td><h4>Reg No.: <strong><?php echo $this->db->get_where('enroll' , array('student_id' => $student_id))->row()->enroll_code;?></strong></h4></td>
                                            <td><h4>Days Opened: <strong>60</strong></h4></td>
                                            <td><h4>Days Present: <strong><?=$days_present;?></strong></h4></td>
                                            <td><h4>Days Absent: <strong><?=$days_absent;?></strong></h4></td>
                                        </tr>

                                        <tr>
                                            <td><h4>Total Marks Obtained: <strong><?=$total_marked;?></strong></h4></td>
                                            <td><h4>No. of Subjects Taken: <strong><?=$no_of_subjects;?></strong></h4></td>
                                            <td><h4>Vacation Date: <strong><?php echo $this->db->get_where('exam' , array('name' => $exam_name, 'year' => $running_year))->row()->date;?></strong></h4></td>
                                            <td><h4>Resumption Date: <strong>N/A</strong></h4></td>
                                        </tr>
                                    </table>

                                </div>
                            </div>

                            <div class="margin"></div><br>

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered" border="1">
                                        <thead>
                                        <tr>
                                            <td class="text-center" style="text-align: center;background-color: #ccc;" width="20"><strong>Result Status:</strong></td>
                                            <td class="text-center" width="80">&nbsp;
                                                <?php
                                                    //echo $pass_status;
                                                    if($pass_status == 'FAILED')
                                                        echo 'FAILED';
                                                    else
                                                        echo 'PASSED';

                                                ?>
                                            </td>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                            <div class="margin"></div><br>

                            <div class="row">
                                <div class="col-md-12">

                                    <table width="100%" class="table responsive">
                                        <tr>
                                            <td>TEACHER: ______________________________________</td>
                                            <td>PRINCIPAL: ______________________________________</td>
                                            <td>PARENT: ______________________________________</td>
                                        </tr>
                                    </table>

                                </div>
                            </div>

                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script src="<?=base_url();?>assets/js/gsap/main-gsap.js"></script>
    <script src="<?=base_url();?>assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
    <script src="<?=base_url();?>assets/js/bootstrap.js"></script>
    <script src="<?=base_url();?>assets/js/joinable.js"></script>
    <script src="<?=base_url();?>assets/js/resizeable.js"></script>
    <script src="<?=base_url();?>assets/js/neon-api.js"></script>
    <script src="<?=base_url();?>assets/js/neon-custom.js"></script>
    <script src="<?=base_url();?>assets/js/neon-demo.js"></script>

    </body>
</html>








