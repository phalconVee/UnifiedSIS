<?php
$class_name		 	= 	$this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
$exam_name  		= 	$this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name;
$section_name  		= 	$this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
$subject_name  		= 	$this->db->get_where('subject' , array('subject_id' => $subject_id))->row()->name;
//$section_id  		= 	$this->db->get_where('section' , array('class_id' => $class_id))->row()->section_id;
$system_name        =	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
$running_year       =	$this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
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
    <style type="text/css">
        html {
            font-family: "Poppins";
            font-size: 12px;
            line-height: 1.42857143;
        }
        td {
            padding: 3px;

        }
    </style>

    <center>
        <img src="uploads/logo.png" style="max-height : 60px;"><br>
        <h3 style="font-weight: 100;"><?php echo $system_name;?></h3>

        <h3 style="color: #696969;"><?php echo get_phrase('mark_sheet_for');?> <?php echo $exam_name;?></h3>

        <h4 style="color: #696969;">
            <?php echo get_phrase('class');?> <?php echo $class_name;?> :
            <?php echo get_phrase('section');?> <?php echo $section_name;?>
        </h4>

        <h4 style="color: #696969;">
            <?php echo get_phrase('subject');?> : <?php echo $subject_name;?>
        </h4>


    </center>

        <table style="width:100%; border-collapse:collapse;border: 2px solid #000; margin-top: 10px;" border="1">
            <thead>
            <tr>
                <th>#</th>
                <th><?php echo get_phrase('admission_no');?></th>
                <th><?php echo get_phrase('name');?></th>
                <th><?php echo get_phrase('1st CA');?></th>
                <th><?php echo get_phrase('2nd CA');?></th>
                <th><?php echo get_phrase('3rd CA');?></th>
                <th><?php echo get_phrase('exam');?></th>
                <th><?php echo get_phrase('total');?></th>
                <th><?php echo get_phrase('comment');?></th>
            </tr>
            </thead>
            <tbody>

            <?php
            $count = 1;

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
                        <?php echo $row['name'];?>
                    </td>

                    <td>
                        <?php if($row['other_mark'] == 0){ echo ''; }else { echo $row['other_mark']; };?>
                    </td>

                    <td>
                        <?php if($row['mark_test_1'] == 0) { echo ''; } else{ echo $row['mark_test_1']; };?>
                    </td>
                    <td>
                        <?php if($row['mark_test_2'] == 0) { echo ''; } else{ echo $row['mark_test_2']; };?>
                    </td>

                    <td>
                        <?php if($row['mark_obtained'] == 0) { echo ''; } else{ echo $row['mark_obtained']; };?>
                    </td>

                    <td>
                        <?php if($row['total_score'] == 0) { echo ''; } else { echo $row['total_score']; };?>
                    </td>

                    <td>
                        <?php if(empty($row['comment'])) { echo ''; }else { echo $row['comment']; };?>
                    </td>
                </tr>
            <?php endforeach;?>


            </tbody>
    </table>
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
</script>