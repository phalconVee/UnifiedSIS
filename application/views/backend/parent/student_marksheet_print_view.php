<?php
$class_name		 	= 	$this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
$exam_name  		= 	$this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name;
$section_name  		= 	$this->db->get_where('section' , array('section_id' => $class_id))->row()->name;
$section_id  		= 	$this->db->get_where('section' , array('section_id' => $class_id))->row()->section_id;
$system_name        =	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
$address            =   $this->db->get_where('settings' , array('type'=>'address'))->row()->description;
$running_year       =   $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
?>

<div id="print">
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
<script>
    WebFont.load({
        google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
        active: function() {
            sessionStorage.fonts = true;
        }
    });
</script>
<script src="assets/js/jquery-1.11.0.min.js"></script>
<style type="text/css">
    html {
        font-family: "Poppins";
        font-size: 12px;
        line-height: 1.42857143;
    }
    td {
        padding: 1px;

    }
    .column {
        float: left;
        width: 33.33%;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }
</style>

<div class="container">
    <div class="row">
        <div style="float:left;">
            <img src="uploads/logo.png" style="max-height : 60px;">
        </div>

        <div style="margin-left: 50px;">
            <p style="font-size: 18px;"><strong><?php echo $system_name;?></p></strong>
            <p><?php echo $address ?>
            </p>
            <center><b>CONTINUOUS ASSESSMENT FOR SENIOR SECONDARY SCHOOL</b></center>


        </div>

        <div style="float:right; margin-top: -50px; margin-right: 20px;">
            <a href="#" onclick="printDiv();"><img src="assets/images/print.png" alt="print-icon" title="print" id="printbtn"/></a>
        </div>

        <hr>
    </div>

    <div class="row">
        <div style="float:left;">

            <table>
                <tr>
                    <td><strong>STUDENT'S NAME</strong></td>
                    <td><?php echo $this->db->get_where('student' , array('student_id' => $student_id))->row()->name;?></td>
                </tr>

                <tr>
                    <td><strong>ADMISSION NO.</strong></td>
                    <td><?php echo $this->db->get_where('enroll' , array('student_id' => $student_id))->row()->enroll_code;?></td>
                </tr>

                <tr>
                    <td><strong>GENDER</strong></td>
                    <td><?php echo $this->db->get_where('student' , array('student_id' => $student_id))->row()->sex;?></td>
                </tr>
            </table>

        </div>

        <div style="float:right;">

            <table>
                <tr>
                    <td><strong>CLASS</strong></td>
                    <td><?php echo get_phrase('class') . ' ' . $class_name;?>&nbsp;<?=$section_name;?></td>
                </tr>

                <tr>
                    <td><strong>REPORT SHEET FOR</strong></td>
                    <td><?php echo $exam_name;?> <?=$running_year?></td>
                </tr>

                <tr>
                    <td><strong>NEXT TERM BEGINS</strong></td>
                    <td>________________________</td>
                </tr>

            </table>


        </div>
    </div>

</div>

<br>

<h2>(A) AFFECTIVE &amp; PSYCHO MOTOR REPORT</h2>

<div class="row">
    <div class="column">
        <table style="border-collapse:collapse;border: 2px solid #ccc; margin-top: 10px;" border="1">
            <thead>RATES</thead>
            <tr>
                <td>(i) Mental Alertness</td>
                <td style="width:40px;">&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td>(ii) Physical Development</td>
                <td>&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td>(iii) Relationship with peers</td>
                <td>&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td>(iv) Adjustment to school life</td>
                <td>&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td>(v) Neatness</td>
                <td>&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td>(vi) Punctuality</td>
                <td>&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td>(vii) Honesty</td>
                <td>&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td>(vii) Respect</td>
                <td>&nbsp;&nbsp;</td>
            </tr>
        </table>

    </div>

    <div class="column">
        <div>
            <table style="border-collapse:collapse;border: 2px solid #ccc; margin-top: 10px;" border="1">
                <thead>RATES</thead>
                <tr>
                    <td>(i) Hand Writing</td>
                    <td style="width:40px;">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>(ii) Fluency</td>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>(iii) Games</td>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>(iv) Handling of tools/equipment</td>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>(v) Drawing</td>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>(vi) Clubs &amp; Society</td>
                    <td>&nbsp;&nbsp;</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="column">

        <table style="border-collapse:collapse;border: 2px solid #ccc; margin-top: 10px;" border="1">
            <thead>
            <tr>
                <td>KEYS TO RATINGS</td>
                <td>RATES</td>
            </tr>
            </thead>
            <tr>
                <td>(i) Maintains an excellent degree of observed trait</td>
                <td style="width:40px;">&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td>(ii) Maintains a high level degree of observed trait</td>
                <td>&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td>(iii) Maintains acceptable level</td>
                <td>&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td>(iv) Shows minimal regard for trait</td>
                <td>&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td>(v) Has no regard for observable trait</td>
                <td>&nbsp;&nbsp;</td>
            </tr>

        </table>

    </div>
</div>

<br>

<h2>(B) ACADEMIC PERFORMANCE</h2>

<table style="width:100%; border-collapse:collapse;border: 2px solid #ccc; margin-top: 10px;" border="1">

    <thead style="background-color: #ccc;">
    <tr>
        <td style="text-align: center;">SUBJECTS</td>
        <td style="text-align: center;">C.A</td>
        <td style="text-align: center;">1<sub>ST</sub> TEST</td>
        <td style="text-align: center;">2<sub>ND</sub> TEST</td>
        <td style="text-align: center;">EXAM</td>
        <td style="text-align: center;">MEAN SCORE (100%)</td>

        <td style="text-align: center;">GRADE</td>
        <td style="text-align: center;">REMARKS</td>
    </tr>
    </thead>

    <tbody>
    <?php
    $total_marks = 0;
    $total_score = 0;
    $total_grade_point = 0;
    $subjects = $this->db->get_where('subject' , array(
        'class_id' => $class_id , 'year' => $running_year
    ))->result_array();
    foreach ($subjects as $row3):
        ?>
        <tr>
            <td style="text-align: center;"><strong><?php echo $row3['name'];?></strong></td>

            <td style="text-align: center;">
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
                        echo $row4['other_mark'];
                        $total_marks += $row4['other_mark'];
                    }
                }
                ?>
            </td>

            <td style="text-align: center;">
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
                        echo $row4['mark_test_1'];
                        $total_marks += $row4['mark_test_1'];
                    }
                }
                ?>
            </td>

            <td style="text-align: center;">
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
                        echo $row4['mark_test_2'];
                        $total_marks += $row4['mark_test_2'];
                    }
                }
                ?>
            </td>


            <td style="text-align: center;">
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

            <td style="text-align: center;">
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
                        echo $row4['total_score'];
                        $total_marks += $row4['total_score'];
                    }
                }
                ?>
            </td>


            <td style="text-align: center;">
                <strong>
                    <?php
                    if($obtained_mark_query->num_rows() > 0){
                        if ($row4['mark_obtained'] >= 0 || $row4['mark_obtained'] != '') {
                            $grade = $this->crud_model->get_grade($row4['total_score']);
                            echo $grade['name'];
                            $total_grade_point += $grade['grade_point'];
                        }
                    }
                    ?>
                </strong>
            </td>

            <td style="text-align: center;">
                <?php if($obtained_mark_query->num_rows() > 0) echo $row4['comment'];?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>

    <thead >
    <tr>
        <td style="text-align: center;"><strong>CLASS AVERAGE</strong></td>
        <td style="text-align: center;" colspan="8">

            <?php
            $class_average_query = $this->db->get_where('result', array(
                'exam_id' => $exam_id,
                'section_id' => $section_id,
                'class_id' => $class_id,
                'student_id' => $student_id,
                'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
            ));

            if($class_average_query->num_rows() > 0) {
                $average = $class_average_query->row()->average;
                echo $average.'%';
            }
            ?>

        </td>
    </tr>

    <tr>
        <td style="text-align: center;"><strong>POSITION</strong></td>
        <td style="text-align: center;" colspan="8">
            <?php
            $position = $this->crud_model->get_position($class_id, $exam_id, $section_id, $student_id, $running_year);
            echo '<strong>'.$position.'</strong>';
            ?>
        </td>
    </tr>

    <tr>
        <td style="text-align: center;"><strong>NO. IN CLASS</strong></td>
        <td style="text-align: center;" colspan="8">

            <?php

            $this->db->where('class_id' , $class_id);
            $this->db->where('section_id' , $section_id);
            $this->db->from('enroll');
            $no_in_class = $this->db->count_all_results();
            echo $no_in_class;
            ?>

        </td>

    </tr>
    </thead>

</table>

<div>&nbsp;</div>

<!-- BEGIN ATTENDANCE TABLE -->
<table style="width:100%; border-collapse:collapse;border: 2px solid #ccc; margin-top: 10px;" border="1">
    <thead style="background-color: #ccc;">
    <tr>
        <td style="text-align: center;">ATTENDANCE</td>
        <td style="text-align: center;">&nbsp;</td>
    </tr>
    </thead>

    <tbody>
    <tr>
        <td style="text-align: center;"><strong>ABSENT</strong></td>
        <td style="text-align: center;">
            <strong>
                <?php
                $this->db->where('student_id' , $student_id);
                $this->db->where('year' , $running_year);
                $this->db->where('status' , '1');
                $this->db->from('attendance');
                echo $this->db->count_all_results();
                ?>
            </strong>
        </td>
    </tr>

    <tr>
        <td style="text-align: center;"><strong>PRESENT</strong></td>
        <td style="text-align: center;">
            <strong>
                <?php
                $this->db->where('student_id' , $student_id);
                $this->db->where('year' , $running_year);
                $this->db->where('status' , '2');
                $this->db->from('attendance');
                echo $this->db->count_all_results();
                ?>
            </strong>
        </td>
    </tr>
    </tbody>

</table>

<div>&nbsp;</div>

<!--<table style="width:100%; border-collapse:collapse;border: 2px solid #ccc; margin-top: 10px;" border="1">
    
       <thead style="background-color: #ccc;">
        <tr>
            <td style="text-align: center;">GRADING SCALE</td>

        </tr>
        </thead>

        <tbody>
            <?php
$query = $this->db->get('grade')->result_array();
foreach ($query as $val):
    ?>
            <tr style="text-align: center;">
                <td style="border: none;"> <strong><?=$val['name'];?></strong> - <?=$val['mark_from']?>-<?=$val['mark_upto'];?></td>
            </tr>

        <?php endforeach;?>

        </tbody>

    </table>-->

<div>&nbsp;</div>

<!-- PROMOTION -->
<table style="width:100%; border-collapse:collapse;border: 2px solid #ccc; margin-top: 10px;" border="1">

    <thead>
    <tr>
        <td style="text-align: center;background-color: #ccc;" width="20">PROMOTED/RETAINED:</td>
        <td style="text-align: center;" width="80">&nbsp;</td>
    </tr>
    </thead>
</table>

<div>&nbsp;</div>

<!-- COMMENT -->

<table style="width:100%; border-collapse:collapse;border: 2px solid #ccc; margin-top: 10px;" border="1">

    <thead style="background-color: #ccc;">
    <tr>
        <td style="text-align: center;">COMMENTS</td>
    </tr>
    </thead>

    <tbody>
    <tr>
        <td>&nbsp;</td>
    </tr>
    </tbody>

</table>

<div>&nbsp;</div>

<div class="container">
    <div class="row">
        <div style="margin-left: 20px;">
            TEACHER: ______________________________________
        </div>
        <div style="margin-left: 550px;margin-top: -20px;">
            PARENT: ______________________________________
        </div>
    </div>

    <br>

    <div class="row">
        <div style="margin-left: 20px;">
            PRINCIPAL: ______________________________________
        </div>

    </div>

</div>

</div>


<script type="text/javascript">

    jQuery(document).ready(function($)
    {
        var elem = $('#print');
        PrintElem(elem);
        Popup(data);

    });

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title></title>');
        //mywindow.document.write('<link rel="stylesheet" href="assets/css/print.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        //mywindow.document.write('<style>.print{border : 1px;}</style>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }

    function printDiv()
    {

        var link = document.getElementById('printbtn');

        var divToPrint=document.getElementById('print');

        var newWin=window.open('','Print-Window');

        newWin.document.open();

        newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

        link.style.display = 'none'; //or

        newWin.document.close();

        setTimeout(function(){newWin.close();},10);

    }

</script>

